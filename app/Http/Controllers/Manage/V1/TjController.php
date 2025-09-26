<?php

namespace App\Http\Controllers\Manage\V1;


use App\Common\Queue\CommonQueue;
use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Admin;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\kjw\LoadHistoryData;
use App\ort\kjw\services\ConService;
use App\ort\services\AutoKjsService;
use App\ort\services\AutosService;
use App\ort\sgwin\Json;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Illuminate\Support\Facades\delete;

class TjController extends ManageAuthController
{
    public function datalist(Request $request){
        $lotterys = Game::where('ifopen',1)->select(['gname','gid'])->get();
        view()->share('lotterys',$lotterys);
        $sdate = AdminFunc::week();
        view()->share('sdate',$sdate);
        return view('managev1.tj.datalist');
    }

    public function datalistdata(Request $request){
        $gid = $request->input('gid','');
        $duoshiduan = $request->input('duoshiduan',1);
        $mutiue = $request->input('mutiue',5);
        $date = $request->input('date','');
        $predate = date('Y-m-d',strtotime($date));
        $table = 'x_lib_'.str_replace('-','',$predate);
        $db = Db::connection();
        $whi = '';
        if($gid){
            $whi .= " and gid = $gid";
        }
        //根据时间段和次数生成日期数组
        $dataarr = [];
        //固定开始时间为date的 07:00:00
        $startdate = strtotime($date);
        for($i=0;$i<$duoshiduan;$i++){
            //加mutiue分钟
            $enddate = $startdate+$mutiue*60;
            $showdate = date('Y-m-d H:i:s',$startdate);
            $dataarr[] = ['start'=>$startdate,'end'=>$enddate,'je'=>0,'yk'=>0,'i'=>$i+1,'showdate'=>$showdate];
            $startdate = $enddate;
        }
        $totalje = 0;$totalyk = 0;
        foreach ($dataarr as $k=>$v) {
            $startdate = $v['start'];
            $sql = "SELECT SUM(je) as je,SUM(if(z=1,(je*peilv11-je),0))-SUM(if(z=0,je,0))+SUM(if(z in (0,1),je*points/100,0)) as yk FROM {$table} WHERE z in (0,1) and time <= {$startdate} $whi;";
            $res = $db->select($sql);
            $resdata = isset($res[0])?$res[0]:[];
            $dataarr[$k]['je'] = isset($resdata['je'])?$resdata['je']:0;
            $dataarr[$k]['yk'] = isset($resdata['yk'])?$resdata['yk']:0;
            $dataarr[$k]['je'] = ComFunc::pr2($dataarr[$k]['je']);
            $dataarr[$k]['yk'] = ComFunc::pr2($dataarr[$k]['yk']);
            $totalje += $dataarr[$k]['je'];
            $totalyk += $dataarr[$k]['yk'];
        }
        $totalje = ComFunc::pr2($totalje);
        $totalyk = ComFunc::pr2($totalyk);
        $result = [];
        $result['list'] = $dataarr;
        $result['totalje'] = $totalje;
        $result['totalyk'] = $totalyk;
        return response()->json($result);
    }

}
