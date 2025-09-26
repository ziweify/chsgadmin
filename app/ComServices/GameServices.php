<?php

namespace App\ComServices;

use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\Play;
use App\Models\Game\Sclass;
use App\Models\Game\Userpatt;
use App\ort\common\ComFunc;
use App\ort\common\JsFunc;
use App\ort\services\CommonCache;
use App\ort\sgwin\SGUtils;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class GameServices
{
    public function periodListOrSingle($ruid, $gid,$type = 1){
        if(empty($ruid)){
            $model = Game::where(['ifopen'=>1]);
            if (!empty($gid)) {
                $model->where('gid', $gid);
            }
            $gamelist = $model->select(['gid','kjqishu','gname', 'fenlei', 'mnum', 'stopstatus', 'cs', 'template', 'fpseconds','userclosetime'])->orderBy('xsort')->get();
        }else{
            if($type == 1){
                $model = SGUtils::ruidGameModel($ruid);
            }elseif ($type == 2){
                $model = SGUtils::ruidGameModelByRoom($ruid);
            }
            if (!empty($gid)) {
                $model->where('game.gid', $gid);
            }
            $model = $model->select(['userpatt.gid','kjqishu','ifok','gname', 'fenlei', 'mnum', 'stopstatus', 'cs', 'template', 'fpseconds','userclosetime'])->orderBy('userpatt.xsort');
            /*if($type == 2){
                $model = $model->orderByDesc('userpatt.ifok');
            }*/
            $gamelist = $model->get();
        }
        $dates = ComFunc::getthisdateend();
        $result = [];
        $fields1 = ['qishu','opentime','closetime','kjtime'];
        foreach ($gamelist as $game) {
            $fields2 = ['qishu'];
            for ($i = 1; $i <= $game['mnum']; $i++) {
                $fields2[] = 'm'.$i;
            }
            $return = [];
            $time = time();
            $return['gid'] = $game['gid'];
            $return['gname'] = $game['gname'];
            $return['template'] = $game['template'];
            $return['stopstatus'] = $game['stopstatus'];
            if($type == 2){
                $return['ifok'] = $game['ifok'] == 1;
                if($game['ifok'] == 0){
                    $return['fp'] = 0;
                    $return['timearr'] = [];
                    $return['nowSaleTime'] = 0;
                    $return['nowSealTime'] = 0;
                    $return['nowOpenTime'] = 0;
                    $return['sysTime'] = $time;
                    $return['period'] = '-';
                    $result[] = $return;
                    continue;
                }
            }
            if ($game['stopstatus'] == 1) {
                $return['fp'] = 0;
                $return['timearr'] = [];
                $return['nowSaleTime'] = 0;
                $return['nowSealTime'] = 0;
                $return['nowOpenTime'] = 0;
                $return['sysTime'] = $time;
                $return['period'] = '-';
            } else {
                $kj_data = SGUtils::currentPeriod($game['gid'],$dates,null,$fields1);
                if (empty($kj_data)) {
                    $return['fp'] = 0;
                    $return['timearr'] = [0,0,0,0];
                    $return['nowSaleTime'] = 0;
                    $return['nowSealTime'] = 0;
                    $return['nowOpenTime'] = 0;
                    $return['sysTime'] = $time;
                    $return['period'] = '-';
                    $return['stopstatus'] = 1;
                } else {
                    $return['djs'] = ($kj_data['closetime']-$game['fpseconds']-$game['userclosetime']-$time);
                    $return['nowSaleTime'] = $kj_data['opentime'];
                    $return['nowSealTime'] = ($kj_data['closetime']-$game['fpseconds']-$game['userclosetime']);
                    $return['nowOpenTime'] = $kj_data['kjtime'];
                    $return['sysTime'] = $time ;
                    $return['period'] = $kj_data['qishu'];
                    if($time > ($kj_data['closetime']-$game['fpseconds']-$game['userclosetime']) && $time <= $kj_data['kjtime']){
                        $return['fp'] = 1;
                    }else{
                        $return['fp'] = 0;
                    }
                    $fptime = $return['nowSealTime']-$time;
                    $minutes = floor($fptime/60);
                    $seconds = $fptime%60;
                    $timearr = [];
                    if ($minutes < 10) {
                        $timearr[0] = 0;
                        $timearr[1] = $minutes;
                    } else {
                        $minutesStr = str_split((string)$minutes);
                        $timearr[0] = $minutesStr[0];
                        $timearr[1] = $minutesStr[1];
                    }
                    if ($seconds < 10) {
                        $timearr[2] = 0;
                        $timearr[3] = $seconds;
                    } else {
                        $secondsStr = str_split((string)$seconds);
                        $timearr[2] = $secondsStr[0];
                        $timearr[3] = $secondsStr[1];
                    }
                    $return['timearr'] = $timearr;
                }
            }
            //上期期号
            $upkj = SGUtils::upPeriod($game['gid'],$dates,$fields2,$game['kjqishu']);
            if (!empty($upkj)) {
                if($game['stopstatus'] == 1){
                    $return['period'] = $upkj['qishu'];
                }
                $return['upPeriod'] = substr($upkj['qishu'], -8);
                //上期开奖号码
                $hm = [];
                for ($i = 1; $i <= $game['mnum']; $i++) {
                    if ($game['fenlei'] == 107 || $game['fenlei'] == 101 || $game['fenlei'] == 444)
                        $hm[] = intval($upkj['m' . $i]);
                    else
                        $hm[] = $upkj['m' . $i];
                }
                $return['openNum'] = $hm;
                if($game['fenlei'] == 151){
                    $return['sum'] = $hm[0]+$hm[1]+$hm[2];
                }
            } else {
                $return['upPeriod'] = '-';
                $return['openNum'] = [];
            }
            $result[] = $return;
        }
        return $result;
    }

    public function period($ruid, $gid){
        $userpatt = Userpatt::where(['userid' => $ruid, 'gid' => $gid, 'ifopen' => 1, 'ifok' => 1])->select(['fpseconds'])->first();
        if (empty($userpatt)) {
            return ['ifok'=>0];
        }
        $game = Game::where('gid', $gid)->select(['gname', 'gid', 'fenlei', 'stopstatus', 'cs','userclosetime'])->first();
        $return = [];
        $dates = ComFunc::getthisdateend();
        $cs = json_decode($game['cs'], true);
        $return['stopstatus'] = $game['stopstatus'];
        $return['gid'] = $gid;
        $return['gname'] = $game['gname'];
        $return['timearr'] = [0,0,0,0];
        $return['fp'] = 0;
        $return['totalPeriods'] = $cs['qsnums'];
        if ($game['stopstatus'] == 1) {
            $upkjdata = SGUtils::upPeriod($gid);
            $return['period'] = $upkjdata['qishu'];
            $return['shortPeriod'] = substr($upkjdata['qishu'],-5);
            $return['nowSaleTime'] = 0;
            $return['nowSealTime'] = 0;
            $return['nowOpenTime'] = 0;
            $return['sysTime'] = time();
            return $return;
        } else {
            $kj_data = SGUtils::currentPeriod($game['gid'], $dates);
            if (empty($kj_data)) {
                $return['period'] = 0;
                $return['shortPeriod'] = 0;
                $return['nowSaleTime'] = 0;
                $return['nowSealTime'] = 0;
                $return['nowOpenTime'] = 0;
                $return['sysTime'] = time();
                return $return;
            }
            $return['djs'] = ($kj_data['closetime']-$userpatt['fpseconds']-$game['userclosetime']-time());
            $return['kjdjs'] = ($kj_data['kjtime']-time());
            $return['period'] = $kj_data['qishu'];
            $return['shortPeriod'] = substr($kj_data['qishu'],-5);
            $return['nowSaleTime'] = $kj_data['opentime'];
            $return['nowSealTime'] = ($kj_data['closetime']-$userpatt['fpseconds']-$game['userclosetime']);
            $return['nowOpenTime'] = $kj_data['kjtime'];
            $return['sysTime'] = time();
            if(time() > ($kj_data['closetime']-$userpatt['fpseconds']-$game['userclosetime']) && time() <= $kj_data['kjtime']){
                $return['fp'] = 1;
                $fptime = $return['nowOpenTime']-time();
            }else{
                $return['fp'] = 0;
                $fptime = $return['nowSealTime']-time();
            }
            $minutes = floor($fptime/60);
            $seconds = $fptime%60;
            $timearr = [];
            if ($minutes < 10) {
                $timearr[0] = 0;
                $timearr[1] = $minutes;
            } else {
                $minutesStr = str_split((string)$minutes);
                $timearr[0] = $minutesStr[0];
                $timearr[1] = $minutesStr[1];
            }
            if ($seconds < 10) {
                $timearr[2] = 0;
                $timearr[3] = $seconds;
            } else {
                $secondsStr = str_split((string)$seconds);
                $timearr[2] = $secondsStr[0];
                $timearr[3] = $secondsStr[1];
            }
            $return['timearr'] = $timearr;

            //下一期
            /*$nextkjdata = SGUtils::nextPeriod($gid, $kj_data['qishu'], $dates);
            if (!empty($nextkjdata)) {
                $return['nextPeriod'] = $nextkjdata['qishu'];
                $return['shortNextPeriod'] = substr($nextkjdata['qishu'],-5);
                $return['nextNowSaleTime'] = $nextkjdata['opentime'] ;
                $return['nextNowSealTime'] = ($nextkjdata['closetime'] - $userpatt['fpseconds']) ;
                $return['nextNowOpenTime'] = $nextkjdata['kjtime'] ;
            }*/
        }
        return $return;
    }

    public function openResult($gid)
    {
        $game = Game::where('gid', $gid)->select(['fenlei', 'mnum','template'])->first();
        if (empty($game)) {
            return [];
        }
        //上期期号
        $return = [];
        $kj_data = SGUtils::upPeriod($gid);
        $ma = [];$mb = [];$total = 0;
        $mb['bigSmalls'] = [];
        $mb['singleDoubles'] = [];
        for ($i = 1; $i <= $game['mnum']; $i++) {
            $m = intval($kj_data['m' . $i]);
            if ($game['fenlei'] == 121 || $game['fenlei'] == 103 || $game['fenlei'] == 161) {
                $m < 10 && $m = '0' . $m;
            }
            $total += $m;
            $ma[] = $m . '';
            //大小
            $mb['bigSmalls'][] = JsFunc::dx($game['fenlei'], $m);
            //单双
            $mb['singleDoubles'][] = JsFunc::ds($game['fenlei'], $m);
        }
        $return['gid'] = $gid;
        $return['template'] = $game['template'];
        $return['period'] = substr($kj_data['qishu'],-5);
        $return['openTime'] = $kj_data['kjtime'] ;
        $return['openNum'] = $ma;
        //开奖号码计算
        if ($game['fenlei'] == 107) {
            $mb['sum'] = $ma[0] + $ma[1];
        } else {
            $mb['sum'] = $total;
        }
        if ($game['fenlei'] == 107) {
            $mb['bigSmall'] = JsFunc::zhdx($game['fenlei'], $ma[0] + $ma[1]);
            $mb['singleDouble'] = JsFunc::ds($game['fenlei'], $ma[0] + $ma[1]);
            $mb['dragonTigerNum1'] = JsFunc::longhuhe($ma[0], $ma[9]);
            $mb['dragonTigerNum2'] = JsFunc::longhuhe($ma[1], $ma[8]);
            $mb['dragonTigerNum3'] = JsFunc::longhuhe($ma[2], $ma[7]);
            $mb['dragonTigerNum4'] = JsFunc::longhuhe($ma[3], $ma[6]);
            $mb['dragonTigerNum5'] = JsFunc::longhuhe($ma[4], $ma[5]);
        } elseif ($game['fenlei'] == 101) {
            $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
            $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
            $mb['dragonTiger'] = JsFunc::longhuhe($ma[0], $ma[4]);
            $mb['topThree'] = JsFunc::qita($ma[0], $ma[1], $ma[2]);
            $mb['middleThree'] = JsFunc::qita($ma[1], $ma[2], $ma[3]);
            $mb['tailThree'] = JsFunc::qita($ma[2], $ma[3], $ma[4]);
        } elseif ($game['fenlei'] == 151) {
            $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
        } elseif ($game['fenlei'] == 121) {
            $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
            $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
            $mb['sumTailBigSmall'] = JsFunc::zwdx($ma[0], 1);
            $mb['dragonTiger'] = JsFunc::longhuhe($ma[0], $ma[4]);
        } elseif ($game['fenlei'] == 103) {
            $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
            $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
            $mb['sumTailBigSmall'] = JsFunc::zwdx($ma[0], 1);
            $mb['dragonTigerNum1'] = JsFunc::longhuhe($ma[0], $ma[7]);
            $mb['dragonTigerNum2'] = JsFunc::longhuhe($ma[1], $ma[6]);
            $mb['dragonTigerNum3'] = JsFunc::longhuhe($ma[2], $ma[5]);
            $mb['dragonTigerNum4'] = JsFunc::longhuhe($ma[3], $ma[4]);
        }elseif ($game['fenlei'] == 444){
            $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
            $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
            $mb['sumTailBigSmall'] = JsFunc::zwdx($ma[0], 1);
            $mb['dragonTigerNum'] = JsFunc::longhuhe($ma[0], $ma[4]);
        }
        $return['property'] = $mb;
        return $return;
    }

    public function resultByDate($currentPage, $pageSize, $gid, $date){
        $game = Game::where('gid', $gid)->select(['gid', 'fenlei', 'mnum'])->first();
        if (empty($date)) {
            $dates = ComFunc::getthisdateend();
        } else {
            $dates = $date;
        }
        $fields = ['qishu', 'kjtime'];
        for ($i = 1; $i <= $game['mnum']; $i++) {
            $fields[] = 'm' . $i;
        }
        $kjmodel = Kj::where(['gid' => $game['gid'], 'dates' => strtotime($dates), 'status' => 1]);
        $kjlist = $kjmodel->orderByDesc('qishu')->paginate($pageSize, $fields, 'page', $currentPage);
        $totalCount = $kjmodel->count('id');
        $totalPage = ceil($totalCount / $pageSize);
        $list = [];
        foreach ($kjlist as $kj) {
            $item = [];
            $item['period'] = $kj['qishu'];
            $item['shortPeriod'] = substr($kj['qishu'],-5);
            $item['openTimes'] = $kj['kjtime'];
            $item['openTime'] = date('Y-m-d H:i:s', $kj['kjtime']);
            $item['shortOpenTime'] = date('H:i', $kj['kjtime']);
            $ma = [];
            $total = 0;
            $mb = [];
            for ($i = 1; $i <= $game['mnum']; $i++) {
                $m = intval($kj['m' . $i]);
                if ($game['fenlei'] == 121 || $game['fenlei'] == 103 || $game['fenlei'] == 161) {
                    $m < 10 && $m = '0' . $m;
                }
                $total += $m;
                $ma[] = $m . '';
                //大小
                $mb['bigSmalls'][] = JsFunc::dx($game['fenlei'], $m);
                //单双
                $mb['singleDoubles'][] = JsFunc::ds($game['fenlei'], $m);
            }
            $item['openNum'] = $ma;
            //开奖号码计算
            if ($game['fenlei'] == 107) {
                $mb['sum'] = $ma[0] + $ma[1];
            } else {
                $mb['sum'] = $total;
            }
            if ($game['fenlei'] == 107) {
                $mb['bigSmall'] = JsFunc::zhdx($game['fenlei'], $ma[0] + $ma[1]);
                $mb['singleDouble'] = JsFunc::ds($game['fenlei'], $ma[0] + $ma[1]);
                $mb['dragonTigerNum1'] = JsFunc::longhuhe($ma[0], $ma[9]);
                $mb['dragonTigerNum2'] = JsFunc::longhuhe($ma[1], $ma[8]);
                $mb['dragonTigerNum3'] = JsFunc::longhuhe($ma[2], $ma[7]);
                $mb['dragonTigerNum4'] = JsFunc::longhuhe($ma[3], $ma[6]);
                $mb['dragonTigerNum5'] = JsFunc::longhuhe($ma[4], $ma[5]);
            } elseif ($game['fenlei'] == 101) {
                $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
                $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
                $mb['dragonTiger'] = JsFunc::longhuhe($ma[0], $ma[4]);
                $mb['topThree'] = JsFunc::qita($ma[0], $ma[1], $ma[2]);
                $mb['middleThree'] = JsFunc::qita($ma[1], $ma[2], $ma[3]);
                $mb['tailThree'] = JsFunc::qita($ma[2], $ma[3], $ma[4]);
            } elseif ($game['fenlei'] == 151) {
                if($ma[0] == $ma[1] && $ma[1] == $ma[2]){
                    $mb['sumSingleDouble'] = '通杀';
                    $mb['sumBigSmall'] = '通杀';
                }else{
                    $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
                    $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
                }
                $mb['yxx1'] = JsFunc::yxx($ma[0]);
                $mb['yxx2'] = JsFunc::yxx($ma[1]);
                $mb['yxx3'] = JsFunc::yxx($ma[2]);
            } elseif ($game['fenlei'] == 121) {
                $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
                $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
                $mb['sumTailBigSmall'] = JsFunc::zwdx($ma[0], 1);
                $mb['dragonTiger'] = JsFunc::longhuhe($ma[0], $ma[4]);
            } elseif ($game['fenlei'] == 103) {
                $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
                $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
                $mb['sumTailBigSmall'] = JsFunc::zwdx($ma[0], 1);
                $mb['dragonTigerNum1'] = JsFunc::longhuhe($ma[0], $ma[7]);
                $mb['dragonTigerNum2'] = JsFunc::longhuhe($ma[1], $ma[6]);
                $mb['dragonTigerNum3'] = JsFunc::longhuhe($ma[2], $ma[5]);
                $mb['dragonTigerNum4'] = JsFunc::longhuhe($ma[3], $ma[4]);
            }elseif ($game['fenlei'] == 444){
                $mb['sumSingleDouble'] = JsFunc::ds($game['fenlei'], $total);
                $mb['sumBigSmall'] = JsFunc::zhdx($game['fenlei'], $total);
                $mb['sumTailBigSmall'] = JsFunc::zwdx($ma[0], 1);
                $mb['dragonTigerNum'] = JsFunc::longhuhe($ma[0], $ma[4]);
            }
            $item['property'] = $mb;
            $list[] = $item;
        }
        return ['total' => $totalCount, 'totalPage' => $totalPage, 'currentPage' => $currentPage, 'pageSize' => $pageSize, 'records' => $list];
    }

    public function longdragon($gid){
        $game = Game::where('gid', $gid)->select(['fenlei'])->first();
        if (empty($game)) {
            return [];
        }
        $z = ComFunc::getzlong($game['fenlei'], $gid);
        $cl = [];
        foreach ($z as $v) {
            $arr = explode('-', $v['name']);
            $item = [];
            $item['betItem'] = $arr[1];
            $item['position'] = $arr[0];
            $item['times'] = $v['qishu'];
            $cl[] = $item;
        }
        return $cl;
    }

    public function bet($bets,$game,$user,$userpatt,$gid,$userid,$ruid,$ip){
        try {
            $cp = count($bets);
            if ($user['yingdeny'] > 0 && $user['sy'] >= $user['yingdeny']) {
                throw new Exception('今日盈利已达到上限');
            }
            if ($game['ifopen'] == 0) {
                throw new Exception('该彩种已关闭下注!');
            }
            if ($user['room_status'] == 0) {
                throw new Exception('您的账号已被禁用!');
            }
            $moneys = $user['kmoney'];
            $libmodel = SGUtils::getcuremodel();

            if (empty($userpatt)) {
                throw new Exception('房主彩种错误，请联系客服!');
            }
            $zje = 0;
            $patt = json_decode($userpatt['patt'], true);
            $dates = ComFunc::getthisdateend();
            for ($i = 0; $i < $cp; $i++) {
                $zje += $bets[$i]['amount'];
            }
            if ($zje > $moneys) {
                throw new Exception('积分不足 下注失败，请稍后再试！');
            }
            $time = time();
            $kj = Kj::where(['gid' => $gid, 'qishu' => $userpatt['thisqishu'], 'dates' => strtotime($dates)])->select(['opentime', 'closetime'])->first();
            if (empty($kj)) {
                throw new Exception('该期已封盘');
            }
            if ($time > ($kj['closetime']-$userpatt['fpseconds']-$game['userclosetime'])) {
                throw new Exception("下单失败,【{$game['gname']}-{$userpatt['thisqishu']}】已封盘");
            }
            $temp = [];$betSaveArr = [];$tmpMap = [];
            $tmpOrderNos = [];
            foreach ($bets as $bet) {
                if ($bet['amount'] <= 0 || !is_numeric($bet['amount'])) {
                    throw new Exception('金额错误!');
                }
                //如果下注金额有小数提示金额错误！
                if (strpos($bet['amount'], '.') !== false) {
                    throw new Exception('金额错误!');
                }
                $cy = $bet['mark'];
                $pp = Play::where(['gid' => $gid, 'cy' => $cy])->select(['pid', 'bid', 'sid', 'cid', 'peilv1', 'ifok', 'ptype'])->first();
                if (empty($pp)) {
                    throw new Exception("下注失败,玩法[{$bet['mid_name']}{$bet['play']}]不存在!");
                }
                $ptype = $pp['ptype'];
                $bid = $pp['bid'];
                $sid = $pp['sid'];
                $cid = $pp['cid'];
                $ifok = $pp['ifok'];
                if ($ifok != 1) {
                    throw new Exception('玩法未开放');
                }
                if (!isset($temp['f' . $gid . $pp['cid']])) {
                    $class = CommonCache::getclasscache($gid, $cid);
                    $dftype = $class['dftype'];
                }
                if (!isset($temp['s'.$gid.$sid])) {
                    $temp['s'.$gid.$sid] = CommonCache::getsclasscache($gid, $sid)['name'];
                }
                $sname = $temp['s'.$gid.$pp['sid']];
                $peilv1 = $patt[$ptype]['p'];
                if($peilv1 <= 0){
                    throw new Exception('该玩法未开放投注!');
                }
                $minBetAmount = $patt[$ptype]['minBetAmount'];
                $maxBetAmount = $patt[$ptype]['maxBetAmount'];
                $maxUserPeriodAmount = $patt[$ptype]['maxUserPeriodAmount'];
                $maxPeriodAmount = $patt[$ptype]['maxPeriodAmount'];
                if ($bet['amount'] < $minBetAmount) {
                    throw new Exception("单注最低投注金额: 最低下注{$minBetAmount}元");
                }
                if ($bet['amount'] > $maxBetAmount) {
                    throw new Exception("单注最高投注金额: 最高只能下注{$maxBetAmount}元");
                }
                $extje = $libmodel->where(['gid' => $gid, 'userid' => $userid, 'ruid' => $ruid, 'qishu' => $userpatt['thisqishu'], 'cy' => $cy])->sum('je');
                if ($extje + $bet['amount'] > $maxUserPeriodAmount) {
                    throw new Exception("单期最高限额: 最高只能下注{$maxUserPeriodAmount}元");
                }
                $extzje = $libmodel->where(['gid' => $gid, 'ruid' => $ruid, 'qishu' => $userpatt['thisqishu'], 'cy' => $cy])->sum('je');
                if ($extzje + $bet['amount'] > $maxPeriodAmount) {
                    throw new Exception("单期总限额: 最高只能下注{$maxPeriodAmount}元");
                }
                $order = [];
                $order['userid'] = $userid;
                $order['qishu'] = $userpatt['thisqishu'];
                $order['gid'] = $gid;
                $order['bid'] = $bid;
                $order['sid'] = $sid;
                $order['cid'] = $cid;
                $order['pid'] = $pp['pid'];
                $order['peilv1'] = $peilv1;
                $order['je'] = $bet['amount'];
                $order['time'] = time();
                $order['z'] = 9;
                $order['ruid'] = $ruid;
                $order['fid'] = $user['fid'];
                $order['bz'] = isset($bet['bz']) ? $bet['bz'] : '';
                $order['ip'] = $ip;
                $order['code'] = ComFunc::getNewOrderId("OM");//$userid.SGUtils::generateOrderNumber();
                $order['zcount'] = 0;
                $order['uzp'] = 0;
                $order['dftype'] = $dftype;
                $order['cy'] = $cy;
                $order['robot'] = $user['robot'];
                $order['ignore_outbet'] = $user['ignore_outbet'];
                $tmpOrderNos[] = $order['code'];
                $betSaveArr[] = $order;
                if(!isset($tmpMap[$sname])){
                    $tmpMap[$sname] = [];
                }
                $tmpMap[$sname][] = ['play'=>$bet['play'],'amount'=>$bet['amount']];
            }
            //更新用户余额
            if (count($betSaveArr) > 0) {
                $logArr = ['moneyType'=>1,'gid'=>$gid,'qishu'=>$userpatt['thisqishu']];
                $rec = UserService::operBalance($userid,$ruid,$zje,1,2,$logArr,$libmodel,$betSaveArr);
                if($rec['code'] == 0){
                    throw new Exception('系统异常，下注失败!');
                }
                //缓存最后下注的订单号，用,分割，有效期10分钟
                $key = "last:order:nos:".$userid.":".$gid.":".$userpatt['thisqishu'];
                $lastOrderNos = implode(',',$tmpOrderNos);
                Redis::setex($key,600,$lastOrderNos);
                //组装返回信息
                return ['code'=>1,'map'=>$tmpMap,'zje'=>$zje,'balance'=>ComFunc::pr2($rec['balance'])];
            }else{
                throw new Exception('无符合订单，下注失败!');
            }
        } catch (\Exception $e) {
            Log::info('下注失败:'. $e->getMessage().$e->getTraceAsString());
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }


    //本群预测
    public function lotteryPredictInfo($gid){
        /*$game = Game::where('gid', $gid)->select(['fenlei'])->first();
        if (empty($game)) {
            return [];
        }*/
        $key = 'yc_kj_'.$gid;
        $yckjlist = Redis::get($key);
        if(empty($yckjlist)){
            return [];
        }
        return json_decode($yckjlist,true);
    }

    public function lastOpenDataList($gid,$fenlei,$mnum,$count = 20){
        $dates = ComFunc::getthisdateend();
        $fields = ['qishu','kjtime'];
        for ($i = 1; $i <= $mnum; $i++) {
            $fields[] = 'm'.$i;
        }
        $kjlist = Kj::where(['gid' => $gid, 'dates' => strtotime($dates), 'status' => 1])->select($fields)->orderByDesc('qishu')->limit($count)->get()->toArray();
        $openlist = [];
        foreach ($kjlist as $kj) {
            $item = [];$ma = [];
            $item['period'] = $kj['qishu'];
            for ($i = 1; $i <= $mnum; $i++) {
                $ma[] = intval($kj['m'.$i]);
            }
            $item['open_num'] = $ma;
            $item['kjtime'] = $kj['kjtime'];
            $openlist[] = $item;
        }
        return $openlist;
    }

    //快捷玩法赔率
    public function quickPlayDetail($gid,$ruid){
        $game = Game::where('gid',$gid)->select(['fenlei'])->first();
        $userpatt = Userpatt::where(['userid'=>$ruid,'gid'=>$gid])->first();
        $patt = json_decode($userpatt['patt'], true);
        $sclass = Sclass::where(['gid'=>$gid])->select(['sid','name','xsort'])->orderBy('xsort')->get()->toArray();
        $bgroup = [];
        if($game['fenlei'] == 107){
            $bgroup[0] = ['name'=>"快捷",'key'=>'kj','list'=>[]];
            $bgroup[1] = ['name'=>"两面盘",'key'=>'lm','list'=>[]];
            $bgroup[2] = ['name'=>"车号1-10",'key'=>'ball','list'=>[]];
            $bgroup[3] = ['name'=>"冠亚军组合",'key'=>'gyh','list'=>[]];
        }elseif ($game['fenlei'] == 101){
            $bgroup[0] = ['name'=>"快捷",'key'=>'kj','list'=>[]];
            $bgroup[1] = ['name'=>"整合",'key'=>'zh','list'=>[]];
            $bgroup[2] = ['name'=>"第一球",'key'=>'ball1','list'=>[]];
            $bgroup[3] = ['name'=>"第二球",'key'=>'ball2','list'=>[]];
            $bgroup[4] = ['name'=>"第三球",'key'=>'ball3','list'=>[]];
            $bgroup[5] = ['name'=>"第四球",'key'=>'ball4','list'=>[]];
            $bgroup[6] = ['name'=>"第五球",'key'=>'ball5','list'=>[]];
        }elseif ($game['fenlei'] == 444) {//宾果
            $bgroup[0] = ['name' => "快捷", 'key' => 'kj', 'list' => []];
            $bgroup[1] = ['name' => "整合", 'key' => 'zh', 'list' => []];
            $bgroup[2] = ['name' => "第一球", 'key' => 'ball1', 'list' => []];
            $bgroup[3] = ['name' => "第二球", 'key' => 'ball2', 'list' => []];
            $bgroup[4] = ['name' => "第三球", 'key' => 'ball3', 'list' => []];
            $bgroup[5] = ['name' => "第四球", 'key' => 'ball4', 'list' => []];
            $bgroup[6] = ['name' => "第五球", 'key' => 'ball5', 'list' => []];
        }
        foreach ($sclass as $i=>$sc){
            if($sc['name'] == '冠亚和'){
                $sc['f'] = '冠亚';
            }elseif($sc['name'] == '总和龙虎'){
                $sc['f'] = '总和';
            }elseif($sc['name'] == '第十名'){
                $sc['f'] = '0';
            }elseif($sc['name'] == '前三' || $sc['name'] == '中三' || $sc['name'] == '后三'){
                $sc['f'] = $sc['name'];
            }else{
                $sc['f'] = $sc['xsort'];
            }
            $plist = Play::where(['gid'=>$gid,'sid'=>$sc['sid'],'ifok'=>1])->select(['name','ptype','cy','ztype'])->orderBy('xsort')->get()->toArray();
            $tmplm = [];$tmpball = [];$tmpkj = [];$tmpzh = [];$tmpball1 = [];$tmpball2 = [];$tmpball3 = [];$tmpball4 = [];$tmpball5 = [];
            foreach ($plist as &$p){
                if($p['name'] == '冠亚大' || $p['name'] == '冠亚小' || $p['name'] == '冠亚单' || $p['name'] == '冠亚双'){
                    $p['f'] = str_replace('冠亚','',$p['name']);
                }else if($p['cy'] == 'B1_10'){
                    $p['f'] = '0';
                }else{
                    $p['f'] = $p['name'];
                }
                $p['odds'] = $patt[$p['ptype']]['p'];
                if(is_numeric($p['name']) && $sc['name'] != '冠亚和'){
                    $p['isn'] = 1;
                }else{
                    $p['isn'] = 0;
                }
                if($game['fenlei'] == 107){
                    if(in_array(intval($p['ztype']),[1,2,3])){//两面
                        $tmplm[] = $p;
                    }
                    if($p['ztype'] == 0 && $sc['name'] != '冠亚和'){//号码
                        $tmpball[] = $p;
                    }
                    if(in_array(intval($p['ztype']),[0,1,2])) {//快捷
                        $tmpkj[] = $p;
                    }
                }
                if($game['fenlei'] == 101 || $game['fenlei'] == 444){
                    if(in_array(intval($p['ztype']),[0,1,2]) || $game['fenlei'] == 444) {//快捷
                        $tmpkj[] = $p;
                    }
                    $tmpzh[] = $p;
                    if($sc['name'] == '第一球' || $sc['name'] == '平码一'){
                        $tmpball1[] = $p;
                    }elseif($sc['name'] == '第二球' || $sc['name'] == '平码二'){
                        $tmpball2[] = $p;
                    }elseif($sc['name'] == '第三球' || $sc['name'] == '平码三'){
                        $tmpball3[] = $p;
                    }elseif($sc['name'] == '第四球' || $sc['name'] == '平码四'){
                        $tmpball4[] = $p;
                    }elseif($sc['name'] == '第五球' || $sc['name'] == '特码'){
                        $tmpball5[] = $p;
                    }
                }
            }
            if($game['fenlei'] == 107){
                $tmplmsc = $sc;
                $tmplmsc['plist'] = $tmplm;
                $bgroup[1]['list'][] = $tmplmsc;
                if($sc['name'] == '冠亚和'){
                    $tmpgyhsc = $sc;
                    $tmpgyhsc['plist'] = $plist;
                    $bgroup[3]['list'][] = $tmpgyhsc;
                }
                if($sc['name'] != '冠亚和'){
                    $tmpballsc = $sc;
                    $tmpballsc['plist'] = $tmpball;
                    $bgroup[2]['list'][] = $tmpballsc;

                    $tmpkjsc = $sc;
                    if ($i == 1){
                        $tmpkjsc['plist'] = $tmpkj;
                    }
                    $bgroup[0]['list'][] = $tmpkjsc;
                }
            }elseif ($game['fenlei'] == 101 || $game['fenlei'] == 444){
                if(in_array($sc['name'],['第一球','第二球','第三球','第四球','第五球','平码一','平码二','平码三','平码四','特码'])){
                    $tmpkjsc = $sc;
                    if (($game['fenlei'] == 101 && $i == 1) || ($game['fenlei'] == 444 && $i == 0)){
                        $tmpkjsc['plist'] = $tmpkj;
                    }
                    $bgroup[0]['list'][] = $tmpkjsc;
                }
                $tmpzhsc = $sc;
                $tmpzhsc['plist'] = $tmpzh;
                $bgroup[1]['list'][] = $tmpzhsc;

                if($sc['name'] == '第一球' || $sc['name'] == '平码一'){
                    $tmpball1sc = $sc;
                    $tmpball1sc['plist'] = $tmpball1;
                    $bgroup[2]['list'][] = $tmpball1sc;
                }

                if($sc['name'] == '第二球' || $sc['name'] == '平码二'){
                    $tmpball2sc = $sc;
                    $tmpball2sc['plist'] = $tmpball2;
                    $bgroup[3]['list'][] = $tmpball2sc;
                }
                if($sc['name'] == '第三球' || $sc['name'] == '平码三'){
                    $tmpball3sc = $sc;
                    $tmpball3sc['plist'] = $tmpball3;
                    $bgroup[4]['list'][] = $tmpball3sc;
                }
                if($sc['name'] == '第四球' || $sc['name'] == '平码四'){
                    $tmpball4sc = $sc;
                    $tmpball4sc['plist'] = $tmpball4;
                    $bgroup[5]['list'][] = $tmpball4sc;
                }
                if($sc['name'] == '第五球' || $sc['name'] == '特码'){
                    $tmpball5sc = $sc;
                    $tmpball5sc['plist'] = $tmpball5;
                    $bgroup[6]['list'][] = $tmpball5sc;
                }
            }
        }
        return $bgroup;
    }
}