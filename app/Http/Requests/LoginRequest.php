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
            'name'=>[
                'required',
                'regex:/^[a-zA-Z0-9]*$/',
            ],
            'password'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'name.regex' => '用户名为纯数字',
            'password.required' => '密码不能为空',
        ];
    }
}
