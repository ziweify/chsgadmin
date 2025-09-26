<?php

namespace App\ComServices;

/**
 * 宾果游戏专用下注词法分析引擎
 * 支持复杂多变的下注格式解析
 * 
 * 支持的格式示例：
 * 1. 基础格式：123大100 -> 1大100, 2大100, 3大100
 * 2. 复杂组合：123大单龙100 -> 1大100, 2大100, 3大100, 单100, 龙100
 * 3. 多段识别：123大100, 45大100 -> 分别解析两段
 * 4. 混合格式：12大45小单3尾大龙100 -> 1大100, 2大100, 4小100, 5小100, 单100, 3尾大100, 龙100
 */
class UnifiedBettingParser extends CmdBase
{
    /**
     * 宾果游戏专用解析入口
     * @param string $content 用户输入的下注内容
     * @param float $userBalance 用户总余额（用于梭哈计算）
     * @return array 解析结果
     */
    public function parseBetting($content, $userBalance = 0)
    {
        try {
            // 清理输入内容
            $content = $this->cleanInput($content);
            
            // 多段识别：按逗号分割
            $segments = $this->splitByComma($content);
            
            $allBets = [];
            $totalAmount = 0;
            
            foreach ($segments as $segment) {
                $segmentResult = $this->parseSingleSegment($segment, $userBalance);
                if ($segmentResult['status'] > 0) {
                    $allBets = array_merge($allBets, $segmentResult['data']);
                    $totalAmount += $this->calculateSegmentAmount($segmentResult['data']);
                }
            }
            
            // 统一排序
            $this->sortBets($allBets);
            
            return $this->CmdResult(count($allBets), $allBets, '', false);
            
        } catch (\Exception $e) {
            return $this->CmdResult(-1, [], $e->getMessage(), false);
        }
    }
    
    /**
     * 清理输入内容
     */
    private function cleanInput($content)
    {
        // 移除多余空格和特殊字符
        $content = trim($content);
        $content = str_replace([' ', '　', '\t'], '', $content);
        return $content;
    }
    
    /**
     * 按逗号分割内容
     */
    private function splitByComma($content)
    {
        // 支持中英文逗号分割
        $segments = preg_split('/[,，]/', $content);
        return array_filter(array_map('trim', $segments));
    }
    
    /**
     * 解析单个段落
     */
    private function parseSingleSegment($segment, $userBalance)
    {
        // 提取金额
        $amountInfo = $this->extractAmount($segment);
        $amount = $amountInfo['amount'];
        $betContent = $amountInfo['content'];
        
        // 词法分析：提取位置、玩法和金额的组合
        $tokens = $this->tokenize($betContent);
        
        // 语法分析：将词法单元组合成投注项
        $bets = $this->parse($tokens, $amount, $userBalance);
        
        return $this->CmdResult(count($bets), $bets, '', false);
    }
    
    /**
     * 提取金额部分
     */
    private function extractAmount($content)
    {
        // 匹配金额：数字或梭哈
        if (preg_match('/(\d+|梭哈)$/', $content, $matches)) {
            $amount = $matches[1];
            $betContent = substr($content, 0, -strlen($amount));
            return ['amount' => $amount, 'content' => $betContent];
        }
        
        return ['amount' => 10, 'content' => $content]; // 默认金额
    }
    
