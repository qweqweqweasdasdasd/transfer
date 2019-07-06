<?php

namespace App\Http\Controllers\Api;

use App\Order;
use app\Libs\AddMoneyTool;
use App\Common\ApiErrDesc;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;

class MoneyController extends Controller
{
    // 自动存款接口
    public function addMoney(Request $request)
    {
        // 写日志
        AddMoneyTool::log('原始数据:'.json_encode($request->all()));
        // 接收数据
        $d = [
            'type'    => !empty($request->input('type'))? $request->input('type') :'',       //支付类型
            'order_no'=> !empty($request->input('no'))? $request->input('no'):'',            //订单号
            'money'   => !empty($request->input('money'))? str_replace(",","",$request->input('money')):'',      //存款金额 去除 ,
            'mark'    => !empty($request->input('mark'))? $request->input('mark'):'',        //会员账号
            'dt'      => !empty($request->input('dt'))? $request->input('dt'):'',            //支付时间
            'mch_id'  => !empty($request->input('mch_id'))? $request->input('mch_id'):'',    //mch_id
            'shopId'  => !empty($request->input('shopId'))? $request->input('shopId'):'',    //shopid
            'account' => !empty($request->input('account'))? $request->input('account'):'',  //本机手机号
            'status'  => Order::PAY_SUCCESS                                                  //订单状态
        ];
        
        // 写日志
        AddMoneyTool::log('处理之后数据:'.json_encode($d));

        $or = (new Order())->OrderFirst($d['order_no']);
        
        // 订单已经生成了,,已经支付成功或者补单成功,,
        if(!is_null($or)){
            AddMoneyTool::log(ApiErrDesc::ORDER_EXIST[1].'订单-'.$d['order_no']);
            return 'success';
        }

        // 组装数据生成订单
        try {
            // 生成订单
            if($order = (new Order())->create($d)){
            
              // 订单生成成功之后 查询该会员是否存在于平台
              dd($this->doVerifyUser($order));
              
              // 执行平台第四方接口存款
             

            }

        } catch (\Exception $e) {
            AddMoneyTool::log($e->getMessage());
            return 'success';
        } 
    }


    // 查询平台是否存在该会员
    public function doVerifyUser($order)
    {
        $build = app('\App\Build\Building');
        
        $d = [
            'username' => $order->mark,
            'money' => $order->money,
            'no' => $order->no
        ];

        try {
            $res = $build->doVerifyUser($d['username']);
        } catch (\Exception $e) {
            // 接口失败
            $order->status = Order::INTERFACE_ERR;
            $order->desc   = $e->getMessage();
            AddMoneyTool::log($e->getMessage());
        }
        // 内容失败
        if(!$res['status']){
            $order->status = Order::USERNAME_ERR;
            $order->desc   = $res['msg'];
            AddMoneyTool::log($res['msg'].'会员账号-'.$d['username']);
        }
        // 成功
        if($res['status']){
            // 写成功日志
            $order->status = Order::USERNAME_SUCCESS;
            $order->desc   = $res['msg'];
            AddMoneyTool::log(ApiErrDesc::DO_VERIFY_SUCCESS[1].'会员账号-'.$d['username']);
        }
        // 更新数据
        $order->update();
        return true;
    }

    // 平台存款动作
    public function doDeposit($order)
    {
        $build = app('\App\Build\Building');
        
        $d = [
            'username' => $order->mark,
            'money' => $order->money,
            'no' => $order->no
        ];

        try {
            $res = $build->doDeposit($d);
        } catch (\Exception $e) {
            // 失败
            $order->status = Order::INTERFACE_ERR;
            $order->desc   = $e->getMessage();
            AddMoneyTool::log($e->getMessage());
        }
        // 失败
        if(!$res['status']){
            $order->status = Order::POINT_ERR;
            $order->desc   = $res['msg'];
            AddMoneyTool::log($res['msg']);
        }
        // 成功
        if($res['status']){
            // 写成功日志
            $order->status = Order::POINT_SUCCESS;
            $order->desc   = $res['msg'];
            AddMoneyTool::log(ApiErrDesc::DO_DEPOSIT_SUCCESS[1]);
        }
        // 更新数据
        $order->update();
        return true;
    }
}
