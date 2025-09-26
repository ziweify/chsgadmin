<?php

namespace App\Http\Controllers\Manage;

use App\ComServices\UnifiedBettingParser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 统一下注词法分析器测试控制器
 */
class TestBettingParser extends Controller
{
    public function test(Request $request)
    {
        $testCases = [
            // 基础格式测试
            '123大100',
            '123大单龙100',
            '123大双虎100',
            '123大双尾大龙100',
            
            // 多段识别测试
            '123大100, 45大100',
            '123大100，456小100',
            
            // 混合格式测试
            '12大45小单3尾大龙100',
            '1小5大虎100',
            '2大双尾大4合双福喜100',
            
            // 边界情况测试
            '大100',
            '龙虎100',
            '1尾大单100',
            '6龙虎大小100',
            
            // 梭哈测试
            '123大梭哈',
            '12大45小梭哈',
        ];
        
        $parser = new UnifiedBettingParser();
        $results = [];
        
        foreach ($testCases as $testCase) {
            $result = $parser->parseBetting($testCase, 10000); // 宾果游戏，余额10000
            $results[] = [
                'input' => $testCase,
                'status' => $result['status'],
                'data' => $result['data'],
                'msg' => $result['msg'],
                'bet_count' => count($result['data']),
                'total_amount' => $this->calculateTotalAmount($result['data'])
            ];
        }
        
        return response()->json([
            'title' => '统一下注词法分析器测试结果',
            'test_cases' => count($testCases),
            'results' => $results
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    
    public function testCustom(Request $request)
    {
        $content = $request->input('content', '123大100');
        $balance = $request->input('balance', 10000);
        
        $parser = new UnifiedBettingParser();
        $result = $parser->parseBetting($content, $balance);
        
        return response()->json([
            'title' => '宾果游戏自定义测试结果',
            'input' => [
                'content' => $content,
                'balance' => $balance
            ],
            'result' => [
                'status' => $result['status'],
                'data' => $result['data'],
                'msg' => $result['msg'],
                'bet_count' => count($result['data']),
                'total_amount' => $this->calculateTotalAmount($result['data']),
                'detailed_bets' => $this->formatBetDetails($result['data'])
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    private function calculateTotalAmount($bets)
    {
        $total = 0;
        foreach ($bets as $bet) {
            if (is_numeric($bet['amount'])) {
                $total += $bet['amount'];
            }
        }
        return $total;
    }
    
    private function formatBetDetails($bets)
    {
        $details = [];
        foreach ($bets as $bet) {
            $details[] = sprintf(
                "%s：%s %s元",
                $bet['mid_name'],
                $bet['play'],
                $bet['amount']
            );
        }
        return $details;
    }
}
