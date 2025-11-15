<?php

namespace App\Http\Controllers;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Services\DTO\EditProfileDTO;
use App\Services\DTO\LoginDTO;
use App\Services\DTO\SignUpDTO;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

/**
 * Контроллер отвечающий за пользователя
 */

class UserController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Выдает форму регистрации
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getSignUpForm()
    {
       return view('signUpForm');
    }

    /**
     * Выдает форму логина
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getLoginForm()
    {
        return view('loginForm');
    }


    /**
     * Регистрация пользователя, отдает в очередь отправление письма на указанный email пользователя
     *
     * @param SignUpRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signUp(SignUpRequest $request)
    {
        $dto =SignUpDTO::fromRequest($request);
        $this->userService->signUp($dto);
        return response()->redirectTo('login');
    }


    /**
     * Логин пользователя
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromRequest($request);
        $this->userService->login($dto);
        return response()->redirectTo('catalog');
    }


    /**
     * Выдача страницы пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getProfile()
    {
            $user=User::find(Auth::id());
            $userData=$user->only(['id','username','email','image']);
            return view('profile', ['user' => $userData]);
    }


    /**
     * Выдает страницу редактирования пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getEditProfile()
    {
            $user=User::find(Auth::id());
            $userData=$user->only(['id','username','email','image']);
            return view('editProfileForm', ['user' => $userData]);
    }


    /**
     * Редактирование пользователя
     *
     * @param EditProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleEditProfile(EditProfileRequest $request)
    {
        $dto = EditProfileDTO::fromRequest($request);
        $this->userService->editProfile($dto);
        return redirect()->route('profile')->with('success', 'Сохранения изменены!');
    }

    /**
     * Выход из системы
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->redirectTo('login');
    }



}
