<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    protected $rules = [
        'p_name' => 'required|unique:permissions|max:100',
        'route' => 'required|max:100',
        'rule' => 'required|max:100',
        'pid' => 'required|integer',
        'check' => 'required|in:1,2',
        'status' => 'required|in:1,2'
    ];

    protected $messages = [
        'p_name.required' => '权限名称必须存在',
        'p_name.unique' => '权限名称不得重复',
        'p_name.max' => '权限名称不得超出100个字符',

        'route.required' => '路由必须存在',
        'route.max' => '路由不得超出100个字符',

        'rule.required' => '控制器和方法必须存在',
        'rule.max' => '控制器和方法不得超出100个字符',

        'pid.required' => '父级id必须存在',
        'pid.integer' => '父级id格式不对',

        'check.required' => '是否验证必须存在',
        'check.in' => '是否验证参数不合法',

        'status.required' => '状态必须存在',
        'status.in' => '状态参数不合法'
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
        //顶级权限
        if(Request::get('pid') == 0){
            $rules['route'] = '';
            $rules['rule'] = '';
        }
        if(Request::isMethod('PATCH')){
            $rules['p_name'] = 'required|max:100';
        }
        return $rules;
    }

    //自定定义错误
    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
