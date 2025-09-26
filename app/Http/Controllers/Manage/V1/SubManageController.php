<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Admin;
use App\Models\Game\AdminsPage;
use App\Models\Game\Game;
use App\Models\Game\Lib;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\Models\Game\Warn;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\sgwin\Json;
use App\ort\sgwin\UserOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubManageController extends ManageAuthController
{
   public function list(Request $request){
       $admin = Admin::where('adminid',$this->adminid)->select(['level','ifhide'])->first();
       $pagesize = 10;
       $list = Admin::with(['fadmin'])->where('level','>',$admin['level'])->paginate($pagesize);
       //计算总页数
       $total = $list->total();
       $totalPage = ceil($total/$pagesize);
       $list->totalPage = $totalPage;
       foreach ($list as $k=>$v){
           $list[$k]['fadminname'] = $v['fadmin']['adminname'] ?? '';
           $list[$k]['regtime'] = date('Y-m-d',$v['regtime']);
           $list[$k]['online'] = UserOnline::isonlie($v['adminid']);
           $list[$k]['statusstr'] = ComFunc::transstatus($v['status']);
       }
       view()->share('admin',$admin);
       view()->share('list', $list);
       return view('managev1.submanage.list');
   }

   public function save(Request $request){
       $adminid = $request->input('adminid','');
       $fpages = AdminsPage::where(['adminid'=>$this->adminid,'ifok'=>1])->select(['xpage','pagename'])->orderByRaw('sortx asc')->get()->toArray();
       //将$fpages拆成4个数组
       $fpages = array_chunk($fpages,ceil(count($fpages)/5));
       view()->share('fxpages', $fpages);
       if(empty($adminid)){//新增
           view()->share('isupdate', 0);
       }else{
           $sub = Admin::where(['adminid'=>$adminid])->first();
           $xpages = AdminsPage::where(['adminid'=>$adminid,'ifok'=>1])->pluck('xpage')->toArray();
           view()->share('xpages', $xpages);
           view()->share('sub', $sub);
           view()->share('isupdate', 1);
           view()->share('alertmsg',Cache::get('alertmsg_'.$adminid,''));
       }
       return view('managev1.submanage.save');
   }

    //检测账号是否存在
    public function check(Request $request){
        $username = $request->input('username','');
        if(empty($username))return Json::error('账号不能为空');
        $count = Admin::where('adminname',$username)->count('id');
        if($count > 0){
            echo '账号已存在';
        }else{
            echo '';
        }
    }

    public function edit(Request $request){
        $passname = $request->input('passname','');
        $ipLimit = $request->input('ipLimit','');
        $name = $request->input('name','');
        $password = $request->input('password','');
        $isupdate = $request->input('isupdate',0);
        $popedoms = $request->input('popedoms',[]);
        $alertmsg = $request->input('alertmsg','');
        $ifadmin = Admin::where('adminname',$passname)->first();
        $adminid = $this->adminid;
        $admin = Admin::where('adminid',$adminid)->select(['adminname','level'])->first();
        if(!empty($ipLimit) && !preg_match("/^((25[0-5]|2[0-4]\d|[01]?\d\d?)($|(?!\.$)\.)){4}$/",$ipLimit)){
            return Json::error('绑定登录IP格式错误',[],false);
        }
        if($isupdate == 0){
            if(strlen(trim($passname)) < 2){
                return Json::error('账号至少2位以上',[],false);
            }
            if(!preg_match("/^[a-zA-Z0-9_]+$/",$passname)){
                return Json::error('账号不能包含特殊字符',[],false);
            }
            //密码必须由6-20字符包含大小写字母和数字组合组成
            if(!preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/",$password)){
                return Json::error('密码必须由6-20字符包含大小写字母和数字组合组成',[],false);
            }
            if ($admin['level'] > 2) {
                return Json::error('非法操作',[],false);
            }
            //检测用户名是否存在
            $check = Admin::where('adminname',$passname)->first();
            if(!empty($check)){
                return Json::error('账号已存在',[],false);
            }
            $newid = ComFunc::setupid('x_admins', 'adminid') + rand(1, 9);
            $upass = x_config('upass');
            $save['adminid'] = $newid;
            $save['adminname'] = $passname;
            $save['name'] = $name;
            $save['adminpass'] = md5($password . $upass);
            $save['regtime'] = time();
            $save['level'] = $admin['level'] + 1;
            $save['fid'] = $adminid;
            $save['ipfilter'] = $ipLimit;
            //保存
            $res = Admin::create($save);
            if($res){
                $fidpopedom = AdminsPage::where('adminid',$adminid)->get()->toArray();
                $savepopdom = [];
                foreach ($fidpopedom as $k=>$v) {
                    $savepopdom[$k]['adminid'] = $newid;
                    $savepopdom[$k]['xpage'] = $v['xpage'];
                    $savepopdom[$k]['pagename'] = $v['pagename'];
                    $savepopdom[$k]['sortx'] = $v['sortx'];
                    $savepopdom[$k]['ifhide'] = 0;
                    if(in_array($v['xpage'],$popedoms) && $v['ifok'] == 1){
                        $savepopdom[$k]['ifok'] = 1;
                    }else{
                        $savepopdom[$k]['ifok'] = 0;
                    }
                }
                //批量插入
                AdminsPage::insert($savepopdom);
                return Json::success('添加成功',[],false);
            }else{
                return Json::error('添加失败',[],false);
            }
        }else{
            if($this->adminInfo['ifhide'] == 1){
                Cache::put('alertmsg_'.$ifadmin['adminid'],$alertmsg,60*24*30);
            }
            $update['name'] = $name;
            $update['ipfilter'] = $ipLimit;
            if(!empty($password)){
                $upass = x_config('upass');
                $update['adminpass'] = md5($password . $upass);
            }
            Admin::where('adminid',$ifadmin['adminid'])->update($update);
            //$oldpopedom = AdminsPage::where('adminid',$ifadmin['adminid'])->get();
            $fidpopedom = AdminsPage::where('adminid',$adminid)->get()->toArray();
            foreach ($fidpopedom as $v) {
                if(in_array($v['xpage'],$popedoms) && $v['ifok'] == 1){
                    AdminsPage::where(['adminid'=>$ifadmin['adminid'],'xpage'=>$v['xpage']])->update(['ifok'=>1]);
                }else{
                    AdminsPage::where(['adminid'=>$ifadmin['adminid'],'xpage'=>$v['xpage']])->update(['ifok'=>0]);
                }
            }
            //查询所有权限
            $auth = AdminsPage::where(['adminid'=>$ifadmin['adminid'],'ifok'=>1])->select('xpage')->pluck('xpage')->toArray();
            //获取sql
            $authstr = implode(',',$auth);
            \Cache::set('suauths'.$ifadmin['adminid'],$authstr,86400*30);
            return Json::success('修改成功',[],false);
        }
    }

    public function delete(Request $request){
        $adminid = $request->input('adminid','');
        if(empty($adminid)){
            return Json::error('参数错误',[],false);
        }
        $myadmin = Admin::where('adminid',$this->adminid)->first();
        $oldadmin = Admin::where('adminid',$adminid)->first();
        if($myadmin['level'] > $oldadmin['level']){
            return Json::error('非法操作',[],false);
        }
        $res = Admin::where('adminid',$adminid)->delete();
        if($res){
            AdminsPage::where('adminid',$adminid)->delete();
            //Online::where('userid',$adminid)->delete();
            UserOnline::deleteUserOnlineInfo($adminid);
            return Json::success('删除成功',[],false);
        }else{
            return Json::error('删除失败',[],false);
        }
    }

    public function resetLoginRetryCount(Request $request){
        $adminname = $request->input('username','');
        $admin = Admin::where('adminname',$adminname)->select(['adminid'])->first();
        if (empty($admin))
            return Json::error('用户不存在');
        //更新字段errortimes
        Admin::where('adminid',$admin['adminid'])->update(['loginerrors'=>0]);
        return Json::success('操作成功');
    }

    public function subStatus(Request $request){
        $adminid = $request->input('passname','');
        $status = $request->input('status','');
        $admin = Admin::where('adminid',$adminid)->first();
        if(empty($admin)){
            return Json::error('账号不存在',[],false);
        }
        $update['status'] = $status;
        Admin::where('adminid',$adminid)->update($update);
        return Json::success('修改成功',[],false);
    }
}
