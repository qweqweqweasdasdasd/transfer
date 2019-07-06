<?php

namespace app\Libs;

use App\Order;

/**
 * 存款接口工具
 */
class AddMoneyTool
{
    // 写日志 格式 (时间-xxxx-xx-xx 信息-************)
    public static function log($ErrInfo)
    {
        return app('log')->info('时间-' . date('Y-m-d H:i:s',time()) . ' 信息-' . $ErrInfo);
    }

}