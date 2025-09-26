<?php

namespace App\ort\common;

class ArrayUtils
{
    public static function toCollapse($data){
        //循环取出子数组
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                //判断是否是数组
                if(is_array($v)){
                    $data[$key] = array_merge($data[$key], $v);
                    unset($data[$key][$k]);
                }
            }
        }
        return $data;
    }

    public static function array_to_collapse($array,$key){
        $result = [];
        foreach ($array as $value) {
           $keys = $value[$key];
           if(!isset($result[$keys])){
               $result[$keys] = [];
           }
           array_push($result[$keys],$value);
        }
        return $result;
    }
}
