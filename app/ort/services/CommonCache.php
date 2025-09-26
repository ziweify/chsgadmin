<?php

namespace App\ort\services;

use App\Models\Game\Bclass;
use App\Models\Game\Game;
use App\Models\Game\Mclass;
use App\Models\Game\Play;
use App\Models\Game\Sclass;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CommonCache
{

    const PLAYCACHE = 'playcache';
    const CLASSCACHE = 'classcache';
    const SCLASSCACHE = 'sclasscache';
    const BCLASSCACHE = 'oabclasscache';

    public static function getgamecachebyfast(){
        $list = Cache::get('gamecachebyfast');
        //如果没有数据，就从数据库中获取
        if(empty($list)){
            $list = Game::where(['ifopen'=>1])->select(['cs','stopstatus','autoopenpan','panstatus','cs','thisbml','thisqishu','gid','upqishu','userclosetime'])->orderBy('xsort')->get()->toArray();
        }
        return $list;
    }

    public static function cleargamecachebyfast(){
        Cache::forget('gamecachebyfast');
    }

    //缓存玩法
    public static function getplaycache($gid,$pid){
        $cachekey = 'playcache_'.$gid.'_'.$pid;
        $play = Cache::tags(self::PLAYCACHE)->get($cachekey);
        if(empty($play)){
            $play = Play::where(['gid' => $gid,'pid' => $pid])->select(['name','ztype','znum1','znum2','ptype'])->first();
            //缓存
            Cache::tags(self::PLAYCACHE)->put($cachekey,$play,24*60*90);
        }
        return $play;
    }

    public function clearallplaycache(){
        Cache::tags(self::PLAYCACHE)->flush();
    }

    public static function getclasscache($gid,$cid){
        $cachekey = 'mclasscache_'.$gid.'_'.$cid;
        $mclass = Cache::tags(self::CLASSCACHE)->get($cachekey);
        if(empty($mclass)){
            $mclass = Mclass::where(['gid'=>$gid,'cid'=>$cid])->select(['ftype','dftype','cs','name','mtype'])->first();
            //缓存
            Cache::tags(self::CLASSCACHE)->put($cachekey,$mclass,24*60*90);
        }
        return $mclass;
    }

    public function clearallclasscache(){
        Cache::tags(self::CLASSCACHE)->flush();
    }

    public static function getsclasscache($gid,$sid){
        $cachekey = 'sclasscache_'.$gid.'_'.$sid;
        $sclass = Cache::tags(self::CLASSCACHE)->get($cachekey);
        if(empty($sclass)){
            $sclass = Sclass::where(['gid'=>$gid,'sid'=>$sid])->select(['name'])->first();
            //缓存
            Cache::tags(self::CLASSCACHE)->put($cachekey,$sclass,24*60*90);
        }
        return $sclass;
    }

    public function clearallsclasscache(){
        Cache::tags(self::SCLASSCACHE)->flush();
    }

    public static function getbclasscache($gid,$bid){
        $cachekey = 'bclasscache_'.$gid.'_'.$bid;
        $bclass = Cache::tags(self::BCLASSCACHE)->get($cachekey);
        if(empty($bclass)){
            $bclass = Bclass::where(['gid'=>$gid,'bid'=>$bid])->select(['name'])->first();
            //缓存
            Cache::tags(self::BCLASSCACHE)->put($cachekey,$bclass,24*60*90);
        }
        return $bclass;
    }

    public function clearallbclasscache(){
        Cache::tags(self::BCLASSCACHE)->flush();
    }
}
