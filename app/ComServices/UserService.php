<?php

namespace App\ComServices;

use App\Models\Game\Game;
use App\Models\Game\Gamecs;
use App\Models\Game\MoneyLog;
use App\Models\Game\Online;
use App\Models\Game\OutbetSite;
use App\Models\Game\TaxUser;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function saveuser($param){
        $account = $param['account'];
        $password = $param['password'];
        $ishoutai = $param['ishoutai'];//是否后台添加
        $isapp = $param['isapp'];//是否app添加
        $mduserid = $param['mduserid'];
        $adminid = $param['adminid'];
        $roomid = $param['roomid'];
        $ruid = $param['ruid'];
        $type = $param['type'];
        if($isapp == 1){
            $code = $param['code'];
            $key = $param['key'];
            if(empty($account) || empty($password) || empty($code) || empty($key)){
                return ['code'=>0,'msg'=>'参数错误'];
            }
            $cacheCode = Cache::get($key);
            if($cacheCode != $code){
                return ['code'=>0,'msg'=>'验证码错误'];
            }
        }
        if(strlen(trim($account)) < 2){
            return ['code'=>0,'msg'=>'账号至少2位以上'];
        }
        //账号不能包含特殊字符
        if(!preg_match("/^[a-zA-Z0-9_]+$/",$account)){
            return ['code'=>0,'msg'=>'账号不能包含特殊字符'];
        }
        if(!isset($param['name']) || empty($param['name'])){
            //随机生成3位昵称
            $name = SGUtils::randomName();
        }else{
            $name = $param['name'];
        }
        $saveuser = [];$saveuserreg = [];$saveuserroom = [];
        if($ishoutai == 1){//后台添加
            $fuser = User::where(['userid'=>$param['parent'],'ruid'=>$ruid])->first();
            if(empty($fuser)){
                return ['code'=>0,'msg'=>'上级账号不存在'];
            }
            $fuserroom = Userroom::where(['userid'=>$ruid])->first();
            if($type == 2 && $param['type'] == 2){//是否开放盘口设置
                $saveuserroom['pself'] = $param['pself'];
                $saveuserroom['ifexe'] = $param['ifexe'];
            }
            if($type == 2 && isset($param['tax_status'])){//赚点开关
                $saveuserroom['tax_status'] = $param['tax_status'];
            }
            if($type == 2 && isset($param['outbet_status'])){//飞单开关
                $saveuserroom['outbet_status'] = $param['outbet_status'];
            }
            //自定义ip
            if($param['adminlevel'] <= x_config('modify_ip_level') || in_array('order.znmodify',$param['auths'])){
                $saveuserreg['ipcustom'] = isset($param['ipcustom']) ? $param['ipcustom'] : '';
            }
            $thefid = $fuser['userid'];
            $ftime = strtotime(ComFunc::getthisdate());
            $saveuser['fid'] = $fuser['userid'];
            $saveuser['ifagent'] = $param['type'] == 4 ? 0 : 1;
            $saveuser['username'] = $account;
            $saveuser['name'] = $name;
            $saveuser['is_exclusive'] = $param['is_exclusive'];//是否专属账号
            $saveuser['yingdeny'] = isset($param['yingdeny']) ? $param['yingdeny'] : 0;
            $saveuser['ftime'] = $ftime;
            $saveuser['pan'] = '["A"]';
            $saveuser['type'] = $type;
            if($type == 2){
                $saveuserreg['type'] = 1;//房主账号
                $saveuserroom['roomName'] = $param['roomName'];
                $saveuserroom['roomNickname'] = $param['roomNickname'];
                $saveuserroom['roomStatus'] = $param['roomStatus'];
                $saveuserroom['auth_outbet_ip'] = $param['auth_outbet_ip'];
                $saveuserroom['outbet_overtime'] = $param['outbet_overtime'];
                if(!isset($param['expiryDate']) || empty($param['expiryDate'])) {
                    $saveuserroom['expiryDate'] = strtotime(date('Y-m-d H:i:s'));
                }else{
                    $saveuserroom['expiryDate'] = strtotime($param['expiryDate']);
                }
            }
        }

        //基础注册信息
        $saveuserreg['username'] = $account;
        $saveuserreg['name'] = $name;
        $saveuserreg['userpass'] = md5($password.x_config('upass'));
        $saveuserreg['ipfilter'] = isset($param['ipFilter']) ? $param['ipFilter'] : '';
        $saveuserreg['status'] = 0;
        $saveuserreg['regtime'] = time();
        $saveuserreg['passtime'] = time();
        if($type != 2){
            $saveuserreg['avatar'] = "/avatar/".rand(1,50).".jpg";
        }

        $ex_count = Userreg::where('username',$account)->count('userid');
        if($ex_count > 0){
            return ['code'=>0,'msg'=>'账号已存在'];
        }
        $db = Db::connection();
        $db->beginTransaction();
        try {
            if($ishoutai == 1 && $type == 2){
                //生成房间
                if(empty($roomid)){
                    for($i = 1;$i < 10;$i++){
                        $tmroomid = rand(199999,999999);
                        //判断房间id是否存在
                        $rc = Userroom::where('roomid',$tmroomid)->count('id');
                        if($rc <= 0){
                            $roomid = $tmroomid;
                            break;
                        }
                    }
                    if(empty($roomid)){
                        return ['code'=>0,'msg'=>'房间号生成失败，请重试'];
                    }
                }else{
                    //查询房间是否存在//
                    $rc = Userroom::where('roomid',$roomid)->count('id');
                    if($rc > 0){
                        return ['code'=>0,'msg'=>'房间号已存在'];
                    }
                }
            }elseif ($ishoutai == 1 && $type  != 2){
                $roomid = $fuserroom['roomid'];
            }
            $uid = Userreg::insertGetId($saveuserreg);
            if($ishoutai == 1 && $type == 2){
                $saveuserroom['roomid'] = $roomid;
                $saveuserroom['userid'] = $uid;
                Userroom::create($saveuserroom);//生成房间
            }
            //房间用户信息
            if($ishoutai == 1){
                $saveuser['userid'] = $uid;
                $saveuser['ruid'] = $uid;
                User::create($saveuser);
            }
            //检测是否开启赚点自动添加会员
            $plat_tax_status = x_config('plat_tax_status');
            if($ishoutai == 1 && $plat_tax_status == 1 && $saveuser['ifagent'] == 0){
                $dftaxtemplateid = $fuserroom['dftaxtemplateid'];
                $dftaxstatus = $fuserroom['dftaxstatus'];
                $fid1 = $fuser['userid'];
                if($dftaxstatus == 1 || $dftaxtemplateid > 0){
                    TaxUser::insert(['userid' => $uid,'ruid'=>$ruid,'tax_status'=>$dftaxstatus, 'tax_template_id'=>$dftaxtemplateid,'fid'=>$fid1,'flayer'=>1,'tax_auto_close'=>0]);
                }
            }

            if ($ishoutai == 1 && $type == 2) {
                $db->insert("insert into x_userpatt select NULL,$uid,lottery,0,0,gid,patt,point,xsort,30,1,0,'','','','' from x_game");
                $db->insert("insert into x_gamemsg select NULL,gid,$uid,keyname,msg_name,msg_content,msg_time,remark,is_time,ifok from x_gamemsg where ruid={$thefid}");
                $lotterys = explode(',',$param['lotterys']);
                Userpatt::where(['userid'=>$uid])->whereIn('lottery',$lotterys)->update(['ifopen'=>1]);
            }
            /*if($ishoutai == 1){
                if($type  == 2){
                    $db->insert("insert into x_points select NULL,gid,$uid,$uid,point from x_game");
                }else{
                    $db->insert("insert into x_points select NULL,gid,$ruid,$uid,if(point-$commission<0,0,point-$commission) from x_points where userid='$thefid'");
                }
            }*/
            if($mduserid == 0){
                $mduserid = $uid;
            }
            //插入online表
            $online = new Online();
            $online->ruid = $saveuser['ruid'];
            $online->userid = $uid;
            $online->online = 0;
            $online->lastOnlineTime = 0;
            $online->type = $type;
            $online->robot = 0;
            $online->save();
            ComFunc::adduseredit(['userid'=>$uid,'mduserid'=>$mduserid,'adminid'=>$adminid,'action'=>'新增用户','moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'add']);
            $db->commit();
            return ['code'=>1,'msg'=>'保存成功','username'=>$account,'userid'=>$uid];
        }catch (\Exception $e){
            Log::info('新增用户失败：'.$e->getMessage().$e->getTraceAsString());
            $db->rollBack();
            return ['code'=>0,'msg'=>'保存失败'];
        }
    }

    public function updateuser($param){
        $username = $param['account'];
        $password = $param['password'];
        $roomid = $param['roomid'];
        $lotterys = $param['lotterys'];
        $type = $param['type'];
        $userreg = Userreg::where('username',$username)->first();
        if(empty($userreg)){
            return ['code'=>0,'msg'=>'用户不存在'];
        }
        $user = User::where('username',$username)->first();
        if(empty($user)){
            return ['code'=>0,'msg'=>'用户不存在'];
        }
        $updatereg = [];$updateRoom = [];
        if(isset($param['ipcustom'])){
            $updatereg['ipcustom'] = $param['ipcustom'];
        }
        if(isset($param['ipfilter'])){
            $updatereg['ipfilter'] = $param['ipfilter'];
        }
        if(!empty($password)){
            $updatereg['userpass'] = md5($password.x_config('upass'));
        }
        if($type == 2){
            $updateRoom['roomName'] = $param['roomName'];
            $updateRoom['roomNickname'] = $param['roomNickname'];
            $updateRoom['expiryDate'] = strtotime($param['expiryDate']);
            $updateRoom['roomStatus'] = $param['roomStatus'];
            $updateRoom['auth_outbet_ip'] = $param['auth_outbet_ip'];
            $updateRoom['outbet_overtime'] = $param['outbet_overtime'];
            if(!empty($roomid)){
                $updateRoom['roomid'] = $roomid;
            }
            $updateRoom['tax_status'] = $param['tax_status'];
            $updateRoom['outbet_status'] = $param['outbet_status'];
        }
        $db = Db::connection();
        $db->beginTransaction();
        try {
            if($type == 2){
                if(!empty($param['auth_outbet_ip'])){
                    OutbetSite::where(['userid'=>$userreg['userid']])->update(['auth_outbet_ip'=>$param['auth_outbet_ip']]);
                }
                Userroom::where('userid',$userreg['userid'])->update($updateRoom);
                //更新可玩彩种
                Userpatt::where(['userid'=>$userreg['userid']])->update(['ifopen'=>0]);
                $gids = Game::whereIn('gid', function ($query) use ($userreg){
                    $query->select('gid')->from('userpatt')->where(['userid'=>$userreg['userid']]);
                })->whereIn('lottery',explode(',',$lotterys))->where('ifopen', 1)->pluck('gid')->toArray();
                Userpatt::where(['userid'=>$userreg['userid']])->whereIn('gid',$gids)->update(['ifopen'=>1]);
            }
            Userreg::where('username',$username)->update($updatereg);
            $db->commit();
            return ['code'=>1,'msg'=>'修改成功'];
        }catch (\Exception $e){
            Log::info('修改用户失败：'.$e->getMessage().$e->getTraceAsString());
            $db->rollBack();
            return ['code'=>0,'msg'=>'保存失败'];
        }
    }

    public function getlist(Request $request,$userid){
        $type = $request->input('type','');//2代理 1会员
        $name = $request->input('name','');
        $fid = $request->input('fid','');
        $status = $request->input('status','');
        $resetType = $request->input('resetType','');
        $page = $request->input('page',1);
        $ruid = $request->input('ruid','');
        $roomid = $request->input('roomid','');
        //分页查询用户User
        $usermode = User::with(['userreg'])->where(['robot'=>0,'is_del'=>0,'ifson'=>0]);
        //$fuserroomb = Userreg::where(['roomid'=>$fuser['roomid'],'userid'=>$userid])->first();
        if(!empty($name)){
            $usermode = $usermode->where('username',$name);
        }
        if($status != ''){
            $usermode = $usermode->where('status',$status);
        }
        if(!empty($fid)){
            $usermode = $usermode->where('fid',$fid);
        }
        if(!empty($type)){
            $usermode = $usermode->where('type',$type);
        }
        if(!empty($ruid)){
            $usermode = $usermode->where('ruid',$ruid);
        }
        if(empty($ruid)){
            $fuser = User::where(['userid'=>Constants::$SUID])->first();
            $fusername = $fuser['username'];
            $fuserid = $fuser['userid'];
        }else{
            $fuser = User::where(['userid'=>$fid,'ruid'=>$ruid])->first();
            $fusername = $fuser['username'];
            $fuserid = $fuser['userid'];
        }
        $pagesize = 20;
        $queryfields = ['*'];
        $userlist = $usermode->select($queryfields)->orderByRaw('id desc')->paginate($pagesize);
        //计算总页数
        $total = $userlist->total();
        $totalPage = ceil($total/$pagesize);
        $userlist->totalPage = $totalPage;
        foreach ($userlist as &$item){
            $userreg = $item['userreg'];
            $item['roomid'] = Userroom::where(['userid'=>$item['ruid']])->value('roomid');
            if(!empty($userreg)){
                if($item['fid'] > 0){
                    $pusername = User::where('userid',$item['fid'])->value('username');
                    $item['pusername'] = $pusername;
                }
                $item['kmaxmoney'] = ComFunc::pr1($item['kmoney']);
                $item["layername"] = SGUtils::getUtypeStr($item['type']);
                if($item['ifagent'] == 1){
                    $item['downnum1'] = User::where(['fid'=>$item['userid'],'ifagent'=>1,'ruid'=>$item['ruid']])->count('userid');
                    $item['downnum2'] = User::where(['fid'=>$item['userid'],'ifagent'=>0,'ruid'=>$item['ruid']])->count('userid');
                    $item['downson'] = Userreg::where(['ruid'=>$item['userid'],'type'=>1,'ifson'=>1])->count('userid');
                }else{
                    $item['downnumag'] = 0;
                    $item['downnumu'] = 0;
                    $item['downson'] = 0;
                }
            }else{
                $item['pusername'] = '';
                $item['kmaxmoney'] = 0;
                $item["layername"] = '会员';
                $item['downnum1'] = 0;
                $item['downnum2'] = 0;
                $item['downson'] = 0;
                $item['downnumag'] = 0;
                $item['downnumu'] = 0;
            }
            $item['statusz'] = ComFunc::transstatus($item['userreg']['status']);
            $item['regtime'] = date('Y-m-d',$userreg['regtime']);
            //$item["pan"] = implode(',', json_decode($item['pan'], true));
            $online = Online::where(['ruid'=>$item['ruid'],'userid'=>$item['userid']])->value('online');
            $item['online'] = $online;
        }
        //左边代理树
        view()->share('list',$userlist);
        view()->share('username',$fusername);
        view()->share('fuserid',$fuserid);
        view()->share('roomid',$roomid);
        view()->share('ruid',$ruid);
        view()->share('type',$type);
        view()->share('name',$name);
        view()->share('fid',$fid);
        view()->share('status',$status);
        view()->share('resetType',$resetType);
        view()->share('plat_outbet_status',x_config('plat_outbet_status'));
        view()->share('outbet_name', x_config('outbet_name'));
        if ($totalPage <= 10) {
            view()->share('startpcount', 1);
            view()->share('endpcount', $totalPage);
        }else{
            if($page <= 10){
                $startpcount = 1;
                $endpcount = 10;
            }else{
                $tt = intval($page/10);
                $startpcount = $tt*10+1;
                if($startpcount > $totalPage){
                    $startpcount = $totalPage;
                }
                $endpcount = $tt*10+10;
                if($endpcount > $totalPage){
                    $endpcount = $totalPage;
                }
            }
            view()->share('startpcount', $startpcount);
            view()->share('endpcount', $endpcount);
        }
    }


    public function initRoomUser($uid,$ruid){
        $userreg = Userreg::where(['userid' => $uid])->select(['username','name'])->first();
        $c = User::where(['userid'=>$uid,'ruid'=>$ruid])->count('userid');
        if($c <= 0){
            $ftime = strtotime(ComFunc::getthisdate());
            //初始化房间数据
            $saveuser = [];
            $saveuser['fid'] = $ruid;
            $saveuser['ifagent'] = 0;
            $saveuser['username'] = $userreg['username'];
            $saveuser['name'] = $userreg['name'];
            $saveuser['is_exclusive'] = 0;//是否专属账号
            $saveuser['ftime'] = $ftime;
            $saveuser['pan'] = '["A"]';
            $saveuser['userid'] = $uid;
            $saveuser['ruid'] = $ruid;
            $saveuser['type'] = 4;
            User::create($saveuser);
        }
    }

    /**
     * @param $userid 会员id
     * @param $ruid 房主uid
     * @param $money 变动金额
     * @param $iswritelog 是否写入日志
     * @param $operateType 操作类型 1：增加 2：减少
     * @param $logArr 资金变动数组
     * @param $libmodel 订单model
     * @param $bets 下注信息
     * @return array
     * @throws \Throwable
     */
    public static function operBalance($userid,$ruid,$money,$iswritelog = 1,$operateType = 1,$logArr = [],$libmodel = null,$bets = []){
        $retryCount = 10; // 设置重试次数
        $db = Db::connection();
        do {
            try {
                // 启动数据库事务
                $db->beginTransaction();
                // 获取当前余额并锁定选定的行
                $user = User::where(['userid'=>$userid,'ruid'=>$ruid])->select(['kmoney','version'])->first();
                $version = $user['version'];
                $update = [];
                // 根据类型更新余额
                if ($operateType == 1) {//增加
                    $newBalance = $user['kmoney'] + $money; // 示例：加 100
                } elseif ($operateType == 2) {//减少
                    //判断余额是否足够
                    if($money > $user['kmoney']){
                        throw new \Exception('余额不足');
                    }
                    $newBalance = $user['kmoney'] - $money; // 示例：减 100
                } else {
                    throw new \Exception('余额操作失败');
                }
                $update['kmoney'] = $newBalance;
                $update['version'] = $version + 1;
                // 更新余额
                $res = User::where(['userid'=>$userid,'ruid'=>$ruid,'version'=>$version])->update($update);
                if($res <= 0){
                    throw new \Exception('余额更新失败');
                }
                // 写入日志（如果需要）
                if ($iswritelog == 1) {
                    $savemoneylog = [];
                    $savemoneylog['ruid'] = $ruid;
                    $savemoneylog['userid'] = $userid;
                    $savemoneylog['mtype'] = 1;
                    $savemoneylog['beforeMoney'] = $user['kmoney'];
                    $savemoneylog['money'] = $money;
                    $savemoneylog['operateType'] = $operateType;
                    $savemoneylog['moneyType'] = isset($logArr['moneyType']) ? $logArr['moneyType'] : 1;
                    $savemoneylog['bz'] = isset($logArr['bz']) ? $logArr['bz'] : '';
                    $savemoneylog['gid'] = isset($logArr['gid']) ? $logArr['gid'] : 0;
                    $savemoneylog['qishu'] = isset($logArr['qishu']) ? $logArr['qishu'] : 0;
                    $savemoneylog['operUserid'] = isset($logArr['operUserid']) ? $logArr['operUserid'] : 0;
                    $savemoneylog['modisonuser'] = isset($logArr['modisonuser']) ? $logArr['modisonuser'] : 0;
                    $savemoneylog['time'] = time();
                    $savemoneylog['dates'] = strtotime(ComFunc::getthisdateend());
                    MoneyLog::create($savemoneylog);
                }
                if(!empty($libmodel)){
                    $libmodel->insert($bets);
                }
                // 提交事务
                $db->commit();
                break; // 操作成功，退出循环
            } catch (\Throwable $e) {
                Log::info("余额更新失败：".$e->getMessage().$e->getTraceAsString());
                // 发生异常时回滚事务
                $db->rollBack();
                if ($retryCount <= 0 || !str_contains($e->getMessage(), 'Lock wait timeout exceeded')) {
                    return ['code'=>0]; // 不是锁超时异常或者重试次数已用完，则抛出异常
                }
                $retryCount--; // 减少重试次数
                //usleep(rand(10000,50000)); // 等待一段时间后重试
            }
        } while (true);
        return ['code'=>1,'balance'=>$newBalance];
    }

    public static function getBalanceInfo($userid,$ruid){
        $utype = Userreg::where('userid',$userid)->value('type');
        $result = [];
        if($utype == 0){//会员
            $userinfo = User::where(['ruid'=>$ruid,'userid'=>$userid])->select(['kmoney','sy','jetotal','room_status'])->first();
            $result['kmoney'] = ComFunc::pr2($userinfo['kmoney']);
            $result['sy'] = ComFunc::pr2($userinfo['sy']);
            $result['jetotal'] = ComFunc::pr2($userinfo['jetotal']);
            //回水
            $result['backWater'] = 0;
            $result['room_status'] = $userinfo['room_status'];
        }else{//房主
            $db = Db::connection();
            $res = $db->select("SELECT SUM(kmoney) as kmoney,SUM(sy) as sy,SUM(jetotal) as jetotal FROM x_user WHERE ruid = {$ruid};");
            $result['kmoney'] = ComFunc::pr2($res[0]['kmoney']);
            $result['sy'] = ComFunc::pr2($res[0]['sy']*-1);
            $result['jetotal'] = ComFunc::pr2($res[0]['jetotal']);
            //回水
            $result['backWater'] = 0;
            $result['room_status'] = 1;
        }
        return $result;
    }
}