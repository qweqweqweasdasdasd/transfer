<?php
/**
 * 后台管理路由
 */

Route::get('/login','Admin\LoginController@index');                      //后台管理--登录显示
Route::post('/login','Admin\LoginController@login')->name('login');      //后台管理--登录逻辑
Route::get('/logout','Admin\LoginController@logout');                    //后台管理--退出登录


//RBAC 权限鉴定(当前管理员是否)
Route::group(['middleware' => ['auth:admin','RBAC']],function(){
    
    Route::get('/index','Admin\IndexController@index');             //后台管理--后台主页
    Route::get('/welcome','Admin\IndexController@welcome');         //后台管理--欢迎页面

    Route::resource('/manager','Admin\ManagerController',['except'=>'show']);                   //后台管理--管理员路由
    Route::post('/reset','Admin\ManagerController@reset');                                      //后台管理--管理员状态
    Route::match(['get','post'],'/allocation/{manager?}','Admin\ManagerController@allocation'); //后台管理--角色分配
    
    Route::get('/password','Admin\ManagerController@password');      //后台管理--管理员密码修改
    Route::post('/password','Admin\ManagerController@dopassword');   //后台管理--管理员密码修改
    
    Route::resource('/role','Admin\RoleController',['except'=>'show']);                          //后台管理--角色路由
    Route::match(['get','post'],'/role/permission/{role?}','Admin\RoleController@allocation');   //后台管理--权限分配
    
    Route::resource('/permission','Admin\PermissionController',['except'=>'show']);              //后台管理--权限路由

    Route::resource('/order','Admin\OrderController',['except'=>'show']);                        //后台管理--自动存款订单


    //Route::resource('/category','Admin\CategoryController',['except'=>'show']);                //后台管理--分类路由

    Route::resource('/wallet','Admin\WalletController',['except'=>'show']);                      //后台管理--钱包管理

    //Route::resource('/outflow','Admin\OutflowController');          //后台管理--出款订单(流出)
});


