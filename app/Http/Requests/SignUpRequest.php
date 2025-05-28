<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя должно быть заполнено',
            'name.min' => 'Имя должно содержать больше 5 символов',

            'email.required' => 'Email должен быть заполнен',
            'email.email' => 'Email введён не корректно',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован',

            'password.required' => 'Пароль должен быть заполнен',
            'password.min' => 'Пароль должен содержать больше 6 символов',
            'password.confirmed' => 'Пароли не совпадают',

            'password_confirmation.required' => 'Пароль должен быть заполнен',
            'password_confirmation.min' => 'Пароль должен содержать больше 6 символов',
        ];
    }
}
