<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController
{
    public function getSignUpForm()
    {
       return view('signUpForm');
    }
    public function getLoginForm()
    {
        return view('loginForm');
    }

    public function signUp(SignUpRequest $request)
    {
        User::query()->create([
            'username' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        response()->redirectTo('login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);


    }

}
