<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\ComServices\ComServices;
use App\Models\Game\Userpatt;
use App\ort\common\ComFunc;
use App\ort\services\CommonCache;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameDataController
{
    public function gameData(Request $request){
        $gid = $request->input('gid','');
        $ruid = $request->ruid;
        $model = SGUtils::ruidGameModelByRoom($ruid);
        if (!empty($gid)) {
            $model->where('game.gid', $gid);
        }
        $model = $model->select(['userpatt.gid','stopstatus','gname','ifok','template','fpseconds','userclosetime'])->orderBy('userpatt.xsort');
        $gamelist = $model->get();
        $fields1 = ['qishu','opentime','closetime','kjtime'];
        $time = time();$dates = ComFunc::getthisdateend();
        $result = [];$table = SGUtils::getcuretable(true);
        foreach ($gamelist as $game) {
            $return = [];
            $return['gid'] = $game['gid'];
            $return['gname'] = $game['gname'];
            $return['template'] = $game['template'];
            $return['stopstatus'] = $game['stopstatus'];
            $return['ifok'] = $game['ifok'] == 1;
            $return['dqls'] = 0;
            if($game['ifok'] == 0){
                $return['fp'] = 0;
                $return['timearr'] = ['-','-','-','-'];
                $return['nowSaleTime'] = 0;//开盘时间
                $return['nowSealTime'] = 0;//封盘时间
                $return['nowOpenTime'] = 0;//开奖时间
                $return['sysTime'] = $time;
                $return['period'] = '-';
                $result[] = $return;
                continue;
            }
            $return['jrsy'] = ComServices::getJrsy($ruid,$game['gid']);
            $return['jrls'] = ComServices::getLiushui($ruid,$game['gid'],null,$table);
            if ($game['stopstatus'] == 1) {//当天已停盘
                $return['fp'] = 0;
                $return['timearr'] = ['-','-','-','-'];
                $return['nowSaleTime'] = 0;//开盘时间
                $return['nowSealTime'] = 0;//封盘时间
                $return['nowOpenTime'] = 0;//开奖时间
                $return['sysTime'] = $time;
                $upkj = SGUtils::upPeriod($game['gid'],$dates,['qishu']);
                $return['period'] = $upkj['qishu'];
            } else {
                $kj_data = SGUtils::currentPeriod($game['gid'],$dates,null,$fields1);
                if (empty($kj_data)) {
                    $return['fp'] = 0;
                    $return['timearr'] = ['-','-','-','-'];
                    $return['nowSaleTime'] = 0;
                    $return['nowSealTime'] = 0;
                    $return['nowOpenTime'] = 0;
                    $return['sysTime'] = $time;
                    $return['period'] = '-';
                    $return['stopstatus'] = 1;
                } else {
                    $return['dqls'] = ComServices::getLiushui($ruid,$game['gid'],$kj_data['qishu'],$table,0,'qishu');
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
            $result[] = $return;
        }
        return AppJson::success('ok',['list'=>$result,'gid'=>$gid]);
    }

    public function betDataByPeriod(Request $request){
        $gid = $request->input('gid','');
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',20);
        if(empty($gid)){
            return AppJson::error('参数异常');
        }
        $ruid = $request->ruid;
        $table = SGUtils::getcuretable(true);
        $qishu = Userpatt::where(['userid'=>$ruid,'gid'=>$gid])->value('thisqishu');
        $db = Db::connection();
        $whi = " a.ruid = {$ruid} and gid = {$gid} and qishu = {$qishu} and a.robot = 0";
        $sql = "SELECT SUM(je) as je,b.username,b.`name`,b.kmoney,a.userid FROM {$table} a LEFT JOIN x_user b ON a.userid = b.userid WHERE {$whi} GROUP BY a.userid";
        $list = $db->select($sql);
        foreach ($list as &$item){
            $item['kmoney'] = ComFunc::pr2($item['kmoney']);
        }
        return AppJson::success('ok',['list'=>$list]);
    }

    public function betDataRecord(Request $request){
        $gid = $request->input('gid','');
        $userid = $request->input('userid','');
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',20);
        if(empty($gid) || empty($userid)){
            return AppJson::error("参数异常");
        }
        $ruid = $request->ruid;
        $table = SGUtils::getcuretable(true);
        $db = Db::connection();$tmp = [];
        $qishu = Userpatt::where(['userid'=>$ruid,'gid'=>$gid])->value('thisqishu');
        $whi = " gid='{$gid}' and ruid='{$ruid}' and userid = {$userid} and qishu='{$qishu}' and z = 9 ";
        $trow = $db->select("SELECT COUNT(*) as total FROM {$table} WHERE {$whi}");
        $total = $trow[0]['total'];
        $sql = "select sid,pid,je,peilv1 from {$table} where {$whi} order by pid asc";
        //分页
        $sql .= " limit ".($page-1)*$pageSize.",".$pageSize;
        $libs = $db->select($sql);
        foreach ($libs as &$lib){
            if(!isset($tmp[$lib['sid']])){
                $tmp['s'.$lib['sid']] = CommonCache::getsclasscache($gid,$lib['sid'])['name'];
            }
            if(!isset($tmp[$lib['pid']])){
                $tmp['p'.$lib['pid']] = CommonCache::getplaycache($gid,$lib['pid'])['name'];
            }
            $lib['sname'] = $tmp['s'.$lib['sid']];
            $lib['pname'] = $tmp['p'.$lib['pid']];
            unset($lib['sid']);unset($lib['pid']);
        }
        $result = [];
        $result['list'] = $libs;
        $result['total'] = $total;
        return AppJson::success('ok',$result);
    }
}
