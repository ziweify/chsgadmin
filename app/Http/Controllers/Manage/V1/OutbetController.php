<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\OutbetAccs;
use App\Models\Game\OutbetSite;
use App\Models\Game\User;
use App\ort\common\Constants;
use App\ort\HttpUtils;
use App\ort\services\CommonServices;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;
use voku\helper\HtmlDomParser;

class OutbetController extends ManageAuthController
{

    public function config(Request $request){
        $userid = $request->input('userid','');
        $plat_outbet_status = x_config('plat_outbet_status');
        if (!in_array('flyout',$this->auths) || $plat_outbet_status == 0) {
            return view('common.noauth');
        }
        //查询所有已开启的飞单代理
        /*if($this->adminInfo['ifhide'] == 1){
            $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->select(['userid','username'])->get();
        }else{
            $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->where('layer','>',0)->select(['userid','username'])->get();
        }*/
        $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->select(['userid','username'])->get();
        view()->share('flyuserlist',$flyuserlist);
        if(empty($userid)){
            $userid = $flyuserlist[0]['userid'];
        }
        $user = User::where('userid',$userid)->select(['outbet_status','outbet_switch','username','outbet_mode'])->first();
        $list = (new CommonServices())->outbet_config($userid,$this->adminInfo['ifhide'],$this->adminid);
        view()->share('outbet_switch',$user['outbet_switch']);
        view()->share('outbet_mode',$user['outbet_mode']);
        view()->share('list',$list);
        view()->share('username',$user['username']);
        view()->share('ht',1);
        view()->share('userid',$userid);
        view()->share('ifhide',$this->adminInfo['ifhide']);
        view()->share('outbet_name', x_config('outbet_name'));
        return view('common.outbet.config');
    }

    public function saveconfig(Request $request){
        $enabled = $request->input('enabled',0);
        $outbet_mode = $request->input('outbet_mode',1);
        $userid = $request->input('userid','');
        $plat_outbet_status = x_config('plat_outbet_status');
        $outbet_status = User::where('userid',$userid)->value('outbet_status');
        if ($plat_outbet_status == 0) {
            return Json::error('平台未开放权限');
        }
        if ($outbet_status == 0) {
            return Json::error('用户未开启飞单权限');
        }
        User::where('userid',$userid)->update(['outbet_switch'=>$enabled,'outbet_mode'=>$outbet_mode]);
        return Json::success('保存成功');
    }

    public function site(Request $request){
        $id = $request->input('id','');
        $userid = $request->input('userid','');
        $user = User::where('userid',$userid)->select(['outbet_status','username','layer'])->first();
        $plat_outbet_status = x_config('plat_outbet_status');
        if ($user['outbet_status'] == 0 || $plat_outbet_status == 0) {
            return view('common.noauth');
        }
        $layers = json_decode(x_config('layer'),true);
        (new CommonServices())->outbet_site($id,$userid,$this->adminInfo['ifhide'],$this->adminid);
        view()->share('ht',1);
        view()->share('userid',$userid);
        view()->share('username',$user['username']);
        $isshowfantou = 0;$fly_fantou = x_config('fly_fantou');
        if($this->adminInfo['ifhide'] == 1 || $fly_fantou == 1){
            $isshowfantou = 1;
        }
        view()->share('ifhide',$isshowfantou);
        view()->share('adminid',$this->adminid);
        view()->share('layername',$user['layer'] > 0 ? $layers[$user['layer']-1] : '总监');
        view()->share('outbet_name', x_config('outbet_name'));
        return view('common.outbet.site');
    }

    public function delsite(Request $request){
        $id = $request->input('id','');
        $userid = $request->input('userid','');
        $plat_outbet_status = x_config('plat_outbet_status');
        $outbet_status = User::where('userid',$userid)->value('outbet_status');
        if ($plat_outbet_status == 0) {
            return Json::error('平台未开放权限');
        }
        if ($outbet_status == 0) {
            return Json::error('用户未开启飞单权限');
        }
        $site = OutbetSite::where(['id'=>$id,'userid'=>$userid])->first();
        if(!$site){
            return Json::error('站点不存在');
        }
        $site->delete();
        OutbetAccs::where(['siteid'=>$id])->delete();
        return Json::success('删除成功');
    }

    public function siteenabled(Request $request){
        $enabled = $request->input('enabled',1);
        $id = $request->input('id','');
        OutbetSite::where(['id'=>$id])->update(['enabled'=>$enabled]);
        return Json::success('操作成功');
    }

