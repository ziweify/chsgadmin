<?php

namespace App\ort\sgwin;

class Json
{
    public static function success($msg = 'success',$data = [],$is_json = true){
        if($is_json){
            return response()->json(['message' => $msg,'success' => true,'data' => !empty($data) ? $data : new \stdClass()],200,[],JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json(['message' => $msg,'success' => true,'data' => !empty($data) ? $data : new \stdClass()],200,[],JSON_UNESCAPED_UNICODE)->content();
        }
    }

    public static function error($msg = 'error',$data = [],$is_json = true){
        if($is_json){
            return response()->json(['message' => $msg,'success' => false,'data' => !empty($data) ? $data : new \stdClass()],200,[],JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json(['message' => $msg,'success' => false,'data' => !empty($data) ? $data : new \stdClass()],200,[],JSON_UNESCAPED_UNICODE)->content();
        }
    }
}
