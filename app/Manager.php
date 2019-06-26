<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    protected $primaryKey = 'mg_id';
	protected $table = 'managers';
    protected $fillable = [
    	'mg_name','password','ip','login_counts','status','last_login_time','sesstion_id'
    ];
    protected $rememberTokenName = '';

    //管理员和角色多对多的关系
    public function roles()
    {
        return $this->belongsToMany('App\Role','manager_role','mg_id','r_id')->withTimestamps();
    }

    //scope使用
    public function scopeWork($query)
    {
        return $query->where('status',1)->orderBy('mg_id','asc');
    }
}
