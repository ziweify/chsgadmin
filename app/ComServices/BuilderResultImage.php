<?php

namespace App\ComServices;

use App\ort\common\JsFunc;

class BuilderResultImage
{
    public static function getImgObj($imgPath){
        $pathInfo = pathinfo($imgPath);
        $oldLevel = null; // 初始化错误报告级别变量
        
        switch (strtolower($pathInfo['extension'])) {
            case 'jpg':
            case 'jpeg':
                $imagecreatefromjpeg = 'imagecreatefromjpeg';
                break;
            case 'png':
                $imagecreatefromjpeg = 'imagecreatefrompng';
                // 临时禁用PNG警告，抑制libpng sRGB配置文件警告
                $oldLevel = error_reporting(E_ALL & ~E_WARNING);
                break;
            case 'gif':
            default:
                $imagecreatefromjpeg = 'imagecreatefromstring';
                $imgPath = file_get_contents($imgPath);
                break;
        }
        
        $resource = $imagecreatefromjpeg($imgPath);
        
        // 恢复错误报告级别（仅在处理PNG时需要）
        if ($oldLevel !== null) {
            error_reporting($oldLevel);
        }
        
        return $resource;
    }

    public static function buildSscImg($gid,$fenlei,$openInfo){
        $basepath = base_path() . '/public';
        $bgPath = $basepath.'/openimg/ssc/bodybg.png';
        $openNums = $openInfo['open_num'];
        $logoPath = $basepath . "/openimg/ssc/{$gid}.png";
        $beforePath = $basepath . "/openimg/ssc/before.png";

        $backImgObj = self::getImgObj($bgPath);//背景图
        $logoPathObj = self::getImgObj($logoPath);//logo图
        $beforePathObj = self::getImgObj($beforePath);//号码背景图

        $logor_w = imagesx($logoPathObj);
        $logor_h = imagesy($logoPathObj);
        $before_w = imagesx($beforePathObj);
        $before_h = imagesy($beforePathObj);

        $oneRate = 1;
        $otherRate = 0.5;
        $zhsum = 0;

        //logo名称
        imagecopyresampled($backImgObj, $logoPathObj, 172, 0, 0, 0, $logor_w * $oneRate, $logor_h * $oneRate, $logor_w, $logor_h); // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度
        $left = 160;$hmtop = 320;$dxtop = 180;$dstop = 460;$tshmtop = 520;$tshmleft = 745;
        foreach ($openNums as $numImgName) {
            $targetWH = 98;$targetWH1 = 50;$zhsum += intval($numImgName);
            //大小
            $daxiao = JsFunc::dx($fenlei,$numImgName,2);
            $dxpath = $basepath . '/openimg/ssc/dx/'.$daxiao.'.png';
            $dxObj = self::getImgObj($dxpath);
            $dxw = imagesx($dxObj);$dxh = imagesy($dxObj);
            imagecopyresampled($backImgObj, $dxObj, $left, $dxtop, 0, 0, $dxw, $dxh, $dxw, $dxh);
            //号码
            $hmpath = $basepath . '/openimg/ssc/'.$numImgName.'.png';
            $hmObj = self::getImgObj($hmpath);
            $hmw = imagesx($hmObj);$hmh = imagesy($hmObj);
            imagecopyresampled($backImgObj, $beforePathObj, $left, $hmtop, 0, 0, $before_w * $oneRate, $before_h * $oneRate, $before_w, $before_h);
            imagecopyresampled($backImgObj, $hmObj, $left, $hmtop, 0, 0, $hmw, $hmh, $hmw, $hmh);

            //小的号码
            imagecopyresampled($backImgObj, $beforePathObj, $tshmleft, $tshmtop, 0, 0, $before_w * $otherRate, $before_h * $otherRate, $before_w, $before_h);
            imagecopyresampled($backImgObj, $hmObj, $tshmleft, $tshmtop, 0, 0, $hmw * $otherRate, $hmh * $otherRate, $hmw, $hmh);

            //单双
            $danshaung = JsFunc::ds($fenlei,$numImgName,3);
            $dspath = $basepath . '/openimg/ssc/ds/'.$danshaung.'.png';
            $dsObj = self::getImgObj($dspath);
            $dsw = imagesx($dsObj);$dsh = imagesy($dsObj);
            imagecopyresampled($backImgObj, $dsObj, $left, $dstop, 0, 0, $dsw, $dsh, $dsw, $dsh);

            $left = $left + $targetWH + 15;
            $tshmleft = $tshmleft + $targetWH1 + 10;
        }

        //写入文字
        $whiteColor = imagecolorallocate($backImgObj, 255, 255, 255);
        $redColor = imagecolorallocate($backImgObj, 255, 0, 0);

        //总和
        $arr = [];
        $arr[] = $zhsum;
        $arr[] = JsFunc::zhdx($fenlei,$zhsum,1);
        $arr[] = JsFunc::ds($fenlei,$zhsum,1);
        $arr[] = JsFunc::longhuhe($openNums[0],$openNums[4],1);
        $zhText = implode('  ', $arr);
        imagettftext($backImgObj, 16, 0, 745, 500, $whiteColor, $basepath . '/openimg/st.ttf', $zhText);
        imagettftext($backImgObj, 16, 0, 745, 500, $whiteColor, $basepath . '/openimg/st.ttf', $zhText);
        imagettftext($backImgObj, 16, 0, 745, 500, $whiteColor, $basepath . '/openimg/st.ttf', $zhText);

        //期数
        $qText = "本期：";
        $qishu = $openInfo['period'];
        $eText = "期";
        imagettftext($backImgObj, 14, 0, 790, 255, 0, $basepath . '/openimg/st.ttf', $qText);
        imagettftext($backImgObj, 14, 0, 845, 255, $redColor, $basepath . '/openimg/st.ttf', $qishu);
        imagettftext($backImgObj, 14, 0, 945, 255, 0, $basepath . '/openimg/st.ttf', $eText);
        //下期开奖
        $nqText = "下期开奖：";
        imagettftext($backImgObj, 14, 0, 790, 300, 0, $basepath . '/openimg/st.ttf', $nqText);
        imagettftext($backImgObj, 14, 0, 880, 300, $redColor, $basepath . '/openimg/st.ttf', $openInfo['next_time']);

        //$backImgObj = self::buildOpenNum($backImgObj, 150, 15, $openNums);
        return $backImgObj;
    }

