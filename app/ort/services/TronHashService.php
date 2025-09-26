<?php


namespace App\ort\services;



use App\ort\common\CsFunc;

class TronHashService
{

    public static function gettronlottery($start_timestamp, $end_timestamp,$count = 1,$fenlei,$num){
        $list = [];
        if($count > 5){
            return $list;
        }
        $param = "limit=50&start=0&contract_address=TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t&start_timestamp=$start_timestamp&end_timestamp=$end_timestamp&confirm=";
        $url = 'https://apilist.tronscanapi.com/api/token_trc20/transfers';
        $res = CsFunc::curl_get(1, $url.'?'.$param);
        $res = json_decode($res, true);
        $jsonlist = $res['token_transfers'];
        if(empty($res) || empty($jsonlist)){
            $count = $count+1;
            $start_timestamp = $start_timestamp+(1000*1000);
            $end_timestamp = $end_timestamp+(1000*1000);
            return self::gettronlottery($start_timestamp, $end_timestamp,$count,$fenlei,$num);
        }
        foreach ($jsonlist as $item){
            $team = ['hash'=>$item['transaction_id'],'block'=>$item['block']];
            $qiu = self::get_string_qiu($team['hash'],$num,$fenlei);
            if(!empty($qiu)){
                $team['qiu'] = $qiu;
                $list[] = $team;
            }
        }
        return $list;
    }

    public static function get_string_qiu($str,$count,$fenlei){
        $qiuarr = [];
        //从字符串倒数第一个字符开始获取字符，如果是数字放入数组$qiuarr，如果是字母则不要，如果$fenlei==107，则0替换成10，如果$fenlei==107,则不能出现一样的数字，凑够$count个数字就返回
        $str = strrev($str);
        $len = strlen($str);
        for($i=0;$i<$len;$i++){
            $qiu = substr($str,$i,1);
            if(is_numeric($qiu)){
                $qiu = intval($qiu);
                if($fenlei==107){
                    if($qiu==0){
                        $qiu = 10;
                    }
                    if(!in_array($qiu,$qiuarr)){
                        $qiuarr[] = $qiu;
                    }
                }else{
                    $qiuarr[] = $qiu;
                }
            }
            if(count($qiuarr)==$count){
                break;
            }
        }
        if(count($qiuarr)<$count){
            $qiuarr = [];
        }
        return $qiuarr;
    }
}
