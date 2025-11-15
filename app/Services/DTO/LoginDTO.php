<?php

namespace App\Services\DTO;

use App\Http\Requests\LoginRequest;

class LoginDTO
{
    public function __construct(
        private string $email,
        private string $password,
    ){}

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            $request->get('email'),
            $request->get('password'),
        );
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


}
