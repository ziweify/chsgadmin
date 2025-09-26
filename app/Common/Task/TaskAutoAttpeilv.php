<?php

namespace App\Common\Task;

use App\Models\Game\Game;
use App\ort\common\AdminFunc;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;
use Illuminate\Support\Facades\Log;

class TaskAutoAttpeilv extends CronJob
{
    public function interval(){
        return 3000;
    }

    public function isImmediate(){
        return false;
    }

    public function run(){
        $comattpeilv = x_config('comattpeilv',0);
        if($comattpeilv==0){
            return;
        }
        $game = Game::where(['ifopen'=>1])->select(['gid','panstatus'])->get();
        foreach ($game as $item){
            if($item['panstatus'] == 1){
                try {
                    AdminFunc::attpeilvs($item['gid']);
                }catch (\Exception $e){
                    Log::error("【投注站】自动降赔错误,gid:{$item['gid']}：".$e->getMessage());
                }
            }
        }
        if(env('IS_DEBUG_INFO')) {
            Log::debug('【投注站】【TaskAutoAttpeilv】自动降赔结束');
        }
    }
}
