<?php

namespace App\Lisenter;

use App\Events\UserLogin;
use App\ort\glob\IpUtils;
use App\ort\sgwin\UserOnline;

class UserLoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserLogin  $event
     * @return void
     */
    public function handle(UserLogin $event){
        [$type,$user_type,$ifok,$username,$password,$svip,$os,$ip,$logintype,$ruid] = $event->eloquent;
        if ($type == 'log') {//管理登录日志
            if($user_type == 'admin'){
                $xtype = 0;
            }elseif ($user_type == 'user'){
                $xtype = 2;
            }elseif ($user_type == 'agent'){
                $xtype = 1;
            }
            $save_data = [];
            $save_data['ruid'] = $ruid;
            $save_data['logintype'] = $logintype;
            $save_data['xtype'] = $xtype;
            $save_data['ip'] = isset($ip) ? $ip : request()->ip();
            $save_data['time'] = time();
            $save_data['ifok'] = $ifok;
            $save_data['username'] = $username;
            $save_data['userpass'] = $password;
            $save_data['server'] = $svip;
            $save_data['os'] = $os;
            $save_data['addr'] = IpUtils::getaddrbyip($save_data['ip']);
            \App\Models\Game\UserLogin::create($save_data);
        }
    }
}
