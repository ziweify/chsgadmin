<?php

namespace App\Http\Middleware;

use App\Models\Game\Userreg;
use App\ort\sgwin\Json;
use Closure;
use Illuminate\Http\Request;

class RoomIdMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $ruid = $request->ruid;
        if(empty($ruid)){
            return Json::error('房间号未授权',['code'=>100001]);
        }
        return $next($request);
    }
}
