<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\CustomDomain;
use App\Models\Game\Config;
use App\ort\HttpUtils;
use App\ort\services\AliyunDomainService;
use App\ort\services\AwsDomainService;
use App\ort\services\BtServices;
use App\ort\services\ConfigService;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use voku\helper\HtmlDomParser;

class DomainController extends ManageAuthController
{

    public function list(Request $request){
        //会员端
        $hylist = CustomDomain::where(['type'=>5])->get();
        //代理端
        //$dllist = CustomDomain::where(['type'=>4])->get();
        //管理端
        $gllist = CustomDomain::where(['type'=>3])->get();
        //开奖网
        //$kjwlist = CustomDomain::where(['type'=>2])->get();
        $list = [];
        $list[] = ['type'=>5,'name'=>'会员代理端','color'=>'green','list'=>$hylist];
        //$list[] = ['type'=>4,'name'=>'代理端','color'=>'blue','list'=>$dllist];
        $list[] = ['type'=>3,'name'=>'管理端','color'=>'red','list'=>$gllist];
        //$list[] = ['type'=>2,'name'=>'开奖网','color'=>'orange','list'=>$kjwlist];
        view()->share('list',$list);
        return view('managev1.setting.domain.list');
    }

    public function save(Request $request){
        $type = $request->input('type',0);
        $domainlist = $request->input('domainlist','');

        $db = Db::connection();
        $db->beginTransaction();;
        //先删除
        CustomDomain::where(['type'=>$type])->delete();
        //再添加
        $savelist = [];
        foreach ($domainlist as $v){
            if(empty($v['domain'])){
                continue;
            }
            $save = [];
            $save['domain'] = $v['domain'];
            $save['type'] = $type;
            $save['status'] = $v['status'];
            $save['custom_id'] = 1;
            $save['create_time'] = time();
            $savelist[] = $save;
        }
        $res = CustomDomain::insert($savelist);
        if($res){
            $db->commit();
            return Json::success('保存成功');
        }else{
            $db->rollBack();
            return Json::error('保存失败');
        }
    }

    public function delete(Request $request){
        $id = $request->input('id','');
        CustomDomain::where(['id'=>$id])->delete();
        return Json::success('删除成功');
    }

    public function saveawsandbt(Request $request){
        $type = $request->input('type',0);
        $domainlist = $request->input('domainlist','');
        $domianarr = []; $domain_service = x_config('domain_service');
        foreach ($domainlist as $v){
            $id = $v['id'];
            if(empty($id)){
                continue;
            }
            $olddomian = CustomDomain::where(['id'=>$id])->first();
            if(empty($olddomian)){
                return Json::error('请选保存数据');
            }
            if($domain_service == 1){
                $domianarr[] = $olddomian['domain'];
            }else{
                $domianarr[] = ['domain'=>$olddomian['domain'],'id'=>$olddomian['id']];
            }
        }
        $domainstr = implode(',', array_column($domianarr,'domain'));
        $msg = "";
        //先保存aws
        $public_ip = x_config('public_ip');
        if($domain_service == 1) {
            $res = AwsDomainService::addDomain($domainstr, $public_ip);
        }else{
            $res = AliyunDomainService::addrecord($domianarr,$public_ip);
        }
        $msg .= "yun:".$res['msg'].'<br>';
        //保存bt
        $bt_siteids = x_config('bt_siteids');
        $res = (new BtServices())->adddomian($bt_siteids,$domainstr);
        $msg .= "bt:".(isset($res['msg'])?$res['msg']: json_encode($res,JSON_UNESCAPED_UNICODE));
        return response()->json(['code'=>1,'msg'=>$msg]);
    }

    public function delawsandbt(Request $request){
        $type = $request->input('type',0);
        $domainlist = $request->input('domainlist','');
        $domianarr = [];$domain_service = x_config('domain_service');
        foreach ($domainlist as $v){
            $id = $v['id'];
            if(empty($id)){
                continue;
            }
            $olddomian = CustomDomain::where(['id'=>$id])->first();
            if(empty($olddomian)){
                return Json::error('请选保存数据');
            }
            if($domain_service == 1){
                $domianarr[] = $olddomian['domain'];
            }else{
                $domianarr[] = ['record_id'=>$olddomian['record_id'],'domain'=>$olddomian['domain']];
            }
        }
        $domainstr = implode(',', array_column($domianarr,'domain'));
        $msg = "";
        //aws
        $public_ip = x_config('public_ip');
        if($domain_service == 1){
            $res = AwsDomainService::deleteDomain($domainstr,$public_ip);
        }else{
            $res = AliyunDomainService::deleteDomain($domianarr);
        }
        $msg .= "yun:".$res['msg'].' ';
        //bt
        $bt_siteids = x_config('bt_siteids');
        foreach ($domianarr as $domain){
            $res = (new BtServices())->deldomain($bt_siteids,$domain['domain']);
            $msg .= "bt:".$res['msg'];
        }
        return response()->json(['code'=>1,'msg'=>$msg]);
    }

