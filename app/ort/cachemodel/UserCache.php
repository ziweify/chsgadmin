<?php

namespace App\ort\cachemodel;

class UserCache
{
    public static function getByfield($userid,$field = []){
        //先从缓存中获取
        $cache = \Cache::get('user_'.$userid);
        if($cache){
            //遍历缓存中的数据，如果和传入的字段相同，则返回
            $data = [];
            foreach($field as $v){
                if(isset($cache[$v])){
                    $data[$v] = $cache[$v];
                }
            }
            return $data;
        }
        $model = new \App\Models\Game\User();
        if($field){
            $model = $model->select($field);
        }
        $res = $model->where('userid',$userid)->first();
        if($res){
            $res = $res->toArray();
            \Cache::put('user_'.$userid,$res,86400);
            return $res;
        }else{
            return [];
        }
    }
}
