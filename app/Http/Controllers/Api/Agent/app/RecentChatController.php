<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\ComServices\WebsocketConstants;
use App\Models\Game\Chatmsg;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use App\ort\sgwin\AppJson;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RecentChatController
{
    public function getRecentChatUserList(Request $request){
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',20);
        $username = $request->input('username','');
        $sort = $request->input('sort','lastOnlineTime');
        $ruid = $request->ruid;

        // 构建WHERE条件
        $whereConditions = ["a.ruid = ?", "a.recentChat = 1"];
        $params = [$ruid];
        
        if(!empty($username)){
            $whereConditions[] = "(a.username LIKE ? OR a.name LIKE ?)";
            $params[] = '%'.$username.'%';
            $params[] = '%'.$username.'%';
        }
        
        $whereClause = implode(' AND ', $whereConditions);
        
        // 处理排序字段
        $orderBy = 'a.lastOnlineTime DESC';
        if(!empty($sort)){
            if($sort == 'online' || $sort == 'lastOnlineTime'){
                $orderBy = 'o.online DESC, a.lastOnlineTime DESC';
            } else {
                $orderBy = 'a.'.$sort.' DESC';
            }
        }
        
        // 计算偏移量
        $offset = ($page - 1) * $pageSize;
        
        // 主查询SQL - 关联online表
        $sql = "
            SELECT a.userid, a.username, a.kmoney, a.name, b.avatar,
                   COALESCE(o.online, 0) as online
            FROM x_user a 
            INNER JOIN x_userreg b ON a.userid = b.userid
            LEFT JOIN x_online o ON a.userid = o.userid AND o.ruid = ?
            WHERE {$whereClause}
            ORDER BY {$orderBy}
            LIMIT ? OFFSET ?
        ";
        
        // 添加参数
        $params[] = $ruid; // 用于JOIN的ruid
        $params[] = $pageSize;
        $params[] = $offset;
        
        // 执行查询
        $list = DB::select($sql, $params);
        
        // 获取总数
        $countSql = "
            SELECT COUNT(*) as total 
            FROM x_user a 
            INNER JOIN x_userreg b ON a.userid = b.userid
            WHERE {$whereClause}
        ";
        $countResult = DB::select($countSql, array_slice($params, 0, -3));
        $totalCount = !empty($countResult) ? $countResult[0]->total : 0;
        
        $key = WebsocketConstants::$NotReadMsgAgentPre.":".$ruid;
        foreach ($list as $k=>$item){
            $list[$k]['kmoney'] = ComFunc::pr2($item['kmoney']);
            $d = Redis::hget($key,$item['userid']);
            if(!empty($d)){
                $list[$k]['unreadCount'] = intval($d);
            }else{
                $list[$k]['unreadCount'] = 0;
            }
        }
        
        $totalPage = ceil($totalCount / $pageSize);
        $result = [
            'list' => $list,
            'total' => $totalCount,
            'totalPage' => $totalPage,
            'currentPage' => $page,
            'pageSize' => $pageSize
        ];
        
        return AppJson::success('ok',$result);
    }

    public function deleteRecentChat(Request $request){
        $userid = $request->input('userid','');
        if(empty($userid)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $user = User::where(['ruid'=>$ruid,'userid'=>$userid])->count("id");
        if (empty($user)){
            return AppJson::error('用户不存在');
        }
        Chatmsg::where(['type'=>'customer','ruid'=>$ruid,'msgGroupId'=>$userid])->delete();
        User::where(['ruid'=>$ruid,'userid'=>$userid])->update(['recentChat'=>0]);
        $chatListKey = WebsocketConstants::$CustomerChatListKeyPre.':'.$ruid.':'.$userid;
        Redis::del($chatListKey);
        return AppJson::success('ok','操作成功');
    }
}
