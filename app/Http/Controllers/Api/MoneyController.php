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
        // 接收数据
        $d = [
            'type'    => $request->input('type',''),      //支付类型
            'order_no'=> $request->input('no',''),        //订单号
            'money'   => $request->input('money',''),     //存款金额
            'mark'    => $request->input('mark',''),      //会员账号
            'dt'      => $request->input('dt',''),        //支付时间
            'mch_id'  => $request->input('mch_id',''),    //mch_id
            'shopId'  => $request->input('shopId',''),    //shopid
            'account' => $request->input('account',''),   //本机手机号
            'status'  => Order::PAY_SUCCESS               //订单状态
        ];
        
        $or = (new Order())->OrderFirst($d['order_no']);
        
        // 订单已经生成了,,已经支付成功或者补单成功,,
        if(!is_null($or)){
            AddMoneyTool::log(ApiErrDesc::ORDER_EXIST[1]);
            return 'success';
        }

        // 组装数据生成订单
        try {
            // 生成订单
            if($or = (new Order())->create($d)){
              dump($or);
              // 订单生成成功之后 查询该会员是否存在于平台
              
              // 执行平台第四方接口存款

            }

        } catch (\Exception $e) {
            AddMoneyTool::log($e->getMessage());
            return 'success';
        } 
    }


    // 查询平台是否存在该会员
    public function doVerifyUser()
    {
        $build = app('\App\Build\Building');
        
        $d = [
            'username' => 'test',
            'money' => '1',
            //'no' => '111111111111111111'
        ];
        try {
            $build->doVerifyUser($username = 'test123');
        } catch (\Exception $e) {
            // 失败
            AddMoneyTool::log($e->getMessage());
        }
        // 成功
    }

    // 平台存款动作
    public function doDeposit()
    {
        $build = app('\App\Build\Building');
        
        $d = [
            'username' => 'test',
            'money' => '1',
            'no' => '111111111111111111'
        ];
        try {
            $build->doDeposit($d);
        } catch (\Exception $e) {
            // 失败
            AddMoneyTool::log($e->getMessage());
        }
        // 成功
    }
}
