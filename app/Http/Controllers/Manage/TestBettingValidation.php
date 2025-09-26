<?php

namespace App\Http\Controllers\Manage;

use App\ComServices\CmdBingo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 测试下注验证控制器
 */
class TestBettingValidation extends Controller
{
    public function test(Request $request)
    {
        $content = $request->input('content', '12大45小单3尾大龙100；123da100');
        $balance = $request->input('balance', 10000);
        
        $cmdBingo = new CmdBingo();
        $result = $cmdBingo->commandBetting($content, $balance, false);
        
        return response()->json([
            'title' => '下注验证测试结果',
            'input' => $content,
            'user_balance' => $balance,
            'result' => [
                'status' => $result['status'],
                'data' => $result['data'],
                'msg' => $result['msg'],
                'bet_count' => count($result['data'] ?? []),
                'is_valid' => $result['status'] > 0
            ],
            'validation_status' => $result['status'] > 0 ? '✅ 解析成功' : ($result['status'] == 0 ? '⚠️ 格式错误' : '❌ 验证失败'),
            'timestamp' => date('Y-m-d H:i:s')
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
