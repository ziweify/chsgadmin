<?php

namespace App\Common\Queue;

use App\ort\services\AutosService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateKjdataQueue implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable;
    private $param;
    public function __construct($param){
        $this->param = $param;
    }

/*    public function uniqueId(){
        return $this->param['gid'];
    }*/

    public function handle(){
        $gid = $this->param['gid'];
        $stopstatus = $this->param['stopstatus'];
        try {
            AutosService::create_kjdata($gid,$stopstatus);
        }catch (\Exception $e){
            Log::error("【投注站】【CreateKjdataQueue{$gid}】创建开奖数据队列异常：".$e->getMessage());
        }
        if(env('IS_DEBUG_INFO')) {
            Log::info("【投注站】【CreateKjdataQueue{$gid}】创建开奖数据队列成功");
        }
    }
}
