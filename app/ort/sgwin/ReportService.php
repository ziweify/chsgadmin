<?php

namespace App\ort\sgwin;

use App\Models\Game\Baototal;
use App\Models\Game\LibModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportService
{
    //整理日报表
    public static function zhengli_day_reportdanqi($ruid = 0,$tb = '',$gid = 0,$qishu = 0,$userid = 0, $type = 0){
        if (empty($tb)) {
            $tb = SGUtils::getcuretable(true);
        }
        //锁标记
        $tbarr = explode('_', $tb);
        //将20231201转成2023-12-01
        $dates = substr($tbarr[2], 0, 4) . '-' . substr($tbarr[2], 4, 2) . '-' . substr($tbarr[2], 6, 2);
        $db = Db::connection();
        $gstr = " a.ruid = {$ruid} ";
        if ($userid > 0) {
            $gstr .= " and a.userid = {$userid} ";
        }
        if ($gid > 0) {
            $gstr .= " and a.gid = {$gid} ";
        }
        if ($qishu > 0) {
            $gstr .= " and a.qishu = {$qishu} ";
        }
        $sql = "select ";
        $fields = '';
        //会员数据字段
        $fields .= "count(a.id) as count";//下注笔数
        $fields .= ",sum(je) as bet_amount";//投注金额
        $fields .= ",sum(if(z in (0,1),je,0)) as valid_amount";//有效金额
        $fields .= ",0 as points";//会员退水
        $fields .= ",sum(if(z=1,peilv1*je*zcount*100,0)) as prize_amount";//会员中奖金额
        $fields .= ",sum(je*uzp*100) as tax_amount";//会员赚点
        $sql .= $fields;
        $sql .= ",a.gid,a.dftype,b.userid from {$tb} as a INNER JOIN x_user as b ON a.userid=b.userid where $gstr and z between 0 and 2 group by b.userid,a.gid,dftype";
        $data = $db->select($sql);
        foreach ($data as $d) {
            if ($type == 1) {
                //删除原有数据
                Baototal::where(['userid' => $d['userid'], 'gid' => $d['gid'], 'dftype' => $d['dftype'], 'dates' => strtotime($dates)])->delete();
            }
            //开启事务
            $db->beginTransaction();
            try {
                //判断是否存在该日期数据，如果存在则更新，不存在则插入
                $old = Baototal::where(['ruid' => $ruid,'userid'=>$d['userid'],'gid'=>$d['gid'],'dftype'=>$d['dftype'],'dates' => strtotime($dates)])->lockForUpdate()->first();
                if ($old) {
                    $old['count'] = $old['count'] + $d['count'];
                    $old['bet_amount'] = $old['bet_amount'] + $d['bet_amount'];
                    $old['valid_amount'] = $old['valid_amount'] + $d['valid_amount'];
                    $old['points'] = $old['points'] + $d['points'];
                    $old['prize_amount'] = $old['prize_amount'] + $d['prize_amount'];
                    $old['tax_amount'] = $old['tax_amount'] + $d['tax_amount'];
                    $old->save();
                } else {
                    $baotatal = [];
                    $baotatal['ruid'] = $ruid;
                    $baotatal['userid'] = $d['userid'];
                    $baotatal['gid'] = $d['gid'];
                    $baotatal['dftype'] = $d['dftype'];
                    $baotatal['dates'] = strtotime($dates);
                    $baotatal['count'] = $d['count'];
                    $baotatal['bet_amount'] = $d['bet_amount'];
                    $baotatal['valid_amount'] = $d['valid_amount'];
                    $baotatal['points'] = $d['points'];
                    $baotatal['prize_amount'] = $d['prize_amount'];
                    $baotatal['tax_amount'] = $d['tax_amount'];
                    Baototal::create($baotatal);
                }
                $db->commit();
            } catch (\Exception $e) {
                $db->rollBack();
                Log::info("单期报表整理失败{$ruid},{$tb},{$gid},{$qishu},{$userid},{$type}". $e->getMessage());
            }
        }
    }


    public static function zhengli_day_report($tb = '', $gid = 0, $userid = 0, $js = 0){
        if (empty($tb)) {
            $tb = SGUtils::getcuretable(true);
        }
        $tbarr = explode('_', $tb);
        //将20231201转成2023-12-01
        $dates = substr($tbarr[2], 0, 4) . '-' . substr($tbarr[2], 4, 2) . '-' . substr($tbarr[2], 6, 2);
        $db = Db::connection();
        $libmodel = new LibModel();
        $libmodel->setTable($tb);
        $gstr = '';
        if ($userid > 0) {
            $gstr .= " a.userid = {$userid} and";
        }
        if ($gid > 0) {
            $gstr .= " a.gid = {$gid} and";
        }
        $sql = "select ";
        $fields = '';
        //会员数据字段
        $fields .= "count(a.id) as count";//下注笔数
        $fields .= ",sum(je) as bet_amount";//投注金额
        $fields .= ",sum(if(z in (0,1),je,0)) as valid_amount";//有效金额
        $fields .= ",0 as points";//会员退水
        $fields .= ",sum(if(z=1,peilv1*je*zcount*100,0)) as prize_amount";//会员中奖金额
        $fields .= ",sum(je*uzp*100) as tax_amount";//会员赚点
        $sql .= $fields;
        $sql .= ",a.gid,a.dftype,b.userid,a.ruid from {$tb} as a INNER JOIN x_user as b ON a.userid=b.userid where $gstr z between 0 and 2 group by b.userid,a.gid,a.dftype,a.ruid";
        $data = $db->select($sql);
        foreach ($data as $d) {
            $baotatal = [];
            $baotatal['ruid'] = $d['ruid'];
            $baotatal['userid'] = $d['userid'];
            $baotatal['gid'] = $d['gid'];
            $baotatal['dftype'] = $d['dftype'];
            $baotatal['count'] = $d['count'];
            $baotatal['bet_amount'] = $d['bet_amount'];
            $baotatal['valid_amount'] = $d['valid_amount'];
            $baotatal['points'] = $d['points'];
            $baotatal['prize_amount'] = $d['prize_amount'];
            $baotatal['tax_amount'] = $d['tax_amount'];
            $baotatal['dates'] = strtotime($dates);
            $db->beginTransaction();
            try {
                Baototal::where(['ruid' => $d['ruid'], 'userid' => $d['userid'], 'gid' => $d['gid'], 'dftype' => $d['dftype'], 'dates' => strtotime($dates)])->lockForUpdate()->first();
                Baototal::where(['ruid' => $d['ruid'], 'userid' => $d['userid'], 'gid' => $d['gid'], 'dftype' => $d['dftype'], 'dates' => strtotime($dates)])->delete();
                Baototal::create($baotatal);
                $db->commit();
            }catch (\Exception $e) {
                $db->rollBack();
                throw $e;
            }
        }
    }
}
