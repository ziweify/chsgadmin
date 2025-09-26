<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Admin;
use App\Models\Game\Autozj;
use App\Models\Game\Autozjlog;
use App\Models\Game\FollowplanFrommember;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\ort\glob\IpUtils;
use App\ort\sgwin\UserOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AutozjController extends ManageAuthController
{

    public function autozjpage(){
        return view('managev1.autozj.autozjlist');
    }

    public function getautozjlist(Request $request){
        $username = $request->input('username','');
        $where = [];
        if(!empty($username)){
            $userid = User::where('username',$username)->value('userid');
            $where['userid'] = $userid;
        }
        $pagesize = 20; $db = Db::connection();
        $list = Autozj::where($where)->paginate($pagesize);
        foreach ($list as $k => $v) {
            $online = UserOnline::getUserOnlineInfo($v['userid']);
            $ip = isset($online['ip']) ? $online['ip'] : '';
            $list[$k]['ip'] = !empty($ip) ? $ip : '无';
            $list[$k]['mode'] = $v['mode'] == 1 ? '赢' : '输';
            $list[$k]['momey'] = $v['money1'].'|'.$v['money2'].'|'.$v['money3'];
            if($v['fwtime']){
                $list[$k]['fwtime'] = date('Y-m-d H:i:s',$v['fwtime']);
            }else{
                $list[$k]['fwtime'] = '--';
            }
            $u = User::where('userid',$v['userid'])->select(['username','sy','jetotal'])->first();
            $list[$k]['username'] = $u['username'];
            $list[$k]['sy'] = $u['sy'];
            $list[$k]['jetotal'] = $u['jetotal'];
            //是否有跟投
            $gtrs = $db->select("SELECT c.userid FROM x_followplan_frommember as a INNER JOIN x_followplan as b on (a.followplan_id=b.id) INNER JOIN x_followplan_tomember as c on (b.id=c.followplan_id) WHERE b.enabled=1 and a.userid='{$v['userid']}'");
            $uids = [];
            foreach ($gtrs as $item){
                $uids[] = $item['userid'];
            }
            $usernames = '';
            if(count($uids) > 0){
                $usernames = User::whereIn('userid',$uids)->pluck('username')->toArray();
                $usernames = implode(',',$usernames);
                $list[$k]['gtcount'] = count($uids).'人|'.$usernames;
            }else{
                $list[$k]['gtcount'] = '0人';
            }
        }
        return response()->json(['list'=>$list->items(),'count' =>$list->total()]);
    }

    public function addautozj(Request $request){
        $username = $request->input('username','');
        $money1 = $request->input('money1','');
        $money2 = $request->input('money2','');
        $money3 = $request->input('money3','');
        $ips = $request->input('ips','');
        $houtai = $request->input('houtai',0);
        $gongsi = $request->input('gongsi',1);
        $gudong = $request->input('gudong',1);
        $mode = $request->input('mode',1);
        $zjcount = $request->input('zjcount',1);
        $zjtatalcount = $request->input('zjtatalcount',1);
        $ipcustom = $request->input('ipcustom','');
        if(empty($username)){
            return response()->json(['status'=>400,'msg'=>'请输入会员账号']);
        }
        $user = User::where(['username'=>$username,'ifagent'=>0,'ifson'=>0])->first();
        if(empty($user)){
            return response()->json(['status'=>400,'msg'=>'会员账号不存在']);
        }
        $count = Autozj::where('userid',$user['userid'])->count();
        if($count > 0){
            return response()->json(['status'=>400,'msg'=>'该用户已存在改单列表']);
        }
        $data = [
            'userid' => $user['userid'],
            'money1' => $money1,
            'money2' => $money2,
            'money3' => $money3,
            'ips' => $ips,
            'houtai' => $houtai,
            'mode' => $mode,
            'zjcount' => $zjcount,
            'zjtatalcount' => $zjtatalcount,
        ];
        for($i = $user['layer']-1;$i > 0;$i--){
            if($i == 1 && $gongsi == 1){
                $data['uid'.$i] = $user['fid'.$i];
            }elseif ($gudong == 1){
                $data['uid'.$i] = $user['fid'.$i];
            }
        }
        $res = Autozj::create($data);
        if($res){
            //添加自定义ip
            if(!empty($ipcustom)){
                User::where('userid',$user['userid'])->update(['ipcustom'=>$ipcustom]);
            }
            //清理缓存
            Cache::delete("autozjlist");
            return response()->json(['status'=>200,'msg'=>'添加成功']);
        }else{
            return response()->json(['status'=>400,'msg'=>'添加失败']);
        }
    }

    public function editautozj(Request $request){
        $uid = $request->input('uid','');
        $money1 = $request->input('money1','');
        $money2 = $request->input('money2','');
        $money3 = $request->input('money3','');
        $ips = $request->input('ips','');
        $houtai = $request->input('houtai',0);
        $gongsi = $request->input('gongsi',1);
        $gudong = $request->input('gudong',1);
        $mode = $request->input('mode',1);
        $zjcount = $request->input('zjcount',1);
        $zjtatalcount = $request->input('zjtatalcount',1);
        $ipcustom = $request->input('ipcustom','');
        if(empty($uid)){
            return app('json')->fail('参与错误');
        }
        $user = User::where(['userid'=>$uid,'ifagent'=>0,'ifson'=>0])->first();
        if(empty($user)){
            return response()->json(['status'=>400,'msg'=>'会员账号不存在']);
        }
        $old = Autozj::where('userid',$user['userid'])->first();
        if(empty($old)){
            return response()->json(['status'=>400,'msg'=>'数据不存在']);
        }
        $data = [
            'money1' => $money1,
            'money2' => $money2,
            'money3' => $money3,
            'ips' => $ips,
            'houtai' => $houtai,
            'mode' => $mode,
            'zjcount' => $zjcount,
            'zjtatalcount' => $zjtatalcount,
        ];
        for($i = $user['layer']-1;$i > 0;$i--){
            $data['uid'.$i] = 0;
            if($i == 1 && $gongsi == 1){
                $data['uid'.$i] = $user['fid'.$i];
            }elseif ($gudong == 1){
                $data['uid'.$i] = $user['fid'.$i];
            }
        }
        //更新
        Autozj::where('userid',$user['userid'])->update($data);
        User::where('userid',$user['userid'])->update(['ipcustom'=>$ipcustom]);
        //清理缓存
        Cache::delete("autozjlist");
        return response()->json(['status'=>200,'msg'=>'修改成功']);
    }

    public function getautozjbyid(Request $request){
        $id = $request->input('id','');
        $info = Autozj::with(['user'])->where('id',$id)->first();
        $info['username'] = $info['user']['username'];
        $info['jetotal'] = $info['user']['jetotal'];
        $info['sy'] = $info['user']['sy'];
        if($info['uid1'] > 0){
            $info['gongsi'] = 1;
        }else{
            $info['gongsi'] = 0;
        }
        if($info['uid2'] > 0 || $info['uid3'] > 0 || $info['uid4'] > 0) {
            $info['gudong'] = 1;
        }else{
            $info['gudong'] = 0;
        }
        $info['ipcustom'] = User::where('userid',$info['userid'])->value('ipcustom');
        if(!empty($info['ipcustom'])){
            $info['ipaddress'] = IpUtils::getaddrbyip($info['ipcustom']);
        }
        if($info){
            return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$info->toArray()]);
        }else{
            return response()->json(['status'=>400,'msg'=>'获取失败']);
        }
    }

    public function delautozj(Request $request){
        $id = $request->input('id','');
        if(empty($id)){
            return response()->json(['status'=>400,'msg'=>'参数错误']);
        }
        if($this->adminInfo['ifhide'] == 0){
            return response()->json(['status'=>400,'msg'=>'您没有权限删除，请联系管理员']);
        }
        $res = Autozj::where('id',$id)->delete();
        if($res){
            //清理缓存
            Cache::delete("autozjlist");
            return response()->json(['status'=>200,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>400,'msg'=>'删除失败']);
        }
    }

    public function getautozjloglist(Request $request){
        $username = $request->input('username','');
        $limit = $request->input('limit',15);
        $where = [];
        if(!empty($username)){
            $user = User::where('username',$username)->first();
            if(empty($user)){
                return response()->json(['status'=>400,'msg'=>'会员账号不存在']);
            }
            $where['userid'] = $user['userid'];
        }
        $list = Autozjlog::with(['user'])->where($where)->orderBy('id','desc')->paginate($limit);
        $layers = json_decode(x_config('layer'),true);
        foreach ($list->items() as &$item){
            $cha = (time()-$item['time']);
            $item['time'] = date('d H:i:s',$item['time']);
            $restult = intval($cha).'秒前访问';
            if($cha > 60){
                $vt = intval(($cha/60));
                $restult = $vt.'分钟前';
                if($vt > 60){
                    $b = intval(($vt/60));
                    $restult = $b.'小时前';
                }
            }
            $item['restult'] = $restult;
            $item['cha'] = $cha;
            if($item['type'] == 1) {
                $item['username'] = $item['user']['username'];
                $item['layer'] = $item['user']['layer'];
                $item['layername'] = $layers[$item['layer']-1];
                if($item['ziuserid'] != $item['userid']){
                    $item['username'] = User::where('userid',$item['ziuserid'])->value('username');
                    $item['layername'] = $item['layername'].'(子)';
                }
            }else{
                if(!isset($temp['u'.$item['adminid']])){
                    $temp['u'.$item['adminid']] = Admin::where('adminid',$item['adminid'])->value('adminname');
                }
                $item['username'] = $temp['u'.$item['adminid']];
                $item['layername'] = '公司';
            }
        }
        return response()->json(['status'=>200,'msg'=>'获取成功','list'=>$list->items(),'total'=>$list->total()]);
    }
}




























