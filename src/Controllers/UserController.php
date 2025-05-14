<?php

namespace Controllers;

use Request\EditProfileRequest;
use Request\RegistrateRequest;
use Request\LoginRequest;
use Model\User;

class UserController extends BaseController
{
    private \Services\CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new \Services\CartService();
    }

    public function getRegistrate(array $errors = null)
    {
        require_once '../Views/registration_form.php';
    }

    public function getLogin(array $errors = null)
    {
        if ($this->authService->check()!==false) { // если user залогинен - перейдет на профиль
            header("Location: /profile");
            exit;
        }
        require_once '../Views/login_form.php';
    }

    public function getProfile()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        } else {
            $sessionId = $this->authService->getCurrentUser();
            $user=User::getBySessionId($sessionId->getId());
            $sum = $this->cartService->getSum();
            $cartQuantity=$this->cartService->getQuantity();


            require_once '../Views/profile.php';
        }

    }

    public function getEditProfile(array $errors=null)
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
        $sum = $this->cartService->getSum();
        $cartQuantity=$this->cartService->getQuantity();

        require_once '../Views/edit_profile.php';
    }


    public function registrate(RegistrateRequest $request)
    {
        $errors = $request->validateUser();

        if (empty($errors)) {

            $hashedPassword = password_hash($request->getPassword(), PASSWORD_DEFAULT);

            User::insert( $request->getName(), $request->getEmail(), $hashedPassword);

            echo "\n Пользователь зарегистрирован";
        }
        $this->getRegistrate($errors);
    }

    public function login(LoginRequest $request)
    {
        $errors = $request->validateLogin();

        if (empty($errors)) {

            $dto = new \DTO\AuthDTO($_POST['email'], $_POST['password']);

           $result = $this->authService->auth($dto);

            if ($result===true) {
                header("Location: /catalog");
                exit;

            } else {
                $errors['username'] = 'username or password not valid';
            }
        }

        $this->getLogin($errors);
    }

    public function editProfile(EditProfileRequest $request)
    {
        $errors = $request->validationEditProfile();

        if (empty($errors)) {
            $userId = $this->authService->getCurrentUser();

            $username = $request->getName();
            $email = $request->getEmail();
            $image_url = $request->getAvatar();

            if ($request->getPassword() !== "") { //проверка пароля на пустоту
                $password = $request->getPassword();
                $password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $password = "";
            }

            $user= User::getById($userId->getId());

            if ($user->getId() !== $username) {
                User::updateNameById($username, $userId->getId());
            }

            if ($user->getEmail() !== $email) {
                User::updateEmailById($email, $userId->getId());
            }

            if ($user->getPassword() !== $password && $password !== "") {
                User::updatePasswordById($password, $userId->getId());
            }

            if ($user->getAvatar() !== $image_url && $image_url !== "") {
                User::updateAvatarById($image_url, $userId->getId());
            }

            header("Location: /profile");
            exit;

        } else {
            $this->GetEditProfile($errors);
        }
    }

    public function logout()
    {
        $this->authService->logout();
        header("Location: /login");
        exit;
    }

}