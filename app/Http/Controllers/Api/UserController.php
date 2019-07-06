<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //会员登录
    public function login()
    {
        $data = [
            'name' => 'json',
            'age'  => '23',
            'iphone' => '15836020238'
        ];
        return $data;
    }
}
