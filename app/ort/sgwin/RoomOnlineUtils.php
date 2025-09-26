<?php

namespace App\ort\sgwin;

class RoomOnlineUtils
{

    public static $onlinelistkey = "onlinelist";

    public static function addOnline($ruid,$userid){
        $key = self::$onlinelistkey.":".$ruid;

    }
}