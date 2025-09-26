<?php

namespace App\ort\sgwin;

//飞单功能服务
use App\Common\Task\TaskRunOubet;
use App\Common\TaskSwoole\OutbetRunOrderQueue;
use App\Models\CustomDomain;
use App\Models\Game\Game;
use App\Models\Game\OutbetAccs;
use App\Models\Game\OutbetError;
use App\Models\Game\OutbetSite;
use App\Models\Game\Play;
use App\Models\Game\User;
use App\ort\cachemodel\CommonCache;
use App\ort\cachemodel\GameCache;
use App\ort\common\ComFunc;
use App\ort\common\CommonUtils;
use App\ort\common\Constants;
use App\ort\HttpUtils;
use Firebase\JWT\JWT;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use function AlibabaCloud\Client\json;
use function Illuminate\Support\Facades\update;
use function Symfony\Component\String\b;

class OutbetServices
{


    public function handle($param){
        $plat_outbet_status = x_config('plat_outbet_status');
        if($plat_outbet_status == 0){
            return;
        }
        $userid = $param['userid'];
        $drawNumber = $param['drawNumber'];
        $orderbets = $param['bets'];
        $lottery = $param['lottery'];
        $gid = $param['gid'];
        $opentime = $param['opentime'];
        $closetime = $param['closetime'];
        $fenduan = $param['fenduan'];
        $fids = $this->getfids($userid);
        //加入99999999
        $fids[] = Constants::$SUID;
        $outsitelist = OutbetSite::where(['main_fu_type'=>1,'is_gentoumode'=>1])->whereIn('userid',$fids)->get();
        //$libmode = SGUtils::getcuremodel();
        $libflymode = SGUtils::getcureflymodel();
        $redis = app('redis.connection');
        $outbet_redis_key = 'outbet_list';$tmp = [];$minje = x_config('minje');$fantou_teshu = Cache::get('fantou_teshu',0);
        foreach ($outsitelist as $site){
            $accscount = OutbetAccs::where(['siteid'=>$site['id'],'enabled'=>1,'online'=>1])->count('id');
            if($site['enabled'] == 0 || $accscount == 0){
                //判断是否有副站
                $site = OutbetSite::where(['main_fu_type'=>2,'main_site_id'=>$site['id'],'enabled'=>1])->first();
                if(empty($site)){
                    continue;
                }
            }
            $fuser = User::where('userid',$site['userid'])->select(['layer','outbet_switch','outbet_mode'])->first();
            if(empty($fuser)){
                continue;
            }
            if($fuser['outbet_switch'] == 0 || $fuser['outbet_mode'] == 2 || $site['is_hebing'] == 1){
                continue;
            }
            $accs = OutbetAccs::where(['siteid'=>$site['id'],'enabled'=>1,'online'=>1])->get()->toArray();
            if(empty($accs)){
                continue;
            }
            $f1 = 1;$f2 = 1;
            if(!empty($site['zhidingagent'])){//指定代理
                $usernames = explode(',',$site['zhidingagent']);
                $fusers = User::whereIn('username',$usernames)->select(['userid','layer'])->get();
                $uids = [];
                foreach ($fusers as $f){
                    $tuids = User::where('fid'.$f['layer'],$f['userid'])->pluck('userid')->toArray();
                    $uids = array_merge($uids,$tuids);
                }
                if(!in_array($userid,$uids)){
                    $f1 = 0;
                }
            }
            if(!empty($site['zhidinguser'])){//指定会员
                $usernames = explode(',',$site['zhidinguser']);
                $uids = User::whereIn('username',$usernames)->pluck('userid')->toArray();
                if(!in_array($userid,$uids)){
                    $f2 = 0;
                }
            }
            if(!empty($site['zhidingagent']) || !empty($site['zhidinguser'])){
                if($f1 == 0 || $f2 == 0){
                    continue;
                }
            }
            $lotterys = explode(',',$site['lotterys']);
            if(!in_array($lottery,$lotterys)){
                continue;
            }
            //计算总金额
            $total = 0;$chai_money = $site['chai_money'];$tmpbets = [];$tspids = [];
            $bets = $orderbets;$ftmp = [];
            if ($fantou_teshu == 1 && $site['indicator'] == 0){
                foreach ($bets as $obet){
                    $tspids['p'.$obet['gid'].$obet['bid'].$obet['cid']][] = $obet['pid'];
                }
            }
            foreach ($bets as $k=>&$obet){
                $je = $obet['je'];
                if ($site['mode'] == 1) {//按占城飞单
                    $je = $je * $obet['zc' . $fuser['layer']]/100;
                }
                $je = ($site['flyjiabei'] / 100) * $je;//飞单倍数
                $total += $je;

                //是否是反跟
                if($site['indicator'] == 0){//反跟
                    if(!isset($tmp['g'.$obet['gid']])){
                        $tmp['g'.$obet['gid']] = GameCache::getgamecache($obet['gid']);
                    }
                    $game = $tmp['g'.$obet['gid']];
                    $dftypejson = json_decode($game['dftype'],true);
                    $mclass = CommonCache::getclasscache($obet['gid'],$obet['cid']);
                    $dftype = $mclass['dftype'];
                    if($dftypejson[$dftype] == '两面' || $dftypejson[$dftype] == '双面' || $dftypejson[$dftype] == '1-10名双面' || $dftypejson[$dftype] == '1-5双面' || $dftypejson[$dftype] =='总和两面' || $dftypejson[$dftype] =='冠亚军和大小' || $dftypejson[$dftype] =='冠亚军和单双'){
                        $tpp = Play::where(['gid'=>$obet['gid'],'bid'=>$obet['bid'],'cid'=>$obet['cid']])->where('pid','<>',$obet['pid'])->select(['cy','pid'])->first();
                        $obet['pid'] = $tpp['pid'];
                        $obet['cy'] = $tpp['cy'];
                    }elseif ($dftypejson[$dftype] == '1-5球号' || $dftypejson[$dftype] == '1-10车号'){
                        $fcount = $libflymode->where(['gid'=>$obet['gid'],'bid'=>$obet['bid'],'cid'=>$obet['cid'],'qishu'=>$drawNumber,'userid'=>$site['userid'],'uzp6'=>$site['id']])->count('id');
                        if ($fantou_teshu == 1 && $fcount <= 0){
                            if(!isset($ftmp['g'.$obet['gid'].'_'.$obet['bid'].'_'.$obet['cid']])){
                                $cypids = Play::where(['gid'=>$obet['gid'],'bid'=>$obet['bid'],'cid'=>$obet['cid']])->select(['pid','cy'])->get()->toArray();
                                $tpid = $tspids['p'.$obet['gid'].$obet['bid'].$obet['cid']];
                                foreach ($cypids as $pidcy){
                                    if(!in_array($pidcy['pid'],$tpid)){
                                        $obet['pid'] = $pidcy['pid'];
                                        $obet['cy'] = $pidcy['cy'];
                                        $tmpbets[] = $obet;
                                    }
                                }
                                $ftmp['g'.$obet['gid'].'_'.$obet['bid'].'_'.$obet['cid']] = 1;
                            }
                        }else{
                            $playlist = Play::where(['gid'=>$obet['gid'],'bid'=>$obet['bid'],'cid'=>$obet['cid']])->where('pid','<>',$obet['pid'])->select(['cy','pid'])->orderByDesc('pid')->get()->toArray();
                            foreach ($playlist as $play){
                                $obet['pid'] = $play['pid'];
                                $obet['cy'] = $play['cy'];
                                $tmpbets[] = $obet;
                            }
                        }
                        unset($bets[$k]);
                    }elseif ($dftypejson[$dftype] == '龙虎和' && ($obet['pid'] == 25585014 || $obet['pid'] == 25585015)){
                        $tpp = Play::where(['gid'=>$obet['gid'],'bid'=>$obet['bid'],'cid'=>$obet['cid']])->where('pid','<>',$obet['pid'])->where('pid','<>',25585016)->select(['cy','pid'])->first();
                        $obet['pid'] = $tpp['pid'];
                        $obet['cy'] = $tpp['cy'];
                    }else{
                        if($site['indicator_hl'] == 1){
                            unset($bets[$k]);
                        }
                    }
                }
            }
            if(count($tmpbets) > 0){
                $bets = array_merge($bets,$tmpbets);
            }
            $tempaccs = [];$abcdacc = [];
            foreach ($accs as $ac){
                $bzs = explode('|',$ac['bz']);
                if(!isset($bzs[0])){
                    $tempaccs[] = $ac;
                }else{
                    $balance = $bzs[0];
                    if($total > $balance && $site['bet_mode'] != 2){
                        continue;
                    }
                    $tempaccs[] = $ac;
                    $abcdacc[$ac['abcd']] = $ac;
                }
            }
            //随机取一个账号
            if(count($tempaccs) > 0){
                $acc = $tempaccs[array_rand($tempaccs)];
            }else{
                $acc = $accs[array_rand($accs)];
            }
            //循环会员下注的订单
            $fuserid = $site['userid'];
            $betsave = [];$saves = [];
            foreach ($bets as $bet) {
                $tmpacc = $acc;
                if(isset($abcdacc[$bet['abcd']])){
                    $tmpacc = $abcdacc[$bet['abcd']];
                }
                //计算飞单金额
                $je = $bet['je'];
                if ($site['mode'] == 1) {//按占城飞单
                    $je = $je * $bet['zc'.$fuser['layer']]/100;
                }
                if($site['start_money'] > 0 && $je < $site['start_money']){
                    //Log::info('飞单金额小于起飞金额：'.$je.'|'.$site['start_money'].'|'.$site['id']);
                    continue;
                }
                $je = ($site['flyjiabei'] / 100) * $je;//飞单倍数
                $je = ceil($je);
                if($je <= 0){
                    continue;
                }
                $save['userid'] = $fuserid;
                $save['code'] = ComFunc::getNewOrderId(date("YmdH"));
                $save['gid'] = $bet['gid'];
                $save['bid'] = $bet['bid'];
                $save['sid'] = $bet['sid'];
                $save['cid'] = $bet['cid'];
                $save['pid'] = $bet['pid'];
                $save['je'] = $je;
                $save['xtype'] = 2;
                $save['points'] = isset($bet['points'.$fuser['layer']]) ? $bet['points'.$fuser['layer']] : 0;
                $save['peilv1'] = isset($bet['peilv1'.$fuser['layer']]) ? $bet['peilv1'.$fuser['layer']] : 0;
                $save['ip'] = $bet['userid'];
                $save['flytype'] = 2;
                $save['z'] = 9;
                $save['bs'] = 1;
                $save['qishu'] = $drawNumber;
                $save['content'] = $bet['content'];
                $save['dates'] = $bet['dates'];
                $save['time'] = $bet['time'];
                $save['abcd'] = 'A';
                $save['ab'] = 'A';
                $save['sv'] = 7;
                $save['bz'] = $bet['code'].'|'.$site['name'].'|'.$tmpacc['username'];
                $save['dftype'] = $bet['dftype'];
                $save['cy'] = $bet['cy'];
                $save['uzp6'] = $site['id'];
                $cys = explode('_',$bet['cy']);
                $saves[] = $save;
                $tempbet = ['amount'=>$save['je'],'game'=>$cys[0],'contents'=>$cys[1]];
                if($chai_money > 0 && $je > $chai_money) {
                    $moneys = $this->chaimoney($je,$chai_money);
                    foreach ($moneys as $money){
                        $tempbet['fcode'] = $save['code'];
                        $tempbet['bz'] = $save['bz'];
                        $tempbet['amount'] = ceil($money);
                        $betsave[$bet['abcd']][] = $tempbet;
                    }
                }else{
                    $tempbet['fcode'] = $save['code'];
                    $tempbet['bz'] = $save['bz'];
                    $tempbet['amount'] = ceil($tempbet['amount']);
                    $betsave[$bet['abcd']][] = $tempbet;
                }
            }
            if(count($saves) > 0){
                $libflymode->insert($saves);
                $keys = array_keys($abcdacc);
                if(count($keys) <= 1){
                    $bet = [];
                    foreach ($betsave as $b){
                        array_push($bet,...$b);
                    }
                    //self::sgbet($site,$acc,$bet,$drawNumber,$lottery);
                    if($fuser['outbet_mode'] == 1){//订单轮训模式
                        $outb = ['site'=>$site,'acc'=>$acc,'bet'=>$bet,'drawNumber'=>$drawNumber,'lottery'=>$lottery,'error'=>0];
                        $redis->lpush($outbet_redis_key,json_encode($outb));
                    }elseif ($fuser['outbet_mode'] == 3){//分段模式
                        $fdkey = "fdlist_{$gid}_{$drawNumber}_{$site['id']}_{$acc['id']}_{$opentime}_{$closetime}_{$fenduan}_{$lottery}";
                        $redis->lpush($fdkey,json_encode($bet));
                    }
                }else{
                    foreach ($betsave as $abcd=>$bet){
                        if(isset($abcdacc[$abcd])) {
                            $acc = $abcdacc[$abcd];
                        }
                        //self::sgbet($site,$acc,$bet,$drawNumber,$lottery);
                        if($fuser['outbet_mode'] == 1) {
                            $outb = ['site'=>$site,'acc'=>$acc,'bet'=>$bet,'drawNumber'=>$drawNumber,'lottery'=>$lottery,'error'=>0];
                            $redis->lpush($outbet_redis_key,json_encode($outb));
                        }elseif ($fuser['outbet_mode'] == 3){
                            $fdkey = "fdlist_{$gid}_{$drawNumber}_{$site['id']}_{$acc['id']}_{$opentime}_{$closetime}_{$fenduan}_{$lottery}";
                            $redis->lpush($fdkey,json_encode($bet));
                        }
                    }
                }
            }
        }
    }

