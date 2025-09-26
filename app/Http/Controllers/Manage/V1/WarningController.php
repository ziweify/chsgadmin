<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\Lib;
use App\Models\Game\User;
use App\Models\Game\Warn;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\sgwin\Json;
use App\ort\sgwin\SGUtils;
use Illuminate\Http\Request;

class WarningController extends ManageAuthController
{
   public function warning(Request $request){
       $userid = $this->uid;
       $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
           $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
       })->where('ifopen', 1)->select(['gname','lottery','gid'])->orderBy('xsort')->get();
       if ($request->isMethod('post')) {
           $lottery = $request->input('lottery','');
           $key = $request->input('key','');
           $time = $request->input('time','');
           $result = ['totals'=>[],'warnFirst'=>[],'warnKey'=>[],'warnLast'=>[]];
           $lotarr = $lotterys->toArray();
           if(empty($lottery)){
               $lottery = $lotarr[0]['lottery'];
           }
           $game = Game::where('lottery',$lottery)->select(['gid','gname'])->first();
           //将$lotarr中的字段lottery作为键名，值为0
           $result['totals'] = array_combine(array_column($lotarr,'lottery'),array_fill(0,count($lotarr),0));
           $libmodel = SGUtils::getcuremodel();
           foreach ($lotterys as $vo){
               $result['totals'][$vo['lottery']] = $libmodel->where(['gid'=>$vo['gid'],'z'=>9,'bs'=>1])->sum('je');
           }
           $model = $libmodel->where(['gid'=>$game['gid'],'z'=>9,'bs'=>1]);
           //时间time格式为60秒，条件为比time小的
           if ($time) {
               $model->where('time','>=',time()-$time);
           }
           if(!empty($key)){
                $model->where('dftype',$key);
           }
           $dftypes = Warn::where(['gid'=>$game['gid'],'userid'=>$userid])->where('je','>',0)->select(['class','je'])->get()->toArray();
           $dfs = array_column($dftypes,'class');
           $dftypes = array_combine(array_column($dftypes,'class'),array_column($dftypes,'je'));
           $liblist = $model->selectRaw('sum(je) as je,dftype,cy,bid,sid,cid,pid')->whereIn('dftype',$dfs)->orderByDesc('je')->groupBy('dftype')->get();
           $rlsit = [];$tmp = [];
           foreach ($liblist as $vo){
               if($dftypes[$vo['dftype']] > $vo['je']) {
                   continue;
               }
               $item = [];
               $item['amount'] = $vo['je'];
               $arr = explode('_',$vo['cy']);
               $item['item'] = $arr[0];
               $item['key'] = $arr[1];
               $item['lottery'] = $lottery;
               if (!isset($tmp['b'.$vo['bid']])) {
                   $tmp['b'.$vo['bid']] = CsFunc::transb8('name', $vo['bid'], $game['gid']);
               }
               if (!isset($tmp['s'.$vo['sid']])) {
                   $tmp['s'.$vo['sid']] = CsFunc::transs8('name', $vo['sid'], $game['gid']);
               }
               if (!isset($tmp['c'.$vo['cid']])) {
                   $tmp['c'.$vo['cid']] = CsFunc::transc8('name', $vo['cid'], $game['gid']);
               }
               if (!isset($tmp['p'.$vo['pid']])) {
                   $tmp['p'.$vo['pid']] = CsFunc::transp8('name', $vo['pid'], $game['gid']);
               }
               $wf = ComFunc::wfuser($game['gid'], $tmp['b'.$vo['bid']], $tmp['s'.$vo['sid']], $tmp['c'.$vo['cid']], $tmp['p'.$vo['pid']]);
               $item['text'] = $game['gname'].'-'.$wf;
               $rlsit[] = $item;
           }
           $result['warnKey'] = $rlsit;
           return response()->json($result);
       }else{
           $user = User::where('userid',$userid)->select(['username'])->first();
           view()->share('lotterys', $lotterys);
           view()->share('username', $user['username']);
           return view('managev1.warning.warning');
       }
   }

   public function gameMap(){
       $userid = $this->uid;
       $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
           $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
       })->where('ifopen', 1)->select(['gname','lottery','dftype'])->orderBy('xsort')->get();
       $result = [];
       foreach ($lotterys as $lottery){
           $dftype = json_decode($lottery['dftype'],true);
           $arr = [];
           foreach ($dftype as $key=>$value){
               $arr[] = ['key'=>$key,'name'=>$value];
           }
           $result[$lottery['lottery']] = $arr;
       }
       return response()->json($result);
   }

   public function setting(Request $request){
       $userid = $this->uid;
       if($request->isMethod('post')) {
           $list = $request->input('list','');
           $list = json_decode($list,true);
           $tmp = [];
           foreach ($list as $v){
               $lottery = $v['lottery'];
               if(!isset($tmp['g'.$lottery])){
                   $tmp['g'.$lottery] = Game::where('lottery',$lottery)->select(['gid'])->first();
               }
               $game = $tmp['g'.$lottery];
               $gid = $game['gid'];
               $cs = $v['game'];
               $update = [];
               if(isset($v['warnAmount'])){
                   $update['firstje'] = $v['warnAmount'];
               }
               if(isset($v['warnLoop'])){
                   $update['je'] = $v['warnLoop'];
               }
               $oldwarn = Warn::where(['userid'=>$userid,'gid'=>$gid,'class'=>$cs])->first();
               if(empty($oldwarn)){
                   $update['userid'] = $userid;
                   $update['gid'] = $gid;
                   $update['class'] = $cs;
                   Warn::insert($update);
               }else{
                   Warn::where(['userid'=>$userid,'gid'=>$gid,'class'=>$cs])->update($update);
               }
           }
           return Json::success('保存成功');
       }else{
           $user = User::where('userid',$userid)->select(['username','name'])->first();
           $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
               $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
           })->where('ifopen', 1)->select(['gname','lottery','template','dftype','gid'])->orderBy('xsort')->get()->toArray();
           foreach ($lotterys as &$game){
               $dftype = json_decode($game['dftype'], true);
               $warn = [];
               foreach ($dftype as $key=>$val) {
                   $warn_single = Warn::where(['class'=>$key,'userid'=>$userid,'gid'=>$game['gid']])->first();
                   if(empty($warn_single)){
                       $warn[$key]['je'] = 0;
                       $warn[$key]['firstje'] = 0;
                   }else{
                       $warn[$key]['je'] = $warn_single['je'];
                       $warn[$key]['firstje'] = $warn_single['firstje'];
                   }
                   $warn[$key]['name'] = $val;
                   $warn[$key]['class'] = $key;
               }
               //根据dftype数组数量拆分成两个数组，如果有多的则放在第一个数组
               $count = count($warn);
               $count1 = ceil($count/2);
               $count2 = floor($count/2);
               $list = [];
               $list[] = array_slice($warn,0,$count1);
               $list[] = array_slice($warn,$count1,$count2);
               $game['warnlist'] = $list;
           }
           view()->share('lotterys', $lotterys);
           view()->share('username', $user['username']);
           view()->share('name', $user['name']);
           return view('managev1.warning.setting');
       }
   }
}
