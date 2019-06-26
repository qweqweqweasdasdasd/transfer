<?php
/**
 * 后台管理路由
 */

Route::get('/login','Admin\LoginController@index');             //后台管理--登录显示
Route::post('/login','Admin\LoginController@login')->name('login');      //后台管理--登录逻辑
Route::get('/logout','Admin\LoginController@logout');           //后台管理--退出登录


//RBAC 权限鉴定(当前管理员是否)
Route::group(['middleware' => ['auth:admin','RBAC']],function(){
    
    Route::get('/index','Admin\IndexController@index');             //后台管理--后台主页
    Route::get('/welcome','Admin\IndexController@welcome');         //后台管理--欢迎页面

    Route::resource('/manager','Admin\ManagerController');          //后台管理--管理员路由
    Route::post('/reset','Admin\ManagerController@reset');          //后台管理--管理员状态
    Route::match(['get','post'],'/allocation/{manager?}','Admin\ManagerController@allocation'); //后台管理--角色分配
    
    Route::get('/password','Admin\ManagerController@password');      //后台管理--管理员统一密码
    Route::post('/password','Admin\ManagerController@dopassword');   //后台管理--重置密码
    
    Route::resource('/role','Admin\RoleController');                //后台管理--角色路由
    Route::match(['get','post'],'/role/permission/{role?}','Admin\RoleController@allocation');   //后台管理--权限分配
    
    Route::resource('/permission','Admin\PermissionController');    //后台管理--权限路由

    Route::resource('/outflow','Admin\OutflowController');          //后台管理--出款订单(流出)
});


