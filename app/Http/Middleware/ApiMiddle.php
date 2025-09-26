<?php

namespace App\Http\Middleware;

use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\UserOnline;
use App\Services\TokenService;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class ApiMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        //平台是否运行
        $pifopen = x_config('ifopen');
        if ($pifopen == 0) {
            return AppJson::error('平台维护中，请稍后再试',1003);
        }
        $token = $request->header('Authorization');
        //去掉Bearer
        $token = str_replace('Bearer ','',$token);
        try {
            $userInfo = TokenService::getUserInfo($token);
        }catch (\Exception $e) {
            Log::info($e->getMessage());
            return AppJson::error('token已过期，请重新登录',1003);
        }
        if(empty($userInfo)){
            return AppJson::error('token异常，请重新登录',1003);
        }
        $request->userInfo = $userInfo;
        $request->uid = $userInfo['userid'];
        $request->utype = $userInfo['type'];
        $request->ifson = $userInfo['ifson'];
        $userreg = Userreg::where('userid',$request->uid)->select(['status','ipcustom','ruid'])->first();
        if(empty($userreg)){
            return AppJson::error('用户不存在',1003);
        }
        if($userreg['status'] == 2){
            return AppJson::error('用户已被禁用',1003);
        }
        if($userInfo['type'] == 1){//房主
            $request->ruid = $userInfo['auid'];
        }else{
            $request->ruid = $userreg['ruid'];
            if($request->ruid > 0){
                $rstatus = User::where(['ruid'=>$userreg['ruid'],'userid'=>$userInfo['userid']])->value('room_status');
                if($rstatus == 0){
                    return AppJson::error('账号已停用，请联系客服',1003);
                }
            }
        }
        $request->userreg = $userreg;
        return $next($request);
    }
}
