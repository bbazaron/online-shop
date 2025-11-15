<?php

namespace App\Services\DTO;

use App\Http\Requests\EditProfileRequest;

class EditProfileDTO
{
    public function __construct(
        private string|null $username,
        private string|null $email,
        private string|null $image,
    ){}

    public static function fromRequest(EditProfileRequest $request): self
    {
        return new self(
            $request->get('username'),
            $request->get('email'),
            $request->get('image'),
        );
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

}
