<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * 表单验证
     * @return string[]
     */
    public function rules(){
        return [
            'name' => 'required|max:16',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:16|confirmed',
        ];
    }

    /**
     * 自定义验证提示信息
     */
    public function messages()
    {
        return [
            'name.required' => '昵称 不能为空',
            'name.max' => '昵称 不能超过16个字符',
        ];
    }
}
