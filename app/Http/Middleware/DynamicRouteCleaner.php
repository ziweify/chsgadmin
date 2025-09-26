<?php

namespace App\Http\Middleware;

use Hhxsv5\LaravelS\Illuminate\Cleaners\BaseCleaner;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class DynamicRouteCleaner extends BaseCleaner
{
    public function clean()
    {
        // 清理每个请求后的状态
        //Log::info('DynamicRouteCleaner - 清理请求状态');
        
        // 清理URL生成器的状态，防止状态污染
        try {
            // 在Swoole环境下，检查是否有有效的请求上下文
            if (app()->bound('request') && app('request') !== null) {
                URL::forceRootUrl(null);
                URL::forceScheme(null);
                //Log::info('DynamicRouteCleaner - URL生成器状态已清理');
            } else {
                // 在没有请求上下文时，直接重置URL生成器实例
                app()->forgetInstance('url');
                //Log::info('DynamicRouteCleaner - URL生成器实例已重置');
            }
        } catch (\Exception $e) {
            //Log::warning('DynamicRouteCleaner - URL生成器清理失败: ' . $e->getMessage());
            // 如果出错，尝试重置实例
            try {
                app()->forgetInstance('url');
                //Log::info('DynamicRouteCleaner - URL生成器实例强制重置');
            } catch (\Exception $resetException) {
                Log::error('DynamicRouteCleaner - URL生成器重置也失败: ' . $resetException->getMessage());
            }
        }
        
        // 这里可以添加需要清理的内容
        // 例如清理静态变量、单例状态等
        
        // 强制清理可能的缓存
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        // 清理内存缓存
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
    }
} 