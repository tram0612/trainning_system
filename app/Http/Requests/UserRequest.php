<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;   
class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8|max:20',
                    'role'=>'required'
                ];
            }
            case 'PATCH':
            {
                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,'.Request()->user,
                    'avatar' =>  'image|mimes:jpeg,jpg,bmp,png,gif|max:2048',
                    'password' => 'nullable|min:8|max:20',
                ];
            }
            default: break;
        }
    }
    public function messages()
    {
        return [
                'name.required' => __('validation.required',['attribute' => 'name']),
                'email.required' => __('validation.required',['attribute' => 'email']),
                'email.email' => __('validation.email',['attribute' => 'email']),
                'password.min' => __('validation.min',['attribute' => 'password']),
                'password.max' => __('validation.max',['attribute' => 'password']),
                'email.unique' => __('validation.unique',['attribute' => 'email']),
                'avarta.image' => __('validation.image',['attribute' => 'avarta']),
                'avarta.mimes' => __('validation.mimes',['attribute' => 'avarta']),
                'avarta.max' => __('validation.max',['attribute' => 'avarta']),
                'role.required'=> __('validation.required',['attribute' => 'role']),
                
        ];
    }
}
