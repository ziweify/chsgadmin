<?php


namespace App\ort\kjw\cltool;


class KlsfChanglongold
{
    public static function sum_ball_count_1($BallString, $BallString_a, $result, $sMax = 2) {
        $numArray1 = array();
        $numArray2 = array();
        $countArray1 = array();
        $countArray2 = array();
        for ($i = 0; $i < count($result); $i++) {
            for ($n = 0; $n < count($result[$i]); $n++) {
                $s = $n + 1;
                $countArray1 += self::_getballstring($result[$i][$n], $BallString, $s);
            }
            $countArray2 += self::_getballstring($result[$i], $BallString_a, 0, true);
            foreach ($countArray1 as $key => $value ) {
                if ($value != 0) {
                    $numArray1[$key] += $value;
                } else {
                    $numArray1[$key] = 0;
                }
            }
            $countArray1 = array();
            foreach ($countArray2 as $key => $value ) {
                if ($value != 0) {
                    $numArray2[$key] += $value;
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

    public static function _getBallString($resultArray, $BallArray, $index = 0, $bool = false) {
        $countArray = array();
        for ($i = 0; $i < count($BallArray); $i++) {
            if ($bool == false) {
                $numStrng = self::sum_ball_string($resultArray, $i);
                if ($numStrng == $BallArray[$i]) {
                    $countArray["第" . self::n2c($index) . "球-" . $BallArray[$i]] = 1;
                } else {
                    $countArray["第" . self::n2c($index) . "球-" . $BallArray[$i]] = 0;
                }
            } else {
                $nString = self::sum_ball_str_a(self::sum_int($resultArray, $i), $i);
                if ($nString == $BallArray[$i]) {
                    $countArray[$BallArray[$i]] = 1;
                } else {
                    $countArray[$BallArray[$i]] = 0;
                }
            }
        }
        return $countArray;
    }

    public static function sum_ball_str_a($ball, $index, $p = 1) {
        if (($index == 0) || ($index == 1)) {
            if ($ball[1] < $ball[0]) {
                return "龙";
            } else {
                return "虎";
            }
        } else {
            if (($index == 2) || ($index == 3)) {
                if ($ball == 84) {
                    return "和";
                } else {
                    if (85 <= $ball) {
                        return $p == 1 ? "总和大" : "大";
                    } else {
                        return $p == 1 ? "总和小" : "小";
                    }
                }
            } else {
                if (($index == 4) || ($index == 5)) {
                    if (($ball % 2) == 0) {
                        return $p == 1 ? "总和双" : "双";
                    } else {
                        return $p == 1 ? "总和单" : "单";
                    }
                } else {
                    if (($index == 6) || ($index == 7)) {
                        $ball = substr($ball, -1);
                        if (5 <= $ball) {
                            return $p == 1 ? "总和尾大" : "大";
                        } else {
                            return $p == 1 ? "总和尾小" : "小";
                        }
                    }
                }
            }
        }
    }

    public static function sum_int($result, $index) {
        if ((2 <= $index) && ($index <= 7)) {
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

    public static function sum_ball_string($ball, $index, $p = 1) {
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
                    $i = mb_strlen($number);
                    if (1 < $i) {
                        $number = substr($number, -1);
                    }

                    if (5 <= $number) {
                        return $p == 1 ? "尾大" : "大";
                    } else {
                        return $p == 1 ? "尾小" : "小";
                    }
                } else {
                    if (($index == 6) || ($index == 7)) {
                        if (($number == 1) || ($number == 3) || ($number == 5) || ($number == 7) || ($number == 9) || ($number == 10) || ($number == 12) || ($number == 14) || ($number == 16) || ($number == 18)) {
                            return $p == 1 ? "合数单" : "单";
                        } else {
                            return $p == 1 ? "合数双" : "双";
                        }
                    } else if ($index == 8) {
                        if (($number == 1) || ($number == 5) || ($number == 9) || ($number == 13) || ($number == 17)) {
                            return "东";
                        } else {
                            if (($number == 2) || ($number == 6) || ($number == 10) || ($number == 14) || ($number == 18)) {
                                return "南";
                            } else {
                                if (($number == 3) || ($number == 7) || ($number == 11) || ($number == 15) || ($number == 19)) {
                                    return "西";
                                } else {
                                    return "北";
                                }
                            }
                        }
                    } else if ($index == 9) {
                        if (($number == 1) || ($number == 2) || ($number == 3) || ($number == 4) || ($number == 5) || ($number == 6) || ($number == 7)) {
                            return "中";
                        } else {
                            if (($number == 8) || ($number == 9) || ($number == 10) || ($number == 11) || ($number == 12) || ($number == 13) || ($number == 14)) {
                                return "发";
                            } else {
                                return "白";
                            }
                        }
                    }
                }
            }
        }
    }

    public static function n2c($x) {
        $arr_n = array("零","一","二","三","四","五","六","七","八","九","十");
        return $arr_n[$x];
    }
}
