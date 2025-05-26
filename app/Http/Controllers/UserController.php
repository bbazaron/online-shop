<?php

namespace App\Http\Controllers;
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

    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::query()->create([
            'username' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($data)){
            $request->session()->regenerate();

            return redirect()->intended('catalog');
        }

        return back()->withErrors([
            'email' => 'Введены неверные данные'
        ])->onlyInput('email');
    }

}
