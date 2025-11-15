<?php

namespace App\Services;

use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Jobs\SendTestEmailJob;
use App\Models\User;
use App\Services\DTO\EditProfileDTO;
use App\Services\DTO\LoginDTO;
use App\Services\DTO\SignUpDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Создание нового пользователя
     *
     * @param SignUpDTO $dto
     * @return void
     */
    public function signUp(SignUpDTO $dto)
    {
        User::query()->create([
            'username' => $dto->getName(),
            'email' => $dto->getEmail(),
            'password' => Hash::make($dto->getPassword()),
        ]);

        $email = $dto->getEmail();

        SendTestEmailJob::dispatch($email);
    }


    /**
     * Логин
     *
     * @param LoginDTO $dto
     * @return void
     */
    public function login(LoginDTO $dto)
    {
        Auth::attempt([
            'email' => $dto->getEmail(),
            'password' => $dto->getPassword()
        ]);
    }

    /**
     * Редактирование пользователя
     *
     * @param EditProfileDTO $dto
     * @return void
     */
    public function editProfile(EditProfileDTO $dto)
    {
        User::query()->where('id', Auth::id())->update([
            'username' => $dto->getUsername(),
            'email' => $dto->getEmail(),
            'image' => $dto->getImage(),
        ]);
    }
}
