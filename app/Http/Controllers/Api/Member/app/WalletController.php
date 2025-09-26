<?php

namespace App\Http\Controllers\Api\Member\app;


use App\ComServices\UserService;
use App\Models\Game\Game;
use App\Models\Game\Userpatt;
use App\Models\Game\Userroom;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\services\CommonCache;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController
{

    /**
     * 获取余额信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getBalanceInfo(Request $request){
        $uid = $request->uid;
        $ruid = $request->ruid;
        $res = UserService::getBalanceInfo($uid,$ruid);
        return AppJson::success('ok',$res);
    }

    /**
     * 申请列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApplyList(Request $request){
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',10);
        $startDate = $request->input('startDate','');
        $endDate = $request->input('endDate','');
        $db = Db::connection();
        $ruid = $request->ruid;
        $uid = $request->uid;
        $where = " ruid = {$ruid} and userid = {$uid} and applyType in (2,3) ";
        if(!empty($startDate)){
            $startDate = strtotime($startDate.' 00:00:00');
            $where .= " and applicationTime >= $startDate";
        }
        if(!empty($endDate)){
            $endDate = strtotime($endDate.' 23:59:59');
            $where .= " and applicationTime <= $endDate";
        }
        $sql = "select applyType,value,applicationTime,status,reviewTime from x_apply a where {$where}";
        $sql .= " order by id desc limit ".($page-1)*$pageSize.",".$pageSize;
        $records = $db->select($sql);
        //处理时间
        foreach ($records as $key => $record){
            //申请时间
            $records[$key]['time1'] = date('m-d',$record['applicationTime']);
            $records[$key]['time2'] = date('H:i:s',$record['applicationTime']);
        }
        $res = $db->select("select count(id) as count from x_apply a where $where");
        $totalCount = $res[0]['count'];
        $totalPage = ceil($totalCount/$pageSize);
        $result = [];
        $result['total'] = $totalCount;
        $result['totalPage'] = $totalPage;
        $result['currentPage'] = $page;
        $result['pageSize'] = $pageSize;
        $result['records'] = $records;
        return AppJson::success('ok',$result);
    }

    //两周报表
    public function report(Request $request){
        $type = $request->input('type',1);//1 本周 2 上周
        $gid = $request->input('gid','');
        $db = Db::connection();
        $ruid = $request->ruid;
        $uid = $request->uid;
        $editend = x_config('editend');
        $ddd = ComFunc::getthisdateend();//
        $sdate = AdminFunc::week();
        $start = strtotime($sdate[5].' '.$editend);
        $upstart = strtotime($sdate[7].' '.$editend);
        $list = [];
        $whi = " ruid = {$ruid} and userid = {$uid} ";
        if($gid != '-1'){
            $whi .= " and gid = {$gid}";
        }
        for ($i = 1; $i <= 7; $i++) {
            if($type == 2){//上周
                $date = date("Y-m-d",$upstart+($i-1)*86400);
            }else{
                $date = date("Y-m-d",$start+($i-1)*86400);
            }
            $item = ['count'=>0,'bet_amount'=>0,'valid_amount'=>0,'win_amount'=>0];
            $week = ComFunc::rweek(date("w", strtotime($date)));
            $item['date'] = $date;
            $item['week'] = $week;
            if ($date > $ddd) {
                $list[] = $item;
                continue;
            }
            $dates = strtotime($date);
            $sql = "select sum(count) as count,sum(bet_amount) as bet_amount,sum(valid_amount) as valid_amount,sum(prize_amount/100) as prize_amount from x_baototal where dates = {$dates} and {$whi}";
            $res = $db->select($sql);
            $count = $res[0]['count'] ?? 0;
            $bet_amount = $res[0]['bet_amount'] ?? 0;
            $valid_amount = $res[0]['valid_amount'] ?? 0;
            $prize_amount = $res[0]['prize_amount'] ?? 0;
            $item['count'] = $count;
            $item['bet_amount'] = ComFunc::pr2($bet_amount);
            $item['valid_amount'] = ComFunc::pr2($valid_amount);
            $item['win_amount'] = ComFunc::pr2($prize_amount-$bet_amount);
            $list[] = $item;
        }
        return AppJson::success('ok',$list);
    }

    /**
     * 获取投注记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBetrecord(Request $request){
        $qishu = request()->input('qishu', '');
        $gid = request()->input('gid', -1);
        $date = request()->input('date', '');
        $page = request()->input('page', 1);
        $pageSize = request()->input('pageSize', 20);
        //校验参数
        if(empty($date)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $uid = $request->uid;
        /*$maxDays = Userroom::where('userid',$ruid)->value('maxDays');
        $rs = SGUtils::pdDateRange($date,$maxDays);
        if(!$rs){
            return AppJson::error('日期范围错误');
        }*/
        $whi = " ruid = {$ruid} and userid = {$uid} and z in (0,1,2) ";
        if(!empty($qishu)){
            $whi .= " and qishu = '{$qishu}'";
        }
        if($gid != -1){
            $whi .= " and gid = {$gid}";
        }
        $table = "x_lib_".date('Ymd',strtotime($date));
        $db = Db::connection();$tmp = [];
        /*$trow = $db->select("SELECT COUNT(*) as total FROM {$table} WHERE {$whi}");
        $total = $trow[0]['total'];*/
        $sql = "select sid,pid,je,peilv1,time,z,uzp,gid,qishu from {$table} where {$whi} order by id desc";
        //分页
        $sql .= " limit ".($page-1)*$pageSize.",".$pageSize;
        $libs = $db->select($sql);
        foreach ($libs as &$lib){
            if(!isset($tmp[$lib['sid']])){
                $tmp['s'.$lib['sid']] = CommonCache::getsclasscache($lib['gid'],$lib['sid'])['name'];
            }
            if(!isset($tmp[$lib['pid']])){
                $tmp['p'.$lib['pid']] = CommonCache::getplaycache($lib['gid'],$lib['pid'])['name'];
            }
            if(!isset($tmp[$lib['gid']])){
                $tmp['g'.$lib['gid']] = Game::where('gid',$lib['gid'])->value('gname');
            }
            $lib['sname'] = $tmp['s'.$lib['sid']];
            $lib['pname'] = $tmp['p'.$lib['pid']];
            $lib['gname'] = $tmp['g'.$lib['gid']];
            $lib['time1'] = date('m-d',$lib['time']);
            $lib['time2'] = date('H:i:s',$lib['time']);

            //盈亏
            If($lib['z'] == 1){//中奖
                $lib['yk'] = ComFunc::pr2(($lib['je'] * $lib['peilv1'])-$lib['je']-($lib['je']*$lib['uzp']));
            }else if($lib['z'] == 0){//未中奖
                $lib['yk'] = ComFunc::pr2(-$lib['je']);
            }else{
                $lib['yk'] = 0;
            }
            unset($lib['sid']);unset($lib['pid']);unset($lib['z']);unset($lib['uzp']);unset($lib['time']);
            unset($lib['gid']);
        }
        $result = [];
        $result['list'] = $libs;
        //$result['total'] = $total;
        return AppJson::success('ok',$result);
    }

    /**
     * 获取未结算报表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWjsRecord(Request $request){
        $gid = $request->input('gid','-1');
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',20);
        $ruid = $request->ruid;
        $uid = $request->uid;
        $table = SGUtils::getcuretable(true);
        $db = Db::connection();$tmp = [];
        $where = " ruid='{$ruid}' and userid = {$uid} and z = 9 ";
        if($gid != -1 && !empty($gid)){
            $where .= " and gid='{$gid}'";
        }
        $trow = $db->select("SELECT sum(je) as totalMoney FROM {$table} WHERE {$where}");
        $totalMoney = $trow[0]['totalMoney'] ?? 0;
        $sql = "select sid,pid,je,peilv1,gid,qishu,time from {$table} where {$where} order by id desc";
        //分页
        $sql .= " limit ".($page-1)*$pageSize.",".$pageSize;
        $libs = $db->select($sql);
        foreach ($libs as &$lib){
            if(!isset($tmp[$lib['sid']])){
                $tmp['s'.$lib['sid']] = CommonCache::getsclasscache($lib['gid'],$lib['sid'])['name'];
            }
            if(!isset($tmp[$lib['pid']])){
                $tmp['p'.$lib['pid']] = CommonCache::getplaycache($lib['gid'],$lib['pid'])['name'];
            }
            if(!isset($tmp[$lib['gid']])){
                $tmp['g'.$lib['gid']] = Game::where('gid',$lib['gid'])->value('gname');
            }
            $lib['sname'] = $tmp['s'.$lib['sid']];
            $lib['pname'] = $tmp['p'.$lib['pid']];
            $lib['gname'] = $tmp['g'.$lib['gid']];
            $lib['time1'] = date('m-d',$lib['time']);
            $lib['time2'] = date('H:i:s',$lib['time']);
            unset($lib['sid']);unset($lib['pid']);unset($lib['gid']);
        }
        $result = [];
        $result['records'] = $libs;
        $result['totalMoney'] = $totalMoney;
        return AppJson::success('ok',$result);
    }

    public function getMoneyLogList(Request $request){
        $qishu = request()->input('qishu', '');
        $gid = request()->input('gid', -1);
        $startDate = request()->input('startDate', '');
        $endDate = request()->input('endDate', '');
        $page = request()->input('page', 1);
        $pageSize = request()->input('pageSize', 20);
        //校验参数
        if(empty($startDate) || empty($endDate)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $uid = $request->uid;
        $maxDays = Userroom::where('userid',$ruid)->value('maxDays');
        $rs = SGUtils::pdDateRange($startDate,$maxDays);
        if(!$rs){
            return AppJson::error('日期范围错误');
        }
        $db = DB::connection();
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        if($startDate == $endDate){
            $where = " userid = {$uid} and dates = {$startDate}";
        }else{
            $where = " userid = {$uid} and dates >= {$startDate} and dates <= {$endDate}";
        }
        if(!empty($qishu)){
            $where .= " and qishu = '{$qishu}'";
        }
        if($gid != -1){
            $where .= " and gid = {$gid}";
        }
        $sql = "select userid,money,moneyType,operateType,time,gid,qishu,bz from x_money_log where {$where} order by id desc";
        $res = $db->select("select count(id) as count from x_money_log where {$where}");
        $totalCount = $res[0]['count'];
        $sql .= " limit ".($page-1)*$pageSize.",".$pageSize;
        $records = $db->select($sql);
        $tmp = [];
        foreach ($records as &$record){
            $record['time1'] = date('m-d',$record['time']);
            $record['time2'] = date('H:i:s',$record['time']);
            if(!empty($record['gid'])){
                if(!isset($tmp[$record['gid']])){
                    $tmp[$record['gid']] = Game::where('gid',$record['gid'])->value('gname');
                }
                $record['gname'] = $tmp[$record['gid']];
            }else{
                $record['gname'] = '';
                $record['qishu'] = '';
            }
        }
        $totalPage = ceil($totalCount/$pageSize);
        $result = [];
        $result['total'] = $totalCount;
        $result['totalPage'] = $totalPage;
        $result['currentPage'] = $page;
        $result['pageSize'] = $pageSize;
        $result['records'] = $records;
        return AppJson::success('ok',$result);
    }
}
