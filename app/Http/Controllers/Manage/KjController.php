<?php

namespace App\Http\Controllers\Manage;

use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\Lib;
use App\Models\Game\LibTotal;
use App\Models\Game\User;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\common\Json;
use App\ort\common\Page;
use App\ort\services\AutoKjsService;
use App\ort\services\SearchqishuService;
use App\ort\sgwin\ReportService;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class KjController extends ManageAuthController
{
    public function kjshow(Request $request){
        $gid = $request->input('gid','');
        $userid = $this->uid;
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share("lotterys", $lotterys->toArray());
        if(empty($gid)){
            $gid = $lotterys[0]['gid'];
        }
        view()->share("gid", $gid);
        $g = Game::where('gid', $gid)->select(['gid','gname','autokj','autoopenpan','panstatus','thisqishu','fast','guanfang','thisbml','cs','fenlei'])->first();
        $game = array();
        $game[0]['gid'] = $g['gid'];
        $game[0]['gname'] = $g['gname'];
        $game[0]['autokj'] = $g['autokj'];
        $game[0]['autoopenpan'] = $g['autoopenpan'];
        $game[0]['panstatus'] = $g['panstatus'];
        $game[0]['thisqishu'] = $g['thisqishu'];
        $game[0]['fast'] = $g['fast'];
        $game[0]['guanfang'] = $g['guanfang'];
        $game[0]['thisbml'] = $g['thisbml'];
        $cs = json_decode($g['cs'], true);
        view()->share('cs',$cs);
        $sdate = AdminFunc::week();
        view()->share("sdate", $sdate);
        view()->share('game', $game);
        view()->share('fenlei', $g['fenlei']);
        view()->share('gid', $gid);
        return view('manage.kj');
    }

    public function kjupdatestatus(Request $request){
        $type = $request->input('type','');
        $gid  = $request->input('gid','');
        if(empty($type) || empty($gid)){
            return '参数错误';
        }
        $db = Db::connection();
        $db->update("update x_game set $type=if($type=1,0,1) where gid='$gid'");
        return 1;
    }

    public function kjgetkj(Request $request){
        $jsstatus = $request->input('jsstatus','');
        $psize = $request->input('psize','');
        $page = $request->input('page','');
        $start = $request->input('start','');
        $end = $request->input('end','');
        $ze = $request->input('ze','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $start = strtotime($start);
        $end = strtotime($end);
        $game = Game::where('gid', $gid)->select(['fast','otherclosetime','mnum'])->first();
        $fast = $game['fast'];
        $time = time() + 900;
        $whi = '';
        $ddd = date('Y-m-d',$start);
        $dd = ComFunc::getthisdate();
        if($ddd == $dd){
            $tb_lib = SGUtils::getcuretable(true);
        }else{
            $tb_lib = 'x_lib_'.str_replace('-','',$ddd);
        }
        $exists = $db->select("SHOW TABLES LIKE  '{$tb_lib}'");
        if(empty($exists)){
            $tb_lib = SGUtils::getcuretable(true);
        }
        if ($fast != 0) {
            if (!is_numeric($page))
                $page = 1;
            if ($jsstatus == 0) {
                if ($start == $end) $whi = " and dates='$start' and js=0 ";
                else $whi = " and js=0 and dates>='$start' and dates<='$end'";
                $orderby = " order by gid,dates,kjtime ";
            } else if ($jsstatus == 1) {
                if ($start == $end) $whi = " and dates='$start' and kjtime<'$time' ";
                else $whi = "  and dates>='$start' and dates<='$end' and kjtime<'$time' ";
                $orderby = " order by gid,dates desc,kjtime desc ";
            } else {
                if ($start == $end) $whi = " and dates='$start' ";
                else $whi = " and dates>='$start' and dates<='$end'  ";
                $orderby = " order by gid,dates,kjtime ";
            }
        } else {
            $orderby = " order by gid,qishu  desc ";
        }
        $rs = $db->select("select count(id) as count from x_kj where gid='$gid' $whi ");
        $rcount = $rs[0]['count'];
        $list = $db->select("select * from x_kj where gid='$gid' $whi $orderby limit " . (($page - 1) * $psize) . ",$psize");
        $i = 0;
        $kj = array();
        $otherclosetime = $game['otherclosetime'];
        $tmp = array();
        foreach ($list as $item) {
            if (!isset($tmp['g' . $item['gid']])) {
                $sgname = Game::where('gid',$item['gid'])->value('gname');
                $tmp['g' . $item['gid']] = $sgname;
            }
            if ($ze == 1) {
                if($tb_lib != '1'){
                    $cs = $db->select("select count(id) as count from $tb_lib where gid='$gid' and qishu='$item[qishu]' ");
                    $c = $cs[0]['count'] ?? 0;
                }else{
                    $c = 0;
                }
                if ($c <= 0) {
                    continue;
                }
            }
            $kj[$i]['gname'] = $tmp['g' . $item['gid']];
            $kj[$i]['gid'] = $item['gid'];
            $kj[$i]['bml'] = $item['bml'];
            $kj[$i]['oy'] = date("Y-m-d H:i:s", $item['opentime']);
            $kj[$i]['cy'] = date("Y-m-d H:i:s", $item['closetime']);
            $kj[$i]['ky'] = date("Y-m-d H:i:s", $item['kjtime']);
            $kj[$i]['opentime'] = date("Y-m-d H:i:s", $item['opentime']);
            $kj[$i]['closetime'] = date("Y-m-d H:i:s", $item['closetime']);
            $kj[$i]['kjtime'] = date("Y-m-d H:i:s", $item['kjtime']);
            $kj[$i]['otherclosetime'] = date("Y-m-d H:i:s", $item['closetime'] - $otherclosetime);
            $kj[$i]['baostatus'] = $item['baostatus'];
            $kj[$i]['js'] = $item['js'];
            $kj[$i]['qishu'] = $item['qishu'];
            $kj[$i]['lib'] = [0,0,0,0,0];
            for ($j = 1; $j <= $game['mnum']; $j++) {
                $kj[$i]['m' . $j] = $item['m' . $j];
            }
            $i++;
        }
        $pcount = $rcount % $psize == 0 ? $rcount / $psize : (1 + ($rcount - $rcount % $psize) / $psize);
        echo json_encode(array(
            "kj" => $kj,
            'pcount' => $pcount,
            'rcount' => $rcount,
            'mnum' => $game['mnum']
        ));
    }

    public function kjeditguanfang(Request $request){
        $gid = $request->input('gid','');
        $pass = $request->input('pass','');
        $kongje = $request->input('kongje','');
        $zcmode = $request->input('zcmode','');
        $cjmode = $request->input('cjmode','');
        $xtmode = $request->input('xtmode','');
        $zhiding = $request->input('zhiding','');
        $zduser = $request->input('zduser','');
        $suiji = $request->input('suiji','');
        $ylup = $request->input('ylup','');
        $shenglv = $request->input('shenglv','');
        if ($pass != x_config('supass')) {
            return Json::error('密码错误');
        }
        $game = Game::where('gid', $gid)->select(['cs','lotCode'])->first();
        $cs= json_decode($game['cs'],true);
        $sys_lot_api = x_config('sys_lot_api');;
        $sys_lot_token = x_config('sys_lot_token');
        if($cjmode != $cs['cjmode'] && $sys_lot_api && $sys_lot_token){
            $lotCode = $game['lotCode'];
            $laiyuan = ($cjmode == 0 || $cjmode == 1) ? 1 : 0;
            $sys_lot_api = $sys_lot_api.'upload_laiyuan.do';
            $param = "token=$sys_lot_token&laiyuan=$laiyuan&lotCode=$lotCode";
            $res = CsFunc::curl_get(0, $sys_lot_api.'?'.$param);
            $res = json_decode($res, true);
            if($res['errorCode'] != 0){
                return Json::error($res['message']);
            }
        }
        $cs['kongje'] = $kongje;
        $cs['zcmode'] = $zcmode;
        $cs['cjmode'] = $cjmode;
        $cs['xtmode'] = $xtmode;
        $cs['zhiding'] = $zhiding;
        $cs['zduser'] = $zduser;
        $cs['suiji'] = $suiji;
        $cs['ylup'] = $ylup;
        $cs['shenglv'] = $shenglv;
        if(!is_numeric($cs["kongje"]) || $cs["kongje"]%1!=0 || $cs["kongje"]<0){
            $cs["kongje"] = 0;
        }
        if(!is_numeric($cs["ylup"]) || $cs["ylup"]%1!=0 || $cs["ylup"]<0){
            $cs["ylup"] = 0;
        }
        if(!in_array($cs["shenglv"],[21,31,32,41,42,43,51,52,53,54,61,71,72,73,81,83,91,92])){
            $cs['shenglv'] = 31;
        }
        if(!is_numeric($cs["suiji"]) || $cs["suiji"]%1!=0 || $cs["suiji"]<50){
            $cs["suiji"] = 100;
        }
        if($cs["suiji"]>5000){
            $cs["suiji"] = 5000;
        }
        if($cs["xtmode"]==5){
            $cs["yingqs"] = 0;
            $cs["shuqs"] = 0;
        }
        //正则校验，2-32位，只能是数字、字母、下划线
        if(!preg_match("/^[a-zA-Z0-9]{2,32}$/",$cs["zduser"])){
            $cs['zduser'] = "";
            $cs['zhiding'] = 0;
        }else{
            $user = User::where('username',$cs['zduser'])->select(['userid','username'])->first();
            if(empty($user)){
                $cs['zduser'] = "";
                $cs['zhiding'] = 0;
            }
        }
        Game::where(['gid'=>$gid])->update(['cs'=>json_encode($cs)]);
        return Json::success('修改成功');
    }

    public function kjeditkpcs(Request $request){
        $pass = $request->input('pass','');
        $starttime = $request->input('starttime','');
        $starttime2 = $request->input('starttime2','');
        $qsjg = $request->input('qsjg','');
        $qsnums = $request->input('qsnums','');
        $qishunum = $request->input('qishunum','');
        $startdate = $request->input('startdate','');
        $startqs = $request->input('startqs','');
        $tzqs = $request->input('tzqs','');
        $closetime = $request->input('closetime','');
        $tuichi = $request->input('tuichi','');
        $tuichikp = $request->input('tuichikp','');
        if ($pass != x_config('supass')) {
            return 2;
        }
        $gid = $request->input('gid','');
        $game = Game::where('gid', $gid)->select(['cs'])->first();
        $cs = json_decode($game['cs'],true);
        $cs['starttime'] = $starttime;
        $cs['starttime2'] = $starttime2;
        $cs['qsjg'] = $qsjg;
        $cs['qsnums'] = $qsnums;
        $cs['qishunum'] = $qishunum;
        $cs['startdate'] = $startdate;
        $cs['startqs'] = $startqs;
        $cs['tzqs'] = $tzqs;
        $cs['closetime'] = $closetime;
        $cs['tuichi'] = $tuichi;
        $cs['tuichikp'] = $tuichikp;
        $cs = json_encode($cs);
        Game::where(['gid'=>$gid])->update(['cs'=>$cs]);
        Kj::where('gid',$gid)->where('opentime','>',time())->delete();
        return 1;
    }

    public function kjjs(Request $request){
        $qishu = $request->input('qishu','');
        $gid = $request->input('gid','');
        $game = Game::where('gid',$gid)->select(['fenlei','cs','mtype','ztype','mnum'])->first();
        $fenlei = $game["fenlei"];
        $mnum = $game['mnum'];
        $cs = json_decode($game["cs"],true);
        $ztype = json_decode($game["ztype"],true);
        $mtype = json_decode($game["mtype"],true);
        $val =  CsFunc::calc($fenlei,$gid,$cs,$qishu,$mnum,$ztype,$mtype,true);
        AdminFunc::jiaozhengedu();
        ReportService::zhengli_day_report('',$gid);
        return 1;
    }

    public function kjckj(Request $request){
        $qishu = $request->input('qishu','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $db->update("update x_kj set m1='',m2='',m3='',m4='',m5='',m6='',m6='',m7='',m8='',m9='',m10='',m11='',m12='',m13='',m14='',m15='',m16='',m16='',m17='',m18='',m19='',m20='',js=0,status=0 where gid='$gid' and qishu='$qishu'");
        return 1;
    }

    public function kjsetthisqishu(Request $request){
        $qishu = $request->input('qishu','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $db->update("update x_game set thisqishu='$qishu' where gid='$gid'");
        return 1;
    }

    public function kjeditkj(Request $request){
        $qishu = $request->input('qishu','');
        $kjtime = $request->input('kjtime','');
        $closetime = $request->input('closetime','');
        $opentime = $request->input('opentime','');
        $em = $request->input('em','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $game = Game::where('gid', $gid)->select(['mnum','fenlei','lotCode','cs'])->first();
        $m         = str_replace('\\', '', $em);
        $m         = json_decode($m, true);
        $m1 = array_filter($m);
        $m2 = array_unique($m1);
        $kjtime = strtotime($kjtime);
        $closetime = strtotime($closetime);
        $opentime = strtotime($opentime);
        if($game['mnum']==10 && count($m1)!=count($m2)){
            $m=[];
        }
        $mstr  = '';
        $arr = [];
        try {
            if($game['fenlei'] != 444)
            switch ($game['mnum']) {
                case 3:
                    if($game['fenlei']==163){
                        $arr = [0,1,2,3,4,5,6,7,8,9];
                    }else{
                        $arr = [1,2,3,4,5,6];
                    }
                    break;
                case 5:
                    $arr = [0,1,2,3,4,5,6,7,8,9,10,11];
                    break;
                case 8:
                    $arr = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20'];
                    break;
                case 10:
                    $arr = ['01','02','03','04','05','06','07','08','09','10'];
                    break;
                case 20:
                    for($i=1;$i<=80;$i++){
                        if($i<10){
                            $arr[$i-1] = '0'.$i;
                        }else{
                            $arr[$i-1] = $i;
                        }
                    }
                    break;
                case 7:
                    for($i=1;$i<=49;$i++){
                        if($i<10){
                            $arr[$i-1] = '0'.$i;
                        }else{
                            $arr[$i-1] = $i;
                        }
                    }
                    break;
            }
            foreach($m as $k => $v){
                if($game['fenlei']==103 || $game['fenlei']==107 || $game['fenlei']==100) {
                    if(strlen($v)==1 && $v!=""){
                        $m[$k] = '0'.$v;
                    }
                }
            }
            if($game['fenlei'] != 444)
            foreach($m as $k => $v){
                if(!in_array($v, $arr) && $v != "" ){
                    $m=[];
                    break;
                }
                if(!is_numeric($v) && $v != ""){
                    $m=[];
                    break;
                }
            }
            for ($i = 0; $i < $game['mnum']; $i++) {
                if ($m[$i] == '') {
                    if($game['fenlei']==151){
                        $m[$i] = $arr[rand(0, 5)];
                    }else if ($game['mnum'] == 3) {
                        $m[$i] = $arr[rand(0, 9)];
                    } else if ($game['mnum'] == 5) {
                        $m[$i] = $arr[rand(0, 9)];
                    } else if ($game['mnum'] == 8) {
                        $m[$i] = CsFunc::randm($m, $arr, $game['mnum'],20);
                    } else if ($game['mnum'] == 10) {
                        $m[$i] = CsFunc::randm($m, $arr, $game['mnum'],10);
                    }else if ($game['mnum'] == 7) {
                        $m[$i] = CsFunc::randm($m, $arr, $game['mnum'],49);
                    }else if ($game['mnum'] == 20) {
                        $m[$i] = CsFunc::randm($m, $arr, $game['mnum'],80);
                    }
                }
                $mstr .= ",m" . ($i + 1) . "='" . $m[$i] . "'";
            }
            $date = date('Y-m-d',$kjtime);
            $dates = strtotime($date);
            $curkj = Kj::where(['qishu'=>$qishu,'gid'=>$gid])->first();
            //$cs= json_decode($game['cs'],true);
            $status = 0;
            if($curkj['kjtime'] < time()){
                $status = 1;
            }
            $sql = "update x_kj set status='$status',kjtime='$kjtime',closetime='$closetime',opentime='$opentime'" . $mstr;
            $sql .= " where qishu='$qishu' and gid='$gid' ";
            $db->update($sql);
            $kjw_is_run = x_config('kjw_is_run');
            if($kjw_is_run == 1){
                $kjwdb = Db::connection('kjw');
                $kjwgid = \App\Models\Kjw\Game::where('lotCode',$game['lotCode'])->value('gid');
                $sql = "update eb_kj{$kjwgid} set status='$status'" . $mstr;
                $sql .= " where qishu='$qishu' ";
                $kjwdb->update($sql);
            }
            $thisdate = ComFunc::getthisdate();
            if($date == $thisdate){
                try {
                    if($status == 1){
                        AdminFunc::jiaozhengedu();
                        ReportService::zhengli_day_report('',$gid);
                    }
                    SearchqishuService::searchqishu($gid, 50, 1,$game['fenlei']);
                }catch (\Exception $e){
                    echo $e->getMessage();
                }
            }
            //清理开奖结果缓存
            $cachekey = "dayresult".$gid.$date.'2';
            Cache::delete($cachekey);
            //减去一天
            $prefdate = date('Y-m-d', strtotime('-1 day', $dates));
            $cachekey = "dayresult".$gid.$prefdate.'2';
            Cache::delete($cachekey);
            return 1;
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function kjkjxx(Request $request){
        $tztype = $request->post('tztype','');
        $qishu = $request->post('qishu','');
        $orderby = $request->post('orderby','');
        $sorttype = $request->post('sorttype','');
        $PB_page = $request->post('PB_page','');
        $gid = $request->post('gid','');
        $db = Db::connection();
        $wh = " gid='$gid'  and qishu='$qishu' ";
        if ($tztype != 2) {
            $wh .= " and xtype='$tztype' ";
        }
        $zcstr = "zc0";$table = SGUtils::getcuretable(true);
        $sql   = " select count(id) as count from $table where $wh ";
        $rs = $db->select($sql);
        $ra = $rs[0]['count'] ? $rs[0]['count'] : 0;
        $rcount   = ComFunc::pr0($ra);
        $psize    = 20;
        $thispage = ComFunc::r1($PB_page);
        $page     = new Page();
        $page->page(array(
            'total' => $rcount,
            'perpage' => $psize,
            'nowindex' => $thispage
        ));
        $pstr = $page->show(6);
        $sql = " select * from $table where $wh ";
        if ($orderby == 'time') {
            $sql .= " order by time $sorttype,id $sorttype";
        } else {
            $sql .= " order by $zcstr*je $sorttype,id $sorttype";
        }
        $sql .= " limit " . ($thispage - 1) * $psize . "," . $psize;
        $list = $db->select($sql);
        $tz  = array();
        $i   = 0;
        $tmp = array();
        foreach ($list as $item) {
            $tz[$i]['qishu']  = $item['qishu'];
            $tz[$i]['je']     = (float) $item['je'];
            $tz[$i]['zcje']   = (float) ComFunc::pr2($item['je'] * $item[$zcstr] / 100);
            $tz[$i]['peilv1'] = (float) $item['peilv1'];
            $tz[$i]['points'] = (float) $item['points'];

            if (!isset($tmp['g' . $item['gid']])) {
                $game = Game::where('gid',$item['gid'])->select(['gname','fenlei'])->first();
                $tmp['g' . $item['gid']] = $game['gname'];
                $tmp['f' . $item['gid']] = $game['fenlei'];
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
            $tz[$i]['con']   = $item['content'];
            $tz[$i]['wf']    = ComFunc::wf($tmp['f' . $item['gid']], $tmp['b' . $item['gid'] . $item['bid']], $tmp['s' . $item['gid'] . $item['sid']], $tmp['c' . $item['gid'] . $item['cid']], $tmp['p' . $item['gid'] . $item['pid']]);
            $tz[$i]['time']  = $item['time'];
            $tz[$i]['z']     = $item['z'];
            $tz[$i]['gname'] = $tmp['g' . $item['gid']];
            $tz[$i]['xtime'] = substr(date('Y-m-d H:i:s', $item['time']), -8);
            $tz[$i]['user']  = ComFunc::transu($item['userid']);
            $i++;
        }
        $e = array(
            "tz" => $tz,
            "page" => $pstr,
            "tztype" => $tztype,
            "sql" => $sql
        );
        return response()->json($e);
    }

    public function kjchangejs(Request $request){
        $qishu = $request->input('qishu','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $js = Kj::where(['gid'=>$gid,'qishu'=>$qishu])->value('js');
        if ($js == 0) {
            return $js;
        }
        $table = SGUtils::getcuretable(true);
        $db->update("update $table set z=9 where gid='$gid' and qishu='$qishu'");
        Kj::where(['gid'=>$gid,'qishu'=>$qishu])->update(['js'=>0]);
        $db->delete("delete from x_z where gid='$gid' and qishu='$qishu'");
        AdminFunc::jiaozhengedu();
        return 0;
    }

    public function kjchangebaos(Request $request){
        $qishu = $request->input('qishu','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $table = SGUtils::getcuretable(true);
        $db->update("update x_kj set baostatus=if(baostatus=1,0,1) where gid='$gid' and qishu='$qishu'");
        $bs = Kj::where(['gid'=>$gid,'qishu'=>$qishu])->value('baostatus');
        $db->update("update $table set bs='$bs' where gid='$gid' and qishu='$qishu'");
        return $bs;
    }

    public function kjadd(Request $request){
        $opentime = $request->input('opentime','');
        $closetime = $request->input('closetime','');
        $kjtime = $request->input('kjtime','');
        $qishu = $request->input('qishu','');
        $gid = $request->input('gid','');
        if ($gid == 111 || $gid == 115 || $gid == 133) {
           return 1;
        }
        $bml       = Game::where('gid',$gid)->value('thisbml');
        $editstart = str_replace(':', '', x_config('editstart'));
        if (str_replace(':', '', substr($kjtime, -8)) < $editstart) {
            $dates = strtotime($kjtime);
        } else {
            $dates = strtotime(substr($kjtime, 0, 10));
        }
        $db = Db::connection();
        $kjtime = strtotime($kjtime);
        $opentime = strtotime($opentime);
        $closetime = strtotime($closetime);
        $sql = "insert into x_kj set kjtime='$kjtime',opentime='$opentime',closetime='$closetime',qishu='$qishu',dates='$dates',bml='$bml',gid='$gid',baostatus=1";
        $count = Kj::where(['gid'=>$gid,'qishu'=>$qishu])->count('id');
        if ($count <= 0) {
            $db->insert($sql);
        }
        return 1;
    }

    public function kjtongbu168(Request $request){
        $start = $request->input('start','');
        $end = $request->input('end','');
        $gid = $request->input('gid','');
        if(empty($start)){
            $time = time();
            $start = date('Y-m-d',$time);
        }
        AutoKjsService::loadhistorykjdata($start,$gid,1,'https://api.api68.com/');
        return 1;
    }

    public function kjqsqc(Request $request){
        $dates = $request->input('date','');
        if(empty($dates)){
            $dates = date('Y-m-d',time());
        }
        $db = Db::connection();
        $rs = Game::where(['ifopen'=>1])->select(['autoopenpan','panstatus','cs','thisbml','thisqishu','gid'])->orderBy('xsort')->get();
        $dates = strtotime($dates);
        foreach ($rs as $k => $v) {
            $gid = $v['gid'];
            $db->delete("DELETE x_kj FROM x_kj  LEFT JOIN(SELECT MIN(vpy.id) AS id FROM x_kj AS vpy where vpy.dates='$dates' and vpy.gid='$gid' GROUP BY vpy.qishu ) AS tmp USING (id) WHERE tmp.id IS NULL and dates='$dates' and gid='$gid'");
        }
        return "操作成功";
    }

    public function kjdeldate(Request $request){
        $start = $request->input('start','');
        $end = $request->input('end','');
        $t = $request->input('t','');
        $pass = $request->input('pass','');
        $allgame = $request->input('allgame','');
        if ($pass != x_config('supass') && $this->adminInfo['hides'] == 1) {
            return Json::error('密码错误');
        }
        $start = strtotime($start);
        $end = strtotime($end);
        $gid = $request->input('gid','');
        $db = Db::connection();
        if ($allgame == 0) {
            $gamearr           = array();
            $gamearr[0]        = array();
            $gamearr[0]['gid'] = $gid;
        } else {
            $gamearr = CsFunc::getgame();
        }
        $cg = count($gamearr);
        for ($i = 0; $i < $cg; $i++) {
            if (($gamearr[$i]['gid'] == 100 || $gamearr[$i]['gid'] == 300) && $cg > 1)
                continue;
            $gamestr = " gid='" . $gamearr[$i]['gid'] . "' ";
            if ($t == 1) {
                $whi = " $gamestr and dates>='$start' and dates<='$end' ";
            } else if ($t == 2) {
                $whi = " $gamestr and dates<='$end' ";
            }
            if ($t == 1 | $t == 2) {
                //$db->delete("delete from `$tb_lib` where $whi");
                $db->delete("delete from x_kj where $whi ");
            }
        }
        return Json::success('操作成功');
    }
}




























