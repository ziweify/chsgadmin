<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\User;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\common\CsFunc;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends ManageAuthController
{
    public function main(Request $request){
        $action = $request->input('action','list');
        if(empty($action) || $action == 'list'){
            if(!in_array('report.logs',$this->auths)){//无权限跳转
                return redirect('/noauth');
            }
            $userid = $this->uid;
            $user = User::where('userid',$userid)->select(['username','name','layer'])->first();
            $sdate = AdminFunc::week();
            view()->share("sdate", $sdate);
            $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
                $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
            })->where('ifopen', 1)->select(['gname','xsort','lottery'])->orderByRaw('xsort asc')->get();
            view()->share("lotterys", $lotterys);
            view()->share("username", $user['username']);
            view()->share("layername", '公司');
            view()->share("today", strtotime($sdate[10])*1000);
            view()->share("layer", $user['layer']);
            return view('common.report.main');
        }else{
            if(!in_array('report.logs',$this->auths)){//无权限跳转
                return redirect('/noauth');
            }
            view()->share('date', date('Y-m-d'));
            view()->share('layer', 0);
            return view('agentv1.report.logs');
        }
    }

    public function period(Request $request){
        $lottery = $request->input('lottery','');
        $beginTime = $request->input('beginTime','');
        $endTime = $request->input('endTime','');
        if(empty($lottery) || empty($beginTime) || empty($endTime)){
            return response()->json([]);
        }
        $beginTime = strtotime($beginTime);
        $endTime = strtotime($endTime);
        $game = Game::where('lottery',$lottery)->select(['gid','gname'])->first();
        $kjdata = Kj::where(['gid'=>$game['gid'],'js'=>1])->whereBetween('dates',[$beginTime,$endTime])->select(['qishu'])->orderByDesc('qishu')->get();
        $list = [];
        foreach ($kjdata as $v){
            $list[] = ['drawNumber'=>$v['qishu'],'name'=>$game['gname']];
        }
        return response()->json($list);
    }

    public function list1(Request $request,$detail){
        $game = $request->input('lottery','');
        $username = $request->input('username','');
        $start = $request->input('begin','');
        $end = $request->input('end','');
        $qishu = $request->input('period','');
        $detail = $request->input('detail',0);
        $jsstatus = $request->input('settle','');
        if(!is_numeric($jsstatus)){
            if($jsstatus == 'false' || $jsstatus == false) {
                $jsstatus = 2;
            }else{
                $jsstatus = 1;
            }
        }
        $filter = $request->input('filter','');
        $yk = $request->input('nd','');
        $je = $request->input('amount','');
        $userid = Constants::$SUID;
        $db = Db::connection();
        $start = ComFunc::rdates($start);
        $end = ComFunc::rdates($end);
        $filter = trim($filter);
        $uidson = '';
        view()->share('period', $qishu);
        view()->share('begin', $start);
        view()->share('end', $end);
        view()->share('jsstatus', $jsstatus);
        view()->share('detail', $detail);
        view()->share('tax_name', x_config('tax_name'));
        view()->share('water_name', x_config('water_name'));
        if ($filter != '') {
            $tuser = User::where('username', $filter)->select(['userid','fid'])->first();
            if (empty($tuser)) {
                view()->share('cuser', '');
                view()->share('msg', '未找到指定用户');
                return view('common.report.list', ['data' => []]);
            }
            $uid = $tuser['fid'];
            $uidson = $tuser['userid'];
            $myuser = User::where('userid',$uid)->select(['userid','username','layer','kmoney'])->first();
        }else{
            if(empty($username)){
                $myuser = User::where('userid',$userid)->select(['userid','username','layer','kmoney'])->first();
                $uid = $userid;
            }else{
                $myuser = User::where('username',$username)->select(['userid','username','layer','kmoney'])->first();
                $uid = $myuser['userid'];
            }
        }
        $layers = json_decode(x_config('layer'), true);
        $layername = $myuser['layer'] == 0 ? '公司' : $layers[$myuser['layer'] - 1];
        view()->share('layername', $layername);
        view()->share('cuser', $myuser['username']);
        $tbs = $db->select("SHOW TABLES LIKE  'x_lib_20%'");
        $tb = "";
        foreach ($tbs as $v) {
            $tb .= array_values($v)[0];
        }
        $dd = ComFunc::getthisdate();
        $datearr = ComFunc::getdatearr($start, $end, $dd, $tb);
        if(empty($game)){
            $game = Game::whereIn('gid', function ($query){
                $query->select('gid')->from('gamecs')->where(['userid'=>$this->uid,'ifok'=>1]);
            })->where('ifopen', 1)->pluck('gid')->toArray();
        }else{
            $gstr = explode(',',$game);
            $game = Game::whereIn('lottery',$gstr)->pluck('gid')->toArray();
        }
        $zstr = "";
        if (is_numeric($qishu)) {
            $zstr = " qishu='{$qishu}' and ";
        }
        if ($jsstatus == 1) {
            $zstr .= " z not in(2,7,9) ";
        } elseif ($jsstatus == 2) {
            $zstr .= " z = 9 ";
        } elseif ($jsstatus == 3) {
            $zstr .= " z = 7 ";
        }
        if(!empty($je)){
            $zstr .= " and je=$je ";
        }
        if(!empty($yk)){
            $zstr .= " and je=-$yk ";
        }
        $bao = ComFunc::topuser($uid);
        $cb = count($bao);
        $layer = $myuser['layer'];
        $tax = x_config('plat_tax_status');
        $water = x_config('plat_water_status');
        if ($layer == 0) {
            $myzcstr = 'zc' . $layer;
            $mypointsstr = '0';
            $mypeilv1str = '0';
        } else {
            $myzcstr = 'zc' . $layer;
            $mypointsstr = 'points' . $layer;
            $mypeilv1str = 'peilv1' . $layer;
        }
        $mypeilv1str = 'peilv1';
        for ($i = 0; $i < $cb; $i++) {
            if ($uidson != '' && $uidson != $bao[$i]['userid']) {
                unset($bao[$i]);
                continue;
            }
            if(empty($bao[$i]['name'])){
                $bao[$i]['name'] = '';
            }
            $bao[$i]['fly'] = 0;
            if ($layer < 10) {
                $uidstrdown = 'uid' . ($layer + 1);
                $pointsstrdown = 'points' . ($layer + 1);
                $peilv1strdown = 'peilv1' . ($layer + 1);
            } else {
                $uidstrdown = 'userid';
                $pointsstrdown = 'points';
                $peilv1strdown = 'peilv1';
            }
            $zcstrdown = '';
            for ($k = 10; $k >= $bao[$i]['layer']; $k--) {
                $zcstrdown .= '-zc' . $k;
            }
            $zcstrup = $zcstrdown . '-zc' . $k;
            if ($bao[$i]['ifagent'] == '0') {
                $whs = ComFunc::getsqls($datearr, $game, ["userid" => $bao[$i]['userid']], $dd, $qishu);
                $sql = "select count(id) as r0,sum(je) as r1,sum(je*points/100) as r2,sum(if(z=1,peilv1*je,0)) as r3,0 as r4,0 as r5,sum(je*uzp2) as r6,0 as r7";
                $sql .= ",sum(if(z=1,(100 {$zcstrdown})/100*prize,0)) as r8,sum({$myzcstr}*je/100) as r9,sum(if({$uidstrdown}=0,(points*{$myzcstr}*je/(100*100)),{$pointsstrdown}*{$myzcstr}*je/(100*100))) as r10,sum({$mypointsstr}*{$myzcstr}*je/(100*100)) as r11,max({$myzcstr}) as r12,min({$myzcstr}) as r13,sum(if({$uidstrdown}=0,if(z=1,(peilv1*{$myzcstr})*je/100,0),if(z=1,{$peilv1strdown}*{$myzcstr}*je/100,0))) as r14,sum(if(z=1,{$myzcstr}/100*prize,0)) as r15,sum(uzp1*je) as r16,sum(uzp1*je) as r17,sum(uzp1*je*$myzcstr/100) as r18";
                if ($layer > 0) {
                    $sql .= ",sum((100 {$zcstrup})*je/100) as r19,sum({$mypointsstr}*(100 {$zcstrup})*je/(100*100)) as r20,sum(if(z=1,(100 {$zcstrup})*je*{$mypeilv1str}/100,0)) as r21,sum(if(z=1,prize,0)) as r22,sum((100 {$zcstrup})*uzp1*je/100) as r23";
                }
            } else {
                $whs = ComFunc::getsqls($datearr, $game, ["userid" => $bao[$i]['userid'], $uidstrdown => $bao[$i]['userid']], $dd, $qishu);
                $sql = "select count(id) as r0,sum((100" . $zcstrdown . ")*je/100) as r1,sum(if({$uidstrdown}=0,(points*je/100),{$pointsstrdown}*je*(100 {$zcstrdown})/(100*100))) as r2,sum(je) as r3,sum(je*points/100) as r4,sum(if({$uidstrdown}=0,if(z=1,peilv1*je,0),if(z=1,{$peilv1strdown}*(100 {$zcstrdown})*je/100,0))) as r5,sum(je*uzp2) as r6,sum(if(z=1,peilv1*je,0)) as r7";
                $sql .= ",sum(if(z=1,(100 {$zcstrdown})/100*prize,0)) as r8,sum({$myzcstr}*je/100) as r9,sum(if({$uidstrdown}=0,(points*{$myzcstr}*je/(100*100)),{$pointsstrdown}*{$myzcstr}*je/(100*100))) as r10,sum({$mypointsstr}*{$myzcstr}*je/(100*100)) as r11,max({$myzcstr}) as r12,min({$myzcstr}) as r13,sum(if({$uidstrdown}=0,if(z=1,(peilv1*{$myzcstr})*je/100,0),if(z=1,{$peilv1strdown}*{$myzcstr}*je/100,0))) as r14,sum(if(z=1,{$myzcstr}/100*prize,0)) as r15,sum(uzp1*je) as r16,sum((100" . $zcstrdown . ")*je*uzp1/100) as r17,sum(uzp1*je*$myzcstr/100) as r18";
                if ($layer > 0) {
                    $sql .= ",sum((100 {$zcstrup})*je/100) as r19,sum({$mypointsstr}*(100 {$zcstrup})*je/(100*100)) as r20,sum(if(z=1,(100 {$zcstrup})*je*{$mypeilv1str}/100,0)) as r21,sum(if(z=1,prize,0)) as r22,sum((100 {$zcstrup})*uzp1*je/100) as r23";
                }
            }
            $bb = [];
            foreach ($whs as $vs) {
                $bb[] = "{$sql} {$vs} and bs=1 and xtype!=2 and {$zstr}";
            }
            if(empty($bb)){
                unset($bao[$i]);
                continue;
            }
            $ssql = implode(" union all ", $bb);
            $bb = $db->select($ssql);
            $rr = ComFunc::sumbb($bb);
            $bao[$i]['zs'] = ComFunc::pr0($rr[0]);
            if ($bao[$i]['zs'] == 0) {
                unset($bao[$i]);
                continue;
            }
            $bao[$i]['upje'] = ComFunc::pr4($rr[1]);
            $bao[$i]['meprize'] = ComFunc::pr2($rr[15]);
            if ($bao[$i]['ifagent'] == '0') {
                $bao[$i]['zje'] = ComFunc::pr4($rr[1]);
                $bao[$i]['uje'] = ComFunc::pr4($rr[1]);
                $bao[$i]['sje'] = ComFunc::pr4($rr[1]);
                if ($jsstatus == 1) {
                    $bao[$i]['zeje'] = ComFunc::pr4($rr[6]);
                    $bao[$i]['tax'] = ComFunc::pr4($rr[16]);
                    $bao[$i]['utax'] = ComFunc::pr4($rr[17]);
                    $bao[$i]['shui'] = ComFunc::pr4($rr[2]);
                    $bao[$i]['zhong'] = ComFunc::pr4($rr[3]);
                    $bao[$i]['yk'] = ComFunc::pr4($bao[$i]['upje'] - $bao[$i]['shui'] - $bao[$i]['zhong']+$bao[$i]['utax']);
                    $bao[$i]['uyk'] = 0 - $bao[$i]['yk'];
                    $bao[$i]['ushui'] = $bao[$i]['shui'];
                    $bao[$i]['uzhong'] = $bao[$i]['zhong']-$bao[$i]['tax'];
                    $bao[$i]['ushuying'] = ComFunc::pr4($bao[$i]['uzhong']-$bao[$i]['uje']);
                } else {
                    $bao[$i]['zeje'] = 0;
                    $bao[$i]['tax'] = 0;
                    $bao[$i]['utax'] = 0;
                    $bao[$i]['shui'] = 0;
                    $bao[$i]['zhong'] = 0;
                    $bao[$i]['yk'] = 0;
                    $bao[$i]['uyk'] = 0;
                    $bao[$i]['ushui'] = 0;
                    $bao[$i]['uzhong'] = 0;
                    $bao[$i]['ushuying'] = 0;
                }
            } else {
                $bao[$i]['uje'] = ComFunc::pr4($rr[3]);
                $bao[$i]['sje'] = ComFunc::pr4($rr[3]);
                if ($jsstatus == 1) {
                    $bao[$i]['zeje'] = ComFunc::pr4($rr[6]);
                    $bao[$i]['tax'] = ComFunc::pr4($rr[16]);
                    $bao[$i]['utax'] = ComFunc::pr4($rr[17]);
                    $bao[$i]['shui'] = ComFunc::pr4($rr[2]);
                    $bao[$i]['zhong'] = ComFunc::pr4($rr[5]) - ComFunc::pr4($rr[8]);
                    $bao[$i]['yk'] = ComFunc::pr4($bao[$i]['upje'] - $bao[$i]['shui'] - $bao[$i]['zhong']+$bao[$i]['utax']);
                    $bao[$i]['uzhong'] = ComFunc::pr4($rr[7]-$bao[$i]['tax']);
                    $bao[$i]['ushui'] = ComFunc::pr4($rr[4]);
                    $bao[$i]['uyk'] = ComFunc::pr4($bao[$i]['uzhong'] + $bao[$i]['ushui'] - $bao[$i]['uje']);
                    $bao[$i]['ushuying'] = ComFunc::pr4($bao[$i]['uzhong']-$bao[$i]['uje']);
                } else {
                    $bao[$i]['zeje'] = 0;
                    $bao[$i]['tax'] = 0;
                    $bao[$i]['utax'] = 0;
                    $bao[$i]['shui'] = 0;
                    $bao[$i]['zhong'] = 0;
                    $bao[$i]['yk'] = 0;
                    $bao[$i]['uyk'] = 0;
                    $bao[$i]['ushui'] = 0;
                    $bao[$i]['uzhong'] = 0;
                    $bao[$i]['ushuying'] = 0;
                }
            }
            $bao[$i]['water_result'] = 0;
            $bao[$i]['mezc'] = ComFunc::pr4($rr[9]);
            if ($jsstatus == 1) {
                $bao[$i]['metax'] = ComFunc::pr4($rr[18]);
                if ($layer == 0) {
                    $bao[$i]['meshui'] = ComFunc::pr4($rr[10]);
                } else {
                    $bao[$i]['meshui'] = ComFunc::pr4($rr[11]);
                }
                $bao[$i]['mezhong'] = ComFunc::pr4($rr[14]);
                $bao[$i]['meyk'] = ComFunc::pr4($bao[$i]['mezc'] - $bao[$i]['meshui'] - $bao[$i]['mezhong']+$bao[$i]['meprize']+$bao[$i]['metax']);
            } else {
                $bao[$i]['metax'] = 0;
                $bao[$i]['meshui'] = 0;
                $bao[$i]['mezhong'] = 0;
                $bao[$i]['meyk'] = 0;
            }
            if ($layer > 0) {
                $bao[$i]['sendje'] = ComFunc::pr4($rr[19]);
                if ($jsstatus == 1) {
                    $bao[$i]['sendtax'] = ComFunc::pr4($rr[23]);
                    $bao[$i]['sendshui'] = ComFunc::pr4($rr[20]);
                    $bao[$i]['sendzhong'] = ComFunc::pr4($rr[21]) - ComFunc::pr4($rr[22]);
                    $bao[$i]['sendyk'] = ComFunc::pr4($bao[$i]['sendshui'] + $bao[$i]['sendzhong'] - $bao[$i]['sendje']-$bao[$i]['sendtax']);
                    //$tanshui = ComFunc::pr4($bao[$i]['meshui'] + $bao[$i]['sendshui'] - $bao[$i]['shui']);
                    //$bao[$i]['sendyk'] = ComFunc::pr4(abs($bao[$i]['yk'])-abs($bao[$i]['meyk']+$tanshui));
                } else {
                    $bao[$i]['sendtax'] = 0;
                    $bao[$i]['sendshui'] = 0;
                    $bao[$i]['sendzhong'] = 0;
                    $bao[$i]['sendyk'] = 0;
                }
            } else {
                $bao[$i]['sendtax'] = 0;
                $bao[$i]['sendje'] = 0;
                $bao[$i]['sendshui'] = 0;
                $bao[$i]['sendzhong'] = 0;
                $bao[$i]['sendyk'] = 0;
            }
            if($jsstatus == 1){
                $bao[$i]['shizhanjieguo'] = ComFunc::pr4($bao[$i]['mezc']-$bao[$i]['mezhong']+$bao[$i]['meprize']+$bao[$i]['metax']);
                if($myuser['layer'] == 0){
                    $bao[$i]['zuanshui'] = 0;
                }else{
                    $bao[$i]['zuanshui'] = ComFunc::pr4($bao[$i]['meshui']+$bao[$i]['sendshui']-$bao[$i]['shui']);
                }
                $bao[$i]['yingkuijieguo'] = ComFunc::pr4($bao[$i]['meyk']+$bao[$i]['zuanshui']);

                $bao[$i]['uje'] = ComFunc::pr4($bao[$i]['uje']-$bao[$i]['zeje']);
            }else{
                $bao[$i]['shizhanjieguo'] = 0;
                $bao[$i]['zuanshui'] = 0;
                $bao[$i]['yingkuijieguo'] = 0;
            }
            $rr = ComFunc::searchzcb($bb);
            $p1 = $rr[13];
            $p2 = $rr[12];
            $bao[$i]['mezcp'] = $p1 == $p2 ? $p1 . "%" : $p1 . "%/" . $p2 . "%";
            //$bao[$i]['mezcp'] = $p2 . "%";
        }
        $bao = array_values($bao);
        if ($layer > 0) {
            $whs = ComFunc::getsqls($datearr, $game, ["userid" => $uid], $dd, $qishu);
            $sql = "select count(id) as r1,sum(je) as r2,sum(je*points/100) as r3,sum(if(z=1,peilv1*je,0)) as r4,0 as r5,0 as r6";
            $bb = [];
            foreach ($whs as $vs) {
                $tt = $db->select("{$sql} {$vs} and bs=1 and xtype!=2 and {$zstr} ");
                $bb[] = $tt[0];
            }
            $rr = ComFunc::sumbb($bb);
            if ($rr[0] > 0) {
                $i = count($bao);
                $bao[$i]['username'] = "fly1";
                $bao[$i]['fly'] = 1;
                $bao[$i]['userid'] = $uid;
                $bao[$i]['layername'] = "补货";
                $bao[$i]['user'] = $myuser['username'];
                $bao[$i]['name'] = '';
                $bao[$i]['money'] = $myuser['kmoney'];
                $bao[$i]['zs'] = ComFunc::pr0($rr[0]);
                $bao[$i]['mezc'] = ComFunc::pr4($rr[1]);
                $bao[$i]['mezcp'] = '-100%';
                $bao[$i]['uje'] = $bao[$i]['mezc'];
                $bao[$i]['sje'] = $bao[$i]['mezc'];
                $bao[$i]['zeje'] = 0;
                $bao[$i]['water_result'] = 0;
                if ($jsstatus == 1) {
                    $bao[$i]['meshui'] = ComFunc::pr4($rr[2]);
                    $bao[$i]['mezhong'] = ComFunc::pr4($rr[3]);
                    $bao[$i]['meyk'] = ComFunc::pr4($bao[$i]['meshui'] + $bao[$i]['mezhong'] - $bao[$i]['mezc']);
                    $bao[$i]['sendje'] = $bao[$i]['mezc'];
                    $bao[$i]['sendshui'] = $bao[$i]['meshui'];
                    $bao[$i]['sendzhong'] = $bao[$i]['mezhong'];
                    $bao[$i]['sendyk'] = ComFunc::pr4($bao[$i]['meshui'] + $bao[$i]['mezhong'] - $bao[$i]['mezc']);
                    $bao[$i]['meshui'] = 0 - $bao[$i]['meshui'];
                    $bao[$i]['mezhong'] = 0 - $bao[$i]['mezhong'];
                } else {
                    $bao[$i]['meshui'] = 0;
                    $bao[$i]['mezhong'] = 0;
                    $bao[$i]['meyk'] = 0;
                    $bao[$i]['sendje'] = 0;
                    $bao[$i]['sendshui'] = 0;
                    $bao[$i]['sendzhong'] = 0;
                    $bao[$i]['sendyk'] = 0;
                    $bao[$i]['meshui'] = 0;
                    $bao[$i]['mezhong'] = 0;
                }
                $bao[$i]['mezc'] = 0 - $bao[$i]['mezc'];
                $bao[$i]['upje'] = 0;
                $bao[$i]['zje'] = 0;
                $bao[$i]['shui'] = 0;
                $bao[$i]['zhong'] = 0;
                $bao[$i]['yk'] = 0;
                $bao[$i]['ushui'] = 0;
                $bao[$i]['uzhong'] = 0;
                $bao[$i]['uyk'] = 0;
                $bao[$i]['ifagent'] = 0;
                $bao[$i]['meprize'] = 0;
                $bao[$i]['tax'] = 0;
                $bao[$i]['utax'] = 0;
                $bao[$i]['sendtax'] = 0;
                $bao[$i]['metax'] = 0;

                if ($jsstatus == 1) {
                    $bao[$i]['ushuying'] = ComFunc::pr4($bao[$i]['mezhong']-$bao[$i]['uje']);
                    $bao[$i]['shizhanjieguo'] = ComFunc::pr4($bao[$i]['mezc']-$bao[$i]['mezhong']+$bao[$i]['meprize']+$bao[$i]['metax']);
                    if($layer == 0){
                        $bao[$i]['zuanshui'] = 0;
                    }else{
                        $bao[$i]['zuanshui'] = ComFunc::pr4($bao[$i]['meshui']+$bao[$i]['sendshui']-$bao[$i]['shui']);
                    }
                    $bao[$i]['yingkuijieguo'] = ComFunc::pr4($bao[$i]['meyk']+$bao[$i]['zuanshui']);
                } else {
                    $bao[$i]['ushuying'] = 0;
                    $bao[$i]['shizhanjieguo'] = 0;
                    $bao[$i]['zuanshui'] = 0;
                    $bao[$i]['yingkuijieguo'] = 0;
                }
            }
        }
        view()->share('isagent', 0);
        view()->share('mbao', array_values($bao));
        view()->share('gbao', []);
        view()->share('tax', $tax);
        view()->share('water', $water);
        view()->share('layer', $layer);
        view()->share('username', $myuser['username']);
        view()->share('enable_mjpei', x_config('enable_mjpei'));
        return view('common.report.list');
    }

    public function getfid(Request $request){
        $uid = $request->input('uid','');
        $userid = Constants::$SUID;
        if (!ComFunc::checkfid($uid, $userid)) exit;
        if ($uid == $userid) {
            $arr = array('1', $userid, 0, 0);
            echo json_encode($arr);
            exit;
        }
        $fid = User::where('userid', $uid)->value('fid');
        $user = User::where('userid', $fid)->select(['userid','layer','username'])->first();
        $arr = array('1', $user['userid'], $user['layer'], $user['username']);
        echo json_encode($arr);
    }

    public function list(Request $request){
        $detail = $request->input('detail',0);
        if($detail == 1){
            return $this->list_detail($request,$detail);
        }else{
            return $this->list1($request,$detail);
        }
    }

    public function list_detail(Request $request,$detail){
        $game = $request->input('lottery','');
        $username = $request->input('username','');
        $start = $request->input('begin','');
        $end = $request->input('end','');
        $qishu = $request->input('period','');
        //$detail = $request->input('detail',0);
        $jsstatus = $request->input('settle','');
        if(!is_numeric($jsstatus)){
            if($jsstatus == 'false' || $jsstatus == false) {
                $jsstatus = 2;
            }else{
                $jsstatus = 1;
            }
        }
        $filter = $request->input('filter','');
        $yk = $request->input('nd','');
        $je = $request->input('amount','');
        $userid = Constants::$SUID;
        $db = Db::connection();
        $start = ComFunc::rdates($start);
        $end = ComFunc::rdates($end);
        $filter = trim($filter);
        $uidson = '';
        view()->share('period', $qishu);
        view()->share('begin', $start);
        view()->share('end', $end);
        view()->share('jsstatus', $jsstatus);
        view()->share('detail', $detail);
        view()->share('tax_name', x_config('tax_name'));
        view()->share('water_name', x_config('water_name'));
        if ($filter != '') {
            $tuser = User::where('username', $filter)->select(['userid','fid'])->first();
            if (empty($tuser)) {
                view()->share('cuser', '');
                view()->share('msg', '未找到指定用户');
                return view('common.report.list', ['data' => []]);
            }
            $uid = $tuser['fid'];
            $uidson = $tuser['userid'];
            $myuser = User::where('userid',$uid)->select(['userid','username','layer'])->first();
        }else{
            if(empty($username)){
                $myuser = User::where('userid',$userid)->select(['userid','username','layer'])->first();
                $uid = $userid;
            }else{
                $myuser = User::where('username',$username)->select(['userid','username','layer'])->first();
                $uid = $myuser['userid'];
            }
        }
        $layers = json_decode(x_config('layer'), true);
        $layername = $myuser['layer'] == 0 ? '公司' : $layers[$myuser['layer'] - 1];
        view()->share('layername', $layername);
        view()->share('cuser', $myuser['username']);
        $tbs = $db->select("SHOW TABLES LIKE  'x_lib_20%'");
        $tb = "";
        foreach ($tbs as $k => $v) {
            $tb .= array_values($v)[0];
        }
        $dd = ComFunc::getthisdate();
        $datearr = ComFunc::getdatearr($start, $end, $dd, $tb);
        if(empty($game)){
            $game = Game::whereIn('gid', function ($query){
                $query->select('gid')->from('gamecs')->where(['userid'=>$this->uid,'ifok'=>1]);
            })->where('ifopen', 1)->select(['gid','gname','lottery'])->get();
        }else{
            $gstr = explode(',',$game);
            $game = Game::whereIn('lottery',$gstr)->where('ifopen', 1)->select(['gid','gname','lottery'])->get();
        }
        if ($jsstatus == 1) {
            $zstr = " z not in(2,7,9) ";
        } else if ($jsstatus == 2) {
            $zstr = " z=9 ";
        } else if ($jsstatus == 3) {
            $zstr = " z=7 ";
        }
        if(!empty($je)){
            $zstr .= " and je=$je ";
        }
        if(!empty($yk)){
            $zstr .= " and je=-$yk ";
        }
        $bao = ComFunc::topuser($uid);
        $cb = count($bao);
        $zbao = array();
        $mbao = array();
        $layer = $myuser['layer'];
        $tax = x_config('plat_tax_status');
        $water = x_config('plat_water_status');
        $myzcstr = 'zc' . $layer;
        $mypointsstr = 'points' . $layer;
        $mypeilv1str = 'peilv1' . $layer;
        $tbsql = [];
        foreach ($game as $j=>$gitem) {
            $tbao = $bao;
            for ($i = 0; $i < $cb; $i++) {
                if ($uidson != '' & $uidson != $tbao[$i]['userid']) {
                    unset($tbao[$i]);
                    continue;
                }
                $tbao[$i]['fly'] = 0;
                if ($layer < 10) {
                    $uidstrdown = 'uid' . ($layer + 1);
                    $pointsstrdown = 'points' . ($layer + 1);
                    $peilv1strdown = 'peilv1' . ($layer + 1);
                } else {
                    $uidstrdown = 'userid';
                    $pointsstrdown = 'points';
                    $peilv1strdown = 'peilv1';
                }
                $zcstrdown = '';
                for ($k = 10; $k >= $tbao[$i]['layer']; $k--) {
                    $zcstrdown .= '-zc' . $k;
                }
                $zcstrup = $zcstrdown . '-zc' . $k;
                if ($tbao[$i]['ifagent'] == '0') {
                    $whs = ComFunc::getsqls($datearr, [$gitem['gid']], ["userid" => $tbao[$i]['userid']], $dd, $qishu);
                    $sql = "select count(id) as r0,sum(je) as r1,sum(je*points/100) as r2,sum(if(z=1,peilv1*je,0)) as r3,sum(je*uzp2) as r4,sum(uzp1*je) as r5,sum(uzp1*je) as r6";
                    $bb = [];
                    foreach ($whs as $vs) {
                        $itemsql = "$sql $vs and bs=1 and xtype!=2 and $zstr";
                        $tbsql[] = $itemsql;
                        $tt = $db->select($itemsql);
                        $bb[] = $tt[0];
                    }
                    $rr = ComFunc::sumbb($bb);
                    $tbao[$i]['upje'] = ComFunc::pr4($rr[1]);
                    $tbao[$i]['zje'] = ComFunc::pr4($rr[1]);
                    $tbao[$i]['uje'] = ComFunc::pr4($rr[1]);
                    $tbao[$i]['sje'] = ComFunc::pr4($rr[1]);
                    $tbao[$i]['zs'] = ComFunc::pr0($rr[0]);
                    if ($tbao[$i]['upje'] == 0) {
                        unset($tbao[$i]);
                        continue;
                    }
                    if ($jsstatus == 1) {
                        $tbao[$i]['tax'] = ComFunc::pr4($rr[5]);
                        $tbao[$i]['utax'] = ComFunc::pr4($rr[6]);
                        $tbao[$i]['shui'] = ComFunc::pr4($rr[2]);
                        $tbao[$i]['zhong'] = ComFunc::pr4($rr[3]);
                        $tbao[$i]['zeje'] = ComFunc::pr4($rr[4]);
                        $tbao[$i]['yk'] = ComFunc::pr4($tbao[$i]['upje'] - $tbao[$i]['shui'] - $tbao[$i]['zhong']+$tbao[$i]['utax']);
                        $tbao[$i]['uyk'] = 0 - $tbao[$i]['yk'];
                        $tbao[$i]['ushui'] = $tbao[$i]['shui'];
                        $tbao[$i]['uzhong'] = $tbao[$i]['zhong']-$tbao[$i]['tax'];
                    } else {
                        $tbao[$i]['zeje'] = 0;
                        $tbao[$i]['tax'] = 0;
                        $tbao[$i]['utax'] = 0;
                        $tbao[$i]['shui'] = 0;
                        $tbao[$i]['zhong'] = 0;
                        $tbao[$i]['yk'] = 0;
                        $tbao[$i]['uyk'] = 0;
                        $tbao[$i]['ushui'] = 0;
                        $tbao[$i]['uzhong'] = 0;
                    }
                } else {
                    $whs = ComFunc::getsqls($datearr, [$gitem['gid']], ["userid" => $tbao[$i]['userid'], $uidstrdown => $tbao[$i]['userid']], $dd, $qishu);
                    $sql = "select count(id) as r0,sum((100" . $zcstrdown . ")*je/100) as r1,sum(if($uidstrdown=0,(points*je/100),$pointsstrdown*je*(100 $zcstrdown)/(100*100))) as r2,sum(je) as r3,sum(je*points/100) as r4,sum(if($uidstrdown=0,if(z=1,peilv1*je,0),if(z=1,$peilv1strdown*(100 $zcstrdown)*je/100,0))) as r5,sum(je*uzp2) as r6,sum(if(z=1,peilv1*je,0)) as r7,sum(uzp1*je) as r8,sum((100" . $zcstrdown . ")*je*uzp1/100) as r9";
                    $bb = [];
                    foreach ($whs as $vs) {
                        $itemsql = "$sql $vs and bs=1 and xtype!=2 and $zstr";
                        $tbsql[] = $itemsql;
                        $tt = $db->select($itemsql);
                        $bb[] = $tt[0];
                    }
                    $rr = ComFunc::sumbb($bb);
                    $tbao[$i]['zs'] = ComFunc::pr0($rr[0]);
                    $tbao[$i]['upje'] = ComFunc::pr4($rr[1]);
                    $tbao[$i]['uje'] = ComFunc::pr4($rr[3]);
                    $tbao[$i]['sje'] = ComFunc::pr4($rr[3]);
                    $tbao[$i]['ushui'] = ComFunc::pr4($rr[4]);
                    if ($tbao[$i]['zs'] == 0) {
                        unset($tbao[$i]);
                        continue;
                    }
                    if ($jsstatus == 1) {
                        $tbao[$i]['tax'] = ComFunc::pr4($rr[8]);
                        $tbao[$i]['utax'] = ComFunc::pr4($rr[9]);
                        $tbao[$i]['shui'] = ComFunc::pr4($rr[2]);
                        $tbao[$i]['zhong'] = ComFunc::pr4($rr[5]);
                        $tbao[$i]['zeje'] = ComFunc::pr4($rr[6]);
                        $tbao[$i]['yk'] = ComFunc::pr4($tbao[$i]['upje'] - $tbao[$i]['shui'] - $tbao[$i]['zhong']+$tbao[$i]['utax']);
                        $tbao[$i]['uzhong'] = ComFunc::pr4($rr[7] - $tbao[$i]['tax']);
                        $tbao[$i]['uyk'] = ComFunc::pr4($tbao[$i]['uzhong'] + $tbao[$i]['ushui'] - $tbao[$i]['uje']);
                    } else {
                        $tbao[$i]['zeje'] = 0;
                        $tbao[$i]['tax'] = 0;
                        $tbao[$i]['utax'] = 0;
                        $tbao[$i]['shui'] = 0;
                        $tbao[$i]['zhong'] = 0;
                        $tbao[$i]['yk'] = 0;
                        $tbao[$i]['uyk'] = 0;
                        $tbao[$i]['ushui'] = 0;
                        $tbao[$i]['uzhong'] = 0;
                    }
                }
                $tbao[$i]['water_result'] = 0;
                if ($uidstrdown == 'userid') {
                    $whs = ComFunc::getsqls($datearr, [$gitem['gid']], ["userid" => $tbao[$i]['userid']], $dd, $qishu);
                } else {
                    $whs = ComFunc::getsqls($datearr, [$gitem['gid']], ["userid" => $tbao[$i]['userid'], $uidstrdown => $tbao[$i]['userid']], $dd, $qishu);
                }
                if ($layer > 0) {
                    $sql = "select 0 as r0,sum($myzcstr*je/100) as r1,sum(if($uidstrdown=0,(points*$myzcstr*je/(100*100)),$pointsstrdown*$myzcstr*je/(100*100))) as r2,sum($mypointsstr*$myzcstr*je/(100*100)) as r3,max($myzcstr) as r4,min($myzcstr) as r5,sum(if($uidstrdown=0,if(z=1,(peilv1*$myzcstr)*je/100,0),if(z=1,$peilv1strdown*$myzcstr*je/100,0))) as r6,sum(uzp1*je*$myzcstr/100) as r7";
                    //$sql = "select 0 ,sum($myzcstr*je/100) ,sum(if($uidstrdown=0,(points*$myzcstr*je/(100*100)),$pointsstrdown*$myzcstr*je/(100*100))) ,sum(points1*$myzcstr*je/(100*100)) ,max($myzcstr) ,min($myzcstr) ,sum(if($uidstrdown=0,if(z=1,(peilv1*$myzcstr)*je/100,0),if(z=1,$peilv1strdown*$myzcstr*je/100,0)))";
                    $bb = [];
                    foreach ($whs as $vs) {
                        $itemsql = "$sql $vs and bs=1 and xtype!=2 and $zstr ";
                        $tbsql[] = $itemsql;
                        $tt = $db->select($itemsql);
                        $bb[] = $tt[0];
                    }
                } else {
                    $sql = "select 0 as r0,sum($myzcstr*je/100) as r1,sum(if($uidstrdown=0,(points*$myzcstr*je/(100*100)),$pointsstrdown*$myzcstr*je/(100*100))) as r2,sum(points1*$myzcstr*je/(100*100)) as r3,max($myzcstr) as r4,min($myzcstr) as r5,sum(if($uidstrdown=0,if(z=1,(peilv1*$myzcstr)*je/100,0),if(z=1,$peilv1strdown*$myzcstr*je/100,0))) as r6,sum(uzp1*je*$myzcstr/100) as r7";
                    $bb = [];
                    foreach ($whs as $vs) {
                        $itemsql = "$sql $vs and bs=1 and xtype!=2 and $zstr ";
                        $tbsql[] = $itemsql;
                        $tt = $db->select($itemsql);
                        $bb[] = $tt[0];
                    }
                }
                $rr = ComFunc::searchzc($bb);
                $p1 = $rr[5];
                $p2 = $rr[4];
                $tbao[$i]['mezcp'] = $p1 == $p2 ? $p1 . "%" : $p1 . "%/" . $p2 . "%";
                //$tbao[$i]['mezcp'] = $p2 . "%";
                $rr = ComFunc::sumbb($bb);
                $tbao[$i]['mezc'] = ComFunc::pr1($rr[1]);

                if ($jsstatus == 1) {
                    $tbao[$i]['metax'] = ComFunc::pr4($rr[7]);
                    if ($layer == 0) $tbao[$i]['meshui'] = ComFunc::pr4($rr[2]);
                    else $tbao[$i]['meshui'] = ComFunc::pr4($rr[3]);
                    $tbao[$i]['mezhong'] = ComFunc::pr4($rr[6]);
                    $tbao[$i]['meyk'] = ComFunc::pr4($tbao[$i]['mezc'] - $tbao[$i]['meshui'] - $tbao[$i]['mezhong']+$tbao[$i]['metax']);
                } else {
                    $tbao[$i]['metax'] = 0;
                    $tbao[$i]['meshui'] = 0;
                    $tbao[$i]['mezhong'] = 0;
                    $tbao[$i]['meyk'] = 0;
                }

                if ($uidstrdown == 'userid') {
                    $whs = ComFunc::getsqls($datearr, [$gitem['gid']], ["userid" => $tbao[$i]['userid']], $dd, $qishu);
                } else {
                    $whs = ComFunc::getsqls($datearr, [$gitem['gid']], ["userid" => $tbao[$i]['userid'], $uidstrdown => $tbao[$i]['userid']], $dd, $qishu);
                }
                if ($layer > 0) {
                    $sql = "select 0 as r0,sum((100 $zcstrup)*je/100) as r1,sum($mypointsstr*(100 $zcstrup)*je/(100*100)) as r2,sum(if(z=1,(100 $zcstrup)*je*$mypeilv1str/100,0)) as r3,0 as r4,sum((100 {$zcstrup})*uzp1*je/100) as r5";
                    $bb = [];
                    foreach ($whs as $vs) {
                        $itemsql = "$sql $vs and bs=1 and xtype!=2 and $zstr ";
                        $tbsql[] = $itemsql;
                        $tt = $db->select($itemsql);
                        $bb[] = $tt[0];
                    }
                    $rr = ComFunc::sumbb($bb);
                    $tbao[$i]['sendje'] = ComFunc::pr4($rr[1]);
                    if ($jsstatus == 1) {
                        $tbao[$i]['sendtax'] = ComFunc::pr4($rr[5]);
                        $tbao[$i]['sendshui'] = ComFunc::pr4($rr[2]);
                        $tbao[$i]['sendzhong'] = ComFunc::pr4($rr[3]);
                        $tbao[$i]['sendyk'] = ComFunc::pr4($tbao[$i]['sendshui'] + $tbao[$i]['sendzhong'] - $tbao[$i]['sendje']-$tbao[$i]['sendtax']);
                    } else {
                        $tbao[$i]['sendtax'] = 0;
                        $tbao[$i]['sendshui'] = 0;
                        $tbao[$i]['sendzhong'] = 0;
                        $tbao[$i]['sendyk'] = 0;
                    }
                } else {
                    $tbao[$i]['sendtax'] = 0;
                    $tbao[$i]['sendje'] = 0;
                    $tbao[$i]['sendshui'] = 0;
                    $tbao[$i]['sendzhong'] = 0;
                    $tbao[$i]['sendyk'] = 0;
                }

                if ($jsstatus == 1) {
                    $tbao[$i]['ushuying'] = ComFunc::pr4($tbao[$i]['uzhong']-$tbao[$i]['uje']);
                    $tbao[$i]['shizhanjieguo'] = ComFunc::pr4($tbao[$i]['mezc']-$tbao[$i]['mezhong']+$tbao[$i]['metax']);
                    if($layer == 0){
                        $tbao[$i]['zuanshui'] = 0;
                    }else{
                        $tbao[$i]['zuanshui'] = ComFunc::pr4($tbao[$i]['meshui']+$tbao[$i]['sendshui']-$tbao[$i]['shui']);
                    }
                    $tbao[$i]['yingkuijieguo'] = ComFunc::pr4($tbao[$i]['meyk']+$tbao[$i]['zuanshui']);

                    $tbao[$i]['uje'] = ComFunc::pr4($tbao[$i]['uje']-$tbao[$i]['zeje']);
                } else {
                    $tbao[$i]['ushuying'] = 0;
                    $tbao[$i]['shizhanjieguo'] = 0;
                    $tbao[$i]['zuanshui'] = 0;
                    $tbao[$i]['yingkuijieguo'] = 0;
                }
                $tbao[$i]['water_result'] = 0;
            }
            $tbao = array_values($tbao);
            if ($layer > 0) {
                $whs = ComFunc::getsqls($datearr, [$gitem['gid']], ["userid" => $uid], $dd, $qishu);
                $sql = "select count(id) ,sum(je) ,sum(je*points/100) ,sum(if(z=1,peilv1*je,0)) ,0 ,0 ";
                $bb = [];
                foreach ($whs as $vs) {
                    $itemsql = "$sql $vs and bs=1 and xtype!=2 and $zstr ";
                    $tbsql[] = $itemsql;
                    $tt = $db->select($itemsql);
                    $bb[] = $tt[0];
                }
                $rr = ComFunc::sumbb($bb);
                if ($rr[0] > 0) {
                    $i = count($tbao);
                    $tbao[$i]['username'] = "fly1";
                    $tbao[$i]['fly'] = 1;
                    $tbao[$i]['userid'] = $uid;
                    $ur = User::where('userid', $uid)->select(['username','name','kmoney'])->first();
                    $tbao[$i]['layername'] = "补货";
                    $tbao[$i]['user'] = $ur['username'];
                    $tbao[$i]['name'] = $ur['name'];
                    $tbao[$i]['money'] = $ur['kmoney'];
                    $tbao[$i]['zs'] = ComFunc::pr0($rr[0]);
                    $tbao[$i]['mezc'] = ComFunc::pr4($rr[1]);
                    $tbao[$i]['mezcp'] = '-100%';
                    $tbao[$i]['uje'] = $tbao[$i]['mezc'];
                    $tbao[$i]['sje'] = $tbao[$i]['mezc'];
                    $tbao[$i]['zeje'] = 0;
                    $tbao[$i]['water_result'] = 0;
                    if ($jsstatus == 1) {
                        $tbao[$i]['meshui'] = ComFunc::pr4($rr[2]);
                        $tbao[$i]['mezhong'] = ComFunc::pr4($rr[3]);
                        $tbao[$i]['meyk'] = ComFunc::pr4($tbao[$i]['meshui'] + $tbao[$i]['mezhong'] - $tbao[$i]['mezc']);
                        $tbao[$i]['sendje'] = $tbao[$i]['mezc'];
                        $tbao[$i]['sendshui'] = $tbao[$i]['meshui'];
                        $tbao[$i]['sendzhong'] = $tbao[$i]['mezhong'];
                        $tbao[$i]['sendyk'] = ComFunc::pr4($tbao[$i]['meshui'] + $tbao[$i]['mezhong'] - $tbao[$i]['mezc']);
                        $tbao[$i]['meshui'] = 0 - $tbao[$i]['meshui'];
                        $tbao[$i]['mezhong'] = 0 - $tbao[$i]['mezhong'];
                    } else {
                        $tbao[$i]['meshui'] = 0;
                        $tbao[$i]['mezhong'] = 0;
                        $tbao[$i]['meyk'] = 0;
                        $tbao[$i]['sendje'] = 0;
                        $tbao[$i]['sendshui'] = 0;
                        $tbao[$i]['sendzhong'] = 0;
                        $tbao[$i]['sendyk'] = 0;
                        $tbao[$i]['meshui'] = 0;
                        $tbao[$i]['mezhong'] = 0;
                    }
                    $tbao[$i]['mezc'] = 0 - $tbao[$i]['mezc'];
                    $tbao[$i]['upje'] = 0;
                    $tbao[$i]['zje'] = 0;
                    $tbao[$i]['shui'] = 0;
                    $tbao[$i]['zhong'] = 0;
                    $tbao[$i]['yk'] = 0;
                    $tbao[$i]['ushui'] = 0;
                    $tbao[$i]['uzhong'] = 0;
                    $tbao[$i]['uyk'] = 0;
                    $tbao[$i]['ifagent'] = 0;
                    $tbao[$i]['tax'] = 0;
                    $tbao[$i]['utax'] = 0;
                    $tbao[$i]['sendtax'] = 0;
                    $tbao[$i]['metax'] = 0;

                    if ($jsstatus == 1) {
                        $tbao[$i]['ushuying'] = ComFunc::pr4($tbao[$i]['mezhong']-$tbao[$i]['uje']);
                        $tbao[$i]['shizhanjieguo'] = ComFunc::pr4($tbao[$i]['mezc']-$tbao[$i]['mezhong']+$tbao[$i]['metax']);
                        if($layer == 0){
                            $tbao[$i]['zuanshui'] = 0;
                        }else{
                            $tbao[$i]['zuanshui'] = ComFunc::pr4($tbao[$i]['meshui']+$tbao[$i]['sendshui']-$tbao[$i]['shui']);
                        }
                        $tbao[$i]['yingkuijieguo'] = ComFunc::pr4($tbao[$i]['meyk']+$tbao[$i]['zuanshui']);
                    } else {
                        $tbao[$i]['ushuying'] = 0;
                        $tbao[$i]['shizhanjieguo'] = 0;
                        $tbao[$i]['zuanshui'] = 0;
                        $tbao[$i]['yingkuijieguo'] = 0;
                    }
                }
            }
            foreach ($tbao as $titem) {
                if(isset($mbao[$titem['user']])){
                    $mbao[$titem['user']]['zs'] = ComFunc::pr4($mbao[$titem['user']]['zs']+$titem['zs']);
                    $mbao[$titem['user']]['uje'] = ComFunc::pr4($mbao[$titem['user']]['uje']+$titem['uje']);
                    $mbao[$titem['user']]['sje'] = ComFunc::pr4($mbao[$titem['user']]['sje']+$titem['sje']);
                    $mbao[$titem['user']]['zeje'] = ComFunc::pr4($mbao[$titem['user']]['zeje']+$titem['zeje']);
                    $mbao[$titem['user']]['water_result'] = ComFunc::pr4($mbao[$titem['user']]['water_result']+$titem['water_result']);
                    $mbao[$titem['user']]['ushuying'] = ComFunc::pr4($mbao[$titem['user']]['ushuying']+$titem['ushuying']);
                    $mbao[$titem['user']]['ushui'] = ComFunc::pr4($mbao[$titem['user']]['ushui']+$titem['ushui']);
                    $mbao[$titem['user']]['uyk'] = ComFunc::pr4($mbao[$titem['user']]['uyk']+$titem['uyk']);
                    $mbao[$titem['user']]['tax'] = ComFunc::pr4($mbao[$titem['user']]['tax']+$titem['tax']);
                    $mbao[$titem['user']]['metax'] = ComFunc::pr4($mbao[$titem['user']]['metax']+$titem['metax']);
                    $mbao[$titem['user']]['yk'] = ComFunc::pr4($mbao[$titem['user']]['yk']+$titem['yk']);
                    $mbao[$titem['user']]['mezc'] = ComFunc::pr4($mbao[$titem['user']]['mezc']+$titem['mezc']);
                    $mbao[$titem['user']]['shizhanjieguo'] = ComFunc::pr4($mbao[$titem['user']]['shizhanjieguo']+$titem['shizhanjieguo']);
                    $mbao[$titem['user']]['meshui'] = ComFunc::pr4($mbao[$titem['user']]['meshui']+$titem['meshui']);
                    $mbao[$titem['user']]['zuanshui'] = ComFunc::pr4($mbao[$titem['user']]['zuanshui']+$titem['zuanshui']);
                    $mbao[$titem['user']]['yingkuijieguo'] = ComFunc::pr4($mbao[$titem['user']]['yingkuijieguo']+$titem['yingkuijieguo']);
                    $mbao[$titem['user']]['sendje'] = ComFunc::pr4($mbao[$titem['user']]['sendje']+$titem['sendje']);
                    $mbao[$titem['user']]['sendyk'] = ComFunc::pr4($mbao[$titem['user']]['sendyk']+$titem['sendyk']);
                }else{
                    $mbaoitem = array();
                    $mbaoitem['user'] = $titem['user'];
                    $mbaoitem['name'] = $titem['name'];
                    $mbaoitem['money'] = $titem['money'];
                    $mbaoitem['layername'] = $titem['layername'];
                    $mbaoitem['ifagent'] = $titem['ifagent'];
                    $mbaoitem['fly'] = $titem['fly'];
                    $mbaoitem['zs'] = $titem['zs'];
                    $mbaoitem['uje'] = $titem['uje'];
                    $mbaoitem['sje'] = $titem['sje'];
                    $mbaoitem['zeje'] = $titem['zeje'];
                    $mbaoitem['water_result'] = $titem['water_result'];
                    $mbaoitem['ushuying'] = $titem['ushuying'];
                    $mbaoitem['ushui'] = $titem['ushui'];
                    $mbaoitem['uyk'] = $titem['uyk'];
                    $mbaoitem['tax'] = $titem['tax'];
                    $mbaoitem['metax'] = $titem['metax'];
                    $mbaoitem['yk'] = $titem['yk'];
                    $mbaoitem['mezcp'] = $titem['mezcp'];
                    $mbaoitem['mezc'] = $titem['mezc'];
                    $mbaoitem['shizhanjieguo'] = $titem['shizhanjieguo'];
                    $mbaoitem['meshui'] = $titem['meshui'];
                    $mbaoitem['zuanshui'] = $titem['zuanshui'];
                    $mbaoitem['yingkuijieguo'] = $titem['yingkuijieguo'];
                    $mbaoitem['sendje'] = $titem['sendje'];
                    $mbaoitem['sendyk'] = $titem['sendyk'];
                    $mbao[$titem['user']] = $mbaoitem;
                }
            }
            if (count($tbao) > 0) {
                $zbao[$j]['bao'] = $tbao;
                unset($tbao);
                $zbao[$j]['gname'] = $gitem['gname'];
                $zbao[$j]['lottery'] = $gitem['lottery'];
            }
        }
        view()->share('isagent', 0);
        view()->share('mbao', array_values($mbao));
        view()->share('gbao', $zbao);
        view()->share('tax', $tax);
        view()->share('water', $water);
        view()->share('layer', $layer);
        view()->share('username', $myuser['username']);
        view()->share('enable_mjpei', x_config('enable_mjpei'));
        return view('common.report.list');
    }

    public function list_game(Request $request){
        $game = $request->input('lottery','');
        $username = $request->input('username','');
        $start = $request->input('begin','');
        $end = $request->input('end','');
        $qishu = $request->input('period','');
        $jsstatus = $request->input('settle','');
        if(!is_numeric($jsstatus)){
            if($jsstatus == 'false' || $jsstatus == false) {
                $jsstatus = 2;
            }else{
                $jsstatus = 1;
            }
        }
        //$filter = $request->input('filter','');
        $yk = $request->input('nd','');
        $je = $request->input('amount','');
        $userid = Constants::$SUID;
        $db = Db::connection();
        $start = ComFunc::rdates($start);
        $end = ComFunc::rdates($end);
        view()->share('period', $qishu);
        $layers = json_decode(x_config('layer'), true);
        view()->share('begin', $start);
        view()->share('end', $end);
        view()->share('jsstatus', $jsstatus);
        view()->share('tax_name', x_config('tax_name'));
        view()->share('water_name', x_config('water_name'));
        if(empty($username)){
            $myuser = User::where('userid',$userid)->select(['userid','username','layer'])->first();
            $uid = $userid;
        }else{
            $myuser = User::where('username',$username)->select(['userid','username','layer'])->first();
            if (empty($myuser)) {
                view()->share('msg', '未找到指定数据');
                view()->share('bao', []);
                view()->share('layername', '');
                view()->share('cuser', '');
                view()->share('username', '');
                view()->share('tax_name', x_config('tax_name'));
                return view('common.report.list_game');
            }
            $uid = $myuser['userid'];
        }
        $layername = $myuser['layer'] == 0 ? '公司' : $layers[$myuser['layer'] - 1];
        view()->share('layername', $layername);
        view()->share('cuser', $myuser['username']);
        if(empty($game)){
            $game = Game::whereIn('gid', function ($query){
                $query->select('gid')->from('gamecs')->where(['userid'=>$this->uid,'ifok'=>1]);
            })->where('ifopen', 1)->pluck('gid')->toArray();
        }else{
            $game = Game::whereIn('lottery',explode(',',$game))->where('ifopen', 1)->pluck('gid')->toArray();
        }
        if ($jsstatus == 1) {
            $zstr = " z not in(2,7,9) ";
        } elseif ($jsstatus == 2) {
            $zstr = " z=9 ";
        } elseif ($jsstatus == 3) {
            $zstr = " z=7 ";
        }
        $layer = $myuser['layer'];
        $tax = x_config('plat_tax_status');
        $water = x_config('plat_water_status');
        if ($layer == 0) {
            $myzcstr = 'zc' . $layer;
            $mypointsstr = '';
            $mypeilv1str = '';
        } else {
            $myzcstr = 'zc' . $layer;
            $mypointsstr = 'points' . $layer;
            $mypeilv1str = 'peilv1' . $layer;
        }
        $zcstrdown = '';
        for ($k = 10; $k > $layer; $k--) {
            $zcstrdown .= '-zc' . $k;
        }
        $zcstrup = $zcstrdown . '-zc' . $k;
        if ($layer < 10) {
            $uidstrdown = 'uid' . ($layer + 1);
            $pointsstrdown = 'points' . ($layer + 1);
            $peilv1strdown = 'peilv1' . ($layer + 1);
        } else {
            $uidstrdown = 'userid';
            $pointsstrdown = 'points';
            $peilv1strdown = 'peilv1';
        }
        $tbs = $db->select("SHOW TABLES LIKE  'x_lib_20%'");
        $tb = "";
        foreach ($tbs as $v) {
            $tb .= array_values($v)[0];
        }
        $dd = ComFunc::getthisdate();
        $datearr = ComFunc::getdatearr($start, $end, $dd, $tb);
        $us = [];
        if ($layer > 0) {
            $us = ['uid' . $layer=>$uid];//,'userid'=>$uid
        }
        $whs = ComFunc::getsqlsfl($datearr, $game, $us, $dd, $qishu);
        $bb = [];
        $sql = "select gid,dftype ";
        foreach ($whs as $vs) {
            $bb[] = "{$sql} {$vs} and bs=1 and xtype!=2 and {$zstr} group by gid,dftype";
        }
        if(empty($bb)){
            view()->share('bao', []);
            view()->share('tax', $tax);
            view()->share('layer', $layer);
            view()->share('username', $myuser['username']);
            view()->share('tax_name', x_config('tax_name'));
            return view('common.report.list_game');
        }
        $ssql = implode(" union ", $bb);
        $list = $db->select($ssql);
        $tmp = array();
        $i = 0;
        $bao = [];
        foreach ($list as $item) {
            $bao[$i]['gid'] = $item['gid'];
            $bao[$i]['bid'] = $item['dftype'];
            $gid = $bao[$i]['gid'];
            $bid = $bao[$i]['bid'];
            if (!isset($tmp['g' . $gid])) {
                $tmp['g' . $gid] = Game::where('gid', $gid)->select(['gname','dftype','lottery'])->first();
            }
            $game = $tmp['g' . $gid];
            $dftype = json_decode($game['dftype'], true);
            $bao[$i]['gname'] = $game['gname'];
            $bao[$i]['bname'] = $dftype[$bid];
            $bao[$i]['lottery'] = $game['lottery'];
            $bb = [];
            $whs = ComFunc::getsqlsfl($datearr, [$gid], $us, $dd, $qishu);
            foreach ($whs as $vs) {
                if ($layer > 0) {
                    $join = " dftype='$bid' and bs=1 and xtype!=2 and {$zstr}";
                    $sql = "select count(id) as r0
			               ,sum(je) as r1
			               ,sum(je*points/100) as r2
						   ,sum((100 $zcstrdown)*je/100) as r3
						   ,sum(if($uidstrdown=0,(points*je/100),$pointsstrdown*je*(100 $zcstrdown)/(100*100))) as r4
						   ,sum($myzcstr*je/100) as r5
						   ,sum(if($uidstrdown=0,(points*$myzcstr*je/(100*100)),$pointsstrdown*$myzcstr*je/(100*100))) as r6
						   ,sum((100 $zcstrup)*je/100) as r7
						   ,sum($mypointsstr*(100 $zcstrup)*je/(100*100)) as r8
						   ,sum($mypointsstr*$myzcstr*je/(100*100)) as r9
						   ,max($myzcstr) as r10
						   ,min($myzcstr) as r11
						    $vs and $join";
                } else {
                    $join = " dftype='$bid' and bs=1 and xtype!=2 and {$zstr}";
                    $sql = "select count(id) as r0
			               ,sum(je) as r1
			               ,sum(je*points/100) as r2
						   ,sum((100 $zcstrdown)*je/100) as r3
						   ,sum(if($uidstrdown=0,(points*je/100),$pointsstrdown*je*(100 $zcstrdown)/(100*100))) as r4
						   ,sum($myzcstr*je/100) as r5
						   ,sum(if($uidstrdown=0,(points*$myzcstr*je/(100*100)),$pointsstrdown*$myzcstr*je/(100*100))) as r6
						   ,0 as r7
						   ,0 as r8
						   ,0 as r9
						   ,max($myzcstr) as r10
						   ,min($myzcstr) as r11
						    $vs and $join";
                }
                $bb[] = $sql;
            }
            $ssql = implode(" union all ", $bb);
            $rs = $db->select($ssql);
            $rr = ComFunc::searchzcgame($rs);
            $p1 = $rr[11];
            $p2 = $rr[10];
            $bao[$i]['mezcp'] = $p1 == $p2 ? $p1 . "%" : $p1 . "%/" . $p2 . "%";
            $rs = ComFunc::sumbb($rs);
            $bao[$i]['uje'] = ComFunc::pr4($rs[1]);
            $bao[$i]['sje'] = ComFunc::pr4($rs[1]);
            $bao[$i]['zje'] = ComFunc::pr4($rs[3]);
            $bao[$i]['upje'] = ComFunc::pr4($rs[3]);
            $bao[$i]['zs'] = ComFunc::pr4($rs[0]);
            $bao[$i]['mezc'] = ComFunc::pr4($rs[5]);
            //$bao[$i]['mezcp'] = ComFunc::pr4($rs[11]).'%';
            if ($jsstatus == 1) {
                $bao[$i]['shui'] = ComFunc::pr4($rs[4]);
                $bao[$i]['ushui'] = ComFunc::pr4($rs[2]);
                if ($layer == 0) $bao[$i]['meshui'] = ComFunc::pr4($rs[6]);
                else  $bao[$i]['meshui'] = ComFunc::pr4($rs[9]);
                $bao[$i]['sendje'] = ComFunc::pr4($rs[7]);
                $bao[$i]['sendshui'] = ComFunc::pr4($rs[8]);
            } else {
                $bao[$i]['shui'] = 0;
                $bao[$i]['ushui'] = 0;
                $bao[$i]['meshui'] = 0;
                $bao[$i]['sendje'] = 0;
                $bao[$i]['sendshui'] = 0;
            }
            if ($jsstatus == 1) {
                $bb = [];
                foreach ($whs as $vs) {
                    if ($layer > 0) {
                        $join = " dftype='$bid' and bs=1 and xtype!=2";
                        $sql = "select sum(je*peilv1) as r0
			               ,sum(if($uidstrdown=0,(peilv1*je),$peilv1strdown*(100 $zcstrdown)*je/100)) as r1
						   ,sum(if($uidstrdown=0,(peilv1*$myzcstr)*je/100,$peilv1strdown*$myzcstr*je/100)) as r2
						   ,sum((100 $zcstrup)*je*$mypeilv1str/100) as r3
						   ,sum(je*uzp2) as r4
						   ,sum((100{$zcstrup})*uzp1*je/100) as r5
						   ,sum((100{$zcstrdown})*je*uzp1/100) as r6
						   ,sum(uzp1*je) as r7
						   ,sum(uzp1*je*$myzcstr/100) as r8
						    $vs and $join and z=1";
                    } else {
                        $join = " dftype='$bid' and bs=1 and xtype!=2";
                        $sql = "select sum(je*peilv1) as r0
			               ,sum(if($uidstrdown=0,(peilv1*je),$peilv1strdown*(100 $zcstrdown)*je/100)) as r1
						   ,sum(if($uidstrdown=0,(peilv1*$myzcstr)*je/100,$peilv1strdown*$myzcstr*je/100)) as r2
						   ,0 as r3
						   ,sum(je*uzp2) as r4
						   ,sum((100{$zcstrup})*uzp1*je/100) as r5
						   ,sum((100{$zcstrdown})*je*uzp1/100) as r6
						   ,sum(uzp1*je) as r7
						   ,sum(uzp1*je*$myzcstr/100) as r8
						    $vs and $join and z=1";
                    }
                    $bb[] = $sql;
                }
                $ssql = implode(" union all ", $bb);
                $rs = $db->select($ssql);
                $rs = ComFunc::sumbb($rs);
                $bao[$i]['sendtax'] = ComFunc::pr4($rs[5]);
                $bao[$i]['utax'] = ComFunc::pr4($rs[6]);
                $bao[$i]['tax'] = ComFunc::pr4($rs[7]);
                $bao[$i]['metax'] = ComFunc::pr4($rs[8]);
                $bao[$i]['uzhong'] = ComFunc::pr4($rs[0]-$bao[$i]['tax']);
                $bao[$i]['zhong'] = ComFunc::pr4($rs[1]);
                $bao[$i]['zeje'] = ComFunc::pr4($rs[4]);
                $bao[$i]['mezhong'] = ComFunc::pr4($rs[2]);
                $bao[$i]['sendzhong'] = ComFunc::pr4($rs[3]);

                $bao[$i]['yk'] = ComFunc::pr4($bao[$i]['upje'] - $bao[$i]['shui'] - $bao[$i]['zhong']+$bao[$i]['utax']);
                $bao[$i]['uyk'] = ComFunc::pr4($bao[$i]['uzhong'] + $bao[$i]['ushui'] - $bao[$i]['uje']);
                $bao[$i]['meyk'] = ComFunc::pr4($bao[$i]['mezc'] - $bao[$i]['meshui'] - $bao[$i]['mezhong']+$bao[$i]['metax']);
                $bao[$i]['sendyk'] = ComFunc::pr4($bao[$i]['sendzhong'] + $bao[$i]['sendshui'] - $bao[$i]['sendje']-$bao[$i]['sendtax']);

                $bao[$i]['ushuying'] = ComFunc::pr4($bao[$i]['uzhong']-$bao[$i]['uje']);
                $bao[$i]['shizhanjieguo'] = ComFunc::pr4($bao[$i]['mezc']-$bao[$i]['mezhong']+$bao[$i]['metax']);
                if($layer == 0){
                    $bao[$i]['zuanshui'] = 0;
                }else{
                    $bao[$i]['zuanshui'] = ComFunc::pr4($bao[$i]['meshui']+$bao[$i]['sendshui']-$bao[$i]['shui']);
                }
                $bao[$i]['yingkuijieguo'] = ComFunc::pr4($bao[$i]['meyk']+$bao[$i]['zuanshui']);

                $bao[$i]['uje'] = ComFunc::pr4($bao[$i]['uje']-$bao[$i]['zeje']);
            } else {
                $bao[$i]['sendtax'] = 0;
                $bao[$i]['utax'] = 0;
                $bao[$i]['tax'] = 0;
                $bao[$i]['metax'] = 0;
                $bao[$i]['uzhong'] = 0;
                $bao[$i]['zhong'] = 0;
                $bao[$i]['mezhong'] = 0;
                $bao[$i]['sendzhong'] = 0;
                $bao[$i]['yk'] = 0;
                $bao[$i]['uyk'] = 0;
                $bao[$i]['meyk'] = 0;
                $bao[$i]['sendyk'] = 0;
                $bao[$i]['ushuying'] = 0;
                $bao[$i]['shizhanjieguo'] = 0;
                $bao[$i]['zuanshui'] = 0;
                $bao[$i]['yingkuijieguo'] = 0;
                $bao[$i]['zeje'] = 0;
            }
            $bao[$i]['water_result'] = 0;
            $i++;
        }
        count($bao) > 0 && sort($bao);
        view()->share('isagent', 0);
        view()->share('bao', $bao);
        view()->share('tax', $tax);
        view()->share('water', $water);
        view()->share('layer', $layer);
        view()->share('username', $myuser['username']);
        return view('common.report.list_game');
    }

    public function getqishu(Request $request){
        $gid = $request->input('gid','');
        $start = $request->input('start','');
        $end = $request->input('end','');
        $start = ComFunc::rdates($start);
        $end = ComFunc::rdates($end);
        $start = strtotime($start);
        $end = strtotime($end);
        $list = Kj::where(['gid' => $gid])->where('dates', '>=', $start)->where('dates', '<=', $end)->groupByRaw('qishu desc')->limit(600)->select(['qishu'])->get();
        echo json_encode($list);
    }

    public function bets(Request $request){
        $username = $request->input('username','');
        $dftype = $request->input('game','');
        $lottery = $request->input('lottery','');
        $begin = $request->input('begin','');
        $end = $request->input('end','');
        $date = $request->input('date','');
        $settle = $request->input('settle','');
        $page = $request->input('page','');
        $period = $request->input('period','');
        $minAmount = $request->input('minAmount','');
        $maxAmount = $request->input('maxAmount','');
        $gameText = $request->input('gameText','');
        $text = $request->input('text','');
        $amount = $request->input('amount','');
        if ($page == '' || !is_numeric($page)) $page = 1;
        if(!empty($dftype)){
            $whi = " dftype='$dftype' and xtype != 2 ";
        }else{
            $muser = User::where('username', $username)->select(['userid'])->first();
            $userid = $muser->userid;
            $whi = " userid='$userid' and xtype != 2 ";
        }
        $zstr = '';
        $zstrl = '';
        if ($settle == 1) {
            $zstr .= " and z not in(2,7,9) ";
            $zstrl .= " and z not in(7,9) ";
        } elseif ($settle == 2) {
            $zstr .= " and z = 9 ";
            $zstrl .= " and z = 9 ";
        }
        if(!empty($period)){
            $whi .= " and qishu='$period' ";
        }
        if(!empty($amount)){
            $whi .= " and je='$amount' ";
        }
        if(!empty($lottery)){
            $gids = Game::whereIn('lottery',explode(',',$lottery))->pluck('gid')->toArray();
            $gids = implode(',',$gids);
            $whi .= " and gid in ($gids) ";
        }
        if(!empty($minAmount) && !empty($maxAmount)){
            $whi .= " and je>='$minAmount' and je<='$maxAmount' ";
        }
        $db = Db::connection();
        $dd = ComFunc::getthisdate();
        $tb_lib = SGUtils::getcuretable(true);
        $datearr = ComFunc::getdatearray($begin, $end,$dd,$whi);
        $tax = x_config('plat_tax_status');
        view()->share('lottery', $lottery);
        view()->share('date', $date);
        view()->share('username', $username);
        view()->share('game', $dftype);
        view()->share('begin', $begin);
        view()->share('end', $end);
        view()->share('settle', $settle);
        view()->share('datearr', $datearr);
        view()->share('minAmount', $minAmount);
        view()->share('maxAmount', $maxAmount);
        view()->share('period', $period);
        view()->share('amount', $amount);
        view()->share('gameText', $gameText);
        view()->share('text', $text);
        view()->share('tax', $tax);
        view()->share('tax_name', x_config('tax_name'));
        $user = User::where('userid', $this->uid)->select(['layer'])->first();
        if(empty($datearr)){
            view()->share('bao', []);
            view()->share('pcount', 0);
            view()->share('rcount', 0);
            view()->share('page', 1);
            view()->share('total', ['zs'=>0,'je'=>0,'jg'=>0,'bj'=>0,'total_tax'=>0]);
            view()->share('startpcount', 0);
            view()->share('endpcount', 0);
            view()->share('tax', $tax);
            view()->share('ifson', 0);
            return view('common.report.bets');
        }
        if (empty($date)) {
            $date = $datearr[0]['date'];
        }
        if ($date != $dd) {
            $tb_lib = "x_lib_" . str_replace('-', '', $date);
        }
        $layer = $user['layer'];
        $myzcstr = 'zc' . $layer;
        $join = " from `$tb_lib` where $whi and bs=1 $zstrl";
        $sql = "select count(id) as ra $join ";
        $rs = $db->select($sql);
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rcount = ComFunc::pr0($ra);
        $psize = 20;
        $pcount = $rcount % $psize == 0 ? $rcount / $psize : (($rcount - $rcount % $psize) / $psize + 1);
        if ($pcount <= 10) {
            view()->share('startpcount', 1);
            view()->share('endpcount', $pcount);
        }else{
            if($page <= 10){
                $startpcount = 1;
                $endpcount = 10;
            }else{
                $tt = intval($page/10);
                $startpcount = $tt*10+1;
                if($startpcount > $pcount){
                    $startpcount = $pcount;
                }
                $endpcount = $tt*10+10;
                if($endpcount > $pcount){
                    $endpcount = $pcount;
                }
            }
            view()->share('startpcount', $startpcount);
            view()->share('endpcount', $endpcount);
        }
        $total = [];
        $zcstr = 'zc' . $layer;
        $rs = $db->select("select sum(je*uzp2) as rbb,sum(je) as ra,sum(je*points/100) as rb,count(id) as rc,sum($zcstr*je/100) as rd,sum($zcstr*je*points/(100*100)) as re $join $zstr");
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
        $rc = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
        $rd = $rs[0]['rd'] ? $rs[0]['rd'] : 0;
        $re = $rs[0]['re'] ? $rs[0]['re'] : 0;
        $rbb = $rs[0]['rbb'] ? $rs[0]['rbb'] : 0;
        $total['je'] = $ra;
        $total['points'] = ComFunc::pr1($rb);
        $total['zs'] = ComFunc::pr0($rc);
        $total['zc'] = ComFunc::pr1($rd);
        $total['zcpoints'] = ComFunc::pr1($re);

        $rs = $db->select("select sum(je*peilv1) as ra,sum(prize) as rb,sum(je*peilv1*$zcstr/100) as rc,sum(uzp1*je) as rd $join and z=1 $zstr");
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
        $rc = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
        $rd = $rs[0]['rd'] ? $rs[0]['rd'] : 0;
        $total['total_tax'] = ComFunc::pr1($rd);
        $total['zhong'] = ComFunc::pr1($ra-$rb-$rd);
        $total['bjzhong'] = ComFunc::pr1($rc);
        $total['bj'] = ComFunc::pr1($total['zc'] - $total['zcpoints'] - $total['bjzhong']);
        $total['jg'] = ComFunc::pr1($total['zhong'] + $total['points'] - $total['je']);
        $total['je'] = ComFunc::pr1($total['je']-$rbb);
        $sql = "select * $join $zstrl order by id desc limit " . ($page - 1) * $psize . "," . $psize;
        $list = $db->select($sql);
        $i = 0;
        $bao = array();
        $tmp = array();
        foreach ($list as $item) {
            if (!isset($tmp['g' . $item['gid']])) {
                $game = Game::where('gid',$item['gid'])->select(['gname','fenlei'])->first();
                $tmp['g' . $item['gid']] = $game['gname'];
                $tmp['f' . $item['gid']] = $game['fenlei'];
            }
            if (!isset($tmp['u' . $item['userid']])) {
                $tmp['u' . $item['userid']] = User::where('userid',$item['userid'])->value('username');
            }
            if (!isset($tmp['b' . $item['gid'] . $item['bid']])) {
                $tmp['b' . $item['gid'] . $item['bid']] = CsFunc::transb8('name', $item['bid'], $item['gid']);
            }
            if (!isset($tmp['s' . $item['gid'] . $item['sid']])) {
                $tmp['s' . $item['gid'] . $item['sid']] = CsFunc::transs8('name', $item['sid'], $item['gid']);
            }
            if (!isset($tmp['c' . $item['gid'] . $item['cid']])) {
                $tmp['c' . $item['gid'] . $item['cid']] = CsFunc::transc8('name', $item['cid'], $item['gid']);
            }
            if (!isset($tmp['p' . $item['gid'] . $item['pid']])) {
                $tmp['p' . $item['gid'] . $item['pid']] = CsFunc::transp8('name', $item['pid'], $item['gid']);
            }
            $bao[$i]['code'] = $item['code'];
            $bao[$i]['time'] = date('Y-m-d H:i:s', $item['time']);
            $bao[$i]['week'] = ComFunc::rweek(date("w", $item['time']));
            $bao[$i]['game'] = $tmp['g' . $item['gid']];
            $bao[$i]['user'] = $tmp['u' . $item['userid']];
            $bao[$i]['qishu'] = $item['qishu'];
            $bao[$i]['abcd'] = $item['abcd'];
            $bao[$i]['wf'] = ComFunc::wfuser($tmp['f' . $item['gid']], $tmp['b' . $item['gid'] . $item['bid']], $tmp['s' . $item['gid'] . $item['sid']], $tmp['c' . $item['gid'] . $item['cid']], $tmp['p' . $item['gid'] . $item['pid']]);
            $bao[$i]['peilv1'] = (float)$item['peilv1'];
            $bao[$i]['peilv2'] = (float)$item['peilv2'];
            $bao[$i]['je'] = (float)$item['je'];
            $bao[$i]['points'] = (float)$item['points'];
            $bao[$i]['xtype'] = ComFunc::transxtype($item['xtype']);
            $bao[$i]['z'] = $item['z'];
            if ($item['z'] == 1) {
                $bao[$i]['rs'] = ComFunc::pr1($item['peilv1'] * $item['je'] - $item['je'] * (1 - $item['points'] / 100));
            } else if ($item['z'] == 3) {
                $bao[$i]['rs'] = ComFunc::pr1($item['peilv2'] * $item['je'] - $item['je'] * (1 - $item['points'] / 100));
            } else if ($item['z'] == 2 || $item['z'] == 7) {
                $bao[$i]['rs'] = 0;
            } else if ($item['z'] == 5) {
                $bao[$i]['rs'] = ComFunc::pr1($item['prize'] - $item['je'] + $item['je'] * $item['points'] / 100);
            } else {
                $bao[$i]['rs'] = ComFunc::pr1(0 - $item['je'] * (1 - $item['points'] / 100));
            }
            $bao[$i]['tax'] = ComFunc::pr1($item['je']*$item['uzp1']);
            $bao[$i]['con'] = $item['content'];
            $bao[$i]['rs'] = ComFunc::pr1($bao[$i]['rs']);
            if($item['xtype'] ==1){
                $bao[$i]['fly'] = 1;
                if(isset($userid) && ($userid == $item['userid'])){
                    $bao[$i]['mezc'] = -100;
                }else{
                    $bao[$i]['mezc'] = $item[$myzcstr];
                }
            }else{
                $bao[$i]['mezc'] = $item[$myzcstr];
            }
            $bao[$i]['mers'] = ComFunc::pr1(0 - $bao[$i]['rs'] * $bao[$i]['mezc'] / 100);
            $i++;
        }
        view()->share('bao', $bao);
        view()->share('pcount', $pcount);
        view()->share('rcount', $rcount);
        view()->share('page', $page);
        view()->share('total', $total);
        view()->share('ifson', 0);
        return view('common.report.bets');
    }
}
