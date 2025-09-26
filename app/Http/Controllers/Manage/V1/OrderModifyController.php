<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\LibErr;
use App\Models\Game\Play;
use App\Models\Game\Sclass;
use App\Models\Game\User;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\sgwin\ReportService;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderModifyController extends ManageAuthController
{

    public function list(){
        //查询游戏数据
        $userid = $this->uid;
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share('gamecs', $lotterys);
        $sdate = AdminFunc::week();
        view()->share("sdate", $sdate);
        return view('managev1.ordermodify.list');
    }

    public function getzddglist(Request $request){
        $page = $request->input('page', '');
        $start = $request->input('start', '');
        $end = $request->input('end', '');
        $uid = $request->input('username', '');
        $bid = $request->input('bid', '');
        $sid = $request->input('sid', '');
        $cid = $request->input('cid', '');
        $qishu = $request->input('qishu', '');
        $gid = $request->input('gid', '');
        $z = $request->input('z', '');
        $psize = $request->input('limit', 20);
        $db = Db::connection();
        $page = ComFunc::rpage($page);
        $username = trim($uid);
        $uid = "";
        if ($username != "") {
            $uid = User::where(['username'=>$username])->value('userid');
        }
        $whi = " 1=1 ";
        $tb_lib = 'x_lib_'.str_replace('-','',$start);
        $thidate = ComFunc::getthisdate();
        if($start == $thidate){
            $tb_lib = SGUtils::getcuretable(true);
        }
        $dat = $db->select("SHOW TABLES LIKE  '$tb_lib'");
        if(empty($dat)){
            $e = array("tz" => [], "page" => $page, "rcount"=>0, "layer" => 0);
            return response()->json($e);
        }
        $username != "" && ($whi .= " and userid='{$uid}' ");
        if(!empty($bid) && is_numeric($bid)){
            $whi .= " and bid='{$bid}' ";
        }
        if(!empty($sid) && is_numeric($sid)){
            $whi .= " and sid='{$sid}' ";
        }
        if(!empty($cid) && is_numeric($cid)){
            $whi .= " and cid='{$cid}' ";
        }
        if(!empty($qishu) && is_numeric($qishu)){
            $whi .= " and qishu='{$qishu}' ";
        }
        if(!empty($gid) && is_numeric($gid)){
            $whi .= " and gid='{$gid}' ";
        }
        if($z != '' && is_numeric($z)){
            $whi .= " and z='{$z}' ";
        }
        $join = " from `{$tb_lib}` where {$whi} ";
        $sql = " select count(id) as count {$join} ";
        $record_count = $db->select($sql);
        $rcount = ComFunc::pr0($record_count[0]['count']);
        $sql = " select * {$join} order by id desc ";
        $sql .= " limit " . ($page - 1) * $psize . "," . $psize;
        $record_list = $db->select($sql);
        $tz = array();
        $i = 0;
        $tmp = [];
        $layer = 0;
        foreach ($record_list as $item) {
            $tz[$i]['checkbox'] = false;
            $tz[$i]['code'] = $item['code'];
            $tz[$i]['dates'] = $item['dates'];
            $tz[$i]['xtype'] = ComFunc::transxtype($item['xtype']);
            $tz[$i]['id'] = $item['id'];
            $tz[$i]['userid'] = $item['userid'];
            $tz[$i]['qishu'] = $item['qishu'];
            $tz[$i]['je'] = (double) $item['je'];
            if ($uid == $item['userid']) {
                $tz[$i]['me'] = 1;
            }
            //$tz[$i]['zcje'] = pr2($item['je') * $item[$zcstr) / 100);
            $tz[$i]['peilv1'] = (double) $item['peilv1'];
            $tz[$i]['peilv2'] = (double) $item['peilv2'];
            $tz[$i]['points'] = (double) $item['points'];
            $tz[$i]['con'] = $item['content'];
            if (!isset($tmp['g' . $item['gid']])) {
                $game = Game::where('gid',$item["gid"])->select(['gname','fenlei'])->first();
                $tmp['g' . $item['gid']] = $game["gname"];
                $tmp['f' . $item['gid']] = $game["fenlei"];
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
            if (!isset($tmp['u' . $item['userid']])) {
                $tmp['u' . $item['userid']] = User::where('userid',$item['userid'])->value('username');
            }
            $tz[$i]['bid'] = $tmp['b' . $item['gid'] . $item['bid']];
            $tz[$i]['sid'] = $tmp['s' . $item['gid'] . $item['sid']];
            $tz[$i]['cid'] = $tmp['c' . $item['gid'] . $item['cid']];
            $tz[$i]['pid'] = $tmp['p' . $item['gid'] . $item['pid']];
            if(is_numeric($tz[$i]['pid'])){
                $tz[$i]['pid'] = (int)$tz[$i]['pid'];
            }
            $tz[$i]['bids'] = $item['bid'];
            $tz[$i]['sids'] = $item['sid'];
            $tz[$i]['cids'] = $item['cid'];
            $tz[$i]['pids'] = $item['pid'];
            $tz[$i]['gids'] = $item['gid'];
            $tz[$i]['game'] = $tmp['g' . $item['gid']];
            $tz[$i]['fl'] = $tmp['f' . $item['gid']];
            $tz[$i]['time'] = date('Y-m-d H:i:s', $item['time']);
            $tz[$i]['xtime'] = date('d H:i:s', $item['time']);
            $tz[$i]['duser'] = $tmp['u' . $item['userid']];
            for ($j = 0; $j < 11; $j++) {
                $tz[$i]['zc' . $j] = ComFunc::pr2($item['je'] * $item['zc' . $j] / 100);
                if ($j != 0) {
                    $tz[$i]['points' . $j] = (double) $item['points' . $j];
                    $tz[$i]['peilv1' . $j] = (double) $item['peilv1' . $j];
                    if ($item['peilv2' . $j] > 1) {
                        $tz[$i]['peilv1' . $j] .= '/' . (double) $item['peilv2' . $j];
                    }
                }
            }
            if (strpos("|A|B|C|D|E", $item['abcd'])) {
                $tz[$i]['abcd'] = $item['abcd'];
            } else {
                $tz[$i]['abcd'] = '';
            }
            if (strpos("|A|B|", $item['ab'])) {
                $tz[$i]['ab'] = $item['ab'];
            } else {
                $tz[$i]['ab'] = '';
            }
            $tz[$i]['z'] = $item['z'];
            $i++;
        }
        $e = array("tz" => $tz, "page" => $page, "rcount"=>$rcount, "layer" => $layer);
        return response()->json($e);
    }

    public function editzddg(Request $request){
        $str = $request->input('str','');
        $str = str_replace('\\', '',$str);
        $arr = json_decode($str, true);
        $ca = count($arr);
        $db = Db::connection();
        $tmp = [];
        $userids = [];$tmpdate = null;
        for ($i = 0; $i < $ca; $i++) {
            $code = $arr[$i]['code'];
            $dates = $arr[$i]['dates'];
            $dates = date('Ymd',$dates);
            $tmpdate = date('Ymd',$arr[$i]['dates']);
            $tb_lib = 'lib_'.$dates;
            $oldliberr = LibErr::where('code',$code)->count('id');
            if ($oldliberr > 0) {
                return response()->json(['code'=>0,'msg'=>'该订单已经存在于改单日志，请先还原改单日志']);
            }
            $qishu = $arr[$i]['qishu'];
            $gid = $arr[$i]['gids'];
            $sqls = "gid='{$gid}' and qishu='{$qishu}' and code='{$code}'";
            $lib = $db->table($tb_lib)->where('code',$code)->first();
            if (!isset($tmp['g' . $lib['gid']])) {
                $tmp['f' . $lib['gid']] = Game::where('gid',$lib['gid'])->value('fenlei');
            }
            $fl = $tmp['f' . $lib['gid']];
            $gid = $lib["gid"];
            if (($fl == 107 && $lib['bid'] != 23378805) || ($fl == 101 && $lib['bid'] == 23378755)) {
                $sid = $arr[$i]['sid'];
                $sclass = Sclass::where(['gid'=>$gid,'name'=>$sid])->select(['bid','sid'])->first();
                $bid = $sclass['bid'];
                $sid = $sclass['sid'];
                $play = Play::where(['gid'=>$gid,'sid'=>$sid,'name'=>$arr[$i]['pid']])->select(['cid','pid'])->first();
                $cid = $play['cid'];
                $pid = $play['pid'];
                if ($pid == '') {
                    continue;
                }
                $peilv1 = $arr[$i]['peilv1'];
                $points = $arr[$i]['points'];
                $content = $arr[$i]['con'];
                $je = $arr[$i]['je'];
                $z = $arr[$i]['z'];
                $time = strtotime($arr[$i]['time']);
                $sql = "update x_{$tb_lib} set bid='{$bid}',sid='{$sid}',cid='{$cid}',pid='{$pid}',peilv1='{$peilv1}',points='{$points}',content='{$content}',je='{$je}',time='{$time}',z='{$z}'";
                $liberrsql = "update x_lib_err set bid='{$bid}',sid='{$sid}',cid='{$cid}',pid='{$pid}',peilv1='{$peilv1}',points='{$points}',content='{$content}',je='{$je}',time='{$time}',z='{$z}'";
            } else {
                $pid = ComFunc::untransp($lib['bid'], $lib['sid'], $lib['cid'], $arr[$i]['pid'], $lib['gid']);
                if (empty($pid)) {
                    continue;
                }
                $peilv1 = $arr[$i]['peilv1'];
                $points = $arr[$i]['points'];
                $content = $arr[$i]['con'];
                $je = $arr[$i]['je'];
                $z = $arr[$i]['z'];
                $time = strtotime($arr[$i]['time']);
                $sql = "update x_{$tb_lib} set pid='{$pid}',peilv1='{$peilv1}',points='{$points}',content='{$content}',je='{$je}',time='{$time}',z='{$z}'";
                $liberrsql = "update x_lib_err set pid='{$pid}',peilv1='{$peilv1}',points='{$points}',content='{$content}',je='{$je}',time='{$time}',z='{$z}'";
            }
            $md5str = $pid.$z.$peilv1.$points.$content.$je.$time;
            $oldmd5str = $lib['pid'].$lib['z'].$lib['peilv1'].$lib['points'].$lib['content'].$lib['je'].$lib['time'];
            /*for ($j = 1; $j < 5; $j++) {
                $md5str .= $arr[$i]['peilv1' . $j];
                $md5str .= $arr[$i]['points' . $j];
                $oldmd5str .= $lib['peilv1' . $j];
                $oldmd5str .= $lib['points' . $j];
                $sql .= ",peilv1" . $j . "='" . $arr[$i]['peilv1' . $j] . "'";
                $sql .= ",points" . $j . "='" . $arr[$i]['points' . $j] . "'";
                $liberrsql .= ",peilv1" . $j . "='" . $arr[$i]['peilv1' . $j] . "'";
                $liberrsql .= ",points" . $j . "='" . $arr[$i]['points' . $j] . "'";
            }*/
            if(md5($md5str) != md5($oldmd5str)){
                //插入到修改记录表 x_lib_err
                $t = time();
                $c = LibErr::where('code',$code)->count('id');
                if($c <= 0){
                    //复制一份$lib对象
                    $liberr = $lib;
                    $liberr['ifcl'] = $lib['kk'];
                    $liberr['errtime'] = $t;
                    $liberr['action'] = 1;
                    $liberr['ifh'] = 1;
                    unset($liberr['id']);
                    unset($liberr['kk']);
                    LibErr::create($liberr);
                }else{
                    $db->update($liberrsql." where code='{$code}'");
                }
                $sql2 = $sql . ",kk=2 where {$sqls} ";
                $db->update($sql2);
                $userids[] = $lib['userid'];
            }
        }
        AdminFunc::jiaozhengedu(true);
        //去重
        $userids = array_unique($userids);
        if(count($userids) > 0) {
            $tb = 'x_lib_'.$tmpdate;
            foreach ($userids as $userid){
                ReportService::zhengli_day_report($tb,0,$userid);
            }
        }
        return response()->json(['code'=>1,'msg'=>'操作成功']);
    }

    public function delzddg(Request $request){
        $str = $request->input('str','');
        $tarr = json_decode($str,true);
        $db = Db::connection();
        $tmpdate = null;
        foreach ($tarr as $v) {
            $code = $v['code'];
            $dates = $v['dates'];
            $dates = date('Ymd',$dates);
            $tmpdate = date('Ymd',$v['dates']);
            $tb_lib = 'lib_'.$dates;
            $oldliberr = LibErr::where('code',$code)->count('id');
            if ($oldliberr > 0) {
                return response()->json(['code'=>0,'msg'=>'该订单已经存在于改单日志，请先还原改单日志']);
            }
            $oldorder = $db->table($tb_lib)->where('code',$code)->first();
            $userids[] = $oldorder['userid'];
            $liberr = $oldorder;
            $liberr['ifcl'] = $oldorder['kk'];
            $liberr['ifh'] = 1;
            $liberr['errtime'] = time();
            $liberr['action'] = 2;
            unset($liberr['kk']);
            unset($liberr['id']);
            $db->table($tb_lib)->where('code',$code)->delete();
            LibErr::create($liberr);
        }
        AdminFunc::jiaozhengedu(true);
        //去重
        $userids = array_unique($userids);
        if(count($userids) > 0) {
            foreach ($userids as $userid){
                $tb = 'x_lib_'.$tmpdate;
                ReportService::zhengli_day_report($tb,0,$userid);
            }
        }
        return response()->json(['code'=>1,'msg'=>'操作成功']);
    }
}
