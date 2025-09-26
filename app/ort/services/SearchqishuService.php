<?php

namespace App\ort\services;

use App\Models\Game\Game;
use App\Models\Game\Play;
use App\ort\common\JsFunc;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchqishuService
{
    public static function searchqishu($gid, $psize, $page, $fenlei){
        //$db = Db::connection();
        //$db->update("update x_play set zqishu=0,buzqishu=0 where gid='$gid'");
        $cache = Cache::get('searchqishu_'.$gid);
        if(!empty($cache)){
            Log::info('searchqishu_'.$gid.' cache hit');
            return;
        }
        Cache::put('searchqishu_'.$gid, 1, 15);
        Play::where('gid', $gid)->update(['zqishu' => 0, 'buzqishu' => 0]);
        if ($fenlei == 163) {
            self::searchqishu_101($gid, $psize, $page, $fenlei);
        } else {
            if ($fenlei == 101 || $gid == 518) {
                self::searchqishu_101($gid, $psize, $page, $fenlei);
            } else if ($fenlei == 103) {
                self::searchqishu_103($gid, $psize, $page, $fenlei);
            } else if ($fenlei == 121) {
                self::searchqishu_121($gid, $psize, $page, $fenlei);
            } else if ($fenlei == 107) {
                self::searchqishu_107($gid, $psize, $page, $fenlei);
            } else if ($fenlei == 161) {
                self::searchqishu_161($gid, $psize, $page, $fenlei);
            } else if ($fenlei == 151) {
                self::searchqishu_151($gid, $psize, $page, $fenlei);
            } else if ($gid == 444) {
                self::searchqishu_444($gid, $psize, $page, $fenlei);
            }
        }
        //删除缓存
        Cache::delete('searchqishu_'.$gid);
    }

    public static function searchqishu_101($gid, $psize, $page, $fenlei){
        $g = Game::where('gid', $gid)->select(['mnum','thisqishu'])->first();
        $mnum = $g['mnum'];
        $thisqishu = $g['thisqishu'];
        $kj = JsFunc::getkj($mnum, $gid, $thisqishu, $page, $psize);;
        $ck = count($kj);$harr = [];
        $kj[0]['mnum'] = $mnum;
        $kj[0]['u'] = array();
        $kj[0]['z'] = array();
        $kj[0]['m'] = array();
        $db = Db::connection();
        $rs = $db->select("SELECT p.`name`, p.bid, p.sid, p.cid, p.pid, p.gid, b.`name` as bname, s.`name` AS sname, c.`name` AS cname, c.mtype AS mtype FROM x_play p LEFT JOIN x_bclass b ON(b.bid = p.bid AND b.gid = p.gid) LEFT JOIN x_sclass s ON (s.sid = p.sid AND s.gid = p.gid) LEFT JOIN x_class c ON (c.cid = p.cid AND c.gid = p.gid) WHERE p.gid = '$gid' and p.ifok = 1 ORDER BY p.xsort;");
        $cr = count($rs);
        for ($i = 0; $i < $ck; $i++) {
            for ($j = 0; $j < $cr; $j++) {
                if (isset($kj[0]['u'][$j]) && $kj[0]['u'][$j] == 1)
                    continue;
                $bname = $rs[$j]['bname'];
                $sname = $rs[$j]['sname'];
                $cname = $rs[$j]['cname'];
                $mtype = $rs[$j]['mtype'];
                if ($fenlei == 163) {
                    $he = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'];
                    $hemid = 13;
                } else {
                    $he = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'] + $kj[$i]['m4'] + $kj[$i]['m5'];
                    $hemid = 22;
                }
                if ($bname == '1~5') {
                    $m = isset($kj[$i]['m' . ($mtype + 1)]) ? $kj[$i]['m' . ($mtype + 1)] : '';
                    if (is_numeric($rs[$j]['name'])) {
                        if ($m != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[单双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[大小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiao($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } /*else if (strpos('[质合]', $rs[$j]['name'])) {
                        $tmp = JsFunc::zhihe($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }*/
                } /*else if ($bname == '1字组合') {
                    if ($cname == '全五1字组合') {
                        $arr = array(
                            $kj[$i]['m1'],
                            $kj[$i]['m2'],
                            $kj[$i]['m3'],
                            $kj[$i]['m4'],
                            $kj[$i]['m5']
                        );
                    } else if ($cname == '前三1字组合' | $fenlei == 163) {
                        $arr = array(
                            $kj[$i]['m1'],
                            $kj[$i]['m2'],
                            $kj[$i]['m3']
                        );
                    } else if ($cname == '中三1字组合') {
                        $arr = array(
                            $kj[$i]['m2'],
                            $kj[$i]['m3'],
                            $kj[$i]['m4']
                        );
                    } else if ($cname == '后三1字组合') {
                        $arr = array(
                            $kj[$i]['m3'],
                            $kj[$i]['m4'],
                            $kj[$i]['m5']
                        );
                    }
                    if (!in_array($rs[$j]['name'], $arr)) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                } *//*else if ($bname == '2字和数') {
                    $he = 0;
                    if ($fenlei == 163) {
                        if ($sname == '百十和数') {
                            $he = $kj[$i]['m1'] + $kj[$i]['m2'];
                        } else if ($sname == '百个和数') {
                            $he = $kj[$i]['m1'] + $kj[$i]['m3'];
                        } else if ($sname == '十个和数') {
                            $he = $kj[$i]['m2'] + $kj[$i]['m3'];
                        }
                    } else {
                        if ($sname == '万千和数') {
                            $he = $kj[$i]['m1'] + $kj[$i]['m2'];
                        } else if ($sname == '万百和数') {
                            $he = $kj[$i]['m1'] + $kj[$i]['m3'];
                        } else if ($sname == '万十和数') {
                            $he = $kj[$i]['m1'] + $kj[$i]['m4'];
                        } else if ($sname == '万个和数') {
                            $he = $kj[$i]['m1'] + $kj[$i]['m5'];
                        } else if ($sname == '千百和数') {
                            $he = $kj[$i]['m2'] + $kj[$i]['m3'];
                        } else if ($sname == '千十和数') {
                            $he = $kj[$i]['m2'] + $kj[$i]['m4'];
                        } else if ($sname == '千个和数') {
                            $he = $kj[$i]['m2'] + $kj[$i]['m5'];
                        } else if ($sname == '百十和数') {
                            $he = $kj[$i]['m3'] + $kj[$i]['m4'];
                        } else if ($sname == '百个和数') {
                            $he = $kj[$i]['m3'] + $kj[$i]['m5'];
                        } else if ($sname == '十个和数') {
                            $he = $kj[$i]['m4'] + $kj[$i]['m5'];
                        }
                    }
                    if ($cname == '单双') {
                        if ($rs[$j]['name'] != JsFunc::danshuang($he)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else {
                        if ($rs[$j]['name'] != "和尾" . JsFunc::daxiaow($he % 10)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                }*/ /*else if ($bname == '3字和数') {
                    if ($sname == '前三和数') {
                        $he = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'];
                    } else if ($sname == '中三和数') {
                        $he = $kj[$i]['m2'] + $kj[$i]['m3'] + $kj[$i]['m4'];
                    } else if ($sname == '后三和数') {
                        $he = $kj[$i]['m3'] + $kj[$i]['m4'] + $kj[$i]['m5'];
                    }
                    $wei = $he % 10;
                    if (strpos('[和单和双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($he);
                        if (!strpos($rs[$j]['name'], $tmp)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[和大和小]', $rs[$j]['name'])) {
                        if (!(($he >= 14 & $rs[$j]['name'] == '和大') | ($he <= 13 & $rs[$j]['name'] == '和小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[和尾大和尾小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiao($wei);
                        if (!strpos($rs[$j]['name'], $tmp)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[和尾质和尾合]', $rs[$j]['name'])) {
                        $tmp = JsFunc::zhihe($wei);
                        if (!strpos($rs[$j]['name'], $tmp)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['cname'] == '尾数') {
                        if ($wei != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                }*/ else if ($bname == '牛牛梭哈') {
                    $arr = array(
                        $kj[$i]['m1'],
                        $kj[$i]['m2'],
                        $kj[$i]['m3'],
                        $kj[$i]['m4'],
                        $kj[$i]['m5']
                    );
                    if ($sname == '牛牛') {
                        $nn = JsFunc::niuniu($arr);
                        if ($rs[$j]['name'] == '无牛') {
                            if ($nn[0]) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else if ($rs[$j]['name'] == '牛牛') {
                            if (!$nn[0] | $nn[1]) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else if ($rs[$j]['name'] == '牛单' | $rs[$j]['name'] == '牛双') {
                            if (!$nn[0] | '牛' . JsFunc::danshuang($nn[2]) != $rs[$j]['name']) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else if ($rs[$j]['name'] == '牛大' | $rs[$j]['name'] == '牛小') {
                            if (!$nn[0] | '牛' . JsFunc::nndaxiao($nn[2]) != $rs[$j]['name']) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else if ($rs[$j]['name'] == '牛质' | $rs[$j]['name'] == '牛合') {
                            if (!$nn[0] | '牛' . JsFunc::zhihe($nn[2]) != $rs[$j]['name']) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else {
                            if (!$nn[0] | '牛' . $nn[2] != $rs[$j]['name']) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        }
                    } else {
                        $sh = JsFunc::suoha($arr);
                        if ($sh != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                }else if ($bname == '斗牛梭哈') {
                    $arr = array($kj[$i]['m1'],$kj[$i]['m2'],$kj[$i]['m3'],$kj[$i]['m4'],$kj[$i]['m5']);
                    $sh = JsFunc::douniusuoha($arr);
                    if ($sh != $rs[$j]['name']) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                }else if ($bname == '斗牛') {
                    $arr = array($kj[$i]['m1'],$kj[$i]['m2'],$kj[$i]['m3'],$kj[$i]['m4'],$kj[$i]['m5']);
                    $nn = JsFunc::niuniu($arr);
                    if ($rs[$j]['name'] == '无牛') {
                        if ($nn[0]) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '牛牛') {
                        if (!$nn[0] | $nn[1]) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '牛单' | $rs[$j]['name'] == '牛双') {
                        if (!$nn[0] | '牛' . JsFunc::danshuang($nn[2]) != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '牛大' | $rs[$j]['name'] == '牛小') {
                        if (!$nn[0] | '牛' . JsFunc::nndaxiao($nn[2]) != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '牛质' | $rs[$j]['name'] == '牛合') {
                        if (!$nn[0] | '牛' . JsFunc::zhihe($nn[2]) != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else {
                        if (!$nn[0] | '牛' . $nn[2] != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '总和龙虎') {
                    $wei = $he % 10;
                    if (strpos('[总和单总和双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($he);
                        if (!strpos($rs[$j]['name'], $tmp)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[总和大总和小]', $rs[$j]['name'])) {
                        if (!(($he >= $hemid + 1 & $rs[$j]['name'] == '总和大') | ($he <= $hemid & $rs[$j]['name'] == '总和小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }

                        }
                    } else if (strpos('[总和尾大总和尾小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiao($wei);
                        if (!strpos($rs[$j]['name'], $tmp)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[总尾质总尾合]', $rs[$j]['name'])) {
                        $tmp = JsFunc::zhihe($wei);
                        if (!strpos($rs[$j]['name'], $tmp)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[总大单总大双总小单总小双]', $rs[$j]['name'])) {
                        $ds = JsFunc::danshuang($he);
                        if ($he >= 14)
                            $tmp = '大' . $ds;
                        else
                            $tmp = '小' . $ds;
                        if (!strpos($rs[$j]['name'], $tmp)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($cname == '总和尾数') {
                        if ($wei != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($cname == '总和数' || strpos($cname, '和-')) {

                        if ($fenlei == 163) {
                            $he = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'];
                        } else {
                            $he = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'] + $kj[$i]['m4'] + $kj[$i]['m5'];
                        }
                        $ps = explode('~', $rs[$j]['name']);
                        $cp = count($ps);
                        $flag = false;
                        if ($cp == 1) {
                            if ($he != $rs[$j]['name']) {
                                $flag = true;
                            }
                        } else {
                            if ($he < $ps[0] | $he > $ps[1]) {
                                $flag = true;
                            }
                        }
                        if ($flag) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($cname == '龙虎和') {
                        if ($fenlei == 163) {
                            $tmp = JsFunc::longhuhe($kj[$i]['m1'], $kj[$i]['m3']);
                        } else {
                            $tmp = JsFunc::longhuhe($kj[$i]['m1'], $kj[$i]['m5']);
                        }
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '跨度') {
                    if (strpos("[$sname]", '前三') | $fenlei == 163) {
                        $k1 = abs($kj[$i]['m1'] - $kj[$i]['m2']);
                        $k2 = abs($kj[$i]['m1'] - $kj[$i]['m3']);
                        $k3 = abs($kj[$i]['m2'] - $kj[$i]['m3']);
                    } else if (strpos("[$sname]", '中三')) {
                        $k1 = abs($kj[$i]['m2'] - $kj[$i]['m3']);
                        $k2 = abs($kj[$i]['m2'] - $kj[$i]['m4']);
                        $k3 = abs($kj[$i]['m3'] - $kj[$i]['m4']);
                    } else if (strpos("[$sname]", '后三')) {
                        $k1 = abs($kj[$i]['m3'] - $kj[$i]['m4']);
                        $k2 = abs($kj[$i]['m3'] - $kj[$i]['m5']);
                        $k3 = abs($kj[$i]['m4'] - $kj[$i]['m5']);
                    }
                    $k = max($k1, $k2, $k3);
                    if ($rs[$j]['name'] != $k) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                } else if ($bname == '其他') {
                    if (strpos("[$sname]", '前三') | $fenlei == 163) {
                        $k1 = $kj[$i]['m1'];
                        $k2 = $kj[$i]['m2'];
                        $k3 = $kj[$i]['m3'];
                    } else if (strpos("[$sname]", '中三')) {
                        $k1 = $kj[$i]['m2'];
                        $k2 = $kj[$i]['m3'];
                        $k3 = $kj[$i]['m4'];
                    } else if (strpos("[$sname]", '后三')) {
                        $k1 = $kj[$i]['m3'];
                        $k2 = $kj[$i]['m4'];
                        $k3 = $kj[$i]['m5'];
                    }
                    $kj[$i]['m'][$j] = '-';
                    if ($cname == '准对') {
                        $num = 0;
                        if ($k1 == $rs[$j]['name'])
                            $num++;
                        if ($k2 == $rs[$j]['name'])
                            $num++;
                        if ($k3 == $rs[$j]['name'])
                            $num++;
                        if ($num != 2) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($cname == '不出') {
                        if (!($k1 != $rs[$j]['name'] & $k2 != $rs[$j]['name'] & $k3 != $rs[$j]['name'])) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '豹子') {
                        $v = JsFunc::baozhi($k1, $k2, $k3);
                        if ($v != 1) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '顺子') {
                        $v = JsFunc::shunzhi($k1, $k2, $k3);
                        if ($v != 1) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '对子') {
                        $v = JsFunc::duizhi($k1, $k2, $k3);
                        if ($v != 1) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '半顺') {
                        $v = JsFunc::banshun($k1, $k2, $k3);
                        if ($v != 1) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if ($rs[$j]['name'] == '杂六') {
                        if (JsFunc::zaliu($k1, $k2, $k3) != 1) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                }
                $tmpbid = $rs[$j]['bid'];
                $tmpsid = $rs[$j]['sid'];
                $tmpcid = $rs[$j]['cid'];
            }
        }
        foreach ($harr as $s=>$v){
            $arr = explode('_', $s);
            $gid = $arr[1];
            $pid = $arr[2];
            $z = $arr[3];
            if ($z == 1) {
                $db->update("update x_play set zqishu='$v' where gid='$gid' and pid='$pid'");
            }/* else {
                $db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='$pid'");
            }*/
        }
    }

    public static function searchqishu_103($gid, $psize, $page, $fenlei){
        $g = Game::where('gid', $gid)->select(['mnum','thisqishu'])->first();
        $mnum = $g['mnum'];
        $thisqishu = $g['thisqishu'];
        $kj = JsFunc::getkj($mnum, $gid, $thisqishu, $page, $psize);
        $ck = count($kj);$harr = [];
        $kj[0]['mnum'] = $mnum;
        $kj[0]['u'] = array();
        $kj[0]['z'] = array();
        $kj[0]['m'] = array();
        $db = Db::connection();
        $rs = $db->select("SELECT p.`name`, p.bid, p.sid, p.cid, p.pid, p.gid, b.`name` as bname, c.`name` AS cname, c.mtype AS mtype FROM x_play p LEFT JOIN x_bclass b ON(b.bid = p.bid AND b.gid = p.gid) LEFT JOIN x_class c ON (c.cid = p.cid AND c.gid = p.gid) WHERE p.gid = '$gid' and p.ifok = 1 ORDER BY p.xsort;");
        $cr = count($rs);
        for ($i = 0; $i < $ck; $i++) {
            for ($j = 0; $j < $cr; $j++) {
                if (isset($kj[0]['u'][$j]) && $kj[0]['u'][$j] == 1)
                    continue;
                $bname = $rs[$j]['bname'];
                $mtype = $rs[$j]['mtype'];
                $m = isset($kj[$i]['m' . ($mtype + 1)]) ? $kj[$i]['m' . ($mtype + 1)] : '';
                if (strpos($bname, '球') | $bname == '特码号') {
                    if (is_numeric($rs[$j]['name'])) {
                        if ($m != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[单双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[大小]', $rs[$j]['name'])) {
                        if (!(($m >= 11 & $rs[$j]['name'] == '大') | ($m <= 10 & $rs[$j]['name'] == '小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[合数单合数双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang(JsFunc::heshu($m));
                        if ("合数" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[尾大尾小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiaow($m % 10);
                        if ("尾" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[龙虎]', $rs[$j]['name'])) {
                        $m2 = 8 - $mtype;
                        $longhu = JsFunc::longhuhe($m, $kj[$i]['m' . $m2]);
                        if ($longhu != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }else if (strpos('[春夏秋冬]', $rs[$j]['name'])) {
                        $tmp = JsFunc::siji($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[金木水火土]', $rs[$j]['name'])) {
                        $tmp = JsFunc::wuhang($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[东南西北]', $rs[$j]['name'])) {
                        $tmp = JsFunc::fangwei($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[中发白]', $rs[$j]['name'])) {
                        $tmp = JsFunc::zhongfabai($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '总和龙虎') {
                    $m = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'] + $kj[$i]['m4'] + $kj[$i]['m5'] + $kj[$i]['m6'] + $kj[$i]['m7'] + $kj[$i]['m8'];
                    if (strpos('[总和单总和双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ("总和" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[总和大总和小]', $rs[$j]['name'])) {
                        if (!(($m > 84 & $rs[$j]['name'] == '总和大') | ($m < 84 & $rs[$j]['name'] == '总和小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[总和尾大总和尾小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiao($m % 10);
                        if ("总和尾" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[龙虎]', $rs[$j]['name'])) {
                        $tmp = JsFunc::longhuhe($kj[$i]['m1'], $kj[$i]['m8']);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '正码') {
                    $arr = array(
                        $kj[$i]['m1'],
                        $kj[$i]['m2'],
                        $kj[$i]['m3'],
                        $kj[$i]['m4'],
                        $kj[$i]['m5'],
                        $kj[$i]['m6'],
                        $kj[$i]['m7'],
                        $kj[$i]['m8']
                    );
                    if (!in_array($rs[$j]['name'], $arr)) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                }
                //$tmpbid = $rs[$j]['bid'];
                //$tmpcid = $rs[$j]['cid'];
            }
        }

        foreach ($harr as $s=>$v){
            $arr = explode('_', $s);
            $gid = $arr[1];
            $pid = $arr[2];
            $z = $arr[3];
            if ($z == 1) {
                $db->update("update x_play set zqishu='$v' where gid='$gid' and pid='$pid'");
            }/* else {
                $db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='$pid'");
            }*/
        }
    }

    //1
    public static function searchqishu_444($gid, $psize, $page, $fenlei){
        $g = Game::where('gid', $gid)->select(['mnum','thisqishu'])->first();
        $mnum = $g['mnum'];
        $thisqishu = $g['thisqishu'];
        $kj = JsFunc::getkj($mnum, $gid, $thisqishu, $page, $psize);
        $ck = count($kj);$harr = [];
        $kj[0]['mnum'] = $mnum;
        $kj[0]['u'] = array();
        $kj[0]['z'] = array();
        $kj[0]['m'] = array();
        $db = Db::connection();
        $rs = $db->select("SELECT p.`name`, p.bid, p.sid, p.cid, p.pid, p.gid, b.`name` as bname, c.`name` AS cname, c.mtype AS mtype FROM x_play p LEFT JOIN x_bclass b ON(b.bid = p.bid AND b.gid = p.gid) LEFT JOIN x_class c ON (c.cid = p.cid AND c.gid = p.gid) WHERE p.gid = '$gid' and p.ifok = 1 ORDER BY p.xsort;");
        $cr = count($rs);
        for ($i = 0; $i < $ck; $i++) {
            for ($j = 0; $j < $cr; $j++) {
                if (isset($kj[0]['u'][$j]) && $kj[0]['u'][$j] == 1)
                    continue;
                $bname = $rs[$j]['bname'];
                $mtype = $rs[$j]['mtype'];
                if($mtype <= 4){
                    $m = $kj[$i]['m' . ($mtype + 1)];
                }
                if ($bname != '和值') {
                    if (is_numeric($rs[$j]['name'])) {
                        if ($m != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[单双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[大小]', $rs[$j]['name'])) {
                        if (!(($m >= 41 & $rs[$j]['name'] == '大') | ($m <= 40 & $rs[$j]['name'] == '小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[合单合双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang(JsFunc::heshu($m));
                        if ("合" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[尾大尾小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiaow($m % 10);
                        if ("尾" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '和值') {
                    $m = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'] + $kj[$i]['m4'] + $kj[$i]['m5'];
                    if (strpos('[单双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[大小]', $rs[$j]['name'])) {
                        if (!(($m > 202 & $rs[$j]['name'] == '大') | ($m < 203 & $rs[$j]['name'] == '小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[尾大尾小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiaow($m % 10);
                        if ("尾" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[龙虎]', $rs[$j]['name'])) {
                        $tmp = JsFunc::longhuhe($kj[$i]['m1'], $kj[$i]['m5']);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($harr as $s=>$v){
            $arr = explode('_', $s);
            $gid = $arr[1];
            $pid = $arr[2];
            $z = $arr[3];
            if ($z == 1) {
                $db->update("update x_play set zqishu='$v' where gid='$gid' and pid='$pid'");
            }/* else {
                $db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='$pid'");
            }*/
        }
    }

    public static function searchqishu_121($gid, $psize, $page, $fenlei){
        $kj = array();
        $g = Game::where('gid', $gid)->select(['mnum','thisqishu'])->first();
        $mnum = $g['mnum'];
        $thisqishu = $g['thisqishu'];
        $kj = JsFunc::getkj($mnum, $gid, $thisqishu, $page, $psize);
        $ck = count($kj);$harr = [];
        $kj[0]['mnum'] = $mnum;
        $kj[0]['u'] = array();
        $kj[0]['z'] = array();
        $kj[0]['m'] = array();
        $db = Db::connection();
        $rs = $db->select("SELECT p.`name`, p.bid, p.sid, p.cid, p.pid, p.gid, b.`name` as bname, c.`name` AS cname, c.mtype AS mtype FROM x_play p LEFT JOIN x_bclass b ON(b.bid = p.bid AND b.gid = p.gid) LEFT JOIN x_class c ON (c.cid = p.cid AND c.gid = p.gid) WHERE p.gid = '$gid' and p.ifok = 1 ORDER BY p.xsort;");
        $cr = count($rs);
        for ($i = 0; $i < $ck; $i++) {
            for ($j = 0; $j < $cr; $j++) {
                if (isset($kj[0]['u'][$j]) && $kj[0]['u'][$j] == 1)
                    continue;
                $bname = $rs[$j]['bname'];
                $mtype = $rs[$j]['mtype'];
                $m = isset($kj[$i]['m' . ($mtype + 1)]) ? $kj[$i]['m' . ($mtype + 1)] : '';
                if (strpos($bname, '球')) {
                    if (is_numeric($rs[$j]['name']) && $bname = 11111) {//注释中
                        if ($m != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[单双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang121($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[大小]', $rs[$j]['name'])) {
                        if (!(($m <= 10 & $m >= 6 & $rs[$j]['name'] == '大') | ($m <= 5 & $rs[$j]['name'] == '小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0,$s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '总和龙虎') {
                    $m = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'] + $kj[$i]['m4'] + $kj[$i]['m5'];
                    if (strpos('[总和单总和双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ("总和" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[总和大总和小]', $rs[$j]['name'])) {
                        if (!(($m > 30 & $rs[$j]['name'] == '总和大') | ($m < 30 & $rs[$j]['name'] == '总和小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[总和尾大总和尾小]', $rs[$j]['name'])) {
                        $tmp = JsFunc::daxiaow($m % 10);
                        if ("总和尾" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[龙虎]', $rs[$j]['name'])) {
                        $tmp = JsFunc::longhuhe($kj[$i]['m1'], $kj[$i]['m5']);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '正码11111') {
                    $arr = array(
                        $kj[$i]['m1'],
                        $kj[$i]['m2'],
                        $kj[$i]['m3'],
                        $kj[$i]['m4'],
                        $kj[$i]['m5']
                    );
                    if (!in_array($rs[$j]['name'], $arr)) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                }
                //$tmpbid = $rs[$j]['bid'];
                //$tmpcid = $rs[$j]['cid'];
            }
        }

        foreach ($harr as $s=>$v){
            $arr = explode('_', $s);
            $gid = $arr[1];
            $pid = $arr[2];
            $z = $arr[3];
            if ($z == 1) {
                $db->update("update x_play set zqishu='$v' where gid='$gid' and pid='$pid'");
            }/* else {
                $db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='$pid'");
            }*/
        }
    }

    public static function searchqishu_107($gid, $psize, $page, $fenlei){
        $g = Game::where('gid', $gid)->select(['mnum','thisqishu'])->first();
        $mnum = $g['mnum'];
        $thisqishu = $g['thisqishu'];
        $kj = JsFunc::getkj($mnum, $gid, $thisqishu, $page, $psize);
        $ck = count($kj);$harr = [];
        $kj[0]['mnum'] = $mnum;
        $kj[0]['u'] = array();
        $kj[0]['z'] = array();
        $kj[0]['m'] = array();
        $db = Db::connection();
        $rs = $db->select("SELECT p.`name`, p.bid, p.sid, p.cid, p.pid, p.gid, b.`name` as bname, c.mtype AS mtype FROM x_play p LEFT JOIN x_bclass b ON(b.bid = p.bid AND b.gid = p.gid) LEFT JOIN x_class c ON (c.cid = p.cid AND c.gid = p.gid) WHERE p.gid = '$gid' and p.ifok = 1 ORDER BY p.xsort;");
        $cr = count($rs);
        for ($i = 0; $i < $ck; $i++) {
            for ($j = 0; $j < $cr; $j++) {
                if (isset($kj[0]['u'][$j]) && $kj[0]['u'][$j] == 1)
                    continue;
                $bname = $rs[$j]['bname'];
                $mtype = $rs[$j]['mtype'];
                $m = isset($kj[$i]['m' . ($mtype + 1)]) ? $kj[$i]['m' . ($mtype + 1)] : "";
                if (strpos($bname, '名') || $bname == "冠军" || $bname == "亚军") {
                    if (is_numeric($rs[$j]['name'])) {
                        if ($m != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[单双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[大小]', $rs[$j]['name'])) {
                        if (!(($m >= 6 & $rs[$j]['name'] == '大') | ($m <= 5 & $rs[$j]['name'] == '小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } /*else if (strpos('[质合]', $rs[$j]['name'])) {
                        $tmp = JsFunc::zhihe($m);
                        if ($tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }*/ else if (strpos('[龙虎]', $rs[$j]['name'])) {
                        $m2 = 10 - $mtype;
                        $longhu = JsFunc::longhuhe($m, $kj[$i]['m' . $m2]);
                        if ($longhu != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '冠亚军组合') {
                    $m = $kj[$i]['m1'] + $kj[$i]['m2'];
                    if (is_numeric($rs[$j]['name'])) {
                        if ($m != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[冠亚单冠亚双]', $rs[$j]['name'])) {
                        $tmp = JsFunc::danshuang($m);
                        if ("冠亚" . $tmp != $rs[$j]['name']) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (strpos('[冠亚大冠亚小]', $rs[$j]['name'])) {
                        if (!(($m > 11 & $rs[$j]['name'] == '冠亚大') | ($m <= 11 & $rs[$j]['name'] == '冠亚小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($harr as $s=>$v){
            $arr = explode('_', $s);
            $gid = $arr[1];
            $pid = $arr[2];
            $z = $arr[3];
            if ($z == 1) {
                $db->update("update x_play set zqishu='$v' where gid='$gid' and pid='$pid'");
            }/* else {
                $db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='$pid'");
            }*/
        }
    }

    public static function searchqishu_161($gid, $psize, $page, $fenlei){
        $g = Game::where('gid', $gid)->select(['mnum','thisqishu'])->first();
        $mnum = $g['mnum'];
        $thisqishu = $g['thisqishu'];
        $kj = JsFunc::getkj($mnum, $gid, $thisqishu, $page, $psize);
        $ck = count($kj);$harr = [];
        $kj[0]['mnum'] = $mnum;
        $kj[0]['u'] = array();
        $kj[0]['z'] = array();
        $kj[0]['m'] = array();
        $db = Db::connection();
        $rs = $db->select("SELECT p.`name`, p.bid, p.sid, p.cid, p.pid, p.gid, b.`name` as bname FROM x_play p LEFT JOIN x_bclass b ON(b.bid = p.bid AND b.gid = p.gid) WHERE p.gid = '$gid' and p.ifok = 1 ORDER BY p.xsort;");
        $cr = count($rs);
        $tmp = '';
        for ($i = 0; $i < $ck; $i++) {
            $m = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'] + $kj[$i]['m4'] + $kj[$i]['m5'] + $kj[$i]['m6'] + $kj[$i]['m7'] + $kj[$i]['m8'] + $kj[$i]['m9'] + $kj[$i]['m10'] + $kj[$i]['m11'] + $kj[$i]['m12'] + $kj[$i]['m13'] + $kj[$i]['m14'] + $kj[$i]['m15'] + $kj[$i]['m16'] + $kj[$i]['m17'] + $kj[$i]['m18'] + $kj[$i]['m19'] + $kj[$i]['m20'];
            $zd = 0;
            $zq = 0;
            for ($h = 1; $h <= 20; $h++) {
                if (JsFunc::danshuang($kj[$i]['m' . $h]) == '单') {
                    $zd++;
                }
                if ($kj[$i]['m' . $h] <= 40) {
                    $zq++;
                }
            }
            for ($j = 0; $j < $cr; $j++) {
                if (isset($kj[0]['u'][$j]) && $kj[0]['u'][$j] == 1)
                    continue;
                $bname = $rs[$j]['bname'];
                switch ($bname) {
                    /* case '正码':
                         $arr = array(
                             $kj[$i]['m1'],
                             $kj[$i]['m2'],
                             $kj[$i]['m3'],
                             $kj[$i]['m4'],
                             $kj[$i]['m5'],
                             $kj[$i]['m6'],
                             $kj[$i]['m7'],
                             $kj[$i]['m8'],
                             $kj[$i]['m9'],
                             $kj[$i]['m10'],
                             $kj[$i]['m11'],
                             $kj[$i]['m12'],
                             $kj[$i]['m13'],
                             $kj[$i]['m14'],
                             $kj[$i]['m15'],
                             $kj[$i]['m16'],
                             $kj[$i]['m17'],
                             $kj[$i]['m18'],
                             $kj[$i]['m19'],
                             $kj[$i]['m20']
                         );
                         if (in_array($rs[$j]['name'], $arr)) {
                             $kj[$i]['m'][$j] = 2;
                             if ($i > 0) {
                                 if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                     if (isset($kj[0]['z'][$j])) {
                                         $kj[0]['z'][$j] += 1;
                                     } else {
                                         $kj[0]['z'][$j] = 1;
                                     }
                                     if ($kj[0]['z'][$j] >= $ck) {
                                         self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                     }
                                 } else {
                                     $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                     self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                     $kj[0]['u'][$j] = 1;
                                 }
                             } else {
                                 if (isset($kj[0]['z'][$j])) {
                                     $kj[0]['z'][$j] += 1;
                                 } else {
                                     $kj[0]['z'][$j] = 1;
                                 }
                             }
                         } else {
                             $kj[$i]['m'][$j] = 1;
                             if ($i > 0) {
                                 if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                     if (isset($kj[0]['z'][$j])) {
                                         $kj[0]['z'][$j] += 1;
                                     } else {
                                         $kj[0]['z'][$j] = 1;
                                     }
                                     if ($kj[0]['z'][$j] >= $ck) {
                                         self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                     }
                                 } else {
                                     $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                     self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                     $kj[0]['u'][$j] = 1;
                                 }
                             } else {
                                 if (isset($kj[0]['z'][$j])) {
                                     $kj[0]['z'][$j] += 1;
                                 } else {
                                     $kj[0]['z'][$j] = 1;
                                 }
                             }
                         }
                         break;*/
                    case  '总和':
                        if (strpos('[总和单总和双]', $rs[$j]['name'])) {
                            $tmp = JsFunc::danshuang($m);
                            if ("总和" . $tmp != $rs[$j]['name']) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else if (strpos('[总和大总和小]', $rs[$j]['name'])) {
                            if (!(($m > 810 & $rs[$j]['name'] == '总和大') | ($m < 810 & $rs[$j]['name'] == '总和小'))) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else if (strpos('[总和810]', $rs[$j]['name'])) {
                            if ($tmp != 810) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case  '前后和':
                        if (strpos('[前(多)后(多)]', $rs[$j]['name'])) {
                            if (!(("前(多)" == $rs[$j]['name'] & $zq > 10) | ("后(多)" == $rs[$j]['name'] & $zq < 10) | ("前后(和)" == $rs[$j]['name'] & $zq == 10))) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        } else if (strpos('[前后(和)]', $rs[$j]['name'])) {
                            if (!($kj[$i]['m10'] <= 40 & $kj[$i]['m11'] >= 41)) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case  '单双和':
                        if (strpos('[单(多)双(多)单双(和)]', $rs[$j]['name'])) {
                            if (!(("单(多)" == $rs[$j]['name'] & $zd > 10) | ("双(多)" == $rs[$j]['name'] & $zd < 10) | ("单双(和)" == $rs[$j]['name'] & $zd == 10))) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }

                        }
                        break;
                    case  '总和过关':
                        if (strpos('[总大单总小单总大双总小双]', $rs[$j]['name'])) {
                            $tmp = JsFunc::danshuang($m);
                            if ($m < 810)
                                $tmp = "总小" . $tmp;
                            else if ($tmp > 810)
                                $tmp = "总大" . $tmp;
                            if ($tmp != $rs[$j]['name']) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        }
                        break;
                    case  '五行':
                        if (strpos('[金木水火土]', $rs[$j]['name'])) {
                            $tmp = JsFunc::wuhang_161($m);
                            if ($tmp != $rs[$j]['name']) {
                                $kj[$i]['m'][$j] = 2;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            } else {
                                $kj[$i]['m'][$j] = 1;
                                if ($i > 0) {
                                    if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                        if (isset($kj[0]['z'][$j])) {
                                            $kj[0]['z'][$j] += 1;
                                        } else {
                                            $kj[0]['z'][$j] = 1;
                                        }
                                        if ($kj[0]['z'][$j] >= $ck) {
                                            self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                        }
                                    } else {
                                        $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                        $kj[0]['u'][$j] = 1;
                                    }
                                } else {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                }
                            }
                        }
                        break;
                    /* case '正码':
                         if (!in_array($rs[$j]['name'], $kj[$i])) {
                             $kj[$i]['m'][$j] = 2;
                             if ($i > 0) {
                                 if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                     if (isset($kj[0]['z'][$j])) {
                                         $kj[0]['z'][$j] += 1;
                                     } else {
                                         $kj[0]['z'][$j] = 1;
                                     }
                                     if ($kj[0]['z'][$j] >= $ck) {
                                         self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                     }
                                 } else {
                                     $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                     self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                     $kj[0]['u'][$j] = 1;
                                 }
                             } else {
                                 if (isset($kj[0]['z'][$j])) {
                                     $kj[0]['z'][$j] += 1;
                                 } else {
                                     $kj[0]['z'][$j] = 1;
                                 }
                             }
                         } else {
                             $kj[$i]['m'][$j] = 1;
                             if ($i > 0) {
                                 if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                     if (isset($kj[0]['z'][$j])) {
                                         $kj[0]['z'][$j] += 1;
                                     } else {
                                         $kj[0]['z'][$j] = 1;
                                     }
                                     if ($kj[0]['z'][$j] >= $ck) {
                                         self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                     }
                                 } else {
                                     $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                     self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                     $kj[0]['u'][$j] = 1;
                                 }
                             } else {
                                 if (isset($kj[0]['z'][$j])) {
                                     $kj[0]['z'][$j] += 1;
                                 } else {
                                     $kj[0]['z'][$j] = 1;
                                 }
                             }
                         }
                         break;*/

                }
            }
        }

        foreach ($harr as $s=>$v){
            $arr = explode('_', $s);
            $gid = $arr[1];
            $pid = $arr[2];
            $z = $arr[3];
            if ($z == 1) {
                $db->update("update x_play set zqishu='$v' where gid='$gid' and pid='$pid'");
            }/* else {
                $db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='$pid'");
            }*/
        }
    }

    public static function searchqishu_151($gid, $psize, $page, $fenlei){
        $g = Game::where('gid', $gid)->select(['mnum','thisqishu'])->first();
        $mnum = $g['mnum'];
        $thisqishu = $g['thisqishu'];
        $kj = JsFunc::getkj($mnum, $gid, $thisqishu, $page, $psize);
        $ck = count($kj);$harr = [];
        $kj[0]['mnum'] = $mnum;
        $kj[0]['u'] = array();
        $kj[0]['z'] = array();
        $kj[0]['m'] = array();
        $db = Db::connection();
        $rs = $db->select("SELECT p.`name`, p.bid, p.sid, p.cid, p.pid, p.gid, b.`name` as bname FROM x_play p LEFT JOIN x_bclass b ON(b.bid = p.bid AND b.gid = p.gid) WHERE p.gid = '$gid' and p.ifok = 1 ORDER BY p.xsort;");
        $cr = count($rs);
        for ($i = 0; $i < $ck; $i++) {
            $ma = array(
                $kj[$i]['m1'],
                $kj[$i]['m2'],
                $kj[$i]['m3']
            );
            $m = $kj[$i]['m1'] + $kj[$i]['m2'] + $kj[$i]['m3'];
            for ($j = 0; $j < $cr; $j++) {
                if (isset($kj[0]['u'][$j]) && $kj[0]['u'][$j] == 1)
                    continue;
                $bname = $rs[$j]['bname'];
                if ($bname == '三军') {
                    if (strpos('[三军大三军小]', $rs[$j]['name'])) {
                        if (!(($m >= 11 & $rs[$j]['name'] == '三军大') | ($m <= 10 & $rs[$j]['name'] == '三军小'))) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    } else if (is_numeric($rs[$j]['name'])) {
                        if (!in_array($rs[$j]['name'], $ma)) {
                            $kj[$i]['m'][$j] = 2;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        } else {
                            $kj[$i]['m'][$j] = 1;
                            if ($i > 0) {
                                if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                    if (isset($kj[0]['z'][$j])) {
                                        $kj[0]['z'][$j] += 1;
                                    } else {
                                        $kj[0]['z'][$j] = 1;
                                    }
                                    if ($kj[0]['z'][$j] >= $ck) {
                                        self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                    }
                                } else {
                                    $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                    $kj[0]['u'][$j] = 1;
                                }
                            } else {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                            }
                        }
                    }
                } else if ($bname == '围骰') {
                    if (!(JsFunc::baozhi($kj[0], $kj[1], $kj[2]) == 1 & $ma[0] == $rs[$j]['name'] % 10)) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1,$s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                } else if ($bname == '全骰') {
                    if (JsFunc::baozhi($kj[0], $kj[1], $kj[2]) != 1) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                } else if ($bname == '点数') {
                    if ($rs[$j]['name'] != $m) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                } else if ($bname == '长牌') {
                    $one = $rs[$j]['name'] % 10;
                    $two = ($rs[$j]['name'] - $one) / 10;
                    if (!(in_array($one, $ma) & in_array($two, $ma))) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                } else if ($bname == '短牌') {
                    $one = $rs[$j]['name'] % 10;
                    $cs = array_count_values($ma);
                    if (isset($cs[$one]) && $cs[$one] < 2) {
                        $kj[$i]['m'][$j] = 2;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 2) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 0, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 1, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    } else {
                        $kj[$i]['m'][$j] = 1;
                        if ($i > 0) {
                            if (isset($kj[$i - 1]['m'][$j]) && $kj[$i - 1]['m'][$j] == 1) {
                                if (isset($kj[0]['z'][$j])) {
                                    $kj[0]['z'][$j] += 1;
                                } else {
                                    $kj[0]['z'][$j] = 1;
                                }
                                if ($kj[0]['z'][$j] >= $ck) {
                                    self::updateqishu($gid, $rs[$j]['pid'], 1, $kj[0]['z'][$j],$harr);
                                }
                            } else {
                                $s = isset($kj[0]['z'][$j]) ? $kj[0]['z'][$j] : 0;
                                self::updateqishu($gid, $rs[$j]['pid'], 0, $s,$harr);
                                $kj[0]['u'][$j] = 1;
                            }
                        } else {
                            if (isset($kj[0]['z'][$j])) {
                                $kj[0]['z'][$j] += 1;
                            } else {
                                $kj[0]['z'][$j] = 1;
                            }
                        }
                    }
                }
            }
        }

        foreach ($harr as $s=>$v){
            $arr = explode('_', $s);
            $gid = $arr[1];
            $pid = $arr[2];
            $z = $arr[3];
            if ($z == 1) {
                $db->update("update x_play set zqishu='$v' where gid='$gid' and pid='$pid'");
            }/* else {
                $db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='$pid'");
            }*/
        }
    }

    public static function updateqishu($gid, $pid, $z, $v,&$harr)
    {
        //$db = Db::connection();
        /*if ($z == 1) {
            //$db->update("update x_play set zqishu='$v' where gid='$gid' and pid='" . $pid . "'");
            Play::where('gid', $gid)->where('pid', $pid)->update(['zqishu' => $v]);
        } else {
            //$db->update("update x_play set buzqishu='$v' where gid='$gid' and pid='" . $pid . "'");
            Play::where('gid', $gid)->where('pid', $pid)->update(['buzqishu' => $v]);
        }*/
        $key = 'tp_' . $gid . '_' . $pid.'_'.$z;
        if(isset($harr[$key])){
            $c = $harr[$key];
            $v > $c && $harr[$key] = $v;
        }else{
            $harr[$key] = $v;
        }
    }
}
