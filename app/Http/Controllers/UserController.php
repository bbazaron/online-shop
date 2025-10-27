<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Services\RabbitmqService;
use App\Http\Services\UserService;
use App\Jobs\SendTestEmailJob;
use App\Mail\Testmail;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

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
        $this->userService->signUp($request);
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
        $this->userService->login($request);
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
        $this->userService->editProfile($request);
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
