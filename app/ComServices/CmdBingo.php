<?php

namespace App\ComServices;

use Psy\CodeCleaner\ReturnTypePass;


class CmdBingo extends CmdBase
{
    function __construct() {

    }


    //投注命令
    //   测试链接:http://fnadmin.ling.com/test/send?msg=大小1000
    //   解析 1大小单双1000  该类型命令
    //   返回值: json{ status:1, data:[{bname=第一球, mark:B1_1, play:大, amount:1000}, {bname=第一球, sname:B1_1, play:小, amout:2000}], msg:'错误信息'}
    //              status:返回data item数量, =0未匹配, -1其他错误
    //    当梭哈时候, 需要提供 amount金额.
    public function commandBetting($content, $amount_all = 0, $json = false)
    {
        try {
            // 使用严格的统一词法分析引擎
            $unifiedParser = new UnifiedBettingParser();
            $result = $unifiedParser->parseBetting($content, $amount_all);
            
            if ($result['status'] > 0) {
                return $this->CmdResult($result['status'], $result['data'], $result['msg'], $json);
            }
            
            // 不再回退到旧解析器，严格按照新规则执行
            return $this->CmdResult(0, [], '格式不正确，请检查输入格式', $json);
            
        } catch (\Exception $e) {
            // 对于格式验证错误，直接返回错误信息，不尝试旧解析器
            return $this->CmdResult(-1, [], $e->getMessage(), $json);
        }
    }
    
    /**
     * 原有解析方案作为备用
     */
    private function legacyCommandBetting($content, $amount_all = 0, $json = false)
    {
        $err = '';
        $data = null;
        $status = 0;
        try
        {
            // 新的统一解析方案
            $result = $this->parseBettingCommand($content, $amount_all);
            if($result !== null) {
                $status = 1;
                $data = $result;
                return $this->CmdResult($status, $data, $err, $json);
            }

            // 如果新方案无法解析，尝试原有方案作为备用
            $result = $this->parseLegacyCommand($content, $amount_all);
            if($result !== null) {
                $status = 1;
                $data = $result;
                return $this->CmdResult($status, $data, $err, $json);
            }
        }
        catch(\Exception $e)
        {
            $err = $e->getMessage();
            $status = -1;
        }
        
        return $this->CmdResult($status, $data, $err, $json);
    }

    /**
     * 新的统一解析方案
     * 支持各种复杂格式：
     * 1尾小单23456双100
     * 1尾大单大356大双100
     * 123大小单双尾小456大100
     * 1尾大5尾小100
     */
    private function parseBettingCommand($content, $amount_all)
    {
        // 移除所有空格和斜杠，统一格式
        $content = str_replace([' ', '/'], '', $content);
        
        // 提取金额部分
        if(preg_match('/(\d+|梭哈)$/', $content, $amountMatch)) {
            $amount = $amountMatch[1];
            $betContent = substr($content, 0, -strlen($amount));
        } else {
            $amount = 10; // 默认金额
            $betContent = $content;
        }

        // 解析投注内容
        $betData = $this->parseBetContent($betContent, $amount, $amount_all);
        
        return $betData;
    }