    public function suijiregister(Request $request){
        $type = $request->input('type',1);
        if($type == 1){
            $sgaccount = $request->input('sgaccount','');
            $sgpassword = $request->input('sgpassword','');
            //保存账号密码
            Config::where('id',1)->update(['sgaccount'=>$sgaccount,'sgpassword'=>$sgpassword]);
            //清理缓存
            ConfigService::clearSingle('sgaccount');
            ConfigService::clearSingle('sgpassword');
            return Json::success('保存成功');
        }else{
            $sgaccount = $this->randaccount('sg');
            $sgpassword = $this->randaccount('sg');

            $domain = x_config('dh_138_url');
            $url = $domain.'/ajax/register.php';
            $postdata = [];
            $postdata['userName'] = $sgaccount;
            $postdata['userPwd'] = $sgpassword;
            $postdata['userPwd1'] = $sgpassword;
            $postdata['userEmail'] = $sgaccount.'@qq.com';
            $result = HttpUtils::curl('POST',true,'',$url,$postdata,[],true,true,false,0);
            $json = json_decode($result,true);
            if($json['code'] == 1){
                //保存账号密码
                Config::where('id',1)->update(['sgaccount'=>$sgaccount,'sgpassword'=>$sgpassword]);
                //清理缓存
                ConfigService::clearSingle('sgaccount');
                ConfigService::clearSingle('sgpassword');
                return Json::success('注册成功');
            }else{
                return Json::error($json['msg']);
            }
        }
    }

    public function randaccount($pre){
        //随机生成账号8-12位
        $account = $pre;
        $len = rand(8,12);
        for($i=0;$i<$len;$i++){
            $account .= rand(0,9);
        }
        return $account;
    }

    public function login138(Request $request){
        $type = $request->input('type',1);
        $domain = x_config('dh_138_url');
        $url = $domain.'/ajax/login.php';
        $postdata = [];
        $postdata['txtUserName'] = x_config('sgaccount');
        $postdata['txtUserPwd'] = x_config('sgpassword');
        $cookie_jar = base_path().'/upload/cookie/'.$postdata['txtUserName'].".txt";
        //先删除cookie
        if(file_exists($cookie_jar)){
            unlink($cookie_jar);
        }
        $res = HttpUtils::bdcurl($cookie_jar,$url,$postdata,[],true,true,false);
        $json = json_decode($res['data'],true);
        if($json['code'] == 1){
            return Json::success('登录成功');
        }else{
            return Json::error($json['msg']);
        }
    }

    public function get138sitelist(){
        $list = $this->get138sitelistcom();
        return Json::success(json_encode($list,JSON_UNESCAPED_UNICODE),$list);
    }

    public function get138sitelistcom(){
        $domain = x_config('dh_138_url');
        $url = $domain.'/user-page-domain.php';
        $cookie_jar = base_path().'/upload/cookie/'.x_config('sgaccount').".txt";
        $res = HttpUtils::bdcurl($cookie_jar,$url,[],[],true,false,false);
        //html解析
        $html = $res['data'];
        $dom = new HtmlDomParser($html);
        $tableElements = $dom->find('#deleteSiteForm .card');
        $list = [];
        foreach ($tableElements as $k=>$element) {
            //获取属性data-id
            $dataid = $element->find('a.modaledit')[0]->getAttribute('data-id');
            $list[$k]['id'] = $dataid;
            //获取class为modaledit下面的p标签内容
            $pElements = $element->find('.modaledit p');
            $name = $pElements[0]->text();
            $list[$k]['name'] = $name;
            //获取class为token 下面span
            $spanElements = $element->find('.token span');
            $token = $spanElements[0]->text();
            $list[$k]['token'] = $token;
            if($token == x_config('anquanma') || $token == x_config('anquanmagl')){
                $list[$k]['token'] = $list[$k]['token'].'(当前)';
            }
        }
        return $list;
    }

    public function del138daohang(){
        $list = $this->get138sitelistcom();
        $checksiteid = [];
        foreach ($list as $v){
            $checksiteid[] = $v['id'];
        }
        $domain = x_config('dh_138_url');
        $url = $domain.'/ajax/delete-site.php';
        $cookie_jar = base_path().'/upload/cookie/'.x_config('sgaccount').".txt";
        $postdata = [];
        $postdata['checksiteid'] = $checksiteid;
        $res = HttpUtils::bdcurl($cookie_jar,$url,$postdata,[],true,true,false);
        $json = json_decode($res['data'],true);
        if($json['code'] == 1){
            return Json::success('删除成功');
        }else{
            return Json::error($json['msg']);
        }
    }