    public function savesite(Request $request){
        $accs = $request->input('accs','');
        $site = $request->input('site','');
        $siteid = $request->input('siteid','');
        $userid = $site['userid'];
        unset($site['userid']);
        $cuser = User::where('userid',$userid)->select(['layer','outbet_status'])->first();
        $plat_outbet_status = x_config('plat_outbet_status');
        if ($plat_outbet_status == 0) {
            return Json::error('平台未开放权限');
        }
        if ($cuser['outbet_status'] == 0) {
            return Json::error('用户未开启飞单权限');
        }
        $res = (new CommonServices())->outbet_savesite($userid,$siteid,$accs,$site,$cuser,$this->adminInfo['ifhide']);
        if($res['code'] == 1){
            return Json::success($res['msg']);
        }else{
            return Json::error($res['msg']);
        }
    }

    public function downlines(Request $request){
        $ifagent = $request->input('ifagent', 0);
        $sourceUsername = $request->input('sourceUsername', '');
        $userid = $request->input('userid', '');
        $usernames = (new CommonServices())->outbet_downlines($userid,$ifagent,$sourceUsername);
        return response()->json($usernames)->content();
    }

    public function error(Request $request){
        $userid = $request->input('userid','');
        $plat_outbet_status = x_config('plat_outbet_status');
        if (!in_array('flyout',$this->auths) || $plat_outbet_status == 0) {
            return view('common.noauth');
        }
        //查询所有已开启的飞单代理
        /*if($this->adminInfo['ifhide'] == 1){
            $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->select(['userid','username'])->get();
        }else{
            $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->where('layer','>',0)->select(['userid','username'])->get();
        }*/
        $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->select(['userid','username'])->get();
        view()->share('flyuserlist',$flyuserlist);
        if(empty($userid)){
            $userid = $flyuserlist[0]['userid'];
        }
        $user = User::where('userid',$userid)->select(['outbet_status','username'])->first();
        $list = (new CommonServices())->outbet_error($userid,$this->adminInfo['ifhide'],1,$this->adminid);
        view()->share('list',$list);
        view()->share('username',$user['username']);
        view()->share('outbet_name', x_config('outbet_name'));
        view()->share('ht',1);
        return view('common.outbet.error');
    }

    public function bets(Request $request){
        $date = $request->input('date', '');
        $status = $request->input('status', '');
        $page = $request->input('page', 1);
        $userid = $request->input('userid', '');
        //$user = User::where('userid',$userid)->select(['outbet_status','username'])->first();
        $plat_outbet_status = x_config('plat_outbet_status');
        if (!in_array('flyout',$this->auths) || $plat_outbet_status == 0) {
            return view('common.noauth');
        }
        (new CommonServices())->outbet_bets($userid,$date,$status,$page,$this->adminInfo['ifhide'],1,$this->adminid);
        //view()->share('username',$user['username']);
        view()->share('ht',1);
        view()->share('userid',$userid);
        view()->share('outbet_name', x_config('outbet_name'));
        //查询所有已开启的飞单代理
        /*if($this->adminInfo['ifhide'] == 1){
            $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->select(['userid','username'])->get();
        }else{
            $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->where('layer','>',0)->select(['userid','username'])->get();
        }*/
        $flyuserlist = User::where(['outbet_status'=>1,'status'=>0])->select(['userid','username'])->get();
        view()->share('flyuserlist',$flyuserlist);
        return view('common.outbet.bets');
    }

    public function qiehuan(Request $request){
        $siteid = $request->input('siteid','');
        $site = OutbetSite::where('id',$siteid)->first();
        if(!$site){
            return Json::error('站点不存在');
        }
        $main_site_id = $site['main_site_id'];
        OutbetSite::where('id',$main_site_id)->update(['main_fu_type'=>2,'main_site_id'=>$siteid]);
        OutbetSite::where('id',$siteid)->update(['main_fu_type'=>1,'main_site_id'=>0]);
        return Json::success('切换成功');
    }

    public function outbet_bhdata(Request $request){
        $accid = $request->input('accid', '');
        $type = $request->input('type', 1);
        $acc = OutbetAccs::where(['id'=>$accid])->first();
        $site = OutbetSite::where(['id'=>$acc['siteid']])->first();
        if(empty($acc)){
            return Json::error('账号不存在');
        }
        if($acc['online'] == 0){
            return Json::error('账号已离线');
        }
        if($site['bet_mode'] == 2){
            return Json::error('API模式不支持');
        }
        if($type == 1){//未结算注单
            $url = $acc['curl'].'/member/bets';
        }else{//报表
            $url = $acc['curl'].'/member/history';
        }
        $cookie_jar = $acc['cookie'];
        $tableHtml = '';
        try {
            $html = HttpUtils::curl('GET',true,$cookie_jar,$url,[],[],true,true,false,$acc['id']);
            $dom = new HtmlDomParser($html);
            if($type == 1){//未结算注单
                $tableElement = $dom->find('table', 0);
            }else{
                $tableElement = $dom->find('div.history', 0);
            }
            if ($tableElement) {
                $tableHtml = $tableElement->outertext;
            }
        }catch (\Exception $e){
            $tableHtml = '获取数据失败';
        }
        return Json::success('ok',['html'=>$tableHtml]);
    }
}
