<?php

//公用状态修改函数方法
function CommonResetStatus($mgID,$code)
{
    switch ($code) {
        case '1':
            return '<input class="btn btn-warning radius size-MINI reset" data-status="2" data-id="'.$mgID.'" type="button" value="关闭">';
        case '2':
            return '<input class="btn btn-default radius size-MINI reset" data-status="1" data-id="'.$mgID.'" type="button" value="开启">';  
    }
}

//公用状态显示
function CommonStatusShow($code)
{
    switch($code){
        case '1':
            return '<span class="label label-success radius">TRUE</span>';
        case '2':
            return '<span class="label label-default radius">FALSE</span>'; 
    }
}

//存款订单状态显示
function CommonDepositStatus($code)
{
    switch($code){
        case '1':
            return '<span class="label label-default radius">支付成功</span>';
        case '2':
            return '<span class="label label-warning radius">账号无效</span>'; 
        case '3':
            return '<span class="label label-danger radius">请求上分接口中</span>';
        case '4';
            return '<span class="label label-success radius">上分成功</span>';
        case '5';
            return '<span class="label label-success ondary radius">补单成功</span>';
        case '6';
            return '<span class="label label-danger  radius">不明原因失败</span>';
        case '7';
            return '<span class="label label-danger  radius">接口服务器错误</span>';
        case '8';
            return '<span class="label label-danger  radius">上分失败</span>';
        case '9';
            return '<span class="label label-success  radius">账号有效</span>';
    }
}

//出款订单状态显示
function OutflowStatusShow($code)
{
    switch($code){
        case '1':
            return '<span class="label label-default radius">生成订单</span>';
        case '2':
            return '<span class="label label-warning radius">请求失败</span>'; 
        case '3':
            return '<span class="label label-danger radius">转账失败</span>';
        case '4';
            return '<span class="label label-success radius">转账成功</span>';
        case '5';
            return '<span class="label label-secwarning ondary radius">次要</span>';
        case '6';
            return '<span class="label label-danger  radius">次要</span>';
    }
}

//出款方式显示
function OutflowWayStatus($code)
{
    switch ($code) {
        case '1':
            return '<span class="label label-primary radius">支付宝</span>';
        case '2':
            return '<span class="label label-secondary radius">网银</span>'; 
    }
}

/**
 * 递归方式获取上下级权限信息
 */
function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['p_id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['pid']])){
            $items[$item['pid']]['son'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return getTreeData($tree);
}
function getTreeData($tree,$level=0){
    static $arr = array();
    foreach($tree as $t){
        $tmp = $t;
        unset($tmp['son']);
        //$tmp['level'] = $level;
        $arr[] = $tmp;
        if(isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}

/**
 * 获取当前控制器名
 */
function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}
/**
 * 获取当前方法名
 */
function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}
/**
 * 获取当前控制器与操作方法的通用函数
 */
function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    //dd($action);exit;
    //dd($action);
    list($class, $method) = explode('@', $action);
    //$classes = explode(DIRECTORY_SEPARATOR,$class);
    $class = str_replace('Controller','',substr(strrchr($class,DIRECTORY_SEPARATOR),1));
    return ['controller' => $class, 'method' => $method];
}