<?php


namespace App\ort\kjw;

use Illuminate\Support\Facades\DB;

class JsFunc
{
    public static $zhishu = array(1, 2, 3, 5, 7);
    public static $heshu = array(0, 4, 6, 8, 9);
    public static $dashu = array(5, 6, 7, 8, 9);
    public static $xiaoshu = array(0, 1, 2, 3, 4);

    public static function nndaxiao($v)
    {
        if ($v >= 1 & $v <= 5) {
            return '小';
        } else {
            return '大';
        }
    }

    public static function niuniu($arr)
    {
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        for ($a = 0; $a <= 2; $a++) {
            for ($b = $a + 1; $b <= 3; $b++) {
                for ($c = $b + 1; $c <= 4; $c++) {
                    if (($arr[$a] + $arr[$b] + $arr[$c]) % 10 == 0) {
                        $t1 = 1;
                        for ($j = 0; $j <= 4; $j++) {
                            if ($j != $a && $j != $b && $j != $c) {
                                $t3 += $arr[$j];
                            }
                        }
                        if ($t3 % 10 == 0) {
                            $t2 = 1;
                        }
                    }
                }
            }
        }
        $arr = [$t1, $t2, $t3 % 10, max($arr[0], $arr[1], $arr[2], $arr[3], $arr[4])];
        //print_r($arr);
        return $arr;
    }

    public static function suoha($arr)
    {
        $r = 0;//散号
        $a = array();
        foreach ($arr as $v) {
            $a[$v] += 1;
        }
        array_merge($a);
        $ca = count($a);
        switch ($ca) {
            case 1:
                $r = 1;//五梅
                break;
            case 2:
                sort($a);
                if ($a[0] == 1 | $a[1] == 1) {
                    $r = 2;//炸弹
                } else {
                    $r = 3;//葫芦
                }
                break;
            case 3:
                if ($a[0] == 3 | $a[1] == 3 | $a[2] == 3) {
                    $r = 4;//三条
                } else {
                    $r = 5;//两对
                }
                break;
            case 4:
                $r = 6;//单对
                break;
            case 5:
                sort($arr);
                if ($arr[4] - $arr[0] == 4) {
                    $r = 7;//顺子
                } else {
                    $kao1 = array(1, 3, 5, 7, 9);
                    $kao2 = array(0, 2, 4, 6, 8);
                    if ($arr == $kao1 | $arr == $kao2) {
                        $r = 8;//五不靠
                    }
                }
                break;
        }
        $arr = array("散号", "五梅", "炸弹", "葫芦", "三条", "两对", "单对", "顺子", "五不靠");
        return $arr[$r];
    }

    public static function qita($v1, $v2, $v3)
    {
        $v = 9;
        if (self::baozhi($v1, $v2, $v3) == 1) $v = 0;
        else if (self::shunzhi($v1, $v2, $v3) == 1) $v = 1;
        else if (self::duizhi($v1, $v2, $v3) == 1) $v = 2;
        else if (self::banshun($v1, $v2, $v3) == 1) $v = 3;
        else $v = 4;
        $arr = array("豹子", "顺子", "对子", "半顺", "杂六");
        return $arr[$v];
    }

    public static function danshuang($v)
    {
        if ($v % 2 == 1) {
            $v = '单';
        } else {
            $v = '双';
        }
        return $v;
    }

