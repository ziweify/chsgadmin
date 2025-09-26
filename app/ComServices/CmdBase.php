<?php

namespace App\ComServices;

class CmdBase
{
    const LargeCateLiangMian = '两面';
    const LargeCateHaoMa= '号码';
    const LargeCateGyh = '冠亚和';
    const LargeCateQwhz = '前五和值';

    //解析结果
    protected function CmdResult($status = 0, $data, $msg = '', $json = false)
    {
        // 0 是没错误
        $result = [
            'status' => $status,  //状态码
            'data' => $data,     //数据返回
            'msg' => $msg,       //自定义信息, 错误信息
        ];
        if($json)
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        else
            return $result;
    }
}