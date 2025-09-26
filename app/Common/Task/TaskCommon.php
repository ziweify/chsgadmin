<?php

namespace App\Common\Task;

use App\Common\TaskSwoole\CommonQueue;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

class TaskCommon extends CronJob
{
    public function interval(){
        return 10000;
    }

    public function isImmediate(){
        return false;
    }

    public function run(){
        Task::deliver(new CommonQueue(['type'=>'taskcommon']));
    }
}