    public static function danshuangb($v)
    {
        if ($v % 2 == 1) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function zhdanshuang161bc($v){
        if($v == 810){
            return 0;
        }
        if ($v % 2 == 1) {
            $v = 1;
        } else {
            $v = -1;
        }
        return $v;
    }

    public static function qioushu($v){
        if(in_array($v,[1,3,5,7,9])){
            return 0;
        }else{
            return 1;
        }
    }

    public static function panduansinglebycl($type,$fenlei,$v1,$v2){
        $v = 0;
        if($type == 1){//单双
            if($fenlei == 101 || $fenlei == 107 || $fenlei == 103 || $fenlei == 151){
                if ($v1 % 2 == 1) {
                    $v = 1;
                } else {
                    $v = 2;
                }
            }elseif ($fenlei == 121){
                if($v1 == 11){
                    return -1;
                }
                if ($v1 % 2 == 1) {
                    $v = 1;
                } else {
                    $v = 2;
                }
            }elseif ($fenlei == 161){
                if($v1 == 810)return 5;
                if($v1%2==1)return 1;
                if($v1%2==0)return 2;
            }
        }elseif ($type == 2){//大小
            if($fenlei == 101){
                if ($v1 >= 5) {
                    $v = 3;
                } else {
                    $v = 4;
                }
            }elseif($fenlei == 121){
                if($v1 == 11){
                    return -1;
                }
                if ($v1 > 5) {
                    $v = 3;
                } elseif($v <= 5) {
                    $v = 4;
                }
            }elseif($fenlei == 107){
                if ($v1 > 5) {
                    $v = 3;
                } else{
                    $v = 4;
                }
            }elseif($fenlei == 103){
                if ($v1 > 10) {
                    $v = 3;
                } else{
                    $v = 4;
                }
            }
        }elseif ($type == 3){//龙虎
            if($fenlei == 101 || $fenlei == 107 || $fenlei == 103){
                if ($v1 == $v2) {
                    return 7;
                } else if ($v1 > $v2) {
                    return 5;
                } else {
                    return 6;
                }
            }elseif ($fenlei == 121){
                if ($v1 == $v2) {
                    return 8;
                } else if ($v1 > $v2) {
                    return 6;
                } else {
                    return 7;
                }
            }
        }elseif ($type == 4){//总和大小
            if($fenlei == 101){
                if ($v1 > 22) {
                    $v = 3;
                } else {
                    $v = 4;
                }
            }elseif($fenlei == 121){
                if ($v1 > 30) {
                    $v = 3;
                } elseif($v1 < 30) {
                    $v = 4;
                }
            }elseif($fenlei == 103){
                if ($v1 > 84) {
                    $v = 3;
                } else {
                    $v = 4;
                }
            }elseif($fenlei == 151){
                if ($v1 > 10) {
                    $v = 3;
                } else {
                    $v = 4;
                }
            }elseif ($fenlei == 161){
                if($v1 == 810)return 5;
                if($v1 > 810)return 3;
                if($v1 < 810)return 4;
            }
        }elseif ($type == 5){//尾数大小
           if($fenlei == 121){
               $v1 = $v1%10;
               if ($v1 > 4) {
                   $v = 3;
               } else{
                   $v = 4;
               }
            }
        }elseif ($type == 6){//冠亚大小
            if ($v1 > 11) {
                $v = 3;
            } else {
                $v = 4;
            }
        }elseif ($type == 7){//尾数大小
            if($fenlei == 103){
                $v1 = $v1%10;
                if ($v1 > 4) {
                    $v = 7;
                } else{
                    $v = 8;
                }
            }
        }elseif ($type == 8){//合单双
            if($fenlei == 103){
                $v1 = self::heshu($v1);
                if ($v1 % 2 == 1) {
                    $v = 9;
                } else {
                    $v = 10;
                }
            }
        }
        return $v;
    }

    public static function hezhib($v)
    {
        if (in_array($v,[0,4,6,8,9])) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function hezhi107b($v)
    {
        if (in_array($v,[1,2,3,5,7])) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function lyelub($v)
    {
        if ($v % 3 == 0) {
            $v = 0;
        }elseif ($v % 3 == 1) {
            $v = 1;
        } else {
            $v = 2;
        }
        return $v;
    }

    public static function danshuangbc($v)
    {
        if ($v % 2 == 1) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function danshuang100($v)
    {
        if ($v % 2 == 1) {
            $v = 1;
        } else {
            $v = -1;
        }
        return $v;
    }

    public static function danshuang211($v)
    {
        if ($v % 2 == 1) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }


    public static function zhongfabaibc($v)
    {
        if (in_array($v, array(1,2,3,4,5,6,7))) {
            $v = 2;
        } else {
            if (in_array($v, array(8,9,10,11,12,13,14))) {
                $v = 3;
            } else {
                if (in_array($v, array(15,16,17,18,19,20))) {
                    $v = 4;
                }
            }
        }
        return $v;
    }

    public static function danshuang121bc($v)
    {
        if ($v % 2 == 1) {
            $v = -1;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function danshuang121he($v)
    {
        if($v == 30){
            return 2;
        }
        if ($v % 2 == 1) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function danshuanghebc($v)
    {
        if($v == 11){
            return 0;
        }
        if ($v % 2 == 1) {
            $v = -1;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function danshuang_555($v)
    {
        if($v == 55){
            $v = '和';
        }else{
            if ($v % 2 == 1) {
                $v = '单';
            } else {
                $v = '双';
            }
        }
        return $v;
    }

    public static function danshuang_100($v)
    {
        if ($v % 2 == 1) {
            $v = '單';
        } else {
            $v = '雙';
        }
        return $v;
    }

    public static function longhub($v1, $v2)
    {
        if ($v2 == '') return '';
        if ($v1 == $v2) {
            return 2;
        } else if ($v1 < $v2) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function longhubc($v1, $v2)
    {
        if ($v2 == '') return '';
        if ($v1 == $v2) {
            return 2;
        } else if ($v1 < $v2) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function daxiao($v)
    {
        //global $dashu;
        if (in_array($v, self::$dashu)) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiao107($v)
    {
        if ($v > 5) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiao107b($v)
    {
        if ($v > 5) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function daxiao107bc($v)
    {
        if ($v > 5) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function daxiao101b($v)
    {
        if ($v >= 5) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function daxiao101bc($v)
    {
        if ($v >= 5) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function qitab($v1, $v2, $v3)
    {
        if ($v3 == '') return '';
        if (JsFunc::baozhi($v1, $v2, $v3) == 1) $v = 4;
        else if (JsFunc::shunzhi($v1, $v2, $v3) == 1) $v = 2;
        else if (JsFunc::duizhi($v1, $v2, $v3) == 1) $v = 3;
        else if (JsFunc::banshun($v1, $v2, $v3) == 1) $v = 1;
        else $v = 0;
        return $v;
    }

    public static function qita121b($v1, $v2, $v3)
    {
        if ($v3 == '') return '';
        if (JsFunc::baozhi($v1, $v2, $v3) == 1) $v = 4;
        else if (JsFunc::shunzhi121($v1, $v2, $v3) == 1) $v = 2;
        else if (JsFunc::duizhi($v1, $v2, $v3) == 1) $v = 3;
        else if (JsFunc::banshun121($v1, $v2, $v3) == 1) $v = 1;
        else $v = 0;
        return $v;
    }

    public static function qitabs($v1, $v2, $v3)
    {
        if ($v3 == '') return '';
        if (JsFunc::baozhi($v1, $v2, $v3) == 1) $v = 0;
        else if (JsFunc::shunzhi($v1, $v2, $v3) == 1) $v = 1;
        else if (JsFunc::duizhi($v1, $v2, $v3) == 1) $v = 2;
        else if (JsFunc::banshun($v1, $v2, $v3) == 1) $v = 3;
        else $v = 4;
        return $v;
    }

    public static function zuxuanbs($arr){
        if (JsFunc::baozhi($arr[0], $arr[1], $arr[2]) == 1) $v = 7;
        else if(count($arr) != count(array_unique($arr))) $v = 5;
        else $v = 6;
        return $v;
    }

    public static function guanyadaxiao107b($v)
    {
        if ($v > 11) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function guanyadaxiao107bc($v)
    {
        if ($v > 11) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function daxiao121($v)
    {
        if ($v == 11) {
            $v = '和';
        } else if ($v > 5) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiao121b($v)
    {
        if ($v == 11) {
            $v = 2;
        } else if ($v > 5) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function daxiao121bc($v)
    {
        if ($v == 11) {
            $v = 0;
        } else if ($v > 5) {
            $v = 1;
        } else {
            $v = -1;
        }
        return $v;
    }

    public static function zhdaxiao121b($v)
    {
        if ($v == 30) {
            $v = 2;
        } else if ($v > 30) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function zhdaxiao163($v){
        if ($v > 13) {
            $v = 1;
        } else {
            $v = -1;
        }
        return $v;
    }

    public static function zhdaxiao161b($v)
    {
        if ($v == 810) {
            $v = 0;
        } else if ($v > 810) {
            $v = 1;
        } else {
            $v = -1;
        }
        return $v;
    }

    public static function zhdaxiao212b($v)
    {
       if ($v > 13) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function zhdaxiao100b($v)
    {
        if ($v >= 175) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function zhdaxiao121bc($v)
    {
        if ($v == 30) {
            $v = 0;
        } else if ($v > 30) {
            $v = 1;
        } else {
            $v = -1;
        }
        return $v;
    }

    public static function zhdaxiao101b($v){
        if ($v > 22) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function zhdaxiao103b($v){
        if($v == 84){
            return 2;
        }
        if ($v > 84) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function zhdaxiao103bc($v){
        if($v == 84){
            return 9;
        }
        if ($v > 84) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function zhdaxiao101bc($v){
        if ($v > 22) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function zhdaxiao151b($v)
    {
        if ($v > 10) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function zhdaxiao161bc($v)
    {
        if($v == 810){
            return 0;
        }
        if ($v > 810) {
            $v = 1;
        } else {
            $v = -1;
        }
        return $v;
    }

    public static function wuhang161b($v)
    {
        if ($v == '') return '';
        if ($v <= 695) {
            $v = 1;
        } else if ($v <= 763) {
            $v = 2;
        } else if ($v <= 855) {
            $v = 3;
        } else if ($v <= 923) {
            $v = 4;
        } else {
            $v = 5;
        }
        return $v;
    }

    public static function wuhang100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[1,8,9,22,23,30,31,38,39])) {
            $v = 1;
        } else if (in_array($v,[4,5,12,13,20,21,34,35,42,43])) {
            $v = 2;
        } else if (in_array($v,[10,11,18,19,26,27,40,41,48,49])) {
            $v = 3;
        } else if (in_array($v,[6,7,14,15,28,29,36,37,44,45])) {
            $v = 4;
        } else if (in_array($v,[2,3,16,17,24,25,32,33,46,47])) {
            $v = 5;
        }
        return $v;
    }

    public static function jiaqinyeshou100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[2,4,5,6,8,9,14,16,17,18,20,21,26,28,29,30,32,33,38,40,41,42,44,45])) {//家
            $v = 1;
        }else if (in_array($v,[1,3,7,10,11,12,13,15,19,22,23,24,25,27,31,34,35,36,37,39,43,46,47,48,49])) {//野
            $v = 2;
        }
        return $v;
    }

    public static function nannvshengxiao100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[1,2,3,5,7,9,11,13,14,15,17,19,21,23,25,26,27,29,31,33,35,37,38,39,41,43,45,47,49])) {//男
            $v = 1;
        }else if (in_array($v,[4,6,8,10,12,16,18,20,22,24,28,30,32,34,36,40,42,44,46,48])) {//女
            $v = 2;
        }
        return $v;
    }

    public static function tiandixiao100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[2,4,7,9,11,12,14,16,19,21,23,24,26,28,31,33,35,36,38,40,43,45,47,48])) {//天
            $v = 1;
        }else if (in_array($v,[1,3,5,6,8,10,13,15,17,18,20,22,25,27,29,30,32,34,37,39,41,42,44,46,49])) {//地
            $v = 2;
        }
        return $v;
    }

    public static function siji100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[1,11,12,13,23,24,25,35,36,37,47,48,49])) {//春
            $v = 1;
        } else if (in_array($v,[8,9,10,20,21,22,32,33,34,44,45,46])) {//夏
            $v = 2;
        } else if (in_array($v,[5,6,7,17,18,19,29,30,31,41,42,43])) {//秋
            $v = 3;
        } else if (in_array($v,[2,3,4,14,15,16,26,27,28,38,39,40])) {//冬
            $v = 4;
        }
        return $v;
    }

    public static function qinqishuhua100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[6,10,12,18,22,24,30,34,36,42,46,48])) {//琴
            $v = 1;
        } else if (in_array($v,[2,3,5,14,15,17,26,27,29,38,39,41])) {//棋
            $v = 2;
        } else if (in_array($v,[1,9,11,13,21,23,25,33,35,37,45,47,49])) {//书
            $v = 3;
        } else if (in_array($v,[4,7,8,16,19,20,28,31,32,40,43,44])) {//画
            $v = 4;
        }
        return $v;
    }

    public static function sanseshengxiao100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[3,6,9,12,15,18,21,24,27,30,33,36,39,42,45,48])) {//红
            $v = 1;
        } else if (in_array($v,[2,5,8,11,14,17,20,23,26,29,32,35,38,41,44,47])) {//绿
            $v = 3;
        } else if (in_array($v,[1,4,7,10,13,16,19,22,25,28,31,34,37,40,43,46,49])) {//蓝
            $v = 2;
        }
        return $v;
    }

    public static function honglvlan100b($v)
    {
        if ($v == '') return '';
        if (in_array($v,[1,2,7,8,12,13,18,19,23,24,29,30,34,35,40,45,46])) {
            $v = 1;
        } else if (in_array($v,[5,6,11,16,17,21,22,27,28,32,33,38,39,43,44,49])) {
            $v = 2;
        } else if (in_array($v,[3,4,9,10,14,15,20,25,26,31,36,37,41,42,47,48])) {
            $v = 3;
        }
        return $v;
    }

    public static function qisebo100b($qiuarr){
        $hong = 0;
        $lv = 0;
        $lan = 0;
        $te = 0;
        for ($i = 0;$i <count($qiuarr);$i++){
            $item = $qiuarr[$i];
            if($i <= 5){
                if(self::honglvlan100b($item) == 1)$hong++;
                if(self::honglvlan100b($item) == 2)$lv++;
                if(self::honglvlan100b($item) == 3)$lan++;
            }else{
                $te = self::honglvlan100b($item);
                if($te == 1)$hong = $hong+1.5;
                if($te == 2)$lv = $lv+1.5;
                if($te == 3)$lan = $lan+1.5;
            }
        }
        if(($lan == 3 && $lv == 3 && $te == 1) || ($lan == 3 && $hong == 3 && $te == 2) || ($lv == 3 && $hong == 3 && $te == 3)){
            return 3;
        }elseif ($hong > $lan && $hong > $lv){
            return 0;
        }elseif ($lv > $lan && $lv > $hong){
            return 1;
        }elseif ($lan > $lv && $lan > $hong){
            return 2;
        }
    }

    public static function dsduo($balls){
        $shuangcount = 0;
        $dancount = 0;
        for($x = 0;$x < count($balls);$x++){
            if($balls[$x]%2 == 0){
                $shuangcount++;
            }else{
                $dancount++;
            }
        }
        if($shuangcount > $dancount){
            return -1;
        }elseif ($shuangcount < $dancount){
            return 1;
        }else{
            return 0;
        }
    }

    public static function qhduo($balls){
        $qiancount = 0;
        $houcount = 0;
        for($x = 0;$x < count($balls);$x++){
            if($balls[$x] <= 40){
                $qiancount++;
            }else{
                $houcount++;
            }
        }
        if($qiancount > $houcount){
            return 1;
        }elseif ($qiancount < $houcount){
            return -1;
        }else{
            return 0;
        }
    }

    public static function zhdanshuangdaxiao($total){
        if($total == 810){
            return 5;
        }
        if($total > 810){
            if($total%2 == 1){
                return 1;
            }else{
                return 2;
            }
        }else{
            if($total%2 == 1){
                return 3;
            }else{
                return 4;
            }
        }
    }

/*    public static function yxx(){
        $arr = ['鱼', '虾', '葫芦', '金钱', '蟹', '鸡'];
        return
    }*/

    public static function daxiaow555($v)
    {
        if ($v == 11) {
            $v = '和';
        } else if ($v >= 5) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function danshuang121($v)
    {
        if ($v == 11) {
            $v = '和';
        } else {
            if ($v % 2 == 1) {
                $v = '单';
            } else {
                $v = '双';
            }
        }
        return $v;
    }

    public static function daxiao555($v)
    {
        if ($v == 11) {
            $v = '和';
        } else if ($v > 12) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function danshuang555($v)
    {
        if ($v == 11) {
            $v = '和';
        } else {
            if ($v % 2 == 1) {
                $v = '单';
            } else {
                $v = '双';
            }
        }
        return $v;
    }

    public static function ds($gid, $v)
    {
        if (($gid == 121 | $gid == 123 | $gid == 125) & $v == 11) {
            return "和";
        } else if (($gid == 161 | $gid == 162) & $v == 810) {
            return "和";
        }  else if (($gid == 555) & $v == 55) {
            return "和";
        } else if ($v % 2 == 0)
            return "双";
        else
            return "单";
    }

    public static function daxiao103($v)
    {
        if ($v > 10) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiao103b($v){
        if ($v > 10) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function daxiao151b($v){
        if ($v > 3) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function temadaxiao100b($v){
        if($v == 49){
            return 2;
        }
        if ($v >= 25) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function temahedaxiao100b($v){
        if ($v >= 7) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function temaweidaxiao100b($v){
        if($v == 49){
            return 2;
        }
        $v = $v%10;
        if ($v >= 5) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function temadanshuang100b($v){
        if($v == 49){
            return 2;
        }
        if ($v%2 == 1) {
            $v = 0;
        } else {
            $v = 1;
        }
        return $v;
    }

    public static function daxiaobi103($dabi,$xiaobi){
        if($dabi == 0 && $xiaobi == 8){
            return 16;
        }elseif($dabi == 1 && $xiaobi == 7){
            return 17;
        }elseif($dabi == 2 && $xiaobi == 6){
            return 18;
        }elseif($dabi == 3 && $xiaobi == 5){
            return 19;
        }elseif($dabi == 4 && $xiaobi == 4){
            return 20;
        }elseif($dabi == 5 && $xiaobi == 3){
            return 21;
        }elseif($dabi == 6 && $xiaobi == 2){
            return 22;
        }elseif($dabi == 7 && $xiaobi == 1){
            return 23;
        }elseif($dabi == 8 && $xiaobi == 0){
            return 24;
        }
    }

    public static function daxiaobi151($dabi,$xiaobi){
        if($dabi == 3 && $xiaobi == 0){
            return 12;
        }elseif($dabi == 2 && $xiaobi == 1){
            return 13;
        }elseif($dabi == 1 && $xiaobi == 2){
            return 14;
        }elseif($dabi == 0 && $xiaobi == 3){
            return 15;
        }
    }

    public static function xingtai151($v1,$v2,$v3){
        if($v1 == $v2 && $v2 == $v3){
            return 6;
        }elseif ($v1 != $v2 && $v2 != $v3){
            return 7;
        }else{
            return 8;
        }
    }

    public static function dacount151($balls){
        $count = 0;
        foreach ($balls as $item){
            if($item > 3){
                $count++;
            }
        }
        return $count;
    }

    public static function dancount151($balls){
        $count = 0;
        foreach ($balls as $item){
            if($item%2 == 1){
                $count++;
            }
        }
        return $count;
    }

    public static function xiaocount151($balls){
        $count = 0;
        foreach ($balls as $item){
            if($item <= 3){
                $count++;
            }
        }
        return $count;
    }

    public static function shuangcount151($balls){
        $count = 0;
        foreach ($balls as $item){
            if($item%2 == 0){
                $count++;
            }
        }
        return $count;
    }

    public static function daxiao103bc($v){
        if ($v > 10) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function zda103b($v){
        if ($v < 84)
            return 1;
        else if ($v > 84)
            return 0;
        else
            return 2;
    }

    public static function daxiao444($v)
    {
        if ($v > 40) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiaow($v)
    {
        if ($v <= 4) {
            return '小';
        } else {
            return '大';
        }
    }

    public static function daxiaowb($v)
    {
        if ($v <= 4) {
            return 1;
        } else {
            return 0;
        }

    }

    public static function daxiaowbc($v)
    {
        if ($v <= 4) {
            return 0;
        } else {
            return 1;
        }

    }

    public static function daxiaow121bc($v)
    {
        if ($v <= 4) {
            return -1;
        } else {
            return 1;
        }
    }

    public static function zhihe($v)
    {
        //global $zhishu;
        if (in_array($v, self::$zhishu)) {
            $v = '质';
        } else {
            $v = '合';
        }
        return $v;
    }

    public static function heshu($tm)
    {
        if ($tm == '') {
            return '';
        }
        $heshu = $tm % 10 + ($tm - $tm % 10) / 10;
        return $heshu;
    }

    public static function heshudaxiao_100($v)
    {
        if ($v == 13) {
            return "和";
        } else if ($v <= 6) {
            return "合小";
        } else {
            return "合大";
        }
    }

    public static function longhuhe($v0, $v4)
    {
        $v0 = $v0 + 0;
        $v4 = $v4 + 0;
        if ($v0 > $v4) {
            $v = '龙';
        } else {
            if ($v0 < $v4) {
                $v = '虎';
            } else {
                $v = '和';
            }
        }
        return $v;
    }

    public static function duizhi($v1, $v2, $v3)
    {
        if ($v1 == $v2 | $v1 == $v3 | $v2 == $v3) {
            $v = 1;
        } else {
            $v = 0;
        }
        if ($v == 1) {
            $vv = self::baozhi($v1, $v2, $v3);
            if ($vv == 1) {
                $v = 0;
            }
        }
        return $v;
    }

    public static function baozhi($v1, $v2, $v3)
    {
        if ($v1 == $v2 & $v1 == $v3 & $v2 == $v3) {
            $v = 1;
        } else {
            $v = 0;
        }
        return $v;
    }

    public static function shunzhi($v1, $v2, $v3)
    {
        $vh = $v1 + $v2 + $v3;
        $v = 0;
        if ($vh % 3 == 0 & $v1 != $v2 & $v1 != $v3 & $v2 != $v3 & max($v1, $v2, $v3) - min($v1, $v2, $v3) == 2) {
            $v = 1;
        } else {
            if (strpos('[019]', $v1) != false & strpos('[019]', $v2) != false & strpos('[019]', $v3) != false & $v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                if ($v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                    $v = 1;
                }
            } else {
                if (strpos('[890]', $v1) != false & strpos('[890]', $v2) != false & strpos('[890]', $v3) != false & $v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                    if ($v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                        $v = 1;
                    }
                }
            }
        }
        return $v;
    }

    public static function shunzhi121($v1, $v2, $v3)
    {
        $vh = $v1 + $v2 + $v3;
        $v = 0;
        if ($vh % 3 == 0 & $v1 != $v2 & $v1 != $v3 & $v2 != $v3 & max($v1, $v2, $v3) - min($v1, $v2, $v3) == 2) {
            $v = 1;
        }
        return $v;
    }

    public static function banshun($v1, $v2, $v3)
    {
        $vh1 = abs($v1 - $v2);
        $vh2 = abs($v1 - $v3);
        $vh3 = abs($v2 - $v3);
        if (self::baozhi($v1, $v2, $v3) == 1) {
            $z = 0;
        } else {
            if (self::shunzhi($v1, $v2, $v3) == 1) {
                $z = 0;
            } else {
                if (self::duizhi($v1, $v2, $v3) == 1) {
                    $z = 0;
                } else {
                    if ($vh1 == 1 | $vh2 == 1 | $vh3 == 1) {
                        $z = 1;
                    } else {
                        if (strpos('[' . $v1 . $v2 . $v3 . ']', '0') != false & strpos('[' . $v1 . $v2 . $v3 . ']', '9') != false) {
                            $z = 1;
                        } else {
                            $z = 0;
                        }
                    }
                }
            }
        }
        return $z;
    }

    public static function banshun121($v1, $v2, $v3)
    {
        $vh1 = abs($v1 - $v2);
        $vh2 = abs($v1 - $v3);
        $vh3 = abs($v2 - $v3);
        $z = 0;
        if (self::baozhi($v1, $v2, $v3) == 1) {
            $z = 0;
        } else {
            if (self::shunzhi121($v1, $v2, $v3) == 1) {
                $z = 0;
            } else {
                if (self::duizhi($v1, $v2, $v3) == 1) {
                    $z = 0;
                } else {
                    if ($vh1 == 1 | $vh2 == 1 | $vh3 == 1) {
                        $z = 1;
                    }
                }
            }
        }
        return $z;
    }

    public static function zaliu($v1, $v2, $v3)
    {
        if (self::baozhi($v1, $v2, $v3) == 1) {
            $z = 0;
        } else {
            if (self::shunzhi($v1, $v2, $v3) == 1) {
                $z = 0;
            } else {
                if (self::duizhi($v1, $v2, $v3) == 1) {
                    $z = 0;
                } else {
                    if (self::banshun($v1, $v2, $v3) == 1) {
                        $z = 0;
                    } else {
                        $z = 1;
                    }
                }
            }
        }
        return $z;
    }

    public static function siji($v)
    {
        //if(strpos('anull',$v)) return '';
        if (in_array($v, array(
            1,
            2,
            3,
            4,
            5
        ))) {
            $v = '春';
        } else {
            if (in_array($v, array(
                6,
                7,
                8,
                9,
                10
            ))) {
                $v = '夏';
            } else {
                if (in_array($v, array(
                    11,
                    12,
                    13,
                    14,
                    15
                ))) {
                    $v = '秋';
                } else {
                    if (in_array($v, array(
                        16,
                        17,
                        18,
                        19,
                        20
                    ))) {
                        $v = '冬';
                    }
                }
            }
        }
        return $v;
    }

    public static function wuhang($v)
    {
        //if(strpos('anull',$v)) return '';
        if (in_array($v, array(
            5,
            10,
            15,
            20
        ))) {
            $v = '金';
        } else {
            if (in_array($v, array(
                1,
                6,
                11,
                16
            ))) {
                $v = '木';
            } else {
                if (in_array($v, array(
                    2,
                    7,
                    12,
                    17
                ))) {
                    $v = '水';
                } else {
                    if (in_array($v, array(
                        3,
                        8,
                        13,
                        18
                    ))) {
                        $v = '火';
                    } else {
                        if (in_array($v, array(
                            4,
                            9,
                            14,
                            19
                        ))) {
                            $v = '土';
                        }
                    }
                }
            }
        }
        return $v;
    }

    public static function wuhang_161($v)
    {
        if ($v <= 695) {
            $v = '金';
        } else if ($v <= 763) {
            $v = '木';
        } else if ($v <= 855) {
            $v = '水';
        } else if ($v <= 923) {
            $v = '火';
        } else {
            $v = '土';
        }
        return $v;
    }

    public static function fangweibc($v){
        if (in_array($v, array(1,5,9,13,17))) {
            $v = 5;
        } else {
            if (in_array($v, array(2,6,10,14,18))) {
                $v = 6;
            } else {
                if (in_array($v, array(3,7,11,15,19))) {
                    $v = 7;
                } else {
                    if (in_array($v, array(4,8,12,16,20))) {
                        $v = 8;
                    }
                }
            }
        }
        return $v;
    }

    public static function fangwei($v)
    {
        if (in_array($v, array(
            1,
            5,
            9,
            13,
            17
        ))) {
            $v = '东';
        } else {
            if (in_array($v, array(
                2,
                6,
                10,
                14,
                18
            ))) {
                $v = '南';
            } else {
                if (in_array($v, array(
                    3,
                    7,
                    11,
                    15,
                    19
                ))) {
                    $v = '西';
                } else {
                    if (in_array($v, array(
                        4,
                        8,
                        12,
                        16,
                        20
                    ))) {
                        $v = '北';
                    }
                }
            }
        }
        return $v;
    }

    public static function zhongfabai($v)
    {
        //if(strpos('anull',$v)) return '';
        if (in_array($v, array(
            1,
            2,
            3,
            4,
            5,
            6,
            7
        ))) {
            $v = '中';
        } else {
            if (in_array($v, array(
                8,
                9,
                10,
                11,
                12,
                13,
                14
            ))) {
                $v = '发';
            } else {
                if (in_array($v, array(
                    15,
                    16,
                    17,
                    18,
                    19,
                    20
                ))) {
                    $v = '白';
                }
            }
        }
        return $v;
    }

    public static function sx_100($m, $arr)
    {
        $sx = array(
            "鼠",
            "牛",
            "虎",
            "兔",
            "龍",
            "蛇",
            "馬",
            "羊",
            "猴",
            "雞",
            "狗",
            "豬"
        );
        foreach ($sx as $v) {
            if (in_array($m, $arr[$v])) {
                return $v;
            }
        }
        return false;
    }

    public static function getkjarr($tb,$mnum, $gid,$page, $psize){
        $db = Db::connection('kjw');
        $sql = '';
        for ($i = 1; $i <= $mnum; $i++) {
            if ($i > 1) {
                $sql .= ',';
            }
            $sql .= 'm' . $i;
        }
        $list = $db->select("select {$sql} from $tb where gid='{$gid}'  and status = 1 order by qishu desc limit " . ($page - 1) * $psize . ",{$psize}");
        $kj = array();
        $j = 0;
        foreach ($list as $item) {
            $qiuarr = [];
            for ($i = 0; $i < $mnum; $i++) {
                $qiuarr[$i] = $item['m' . ($i+1)];
            }
            array_unshift($kj,$qiuarr);
            $j++;
        }
        return $kj;
    }

    public static function phpC($a, $m){
        $r = array();
        $n = count($a);
        if ($m <= 0 || $m > $n) {
            return $r;
        }
        for ($i = 0; $i < $n; $i++) {
            $t = array($a[$i]);
            if ($m == 1) {
                $r[] = $t;
            } else {
                $b = array_slice($a, $i + 1);
                $c = self::phpC($b, $m - 1);
                foreach ($c as $v) {
                    $r[] = array_merge($t, $v);
                }
            }
        }
        return $r;
    }

    public static function phpC2(array $elements, $chosen)
    {
        $result = array();
        for ($i = 0; $i < $chosen; $i++) {
            $vecm[$i] = $i;
        }
        for ($i = 0; $i < $chosen - 1; $i++) {
            $vecb[$i] = $i;
        }
        $vecb[$chosen - 1] = count($elements) - 1;
        $result[] = $vecm;
        $mark = $chosen - 1;
        while (true) {
            if ($mark == 0) {
                $vecm[0]++;
                $result[] = $vecm;
                if ($vecm[0] == $vecb[0]) {
                    for ($i = 1; $i < $chosen; $i++) {
                        if ($vecm[$i] < $vecb[$i]) {
                            $mark = $i;
                            break;
                        }
                    }
                    if ($i == $chosen && $vecm[$chosen - 1] == $vecb[$chosen - 1]) {
                        break;
                    }
                }
            } else {
                $vecm[$mark]++;
                $mark--;
                for ($i = 0; $i <= $mark; $i++) {
                    $vecb[$i] = $vecm[$i] = $i;
                }
                $vecb[$mark] = $vecm[$mark + 1] - 1;
                $result[] = $vecm;
            }
        }
        return $result;
    }

    public static function zhdx($gid, $v)
    {
        if (in_array($gid, array(101,111,113,115))) {
            if ($v <= 22)
                return "小";
            else
                return "大";
        } else if (in_array($gid, array(117,163))) {
            if ($v <= 13)
                return "小";
            else
                return "大";
        } else if (in_array($gid, array(121,123,125))) {
            if ($v < 30)
                return "小";
            else if ($v > 30)
                return "大";
            else
                return "和";
        } else if (in_array($gid, array(103,133,135))) {
            if ($v < 84)
                return "小";
            else if ($v > 84)
                return "大";
            else
                return "和";
        } else if (in_array($gid, array(151,152))) {
            if ($v <= 10)
                return "小";
            else
                return "大";
        } else if (in_array($gid, array(161,162))) {
            if ($v < 810)
                return "小";
            else if ($v > 810)
                return "大";
            else
                return "和";
        } else if ($gid == 107) {
            if ($v <= 11)
                return "小";
            else
                return "大";
        } else if ($gid == 100) {
            if ($v <= 174)
                return "小";
            else
                return "大";
        } else if ($gid == 444) {
            if ($v <= 202)
                return "小";
            else
                return "大";
        } else if ($gid == 555) {
            if($v == 55){
                return "和";
            }else{
                if ($v <= 54)
                    return "小";
                else
                    return "大";
            }

        }
    }

    public static function dx($gid, $v){
        if (in_array($gid, array(101,111,113,115))) {
            if ($v <= 4)
                return "小";
            else
                return "大";
        } else if (in_array($gid, array(121,123,125))) {
            if ($v < 6)
                return "小";
            else if ($v < 10)
                return "大";
            else
                return "和";
        } else if (in_array($gid, array(103,133,135))) {
            if ($v < 11)
                return "小";
            return "大";
        } else if (in_array($gid, array(151,152))) {
            if ($v <= 3)
                return "小";
            else
                return "大";
        } else if (in_array($gid, array(161,162))) {
            if ($v < 41)
                return "小";
            else
                return "大";
        } else if ($gid == 107) {
            if ($v <= 5)
                return "小";
            else
                return "大";
        } else if ($gid == 100) {
            if ($v < 25)
                return "小";
            else if ($v < 49)
                return "大";
            else
                return "和";
        }
    }


    public static function getpk10nium($kj, $arr)
    {
        $a = [];
        $arr = explode('-', $arr);
        foreach ($arr as $v) {
            $a[] = $kj[$v - 1];
        }
        return $a;
    }

    public static function bjniuniu($a1, $a2, $pk10ts)
    {
        //echo $a1[0];
        if (!$a1[0] & $a2[0]) {
            return 1;
        }
        if ($a1[0] & !$a2[0]) {
            return 0;
        }
        if ($a1[0] & $a2[0]) {
            if ($a1[2] == 0) $a1[2] = 10;
            if ($a2[2] == 0) $a2[2] = 10;
            if ($a1[2] > $a2[2]) {
                return 0;
            } else if ($a1[2] == $a2[2]) {
                return 2;
            } else if ($a1[2] < $a2[2]) {
                return 1;
            }
        }

        if (!$a1[0] & !$a2[0]) {
            if ($a2[3] < $pk10ts) {
                return 0;
            }
            if ($a1[3] > $a2[3]) {
                return 0;
            } else if ($a1[3] == $a2[3]) {
                return 2;
            } else if ($a1[3] < $a2[3]) {
                return 1;
            }
        }
        return 0;

    }

    public static function writelog($loginfo)
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/yhgzs/tongbu_' . date('y-m-d') . '.txt';
        if (!is_file($file)) {
            file_put_contents($file, '', FILE_APPEND);//如果文件不存在，则创建一个新文件。
        }
        $contents = json_encode($loginfo) . "\r\n";
        file_put_contents($file, $contents, FILE_APPEND);
    }

    public static function getduoarrssuser($fenlei,$name){

        if($fenlei==101 || $fenlei==163){
            if((strpos('['.$name.']','组')>0)){
                $pl = array("0","1","2","3","4","5","6","7","8","9");
            }else{
                $names = str_replace('定位','',$name);
                $nl = strlen($names);
                if($nl==6){
                    $pl = array("0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9");
                }else{
                    if(strpos('['.$name.']','前三')){
                        $pl = array("0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9");
                    }else if(strpos('['.$name.']','中三')){
                        $pl = array("0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9");
                    }else{
                        $pl = array("0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9");
                    }
                }
            }
        }else if($fenlei==121){
            if($name=='选前二直选'){
                $pl = array("01","02","03","04","05","06","07","08","09","10","11","01","02","03","04","05","06","07","08","09","10","11");
            }else if($name=='选前三直选'){
                $pl = array("01","02","03","04","05","06","07","08","09","10","11","01","02","03","04","05","06","07","08","09","10","11","01","02","03","04","05","06","07","08","09","10","11");
            }else{
                $pl = array("01","02","03","04","05","06","07","08","09","10","11");
            }
        }else if($fenlei==107){
            $pl = array("1","2","3","4","5","6","7","8","9","10");
        }else if($fenlei==103){
            if($name=='选二连直'){
                $pl = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20");
            }else if($name=='选三前直'){
                $pl = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20");
            }else{
                $pl = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20");
            }
        }
        return $pl;
    }

    public static function getduoarr($name){
        if(strpos($name,'肖')>0){
            $pl = array("鼠","牛","虎","兔","龍","蛇","馬","羊","猴","雞","狗","豬");
        }else if(strpos($name,'尾')>0){
            $pl = array("0尾","1尾","2尾","3尾","4尾","5尾","6尾","7尾","8尾","9尾");
        }else{
            $pl = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49");
        }
        return $pl;
    }

    public static function rduokeydw($arr,$v1,$kk){
        foreach($arr as $key => $v2){
            if($v2==$v1){
                return $key+$kk*10;
            }
        }
    }

    public static function rduokeyklsf($arr,$v1,$kk){
        foreach($arr as $key => $v2){
            if($v2==$v1){
                return $key+$kk*20;
            }
        }
    }

    public static function rduokeysyxw($arr,$v1,$kk){
        foreach($arr as $key => $v2){
            if($v2==$v1){
                return $key+$kk*11;
            }
        }
    }

    public static function calcmoni($fenlei, $gid)
    {
        return self::suiji($fenlei, $gid);
    }

    public static function suiji($fenlei, $gid){
        switch ($fenlei) {
            case '101':
                return self::suijikj($gid, 5);
                break;
            case '107':
                return self::suijikj($gid, 10);
                break;
            case '151':
                return self::suijikj($gid, 3);
                break;
            case '161':
                return self::suijikj($gid, 21);
                break;
            case '163':
                return self::suijikj($gid, 4);
                break;
            case '121':
                return self::suijikj($gid, 6);
                break;
            case '103':
                return self::suijikj($gid, 8);
                break;
            case '100':
                return self::suijikj($gid, 7);
                break;
        }
    }

    public static function suijikj($gid,$mnum,$qtarr = []){
        $m = array();
        switch ($mnum) {
            case 4:
                $arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                $m[0] = $arr[rand(0, 9)];
                $m[1] = $arr[rand(0, 9)];
                $m[2] = $arr[rand(0, 9)];
                break;
            case 3:
                $arr = [1, 2, 3, 4, 5, 6];
                $m[0] = $arr[rand(0, 5)];
                $m[1] = $arr[rand(0, 5)];
                $m[2] = $arr[rand(0, 5)];
                break;
            case 5:
                $arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                $m[0] = $arr[rand(0, 9)];
                $m[1] = $arr[rand(0, 9)];
                $m[2] = $arr[rand(0, 9)];
                $m[3] = $arr[rand(0, 9)];
                $m[4] = $arr[rand(0, 9)];
                break;
            case 8:
                $arr = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20"];
                $m[0] = $arr[rand(0, 19)];
                for ($i = 1; $i < 8; $i++) {
                    $m[$i] = self::randm($m, $arr, $mnum, 20);
                }
                break;
            case 6:
                $arr = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"];
                $m[0] = $arr[rand(0, 10)];
                for ($i = 1; $i < 5; $i++) {
                    $m[$i] = self::randm($m, $arr, $mnum, 11);
                }
                break;
            case 21:
                for ($i = 1; $i <= 80; $i++) {
                    if ($i < 10) {
                        $arr[$i - 1] = '0' . $i;
                    } else {
                        $arr[$i - 1] = $i;
                    }
                }
                $m[0] = $arr[rand(0, 79)];
                for ($i = 1; $i < 20; $i++) {
                    $m[$i] = self::randm($m, $arr, $mnum, 80);
                }
                $d = [1,2,3,4,5,10];
                $m[20] = $d[rand(0, 5)];
                break;
            case 7:
                for ($i = 1; $i <= 49; $i++) {
                    if ($i < 10) {
                        $arr[$i - 1] = '0' . $i;
                    } else {
                        $arr[$i - 1] = $i;
                    }
                }
                $m[0] = $arr[rand(0, 48)];
                for ($i = 1; $i < 7; $i++) {
                    $m[$i] = self::randm($m, $arr, $mnum, 49);
                }
                break;
            case 10:
                $arr = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10"];
                $m[0] = $arr[rand(0, 9)];
                for ($i = 1; $i < 10; $i++) {
                    $m[$i] = self::randm($m, $arr, $mnum, 10);
                }
                break;
        }
        return $m;
    }

    public static function randm($m, $arr, $mnum, $maxs){
        $a = $arr[rand(0, $maxs - 1)];
        if (in_array($a, $m)) return self::randm($m, $arr, $mnum, $maxs);
        else return $a;
    }

    public static function curl_post($type, $url, $cookie = '', $post_data = array()){
        if (empty($url)) {
            return false;
        }
        $jsonStr = json_encode($post_data);
        $headers = array(
            "Content-Type: application/json",
            "Content-Length: " . strlen($jsonStr) . "",
            "Accept: application/json",
            "X-Requested-With:XMLHttpRequest",
            "Host:yun.citi668.com",
            "Origin:http://yun.citi668.com",
        );
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        if ($type) {  //判断请求协议http或https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36'); // 模拟用户使用的浏览器
        if (!empty($cookie)) curl_setopt($ch, CURLOPT_COOKIE, $cookie);  //设置cookie
        // 在尝试连接时等待的秒数
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        // 最大执行时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

    public static function shengxiaos($ma, $bml)
    {
        $jiazhi = array('甲子', '乙丑', '丙寅', '丁卯', '戊辰', '己巳', '庚午', '辛未', '壬申', '癸酉', '甲戌', '乙亥', '丙子', '丁丑', '戊寅', '己卯', '庚辰', '辛巳', '壬午', '癸未', '甲申', '乙酉', '丙戌', '丁亥', '戊子', '己丑', '庚寅', '辛卯', '壬辰', '癸巳', '甲午', '乙未', '丙申', '丁酉', '戊戌', '己亥', '庚子', '辛丑', '壬寅', '癸卯', '甲辰', '乙巳', '丙午', '丁未', '戊申', '己酉', '庚戌', '辛亥', '壬子', '癸丑', '甲寅', '乙卯', '丙辰', '丁巳', '戊午', '己未', '庚申', '辛酉', '壬戌', '癸亥');
        $index = 0;
        foreach ($jiazhi as $key => $val) {
            if ($val == $bml) {
                $index = $key;
                break;
            }
        }
        $index = $index % 12 + 1;
        $ma = $ma % 12;
        $arr = array('鼠', '牛', '虎', '兔', '龍', '蛇', '馬', '羊', '猴', '雞', '狗', '豬');
        $in= 0 ;
        if ($index >= $ma) {
            $in = $index - $ma;
        } else {
            $in =  $index - $ma + 12;
        }
        if($in>=12) $in -=12;
        return $in+1;
    }
}
