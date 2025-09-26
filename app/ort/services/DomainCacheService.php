<?php

namespace App\ort\services;

use App\Models\CustomDomain;
use Illuminate\Support\Facades\Cache;

class DomainCacheService
{

    protected const TAG = 'domain_cache';

    /**
     * 缓存域名并获取域名
     * @return mixed
     */
    public static function getCustomDomainBycache($host){
        $pre = 'host_';
        $key = $pre.$host;
        //先从缓存中获取
        $domain = Cache::tags(self::TAG)->get($key);
        if($domain){
            return $domain;
        }
        //从数据库中获取
        $domain = CustomDomain::where(['domain'=>$host,'status'=>1])->first(['id','domain','type']);
        if(empty($domain)){
            return [];
        }
        $domain = $domain->toArray();
        //缓存到redis
        Cache::tags(self::TAG)->put($key, $domain, 60 * 60 * 24);
        return $domain;
    }

    /**
     * 清除域名缓存
     * @return void
     */
    public static function clearCustomDomainCache($host){
        //$host = request()->getHost();
        Cache::tags(self::TAG)->forget($host);
    }

    /**
     * 清理所有域名缓存
     * @return void
     */
    public static function clearAllCustomDomainCache(){
        Cache::tags(self::TAG)->flush();
    }
}
