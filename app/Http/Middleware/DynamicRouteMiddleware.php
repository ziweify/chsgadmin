<?php

namespace App\Http\Middleware;

use App\ort\services\DomainCacheService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DynamicRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 获取由事件监听器设置的域名配置
        $customdomain = $request->get('domain_config');

        // 如果没有域名配置，说明域名未配置
        if(empty($customdomain)){
            $host = $request->getHost();
            $port = $request->getPort();
            $fullHost = $host;
            if(filter_var($host, FILTER_VALIDATE_IP) && $port != 80 && $port != 443){
                $fullHost = $host.':'.$port;
            }
            $dm = env("domain_mode",0);
            if($dm == 1){
                //本地开发不适用swoole，兼容写法
                $customdomain = DomainCacheService::getCustomDomainBycache($fullHost);
                if(!empty($customdomain)){
                    // 在请求中设置域名配置信息
                    $request->merge(['domain_config' => $customdomain]);
                    // 根据域名类型设置路由类型
                    switch($customdomain['type']){
                        case 3: // 管理端
                            $request->merge(['route_type' => 'manage']);
                            break;
                        case 4: // 代理端
                            $request->merge(['route_type' => 'agent']);
                            break;
                        case 5: // 会员端
                            $request->merge(['route_type' => 'api']);
                            break;
                    }
                }
            }else{
                return response()->json([
                    'error' => '域名未配置',
                    'domain' => $fullHost
                ], 404);
            }
        }
        
        /*Log::info('DynamicRoute - 中间件验证开始', [
            'domain_type' => $customdomain['type'],
            'route_type' => $request->get('route_type'),
            'uri' => $request->getRequestUri(),
            'time' => microtime(true)
        ]);*/
        
        // 继续处理请求
        $response = $next($request);
        
        // 在响应后验证路由是否匹配
        $route = $request->route();
        if ($route) {
            $namespace = $route->getAction('namespace');
            $allowedNamespace = '';
            
            // 根据域名类型确定允许的命名空间
            switch($customdomain['type']){
                case 3: // 管理端
                    $allowedNamespace = 'App\Http\Controllers\Manage';
                    break;
                case 4: // 代理端
                    $allowedNamespace = 'App\Http\Controllers\Agent';
                    break;
                case 5: // 会员端
                    $allowedNamespace = 'App\Http\Controllers\Api';
                    break;
            }
            
            // 检查命名空间是否匹配
            if($namespace !== $allowedNamespace){
                /*Log::warning('DynamicRoute - 路由命名空间不匹配', [
                    'type' => $customdomain['type'],
                    'expected_namespace' => $allowedNamespace,
                    'actual_namespace' => $namespace,
                    'uri' => $request->getRequestUri()
                ]);*/
                return response()->json([
                    'error' => '路由不匹配',
                    'type' => $customdomain['type'],
                    'expected' => $allowedNamespace,
                    'actual' => $namespace
                ], 403);
            }
        }
        
        /*Log::info('DynamicRoute - 中间件验证完成', [
            'type' => $customdomain['type'],
            'namespace' => $namespace ?? 'unknown',
            'time' => microtime(true)
        ]);*/
        
        return $response;
    }
} 