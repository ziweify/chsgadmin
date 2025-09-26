<?php

namespace App\Http\Controllers\Manage;

use App\Common\Task\TaskOutbet;
use App\Common\TaskSwoole\PlatCreateQueue;
use App\ComServices\BuilderResultImage;
use App\ComServices\CmdBingo;
use App\ComServices\GameServices;
use App\Models\Game\Game;
use App\Models\Game\Gamemsg;
use App\Models\Game\Online;
use App\Models\Game\User;
use App\Models\Game\Userreg;
use App\Models\Game\Userroom;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\HttpUtils;
use App\ort\services\AutosService;
use App\ort\services\SearchqishuService;
use App\ort\sgwin\SGUtils;
use App\Services\UploadService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController
{
    public function test(Request $request){
        //AutosService::checkkj(444);
        //SGUtils::dotask();
        //AutosService::deleteOpenImg();//
        /*echo 'test';
        $fenlei = 444;
        $gid = 444;
        $qishu = 113053902;
        $ruid = 100000024;
        $roomConfig = Userroom::where(['userid'=>$ruid])->first();
        $kjhm = ['32','06','17','07','20'];
        $fields = ['lotCode','cs','mtype','ztype','gid','fast','mnum','fenlei','ifopen','autokj','guanfang','ctype','gname'];
        $game = Game::where(['gid'=>$gid])->select($fields)->first();
        $mtype = json_decode($game['mtype'], true);
        $ztype = json_decode($game['ztype'], true);
        $cs = json_decode($game['cs'], true);
        $res = CsFunc::calc($fenlei,$gid,$kjhm,$cs,$qishu,$ztype,$mtype,$ruid,$roomConfig);
        dump($res);*/
        //获取public/avatar所有文件上传到阿里云oss
        /*$files = scandir(public_path('avatar'));
        $i = 0;
        foreach ($files as $filename){
            if($i == 1){
                break;
            }
            if($filename == '.' || $filename == '..'){
                continue;
            }
            $path = public_path('avatar/'.$filename);
            $file = new \Illuminate\Http\UploadedFile($path,$filename);
            $disk = Storage::disk('oss');
            $url = "/upload/defaultavatar/".$filename;
            $disk->put($url,$file->getContent());
            //$i++;
        }*/
        /* echo '开始输出';
        $url = 'http://127.0.0.1:5001/user/token';
        $postdata = ['uid'=>'100000030','token'=>'123456','device_flag'=>1,'device_level'=>1];
        $res = HttpUtils::request('POST',$url,$postdata,[],true);
        var_dump($res);
        echo '结束输出';// */
        /* $gid = 444;
        $fenlei = 444;
        $game = Game::where(['gid'=>$gid])->first();
        $dates = '2024-09-20';
        $dstr = str_replace('-','',$dates);
        $openlist = (new GameServices())->lastOpenDataList($gid,$fenlei,5,31);
        BuilderResultImage::doSaveOpenImg($gid,$fenlei,$openlist,$game['ctype'],'openlist','openlist',1111,$dstr);  */
        //(new TaskOutbet())->run();
        /* $url = "https://dj16888.fr.cvv66.top/frclienthall/getmoneyinfo";
        $postdata = ['uuid'=>'','sid'=>''];
        $res = HttpUtils::request('POST',$url,$postdata,[],false);
        var_dump($res); */
        $content = "1小虎100";
        
        // 测试新的解析逻辑
        $cmdBingo = new \App\ComServices\CmdBingo();
        $result = $cmdBingo->commandBetting($content, 0, true);
        // 输出结果
        var_dump($result);
        
        /* $glist = Game::where('id','>',0)->select(['gid'])->get();
        $msgitem = [];
        $msgitem['keyname'] = "SubmitAfterBetting";
        $msgitem['msg_name'] = "下注成功后回复";
        $msgitem['msg_content'] = "";
        $msgitem['msg_time'] = 0;
        $msgitem['remark'] = "{游戏} 游戏名称{期号} 表示当期期号{账单}表示下注玩法列表{金额}表示下注金额{余额}表示当前用户余额";
        $msgitem['is_time'] = 0;
        $msgitem['ifok'] = 1;
        //查询房主
        $list = User::whereIn('type',[1,2])->select(['userid'])->get();
        foreach($list as $item){
            foreach($glist as $game){
                $gamemsg = Gamemsg::where(['ruid'=>$item['userid'],'gid'=>$game['gid'],'keyname'=>$msgitem['keyname']])->first();
                if(empty($gamemsg)){
                    $msgitem['ruid'] = $item['userid'];
                    $msgitem['gid'] = $game['gid'];
                    //插入
                    Gamemsg::insert($msgitem);
                }
            }
        } */
        //$this->testSendItem($request);


        //新增online表，然后需要查询userbiao数据插入到online表中
        $ulist = User::where('id','>',0)->select(['ruid','userid','online','type','lastOnlineTime','robot'])->get();
        foreach($ulist as $item){
            //判断是否存在
            $online = Online::where(['ruid'=>$item['ruid'],'userid'=>$item['userid']])->first();
            if(empty($online)){
                $online = new Online();
                $online->ruid = $item['ruid'];
                $online->userid = $item['userid'];
                $online->online = $item['online'];
                $online->lastOnlineTime = $item['lastOnlineTime'];
                $online->type = $item['type'];
                $online->robot = $item['robot'];
                $online->save();
            }
        }
    }


    //测试发送物品接口
    public function testSendItem(Request $request){
        // 获取请求参数，设置默认值
        $page = $request->input('page', 1); // 指定第几页
        $count = $request->input('count', 1);
        $limit = 100; // 每页100条物品
        
        try {
            // 获取物品总数
            $firstPageUrl = "https://qiub.net/api/player/f3d4e344/65b89a0c/1/prop?page=1&limit=1";
            $firstResponse = HttpUtils::request('GET', $firstPageUrl, [], [], false);
            $firstData = json_decode($firstResponse['data'], true);
            
            if (!isset($firstData['count'])) {
                return response()->json(['code' => 500, 'message' => '获取物品总数失败']);
            }
            
            $totalItems = $firstData['count'];
            $totalPages = ceil($totalItems / $limit);
            
            // 验证页码是否有效
            if ($page < 1 || $page > $totalPages) {
                return response()->json([
                    'code' => 400, 
                    'message' => "页码无效，有效范围：1-{$totalPages}",
                    'data' => [
                        'total_items' => $totalItems,
                        'total_pages' => $totalPages,
                        'requested_page' => $page
                    ]
                ]);
            }
            
            echo "总物品数: {$totalItems}, 总页数: {$totalPages}, 当前处理第 {$page} 页\n";
            
            // 获取指定页的物品列表
            $url = "https://qiub.net/api/player/f3d4e344/65b89a0c/1/prop?page={$page}&limit={$limit}";
            $response = HttpUtils::request('GET', $url, [], [], false);
            $data = json_decode($response['data'], true);
            
            if (!isset($data['data']) || !is_array($data['data'])) {
                return response()->json([
                    'code' => 500, 
                    'message' => "第 {$page} 页获取数据失败"
                ]);
            }
            
            $items = $data['data'];
            echo "第 {$page} 页获取到 " . count($items) . " 条物品\n";
            
            // 构建发送物品的请求数据
            $sendData = [
                'type' => 'prop',
                'items' => []
            ];
            
            foreach ($items as $item) {
                $sendData['items'][] = [
                    'prop_id' => $item['prop_id'],
                    'name' => $item['name'],
                    'count' => (string)$count
                ];
            }
            
            // 发送物品
            $sendUrl = "https://qiub.net/api/player/f3d4e344/65b89a0c/1/seed";
            $sendResponse = HttpUtils::request('POST', $sendUrl, $sendData, [], true);
            $sendResult = json_decode($sendResponse['data'], true);
            
            if (isset($sendResult['code']) && $sendResult['code'] == 200) {
                echo "第 {$page} 页发送成功\n";
                $success = true;
                $message = "第 {$page} 页物品发送成功";
            } else {
                echo "第 {$page} 页发送失败: " . json_encode($sendResult) . "\n";
                $success = false;
                $message = "第 {$page} 页物品发送失败";
            }
            
            $result = [
                'code' => $success ? 200 : 500,
                'message' => $message,
                'data' => [
                    'total_items' => $totalItems,
                    'total_pages' => $totalPages,
                    'current_page' => $page,
                    'items_in_current_page' => count($items),
                    'count_per_item' => $count,
                    'send_success' => $success,
                    'send_response' => $sendResult
                ]
            ];
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => '发送物品过程中发生错误: ' . $e->getMessage()
            ]);
        }
    }
}