    /**
     * 解析投注内容的核心方法
     */
    private function parseBetContent($betContent, $amount, $amount_all)
    {
        $datas = array();
        
        // 定义位置映射：1-4为平码，5为特码，6为和值
        $positionMap = [
            '1' => '平码一',
            '2' => '平码二', 
            '3' => '平码三',
            '4' => '平码四',
            '5' => '特码',
            '6' => '和值'
        ];

        // 定义玩法映射
        $playMap = [
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
            '喜' => 'FLSX'
            // 龙虎玩法只能用于前五和值，不能用于平码位置
            // '龙' => 'LH',
            // '虎' => 'LH'
        ];

        // 特殊处理：检查是否为"123大龙虎100"这种格式
        // 其中"龙虎"应该被识别为总和玩法
        if(preg_match('/^(\d+)(大|小|单|双)(龙|虎|龙虎)$/u', $betContent, $specialMatches)) {
            $positions = $specialMatches[1]; // 位置字符串，如 "123"
            $basicPlay = $specialMatches[2]; // 基础玩法，如 "大"
            $sumPlay = $specialMatches[3];   // 总和玩法，如 "龙" 或 "龙虎"
            
            // 对每个位置应用基础玩法（不包括龙虎）
            for($i = 0; $i < strlen($positions); $i++) {
                $position = $positions[$i];
                $item = $this->createBetItem($position, $basicPlay, $amount, $positionMap, $playMap);
                if($item) {
                    array_push($datas, $item);
                }
            }
            
            // 添加总和玩法（前五和值）- 龙虎只能用于总和
            if($sumPlay == '龙虎') {
                // 龙虎需要分别添加
                $item1 = $this->createBetItem('6', '龙', $amount, $positionMap, $playMap);
                $item2 = $this->createBetItem('6', '虎', $amount, $positionMap, $playMap);
                if($item1) array_push($datas, $item1);
                if($item2) array_push($datas, $item2);
            } else {
                $item = $this->createBetItem('6', $sumPlay, $amount, $positionMap, $playMap);
                if($item) {
                    array_push($datas, $item);
                }
            }
            
            // 排序
            $this->SortDefault($datas);
            
            // 处理梭哈
            if($amount == '梭哈'){
                $this->SetItemsSuoHaAmount($datas, $amount_all);
            }
            
            return $datas;
        }

        // 新增：处理"1小5大虎100"这种混合格式
        // 格式：位置+玩法+位置+玩法+前五和值玩法
        if(preg_match('/^(\d+)([大小单双尾大尾小合单合双福禄寿喜]+)(\d+)([大小单双尾大尾小合单合双福禄寿喜]+)(龙|虎|龙虎)$/u', $betContent, $mixedMatches)) {
            $position1 = $mixedMatches[1];      // 第一个位置，如 "1"
            $play1 = $mixedMatches[2];          // 第一个玩法，如 "小"
            $position2 = $mixedMatches[3];      // 第二个位置，如 "5"
            $play2 = $mixedMatches[4];          // 第二个玩法，如 "大"
            $sumPlay = $mixedMatches[5];        // 前五和值玩法，如 "虎"
            
            // 添加第一个位置的投注
            $item1 = $this->createBetItem($position1, $play1, $amount, $positionMap, $playMap);
            if($item1) {
                array_push($datas, $item1);
            }
            
            // 添加第二个位置的投注
            $item2 = $this->createBetItem($position2, $play2, $amount, $positionMap, $playMap);
            if($item2) {
                array_push($datas, $item2);
            }
            
            // 添加前五和值投注
            if($sumPlay == '龙虎') {
                // 龙虎需要分别添加
                $item3 = $this->createBetItem('6', '龙', $amount, $positionMap, $playMap);
                $item4 = $this->createBetItem('6', '虎', $amount, $positionMap, $playMap);
                if($item3) array_push($datas, $item3);
                if($item4) array_push($datas, $item4);
            } else {
                $item3 = $this->createBetItem('6', $sumPlay, $amount, $positionMap, $playMap);
                if($item3) {
                    array_push($datas, $item3);
                }
            }
            
            // 排序
            $this->SortDefault($datas);
            
            // 处理梭哈
            if($amount == '梭哈'){
                $this->SetItemsSuoHaAmount($datas, $amount_all);
            }
            
            return $datas;
        }

        // 首先检查是否为纯玩法格式（如"大100"、"虎100"等）
        $purePlayPattern = '/^([大小单双龙虎尾大尾小合单合双福禄寿喜]+)$/u';
        if(preg_match($purePlayPattern, $betContent, $pureMatches)) {
            // 这是和值玩法，位置为6
            $plays = $this->extractPlays($pureMatches[1]);
            foreach($plays as $play) {
                $item = $this->createBetItem('6', $play, $amount, $positionMap, $playMap);
                if($item) {
                    array_push($datas, $item);
                }
            }
        } else if(preg_match('/^(前五和值|和|前五|6)\/?([大小单双龙虎尾大尾小]+)$/u', $betContent, $matches)) {
            // 处理"前五和值虎"、"6虎"等格式
            $plays = $this->extractPlays($matches[2]);
            foreach($plays as $play) {
                $item = $this->createBetItem('6', $play, $amount, $positionMap, $playMap);
                if($item) {
                    array_push($datas, $item);
                }
            }
        } else {
            // 解析位置和玩法组合
            // 支持格式：1尾小单、123大小单双、1尾大单大等
            $pattern = '/(\d+)([大小单双龙虎尾大尾小合单合双福禄寿喜]+)/u';
            
            if(preg_match_all($pattern, $betContent, $matches, PREG_SET_ORDER)) {
                foreach($matches as $match) {
                    $positions = $match[1]; // 位置字符串，如 "1", "123", "356"
                    $plays = $match[2];     // 玩法字符串，如 "尾小单", "大小单双"
                    
                    // 解析每个位置
                    for($i = 0; $i < strlen($positions); $i++) {
                        $position = $positions[$i];
                        
                        // 解析该位置的玩法
                        $positionPlays = $this->extractPlays($plays);
                        
                        foreach($positionPlays as $play) {
                            $item = $this->createBetItem($position, $play, $amount, $positionMap, $playMap);
                            if($item) {
                                array_push($datas, $item);
                            }
                        }
                    }
                }
            }
        }

        // 排序
        $this->SortDefault($datas);
        
        // 处理梭哈
        if($amount == '梭哈'){
            $this->SetItemsSuoHaAmount($datas, $amount_all);
        }
        
        return $datas;
    }

