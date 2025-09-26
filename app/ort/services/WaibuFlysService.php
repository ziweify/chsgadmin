<?php


namespace App\ort\services;


use App\Models\Game\Flyinfo;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\common\Json;
use Illuminate\Support\Facades\DB;

class WaibuFlysService
{
    public function delfly($pass,$id){
        if ($pass != x_config('supass')) {
            return Json::error('密码错误');
        }
        $db = Db::connection();
        $userid = Constants::$SUID;
        $db->delete("delete from x_flyinfo where userid='{$userid}' and id='{$id}'");
        return Json::success('删除成功');
    }

    public function flygetcode($fid){
        $userid = Constants::$SUID;
        $db = Db::connection();
        $fly = Flyinfo::where(['userid'=>$userid,'id'=>$fid,'isable'=>1])->first();
        if (empty($fly)) {
            return Json::success('ok',["status" => 0, "data" => "请先启用"]);
        }
        $cookie_jar = base_path().'/upload/cookie/' . $fly['userid'] . $fid . ".txt";
        //判断文件是否存在，存在则删除
        if (file_exists($cookie_jar)) {
            unlink($cookie_jar);
        }
        $c = '/uploads/' . $fly['userid'] . $fid . rand(111, 999) . ".png";
        $b = '/public'.$c;
        $code = base_path().$b;
        ComFunc::delcode(base_path().'/upload/');
        $ip = ComFunc::Rand_IP();
        Flyinfo::where(['id'=>$fly['id']])->update(['ip'=>$ip]);
        switch ($fly['webtype']) {
            case 'IDC':
                $url = trim($fly['url1']) . '/search.aspx';
                $data=["wd"=>$fly['searchcode']];
                $send = ["headip" => $ip, "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => true, "postdata" => $data,'head'=>true, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                $res = ComFunc::CURL($send);
                preg_match_all('/src="(.*)"/isU', $res["res"], $output);
                $url = $output[1][0];
                $url = explode('?', $url);
                $urls = $url[0] . '/indexmb.aspx?'.$url[1];
                $send = ["headip" => $ip, "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $urls, "posttype" => false, "postdata" => [],'head'=>true, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                $res = ComFunc::CURL($send);
                preg_match_all('/value="(.*)"/isU', $res["res"], $output);
                $data=[];
                $data["__VIEWSTATE"] = $output[1][0];
                $data["__VIEWSTATEGENERATOR"] = $output[1][1];
                $data["__RequestVerificationToken"] = $output[1][2];

                preg_match_all('/action="(.*)"/isU', $res["res"], $output);
                $data["action"] = substr($output[1][0],2);
                $data["action"] = str_replace('&amp;', '&', $data['action']);
                $cookie = json_encode($data);

                $db->update("update x_flyinfo set url3='{$url[0]}',url4='{$url[1]}',cookie='$cookie' where id='{$fly['id']}'");

                $url = $url[0]."/checknum.aspx?ts=".time();
                $send = ["headip" => $ip, "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => false, "postdata" => [], "head" => false, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                $res = ComFunc::CURL($send);
                $fp = fopen($code, "w");
                fwrite($fp, $res["res"]);
                fclose($fp);
                $arr = ["status" => 1, "data" => $c, 'webtype' => $fly['webtype']];
                break;
            case 'SGWIN':
                $url = trim($fly['url1']) . '/login';
                $send = ["headip" => $ip, "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => false, "postdata" => [],'head'=>true, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                $res = ComFunc::CURL($send);
                //$res = curls($cookie_jar, $url, false, "", true);
                $url = trim($fly['url1']) . '/code?_=' . time();
                $send = ["headip" => $ip, "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => false, "postdata" => [], "head" => false, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                $res = ComFunc::CURL($send);
                //$res = curls($cookie_jar, $url, false, "", true,false);
                //list($header, $body) = explode("\r\n\r\n", $res["res"]);
                $fp = fopen($code, "w");
                fwrite($fp, $res["res"]);
                fclose($fp);
                $arr = ["status" => 1, "data" => $c, 'webtype' => $fly['webtype']];
                break;
        }
        return Json::success('ok',$arr);
    }

    public function flylogin($fid,$code){
        $userid = Constants::$SUID;
        $fly = Flyinfo::where(['userid'=>$userid,'id'=>$fid,'isable'=>1])->first();
        if (empty($fly)) {
            return Json::success('ok',['status'=>0,'data'=>'请先启用']);
        }
        $cookie_jar = base_path().'/upload/cookie/' . $fly['userid'] . $fid . ".txt";
        switch ($fly['webtype']) {
            case "IDC":
                $cookie = json_decode($fly["cookie"],true);
                $url = trim($fly['url3']) . '/'.$cookie["action"];
                unset($cookie["action"]);
                $post = ['txt_U_name' => $fly['username'], 'txt_U_Password' => $fly['passwd'], 'txt_validate' => $code];
                $post = array_merge($post,$cookie);
                $send = ["headip" => $fly["ip"], "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => true, "postdata" => $post, "head" => false, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                $res = ComFunc::CURL($send);
                $result = $res["res"];
                if(strpos($res["res"],'ch/agreement.aspx')!==false){
                    $arr = ["status" => 200, "data" => "登陆成功"];
                }else{
                    $arr = ComFunc::sgwingetcode($fly, $cookie_jar);
                    $arr['err'] = '账号或密码错误';
                    $arr["message"] = $result;
                }
                break;
            case 'SGWIN':
                $url = trim($fly['url1']) . '/login';
                $code = $_REQUEST['imgcode'];
                $post = ['type' => '1', 'account' => $fly['username'], 'password' => $fly['passwd'], 'code' => $code];
                $send = ["headip" => $fly["ip"], "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => true, "postdata" => $post, "head" => true, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                $res = ComFunc::CURL($send);
                $result = $res["res"];
                if (strpos($result, '验证码错误') !== false) {
                    $arr = ComFunc::sgwingetcode($fly, $cookie_jar);
                    $arr['err'] = '验证码错误';
                    $arr["message"] = $result;
                } else {
                    if (strpos($result, '账号或密码错误') !== false) {
                        $arr = ComFunc::sgwingetcode($fly, $cookie_jar);
                        $arr['err'] = '账号或密码错误';
                        $arr["message"] = $result;
                    } else {
                        if (strpos($result, '用户协议') !== false) {
                            $arr = ["status" => 200, "data" => "登陆成功"];
                        } else {
                            $arr = ComFunc::sgwingetcode($fly, $cookie_jar);
                            $arr['err'] = '账号或密码错误';
                            $arr["message"] = $result;
                            $arr["url"] = $url;
                        }
                    }
                }
                break;
        }
        return Json::success('ok',$arr);
    }

    public function getflystatus($fid){
        $userid = Constants::$SUID;
        $db = Db::connection();
        $fly = Flyinfo::where(['userid'=>$userid,'id'=>$fid,'isable'=>1])->first();
        if (empty($fly)) {
            return Json::error('请先启用');
        }
        $cookie_jar = base_path().'/upload/cookie/' . $fly['userid'] . $fid . ".txt";
        $arr["webtype"] = $fly["webtype"];
        try {
            switch ($fly['webtype']) {
                case "IDC":
                    $refer = trim($fly['url3'])."ch/main.aspx";
                    $url = trim($fly['url3']) . 'app/ws_member.asmx/MembersInfo_Data';
                    $data="";
                    $send = ["headip" => $fly["ip"], "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => true, "postdata" => $data, "head" => false, "location" => true,"refer"=>$refer, "sslhostflag" => true,"json"=>true];
                    $res = ComFunc::CURL($send);
                    $res = str_replace('\\', '', $res["res"]);
                    $res = explode('{"Rows":[', $res);
                    $res = explode(']}]', $res[1]);
                    $data = json_decode($res[0],true);
                    $arr['balance'] = $data["allowcreditquota"];
                    $arr['loginuser'] = $data['memberno'];
                    $arr['name'] = $fly['name'];
                    $arr['wjs'] = $data["usecreditquota"];
                    //$arr["sy"] = ComFunc::pr2($arr['balance'] - $data["creditquota"]);
                    $arr["sy"] = ComFunc::pr1($data["usecreditquota2"]);
                    if($data["opena"]=='true'){
                        $abcd='A';
                    }else if($data["openb"]=='true'){
                        $abcd='B';
                    }else if($data["openc"]=='true'){
                        $abcd='C';
                    }else if($data["opend"]=='true'){
                        $abcd='D';
                    }else{
                        $abcd='E';
                    }
                    $arr["abcd"] = $abcd;
                    $db->update("update x_flyinfo set abcd='$abcd' where id='{$fly['id']}'");
                    break;
                case 'SGWIN':
                    $url = trim($fly['url1']) . '/member/accounts';
                    $send = ["headip" => $fly["ip"], "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => false, "postdata" => [], "head" => false, "location" => true,"refer"=>"", "sslhostflag" => true,"json"=>true];
                    $res = ComFunc::CURL($send);
                    //$res = curls($cookie_jar, $url, false, "", true, false);
                    $res = json_decode($res["res"], true);
                    $res = $res[0];
                    $arr['balance'] = $res['balance'];
                    $arr['wjs'] = $res['betting'];
                    $arr['sy'] = isset($res['result']) ? $res['result'] : 0;
                    $arr['loginuser'] = $fly['username'];
                    $arr['name'] = $fly['name'];
                    break;
            }
        }catch (\Exception $e){
            return Json::error('失败');
        }
        return Json::success('成功',$arr);
    }

    public function logoutfly($fid){
        $userid = Constants::$SUID;
        $fly = Flyinfo::where(['userid'=>$userid,'id'=>$fid,'isable'=>1])->first();
        if (empty($fly)) {
            return Json::error('请先启用');
        }
        $cookie_jar = base_path().'/upload/cookie/' . $fly['userid'] . $fid . ".txt";
        try {
            switch ($fly['webtype']) {
                case "IDC":
                    $refer = trim($fly['url3'])."ch/main.aspx";
                    $url = trim($fly['url3'])."logout.aspx?mno=".$fly["username"]."&submno=&sid=xpwtciynjq1ittfuvyglgt4g_53";
                    $send = ["headip" => $fly["ip"], "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => false, "postdata" => [], "head" => true, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                    $res = ComFunc::CURL($send);
                    unlink($cookie_jar);
                    break;
                case 'SGWIN':
                    $url = trim($fly['url1']) . '/member/logout';
                    $send = ["headip" => $fly["ip"], "cookietype" => true, "cookie_jar" => $cookie_jar, "url" => $url, "posttype" => false, "postdata" => [], "head" => true, "location" => true, "refer" => "", "sslhostflag" => true, "json" => false];
                    $res = ComFunc::CURL($send);
                    unlink($cookie_jar);
                    //$res = curls($cookie_jar, $url, false, "", true);
                    break;
            }
        }catch (\Exception $e){
            return Json::error('退出失败');
        }
        return Json::success('退出成功');
    }
}
