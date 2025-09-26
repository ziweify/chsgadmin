<?php

namespace App\Http\Middleware;

use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\UserOnline;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class ApiAgentMid
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
            // 使用服务器的密钥来解析JWT
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $userInfo = (array)$decoded->userinfo;
        }catch (\Exception $e) {
            //Log::info($e->getMessage());
            return AppJson::error('验证Token已过期，请重新登录',1003);
        }
        $request->userInfo = $userInfo;
        $request->auid = $userInfo['auid'];
        $request->uid = $userInfo['userid'];
        $request->ifson = $userInfo['ifson'];
        $userroom = Userroom::where('userid',$request->uid)->select(['roomStatus','expiryDate'])->first();
        if(empty($userroom)){
            return AppJson::error('用户不存在',1003);
        }
        if($userroom['roomStatus'] == 0){
            return AppJson::error('房间已停用',1003);
        }
        //是否到期
        if(time() > $userroom['expiryDate']){
            return AppJson::error('房间已到期',1003);
        }
        return $next($request);
    }
}
