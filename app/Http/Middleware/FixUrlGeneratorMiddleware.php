<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class FixUrlGeneratorMiddleware
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
        // 在每个请求开始时修复URL生成器状态
        $this->fixUrlGenerator($request);
        
        return $next($request);
    }
    
    /**
     * 修复URL生成器的状态，防止状态污染
     * 
     * @param Request $request
     * @return void
     */
    private function fixUrlGenerator(Request $request)
    {
        try {
            // 强制重新设置URL生成器的根URL
            $host = $request->getHost();
            $port = $request->getPort();
            $scheme = $request->getScheme();
            
            // 构造根URL
            $rootUrl = $scheme . '://' . $host;
            if (($scheme === 'http' && $port != 80) || ($scheme === 'https' && $port != 443)) {
                $rootUrl .= ':' . $port;
            }
            
            // 强制设置URL根
            URL::forceRootUrl($rootUrl);
            URL::forceScheme($scheme);
            
            /*Log::info('FixUrlGeneratorMiddleware - URL生成器状态已修复', [
                'root_url' => $rootUrl,
                'scheme' => $scheme,
                'host' => $host,
                'port' => $port
            ]);*/
        } catch (\Exception $e) {
            Log::warning('FixUrlGeneratorMiddleware - URL生成器修复失败: ' . $e->getMessage());
        }
    }
} 