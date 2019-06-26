<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckManagerRequest extends FormRequest
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
            'mg_name' => 'required|min:2,max:16',
            'password' => 'required|min:2,max:16',
            'code' => 'required|integer|captcha'
        ];
    }

    /**
     * 自定义错误信息
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'mg_name.required' => '管理员名称必须存在',
            'mg_name.min' => '管理员名称不得下于2个字符',
            'mg_name.max' => '管理员名称不得超出16个字符',
            'password.required' => '管理员密码必须存在',
            'password.min' => '管理员密码不得小于2个字符',
            'password.max' => '管理员密码不得超出16个字符',
            'code.required' => '验证码必须存在',
            'code.integer' => '验证码格式不对',
            'code.captcha' => '验证码不对哦'
        ];
    }
}
