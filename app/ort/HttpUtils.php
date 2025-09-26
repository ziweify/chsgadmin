<?php

namespace App\ort;

use App\Models\Game\OutbetAccs;
use App\Models\Game\OutbetSite;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class HttpUtils
{

    private static $client = null;
    private static $clientproxy = null;
    public static function getClient($is_proxy,$proxy_url){
        if($is_proxy == 1 && !empty($proxy_url)){
            if (self::$clientproxy === null) {
                self::$clientproxy = new Client([
                    'allow_redirects' => [
                        'max' => 20,
                        'strict' => true,
                        'referer' => true,
                        'protocols' => ['https'],
                        'stream' => true,  // 追加stream选项
                    ],
                    'proxy'=>$proxy_url,
                ]);
            }
            return self::$clientproxy;
        }else{
            if (self::$client === null) {
                self::$client = new Client([
                    'allow_redirects' => [
                        'max' => 20,
                        'strict' => true,
                        'referer' => true,
                        'protocols' => ['https'],
                        'stream' => true,  // 追加stream选项
                    ],
                ]);
            }
        }
        return self::$client;
    }

    public static function request($type,$url,$postdata,$head,$json,$is_proxy = 1,$proxy_url = ''){
        $client = self::getClient($is_proxy,$proxy_url);
        $params = [];
        $head['Accept-Encoding'] = 'gzip';
        $params['http_errors'] = false;
        $params['keepalive'] = true;
        $params['timeout'] = 10;
        $params['connect_timeout'] = 5;
        $params['headers'] = $head;
        $params['allow_redirects'] = true;
        $params['verify'] = false;
        $result = [];
        try {
            if ($type == 'POST'){
                if($json == true){
                    $params['json'] = $postdata;
                }else{
                    $params['form_params'] = $postdata;
                }
                $response = $client->request('POST', $url, $params);
            }else{
                if(isset($postdata['query'])){
                    $params['query'] = $postdata['query'];
                    unset($postdata['query']);
                }
                $response = $client->request('GET', $url, $params);
            }
            //http状态
            $result['status'] = $response->getStatusCode();
            $result['code'] = 1;
            $result['data'] = $response->getBody()->getContents();
        }catch (\Exception $e){
           $result['status'] = 0;
           $result['code'] = 0;
           $result['data'] = '';
           $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    public static function req($type,$url,$postdata = [],$json = false){
        $client = self::getClient(1,'');
        $params = [];
        $head['Accept-Encoding'] = 'gzip';
        $params['http_errors'] = false;
        $params['keepalive'] = true;
        $params['timeout'] = 10;
        $params['connect_timeout'] = 5;
        $params['headers'] = ['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36'];
        $params['allow_redirects'] = true;
        $params['verify'] = false;
        if ($type == 'POST'){
            if($json == true){
                $params['json'] = $postdata;
            }else{
                $params['form_params'] = $postdata;
            }
            $response = $client->request('POST', $url, $params);
        }else{
            if(isset($postdata['query'])){
                $params['query'] = $postdata['query'];
                unset($postdata['query']);
            }
            $response = $client->request('GET', $url, $params);
        }
        return $response->getBody();
    }

    public static function curl($type,$issavecookie,$cookieJar,$url,$postdata,$head,$location,$sslhostflag,$json,$siteid,$is_proxy = 1,$proxy_url = ''){
        if($issavecookie){
            if(empty($cookieJar)){
                $cookieJar = new CookieJar();
            }else{
                $cookieJar = unserialize($cookieJar);
            }
        }
        $client = self::getClient($is_proxy,$proxy_url);
        $params = [];
        $head['Accept-Encoding'] = 'gzip';
        //$head['User-Agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36';
        //$head['Sec-Ch-Ua'] = 'Google Chrome";v="119", "Chromium";v="119", "Not?A_Brand";v="24';
        $params['http_errors'] = false;
        $params['keepalive'] = true;
        $params['timeout'] =  env('http_timeout',10);
        $params['connect_timeout'] = env('http_connect_timeout',10);
        $params['headers'] = $head;
        $params['allow_redirects'] = $location;
        $params['verify'] = !$sslhostflag;
        if($issavecookie){
            $params['cookies'] = $cookieJar;
        }
        try {
            if ($type == 'POST'){
                if($json == true){
                    $params['json'] = $postdata;
                }else{
                    $params['form_params'] = $postdata;
                }
                $response = $client->request('POST', $url, $params);
            }else{
                $response = $client->request('GET', $url, $params);
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
        if($issavecookie){
            $serializedCookieJar = serialize($cookieJar);
            OutbetSite::where('id',$siteid)->update(['cookie'=>$serializedCookieJar]);
        }
        $response = $response->getBody()->getContents();
        return $response;
    }

    public static function bdcurl($cookieJar,$url,$postdata,$head,$location,$ispost,$isjson){
        $url = str_replace('://', '---', $url);
        $url = str_replace('//', '/', $url);
        $url = str_replace('---', '://', $url);
        $SSL = substr($url, 0, 8) == "https://" ? true : false;
        //$ch = self::getcurlchbypool();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($SSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        /*if ($head) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }*/
        if (!empty($head["Referer"])) {
            curl_setopt($ch, CURLOPT_REFERER, $head["Referer"]);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36');

        //curl_setopt($ch, CURL_XML, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($location) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $location);
        }
        if (!empty($cookieJar)) {
            //curl_setopt($ch, CURLOPT_COOKIE, $cookieJar);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
        }
        if ($ispost) {
            if ($isjson) {
                is_array($postdata) && $postdata = json_encode($postdata);
                if(empty($postdata)){$postdata = '';}
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                $headers[] = 'Content-Type: application/json; charset=utf-8';
                $headers[] = 'Content-Length: ' . strlen($postdata);
            } else {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
            }
        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);//设置连接等待时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);//设置curl允许执行的最长秒数
        if(isset($headers)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        // 将 cURL 句柄放回连接池
        //self::$curlPool->push($ch);
        if ($result === false) {// 检查 cURL 错误
            $errorCode = curl_errno($ch);
            $errorMsg = curl_error($ch);
            if ($errorCode == CURLE_OPERATION_TIMEDOUT) {
                return ['code'=>-1,'msg'=>'连接超时'.$errorMsg,'data'=>''];
            } else {
                return ['code'=>-2,'msg'=>'网络不通'.$errorMsg,'data'=>''];
            }
        }
        return ['code'=>1,'data'=>$result];
    }
}
