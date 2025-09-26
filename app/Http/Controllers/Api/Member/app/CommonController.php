<?php

namespace App\Http\Controllers\Api\Member\app;


use App\ComServices\ComServices;
use App\ComServices\GameServices;
use App\ComServices\UserService;
use App\ComServices\WebsocketConstants;
use App\Events\UserLogin;
use App\Models\Game\Apply;
use App\Models\Game\Chatmsg;
use App\Models\Game\Game;
use App\Models\Game\Link;
use App\Models\Game\Roomhistory;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\glob\client;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use App\Services\TokenService;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommonController
{

    public function periodListOrSingle(Request $request){
        $gid = $request->get('gid','');
        $ruid = $request->ruid;
        $result = (new GameServices())->periodlistorsingle($ruid,$gid);
        return AppJson::success('ok',['list'=>$result,'gid'=>$gid]);
    }

    public function openResult(Request $request){
        $gid = $request->get('gid','');
        if (empty($gid)){
            return AppJson::error('彩种id不能为空');
        }
        $result = (new GameServices())->openResult($gid);
        return AppJson::success('ok',$result);
    }


    public function time(){
        //获取当期毫秒时间戳
        $time = explode(" ", microtime());
        $time = ($time[1] + $time[0]) * 1000;
        $time = round($time) . '';
        return AppJson::success('ok',['time'=>$time]);
    }

    //进入房间
    public function enterroom(Request $request){
        $roomid = $request->input('roomid', '');
        $type  = $request->input('type',1);//1房间号 2推荐码
        $logintype = $request->input('logintype',0);
        if (empty($roomid)) {
            return AppJson::error('房间号不能为空');
        }
        //检测房间号是否存在
        $uid = $request->uid;
        if($type == 1){
            $userroom = Userroom::where(['roomid' => $roomid])->select(['expiryDate','userid','groupJoinReview','roomStatus'])->first();
        }else{
            $userroom = Userroom::where(['cleanedCode' => $roomid])->select(['expiryDate','userid','groupJoinReview','roomStatus'])->first();
        }
        $msg = $type == 1 ? "房间号" : "推荐码";
        if (empty($userroom)) {
            return AppJson::error("您输入的{$msg}不存在，请确认后再试");
        }
        //房间是否到期，字段是expiryDate
        if ($userroom['expiryDate'] <= time()) {
            return AppJson::error('房间已到期，请联系客服');
        }
        //房间是否启用
        if($userroom['roomStatus'] == 0){
            return AppJson::error('房间已停用，请联系客服');
        }
        //查询当前房间的会员账号
        $user = User::where(['userid' => $uid,'ruid'=>$userroom['userid']])->select(['room_status','username'])->first();
        if (empty($user)) {
            //检测当前房间是否需要审核
            if($userroom['groupJoinReview'] == 1){//
                $applycount = Apply::where(['userid'=>$uid,'ruid'=>$userroom['userid'],'applyType'=>1,'status'=>1])->count('id');
                if($applycount > 0){
                    return AppJson::error('已经申请进入当前房间,请不要重复申请！');
                }
                $saveapply = [];
                $saveapply['userid'] = $uid;
                $saveapply['ruid'] = $userroom['userid'];
                $saveapply['applyType'] = 1;
                $saveapply['accountType'] = 1;
                $saveapply['applicationTime'] = time();
                $saveapply['status'] = 1;
                Apply::create($saveapply);
                $userreg = Userreg::where('userid',$uid)->select(['name','avatar'])->first();
                //websocket通知房主
                $key = WebsocketConstants::$NotReadApplyAgentPre.":".$userroom['userid'];
                if(!Redis::exists($key)){
                    Redis::set($key,1);
                }
                $ulist = User::where(['ruid'=>$userroom['userid'],'type'=>2])->select(['userid'])->get()->toArray();
                $fds = [];
                foreach ($ulist as $u){
                    $hfd = ComServices::getFdByUid($userroom['userid'],$u['userid']);
                    if(!empty($hfd)){
                        $fds[] = $hfd;
                    }
                }
                $other = ['isApplayMsg'=>1,'applyType'=>1];
                $other['nickname'] = $userreg['name'];
                $other['avatar'] = $userreg['avatar'];
                $other['mtype'] = 3;
                ComServices::sendMsg(null,$fds,'applyMsgEvent',[],0,$other);
                return AppJson::error('进入该群需要群主审核,已发起申请,请耐心等待');
            }
            (new UserService())->initRoomUser($uid,$userroom['userid']);
        }else{
            if($user['room_status'] == 0){
                return AppJson::error('您已被禁止进入该房间');
            }
            //登录日志
            $client = new client();
            $user_agent = $request->header('user-agent');
            $server_addr = $request->server('SERVER_ADDR');
            $os = $client->getbrowser($user_agent).' '.$client->getos($user_agent);
            $ip = request()->getClientIp();
            $account = $user['username'];
            event(new UserLogin(['log','user',1,$account,'',$server_addr,$os,$ip,$logintype,$userroom['userid']]));
            //更新userreg
            Userreg::where('userid',$uid)->update(['ruid'=>$userroom['userid']]);
            //房间进入历史记录
            $rc = Roomhistory::where(['userid'=>$uid,'ruid'=>$userroom['userid']])->count('id');
            if($rc <= 0){
                Roomhistory::create(['userid'=>$uid,'ruid'=>$userroom['userid']]);
            }
        }
        return AppJson::success('ok');
    }

    /**
     * 房间介绍数据2
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function gameintroduce(Request $request){
        $gid = $request->input('gid',0);
        if(empty($gid)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $uid = $request->uid;
        $game = Game::where(['gid'=>$gid])->select(['dftype'])->first();
        if(empty($game)){
            return AppJson::error('游戏不存在');
        }
        $dftypeJson = json_decode($game['dftype'],true);
        $patt = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->value('patt');
        $pattJson = json_decode($patt,true);
        $result = [];
        foreach ($pattJson as $key=>$item){
            $resultitem = [];
            $resultitem['name'] = $dftypeJson[$item['bc']].'-'.$item['name'];
            $resultitem['odds'] = $item['p'];
            $resultitem['minBetAmount'] = $item['minBetAmount'];
            $resultitem['maxBetAmount'] = $item['maxBetAmount'];
            $resultitem['maxUserPeriodAmount'] = $item['maxUserPeriodAmount'];
            $resultitem['maxPeriodAmount'] = $item['maxPeriodAmount'];
            $resultitem['key'] = $key;
            $result[] = $resultitem;
        }
        //查询公告
        $notice = Userroom::where(['userid'=>$ruid])->value('roomNotice');
        $return = [];
        $return['odds'] = $result;
        $return['notice'] = $notice;
        return AppJson::success('ok',$return);
    }

    //token授权tokenauth
    public function tokenAuth(Request $request){
        $qtoken = $request->input('token','');
        if(empty($qtoken)){
            return AppJson::error('授权失败');
        }
        $link = Link::where('token',$qtoken)->first();
        if(empty($link)){
            return AppJson::error('此链接已过期');
        }
        $ruid = $link['ruid'];
        $userid = $link['userid'];
        $gid = $link['gid'];
        //类型 时间：time 次数：count
        if($link['type'] == 'time'){
            $expire_time = $link['expire_time'];
            if($expire_time < time()){
                return AppJson::error('此链接已过期');
            }
        }else{
            if($link['count'] <= 0){
                return AppJson::error('此链接已过期');
            }
        }
        $template = Game::where('gid',$gid)->value('template');

        $user = Userreg::where(['userid'=>$userid,'type'=>0])->first();
        if(empty($user)){
            return AppJson::error('授权失败');
        }
        //更新用户信息
        $ip = $request->getClientIp();
        if(!empty($user['ipcustom'])){
            $ip = $user['ipcustom'];
        }
        $update = [];
        $update['lastloginip'] = $ip;
        $update['lastlogintime'] = time();
        $update['errortimes'] = 0;
        $update['logintimes'] = \DB::raw('logintimes+1');
        $update['ruid'] = $ruid;
        Userreg::where('userid',$user['userid'])->update($update);

        $userInfo = [
            'ruid' => $user['ruid'],
            'userid' => $user['userid'],
            'username' => $user['username'],
            'type' => $user['type'],
            'name' => $user['name'],
            'ifson' => 1,
            'avatar' => $user['avatar'],
        ];
        $extime = 1*24*3600;
        if(!empty($user['token'])){
            TokenService::deleteToken($user['token']);
        }
        $token = TokenService::createToken($userInfo, $extime);
        $update['token'] = $token;
        Userreg::where('userid',$user['userid'])->update($update);
        $result = [
            'token' => $token,
            'userInfo' => $userInfo,
            'expires_time' => time()+$extime,
            'ruid' => $ruid,
            'gid' => $gid,
            'template' => $template,
            'modifypwd' => $user['passtime'] == 0 ? 1 : 0,
        ];
        //更新次数和已使用次数use_count
        $use_count = $link['use_count']+1;
        Link::where('token',$qtoken)->update(['use_count'=>$use_count,'count'=>$link['count']-1]);
        return AppJson::success('登陆成功',$result);
    }

    /**
     * 获取打单中心记录 - 真实数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBettingCenterRecords(Request $request)
    {
        $gid = $request->input('gid');
        $uid = $request->uid;
        $ruid = $request->ruid;
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        
        try {
            // 获取当前日期，查询今日的打单记录
            $thisdate = \App\ort\common\ComFunc::getthisdateend();
            $db = \Illuminate\Support\Facades\DB::connection();
            
            // 获取当前的打单表名
            $flytb = \App\ort\sgwin\SGUtils::getcureflytable(false);
            
            // 检查表是否存在
            $tables = $db->select("SHOW TABLES LIKE '$flytb'");
            if (empty($tables)) {
                return AppJson::success('获取成功', ['records' => [], 'total' => 0]);
            }
            
            // 查询打单记录
            $query = $db->table($flytb)
                ->where('ruid', $ruid);
                
            if ($gid) {
                $query->where('gid', $gid);
            }
            
            $totalCount = $query->count();
            
            $records = $query->orderBy('id', 'desc')
                ->offset(($page - 1) * $pageSize)
                ->limit($pageSize)
                ->get();
            
            // 获取游戏名称缓存
            $gameNames = [];
            foreach ($records as &$record) {
                if (!isset($gameNames[$record->gid])) {
                    $gameNames[$record->gid] = \App\Models\Game\Game::where('gid', $record->gid)->value('gname');
                }
                $record->gname = $gameNames[$record->gid] ?? '未知游戏';
            }
            
            return AppJson::success('获取成功', [
                'records' => $records,
                'total' => $totalCount,
                'hasMore' => $totalCount > $page * $pageSize
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('获取打单记录失败: ' . $e->getMessage());
            return AppJson::error('获取失败');
        }
    }
    
    /**
     * 获取今日打单失败次数
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTodayBettingFailCount(Request $request)
    {
        $gid = $request->input('gid');
        $uid = $request->uid;
        $ruid = $request->ruid;
        
        // 从Redis或缓存中获取今日失败次数
        $cacheKey = "betting_fail_count:{$ruid}:{$uid}:{$gid}:" . date('Y-m-d');
        $failCount = Cache::get($cacheKey, 0);
        
        return AppJson::success('获取成功', ['failCount' => $failCount]);
    }
    
    /**
     * 增加打单失败次数
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function increaseBettingFailCount(Request $request)
    {
        $gid = $request->input('gid');
        $uid = $request->uid;
        $ruid = $request->ruid;
        
        // 缓存key，按日期区分
        $cacheKey = "betting_fail_count:{$ruid}:{$uid}:{$gid}:" . date('Y-m-d');
        $currentCount = Cache::get($cacheKey, 0);
        
        // 增加失败次数，缓存到第二天6点
        $tomorrow6am = strtotime(date('Y-m-d 06:00:00', strtotime('+1 day')));
        $expiresAt = $tomorrow6am - time();
        
        Cache::put($cacheKey, $currentCount + 1, $expiresAt);
        
        return AppJson::success('更新成功', ['failCount' => $currentCount + 1]);
    }
    
    /**
     * 获取打单配置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBettingConfig(Request $request)
    {
        $ruid = $request->ruid;
        
        try {
            $config = \App\Models\Game\Userroom::where('userid', $ruid)
                ->select(['outbet_switch', 'outbet_mode', 'outbet_overtime'])
                ->first();
            
            if (!$config) {
                return AppJson::error('用户房间配置不存在');
            }
                
            $result = [
                'enabled' => $config->outbet_switch == 1,
                'mode' => $config->outbet_mode ?? 3,
                'overtime' => $config->outbet_overtime ?? 30
            ];
            
            return AppJson::success('获取成功', $result);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('获取打单配置失败: ' . $e->getMessage());
            return AppJson::error('获取配置失败: ' . $e->getMessage());
        }
    }
    
    /**
     * 获取打单站点列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBettingSites(Request $request)
    {
        $ruid = $request->ruid;
        
        try {
            $sites = \App\Models\Game\OutbetSite::where('ruid', $ruid)
                ->select(['id', 'name', 'type', 'enabled', 'lixiancount', 'onlinecount', 'yichangcount', 'totalbalance', 'totalbet', 'totalwin', 'main_fu_type', 'create_time'])
                ->get();
                
            $result = [];
            foreach ($sites as $site) {
                // 主副站类型映射
                $mainFuTypeMap = [
                    1 => '主站',
                    2 => '副站',
                    3 => '混合'
                ];
                
                $result[] = [
                    'id' => $site->id,
                    'name' => $site->name,
                    'type' => $site->type,
                    'enabled' => $site->enabled == 1,
                    'offlineCount' => $site->lixiancount ?? 0,
                    'onlineCount' => $site->onlinecount ?? 0,
                    'errorCount' => $site->yichangcount ?? 0,
                    'balance' => number_format($site->totalbalance ?? 0, 2),
                    'totalbet' => number_format($site->totalbet ?? 0, 2),
                    'totalwin' => number_format($site->totalwin ?? 0, 2),
                    'main_fu_typestr' => $mainFuTypeMap[$site->main_fu_type] ?? '-',
                    'create_time' => date('Y-m-d H:i', strtotime($site->create_time))
                ];
            }
            
            return AppJson::success('获取成功', $result);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('获取打单站点失败: ' . $e->getMessage());
            return AppJson::error('获取站点失败');
        }
    }
    
    /**
     * 更新打单配置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBettingConfig(Request $request)
    {
        $ruid = $request->ruid;
        $enabled = $request->input('enabled', false);
        $mode = $request->input('mode', 3);
        
        try {
            \App\Models\Game\Userroom::where('userid', $ruid)->update([
                'outbet_switch' => $enabled ? 1 : 0,
                'outbet_mode' => $mode
            ]);
            
            return AppJson::success('配置更新成功');
        } catch (\Exception $e) {
            return AppJson::error('更新配置失败');
        }
    }
    
    /**
     * 更新站点状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSiteStatus(Request $request)
    {
        $ruid = $request->ruid;
        $id = $request->input('id');
        $enabled = $request->input('enabled', false);
        
        try {
            \App\Models\Game\OutbetSite::where(['id' => $id, 'ruid' => $ruid])
                ->update(['enabled' => $enabled ? 1 : 0]);
                
            return AppJson::success('状态更新成功');
        } catch (\Exception $e) {
            return AppJson::error('状态更新失败');
        }
    }
    
    /**
     * 删除站点
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSite(Request $request)
    {
        $ruid = $request->ruid;
        $id = $request->input('id');
        
        try {
            $deleted = \App\Models\Game\OutbetSite::where(['id' => $id, 'ruid' => $ruid])
                ->delete();
                
            if ($deleted) {
                return AppJson::success('删除成功');
            } else {
                return AppJson::error('站点不存在');
            }
        } catch (\Exception $e) {
            return AppJson::error('删除失败');
        }
    }
    
    /**
     * 添加站点 (暂时返回提示)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addSite(Request $request)
    {
        // TODO: 实现添加站点功能
        return AppJson::error('添加站点功能开发中');
    }
}
