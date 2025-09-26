<?php

namespace App\Common\TaskSwoole;

use App\ort\services\AutosService;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Log;

class GameCountdownQueue extends Task
{
    protected $gid;

    public function __construct($gid){
        $this->gid = $gid;
    }

    public function handle(){
        try {
            //Log::info("当前系统时间：".date('Y-m-d H:i:s',time()));
            AutosService::fast_create_data($this->gid,0);
        }catch (\Exception $e){
            Log::info($e->getMessage().$e->getTraceAsString());
        }
    }

   /* public function finish(){
        Log::info("任务完成时间：".date('Y-m-d H:i:s',time()));
    }*/
}
