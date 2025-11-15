<?php

namespace App\Services\DTO;


use App\Http\Requests\SignUpRequest;

class SignUpDTO
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
    ){}

    public static function fromRequest(SignUpRequest $request): self
    {
        return new self(
            $request->get('username'),
            $request->get('email'),
            $request->get('password'),
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
