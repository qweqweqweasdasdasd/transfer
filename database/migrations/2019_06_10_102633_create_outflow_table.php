<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outflow', function (Blueprint $table) {
            $table->increments('out_id'); 
            $table->string('username',10)->index()->default('')->comment('会员账号');
            $table->string('money',10)->defaule('')->comment('出款金额');
            $table->string('order_no',60)->index()->default('')->comment('唯一订单号');
            $table->tinyInteger('status')->default('1')->comment('订单状态:1,生成订单');
            $table->tinyInteger('account_type')->default('1')->comment('出款方式:1,支付宝,2,网银银行');
            $table->string('account',60)->defaule('')->nullable()->comment('出款账号');
            $table->string('to_account',60)->defaule('')->comment('出款到用户账号');
            $table->string('desc',250)->default('')->nullable()->comment('备注错误信息');
            $table->engine = 'InnoDB';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outflow');
    }
}
