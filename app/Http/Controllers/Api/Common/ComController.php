<?php

namespace App\Http\Controllers\Api\Common;

use App\ComServices\ComServices;
use App\ComServices\GameServices;
use App\ComServices\WebsocketConstants;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ComController
{
    /**
     * 获取平台配置信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function siteConfig(Request $request){
        $headImageDomain = x_config('headImageDomain');
        $chatImageDomain = x_config('chatImageDomain');
        $openImageDomain = x_config('openImageDomain');
        $kjwurl = x_config('kjwurl');
        $config = [];//
        $config['headImageDomain'] = $headImageDomain;
        $config['chatImageDomain'] = $chatImageDomain;
        $config['openImageDomain'] = $openImageDomain;
        $config['kjwurl'] = $kjwurl;
        $config['open_register'] = x_config('open_register');
        return AppJson::success('ok',$config);
    }

    /**
     * 获取验证码
     * @return \Illuminate\Http\JsonResponse
     */
    public function captcha(){
        $path = base_path();
        $list = scandir($path."/public/sgcode");
        $cl = count($list);
        request()->headers->set('content-type', 'image/jpeg');
        $code = $list[rand(2,$cl-1)];
        $scode = substr($code,0,4);
        $return = [];
        if(is_numeric($scode)){
            $fullPath = $path."/public/sgcode/".$code;
            $base64 = base64_encode(file_get_contents($fullPath));
        }else{
            return AppJson::error('验证码生成失败');
        }
        //生成唯一的key
        $key = md5(time().rand(1000,9999));
        $return['key'] = $key;
        $return['base64'] = $base64;
        //缓存验证码
        Cache::set($key,$scode,600);
        return AppJson::success('ok',$return);
    }


    /**
     * 上传聊天图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadChatImage(Request $request){
        try {
            $file = $request->file('file');
            if (empty($file)) {
                return AppJson::error('请选择图片');
            }
            // 校验文件类型
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                return AppJson::error('图片类型不支持');
            }
            // 校验文件大小，限制为 2MB（2048 KB）
            $maxSize = 5 * 1024 * 1024;
            if ($file->getSize() > $maxSize) {
                return AppJson::error('最大支持单张图片大小5M');
            }
            $chatImageUploadMode = x_config('chatImageUploadMode');
            $url = UploadService::upload($chatImageUploadMode,$file,'customchat');
        } catch (\Exception $e) {
            return AppJson::error('上传失败');
        }
        return AppJson::success('ok', ['url' => $url]);
    }

    public function customChatRecords(Request $request){
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',50);
        $utype = $request->utype;$ruid = $request->ruid;
        if($utype == 1){//房主
            $uid = $request->input('uid',"");
            if(empty($uid)){
                return AppJson::error('参数错误');
            }
            $ucount = User::where(['ruid'=>$ruid,'userid'=>$uid])->count('id');
            if(empty($ucount)){
                return AppJson::error('会员账号不存在');
            }
        }else{
            $uid = $request->uid;
        }
        $custChatPageMode = x_config('custChatPageMode');
        $newchatlist = [];
        if($custChatPageMode == 1){//固定
            if($page == 1){
                $chatListKey = WebsocketConstants::$CustomerChatListKeyPre.':'.$ruid.':'.$uid;
                $chatList = Redis::lrange($chatListKey, -50, -1);
                $newchatlist = [];
                if(!empty($chatList)){
                    foreach ($chatList as $chat){
                        $newchatlist[] = json_decode($chat,true);
                    }
                }
            }
        }else{
            $db = Db::connection();
            $sql = "SELECT content,time,avatar,nickname,sender,chatType FROM x_chatmsg WHERE type = 'customer' and ruid = {$ruid} and msgGroupId = {$uid}";
            $sql = $sql. ' order by id desc limit ' .($page - 1) * $pageSize.",".$pageSize;
            $newchatlist = $db->select($sql);
        }
        foreach ($newchatlist as $k=>$item){
            if($k > 0){
                $diff = abs($newchatlist[$k-1]['time']-$item['time']);
                if($diff > 600){
                    $newchatlist[$k]['showtime'] = date('m-d H:i',$item['time']);
                }
            }else{
                $newchatlist[$k]['showtime'] = date('m-d H:i',$item['time']);
            }
        }
        if($custChatPageMode == 1) {//固定
            $newchatlist = array_reverse($newchatlist);
        }
        return AppJson::success('ok',['list'=>$newchatlist]);
    }

    public function chatRecords(Request $request){
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',50);
        $gid = $request->input('gid','');
        $isapp = $request->input('isapp',0);
        $ruid = $request->ruid;
        // 获取上一页的最后一条记录ID，用于基于ID的分页
        $lastId = $request->input('lastId', 0);
        
        if(empty($gid)){
            return AppJson::error('参数异常');
        }
        $gameChatPageMode = x_config('gameChatPageMode');
        $newchatlist = [];
        if($gameChatPageMode == 1) {//固定 - 修复分页逻辑
            $chatListKey = WebsocketConstants::$chatListKeyPre . ':' . $ruid . ':' . $gid;
            // 计算Redis分页的起始和结束位置
            $totalCount = Redis::llen($chatListKey);
            $start = max(0, $totalCount - $page * $pageSize);
            $end = $totalCount - ($page - 1) * $pageSize - 1;
            
            if($start <= $end && $totalCount > 0) {
                $chatList = Redis::lrange($chatListKey, $start, $end);
                if (!empty($chatList)) {
                    foreach ($chatList as $chat) {
                        $item = json_decode($chat, true);
                        if($isapp == 1) {
                            if (!isset($item['mtype']) || $item['mtype'] == 0) {
                                $item['content'] = preg_replace('/<br>/i', '', $item['content']);
                            } else {
                                foreach ($item['content'] as $k => $it) {
                                    $item['content'][$k]['con'] = preg_replace('/<br>/i', '', $it['con']);
                                }
                            }
                        }
                        $newchatlist[] = $item;
                    }
                    // 由于Redis lrange返回的是正序，需要反转以保持时间倒序
                    $newchatlist = array_reverse($newchatlist);
                }
            }
        }else{
            $db = Db::connection();
            // 修复动态模式：使用基于ID的分页，避免数据重复
            $sql = "SELECT content,time,avatar,nickname,chatType,mtype,other,isA,sender,id FROM x_chatmsg WHERE type = 'game' and gid = {$gid} and ruid = {$ruid}";
            
            // 如果有lastId，使用基于ID的分页（推荐方式）
            if($lastId > 0) {
                $sql .= " AND id < {$lastId}";
                $sql = $sql. ' order by id desc limit ' . $pageSize;
            } else {
                // 兼容传统页码分页方式
                $sql = $sql. ' order by id desc limit ' .($page - 1) * $pageSize.",".$pageSize;
            }
            
            $newchatlist = $db->select($sql);
            
            foreach ($newchatlist as &$item){
                if($item['mtype'] == 1 || $item['mtype'] == 2){
                    $item['content'] = json_decode($item['content'],true);
                }
                if($item['mtype'] == 1){
                    $item['other'] = json_decode($item['other'],true);
                }
            }
        }
        
        // 返回结果中包含nextLastId，用于下一页查询
        $result = ['list' => $newchatlist];
        if(!empty($newchatlist) && $gameChatPageMode != 1) {
            $lastRecord = end($newchatlist);
            $result['nextLastId'] = $lastRecord['id'];
        }
        //
        return AppJson::success('ok', $result);
    }

    public function updatePwd(Request $request){
        $oldPassword = $request->post('oldPwd','');
        $password = $request->post('newPwd','');
        //校验密码必须8-16位大小写字母和数字的密码
        if(!preg_match('/^[a-zA-Z0-9]{8,16}$/',$password)){
            return AppJson::error('密码必须8-16位大小写字母和数字的密码');
        }
        $userid = $request->uid;
        $ruid = isset($request->ruid) ? $request->ruid : 0;
        $user = Userreg::where('userid', $userid)->select(['userpass','ipcustom'])->first();
        $upass = x_config('upass');
        $oldPassword = md5($oldPassword.$upass);
        $password = md5($password.$upass);
        if ($user['userpass'] != $oldPassword) {
            return AppJson::error('原密码错误');
        }
        $res = Userreg::where('userid',$userid)->update(['userpass'=>$password]);
        $ip = $request->ip();
        if($user['ipcustom']){
            $ip = $user['ipcustom'];
        }
        if ($res) {
            ComFunc::adduseredit(['ruid'=>$ruid,'ip'=>$ip,'userid'=>$userid,'mduserid'=>$userid,'sonuid'=>$userid,'action'=>'资料更改【密码】','moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'update']);
            return AppJson::success('修改成功');
        }else{
            return AppJson::error('修改失败');
        }
    }

    /**
     * 开奖结果列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resultByDate(Request $request){
        $currentPage = $request->input('page',1);
        $pageSize = $request->input('pageSize',50);
        $gid = $request->input('gid','');
        $date = $request->input('date','');
        if(empty($gid)){
            return AppJson::error('gid不能为空');
        }
        $result = (new GameServices())->resultByDate($currentPage,$pageSize,$gid,$date);
        return AppJson::success('ok',$result);
    }

    public function logout(Request $request){
        $uid = $request->uid;
        //清空在线数据
        if($request->utype == 1){//房主
            $ruid = $request->ruid;
            ComServices::clearOnlineData($ruid,$uid);
        }
        return AppJson::success('ok');
    }

    public function getOtherConfig(Request $request){
        $mode = $request->input('mode',1);
        $ruid = $request->ruid;
        $roomConfig = Userroom::where('userid',$ruid)->select(['maxDays'])->first();
        $maxDays = $roomConfig['maxDays'];
        $minDate = date('Y-m-d',strtotime("-{$maxDays} day"));
        $date = ComFunc::getthisdateend();
        if($mode == 1){
            $maxDate = $date;
        }else{
            $maxDate = date('Y-m-d');
        }
        $result = [];
        $result['minDate'] = $minDate;
        $result['maxDate'] = $maxDate;
        $result['date'] = $date;
        return AppJson::success('ok',$result);
    }

    /**
     * 获取游戏列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGameListByIfok(Request $request){
        $type = $request->input('type',0);
        $mode = $request->input('mode',1);
        $isdates = $request->input('isdates',0);
        $ruid = $request->ruid;
        $model = SGUtils::ruidGameModel($ruid);
        $gamelist = $model->select(['userpatt.gid','gname','template'])->orderBy('userpatt.xsort')->get()->toArray();
        $date = ComFunc::getthisdateend();
        $maxDays = Userroom::where('userid',$ruid)->value('maxDays');
        $minDate = date('Y-m-d',strtotime("-{$maxDays} day"));
        if($mode == 1){
            $maxDate = $date;
        }else{
            $maxDate = date('Y-m-d');
        }
        if($type == 1){//在头部添加一个全部游戏
            $allGame = ['gid'=>-1,'gname'=>'全部游戏','template'=>0];
            array_unshift($gamelist,$allGame);
        }
        $result = [];
        $result['list'] = $gamelist;
        $result['minDate'] = $minDate;
        $result['maxDate'] = $maxDate;
        $result['date'] = $maxDate;
        //获取今日，昨日。本周，上周
        if($isdates == 1){
            $result['sdate'] = AdminFunc::week();
        }
        return AppJson::success('ok',$result);
    }

    /**
     * 获取房间配置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoomConfig(Request $request){
        $ruid = $request->ruid;
        $roomConfig = Userroom::where(['userid'=>$ruid])->select(['banChat','webInputKeyboard','showTurnover','showPrediction','selfWater','showOdds','chatroomNicknameLength','automaticBackflow','roomStatus','expiryDate','show_online_count'])->first();
        $return = [];
        $return['banChat'] = $roomConfig['banChat'];
        $return['webInputKeyboard'] = $roomConfig['webInputKeyboard'];
        $return['showTurnover'] = $roomConfig['showTurnover'];
        $return['showPrediction'] = $roomConfig['showPrediction'];
        $return['selfWater'] = $roomConfig['selfWater'];
        $return['showOdds'] = $roomConfig['showOdds'];
        $return['chatroomNicknameLength'] = $roomConfig['chatroomNicknameLength'];
        $return['automaticBackflow'] = $roomConfig['automaticBackflow'];
        $return['show_online_count'] = $roomConfig['show_online_count'];
        $expiryDate = $roomConfig['expiryDate'];
        $roomStatus = $roomConfig['roomStatus'];
        if($roomStatus == 1){
            if($expiryDate < time()){
                $roomStatus = 0;
            }
        }
        $return['roomStatus'] = $roomStatus;
        //房间人数
        $return['onlineCount'] = User::where(['ruid'=>$ruid,'type'=>4,'ifson'=>0])->count('id');//Online::where(['ruid'=>$ruid,'online'=>1,'type'=>4])->count('id');
        return AppJson::success('ok',$return);
    }

    /**
     * 获取当前期数数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function period(Request $request){
        $gid = $request->input('gid','');
        if (empty($gid)){
            return AppJson::error('彩种id不能为空');
        }
        $ruid = $request->ruid;
        $result = (new GameServices())->period($ruid,$gid);
        return AppJson::success('ok',$result);
    }

    /**
     * 获取预测结果
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lotteryPredictInfo(Request $request){
        $gid = $request->input('gid','');
        if(empty($gid)){
            return AppJson::error('彩种id不能为空');
        }
        $result = (new GameServices())->lotteryPredictInfo($gid);
        return AppJson::success('ok',$result);
    }

    /**
     * 获取长龙榜数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function longdragon(Request $request){
        $gid = $request->input('gid','');
        if(empty($gid)){
            return AppJson::error('彩种id不能为空');
        }
        $result = (new GameServices())->longdragon($gid);
        return AppJson::success('ok',$result);
    }

    //上传开奖结果
    public function uploadResult(Request $request){
        $lottery = $request->input('lottery','');
        $openresult = $request->input('openresult','');
        $drawnumber = $request->input('drawnumber','');
        $token = $request->input('token','');
        if(empty($lottery)){
            return AppJson::error('彩种id不能为空');
        }
        if(empty($openresult)){
            return AppJson::error('开奖结果不能为空');
        }
        if(empty($drawnumber)){
            return AppJson::error('开奖期数不能为空');
        }
        if(empty($token) || $token != env('upload_result_token')){
            return AppJson::error('token错误');
        }
        $game = Game::where(['lottery'=>$lottery])->select(['gid','mnum'])->first();
        if(empty($game)){
            return AppJson::error('彩种不存在');
        }
        $gid = $game['gid'];
        $mnum = $game['mnum'];
        $kj = Kj::where(['gid'=>$gid,'qishu'=>$drawnumber])->first();
        if(empty($kj)){
            return AppJson::error('开奖期数不存在');
        }
        if(!empty($kj['m1'])){
            return AppJson::error('开奖结果已存在');
        }
        $m = explode(',',$openresult);
        for($i=1;$i<=$mnum;$i++){
            $kj['m'.$i] = $m[$i-1];
        }
        $kj['up_time'] = time();
        $kj['up_from'] = 2;
        $kj->save();
        return AppJson::success('ok');
    }
}
