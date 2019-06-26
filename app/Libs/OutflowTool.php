<?php

namespace App\Libs;

/**
 * 出款订单工具
 * 
 */
class OutflowTool
{
    /**
     * 出款订单状态
     */ 
    CONST CREATE_ORDER = '1';   //生成订单
    CONST REQUEST_TRANSFER_ACCOUNT = '2';   //请求转账失败
    CONST TRANSFER_ACCOUNT_ERROR = '3';     //转账失败
    CONST TRANSFER_ACCOUNT_SUCCESS = '4';   //转账成功

    
    /**
     * 接口报错信息
     */ 
    CONST APPID_KEY_ERROR   = ['20000','appid或者key是错误的'];         //app_id 或者 key 不对
    CONST SIGN_ERROR        = ['20001','签名不对哦'];                   //app_id 或者 key 不对
    CONST PARAME_ERROR      = ['20002','参数为空'];                     //参数不得为空
    CONST MAX_MONEY         = ['20003','转账金额不得超出:'];             //最高金额

    CONST MYSQL_CREATE_ERROR= ['20004','出款系统-创建出款订单-失败,时间:'];  //创建订单失败
    
}