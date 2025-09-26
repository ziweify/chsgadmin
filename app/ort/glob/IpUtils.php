<?php

namespace App\ort\glob;

use App\ort\common\XdbSearcher;

class IpUtils
{
    public static function getaddrbyip($ip){
        try {
            $path = dirname(dirname(__FILE__)).'/dat/world.xdb';
            /*$searcher = XdbSearcher::newWithFileOnly($path);
            $region = $searcher->search($ip);*/
            $vIndex = XdbSearcher::loadVectorIndexFromFile($path);
            $searcher = XdbSearcher::newWithVectorIndex($path, $vIndex);
            $region = $searcher->search($ip);
            $regions = explode('|', $region);
            $t = $regions[2];
            if(strpos($t, '特别行政区')){
                $s1 = '香港 香港 香港';
                if(strpos($regions[11], '里云')){
                    $s2 = 'Alibaba.com Singapore E-Commerce Private Limited';
                }else{
                    $s2 = 'Aofei Data International Company Limited';
                }
            }else{
                $regions[2] = str_replace('省', '', $regions[2]);
                $regions[3] = str_replace('市', '', $regions[3]);
                $s1 = $regions[1].' '.$regions[2].' '.$regions[3];
                if($regions[1] == '中国'){
                    $ss = self::cityToPinyin($regions[2]);
                    $s2 = "ChinaNet {$ss} Province Network";
                }else{
                    $s2 = 'Aofei Data International Company Limited';
                }
            }
            $region = $s1.' '.$s2;
        }catch (\Exception $e) {
            $region = '未知';
        }
        return $region;
    }

    //城市名称转拼音
    public static function cityToPinyin($city){
        if(empty($city)){
            return '未知';
        }
        if(count(explode($city,'北京')) > 1){
            return 'Beijing';
        }elseif (count(explode($city,'上海')) > 1){
            return 'Shanghai';
        }elseif (count(explode($city,'天津')) > 1){
            return 'Tianjin';
        }elseif (count(explode($city,'重庆')) > 1){
            return 'Chongqing';
        }elseif (count(explode($city,'香港')) > 1){
            return 'Hongkong';
        }elseif (count(explode($city,'澳门')) > 1){
            return 'Macau';
        }elseif (count(explode($city,'台湾')) > 1){
            return 'Taiwan';
        }elseif (count(explode($city,'河北')) > 1){
            return 'Hebei';
        }elseif (count(explode($city,'山西')) > 1){
            return 'Shanxi';
        }elseif (count(explode($city,'内蒙古')) > 1){
            return 'Neimenggu';
        }elseif (count(explode($city,'辽宁')) > 1){
            return 'Liaoning';
        }elseif (count(explode($city,'吉林')) > 1){
            return 'Jilin';
        }elseif (count(explode($city,'黑龙江')) > 1){
            return 'Heilongjiang';
        }elseif (count(explode($city,'江苏')) > 1){
            return 'Jiangsu';
        }elseif (count(explode($city,'浙江')) > 1){
            return 'Zhejiang';
        }elseif (count(explode($city,'安徽')) > 1){
            return 'Anhui';
        }elseif (count(explode($city,'福建')) > 1){
            return 'Fujian';
        }elseif (count(explode($city,'江西')) > 1){
            return 'Jiangxi';
        }elseif (count(explode($city,'山东')) > 1){
            return 'Shandong';
        }elseif (count(explode($city,'河南')) > 1){
            return 'Henan';
        }elseif (count(explode($city,'湖北')) > 1){
            return 'Hubei';
        }elseif (count(explode($city,'湖南')) > 1){
            return 'Hunan';
        }elseif (count(explode($city,'广东')) > 1){
            return 'Guangdong';
        }elseif (count(explode($city,'广西')) > 1){
            return 'Guangxi';
        }elseif (count(explode($city,'海南')) > 1){
            return 'Hainan';
        }elseif (count(explode($city,'四川')) > 1){
            return 'Sichuan';
        }elseif (count(explode($city,'贵州')) > 1){
            return 'Guizhou';
        }elseif (count(explode($city,'云南')) > 1){
            return 'Yunnan';
        }elseif (count(explode($city,'西藏')) > 1){
            return 'Xizang';
        }elseif (count(explode($city,'陕西')) > 1){
            return 'Shaanxi';
        }elseif (count(explode($city,'甘肃')) > 1){
            return 'Gansu';
        }elseif (count(explode($city,'青海')) > 1){
            return 'Qinghai';
        }elseif (count(explode($city,'宁夏')) > 1){
            return 'Ningxia';
        }elseif (count(explode($city,'新疆')) > 1){
            return 'Xinjiang';
        }else{
            return 'Ohter';
        }
    }
}
