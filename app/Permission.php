<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = 'p_id';
	protected $table = 'permissions';
    protected $fillable = [
    	'p_name','route','rule','pid','check','status','level'
    ];
}
