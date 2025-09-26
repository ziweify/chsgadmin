<?php

namespace App\ort\sgwin;

use App\Models\Game\Fly;
use App\Models\Game\Game;
use App\Models\Game\Gamezc;
use App\Models\Game\Kj;
use App\Models\Game\Lib;
use App\Models\Game\Play;
use App\Models\Game\PlayUser;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

//新的自动补货
class NewAutoFlys
{
    public function autoFlys($userid,$gid,$qishu,$list){
        $flyflag = x_config('flyflag');
        if($flyflag == 0){//自动补货未开放
            return;
        }
        $fids = ComFunc::getfid($userid);
        $zcmode = x_config('zcmode');
        $syspcl = x_config('plc');
        $db = Db::connection();
        $game = Game::where('gid',$gid)->select(['ifopen','gid','panstatus','thisqishu','pan','fast','userclosetime','patt1'])->first();
        //$dftypearr = json_decode($game['dftype'], true);
        $pan = json_decode($game['pan'], true);
        $fast = $game['fast'];
        //$time  = time();
        $kj = Kj::where(['gid'=>$gid,'qishu'=>$qishu])->select(['closetime','dates','status'])->first();
        if($kj['status'] == 1){
            Log::log('autoFlys','开奖已完成'.$userid.'-'.$gid.'-'.$qishu);
            return;
        }
        /*if (($kj['closetime']-$game['userclosetime']) < $time) {//已封盘
            return;
        }*/
        $libmode = SGUtils::getcuremodel();$orders = [];
        foreach ($fids as $fid){
            $flytype = Gamezc::where(['typeid'=>$fast,'userid'=>$fid])->value('flytype');
            if($flytype != 1){//未开放自动补货
                continue;
            }
            $user = User::where('userid',$fid)->select(['userid','layer','defaultpan','pself','fid1','wid','zcobj','backmode'])->first();
            $fid1 = $fid;
            $table = SGUtils::getcuretable(true);
            $backmode = $user['backmode'];$abcd = strtoupper($user['defaultpan']);
            $pself = $user['pself'];$zcobj = $user['zcobj'];
            if($user['layer'] > 1){
                $puser = User::where('userid',$user['fid1'])->select(['pself','zcobj','layer','userid','backmode'])->first();
                $pself = $puser['pself'];
                $zcobj = $puser['zcobj'];
                $fid1 = $puser['userid'];
                $backmode = $puser['backmode'];
            }
            if($pself == 1){
                $patt = Userpatt::where(['userid'=>$fid1,'gid'=>$game['gid']])->value('patt1');
                $patt = json_decode($patt, true);
            }else{
                $patt = json_decode($game['patt1'], true);
            }
            $u = ComFunc::getfid($fid);
            $zc = ComFunc::getzcnew_sg($fid, $u, $user['layer'], $gid, $zcmode,$fast,$zcobj,1,$backmode,$user['fid1']);
            $czc = count($zc) - 1;
            //$list = $db->select("select bid,sid,cid,pid,content,bz,ab,dftype from $table where gid='$gid' and qishu='$qishu' and uid{$user['layer']}='{$user['userid']}' and xtype!=2 and zc{$user['layer']}>0  group by pid");
            $cptype = -1;
            foreach($list as $lib) {
                $dftype = $lib['dftype'];
                /*if($dftypearr[$dftype]=='两面' || $dftypearr[$dftype]=='1-5双面' || $dftypearr[$dftype]=='1-10名双面' || $dftypearr[$dftype]=='总和两面'){
                    $pidf = Play::where(['gid'=>$gid,'cid'=>$lib['cid']])->where('pid','<>',$lib['pid'])->value('pid');
                }*/
                $abcd = $lib['abcd'];
                $playpp = Play::where(['gid'=>$gid,'pid'=>$lib['pid']])->select(['peilv1','peilv2','ifok','name','ptype','ztype','cy','pid'])->first();
                $ptype = $playpp['ptype'];
                $peilv1 = $playpp['peilv1'];
                if ($pself == 1) {
                    $peilv1s = PlayUser::where(['userid'=>$fid1,'gid'=>$gid,'pid'=>$playpp['pid']])->value('peilv1');
                }
                //$maxje = 0;
                if($cptype != $ptype){
                    $flyitem = Fly::where(['gid'=>$gid,'class'=>$dftype,'userid'=>$fid])->select(['je','ifok'])->first();
                    if(empty($flyitem) || $flyitem['ifok'] == 0){
                        continue;
                    }
                    $maxje = $flyitem['je'];
                    $abcdcha = 0;
                    $tmpabcd = 0;
                    if ($pan[$dftype]['abcd'] == 1) {
                        if ($abcd != 'A') {
                            $abcdcha = $patt[$ptype][strtolower($abcd)];
                        }
                        $tmpabcd = $abcd;
                    }
                    $order = [];
                    $points = ComFunc::getpoints8($dftype, $tmpabcd, 0, $fid, $gid);
                    $order['points'] = $points;
                    $tmppeilvcha = 0;
                    for ($j = 0; $j < $czc; $j++) {
                        $order['zc'.$j] = $zc[$j]['zc'];
                        if ($j > 0) {
                            if($syspcl == 1){
                                $arr = ComFunc::getzcs8($dftype, $u[$j], $gid);
                                $tmppeilvcha += $arr['peilvcha'];
                                $lowpeilv[$j] = $arr['lowpeilv'];
                            }else{
                                $lowpeilv[$j] = 0;
                            }
                            $peilvcha[$j] = $tmppeilvcha + $abcdcha - 0;
                            $points       = ComFunc::getpoints8($dftype, $tmpabcd, 0, $u[$j], $gid);
                            $order['points'.$j] = $points;
                            $order['uid'.$j] = $u[$j];
                            if ($j == 1 && $pself == 1) {
                                $tmppeilvcha = 0;
                            }
                        }
                    }
                    if($syspcl == 1){
                        $arr = ComFunc::getzcs8($dftype, $fid, $gid);
                        $tmppeilvcha += $arr['peilvcha'];
                        $peilvchax = $tmppeilvcha + $abcdcha - 0;
                        $lowpeilvx = $arr['lowpeilv'];
                    }else{
                        $peilvchax = $tmppeilvcha + $abcdcha - 0;
                        $lowpeilvx = 0;
                    }
                }
                $cptype = $ptype;
                if($maxje > 0){
                    $rs = $db->select("select sum(je*zc{$user['layer']}/100) as ra from $table where gid='$gid' and uid{$user['layer']}='{$user['userid']}' and qishu='$qishu' and zc{$user['layer']}>0 and pid='{$playpp['pid']}'");
                    $zcje = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
                    $rs = $db->select("select sum(je) as ra from $table where gid='$gid' and userid='{$user['userid']}' and  qishu='$qishu' and  pid='{$playpp['pid']}'");
                    $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
                    $yfje = ComFunc::pr2($ra);
                    $je   = $zcje - $maxje - $yfje;
                }else{
                    $je = $lib['je']*$lib['zc'.$user['layer']]/100;
                }
                if ($je <= 0) {
                    continue;
                }
                if ($user['layer'] > 1 && $pself == 1) {
                    $tmppeilv = ComFunc::moren($peilv1s - $peilvchax, $lowpeilvx);
                }else {
                    $tmppeilv = ComFunc::moren($peilv1 - $peilvchax, $lowpeilvx);
                }
                $order['xtype'] = 1;
                $order['cy'] = $playpp['cy'];
                $order['dftype'] = $dftype;
                $order['dates'] = strtotime(date("Y-m-d",$kj['dates']));
                $order['gid'] = $gid;
                $order['qishu'] = $qishu;
                $order['userid'] = $fid;
                $order['bid'] = $lib['bid'];
                $order['sid'] = $lib['sid'];
                $order['cid'] = $lib['cid'];
                $order['pid'] = $lib['pid'];
                $order['abcd'] = strtoupper($abcd);
                $order['ab'] = 'A';
                $order['time'] = time();
                $order['je'] = $je;
                $order['z'] = 9;
                $order['bs'] = 1;
                $order['peilv1'] = $tmppeilv;
                $order['sv'] = '0';
                $order['ip'] = $userid;
                $order['code'] = ComFunc::getNewOrderId(date("YmdH"));
                $order['kk'] = 1;
                $order['content'] = $lib['content'];
                $order['flytype'] = 2;
                $order['bz'] = $lib['bz'];
                for ($j = 1; $j < $czc; $j++) {
                    if ($pself == 1 && $j > 1) {
                        $order['peilv1'.$j] = ComFunc::moren($peilv1s - $peilvcha[$j] , $lowpeilv[$j]);
                    } else {
                        $order['peilv1'.$j] = ComFunc::moren($peilv1 - $peilvcha[$j] , $lowpeilv[$j]);
                    }
                }
                //$libmode->create($order);
                $orders[$fid][] = $order;
                $libmode->insert($order);
                //$orderstr = json_encode($order);
                //$db->insert("insert into x_log set ip='{$order['ip']}',userid='$fid',gid='$gid',time='$time',type='flys',content='{$orderstr}'");
            }
        }
        /*if(count($orders) > 0) {
            $libmode->insert($orders);
        }*/
        foreach ($orders as $fid=>$order) {
            //$libmode->insert($order);
            if($fid != Constants::$SUID){
                $this->autoFlys($fid,$gid,$qishu,$order);
            }
        }
    }
}