    public static function buildScImg($gid,$fenlei,$openInfo,$ctype){
        $basepath = base_path() . '/public';
        $bgPath = $basepath.'/openimg/sc/bodybg.png';
        $openNums = $openInfo['open_num'];
        $logoPath = $basepath . "/openimg/{$ctype}/{$gid}.png";
        $headerPath = $basepath . "/openimg/sc/top_header.jpg";
        $firstImgPath = $basepath."/openimg/{$ctype}/winner". $openNums[0] . '.png';
        $secondImgPath = $basepath."/openimg/{$ctype}/winner". $openNums[1] . '.png';
        $thirdImgPath = $basepath."/openimg/{$ctype}/winner". $openNums[2] . '.png';
        $f1Path = $basepath.'/openimg/sc/f1.png';
        $f2Path = $basepath.'/openimg/sc/f2.png';
        $f3Path = $basepath.'/openimg/sc/f3.png';
        $footerPath = $basepath.'/openimg/sc/footer.png';

        $backImgObj = self::getImgObj($bgPath);//背景图
        $logoPathObj = self::getImgObj($logoPath);//logo图
        $headerPathObj = self::getImgObj($headerPath);//号码背景图
        $f1PathObj = self::getImgObj($f1Path);
        $f2PathObj = self::getImgObj($f2Path);
        $f3PathObj = self::getImgObj($f3Path);
        $firstImgPathObj = self::getImgObj($firstImgPath);
        $secondImgPathObj = self::getImgObj($secondImgPath);
        $thirdImgPathObj = self::getImgObj($thirdImgPath);
        $footerPathObj = self::getImgObj($footerPath);

        $bg_w = imagesx($backImgObj);
        $bg_h = imagesy($backImgObj);

        $logor_w = imagesx($logoPathObj);
        $logor_h = imagesy($logoPathObj);
        $header_w = imagesx($headerPathObj);
        $header_h = imagesy($headerPathObj);
        $f1_w = imagesx($f1PathObj);
        $f1_h = imagesy($f1PathObj);
        $f2_w = imagesx($f2PathObj);
        $f2_h = imagesy($f2PathObj);
        $f3_w = imagesx($f3PathObj);
        $f3_h = imagesy($f3PathObj);
        $firstImg_w = imagesx($firstImgPathObj);
        $firstImg_h = imagesy($firstImgPathObj);
        $secondImg_w = imagesx($secondImgPathObj);
        $secondImg_h = imagesy($secondImgPathObj);
        $thirdImgImg_w = imagesx($thirdImgPathObj);
        $thirdImgImg_h = imagesy($thirdImgPathObj);
        $footer_w = imagesx($footerPathObj);
        $footer_h = imagesy($footerPathObj);

        $oneRate = 1;
        $otherRate = 0.7;
        $zhsum = 0;
        //顶部背景
        imagecopyresampled($backImgObj, $headerPathObj, 0, 0, 0, 0, $header_w * $oneRate, $header_h * $oneRate, $header_w, $header_h);
        //logo名称
        imagecopyresampled($backImgObj, $logoPathObj, 50, 22, 0, 0, $logor_w * $oneRate, $logor_h * 0.7, $logor_w, $logor_h); // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度

        $left = 540;$hmtop = 25;
        foreach ($openNums as $numImgName) {
            $targetWH = 55;
            //号码
            $hmpath = $basepath . '/openimg/sc/result'.$numImgName.'.png';
            $hmObj = self::getImgObj($hmpath);
            $hmw = imagesx($hmObj);$hmh = imagesy($hmObj);
            imagecopyresampled($backImgObj, $hmObj, $left, $hmtop, 0, 0, $hmw*$otherRate, $hmh*$otherRate, $hmw, $hmh);

            $left = $left + $targetWH + 19;
        }

        //冠亚季排名图片
        imagecopyresampled($backImgObj, $f1PathObj, 600, 300, 0, 0, $f1_w * 0.6, $f1_h * 0.6, $f1_w, $f1_h);
        imagecopyresampled($backImgObj, $f2PathObj, 260, 180, 0, 0, $f2_w * 0.6, $f2_h * 0.6, $f2_w, $f2_h);
        imagecopyresampled($backImgObj, $f3PathObj, 920, 180, 0, 0, $f3_w * 0.6, $f3_h * 0.6, $f3_w, $f3_h);

        //1-3名
        imagecopyresampled($backImgObj, $secondImgPathObj, 220, 270, 0, 0, $secondImg_w * 0.6, $secondImg_h * 0.6, $secondImg_w, $secondImg_h);
        imagecopyresampled($backImgObj, $thirdImgPathObj, 850, 255, 0, 0, $thirdImgImg_w * 0.6, $thirdImgImg_h * 0.6, $thirdImgImg_w, $thirdImgImg_h);
        imagecopyresampled($backImgObj, $firstImgPathObj, 540, 410, 0, 0, $firstImg_w * 0.6, $firstImg_h * 0.6, $firstImg_w, $firstImg_h);

        //写入文字
        $whiteColor = imagecolorallocate($backImgObj, 255, 255, 255);
        //$redColor = imagecolorallocate($backImgObj, 255, 0, 0);

        //底部图片
        imagecopyresampled($backImgObj, $footerPathObj, 0, 615, 0, 0, $bg_w, $footer_h*1.3, $footer_w, $footer_h);

        //期数
        $qText = $openInfo['this_time']."   ".$openInfo['period'];
        imagettftext($backImgObj, 18, 0, 75, 718, $whiteColor, $basepath . '/openimg/st.ttf', $qText);
        imagettftext($backImgObj, 18, 0, 75, 718, $whiteColor, $basepath . '/openimg/st.ttf', $qText);

        //冠亚和
        $arr = [];
        $arr[] = $openNums[0]+$openNums[1];
        $arr[] = JsFunc::zhdx($fenlei,$zhsum,1);
        $arr[] = JsFunc::ds($fenlei,$zhsum,1);

        $zhText = implode('  ', $arr);
        imagettftext($backImgObj, 18, 0, 660, 718, $whiteColor, $basepath . '/openimg/st.ttf', $zhText);
        imagettftext($backImgObj, 18, 0, 660, 718, $whiteColor, $basepath . '/openimg/st.ttf', $zhText);
        //imagettftext($backImgObj, 16, 0, 745, 500, $whiteColor, $basepath . '/openimg/st.ttf', $zhText);
        //imagettftext($backImgObj, 16, 0, 745, 500, $whiteColor, $basepath . '/openimg/st.ttf', $zhText);

        //1-5龙虎
        $arr = [];
        $arr[] = JsFunc::longhuhe($openNums[0],$openNums[9],1);
        $arr[] = JsFunc::longhuhe($openNums[1],$openNums[8],1);
        $arr[] = JsFunc::longhuhe($openNums[2],$openNums[7],1);
        $arr[] = JsFunc::longhuhe($openNums[3],$openNums[6],1);
        $arr[] = JsFunc::longhuhe($openNums[4],$openNums[5],1);
        $lhText = implode('  ', $arr);
        imagettftext($backImgObj, 18, 0, 1000, 718, $whiteColor, $basepath . '/openimg/st.ttf', $lhText);
        imagettftext($backImgObj, 18, 0, 1000, 718, $whiteColor, $basepath . '/openimg/st.ttf', $lhText);

        //$backImgObj = self::buildOpenNum($backImgObj, 150, 15, $openNums);
        return $backImgObj;
    }

