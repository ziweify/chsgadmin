<?php

namespace App\Http\Controllers\Manage\Kjw;


use App\Common\Queue\CommonQueue;
use App\Models\Kjw\Game;
use App\ort\kjw\CommonService;
use App\ort\kjw\LoadHistoryData;
use App\ort\kjw\services\ConService;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class KjdataGroupController
{
    public function list(Request $request){
        $gamelist = Game::where('status',1)->select(['gid','gname'])->get();
        view()->share('gamelist',$gamelist);
        $gid = $request->input('gid','');
        if(empty($gid)){
            $gid = $gamelist[0]['gid'];
        }
        $game = Game::where('gid',$gid)->select(['gname'])->first();
        $kjServices = CommonService::getKjmodel($gid);
        //获取最近30天的日期
        $list = [];
        $dates = $this->getRecentDays(30);
        foreach ($dates as $date){
            $item = [];
            $item['date'] = $date;
            $item['ykjcount'] = $kjServices->where(['dates'=>strtotime($date),'status'=>1])->count('id');
            $item['wkjcount'] = $kjServices->where(['dates'=>strtotime($date),'status'=>0])->count('id');
            $item['gname'] = $game->gname;
            if($item['ykjcount'] <= 0 && $item['wkjcount'] <= 0){
                $item['isdata'] = 0;
                $item['isdatastr'] = '无数据';
            }else{
                $item['isdata'] = 1;
                $item['isdatastr'] = '有数据';
            }
            $list[] = $item;
        }
        view()->share('list',$list);
        view()->share('gid',$gid);
        return view('managev1.kjw.kjdatagroup.list');
    }

    public function clearall(Request $request){
        $fast = $request->input('fast',1);
        ConService::truncate_table($fast);
        return Json::success('清空成功');
    }

    public function createdata(Request $request){
        $date = $request->input('date','');
        $gid = $request->input('gid','');
        $game = Game::where('gid',$gid)->select(['gname','fenlei','fast'])->first();
        if($game['fast'] == 1){
            ConService::fast_create_data(strtotime($date),$gid);
        }
        return Json::success('操作成功');
    }

    public function clear(Request $request){
        $date = $request->input('date','');
        $gid = $request->input('gid','');
        $db = Db::connection('kjw');
        $db->table('kj'.$gid)->where('dates',strtotime($date))->delete();
        return Json::success('操作成功');
    }

    public function tongbugf(Request $request){
        $date = $request->input('date','');
        $gid = $request->input('gid','');
        $game = Game::where('gid',$gid)->select(['lotCode','fenlei','fast'])->first();
        ConService::loadhistorykjdata($date,$game['lotCode'],1);
        return Json::success('操作成功');
    }

    public function yijiantongbugf(Request $request){
        $days = $request->input('days','');
        $gid = $request->input('gid','');
        $game = Game::where('gid',$gid)->select(['lotCode','fenlei','fast'])->first();
        //ConService::loadhistorykjdata($date,$game['lotCode'],0);
        CommonQueue::dispatch(['days'=>$days,'gid'=>$gid,'type'=>'tongbuguanfang','lotCode'=>$game['lotCode']]);
        return Json::success('操作成功');
    }

    public function createbydays(Request $request){
        $days = $request->input('days','');
        $gid = $request->input('gid','');
        CommonQueue::dispatch(['days'=>$days,'gid'=>$gid,'type'=>'createkjdata']);
        return Json::success('操作成功');
    }

    public function loadqgc(Request $request){
        $gid = $request->input('gid',0);
        //CommonQueue::dispatch(['gid'=>$gid,'type'=>'loadqgc']);\
        LoadHistoryData::load_qgc_and_twc_history(0);
        return Json::success('操作成功');
    }

    public function loadlhc(Request $request){
        LoadHistoryData::load_lhc_history(20);
        LoadHistoryData::load_oldamlhc_history();
        return Json::success('操作成功');
    }

    /*public function loadoldamlhc(Request $request){
        LoadHistoryData::load_oldamlhc_history();
        return Json::success('操作成功');
    }*/

    /**
     * 获取最近天数的日期
     * @param $days
     * @return array
     */
    public function getRecentDays($days){
        $date = [];
        for($i=0;$i<$days;$i++){
            $date[] = date('Y-m-d',strtotime("-$i day"));
        }
        return $date;
    }
}
