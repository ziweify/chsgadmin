<?php

namespace App\Common\Queue;

use App\ort\services\FollowPlanService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * 跟投任务队列
 */
class FollowPlanQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $param;

    public function __construct($param){
        $this->param = $param;
    }

    public $tries = 2;

    public function handle(){
        $param= $this->param;
        try{
            (new FollowPlanService())->bet($param);
        }catch (\Exception $e){
            Log::error("【投注站】【FollowPlanQueue】跟投队列异常：" . $e->getMessage() . '，参数：' . json_encode($this->param));
        }
        if(env('IS_DEBUG_INFO')) {
            Log::info("【投注站】【FollowPlanQueue】跟投队列成功");
        }
    }

    /*public function failed(\Exception $exception){
        Log::error('跟投队列执行失败：'.$exception->getMessage().'，参数：'.json_encode($this->param));
    }*/
}
