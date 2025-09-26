<?php

namespace App\ort\common;

class Json
{
    public static function success($msg = 'success',$data = []){
        return response()->json([
            'status' => 200,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    public static function error($msg = 'error',$data = []){
        return response()->json([
            'status' => 400,
            'msg' => $msg,
            'data' => $data
        ]);
    }
}
