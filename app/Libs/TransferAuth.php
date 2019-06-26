<?php

namespace App\Libs;

/**
 * 接口的验证规则
 */
class TransferAuth
{
    /**
     * $sign == 字段ACSII码顺序拼接为key-value形式md5()方式加密操作
     * @ username 会员账号 (account)
     * @ money 转账金额 (money)
     * @ order_no 平台订单号 (平台的order_no)
     * @ to_account 用户收款账号
     * @ account_type 账号类型 (银行卡,支付宝)
     * @ remark 备注信息
     * @ app_id '1538121609651' ?
     * @ status 是否可以出款
     */

    //签名
    public static function SignEncode($data)
    {
        return md5(http_build_query($data));
    }

    /**
     * 解密操作
     */ 
    
    
}