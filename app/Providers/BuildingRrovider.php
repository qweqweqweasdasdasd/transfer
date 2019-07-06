<?php

namespace App\Providers;

use App\Build\XhuihuangBuilding;
use Illuminate\Support\ServiceProvider;

class BuildingRrovider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // 绑定一个类
        $this->app->bind('\App\Build\Building',function(){
            return new XhuihuangBuilding();
        });

    }
}
