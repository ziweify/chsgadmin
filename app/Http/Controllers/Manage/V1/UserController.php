<?php

namespace App\Http\Controllers\Manage\V1;


use App\ComServices\UserService;
use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Admin;
use App\Models\Game\Game;
use App\Models\Game\Gamecs;
use App\Models\Game\Gamezc;
use App\Models\Game\Gamezcback;
use App\Models\Game\MoneyLog;
use App\Models\Game\OutbetSite;
use App\Models\Game\TaxUser;
use App\Models\Game\User;
use App\Models\Game\UserEdit;
use App\Models\Game\UserLogin;
use App\Models\Game\UserPage;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\Models\Game\WaterUser;
use App\ort\common\AdminFunc;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\glob\IpUtils;
use App\ort\services\CommonServices;
use App\ort\sgwin\HtService;
use App\ort\sgwin\Json;
use App\ort\sgwin\SGUtils;
use App\ort\sgwin\UserOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends ManageAuthController
{
    public function list(Request $request){
        (new UserService())->getlist($request,$this->uid);
        return view('managev1.user.list');
    }

    public function status(Request $request){
        $username = $request->input('username','');
        $status = $request->input('status','');
        $user = User::where('username',$username)->first();
        if(empty($user)){
            return '用户不存在';
        }
        return $this->updatestatus($user,$status);
    }

    public function updatestatus($user,$status){
        $db = Db::connection();
        $fid = $user['fid'];$uid = $user['userid'];$ifagent = $user['ifagent'];$layer = $user['layer'];
        $sta = User::where('userid', $fid)->value('status');
        if ($sta == 1 && ($status == 0 || $status == 1)) {
            return '上级用户已被冻结';
        }
        if ($sta == 2 && $status == 0) {
            return '上级用户已被停用';
        }
        $newstatus = $status == 0 ? '启用' : ($status == 1 ? '冻结' : '禁用');
        $res = User::where(['userid' => $uid])->update(['status' => $status]);
        if ($res) {
            if (($status == 1 || $status == 2) && $ifagent == 1) {
                User::where(['fid' => $uid, 'ifson' => 1])->update(['status' => $status]);
                //更新所有下级的x_complex 表enabled为0
                $db->update("update x_complex set enabled=0 where userid in (select userid from x_user where fid{$layer}='{$uid}')");
            }
            if (($status == 1 || $status == 2) && $user['ifagent'] == 1) {//禁用或冻结
                $list = User::where('fid'.$user['layer'], $uid)->select(['userid','status'])->get();
                foreach ($list as $item) {
                    if($status != $item['status']){
                        $db->update("update x_user set status='$status',online=0 where userid='{$item->userid}'");
                        $oldstatus = $item['status'] == 0 ? '启用' : ($item['status'] == 1 ? '冻结' : '禁用');
                        ComFunc::adduseredit(['action'=>'帐号状态','userid'=>$item['userid'],'mduserid'=>$this->uid,'adminid'=>$this->adminid,'old'=>$oldstatus,'new'=>$newstatus,'moduleKey'=>'user','functionKey'=>'status','actionKey'=>'update']);
                    }
                    UserOnline::deleteUserOnlineInfo($item->userid);
                }
            }
            /*if ($status == 1 || $status == 2) {//停用或冻结
                $ugroup = ComFunc::getuserids($uid);
                UserOnline::deleteUserOnlinebyuserids($ugroup);
                //更新x_user online=0
                $ustr = implode(',', $ugroup);
                $db->update("update x_user set online=0 where userid in ($ustr)");
            }*/
            $oldstatus = $user['status'] == 0 ? '正常' : ($user['status'] == 1 ? '冻结' : '禁用');
            ComFunc::adduseredit(['action'=>'帐号状态','userid'=>$uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'old'=>$oldstatus,'new'=>$newstatus,'moduleKey'=>'user','functionKey'=>'status','actionKey'=>'update']);
        }
        return '';
    }

    public function edit(Request $request){
        $back = $request->input('back','');
        $parent = $request->input('fid','');
        $username = $request->input('username','');
        $type = $request->input('type','');//2代理 1会员
        $ruid = $request->input('ruid','');
        if(empty($username) && !empty($parent)){//添加
            if(!empty($ruid)){
                $fuser = User::where(['userid'=>$parent,'ruid'=>$ruid])->first();
            }else{
                $fuser = User::where(['userid'=>$parent,'ruid'=>Constants::$SUID])->first();
            }
            if (empty($fuser)){
                return Json::error('上级用户不存在');
            }
            if($fuser['ifagent'] == 0 || $fuser['ifson'] == 1){
                return Json::error('上级用户不存在');
            }
            $isupdate = 0;
            //加一个月时间
            view()->share('expiryDate',date('Y-m-d H:i:s',strtotime('+1 month')));
            view()->share('server_ip',env('SERVER_IP'));
        }else{//修改
            $user = User::where('username',$username)->first();
            $fuser = User::where('userid',$user['fid'])->first();
            $userreg = Userreg::where('userid',$user['userid'])->first();
            if($userreg['type'] == 1){
                $userroom = Userroom::where('userid',$user['userid'])->first();
                $userroom['expiryDate'] = date('Y-m-d H:i:s',$userroom['expiryDate']);
                $userroom['outbet_overtime'] = date('Y-m-d H:i:s',$userroom['outbet_overtime']);
                view()->share('userroom',$userroom);
            }
            view()->share('userreg',$userreg);
            view()->share('user',$user);
            $isupdate = 1;
        }
        view()->share('ifhide', $this->adminInfo['ifhide']);
        if ($isupdate){
            $userreg['ipaddress'] = '';
            if($this->adminInfo['ifhide'] == 1 && !empty($userreg['ipcustom'])){
                $userreg['ipaddress'] = IpUtils::getaddrbyip($userreg['ipcustom']);
            }
        }
        if($type == 2){//可玩彩种查询
            $lotterys = Game::where('ifopen', 1)->select(['gname','lottery'])->orderBy('xsort')->get()->toArray();
            $lotterysstr = '';
            $lotterykeys = '';
            foreach ($lotterys as $k=>$v){
                //格式XYFT=幸运飞艇;CQSSC=重庆时时彩
                $lotterysstr .= $v['lottery'].'='.$v['gname'].';';
                if(!$isupdate){
                    //格式XYFT,CQSSC 最后一个不加逗号
                    if($k == count($lotterys)-1){
                        $lotterykeys .= $v['lottery'];
                    }else{
                        $lotterykeys .= $v['lottery'].',';
                    }
                }
            }
            if($isupdate){
                $mylotterys = Game::whereIn('gid', function ($query)use ($user) {
                    $query->select('gid')->from('userpatt')->where(['userid'=>$user['userid'],'ifopen'=>1]);
                })->where('ifopen', 1)->select(['gname','lottery'])->orderBy('xsort')->get()->toArray();
                foreach ($mylotterys as $k=>$v){
                    //格式XYFT,CQSSC 最后一个不加逗号
                    if($k == count($mylotterys)-1){
                        $lotterykeys .= $v['lottery'];
                    }else{
                        $lotterykeys .= $v['lottery'].',';
                    }
                }
            }
            view()->share('lotterysstr',$lotterysstr);
            view()->share('lotterykeys',$lotterykeys);
        }
        view()->share('isupdate',$isupdate);
        view()->share('back',$back);
        view()->share('parent',$parent);
        view()->share('ruid',$fuser['ruid']);
        view()->share('fusername',$fuser['username']);
        view()->share('type',$type);
        if($type == 2){
            return view('managev1.user.editagent');
        }else{
            return view('managev1.user.editmember');
        }
    }

    //检测账号是否存在
    public function check(Request $request){
        $username = $request->input('username','');
        if(empty($username))return Json::error('账号不能为空');
        $count = User::where('username',$username)->count('userid');
        if($count > 0){
            echo '账号已存在';
        }else{
            echo '';
        }
    }

    public function save(Request $request){
        $commission = $request->input('commission','');//退水
        $ipFilter = $request->input('ipFilter','');//IP限制
        $lotterys = $request->input('lotterys','');//可玩彩种
        $shares = $request->input('shares','');//占城列表
        $update = $request->input('update','');//是否是修改
        $user = $request->input('user','');//用户数据

        $param = [];
        $param['account'] = $user['username'];
        $param['password'] = $user['password'];
        $param['isapp'] = 0;
        $param['ishoutai'] = 1;
        $param['mduserid'] = $this->uid;
        $param['adminid'] = $this->adminid;
        $param['parent'] = $user['parent'];
        $param['tax_status'] = isset($user['tax_status']) ? $user['tax_status'] : 0;
        $param['water_status'] = isset($user['water_status']) ? $user['water_status'] : 0;
        $param['outbet_status'] = isset($user['outbet_status']) ? $user['outbet_status'] : 0;
        $param['adminlevel'] = $this->adminInfo['level'];
        $param['auths'] = $this->auths;
        $param['ipcustom'] = isset($user['ipcustom']) ? $user['ipcustom'] : '';
        $param['shareMode'] = isset($user['shareMode']) ? $user['shareMode'] : 0;
        $param['shares'] = $shares;
        $param['name'] = isset($user['name']) ? $user['name'] : '';
        $param['ipFilter'] = $ipFilter;
        $param['type'] = $user['type'];
        $param['yingdeny'] = isset($user['yingdeny']) ? $user['yingdeny'] : 0;
        $param['lotterys'] = $lotterys;
        $param['commission'] = $commission;
        $param['is_exclusive'] = isset($user['is_exclusive']) ? $user['is_exclusive'] : 0;
        $param['pself'] = isset($user['pself']) ? $user['pself'] : 0;
        $param['ifexe'] = isset($user['ifexe']) ? $user['ifexe'] : 0;
        $param['roomid'] = isset($user['roomid']) ? $user['roomid'] : 0;
        $param['ruid'] = isset($user['ruid']) ? $user['ruid'] : 0;
        $param['avatar'] = isset($user['avatar']) ? $user['avatar'] : '';
        $param['roomName'] = isset($user['roomName']) ? $user['roomName'] : '';
        $param['roomNickname'] = isset($user['roomNickname']) ? $user['roomNickname'] : '';
        $param['expiryDate'] = isset($user['expiryDate']) ? $user['expiryDate'] : '';
        $param['outbet_overtime'] = isset($user['outbet_overtime']) ? $user['outbet_overtime'] : '';
        $param['roomStatus'] = isset($user['roomStatus']) ? $user['roomStatus'] : 0;
        $param['auth_outbet_ip'] = isset($user['auth_outbet_ip']) ? $user['auth_outbet_ip'] : '';

        if($update == 1){
            $res = (new UserService())->updateuser($param);
            if($res['code'] == 0) {
                return Json::error($res['msg'],[],false);
            }else{
                return Json::success($res['msg'],[],false);
            }
        }else{
            $res = (new UserService())->saveuser($param);
            if($res['code'] == 0) {
                return Json::error($res['msg'],[],false);
            }else{
                return Json::success($res['msg'],$res['username'],false);
            }
        }
    }

    public function delUser(Request $request){
        $id = $request->input('id','');
        $name = $request->input('name','');
        $type = $request->input('type','');
        return view('managev1.user.delUser',compact('id','name','type'));
    }

    public function zh_delete(Request $request){
        $ruid = $request->input('ruid','');
        $userid = $request->input('userid','');
        $pass = $request->input('pass','');
        if ($pass != x_config('supass')) {
            return Json::error('密码错误！');
        }
        $user = User::where(['ruid'=>$ruid,'userid'=>$userid])->first();
        if (empty($user)) {
            return Json::error('用户不存在！');
        }
        if($this->adminInfo['ifhide'] == 0){
            $libmodel = SGUtils::getcuremodel();
            $count = $libmodel->where(['userid'=>$user['userid']])->count('userid');
            if ($count > 0) {
                return Json::error('该用户存在今日下注，无法删除！');
            }
        }
        $res = HtService::clearaccount($user);
        if($res['code'] == 1){
            return Json::success('删除成功！');
        }else{
            return Json::error($res['msg']);
        }
    }

    public function param(Request $request){
        $userid = $request->input('username','');
        $ruid = $request->input('ruid','');
        (new CommonServices())->parampoint($userid,$ruid);
        return view('common.user.param');
    }

    public function saveParam(Request $request){
        $userid = $request->input('userid','');
        $ruid = $request->input('ruid','');
        $params = $request->input('params','');
        $downLine = $request->input('downLine','');
        if(empty($userid) || empty($ruid)){
            return Json::error('参数错误');
        }
        $res = (new CommonServices())->savepoints($userid,$ruid,$params,$downLine,$this->uid,$this->adminid);
        if($res['code'] == 1){
            return Json::success($res['msg']);
        }else{
            return Json::error($res['msg']);
        }
    }


    public function account(Request $request){
        $userid = $request->input('userid','');
        $ruid = $request->input('ruid','');
        $user = User::where(['userid'=>$userid,'ruid'=>$ruid])->first();
        view()->share('user',$user);
        return view('managev1.user.account');
    }

    public function editAccount(Request $request){
        $je = $request->input('value','');
        $types = $request->input('updatetype','');
        $userid = $request->input('userid','');
        $ruid = $request->input('ruid','');
        if (!is_numeric($je) || $je % 1 != 0 || $je < 1 || $je == '') {
            return Json::error('请输入正确的金额',[],false);
        }
        if ($types != 0)$je = 0 - $je;
        $db = Db::connection();
        //开启事务
        try {
            $db->beginTransaction();
            $user = User::where(['ruid'=>$ruid,'userid'=>$userid])->lockForUpdate()->first();
            //$uid = $user['userid'];
            if ($je < 0) {
                $update = [];
                if ($user['bsb_coin'] < abs($je)) {
                    throw new \Exception('可提取余额不足');
                }
                if ($user['bsb_coin'] >= 0) {
                    $update['bsb_coin'] = $user['bsb_coin'] + $je;
                }
                User::where(['ruid'=>$ruid,'userid'=>$userid])->update($update);
                //ComFunc::adduseredit(['userid'=>$uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'百胜币余额','old'=>ComFunc::pr2($oldbsb_coin),'new'=>ComFunc::pr2($bsb_coin),'moduleKey'=>'user','functionKey'=>'creditaccount','actionKey'=>'update']);
            } else {
                $update = [];
                $update['bsb_coin'] = $user['bsb_coin']+$je;
                User::where(['ruid'=>$ruid,'userid'=>$userid])->update($update);
                //ComFunc::adduseredit(['userid'=>$uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'百胜币余额','old'=>ComFunc::pr2($oldbsb_coin),'new'=>ComFunc::pr2($bsb_coin),'moduleKey'=>'user','functionKey'=>'creditaccount','actionKey'=>'update']);
            }
            // 写入日志（如果需要）
            $savemoneylog = [];
            $savemoneylog['ruid'] = $ruid;
            $savemoneylog['userid'] = $userid;
            $savemoneylog['mtype'] = 2;
            $savemoneylog['beforeMoney'] = $user['bsb_coin'];
            $savemoneylog['money'] = abs($je);
            $savemoneylog['operateType'] = $types == 0 ? 1 : 2;
            $savemoneylog['moneyType'] = $types == 0 ? 3 : 4;
            $savemoneylog['bz'] = '百胜币';
            $savemoneylog['gid'] = 0;
            $savemoneylog['qishu'] = 0;
            $savemoneylog['operUserid'] = $this->uid;
            $savemoneylog['modisonuser'] = $this->adminid;
            $savemoneylog['time'] = time();
            $savemoneylog['dates'] = strtotime(ComFunc::getthisdateend());
            MoneyLog::create($savemoneylog);
            $db->commit();//提交事务
            return Json::success('操作成功',[],false);
        }catch (\Exception $e) {
            $db->rollBack();//回滚事务
            return Json::error($e->getMessage(),[],false);
        }
    }

    public function extractAccount(Request $request){
        $username = $request->input('username','');
        $type = $request->input('type',0);
        $db = Db::connection();
        $user = User::where('username',$username)->first();
        $ifagent = $user['ifagent'];$fid = $user['fid'];$uid = $user['userid'];
        $puser = User::where('userid',$fid)->first();
        $layer = $user['layer'];
        $libmodel = SGUtils::getcuremodel();
        if ($ifagent == 1) {
            $libcount = $libmodel->where('uid'.$layer,$uid)->count('id');
            if($libcount > 0){
                return Json::error('今日已下注用户无法提取，请明天再试。',[],false);
            }
            if($user['fudong'] == 1){
                $totalmoney = User::where('fid'.$layer,$uid)->sum('kmoney');
                $totalmoney = $totalmoney + $user['kmoney'];
                $db->update("update x_user set kmaxmoney=kmaxmoney+$totalmoney,kmoney=kmoney+$totalmoney where userid='$fid'");
                ComFunc::adduseredit(['userid'=>$fid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>"提取({$user['username']})全部快开彩额度",'old'=>ComFunc::pr2($puser['kmoney']),'new'=>ComFunc::pr2($puser['kmoney'] + $totalmoney),'moduleKey'=>'user','functionKey'=>'extractcreditaccount','actionKey'=>'add']);
            }
            $db->update("update x_user set kmaxmoney=0,kmoney=0 where  fid" . $layer . "='$uid' and kmaxmoney=kmoney");
            $db->update("update x_user set kmaxmoney=0,kmoney=0 where userid='$uid'  and kmaxmoney=kmoney");
            ComFunc::adduseredit(['userid'=>$uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'提取全部快开彩额度','old'=>ComFunc::pr2($user['kmoney']),'new'=>0,'moduleKey'=>'user','functionKey'=>'extractcreditaccount','actionKey'=>'add']);
        }else{
            $libcount = $libmodel->where('userid',$uid)->count('id');
            if($libcount > 0){
                return Json::error('今日已下注用户无法提取，请明天再试。',[],false);
            }
            if($user['fudong'] == 1){
                $totalmoney = $user['kmoney'];
                $db->update("update x_user set kmaxmoney=kmaxmoney+$totalmoney,kmoney=kmoney+$totalmoney where userid='$fid'");
                ComFunc::adduseredit(['userid'=>$fid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>"提取({$user['username']})全部快开彩额度",'old'=>ComFunc::pr2($puser['kmoney']),'new'=>ComFunc::pr2($puser['kmoney'] + $totalmoney),'moduleKey'=>'user','functionKey'=>'extractcreditaccount','actionKey'=>'add']);
            }
            $db->update("update x_user set kmaxmoney=0,kmoney=0 where userid='$uid'");
            ComFunc::adduseredit(['userid'=>$uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'提取全部快开彩额度','old'=>ComFunc::pr2($user['kmoney']),'new'=>0,'moduleKey'=>'user','functionKey'=>'extractcreditaccount','actionKey'=>'add']);
        }
        return Json::success('操作成功',$username,false);
    }

    public function shares(Request $request){
        $username = $request->input('userid','');
        $user = User::where('username',$username)->select(['layer','userid','zcobj','fid1'])->first();
        if (empty($user))
            return Json::error('用户不存在',[],false);
        $uid = $user['userid'];
        //$u = ComFunc::getfid($uid);
        //$zc = ComFunc::getzcnewall($uid, $u, $user['layer'], x_config('zcmode'));
        //$layers = json_decode(x_config('layer'), true);
        $zcobj = $user['zcobj'];
        if($user['layer'] > 1){
            $zcobj = User::where('userid',$user['fid1'])->value('zcobj');
        }
        $u = ComFunc::getfid($uid);
        $u[0] = 99999999;
        $u = array_reverse($u,true);
        //$zc = ComFunc::getzcnewall($uid, $u, $user['layer'], x_config('zcmode'));
        $zzc = ComFunc::getzcnew_sgall($uid, $u, $user['layer'],$zcobj);
        $zc = $zzc[0];
        $layers = json_decode(x_config('layer'), true);
        $n=[];
        foreach ($u as $k => $v) {
            $tuser = User::where('userid',$v)->select(['username','layer'])->first();
            if($tuser['layer'] == 0){
                $n[$k]['username'] = $tuser['username'];
                $n[$k]['layername'] = '公司';
            }else{
                $n[$k]['username'] = $tuser['username'];
                $n[$k]['layername'] = $layers[$tuser['layer']-1];
            }
        }
        view()->share('zc', $zc);
        view()->share('u', $u);
        view()->share('n', $n);
        view()->share('glist', $zzc[1]);
        return view('managev1.user.shares');
    }

    public function agentloginLogs(Request $request){
        $username = $request->input('id','');
        $type = $request->input('type','user');
        $where = [];
        if($type == 'user'){
            if(empty($username)){
                $username = Admin::where('adminid',$this->adminid)->value('adminname');
                $where[] = ['xtype','=',0];
            }else{
                //$username  = User::where('userid',$username)->value('username');
                $where[] = ['xtype','<>',0];
            }
            $where[] = ['username',$username];
        }else{
            $admin = Admin::where('adminid',$username)->select(['adminid','adminname'])->first();
            $where[] = ['xtype','=',0];
            $where[] = ['username',$admin['adminname']];
        }
        $model = new UserLogin();
        $pagesize = 20;
        $list = $model->where($where)->select(['ip','addr','time','ifok'])->orderByRaw('time desc')->limit($pagesize)->get();
        foreach ($list as $k=>$v){
            $list[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        view()->share('list', $list);
        return view('managev1.user.agentloginLogs');
    }

    public function logs(Request $request){
        $username = $request->input('id','');
        $begin = $request->input('begin','');
        $end = $request->input('end','');
        $page = $request->input('page',1);
        $moduleKey = $request->input('moduleKey','');
        $user = User::where('username',$username)->select(['userid'])->first();
        $uid = $user['userid'];
        $notadminids = Admin::where('adminid','ifhide', 1)->pluck('adminid')->toArray();
        $model = UserEdit::where('userid',$uid);
        if(empty($moduleKey)){
            $model = $model->where('moduleKey','user');
        }else{
            $model = $model->where('moduleKey',$moduleKey);
        }
        if($this->adminInfo['ifhide'] != 1){
            $model = $model->whereNotIn('modisonuser',$notadminids);
        }
        $sdate = AdminFunc::weekbyreport();
        if($begin != '' && $end != '') {
            $startt = $begin . ' 00:00:00';
            $endt = $end . ' 23:59:59';
        }else{
            $startt = $sdate[5].' 00:00:00';
            $endt = $sdate[6].' 23:59:59';
            $begin = $sdate[5];
            $end = $sdate[6];
        }
        //只查询15天内数据
        //$model->where('moditime','>',time()-15*24*3600);
        $model = $model->where('moditime','>=',strtotime($startt));
        $model = $model->where('moditime','<=',strtotime($endt));
        $pagesize = 20;
        $list = $model->orderByRaw('id desc')->paginate($pagesize);
        //计算总页数
        $total = $list->total();
        $totalPage = ceil($total/$pagesize);
        $list->totalPage = $totalPage;
        foreach ($list as $i=>$item) {
            $list[$i]['moditime'] = date('Y-m-d H:i:s', $item['moditime']);;
            if (!ComFunc::checkfid($item['modiuser'],Constants::$SUID) && $item['modiuser'] != Constants::$SUID) {
                $list[$i]['modiuser'] = '公司';
                $list[$i]['modisonuser'] = Admin::where('adminid',$item['modisonuser'])->value('adminname');
                $list[$i]['modiuser'] = $list[$i]['modiuser'].'('.$list[$i]['modisonuser'].')';
            } else {
                if($item['modiuser'] == Constants::$SUID){
                    $list[$i]['modisonuser'] = Admin::where('adminid',$item['modisonuser'])->value('adminname');
                    $list[$i]['modiuser'] = $list[$i]['modisonuser'].'(公司)';
                }else{
                    if(!empty($item['modisonuser'])){
                        $mainuser = User::where('userid',$item['modiuser'])->value('username');
                        $list[$i]['modiuser'] = User::where('userid',$item['modisonuser'])->value('username')."(代理 {$mainuser} 子账号)";
                    }else{
                        $list[$i]['modiuser'] = ComFunc::transu($item['modiuser']);
                    }
                }
            }
            $arr = explode(' 【',$item['action']);
            if(count($arr) > 1) {
                $list[$i]['action'] = [$arr[0],' 【'.$arr[1]];
            }else{
                $list[$i]['action'] = [$item['action']];
            }
        }
        view()->share('begin', $begin);
        view()->share('end', $end);
        view()->share('sdate', $sdate);
        view()->share('list',$list);
        view()->share('username',$username);
        view()->share('moduleKey',$moduleKey);
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
        return view('common.user.logs');
    }

    public function resetLoginRetryCount(Request $request){
        $username = $request->input('username','');
        $userreg = Userreg::where('username',$username)->select(['userid','errortimes'])->first();
        if (empty($userreg))
            return Json::error('用户不存在');
        //更新字段errortimes
        Userreg::where('userid',$userreg['userid'])->update(['errortimes'=>0]);
        //ComFunc::adduseredit(['userid'=>$userreg['userid'],'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'重置错误登录次数','old'=>$userreg['errortimes'],'new'=>'0','moduleKey'=>'user','functionKey'=>'accinfo','actionKey'=>'reset']);
        return Json::success('操作成功');
    }

    public function followCountReset(Request $request){
        $username = $request->input('username','');
        $user = User::where('username',$username)->select(['userid'])->first();
        if (empty($user))
            return Json::error('用户不存在');
        //更新
        $oldcount = Cache::get('followplan_error_' . $user['userid'],0);
        Cache::delete('followplan_error_' . $user['userid']);
        ComFunc::adduseredit(['userid'=>$user['userid'],'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'重置跟投禁用次数','old'=>$oldcount,'new'=>'0','moduleKey'=>'user','functionKey'=>'accinfo','actionKey'=>'reset']);
        return Json::success('操作成功');
    }

    public function relation(Request $request){
        $userid = $request->input('id','');
        $user = User::where('userid',$userid)->first();
        $list = [];
        $layers = json_decode(x_config('layer'), true);
        //循环8次，初始是8
        for ($i = $user['layer']; $i > 0; $i--) {
            if($i == $user['layer']){
                $list[$i]['username'] = $user['username'];
                $list[$i]['layername'] = $user['ifagent'] == 1 ? $layers[$i-1] : '会员';
                $list[$i]['online'] = UserOnline::isonlie($user['userid']);
            }else{
                $fid = $user['fid'.$i];
                $fuser = User::where('userid',$fid)->select(['userid','username','layer','fid','ifagent','online'])->first();
                $list[$i]['username'] = $fuser['username'];
                $list[$i]['layername'] = $fuser['ifagent'] == 1 ? $layers[$i-1] : '会员';
                $list[$i]['online'] = UserOnline::isonlie($fuser['userid']);
            }
        }
        $list = array_reverse($list);
        view()->share('list',$list);
        return view('managev1.user.relation');
    }

    public function userloginLogs(Request $request){
        $username = $request->input('userid','');
        $page = $request->input('page',1);
        $begin = $request->input('begin','');
        $end = $request->input('end','');
        $logout_type = $request->input('logoutType','');
        $logoutBegin = $request->input('logoutBegin','');
        $logoutEnd = $request->input('logoutEnd','');
        $addr = $request->input('ipAddr','');
        $muser = User::where('userid',$this->uid)->first();
        $model = UserLogin::where('xtype','<>',0)->where(['ifok'=>1]);
        if(!empty($username)){
            $model = $model->where(['username'=>$username]);
        }
        if(!empty($begin) && !empty($end)){
            $model = $model->whereBetween('time',[strtotime($begin),strtotime($end)]);
        }
        if(!empty($logoutBegin) && !empty($logoutEnd)){
            $model = $model->whereBetween('logout_time',[strtotime($logoutBegin),strtotime($logoutEnd)]);
        }
        if($logout_type != ''){
            $model = $model->where(['logout_type'=>$logout_type]);
        }
        if(!empty($addr)){
            //使用like查询
            $model = $model->where('addr','like','%'.$addr.'%');
        }
        $pagesize = 20;
        $list = $model->orderByRaw('time desc')->paginate($pagesize);
        //计算总页数
        $total = $list->total();
        $totalPage = ceil($total/$pagesize);
        $list->totalPage = $totalPage;
        $tmp = [];
        foreach ($list as $k=>$v){
            $list[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
            if(!empty($v['logout_time'])){
                $list[$k]['logout_time'] = date('Y-m-d H:i:s',$v['logout_time']);
                if($v['logout_type'] == 0){
                    $list[$k]['logout_type'] = '用户登出';
                }elseif($v['logout_type'] == 1){
                    $list[$k]['logout_type'] = '系统踢出';
                }elseif($v['logout_type'] == 2){
                    $list[$k]['logout_type'] = '超时注销';
                }
            }else{
                $list[$k]['logout_time'] = '';
                $list[$k]['logout_type'] = '';
            }
            if(!isset($tmp[$v['userid']])){
                $tmp[$v['userid']] = User::where('username',$v['username'])->select(['username','ifson'])->first();
            }
            $user = $tmp[$v['userid']];
            if(!empty($user) && $user['ifson'] == 1){
                $list[$k]['username'] = $user['username'];
            }else{
                $list[$k]['username'] = $v['username'];
            }
        }
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
        view()->share('list',$list);
        view()->share('username',$muser['username']);
        return view('managev1.user.userloginLogs');
    }

    public function reset(Request $request){
        $username = $request->input('username','');
        $type = $request->input('type','');
        if(empty($username)){
            return Json::error('用户名不能为空',[],false);
        }
        $user = User::where('username',$username)->first();
        if(empty($user)){
            return Json::error('用户不存在',[],false);
        }
        if($type == 5){
            $user->google_open = 0;
            $user->save();
        }
        ComFunc::adduseredit(['userid'=>$user['userid'],'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'重置二次验证','old'=>'-','new'=>'-','moduleKey'=>'user','functionKey'=>'2fa','actionKey'=>'reset']);
        return Json::success('操作成功',[],false);
    }

    public function resetsub(Request $request){
        $username = $request->input('username','');
        $type = $request->input('type','');
        if(empty($username)){
            return Json::error('用户名不能为空',[],false);
        }
        if($type == 0){
            $res = Admin::where('adminid',$this->adminid)->update(['google_open'=>0]);
            if($res){
                ComFunc::adduseredit(['userid'=>$this->uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'资料更改【解绑谷歌口令】','old'=>'','new'=>'','moduleKey'=>'user','functionKey'=>'accinfo','actionKey'=>'update']);
                return Json::success('解绑成功',[],false);
            }else{
                return Json::error('解绑失败',[],false);
            }
        }else{
            $user = User::where('username',$username)->first();
            if(empty($user)){
                return Json::error('用户不存在',[],false);
            }
            if($type == 5){
                $user->google_open = 0;
                $user->save();
            }
            ComFunc::adduseredit(['userid'=>$user['userid'],'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'重置二次验证','old'=>'-','new'=>'-','moduleKey'=>'user','functionKey'=>'2fa','actionKey'=>'reset']);
            return Json::success('操作成功',[],false);
        }
    }

    public function resetTransferPassword(Request $request){
        $username = $request->input('username','');
        $isMain = $request->input('isMain','');
        if(empty($username)){
            return Json::error('用户名不能为空',[]);
        }
        $user = User::where('username',$username)->first();
        if(empty($user)){
            return Json::error('用户不存在',[]);
        }
        $user->moneypass = '';
        $user->save();
        ComFunc::adduseredit(['userid'=>$user['userid'],'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'重置转账密码','old'=>'-','new'=>'-','moduleKey'=>'user','functionKey'=>'2fa','actionKey'=>'reset']);
        return Json::success('操作成功',[]);
    }

    public function subAccounts(Request $request){
        $mainAccount = $request->input('mainAccount','');
        $username = $request->input('username','');
        $model = User::where(['ifson'=>1]);
        if(!empty($mainAccount)){
            $mainuserid = User::where('username',$mainAccount)->value('userid');
            if(!empty($mainuserid)){
                $model = $model->where(['fid'=>$mainuserid]);
            }
        }
        if(!empty($username)){
            $model = $model->where(['username'=>$username]);
        }
        $pagesize = 20;
        $list = $model->with(['puser'])->select(['username','name','regtime','userid','status','fid'])->orderByRaw('id desc')->paginate($pagesize);
        //计算总页数
        $total = $list->total();
        $totalPage = ceil($total/$pagesize);
        $list->totalPage = $totalPage;
        foreach ($list as &$item){
            $item['regtime'] = date('Y-m-d',$item['regtime']);
            $item['statusstr'] = ComFunc::transstatus($item['status']);
            $item['pusername'] = isset($item['puser']) ? $item['puser']['username'] : '';
            $item['online'] = UserOnline::isonlie($item['userid']);
        }
        view()->share('list',$list);
        return view('managev1.user.subAccounts');
    }

    public function delSubAccount(Request $request){
        $passname = $request->input('passname','');
        if(empty($passname)){
            return Json::error('用户名不能为空',[],false);
        }
        $unamearr = explode('-',$passname);
        if(count($unamearr) != 2){
            return Json::error('用户名格式错误',[],false);
        }
        $username = $unamearr[1];
        $user = User::where('username',$username)->first();
        if(empty($user)){
            return Json::error('用户不存在',[],false);
        }
        if($user['ifson'] != 1){
            return Json::error('用户不是子账号',[],false);
        }
        //删除用户
        $uid = $user['userid'];
        $db = Db::connection();
        $db->delete("delete from x_user where userid='$uid'");
        $db->delete("delete from x_user_page where userid='$uid'");
        $db->delete("delete from x_user_login where username='$username'");
        $db->delete("delete from x_user_edit where userid='$uid'");
        UserOnline::deleteUserOnlineInfo($uid);
        return Json::success('操作成功',[],false);
    }

    public function subAccountStatus(Request $request){
        $username = $request->input('passname','');
        $unamearr = explode('-',$username);
        if(count($unamearr) != 2){
            return Json::error('用户名格式错误',[],false);
        }
        $username = $unamearr[1];
        $status = $request->input('status','');
        $user = User::where('username',$username)->first();
        if(empty($user)){
            return Json::error('账号不存在',[],false);
        }
        $update['status'] = $status;
        User::where('username',$username)->update($update);
        return Json::success('修改成功',[],false);
    }

    public function subAccount(Request $request){
        $username = $request->input('passname','');
        $unamearr = explode('-',$username);
        if(count($unamearr) != 2){
            return Json::error('用户名格式错误',[],false);
        }
        $pusername = $unamearr[0];
        $username = $unamearr[1];
        $isupdate = 1;
        $puser = User::where('username',$pusername)->select(['layer'])->first();
        $sub = User::where(['username'=>$username,'ifson'=>1])->first();
        view()->share('sub',$sub);
        $xpages = UserPage::where(['userid'=>$sub['userid'],'ifok'=>1])->pluck('xpage')->toArray();
        view()->share('xpages',$xpages);
        view()->share('isupdate',$isupdate);
        view()->share('layer',$puser['layer']);
        view()->share('alertmsg',Cache::get('alertmsg_'.$sub['userid'],''));
        return view('managev1.user.subAccount');
    }

    public function saveSub(Request $request){
        $passname = $request->input('passname','');
        $ipLimit = $request->input('ipLimit','');
        $name = $request->input('name','');
        $password = $request->input('password','');
        $popedoms = $request->input('popedoms','');
        $alertmsg = $request->input('alertmsg','');
        $ifuser = User::where('username',$passname)->first();
        if(!empty($ipLimit) && !preg_match("/^((25[0-5]|2[0-4]\d|[01]?\d\d?)($|(?!\.$)\.)){4}$/",$ipLimit)){
            return Json::error('绑定登录IP格式错误',[],false);
        }
        if(!empty($ifuser)){
            $update['name'] = $name;
            $update['ipfilter'] = $ipLimit;
            if(!empty($password)){
                $upass = x_config('upass');
                $update['userpass'] = md5($password . $upass);
            }
            if($this->adminInfo['ifhide'] == 1){
                Cache::put('alertmsg_'.$ifuser['userid'],$alertmsg,60*24*30);
            }
            User::where('userid',$ifuser['userid'])->update($update);
            $oldpopedom = UserPage::where('userid',$ifuser['userid'])->get();
            foreach ($oldpopedom as $v) {
                if(in_array($v['xpage'],$popedoms)){
                    UserPage::where('id',$v['id'])->update(['ifok'=>1]);
                }else{
                    UserPage::where('id',$v['id'])->update(['ifok'=>0]);
                }
            }
            return Json::success('修改成功',[],false);
        }
        return Json::error('非法操作',[],false);
    }

    public function oncealertmsg(Request $request){
        $username = $request->input('username','');
        $userid = User::where('username',$username)->value('userid');
        $alert_msg = Cache::get('alertmsg_'.$userid,'');
        if(!empty($alert_msg)){
            Cache::put('once_msg_'.$userid,$alert_msg,60*24*30);
        }
        return Json::success('操作成功',[],true);
    }
}
