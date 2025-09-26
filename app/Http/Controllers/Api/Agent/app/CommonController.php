<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\Models\Game\Online;
use App\Models\Game\User;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Added this import for DB facade

class CommonController
{
    public function getGameListAll(Request $request){
        $ruid = $request->ruid;
        $model = SGUtils::ruidGameModelByRoom($ruid);
        $gamelist = $model->select(['userpatt.gid','gname'])->orderBy('userpatt.xsort')->get();
        return AppJson::success('ok',['list'=>$gamelist]);
    }

    //获取在线会员列表
    public function getOnlineUserList(Request $request){
        $ruid = $request->ruid;
        
        // 使用纯SQL查询Online表关联User表
        $sql = "
            SELECT u.userid, u.username, u.name, u.kmoney
            FROM x_online o
            INNER JOIN x_user u ON o.userid = u.userid AND o.ruid = u.ruid
            WHERE o.ruid = ? AND o.online = 1 AND o.type = 4 AND u.ifson = 0
            ORDER BY u.userid DESC
        ";
        
        $userList = DB::select($sql, [$ruid]);
        
        // 处理金额格式
        foreach($userList as $key=>$value){
            $userList[$key]['kmoney'] = ComFunc::pr2($value['kmoney']);
        }
        
        return AppJson::success('ok',$userList);
    }
}