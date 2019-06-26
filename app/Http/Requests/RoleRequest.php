<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    protected $rules = [
        'r_name' => 'required|unique:roles|max:16|min:2',
        'desc' => 'max:255'
    ];

    protected $messages = [
        'r_name.required' => '角色的名称必须存在',
        'r_name.unique' => '角色名称不得重复',
        'r_name.max' => '角色不得超出16个字符',
        'r_name.min' => '角色小于2个字符',
        'desc.max' => '备注不得超出255个字符'
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
            $rules['r_name'] =  'required|max:16|min:2';
        }
        return $rules;
    }

    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
