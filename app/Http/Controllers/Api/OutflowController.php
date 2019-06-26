<?php

namespace App\Http\Controllers\Api;

use App\Jobs\Transfer;
use App\Libs\OutflowTool;
use app\Libs\ResponseJson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OutflowRepository;

class OutflowController extends Controller
{
    /**
     * 从其他的平台发送过来的数据
     * @ username 会员账号
     * @ money 转账金额
     * @ order_no 平台订单号 (平台的)
     * @ to_account 用户收款账号
     * @ account_type 账号类型 (银行卡,支付宝)
     */
    protected $maxMoney = 5000;
    protected $outflowRepository;

    //构造函数
    public function __construct(OutflowRepository $outflowRepository)
    {
        $this->outflowRepository = $outflowRepository;
    }

    public function toTransfer(Request $request)
    {
        //dump(';;');
        $data = [
            'username' => $request->input('username',''),
            'money' => $request->input('money',''),
            'order_no' => $request->input('order_no',''),
            'to_account' => $request->input('to_account',''),
            'account_type' => $request->input('account_type','')
        ];
        //参数是否合法
        if( empty($data['username']) || empty($data['money']) || empty($data['order_no']) || empty($data['to_account']) || empty($data['account_type']) ){
            return ResponseJson::JsonData(OutflowTool::PARAME_ERROR[0],OutflowTool::PARAME_ERROR[1]);
        }
        //会员账号是否在平台内存在 todo
         
        //转账金额是否符合要求
        if($data['money'] > $this->maxMoney){
            return ResponseJson::JsonData(OutflowTool::MAX_MONEY[0],OutflowTool::MAX_MONEY[1] . $this->maxMoney . '元');
        }
        
        //出款订单是否存在
        if(!$this->outflowRepository->outfloweExistd($data['order_no'])){
            //保存出款信息后台
            if(!$this->outflowRepository->outflowSave($data)){
                app('log')->info('出款系统-创建出款订单-失败,时间:'.date('Y-m-d H:i:s',time()));
                return ResponseJson::JsonData(OutflowTool::MYSQL_CREATE_ERROR[0],OutflowTool::MYSQL_CREATE_ERROR[1].date('Y-m-d H:i:s',time()));
            };
        }

        //订单转账成功之后,直接返回回调
        if($this->outflowRepository->outflowed($data['order_no'])){

            $data = [
                'username' => 'test123',
                'order_no' => '111111111111111',
                'status'   => '4'
            ];
            return ResponseJson::SuccessJsonResponse($data);
        };
        
        // (1) 转账操作(分配队列),,支付一次之后失败,,重新进入队列
        dispatch(new Transfer($data));
        // (2) 支付操作       
        return 'ok';
    }
}
