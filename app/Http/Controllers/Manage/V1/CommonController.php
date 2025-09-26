<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\Models\Game\Admin;
use App\Models\Game\Game;
use App\Models\Game\Kj;
use App\Models\Game\News;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use App\ort\glob\IpUtils;
use App\ort\sgwin\AppJson;
use App\ort\sgwin\HtService;
use App\ort\sgwin\SGUtils;
use App\ort\sgwin\UserOnline;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CommonController extends ManageAuthController
{


    public function logout(Request $request){
        $admin = $this->adminInfo;
        UserOnline::deleteUserOnlineInfo($admin['adminid']);
        Session::remove('adminInfo');
        Session::remove('adminid');
        //如果域名是ip地址，就用http://ip:port的形式
        $domain = $request->server('HTTP_HOST');
        //去掉端口号
        $domain = explode(':',$domain)[0];
        if(filter_var($domain, FILTER_VALIDATE_IP)){
            $domain = 'http://'.$domain.':'.$request->server('SERVER_PORT');
            return redirect($domain.'/login');
        }else{
            return redirect('/login');
        }
    }

    //公告页面
    public function notices(Request $request){
        $pagesize = 10;
        $list = News::where('ifok',1)->where('agent',0)->orderByDesc('time')->paginate($pagesize);
        //计算总页数
        $total = $list->total();
        $totalPage = ceil($total/$pagesize);
        $list->totalPage = $totalPage;
        foreach ($list as &$item) {
            $item['time']    = date("Y-m-d H:i:s", $item['time']);
            //格式23-11-02 12:00:00
            $item['time'] = substr($item['time'],2);
        }
        view()->share('list', $list);
        return view('common.notices');
    }

    public function online(){
        $mylevel = Admin::where('adminid',$this->adminid)->value('level');
        $adminids = Admin::where(['ifhide'=>1])->orWhere('level','<=',$mylevel)->pluck('adminid')->toArray();
       /* $count = Online::whereNotIn('userid', function ($query) use ($mylevel) {
            $query->select('adminid')->from('admins')->where(['ifhide'=>1])->orWhere('level','<=',$mylevel);
        })->count();*/
        $count = UserOnline::countOnlineUsers($adminids);
        echo "网页端：$count+APP：0总在线：$count";
    }

    //滚动公告
    public function notice(){
        $list = News::where(['gundong'=>1,'ifok'=>1])->where('agent',0)->select(['content'])->orderByDesc('time')->get();
        $cstr = '';
        foreach ($list as $item) {
            $cstr .= $item['content'];
        }
        echo $cstr;
    }

    //获取当前时间
    public function time(){
        //获取当期毫秒时间戳
        $time = explode(" ", microtime());
        $time = ($time[1] + $time[0]) * 1000;
        $time = round($time) . '';
        return $time;
    }

    public function accounts(){
        $list = [];
        $userid = $this->uid;
        $jrsy = ComFunc::getjrsy($userid);
        $list[0]['balance'] = 0;
        $list[0]['maxLimit'] = 0;
        $list[0]['result'] = $jrsy;
        $list[0]['type'] = 0;
        $list[1] = ['balance'=>0,'maxLimit'=>0,'type'=>1];
        $list[2] = ['balance'=>0,'maxLimit'=>0,'type'=>2];
        return response()->json($list)->content();
    }

    public function dresult(Request $request){
        $lottery = $request->get('lottery','');
        $game = Game::where('lottery',$lottery)->select(['gid','fenlei','mnum','template'])->first();
        $date = $request->get('date','');
        $qishu = $request->get('drawNumber','');
        if(empty($date)){
            $editend = x_config('editend');
            if (date("His") < str_replace(':', '',$editend)) {
                $date = date("Y-m-d", time() - 86400);
            } else {
                $date = date("Y-m-d");
            }
        }
        $model = Kj::where(['gid'=>$game['gid'],'status'=>1]);
        if (!empty($qishu)) {
            $model->where('qishu', $qishu);
        }
        $kjlist = $model->where('dates',strtotime($date))->orderByDesc('qishu')->get();
        $list = HtService::getopendatadata($kjlist,$game);
        view()->share('fenlei',$game['fenlei']);
        view()->share('lottery',$lottery);
        view()->share('list',$list);
        $lotterys = Game::whereIn('gid', function ($query){
            $query->select('gid')->from('gamecs')->where(['userid'=>$this->uid,'ifok'=>1]);
        })->where('ifopen', 1)->select(['gname','lottery','xsort'])->orderBy('xsort')->get();
        view()->share('lotterys',$lotterys);
        $template = $game['template'];
        view()->share('template',$template);
        view()->share('date',$date);
        return view('common.dresult');
    }

    public function create_randip(Request $request){
        $ipcity = $request->get('ipcity','');
        if(empty($ipcity)){
            return response()->json(['ip'=>'','address'=>'']);
        }
        $ip = SGUtils::create_randip($ipcity);
        $address = IpUtils::getaddrbyip($ip);
        return response()->json(['ip'=>$ip,'address'=>$address]);
    }

    public function uploadimg(Request $request){
        //$path = $request->file('avatar')->store('avatars');
        $file = $request->file('avatar');
        if (!$file || !$file->isValid()) {
            return AppJson::error('请选择文件');
        }
        $headImageUploadMode = x_config('headImageUploadMode');
        //$headImageDomain = x_config('headImageDomain');
        $url = UploadService::upload($headImageUploadMode,$file,'avatar');
        return response()->json([
            'code' => 200,
            'message' => '上传成功',
            'data' => $url,
        ]);
    }
}
