<?php

namespace App\Repositories;

use DB;
use Hash;
use App\Manager;
use Illuminate\Database\QueryException;

class ManagerRepository extends BaseRepository
{
    //构造函数
    public function __construct()
    {
        $this->table = 'managers';
        $this->id = 'mg_id';
    }

    //创建管理员数据
    public function ManagerSave($d)
    {
        $d = [
            'mg_name' => $d['mg_name'],
            'password' => $this->HashString($d['password']),
            'status' => $d['status']
        ];

        return $this->CommonSave($d);
    }

    //使用模型获取到一条管理员数据
    public function ManagerFind($id)
    {
        return Manager::with('roles')->find($id);
    }

    //管理员删除--中间表数据删除
    public function ManagerDelete($id)
    {
        DB::beginTransaction();
        try {
            //删除中间表数据
            DB::table('manager_role')->where('mg_id',$id)->delete();
            //删除管理员数据
            DB::table('managers')->where('mg_id',$id)->delete();
            DB::commit();
        } catch (\QueryException $ex) {
            DB::rollback();
            return false;
        }
        return true;
    }

    //管理员分配角色保存数据
    public function ManagerAttach($id,$d)
    {
        $manager = $this->ManagerFind($id);
        
        return $manager->roles()->sync($d['r_ids']);
    }

    //重置密码
    public function dopassword($d)
    {
        $d['password'] =  $this->HashString($d['password']);

        return $this->CommonUpdate($d['mg_id'],$d);
    }

    //工作中的管理员
    public function WorkManagers()
    {
        return json_decode(Manager::work()->pluck('mg_name','mg_id'),true);
    }

    //获取到所有的数据
    public function GetManagers()
    {
        return Manager::with('roles')->orderBy('mg_id','asc')->get();
    }

    //获取到管理员总数
    public function GetCount()
    {
        return Manager::count();
    }

    //生成哈希密码
    public function HashString($string)
    {
        return Hash::make($string);
    }
}
