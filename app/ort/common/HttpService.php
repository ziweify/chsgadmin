<?php
// +----------------------------------------------------------------------
// | CRMEB [ CRMEB赋能开发者，助力企业发展 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.crmeb.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed CRMEB并不是自由软件，未经许可不能去掉CRMEB相关版权
// +----------------------------------------------------------------------
// | Author: CRMEB Team <admin@crmeb.com>
// +----------------------------------------------------------------------

namespace App\ort\common;

/**
 * Class HttpService
 * @package crmeb\services
 */
class HttpService
{
    /**
     * 错误信息
     * @var string
     */
    private static $curlError;

    /**
     * header头信息
     * @var string
     */
    private static $headerStr;

    /**
     * 请求状态
     * @var int
     */
    private static $status;

    /**
     * @return string
     */
    public static function getCurlError()
    {
        return self::$curlError;
    }

    /**
     * @return mixed
     */
    public static function getStatus()
    {
        return self::$status;
    }

    /**
     * 模拟GET发起请求
     * @param $url
     * @param array $data
     * @param bool $header
     * @param int $timeout
     * @return bool|string
     */
    public static function getRequest($url, $data = array(), $header = false, $timeout = 5)
    {
        if (!empty($data)) {
            $url .= (stripos($url, '?') === false ? '?' : '&');
            $url .= (is_array($data) ? http_build_query($data) : $data);
        }

        return self::request($url, 'get', array(), $header, $timeout);
    }

    /**
     * curl 请求
     * @param $url
     * @param string $method
     * @param array $data
     * @param bool $header
     * @param int $timeout
     * @return bool|string
     */
    public static function request($url, $method = 'get', $data = array(), $header = false, $timeout = 15)
    {
        self::$status = null;
        self::$curlError = null;
        self::$headerStr = null;

        $curl = curl_init($url);
        $method = strtoupper($method);
        //请求方式
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        //post请求
        if ($method == 'POST') curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //超时时间
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        //设置header头
        if ($header !== false) curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        //返回抓取数据
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //输出header头信息
        curl_setopt($curl, CURLOPT_HEADER, true);
        //TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        //https请求
        if (1 == strpos("$" . $url, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        self::$curlError = curl_error($curl);

        list($content, $status) = [curl_exec($curl), curl_getinfo($curl), curl_close($curl)];
        self::$status = $status;
        self::$headerStr = trim(substr($content, 0, $status['header_size']));
        $content = trim(substr($content, $status['header_size']));
        return (intval($status["http_code"]) === 200) ? $content : false;
    }

    /**
     * 模拟POST发起请求
     * @param $url
     * @param $data
     * @param bool $header
     * @param int $timeout
     * @return bool|string
     */
    public static function postRequest($url, $data = array(), $header = false, $timeout = 10)
    {
        return self::request($url, 'post', $data, $header, $timeout);
    }

    public static function curl_post($type, $url, $cookie = '', $post_data = array()){
        if (empty($url)) {
            return false;
        }
        //正确写法
        $headers = [
            "Content-Type:application/json; charset=UTF-8",
            "X-Requested-With:XMLHttpRequest",
            "Host:yun.citi668.com",
            "Origin:http://yun.citi668.com",
        ];
        $jsonStr = json_encode($post_data);
        $headers = array(
            "Content-Type: application/json",
            "Content-Length: " . strlen($jsonStr) . "",
            "Accept: application/json",
            "X-Requested-With:XMLHttpRequest",
            "Host:yun.citi668.com",
            "Origin:http://yun.citi668.com",
        );
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        if ($type) {  //判断请求协议http或https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36'); // 模拟用户使用的浏览器
        if (!empty($cookie)) curl_setopt($ch, CURLOPT_COOKIE, $cookie);  //设置cookie
        // 在尝试连接时等待的秒数
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        // 最大执行时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

    /**
     * 获取header头字符串类型
     * @return mixed
     */
    public static function getHeaderStr()
    {
        return self::$headerStr;
    }

    /**
     * 获取header头数组类型
     * @return array
     */
    public static function getHeader()
    {
        $headArr = explode("\r\n", self::$headerStr);
        return $headArr;
    }

}
