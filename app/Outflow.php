<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outflow extends Model
{
    protected $primaryKey = 'out_id';
	protected $table = 'outflow';
    protected $fillable = [
    	'username','money','order_no','status','payout','account','to_account','desc'
    ];
}
