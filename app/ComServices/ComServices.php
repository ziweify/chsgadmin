<?php

namespace App\ComServices;

use App\Common\TaskSwoole\SaveMsgQueue;
use App\Models\Game\Chatmsg;
use App\Models\Game\LibModel;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use App\ort\sgwin\SGUtils;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Swoole\WebSocket\Server;

class ComServices
{

    //保存历史消息
    public static function saveMsg($chatListKey,$chatData,$ruid,$gid,$isbatch = 0){
        /* $param = [];
        $param['chatListKey'] = $chatListKey;
        $param['chatData'] = $chatData;
        $param['ruid'] = $ruid;
        $param['gid'] = $gid;
        $param['isbatch'] = $isbatch; */
        //Task::deliver(new SaveMsgQueue($param));

        try {
            $chatDataOrS = $chatData;
            if($isbatch == 0){//不是批量保存
                Redis::rpush($chatListKey, json_encode($chatDataOrS));
                Redis::ltrim($chatListKey, env('SAVE_MSG_LEN',50)*-1, -1);//只保留最新的100条
                //存储到数据库
                if(isset($chatDataOrS['mtype']) && ($chatDataOrS['mtype'] == 1 || $chatDataOrS['mtype'] == 2)){
                    $chatDataOrS['content'] = json_encode($chatDataOrS['content'], JSON_UNESCAPED_UNICODE);
                    if(isset($chatDataOrS['other']) && !empty($chatDataOrS['other'])){
                        $chatDataOrS['other'] = json_encode($chatDataOrS['other'], JSON_UNESCAPED_UNICODE);
                    }else{
                        $chatDataOrS['other'] = '';
                    }
                }
                $saveChatData = $chatDataOrS;
                $saveChatData['ruid'] = $ruid;
                $saveChatData['gid'] = $gid;
                Chatmsg::create($saveChatData);
            }else{
                $saveChatDatas = [];
                foreach ($chatDataOrS as $chatListKey=>$chatDatas) {
                    Redis::ltrim($chatListKey, env('SAVE_MSG_LEN',50)*-1, -1);//只保留最新的50条
                    foreach ($chatDatas as $chatData) {
                        if(isset($chatData['mtype']) && ($chatData['mtype'] == 1 || $chatData['mtype'] == 2)){
                            $chatData['content'] = json_encode($chatData['content'], JSON_UNESCAPED_UNICODE);
                            if(isset($chatData['other']) && !empty($chatData['other'])){
                                $chatData['other'] = json_encode($chatData['other'], JSON_UNESCAPED_UNICODE);
                            }else{
                                $chatData['other'] = '';
                            }
                        }else{
                            $chatData['mtype'] = 0;
                            $chatData['other'] = '';
                        }
                        $saveChatDatas[] = $chatData;
                    }
                }
                Chatmsg::insert($saveChatDatas);
                //在保存到redis
                $pipeline = Redis::pipeline();
                foreach ($chatDataOrS as $chatListKey=>$chatDatas) {
                    foreach ($chatDatas as $chatData) {
                        unset($chatData['ruid']);
                        unset($chatData['gid']);
                        unset($chatData['type']);
                        $pipeline->rpush($chatListKey, json_encode($chatData));
                    }
                }
                $pipeline->exec();
            }
        }catch (\Exception $e){
            Log::info($e->getMessage().$e->getTraceAsString());
        }
    }

    /**
     * 发送消息
     * @param Server $server
     * @param $fdors
     * @param $eventType
     * @param $data
     * @param $gid
     * @param $other
     * @return true
     */
    public static function sendMsg(Server $server = null,$fdors,$eventType,$data,$gid = '',$other = []){
        if(empty($server)){
            $server = app('swoole');
        }
        if(is_array($fdors)){
            foreach ($fdors as $fd) {
                if ($server->isEstablished($fd)) {
                    $server->push($fd, json_encode(['eventType'=>$eventType,'data'=>$data,'gid'=>$gid,'other'=>$other]));
                }
            }
        }else{
            if ($server->isEstablished($fdors)) {
                $server->push($fdors, json_encode(['eventType'=>$eventType,'data'=>$data,'gid'=>$gid,'other'=>$other]));
            }
        }
        return true;
    }

    /**
     * 获取房间所有fd
     * @param $ruid
     * @return array
     */
    public static function getRoomAllFd($ruid){
        $roomkey = WebsocketConstants::$roomKeyPre;
        $fdors = Redis::smembers($roomkey.$ruid);
        if(empty($fdors)){
            return [];
        }
        return $fdors;
    }

