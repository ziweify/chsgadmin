<?php

namespace App\Common\TaskSwoole;

use App\Models\Game\Chatmsg;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class SaveMsgQueue extends Task
{
    protected $param;

    public function __construct($param){
        $this->param = $param;
    }

    public function handle(){
        try {
            $chatDataOrS = $this->param['chatData'];
            $isbatch = $this->param['isbatch'];//是否批量保存
            if($isbatch == 0){//不是批量保存
                $chatListKey = $this->param['chatListKey'];
                $ruid = $this->param['ruid'];
                $gid = $this->param['gid'];
                Redis::rpush($chatListKey, json_encode($chatDataOrS));
                Redis::ltrim($chatListKey, env('SAVE_MSG_LEN',50)*-1, -1);//只保留最新的100条
                //存储到数据库
                if(isset($chatDataOrS['mtype']) && ($chatDataOrS['mtype'] == 1 || $chatDataOrS['mtype'] == 2)){
                    $chatDataOrS['content'] = json_encode($chatDataOrS['content'], JSON_UNESCAPED_UNICODE);
                    $chatDataOrS['other'] = json_encode($chatDataOrS['other'], JSON_UNESCAPED_UNICODE);
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
                            if(isset($chatData['other'])){
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
}
