<?php

namespace Request;

use Services\Auth\AuthSessionService;

class OrderRequest
{
    protected AuthSessionService $authService;

    public function __construct(private array $post)
    {
        $this->authService = new AuthSessionService();

    }

    public function getName(): string
    {
        return $this->post['contact_name'];
    }

    public function getPhone(): string
    {
        return $this->post['contact_phone'];
    }

    public function getAddress(): string
    {
        return $this->post['address'];
    }

    public function getComment(): string
    {
        return $this->post['comment'];
    }

    public function orderValidation():array
    {
        if ($this->authService->check()===false) {
            header("Location: /login");
            exit;
        }

        $errors = [];

        if (isset($this->post['contact_name'])) {
            $name = $this->post['contact_name'];

            if (strlen($name) < 2) {
                $errors['contact_name'] = "Имя должно содержать больше 2 символов";
            }
        } else {
            $errors['contact_name'] = "Имя должно быть заполнено";
        }

        if (isset($this->post['contact_phone'])) {
            $contact_phone = $this->post['contact_phone'];
            if (is_numeric($contact_phone) === false) {
                $errors['contact_phone'] = "Введены неверные данные";
            } elseif ($contact_phone === '0') {
                $errors['contact_phone'] = "номер не может быть 0";
            } elseif(strlen($contact_phone)<2)
            {
                $errors['contact_phone'] = 'номер должен содержать большей 2 символов';
            }
        } else {
            $errors['contact_phone'] = 'номер должен быть заполнен';
        }

        if (isset($this->post['address'])) {
            $address = $this->post['address'];

            if (strlen($address) < 2) {
                $errors['address'] = "Адрес должен содержать больше 2 символов";
            }
        } else {
            $errors['address'] = "Адрес должен быть заполнен";
        }

        return $errors;
    }

}