<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Admin;
use App\Models\Game\Auto;
use App\Models\Game\Autozjlog;
use App\Models\Game\Baototal;
use App\Models\Game\Complex;
use App\Models\Game\Config;
use App\Models\Game\Followplan;
use App\Models\Game\Game;
use App\Models\Game\Gamemsg;
use App\Models\Game\Kj;
use App\Models\Game\Lib;
use App\Models\Game\Online;
use App\Models\Game\Play;
use App\Models\Game\PlayUser;
use App\Models\Game\Points;
use App\Models\Game\Pointsback;
use App\Models\Game\TaxUser;
use App\Models\Game\User;
use App\Models\Game\UserEdit;
use App\Models\Game\UserLogin;
use App\Models\Game\Userpatt;
use App\Models\Game\WaterUser;
use App\Models\Game\Web;
use App\ort\common\AdminFunc;
use App\ort\common\ArrayUtils;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\common\CsFunc;
use App\ort\glob\IpUtils;
use App\ort\services\AutosService;
use App\ort\services\BtServices;
use App\ort\services\ConfigService;
use App\ort\services\XwebService;
use App\ort\sgwin\Json;
use App\ort\sgwin\ReportService;
use App\ort\sgwin\SGUtils;
use App\ort\sgwin\UserOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\task;

class SettingController extends ManageAuthController
{

    public function quick(Request $request){
        $lotterys = Game::where('ifopen', 1)->select(['gname','lottery','fenlei','dftype','patt','gid','template'])->orderBy('xsort')->get();
        $result = [];
        foreach ($lotterys as $game){
            $dftype = json_decode($game['dftype'], true);
            $patt = json_decode($game['patt'], true);
            $patt = ArrayUtils::array_to_collapse($patt,'bc');
            $gitem = [];
            $gitem['lottery'] = $game['lottery'];
            $gitem['gname'] = $game['gname'];
            $gitem['template'] = $game['template'];
            $list = [];
            foreach ($dftype as $k => $v) {
                //赔率
                $peilvs = $patt[$k];
                $oks = [];
                foreach ($peilvs as $key=>$p){
                    $okitem['pla'] = $p['p'];
                    $okitem['plname'] = $p['name'];
                    $okitem['cma'] = $p['p'];
                    $okitem['minBetAmount'] = $p['minBetAmount'];
                    $okitem['maxBetAmount'] = $p['maxBetAmount'];
                    $okitem['maxUserPeriodAmount'] = $p['maxUserPeriodAmount'];
                    $okitem['maxPeriodAmount'] = $p['maxPeriodAmount'];
                    $okitem['ck'] = $k;
                    $okitem['ok'] = $p['key'];
                    $okitem['ckname'] = $v;
                    $oks[] = $okitem;
                }
                $list[$k] = $oks;
            }
            $gitem['list'] = $list;
            $result[] = $gitem;
        }
        view()->share("results", $result);
        view()->share("lotterys", $lotterys);
        return view('managev1.setting.quick');
    }

    public function savequick(Request $request){
        $odds = $request->input('odds','');
        $cm = $request->input('cm','');
        $odds = json_decode($odds,true);
        $cm = json_decode($cm,true);
        foreach ($odds as $v){//保存赔率
            $lottery = $v['lottery'];
            $game = Game::where('lottery',$lottery)->select(['gid','patt'])->first();
            $gid = $game['gid'];
            $patt = json_decode($game['patt'],true);
            $key = $v['key'];
            $values = $v['values'];
            $patt[$key]['p'] = ComFunc::pr4($values[0]);
            Game::where('lottery',$lottery)->update(['patt'=>json_encode($patt)]);
            Play::where(['gid'=>$gid,'ptype'=>$key])->update(['peilv1'=>$values[0],'mp1'=>$values[0]]);
        }
        foreach ($cm as $v){//保存退水
            $lottery = $v['lottery'];
            $game = Game::where('lottery',$lottery)->select(['patt'])->first();
            $patt = json_decode($game['patt'],true);
            $key = $v['key'];
            $values = $v['values'];
            $patt[$key]['minBetAmount'] = $values[0];
            $patt[$key]['maxBetAmount'] = $values[1];
            $patt[$key]['maxUserPeriodAmount'] = $values[2];
            $patt[$key]['maxPeriodAmount'] = $values[2];
            Game::where('lottery',$lottery)->update(['patt'=>json_encode($patt)]);
        }
        return Json::success('保存成功',[],false);
    }

