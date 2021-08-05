<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;   
class SubjectRequest extends FormRequest
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
                    'name' => 'required|unique:subject,name',
                    'detail' =>'required',
                    'img' =>'required|image|mimes:jpeg,jpg,bmp,png,gif|max:2048',
                    
                ];
            }
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:course,name,'.Request()->subject,
                    'detail' => 'required',
                    'img' =>  'image|mimes:jpeg,jpg,bmp,png,gif|max:2048',
                    
                                       
                ];
            }
            default: break;
        }
    }
    public function messages()
    {
        return [
                'name.required' =>  __('validation.required',['attribute' => 'name']),
                'detail.required' =>  __('validation.required',['attribute' => 'detail']),
                'name.unique' => __('validation.unique',['attribute' => 'name']),
                'img.image' =>  __('validation.image',['attribute' => 'img']),
                'img.mimes' =>  __('validation.mimes',['attribute' => 'img']),
                'img.max' =>  __('validation.max',['attribute' => 'img']),
        ];
    }
}
