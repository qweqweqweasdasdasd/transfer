<?php

Route::any('/pay/addMoney','Api\MoneyController@addMoney')->middleware('form_android_auth');     // 自动存款接口

Route::any('/pay/budan','Api\MoneyController@budan');      // 自动补单接口 ??

Route::any('/pay/doVerifyUser','Api\MoneyController@doVerifyUser');        // 测试平台会员存在接口

Route::any('/pay/doDeposit','Api\MoneyController@doDeposit');        // 测试平台存款接口

