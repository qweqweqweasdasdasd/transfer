<?php

namespace App\Build;

use App\Common\ApiErrDesc;
use App\Exceptions\ApiException;

class XhuihuangBuilding implements Building
{
    protected $client = '';
    protected $app_id = '1543652117475';
    protected $key    = 'ebce3623f74746c3968d0ad072a108b5';
    protected $url    = 'http://ourf4pay.agcjxnow.com/fourth_payment_platform/pay/addMoney';

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    // 第四方接口存款
    // 会员账号:  $username
    // 存款金额:  $money
    // 订单号:    $no
    public function doDeposit(array $d)
    {
        // 参数不全 抛出异常
        if( !(!empty($d['username']) && !empty($d['money']) && !empty($d['no'])) ){
            throw new ApiException(ApiErrDesc::DO_DEPOSIT_PARAM_EMPTY);
        }

        $sign = md5('account='.$d['username'].'&app_id='.$this->app_id.'&money='.$d['money'].'&order_no='.$d['no'].'&status=0&tradeType=1&type=1&key='.$this->key);

        // 发送数据
        $postData = [
            'account'=>$d['username'],
            'app_id'=>$this->app_id,
            'money'=>$d['money'],
            'order_no'=>$d['no'],
            'remark'=>'okok111',
            'sign'=>$sign,    //32位小写MD5签名值，GB2312编码
            'status'=>'0',    //0：支付成功 1：支付失败
            'tradeType'=>'1', //支付类型  0：网银 1 微信 2支付宝 3QQ
            'type'=>'1'      //支付终端  0：PC 1：手机 2：APP
        ];

        // 发送请求 POST
        $res = $this->client->request('POST',$this->url,$postData);
        dump($res);
        echo $res->getStatusCode();
    }

    // 第四方接口会员查询
    public function doVerifyUser(string $username)
    {
        if(empty($username)){
            throw new ApiException(ApiErrDesc::DO_VERIFY_USER_PARAM_EMPTY);
        }
        
        $sign = md5('account='.$username.'&app_id='.$this->app_id.'&key='.$this->key);

        $postData = [
            'account' => $username,
            'app_id' =>$this->app_id,
            'sign' => $sign
        ];

        // 发送请求 POST
        $res = $this->client->request('POST',$this->url,$postData);
        dump($res);
        echo $res->getStatusCode();
    }

}