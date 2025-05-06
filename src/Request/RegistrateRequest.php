<?php

namespace Request;
use \Model\User;

class RegistrateRequest
{

    public function __construct(private array $post)
    {
    }
    public function getName(): string
    {
        return $this->post['name'];
    }

    public function getEmail(): string
    {
        return $this->post['email'];
    }

    public function getPassword():string
    {
        return $this->post['psw'];
    }

    public function getPasswordRepeat():string
    {
        return $this->post['psw-repeat'];
    }



    public function validateUser(): array
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

                $result = User::getByEmail($email);

                if ($result !== null) {
                    $errors['email'] = 'Пользователь с таким email уже зарегистрирован';
                }
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($this->post['psw'])) {
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

        } else {
            $errors['password'] = "Пароль должен быть заполнен";
        }


        return $errors;
    }
}