    /**
     * 从玩法字符串中提取所有玩法
     * 支持复合玩法如 "尾小单" -> ["尾小", "单"]
     */
    private function extractPlays($playString)
    {
        $plays = array();
        
        // 定义所有可能的玩法（包括前五和值可用的玩法）
        $allPlays = ['尾大', '尾小', '合单', '合双', '大', '小', '单', '双', '龙', '虎', '福', '禄', '寿', '喜'];
        
        $remaining = $playString;
        while(!empty($remaining)) {
            $found = false;
            
            // 优先匹配长玩法（如"尾大"、"合单"）
            foreach($allPlays as $play) {
                if(strpos($remaining, $play) === 0) {
                    $plays[] = $play;
                    $remaining = substr($remaining, strlen($play));
                    $found = true;
                    break;
                }
            }
            
            if(!$found) {
                // 如果没有匹配到任何玩法，跳过当前字符
                $remaining = substr($remaining, 1);
            }
        }
        
        return $plays;
    }

    /**
     * 创建投注项
     */
    private function createBetItem($position, $play, $amount, $positionMap, $playMap)
    {
        // 确定位置名称
        $positionName = isset($positionMap[$position]) ? $positionMap[$position] : "位置{$position}";
        
        // 特殊处理龙虎玩法（只能用于总和）
        if($play == '龙' || $play == '虎') {
            if($position == '6') {
                // 龙虎只能用于前五和值
                $playSuffix = ($play == '龙') ? '_L' : '_H';
                $mark = 'LH' . $playSuffix;
                return [
                    'mark' => $mark,
                    'mid' => $position,
                    'mid_name' => '前五和值',
                    'play' => $play,
                    'amount' => $amount
                ];
            } else {
                // 龙虎不能用于平码位置
                return null;
            }
        }
        
        // 确定玩法类型和标记
        $markType = '';
        $playSuffix = '';
        
        if(isset($playMap[$play])) {
            $baseMark = $playMap[$play];
            
            // 根据玩法确定后缀
            switch($play) {
                case '大':
                    $playSuffix = '_D';
                    break;
                case '小':
                    $playSuffix = '_X';
                    break;
                case '单':
                    $playSuffix = '_D';
                    break;
                case '双':
                    $playSuffix = '_S';
                    break;
                case '尾大':
                    $playSuffix = '_D';
                    break;
                case '尾小':
                    $playSuffix = '_X';
                    break;
                case '合单':
                    $playSuffix = '_D';
                    break;
                case '合双':
                    $playSuffix = '_S';
                    break;
                case '福':
                    $playSuffix = '_F';
                    break;
                case '禄':
                    $playSuffix = '_L';
                    break;
                case '寿':
                    $playSuffix = '_S';
                    break;
                case '喜':
                    $playSuffix = '_X';
                    break;
            }
            
            // 生成标记
            if($position == '6') {
                // 和值特殊处理，需要添加Z前缀
                switch($baseMark) {
                    case 'DX':
                        $mark = 'ZDX' . $playSuffix;
                        break;
                    case 'DS':
                        $mark = 'ZDS' . $playSuffix;
                        break;
                    case 'WDX':
                        $mark = 'ZWDX' . $playSuffix;
                        break;
                    default:
                        $mark = $baseMark . $playSuffix;
                }
            } else {
                $mark = $baseMark . $position . $playSuffix;
            }
            
            return [
                'mark' => $mark,
                'mid' => $position,
                'mid_name' => $positionName,
                'play' => $play,
                'amount' => $amount
            ];
        }
        
        return null;
    }

