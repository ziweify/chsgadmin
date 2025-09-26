<?php

namespace App\ort\sgwin;

use App\Common\Queue\AutoFlysQueue;
use App\Models\Game\Game;
use App\Models\Game\Gamecs;
use App\Models\Game\Gamezc;
use App\Models\Game\Kj;
use App\Models\Game\Mclass;
use App\Models\Game\Play;
use App\Models\Game\PlayUser;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\Zpan;
use App\ort\common\ComFunc;
use App\ort\common\JsFunc;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Illuminate\Support\Facades\delete;

class HtService
{
    public static function getopendatadata($kjlist,$game){
        $list = [];
        foreach ($kjlist as $key=>$kj){
            $list[$key]['drawNumber'] = $kj['qishu'];
            $list[$key]['drawTime'] = date('Y-m-d H:i:s',$kj['kjtime']);
            $ma = [];
            $total = 0;
            for ($i = 1; $i <= $game['mnum']; $i++) {
                $m = intval($kj['m' . $i]);
                if($game['fenlei'] == 121 || $game['fenlei'] == 103 || $game['fenlei'] == 161){
                    $m = $m < 10 ? '0'.$m : $m;
                }
                $total += $m;
                $ma[] = $m;
            }
            $list[$key]['result'] = $ma;
            if($game['fenlei'] == 107){//pk10
                //1-5龙虎
                for($i = 1;$i <= 5;$i++){
                    $lh = JsFunc::longhuhe($kj['m'.$i],$kj['m'.(11-$i)],1);
                    $lh1 = JsFunc::longhuhe($kj['m'.$i],$kj['m'.(11-$i)],3);
                    $list[$key]["LH".$i] = [$lh,$lh1];
                }
                //冠亚大小
                $gydx = JsFunc::zhdx($game['fenlei'],($kj['m1']+$kj['m2']),1);
                $gydx1 = JsFunc::zhdx($game['fenlei'],($kj['m1']+$kj['m2']),3);
                $list[$key]["GDX"] = [$gydx,$gydx1];
                //冠亚单双
                $gyds = JsFunc::ds($game['fenlei'],($kj['m1']+$kj['m2']),1);
                $gyds1 = JsFunc::ds($game['fenlei'],($kj['m1']+$kj['m2']),3);
                $list[$key]["GDS"] = [$gyds,$gyds1];
                //冠亚和
                $gyh = $kj['m1']+$kj['m2'];
                $list[$key]["GYH"] = $gyh;
                for($i = 1;$i <= $game['mnum'];$i++){
                    //大小
                    $dx = JsFunc::dx($game['fenlei'],$kj['m'.$i],3);
                    $list[$key]["DX}".$i] = $dx;
                    //单双
                    $ds = JsFunc::ds($game['fenlei'],$kj['m'.$i],3);
                    $list[$key]["DS".$i] = $ds;
                    //号码
                    $hm = intval($kj['m'.$i]);
                    $list[$key]["B".$i] = $hm;
                }
            }elseif ($game['fenlei'] == 101){//时时彩系列
                //总和
                $list[$key]["ZH"] = $total;
                //总和大小
                $zdx = JsFunc::zhdx($game['fenlei'],$total,1);
                $zdx1 = JsFunc::zhdx($game['fenlei'],$total,3);
                $list[$key]["ZDX"] = [$zdx,$zdx1];
                //总和单双
                $zds = JsFunc::ds($game['fenlei'],$total,1);
                $zds1 = JsFunc::ds($game['fenlei'],$total,3);
                $list[$key]["ZDS"] = [$zds,$zds1];
                //龙虎
                $lh = JsFunc::longhuhe($kj['m1'],$kj['m5'],1);
                $lh1 = JsFunc::longhuhe($kj['m1'],$kj['m5'],3);
                $list[$key]["LH"] = [$lh,$lh1];
                //斗牛
                $dn = JsFunc::niuniu($ma);
                $ddn = JsFunc::niuniures($dn,1);
                $ddn1 = JsFunc::niuniures($dn,3);
                $list[$key]["DN"] = [$ddn,$ddn1];
                //斗牛大小
                $dndx = JsFunc::dndx($dn[0],$dn[2],1);
                $dndx1 = JsFunc::dndx($dn[0],$dn[2],3);
                $list[$key]["DNDX"] = [$dndx,$dndx1];
                //斗牛单双
                $dnds = JsFunc::dnds($dn[0],$dn[2],1);
                $dnds1 = JsFunc::dnds($dn[0],$dn[2],3);
                $list[$key]["DNDS"] = [$dnds,$dnds1];
                //斗牛梭哈
                $dnsh = JsFunc::douniusuoha($ma,1);
                $dnsh1 = JsFunc::douniusuoha($ma,3);
                $list[$key]["DNSH"] = [$dnsh,$dnsh1];
                for($i = 1;$i <= $game['mnum'];$i++){
                    //号码
                    $hm = intval($kj['m'.$i]);
                    $list[$key]["B".$i] = $hm;
                }
                //前三
                $qs = JsFunc::qita($ma[0], $ma[1], $ma[2],1);
                $qs1 = JsFunc::qita($ma[0], $ma[1], $ma[2],3);
                $list[$key]["QS"] = [$qs,$qs1];
                //中三
                $zs = JsFunc::qita($ma[1], $ma[2], $ma[3],1);
                $zs1 = JsFunc::qita($ma[1], $ma[2], $ma[3],3);
                $list[$key]["ZS"] = [$zs,$zs1];
                //后三
                $hs = JsFunc::qita($ma[2], $ma[3], $ma[4],1);
                $hs1 = JsFunc::qita($ma[2], $ma[3], $ma[4],3);
                $list[$key]["HS"] = [$hs,$hs1];
            }elseif ($game['fenlei'] == 151){//快三系列
                //总和
                $list[$key]["ZH"] = $total;
                //总和大小
                $zdx = JsFunc::zhdx($game['fenlei'],$total,1);
                $zdx1 = JsFunc::zhdx($game['fenlei'],$total,3);
                $list[$key]["ZDX"] = [$zdx,$zdx1];
                //鱼虾蟹
                $yxxone = JsFunc::yuxiaxie($ma[0],1);
                $yxxone1 = JsFunc::yuxiaxie($ma[0],3);
                $list[$key]['yxxone'] = [$yxxone,$yxxone1];
                $yxxtwo = JsFunc::yuxiaxie($ma[1],1);
                $yxxtwo1 = JsFunc::yuxiaxie($ma[1],3);
                $list[$key]['yxxtwo'] = [$yxxtwo,$yxxtwo1];
                $yxxthree = JsFunc::yuxiaxie($ma[2],1);
                $yxxthree1 = JsFunc::yuxiaxie($ma[2],3);
                $list[$key]['yxxthree'] = [$yxxthree,$yxxthree1];
            }elseif ($game['fenlei'] == 121) {//11选5系列
                //总和
                $list[$key]["ZH"] = $total;
                //总和大小
                $zdx = JsFunc::zhdx($game['fenlei'],$total,1);
                $zdx1 = JsFunc::zhdx($game['fenlei'],$total,3);
                $list[$key]["ZDX"] = [$zdx,$zdx1];
                //总和单双
                $zds = JsFunc::ds($game['fenlei'],$total,1);
                $zds1 = JsFunc::ds($game['fenlei'],$total,3);
                $list[$key]["ZDS"] = [$zds,$zds1];
                //总和尾数大小
                $zwdx = JsFunc::zwdx($total,1);
                $zwdx1 = JsFunc::zwdx($total,3);
                $list[$key]["ZWDX"] = [$zwdx,$zwdx1];
                //龙虎
                $lh = JsFunc::longhuhe($kj['m1'],$kj['m5'],1);
                $lh1 = JsFunc::longhuhe($kj['m1'],$kj['m5'],3);
                $list[$key]["LH"] = [$lh,$lh1];
                for($i = 1;$i <= $game['mnum'];$i++){
                    //号码
                    $hm = intval($kj['m'.$i]);
                    $list[$key]["B".$i] = $hm;
                    //大小
                    $dx = JsFunc::dx($game['fenlei'],$hm,1);
                    $dx1 = JsFunc::dx($game['fenlei'],$hm,3);
                    $list[$key]["DX".$i] = [$dx,$dx1];
                }
            }elseif($game['fenlei'] == 103){//快乐十分
                //总和
                $list[$key]["ZH"] = $total;
                //总和大小
                $zdx = JsFunc::zhdx($game['fenlei'],$total,1);
                $zdx1 = JsFunc::zhdx($game['fenlei'],$total,3);
                $list[$key]["ZDX"] = [$zdx,$zdx1];
                //总和单双
                $zds = JsFunc::ds($game['fenlei'],$total,1);
                $zds1 = JsFunc::ds($game['fenlei'],$total,3);
                $list[$key]["ZDS"] = [$zds,$zds1];
                //总和尾数大小
                $zwdx = JsFunc::zwdx($total,1);
                $zwdx1 = JsFunc::zwdx($total,3);
                $list[$key]["ZWDX"] = [$zwdx,$zwdx1];
                //1-4龙虎
                for($i = 1;$i <= 4;$i++){
                    $lh = JsFunc::longhuhe($kj['m'.$i],$kj['m'.(9-$i)],1);
                    $lh1 = JsFunc::longhuhe($kj['m'.$i],$kj['m'.(9-$i)],3);
                    $list[$key]["LH".$i] = [$lh,$lh1];
                }
                for($i = 1;$i <= $game['mnum'];$i++){
                    //号码
                    $hm = intval($kj['m'.$i]);
                    $list[$key]["B".$i] = $hm;
                }
            }elseif($game['fenlei'] == 161) {//快乐8系列
                $dan = 0;
                $qian = 0;
                for ($j = 1; $j <= $game['mnum']; $j++) {
                    if ($kj['m' . $j] % 2 == 1) $dan++;
                    if ($kj['m' . $j] <= 40) $qian++;
                }
                //总和
                $list[$key]["ZH"] = $total;
                //五行
                $wx = JsFunc::wuhang_161($total,1);
                $wx1 = JsFunc::wuhang_161($total,3);
                $list[$key]["WX"] = [$wx,$wx1];
                //前后和
                $qhh = JsFunc::qianhouhe($qian,1);
                $qhh1 = JsFunc::qianhouhe($qian,3);
                $list[$key]["QHH"] = [$qhh,$qhh1];
                //单双和
                $dsh = JsFunc::danshuanghe($dan,1);
                $dsh1 = JsFunc::danshuanghe($dan,3);
                $list[$key]["DSH"] = [$dsh,$dsh1];
                //总和大小
                $zdx = JsFunc::zhdx($game['fenlei'],$total,1);
                $zdx1 = JsFunc::zhdx($game['fenlei'],$total,3);
                $list[$key]["ZDX"] = [$zdx,$zdx1];
                //总和单双
                $zds = JsFunc::ds($game['fenlei'],$total,1);
                $zds1 = JsFunc::ds($game['fenlei'],$total,3);
                $list[$key]["ZDS"] = [$zds,$zds1];
                for($i = 1;$i <= $game['mnum'];$i++){
                    //号码
                    $hm = intval($kj['m'.$i]);
                    $list[$key]["B".$i] = $hm;
                }
            }
        }
        return $list;
    }

