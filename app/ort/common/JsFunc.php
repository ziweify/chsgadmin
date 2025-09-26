<?php


namespace App\ort\common;

use App\Models\Game\Kj;
use App\Models\Game\Sclass;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Type;

class JsFunc
{
    public static $zhishu = array(1, 2, 3, 5, 7);
    public static $heshu = array(0, 4, 6, 8, 9);
    public static $dashu = array(5, 6, 7, 8, 9);
    public static $xiaoshu = array(0, 1, 2, 3, 4);

    public static function nndaxiao($v){
        if ($v >= 1 & $v <= 5) {
            return '小';
        } else {
            return '大';
        }
    }

    public static function niuniu($arr){
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        for ($a = 0; $a <= 2; $a++) {
            for ($b = $a + 1; $b <= 3; $b++) {
                for ($c = $b + 1; $c <= 4; $c++) {
                    if (($arr[$a] + $arr[$b] + $arr[$c]) % 10 == 0) {
                        $t1 = 1;
                        $t3 = 0;
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
        return $arr;
    }

    public static function niuniures($nn,$type=1){
        if ($nn[0]) {
            switch ($nn[2]) {
                case 0:
                    return $type == 1 ? '牛牛' : 10;
                case 1:
                    return $type == 1 ? '牛一' : 1;
                case 2:
                    return $type == 1 ? '牛二' : 2;
                case 3:
                    return $type == 1 ? '牛三' : 3;
                case 4:
                    return $type == 1 ? '牛四' : 4;
                case 5:
                    return $type == 1 ? '牛五' : 5;
                case 6:
                    return $type == 1 ? '牛六' : 6;
                case 7:
                    return $type == 1 ? '牛七' : 7;
                case 8:
                    return $type == 1 ? '牛八' : 8;
                case 9:
                    return $type == 1 ? '牛九' : 9;
            }
        }else{
            return $type == 1 ? '无牛' : 0;
        }
    }

    public static function suoha($arr){
        $r = 0;//散号
        $a = array();
        foreach ($arr as $v) {
            isset($a[$v]) ? $a[$v]++ : $a[$v] = 1;
        }
        $a = array_merge($a);
        $na = [];
        $index = 0;
        foreach ($a as $v) {
            $na[$index] = $v;
            $index++;
        }
        $a = $na;
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

    public static function dndx($n,$v,$type = 1){
        if($n){
            if (in_array($v, [1,2,3,4,5])) {
                return $type == 1 ? '牛小' : ($type == 4 ? '小' : 'X');
            } else {
                return $type == 1 ? '牛大' : ($type == 4 ? '大' : 'D');
            }
        }else{
            return $type == 1 ? '无牛' : ($type == 4 ? '输' : 'LOSE');
        }
    }

    public static function dnds($n,$v,$type = 1){
        if($n){
            if (in_array($v, [1,3,5,7,9])) {
                return $type == 1 ? '牛单' : ($type == 4 ? '单' :'D');
            } else {
                return $type == 1 ? '牛双' : ($type == 4 ? '双' :'S');
            }
        }else{
            return $type == 1 ? '无牛' : ($type == 4 ? '通吃' :'LOSE');
        }
    }

    public static function douniusuoha($arr,$type = 1){
        $r = 0;//高牌
        $a = array();
        foreach ($arr as $v) {
            isset($a[$v]) ? $a[$v]++ : $a[$v] = 1;
        }
        $a = array_merge($a);
        $na = [];
        $index = 0;
        foreach ($a as $v) {
            $na[$index] = $v;
            $index++;
        }
        $a = $na;
        $ca = count($a);
        switch ($ca) {
            case 1:
                $r = 1;//五条
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
                //开奖的五个号码位置不限，出现包含下例十组号码：01234、12345、23456、34567、45678、56789、67890、78901、89012、90123，出现以上号码即算中奖
                $str = implode('',$arr);
                if(strpos($str,'01234') !== false
                    || strpos($str,'12345') !== false
                    || strpos($str,'23456') !== false
                    || strpos($str,'34567') !== false
                    || strpos($str,'45678') !== false
                    || strpos($str,'56789') !== false
                    || strpos($str,'06789') !== false
                    || strpos($str,'01789') !== false
                    || strpos($str,'12890') !== false
                    || strpos($str,'01289') !== false
                    || strpos($str,'01239') !== false){
                    $r = 7;//顺子
                }
                break;
        }
        if($type == 1){
            $arr = array("高牌", "五条", "四条", "葫芦", "三条", "两对", "一对", "顺子");
        }else{
            $arr = array("GP", "WT", "SIT", "HL", "SANT", "LD", "YD", "SHUNZ");
        }
        return $arr[$r];
    }

    public static function qita($v1, $v2, $v3,$type = 1){
        $v = 9;
        if (self::baozhi($v1, $v2, $v3) == 1) $v = 0;
        else if (self::shunzhi($v1, $v2, $v3) == 1) $v = 1;
        else if (self::duizhi($v1, $v2, $v3) == 1) $v = 2;
        else if (self::banshun($v1, $v2, $v3) == 1) $v = 3;
        else $v = 4;
        if($type == 1){
            $arr = array("豹子", "顺子", "对子", "半顺", "杂六");
        }elseif($type == 2){
            $arr = array("BZ", "SZ", "DZ", "BS", "ZL");
        }elseif ($type == 3){
            $arr = array(0,1,2,3,4);
        }
        return $arr[$v];
    }

    public static function danshuang($v){
        if ($v % 2 == 1) {
            $v = '单';
        } else {
            $v = '双';
        }
        return $v;
    }

    public static function danshuang_555($v){
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

    public static function danshuang_100($v){
        if ($v % 2 == 1) {
            $v = '單';
        } else {
            $v = '雙';
        }
        return $v;
    }

    public static function daxiao($v){
        if (in_array($v, self::$dashu)) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiao107($v){
        if ($v > 5) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiao121($v){
        if ($v == 11) {
            $v = '和';
        } else if ($v > 5) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiaow555($v){
        if ($v == 11) {
            $v = '和';
        } else if ($v >= 5) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function danshuang121($v){
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

    public static function daxiao555($v){
        if ($v == 11) {
            $v = '和';
        } else if ($v > 12) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function danshuang555($v){
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

    public static function ds($gid, $v,$type = 1){
        if (($gid == 121 || $gid == 123 || $gid == 125) && $v == 11) {
            return $type==1 ? "和" : ($type==2 ? 2 : "T");
        } else if (($gid == 161 || $gid == 162) && $v == 810) {
            return $type==1 ? "和" : ($type==2 ? 2 : "T");
        }  else if (($gid == 555) && $v == 55) {
            return $type==1 ? "和" : ($type==2 ? 2 : "T");
        } else if ($v % 2 == 0)
            return $type==1 ? "双" : ($type==2 ? 1 : "S");
        else
            return $type==1 ? "单" : ($type==2 ? 0 : "D");
    }

    public static function daxiao103($v){
        if ($v > 10) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiao444($v){
        if ($v > 40) {
            $v = '大';
        } else {
            $v = '小';
        }
        return $v;
    }

    public static function daxiaow($v,$type = 1){
        if ($v <= 4) {
            return $type == 1 ? "小" : "X";
        } else {
            return $type == 1 ? "大" : "D";
        }
    }

    public static function zhihe($v){
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

    public static function longhuhe($v0, $v4,$type = 1)
    {
        $v0 = $v0 + 0;
        $v4 = $v4 + 0;
        if ($v0 > $v4) {
            $v = $type==1 ? '龙' : 'L';
        } else {
            if ($v0 < $v4) {
                $v = $type==1 ? '虎' : 'H';
            } else {
                $v = $type==1 ? '和' : 'T';
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
            if (strpos('[019]', $v1) != false && strpos('[019]', $v2) != false && strpos('[019]', $v3) != false && $v1 != $v2 && $v1 != $v3 && $v2 != $v3) {
                if ($v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                    $v = 1;
                }
            } else {
                if (strpos('[890]', $v1) != false & strpos('[890]', $v2) != false & strpos('[890]', $v3) != false & $v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                    if ($v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                        $v = 1;
                    }
                }else{
                    if (strpos('[809]', $v1) != false & strpos('[809]', $v2) != false & strpos('[809]', $v3) != false & $v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                        if ($v1 != $v2 & $v1 != $v3 & $v2 != $v3) {
                            $v = 1;
                        }
                    }
                }
            }
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

    public static function siji($v){
        if (in_array($v, array(1,2,3,4,5))) {
            $v = '春';
        } else {
            if (in_array($v, array(6,7,8,9,10))) {
                $v = '夏';
            } else {
                if (in_array($v, array(11,12,13,14,15))) {
                    $v = '秋';
                } else {
                    if (in_array($v, array(16,17,18,19,20))) {
                        $v = '冬';
                    }
                }
            }
        }
        return $v;
    }

    public static function wuhang($v)
    {
        if (in_array($v, array(5,10,15,20))) {
            $v = '金';
        } else {
            if (in_array($v, array(1,6,11,16))) {
                $v = '木';
            } else {
                if (in_array($v, array(2,7,12,17))) {
                    $v = '水';
                } else {
                    if (in_array($v, array(3,8,13,18))) {
                        $v = '火';
                    } else {
                        if (in_array($v, array(4,9,14,19))) {
                            $v = '土';
                        }
                    }
                }
            }
        }
        return $v;
    }

    public static function yxx($index){
        $arr = ['鱼', '虾', '葫芦', '铜钱', '蟹', '鸡'];
        return $arr[$index-1];
    }

    public static function yuxiaxie($v,$type = 1){
        $s = '';
        if($v == 1){
            $s = $type == 1 ? '鱼' : 1;
        }elseif($v == 2){
            $s = $type == 1 ? '虾' : 2;
        }elseif ($v == 3){
            $s = $type == 1 ? '葫芦' : 3;
        }elseif ($v == 4){
            $s = $type == 1 ? '金钱' : 4;
        }elseif ($v == 5){
            $s = $type == 1 ? '螃蟹' : 5;
        }elseif ($v == 6){
            $s = $type == 1 ? '鸡' : 6;
        }
        return $s;
    }

    public static function wuhang_161($v,$type = 1){
        if ($v <= 695) {
            $v = $type==1 ? '金' : 0;
        } else if ($v <= 763) {
            $v = $type==1 ? '木' : 1;
        } else if ($v <= 855) {
            $v = $type==1 ? '水' : 2;
        } else if ($v <= 923) {
            $v = $type==1 ? '火' : 3;
        } else {
            $v = $type==1 ? '土' : 4;
        }
        return $v;
    }

    public static function qianhouhe($qian,$type = 1){
        if ($qian == 10) {
            return $type == 1 ? "前后(和)" : ($type == 4 ? "和" : 'T');
        } else if ($qian > 10) {
            return $type == 1 ? "前(多)" : ($type == 4 ? "前" : 'Q');
        } else if ($qian < 10) {
            return $type == 1 ? "后(多)" : ($type == 4 ? "後" : 'H');
        }else{
            return '';
        }
    }

    public static function danshuanghe($dan,$type = 1){
        if ($dan == 10) {
            return $type == 1 ? "单双(和)" : ($type == 4 ? '和' : 'T');
        } else if ($dan < 10) {
            return $type == 1 ? "双(多)" : ($type == 4 ? '双' : 'S');
        } else if ($dan > 10) {
            return $type == 1 ? "单(多)" : ($type == 4 ? '单' : 'D');
        }else{
            return '';
        }
    }

    public static function fangwei($v,$type = 1)
    {
        if (in_array($v, array(1,5,9,13,17))) {
            $v = $type == 1 ? '东' : 1;
        } else {
            if (in_array($v, array(2,6,10,14,18))) {
                $v = $type == 1 ? '南' : 2;
            } else {
                if (in_array($v, array(3,7,11,15,19))) {
                    $v = $type == 1 ? '西' : 3;
                } else {
                    if (in_array($v, array(4,8,12,16,20))) {
                        $v = $type == 1 ? '北' : 4;
                    }
                }
            }
        }
        return $v;
    }

    public static function zhongfabai($v,$type = 1)
    {
        if (in_array($v, array(1,2,3,4,5,6,7))) {
            $v = $type == 1 ? '中' : 1;
        } else {
            if (in_array($v, array(8,9,10,11,12,13,14))) {
                $v = $type == 1 ? '发' : 2;
            } else {
                if (in_array($v, array(15,16,17,18,19,20))) {
                    $v = $type == 1 ? '白' : 3;
                }
            }
        }
        return $v;
    }

    public static function sx_100($m, $arr){
        $sx = array("鼠","牛","虎","兔","龍","蛇","馬","羊","猴","雞","狗","豬");
        foreach ($sx as $v) {
            if (in_array($m, $arr[$v])) {
                return $v;
            }
        }
        return false;
    }

    public static function getkj($mnum, $gid, $thisqishu, $page, $psize){
        $db = Db::connection();
        $sql = '';
        for ($i = 1; $i <= $mnum; $i++) {
            if ($i > 1) {
                $sql .= ',';
            }
            $sql .= 'm' . $i;
        }
        $time = time();
        $list = $db->select("select {$sql},qishu,kjtime from x_kj where gid='{$gid}'  and status=1 and closetime<'$time' order by gid,qishu desc limit " . ($page - 1) * $psize . ",{$psize}");
        $kj = array();
        $j = 0;
        foreach ($list as $item) {
            for ($i = 1; $i <= $mnum; $i++) {
                $kj[$j]['m' . $i] = $item['m' . $i];
            }
            $kj[$j]['qishu'] = $item['qishu'];
            $kj[$j]['time'] = date('H:i', $item['kjtime']);
            $j++;
        }
        return $kj;
    }

    public static function getkjarr($mnum, $gid, $thisqishu, $page, $psize){
        $db = Db::connection();
        $sql = '';
        for ($i = 1; $i <= $mnum; $i++) {
            if ($i > 1) {
                $sql .= ',';
            }
            $sql .= 'm' . $i;
        }
        $time = time();
        $list = $db->select("select {$sql},qishu,kjtime from x_kj where gid='{$gid}'  and m1!='' and closetime<'$time' order by qishu desc limit " . ($page - 1) * $psize . ",{$psize}");
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

    public static function getkjredis($mnum, $gid, $page, $psize){
        $key = 'kjlist_'.$gid;
        $redis = Cache::store('redis');
        $kj = array();
        if($redis->has($key)){
            $count = $redis->Llen($key);
            $list = $redis->Lrange($key,0,$count);
            $j = 0;
            foreach ($list as $item) {
                $kj[$j] = json_decode($item,true);
                $j++;
            }
        }else{
            $db = Db::connection();
            $sql = '';
            for ($i = 1; $i <= $mnum; $i++) {
                if ($i > 1) {
                    $sql .= ',';
                }
                $sql .= 'm' . $i;
            }
            $time = time();
            $list = $db->select("select {$sql},qishu,kjtime from x_kj where gid='{$gid}'  and m1!='' and closetime<'$time' order by gid,qishu desc limit " . ($page - 1) * $psize . ",{$psize}");
            $j = 0;
            foreach ($list as $item) {
                for ($i = 1; $i <= $mnum; $i++) {
                    $kj[$j]['m' . $i] = $item['m' . $i];
                }
                $kj[$j]['qishu'] = $item['qishu'];
                $kj[$j]['time'] = date('H:i', $item['kjtime']);
                $redis->Rpush($key,json_encode($kj[$j],true));
                $j++;
            }
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

    public static function zwdx($v,$type = 1){
        $v = $v % 10;
        if ($v <= 4)
            return $type == 1 ? "尾小" : ($type == 4 ? "小" : "X");
        else
            return $type == 1 ? "尾大" : ($type == 4 ? "大" : "D");
    }

    public static function zhdx($gid, $v,$type = 1)
    {
        if (in_array($gid, array(101,111,113,115))) {
            if ($v <= 22)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
        } else if (in_array($gid, array(117,163))) {
            if ($v <= 13)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
        } else if (in_array($gid, array(121,123,125))) {
            if ($v < 30)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else if ($v > 30)
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
            else
                return $type==1 ? "和" : ($type==2 ? 2 : "T");
        } else if (in_array($gid, array(103,133,135))) {
            if ($v < 84)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else if ($v > 84)
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
            else
                return $type==1 ? "和" : ($type==2 ? 2 : "T");
        } else if (in_array($gid, array(151,152))) {
            if ($v <= 10)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
        } else if (in_array($gid, array(161,162))) {
            if ($v < 810)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else if ($v > 810)
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
            else
                return $type==1 ? "和" : ($type==2 ? 2 : "T");
        } else if ($gid == 107) {
            if ($v <= 11)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
        } else if ($gid == 100) {
            if ($v <= 174)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
        } else if ($gid == 444) {
            if ($v <= 202)
                return $type==1 ? "小" : ($type==2 ? 1 : "X");
            else
                return $type==1 ? "大" : ($type==2 ? 0 : "D");
        } else if ($gid == 555) {
            if($v == 55){
                return $type==1 ? "和" : ($type==2 ? 2 : "T");
            }else{
                if ($v <= 54)
                    return $type==1 ? "小" : ($type==2 ? 1 : "X");
                else
                    return $type==1 ? "大" : ($type==2 ? 0 : "D");
            }
        }
    }

    public static function zongheguoguan($ma,$type = 1){
        $tmp = JsFunc::danshuang($ma);
        if($tmp == "单" && $ma > 810){
            return $type == 1 ? "总大单" : "DD";
        }elseif($tmp == "双" && $ma > 810){
            return $type == 1 ? "总大双" : "DS";
        }elseif ($tmp == "单" && $ma < 810){
            return $type == 1 ? "总小单" : "XD";
        }elseif ($tmp == "双" && $ma < 810){
            return $type == 1 ? "总小双" : "XS";
        }else{
            return '';
        }
    }

    public static function dx($gid, $v,$type = 1){
        if (in_array($gid, array(101,111,113,115))) {
            if ($v <= 4)
                return $type==1 ? "小" : "X";
            else
                return $type==1 ? "大" : "D";
        } else if (in_array($gid, array(121,123,125))) {
            if ($v < 6)
                return $type==1 ? "小" : "X";
            else if ($v >= 6 && $v <= 10)
                return $type==1 ? "大" : "D";
            else
                return $type==1 ? "和" : "T";
        } else if (in_array($gid, array(103,133,135))) {
            if ($v < 11)
                return $type==1 ? "小" : "X";
            return $type==1 ? "大" : "D";
        } else if (in_array($gid, array(151,152))) {
            if ($v <= 3)
                return $type==1 ? "小" : "X";
            else
                return $type==1 ? "大" : "D";
        } else if (in_array($gid, array(161,162))) {
            if ($v < 41)
                return $type==1 ? "小" : "X";
            else
                return $type==1 ? "大" : "D";
        } else if ($gid == 107) {
            if ($v <= 5)
                return $type==1 ? "小" : "X";
            else
                return $type==1 ? "大" : "D";
        } else if ($gid == 100) {
            if ($v < 25)
                return $type==1 ? "小" : "X";
            else if ($v < 49)
                return $type==1 ? "大" : "D";
            else
                return $type==1 ? "和" : "T";
        }else if ($gid == 444){
            if ($v <= 40)
                return $type==1 ? "小" : "X";
            else
                return $type==1 ? "大" : "D";
        }
    }

    public static function getbuz($gid, $whi){
        $db = Db::connection();
        $sql = "select buzqishu,name from x_play where gid='$gid' $whi order by xsort";
        $arr = $db->select($sql);
        return $arr;
    }

    public static function getpk10nium($kj, $arr){
        $a = [];
        $arr = explode('-', $arr);
        foreach ($arr as $v) {
            $a[] = $kj[$v - 1];
        }
        return $a;
    }

    public static function bjniuniu($a1, $a2, $pk10ts){
        if (!$a1[0] && $a2[0]) {
            return 1;
        }
        if ($a1[0] && !$a2[0]) {
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

    public static function writelog($loginfo){
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

    public static function getduoarrss($gid,$name){
        if($gid==101 || $gid==163){
            if((strpos('['.$name.']','组')>0)){
                $pl = array("0","1","2","3","4","5","6","7","8","9");
            }else{
                $names = str_replace('定位','',$name);
                $nl = strlen($names);
                if($nl==6){
                    $pl = array(substr($names,0,$nl/2)."-0","1","2","3","4","5","6","7","8","9",substr($names,$nl/2)."-0","1","2","3","4","5","6","7","8","9");
                }else{
                    if(strpos('['.$name.']','前三')){
                        $pl = array("万-0","1","2","3","4","5","6","7","8","9","千-0","1","2","3","4","5","6","7","8","9","百-0","1","2","3","4","5","6","7","8","9");
                    }else if(strpos('['.$name.']','中三')){
                        $pl = array("千-0","1","2","3","4","5","6","7","8","9","百-0","1","2","3","4","5","6","7","8","9","十-0","1","2","3","4","5","6","7","8","9");
                    }else{
                        $pl = array("百-0","1","2","3","4","5","6","7","8","9","十-0","1","2","3","4","5","6","7","8","9","个-0","1","2","3","4","5","6","7","8","9");
                    }
                }
            }
        }else if($gid==121){
            if($name=='选前二直选'){
                $pl = array("第1球-01","02","03","04","05","06","07","08","09","10","11","第2球-01","02","03","04","05","06","07","08","09","10","11");
            }else if($name=='选前三直选'){
                $pl = array("第1球-01","02","03","04","05","06","07","08","09","10","11","第2球-01","02","03","04","05","06","07","08","09","10","11","第3球-01","02","03","04","05","06","07","08","09","10","11");
            }else{
                $pl = array("01","02","03","04","05","06","07","08","09","10","11");
            }
        }else if($gid==107){
            $pl = array("1","2","3","4","5","6","7","8","9","10");

        }else if($gid==103){
            if($name=='选二连直'){
                $pl = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20");
            }else if($name=='选三前直'){
                $pl = array("第1球-01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","第2球-01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","第3球-01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20");
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

    public static function gets($gid,$bid = ''){
        if ($bid != '') {
            $list = Sclass::where(['gid'=>$gid,'ifok'=>1,'bid'=>$bid])->select(['sid','name'])->orderBy('xsort')->get();
        } else {
            $list = Sclass::where(['gid'=>$gid,'ifok'=>1])->select(['sid','name'])->orderBy('xsort')->get();
        }
        if(count($list) > 0){
            $list = $list->toArray();
        }
        return $list;
    }
}
