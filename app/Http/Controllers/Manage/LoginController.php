<?php

namespace App\Http\Controllers\Manage;


use App\Events\UserLogin;
use App\Models\Game\Admin;
use App\Models\Game\AdminsPage;
use App\Models\Game\Gamecs;
use App\Models\Game\Online;
use App\ort\common\Constants;
use App\ort\common\Json;
use App\ort\glob\client;
use App\ort\sgwin\SGUtils;
use App\ort\sgwin\UserOnline;
use Earnp\GoogleAuthenticator\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\SwooleRedirectHelper;

class LoginController
{
    public function code(Request $request){
        $path = base_path();
        $list = scandir($path."/public/sgcode");
        $cl = count($list);
        request()->headers->set('content-type', 'image/jpeg');
        $code = $list[rand(2,$cl-1)];
        Session::put('login_check_number',substr($code,0,4));
        $vc = Session::get('login_check_number');
        while (1){
            if(is_numeric($vc)){
                $fullPath = $path."/public/sgcode/".$code;
                return response()->stream(function () use ($fullPath) {
                    echo file_get_contents($fullPath);
                }, 200, ['Content-Type' => 'image/jpeg']);
            }
        }
    }

    public function login(Request $request){
        if ($request->isMethod('post')) {
            $username = $request->input('account');
            $password = $request->input('password');
            $code = $request->input('code');
            $facode = $request->input('facode');
            /*if(empty($username)){
                return back()->with('opMsg','请输入登录账号');
            }
            if(empty($password)){
                return back()->with('opMsg','请输入登录密码');
            }*/
            //校验验证码
            $mcode = Session::get('login_check_number');
            if($mcode != $code){
                return back()->with('opMsg','验证码错误，请重新输入。');
                //return redirect('login?e=3')->with('opMsg','验证码错误，请重新输入。');
            }
            $admin = Admin::where(['adminname'=>$username])->first();
            $client = new client();
            $user_agent = $request->header('user-agent');
            $server_addr = $request->server('SERVER_ADDR');
            $os = $client->getbrowser($user_agent) . '  ' . $client->getos($user_agent);
            $ip = $request->getClientIp();
            //密码校验
            $pass = md5($password. x_config('upass'));
            if(empty($admin) || $pass != $admin['adminpass']){
                event(new UserLogin(['log','admin',0,$username,$password,$server_addr,$os,$ip,3,0]));//日志记录
                if($admin && $admin['loginerrors'] < 5){
                    Admin::where('id',$admin['id'])->increment('loginerrors');
                }
                //return back()->with('opMsg','账号或密码错误。');
                return redirect('login?e=4')->with('opMsg','账号或密码错误。');
            }
            if(!empty($admin['ipcustom'])){
                $ip = $admin['ipcustom'];
            }
            if($admin['loginerrors'] >= 5){
                return back()->with('opMsg','登录密码错误次数过多，禁止登录，请联系上级！');
            }
            if($admin['google_open'] == 1){
                $checkResult = GoogleAuthenticator::CheckCode($admin['google_secret'], $facode);
                if(!$checkResult){
                    return back()->with('opMsg','二次验证失败');
                }
            }
            //更新并使用Db:raw()使logintimes字段加1
            Admin::where('id',$admin['id'])->update(['logintimes'=>\DB::raw('logintimes+1'),'lastloginip'=>$ip,'lastlogintime'=>time(),'loginerrors'=>0]);
            $passcode = (getmicrotime() * 100000000) . time();
            /*$oldonline = UserOnline::getUserOnlineInfo($admin['adminid']);
            if(!empty($oldonline) && isset($oldonline['loginipid'])){
                \App\Models\Game\UserLogin::where('id',$oldonline['loginipid'])->update(['logout_time'=>time()]);
            }*/
            //Online::where(['xtype'=>0,'userid'=>$admin['adminid']])->delete();
            UserOnline::deleteUserOnlineInfo($admin['adminid']);
            $online_data['page'] = 'welcome';
            $online_data['xtype'] = 0;
            $online_data['passcode'] = $passcode;
            $online_data['userid'] = $admin['adminid'];
            $online_data['logintime'] = time();
            $online_data['savetime'] = time();
            $online_data['ip'] = $ip;
            $online_data['server'] = $server_addr;
            $online_data['os'] = $os;
            //Online::create($online_data);
            UserOnline::setUserOnlineInfo($online_data);
            event(new UserLogin(['log','admin',1,$username,$password,$server_addr,$os,$ip,3,0]));//日志记录
            Session::put('adminid',$admin['adminid']);
            //查询默认游戏
            if(empty($admin['gid'])){
                $gid = Gamecs::where(['userid'=>Constants::$SUID,'ifok'=>1])->orderBy('xsort')->value('gid');
                Session::put('gid',$gid);
            }else{
                Session::put('gid',$admin['gid']);
            }
            Session::put('passcode',$passcode);
            Session::put('adminInfo',$admin);
            //查询所有权限
            $auth = AdminsPage::where(['adminid'=>$admin['adminid'],'ifok'=>1])->select('xpage')->pluck('xpage')->toArray();
            //获取sql
            $authstr = implode(',',$auth);
            \Cache::set('suauths'.$admin['adminid'],$authstr,86400*30);
            
            // 使用Swoole环境下的安全重定向助手函数
            return swoole_redirect('/agent/index');
        }
        $e = $request->input('e','');
        if(!empty($e) && $e == 3){
            Session::flash('opMsg','验证码错误，请重新输入。');
        }elseif (!empty($e) && $e == 4){
            Session::flash('opMsg','账号或密码错误。');
        }
        return view('managev1.login');
    }
}
