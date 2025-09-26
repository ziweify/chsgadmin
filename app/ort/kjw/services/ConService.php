<?php


namespace App\ort\kjw\services;



use App\Models\Kjw\Game;
use App\ort\common\CsFunc;
use App\ort\kjw\CommonService;
use Illuminate\Support\Facades\DB;

class ConService
{
    /**
     * 慢彩数据生成
     */
    public static function nofast_create_data(){
        Game::where(['fast'=>0,'status'=>1])
            ->get()
            ->each(function ($item){
                $gid = $item['gid'];
                $starttime = $item['starttime'];
                $starttime2 = $item['starttime2'];
                if($gid == 100){//香港六合彩
                    $kjServices = CommonService::getKjmodel($gid);
                    $c = $kjServices->where('status',0)->count('id');
                    if($c <= 0){
                        $url = x_config('kjw_xglhc_url');
                        if(strpos($url,'data/xg.json') !== false) {
                            $url .= '?'.(time()*1000);
                            $ma = CsFunc::curl_get(1, $url);
                            $ma = json_decode($ma, true);
                            if(!isset($ma['data']) || empty($ma['data'])){
                                return;
                            }
                            $data = $ma['data'];
                            $m = explode(',', $data);
                            $pre = date('Y');
                            $drawIssue = $pre.$m[8];
                            $exc = $kjServices->where(['gid'=>$gid,'qishu'=>$drawIssue])->count('id');
                            if($exc <= 0){
                                $drawTime = date("Y-{$m[9]}-{$m[10]} 21:30:00");
                                $drawTime = strtotime($drawTime);
                                $date = date('Y-m-d', $drawTime);
                                $dates = strtotime($date);
                                $kjsave = [];
                                $kjsave['qishu'] = $drawIssue;
                                $kjsave['gid'] = $gid;
                                $kjsave['dates'] = $dates;
                                $kjsave['add_time'] = time();
                                $kjsave['kjtime'] = $drawTime;
                                $kjServices->create($kjsave);
                            }
                        }else{
                            $ma = CsFunc::curl_get(1, $url);
                            $ma = json_decode($ma, true);
                            $data = $ma['result']['data'];
                            $drawIssue = $data['drawIssue'];
                            $exc = $kjServices->where(['gid'=>$gid,'qishu'=>$drawIssue])->count('id');
                            if($exc <= 0){
                                $drawTime = strtotime($data['drawTime']);
                                $date = date('Y-m-d', $drawTime);
                                $dates = strtotime($date);
                                $kjsave = [];
                                $kjsave['qishu'] = $drawIssue;
                                $kjsave['gid'] = $gid;
                                $kjsave['dates'] = $dates;
                                $kjsave['add_time'] = time();
                                $kjsave['kjtime'] = $drawTime;
                                $kjServices->create($kjsave);
                            }
                        }
                    }
                }elseif($gid == 300 || $gid == 311 || $gid == 192 || $gid == 193
                    || $gid == 211 || $gid == 212 || $gid == 213 || $gid == 214
                    || $gid == 215 || $gid == 216 || $gid == 217){//台湾大乐透、香港六合彩、台湾威力彩、台湾金彩539
                    $kjServices = CommonService::getKjmodel($gid);
                    $c = $kjServices->where('gid',$gid)->where('status',0)->count('id');
                    if($c <= 0){
                        $maxqishu = $kjServices->where('gid',$gid)->where('status',1)->max('qishu');
                        if($maxqishu){
                            $kj_sig = $kjServices->where(['gid'=>$gid,'qishu'=>$maxqishu])->first();
                            $old_date = $kj_sig['dates'];
                            $oldw = date('w',$old_date);
                            $index = 0;
                            while (true){
                                $index++;
                                $cdate = strtotime('+1 day',$old_date);
                                $cw = date('w',$cdate);
                                if($gid == 311){//台湾大乐透
                                    if(($oldw == 2 && $cw == 5) || ($oldw == 5 && $cw == 2) || $index > 20){
                                        break;
                                    }
                                }elseif ($gid == 100){//香港六合彩
                                    if(($oldw == 2 && $cw == 4) || ($oldw == 4 && $cw == 6) || ($oldw == 6 && $cw == 2) || $index > 20){
                                        break;
                                    }
                                }elseif ($gid == 192){//台湾威力彩
                                    if(($oldw == 1 && $cw == 4) || ($oldw == 4 && $cw == 1) || $index > 20){
                                        break;
                                    }
                                }elseif ($gid == 193){//台湾今彩539
                                    if(($oldw == 1 && $cw == 2) || ($oldw == 2 && $cw == 3) ||
                                        ($oldw == 3 && $cw == 4) || ($oldw == 4 && $cw == 5) || ($oldw == 5 && $cw == 6) || ($oldw == 6 && $cw == 1) || $index > 20){
                                        break;
                                    }
                                }elseif ($gid == 211){//双色球
                                    if(($oldw == 2 && $cw == 4) || ($oldw == 4 && $cw == 0) || ($oldw == 0 && $cw == 2) || $index > 20){
                                        break;
                                    }
                                }elseif ($gid == 212 || $gid == 300 || $gid == 215 || $gid == 216){//福彩3d,澳门六合彩，体彩排列3,体彩排列5
                                    break;
                                }elseif ($gid == 213){//福彩七乐彩
                                    if(($oldw == 1 && $cw == 3) || ($oldw == 3 && $cw == 5) || ($oldw == 5 && $cw == 1) || $index > 20){
                                        break;
                                    }
                                }elseif ($gid == 214){//超级大乐透
                                    if(($oldw == 1 && $cw == 3) || ($oldw == 3 && $cw == 6) || ($oldw == 6 && $cw == 1) || $index > 20){
                                        break;
                                    }
                                }elseif ($gid == 217){//体彩七星彩
                                    if(($oldw == 2 && $cw == 5) || ($oldw == 5 && $cw == 0) || ($oldw == 0 && $cw == 2) || $index > 20){
                                        break;
                                    }
                                }
                                $old_date = $cdate;
                            }
                            $kjsave = [];
                            $kjsave['qishu'] = $maxqishu+1;
                            //跨年检测
                            /*$oldyear = date('Y',$kj_sig['dates']);
                            $newyear = date('Y',$cdate);
                            if($newyear > $oldyear){
                                if($gid == 311 || $gid == 192 || $gid == 193)$kjsave['qishu'] = 111000001;
                                if ($gid == 300 || $gid == 211 || $gid == 212 || $gid == 213)$kjsave['qishu'] = $newyear.'001';
                                if ($gid == 214 || $gid == 215 || $gid == 216 || $gid == 217){
                                    $newyear = substr($newyear,-2);
                                    $kjsave['qishu'] = $newyear.'001';
                                }
                            }*/
                            $kjsave['gid'] = $gid;
                            $kjsave['dates'] = $cdate;
                            $kjsave['add_time'] = time();
                            $kjsave['kjtime'] = strtotime(date('Y-m-d',$cdate).' '.$starttime);
                            $kjServices->create($kjsave);
                        }
                    }
                }
            });
    }


