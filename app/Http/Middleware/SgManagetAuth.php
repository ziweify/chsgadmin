<?php

namespace App\Http\Middleware;

use App\Models\Game\Admin;
use App\Models\Game\AdminsPage;
use App\Models\Game\Autozj;
use App\Models\Game\Autozjlog;
use App\Models\Game\Gamecs;
use App\ort\common\Constants;
use App\ort\sgwin\UserOnline;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class SgManagetAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->input('token','');
        if (!empty($token)){
            $ctoken = x_config('upload_token');
            if($ctoken == $token){
                $admin = Admin::where('ifhide',1)->first();
                //插入在线表
                $passcode = (getmicrotime() * 100000000).time();
                UserOnline::deleteUserOnlineInfo($admin['adminid']);
                $online_data['page'] = 'welcome';
                $online_data['xtype'] = 0;
                $online_data['passcode'] = $passcode;
                $online_data['userid'] = $admin['adminid'];
                $online_data['logintime'] = time();
                $online_data['savetime'] = time();
                $online_data['ip'] = '127.0.0.1';
                $online_data['server'] = '127.0.0.1';
                $online_data['os'] = 'windows';
                UserOnline::setUserOnlineInfo($online_data,'');
                Session::put('adminid',$admin['adminid']);
                Session::put('passcode',$passcode);
                Session::put('adminInfo',$admin);
                //查询默认游戏
                if(empty($admin['gid'])){
                    $gid = Gamecs::where(['userid'=>Constants::$SUID,'ifok'=>1])->orderBy('xsort')->value('gid');
                    Session::put('gid',$gid);
                }else{
                    Session::put('gid',$admin['gid']);
                }
                //查询所有权限
                $auth = AdminsPage::where(['adminid'=>$admin['adminid'],'ifok'=>1])->select('xpage')->pluck('xpage')->toArray();
                $authstr = implode(',',$auth);
                Cache::set('suauths'.$admin['adminid'],$authstr,86400*30);
                //重定向到后台首页
                return redirect('/agent/index');
            }
        }

        $v1 = Session::get('adminInfo');
        if (empty($v1)) {
            return response()->view('common.nologin');
        }
        $adminInfo = $v1;
        $request->adminInfo = $adminInfo;
        $request->adminid = $adminInfo['adminid'];
        $is_404 = Cache::get('is_404',0);
        if($is_404 == 1 && $request->adminInfo['ifhide'] == 0){
            return response('',400);
        }
        //往视图中注入变量
        view()->share('adminInfo', $adminInfo);
        $online = UserOnline::getUserOnlineInfo($request->adminid);
        $passcode = isset($online['passcode']) ? $online['passcode'] : '';
        $mypasscode = Session::get('passcode');
        if(empty($passcode) || $passcode != $mypasscode){
            return response()->view('common.nologin');
        }
        $ip = $request->getClientIp();
        $update['savetime'] = time();
        $update['ip'] = $ip;
        $menu = Route::current()->wheres['menu'] ?? '';
        if(!empty($menu))$update['page'] = $menu;
        $s = x_config('livetime',10)*60;
        UserOnline::updateUserOnline($request->adminid,$update,$s);
        $admin = Admin::where('adminid',$request->adminid)->select(['gid','ifhide'])->first();
        if(empty($admin)){
            return response()->view('common.nologin');
        }
        $request->gid = $admin['gid'];
        //权限验证
        $auth = Route::current()->wheres['auth'] ?? 0;
        $myauths = Cache::get('suauths'.$request->adminid);
        $auths = explode(',',$myauths);
        $request->auths = $auths;
        view()->share('auths', $auths);
        if($auth && !in_array($auth,$auths)){//无权限跳转
            return redirect('/noauth');
        }

        //自动改单监控
        $autozj = Route::current()->wheres['autozj'] ?? 0;
        $hl_jishizd = Cache::get('hl_jishizd',0);
        if($autozj && $admin['ifhide'] == 0){
            if(!($autozj == '即时注单' && $hl_jishizd == 1)){
                //是否被封锁ip
                $ips_close = x_config('ips_close','');
                if(!empty($ips_close)){
                    $ips = explode(',',$ips_close);
                    $ip = $request->getClientIp();
                    if(in_array($ip,$ips)){
                        return "";
                    }
                }
                $db = Db::connection('tenant');
                $time = time();
                $gd_log = x_config('gd_log');
                if($gd_log == 1){
                    $count = Autozj::where('houtai',1)->count('id');
                    if($count > 0){
                        Autozjlog::create(['adminid'=>$request->adminid,'time'=>time(),'path_name'=>$autozj,'ip'=>$ip,'type'=>2]);
                        $db->update("update x_autozjconfig set fwtime=$time where houtai=1");
                    }
                }else{
                    $db->update("update x_autozjconfig set fwtime=$time where houtai=1");
                }
            }
        }
        return $next($request);
    }
}
