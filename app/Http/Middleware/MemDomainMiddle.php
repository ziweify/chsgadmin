<?php

namespace App\Http\Middleware;

use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\ort\services\DomainCacheService;
use App\ort\sgwin\Json;
use App\ort\sgwin\UserOnline;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemDomainMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        // 查询数据库以确定要使用的域名
        $host = $request->getHost();
        $port = $request->getPort();
        if(filter_var($host, FILTER_VALIDATE_IP) && $port != 80){
            $host = $host.':'.$port;
        }
        $domainCacheService = app(DomainCacheService::class);
        $domain = $domainCacheService->getCustomDomainBycache($host,5);
        if (empty($domain)) {
            return response('',401);
        }
        return $next($request);
    }
}