    public static function buildScOpenListImg($gid,$fenlei,$openlist = []){
        $basepath = base_path() . '/public';
        $bgPath = $basepath.'/openimg/sc/resultlist.png';
        $backImgObj = self::getImgObj($bgPath);//背景图

        //写入文字
        $redColor = imagecolorallocate($backImgObj, 255, 0, 0);

        $oneRate = 1;
        $otherRate = 0.4;
        $zhsum = 0;$length = count($openlist);
        for($i = 0;$i < $length;$i++){
            $openInfo = $openlist[$i];
            $openNums = $openInfo['open_num'];
            $top = 48.1*$i+80;
            $qslen = strlen((string)$openInfo['period']);
            //期数 - 加粗处理
            imagettftext($backImgObj, 18, 0, $qslen <= 8 ? 30 : 10, $top, 0, $basepath . '/openimg/st.ttf', $openInfo['period']);
            //imagettftext($backImgObj, 16, 0, 75, 718, 0, $basepath . '/openimg/st.ttf', $openInfo['period']);
            $left = 190;$hmtop = 48.1*$i+54;
            foreach ($openNums as $num) {
                $targetWH = 30;
                //号码
                $hmpath = $basepath . '/openimg/sc/result'.$num.'.png';
                $hmObj = self::getImgObj($hmpath);
                $hmw = imagesx($hmObj);$hmh = imagesy($hmObj);
                imagecopyresampled($backImgObj, $hmObj, $left, $hmtop, 0, 0, $hmw*$otherRate, $hmh*$otherRate, $hmw, $hmh);
                $left = $left + $targetWH + 10;
            }
            //冠亚和 - 加粗处理
            $gyh = $openNums[0]+$openNums[1];
            imagettftext($backImgObj, 18, 0, 635, $top, 0, $basepath . '/openimg/st.ttf', $gyh);
            //冠亚和大小 - 加粗处理
            $gyhdx = JsFunc::zhdx($fenlei,$gyh,1);
            $color = $gyhdx == '大' ? $redColor : 0;
            imagettftext($backImgObj, 18, 0, 675, $top, $color, $basepath . '/openimg/st.ttf', $gyhdx);
            //冠亚和单双 - 加粗处理
            $gyhds = JsFunc::ds($fenlei,$gyh,1);
            $color = $gyhds == '双' ? $redColor : 0;
            imagettftext($backImgObj, 18, 0, 715, $top, $color, $basepath . '/openimg/st.ttf', $gyhds);
            //1-5龙虎 - 加粗处理
            $lh1 = JsFunc::longhuhe($openNums[0],$openNums[9],1);
            $lh2 = JsFunc::longhuhe($openNums[1],$openNums[8],1);
            $lh3 = JsFunc::longhuhe($openNums[2],$openNums[7],1);
            $lh4 = JsFunc::longhuhe($openNums[3],$openNums[6],1);
            $lh5 = JsFunc::longhuhe($openNums[4],$openNums[5],1);
            $lh1color = $lh1 == '龙' ? $redColor : 0;
            $lh2color = $lh2 == '龙' ? $redColor : 0;
            $lh3color = $lh3 == '龙' ? $redColor : 0;
            $lh4color = $lh4 == '龙' ? $redColor : 0;
            $lh5color = $lh5 == '龙' ? $redColor : 0;
            imagettftext($backImgObj, 18, 0, 780, $top, $lh1color, $basepath . '/openimg/st.ttf', $lh1);
            imagettftext($backImgObj, 18, 0, 815, $top, $lh2color, $basepath . '/openimg/st.ttf', $lh2);
            imagettftext($backImgObj, 18, 0, 845, $top, $lh3color, $basepath . '/openimg/st.ttf', $lh3);
            imagettftext($backImgObj, 18, 0, 880, $top, $lh4color, $basepath . '/openimg/st.ttf', $lh4);
            imagettftext($backImgObj, 18, 0, 915, $top, $lh5color, $basepath . '/openimg/st.ttf', $lh5);
        }
        return $backImgObj;
    }

