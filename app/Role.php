<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'r_id';
	protected $table = 'roles';
    protected $fillable = [
    	'r_name','desc'
    ];

    //角色和管理员多对多关系
    public function manager()
    {
        return $this->belongsToMany('App\Manager','manager_role','r_id','mg_id')->orderBy('mg_id','asc');
    }

    //角色和权限多对多关系
    public function permission()
    {
        return $this->belongsToMany('App\Permission','role_permission','r_id','p_id')->orderBy('r_id','asc')->withTimestamps();
    }
}
