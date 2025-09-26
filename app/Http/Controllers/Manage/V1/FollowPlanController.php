<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Followplan;
use App\Models\Game\FollowplanFrommember;
use App\Models\Game\FollowplanTomember;
use App\Models\Game\Game;
use App\Models\Game\User;
use App\Models\Game\UserEdit;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\services\FollowPlanService;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FollowPlanController extends ManageAuthController
{
    public function query(Request $request)
    {
        $userid = $this->uid;
        $cuser = User::where('userid', $userid)->select(['username','layer'])->first();
        view()->share('username', $cuser['username']);
        view()->share('layer', $cuser['layer']);
        $layers = json_decode(x_config('layer'), true);
        $list = Followplan::orderByDesc('id')->get();
        $db = Db::connection();
        foreach ($list as &$item) {
            //跟投对象额度
            $frommember = FollowplanFrommember::where('followplan_id', $item->id)->get();
            $item['sourceMax'] = 0;
            $item['sourceBalance'] = 0;
            foreach ($frommember as $fm) {
                /*if ($fm['ifagent'] == 1) {
                    $m = User::where('fid' . $fm['layer'], $fm['userid'])->select(['kmaxmoney', 'kmoney'])->first();
                } else {
                }*/
                $m = User::where('userid', $fm['userid'])->select(['kmaxmoney', 'kmoney'])->first();
                if(empty($m)){
                    $db->delete('delete x_followplan,x_followplan_frommember,x_followplan_tomember from x_followplan left join x_followplan_frommember on x_followplan.id=x_followplan_frommember.followplan_id left join x_followplan_tomember on x_followplan.id=x_followplan_tomember.followplan_id where x_followplan.id='.$item->id);
                }
                $item['sourceMax'] = ComFunc::pr3($item['sourceMax'] + $m['kmaxmoney']);
                $item['sourceBalance'] = ComFunc::pr3($item['sourceBalance'] + $m['kmoney']);
            }
            //投注会员额度
            $item['targetMax'] = 0;
            $item['targetBalance'] = 0;
            $item['targetWinLoss'] = 0;
            $tomember = FollowplanTomember::where('followplan_id', $item->id)->get();
            foreach ($tomember as $tm) {
                if($tm['type'] == 1) {
                    $m = User::where('userid', $tm['userid'])->select(['kmaxmoney', 'kmoney', 'sy'])->first();
                    if(!empty($m)){
                        $item['targetMax'] = ComFunc::pr3($item['targetMax'] + $m['kmaxmoney']);
                        $item['targetBalance'] = ComFunc::pr3($item['targetBalance'] + $m['kmoney']);
                        $item['targetWinLoss'] = ComFunc::pr3($item['targetWinLoss'] + $m['sy']);
                    }
                }else{
                    if(!empty($tm['bz'])){
                        $arr = explode('|',$tm['bz']);
                        $item['targetMax'] = ComFunc::pr3($item['targetMax'] + $arr[1]);
                        $item['targetBalance'] = ComFunc::pr3($item['targetBalance'] + $arr[0]);
                        $item['targetWinLoss'] = ComFunc::pr3($item['targetWinLoss'] + $arr[2]);
                    }
                }
            }
            //所属用户
            if($item['userid'] == Constants::$SUID) {
                $item['username'] = '公司';
                $item['me'] = 1;
            }else{
                $user = User::where('userid', $item['userid'])->select(['username', 'layer'])->first();
                $item['username'] = $layers[$user['layer']-1].'-'.$user['username'];
                $item['me'] = 0;
            }
        }
        view()->share('layername', '公司');
        view()->share('list', $list);
        return view('managev1.agentfollowplan.query');
    }

    public function setting(Request $request){
        $action = $request->input('action', '');
        $username = $request->input('username', '');
        $planId = $request->input('planId', '');
        $userid = $this->uid;
        //查询平台有几级代理和会员
        $layerlist = [];
        $layers = json_decode(x_config('layer'), true);
        for ($i = 1; $i <= 10; $i++) {
            $count = User::where(['ifagent' => 1, 'ifson' => 0])->where('layer', $i)->count();
            if ($count > 0) {
                $layerlist[$i] = $layers[$i - 1];
            }
        }
        view()->share('layerlist', $layerlist);
        view()->share('action', $action);
        view()->share('username', $username);
        view()->share('planId', $planId);
        if (!empty($planId)) {
            $plan = Followplan::where('id', $planId)->first();
            //查询彩种
            $lotterys = Game::whereIn('gid', function ($query) use($plan) {
                $query->select('gid')->from('gamecs')->where(['userid' => $plan['userid'], 'ifok' => 1]);
            })->where('ifopen', 1)->select(['gname', 'lottery', 'template'])->orderBy('xsort')->get();
            view()->share('lotterys', $lotterys);
            $fromlist = FollowplanFrommember::where('followplan_id', $planId)->get();
            $sourceuids = [];
            $layers = [];$webname = x_config('webname');
            foreach ($fromlist as $item) {
                $sourceuids[] = $item['userid'];
                if ($item['ifagent'] == 1) {
                    $layers[] = $item['layer'];
                } else {
                    $layers[] = 0;
                }
            }
            $usernames = User::whereIn('userid', $sourceuids)->pluck('username')->toArray();
            $plan['source'] = implode(',', $usernames);
            $targets = FollowplanTomember::where('followplan_id', $planId)->orderByRaw('sequence asc')->get();
            foreach ($targets as &$target) {
                if($target['type'] == 1) {
                    $uu = User::where('userid', $target['userid'])->select(['username', 'name'])->first();
                    $target['username'] = $uu['username'];
                    $target['name'] = $webname;
                }else{
                    $target['name'] = $target['webname'];
                }
            }
            $plan['layers'] = implode(',', $layers);
            $plan['target'] = $targets;
            $plan['lotteryList'] = json_decode($plan['lotteryList'], true);
            $plan['lotterystr'] = implode(',', $plan['lotteryList']);
            view()->share('plan', $plan);
        }else{
            //查询彩种
            $lotterys = Game::whereIn('gid', function ($query) use($userid) {
                $query->select('gid')->from('gamecs')->where(['userid' => $userid, 'ifok' => 1]);
            })->where('ifopen', 1)->select(['gname', 'lottery', 'template'])->orderBy('xsort')->get();
            view()->share('lotterys', $lotterys);
        }
        view()->share('layername', '公司');
        view()->share('open_follow_outbet', x_config('open_follow_outbet'));
        view()->share('dh_138_url', x_config('dh_138_url'));
        return view('managev1.agentfollowplan.setting');
    }

    //根据条件查询下线会员账号
    public function downlines(Request $request)
    {
        $type = $request->input('type', '');
        $agentLv = $request->input('agentLv', 0);
        $username = $request->input('username', '');
        $sourceUsername = $request->input('sourceUsername', '');
        $userid = $this->uid;
        $model = new User();
        $model = $model->where(['status' => 0]);
        if ($agentLv == 0) {
            $model = $model->where(['ifagent' => 0]);
        } else {
            $model = $model->where(['ifagent' => 1, 'ifson' => 0, 'layer' => $agentLv]);
        }
        if (!empty($sourceUsername)) {
            $model = $model->where('username', $sourceUsername);
        }
        $usernames = $model->pluck('username')->toArray();
        return response()->json($usernames)->content();
    }

    public function save(Request $request)
    {
        $username = $request->input('username', '');
        $planId = $request->input('planId', '');
        $planName = $request->input('planName', '');
        $sourceLv = $request->input('sourceLv', 0);
        $sourceLvs = $request->input('sourceLvs', []);
        $indicator = $request->input('indicator', 1);
        $sourceList = $request->input('sourceList', []);
        $sourceList = json_decode($sourceList, true);
        $lotteryList = $request->input('lotteryList', []);
        $percentage = $request->input('percentage', 0);
        $detailList = $request->input('detailList', []);
        $dh_138_url = $request->input('dh_138_url', '');
        $detailList = json_decode($detailList, true);
        $userid = $this->uid;$open_follow_outbet = x_config('open_follow_outbet');
        //检测跟投功能是否开启
        if (x_config('planenable') !=1) {
            return Json::error('跟投功能未开放', [], false);
        }
        if (empty($planName)){
            return Json::error('组名不能为空', [], false);
        }
        if (empty($lotteryList)) {
            return Json::error('请选择至少一个彩种', [], false);
        }
        if (empty($sourceList)) {
            return Json::error('请最少选择一个账号', [], false);
        }
        if (empty($detailList)) {
            return Json::error('请至少选择一个投注会员', [], false);
        }
        //$percentage不能小于1不能大于100
        if (!is_numeric($percentage) || $percentage < 1 || $percentage > 100) {
            return Json::error('请输入正确跟投比例', [], false);
        }
        if($open_follow_outbet == 1){
            if(empty($dh_138_url)){
                return Json::error('请填写导航', [], false);
            }
        }
        $usernames = array_column($detailList, 'username');
        if(count($usernames) != count(array_unique($usernames))){
            return Json::error('投注会员账号存在重复', [], false);
        }
        //校验跟投对象列表
        $savefrommemeberlist = [];
        foreach ($sourceList as $source) {
            $fromuser = User::where('username', $source)->select(['userid', 'layer', 'ifagent'])->first();
            if (!empty($fromuser)) {
                $savefrommemeberlist[] = [
                    'followplan_id' => $planId ? $planId : 0,
                    'userid' => $fromuser['userid'],
                    'ifagent' => $fromuser['ifagent'],
                    'layer' => $fromuser['layer'],
                ];
            }
        }
        //校验投注会员列表
        $savetomemeberlist = [];
        $anquanma = x_config('anquanma');
        $totalratio = 0;
        $error = 0;
        $errorsavetime = 86400 * 10;
        $time = time();
        $passtime = x_config('passtime');
        $errors = Cache::get('followplan_error_' . $userid);
        if ($errors >= 10) {
            return Json::error("错误次数过多，封停中", [], false);
        }
        foreach ($detailList as $detail) {
            $type = 1;
            if (!empty($planId)) {
                $oldtouser = FollowplanTomember::where(['followplan_id'=>$planId,'sequence'=>$detail['sequence']])->first()->toArray();
            }else{
                $oldtouser = [];
            }
            if($detail['safeCode'] == $anquanma){//本服跟投
                $touser = User::where(['username'=>$detail['username'],'userpass'=>md5($detail['password'].x_config('upass')),'ifagent'=>0])->select(['userid', 'userpass','passtime'])->first();
                $oldtouser['userid'] = $touser['userid'];
                if (empty($touser)) {
                    if ($error == 0) {
                        if (Cache::has('followplan_error_' . $userid)) {
                            Cache::increment('followplan_error_' . $userid);
                        } else {
                            Cache::set('followplan_error_' . $userid, 1, $errorsavetime);
                        }
                        $error = 1;
                    }
                    return Json::error("投注会员{$detail['username']}账号密码错误", [], false);
                }
                if (($time - $touser['passtime']) / (60 * 60 * 24) >= $passtime && $passtime != 0) {
                    return Json::error("投注会员{$detail['username']}的账号需先登录修改密码", [], false);
                }
                if ($planId && $touser['userpass'] != md5($oldtouser['password'].x_config('upass'))) {
                    if ($error == 0) {
                        if (Cache::has('followplan_error_' . $userid)) {
                            Cache::increment('followplan_error_' . $userid);
                        } else {
                            Cache::set('followplan_error_' . $userid, 1, $errorsavetime);
                        }
                        $error = 1;
                    }
                    return Json::error("投注会员{$detail['username']}密码已变更，请重新修改", [], false);
                }
            }else{//外网检测
                if($open_follow_outbet == 0){
                    if($detail['safeCode'] != $anquanma){
                        return Json::error("投注会员{$detail['username']}安全码错误", [], false);
                    }
                }
                $type = 2;$oldtouser['userid'] = 0;
                //解析导航获取url
                $res = (new FollowPlanService())->searchurlandname($dh_138_url,$detail['username'],$detail['safeCode']);
                $curl = $res['curl'];
                $oldtouser['webname'] = $res['webname'];
                if (empty($curl)) {
                    if ($error == 0) {
                        if (Cache::has('followplan_error_' . $userid)) {
                            Cache::increment('followplan_error_' . $userid);
                        } else {
                            Cache::set('followplan_error_' . $userid, 1, $errorsavetime);
                        }
                        $error = 1;
                    }
                    return Json::error("投注会员{$detail['username']}安全码错误", [], false);
                }
                $oldtouser['curl'] = $curl;
                //登陆网站验证账号密码是否错误
                $res = (new FollowPlanService())->sglogin($curl,$detail['username'],$detail['password']);
                if($res['code'] == 1){
                    $oldtouser['cookie'] = $res['cookie'];
                }else{
                    if ($error == 0) {
                        if (Cache::has('followplan_error_' . $userid)) {
                            Cache::increment('followplan_error_' . $userid);
                        } else {
                            Cache::set('followplan_error_' . $userid, 1, $errorsavetime);
                        }
                        $error = 1;
                    }
                    return Json::error("投注会员{$detail['username']}{$res['msg']}", [], false);
                }
            }
            //校验分配比例
            if (!is_numeric($detail['ratio']) || $detail['ratio'] < 1 || $detail['ratio'] > 100) {
                return Json::error("投注会员{$detail['username']}分配比例错误", [], false);
            }
            $oldtouser['ratio'] = $detail['ratio'];
            $oldtouser['password'] = $detail['password'];
            $oldtouser['sequence'] = $detail['sequence'];
            $oldtouser['username'] = $detail['username'];
            $oldtouser['safeCode'] = $detail['safeCode'];
            $oldtouser['type'] = $type;
            $savetomemeberlist[] = $oldtouser;
            $totalratio += $detail['ratio'];
        }
        if ($totalratio != 100) {
            return Json::error("投注会员分配比例总和不等于100", [], false);
        }
        if (empty($planId)) {//新增
            $save['userid'] = $this->uid;
            $save['planName'] = $planName;
            $save['percentage'] = $percentage;
            $save['indicator'] = $indicator;
            $save['lotteryList'] = $lotteryList;
            $save['add_time'] = time();
            $save['dh_138_url'] = $dh_138_url;
            $res = FollowPlan::insertGetId($save);
            if ($res) {
                foreach ($savetomemeberlist as $k => $v) {
                    $savetomemeberlist[$k]['followplan_id'] = $res;
                }
                foreach ($savefrommemeberlist as $k => $v) {
                    $savefrommemeberlist[$k]['followplan_id'] = $res;
                }
                FollowplanFrommember::insert($savefrommemeberlist);
                FollowplanTomember::insert($savetomemeberlist);
                Cache::delete('followplan_error_' . $userid);
                $sourcestr = implode(',', $sourceList);
                $lotterys = Game::whereIn('lottery', json_decode($lotteryList, true))->pluck('gname')->toArray();
                $lotterys = implode(',', $lotterys);
                $indicatorstr = $indicator == 1 ? '正跟' : '反跟';
                $info = "新增跟投。组名：{$save['planName']}, 选择账号：{$sourcestr}, 跟投比例：{$save['percentage']}, 游戏选择：[{$lotterys}], 正跟反跟：{$indicatorstr}";
                $oldenabledstr = '未跟投';
                $newenabledstr = '未跟投';
                ComFunc::adduseredit(['other'=>$res,'title'=>'跟投','userid'=>$this->uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>$info,'old'=>$oldenabledstr,'new'=>$newenabledstr,'moduleKey'=>'agentfollowbet','functionKey'=>'agentfollowplan','actionKey'=>'update']);
                foreach ($savetomemeberlist as $i=>$v) {
                    $info = "新增跟投投注会员。安全码：{$v['safeCode']}, 账号：{$detailList[$i]['username']}, 分配比例：{$v['ratio']}";
                    $oldenabledstr = '未跟投';
                    $newenabledstr = '未跟投';
                    ComFunc::adduseredit(['other'=>$res,'title'=>'跟投','userid'=>$this->uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>$info,'old'=>$oldenabledstr,'new'=>$newenabledstr,'moduleKey'=>'agentfollowbet','functionKey'=>'agentfollowplan','actionKey'=>'add']);
                }
                return Json::success('', [], false);
            } else {
                return Json::error('保存失败', [], false);
            }
        } else {
            $update['planName'] = $planName;
            $update['percentage'] = $percentage;
            $update['indicator'] = $indicator;
            $update['lotteryList'] = $lotteryList;
            $update['dh_138_url'] = $dh_138_url;
            FollowPlan::where('id', $planId)->update($update);
            FollowplanFrommember::where('followplan_id', $planId)->delete();
            FollowplanFrommember::insert($savefrommemeberlist);
            FollowplanTomember::where('followplan_id', $planId)->delete();
            FollowplanTomember::insert($savetomemeberlist);
            Cache::delete('followplan_error_' . $userid);
            return Json::success('', [], false);
        }
    }

    public function enable(Request $request)
    {
        $planId = $request->input('planId');
        $enabled = $request->input('enabled');
        if (empty($planId)) {
            return Json::error('参数错误', [], false);
        }
        //检测跟投功能是否开启
        if (x_config('planenable') !=1) {
            return Json::error('跟投功能未开放', [], false);
        }
        $oldplan = FollowPlan::where(['id' => $planId])->first();
        $anquanma = x_config('anquanma');
        if($enabled == 1){
            $tomember = FollowplanTomember::where(['followplan_id' => $planId])->get();
            foreach ($tomember as $v) {
                if($v['type'] == 1){
                    $user = User::where('userid', $v['userid'])->select(['userpass','username'])->first();
                    $mpass = md5($v['password'] . x_config('upass'));
                    if($user['userpass'] != $mpass){
                        return Json::error('有投注会员密码已变更,请点击修改提交', [], false);
                    }
                    if ($v['safeCode'] != $anquanma) {
                        return Json::error("投注会员{$user['username']}的安全码有误", [], false);
                    }
                }
            }
        }
        $res = FollowPlan::where(['id' => $planId])->update(['enabled' => $enabled]);
        if ($res) {
            $oldenabledstr = $oldplan['enabled'] == 1 ? '跟投中' : '未跟投';
            $newenabledstr = $enabled == 1 ? '跟投中' : '未跟投';
            ComFunc::adduseredit(['other'=>$oldplan['id'],'title'=>'跟投','userid'=>$this->uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>"状态变化({$oldenabledstr}=>{$newenabledstr})",'old'=>$oldenabledstr,'new'=>$newenabledstr,'moduleKey'=>'agentfollowbet','functionKey'=>'agentfollowplan','actionKey'=>'update']);
            return Json::success('', [], false);
        } else {
            return Json::error('操作失败', [], false);
        }
    }

    public function delete(Request $request)
    {
        $planId = $request->input('planId');
        if (empty($planId)) {
            return Json::error('参数错误', [], false);
        }
        $userid = $this->uid;
        $db = Db::connection();
        //删除x_followplan同时删除关联的x_followplan_frommember和x_followplan_tomember
        $res = $db->delete('delete x_followplan,x_followplan_frommember,x_followplan_tomember from x_followplan left join x_followplan_frommember on x_followplan.id=x_followplan_frommember.followplan_id left join x_followplan_tomember on x_followplan.id=x_followplan_tomember.followplan_id where x_followplan.id=' . $planId);
        if ($res) {
            $db->delete("delete from x_user_edit where userid='$userid' and title='跟投' and other='$planId'");
            return Json::success('', [], false);
        } else {
            return Json::error('删除失败', [], false);
        }
    }

    public function logs(Request $request)
    {
        $planId = $request->input('planId', '');
        $username = $request->input('username', '');
        $date = $request->input('date', '');
        $module = $request->input('module', '');
        $userid = $this->uid;
        $user = User::where('userid', $userid)->select(['username','name','layer'])->first();
        //$layers = json_decode(x_config('layer'), true);
        $lotterys = Game::whereIn('gid', function ($query) {
            $query->select('gid')->from('gamecs')->where(['userid' => $this->uid, 'ifok' => 1]);
        })->where('ifopen', 1)->select(['gname', 'lottery'])->orderBy('xsort')->get();
        $model = UserEdit::with(['followplan'])->where('title', '跟投')->where('other', $planId);
        if (!empty($date)) {
            $model->where('moditime', '>=', strtotime($date . ' 00:00:00'))->where('moditime', '<=', strtotime($date . ' 23:59:59'));
        }
        if (!empty($module) && $module != 'CHANGE') {
            $model->where('action', $module);
        }
        $pagesize = 20;
        $list = $model->orderBy('moditime', 'desc')->paginate($pagesize);
        foreach ($list as $k => $v) {
            $list[$k]['moditime'] = date('Y-m-d H:i:s', $v['moditime']);
            $list[$k]['planName'] = $v['followplan']['planName'];
            if ($v['followplan']['userid'] == Constants::$SUID) {
                $list[$k]['modiuser'] = User::where('userid', $v['modiuser'])->value('username').'(公司)';
                $list[$k]['modisonuser'] = '';
            } else {
                $list[$k]['modiuser'] = User::where('userid', $v['modiuser'])->value('username').'(代理)';
                if(!empty($v['modisonuser'])){
                    $list[$k]['modisonuser'] = User::where('userid', $v['modisonuser'])->value('username').'(子账号)';
                }else{
                    $list[$k]['modisonuser'] = '';
                }
            }
        }
        //计算总页数
        $total = $list->total();
        $totalPage = ceil($total/$pagesize);
        $list->totalPage = $totalPage;
        view()->share('list', $list);
        view()->share('lotterys', $lotterys);
        view()->share('layername', '公司');
        view()->share('username', $user['username']);
        view()->share('date',empty($date)?date('Y-m-d'):$date);
        view()->share('planId', $planId);
        view()->share('module', $module);
        return view('managev1.agentfollowplan.logs');
    }
}