    public function add138daohang(Request $request){
        $type = $request->input('type',1);
        $iskjw = $request->input('iskjw',1);
        $anquanma = $request->input('anquanma','');
        $anquanmagl = $request->input('anquanmagl','');
        if($anquanma != x_config('anquanma') || $anquanmagl != x_config('anquanmagl')){
            return Json::error('请先保存安全码');
        }
        $domain = x_config('dh_138_url');
        $url = $domain.'/ajax/save-site.php';
        $cookie_jar = base_path().'/upload/cookie/'.x_config('sgaccount').".txt";
        $postdata = [];
        $postdata['siteName'] = x_config('webname');
        $postdata['group1'] = 'on';
        $postdata['announcement'] = []; //公告
        $postdata['regdate2'] = [];
        if ($type == 1){//生成会员代理端导航
            $postdata['siteToken'] = x_config('anquanma');
            //查询会员端域名
            $domainlist = CustomDomain::where(['type'=>5])->get();
            $webName = [];$webDomain = [];$status = [];$regdate = [];
            foreach ($domainlist as $k=>$v){
                //是否包含:如果包含跳过
                if(strpos($v['domain'],':') !== false){
                    continue;
                }
                $webName[] = "会员线路".($k+1);
                $webDomain[] = "https://".$v['domain'];
                if($k != 0){
                    $status[] = '';
                    $regdate[] = '';
                }
            }
            //查询代理端域名
            $domainlist = CustomDomain::where(['type'=>4])->get();
            foreach ($domainlist as $k=>$v){
                //是否包含:如果包含跳过
                if(strpos($v['domain'],':') !== false){
                    continue;
                }
                $webName[] = "代理线路".($k+1);
                $webDomain[] = "https://".$v['domain'];
                $status[] = '';
                $regdate[] = '';
            }
            //是否写入开奖网
            if($iskjw == 1){
                $webName[] = "开奖网";
                $webDomain[] = x_config('kfurl');
                $status[] = '';
                $regdate[] = '';
            }
            $postdata['webName'] = $webName;
            $postdata['webDomain'] = $webDomain;
            $postdata['status'] = $status;
            $postdata['regdate'] = $regdate;
        }else{//生成管理端导航
            $postdata['siteToken'] = x_config('anquanmagl');
            //查询管理端域名
            $webName = [];$webDomain = [];$regdate = [];$status = [];
            $domainlist = CustomDomain::where(['type'=>3])->get();
            foreach ($domainlist as $k=>$v){
                //是否包含:如果包含跳过
                if(strpos($v['domain'],':') !== false){
                    continue;
                }
                $webName[] = "管理线路".($k+1);
                $webDomain[] = "https://".$v['domain'];
                $status[] = '';
                $regdate[] = '';
            }
            //是否写入开奖网
            if($iskjw == 1){
                $webName[] = "开奖网";
                $webDomain[] = x_config('kfurl');
                $status[] = '';
                $regdate[] = '';
            }
            $postdata['webName'] = $webName;
            $postdata['webDomain'] = $webDomain;
            $postdata['status'] = $status;
            $postdata['regdate'] = $regdate;
        }
        $header = [
            "Accept:application/json, text/javascript, */*; q=0.01",
            "Content-Type:application/x-www-form-urlencoded; charset=UTF-8",
            "Host:013806.app",
            "Origin:https://013806.app",
            "Referer:https://013806.app/user-page-domain.php",
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko)',
            'X-Requested-With: XMLHttpRequest'
        ];
        $res = HttpUtils::bdcurl($cookie_jar,$url,$postdata,$header,true,true,false);
        $json = json_decode($res['data'],true);
        if($json['code'] == 1){
            return Json::success('添加成功');
        }else{
            return Json::error($json['msg']);
        }
    }

    public function saveanquanma(Request $request){
        $type = $request->input('type',1);
        $anquanma = $request->input('anquanma','');
        $anquanmagl = $request->input('anquanmagl','');
        //转成大写
        $anquanma = strtoupper($anquanma);
        $anquanmagl = strtoupper($anquanmagl);
        //保存账号密码
        Config::where('id',1)->update(['anquanma'=>$anquanma,'anquanmagl'=>$anquanmagl]);
        //清理缓存
        ConfigService::clearSingle('anquanma');
        ConfigService::clearSingle('anquanmagl');
        return Json::success('保存成功');
    }
}
