<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Game;
use App\Models\Game\Lib;
use App\Models\Game\News;
use App\Models\Game\User;
use App\Models\Game\Warn;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\sgwin\Json;
use Illuminate\Http\Request;

class NoticeController extends ManageAuthController
{
   public function list(Request $request){

       $news = News::with(['admin'])->orderBy('time','desc')->paginate(20);
       foreach ($news as $k=>$v){
           $news[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
           $news[$k]['adminname'] = $v['admin']['adminname'] ?? '';
           //状态agent 0：全部 1：代理 2：会员
           if($v['agent'] == 0){
               $news[$k]['agentstr'] = '全部可见';
           }elseif($v['agent'] == 1){
               $news[$k]['agentstr'] = '代理可见';
           }elseif($v['agent'] == 2){
               $news[$k]['agentstr'] = '会员可见';
           }
           //是否可用
           if($v['ifok'] == 1){
               $news[$k]['ifokstr'] = '可用';
           }else{
               $news[$k]['ifokstr'] = '禁用';
           }
           //是否弹窗
           if($v['alert'] == 1){
               $news[$k]['alertstr'] = '弹窗';
           }else{
               $news[$k]['alertstr'] = '不弹窗';
           }
           //是否滚动
           if($v['gundong'] == 1){
               $news[$k]['gundongstr'] = '滚动';
           }else{
               $news[$k]['gundongstr'] = '不滚动';
           }
       }
       view()->share('list',$news);
       return view('managev1.notice.list');
   }

   public function save(Request $request){
        $agent = $request->input('agent',0);
        $content = $request->input('content','');
        $id = $request->input('id',0);
        $ifok = $request->input('ifok',1);
        $alert = $request->input('alert',1);
        $gundong = $request->input('gundong',0);
        $content = str_replace(array("\r\n", "\r", "\n"), "", $content);
        if(empty($id)){
            $save['content'] = $content;
            $save['time'] = time();
            $save['ifok'] = $ifok;
            $save['alert'] = $alert;
            $save['gundong'] = $gundong;
            //$save['adminid'] = $this->adminid;
            $save['agent'] = $agent;
            $res = News::create($save);
            if($res){
                return Json::success('保存成功');
            }else{
                return Json::error('保存失败');
            }
        }else{
            $save['content'] = $content;
            $save['agent'] = $agent;
            $save['ifok'] = $ifok;
            $save['alert'] = $alert;
            $save['gundong'] = $gundong;
            News::where('id',$id)->update($save);
            return Json::success('保存成功');
        }
   }

   public function delete(Request $request){
        $id = $request->input('id',0);
        if(empty($id)){
            return Json::error('参数错误');
        }
        $res = News::where('id',$id)->delete();
        if($res){
            return Json::success('删除成功');
        }else{
            return Json::error('删除失败');
        }
   }
}
