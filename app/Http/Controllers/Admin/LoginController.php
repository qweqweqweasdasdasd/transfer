<?php

namespace App\Http\Controllers\Admin;

use Auth;
use app\Libs\ResponseJson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckManagerRequest;

class LoginController extends Controller
{
    //后台管理--登录显示
    public function index()
    {
        if(Auth::guard('admin')->check()){
            return redirect('/admin/index');
        }
        return view('admin.login.index');
    }

    //后台管理--登录逻辑
    public function login(CheckManagerRequest $request)
    {
        //auth认证是否存在
        $credentials = $request->only(['mg_name','password']);
        if(!(Auth::guard('admin')->attempt($credentials))){
            return ResponseJson::JsonData(config('code.error'),config('code.msg.1000'));
        }
        $manager = Auth::guard('admin')->user();
        
        //判定当前用户状态为
        if(!$this->CheckManagerStatus($manager)){
            return ResponseJson::SuccessJsonResponse(['href' => '/admin/login']);
        }
        //sso中间件
        
        //记录用户ip地址和最后一次登录时间和记录登录次数
        $this->CreateIpAndLastLoginTimeAndCounts($manager);
        return ResponseJson::SuccessJsonResponse(['href' => '/admin/index']);
    }

    //后台管理--退出登录
    public function logout()
    {
        Auth::guard('admin')->logout();  
        return redirect('/admin/login');
    }

    //判定当前用户状态
    protected function CheckManagerStatus($manager)
    {
        if($manager->status == 1){
            return true;
        }elseif($manager->status == 2){
            return false;
        }

    }

    //记录用户ip地址和最后一次登录时间和记录登录次数
    protected function CreateIpAndLastLoginTimeAndCounts($manager)
    {
        $manager->ip = request()->ip();
        $manager->last_login_time = date('Y-m-d H:i:s',time());

        return $manager->increment('login_counts',1) && $manager->save();
    }

}
