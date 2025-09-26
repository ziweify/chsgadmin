<?php

namespace App\Http\Controllers\Api\Member\app;

use App\ComServices\GameServices;
use App\ComServices\WebsocketConstants;
use App\Models\Game\News;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\services\CommonCache;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RoomController
{
    
    public function getRoomNotice(Request $request){
        $ruid = $request->ruid;
        $uid = $request->uid;
        $notice = Userroom::where(['userid'=>$ruid])->value('roomNotice');
        $key = WebsocketConstants::$NotReadMsgMemberPre.":".$ruid.':'.$uid;
        $notReadCount = Redis::get($key);
        $notReadCount = $notReadCount ? : 0;
        //平台弹窗公告
        $news = News::where(['ifok'=>1,'alert'=>1])->whereIn('agent',[0,2])->select(['title','content','time'])->get()->toArray();
        $alerts = [];
        foreach ($news as $v){
            $alerts[] = ['title'=>$v['title'],'content'=>$v['content'],'time'=>date('Y-m-d H:i:s',$v['time'])];
        }
        return AppJson::success('ok',['notice'=>$notice,'notReadCount'=>$notReadCount,'alerts'=>$alerts]);
    }

    public function quickPlayDetail(Request $request){
        $ruid = $request->ruid;
        $gid = $request->input('gid','');
        if(empty($gid)){
            return AppJson::error('无效参数');
        }
        $res = (new GameServices())->quickPlayDetail($gid,$ruid);
        return AppJson::success('ok',$res);
    }

    public function getBetsSumByLotteryId(Request $request){
        $ruid = $request->ruid;
        $gid = $request->input('gid','');
        if(empty($gid)){
            return AppJson::error('无效参数');
        }
        $uid = $request->uid;
        $tb_lib = SGUtils::getcuretable(true);
        $db = Db::connection();
        $whi = " ruid = {$ruid} and gid = {$gid} and userid = {$uid} GROUP BY qishu ORDER BY qishu DESC";
        $list = $db->select("SELECT qishu,z,count(id) as c,sum(if(z=1,peilv1*je*zcount,0)) as zhong,sum(if(z in (0,1,9),je,0)) as zje,sum(if(z=1,uzp*je,0)) as tax,sum(if(z=2,je,0)) as heje FROM {$tb_lib} WHERE {$whi}");
        $rlist = [];
        foreach ($list as $row){
            $qishu = $row['qishu'];
            $z = $row['z'];
            $zhong = $row['zhong'] ?: 0;
            $zje = $row['zje'] ?: 0;
            $tax = $row['tax'] ?: 0;
            $heje = $row['heje'] ?: 0;
            $total = $row['c'] ?: 0;

            $myk = $zhong-$zje-$tax+$heje;

            $item = [];
            $item['period'] = $qishu;
            $item['isSettle'] = $z == 9 ? false : true;
            $item['totalCount'] = $total;
            $item['totalMoney'] = $zje;
            $item['winLose'] = ComFunc::pr2($myk);
            $item['orders'] = [];
            $rlist[] = $item;
        }
        return AppJson::success('ok',$rlist);
    }

    public function getLotterySettledList(Request $request){
        $ruid = $request->ruid;
        $gid = $request->input('gid','');
        $period = $request->input('period','');
        if(empty($gid) || empty($period)){
            return AppJson::error('无效参数');
        }
        $uid = $request->uid;
        $tb_lib = SGUtils::getcuretable(true);
        $db = Db::connection();
        $whi = " ruid = {$ruid} and gid = {$gid} and qishu = {$period} and userid = {$uid} ORDER BY id DESC";
        $list = $db->select("SELECT sid,pid,qishu,uzp,je,zcount,time,peilv1,z FROM {$tb_lib} WHERE {$whi}");
        $rlist = [];$tmp = [];
        foreach ($list as $row){
            $item = [];
            if ($row['z'] == 1) {
                $item['winLose'] = ComFunc::pr2(($row['peilv1']*$row['zcount']*$row['je']-$row['je'])-($row['uzp']*$row['je']));
            }else if ($row['z'] == 2 || $row['z'] == 9) {
                $item['winLose'] = 0;
            }else {
                $item['winLose'] = ComFunc::pr2(0-$row['je']);
            }
            $item['period'] = $row['qishu'];
            $item['je'] = $row['je'];
            $item['time'] = date('Y-m-d H:i:s',$row['time']);
            if(!isset($tmp[$row['sid']])){
                $tmp[$row['sid']] = CommonCache::getsclasscache($gid,$row['sid'])['name'];
            }
            if(!isset($tmp[$row['pid']])){
                $tmp[$row['pid']] = CommonCache::getplaycache($gid,$row['pid'])['name'];
            }
            $item['playGroupName'] = $tmp[$row['sid']];
            $item['playDetailName'] = $tmp[$row['pid']];
            $item['isSettle'] = $row['z'] == 9 ? false : true;
            $rlist[] = $item;
        }
        return AppJson::success('ok',$rlist);
    }
}
