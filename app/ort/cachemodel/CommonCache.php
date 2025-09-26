<?php


namespace App\ort\cachemodel;

use App\Models\Game\Bclass;
use App\Models\Game\Game;
use App\Models\Game\Mclass;
use App\Models\Game\Play;
use App\Models\Game\Sclass;
use App\Models\Game\Web;
use Illuminate\Support\Facades\Cache;

class CommonCache
{
    const TAG = 'sgcommon';
    const PLAYCACHE = 'sgplaycache';
    const CLASSCACHE = 'sgclasscache';
    const SCLASSCACHE = 'sgsclasscache';
    const BCLASSCACHE = 'sgbclasscache';

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
            $play = Play::where(['gid' => $gid,'pid' => $pid])->select(['name','ztype','znum1','znum2','ptype','cy'])->first();
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

    public static function transbclass($gid,$field,$bid){
        $key = "transbclass_{$gid}_{$field}_{$bid}";
        $data = Cache::tags(self::TAG)->rememberForever($key, function () use ($gid,$field,$bid) {
            return Bclass::where(['gid' => $gid, 'bid' => $bid])->value($field);
        });
        return $data;
    }

    public static function transsclass($gid,$field,$sid){
        $key = "transsclass_{$gid}_{$field}_{$sid}";
        $data = Cache::tags(self::TAG)->rememberForever($key,function() use ($gid,$field,$sid) {
            return Sclass::where(['gid'=>$gid,'sid'=>$sid])->value($field);
        });
        return $data;
    }

    public static function transmclass($gid,$field,$cid){
        $key = "transmclass_{$gid}_{$field}_{$cid}";
        $data = Cache::tags(self::TAG)->rememberForever($key,function() use ($gid,$field,$cid) {
            return Mclass::where(['gid'=>$gid,'cid'=>$cid])->value($field);
        });
        return $data;
    }

    public static function transplay($gid,$field,$pid){
        $key = "transplay_{$gid}_{$field}_{$pid}";
        $data = Cache::tags(self::TAG)->rememberForever($key,function() use ($gid,$field,$pid) {
            return Play::where(['gid'=>$gid,'pid'=>$pid])->value($field);
        });
        return $data;
    }

    public static function transgame($gid,$field){
        $key = "transgame_{$gid}_{$field}";
        $data = Cache::tags(self::TAG)->rememberForever($key,function() use ($gid,$field) {
            return Game::where(['gid'=>$gid])->value($field);
        });
        return $data;
    }

    public static function clearSingle($key){
        Cache::tags(self::TAG)->forget($key);
    }

    public static function clearAll(){
        Cache::tags(self::TAG)->flush();
    }

    public static function getplaybyts1($gid,$cid,$name){
        $key = "getplaybyts1_{$gid}_{$cid}_{$name}";
        $data = Cache::tags(self::PLAYCACHE)->rememberForever($key,function() use ($gid,$cid,$name) {
            return Play::where(['gid'=>$gid,'cid'=>$cid,'name'=>$name])->select(['pid','cy'])->first();
        });
        return $data;
    }

    public static function getplaybyts2($gid,$cid,$pid){
        $key = "getplaybyts2_{$gid}_{$cid}_{$pid}";
        $data = Cache::tags(self::PLAYCACHE)->rememberForever($key,function() use ($gid,$cid,$pid) {
            return Play::where(['gid'=>$gid,'cid'=>$cid])->where('pid','<>',$pid)->orderBy('pid')->select(['pid','cy'])->first();
        });
        return $data;
    }
}
