<?php

namespace App\Http\Controllers;
use App\Http\Requests\EditProfileRequest;
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
        Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);
        return response()->redirectTo('catalog');

    }

    public function logout()
    {
        Auth::logout();
        return response()->redirectTo('login');
    }

    public function getProfile()
    {
            $user=User::find(Auth::id());
            $userData=$user->only(['id','username','email','image']);
//            print_r($userData);exit;
            return view('profile', ['user' => $userData]);
    }

    public function getEditProfile()
    {
            $user=User::find(Auth::id());
            $userData=$user->only(['id','username','email','image']);
            return view('editProfileForm', ['user' => $userData]);
    }

    public function handleEditProfile(EditProfileRequest $request)
    {
//        print_r($request->all());
        User::query()->where('id', Auth::id())->update([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'image' => $request->get('avatar')
            ]);
        return response()->redirectTo('profile');
    }

}
