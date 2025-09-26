<?php

namespace App\ort\cachemodel;

use App\Models\Game\Zpan;

class ZpanCache
{
    public static function getByfield($where,$field = []){
        //循环where生成缓存key
        $key = '';
        foreach ($where as $k => $v){
            $key .= $v;
        }
        //先从缓存中获取
        $cache = \Cache::tags('zpan')->get('zpan_'.$key);
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
        $model = new Zpan();
        $model->where($where);
        if($field){
            $model = $model->select($field);
        }
        $res = $model->first();
        if($res){
            $res = $res->toArray();
            \Cache::tags('zpan')->put('zpan_'.$key,$res,86400);
            return $res;
        }else{
            return [];
        }
    }

    public static function clearCache(){
        \Cache::tags('zpan')->flush();
    }
}
