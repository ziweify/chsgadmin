<?php

namespace App\ComServices;


use Swoole\Table as SwooleTable;

/**
 * 房间管理
 * Class Room
 * @package app\webscoket
 */
class Room
{

    /**
     * 类型 只有kefu和admin有区别
     * @var string
     */
    protected $type = '';

    /**
     * fd前缀
     * @var string
     */
    protected $tableFdPrefix = 'ws_fd_';

    /**
     *
     * @var array
     */
    protected $room = [];

    /**
     * @var \Redis
     */
    protected $cache;

    /**
     * 设置缓存
     * @param $cache
     * @return $this
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * 获取表实例
     * @return SwooleTable
     */
    public function getTable(){
        return app('swoole')->wsTable;
    }

    /**
     * 添加fd
     * @param string $key fd
     * @param int $uid 用户uid
     * @param int $to_uid 当前聊天人的uid
     * @param int $tourist 是否为游客
     * @return mixed
     */
    public function add(string $key, int $uid, int $ruid, int $type){
        $nowkey = $this->tableFdPrefix . $key;
        $data = ['fd' => $key, 'type' => $type, 'uid' => $uid, 'ruid' => $ruid];
        $res = $this->getTable()->set($nowkey, $data);
        return $res;
    }

    /**
     * 修改数据
     * @param string $key
     * @param null $field
     * @param null $value
     * @return bool|mixed
     */
    public function update(string $key, $field = null, $value = null){
        $nowkey = $this->tableFdPrefix . $key;
        $res = true;
        if (is_array($field)) {
            $res = $this->getTable()->set($nowkey, $field);
        } else if (!is_array($field) && $value !== null) {
            $data = $this->getTable()->get($nowkey);
            if (!$data) {
                return false;
            }
            $data[$field] = $value;
            $res = $this->getTable()->set($nowkey, $data);
        }
        return $res;
    }

    /**
     * 删除
     * @param string $key
     * @return mixed
     */
    public function del(string $key){
        $nowkey = $this->tableFdPrefix . $key;
        return $this->getTable()->del($nowkey);
    }

    /**
     * 是否存在
     * @param string $key
     * @return mixed
     */
    public function exist(string $key){
        return $this->getTable()->exist($this->tableFdPrefix . $key);
    }

    /**
     * 获取fd的所有信息
     * @param string $key
     * @return array|bool|mixed
     */
    public function get(string $key, string $field = null){
        if($field == null){
            return $this->getTable()->get($this->tableFdPrefix . $key);
        }
        return $this->getTable()->get($this->tableFdPrefix . $key, $field);
    }
}