    public static function buildSscOpenListImg($fenlei,$openlist = []){
        $basepath = base_path() . '/public';
        $bgPath = $basepath.'/openimg/ssc/resultlist.png';
        $backImgObj = self::getImgObj($bgPath);//背景图
        //写入文字
        $redColor = imagecolorallocate($backImgObj, 255, 0, 0);

        $otherRate = 1;$length = count($openlist);
        for($i = 0;$i < $length;$i++){
            $openInfo = $openlist[$i];
            $openNums = $openInfo['open_num'];
            $top = 68.25*$i+90;
            $qslen = strlen((string)$openInfo['period']);
            //期数
            imagettftext($backImgObj, 16, 0, $qslen <= 8 ? 120 : 100, $top, 0, $basepath . '/openimg/st.ttf', $openInfo['period']);
            $left = 350;$hmtop = 68.2*$i+58;$zhsum = 0;
            foreach ($openNums as $num) {
                $zhsum += $num;
                $targetWH = 50;
                //号码
                $hmpath = $basepath . '/openimg/ssc/bkx-'.$num.'.png';
                $hmObj = self::getImgObj($hmpath);
                $hmw = imagesx($hmObj);$hmh = imagesy($hmObj);
                imagecopyresampled($backImgObj, $hmObj, $left, $hmtop, 0, 0, $hmw*$otherRate, $hmh*$otherRate, $hmw, $hmh);
                $left = $left + $targetWH + 15;
            }
            //总和
            imagettftext($backImgObj, 16, 0, 750, $top, 0, $basepath . '/openimg/st.ttf', $zhsum);
            //总和大小
            $zhdx = JsFunc::zhdx($fenlei,$zhsum,1);
            $color = $zhdx == '大' ? $redColor : 0;
            imagettftext($backImgObj, 16, 0, 795, $top, $color, $basepath . '/openimg/st.ttf', $zhdx);
            //总和单双
            $zhds = JsFunc::ds($fenlei,$zhsum,1);
            $color = $zhds == '双' ? $redColor : 0;
            imagettftext($backImgObj, 16, 0, 835, $top, $color, $basepath . '/openimg/st.ttf', $zhds);
            //龙虎
            $lh = JsFunc::longhuhe($openNums[0],$openNums[4],1);
            $lhcolor = $lh == '龙' ? $redColor : 0;
            imagettftext($backImgObj, 16, 0, 890, $top, $lhcolor, $basepath . '/openimg/st.ttf', $lh);
        }
        return $backImgObj;
    }



