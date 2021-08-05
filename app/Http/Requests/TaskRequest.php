<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;   
class TaskRequest extends FormRequest
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
            'name' => 'required',
            'detail' =>'required',
        ];
           
        
    }
    public function messages()
    {
        return [
                'name.required' =>  __('validation.required',['attribute' => 'name']),
                'detail.required' =>  __('validation.required',['attribute' => 'detail']),
        ];
    }
}
