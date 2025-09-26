<?php

namespace App\Http\Controllers\Api\Member\app;

use App\ComServices\UserService;
use App\Events\UserLogin;
use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\ort\glob\client;
use App\ort\HttpUtils;
use App\ort\sgwin\AppJson;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController
{
    public function login(Request $request){
        $account = $request->input('account','');
        $password = $request->input('password','');
        $logintype = $request->input('logintype',0);
        $code = $request->input('code','');
        $key = $request->input('key','');
        if(empty($password) || empty($account)){
            return AppJson::error('账号或密码错误');
        }
        $cacheCode = Cache::get($key);
        if(empty($cacheCode) || $cacheCode != $code){
            return AppJson::error('验证码错误');
        }
        $user = Userreg::where(['username'=>$account,'type'=>0])->first();
        $client = new client();
        //获取浏览器HTTP_USER_AGENT
        $user_agent = $request->header('user-agent');
        $server_addr = $request->server('SERVER_ADDR');
        $os = $client->getbrowser($user_agent).' '.$client->getos($user_agent);
        $ip = request()->getClientIp();
        //密码校验
        $pass = md5($password.x_config('upass'));
        if(empty($user) || $pass != $user['userpass']){
            if($user && !empty($user['ipcustom'])){
                $ip = $user['ipcustom'];
            }
            event(new UserLogin(['log','user',0,$account,$password,$server_addr,$os,$ip,$logintype,0]));
            if($user && $user['errortimes'] < 5){
                Userreg::where('userid',$user['userid'])->increment('errortimes');
            }
            return AppJson::error('账号或密码错误');
        }
        if(!empty($user['ipcustom'])){
            $ip = $user['ipcustom'];
        }
        if($user['errortimes'] >= 15){
            return AppJson::error('登录密码错误次数过多，禁止登录，请联系上级！');
        }
        if($user['status'] == 2){
            return AppJson::error('账户已禁用');
        }
        if(!empty($user['ipfilter']) && $ip != $user['ipfilter']){
            return AppJson::error('登录ip与绑定ip不符');
        }
        //更新用户信息
        $update = [];
        $update['lastloginip'] = $ip;
        $update['lastlogintime'] = time();
        $update['errortimes'] = 0;
        //$update['online'] = 1;
        $update['logintimes'] = \DB::raw('logintimes+1');
        //Userreg::where('userid',$user['userid'])->update($update);
        //event(new UserLogin(['log','user',1,$account,$password,$server_addr,$os,$ip,$logintype]));//日志记录
        //检测密码是否过期
        /*$time = time();
        $passtime = x_config('passtime');
        if (($time - $user['passtime']) / (60 * 60 * 24) >= $passtime && $passtime != 0) {
            return redirect('/member/update_password');
        }*/
        $userInfo = [
            'ruid' => $user['ruid'],
            'userid' => $user['userid'],
            'username' => $user['username'],
            'type' => $user['type'],
            'name' => $user['name'],
            'ifson' => 1,
            'avatar' => $user['avatar'],
        ];
        $extime = 1*24*3600;
        if(!empty($user['token'])){
            TokenService::deleteToken($user['token']);
        }
        $token = TokenService::createToken($userInfo, $extime);
        $update['token'] = $token;
        Userreg::where('userid',$user['userid'])->update($update);
        $result = [
            'token' => $token,
            'userInfo' => $userInfo,
            'expires_time' => time()+$extime,
        ];
        return AppJson::success('登陆成功',$result);
    }

    public function register(Request $request){
        if(x_config('open_register') == 0){
            return AppJson::error('平台已关闭自助注册功能');
        }
        $account = $request->input('account','');
        $password = $request->input('password','');
        $name = $request->input('nickname','');
        $code = $request->input('code','');
        $key = $request->input('key','');
        $logintype = $request->input('logintype',0);

        //校验账号/^[a-zA-Z0-9]{6,16}$/
        if (!preg_match('/^[a-zA-Z0-9]{6,16}$/', $account)){
            return AppJson::error('登陆账号必须是6-16位数字和字母组合');
        }
        //校验密码/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}$/
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}$/', $password)){
            return AppJson::error('登陆密码必须包含大小写字母和数字，长度8-16位');
        }

        $param = [];
        $param['account'] = $account;
        $param['password'] = $password;
        $param['name'] = $name;
        $param['code'] = $code;
        $param['key'] = $key;
        $param['ishoutai'] = 0;
        $param['isapp'] = 1;
        $param['mduserid'] = 0;
        $param['adminid'] = 0;
        $param['commission'] = 0;
        $param['roomid'] = 0;
        $param['ruid'] = 0;
        $param['type'] = 4;
        $res = (new UserService())->saveuser($param);
        if($res['code'] == 0) {
            return AppJson::error($res['msg']);
        }else{
            $userid = $res['userid'];
            //注册成功进行登录
            $client = new client();
            //获取浏览器HTTP_USER_AGENT
            $user_agent = $request->header('user-agent');
            $server_addr = $request->server('SERVER_ADDR');
            $os = $client->getbrowser($user_agent).' '.$client->getos($user_agent);
            $ip = request()->getClientIp();
            $update = [];
            $update['lastloginip'] = $ip;
            $update['lastlogintime'] = time();
            $update['errortimes'] = 0;
            //$update['online'] = 1;
            $update['logintimes'] = \DB::raw('logintimes+1');
            Userreg::where('userid',$userid)->update($update);
            //记录日志
            event(new UserLogin(['log','user',1,$account,$password,$server_addr,$os,$ip,$logintype,0]));//日志记录
            //生成token
            $user = Userreg::where('userid',$userid)->select(['username','name','avatar','type','ifson'])->first();
            $newuser = new User();
            $newuser->userid = $userid;
            $newuser->username = $user['username'];
            $newuser->type = $user['type'];
            $newuser->name = $user['name'];
            $newuser->ifson = $user['ifson'];//
            $token = JWTAuth::fromUser($newuser);
            $newuser['avatar'] = $user['avatar'];
            $result = [
                'token' => $token,
                'userInfo' => $newuser,
                'expires_time' => time()+JWTAuth::factory()->getTTL() * 60,
            ];
            return AppJson::success('注册成功',$result);
        }
    }

    public function downloadAllImage(){
        //请求url获取图片存储到public/avatar目录下
        $path = base_path();
        $destinationPath = $path.'/public/avatar/';
        for($i = 1;$i <= 2;$i++){
            // 发送 HTTP 请求获取图片内容
            $imageUrl = "https://image.mingjue8.vip/default/avatar/{$i}.jpg";
            //echo $imageUrl;
            $res = HttpUtils::curl('GET',false,'',$imageUrl,[],[],false,true,[],0);
            echo $res;
            // 将图片内容保存到指定目录
            file_put_contents($destinationPath.$i.'.jpg', $res);
        }
    }
}
