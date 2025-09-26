<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\AdminsPage;
use App\Models\Game\Game;
use App\Models\Game\Gamecs;
use App\Models\Game\Kj;
use App\Models\Game\News;
use App\Models\Game\User;
use App\ort\common\AdminFunc;
use App\ort\common\ArrayUtils;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\services\AutosService;
use App\ort\sgwin\SGUtils;
use Illuminate\Support\Facades\Cache;

class IndexController extends ManageAuthController
{
    public function index(){
        //游戏查询
        $webname = x_config('webname');
        view()->share("webname",$webname );
        $user = User::where('userid', Constants::$SUID)->select(['username'])->first();
        //查询游戏数据
        view()->share("layer", 0);
        view()->share("ifhide", $this->adminInfo['ifhide']);
        view()->share('adminid', $this->uid);
        view()->share('username', $this->adminInfo['adminname']);
        $nlist = News::where('agent',0)->where(['alert'=>1,'ifok'=>1])->select(['content'])->orderByDesc('time')->get();
        view()->share("notices",$nlist);
        $lotterys = Game::whereIn('gid', function ($query){
            $query->select('gid')->from('gamecs')->where('userid', $this->uid);
        })->where('ifopen', 1)->select(['gname','lottery','fenlei','template'])->orderBy('xsort')->get();
        $lotterys = $lotterys->toArray();
        foreach ($lotterys as $k => $v) {
            //玩法分类
            $lotterys[$k]['sub'] = SGUtils::gethtfllist($v['fenlei']);
            //url生成
            foreach ($lotterys[$k]['sub'] as $k1 => $v1) {
                $lotterys[$k]['sub'][$k1]['url'] = "load?lottery={$v['lottery']}&page={$v1['page']}";
                if(isset($v1['index'])){
                    $lotterys[$k]['sub'][$k1]['url'] .= "&index={$v1['index']}";
                }
            }
        }
        view()->share('lotterys', $lotterys);
        view()->share('planenable', x_config('planenable'));
        view()->share('ismobie',ComFunc::ismobie() ? 1 : 0);
        view()->share('plat_tax_status', x_config('plat_tax_status'));
        view()->share('tax_status', in_array('user.tax',$this->auths) ? 1 : 0);
        view()->share('tax_name', x_config('tax_name'));
        view()->share('outbet_status', in_array('flyout',$this->auths) ? 1 : 0);
        view()->share('plat_outbet_status', x_config('plat_outbet_status'));
        view()->share('outbet_name', x_config('outbet_name'));
        return view('managev1.index');
    }
}
