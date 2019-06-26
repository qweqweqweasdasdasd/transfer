<?php

namespace App\Repositories;

use DB;
use Hash;
use App\Outflow;
use App\Libs\OutflowTool;
use Illuminate\Database\QueryException;

class OutflowRepository extends BaseRepository
{
    //构造函数
    public function __construct()
    {
        $this->table = 'outflow';
        $this->id = 'out_id';
    }

    //获取到所有出款订单数据
    public function getOutflow($data)
    {
        return Outflow::where(function($query) use($data) {
                    if( !empty($data['status']) ){
                        $query->where('status',$data['status']);
                    }
                    if( !empty($data['account_type']) ){
                        $query->where('account_type',$data['account_type']);
                    }
                    if( !empty($data['account']) ){
                        $query->where('account',$data['account']);
                    }
                    if( !empty($data['order_no']) ){
                        $query->where('order_no',$data['order_no']);
                    }
                })
                ->orderBy('out_id','desc')
                ->paginate(11);
    }

    //获取到所有出款订单总数
    public function getCount($data)
    {
        return Outflow::where(function($query) use($data){
                    if( !empty($data['status']) ){
                        $query->where('status',$data['status']);
                    }
                    if( !empty($data['account_type']) ){
                        $query->where('account_type',$data['account_type']);
                    }
                    if( !empty($data['account']) ){
                        $query->where('account',$data['account']);
                    }
                    if( !empty($data['order_no']) ){
                        $query->where('order_no',$data['order_no']);
                    }
                })->count();
    }

    //是否存在订单
    public function outfloweExistd($order_no)
    {
        return Outflow::where('order_no',$order_no)->count();
    }

    //订单号判断是否出款过
    public function outflowed($order_no)
    {
        $outflow = Outflow::where('order_no',$order_no)->first();
        if($outflow->status == OutflowTool::TRANSFER_ACCOUNT_SUCCESS){
            return true;
        }
        return false;
    }   

    //保存出款信息后台
    public function outflowSave($d)
    {
        $d['status'] = OutflowTool::CREATE_ORDER;
        return $this->CommonSave($d);
    }
}
