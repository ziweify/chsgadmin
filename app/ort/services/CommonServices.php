<?php

namespace App\ort\services;

use App\Common\Queue\CommonQueue;
use App\Models\Game\Game;
use App\Models\Game\Lib;
use App\Models\Game\OutbetAccs;
use App\Models\Game\OutbetError;
use App\Models\Game\OutbetSite;
use App\Models\Game\Points;
use App\Models\Game\Pointsback;
use App\Models\Game\TaxTemplateItem;
use App\Models\Game\User;
use App\Models\Game\Userpatt;
use App\Models\Game\WaterTemplateItem;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\common\CsFunc;
use App\ort\sgwin\Json;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommonServices
{
    public function updatetaxtemplateitem($userid,$layer,$tid){
        $db = Db::connection();
        $uids = User::where(['fid'.$layer=>$userid,'ifagent'=>0,'ifson'=>0])->pluck('userid')->toArray();
        $tax_tempate_items = TaxTemplateItem::whereIn('userid',$uids)->select(['userid'])->get();
        foreach ($tax_tempate_items as $tax){
            $uid = $tax['userid'];
            //先删除
            $db->table('tax_template_item')->where(['userid'=>$uid,'template_id'=>$tid])->delete();
            $sql = "INSERT INTO x_tax_template_item SELECT NULL,$tid,$uid,gid,dftype,tax,2,$userid FROM x_tax_template_item WHERE userid=$userid and template_id=$tid";
            $db->insert($sql);
        }
    }

    public function updatewatertemplateitem($userid,$layer,$tid){
        $db = Db::connection();
        $uids = User::where(['fid'.$layer=>$userid,'ifagent'=>0,'ifson'=>0])->pluck('userid')->toArray();
        $water_tempate_items = WaterTemplateItem::whereIn('userid',$uids)->select(['userid'])->get();
        foreach ($water_tempate_items as $water){
            $uid = $water['userid'];
            //先删除
            $db->table('water_template_item')->where(['userid'=>$uid,'template_id'=>$tid])->delete();
            $sql = "INSERT INTO x_water_template_item SELECT NULL,$tid,$uid,gid,dftype,water,2,$userid FROM x_water_template_item WHERE userid=$userid and template_id=$tid";
            $db->insert($sql);
        }
    }

    public function parampoint($userid,$ruid){
        $user = User::where(['userid'=>$userid,'ruid'=>$ruid])->first();
        $lotterys = Game::whereIn('gid', function ($query) use ($ruid) {
            $query->select('gid')->from('userpatt')->where(['userid'=>$ruid,'ifopen'=>1]);
        })->select(['gname','lottery','template','point','gid'])->orderBy('xsort')->get()->toArray();
        foreach ($lotterys as &$game){
            $fpoint = Userpatt::where(['userid'=>$ruid,'gid'=>$game['gid']])->value('point');
            $game['fpoint'] = $fpoint;
            $game['point'] = Points::where(['userid'=>$userid,'gid'=>$game['gid']])->value('point');
        }
        view()->share('layername','房主');
        view()->share('username',$user['username']);
        view()->share('userid',$userid);
        view()->share('ruid',$ruid);
        view()->share('name',$user['name']);
        view()->share("lotterys", $lotterys);
    }

    public function savepoints($userid,$ruid,$params,$downLine,$mduserid,$sonuid){
        $logs = [];$db = Db::connection();
        $user = User::where(['userid'=>$userid,'ruid'=>$ruid])->first();
        if(empty($user)){
            return ['code'=>0,'msg'=>'用户不存在'];
        }
        $params = json_decode($params,true);
        $ustr = 'fid'.$user['layer'];
        foreach ($params as $v){
            $gid = $v['gid'];
            $point = $v['p'];
            if(!is_numeric($point)){
                continue;
            }
            $game = Game::where('gid',$gid)->select(['gname'])->first();
            $log = ['userid'=>$userid,'mduserid'=>$mduserid,'action'=>"{$game['gname']} 【退水】",'moduleKey'=>'user','functionKey'=>'individualuserparam','actionKey'=>'update'];
            if($mduserid == Constants::$SUID){
                $log['adminid'] = $sonuid;
            }else{
                $log['sonuid'] = $sonuid;
            }
            $fpoint = Points::where(['userid'=>$ruid,'gid'=>$gid])->value('point');
            $mypoint = Points::where(['userid'=>$userid,'gid'=>$gid])->value('point');
            $mypoint = empty($mypoint) ? 0 : $mypoint;
            if($user['exc_point'] == 1){
                if($point > $fpoint){
                    $point = $mypoint;
                }
            }
            if($mypoint != $point){
                Points::where(['userid'=>$userid,'gid'=>$gid])->update(['point'=>$point]);
                $log['old'] = $mypoint;
                $log['new'] = $point;
            }
            if ($user['ifagent'] == 1) {
                $chapoint = $point-$mypoint;
                if ($downLine == 'agent' || $downLine == 'member') {
                    $agentstr = "and Y.ifagent=1";
                    if($downLine == 'member'){
                        $agentstr = "";
                    }
                    $sql2 = "update x_points X,x_user Y set ";
                    $sqls = " where X.userid=Y.userid and Y.$ustr='$userid' and X.gid='$gid' $agentstr";
                    $sql2 .= "X.point=if((X.point+$chapoint})>0,(X.point+{$chapoint}),0)";
                    $db->update($sql2.$sqls);
                }else{
                    $sqls = " where X.userid=Y.userid and Y.$ustr='$userid' and X.gid='$gid'";
                    $sql2 = "update x_points X,x_user Y set ";
                    $sql2 .= "X.point=if((X.point+{$chapoint})>0,(X.point+{$chapoint}),0)";
                    $db->update($sql2.$sqls);
                }
            }
            $logs[] = $log;
        }
        if(!empty($logs)){
            ComFunc::addbatchuseredit($logs);
        }
        return ['code'=>1,'msg'=>'保存成功'];
    }

    public function tbmemberpointsv1($ustr,$uid,$cs,$gid,$v,$tb,$layer){
        $db = Db::connection();
        $agentuids = User::where([$ustr=>$uid,'ifagent'=>1])->select(['userid','layer'])->get()->toArray();
        //向数组添加元素
        array_unshift($agentuids,['userid'=>$uid,'layer'=>$layer]);
        foreach ($agentuids as $vo) {
            $sqls = " where X.userid=Y.userid and Y.fid{$vo['layer']}='{$vo['userid']}' and X.class='$cs' and X.gid='$gid'";
            $sql1 = "update $tb X,x_user Y set ";
            $ffpoint = Points::where(['gid'=>$gid,'class'=>$cs,'userid'=>$vo['userid']])->first();
            if(isset($v['maxAmount'])){
                $sql1 .= "X.maxje=if(X.maxje>{$ffpoint['maxje']},{$ffpoint['maxje']},X.maxje),";
            }
            if(isset($v['maxPeriod'])){
                $sql1 .= "X.cmaxje=if(X.cmaxje>{$ffpoint['cmaxje']},{$ffpoint['cmaxje']},X.cmaxje),";
            }
            $sql1 = rtrim($sql1,',');
            $db->update($sql1 . $sqls);
        }
    }

    public function tbmemberpoints($ustr,$uid,$cs,$gid,$v,$tb,$layer){
        $db = Db::connection();
        $agentuids = User::where([$ustr=>$uid,'ifagent'=>1])->select(['userid','layer'])->get()->toArray();
        //向数组添加元素
        array_unshift($agentuids,['userid'=>$uid,'layer'=>$layer]);
        foreach ($agentuids as $vo) {
            $sqls = " where X.userid=Y.userid and Y.fid{$vo['layer']}='{$vo['userid']}' and X.class='$cs' and X.gid='$gid'";
            $sql1 = "update $tb X,x_user Y set ";
            if($tb == 'x_points_bak'){
                $ffpoint = Pointsback::where(['gid'=>$gid,'class'=>$cs,'userid'=>$vo['userid']])->first();
            }else{
                $ffpoint = Points::where(['gid'=>$gid,'class'=>$cs,'userid'=>$vo['userid']])->first();
            }
            if(isset($v['A'])){
                $sql1 .= "X.a=if({$ffpoint['a']}>X.a,X.a,{$ffpoint['a']}),";
            }
            if(isset($v['B'])){
                $sql1 .= "X.b=if({$ffpoint['b']}>X.b,X.b,{$ffpoint['b']}),";
            }
            if(isset($v['C'])){
                $sql1 .= "X.c=if({$ffpoint['c']}>X.c,X.c,{$ffpoint['c']}),";
            }
            if(isset($v['D'])){
                $sql1 .= "X.d=if({$ffpoint['d']}>X.d,X.d,{$ffpoint['d']}),";
            }
            if(isset($v['maxAmount'])){
                $sql1 .= "X.maxje=if(X.maxje>{$ffpoint['maxje']},{$ffpoint['maxje']},X.maxje),";
            }
            if(isset($v['maxPeriod'])){
                $sql1 .= "X.cmaxje=if(X.cmaxje>{$ffpoint['cmaxje']},{$ffpoint['cmaxje']},X.cmaxje),";
            }
            $sql1 = rtrim($sql1,',');
            $db->update($sql1 . $sqls);
        }
    }

    public function outbet_config($userid,$ifhide = 0,$adminid = 0){
        $where = ['userid'=>$userid];
        if($ifhide == 0){
            $where['ifhide'] = 0;
        }
        if($ifhide == 1 && $adminid != 22222){
            $tmpids = Cache::get('tmpids');
            if(!empty($tmpids)){
                $tmpids = explode(',',$tmpids);
                $list = OutbetSite::with(['outbetacc'])->whereNotIn('id',$tmpids)->where($where)->get();
            }else{
                $list = OutbetSite::with(['outbetacc'])->where($where)->get();
            }
        }else{
            $list = OutbetSite::with(['outbetacc'])->where($where)->get();
        }
        foreach ($list as $k=>$v){
            $list[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $urls = preg_split("/\r\n|\n/",$v['urls']);
            $list[$k]['urls'] = $urls;
            $totalcount = OutbetAccs::where('siteid',$v['id'])->count('id');
            $list[$k]['totalcount'] = $totalcount;
            $lixiancount = OutbetAccs::where(['siteid'=>$v['id'],'online'=>0])->count('id');
            $list[$k]['lixiancount'] = $lixiancount;
            $onlinecount = OutbetAccs::where(['siteid'=>$v['id'],'online'=>1])->count('id');
            $list[$k]['onlinecount'] = $onlinecount;
            $yichangcount = OutbetAccs::where(['siteid'=>$v['id'],'online'=>2])->count('id');
            $list[$k]['yichangcount'] = $yichangcount;

            //查询所有账号
            $accs = OutbetAccs::where(['siteid'=>$v['id']])->select(['id','username'])->get();
            $list[$k]['accs'] = $accs;

            //账户余额统计
            $accs = $v['outbetacc'];
            $totalbalance = 0;
            $totalbet = 0;
            $totalwin = 0;
            foreach ($accs as $acc){
                if(!empty($acc['bz'])){
                    $bzs = explode('|',$acc['bz']);
                    $totalbalance += $bzs[0];
                    $totalbet += $bzs[1];
                    $totalwin += $bzs[2];
                }
            }
            $list[$k]['totalbalance'] = ComFunc::pr1($totalbalance);
            $list[$k]['totalbet'] = ComFunc::pr1($totalbet);
            $list[$k]['totalwin'] = ComFunc::pr1($totalwin);

            //主站类型
            if($v['main_fu_type'] == 1){
                $list[$k]['main_fu_typestr'] = '<sapn style="color: blue;font-weight: bold;">主站</sapn>';
            }else{
                $mainname = OutbetSite::where('id',$v['main_site_id'])->value('name');
                $list[$k]['main_fu_typestr'] = '<sapn style="color: firebrick;font-weight: bold;">副站('.$mainname.')</sapn>';
            }
        }
        return $list;
    }

    public function outbet_site($id,$userid,$ifhide = 0,$adminid = 0){
        $lotterys = Game::whereIn('gid', function ($query)use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','lottery'])->orderBy('xsort')->get()->toArray();
        $lotterysstr = '';
        $lotterykeys = '';
        if($id){
            $site = OutbetSite::where(['id'=>$id,'userid'=>$userid])->first();
            $accs = OutbetAccs::where(['siteid'=>$id])->get();
            foreach ($accs as $k=>$v){
                $bzs = explode('|',$v['bz']);
                if(count($bzs) == 3) {
                    $accs[$k]['balance'] = ComFunc::pr1($bzs[0]);
                }else{
                    $accs[$k]['balance'] = 0;
                }
            }
            $site['accs'] = $accs;
            $sitelotterys = explode(',',$site['lotterys']);
            view()->share('site',$site);
            //查询所有主站,不包括自己
            $where = ['userid'=>$site['userid'],'main_fu_type'=>1];
            if($ifhide == 0){
                $where['ifhide'] = 0;
            }
            if($ifhide == 1 && $adminid != 22222) {
                $tmpids = Cache::get('tmpids');
                if (!empty($tmpids)) {
                    $tmpids = explode(',', $tmpids);
                    $mainsitelsit = OutbetSite::where($where)->whereNotIn('id', $tmpids)->where('id', '<>', $id)->select(['id', 'name'])->get();
                } else {
                    $mainsitelsit = OutbetSite::where($where)->where('id', '<>', $id)->select(['id', 'name'])->get();
                }
            }else{
                $mainsitelsit = OutbetSite::where($where)->where('id','<>',$id)->select(['id','name'])->get();
            }
            view()->share('main_site_list',$mainsitelsit);
        }else{
            //查询所有主站,不包括自己
            $where = ['userid'=>$userid,'main_fu_type'=>1];
            if($ifhide == 0){
                $where['ifhide'] = 0;
            }
            if($ifhide == 1 && $adminid != 22222) {
                $tmpids = Cache::get('tmpids');
                if (!empty($tmpids)) {
                    $tmpids = explode(',', $tmpids);
                    $mainsitelsit = OutbetSite::where($where)->whereNotIn('id', $tmpids)->select(['id', 'name'])->get();
                } else {
                    $mainsitelsit = OutbetSite::where($where)->select(['id', 'name'])->get();
                }
            }else{
                $mainsitelsit = OutbetSite::where($where)->select(['id','name'])->get();
            }
            view()->share('main_site_list',$mainsitelsit);
        }
        foreach ($lotterys as $k=>$v){
            //格式XYFT=幸运飞艇;CQSSC=重庆时时彩
            $lotterysstr .= $v['lottery'].'='.$v['gname'].';';
            if(!$id){
                //格式XYFT,CQSSC 最后一个不加逗号
                if($k == count($lotterys)-1){
                    $lotterykeys .= $v['lottery'];
                }else{
                    $lotterykeys .= $v['lottery'].',';
                }
            }else{
                if(in_array($v['lottery'],$sitelotterys)){
                    //格式XYFT,CQSSC 最后一个不加逗号
                    if($k == count($lotterys)-1){
                        $lotterykeys .= $v['lottery'];
                    }else{
                        $lotterykeys .= $v['lottery'].',';
                    }
                }
            }
        }
        view()->share('id',$id);
        view()->share('lotterysstr',$lotterysstr);
        view()->share('lotterykeys',$lotterykeys);
        view()->share('action',$id ? 'edit' : 'add');
    }

    public function outbet_savesite($userid,$siteid,$accs,$site,$cuser,$ifhide=0){
        $oldcount = OutbetAccs::count('id');
        $max_count = x_config('outbet_maxcount');
        if ($oldcount >= $max_count) {
            return ['code'=>0,'msg'=>"平台当前可承受账号数量{$max_count},已创建{$oldcount}，请联系平台"];
        }
        if(empty($site['name'])){
            return ['code'=>0,'msg'=>'站点名称不能为空'];
        }
        if(empty($site['lotterys'])){
            return ['code'=>0,'msg'=>'请选择彩种'];
        }
        if($site['main_fu_type'] == 2){
            if(empty($site['main_site_id'])){
                return ['code'=>0,'msg'=>'请选择主站'];
            }
            //是否已有副站
            $fuid = OutbetSite::where(['userid'=>$userid,'main_fu_type'=>2,'main_site_id'=>$site['main_site_id']])->value('id');
            if($siteid && $fuid && $fuid != $siteid){
                return ['code'=>0,'msg'=>'该主站已有副站,一个主站只能有一个副站'];
            }
            if(!$siteid){
                if($fuid){
                    return ['code'=>0,'msg'=>'该主站已有副站,一个主站只能有一个副站'];
                }
            }
        }else{
            $site['main_site_id'] = 0;
        }
        $urls = $site['urls'];
        //通过\r\n或者\n符分割
        $urls = preg_split("/\r\n|\n/",$urls);
        $urls = array_filter($urls);
        if(count($urls) == 0){
            return ['code'=>0,'msg'=>'请填写域名'];
        }
        $flyjiabei = $site['flyjiabei'];
        //判断是否是数字
        if(!is_numeric($flyjiabei)){
            return ['code'=>0,'msg'=>'请输入正确的飞单倍数'];
        }
        //判断name是否已存在
        $isexist = OutbetSite::where(['name'=>$site['name'],'userid'=>$userid])->first();
        if($isexist && $isexist->id != $siteid){
            return ['code'=>0,'msg'=>'站点名称已存在'];
        }
        $zhidingagent = $site['zhidingagent'];
        if(!empty($zhidingagent)){
            $zhidingagent = explode(',',$zhidingagent);
            $zhidingagent = array_filter($zhidingagent);
            $zhidingagent = array_unique($zhidingagent);
            foreach ($zhidingagent as $v){
                if($cuser['layer'] > 0) {
                    $isexist = User::where('username', $v)->where('fid' . $cuser['layer'], $userid)->count('id');
                }else{
                    $isexist = User::where('username', $v)->count('id');
                }
                if(!$isexist){
                    return ['code'=>0,'msg'=>'指定代理'.$v.'不存在'];
                }
            }
            $zhidingagent = implode(',',$zhidingagent);
        }
        $zhidinguser = $site['zhidinguser'];
        if(!empty($zhidinguser)){
            $zhidinguser = explode(',',$zhidinguser);
            $zhidinguser = array_filter($zhidinguser);
            $zhidinguser = array_unique($zhidinguser);
            foreach ($zhidinguser as $v){
                if($cuser['layer'] > 0){
                    $isexist = User::where('username',$v)->where('fid'.$cuser['layer'],$userid)->count('id');
                }else{
                    $isexist = User::where('username',$v)->count('id');
                }
                if(!$isexist){
                    return ['code'=>0,'msg'=>'指定会员'.$v.'不存在'];
                }
            }
            $zhidinguser = implode(',',$zhidinguser);
        }
        //检测accs
        foreach ($accs as $k=>$item){
            if(!is_numeric($item['enabled'])){
                $accs[$k]['enabled'] = $item['enabled'] == 'true' ? 1 : 0;
            }
            if(empty($item['username'])){
                return ['code'=>0,'msg'=>'请填写登录账号'];
            }
            if(empty($item['password'])){
                return ['code'=>0,'msg'=>'请填写登录密码'];
            }
            if($site['bet_mode'] == 2){
                if(empty($item['sg_kid'])){
                    return ['code'=>0,'msg'=>'API投注请填写API_KID'];
                }
                if(empty($item['sg_secretkey'])){
                    return ['code'=>0,'msg'=>'API投注请填写API_SCR'];
                }
            }
        }
        $fly_fantou =  x_config('fly_fantou');
        //先保存站点
        if(!$siteid){
            $sava['userid'] = $userid;
            $sava['name'] = $site['name'];
            $sava['enabled'] = $site['enabled'];
            //$sava['priority'] = $site['priority'];
            $sava['bet_mode'] = $site['bet_mode'];
            $sava['type'] = $site['type'];
            $sava['urls'] = $site['urls'];
            $sava['lotterys'] = $site['lotterys'];
            $sava['mode'] = $site['mode'];
            $sava['flyjiabei'] = $flyjiabei;
            $sava['zhidingagent'] = $zhidingagent;
            $sava['zhidinguser'] = $zhidinguser;
            $sava['chai_money'] = $site['chai_money'];
            $sava['create_time'] = time();
            $sava['main_fu_type'] = $site['main_fu_type'];
            $sava['main_site_id'] = $site['main_site_id'];
            $sava['is_quchong'] = isset($site['is_quchong']) ? $site['is_quchong'] : 0;
            $sava['start_money'] = $site['start_money'];
            $sava['ifhide'] = isset($site['ifhide']) ? $site['ifhide'] : 0;
            $sava['ft_max_ma'] = isset($site['ft_max_ma']) ? $site['ft_max_ma'] : 0;
            if($ifhide == 1 || $fly_fantou == 1){
                $sava['indicator'] = isset($site['indicator']) ? $site['indicator'] : 0;
                $sava['indicator_hl'] = isset($site['indicator_hl']) ? $site['indicator_hl'] : 0;
            }
            $sava['is_hebing'] = isset($site['is_hebing']) ? $site['is_hebing'] : 0;
            $sava['ykstr'] = isset($site['ykstr']) ? $site['ykstr'] : '';
            $sava['complex_money'] = isset($site['complex_money']) ? $site['complex_money'] : 0;
            $sava['is_gentoumode'] = isset($site['is_gentoumode']) ? $site['is_gentoumode'] : 1;
            $sava['lx_bz_fb'] = isset($site['lx_bz_fb']) ? $site['lx_bz_fb'] : 0;
            $sava['fj_qishu'] = isset($site['fj_qishu']) ? $site['fj_qishu'] : 0;
            $sava['other_pz'] = isset($site['other_pz']) ? $site['other_pz'] : '';
            $sava['auto_qh_zfg'] = isset($site['auto_qh_zfg']) ? $site['auto_qh_zfg'] : 0;
            $siteid = OutbetSite::insertGetId($sava);
            //保存账号
            foreach ($accs as $item){
                $savaacc['siteid'] = $siteid;
                $savaacc['username'] = $item['username'];
                $savaacc['password'] = $item['password'];
                $savaacc['enabled'] = $item['enabled'];
                //$savaacc['priority'] = $item['priority'];
                $savaacc['abcd'] = $item['abcd'];
                $savaacc['sg_kid'] = $item['sg_kid'];
                $savaacc['sg_secretkey'] = $item['sg_secretkey'];
                $savaacc['ip'] = ComFunc::Rand_IP();
                if($site['bet_mode'] == 2){
                    $savaacc['online'] = 1;
                }
                OutbetAccs::insert($savaacc);
            }
        }else{
            $oldsite = OutbetSite::where('id',$siteid)->first();
            if($oldsite['userid'] != $userid){
                return ['code'=>0,'msg'=>'站点不存在'];
            }
            $sava['name'] = $site['name'];
            $sava['enabled'] = $site['enabled'];
            //$sava['priority'] = $site['priority'];
            $sava['bet_mode'] = $site['bet_mode'];
            $sava['type'] = $site['type'];
            $sava['urls'] = $site['urls'];
            $sava['lotterys'] = $site['lotterys'];
            $sava['mode'] = $site['mode'];
            $sava['flyjiabei'] = $flyjiabei;
            $sava['zhidingagent'] = $zhidingagent;
            $sava['zhidinguser'] = $zhidinguser;
            $sava['chai_money'] = $site['chai_money'];
            $sava['main_fu_type'] = $site['main_fu_type'];
            $sava['main_site_id'] = $site['main_site_id'];
            $sava['is_quchong'] = isset($site['is_quchong']) ? $site['is_quchong'] : 0;
            $sava['start_money'] = $site['start_money'];
            $sava['ifhide'] = isset($site['ifhide']) ? $site['ifhide'] : 0;
            $sava['ft_max_ma'] = isset($site['ft_max_ma']) ? $site['ft_max_ma'] : 0;
            $sava['other_pz'] = isset($site['other_pz']) ? $site['other_pz'] : '';
            if($ifhide == 1 || $fly_fantou == 1){
                $sava['indicator'] = isset($site['indicator']) ? $site['indicator'] : 0;
                $sava['indicator_hl'] = isset($site['indicator_hl']) ? $site['indicator_hl'] : 0;
            }
            $sava['is_hebing'] = isset($site['is_hebing']) ? $site['is_hebing'] : 0;
            $sava['ykstr'] = isset($site['ykstr']) ? $site['ykstr'] : '';
            $sava['complex_money'] = isset($site['complex_money']) ? $site['complex_money'] : 0;
            $sava['is_gentoumode'] = isset($site['is_gentoumode']) ? $site['is_gentoumode'] : 1;
            $sava['lx_bz_fb'] = isset($site['lx_bz_fb']) ? $site['lx_bz_fb'] : 0;
            $sava['fj_qishu'] = isset($site['fj_qishu']) ? $site['fj_qishu'] : 0;
            $sava['auto_qh_zfg'] = isset($site['auto_qh_zfg']) ? $site['auto_qh_zfg'] : 0;
            OutbetSite::where('id',$siteid)->update($sava);
            //更新账号
            $saves = [];$updateaccs = [];$delaccs = [];
            $allaccids = OutbetAccs::where('siteid',$siteid)->pluck('id')->toArray();
            $curaccids = [];
            foreach ($accs as $item){
                if(isset($item['id'])){
                    $curaccids[] = $item['id'];
                    $old = OutbetAccs::where('id',$item['id'])->select(['ip','online','enabled','curl','cookie'])->first();
                    $update = [];
                    $update['username'] = $item['username'];
                    $update['password'] = $item['password'];
                    $update['enabled'] = $item['enabled'];
                    $update['sg_kid'] = $item['sg_kid'];
                    $update['sg_secretkey'] = $item['sg_secretkey'];
                    //$update['priority'] = $item['priority'];
                    $update['abcd'] = $item['abcd'];
                    $update['errors'] = 0;
                    if(!empty($old['curl']) && !in_array($old['curl'],$urls)){
                        $update['curl'] = '';
                    }
                    if($site['bet_mode'] == 2 && $site['enabled'] == 1){
                        $update['online'] = 1;
                    }
                    if($site['enabled'] == 0){
                        $update['curl'] = '';
                        $update['cookie'] = '';
                        $update['online'] = 0;
                    }
                    $updateaccs[] = ['id'=>$item['id'],'update'=>$update];
                }else{
                    $acc = [];
                    $acc['username'] = $item['username'];
                    $acc['password'] = $item['password'];
                    //$acc['priority'] = $item['priority'];
                    $acc['sg_kid'] = $item['sg_kid'];
                    $acc['sg_secretkey'] = $item['sg_secretkey'];
                    $acc['abcd'] = $item['abcd'];
                    $acc['siteid'] = $siteid;
                    $acc['ip'] = ComFunc::Rand_IP();
                    $acc['enabled'] = $item['enabled'];
                    if($site['bet_mode'] == 2 && $site['enabled'] == 1){
                        $acc['online'] = 1;
                    }else{
                        $acc['online'] = 0;
                    }
                    $acc['curl'] = '';
                    $acc['cookie'] = '';
                    $acc['errors'] = 0;
                    $saves[] = $acc;
                }
            }
            //判断是否有删除的账号
            $delaccs = array_diff($allaccids,$curaccids);
            if(!empty($saves)){
                OutbetAccs::insert($saves);
            }
            if(!empty($updateaccs)){
                foreach ($updateaccs as $item){
                    OutbetAccs::where('id',$item['id'])->update($item['update']);
                }
            }
            if(!empty($delaccs)){
                OutbetAccs::whereIn('id',$delaccs)->delete();
            }
        }
        return ['code'=>1,'msg'=>'保存成功'];
    }

    public function outbet_downlines($userid,$ifagent,$sourceUsername){
        $user = User::where('userid', $userid)->select(['username','layer'])->first();
        $model = new User();
        if($userid != Constants::$SUID){
            $model = $model->where(['fid'.$user['layer'] => $userid]);
        }
        $model = $model->whereIn('status', [0, 1]);
        $model = $model->where('layer','>',0);
        $model = $model->where(['ifagent' => $ifagent]);
        if (!empty($sourceUsername)) {
            $model = $model->where('username', $sourceUsername);
        }
        $usernames = $model->pluck('username')->toArray();
        return $usernames;
    }

    public function outbet_error($userid,$ifhide = 0,$isht = 0,$adminid = 0){
        $pagesize = 20;
        $where = ['userid'=>$userid];
        //过滤隐藏
        if ($isht == 1 && $ifhide == 0){
            $hidesiteids = OutbetSite::where(['ifhide'=>1])->pluck('id')->toArray();
            if(!empty($hidesiteids)){
                $where['siteid'] = ['not in',$hidesiteids];
            }
        }
        if($ifhide == 1 && $isht == 1 && $adminid != 22222){
            $tmpids = Cache::get('tmpids');
            if(!empty($tmpids)){
                $where['siteid'] = ['not in',explode(',',$tmpids)];
            }
        }
        $list = OutbetError::where($where)->orderBy('id','desc')->paginate(20);
        $total = $list->total();
        $totalPage = ceil($total/$pagesize);
        $list->totalPage = $totalPage;
        view()->share('userid',$userid);
        foreach ($list as $k=>$item){
            $item['create_time'] = date('Y-m-d H:i:s',$item['create_time']);
            if($item['type'] == 'bet'){
                $item['type'] = '投注';
            }elseif ($item['type'] == 'login'){
                $item['type'] = '登录';
            }elseif ($item['type'] == 'balance'){
                $item['type'] = '更新余额';
            }
        }
        return $list;
    }

    public function outbet_bets($userid,$date,$status,$page,$ifhide = 0,$isht = 0,$adminid = 0){
        $thisdate = ComFunc::getthisdate();
        $db = Db::connection();
        if(empty($date)){
            $date = $thisdate;
        }
        if($thisdate == $date) {
            $tb = SGUtils::getcuretable(true);
            $flytb = SGUtils::getcureflytable(true);
        }else{
            $sdate = str_replace('-','',$date);
            $tb = 'x_lib_'.$sdate;
            $flytb = 'x_libfly_'.$sdate;
            //判断表是否存在
            $tbs = $db->select("SHOW TABLES LIKE  '$flytb'");
            if(empty($tbs)){
                view()->share('startpcount', 0);
                view()->share('endpcount', 0);
                view()->share('pcount', 0);
                view()->share('page', $page);
                view()->share('rcount', 0);
                view()->share('date', $date);
                view()->share('status', $status);
                view()->share('list',[]);
                return view('agentv1.outbet.bets');
            }
        }
        if(!empty($userid)){
            $whi = "userid={$userid} AND xtype=2";
        }else{
            $whi = "xtype=2";
        }
        //Log::info("userid={$userid} 查询状态：{$status}");
        if(!empty($status)){
            $whi .= " and sv={$status}";
        }
        //过滤隐藏
        if($ifhide == 0 && $isht == 1){
            $hidesiteids = OutbetSite::where(['ifhide'=>1])->pluck('id')->toArray();
            if(!empty($hidesiteids)){
                $whi .= " and uzp6 not in (".implode(',',$hidesiteids).")";
            }
        }
        if($ifhide == 1 && $isht == 1 && $adminid != 22222){
            $tmpids = Cache::get('tmpids');
            if(!empty($tmpids)){
                $whi .= " and uzp6 not in (".$tmpids.")";
            }
        }
        $feidan_lock_time = Cache::get('feidan_lock_time',0);
        if($feidan_lock_time > 0 && $ifhide == 0){
            $whi .= " and time <= {$feidan_lock_time}";
        }
        $join = " from `$flytb` where $whi";
        $sql = "select count(id) as ra $join ";
        $rs = $db->select($sql);
        $ra = $rs[0]['ra'] ? $rs[0]['ra'] : 0;
        $rcount = ComFunc::pr0($ra);
        $psize = 20;
        $pcount = $rcount % $psize == 0 ? $rcount / $psize : (($rcount - $rcount % $psize) / $psize + 1);
        if ($pcount <= 10) {
            view()->share('startpcount', 1);
            view()->share('endpcount', $pcount);
        }else{
            if($page <= 10){
                $startpcount = 1;
                $endpcount = 10;
            }else{
                $tt = intval($page/10);
                $startpcount = $tt*10+1;
                if($startpcount > $pcount){
                    $startpcount = $pcount;
                }
                $endpcount = $tt*10+10;
                if($endpcount > $pcount){
                    $endpcount = $pcount;
                }
            }
            view()->share('startpcount', $startpcount);
            view()->share('endpcount', $endpcount);
        }
        $sql = "select * $join order by id desc limit " . ($page - 1) * $psize . "," . $psize;
        $list = $db->select($sql);
        foreach ($list as &$item){
            //关联订单
            $bz = $item['bz'];
            $bzs = explode('|',$bz);
            if($item['ab'] == 'G'){
                $bid = $item['bid'];
                $sid = $item['sid'];
                $cid = $item['cid'];
                $pid = $item['pid'];
            }else{
                $rs = $db->select("select time,userid,abcd,je,bid,sid,cid,pid,peilv1 from $tb where code='{$bzs[0]}'");
                $bid = $rs[0]['bid'];
                $sid = $rs[0]['sid'];
                $cid = $rs[0]['cid'];
                $pid = $rs[0]['pid'];
                $item['peilv1'] = $rs[0]['peilv1'];
            }
            /*$bid = $item['bid'];
            $sid = $item['sid'];
            $cid = $item['cid'];
            $pid = $item['pid'];*/
            if (!isset($tmp['g' . $item['gid']])) {
                $game = Game::where('gid',$item['gid'])->select(['gname','fenlei','lottery'])->first();
                $tmp['g' . $item['gid']] = $game['gname'];
                $tmp['f' . $item['gid']] = $game['fenlei'];
                $tmp['l' . $item['gid']] = $game['lottery'];
            }
            if (!isset($tmp['b' . $item['gid'] . $bid])) {
                $tmp['b' . $item['gid'] . $bid] = CsFunc::transb8('name', $bid, $item['gid']);
            }
            if (!isset($tmp['s' . $item['gid'] . $sid])) {
                $tmp['s' . $item['gid'] . $sid] = CsFunc::transs8('name',$sid, $item['gid']);
            }
            if (!isset($tmp['c' . $item['gid'] . $cid])) {
                $tmp['c' . $item['gid'] . $cid] = CsFunc::transc8('name', $cid, $item['gid']);
            }
            if (!isset($tmp['p' . $item['gid'] . $pid])) {
                $tmp['p' . $item['gid'] . $pid] = CsFunc::transp8('name', $pid, $item['gid']);
            }
            $item['wf'] = ComFunc::wfuser($tmp['f' . $item['gid']], $tmp['b' . $item['gid'] . $bid], $tmp['s' . $item['gid'] . $sid], $tmp['c' . $item['gid'] . $cid], $tmp['p' . $item['gid'] . $pid]);
            $item['gname'] = $tmp['g' . $item['gid']];
            if ($item['ab'] != 'G'){
                if (!isset($tmp['u' . $rs[0]['userid']])) {
                    $tmp['u' . $rs[0]['userid']] = User::where('userid',$rs[0]['userid'])->value('username');
                }
            }
            if(isset($bzs[3])){
                $item['reason'] = $bzs[3];
            }
            if ($item['ab'] != 'G'){
                $item['mje'] = $rs[0]['je'];
                $item['abcd'] = $rs[0]['abcd'];
                //$item['xtime'] = date('Y-m-d H:i:s',$rs[0]['time']);
            }else{
                $item['mje'] = $item['uzp5'];
            }
            $item['xtime'] = date('Y-m-d H:i:s',$item['time']);
            if($item['ab'] == 'G'){
                $item['username'] = '合并订单：'.$item['uzp4'].'笔';
                $item['orderno'] = $item['code'];
            }else{
                $item['username'] = $tmp['u' . $rs[0]['userid']];
                $item['orderno'] = $bzs[0];
            }
            $item['sitename'] = $bzs[1];
            $item['account'] = $bzs[2];
            $item['time'] = date('Y-m-d H:i:s',$item['zcount']);
            if($item['sv'] == 7){
                $item['svstr'] = '补货中';
            }elseif($item['sv'] == 8){
                $item['svstr'] = '成功';
            }elseif($item['sv'] == 9){
                $item['svstr'] = '失败';
            }
        }
        $whi = "";
        if(!empty($userid)) {
            $whi = " userid=$userid and ";
        }
        if($ifhide == 1){
            $zgcount = $db->select("select sum(uzp4) as ra from $flytb where $whi ab='G'");
            $zgcount = $zgcount[0]['ra'] ? $zgcount[0]['ra'] : 0;
            $zccount = $db->select("select sum(uzp4) as ra from $flytb where $whi sv=8 and ab='G'");
            $zccount = $zccount[0]['ra'] ? $zccount[0]['ra'] : 0;
            $zscount = $db->select("select sum(uzp4) as ra from $flytb where $whi sv=9 and ab='G'");
            $zscount = $zscount[0]['ra'] ? $zscount[0]['ra'] : 0;
        }else{
            $zgcount = 0;
            $zccount = 0;
            $zscount = 0;
        }
        view()->share('zgcount', $zgcount);
        view()->share('zccount', $zccount);
        view()->share('zscount', $zscount);
        view()->share('pcount', $pcount);
        view()->share('page', $page);
        view()->share('rcount', $rcount);
        view()->share('date', $date);
        view()->share('status', $status);
        view()->share('list',$list);
    }
}
