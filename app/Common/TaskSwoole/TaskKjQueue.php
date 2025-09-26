<?php

namespace App\Common\TaskSwoole;

use App\ort\services\AutoKjsService;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Log;

class TaskKjQueue extends Task
{
    protected $gid;

    public function __construct($gid){
        $this->gid = $gid;
    }

    public function handle(){
        try {
            AutoKjsService::kj($this->gid,0);
        }catch (\Exception $e){
            Log::info("开奖结算异常：".$e->getMessage().$e->getTraceAsString());
        }
    }
}
