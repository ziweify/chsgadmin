<?php

namespace App\ort\sgwin;

use App\Models\Game\Autozj;
use App\Models\Game\Autozjlog;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\LibModel;
use App\Models\Game\User;
use App\Models\Game\UserEdit;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\services\AutosService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SGUtils
{

    public static function parsecy($detail)
    {
        $newdetail = [];
        foreach ($detail as $v) {
            if (substr($v, 0, 1) == 'G') {
                $v = substr($v, 1);
                $newdetail[] = $v;
            }
        }
        return $newdetail;
    }

    public static function getfllist($fenlei)
    {
        $arr = [];
        if ($fenlei == 107) {
            $arr[] = ['page' => 'lm', 'name' => '两面盘', 'index' => ''];
            $arr[] = ['page' => '110', 'name' => '单号1 ~ 10', 'index' => ''];
            $arr[] = ['page' => 'gy', 'name' => '冠亚军组合', 'index' => ''];
        } elseif ($fenlei == 101) {
            $arr[] = ['page' => 'lm', 'name' => '两面', 'index' => ''];
            $arr[] = ['page' => 'ball', 'name' => '1~5', 'index' => '1_5'];
            $arr[] = ['page' => '1z', 'name' => '一字组合', 'index' => ''];
            $arr[] = ['page' => '2z', 'name' => '二字组合', 'index' => ''];
            $arr[] = ['page' => '3z', 'name' => '三字组合', 'index' => ''];
            $arr[] = ['page' => '2zdw', 'name' => '二字定位', 'index' => ''];
            $arr[] = ['page' => '3zdw', 'name' => '三字定位', 'index' => ''];
            $arr[] = ['page' => '2zhs', 'name' => '二字和数', 'index' => '54'];
            $arr[] = ['page' => '3zhs', 'name' => '三字和数', 'index' => '543'];
            $arr[] = ['page' => 'zx3', 'name' => '组选三', 'index' => 'TS1'];
            $arr[] = ['page' => 'zx6', 'name' => '组选六', 'index' => 'TS1'];
            $arr[] = ['page' => 'fs', 'name' => '复式组合', 'index' => 'TS1'];
            $arr[] = ['page' => 'kd', 'name' => '跨度', 'index' => 'TS1'];
            $arr[] = ['page' => 'dn', 'name' => '斗牛', 'index' => ''];
        } elseif ($fenlei == 103) {//快十
            $arr[] = ['page' => 'lm', 'name' => '两面盘', 'index' => ''];
            $arr[] = ['page' => 'balls', 'name' => '单球1～8', 'index' => ''];
            $arr[] = ['page' => 'ball', 'name' => '第一球', 'index' => '1'];
            $arr[] = ['page' => 'ball', 'name' => '第二球', 'index' => '2'];
            $arr[] = ['page' => 'ball', 'name' => '第三球', 'index' => '3'];
            $arr[] = ['page' => 'ball', 'name' => '第四球', 'index' => '4'];
            $arr[] = ['page' => 'ball', 'name' => '第五球', 'index' => '5'];
            $arr[] = ['page' => 'ball', 'name' => '第六球', 'index' => '6'];
            $arr[] = ['page' => 'ball', 'name' => '第七球', 'index' => '7'];
            $arr[] = ['page' => 'ball', 'name' => '第八球', 'index' => '8'];
            $arr[] = ['page' => 'zm', 'name' => '正码', 'index' => ''];
            $arr[] = ['page' => 'mp', 'name' => '连码', 'index' => ''];
        } elseif ($fenlei == 161) {
            $arr[] = ['page' => 'all', 'name' => '总和、比数、五行', 'index' => ''];
            $arr[] = ['page' => 'balls', 'name' => '正码', 'index' => ''];
        } elseif ($fenlei == 151) {
            $arr[] = ['page' => 'all', 'name' => '大小骰宝', 'index' => ''];
            $arr[] = ['page' => 'yxx', 'name' => '鱼虾蟹骰宝', 'index' => ''];
        } elseif ($fenlei == 121) {
            $arr[] = ['page' => 'lm', 'name' => '两面', 'index' => ''];
            $arr[] = ['page' => 'dh', 'name' => '单号', 'index' => ''];
            $arr[] = ['page' => 'mp', 'name' => '连码', 'index' => ''];
            $arr[] = ['page' => 'zx', 'name' => '直选', 'index' => '2'];
        } elseif ($fenlei == 163) {
            $arr[] = ['page' => 'lm', 'name' => '主势盘', 'index' => ''];
        }
        return $arr;
    }

    public static function gettemplate($fenlei)
    {
        $template = '';
        if ($fenlei == 107) {
            $template = 'PK10';
        } elseif ($fenlei == 101) {
            $template = 'SSC';
        } elseif ($fenlei == 103) {
            $template = 'KLSF';
        } elseif ($fenlei == 161) {
            $template = 'KL8';
        } elseif ($fenlei == 151) {
            $template = 'K3';
        } elseif ($fenlei == 121) {
            $template = '11X5';
        }
        return $template;
    }

    public static function getclassfl($fenlei, $name)
    {
        if ($fenlei == 107) {
            if ($name == '1-10车号') {
                return 'BALL';
            } elseif ($name == '冠亚军和单双') {
                return 'GDS';
            } elseif ($name == '冠亚军和大小') {
                return 'GDX';
            } elseif ($name == '冠亚军和') {
                return 'GYH';
            } elseif ($name == '两面') {
                return 'LM';
            }
        } elseif ($fenlei == 103) {//快乐十分
            if ($name == '1-8方位') {
                return 'FW';
            } elseif ($name == '两面') {
                return 'LM';
            } elseif ($name == '连码') {
                return 'MP';
            } elseif ($name == '总和单双') {
                return 'ZDS';
            } elseif ($name == '1-8中发白') {
                return 'ZFB';
            } elseif ($name == '正码') {
                return 'ZM';
            } elseif ($name == '总和尾数大小') {
                return 'ZWDX';
            }
        } elseif ($fenlei == 101) {//时时彩
            if ($name == '两面') {
                return 'LM';
            } elseif ($name == '龙虎和') {
                return 'LH';
            } elseif ($name == '前三中三后三') {
                return 'TS';
            } elseif ($name == '一字组合') {
                return '1Z';
            } elseif ($name == '二字组合') {
                return '2Z';
            } elseif ($name == '三字组合') {
                return '3Z';
            } elseif ($name == '二字定位') {
                return '2DW';
            } elseif ($name == '三字定位') {
                return '3DW';
            } elseif ($name == '二字和数') {
                return '2ZHS';
            } elseif ($name == '和尾数') {
                return 'HWS';
            } elseif ($name == '三字和数') {
                return '3ZHS';
            } elseif ($name == '组选三') {
                return 'ZX3';
            } elseif ($name == '组选六') {
                return 'ZX6';
            } elseif ($name == '跨度') {
                return 'KD';
            } elseif ($name == '复式') {
                return 'FS';
            }
        }
    }

    public static function getdefalutfastbetdata($fenlei)
    {
        $list = [];
        if ($fenlei == 107) {//pk10
            $list[] = ['betSelectId' => 'GDX_X', 'followResult' => 'N', 'id' => 'PK10-GDX_X', 'name' => '冠，亚+冠亚和-小', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'GDX_D', 'followResult' => 'N', 'id' => 'PK10-GDX_D', 'name' => '冠，亚+冠亚和-大', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'GDS_D', 'followResult' => 'N', 'id' => 'PK10-GDS_D', 'name' => '冠，亚+冠亚和-单', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'GDS_S', 'followResult' => 'N', 'id' => 'PK10-GDS_S', 'name' => '冠，亚+冠亚和-双', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DX_X_T', 'followResult' => 'N', 'id' => 'PK10-DX_X_T', 'name' => '1-5名小', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DX_D_T', 'followResult' => 'N', 'id' => 'PK10-DX_D_T', 'name' => '1-5名大', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DS_D_T', 'followResult' => 'N', 'id' => 'PK10-DS_D_T', 'name' => '1-5名单', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DS_S_T', 'followResult' => 'N', 'id' => 'PK10-DS_S_T', 'name' => '1-5名双', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DX_X_L', 'followResult' => 'N', 'id' => 'PK10-DX_X_L', 'name' => '6-10名小', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DX_D_L', 'followResult' => 'N', 'id' => 'PK10-DX_D_L', 'name' => '6-10名大', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DS_D_L', 'followResult' => 'N', 'id' => 'PK10-DS_D_L', 'name' => '6-10名单', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'DS_S_L', 'followResult' => 'N', 'id' => 'PK10-DS_S_L', 'name' => '6-10名双', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'TM_B1_D', 'followResult' => 'N', 'id' => 'PK10-TM_B1_D', 'name' => '1名特码-单', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'TM_B1_S', 'followResult' => 'N', 'id' => 'PK10-TM_B1_S', 'name' => '1名特码-双', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'TM_B1_B', 'followResult' => 'N', 'id' => 'PK10-TM_B1_B', 'name' => '1名特码-大', 'template' => 'PK10'];
            $list[] = ['betSelectId' => 'TM_B1_X', 'followResult' => 'N', 'id' => 'PK10-TM_B1_X', 'name' => '1名特码-小', 'template' => 'PK10'];
        } elseif ($fenlei == 101) {//时时彩系列
            $list[] = ['betSelectId' => 'DX_D', 'followResult' => 'N', 'id' => 'SSC-DX_D', 'name' => '1-5球大', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'DX_X', 'followResult' => 'N', 'id' => 'SSC-DX_X', 'name' => '1-5球小', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'DS_D', 'followResult' => 'N', 'id' => 'SSC-DS_D', 'name' => '1-5球单', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'DS_S', 'followResult' => 'N', 'id' => 'SSC-DS_S', 'name' => '1-5球双', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B1_D', 'followResult' => 'N', 'id' => 'SSC-TM_B1_D', 'name' => '1球特码-单', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B1_S', 'followResult' => 'N', 'id' => 'SSC-TM_B1_S', 'name' => '1球特码-双', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B1_B', 'followResult' => 'N', 'id' => 'SSC-TM_B1_B', 'name' => '1球特码-大', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B1_X', 'followResult' => 'N', 'id' => 'SSC-TM_B1_X', 'name' => '1球特码-小', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B2_B', 'followResult' => 'N', 'id' => 'SSC-TM_B2_B', 'name' => '2球特码-大', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B2_X', 'followResult' => 'N', 'id' => 'SSC-TM_B2_X', 'name' => '2球特码-小', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B2_D', 'followResult' => 'N', 'id' => 'SSC-TM_B2_D', 'name' => '2球特码-单', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B2_S', 'followResult' => 'N', 'id' => 'SSC-TM_B2_S', 'name' => '2球特码-双', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B3_B', 'followResult' => 'N', 'id' => 'SSC-TM_B3_B', 'name' => '3球特码-大', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B3_X', 'followResult' => 'N', 'id' => 'SSC-TM_B3_X', 'name' => '3球特码-小', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B3_D', 'followResult' => 'N', 'id' => 'SSC-TM_B3_D', 'name' => '3球特码-单', 'template' => 'SSC'];
            $list[] = ['betSelectId' => 'TM_B3_S', 'followResult' => 'N', 'id' => 'SSC-TM_B3_S', 'name' => '3球特码-双', 'template' => 'SSC'];
        } elseif ($fenlei == 103) {//快乐十分
            $list[] = ['betSelectId' => 'DX_D', 'followResult' => 'N', 'id' => 'KLSF-DX_D', 'name' => '1-8球大', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'DX_X', 'followResult' => 'N', 'id' => 'KLSF-DX_X', 'name' => '1-8球小', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'DS_D', 'followResult' => 'N', 'id' => 'KLSF-DS_D', 'name' => '1-8球单', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'DS_S', 'followResult' => 'N', 'id' => 'KLSF-DS_S', 'name' => '1-8球双', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'WDX_D', 'followResult' => 'N', 'id' => 'KLSF-WDX_D', 'name' => '1-8球尾大', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'WDX_X', 'followResult' => 'N', 'id' => 'KLSF-WDX_X', 'name' => '1-8球尾小', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'HDS_D', 'followResult' => 'N', 'id' => 'KLSF-HDS_D', 'name' => '1-8球合单', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'HDS_S', 'followResult' => 'N', 'id' => 'KLSF-HDS_S', 'name' => '1-8球合双', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'LH_L', 'followResult' => 'N', 'id' => 'KLSF-LH_L', 'name' => '1-4球龙', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'LH_H', 'followResult' => 'N', 'id' => 'KLSF-LH_H', 'name' => '1-4球虎', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'BALL_DX_D', 'followResult' => 'N', 'id' => 'KLSF-BALL_DX_D', 'name' => '全部大', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'BALL_DX_X', 'followResult' => 'N', 'id' => 'KLSF-BALL_DX_X', 'name' => '全部小', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'BALL_DS_D', 'followResult' => 'N', 'id' => 'KLSF-BALL_DS_D', 'name' => '全部单', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'BALL_DS_S', 'followResult' => 'N', 'id' => 'KLSF-BALL_DS_S', 'name' => '全部双', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'BALL_WDX_D', 'followResult' => 'N', 'id' => 'KLSF-BALL_WDX_D', 'name' => '全部尾大', 'template' => 'KLSF'];
            $list[] = ['betSelectId' => 'BALL_WDX_X', 'followResult' => 'N', 'id' => 'KLSF-BALL_WDX_X', 'name' => '全部尾小', 'template' => 'KLSF'];
        }
        return $list;
    }

    public static function get107fastbetdata($key, $template)
    {
        $data = [
            ["GDX_X", "冠，亚+冠亚和-小"],
            ["GDX_D", "冠，亚+冠亚和-大"],
            ["GDS_D", "冠，亚+冠亚和-单"],
            ["GDS_S", "冠，亚+冠亚和-双"],
            ["DX_X_T", "1-5名小"],
            ["DX_D_T", "1-5名大"],
            ["DS_D_T", "1-5名单"],
            ["DS_S_T", "1-5名双"],
            ["DX_X_L", "6-10名小"],
            ["DX_D_L", "6-10名大"],
            ["DS_D_L", "6-10名单"],
            ["DS_S_L", "6-10名双"],
            ["TM_B1_D", "1名特码-单"],
            ["TM_B1_S", "1名特码-双"],
            ["TM_B1_B", "1名特码-大"],
            ["TM_B1_X", "1名特码-小"],
            ["TM_B2_D", "2名特码-单"],
            ["TM_B2_S", "2名特码-双"],
            ["TM_B2_B", "2名特码-大"],
            ["TM_B2_X", "2名特码-小"],
            ["TM_B3_D", "3名特码-单"],
            ["TM_B3_S", "3名特码-双"],
            ["TM_B3_B", "3名特码-大"],
            ["TM_B3_X", "3名特码-小"],
            ["TM_B4_D", "4名特码-单"],
            ["TM_B4_S", "4名特码-双"],
            ["TM_B4_B", "4名特码-大"],
            ["TM_B4_X", "4名特码-小"],
            ["TM_B5_D", "5名特码-单"],
            ["TM_B5_S", "5名特码-双"],
            ["TM_B5_B", "5名特码-大"],
            ["TM_B5_X", "5名特码-小"],
            ["TM_B6_D", "6名特码-单"],
            ["TM_B6_S", "6名特码-双"],
            ["TM_B6_B", "6名特码-大"],
            ["TM_B6_X", "6名特码-小"],
            ["TM_B7_D", "7名特码-单"],
            ["TM_B7_S", "7名特码-双"],
            ["TM_B7_B", "7名特码-大"],
            ["TM_B7_X", "7名特码-小"],
            ["TM_B8_D", "8名特码-单"],
            ["TM_B8_S", "8名特码-双"],
            ["TM_B8_B", "8名特码-大"],
            ["TM_B8_X", "8名特码-小"],
            ["TM_B9_D", "9名特码-单"],
            ["TM_B9_S", "9名特码-双"],
            ["TM_B9_B", "9名特码-大"],
            ["TM_B9_X", "9名特码-小"],
            ["TM_B10_D", "10名特码-单"],
            ["TM_B10_S", "10名特码-双"],
            ["TM_B10_B", "10名特码-大"],
            ["TM_B10_X", "10名特码-小"],
            ["FB_DX_T", "1-5名大小追同"],
            ["RB_DX_T", "1-5名大小追反"],
            ["FB_DS_T", "1-5名单双追同"],
            ["RB_DS_T", "1-5名单双追反"],
            ["FB_DX_L", "6-10名大小追同"],
            ["RB_DX_L", "6-10名大小追反"],
            ["FB_DS_L", "6-10名单双追同"],
            ["RB_DS_L", "6-10名单双追反"],
            ["FB_DS", "1-10名单双追同"],
            ["RB_DS", "1-10名单双追反"],
            ["RB_DX", "1-10名大小追反"],
            ["FB_DX", "1-10名大小追同"],
            ["MFB_DX_T", "1-5名上期热门大小-追同"],
            ["MRB_DX_T", "1-5名上期热门大小-追反"],
            ["MFB_DS_T", "1-5名上期热门单双-追同"],
            ["MRB_DS_T", "1-5名上期热门单双-追反"],
            ["MRB_DS_L", "6-10名上期热门单双-追反"],
            ["MFB_DS_L", "6-10名上期热门单双-追同"],
            ["MRB_DX_L", "6-10名上期热门大小-追反"],
            ["MFB_DX_L", "6-10名上期热门大小-追同"],
            ["CL_2_S", "长龙>=2 追同"],
            ["CL_2_R", "长龙>=2 追反"],
            ["CL_3_S", "长龙>=3 追同"],
            ["CL_3_R", "长龙>=3 追反"],
            ["CL_4_S", "长龙>=4 追同"],
            ["CL_4_R", "长龙>=4 追反"],
            ["CL_5_S", "长龙>=5 追同"],
            ["CL_5_R", "长龙>=5 追反"],
            ["CL_6_S", "长龙>=6 追同"],
            ["CL_6_R", "长龙>=6 追反"],
            ["CL_7_S", "长龙>=7 追同"],
            ["CL_7_R", "长龙>=7 追反"],
            ["CL_8_S", "长龙>=8 追同"],
            ["CL_8_R", "长龙>=8 追反"]
        ];
        $result = [];
        foreach ($data as $item) {
            [$betSelectId, $name] = $item;
            $result[$betSelectId] = [
                'betSelectId' => $betSelectId,
                'followResult' => 'N',
                'id' => $template . '-' . $betSelectId,
                'name' => $name,
                'template' => $template,
            ];
        }
        return $result[$key];
    }

    public static function get101fastbetdata($key, $template)
    {
        $data = [
            ["DX_D", "1-5球大"],
            ["DX_X", "1-5球小"],
            ["DS_D", "1-5球单"],
            ["DS_S", "1-5球双"],
            ["TM_B1_D", "1球特码-单"],
            ["TM_B1_S", "1球特码-双"],
            ["TM_B1_B", "1球特码-大"],
            ["TM_B1_X", "1球特码-小"],
            ["TM_B2_D", "2球特码-单"],
            ["TM_B2_S", "2球特码-双"],
            ["TM_B2_B", "2球特码-大"],
            ["TM_B2_X", "2球特码-小"],
            ["TM_B3_D", "3球特码-单"],
            ["TM_B3_S", "3球特码-双"],
            ["TM_B3_B", "3球特码-大"],
            ["TM_B3_X", "3球特码-小"],
            ["TM_B4_D", "4球特码-单"],
            ["TM_B4_S", "4球特码-双"],
            ["TM_B4_B", "4球特码-大"],
            ["TM_B4_X", "4球特码-小"],
            ["TM_B5_D", "5球特码-单"],
            ["TM_B5_S", "5球特码-双"],
            ["TM_B5_B", "5球特码-大"],
            ["TM_B5_X", "5球特码-小"],
            ["BALL_DX_D", "全部大"],
            ["BALL_DX_X", "全部小"],
            ["BALL_DS_D", "全部单"],
            ["BALL_DS_S", "全部双"],
            ["FB_DX", "1-5球大小追同"],
            ["RB_DX", "1-5球大小追反"],
            ["FB_DS", "1-5球单双追同"],
            ["RB_DS", "1-5球单双追反"],
            ["CL_2_S", "长龙>=2 追同"],
            ["CL_2_R", "长龙>=2 追反"],
            ["CL_3_S", "长龙>=3 追同"],
            ["CL_3_R", "长龙>=3 追反"],
            ["CL_4_S", "长龙>=4 追同"],
            ["CL_4_R", "长龙>=4 追反"],
            ["CL_5_S", "长龙>=5 追同"],
            ["CL_5_R", "长龙>=5 追反"],
            ["CL_6_S", "长龙>=6 追同"],
            ["CL_6_R", "长龙>=6 追反"],
            ["CL_7_S", "长龙>=7 追同"],
            ["CL_7_R", "长龙>=7 追反"],
            ["CL_8_S", "长龙>=8 追同"],
            ["CL_8_R", "长龙>=8 追反"],
            ["MFB_DX", "上期热门大小-追同"],
            ["MRB_DX", "上期热门大小-追反"],
            ["MFB_DS", "上期热门单双-追同"],
            ["MRB_DS", "上期热门单双-追反"],
            ["PFB_DX", "全部大小追同"],
            ["PRB_DX", "全部大小追反"],
            ["PFB_DS", "全部单双追同"],
            ["PRB_DS", "全部单双追反"]
        ];
        $result = [];
        foreach ($data as $item) {
            [$betSelectId, $name] = $item;
            $result[$betSelectId] = [
                'betSelectId' => $betSelectId,
                'followResult' => 'N',
                'id' => $template . '-' . $betSelectId,
                'name' => $name,
                'template' => $template,
            ];
        }
        return $result[$key];
    }

    public static function get103fastbetdata($key, $template)
    {
        $data = [
            ["DX_D", "1-8球大"],
            ["DX_X", "1-8球小"],
            ["DS_D", "1-8球单"],
            ["DS_S", "1-8球双"],
            ["WDX_D", "1-8球尾大"],
            ["WDX_X", "1-8球尾小"],
            ["HDS_D", "1-8球合单"],
            ["HDS_S", "1-8球合双"],
            ["LH_L", "1-4球龙"],
            ["LH_H", "1-4球虎"],
            ["BALL_DX_D", "全部大"],
            ["BALL_DX_X", "全部小"],
            ["BALL_DS_D", "全部单"],
            ["BALL_DS_S", "全部双"],
            ["BALL_WDX_D", "全部尾大"],
            ["BALL_WDX_X", "全部尾小"],
            ["TM_B1_D", "1球特码-单"],
            ["TM_B1_S", "1球特码-双"],
            ["TM_B1_B", "1球特码-大"],
            ["TM_B1_X", "1球特码-小"],
            ["TM_B2_D", "2球特码-单"],
            ["TM_B2_S", "2球特码-双"],
            ["TM_B2_B", "2球特码-大"],
            ["TM_B2_X", "2球特码-小"],
            ["TM_B3_D", "3球特码-单"],
            ["TM_B3_S", "3球特码-双"],
            ["TM_B3_B", "3球特码-大"],
            ["TM_B3_X", "3球特码-小"],
            ["TM_B4_D", "4球特码-单"],
            ["TM_B4_S", "4球特码-双"],
            ["TM_B4_B", "4球特码-大"],
            ["TM_B4_X", "4球特码-小"],
            ["TM_B5_D", "5球特码-单"],
            ["TM_B5_S", "5球特码-双"],
            ["TM_B5_B", "5球特码-大"],
            ["TM_B5_X", "5球特码-小"],
            ["TM_B6_D", "6球特码-单"],
            ["TM_B6_S", "6球特码-双"],
            ["TM_B6_B", "6球特码-大"],
            ["TM_B6_X", "6球特码-小"],
            ["TM_B7_D", "7球特码-单"],
            ["TM_B7_S", "7球特码-双"],
            ["TM_B7_B", "7球特码-大"],
            ["TM_B7_X", "7球特码-小"],
            ["TM_B8_D", "8球特码-单"],
            ["TM_B8_S", "8球特码-双"],
            ["TM_B8_B", "8球特码-大"],
            ["TM_B8_X", "8球特码-小"],
            ["FB_DX", "1-8球大小追同"],
            ["RB_DX", "1-8球大小追反"],
            ["FB_DS", "1-8球单双追同"],
            ["RB_DS", "1-8球单双追反"],
            ["FB_WDX", "1-8球尾大小追同"],
            ["RB_WDX", "1-8球尾大小追反"],
            ["FB_HDS", "1-8球合单双追同"],
            ["RB_HDS", "1-8球合单双追反"],
            ["CL_2_S", "长龙>=2 追同"],
            ["CL_2_R", "长龙>=2 追反"],
            ["CL_3_S", "长龙>=3 追同"],
            ["CL_3_R", "长龙>=3 追反"],
            ["CL_4_S", "长龙>=4 追同"],
            ["CL_4_R", "长龙>=4 追反"],
            ["CL_5_S", "长龙>=5 追同"],
            ["CL_5_R", "长龙>=5 追反"],
            ["CL_6_S", "长龙>=6 追同"],
            ["CL_6_R", "长龙>=6 追反"],
            ["CL_7_S", "长龙>=7 追同"],
            ["CL_7_R", "长龙>=7 追反"],
            ["CL_8_S", "长龙>=8 追同"],
            ["CL_8_R", "长龙>=8 追反"]
        ];
        $result = [];
        foreach ($data as $item) {
            [$betSelectId, $name] = $item;
            $result[$betSelectId] = [
                'betSelectId' => $betSelectId,
                'followResult' => 'N',
                'id' => $template . '-' . $betSelectId,
                'name' => $name,
                'template' => $template,
            ];
        }
        return $result[$key];
    }

    public static function get2zdwname($page)
    {
        if ($page == '' || $page == 0) {
            return ['DW54_0', '万千'];
        } elseif ($page == 1) {
            return ['DW53_0', '万佰'];
        } elseif ($page == 2) {
            return ['DW52_0', '万拾'];
        } elseif ($page == 3) {
            return ['DW51_0', '万个'];
        } elseif ($page == 4) {
            return ['DW43_0', '千佰'];
        } elseif ($page == 5) {
            return ['DW42_0', '千拾'];
        } elseif ($page == 6) {
            return ['DW41_0', '千个'];
        } elseif ($page == 7) {
            return ['DW32_0', '佰拾'];
        } elseif ($page == 8) {
            return ['DW31_0', '佰个'];
        } elseif ($page == 9) {
            return ['DW21_0', '拾个'];
        }
    }

    public static function get3zdwname($page)
    {
        if ($page == '' || $page == 0) {
            return ['DW543_0', '前三定位'];
        } elseif ($page == 1) {
            return ['DW432_0', '中三定位'];
        } elseif ($page == 2) {
            return ['DW321_0', '后三定位'];
        }
    }

    public static function get2zhsname($page)
    {
        if ($page == 54) {
            return ['HS54_0', '万千'];
        } elseif ($page == 53) {
            return ['HS53_0', '万佰'];
        } elseif ($page == 52) {
            return ['HS52_0', '万拾'];
        } elseif ($page == 51) {
            return ['HS51_0', '万个'];
        } elseif ($page == 43) {
            return ['HS43_0', '千佰'];
        } elseif ($page == 42) {
            return ['HS42_0', '千拾'];
        } elseif ($page == 41) {
            return ['HS41_0', '千个'];
        } elseif ($page == 32) {
            return ['HS32_0', '佰拾'];
        } elseif ($page == 31) {
            return ['HS31_0', '佰个'];
        } elseif ($page == 21) {
            return ['HS21_0', '拾个'];
        }
    }

    public static function get3zhsname($page)
    {
        if ($page == 543) {
            return ['HS543_0', '前三'];
        } elseif ($page == 432) {
            return ['HS432_0', '中三'];
        } elseif ($page == 321) {
            return ['HS321_0', '后三'];
        }
    }

    public static function get11x5zx($page)
    {
        if ($page == 2) {
            return ['Q2ZX_0', '前二直选'];
        } elseif ($page == 3) {
            return ['Q3ZX_0', '前三直选'];
        }
    }

    public static function strtoarray($str)
    {
        $len = mb_strlen($str, 'utf-8');
        $arr = [];
        for ($i = 0; $i < $len; $i++) {
            $arr[] = mb_substr($str, $i, 1, 'utf-8');
        }
        return $arr;
    }

    public static function getballs($fenlei)
    {
        $arr = [];
        if ($fenlei == 107) {//pk10系列
            $arr = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];
        } elseif ($fenlei == 101) {//时时彩系列
            $arr = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        } elseif ($fenlei == 103) {//快乐十分
            $arr = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20"];
        } elseif ($fenlei == 161) {//快乐8系列
            //01-80的号码数组
            $arr = [];
            for ($i = 1; $i <= 80; $i++) {
                $arr[] = $i < 10 ? '0' . $i : $i . '';
            }
        } elseif ($fenlei == 100) {//六合彩系列
            //01-80的号码数组
            $arr = [];
            for ($i = 1; $i <= 49; $i++) {
                $arr[] = $i < 10 ? '0' . $i : $i . '';
            }
        } elseif ($fenlei == 121) {//11选5系列
            $arr = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"];
        } elseif ($fenlei == 151) {//快3系列
            $arr = ["1", "2", "3", "4", "5", "6"];
        }
        return $arr;
    }

    public static function getlotterySubType($gname)
    {
        //如果名字包含澳洲
        if (strpos($gname, '澳洲') !== false) {
            return 3;
        } elseif (strpos($gname, '极速') !== false) {
            return 4;
        } elseif (strpos($gname, '幸运') !== false || strpos($gname, 'SG') !== false) {
            return 0;
        } elseif (strpos($gname, '六合彩') !== false) {
            return 2;
        } elseif (strpos($gname, '波场') !== false) {
            return 4;
        }
    }

    public static function getmaxball($template)
    {
        if ($template == 'SSC') {
            return 9;
        } elseif ($template == 'PK10') {
            return 10;
        } elseif ($template == 'K3') {
            return 6;
        } elseif ($template == '11X5') {
            return 11;
        } elseif ($template == 'KL8') {
            return 80;
        } elseif ($template == 'LHC') {
            return 49;
        } elseif ($template == 'KLSF') {
            return 20;
        } else {
            return 9;
        }
    }

    public static function defaultQuickAmount($ismobile = false)
    {
        if ($ismobile = false) {
            return [
                'amount1' => '5',
                'amount2' => '10',
                'amount3' => '20',
                'amount4' => '50',
                'amount5' => '100',
                'amount6' => '200',
                'amount7' => '500',
                'amount8' => '1000',
            ];
        } else {
            return [
                'amount1' => '5',
                'amount2' => '10',
                'amount3' => '20',
                'amount4' => '50',
                'amount5' => '100',
            ];
        }
    }

    public static function createColdHotData($type = 'cold', $qishu, $gid, $fenlei)
    {
        $key = 'coldhotdata_' . $type . '_' . $qishu . '_' . $gid;
        $t = Cache::get($key);
        if (empty($t)) {
            if ($fenlei == 101) {
                $t = rand(0, 9);
            } elseif ($fenlei == 107) {
                $t = rand(1, 10);
            } elseif ($fenlei == 103) {
                $t = rand(1, 20);
            } elseif ($fenlei == 161) {
                $t = rand(1, 80);
            } elseif ($fenlei == 121) {
                $t = rand(1, 11);
            }
            //缓存
            Cache::put($key, $t, 300);
        }
        return $t . '';
    }

    public static function getcname($fenlei, $bname, $sname, $cname)
    {
        if ($fenlei == 107) {
            if ($bname == '冠亚军组合') {
                if ($cname == '和大小' || $cname == '和单双') {
                    return '冠亚军' . $cname;
                } else {
                    return '冠亚军和';
                }
            } else {
                return $bname;
            }
        } elseif ($fenlei == 121) {
            if ($bname == '总和龙虎') {
                return '';
            } elseif ($bname == '连码') {
                return $bname;
            } else {
                return $cname;
            }
        } elseif ($fenlei == 101) {
            if ($bname == '1~5') {
                return $sname;
            } elseif ($bname == '3字定位' || $bname == '2字定位') {
                return '';
            } elseif ($bname == '3字和数' || $bname == '2字和数') {
                return $sname;
            } elseif ($bname == '跨度') {
                return $bname;
            } elseif ($bname == '斗牛' || $bname == '斗牛梭哈') {
                return '';
            } else {
                return $cname;
            }
        } elseif ($fenlei == 103) {
            if ($bname == '总和龙虎' || $bname == '连码') {
                return '';
            } elseif (strpos($bname, '球') !== false) {
                return $bname;
            } else {
                return $cname;
            }
        } elseif ($fenlei == 161) {
            if ($bname == '五行') {
                return '五行';
            } else {
                return $cname;
            }
        } else {
            return $cname;
        }
    }

    public static function gethtfllist($fenlei)
    {
        $arr = [];
        if ($fenlei == 107) {
            $arr[] = ['page' => '12', 'name' => '冠、亚军 组合'];
            $arr[] = ['page' => '3456', 'name' => '三、四、五、六名'];
            $arr[] = ['page' => '78910', 'name' => '七、八、九、十名'];
        } elseif ($fenlei == 101) {
            $arr[] = ['page' => 'lm', 'name' => '两面'];
            $arr[] = ['page' => 'dh', 'name' => '单号'];
            $arr[] = ['page' => 'ts', 'name' => '前中后三'];
            $arr[] = ['page' => '1z', 'name' => '一字组合'];
            $arr[] = ['page' => '2z', 'name' => '二字组合'];
            $arr[] = ['page' => '3z', 'name' => '三字组合'];
            $arr[] = ['page' => 'dw2', 'name' => '二字定位'];
            $arr[] = ['page' => 'dw3', 'name' => '三字定位'];
            $arr[] = ['page' => '2zhs', 'name' => '二字和数、和尾数'];
            $arr[] = ['page' => '3zhs', 'name' => '三字和数、和尾数'];
            $arr[] = ['page' => 'zx3', 'name' => '组选三'];
            $arr[] = ['page' => 'zx6', 'name' => '组选六'];
            $arr[] = ['page' => 'fs', 'name' => '复式组合'];
            $arr[] = ['page' => 'kd', 'name' => '跨度'];
            $arr[] = ['page' => 'dn', 'name' => '斗牛'];
        } elseif ($fenlei == 103) {//快十
            $arr[] = ['page' => 'ball', 'name' => '第一球', 'index' => 1];
            $arr[] = ['page' => 'ball', 'name' => '第二球', 'index' => 2];
            $arr[] = ['page' => 'ball', 'name' => '第三球', 'index' => 3];
            $arr[] = ['page' => 'ball', 'name' => '第四球', 'index' => 4];
            $arr[] = ['page' => 'ball', 'name' => '第五球', 'index' => 5];
            $arr[] = ['page' => 'ball', 'name' => '第六球', 'index' => 6];
            $arr[] = ['page' => 'ball', 'name' => '第七球', 'index' => 7];
            $arr[] = ['page' => 'ball', 'name' => '第八球', 'index' => 8];
            $arr[] = ['page' => 'zh', 'name' => '总和、正码'];
            $arr[] = ['page' => 'mp', 'name' => '连码'];
        } elseif ($fenlei == 161) {
            $arr[] = ['page' => 'all', 'name' => '总项盘口'];
            $arr[] = ['page' => 'ball', 'name' => '正码'];
        } elseif ($fenlei == 151) {
            $arr[] = ['page' => 'all', 'name' => '总项盘口'];
        } elseif ($fenlei == 121) {
            $arr[] = ['page' => 'lm', 'name' => '两面'];
            $arr[] = ['page' => 'dh', 'name' => '单号'];
            $arr[] = ['page' => 'mp', 'name' => '连码、直选'];
        }
        return $arr;
    }

    public static function getCsBypage($template, $page, $index = '')
    {
        $res = [];
        if ($template == 'SSC') {//时时彩系列
            switch ($page) {
                case 'lm':
                    $res['name'] = '两面';
                    $res['cs'] = 'DX1,DS1,DX2,DS2,DX3,DS3,DX4,DS4,DX5,DS5,ZDX,ZDS,LH';
                    break;
                case 'dh':
                    $res['name'] = '球号';
                    $res['cs'] = 'B1,B2,B3,B4,B5';
                    break;
                case 'ts':
                    $res['name'] = '前中后三';
                    $res['cs'] = 'TS1,TS2,TS3';
                    break;
                case '1z':
                    $res['name'] = '一字组合';
                    $res['cs'] = '1ZTS1,1ZTS2,1ZTS3,1ZTS5';
                    break;
                case '2z':
                    $res['name'] = '二字组合';
                    $res['cs'] = '2ZTS1,2ZTS2,2ZTS3';
                    break;
                case '3z':
                    $res['name'] = '三字组合';
                    $res['cs'] = '3ZTS1,3ZTS2,3ZTS3';
                    break;
                case 'dw2':
                    $res['name'] = '二字定位';
                    $res['cs'] = 'DW54,DW53,DW52,DW51,DW43,DW42,DW41,DW32,DW31,DW21';
                    break;
                case 'dw3':
                    $res['name'] = '三字定位';
                    $res['cs'] = 'DW543,DW432,DW321';
                    break;
                case '2zhs':
                    $res['name'] = '二字和数、和尾数';
                    $res['cs'] = 'HS54,HS53,HS52,HS51,HS43,HS42,HS41,HS32,HS31,HS21,HWS54,HWS53,HWS52,HWS51,HWS43,HWS42,HWS41,HWS32,HWS31,HWS21';
                    break;
                case '3zhs':
                    $res['name'] = '三字和数、和尾数';
                    $res['cs'] = 'HS543,HS432,HS321,HWS543,HWS432,HWS321';
                    break;
                case 'zx3':
                    $res['name'] = '组选三';
                    $res['cs'] = 'ZX3TS1,ZX3TS2,ZX3TS3';
                    break;
                case 'zx6':
                    $res['name'] = '组选六';
                    $res['cs'] = 'ZX6TS1,ZX6TS2,ZX6TS3';
                    break;
                case 'fs':
                    $res['name'] = '复式组合';
                    $res['cs'] = 'FSTS1,FSTS2,FSTS3';
                    break;
                case 'kd':
                    $res['name'] = '跨度';
                    $res['cs'] = 'KDTS1,KDTS2,KDTS3';
                    break;
                case 'dn':
                    $res['name'] = '斗牛';
                    $res['cs'] = 'DN,DNDS,DNDX,DNGP,DNYD,DNLD,DNSANT,DNSHUNZ,DNHL,DNSIT,DNWT';
                    break;
            }
        } elseif ($template == 'PK10') {//PK10系列
            switch ($page) {
                case '12':
                    $res['name'] = '冠、亚军 组合';
                    $res['cs'] = 'GYH,GDX,GDS,B1,DX1,DS1,LH1,B2,DX2,DS2,LH2';
                    break;
                case '3456':
                    $res['name'] = '三、四、五、六名';
                    $res['cs'] = 'B3,DX3,DS3,LH3,B4,DX4,DS4,LH4,B5,DX5,DS5,LH5,B6,DX6,DS6,LH6';
                    break;
                case '78910':
                    $res['name'] = '七、八、九、十名';
                    $res['cs'] = 'B7,DX7,DS7,B8,DX8,DS8,B9,DX9,DS9,B10,DX10,DS10';
                    break;
            }
        } elseif ($template == 'KLSF') {//快乐十分
            if ($page == 'ball' && $index == '1') {
                $res['name'] = '第一球';
                $res['cs'] = 'B1,DX1,DS1,WDX1,HDS1,FW1,ZFB1,LH1';
                $res['qiu'] = 'B1';
            } elseif ($page == 'ball' && $index == '2') {
                $res['name'] = '第二球';
                $res['cs'] = 'B2,DX2,DS2,WDX2,HDS2,FW2,ZFB2,LH2';
                $res['qiu'] = 'B2';
            } elseif ($page == 'ball' && $index == '3') {
                $res['name'] = '第三球';
                $res['cs'] = 'B3,DX3,DS3,WDX3,HDS3,FW3,ZFB3,LH3';
                $res['qiu'] = 'B3';
            } elseif ($page == 'ball' && $index == '4') {
                $res['name'] = '第四球';
                $res['cs'] = 'B4,DX4,DS4,WDX4,HDS4,FW4,ZFB4,LH4';
                $res['qiu'] = 'B4';
            } elseif ($page == 'ball' && $index == '5') {
                $res['name'] = '第五球';
                $res['cs'] = 'B5,DX5,DS5,WDX5,HDS5,FW5,ZFB5,LH5';
                $res['qiu'] = 'B5';
            } elseif ($page == 'ball' && $index == '6') {
                $res['name'] = '第六球';
                $res['cs'] = 'B6,DX6,DS6,WDX6,HDS6,FW6,ZFB6,LH6';
                $res['qiu'] = 'B6';
            } elseif ($page == 'ball' && $index == '7') {
                $res['name'] = '第七球';
                $res['cs'] = 'B7,DX7,DS7,WDX7,HDS7,FW7,ZFB7,LH7';
                $res['qiu'] = 'B7';
            } elseif ($page == 'ball' && $index == '8') {
                $res['name'] = '第八球';
                $res['cs'] = 'B8,DX8,DS8,WDX8,HDS8,FW8,ZFB8,LH8';
                $res['qiu'] = 'B8';
            } elseif ($page == 'zh') {
                $res['name'] = '总和、正码';
                $res['cs'] = 'ZM,ZDX,ZDS,ZWDX';
            } elseif ($page == 'mp') {
                $res['name'] = '连码';
                $res['cs'] = 'LM2,LM21,LM22,LM3,LM31,LM32,LM4,LM5';
            }
        } elseif ($template == '11X5') {//11选5系列
            switch ($page) {
                case 'lm':
                    $res['name'] = '两面';
                    $res['cs'] = 'DX1,DS1,DX2,DS2,DX3,DS3,DX4,DS4,DX5,DS5,ZDX,ZDS,ZWDX,LH';
                    break;
                case 'dh':
                    $res['name'] = '单号';
                    $res['cs'] = 'B1,B2,B3,B4,B5,ZM';
                    break;
                case 'mp':
                    $res['name'] = '连码、直选';
                    $res['cs'] = 'LM2,LM3,LM30,LM32,LM4,LM5,LM6,LM7,LM8,Q2ZX,Q3ZX';
                    break;
            }
        } elseif ($template == 'KL8') {//快乐8系列
            switch ($page) {
                case 'all':
                    $res['name'] = '总项盘口';
                    $res['cs'] = 'ZDX,ZDS,DXDS,QHH,DSH,WX,ZHT';
                    break;
                case 'ball':
                    $res['name'] = '正码';
                    $res['cs'] = 'ZM';
                    break;
            }
        } elseif ($template == 'K3') {//快3系列
            switch ($page) {
                case 'all':
                    $res['name'] = '总项盘口';
                    $res['cs'] = '';
                    break;
            }
        }
        return $res;
    }

    public static function getfLbYGroup($template, $cs)
    {
        if ($template == 'SSC') {
            if (in_array($cs, ['DX1', 'DS1', 'DX2', 'DS2', 'DX3', 'DS3', 'DX4', 'DS4', 'DX5', 'DS5', 'ZDX', 'ZDS', 'LH'])) {
                $cs = 'LM';
            } elseif (in_array($cs, ['TS1', 'TS2', 'TS3'])) {
                $cs = 'TS';
            } elseif (in_array($cs, ['1ZTS1', '1ZTS2', '1ZTS3', '1ZTS5'])) {
                $cs = '1Z';
            } elseif (in_array($cs, ['2ZTS1', '2ZTS2', '2ZTS3'])) {
                $cs = '2Z';
            } elseif (in_array($cs, ['3ZTS1', '3ZTS2', '3ZTS3'])) {
                $cs = '3Z';
            } elseif (in_array($cs, ['DW54', 'DW53', 'DW52', 'DW51', 'DW43', 'DW42', 'DW41', 'DW32', 'DW31', 'DW21'])) {
                $cs = '2DW';
            } elseif (in_array($cs, ['DW543', 'DW432', 'DW321'])) {
                $cs = '3DW';
            } elseif (in_array($cs, ['HS54', 'HS53', 'HS52', 'HS51', 'HS43', 'HS42', 'HS41', 'HS32', 'HS31', 'HS21', 'HWS54', 'HWS53', 'HWS52', 'HWS51', 'HWS43', 'HWS42', 'HWS41', 'HWS32', 'HWS31', 'HWS21'])) {
                $cs = '2HS';
            } elseif (in_array($cs, ['HS543', 'HS432', 'HS321', 'HWS543', 'HWS432', 'HWS321'])) {
                $cs = '3HS';
            } elseif (in_array($cs, ['ZX3TS1', 'ZX3TS2', 'ZX3TS3'])) {
                $cs = 'ZX3';
            } elseif (in_array($cs, ['ZX6TS1', 'ZX6TS2', 'ZX6TS3'])) {
                $cs = 'ZX6';
            } elseif (in_array($cs, ['FSTS1', 'FSTS2', 'FSTS3'])) {
                $cs = 'FS';
            } elseif (in_array($cs, ['KDTS1', 'KDTS2', 'KDTS3'])) {
                $cs = 'KD';
            } elseif (in_array($cs, ['DN', 'DNDS', 'DNDX', 'DNGP', 'DNYD', 'DNLD', 'DNSANT', 'DNSHUNZ', 'DNHL', 'DNSIT', 'DNWT'])) {
                $cs = 'DN';
            }
        }
        return $cs;
    }

    public static function getSgKeyByIndex($fenlei, $index)
    {
        $json = [];
        if ($fenlei == 101) {//时时彩
            $json = [0 => 'BALL', 1 => 'LM', 2 => 'LH', 3 => 'TS', 4 => 'DN', 5 => 'DNDX', 6 => 'DNDS', 7 => 'DNWT', 8 => 'DNSIT', 9 => 'DNHL', 10 => 'DNSHUNZ',
                11 => 'DNSANT', 12 => 'DNLD', 13 => 'DNYD', 14 => 'DNGP', 15 => '1Z', 16 => '2Z', 17 => '3Z', 18 => '2DW', 19 => '3DW', 20 => '2ZHS', 21 => 'HWS'
                , 22 => '3ZHS', 23 => 'ZX3', 24 => 'ZX6', 25 => 'KD', 26 => 'FS'];
        } elseif ($fenlei == 107) {//赛车系列
            $json = [0 => 'BALL', 1 => 'LM', 2 => 'GDX', 3 => 'GDS', 4 => 'GYH'];
        } elseif ($fenlei == 103) {//快乐十分系列
            $json = [0 => 'BALL', 1 => 'LM', 2 => 'FW', 3 => 'ZFB', 4 => 'ZM', 5 => 'ZDS', 6 => 'ZWDX', 7 => 'MP'];
        } elseif ($fenlei == 121) {//11选5系列
            $json = [0 => 'BALL', 1 => 'LM', 2 => 'ZDS', 3 => 'ZWDX', 4 => 'ZM', 5 => 'MP'];
        } elseif ($fenlei == 161) {//快乐8系列
            $json = [0 => 'ZM', 1 => 'LM', 2 => 'ZHT', 3 => 'DXDS', 4 => 'QHH', 5 => 'DSH', 6 => 'WX'];
        } elseif ($fenlei == 151) {//快3系列
            $json = [0 => 'DX', 1 => '3G', 2 => 'WS', 3 => 'QS', 4 => 'DS', 5 => 'CP', 6 => 'DP'];
        }
        return $json[$index];
    }

    public static function gettree($fuser)
    {
        $layer = $fuser['layer'];
        $fid = $fuser['userid'];
        $num = User::where(['fid' => $fid, 'ifagent' => 1, 'ifson' => 0])->count('userid');
        $tree[0]['name'] = "直属代理";
        $tree[0]['parent'] = $fuser['username'];
        $tree[0]['num'] = $num;
        $tree[0]['type'] = 2;
        $tree[0]['layer'] = 0;
        $num = User::where(['fid' => $fid, 'ifagent' => 0])->count('userid');
        $tree[1]['name'] = "直属会员";
        $tree[1]['parent'] = $fuser['username'];
        $tree[1]['num'] = $num;
        $tree[1]['type'] = 1;
        $tree[1]['layer'] = 0;
        $j = 2;
        $layers = json_decode(x_config('layer'), true);
        if ($fid != Constants::$SUID) {
            $num = User::where(['fid' . $layer => $fid, 'ifagent' => 1, 'ifson' => 0])->where('layer', ">", 0)->count('userid');
        } else {
            $num = User::where(['ifagent' => 1, 'ifson' => 0])->where('layer', ">", 0)->count('userid');
        }
        $tree[$j]['name'] = "全部代理";
        $tree[$j]['parent'] = $fuser['username'];
        $tree[$j]['num'] = $num;
        $tree[$j]['type'] = 2;
        $tree[$j]['layer'] = '';
        $j++;
        for ($i = $layer + 1; $i <= 10; $i++) {
            $c = 0;
            if ($fid != 99999999) {
                $c = User::where(['fid' . $layer => $fid, 'layer' => $i, 'ifagent' => 1, 'ifson' => 0])->count('userid');
            } else {
                $c = User::where(['layer' => $i, 'ifagent' => 1, 'ifson' => 0])->count('userid');
            }
            if ($c > 0) {
                $tree[$j]['type'] = 2;
                $tree[$j]['layer'] = $i;
                $tree[$j]['num'] = $c;
                $tree[$j]['name'] = $layers[$i - 1];
                $tree[$j]['parent'] = $fuser['username'];
                $j++;
            }
        }
        $j++;
        if ($fid != Constants::$SUID) {
            $num = User::where(['fid' . $layer => $fid, 'ifagent' => 0])->where('layer', ">", 0)->count('userid');
        } else {
            $num = User::where(['ifagent' => 0])->where('layer', ">", 0)->count('userid');
        }
        if ($num > 0) {
            $tree[$j]['name'] = "全部会员";
            $tree[$j]['parent'] = $fuser['username'];
            $tree[$j]['num'] = $num;
            $tree[$j]['type'] = 1;
            $tree[$j]['layer'] = '';
        }
        return $tree;
    }

    //是否是双面玩法
    public static function islm($name)
    {
        if ($name == '两面' || $name == '双面' || $name == '1-10名双面' || $name == '1-5双面' || $name == '总和两面') {
            return true;
        } else {
            return false;
        }
    }

    public static function getCsByMember($template, $page, $index = '')
    {
        if ($template == 'SSC') {//时时彩系列
            if ($page == 'lm') {
                return 'DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3';
            } elseif ($page == 'ball' && $index == '1_5') {
                return 'DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,B1,B2,B3,B4,B5';
            } elseif ($page == '1z') {
                return '1ZTS1,1ZTS2,1ZTS3,1ZTS5,DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3';
            } elseif ($page == '2z') {
                return '2ZTS1,DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3';
            } elseif ($page == '3z') {
                return '3ZTS1,DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3';
            } elseif ($page == '2zdw') {
                return 'DW54,DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3';
            } elseif ($page == '3zdw') {
                return 'DW543,DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3';
            } elseif ($page == '2zhs' && $index == '54') {
                return 'HS54,HWS54,DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3';
            }
        }
        return '';
    }

    //根据ip段生成随机ip
    public static function create_randip($city = 'guangzhou')
    {
        try {
            $path = dirname(dirname(__FILE__)) . "/dat/ipcity/$city.txt";
            //随机从文件读取一行
            $ip = file($path);
            $ip = $ip[array_rand($ip)];
            //去掉换行符
            $ip = str_replace(array("\r\n", "\r", "\n", "", " "), '', $ip);
            if ($ip) {
                //分割ip段
                $ips = explode('/', $ip);
                if (count($ips) != 2) return false;
                //计算ip段最大最小值
                $min = $ips[0];
                $max = substr($min, 0, strrpos($min, '.')) . '.' . $ips[1];
                //判断min和max是否是合法ip
                if (ip2long($min) === false || ip2long($max) === false) return false;
                $m1 = ip2long($min);
                $m2 = ip2long($max);
                if ($m2 < $m1) {
                    $m1 = ip2long($max);
                    $m2 = ip2long($min);
                }
                if ($m1 <= 0 || $m2 <= 0 || $m2 < $m1) return false;
                $ip = long2ip(mt_rand($m1, $m2));
            }
        } catch (\Exception $e) {
            return '';
        }
        return $ip;
    }

    public static function bjdate($drawDate)
    {
        $today = ComFunc::getthisdate();
        $t1 = strtotime($today);
        $today = str_replace('-', '', $today);
        $editend = str_replace(':', '', x_config('editend'));
        $mytime = date('His', strtotime($drawDate));
        $lindate = date('Ymd', strtotime($drawDate));
        if (($lindate == $today || (strtotime($drawDate) >= $t1)) && $mytime >= $editend) {
            $tb = SGUtils::getcuretable();
        } else {
            $editstart = str_replace(':', '', x_config('editstart'));
            $drawstart = date('His', strtotime($drawDate));
            if ($drawstart < $editstart) {
                $tb = 'lib_' . date('Ymd', strtotime($drawDate) - 86400);
            } else {
                $tb = 'lib_' . date('Ymd', strtotime($drawDate));
            }
        }
        return $tb;
    }

    //获取当日注单表
    public static function getcuretable($isqz = false, $endtime = ''){
        $his = date("His");
        if (empty($endtime)) {
            $editend = x_config('editend');
        } else {
            $editend = $endtime;
        }
        if ($his < str_replace(':', '', $editend)) {
            $today = date("Ymd", time() - 86400);
        } else {
            $today = date("Ymd");
        }
        $table = $isqz ? 'x_lib_' . $today : 'lib_' . $today;
        return $table;
    }

    public static function getcureflytable($isqz = false)
    {
        $his = date("His");
        if ($his < str_replace(':', '', x_config('editend'))) {
            $today = date("Ymd", time() - 86400);
        } else {
            $today = date("Ymd");
        }
        $table = $isqz ? 'x_libfly_' . $today : 'libfly_' . $today;
        return $table;
    }

    public static function getcurdate()
    {
        $his = date("His");
        if ($his < str_replace(':', '', x_config('editend'))) {
            $today = date("Ymd", time() - 86400);
        } else {
            $today = date("Ymd");
        }
        return $today;
    }

    //根据当日注单表生成model对象
    public static function getcuremodel($endtime = '')
    {
        $table = self::getcuretable(false, $endtime);
        $model = new LibModel();
        $model->setTable($table);
        return $model;
    }

    public static function getcureflymodel()
    {
        $table = self::getcureflytable();
        $model = new LibModel();
        $model->setTable($table);
        return $model;
    }

    public static function updateUserAmount($userId, $amount)
    {
        $lockKey = "user:{$userId}:lock";
        //获取锁，其他的请求会阻塞
        $lock = Cache::lock($lockKey, 3);
        if ($lock->get()) {
            $user = User::where('userid', $userId)->select(['id', 'userid', 'kmoney'])->first();
            if ($user) {
                $user->kmoney = $user->kmoney + $amount;
                $user->save();
            }
            $lock->release();
        }
        return true;
    }


    public static function autozjhandleragent($zjfid, $userid, $sonuid, $title, $lottery, $ip, $tmpuserids, $type = 1)
    {
        $count = Autozj::where($zjfid, $userid)->count('id');
        if ($count > 0) {
            $libmodel = SGUtils::getcuremodel();
            if ($type == 1) {
                $game = Game::where('lottery', $lottery)->select(['gid', 'gname'])->first();
                $title = $title . '-' . $game['gname'];
                $tmpuserids = Autozj::where($zjfid, $userid)->pluck('userid')->toArray();
                $ordercount = $libmodel->where($zjfid, $userid)->where(['gid' => $game['gid'], 'z' => 9])->whereIn('userid', $tmpuserids)->count('id');
            } elseif ($type == 2) {
                if (!empty($lottery)) {
                    $game = Game::where('lottery', $lottery)->select(['gid', 'gname'])->first();
                    $title .= '-' . $game['gname'];
                }
                $ordercount = $libmodel->where($zjfid, $userid)->where('z', 9)->whereIn('userid', $tmpuserids)->count('id');
            } elseif ($type == 3) {
                $ordercount = 1;
            }
            if ($ordercount > 0) {
                $time = time();
                $db = Db::connection();
                $db->update("update x_autozjconfig set fwtime=$time where $zjfid=" . $userid);
                Autozjlog::create(['userid' => $userid, 'ziuserid' => $sonuid, 'time' => time(), 'path_name' => $title, 'ip' => $ip, 'type' => 1]);
            }
        }
    }

    public static function chttpurl($request)
    {
        //如果域名是ip地址，就用http://ip:port的形式
        $domain = $request->server('HTTP_HOST');
        //去掉端口号
        $domain = explode(':', $domain)[0];
        if (filter_var($domain, FILTER_VALIDATE_IP)) {
            $domain = 'http://' . $domain . ':' . $request->server('SERVER_PORT');
            return $domain;
        } else {
            return '';
        }
    }

    //判断当前是否处于维护时间段
    public static function pdisweihu()
    {
        $his = date('His');
        //当前时间大于06:25:00小于06:30:00
        if ($his >= 62500 && $his < 63000) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function dotask(){
        $thisdate = ComFunc::getthisdateend();
        $thisdate = strtotime($thisdate);
        //回水结算任务
        $cashagentfs = UserEdit::where(['userid' => Constants::$SUID, 'other' => $thisdate, 'moduleKey' => 'stystem', 'functionKey' => 'task', 'actionKey' => 'backwater'])->count('id');
        if ($cashagentfs <= 0) {
            try {
                AutosService::backwaterCompete();//代理退水结算
            } catch (\Exception $e) {
                Log::info('回水结算失败.message:' . $e->getMessage());
            }
        }
        //额度矫正任务
        $cashuseredu = UserEdit::where(['userid' => Constants::$SUID, 'other' => $thisdate, 'moduleKey' => 'stystem', 'functionKey' => 'task', 'actionKey' => 'cashuseredu'])->count('id');
        if ($cashuseredu <= 0) {
            try {
                AutosService::edu_zhuanhuan();//现金模式额度恢复
            } catch (\Exception $e) {
                Log::info('现金模式额度恢复失败.message:' . $e->getMessage());
            }
        }
        //清理数据任务
        $cleardata = UserEdit::where(['userid' => Constants::$SUID, 'other' => $thisdate, 'moduleKey' => 'stystem', 'functionKey' => 'task', 'actionKey' => 'cleardata'])->count('id');
        if ($cleardata <= 0) {
            try {
                AutosService::cleardata();//删除多少天的数据
            } catch (\Exception $e) {
                Log::info('清理数据失败.message:' . $e->getMessage());
            }
        }
    }

    public static $ftredis = null;

    public static function getftredis()
    {
        if (self::$ftredis == null) {
            self::$ftredis = new \Redis();
            self::$ftredis->connect('172.26.18.69', 58637);
            self::$ftredis->auth('GHyMLDQpTBIA');
            self::$ftredis->select(5);
        }
        return self::$ftredis;
    }

    public static function pdislmorball($game)
    {
        if (in_array($game, ['GDX', 'GDS'])) {
            return true;
        } elseif (in_array($game, ['DX1', 'DX2', 'DX3', 'DX4', 'DX5', 'DX6', 'DX7', 'DX8', 'DX9', 'DX10'])) {
            return true;
        } elseif (in_array($game, ['DS1', 'DS2', 'DS3', 'DS4', 'DS5', 'DS6', 'DS7', 'DS8', 'DS9', 'DS10'])) {
            return true;
        } elseif (in_array($game, ['B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10'])) {
            return true;
        } elseif (in_array($game, ['LH1', 'LH2', 'LH3', 'LH4', 'LH5'])) {
            return true;
        } elseif (in_array($game, ['ZDX', 'ZDS', 'LH'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function ruidGameModel($ruid){
        return Game::Join('userpatt', 'game.gid', '=', 'userpatt.gid')
            ->where('userpatt.userid', $ruid)
            ->where('userpatt.ifopen', 1)
            ->where('userpatt.ifok', 1)
            ->where('game.ifopen', 1);
    }

    public static function ruidGameModelByRoom($ruid){
        return Game::Join('userpatt', 'game.gid', '=', 'userpatt.gid')
            ->where('userpatt.userid', $ruid)
            ->where('userpatt.ifopen', 1)
            ->where('game.ifopen', 1);
    }

    public static function currentPeriod($gid, $dates = null,$thisqishu = null,$fields = ['*']){
        if (empty($dates)) {
            $dates = ComFunc::getthisdate();
        }
        $time = time();
        $model = Kj::where(['gid' => $gid, 'dates' => strtotime($dates), 'status' => 0]);
        if(!empty($thisqishu)){
            $model = $model->where('qishu',$thisqishu);
        }else{
            $model = $model->where('kjtime', '>=', $time);
        }
        return $model->select($fields)->orderBy('qishu')->first();
    }

    public static function nextPeriod($gid, $period, $dates = null)
    {
        if (empty($dates)) {
            $dates = ComFunc::getthisdate();
        }
        return Kj::where(['gid' => $gid, 'dates' => strtotime($dates), 'status' => 0])->where('qishu', '>', $period)->orderBy('qishu')->first();
    }

    public static function upPeriod($gid,$dates = null,$fields = ['*'],$qishu = null){
        if(empty($qishu)){
            if (empty($dates)) {
                $dates = ComFunc::getthisdateend();
            }
            $dates = strtotime($dates);
            $kjmodel = Kj::where(['gid' => $gid, 'status' => 1, 'dates' => $dates]);
            $kjdata = $kjmodel->select($fields)->orderByDesc('qishu')->first();
            if (empty($kjdata)) {//减少一天
                $dates = $dates - 86400;
                $kjdata = Kj::where(['gid' => $gid, 'status' => 1, 'dates' => $dates])->select($fields)->orderByDesc('qishu')->first();
            }
        }else{
            $kjdata = Kj::where(['gid' => $gid, 'qishu' => $qishu])->select($fields)->first();
        }
        return $kjdata;
    }

    //根据开始时间和结束时间判断当前系统时间是否在这个范围内
    public static function pdtime($start, $end)
    {
        // 获取当前系统时间
        $current_time = time();
        // 判断当前时间是否在任一时间段内
        $in_time_period = 0;
        // 将时间段转换为时间戳
        $start_time = strtotime($start);
        $end_time = strtotime($end);
        // 如果结束时间在开始时间之前，表示跨越了两天
        if ($end_time < $start_time) {
            if ($current_time >= $start_time || $current_time <= $end_time) {
                $in_time_period = 1;
            }
        } else {
            if ($current_time >= $start_time && $current_time <= $end_time) {
                $in_time_period = 1;
            }
        }
        return $in_time_period;
    }

    public static function createPredictInfo($fenlei)
    {
        $list = [];
        if ($fenlei == 107) {//赛车
            //冠亚和
            $item = [];
            $item['name'] = '冠亚和';
            $item['referenceNum'] = self::randResult('gyh', $fenlei, 5, 1);
            $item['bigOrSmall'] = self::randResult('bigOrSmall', $fenlei, 1, 1);
            $item['singleOrDouble'] = self::randResult('singleOrDouble', $fenlei, 1, 1);
            $list[] = $item;
            //第一球-第十球
            $qiuNameArr = ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十'];
            for ($i = 0; $i < 10; $i++) {
                $item = [];
                $item['name'] = '第' . $qiuNameArr[$i] . '球';
                $item['referenceNum'] = self::randResult('number', $fenlei, 5, 1);
                $item['bigOrSmall'] = self::randResult('bigOrSmall', $fenlei, 1, 1);
                $item['singleOrDouble'] = self::randResult('singleOrDouble', $fenlei, 1, 1);
                $list[] = $item;
            }
        } elseif ($fenlei == 101) {//时时彩
            //总和
            $item = [];
            $item['name'] = '总和';
            $item['referenceNum'] = self::randResult('zonghe', $fenlei, 1, 1);
            $item['bigOrSmall'] = self::randResult('bigOrSmall', $fenlei, 1, 1);
            $item['singleOrDouble'] = self::randResult('singleOrDouble', $fenlei, 1, 1);
            $list[] = $item;
            //第一球-第五球
            $qiuNameArr = ['一', '二', '三', '四', '五'];
            for ($i = 0; $i < 5; $i++) {
                $item = [];
                $item['name'] = '第' . $qiuNameArr[$i] . '球';
                $item['referenceNum'] = self::randResult('number', $fenlei, 5, 1);
                $item['bigOrSmall'] = self::randResult('bigOrSmall', $fenlei, 1, 1);
                $item['singleOrDouble'] = self::randResult('singleOrDouble', $fenlei, 1, 1);
                $list[] = $item;
            }
        } elseif ($fenlei == 444) {//宾果
            //总和
            $item = [];
            $item['name'] = '和值';
            $item['referenceNum'] = self::randResult('zonghe', $fenlei, 1, 1);
            $item['bigOrSmall'] = self::randResult('bigOrSmall', $fenlei, 1, 1);
            $item['singleOrDouble'] = self::randResult('singleOrDouble', $fenlei, 1, 1);
            $list[] = $item;
            //第一球-第五球
            $qiuNameArr = ['平码一', '平码二', '平码三', '平码四', '和值'];
            for ($i = 0; $i < 5; $i++) {
                $item = [];
                $item['name'] = $qiuNameArr[$i];
                $item['referenceNum'] = self::randResult('number', $fenlei, 5, 1);
                $item['bigOrSmall'] = self::randResult('bigOrSmall', $fenlei, 1, 1);
                $item['singleOrDouble'] = self::randResult('singleOrDouble', $fenlei, 1, 1);
                $list[] = $item;
            }
        }
        return $list;
    }

    public static function randResult($type, $fenlei, $count, $isToStr)
    {
        $result = [];
        if ($fenlei == 107) {
            if ($type == 'number') {
                $numarr = self::generateUniqueRandomNumbers(1, 10, $count, 0);
            } elseif ($type == 'gyh') {//3-19
                $numarr = self::generateUniqueRandomNumbers(3, 19, $count, 0);
            } elseif ($type == 'bigOrSmall') {
                $numarr = ['大', '小'];
            } elseif ($type == 'singleOrDouble') {
                $numarr = ['单', '双'];
            }
        } elseif ($fenlei == 101) {
            if ($type == 'number') {
                $numarr = self::generateUniqueRandomNumbers(0, 9, $count, 0);
            } elseif ($type == 'zonghe') {
                $numarr = ['龙', '虎', '龙', '虎', '龙', '虎', '龙', '虎', '和'];
            } elseif ($type == 'bigOrSmall') {
                $numarr = ['大', '小'];
            } elseif ($type == 'singleOrDouble') {
                $numarr = ['单', '双'];
            }
        }elseif ($fenlei == 444) {
            if ($type == 'number') {
                $numarr = self::generateUniqueRandomNumbers(1, 80, $count, 0);
            } elseif ($type == 'zonghe') {
                $numarr = ['大', '小', '单', '双'];
            } elseif ($type == 'bigOrSmall') {
                $numarr = ['大', '小'];
            } elseif ($type == 'singleOrDouble') {
                $numarr = ['单', '双'];
            }
        }
        if ($type == 'number' || $type == 'gyh') {
            if ($isToStr == 1) {
                $result = implode(',', $numarr);
            }
        } else {
            for ($i = 0; $i < $count; $i++) {
                $result[] = $numarr[array_rand($numarr)];
            }
            if ($isToStr == 1) {
                $result = implode(',', $result);
            }
        }
        return $result;
    }

    public static function generateUniqueRandomNumbers($min, $max, $count, $allowDuplicates)
    {
        $numbers = [];
        if ($allowDuplicates) {
            // 允许重复生成号码
            for ($i = 0; $i < $count; $i++) {
                $numbers[] = rand($min, $max);
            }
        } else {
            // 不允许重复生成号码
            $allNumbers = range($min, $max);
            shuffle($allNumbers);
            $numbers = array_slice($allNumbers, 0, $count);
        }
        //从小到大排序
        sort($numbers);
        return $numbers;
    }

    public static function randomName()
    {
        $nameArr = ['赵', '钱', '孙', '李', '周', '吴', '郑', '王', '冯', '陈', '褚', '卫', '蒋', '沈', '韩', '杨', '朱', '秦', '尤', '许', '何', '吕', '施', '张', '孔', '曹', '严', '华', '金', '魏', '陶', '姜', '戚', '谢', '邹', '喻', '柏', '水', '窦', '章', '云', '苏', '潘', '葛', '奚', '范', '彭', '郎', '鲁', '韦', '昌', '马', '苗', '凤', '花', '方', '俞', '任', '袁', '柳', '酆', '鲍', '史', '唐', '费', '廉', '岑', '薛', '雷', '贺', '倪', '汤', '滕'];
        //随机去3个
        $indexarr = array_rand($nameArr, 3);
        $name = '';
        for ($i = 0; $i < 3; $i++) {
            $name .= $nameArr[$indexarr[$i]];
        }
        return $name;
    }

    //组合玩法
    public static function formatNumber($number,$len) {
        return number_format($number, $len, '.', '');
    }

    public static function generateOrderNumber() {
        $timestamp = microtime(true); // 获取当前时间戳（包含微秒部分）
        $timestamp = str_replace('.','',$timestamp);
        $randomNumber = mt_rand(1000, 9999); // 生成一个四位随机数
        return $timestamp.$randomNumber; // 拼接生成订单号
    }

    public static function getUtypeStr($type){
        if($type == 2) {
            return '房主';
        }elseif ($type == 3) {
            return '代理';
        }elseif ($type == 4) {
            return '会员';
        }
        return '';
    }

    public static function delDir($dir){
        if (!is_dir($dir)) {
            return false;
        }
        $handle = opendir($dir);
        while (($file = readdir($handle)) !== false) {
            if ($file != '.' && $file != '..') {
                $file = $dir . '/' . $file;
                if (is_dir($file)) {
                    self::delDir($file);
                } else {
                    unlink($file);
                }

            }
        }
        closedir($handle);
        rmdir($dir);
        return true;
    }

    /**
     * 判断日期范围
     * @param $startDate
     * @param $endDate
     * @param $maxDays
     * @param null $maxDate
     * @return bool
     */
    public static function pdDateRange($startDate,$maxDays){
        $minDate = date('Y-m-d',strtotime("-{$maxDays} day"));
        if($startDate < $minDate){
            return false;
        }
        return true;
    }

    public static function getStatusStr($room_status){
        if($room_status == 1){
            return '正常';
        }elseif ($room_status == 0){
            return '禁用';
        }elseif ($room_status == 2){
            return '禁言';
        }elseif ($room_status == 3){
            return '冻结';
        }
        return '';
    }


    public static function createDajiToken($uuid, $sid, $timestamp, $qwer = 'WEOROCBS'){
        // 按照前端的逻辑拼接字符串：uuid + sid + timestamp + qwer
        $tokenStr = $uuid . $sid . $timestamp . $qwer;
        // 使用MD5生成token
        $token = md5($tokenStr);
        return $token;
    }

    //根据数据库字段获取大吉玩法
    public static function getDajiPlay($cy){
        //平码一
        if($cy == 'DX1_D'){
            return ['5370','平码一大'];
        }elseif($cy == 'DX1_X'){
            return ['5371','平码一小'];
        }elseif($cy == 'DS1_D'){
            return ['5372','平码一单'];
        }elseif($cy == 'DS1_S'){
            return ['5373','平码一双'];
        }elseif($cy == 'WDX1_D'){
            return ['5374','平码一尾大'];
        }elseif($cy == 'WDX1_X'){
            return ['5375','平码一尾小'];
        }elseif($cy == 'HDS1_D'){
            return ['5376','平码一合单'];
        }elseif($cy == 'HDS1_S'){
            return ['5377','平码一合双'];
        }elseif($cy == 'FLSX1_F'){
            return ['21831','平码一福'];
        }elseif($cy == 'FLSX1_L'){
            return ['21832','平码一禄'];
        }elseif($cy == 'FLSX1_S'){
            return ['21833','平码一寿'];
        }elseif($cy == 'FLSX1_X'){
            return ['21834','平码一喜'];
        }

        //平码二
        if($cy == 'DX2_D'){
            return ['5378','平码二大'];
        }elseif($cy == 'DX2_X'){
            return ['5379','平码二小'];
        }elseif($cy == 'DS2_D'){
            return ['5380','平码二单'];
        }elseif($cy == 'DS2_S'){
            return ['5381','平码二双'];
        }elseif($cy == 'WDX2_D'){
            return ['5382','平码二尾大'];
        }elseif($cy == 'WDX2_X'){
            return ['5383','平码二尾小'];
        }elseif($cy == 'HDS2_D'){
            return ['5384','平码二合单'];
        }elseif($cy == 'HDS2_S'){
            return ['5385','平码二合双'];
        }elseif($cy == 'FLSX2_F'){
            return ['21835','平码二福'];
        }elseif($cy == 'FLSX2_L'){
            return ['21836','平码二禄'];
        }elseif($cy == 'FLSX2_S'){
            return ['21837','平码二寿'];
        }elseif($cy == 'FLSX2_X'){
            return ['21838','平码二喜'];
        }

        //平码三
        if($cy == 'DX3_D'){
            return ['5386','平码三大'];
        }elseif($cy == 'DX3_X'){
            return ['5387','平码三小'];
        }elseif($cy == 'DS3_D'){
            return ['5388','平码三单'];
        }elseif($cy == 'DS3_S'){
            return ['5389','平码三双'];
        }elseif($cy == 'WDX3_D'){
            return ['5390','平码三尾大'];
        }elseif($cy == 'WDX3_X'){
            return ['5391','平码三尾小'];
        }elseif($cy == 'HDS3_D'){
            return ['5392','平码三合单'];
        }elseif($cy == 'HDS3_S'){
            return ['5393','平码三合双'];
        }elseif($cy == 'FLSX3_F'){
            return ['21839','平码三福'];
        }elseif($cy == 'FLSX3_L'){
            return ['21840','平码三禄'];
        }elseif($cy == 'FLSX3_S'){
            return ['21841','平码三寿'];
        }elseif($cy == 'FLSX3_X'){
            return ['21842','平码三喜'];
        }

        //平码四
        if($cy == 'DX4_D'){
            return ['5394','平码四大'];
        }elseif($cy == 'DX4_X'){
            return ['5395','平码四小'];
        }elseif($cy == 'DS4_D'){
            return ['5396','平码四单'];
        }elseif($cy == 'DS4_S'){
            return ['5397','平码四双'];
        }elseif($cy == 'WDX4_D'){
            return ['5398','平码四尾大'];
        }elseif($cy == 'WDX4_X'){
            return ['5399','平码四尾小'];
        }elseif($cy == 'HDS4_D'){
            return ['5400','平码四合单'];
        }elseif($cy == 'HDS4_S'){
            return ['5401','平码四合双'];
        }elseif($cy == 'FLSX4_F'){
            return ['21843','平码四福'];
        }elseif($cy == 'FLSX4_L'){
            return ['21844','平码四禄'];
        }elseif($cy == 'FLSX4_S'){
            return ['21845','平码四寿'];
        }elseif($cy == 'FLSX4_X'){
            return ['21846','平码四喜'];
        }

        //平码五
        if($cy == 'DX5_D'){
            return ['5402','特码(第五球)大'];
        }elseif($cy == 'DX5_X'){
            return ['5403','特码(第五球)小'];
        }elseif($cy == 'DS5_D'){
            return ['5404','特码(第五球)单'];
        }elseif($cy == 'DS5_S'){
            return ['5405','特码(第五球)双'];
        }elseif($cy == 'WDX5_D'){
            return ['5406','特码(第五球)尾大'];
        }elseif($cy == 'WDX5_X'){
            return ['5407','特码(第五球)尾小'];
        }elseif($cy == 'HDS5_D'){
            return ['5408','特码(第五球)合单'];
        }elseif($cy == 'HDS5_S'){
            return ['5409','特码(第五球)合双'];
        }elseif($cy == 'FLSX5_F'){
            return ['21847','特码(第五球)福'];
        }elseif($cy == 'FLSX5_L'){
            return ['21848','特码(第五球)禄'];
        }elseif($cy == 'FLSX5_S'){
            return ['21849','特码(第五球)寿'];
        }elseif($cy == 'FLSX5_X'){
            return ['21850','特码(第五球)喜'];
        }

        //前五和值
        if($cy == 'ZDX_D'){
            return ['5364','前五和值大'];
        }elseif($cy == 'ZDX_X'){
            return ['5365','前五和值小'];
        }elseif($cy == 'ZDS_D'){
            return ['5366','前五和值单'];
        }elseif($cy == 'ZDS_S'){
            return ['5367','前五和值双'];
        }elseif($cy == 'ZWDX_D'){
            return ['5368','前五和值尾大'];
        }elseif($cy == 'ZWDX_X'){
            return ['5369','前五和值尾小'];
        }elseif($cy == 'LH_L'){
            return ['5418','前五和值龙'];
        }elseif($cy == 'LH_H'){
            return ['5419','前五和值虎'];
        }
    }

    public static function generateToken($userInfo){
        // 生成唯一token：时间戳 + 随机字符串 + 用户ID的哈希
        $timestamp = time();
        $randomString = Str::random(32);
        $userHash = md5($userInfo['userid'].$userInfo['username'].$timestamp.$randomString);
        return $userHash;
    }
}
