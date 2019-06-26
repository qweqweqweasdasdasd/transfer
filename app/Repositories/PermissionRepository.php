<?php

namespace App\Repositories;

use App\Permission;

class PermissionRepository extends BaseRepository
{
    //构造函数
    public function __construct()
    {
        $this->table = 'permissions';
        $this->id = 'p_id';
    }

    //获取数据
    public function getPermission()
    {
        return Permission::orderBy('p_id','asc')->get()->toArray();
    }

    //获取到权限列表(1,2,3)
    public function byPermissionWithLevel($l = 1)
    {
        return Permission::where('level',$l)->get();
    }

    //权限总数
    public function getCount()
    {
        return Permission::count();
    }

    //判断权限是否有子权限
    public function existNotSon($p_id)
    {
        return !(Permission::where('pid',$p_id)->count());
    }

    //添加层级数据
    public function dataAddLevel($d)
    {
        //根据pid设置level数值

        $data = [
            'p_name' => $d['p_name'],
            'route' => !is_null($d['route'])?trim($d['route']):'',
            'rule' => !is_null($d['rule'])?trim($d['rule']):'',
            'pid' => $d['pid'],
            'check' => $d['check'],
            'status' => $d['status'],
            'level' => $this->setLevel($d['pid'])
        ];

        return $data;
    }

    //根据pid设置level数值
    protected function setLevel($pid)
    {
        //如果pid是0 level==1 如果pid不是0 查询pid数据level+1
        if($pid){
            return (string)(Permission::where('p_id',$pid)->value('level') + 1);
        }
        return '1';
    }
}
