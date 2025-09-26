<?php

namespace App\Http\Controllers\Manage;


use App\Models\Game\Game;
use App\ort\cachemodel\GameCache;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ZshuiController extends ManageAuthController
{

    public function zshuigameset(){
        $game = Game::select(['gid','gname','ifopen','lottery','xsort','taskgroup'])->orderBy('xsort')->get();
        //$cg = count($game);
        /*for ($i = 0; $i < $cg; $i++) {
            $ifok = Gamecs::where(['userid'=>Constants::$SUID,'gid'=>$game[$i]['gid']])->value('ifok');
            $game[$i]['ifok'] = $ifok;
        }*/
        view()->share("game", $game);
        return view('manage.zshui.gameset');
    }

    public function zshuisetgame(Request $request){
        $istest = env('TEST_PLATFORM');
        if($istest == 1 && $this->adminInfo['ifhide'] == 0){
            return Json::error('测试平台不允许修改');
        }
        $str = $request->input('str','');
        $game = str_replace('\\', '', $str);
        $game = json_decode($game, true);
        $cg = count($game);
        $db = Db::connection();
        for ($i = 0; $i < $cg; $i++) {
            $db->update("update x_game set xsort='{$game[$i]['px']}',ifopen='{$game[$i]['ifopen']}' where gid='{$game[$i]['gid']}'");
        }
        //从新分组
        $games = Game::where('ifopen',1)->select(['gid'])->get()->toArray();
        //分成5组
        $group = array_chunk($games,ceil(count($games)/5));
        foreach ($group as $k=>$v){
            $k = $k+1;
            $gidstr = implode(',',array_column($v,'gid'));
            $db->update("update x_game set taskgroup='$k' where gid in ($gidstr)");
        }
        //清理缓存
        Cache::delete('gids_list');
        GameCache::clearallgamecache();
        return Json::success('设置成功');
    }
}
