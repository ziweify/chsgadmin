<?php


namespace App\ort\kjw\cltool;



use App\ort\kjw\JsFunc;

class KlsfChanglong
{
    public static function sum_ball_count_1_pk($BallString, $BallString_a, $result, $sMax = 2) {
        $numArray1 = array();
        $numArray2 = array();
        $countArray1 = array();
        $countArray2 = array();
        for ($i = 0; $i < count($result); $i++) {
            for ($n = 0; $n < count($result[$i]); $n++) {
                $s = $n + 1;
                if (3 < $n) {
                    $countArray1 += self::_getballstringpk($result[$i][$n], $BallString, $s, false);
                } else {
                    $countArray1 += self::_getballstringpk($result[$i][$n], $BallString, $s, false, $result[$i][7 - $n]);
                }
            }
            $countArray2 += self::_getballstringpk($result[$i], $BallString_a, 0, true);
            foreach ($countArray1 as $key => $value ) {
                if ($value != 0) {
                    if(isset($numArray1[$key])){
                        @$numArray1[$key] += $value;
                    }else{
                        @$numArray1[$key] = $value;
                    }
                } else {
                    $numArray1[$key] = 0;
                }
            }
            $countArray1 = array();
            foreach ($countArray2 as $key => $value ) {
                if ($value != 0) {
                    if(isset($numArray2[$key])){
                        @$numArray2[$key] += $value;
                    }else{
                        @$numArray2[$key] = $value;
                    }
                } else {
                    $numArray2[$key] = 0;
                }
            }
            $countArray2 = array();
        }
        $numArray1 = array_merge($numArray1, $numArray2);
        $numArr = array();
        $count = 0;
        foreach ($numArray1 as $key => $value ) {
            if ($sMax <= $value) {
                $count++;
                $numArr[$key] = $value;
            }
        }
        arsort($numArr);
        return $numArr;
    }

    public static function _getBallStringpk($resultArray, $BallArray, $index = 0, $bool = false, $resultArray1 = NULL) {
        $countArray = array();
        for ($i = 0; $i < count($BallArray); $i++) {
            if ($bool == false) {
                if ($resultArray1 == NULL) {
                    $numStrng = self::sum_ball_string_pk($resultArray, $i);
                } else {
                    $numStrng = self::sum_ball_string_pk($resultArray, $i, $resultArray1);
                }
                if ($numStrng == $BallArray[$i]) {
                    $countArray["第" . self::n2c($index) . "球-" . $BallArray[$i]] = 1;
                } else {
                    $countArray["第" . self::n2c($index) . "球-" . $BallArray[$i]] = 0;
                }
            } else {
                $nString = self::sum_ball_str_a_smpk(self::sum_int_pk($resultArray, $i), $i);
                if ($nString == $BallArray[$i]) {
                    $countArray[$BallArray[$i]] = 1;
                } else {
                    $countArray[$BallArray[$i]] = 0;
                }
            }
        }
        return $countArray;
    }

    public static function sum_ball_string_pk($ball, $index, $ball2 = NULL, $p = 1) {
        $number = $ball;
        if (($index == 0) || ($index == 1)) {
            if (($number % 2) == 0) {
                return 2;//双
            } else {
                return 1;//单
            }
        } else {
            if (($index == 2) || ($index == 3)) {
                if ($number <= 10) {
                    return 4;//小
                } else {
                    return 3;//大
                }
            } else {
                if (($index == 4) || ($index == 5)) {
                    if (($ball2 != NULL) || ($ball2 != "")) {
                        if ($ball2 < $ball) {
                            return 5;//龙
                        } else {
                            return 6;//虎
                        }
                    }
                }elseif (($index == 6) || ($index == 7)) {
                    $vs = $number%10;
                    if($vs > 4){
                        return 7;//尾大
                    }else{
                        return 8;//尾小
                    }
                }elseif (($index == 8) || ($index == 9)) {
                    $vs = JsFunc::heshu($number);
                    $vs = JsFunc::danshuangb($vs);
                    if($vs == 0){
                        return 9;//合数单
                    }else{
                        return 10;//合数双
                    }
                }
            }
        }
    }

    public static function sum_ball_str_a_smpk($ball, $index, $p = 1) {
        if (($index == 2) || ($index == 3) || ($index == 4)) {
            if ($ball == 84) {
                return "总和-11";
            } else {
                if (85 <= $ball) {
                    return $p == 1 ? "总和-3" : "大";
                } else {
                    return $p == 1 ? "总和-4" : "小";
                }
            }
        } else {
            if (($index == 0) || ($index == 1)) {
                if (($ball % 2) == 0) {
                    return "总和-2";
                } else {
                    return "总和-1";
                }
            }elseif(($index == 5) || ($index == 6)){
                $vs = $ball%10;
                if($vs > 4){
                    return 7;//尾大
                }else{
                    return 8;//尾小
                }
            }
        }
    }

    public static function sum_int_pk($result, $index) {
        if ($index <= 6) {
            $num = $result[0] + $result[1] + $result[2] + $result[3] + $result[4] + $result[5] + $result[6] + $result[7];
        } else {
            if (($index == 0) || ($index == 1)) {
                $num = array(0, 0);
                $num[0] = $result[0];
                $num[1] = $result[7];
            } else {
                $num = NULL;
            }
        }
        return $num;
    }

    public static function n2c($x) {
        $arr_n = array("零","一","二","三","四","五","六","七","八","九","十");
        return $arr_n[$x];
    }
}
