<?php

namespace App\ComServices;

use Psy\CodeCleaner\ReturnTypePass;


class CmdPk extends CmdBase
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
        $err = '';
        $data = null;
        $status = 0;
        try
        {
            //分开成两条
            preg_match("/^([0-9]+)([大小单双龙虎]+)\/?(\d*|梭哈)$/u", $content, $matches);
            $count = count($matches);
            if($count > 0){
                $status = 1;
                $data = $this->BetArrayDxdsl($matches[1], $matches[2], $matches[3], $amount_all); 
                return;
            }

            //大小单双龙 -- 
            preg_match("/^([0-9]+)?\/?([大小单双龙虎0123456789]+)\/?(\d*|梭哈)$/u", $content, $matches);
            $count = count($matches);
            if($count > 0){
                $status = 1;
                $data = $this->BetArrayDxdsl($matches[1], $matches[2], $matches[3], $amount_all); 
                return;
            }

            //和类型
            preg_match("/^(冠亚和|和|冠亚)\/?([0-9大小单双]+)\/(\d*|梭哈)+$/u", $content, $matches);
            if(count($matches)){
                $status = 1;
                $data = $this->BetArrayGyh($matches[1], $matches[2], $matches[3], $amount_all, $err); 
                return;
            }

            //位置类型
            preg_match("/^(\d+)\/(\d+)\/(\d*|梭哈)+$/u", $content, $matches);
            if(count($matches)){
                $status = 1;
                $data = $this->BetArrayWeizhi($matches[1], $matches[2], $matches[3], $amount_all, $err); 
                return;
            }

            //前三类型
            preg_match("/^(前|后)(一|二|三|四|五|六|七|八|九|十|1|2|3|4|5|6|7|8|9|0)\/?(\d+)\/(\d*|梭哈)+$/u", $content, $matches);
            if(count($matches)){
                $status = 1;
                $data = $this->BetArrayQianhou($matches[1], $matches[2], $matches[3], $matches[4], $err); 
                return;
            }

        }
        catch(\Exception $e)
        {
            $err = $e->getMessage();
            $status = -1;
        }
        finally
        {
            return  $this->CmdResult($status, $data, $err, $json);
        }
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
    //解析数据: 大小单双龙
    //返回值: json data:[{bname=第一球, mark:B1_1, mid=1, play:大, amount:1000}, {bname=第一球, sname:B1_1, play:小, amout:2000}
    private function BetArrayDxdsl($mids, $plays, $amount, $amount_suoha)
    {
        if(empty($amount))
            $amount = 10;   //最低默认金额
        if(empty($mids))
            $mids = '1';    //默认是冠军位

        $datas = array();    //{第一球: $data_mid, 第二球: data_mid, 第三球: data_mid}
        for($i = 0; $i< strlen($mids); $i++)
        {
            //$mid是全数字的, 可以安全遍历
                for($k = 0 ; $k < mb_strlen($plays); $k++)
                {
                    $play = mb_substr($plays, $k, 1);
                    $marktype = '';
                    try
                    {
                        if(preg_match("/大|小|单|双|龙|虎/u", $play))
                            $marktype = CmdBase::LargeCateLiangMian;
                        else
                            $marktype = CmdBase::LargeCateHaoMa;
    
                        $item = $this->GetMarksPlayLarge($marktype, $mids[$i], $play, $amount);
                        array_push($datas, $item);
                    }
                    catch(\Exception $e)
                    {
                        throw new \Exception(sprintf("err=100, 不匹配:%s-%s-%s", $mids[$i], $play, $amount));
                    }
                }
        }
        $this->SortDefault($datas);
        if($amount == '梭哈'){
            $this->SetItemsSuoHaAmount($datas, $amount_suoha);
        }
        
        
        return $datas;
    }

    //冠亚和, 和
    // status: 
    private function BetArrayGyh($mid, $sums, $amount, $amount_suoha, &$errmsg)
    {
        $datas = array();
        //解析sums里面有几个是数字组合
        //有19,18,17...单双大小
        $pattern = "/(19|18|17|16|15|14|13|12|11|10|9|8|7|6|5|4|3|大|小|单|双)/u";  //要匹配的表达式
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
            $marks = $this->GetMarks('和');
            foreach($plays as $sum)
            {
                $item = $this->GetMarksPlayLarge(CmdBase::LargeCateGyh, '', $sum, $amount);
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

    //获得玩法大类别。标记。
    ///@todo
    //$mid  0123456789
    //play  大小单双龙虎, 进来的玩法是单一的
    private function GetMarksPlayLarge($largeCate, $mid, $play, $amount)
    {
        if($mid == 0) 
            $mid = 10;  //mid位置代码.
        $LargeCateMark = array();
        $nums = array('一', '二','三', '四', '五', '六', '七', '八', '九', '十');
        switch($largeCate)
        {
            case CmdBase::LargeCateLiangMian:
                $number = $nums[$mid-1];
                $LargeCateMark['大'] = ['mark'=> sprintf('DX%d_D', $mid), 'mid'=>$mid, 'mid_name' => sprintf('第%s名', $number), 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['小'] = ['mark'=> sprintf('DX%d_X', $mid), 'mid'=>$mid, 'mid_name' => sprintf('第%s名', $number), 'play'=>$play, 'amount'=>$amount ];
                $LargeCateMark['单'] = ['mark'=> sprintf('DS%d_D', $mid), 'mid'=>$mid, 'mid_name' => sprintf('第%s名', $number), 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['双'] = ['mark'=> sprintf('DS%d_S', $mid), 'mid'=>$mid, 'mid_name' => sprintf('第%s名', $number), 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['龙'] = ['mark'=> sprintf('LH%d_L', $mid), 'mid'=>$mid, 'mid_name' => sprintf('%s龙', $number), 'play'=>$play, 'amount'=>$amount];
                $LargeCateMark['虎'] = ['mark'=> sprintf('LH%d_H', $mid), 'mid'=>$mid, 'mid_name' => sprintf('%s虎', $number), 'play'=>$play, 'amount'=>$amount];
                return $LargeCateMark[$play];
            case CmdBase::LargeCateGyh:
                if($play == '大')
                    $marks = ['mark'=> sprintf('GDX_D'), 'mid'=>11, 'mid_name' => sprintf('冠亚和'), 'play'=>$play, 'amount'=>$amount];
                else if($play == '小')
                    $marks = ['mark'=> sprintf('GDX_X'), 'mid'=>11, 'mid_name' => sprintf('冠亚和'), 'play'=>$play, 'amount'=>$amount];
                else if($play == '单')
                    $marks = ['mark'=> sprintf('GDS_D'), 'mid'=>11, 'mid_name' => sprintf('冠亚和'), 'play'=>$play, 'amount'=>$amount];
                else if($play == '双')
                    $marks = ['mark'=> sprintf('GDS_S'), 'mid'=>11, 'mid_name' => sprintf('冠亚和'), 'play'=>$play, 'amount'=>$amount];
                else if($play == '龙')
                    $marks = ['mark'=> sprintf('GYH_%s', $play),  'mid'=>11, 'mid_name' => sprintf('冠亚和'), 'play'=>$play, 'amount'=>$amount];
                return $marks;
            case CmdBase::LargeCateHaoMa:
                //$mid = 外部保证是 0-9  排名
                //$play包含车号，和大小单双
                $number = $nums[$mid-1];
                $marks = ['mark'=> sprintf('B%s_%s', $mid, $play), 'mid'=>$mid, 'mid_name' => sprintf('第%s名',  $number), 'play'=>$play, 'amount'=>$amount];
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
        $marks['和'] = ['mid'=> $mid, 'bname'=> '冠亚和', 'mark' => 'B1_gyh',];
         $mark = $marks[$mid];
         return $mark;
    }
}