<?php

namespace Controllers;

class UserController extends BaseController
{
    private \Model\User $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new \Model\User();
    }

    public function getRegistrate(array $errors = null)
    {
//        if ($this->authService->check()===false) {
//            header("Location: /login");
//            exit;
//        }
        require_once '../Views/registration_form.php';
    }

    public function getLogin(array $errors = null)
    {
//        if ($this->authService->check()===false) {
//            header("Location: /login");
//            exit;
//        }
        require_once '../Views/login_form.php';
    }

    public function getProfile()
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        } else {
            $sessionId = $this->authService->getCurrentUser();
            $user=$this->userModel->getBySessionId($sessionId->getId());



            require_once '../Views/profile.php';
        }
    }

    public function getEditProfile(array $errors=null)
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }
        require_once '../Views/edit_profile.php';
    }

    private function validateLogin(array $post): array
    {
        $errors = [];

        if (!isset($post['email'])) {
            $errors['username'] = "Username is required!";
        }

        if (!isset($post['password'])) {
            $errors['password'] = "Password is required!";
        }

        return $errors;

    }

    private function validateUser(array $post): array
    {
        $errors = [];

        if (isset($post['name'])) {
            $name = $post['name'];

            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно содержать больше 2 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($post['email'])) {
            $email = $post['email'];

            if (strlen($email) < 2) {
                $errors['email'] = "email должен содержать больше 2 символов";
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = "email некорректный";
            } else {

                $result = $this->userModel->getByEmail($email);

                if ($result !== null) {
                    $errors['email'] = 'Пользователь с таким email уже зарегистрирован';
                }
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($post['psw'])) {
            $password = $post['psw'];

            if (strlen($password) < 2) {
                $errors['password'] = "Пароль должен содержать больше 2 символов";
            } elseif (isset($post['psw-repeat'])) {

                $pswRepeat = $post['psw-repeat'];

                if ($password !== $pswRepeat) {
                    $errors['psw-repeat'] = "Пароли не совпадают";
                }
            } else {
                $errors['psw-repeat'] = "Повторите пароль";
            }

        } else {
            $errors['password'] = "Пароль должен быть заполнен";
        }
        return $errors;
    }

    private function validationEditProfile(array $post): array
    {
        $errors = [];

        if (isset($post['name'])) {
            $name = $post['name'];

            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно содержать больше 2 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($post['email'])) {
            $email = $post['email'];
            if (strlen($email) < 2) {
                $errors['email'] = "email должен содержать больше 2 символов";
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = "email некорректный";
            } else {

                $result = $this->userModel->getByEmail($email);

                if ($result !== null) { // запрос вернет null если не найдет введеный email
                    $userId = $_SESSION['userId'];
                    if ($result->getId() !== $userId) {
                        $errors['email'] = 'Пользователь с таким email уже зарегистрирован';
                    }
                }
            }
        }

        if (isset($post['psw'])) {
            if ($post['psw'] !== "") {
                $password = $post['psw'];

                if (strlen($password) < 2) {
                    $errors['password'] = "Пароль должен содержать больше 2 символов";
                } elseif (isset($post['psw-repeat'])) {

                    $pswRepeat = $post['psw-repeat'];

                    if ($password !== $pswRepeat) {
                        $errors['psw-repeat'] = "Пароли не совпадают";
                    }
                } else {
                    $errors['psw-repeat'] = "Повторите пароль";
                }
            }

        }
        return $errors;
    }

    public function registrate()
    {
        $errors = $this->validateUser($_POST);

        if (empty($errors)) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];


            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->insert( $name, $email, $password);

//            $data = $this->userModel->getByEmail($email);

            echo "\n Пользователь зарегистрирован";
        }
        $this->getRegistrate($errors);
    }

    public function login()
    {
        $errors = $this->validateLogin($_POST);


        if (empty($errors)) {

           $result = $this->authService->auth($_POST['email'], $_POST['password']);

            if ($result===true) {
                header("Location: /catalog");
                exit;

            } else {
                $errors['username'] = 'username or password not valid';
            }
        }

        $this->getLogin($errors);
    }

    public function editProfile()
    {
        $errors = $this->validationEditProfile($_POST);

        if (empty($errors)) {
            $userId = $this->authService->getCurrentUser();

            $username = $_POST['name'];
            $email = $_POST['email'];
            $image_url = $_POST['avatar'];

            if ($_POST["psw"] !== "") { //проверка пароля на пустоту
                $password = $_POST["psw"];
                $password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $password = "";
            }

            $user= $this->userModel->getById($userId->getId());



            if ($user->getId() !== $username) {
                $this->userModel->updateNameById($username, $userId->getId());
            }

            if ($user->getEmail() !== $email) {
                $this->userModel->updateEmailById($email, $userId);
            }

            if ($user->getPassword() !== $password && $password !== "") {
                $this->userModel->updatePasswordById($password, $userId);
            }

            if ($user->getAvatar() !== $image_url && $image_url !== "") {
                $this->userModel->updateAvatarById($image_url, $userId);
            }
            //var_dump($_POST);
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