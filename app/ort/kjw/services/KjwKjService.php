<?php


namespace App\ort\kjw\services;


use App\Models\Game\Kj;
use App\Models\Kjw\Game;
use App\ort\common\CsFunc;
use App\ort\kjw\CommonService;
use App\ort\kjw\JsFunc;
use Illuminate\Support\Facades\DB;

class KjwKjService
{
    public static function kj($gid = 0){
        $db = Db::connection('kjw');
        if($gid > 0){
            $game = Game::where(['gid'=>$gid,'status' => 1,'autokj'=>1])->get();
        }else{
            $game = Game::where(['status' => 1,'autokj'=>1])->orderByRaw('kjtime desc')->get();
        }
        $cg = count($game);
        $kjurls = x_config('kjip','https://api.api68.com/');
        $kjurlarray = explode(',',$kjurls);
        $kjurl = $kjurlarray[random_int(0,count($kjurlarray)-1)];
        for ($k = 0; $k < $cg; $k++) {
            $gid = $game[$k]['gid'];
            $fenlei = $game[$k]['fenlei'];
            $mnum = $game[$k]['mnum'];
            $qsjg = $game[$k]['qsjg'];
            $kjServices = CommonService::getKjmodel($gid);
            /*$kj = $kjServices->where(['status'=>0])->where('kjtime', '<', time())->order('qishu asc')->find();
            if(empty($kj)){
                continue;
            }*/
            $kj = null;
            if($game[$k]['fast'] == 1){
                //日期判断
                $his = date("His");
                $pdstime = str_replace(':', '', $game[$k]['starttime']);
                $pdetime = str_replace(':', '', $game[$k]['starttime2']);
                if(($pdetime < $pdstime) && $his < $pdetime){
                    $dates = date("Y-m-d", time() - 86400);
                }else{
                    $dates = date("Y-m-d");
                }
                $cur = $kjServices->where(['dates'=>strtotime($dates),'status'=>0])->where('kjtime','>',time())->orderByRaw('qishu asc')->value('kjtime');
                if($cur){
                    $kj = $kjServices->where('kjtime', '<', $cur)->orderByRaw('qishu desc')->select(['status','qishu','kjtime'])->first();
                    if($kj['status'] == 1){
                        continue;
                    }
                }
                if (empty($kj)) {
                    continue;
                }
                //查询投注站游戏
                $tzgame = \App\Models\Game\Game::where(['lottery'=>$game[$k]['lotCode']])->select(['gid','cs','guanfang'])->first();
                $tzcs = json_decode($tzgame['cs'],true);
                $tzkjcount = Kj::where(['gid'=>$tzgame['gid'],'qishu'=>$kj['qishu']])->count('id');
                if ($tzgame['guanfang'] == 1 && ($tzcs['cjmode'] == 1 || $tzcs['cjmode'] == 2) && $tzkjcount > 0) {
                    continue;
                }
                if ($tzgame['guanfang'] == 1 && ($tzcs['cjmode'] == 1 || $tzcs['cjmode'] == 2) && $tzkjcount <= 0) {
                    $game[$k]['guanfang'] = 0;
                }
            }
            $tb = 'eb_kj'.$gid;
            $is_Update = 0;
            $m = [];
            if ($game[$k]['fast'] == 0) {//低频彩
                $oldkj = $kjServices->where(['status'=>0])->orderByRaw('qishu desc')->first();
                if(empty($oldkj) || $oldkj['kjtime'] > time()){
                    continue;
                }
                if ($gid == 300) {//澳门六合彩
                    $url = x_config('kjw_amlhc_url');
                    //判断url是否包含opencode/2032
                    if(strpos($url,'opencode/2032') !== false){
                        $ma = CsFunc::curl_get(0, $url);
                        $ma = json_decode($ma, true);
                        $data = $ma['data'][0];
                        $m = explode(',', $data['openCode']);
                        $action_no = $data['issue'];
                        $sql = "update `$tb` set status='1',m1='{$m[0]}',m2='{$m[1]}',m3='{$m[2]}',m4='{$m[3]}',m5='{$m[4]}',m6='{$m[5]}',m7='{$m[6]}'";
                        $sql .= " where  gid='{$gid}' and qishu='{$action_no}' ";
                        $db->update($sql);
                        $is_Update = 1;
                    }else{
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if ($ma['code'] == 'amlhc') {
                            $data = $ma['data'][0];
                            $m = explode(',', $data['opencode']);
                            $action_no = $data['expect'];
                            $sql = "update `$tb` set status='1',m1='{$m[0]}',m2='{$m[1]}',m3='{$m[2]}',m4='{$m[3]}',m5='{$m[4]}',m6='{$m[5]}',m7='{$m[6]}'";
                            $sql .= " where  gid='{$gid}' and qishu='{$action_no}' ";
                            $db->update($sql);
                            $is_Update = 1;
                        }
                    }
                }elseif ($gid == 100) {//香港六合彩
                    $url = x_config('kjw_xglhc_url');
                    if(strpos($url,'data/xg.json') !== false){
                        $url .= '?'.(time()*1000);
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if(!isset($ma['data']) || empty($ma['data'])){
                            continue;
                        }
                        $data = $ma['data'];
                        $m = explode(',', $data);
                        $pre = date('Y');
                        $action_no = $pre.$m[0];
                        if((is_numeric($m[1]) && is_numeric($m[2]) && is_numeric($m[3]) && is_numeric($m[4]) && is_numeric($m[5]) && is_numeric($m[6]) && is_numeric($m[7]))
                            && ($m[1] > 0 && $m[2] > 0 && $m[3] > 0 && $m[4] > 0 && $m[5] > 0 && $m[6] > 0 && $m[7] > 0)){
                            $sql = "update `$tb` set status='1',m1='{$m[1]}',m2='{$m[2]}',m3='{$m[3]}',m4='{$m[4]}',m5='{$m[5]}',m6='{$m[6]}',m7='{$m[7]}'";
                            $sql .= " where  gid='{$gid}' and qishu='{$action_no}' ";
                            $db->update($sql);
                            $is_Update = 1;
                        }
                    }else{
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    }
                }elseif ($gid == 311 || $gid == 192 || $gid == 193){//台湾大乐透、台湾威力彩、台湾今彩539
                    $url = $kjurl.'taiWanCai/getLotteryInfo.do?lotCode='.$game[$k]['lotCode'];
                    $ma = CsFunc::curl_get(1, $url);
                    $ma = json_decode($ma, true);
                    if (!is_array($ma['result']['data'])) {
                        continue;
                    }
                    $m = explode(',', $ma['result']['data']['preDrawCode']);
                    $qishu = $ma['result']['data']['preDrawIssue'];
                    $save = [];
                    for ($i = 1; $i <= $mnum; $i++) {
                        $save['m'.$i] = $m[$i - 1];
                    }
                    $save['status'] = 1;
                    $kjServices->where(['qishu'=>$qishu])->update($save);
                    $is_Update = 1;
                }elseif ($gid == 211 || $gid == 212 || $gid == 213 || $gid == 214 || $gid == 215 || $gid == 216 || $gid == 217){//全国彩
                    if ($gid == 212 || $gid == 215){
                        $url = $kjurl.'QuanGuoCai/getLotteryInfo1.do?lotCode='.$game[$k]['lotCode'];
                    }else{
                        $url = $kjurl.'QuanGuoCai/getLotteryInfo.do?lotCode='.$game[$k]['lotCode'];
                    }

                    $ma = CsFunc::curl_get(1, $url);
                    //$ma = HttpService::getRequest($url);
                    $ma = json_decode($ma, true);
                    if (!is_array($ma['result']['data'])) {
                        continue;
                    }
                    $m = explode(',', $ma['result']['data']['preDrawCode']);
                    $qishu = $ma['result']['data']['preDrawIssue'];
                    $save = [];
                    for ($i = 1; $i <= $mnum; $i++) {
                        $save['m'.$i] = $m[$i - 1];
                    }
                    $save['status'] = 1;
                    $kjServices->where(['qishu'=>$qishu])->update($save);
                    $is_Update = 1;
                }
            }elseif($gid == 316 || $gid == 317 || $gid == 318 || $gid == 319 || $gid == 320 || $gid == 321){
                $starttime = $kj['kjtime'];
                $endtime = $kj['kjtime'];
                $qiulist = TronHashService::gettronlottery($starttime,$endtime,1,$fenlei,$mnum);
                if(!empty($qiulist)){
                    //随机从数组中取出一个
                    $qiuitem = $qiulist[array_rand($qiulist)];
                    $ma = $qiuitem['qiu'];
                    $save = [];
                    for ($i = 1; $i <= $mnum; $i++) {
                        $save['m'.$i] = $ma[$i - 1];
                    }
                    $save['status'] = 1;
                    $save['jyhash'] = $qiuitem['hash'];
                    $kjServices->update($save,['qishu'=>$kj['qishu']]);
                    $qkhash = TronHashService::getblockhashbyblock($qiuitem['block']);
                    $kjServices->update(['qkhash'=>$qkhash],['qishu'=>$kj['qishu']]);
                    $is_Update = 1;
                }
            } else {
                /*if($game[$k]['laiyuan'] == 0){
                    $cha = time()-$kj['kjtime'];
                    if($cha <= 30){
                        continue;
                    }
                    $game[$k]['guanfang'] == 0;
                }*/
                if ($game[$k]['guanfang'] == 0) {//系统开奖
                    $m = JsFunc::calcmoni($fenlei, $gid);
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
                    $kjServices->where(['gid'=>$gid,'qishu'=>$kj['qishu']])->update($save);
                    $is_Update = 1;
                } else {
                    /*$url = 'http://api.fiash.top/sgwinapi.php?gid=' . $gid . '&qishu=' . $qs;
                    //$ma = file_get_contents($url);
                    $ma = HttpService::getRequest($url);
                    $ma = json_decode($ma, true);

                    foreach ($ma as $key => $value) {
                        if (!is_array($value['m'])) {
                            $value['m'] = explode(',', $value['m']);
                        }
                        if (!is_numeric($value['m'][0]) || !is_numeric($value['m'][$mnum - 1])) {
                            continue;
                        }
                        if ($value['qishu'] == $qishu) {
                            $sql = "update `$tb` set ";
                            for ($i = 1; $i <= $mnum; $i++) {
                                if ($i > 1) {
                                    $sql .= ',';
                                }
                                $sql .= 'm' . $i . '=\'' . $value['m'][$i - 1] . '\'';
                            }
                            $sql .= " where  gid='{$gid}' and qishu='{$qishu}' ";
                            $db->query($sql);
                            $updatesearchqishustatus = 1;
                            break;
                        }
                    }*/
                    if ($gid == 170) { // 极速飞艇
                        $url = $kjurl.'pks/getLotteryPksInfo.do?lotCode=10035';
                        //$ma = HttpService::getRequest($url);
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    }else if ($gid == 121) { // 极速11选5
                        $url = $kjurl.'ElevenFive/getElevenFiveInfo.do?issue=&lotCode=10055';
                        $ma = CsFunc::curl_get(1, $url);
                        //$ma = HttpService::getRequest($url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        /*$m[5] = '0';
                        $m[6] = '0';
                        $m[7] = '0';
                        $m[8] = '0';
                        $m[9] = '0';*/
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 253) { // 极速快乐十分
                        $url = $kjurl.'klsf/getLotteryInfo.do?lotCode=10053';
                        $ma = CsFunc::curl_get(1, $url);
                        //$ma = HttpService::getRequest($url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 255) { // 极速快三
                        $url = $kjurl.'lotteryJSFastThree/getBaseJSFastThree.do?issue=&lotCode=10052';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 172) { //极速赛车
                        $url = $kjurl.'pks/getLotteryPksInfo.do?lotCode=10037';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 168) { //极速赛车
                        $url = $kjurl.'pks/getLotteryPksInfo.do?lotCode=10035';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 108) { //极速时时彩
                        $url = $kjurl.'CQShiCai/getBaseCQShiCai.do?lotCode=10036';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 164) { //极速快乐8
                        $url = $kjurl.'LuckTwenty/getBaseLuckTewnty.do?lotCode=10054';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    }else if ($gid == 200) { //极速六合彩
                        $url = $kjurl.'speedSix/findSpeedSixInfo.do';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 109) { //澳洲幸运5
                        $url = $kjurl.'CQShiCai/getBaseCQShiCai.do?lotCode=10010';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 169) { //澳洲幸运8
                        $url = $kjurl.'klsf/getLotteryInfo.do?lotCode=10011';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 131) { // 澳洲幸运8
                        $url = $kjurl.'klsf/getLotteryInfo.do?lotCode=10011';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 175) { //澳洲幸运10
                        $url = $kjurl.'pks/getLotteryPksInfo.do?lotCode=10012';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 162) { //澳洲幸运20
                        $url = $kjurl.'LuckTwenty/getBaseLuckTewnty.do?lotCode=10013';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        $one = 0;
                        $two = 0;
                        $three = 0;
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                            if($i <= 6){
                                $one+=$m[$i - 1];
                            }elseif ($i <= 12){
                                $two+=$m[$i - 1];
                            }elseif ($i <= 18){
                                $three+=$m[$i - 1];
                            }
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        //更新PC蛋蛋幸运28
                        $kjs = CommonService::getKjmodel(163);
                        $kjs->where(['gid'=>163,'qishu'=>$qishu])->update(['m1'=>$one%10,'m2'=>$two%10,'m3'=>$three%10,'status'=>1]);
                        $is_Update = 1;
                    } else if ($gid == 444) { //台湾宾果
                        $url = $kjurl.'LuckTwenty/getBaseLuckTewnty.do?lotCode=10047';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 167) { //台湾5分彩
                        $url = $kjurl.'CQShiCai/getBaseCQShiCai.do?lotCode=10064';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 177) { //SG飞艇
                        $url = $kjurl.'pks/getLotteryPksInfo.do?lotCode=10058';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 310) { //SG时时彩
                        $url = $kjurl.'CQShiCai/getBaseCQShiCai.do?lotCode=10075';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 312) { //SG快乐8
                        $url = $kjurl.'LuckTwenty/getBaseLuckTewnty.do?issue=&lotCode=10082';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 313) { //SG快乐十分
                        $url = $kjurl.'klsf/getLotteryInfo.do?issue=&lotCode=10083';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 314) { //SG快3
                        $url = $kjurl.'lotteryJSFastThree/getBaseJSFastThree.do?issue=&lotCode=10076';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 315) { //SG11选5
                        $url = $kjurl.'ElevenFive/getElevenFiveInfo.do?issue=&lotCode=10084';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 191) { //幸运飞艇
                        $url = $kjurl.'pks/getLotteryPksInfo.do?lotCode=10057';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    } else if ($gid == 110) { //幸运时时彩
                        $url = $kjurl.'CQShiCai/getBaseCQShiCai.do?lotCode=10059';
                        $ma = CsFunc::curl_get(1, $url);
                        $ma = json_decode($ma, true);
                        if (!is_array($ma['result']['data'])) {
                            continue;
                        }
                        $m = explode(',', $ma['result']['data']['preDrawCode']);
                        $qishu = $ma['result']['data']['preDrawIssue'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $m[$i - 1];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$qishu])->update($save);
                        $is_Update = 1;
                    }else if($gid == 221 || $gid == 256 || $gid == 257 || $gid == 258 || $gid == 259 || $gid == 260 || $gid == 261 || $gid == 262 || $gid == 263 || $gid == 264){
                        $gameno = '81';
                        if($gid == 256)$gameno = '82';
                        if($gid == 257)$gameno = '83';
                        if($gid == 258)$gameno = '86';
                        if($gid == 259)$gameno = '27';
                        if($gid == 260)$gameno = '36';
                        if($gid == 261)$gameno = '37';
                        if($gid == 262)$gameno = '26';
                        if($gid == 263)$gameno = '34';
                        if($gid == 264)$gameno = '35';
                        $url = 'http://yun.citi668.com/ui-02/index.aspx/Chawinning_Two';
                        $ma = JsFunc::curl_post(0, $url,'',['gameno'=>$gameno]);
                        $json = json_decode($ma, true);
                        $data = $json['d'];
                        $data = json_decode($data, true);
                        $data = $data['Rows'][0];
                        $action_no = $data['roundno'];
                        $save = [];
                        for ($i = 1; $i <= $mnum; $i++) {
                            $save['m'.$i] = $data['lotteryno'.$i];
                        }
                        $save['status'] = 1;
                        $kjServices->where(['gid'=>$gid,'qishu'=>$action_no])->update($save);
                        $is_Update = 1;
                    }
                }
            }
            if($is_Update == 1 && ($game[$k]['fenlei'] == 107
                    || $game[$k]['fenlei'] == 101 || $game[$k]['fenlei'] == 121
                    || $game[$k]['fenlei'] == 103 || $game[$k]['fenlei'] == 151 || $game[$k]['fenlei'] == 161)){
                TongjiService::daytongjiall($gid,strtotime($dates),$game[$k]['fenlei'],$game[$k]['mnum']);
            }
        }
    }
}