    /**
     * 词法分析：将输入拆分成词法单元（数字+玩法为一个作用域）
     */
    private function tokenize($content)
    {
        $tokens = [];
        
        // 使用正则表达式提取数字+玩法的组合
        $pattern = '/(\d+)([^0-9]+)/u';
        
        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $positions = $match[1]; // 位置数字，如 "12", "45", "3"
                $playsText = $match[2];  // 玩法文本，如 "大", "小单", "尾大龙"
                
                $tokens[] = [
                    'type' => 'POSITION_PLAYS', 
                    'positions' => $positions,
                    'plays' => $playsText
                ];
            }
        }
        
        return $tokens;
    }
    
    /**
     * 语法分析：将词法单元解析成投注项（每个数字+玩法为独立作用域）
     */
    private function parse($tokens, $amount, $userBalance)
    {
        $bets = [];
        
        foreach ($tokens as $token) {
            if ($token['type'] === 'POSITION_PLAYS') {
                $positions = str_split($token['positions']); // 将数字字符串拆分为位置数组
                $playsText = $token['plays']; // 玩法文本
                
                // 从玩法文本中提取所有玩法
                $plays = $this->extractPlays($playsText);
                
                foreach ($plays as $play) {
                    // 确定该玩法应该应用到哪些位置
                    $playPositions = $this->determinePlayPositions($play, $positions);
                    
                    foreach ($playPositions as $position) {
                        $bet = $this->createBet($position, $play, $amount);
                        if ($bet) {
                            $bets[] = $bet;
                        }
                    }
                }
            }
        }
        
        // 处理梭哈
        if ($amount === '梭哈') {
            $this->distributeSuohaAmount($bets, $userBalance);
        }
        
        return $bets;
    }
    
    /**
     * 从玩法字符串中提取所有玩法
     */
    private function extractPlays($playString)
    {
        $plays = [];
        
        // 定义宾果游戏支持的玩法（按长度排序，优先匹配长玩法）
        $allPlays = [
            // 多字符玩法（必须优先匹配）
            '尾大', '尾小', '合单', '合双',
            // 单字符玩法
            '大', '小', '单', '双', '龙', '虎',
            // 特殊玩法
            '福', '禄', '寿', '喜'
        ];
        
        $remaining = $playString;
        while (!empty($remaining)) {
            $found = false;
            
            // 优先匹配长玩法
            foreach ($allPlays as $play) {
                if (mb_strpos($remaining, $play) === 0) {
                    $plays[] = $play;
                    $remaining = mb_substr($remaining, mb_strlen($play));
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                // 跳过无法识别的字符
                $remaining = mb_substr($remaining, 1);
            }
        }
        
        return $plays;
    }
    
    /**
     * 确定玩法应用的位置
     */
    private function determinePlayPositions($play, $currentPositions)
    {
        // 宾果游戏特殊玩法的位置规则
        $specialPlayPositions = [
            '龙' => ['6'], // 龙虎只能用于前五和值位置
            '虎' => ['6'],
        ];
        
        if (isset($specialPlayPositions[$play])) {
            return $specialPlayPositions[$play];
        }
        
        // 普通玩法使用当前位置
        return $currentPositions;
    }
    
    /**
     * 创建投注项
     */
    private function createBet($position, $play, $amount)
    {
        $positionNames = $this->getPositionNames();
        $positionName = $positionNames[$position] ?? "位置{$position}";
        
        // 生成标记
        $mark = $this->generateMark($position, $play);
        if (!$mark) {
            return null;
        }
        
        return [
            'mark' => $mark,
            'mid' => $position,
            'mid_name' => $positionName,
            'play' => $play,
            'amount' => $amount
        ];
    }
    
    /**
     * 获取位置名称映射（宾果游戏专用）
     */
    private function getPositionNames()
    {
        return [
            '1' => '平码一',
            '2' => '平码二', 
            '3' => '平码三',
            '4' => '平码四',
            '5' => '特码',
            '6' => '前五和值'
        ];
    }
    
    /**
     * 生成标记（宾果游戏专用）
     */
    private function generateMark($position, $play)
    {
        return $this->generateBingoMark($position, $play);
    }
    
    /**
     * 生成宾果标记
     */
    private function generateBingoMark($position, $play)
    {
        $markMapping = [
            '大' => 'DX',
            '小' => 'DX',
            '单' => 'DS',
            '双' => 'DS',
            '尾大' => 'WDX',
            '尾小' => 'WDX',
            '合单' => 'HDS',
            '合双' => 'HDS',
            '福' => 'FLSX',
            '禄' => 'FLSX',
            '寿' => 'FLSX',
            '喜' => 'FLSX',
            '龙' => 'LH',
            '虎' => 'LH'
        ];
        
        $suffixMapping = [
            '大' => '_D',
            '小' => '_X',
            '单' => '_D',
            '双' => '_S',
            '尾大' => '_D',
            '尾小' => '_X',
            '合单' => '_D',
            '合双' => '_S',
            '福' => '_F',
            '禄' => '_L',
            '寿' => '_S',
            '喜' => '_X',
            '龙' => '_L',
            '虎' => '_H'
        ];
        
        if (!isset($markMapping[$play])) {
            return null;
        }
        
        $baseMark = $markMapping[$play];
        $suffix = $suffixMapping[$play];
        
        if ($position == '6') {
            // 和值位置特殊处理
            if ($play == '龙' || $play == '虎') {
                return 'LH' . $suffix;
            } else {
                return 'Z' . $baseMark . $suffix;
            }
        } else {
            return $baseMark . $position . $suffix;
        }
    }
    
    /**
     * 分配梭哈金额
     */
    private function distributeSuohaAmount(&$bets, $userBalance)
    {
        $count = count($bets);
        if ($count > 0) {
            $amountPerBet = intval($userBalance / $count);
            foreach ($bets as &$bet) {
                $bet['amount'] = $amountPerBet;
            }
        }
    }
    
    /**
     * 计算段落总金额
     */
    private function calculateSegmentAmount($bets)
    {
        $total = 0;
        foreach ($bets as $bet) {
            if (is_numeric($bet['amount'])) {
                $total += $bet['amount'];
            }
        }
        return $total;
    }
    
    /**
     * 排序投注项
     */
    private function sortBets(&$bets)
    {
        usort($bets, function($a, $b) {
            $midDiff = $a['mid'] - $b['mid'];
            if ($midDiff === 0) {
                return strcmp($a['play'], $b['play']);
            }
            return $midDiff;
        });
    }
}
