<?php

namespace App\ort\common;

use App\ort\HttpUtils;
use Illuminate\Support\Facades\Log;

class CommonUtils
{
    public static function url_to_base64($url,$ip,$accid){
        try {
            //$send = ["headip" => $ip, "cookietype" => true, "cookie_jar" => $file, "url" => $url, "posttype" => false, "postdata" => [], "head" => false, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
            //$res = ComFunc::CURL($send);
            $res = HttpUtils::curl('GET',true,'',$url,[],[],true,true,[],$accid);
            if(empty($res)){
                $res = HttpUtils::curl('GET',true,'',$url,[],[],true,true,[],$accid);
            }
            $base64 = base64_encode($res);
            return $base64;
        }catch (\Exception $e){
            Log::info('url_to_base64 error:'.$e->getMessage());
            return '';
        }
    }
}
