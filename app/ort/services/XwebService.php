<?php


namespace App\ort\services;

use App\Models\Game\Web;
use Illuminate\Support\Facades\Cache;

class XwebService
{
    const TAG = 'xweb';

    public static function get(string $key, $default = '', bool $isCaChe = false){
        if($isCaChe == true){
            return Web::value($key);
        }
        $value = Cache::tags(self::TAG)->rememberForever($key, function () use ($key) {
            return Web::value($key);
        });
        if($value == null || $value == ''){
            return $default;
        }
        return $value;
    }

    public static function clearSingle($key){
        Cache::tags(self::TAG)->forget($key);
    }

    public static function clearAll(){
        Cache::tags(self::TAG)->flush();
    }
}
