<?php

namespace App\Common\TaskSwoole;

use App\ComServices\ComServices;
use App\ComServices\WebsocketConstants;
use App\Models\Game\Game;
use App\Models\Game\Gamemsg;
use App\Models\Game\User;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\services\AutosService;
use App\ort\services\CommonCache;
use App\ort\sgwin\SGUtils;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommonQueue extends Task
{
    protected $param;

    public function __construct($param){
        $this->param = $param;
    }

    public function handle(){
        try {
            if($this->param['type'] == 'sendKjNotice'){//发送开奖通知
                $this->sendKjNotice($this->param);
            }elseif($this->param['type'] == 'secondsToCloseAnnouncement'){//距封盘N秒喊话
                $this->secondsToCloseAnnouncement($this->param);
            }elseif($this->param['type'] == 'closingMessage'){//封盘后的消息处理
                $this->closingMessage($this->param);
            }elseif($this->param['type'] == 'winnerListAfterSettlement'){//结算后获奖名单
                $this->winnerListAfterSettlement($this->param);
            }elseif($this->param['type'] == 'taskcommon'){//公共任务
                $this->taskcommo();
            }elseif($this->param['type'] == 'checkonline'){//在线检测
                $this->checkonline();
            }
        }catch (\Exception $e){
            Log::info("公共队列任务异常：".$e->getMessage().$e->getTraceAsString());
        }
    }

    public function sendKjNotice($param){
        //生成本期开奖图片-排名图片
        $gid = $param['gid'];
        $period = $param['period'];
        $roomConfig = $param['roomConfig'];
        $ruid = $roomConfig['userid'];
        $list = ComServices::getRoomAllFd($ruid);
        /* if(empty($list)){
            Log::info('没有任何fd:'.$ruid);
            return;
        } */
        $server = app('swoole');
        //批量保存消息
        $batchs = [];
        $chatData = ['type' => 'game','chatType' => 'text','time'=>time()];
        $chatListKey = WebsocketConstants::$chatListKeyPre.':'.$ruid.':'.$gid;
        $chatDatas = [];$dates = ComFunc::getthisdateend();$dstr = str_replace('-','',$dates);
        //先发送一段文字下一期已开始
        $chatData['sender'] = $roomConfig['userid'];
        $chatData['nickname'] = $roomConfig['roomNickname'];
        $chatData['avatar'] = $roomConfig['roomAvatar'];
        $chatData['content'] = "第 {$period} 期<br>----------线下开始----------";
        $chatData['ruid'] = $roomConfig['userid'];
        $chatData['gid'] = $gid;
        $chatDatas[] = $chatData;

        $chatData['chatType'] = 'image';
        if($roomConfig['currentDrawImage'] == 1 && $gid != 444){//当前排名开奖图
            $chatData['sender'] = $roomConfig['userid'];
            $chatData['nickname'] = $roomConfig['roomNickname'];
            $chatData['avatar'] = $roomConfig['roomAvatar'];
            $chatData['content'] = "/upload/openimg/$dstr/{$gid}/open_{$period}.webp";
            $chatData['ruid'] = $roomConfig['userid'];
            $chatData['gid'] = $gid;
            $chatDatas[] = $chatData;
        }
        if($roomConfig['latestDrawImage'] == 1) {//最近20期开奖图
            $chatData['sender'] = $roomConfig['userid'];
            $chatData['nickname'] = $roomConfig['roomNickname'];
            $chatData['avatar'] = $roomConfig['roomAvatar'];
            $chatData['content'] = "/upload/openimg/$dstr/$gid/openlist_{$period}.webp";
            $chatData['ruid'] = $roomConfig['userid'];
            $chatData['gid'] = $gid;
            $chatDatas[] = $chatData;
        }
        count($chatDatas) > 0 && $batchs[$chatListKey] = $chatDatas;
        ComServices::saveMsg(null,$batchs,null,null,1);
        $chatData = ['type' => 'game','time'=>time()];
        foreach ($list as $fd){
            $chatDatas = [];
            //下期开始文字提示
            $chatData['chatType'] = 'text';
            $chatData['sender'] = $ruid;
            $chatData['nickname'] = $roomConfig['roomNickname'];
            $chatData['avatar'] = $roomConfig['roomAvatar'];
            $chatData['content'] = "第 {$period} 期<br>----------线下开始----------";
            $chatDatas[] = $chatData;

            $chatData['chatType'] = 'image';
            if($roomConfig['currentDrawImage'] == 1 && $gid != 444){//当前排名开奖图
                $chatData['sender'] = $ruid;
                $chatData['nickname'] = $roomConfig['roomNickname'];
                $chatData['avatar'] = $roomConfig['roomAvatar'];
                $chatData['content'] = "/upload/openimg/$dstr/{$gid}/open_{$period}.webp";
                $chatDatas[] = $chatData;
            }
            if($roomConfig['latestDrawImage'] == 1){//最近20期开奖图
                $chatData['sender'] = $ruid;
                $chatData['nickname'] = $roomConfig['roomNickname'];
                $chatData['avatar'] = $roomConfig['roomAvatar'];
                $chatData['content'] = "/upload/openimg/$dstr/{$gid}/openlist_{$period}.webp";
                $chatDatas[] = $chatData;
            }
            if(count($chatDatas) > 0){
                if(count($chatDatas) > 1){
                    ComServices::sendMsg($server,$fd,'gamechat',$chatDatas,$gid,['openResult'=>1]);
                }else{
                    ComServices::sendMsg($server,$fd,'gamechat',$chatDatas[0],$gid,['openResult'=>1]);
                }
            }
        }
    }

    public function secondsToCloseAnnouncement($param){
        $gid = $param['gid'];
        $gname = $param['gname'];
        $qishu = $param['qishu'];
        $gameMsgArr = $param['gameMsgArr'];
        $chatData = ['type' => 'game','chatType' => 'text','time'=>time()];
        $batchs = [];$ruidmap = [];
        foreach ($gameMsgArr as $item){
            $chatListKey = WebsocketConstants::$chatListKeyPre.':'.$item['ruid'].':'.$gid;
            $msg_content = $item['msg_content'];
            $msg_content = ComServices::textHandler($msg_content);
            $msg_content = str_replace("{游戏}",$gname,$msg_content);
            $msg_content = str_replace("{期号}",$qishu,$msg_content);
            $msg_content = str_replace("{second}",$item['fptime'],$msg_content);

            unset($chatData['ruid'],$chatData['gid']);
            $chatData['sender'] = $item['ruid'];
            $chatData['nickname'] = $item['roomNickname'];
            $chatData['avatar'] = $item['roomAvatar'];
            $chatData['content'] = $msg_content;
            $ruidmap[$item['ruid']] = $chatData;
            $chatData['ruid'] = $item['ruid'];
            $chatData['gid'] = $gid;
            $batchs[$chatListKey] = [$chatData];
        }
        ComServices::saveMsg(null,$batchs,null,null,1);
        foreach ($ruidmap as $ruid=>$chatData){
            $fds = ComServices::getRoomAllFd($ruid);
            if(!empty($fds)){
                ComServices::sendMsg(null,$fds,'gamechat',$chatData,$gid);
            }
        }
    }

    public function closingMessage($param){
        $gid = $param['gid'];
        $gname = $param['gname'];
        $qishu = $param['qishu'];
        $gameMsgArr = $param['gameMsgArr'];
        $chatData = ['type' => 'game','chatType' => 'text','time'=>time()];
        $batchs = [];$ruidmap = [];
        $tb_lib = SGUtils::getcuretable(true);
        $db = Db::connection();$tmp = [];
        foreach ($gameMsgArr as $item){
            $chatListKey = WebsocketConstants::$chatListKeyPre.':'.$item['ruid'].':'.$gid;

            $chatDatas = [];

            //封盘线消息
            $msg_content = Gamemsg::where(['ruid'=>$item['ruid'],'gid'=>$gid,'keyname'=>'closingLineMessage','ifok'=>1])->value('msg_content');
            if(!empty($msg_content)){
                $msg_content = ComServices::textHandler($msg_content);
                $msg_content = str_replace("{游戏}",$gname,$msg_content);
                $msg_content = str_replace("{期号}",$qishu,$msg_content);
                unset($chatData['ruid'],$chatData['gid']);
                $chatData['sender'] = $item['ruid'];
                $chatData['nickname'] = $item['roomNickname'];
                $chatData['avatar'] = $item['roomAvatar'];
                $chatData['content'] = $msg_content;
                $ruidmap[$item['ruid']] = $chatData;
                $chatData['ruid'] = $item['ruid'];
                $chatData['gid'] = $gid;
                $chatData['mtype'] = 0;
                $chatDatas[] = $chatData;
            }

            //对账消息
            $sql = "select sid,pid,o.userid,u.name,sum(je) as je from `{$tb_lib}` as o inner join x_user as u on u.userid = o.userid where o.ruid='{$item['ruid']}' and gid='{$gid}' and qishu='{$qishu}' and z = 9 group by userid,pid order by pid asc";
            $libs = $db->select($sql);
            $utmp = [];
            foreach ($libs as $lib){
                if(!isset($tmp[$lib['sid']])){
                    $tmp[$lib['sid']] = CommonCache::getsclasscache($gid,$lib['sid'])['name'];
                }
                if(!isset($tmp[$lib['pid']])){
                    $tmp[$lib['pid']] = CommonCache::getplaycache($gid,$lib['pid'])['name'];
                }
                $sname = $tmp[$lib['sid']];
                $pname = $tmp[$lib['pid']];
                $pl = ['play'=>$pname,'amount'=>$lib['je']];
                if(!isset($utmp[$lib['userid']])){
                    $utmp[$lib['userid']]['name'] = $lib['name'];
                    $utmp[$lib['userid']]['zje'] = $lib['je'];
                    $utmp[$lib['userid']]['orders'] = [];
                }else{
                    $utmp[$lib['userid']]['zje'] += $lib['je'];
                }
                if(!isset($utmp[$lib['userid']]['orders'][$sname])) {
                    $utmp[$lib['userid']]['orders'][$sname] = [];
                    $utmp[$lib['userid']]['orders'][$sname][] = $pl;
                }else{
                    $utmp[$lib['userid']]['orders'][$sname][] = $pl;
                }
            }
            $msg_content = Gamemsg::where(['ruid'=>$item['ruid'],'gid'=>$gid,'keyname'=>'billVerificationMessageAfterClosing','ifok'=>1])->value('msg_content');
            if(!empty($msg_content)){
                $msg_content = ComServices::textHandler($msg_content);
                $msg_content = str_replace("{游戏}",$gname,$msg_content);
                $msg_content = str_replace("{期号}",$qishu,$msg_content);
                $chatData['mtype'] = 1;
                if($item['orderSummaryDisplay'] == 0){
                    $x = 0;count($utmp) > 0 ? $tmp_msg = "<empty><br>" : $tmp_msg = "";
                    foreach ($utmp as $u){
                        $tmp_msg .= "[".$u['name']."]&nbsp;使用:{$u['zje']}<br>";
                        foreach ($u['orders'] as $sname=>$cons){
                            $tmp_msg .= $sname."[";
                            foreach ($cons as $c){
                                if($c != end($cons)){
                                    $tmp_msg .= $c['play'].'/'.$c['amount'].'&nbsp;';
                                }else{
                                    $tmp_msg .= $c['play'].'/'.$c['amount'];
                                }
                            }
                            $tmp_msg .= "]<br>";
                        }
                        $x != count($utmp)-1 && $tmp_msg .= "<empty><br>";
                        $x++;
                    }
                    $msg_content = str_replace("{核对}",$tmp_msg,$msg_content);
                    $msg_content = ComServices::textToArr($msg_content);
                }else{//订单内容简化
                    $orderlist = [];
                    $marr = explode("{核对}",$msg_content);
                    $msgarr = [];
                    if(count($marr) > 1){
                        //$msgarr[] = ['otype'=>'normal','ctype'=>'text','con'=>$marr[0]];
                        $msgarr = array_merge($msgarr,ComServices::textToArr($marr[0],'normal','html',2));
                    }
                    foreach ($utmp as $uid=>$u) {
                        $orderlist[$uid] = [];
                        foreach ($u['orders'] as $sname=>$cons){
                            foreach ($cons as $c){
                                $orderlist[$uid][] = ['b'=>$sname,'p'=>$c['play'],'a'=>$c['amount']];
                            }
                        }
                        $tmp = ['otype'=>'orderlist','ctype'=>'html','con'=>'<p>'.$u['name']."&nbsp;使用:". $u['zje'].'&nbsp;&nbsp;</p>','uid'=>$uid];
                        array_push($msgarr,$tmp);
                    }
                    if(count($marr) > 1){
                        //$msgarr[] = ['otype'=>'normal','ctype'=>'text','con'=>$marr[1]];
                        $msgarr = array_merge($msgarr,ComServices::textToArr($marr[1]));
                    }
                    if(count($marr) <= 1){
                        //$msgarr[] = ['otype'=>'normal','ctype'=>'text','con'=>$marr[0]];
                        $msgarr = array_merge($msgarr,ComServices::textToArr($marr[0]));
                    }
                    $chatData['other'] = $orderlist;
                    $msg_content = $msgarr;
                }
                unset($chatData['ruid'],$chatData['gid']);
                $chatData['content'] = $msg_content;
                $ruidmap[$item['ruid']] = $chatData;
                $chatData['ruid'] = $item['ruid'];
                $chatData['gid'] = $gid;
                $chatDatas[] = $chatData;
            }

            $batchs[$chatListKey] = $chatDatas;
        }
        ComServices::saveMsg(null,$batchs,null,null,1);
        foreach ($ruidmap as $ruid=>$chatData){
            $fds = ComServices::getRoomAllFd($ruid);
            if(!empty($fds)){
                ComServices::sendMsg(null,$fds,'gamechat',$chatData,$gid);
            }
        }
    }

    public function winnerListAfterSettlement($param){
        $gid = $param['gid'];
        $gname = $param['gname'];
        $qishu = $param['qishu'];
        $roomConfig = $param['roomConfig'];
        $result = $param['result'];
        $ruid = $roomConfig['userid'];
        $isopenresult = $param['isopenresult'];
        $tb_lib = SGUtils::getcuretable(true);
        $db = Db::connection();$tmp = [];$utmp = [];
        //对账消息
        $sql = "select sid,pid,o.userid,u.name,sum(if(z=1,peilv1*je,0)) as zhong,sum(if(z in (0,1),je,0)) as je,sum(if(z=1,uzp*je,0)) as tax from `{$tb_lib}` as o inner join x_userreg as u on u.userid = o.userid where o.ruid = {$ruid} and gid='{$gid}' and qishu='{$qishu}' and z<>7 group by userid,pid order by pid,userid asc";
        $libs = $db->select($sql);
        foreach ($libs as $lib){
            $zhong = $lib['zhong'] ?: 0;
            $je = $lib['je'] ?: 0;
            $tax = $lib['tax'] ?: 0;

            $yk = $zhong-$je-$tax;

            if(!isset($tmp[$lib['sid']])){
                $tmp[$lib['sid']] = CommonCache::getsclasscache($gid,$lib['sid'])['name'];
            }
            if(!isset($tmp[$lib['pid']])){
                $tmp[$lib['pid']] = CommonCache::getplaycache($gid,$lib['pid'])['name'];
            }
            $sname = $tmp[$lib['sid']];
            $pname = $tmp[$lib['pid']];
            $mkey = $lib['userid'];
            $pl = ['play'=>$pname,'je'=>$lib['je'],'yk'=>$yk];
            if(!isset($utmp[$mkey])){
                $utmp[$mkey]['name'] = $lib['name'];
                $utmp[$mkey]['zje'] = $lib['je'];
                $utmp[$mkey]['zyk'] = $yk;
                $utmp[$mkey]['orders'] = [];
            }else{
                $utmp[$mkey]['zje'] += $lib['je'];
                $utmp[$mkey]['zyk'] += $yk;
            }
            if(!isset($utmp[$mkey]['orders'][$sname])) {
                $utmp[$mkey]['orders'][$sname] = [];
                $utmp[$mkey]['orders'][$sname][] = $pl;
            }else{
                $utmp[$mkey]['orders'][$sname][] = $pl;
            }
        }
        $chatData = ['type' => 'game','chatType' => 'text','time'=>time()];
        $batchs = [];$chatDatas = [];
        $chatListKey = WebsocketConstants::$chatListKeyPre.':'.$ruid.':'.$gid;
        $msg_content = Gamemsg::where(['ruid'=>$ruid,'gid'=>$gid,'keyname'=>'winnerListAfterSettlement','ifok'=>1])->value('msg_content');
        if(!empty($msg_content)){
            $msg_content = ComServices::textHandler($msg_content);
            $msg_content = str_replace("{游戏}",$gname,$msg_content);
            $msg_content = str_replace("{期号}",$qishu,$msg_content);
            //消息
            $chatData['sender'] = $ruid;
            $chatData['nickname'] = $roomConfig['roomNickname'];
            $chatData['avatar'] = $roomConfig['roomAvatar'];
            $chatData['ruid'] = $ruid;
            $chatData['gid'] = $gid;
            if($roomConfig['orderSummaryDisplay'] == 0){
                $x = 0;count($utmp) > 0 ? $tmp_msg = "<empty><br>" : $tmp_msg = '';
                foreach ($utmp as $uid=>$u){
                    $u['zyk'] = ComFunc::pr2($u['zyk']);
                    $ykcolor = $u['zyk'] > 0 ? '#00d123' : ($u['zyk'] < 0 ? '#fe0101' : '');
                    $tmp_msg .= "[{$u['name']}]&nbsp;得分:<span style='color:{$ykcolor}'>{$u['zyk']}</span><br>";
                    foreach ($u['orders'] as $sname=>$cons){
                        $tmp_msg .= $sname."[";
                        foreach ($cons as $c){
                            $yk = ComFunc::pr2($c['yk']);
                            $yk = $yk > 0 ? "<span style='color:#00d123'>{$yk}</span>" : ($yk < 0 ? "<span style='color:#fe0101'>{$yk}</span>" : "<span>{$yk}</span>");
                            if($c != end($cons)){
                                $tmp_msg .= $c['play'].'/'.(ComFunc::pr2($c['je'])).'/'.$yk.'&nbsp;';
                            }else{
                                $tmp_msg .= $c['play'].'/'.ComFunc::pr2($c['je']).'/'.$yk;
                            }
                        }
                        $tmp_msg .= "]<br>";
                    }
                    $x != count($utmp)-1 && $tmp_msg .= "<empty><br>";
                    $x++;
                }
                $msg_tent = str_replace("{结算}",$tmp_msg,$msg_content);
                $msg_content = ComServices::textToArr($msg_tent);
                $chatData['mtype'] = 1;
            }else{//订单内容简化
                $orderlist = [];
                $marr = explode("{结算}",$msg_content);
                $msgarr = [];
                if(count($marr) > 1){
                    //$msgarr[] = ['otype'=>'normal','ctype'=>'text','con'=>$marr[0]];
                    $msgarr = array_merge($msgarr,ComServices::textToArr($marr[0],'normal','html',2));
                }
                foreach ($utmp as $uid=>$u){
                    $u['zyk'] = ComFunc::pr2($u['zyk']);
                    $ykcolor = $u['zyk'] > 0 ? '#00d123' : ($u['zyk'] < 0 ? '#fe0101' : '');
                    $orderlist[$uid] = [];
                    foreach ($u['orders'] as $sname=>$cons){
                        foreach ($cons as $c){
                            $orderlist[$uid][] = ['b'=>$sname,'p'=>$c['play'],'a'=>$c['je'],'y'=>ComFunc::pr2($c['yk'])];
                        }
                    }
                    $tmp = ['otype'=>'settle','ctype'=>'html','con'=>"<p>[{$u['name']}]&nbsp;得分:<span style='color:{$ykcolor}'>{$u['zyk']}&nbsp;&nbsp;</span></p>",'uid'=>$uid];
                    array_push($msgarr,$tmp);
                }
                if(count($marr) > 1){
                    //$msgarr[] = ['otype'=>'normal','ctype'=>'text','con'=>$marr[1]];
                    $msgarr = array_merge($msgarr,ComServices::textToArr($marr[1]));
                }
                if(count($marr) <= 1){
                    //$msgarr[] = ['otype'=>'normal','ctype'=>'text','con'=>$marr[0]];
                    $msgarr = array_merge($msgarr,ComServices::textToArr($marr[0]));
                }
                $chatData['mtype'] = 1;
                $chatData['other'] = $orderlist;
                $msg_content = $msgarr;
            }
            $chatData['content'] = $msg_content;
            $chatDatas[] = $chatData;
        }

        //玩家结算后的积分显示
        unset($chatData['mtype'],$chatData['other']);
        $msg_content = Gamemsg::where(['ruid'=>$ruid,'gid'=>$gid,'keyname'=>'playerPointsMessageAfterSettlement','ifok'=>1])->value('msg_content');
        if(!empty($msg_content)){
            $msg_content = ComServices::textHandler($msg_content);
            $msg_content = str_replace("{游戏}",$gname,$msg_content);
            $msg_content = str_replace("{期号}",$qishu,$msg_content);
            $tmp_msg = "";$x = 0;
            if($roomConfig['betUserCreditOnly'] == 1){
                foreach ($utmp as $uid=>$u){
                    $balance = ComFunc::pr2(isset($result[$uid]) ? $result[$uid] : 0);
                    if($balance < $roomConfig['lowScoreNoBillMessage']){
                        continue;
                    }
                    $tmp_msg .= "[" . $u['name'] . " 积分:" . $balance . ']';
                    $x != count($utmp)-1 && $tmp_msg .= "<br>";
                    $x++;
                }
            }else{
                $ulist = User::where(['ruid'=>$ruid,'type'=>4,'room_status'=>1,'robot'=>0,'is_del'=>0,'ifson'=>0])->where('kmoney','>',$roomConfig['lowScoreNoBillMessage'])->select(['name','kmoney'])->get()->toArray();
                foreach ($ulist as $u){
                    $kmoney = ComFunc::pr2($u['kmoney']);
                    $tmp_msg .= "[" . $u['name'] . " 积分:" . $kmoney . ']';
                    $x != count($ulist)-1 && $tmp_msg .= "<br>";
                    $x++;
                }
            }
            $msg_content = str_replace("{账单}",$tmp_msg,$msg_content);
            $count = count($result);
            $msg_content = str_replace("{玩家数量}",$count,$msg_content);
            $chatData['content'] = ComServices::textToArr($msg_content);
            $chatData['mtype'] = 1;
            $chatDatas[] = $chatData;
        }

        $batchs[$chatListKey] = $chatDatas;
        ComServices::saveMsg(null,$batchs,null,null,1);
        $list = ComServices::getRoomAllFd($ruid);
        if(!empty($list)){
            foreach ($list as $fd) {
                ComServices::sendMsg(null,$fd,'gamechat',$chatDatas,$gid,['openResult'=>$isopenresult]);//
            }
        }
    }

    public function taskcommo(){
        try {
            $his = date('His');
            //当前时间大于06:25:00小于06:30:00
            if ($his >= 62500 && $his < 63000) {
                //执行任务
                SGUtils::dotask();
            }
            AutosService::create_today_table();
            AutosService::create_today_tablef();
            //检测飞单时间是否过期，如果过期则关闭所有飞单
            $olist = Userroom::where('outbet_switch',1)->where('outbet_overtime','<',time())->select(['userid'])->get();
            foreach ($olist as $item){
                Userroom::where('userid',$item['userid'])->update(['outbet_switch'=>0]);
            }
            $this->checkonline();
        }catch (\Exception $e){
            Log::error('公共任务错误：'.$e->getMessage());
        }
    }

    public function checkonline(){
        /*$onlinefdmapkey =
        $list = Redis::hgetall($onlinefdmapkey);
        $pipeline = Redis::pipeline();
        $maps = [];$index = 0;
        foreach ($list as $ustr=>$fd) {
            $maps[$index] = $ustr;
            $onlinekey = WebsocketConstants::$onlineFdKeyPre.':'.$fd;
            $pipeline->exists($onlinekey);
            $index++;
        }
        $results = $pipeline->exec();$delkeys = [];
        foreach ($results as $index=>$result) {
            if(!$result){
                $delkeys[] = $maps[$index];
            }
        }
        if(count($delkeys) > 0){
            $pipeline = Redis::pipeline();
            foreach ($delkeys as $k) {
                $pipeline->hdel($onlinefdmapkey,$k);
            }
            $pipeline->exec();
        }*/
        $db = Db::connection();
        $t = time()-WebsocketConstants::$onlineTimeout;
        $db->update("update x_online set online = 0 where online = 1 and lastOnlineTime < {$t}");
    }

    public function finish(){

    }
}