    public function tmfantou($list,$fenlei){
        $map = [];$newmap = [];
        if($fenlei == 107){
            $tmarr1 = ['B1','B2','B3','B4','B5','B6','B7','B8','B9','B10'];
            $tmarr2 = ['1','2','3','4','5','6','7','8','9','10'];
        }elseif ($fenlei == 101) {
            $tmarr1 = ['B1','B2','B3','B4','B5'];
            $tmarr2 = ['0','1','2','3','4','5','6','7','8','9'];
        }
        foreach ($list as $item){
            if(in_array($item['cy1'],$tmarr1)) {
                if(!isset($map[$item['cy1']])){
                    $map[$item['cy1']] = [];
                }
                $map[$item['cy1']][$item['cy']] = $item['je'];
            }
        }
        foreach ($tmarr1 as $tm){
            if(isset($map[$tm])){
                $hmarr = [];
                foreach ($tmarr2 as $hm){
                    $hmarr[$tm.'_'.$hm] = 0;
                }
                $myhmarr = $map[$tm];
                foreach ($myhmarr as $hm=>$je){
                    foreach ($hmarr as $k=>$hmje){
                        if($hm != $k){
                            $hmarr[$k] += $je;
                        }
                    }
                }
                //去除金额为0的号码
                foreach ($hmarr as $hm=>$je){
                    if($je > 0){
                        $newmap[$hm] = $je;
                    }
                }
            }
        }
        return $newmap;
    }

    public function fantouhandler($orders,$dftypejson,$fenlei){
        $dftypeorders = [];
        $dftypeminje = [];
        $neworders = [];$cy1arr = [];
        foreach ($orders as $order){
            $dftypeorders[$order['cy1']][] = $order;
            if(!isset($dftypeminje[$order['cy1']])){
                $dftypeminje[$order['cy1']] = $order['je'];
            }else{
                //比较最小金额
                if($order['je'] < $dftypeminje[$order['cy1']]){
                    $dftypeminje[$order['cy1']] = $order['je'];
                }
            }
            //存储cy1
            $cy1arr[] = $order['cy1'];
        }
        $cy1arr = array_unique($cy1arr);
        foreach ($cy1arr as $cy1){
            if(!isset($dftypeorders[$cy1]) || count($dftypeorders[$cy1]) <= 0){
                continue;
            }
            if(!in_array($cy1,['B1','B2','B3','B4','B5','B6','B7','B8','B9','B10']) && !in_array($cy1,['GDX','GDS','DS1','DX1','DS2','DX2','DS3','DX3','DS4','DX4','DS5','DX5','DS6','DX6','DS7','DX7','DS8','DX8','DS9','DX9','DS10','DX10','LH1','LH2','LH3','LH4','LH5','LH','ZDX','ZDS','WDX1','HDS1','WDX2','HDS2','WDX3','HDS3','WDX4','HDS4','WDX5','HDS5','ZWDX'])) {//1-10名
               $neworders = array_merge($neworders,$dftypeorders[$cy1]);
                continue;
            }
            $temporders = $dftypeorders[$cy1];
            $minje = $dftypeminje[$cy1];
            //去重，当前订单金额减去最小金额，如果为0则不加入订单列表
            foreach ($temporders as &$o){
                if($o['je'] > $minje){
                    $eje = $o['je']-$minje;
                    $o['je'] = $minje;
                    $o['flag'] = 0;
                    $neworders[] = $o;
                    $o['je'] = $eje;
                    $o['flag'] = 1;
                    $neworders[] = $o;
                }else{
                    $neworders[] = $o;
                }
            }
        }
        return $neworders;
    }

