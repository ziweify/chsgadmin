<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\Models\Game\Game;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\services\CommonCache;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController
{
    /**
     * 总报表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportAll(Request $request){
        $username = request()->input('username', '');
        $qishu = request()->input('qishu', '');
        $gid = request()->input('gid', -1);
        $startDate = request()->input('startDate', '');
        $endDate = request()->input('endDate', '');
        $page = request()->input('page', 1);
        $pageSize = request()->input('pageSize', 20);
        $mtype = request()->input('mtype', 0);
        //校验参数
        if(empty($startDate) || empty($endDate)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $maxDays = Userroom::where('userid',$ruid)->value('maxDays');
        $rs = SGUtils::pdDateRange($startDate,$maxDays);
        if(!$rs){
            return AppJson::error('日期范围错误');
        }
        $db = DB::connection();
        $startDate = strtotime($startDate.' 00:00:00');
        $endDate = strtotime($endDate.' 23:59:59');
        $where = " time >= {$startDate} and time <= {$endDate}";
        if(!empty($username)){
            //模糊查询username或者name
            $where .= " and username like '%{$username}%' or name like '%{$username}%'";
        }
        if(!empty($qishu)){
            $where .= " and qishu = '{$qishu}'";
        }
        if($gid != -1){
            $where .= " and gid = {$gid}";
        }
        if($mtype > 0){
            $where .= " and mtype = {$mtype}";
        }
        //x_money_log和x_user表，userid关联两张表
        $sql = "select a.userid,a.money,a.moneyType,a.operateType,a.time,a.gid,a.qishu,u.username,u.name,a.bz from x_money_log a left join x_user u on a.userid = u.userid where a.ruid = {$ruid} and {$where} order by a.id desc";
        //分页
        $res = $db->select("select count(a.id) as count from x_money_log a left join x_user u on a.userid = u.userid where a.ruid = {$ruid} and {$where}");
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

    /**
     * 用户报表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportUser(Request $request){
        $username = request()->input('username', '');
        $qishu = request()->input('qishu', '');
        $gid = request()->input('gid', -1);
        $startDate = request()->input('startDate', '');
        $endDate = request()->input('endDate', '');
        $sort = request()->input('sort', 'betMoney');
        //校验参数
        if(empty($startDate) || empty($endDate)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $maxDays = Userroom::where('userid',$ruid)->value('maxDays');
        $rs = SGUtils::pdDateRange($startDate,$maxDays);
        if(!$rs){
            return AppJson::error('日期范围错误');
        }
        $db = DB::connection();
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        if($startDate == $endDate){
            $where = " a.ruid = {$ruid} and dates = {$startDate}";
        }else{
            $where = " a.ruid = {$ruid} and dates >= {$startDate} and dates <= {$endDate}";
        }
        if(!empty($username)){
            //模糊查询username或者name
            $where .= " and username like '%{$username}%' or name like '%{$username}%'";
        }
        if(!empty($qishu)){
            $where .= " and qishu = '{$qishu}'";
        }
        if($gid != -1){
            $where .= " and gid = {$gid}";
        }
        $sortStr = '';
        if($sort == 1){//输赢降序
            $sortStr = ' order by yk desc';
        }elseif($sort == 2) {//输赢升序
            $sortStr = ' order by yk asc';
        }elseif ($sort == 3) {//投注金额降序
            $sortStr = ' order by betMoney desc';
        }elseif ($sort == 4) {//投注金额升序
            $sortStr = ' order by betMoney asc';
        }
        $totalData = ['balance'=>0,'totalSy'=>0,'totalMoney'=>0,'backWater'=>0,'totalCount'=>0];
        $sql = "select sum(a.count) as count,sum(a.valid_amount) as betMoney,sum(a.prize_amount/100-a.valid_amount) as yk,u.username,u.name,u.kmoney,a.userid from x_baototal a left join x_user u on a.userid = u.userid where {$where} group by a.userid $sortStr";
        $records = $db->select($sql);
        foreach ($records as &$record){
            $record['yk'] = ComFunc::pr2($record['yk']);
            $record['betMoney'] = ComFunc::pr2($record['betMoney']);
            $record['kmoney'] = ComFunc::pr2($record['kmoney']);

            $totalData['totalSy'] += $record['yk'];
            $totalData['totalMoney'] += $record['betMoney'];
            $totalData['balance'] += $record['kmoney'];
            $totalData['totalCount'] += $record['count'];
        }
        //格式化
        $totalData['totalSy'] = ComFunc::pr2($totalData['totalSy']);
        $totalData['totalMoney'] = ComFunc::pr2($totalData['totalMoney']);
        $totalData['balance'] = ComFunc::pr2($totalData['balance']);
        $result = [];
        $result['records'] = $records;
        $result['totalData'] = $totalData;
        return AppJson::success('ok',$result);
    }

    /**
     * 未结算报表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportWjs(Request $request){
        $gid = $request->input('gid','-1');
        $username = $request->input('username','');
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',20);
        $ruid = $request->ruid;
        $table = SGUtils::getcuretable(true);
        $db = Db::connection();$tmp = [];
        $where = " a.ruid='{$ruid}' and z = 9 ";
        if($gid != -1 && !empty($gid)){
            $where .= " and a.gid='{$gid}'";
        }
        if(!empty($username)){
            $where .= " and username like '%{$username}%' or name like '%{$username}%'";
        }
        $trow = $db->select("SELECT sum(a.je) as totalMoney FROM {$table} a LEFT JOIN x_user u ON a.userid = u.userid WHERE {$where}");
        $totalMoney = $trow[0]['totalMoney'] ?? 0;
        $sql = "select sid,pid,je,peilv1,gid,u.username,u.name,a.userid,a.qishu from {$table} a left join x_user u on a.userid = u.userid where {$where} order by a.id desc";
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
            unset($lib['sid']);unset($lib['pid']);unset($lib['gid']);
        }
        $result = [];
        $result['records'] = $libs;
        $result['totalMoney'] = $totalMoney;
        return AppJson::success('ok',$result);
    }


    /**
     * 获取报表日志
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportLogs(Request $request){
        $username = $request->input('username','');
        $ip = $request->input('ip','');
        $type = $request->input('type',1);//1登录日志 2操作日志
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',20);
        $startDate = $request->input('startDate','');
        $endDate = $request->input('endDate','');
        if(empty($startDate) || empty($endDate)){
            return AppJson::error('参数错误');
        }
        $startDate = strtotime($startDate.' 00:00:00');
        $endDate = strtotime($endDate.' 23:59:59');
        $ruid = $request->ruid;
        if($type == 1) {//登录日志
            $where = " ruid = {$ruid} and ifok = 1";
            $where .= " and time >= {$startDate} and time <= {$endDate}";
            if(!empty($ip)){
                $where .= " and ip = '{$ip}'";
            }
            if(!empty($username)){
                $where .= " and username = '{$username}'";
            }
            $db = DB::connection();
            /*$sql = "select count(id) as count from x_user_login a where {$where}";
            $res = $db->select($sql);
            $totalCount = $res[0]['count'];*/
            $sql = "select username,time,ip,addr from x_user_login a where {$where} order by id desc limit ".($page-1)*$pageSize.",".$pageSize;
            $records = $db->select($sql);
            foreach ($records as &$record){
                $record['time1'] = date('m-d',$record['time']);
                $record['time2'] = date('H:i:s',$record['time']);
            }
            $result = [];
            $result['records'] = $records;
            return AppJson::success('ok',$result);
        }elseif ($type == 2){//操作日志
            $where = " a.ruid = {$ruid} and a.moduleKey = 'platform'";
            $where .= " and a.moditime >= {$startDate} and a.moditime <= {$endDate}";
            if(!empty($username)){
                $where .= " and username = '{$username}'";
            }
            $db = DB::connection();
            $sql = "select a.modiuser,a.modisonuser,a.userid,a.moditime,a.action,u.username,a.oldvalue,a.newvalue from x_user_edit a left join x_user u on a.userid = u.userid where {$where} order by a.id desc";
            //分页
            $sql .= " limit ".($page-1)*$pageSize.",".$pageSize;
            $records = $db->select($sql);$tmp = [];
            foreach ($records as &$record){
                $record['time1'] = date('m-d',$record['moditime']);
                $record['time2'] = date('H:i:s',$record['moditime']);
                //查询修改人
                if(!isset($tmp[$record['modiuser']])){
                    $tmp[$record['modiuser']] = User::where(['userid'=>$record['modiuser'],'ruid'=>$ruid])->value('username');
                }
                //查询修改的子账号
                if(!isset($tmp[$record['modisonuser']]) && !empty($record['modisonuser'])){
                    $record['modiusername'] = User::where(['userid'=>$record['modisonuser'],'ruid'=>$ruid])->value('username');
                }else{
                    $record['modiusername'] = $tmp[$record['modiuser']];
                }
                //$record['modiusername'] = $tmp[$record['modiuser']];
                //$record['modisonusername'] = $tmp[$record['modisonuser']];
                if(!empty($record['oldvalue']) || !empty($record['newvalue'])){
                    $record['value'] = $record['oldvalue'].' '.$record['newvalue'];
                }
            }
            $result = [];
            $result['records'] = $records;
            return AppJson::success('ok',$result);
        }
    }

    /**
     * 获取用户下注记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBetrecordByUser(Request $request){
        $userid = $request->input('userid',0);
        $qishu = request()->input('qishu', '');
        $gid = request()->input('gid', -1);
        $startDate = request()->input('startDate', '');
        $endDate = request()->input('endDate', '');
        $page = request()->input('page', 1);
        $pageSize = request()->input('pageSize', 20);
        //校验参数
        if(empty($startDate) || empty($endDate) || empty($userid)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $whi = " ruid = {$ruid} and userid = {$userid} and z in (0,1,2) ";
        if(!empty($qishu)){
            $whi .= " and qishu = '{$qishu}'";
        }
        if($gid != -1){
            $whi .= " and gid = {$gid}";
        }
        $db = Db::connection();$tmp = [];
        $tbs = $db->select("SHOW TABLES LIKE  'x_lib_20%'");
        $tb = "";
        foreach ($tbs as $v) {
            $tb .= array_values($v)[0];
        }
        $dd = ComFunc::getthisdate();
        $datearr = ComFunc::getdatearr($startDate, $endDate, $dd, $tb);
        $fromdataarr = [];
        foreach ($datearr as $v) {
            $tb = "x_lib_".str_replace("-", "", $v);
            $fromdataarr[] = "SELECT sid,pid,je,peilv1,time,z,uzp,gid,qishu FROM {$tb} WHERE {$whi}";
        }
        $fromdatas = implode(" UNION ALL ", $fromdataarr);
        //$table = "x_lib_".date('Ymd',strtotime($date));
        /*$trow = $db->select("SELECT COUNT(*) as total FROM {$table} WHERE {$whi}");
        $total = $trow[0]['total'];*/
        //$sql = "select sid,pid,je,peilv1,time,z,uzp,gid,qishu from {$table} where {$whi} order by id desc";
        //分页
        //$sql .= " limit ".($page-1)*$pageSize.",".$pageSize;
        $sql = "SELECT * FROM ({$fromdatas}) AS a order by time desc LIMIT ".($page-1)*$pageSize.",".$pageSize;
        //Log::info($sql);
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
}
