<?php

namespace App\Http\Controllers\Manage\Kjw;


use App\Models\Kjw\Game;
use Illuminate\Http\Request;

class GameController
{
    public function list(){
        $gname = request()->get('gname','');
        $fenlei = request()->get('fenlei','');
        $fast = request()->get('fast','');
        $model = Game::query();
        if(!empty($gname)){
            $model->where('gname','like','%'.$gname.'%');
        }
        if(!empty($fenlei)){
            $model->where('fenlei',$fenlei);
        }
        if($fast != ''){
            $model->where('fast',$fast);
        }
        $pagesize = 20;
        $list = $model->orderByRaw('gid desc')->paginate($pagesize);
        //计算总页数
        $total = $list->total();
        $totalPage = ceil($total/$pagesize);
        $list->totalPage = $totalPage;
        foreach ($list as $k=>$v){
            $list[$k]['guanfang'] = $v['guanfang'] == 1 ? '官方' : '系统';
            $list[$k]['laiyuan'] = $v['laiyuan'] == 1 ? '自己开' : '投注站';
            $list[$k]['status'] = $v['status'] == 1 ? '正常' : '禁用';
        }
        view()->share('fenlei',$fenlei);
        view()->share('fast',$fast);
        view()->share('gname',$gname);
        view()->share('list',$list);
        return view('managev1.kjw.game.list');
    }

}
