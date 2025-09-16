<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:30',
            'rating'=>'required|integer|between:1,5',
            'comment'=>'string|max:256',
            'product_id'=>'required|integer|exists:products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя должно быть заполнено',
            'name.string' => 'Имя введено не корректно',
            'name.min' => 'Имя должно содержать больше 3 символов',
            'name.max' => 'Имя не должно содержать больше 30 символов',

            'rating.required' => 'Оценка должна быть заполнена',
            'rating.integer' => 'Оценка введена не корректно',
            'rating.between:1,5' => 'Оценка может быть только от 1 до 5',

            'comment.string' => 'Комментарий введён не корректно',
            'comment.max' => 'Комментарий не должен содержать больше 256 символов'
        ];
    }
}
