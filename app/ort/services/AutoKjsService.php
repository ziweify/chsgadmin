<?php


namespace App\ort\services;

use App\Common\TaskSwoole\CommonQueue;
use App\Common\TaskSwoole\JieSuanQueue;
use App\ComServices\BuilderResultImage;
use App\ComServices\GameServices;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\Userroom;
use App\ort\cachemodel\GameCache;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\HttpUtils;
use App\ort\sgwin\ReportService;
use App\ort\sgwin\SGUtils;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class AutoKjsService
{
    protected static $aomen_caiji_mode = 1;//澳门采集模式 1：自己的168开奖网 2：第三方官网
    protected static $xianggang_caiji_mode = 1;//香港采集模式 1：自己的168开奖网 2：第三方官网

    public static function kj($gid = 0,$taskgroup = 0,$kjurls = '',$isrp = 0){
        //redis锁检测
        $lock = "kj_lock_".$gid;
        $islock = Cache::get($lock);
        if(!empty($islock)){
            Log::info('开奖锁定中,gid:'.$gid.',taskgroup:'.$taskgroup.',kjurls:'.$kjurls.',isrp:'.$isrp);
            return ;
        }
        //缓存锁
        Cache::put($lock, 1, 15);
        if(empty($kjurls)){
            $kjurls = x_config('kjip','');
        }
        $kjurlarray = explode(',',$kjurls);
        $kjurl = $kjurlarray[random_int(0,count($kjurlarray)-1)];
        $db = Db::connection();
        $fields = ['lotCode','cs','mtype','ztype','gid','fast','mnum','fenlei','ifopen','autokj','guanfang','ctype','gname'];
        $cachekey = 'w';
        $model = Game::where(['autokj'=>1,'ifopen'=>1]);$where = ['autokj'=>1,'ifopen'=>1];
        if($gid > 0){
            $model = $model->where('gid',$gid);
            $cachekey .= $gid;
            $where['gid'] = $gid;
        }
        if($taskgroup > 0){
            $model = $model->where('taskgroup',$taskgroup);
            $cachekey .= $taskgroup;
            $where['taskgroup'] = $taskgroup;
        }
        $gamelist = GameCache::getgamecachebywhere($cachekey,$where);//先从缓存中获取
        if(empty($gamelist)){
            $gamelist = $model->select($fields)->get();
        }
        $dates = ComFunc::getthisdate();
        $dstr = str_replace('-','',$dates);
        foreach ($gamelist as $game) {
            $gid = $game['gid'];
            $fenlei = $game['fenlei'];
            $lotCode = $game['lotCode'];
            $mnum = $game['mnum'];
            $kj = Kj::where(['gid' => $gid,'dates'=>strtotime($dates)])->where('kjtime','<',time())->orderByDesc('qishu')->first();
            if(empty($kj)){
                continue;
            }
            if($kj && $kj['status'] == 1 && $kj['m1'] != ''){
                continue;
            }
            $qishu = $kj['qishu'];$kjhm = [];
            $updatesearchqishustatus = 0;
            if($kj['m1'] != ''){
                $updatesearchqishustatus = 1;
                //更新状态1
                Kj::where(['gid'=>$gid,'qishu'=>$qishu])->update(['status'=>1]);
            }
            if ($game['fast'] == 0 && $updatesearchqishustatus == 0) {//低频彩
                
            } else {
                //系统开奖
                $cs = json_decode($game['cs'], true);
                if ($game['guanfang'] == 1 && $cs['cjmode'] == 1) {//系统开奖
                    if($kj['status'] == 0 && $kj['m1'] == ''){
                        $mtype = json_decode($game['mtype'], true);
                        $ztype = json_decode($game['ztype'], true);
                        $ms = CsFunc::calcmoni($fenlei, $gid, $cs, $kj['qishu'], $mnum, $ztype, $mtype);
                        if (!is_array($ms)) {
                            $ms = explode(',', $ms);
                        }
                        if (!is_numeric($ms[0]) || !is_numeric($ms[$mnum - 1])) {
                            continue;
                        }
                    }else{
                        $ms = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $ms[] = $kj['m'.$i];
                            $kjhm[] = intval($kj['m'.$i]);
                        }
                    }
                    $save = [];
                    for ($i = 1; $i <= $mnum; $i++) {
                        $save['m'.$i] = $ms[$i-1];
                        $kjhm[] = intval($ms[$i-1]);
                    }
                    $save['status'] = 1;
                    Kj::where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                    $updatesearchqishustatus = 1;
                } else {
                    if($gid == 444 && $updatesearchqishustatus == 0){//台湾宾果
                        $kjurl = "https://api.taiwanlottery.com/TLCAPIWeB/Lottery/LatestBingoResult";
                        //$ishttps = strpos($kjurl,'https') !== false ? 1 : 0;
                        //$ma = CsFunc::curl_get($ishttps, $kjurl);
                        $res = HttpUtils::request('GET',$kjurl,[],[],false,0,'');
                        $ma = $res['data'];
                        //Log::info('台湾宾果开奖数据:'.$ma);
                        $ma = json_decode($ma, true);
                        if(isset($ma['content'])){
                            $openlist = $ma['content']['lotteryBingoLatestPost']['openShowOrder'];
                            $m = array_slice($openlist,0,5);
                            $qishu = $ma['content']['lotteryBingoLatestPost']['drawTerm'];
                            if(is_array($m)){
                                $save = [];
                                for ($i = 1; $i <= $mnum; $i++) {
                                    $kjhm[] = intval($m[$i-1]);
                                    $save['m'.$i] = $m[$i-1];
                                }
                                $save['status'] = 1;
                                Kj::where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                                if($qishu == $kj['qishu']){
                                    $updatesearchqishustatus = 1;
                                }
                            }
                        }
                    }elseif($updatesearchqishustatus == 0){
                        $f168 = 0;
                        if($fenlei == 107){$f168 = 1;$url = $kjurl.'pks/getLotteryPksInfo.do?lotCode='.$lotCode;}//赛车系列
                        if($fenlei == 121){$f168 = 1;$url = $kjurl.'ElevenFive/getElevenFiveInfo.do?lotCode='.$lotCode;}//11选5系列
                        if($fenlei == 103){$f168 = 1;$url = $kjurl.'klsf/getLotteryInfo.do?lotCode='.$lotCode;}//快乐十分系列
                        if($fenlei == 101){$f168 = 1;$url = $kjurl.'CQShiCai/getBaseCQShiCai.do?lotCode='.$lotCode;}//时时彩系列
                        if($gid == 200){$f168 = 1;$url = $kjurl.'speedSix/findSpeedSixInfo.do?lotCode='.$lotCode;}
                        if($fenlei == 161){$f168 = 1;$url = $kjurl.'LuckTwenty/getBaseLuckTewnty.do?lotCode='.$lotCode;}//幸运20系列
                        if($fenlei == 163){$f168 = 1;$url = $kjurl.'LuckTwenty/getPcLucky28.do?issue=&lotCode='.$lotCode;}//PC蛋蛋系列
                        if($fenlei == 151){$f168 = 1;$url = $kjurl.'lotteryJSFastThree/getBaseJSFastThree.do?lotCode='.$lotCode;}//快三系列
                        if($f168 == 1){
                            if($kj['status'] == 0 && $kj['m1'] == ''){
                                if($gid == 616){//波场时时彩
                                    $kjurl = 'https://bc-api.bc1880.com/latestWithAnalysis?code=tron';
                                    //$ma = CsFunc::curl_get(1, $kjurl);
                                    $res = HttpUtils::request('GET',$kjurl,[],[],false,0);
                                    if($res['code'] == 0){
                                        Log::info('单期获取开奖数据失败,gid:'.$gid.',url:'.$url.',msg:'.$res['msg']);
                                        return ;
                                    }
                                    $ma = json_decode($res['data'], true);
                                    if(empty($ma)){
                                        Log::info('单期获取开奖数据失败,gid:'.$gid.',url:'.$url.',msg:返回数据为空');
                                        return ;
                                    }
                                    $m = explode(',', $ma['number']);
                                    if(is_array($m)){
                                        $qishu = $ma['drawNumber'];
                                        $save = [];
                                        for ($i = 1; $i <= $mnum; $i++) {
                                            $save['m'.$i] = $m[$i-1];
                                            $kjhm[] = intval($m[$i-1]);
                                        }
                                        $save['status'] = 1;
                                        Kj::where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                                        if($qishu == $kj['qishu']){
                                            $updatesearchqishustatus = 1;
                                        }
                                    }
                                }else{
                                    //$ishttps = strpos($kjurl,'https') !== false ? 1 : 0;
                                    //$ma = CsFunc::curl_get($ishttps, $url);
                                    $start = time();
                                    $res = HttpUtils::request('GET',$url,[],[],false);
                                    $end = time();
                                    //Log::info('单期获取开奖数据,gid:'.$gid.',url:'.$url.',耗时:'.($end-$start));
                                    $ma = json_decode($res['data'], true);
                                    if(empty($ma)){//获取失败
                                        Log::info('单期获取开奖数据失败,gid:'.$gid.',url:'.$url.',msg:'.$res['msg']);
                                        //切换url在获取一次
                                        if($isrp == 0){
                                            //释放锁
                                            Cache::delete($lock);
                                            $by_kj_api = env('BEIYONG_KJ_API','https://1689410.com/api/');
                                            self::kj($gid,$taskgroup,$by_kj_api,1);
                                        }
                                        return ;
                                    }
                                    if(empty($ma)){
                                        Log::info('单期获取开奖数据失败,gid:'.$gid.',url:'.$url.',msg:返回数据为空');
                                        return ;
                                    }
                                    if(isset($ma['result']['data']['preDrawCode'])){
                                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                                        if(is_array($m)){
                                            $qishu = $ma['result']['data']['preDrawIssue'];
                                            $save = [];
                                            for ($i = 1; $i <= $mnum; $i++) {
                                                $save['m'.$i] = $m[$i-1];
                                                $kjhm[] = intval($m[$i-1]);
                                            }
                                            $save['status'] = 1;
                                            Kj::where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                                            if($qishu == $kj['qishu']){
                                                $updatesearchqishustatus = 1;
                                            }
                                        }
                                    }
                                }
                            }else{
                                $kjwsave = [];
                                for ($i = 1; $i <= $mnum; $i++) {
                                    $kjwsave['m'.$i] = $kj['m'.$i];
                                    $kjhm[] = intval($kj['m'.$i]);
                                }
                                $save['status'] = 1;
                                Kj::where(['gid'=>$gid,'qishu'=>$kj['qishu']])->update($save);
                                $updatesearchqishustatus = 1;
                            }
                        }
                    }
                }
            }

            //通知所有客户端已开奖
            if($updatesearchqishustatus == 1){
                Game::where(['gid'=>$gid])->update(['kjqishu'=>$qishu]);
                //生成开奖图片
                if($fenlei == 101 || $fenlei == 107 || $fenlei == 444){
                    try {
                        if($fenlei == 101 || $fenlei == 107){
                            $openinfo = [];
                            $openinfo['open_num'] = $kjhm;
                            $openinfo['period'] = $kj['qishu'];
                            $openinfo['this_time'] = date('Y-m-d H:i:s',$kj['kjtime']);
                            if($fenlei == 101){//时时彩类获取下一期
                                $nextkj = SGUtils::nextPeriod($gid,$kj['qishu']);
                                if(!empty($nextkj)){
                                    $openinfo['next_time'] = date('H:i:s',$nextkj['kjtime']);
                                }else{
                                    $openinfo['next_time'] = "00:00:00";
                                }
                            }
                            BuilderResultImage::doSaveOpenImg($gid,$fenlei,$openinfo,$game['ctype'],'open','open','',$dstr);
                        }
                        $count = 20;
                        $fenlei == 444 && $count = 31;
                        $openlist = (new GameServices())->lastOpenDataList($gid,$fenlei,$mnum,$count);
                        BuilderResultImage::doSaveOpenImg($gid,$fenlei,$openlist,$game['ctype'],'openlist','openlist',$kj['qishu'],$dstr);
                    }catch (\Exception $e){
                        Log::info("gid：{$gid}qishu：{$kj['qishu']}生成开奖图片失败：{$e->getMessage()}".$e->getTraceAsString());
                    }
                }

                $mtype = json_decode($game['mtype'], true);
                $ztype = json_decode($game['ztype'], true);
                $cs = json_decode($game['cs'], true);
                $param = [];
                $param['gid'] = $gid;
                $param['qishu'] = $kj['qishu'];
                $param['isNotice'] = 1;
                $param['kjtime'] = $kj['kjtime'];
                $param['kjhm'] = $kjhm;
                $param['mnum'] = $mnum;
                $param['fenlei'] = $fenlei;
                $param['gname'] = $game['gname'];
                $param['cs'] = $cs;
                $param['mtype'] = $mtype;
                $param['ztype'] = $ztype;
                //$param['roomConfig'] = $roomConfig;
                Task::deliver(new JieSuanQueue($param));
            }
            //结算
            /*$qishulist = Kj::where(['gid'=>$gid,'dates'=>strtotime($dates),'status'=>1,'js'=>0])->pluck('qishu')->toArray();
            if(count($qishulist) > 0){
                Log::info("结算开始->【{$game['gid']}】【{$qishu}】【count:" . count($qishulist) . "】【qishus:" . implode(',', $qishulist) . "】");
                //结算
                $mtype = json_decode($game['mtype'], true);
                $ztype = json_decode($game['ztype'], true);
                foreach ($qishulist as $qi){
                    CsFunc::calc($game['fenlei'], $game['gid'], $cs, $qi, $game['mnum'], $ztype, $mtype);
                }
            }*/
            //AutosService::checkreport($gid);
            Cache::delete($lock);
            if($updatesearchqishustatus == 1){
                //生成预测
                $key = 'yc_kj_'.$gid;
                $yckj = SGUtils::createPredictInfo($game['fenlei']);
                Redis::setex($key, 1200, json_encode($yckj));
                //长龙
                Cache::set('sqishu_'.$gid,$kj['qishu'],86400);
                SearchqishuService::searchqishu($gid, 50, 1,$game['fenlei']);
                //清理缓存
                //Cache::delete("dayresult".$game['gid'].$dates.'1');//今日开奖缓存
            }
        }
        //释放锁
        Cache::delete($lock);
    }

    public static function seachqihao(){
        $game = Game::where(['ifopen' => 1])->select(['gid','fenlei','fast','thisqishu'])->get();
        $db = Db::connection();
        $autoresetpl = x_config('autoresetpl');
        foreach ($game as $item){
            $gid = $item['gid'];
            $f = Cache::get('sqishu_'.$gid);
            if(!empty($f)){
                //六合彩赔率还原
                if ($autoresetpl == 1 && $item['fast'] == 0) {
                    $db->update("update x_play set peilv1=mp1,peilv2=mp2,pl=mpl,ystart=0,yautocs=0,start=0,autocs=0 where gid='{$gid}'");
                    $db->update("update x_play_user set peilv1=mp1,peilv2=mp2,pl=mpl,ystart=0,yautocs=0,start=0,autocs=0 where gid='{$gid}'");
                }
                Cache::delete('sqishu_'.$item['gid']);
            }
        }
    }

    public static function jiesuan($gid = 0){
        $editstart = x_config('editstart');
        $db = Db::connection();
        if (date("His") < str_replace(':', '', $editstart)) {
            $dates = date("Y-m-d", time() - 86400);
        } else {
            $dates = date("Y-m-d");
        }
        $model = Game::where(['ifopen' => 1]);
        if($gid > 0){
            $model->where('gid',$gid);
        }
        $game = $model->select(['gid','mnum','fenlei'])->get();
        //结算开始
        $js = 0;
        $jarr = [];
        foreach ($game as $v) {
            $gid = $v['gid'];
            $timekj = time();
            $date = strtotime($dates);
            $rs1 = $db->select("select qishu from x_kj where gid='{$gid}' and dates='{$date}' and kjtime<='{$timekj}' and js=0 and status=1 order by qishu desc limit 5");
            if (count($rs1) > 0) {
                $ga = Game::where('gid',$gid)->select(['cs','fenlei','mtype','ztype'])->first();
                $cs = json_decode($ga['cs'], true);
                $mtype = json_decode($ga['mtype'], true);
                $ztype = json_decode($ga['ztype'], true);
                foreach ($rs1 as $v1) {
                    $ms = CsFunc::calc($v['fenlei'], $v['gid'], $cs, $v1['qishu'], $v['mnum'], $ztype, $mtype);
                    $js = 1;
                    $jarr[] = $v['gid'];
                }
            }
        }
        if ($js == 1 && date("H") != 6) {
            AdminFunc::jiaozhengedu();
            foreach ($jarr as $v){
                ReportService::zhengli_day_report('',$v,0,0);
            }
        }
    }


    public static function loadhistorykjdata($date,$gid,$force,$kjurls = '',$isjs = 0,$isrp = 0){
        if(empty($kjurls)){
            $kjurls = x_config('kjip','https://api.api68.com/');
        }
        $kjurlarray = explode(',',$kjurls);
        $kjurl = $kjurlarray[random_int(0,count($kjurlarray)-1)];
        $game = Game::where('gid',$gid)->select(['gid','mnum','fenlei','fast','lotCode','thisbml','mtype','ztype','gname'])->first();
        $gid = $game['gid'];
        $lotCode = $game['lotCode'];
        $url = '';
        $roomConfigList = Userroom::where(['roomStatus'=>1])->where('expiryDate','>=',time())->select(['userid','roomAvatar','roomNickname','orderSummaryDisplay','currentDrawImage','latestDrawImage','longDragonDataImage','lowScoreNoBillMessage'])->get()->toArray();
        if($game['fast'] != 0){//快开
            if($game['fenlei'] == 107){//赛车系列
                $url = $kjurl."pks/getPksHistoryList.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 101){
                $url = $kjurl."CQShiCai/getBaseCQShiCaiList.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 121){
                $url = $kjurl."ElevenFive/getElevenFiveList.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 103){
                $url = $kjurl."klsf/getHistoryLotteryInfo.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 151){
                $url = $kjurl."lotteryJSFastThree/getJSFastThreeList.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 161 || $gid == 444){
                $url = $kjurl."LuckTwenty/getBaseLuckTwentyList.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 163){
                $url = $kjurl."LuckTwenty/getPcLucky28List.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 100){//极速六合彩
                $url = $kjurl."speedSix/findSpeedSixHistory.do?type=1&date=$date";
            }
            if($game['gid'] == 616){//波
                $url = "https://bc-api.bc1880.com/ssc/analysis/list?code=tron&day=$date";
            }
            if($game['gid'] == 444){//台湾宾果
                $url = "https://api.taiwanlottery.com/TLCAPIWeB/Lottery/BingoResult?openDate={$date}&pageNum=1&pageSize=203";
            }
            if(empty($url)){
                return ;
            }
            /*$ishttps = strpos($kjurl,'https') !== false ? 1 : 0;
            if($ishttps == 1){
                $ma = CsFunc::curl_get($ishttps, $url);
            }else{
                $ishttps = strpos($url,'https') !== false ? 1 : 0;
                $ma = CsFunc::curl_get($ishttps,$url);
            }*/
            $res = HttpUtils::request('GET',$url,[],[],false,0,'');
            if($res['code'] == 0){//获取失败
                Log::info('获取开奖数据失败,gid:'.$gid.',url:'.$url.',msg:'.$res['msg']);
                if($game['gid'] != 616){
                    //切换url在获取一次
                    if($isrp == 0){
                        $by_kj_api = env('BEIYONG_KJ_API','https://1689410.com/api/');
                        self::loadhistorykjdata($date,$gid,$force,$by_kj_api,$isjs,1);
                    }
                }
                return;
            }
            $ma = json_decode($res['data'], true);
            if(empty($ma)){
                Log::info('获取开奖数据失败,gid:'.$gid.',url:'.$url.',msg:返回数据为空');
                return ;
            }
            if($gid == 616){
                $list = $ma;
            }elseif($gid == 444){
                $list = $ma['content']['bingoQueryResult'];
            }else{
                $list = $ma['result']['data'];
                if(isset($list['bodyList'])){
                    $list = $list['bodyList'];
                }
            }
            foreach ($list as $item){
                $where = [];
                if (($force == 0)){
                    $where['status'] = 0;
                }
                if($gid == 616) {
                    $issue = $item['drawNumber'];
                }elseif($gid == 444) {
                    $issue = $item['drawTerm'];
                }else{
                    $issue = $game['fenlei'] == 100 ? $item['issue'] : $item['preDrawIssue'];
                }
                $cc = Kj::where(['qishu'=>$issue,'gid'=>$gid])->where($where)->count('id');
                if($cc > 0){
                    $kjhm = [];
                    if($gid == 616){
                        $qiuarr = explode(',',$item['number']);
                    }elseif($gid == 444){
                        $qiuarr = $item['openShowOrder'];
                    }else{
                        $qiuarr = explode(',',$item['preDrawCode']);
                    }
                    for($i = 1;$i <= $game['mnum'];$i++){
                        $kjhm[] = intval($qiuarr[$i-1]);
                        $updat['m'.$i] = $qiuarr[$i-1].'';
                    }
                    $updat['status'] = 1;
                    Kj::where(['qishu'=>$issue,'gid'=>$gid])->update($updat);

                    //是否需要结算
                    if($isjs == 1){
                        $mtype = json_decode($game['mtype'], true);
                        $ztype = json_decode($game['ztype'], true);
                        foreach ($roomConfigList as $roomConfig){
                            //进行结算操作
                            $res = CsFunc::calc($game['fenlei'],$gid,$kjhm,$issue,$ztype,$mtype,$roomConfig['userid'],$roomConfig);
                        }
                    }
                }
            }
        }elseif ($game['fast'] == 0){
            if($gid == 311){//台湾大乐透
                $url = $kjurl."taiWanCai/getHistoryLotteryInfo.do?lotCode=$lotCode&date=".date('Y-m-d');
                $ma = CsFunc::curl_get(1, $url);
                $ma = json_decode($ma, true);
                $list = $ma['result']['data'];
                foreach ($list as $item){
                    $c = Kj::where(['gid'=>$gid,'qishu'=>$item['preDrawIssue']])->first();
                    if(empty($c)){
                        $kjsave = [];
                        $qiuarr = explode(',',$item['preDrawCode']);
                        for($i = 1;$i <= $game['mnum'];$i++){
                            $kjsave['m'.$i] = $qiuarr[$i-1].'';
                        }
                        $ddd = date('Y-m-d',strtotime($item['preDrawTime']));
                        $kjsave['gid'] = $gid;
                        $kjsave['dates'] = strtotime($ddd);
                        $kjsave['qishu'] = $item['preDrawIssue'];
                        $kjsave['opentime'] = strtotime($ddd.' 17:00:00');
                        $kjsave['closetime'] = strtotime($ddd.' 21:30:00');
                        $kjsave['status'] = 1;
                        $kjsave['baostatus'] = 1;
                        $kjsave['js'] = 1;
                        $kjsave['kjtime'] = strtotime($ddd.' 21:35:00');
                        Kj::create($kjsave);
                    }else{
                        if($c['status'] == 0 || $force == 1){
                            $qiuarr = explode(',',$item['preDrawCode']);
                            $updat = [];
                            for($i = 0;$i < count($qiuarr);$i++){
                                $updat['m'.($i+1)] = $qiuarr[$i].'';
                            }
                            $updat['status'] = 1;
                            Kj::where('id',$c['id'])->update($updat);
                        }
                    }
                }
            }elseif ($gid == 100){//香港六合彩
                $url = "https://1680660.com/smallSix/findSmallSixHistory.do?type=1&year=".$date;
                $ma = CsFunc::curl_get(1, $url);
                $ma = json_decode($ma, true);
                $list = $ma['result']['data']['bodyList'];
                if(is_array($list)){
                    foreach ($list as $item){
                        $issue = intval($item['issue']);
                        if($issue > 9 && $issue <= 99){
                            $issue = '0'.$issue;
                        }
                        if($issue <= 9){
                            $issue = '00'.$issue;
                        }
                        $issue = date('Y',strtotime($item['preDrawDate'])).$issue;
                        $c = Kj::where(['gid'=>$gid,'qishu'=>$issue])->first();
                        if(empty($c)){
                            $kjsave = [];
                            $qiuarr = explode(',',$item['preDrawCode']);
                            for($i = 0;$i < count($qiuarr);$i++){
                                $is = intval($qiuarr[$i]);
                                if($is <= 9){
                                    $is = '0'.$is;
                                }
                                $kjsave['m'.($i+1)] = $is;
                            }
                            $kjsave['gid'] = $gid;
                            $kjsave['dates'] = strtotime($item['preDrawDate']);
                            $kjsave['qishu'] = $issue;
                            $kjsave['opentime'] = strtotime($item['preDrawDate'].' 17:00:00');
                            $kjsave['closetime'] = strtotime($item['preDrawDate'].' 21:30:00');
                            $kjsave['status'] = 1;
                            $kjsave['baostatus'] = 1;
                            $kjsave['js'] = 1;
                            $kjsave['kjtime'] = strtotime($item['preDrawDate'].' 21:30');
                            Kj::create($kjsave);
                        }else{
                            if($c['status'] == 0 || $force == 1){
                                $qiuarr = explode(',',$item['preDrawCode']);
                                $updat = [];
                                for($i = 0;$i < count($qiuarr);$i++){
                                    $is = intval($qiuarr[$i]);
                                    if($is <= 9){
                                        $is = '0'.$is;
                                    }
                                    $updat['m'.($i+1)] = $is;
                                }
                                $updat['status'] = 1;
                                Kj::where('id',$c['id'])->update($updat);
                            }
                        }
                    }
                }
            }elseif ($gid == 300){//澳门六合彩
                //$url = sys_config('kjw_amlhc_url');
                //$url = str_replace('1.json','20.json',$url);
                $url = 'https://520-api.com/token/9ca7f1fa0a7111edbf5883ee0741c4c0/code/amlhc/rows/10.json';
                $ma = CsFunc::curl_get(1, $url);
                $ma = json_decode($ma, true);
                $list = $ma['data'];
                if(is_array($list)){
                    foreach ($list as $item){
                        $expect = intval($item['expect']);
                        $c = Kj::where(['gid'=>$gid,'qishu'=>$expect])->first();
                        if(empty($c)){
                            $kjsave = [];
                            $qiuarr = explode(',',$item['opencode']);
                            for($i = 0;$i < count($qiuarr);$i++){
                                $is = intval($qiuarr[$i]);
                                if($is <= 9){
                                    $is = '0'.$is;
                                }
                                $kjsave['m'.($i+1)] = $is;
                            }
                            $ddd = date('Y-m-d',strtotime($item['opentime']));
                            $kjsave['gid'] = $gid;
                            $kjsave['dates'] = strtotime($ddd);
                            $kjsave['qishu'] = $expect;
                            $kjsave['opentime'] = strtotime($ddd.' 17:00:00');
                            $kjsave['closetime'] = strtotime($ddd.' 21:30:00');
                            $kjsave['status'] = 1;
                            $kjsave['baostatus'] = 1;
                            $kjsave['bml'] = $game['thisbml'];
                            $kjsave['js'] = 1;
                            $kjsave['kjtime'] = strtotime($ddd.'  21:35:00');
                            Kj::create($kjsave);
                        }else{
                            if($c['status'] == 0 || $force == 1){
                                $qiuarr = explode(',',$item['opencode']);
                                $updat = [];
                                for($i = 0;$i < count($qiuarr);$i++){
                                    $is = intval($qiuarr[$i]);
                                    if($is <= 9){
                                        $is = '0'.$is;
                                    }
                                    $updat['m'.($i+1)] = $is;
                                }
                                $updat['status'] = 1;
                                Kj::where('id',$c['id'])->update($updat);
                            }
                        }
                    }
                }
            }
        }
        return $url;
    }

}
