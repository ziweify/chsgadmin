<?php

namespace App\Http\Controllers\Manage;

use App\ort\common\Constants;
use Illuminate\Http\Request;

class ManageAuthController
{
    protected $adminInfo;
    protected $auths;

    //继承父类的构造函数,并注入request对象
    public function __construct(Request $request){
        $this->auths = $request->auths;
        $this->adminInfo = $request->adminInfo;
        $this->adminid = $request->adminid;
        $this->uid = Constants::$SUID;
        $this->gid = $request->gid;//保留用于老版可以访问
        view()->share('adminInfo',$this->adminInfo);
        view()->share('rkey', 0);
    }
}
