<?php

namespace app\Libs;

/**
 * 封装json错误信息
 * 
 */
class ResponseJson
{
    //返回错误码和错误信息 (success||error)
    public static function JsonData($code,$msg,$data=[])
    {
        $content = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];

        return json_encode($content);
    }

    //返回成功的数据
    public static function SuccessJsonResponse($data)
    {
        $content = [
            'code' => '1',
            'msg' => 'success',
            'data' => $data
        ];

        return json_encode($content);
    }

    //返回错误
    //返回成功的数据
    public static function ErrorJsonResponse($data)
    {
        $content = [
            'code' => '0',
            'msg' => 'error',
            'data' => $data
        ];

        return json_encode($content);
    }
}