<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\Lib;
use App\Models\Game\LibTotal;
use App\Models\Game\Play;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\sgwin\Json;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BetsController extends ManageAuthController
{
    public function show(Request $request){
        $lottery = $request->input('lottery','');
        $qishu = $request->input('number','');
        $games = $request->input('game','');
        $items = $request->input('item','');
        $state = $request->input('state','');
        $minAmount = $request->input('minAmount','');
        $maxAmount = $request->input('maxAmount','');
        $gameText = $request->input('gameText','');
        $text = $request->input('text','');
        $page = $request->input('page','');
        $g = Game::where('lottery',$lottery)->select(['gid'])->first();
        $gid = $g->gid;
        $db = Db::connection();
        $tb_lib = SGUtils::getcuretable(true);
        $userid = $this->uid;
        if ($page == '' || !is_numeric($page)) $page = 1;
        $zstr = '';
        $gstr = " gid='$gid' ";
        $whi = " qishu='$qishu' ";
        if(!empty($minAmount) && !empty($maxAmount)){
            $whi .= " and je>='$minAmount' and je<='$maxAmount' ";
        }
        $xstr = " xtype!=2 ";
        $user = User::where('userid', $userid)->select(['layer'])->first();
        $layer = $user['layer'];
        $myzcstr = 'zc' . $layer;
        /*$zcstrdown = '';
        for ($k = 10; $k > $layer; $k--) {
            $zcstrdown .= '-zc' . $k;
        }*/
        if($state != '' && $state != null){
            $cy = $games.'_'.$state;
        }else{
            $cy = $games.'_'.$items;
        }
        $pid = Play::where(['gid'=>$gid,'cy'=>$cy])->value('pid');
        $whi .= " and pid='$pid' ";
        if($layer > 0){
            $join = " from `$tb_lib` where uid" . $layer . "='$userid' and $gstr and $whi and bs=1 and $xstr";
        }else{
            $join = " from `$tb_lib` where $gstr and $whi and bs=1 and $xstr";
        }
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
        $rs = $db->select("select sum(je*uzp2) as rbb,sum(je) as ra,sum(je*points/100) as rb,count(id) as rc,sum($zcstr*je/100) as rd,sum($zcstr*je*points/(100*100)) as re $join");
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

        $rs = $db->select("select sum(je*peilv1) as ra,sum(prize) as rb,sum(je*peilv1*$zcstr/100) as rc $join and z=1");
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
        $rc = $rs[0]['rc'] ? $rs[0]['rc'] : 0;
        $total['zhong'] = ComFunc::pr1($ra) - ComFunc::pr1($rb);
        $total['bjzhong'] = ComFunc::pr1($rc);
        $rs = $db->select("select sum(je*peilv2) as ra,sum(je*peilv2*$zcstr/100) as rb $join and z=3");
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rb = $rs[0]['rb'] ? $rs[0]['rb'] : 0;
        $total['zhong'] += ComFunc::pr1($ra);
        $total['bjzhong'] += ComFunc::pr1($rb);
        $total['bj'] = ComFunc::pr1($total['zc'] - $total['zcpoints'] - $total['bjzhong']);
        $total['jg'] = ComFunc::pr1($total['zhong'] + $total['points'] - $total['je']);
        $total['je'] = ComFunc::pr1($total['je']-$rbb);

        $sql = "select * $join order by id desc limit " . ($page - 1) * $psize . "," . $psize;
        $list = $db->select($sql);
        $i = 0;
        $bao = array();
        $tmp = array();
        //$layers = json_decode(x_config('layer'),true);
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
            $bao[$i]['peilv1'] = $item['peilv1'];
            $bao[$i]['peilv2'] = $item['peilv2'];
            $bao[$i]['je'] = Comfunc::pr1($item['je']);
            $bao[$i]['points'] = $item['points'];
            $bao[$i]['xtype'] = ComFunc::transxtype($item['xtype']);
            $bao[$i]['z'] = $item['z'];
            if ($item['z'] == 1) {
                $bao[$i]['rs'] = Comfunc::pr1($item['peilv1'] * $item['je'] - $item['je'] * (1 - $item['points'] / 100));
            } else if ($item['z'] == 3) {
                $bao[$i]['rs'] = Comfunc::pr1($item['peilv2'] * $item['je'] - $item['je'] * (1 - $item['points'] / 100));
            } else if ($item['z'] == 2 || $item['z'] == 7) {
                $bao[$i]['rs'] = 0;
            } else if ($item['z'] == 5) {
                $bao[$i]['rs'] = Comfunc::pr1($item['prize'] - $item['je'] + $item['je'] * $item['points'] / 100);
            } else {
                $bao[$i]['rs'] = Comfunc::pr1(0 - $item['je'] * (1 - $item['points'] / 100));
            }
            $bao[$i]['con'] = $item['content'];
            $bao[$i]['rs'] = ComFunc::pr1($bao[$i]['rs']);
            if($item['xtype'] ==1){
                $bao[$i]['fly'] = 1;
                if($userid == $item['userid']){
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
        view()->share('lottery', $lottery);
        view()->share('number', $qishu);
        view()->share('minAmount', $minAmount);
        view()->share('maxAmount', $maxAmount);
        view()->share('gameText', $gameText);
        view()->share('text', $text);
        view()->share('game', $games);
        view()->share('item', $items);
        view()->share('state', $state);
        return view('common.load.bets');
    }

    public function reportshares(Request $request){
        $code = $request->input('bid','');
        $drawDate = $request->input('drawDate','');
        if(empty($code)){
           exit('参数错误');
        }
        $db = Db::connection();
        /*$tb = SGUtils::bjdate($drawDate);
        $exits = $db->select("SHOW TABLES LIKE 'x_".$tb."'");
        if(empty($exits)){
            exit('订单不存在');
        }*/
        $date = explode(' ',$drawDate)[0];
        $tb = "lib_".str_replace('-','',$date);
        $order = $db->table($tb)->where(['code'=>$code])->first();
        if (empty($order)) {
            exit('订单不存在');
        }
        $bao = [];
        $i = 0;
        $tmp = [];
        $layers = json_decode(x_config('layer'),true);
        for ($j = 10; $j >= 0; $j--) {
            $bao[$i]['uid'] = isset($order['uid' . $j]) ? $order['uid' . $j] : 0;
            if (isset($order['uid' . $j]) && !isset($tmp['u' . $order['uid' . $j]]) && $order['uid' . $j] != 0) {
                $tmp['u' . $order['uid' . $j]] = User::where('userid', $order['uid' . $j])->value('username');
            }
            if($j == 0){
                $bao[$i]['user'] = User::where('userid', $this->uid)->value('username');
                $bao[$i]['peilv1'] = (float)$order['peilv11'];
                $bao[$i]['peilv2'] = (float)$order['peilv21'];
                $bao[$i]['zc'] = $order['zc' . $j];
                $bao[$i]['layer'] = '公司';
                $bao[$i]['points'] = $order['points1'];
            }else{
                $bao[$i]['user'] = isset($tmp['u' . $order['uid' . $j]]) ? $tmp['u' . $order['uid' . $j]] : '';
                $bao[$i]['peilv1'] = (float)$order['peilv1' . $j];
                $bao[$i]['peilv2'] = (float)$order['peilv2' . $j];
                $bao[$i]['zc'] = $order['zc' . $j];
                $bao[$i]['layer'] = $layers[$j - 1];
                $bao[$i]['points'] = $order['points' . $j];
            }
            $i++;
        }
        //移除字段user为空的数据
        foreach ($bao as $k => $v) {
            if (empty($v['user'])) {
                unset($bao[$k]);
            }
        }
        //反转数组
        $bao = array_reverse($bao);
        view()->share('bao', $bao);
        $html = view('managev1.bets.shares')->render();
        echo $html;
    }

    public function betExtraDetail(Request $request){
        $bid = $request->input('bid','');
        $drawDate = $request->input('drawDate','');
        $db = Db::connection();
        $date = explode(' ',$drawDate)[0];
        $tb = "lib_".str_replace('-','',$date);
        $order = $db->table($tb)->where(['code'=>$bid])->first();

        $result['bid'] = $bid;
        $result['channel'] = 'web';
        $result['ip'] = $order['ip'];
        $result['remark'] = 'web';
        $result['status'] = 0;
        if($order['z'] != 9){
            $kjtdata = Kj::where(['gid'=>$order['gid'],'qishu'=>$order['qishu']])->select(['js_time','kjtime'])->first();
            if(empty($kjtdata['js_time'])){
                $result['settleTime'] = ($kjtdata['kjtime']+13)*1000;
            }else{
                $result['settleTime'] = $kjtdata['js_time']*1000;
            }
        }
        return Json::success('', $result);
    }
}
