<?php

namespace App\ort\services;

use App\Models\CustomDomain;
use App\Models\Game\Config;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;

class BtServices
{
    private function GetKeyData(){
        $now_time = time();
        $p_data = array(
            'request_token'	=>	md5($now_time.''.md5(x_config('bt_key'))),
            'request_time'	=>	$now_time
        );
        return $p_data;
    }

    public function adddomian($id,$domain){
        $ids = explode('-',$id);
        $id = $ids[0];
        $webname = $ids[1];
        $url = x_config('bt_api').'/site?action=AddDomain';
        //准备POST数据
        $p_data = $this->GetKeyData();		//取签名
        $p_data['webname'] = $webname;
        $p_data['id'] = $id;
        $p_data['domain'] = $domain;
        //请求面板接口
        $result = $this->HttpPostCookie($url,$p_data);
        //解析JSON数据
        $data = json_decode($result,true);
        return $data;
    }

    public function deldomain($id,$domain){
        $ids = explode('-',$id);
        $id = $ids[0];
        $webname = $ids[1];
        $url = x_config('bt_api').'/site?action=DelDomain';
        //准备POST数据
        $p_data = $this->GetKeyData();		//取签名
        $p_data['webname'] = $webname;
        $p_data['id'] = $id;
        $p_data['domain'] = $domain;
        $p_data['port'] = 80;
        //请求面板接口
        $result = $this->HttpPostCookie($url,$p_data);
        //解析JSON数据
        $data = json_decode($result,true);
        if(empty($data)){
            $data = ['code'=>0,'msg'=>'删除失败'];
        }
        return $data;
    }

    private function HttpPostCookie($url, $data,$timeout = 60){
        //定义cookie保存位置
        $cookie_file = base_path().'/upload/cookie/'.md5(x_config('bt_api')).'.cookie';
        if(!file_exists($cookie_file)){
            $fp = fopen($cookie_file,'w+');
            fclose($fp);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function addsite($param){
        $url = x_config('bt_api').'/site?action=AddSite';
        //准备POST数据
        $p_data = $this->GetKeyData();		//取签名
        $p_data['webname'] = $param['webname'];
        $p_data['type'] = $param['type'];
        $p_data['port'] = $param['port'];
        $p_data['ps'] = $param['ps'];
        $p_data['path'] = $param['path'];
        $p_data['type_id'] = $param['type_id'];
        $p_data['version'] = $param['version'];
        $p_data['ftp'] = $param['ftp'];
        $p_data['sql'] = $param['sql'];
        $p_data['codeing'] = $param['codeing'];
        //请求面板接口
        $result = $this->HttpPostCookie($url,$p_data);
        //解析JSON数据
        $data = json_decode($result,true);
        if(empty($data)){
            $data = ['code'=>0,'msg'=>'添加失败'];
        }
        return $data;
    }

    public function getallsitelist(){
        $url = x_config('bt_api').'/data?action=getData';
        //准备POST数据
        $p_data = $this->GetKeyData();		//取签名
        $p_data['table'] = 'sites';
        $p_data['limit'] = 20;
        $p_data['p'] = 1;
        $p_data['type'] = 0;
        //请求面板接口
        $result = $this->HttpPostCookie($url,$p_data);
        //解析JSON数据
        $data = json_decode($result,true);
        return $data;
    }
}
