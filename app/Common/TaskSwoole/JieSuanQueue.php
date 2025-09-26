<?php

namespace App\Common\TaskSwoole;

use App\Models\Game\Userroom;
use App\ort\common\CsFunc;
use Hhxsv5\LaravelS\Swoole\Task\Task;

class JieSuanQueue extends Task
{
    protected $param;
    public function __construct($param)
    {
        $this->param = $param;
    }

    public function handle(){
        $gid = $this->param['gid'];
        $qishu = $this->param['qishu'];
        $isNotice = $this->param['isNotice'];
        $kjhm = $this->param['kjhm'];
        $mnum = $this->param['mnum'];
        $fenlei = $this->param['fenlei'];
        $gname = $this->param['gname'];
        //$cs = $this->param['cs'];
        $ztype = $this->param['ztype'];
        $mtype = $this->param['mtype'];
        //$roomConfig = $this->param['roomConfig'];

        $roomConfigList = Userroom::where(['roomStatus'=>1])->select(['userid','roomAvatar','roomNickname','orderSummaryDisplay','currentDrawImage','latestDrawImage','longDragonDataImage','lowScoreNoBillMessage','betUserCreditOnly','lowScoreNoBillMessage'])->get()->toArray();
        foreach ($roomConfigList as $roomConfig){
            $ruid = $roomConfig['userid'];
            $isopenresult = 1;//
            //进行结算操作
            $res = CsFunc::calc($fenlei,$gid,$kjhm,$qishu,$ztype,$mtype,$ruid,$roomConfig);
            //发送结算通知
            if($isNotice == 1){
                $p = [];
                $p['type']  = 'winnerListAfterSettlement';
                $p['gid'] = $gid;
                $p['qishu'] = $qishu;
                $p['gname'] = $gname;
                $p['roomConfig'] = $roomConfig;
                $p['result'] = $res['result'];
                $p['isopenresult'] = $isopenresult;//
                (new CommonQueue($p))->handle();
            }
            //发送开奖通知
            if(($fenlei == 101 || $fenlei == 107 || $fenlei == 444) && $isNotice == 1){
                $isopenresult = 0;
                $p = [];
                $p['type']  = 'sendKjNotice';
                $p['gid'] = $gid;
                $p['period'] = $qishu;
                $p['open_num'] = $kjhm;
                $p['mnum'] = $mnum;
                $p['roomConfig'] = $roomConfig;
                (new CommonQueue($p))->handle();
            }
        }
    }
}
