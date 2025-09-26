<?php


namespace App\ort\kjw\cltool;


class Syx5Changlong
{
    public static function OpenNumberChangLong($BallStringcq, $BallString_acq, $result, $openMax = 2) {
        $numArray1 = array();
        $numArray2 = array();
        $countArray1 = array();
        $countArray2 = array();

        for ($i = 0; $i < count($result); $i++) {
            for ($n = 0; $n < count($result[$i]); $n++) {
                $s = $n + 1;
                $countArray1 += self::GetBallString($result[$i][$n], $BallStringcq, $s);
            }
            $countArray2 += self::GetBallString($result[$i], $BallString_acq, 0, true);
            foreach ($countArray1 as $key => $value) {
                if ($value != 0) {
                    if(isset($numArray1[$key])){
                        $numArray1[$key] += $value;
                    }else{
                        $numArray1[$key] = $value;
                    }
                } else {
                    $numArray1[$key] = 0;
                }
            }
            $countArray1 = array();
            foreach ($countArray2 as $key => $value) {
                if ($value != 0) {
                    if(isset($numArray2[$key])){
                        $numArray2[$key] += $value;
                    }else{
                        $numArray2[$key] = $value;
                    }
                } else {
                    $numArray2[$key] = 0;
                }
            }

            $countArray2 = array();
        }
        $numArray1 = array_merge($numArray1, $numArray2);
        $numArr = array();
        foreach ($numArray1 as $key => $value) {
            if ($openMax <= $value) {
                $numArr[$key] = $value;
            }
        }
        arsort($numArr);
        return $numArr;
    }

    public static function GetBallString($result, $BallArray, $index = 0, $bool = false) {
        $countArray = array();
        for ($i = 0; $i < count($BallArray); $i++) {
            if ($bool == false) {
                $numStrng = self::Getcqa($result, $i);
                if ($numStrng == $BallArray[$i]) {
                    $countArray["第" . self::n2c($index) . "球-" . $BallArray[$i]] = 1;
                } else {
                    $countArray["第" . self::n2c($index) . "球-" . $BallArray[$i]] = 0;
                }
            } else {
                $nString = self::Getcqc(self::SumCount($result, $i), $i);
                if ($nString == $BallArray[$i]) {
                    $countArray[$BallArray[$i]] = 1;
                } else {
                    $countArray[$BallArray[$i]] = 0;
                }
            }
        }
        return $countArray;
    }

    public static function Getcqa($result, $num) {
        if($result == 11){
            return 7;
        }
        if (($num == 0) || ($num == 1)) {
            if (($result % 2) == 0) {
                return 2;
            } else {
                return 1;
            }
        } else {
            if (($num == 2) || ($num == 3)) {
                if (5 < $result) {
                    return 3;
                } else {
                    return 4;
                }
            }
        }
    }

    public static function Getcqc($result, $num) {
        if (($num == 0) || ($num == 1)) {
            if($result == 30){
                return "和值-7";
            }
            if (($result % 2) == 0) {
                return "和值-2";
            } else {
                return "和值-1";
            }
        } else {
            if($result == 30){
                return "和值-7";
            }
            if (($num == 2) || ($num == 3)) {
                if (30 <= $result) {
                    return "和值-3";
                } else {
                    return "和值-4";
                }
            } else {
                if (($num == 4) || ($num == 5) || ($num == 6)) {
                    if ($result[0] == $result[1]) {
                        return "和-7";
                    } else {
                        if ($result[1] < $result[0]) {
                            return "龙-5";
                        } else {
                            return "虎-6";
                        }
                    }
                }/*elseif (($num == 7) || ($num == 8)){//尾数单双
                    $result = $result%10;
                    if (($result % 2) == 0) {
                        return "尾数-2";
                    } else {
                        return "尾数-1";
                    }
                }*/elseif (($num == 9) || ($num == 10)){//尾数
                    $result = $result%10;
                    if (5 <= $result) {
                        return "尾数-3";
                    } else {
                        return "尾数-4";
                    }
                }
            }
        }
    }

    public static function SumCount($result, $index) {
        if ((0 <= $index) && ($index <= 3) || ($index >= 7 && $index <=10)) {
            $num = $result[0] + $result[1] + $result[2] + $result[3] + $result[4];
        } else {
            $num = array(0, 0);
            $num[0] = $result[0];
            $num[1] = $result[4];
        }
        return $num;
    }

    //单个数字变汉字
    public static function n2c($x) {
        $arr_n = array("零","一","二","三","四","五","六","七","八","九","十");
        return $arr_n[$x];
    }
}
