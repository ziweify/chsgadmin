<?php

namespace App\Http\Middleware;

use App\Models\Game\Autozj;
use App\Models\Game\Autozjlog;
use App\Models\Game\Game;
use App\Models\Game\User;
use App\ort\sgwin\SGUtils;
use App\ort\sgwin\UserOnline;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class SgAgentAuth
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
        //平台是否运行
        $ifopen = x_config('ifopen');
        if ($ifopen == 0) {
            return response('',404);
        }

        $is_404 = Cache::get('is_404',0);
        if($is_404 == 1){
            return response('',400);
        }

        $v1 = Session::get('agentInfo');
        $v2 = Session::get('auid');
        if (empty($v1) || empty($v2)){
            //return response()->view('common.nologin');
            return redirect('/login');
        }
        $request->agentInfo = $v1;
        $request->uid = $v1['userid'];
        $request->auid = $v2;
        $request->atype = Session::get('atype');
        $menu = Route::current()->wheres['menu'] ?? '';
        //$ingore = Route::current()->wheres['ingore'] ?? '';
        view()->share('agentInfo',$v1);
        view()->share('rkey', x_config('rkey'));
        $user = User::where('userid',$request->uid)->select(['gid','ifson','layer','ipcustom'])->first();
        if(empty($user)){
            //return response()->view('common.nologin');
            return redirect('/login');
        }
        $online = UserOnline::getUserOnlineInfo($request->uid);
        $passcode = isset($online['passcode']) ? $online['passcode'] : '';
        $mypasscode = Session::get('passcode');
        if(empty($passcode) || $passcode != $mypasscode){
            //return response()->view('common.nologin');
            return redirect('/login');
        }
        if(!empty($user['ipcustom'])){
            $ip = $user['ipcustom'];
        }else{
            $ip = $request->getClientIp();
        }
        /*if(empty($ingore)){
            $update['savetime'] = time();
        }*/
        $update['savetime'] = time();
        $update['ip'] = $ip;
        if(!empty($menu))$update['page'] = $menu;
        $s = x_config('livetime',10)*60;
        UserOnline::updateUserOnline($request->uid,$update,$s);
        //权限验证
        $params = Route::current()->wheres;
        $auth = $params['auth'] ?? 0;
        $myauths = Cache::get('auths'.$request->uid);
        $auths = explode(',',$myauths);
        $request->auths = $auths;
        view()->share('auths',$auths);
        if($auth && !in_array($auth,$auths)){//无权限跳转
            return redirect('/noauth');
        }

        //自动改单监控
        $autozj = $params['autozj'] ?? 0;
        if($autozj){
            $request->autozj = $autozj;
            $request->zjfid = 'uid'.$user['layer'];
            $request->zjip = $ip;
            if($autozj == '报表-分类报表' || $autozj == '对外补货->注单列表') {
                SGUtils::autozjhandleragent($request->zjfid,$request->auid,$request->uid,$autozj,'',$ip,[],3);
            }
            /*$upuid = 'uid'.$user['layer'];
            $db = Db::connection('tenant');
            $time = time();
            $gd_log = x_config('gd_log');//是否开启改单日志
            if($gd_log == 1){
                $count = Autozj::where($upuid,$request->auid)->count('id');
                if($count > 0){
                    $lottery = $request->input('lottery','');
                    if(!empty($lottery)){
                        $game = Game::where('lottery',$lottery)->select(['gid','gname'])->first();
                        if(!empty($game)){
                            $autozj .= '-'.$game['gname'];
                        }
                    }

                    Autozjlog::create(['userid'=>$request->auid,'ziuserid'=>$request->uid,'time'=>time(),'path_name'=>$autozj,'ip'=>$ip,'type'=>1]);
                    $db->update("update x_autozjconfig set fwtime=$time where $upuid=".$request->auid);
                }
            }else{
                $db->update("update x_autozjconfig set fwtime=$time where $upuid=".$request->auid);
            }*/
        }
        return $next($request);
    }
}