    public static function loadhistorykjdata($date,$lotCode,$force){
        $kjurls = admin_setting('api_urls','https://api.api68.com/');
        $kjurlarray = explode(',',$kjurls);
        $kjurl = $kjurlarray[random_int(0,count($kjurlarray)-1)];
        $game = Game::where('lotCode',$lotCode)->select(['gid','mnum','starttime','starttime2','fenlei','fast'])->first();
        $gid = $game['gid'];
        $kjServices = CommonService::getKjmodel($gid);
        if($game['fast'] == 1){//快开
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
            }elseif ($game['fenlei'] == 161){
                $url = $kjurl."LuckTwenty/getBaseLuckTwentyList.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 163){
                $url = $kjurl."LuckTwenty/getPcLucky28List.do?date=$date&lotCode=".$lotCode;
            }elseif ($game['fenlei'] == 100){//极速六合彩
                $url = $kjurl."speedSix/findSpeedSixHistory.do?type=1&date=$date";
            }
            $ma = CsFunc::curl_get(1, $url);
            $ma = json_decode($ma, true);
            $list = $ma['result']['data'];
            if($game['fenlei'] == 100){
                $list = $list['bodyList'];
            }
            foreach ($list as $item){
                $where = [];
                if (($force == 0)){
                    $where['status'] = 0;
                }
                $issue = $game['fenlei'] == 100 ? $item['issue'] : $item['preDrawIssue'];
                $count = $kjServices->where(['qishu'=>$issue])->where($where)->count('id');
                if($count > 0){
                    $qiuarr = explode(',',$item['preDrawCode']);
                    for($i = 0;$i < count($qiuarr);$i++){
                        $updat['m'.($i+1)] = $qiuarr[$i].'';
                    }
                    $updat['status'] = 1;
                    $kjServices->where(['qishu'=>$issue])->update($updat);
                }
            }
        }elseif ($game['fast'] == 0){
            if($gid == 311 || $gid == 192 || $gid == 193){//台湾大乐透、台湾威力彩、台湾今彩539
                $url = $kjurl."taiWanCai/getHistoryLotteryInfo.do?lotCode=$lotCode&date=".date('Y-m-d');
                $ma = CsFunc::curl_get(1, $url);
                $ma = json_decode($ma, true);
                $list = $ma['result']['data'];
                foreach ($list as $item){
                    $c = $kjServices->where(['gid'=>$gid,'qishu'=>$item['preDrawIssue']])->first();
                    if(empty($c)){
                        $kjsave = [];
                        $qiuarr = explode(',',$item['preDrawCode']);
                        for($i = 0;$i < count($qiuarr);$i++){
                            $kjsave['m'.($i+1)] = $qiuarr[$i].'';
                        }
                        $kjsave['gid'] = $gid;
                        $kjsave['dates'] = strtotime(date('Y-m-d',strtotime($item['preDrawTime'])));
                        $kjsave['qishu'] = $item['preDrawIssue'];
                        $kjsave['add_time'] = time();
                        $kjsave['status'] = 1;
                        $kjsave['kjtime'] = strtotime($item['preDrawTime']);
                        $kjServices->create($kjsave);
                    }else{
                        if($c['status'] == 0 || $force == 1){
                            $qiuarr = explode(',',$item['preDrawCode']);
                            $updat = [];
                            for($i = 0;$i < count($qiuarr);$i++){
                                $updat['m'.($i+1)] = $qiuarr[$i].'';
                            }
                            $updat['status'] = 1;
                            $kjServices->where('id',$c['id'])->update($updat);
                        }
                    }
                }
            }elseif($gid == 211 || $gid == 212 || $gid == 213 || $gid == 214 || $gid == 215 || $gid == 216 || $gid == 217){//全国彩
                if($gid == 212 || $gid == 215){
                    $url = $kjurl."QuanGuoCai/getLotteryInfoList.do?lotCode=$lotCode&date=".date('Y-m-d');
                }else{
                    $url = $kjurl."QuanGuoCai/getHistoryLotteryInfo.do?lotCode=$lotCode&date=".date('Y-m-d');
                }
                $ma = CsFunc::curl_get(1, $url);
                $ma = json_decode($ma, true);
                $list = $ma['result']['data'];
                foreach ($list as $item){
                    $c = $kjServices->where(['gid'=>$gid,'qishu'=>$item['preDrawIssue']])->first();
                    if(empty($c)){
                        $kjsave = [];
                        $qiuarr = explode(',',$item['preDrawCode']);
                        for($i = 0;$i < count($qiuarr);$i++){
                            $kjsave['m'.($i+1)] = $qiuarr[$i].'';
                        }
                        $kjsave['gid'] = $gid;
                        $kjsave['dates'] = strtotime(date('Y-m-d',strtotime($item['preDrawTime'])));
                        $kjsave['qishu'] = $item['preDrawIssue'];
                        $kjsave['add_time'] = time();
                        $kjsave['status'] = 1;
                        $kjsave['kjtime'] = strtotime($item['preDrawTime']);
                        $kjServices->create($kjsave);
                    }else{
                        if($c['status'] == 0 || $force == 1){
                            $qiuarr = explode(',',$item['preDrawCode']);
                            $updat = [];
                            for($i = 0;$i < count($qiuarr);$i++){
                                $updat['m'.($i+1)] = $qiuarr[$i].'';
                            }
                            $updat['status'] = 1;
                            $kjServices->where('id',$c['id'])->update($updat);
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
                        $c = $kjServices->where(['gid'=>$gid,'qishu'=>$issue])->first();
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
                            $kjsave['add_time'] = time();
                            $kjsave['status'] = 1;
                            $kjsave['kjtime'] = strtotime($item['preDrawDate'].' 21:30');
                            $kjServices->create($kjsave);
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
                                $kjServices->where('id',$c['id'])->update($updat);
                            }
                        }
                    }
                }
            }elseif ($gid == 300){//澳门六合彩
                $url = x_config('kjw_amlhc_url');
                $ma = CsFunc::curl_get(0, $url);
                $ma = json_decode($ma, true);
                $list = $ma['data'];
                if(is_array($list)){
                    foreach ($list as $item){
                        $expect = intval($item['issue']);
                        $c = $kjServices->where(['gid'=>$gid,'qishu'=>$expect])->first();
                        if(empty($c)){
                            $kjsave = [];
                            $qiuarr = explode(',',$item['openCode']);
                            for($i = 0;$i < count($qiuarr);$i++){
                                $is = intval($qiuarr[$i]);
                                if($is <= 9){
                                    $is = '0'.$is;
                                }
                                $kjsave['m'.($i+1)] = $is;
                            }
                            $ddd = date('Y-m-d',strtotime($item['openTime']));
                            $kjsave['gid'] = $gid;
                            $kjsave['dates'] = strtotime($ddd);
                            $kjsave['qishu'] = $expect;
                            $kjsave['add_time'] = time();
                            $kjsave['status'] = 1;
                            $kjsave['kjtime'] = strtotime($ddd.' '.$game['starttime']);
                            $kjServices->create($kjsave);
                        }else{
                            if($c['status'] == 0 || $force == 1){
                                $qiuarr = explode(',',$item['openCode']);
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
            }
        }
        return $url;
    }

    public static function truncate_table($fast){
        $gamelist = Game::where(['status'=>1,'fast'=>$fast])->select(['gid'])->get();
        $db = Db::connection('kjw');
        foreach ($gamelist as $item){
            if($item['gid'] != 100 && $item['gid'] != 300){
                $tb = 'eb_kj'.$item['gid'];
                $db->delete('TRUNCATE '.$tb);
            }
        }
        if($fast == 1){
            $db->delete('TRUNCATE eb_daybao');
            $db->delete('TRUNCATE eb_daycl');
        }
    }

    /**
     * 快开彩数据生成
     */
    public static function fast_create_data($flagtime,$gid = 0,$force = 0){
        $his = date("His",$flagtime);
        $game_list = Game::where(['fast'=>1,'status'=>1])->when($gid > 0,function ($query)use($gid){
            $query->where('gid',$gid);
        })->get();
        foreach ($game_list as $item){
            $gid = $item['gid'];
            $starttime = $item['starttime'];
            $starttime2 = $item['starttime2'];
            $pdstime = str_replace(':', '', $starttime);
            $pdetime = str_replace(':', '', $starttime2);
            if(($pdetime < $pdstime) && $his < $pdetime && $force == 0){
                $dates = date("Y-m-d", $flagtime - 86400);
            }else{
                $dates = date("Y-m-d",$flagtime);
            }
            $kjServices = CommonService::getKjmodel($gid);
            $count = $kjServices->where(['gid'=>$gid,'dates'=>strtotime($dates)])->count('id');
            if($count > 0){
                if($count != $item['qsnums']){
                    $kjServices->where(['gid'=>$gid,'dates'=>strtotime($dates)])->delete();
                }else{
                    continue;
                }
            };
            if ($gid == 555 || $gid == 161 || $gid == 153 || $gid == 171) {//新版
                $qishu = $item['qishunum'] * (strtotime($dates) - strtotime($item['startdate'])) / 3600 / 24 + $item['startqs'] - $item['tzqs'];
                $starttime = $dates . " " . $item['starttime'];
                $starttime = strtotime($starttime);
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    $opentime = $starttime;
                    $kjtime = $opentime + $item['qsjg'] * 60;
                    $kj_count = $kjServices->where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                    if($kj_count <= 0){
                        $kjServices->create(['add_time'=>time(),'kjtime'=>$kjtime,'qishu'=>$qishu,'dates'=>strtotime($dates),'gid'=>$gid]);
                    }
                    $qishu++;
                    $starttime = $kjtime;
                }
            }elseif ($gid == 444 || $gid == 162 || $gid == 163 || $gid == 172 || $gid == 109 ||
                $gid == 108 || $gid == 175 || $gid == 200 || $gid == 121
                || $gid == 164 || $gid == 253 || $gid == 255 || $gid == 167 || $gid == 168 || $gid == 169) {
                $qishu = $item['qishunum'] * (strtotime($dates) - strtotime($item['startdate'])) / 3600 / 24 + $item['startqs'] - $item['tzqs'];
                $starttime = $dates . " " . $item['starttime'];
                $starttime = strtotime($starttime);
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    $opentime = $starttime;
                    if($i > 1){
                        $kjtime = $opentime + $item['qsjg'] * 60;
                    }else{
                        $kjtime = $opentime;
                    }
                    $kj_count = $kjServices->where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                    if($kj_count <= 0){
                        $kjServices->create(['add_time'=>time(),'kjtime'=>$kjtime,'qishu'=>$qishu,'dates'=>strtotime($dates),'gid'=>$gid]);
                    }
                    $qishu++;
                    $starttime = $kjtime;
                }
            } else if ($gid == 110) {//幸运时时彩
                $starttime = strtotime($dates . ' 00:00:00');
                $kjtime = $starttime;
                $item['qsnums'] = 120;
                $item['qsjg'] = 5;
                $ddd = strtotime($dates);
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    if ($i == 1) {
                        $kjtime = $starttime;
                        $item['qsjg'] = 5;
                    }
                    if ($i == 24) {
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 09:50:00');
                        $kjtime = $starttime;
                        $item['qsjg'] = 10;
                    }
                    if ($i == 97) {
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 22:00:00');
                        $kjtime = $starttime;
                        $item['qsjg'] = 5;
                    }
                    if ($gid == 101) {
                        $k = $i + 9;
                    } else if ($gid == 135) {
                        $k = $i + 9;
                    } else if ($gid == 229) {
                        $k = $i + 23;
                    } else {
                        $k = $i;
                    }

                    if ($k < 10) {
                        $j = '00' . $k;
                    } else if ($k < 100) {
                        $j = '0' . $k;
                    } else {
                        $j = $k;
                    }
                    $opentime = $kjtime;
                    if ($gid == 101 && $k == 1) {
                        $opentime = $opentime + $item['qsjg2'] * 60;
                    }
                    if ($gid == 135 && $k == 1) {
                        $opentime = $opentime + $item['qsjg2'] * 60;
                    }
                    $kjtime = $opentime + $item['qsjg'] * 60;
                    if ($gid == 101 || $gid == 229) {
                        $qishu = date("Ymd", $opentime) . $j;
                    } else if ($gid == 135) {
                        $qishu = date("Ymd", $kjtime) . $j;
                    } else {
                        $qishu = date("Ymd", $starttime) . $j;
                    }
                    $kj_count = $kjServices->where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                    if($kj_count <= 0){
                        $kjServices->create(['add_time'=>time(),'kjtime'=>$kjtime,'qishu'=>$qishu,'dates'=>$ddd,'gid'=>$gid]);
                    }
                }
            } elseif($gid == 107 || $gid == 111 || $gid == 251 || $gid == 123 || $gid == 124 || $gid == 166
                || $gid == 177 || $gid == 310 || $gid == 312 || $gid == 313 || $gid == 314 || $gid == 315) {
                $starttime = strtotime($dates . " " . $item['starttime']);
                $kjtime = $starttime;
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    $k = $i;
                    if ($k < 10) {
                        $j = '00' . $k;
                    } else if ($k < 100) {
                        $j = '0' . $k;
                    } else {
                        $j = $k;
                    }
                    $opentime = $kjtime;
                    if($i > 1){
                        $kjtime = $opentime + $item['qsjg'] * 60;
                    }else{
                        $kjtime = $opentime;
                    }
                    $qishu = date("Ymd", $starttime) . $j;
                    $kj_count = $kjServices->where(['gid' => $gid, 'qishu' => $qishu, 'dates' => strtotime($dates)])->count('id');
                    if ($kj_count <= 0) {
                        $kjServices->create(['add_time' => time(), 'kjtime' => $kjtime, 'qishu' => $qishu, 'dates' => strtotime($dates), 'gid' => $gid]);
                    }
                }
            } else if ($gid == 221 || $gid == 256 || $gid == 257 || $gid == 258) {//飚速系列
                $starttime = strtotime($dates . ' 00:00:00');
                $kjtime = $starttime;
                $ddd = strtotime($dates);
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    if ($i == 1 && ($gid == 221 || $gid == 256)) {
                        //$starttime = strtotime('+1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 23:59:00');
                        $kjtime = $starttime;
                    }
                    if ($i == 1 && ($gid == 257 || $gid == 258)) {
                        $starttime = strtotime('+1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 00:00:00');
                        $kjtime = $starttime;
                    }
                    if (($i == 193 && ($gid == 221 || $gid == 256))) {
                        //$starttime = strtotime('-1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 07:59:00');
                        $kjtime = $starttime;
                    }
                    if (($i == 49 && ($gid == 257 || $gid == 258))) {
                        $starttime = strtotime('-1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 08:00:00');
                        $kjtime = $starttime;
                    }
                    $k = $i;
                    if ($k < 10) {
                        $j = '00' . $k;
                    } else if ($k < 100) {
                        $j = '0' . $k;
                    } else {
                        $j = $k;
                    }
                    $opentime = $kjtime;
                    $kjtime = $opentime + $item['qsjg'] * 60;
                    if($gid == 221 || $gid == 256) {
                        $qishu = date("Ymd", $kjtime) . $j;
                    }else{
                        $qishu = date("Ymd", $opentime) . $j;
                    }
                    //$qishu = date("Ymd", $kjtime) . $j;
                    $kj_count = $kjServices->where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                    if($kj_count <= 0){
                        $kjServices->create(['add_time'=>time(),'kjtime'=>$kjtime,'qishu'=>$qishu,'dates'=>$ddd,'gid'=>$gid]);
                    }
                }
            }else if ($gid == 262 || $gid == 263 || $gid == 264) {//eps赛马
                $starttime = strtotime($dates . ' 00:00:00');
                $kjtime = $starttime;
                $ddd = strtotime($dates);
                $tmptime = strtotime($dates);
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    if ($i == 1) {
                        //$starttime = strtotime('+1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 12:00:00');
                        $kjtime = $starttime;
                    }
                    if (($i == 481 && $gid == 262) || ($i == 321 && $gid == 263) || ($i == 193 && $gid == 264)) {
                        //$starttime = strtotime('-1 day',$starttime);
                        $starttime = strtotime($dates . ' 09:00:00');
                        $kjtime = $starttime;
                        $tmptime = strtotime('-1 day',strtotime($dates));
                    }
                    $k = $i;
                    if ($k < 10) {
                        $j = '00' . $k;
                    } else if ($k < 100) {
                        $j = '0' . $k;
                    } else {
                        $j = $k;
                    }
                    $opentime = $kjtime;
                    $kjtime = $opentime + $item['qsjg'] * 60;
                    //$closetime = $kjtime - $item['closetime'];
                    $qishu = date("Ymd", $tmptime) . $j;
                    $kj_count = $kjServices->where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                    if($kj_count <= 0){
                        $kjServices->create(['add_time'=>time(),'kjtime'=>$kjtime,'qishu'=>$qishu,'dates'=>$ddd,'gid'=>$gid]);
                    }
                }
            } else if ($gid == 259 || $gid == 260 || $gid == 261) {//超级5系列
                $starttime = strtotime($dates . ' 00:00:00');
                $kjtime = $starttime;
                $ddd = strtotime($dates);
                $tmptime = strtotime($dates);
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    if ($i == 1) {
                        //$starttime = strtotime('+1 day',$starttime);
                        $starttime = strtotime(date("Y-m-d", $starttime) . ' 11:59:00');
                        $kjtime = $starttime;
                    }
                    if (($i == 481 && $gid == 259) || ($i == 321 && $gid == 260) || ($i == 193 && $gid == 261)) {
                        //$starttime = strtotime('-1 day',$starttime);
                        $starttime = strtotime($dates . ' 08:59:00');
                        $kjtime = $starttime;
                        $tmptime = strtotime('-1 day',strtotime($dates));
                    }
                    $k = $i;
                    if ($k < 10) {
                        $j = '00' . $k;
                    } else if ($k < 100) {
                        $j = '0' . $k;
                    } else {
                        $j = $k;
                    }
                    $opentime = $kjtime;
                    $kjtime = $opentime + $item['qsjg'] * 60;
                    //$closetime = $kjtime - $cs['closetime'];
                    $qishu = date("Ymd", $tmptime) . $j;
                    $kj_count = $kjServices->where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                    if($kj_count <= 0){
                        $kjServices->create(['add_time'=>time(),'kjtime'=>$kjtime,'qishu'=>$qishu,'dates'=>$ddd,'gid'=>$gid]);
                    }
                }
            }elseif($gid == 316 || $gid == 317 || $gid == 318 || $gid == 319 || $gid == 320 || $gid == 321){//哈希系列
                $starttime = strtotime($dates . ' 00:00:00');
                $kjtime = $starttime;
                $ddd = strtotime($dates);
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    if ($i == 1) {
                        if($gid == 316 || $gid == 319){
                            $starttime = strtotime('-1 day',$starttime);
                            $starttime = strtotime(date("Y-m-d", $starttime) . ' 23:59:57');
                        }elseif ($gid == 317 || $gid == 320){
                            $starttime = strtotime(date("Y-m-d", $starttime) . ' 00:00:09');
                        }elseif ($gid == 318 || $gid == 321){
                            $starttime = strtotime(date("Y-m-d", $starttime) . ' 00:00:18');
                        }
                        $kjtime = $starttime;
                    }
                    $k = $i;
                    if ($k < 10) {
                        $j = '000' . $k;
                    } else if ($k < 100) {
                        $j = '00' . $k;
                    } else if ($k < 1000) {
                        $j = '0' . $k;
                    } else {
                        $j = $k;
                    }
                    $opentime = $kjtime;
                    $kjtime = $opentime + $item['qsjg'] * 60;
                    $qishu = date("Ymd", $ddd) . $j;
                    $kj_count = $kjServices->where(['gid'=>$gid,'qishu'=>$qishu,'dates'=>strtotime($dates)])->count('id');
                    if($kj_count <= 0){
                        $kjServices->create(['add_time'=>time(),'kjtime'=>$kjtime,'qishu'=>$qishu,'dates'=>$ddd,'gid'=>$gid]);
                    }
                }
            }else {
                $starttime = strtotime($dates . " " . $item['starttime']);
                $kjtime = $starttime;
                for ($i = 1; $i <= $item['qsnums']; $i++) {
                    if ($gid == 101) {
                        $k = $i + 9;
                    } else if ($gid == 135) {
                        $k = $i + 9;
                    } else if ($gid == 229) {
                        $k = $i + 23;
                    } else {
                        $k = $i;
                    }
                    if ($gid == 229 & $k > 120) {
                        $k -= 120;
                    }
                    if ($gid == 101 & $k > 59) {
                        $k -= 59;
                    }
                    if ($gid == 135 & $k > 59) {
                        $k -= 59;
                    }

                    if ($k < 10) {
                        $j = '00' . $k;
                    } else if ($k < 100) {
                        $j = '0' . $k;
                    } else {
                        $j = $k;
                    }
                    if ($gid == 229 & ($j <= 23 | $j >= 97)) {
                        $item['qsjg'] = $item['qsjg2'];

                    }
                    $opentime = $kjtime;
                    if ($gid == 101 && $k == 1) {
                        $opentime = $opentime + $item['qsjg2'] * 60;
                    }
                    if ($gid == 135 && $k == 1) {
                        $opentime = $opentime + $item['qsjg2'] * 60;
                    }
                    $kjtime = $opentime + $item['qsjg'] * 60;
                    if ($gid == 101 || $gid == 229) {
                        $qishu = date("Ymd", $opentime) . $j;
                    } else if ($gid == 135) {
                        $qishu = date("Ymd", $kjtime) . $j;
                    }else {
                        $qishu = date("Ymd", $starttime) . $j;
                    }
                    $kj_count = $kjServices->where(['gid' => $gid, 'qishu' => $qishu, 'dates' => strtotime($dates)])->count('id');
                    if ($kj_count <= 0) {
                        $kjServices->create(['add_time' => time(), 'kjtime' => $kjtime, 'qishu' => $qishu, 'dates' => strtotime($dates), 'gid' => $gid]);
                    }
                }
            }
        }
    }
}
