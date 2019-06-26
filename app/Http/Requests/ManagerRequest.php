<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
{
    //规则
    protected $rules = [
        'mg_name' => 'required|min:2,max:16|unique:managers',
        'password' => 'required|min:2,max:16|confirmed',
        'status' => 'required|integer'
    ];

    protected $messages = [
        'mg_name.required' => '管理员名称必须存在',
        'mg_name.min' => '管理员名称不得下于2个字符',
        'mg_name.max' => '管理员名称不得超出16个字符',
        'mg_name.unique' => '管理员名称不得重复',

        'password.required' => '管理员密码必须存在',
        'password.min' => '管理员密码不得小于2个字符',
        'password.max' => '管理员密码不得超出16个字符',
        'password.confirmed' => '初始密码和确认密码不符',

        'status.required' => '验证码必须存在',
        'status.integer' => '验证码格式不对'
    ];

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
        $rules = $this->rules;
        if(Request::isMethod('PATCH')){
            $rules['mg_name'] = 'required|min:2,max:16';
        }
        return $rules;
    }

    //自定义错误信息
    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
