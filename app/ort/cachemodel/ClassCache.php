<?php


namespace App\ort\cachemodel;

use App\Models\Game\Mclass;
use App\Models\Game\Web;
use Illuminate\Support\Facades\Cache;

class ClassCache
{
    const TAG = 'class';

    public static function getcids($cs){
        $cids = Cache::tags(self::TAG)->rememberForever($cs, function () use ($cs) {
            return Mclass::whereIn('cs',explode(';',$cs))->pluck('cid')->toArray();
        });
        return $cids;
    }

    public static function clearSingle($key){
        Cache::tags(self::TAG)->forget($key);
    }

    public static function clearAll(){
        Cache::tags(self::TAG)->flush();
    }
}
