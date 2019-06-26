<?php
namespace App\Repositories;

use DB;

class BaseRepository 
{
    //公共更新方法
    public function CommonUpdate($id,$data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s',time());
        
        return !!(DB::table($this->table)->where($this->id,$id)->update($data));
    }

    //公共创建方法
    public function CommonSave($d)
    {
        $d['created_at'] = date('Y-m-d H:i:s',time());
        
        return !!(DB::table($this->table)->insert($d));
    }

    //公共方法获取一条数据
    public function CommonFirst($id)
    {
        return DB::table($this->table)->where($this->id,$id)->first();
    }

    //公共方法删除指定数据
    public function CommonDelete($id)
    {
        return DB::table($this->table)->where($this->id,$id)->delete();
    }

    //获取当前的模型
    public function getCurrentPathInfo()
    {
        $class = strtolower($this->getCurrentAction()['class']);
        $method = $this->getCurrentAction()['method'];
        $list = str_replace('controller','',explode('\\',$class));
        
        return ['model'=>$list[3],'controller'=>$list[4],'method'=>$method];
    }
    //获取到当前控制器和方法
    public function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        
        return ['class'=>$class,'method'=>$method];
    }
}
