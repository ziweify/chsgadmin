<?php
//添加助手函数x_config
use App\ort\services\ConfigService;
use App\Http\Middleware\SwooleRedirectHelper;

if (!function_exists('x_config')) {
    function x_config($key, $default = '')
    {
        return ConfigService::get($key, $default);
    }
}
if (!function_exists('getmicrotime')) {
    function getmicrotime()
    {
        $mtime = explode(" ", microtime());
        return $mtime[0];
    }
}
if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        static $ip = NULL;
        if ($ip !== NULL)
            return $ip;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos)
                unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        //$ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
        return $ip;
    }
}

if (!function_exists('swoole_redirect')) {
    /**
     * Swoole环境下的安全重定向助手函数
     * 
     * @param string $path 重定向路径
     * @param int $status HTTP状态码
     * @param array $headers 额外的头信息
     * @return \Illuminate\Http\RedirectResponse
     */
    function swoole_redirect($path, $status = 302, $headers = [])
    {
        $request = request();
        
        // 使用安全的重定向助手类
        return SwooleRedirectHelper::safeRedirect($request, $path)->setStatusCode($status)->withHeaders($headers);
    }
}