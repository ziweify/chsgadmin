<?php

namespace App\ort\services;

use App\Models\Game\Config;
use Illuminate\Support\Facades\Cache;

class ConfigService
{
    protected const TAG = 'xconfig';

    public static function get(string $key, $default = '', bool $isCaChe = false){
        if($isCaChe == true){
            return Config::where('id',1)->value($key);
        }
        $value = Cache::tags(self::TAG)->rememberForever($key, function () use ($key) {
            return Config::where('id',1)->value($key);
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
