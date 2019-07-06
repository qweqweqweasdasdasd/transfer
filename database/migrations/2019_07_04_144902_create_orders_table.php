<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('type',10)->nullable()->default('')->comment('wechat||alipay');
            $table->string('order_no',100)->index()->default('')->comment('支付订单号');
            $table->string('money',100)->default('')->comment('支付金额');
            
            $table->string('mark',100)->nullable()->default('')->comment('会员账号');
            $table->string('dt',20)->nullable()->default('')->comment('订单时间');
            $table->string('mch_id',20)->nullable()->default('')->comment('微信支付分配的商户号');
            $table->string('shopId',20)->nullable()->default('')->comment('shopId');
            $table->string('account',20)->nullable()->default('')->comment('本机手机号');
            $table->tinyInteger('status')->default('1')->comment('订单状态: 1,支付成功 2,账号无效(会员) 3,请求上分接口中 4,上分成功 5,补单成功 6,不明原因失败');
            $table->text('desc')->nullable()->comment('备注');
            
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
        Schema::dropIfExists('orders');
    }
}
