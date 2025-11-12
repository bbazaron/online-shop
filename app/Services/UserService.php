<?php

namespace App\Services;

use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Jobs\SendTestEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Создание нового пользователя
     *
     * @param SignUpRequest $request
     * @return void
     */
    public function signUp(SignUpRequest $request)
    {
        $data = $request->validated();

        User::query()->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $email = $request->input('email', 'youremail@example.com');

        SendTestEmailJob::dispatch($email);
    }


    /**
     * Логин
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);
    }

    /**
     * Редактирование пользователя
     *
     * @param EditProfileRequest $request
     * @return void
     */
    public function editProfile(EditProfileRequest $request)
    {
        $data = $request->validated();
        User::query()->where('id', Auth::id())->update([
            'username' => $data['username'],
            'email' => $data['email'],
            'image' => $data['image'],
        ]);
    }
}
