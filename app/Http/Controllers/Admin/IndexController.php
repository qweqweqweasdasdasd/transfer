<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //后台管理--后台主页
    public function index()
    {
        return view('admin.index.index');
    }

    //后台管理--welcome
    public function welcome()
    {
        $manager = Auth::guard('admin')->user();
        //dump($manager);
        return view('admin.index.welcome',compact('manager'));
    }
}
