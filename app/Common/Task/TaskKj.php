<?php

namespace App\Common\Task;

use App\Common\TaskSwoole\TaskKjQueue;
use App\Models\Game\Game;
use App\ort\services\AutoKjsService;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Swoole\Coroutine;

class TaskKj extends CronJob
{
    public function interval(){
        return 4000;
    }

    public function isImmediate(){
        return false;
    }

    public function run(){
        /*for($i = 1;$i <= 5;$i++){
            Task::deliver(new TaskKjQueue($i));
            //KjQueue::dispatch(['type'=>'tzz','group'=>$i]);
        }*/
        $gids = Cache::get('gids_list');
        if(empty($gids)){
            $gids = Game::where(['ifopen'=>1])->pluck('gid')->toArray();
            Cache::put('gids_list', $gids);
        }
        foreach ($gids as $gid){
            Task::deliver(new TaskKjQueue($gid));
            /*try {
                AutoKjsService::kj($gid,0);
            }catch (\Exception $e){
                Log::info("TaskKj:".$e->getTraceAsString().$e->getMessage());
            }*/
        }
    }
}
