<?php

namespace App\Providers;

use App\ort\services\DomainCacheService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

//use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class DomainProxyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $host = request()->getHost();
        $port = request()->getPort();
        if(filter_var($host, FILTER_VALIDATE_IP) && $port != 80){
            $host = $host.':'.$port;
        }
        $domainCacheService = app(DomainCacheService::class);
        $customDomain = $domainCacheService->getCustomDomainBycache($host);
        $maindomain = env('ADMIN_ROUTE_DOMAIN');
        if(!empty($customDomain) && $customDomain->type == 2){//开奖网主站
            Route::namespace('App\Http\Controllers\Kjw')
                ->group(base_path('routes/kjw.php'));
        }elseif((!empty($customDomain) && $customDomain->type == 3) || $host == $maindomain){//管理端域名
            Route::middleware(['web'])
                ->namespace('App\Http\Controllers\Manage')
                ->group(base_path('routes/manage.php'));
        }elseif (!empty($customDomain) && $customDomain->type == 5){//会员端域名
            Route::namespace('App\Http\Controllers\Member')
                ->group(base_path('routes/member.php'));
        }elseif (!empty($customDomain) && $customDomain->type == 4) {//代理端域名
            Route::middleware(['web'])
                ->namespace('App\Http\Controllers\Agent')
                ->group(base_path('routes/agent.php'));
        }
    }
}
