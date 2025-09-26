<?php

namespace App\Listeners;

use App\ort\services\DomainCacheService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class DynamicRouteListener
{
    public function handle($event)
    {
        $request = $event[0] ?? $event;
        
        // 获取请求的域名和端口
        $host = $request->getHost();
        $port = $request->getPort();
        
        // 构造完整的域名或IP:端口格式
        $fullHost = $host;
        if(filter_var($host, FILTER_VALIDATE_IP) && $port != 80 && $port != 443){
            $fullHost = $host.':'.$port;
        }
        
        //Log::info('DynamicRouteListener - 处理请求: '.$fullHost);
        
        // 使用缓存服务查询域名配置
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
            
            /*Log::info('DynamicRouteListener - 域名配置已设置', [
                'domain' => $fullHost,
                'type' => $customdomain['type'],
                'route_type' => $request->get('route_type')
            ]);*/
        }
    }
} 