<?php

namespace App\Providers;

use App\Models\CustomDomain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // 使用 DB::listen() 方法来监听数据库查询
        /*DB::listen(function ($query) {
            // 输出 SQL 查询语句
            $sql = $query->sql;
            // 输出绑定参数
            $bindings = $query->bindings;
            // 使用占位符替换绑定参数
            $sqlWithPlaceholders = vsprintf(str_replace('?', '%s', $sql), $bindings);
            // 输出 SQL 查询语句和绑定参数
            log::info($sqlWithPlaceholders);
        });*/
    }
}
