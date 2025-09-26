<?php

namespace App\ort\kjw\services;


use App\Models\Kjw\Daybao;
use App\Models\Kjw\Daycl;
use App\Models\Kjw\Game;
use App\ort\kjw\CommonService;
use App\ort\kjw\JsFunc;
use Illuminate\Support\Facades\DB;

class TongjiService
{
    /**
     * 龙虎每日统计
     */
    public static function lhtongji($gid,$date,$ball){
        $lh1 = JsFunc::longhub($ball[0],$ball[9]);
        $lh2 = JsFunc::longhub($ball[1],$ball[8]);
        $lh3 = JsFunc::longhub($ball[2],$ball[7]);
        $lh4 = JsFunc::longhub($ball[3],$ball[6]);
        $lh5 = JsFunc::longhub($ball[4],$ball[5]);
        $update = [];
        if ($lh1 == 0){
            $update['firstDragon'] = Db::raw('firstDragon+1');
        }else{
            $update['firstTiger'] = Db::raw('firstTiger+1');
        }
        if ($lh2 == 0){
            $update['secondDragon'] = Db::raw('secondDragon+1');
        }else{
            $update['secondTiger'] = Db::raw('secondTiger+1');
        }
        if ($lh3 == 0){
            $update['thirdDragon'] = Db::raw('thirdDragon+1');
        }else{
            $update['thirdTiger'] = Db::raw('thirdTiger+1');
        }
        if ($lh4 == 0){
            $update['fourthDragon'] = Db::raw('fourthDragon+1');
        }else{
            $update['fourthTiger'] = Db::raw('fourthTiger+1');
        }
        if ($lh5 == 0){
            $update['fifthDragon'] = Db::raw('fifthDragon+1');
        }else{
            $update['fifthTiger'] = Db::raw('fifthTiger+1');
        }
        //$lh1 == 0 ? self::updatedaybao($gid,$date,'firstDragon',1) : self::updatedaybao($gid,$date,'firstTiger',1);
        //$lh2 == 0 ? self::updatedaybao($gid,$date,'secondDragon',1) : self::updatedaybao($gid,$date,'secondTiger',1);
        //$lh3 == 0 ? self::updatedaybao($gid,$date,'thirdDragon',1) : self::updatedaybao($gid,$date,'thirdTiger',1);
        //$lh4 == 0 ? self::updatedaybao($gid,$date,'fourthDragon',1) : self::updatedaybao($gid,$date,'fourthTiger',1);
        self::updatedaybao($gid,$date,$update);
    }

    /**
     * 更新每日统计表
     * @param $date
     * @param $field
     * @param $count
     */
    public static function updatedaybao($gid,$date,$update){
        $c = Daybao::where(['date'=>$date,'gid'=>$gid])->count('id');
        if($c <= 0){
            $update['gid'] = $gid;
            $update['date'] = $date;
            $update['clcount'] = 1;
            Daybao::create($update);
        }else{
            Daybao::where(['date'=>$date,'gid'=>$gid,'clcount'=>Db::raw('clcount+1')])->update($update);
        }
    }

    public static function daytongjilh($gid,$date){
        $game = Game::where('gid',$gid)->first();
        Daybao::where(['gid'=>$gid,'date'=>strtotime($date)])->delete();
        $kjServices = CommonService::getKjmodel($game['gid']);
        $fields = ['qishu','dates'];
        for ($i = 1; $i <= $game['mnum']; $i++) {
            $fields[] = 'm' . $i;
        }
        $list = $kjServices->where(['dates'=>strtotime($date),'status'=>1])->select($fields)->get();
        foreach ($list as $item){
            $arr = [];
            for ($i = 1; $i <= $game['mnum']; $i++) {
                $arr[] = $item['m'.$i];
            }
            self::lhtongji($gid,$item['dates'],$arr);
        }
    }