    public function ftmaxma($orders,$fenlei){
        $dftypeorders = [];
        $neworders = [];
        $cy1arr = [];
        foreach ($orders as $order){
            $dftypeorders[$order['cy1']][] = $order;
            //存储cy1
            $cy1arr[] = $order['cy1'];
        }
        //去重cy1
        $cy1arr = array_unique($cy1arr);
        foreach ($cy1arr as $cy){
            if(!isset($dftypeorders[$cy]) || count($dftypeorders[$cy]) <= 0){
                continue;
            }
            if(($fenlei == 107 && in_array($cy,['GYH'])) || ($fenlei == 101 && in_array($cy,['LH','TS']))){
                $neworders = array_merge($neworders,$dftypeorders[$cy]);
                continue;
            }
            $temporders = $dftypeorders[$cy];
            $isquchong = false;
            if(in_array($cy,['B1','B2','B3','B4','B5','B6','B7','B8','B9','B10'])){//1-10名
                $isquchong = true;
            }
            if($isquchong == false){
                $neworders = array_merge($neworders,$temporders);
                continue;
            }
            array_multisort(array_column($temporders, 'je'), SORT_DESC, $temporders);
            if(count($temporders) <= 5){
                $tmpos = $temporders;
            }else{
                $tmpos = array_slice($temporders,0,5);
            }
            //取最大金额
            $pinjunje = 0;
            foreach ($tmpos as $o1){
                $pinjunje += $o1['je'];
            }
            $pinjunje = $pinjunje / count($tmpos);
            $pinjunje = ceil($pinjunje);
            //赋值新的金额
            foreach ($tmpos as &$o){
                $o['je'] = $pinjunje;
            }
            $neworders = array_merge($neworders,$tmpos);
        }
        return $neworders;
    }

    //去重玩法合并金額
    public function quchongdingdan($orders,$dftypejson,$fenlei){
        $dftypeorders = [];
        $dftypeminje = [];
        $neworders = [];
        $dftypetotalje = [];$cy1arr = [];
        $dftypearr = [];
        foreach ($orders as $order){
            $dftypeorders[$order['cy1']][] = $order;
            $dftypetotalje[$order['cy1']] = isset($dftypetotalje[$order['cy1']]) ? $dftypetotalje[$order['cy1']] + $order['je'] : $order['je'];
            if(!isset($dftypeminje[$order['cy1']])){
                $dftypeminje[$order['cy1']] = $order['je'];
            }else{
                //比较最小金额
                if($order['je'] < $dftypeminje[$order['cy1']]){
                    $dftypeminje[$order['cy1']] = $order['je'];
                }
            }
            //存储cy1
            $cy1arr[] = $order['cy1'];
        }
        //打印最小金额列表
        //Log::info("最小金额列表：".json_encode($dftypeminje));
        //去重cy1
        $cy1arr = array_unique($cy1arr);
        foreach ($cy1arr as $cy){
            if(!isset($dftypeorders[$cy]) || count($dftypeorders[$cy]) <= 0){
                continue;
            }
            if(($fenlei == 107 && in_array($cy,['GYH'])) || ($fenlei == 101 && in_array($cy,['LH','TS']))){
                $neworders = array_merge($neworders,$dftypeorders[$cy]);
                continue;
            }
            $ordercount = count($dftypeorders[$cy]);
            $temporders = $dftypeorders[$cy];
            $isquchong = false;
            $minje = $dftypeminje[$cy];
            //Log::info("最小金额：".$minje."|".$cy."|".$ordercount."|".$fenlei);
            if(in_array($cy,['B1','B2','B3','B4','B5','B6','B7','B8','B9','B10']) && $ordercount == 10){//1-10名
                $isquchong = true;
            }elseif (in_array($cy,['GDX','GDS','DS1','DX1','DS2','DX2','DS3','DX3','DS4','DX4','DS5','DX5','DS6','DX6','DS7','DX7','DS8','DX8','DS9','DX9','DS10','DX10','LH1','LH2','LH3','LH4','LH5','LH','ZDX','ZDS','WDX1','HDS1','WDX2','HDS2','WDX3','HDS3','WDX4','HDS4','WDX5','HDS5','ZWDX']) && $ordercount == 2){//
                $isquchong = true;
            }
            if($isquchong == false){
                $neworders = array_merge($neworders,$temporders);
                continue;
            }
            //去重，当前订单金额减去最小金额，如果为0则不加入订单列表
            foreach ($temporders as &$order){
                $order['totalje'] = $dftypetotalje[$cy];
                $order['je'] = $order['je']-$minje;
                if($order['je'] > 0){
                    $neworders[] = $order;
                }
            }
        }
        return $neworders;
    }