    public static function buildTwbgOpenListImg($fenlei,$openlist = []){
        $basepath = base_path() . '/public';
        $bgPath = $basepath.'/openimg/bg/openlist.png';
        $backImgObj = self::getImgObj($bgPath);//背景图
        // 启用抗锯齿，提升文字清晰度
        /* if(function_exists('imageantialias')){
            imageantialias($backImgObj, true);
        } */
        //定义颜色
        $redColor = imagecolorallocate($backImgObj, 255, 0, 0);    // 红色：大、双、>40的号码
        $blueColor = imagecolorallocate($backImgObj, 0, 0, 0);   // 蓝色：小、单 255
        $blackColor = imagecolorallocate($backImgObj, 0, 0, 0);   // 黑色：<=40的号码、期数、时间
        //数组反转
        $openlist = array_reverse($openlist);
        $length = count($openlist);
        $rowHeight = 28; // 行高
        $startY = 77;    // 起始Y位置
        
        for($i = 0; $i < $length; $i++){
            $openInfo = $openlist[$i];
            $openNums = $openInfo['open_num'];
            $textY = $startY + $rowHeight * $i + 15; // 文字Y位置
            
                         // 1. 期数 - 只显示后三位（字体加粗）
             $periodDisplay = substr($openInfo['period'], -3);
             imagettftext($backImgObj, 15, 0, 10, $textY, $blackColor, $basepath . '/openimg/st.ttf', $periodDisplay);
             
             // 2. 时间 - HH:MM格式（字体加粗）
             $timeDisplay = date('H:i', $openInfo['kjtime']);
             imagettftext($backImgObj, 15, 0, 64, $textY, $blackColor, $basepath . '/openimg/st.ttf', $timeDisplay);
            
            // 3. 平码一到平码五 - 每个号码显示：号码 大小 单双
            $startX = 99; // 号码区域起始X位置
            $cellWidth = 102; // 每个号码区域宽度
            
            for($j = 0; $j < 5; $j++){
                if(isset($openNums[$j])){
                    $num = $openNums[$j];
                    $x = $startX + $j * $cellWidth;
                    
                    // 号码颜色：<=40黑色，>40红色
                    $numColor = $num <= 40 ? $blackColor : $redColor;
                    
                    // 大小
                    $dx = JsFunc::dx($fenlei, $num, 1);
                    $dxColor = $dx == '大' ? $redColor : $blueColor;
                    
                    // 单双
                    $ds = JsFunc::ds($fenlei, $num, 1);
                    $dsColor = $ds == '双' ? $redColor : $blueColor;
                    
                                         // 显示：号码 大小 单双（字体加粗）
                     $nnn = 0;
                     if($num < 10){
                         $nnn = 6;
                     }
                     // 号码加粗
                     imagettftext($backImgObj, 15, 0, $x + 33 + $nnn, $textY, $numColor, $basepath . '/openimg/st.ttf', $num);
                     imagettftext($backImgObj, 15, 0, $x + 33 + $nnn, $textY, $numColor, $basepath . '/openimg/st.ttf', $num);
                     imagettftext($backImgObj, 15, 0, $x + 33 + $nnn, $textY, $numColor, $basepath . '/openimg/st.ttf', $num);
                     // 大小加粗
                     imagettftext($backImgObj, 15, 0, $x + 69, $textY, $dxColor, $basepath . '/openimg/st.ttf', $dx);
                     imagettftext($backImgObj, 15, 0, $x + 69, $textY, $dxColor, $basepath . '/openimg/st.ttf', $dx);
                     imagettftext($backImgObj, 15, 0, $x + 69, $textY, $dxColor, $basepath . '/openimg/st.ttf', $dx);
                     // 单双加粗
                     imagettftext($backImgObj, 15, 0, $x + 102, $textY, $dsColor, $basepath . '/openimg/st.ttf', $ds);
                     imagettftext($backImgObj, 15, 0, $x + 102, $textY, $dsColor, $basepath . '/openimg/st.ttf', $ds);
                     imagettftext($backImgObj, 15, 0, $x + 102, $textY, $dsColor, $basepath . '/openimg/st.ttf', $ds);
                }
            }
            
            // 4. 总和相关（如果需要显示）
            $zhsum = array_sum(array_map('intval', $openNums));
            $zhdx = JsFunc::zhdx($fenlei, $zhsum, 1);
            $zhds = JsFunc::ds($fenlei, $zhsum, 1);
            $zhdxColor = $zhdx == '大' ? $redColor : $blueColor;
            $zhdsColor = $zhds == '双' ? $redColor : $blueColor;
            
             // 可选：显示总和信息（根据demo.png决定是否需要）
             $totalX = 640; // 总和区域X位置
             // 总和加粗
             $nnn = 0;
             if($zhsum < 100){
                $nnn = 5;
             }
             imagettftext($backImgObj, 15, 0, $totalX + $nnn, $textY, $blackColor, $basepath . '/openimg/st.ttf', $zhsum);
             imagettftext($backImgObj, 15, 0, $totalX + $nnn, $textY, $blackColor, $basepath . '/openimg/st.ttf', $zhsum);
             imagettftext($backImgObj, 15, 0, $totalX + $nnn, $textY, $blackColor, $basepath . '/openimg/st.ttf', $zhsum);
             // 总和大小加粗
             imagettftext($backImgObj, 15, 0, $totalX + 48, $textY, $zhdxColor, $basepath . '/openimg/st.ttf', $zhdx);
             imagettftext($backImgObj, 15, 0, $totalX + 48, $textY, $zhdxColor, $basepath . '/openimg/st.ttf', $zhdx);
             imagettftext($backImgObj, 15, 0, $totalX + 48, $textY, $zhdxColor, $basepath . '/openimg/st.ttf', $zhdx);
             // 总和单双加粗
             imagettftext($backImgObj, 15, 0, $totalX + 81, $textY, $zhdsColor, $basepath . '/openimg/st.ttf', $zhds);
             imagettftext($backImgObj, 15, 0, $totalX + 81, $textY, $zhdsColor, $basepath . '/openimg/st.ttf', $zhds);
             imagettftext($backImgObj, 15, 0, $totalX + 81, $textY, $zhdsColor, $basepath . '/openimg/st.ttf', $zhds);
             //龙虎（字体加粗）
             $lh = JsFunc::longhuhe($openNums[0],$openNums[4],1);
             $lhcolor = $lh == '龙' ? $redColor : $blueColor;
             imagettftext($backImgObj, 15, 0, 756, $textY, $lhcolor, $basepath . '/openimg/st.ttf', $lh);
             imagettftext($backImgObj, 15, 0, 756, $textY, $lhcolor, $basepath . '/openimg/st.ttf', $lh);
             imagettftext($backImgObj, 15, 0, 756, $textY, $lhcolor, $basepath . '/openimg/st.ttf', $lh);
        }
        return $backImgObj;
    }

