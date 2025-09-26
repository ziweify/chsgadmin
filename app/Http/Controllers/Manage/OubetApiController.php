<?php

namespace App\Http\Controllers\Manage;


use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\OutbetAccs;
use App\Models\Game\OutbetError;
use App\Models\Game\OutbetSite;
use App\ort\cachemodel\GameCache;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\common\JsFunc;
use App\ort\common\Json;
use App\ort\services\AutosService;
use App\ort\services\CommonCache;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OubetApiController
{
    //获取所有飞单订单
    public function getalloutbetorder(Request $request){
        $token = $request->input('token','');
        $outbet_token = x_config('outbet_token');
        if($token != $outbet_token){
            return Json::error('token error');
        }
        $redis = Redis::connection();
        //获取所有hash订单数据
        $list = $redis->hgetall("outbet_run_order");
        $data = [];
        foreach ($list as $v){
            $data[] = json_decode($v,true);
        }
        return Json::success('ok',$data);
    }

    //获取所有平台账号
    public function getallplatacc(Request $request){
        $token = $request->input('token','');
        $outbet_token = x_config('outbet_token');
        if($token != $outbet_token){
            return Json::error('token error');
        }
        $outbetsitelsit = OutbetSite::with(['accvs'])->where('enabled', 1)->get();
        return Json::success('ok',$outbetsitelsit);
    }

    //更新账号
    public function updateacc(Request $request){
        $token = $request->input('token','');
        $outbet_token = x_config('outbet_token');
        if($token != $outbet_token){
            return Json::error('token error');
        }
        $siteid = $request->input('siteid','');
        $accid = $request->input('accid','');
        $bz = $request->input('bz','');
        $online = $request->input('online','');
        $curl = $request->input('curl','');
        $error = $request->input('error','');
        $enabled = $request->input('enabled','');
        $update = [];
        if(!empty($bz)){
            $update['bz'] = $bz;
            $update['online'] = 0;
        }
        if(!empty($online) && is_numeric($online)){
            $update['online'] = $online;
        }
        if(!empty($curl)){
            $update['curl'] = $curl;
        }
        if($enabled != '' && in_array($enabled,[0,1])){
            $update['enabled'] = $enabled;
        }
        if(!empty($update)){
            OutbetAccs::where(['site'=>$siteid,'accid'=>$accid])->update($update);
        }
        if(!empty($error)){
           $site = OutbetSite::where('id',$siteid)->first();
           $acc = OutbetAccs::where(['site'=>$siteid,'accid'=>$accid])->first();
           OutbetError::create(['userid'=>$site['userid'],'create_time'=>time(),'type'=>'login','sitename'=>$site['name'].'-'.$acc['username'],'bz'=>$error]);
        }
        return Json::success('ok');
    }

    public function noticeorder(Request $request){
        $token = $request->input('token','');
        $outbet_token = x_config('outbet_token');
        if($token != $outbet_token){
            return Json::error('token error');
        }
        $data = $request->input('data','');
        $json = json_decode($data,true);
        $redis = Redis::connection();
        $libflymode = SGUtils::getcureflymodel();
        foreach ($json as $v){
            $bets = $v['bet'];
            $key = $v['key'];
            $ordetstatus = $v['ordetstatus'];
            $error = isset($v['error']) ? $v['error'] : '';
            foreach ($bets as $bet){
                $update = [];
                if($ordetstatus == 0){//飞单失败
                    $update['sv'] = 9;
                    $update['zcount'] = time();
                    $update['bz'] = $bet['bz'] . '|' . $error;
                }else{
                    $update['sv'] = 8;
                    $update['zcount'] = time();
                }
                $libflymode->where(['code'=>$bet['fcode']])->update($update);
            }
            //删除redis hash
            $redis->hdel("outbet_run_order",$key);
        }
        return Json::success('ok');
    }

    public function getcurqishu(Request $request){
        $gid = $request->input('gid','');
        $game = Game::where('gid',$gid)->select(['cs'])->first();
        $cs = json_decode($game['cs'], true);
        $kj_data = AutosService::getcurkj($gid,$cs);
        if(empty($kj_data)){
            return response()->json(['code'=>1,'msg'=>'ok','qishu'=>0]);
        }else{
            return response()->json(['code'=>1,'msg'=>'ok','qishu'=>$kj_data['qishu']]);
        }
    }

    public function cudatatotal(Request $request){
        $qishu = $request->input('qishu','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $table = SGUtils::getcureflytable(true);
        $list = $db->select("SELECT SUM(je) as je,bid,sid,cid,pid,cy FROM $table WHERE gid = $gid and qishu = $qishu and z = 11 and sv = 8 and dftype in ('BALL','LM') GROUP BY pid;");
        $fenlei = GameCache::getgamecache($gid)['fenlei'];
        $totalje = 0;
        foreach ($list as &$v){
            $bname = CommonCache::getbclasscache($gid,$v['bid'])['name'];
            $sname = CommonCache::getsclasscache($gid,$v['sid'])['name'];
            $cname = CommonCache::getclasscache($gid,$v['cid'])['name'];
            $pname = CommonCache::getplaycache($gid,$v['pid'])['name'];
            $wf = ComFunc::wfuser($fenlei,$bname,$sname,$cname,$pname);
            $v['wf'] = $wf;
            $totalje += $v['je'];
        }
        $totalje = ComFunc::pr2($totalje);
        //不转义中文
        return response()->json(['code'=>1,'msg'=>'ok','data'=>$list,'totalje'=>$totalje],200,[],JSON_UNESCAPED_UNICODE);
    }

    public function qishutotal(Request $request){
        $qishus = $request->input('qishus','');
        $gid = $request->input('gid','');
        $lmpeilv = $request->input('lmpeilv','');
        $ballpeilv = $request->input('ballpeilv','');
        $db = Db::connection();
        $table = SGUtils::getcureflytable(true);
        $newlist = [];
        $game = Game::where('gid',$gid)->select(['mnum','mtype','fenlei','ztype'])->first();
        $mtype = json_decode($game['mtype'], true);
        $ztype = json_decode($game['ztype'], true);
        $mnum = $game['mnum'];$tmp = [];
        $qishus = explode(',',$qishus);
        foreach ($qishus as $qishu){
            //先从缓存
            /*$list = Cache::get('qishutotal_'.$gid.'_'.$qishu);
            if(empty($list)){
                Cache::put('qishutotal_'.$gid.'_'.$qishu,$list,300*10);
            }*/
            $list = $db->select("SELECT SUM(je) as je,bid,sid,cid,pid,cy FROM $table WHERE gid = $gid and qishu = $qishu and z = 11 and sv = 8 and dftype in ('BALL','LM') GROUP BY pid;");
            //计算开奖
            $kjdata = Kj::where(['gid' => $gid, 'qishu' => $qishu])->first();
            $kj = [];
            $kj[0] = [];
            $kj[0]['m'] = [];
            for ($i = 1; $i <= $mnum; $i++) {
                $kj[0]['m'][] = $kjdata["m" . $i];
            }
            $totalyk = 0;$totalje = 0;
            foreach ($list as $v){
                if (!isset($tmp['c' . $v['cid']])) {
                    $mclass = CommonCache::getclasscache($gid,$v['cid']);
                    $tmp['c' . $v['cid']]['name'] = $mclass['name'];
                    $tmp['c' . $v['cid']]['mtype'] = $mclass['mtype'];
                    $tmp['c' . $v['cid']]['ftype'] = $mclass['ftype'];
                    $tmp['c' . $v['cid']]['cm'] = $mtype[$mclass['mtype']];
                    $tmp['c' . $v['cid']]['dftype'] = $mclass['dftype'];
                }
                if (!isset($tmp['s'.$v['sid']])) {
                    $tmp['s'.$v['sid']] = CommonCache::getsclasscache($gid,$v['sid'])['name'];
                }
                if (!isset($tmp['b'.$v['bid']])) {
                    $tmp['b'.$v['bid']] = CommonCache::getbclasscache($gid,$v['bid'])['name'];
                }
                if (!isset($tmp['p'.$v['pid']])) {
                    $play = CommonCache::getplaycache($gid,$v['pid']);
                    $tmp['p'.$v['pid']]['name'] = $play["name"];
                    $tmp['p'.$v['pid']]['ztype'] = $ztype[$play["ztype"]];
                    $tmp['p'.$v['pid']]['znum1'] = $play['znum1'];
                    $tmp['p'.$v['pid']]['znum2'] = $play['znum2'];
                    $tmp['p'.$v['pid']]['ptype'] = $play['ptype'];
                }
                if($tmp['c' . $v['cid']]['dftype'] == 'BALL'){
                    $peilv = $ballpeilv;
                }else{
                    $peilv = $lmpeilv;
                }
                if($game['fenlei'] == 107){
                    $flag = CsFunc::moni_107(null,null,$kj[0]['m'],$tmp['b'.$v['bid']],$tmp['s'.$v['sid']], $tmp['c' . $v['cid']],$tmp['p'.$v['pid']],'','');
                }elseif ($game['fenlei'] == 101) {
                    $flag = CsFunc::moni_101(null, null,$kj[0]['m'], $tmp['b' . $v['bid']], $tmp['s' . $v['sid']], $tmp['c' . $v['cid']], $tmp['p' . $v['pid']], '', '');
                }
                if($flag[0] == 1){//中奖
                    $yk = $v['je'] * $peilv - $v['je'];
                }elseif ($flag[0] == 2){//和局
                    $yk = 0;
                }else{//未中奖
                    $yk = -$v['je'];
                }
                $totalyk += $yk;
                $totalje += $v['je'];
                $v['yk'] = ComFunc::pr2($yk);
            }
            $totalyk = ComFunc::pr2($totalyk);
            $totalje = ComFunc::pr2($totalje);
            $newlist[] = ['qishu'=>$qishu,'list'=>$list,'totalyk'=>$totalyk,'totalje'=>$totalje];
        }
        return response()->json(['code'=>1,'msg'=>'ok','data'=>$newlist],200,[],JSON_UNESCAPED_UNICODE);
    }

    public function getqishus(Request $request){
        $gid = $request->get('gid','');
        $num = $request->get('num',10);
        $game = Game::where('gid',$gid)->select(['fenlei','mnum'])->first();
        $editstart = x_config('editstart');
        if (date("His") < str_replace(':', '',$editstart)) {
            $dates = date("Y-m-d", time() - 86400);
        } else {
            $dates = date("Y-m-d");
        }
        $kjlist = Kj::where(['gid'=>$gid,'status'=>1])->where('dates',strtotime($dates))->orderByDesc('qishu')->limit($num)->get();
        $list = [];
        foreach ($kjlist as $key=>$kj){
            $list[$key]['drawNumber'] = $kj['qishu'];
            $list[$key]['drawTime'] = date('Y-m-d H:i:s',$kj['kjtime']);
            $ma = [];
            for ($i = 1; $i <= $game['mnum']; $i++) {
                $m = intval($kj['m' . $i]);
                $ma[] = $m;
            }
            $list[$key]['result'] = implode(',',$ma);
        }
        return response()->json(['code'=>1,'msg'=>'ok','data'=>$list]);
    }
}
