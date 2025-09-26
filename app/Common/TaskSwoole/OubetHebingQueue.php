<?php

namespace App\Common\TaskSwoole;

use App\ort\services\AutoKjsService;
use App\ort\sgwin\OutbetServices;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Log;

class OubetHebingQueue extends Task
{
    protected $param;

    public function __construct($param){
        $this->param = $param;
    }

    public function handle(){
        try {
            $ruid = $this->param['ruid'];
            $gid = $this->param['gid'];
            $qishu = $this->param['qishu'];
            $outbetServices = new OutbetServices();
            $outbetServices->hebingbet($ruid,$gid,$qishu);
        }catch (\Exception $e){
            Log::info("飞单合并失败".$e->getMessage().$e->getTraceAsString());
        }
    }
}