    public static function doSaveOpenImg($gid,$fenlei,$openinfo,$ctype,$pre = 'open',$imgtype = 'open',$period = '',$date = null){
        $basepath = base_path() . '/public';
        if($fenlei == 107){//pk10
            if($imgtype == 'open'){
                $imgObj = self::buildScImg($gid,$fenlei,$openinfo,$ctype);
            }elseif ($imgtype == 'openlist'){
                $imgObj = self::buildScOpenListImg($gid,$fenlei,$openinfo);
            }
        }elseif ($fenlei == 101){
            if($imgtype == 'open'){
                $imgObj = self::buildSscImg($gid,$fenlei,$openinfo);
            }elseif ($imgtype == 'openlist'){
                $imgObj = self::buildSscOpenListImg($fenlei,$openinfo);
            }
        }elseif ($fenlei == 444){//台湾宾果
            if ($imgtype == 'openlist'){
                $imgObj = self::buildTwbgOpenListImg($fenlei,$openinfo);
            }
        }
        $directory = $basepath."/upload/openimg/{$date}/".$gid;
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        if($imgtype == 'open'){
            self::saveImg($imgObj, $directory.'/'.$pre.'_'.$openinfo['period'], 10);
        }elseif ($imgtype == 'openlist'){
            self::saveImg($imgObj, $directory.'/'.$pre.'_'.$period, 70);
        }
        imagedestroy($imgObj);
    }

    //保存图片，如果存在webp，则保存webp，否则保存jpg
    public static function saveImg($imgObj, $filepath, $quality = 80){
        if(function_exists('imagewebp')){
            imagewebp($imgObj, $filepath.'.webp', $quality);
        }else{
            imagejpeg($imgObj, $filepath.'.jpg', $quality);
        }
    }
}