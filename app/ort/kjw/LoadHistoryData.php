<?php


namespace App\ort\kjw;


use App\Models\Kjw\Game;
use App\ort\common\HttpService;
use App\ort\kjw\services\ConService;

class LoadHistoryData
{
    /**
     * 创建历史开奖数据
     * @param $days 天数
     */
    public static function create_history_data($days){
        $flagtime = time();
        for($i = 0;$i < $days;$i++){
            $flagtime = strtotime('-1 day',$flagtime);
            ConService::fast_create_data($flagtime);
        }
    }

    /**
     * 加载香港六合彩历史数据
     */
    public static function load_lhc_history($year = 46){
        $list = [];
        $time = time();
        $list[] = date('Y',$time);
        for($i = 0;$i < $year;$i++){
            $list[] = date('Y',$time);
            $time = strtotime('-1 year',$time);
        }
        foreach ($list as $item){
            try {
                ConService::loadhistorykjdata($item,10048,0);
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }
    }

    //老澳门六合彩
    public static function load_oldamlhc_history($force = 0){
        $url = "https://ls.kjkj.fit/kj";
        $res = HttpService::curl_post(1,$url,'',['g'=>'48am','s'=>500]);
        $json = json_decode($res,true);
        $list = $json['data'];
        $gid = 300;
        $game = Game::where('gid',$gid)->select(['lotCode','fenlei','fast','starttime'])->first();
        $kjServices = CommonService::getKjmodel($gid);
        foreach ($list as $item){
            $expect = $item['year'].$item['qishu'];
            $c = $kjServices->where(['gid'=>$gid,'qishu'=>$expect])->first();
            if(empty($c)){
                $kjsave = [];
                $qiuarr = explode(',',$item['num']);
                for($i = 0;$i < count($qiuarr);$i++){
                    $is = intval($qiuarr[$i]);
                    if($is <= 9){
                        $is = '0'.$is;
                    }
                    $kjsave['m'.($i+1)] = $is;
                }
                $ddd = date('Y-m-d',strtotime($item['date']));
                $kjsave['gid'] = $gid;
                $kjsave['dates'] = strtotime($ddd);
                $kjsave['qishu'] = $expect;
                $kjsave['add_time'] = time();
                $kjsave['status'] = 1;
                $kjsave['kjtime'] = strtotime($ddd.' '.$game['starttime']);
                $kjServices->create($kjsave);
            }else{
                if($c['status'] == 0 || $force == 1){
                    $qiuarr = explode(',',$item['num']);
                    $updat = [];
                    for($i = 0;$i < count($qiuarr);$i++){
                        $is = intval($qiuarr[$i]);
                        if($is <= 9){
                            $is = '0'.$is;
                        }
                        $updat['m'.($i+1)] = $is;
                    }
                    $updat['status'] = 1;
                    $kjServices->where('id',$c['id'])->update($updat);
                }
            }
        }
    }

    /**
     * 加载台湾彩和全国彩历史数据
     */
    public static function load_qgc_and_twc_history($gid = 0){
        if($gid > 0){
            $game_list = Game::where(['fast'=>0,'status'=>1,'guanfang'=>1,'gid'=>$gid])->get();
        }else{
            $game_list = Game::whereIn('gid',explode(',','311,192,193,211,212,213,214,215,216,217'))->get();
        }
        foreach ($game_list as $item){
            try {
                ConService::loadhistorykjdata(date('Y-m-d'),$item['lotCode'],0);
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }
        //ConService::loadhistorykjdata(date('Y-m-d'),20049,0);
    }

    /**
     * 补全今天没有开奖的数据
     * @param $guanfang
     */
    public static function load_today_data($guanfang){
        $game_list = Game::where(['fast'=>1,'status'=>1,'guanfang'=>$guanfang,'laiyuan'=>1])->get();
        $ctime = strtotime(date('Y-m-d'));
        foreach ($game_list as $item) {
            $gid = $item['gid'];
            $mnum = $item['mnum'];
            $jiange = $item['qsjg']*60;
            $kjServices = CommonService::getKjmodel($gid);
            if($guanfang == 0){
                $kjlist = $kjServices->where(['status'=>0,'dates'=>$ctime])->where('kjtime','<',time()-$jiange)->select(['id'])->get();
                foreach ($kjlist as $kj){
                    $m = JsFunc::calcmoni($item['fenlei'], $gid);
                    if (!is_array($m)) {
                        $m = explode(',', $m);
                    }
                    if (!is_numeric($m[0]) || !is_numeric($m[$mnum - 1])) {
                        continue;
                    }
                    $save = [];
                    for ($i = 1; $i <= $mnum; $i++) {
                        $save['m'.$i] = $m[$i - 1];
                    }
                    $save['status'] = 1;
                    $kjServices->where(['id'=>$kj['id']])->update($save);
                }
            }else{
                $kjlist = $kjServices->where(['status'=>0,'dates'=>$ctime])->where('kjtime','<',time()-$jiange)->count('id');
                if($kjlist > 0){
                    ConService::loadhistorykjdata(date('Y-m-d'),$item['lotCode'],0);
                }
            }
        }
    }

    /**
     * 官方快开彩开奖数据
     */
    public static function load_fast_history($gid = 0){
        if($gid > 0){
            $game_list = Game::where(['fast'=>1,'status'=>1,'guanfang'=>1,'gid'=>$gid,'laiyuan'=>1])->get();
        }else{
            $game_list = Game::where(['fast'=>1,'status'=>1,'guanfang'=>1,'laiyuan'=>1])->get();
        }
        $ctime = strtotime(date('Y-m-d'));
        foreach ($game_list as $item){
            $gid = $item['gid'];
            $kjServices = CommonService::getKjmodel($gid);
            $datelist = $kjServices->select(['dates'])->groupByRaw('dates')->get();
            foreach ($datelist as $d){
                if($d['dates'] <=$ctime){
                    $date = date('Y-m-d', $d['dates']);
                    try {
                        $count = $kjServices->where(['dates'=>$d['dates'],'status'=>0])->count('id');
                        if($count > 0){
                            ConService::loadhistorykjdata($date,$item['lotCode'],0);
                        }
                    }catch (\Exception $e){
                        echo $e->getMessage();
                    }
                }
            }
        }
    }

    /**
     * 加载自己的彩种历史数据
     */
    public static function load_my_history(){
        $game_list = Game::where(['fast'=>1,'status'=>1,'guanfang'=>0])->get();
        $ctime = strtotime(date('Y-m-d'));
        foreach ($game_list as $item){
            $gid = $item['gid'];
            $mnum = $item['mnum'];
            $kjServices = CommonService::getKjmodel($gid);
            $datelist = $kjServices->select(['dates'])->groupByRaw('dates')->get();
            foreach ($datelist as $d){
                if($d['dates'] <$ctime){
                    $kjlist = $kjServices->where(['status'=>0,'dates'=>$d['dates']])->select(['id'])->get();
                    foreach ($kjlist as $kj){
                        $m = JsFunc::calcmoni($item['fenlei'], $gid);
                        if (!is_array($m)) {
                            $m = explode(',', $m);
                        }
                        if (!is_numeric($m[0]) || !is_numeric($m[$mnum - 1])) {
                            continue;
                        }
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->update($save,['id'=>$kj['id']]);
                    }
                }
            }
        }
    }
}
