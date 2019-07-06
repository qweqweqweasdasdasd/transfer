<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
	protected $table = 'orders';
    protected $fillable = [
    	'type','order_no','money','mark','dt','mch_id','shopId','account','desc','status'
    ];

    // 订单状态 常量
    const PAY_SUCCESS   = 1;      // 支付成功 
    const USERNAME_ERR  = 2;      // 账号无效(会员)
    const REQUEST_IN    = 3;      // 请求上分接口中
    const POINT_SUCCESS = 4;      // 上分成功
    const BUDAN_SUCCESS = 5;      // 补单成功
    const NOT_KNOW_ERR  = 6;      // 不明原因失败
    const INTERFACE_ERR = 7;      // 请求查询会员账号或者存款接口服务器错误
    const POINT_ERR     = 8;      // 上分失败
    const USERNAME_SUCCESS = 9;   // 账号有效

    // 根据订单查询到一条数据
    public function OrderFirst($orderNo)
    {
        return Order::where('order_no',$orderNo)->first();
    }

    // 根据订单查询是否上分成功
    public function pdPointed($orderNo)
    {
        return !!Order::Pointed()->where('order_no',$orderNo)->count();
    }

    // 根据订单查询是否补单成功
    public function pdBudaned($orderNo)
    {
        return !!Order::Budaned()->where('order_no',$orderNo)->count();
    }

    // 平台补单成功
    public function scopeBudaned($query)
    {
        return $query->where('status',self::BUDAN_SUCCESS);
    }

    // 平台上分成功
    public function scopePointed($query)
    {
        return $query->where('status',self::POINT_SUCCESS);
    }
}
