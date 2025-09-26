<?php

namespace App\Http\Controllers\Manage\V1;


use App\Common\Queue\CommonQueue;
use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\ort\common\CsFunc;
use App\ort\kjw\LoadHistoryData;
use App\ort\kjw\services\ConService;
use App\ort\services\AutoKjsService;
use App\ort\services\AutosService;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Illuminate\Support\Facades\delete;

class KjdataGroupController extends ManageAuthController
{
    public function list(Request $request){
        $userid = $this->uid;
        $gamelist = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share('gamelist',$gamelist);
        $gid = $request->input('gid','');
        if(empty($gid)){
            $gid = $gamelist[0]['gid'];
        }
        $game = Game::where('gid',$gid)->select(['gname'])->first();
        $kjServices = new Kj();
        //获取最近30天的日期
        $list = [];
        $dates = $this->getRecentDays(30);
        foreach ($dates as $date){
            $item = [];
            $item['date'] = $date;
            $item['ykjcount'] = $kjServices->where(['dates'=>strtotime($date),'status'=>1,'gid'=>$gid])->count('id');
            $item['wkjcount'] = $kjServices->where(['dates'=>strtotime($date),'status'=>0,'gid'=>$gid])->count('id');
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
        return view('managev1.setting.kjdatagroup.list');
    }

    public function clearall(Request $request){
        $db = Db::connection();
        $db->delete('truncate x_kj;');
        return Json::success('清空成功');
    }

    public function createdata(Request $request){
        $date = $request->input('date','');
        $gid = $request->input('gid','');
        AutosService::create_kjdata($gid,0,$date);
        return Json::success('操作成功');
    }

    public function clear(Request $request){
        $date = $request->input('date','');
        $gid = $request->input('gid','');
        Kj::where(['dates'=>strtotime($date),'gid'=>$gid])->delete();
        return Json::success('操作成功');
    }

    public function tongbugf(Request $request){
        $date = $request->input('date','');
        $gid = $request->input('gid','');
        AutoKjsService::loadhistorykjdata($date,$gid,0);
        return Json::success('操作成功');
    }

    public function yijiantongbugf(Request $request){
        $days = $request->input('days','');
        $gid = $request->input('gid','');
        CommonQueue::dispatch(['days'=>$days,'gid'=>$gid,'type'=>'tongbuguanfang_bet']);
        return Json::success('操作成功');
    }

    public function createbydays(Request $request){
        $days = $request->input('days','');
        $gid = $request->input('gid','');
        CommonQueue::dispatch(['days'=>$days,'gid'=>$gid,'type'=>'createkjdata_bet']);
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
        return Json::success('操作成功');
    }

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

    public function yijianjiesuan(){
        $editend = x_config('editend');
        $db = Db::connection();
        if (date("His") < str_replace(':', '', $editend)) {
            $dates = date("Y-m-d", time() - 86400);
        } else {
            $dates = date("Y-m-d");
        }
        $game = Game::where(['ifopen' => 1])->select(['gid','mnum','fenlei'])->get();
        //结算开始
        foreach ($game as $v) {
            $gid = $v['gid'];
            $date = strtotime($dates);
            $rs1 = $db->select("select qishu from x_kj where gid='{$gid}' and dates='{$date}' and js=0 and status=1");
            if (count($rs1) > 0) {
                $ga = Game::where('gid',$gid)->select(['cs','fenlei','mtype','ztype'])->first();
                $cs = json_decode($ga['cs'], true);
                $mtype = json_decode($ga['mtype'], true);
                $ztype = json_decode($ga['ztype'], true);
                foreach ($rs1 as $v1) {
                    $ms = CsFunc::calc($v['fenlei'], $v['gid'], $cs, $v1['qishu'], $v['mnum'], $ztype, $mtype);
                }
            }
        }
        return Json::success('操作成功');
    }
}