    public function hebingbet($ruid,$gid,$qishu){
        $db = Db::connection();
        $game = Game::where('gid',$gid)->select(['lottery','dftype','fenlei'])->first();
        $dftypejson = json_decode($game['dftype'],true);
        $outsitelist = OutbetSite::where(['ruid'=>$ruid,'main_fu_type'=>1,'order_mode'=>1,'is_gentoumode'=>1])->get();
        $table = SGUtils::getcuretable(true);
        $flytable = SGUtils::getcureflytable(true);
        foreach ($outsitelist as $site){
            //Log::info("开始合并飞单2：".$site['name']);
            if($site['enabled'] == 0 || $site['online'] == 0){
                //判断是否有副站
                $site = OutbetSite::where(['ruid'=>$ruid,'main_fu_type'=>2,'order_mode'=>1,'main_site_id'=>$site['id'],'enabled'=>1,'online'=>1])->first();
                if(empty($site)){
                    continue;
                }
            }
            $gids = explode(',',$site['gids']);
            if(!in_array($gid,$gids)){
                continue;
            }
            $sqlw = " ruid = {$ruid} and gid='{$gid}' and qishu='{$qishu}' and z = 9 and ignore_outbet = 0";
            if (!empty($site["zhidinguser"])) {
                $zuser = explode(',', $site["zhidinguser"]);
                $userids = User::where('ruid',$ruid)->whereIn('username',$zuser)->pluck('userid')->toArray();
                $insert_userids = [];
                /* foreach ($userids as $v) {
                    $uidarr[] = " userid=".$v;
                } */
                $insert_userids = implode(',',$userids);
                if (!empty($insert_userids)) {
                    $sqlw .= " and userid in ({$insert_userids}) ";
                }
            }
            if($site['start_money'] > 0){
                $sqlw .= " and je>=".$site['start_money'];
            }
            $count = $db->select("select count(id) as c from $flytable where ruid='{$ruid}' and gid='{$gid}' and qishu='{$qishu}' and siteid='{$site['id']}'");
            //Log::info("合并飞单3：".$count[0]['c']);
            if($count[0]['c'] > 0){
                continue;
            }
            $list = $db->select("select bid,sid,cid,pid,dftype,sum(je) as je,peilv1,cy,count(id) as count from $table where {$sqlw} group by cy");
            //Log::info("合并飞单4：".json_encode($list));
            if(empty($list)){
                continue;
            }
            //Log::info("合并订单笔数：".$list[0]['count'].'期数：'.$qishu.'gid：'.$gid.' sql:'."select bid,sid,cid,pid,dftype,$ss as je,sum(je) as zje,peilv1,dates,abcd,cy,count(id) as count from $table where gid='{$gid}' and qishu='{$qishu}' {$sqlw} group by $groupstr");
            foreach ($list as &$o) {
                $o['cy1'] = explode('_', $o['cy'])[0];
            }
            if($site['is_quchong'] == 1){//合并去重订单
                $list = $this->quchongdingdan($list,$dftypejson,$game['fenlei']);
            }
            //$tmftmap = $this->tmfantou($list,$game['fenlei']);
            //Log::info('合并飞单1：'.json_encode($list));
            if($site['ft_max_ma'] == 1){//合并飞单
                $list = $this->ftmaxma($list,$game['fenlei']);
            }
            //Log::info('合并飞单2：'.json_encode($list));
            if($site['indicator'] == 0){//反跟
                $list = $this->fantouhandler($list,$dftypejson,$game['fenlei']);
            }
            //Log::info('合并飞单3：'.json_encode($list));
            $total = 0;$chai_money = $site['chai_money'];$tmpbets = [];
            $tmplist = $list;
            foreach ($tmplist as $k=>&$torder){
                $je = $torder['je'];
                $je = $site['flyjiabei']*$je;//飞单倍数
                $total += $je;

                //是否是反跟
                if($site['indicator'] == 0){//反跟
                    $mclass = CommonCache::getclasscache($gid,$torder['cid']);
                    $dftype = $mclass['dftype'];
                    if($dftypejson[$dftype] == '两面' || $dftypejson[$dftype] == '双面' || $dftypejson[$dftype] == '1-10名双面' || $dftypejson[$dftype] == '1-5双面' || $dftypejson[$dftype] =='总和两面' || $dftypejson[$dftype] =='冠亚军和大小' || $dftypejson[$dftype] =='冠亚军和单双'){
                        $tpp = Play::where(['gid'=>$gid,'bid'=>$torder['bid'],'cid'=>$torder['cid']])->where('pid','<>',$torder['pid'])->select(['cy','pid'])->first();
                        $torder['pid'] = $tpp['pid'];
                        $torder['cy'] = $tpp['cy'];
                        $tmpbets[] = $torder;
                    }elseif ($dftypejson[$dftype] == '1-5球号' || $dftypejson[$dftype] == '1-10车号'){
                        $key = 'flybdlist_'.$gid.'_'.$torder['bid'].'_'.$torder['cid'].'_'.$torder['pid'];
                        $playlist = Cache::get($key);
                        if(empty($playlist)){
                            $playlist = Play::where(['gid'=>$gid,'bid'=>$torder['bid'],'cid'=>$torder['cid']])->where('pid','<>',$torder['pid'])->select(['cy','pid'])->orderByDesc('pid')->get()->toArray();
                            Cache::put($key,$playlist,24*60*60);
                        }
                        foreach ($playlist as $play){
                            $tmplist[$k]['pid'] = $play['pid'];
                            $tmplist[$k]['cy'] = $play['cy'];
                            $tmpbets[] = $torder;
                        }
                        unset($tmplist[$k]);
                        /*if(!isset($tmpp[$torder['cy1']])) {
                            foreach ($tmftmap as $tm=>$jee){
                                $tpp = Play::where(['gid'=>$gid,'cy'=>$tm])->select(['pid'])->first();
                                $tmporder = $torder;
                                $tmporder['pid'] = $tpp['pid'];
                                $tmporder['cy'] = $tm;
                                $tmporder['je'] = $jee;
                                $tmporder['cy1'] = explode('_', $tm)[0];
                                $tmpbets[] = $tmporder;
                            }
                            $tmpp[$torder['cy1']] = 1;
                        }*/
                    }elseif ($dftypejson[$dftype] == '龙虎和' && ($torder['pid'] == 25585014 || $torder['pid'] == 25585015)){
                        $tpp = Play::where(['gid'=>$gid,'bid'=>$torder['bid'],'cid'=>$torder['cid']])->where('pid','<>',$torder['pid'])->where('pid','<>',25585016)->select(['cy','pid'])->first();
                        $torder['pid'] = $tpp['pid'];
                        $torder['cy'] = $tpp['cy'];
                        $tmpbets[] = $torder;
                    }else{
                        if($site['indicator_hl'] == 0){
                            $tmpbets[] = $torder;
                        }
                    }
                }else{
                    $tmpbets[] = $torder;
                }
            }
            //打印tmpbets
            //Log::info("合并飞单3：".json_encode($tmpbets));
            $tmplist = $tmpbets;
            //打印tmplist
            //Log::info("合并飞单4：".json_encode($tmplist));
            //去重
            if($site['is_quchong'] == 1){
                //先将所有的pid一样的数据合并
                $tmporders = [];
                foreach ($tmplist as $order){
                    if(!isset($tmporders[$order['cy']])) {
                        $tmporders[$order['cy']] = $order;
                    }else{
                        $tmporders[$order['cy']]['je'] += $order['je'];
                        $tmporders[$order['cy']]['zje'] += $order['zje'];
                        $tmporders[$order['cy']]['count'] += $order['count'];
                    }
                }
                $tmplist = array_values($tmporders);
                /*foreach ($tmplist as &$oo) {
                    $oo['cy1'] = explode('_', $oo['cy'])[0];
                }*/
                //Log::info("开始去重：".json_encode($tmplist));
                $tmplist = $this->quchongdingdan($tmplist,$dftypejson,$game['fenlei']);
                //Log::info("结束去重：".json_encode($tmplist));
            }
            $bets = [];$saves = [];$libflymode = SGUtils::getcureflymodel();
            foreach ($tmplist as $order){
                $je = $site['flyjiabei']*$order['je'];//飞单倍数
                $save = [];
                $save['ruid'] = $site['userid'];
                $save['orderno'] = ComFunc::getNewOrderId("OX");
                $save['gid'] = $gid;
                $save['qishu'] = $qishu;
                $save['bid'] = $order['bid'];
                $save['sid'] = $order['sid'];
                $save['cid'] = $order['cid'];
                $save['pid'] = $order['pid'];
                $save['old_count'] = $order['count'];
                $save['old_je'] = $order['je'];
                $save['je'] = ceil($je);
                $save['status'] = 2;
                $save['siteid'] = $site['id'];
                $save['type'] = $site['order_mode'];
                //$save['dftype'] = $order['dftype'];
                //$save['cy'] = $order['cy'];
                $cys = explode('_',$order['cy']);
                $saves[] = $save;
                if($chai_money > 0 && $save['je'] > $chai_money) {
                    $moneys = $this->chaimoney($save['je'],$chai_money);
                    foreach ($moneys as $money){
                        $tempbet = [];
                        $tempbet['game'] = $cys[0];
                        $tempbet['contents'] = $cys[1];
                        $tempbet['odds'] = $order['peilv1'];
                        $tempbet['title'] = "";
                        $tempbet['orderno'] = $save['orderno'];
                        $tempbet['amount'] = ceil($money);
                        $bets[] = $tempbet;
                    }
                }else{
                    $tempbet = [];
                    $tempbet['game'] = $cys[0];
                    $tempbet['contents'] = $cys[1];
                    $tempbet['odds'] = $order['peilv1'];
                    $tempbet['title'] = "";
                    $tempbet['orderno'] = $save['orderno'];
                    $tempbet['amount'] = ceil($save['je']);
                    $bets[] = $tempbet;
                }
            }
            if(count($saves) > 0){
                $libflymode->insert($saves);
                $outb = ['site'=>$site,'bets'=>$bets,'drawNumber'=>$qishu,'lottery'=>$game['lottery'],'gid'=>$gid,'error'=>0];
                //Task::deliver(new OutbetRunOrderQueue($outb));
                $this->dajibet($outb,2);
            }
        }
    }

    public function chaimoney($money,$chai_money){
        $moneys = [];
        $m = $money%$chai_money;
        if($m > 0){
            $moneys[] = $m;
        }
        $n = floor($money/$chai_money);
        for ($i=0;$i<$n;$i++){
            $moneys[] = $chai_money;
        }
        return $moneys;
    }

    //切换站点
    public function switch_site($param,$type = 1,$teshu = 0){
        $site = $param['site'];
        $bets = $param['bet'];
        $fusite = OutbetSite::where(['main_fu_type'=>2,'main_site_id'=>$site['id'],'enabled'=>1])->first();
        $accs = OutbetAccs::where(['siteid'=>$fusite['id'],'enabled'=>1,'online'=>1])->get()->toArray();
        if(empty($accs)){
            return false;
        }
        //随机取一个账号
        $acc = $accs[array_rand($accs)];
        $param['acc'] = $acc;
        $param['site'] = $fusite;

        //查询飞单注单
        $libflymode = SGUtils::getcureflymodel();
        foreach ($bets as $k=>$bet){
            $flyorder = $libflymode->where(['code'=>$bet['fcode']])->first();
            $bzarr = explode('|',$flyorder['bz']);
            $flyorder->bz = $bzarr[0].'|'.$fusite['name'].'|'.$acc['username'];
            $flyorder->save();
            $bets[$k]['bz'] = $flyorder->bz;
        }
        //放入缓存
        $param['bet'] = $bets;
        if($teshu == 1){
            $this->sgbet($param,$type);
        }else{
            $redis = TaskRunOubet::getredis();
            if($type == 1){
                $outbet_redis_key = 'outbet_list';
                $redis->lpush($outbet_redis_key,json_encode($param));
            }else{
                $outbet_redis_key = $param['key'];
                $redis->lpush($outbet_redis_key,json_encode($bets));
            }
        }
    }

