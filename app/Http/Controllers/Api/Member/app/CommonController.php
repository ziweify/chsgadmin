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
}