    public static function bet($play,$lottery,$drawNumber,$userid){
        $tzjq = x_config('tzjg');
        $editstart = x_config('editstart');
        $zcmode = x_config('zcmode');
        $minje = x_config('minje');
        $db = Db::connection();
        $game = Game::where('lottery', $lottery)->select(['gid','ifopen','fenlei','thisqishu','panstatus','otherstatus','autoopenpan','userclosetime','otherclosetime','fast','pan','patt1','pause'])->first();
        if($game['pause'] == 1){
            return ['code' => 0,'msg' => '该彩种已暂停投注'];
        }
        $pan = json_decode($game['pan'], true);
        $user = User::where('userid', $userid)->select(['kmoney','money','fudong','layer','fid1','pself','status','defaultpan','plwarn','sy','yingdeny','ftime','username','kmaxmoney','zcobj','backmode'])->first();
        $ip = request()->getClientIp();$time = time();$gid = $game['gid'];
        $db->insert("insert into x_log set ip='$ip',userid='$userid',gid='$gid',time='$time',type='user',content='".json_encode($play,JSON_UNESCAPED_UNICODE)."'");
        $cp   = count($play);
        $sess_exetime = Cache::get('exetime'.$userid,'0');
        if ((time() - $sess_exetime) < $tzjq) {
            return ['code'=>0,'msg'=>"下注间隔频繁!"];
        }
        Cache::put('exetime'.$userid,time());
        if($game['ifopen'] == 0){
            return ['code'=>0,'msg'=>'该彩种已关闭下注!'];
        }
        $je = 0;
        if ($zcmode == 1) {
            $flytype = Gamecs::where(['gid' => $game['gid'], 'userid' => $userid])->value('flytype');
        } else {
            $flytype = Gamezc::where(['typeid' => $game['fast'], 'userid' => $userid])->value('flytype');
        }
        if($flytype != 1){
            return ['code'=>0,'msg'=>'上级已禁止补货!'];
        }
        if ($user['status'] != 0) {
            return ['code'=>0,'msg'=>'您已被暂停投注!'];
        }
        if ($user["yingdeny"] == 1) {
            return ['code'=>0,'msg'=>'赢利超限,请明日再投注!'];
        }
        $ab = 'A';
        $abcd = $user['defaultpan'];
        $moneys = $user['kmoney'];
        $thelayer = $user['layer'];
        $fid1 = $userid;
        $pself    = $user['pself'];
        $zcobj = $user['zcobj'];
        $backmode = $user['backmode'];
        if ($thelayer > 1) {
            $puser = User::where('userid',$fid1)->select(['pself','zcobj','backmode'])->first();
            $pself = $puser['pself'];
            $zcobj = $puser['zcobj'];
            $backmode = $puser['backmode'];
            $fid1 = $user['fid1'];
        }
        if($pself == 1){
            $patt = Userpatt::where(['userid'=>$user['userid'],'gid'=>$game['gid']])->value('patt1');
            $patt = json_decode($patt, true);
        }else{
            $patt = json_decode($game['patt1'], true);
        }
        $je = 0;
        $chaiplaylist = [];
        for ($i = 0; $i < $cp; $i++) {
            if(!empty($play[$i]['range'])){
                $abcd = $play[$i]['range'];
            }
            $je += $play[$i]['amount'];
            $play[$i]['con'] = '';
            if($play[$i]['game'] == 'LM30' || $play[$i]['game'] == 'LM2' || $play[$i]['game'] == 'LM22'){//11选5 前二组选
                $hmarr = explode(',',$play[$i]['contents']);
                $hmcount = count($hmarr);
                if($hmcount >= 2){
                    $plist = ComFunc::getTwoPairs($hmarr);
                    foreach ($plist as $value) {
                        $tmp = $play[$i];
                        $tmp['contents'] = implode(',',$value);
                        $chaiplaylist[] = $tmp;
                    }
                }else{
                    if($hmcount < 2){
                        Cache::delete('exe'.$userid);
                        return ['code'=>0,'msg'=>'投注内容错误!'];
                    }
                }
                unset($play[$i]);
            }elseif($play[$i]['game'] == 'LM32' || $play[$i]['game'] == 'LM3'){//11选5 前三组选
                $hmarr = explode(',',$play[$i]['contents']);
                $hmcount = count($hmarr);
                if($hmcount >= 3){
                    $plist = ComFunc::getThreePairs($hmarr);
                    foreach ($plist as $value) {
                        $tmp = $play[$i];
                        $tmp['contents'] = implode(',',$value);
                        $chaiplaylist[] = $tmp;
                    }
                }else{
                    if($hmcount < 3){
                        Cache::delete('exe'.$userid);
                        return ['code'=>0,'msg'=>'投注内容错误!'];
                    }
                }
                unset($play[$i]);
            }elseif ($play[$i]['game'] == 'LM4') {//快乐十分
                $hmarr = explode(',',$play[$i]['contents']);
                $hmcount = count($hmarr);
                if($hmcount > 3){
                    $plist = ComFunc::getFourPairs($hmarr);
                    foreach ($plist as $value) {
                        $tmp = $play[$i];
                        $tmp['contents'] = implode(',',$value);
                        $chaiplaylist[] = $tmp;
                    }
                }else{
                    if($hmcount < 4){
                        Cache::delete('exe'.$userid);
                        return ['code'=>0,'msg'=>'投注内容错误!'];
                    }
                }
                unset($play[$i]);
            }elseif ($play[$i]['game'] == 'LM5') {//快乐十分
                $hmarr = explode(',',$play[$i]['contents']);
                $hmcount = count($hmarr);
                if($hmcount > 4){
                    $plist = ComFunc::getFivePairs($hmarr);
                    foreach ($plist as $value) {
                        $tmp = $play[$i];
                        $tmp['contents'] = implode(',',$value);
                        $chaiplaylist[] = $tmp;
                    }
                }else{
                    if($hmcount < 5){
                        Cache::delete('exe'.$userid);
                        return ['code'=>0,'msg'=>'投注内容错误!'];
                    }
                }
                unset($play[$i]);
            }
        }
        //合并$chaiplaylist
        $play = array_merge($play,$chaiplaylist);
        $cp = count($play);
        if($thelayer >= 1 && $user['fudong'] == 1){
            if ($je > $moneys) {
                return ['code'=>0,'msg'=>'余额不足!'];
            }
        }
        $u        = ComFunc::getfid($userid);//查询所有的上级用户
        $zc       = ComFunc::getzcnew_sg($userid, $u, $thelayer, $gid, $zcmode,$game['fast'],$zcobj,1,$backmode,$user['fid1']);
        $czc      = count($zc) - 1;
        $peilvcha = array();
        $jex      = 0;
        //$db->delete("delete from x_libu where  userid='$userid'");
        $kj = Kj::where(['gid'=>$gid,'qishu'=>$drawNumber])->select(['opentime','closetime'])->first();
        $game['closetime'] = $kj['closetime'];
        $time = time();
        if (($time - $kj['opentime']) < 0 && $game['autoopenpan'] == 1) {
            $game['panstatus']   = 0;
            $game['otherstatus'] = 0;
        }
        if ($game['panstatus'] == 0) {
            return ['code'=>0,'msg'=>'已关盘'];
        }
        if ($time > ($kj['closetime'] - $game['otherclosetime'] - $game['userclosetime'])) {
            return ['code'=>0,'msg'=>'已关盘'];
        }
        if (date("His") <= str_replace(':', '', $editstart)) {
            $dates = time() - 86400;
        } else {
            $dates = time();
        }
        $cdftype = 0;$cptype = -1;
        $odds = [];$table = SGUtils::getcuretable(true);
        $ids = [];$dividends = [];$syspcl = x_config('plc');
        $libmodel = SGUtils::getcuremodel();$bets = [];
        for ($i = 0; $i < $cp; $i++) {
            if ($play[$i]['amount'] <= 0 | $play[$i]['amount'] % 1 != 0){
                return ['code'=>0,'msg'=>'补货金额错误!'];
            }
            if($play[$i]['amount'] < $minje){
                return ['code'=>0,'msg'=>'补货金额不能小于'.$minje];
            }
            //如果包含2shs则为特殊玩法
            if (isset($play[$i]['state'])) {
                $cy = $play[$i]['game'].'_'.$play[$i]['state'];
            }else{
                $cy = $play[$i]['game'].'_'.$play[$i]['contents'];
            }
            $pp = Play::where(['gid'=>$gid,'cy'=>$cy])->select(['pid','bid','sid','cid','peilv1','ifok','ptype','pl','yautocs','ystart','ztype','cy'])->first();
            if(empty($pp)){
                return ['code'=>0,'msg'=>'补货失败,玩法不存在!'];
            }
            $ptype   = $pp['ptype'];
            $bid     = $pp['bid'];
            $sid     = $pp['sid'];
            $cid     = $pp['cid'];
            $pname   = $pp['name'];
            $ifok    = $pp['ifok'];
            $yautocs = $pp['yautocs'];
            $ystart  = $pp['ystart'];
            $pl      = $pp['pl'];
            $peilv1  = 0;
            $peilv2  = 0;
            $peilv1s = 0;
            $peilv2s = 0;
            if ($pname == '過關' || $pname == '过关') {

            } else {
                //如果$pp['cy']包含2ZTS1则将cy转成数组
                if (strpos($pp['cy'], '2ZTS') !== false || strpos($pp['cy'], '3ZTS') !== false) {
                    $tarr = str_split($play[$i]['contents']);
                    $play[$i]['con'] = implode('-', $tarr);
                }elseif (isset($play[$i]['multiple']) && $play[$i]['multiple'] = 1) {
                    $play[$i]['con'] = $play[$i]['contents'];
                }/*elseif (isset($play[$i]['multiple']) && $play[$i]['multiple'] > 1){
                    $harr = explode(',', $play[$i]['contents']);
                    $tarr = ComFunc::getTwoPairs($harr);
                }*/
                $peilv1 = $pp['peilv1'];
                if ($pself == 1) {
                    $playuser = PlayUser::where(['userid'=>$fid1,'gid'=>$gid,'pid'=>$pp['pid']])->select(['peilv1','ystart','yautocs'])->first();
                    $peilv1s = $playuser['peilv1'];
                }
                //已飞金额校验
                if ($thelayer > 0) {
                    $rs = $db->select("select sum(je*zc{$thelayer}/100) as ra from $table where gid='$gid' and uid{$thelayer}='{$userid}' and qishu='{$drawNumber}' and pid='{$pp['pid']}' union all select sum(je) as rb from $table where gid='$gid' and userid='{$userid}' and qishu='{$drawNumber}' and pid='{$pp['pid']}' and xtype!=2");
                }else{
                    $rs = $db->select("select sum(je*zc{$thelayer}/100) as ra from $table where gid='$gid' and qishu='{$drawNumber}' and pid='{$pp['pid']}' union all select sum(je) as rb from $table where gid='$gid' and userid='{$userid}' and qishu='{$drawNumber}' and pid='{$pp['pid']}' and xtype!=2");
                }
                $maxfei = isset($rs[0]['ra']) ? $rs[0]['ra'] : 0;
                $yifei = isset($rs[1]['ra']) ? $rs[1]['ra'] : 0;
                if ($yifei + $play[$i]['amount'] > $maxfei) {
                    return ['code'=>0,'msg'=>'补货额已超占成金额!'];
                }
            }
            if ($ifok != 1) {
                return ['code'=>0,'msg'=>'玩法未开放'];
            }
            $class = Mclass::where(['gid'=>$gid,'cid'=>$cid])->select(['dftype'])->first();
            $dftype = $class['dftype'];
            if ($cptype != $ptype) {
                //$autopl = Auto::where(['userid'=>$userid,'gid'=>$gid,'class'=>$dftype])->first();
                $abcdcha = 0;
                $tmpabcd = 0;
                if ($pan[$dftype]['abcd'] == 1) {
                    if ($abcd != 'A') {
                        $abcdcha = $patt[$ptype][strtolower($abcd)];
                    }
                    $tmpabcd = $abcd;
                }
                $points = ComFunc::getpoints8($dftype, $tmpabcd, 0, $userid, $gid);
                $order = [];
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
                    $arr = ComFunc::getzcs8($dftype, $userid, $gid);
                    $tmppeilvcha += $arr['peilvcha'];
                    $peilvchax = $tmppeilvcha + $abcdcha - 0;
                    $lowpeilvx = $arr['lowpeilv'];
                }else{
                    $peilvchax = $tmppeilvcha + $abcdcha - 0;
                    $lowpeilvx = 0;
                }
                $arr       = ComFunc::getjes8($dftype, $userid, $gid);
                $cmaxjex = $arr['cmaxje'];
                $maxjex  = $arr['maxje'];
            }
            $cptype = $ptype;
            $attpeilv = 0;
            $tmppeilv        = 0;
            $tmppeilv2       = 0;
            if (!isset($play[$i]['multiple'])) {
                if ($thelayer == 1 && $pself == 1) {
                    $tmppeilv = ComFunc::moren($peilv1s - $peilvchax, $lowpeilvx);
                }else {
                    $tmppeilv = ComFunc::moren($peilv1 - $peilvchax, $lowpeilvx);
                }
            }else {
                $tmppeilv = $peilv1;
            }
            $odds[] = $tmppeilv.",";
            $play[$i]['peilv1'] = $tmppeilv;
            $dividends[] = ComFunc::pr2($play[$i]['amount'] * $tmppeilv);
            $order['xtype'] = 1;
            $order['cy'] = $pp['cy'];
            $order['dftype'] = $dftype;
            $order['dates'] = strtotime(date("Y-m-d",$dates));
            $order['gid'] = $gid;
            $order['qishu'] = $drawNumber;
            $order['userid'] = $userid;
            $order['bid'] = $bid;
            $order['sid'] = $sid;
            $order['cid'] = $cid;
            $order['pid'] = $pp['pid'];
            $order['abcd'] = $abcd;
            $order['flytype'] = 1;
            $order['ab'] = $ab;
            //$order['content'] = isset($play[$i]['multiple']) ? $play[$i]['contents'] : '';
            $order['time'] = time();
            $order['je'] = $play[$i]['amount'];
            $order['z'] = 9;
            $order['bs'] = 1;
            $order['peilv1'] = $tmppeilv;
            $order['peilv2'] = $tmppeilv2;
            $order['sv'] = '0';
            $order['ip'] = $ip;
            $order['code'] = ComFunc::getNewOrderId(date("YmdH"));
            $order['kk'] = 1;
            $order['content'] = $play[$i]['con'];
            $ids[] = $order['code'];
            $zxstr=[];
            $pei=[];
            /*if($pname=='三中二' || $pname=='二中特'){
                $pei[0][0] = $tmppeilv;
                $pei[0][1] = $tmppeilv2;
            }*/
            for ($j = 1; $j < $czc; $j++) {
                if ($pself == 1 && $j > 1) {
                    $order['peilv1'.$j] = ComFunc::moren($peilv1s - $peilvcha[$j] , $lowpeilv[$j]);
                } else {
                    $order['peilv1'.$j] = ComFunc::moren($peilv1 - $peilvcha[$j] , $lowpeilv[$j]);
                }
            }
            if($bid=='26000004'){
                $order['bz'] = json_encode($zxstr);
            } else if($pname=='三中二' || $pname=='二中特'){
                $order['bz'] = json_encode($pei);
            } else{
                $order['bz'] = isset($play[$i]['bz']) ? $play[$i]['bz'] : '';
            }
            /*if ($cp > 3) {
                $res = Libu::create($order);
            } else {
                $res = $libmodel->create($order);
            }*/
            /*if ($res) {
                $jex += $order['je'];
            }*/
            $bets[] = $order;
        }
        if(count($bets) > 0){
            $libmodel->insert($bets);
            AutoFlysQueue::dispatch(['userid'=>$userid,'gid'=>$gid,'qishu'=>$drawNumber,'list'=>$bets]);
        }
        return ['code'=>1,'dividends'=>$dividends,'ids'=>$ids,'odds'=>$odds];
    }

    public static function controlrisk($user,$lottery,$abcd,$all,$games){
        $result = [[],[],[]];
        $userid = $user['userid'];
        $db = Db::connection();
        $game = Game::where('lottery', $lottery)->select(['gid','fenlei','cs','otherclosetime','autoopenpan','panstatus','thisqishu','template','patt1'])->first();
        $gid = $game['gid'];$qishu = $game['thisqishu'];
        $patt = json_decode($game['patt1'], true);
        $layer = $user['layer'];$pself = $user['pself'];
        $fid1 = $user['userid'];$table = SGUtils::getcuretable(true);
        if($layer > 1){
            $puser = User::where('userid', $user['fid1'])->select(['layer','pself','userid'])->first();
            $pself = $puser['pself'];
            $fid1 = $puser['userid'];
        }
        if($layer > 0 && $pself == 1){
            $patt = Userpatt::where(['userid'=>$fid1,'gid'=>$game['gid']])->value('patt1');
            $patt = json_decode($patt, true);
        }
        $yqa = " gid='{$gid}'  and qishu='{$qishu}'";
        $yq2 = $yqa;
        $yq = '';
        $yq2b = '';
        $yq .= ' and xtype!=2 ';
        if($layer > 0){
            $yq .= " and uid{$layer}='{$userid}'";
        }
        $maxlayer = x_config('maxlayer');
        if ($layer < $maxlayer - 1) {
            $pointsstr = 'points' . ($layer + 1);
            $peilv1str = 'peilv1' . ($layer + 1);
            $uidstr = 'uid' . $layer;
        } else {
            $pointsstr = 'points';
            $peilv1str = 'peilv1';
            $uidstr = 'uid' . $layer;
        }
        $zcstr = 'zc' . $layer;
        if($layer > 0)$yqa .= " and {$uidstr}='{$userid}' ";
        $ab = 'A';
        if ($abcd == 'A' || $abcd == 'B' || $abcd == 'C' || $abcd == 'D') {
            $yq .= " and abcd='{$abcd}' ";
            $yq2b .= " and abcd='{$abcd}' ";
        }
        if ($abcd != 'A' && $abcd != 'B' && $abcd != 'C' && $abcd != 'D') {
            $abcd = 'A';
        }
        $cids = [];
        if(!empty($games)){
            $css = explode(',', $games);
            $cids = Mclass::where('gid',$gid)->whereIn('cs',$css)->pluck('cid')->toArray();
        }
        $play = Play::where('gid',$gid);
        if(!empty($cids)){
            $play = $play->whereIn('cid',$cids);
        }
        $play = $play->select(['cid','peilv1','cy','pid','ptype'])->get();
        $cdftype = -1;$temp = [];$tempa = [];$tempb=[];$syspcl = x_config('plc');$peilvcha = 0;
        foreach ($play as $p){
            $ptype = $p['ptype'];
            if (!isset($temp['f'.$gid.$p['cid']])){
                $class = Mclass::where(['gid'=>$gid,'cid'=>$p['cid']])->select(['ftype','dftype'])->first();
                $dftype = $class['dftype'];
                $ftype = $class['ftype'];
            }
            if ($cdftype != $dftype) {
                if($syspcl == 1){
                    if ($layer > 0 && $pself == 1) {
                        $tuid = $userid;$peilvcha = 0;$ulayer = $user['layer'];
                        while ($ulayer > 1) {
                            if(!isset($temp['zpan'.$gid.$dftype.$tuid])){
                                $temp['zpan'.$gid.$dftype.$tuid] = Zpan::where(['gid'=>$gid,'userid'=>$tuid,'class'=>$dftype])->value('peilvcha');
                            }
                            $peilvc = $temp['zpan'.$gid.$dftype.$tuid];
                            $peilvc = $peilvc ? $peilvc : 0;
                            $peilvcha += $peilvc;
                            if(!isset($temp['ufid'.$tuid])){
                                $temp['ufid'.$tuid] = User::where('userid',$tuid)->select(['fid','layer'])->first();
                            }
                            $ulayer = $temp['ufid'.$tuid]['layer'];
                            $tuid = $temp['ufid'.$tuid]['fid'];
                            if ($ulayer==2)
                                break;
                        }
                    } else {
                        $tuid = $userid;$peilvcha = 0;
                        while ($tuid != 99999999) {
                            if(!isset($temp['zpan'.$gid.$dftype.$tuid])){
                                $temp['zpan'.$gid.$dftype.$tuid] = Zpan::where(['gid'=>$gid,'userid'=>$tuid,'class'=>$dftype])->value('peilvcha');
                            }
                            $peilvc = $temp['zpan'.$gid.$dftype.$tuid];
                            $peilvc = $peilvc ? $peilvc : 0;
                            $peilvcha += $peilvc;
                            if(!isset($temp['ufid'.$tuid])){
                                $temp['ufid'.$tuid] = User::where('userid',$tuid)->value('fid');
                            }
                            $tuid = $temp['ufid'.$tuid];
                            if ($tuid == 99999999)
                                break;
                        }
                    }
                }
                $cdftype = $dftype;
            }
            if ($layer > 0 && $pself == 1) {
                $f_user = PlayUser::where(['userid'=>$fid1,'gid'=>$gid,'pid'=>$p['pid']])->select(['peilv1'])->first();
                $p['peilv1'] = $f_user['peilv1'];
                if ($abcd != 'A') {
                    $p['peilv1'] -= $patt[$ptype][strtolower($abcd)];
                }
            }else{
                if ($abcd != 'A') {
                    $p['peilv1'] -= $patt[$ptype][strtolower($abcd)];
                }
            }
            $p['peilv1'] -= $peilvcha;
            $p['peilv1']  = ComFunc::pr4($p['peilv1']);
            $result[1][$p['cy']] = ['a'=>$p['peilv1'],'showFlag'=>0];
        }
        $libs = $db->select("select pid from $table where {$yqa} {$yq} group by pid");
        foreach ($libs as $lib) {
            $p = Play::where(['gid'=>$gid,'pid'=>$lib['pid']])->select(['pid','cy'])->first();
            //下注金额统计查询
            if($all == 'SZ'){
                $sql = "select sum(je*{$zcstr}/100) as rb,sum(if({$peilv1str}=0,peilv1,{$peilv1str})*je*{$zcstr}/100) as rc,sum((if({$peilv1str}=0,points,{$pointsstr})/100)*je*{$zcstr}/100) as rd,count(id) as re ";
                $sql .= " from $table where {$yqa} and  pid='" . $p['pid'] . "' {$yq}  ";
                $rs = $db->select($sql);
                $zje = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
                $zhong = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
                $point = $rs[0]['rd'] ? $rs[0]['rd'] : 0;
                $count = $rs[0]['re'] ? $rs[0]['re'] : 0;
                $sql = "select sum(je) as ra,sum(je*points/100) as rb,sum(je*peilv1) as rc from $table";
                $sql .= " where {$yq2} and userid='{$userid}'  and pid='{$p['pid']}' {$yq2b} and xtype!=2";
                $rs = $db->select($sql);
                $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
                $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
                $rc = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
                $sumflyje = ComFunc::pr1($ra);
                $sumflypoints = ComFunc::pr1($rb);
                $sumflyzhong = ComFunc::pr1($rc);
                $point -= $sumflypoints;
                $zje -= $sumflyje;
                $ky = ComFunc::pr1($zhong-$sumflyzhong);//ComFunc::pr1($zje - $zhong - -$point);
            }elseif ($all == 'XZ') {
                $sql = "select sum(je) as rb,sum(peilv1*je) as rc,sum(points/100*je) as rd,count(id) as re ";
                $sql .= " from $table where {$yqa} and  pid='" . $p['pid'] . "' {$yq}  ";
                $rs = $db->select($sql);
                $zje = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
                $zhong = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
                $point = $rs[0]['rd'] ? $rs[0]['rd'] : 0;
                $count = $rs[0]['re'] ? $rs[0]['re'] : 0;
                $ky = ComFunc::pr1($zhong);
            }elseif ($all == 'BH') {
                $sql = "select sum(je) as rb,sum(je*peilv1) as rc,sum(je*points/100) as rd,count(id) as re from $table";
                $sql .= " where {$yq2} and userid='{$userid}' and pid='" . $p['pid'] . "' {$yq2b} and xtype!=2";
                $rs = $db->select($sql);
                $zje = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
                $zhong = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
                $point = $rs[0]['rd'] ? $rs[0]['rd'] : 0;
                $count = $rs[0]['re'] ? $rs[0]['re'] : 0;
                $ky = ComFunc::pr1($zhong);
            }
            if($count > 0){
                $cc = explode('_',$p['cy']);
                $cs = $cc[0];
                $cy = $cc[1];
                if(!isset($tempa[$p['cy']])){
                    $tempa[$p['cy']]['a'] = $zje;
                    $tempa[$p['cy']]['c'] = $count;
                    $tempa[$p['cy']]['cm'] = $point;
                    $tempa[$p['cy']]['i'] = $cy;
                    $tempa[$p['cy']]['k'] = $cs;
                    $tempa[$p['cy']]['r'] = $ky;
                }else{
                    $tempa[$p['cy']]['a'] += $zje;
                    $tempa[$p['cy']]['c'] += $count;
                    $tempa[$p['cy']]['cm'] += $point;
                    $tempa[$p['cy']]['r'] += $ky;
                }
                $tempa[$p['cy']]['a'] = ComFunc::pr2($tempa[$p['cy']]['a']);
                $tempa[$p['cy']]['cm'] = ComFunc::pr2($tempa[$p['cy']]['cm']);
                $tempa[$p['cy']]['r'] = ComFunc::pr2($tempa[$p['cy']]['r']);
                $tcs = SGUtils::getfLbYGroup($game['template'],$cs);
                if(!isset($tempb[$tcs])){
                    $tempb[$tcs] = $zje;
                }else{
                    $tempb[$tcs] += $zje;
                }
            }
        }
        $result[0] = array_values($tempa);
        $result[2] = $tempb;
        return $result;
    }

    public static function clearaccount($user){
        Log::info("删除账号:".$user['username'].',userid:'.$user['userid']);
        $db = Db::connection();
        //开启事务
        try {
            $db->beginTransaction();
            //是否是房主号
            if($user['type'] == 2){
                $db->delete("delete from x_apply where ruid='{$user['userid']}'");//申请表
                $db->delete("delete from x_baototal where ruid='{$user['userid']}'");//报表
                $db->delete("delete from x_chatmsg where ruid='{$user['userid']}'");//占城备份表
                $db->delete("delete from x_gamemsg where ruid='{$user['userid']}'");//订单修改表
                $db->delete("delete from x_link where ruid='{$user['userid']}'");//自动降赔表
                $db->delete("delete from x_money_log where ruid='{$user['userid']}'");//资金记录
                $db->delete("delete from x_outbet_site where ruid = {$user['userid']}");//外部投注表
                $db->delete("delete from x_outbet_error where userid = {$user['userid']}");//外部投注表
                $db->delete("delete from x_points where ruid='{$user['userid']}'");//退水表
                $db->delete("delete from x_roomhistory where ruid='{$user['userid']}'");//房间历史记录
                //$db->delete("delete x_tax_template,x_tax_template_item from x_tax_template left join x_tax_template_item on x_tax_template.id=x_tax_template_item.template_id where x_tax_template.fid1 = {$user['userid']}");//税收表
                //$db->delete("delete from x_tax_user where ruid='{$user['userid']}'");//赚点用户表
                $db->delete("delete from x_user where ruid='{$user['userid']}'");//专属用户清理
                $db->delete("delete from x_user_edit where ruid='{$user['userid']}'");//用户修改表
                $db->delete("delete from x_userpatt where userid='{$user['userid']}'");//房主赔率差表
                $db->delete("delete from x_userroom where userid='{$user['userid']}'");//房间表
                $db->delete("delete from x_user_page where ruid='{$user['userid']}'");
                $db->delete("update x_userreg set ruid=0 where ruid='{$user['userid']}'");
                $db->delete("delete from x_userreg where userid='{$user['userid']}'");
            }
            $db->delete("delete from x_money_log where userid='{$user['userid']}'");
            $db->delete("delete from x_baototal where userid='{$user['userid']}'");//报表
            $db->delete("delete from x_points where userid='{$user['userid']}'");
            $db->delete("delete from x_apply where userid='{$user['userid']}'");
            $db->delete("delete from x_user where userid='{$user['userid']}'");
            $db->delete("delete from x_user_edit where userid='{$user['userid']}'");
            $db->delete("delete from x_user_login where username='{$user['username']}'");
            $db->delete("delete from x_link where userid='{$user['userid']}'");
            $db->commit();
        }catch (\Exception $e){
            $db->rollBack();
            Log::info('清理账号失败,请重试!,userid:'.$user['userid'].',msg:'.$e->getMessage());
            return ['code'=>0,'msg'=>'清理账号失败,请重试!'];
        }
        //清理在线websocket

        //清理注单表
        /*foreach ($arr as $v) {
            $tb = array_values($v)[0];
            $db->delete("delete from {$tb} where userid='{$user['userid']}'");
        }*/
        return ['code'=>1,'msg'=>'清理账号成功!'];
    }
}