    public function sgbet($param,$type = 1){
        $outbet_error_status = x_config('outbet_error_status');
        if($type == 1){
            $param = json_decode($param,true);
            $outbet_redis_key = 'outbet_list';
            $error = $param['error'];
        }else{
            $outbet_redis_key = $param['key'];
            $errorkey = "fderror".$param['lottery'].$param['accid'].$param['drawNumber'];
            $error = Cache::get($errorkey,0);
        }
        $redis = TaskRunOubet::getredis();
        $ingore_tj = x_config('ingore_tj');
        $site = $param['site'];
        $acc = $param['acc'];
        $bet = $param['bet'];
        $drawNumber = $param['drawNumber'];
        $lottery = $param['lottery'];
        $cookie_jar = $acc['cookie'];
        $tempbet = $bet;$libflymode = SGUtils::getcureflymodel();
        if($outbet_error_status == 1){
            $outbet_error_msg = x_config('outbet_error_msg');
            foreach ($bet as $item){
                $fcode = $item['fcode'];
                $update = [
                    'sv' => 9,
                    'zcount' => time(),
                    'bz' => $item['bz'] . '|' . $outbet_error_msg
                ];
                //更新
                $libflymode->where('code', $fcode)->update($update);
            }
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'bet','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>$outbet_error_msg,'siteid'=>$site['id']]);
            return;
        }
        foreach ($bet as $k=>$v){
            unset($bet[$k]['fcode']);
            unset($bet[$k]['bz']);
            unset($bet[$k]['code']);
            unset($bet[$k]['orderId']);
        }
        $ftbet = $bet;
        $arr = [];
        $arr['lottery'] = $lottery;
        $arr['ignore'] = true;
        $arr['fastBets'] = false;
        $arr['drawNumber'] = $drawNumber;
        $arr['bets'] = $bet;
        if(empty($acc['curl']) || strpos($acc['curl'],'http') === false){
            $urls = OutbetSite::where('id',$acc['siteid'])->value('urls');
            $url = $this->randurl($urls);
            OutbetAccs::where('id',$acc['id'])->update(['curl'=>$url]);
            Log::info("飞单账号{$acc['username']}没有curl，重新获取curl：".$url);
        }else{
            $url = $acc['curl'];
        }
        $c_domain = str_replace('https://','',$url);
        $c_domain = str_replace('http://','',$c_domain);
        $c_domain = trim($c_domain,'/');
        $head = [];
        $head['host'] = str_replace('https://','',$url);
        $head['Origin'] = $url;
        $head['Referer'] = $url.'/member/index';
        $url = $url . "/member/bet";
        $starttime = time();
        //Log::info("投注数据：".json_encode($arr));
        try {
            $res = HttpUtils::curl('POST',false,$cookie_jar,$url,$arr,$head,true,true,true,$acc['id']);
        }catch (\Exception $e){
            $message = $e->getMessage();
            OutbetAccs::where('id',$acc['id'])->update(['cookie'=>'','curl'=>'','online'=>0]);
            $acc = OutbetAccs::where('id',$acc['id'])->first();
            $this->sglogin($site,$acc);
        }
        $jsondata = json_decode($res, true);
        if(!empty($jsondata) && isset($jsondata['message']) && $jsondata['message'] == 'orderId已存在'){
            //再投一次
            $res = HttpUtils::curl('POST',false,$cookie_jar,$url,$arr,$head,true,true,true,$acc['id']);
            $jsondata = json_decode($res, true);
            Log::info("飞单投注返回：orderId已存在，再投一次");
        }
        if(env('IS_DEBUG_INFO')) {
            Log::info('飞单投注返回：' . json_encode($res));
        }
        $endtime = time();
        if(env('IS_SHOW_FLYINFO')){
            Log::info("count:{$error}飞单投注耗时：".($endtime-$starttime).'秒'.'，url：'.$url);
        }
        $erroe = 0;
        $reason = '';
        $isupdatez = 1;
        if($ingore_tj == 0){
            $cc = CustomDomain::where('domain',$c_domain)->count('id');
            $cc > 0 && $isupdatez = 0;
        }
        if(empty($jsondata)){
            if($error < 3){
                $sitecc = OutbetSite::where(['main_fu_type'=>2,'main_site_id'=>$site['id'],'enabled'=>1])->count('id');
                if ($res && strpos($res, '用户登录') !== false) {
                    if($type == 1){
                        $param['error'] = $error+1;
                    }else{
                        Cache::set($errorkey,$error+1,600);
                    }
                    $key = 'outbet:login:'.$site['id'].':'.$acc['username'];
                    if(empty($key)){
                        $this->sglogin($site, $acc);
                    }else{
                        Log::info("用户正在登录,继续等待".$acc['username']);
                    }
                    if($sitecc > 0){
                        $this->switch_site($param,$type);
                    }else{
                        if($type == 1){
                            $redis->lpush($outbet_redis_key,json_encode($param));
                        }else{
                            $redis->lpush($outbet_redis_key,json_encode($param['bet']));
                        }
                    }
                    return;
                }
            }
            //从新让如队列执行
            if($error < 3){
                if($type == 1){
                    $param['error'] = $error+1;
                }else{
                    Cache::set($errorkey,$error+1,600);
                }
                if($sitecc > 0){
                    $this->switch_site($param,$type);
                }else{
                    $redis->lpush($outbet_redis_key,json_encode($param));
                }
                return;
            }
            //抛出异常上级捕获
            Log::info("网站方返回空数据,error:{$error}：".$res."投注数据".json_encode($arr));
            $erroe = 1;
            $reason = '网站方异常';
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'bet','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'网站方异常','siteid'=>$site['id']]);
            //关闭账号
            //OutbetAccs::where('id',$acc['id'])->update(['online'=>0]);
        }else{
            if(isset($jsondata['status']) && $jsondata['status'] == 0){
                if (isset($jsondata['account'])){
                    $balance = isset($jsondata['account']['balance']) ? $jsondata['account']['balance'] : 0;
                    $betting = isset($jsondata['account']['betting']) ? $jsondata['account']['betting'] : 0;
                    $result = isset($jsondata['account']['result']) ? $jsondata['account']['result'] : 0;
                    OutbetAccs::where('id',$acc['id'])->update(['bz'=>$balance.'|'.$betting.'|'.$result]);
                    Cache::set('updateaccbalance_'.$site['id'].'_'.$acc['id'],1,rand(5,15));
                }
                //添加大数据返投
                try {
                    if($ingore_tj == 0 && $isupdatez == 1) {
                        $this->adddsjft($ftbet, $lottery, $drawNumber);
                    }
                }catch (\Exception $e){
                    Log::info('添加大数据返投异常：'.$e->getMessage());
                }
            }else{
                $erroe = 1;
                if(isset($jsondata['message'])){
                    $reason = $jsondata['message'];
                    //如果包含禁止投注，更换账号
                    if(strpos($reason,'禁止投注') !== false || strpos($reason,'暂停投注') !== false || strpos($reason,'冻结') !== false){// || strpos($reason,'投注超出') !== false
                        if($type == 1){
                            $param['error'] = $error+1;
                        }else{
                            Cache::set($errorkey,$error+1,600);
                        }
                        OutbetAccs::where('id',$acc['id'])->update(['online'=>0,'enabled'=>0]);
                        $sitecc = OutbetSite::where(['main_fu_type'=>2,'main_site_id'=>$site['id'],'enabled'=>1])->count('id');
                        if($sitecc > 0){
                            $this->switch_site($param,$type);
                            return;
                        }
                    }
                    //如果账号提示暂停投注，关闭账号
                    /*if(strpos($reason,'暂停投注') !== false){
                        OutbetAccs::where('id',$acc['id'])->update(['online'=>0,'enabled'=>0]);
                    }*/
                    //如果字数大于50，截取前50个字
                    if(mb_strlen($reason,'utf-8') > 50){
                        $reason = mb_substr($reason,0,50,'utf-8');
                    }
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'bet','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>$jsondata['message'],'siteid'=>$site['id']]);
                }else{
                    if (isset($jsondata['status']) && $jsondata['status'] == 2){
                        $reason = '对方已封盘';
                    }else{
                        $reason = '未知错误';
                    }
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'bet','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>$res,'siteid'=>$site['id']]);
                }
            }
        }
        foreach ($tempbet as $item) {
            $fcode = $item['fcode'];
            if ($erroe == 1) {
                $update = [
                    'sv' => 9,
                    'zcount' => time(),
                    'bz' => $item['bz'] . '|' . $reason
                ];
            } else {
                $update = ['sv' => 8,'zcount' => time()];
                //是否包含忽略域名
                if($ingore_tj == 0 && $isupdatez == 1){
                    $update['z'] = 11;
                }
            }
            //更新
            $libflymode->where('code', $fcode)->update($update);
        }
        /*if (!empty($fcodes)) {
            $libflymode->whereIn('code', $fcodes)->each(function ($item) use ($updates) {
                if (isset($updates[$item->code])) {
                    $item->update($updates[$item->code]);
                }
            });
        }*/
    }

    //添加大数据返投
    public function adddsjft($ftbet,$lottery,$drawNumber){
        //是否开启大数据返投
        $is_open_dshujutj = x_config('is_open_dshujutj');
        if($is_open_dshujutj == 1){
            $ftredis = SGUtils::getftredis();
            $listkey = 'ftlist:'.$lottery.':'.$drawNumber;
            $ttmp = [];
            //过滤
            foreach ($ftbet as $k=>$v){
                if(!SGUtils::pdislmorball($v['game'])){
                    unset($ftbet[$k]);
                }
            }
            //合并同样的玩法
            $tsmp = [];
            foreach ($ftbet as $v){
                if(!isset($tsmp[$v['game'].'_'.$v['contents']])) {
                    $tsmp[$v['game'] . '_' . $v['contents']] = $v;
                }else{
                    $tsmp[$v['game'] . '_' . $v['contents']]['amount'] += $v['amount'];
                }
            }
            $ftbet = array_values($tsmp);
            //附加数据库id
            $gid = Game::where('lottery',$lottery)->value('gid');
            $dates = strtotime(ComFunc::getthisdate());
            foreach ($ftbet as &$ftbetitem){
                $cy = $ftbetitem['game'].'_'.$ftbetitem['contents'];
                if(!isset($ttmp[$gid.$ftbetitem['game']])){
                    $ttmp[$gid.$ftbetitem['game']] = Play::where(['gid'=>$gid,'cy'=>$cy])->select(['pid','bid','sid','cid','peilv1','cy'])->first();
                }
                $pp = $ttmp[$gid.$ftbetitem['game']];
                if(!empty($pp)){
                    $ftbetitem['bid'] = $pp['bid'];
                    $ftbetitem['sid'] = $pp['sid'];
                    $ftbetitem['cid'] = $pp['cid'];
                    $ftbetitem['pid'] = $pp['pid'];
                    $ftbetitem['peilv1'] = $pp['peilv1'];
                    $ftbetitem['cy'] = $pp['cy'];
                }
                //dftype查询
                $mclass = \App\ort\services\CommonCache::getclasscache($gid,$pp['cid']);
                $ftbetitem['dftype'] = $mclass['dftype'];
                $ftbetitem['je'] = $ftbetitem['amount'];
                $ftbetitem['zje'] = $ftbetitem['amount'];
                $ftbetitem['dates'] = $dates;
                $ftbetitem['abcd'] = 'A';
                $ftbetitem['count'] = 1;
            }
            //放入redis
            if(count($ftbet) > 0){
                $ftredis->lpush($listkey,json_encode($ftbet));
            }
        }
    }

