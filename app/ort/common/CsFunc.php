<?php


namespace App\ort\common;


use App\Common\TaskSwoole\CommonQueue;
use App\Models\Game\Autozj;
use App\Models\Game\Bclass;
use App\Models\Game\Kj;
use App\Models\Game\Mclass;
use App\Models\Game\MoneyLog;
use App\Models\Game\Play;
use App\Models\Game\Sclass;
use App\Models\Game\TaxTemplateItem;
use App\Models\Game\User;
use App\Models\Game\WaterTemplateItem;
use App\ort\services\CommonCache;
use App\ort\sgwin\ReportService;
use App\ort\sgwin\SGUtils;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CsFunc
{
    public static function formatqs($gid, $qs)
    {
        if ($gid == 113 | $gid == 123)
            $qs = substr($qs, 0, 8) . substr($qs, -2);
        else if ($gid == 152 | $gid == 153 | $gid == 155)
            $qs = substr($qs, -9);
        else if ($gid == 121 | $gid == 125)
            $qs = substr($qs, 0, 8) . substr($qs, -2);
        return $qs;
    }

    public static function curl_get($type, $url, $cookie = ''){
        if (empty($url)) {
            return false;
        }
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        if ($type) {  //判断请求协议http或https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Chrome 42.0.2311.135'); // 模拟用户使用的浏览器
        if (!empty($cookie)) curl_setopt($ch, CURLOPT_COOKIE, $cookie);  //设置cookie
        // 在尝试连接时等待的秒数
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        // 最大执行时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

    public static function calcmoni($fenlei, $gid, $cs, $qishu, $mnum, $ztype, $mtype){
        $table = SGUtils::getcuretable(true);
        $db = Db::connection();
        $sql = "select bid,sid,cid,pid,userid,sum(je) as jes,sum(je*peilv1) as z1,sum(je*points/100) as shui,bz,dates from $table where gid='{$gid}' and qishu='{$qishu}' group by cid,pid";
        $lib = $db->select($sql);
        $cl = count($lib);
        $zje = 0;
        foreach ($lib as $v) {
            $zje += $v['jes'];
        }
        if ($zje < $cs['kongje'] || $cs['xtmode'] == 0 || $cl == 0) {
            return self::suiji($fenlei, $gid, $qishu);
        }
        if ($cs["ylup"] > 0 && $lib[0]['dates']) {
            $dates = $lib[0]['dates'];
            $rs = $db->select("select sum(je*zc0/100) as ra,sum(if(z=1,peilv11,0)*je*zc0/100) as rb,sum(je*zc0*points1/100*100) as rc from $table where gid='$gid' and dates='$dates' and z in(0,1)");
            $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
            $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
            $rc = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
            $zje = $ra;
            $points = $rc;
            $zhong = $rb;
            $yk = $zje - $points - $zhong;
            if ($yk > $cs["ylup"]) {
                return self::suiji($fenlei, $gid, $qishu);
            }
        }
        $kj = [];$tmp = [];$marr = [];$y1 = [];$y2 = [];$sy1 = [];$sy2 = [];
        if ($fenlei == 100) {
            $marrs = json_decode(x_config('ma'), true);
            foreach ($marrs as $v) {
                foreach ($v as $k1 => $v1) {
                    $marr[$k1] = explode(',', $v1);
                }
            }
            $marr['pc'] = x_config('maxpc');
        }
        $jiang = [];
        $usy = [];
        for ($i = 0; $i < $cs['suiji']; $i++) {
            $kj[$i]['m'] = self::suiji($fenlei, $gid, $qishu);
            $jiang[$i] = 0;
            $usy[$i] = 0;
            $ft = 0;
            if (isset($cs['ft']) && $cs['ft'] == 1) {
                $ft = ComFunc::getft($kj[$i]['m'], $cs);
            }
            $sx = [];
            $ws = [];
            if ($fenlei == 100) {
                foreach ($kj[$i]['m'] as $ks => $vs) {
                    $sx[] = self::sx_100($vs, $marr);
                    $ws[] = $vs % 10;
                }
            }
            $tmpcid = 0;
            for ($j = 0; $j < $cl; $j++) {
                if ($fenlei == 100 && ($lib[$j]['bid'] == '26000004' || $lib[$j]['bid'] == '23378733')) {
                    continue;
                }
                if ($tmpcid != $lib[$j]['cid']) {
                    if (!isset($tmp['c' . $lib[$j]['cid']])) {
                        $class = Mclass::where(['cid' => $lib[$j]['cid'], 'gid' => $gid])->select(['name','mtype'])->first();
                        $tmp['c' . $lib[$j]['cid']]['name'] = $class['name'];
                        $tmp['c' . $lib[$j]['cid']]['mtype'] = $class['mtype'];
                        $tmp['c' . $lib[$j]['cid']]['cm'] = isset($mtype[$class['mtype']]) ? $mtype[$class['mtype']] : '';
                    }
                    if (!isset($tmp['s' . $lib[$j]['sid']])) {
                        $tmp['s' . $lib[$j]['sid']] = self::transs8('name', $lib[$j]['sid'], $gid);
                    }
                    if (!isset($tmp['b' . $lib[$j]['bid']])) {
                        $tmp['b' . $lib[$j]['bid']] = self::transb8('name', $lib[$j]['bid'], $gid);
                    }
                }
                if (!isset($tmp['p' . $lib[$j]['pid']])) {
                    $play = Play::where(['gid' => $gid, 'pid' => $lib[$j]['pid']])->select(['name','ztype','znum1','znum2'])->first();
                    $tmp['p' . $lib[$j]['pid']]['name'] = $play["name"];
                    $tmp['p' . $lib[$j]['pid']]['ztype'] = $ztype[$play["ztype"]];
                    $tmp['p' . $lib[$j]['pid']]['znum1'] = $play['znum1'];
                    $tmp['p' . $lib[$j]['pid']]['znum2'] = $play['znum2'];
                }
                $flag  = self::calcjs($fenlei, $gid, $kj[$i]['m'], $tmp['b' . $lib[$j]['bid']], $tmp['s' . $lib[$j]['sid']], $tmp['c' . $lib[$j]['cid']], $tmp['p' . $lib[$j]['pid']], '', $ft, $marr, $sx, $ws);
                switch ($flag[0]) {
                    case 1:
                        $jiang[$i] += $lib[$j]['jes'] - ($lib[$j]['z1'] + $lib[$j]['shui']);
                        break;
                    case 3:
                        $jiang[$i] += $lib[$j]['jes'] - $lib[$j]['z2'] - $lib[$j]['shui'];
                        break;
                    case 2:
                        $jiang[$i] += 0;
                        break;
                    case 0:
                        $jiang[$i] += $lib[$j]['jes'] - $lib[$j]['shui'];
                        break;
                }
                $tmpcid = $lib[$j]['cid'];
            }
            $jiang[$i] = intval($jiang[$i]);
            $jiang[$i] > 0 ? $y1[] = $jiang[$i] : ($y2[] = $jiang[$i]);
            $usy[$i] > 0 ? $sy1[] = $usy[$i] : ($sy2[] = $usy[$i]);
        }
        $v = 0;
        switch ($cs['xtmode']) {
            case 3:
                $v = count($y1)>0 ? $y1[rand(0, count($y1) - 1)] : 0;
                break;
            case 2:
                $v = count($y1)>0 ? max($y1) : 0;
                break;
            case 1:
                $v = count($y1)>0 ? min($y1) : 0;
                break;
            case -1:
                $v = count($y2)>0 ? max($y2) : 0;
                break;
            case -2:
                $v = count($y2)>0 ? min($y2) : 0;
                break;
            case -3:
                $v = count($y2)>0 ? $y2[rand(0, count($y2) - 1)] : 0;
                break;
            case 5:
                $totalqs = floor($cs["shenglv"] / 10);
                $zhongqs = $cs["shenglv"] % 10;
                $buzhongqs = $totalqs - $zhongqs;
                if ($cs["yingqs"] + $cs["shuqs"] == $totalqs) {
                    $cs["yingqs"] = 0;
                    $cs["shuqs"] = 0;
                }
                $v = $jiang[rand(0, $cs['suiji'] - 1)];
                $v < 0 ? $cs["shuqs"]++ : $cs["yingqs"]++;
                if ($cs["yingqs"] > $buzhongqs) {
                    $cs["yingqs"]--;
                    $v = $y2[rand(0, count($y2) - 1)];
                    $cs["shuqs"]++;
                }
                if ($cs["shuqs"] > $zhongqs) {
                    $cs["shuqs"]--;
                    $v = $y1[rand(0, count($y1) - 1)];
                    $cs["yingqs"]++;
                }
                $cs = json_encode($cs);
                $db->update("update x_game set cs='$cs' where gid='$gid'");
                break;
        }
        $key = array_search($v, $jiang);
        if(!isset($kj[$key]['m'])){
            return self::suiji($fenlei, $gid, $qishu);
        }else{
            return $kj[$key]['m'];
        }
    }

    public static function suiji($fenlei, $gid, $qishu){
        switch ($fenlei) {
            case '101':
                return self::suijikj($gid, $qishu, 5);
                break;
            case '107':
                return self::suijikj($gid, $qishu, 10);
                break;
            case '151':
                return self::suijikj($gid, $qishu, 3);
                break;
            case '161':
                return self::suijikj($gid, $qishu, 20);
                break;
            case '163':
                return self::suijikj($gid, $qishu, 4);
                break;
            case '121':
                return self::suijikj($gid, $qishu, 6);
                break;
            case '103':
                return self::suijikj($gid, $qishu, 8);
                break;
            case '100':
                return self::suijikj($gid, $qishu, 7);
                break;
            case '444':
                return self::suijikj($gid, $qishu, 5);
                break;
        }
    }

    public static function suijikj($gid, $qishu, $mnum){
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
                if($gid == 444){
                    for ($i = 1; $i <= 80; $i++) {
                        if ($i < 10) {
                            $arr[$i - 1] = '0' . $i;
                        } else {
                            $arr[$i - 1] = $i;
                        }
                    }
                    $m[0] = $arr[rand(0, 79)];
                    for ($i = 1; $i < 5; $i++) {
                        $m[$i] = self::randm($m, $arr, $mnum, 80);
                    }
                }else{
                    $arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                    $m[0] = $arr[rand(0, 9)];
                    $m[1] = $arr[rand(0, 9)];
                    $m[2] = $arr[rand(0, 9)];
                    $m[3] = $arr[rand(0, 9)];
                    $m[4] = $arr[rand(0, 9)];
                }
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
            case 20:
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

    public static function sx_100($m, $arr){
        $sx = array("鼠","牛","虎","兔","龍","蛇","馬","羊","猴","雞","狗","豬");
        foreach ($sx as $v) {
            if (in_array($m, $arr[$v])) {
                return $v;
            }
        }
        return false;
    }

    public static function transs8($field, $sid, $gid){
        return Sclass::where(['gid' => $gid, 'sid' => $sid])->value($field);
    }

    public static function transb8($field, $bid, $gid){
        return Bclass::where(['gid' => $gid, 'bid' => $bid])->value($field);
    }

    public static function transc8($field, $cid, $gid){
        return Mclass::where(['gid' => $gid, 'cid' => $cid])->value($field);
    }

    public static function transp8($field, $pid, $gid){
        return Play::where(['gid' => $gid, 'pid' => $pid])->value($field);
    }

    public static function calcjs($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft, $marr, $sx, $ws){
        switch ($fenlei) {
            case '101':
                return self::moni_101($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '107':
                return self::moni_107($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '151':
                return self::moni_151($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '161':
                return self::moni_161($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '163':
                return self::moni_163($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '121':
                return self::moni_121($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '103':
                return self::moni_103($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '100':
                return self::moni_100($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft, $marr, $sx, $ws);
                break;
            case '444':
                return self::moni_444($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
            case '555':
                return self::moni_555($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft);
                break;
        }
    }

    public static function moni_100($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft, $marr, $sx, $ws){
        $v = 0;$jj = 0;
        if ($c['mtype'] == 0) {
            $c['mtype'] = 6;
        } else if ($c['mtype'] <= 6) {
            $c['mtype'] -= 1;
        }
        switch ($p['ztype']) {
            case '番摊':
                switch ($c['name']) {
                    case "双面":
                        if ($p['name'] == "单" && $ft % 2 == 1) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "双" && $ft % 2 == 0) {
                                $v = 1;
                            } else {
                                if ($p['name'] == "大" && $ft > 2) {
                                    $v = 1;
                                } else {
                                    if ($p['name'] == "小" && $ft < 3) {
                                        $v = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case "番":
                        $ft . "番" == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "念":
                        $ps = explode('念', $p["name"]);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if ($ps[1] == $ft) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    case "角":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case "正":
                        $ps = str_replace('正', '', $p['name']);
                        if ($ps > 2) {
                            $psdui = $ps - 2;
                        } else {
                            $psdui = $ps + 2;
                        }
                        if ($ps == $ft) {
                            $v = 1;
                        } else {
                            if ($psdui == $ft) {
                                $v = 0;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                    case "中":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case '加':
                        $ps = explode('加', $p['name']);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if (strpos($ps[1], $ft . "") !== false) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    default:
                        if ($p['znum1'] == $ft) {
                            $v = 0;
                        } else {
                            if (strpos($p['name'], $ft . "") !== false) {
                                $v = 1;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                }
                break;
            case '码':
            case '碼':
                ($b == '正码' || $b == '正碼') ? $arr = [$kj[0], $kj[1], $kj[2], $kj[3], $kj[4], $kj[5]] : ($arr = [$kj[$c['mtype']]]);
                in_array($p['name'], $arr) && ($v = 1);
                break;
            case '单双':
            case '單雙':
                if ($c['name'] == '总单双' || $c['name'] == '總單雙') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4] + $kj[5] + $kj[6];
                    strpos($p['name'], JsFunc::danshuang_100($ma)) !== false && ($v = 1);
                } else {
                    $ma = $kj[$c['mtype']];
                    if ($ma == 49) {
                        $v = 2;
                    } else {
                        strpos($p['name'], JsFunc::danshuang_100($ma)) !== false && ($v = 1);
                    }
                }
                break;
            case '大小':
                if ($c['name'] == '总大小' || $c['name'] == '總大小') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4] + $kj[5] + $kj[6];
                    (($p['name'] == '总大' || $p['name'] == '總大') && $ma > 174) && ($v = 1);
                    (($p['name'] == '总小' || $p['name'] == '總小') && $ma < 175) && ($v = 1);
                } else {
                    $ma = $kj[$c['mtype']];
                    if ($ma == 49) {
                        $v = 2;
                    } else {
                        $p['name'] == '大' && $ma >= 25 && ($v = 1);
                        $p['name'] == '小' && $ma <= 24 && ($v = 1);
                    }
                }
                break;
            case '合单双':
            case '合單雙':
                $ma = JsFunc::heshu($kj[$c['mtype']]);
                if ($kj[$c['mtype']] == 49) {
                    $v = 2;
                } else {
                    (strpos($p['name'], JsFunc::danshuang_100($ma)) !== false) && ($v = 1);
                }
                break;
            case "波色":
                in_array($kj[$c['mtype']], $marr[$p['name']]) && ($v = 1);
                break;
            case '尾大小':
                $ma = $kj[$c['mtype']];
                if ($c['name'] == "合尾大小") {
                    if ($ma == 25) {
                        $v = 2;
                    } else {
                        $hs = JsFunc::heshu($ma);
                        (strpos($p['name'], JsFunc::daxiaow($hs % 10)) !== false) && ($v = 1);
                    }
                } else {
                    if ($ma == 49) {
                        $v = 2;
                    } else {
                        (strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false) && ($v = 1);
                    }
                }
                break;
            case '合大小':
                $ma = JsFunc::heshu($kj[$c['mtype']]);
                if ($kj[$c['mtype']] == 49) {
                    $v = 2;
                } else {
                    ($p['name'] == JsFunc::heshudaxiao_100($ma)) && ($v = 1);
                }
                break;
            case "家野":
                $ma = $kj[$c['mtype']];
                if ($ma == 49) {
                    $v = 2;
                } else {
                    in_array($ma, $marr[$p['name']]) && ($v = 1);
                }
                break;
            case "半波":
                if ($kj[$c['mtype']] == 49) {
                    $v = 2;
                } else {
                    in_array($kj[$c['mtype']], $marr[$p['name']]) && ($v = 1);
                }
                break;
            case "五行":
                in_array($kj[$c['mtype']], $marr[$p['name']]) && ($v = 1);
                break;
            case '生肖':
                if ($b == '一肖') {
                    $arr = $kj;
                } else {
                    if ($b == '正肖') {
                        $arr = [$kj[0], $kj[1], $kj[2], $kj[3], $kj[4], $kj[5]];
                    } else {
                        $arr = [$kj[6]];
                    }
                }
                $zflag = 0;
                foreach ($arr as $vv) {
                    if (in_array($vv, $marr[$p['name']])) {
                        $zflag += 1;
                    }
                }
                if ($zflag >= 1) {
                    /*if ($b == "正肖") {
                        $v = 5;
                        $jj = $zflag;
                    } else {*/
                    $v = 1;
                    //}
                }
                break;
            case '尾数':
            case '尾數':
                $b == "特头尾" ? $arr = [$kj[6]] : ($arr = $kj);
                $zflag = 0;
                foreach ($arr as $vv) {
                    if (in_array($vv, $marr[$p['name']])) {
                        $zflag = 1;
                        break;
                    }
                }
                $zflag == 1 && ($v = 1);
                break;
            case "其他":
                if ($b == "总肖七色波") {
                    $zx = array_count_values($sx);
                    $czx = count($zx);
                    switch ($c['name']) {
                        case '总肖':
                            $p['znum1'] == $czx && ($v = 1);
                            break;
                        case '总肖单双':
                            strpos($p['name'], JsFunc::danshuang($czx)) !== false && ($v = 1);
                            break;
                        default:
                            $hob = 0;
                            $lao = 0;
                            $lvb = 0;
                            for ($i = 0; $i < 6; $i++) {
                                in_array($kj[$i], $marr["紅"]) && $hob++;
                                in_array($kj[$i], $marr["藍"]) && $lab++;
                                in_array($kj[$i], $marr["綠"]) && $lvb++;
                            }
                            in_array($kj[6], $marr["紅"]) && ($hob += 1.5);
                            in_array($kj[6], $marr["藍"]) && ($lab += 1.5);
                            in_array($kj[6], $marr["綠"]) && ($lvb += 1.5);
                            $p['name'] == "和局" && ($hob == 3 && $lab == 3 && $lvb == 1.5 || $hob == 3 && $lvb == 3 && $lab == 1.5 || $lvb == 3 && $lab == 3 && $hob == 1.5) && ($v = 1);
                            $p['name'] != "和局" && ($hob == 3 && $lab == 3 && $lvb == 1.5 || $hob == 3 && $lvb == 3 && $lab == 1.5 || $lvb == 3 && $lab == 3 && $hob == 1.5) && ($v = 2);
                            $p['name'] == "红波" && $hob == max($hob, $lab, $lvb) && ($v = 1);
                            $p['name'] == "蓝波" && $lab == max($hob, $lab, $lvb) && ($v = 1);
                            $p['name'] == "绿波" && $lvb == max($hob, $lab, $lvb) && ($v = 1);
                            break;
                    }
                } else {
                    switch ($c['name']) {
                        case '特头数':
                            $p['name'] == floor($kj[$c['mtype']] / 10) . "头" && ($v = 1);
                            break;
                        case '特尾数':
                            $p['name'] == $kj[$c['mtype']] % 10 . "尾" && ($v = 1);
                            break;
                    }
                }
                break;
            case '多肖':
                if ($b == '特肖连' | $b == '合肖') {
                    if ($kj[6] == 49 && $p['znum1'] == 6) {
                        $v = 2;
                        break;
                    }
                    $cons = explode('-', $con);
                    $cons = array_unique($cons);
                    $cc = count($cons);
                    $zflag = 0;
                    foreach ($cons as $vv) {
                        if (in_array($kj[6], $marr[$vv])) {
                            $zflag = 1;
                            break;
                        }
                    }
                    if ($p['znum2'] < 0) {
                        $zflag == 0 && ($v = 1);
                    } else {
                        $zflag == 1 && ($v = 1);
                    }
                } else {
                    $cons = explode('-', $con);
                    $cons = array_unique($cons);
                    $cc = count($cons);
                    $zflag = 0;
                    foreach ($cons as $vv) {
                        if (in_array($vv, $sx)) {
                            $zflag++;
                        }
                    }
                    if ($p['znum2'] >= 0) {
                        $zflag == $p['znum1'] && ($v = 1);
                    } else {
                        $zflag == 0 && ($v = 1);
                    }
                }
                break;
            case '多尾':
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                $zflag = 0;
                foreach ($cons as $vv) {
                    if (in_array(str_replace('尾', '', $vv), $ws)) {
                        $zflag++;
                    }
                }
                if ($p['znum2'] >= 0) {
                    $zflag == $p['znum1'] && ($v = 1);
                } else {
                    $zflag == 0 && ($v = 1);
                }
                break;
            case '多不中':
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                $zflag = 1;
                foreach ($cons as $vv) {
                    if (in_array($vv, $kj)) {
                        $zflag = 0;
                        break;
                    }
                }
                $zflag == 1 && ($v = 1);
                break;
            case '多码':
            case '多碼':
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if ($cc != $p['znum1'] && $cc != $p['znum2']) {
                    break;
                }
                $arr = [$kj[0], $kj[1], $kj[2], $kj[3], $kj[4], $kj[5]];
                switch ($p['name']) {
                    case '特串':
                        if ((in_array($cons[0], $arr) && $cons[1] == $kj[6]) || (in_array($cons[1], $arr) && $cons[0] == $kj[6])) {
                            ($v = 1);
                        }
                        break;
                    case '二中特':
                        in_array($cons[0], $arr) && in_array($cons[1], $arr) && $cons[0] != $cons[1] && ($v = 1);
                        (($cons[0] == $kj[6] && in_array($cons[1], $arr)) || ($cons[1] == $kj[6] && in_array($cons[0], $arr))) && $con[0] != $con[1] && ($v = 3);
                        break;
                    default:
                        $zflag = 0;
                        foreach ($cons as $vv) {
                            if (in_array($vv, $arr)) {
                                $zflag++;
                            }
                        }
                        if ($p['name'] == '三中二') {
                            if ($zflag == 2) {
                                $v = 1;
                            }
                            if ($zflag == 3) {
                                $v = 3;
                            }
                        } else {
                            $zflag == $p['znum1'] && ($v = 1);
                        }
                        break;
                }
                break;
        }
        return [$v, $jj];
    }

    public static function moni_103($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft){
        $v = 0;
        switch ($p['ztype']) {
            case '番摊':
                switch ($c['name']) {
                    case "双面":
                        if ($p['name'] == "单" && $ft % 2 == 1) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "双" && $ft % 2 == 0) {
                                $v = 1;
                            } else {
                                if ($p['name'] == "大" && $ft > 2) {
                                    $v = 1;
                                } else {
                                    if ($p['name'] == "小" && $ft < 3) {
                                        $v = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case "番":
                        $ft . "番" == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "念":
                        $ps = explode('念', $p["name"]);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if ($ps[1] == $ft) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    case "角":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case "正":
                        $ps = str_replace('正', '', $p['name']);
                        if ($ps > 2) {
                            $psdui = $ps - 2;
                        } else {
                            $psdui = $ps + 2;
                        }
                        if ($ps == $ft) {
                            $v = 1;
                        } else {
                            if ($psdui == $ft) {
                                $v = 0;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                    case "中":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case '加':
                        $ps = explode('加', $p['name']);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if (strpos($ps[1], $ft . "") !== false) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    default:
                        if ($p['znum1'] == $ft) {
                            $v = 0;
                        } else {
                            if (strpos($p['name'], $ft . "") !== false) {
                                $v = 1;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                }
                break;
            case '码':
                $b == '正码' ? $ma = $kj : ($ma = [$kj[$c['mtype']]]);
                in_array($p['name'], $ma) ? $v = 1 : ($v = 0);
                break;
            case '单双':
                $c['name'] == '总和单双' ? $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4] + $kj[5] + $kj[6] + $kj[7] : ($ma = $kj[$c['mtype']]);
                strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                break;
            case '合单双':
                $ma = JsFunc::heshu($kj[$c['mtype']]);
                strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                break;
            case '大小':
                $v = 0;
                if ($c['name'] == '总和大小') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4] + $kj[5] + $kj[6] + $kj[7];
                    $p['name'] == '总和大' && $ma > 84 && ($v = 1);
                    $p['name'] == '总和小' && $ma < 84 && ($v = 1);
                    $ma == 84 && ($v = 2);
                } else {
                    $ma = $kj[$c['mtype']];
                    $p['name'] == '小' && $ma <= 10 && ($v = 1);
                    $p['name'] == '大' && $ma >= 11 && ($v = 1);
                }
                break;
            case '尾大小':
                if ($c['name'] == '总尾大小') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4] + $kj[5] + $kj[6] + $kj[7];
                    strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false && ($v = 1);
                } else {
                    $ma = $kj[$c['mtype']];
                    strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false && ($v = 1);
                }
                break;
            case '龙虎':
                $ma = JsFunc::longhuhe($kj[$c['mtype']], $kj[7 - $c['mtype']]);
                $ma == $p['name'] ? $v = 1 : $v = 0;
                break;
            case '方位':
                JsFunc::fangwei($kj[$c['mtype']]) == $p['name'] && ($v = 1);
                break;
            case '中发白':
                JsFunc::zhongfabai($kj[$c['mtype']]) == $p['name'] && ($v = 1);
                break;
            case '连码':
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if ($cc != $p['znum1']) {
                    break;
                }
                switch ($p['name']) {
                    case '选二任选':
                        in_array($cons[0], $kj) && in_array($cons[1], $kj) && ($v = 1);
                        break;
                    case '选三任选':
                        in_array($cons[0], $kj) && in_array($cons[1], $kj) && in_array($cons[2], $kj) && ($v = 1);
                        break;
                    case '选四任选':
                        in_array($cons[0], $kj) && in_array($cons[1], $kj) && in_array($cons[2], $kj) && in_array($cons[3], $kj) && ($v = 1);
                        break;
                    case '选五任选':
                        in_array($cons[0], $kj) && in_array($cons[1], $kj) && in_array($cons[2], $kj) && in_array($cons[3], $kj) && in_array($cons[4], $kj) && ($v = 1);
                        break;
                    case '选二连组':
                        if (in_array($cons[0], $kj)) {
                            $keylm = -1;
                            foreach ($kj as $klm => $vlm) {
                                $cons[0] == $vlm && ($keylm = $klm);
                            }
                            if ($keylm > 0) {
                                ($kj[$keylm - 1] == $cons[1] || $kj[$keylm + 1] == $cons[1]) && ($v = 1);
                            } else {
                                $kj[$keylm + 1] == $cons[1] && ($v = 1);
                            }
                        }
                        break;
                    case '选二连直':
                        if (in_array($cons[0], $kj)) {
                            $keylm = -1;
                            foreach ($kj as $klm => $vlm) {
                                $cons[0] == $vlm && ($keylm = $klm);
                            }
                            $kj[$keylm + 1] == $con[1] && ($v = 1);
                        }
                        break;
                    case '选三前组':
                        $arrlm = [$kj[0], $kj[1], $kj[2]];
                        in_array($cons[0], $arrlm) && in_array($cons[1], $arrlm) && in_array($cons[2], $arrlm) && ($v = 1);
                        break;
                    case '选三前直':
                        $con[0] == $kj[0] && $con[1] == $kj[1] && $con[2] == $kj[2] && ($v = 1);
                        break;
                    case '选前二组选':
                        $arr = [$kj[0], $kj[1]];
                        in_array($cons[0], $arr) && in_array($cons[1], $arr) && ($v = 1);
                        break;
                    case '选前二直选':
                        $cons[0] == $kj[0] && $cons[1] == $kj[1] && ($v = 1);
                        break;
                    case '选前三组选':
                        $arr = [$kj[0], $kj[1], $kj[2]];
                        in_array($cons[0], $arr) && in_array($cons[1], $arr) && in_array($cons[2], $arr) && ($v = 1);
                        break;
                    case '选前三直选':
                        $cons[0] == $kj[0] && $cons[1] == $kj[1] && $cons[2] == $kj[2] && ($v = 1);
                        in_array($kj[0], $cons) & in_array($kj[1], $cons) & in_array($kj[2], $cons) & in_array($kj[3], $cons) & in_array($kj[4], $cons) && ($v = 1);
                        break;
                }
                break;
        }
        return [$v];
    }

    public static function moni_444($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft){
        $v = 0;
        switch ($p['ztype']) {
            case '码':
                $b == '正码' ? $ma = $kj : ($ma = [$kj[$c['mtype']]]);
                in_array($p['name'], $ma) ? $v = 1 : ($v = 0);
                break;
            case '单双':
                $b == '和值' ? $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4] : ($ma = $kj[$c['mtype']]);
                strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                break;
            case '合单双':
                $ma = JsFunc::heshu($kj[$c['mtype']]);
                strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                break;
            case '大小':
                $v = 0;
                if ($c['name'] == '大小' && $b == '和值') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                    if($gid == 444){
                        $p['name'] == '大' && $ma >= 203 && ($v = 1);
                        $p['name'] == '小' && $ma <= 202 && ($v = 1);
                    }elseif($gid == 518){
                        $p['name'] == '大' && $ma >= 23 && ($v = 1);
                        $p['name'] == '小' && $ma <= 22 && ($v = 1);
                    }
                } else {
                    $ma = $kj[$c['mtype']];
                    if($gid == 444){
                        $p['name'] == '小' && $ma <= 40 && ($v = 1);
                        $p['name'] == '大' && $ma >= 41 && ($v = 1);
                    }elseif ($gid == 518){
                        $p['name'] == '小' && $ma <= 4 && ($v = 1);
                        $p['name'] == '大' && $ma >= 5 && ($v = 1);
                    }
                }
                break;
            case '尾大小':
                if ($c['name'] == '尾大小' && $b == '和值') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                    strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false && ($v = 1);
                } else {
                    $ma = $kj[$c['mtype']];
                    strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false && ($v = 1);
                }
                break;
            case '龙虎':
                $ma = JsFunc::longhuhe($kj[0], $kj[4]);
                if($gid == 444) {
                    $ma == $p['name'] ? $v = 1 : $v = 0;
                }elseif($gid == 518){
                    $p['name'] == '龙' && $ma == '龙' && ($v = 1);
                    $p['name'] == '虎' && $ma == '虎' && ($v = 1);
                    $ma == '和' && ($v = 2);
                }
                break;
            case '福禄寿喜':
                /*
                 *  福：01,02,03,04,05,21,22,23,24,25,41,42,43,44,45,61,62,63,64,65
                    禄：06,07,08,09,10,26,27,28,29,30,46,47,48,49,50,66,67,68,69,70
                    寿：11,12,13,14,15,31,32,33,34,35,51,52,53,54,55,71,72,73,74,75
                    喜：16,17,18,19,20,36,37,38,39,40,56,57,58,59,60,76,77,78,79,80
                 */
                $ma = $kj[$c['mtype']];
                if(in_array($ma,[1,2,3,4,5,21,22,23,24,25,41,42,43,44,45,61,62,63,64,65]) && $p['name'] == '福'){
                    $v = 1;
                }elseif (in_array($ma,[6,7,8,9,10,26,27,28,29,30,46,47,48,49,50,66,67,68,69,70]) && $p['name'] == '禄'){
                    $v = 1;
                }elseif (in_array($ma,[11,12,13,14,15,31,32,33,34,35,51,52,53,54,55,71,72,73,74,75]) && $p['name'] == '寿'){
                    $v = 1;
                }elseif (in_array($ma,[16,17,18,19,20,36,37,38,39,40,56,57,58,59,60,76,77,78,79,80]) && $p['name'] == '喜'){
                    $v = 1;
                }
                break;
        }
        return [$v];
    }

    public static function moni_555($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft)
    {
        $v = 0;
        switch ($p['ztype']) {
            case '码':
                $b == '正码' ? $ma = $kj : ($ma = [$kj[$c['mtype']]]);
                in_array($p['name'], $ma) ? $v = 1 : ($v = 0);
                break;
            case '单双':
                if($c['name'] == '总和单双'){
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                    if ($ma == 55){
                        $v = 2;
                    }else{
                        strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                    }
                }else{
                    $ma = $kj[$c['mtype']];
                    if($ma == 11){
                        $v = 2;
                    }else{
                        strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                    }
                }
                break;
            case '合单双':
                if($kj[$c['mtype']] == 11){
                    $v = 2;
                }else{
                    $ma = JsFunc::heshu($kj[$c['mtype']]);
                    strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                }
                break;
            case '大小':
                $v = 0;
                if ($c['name'] == '总和大小') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                    if($ma == 55){
                        $v = 2;
                    }else{
                        $p['name'] == '总和大' && $ma >= 56 && ($v = 1);
                        $p['name'] == '总和小' && $ma <= 54 && ($v = 1);
                    }
                } else {
                    $ma = $kj[$c['mtype']];
                    if($ma == 11){
                        $v = 2;
                    }else{
                        $p['name'] == '小' && $ma <= 10 && ($v = 1);
                        $p['name'] == '大' && $ma >= 12 && ($v = 1);
                    }
                }
                break;
            case '尾大小':
                if ($c['name'] == '总尾大小') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                    strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false && ($v = 1);
                } else {
                    $ma = $kj[$c['mtype']];
                    if($ma == 11){
                        $v = 2;
                    }else{
                        strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false && ($v = 1);
                    }
                }
                break;
            case '龙虎':
                $ma = JsFunc::longhuhe($kj[0], $kj[4]);
                $ma == $p['name'] ? $v = 1 : $v = 0;
                break;
        }
        return [$v];
    }

    public static function moni_121($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft){
        $v = 0;
        switch ($p['ztype']) {
            case '番摊':
                switch ($c['name']) {
                    case "双面":
                        if ($p['name'] == "单" && $ft % 2 == 1) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "双" && $ft % 2 == 0) {
                                $v = 1;
                            } else {
                                if ($p['name'] == "大" && $ft > 2) {
                                    $v = 1;
                                } else {
                                    if ($p['name'] == "小" && $ft < 3) {
                                        $v = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case "番":
                        $ft . "番" == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "念":
                        $ps = explode('念', $p["name"]);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if ($ps[1] == $ft) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    case "角":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case "正":
                        $ps = str_replace('正', '', $p['name']);
                        if ($ps > 2) {
                            $psdui = $ps - 2;
                        } else {
                            $psdui = $ps + 2;
                        }
                        if ($ps == $ft) {
                            $v = 1;
                        } else {
                            if ($psdui == $ft) {
                                $v = 0;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                    case "中":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case '加':
                        $ps = explode('加', $p['name']);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if (strpos($ps[1], $ft . "") !== false) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    default:
                        if ($p['znum1'] == $ft) {
                            $v = 0;
                        } else {
                            if (strpos($p['name'], $ft . "") !== false) {
                                $v = 1;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                }
                break;
            case '码':
                $b == '一中一' ? $ma = $kj : ($ma = [$kj[$c['mtype']]]);
                in_array($p['name'], $ma) ? $v = 1 : ($v = 0);
                break;
            case '单双':
                if ($c['name'] == '总和单双') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                    strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                } else {
                    $ma = $kj[$c['mtype']];
                    $yhjg = JsFunc::danshuang121($ma);
                    if ($p['name'] == $yhjg) {
                        $v = 1;
                    } else {
                        if ($yhjg == '和') {
                            $v = 2;
                        } else {
                            $v = 0;
                        }
                    }
                }
                break;
            case '大小':
                $v = 0;
                if ($c['name'] == '总和大小') {
                    $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                    $p['name'] == '总和大' && $ma > 30 && ($v = 1);
                    $p['name'] == '总和小' && $ma < 30 && ($v = 1);
                    $ma == 30 && ($v = 2);
                } else {
                    $ma = $kj[$c['mtype']];
                    $p['name'] == '小' && $ma <= 5 && ($v = 1);
                    $p['name'] == '大' && $ma >= 6 && ($v = 1);
                    $ma == 11 && ($v = 2);
                }
                break;
            case '尾大小':
                $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false && ($v = 1);
                break;
            case '龙虎':
                $ma = JsFunc::longhuhe($kj[0], $kj[4]);
                $ma == $p['name'] ? $v = 1 : $v = 0;
                break;
            case '连码':
                $cons = explode(',', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if ($cc != $p['znum1']) {
                    break;
                }
                switch ($p['name']) {
                    case '任选二中二':
                        in_array($cons[0], $kj) && in_array($cons[1], $kj) && ($v = 1);
                        break;
                    case '任选三中三':
                        in_array($cons[0], $kj) && in_array($cons[1], $kj) && in_array($cons[2], $kj) && ($v = 1);
                        break;
                    case '任选四中四':
                        in_array($cons[0], $kj) && in_array($cons[1], $kj) && in_array($cons[2], $kj) && in_array($cons[3], $kj) && ($v = 1);
                        break;
                    case '任选五中五':
                    case '任选六中五':
                    case '任选七中五':
                    case '任选八中五':
                        in_array($kj[0], $cons) & in_array($kj[1], $cons) & in_array($kj[2], $cons) & in_array($kj[3], $cons) & in_array($kj[4], $cons) && ($v = 1);
                        break;
                    case '选前二组选':
                        $arr = [$kj[0], $kj[1]];
                        in_array($cons[0], $arr) && in_array($cons[1], $arr) && ($v = 1);
                        break;
                    case '选前二直选':
                        $cons[0] == $kj[0] && $cons[1] == $kj[1] && ($v = 1);
                        break;
                    case '选前三组选':
                        $arr = [$kj[0], $kj[1], $kj[2]];
                        in_array($cons[0], $arr) && in_array($cons[1], $arr) && in_array($cons[2], $arr) && ($v = 1);
                        break;
                    case '选前三直选':
                        $cons[0] == $kj[0] && $cons[1] == $kj[1] && $cons[2] == $kj[2] && ($v = 1);
                        break;
                }
                break;
        }
        return [$v];
    }

    public static function moni_161($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft)
    {
        $v = 0;
        switch ($p['ztype']) {
            case '番摊':
                switch ($c['name']) {
                    case "双面":
                        if ($p['name'] == "单" && $ft % 2 == 1) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "双" && $ft % 2 == 0) {
                                $v = 1;
                            } else {
                                if ($p['name'] == "大" && $ft > 2) {
                                    $v = 1;
                                } else {
                                    if ($p['name'] == "小" && $ft < 3) {
                                        $v = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case "番":
                        $ft . "番" == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "念":
                        $ps = explode('念', $p["name"]);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if ($ps[1] == $ft) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    case "角":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case "正":
                        $ps = str_replace('正', '', $p['name']);
                        if ($ps > 2) {
                            $psdui = $ps - 2;
                        } else {
                            $psdui = $ps + 2;
                        }
                        if ($ps == $ft) {
                            $v = 1;
                        } else {
                            if ($psdui == $ft) {
                                $v = 0;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                    case "中":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case '加':
                        $ps = explode('加', $p['name']);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if (strpos($ps[1], $ft . "") !== false) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    default:
                        if ($p['znum1'] == $ft) {
                            $v = 0;
                        } else {
                            if (strpos($p['name'], $ft . "") !== false) {
                                $v = 1;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                }
                break;
            case '正码':
                in_array($p['name'], $kj) && ($v = 1);
                break;
            case '总和':
                $ma = 0;
                $qma = 0;
                $dma = 0;
                for ($i = 0; $i < 20; $i++) {
                    $kj[$i] <= 40 && $qma++;
                    $kj[$i] % 2 == 1 && $dma++;
                    $ma += $kj[$i];
                }
                switch ($c['name']) {
                    case "总和单双":
                        strpos($p['name'], JsFunc::danshuang($ma)) !== false && ($v = 1);
                        break;
                    case "总和大小":
                        $p['name'] == '总和大' && $ma > 810 && ($v = 1);
                        $p['name'] == '总和小' && $ma < 810 && ($v = 1);
                        $ma == 810 && ($v = 2);
                        break;
                    case "总和810":
                        $ma == 810 && ($v = 1);
                        break;
                    case "总和过关":
                        if ($ma == 810) {
                            $v = 2;
                        } else {
                            $tmp = JsFunc::danshuang($ma);
                            $p['name'] == '总大单' && $tmp == "单" && $ma > 810 && ($v = 1);
                            $p['name'] == '总大双' && $tmp == "双" && $ma > 810 && ($v = 1);
                            $p['name'] == '总小单' && $tmp == "单" && $ma < 810 && ($v = 1);
                            $p['name'] == '总小双' && $tmp == "双" && $ma < 810 && ($v = 1);
                        }
                        break;
                    case "单双和":
                        $p['name'] == "单(多)" && $dma > 10 && ($v = 1);
                        $p['name'] == "双(多)" && $dma < 10 && ($v = 1);
                        $p['name'] == "单双(和)" && $dma == 10 && ($v = 1);
                        break;
                    case "前后和":
                        $p['name'] == "前(多)" && $dma > 10 && ($v = 1);
                        $p['name'] == "后(多)" && $dma < 10 && ($v = 1);
                        $p['name'] == "前后(和)" && $dma == 10 && ($v = 1);
                        break;
                }
                break;
            case '五行':
                $ma = 0;
                for ($i = 0; $i < 20; $i++) {
                    $ma += $kj[$i];
                }
                JsFunc::wuhang_161($ma) == $p['name'] && ($v = 1);
                break;
        }
        return [$v];
    }

    public static function moni_151($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft)
    {
        $v = 0;
        $d = 1;
        switch ($p['ztype']) {
            case '码':
                //$p['name']在$kj数组中出现的次数
                $s = isset(array_count_values($kj)[$p['name']]) ? array_count_values($kj)[$p['name']] : 0;
                //in_array($p['name'], $kj) && ($v = 1);
                $s > 1 && ($d = $s);
                $s > 0 && ($v = 1);
                break;
            case '骰':
                if ($p["name"] == "全骰") {
                    JsFunc::baozhi($kj[0], $kj[1], $kj[2]) == 1 && ($v = 1);
                } else {
                    JsFunc::baozhi($kj[0], $kj[1], $kj[2]) == 1 & $kj[0] == $p['name'] % 10 && ($v = 1);
                }
                break;
            case '点':
                $ma = $kj[0] + $kj[1] + $kj[2];
                if ($c['name'] == '三军大小') {
                    $p['name'] == '三军大' && $ma >= 11 && ($v = 1);
                    $p['name'] == '三军小' && $ma < 11 && ($v = 1);
                    $p['name'] == '三军单' && $ma % 2 != 0 && ($v = 1);
                    $p['name'] == '三军双' && $ma % 2 == 0 && ($v = 1);
                    JsFunc::baozhi($kj[0], $kj[1], $kj[2]) == 1 && ($v = 0);
                } else {
                    str_replace('点', '', $p['name']) == $ma && ($v = 1);
                }
                break;
            case "牌":
                if ($c['name'] == '长牌') {
                    $two = $p['name'] % 10;
                    $one = ($p['name'] - $two) / 10;
                    in_array($one, $kj) && in_array($two, $kj) && ($v = 1);
                } else {
                    $two = $p['name'] % 10;
                    $cs = array_count_values($kj);
                    if(isset($cs[$two])){
                        $cs[$two] >= 2 && ($v = 1);
                    }
                }
                break;
        }
        return [$v,0,$d];
    }

    public static function moni_101($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft)
    {
        $v = 0;
        switch ($b) {
            case '番摊':
                switch ($c['name']) {
                    case "双面":
                        if ($p['name'] == "单" && $ft % 2 == 1) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "双" && $ft % 2 == 0) {
                                $v = 1;
                            } else {
                                if ($p['name'] == "大" && $ft > 2) {
                                    $v = 1;
                                } else {
                                    if ($p['name'] == "小" && $ft < 3) {
                                        $v = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case "番":
                        $ft . "番" == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "念":
                        $ps = explode('念', $p["name"]);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if ($ps[1] == $ft) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    case "角":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case "正":
                        $ps = str_replace('正', '', $p['name']);
                        if ($ps > 2) {
                            $psdui = $ps - 2;
                        } else {
                            $psdui = $ps + 2;
                        }
                        if ($ps == $ft) {
                            $v = 1;
                        } else {
                            if ($psdui == $ft) {
                                $v = 0;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                    case "中":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case '加':
                        $ps = explode('加', $p['name']);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if (strpos($ps[1], $ft . "") !== false) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    default:
                        if ($p['znum1'] == $ft) {
                            $v = 0;
                        } else {
                            if (strpos($p['name'], $ft . "") !== false) {
                                $v = 1;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                }
                break;
            case '1~5':
                $ma = $kj[$c['mtype']];
                switch ($p['ztype']) {
                    case "码":
                        $ma == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "单双":
                        strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                        break;
                    case "大小":
                        if (($p['name'] == "大" && $ma >= 5) || ($p['name'] == "小" && $ma < 5)) {
                            $v = 1;
                        }
                        break;
                }
                break;
            case '1字组合':
                $arr = [];
                switch ($c['cm']) {
                    case "全部":
                        $arr = $kj;
                        break;
                    case '前三':
                        $arr = [$kj[0], $kj[1], $kj[2]];
                        break;
                    case '中三':
                        $arr = [$kj[1], $kj[2], $kj[3]];
                        break;
                    case '后三':
                        $arr = [$kj[2], $kj[3], $kj[4]];
                        break;
                }
                if (in_array($p['name'], $arr)) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '2字组合':
                $arr = [];
                if (strpos($c['name'], '前三') !== false) {
                    $arr = [$kj[0], $kj[1], $kj[2]];
                } else {
                    if (strpos($c['name'], '中三') !== false) {
                        $arr = [$kj[1], $kj[2], $kj[3]];
                    } else {
                        if (strpos($c['name'], '后三') !== false) {
                            $arr = [$kj[2], $kj[3], $kj[4]];
                        }
                    }
                }
                $co1 = explode('-', $con);
                $c1 = array_unique($co1);
                //$c2 = array_unique($arr);
                //$cc = count($co1);
                $cs = [];
                foreach ($co1 as $k => $v) {
                    $cs[$v] = 0;
                    foreach ($arr as $kk => $vv) {
                        if ($v == $vv) {
                            $cs[$v]++;
                        }
                    }
                }
                if(count($c1) == 1 && isset($cs[$c1[0]]) && $cs[$c1[0]] >= 2 && count($co1) == 2){
                    $v = 1;
                }elseif (count($c1) == 2 && isset($cs[$c1[0]]) && $cs[$c1[0]] >= 1 && isset($cs[$c1[1]]) && $cs[$c1[1]] >= 1 && count($co1) == 2){
                    $v = 1;
                }else{
                    $v = 0;
                }
                break;
            case '2字定位':
                $pnames = str_replace("定位", "", $p['name']);
                switch ($pnames) {
                    case '万千':
                        $arr = [$kj[0], $kj[1]];
                        break;
                    case '万百':
                        $arr = [$kj[0], $kj[2]];
                        break;
                    case '万十':
                        $arr = [$kj[0], $kj[3]];
                        break;
                    case '万个':
                        $arr = [$kj[0], $kj[4]];
                        break;
                    case '千百':
                        $arr = [$kj[1], $kj[2]];
                        break;
                    case '千十':
                        $arr = [$kj[1], $kj[3]];
                        break;
                    case '千个':
                        $arr = [$kj[0], $kj[4]];
                        break;
                    case '百十':
                        $arr = [$kj[2], $kj[3]];
                        break;
                    case '百个':
                        $arr = [$kj[2], $kj[4]];
                        break;
                    case '十个':
                        $arr = [$kj[3], $kj[4]];
                        break;
                }
                $cons = explode(',', $con);
                //$cons = array_unique($cons);
                $cc = count($cons);
                if ($cons[0] == $arr[0] && $cons[1] == $arr[1] && $cc == 2) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '2字和数':
                switch ($c['cm']) {
                    case '万千':
                        $arr = $kj[0] + $kj[1];
                        break;
                    case '万百':
                        $arr = $kj[0] + $kj[2];
                        break;
                    case '万十':
                        $arr = $kj[0] + $kj[3];
                        break;
                    case '万个':
                        $arr = $kj[0] + $kj[4];
                        break;
                    case '千百':
                        $arr = $kj[1] + $kj[2];
                        break;
                    case '千十':
                        $arr = $kj[1] + $kj[3];
                        break;
                    case '千个':
                        $arr = $kj[1] + $kj[4];
                        break;
                    case '百十':
                        $arr = $kj[2] + $kj[3];
                        break;
                    case '百个':
                        $arr = $kj[2] + $kj[4];
                        break;
                    case '十个':
                        $arr = $kj[3] + $kj[4];
                        break;
                }
                if($c['name'] == '和数'){
                    if($p['name'] <= 4 && $arr <= 4) {
                        $v = 1;
                    }elseif ($p['name'] >= 14 && $arr >= 14) {
                        $v = 1;
                    }elseif ($p['name'] == $arr) {
                        $v = 1;
                    }else{
                        $v = 0;
                    }
                }elseif($c['name'] == '和数尾数'){
                    $arr = $arr % 10;
                    if($p['name'] == $arr){
                        $v = 1;
                    }else{
                        $v = 0;
                    }
                }
                /*if (strpos('[单双]', $p['name'])) {
                    $p['name'] == JsFunc::danshuang($arr) ? $v = 1 : ($v = 0);
                } else {
                    $tmp = JsFunc::daxiaow($arr % 10);
                    strpos($p['name'], $tmp) !== false ? $v = 1 : ($v = 0);
                }*/
                break;
            case '3字组合':
                if (strpos($c['name'], '前三') !== false) {
                    $arr = [$kj[0], $kj[1], $kj[2]];
                } else {
                    if (strpos($c['name'], '中三') !== false) {
                        $arr = [$kj[1], $kj[2], $kj[3]];
                    } else {
                        if (strpos($c['name'], '后三') !== false) {
                            $arr = [$kj[2], $kj[3], $kj[4]];
                        }
                    }
                }
                $co1 = explode('-', $con);
                $c1 = array_unique($co1);
                //$c2 = array_unique($arr);
                //$cc = count($co1);
                $cs = [];$cb = [];$cy2 = 0;$cy1 = 0;
                foreach ($co1 as $k => $v) {
                    $cs[$v] = 0;
                    isset($cb[$v]) ? $cb[$v]++ : $cb[$v] = 1;
                    foreach ($arr as $kk => $vv) {
                        if ($v == $vv) {
                            $cs[$v]++;
                        }
                    }
                    if($k == count($co1) - 1){
                        if($cb[$v] == 2){
                            $cy2 = $v;
                        }elseif ($cb[$v] == 1){
                            $cy1 = $v;
                        }
                    }
                }
                if(count($c1) == 1 && isset($cs[$c1[0]]) && $cs[$c1[0]] >= 3 && count($co1) == 3){
                    $v = 1;
                }elseif (count($c1) == 2 && (isset($cs[$cy2]) && $cs[$cy2] == 2 && isset($cs[$cy1]) && $cs[$cy1] == 1) && count($co1) == 3) {
                    $v = 1;
                }elseif (count($c1) == 3 && isset($cs[$c1[0]]) && $cs[$c1[0]] == 1 && isset($cs[$c1[1]]) && $cs[$c1[1]] == 1 && isset($cs[$c1[2]]) && $cs[$c1[2]] == 1 && count($co1) == 3) {
                    $v = 1;
                }else{
                    $v = 0;
                }
                break;
            case '3字定位':
                if (strpos($p['name'], '前三') !== false) {
                    $arr = [$kj[0], $kj[1], $kj[2]];
                } else {
                    if (strpos($p['name'], '中三') !== false) {
                        $arr = [$kj[1], $kj[2], $kj[3]];
                    } else {
                        if (strpos($p['name'], '后三') !== false) {
                            $arr = [$kj[2], $kj[3], $kj[4]];
                        }
                    }
                }
                $cons = explode(',', $con);
                //$cons = array_unique($cons);
                $cc = count($cons);
                if ($arr[0] == $cons[0] & $arr[1] == $cons[1] & $arr[2] == $cons[2] && $cc == 3) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case "3字和数":
                switch ($c['cm']) {
                    case '前三':
                        $arr = $kj[0] + $kj[1] + $kj[2];
                        break;
                    case '中三':
                        $arr = $kj[1] + $kj[2] + $kj[3];
                        break;
                    case '后三':
                        $arr = $kj[2] + $kj[3] + $kj[4];
                        break;
                }
                if($c['name'] == '和数'){
                    if($p['name'] <= 6 && $arr <= 6) {
                        $v = 1;
                    }elseif ($p['name'] >= 21 && $arr >= 21) {
                        $v = 1;
                    }elseif ($p['name'] == $arr) {
                        $v = 1;
                    }else{
                        $v = 0;
                    }
                }elseif($c['name'] == '和数尾数'){
                    $arr = $arr % 10;
                    if($p['name'] == $arr){
                        $v = 1;
                    }else{
                        $v = 0;
                    }
                }
                /*if (strpos('[和单和双]', $p['name']) !== false) {
                    $tmp = JsFunc::danshuang($arr);
                    if (strpos($p['name'], $tmp)) {
                        $v = 1;
                    } else {
                        $v = 0;
                    }
                } else {
                    if (strpos('[和大和小]', $p['name']) !== false) {
                        if ($arr >= 14 && $p['name'] == '和大' || $arr <= 13 & $p['name'] == '和小') {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                    } else {
                        if (strpos('[和尾大和尾小]', $p['name']) !== false) {
                            $tmp = JsFunc::daxiaow($arr % 10);
                            if (strpos($p['name'], $tmp)) {
                                $v = 1;
                            } else {
                                $v = 0;
                            }
                        }
                    }
                }*/
                break;
            case '总和龙虎':
                $ma = $kj[0] + $kj[1] + $kj[2] + $kj[3] + $kj[4];
                switch ($p['name']) {
                    case '单':
                    case '双':
                        $p['name'] == JsFunc::danshuang($ma) ? $v = 1 : ($v = 0);
                        break;
                    case '大':
                        $ma >= 23 ? $v = 1 : ($v = 0);
                        break;
                    case '小':
                        $ma <= 22 ? $v = 1 : ($v = 0);
                        break;
                    case '总和尾大':
                    case '总和尾小':
                        strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false ? $v = 1 : ($v = 0);
                        break;
                    case "龙":
                    case "虎":
                    case "和":
                        $tmp = JsFunc::longhuhe($kj[0], $kj[4]);
                        $tmp == $p['name'] && ($v = 1);
                        $tmp == '和' && $p['name'] != '和' && ($v = 2);
                        break;
                }
                break;
            case '组选3':
                if (strpos($p['name'], '前三') !== false) {
                    $arr = [$kj[0], $kj[1], $kj[2]];
                } else {
                    if (strpos($p['name'], '中三') !== false) {
                        $arr = [$kj[1], $kj[2], $kj[3]];
                    } else {
                        if (strpos($p['name'], '后三') !== false) {
                            $arr = [$kj[2], $kj[3], $kj[4]];
                        }
                    }
                }
                if (JsFunc::duizhi($arr[0], $arr[1], $arr[2]) != 1) {
                    $v = 0;
                    break;
                }
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if (in_array($arr[0], $cons) && in_array($arr[1], $cons) && in_array($arr[2], $cons)) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '组选6':
                if (strpos($p['name'], '前三') !== false) {
                    $arr = [$kj[0], $kj[1], $kj[2]];
                } else {
                    if (strpos($p['name'], '中三') !== false) {
                        $arr = [$kj[1], $kj[2], $kj[3]];
                    } else {
                        if (strpos($p['name'], '后三') !== false) {
                            $arr = [$kj[2], $kj[3], $kj[4]];
                        }
                    }
                }
                if (JsFunc::duizhi($arr[0], $arr[1], $arr[2]) == 1 | JsFunc::baozhi($arr[0], $arr[1], $arr[2]) == 1) {
                    $v = 0;
                    break;
                }
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if (in_array($arr[0], $cons) && in_array($arr[1], $cons) && in_array($arr[2], $cons)) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '跨度':
                switch ($c['cm']) {
                    case '前三':
                        $k1 = abs($kj[0] - $kj[1]);
                        $k2 = abs($kj[0] - $kj[2]);
                        $k3 = abs($kj[1] - $kj[2]);
                        $k = max($k1, $k2, $k3);
                        break;
                    case '中三':
                        $k1 = abs($kj[1] - $kj[2]);
                        $k2 = abs($kj[1] - $kj[3]);
                        $k3 = abs($kj[2] - $kj[3]);
                        $k = max($k1, $k2, $k3);
                        break;
                    case '后三':
                        $k1 = abs($kj[2] - $kj[3]);
                        $k2 = abs($kj[2] - $kj[4]);
                        $k3 = abs($kj[3] - $kj[4]);
                        $k = max($k1, $k2, $k3);
                        break;
                }
                $k == $p['name'] ? $v = 1 : ($v = 0);
                break;
            case '牛牛':
            case '斗牛':
                $nn = JsFunc::niuniu($kj);
                $zflag = 0;
                if ($nn[0]) {
                    switch ($nn[2]) {
                        case 0:
                            if ($p['name'] == '牛牛' | $p['name'] == '牛大' | $p['name'] == '牛双' | $p['name'] == '牛合') {
                                $zflag = 1;
                            }
                            break;
                        case 1:
                            if ($p['name'] == '牛一' | $p['name'] == '牛小' | $p['name'] == '牛单' | $p['name'] == '牛质') {
                                $zflag = 1;
                            }
                            break;
                        case 2:
                            if ($p['name'] == '牛二' | $p['name'] == '牛小' | $p['name'] == '牛双' | $p['name'] == '牛质') {
                                $zflag = 1;
                            }
                            break;
                        case 3:
                            if ($p['name'] == '牛三' | $p['name'] == '牛小' | $p['name'] == '牛单' | $p['name'] == '牛质') {
                                $zflag = 1;
                            }
                            break;
                        case 4:
                            if ($p['name'] == '牛四' | $p['name'] == '牛小' | $p['name'] == '牛双' | $p['name'] == '牛合') {
                                $zflag = 1;
                            }
                            break;
                        case 5:
                            if ($p['name'] == '牛五' | $p['name'] == '牛小' | $p['name'] == '牛单' | $p['name'] == '牛质') {
                                $zflag = 1;
                            }
                            break;
                        case 6:
                            if ($p['name'] == '牛六' | $p['name'] == '牛大' | $p['name'] == '牛双' | $p['name'] == '牛合') {
                                $zflag = 1;
                            }
                            break;
                        case 7:
                            if ($p['name'] == '牛七' | $p['name'] == '牛大' | $p['name'] == '牛单' | $p['name'] == '牛质') {
                                $zflag = 1;
                            }
                            break;
                        case 8:
                            if ($p['name'] == '牛八' | $p['name'] == '牛大' | $p['name'] == '牛双' | $p['name'] == '牛合') {
                                $zflag = 1;
                            }
                            break;
                        case 9:
                            if ($p['name'] == '牛九' | $p['name'] == '牛大' | $p['name'] == '牛单' | $p['name'] == '牛合') {
                                $zflag = 1;
                            }
                            break;
                    }
                }else{
                    if ($p['name'] == '无牛') {
                        $zflag = 1;
                    }
                }
                if ($zflag == 1) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '梭哈':
                $suoha = JsFunc::suoha($kj);
                if ($suoha == $p['name']) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '斗牛梭哈':
                $suoha = JsFunc::douniusuoha($kj);
                if ($suoha == $p['name']) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '前中后三':
                switch ($c['cm']) {
                    case '前三':
                        $k1 = $kj[0];
                        $k2 = $kj[1];
                        $k3 = $kj[2];
                        break;
                    case '中三':
                        $k1 = $kj[1];
                        $k2 = $kj[2];
                        $k3 = $kj[3];
                        break;
                    case '后三':
                        $k1 = $kj[2];
                        $k2 = $kj[3];
                        $k3 = $kj[4];
                        break;
                }
                switch ($p['name']) {
                    case '豹子':
                        $vv = JsFunc::baozhi($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '顺子':
                        $vv = JsFunc::shunzhi($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '对子':
                        $vv = JsFunc::duizhi($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '半顺':
                        $vv = JsFunc::banshun($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '杂六':
                        $vv = JsFunc::zaliu($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                }
                break;
        }
        return [$v];
    }

    public static function moni_163($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft)
    {
        $v = 0;
        switch ($b) {
            case '番摊':
                switch ($c['name']) {
                    case "双面":
                        if ($p['name'] == "单" && $ft % 2 == 1) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "双" && $ft % 2 == 0) {
                                $v = 1;
                            } else {
                                if ($p['name'] == "大" && $ft > 2) {
                                    $v = 1;
                                } else {
                                    if ($p['name'] == "小" && $ft < 3) {
                                        $v = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case "番":
                        $ft . "番" == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "念":
                        $ps = explode('念', $p["name"]);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if ($ps[1] == $ft) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    case "角":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case "正":
                        $ps = str_replace('正', '', $p['name']);
                        if ($ps > 2) {
                            $psdui = $ps - 2;
                        } else {
                            $psdui = $ps + 2;
                        }
                        if ($ps == $ft) {
                            $v = 1;
                        } else {
                            if ($psdui == $ft) {
                                $v = 0;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                    case "中":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case '加':
                        $ps = explode('加', $p['name']);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if (strpos($ps[1], $ft . "") !== false) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    default:
                        if ($p['znum1'] == $ft) {
                            $v = 0;
                        } else {
                            if (strpos($p['name'], $ft . "") !== false) {
                                $v = 1;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                }
                break;
            case '1~3':
                $ma = $kj[$c['mtype']];
                switch ($p['ztype']) {
                    case "码":
                        $ma == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "单双":
                        strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                        break;
                    case "大小":
                        if ($p['name'] == "大" && $ma > 5) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "小" && $ma < 5) {
                                $v = 1;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                }
                break;
            case '1字组合':
                $arr = $kj;
                if (in_array($p['name'], $arr)) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '2字组合':
                $arr = [];
                $arr = [$kj[0], $kj[1], $kj[2]];
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if (in_array($cons[0], $arr) && in_array($cons[1], $arr) && $cc == 2) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '2字定位':
                $pnames = str_replace("定位", "", $p['name']);
                switch ($pnames) {
                    case '百十':
                        $arr = [$kj[2], $kj[3]];
                        break;
                    case '百个':
                        $arr = [$kj[2], $kj[4]];
                        break;
                    case '十个':
                        $arr = [$kj[3], $kj[4]];
                        break;
                }
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if ($cons[0] == $arr[0] && $cons[1] == $arr[1] && $cc == 2) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '2字和数':
                switch ($c['cm']) {
                    case '百十':
                        $arr = $kj[2] + $kj[3];
                        break;
                    case '百个':
                        $arr = $kj[2] + $kj[4];
                        break;
                    case '十个':
                        $arr = $kj[3] + $kj[4];
                        break;
                }
                if (strpos('[单双]', $p['name'])) {
                    $p['name'] == JsFunc::danshuang($arr) ? $v = 1 : ($v = 0);
                } else {
                    $tmp = JsFunc::daxiaow($arr % 10);
                    strpos($p['name'], $tmp) !== false ? $v = 1 : ($v = 0);
                }
                break;
            case '3字组合':
                $arr = $kj;
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if (in_array($cons[0], $arr) && in_array($cons[1], $arr) && in_array($cons[2], $arr) && $cc == 3) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '3字定位':
                $arr = $kj;
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if ($arr[0] == $cons[0] & $arr[1] == $cons[1] & $arr[2] == $cons[2] && $cc == 3) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '总和龙虎':
                $ma = $kj[0] + $kj[1] + $kj[2];
                switch ($p['name']) {
                    case '总和单':
                    case '总和双':
                        strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                        $ma == 14 && $p['name'] == "总和双" && ($v = 2);
                        $ma == 13 && $p['name'] == "总和单" && ($v = 2);
                        break;
                    case '总和大':
                        $ma > 14 ? $v = 1 : ($v = 0);
                        $ma == 14 && ($v = 2);
                        break;
                    case '总和小':
                        $ma < 13 ? $v = 1 : ($v = 0);
                        $ma == 13 && ($v = 2);
                        break;
                    case '总和尾大':
                    case '总和尾小':
                        strpos($p['name'], JsFunc::daxiaow($ma % 10)) !== false ? $v = 1 : ($v = 0);
                        break;
                    case "龙":
                    case "虎":
                    case "和":
                        $tmp = JsFunc::longhuhe($kj[0], $kj[2]);
                        $tmp == $p['name'] ? $v = 1 : ($v = 0);
                        $tmp == '和' && $p['name'] != '和' && ($v = 2);
                        break;
                    case "极大":
                        $ma >= 22 && ($v = 1);
                        break;
                    case "极小":
                        $ma <= 5 && ($v = 1);
                        break;
                    case '总大单':
                        $tmp = JsFunc::danshuang($ma);
                        ($tmp == "单" && $ma > 14) && ($v = 1);
                        break;
                    case '总大双':
                        $tmp = JsFunc::danshuang($ma);
                        ($tmp == "双" && $ma > 14) && ($v = 1);
                        ($tmp == "双" && $ma == 14) && ($v = 2);
                        break;
                    case '总小单':
                        $tmp = JsFunc::danshuang($ma);
                        ($tmp == "单" && $ma < 13) && ($v = 1);
                        ($tmp == "单" && $ma == 13) && ($v = 2);
                        break;
                    case '总小双':
                        $tmp = JsFunc::danshuang($ma);
                        ($tmp == "双" && $ma < 13) && ($v = 1);
                        break;
                    default:
                        $ma == $p['name'] && ($v = 1);
                        break;
                }
                break;
            case '组选3':
                $arr = $kj;
                if (JsFunc::duizhi($arr[0], $arr[1], $arr[2]) != 1) {
                    $v = 0;
                    break;
                }
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if (in_array($arr[0], $cons) && in_array($arr[1], $cons) && in_array($arr[2], $cons)) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '组选6':
                $arr = $kj;
                if (JsFunc::duizhi($arr[0], $arr[1], $arr[2]) == 1 || JsFunc::baozhi($arr[0], $arr[1], $arr[2]) == 1) {
                    $v = 0;
                    break;
                }
                $cons = explode('-', $con);
                $cons = array_unique($cons);
                $cc = count($cons);
                if (in_array($arr[0], $cons) && in_array($arr[1], $cons) && in_array($arr[2], $cons)) {
                    $v = 1;
                } else {
                    $v = 0;
                }
                break;
            case '跨度':
                $k1 = abs($kj[0] - $kj[1]);
                $k2 = abs($kj[0] - $kj[2]);
                $k3 = abs($kj[1] - $kj[2]);
                $k = max($k1, $k2, $k3);
                $k == $p['name'] ? $v = 1 : ($v = 0);
                break;
            case '前三':
                $k1 = $kj[0];
                $k2 = $kj[1];
                $k3 = $kj[2];
                switch ($p['name']) {
                    case '豹子':
                        $vv = JsFunc::baozhi($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '顺子':
                        $vv = JsFunc::shunzhi($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '对子':
                        $vv = JsFunc::duizhi($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '半顺':
                        $vv = JsFunc::banshun($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                    case '杂六':
                        $vv = JsFunc::zaliu($k1, $k2, $k3);
                        $vv == 1 ? $v = 1 : ($v = 0);
                        break;
                }
                break;
        }
        return [$v];
    }

    public static function moni_107($fenlei, $gid, $kj, $b, $s, $c, $p, $con, $ft)
    {
        $v = 0;
        switch ($p['ztype']) {
            case '番摊':
                switch ($c['name']) {
                    case "双面":
                        if ($p['name'] == "单" && $ft % 2 == 1) {
                            $v = 1;
                        } else {
                            if ($p['name'] == "双" && $ft % 2 == 0) {
                                $v = 1;
                            } else {
                                if ($p['name'] == "大" && $ft > 2) {
                                    $v = 1;
                                } else {
                                    if ($p['name'] == "小" && $ft < 3) {
                                        $v = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case "番":
                        $ft . "番" == $p['name'] ? $v = 1 : ($v = 0);
                        break;
                    case "念":
                        $ps = explode('念', $p["name"]);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if ($ps[1] == $ft) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    case "角":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case "正":
                        $ps = str_replace('正', '', $p['name']);
                        if ($ps > 2) {
                            $psdui = $ps - 2;
                        } else {
                            $psdui = $ps + 2;
                        }
                        if ($ps == $ft) {
                            $v = 1;
                        } else {
                            if ($psdui == $ft) {
                                $v = 0;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                    case "中":
                        if (strpos($p['name'], $ft . "") !== false) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        break;
                    case '加':
                        $ps = explode('加', $p['name']);
                        if ($ps[0] == $ft) {
                            $v = 1;
                        } else {
                            if (strpos($ps[1], $ft . "") !== false) {
                                $v = 2;
                            } else {
                                $v = 0;
                            }
                        }
                        break;
                    default:
                        if ($p['znum1'] == $ft) {
                            $v = 0;
                        } else {
                            if (strpos($p['name'], $ft . "") !== false) {
                                $v = 1;
                            } else {
                                $v = 2;
                            }
                        }
                        break;
                }
                break;
            case '码':
                $b == '冠亚军组合' ? $ma = $kj[0] + $kj[1] : ($ma = $kj[$c['mtype']]);
                $ma == $p['name'] ? $v = 1 : ($v = 0);
                break;
            case '单双':
                $b == '冠亚军组合' ? $ma = $kj[0] + $kj[1] : ($ma = $kj[$c['mtype']]);
                strpos($p['name'], JsFunc::danshuang($ma)) !== false ? $v = 1 : ($v = 0);
                break;
            case '大小':
                $v = 0;
                if ($b == '冠亚军组合') {
                    $zf = $kj[0] + $kj[1];
                    if ($p['name'] == '冠亚大' && $zf > 11) {
                        $v = 1;
                    } else {
                        if ($p['name'] == '冠亚小' && $zf <= 11) {
                            $v = 1;
                        }
                    }
                } else {
                    $ma = $kj[$c['mtype']];
                    if ($p['name'] == '大' & $ma >= 6) {
                        $v = 1;
                    } else {
                        if ($p['name'] == '小' & $ma <= 5) {
                            $v = 1;
                        }
                    }
                }
                break;
            case '龙虎':
                $ma = JsFunc::longhuhe($kj[$c['mtype']], $kj[9 - $c['mtype']]);
                $ma == $p['name'] ? $v = 1 : $v = 0;
                break;
        }
        return [$v];
    }

    public static function calc($fenlei,$gid,$kjarr,$qishu,$ztype,$mtype,$ruid,$roomConfig,$qz = false){
        Log::info("结算开始->【{$gid}】【{$qishu}】【{$ruid}】");
        //结算锁检测
        $lock = "jslock_{$gid}_{$qishu}_{$ruid}";
        if(!empty(Cache::get($lock))){
            Log::info("正在结算，gid:{$gid},qishu:{$qishu},ruid:{$ruid}");
            return ['code'=>0,'result'=>[]];
        }
        //缓存结算锁
        Cache::put($lock,1,10);
        $db = Db::connection();$thisdate = ComFunc::getthisdateend();
        $whi = " ruid = {$ruid} and gid='{$gid}' and qishu='{$qishu}' ";
        $tb_lib = SGUtils::getcuretable(true);
        if($qz){//强制结算，还原订单z=9
            $db->update("update {$tb_lib} set z=9,zcount=1 where $whi and z<>7");
            $db->delete("delete from x_money_log where ruid = {$ruid} and gid = {$gid} and qishu = {$qishu} and moneyType = 2");
        }
        $tmp = [];$marr = [];
        $sql = "select bid,sid,cid,pid from `{$tb_lib}` where $whi and z = 9 group by pid";
        $lib = $db->select($sql);
        $cl = count($lib);
        $tmpcid = 0;
        $ft = 0;
        $sx = [];$ws = [];
        foreach ($lib as $order){
            if ($tmpcid != $order['cid']) {
                if (!isset($tmp['c'.$order['cid']])) {
                    $mclass = CommonCache::getclasscache($gid,$order['cid']);
                    $tmp['c'.$order['cid']]['name'] = $mclass['name'];
                    $tmp['c'.$order['cid']]['mtype'] = $mclass['mtype'];
                    $tmp['c'.$order['cid']]['ftype'] = $mclass['ftype'];
                    $tmp['c'.$order['cid']]['cm'] = $mtype[$mclass['mtype']];
                    $tmp['c'.$order['cid']]['dftype'] = $mclass['dftype'];
                }
                if (!isset($tmp['s'.$order['sid']])) {
                    $tmp['s'.$order['sid']] = CommonCache::getsclasscache($gid,$order['sid'])['name'];
                }
                if (!isset($tmp['b'.$order['bid']])) {
                    $tmp['b'.$order['bid']] = CommonCache::getbclasscache($gid,$order['bid'])['name'];
                }
            }
            if (!isset($tmp['p'.$order['pid']])) {
                $play = CommonCache::getplaycache($gid,$order['pid']);
                $tmp['p'.$order['pid']]['name'] = $play["name"];
                $tmp['p'.$order['pid']]['ztype'] = $ztype[$play["ztype"]];
                $tmp['p'.$order['pid']]['znum1'] = $play['znum1'];
                $tmp['p'.$order['pid']]['znum2'] = $play['znum2'];
                $tmp['p'.$order['pid']]['ptype'] = $play['ptype'];
            }
            $flag = self::calcjs($fenlei,$gid, $kjarr, $tmp['b'.$order['bid']], $tmp['s'.$order['sid']], $tmp['c'.$order['cid']], $tmp['p'.$order['pid']], '', $ft, $marr, $sx, $ws);
            $zcount = 1;
            if(isset($flag[2]) && $flag[2] > 1){
                $zcount = $flag[2];
            }
            if($flag[0] == 2 && $roomConfig['dtSettleMethod'] == 1){//和局是否有群主需要通杀
                $db->update("update `{$tb_lib}` set z=0,zcount={$zcount} where {$whi} and pid='{$order['pid']}'");
            }else{
                $db->update("update `{$tb_lib}` set z='{$flag[0]}',zcount={$zcount} where {$whi} and pid='{$order['pid']}' and z = 9");
            }
            $tmpcid = $order['cid'];
        }
        $uids = $db->select("select sum(if(z=1,peilv1*je*zcount,0)) as zhong,sum(if(z in (0,1),je,0)) as zje,sum(if(z=1,uzp*je,0)) as tax,sum(if(z=2,je,0)) as heje,userid from `$tb_lib` where {$whi} and z in (0,1,2) group by userid");
        $result = [];
        foreach ($uids as $row) {
            $userid = $row['userid'];
            $zhong = $row['zhong'] ?: 0;
            $zje = $row['zje'] ?: 0;
            $tax = $row['tax'] ?: 0;
            $heje = $row['heje'] ?: 0;
            //是否结算过
            $key = 'js_'.$ruid.'_'.$userid.'_'.$gid.'_'.$qishu;
            //$cc = MoneyLog::where(['ruid'=>$ruid,'userid'=>$userid,'gid'=>$gid,'qishu'=>$qishu,'moneyType'=>2])->count("id");
            $cc = Cache::get($key);
            if(!empty($cc)){
                continue;
            }
            $retrycount = 0;
            while ($retrycount < 10){
                $myk = $zhong-$tax+$heje;
                $yk = $zhong-$zje-$tax+$heje;
                $yk1 = $zhong-$zje-$tax;
                $jg = $zje+$yk;
                //进行余额结算
                try {
                    //$db->beginTransaction();
                    $user = User::where(['userid'=>$userid,'ruid'=>$ruid])->select(['kmoney','sy','jetotal','name','version'])->first();
                    $update = [];
                    $beforeMoney = $user['kmoney'];
                    //更新余额
                    $update['kmoney'] = $user['kmoney']+$jg;
                    $update['sy'] = $user['sy']+$yk1;
                    //投注总金额
                    $update['jetotal'] = $user['jetotal']+$zje;
                    //版本号
                    $update['version'] = $user['version']+1;
                    $res = User::where(['userid'=>$userid,'ruid'=>$ruid])->update($update);
                    if(!$res){
                        throw new \Exception("ruid:{$ruid},userid:{$userid},version:{$user['version']}更新余额失败");
                    }
                    //资金日志记录
                    if($myk > 0){
                        $savemoneylog = [];
                        $savemoneylog['ruid'] = $ruid;
                        $savemoneylog['userid'] = $userid;
                        $savemoneylog['beforeMoney'] = $beforeMoney;
                        $savemoneylog['money'] = $myk;
                        $savemoneylog['operateType'] = 1;
                        $savemoneylog['moneyType'] = 2;
                        $savemoneylog['gid'] = $gid;
                        $savemoneylog['qishu'] = $qishu;
                        $savemoneylog['time'] = time();
                        $savemoneylog['dates'] = strtotime($thisdate);
                        MoneyLog::create($savemoneylog);
                    }
                    $result[$userid] = $update['kmoney'];
                    //$db->commit();
                    Cache::put($key,1,300);
                    break;
                }catch (\Exception $e) {
                    $retrycount++;
                    //$db->rollBack();
                    Log::info("结算失败，userid:{$userid},gid:{$gid},qishu:{$qishu},ruid:{$ruid},retrycount:{$retrycount},msg:{$e->getMessage()}");
                }
            }
        }
        //更新结算
        $db->update("update `{$tb_lib}` set isjs=1 where {$whi}");
        ReportService::zhengli_day_reportdanqi($ruid,'',$gid,$qishu);
        /*$rs = $db->select("select count(id) as ra from `$tb_lib` where {$whi} and z=9");
        $c = isset($rs[0]['ra']) ? $rs[0]['ra'] : 0;
        if($c <= 0){
            //结算通知
            if($cl > 0){
                $param = [];
                $param['type']  = 'winnerListAfterSettlement';
                $param['gid'] = $gid;
                $param['qishu'] = $qishu;
                Task::deliver(new CommonQueue($param));
            }
            $time = time();
            $db->update("update x_kj set js=1,js_time={$time} where {$whi}");
            //报表合并
            //ReportService::zhengli_day_reportdanqi('',$gid,$qishu);
        }*/
        Log::info("结算完成->【{$gid}】【{$qishu}】【{$ruid}】【count:{$cl}】");
        //清除结算锁
        Cache::delete($lock);
        return ['code'=>1,'result'=>$result];
    }

    public static function getb($gid){
        if ($gid == 107) {
            $b[0]['bid'] = 0;
            $b[0]['i'] = 0;
            $b[0]['name'] = '冠、亚军组合';
            $b[1]['bid'] = 1;
            $b[1]['i'] = 1;
            $b[1]['name'] = '三、四、五、六名';
            $b[2]['bid'] = 2;
            $b[2]['i'] = 2;
            $b[2]['name'] = '七、八、九、十名';
        } else {
            $bclass_list = Bclass::where(['gid' => $gid, 'ifok' => 1])->select(['bid','name'])->orderBy('xsort')->get();
            $i = 0;
            $b = array();
            foreach ($bclass_list as $item) {
                $b[$i]['bid'] = $item['bid'];
                $b[$i]['name'] = $item['name'];
                $b[$i]['i'] = $i;
                $i++;
            }
        }
        return $b;
    }

    public static function getbh($gid){
        $bclass_list = Bclass::where(['gid' => $gid, 'ifok' => 1])->orderBy('xsort')->select(['bid','name'])->get();
        $i = 0;
        $b = array();
        foreach ($bclass_list as $item) {
            $b[$i]['bid'] = $item['bid'];
            $b[$i]['name'] = $item['name'];
            $b[$i]['i'] = $i;
            $i++;
        }
        return $b;
    }

    public static function getma(){
        $ma = json_decode(x_config('ma'), true);
        return $ma;
    }

    public static function transb($gid, $field, $bid)
    {
        return Bclass::where(['gid' => $gid, 'bid' => $bid])->value($field);
    }

    public static function transs($gid, $field, $sid)
    {
        return Sclass::where(['gid' => $gid, 'sid' => $sid])->value($field);
    }

    public static function transc($gid, $field, $cid)
    {
        return Mclass::where(['gid' => $gid, 'cid' => $cid])->value($field);
    }

    public static function transp($gid, $field, $pid)
    {
        return Play::where(['gid' => $gid, 'pid' => $pid])->value($field);
    }

    public static function getgame(){
        $db = Db::connection();
        $list = $db->select("select gid,gname,fast,panstatus,otherstatus,otherclosetime,userclosetime,mnum,fenlei,ifopen,autokj,guanfang,xsort from x_game order by xsort");
        $i = 0;
        foreach ($list as $item) {
            $game[$i]['gid'] = $item['gid'];
            $game[$i]['gname'] = $item['gname'];
            $game[$i]['fast'] = $item['fast'];
            $game[$i]['mnum'] = $item['mnum'];
            $game[$i]['fenlei'] = $item['fenlei'];
            $game[$i]['xsort'] = $item['xsort'];
            $game[$i]['panstatus'] = $item['panstatus'];
            $game[$i]['otherstatus'] = $item['otherstatus'];
            $game[$i]['otherclosetime'] = $item['otherclosetime'];
            $game[$i]['userclosetime'] = $item['userclosetime'];
            $game[$i]['ifopen'] = $item['ifopen'];
            $game[$i]['autokj'] = $item['autokj'];
            $game[$i]['guanfang'] = $item['guanfang'];
            $i++;
        }
        return $game;
    }
}
