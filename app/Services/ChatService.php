<?php

namespace App\Services;

use App\ComServices\ComServices;
use App\ComServices\MsgHandlerServices;
use App\ComServices\Room;
use App\ComServices\WebsocketConstants;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\Models\Game\Userreg;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class ChatService implements WebSocketHandlerInterface
{

    protected $handle;
    protected $nowRoom;
    protected $cache;

    public function __construct(){
        $this->handle = new MsgHandlerServices();
        //$this->nowRoom = new Room();
        $this->cache = Redis::connection();//Redis实例
    }

    public function onOpen(Server $server, Request $request){
        Log::info('WebSocket 连接建立,fd:'.$request->fd);
        $data = $request->get;
        //$gid = isset($data['gid']) ? $data['gid'] : '';
        $token = isset($data['token']) ? $data['token'] : '';
        $type = isset($data['type']) ? $data['type'] : 'game';
        if($type == 'game'){//游戏聊天室
            if(empty($token)){
                ComServices::sendMsg($server,$request->fd,'logout',"请传入token");
                //断开连接
                $server->disconnect($request->fd);
                return;
            }
            $userInfo = TokenService::getUserInfo($token);
            if(empty($userInfo)){
                ComServices::sendMsg($server,$request->fd,'logout','token失效1');
                return;
            }
            $userreg = Userreg::where(['userid'=>$userInfo['userid']])->select(['userid','ruid','type','token'])->first();
            if(empty($userreg)){
                ComServices::sendMsg($server,$request->fd,'logout','注册用户不存在');
                return;
            }
            if($userreg['token'] != $token){
                ComServices::sendMsg($server,$request->fd,'logout','token失效1');
                return;
            }
            if($userreg['type'] == 0){//群成员
                if(empty($userreg['ruid'])){
                    ComServices::sendMsg($server,$request->fd,'logout','未初始化房间');
                    return;
                }
                $user = User::where(['userid'=>$userInfo['userid'],'ruid'=>$userreg['ruid']])->select(['room_status'])->first();
                if(empty($user)){
                    ComServices::sendMsg($server,$request->fd,'logout','房间用户不存在');
                    return;
                }
                if($user['room_status'] == 0){
                    ComServices::sendMsg($server,$request->fd,'logout','禁止加入房间');
                    return;
                }
                $ruid = $userreg['ruid'];
                //更新token的ruid
                if($ruid != $userInfo['ruid']){
                    $userInfo['ruid'] = $ruid;
                    TokenService::updateToken($token,$userInfo);
                }
            }else{
                $ruid = $userInfo['ruid'];
            }
            //添加房间数据
            //$this->nowRoom->add($request->fd,$userInfo['userid'],$ruid,$userreg['type']);
            $this->login($ruid,$userInfo['userid'],$request->fd);
            //发送连接成功
            ComServices::sendMsg($server,$request->fd,'loginSuccess','连接成功');
        }
    }

    public function login($ruid, $uid, $fd){
        $roomkey = WebsocketConstants::$roomKeyPre;
        $onlinekey = WebsocketConstants::$onlineKeyPre;
        $roomfdkey = WebsocketConstants::$roomFdKeyPre;
        $this->cache->sadd($roomkey.$ruid,$fd);
        $this->cache->set($onlinekey.$ruid.$uid,$fd);
        $this->cache->set($roomfdkey.$fd,$ruid.'|'.$uid);
        $this->refresh($ruid,$uid);
        //User::where(['ruid'=>$ruid,'userid'=>$uid])->update(['online'=>1]);
    }

    public function refresh($ruid, $uid){
        $roomkey = WebsocketConstants::$roomKeyPre;
        $onlinekey = WebsocketConstants::$onlineKeyPre;
        $this->cache->expire($roomkey.$ruid, WebsocketConstants::$onlineTimeout);
        $this->cache->expire($onlinekey.$ruid.$uid, WebsocketConstants::$onlineTimeout);
        //更新用户表lastOnlineTime
        Online::where(['ruid'=>$ruid,'userid'=>$uid])->update(['lastOnlineTime'=>time(),'online'=>1]);
    }

    public function logout($ruid, $uid, $fd){
        $roomkey = WebsocketConstants::$roomKeyPre;
        $onlinekey = WebsocketConstants::$onlineKeyPre;
        $roomfdkey = WebsocketConstants::$roomFdKeyPre;
        $this->cache->srem($roomkey.$ruid,$fd);
        $this->cache->del($onlinekey.$ruid.$uid);
        $this->cache->del($roomfdkey.$fd);
    }

    public function onMessage(Server $server, Frame $frame){
        try {
            $fd = $frame->fd;
            //$info = $this->nowRoom->get($fd);
            //Log::info('info:'.json_encode($info));
            $data = json_decode($frame->data, true);
            if(!$data || !isset($data['eventType']) || !isset($data['token'])){
                return true;
            }
            $userInfo = TokenService::getUserInfo($data['token']);
            if(empty($userInfo)){
                ComServices::sendMsg($server,$fd,'logout','token失效2');
                return;
            }
            //检查登录状态
            if(!$this->checkLoginStatus($userInfo,$fd)){
                return true;
            }
            $this->refresh($userInfo['ruid'],$userInfo['userid']);
            if($data['eventType'] == 'ping'){
                ComServices::sendMsg(null,$fd,'pong','pong');
                return true;
            }
            if (!method_exists($this->handle, $data['eventType'])) {
                Log::info("{$data['eventType']}方法不存在");
                return true;
            }
            $data['uid'] = $userInfo['userid'];
            $data['ruid'] = $userInfo['ruid'];
            $data['ip'] = $server->getClientInfo($fd)['remote_ip'];
            $data['type'] = $userInfo['type'];
            //合并参数
            $this->handle->{$data['eventType']}($server,$frame,$data);
        }catch (\Exception $e){
            Log::error('聊天服务异常：'.$e->getMessage().$e->getTraceAsString());
        }
    }
    public function checkLoginStatus($userInfo,$fd){
        $ruid = $userInfo['ruid'];
        $uid = $userInfo['userid'];
        $onlinekey = WebsocketConstants::$onlineKeyPre;
        $chacefd = $this->cache->get($onlinekey.$ruid.$uid);
        //Log::info('chacefd:'.$chacefd);
        if($chacefd != $fd){
            //退出登录
            //$this->logout($ruid,$uid,$fd);
            //删除table
            //$this->nowRoom->del($fd);
            ComServices::sendMsg(null,$fd,'timeout','超时重新连接');
            return false;
        }
        return true;
    }

    public function onClose(Server $server, $fd, $reactorId){
        Log::info('WebSocket 连接关闭,fd:'.$fd.' '.$reactorId);
        //清除在线fd映射
        /*$onlinefdkey = WebsocketConstants::$onlineFdKeyPre.':'.$fd;
        $ustr = Redis::get($onlinefdkey,'');*/
        $roomfdkey = WebsocketConstants::$roomFdKeyPre;
        $ruidanduid = $this->cache->get($roomfdkey.$fd);
        if(!empty($ruidanduid)){
            $ruid = explode('|',$ruidanduid)[0];
            $uid = explode('|',$ruidanduid)[1];
            $this->logout($ruid,$uid,$fd);
            Online::where(['ruid'=>$ruid,'userid'=>$uid])->update(['online'=>0]);
        }
    }
}
