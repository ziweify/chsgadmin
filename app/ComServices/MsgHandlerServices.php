<?php

namespace App\ComServices;

use App\Models\Game\Apply;
use App\Models\Game\Game;
use App\Models\Game\Gamemsg;
use App\Models\Game\Kj;
use App\Models\Game\MoneyLog;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\services\CommonCache;
use App\ort\sgwin\SGUtils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class MsgHandlerServices
{

    public function gamechat($server,$frame,$data){
        $gid = isset($data['gid']) ? $data['gid'] : 0;
        if(empty($gid)){
            return false;
        }
        $msgid = isset($data['msgid']) ? $data['msgid'] : '';
        $uid = $data['uid'];$ruid = $data['ruid'];$eventType = $data['eventType'];$ip = $data['ip'];
        $user = User::where(['userid'=>$uid,'ruid'=>$ruid])->select(['yingdeny', 'sy', 'kmoney','room_status','fid','robot','jetotal','ignore_outbet'])->first();
        $userreg = Userreg::where(['userid'=>$uid])->select(['avatar','name','ipcustom','type'])->first();
        $roomConfig = Userroom::where(['userid'=>$ruid])->select(['betSuccessResponse','roomNickname','roomAvatar','orderSummaryDisplay','allowRepeatCreditChanges','webInputKeyboard','notopen_bet'])->first();
        if(!empty($userreg['ipcustom'])){
            $ip = $userreg['ipcustom'];
        }
        //消息存储
        $chatListKey = WebsocketConstants::$chatListKeyPre.':'.$ruid.':'.$gid;
        $chatData = [
            'type' => 'game',
            'chatType' => 'text',
            'content' => $data['content'],
            'sender' => $uid,
            'nickname'=> $userreg['type'] == 0 ? $userreg['name'] : $roomConfig['roomNickname'],
            'avatar'=>$userreg['type'] == 0 ? $userreg['avatar'] : $roomConfig['roomAvatar'],
            'time'=>time(),
        ];

        //是否已被禁言
        if($user['room_status'] == 2){
            return false;
            /*$chatData['content'] = "您已被禁言,请联系房主解除禁言！";
            return ComServices::sendMsg($server,$frame->fd,$eventType,$chatData,$gid,['msgid'=>$msgid]);*/
        }

        ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);

        $userpatt = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1,'ifok'=>1])->select(['patt', 'fpseconds','thisqishu','upqishu'])->first();
        //向所有在线用户发送消息
        $fds = ComServices::getRoomAllFd($ruid);
        // 如果是普通聊天消息，使用send事件类型返回以确保前端正确接收响应
        $responseEventType = ($eventType === 'gamechat') ? 'send' : $eventType;
        ComServices::sendMsg($server,$fds,$responseEventType,$chatData,$gid,['msgid'=>$msgid]);
        if($userreg['type'] == 1){//如果是房主不处理下面任何操作
            return true;
        }
        $chatData = [
            'type' => 'game',
            'chatType' => 'text',
            'sender' => $ruid,
            'nickname'=>$roomConfig['roomNickname'],
            'avatar'=>$roomConfig['roomAvatar'],
            'isA'=>$userreg['name'],
            'time'=>time(),
        ];

        //上下分申请
        if (preg_match('/^(上分|上|下分|下)(\d+)$/u', $data['content'], $matches)) {
            $m1 = $matches[1];$money = $matches[2];
            if(empty($money) || $money <= 0){
                if($roomConfig['webInputKeyboard'] == 0){
                    return false;
                }
                $chatData['content'] = "解析失败，请注意格式是否正确！";
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
            }
            $applyType = ($m1 == '上分' || $m1 == '上') ? 2 : 3;
            //Log::info('上下分申请：'.$m1.'-'.$money.'-'.$applyType);
            $applyTypestr = $applyType == 2 ? "上分" : "下分";
            if($roomConfig['allowRepeatCreditChanges'] == 0){//不允许重复上下分
                $applycount = Apply::where(['ruid'=>$ruid,'userid'=>$uid,'applyType'=>$applyType,'status'=>1])->count('id');
                if($applycount > 0){
                    $chatData['content'] = "请等待前一笔处理完成再提交新的上下分订单，谢谢";
                    ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                    return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
                }
            }
            //检测下分余额是否足够
            if($applyType == 3){
                if($user['kmoney'] < $money){
                    $chatData['content'] = "下分余额不足,请核对账户余额！";
                    ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                    return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
                }
            }
            Apply::create([
                'userid' => $uid,
                'ruid' => $ruid,
                'applyType' => $applyType,
                'toupType'  => 1,//群内上下分
                'accountType' => 1,
                'value' => $money,
                'applicationTime' => time(),
                'status' => 1,
                'relationid'=>$gid
            ]);
            $chatData['content'] = " 已收到[{$applyTypestr} {$money}]申请,请稍等!";
            ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
            //缓存消息通知标记
            $key = WebsocketConstants::$NotReadApplyAgentPre.":".$ruid;
            if(!Redis::exists($key)){
                Redis::set($key,1);
            }
            $other = ['isApplayMsg'=>1,'applyType'=>$applyType,'money'=>$money];
            $other['nickname'] = $userreg['name'];
            $other['avatar'] = $userreg['avatar'];
            $other['mtype'] = 2;
            return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid,$other);
        }
        $game = Game::where('gid', $gid)->select(['ifopen', 'fenlei', 'gname', 'pan', 'patt','userclosetime'])->first();
        if($data['content'] == '查' || $data['content'] == '查询'){
            $db = Db::connection();
            $tb_lib = SGUtils::getcuretable(true);
            $dates = strtotime(ComFunc::getthisdateend());
            /* $sql = "select sid,pid,sum(je) as je from `{$tb_lib}` where gid='{$gid}' and qishu='{$userpatt['thisqishu']}' and ruid='{$ruid}' and userid={$uid} and z<>7 group by pid order by pid asc";
            $libs = $db->select($sql);
            $tmp = [];$utmp = [];$zje = 0;
            foreach ($libs as $lib) {
                if (!isset($tmp[$lib['sid']])) {
                    $tmp[$lib['sid']] = CommonCache::getsclasscache($gid,$lib['sid'])['name'];
                }
                if (!isset($tmp[$lib['pid']])) {
                    $tmp[$lib['pid']] = CommonCache::getplaycache($gid,$lib['pid'])['name'];
                }
                $sname = $tmp[$lib['sid']];
                $pname = $tmp[$lib['pid']];
                $pl = ['play'=>$pname,'amount'=>$lib['je']];
                if(!isset($utmp[$sname])) {
                    $utmp[$sname] = [];
                    $utmp[$sname][] = $pl;
                }else{
                    $utmp[$sname][] = $pl;
                }
                $zje += $lib['je'];
            }
            $zje = ComFunc::pr2($zje,1);
            $msgh = "[{$game['gname']}-{$userpatt['thisqishu']}]";
            foreach ($utmp as $pn=>$cons){
                $msgh .= "<br>\n".$pn."[";
                foreach ($cons as $c){
                    if($c != end($cons)){
                        $msgh .= $c['play'].'/'.$c['amount'].' ';
                    }else{
                        $msgh .= $c['play'].'/'.$c['amount'];
                    }
                }
                $msgh .= "]";
            } */
            //$user['kmoney'] = ComFunc::pr2($user['kmoney'],1);
            $rs1 = $db->select("select sum(je) as je from `{$tb_lib}` where gid='{$gid}' and qishu='{$userpatt['thisqishu']}' and ruid='{$ruid}' and userid={$uid} and z = 9");
            $wjsje = isset($rs1[0]['je']) ? $rs1[0]['je'] : 0;
            $jrsf = MoneyLog::where(['ruid'=>$ruid,'userid'=>$uid,'dates'=>$dates,'moneyType'=>3,'mtype'=>1])->sum('money');
            $jrxf = MoneyLog::where(['ruid'=>$ruid,'userid'=>$uid,'dates'=>$dates,'moneyType'=>4,'mtype'=>1])->sum('money');
            $sy = ComFunc::pr2($user['sy']);
            $msgh = "流水记录";
            $msgh .= "<br>\n今日/本轮进货:{$user['jetotal']}/{$wjsje}";
            $msgh .= "<br>\n今日上/下分:{$jrsf}/{$jrxf}";
            $msgh .= "<br>\n今日盈亏:{$sy}";
            $chatData['content'] = $msgh;
            ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
            return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
        }

        if($data['content'] == '取消' || $data['content'] == '取消全部' || $data['content'] == '全部取消'){
            //判断是否已封盘
            $time = time();$dates = ComFunc::getthisdateend();
            $kj = Kj::where(['gid' => $gid, 'qishu' => $userpatt['thisqishu'], 'dates' => strtotime($dates)])->select(['opentime', 'closetime'])->first();
            if ($time > ($kj['closetime']-$userpatt['fpseconds']-$game['userclosetime'])) {
                $chatData['content'] = "撤单失败, [{$game['gname']}-{$userpatt['thisqishu']}期] 已封盘,无法取消.";
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
            }
            if($game['userclosetime'] > 0 && $game['userclosetime'] < time()){
                $chatData['content'] = "撤单失败, [{$game['gname']} {$userpatt['thisqishu']}期] 已封盘,无法取消.";
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
            }
            //如果是取消，那么取消最后一次下注的订单
            $tsql = "";
            if($data['content'] == '取消'){
                $orderNos = Redis::get("last:order:nos:".$uid.":".$gid.":".$userpatt['thisqishu']);
                if(!empty($orderNos)){
                    $tarr = explode(',',$orderNos);
                    $orderNos = "'".implode("','",$tarr)."'";
                    $tsql = " and code in ({$orderNos})";
                }
            }
            $db = Db::connection();
            $tb_lib = SGUtils::getcuretable(true);
            $sql = "select count(id) as c,sum(je) as je from `{$tb_lib}` where gid='{$gid}' and qishu='{$userpatt['thisqishu']}' and ruid='{$ruid}' and userid={$uid} and z = 9 {$tsql}";
            $lib = $db->select($sql);
            $orderCount = isset($lib[0]['c']) ? $lib[0]['c'] : 0;
            $je = isset($lib[0]['je']) ? $lib[0]['je'] : 0;
            if($orderCount <= 0){
                $chatData['content'] = "撤单失败, [{$game['gname']} {$userpatt['thisqishu']}期] 无订单,无法取消.";
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
            }
            $logArr = ['moneyType'=>7,'gid'=>$gid,'qishu'=>$userpatt['thisqishu']];
            $rec = UserService::operBalance($uid,$ruid,$je,1,1,$logArr);
            if($rec['code'] == 0){
                $chatData['content'] = "撤单失败, [{$game['gname']} {$userpatt['thisqishu']}期] 系统异常,无法取消.";
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
            }
            $db->update("update `{$tb_lib}` set z=7 where gid='{$gid}' and qishu='{$userpatt['thisqishu']}' and ruid='{$ruid}' and userid={$uid} and z=9 {$tsql}");
            $msgh = "撤单成功, [{$game['gname']} {$userpatt['thisqishu']}期]";
            $msgh .= "<br>\n撤单积分:".$je;
            $msgh .= "<br>\n剩余积分:".ComFunc::pr2($rec['balance']);
            $chatData['content'] = $msgh;
            ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
            //删除缓存
            Redis::del("last:order:nos:".$uid.":".$gid.":".$userpatt['thisqishu']);
            return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
        }

        //玩法下注解析
        if($game['fenlei'] == 107) {
            $result = (new CmdPk())->commandBetting($data['content'], $user['kmoney'], false);
        }elseif ($game['fenlei'] == 444){
            $result = (new CmdBingo())->commandBetting($data['content'], $user['kmoney'], false);
        }
        if(empty($result['data'])){
            if($roomConfig['webInputKeyboard'] == 0){
                return false;
            }
            $chatData['content'] = "解析失败，请注意格式是否正确！";
            ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
            return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
        }
        if($roomConfig['notopen_bet'] == 1){
            $upqishu = $userpatt['thisqishu'] - 1;
            $kjcount = Kj::where(['gid'=>$gid,'qishu'=>$upqishu,'status'=>0])->count('id');
            if($kjcount >= 1){
                $chatData['content'] = "上期未开奖，请等待开奖后再下注！";
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
            }
        }
        $betres = (new GameServices())->bet($result['data'],$game,$user,$userpatt,$gid,$uid,$ruid,$ip);
        if($betres['code'] == 0){
            $chatData['content'] = $betres['msg'];
            ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
            return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
        }else{
            if($roomConfig['betSuccessResponse'] == 0){
                return false;
            }
            $map = $betres['map'];
            $chatData['mtype'] = 1;
            $msg_content = Gamemsg::where(['ruid'=>$ruid,'gid'=>$gid,'keyname'=>'SubmitAfterBetting','ifok'=>1])->value('msg_content');
            if(!empty($msg_content)){
                $msg_content = ComServices::textHandler($msg_content);
                $msg_content = str_replace("{游戏}",$game['gname'],$msg_content);
                $msg_content = str_replace("{期号}",$userpatt['thisqishu'],$msg_content);
                $msg_content = str_replace("{金额}",$betres['zje'],$msg_content);
                $msg_content = str_replace("{余额}",$betres['balance'],$msg_content);
                //$msgh = $msg_content;
                if($roomConfig['orderSummaryDisplay'] == 0){//订单内容不简化
                    $msgh = '';//"<p>【{$game['gname']}-{$userpatt['thisqishu']}】下单成功</p>";
                    foreach ($map as $pn=>$cons){
                        $msgh .= "<p>".$pn."[";
                        foreach ($cons as $c){
                            if($c != end($cons)){
                                $msgh .= $c['play'].'/'.$c['amount'].' ';
                            }else{
                                $msgh .= $c['play'].'/'.$c['amount'];
                            }
                        }
                        $msgh .= "]</p>";
                    }
                    //$msgh .= "<br>\n";
                    //$msgh .= "<p>使用:{$betres['zje']}</p>";
                    //$msgh .= "<p>剩余:{$betres['balance']}</p>";
                    $msg_content = str_replace("{账单}",$msgh,$msg_content);
                    $msg_content = str_replace('<br><br>','<br>',$msg_content);
                    //</p><br>替换为</p>
                    $msg_content = str_replace('</p><br>','</p>',$msg_content);
                    $msgh = [["otype"=>'normal',"ctype"=>'html',"con"=>$msg_content]];
                }else{//订单简化显示
                    $orderlist = [];
                    foreach ($map as $pn=>$cons){
                        foreach ($cons as $c){
                            $orderlist[] = ['b'=>$pn,'p'=>$c['play'],'a'=>$c['amount']];
                        }
                    }
                    //$tmpstr = "<p>【{$game['gname']}-{$userpatt['thisqishu']}】下单成功</p>";
                    //$tmpstr .= "<p>使用:{$betres['zje']}</p>";
                    //$tmpstr .= "<p>剩余:{$betres['balance']}</p>";
                    $msg_content = str_replace("{账单}",'',$msg_content);
                    //如果存在两个br则改成一个
                    $msg_content = str_replace('<br><br>','<br>',$msg_content);
                    $msgh = [];
                    $msgh[] = ["otype"=>'order',"ctype"=>'html','con'=>$msg_content,'uid'=>$uid];
                    $chatData['other'] = [$uid=>$orderlist];
                }
                $chatData['content'] = $msgh;
                ComServices::saveMsg($chatListKey,$chatData,$ruid,$gid);
                return ComServices::sendMsg($server,$fds,$eventType,$chatData,$gid);
            }
        }
    }

    //在线客服聊天
    public function customchat($server,$frame,$data){
        $msgid = isset($data['msgid']) ? $data['msgid'] : '';
        $chatType = isset($data['chatType']) ? $data['chatType'] : 'text';
        $ruid = $data['ruid'];$uid = $data['uid'];$fd = $frame->fd;
        $userreg = Userreg::where(['userid'=>$uid])->select(['avatar','name','ipcustom','type'])->first();
        $sender = $uid;
        $roomConfig = Userroom::where(['userid'=>$ruid])->select(['roomNickname','roomAvatar'])->first();
        $fds = [];$fds[] = $fd;$msgGroupId = $uid;
        if($userreg['type'] == 1){//群主发送消息
            $sender = $ruid;
            $senderNick = $roomConfig['roomNickname'];
            $senderAvatar = $roomConfig['roomAvatar'];
            if(!isset($data['receiver'])){
                return;
            }
            $msgGroupId = $data['receiver'];
            $receiverUser = User::where(['ruid'=>$ruid,'userid'=>$data['receiver']])->select(['username'])->first();
            if(empty($receiverUser)){
                return;
            }
            $receiver = $data['receiver'];
            $fds[] = ComServices::getFdByUid($ruid,$receiver);
            $chatListKey = WebsocketConstants::$CustomerChatListKeyPre.':'.$ruid.':'.$receiver;
            //缓存消息通知标记
            $key = WebsocketConstants::$NotReadMsgMemberPre.":".$ruid.':'.$data['receiver'];
            Redis::set($key,1);
            //更新最近聊天标识
            User::where(['ruid'=>$ruid,'userid'=>$receiver,'recentChat'=>0])->update(['recentChat'=>1]);
            $noReadCount = 1;
        }else{//会员发送消息给群主
            $senderUerreg = Userreg::where(['userid'=>$uid])->select(['avatar','name'])->first();
            $senderNick = $senderUerreg['name'];
            $senderAvatar = $senderUerreg['avatar'];
            $chatListKey = WebsocketConstants::$CustomerChatListKeyPre.':'.$ruid.':'.$uid;
            //缓存消息通知标记
            $key = WebsocketConstants::$NotReadMsgAgentPre.":".$ruid;
            if(!Redis::hexists($key,$uid)){
                Redis::hset($key,$uid,1);
                $noReadCount = 1;
            }else{//累加
                $noReadCount = Redis::hincrby($key,$uid,1);
            }
            //更新最近聊天标识
            User::where(['ruid'=>$ruid,'userid'=>$uid,'recentChat'=>0])->update(['recentChat'=>1]);
        }

        //消息存储
        $chatData = [
            'type' => 'customer',
            'chatType' => $chatType,
            'content' => $data['content'],
            'sender' => $sender,
            'nickname'=>$senderNick,
            'avatar'=>$senderAvatar,
            'msgGroupId' => $msgGroupId,
            'time'=>time(),
        ];
        ComServices::saveMsg($chatListKey,$chatData,$ruid,0);
        $ulist = Userreg::where(['ruid'=>$ruid,'type'=>1,'ifson'=>1])->select(['userid'])->get()->toArray();
        $ulist[] = ['userid'=>$ruid];
        foreach ($ulist as $u){
            $hfd = ComServices::getFdByUid($ruid,$u['userid']);
            if(!empty($hfd)){
                $fds[] = $hfd;
            }
        }
        ComServices::sendMsg($server,$fds,$data['eventType'],$chatData,0,['msgid'=>$msgid,'noReadCount'=>$noReadCount]);
    }

    public function resetNotReadMsg(Server $server,Frame $frame,$data){
        $ruid = $data['ruid'];$uid = $data['uid'];$type = $data['type'];
        $receiver = isset($data['receiver']) ? $data['receiver'] : 0;
        if($type == 1){
            //清理未读消息
            if(!empty($receiver)){
                $key = WebsocketConstants::$NotReadMsgAgentPre.":".$ruid;
                Redis::hdel($key,$receiver);
            }
        }else{
            //清理未读消息
            $key = WebsocketConstants::$NotReadMsgMemberPre.":".$ruid.':'.$uid;
            Redis::del($key);
        }
    }

    public function periodListOrSingle(Server $server,Frame $frame,$data){
        $ruid = $data['ruid'];$uid = $data['uid'];$fd = $frame->fd;
        $gid = isset($data['gid']) ? $data['gid'] : null;
        /*$type = User::where(['userid'=>$uid,'ruid'=>$ruid])->value('type');
        $type = $type == 2 ? 2 : 1;*/
        $result = (new GameServices())->periodlistorsingle($ruid,$gid,1);
        ComServices::sendMsg($server,$fd,$data['eventType'],$result,$gid);
    }

    public function chatList(Server $server,Frame $frame,$data){
        $gid = isset($data['gid']) ? $data['gid'] : 0;
        if(empty($gid)){
            return;
        }
        $ruid = $data['ruid'];$fd = $frame->fd;
        $chatListKey = WebsocketConstants::$chatListKeyPre.':'.$ruid.':'.$gid;
        $chatList = Redis::lrange($chatListKey, -30, -1);
        if(!empty($chatList)){
            $newchatlist = [];
            foreach ($chatList as $chat){
                $newchatlist[] = json_decode($chat,true);
            }
            ComServices::sendMsg($server,$fd,$data['eventType'],$newchatlist,$gid);
        }
    }

    //获取某个彩种当前开奖结果
    public function openResult(Server $server,Frame $frame,$data){
        $gid = isset($data['gid']) ? $data['gid'] : 0;
        if(empty($gid)){
            return;
        }
        $fd = $frame->fd;
        $result = (new GameServices())->openResult($gid);
        ComServices::sendMsg($server,$fd,$data['eventType'],$result,$gid);
    }

    //获取用户余额
    public function getBalanceInfo(Server $server,Frame $frame,$data){
        $ruid = $data['ruid'];$uid = $data['uid'];$fd = $frame->fd;
        $result = UserService::getBalanceInfo($uid,$ruid);
        ComServices::sendMsg($server,$fd,$data['eventType'],$result,0);
    }
}