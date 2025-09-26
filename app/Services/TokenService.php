<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TokenService
{
    /**
     * Token前缀
     */
    private static $prefix = 'token:';
    
    /**
     * 默认过期时间（秒）- 24小时
     */
    private static $defaultExpire = 86400;

    /**
     * 获取Redis连接
     * @return \Illuminate\Redis\RedisManager
     */
    private static function getRedis()
    {
        return Redis::connection();
    }

    /**
     * 生成token
     * @param array $userInfo 用户信息
     * @return string
     */
    public static function generateToken($userInfo)
    {
        // 生成唯一token：时间戳 + 随机字符串 + 用户ID的哈希
        $timestamp = time();
        $randomString = Str::random(32);
        $userHash = md5($userInfo['userid'] . $userInfo['username'] . $timestamp . $randomString);
        return $userHash;
    }

    /**
     * 创建并存储token
     * @param array $userInfo 用户信息
     * @param int|null $expireSeconds 过期时间（秒）
     * @return string
     */
    public static function createToken($userInfo, $expireSeconds = null)
    {
        $token = self::generateToken($userInfo);
        $expire = $expireSeconds ?? self::$defaultExpire;
        try {
            // 一次Redis调用存储token
            self::getRedis()->setex(self::$prefix.$token, $expire, json_encode($userInfo));
            return $token;
        } catch (\Exception $e) {
            Log::error('Failed to create token', ['error' => $e->getMessage(), 'userid' => $userInfo['userid']]);
            throw $e;
        }
    }

    public static function updateToken($token,$userInfo){
        try {
            self::getRedis()->set(self::$prefix.$token, json_encode($userInfo));
        } catch (\Exception $e) {
            Log::error('Failed to update token', ['error' => $e->getMessage(), 'token' => $token]);
            throw $e;
        }
    }

    /**
     * 验证token（简化版，不更新使用时间）
     * @param string $token
     * @return array|false
     */
    public static function validateToken($token){
        if (empty($token)) {
            return false;
        }
        try {
            // 一次Redis调用获取数据
            $tokenData = self::getRedis()->get(self::$prefix.$token);
            if (!$tokenData) {
                return false;
            }
            $data = json_decode($tokenData, true);
            if (!$data) {
                return false;
            }
            return $data;
        } catch (\Exception $e) {
            Log::error('Failed to validate token', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * 刷新token过期时间
     * @param string $token
     * @param int|null $expireSeconds
     * @return bool
     */
    public static function refreshToken($token, $expireSeconds = null){
        if (empty($token)) {
            return false;
        }
        try {
            $expire = $expireSeconds ?? self::$defaultExpire;
            // 一次Redis调用延长过期时间
            return self::getRedis()->expire(self::$prefix . $token, $expire) > 0;
        } catch (\Exception $e) {
            Log::error('Failed to refresh token', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * 删除token
     * @param string $token
     * @return bool
     */
    public static function deleteToken($token){
        if (empty($token)) {
            return false;
        }
        try {
            // 一次Redis调用删除token
            return self::getRedis()->del(self::$prefix . $token) > 0;
        } catch (\Exception $e) {
            Log::error('Failed to delete token', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * 获取用户信息
     * @param string $token
     * @return array|null
     */
    public static function getUserInfo($token){
        $tokenData = self::validateToken($token);
        if (!$tokenData) {
            return null;
        }
        return $tokenData;
    }

    /**
     * 批量删除用户token（使用通配符）
     * @param int $userId
     * @return int 删除数量
     */
    public static function deleteUserTokens($userId){
        try {
            // 先获取所有匹配的key
            $pattern = self::$prefix . '*';
            $keys = self::getRedis()->keys($pattern);
            $deletedCount = 0;
            foreach ($keys as $key) {
                $tokenData = self::getRedis()->get($key);
                if ($tokenData) {
                    $data = json_decode($tokenData, true);
                    if ($data && isset($data['userid']) && $data['userid'] == $userId) {
                        if (self::getRedis()->del($key)) {
                            $deletedCount++;
                        }
                    }
                }
            }
            return $deletedCount;
        } catch (\Exception $e) {
            Log::error('Failed to delete user tokens', ['error' => $e->getMessage(), 'userid' => $userId]);
            return 0;
        }
    }

    /**
     * 检查token是否存在
     * @param string $token
     * @return bool
     */
    public static function exists($token){
        if (empty($token)) {
            return false;
        }
        try {
            return self::getRedis()->exists(self::$prefix.$token) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取token剩余时间
     * @param string $token
     * @return int
     */
    public static function getTtl($token){
        if (empty($token)) {
            return -1;
        }
        try {
            return self::getRedis()->ttl(self::$prefix.$token);
        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * 设置默认过期时间
     * @param int $seconds
     */
    public static function setDefaultExpire($seconds){
        self::$defaultExpire = $seconds;
    }

    /**
     * 强制登出用户（删除指定用户的所有token）
     * 使用Lua脚本减少Redis调用
     * @param int $userId
     * @return int
     */
    public static function forceLogoutUser($userId){
        $luaScript = "
            local prefix = ARGV[1]
            local userid = ARGV[2]
            local keys = redis.call('KEYS', prefix .. '*')
            local count = 0
            
            for i=1,#keys do
                local data = redis.call('GET', keys[i])
                if data then
                    local decoded = cjson.decode(data)
                    if decoded and decoded.userid and tostring(decoded.userid) == userid then
                        redis.call('DEL', keys[i])
                        count = count + 1
                    end
                end
            end
            
            return count
        ";

        try {
            return self::getRedis()->eval($luaScript, 0, self::$prefix, (string)$userId);
        } catch (\Exception $e) {
            Log::error('Failed to force logout user', ['error' => $e->getMessage(), 'userid' => $userId]);
            // 降级到普通方法
            return self::deleteUserTokens($userId);
        }
    }
} 