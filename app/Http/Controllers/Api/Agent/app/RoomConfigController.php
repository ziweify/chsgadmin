<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\Models\Game\Game;
use App\Models\Game\Gamemsg;
use App\Models\Game\Roomhistory;
use App\Models\Game\Userpatt;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoomConfigController
{
    /**
     * 获取房间配置信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function configInfo(Request $request){
        $ruid = $request->ruid;
        $ifson = $request->ifson;
        $config = ['input'=>[],'switch'=>[]];
        $roomConfig = Userroom::where(['userid'=>$ruid])->first();
        //房间名字 roomName
        $config['input'][] = ['key'=>'roomName','name'=>'房间名字','value'=>$roomConfig['roomName'],'type'=>'input'];
        //聊天昵称 roomNickname
        $config['input'][] = ['key'=>'roomNickname','name'=>'聊天昵称','value'=>$roomConfig['roomNickname'],'type'=>'input'];
        //房间公告 roomNotice
        $config['input'][] = ['key'=>'roomNotice','name'=>'房间公告','value'=>$roomConfig['roomNotice'],'type'=>'textarea'];
        //系统消息中显示账号名称长度 chatroomNicknameLength
        $config['input'][] = ['key'=>'chatroomNicknameLength','name'=>'系统消息中显示账号名称长度','value'=>$roomConfig['chatroomNicknameLength'].'','type'=>'input'];
        //低分数不发账单消息 lowScoreNoBillMessage
        $config['input'][] = ['key'=>'lowScoreNoBillMessage','name'=>'低分数不发账单消息','value'=>$roomConfig['lowScoreNoBillMessage'],'type'=>'input'];
        //下分密码可错次数 wrongAttemptsAllowed
        //$config['input'][] = ['key'=>'wrongAttemptsAllowed','name'=>'下分密码可错次数','value'=>$roomConfig['wrongAttemptsAllowed'],'type'=>'input'];
        //子账号登录密码可错次数 passwordAttemptsAllowed
        $ifson == 0 && $config['input'][] = ['key'=>'passwordAttemptsAllowed','name'=>'子账号登录密码可错次数','value'=>$roomConfig['passwordAttemptsAllowed'],'type'=>'input'];
        //单注下注预警金额值 wordBetWarning
        //$config['input'][] = ['key'=>'wordBetWarning','name'=>'单注下注预警金额值','value'=>$roomConfig['wordBetWarning'],'type'=>'input'];
        //大额中奖预警值 bigWinningWarning
        //$config['input'][] = ['key'=>'bigWinningWarning','name'=>'大额中奖预警值','value'=>$roomConfig['bigWinningWarning'],'type'=>'input'];

        //入群审核 groupJoinReview
        $config['switch'][] = ['key'=>'groupJoinReview','name'=>'入群审核','value'=>$roomConfig['groupJoinReview'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //上下分和入群提示音 creditChAndGrpJoinSound
        //$config['switch'][] = ['key'=>'creditChAndGrpJoinSound','name'=>'上下分和入群提示音','value'=>$roomConfig['creditChAndGrpJoinSound'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //龙虎和结算方式 dtSettleMethod
        $config['switch'][] = ['key'=>'dtSettleMethod','name'=>'龙虎和结算方式','value'=>$roomConfig['dtSettleMethod'],'type'=>'switch','activeText'=>'通杀','inactiveText'=>'返本'];
        //自助回水 selfWater
        $config['switch'][] = ['key'=>'selfWater','name'=>'自助回水','value'=>$roomConfig['selfWater'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //游戏赔率 showOdds
        $config['switch'][] = ['key'=>'showOdds','name'=>'游戏赔率','value'=>$roomConfig['showOdds'],'type'=>'switch','activeText'=>'显示','inactiveText'=>'关闭'];
        //会员流水 showTurnover
        $config['switch'][] = ['key'=>'showTurnover','name'=>'会员流水','value'=>$roomConfig['showTurnover'],'type'=>'switch','activeText'=>'显示','inactiveText'=>'关闭'];
        //预测功能 showPrediction
        $config['switch'][] = ['key'=>'showPrediction','name'=>'预测功能','value'=>$roomConfig['showPrediction'],'type'=>'switch','activeText'=>'显示','inactiveText'=>'关闭'];
        //禁止闲聊 banChat
        $config['switch'][] = ['key'=>'banChat','name'=>'禁止闲聊','value'=>$roomConfig['banChat'],'type'=>'switch','activeText'=>'禁止','inactiveText'=>'允许'];
        //网投键盘 webInputKeyboard
        $config['switch'][] = ['key'=>'webInputKeyboard','name'=>'网投键盘','value'=>$roomConfig['webInputKeyboard'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //下注成功回复消息 betSuccessResponse
        $config['switch'][] = ['key'=>'betSuccessResponse','name'=>'下注成功回复消息','value'=>$roomConfig['betSuccessResponse'],'type'=>'switch','activeText'=>'回复','inactiveText'=>'关闭'];
        //只发下注用户积分 betUserCreditOnly
        $config['switch'][] = ['key'=>'betUserCreditOnly','name'=>'只发下注用户积分','value'=>$roomConfig['betUserCreditOnly'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //订单内容简化显示 orderSummaryDisplay
        $config['switch'][] = ['key'=>'orderSummaryDisplay','name'=>'订单内容简化显示','value'=>$roomConfig['orderSummaryDisplay'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //回复非订单指令消息 nonOrderCommandResponse
        $config['switch'][] = ['key'=>'nonOrderCommandResponse','name'=>'回复非订单指令消息','value'=>$roomConfig['nonOrderCommandResponse'],'type'=>'switch','activeText'=>'回复','inactiveText'=>'关闭'];
        //发送当期开奖图 currentDrawImage
        $config['switch'][] = ['key'=>'currentDrawImage','name'=>'发送当期开奖图','value'=>$roomConfig['currentDrawImage'],'type'=>'switch','activeText'=>'发送','inactiveText'=>'关闭'];
        //发送近期开奖图 latestDrawImage
        $config['switch'][] = ['key'=>'latestDrawImage','name'=>'发送近期开奖图','value'=>$roomConfig['latestDrawImage'],'type'=>'switch','activeText'=>'发送','inactiveText'=>'关闭'];
        //允许重复上下分 allowRepeatCreditChanges
        $config['switch'][] = ['key'=>'allowRepeatCreditChanges','name'=>'允许重复上下分','value'=>$roomConfig['allowRepeatCreditChanges'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //代理报表下线流水详情 agentSubTurnoverDetails
        //$config['switch'][] = ['key'=>'agentSubTurnoverDetails','name'=>'代理报表下线流水详情','value'=>$roomConfig['agentSubTurnoverDetails'],'type'=>'switch','activeText'=>'显示','inactiveText'=>'关闭'];
        //返水按总流水统计 waterStatByTotalTurnover
        //$config['switch'][] = ['key'=>'waterStatByTotalTurnover','name'=>'返水按总流水统计','value'=>$roomConfig['waterStatByTotalTurnover'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        $config['switch'][] = ['key'=>'notopen_bet','name'=>'上期未开奖禁止下注','value'=>$roomConfig['notopen_bet'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //显示在线人数 show_online_count
        $config['switch'][] = ['key'=>'show_online_count','name'=>'会员端显示在线人数','value'=>$roomConfig['show_online_count'],'type'=>'switch','activeText'=>'开启','inactiveText'=>'关闭'];
        //账号信息
        $username = $request->userInfo['username'];
        $account = [];
        $account['username'] = $username;//当前账号
        $account['expiryDate'] = date('Y-m-d H:i:s', $roomConfig['expiryDate']);//账号过期时间
        $account['roomid'] = $roomConfig['roomid'];//房间号

        return AppJson::success('ok',['configInfo'=>$config,'account'=>$account]);
    }

    public function saveConfig(Request $request){
        $key = $request->input('key','');
        $value = $request->input('value','');
        if(empty($key)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        //执行更新操作
        $res = Userroom::where('userid',$ruid)->update([$key=>$value]);
        if($res){
            return AppJson::success('设置成功');
        }else{
            return AppJson::error('设置失败');
        }
    }

    public function refreshRoomId(Request $request){
        $password = $request->input('password','');
        if(empty($password)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;$uid = $request->uid;
        $pass = md5($password.x_config('upass'));
        $mypass = Userreg::where(['userid'=>$ruid])->value('userpass');
        if($pass!= $mypass){
            return AppJson::error('密码错误');
        }
        $roomid = '';
        for($i = 1;$i < 10;$i++){
            $tmroomid = rand(199999,999999);
            //判断房间id是否存在
            $rc = Userroom::where('roomid',$tmroomid)->count('id');
            if($rc <= 0){
                $roomid = $tmroomid;
                break;
            }
        }
        if(empty($roomid)){
            return AppJson::error('房间号刷新失败，请重试');
        }
        $old = Userroom::where('userid',$ruid)->value('roomid');
        //更新房间号
        $res = Userroom::where('userid',$ruid)->update(['roomid'=>$roomid]);
        if($res){
            //删除历史房间记录
            Roomhistory::where(['ruid'=>$ruid])->delete();
            ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$uid,'action'=>"房间号刷新",'old'=>$old,'new'=>$roomid,'moduleKey'=>'platform','functionKey'=>'room','actionKey'=>'updateno']);
            return AppJson::success('房间号刷新成功',['roomid'=>$roomid]);
        }else{
            return AppJson::error('房间号刷新失败，请重试');
        }
    }


    public function getGameSettingList(Request $request){
        $ruid = $request->ruid;
        $model = SGUtils::ruidGameModelByRoom($ruid);
        $model = $model->select(['userpatt.gid','ifok','gname','fpseconds','userpatt.xsort','isCancelOrder','autoStartTime','autoEndTime'])->orderBy('userpatt.xsort');
        $data = $model->get()->toArray();
        foreach ($data as &$item) {
            if($item['autoStartTime'] > 0){
                //将时间数字转成时间格式，例如600转成06:00,1200转成12:00
                $timearr = str_split($item['autoStartTime'].'');
                if(count($timearr) == 4){
                    $str = $timearr[0].$timearr[1].':'.$timearr[2].$timearr[3];
                }else{
                    $str = '0'.$timearr[0].':'.$timearr[1].$timearr[2];
                }
                $item['autoStartTime'] = $str;
            }
            if($item['autoEndTime'] > 0){
                //将时间数字转成时间格式，例如600转成06:00,1200转成12:00
                $timearr = str_split($item['autoEndTime'].'');
                if(count($timearr) == 4){
                    $str = $timearr[0].$timearr[1].':'.$timearr[2].$timearr[3];
                }else{
                    $str = '0'.$timearr[0].':'.$timearr[1].$timearr[2];
                }
                $item['autoEndTime'] = $str;
            }
        }
        return AppJson::success('ok',['gameList'=>$data]);
    }

    public function switchGame(Request $request){
        $type = $request->input('type',1);//1 单独某个游戏 2 一键关闭 3 一键开启
        $gid = $request->input('gid',0);
        $status = $request->input('status',0);
        $ruid = $request->ruid;$uid = $request->uid;
        if($type == 1){
            if(empty($gid)){
                return AppJson::error('参数错误');
            }
            $ifok = Userpatt::where(['userid'=>$ruid,'gid'=>$gid])->value('ifok');
            $res = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->update(['ifok'=>$status]);
        }elseif ($type == 2){
            $res = Userpatt::where(['userid'=>$ruid,'ifopen'=>1])->update(['ifok'=>0]);
        }elseif ($type == 3){
            $res = Userpatt::where(['userid'=>$ruid,'ifopen'=>1])->update(['ifok'=>1]);
        }
        if($type == 1 && $res){
            $gname = Game::where('gid',$gid)->value('gname');
            $old = $ifok == 1 ? '开启' : '关闭';
            $new = $status == 1 ? '开启' : '关闭';
            ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$uid,'action'=>"【{$gname}】游戏开关设置",'old'=>$old,'new'=>$new,'moduleKey'=>'platform','functionKey'=>'game','actionKey'=>'update']);
        }elseif (($type == 2 || $type == 3) && $res){
            $new = $type == 2 ? '一键关闭' : '一键开启';
            ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$uid,'action'=>"游戏开关一键设置",'old'=>'-','new'=>$new,'moduleKey'=>'platform','functionKey'=>'game','actionKey'=>'update']);
        }
        return AppJson::success('设置成功');
    }

    public function saveGameSetting(Request $request){
        $gameList = $request->input('gameList',[]);
        $ruid = $request->ruid;
        $updatecount = 0;
        foreach ($gameList as $item) {
            $gid = $item['gid'];
            $xsort = $item['xsort'];
            $fpseconds = $item['fpseconds'];
            $autoStartTime = $item['autoStartTime'];
            $autoEndTime = $item['autoEndTime'];
            $isCancelOrder = $item['isCancelOrder'];
            //处理时间，前端接收的格式是07:00，数据库存储的是700
            if(!empty($autoStartTime)){
                $autoStartTime = str_replace(':', '', $autoStartTime);
            }else{
                $autoStartTime = 0;
            }
            if(!empty($autoEndTime)){
                $autoEndTime = str_replace(':', '', $autoEndTime);
            }else{
                $autoEndTime = 0;
            }
            $res = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->update(['xsort'=>$xsort,'fpseconds'=>$fpseconds,'autoStartTime'=>$autoStartTime,'autoEndTime'=>$autoEndTime,'isCancelOrder'=>$isCancelOrder]);
            if($res){
                $updatecount++;
            }
        }
        return AppJson::success('保存成功，共更新'.$updatecount.'个游戏');
    }

    /**
     * 获取游戏消息列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGameMsgList(Request $request){
        $gid = $request->input('gid','');
        $ruid = $request->ruid;
        if(empty($gid)){
            return AppJson::error('参数错误');
        }
        $msgList = Gamemsg::where(['ruid'=>$ruid,'gid'=>$gid])->select(['keyname','msg_name','msg_content','msg_time','remark','is_time','ifok'])->get();
        return AppJson::success('ok',['list'=>$msgList]);
    }

    /**
     * 保存游戏消息列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveGameMsg(Request $request){
        $gid = $request->input('gid','');
        $msgList = $request->input('msgList',[]);
        if(empty($gid) || empty($msgList)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;$updaeCount = 0;
        foreach ($msgList as $item) {
            $update = [];
            $update['msg_name'] = $item['msg_name'];
            $update['msg_content'] = $item['msg_content'];
            $update['msg_time'] = $item['msg_time'];
            $update['ifok'] = $item['ifok'];
            $res = Gamemsg::where(['ruid'=>$ruid,'gid'=>$gid,'keyname'=>$item['keyname']])->update($update);
            if($res){
                //Log::info("keyname=".$item['keyname']);
                $updaeCount++;
            }
        }
        return AppJson::success('保存成功，共更新'.$updaeCount.'条消息');
    }

    /**
     * 同步所有游戏消息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function synAllGameMsg(Request $request){
        $gid = $request->input('gid','');
        $ruid = $request->ruid;
        if(empty($gid)){
            return AppJson::error('参数错误');
        }
        $gameMsgList = Gamemsg::where(['ruid'=>$ruid,'gid'=>$gid])->select(['keyname','msg_content','msg_time','is_time'])->get();
        foreach ($gameMsgList as $item) {
            $update = [];
            $update['msg_content'] = $item['msg_content'];
            $item['is_time'] == 1 && $update['msg_time'] = $item['msg_time'];
            Gamemsg::where(['ruid'=>$ruid,'keyname'=>$item['keyname']])->where('gid','<>',$gid)->update($update);
        }
        return AppJson::success('同步成功');
    }

    /**
     * 重置游戏消息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetGameMsg(Request $request){
        $gid = $request->input('gid','');
        $ruid = $request->ruid;
        if(empty($gid)){
            return AppJson::error('参数错误');
        }
        $gameMsgList = Gamemsg::where(['ruid'=>Constants::$SUID,'gid'=>$gid])->select(['keyname','msg_content','msg_time','is_time'])->get();
        foreach ($gameMsgList as $item) {
            $update = [];
            $update['msg_content'] = $item['msg_content'];
            $item['is_time'] == 1 && $update['msg_time'] = $item['msg_time'];
            Gamemsg::where(['ruid'=>$ruid,'keyname'=>$item['keyname'],'gid'=>$gid])->update($update);
        }
        //日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"重置游戏消息",'moduleKey'=>'platform','functionKey'=>'game','actionKey'=>'resetmsg']);
        return AppJson::success('重置成功');
    }
}
