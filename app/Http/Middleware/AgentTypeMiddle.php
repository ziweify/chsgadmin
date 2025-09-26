<?php

namespace App\Http\Middleware;

use App\Models\Game\Userreg;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\UserOnline;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class AgentTypeMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $utype = $request->utype;
        if($utype != 1){
            return AppJson::error('用户类型错误',1003);
        }
        return $next($request);
    }
}
