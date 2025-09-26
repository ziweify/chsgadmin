<?php

namespace App\Common\Task;

use App\Models\Game\OutbetAccs;
use App\Models\Game\OutbetSite;
use App\ort\services\FollowPlanService;
use App\ort\sgwin\OutbetServices;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Swoole\Coroutine;

class TaskRunOubet extends CronJob
{
    public function interval(){
        return 800;
    }

    public function isImmediate(){
        return false;
    }

    public static $redis = null;

    public static function getredis(){
        if(self::$redis == null){
            self::$redis = Redis::connection();
        }
        return self::$redis;
    }

    public function runold(){
        Coroutine::create(function (){
            $outbet_redis_key = 'outbet_list';
            $redis = self::getredis();
            $outbetlist = $redis->lrange($outbet_redis_key, 0, -1);
            //删除列表
            $redis->del($outbet_redis_key);
            $maplist = [];
            foreach ($outbetlist as $outbet){
                $json = json_decode($outbet, true);
                $key = 'acc'.$json['acc']['id'].'_lottery'.$json['lottery'].'_issue'.$json['drawNumber'];
                //Log::info('outbet_key:'.$key);
                if(!isset($maplist[$key])){
                    $maplist[$key] = $json;
                }else{
                    $maplistitem = $maplist[$key];
                    $maplistitem['bet'] = array_merge($maplistitem['bet'], $json['bet']);
                    $maplist[$key] = $maplistitem;
                }
                //Log::info('outbet_maplist:'.json_encode($maplist[$key]['bet']));
            }
            foreach ($maplist as $map){
                //开启独立协程
                Coroutine::create(function () use ($map) {
                    (new OutbetServices())->sgbet(json_encode($map));
                });
            }
        });

        $open_follow_outbet = x_config('open_follow_outbet');
        if($open_follow_outbet == 1){
            $redis = self::getredis();
            $follow_redis_key = 'follow_list';
            $followlist = $redis->lrange($follow_redis_key, 0, -1);
            foreach ($followlist as $follow){
                //删除
                $redis->lrem($follow_redis_key, 0, $follow);
                //开启独立协程
                Coroutine::create(function () use ($follow) {
                    (new FollowPlanService())->sgbet($follow);
                });
            }
        }
        //重新入队
        //$redis->rpush($outbet_redis_key, $outbet);
    }

    public function run(){
        $outbet_redis_key = 'outbet_list';
        $redis = self::getredis();
        /*$outbetlist = $redis->lrange($outbet_redis_key, 0, -1);
        foreach ($outbetlist as $outbet){
            //删除
            $redis->lrem($outbet_redis_key, 0, $outbet);
            //开启独立协程
            Coroutine::create(function () use ($outbet) {
                (new OutbetServices())->sgbet($outbet);
            });
        }*/

        //分段飞单查询
        $pre = config('database.redis.options.prefix');
        $keys = $redis->keys('fdlist_*');
        foreach ($keys as $key){
            $key = str_replace($pre,'',$key);
            //Log::info('outbet_key:'.$key);
            $param = explode('_', $key);
            $gid = $param[1];
            $drawNumber = $param[2];
            $siteid = $param[3];
            $accid = $param[4];
            $opentime = $param[5];
            $closetime = $param[6];
            $fenduan = $param[7];
            $lottery = $param[8];

            //分段时间检测
            $cha = $closetime-$opentime;
            $d = floor($cha/$fenduan);
            $t = time();$end = 0;
            for ($i = 1; $i <= $fenduan; $i++){
                if($t <= $opentime+$d*$i){
                    $end = $opentime+$d*$i;
                    break;
                }
            }
            if($end <= 0){
                $end = $closetime;
            }
            //Log::info("cha：".$cha." d:".$d." end:".$end." t:".$t);
            if($t < $end){
                continue;
            }
            //Log::info("{$drawNumber}期满足条件飞单,gid:{$gid},t:{$t},end:{$end},opentime:{$opentime},closetime:{$closetime},siteid:{$siteid},accid:{$accid}");
            //开启独立协程
            Coroutine::create(function () use ($key,$redis,$gid,$drawNumber,$siteid,$accid,$lottery) {
                $res = $redis->lrange($key, 0, -1);
                $redis->del($key);
                $bets = [];
                foreach ($res as $item){
                    $bets =array_merge($bets, json_decode($item, true));
                }
                $site = OutbetSite::where('id', $siteid)->first();
                $acc = OutbetAccs::where('id', $accid)->first();
                if(empty($site) || empty($acc)){
                    Log::info('outbet_site_acc_null');
                    return;
                }
                $param =[];
                $param['site'] = $site;
                $param['acc'] = $acc;
                $param['key'] = $key;
                $param['accid'] = $accid;
                $param['gid'] = $gid;
                $param['bet'] = $bets;
                $param['drawNumber'] = $drawNumber;
                $param['lottery'] = $lottery;
                if($site['bet_mode'] == 1){
                    (new OutbetServices())->sgbet($param,2);
                }elseif($site['bet_mode'] == 2){
                    (new OutbetServices())->sgapibet($param,2);
                }
            });
        }

        //订单模式
        while ($outbet = $redis->lpop($outbet_redis_key)){
            //开启独立协程
            Coroutine::create(function () use ($outbet) {
                $json = json_decode($outbet, true);
                if($json['site']['bet_mode'] == 1) {
                    (new OutbetServices())->sgbet($outbet);
                }elseif($json['site']['bet_mode'] == 2){
                    (new OutbetServices())->sgapibet($outbet);
                }
            });
        }

        $open_follow_outbet = x_config('open_follow_outbet');
        if($open_follow_outbet == 1){
            $follow_redis_key = 'follow_list';
            $followlist = $redis->lrange($follow_redis_key, 0, -1);
            foreach ($followlist as $follow){
                //删除
                $redis->lrem($follow_redis_key, 0, $follow);
                //开启独立协程
                Coroutine::create(function () use ($follow) {
                    (new FollowPlanService())->sgbet($follow);
                });
            }
        }
        //重新入队
        //$redis->rpush($outbet_redis_key, $outbet);
    }
}
