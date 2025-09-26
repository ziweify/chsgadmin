<?php

namespace App\Common\TaskSwoole;

use App\ort\services\AutoKjsService;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class KJQueue extends Task
{
    protected $gid;

    public function __construct($gid)
    {
        $this->gid = $gid;
    }

    public function handle(){
        AutoKjsService::kj($this->gid,0);
    }

    public function finish(){

    }
}
