<?php

namespace App\Repositories;

use App\Order;

class OrderRepository extends BaseRepository
{
    //构造函数
    public function __construct()
    {
        $this->table = 'orders';
        $this->id = 'order_id';
    }

    // 获取到所有的订单信息
    public function getOrder($d)
    {
        return Order::where(function($query) use($d){
                    if( !empty($d['type']) ){
                        $query->where('type',$d['type']);
                    }
                    if( !empty($d['status']) ){
                        $query->where('status',$d['status']);
                    }

                    if( !empty($d['keyword']) ){
                        $query->where('order_no',$d['keyword'])
                              ->orWhere('mark',$d['keyword'])
                              ->orWhere('mch_id',$d['keyword']);
                    }
                })
                ->orderBy('order_id','desc')
                ->paginate($d['limit']);
    }

    // 获取到订单总数
    public function getCount($d)
    {
        return Order::where(function($query) use($d){
                    if( !empty($d['type']) ){
                        $query->where('type',$d['type']);
                    }
                    if( !empty($d['status']) ){
                        $query->where('status',$d['status']);
                    }
                })
                ->count();
    }
}
