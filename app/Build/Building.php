<?php 

namespace App\Build;

interface Building 
{
    // 第四方接口存款
    public function doDeposit(array $d);

    // 第四方接口会员查询
    public function doVerifyUser(string $username);


}