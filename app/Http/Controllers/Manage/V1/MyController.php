<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Admin;
use App\Models\Game\Fly;
use App\Models\Game\Game;
use App\Models\Game\Gamezc;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use App\ort\sgwin\Json;
use Earnp\GoogleAuthenticator\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyController extends ManageAuthController
{
    public function info(Request $request){
        $lottery = $request->input('lottery','');
        $adminname = Admin::where('adminid',$this->adminid)->value('adminname');
        $userid = $this->uid;
        $db = Db::connection();
        $user = User::where('userid', $userid)->first();
        $pan = json_decode($user['pan'], true);
        $cps = count($pan);
        $str = '';
        for ($k = 0; $k < $cps; $k++) {
            if ($k > 0) {
                $str .= ',';
            }
            $str .= strtolower($pan[$k]);
        }
        view()->share('span', $pan);
        view()->share('panstr', implode(",", $pan));
        $lotterys = Game::whereIn('gid', function ($query){
            $query->select('gid')->from('gamecs')->where(['userid'=>$this->uid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','lottery', 'gid', 'xsort'])->orderBy('xsort')->get();
        view()->share('lotterys', $lotterys);
        $g_list = $db->select("select gid,gname,panstatus,fast,pan,dftype from x_game where lottery = '{$lottery}'");
        $i = 0;
        $game = array();
        foreach ($g_list as $item) {
            $game[$i]['gid'] = $item['gid'];
            $tgid = $item['gid'];
            $game[$i]['gname'] = $item['gname'];
            $game[$i]['panstatus'] = $item['panstatus'];
            $game[$i]['fast'] = $item['fast'];
            $game[$i]['pan'] = json_decode($item['pan'], true);
            $game[$i]['dftype'] = json_decode($item['dftype'], true);
            foreach($game[$i]['pan'] as $j=>$vo) {
                $tclass = $game[$i]['pan'][$j]['class'];
                $cs = ComFunc::getjes8($tclass, $userid, $tgid);
                $game[$i]['pan'][$j]['name'] = $game[$i]['dftype'][$tclass];
                $game[$i]['pan'][$j]['cmaxje'] = $cs['cmaxje'];
                $game[$i]['pan'][$j]['maxje'] = $cs['maxje'];
                $game[$i]['pan'][$j]['minje'] = $cs['minje'];
                if ($game[$i]['pan'][$j]['abcd'] == 1) {
                    if ($game[$i]['pan'][$j]['ab'] == 1) {
                        $rs = $db->select("select {$str} from x_points where userid='{$userid}' and gid='{$tgid}' and class='{$tclass}'  and  ab='A' ");
                        $point = $rs[0];
                        for ($k = 0; $k < $cps; $k++) {
                            $tmp = strtolower($pan[$k]);
                            $game[$i]['pan'][$j]['points' . $tmp . 'a'] = ComFunc::pr2($point[$tmp]);
                        }
                        $rs = $db->select("select {$str} from x_points where userid='{$userid}' and gid='{$tgid}' and class='{$tclass}'  and  ab='B' ");
                        if(!empty($rs)){
                            $point = $rs[0];
                            for ($k = 0; $k < $cps; $k++) {
                                $tmp = strtolower($pan[$k]);
                                $game[$i]['pan'][$j]['points' . $tmp . 'b'] = ComFunc::pr2($point[$tmp]);
                            }
                        }else{
                            $game[$i]['pan'][$j]['points' . $tmp . 'b'] = 0;
                        }
                    } else {
                        $rs = $db->select("select {$str} from x_points where userid='{$userid}' and gid='{$tgid}' and class='{$tclass}'  and  ab='0' ");
                        if (!empty($rs)) {
                            $point = $rs[0];
                            for ($k = 0; $k < $cps; $k++) {
                                $tmp = strtolower($pan[$k]);
                                $game[$i]['pan'][$j]['points' . $tmp . '0'] = ComFunc::pr2($point[$tmp]);
                            }
                        }else{
                            echo $tclass.'<br>';
                            exit();
                            $game[$i]['pan'][$j]['points' . $tmp . '0'] = 0;
                        }
                    }
                } else {
                    $rs = $db->select("select a from x_points where userid='{$userid}' and gid='{$tgid}' and class='{$tclass}'  and  ab='0' ");
                    if (!empty($rs)){
                        $point = $rs[0];
                        $game[$i]['pan'][$j]['pointsa0'] = ComFunc::pr2($point['a']);
                    }else{
                        $game[$i]['pan'][$j]['pointsa0'] = 0;
                    }
                }
            }
            $i++;
        }
        view()->share('lottery', $lottery);
        view()->share('game', $game);
        view()->share('lottery', $lottery);
        view()->share('adminname', $adminname);
        return view('managev1.my.info');
    }

    public function changePassword(Request $request){
        $istest = env('TEST_PLATFORM');
        if($istest == 1 && $this->adminInfo['ifhide'] == 0){
            return Json::error('测试平台不允许该操作');
        }
        $oldPassword = $request->post('oldPassword','');
        $password = $request->post('password','');
        $adminid = $this->adminid;
        $user = Admin::where('adminid', $adminid)->select(['adminpass'])->first();
        $upass = x_config('upass');
        $oldPassword = md5($oldPassword . $upass);
        $password = md5($password . $upass);
        if ($user['adminpass'] != $oldPassword) {
            return Json::error('原密码错误');
        }
        $res = Admin::where('adminid', $adminid)->update(['adminpass' => $password]);
        if ($res) {
            ComFunc::adduseredit(['userid'=>$this->uid,'mduserid'=>$this->uid,'adminid'=>$adminid,'action'=>'资料更改【密码】','old'=>'','new'=>'','moduleKey'=>'user','functionKey'=>'accinfo','actionKey'=>'update']);
            return Json::success('修改成功');
        }
    }

    public function factoryauthenication(){
        $user = Admin::where('adminid',$this->adminid)->first();
        $username = $user['adminname'];
        $authcode = GoogleAuthenticator::CreateSecret();
        $secret = $authcode['secret'];
        $codeurl = $authcode['codeurl'];
        $codeurl = str_replace('?secret',"{$username}:{$username}".'?secret', $codeurl);
        $codeurl .= "&issuer={$username}";
        if($user['google_open'] == 0){
            Admin::where('adminid',$this->adminid)->update(['google_secret'=>$secret]);
        }
        view()->share('codeurl',$codeurl);
        view()->share('secret',$secret);
        view()->share('username',$username);
        view()->share('u1',$username.'-'.$username);
        view()->share('google_open',$user['google_open']);
        return view('managev1.my.factoryauthenication');
    }

    public function savefacode(Request $request){
        $id = $request->post('id','');
        $passname = $request->post('passname','');
        $secretkey = $request->post('secretkey','');
        $faCode = $request->post('facode','');
        $user = Admin::where('adminid',$this->adminid)->first();
        if($user['google_open'] == 1){
            return Json::error('已绑定谷歌口令',[],false);
        }
        //校验谷歌口令
        $checkResult = GoogleAuthenticator::CheckCode($user['google_secret'], $faCode);
        if (!$checkResult){
            return Json::error('更新失败，密码过剘 !',[],false);
        }
        //更新
        $res = Admin::where('adminid',$this->adminid)->update(['google_open'=>1]);
        if($res){
            ComFunc::adduseredit(['userid'=>$this->uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'资料更改【绑定谷歌口令】','old'=>'','new'=>'','moduleKey'=>'user','functionKey'=>'accinfo','actionKey'=>'update']);
            return Json::success('绑定成功',[],false);
        }else{
            return Json::error('绑定失败',[],false);
        }
    }

    public function resetsub(Request $request){
        $userpassid = $request->post('userpassid','');
        $username = $request->post('username','');
        $type = $request->post('type','');
        $user = Admin::where('adminid',$this->adminid)->first();
        //更新google_open为0
        $res = Admin::where('adminid',$this->adminid)->update(['google_open'=>0]);
        if($res){
            ComFunc::adduseredit(['userid'=>$this->uid,'mduserid'=>$this->uid,'adminid'=>$this->adminid,'action'=>'资料更改【解绑谷歌口令】','old'=>'','new'=>'','moduleKey'=>'user','functionKey'=>'accinfo','actionKey'=>'update']);
            return Json::success('解绑成功',[],false);
        }else{
            return Json::error('解绑失败',[],false);
        }
    }

    public function backshare(Request $request){
        $userid = $this->uid;
        $user = User::where('userid',$userid)->select(['username','name','layer'])->first();
        $typeids = Gamezc::where(['userid'=>$userid,'flytype'=>1])->pluck('typeid')->toArray();
        $lotterys = Game::whereIn('fast',$typeids)->whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','lottery','template','dftype','gid'])->orderBy('xsort')->get()->toArray();
        foreach ($lotterys as &$game){
            $dftype = json_decode($game['dftype'], true);
            $fly = [];
            foreach ($dftype as $key=>$val) {
                $fly_single = Fly::where(['class'=>$key,'userid'=>$userid,'gid'=>$game['gid']])->first();
                if(empty($fly_single)){
                    $fly[$key]['je'] = 0;
                    $fly[$key]['ifok'] = 0;
                }else{
                    $fly[$key]['je'] = $fly_single['je'];
                    $fly[$key]['ifok'] = $fly_single['ifok'];
                }
                $fly[$key]['name'] = $val;
                $fly[$key]['class'] = $key;
            }
            //根据dftype数组数量拆分成两个数组，如果有多的则放在第一个数组
            $count = count($fly);
            $count1 = ceil($count/2);
            $count2 = floor($count/2);
            $list = [];
            $list[] = array_slice($fly,0,$count1);
            $list[] = array_slice($fly,$count1,$count2);
            $game['flylist'] = $list;
        }
        view()->share('layername', '公司');
        view()->share('lotterys', $lotterys);
        view()->share('username', $user['username']);
        view()->share('name', $user['name']);
        return view('agentv1.backshare.backshare');
    }

    public function saveBackShare(Request $request){
        $userid = $this->uid;
        $list = $request->input('list','');
        $list = json_decode($list,true);
        $tmp = [];
        foreach ($list as $v){
            $lottery = $v['lottery'];
            if(!isset($tmp['g'.$lottery])){
                $tmp['g'.$lottery] = Game::where('lottery',$lottery)->select(['gid','gname','dftype'])->first();
            }
            $game = $tmp['g'.$lottery];
            $dftype = json_decode($game['dftype'], true);
            $gid = $game['gid'];
            $cs = $v['game'];
            $update = [];
            if(isset($v['enabled'])){
                $update['ifok'] = $v['enabled'] == 'true' ? 1 : 0;
            }
            if(isset($v['flag'])){
                $update['je'] = $v['flag'];
            }
            $oldfly = Fly::where(['userid'=>$userid,'gid'=>$gid,'class'=>$cs])->first();
            $log = [];
            $log['userid'] = $userid;
            $log['adminid'] = $this->uid;
            $log['mduserid'] = $userid;
            $log['action'] = $game['gname']."-".$dftype[$cs];
            $log['title'] = '自动补货';
            $log['moduleKey'] = 'autoback';
            $log['functionKey'] = 'autoback';
            $log['actionKey'] = 'update';
            if(empty($oldfly)){
                $update['userid'] = $userid;
                $update['gid'] = $gid;
                $update['class'] = $cs;
                $update['ab'] = 'A';
                Fly::insert($update);
                $log['old'] = '0-0';
                $log['new'] = $update['je'].'-'.$update['ifok'];
            }else{
                Fly::where(['userid'=>$userid,'gid'=>$gid,'class'=>$cs])->update($update);
                $log['old'] = $oldfly['je'].'-'.$oldfly['ifok'];
                $log['new'] = $update['je'].'-'.$update['ifok'];
            }
            ComFunc::adduseredit($log);
        }
        return Json::success('保存成功');
    }
}