    /**
     * 原有解析方案作为备用
     */
    private function parseLegacyCommand($content, $amount_all)
    {
        //复杂混合格式 (24单20单20等) - 必须放在最前面，避免被其他正则误匹配
        preg_match("/^(\d+)([大小单双龙虎尾大尾小]+)(\d+)([大小单双龙虎尾大尾小]+)(\d+)$/u", $content, $matches);
        if(count($matches)){
            return $this->BetArrayComplex($matches[1], $matches[2], $matches[3], $matches[4], $matches[5], $amount_all); 
        }

        // 新格式解析：如 "1尾小单23456双100"
        preg_match('/^(\d+)([^\d]+)(\d+)([^\d]+)(\d+|梭哈)$/u', $content, $matches);
        if(count($matches) > 0){
            return $this->BetArrayNewFormat($matches[1], $matches[2], $matches[3], $matches[4], $matches[5], $amount_all);
        }

        // 新的解析方案：支持复杂格式如 "2大双尾大4合双福喜100"
        $complexPattern = '/^(.+?)(\d+|梭哈)$/u';
        if(preg_match($complexPattern, $content, $complexMatches)) {
            $playsWithMids = $complexMatches[1];
            $amount = $complexMatches[2];
            
            $multiPattern = '/(\d+)([大小单双龙虎尾大尾小合单合双福禄寿喜]+)/u';
            if(preg_match_all($multiPattern, $playsWithMids, $allMatches, PREG_SET_ORDER)) {
                if(count($allMatches) > 1) {
                    return $this->BetArrayMultiPosition($allMatches, $amount, $amount_all);
                }
            }
        }

        //前五和值默认格式 (大100, 虎100等) - 必须放在位置解析之前
        preg_match("/^([大小单双龙虎尾大尾小]+)\/?(\d+)$/u", $content, $matches);
        if(count($matches)){
            return $this->BetArrayQwhz('前五和值', $matches[1], $matches[2], $amount_all, $err); 
        }

        //分开成两条 - 兼容原有格式
        preg_match("/^([0-9]+)([大小单双龙虎尾大尾小合单合双福禄寿喜]+)\/?(\d*|梭哈)$/u", $content, $matches);
        $count = count($matches);
        if($count > 0){
            return $this->BetArrayDxdsl($matches[1], $matches[2], $matches[3], $amount_all); 
        }

        //大小单双龙 -- 
        preg_match("/^([0-9]+)\/?([大小单双龙虎尾大尾小合单合双福禄寿喜]+)\/?(\d*|梭哈)$/u", $content, $matches);
        if(count($matches) > 0 && preg_match('/\d+单\d+单\d+/', $matches[2])) {
            $matches = array();
        }
        $count = count($matches);
        if($count > 0){
            return $this->BetArrayDxdsl($matches[1], $matches[2], $matches[3], $amount_all); 
        }

        //前五和值类型
        preg_match("/^(前五和值|和|前五|6)\/?([大小单双龙虎尾大尾小]+)\/?(\d*|梭哈)$/u", $content, $matches);
        if(count($matches)){
            return $this->BetArrayQwhz($matches[1], $matches[2], $matches[3], $amount_all, $err); 
        }

        //位置类型
        preg_match("/^(\d+)\/(\d+)\/(\d*|梭哈)+$/u", $content, $matches);
        if(count($matches)){
            return $this->BetArrayWeizhi($matches[1], $matches[2], $matches[3], $amount_all, $err); 
        }

        //前三类型
        preg_match("/^(前|后)(一|二|三|四|五|六|七|八|九|十|1|2|3|4|5|6|7|8|9|0)\/?(\d+)\/(\d*|梭哈)+$/u", $content, $matches);
        if(count($matches)){
            return $this->BetArrayQianhou($matches[1], $matches[2], $matches[3], $matches[4], $err); 
        }

        return null;
    }
    

    //默认排序 - 按1-10车, 号码->大小单双-> 排列
    private function SortDefault($datas)
    {
        try{
            if(count($datas) > 0){
                usort($datas, function($a, $b) {
                    $ageDiff = $a['mid'] - $b['mid'];
                    if ($ageDiff === 0) {
                        return strcmp($a['play'], $b['play']);
                    }
                    return $ageDiff;
                });
            }
        }
        catch(\Exception $e){
            throw new \Exception(sprintf("err=101, 排序错误:%s", $e->getMessage()));
        }
    }

    private function SetItemsSuoHaAmount(&$datas, $amount_all)
    {
        $count = count($datas);
        $amount_lite = (int)($amount_all / $count);
        for($i = 0; $i < $count; $i++)
        {
            $datas[$i]['amount'] = $amount_lite;
        }
    }

