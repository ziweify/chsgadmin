<?php

namespace App\ort\sgwin;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class UserOnline
{
    //获取前缀
    public static function getPrefix(){
        return config('database.redis.options.prefix');
    }

    public static function setUserOnlineInfo($online_data){
        $key = 'user_online:' . $online_data['userid'];
        Redis::hmset($key, $online_data);
        //Redis::expire($key, $s); // 设置过期时间，例如1小时
    }

    public static function getUserOnlineInfo($userid)
    {
        $key = 'user_online:' . $userid;
        return Redis::hgetall($key);
    }

    public static function deleteUserOnlineInfo($userid)
    {
        $key = 'user_online:' . $userid;
        Redis::del($key);
    }

    public static function deleteUserOnlinebyuserids($userids){
        foreach ($userids as $userid) {
            $key = 'user_online:' . $userid;
            Redis::del($key);
        }
    }

    public static function getOnlineUsers($xtype = null, $perPage = 10, $page = 1,$notuseridarray = [])
    {
        $onlineUsersKeyPattern = 'user_online:*';
        $keys = Redis::keys($onlineUsersKeyPattern);
        $onlineUsers = [];
        foreach ($keys as $key) {
            $key = str_replace(self::getPrefix(),'',$key);
            $user = Redis::hgetall($key);
            if($user && !isset($user['xtype'])){
                //删除
                Redis::del($key);
                continue;
            }
            if ($xtype === null || $user['xtype'] == $xtype && !in_array($user['userid'],$notuseridarray)) {
                $onlineUsers[] = $user;
            }
        }
        return self::paginate($onlineUsers, $perPage, $page);
    }

    public static function getAllOnlines($livetime){
        $onlineUsersKeyPattern = 'user_online:*';
        $keys = Redis::keys($onlineUsersKeyPattern);
        $arr1 = [];
        foreach ($keys as $key) {
            $key = str_replace(self::getPrefix(),'',$key);
            $user = Redis::hgetall($key);
            if($user && !isset($user['xtype'])){
                //删除
                Redis::del($key);
                continue;
            }
            if($user && $user['savetime'] < $livetime){
                $arr1[] = $user;
            }
        }
        return $arr1;
    }

    public static function getAllUserid(){
        $onlineUsersKeyPattern = 'user_online:*';
        $keys = Redis::keys($onlineUsersKeyPattern);
        $arr1 = [];
        foreach ($keys as $key) {
            $key = str_replace(self::getPrefix(),'',$key);
            $user = Redis::hgetall($key);
            if($user && !isset($user['xtype'])){
                //删除
                Redis::del($key);
                continue;
            }
            if($user && isset($user['userid']))
            $arr1[] = $user['userid'];
        }
        return $arr1;
    }

    private static function paginate($items, $perPage = 10, $page = 1, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public static function updateUserOnline($userid, $update,$s){
        $key = 'user_online:' . $userid;
        //判断是否存在，不存在则不更新
        $f =  Redis::exists($key);
        if($f){
            foreach ($update as $k => $v) {
                Redis::hset($key, $k, $v);
            }
            //设置过期时间一个月
            Redis::expire($key, 2592000);
        }
    }

    //更新loginipid
    public static function updateUserOnlineLoginIpId($userid, $loginipid){
        $key = 'user_online:' . $userid;
        $f =  Redis::exists($key);
        if($f)
        Redis::hset($key, 'loginipid', $loginipid);
    }

    public static function countOnlineUsersByType($xtype,$notuseridarray = []){
        $onlineUsersKeyPattern = 'user_online:*';
        $keys = Redis::keys($onlineUsersKeyPattern);
        $count = 0;
        foreach ($keys as $key) {
            $key = str_replace(self::getPrefix(),'',$key);
            $user = Redis::hgetall($key);
            if(!isset($user['userid']) || !isset($user['xtype'])){
                //删除
                Redis::del($key);
                continue;
            }
            if ($user && $user['xtype'] == $xtype && !in_array($user['userid'],$notuseridarray)) {
                $count++;
            }
        }
        return $count;
    }

    public static function countOnlineUsers($notuseridarray = []){
        $onlineUsersKeyPattern = 'user_online:*';
        $keys = Redis::keys($onlineUsersKeyPattern);
        $count = 0;
        foreach ($keys as $key) {
            $key = str_replace(self::getPrefix(),'',$key);
            $user = Redis::hgetall($key);
            if(!isset($user['userid'])){
                //删除
                Redis::del($key);
                continue;
            }
            if ($user && !in_array($user['userid'],$notuseridarray)) {
                $count++;
            }
        }
        return $count;
    }

    public static function isonlie($userid){
        $key = 'user_online:' . $userid;
        $f =  Redis::exists($key);
        if($f){
            return 1;
        }else{
            return 0;
        }
    }

    public static function getallipbyxtype($xtype,$notuseridarray = []){
        $onlineUsersKeyPattern = 'user_online:*';
        $keys = Redis::keys($onlineUsersKeyPattern);
        $list = [];
        foreach ($keys as $key) {
            $key = str_replace(self::getPrefix(),'',$key);
            $user = Redis::hgetall($key);
            if(!isset($user['userid']) || !isset($user['xtype'])){
                //删除
                Redis::del($key);
                continue;
            }
            if ($user && $user['xtype'] == $xtype && !in_array($user['userid'],$notuseridarray)) {
                $list[] = $user['ip'];
            }
        }
        return $list;
    }
}
