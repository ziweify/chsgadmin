<?php

namespace App\ort\sgwin;

class AgentJson
{
    public static function success($d = [],$code = 200){
        $result['message'] = isset($d['message']) ? $d['message'] : '成功检索';
        $result['success'] = true;
        if(!empty($d['data'])){
            $result['data'] = $d['data'];
        }
        return response()->json($result,$code);
    }

    public static function error($d = [],$code = 200){
        $result['message'] = isset($d['message']) ? $d['message'] : '检索失败';
        $result['success'] = false;
        if(!empty($d['data'])){
            $result['data'] = $d['data'];
        }
        return response()->json($result,$code);
    }
}
