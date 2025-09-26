<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\ComServices\ComServices;
use App\ComServices\GameServices;
use App\ComServices\WebsocketConstants;
use App\Models\Game\Game;
use App\Models\Game\News;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\sgwin\AppJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RoomController
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGameAndTimedata(Request $request){
        $gid= $request->get('gid','');
        $ruid = $request->ruid;
        $result = (new GameServices())->periodlistorsingle($ruid,$gid,2);
        return AppJson::success('ok',['list'=>$result,'gid'=>$gid]);
    }

    public function getRoomNotice(Request $request){
        $news = News::where(['ifok'=>1])->whereIn('agent',[0,1])->select(['title','content','time','gundong','alert'])->get()->toArray();
        $gundong = '';
        $alerts = [];
        foreach ($news as $v){
            if($v['gundong'] == 1){
                $gundong .= $v['content'];
            }
            if($v['alert'] == 1){
                $alerts[] = ['title'=>$v['title'],'content'=>$v['content'],'time'=>date('Y-m-d H:i:s',$v['time'])];
            }
        }
        return AppJson::success('ok',['gundong'=>$gundong,'alerts'=>$alerts]);
    }

    public function updateGameStatus(Request $request){
        $ifok = $request->input('ifok',0);
        $gid = $request->input('gid','');
        if(empty($gid)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $old = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->value('ifok');
        $gname = Game::where(['gid'=>$gid])->value('gname');
        $old = $old == 1 ? '开启' : '关闭';
        $new = $ifok == 1 ? '开启' : '关闭';
        Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->update(['ifok'=>$ifok]);
        //添加日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>$gname.'开关','old'=>$old,'new'=>$new,'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'update']);
        return AppJson::success('ok');
    }

    public function getOnlineCount(Request $request){
        $ruid = $request->ruid;
        $count = Online::where(['ruid'=>$ruid,'online'=>1,'type'=>4])->count('id');
        $count > 1 && $count = $count - 1;
        $key = WebsocketConstants::$NotReadMsgAgentPre.":".$ruid;
        $noReadMessageCount = Redis::hlen($key);
        $key = WebsocketConstants::$NotReadApplyAgentPre.":".$ruid;
        $noReadApplyCount = Redis::get($key);
        return AppJson::success('ok',['count'=>$count,'noReadMessageCount'=>$noReadMessageCount,'noReadApplyCount'=>$noReadApplyCount]);
    }
}
