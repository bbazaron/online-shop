<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'contact_name' => 'required|max:255',
            'address' => 'required|max:255',
            'contact_phone' => 'required|max:255',
            'comment' => 'max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'contact_name.required' => 'Имя должно быть заполнено',
            'name.max' => 'Имя должно содержать не больше 255 символов',

            'address.required' => 'Адрес должен быть заполнен',
            'address.max' => 'Адрес должен содержать не больше 255 символов',

            'contact_phone.required' => 'Телефон должен быть заполнен',
            'contact_phone.max' => 'Телефон должен содержать не больше 255 символов',

            'comment.max' => 'Комментарий должен содержать не больше 255 символов',
        ];
    }
}
