<?php

Route::any('/pay/addMoney','Api\MoneyController@addMoney')->middleware('form_android_auth');     // 自动存款接口

Route::any('/pay/budan','Api\MoneyController@budan');      // 自动补单接口 ??

Route::any('/pay/test','Api\MoneyController@test');        // 测试接口