    public function sgapibet($param,$type = 1){
        $outbet_error_status = x_config('outbet_error_status');
        if($type == 1){
            $param = json_decode($param,true);
            $outbet_redis_key = 'outbet_list';
            $error = $param['error'];
        }else{
            $outbet_redis_key = $param['key'];
            $errorkey = "fderror".$param['lottery'].$param['accid'].$param['drawNumber'];
            $error = Cache::get($errorkey,0);
        }
        $redis = TaskRunOubet::getredis();
        $site = $param['site'];
        $acc = $param['acc'];
        $bet = $param['bet'];
        $drawNumber = $param['drawNumber'];
        $lottery = $param['lottery'];
        $tempbet = $bet;$libflymode = SGUtils::getcureflymodel();
        if($outbet_error_status == 1){
            $outbet_error_msg = x_config('outbet_error_msg');
            foreach ($bet as $item){
                $fcode = $item['fcode'];
                $update = [
                    'sv' => 9,
                    'zcount' => time(),
                    'bz' => $item['bz'] . '|' . $outbet_error_msg
                ];
                //更新
                $libflymode->where('code', $fcode)->update($update);
            }
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'bet','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>$outbet_error_msg,'siteid'=>$site['id']]);
            return;
        }
        foreach ($bet as $k=>$v){
            $bet[$k]['orderId'] = $v['fcode'];
            unset($bet[$k]['fcode']);
            unset($bet[$k]['bz']);
            unset($bet[$k]['code']);
            unset($bet[$k]['odds']);
            unset($bet[$k]['title']);
        }
        $ftbet = $bet;
        $arr = [];
        $arr['lottery'] = $lottery;
        $arr['drawNumber'] = $drawNumber;
        //相同玩法合并
        $arr['bets'] = $this->hbplay($bet);
        if(empty($acc['curl'])){
            $url = $this->randurl($site['urls']);
            OutbetAccs::where('id',$acc['id'])->update(['curl'=>$url]);
            Log::info("飞单账号{$acc['username']}没有curl，重新获取curl：".$url);
        }else{
            $url = $acc['curl'];
        }
        $secretKey = $acc['sg_secretkey'];
        $issuedAt = time();
        $expirationTime = $issuedAt + 300; // Token有效期为5分钟
        $kid = $acc['sg_kid']; // 密钥ID
        // JWT负载
        $payload = ['iat' => $issuedAt,'exp' => $expirationTime];
        // 生成JWT
        $token = JWT::encode($payload, $secretKey, 'HS256', $kid);
        $headers = ['Authorization' => 'Bearer '.$token];
        $url = $url . "/api/v1/bet";
        $starttime = time();
        try {
            $res = HttpUtils::request('POST',$url,$arr,$headers,true);
        }catch (\Exception $e){
            $res = '';
            Log::info("投注异常：".$e->getMessage());
        }
        $jsondata = json_decode($res['data'], true);
        if(env('IS_DEBUG_INFO')) {
            Log::info('飞单投注返回：' . json_encode($res));
        }
        $endtime = time();
        if(env('IS_SHOW_FLYINFO')){
            Log::info("count:{$error}飞单投注耗时：".($endtime-$starttime).'秒'.'，url：'.$url);
        }
        if(empty($jsondata)){
            if($error < 3){
                if($type == 1){
                    $param['error'] = $error+1;
                }else{
                    Cache::set($errorkey,$error+1,600);
                }

                if($type == 1){
                    $redis->lpush($outbet_redis_key,json_encode($param));
                }else{
                    $redis->lpush($outbet_redis_key,json_encode($param['bet']));
                }
                return;
            }
        }
        $erroe = 0;
        $reason = '';
        if($jsondata['code'] != 0){
            $sitecc = OutbetSite::where(['main_fu_type'=>2,'main_site_id'=>$site['id'],'enabled'=>1])->count('id');
            Log::info($res['data'].$error);
            //Log::info(json_encode($arr));
            if($jsondata['code'] == 1006 || $jsondata['code'] == 2013){//重新放入队列
                if($error < 6){
                    if($type == 1){
                        $param['error'] = $error+1;
                    }else{
                        Cache::set($errorkey,$error+1,600);
                    }
                    //重新生成orderid
                    /*foreach ($tempbet as $k=>$v){
                        $tempbet[$k]['fcode'] = ComFunc::getNewOrderId(date("YmdH"));
                    }*/
                    $param['bet'] = $tempbet;
                    if($sitecc > 0 && $error > 3){
                        $this->switch_site($param,$type,1);
                    }else{
                        if($type == 1){
                            $redis->lpush($outbet_redis_key,json_encode($param));
                        }else{
                            $redis->lpush($outbet_redis_key,json_encode($param['bet']));
                            //$this->sgapibet($param,2);
                        }
                    }
                    return;
                }
            }
            $erroe = 1;
            $reason = $jsondata['message'];
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'bet','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>$jsondata['message'],'siteid'=>$site['id']]);
        }else{
            //添加大数据返投
            try {
                $this->adddsjft($ftbet,$lottery,$drawNumber);
            }catch (\Exception $e){
                Log::info('添加大数据返投异常：'.$e->getMessage());
            }
        }
        foreach ($tempbet as $item) {
            $fcode = $item['fcode'];
            if ($erroe == 1) {
                $update = [
                    'sv' => 9,
                    'zcount' => time(),
                    'bz' => $item['bz'] . '|' . $reason
                ];
            } else {
                $update = [
                    'sv' => 8,
                    'zcount' => time(),
                    'z' => 11
                ];
            }
            //更新
            $libflymode->where('code', $fcode)->update($update);
        }
    }

    public function hbplay($bet){
        $newbet = [];
        foreach ($bet as $b){
            $key = $b['game'].$b['contents'];
            if(!isset($newbet[$key])){
                $newbet[$key] = $b;
                $newbet[$key]['orderId'] = ComFunc::getNewOrderId("MK");
            }else{
                $newbet[$key]['amount'] = ceil($newbet[$key]['amount']+$b['amount']);
            }
        }
        return array_values($newbet);
    }

