<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\CustomDomain;
use App\Models\Game\Config;
use App\Models\Game\Web;
use App\ort\HttpUtils;
use App\ort\services\AliyunDomainService;
use App\ort\services\AwsDomainService;
use App\ort\services\BtServices;
use App\ort\services\ConfigService;
use App\ort\services\XwebService;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use voku\helper\HtmlDomParser;

class YsbConfigController extends ManageAuthController
{

    public function page(Request $request){
        view()->share('webname',x_config('webname'));
        return view('managev1.setting.ysbconfig');
    }


    public function login138(){
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
            //缓存登陆成功状态
            Cache::put('sglogin'.$postdata['txtUserName'],1,60);
            return 1;
        }else{
            return 0;
        }
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
            return 1;
        }else{
            return 0;
        }
    }

    public function saveanquanma(Request $request){
        $istest = env('TEST_PLATFORM');
        if($istest == 1 && $this->adminInfo['ifhide'] == 0){
            return Json::error('测试平台不允许修改');
        }
        $is_openmodifyanquanma = x_config('is_openmodifyanquanma');
        if ($is_openmodifyanquanma == 0){
            return Json::error('系统已关闭修改安全码');
        }
        $iskjw = $request->input('iskjw',1);
        $anquanma = $request->input('anquanma','');
        $anquanmagl = $request->input('anquanmagl','');
        $isip = $request->input('isip',0);
        $webname = $request->input('webname','');
        if(empty($anquanma) || empty($anquanmagl)  || empty($webname)){
            return Json::error('请填写正确');
        }
        $use_dlswgindh = x_config('use_dlswgindh');
        if($use_dlswgindh == 0){
            //先登陆138导航
            $islogin = Cache::get('sglogin'.x_config('sgaccount'));
            if(empty($islogin)){
                $ret = $this->login138();
                if($ret == 0){
                    return Json::error('登陆138导航失败,请重试。');
                }
            }
            //删除导航
            $ret = $this->del138daohang();
            if($ret == 0){
                return Json::error('删除138导航失败,请重试。');
            }
            //添加会员代理端导航
            $ret = $this->add138daohang($anquanma,$anquanmagl,$webname,1,$iskjw);
            if($ret != 1){
                return Json::error($ret);
            }
            //添加管理端导航
            $ret = $this->add138daohang($anquanma,$anquanmagl,$webname,2,$iskjw);
            if($ret != 1){
                return Json::error($ret);
            }
        }else{
            $sgwindh_api = x_config('sgwindh_api');
            $current_sort = x_config('current_sort');
            $jsonlist = [];
            //查询会员端域名
            $domainlist = CustomDomain::where(['type'=>5])->get();
            foreach ($domainlist as $k=>$v){
                //是否包含:如果包含跳过
                if(strpos($v['domain'],':') !== false){
                    if($isip == 1){
                        $jsonlist[] = [
                            'title' => "会员IP线路".($k+1),
                            'url' => "http://".$v['domain'],
                        ];
                    }
                    continue;
                }
                $jsonlist[] = [
                    'title' => "会员线路".($k+1),
                    'url' => "https://".$v['domain'],
                ];
            }
            //查询代理端域名
            $domainlist = CustomDomain::where(['type'=>4])->get();
            foreach ($domainlist as $k=>$v){
                //是否包含:如果包含跳过
                if(strpos($v['domain'],':') !== false){
                    if($isip == 1){
                        $jsonlist[] = [
                            'title' => "代理IP线路".($k+1),
                            'url' => "http://".$v['domain'],
                        ];
                    }
                    continue;
                }
                $jsonlist[] = [
                    'title' => "代理线路".($k+1),
                    'url' => "https://".$v['domain'],
                ];
            }
            //是否写入开奖网
            if($iskjw == 1){
                $jsonlist[] = [
                    'title' => "开奖网",
                    'url' => x_config('kfurl'),
                ];
            }
            //网络请求保存到api
            $postdata = [];
            $postdata['code'] = $anquanma;
            $postdata['data'] = json_encode($jsonlist,JSON_UNESCAPED_UNICODE);
            $postdata['site_name'] = $webname;
            $postdata['type'] = 1;
            $postdata['zhiding_dh'] = '';
            $postdata['site_sort'] = $current_sort;
            $res = HttpUtils::request('POST',$sgwindh_api,$postdata,[],false);
            $re =  $res['data'];
            $json = json_decode($re,true);
            if($json['code'] != 1){
                return Json::error($json['msg']);
            }
            //管理端
            $gllist = CustomDomain::where(['type'=>3])->get();
            $jsonlist = [];
            foreach ($gllist as $k=>$v){
                //是否包含:如果包含跳过
                if(strpos($v['domain'],':') !== false){
                    if($isip == 1){
                        $jsonlist[] = [
                            'title' => "管理IP线路".($k+1),
                            'url' => "http://".$v['domain'],
                        ];
                    }
                    continue;
                }
                $jsonlist[] = [
                    'title' => "管理线路".($k+1),
                    'url' => "https://".$v['domain'],
                ];
            }
            //是否写入开奖网
            if($iskjw == 1){
                $jsonlist[] = [
                    'title' => "开奖网",
                    'url' => x_config('kfurl'),
                ];
            }
            //网络请求保存到api
            $postdata = [];
            $postdata['code'] = $anquanmagl;
            $postdata['data'] = json_encode($jsonlist,JSON_UNESCAPED_UNICODE);
            $postdata['site_name'] = $webname;
            $postdata['type'] = 2;
            $postdata['zhiding_dh'] = '';
            $postdata['site_sort'] = $current_sort;
            $res = HttpUtils::request('POST',$sgwindh_api,$postdata,[],false);
            $re =  $res['data'];
            $json = json_decode($re,true);
            if($json['code'] != 1){
                return Json::error($json['msg']);
            }
        }
        //修改安全码
        $anquanma = strtoupper($anquanma);
        $anquanmagl = strtoupper($anquanmagl);
        //保存账号密码
        Config::where('id',1)->update(['anquanma'=>$anquanma,'anquanmagl'=>$anquanmagl]);
        //清理缓存
        ConfigService::clearSingle('anquanma');
        ConfigService::clearSingle('anquanmagl');
        //修改网站名称
        $webname = trim($webname);
        Web::where('id',1)->update(['webname'=>$webname]);
        //清理缓存
        XwebService::clearSingle('webname');
        return Json::success('保存成功');
    }

    public function add138daohang($anquanma,$anquanmagl,$webname,$type,$iskjw){
        $domain = x_config('dh_138_url');
        $url = $domain.'/ajax/save-site.php';
        $cookie_jar = base_path().'/upload/cookie/'.x_config('sgaccount').".txt";
        $postdata = [];
        $postdata['siteName'] = $webname;
        $postdata['group1'] = 'on';
        $postdata['regdate2'] = [];
        $postdata['announcement'] = []; //公告
        if ($type == 1){//生成会员代理端导航
            $postdata['siteToken'] = $anquanma;
            $domainlist = CustomDomain::where(['type'=>5])->get();
            $webName = [];$webDomain = [];$status = [];$regdate = [];
            foreach ($domainlist as $k=>$v){
                //是否包含:如果包含跳过
                if(strpos($v['domain'],':') !== false){
                    continue;
                }
                $webName[] = "会员线路".($k+1);
                $webDomain[] = "https://".$v['domain'];
                $status[] = '';
                $regdate[] = '';
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
            $postdata['siteToken'] = $anquanmagl;
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
            return 1;
        }else{
            return $json['msg'];
        }
    }

}
