<?php

namespace App\ort\services;

use App\Common\Task\TaskRunOubet;
use App\Http\Controllers\Api\Member\DoubleCommonService;
use App\Models\Game\Autozj;
use App\Models\Game\Autozjlog;
use App\Models\Game\Followplan;
use App\Models\Game\FollowplanFrommember;
use App\Models\Game\FollowplanTomember;
use App\Models\Game\Game;
use App\Models\Game\Mclass;
use App\Models\Game\Play;
use App\Models\Game\Points;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use App\ort\HttpUtils;
use App\ort\sgwin\OutbetServices;
use App\ort\sgwin\SGUtils;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FollowPlanService
{
    public function bet($param){
        $play = $param['play'];
        $lottery = $param['lottery'];
        $game = Game::where('lottery', $lottery)->select(['dftype','gid'])->first();
        $dftypes = json_decode($game->dftype, true);
        $drawNumber = $param['drawNumber'];
        $userid = $param['userid'];
        $redis = app('redis.connection');
        $follow_redis_key = 'follow_list';
        $fids = $this->getfids($userid);
        $fromlist = FollowplanFrommember::where('userid',$userid)->get();
        $formlist2 = FollowplanFrommember::whereIn('userid',$fids)->get();
        //合并
        $fromlist = $fromlist->merge($formlist2);
        //通过属性id去除重复
        $fromlist = $fromlist->unique('followplan_id');
        $enable_flolow_tg = Cache::get('enable_flolow_tg',0);
        foreach ($fromlist as $v){
            $followplan = Followplan::where('id',$v->followplan_id)->first();
            if($followplan->enabled == 0){//是否启用
                continue;
            }
            $lotterylist = json_decode($followplan->lotteryList,true);
            if(!in_array($lottery,$lotterylist)){//是否包含彩种
                continue;
            }
            $percentage = $followplan->percentage;//跟投比例
            //查询投注会员列表
            $touserlist = FollowplanTomember::where('followplan_id',$followplan->id)->get();
            foreach ($touserlist as $touser) {
                if($touser->userid == $userid){
                    continue;
                }
                //校验密码
                if($touser['type'] == 1){//本服会员需要检测密码
                    $upass = User::where('userid',$touser->userid)->value('userpass');
                    $mypass = md5($touser['password'] . x_config('upass'));
                    if($upass != $mypass){
                        //更新关闭跟投
                        Followplan::where('id',$followplan->id)->update(['enabled'=>0]);
                        $oldenabledstr = '跟投中';$newenabledstr = '未跟投';
                        ComFunc::adduseredit(['userid'=>$followplan->userid,'mduserid'=>$followplan->userid,'sonuid'=>$followplan->userid,'action'=>'投注会员有密码变更、请检查修改','old'=>$oldenabledstr,'new'=>$newenabledstr,'moduleKey'=>'agentfollowbet','functionKey'=>'agentfollowplan','actionKey'=>'update']);
                        continue;
                    }
                }
                //克隆一份$play
                $ratio = $touser->ratio;
                $newplay = [];
                foreach ($play as $tp) {
                    $nowplay = $tp;
                    $amount = $tp['amount']*($percentage/100);
                    $amount = $amount*($ratio/100);
                    //$tp['amount'] = ComFunc::pr1($amount);
                    if (isset($tp['state'])) {
                        $cy = $tp['game'].'_'.$tp['state'];
                    }else{
                        $cy = $tp['game'].'_'.$tp['contents'];
                    }
                    $pp = Play::where(['gid'=>$game['gid'],'cy'=>$cy])->select(['pid','bid','sid','cid'])->first();
                    $dftype = Mclass::where(['cid'=>$pp['cid'],'gid'=>$game['gid']])->value('dftype');
                    if($followplan['indicator'] == 0){//反跟(两面)
                        if(SGUtils::islm($dftypes[$dftype])){
                            $tpp = Play::where(['gid'=>$game['gid'],'bid'=>$pp['bid'],'cid'=>$pp['cid']])->where('pid','<>',$pp['pid'])->value('cy');
                            $tpps = explode('_',$tpp);
                            $nowplay['game'] = $tpps[0];
                            $nowplay['contents'] = $tpps[1];
                        }
                    }

                    if($touser['type'] == 1){
                        //检测是否需要拆单，自身限额和跟投对象限额不同
                        $points = Points::where(['gid'=>$game['gid'],'userid'=>$touser->userid,'class'=>$dftype])->select(['maxje','cmaxje'])->first();
                        if($points['maxje'] < $amount){//如果超过单笔限额，则拆单
                            if($amount > $points['cmaxje']){
                                $amount = $points['cmaxje'];
                            }
                            $count = ceil($amount/$points['maxje']);
                            for ($i=0;$i<$count;$i++){
                                $nowplay['amount'] = ceil($amount >= $points['maxje'] ? $points['maxje'] : $amount);
                                $newplay[] = $nowplay;
                                $amount = $amount - $points['maxje'];
                            }
                        }else{
                            $nowplay['amount'] = ceil($amount);
                            $newplay[] = $nowplay;
                        }
                    }else{
                        $nowplay['amount'] = ceil($amount);
                        $newplay[] = $nowplay;
                    }
                }
                if($enable_flolow_tg == 0){
                    $fcount = Autozj::where('userid',$userid)->count('id');
                    if($fcount > 0){
                        Autozj::where('userid',$userid)->update(['fwtime'=>time()]);
                        Autozjlog::create(['userid'=>$userid,'ziuserid'=>0,'time'=>time(),'path_name'=>'被跟投-'.$touser->userid,'ip'=>'127.0.0.1','type'=>1]);
                    }
                }
                //投注
                if($touser['type'] == 1){
                    (new DoubleCommonService())->bet($newplay,$lottery,$drawNumber,$touser->userid,1,0,$userid);
                }else{//外网会员跟投
                    $outb = ['tomember'=>$touser,'bet'=>$newplay,'drawNumber'=>$drawNumber,'lottery'=>$lottery,'error'=>0];
                    try {
                        $redis->rPush($follow_redis_key,json_encode($outb));
                    }catch (\Exception $e){
                        Log::info('跟投投注异常2：'.$e->getMessage());
                    }
                }
            }
        }
    }

    public function getfids($uid){
        $u = array();
        $user = User::where('userid',$uid)->select(['fid1','fid2','fid3','fid4','fid5','fid6','fid7','fid8','fid9','fid10','layer'])->first();
        $layer = $user['layer'];
        for ($i = $layer - 1; $i > 0; $i--) {
            if($user['fid'.$i] != 0){
                $u[] = $user['fid'.$i];
            }
        }
        return $u;
    }

    public function searchurlandname($domain,$username,$search){
        $cookie_jar = base_path().'/upload/cookie/dh'.$username.".txt";
        $url = $domain."/securimage_show.php?0.3699586200".rand(100000,999999);
        $res = HttpUtils::bdcurl($cookie_jar,$url,[],[],true,false,false);
        $base64 = base64_encode($res['data']);
        $ycode = (new OutbetServices)->commoncode($base64);
        $url = $domain."/";
        $postdata = ['do'=>'contact','search'=>$search,'ct_captcha'=>$ycode];
        $res = HttpUtils::bdcurl($cookie_jar,$url,$postdata,[],true,true,false);
        $html =  $res['data'];
        // 正则表达式模式，用于匹配 URL
        $pattern = '/<span class="url">(.+?)<\/span>/i';
        // 执行正则表达式匹配多个结果
        if (preg_match_all($pattern, $html, $match)) {
            foreach ($match[1] as $v){
                $url = str_replace('https://','',$v);
                $url = str_replace('http://','',$url);
                //是否包含-
                if(strpos($url,'-') === false){
                    continue;
                }
                $arr = explode('-',$url);
                $str = $arr[0];
                //如果长度等于10则跳出循环
                if(strlen($str) == 10){
                    $url = $v;
                    break;
                }
            }
            if(empty($url)){
                $url = $match[1][0];
            }
        }else {
            $url = '';
        }
        //搜索平台名称 <span class="light-blue-text">双赢SG-138演示平台</span>
        $pattern = '/<span class="light-blue-text">(.+?)<\/span>/i';
        // 执行正则表达式匹配
        if (preg_match($pattern, $html, $match)) {
            // 提取到的第一个 URL 存储在 $match[1] 中
            $name = $match[1];
        } else {
            $name = '';
        }
        return ['curl'=>$url,'webname'=>$name];
    }

    public function sgupdateblance($tomember){
        $cookie_jar = $tomember['cookie'];
        $baseurl = $tomember['curl'];
        $update = [];$key = 'follow:login:'.$tomember['id'];
        try {
            $head = [];
            $head['host'] = str_replace('https://','',$baseurl);
            //$head[':path'] = '/member/accounts?_='.time()*1000;
            $head['Referer'] = $baseurl.'/member/load?lottery=SSCJSC&page=lm';
            $url = $baseurl . "/member/accounts";
            $res = self::curl('GET',true,$cookie_jar,$url,[],$head,true,true,false,false);
            //Log::info('余额查询，信息：'.$res);
            //判断是否包含
            $resutl = json_decode($res['data'], true);
            if(empty($resutl)){
                $this->sglogin($baseurl,$tomember['username'],$tomember['password'],$tomember['followplan_id'], $tomember['id']);
                return false;
            }
            $resutl = $resutl[0];
            $balance = $resutl['balance'];
            $maxLimit = isset($resutl['maxLimit']) ? $resutl['maxLimit'] : 0;
            $sy = isset($resutl['result']) ? $resutl['result'] : 0;
            //$update['errors'] = 0;
            $update['bz'] = $balance.'|'.$maxLimit.'|'.$sy;
            Cache::set('followbalance_'.$tomember['id'],1,rand(20,50));
            count($update) > 0 && FollowplanTomember::where('id',$tomember['id'])->update($update);
        }catch (\Exception $e){
            Log::info('跟投余额查询异常：'.$e->getMessage());
            Cache::increment($key);
            $this->sglogin($baseurl,$tomember['username'],$tomember['password'],$tomember['followplan_id'], $tomember['id']);
        }
    }

    public function sgbet($param){
        $param = json_decode($param,true);
        $tomember = $param['tomember'];
        $bet = $param['bet'];
        $drawNumber = $param['drawNumber'];
        $lottery = $param['lottery'];
        $error = $param['error'];
        $cookie_jar = $tomember['cookie'];
        $arr = [];
        $arr['lottery'] = $lottery;
        $arr['ignore'] = true;
        $arr['fastBets'] = false;
        $arr['drawNumber'] = $drawNumber;
        $arr['bets'] = $bet;
        $url = $tomember['curl'];
        $head = [];
        $head['host'] = str_replace('https://','',$url);
        //$head[':path'] = '/member/bet';
        //$head[':scheme'] = 'https';
        $head['Origin'] = $url;
        $head['Referer'] = $url.'/member/index';
        $url = $url . "/member/bet";
        $res = self::curl('POST',false,$cookie_jar,$url,$arr,$head,true,true,true,false);
        $jsondata = json_decode($res['data'], true);
        if(env('IS_DEBUG_INFO')) {
            Log::info('跟投投注返回：' . json_encode($res));
        }
        $follow_redis_key = 'follow_list';$redis = TaskRunOubet::getredis();
        if(empty($jsondata)){
            if ($res['data'] && strpos($res['data'], '用户登录') !== false) {
                $param['error'] = $error+1;
                $key = 'follow:login:'.$tomember['id'];
                if(empty($key)){
                    $this->sglogin($tomember['curl'],$tomember['username'],$tomember['password'],$tomember['followplan_id'], $tomember['id']);
                }else{
                    Log::info("跟投-用户正在登录,继续等待".$tomember['username']);
                }
                if($error < 5){
                    $redis->rpush($follow_redis_key,json_encode($param));
                }
                return;
            }
            //从新让如队列执行
            if($error < 5){
                $param['error'] = $error+1;
                $redis->rpush($follow_redis_key,json_encode($param));
            }
        }else{
            if(isset($jsondata['status']) && $jsondata['status'] == 0){
                if (isset($jsondata['account'])){
                    $balance = isset($jsondata['account']['balance']) ? $jsondata['account']['balance'] : 0;
                    $maxLimit = isset($jsondata['account']['maxLimit']) ? $jsondata['account']['maxLimit'] : 0;
                    $result = isset($jsondata['account']['result']) ? $jsondata['account']['result'] : 0;
                    Cache::set('followbalance_'.$tomember['id'],1,rand(20,50));
                    FollowplanTomember::where('id',$tomember['id'])->update(['bz'=>$balance.'|'.$maxLimit.'|'.$result]);
                }
            }else{
                if(isset($jsondata['message'])){
                    $reason = $jsondata['message'];
                    //如果账号提示暂停投注，停止跟投
                    if(strpos($reason,'暂停投注') !== false){
                        Followplan::where('id',$tomember['followplan_id'])->update(['enabled'=>0]);
                    }
                }
            }
        }
    }

    public function sglogin($baseurl,$username,$password,$followplanid = 0,$tomemeberid = 0){
        if($tomemeberid > 0){
            $key = 'follow:login:'.$tomemeberid;
            $kscount = Cache::get($key);
            if($kscount > 5 && $followplanid > 0){
                //关闭跟投
                Followplan::where('id',$followplanid)->update(['enabled'=>0]);
            }
        }
        $result = [];
        $imageurl = $baseurl.'/code?'.time();
        $res = self::curl('GET',true,'',$imageurl,[],[],true,true,[],true);
        $base64 = base64_encode($res['data']);
        if(empty($base64)){
            $result['code'] = 0;
            $result['msg'] = '获取验证码失败';
            $tomemeberid > 0 && Cache::increment($key);
            return $result;
        }
        $code = (new OutbetServices())->commoncode($base64);
        if(empty($code)){
            $result['code'] = 0;
            $result['msg'] = '识别验证码失败';
            $tomemeberid > 0 && Cache::increment($key);
            return $result;
        }
        $url = $baseurl . "/login";
        $post = ['type' => '1', 'account'=>$username,'password'=>$password,'code'=>$code];
        $cookie_jar = $res['cookie'];
        $res = self::curl('POST',true,$cookie_jar,$url,$post,[],true,true,false,true);
        $data = $res['data'];
        $result['cookie'] = $res['cookie'];
        if($tomemeberid > 0){
            FollowplanTomember::where('id',$tomemeberid)->update(['cookie'=>$res['cookie']]);
        }
        if (strpos($data, '验证码错误') !== false) {
            $result['code'] = 0;
            $result['msg'] = '验证码错误';
            $tomemeberid > 0 && Cache::increment($key);
        }else{
            if (strpos($data, '账号或密码错误') !== false) {
                $result['code'] = 0;
                $result['msg'] = '账号或密码错误';
                $tomemeberid > 0 && Cache::increment($key);
            }elseif (strpos($data, '你的帐号已被冻结') !== false) {
                $result['code'] = 0;
                $result['msg'] = '帐号已被冻结';
                $tomemeberid > 0 && Cache::increment($key);
            }elseif (strpos($data, '暂停投注') !== false) {
                $result['code'] = 0;
                $result['msg'] = '已被暂停投注';
                $tomemeberid > 0 && Cache::increment($key);
            }elseif (strpos($data, '账户已禁用') !== false) {
                $result['code'] = 0;
                $result['msg'] = '账户已禁用';
                $tomemeberid > 0 && Cache::increment($key);
            }elseif (strpos($data, '用户协议') !== false || strpos($data, 'agreement.css') !== false) {
                $result['code'] = 1;
                $result['msg'] = '登陆成功';
                $tomemeberid > 0 && Cache::delete($key);
            }elseif (strpos($data, '秒内只能登录一次') !== false) {
                $result['code'] = 0;
                $result['msg'] = '15秒内只能登录一次，请稍后再试';
                $tomemeberid > 0 && Cache::increment($key);
            }elseif (strpos($data, '修改密码') !== false) {
                $result['code'] = 0;
                $result['msg'] = '的账号需先登录修改密码';
                $tomemeberid > 0 && Cache::increment($key);
            }else{
                $result['code'] = 0;
                $result['msg'] = '登陆失败';
                $tomemeberid > 0 && Cache::increment($key);
            }
        }
        return $result;
    }

    private static $client = null;
    private static $clientproxy = null;
    public static function getClient(){
        $use_proxy = x_config('use_proxy');
        if($use_proxy == 1){
            if (self::$clientproxy === null) {
                $proxy_url = x_config('proxy_url');
                self::$clientproxy = new Client([
                    'allow_redirects' => [
                        'max' => 20,
                        'strict' => true,
                        'referer' => true,
                        'protocols' => ['https'],
                        'stream' => true,  // 追加stream选项
                    ],
                    'proxy'=>$proxy_url,
                    //'proxy'=>'http://43.159.18.174:21795','user-lu7602087-region-ph-sessid-phjk1do9def4xs6r3r-sesstime-90:iIxOsZ@as.zvopwcbi.lunaproxy.net:12233'
                ]);
            }
            return self::$clientproxy;
        }else{
            if (self::$client === null) {
                self::$client = new Client([
                    'allow_redirects' => [
                        'max' => 20,
                        'strict' => true,
                        'referer' => true,
                        'protocols' => ['https'],
                        'stream' => true,  // 追加stream选项
                    ],
                ]);
            }
            return self::$client;
        }
    }

    public static function curl($type,$issavecookie,$cookieJar,$url,$postdata,$head,$location,$sslhostflag,$json,$isreturncookie){
        if(empty($cookieJar)){
            $cookieJar = new CookieJar();
        }else{
            $cookieJar = unserialize($cookieJar);
        }
        $client = self::getClient();
        $params = [];
        $head['Accept-Encoding'] = 'gzip';
        $head['User-Agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36';
        $head['Sec-Ch-Ua'] = 'Google Chrome";v="119", "Chromium";v="119", "Not?A_Brand";v="24';
        $params['http_errors'] = false;
        $params['keepalive'] = true;
        $params['timeout'] = 12;
        $params['connect_timeout'] = 5;
        $params['headers'] = $head;
        $params['cookies'] = $cookieJar;
        $params['allow_redirects'] = $location;
        $params['verify'] = !$sslhostflag;
        $data = [];
        try {
            if ($type == 'POST'){
                if($json == true){
                    $params['json'] = $postdata;
                }else{
                    $params['form_params'] = $postdata;
                }
                $response = $client->request('POST', $url, $params);
            }else{
                $response = $client->request('GET', $url, $params);
            }
        }catch (\Exception $e){
            //return $e->getMessage();
            $data['data'] = '';
            if($isreturncookie){
                $serializedCookieJar = serialize($cookieJar);
                $data['cookie'] = $serializedCookieJar;
            }
            return $data;
        }
        if($isreturncookie){
            $serializedCookieJar = serialize($cookieJar);
            $data['cookie'] = $serializedCookieJar;
        }
        $data['data'] = $response->getBody()->getContents();
        return $data;
    }
}
