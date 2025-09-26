<?php

namespace App\ort\cachemodel;

use App\Models\Game\Game;
use Illuminate\Support\Facades\Cache;

class GameCache
{
    const GAMECACHE = 'gamecache';

    public static function getgamecachebywhere($cachekey,$where){
        $list = Cache::get('gamecacheby'.$cachekey);
        //如果没有数据，就从数据库中获取
        if(empty($list)){
            $list = Game::where($where)->select(['lotCode','cs','mtype','ztype','gid','fast','mnum','fenlei','ifopen','autokj','guanfang','ctype','gname'])->orderBy('xsort')->get()->toArray();
            //缓存
            Cache::tags(self::GAMECACHE)->put($cachekey,$list);
        }
        return $list;
    }

    public static function getgamecache($gid){
        $cachekey = 'gamecache_'.$gid;
        $game = Cache::tags(self::GAMECACHE)->get($cachekey);
        if(empty($game)){
            $game = Game::where(['gid'=>$gid])->select(['lottery','dftype','fenlei'])->first();
            //缓存
            Cache::tags(self::GAMECACHE)->put($cachekey,$game);
        }
        return $game;
    }

    public static function clearallgamecache(){
        Cache::tags(self::GAMECACHE )->flush();
    }
}
