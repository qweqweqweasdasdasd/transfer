<?php

namespace App\Repositories;

use DB;
use App\Role;
use Illuminate\Database\QueryException;

class RoleRepository extends BaseRepository
{
    //构造函数
    public function __construct()
    {
        $this->table = 'roles';
        $this->id = 'r_id';
    }

    //获取到指定角色
    public function roleFind($id)
    {
        return Role::with('permission')->find($id);    
    }

    //分配权限同步中间表
    public function rolePermissionSync($id,$data)
    {
        $role = Role::find($id);
        
        return $role->permission()->sync($data);
    }

    //mysql 引擎 使用的innodb mysam 不支持
    public function RoleDelete($id)
    {
        DB::beginTransaction();
        try {
            //删除中间表角色的数据
            DB::table('manager_role')->where('r_id',$id)->delete(); 
            //删除角色数据
            DB::table('roles')->where('r_id',$id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
       return true;
    }

    //获取到所有的角色
    public function GetRoles()
    {
        return Role::with('manager')->orderBy('r_id','asc')->get();
    }

    //获取到角色的数量
    public function GetCount()
    {
        return Role::count();
    }
}