    public function sglogin($site,$acc){
        $key = 'outbet:login:'.$site['id'].':'.$acc['username'];
        $ks = Cache::get($key);
        if(!empty($ks)){
            Log::info('账号：'.$acc['username'].'，已经在登录中');
            return;
        }
        //缓存
        Cache::set($key,1,8);
        if($acc['errors'] >= 5){
            Log::info('账号：'.$acc['username'].'，错误次数超过5次，关闭账号，请在浏览器中登录测试');
            OutbetAccs::where('id',$acc['id'])->update(['enabled'=>0,'online'=>0]);
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'错误次数超过5次，关闭账号，请在浏览器中登录测试','siteid'=>$site['id']]);
            return;
        }
        //获取验证码
        if(empty($acc['curl'])){
            $baseurl = $this->randurl($site['urls']);
            OutbetAccs::where('id',$acc['id'])->update(['curl'=>$baseurl]);
        }else{
            $baseurl = $acc['curl'];
        }
        $ip = $acc['ip'];
        if($site['type'] == 'SGWIN'){
            $imageurl = $baseurl.'/code?'.time();
            $base64 = CommonUtils::url_to_base64($imageurl,$ip,$acc['id']);
            if(empty($base64)){
                Log::info("base64获取失败,count:{$acc['errors']}，账号：".$acc['username']."url:".$imageurl);
                $updateacc = [];
                $updateacc['errors'] =  DB::raw('errors+1');
                OutbetAccs::where('id',$acc['id'])->update($updateacc);
                return false;
            }
            $code = $this->commoncode($base64);
            Log::info('验证码：'.$code);
            if(empty($code)){
                Log::info("验证码获取失败，账号：".$acc['username']."url:".$imageurl);
                $updateacc = [];
                $updateacc['errors'] =  DB::raw('errors+1');
                OutbetAccs::where('id',$acc['id'])->update($updateacc);
                Log::info('对外飞单-login，信息：'.json_encode($site).'-'.json_encode($acc).'获取验证码失败');
                return false;
            }
            $url = $baseurl . "/login";
            $post = ['type' => '1', 'account' => $acc['username'], 'password' => $acc['password'], 'code' => $code];
        }else{
            //先访问首页
            $url = $baseurl . "/main";
            HttpUtils::curl('GET',true,'',$url,[],[],true,true,false,$acc['id']);
            $url = $baseurl . "/cashlogin";
            $post = ['account' => $acc['username'], 'password' => $acc['password']];
        }

        $cookie_jar = OutbetAccs::where('id',$acc['id'])->value('cookie');
        $result = HttpUtils::curl('POST',true,$cookie_jar,$url,$post,[],true,true,false,$acc['id']);
        Log::info('对外飞单-login，信息：'.json_encode($site).'-'.json_encode($acc).$result);
        //访问授权页面
        $updateacc = [];
        if($site['type'] == 'SGWIN2'){
            $result = json_decode($result,true);
            if($result['success']){
                if(!isset($result['data'])){
                    $url = $baseurl . "/member/agreement?".$result['message'];
                }else{
                    $url = $baseurl . "/member/agreement";
                }
                $updateacc['online'] = 1;
                $updateacc['errors'] = 0;
                Cache::set($key,1,8);
                HttpUtils::curl('GET',true,$cookie_jar,$url,[],[],true,true,false,$acc['id']);
            }else{
                $updateacc['online'] = 0;
                $updateacc['errors'] =  DB::raw('errors+1');
                $updateacc['bz'] = '';
                OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>$result['message'],'siteid'=>$site['id']]);
            }
        }else{
            if (strpos($result, '验证码错误') !== false) {
                $updateacc['online'] = 0;
                $updateacc['errors'] =  DB::raw('errors+1');
                OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'验证码错误','siteid'=>$site['id']]);
            }else{
                if (strpos($result, '账号或密码错误') !== false) {
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'账号或密码错误','siteid'=>$site['id']]);
                    OutbetAccs::where('id',$acc['id'])->update(['enabled'=>0,'online'=>0]);
                    return false;
                }elseif (strpos($result, '你的帐号已被冻结') !== false) {
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'你的帐号已被冻结','siteid'=>$site['id']]);
                    OutbetAccs::where('id',$acc['id'])->update(['enabled'=>0,'online'=>0]);
                    return false;
                }elseif (strpos($result, '暂停投注') !== false) {
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'您已被暂停投注!','siteid'=>$site['id']]);
                    OutbetAccs::where('id',$acc['id'])->update(['enabled'=>0,'online'=>0]);
                    return false;
                }elseif (strpos($result, '账户已禁用') !== false) {
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'账户已禁用','siteid'=>$site['id']]);
                    OutbetAccs::where('id',$acc['id'])->update(['enabled'=>0,'online'=>0]);
                    return false;
                }elseif (strpos($result, '修改密码') !== false) {
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'请修改初始密码','siteid'=>$site['id']]);
                    OutbetAccs::where('id',$acc['id'])->update(['enabled'=>0,'online'=>0]);
                    return false;
                }elseif (strpos($result, '用户协议') !== false || strpos($result, 'agreement.css') !== false) {
                    $updateacc['online'] = 1;
                    $updateacc['errors'] = 0;
                    Cache::set($key,1,8);
                }elseif (strpos($result, '秒内只能登录一次') !== false || strpos($result, 'agreement.css') !== false) {
                    $updateacc['online'] = 0;
                    $updateacc['errors'] = 0;
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'15秒内只能登录一次','siteid'=>$site['id']]);
                    Cache::set($key,1,14);
                }else{
                    $updateacc['online'] = 0;
                    $updateacc['errors'] =  DB::raw('errors+1');
                    OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>'未知错误','siteid'=>$site['id']]);
                }
            }
        }
        OutbetAccs::where('id',$acc['id'])->update($updateacc);
    }

    public function sgupdateblance($site){
        $cookie_jar = $site['cookie'];
        if(empty($site['curl'])){
            $url = $this->randurl($site['urls']);
            OutbetSite::where('id',$site['id'])->update(['curl'=>$url]);
        }else{
            $url = $site['curl'];
        }
        $head = [];
        if($site['type'] == 'sgwin'){
            $head['host'] = str_replace('https://','',$url);
            //$head[':path'] = '/member/accounts?_='.time()*1000;
            $head['Referer'] = $url.'/member/load?lottery=SSCJSC&page=lm';
            $url = $url . "/member/accounts?_=".time()*1000;
        }elseif($site['type'] == 'daji'){
            $url = $url . "/member/account";
        }
        $updateacc = [];
        try {
            $res = HttpUtils::curl('GET',true,$cookie_jar,$url,[],$head,true,true,false,$acc['id']);
            //Log::info($acc['username'].'余额查询，信息：'.$res);
            //Log::info($acc['username'].'余额查询，信息：'.$res);
            //判断是否包含
            $resutl = json_decode($res, true);
            if(empty($resutl)){
                if ($res && (strpos($res, '用户登录') !== false || strpos($res,'If you are the site owner') !== false)) {
                    $this->sglogin($site,$acc);
                }elseif ($site['type'] == 'SGWIN2') {
                    $this->sglogin($site,$acc);
                }
                return false;
            }
            if($site['type'] == 'SGWIN'){
                $resutl = $resutl[0];
                $balance = $resutl['balance'];
                $betting = isset($resutl['betting']) ? $resutl['betting'] : 0;
                $sy = isset($resutl['result']) ? $resutl['result'] : 0;
            }elseif ($site['type'] == 'SGWIN2') {
                $balance = $resutl['balance'];
                $betting = isset($resutl['betting']) ? $resutl['betting'] : 0;
                $sy = isset($resutl['result']) ? $resutl['result'] : 0;
            }
            $updateacc['errors'] = 0;
            $updateacc['bz'] = $balance.'|'.$betting.'|'.$sy;
            $updateacc['updatetime'] = time();
            $updateacc['online'] = 1;
            Cache::set('updateaccbalance_'.$site['id'].'_'.$acc['id'],1,rand(5,15));
            count($updateacc) > 0 && OutbetAccs::where('id',$acc['id'])->update($updateacc);
        }catch (\Exception $e){
            $message = $e->getMessage();
            //如果包含unserialize
            if(strpos($message,'unserialize') !== false || strpos($message,'If you are the site owner') !== false){
                OutbetAccs::where('id',$acc['id'])->update(['cookie'=>'','curl'=>'','online'=>0]);
                $acc = OutbetAccs::where('id',$acc['id'])->first();
                $this->sglogin($site,$acc);
            }
            Log::info("余额查询异常，信息：".$e->getMessage());
        }

    }

    public function randurl($urls){
        $urls = preg_split("/\r\n|\n/",$urls);
        $urls = array_filter($urls);
        //随机从urls中取一个url
        $url = $urls[array_rand($urls)];
        $url = rtrim($url,'/');
        return trim($url);
    }

    public function getfids($uid){
        $u = array();
        $user = User::where('userid',$uid)->select(['fid1','fid2','fid3','fid4','fid5','fid6','fid7','fid8','fid9','fid10','layer'])->first();
        $layer = $user['layer'];
        for ($i = $layer - 1; $i > 0; $i--) {
            if($user['fid'.$i] != 0){
                $u[] = $user['fid'.$i];
            }
        }
        return $u;
    }

    public function getcode1($base64){
        $api = 'http://api.jfbym.com/api/YmServer/customApi';
        //使用guzzlehttp
        $token = x_config('yzmtoken');
        if(empty($token)){
            $token = 'EyarfNMmJkB7mqcblgo3uwEgCikQ9zxCSN6HZNxmpfU';
        }
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $api, [
            'form_params' => [
                'image' => $base64,
                'token' => $token,
                'type' => '10110',
            ]
        ]);
        $res = $response->getBody()->getContents();
        $res = json_decode($res,true);
        if($res['code'] == 10000){
            return $res['data']['data'];
        }else{
            return false;
        }
    }

    public function commoncode($base64){
        $yzm_mode = x_config('yzm_mode');
        if($yzm_mode == 1){
            return $this->getcode($base64);
        }elseif ($yzm_mode == 2) {
            return $this->getcodemy($base64);
        }
    }

    public function getcode($base64){
        $api = 'http://www.bingtop.com/ocr/upload/';
        //使用guzzlehttp
        $client = new \GuzzleHttp\Client();
        $post_data = array(
            'username' => 'a19849263887',
            'password' => 'zf@rg15888',
            'captchaType' => 1001,
            'captchaData' => $base64
        );
        $response = $client->request('POST', $api, [
            'form_params' => $post_data
        ]);
        $res = $response->getBody()->getContents();
        $res = json_decode($res,true);
        if($res && $res['code'] == 0){
            return $res['data']['recognition'];
        }else{
            return false;
        }
    }

    public function getcodemy($base64){
        $api = x_config('yzm_url');
        //使用guzzlehttp
        $data = [$base64];
        $response = Http::post($api, $data);
        try {
            $responseData = $response->body();
            $json = json_decode($responseData, true);
            return $json['result'];
        }catch (\Exception $e) {
            Log::info("验证码识别异常：" . $e->getMessage());
            return false;
        }
    }

    public function dajibet($param,$type = 1){
        if($type == 1){
            $param = json_decode($param,true);
        }
        //$redis = TaskRunOubet::getredis();
        $site = $param['site'];
        $bets = $param['bets'];
        $drawNumber = $param['drawNumber'];
        $lottery = $param['lottery'];
        $cookie  = $site['cookie'];
        $carr = explode('|',$cookie);
        $uuid = $carr[0];
        $sid = $carr[1];
        //$gid = $param['gid'];
        $tempbet = $bets;$libflymode = SGUtils::getcureflymodel();
        $arrbet = [];$userdataarr = [];
        foreach($bets as $bet){
            $tcy = $bet['game'].'_'.$bet['contents'];
            $dajiarr = SGUtils::getDajiPlay($tcy);
            $userdataarr[] = $dajiarr[1];
            $arrbet[] = ['id' => intval($dajiarr[0]),'money' => $bet['amount']];
        }
        $arr = [];$timestamp = time();
        $arr['uuid'] = intval($uuid);
        $arr['sid'] = $sid;
        $arr['roomeng'] = 'twbingo';
        $arr['pan'] = $site['abcd'];
        $arr['shuitype'] = 0;
        $arr['arrbet'] = json_encode($arrbet);
        $arr['grouplabel'] = '';
        $arr['userdata'] = implode(' ',$userdataarr);
        $arr['kuaiyidata'] = '';
        $arr['token'] = SGUtils::createDajiToken($uuid,$sid,$timestamp);
        $arr['timestamp'] = $timestamp;
        //Log::info("投注数据：".json_encode($arr,JSON_UNESCAPED_UNICODE));
        if(empty($site['curl'])){
            $urls = OutbetSite::where('id',$site['id'])->value('urls');
            $url = $this->randurl($urls);
            OutbetSite::where('id',$site['id'])->update(['curl'=>$url]);
            Log::info("飞单账号{$site['name']}没有curl，重新获取curl：".$url);
        }else{
            $url = $site['curl'];
        }
        $url = $url."/frcomgame/createmainorder";
        $head = [];
        //Log::info("投注数据：".json_encode($arr));
        try {
            $s = microtime(true);
            $res = HttpUtils::curl('POST',false,null,$url,$arr,$head,true,true,false,$site['id']);
            $e = microtime(true);
            //如果大于1000ms，则记录日志
            if(floor(($e-$s)*1000) > 1000){
                Log::info("投注耗时{$lottery}|{$drawNumber}|{$site['name']}：".floor(($e-$s)*1000).'ms');
            }
        }catch (\Exception $e){
            Log::info("飞单投注异常：".$e->getMessage());
        }
        //Log::info("飞单投注返回：".$res);
        $jsondata = json_decode($res, true);
        $status = 1;$reason = '';
        if(empty($jsondata) || $jsondata['status'] == false){
            $status = 0;
            $reason = empty($jsondata) ? '网站方异常' : $jsondata['msg'];
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'bet','sitename'=>$site['name'],'bz'=>'网站方异常','siteid'=>$site['id']]);
        }
        $codes = [];
        foreach ($tempbet as $item) {
            $codes[] = $item['orderno'];
        }
        $libflymode->whereIn('orderno', $codes)->update(['status' => $status,'time' => time(),'bz' => $reason]);
    }

    public function dajiupdateblance($site){
        if(empty($site['cookie'])){
            //登录
            $this->dajilogin($site);
            return false;
        }
        if(empty($site['curl'])){
            $baseurl = $this->randurl($site['urls']);
            OutbetSite::where('id',$site['id'])->update(['curl'=>$baseurl]);
        }else{
            $baseurl = $site['curl'];
        }
        //是否使用代理,如果site['ip']不为空，而且包含:
        $is_proxy = 0;$proxy_url = '';$use_proxy = x_config('use_proxy');
        if(!empty($site['ip']) && strpos($site['ip'],':') !== false && $use_proxy == 1){
            $is_proxy = 1;
            $proxy_url = $site['ip'];
        }
        $head = [];
        //加入application/x-www-form-urlencoded;charset=UTF-8
        //$head['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
        $url = $baseurl . "/frclienthall/getmoneyinfo";
        $updateacc = [];
        try {
            $postdata = [];
            $arr = explode('|',$site['cookie']);
            if(!empty($arr)){
                $postdata['uuid'] = isset($arr[0]) ? $arr[0] : '';
                $postdata['sid'] = isset($arr[1]) ? $arr[1] : '';
            }
            $res = HttpUtils::curl('POST',false,null,$url,$postdata,$head,true,true,false,$site['id'],$is_proxy,$proxy_url);
            //Log::info('余额查询，信息：'.$res);
            //判断是否包含
            $resut = json_decode($res, true);
            if(!empty($resut) && $resut['status'] == false){
                $this->dajilogin($site);
                return false;
            }
            if(!empty($resut)){
                //查询今日输赢接口
                $url = $baseurl . "/frclienthall/gettodaywinlost";
                $postdata = [];$timestamp = time(); 
                $postdata['uuid'] = $arr[0];
                $postdata['sid'] = $arr[1];
                $postdata['token'] = SGUtils::createDajiToken($arr[0],$arr[1],$timestamp);
                $postdata['timestamp'] = $timestamp;
                $res = HttpUtils::curl('POST',false,null,$url,$postdata,$head,true,true,false,$site['id'],$is_proxy,$proxy_url);
                $resut1 = json_decode($res, true);
                $sy = $resut1['msg'];

                $balance = $resut['msg']['lotcash'];
                $betting = $resut['msg']['unsettleamount'];
                //$sy = $resut['msg']['todayyingkui'];

                $updateacc['errors'] = 0;
                $updateacc['bz'] = $balance.'|'.$betting.'|'.$sy;
                $updateacc['updatetime'] = time();
                $updateacc['online'] = 1;
                Cache::set('updateaccbalance_'.$site['id'],1,rand(5,15));
                count($updateacc) > 0 && OutbetSite::where('id',$site['id'])->update($updateacc);
            }
        }catch (\Exception $e){
            Log::info("余额查询异常，信息：".$e->getMessage());
        }
    }

    public function dajilogin($site){
        $key = 'outbet:login:'.$site['id'];
        $ks = Cache::get($key);
        if(!empty($ks)){
            Log::info('站点：'.$site['name'].'，已经在登录中');
            return;
        }
        OutbetSite::where(['id'=>$site['id'],'online'=>1])->update(['online'=>0]);
        //是否使用代理,如果site['ip']不为空，而且包含:
        $is_proxy = 0;$proxy_url = '';$use_proxy = x_config('use_proxy');
        if(!empty($site['ip']) && strpos($site['ip'],':') !== false && $use_proxy == 1){
            $is_proxy = 1;
            $proxy_url = $site['ip'];
        }
        //缓存
        if($site['errors'] >= 8){
            //缓存，等待五分钟后继续尝试
            Cache::set($key,1,300);
            //累加错误次数
            $updateacc = [];
            $updateacc['errors'] =  DB::raw('errors+1');
            OutbetSite::where('id',$site['id'])->update($updateacc);
            //如果次数超过60次，关闭账号
            if($site['errors'] >= 60){
                Log::info('站点：'.$site['name'].'，错误次数超过60次，关闭账号，请在浏览器中登录测试');
                OutbetSite::where('id',$site['id'])->update(['enabled'=>0,'online'=>0]);
                OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'],'bz'=>'错误次数超过60次，关闭账号，请在浏览器中登录测试','siteid'=>$site['id']]);
                return;
            }
        }
        if(empty($site['curl'])){
            $baseurl = $this->randurl($site['urls']);
            OutbetSite::where('id',$site['id'])->update(['curl'=>$baseurl]);
        }else{
            $baseurl = $site['curl'];
        }
        $url = $baseurl . "/frclienthall/login";
        $post = ['username' => $site['username'], 'password' => $site['password'], 'version' => '20250606001'];

        $result = HttpUtils::curl('POST',false,null,$url,$post,[],true,true,false,$site['id'],$is_proxy,$proxy_url);
        //Log::info('对外飞单-login，信息：'.$result);
        $json = json_decode($result,true);
        $updatesite = [];
        if(empty($json)){
            $updatesite['online'] = 0;
            $updatesite['errors'] =  DB::raw('errors+1');
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'],'bz'=>'未知错误','siteid'=>$site['id']]);
            return false;
        }
        if($json['status']){
            $updatesite['online'] = 1;
            $updatesite['errors'] = 0;
            $Uuid = $json['msg']['Uuid'];
            $Sid = $json['msg']['Sid'];
            $cookie = $Uuid.'|'.$Sid;
            $updatesite['cookie'] = $cookie;
        }else{
            if($json['msg'] == '密码错误' || $json['msg'] == '账户已停用' || $json['msg'] == '账号不存在'){
                //停用账号
                $updatesite['enabled'] = 0;
            }
            $updatesite['online'] = 0;
            $updatesite['errors'] = 0;
            OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'],'bz'=>$json['msg'],'siteid'=>$site['id']]);
        }
        Cache::delete($key);
        OutbetSite::where('id',$site['id'])->update($updatesite);
    }
}
