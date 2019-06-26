<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('p_id');
            $table->string('p_name',20)->default('')->comment('权限菜单名称');
            $table->string('route', 64)->nullable()->comment('路由');
            $table->string('rule', 64)->nullable()->comment('控制器方法');
            $table->integer('pid')->default(0)->comment('父级id');
            $table->tinyInteger('check')->default(1)->comment('是否需要验证');
            $table->tinyInteger('status')->default(0)->comment('是否显示:1,启用,2,关闭');
            $table->tinyInteger('level')->default(0)->comment('权限层级:0,顶级1,一级权限,2,二级权限');;
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
        Schema::dropIfExists('permissions');
    }
}
