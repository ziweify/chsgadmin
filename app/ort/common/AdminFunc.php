<?php


namespace App\ort\common;


use App\Models\Game\Game;
use App\Models\Game\Play;
use App\Models\Game\PlayUser;
use App\Models\Game\User;
use App\ort\sgwin\SGUtils;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminFunc
{
    public static function week(){
        $start = str_replace(':','',x_config('editstart'));
        $zuo = 0;
        if(date("His")<$start) $zuo=1;
        $getWeekDay = date("w");
        if ($getWeekDay == 0) {
            $sdate = array(
                0 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
                1 => date('Y-m-d', mktime(0, 0, 0, date('n'), 1, date('Y'))),
                2 => date('Y-m-d', mktime(0, 0, 0, date('n'), date('t'), date('Y'))),
                3 => date('Y-m-01', strtotime('last month')),
                4 => date('Y-m-t', strtotime('last month')),
                5 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7, date("Y"))),
                6 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7, date("Y"))),
                7 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7 - 7, date("Y"))),
                8 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7 - 7, date("Y"))),
                9 => date("Y-m-d", mktime(0, 0, 0, date('m') - 1, date('d') - 4, date('Y'))),
                10 => date("Y-m-d"),
                11 => date("Y-m-d"),
                12 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
            );
        } else if ($getWeekDay == 1 && $zuo==1) {
            $sdate = array(
                0 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
                1 => date('Y-m-d', mktime(0, 0, 0, date('n'), 1, date('Y'))),
                2 => date('Y-m-d', mktime(0, 0, 0, date('n'), date('t'), date('Y'))),
                3 => date('Y-m-01', strtotime('last month')),
                4 => date('Y-m-t', strtotime('last month')),
                5 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7, date("Y"))),
                6 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7, date("Y"))),
                7 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7 - 7, date("Y"))),
                8 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7 - 7, date("Y"))),
                9 => date("Y-m-d", mktime(0, 0, 0, date('m') - 1, date('d') - 4, date('Y'))),
                10 => date("Y-m-d"),
                11 => date("Y-m-d"),
                12 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
            );
        } else {
            $sdate = array(
                0 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
                1 => date('Y-m-d', mktime(0, 0, 0, date('n'), 1, date('Y'))),
                2 => date('Y-m-d', mktime(0, 0, 0, date('n'), date('t'), date('Y'))),
                3 => date('Y-m-01', strtotime('last month')),
                4 => date('Y-m-t', strtotime('last month')),
                5 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1, date("Y"))),
                6 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7, date("Y"))),
                7 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7, date("Y"))),
                8 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7, date("Y"))),
                9 => date("Y-m-d", mktime(0, 0, 0, date('m') - 1, date('d') - 4, date('Y'))),
                10 => date("Y-m-d"),
                11 => date("Y-m-d"),
                12 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
            );
        }
        if($zuo==1){
            $sdate[0] = date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')));
            $sdate[10] = date("Y-m-d",time()-86400);
        }
        return $sdate;
    }

    public static function weekbyreport(){
        $zuo = 0;
        $getWeekDay = date("w");
        if ($getWeekDay == 0) {
            $sdate = array(
                0 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
                1 => date('Y-m-d', mktime(0, 0, 0, date('n'), 1, date('Y'))),
                2 => date('Y-m-d', mktime(0, 0, 0, date('n'), date('t'), date('Y'))),
                3 => date('Y-m-01', strtotime('last month')),
                4 => date('Y-m-t', strtotime('last month')),
                5 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7, date("Y"))),
                6 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7, date("Y"))),
                7 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7 - 7, date("Y"))),
                8 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7 - 7, date("Y"))),
                9 => date("Y-m-d", mktime(0, 0, 0, date('m') - 1, date('d') - 4, date('Y'))),
                10 => date("Y-m-d")
            );
        } else if ($getWeekDay == 1 && $zuo==1) {
            $sdate = array(
                0 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
                1 => date('Y-m-d', mktime(0, 0, 0, date('n'), 1, date('Y'))),
                2 => date('Y-m-d', mktime(0, 0, 0, date('n'), date('t'), date('Y'))),
                3 => date('Y-m-01', strtotime('last month')),
                4 => date('Y-m-t', strtotime('last month')),
                5 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7, date("Y"))),
                6 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7, date("Y"))),
                7 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7 - 7, date("Y"))),
                8 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7 - 7, date("Y"))),
                9 => date("Y-m-d", mktime(0, 0, 0, date('m') - 1, date('d') - 4, date('Y'))),
                10 => date("Y-m-d")
            );
        } else {
            $sdate = array(
                0 => date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))),
                1 => date('Y-m-d', mktime(0, 0, 0, date('n'), 1, date('Y'))),
                2 => date('Y-m-d', mktime(0, 0, 0, date('n'), date('t'), date('Y'))),
                3 => date('Y-m-01', strtotime('last month')),
                4 => date('Y-m-t', strtotime('last month')),
                5 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1, date("Y"))),
                6 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7, date("Y"))),
                7 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 1 - 7, date("Y"))),
                8 => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $getWeekDay + 7 - 7, date("Y"))),
                9 => date("Y-m-d", mktime(0, 0, 0, date('m') - 1, date('d') - 4, date('Y'))),
                10 => date("Y-m-d")
            );
        }
        if($zuo==1){
            $sdate[0] = date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')));
            $sdate[10] = date("Y-m-d",time()-86400);
        }
        return $sdate;
    }

    /**
     * 矫正当天额度
     * @param $qz
     * @param $userid
     * @return false|int
     * @throws \Throwable
     */
    public static function jiaozhengedu($qz = false,$userid = null){
        //如果当前时间在这个范围则不允许修改
        $start = x_config('editstart');
        $end = x_config('editend');
        $now = date('H:i:s');
        if($now >= $start && $now <= $end){
            Log::info('当前时间在'.$start.'-'.$end.'范围内，不允许矫正额度');
            return false;
        }
        $db = Db::connection();
        $table = SGUtils::getcuretable(true);
        if($userid != null && $userid > 0){
            $ulist = User::where('userid',$userid)->select(['userid'])->get();
            foreach ($ulist as $u){
                try {
                    $uid = $u['userid'];
                    $row = $db->select("select sum(if(z=1,peilv1*je*zcount,0)) as zhong,sum(if(z in (0,1),je,0)) as zje,sum(if(z=1,uzp*je,0)) as tax,sum(if(z=9,je,0)) as wjs from `$table` where z<>7 and userid = {$uid}");
                    $zhong = $row['zhong'] ?: 0;
                    $yjs = $row['zje'] ?: 0;
                    $tax = $row['tax'] ?: 0;
                    $wjs = $row['wjs'] ?: 0;

                    $db->beginTransaction();
                    $user = User::where('userid',$u['userid'])->select(['kmaxmoney','kmoney','sy','jetotal'])->lockForUpdate()->first();
                    $mon = $user['kmaxmoney']-$yjs-$wjs+$zhong-$tax;
                    $sy = $zhong-$yjs;
                    if ($yjs != $user['jetotal'] || $qz) {
                        $update = [];
                        $update['kmoney'] = $mon;
                        $update['sy'] = $sy;
                        $update['jetotal'] = $yjs;
                        //更新
                        User::where(['userid'=>$uid])->update($update);
                    }
                    $db->commit();
                }catch (\Exception $e){
                    $db->rollBack();
                    Log::info('矫正额度失败'.$e->getMessage());
                }
            }
        }else{
            $ulist = User::where(['type'=>4])->select(['userid'])->get();
            foreach ($ulist as $u){
                $row = $db->select("select sum(if(z=1,peilv1*je*zcount,0)) as zhong,sum(if(z in (0,1),je,0)) as zje,sum(if(z=1,uzp*je,0)) as tax,sum(if(z=9,je,0)) as wjs from `$table` where z in (0,1,2,9) and userid = {$u['userid']}");
                $uid = $u['userid'];
                $zhong = $row[0]['zhong'] ?: 0;
                $yjs = $row[0]['zje'] ?: 0;
                $tax = $row[0]['tax'] ?: 0;
                $wjs = $row[0]['wjs'] ?: 0;

                try {
                    $db->beginTransaction();
                    $user = User::where('userid',$uid)->select(['kmaxmoney','kmoney','sy','jetotal'])->lockForUpdate()->first();
                    $mon = $user['kmaxmoney']-$yjs-$wjs+$zhong-$tax;
                    $sy = $zhong-$yjs;
                    if ($yjs != $user['jetotal'] || $qz) {
                        $update = [];
                        $update['kmoney'] = $mon;
                        $update['sy'] = $sy;
                        $update['jetotal'] = $yjs;
                        //更新
                        User::where(['userid'=>$uid])->update($update);
                    }
                    $db->commit();
                }catch (\Exception $e){
                    $db->rollBack();
                    Log::info('矫正额度失败'.$e->getMessage());
                }
            }
        }
        return 1;
    }

    /**
     * 自动降赔
     */
    public static function attpeilvs($gid,$qishu = null){
        $db = Db::connection();
        $game = Game::where('gid',$gid)->select(['thisqishu','panstatus','otherstatus'])->first();
        if(empty($qishu)) {
            $qishu = $game['thisqishu'];
        }
        //先从缓存获取
        $rs = Cache::get('autolist_'.$gid);
        if(empty($rs)){
            $sql = "select * from x_auto where gid = '$gid' and ifok=1 and addje > 0 order by class";
            $rs = $db->select($sql);
            //缓存
            Cache::put('autolist_'.$gid,$rs);
        }
        $table = SGUtils::getcuretable(true);
        foreach ($rs as $v) {
            if ($v['startje'] == 0) continue;
            $startje = $v['startje'];
            $startpeilv = $v['startpeilv'];
            $addje = $v['addje'];
            $attpeilv = $v['attpeilv'];
            $lowpeilv = $v['lowpeilv'];
            $stopje = $v['stopje'];
            $ifzc = $v['ifzc'];
            $class = $v['class'];
            $userid = $v['userid'];
            if ($userid == 99999999) {
                if ($ifzc == 1) {
                    $pa = $db->select("select sum(je*zc0/100) as je,pid from $table where gid='$gid' and qishu='$qishu' and dftype = '{$class}' group by pid");
                } else {
                    $pa = $db->select("select sum(je) as je,pid from $table where gid='$gid' and qishu='$qishu' and dftype = '{$class}' group by pid");
                }
            } else {
                if ($ifzc == 1) {
                    $pa = $db->select("select sum(je*zc1/100) as je,pid from $table where gid='$gid' and qishu='$qishu' and uid1='$userid' and dftype = '{$class}' group by pid");
                } else {
                    $pa = $db->select("select sum(je) as je,pid from $table where gid='$gid' and qishu='$qishu' and uid1='$userid' and dftype = '{$class}' group by pid");
                }
            }
            foreach ($pa as $va) {
                $je = $va['je'];
                if ($je < $startje) {
                    continue;
                }
                if ($stopje > 0 && $je >= $stopje) {
                    continue;
                }
                $pid = $va['pid'];
                if ($userid == 99999999) {
                    $play = Play::where(['gid'=>$gid,'pid'=>$pid])->select(['yautocs','ystart'])->first();
                    $ystart = $play['ystart'];
                    $yautocs = $play['yautocs'];
                    $attcs = ((($je - $startje) - (($je - $startje) % $addje)) / $addje) + 1;
                    $ucs = floor($attcs - $yautocs);
                    if ($ucs > 0) {
                        $db->update("update x_play set yautocs='$attcs',peilv1=if(peilv1-$ucs*$attpeilv>$lowpeilv,peilv1-$ucs*$attpeilv,$lowpeilv) where gid='$gid' and pid='$pid'");
                        $db->update("update x_play_user set peilv1=if(peilv1-$ucs*$attpeilv>$lowpeilv,peilv1-$ucs*$attpeilv,$lowpeilv) where gid='$gid' and pid='$pid'");
                    }
                } else {
                    $play_user = PlayUser::where(['userid'=>$userid,'gid'=>$gid,'pid'=>$pid])->select(['yautocs','ystart'])->first();
                    $ystart = $play_user['ystart'];
                    $yautocs = $play_user['yautocs'];
                    $attcs = ((($je - $startje) - (($je - $startje) % $addje)) / $addje) + 1;
                    $ucs = floor($attcs - $yautocs);
                    if ($ucs > 0) {
                        $db->update("update x_play_user set yautocs='$attcs',peilv1=if(peilv1-$ucs*$attpeilv>$lowpeilv,peilv1-$ucs*$attpeilv,$lowpeilv) where userid='$userid' and gid='$gid' and pid='$pid'");
                    }
                }
            }
        }
    }

}
