<?php

namespace App\Common;

class ApiErrDesc
{
    const NOT_KNOW_ERR = ['1000','不明错误'];
    
    const POINTED_BUDANED = ['2000','上分成功或者补单成功,重复请求!'];

    const ORDER_EXIST = ['2001','接口已经请求一次了,订单已经存在-'];

    const ORDER_NO_MONEY_EMPTY = ['2002','数据不全,订单号或者金额为空!'];

    const DO_DEPOSIT_PARAM_EMPTY = ['3000','第四方存款接口传入参数不全!'];

    const DO_VERIFY_USER_PARAM_EMPTY = ['3001','第四方核实会员是否存在接口传入参数不全!'];

    const DO_VERIFY_SUCCESS = ['3001','第四方核实会员接口核实正确!'];
   
    const DO_DEPOSIT_SUCCESS = ['3002','第四方存款接口核实正确!'];
    
}