    //----------------------------------------------------------------
    // 以下是内部的函数
    //----------------------------------------------------------------      
    //解析数据: 大小单双龙虎尾大尾小合单合双福禄寿喜
    //返回值: json data:[{bname=平码一, mark:B1_1, mid=1, play:大, amount:1000}, {bname=平码一, sname:B1_1, play:小, amout:2000}
    private function BetArrayDxdsl($mids, $plays, $amount, $amount_suoha)
    {
        if(empty($amount))
            $amount = 10;   //最低默认金额
        if(empty($mids))
            $mids = '1';    //默认是冠军位

        $datas = array();    //{第一球: $data_mid, 第二球: data_mid, 第三球: data_mid}
        
        // 解析玩法，支持多字符玩法
        $pattern = "/(尾大|尾小|合单|合双|大|小|单|双|龙|虎|福|禄|寿|喜|0|1|2|3|4|5|6|7|8|9)/u";
        $playList = array();
        $subject = $plays;
        
        while(preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE))
        {
            $playList[] = $matches[1][0];
            $remainingStart = $matches[0][1] + strlen($matches[0][0]);
            $subject = substr($subject, $remainingStart);
        }
        
        for($i = 0; $i< strlen($mids); $i++)
        {
            $currentMid = $mids[$i];
            //$mid是全数字的, 可以安全遍历
            foreach($playList as $play)
            {
                if(preg_match("/[0-9]/u", $play))
                    continue; // 跳过数字，数字应该是号码不是玩法
                    
                $marktype = '';
                try
                {
                    // 如果是6位置，使用前五和值类型
                    if($currentMid == '6') {
                        $marktype = CmdBase::LargeCateQwhz;
                        $item = $this->GetMarksPlayLarge($marktype, $currentMid, $play, $amount);
                        array_push($datas, $item);
                    } else {
                        // 其他位置使用正常的两面或号码类型
                        if(preg_match("/大|小|单|双|龙|虎|尾大|尾小|合单|合双|福|禄|寿|喜/u", $play))
                            $marktype = CmdBase::LargeCateLiangMian;
                        else
                            $marktype = CmdBase::LargeCateHaoMa;

                        $item = $this->GetMarksPlayLarge($marktype, $currentMid, $play, $amount);
                        array_push($datas, $item);
                    }
                }
                catch(\Exception $e)
                {
                    throw new \Exception(sprintf("err=100, 不匹配:%s-%s-%s", $currentMid, $play, $amount));
                }
            }
        }
        $this->SortDefault($datas);
        if($amount == '梭哈'){
            $this->SetItemsSuoHaAmount($datas, $amount_suoha);
        }
        
        
        return $datas;
    }

    //解析多位置格式: 如 "2大双尾大4合双福喜100"
    //参数: $allMatches - 所有匹配的位置和玩法组合
    //返回值: 投注数据数组
    private function BetArrayMultiPosition($allMatches, $amount, $amount_suoha)
    {
        if(empty($amount))
            $amount = 10;   //最低默认金额

        $datas = array();
        
        foreach($allMatches as $match) {
            $mid = $match[1];        // 位置，如 "2", "4"
            $plays = $match[2];      // 玩法串，如 "大双尾大", "合双福喜"
            
            // 解析每个位置的具体玩法
            $playPattern = '/(尾大|尾小|合单|合双|大|小|单|双|龙|虎|福|禄|寿|喜)/u';
            if(preg_match_all($playPattern, $plays, $playMatches)) {
                foreach($playMatches[1] as $play) {
                    $marktype = '';
                    try {
                        // 如果是6位置，使用前五和值类型
                        if($mid == '6') {
                            $marktype = CmdBase::LargeCateQwhz;
                            $item = $this->GetMarksPlayLarge($marktype, $mid, $play, $amount);
                            array_push($datas, $item);
                        } else {
                            // 其他位置使用正常的两面或号码类型
                            if(preg_match("/大|小|单|双|龙|虎|尾大|尾小|合单|合双|福|禄|寿|喜/u", $play))
                                $marktype = CmdBase::LargeCateLiangMian;
                            else
                                $marktype = CmdBase::LargeCateHaoMa;

                            $item = $this->GetMarksPlayLarge($marktype, $mid, $play, $amount);
                            array_push($datas, $item);
                        }
                    }
                    catch(\Exception $e) {
                        throw new \Exception(sprintf("err=100, 不匹配:%s-%s-%s", $mid, $play, $amount));
                    }
                }
            }
        }
        
        $this->SortDefault($datas);
        if($amount == '梭哈'){
            $this->SetItemsSuoHaAmount($datas, $amount_suoha);
        }
        
        return $datas;
    }

    //复杂混合格式解析
    // status: 
    public function BetArrayComplex($positions, $play1, $amount1, $play2, $amount2, $amount_suoha)
    {
        $datas = array();
        
        // 解析位置字符串，如 "24" 表示位置2和位置4
        for($i = 0; $i < strlen($positions); $i++) {
            $mid = $positions[$i];
            $item = $this->GetMarksPlayLarge(CmdBase::LargeCateLiangMian, $mid, $play1, $amount1);
            if($item) {
                array_push($datas, $item);
            }
        }
        
        // 添加前五和值投注
        $item = $this->GetMarksPlayLarge(CmdBase::LargeCateQwhz, '6', $play2, $amount2);
        if($item) {
            array_push($datas, $item);
        }
        
        $this->SortDefault($datas);
        return $datas;
    }

    //前五和值
    // status: 
    private function BetArrayQwhz($mid, $sums, $amount, $amount_suoha, &$errmsg)
    {
        $datas = array();
        //解析sums里面有几个是数字组合和玩法
        //有22,21,20...大小单双龙虎尾大尾小
        $pattern = "/(大|小|单|双|龙|虎|尾大|尾小|50|49|48|47|46|45|44|43|42|41|40|39|38|37|36|35|34|33|32|31|30|29|28|27|26|25|24|23|22|21|20|19|18|17|16|15|14|13|12|11|10|9|8|7|6|5)/u";  //要匹配的表达式
        $plays = array();  //plays 玩法, 和值内容, 中间13141516部分    和/13141516/100
        $ismatch = true;
        $subject = $sums;
        //默认值
        if(empty($amount)){
            $amount = 10;
        }

        while($ismatch)
        {
            if(preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE))
            {
                $errmsg = '';
                // 计算剩余字符串的起始位置
                $remainingStart = $matches[0][1] + strlen($matches[0][0]);
                // 使用substr()截取剩余字符串
                $subject = substr($subject, $remainingStart);
                if(!empty($matches))
                {
                    array_push($plays, $matches[1][0]);
                }
            }
            else
            {
                break;
            }
            
            if(!empty($subject))
            {
                $errmsg = sprintf("有未处理的和值:%s", $subject);
            }
        }

        if(!empty($plays))
        {
            $marks = $this->GetMarks('前五和值');
            foreach($plays as $sum)
            {
                $item = $this->GetMarksPlayLarge(CmdBase::LargeCateQwhz, '', $sum, $amount);
                array_push($datas, $item);
            }
        }

        if($amount == '梭哈'){
            $this->SetItemsSuoHaAmount($datas, $amount_suoha);
        }
        // if(count($result) > 0){
        //     usort($result, function($a, $b) {
        //         $ageDiff = $a['mid'] - $b['mid'];
        //         if ($ageDiff === 0) {
        //             $a_play = $a['play'];
        //             $b_play = $b['play'];
        //             $othertype= array('3'=>3, '大' =>21, '小'=>22, '单'=> 23, '双'=>24);
        //             if(gettype($a_play) == 'string')
        //             {
        //                 $a_play = $othertype[$a_play];
        //             }
        //             if(gettype($b_play) == 'string')
        //             {
        //                 $b_play = $othertype[$b_play];
        //             }
        //             return $a_play- $b_play;
        //         }
        //         return $ageDiff;
        //     });
        // }
        return $datas;
    }

    //位置类型
    //$mid 位置
    //$value 可能开出的车号, 1或者 123678
    //即在地一个和位下  1/123678
    private function BetArrayWeizhi($mids, $value, $amount, $amount_suoha, &$errmsg)
    {
        if(empty($amount))
        $amount = 10;   //最低默认金额
        if(empty($mids))
            $mids = '1';    //默认是冠军位

        $data = array();
        for($i = 0; $i< strlen($mids); $i++)
        {
            $mid = $mids[$i];

                for($k = 0 ; $k < mb_strlen($value); $k++)
                {
                    $play = mb_substr($value, $k, 1);
                    $item = $this->GetMarksPlayLarge(CmdBase::LargeCateHaoMa, $mid, $play, $amount);
                    array_push($data, $item);
                }

        }
        if(count($data) > 0){
            usort($data, function($a, $b) {
                $ageDiff = $a['mid'] - $b['mid'];
                if ($ageDiff === 0) {
                    return $a['play'] - $b['play'];
                }
                return $ageDiff;
            });
        }

        if($amount == '梭哈'){
            $this->SetItemsSuoHaAmount($data, $amount_suoha);
        }

        return $data;
    }

    //前后
    private function BetArrayQianhou($qh, $numstr, $value, $amount, &$errmsg)
    {
        if(empty($amount))
        $amount = 10;   //最低默认金额

        $numarray = array('一'=>1, '二'=>2, '三'=>3,'四'=>4, '五'=>5, '六'=>6, '七'=>7, '八'=>8, '九'=>9, '十'=>0,
                         '0'=>0, '1'=>1, '2'=>2, '3'=>3, '4'=>4, '5'=>5, '6'=>6, '7'=>7, '8'=>8, '9'=>9);
        $num = $numarray[$numstr];

        $mids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        if($qh == '前')
        {
            $mids = array_slice($mids, 0, $num ); 
        }
        else if($qh == '后')
        {

            $mids = array_slice($mids, count($mids)-$num, $num);
        }

        $data = array();
        foreach($mids as $mid)
        {
            for($k = 0 ; $k < mb_strlen($value); $k++)
            {
                $play = mb_substr($value, $k, 1);
                $item = $this->GetMarksPlayLarge(CmdBase::LargeCateHaoMa, $mid, $play, $amount);
                array_push($data,  $item);
            }
        }
        return $data;
    }

    //新格式解析：如 "1尾小单23456双100"
    // 格式：位置+玩法+多个位置数字+玩法+金额
    private function BetArrayNewFormat($mid, $play1, $mids, $play2, $amount, $amount_suoha)
    {
        if(empty($amount))
            $amount = 10;   //最低默认金额

        $datas = array();
        
        // 解析第一个位置的玩法（如"尾小单"）
        $playPattern = '/(尾大|尾小|合单|合双|大|小|单|双|龙|虎|福|禄|寿|喜)/u';
        if(preg_match_all($playPattern, $play1, $playMatches)) {
            foreach($playMatches[1] as $play) {
                $marktype = '';
                try {
                    if(preg_match("/大|小|单|双|龙|虎|尾大|尾小|合单|合双|福|禄|寿|喜/u", $play))
                        $marktype = CmdBase::LargeCateLiangMian;
                    else
                        $marktype = CmdBase::LargeCateHaoMa;

                    $item = $this->GetMarksPlayLarge($marktype, $mid, $play, $amount);
                    if($item) {
                        array_push($datas, $item);
                    }
                }
                catch(\Exception $e) {
                    throw new \Exception(sprintf("err=100, 不匹配:%s-%s-%s", $mid, $play, $amount));
                }
            }
        }

        // 解析多个位置数字（如"23456"），每个位置都使用第二个玩法（如"双"）
        for($i = 0; $i < strlen($mids); $i++) {
            $currentMid = $mids[$i];
            $marktype = '';
            try {
                if(preg_match("/大|小|单|双|龙|虎|尾大|尾小|合单|合双|福|禄|寿|喜/u", $play2))
                    $marktype = CmdBase::LargeCateLiangMian;
                else
                    $marktype = CmdBase::LargeCateHaoMa;

                $item = $this->GetMarksPlayLarge($marktype, $currentMid, $play2, $amount);
                if($item) {
                    array_push($datas, $item);
                }
            }
            catch(\Exception $e) {
                throw new \Exception(sprintf("err=100, 不匹配:%s-%s-%s", $currentMid, $play2, $amount));
            }
        }

        $this->SortDefault($datas);
        if($amount == '梭哈'){
            $this->SetItemsSuoHaAmount($datas, $amount_suoha);
        }

        return $datas;
    }

    //获得玩法大类别。标记。
    ///@todo
    //$mid  0123456789
    //play  大小单双龙虎, 进来的玩法是单一的
    public function GetMarksPlayLarge($largeCate, $mid, $play, $amount)
    {
        if($mid == 0) 
            $mid = 10;  //mid位置代码.
        $LargeCateMark = array();
        $nums = array('一', '二','三', '四', '五', '六', '七', '八', '九', '十');
        switch($largeCate)
        {
            case CmdBase::LargeCateLiangMian:
                $pmNames = [1=>'平码一', 2=>'平码二', 3=>'平码三', 4=>'平码四', 5=>'平码五'];
                $number = isset($pmNames[$mid]) ? $pmNames[$mid] : (($mid <= 10) ? $nums[$mid-1] : $mid);
                $LargeCateMark['大'] = ['mark'=> sprintf('DX%d_D', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['小'] = ['mark'=> sprintf('DX%d_X', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount ];
                $LargeCateMark['单'] = ['mark'=> sprintf('DS%d_D', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['双'] = ['mark'=> sprintf('DS%d_S', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                // 移除龙虎玩法，因为龙虎只能用于前五和值，不能用于平码位置
                // $LargeCateMark['龙'] = ['mark'=> sprintf('LH%d_L', $mid), 'mid'=>$mid, 'mid_name' => sprintf('%s龙', $number), 'play'=>$play, 'amount'=>$amount];
                // $LargeCateMark['虎'] = ['mark'=> sprintf('LH%d_H', $mid), 'mid'=>$mid, 'mid_name' => sprintf('%s虎', $number), 'play'=>$play, 'amount'=>$amount];
                // 新增玩法支持
                $LargeCateMark['尾大'] = ['mark'=> sprintf('WDX%d_D', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['尾小'] = ['mark'=> sprintf('WDX%d_X', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['合单'] = ['mark'=> sprintf('HDS%d_D', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['合双'] = ['mark'=> sprintf('HDS%d_S', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['福'] = ['mark'=> sprintf('FLSX%d_F', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['禄'] = ['mark'=> sprintf('FLSX%d_L', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['寿'] = ['mark'=> sprintf('FLSX%d_S', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['喜'] = ['mark'=> sprintf('FLSX%d_X', $mid), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                if(isset($LargeCateMark[$play])) {
                    return $LargeCateMark[$play];
                } else {
                    // 如果找不到复合玩法，尝试拆分
                    $validPlays = ['大', '小', '单', '双', '尾大', '尾小', '合单', '合双', '福', '禄', '寿', '喜'];
                    foreach($validPlays as $validPlay) {
                        if(strpos($play, $validPlay) !== false) {
                            return $LargeCateMark[$validPlay];
                        }
                    }
                    throw new \Exception(sprintf("err=102, 不支持的玩法:%s", $play));
                }
            case CmdBase::LargeCateQwhz:
                if($play == '大')
                    $marks = ['mark'=> sprintf('ZDX_D'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else if($play == '小')
                    $marks = ['mark'=> sprintf('ZDX_X'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else if($play == '单')
                    $marks = ['mark'=> sprintf('ZDS_D'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else if($play == '双')
                    $marks = ['mark'=> sprintf('ZDS_S'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else if($play == '龙')
                    $marks = ['mark'=> sprintf('LH_L'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else if($play == '虎')
                    $marks = ['mark'=> sprintf('LH_H'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else if($play == '尾大')
                    $marks = ['mark'=> sprintf('ZWDX_D'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else if($play == '尾小')
                    $marks = ['mark'=> sprintf('ZWDX_X'), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                else
                    // 具体和值数字
                    $marks = ['mark'=> sprintf('QWHZ_%s', $play), 'mid'=>6, 'mid_name' => '前五和值', 'play'=>$play, 'amount'=>$amount];
                return $marks;
            case CmdBase::LargeCateHaoMa:
                //$mid = 外部保证是 0-9  排名
                //$play包含车号，和大小单双
                $pmNames = [1=>'平码一', 2=>'平码二', 3=>'平码三', 4=>'平码四', 5=>'平码五'];
                $number = isset($pmNames[$mid]) ? $pmNames[$mid] : (($mid <= 10) ? $nums[$mid-1] : $mid);
                $marks = ['mark'=> sprintf('B%s_%s', $mid, $play), 'mid'=>$mid, 'mid_name' => $number, 'play'=>$play, 'amount'=>$amount];
                return $marks;
                break;
            default:
                break;
        }

        return null;
    }

    private function GetMarks($mid)
    {
        $marks = array();
        $marks['0'] = ['mid'=> $mid, 'bname'=> '第十名', 'mark' => 'B1_10',];
        $marks['1'] = ['mid'=> $mid, 'bname'=> '冠军', 'mark' => 'B1_1',];
        $marks['2'] = ['mid'=> $mid, 'bname'=> '亚军', 'mark' => 'B1_2',];
        $marks['3'] = ['mid'=> $mid, 'bname'=> '第三名', 'mark' => 'B1_3',];
        $marks['4'] = ['mid'=> $mid, 'bname'=> '第四名', 'mark' => 'B1_4',];
        $marks['5'] = ['mid'=> $mid, 'bname'=> '第五名', 'mark' => 'B1_5',];
        $marks['6'] = ['mid'=> $mid, 'bname'=> '第六名', 'mark' => 'B1_6',];
        $marks['7'] = ['mid'=> $mid, 'bname'=> '第七名', 'mark' => 'B1_7',];
        $marks['8'] = ['mid'=> $mid, 'bname'=> '第八名', 'mark' => 'B1_8',];
        $marks['9'] = ['mid'=> $mid, 'bname'=> '第九名', 'mark' => 'B1_9',];
        $marks['前五和值'] = ['mid'=> $mid, 'bname'=> '前五和值', 'mark' => 'B1_qwhz',];
         $mark = $marks[$mid];
         return $mark;
    }
}