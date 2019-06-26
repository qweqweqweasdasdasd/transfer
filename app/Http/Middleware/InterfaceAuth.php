<?php

namespace App\Http\Middleware;

use Closure;
use App\Libs\OutflowTool;
use App\Libs\TransferAuth;
use app\Libs\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class InterfaceAuth
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
        //接口验证规则
        //1, 字段ACSII码顺序拼接为key-value形式
        //2, key = 'ccc22a0e37e9430fa312173697db2c94'
        //3, app_id=1538121609651&key=ccc22a0e37e9430fa312173697db2c94&account_type=1&money=100&order_no=11111111111&status=1&to_account=222222222&username=test123&sign=747e9eca37a469c9c295a95c6409a8c6
        //5, 发送数据
        $data = [
            'username' => $request->input('username',''),           //会员账号
            'money' => $request->input('money',''),                 //出款金额
            'order_no' => $request->input('order_no',''),           //订单号
            'to_account' => $request->input('to_account',''),       //出款到账号
            'account_type' => $request->input('account_type',''),   //出款方式(支付宝,银行)
            'remark' => $request->input('remark',''),             //备注(可缺,不加密)
            'app_id' => $request->input('app_id',''),             //商户id
            'status' => $request->input('status',''),             //是否可以出款状态
            'key' => $request->input('key',''),                   //钥匙
            'sign' => $request->input('sign','')                  //签名
        ];

        //去除 sign 字段 和 remark 字段 不参加加密运算
        $d = array_except($data,['sign','remark']);
        
        //数组以acsii码正序排列
        if(ksort($d)){

            //判断 app_id 和 key 是否一致
            //dd(md5(http_build_query(array_except($data,['sign','remark']))));
            if( !( $d['app_id'] == env('INTERFACE_APP_ID') && $d['key'] == env('INTERFACE_KEY') ) ){
                echo ResponseJson::JsonData(OutflowTool::APPID_KEY_ERROR[0],OutflowTool::APPID_KEY_ERROR[1]);
                exit();
            }
            
            //判断客户端转递的签名是否符合标准
            app('log')->info('url: ' . http_build_query($d) );
            app('log')->info('md5: ' . md5(http_build_query($d)));
            if( !($data['sign'] == TransferAuth::SignEncode($d)) ){   
                echo ResponseJson::JsonData(OutflowTool::SIGN_ERROR[0],OutflowTool::SIGN_ERROR[1]);
                exit();
            }
        };
        
        return $next($request);
    }
}
