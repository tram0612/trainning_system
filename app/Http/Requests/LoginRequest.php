<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'min:8|max:20',
        ];
    }
    public function messages()
    {
        return [
                'email.required' => __('validation.required',['attribute' => 'email']),
                'email.email' => __('validation.email',['attribute' => 'email']),
                'password.min' => __('validation.min',['attribute' => 'password']),
                'password.max' => __('validation.max',['attribute' => 'password']),
        ];
    }
}
