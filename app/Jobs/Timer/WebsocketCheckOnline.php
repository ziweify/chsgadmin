<?php

namespace App\Jobs\Timer;

use App\Common\TaskSwoole\CommonQueue;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

//聊天室在线检测清理
class WebsocketCheckOnline extends CronJob
{
    public function interval(){
        return 20 * 1000; // 每30秒运行一次
    }

    public function isImmediate(){
        return false; // 是否立即执行第一次，false则等待间隔时间后执行第一次
    }

    public function run(){
        Task::deliver(new CommonQueue(['type'=>'checkonline']));
    }
}
