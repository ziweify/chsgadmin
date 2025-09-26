<?php

namespace App\ort\sgwin;

class MobileJson
{
    public static function success($d = [],$code = 200){
        $result['status'] = isset($d['status']) ? $d['status'] : 'success';
        $result['message'] = isset($d['message']) ? $d['message'] : '成功检索';
        $result['statusCode'] = 0;
        if(isset($d['data'])){
            $result['result'] = $d['data'];
        }
        //不序列化中文
        return response()->json($result,$code,[],JSON_UNESCAPED_UNICODE);
    }

    public static function error($d = [],$code = 200){
        $result['status'] = isset($d['status']) ? $d['status'] : 'fail';
        $result['message'] = isset($d['message']) ? $d['message'] : '检索失败';
        $result['statusCode'] = 1;
        if(!empty($d['data'])){
            $result['result'] = $d['data'];
        }
        return response()->json($result,$code,[],JSON_UNESCAPED_UNICODE);
    }
}
