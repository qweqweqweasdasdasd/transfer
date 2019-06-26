<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->increments('mg_id')->comment('管理员id');
            $table->string('mg_name',10)->unique()->default('')->comment('管理员名称');
            $table->string('password',100)->default('')->comment('管理员密码');
            $table->string('ip')->default('')->nullable()->comment('登录ip');
            $table->integer('login_counts')->default('0')->nullable()->comment('登录次数');
            $table->tinyInteger('status')->default('1')->comment('管理员状态 1 正常 2 停用');
            $table->timestamp('last_login_time')->nullable()->comment('管理员最后登录时间');
            $table->string('sesstion_id',200)->default('')->nullable()->comment('sso单用户登录');
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
        Schema::dropIfExists('managers');
    }
}
