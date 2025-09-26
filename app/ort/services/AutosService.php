<?php


namespace App\ort\services;


use App\Common\TaskSwoole\CommonQueue;
use App\Common\TaskSwoole\OubetHebingQueue;
use App\Common\TaskSwoole\OutbetHebingOrderQueue;
use App\Models\Game\Game;
use App\Models\Game\Gamemsg;
use App\Models\Game\Kj;
use App\Models\Game\UserEdit;
use App\Models\Game\UserLogin;
use App\Models\Game\Userpatt;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\glob\Iplocationp;
use App\ort\sgwin\ReportService;
use App\ort\sgwin\SGUtils;
use File;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutosService
{
    public static function getcurkj($gid,$cs,$game = null){
        if(!empty($game) && $game['fenlei'] == 100){
            return Kj::where(['gid'=>$gid,'qishu'=>$game['thisqishu']])->first();
        }else{
            //$his = date("His");
            /*$pdstime = str_replace(':', '', $cs['starttime']);
            $pdetime = str_replace(':', '', $cs['starttime2']);
            if(($pdetime < $pdstime) && $his < $pdetime){
                $dates = date("Y-m-d", time() - 86400);
            }else{
                $dates = date("Y-m-d");
            }*/
            $dates = ComFunc::getthisdate();
            $time = time();
            return Kj::where(['gid'=>$gid,'dates'=>strtotime($dates)])->where('opentime','<=',$time)->where('kjtime','>=',$time)->orderBy('qishu')->first();
        }
    }

    /**
     * 快开彩数据生成
     */
    public static function fast_create_data($gid = 0,$taskgroup = 0){
        $db = Db::connection();
        $where = [];
        $where[] = ['ifopen','=',1];
        if($gid > 0){
            $where['gid'] = $gid;
        }
        if($taskgroup > 0){
            $where['taskgroup'] = $taskgroup;
        }
        $dates = ComFunc::getthisdate();
        $field = ['qishu','closetime','kjtime'];
        $game_list = Game::where($where)->select(['cs','stopstatus','cs','thisqishu','gid','userclosetime','gname'])->orderBy('xsort')->get();
        foreach ($game_list as $item){
            $gid = $item['gid'];
            $kj_sig = SGUtils::currentPeriod($gid,$dates,null,$field);
            if(empty($kj_sig)){//不存在开奖数据
                $cs = json_decode($item['cs'], true);
                $ist = SGUtils::pdtime($cs['starttime'],$cs['starttime2']);
                if($ist == 0){
                    if($item['stopstatus'] == 0){
                        Game::where(['gid'=>$gid,'stopstatus'=>0])->update(['stopstatus'=>1]);
                    }
                    continue;
                }
                self::create_kjdata($gid);
            } else {
                if($item['stopstatus'] == 1){
                    Game::where(['gid'=>$gid])->update(['stopstatus'=>0]);
                }
                $time = time();$gameMsgArr1 = [];$gameMsgArr2 = [];$isfp = 0;
                $allUserPatt = $db->select("SELECT b.userid,b.panstatus,b.thisqishu,b.upqishu,b.fpseconds,a.roomNickname,a.roomAvatar,a.orderSummaryDisplay,a.outbet_switch FROM x_userroom as a,x_userpatt as b WHERE a.userid = b.userid and b.gid = {$gid} and b.ifopen = 1 and b.ifok = 1;");
                foreach ($allUserPatt as $up){
                    if($up['panstatus'] == 0){//开盘中
                        if(($kj_sig['closetime']-$item['userclosetime']-$up['fpseconds']) >= $time){
                            Userpatt::where(['userid'=>$up['userid'],'gid'=>$gid])->update(['panstatus'=>1]);
                        }
                    }
                    if($up['panstatus'] == 1){//封盘中
                        if(($kj_sig['closetime']-$item['userclosetime']-$up['fpseconds']) < $time && $kj_sig['kjtime'] >= $time){
                            //合并飞单
                            if($up['outbet_switch'] == 1){
                                Task::deliver(new OubetHebingQueue(['ruid'=>$up['userid'],'gid'=>$gid,'qishu'=>$kj_sig['qishu']]));
                            }
                            //Log::info("开始合并飞单1：".$up['userid']." gid：".$gid." qishu：".$kj_sig['qishu']);
                            $isfp = 1;
                            Userpatt::where(['userid'=>$up['userid'],'gid'=>$gid])->update(['panstatus'=>0]);
                            $gameMsgArr2[] = ['ruid'=>$up['userid'],'roomNickname'=>$up['roomNickname'],'roomAvatar'=>$up['roomAvatar'],'orderSummaryDisplay'=>$up['orderSummaryDisplay']];
                        }
                    }
                    if($up['thisqishu'] != $kj_sig['qishu']){//更新期号
                        $db->update("update x_userpatt set upqishu=thisqishu,thisqishu='{$kj_sig['qishu']}' where userid='{$up['userid']}' and gid='$gid'");
                    }
                    //查询距封盘N秒喊话
                    if(($kj_sig['closetime']-$item['userclosetime']-$up['fpseconds']) > $time){
                        $flagkey = "secondsToCloseAnnouncement:".$up['userid'].':'.$kj_sig['qishu'];
                        if(!Cache::has($flagkey)){
                            $t = $kj_sig['closetime']-$item['userclosetime']-$up['fpseconds']-$time;
                            $gameMsg = Gamemsg::where(['ruid'=>$up['userid'],'gid'=>$gid,'keyname'=>'secondsToCloseAnnouncement','ifok'=>1])->where('msg_time','>=',$t)->select(['msg_content'])->first();
                            //Log::info("gid：$gid t：$t gamemsgcount：".(!empty($gameMsg) ? 1 : 0));
                            if(!empty($gameMsg)){
                                Cache::put($flagkey,1,$t+10);
                                $gameMsg['ruid'] = $up['userid'];
                                $gameMsg['fptime'] = $t;
                                $gameMsg['roomNickname'] = $up['roomNickname'];
                                $gameMsg['roomAvatar'] = $up['roomAvatar'];
                                $gameMsgArr1[] = $gameMsg;
                            }
                        }
                    }
                }
                //距封盘N秒喊话
                if(count($gameMsgArr1) > 0){
                    $param = [];
                    $param['type']  = 'secondsToCloseAnnouncement';
                    $param['gid'] = $gid;
                    $param['gname'] = $item['gname'];
                    $param['qishu'] = $kj_sig['qishu'];
                    $param['gameMsgArr'] = $gameMsgArr1;
                    //Task::deliver(new CommonQueue($param));
                    (new CommonQueue($param))->secondsToCloseAnnouncement($param);
                }
                //封盘后的消息任务
                if(count($gameMsgArr2) > 0){
                    $param = [];
                    $param['type']  = 'closingMessage';
                    $param['gid'] = $gid;
                    $param['gname'] = $item['gname'];
                    $param['qishu'] = $kj_sig['qishu'];
                    $param['gameMsgArr'] = $gameMsgArr2;
                    //Task::deliver(new CommonQueue($param));
                    (new CommonQueue($param))->closingMessage($param);
                }
                if($isfp == 1){
                    //Log::info('开始检查遗漏开奖数据:'.$gid);
                    AutosService::checkkj($gid);
                }
            }
            //自动降赔
            /*$auto = Cache::get('autoattpeilvs_'.$gid);
            if(!empty($auto) && !empty($kj_sig)){
                //删除
                Cache::delete('autoattpeilvs_'.$gid);
                if($isfp == 0){
                    AdminFunc::attpeilvs($gid,$kj_sig['qishu']);
                }
            }*/
        }
    }

    public static function attpeilvs(){
        $game = Game::where(['ifopen'=>1])->select(['gid','panstatus'])->get();
        foreach ($game as $item){
            if($item['panstatus'] == 1){
                AdminFunc::attpeilvs($item['gid']);
            }
        }
    }

    public static function create_kjdata($gid,$stopstatus = 0,$fdate = null){
        $iscreating = Cache::get('iscreating_kjdata_gid'.$gid);
        if(!empty($iscreating)){
            return;
        }
        //缓存
        Cache::put('iscreating_kjdata_gid'.$gid,1,10);
        $game = Game::where('gid',$gid)->select(['cs','thisbml'])->first();
        $cs = json_decode($game['cs'], true);
        $his = date("His");
        $pdstime = str_replace(':', '', $cs['starttime']);
        $pdetime = str_replace(':', '', $cs['starttime2']);
        if(empty($fdate)){
            if(($pdetime < $pdstime) && $his < $pdetime){
                $dates = date("Y-m-d", time() - 86400);
            }else{
                $dates = date("Y-m-d");
            }
        }else{
            $dates = $fdate;
        }
        $thisbml = $game['thisbml'];
        if ($gid == 131 || $gid == 444 || $gid == 162 || $gid == 109 || $gid == 108
            || $gid == 170 || $gid == 172 || $gid == 175 || $gid == 177 || $gid == 178 || $gid == 191 || $gid == 110
            || $gid == 121 || $gid == 253 || $gid == 255 || $gid == 516 || $gid == 517 || $gid == 518 || $gid == 519
            || $gid == 520 || $gid == 521 || $gid == 616) {//新版
            self::paddqishu($gid,$cs,$thisbml,$dates);
        }
    }


    /**
     * 生成开奖数据
     */
    public static function paddqishu($gid,$cs,$bml, $pdate = ''){
        Log::info("开奖数据生成=====" . $gid . "===" . $pdate . "===");
        $editstart = str_replace(':', '', x_config('editstart'));
        if ($pdate == '') {
            if (date("His") < $editstart) {
                $starttime = strtotime(date("Y-m-d", time() - 86400) . ' ' . $cs['starttime']);
            } else {
                $starttime = strtotime(date("Y-m-d") . ' ' . $cs['starttime']);
            }
        } else {
            $starttime = strtotime($pdate . ' ' . $cs['starttime']);
        }
        if ($gid == 131 || $gid == 444 || $gid == 170 || $gid == 172 || $gid == 175 || $gid == 109
            || $gid == 108 || $gid == 162 || $gid == 121 || $gid == 253 || $gid == 255) {
            $qishu = $cs['qishunum'] * (strtotime($pdate) - strtotime($cs['startdate'])) / 3600 / 24 + $cs['startqs'] - $cs['tzqs'];
            $starttime = $pdate . " " . $cs['starttime'];
            $dates = $pdate;
            $starttime = strtotime($starttime);
            for ($i = 1; $i <= $cs['qsnums']; $i++) {
                $opentime = $starttime;
                $kjtime = $opentime + $cs['qsjg'] * 60;
                $closetime = $kjtime - $cs['closetime'];
                //$his = date("His", $opentime);
                $kj_count = Kj::where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                if($kj_count <= 0){
                    Kj::create(['kjtime'=>$kjtime + $cs['tuichi'],'opentime'=>$opentime + $cs['tuichikp'],'closetime'=>$closetime,'qishu'=>$qishu,'dates'=>strtotime($dates),'bml'=>$bml,'gid'=>$gid,'baostatus'=>1]);
                }
                $qishu++;
                $starttime = $kjtime;
            }
        }else if ($gid == 177 || $gid == 310 || $gid == 178) {//SG彩
            $starttime = strtotime($pdate . ' 00:00:00');
            $kjtime = $starttime;
            $ddd = strtotime($pdate);
            for ($i = 1; $i <= $cs['qsnums']; $i++) {
                if ($i == 1) {
                    $starttime = strtotime('+1 day',$starttime);
                    $starttime = strtotime(date("Y-m-d", $starttime) . ' 00:05:00');
                    $kjtime = $starttime;
                }
                if ($i == 73) {
                    $starttime = strtotime('-1 day',$starttime);
                    $starttime = strtotime(date("Y-m-d", $starttime) . ' 07:00:00');
                    $kjtime = $starttime;
                }
                if($i >= 73){
                    $k = $i+12;
                }else{
                    $k = $i;
                }
                if ($k < 10) {
                    $j = '00' . $k;
                } else if ($k < 100) {
                    $j = '0' . $k;
                } else {
                    $j = $k;
                }
                $opentime = $kjtime;
                if($i > 1){
                    $kjtime = $opentime + $cs['qsjg'] * 60;
                }else{
                    $kjtime = $opentime;
                }
                $closetime = $kjtime - $cs['closetime'];
                $qishu = date("Ymd", $starttime) . $j;
                $kj_count = Kj::where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($pdate)])->count('id');
                if($kj_count <= 0){
                    Kj::create(['kjtime'=>$kjtime + $cs['tuichi'],'opentime'=>$opentime + $cs['tuichikp'],'closetime'=>$closetime,'qishu'=>$qishu,'dates'=>$ddd,'bml'=>$bml,'gid'=>$gid,'baostatus'=>1]);
                }
            }
        } else if ($gid == 516 || $gid == 517 || $gid == 518 || $gid == 519 || $gid == 520 || $gid == 521) {//哈希系列
            $starttime = strtotime($pdate . ' 00:00:00');
            $kjtime = $starttime;
            $ddd = strtotime($pdate);
            for ($i = 1; $i <= $cs['qsnums']; $i++) {
                if ($i == 1) {
                    if($gid == 516 || $gid == 519){
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 23:59:57');
                    }elseif ($gid == 517 || $gid == 520){
                        $starttime = strtotime('+1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 00:00:09');
                    }elseif ($gid == 518 || $gid == 521){
                        $starttime = strtotime('+1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 00:00:18');
                    }
                    $kjtime = $starttime;
                }
                if ($i == 241 && ($gid == 516 || $gid == 519)) {
                    $starttime = strtotime($pdate . ' 07:29:57');
                    $kjtime = $starttime;
                }
                if ($i == 81 && ($gid == 517 || $gid == 520)) {
                    $starttime = strtotime($pdate . ' 07:30:09');
                    $kjtime = $starttime;
                }
                if ($i == 49 && ($gid == 518 || $gid == 521)) {
                    $starttime = strtotime($pdate . ' 07:30:18');
                    $kjtime = $starttime;
                }
                if($i > 240 && ($gid == 516 || $gid == 519)){
                    $k = $i+210;
                }elseif($i > 80 && ($gid == 517 || $gid == 520)){
                    $k = $i+70;
                }elseif($i > 48 && ($gid == 518 || $gid == 521)){
                    $k = $i+42;
                }else{
                    $k = $i;
                }
                if ($k < 10) {
                    $j = '000' . $k;
                } else if ($k < 100) {
                    $j = '00' . $k;
                } else if ($k < 1000) {
                    $j = '0' . $k;
                } else {
                    $j = $k;
                }
                $opentime = $kjtime;
                $kjtime = $opentime + $cs['qsjg'] * 60;
                $closetime = $kjtime - $cs['closetime'];
                $qishu = date("Ymd", $closetime) . $j;
                $kj_count = Kj::where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($pdate)])->count('id');
                if($kj_count <= 0){
                    Kj::create(['kjtime'=>$kjtime + $cs['tuichi'],'opentime'=>$opentime + $cs['tuichikp'],'closetime'=>$closetime,'qishu'=>$qishu,'dates'=>$ddd,'bml'=>$bml,'gid'=>$gid,'baostatus'=>1]);
                }
            }
        } else if ($gid == 110) {//幸运时时彩
            $starttime = strtotime($pdate . ' 00:00:00');
            $kjtime = $starttime;
            $cs['qsnums'] = 120;
            $cs['qsjg'] = 5;
            $ddd = strtotime($pdate);
            for ($i = 1; $i <= $cs['qsnums']; $i++) {
                if ($i == 1) {
                    $starttime = strtotime('+1 day',$starttime);
                    $starttime = strtotime(date("Y-m-d", $starttime) . ' 00:00:00');
                    $kjtime = $starttime;
                    $cs['qsjg'] = 5;
                }
                if ($i == 24) {
                    $starttime = strtotime('-1 day',$starttime);
                    $starttime = strtotime(date("Y-m-d", $starttime) . ' 09:50:00');
                    $kjtime = $starttime;
                    $cs['qsjg'] = 10;
                }
                if ($i == 97) {
                    $starttime = strtotime(date("Y-m-d", $starttime) . ' 22:00:00');
                    $kjtime = $starttime;
                    $cs['qsjg'] = 5;
                }
                if ($gid == 101) {
                    $k = $i + 9;
                } else if ($gid == 135) {
                    $k = $i + 9;
                } else if ($gid == 229) {
                    $k = $i + 23;
                } else if ($gid == 177) {
                    $k = $i + abs($cs["tzqs"]);
                } else {
                    $k = $i;
                }

                if ($k < 10) {
                    $j = '00' . $k;
                } else if ($k < 100) {
                    $j = '0' . $k;
                } else {
                    $j = $k;
                }
                if ($gid == 229 & ($j <= 23 | $j >= 97)) {
                    $cs['qsjg'] = $cs['qsjg2'];

                }
                $opentime = $kjtime;
                if ($gid == 101 && $k == 1) {
                    $opentime = $opentime + $cs['qsjg2'] * 60;
                }
                if ($gid == 135 && $k == 1) {
                    $opentime = $opentime + $cs['qsjg2'] * 60;
                }
                $kjtime = $opentime + $cs['qsjg'] * 60;
                $closetime = $kjtime - $cs['closetime'];
                if ($gid == 101 || $gid == 229) {
                    $qishu = date("Ymd", $opentime) . $j;
                } else if ($gid == 135) {
                    $qishu = date("Ymd", $kjtime) . $j;
                } else if ($gid == 177) {
                    $qishu = date("Ymd", $opentime) . $j;
                } else {
                    $qishu = date("Ymd", $starttime) . $j;
                }
                $kj_count = Kj::where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($pdate)])->count('id');
                if($kj_count <= 0){
                    Kj::create(['kjtime'=>$kjtime + $cs['tuichi'],'opentime'=>$opentime + $cs['tuichikp'],'closetime'=>$closetime,'qishu'=>$qishu,'dates'=>$ddd,'bml'=>$bml,'gid'=>$gid,'baostatus'=>1]);
                }
            }
        }else if ($gid == 616) {//波场时时彩
            $starttime = strtotime($pdate . ' 07:00:00');
            $kjtime = $starttime;
            $cs['qsnums'] = 690;
            $cs['qsjg'] = 2;
            $ddd = strtotime($pdate);
            for ($i = 1; $i <= $cs['qsnums']; $i++) {
                if($i <= 510){
                    $k = $i + 210;
                }else{
                    $k = $i - 510;
                }
                if ($k < 10) {
                    $j = '00' . $k;
                } else if ($k < 100) {
                    $j = '0' . $k;
                } else {
                    $j = $k;
                }
                $opentime = $kjtime;
                $kjtime = $opentime + $cs['qsjg'] * 60;
                $closetime = $kjtime - $cs['closetime'];
                $qishu = date("Ymd", $opentime) . $j;
                $kj_count = Kj::where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($pdate)])->count('id');
                if($kj_count <= 0){
                    Kj::create(['kjtime'=>$kjtime + $cs['tuichi'],'opentime'=>$opentime + $cs['tuichikp'],'closetime'=>$closetime,'qishu'=>$qishu,'dates'=>$ddd,'bml'=>$bml,'gid'=>$gid,'baostatus'=>1]);
                }
            }
        } else {
            $kjtime = $starttime;
            for ($i = 1; $i <= $cs['qsnums']; $i++) {
                if ($gid == 101) {
                    $k = $i + 9;
                } else if ($gid == 135) {
                    $k = $i + 9;
                } else if ($gid == 229) {
                    $k = $i + 23;
                } else if ($gid == 177) {
                    $k = $i + abs($cs["tzqs"]);
                } else {
                    $k = $i;
                }
                if ($gid == 229 & $k > 120) {
                    $k -= 120;
                }
                if ($gid == 101 & $k > 59) {
                    $k -= 59;
                }
                if ($gid == 135 & $k > 59) {
                    $k -= 59;
                }
                if ($gid == 177 & $k > 288) {
                    $k -= 288;
                }

                if ($k < 10) {
                    $j = '00' . $k;
                } else if ($k < 100) {
                    $j = '0' . $k;
                } else {
                    $j = $k;
                }
                if ($gid == 229 & ($j <= 23 | $j >= 97)) {
                    $cs['qsjg'] = $cs['qsjg2'];

                }
                $opentime = $kjtime;
                if ($gid == 101 && $k == 1) {
                    $opentime = $opentime + $cs['qsjg2'] * 60;
                }
                if ($gid == 135 && $k == 1) {
                    $opentime = $opentime + $cs['qsjg2'] * 60;
                }
                $kjtime = $opentime + $cs['qsjg'] * 60;
                $closetime = $kjtime - $cs['closetime'];
                if ($gid == 101 || $gid == 229) {
                    $qishu = date("Ymd", $opentime) . $j;
                } else if ($gid == 135) {
                    $qishu = date("Ymd", $kjtime) . $j;
                } else if ($gid == 177) {
                    $qishu = date("Ymd", $opentime) . $j;
                } else {
                    $qishu = date("Ymd", $starttime) . $j;
                }
                $kj_count = Kj::where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($pdate)])->count('id');
                if($kj_count <= 0){
                    Kj::create(['kjtime'=>$kjtime + $cs['tuichi'],'opentime'=>$opentime + $cs['tuichikp'],'closetime'=>$closetime,'qishu'=>$qishu,'dates'=>strtotime($pdate),'bml'=>$bml,'gid'=>$gid,'baostatus'=>1]);
                }
            }
        }
    }


    /**
     * 检测ip，将ip转成详细地址
     */
    public static function ip_to_address(){
        $ips = new Iplocationp();
        $time = time()-3600;
        $rs = UserEdit::where('moditime','>',$time)->where('addr','')->select(['modiip','id'])->get();
        foreach ($rs as $key => $val) {
            $addr = mb_convert_encoding($ips->getaddress($val['modiip']), 'utf-8', 'GBK');
            $id = $val['id'];
            UserEdit::update(['addr'=>$addr],['id'=>$id]);
        }
        $time = time() - 3600;
        $rs = UserLogin::where('time','>',$time)->where('addr','')->select(['ip','id'])->get();
        foreach ($rs as $key => $val) {
            $addr = mb_convert_encoding($ips->getaddress($val['ip']), 'utf-8', 'GBK');
            $id = $val['id'];
            UserLogin::where(['id'=>$id])->update(['addr'=>$addr]);
        }
    }

    public static function create_today_table(){
        $db = Db::connection();
        $date = ComFunc::getthisdate();
        $date1 = str_replace('-','',$date);
        $tb = "x_lib_".$date1;
        $datt = $db->select("SHOW TABLES LIKE  '$tb'");
        if(empty($datt)){
            $db->insert("create table if not exists `$tb` like x_lib");
        }
        //再多生成一天的表
        $date = date("Ymd",strtotime($date)+86400);
        $tb = "x_lib_".$date;
        $datt = $db->select("SHOW TABLES LIKE  '$tb'");
        if(empty($datt)){
            $db->insert("create table if not exists `$tb` like x_lib");
        }
    }

    //创建飞单记录表
    public static function create_today_tablef(){
        $db = Db::connection();
        $date = ComFunc::getthisdate();
        $date1 = str_replace('-','',$date);
        $tb = "x_libfly_".$date1;
        $datt = $db->select("SHOW TABLES LIKE  '$tb'");
        if(empty($datt)){
            $db->insert("create table if not exists `$tb` like x_libfly");
        }
        //再多生成一天的表
        $date = date("Ymd",strtotime($date)+86400);
        $tb = "x_libfly_".$date;
        $datt = $db->select("SHOW TABLES LIKE  '$tb'");
        if(empty($datt)){
            $db->insert("create table if not exists `$tb` like x_libfly");
        }
    }

    public static function cleardata($opdate = ''){
        $key = "daycleardata";
        $ks = Cache::get($key);
        if(!empty($ks)){
            Log::info("清理数据正在执行中...");
            return;
        }
        Cache::put($key,1,300);
        $starttime = time();
        $db = Db::connection();

        //清理两天的自动中奖日志
        $tt = time()-(2 * 3600 * 24);
        //$db->delete("delete from x_autozjlog where time < '{$tt}'");

        //清理登录日志
        $autodellogintime = x_config('autodellogintime');
        if ($autodellogintime && $autodellogintime > 0) {//自动删除登录日志
            $dtime = time() - $autodellogintime * 3600 * 24;
            $db->delete("delete from x_user_login where time<'$dtime'");
        }

        //清理操作记录
        $autodeledittime = x_config('autodeledittime');
        if ($autodeledittime && $autodeledittime > 0) {//删除多少天的修改记录、资金变动记录
            $dtime = time() - $autodeledittime * 3600 * 24;
            $db->delete("delete from x_user_edit where moditime<'$dtime'");
            $db->delete("delete from x_money_log where time<'$dtime'");
            $db->delete("delete from x_link where create_time<'$dtime'");
            $db->delete("delete from x_apply where applicationTime<'$dtime'");
        }

        //清理聊天记录
        $autodelchsgtime = x_config('autodelchsgtime');
        if ($autodelchsgtime && $autodelchsgtime > 0) {//删除多少天的聊天记录
            $dtime = time() - $autodelchsgtime * 3600 * 24;
            $db->delete("delete from x_chatmsg where time<'$dtime'");
        }
        
        //删除其他日志
        $autodelothertime = x_config('autodelothertime');
        if($autodelothertime && $autodelothertime > 0) {//其他日志时间
            $time = time() - 86400 * $autodelothertime;
            $dates = strtotime(date('Y-m-d', $time));
            //$db->delete("delete from x_lib_err where dates<'$dates'");//改单日志
            $db->delete("delete from x_kj where dates<'$dates'");//开奖表
            $db->delete("delete from x_outbet_error where create_time<'$time'");//对外补货失败记录表
            $db->delete("delete from x_baototal where dates<'$dates'");//报表统计表
            //清理注单表
            $arr = $db->select("SHOW TABLES LIKE '%\\_lib_20%'");
            $ffdata = date('Ymd', $time);
            foreach ($arr as $v) {
                $tb = array_values($v)[0];
                $tbdate = str_replace('x_lib_', '', $tb);
                //如果当前表日期小于指定日期则删除
                if ($tbdate < $ffdata) {
                    $db->delete("drop table $tb");
                }
            }
            //清理飞单表
            $arr = $db->select("SHOW TABLES LIKE '%\\_libfly_20%'");
            foreach ($arr as $v) {
                $tb = array_values($v)[0];
                $tbdate = str_replace('x_libfly_', '', $tb);
                //如果当前表日期小于指定日期则删除
                if ($tbdate < $ffdata) {
                    $db->delete("drop table $tb");
                }
            }
        }

        //删除开奖图片
        AutosService::deleteOpenImg($autodelchsgtime);

        //如果是周日
        /*if (date('w') == 0) {//优化表结构
            //优化所有表结构
            $arr = $db->select("SHOW TABLES LIKE '%\\_%'");
            foreach ($arr as $v) {
                $tb = array_values($v)[0];
                //不能包含lib_
                if (strpos($tb, 'lib_') !== false) {
                    $db->update("OPTIMIZE TABLE $tb");
                }
            }
        }*/
        //清空表
        $endtime = time();
        if(empty($opdate)){
            $opdate = ComFunc::getthisdateend();
        }
        ComFunc::adduseredit(['userid'=>Constants::$SUID,'ip'=>'127.0.0.1','other'=>strtotime($opdate),'mduserid'=>Constants::$SUID,'sonuid'=>'','action'=>"清理数据",'old'=>'-','new'=>($endtime-$starttime),'moduleKey'=>'stystem','functionKey'=>'task','actionKey'=>'cleardata']);
        Cache::delete($key);
    }

    /**
     * 删除历史开奖图片
     * @return void
     */
    public static function deleteOpenImg($autodelchsgtime = 2){
        //获取该目录下所有目录，如果目录小于当前日期-2天则删除
        $rootdir = public_path('upload/openimg');
        $dirs = File::directories($rootdir);
        foreach ($dirs as $dir){
            $dirName = basename($dir);
            if($dirName < date('Ymd',strtotime("-{$autodelchsgtime} day"))){
                $fullDir = public_path('upload/openimg/'.$dirName);
                File::deleteDirectory($fullDir);
            }
        }
    }

    public static function checkreport($gid){
        $cachekey = "checkreport_".$gid;
        if(!empty(Cache::get($cachekey))){
            Log::info('检测报表-正在执行中-'.$gid);
            return false;
        }
        //缓存
        Cache::put($cachekey,1,30);
        $db = Db::connection();
        $date = ComFunc::getthisdateend();
        $dates = strtotime($date);$tb = SGUtils::getcuretable(true);
        $ulist = $db->select("SELECT SUM(count) as count,userid FROM x_baototal WHERE dates = {$dates} and gid = {$gid} GROUP BY userid");
        foreach ($ulist as $item){
            $count = isset($item['count']) ? $item['count'] : 0;
            $userid = isset($item['userid']) ? $item['userid'] : 0;
            $rs = $db->select("SELECT count(id) as count FROM {$tb} WHERE userid = {$userid} and gid = {$gid} and z BETWEEN 0 AND 2;");
            $order_count = isset($rs[0]['count']) ? $rs[0]['count'] : 0;
            if($count > 0 && $order_count <= 0){
                //删除报表
                Log::info('检测报表-删除报表-'.$userid.'-'.$gid.'-'.$count.'-'.$order_count);
                $db->delete("delete from x_baototal where userid = {$userid} and gid = {$gid} and dates = {$dates}");
            }else{
                if($count != $order_count){//对不上
                    Log::info('整合用户报表对不上-'.$userid.'-'.$gid.'-'.$count.'-'.$order_count);
                    ReportService::zhengli_day_report('',$gid,$userid);
                    AdminFunc::jiaozhengedu(true,$userid);
                }
            }
        }
        //删除缓存
        Cache::delete($cachekey);
    }

    //检测遗漏开奖
    public static function checkkj($gid){
        $cachekey = "checkkj_".$gid;
        if(!empty(Cache::get($cachekey))){
            Log::info('检测遗漏开奖-正在执行中-'.$gid);
            return false;
        }
        //缓存
        Cache::put($cachekey,1,60);
        $date = ComFunc::getthisdateend();
        $dates = strtotime($date);
        $kjdate = $date;
        //判断当前时间是否小于06:59:15
        $his = date("His");
        $datearr = [];$endtime = str_replace(':', '', x_config('editend'));
        $chis = date("H:i:s",time()-400);
        $tmphist = str_replace(':', '',$chis);
        if($his < $endtime){
            $kjdate = date("Y-m-d");
            $wkjcount = Kj::where(['gid'=>$gid,'dates'=>$dates,'status'=>0])->where('kjtime','<=',strtotime($kjdate.' 00:00:00'))->count('id');
            if($wkjcount > 0){
                //取昨天
                $datearr[] = $date;
            }
            if($tmphist > $endtime){
                $kjdate = $date;
            }
            $wkjcount = Kj::where(['gid'=>$gid,'dates'=>$dates,'status'=>0])->where('kjtime','<=',strtotime($kjdate.' '.$chis))->count('id');
            if($wkjcount > 0){
                $datearr[] = $kjdate;
            }
        }else{
            $wkjcount = Kj::where(['gid'=>$gid,'dates'=>$dates,'status'=>0])->where('kjtime','<=',strtotime($kjdate.' '.$chis))->count('id');
            if($wkjcount > 0){
                $datearr[] = $kjdate;
            }
        }
        foreach ($datearr as $d){
            //补开奖数据
            Log::info('补开奖数据-'.$gid.'-'.$wkjcount.'-'.$d);
            AutoKjsService::loadhistorykjdata($d,$gid,false,'',1);
        }
        //检测是否有已开奖未结算数据
        /*$wjskjlist = Kj::where(['gid'=>$gid,'dates'=>$dates,'status'=>1,'js'=>0])->select(['qishu'])->get();
        if(count($wjskjlist) > 0){
            $game = Game::where(['gid'=>$gid])->select(['fenlei','cs','mtype','ztype','mnum'])->first();
            //结算
            foreach ($wjskjlist as $item){
                Log::info('补结算数据-'.$gid.'-'.$item['qishu']);
                $qishu = $item['qishu'];
                $mtype = json_decode($game['mtype'], true);
                $ztype = json_decode($game['ztype'], true);
                $cs = json_decode($game['cs'], true);
                CsFunc::calc($game['fenlei'],$gid, $cs,$qishu, $game['mnum'], $ztype, $mtype);
            }
        }*/
        //删除缓存
        Cache::delete($cachekey);
    }


    /**
     * 现金会员额度转正
     */
    public static function edu_zhuanhuan($dates = ''){
        $key = "edu_zhuanhuan";
        $ks = Cache::get($key);
        if(!empty($ks)){
            Log::info("额度矫正正在执行中...");
            return;
        }
        Cache::put($key,1,300);
        $starttime = time();
        $db = Db::connection();
        if (empty($dates)) {
            $ftime = date("Y-m-d");
            $upftime = date("Y-m-d", time()-86400);
            $thisdate = ComFunc::getthisdateend();
        } else {
            $ftime = date("Y-m-d");
            $upftime = $dates;
            $thisdate = $dates;
        }
        $ftime = strtotime($ftime);
        $upftime = strtotime($upftime);
        $db->update("update x_user set sy=0,jetotal=0,kmaxmoney=kmoney");
        $endtime = time();
        ComFunc::adduseredit(['userid'=>Constants::$SUID,'ip'=>'127.0.0.1','other'=>strtotime($thisdate),'mduserid'=>Constants::$SUID,'sonuid'=>'','action'=>"额度矫正",'old'=>'-','new'=>($endtime-$starttime),'moduleKey'=>'stystem','functionKey'=>'task','actionKey'=>'cashuseredu']);
        Cache::delete($key);
    }

    /**
     * 代理退水结算
     */
    public static function backwaterCompete($dates = ''){
        $key = "backwater";
        $ks = Cache::get($key);
        if(!empty($ks)){
            Log::info("回水结算在执行中...");
            return;
        }
        Cache::put($key,1,300);
        $starttime = time();
        $db = Db::connection();
        if (empty($dates)) {
            $ftime = date("Y-m-d").' '.x_config('editend');
            $upftime = date("Y-m-d", time()-86400).' '.x_config('editend');
            $thisdate = ComFunc::getthisdateend();
        } else {
            $ftime = $dates.' '.x_config('editend');
            $upftime = date("Y-m-d", strtotime($dates)-86400).' '.x_config('editend');
            $thisdate = $dates;
        }
        $ftime = strtotime($ftime);
        $upftime = strtotime($upftime);


        $endtime = time();
        Log::info("结束回水结算-耗时".($endtime-$starttime));
        //添加日志记录
        ComFunc::adduseredit(['userid'=>Constants::$SUID,'ip'=>'127.0.0.1','other'=>strtotime($thisdate),'mduserid'=>Constants::$SUID,'sonuid'=>'','action'=>"回水结算",'old'=>'-','new'=>($endtime-$starttime),'moduleKey'=>'stystem','functionKey'=>'task','actionKey'=>'backwater']);
        Cache::delete($key);
    }
}
