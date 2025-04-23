<?php

namespace Request;

class EditProfileRequest
{
    private \Model\User $userModel;

    public function __construct(private array $post)
    {
        $this->userModel = new \Model\User();

    }

    public function getName(): string
    {
        return $this->post['name'];
    }

    public function getEmail(): string
    {
        return $this->post['email'];
    }

    public function getAvatar(): string
    {
        return $this->post['avatar'];
    }

    public function getPassword(): string
    {
        return $this->post['psw'];
    }

    public function getRepeatPsw(): string
    {
        return $this->post['psw-repeat'];
    }

    public function validationEditProfile(): array
    {
        $errors = [];

        if (isset($this->post['name'])) {
            $name = $this->post['name'];

            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно содержать больше 2 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($this->post['email'])) {
            $email = $this->post['email'];
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

        if (isset($this->post['psw'])) {
            if ($this->post['psw'] !== "") {
                $password = $this->post['psw'];

                if (strlen($password) < 2) {
                    $errors['password'] = "Пароль должен содержать больше 2 символов";
                } elseif (isset($this->post['psw-repeat'])) {

                    $pswRepeat = $this->post['psw-repeat'];

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
}