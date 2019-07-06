<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\ApiErrDesc;
use app\Libs\AddMoneyTool;
use Illuminate\Http\Request;

class form_android_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 接口数据是否为空
        $type       = $request->input('type','');      //支付类型
        $no         = $request->input('no','');        //订单号
        $money      = $request->input('money','');     //存款金额
        $mark       = $request->input('mark','');      //会员账号
        $dt         = $request->input('dt','');        //支付时间
        
        $key        = env('SIGN_KEY');                 //约定key
        $sign       = $request->input('sign','');      //客户端的签名

        // 安全考虑::订单或者金额为空
        if( empty($no) || empty($money) ){
            AddMoneyTool::log(ApiErrDesc::ORDER_NO_MONEY_EMPTY[1]);
            echo 'success';die();
        }
        
        // 签名是否存在或者是否正确
        

        return $next($request);
    }
}
