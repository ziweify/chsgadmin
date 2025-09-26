<?php

namespace App\Http\Controllers\Api\Agent\app;

use App\ComServices\ComServices;
use App\Models\Game\Game;
use App\Models\Game\Link;
use App\Models\Game\MoneyLog;
use App\Models\Game\Online;
use App\Models\Game\OutbetSite;
use App\Models\Game\Roomhistory;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\cachemodel\CommonCache;
use App\ort\common\ComFunc;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\SGUtils;
use Earnp\GoogleAuthenticator\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MangeCenterController
{

    public function centerInfo(Request $request){
        $ruid = $request->ruid;
        $uid = $request->uid;
        $db = Db::connection();
        $res = $db->select("SELECT SUM(kmoney) as kmoney,SUM(sy) as sy,SUM(jetotal) as jetotal FROM x_user WHERE ruid = {$ruid};");
        $result['balance'] = ComFunc::pr2($res[0]['kmoney']);//余额
        $result['totalMoney'] = ComFunc::pr2($res[0]['jetotal']);//今日流水
        $result['backWater'] = 0;//回水
        $result['sy'] = ComFunc::pr2($res[0]['sy']*-1);//输赢
        $result['totalSy'] = ComFunc::pr2($result['sy']-$result['backWater']);;//总输赢
        $result['username'] = Userreg::where('userid',$uid)->value('username');
        //百胜币余额
        $result['bsb_coin'] = User::where(['ruid'=>$ruid,'userid'=>$uid])->value('bsb_coin');
        return AppJson::success('ok',$result);
    }

    /**
     * 获取用户列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserList(Request $request){
        $username = $request->input('username','');
        $zero = $request->input('zero',1);
        $sort = $request->input('sort','id');
        $room_status = $request->input('room_status',-1);
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',10);
        $ruid = $request->ruid;
        
        // 构建WHERE条件
        $whereConditions = ["u.ruid = ?", "u.ifson = 0", "u.userid != ?"];
        $params = [$ruid, $ruid];
        
        if(!empty($username)){
            $whereConditions[] = "u.username LIKE ?";
            $params[] = '%'.$username.'%';
        }
        
        if($zero == 0){
            $whereConditions[] = "u.kmoney > 0";
        }
        
        if($room_status != -1){
            $whereConditions[] = "u.room_status = ?";
            $params[] = $room_status;
        }
        
        $whereClause = implode(' AND ', $whereConditions);
        
        // 处理排序字段
        $orderBy = 'u.userid DESC';
        if(!empty($sort)){
            if($sort == 'online'){
                $orderBy = 'o.online DESC, u.userid DESC';
            } else {
                $orderBy = 'u.'.$sort.' DESC';
            }
        }
        
        // 计算偏移量
        $offset = ($page - 1) * $pageSize;
        
        // 主查询SQL
        $sql = "
            SELECT u.userid, u.username, u.name, u.kmoney, u.room_status, u.is_exclusive,
                   COALESCE(o.online, 0) as online, u.ignore_outbet
            FROM x_user u
            LEFT JOIN x_online o ON u.userid = o.userid AND o.ruid = ?
            WHERE {$whereClause}
            ORDER BY {$orderBy}
            LIMIT ? OFFSET ?
        ";
        
        // 添加LIMIT和OFFSET参数
        $params[] = $ruid; // 用于JOIN的ruid
        $params[] = $pageSize;
        $params[] = $offset;
        
        // 执行查询
        $list = DB::select($sql, $params);
        
        // 获取总数
        $countSql = "
            SELECT COUNT(*) as total 
            FROM x_user u 
            WHERE {$whereClause}
        ";
        $countResult = DB::select($countSql, array_slice($params, 0, -3));
        $totalCount = !empty($countResult) ? $countResult[0]['total'] : 0;
        
        // 处理金额格式
        foreach ($list as &$item){
            $item['kmoney'] = ComFunc::pr2($item['kmoney']);
        }
        
        $totalPage = ceil($totalCount / $pageSize);
        $result = [];
        $result['total'] = $totalCount;
        $result['totalPage'] = $totalPage;
        $result['currentPage'] = $page;
        $result['pageSize'] = $pageSize;
        $result['records'] = $list;
        return AppJson::success('ok',$result);
    }

    /**
     * 使用原生SQL JOIN查询用户和在线状态（备选方案）
     */
    public function getUserListWithOnlineStatus(Request $request)
    {
        $ruid = $request->ruid;
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 20);
        
        // 使用原生SQL JOIN查询
        $offset = ($page - 1) * $pageSize;
        
        $sql = "
            SELECT u.userid, u.username, u.name, u.kmoney, u.room_status, u.is_exclusive,
                   COALESCE(o.online, 0) as online
            FROM x_user u
            LEFT JOIN x_online o ON u.userid = o.userid AND o.ruid = ?
            WHERE u.ruid = ?
            ORDER BY u.userid DESC
            LIMIT ? OFFSET ?
        ";
        
        $list = DB::select($sql, [$ruid, $ruid, $pageSize, $offset]);
        
        // 获取总数
        $countSql = "SELECT COUNT(*) as total FROM x_user WHERE ruid = ?";
        $countResult = DB::select($countSql, [$ruid]);
        $totalCount = !empty($countResult) ? $countResult[0]->total : 0;
        
        // 处理金额格式
        foreach ($list as &$item) {
            $item->kmoney = ComFunc::pr2($item->kmoney);
        }
        
        $totalPage = ceil($totalCount / $pageSize);
        $result = [
            'total' => $totalCount,
            'totalPage' => $totalPage,
            'currentPage' => $page,
            'pageSize' => $pageSize,
            'records' => $list
        ];
        
        return AppJson::success('ok', $result);
    }

    /**
     * 使用查询构建器JOIN查询用户和在线状态（第三种备选方案）
     */
    public function getUserListWithQueryBuilder(Request $request)
    {
        $ruid = $request->ruid;
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 20);
        
        // 使用查询构建器JOIN查询
        $query = DB::table('x_user as u')
            ->leftJoin('x_online as o', function($join) use ($ruid) {
                $join->on('u.userid', '=', 'o.userid')
                     ->where('o.ruid', '=', $ruid);
            })
            ->select([
                'u.userid', 'u.username', 'u.name', 'u.kmoney', 
                'u.room_status', 'u.is_exclusive',
                DB::raw('COALESCE(o.online, 0) as online')
            ])
            ->where('u.ruid', $ruid)
            ->orderBy('u.userid', 'desc');
        
        $totalCount = $query->count();
        $list = $query->paginate($pageSize, ['*'], 'page', $page);
        
        // 处理金额格式
        foreach ($list as &$item) {
            $item->kmoney = ComFunc::pr2($item->kmoney);
        }
        
        $result = [
            'total' => $totalCount,
            'totalPage' => $list->lastPage(),
            'currentPage' => $page,
            'pageSize' => $pageSize,
            'records' => $list->items()
        ];
        
        return AppJson::success('ok', $result);
    }

    //注册账号
    public function registerAccount(Request $request){
        $ruid = $request->ruid;
        $username = $request->input('username','');
        $password = $request->input('password','');
        $name = $request->input('name','');
        $ignore_outbet = $request->input('ignore_outbet',0);
        //校验账号/^[a-zA-Z0-9]{6,16}$/
        if (!preg_match('/^[a-zA-Z0-9]{6,16}$/', $username)){
            return AppJson::error('登陆账号必须是6-16位数字和字母组合');
        }
        //校验密码8-16位
        if(!preg_match('/^[a-zA-Z0-9]{8,16}$/', $password)){
            return AppJson::error('登陆密码必须包含大小写字母和数字，长度8-16位');
        }
        if(strlen(trim($username)) < 2){
            return AppJson::error('账号至少2位以上');
        }
        //账号不能包含特殊字符
        if(!preg_match("/^[a-zA-Z0-9_]+$/",$username)){
            return AppJson::error('账号不能包含特殊字符');
        }
        if(!isset($name) || empty($name)){
            //随机生成3位昵称
            $name = SGUtils::randomName();
        }
        $ruid = $request->ruid;
        $saveuser = [];$saveuserreg = [];
        //基础注册信息
        $saveuserreg['username'] = $username;
        $saveuserreg['name'] = $name;
        $saveuserreg['userpass'] = md5($password.x_config('upass'));
        $saveuserreg['status'] = 0;
        $saveuserreg['regtime'] = time();
        $saveuserreg['avatar'] = "/avatar/".rand(1,50).".jpg";
        $ex_count = Userreg::where('username',$username)->count('userid');
        if($ex_count > 0){
            return AppJson::error('账号已存在');
        }
        $db = Db::connection();
        $db->beginTransaction();
        try {
            $uid = Userreg::insertGetId($saveuserreg);
            $ftime = strtotime(ComFunc::getthisdate());
            $saveuser['fid'] = $ruid;
            $saveuser['ifagent'] = 0;
            $saveuser['username'] = $username;
            $saveuser['name'] = $name;
            $saveuser['is_exclusive'] = 1;//是否专属账号
            $saveuser['ftime'] = $ftime;
            $saveuser['pan'] = '["A"]';
            $saveuser['userid'] = $uid;
            $saveuser['ruid'] = $ruid;
            $saveuser['type'] = 4;
            $saveuser['ignore_outbet'] = $ignore_outbet;
            User::create($saveuser);
            //添加日志
            ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$uid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"注册账号",'old'=>$username,'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'add']);
            $db->commit();
            return AppJson::success('注册成功');
        }catch (\Exception $e){
            $db->rollBack();
            return AppJson::error('注册失败');
        }
    }

    /**
     * 修改专属账号
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAccount(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        $password = $request->input('password','');
        $name = $request->input('name','');
        $ignore_outbet = $request->input('ignore_outbet',0);
        
        // 参数校验
        if(empty($userid)){
            return AppJson::error('用户ID不能为空');
        }
        
        // 校验密码格式（如果提供密码）
        if(!empty($password) && !preg_match('/^[a-zA-Z0-9]{8,16}$/', $password)){
            return AppJson::error('登陆密码必须包含大小写字母和数字，长度8-16位');
        }
        
        // 校验昵称格式
        if(empty($name)){
            return AppJson::error('昵称不能为空');
        }
        /* if(!preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,8}$/u', $name)){
            return AppJson::error('昵称格式错误，支持1-8位中文、英文、数字');
        } */
        
        // 检查用户是否存在且为专属账号
        $user = User::where(['ruid' => $ruid, 'userid' => $userid, 'ifson' => 0])
                    ->where('userid', '<>', $ruid)
                    ->first();
        
        if(empty($user)){
            return AppJson::error('用户不存在');
        }
        
        if($user['is_exclusive'] != 1){
            return AppJson::error('只有专属账号才能修改');
        }
        
        // 准备更新数据
        $updateUserreg = [];
        $updateUser = [];
        
        // 如果提供了密码，则更新密码
        if(!empty($password)){
            $updateUserreg['userpass'] = md5($password . x_config('upass'));
        }
        
        // 更新昵称
        $updateUserreg['name'] = $name;
        $updateUser['name'] = $name;
        $updateUser['ignore_outbet'] = $ignore_outbet;
        $db = Db::connection();
        $db->beginTransaction();
        try {
            // 更新用户注册表
            if(!empty($updateUserreg)){
                Userreg::where(['userid' => $userid])->update($updateUserreg);
            }
            
            // 更新用户表
            User::where(['ruid' => $ruid, 'userid' => $userid])->update($updateUser);
            
            // 添加操作日志
            $action = !empty($password) ? '账号修改密码' : '账号修改昵称';
            ComFunc::adduseredit([
                'ruid' => $ruid,
                'userid' => $userid,
                'mduserid' => $ruid,
                'sonuid' => $request->uid,
                'action' => $action,
                'old' => $user['name'],
                'new' => $name,
                'moduleKey' => 'platform',
                'functionKey' => 'user',
                'actionKey' => 'update'
            ]);
            
            $db->commit();
            return AppJson::success('修改成功');
        } catch (\Exception $e) {
            $db->rollBack();
            return AppJson::error('修改失败');
        }
    }

    //生成链接generateLink
    public function generateLink(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        $gid = $request->input('gid','');
        $type = $request->input('type','');//类型1有效次数2有效时间
        $count = $request->input('count','');//有效次数或者有效时间

        $mem_url = x_config('mem_url');
        $token = ComFunc::getNewOrderId("SG");
        $link = $mem_url.'/'.$token;
        $saveLink = [];
        //时间和次数 时间：time 次数：count
        if($type == 'time'){
            $saveLink['expire_time'] = time()+($count*60*60*24);
        }else{
            $saveLink['count'] = $count;
        }
        $saveLink['userid'] = $userid;
        $saveLink['ruid'] = $ruid;
        $saveLink['gid'] = $gid;
        $saveLink['token'] = $token;
        $saveLink['type'] = $type;
        $saveLink['create_time'] = time();
        $saveLink['create_uid'] = $request->uid;
        //$saveLink['template'] = Game::where('gid',$gid)->value('template');
        Link::create($saveLink);
        
        /* $param = [];
        $param['ruid'] = $ruid;
        $param['userid'] = $userid;
        $param['gid'] = $gid;
        $param['count'] = $count;
        $param['time'] = time();
        $param['template'] = Game::where('gid',$gid)->value('template');
        
        //缓存
        Cache::put('mem_link_'.$token, $param, 60 * 60 * 24); */
        return AppJson::success('ok',$link);
    }

    //获取链接列表
    public function getLinkRecord(Request $request){
        $ruid = $request->ruid;
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',10);
        $startDate = $request->input('startDate','');
        $endDate = $request->input('endDate','');
        $username = $request->input('username','');
        $list = Link::where('ruid',$ruid);
        if(!empty($startDate)){
            $list->where('create_time','>=',strtotime($startDate.' 00:00:00'));
        }
        if(!empty($endDate)){
            $list->where('create_time','<=',strtotime($endDate.' 23:59:59'));
        }
        if(!empty($username)){
            $quid = Userreg::where('username','like','%'.$username.'%')->value('userid');
            if(!empty($quid)){
                $list->where('userid',$quid);
            }else{
                $list->where('userid',-1);
            }
        }
        //id排序
        $list = $list->orderBy('id','desc')->paginate($pageSize,['*'],'page',$page);
        $tmp = [];$mem_url = x_config('mem_url');
        foreach ($list as &$item){
            //查询用户的username和name
            if(!isset($tmp[$item['userid']])){
                $tmp[$item['userid']] = Userreg::where('userid',$item['userid'])->select(['username','name'])->first();
            }
            $item['username'] = $tmp[$item['userid']]['username'];
            $item['name'] = $tmp[$item['userid']]['name'];
            $time1 = date('m/d',$item['create_time']);
            $time2 = date('H:i:s',$item['create_time']);
            $item['time1'] = $time1;
            $item['time2'] = $time2;
            $time3 = date('m/d',$item['expire_time']);
            $time4 = date('H:i:s',$item['expire_time']);
            $item['time3'] = $time3;
            $item['time4'] = $time4;
            //生成链接
            $item['link'] = $mem_url.'/'.$item['token'];
        }
        $result = [];
        $result['total'] = $list->total();
        $result['totalPage'] = $list->lastPage();
        $result['currentPage'] = $list->currentPage();
        $result['pageSize'] = $list->perPage();
        $result['records'] = $list->items();
        return AppJson::success('ok',$result);
    }

    /**
     * 获取子账号列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSonAccountList(Request $request){
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',10);
        $ruid = $request->ruid;
        $list = User::with(['userreg'])->where(['ruid'=>$ruid,'ifson'=>1])->select(['userid'])->paginate($pageSize, ['userid'], 'page', $page);
        foreach ($list as &$item){
            //查询Online表
            $online = Online::where(['ruid'=>$ruid,'userid'=>$item['userid']])->value('online');
            $item['online'] = $online;
        }
        $result = [];
        $result['total'] = $list->total();
        $result['totalPage'] = $list->lastPage();
        $result['currentPage'] = $list->currentPage();
        $result['pageSize'] = $list->perPage();
        $result['records'] = $list->items();
        return AppJson::success('ok',$result);
    }

    /**
     * 添加子账号
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function addSonAccount(Request $request){
        $ruid = $request->ruid;
        $username = $request->input('username','');
        $password = $request->input('password','');
        $name = $request->input('name','');
        //校验账号，6-16位英文数字
        if(!preg_match('/^[a-zA-Z0-9]{6,16}$/',$username)){
            return AppJson::error('账号格式错误');
        }
        //校验密码，8-16位英文数字
        if(!preg_match('/^[a-zA-Z0-9]{8,16}$/',$password)){
            return AppJson::error('密码格式错误');
        }
        //校验昵称1-6位任何字符
        if(!preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,8}$/u',$name)){
            return AppJson::error('昵称格式错误');
        }
        $userreg = Userreg::where(['username'=>$username])->first();
        if(!empty($userreg)){
            return AppJson::error('账号已存在');
        }
        /* if($userreg['ifson'] == 1){
            return AppJson::error('权限不足');
        } */
        $saveUserreg = [];
        $saveUserreg['username'] = $username;
        $saveUserreg['userpass'] = md5($password.x_config('upass'));
        $saveUserreg['name'] = $name;
        $saveUserreg['type'] = 1;
        $saveUserreg['ifson'] = 1;
        $saveUserreg['avatar'] = "/upload/defaultavatar/".rand(1,50).".jpg";
        $saveUserreg['ruid'] = $ruid;
        $saveUserreg['regtime'] = time();
        $saveUser = [];
        $saveUser['ruid'] = $ruid;
        $saveUser['fid'] = $ruid;
        $saveUser['username'] = $username;
        $saveUser['name'] = $name;
        $saveUser['ifagent'] = 1;
        $saveUser['ifson'] = 1;
        $saveUser['pan'] = '["A"]';
        $saveUser['type'] = 2;
        $db = Db::connection();
        $db->beginTransaction();
        try {
            $uid = Userreg::insertGetId($saveUserreg);
            $saveUser['userid'] = $uid;
            User::insert($saveUser);
            $db->commit();
            //添加日志1
            ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$uid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"添加子账号",'old'=>$username,'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'add']);
        }catch (\Exception $e){
            $db->rollBack();
            return AppJson::error('添加失败');
        }
        return AppJson::success('添加成功');
    }

    /**
     * 修改子账号
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSonAccount(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        $password = $request->input('password','');
        $name = $request->input('name','');
        //校验密码，8-16位英文数字
        if(!empty($password) && !preg_match('/^[a-zA-Z0-9]{8,16}$/',$password)){
            return AppJson::error('密码格式错误');
        }
        //校验昵称1-8中文英文数字
        if(!empty($name) && !preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,8}$/u',$name)){
            return AppJson::error('昵称格式错误');
        }
        $userreg = Userreg::where(['ruid'=>$ruid,'userid'=>$userid,'ifson'=>1])->first();
        if(empty($userreg)){
            return AppJson::error('用户不存在');
        }
        if($userreg['ifson'] == 0){
            return AppJson::error('权限不足');
        }
        $saveUserreg = [];
        if(!empty($password)){
            $saveUserreg['userpass'] = md5($password.x_config('upass'));
        }
        if(!empty($name)){
            $saveUserreg['name'] = $name;
        }
        if(empty($saveUserreg)){
            return AppJson::success('修改成功');
        }
        Userreg::where(['ruid'=>$ruid,'userid'=>$userid])->update($saveUserreg);
        User::where(['ruid'=>$ruid,'userid'=>$userid])->update(['name'=>$name]);
        //添加日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$userid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"修改子账号",'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'update']);
        return AppJson::success('修改成功');
    }

    /**
     * 修改子账号状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSonStatus(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        $status = $request->input('status',1);
        $userreg = Userreg::where(['ruid'=>$ruid,'userid'=>$userid])->first();
        if(empty($userreg)){
            return AppJson::error('用户不存在');
        }
        $cuser = User::where(['ruid'=>$ruid,'userid'=>$request->uid])->select(['ifson'])->first();
        if($cuser['ifson'] == 1){
            return AppJson::error('权限不足');
        }
        $oldStatusStr = SGUtils::getStatusStr($userreg['status']);
        $newStatusStr = SGUtils::getStatusStr($status);
        $userreg->status = $status;
        $userreg->save();
        //添加日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$userid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"状态变更",'old'=>$oldStatusStr,'new'=>$newStatusStr,'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'update']);
        return AppJson::success('操作成功');
    }

    /**
     * 重置错误次数
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetErrors(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        if(empty($userid)){
            return AppJson::error('参数错误');
        }
        //更新错误次数
        Userreg::where(['ruid'=>$ruid,'userid'=>$userid,'ifson'=>1])->update(['errortimes'=>0]);
        return AppJson::success('重置成功');
    }

    /**
     * 重置谷歌验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetGoogle(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        if(empty($userid)){
            return AppJson::error('参数错误');
        }
        //更新谷歌验证
        Userreg::where(['ruid'=>$ruid,'userid'=>$userid,'ifson'=>1])->update(['google_open'=>0]);
        return AppJson::success('重置成功');
    }

    /**
     * 删除子账号
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function delSonAccount(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        $user = User::where(['ruid'=>$ruid,'userid'=>$userid])->first();
        if(empty($user)){
            return AppJson::error('用户不存在');
        }
        if($user['ifson'] == 1){
            return AppJson::error('权限不足');
        }
        $db = DB::connection();
        $db->beginTransaction();
        try {
            User::where(['ruid'=>$ruid,'userid'=>$userid])->delete();
            Userreg::where(['userid'=>$userid])->delete();
            //删除登录日志
            $db->table('x_user_login')->where(['username'=>$user['username']])->delete();
            $db->commit();
            //添加日志
            ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$userid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"删除子账号".$user['username'],'old'=>$user['username'],'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'del']);
            return AppJson::success('删除成功');
        }catch (\Exception $e){
            $db->rollBack();
            return AppJson::error('删除失败');
        }
    }

    /**
     * 上下分
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function shangxiafen(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        $kmoney = $request->input('kmoney');
        $type = $request->input('type',1);
        //校验金额，只能是正数
        if(!is_numeric($kmoney) && $kmoney <= 0){
            return AppJson::error('金额错误');
        }
        $db = DB::connection();
        $db->beginTransaction();
        try {
            $user = User::where(['ruid'=>$ruid,'userid'=>$userid])->select(['kmoney','kmaxmoney'])->lockForUpdate()->first();
            if(empty($user)){
                $db->rollBack();
                return AppJson::error('用户不存在');
            }
            if($type == 2 && $user->kmoney < $kmoney){
                $db->rollBack();
                return AppJson::error('余额不足，可用余额：'.ComFunc::pr2($user->kmoney));
            }
            //添加资金记录//
            $savemoneylog = [];
            $savemoneylog['ruid'] = $ruid;
            $savemoneylog['userid'] = $userid;
            $savemoneylog['beforeMoney'] = $user->kmoney;
            $savemoneylog['money'] = $kmoney;
            $savemoneylog['operateType'] = $type == 1 ? 1 : 2;
            $savemoneylog['moneyType'] = $type == 1 ? 3 : 4;
            $savemoneylog['operUserid'] = $request->uid;
            $savemoneylog['time'] = time();
            $savemoneylog['dates'] = strtotime(ComFunc::getthisdateend());
            $savemoneylog['bz'] = '管理操作';
            MoneyLog::create($savemoneylog);
            $update = [];
            if($type == 1){
                $update['kmoney'] = $user->kmoney + $kmoney;
                $update['kmaxmoney'] = $user->kmaxmoney + $kmoney;
            }else{
                $update['kmoney'] = $user->kmoney - $kmoney;
                $update['kmaxmoney'] = $user->kmaxmoney - $kmoney;
            }
            User::where(['ruid'=>$ruid,'userid'=>$userid])->update($update);
            //添加日志
            $tstr = $type == 1 ? '上分' : '下分';
            ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$userid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>$tstr.$kmoney,'old'=>'','new'=>'','moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'update']);
            $db->commit();
            return AppJson::success('操作成功');
        }catch (\Exception $e){
            $db->rollBack();
            return AppJson::error('操作失败');
        }
    }

    /**
     * 修改用户状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyStatus(Request $request){
        $ruid = $request->ruid;
        $userid = $request->input('userid');
        $room_status = $request->input('room_status');
        //是否在0,1，2
        if(!in_array($room_status,[0,1,2])){
            return AppJson::error('状态错误');
        }
        $user = User::where(['ruid'=>$ruid,'userid'=>$userid])->first();
        if(empty($user)){
            return AppJson::error('用户不存在');
        }
        $oldStatusStr = SGUtils::getStatusStr($user['room_status']);
        $newStatusStr = SGUtils::getStatusStr($room_status);
        //如果是停用，踢出在线
        if($user['room_status'] != $room_status && $room_status == 0){
            ComServices::clearOnlineData($ruid,$userid,2);
        }elseif ($user['room_status'] != $room_status && ($room_status == 2 || $room_status == 1)){//如果是冻结，发送消息
            $fd = ComServices::getFdByUid($ruid,$userid);
            if($fd){
                ComServices::sendMsg(null,$fd,'roomStatusNotice',['room_status'=>$room_status]);
            }
        }
        $user->room_status = $room_status;
        $user->save();
        //添加日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$userid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"状态变更",'old'=>$oldStatusStr,'new'=>$newStatusStr,'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'update']);
        return AppJson::success('修改成功');
    }

    /**
     * 删除所有0分用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delAllZeroUser(Request $request){
        $ruid = $request->ruid;
        $list = User::where(['ruid'=>$ruid,'kmoney'=>0,'ifagent'=>0])->get();
        foreach ($list as $item){
            //删除用户
            ComServices::clearOnlineData($ruid,$item->userid,2);
            //删除房间记录
            Roomhistory::where(['userid'=>$item->userid,'ruid'=>$ruid])->delete();
        }
        //添加日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"一键删除0分用户",'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'delallzero']);
        return AppJson::success('操作成功');
    }

    /**
     * 获取赔率设置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOddsSet(Request $request){
        $gid = $request->input('gid',0);
        if(empty($gid)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $game = Game::where(['gid'=>$gid])->select(['dftype'])->first();
        if(empty($game)){
            return AppJson::error('游戏不存在');
        }
        $dftypeJson = json_decode($game['dftype'],true);
        $patt = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->value('patt');
        $pattJson = json_decode($patt,true);
        $result = [];
        foreach ($pattJson as $key=>$item){
            $resultitem = [];
            $resultitem['name'] = $dftypeJson[$item['bc']].'-'.$item['name'];
            $resultitem['odds'] = $item['p'];
            $resultitem['minBetAmount'] = $item['minBetAmount'];
            $resultitem['maxBetAmount'] = $item['maxBetAmount'];
            $resultitem['maxUserPeriodAmount'] = $item['maxUserPeriodAmount'];
            $resultitem['maxPeriodAmount'] = $item['maxPeriodAmount'];
            $resultitem['key'] = $key;
            $result[] = $resultitem;
        }
        return AppJson::success('ok',$result);
    }

    /**
     * 保存赔率设置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOddsSet(Request $request){
        $ruid = $request->ruid;
        $gid = $request->input('gid',0);
        $odds = $request->input('odds','');
        if(empty($gid) || empty($odds)){
            return AppJson::error('参数错误');
        }
        $patt = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->value('patt');
        if(empty($patt)){
            return AppJson::error('游戏不存在');
        }
        $pattJson = json_decode($patt,true);
        foreach ($odds as $item){
            $key = $item['key'];
            $pattJson[$key]['p'] = $item['odds'];
            $pattJson[$key]['minBetAmount'] = $item['minBetAmount'];
            $pattJson[$key]['maxBetAmount'] = $item['maxBetAmount'];
            $pattJson[$key]['maxUserPeriodAmount'] = $item['maxUserPeriodAmount'];
            $pattJson[$key]['maxPeriodAmount'] = $item['maxPeriodAmount'];
        }
        $patt = json_encode($pattJson);
        Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->update(['patt'=>$patt]);
        //添加日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"修改赔率",'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'updateodds']);
        return AppJson::success('保存成功');
    }

    /**
     * 同步赔率设置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function synOddsSet(Request $request){
        $ruid = $request->ruid;
        $gid = $request->input('gid',0);
        if(empty($gid)){
            return AppJson::error('参数错误');
        }
        $patt = Userpatt::where(['userid'=>$ruid,'gid'=>$gid,'ifopen'=>1])->value('patt');
        if(empty($patt)){
            return AppJson::error('游戏不存在');
        }
        $fenlei = Game::where(['gid'=>$gid])->value('fenlei');
        $glist = Game::where(['fenlei'=>$fenlei])->select(['gid'])->get();
        foreach ($glist as $item){
            $cgid = $item['gid'];
            if($cgid == $gid){
                continue;
            }
            Userpatt::where(['userid'=>$ruid,'gid'=>$cgid,'ifopen'=>1])->update(['patt'=>$patt]);
        }
        //添加日志
        ComFunc::adduseredit(['ruid'=>$ruid,'userid'=>$ruid,'mduserid'=>$ruid,'sonuid'=>$request->uid,'action'=>"同步赔率",'moduleKey'=>'platform','functionKey'=>'user','actionKey'=>'synodds']);
        return AppJson::success('同步成功');
    }

    /**
     * 获取二次验证信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecondver(Request $request){
        $uid = $request->uid;
        $userreg = Userreg::where('userid',$uid)->select(['google_open','google_secret','username','name'])->first();
        $result = [];
        $result['google_open'] = $userreg['google_open'];
        if($userreg['google_open'] == 0){
            $username = $userreg['username'];
            $name = $userreg['name'];
            $authcode = GoogleAuthenticator::CreateSecret();
            $secret = $authcode['secret'];
            $codeurl = $authcode['codeurl'];
            $codeurl = str_replace('?secret',"{$username}".'?secret', $codeurl);
            $codeurl .= "&issuer={$name}";
            $result['secret'] = $secret;
            $result['codeurl'] = $codeurl;
        }
        return AppJson::success('ok',$result);
    }

    /**
     * 保存二次验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveSecondver(Request $request){
        $uid = $request->uid;
        $code = $request->input('code','');
        $secret = $request->input('secret','');
        if(empty($code) || empty($secret)){
            return AppJson::error('参数错误');
        }
        //判断谷歌口令是否已经开启
        $userreg = Userreg::where('userid',$uid)->select(['google_open','google_secret'])->first();
        if($userreg['google_open'] == 1){
            return AppJson::error('已绑定谷歌口令');
        }
        //校验谷歌口令
        $checkResult = GoogleAuthenticator::CheckCode($secret,$code);
        if (!$checkResult){
            return AppJson::error('谷歌验证码错误');
        }
        //保存谷歌口令
        Userreg::where('userid',$uid)->update(['google_open'=>1,'google_secret'=>$secret]);
        return AppJson::success('保存成功');
    }

    /**
     * 重置二次验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetSecondver(Request $request){
        $uid = $request->uid;
        $code = $request->input('code','');
        $userreg = Userreg::where('userid',$uid)->select(['google_open','google_secret'])->first();
        if($userreg['google_open'] == 0){
            return AppJson::error('未绑定谷歌口令');
        }
        //校验谷歌口令
        $checkResult = GoogleAuthenticator::CheckCode($userreg['google_secret'],$code);
        if (!$checkResult){
            return AppJson::error('谷歌验证码错误');
        }
        Userreg::where('userid',$uid)->update(['google_open'=>0,'google_secret'=>'']);
        return AppJson::success('重置成功');
    }

    //获取会员列表，用于飞单选择
    public function getUserListForOutbet(Request $request){
        $ruid = $request->ruid;
        $username = $request->input('username','');
        $name = $request->input('name','');
        $list = User::where(['ruid'=>$ruid,'type'=>4]);
        $result = [];
        if(!empty($name)){
            $list = $list->where('name','like','%'.$name.'%');
        }
        if(!empty($username)){//模糊查询
            $list = $list->where('username','like','%'.$username.'%');
        }
        $list = $list->select(['userid','username','name'])->get();
        foreach ($list as $item){
            $resultitem = [];
            $resultitem['userid'] = $item['userid'];
            $resultitem['username'] = $item['username'];
            $resultitem['name'] = $item['name'];
            $result[] = $resultitem;
        }
        return AppJson::success('ok',$result);
    }

    //飞单列表
    public function getOutbetList(Request $request){
        $ruid = $request->ruid;
        $list = OutbetSite::where(['ruid'=>$ruid])->get();
        foreach ($list as $item){
            $item['create_time'] = date('Y-m-d H:i:s',$item['create_time']);
            //gids
            $gids = explode(',',$item['gids']);
            $gnames = Game::whereIn('gid',$gids)->pluck('gname')->toArray();
            $item['gidsname'] = implode(',',$gnames);
            //指定用户
            if(!empty($item['zhidinguser'])){
                $zhidinguser = explode(',',$item['zhidinguser']);
                $zhidinguser = User::whereIn('username',$zhidinguser)->where(['ruid'=>$ruid,'type'=>4])->pluck('username')->toArray();
                $item['zhidingusernames'] = implode(',',$zhidinguser);
            }else{
                $item['zhidingusernames'] = '';
            }
            if(!empty($item['bz'])){
                $bzarr = explode('|',$item['bz']);
                $item['balance'] = $bzarr[0];//余额
                $item['unsettle'] = $bzarr[1];//未结算
                $item['sy'] = $bzarr[2];//盈亏
            }else{
                $item['balance'] = 0;
                $item['unsettle'] = 0;
                $item['sy'] = 0;
            }
        }
        return AppJson::success('ok',['records'=>$list,'total'=>count($list)]);
    }

    //添加飞单
    public function addOutbetOrEdit(Request $request){
        $ruid = $request->ruid;
        $uid = $request->uid;
        $id = $request->input('id',0);
        $name = $request->input('name','');
        $type = $request->input('type','');
        $username = $request->input('username','');
        $password = $request->input('password','');
        $gids = $request->input('gids','');
        $bet_mode = $request->input('bet_mode',1);
        $indicator = $request->input('indicator',1);
        $is_hebing = $request->input('is_hebing',0);
        $flyjiabei = $request->input('flyjiabei',1);
        $start_money = $request->input('start_money',0);
        $chai_money = $request->input('chai_money',0);
        $zhidinguser = $request->input('zhidinguser','');
        $urls = $request->input('urls','');
        $enabled = $request->input('enabled',1);
        $order_mode = $request->input('order_mode',1);
        $abcd = $request->input('abcd','A');

        //判断是否过期，如果过期则不能操作
        $outbet_overtime = Userroom::where(['userid'=>$ruid])->value('outbet_overtime');
        if($outbet_overtime < time()){
            return AppJson::error('打单已过期，请开通');
        }

        if(empty($name)){
            return AppJson::error('名称不能为空');
        }
        if(empty($type)){
            return AppJson::error('盘口类型不能为空');
        }
        if(empty($username)){
            return AppJson::error('盘口账号不能为空');
        }
        if(empty($password)){
            return AppJson::error('盘口密码不能为空');
        }
        if(empty($gids)){
            return AppJson::error('请选择至少一个游戏');
        }
        if(empty($bet_mode)){
            return AppJson::error('请选择投注模式');
        }
        if(empty($flyjiabei)){
            return AppJson::error('请填写正确打单倍数');
        }
        //通过\r\n或者\n符分割
        $turls = preg_split("/\r\n|\n/",$urls);
        $turls = array_filter($turls);
        if(count($turls) == 0){
            return AppJson::error('请填写域名');
        }
        //判断域名是否正确
        foreach ($turls as $url){
            if(!filter_var($url,FILTER_VALIDATE_URL)){
                return AppJson::error('域名格式错误');
            }
        }
        if($id <= 0){
            $isexist = OutbetSite::where(['name'=>$name,'ruid'=>$ruid])->first();
            if($isexist){
                return AppJson::error('站点名称已存在');
            }
            //添加
            $saveData = [];
            $saveData['ruid'] = $ruid;
            $saveData['userid'] = $uid;
            $saveData['name'] = $name;
            $saveData['type'] = $type;
            $saveData['username'] = $username;
            $saveData['password'] = $password;
            $saveData['gids'] = $gids;
            $saveData['bet_mode'] = $bet_mode;
            $saveData['indicator'] = $indicator;
            $saveData['is_hebing'] = $is_hebing;
            $saveData['flyjiabei'] = $flyjiabei;
            $saveData['start_money'] = $start_money;
            $saveData['chai_money'] = $chai_money;
            $saveData['zhidinguser'] = $zhidinguser;
            $saveData['urls'] = $urls;
            $saveData['enabled'] = $enabled;
            $saveData['order_mode'] = $order_mode;
            $saveData['create_time'] = time();
            $saveData['abcd'] = $abcd;
            $saveData['auth_outbet_ip'] = Userroom::where(['userid'=>$ruid])->value('auth_outbet_ip');
            OutbetSite::create($saveData);

            return AppJson::success('添加成功');
        }else{
            $info = OutbetSite::where(['id'=>$id,'ruid'=>$ruid])->first();
            if(empty($info)){
                return AppJson::error('飞单不存在');
            }
            $info->name = $name;
            $info->type = $type;
            $info->username = $username;
            $info->password = $password;
            $info->gids = $gids;
            $info->bet_mode = $bet_mode;
            $info->indicator = $indicator;
            $info->is_hebing = $is_hebing;
            $info->flyjiabei = $flyjiabei;
            $info->start_money = $start_money;
            $info->chai_money = $chai_money;
            $info->zhidinguser = $zhidinguser;
            $info->urls = $urls;
            $info->enabled = $enabled;
            $info->order_mode = $order_mode;
            $info->abcd = $abcd;
            $info->save();
            return AppJson::success('编辑成功');
        }
    }

    //根据id获取飞单信息
    public function getOutbetInfo(Request $request){
        $id = $request->input('id',0);
        if(empty($id)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $info = OutbetSite::where(['id'=>$id,'ruid'=>$ruid])->first();
        if(empty($info)){
            return AppJson::error('飞单不存在');
        }
        if(!empty($info['bz'])){
            $bzarr = explode('|',$info['bz']);
            $info['balance'] = $bzarr[0];//余额
            $info['unsettle'] = $bzarr[1];//未结算
            $info['sy'] = $bzarr[2];//盈亏
        }else{
            $info['balance'] = 0;
            $info['unsettle'] = 0;
            $info['sy'] = 0;
        }
        return AppJson::success('ok',$info);
    }

    //删除飞单
    public function delOutbet(Request $request){
        $id = $request->input('id',0);
        if(empty($id)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $info = OutbetSite::where(['id'=>$id,'ruid'=>$ruid])->first();
        if(empty($info)){
            return AppJson::error('飞单不存在');
        }
        $info->delete();
        return AppJson::success('删除成功');
    }

    //更新状态
    public function updateOutbetStatus(Request $request){
        $id = $request->input('id',0);
        $enabled = $request->input('enabled',0);
        if(empty($id)){
            return AppJson::error('参数错误');
        }
        $ruid = $request->ruid;
        $update = [];
        $update['enabled'] = $enabled;
        if($enabled == 0){
            $update['online'] = 0;
            $update['cookie'] = '';
            $update['curl'] = '';
        }
        OutbetSite::where(['id'=>$id,'ruid'=>$ruid])->update($update);
        return AppJson::success('操作成功');
    }

    //飞单记录
    public function getOutbetRecord(Request $request){
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',10);
        $siteid = $request->input('siteid',0);
        $date = $request->input('date','');
        $status = $request->input('status','');
        $ruid = $request->ruid;

        $thisdate = ComFunc::getthisdateend();
        $db = Db::connection();
        if(empty($date)){
            $date = $thisdate;
        }
        if($thisdate == $date) {
            $flytb = SGUtils::getcureflytable(false);
        }else{
            $sdate = str_replace('-','',$date);
            $flytb = 'libfly_'.$sdate;
            //判断表是否存在
            $tbs = $db->select("SHOW TABLES LIKE  '$flytb'");
            if(empty($tbs)){
                return AppJson::success('ok',['records'=>[],'total'=>0]);
            }
        }
        $list = $db->table($flytb);
        $list = $list->where('ruid',$ruid);
        if($siteid > 0){
            $list = $list->where('siteid',$siteid);
        }
        if($status != ''){
            $list = $list->where('status',$status);
        }
        $list = $list->orderBy('id','desc')->paginate($pageSize,['*'],'page',$page);
        $tmp = [];$records = [];
        foreach ($list as &$item){
            $resultitem = [];
            $resultitem['orderno'] = $item['orderno'];
            $resultitem['qishu'] = $item['qishu'];
            $resultitem['old_count'] = $item['old_count'];
            $resultitem['old_je'] = $item['old_je'];
            $resultitem['je'] = $item['je'];
            $resultitem['bz'] = $item['bz'];
            $resultitem['status'] = $item['status'];
            $resultitem['type'] = $item['type'];
            //查询游戏
            if(!isset($tmp[$item['gid']])){
                $tmp[$item['gid']] = Game::where('gid',$item['gid'])->value('gname');
            }
            $resultitem['gname'] = $tmp[$item['gid']];

            //查询站点
            if(!isset($tmp[$item['siteid']])){
                $tmp[$item['siteid']] = OutbetSite::where('id',$item['siteid'])->select(['name','username'])->first();
            }
            $resultitem['sitename'] = $tmp[$item['siteid']]['name'].'【'.$tmp[$item['siteid']]['username'].'】';

            if(!isset($tmp[$item['sid']])){
                $tmp[$item['sid']] = CommonCache::getsclasscache($item['gid'],$item['sid'])['name'];
            }
            if(!isset($tmp[$item['pid']])){
                $tmp[$item['pid']] = CommonCache::getplaycache($item['gid'],$item['pid'])['name'];
            }
            $sname = $tmp[$item['sid']];
            $pname = $tmp[$item['pid']];
            $resultitem['pcon'] = $sname.'-'.$pname;
            $resultitem['time'] = date('Y-m-d H:i:s',$item['time']);
            $records[] = $resultitem;
        }
        $result = [];
        $result['total'] = $list->total();
        $result['totalPage'] = $list->lastPage();
        $result['currentPage'] = $list->currentPage();
        $result['pageSize'] = $list->perPage();
        $result['records'] = $records;
        return AppJson::success('ok',$result);
    }

    //获取飞单配置信息
    public function getOutbetConfig(Request $request){
        $ruid = $request->ruid;
        $roomConfig = Userroom::where(['userid'=>$ruid])->select(['outbet_overtime','outbet_switch'])->first();
        $return = [];
        $return['outbet_overtime'] = $roomConfig['outbet_overtime'];
        $return['outbet_switch'] = $roomConfig['outbet_switch'];
        $return['outbet_sy_count'] = x_config('outbet_sy_count');
        $return['outbet_sy_time'] = x_config('outbet_sy_time');
        $return['outbet_money1'] = x_config('outbet_money1');
        $return['outbet_money2'] = x_config('outbet_money2');
        return AppJson::success('ok',$return);
    }

    //更新飞单总开关
    public function updateOutbetSwitch(Request $request){
        $outbet_switch = $request->input('outbet_switch',0);
        $ruid = $request->ruid;
        //判断是否过期，如果过期则不能操作
        $outbet_overtime = Userroom::where(['userid'=>$ruid])->value('outbet_overtime');
        if($outbet_overtime < time()){
            return AppJson::error('打单已过期，请重新开通');
        }
        Userroom::where(['userid'=>$ruid])->update(['outbet_switch'=>$outbet_switch]);
        return AppJson::success('操作成功');
    }

    //申请试用
    public function applyOutbet(Request $request){
        $type = $request->input('type',1);//1申请试用 2开通飞单
        $days = $request->input('days',1);//开通天数
        $ruid = $request->ruid;
        $outbet_sy_count = x_config('outbet_sy_count');
        $outbet_sy_time = x_config('outbet_sy_time');
        if($type == 1){//申请试用
            $thisdate = ComFunc::getthisdateend();
            $key = "apply_outbet_".$ruid."_".$thisdate;
            $count = Cache::get($key,0);
            if($count >= $outbet_sy_count){
                return AppJson::error('您已达到试用次数上限');
            }
            $old_outbet_overtime = Userroom::where(['userid'=>$ruid])->value('outbet_overtime');
            //如果原来的时间大于当前时间+($outbet_sy_time*60)，则不更新
            if($old_outbet_overtime > time() + ($outbet_sy_time*60)){
                return AppJson::error('您的试用时间未结束，请等待');
            }
            //试用时间=当前时间+($outbet_sy_time*60)
            $endtime = time() + ($outbet_sy_time*60);
            //计算出离第二天00:00:00有多少秒
            $nextday = strtotime(date('Y-m-d',strtotime('+1 day')));
            $diff = $nextday - time();
            Cache::put($key,$count+1,$diff);
            //更新过期时间
            Userroom::where(['userid'=>$ruid])->update(['outbet_overtime'=>$endtime]);
        }else{
            if($days == 1){
                $money = x_config('outbet_money1');
            }else{
                $money = x_config('outbet_money2');
            }
            $db = Db::connection();
            try {
                $db->beginTransaction();
                //查询百胜币余额
                $user = User::where(['ruid'=>$ruid,'userid'=>$ruid])->lockForUpdate()->first();
                if($user['bsb_coin'] < $money){
                    return AppJson::error('百胜币余额不足');
                }
                //扣除百胜币
                User::where(['ruid'=>$ruid,'userid'=>$ruid])->update(['bsb_coin'=>$user['bsb_coin']-$money]);
                //更新过期时间
                $endtime = time() + ($days*24*60*60);
                $oldoutbet_overtime = Userroom::where(['userid'=>$ruid])->value('outbet_overtime');
                if($oldoutbet_overtime > time()){
                    $endtime = $oldoutbet_overtime + ($days*24*60*60);
                }
                Userroom::where(['userid'=>$ruid])->update(['outbet_overtime'=>$endtime]);
                // 写入日志
                $savemoneylog = [];
                $savemoneylog['ruid'] = $ruid;
                $savemoneylog['userid'] = $ruid;
                $savemoneylog['mtype'] = 2;
                $savemoneylog['beforeMoney'] = $user['bsb_coin'];
                $savemoneylog['money'] = abs($money);
                $savemoneylog['operateType'] = 2;
                $savemoneylog['moneyType'] = 4;
                $savemoneylog['bz'] = '百胜币';
                $savemoneylog['gid'] = 0;
                $savemoneylog['qishu'] = 0;
                $savemoneylog['operUserid'] = $ruid;
                $savemoneylog['modisonuser'] = $ruid;
                $savemoneylog['time'] = time();
                $savemoneylog['dates'] = strtotime(ComFunc::getthisdateend());
                MoneyLog::create($savemoneylog);
                $db->commit();
            } catch (\Exception $e) {
                $db->rollBack();
                return AppJson::error($e->getMessage());
            }
        }
        return AppJson::success('操作成功');
    }

    //获取飞单typelist
    public function getOutbetTypeList(Request $request){
        $list = [];
        $list[] = ['id'=>'daji','name'=>'大吉'];
        $list[] = ['id'=>'sgwin','name'=>'SGWIN'];
        $ishowhebing = 1;
        return AppJson::success('ok',['list'=>$list,'ishowhebing'=>$ishowhebing]);
    }
}
