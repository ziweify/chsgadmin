<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\TaxUser;
use App\Models\Game\User;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\common\CsFunc;
use App\ort\sgwin\Json;
use App\ort\sgwin\ReportService;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportNewController extends ManageAuthController
{
    public function main(Request $request){
        $action = $request->input('action','list');
        $userid = $this->uid;
        $user = User::where('userid',$userid)->select(['username','name','layer'])->first();
        view()->share("layername", '总监');
        view()->share("username", $user['username']);
        view()->share("layer", $user['layer']);
        $sdate = AdminFunc::week();
        view()->share("today", strtotime($sdate[10])*1000);
        view()->share("sdate", $sdate);
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','xsort','lottery'])->orderByRaw('xsort asc')->get();
        view()->share("lotterys", $lotterys);
        if(empty($action) || $action == 'list'){
            /*if(!in_array('report.logs',$this->auths)){//无权限跳转
                return redirect('/noauth');
            }*/
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
            return view('agentv1.report.logsmain');
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

    public function list(Request $request){
        $game = $request->input('lottery','');
        $username = $request->input('username','');
        $start = $request->input('begin','');
        $end = $request->input('end','');
        $qishu = $request->input('period','');
        $detail = $request->input('detail',0);
        $jsstatus = $request->input('settle','');
        $filter = $request->input('filter','');
        $yk = $request->input('nd','');
        $je = $request->input('amount','');
        $userid = Constants::$SUID;
        if(!is_numeric($jsstatus)){
            if($jsstatus == 'false' || $jsstatus == false) {
                $jsstatus = 2;
            }else{
                $jsstatus = 1;
            }
        }
        if($jsstatus == 2 || $qishu != '' || $yk != '' || $je != ''){
            if($detail == 1){
                return (new ReportController($request))->list_detail($request,$detail);
            }else{
                return (new ReportController($request))->list1($request,$detail);
            }
        }else{
            if($detail == 1){
                return ReportService::list_detail($game,$username,$start,$end,$qishu,$detail,$jsstatus,$filter,$yk,$je,$userid,0);
            }else{
                return ReportService::list_bebing($game,$username,$start,$end,$qishu,$detail,$jsstatus,$filter,$yk,$je,$userid,0);
            }
        }
    }

    public function list_game(Request $request){
        $game = $request->input('lottery','');
        $username = $request->input('username','');
        $start = $request->input('begin','');
        $end = $request->input('end','');
        $qishu = $request->input('period','');
        $detail = $request->input('detail',0);
        $jsstatus = $request->input('settle','');
        $filter = $request->input('filter','');
        $yk = $request->input('nd','');
        $je = $request->input('amount','');
        $userid = Constants::$SUID;
        if(!is_numeric($jsstatus)){
            if($jsstatus == 'false' || $jsstatus == false) {
                $jsstatus = 2;
            }else{
                $jsstatus = 1;
            }
        }
        if($jsstatus == 2 || $qishu != '' || $yk != '' || $je != ''){
            return (new ReportController($request))->list_game($request,$detail);
        }else{
            return ReportService::list_game($game,$username,$start,$end,$qishu,$detail,$jsstatus,$filter,$yk,$je,$userid,0);
        }
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
            if(empty($muser)){
                return Json::error('用户不存在');
            }
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
        $rs = $db->select("select sum(je*uzp2) as rbb,sum(je) as ra,sum((je-(je*uzp2))*points/100) as rb,sum($zcstr*je/100) as rd,sum($zcstr*(je-(je*uzp2))*points/(100*100)) as re $join $zstr");
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
        $rd = $rs[0]['rd'] ? $rs[0]['rd'] : 0;
        $re = $rs[0]['re'] ? $rs[0]['re'] : 0;
        $rbb = $rs[0]['rbb'] ? $rs[0]['rbb'] : 0;
        $total['je'] = ComFunc::pr0($ra);
        $total['points'] = ComFunc::pr1($rb);
        $total['zc'] = ComFunc::pr0($rd);
        $total['zcpoints'] = ComFunc::pr1($re);

        $rs = $db->select("select sum(je*peilv1) as ra,sum(prize) as rb,sum(je*peilv1*$zcstr/100) as rc,sum(uzp1*je) as rd,sum(uzp1*je*$zcstr/100) as re $join and z=1 $zstr");
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
        $rc = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
        $rd = $rs[0]['rd'] ? $rs[0]['rd'] : 0;
        $re = $rs[0]['re'] ? $rs[0]['re'] : 0;
        $total['total_tax'] = ComFunc::pr1($rd);
        $total['zhong'] = ComFunc::pr1($ra-$rb-$rd);
        $total['bjzhong'] = ComFunc::pr1($rc);
        $total['bj'] = ComFunc::pr1($total['zc'] - $total['zcpoints'] - $total['bjzhong']+$re);
        $total['jg'] = ComFunc::pr1($total['zhong'] + $total['points'] - $total['je']);
        //下注金额
        $rs = $db->select("select sum(je) as ra,count(id) as rb from `$tb_lib` where $whi and bs=1 $zstrl");
        $sje = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $total['zs'] = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
        $total['je'] = ComFunc::pr0($sje-$rbb);
        $sql = "select * $join $zstrl order by id desc limit " . ($page - 1) * $psize . "," . $psize;
        $list = $db->select($sql);
        $i = 0;
        $bao = array();
        $tmp = array();
        foreach ($list as $item) {
            if (!isset($tmp['g' . $item['gid']])) {
                $game = Game::where('gid',$item['gid'])->select(['gname','fenlei','lottery'])->first();
                $tmp['g' . $item['gid']] = $game['gname'];
                $tmp['f' . $item['gid']] = $game['fenlei'];
                $tmp['l' . $item['gid']] = $game['lottery'];
            }
            if (!isset($tmp['u' . $item['userid']])) {
                $tmp['u' . $item['userid']] = User::where('userid',$item['userid'])->value('username');
                $taxis_show_jpei = TaxUser::where('userid',$item['userid'])->value('is_show_jpei');
                $taxis_show_jpei = $taxis_show_jpei ? $taxis_show_jpei : 0;
                $tmp['t' . $item['userid']] = $taxis_show_jpei;
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
            $is_show_jpei = $tmp['t' . $item['userid']];
            //赔率处理
            if($settle == 1 && ($is_show_jpei == 1 || ($is_show_jpei == 2 &&  $page > 1))){
                if($item['uzp1'] > 0){
                    $item['peilv1'] = ComFunc::pr4($item['peilv1']-$item['uzp1']);
                }
            }
            $bao[$i]['lottery'] = $tmp['l' . $item['gid']];
            $bao[$i]['dates'] = date('Y-m-d', $item['dates']);
            $bao[$i]['code'] = $item['code'];
            $bao[$i]['time'] = date('Y-m-d H:i:s', $item['time']);
            $bao[$i]['week'] = ComFunc::rweek(date("w", $item['time']));
            $bao[$i]['game'] = $tmp['g' . $item['gid']];
            $bao[$i]['user'] = $tmp['u' . $item['userid']];
            $bao[$i]['qishu'] = $item['qishu'];
            $bao[$i]['abcd'] = $item['abcd'];
            $bao[$i]['wf'] = ComFunc::wfreport($tmp['f' . $item['gid']], $tmp['b' . $item['gid'] . $item['bid']], $tmp['s' . $item['gid'] . $item['sid']], $tmp['c' . $item['gid'] . $item['cid']], $tmp['p' . $item['gid'] . $item['pid']]);
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
