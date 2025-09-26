<?php

namespace App\ort\sgwin;

class AppJson
{
    public static function success($msg = '',$data = [],$status = 200){
        return response()->json(['status'=>$status,'data' => !empty($data) ? $data : [],'msg'=>$msg]);
    }

    public static function error($msg = '',$status = 400){
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }
}
