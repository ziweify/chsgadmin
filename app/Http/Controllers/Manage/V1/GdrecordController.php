<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\LibErr;
use App\Models\Game\User;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\sgwin\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GdrecordController extends ManageAuthController
{

    public function logs(){
        $qishu = array();
        $userid = $this->uid;
        //查询游戏数据
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share("gamecs", $lotterys);
        //$top_user = User::where('userid',$userid)->select(['layer','username'])->first();
        $sdate = AdminFunc::weekbyreport();
        view()->share("sdate", $sdate);
        return view('managev1.ordermodify.logs');
    }

    public function getgdrecordlist(Request $request){
        $page = $request->input('page', '');
        $start = $request->input('start', '');
        $end = $request->input('end', '');
        $uid = $request->input('username', '');
        $bid = $request->input('bid', '');
        $sid = $request->input('sid', '');
        $cid = $request->input('cid', '');
        $qishu = $request->input('qishu', '');
        $gid = $request->input('gid', '');
        $code = $request->input('code', '');
        $z = $request->input('z', '');
        $psize = $request->input('limit', 20);
        $db = Db::connection();
        $page = ComFunc::rpage($page);
        $start = strtotime($start." 00:00:00");
        $end = strtotime($end." 23:59:59");
        $username = trim($uid);
        $uid = "";
        if ($username != "") {
            $uid = User::where(['username'=>$username])->value('userid');
        }
        $whi = " errtime>='" . $start . "' and errtime<='" . $end . "' ";
        $tb_lib = 'x_lib_err';
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
        if(!empty($code)){
            $whi .= " and code='{$code}' ";
        }
        $join = " from `{$tb_lib}` where {$whi} ";
        $sql = " select count(id) as count {$join} ";
        $record_count = $db->select($sql);
        $rcount = ComFunc::pr0($record_count[0]['count']);
        //$pcount = $rcount % $psize == 0 ? $rcount / $psize : ($rcount - $rcount % $psize) / $psize + 1;
        //$pstr = ComFunc::page($pcount, $page);
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
            $tz[$i]['action'] = $item['action'];
            if ($uid == $item['userid']) {
                $tz[$i]['me'] = 1;
            }
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
            $tz[$i]['bids'] = $item['bid'];
            $tz[$i]['sids'] = $item['sid'];
            $tz[$i]['cids'] = $item['cid'];
            $tz[$i]['pids'] = $item['pid'];
            $tz[$i]['gids'] = $item['gid'];
            $tz[$i]['game'] = $tmp['g' . $item['gid']];
            $tz[$i]['fl'] = $tmp['f' . $item['gid']];
            $ytime = $item['time'];
            $tz[$i]['errtime'] = date('Y-m-d H:i:s', $item['errtime']);
            $tz[$i]['time'] = date('Y-m-d H:i:s', $item['time']);
            $tz[$i]['duser'] = $tmp['u' . $item['userid']];
            for ($j = 0; $j < 11; $j++) {
                $tz[$i]['zc' . $j] = ComFunc::pr2($item['je'] * $item['zc' . $j] / 100);
                if ($j != 0) {
                    $tz[$i]['points' . $j] = (double) $item['points' . $j];
                    $tz[$i]['peilv1' . $j] = (double) $item['peilv1' . $j];
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
            $dates = date('Ymd', $item['dates']);
            $tb = 'lib_'.$dates;
            $oldlib = $db->table($tb)->where('code', $item['code'])->first();
            if(!empty($oldlib)) {
                if($oldlib['pid'] != $item['pid']) {
                    if (!isset($tmp['b' . $oldlib['gid'] . $oldlib['bid']])) {
                        $tmp['b' . $oldlib['gid'] . $oldlib['bid']] = CsFunc::transb8('name', $oldlib['bid'], $oldlib['gid']);
                    }
                    if (!isset($tmp['s' . $oldlib['gid'] . $oldlib['sid']])) {
                        $tmp['s' . $oldlib['gid'] . $oldlib['sid']] = CsFunc::transs8('name', $oldlib['sid'], $oldlib['gid']);
                    }
                    if (!isset($tmp['c' . $oldlib['gid'] . $oldlib['cid']])) {
                        $tmp['c' . $oldlib['gid'] . $oldlib['cid']] = CsFunc::transc8('name', $oldlib['cid'], $oldlib['gid']);
                    }
                    if (!isset($tmp['p' . $oldlib['gid'] . $oldlib['pid']])) {
                        $tmp['p' . $oldlib['gid'] . $oldlib['pid']] = CsFunc::transp8('name', $oldlib['pid'], $oldlib['gid']);
                    }
                    $tz[$i]['oldbid'] = $tmp['b' . $oldlib['gid'] . $oldlib['bid']];
                    $tz[$i]['oldsid'] = $tmp['s' . $oldlib['gid'] . $oldlib['sid']];
                    $tz[$i]['oldcid'] = $tmp['c' . $oldlib['gid'] . $oldlib['cid']];
                    $tz[$i]['oldpid'] = $tmp['p' . $oldlib['gid'] . $oldlib['pid']];
                }
                if($oldlib['z'] != $item['z']) {
                    $tz[$i]['oldz'] = $oldlib['z'];
                }
                if($oldlib['je'] != $item['je']) {
                    $tz[$i]['oldje'] = $oldlib['je'];
                }
                if($oldlib['peilv1'] != $item['peilv1']) {
                    $tz[$i]['oldpeilv1'] = $oldlib['peilv1'];
                }
                if($oldlib['points'] != $item['points']) {
                    $tz[$i]['oldpoints'] = $oldlib['points'];
                }
                if($oldlib['time'] != $ytime) {
                    $tz[$i]['oldtime'] = date('Y-m-d H:i:s', $oldlib['time']);
                }
            }
            $i++;
        }
        $e = array("tz" => $tz, "page" => $page, "rcount"=>$rcount, "layer" => $layer);
        return response()->json($e);
    }

    public function huanyuanzhudan(Request $request){
        $str = $request->input('str','');
        $str = str_replace('\\', '',$str);
        $arr = json_decode($str, true);
        $ca = count($arr);$userids = [];
        $db = Db::connection();
        $dds = [];
        for ($i = 0; $i < $ca; $i++) {
            //判断数组中是否存在
            if(!in_array($arr[$i]['dates'],$dds)) {
                $dds[] = $arr[$i]['dates'];
            }
        }
        if(count($dds) > 1){
            return response()->json(['code'=>0,'msg'=>'只能恢复同一天的订单']);
        }
        for ($i = 0; $i < $ca; $i++) {
            $code = $arr[$i]['code'];
            $oldlib = LibErr::where('code',$code)->first();
            $tmpdate = date('Ymd', $oldlib['dates']);
            $userids[] = $oldlib['userid'];
            $dates = date('Ymd', $oldlib['dates']);
            $tb = 'lib_'.$dates;
            if($oldlib['action'] == 2){//恢复删除的订单
                $lib = $oldlib->toArray();
                $lib['kk'] = $lib['ifcl'];
                unset($lib['id']);
                unset($lib['ifcl']);
                unset($lib['ifh']);
                unset($lib['action']);
                unset($lib['errtime']);
                $db->table($tb)->insert($lib);
                $oldlib->delete();
            }else{
                $lib = $db->table($tb)->where('code', $code)->first();
                if(!empty($lib)) {
                    $update['bid'] = $oldlib['bid'];
                    $update['sid'] = $oldlib['sid'];
                    $update['cid'] = $oldlib['cid'];
                    $update['pid'] = $oldlib['pid'];
                    $update['z'] = $oldlib['z'];
                    $update['je'] = $oldlib['je'];
                    $update['peilv1'] = $oldlib['peilv1'];
                    $update['points'] = $oldlib['points'];
                    $update['time'] = $oldlib['time'];
                    $db->table($tb)->where('code', $code)->update($update);
                    $oldlib->delete();
                }
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
        return response()->json(['code'=>1,'msg'=>'恢复成功']);
    }
}
