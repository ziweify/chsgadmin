<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController
{
    public function upload(Request $request){

        $path = $request->file('file')->storeAs('avatar');
        return response()->json([
            'code' => 200,
            'message' => '上传成功',
            'data' => $path,
        ]);
    }


}
