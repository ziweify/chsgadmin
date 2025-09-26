<?php

namespace App\Http\Middleware;

use App\ort\services\DomainCacheService;
use Closure;
use Illuminate\Http\Request;

class ManageAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //查询域名
        $host = $request->getHost();
        $domain = app(DomainCacheService::class)->getCustomDomainBycache($host);
        //向request中注入
        $request->attributes->add(['domain' => $domain]);
        return $next($request);
    }

}
