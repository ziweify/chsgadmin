<?php

namespace App\ort\sgwin;

//公式投服务
use App\Http\Controllers\Api\Member\DoubleCommonService;
use App\Models\Game\Complex;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Swoole\Coroutine;

class ComplexService
{
    public function handle(){
        $complexlist = Complex::where(['enabled'=>1])->get()->toArray();
        foreach ($complexlist as $complex){
            //开启独立协程
            Coroutine::create(function () use ($complex) {
                $game  = Game::where(['gid'=>$complex['gid']])->select(['template','thisqishu','userclosetime'])->first();
                if($game['thisqishu'] == $complex['cur_qishu']){
                    return;
                }
                $user = User::where(['userid'=>$complex['userid']])->select(['userid','kmoney','status'])->first();
                if($user['kmoney'] < 1 || $user['status'] != 0){
                    Complex::where(['id'=>$complex['id']])->update(['enabled'=>0]);
                    return;
                }
                //止损金额
                if($complex['stoploss'] > 0){
                    $stoploss = $complex['stoploss'];
                    //获取今日输赢
                    $jrsy = $this->get_jrsy($user['userid'],$complex['id']);
                    if($jrsy <= -$stoploss){
                        Complex::where(['id'=>$complex['id']])->update(['enabled'=>0]);
                        return;
                    }
                }
                //止盈金额
                if($complex['takeprofit'] > 0){
                    $takeprofit = $complex['takeprofit'];
                    //获取今日输赢
                    $jrsy = $this->get_jrsy($user['userid'],$complex['id']);
                    if($jrsy >= $takeprofit){
                        Complex::where(['id'=>$complex['id']])->update(['enabled'=>0]);
                        return;
                    }
                }
                $lottery = $complex['lottery'];
                $drawNumber = $game['thisqishu'];
                $kj = Kj::where(['gid'=>$complex['gid'],'qishu'=>$drawNumber])->select(['opentime','closetime'])->first();
                $time = time();
                if (empty($kj) || $time >= ($kj['closetime'] - $game['userclosetime'])) {
                    return;
                }
                $userid = $user['userid'];
                $detail = json_decode($complex['detail'], true);
                $detail = SGUtils::parsecy($detail);
                $bets = [];$libmode = SGUtils::getcuremodel();
                foreach ($detail as $value){
                    $arr = explode('_',$value);
                    $bet = [];
                    if($complex['betMode'] == 0){//固定投注
                        $bet['amount'] = $complex['amount'];
                    }else{//翻倍投注
                        $amounts = explode(',',$complex['amount']);
                        if(!empty($complex['cur_qishu'])){
                            $zcount = $libmode->where(['userid'=>$userid,'gid'=>$complex['gid'],'qishu'=>$complex['cur_qishu'],'cy'=>$value,'z'=>1])->count('id');
                            $key = 'fb_'.$userid.'_'.$complex['gid'].'_'.$value;
                            $index = Cache::get($key) ?? 0;
                            if($complex['fbMode'] == 0){//中翻倍
                                if($zcount > 0){//中奖翻倍
                                    $mindex = $index + 1;
                                    $mindex = $mindex > count($amounts) - 1 ? count($amounts) - 1 : $mindex;
                                    $bet['amount'] = $amounts[$mindex];
                                    Cache::put($key, $mindex, 15*60);
                                }else{
                                    if($complex['fbbzMode'] == 0){//退回到第一金额
                                        $bet['amount'] = $amounts[0];
                                        Cache::put($key, 0, 15*60);
                                    }else{
                                        $mindex = $index > 0 ? $index-1 : 0;
                                        $mindex = $mindex > count($amounts) - 1 ? count($amounts) - 1 : $mindex;
                                        $bet['amount'] = $amounts[$mindex];
                                        Cache::put($key, $mindex, 15*60);
                                    }
                                }
                            }else{//不中翻倍
                                if ($zcount <= 0) {//不中奖翻倍
                                    $mindex = $index + 1;
                                    $mindex = $mindex > count($amounts) - 1 ? count($amounts) - 1 : $mindex;
                                    $bet['amount'] = $amounts[$mindex];
                                    Cache::put($key, $mindex, 15*60);
                                } else {
                                    if ($complex['fbbzMode'] == 0) {//退回到第一金额
                                        $bet['amount'] = $amounts[0];
                                        Cache::put($key, 0, 15*60);
                                    } else {
                                        $mindex = $index > 0 ? $index - 1 : 0;
                                        $mindex = $mindex > count($amounts) - 1 ? count($amounts) - 1 : $mindex;
                                        $bet['amount'] = $amounts[$mindex];
                                        Cache::put($key, $mindex, 15*60);
                                    }
                                }
                            }
                        }else{
                            $bet['amount'] = $amounts[0];
                        }
                    }
                    $bet['game'] = $arr[0];
                    $bet['contents'] = $arr[1];
                    $bet['odds'] = 0;
                    $bet['title'] = '';
                    $bets[] = $bet;
                }
                (new DoubleCommonService())->bet($bets,$lottery,$drawNumber,$userid,3,$complex['id']);
                Complex::where(['id'=>$complex['id']])->update(['cur_qishu'=>$drawNumber]);
            });
        }
    }

    public function get_jrsy($userid,$complexid){
        $table = SGUtils::getcuretable(true);
        $db = Db::connection();
        $rs = $db->select("select sum(je) as rb,sum(je*points/100) as rc from $table where userid='$userid' and uzp8='$complexid' and z not in (2,7,9)");
        $zje = $rs[0]['rb'] ?? 0;
        $points = $rs[0]['rc'] ?? 0;
        $rs = $db->select("select sum(peilv1*je) as ra,sum(prize) as rb,sum(uzp1*je) as rc from $table where userid='$userid' and uzp8='$complexid' and z=1 and bs=1");
        $ra = $rs[0]['ra'] ?? 0;
        $rb = $rs[0]['rb'] ?? 0;
        $rc = $rs[0]['rc'] ?? 0;
        $zhong = $ra - $rb - $rc;
        $yk = $zhong + $points - $zje;
        return ComFunc::pr1($yk);
    }
}