    public function quicktball(){
        $lotterys = Game::whereIn('gid', function ($query){
            $query->select('gid')->from('gamecs')->where('userid',['userid'=>$this->uid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['patt1','gid'])->orderBy('xsort')->get();
        foreach ($lotterys as $game){
            $patt = json_decode($game['patt1'], true);
            foreach ($patt as $k=>$v){
               Play::where(['gid'=>$game['gid'],'ptype'=>$k])->update(['peilv1'=>$v['a'],'mp1'=>$v['a']]);
            }
        }
        return Json::success('操作成功',[],false);
    }

    public function oddscopy(Request $request){
        $from = $request->input('from','');
        $to = $request->input('to','');
        $range = $request->input('range','');
        $types = $request->input('types','');
        $lottery = $request->input('lottery','');
        if(empty($from) || empty($to) || empty($range)){
            return Json::error('参数错误',[],false);
        }
        $fromuser = User::where('username', $from)->select(['userid','layer'])->first();
        $fromlayer = $fromuser['layer'];
        $fromid = $fromuser['userid'];
        $touser = User::where('username', $to)->select(['userid','layer'])->first();
        $tolayer = $touser['layer'];
        $toid = $touser['userid'];
        $lotterys = Game::when(!empty($lottery),function ($query)use ($lottery){return $query->where('lottery', $lottery);})
            ->where('ifopen', 1)->select(['patt1','gid'])->orderBy('xsort')->get();
        foreach ($lotterys as $game){
            if($fromlayer == 0){
                $patt = json_decode($game['patt1'], true);
            }else{
                $patt = json_decode(Userpatt::where(['userid'=>$fromid,'gid'=>$game['gid']])->value('patt1'), true);
            }
            if($tolayer == 0){
                Game::where('gid', $game['gid'])->update(['patt1'=>json_encode($patt)]);
            }else{
                Userpatt::where(['userid'=>$toid,'gid'=>$game['gid']])->update(['patt1'=>json_encode($patt)]);
            }
            foreach ($patt as $k=>$v){
                if($tolayer == 0){
                    Play::where(['gid'=>$game['gid'],'ptype'=>$k])->update(['peilv1'=>$v['a'],'mp1'=>$v['a']]);
                }else{
                    PlayUser::where(['gid'=>$game['gid'],'ptype'=>$k,'userid'=>$toid])->update(['peilv1'=>$v['a'],'mp1'=>$v['a']]);
                }
            }
        }
        //先删除所有退水
        Points::where(['userid'=>$toid])->delete();
        Pointsback::where(['userid'=>$toid])->delete();
        //复制退水
        $db = Db::connection();
        $db->insert("insert into x_points select NULL,gid,$toid,class,ab,a,b,c,d,cmaxje,maxje,minje from x_points where userid='$fromid'");
        $db->insert("insert into x_points_bak select NULL,gid,$toid,class,ab,a,b,c,d,cmaxje,maxje,minje from x_points where userid='$fromid'");
        return Json::success('操作成功',[],false);
    }

    public function commission(Request $request){
        $lotterys = Game::where('ifopen', 1)->select(['gname','lottery','template','gid','point'])->orderBy('xsort')->get()->toArray();
        view()->share("lotterys", $lotterys);
        return view('managev1.setting.commission');
    }

    public function savecommission(Request $request){
        $params = $request->input('params','');
        $params = json_decode($params,true);
        $tmp = [];
        foreach ($params as $v){
            $gid = $v['gid'];
            $point = $v['point'];
            if(is_numeric($point)){
                Game::where(['gid'=>$gid])->update(['point' => $point]);
            }
        }
        return Json::success('保存成功',[],false);
    }

    public function system(){
        $config = Config::where('id',1)->first();
        view()->share("config", $config);
        view()->share("username", $this->adminInfo['adminname']);
        return view('managev1.setting.system');
    }

    public function educheck(){
        AdminFunc::jiaozhengedu(true);
        return Json::success('成功');
    }

    public function getipsbytype(Request $request){
        $type = $request->input('type','');
        //获取当日的ip列表，通过group ip
        if($type == 1){
            $d = date('Y-m-d');
            $ds = $d.' 06:59:15';
            $list = Autozjlog::where('time','>=',strtotime($ds))->groupBy('ip')->select(['ip'])->get()->toArray();
            $ips = array_column($list,'ip');
            //通过,拼接成字符串
            $ips = implode(',',$ips);
        }elseif ($type == 2){//获取后天所有ip
            $adminids = Admin::where('ifhide',1)->select(['adminid'])->get()->toArray();
            $users = UserOnline::getallipbyxtype(0,$adminids);
            $ips = array_column($users,'ip');
            //通过,拼接成字符串
            $ips = implode(',',$ips);
        }
        return Json::success('成功',['ips'=>$ips]);
    }

    public function resetftime(){
        $his = date("His");
        if (str_replace(":", "", x_config('editend')) > $his) {
            $ftime = date("Y-m-d ", time()-86400);
        } else {
            $ftime = date("Y-m-d ");
        }
        User::where('id','>',0)->update(['ftime'=>strtotime($ftime)]);
        return Json::success('成功');
    }

    public function saveSystem(Request $request){
        $istest = env('TEST_PLATFORM');
        if($istest == 1 && $this->adminInfo['ifhide'] == 0){
            return Json::error('测试平台不允许修改');
        }
        $configs = $request->input('configs','');
        $configs = json_decode($configs,true);
        foreach ($configs as $v){
            if($v['key'] == 'supass' && empty($v['value'])){
                continue;
            }
            Config::where('id',1)->update([$v['key']=>$v['value']]);
            ConfigService::clearSingle($v['key']);
        }
        return Json::success('保存成功');
    }


    public function lotterys(){
        $lotterys = Game::where('ifopen', 1)->select(['gname','lottery','gid','userclosetime','thisqishu','jsqishu','pause','cs'])->orderByRaw('xsort asc')->get();
        foreach ($lotterys as &$game){
            $kj = Kj::where(['gid'=>$game['gid'],'qishu'=>$game['thisqishu']])->first();
            if(!empty($kj)){
                $game['opentime'] = date('Y-m-d H:i:s',$kj['opentime']);
                $game['myclosetime'] = date('Y-m-d H:i:s',$kj['closetime']-$game['userclosetime']);
                $game['closetime'] = date('Y-m-d H:i:s',$kj['closetime']);
                $game['kjtime'] = date('Y-m-d H:i:s',$kj['kjtime']);
            }else{
                $game['opentime'] = '';
                $game['myclosetime'] = '';
                $game['closetime'] = '';
                $game['kjtime'] = '';
            }

            //封盘时间
            $csjson = json_decode($game['cs'], true);
            $closetime = $csjson['closetime'];
            $game['closetime'] = $csjson['closetime'];
            $game['closepant'] = $closetime+$game['userclosetime'];
        }
        $username = User::where('userid', $this->uid)->value('username');
        view()->share("username", $username);
        view()->share("lotterys", $lotterys);
        return view('managev1.setting.lotterys');
    }

    public function modifyfptime(Request $request){
        $gid = $request->input('gid','');
        $userclosetime = $request->input('userclosetime','');
        if(!is_numeric($userclosetime)){
            return Json::error('封盘时间必须为数字');
        }
        $update = [];
        $update['userclosetime'] = $userclosetime;
        Game::where('gid', $gid)->update($update);
        return Json::success('保存成功',[]);
    }

    public function lotteryspause(Request $request){
        $username = $request->input('username','');
        $lottery = $request->input('lottery','');
        $pause = $request->input('pause','');
        //更新game
        Game::where('lottery', $lottery)->update(['pause'=>$pause]);
        return Json::success('保存成功',[],false);
    }

    public function lotterysedit(Request $request){
        $lottery = $request->input('lottery','');
        $game = Game::where('lottery', $lottery)->first();
        view()->share("game", $game);
        $cs = json_decode($game['cs'], true);
        view()->share("cs", $cs);
        view()->share("isauth", in_array('sys.znkj',$this->auths) ? 1 : 0);
        return view('managev1.setting.lotterysedit');
    }

    public function lotteryssave(Request $request){
        $lottery = $request->input('lottery','');
        $userclosetime = $request->input('fengpan','');
        $xsort = $request->input('sort','');
        $pause = $request->input('pause','');
        $cjmode = $request->input('cjmode','');
        $xtmode = $request->input('xtmode','');
        $kongje = $request->input('kongje','');
        $ylup = $request->input('ylup','');
        $game = Game::where('lottery', $lottery)->select(['cs','lotCode'])->first();
        $update = [];$kjw_is_run = x_config('kjw_is_run');
        $cs = json_decode($game['cs'], true);
        if($cjmode != $cs['cjmode'] && $kjw_is_run == 1){
            $laiyuan = $cjmode == 0 ? 1 : 0;
            \App\Models\Kjw\Game::where('lotCode', $game['lotCode'])->update(['laiyuan'=>$laiyuan]);
        }
        $cs['cjmode'] = $cjmode;
        $cs['xtmode'] = $xtmode;
        $cs['kongje'] = $kongje;
        $cs['ylup'] = $ylup;
        $update['cs'] = json_encode($cs);
        $update['userclosetime'] = $userclosetime;
        $update['xsort'] = $xsort;
        $update['pause'] = $pause;
        Game::where('lottery', $lottery)->update($update);
        return Json::success('保存成功',[],false);
    }

    public function oddsdown(Request $request){
        $username = $request->input('username');
        $enable_mjpei = x_config('enable_mjpei');
        if($enable_mjpei == 0) {
            $users = User::where(['pself' => 1, 'ifagent' => 1])->select(['username', 'layer', 'name', 'userid'])->get()->toArray();
        }else{
            $users = User::where(['pself' => 1, 'ifagent' => 1])->where('userid','<>',Constants::$SUID)->select(['username', 'layer', 'name', 'userid'])->get()->toArray();
        }
        if(empty($username)){
            if($enable_mjpei == 0){
                $userid = $this->uid;
                $user = User::where(['userid'=>$userid])->select(['userid','username','layer'])->first();
            }else{
                $userid = $users[0]['userid'];
                $user = User::where(['userid'=>$userid])->select(['userid','username','layer'])->first();
            }
        }else{
            $user = User::where(['username'=>$username])->select(['userid','username','layer'])->first();
            $userid = $user['userid'];
        }
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','lottery','fenlei','dftype','gid','template'])->orderBy('xsort')->get();
        foreach ($lotterys as &$game){
            $dftype = json_decode($game['dftype'], true);
            $auto = [];
            foreach ($dftype as $key=>$val) {
                $auto_single = Auto::where(['class'=>$key,'userid'=>$userid,'gid'=>$game['gid']])->first();
                if(empty($auto_single)){
                    $auto[$key]['stopje'] = 0;
                    $auto[$key]['addje'] = 0;
                    $auto[$key]['attpeilv'] = 0;
                    $auto[$key]['lowpeilv'] = 0;
                    $auto[$key]['ifzc'] = 0;
                }else{
                    $auto[$key]['stopje']     = ComFunc::pr0($auto_single['stopje']);
                    $auto[$key]['addje']      = ComFunc::pr0($auto_single['addje']);
                    $auto[$key]['attpeilv']   = ComFunc::pr4($auto_single['attpeilv']);
                    $auto[$key]['lowpeilv']   = ComFunc::pr4($auto_single['lowpeilv']);
                    $auto[$key]['ifzc']       = $auto_single['ifzc'];
                }
                $auto[$key]['name'] = $val;
                $auto[$key]['class'] = $key;
            }
            $game['auto'] = $auto;
        }
        view()->share("lotterys", $lotterys);
        $layers = json_decode(x_config('layer'), true);
        foreach ($users as &$u){
            if($u['layer'] == 1) {
                $u['layername'] = $layers[$u['layer']-1];
            }
        }
        view()->share("users", $users);
        view()->share("username", $user['username']);
        return view('managev1.setting.oddsdown');
    }

    public function oddsdowntball(Request $request){
        $username = $request->input('username','');
        $user = User::where('username', $username)->select(['userid','username','layer'])->first();
        $enable_mjpei = x_config('enable_mjpei');
        if($enable_mjpei == 0) {
            $users = User::where(['pself' => 1, 'ifagent' => 1])->select(['username', 'layer', 'name', 'userid'])->get()->toArray();
        }else{
            $users = User::where(['pself' => 1, 'ifagent' => 1])->where('userid','<>',Constants::$SUID)->select(['username', 'layer', 'name', 'userid'])->get()->toArray();
        }
        $db = Db::connection();
        foreach ($users as $u){
            if($user['userid'] != $u['userid']){
                $uid = $u['userid'];
                $db->insert("insert into x_auto select NULL,gid,class,$uid,ifok,startje,startpeilv,addje,attpeilv,lowpeilv,stopje,ifzc,yj,qsnum,qspeilv from x_auto where userid='{$user['userid']}'");
            }
        }
        $gids = Game::whereIn('gid', function ($query){
            $query->select('gid')->from('gamecs')->where(['userid'=>$this->uid,'ifok'=>1]);
        })->where('ifopen', 1)->pluck('gid')->toArray();
        foreach ($gids as $gid){
            Cache::delete('autolist_'.$gid);
        }
        return Json::success('操作成功');
    }

    public function oddsdownsave(Request $request){
        $username = $request->input('username','');
        if(empty($username)){
            return Json::error('用户名不能为空',[],false);
        }
        $user = User::where('username', $username)->select(['userid'])->first();
        $list = $request->input('list','');
        $list = json_decode($list,true);
        $tmp = [];$gids = [];
        foreach ($list as $v){
            $lottery = $v['lottery'];
            if(!isset($tmp['g'.$lottery])){
                $tmp['g'.$lottery] = Game::where('lottery',$lottery)->select(['gid'])->first();
                $gids[] = $tmp['g'.$lottery]['gid'];
            }
            $game = $tmp['g'.$lottery];
            $gid = $game['gid'];
            $cs = $v['game'];
            $update = [];
            if(isset($v['flag'])){
                $update['addje'] = $v['flag'];
                $update['startje'] = $v['flag'];
            }
            if(isset($v['down'])){
                $update['attpeilv'] = $v['down'];
                $update['startpeilv'] = $v['down'];
            }
            if (isset($v['ifzc'])) $update['ifzc'] = $v['ifzc'];
            if(isset($v['maxFlag']))$update['stopje'] = $v['maxFlag'];
            if(isset($v['minOdds']))$update['lowpeilv'] = $v['minOdds'];
            if (isset($v['ifzc'])) $update['ifzc'] = $v['ifzc'];
            $oldauto = Auto::where(['userid'=>$user['userid'],'gid'=>$gid,'class'=>$cs])->first();
            if(empty($oldauto)){
                $update['userid'] = $user['userid'];
                $update['gid'] = $gid;
                $update['class'] = $cs;
                $update['ifok'] = 1;
                $update['yj'] = 0;
                $update['qspeilv'] = 0;
                $update['qsnum'] = 0;
                Auto::insert($update);
            }else{
                Auto::where(['userid'=>$user['userid'],'gid'=>$gid,'class'=>$cs])->update($update);
            }
        }
        foreach ($gids as $gid){
            Cache::delete('autolist_'.$gid);
        }
        return Json::success('保存成功',[],false);
    }

    public function onlines(Request $request){
        $type = $request->input('type',1);
        $page = $request->input('page',1);
        $mylevel = Admin::where('adminid',$this->adminid)->value('level');
        $adminids = Admin::where('level','<=',$mylevel)->pluck('adminid')->toArray();
        /*$guanli = Online::where(['xtype'=>0])->whereNotIn('userid', function ($query) use ($mylevel) {
            $query->select('adminid')->from('admins')->where(['ifhide'=>1])->orWhere('level','<=',$mylevel);
        })->count();*/
        $guanli = UserOnline::countOnlineUsersByType(0,$adminids);//Online::where(['xtype'=>0])->count();
        $daili = UserOnline::countOnlineUsersByType(1,[]);//Online::where(['xtype'=>1])->count();
        $huiyuan = UserOnline::countOnlineUsersByType(2,[]);//Online::where(['xtype'=>2])->count();
        $zidaili = UserOnline::countOnlineUsersByType(3,[]);//Online::where(['xtype'=>3])->count();
        $pagesize = 20;
        /*$list = Online::where(['xtype'=>$type])->whereNotIn('userid', function ($query) use ($mylevel) {
            $query->select('adminid')->from('admins')->where(['ifhide'=>1])->orWhere('level','<=',$mylevel);
        })->orderBy('savetime','desc')->paginate($pagesize);*/
        $list = UserOnline::getOnlineUsers($type,$pagesize,$page,$adminids)->toArray();
        $list = $list['data'];
        //计算总页数
        if($type == 0) {
            $total_page = ceil($guanli / $pagesize);
            $total_count = $guanli;
        }elseif($type == 1){
            $total_page = ceil($daili / $pagesize);
            $total_count = $daili;
        }elseif($type == 2){
            $total_page = ceil($huiyuan / $pagesize);
            $total_count = $huiyuan;
        }elseif($type == 3){
            $total_page = ceil($zidaili / $pagesize);
            $total_count = $zidaili;
        }
        $tmp = [];
        $layers = json_decode(x_config('layer'), true);
        foreach ($list as $k=>&$v){
            if($v['xtype'] != 0) {
                $user = User::where('userid', $v['userid'])->select(['username', 'name', 'layer','fid','ifagent','ifson'])->first();
                if(empty($user)){
                    UserOnline::deleteUserOnlineInfo($v['userid']);
                    unset($list[$k]);
                    continue;
                }
                $list[$k]['username'] = $user['username'];
                $list[$k]['name'] = $user['name'];
                if($user['ifson'] == 0){
                    $list[$k]['layername'] = $user['ifagent'] == 1 ? $layers[$user['layer'] - 1] : '会员';
                }else{
                    $list[$k]['layername'] = ''.$layers[$user['layer'] - 1].'-子账号';
                }
                //上级账号
                $fuser = User::where('userid', $user['fid'])->select(['username', 'name', 'layer'])->first();
                if(!empty($fuser)){
                    $list[$k]['fusername'] = $fuser['username'];
                }else{
                    $list[$k]['fusername'] = '';
                }
            }else{
                if (!isset($tmp['a' . $v['userid']])) {
                    $tmp['a' . $v['userid']] = Admin::where('adminid', $v['userid'])->select(['adminname', 'name','level','fid'])->first();
                }
                $list[$k]['username'] = $tmp['a' . $v['userid']]['adminname'];
                $list[$k]['name'] = $tmp['a' . $v['userid']]['adminname'];
                $list[$k]['layername'] = $tmp['a' . $v['userid']]['level']==1 ? '公司' : '子账号';
                $list[$k]['fusername'] = '';
            }
            //计算$v['logintime']距离现在的时间差，格式时分秒
            $chatime = time() - $v['logintime'];
            $v['chatime'] = gmstrftime('%H:%M:%S', $chatime);
            $v['savetime'] = date('H:i:s',$v['savetime']);
            $v['addr'] = IpUtils::getaddrbyip($v['ip']);
        }
        view()->share("type", $type);
        view()->share("list", $list);
        view()->share("guanli", $guanli);
        view()->share("daili", $daili);
        view()->share("huiyuan", $huiyuan);
        view()->share("zidaili", $zidaili);
        view()->share("total_page", $total_page);
        view()->share("total_count", $total_count);
        view()->share("page", $page);
        $user = User::where(['userid'=>$this->uid])->select(['userid','username','name'])->first();
        view()->share("username", $this->adminInfo['adminname']);
        view()->share("name", $user['name']);
        return view('managev1.setting.onlines');
    }

    public function kick(Request $request){
        $ifhide = $this->adminInfo['ifhide'];
        if($ifhide != 1 && env('TEST_PLATFORM') == 1){
            return Json::error('测试平台不允许踢人');
        }
        $userid = $request->input('id','');
        if(empty($userid))return Json::error('参数错误');
        $platform = $request->input('platform','');
        $online = UserOnline::getUserOnlineInfo($userid);
        if (!empty($online) && !empty($online['loginipid'])){
            UserLogin::where(['id'=>$online['loginipid']])->update(['logout_time'=>time(),'logout_type'=>1]);
        }
        UserOnline::deleteUserOnlineInfo($userid);
        if($platform != 0){
            User::where(['userid'=>$userid])->update(['online'=>0]);
        }
        return Json::success('踢出成功');
    }

    public function reportreal(Request $request){
        $userid = $this->uid;
        if($request->isMethod('post')) {
            $gid = $request->input('gid', '');
            $skip = $request->input('skip', '');
            $last = $request->input('last', '');
            $lastcount = $request->input('lastcount', '');
            $myzcstr = 'zc0';
            $where = [['z','=',9],['bs','=',1]];
            if($gid != '' && $gid != 0){
                $where[] = ['gid','=',$gid];
            }
            if($skip != '' && $skip > 0){
                $where[] = ['je','>=',$skip];
            }
            $pagesize = 50;
            $libmodel = SGUtils::getcuremodel();
            $lid = $libmodel->where($where)->where('xtype','<>',2)->orderByDesc('time')->value('id');
            $lcount = $libmodel->where($where)->where('xtype','<>',2)->orderByDesc('time')->count();
            if($lid == $last && $lcount == $lastcount){
                return response()->json(['message' => '成功','rows'=>[],'success'=>true,'total'=>0,'type'=>0]);
            }
            $list = $libmodel->where($where)->where('xtype','<>',2)->orderByDesc('time')->paginate($pagesize);
            //计算总页数
            $total = $list->total();
            $totalPage = ceil($total/$pagesize);
            $list->totalPage = $totalPage;
            $bao = [];$tmp = [];
            foreach ($list as $i=>$item){
                if (!isset($tmp['g' . $item['gid']])) {
                    $game = Game::where('gid',$item['gid'])->select(['gname','fenlei'])->first();
                    $tmp['g' . $item['gid']] = $game['gname'];
                    $tmp['f' . $item['gid']] = $game['fenlei'];
                }
                if (!isset($tmp['u' . $item['userid']])) {
                    $tmp['u' . $item['userid']] = User::where('userid',$item['userid'])->value('username');
                }
                if (!isset($tmp['b' . $item['gid'] . $item['bid']])) {
                    $tmp['b' . $item['gid'] . $item['bid']] = CsFunc::transb8('name', $item['bid'], $item['gid']);
                }
                if (!isset($tmp['s' . $item['gid'] . $item['sid']])) {
                    $tmp['s' . $item['gid'] . $item['sid']] = CsFunc::transs8('name', $item['sid'], $item['gid']);
                }
                if (!isset($tmp['c' . $item['gid'] . $item['cid']])) {
                    $tmp['c' . $item['gid'] . $item['cid']] = CsFunc::transc8('name', $item['cid'], $item['gid']);
                }
                if (!isset($tmp['p' . $item['gid'] . $item['pid']])) {
                    $tmp['p' . $item['gid'] . $item['pid']] = CsFunc::transp8('name', $item['pid'], $item['gid']);
                }
                $wf = ComFunc::wfuser($tmp['f' . $item['gid']], $tmp['b' . $item['gid'] . $item['bid']], $tmp['s' . $item['gid'] . $item['sid']], $tmp['c' . $item['gid'] . $item['cid']], $tmp['p' . $item['gid'] . $item['pid']]);
                $bao[$i]['g_id'] = $item['id'];
                $bao[$i]['g_orderid'] = $item['code'];
                $bao[$i]['g_date'] = date('Y-m-d H:i:s', $item['time']);
                $bao[$i]['cztype'] = $tmp['g' . $item['gid']];
                $bao[$i]['g_qishu'] = $item['qishu'];
                $bao[$i]['g_name'] = $tmp['u' . $item['userid']];
                $bao[$i]['g_panlu'] = $item['abcd'];
                $con = !empty($item['content']) ? $item['content'] : '';
                $bao[$i]['mingxi'] = "{$wf}</span>{$con} @ <span class=\"odds\">{$item['peilv1']}</span>";
                $bao[$i]['g_jiner'] = $item['je'];
                $bao[$i]['g_tueishui'] = (float)$item['points'];
                $bao[$i]['g_win'] = ComFunc::pr1((float)(0 - $item['je'] * (1 - $item['points'] / 100)));
                $mezc = $item[$myzcstr];
                $mers = ComFunc::pr1($item['je'] * $mezc / 100);
                $bao[$i]['zc'] = "{$mezc}%<br>{$mers}";
            }
            return response()->json(['message' => '成功','list'=>$list,'success'=>true,'total'=>count($bao),'type'=>0]);
        }else{
            $gid = $request->input('type','');
            $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
                $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
            })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
            view()->share('lotterys', $lotterys);
            view()->share('gid', $gid);
            return view('managev1.setting.reportreal');
        }
    }

    public function clearalldata(){
        $ifhide = $this->adminInfo['ifhide'];
        if($ifhide == 0){
            return Json::error('noauth');
        }
        $db = Db::connection();
        $db->delete('DELETE FROM x_admins WHERE adminid <> 10010;');
        $db->delete('DELETE FROM x_admins_page WHERE adminid <> 10010;');
        $db->delete('truncate x_apply;');
        $db->delete('TRUNCATE x_baototal;');
        $db->delete('TRUNCATE x_chatmsg;');
        $db->delete('DELETE FROM x_gamecs WHERE userid <> 99999999;');
        $db->delete('DELETE FROM x_gamemsg WHERE ruid <> 99999999;');
        $db->delete('TRUNCATE x_link;');
        $db->delete('truncate x_log;');
        $db->delete('truncate x_money_log;');
        $db->delete('truncate x_outbet_error;');
        $db->delete('truncate x_outbet_site;');
        $db->delete('truncate x_points');
        $db->delete('truncate x_roomhistory');
        $db->delete('truncate x_tax_template;');
        $db->delete('truncate x_tax_template_item;');
        $db->delete('truncate x_tax_user;');
        $db->delete('DELETE FROM x_user WHERE userid <> 99999999;');
        $db->delete('TRUNCATE x_user_edit;');
        $db->delete('TRUNCATE x_user_login;');
        $db->delete('DELETE FROM x_user_page WHERE userid <> 2001;');
        $db->delete('TRUNCATE x_userpatt;');
        $db->delete('TRUNCATE x_userreg;');
        $db->delete('TRUNCATE x_userroom;');
        //删除所有注单表
        $arr = $db->select("SHOW TABLES LIKE '%\\_lib_20%'");
        foreach ($arr as $v) {
            $tb = array_values($v)[0];
            $db->delete("DROP TABLE {$tb};");
        }
        //删除所有飞单表
        $arr = $db->select("SHOW TABLES LIKE '%\\_libfly_20%'");
        foreach ($arr as $v) {
            $tb = array_values($v)[0];
            $db->delete("DROP TABLE {$tb};");
        }
        return Json::success('清理成功');
    }

    public function clearallreport(){
        $db = Db::connection();
        //使用TRUNCATE x_baototal语句清空所有报表表
        $db->delete('TRUNCATE x_baototal;');
        return Json::success('清理成功');
    }

    public function createallreport(){
        $db = Db::connection();
        $arr = $db->select("SHOW TABLES LIKE '%\\_lib_20%'");
        //反转
        $arr = array_reverse($arr);
        foreach ($arr as $v) {
            $tb = array_values($v)[0];
            $tbdate = str_replace('x_lib_', '', $tb);
            $dates = substr($tbdate,0,4).'-'.substr($tbdate,4,2).'-'.substr($tbdate,6,2);
            $count = Baototal::where(['dates'=>strtotime($dates)])->count('id');
            if($count <= 0){
                ReportService::zhengli_day_report($tb);
            }
        }
        return Json::success('生成成功');
    }

    public function clearallorderbyusername(Request $request){
        $username = $request->input('username','');
        $days = $request->input('days',0);
        if(empty($username)){
            return Json::error('会员账号不能为空');
        }
        $userid = User::where(['username'=>$username])->value('userid');
        if(empty($userid)){
            return Json::error('用户不存在');
        }
        $db = Db::connection();
        $arr = $db->select("SHOW TABLES LIKE '%\\_lib_20%'");
        $cdate = strtotime("-{$days} day");
        $cdate = strtotime(date('Y-m-d',$cdate));
        $thisdate = ComFunc::getthisdateend();
        foreach ($arr as $v) {
            $tb = array_values($v)[0];
            //将tb 转成日期x_lib_20231011
            $tbdate = str_replace('x_lib_', '', $tb);
            $dates = substr($tbdate,0,4).'-'.substr($tbdate,4,2).'-'.substr($tbdate,6,2);
            $datesint = strtotime($dates);
            //判断天数
            if($datesint < $cdate)continue;
            //删除报表数据
            $db->delete("delete from $tb where userid = {$userid}");
            //删除x_baototal
            $db->delete("delete from x_baototal where userid = {$userid} and dates = {$datesint}");
            if($thisdate == $dates){
                //矫正额度
                AdminFunc::jiaozhengedu(true,$userid);
            }
        }
        return Json::success('生成成功');
    }

    public function report_hb(Request $request){
        $date = $request->input('date','');
        $act = $request->input('act','');
        if(!empty($date) && !empty($act)){
            $tb = "x_lib_".str_replace('-','',$date);
            if($act == 'cxhb'){
                ReportService::zhengli_day_report($tb);
            }elseif ($act == 'qkhb'){//清空合并
               Baototal::where(['dates'=>strtotime($date)])->delete();
            }
        }
        $db = Db::connection();
        $arr = $db->select("SHOW TABLES LIKE '%\\_lib_20%'");
        $list = [];
        foreach ($arr as $v) {
            $tb = array_values($v)[0];
            $tbdate = str_replace('x_lib_', '', $tb);
            $tt = str_replace('x_', '', $tb);
            $dates = substr($tbdate,0,4).'-'.substr($tbdate,4,2).'-'.substr($tbdate,6,2);
            $count = Baototal::where(['dates'=>strtotime($dates)])->sum('count');
            if($count > 0){
                $str = "合并完成";
            }else{
                $str = "尚未合并";
            }
            $order_count = $db->table($tt)->count('id');
            if($order_count <= 0){
                $str = "无注单";
            }
            $hecount = $db->table($tt)->where(['z'=>2])->count('id');
            $wjscount = $db->table($tt)->where(['z'=>9])->count('id');
            $list[] = ['bfb'=>"kc_{$dates}.db",'bf'=>"{$dates} 報表備份",'str'=>$str,'date'=>$dates,'order_count'=>$order_count,'report_count'=>$count,'hecount'=>$hecount,'wjscount'=>$wjscount];
        }
        $autodelothertime = x_config('autodelothertime');
        view()->share('autodelothertime', $autodelothertime);
        //list反转
        $list = array_reverse($list);
        view()->share('list', $list);
        $sdate = AdminFunc::week();
        view()->share("sdate", $sdate);
        view()->share("today", strtotime($sdate[10])*1000);
        return view('managev1.setting.report_hb');
    }

    public function querytax(Request $request){
        $sdate = $request->input('sdate','');
        $edate = $request->input('edate','');
        $username = $request->input('username','');
        $user = User::where(['username'=>$username])->first();
        if(empty($user)){
            return Json::error('用户不存在');
        }
        $model = new Baototal();
        //日期条件
        $model = $model->whereBetween('dates',[strtotime($sdate),strtotime($edate)]);
        if($user['ifagent'] == 1){
            $model = $model->where(['uid'.$user['layer']=>$user['userid']]);
        }else{
            $model = $model->where(['userid'=>$user['userid']]);
        }
        $totaltax = $model->sum('tax_amount');
        return Json::success('查询成功',['totaltax'=>$totaltax]);
    }

    public function cleartax(Request $request){
        $sdate = $request->input('sdate','');
        $edate = $request->input('edate','');
        $username = $request->input('username','');
        $user = User::where(['username'=>$username])->first();
        if(empty($user)){
            return Json::error('用户不存在');
        }
        $datearr = $this->getDates($sdate,$edate);
        //先清理报表赚点数据
        $model = Baototal::whereBetween('dates',[strtotime($sdate),strtotime($edate)]);
        if($user['ifagent'] == 1){
            $model = $model->where(['uid'.$user['layer']=>$user['userid']]);
        }else{
            $model = $model->where(['userid'=>$user['userid']]);
        }
        $model->delete();
        //清理注单表
        foreach ($datearr as $v){
            $tb = "x_lib_".str_replace('-','',$v);
            $db = Db::connection();
            //先判断表是否存在
            $arr = $db->select("SHOW TABLES LIKE '{$tb}'");
            if(empty($arr)){
                continue;
            }
            //更新注单表字段uzp1为0
            if($user['ifagent'] == 1){
                $db->delete("UPDATE {$tb} SET uzp1=0 WHERE uid{$user['layer']}={$user['userid']};");
            }else{
                $db->delete("UPDATE {$tb} SET uzp1=0 WHERE userid={$user['userid']};");
            }
        }
        //重新整合报表
        $thisdate = ComFunc::getthisdate();
        foreach ($datearr as $v){
            $tb = "x_lib_".str_replace('-','',$v);
            $db = Db::connection();
            //先判断表是否存在
            $arr = $db->select("SHOW TABLES LIKE '{$tb}'");
            if(empty($arr)){
                continue;
            }
            //重新整合报表
            ReportService::zhengli_day_report($tb);
            //如果过是当天矫正额度
            if($v == $thisdate){
                AdminFunc::jiaozhengedu(true);
            }
        }
        return Json::success('清理成功');
    }

    public function getDates($sdate,$edate){
        $dates = [];
        $sdate = strtotime($sdate);
        $edate = strtotime($edate);
        while ($sdate <= $edate){
            $dates[] = date('Y-m-d',$sdate);
            $sdate = strtotime('+1 day',$sdate);
        }
        return $dates;
    }

    public function getbtdata(Request $request){
        $res = (new BtServices())->getallsitelist();
        $list = $res['data'];
        $current_sort = x_config('current_sort');
        if($current_sort < 10){
            $current_sort = '0'.$current_sort;
        }
        $pre1 = "xyp".$current_sort;
        $pre2 = "sg".$current_sort;
        foreach ($list as $item){
            $id = $item['id'];
            $name = $item['name'];
            $bt_siteids = $id.'-'.$name;
            $ppre = explode('.',$name)[0];
            if(($ppre == $pre1) || ($ppre == $pre2)){
                Config::where('id',1)->update(['bt_siteids'=>$bt_siteids]);
                ConfigService::clearSingle('bt_siteids');
            }
        }
        return Json::success('ok');
    }


    public function task_list(Request $request){
        $date = $request->input('date','');
        if(empty($date)){
            $date = ComFunc::getthisdateend();
            //减少一天
            $date = date('Y-m-d',strtotime('-1 day',strtotime($date)));
        }
        $list = [
            ['id'=>1,'en'=>'backwater','name'=>'回水结算'],
            ['id'=>2,'en'=>'cashuseredu','name'=>'额度矫正'],
            ['id'=>3,'en'=>'cleardata','name'=>'清理数据'],
        ];
        foreach ($list as &$item){
            $useredit = UserEdit::where(['userid'=>Constants::$SUID,'other'=>strtotime($date),'moduleKey'=>'stystem','functionKey'=>'task','actionKey'=>$item['en']])->first();
            if(empty($useredit)){
                $item['status'] = "<span style='color: red'>未执行</span>";
                $item['time'] = '-';
                $item['oktime'] = '-';
                $item['date'] = $date;
            }else{
                $item['status'] = "<span style='color: #1f9a1f'>已执行</span>";
                $item['time'] = $useredit['newvalue'].'秒';
                $item['oktime'] = date('Y-m-d H:i:s',$useredit['moditime']);
                $item['date'] = $date;
            }
        }
        view()->share('list', $list);
        view()->share("date", $date);
        view()->share("today", strtotime($date)*1000);
        return view('managev1.setting.task');
    }

    public function once_tack(Request $request){
        $date = $request->input('date','');
        $taskname = $request->input('taskname','');
        if(empty($date)){
            return Json::error('日期不能为空');
        }
        if($taskname == 'backwater'){
            AutosService::backwaterCompete($date);//回水结算
        }
        if($taskname == 'cashuseredu'){
            AutosService::edu_zhuanhuan($date);//现金模式额度恢复
        }
        if($taskname == 'cleardata'){
            AutosService::cleardata($date);//清理数据
        }
        return Json::success('执行成功');
    }


    public function gamemsg(Request $request){
        $gid = $request->input('gid','');
        $lotterys = Game::where('ifopen', 1)->select(['gid','gname'])->get()->toArray();
        if(empty($gid)){
            $gid = $lotterys[0]['gid'];
        }
        $list = Gamemsg::where(['ruid'=>$this->uid,'gid'=>$gid])->get();
        view()->share('lotterys', $lotterys);
        view()->share('gid', $gid);
        return view('managev1.setting.gamemsg', compact('list'));
    }

    public function savegamemsg(Request $request){
        $gid = $request->input('gid','');
        $data = $request->input('data','');
        $tball = $request->input('tball',0);
        if(empty($gid) || empty($data)){
            return Json::error('参数错误');
        }
        $data = json_decode($data, true);
        foreach ($data as $item){
            $gamemsg = Gamemsg::where(['ruid'=>$this->uid,'gid'=>$gid,'keyname'=>$item['keyname']])->first();
            //更新
            if(!empty($gamemsg)){
                $gamemsg['msg_content'] = $item['msg_content'];
                $gamemsg['msg_time'] = $item['msg_time'];
                $gamemsg['remark'] = $item['remark'];
                $gamemsg->save();
            }
        }
        if($tball == 1){
            $gamemsglist = Gamemsg::where(['ruid'=>$this->uid,'gid'=>$gid])->get();
            $gids = Game::where('ifopen', 1)->where('gid', '!=', $gid)->pluck('gid')->toArray();
            foreach ($gids as $cgid){
                Gamemsg::where(['ruid'=>$this->uid,'gid'=>$cgid])->delete();
                //将gid的数据复制到当前gid
                foreach ($gamemsglist as $item){
                    $save = [];
                    $save['gid'] = $cgid;
                    $save['ruid'] = $this->uid;
                    $save['keyname'] = $item['keyname'];
                    $save['msg_name'] = $item['msg_name'];
                    $save['msg_content'] = $item['msg_content'];
                    $save['msg_time'] = $item['msg_time'];
                    $save['remark'] = $item['remark'];
                    $save['is_time'] = $item['is_time'];
                    Gamemsg::create($save);
                }
            }
        }
        return Json::success('保存成功');
    }
}























