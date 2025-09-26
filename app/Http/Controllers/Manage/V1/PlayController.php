<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Api\Member\DoubleCommonService;
use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\Play;
use App\Models\Game\User;
use App\ort\services\OrdersExport;
use App\ort\sgwin\HtService;
use App\ort\sgwin\Json;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PlayController extends ManageAuthController
{
    public function load(Request $request){
        $lottery = $request->input('lottery','');
        $page = $request->input('page','');
        $index = $request->input('index','');
        $userid = $this->uid;
        $game = Game::where('lottery',$lottery)->select(['gid','gname','fenlei','lottery','template'])->first();
        $ns = SGUtils::getCsBypage($game['template'],$page,$index);
        view()->share('gameName', $ns['name']);
        view()->share('games', $ns['cs']);
        view()->share('template', $game['template']);
        view()->share('lottery',$lottery);
        view()->share('page',$page);
        view()->share('index',$index);
        isset($ns['qiu']) && view()->share('qiu',$ns['qiu']);
        $layers = json_decode(x_config('layer'), true);
        $users = User::where(['ifexe'=>1,'pself'=>1,'ifagent'=>1])->select(['username','layer','name'])->get();
        foreach ($users as $k=>$v){
            if($v['layer'] > 0){
                $users[$k]['layername'] = $layers[$v['layer']-1];
            }
        }
        view()->share("users", $users);
        view()->share('is_open_dqbf',x_config('is_open_dqbf'));
        return view('managev1.load');
    }

    public function period(Request $request){
        $lottery = $request->get('lottery','');
        if(empty($lottery)){
            return Json::error('参数错误');
        }
        $return = (new DoubleCommonService())->period($lottery);
        return response()->json($return)->content();
    }

    public function lastResult(Request $request){
        $lottery = $request->get('lottery','');
        if(empty($lottery)){
            return Json::error('参数错误');
        }
        $return = (new DoubleCommonService())->lastResult($lottery);
        return response()->json($return);
    }

    public function controlrisk(Request $request){
        $lottery = $request->get('lottery','');
        $games = $request->get('games','');
        $all = $request->get('all','');
        $abcd = $request->get('range','');
        $multiple = $request->get('multiple',false);
        $username = $request->get('username','');
        if(empty($username)){
            $userid = $this->uid;
            $user = User::where('userid', $userid)->select(['pan','defaultpan','layer','userid','ifexe','pself','fid1'])->first();
        }else{
            $user = User::where('username', $username)->select(['pan','defaultpan','layer','userid','ifexe','pself','fid1'])->first();
        }
        $result = HtService::controlrisk($user,$lottery,$abcd,$all,$games);
        return response()->json($result);
    }

    public function bet(Request $request){
        $bets = $request->input('bets','');
        $drawNumber = $request->input('drawNumber','');
        $ignore = $request->input('ignore',false);
        $lotteryId = $request->input('lotteryId','');
        return Json::error('已达到下注上限',[],false);
    }

    public function oddsset(Request $request){
        $username = $request->input('username','');
        $lottery = $request->input('lottery','');
        $type = $request->input('type',1);
        $items = $request->input('items','');
        $items = json_decode($items,true);
        $value = $request->input('value','');
        $drawNumber = $request->input('drawNumber','');
        $user = User::where(['username'=>$username])->first();
        $game = Game::where(['lottery'=>$lottery])->select(['gid'])->first();
        $gid = $game['gid'];
        $db = Db::connection();
        foreach ($items as $item){
            $play = Play::where(['gid'=>$gid,'cy'=>$item])->select(['pid'])->first();
            $pid = $play['pid'];
            if($user['layer'] == 0){
                if($type < 0){
                    $db->update("update x_play set peilv1=if(peilv1+$value>1,peilv1+$value,1)  where gid='$gid' and pid='$pid'");
                }else{
                    $db->update("update x_play set peilv1=peilv1+$value  where  gid='$gid' and pid='$pid'");
                }
            }else{
                if($type < 0){
                    $db->update("update x_play_user set peilv1=if(peilv1+$value>1,peilv1+$value,1)  where gid='$gid' and pid='$pid'");
                }else{
                    $db->update("update x_play_user set peilv1=peilv1+$value  where  gid='$gid' and pid='$pid'");
                }
            }
            $time = time();
            $db->delete("delete from x_c where gid='$gid' and pid='$pid' and userid='{$user['userid']}'");
            $db->insert("insert into x_c set gid='$gid',pid='$pid',time=$time,userid='{$user['userid']}'");
            $atts = $value;
            /*if ($type == -1) {
                $atts = 0 - $atts;
            }*/
            $db->insert("insert into x_peilv set gid='$gid',pid='$pid',peilv='$atts',time=$time,userid='{$user['userid']}',sonuser='$this->adminid',auto=0");
        }
        return Json::success('操作成功',[],false);
    }

    public function bfdangqi(Request $request){
        $lottery = $request->input('lottery','');
        $game = Game::where(['lottery'=>$lottery])->select(['gid','thisqishu','gname'])->first();
        $gamename = $game['gname'];
        $thisqishu = $game['thisqishu'];
        return Excel::download(new OrdersExport($game), "备份_{$gamename}_{$thisqishu}.xlsx");
    }
}
