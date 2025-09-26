<?php

namespace App\Providers;

use App\Models\CustomDomain;
use App\ort\services\DomainCacheService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        //$this->configureRateLimiting();//
        // 在Swoole内存模式下，预先注册所有路由，使用全局中间件控制访问
        $this->routes(function () {
            // 管理端路由 - 全局中间件已处理域名验证
            Route::middleware(['web', 'cors'])
                ->namespace('App\Http\Controllers\Manage')
                ->group(base_path('routes/manage.php'));
            
            // 代理端路由 - 全局中间件已处理域名验证
            Route::middleware(['web', 'cors'])
                ->namespace('App\Http\Controllers\Agent')
                ->group(base_path('routes/agent.php'));
            
            // 会员端路由 - 全局中间件已处理域名验证
            Route::middleware(['cors'])
                ->namespace('App\Http\Controllers\Api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