    /**
     * 获取用户fd
     * @param $ruid
     * @param $uid
     * @return int
     */
    public static function getFdByUid($ruid,$uid){
        $onlinekey = WebsocketConstants::$onlineKeyPre;
        return Redis::get($onlinekey.$ruid.$uid);
    }

    /**
     * 获取当前房间在线人数
     * @param $ruid
     * @param $myuid
     * @return mixed
     */
    public static function getRoomOnlineCount($ruid){
        $roomkey = WebsocketConstants::$roomKeyPre;
        return Redis::scard($roomkey.$ruid);
    }

    /**
     * @param $ruid
     * @param $uid
     * @param $type 1:登录前踢出其他用户 2：踢出所有用户
     * @return void
     */
    public static function clearOnlineData($ruid,$uid,$type = 1){
        $fd = self::getFdByUid($ruid,$uid);
        if($fd){
            //$room = new Room();
            //$room->del($fd);
            $roomkey = WebsocketConstants::$roomKeyPre;
            $onlinekey = WebsocketConstants::$onlineKeyPre;
            Redis::srem($roomkey.$ruid,$fd);
            Redis::srem($onlinekey.$ruid.$uid,$fd);
            Online::where(['ruid'=>$ruid,'userid'=>$uid])->update(['online'=>0]);
        }
    }

    public static function textHandler($text){
        $msg_content = nl2br($text,false);
        return preg_replace("/\r|\n/", "", $msg_content);
    }

    public static function textToArr($text,$otype = 'normal',$ctype = 'html',$isToEmpty = 1){
        $msg_content_arr = explode('<br>',$text);
        $tmpstr = "";$msgarr = [];$c = count($msg_content_arr)-1;
        foreach ($msg_content_arr as $i=>$m){
            if(empty($m) && $isToEmpty == 2 && $i == $c){
                continue;
            }
            if($m == '<empty>' || empty($m)){
                $tmpstr .= "<p><br></p>";
            }else{
                $tmpstr .= "<p>".$m."</p>";
            }
        }
        $msgarr[] = ['otype'=>$otype,'ctype'=>$ctype,'con'=>$tmpstr];
        return $msgarr;
    }

    /**
     * 获取今日盈亏
     * @param $ruid
     * @param $gid
     * @return float
     */
    public static function getJrsy($ruid,$gid = null,$table = null,$robot = 0){
        if(empty($table)){
            $table = SGUtils::getcuretable(true);
        }
        $whi = " ruid = {$ruid}";
        if(!empty($gid)){
            $whi.= " and gid = {$gid}";
        }
        if($robot != 2){
            $whi.= " and robot = {$robot}";
        }
        $db = Db::connection();
        $sql  = "select sum(if(z=1,peilv1*je*zcount,0)) as zhong,sum(if(z in (0,1),je,0)) as zje,sum(if(z=1,uzp*je,0)) as tax,sum(if(z=2,je,0)) as heje from {$table} where {$whi}";
        $row = $db->select($sql);
        $zhong = $row[0]['zhong'] ?: 0;
        $zje = $row[0]['zje'] ?: 0;
        $tax = $row[0]['tax'] ?: 0;
        $heje = $row[0]['heje'] ?: 0;
        $yk = $zje-$tax+$heje-$zhong;
        return ComFunc::pr2($yk);
    }

    /**
     * 获取流水
     * @param $ruid
     * @param $gid
     * @param $qishu
     * @param $table
     * @param $robot
     * @param $type today 今日 qishu 期数
     * @return int|mixed
     */
    public static function getLiushui($ruid,$gid = null,$qishu = null,$table = null,$robot = 0,$type = 'today'){
        if(empty($table)){
            $table = SGUtils::getcuretable(true);
        }
        $whi = " ruid = {$ruid}";
        if(!empty($gid)){
            $whi.= " and gid = {$gid}";
        }
        if(!empty($qishu)){
            $whi.= " and qishu = {$qishu}";
        }
        if($robot != 2){
            $whi.= " and robot = {$robot}";
        }
        $db = Db::connection();
        if($type == 'today'){
            $sql  = "select sum(if(z in (0,1),je,0)) as zje from {$table} where {$whi}";
        }elseif ($type == 'qishu'){
            $sql  = "select sum(je) as zje from {$table} where {$whi}";
        }
        $row = $db->select($sql);
        $zje = $row[0]['zje'] ?: 0;
        return ComFunc::pr2($zje);
    }
}