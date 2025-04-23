<?php

namespace Request;

class LoginRequest
{

    public function __construct(private array $post)
    {
    }

    public function getEmail(): string
    {
        return $this->post['email'];
    }

    public function getPassword(): string
    {
        return $this->post['password'];
    }

    public function validateLogin(): array
    {
        $errors = [];

        if (!isset($this->post['email'])) {
            $errors['username'] = "Username is required!";
        }

        if (!isset($this->post['password'])) {
            $errors['password'] = "Password is required!";
        }

        return $errors;

    }
}