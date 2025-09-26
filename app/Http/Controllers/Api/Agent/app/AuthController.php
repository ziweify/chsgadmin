<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\ComServices\ComServices;
use App\Events\UserLogin;
use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\glob\client;
use App\ort\sgwin\AppJson;
use App\Services\TokenService;
use Earnp\GoogleAuthenticator\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController
{
    public function login(Request $request){
        $account = $request->input('account','');
        $password = $request->input('password','');
        $logintype = $request->input('logintype',0);
        $code = $request->input('code','');
        $key = $request->input('key','');
        $gcode = $request->input('gcode','');
        if(empty($password) || empty($account)){
            return AppJson::error('账号或密码错误');
        }
        $cacheCode = Cache::get($key);
        if($cacheCode != $code){
            return AppJson::error('验证码错误');
        }
        $userreg = Userreg::where(['username'=>$account,'type'=>1])->first();
        $client = new client();
        //获取浏览器HTTP_USER_AGENT
        $user_agent = $request->header('user-agent');
        $server_addr = $request->server('SERVER_ADDR');
        $os = $client->getbrowser($user_agent).' '.$client->getos($user_agent);
        $ip = request()->getClientIp();
        //密码校验
        $pass = md5($password.x_config('upass'));
        if(empty($userreg) || $pass != $userreg['userpass']){
            if($userreg && !empty($userreg['ipcustom'])){
                $ip = $userreg['ipcustom'];
            }
            event(new UserLogin(['log','agent',0,$account,$password,$server_addr,$os,$ip,$logintype,0]));
            Userreg::where('userid',$userreg['userid'])->increment('errortimes');
            return AppJson::error('账号或密码错误');
        }
        //判断是否开启谷歌口令
        if($userreg['google_open'] == 1){
            if($code && empty($gcode)){
                return AppJson::error('您已开启谷歌验证，请切换到谷歌验证');
            }
            if(empty($gcode)){
                return AppJson::error('请输入谷歌验证码');
            }
            //校验谷歌口令
            $checkResult = GoogleAuthenticator::CheckCode($userreg['google_secret'], $gcode);
            if (!$checkResult){
                return AppJson::error('谷歌验证码错误');
            }
        }
        if(!empty($userreg['ipcustom'])){
            $ip = $userreg['ipcustom'];
        }
        /*if($userreg['errortimes'] >= 15){
            return AppJson::error('登录密码错误次数过多，禁止登录，请联系上级！');
        }*/
        if($userreg['status'] == 2){
            return AppJson::error('账户已禁用');
        }
        if(!empty($userreg['ipfilter']) && $ip != $userreg['ipfilter']){
            return AppJson::error('登录ip与绑定ip不符');
        }
        if($userreg['ifson'] == 1){
            $passwordAttemptsAllowed = Userroom::where(['userid'=>$userreg['ruid']])->value('passwordAttemptsAllowed');
            if($userreg['errortimes'] >= $passwordAttemptsAllowed){
                return AppJson::error('登录密码错误次数过多，禁止登录，请联系上级！');
            }
        }
        $ruid = $userreg['userid'];
        if($userreg['ifson'] == 1){
            $ruid = $userreg['ruid'];
        }
        $userroom = Userroom::where(['userid'=>$ruid])->select(['expiryDate','roomStatus','roomAvatar','roomNickname'])->first();
        //房间是否到期，字段是expiryDate
        if ($userroom['expiryDate'] <= time()) {
            return AppJson::error('房间已到期，请联系客服');
        }
        if($userroom['roomStatus'] == 0){
            return AppJson::error('房间已禁用，请联系客服');
        }
        //更新用户信息
        $update = [];
        $update['lastloginip'] = $ip;
        $update['lastlogintime'] = time();
        $update['errortimes'] = 0;
        $update['logintimes'] = \DB::raw('logintimes+1');
        event(new UserLogin(['log','agent',1,$account,$password,$server_addr,$os,$ip,$logintype,$ruid,$userreg['userid']]));//日志记录
        //检测密码是否过期
        $time = time();$isModifyPwd = 0;
        $passtime = x_config('passtime');
        if(($time-$userreg['passtime'])/(60 * 60 * 24) >= $passtime && $passtime != 0) {
            $isModifyPwd = 1;
        }

        //查询所有权限
        /*if($user['ifson'] == 1) {
            $auth = UserPage::where(['userid'=>$user['userid'],'ifok'=>1])->pluck('xpage')->toArray();
        }else{
            $auth = UserPage::where('userid',Constants::$USERID)->pluck('xpage')->toArray();
        }
        $authstr = implode(',',$auth);
        Redis::setex('auths'.$user['userid'],86400,$authstr);*/
        $userInfo = [
            'auid' => $userreg['ifson'] == 0 ? $userreg['userid'] : $userreg['ruid'],
            'ruid' => $userreg['ifson'] == 0 ? $userreg['userid'] : $userreg['ruid'],
            'userid' => $userreg['userid'],
            'username' => $userreg['username'],
            'type' => $userreg['type'],
            'name' => $userroom['roomNickname'],
            'ifson' => $userreg['ifson'],
            'avatar' => $userroom['roomAvatar'],
        ];
        $extime = 1*24*3600;
        if(!empty($userreg['token'])){
            TokenService::deleteToken($userreg['token']);
        }
        $token = TokenService::createToken($userInfo, $extime);
        $update['token'] = $token;
        Userreg::where('userid',$userreg['userid'])->update($update);
        $result = [
            'token' => $token,
            'userInfo' => $userInfo,
            'expires_time' => time()+$extime,
            'isModifyPwd' => $isModifyPwd
        ];
        return AppJson::success('登陆成功',$result);
    }

}
