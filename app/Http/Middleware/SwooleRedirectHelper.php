<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SwooleRedirectHelper
{
    /**
     * 安全的重定向处理，适用于Swoole环境
     * 
     * @param Request $request
     * @param string $path
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function safeRedirect(Request $request, $path)
    {
        // 获取当前请求的基本信息
        $host = $request->getHost();
        $port = $request->getPort();
        $scheme = $request->getScheme();
        
        // 构造完整的域名
        $fullHost = $host;
        if (($scheme === 'http' && $port != 80) || ($scheme === 'https' && $port != 443)) {
            $fullHost = $host . ':' . $port;
        }
        
        // 构造完整的URL
        $baseUrl = $scheme . '://' . $fullHost;
        
        // 确保路径以/开头
        if (!Str::startsWith($path, '/')) {
            $path = '/' . $path;
        }
        
        $redirectUrl = $baseUrl . $path;
        
        // 记录调试信息
        Log::info('SwooleRedirectHelper - Safe redirect', [
            'original_path' => $path,
            'host' => $host,
            'port' => $port,
            'scheme' => $scheme,
            'full_host' => $fullHost,
            'base_url' => $baseUrl,
            'final_url' => $redirectUrl
        ]);
        
        return redirect($redirectUrl);
    }
    
    /**
     * 修复URL生成器的状态，防止状态污染
     * 
     * @param Request $request
     * @return void
     */
    public static function fixUrlGenerator(Request $request)
    {
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
        
        Log::info('SwooleRedirectHelper - URL generator fixed', [
            'root_url' => $rootUrl,
            'scheme' => $scheme
        ]);
    }
} 