    public static function daytongjiall($gid,$date,$fenlei,$mnum){
        $kjServices = CommonService::getKjmodel($gid);
        $fields = [];
        for ($i = 1; $i <= $mnum; $i++) {
            $fields[] = 'm' . $i;
        }
        $c = Daybao::where(['date'=>$date,'gid'=>$gid])->count('id');
        $list = $kjServices->where(['dates'=>$date,'status'=>1])->select($fields)->get();
        $update = ['gyhBig'=>0,'gyhSmall'=>0,'gyhSingle'=>0,'gyhDouble'=>0,'firstDragon'=>0,'firstTiger'=>0,'secondDragon'=>0,'secondTiger'=>0,'thirdDragon'=>0,'thirdTiger'=>0,'fourthDragon'=>0,'fourthTiger'=>0,'fifthDragon'=>0,'fifthTiger'=>0];
        if($fenlei != 161){
            for($i = 1;$i <= $mnum;$i++){
                $update['bigCount_'.$i] = 0;
                $update['smallCount_'.$i] = 0;
                $update['singleCount_'.$i] = 0;
                $update['doubleCount_'.$i] = 0;
            }
        }
        if($c > 0){
            Daybao::where(['date'=>$date,'gid'=>$gid])->update($update);
        }
        //长龙数据统计变量
        if($fenlei == 101){
            $temparray = [];
            for($i = 1;$i <= $mnum;$i++){
                if($i <= 4){
                    for($x = 1;$x <= 4;$x++){
                        $temparray['h_'.$i.'_'.$x] = [];
                    }
                }
                if($i == 1){
                    for($x = 5;$x <= 6;$x++){
                        $temparray['h_'.$i.'_'.$x] = [];
                    }
                }
            }
            //总和
            for($x = 1;$x <= 4;$x++){
                $temparray['h_11_'.$x] = [];
            }
        }elseif($fenlei == 121){//11选5系列
            $temparray = [];
            for($i = 1;$i <= $mnum;$i++){
                if($i <= 4){//单双大小
                    for($x = 1;$x <= 4;$x++){
                        $temparray['h_'.$i.'_'.$x] = [];
                    }
                }
                if($i == 1){//龙虎
                    for($x = 6;$x <= 7;$x++){
                        $temparray['h_'.$i.'_'.$x] = [];
                    }
                }
            }
            //总和
            for($x = 1;$x <= 4;$x++){
                $temparray['h_6_'.$x] = [];
            }
            //尾数大小
            for($x = 3;$x <= 4;$x++){
                $temparray['h_7_'.$x] = [];
            }
        }elseif($fenlei == 107){//赛车系列
            $temparray = [];
            for($i = 1;$i <= $mnum;$i++){
                if($i <= 4){//单双大小
                    for($x = 1;$x <= 4;$x++){
                        $temparray['h_'.$i.'_'.$x] = [];
                    }
                }
                if($i <= 5){//龙虎
                    for($x = 5;$x <= 6;$x++){
                        $temparray['h_'.$i.'_'.$x] = [];
                    }
                }
            }
            //冠亚和
            for($x = 1;$x <= 4;$x++){
                $temparray['h_11_'.$x] = [];
            }
        }elseif($fenlei == 103){//快乐十分系列
            $temparray = [];
            for($i = 1;$i <= $mnum;$i++){
                for($x = 1;$x <= 10;$x++){
                    if($i > 4 && ($x==5 || $x==6)){
                        continue;
                    }
                    $temparray['h_'.$i.'_'.$x] = [];
                }
            }
            //总和
            $s1 = [1,2,3,4,7,8];
            for($x = 0;$x < count($s1);$x++){
                $temparray['h_9_'.$s1[$x]] = [];
            }
            //历史号码统计
            $dataArrays = [];
            for($n = 0;$n < 26;$n++){
                $dataArrays[] = 0;
            }
        }elseif($fenlei == 151){//快三系列
            $temparray = [];
            for($i = 1;$i <= 1;$i++){
                for($x = 1;$x <= 4;$x++){
                    $temparray['h_'.$i.'_'.$x] = [];
                }
            }
            //历史号码统计
            $dataArrays = [];
            for($n = 0;$n < 8;$n++){
                $dataArrays[] = 0;
            }
        }elseif($fenlei == 161){//快乐8系列
            $temparray = [];
            for($x = 1;$x <= 5;$x++){//总和
                $temparray['h_1_'.$x] = [];
            }
        }
        $index = 0;
        foreach ($list as $item){
            $ball = [];
            for ($i = 1; $i <= $mnum; $i++) {
                $ball[] = $item['m'.$i];
                //统计单双大小历史
                if($fenlei == 107){//赛车系列
                    $ds = JsFunc::danshuang($item['m'.$i]);
                    $dx = JsFunc::daxiao107($item['m'.$i]);
                    $ds == '单' ? $update['singleCount_'.$i]++ : $update['doubleCount_'.$i]++;
                    $dx == '大' ? $update['bigCount_'.$i]++ : $update['smallCount_'.$i]++;
                }
                if($fenlei == 101){//时时彩系列
                    $ds = JsFunc::danshuangb($item['m'.$i]);
                    $dx = JsFunc::daxiao101b($item['m'.$i]);
                    $ds == 0 ? $update['singleCount_'.$i]++ : $update['doubleCount_'.$i]++;
                    $dx == 0 ? $update['bigCount_'.$i]++ : $update['smallCount_'.$i]++;
                }
                if($fenlei == 121){//11选5系列
                    $ds = JsFunc::danshuangb($item['m'.$i]);
                    $dx = JsFunc::daxiao121b($item['m'.$i]);
                    if($item['m'.$i] != 11){
                        if($ds == 0)$update['singleCount_'.$i]++;
                        if($ds == 1)$update['doubleCount_'.$i]++;
                    }
                    if($dx == 0)$update['bigCount_'.$i]++;
                    if($dx == 1)$update['smallCount_'.$i]++;
                }
                if($fenlei == 103){//快乐十分系列
                    $ds = JsFunc::danshuangb($item['m'.$i]);
                    $dx = JsFunc::daxiao103b($item['m'.$i]);
                    $ds == 0 ? $update['singleCount_'.$i]++ : $update['doubleCount_'.$i]++;
                    $dx == 0 ? $update['bigCount_'.$i]++ : $update['smallCount_'.$i]++;
                }
                //长龙数据统计
                if($fenlei == 101){//时时彩系列
                    //单双大小长龙统计
                    for($h = 1;$h <= 2;$h++){
                        $p = JsFunc::panduansinglebycl($h,$fenlei,$item['m'.$i],'');
                        $key = 'a_'.$i.'_'.$p;
                        $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                        $oldp = 0;
                        $preitem && ($oldp = JsFunc::panduansinglebycl($h,$fenlei,$preitem['m'.$i],''));
                        if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                            $key2 = 'h_'.$i.'_'.$oldp;
                            if($oldp != $p){
                                $oldkey =  'a_'.$i.'_'.$oldp;
                                if($temparray[$oldkey] >= 2){
                                    isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                                }
                                $temparray[$oldkey] = 0;
                            }elseif ($index == count($list)-1 && $oldp == $p){
                                if($temparray[$key] >= 2){
                                    isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                                }
                                $temparray[$key] = 0;
                            }
                        }else{
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        }
                    }
                }elseif($fenlei == 121){//11选5系列
                    //单双大小长龙统计
                    for($h = 1;$h <= 2;$h++){
                        $p = JsFunc::panduansinglebycl($h,$fenlei,$item['m'.$i],'');
                        $key = 'a_'.$i.'_'.$p;
                        $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                        $oldp = 0;
                        $preitem && ($oldp = JsFunc::panduansinglebycl($h,$fenlei,$preitem['m'.$i],''));
                        if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                            $key2 = 'h_'.$i.'_'.$oldp;
                            if($oldp != $p){
                                $oldkey =  'a_'.$i.'_'.$oldp;
                                if($temparray[$oldkey] >= 2){
                                    isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                                }
                                $temparray[$oldkey] = 0;
                            }elseif ($index == count($list)-1 && $oldp == $p){
                                if($temparray[$key] >= 2){
                                    isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                                }
                                $temparray[$key] = 0;
                            }
                        }else{
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        }
                    }
                }elseif($fenlei == 107){//赛车系列
                    //单双大小长龙统计
                    for($h = 1;$h <= 2;$h++){
                        $p = JsFunc::panduansinglebycl($h,$fenlei,$item['m'.$i],'');
                        $key = 'a_'.$i.'_'.$p;
                        $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                        $oldp = 0;
                        $preitem && ($oldp = JsFunc::panduansinglebycl($h,$fenlei,$preitem['m'.$i],''));
                        if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                            $key2 = 'h_'.$i.'_'.$oldp;
                            if($oldp != $p){
                                $oldkey =  'a_'.$i.'_'.$oldp;
                                if($temparray[$oldkey] >= 2){
                                    isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                                }
                                $temparray[$oldkey] = 0;
                            }elseif ($index == count($list)-1 && $oldp == $p){
                                if($temparray[$key] >= 2){
                                    isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                                }
                                $temparray[$key] = 0;
                            }
                        }else{
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        }
                    }
                }elseif($fenlei == 103){//快乐十分系列
                    //单双大小、尾大小、合单双长龙统计
                    $types = [1,2,7,8];
                    for($h = 0;$h < count($types);$h++){
                        $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$item['m'.$i],'');
                        $key = 'a_'.$i.'_'.$p;
                        $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                        $oldp = 0;
                        $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$preitem['m'.$i],''));
                        if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                            $key2 = 'h_'.$i.'_'.$oldp;
                            if($oldp != $p){
                                $oldkey =  'a_'.$i.'_'.$oldp;
                                if($temparray[$oldkey] >= 2){
                                    isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                                }
                                $temparray[$oldkey] = 0;
                            }elseif ($index == count($list)-1 && $oldp == $p){
                                if($temparray[$key] >= 2){
                                    isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                                }
                                $temparray[$key] = 0;
                            }
                        }else{
                            isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        }
                    }
                    //历史号码统计
                    $dataArrays[$item['m'.$i]-1]++;//号码
                    //单双
                    $lishids = JsFunc::danshuangb($item['m'.$i]);
                    if($lishids == 0)$dataArrays[20]++;
                    if($lishids == 1)$dataArrays[21]++;
                    //大小
                    $lishidx = JsFunc::daxiao103b($item['m'.$i]);
                    if($lishidx == 0)$dataArrays[22]++;
                    if($lishidx == 1)$dataArrays[23]++;
                }elseif ($fenlei == 151){
                    //历史号码统计
                    $dataArrays[$item['m'.$i]-1]++;//号码
                    //大小
                    $lishidx = JsFunc::daxiao151b($item['m'.$i]);
                    if($lishidx == 0)$dataArrays[6]++;
                    if($lishidx == 1)$dataArrays[7]++;
                }
            }
            //龙虎统计
            if($fenlei == 107){
                $lh1 = JsFunc::longhub($ball[0],$ball[9]);
                $lh2 = JsFunc::longhub($ball[1],$ball[8]);
                $lh3 = JsFunc::longhub($ball[2],$ball[7]);
                $lh4 = JsFunc::longhub($ball[3],$ball[6]);
                $lh5 = JsFunc::longhub($ball[4],$ball[5]);
                $lh1 == 0 && $update['firstDragon']++;
                $lh1 == 1 && $update['firstTiger']++ ;
                $lh2 == 0 && $update['secondDragon']++;
                $lh2 == 1 && $update['secondTiger']++;
                $lh3 == 0 && $update['thirdDragon']++;
                $lh3 == 1 && $update['thirdTiger']++;
                $lh4 == 0 && $update['fourthDragon']++;
                $lh4 == 1 && $update['fourthTiger']++;
                $lh5 == 0 && $update['fifthDragon']++;
                $lh5 == 1 && $update['fifthTiger']++;
            }elseif($fenlei == 103){
                $lh1 = JsFunc::longhub($ball[0],$ball[7]);
                $lh2 = JsFunc::longhub($ball[1],$ball[6]);
                $lh3 = JsFunc::longhub($ball[2],$ball[5]);
                $lh4 = JsFunc::longhub($ball[3],$ball[4]);
                $lh1 == 0 && $update['firstDragon']++;
                $lh1 == 1 && $update['firstTiger']++ ;
                $lh2 == 0 && $update['secondDragon']++;
                $lh2 == 1 && $update['secondTiger']++;
                $lh3 == 0 && $update['thirdDragon']++;
                $lh3 == 1 && $update['thirdTiger']++;
                $lh4 == 0 && $update['fourthDragon']++;
                $lh4 == 1 && $update['fourthTiger']++;
                //历史号码统计龙虎
                $lh1 == 0 && $dataArrays[24]++;
                $lh1 == 1 && $dataArrays[25]++;
                $lh2 == 0 && $dataArrays[24]++;
                $lh2 == 1 && $dataArrays[25]++;
                $lh3 == 0 && $dataArrays[24]++;
                $lh3 == 1 && $dataArrays[25]++;
                $lh4 == 0 && $dataArrays[24]++;
                $lh4 == 1 && $dataArrays[25]++;
            }
            //冠亚和大小单双统计
            if($fenlei == 107){
                $m = $item['m1']+$item['m2'];
                $sumBigSamll = JsFunc::guanyadaxiao107b($m);
                $sumBigSamll == 0 ? $update['gyhBig']++ : $update['gyhSmall']++;
                $sumSingleDouble = JsFunc::danshuangb($m);
                $sumSingleDouble == 0 ? $update['gyhSingle']++ : $update['gyhDouble']++;

            }
            //其他长龙统计
            if($fenlei == 101){
                //龙虎长龙统计
                $p = JsFunc::panduansinglebycl(3,$fenlei,$item['m1'],$item['m5']);
                $key = 'a_1_'.$p;
                $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                $oldp = 0;
                $preitem && ($oldp = JsFunc::panduansinglebycl(3,$fenlei,$preitem['m1'],$preitem['m5']));
                if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                    isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    $key2 = 'h_1_'.$oldp;
                    if($oldp != $p){
                        $oldkey =  'a_1_'.$oldp;
                        if($temparray[$oldkey] >= 2){
                            isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                        }
                        $temparray[$oldkey] = 0;
                    }elseif ($index == count($list)-1 && $oldp == $p){
                        if($temparray[$key] >= 2){
                            isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                        }
                        $temparray[$key] = 0;
                    }
                }else{
                    isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                }
                //总和单双大小长龙统计
                $types = [1,4];
                $m = $item['m1']+$item['m2']+$item['m3']+$item['m4']+$item['m5'];
                for($h = 0;$h < 2;$h++){
                    $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$m,'');
                    $key = 'a_11_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$preitem['m1']+$preitem['m2']+$preitem['m3']+$preitem['m4']+$preitem['m5'],''));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_11_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_11_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
            }elseif($fenlei == 121){
                //龙虎长龙统计
                $p = JsFunc::panduansinglebycl(3,$fenlei,$item['m1'],$item['m5']);
                $key = 'a_1_'.$p;
                $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                $oldp = 0;
                $preitem && ($oldp = JsFunc::panduansinglebycl(3,$fenlei,$preitem['m1'],$preitem['m5']));
                if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                    isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    $key2 = 'h_1_'.$oldp;
                    if($oldp != $p){
                        $oldkey =  'a_1_'.$oldp;
                        if($temparray[$oldkey] >= 2){
                            isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                        }
                        $temparray[$oldkey] = 0;
                    }elseif ($index == count($list)-1 && $oldp == $p){
                        if($temparray[$key] >= 2){
                            isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                        }
                        $temparray[$key] = 0;
                    }
                }else{
                    isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                }
                //总和单双大小长龙统计
                $types = [1,4];
                $m = $item['m1']+$item['m2']+$item['m3']+$item['m4']+$item['m5'];
                for($h = 0;$h < 2;$h++){
                    $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$m,'');
                    $key = 'a_6_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$preitem['m1']+$preitem['m2']+$preitem['m3']+$preitem['m4']+$preitem['m5'],''));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_6_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_6_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
                //尾数大小长龙统计
                $types = [5];
                $m = $item['m1']+$item['m2']+$item['m3']+$item['m4']+$item['m5'];
                for($h = 0;$h < 1;$h++){
                    $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$m,'');
                    $key = 'a_7_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$preitem['m1']+$preitem['m2']+$preitem['m3']+$preitem['m4']+$preitem['m5'],''));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_7_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_7_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
            }elseif($fenlei == 107){
                //龙虎长龙统计
                for($g = 1;$g <= 5;$g++){
                    $p = JsFunc::panduansinglebycl(3,$fenlei,$item['m'.$g],$item['m'.(11-$g)]);
                    $key = 'a_'.$g.'_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl(3,$fenlei,$preitem['m'.$g],$preitem['m'.(11-$g)]));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_'.$g.'_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_'.$g.'_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
                //冠亚单双大小长龙统计
                $types = [1,6];
                $m = $item['m1']+$item['m2'];
                for($h = 0;$h < 2;$h++){
                    $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$m,'');
                    $key = 'a_11_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$preitem['m1']+$preitem['m2'],''));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_11_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_11_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
            }elseif($fenlei == 103){//快乐十分系列
                //龙虎长龙统计
                for($g = 1;$g <= 4;$g++){
                    $p = JsFunc::panduansinglebycl(3,$fenlei,$item['m'.$g],$item['m'.(9-$g)]);
                    $key = 'a_'.$g.'_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl(3,$fenlei,$preitem['m'.$g],$preitem['m'.(9-$g)]));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_'.$g.'_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_'.$g.'_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
                //总和单双大小长龙统计
                $types = [1,4,7];
                $m = $item['m1']+$item['m2']+$item['m3']+$item['m4']+$item['m5']+$item['m6']+$item['m7']+$item['m8'];
                for($h = 0;$h < count($types);$h++){
                    $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$m,'');
                    $key = 'a_9_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$preitem['m1']+$preitem['m2']+$preitem['m3']+$preitem['m4']+$preitem['m5']+$preitem['m6']+$preitem['m7']+$preitem['m8'],''));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_9_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_9_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
            }elseif($fenlei == 151){//快三系列
                //总和单双大小长龙统计
                $types = [1,4];
                $m = $item['m1']+$item['m2']+$item['m3'];
                for($h = 0;$h < count($types);$h++){
                    $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$m,'');
                    $key = 'a_1_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$preitem['m1']+$preitem['m2']+$preitem['m3'],''));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_1_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_1_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
            }elseif($fenlei == 161){//快乐8系列
                $balls = [];
                $total = 0;
                for($x = 1;$x <= 20;$x++){
                    $balls[] = $item['m'.$x];
                    $total+=$item['m'.$x];
                }
                //总和单双大小长龙统计
                $types = [1,4];
                for($h = 0;$h < 2;$h++){
                    $p = JsFunc::panduansinglebycl($types[$h],$fenlei,$total,'');
                    $key = 'a_1_'.$p;
                    $preitem = isset($list[$index-1]) ? $list[$index-1] : [];
                    $oldtotal = 0;
                    if($preitem){
                        for($x = 1;$x <= 20;$x++){
                            $oldtotal+=$preitem['m'.$x];
                        }
                    }
                    $oldp = 0;
                    $preitem && ($oldp = JsFunc::panduansinglebycl($types[$h],$fenlei,$oldtotal,''));
                    if($oldp != 0 && ($oldp != $p || ($index == count($list)-1))){
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                        $key2 = 'h_1_'.$oldp;
                        if($oldp != $p){
                            $oldkey =  'a_1_'.$oldp;
                            if($temparray[$oldkey] >= 2){
                                isset($temparray[$key2][$temparray[$oldkey]]) ? $temparray[$key2][$temparray[$oldkey]]++ : $temparray[$key2][$temparray[$oldkey]] = 1;
                            }
                            $temparray[$oldkey] = 0;
                        }elseif ($index == count($list)-1 && $oldp == $p){
                            if($temparray[$key] >= 2){
                                isset($temparray[$key2][$temparray[$key]]) ? $temparray[$key2][$temparray[$key]]++ : $temparray[$key2][$temparray[$key]] = 1;
                            }
                            $temparray[$key] = 0;
                        }
                    }else{
                        isset($temparray[$key]) ? $temparray[$key]++ : $temparray[$key] = 1;
                    }
                }
            }
            $index++;
        }
        //长龙整合
        if($fenlei == 101 || $fenlei == 121 || $fenlei == 107 || $fenlei == 103 || $fenlei == 151 || $fenlei == 161){
            foreach ($temparray as $key=>$value){
                $arr = explode('_',$key);
                if($arr[0] == 'h'){
                    $old = Daycl::where(['gid'=>$gid,'date'=>$date,'rank'=>$arr[1],'type'=>$arr[2]])->select(['id'])->first();
                    if($old){
                        Daycl::where('id',$old['id'])->update(['data'=>json_encode($value)]);
                    }else{
                        Daycl::create(['gid'=>$gid,'date'=>$date,'rank'=>$arr[1],'type'=>$arr[2],'data'=>json_encode($value)]);
                    }
                }
            }
        }
        if(isset($dataArrays) && $dataArrays){
            $old = Daycl::where(['gid'=>$gid,'date'=>$date,'rank'=>$fenlei,'type'=>$fenlei])->first();
            if($old){
                Daycl::where('id',$old['id'])->update(['data'=>json_encode($dataArrays)]);
            }else{
                Daycl::create(['gid'=>$gid,'date'=>$date,'rank'=>$fenlei,'type'=>$fenlei,'data'=>json_encode($value)]);
            }
        }
        if($update){
            if($c > 0){
                Daybao::where(['date'=>$date,'gid'=>$gid])->update($update);
            }else{
                $update['date'] = $date;
                $update['gid'] = $gid;
                Daybao::create($update);
            }
        }
    }
}
