<?php


namespace App\ort\common;

use App\Models\Game\Mclass;
use App\Models\Game\User;
use App\Models\Game\UserEdit;
use App\ort\glob\IpUtils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ComFunc
{

    public static function getjrsy($userid){
        $db = Db::connection();
        //$table = SGUtils::getcuretable(true);
        if ($userid == 99999999) {
            $layer = 0;
            //新报表统计方式查询日报表x_baototal
            $theday = self::getthisdate();
            $theday = strtotime($theday);
            $rs = $db->select("select sum(zcje{$layer}) as zc,sum(zcpo{$layer}/100/100) as shui,sum(zctax{$layer}/100) as metax,sum(zcprizeup{$layer}/100) as zhong from x_baototal where dates='$theday'");
            $mezc = $rs[0]['zc'] ?? 0;
            $meshui = $rs[0]['shui'] ?? 0;
            $metax = $rs[0]['metax'] ?? 0;
            $mezhong = $rs[0]['zhong'] ?? 0;
            $yk = self::pr1($mezc - $mezhong - $meshui+$metax);
        } else {
            $layer = User::transuser($userid, 'layer');

            //新报表统计方式查询日报表x_baototal
            $theday = self::getthisdate();
            $theday = strtotime($theday);
            $rs = $db->select("select sum(zcje{$layer}) as zc,sum(zcpo{$layer}/100/100) as shui,sum(zctax{$layer}/100) as metax,sum(zcprizeup{$layer}/100) as zhong,sum(pointszc{$layer}/100/100) as ushui,sum(points{$layer}/100/100) as sendshui from x_baototal where dates='$theday' and uid{$layer}='$userid'");
            $mezc = $rs[0]['zc'] ?? 0;
            $meshui = $rs[0]['shui'] ?? 0;
            $metax = $rs[0]['metax'] ?? 0;
            $mezhong = $rs[0]['zhong'] ?? 0;
            $shui = $rs[0]['ushui'] ?? 0;
            $sendshui = $rs[0]['sendshui'] ?? 0;
            $zshui = self::pr4($meshui + $sendshui- $shui);
            //补货
            $rs = $db->select("select sum(bet_amount) as zje,sum(points/100/100) as points,sum(prize_amount/100) as yk from x_baototal where dates='$theday' and userid='$userid'");
            $bhzje = $rs[0]['zje'] ?? 0;
            $bhpoints = $rs[0]['points'] ?? 0;
            $bbyk = $rs[0]['yk'] ?? 0;
            $byk = self::pr4($bhpoints + $bbyk - $bhzje);
            $yk = self::pr1($mezc - $mezhong - $meshui + $byk + $metax + $zshui);
        }
        return $yk;
    }

    public static function getthisdate()
    {
        $his = date("His");
        if ($his < str_replace(':', '', x_config('editstart'))) {
            $date = date("Y-m-d", time() - 86400);
        } else {
            $date = date("Y-m-d");
        }
        return $date;
    }

    public static function getthisdateend(){
        $his = date("His");
        if ($his < str_replace(':', '', x_config('editend'))) {
            $date = date("Y-m-d", time() - 86400);
        } else {
            $date = date("Y-m-d");
        }
        return $date;
    }


    public static function bjs($v1, $v2)
    {
        if (!is_numeric($v1) || $v1 > $v2) return $v2;
        else return $v1;
    }

    public static function p2($v)
    {
        return round($v, 2);
    }

    public static function p3($v)
    {
        return round($v, 3);
    }

    public static function pr2($v,$ist = 0){
        if (empty($v)){
            if($ist == 1){
                return number_format($v, 2, '.', '');
            }else{
                return 0;
            }
        }else{
            return round($v, 2);
        }
    }

    public static function pr3($v)
    {
        if (empty($v))
            return 0;
        else
            return round($v, 3);
    }

    public static function low($v){
        return strtolower($v);
    }

    public static function transu($uid,$flag = 1){
        if ($uid == 99999999)
            return "公司";
        if ($uid == 0)
            return "无";
        $user = User::where('userid',$uid)->select(['username','name','layer','ifagent'])->first();
        if (empty($user))return '';
        if ($user['ifagent'] == 0)
            return $user['username'] . '(会员)';
        if($flag == 1){
            $layer = x_config('layer');
            $layer = json_decode($layer, true);
            return $user['username'] . '(' . $layer[$user['layer'] - 1] . ')';
        }else{
            return $user['username'];
        }
    }

    public static function transstatus($v){
        if ($v == 0) {
            $v = '启用';
        } else if ($v == 1) {
            $v = '冻结';
        } else {
            $v = '停用';
        }
        return $v;
    }

    public static function pr4($v){
        if (empty($v))
            return 0;
        else
            return round($v, 4);
    }

    public static function pr1($v){
        if (empty($v))
            return 0;
        else
            return round($v, 1);
    }

    //保留小数方法
    public static function pr($v,$num){
        return number_format($v,$num);
    }

    public static function pr0($v){
        if (empty($v))
            return 0;
        else
            return round($v, 0);
    }

    public static function up($v){
        return strtoupper($v);
    }

    /**
     * 添加单个操作日志
     * @param $param
     * @return true
     */
    public static function adduseredit($param){
        if (!isset($param['ip'])) $modiip = request()->getClientIp();
        else $modiip = $param['ip'];
        $save = [];
        $save['modiip'] = $modiip;
        $save['moditime'] = time();
        $save['action'] = $param['action'];
        $save['userid'] = $param['userid'];
        $save['ruid'] = isset($param['ruid']) ? $param['ruid'] : 0;
        $save['addr'] = IpUtils::getaddrbyip($modiip);
        $save['title'] = !isset($param['title']) ? '会员资料' : $param['title'];
        $save['oldvalue'] = !isset($param['old']) ? '' : $param['old'];
        $save['newvalue'] = !isset($param['new']) ? '' : $param['new'];
        $save['other'] = !isset($param['other']) ? '' : $param['other'];
        $save['moduleKey'] = !isset($param['moduleKey']) ? '' : $param['moduleKey'];
        $save['functionKey'] = !isset($param['functionKey']) ? '' : $param['functionKey'];
        $save['actionKey'] = !isset($param['actionKey']) ? '' : $param['actionKey'];
        $save['lottery'] = !isset($param['lottery']) ? '' : $param['lottery'];
        if ($param['mduserid'] == Constants::$SUID) {
            $save['modiuser'] = $param['mduserid'];
            $save['modisonuser'] = isset($param['adminid']) ? $param['adminid'] : 0;
            if(empty($save['modisonuser'])){
                $save['modisonuser'] = isset($param['sonuid']) ?$param['sonuid'] : 0;
            }
        } else {
            if (!isset($param['sonuid']) || ($param['mduserid'] == $param['sonuid'])) $param['sonuid'] = 0;
            $save['modiuser'] = $param['mduserid'];
            $save['modisonuser'] = $param['sonuid'];
        }
        UserEdit::create($save);
        return true;
    }

    /**
     * 批量添加操作日志
     * @param $logs
     * @return void
     */
    public static function addbatchuseredit($logs){
        $saves = [];
        foreach ($logs as $param){
            if (!isset($param['ip'])) $modiip = request()->getClientIp();
            else $modiip = $param['ip'];
            $save = [];
            $save['modiip'] = $modiip;
            $save['moditime'] = time();
            $save['action'] = $param['action'];
            $save['userid'] = $param['userid'];
            $save['addr'] = IpUtils::getaddrbyip($modiip);
            $save['title'] = !isset($param['title']) ? '会员资料' : $param['title'];
            $save['oldvalue'] = !isset($param['old']) ? '' : $param['old'];
            $save['newvalue'] = !isset($param['new']) ? '' : $param['new'];
            $save['other'] = !isset($param['other']) ? '' : $param['other'];
            $save['moduleKey'] = !isset($param['moduleKey']) ? '' : $param['moduleKey'];
            $save['functionKey'] = !isset($param['functionKey']) ? '' : $param['functionKey'];
            $save['actionKey'] = !isset($param['actionKey']) ? '' : $param['actionKey'];
            if ($param['mduserid'] == Constants::$SUID) {
                $save['modiuser'] = $param['mduserid'];
                $save['modisonuser'] = isset($param['adminid']) ? $param['adminid'] : 0;
            } else {
                if (!isset($param['sonuid']) || ($param['mduserid'] == $param['sonuid'])) $param['sonuid'] = 0;
                $save['modiuser'] = $param['mduserid'];
                $save['modisonuser'] = $param['sonuid'];
            }
            $saves[] = $save;
        }
        //批量插入
        UserEdit::insert($saves);
    }


    public static function rpage($p){
        if (!is_numeric($p) | $p < 0 | $p%1!=0) $p=1;
        return $p;
    }

    public static function rdates($v){
        if (!preg_match("/\d{4}-1[0-2]|0?[1-9]-0?[1-9]|[12][0-9]|3[01]/", $v)) {
            $v = date("Y-m-d");
        }
        return $v;
    }

    public static function transxtype($val){
        if ($val == 0) {
            $val = "下注";
        } else if ($val == 1) {
            $val = "内补";
        } else if ($val == 2) {
            $val = "外补";
        }
        return $val;
    }

    public static function getzlong($fenlei,$gid,$mode=1){
        $z = array();
        $db = Db::connection();
        if ($fenlei == 161 || $fenlei == 162) {
            $play_list = $db->select("select name,bid,sid,cid,zqishu,cy,pid from x_play where gid='{$gid}' and zqishu>=2 order by zqishu desc,bid,sid,cid,xsort");
        } else {
            $play_list = $db->select("select name,bid,sid,cid,zqishu,cy,pid from x_play where gid='{$gid}' and zqishu>=2 and name in('单','双','大','小','龙','虎','冠亚单','冠亚双','冠亚大','冠亚小','总和单','总和双','总和大','总和小','合数单','合数双','尾大','尾小','总和尾大','总和尾小','牛大','牛小','牛单','牛双') order by zqishu desc,bid,sid,cid,xsort");
        }
        $i = 0;
        $tmp = array();
        foreach ($play_list as $item) {
            $pname = $item['name'];
            if (!isset($tmp['b' . $item['bid']])) {
                $tmp['b' . $item['bid']] = CsFunc::transb($gid,'name', $item['bid']);
            }
            if (!isset($tmp['s' . $item['sid']])) {
                $tmp['s' . $item['sid']] = CsFunc::transs($gid,'name', $item['sid']);
            }
            if (!isset($tmp['c' . $item['cid']])) {
                $class = Mclass::where(['gid' => $gid, 'cid' => $item['cid']])->select(['name','cs'])->first();
                $tmp['c' . $item['cid']] = $class['name'];
                $tmp['c' . $item['cid'] . 'cs'] = $class['cs'];
            }
            if($mode == 1){
                $z[$i]['pname'] = $pname;
                $z[$i]['bname'] = $tmp['b' . $item['bid']];
                $z[$i]['cname'] = $tmp['c' . $item['cid']];
                $z[$i]['sname'] = $tmp['s' . $item['sid']];
                $z[$i]['cy'] = $item['cy'];
                $z[$i]['cs'] = $tmp['c' . $item['cid'] . 'cs'];
                $z[$i]['name'] = self::wf3($fenlei, $z[$i]['bname'], $z[$i]['cname'],$z[$i]['sname'], $z[$i]['pname']);
                $z[$i]['qishu'] = $item['zqishu'];
            }elseif($mode == 5){
                $z[$i]['pname'] = $pname;
                $z[$i]['bname'] = $tmp['b' . $item['bid']];
                $z[$i]['cname'] = $tmp['c' . $item['cid']];
                $z[$i]['sname'] = $tmp['s' . $item['sid']];
                $z[$i]['name'] = self::wf3($fenlei, $z[$i]['bname'], $z[$i]['cname'],$z[$i]['sname'], $z[$i]['pname']);
                $z[$i]['cy'] = $item['cy'];
                $z[$i]['cs'] = $tmp['c' . $item['cid'] . 'cs'];
                $z[$i]['qishu'] = $item['zqishu'];
                $z[$i]['bid'] = $item['bid'];
                $z[$i]['sid'] = $item['sid'];
                $z[$i]['cid'] = $item['cid'];
                $z[$i]['pid'] = $item['pid'];
                //$z[$i]['fcy'] = self::fcy($fenlei);
            }else{
                $bname = $tmp['b' . $item['bid']];
                $cname = $tmp['c' . $item['cid']];
                $sname = $tmp['s' . $item['sid']];
                $z[$i]['key'] = $item['cy'];
                $z[$i]['title'] = self::wf3($fenlei, $bname, $cname,$sname, $pname);
                $z[$i]['value'] = $item['zqishu'];
            }
            $i++;
        }
        return $z;
    }

    public static function wf2($g, $b, $s, $c){
        $p = '';
        if($b=="番摊"){
            return $c;
        }else if ($g == 100 || $g == 200) {
            if ($s == '過關')
                return $b;
            else
                return $s ;
        } else if (($g == 101 | $g==163) && $s!='番摊') {
            switch ($b) {
                case "1~5":
                case "1~3":
                    return $s ;
                    break;
                case "1字组合":
                    return $c ;
                    break;
                case "2字和数":
                    return $s ;
                    break;
                case "2字组合":
                    return $p;
                    break;
                case "2字定位":
                    return $p;
                    break;
                case "3字组合":
                    return $p;
                    break;
                case "3字定位":
                    return $p;
                    break;
                case "3字和数":
                    if ($c == '尾数')
                        return $s . '-' . $c ;
                    else
                        return $s ;
                    break;
                case "总和龙虎":
                    if ($c == '总和尾数' | $c == '总和数')
                        return $s . '-' . $c ;
                    else
                        return $s ;
                    break;
                case "牛牛梭哈":
                    return $c;
                    break;
                case "跨度":
                    return $c ;
                    break;
                case "前中后三":
                case "前三":
                    return $s . '-' . $c ;
                    break;
            }
        } else {
            return $b ;
        }
    }

    public static function wf3($fenlei, $bname,$cname,$sname,$pname){
        $str = '';
        if($fenlei == 107){
            if($bname == '冠亚军组合'){
                $pname = str_replace('冠亚','',$pname);
                $str = '冠亚-'.$pname;
            }else{
                $str = $sname.'-'.$pname;
            }
        }elseif ($fenlei == 101){
            if($cname == '总和大小' || $cname == '总和单双'){
                $str = '总和'.'-'.str_replace('总和','',$pname);
            }elseif($cname == '龙虎和'){
                $str = '第一球'.'-'.$pname;
            }elseif ($cname == '牛牛大小' || $cname == '牛牛单双'){
                $str = '斗牛两面-'.$pname;
            }else{
                $str = $sname.'-'.$pname;
            }
        }elseif ($fenlei == 121){
            if($sname == '总和龙虎'){
                $str = $pname;
            }else{
                $str = $sname.'-'.$pname;
            }
        }elseif($fenlei == 103){
            if($sname == '总和龙虎'){
                $str = $pname;
            }else{
                $str = $sname.'-'.$pname;
            }
        }elseif($fenlei == 161){
            $str = $pname;
        }else{
            $str = $sname.'-'.$pname;
        }
        return $str;
    }

    public static function getbuzlong($fenlei,$gid)
    {
        $buz = array();
        $db = Db::connection();
        if ($gid == 161 | $gid == 162) {
            $play_list = $db->query("select * from x_play where gid='{$gid}' and buzqishu>=2 and cid in (select cid from x_class where gid='{$gid}' and ftype not in (1,2))  order by buzqishu desc,bid,sid,cid,xsort");
        } else {
            $play_list = $db->query("select * from x_play where gid='{$gid}' and buzqishu>=2 and cid in (select cid from x_class where gid='{$gid}' and ftype=0)   and name not in('质','合','总尾质','总尾合','和尾质','和尾合') order by buzqishu desc,bid,sid,cid,xsort");
        }
        $i = 0;
        $tmp = array();
        foreach ($play_list as $item) {
            $pname = $item['name'];
            if (!isset($tmp['b' . $item['bid']])) {
                $tmp['b' . $item['bid']] = CsFunc::transb($gid,'name', $item['bid']);
            }
            if (!isset($tmp['s' . $item['sid']])) {
                $tmp['s' . $item['sid']] = CsFunc::transs($gid,'name', $item['sid']);
            }
            if (!isset($tmp['c' . $item['cid']])) {
                $tmp['c' . $item['cid']] = CsFunc::transc($gid,'name', $item['cid']);
            }
            $buz[$i]['name'] = self::wf2($fenlei, $tmp['b' . $item['bid']], $tmp['s' . $item['sid']], $tmp['c' . $item['cid']]);
            $buz[$i]['pname'] = $pname;
            $buz[$i]['bname'] = $tmp['b' . $item['bid']];
            $buz[$i]['qishu'] = $item['buzqishu'];
            $i++;
        }
        return $buz;
    }

    public static function wfuser($g, $b, $s, $c, $p){
        $p = "".$p."";
        if($b=="番摊"){
            return $c . ' ' . $p;
        }else if ($g == 100 || $g == 200) {
            if ($s == '過關'){
                return $p;
            }else if($b=='生肖連' || $b=='尾數連'){
                return  $p;
            }
            else{
                return $s . ' ' . $p;
            }
        }elseif($g == 121){
            if($b == '总和龙虎'){
                return $p;
            }else{
                return $s . ' ' . $p;
            }
        }elseif($g == 103){
            if($b == '总和龙虎'){
                return $p;
            }else{
                return $s . ' ' . $p;
            }
        }elseif($g == 161){
            return $p;
        } else if (($g == 101 | $g==163) && $s!='番摊') {
            switch ($b) {
                case "1~5":
                case "1~3":
                    return $s . ' ' . $p;
                    break;
                case "1字组合":
                    return $c . ' ' . $p;
                    break;
                case "2字组合":
                    return $c;
                    break;
                case "2字定位":
                    return $p;
                    break;
                case "2字和数":
                    //如果$c包含尾数
                    if (strpos($c, '尾数') !== false) {
                        $s = str_replace('和数', '尾数', $s);
                    }
                    return $s . ' ' . $p;
                    break;
                case "3字组合":
                    return $c;
                    break;
                case "3字定位":
                    return $p;
                    break;
                case "3字和数":
                    if ($c == '尾数')
                        return $s . ' ' . $c . ' ' . $p;
                    else
                        return $s . ' ' . $p;
                    break;
                case "总和龙虎":
                    if ($c == '总和尾数' | $c == '总和数')
                        return $s . ' ' . $c . ' ' . $p;
                    else
                        return $c . ' ' . $p;
                    break;
                case "组选3":
                    return $p;
                    break;
                case "组选6":
                    return $p;
                    break;
                case "斗牛":
                    if($c == '牛牛大小'){
                        return '斗牛大小' . ' ' . $p;
                    }elseif ($c == '牛牛单双'){
                        return '斗牛单双' . ' ' . $p;
                    }else{
                        return $b . ' ' . $p;
                    }
                    break;
                case "牛牛梭哈":
                case "斗牛梭哈":
                    return $s. ' ' . $p;
                    break;
                case "跨度":
                    $cc = $s.$c;
                    $cc = str_replace('-', ' ', $cc);
                    return $cc;
                    break;
                case "前中后三":
                case "前三":
                    return $s . ' ' . $p ;
                    break;
            }
        } else {
            if($s=='冠亚和'){
                if($c == '和大小') {
                    return '冠亚和大小 '.$p;
                }elseif($c == '和单双') {
                    return '冠亚和单双 '.$p;
                }else{
                    return $s . ' ' . $p;
                }
            }else{
                return $b . ' ' . $p;
            }

        }
    }

    public static function getNewOrderId(string $prefix = '')
    {
        $snowflake = new \Godruoyi\Snowflake\Snowflake();
        $is_callable = function ($currentTime) {
            $redis = Redis::connection('default')->client();
            $swooleSequenceResolver = new \Godruoyi\Snowflake\RedisSequenceResolver($redis);
            return $swooleSequenceResolver->sequence($currentTime);
        };
        //32位
        if (PHP_INT_SIZE == 4) {
            $id = abs($snowflake->setSequenceResolver($is_callable)->id());
        } else {
            $id = $snowflake->setStartTimeStamp(strtotime('2020-06-05') * 1000)->setSequenceResolver($is_callable)->id();
        }
        return $prefix . $id;
    }
    public static function rweek($v){
        switch ($v) {
            case 1:
                $v = '一';
                break;
            case 2:
                $v = '二';
                break;
            case 3:
                $v = '三';
                break;
            case 4:
                $v = '四';
                break;
            case 5:
                $v = '五';
                break;
            case 6:
                $v = '六';
                break;
            default:
                $v = '日';
                break;
        }
        return $v;
    }

    public static function r1($v){
        if ($v == '')
            return 1;
        else
            return $v;
    }

    public static function wf($g, $b, $s, $c, $p){
        $p = "『".$p."』";
        if($b=="番摊"){
            return $c . '-' . $p;
        }else if ($g == 100 || $g == 200) {
            if ($s == '過關'){
                return $p;
            }else if($b=='生肖連' || $b=='尾數連'){
                return  $p;
            }else{
                return $s . '-' . $p;
            }
        } else if (($g == 101 | $g==163) && $s!='番摊') {
            switch ($b) {
                case "1~5":
                case "1~3":
                    return $s . '-' . $p;
                    break;
                case "1字组合":
                    return $c . '-' . $p;
                    break;
                case "2字组合":
                    return $p;
                    break;
                case "2字定位":
                    return $p;
                    break;
                case "2字和数":
                    return $s . '-' . $p;
                    break;
                case "3字组合":
                    return $p;
                    break;
                case "3字定位":
                    return $p;
                    break;
                case "3字和数":
                    if ($c == '尾数')
                        return $s . '-' . $c . '-' . $p;
                    else
                        return $s . '-' . $p;
                    break;
                case "总和龙虎":
                    if ($c == '总和尾数' | $c == '总和数')
                        return $s . '-' . $c . '-' . $p;
                    else
                        return $s . '-' . $p;
                    break;
                case "组选3":
                    return $p;
                    break;
                case "组选6":
                    return $p;
                    break;
                case "牛牛梭哈":
                    return $c;
                    break;
                case "跨度":
                    return $c . '-' . $p;
                    break;
                case "前中后三":
                case "前三":
                    return $s . '-' . $p ;
                    break;
            }
        } else {
            return $b . '-' . $p;
        }
    }

    public static function isnum($v){
        if (!is_numeric($v) || $v == '' || $v%1!=0)
            return 0;
        return $v;
    }


    public static function getdatearr($v1,$v2,$thisday,$tb){
        $arr=[];
        $start= strtotime($v1);
        if(strpos($tb,str_replace('-', '', $v1))!==false || $v1==$thisday){
            $arr[] = $v1;
        }
        while(1){
            if(date("Y-m-d",$start)>=$thisday){
                break;
            }
            if(date("Y-m-d",$start)>=$v2){
                break;
            }
            $start += 86400;
            $d = date("Y-m-d",$start);
            if(strpos($tb,str_replace('-', '', $d))!==false || $d==$thisday){
                $arr[] = $d;
            }
        }
        return $arr;
    }

    public static function Rand_IP(){
        $ip2id = round(rand(600000, 2550000) / 10000);
        $ip3id = round(rand(600000, 2550000) / 10000);
        $ip4id = round(rand(600000, 2550000) / 10000);
        $arr_1 = array("218", "218", "66", "66", "218", "218", "60", "60", "202", "204", "66", "66", "66", "59", "61", "60", "222", "221", "66", "59", "60", "60", "66", "218", "218", "62", "63", "64", "66", "66", "122", "211");
        $randarr = mt_rand(0, count($arr_1) - 1);
        $ip1id = $arr_1[$randarr];
        return $ip1id . "." . $ip2id . "." . $ip3id . "." . $ip4id;
    }

    public static function CURL($arr = ["cookietype" => false, "cookie_jar" => "", "url" => "", "posttype" => false, "postdata" => [], "head" => true, "location" => true, "refer" => "", "headip" => "127.0.0.1", "sslhostflag" => true, "json" => false])
    {
        //print($arr);
        $url = str_replace('://', '---', $arr["url"]);
        $url = str_replace('//', '/', $url);
        $url = str_replace('---', '://', $url);
        //echo $url;
        $SSL = substr($url, 0, 8) == "https://" ? true : false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($SSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        if ($arr["head"]) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($arr["refer"] != "") {
            //echo $arr["refer"];
            curl_setopt($ch, CURLOPT_REFERER, $arr["refer"]);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36');

        //curl_setopt($ch, CURL_XML, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($arr["location"]) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $arr["location"]);
        }
        if ($arr["cookietype"]) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $arr["cookie_jar"]);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $arr["cookie_jar"]);
        }
        //$headers = ['CLIENT-IP:' . $arr["headip"], 'X-FORWARDED-FOR:' . $arr["headip"]];
        $headers = [];
        if ($arr["posttype"]) {
            if ($arr["json"]) {
                $postdata = "";
                is_array($arr["postdata"]) && $postdata = json_encode($arr["postdata"]);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                $headers[] = 'Content-Type: application/json; charset=utf-8';
                $headers[] = 'Content-Length: ' . strlen($postdata);
            } else {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arr["postdata"]));
            }
        }
        //echo json_encode($headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        if (curl_error($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return ['res' => $result, 'location' => $info, "arr" => $arr];
    }

    const YL8URLS = ['https://api.api68.com/'];
    public static function get168url(){
        return self::YL8URLS[random_int(0,count(self::YL8URLS)-1)];
    }

    public static function ismobie(){
        $request = request();
        if ($request->server('HTTP_VIA') && stristr($request->server('HTTP_VIA'), "wap")) {
            return true;
        } elseif ($request->server('HTTP_ACCEPT') && strpos(strtoupper($request->server('HTTP_ACCEPT')), "VND.WAP.WML")) {
            return true;
        } elseif ($request->server('HTTP_X_WAP_PROFILE') || $request->server('HTTP_PROFILE')) {
            return true;
        } elseif ($request->server('HTTP_USER_AGENT') && preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $request->server('HTTP_USER_AGENT'))) {
            return true;
        }
        return false;
    }
}
