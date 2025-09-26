<?php

namespace App\Http\Controllers\Api\Member\app;


use App\ComServices\UserService;
use App\Models\Game\Roomhistory;
use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\UserOnline;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserinfoController
{
    //上传用户头像
    public function uploadheadimg(Request $request){
        $uid = $request->uid;
        try {
            $file = $request->file('file');
            if (empty($file)) {
                return AppJson::error('请选择图片');
            }
            // 校验文件类型
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                return AppJson::error('图片类型不支持');
            }
            // 校验文件大小，限制为 2MB（2048 KB）
            $maxSize = 5 * 1024 * 1024;
            if ($file->getSize() > $maxSize) {
                return AppJson::error('最大支持单张图片大小5M');
            }
            $headImageUploadMode = x_config('headImageUploadMode');
            $url = UploadService::upload($headImageUploadMode,$file,'avatar');
            Userreg::where('userid', $uid)->update(['avatar' => $url]);//更新用户头像
        } catch (\Exception $e) {
            return AppJson::error('上传失败');
        }
        return AppJson::success('ok', ['url' => $url]);
    }

    //获取房间历史列表
    public function getHistoryRoomList(Request $request){
        $uid = $request->uid;
        $list = Roomhistory::where(['userid'=>$uid])->select(['ruid','id'])->get();
        $result = [];
        foreach ($list as $item){
            $ur = Userroom::where(['userid'=>$item['ruid']])->select(['roomid','roomName','roomAvatar'])->first()->toArray();
            $ur['id'] = $item['id'];
            $result[] = $ur;
        }
        $userreg = Userreg::where('userid', $uid)->select(['avatar','username','name'])->first();
        $r = [];
        $r['avatar'] = $userreg['avatar'];
        $r['username'] = $userreg['username'];
        $r['nickname'] = $userreg['name'];
        $r['roomlist'] = $result;
        return AppJson::success('ok', $r);
    }

    public function delRoomhistory(Request $request){
        $id = $request->input('id','');
        if(empty($id)){
            return AppJson::error('参数错误');
        }
        $uid = $request->uid;
        Roomhistory::where(['userid'=>$uid,'id'=>$id])->delete();
        return AppJson::success('删除成功');
    }

    public function getRegUserinfo(Request $request){
        $uid = $request->uid;
        $res = Userreg::where('userid', $uid)->select(['avatar','username','name'])->first();
        return AppJson::success('',$res);
    }

    public function updateNickName(Request $request){
        $nickname = $request->input('nickname','');
        if(empty($nickname)){
            return AppJson::error('昵称不能为空');
        }
        //校验昵称长度不能超过10个字符
        if(mb_strlen($nickname) > 6){
            return AppJson::error('昵称长度不能超过10个字符');
        }
        $uid = $request->uid;
        Userreg::where('userid', $uid)->update(['name'=>$nickname]);
        //更新所有房间用户昵称
        User::where('userid', $uid)->update(['name'=>$nickname]);
        return AppJson::success();
    }

    public function haveTpsw(Request $request){
        $uid = $request->uid;
        $enabledTPsw = Userreg::where('userid', $uid)->value('enabledTPsw');
        return AppJson::success('ok', ['enabledTPsw' => $enabledTPsw]);
    }

    public function setTpsw(Request $request){
        $psw = $request->input('psw','');
        if(empty($psw)){
            return AppJson::error('请输入下分密码');
        }
        //判断是否是6位数字
        if(!preg_match('/^\d{6}$/',$psw)){
            return AppJson::error('下分密码必须是6位数字');
        }
        $uid = $request->uid;
        $enabledTPsw = Userreg::where('userid', $uid)->value('enabledTPsw');
        if($enabledTPsw == 1){
            return AppJson::error('下分密码已开启，请勿重复开启');
        }
        $psw = md5($psw.x_config('upass'));
        Userreg::where('userid', $uid)->update(['enabledTPsw' => 1,'moneypass'=>$psw]);
        return AppJson::success('下分密码开启成功');
    }

    public function closeTpsw(Request $request){
        $psw = $request->input('psw','');
        if(empty($psw)){
            return AppJson::error('请输入下分密码');
        }
        //判断是否是6位数字
        if(!preg_match('/^\d{6}$/',$psw)){
            return AppJson::error('下分密码必须是6位数字');
        }
        $uid = $request->uid;
        //判断下分密码是否正确
        $mypsw = Userreg::where('userid', $uid)->value('moneypass');
        $psw = md5($psw.x_config('upass'));
        if($psw != $mypsw){
            return AppJson::error('下分密码错误');
        }
        //关闭下分密码
        Userreg::where('userid', $uid)->update(['enabledTPsw' => 0,'moneypass'=>'']);
        return AppJson::success('下分密码关闭成功');
    }

    public function resetTpsw(Request $request){
        $old = $request->input('old','');
        $psw = $request->input('psw','');
        if(empty($old) || empty($psw)){
            return AppJson::error('请输入原密码和新密码');
        }
        //判断是否是6位数字
        if(!preg_match('/^\d{6}$/',$psw)){
            return AppJson::error('下分密码必须是6位数字');
        }
        $uid = $request->uid;
        $userreg = Userreg::where('userid', $uid)->select(['enabledTPsw','moneypass'])->first();
        if($userreg['enabledTPsw'] == 0){
            return AppJson::error('下分密码未开启，请先开启下分密码');
        }
        //判断原密码是否正确
        $old = md5($old.x_config('upass'));
        if($old != $userreg['moneypass']){
            return AppJson::error('原密码错误');
        }
        $psw = md5($psw.x_config('upass'));
        Userreg::where('userid', $uid)->update(['moneypass' => $psw]);
        return AppJson::success('下分密码修改成功');
    }

    public function userIsAgent(Request $request){
        $uid = $request->uid;
        $ruid = $request->ruid;
        $isagent = User::where(['userid'=>$uid,'ruid'=>$ruid])->value('ifagent');
        return AppJson::success('ok', ['isagent' => $isagent]);
    }

    public static function getBalanceInfo(Request $request){
        $uid = $request->uid;
        $ruid = $request->ruid;
        $res = UserService::getBalanceInfo($uid,$ruid);
        return AppJson::success('ok',$res);
    }
    
    //设置初始密码
    public function initFirstPwd(Request $request){
        $newPwd = $request->input('newPwd','');
        if(empty($newPwd)){
            return AppJson::error('请输入密码');
        }
        //校验密码8-16位
        if(!preg_match('/^[a-zA-Z0-9]{8,16}$/', $newPwd)){
            return AppJson::error('密码必须包含大小写字母和数字，长度8-16位');
        }
        $uid = $request->uid;
        $userreg = Userreg::where('userid', $uid)->select(['passtime'])->first();
        if($userreg['passtime'] > 0){
            return AppJson::error('密码已设置，请勿重复设置');
        }
        $newPwd = md5($newPwd.x_config('upass'));
        Userreg::where('userid', $uid)->update(['passtime' => time(),'userpass' => $newPwd]);
        return AppJson::success('密码设置成功');
    }
}
