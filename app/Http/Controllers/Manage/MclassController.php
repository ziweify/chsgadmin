<?php

namespace App\Http\Controllers\Manage;


use App\Models\Game\Bclass;
use App\Models\Game\Game;
use App\Models\Game\Mclass;
use App\Models\Game\Sclass;
use App\ort\common\ComFunc;
use App\ort\common\Constants;
use App\ort\common\CsFunc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MclassController extends ManageAuthController
{
    public function mclassclasspan(Request $request){
        $gid = $request->input('gid','');
        $userid = $this->uid;
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share("lotterys", $lotterys->toArray());
        if(empty($gid)){
            $gid = $lotterys[0]['gid'];
        }
        view()->share("gid", $gid);
        $pa = Game::where('gid',$gid)->value('pan');
        $pan = json_decode($pa, true);
        view()->share("pan",$pan);
        view()->share("game",$lotterys);
        view()->share("gid",$gid);
        return view('manage.mclass.classpan');
    }

    public function mclasseditpan(Request $request){
        $gid = $request->input('gid','');
        $str = $request->input('str','');
        $arr = str_replace('\\','',$str);
        Game::where('gid',$gid)->update(['pan'=>$arr]);
        echo 1;
    }

    public function tongbuzpan(Request $request){
        $gid = $request->input('gid','');
        $db = Db::connection();
        $game_single = Game::where('gid', $gid)->select(['fenlei','dftype'])->first();
        $dftype = json_decode($game_single['dftype'], true);
        $uid = Constants::$SUID;
        $db->delete("delete from x_zpan where gid='$gid' and userid='$uid'");
        foreach ($dftype as $k => $v) {
            $sql = "insert into x_zpan set gid='$gid',class='" . $k . "',userid=$uid,lowpeilv=0,peilvcha=0";
            $db->insert($sql);
        }
        echo 1;
    }

    public function mclassbigclass(Request $request){
        $gid = $request->input('gid','');
        $userid = $this->uid;
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share("lotterys", $lotterys->toArray());
        if(empty($gid)){
            $gid = $lotterys[0]['gid'];
        }
        view()->share("gid", $gid);
        $blist = Bclass::where('gid',$gid)->select(['bid','name','ifok','xsort'])->orderBy('xsort')->get();
        view()->share("b", $blist->toArray());
        $game = Game::where('gid',$gid)->select(['fenlei','flname','gname'])->first();
        view()->share("fenlei", $game['fenlei']);
        view()->share("flname", $game['flname']);
        view()->share("gname", $game['gname']);
        return view('manage.mclass.classlistb');
    }

    public function mclassaddb(Request $request){
        $name = $request->input('name','');
        $gid = $request->input('gid','');
        if (empty($name) || empty($gid)) {
            return '参数错误';
        }
        $bid = ComFunc::setupid('x_bclass', 'bid');
        $res = Bclass::create(['gid'=>$gid,'bid'=>$bid,'name'=>$name,'ifok'=>1,'xsort'=>0]);
        if (($res)){
            return 1;
        }
    }

    public function mclasseditb(Request $request){
        $name = $request->input('name','');
        $ifok = $request->input('ifok','');
        $xsort = $request->input('xst','');
        $bid = $request->input('bid','');
        $gid = $request->input('gid','');
        Bclass::where(['gid'=>$gid,'bid'=>$bid])->update(['name'=>$name,'ifok'=>$ifok,'xsort'=>$xsort]);
        return 1;
    }

    public function mclassdelb(Request $request){
        $idstr = $request->input('idstr','');
        $gid = $request->input('gid','');
        if(empty($idstr) || empty($gid)){
            return '参数错误';
        }
        $db = Db::connection();
        $sql = "delete from x_bclass where instr('$idstr',bid) and gid='$gid'";
        $db->delete($sql);
        return 1;
    }

    public function mclassyiwotongbu(Request $request){
        $ngid = $request->input('gid','');
        if(empty($ngid)){
            return '参数错误';
        }
        $uid = Constants::$SUID;
        $db = Db::connection();
        $fenlei = Game::where('gid',$ngid)->value('fenlei');
        //$game = $db->select("select gid,ifok from x_gamecs where userid='$uid' and gid in (select gid from x_game where fenlei='$fenlei')");
        $gg = Game::where('gid',$ngid)->select(['dftype','ftype','mtype','ztype','patt','pan','ptype'])->first();
        $dftype = json_encode(json_decode($gg['dftype']),JSON_UNESCAPED_UNICODE);
        $ftype = json_encode(json_decode($gg['ftype']),JSON_UNESCAPED_UNICODE);
        $mtype = json_encode(json_decode($gg['mtype']),JSON_UNESCAPED_UNICODE);
        $ztype = json_encode(json_decode($gg['ztype']),JSON_UNESCAPED_UNICODE);
        $patt = json_encode(json_decode($gg['patt']),JSON_UNESCAPED_UNICODE);
        $pan = json_encode(json_decode($gg['pan']),JSON_UNESCAPED_UNICODE);
        $ptype = $gg['ptype'];
        $db->update("update x_game set ftype='$ftype',dftype='$dftype',ztype='$ztype',mtype='$mtype',patt='$patt',pan='$pan',ptype='$ptype' where fenlei='$fenlei' and gid!='$ngid' ");
        $glist = $db->select("select gid from x_game where fenlei='$fenlei' and gid!='$ngid'");
        foreach ($glist as $item) {
            $gid = $item['gid'];
            $db->delete("delete from x_bclass where gid='$gid'");
            $db->delete("delete from x_sclass where gid='$gid'");
            $db->delete("delete from x_class where gid='$gid'");
            $db->delete("delete from x_play where gid='$gid'");
            $db->insert("insert into x_bclass select NULL,$gid,bid,name,ifok,xsort from x_bclass where gid='$ngid'");
            $db->insert("insert into x_sclass select NULL,$gid,bid,sid,name,ifok,xsort from x_sclass where gid='$ngid'");
            $db->insert("insert into x_class select NULL,$gid,bid ,sid,cid,name,xsort,ifok,mtype,ftype,xshow,one,dftype,cs from x_class where gid='$ngid'");
            $db->insert("insert into x_play select NULL,$gid,bid,sid,cid,pid,name,ifok,peilv1,mp1,ztype,znum1,znum2,xsort,start,autocs,zstart,zautocs,zqishu,buzqishu,ystart,yautocs,ptype,cy from x_play where gid='$ngid'");
        }
        return 1;
    }

    public function mclasssclass(Request $request){
        $bid = $request->input('bid','');
        $gid = $request->input('gid','');
        $userid = $this->uid;
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share("lotterys", $lotterys->toArray());
        if(empty($gid)){
            $gid = $lotterys[0]['gid'];
        }
        view()->share("gid", $gid);
        if ($bid == '') {
            $sclass_list = Sclass::where('gid',$gid)->limit(100)->orderBy('xsort')->get();
        } else {
            $sclass_list = Sclass::where(['gid'=>$gid,'bid'=>$bid])->orderBy('xsort')->get();
        }
        $s = array();
        $i = 0;
        foreach ($sclass_list as $item) {
            $s[$i]['bid'] = $item['bid'];
            $s[$i]['bname'] = CsFunc::transb($gid,'name', $item['bid']);
            $s[$i]['sid'] = $item['sid'];
            $s[$i]['name'] = $item['name'];
            $s[$i]['ifok'] = $item['ifok'];
            $s[$i]['xsort'] = $item['xsort'];
            $i++;
        }
        view()->share("s", $s);
        $bclass_list = Bclass::where('gid',$gid)->orderBy('xsort')->get();
        $b = array();
        $i = 0;
        foreach ($bclass_list as $item) {
            $b[$i]['bid'] = $item['bid'];
            $b[$i]['name'] = $item['name'];
            $i++;
        }
        view()->share("b", $b);
        view()->share("bid", $bid);
        return view('manage.mclass.classlists');
    }

    public function mclassadds(Request $request){
        $name = $request->input('name','');
        $bid = $request->input('bid','');
        $gid = $request->input('gid','');
        if (empty($name) || empty($bid) || empty($gid)) {
            return '参数错误';
        }
        $sid = ComFunc::setupid('x_sclass', 'sid');
        Sclass::create(['gid'=>$gid,'bid'=>$bid,'sid'=>$sid,'name'=>$name,'ifok'=>1,'xsort'=>0]);
        return 1;
    }

    public function mclassedits(Request $request){
        $name = $request->input('name','');
        $ifok = $request->input('ifok','');
        $xsort = $request->input('xst','');
        $bid = $request->input('bid','');
        $sid = $request->input('sid','');
        $gid = $request->input('gid','');
        Sclass::where(['gid'=>$gid,'sid'=>$sid])->update(['name'=>$name,'ifok'=>$ifok,'xsort'=>$xsort,'bid'=>$bid]);
        return 1;
    }

    public function mclassdels(Request $request){
        $idstr = $request->input('idstr','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $sql = "delete from x_sclass where instr('$idstr',sid) and gid='$gid'";
        $db->delete($sql);
        return 1;
    }

    public function mclassmclass(Request $request){
        $bid = $request->input('bid','');
        $sid = $request->input('sid','');
        $gid = $request->input('gid','');
        $userid = $this->uid;
        $lotterys = Game::whereIn('gid', function ($query) use ($userid) {
            $query->select('gid')->from('gamecs')->where(['userid'=>$userid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share("lotterys", $lotterys->toArray());
        if(empty($gid)){
            $gid = $lotterys[0]['gid'];
        }
        view()->share("gid", $gid);
        $db = Db::connection();
        $whi = " where gid='$gid' ";
        if ($bid != '')
            $whi .= " and bid='$bid' ";
        if ($sid != '')
            $whi .= " and sid='$sid' ";
        $game = Game::where('gid',$gid)->select(['mtype','ftype','dftype'])->first();
        $config['ftype'] = json_decode($game['ftype'], true);
        $config['dftype'] = json_decode($game['dftype'], true);
        $config['mtype'] = json_decode($game['mtype'], true);
        $class_list = $db->select("select * from x_class  $whi order by xsort ");
        $c = array();
        $i = 0;
        foreach ($class_list as $item) {
            $c[$i]['bid'] = $item['bid'];
            $c[$i]['bname'] = Bclass::where(['bid'=>$item['bid'],'gid'=>$gid])->value('name');
            $c[$i]['sid'] = $item['sid'];
            $c[$i]['sname'] = Sclass::where(['sid'=>$item['sid'],'gid'=>$gid])->value('name');
            $c[$i]['cid'] = $item['cid'];
            $c[$i]['name'] = $item['name'];
            $c[$i]['ifok'] = $item['ifok'];
            $c[$i]['ftype'] = $item['ftype'];
            $c[$i]['dftype'] = $item['dftype'];
            $c[$i]['mtype'] = $config['mtype'][$item['mtype']];
            $c[$i]['xsort'] = $item['xsort'];
            $c[$i]['xshow'] = $item['xshow'];
            $c[$i]['one'] = $item['one'];
            $c[$i]['cs'] = $item['cs'];
            $i++;
        }
        view()->share("c", $c);
        $b = Bclass::where('gid',$gid)->select(['bid','name'])->orderBy('xsort')->get();
        view()->share("b", $b->toArray());
        $s = [];
        if ($bid != '') {
            $s = Sclass::where(['gid'=>$gid,'bid'=>$bid])->select(['sid','name'])->orderBy('xsort')->get();
        }
        view()->share("s", $s);
        view()->share('mtype', $config['mtype']);
        view()->share('ftype', $config['ftype']);
        view()->share('dftype', $config['dftype']);
        view()->share("bid", $bid);
        view()->share("sid", $sid);
        return view('manage.mclass.classlist');
    }

    public function mclasseditc(Request $request){
        $gid = $request->input('gid','');
        $arr = $request->input('arr','');
        $arr = str_replace('\\', '', $arr);
        $arr = json_decode($arr, true);
        $arrc = count($arr);
        $db = Db::connection();
        $game = Game::where('gid',$gid)->select(['mtype'])->first();
        $config['mtype'] = json_decode($game['mtype'], true);
        for ($i = 0; $i < $arrc; $i++) {
            $name = $arr[$i]['name'];
            $cs = $arr[$i]['cs'];
            $ifok = $arr[$i]['ifok'];
            $xsort = $arr[$i]['xst'];
            $xshow = $arr[$i]['xshow'];
            $one = $arr[$i]['one'];
            $cid = $arr[$i]['cid'];
            $bid = trim($arr[$i]['bid']);
            $sid = trim($arr[$i]['sid']);
            $mtype = ComFunc::mtype(trim($arr[$i]['mtype']),$config['mtype']);
            $dftype = $arr[$i]['dftype'];
            $ftype = $arr[$i]['ftype'];
            $sql = "update x_class set name='$name',cs='$cs',one='$one',ifok='$ifok',xsort='$xsort',bid='$bid',sid='$sid',mtype='$mtype',dftype='$dftype',ftype='$ftype',xshow='$xshow' where cid='$cid' and gid='$gid' ";
            $db->update($sql);
        }
        return 1;
    }

    public function mclassgets(Request $request){
        $bid = $request->input('bid','');
        $gid = $request->input('gid','');
        $s = Sclass::where(['gid'=>$gid,'bid'=>$bid])->select(['sid','name','ifok','xsort'])->orderBy('xsort')->get();
        echo json_encode($s);
    }

    public function mclassgetc(Request $request){
        $bid = $request->input('bid','');
        $sid = $request->input('sid','');
        $gid = $request->input('gid','');
        $s = Mclass::where(['gid'=>$gid,'bid'=>$bid,'sid'=>$sid])->select(['cid','name'])->orderBy('xsort')->get();
        return response()->json($s);
    }

    public function mclassaddc(Request $request){
        $name = $request->input('name','');
        $bid = $request->input('bid','');
        $sid = $request->input('sid','');
        $gid = $request->input('gid','');
        $cid = ComFunc::setupid('x_class', 'cid');
        Mclass::create(['gid'=>$gid,'bid'=>$bid,'sid'=>$sid,'name'=>$name,'mtype'=>0,'dftype'=>0,'ftype'=>0,'ifok'=>1,'xsort'=>0,'cid'=>$cid]);
        return 1;
    }

    public function mclassdelc(Request $request){
        $idstr = $request->input('idstr','');
        $gid = $request->input('gid','');
        $db = Db::connection();
        $sql = "delete from x_class where instr('$idstr',cid) and gid='$gid'";
        $db->delete($sql);
        return 1;
    }

    public function playshow(Request $request){
        $bid = $request->input('bid','');
        $sid = $request->input('sid','');
        $cid = $request->input('cid','');
        $gid = $request->input('gid','');
        $lotterys = Game::where('ifopen', 1)->select(['gname','gid'])->orderBy('xsort')->get();
        view()->share("lotterys", $lotterys->toArray());
        if(empty($gid)){
            $gid = $lotterys[0]['gid'];
        }
        view()->share("gid", $gid);
        $db = Db::connection();
        $game = Game::where('gid',$gid)->select(['ztype','patt'])->first();
        $config['ztype'] = json_decode($game["ztype"],true);
        $config['ptype'] = json_decode($game["patt"],true);
        if ($bid != '' && $sid != '' && $cid != '') {
            $list = $db->select("select * from x_play where gid='$gid' and bid='$bid' and sid='$sid' and cid='$cid' order by xsort limit 200");
        } else if ($bid != '' && $sid != '') {
            $list = $db->select("select * from x_play where gid='$gid' and  bid='$bid' and sid='$sid' order by xsort limit 200");
        } else if ($bid != '') {
            $list = $db->select("select * from x_play where gid='$gid' and  bid='$bid' order by xsort limit 200");
        } else {
            $list = $db->select("select * from x_play where gid='$gid' order by xsort limit 200");
        }
        $p = array();
        $temp = array();
        foreach ($list as $i=>$v){
            $p[$i]['bid'] = $v['bid'];
            if(!isset($temp['b'.$v['bid']])){
                $temp['b'.$v['bid']] = CsFunc::transb($v['gid'],'name', $v['bid']);
            }
            $p[$i]['bname'] = $temp['b'.$v['bid']];
            $p[$i]['sid']   = $v['sid'];
            if(!isset($temp['s'.$v['sid']])){
                $temp['s'.$v['sid']] = CsFunc::transs($v['gid'],'name', $v['sid']);
            }
            $p[$i]['sname'] = $temp['s'.$v['sid']];
            $p[$i]['cid']   = $v['cid'];
            if(!isset($temp['c'.$v['cid']])){
                $temp['c'.$v['cid']] = CsFunc::transc($v['gid'],'name', $v['cid']);
            }
            $p[$i]['cname'] = $temp['c'.$v['cid']];
            $p[$i]['pid'] = $v['pid'];
            $p[$i]['name']   = $v['name'];
            $p[$i]['ifok']   = $v['ifok'];
            $p[$i]['xsort']  = $v['xsort'];
            $p[$i]['peilv1'] = $v['peilv1'];
            $p[$i]['ztype']  = $config['ztype'][$v['ztype']];
            $p[$i]['znum1']  = $v['znum1'];
            $p[$i]['znum2']  = $v['znum2'];
            $p[$i]['ptype']  = $v['ptype'];
            $p[$i]['cy']  = $v['cy'];
        }
        view()->share('p', $p);
        view()->share("b", Bclass::where('gid',$gid)->select(['bid','name'])->orderBy('xsort')->get());
        $s = [];
        if ($bid != '') {
            $s = Sclass::where(['gid'=>$gid,'bid'=>$bid])->select(['sid','name'])->orderBy('xsort')->get();
        }
        view()->share("s", $s);
        $c = [];
        if ($bid != '' and $sid != '') {
            $c = Mclass::where(['gid'=>$gid,'bid'=>$bid,'sid'=>$sid])->select(['cid','name'])->orderBy('xsort')->get();
        }
        view()->share("c", $c);
        view()->share("ztype", $config['ztype']);
        view()->share("ptype", $config['ptype']);
        view()->share('bid', $bid);
        view()->share('sid', $sid);
        view()->share('cid', $cid);
        return view('manage.mclass.play');
    }

    public function playeditplay(Request $request){
        $gid = $request->input('gid','');
        $str = $request->input('str','');
        $arr = str_replace('\\', '', $str);
        $arr = json_decode($arr, true);
        $ca  = count($arr);
        $db = Db::connection();
        $game = Game::where('gid',$gid)->select('ztype')->first();
        $config['ztype'] = json_decode($game["ztype"],true);
        for ($i = 0; $i < $ca; $i++) {
            $bid    = trim($arr[$i]['bid']);
            $sid    = trim($arr[$i]['sid']);
            $cid    = trim($arr[$i]['cid']);
            $name   = $arr[$i]['name'];
            $ztype  = ComFunc::ztype(trim($arr[$i]['ztype']),$config['ztype']);
            $peilv1 = $arr[$i]['peilv1'];
            $mp1 = $arr[$i]['peilv1'];
            $znum1  = $arr[$i]['znum1'];
            $znum2  = $arr[$i]['znum2'];
            $pid    = $arr[$i]['pid'];
            $ifok   = $arr[$i]['ifok'];
            $xsort  = $arr[$i]['xs'];
            $ptype = $arr[$i]['ptype'];
            $cy = $arr[$i]['cy'];

            $sql = "update x_play set cy='$cy',bid='$bid',sid='$sid',cid='$cid',name='$name',ztype='$ztype',znum1='$znum1',znum2='$znum2',peilv1='$peilv1',mp1='$mp1'";
            $sql .= ",ifok='$ifok',xsort='$xsort',ptype='$ptype' where pid='$pid' and gid='$gid'";
            $db->update($sql);
        }
       return 1;
    }

    public function playaddplay(Request $request){
        $db = Db::connection();
        $gid = $request->input('gid','');
        $game = Game::where('gid',$gid)->select(['ztype','ptype'])->first();
        $ztype = json_decode($game["ztype"],true);
        $bid    = $_POST['bid'];
        $sid    = $_POST['sid'];
        $cid    = $_POST['cid'];
        $name   = $_POST['name'];
        $ztype  = ComFunc::ztype(trim($_POST['ztype']),$ztype);
        $peilv1 = $_POST['peilv1'];
        $znum1  = $_POST['znum1'];
        $znum2  = $_POST['znum2'];
        $pid    = ComFunc::setupid('x_play', 'pid');
        $sql    = "insert into x_play set gid='$gid',bid='$bid',sid='$sid',cid='$cid',name='$name',ztype='$ztype',znum1='$znum1',znum2='$znum2',peilv1='$peilv1'";
        $sql .= ",pid='$pid',ifok=1,xsort=0";
        $db->insert($sql);
        return 1;
    }

    public function playdelplay(Request $request){
        $gid = $request->input('gid','');
        $idstr = $request->input('idstr','');
        $db = Db::connection();
        $sql = "delete from x_play where instr('$idstr',pid) and gid='$gid'";
        $db->delete($sql);
        return 1;
    }
}

































