<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\ComServices\ComServices;
use App\ComServices\UserService;
use App\ComServices\WebsocketConstants;
use App\Models\Game\Apply;
use App\Models\Game\MoneyLog;
use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\sgwin\AppJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ApplyController
{
    /**
     * 申请列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApplyList(Request $request){
        $ruid = $request->ruid;
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',10);
        $startDate = $request->input('startDate','');
        $endDate = $request->input('endDate','');
        $status = $request->input('status',-1);
        $username = $request->input('username','');
        $qtype = $request->input('qtype',1);
        $db = Db::connection();
        if($qtype == 1){//上下分审核
            $where = " a.ruid = {$ruid} and a.applyType in (2,3)";
            $jointable = "x_user";
        }elseif ($qtype == 2){//入群申请
            $where = " a.ruid = {$ruid} and a.applyType = 1";
            $jointable = "x_userreg";
        }
        if(!empty($startDate)){
            $startDate = strtotime($startDate.' 00:00:00');
            $where .= " and a.applicationTime >= $startDate";
        }
        if(!empty($endDate)){
            $endDate = strtotime($endDate.' 23:59:59');
            $where .= " and a.applicationTime <= $endDate";
        }
        if($status != -1){
            $where .= " and a.status = $status";
        }
        //username是模糊查询,username是username和name，在User表中
        if(!empty($username)){
            $where .= " and (u.username like '%$username%' or u.name like '%$username%')";
        }
        if($qtype == 1) {
            $sql = "select a.id,a.applyType,a.value,a.applicationTime,a.status,u.username,u.name,a.reviewTime from x_apply a left join {$jointable} u on a.ruid = u.ruid and a.userid = u.userid where ";
        }else{
            $sql = "select a.id,a.applyType,a.value,a.applicationTime,a.status,u.username,u.name,a.reviewTime from x_apply a left join {$jointable} u on a.userid = u.userid where ";
        }
        $sql .= $where;
        //排序
        $sql .= " order by a.applicationTime desc limit ".($page-1)*$pageSize.",".$pageSize;
        //Log::info('sql:'.$sql);
        $records = $db->select($sql);
        //处理时间
        foreach ($records as $key => $record){
            //申请时间
            $records[$key]['time1'] = date('m-d',$record['applicationTime']);
            $records[$key]['time2'] = date('H:i:s',$record['applicationTime']);
            if($qtype == 2){
                //审核时间
                if($record['reviewTime']){
                    $records[$key]['reviewTime1'] = date('m-d',$record['reviewTime']);
                    $records[$key]['reviewTime2'] = date('H:i:s',$record['reviewTime']);
                }else{
                    $records[$key]['reviewTime1'] = '';
                    $records[$key]['reviewTime2'] = '-';
                }
            }
        }
        if($qtype == 1){
            $res = $db->select("select count(a.id) as count from x_apply a left join {$jointable} u on a.ruid = u.ruid and a.userid = u.userid where $where");
        }else{
            $res = $db->select("select count(a.id) as count from x_apply a left join {$jointable} u on a.userid = u.userid where $where");
        }
        $totalCount = $res[0]['count'];
        $totalPage = ceil($totalCount/$pageSize);
        $result = [];
        $result['total'] = $totalCount;
        $result['totalPage'] = $totalPage;
        $result['currentPage'] = $page;
        $result['pageSize'] = $pageSize;
        $result['records'] = $records;
        //清除未读标记
        $key = WebsocketConstants::$NotReadApplyAgentPre.":".$ruid;
        Redis::del($key);
        return AppJson::success('ok',$result);
    }

    /**
     * 申请处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doApply(Request $request){
        $ruid = $request->ruid;
        $uid = $request->uid;
        $id = $request->input('id');
        $status = $request->input('status');
        $apply = Apply::where(['id'=>$id,'ruid'=>$ruid])->first();
        if(empty($apply)){
            return AppJson::error('申请不存在');
        }
        //如果applyType是2或者3,status只能是2或者3，4
        if($apply['applyType'] == 2 || $apply['applyType'] == 3) {
            if ($status != 2 && $status != 3 && $status != 4) {
                return AppJson::error('状态错误');
            }
        }
        if($apply['status'] != 1){
            return AppJson::error('申请已处理');
        }
        // 先获取基础数据，减少事务中的查询时间
        $roomConfig = Userroom::where('userid',$ruid)->select(['roomNickname','roomAvatar','userid'])->first();
        $name = Userreg::where('userid',$apply['userid'])->value('name');
        
        $db = DB::connection();
        $db->beginTransaction();
        try{
            Apply::where(['id'=>$id,'ruid'=>$ruid])->update(['status'=>$status,'operator'=>$uid,'reviewTime'=>time()]);
            
            $chatData = null; // 用于事务外发送消息
            $gid = $apply['relationid'];
            
            //通过
            if($apply['applyType'] == 2 || $apply['applyType'] == 3){//上分或者下分
                if($status == 3){//已通过
                    // 使用UserService的统一余额操作方法，确保并发安全
                    $operateType = ($apply['applyType'] == 2) ? 1 : 2; // 1增加 2减少
                    $logArr = [
                        'moneyType' => $apply['applyType'] == 2 ? 3 : 4,
                        'gid' => 0,
                        'qishu' => 0
                    ];
                    
                    $result = UserService::operBalance($apply['userid'], $ruid, $apply['value'], 1, $operateType, $logArr);
                    if($result['code'] == 0){
                        $db->rollBack();
                        return AppJson::error($result['msg'] ?? '余额操作失败');
                    }
                    
                    $kmoney = ComFunc::pr2($result['balance']);
                    if($apply['applyType'] == 2) {
                        $msg = "您的上分申请已通过,上分金额{$apply['value']},当前余额{$kmoney}";
                    }else{
                        $msg = "您的下分申请已通过,下分金额{$apply['value']},当前余额{$kmoney}";
                    }
                    
                    // 准备聊天消息数据，但在事务外发送
                    $chatData = [
                        'type' => 'game',
                        'chatType' => 'text',
                        'sender' => $ruid,
                        'nickname'=>$roomConfig['roomNickname'],
                        'avatar'=>$roomConfig['roomAvatar'],
                        'isA'=>$name,
                        'time'=>time(),
                        'content'=>$msg
                    ];
                }elseif($status == 2){//拒绝
                    if($apply['applyType'] == 2) {
                        $msg = "您的上分申请已被拒绝,上分金额{$apply['value']}";
                    }else{
                        $msg = "您的下分申请已被拒绝,下分金额{$apply['value']}";
                    }
                    // 准备聊天消息数据，但在事务外发送
                    $chatData = [
                        'type' => 'game',
                        'chatType' => 'text',
                        'sender' => $ruid,
                        'nickname'=>$roomConfig['roomNickname'],
                        'avatar'=>$roomConfig['roomAvatar'],
                        'isA'=>$name,
                        'time'=>time(),
                        'content'=>$msg
                    ];
                }
            }elseif ($apply['applyType'] == 1){//入群
                if($status == 3){//已通过
                    //初始化房间用户
                    (new UserService())->initRoomUser($apply['userid'],$ruid);
                }
            }
            $db->commit();
            
            // 事务提交成功后，发送聊天消息（避免在事务中进行非关键操作）
            if($chatData !== null){
                $chatListKey = WebsocketConstants::$chatListKeyPre.':'.$ruid.':'.$gid;
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                $fds = ComServices::getRoomAllFd($ruid);
                ComServices::sendMsg(null,$fds,'gamechat',$chatData,$gid,['getBalanceInfo'=>1]);
            }
            
            return AppJson::success('操作成功');
        }catch (\Exception $e){
            $db->rollBack();
            Log::error('doApply:'.$e->getMessage());
            return AppJson::error('操作失败,请重试');
        }
    }
}
