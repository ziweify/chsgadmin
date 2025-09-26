<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    protected function shortSchedule(\Spatie\ShortSchedule\ShortSchedule $shortSchedule){
        //快开彩数据生成及开奖信息更新
        $shortSchedule->command("command:taskfastdata")->runInMaintenanceMode()->withoutOverlapping()->everySecond(3);
        //慢开彩数据生成及开奖信息更新
        //$shortSchedule->command("command:tasknofastdata")->runInMaintenanceMode()->withoutOverlapping()->everySecond(5);
        //开奖任
        for($i = 1;$i <= 4;$i++){
            $shortSchedule->command("command:taskkj {$i}")->runInMaintenanceMode()->withoutOverlapping()->everySecond(8);
        }
        //开奖结束事件
        $shortSchedule->command("command:taskkjendevent")->runInMaintenanceMode()->withoutOverlapping()->everySecond(5);
        //自动降赔
        //$shortSchedule->command("command:taskautoattpeilv")->runInMaintenanceMode()->withoutOverlapping()->everySecond(3);
        //公共任务
        $shortSchedule->command("command:taskcommon")->runInMaintenanceMode()->withoutOverlapping()->everySecond(10);

        //开奖网数据生成任务
        $kjw_is_run = x_config('kjw_is_run');
        if($kjw_is_run == 1){//是否开启开奖网数据生成任务
            $shortSchedule->command("command:taskkjwcreatedata")->runInMaintenanceMode()->withoutOverlapping()->everySecond(30);
            //开奖任务
            for($i = 1;$i <= 4;$i++){
                $shortSchedule->command("command:taskkjwkj {$i}")->runInMaintenanceMode()->withoutOverlapping()->everySecond(3);
            }
            $shortSchedule->command("command:taskkjwkj 5")->runInMaintenanceMode()->withoutOverlapping()->everySecond(30);
        }
    }
}
