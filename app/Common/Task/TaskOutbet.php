<?php

namespace App\Common\Task;

use App\Common\TaskSwoole\OutbetCheckBalanceQueue;
use App\Models\Game\Followplan;
use App\Models\Game\Game;
use App\Models\Game\OutbetAccs;
use App\Models\Game\OutbetSite;
use App\Models\Game\Play;
use App\ort\common\ComFunc;
use App\ort\HttpUtils;
use App\ort\services\FollowPlanService;
use App\ort\sgwin\OutbetServices;
use App\ort\sgwin\SGUtils;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskOutbet extends CronJob
{
    public function interval(){
        return 10000;
    }

    public function isImmediate(){
        return false;
    }

    public function run(){
        $key = 'is_run_outbet';
        $is_run = Cache::get($key);
        if($is_run == 1){
            return;
        }
        $plat_outbet_status = x_config('plat_outbet_status');
        $server_ip = env('SERVER_IP');//当前服务器ip
        if($plat_outbet_status == 1){
            $outbetsitelsit = OutbetSite::where(['enabled'=>1,'auth_outbet_ip'=>$server_ip])->get();
            foreach ($outbetsitelsit as $site){
                $totalbalance = 0;
                try {
                    if($site['enabled'] == 1){
                        if (!empty($site['bz'])){
                            $arr = explode('|',$site['bz']);
                            if(is_numeric($arr[2])){
                                $totalbalance += $arr[2];
                            }
                        }
                        $ks = Cache::get('updateaccbalance_'.$site['id'],0);
                        if(empty($ks)){
                            if($site['type'] == 'sgwin'){
                                (new OutbetServices())->sgupdateblance($site);
                            }elseif($site['type'] == 'daji'){
                                (new OutbetServices())->dajiupdateblance($site);
                            }
                        }
                    }
                }catch (\Exception $e){
                    Log::info('outbet check balance error:'.$e->getMessage());
                }
                if(!empty($site['ykstr'])){
                    $list = explode('|',$site['ykstr']);
                    foreach ($list as $arrstr){
                        $arr = explode(',',$arrstr);
                        $yk = $arr[0];
                        if(is_numeric($yk) && $yk != 0){
                            $type = isset($arr[1])?$arr[1]:1;
                            if($yk > 0){
                                if($type == 1 && $totalbalance >= $yk){
                                    OutbetSite::where('id',$site['id'])->update(['enabled'=>0]);
                                }
                                if($type == 2 && $totalbalance < $yk){
                                    OutbetSite::where('id',$site['id'])->update(['enabled'=>0]);
                                }
                            }
                            if($yk < 0){
                                if($type == 1 && $totalbalance <= $yk){
                                    OutbetSite::where('id',$site['id'])->update(['enabled'=>0]);
                                }
                            }
                        }
                    }
                }
            }
            //公式投检测
            $complexsitelsit = OutbetSite::where(['enabled'=>1,'is_gentoumode'=>2])->get();
            foreach ($complexsitelsit as $site){
                $complex_money  = $site['complex_money'];
                $fj_qishu = $site['fj_qishu'];
                $other_pz = $site['other_pz'];
                $other_pz_arr = explode('|',$other_pz);
                $mode = isset($other_pz_arr[0]) ? $other_pz_arr[0] : 1;
                if($site['enabled'] == 1 && $site['online'] == 1){
                    $gids = explode(',',$site['gids']);
                    foreach ($gids as $gid){
                        $game = Game::where('gid',$gid)->select(['fenlei','gid','panstatus','thisqishu'])->first();
                        if($game['thisqishu'] == $site['cur_qishu']){
                            continue;
                        }
                        $cl = ComFunc::getzlong($game['fenlei'],$game['gid'],2);
                        //翻转
                        $cl = array_reverse($cl);
                        $newcl = [];
                        foreach ($cl as $item){
                            if($mode == 1){
                                if($item['qishu'] == 2){
                                    $newcl[] = $item;
                                    continue;
                                }
                            }elseif ($mode == 2 || $mode == 3){
                                if($item['qishu'] == $fj_qishu){
                                    $newcl[] = $item;
                                }
                            }
                        }
                        if(($mode == 1 && count($newcl) > 0 && $game['panstatus'] == 1) || ($mode == 2 && count($newcl) > 2 && $game['panstatus'] == 1) || ($mode == 3 && count($newcl) > 0 && $game['panstatus'] == 1)){
                           
                        }
                    }
                }
            }
        }
        //缓存
        Cache::set($key, 1, 10);
    }
}
