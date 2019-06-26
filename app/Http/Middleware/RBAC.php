<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Permission;

class RBAC
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取到当前用户的信息
        $manager = Auth::guard('admin')->user();

        //编辑管理员下面所有角色,角色下面所有的权限,组装为数组
        $data = $d = [];
        foreach($manager->roles as $k=>$r){
            $d[$k] = $r->permission->toArray(); 
            foreach(array_collapse($d) as $k=>$v){
                //空的不验证
                if(!empty($v['rule'])){
                    $data[$k] = $v['rule'];
                }
            }
        }

        //获取到不需要验证的权限添加到数组内
        $allowPermission = Permission::where('check',2)->get();
        if(count($allowPermission)){
            foreach ($allowPermission as $k => $v) {
                //$allow[$k] = $v['rule']; 
                array_push($data,$v['rule']);
            }
        }
        $nowCa = strtolower(getCurrentControllerName().'-'.getCurrentMethodName());
        //删除重复的数值切换为字符串
        $ps_ca = implode(',',array_unique($data));
        //dump($ps_ca,$nowCa);     
        
        if(strpos($ps_ca,$nowCa) === false){
            exit('没有权限!');
        }
        return $next($request);
    }
}
