<?php

namespace App\Common\Task;

use App\Common\TaskSwoole\GameCountdownQueue;
use App\Models\Game\Game;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;
use Illuminate\Support\Facades\Cache;

//检测每期开奖和创建开奖数据
class TaskFastData extends CronJob
{
    public function interval(){
        return 1000;
    }

    public function isImmediate(){
        return false;
    }

    public function run(){
        /*try {
            AutosService::fast_create_data(0,1);
        }catch (\Exception $e){
            Log::error('【投注站】【TaskFastData1】数据生成及更新任务异常：'.$e->getMessage());
        }*/
        $gids = Cache::get('gids_list');
        if(empty($gids)){
            $gids = Game::where(['ifopen'=>1])->pluck('gid')->toArray();
            Cache::put('gids_list', $gids);
        }
        foreach ($gids as $gid){
            Task::deliver(new GameCountdownQueue($gid));
        }
    }
}
