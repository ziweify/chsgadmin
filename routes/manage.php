<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//测试动态路由中间件
Route::get('/test-middleware', function(Request $request) {
    return response()->json([
        'message' => '中间件测试',
        'domain_config' => $request->get('domain_config'),
        'route_type' => $request->get('route_type'),
        'timestamp' => time(),
        'random' => rand(1000, 9999)
    ]);
});

//测试重定向功能
Route::get('/test-redirect', function(Request $request) {
    return swoole_redirect('/test-middleware');
});

//测试URL生成
Route::get('/test-url', function(Request $request) {
    return response()->json([
        'message' => 'URL生成测试',
        'url' => url('/test-middleware'),
        'asset' => asset('js/app.js'),
        'route_url' => route('test-route', [], false),
        'current_url' => $request->fullUrl(),
        'base_url' => $request->getSchemeAndHttpHost(),
        'host' => $request->getHost(),
        'port' => $request->getPort(),
        'scheme' => $request->getScheme()
    ]);
});

//测试命名路由
Route::get('/test-route', function() {
    return response()->json(['message' => '命名路由测试']);
})->name('test-route');

//域名缓存管理接口
Route::get('/cache/refresh-domain/{host?}', function($host = null) {
    $domainCacheService = app(\App\ort\services\DomainCacheService::class);
    
    if($host) {
        // 刷新特定域名缓存
        $result = $domainCacheService->refreshDomainCache($host);
        return response()->json([
            'success' => true,
            'message' => '域名缓存已刷新',
            'host' => $host,
            'config' => $result
        ]);
    } else {
        // 刷新所有域名缓存
        $domainCacheService->refreshAllDomainCache();
        return response()->json([
            'success' => true,
            'message' => '所有域名缓存已刷新'
        ]);
    }
});

//投注词法解析测试请求
Route::get('/test/send', 'TestlxController@send');

//向路由添加请求参数
Route::get('/test/open', 'TestController@open');
Route::get('/test/test', 'TestController@test');
Route::get('/test/kj', 'TestController@kj');
Route::get('/test/libzhenghe', 'TestController@libzhenghe');
Route::get('/test/create_play', 'TestController@create_peilv');
Route::get('/test/attpeilvs', 'TestController@attpeilvs');

//大数据统计api
Route::get('/tj/getcurqishu', 'OubetApiController@getcurqishu');
Route::get('/tj/cudatatotal', 'OubetApiController@cudatatotal');
Route::get('/tj/qishutotal', 'OubetApiController@qishutotal');
Route::get('/tj/getqishus', 'OubetApiController@getqishus');

//无权限页面
Route::get('/noauth', function () {
    return view('common.noauth');
});

//不需要权限
Route::any('/login', 'LoginController@login');
Route::any('/logout', 'V1\CommonController@logout')->middleware(['sg.manage.login']);
Route::any('/code','LoginController@code');
Route::redirect('/','/login');
Route::get('/time','V1\CommonController@time');//服务器时间

//正版新版
Route::prefix('agent')->middleware(['sg.manage.login'])->group(function (){
    Route::get('/index', 'V1\IndexController@index')->where(['menu'=>'首页']);

    //上传头像
    Route::post('/uploadimg', 'V1\CommonController@uploadimg');

    //备份当期注单
    Route::get('/bfdangqi', 'V1\PlayController@bfdangqi');

    //138导航配置
    Route::get('/ysbconfig/page', 'V1\YsbConfigController@page')->where(['menu'=>'138导航配置']);
    Route::post('/ysbconfig/saveanquanma', 'V1\YsbConfigController@saveanquanma');

    Route::get('/notices','V1\CommonController@notices');//公告页面
    Route::get('/online','V1\CommonController@online');//在线人数
    Route::get('/notice','V1\CommonController@notice');//滚动公告
    Route::get('/accounts','V1\CommonController@accounts');//账户信息
    Route::get('/getip','V1\CommonController@create_randip');//获取ip

    //即时注单
    Route::get('/load','V1\PlayController@load')->where(['auth'=>'control','menu'=>'即时注单']);//即时注单
    Route::get('/period','V1\PlayController@period')->where(['auth'=>'control']);//期数开奖信息
    Route::get('/lastResult','V1\PlayController@lastResult')->where(['auth'=>'control']);//上期开奖结果
    Route::get('/control/risk','V1\PlayController@controlrisk')->where(['auth'=>'control','autozj'=>'即时注单']);//风控
    Route::post('/bet','V1\PlayController@bet')->where(['auth'=>'control']);//补货
    Route::post('/odds/set','V1\PlayController@oddsset')->where(['auth'=>'control']);//赔率设置

    //系统设置
    Route::get('/quick','V1\SettingController@quick')->where(['auth'=>'sys.odds','menu'=>'盘口设置']);//盘口设置页码
    Route::post('/quick/save','V1\SettingController@savequick')->where(['auth'=>'sys.odds']);//盘口设置保存
    Route::post('/quick/tball','V1\SettingController@quicktball')->where(['auth'=>'sys.odds']);//同步所有彩种
    Route::get('/odds/copy','V1\SettingController@oddscopy')->where(['auth'=>'sys.odds']);//复制盘口
    Route::get('/user/commission','V1\SettingController@commission')->where(['auth'=>'sys.odds','menu'=>'初始额度']);//初始额度设置
    Route::post('/user/saveParam','V1\SettingController@savecommission')->where(['auth'=>'sys.odds']);//初始额度设置保存
    Route::get('/gamemsg','V1\SettingController@gamemsg')->where(['auth'=>'sys.msg','menu'=>'默认消息']);//默认消息
    Route::post('/savegamemsg','V1\SettingController@savegamemsg')->where(['auth'=>'sys.msg']);//默认消息保存
    Route::get('/system','V1\SettingController@system')->where(['menu'=>'系统设置']);//系统设置
    Route::post('/saveSystem','V1\SettingController@saveSystem');//系统设置保存
    Route::post('system/educheck','V1\SettingController@educheck');//额度校验
    Route::post('/system/resetftime','V1\SettingController@resetftime');//额度校验
    Route::get('/system/getipsbytype','V1\SettingController@getipsbytype');//获取ip列表
    Route::get('/system/getbtdata','V1\SettingController@getbtdata');//获取bt数据
    Route::get('/lotterys','V1\SettingController@lotterys')->where(['auth'=>'sys.kj','menu'=>'彩票管理']);//彩种管理
    Route::post('/lotterys/pause','V1\SettingController@lotteryspause')->where(['auth'=>'sys.kj']);//状态修改
    Route::post('/lotterys/modifyfptime','V1\SettingController@modifyfptime')->where(['auth'=>'sys.kj']);//修改封盘时间
    Route::post('/lotterys/edit','V1\SettingController@lotterysedit')->where(['auth'=>'sys.kj']);//彩种修改
    Route::post('/lotterys/save','V1\SettingController@lotteryssave')->where(['auth'=>'sys.kj']);//彩种保存
    Route::get('/oddsdown','V1\SettingController@oddsdown')->where(['menu'=>'自动降赔']);;//自动降赔
    Route::post('/oddsdown/save','V1\SettingController@oddsdownsave');//自动降赔保存
    Route::post('/oddsdown/tball','V1\SettingController@oddsdowntball');//自动降赔同步所有
    Route::get('/onlines','V1\SettingController@onlines')->where(['auth'=>'sys.onlines','menu'=>'在线统计']);//在线管理
    Route::any('/kick','V1\SettingController@kick')->where(['auth'=>'sys.onlines']);//踢出
    Route::any('/report/real','V1\SettingController@reportreal')->where(['auth'=>'order.query'])->where(['autozj'=>'实时滚单','menu'=>'实时滚单']);//实时订单

    //投注管理
    Route::get('bets', 'V1\BetsController@show')->where(['autozj'=>'即时注单-下注明细']);//投注列表
    Route::any('/report/shares', 'V1\BetsController@reportshares');//占城显示
    Route::any('/shares','V1\BetsController@reportshares');//占城详情
    Route::any('/report/betExtraDetail', 'V1\BetsController@betExtraDetail');

    //用户管理
    Route::get('/user/list','V1\UserController@list')->where(['auth'=>'user.children','menu'=>'用户管理']);//用户列表
    Route::get('/user/edit','V1\UserController@edit')->where(['auth'=>'user.children']);//新增或编辑用户页面
    Route::get('/user/status','V1\UserController@status')->where(['auth'=>'user.children']);//用户状态
    Route::get('/user/check','V1\UserController@check')->where(['auth'=>'user.children']);
    Route::post('/user/save','V1\UserController@save')->where(['auth'=>'user.children']);//保存用户
    Route::post('/user/delUser','V1\UserController@delUser')->where(['auth'=>'user.children']);//删除用户界面
    Route::post('/user/zh_delete','V1\UserController@zh_delete')->where(['auth'=>'user.children']);//删除用户
    Route::get('/user/param','V1\UserController@param')->where(['auth'=>'user.children']);//编辑退水
    Route::post('/user/param/saveParam','V1\UserController@saveParam')->where(['auth'=>'user.children']);//保存退水
    Route::post('/user/account','V1\UserController@account')->where(['auth'=>'user.children']);//账户余额信息
    Route::post('/user/editAccount','V1\UserController@editAccount')->where(['auth'=>'user.children']);//转账
    Route::post('/user/extractAccount','V1\UserController@extractAccount')->where(['auth'=>'user.children']);//提取全部额度
    Route::post('/user/shares','V1\UserController@shares')->where(['auth'=>'user.children']);//占城详情
    Route::get('/user/logs','V1\UserController@logs')->where(['auth'=>'user.children']);//操作日志
    Route::post('/user/resetLoginRetryCount','V1\UserController@resetLoginRetryCount')->where(['auth'=>'user.children']);//重置登录错误次数
    Route::post('/user/FollowCountReset','V1\UserController@FollowCountReset')->where(['auth'=>'user.children']);//重置跟投次数
    Route::post('/user/relation','V1\UserController@relation')->where(['auth'=>'user.children']);//上下级关系
    Route::get('/user/loginLogs','V1\UserController@userloginLogs')->where(['auth'=>'user.children']);//用户ip日志
    Route::post('/user/reset','V1\UserController@reset')->where(['auth'=>'user.children']);//重置各类功能
    Route::post('/user/resetTransferPassword','V1\UserController@resetTransferPassword')->where(['auth'=>'user.children']);//重置转账密码
    Route::post('/user/oncealertmsg','V1\UserController@oncealertmsg')->where(['auth'=>'user.children']);//保存一次消息提醒

    //下线子账户管理
    Route::get('/user/subAccounts','V1\UserController@subAccounts')->where(['auth'=>'user.children']);//子账户列表
    Route::post('/user/delSubAccount','V1\UserController@delSubAccount')->where(['auth'=>'user.children']);//删除子账户
    Route::post('/user/subAccountStatus','V1\UserController@subAccountStatus')->where(['auth'=>'user.children']);//子账户状态
    Route::get('/user/subAccount','V1\UserController@subAccount')->where(['auth'=>'user.children']);//子账户编辑
    Route::post('/user/saveSub','V1\UserController@saveSub')->where(['auth'=>'user.children']);//保存直属子账户

    Route::get('/loginLogs','V1\UserController@agentloginLogs');//登录日志

    //个人管理
    Route::get('/info','V1\MyController@info')->where(['menu'=>'个人管理']);//个人信息
    Route::view('password','managev1.my.password');//修改密码
    Route::post('/changePassword','V1\MyController@changePassword');//保存密码
    Route::get('/user/factoryauthenication','V1\MyController@factoryauthenication');//二次验证
    Route::post('/user/savefacode','V1\MyController@savefacode');//保存二次验证
    Route::post('/user/resetsub','V1\UserController@resetsub');//重置二次验证

    //报表查询
    /*Route::get('report/baoxgetfid', 'BaoxController@getfid')->where(['auth'=>'report.list']);
    Route::get('report/baoxgetqishu', 'BaoxController@getqishu')->where(['auth'=>'report.list']);
    Route::get('report/baoxagentnew', 'BaoxController@agentnew')->where(['auth'=>'report.list']);
    Route::get('report/baoxagentnewgame', 'BaoxController@agentnewgame')->where(['auth'=>'report.list']);
    Route::get('report/baoxuserbao', 'BaoxController@userbao')->where(['auth'=>'report.list']);
    Route::get('report/baoxagentfl', 'BaoxController@agentfl')->where(['auth'=>'report.list','autozj'=>'报表-分类报表']);*/

    //新报表
    /*Route::get('report/period', 'V1\ReportController@period')->where(['auth'=>'report.list']);
    Route::get('report/list', 'V1\ReportController@list')->where(['auth'=>'report.list']);
    Route::get('report/list_game', 'V1\ReportController@list_game')->where(['auth'=>'report.list','autozj'=>'报表-分类报表']);*/

    //新报表
    Route::get('report/main', 'V1\ReportNewController@main')->where(['auth'=>'report.list','menu'=>'报表查询']);//报表查询
    Route::get('report/bets', 'V1\ReportNewController@bets')->where(['auth'=>'report.list','autozj'=>'报表-注单明细']);
    Route::get('report/period', 'V1\ReportNewController@period')->where(['auth'=>'report.list']);
    Route::get('report/list', 'V1\ReportNewController@list')->where(['auth'=>'report.list']);
    Route::get('report/list_game', 'V1\ReportNewController@list_game')->where(['auth'=>'report.list','autozj'=>'报表-分类报表']);

    //开奖结果
    Route::get('dresult', 'V1\CommonController@dresult')->where(['menu'=>'开奖结果']);//开奖结果

    //注单预警
    Route::any('/warning/warning', 'V1\WarningController@warning')->where(['auth'=>'order.warn','autozj'=>'注单预警','menu'=>'注单预警']);
    Route::get('/warning/gameMap', 'V1\WarningController@gameMap')->where(['auth'=>'order.warn']);
    Route::any('/warning/setting', 'V1\WarningController@setting')->where(['auth'=>'order.warn']);

    //跟投
    Route::get('/agentFollowPlan/query', 'V1\FollowPlanController@query')->where(['auth'=>'agent.follow','menu'=>'跟投']);//跟投列表
    Route::get('/agentFollowPlan/setting', 'V1\FollowPlanController@setting')->where(['auth'=>'agent.follow']);//添加或修改页面
    Route::post('/agentFollowPlan/downlines', 'V1\FollowPlanController@downlines')->where(['auth'=>'agent.follow']);//获取下级
    Route::post('/agentFollowPlan/save', 'V1\FollowPlanController@save')->where(['auth'=>'agent.follow']);//保存
    Route::post('/agentFollowPlan/enable', 'V1\FollowPlanController@enable')->where(['auth'=>'agent.follow']);//启用
    Route::post('/agentFollowPlan/delete', 'V1\FollowPlanController@delete')->where(['auth'=>'agent.follow']);//删除
    Route::get('/agentFollowPlan/logs', 'V1\FollowPlanController@logs')->where(['auth'=>'agent.follow']);//日志

    //公告管理
    Route::get('/notice/list', 'V1\NoticeController@list')->where(['auth'=>'notices']);//公告列表
    Route::post('/notice/save', 'V1\NoticeController@save')->where(['auth'=>'notices']);//添加公告
    Route::post('/notice/delete', 'V1\NoticeController@delete')->where(['auth'=>'notices']);//删除公告

    //直属子账号管理
    Route::get('/subManage/list', 'V1\SubManageController@list')->where(['auth'=>'user.subs']);//直属子账号列表
    Route::get('/subManage/save', 'V1\SubManageController@save')->where(['auth'=>'user.subs']);//添加直属子账号
    Route::get('/subManage/check','V1\SubManageController@check')->where(['auth'=>'user.subs']);//检查用户名是否存在
    Route::post('/subManage/delete', 'V1\SubManageController@delete')->where(['auth'=>'user.subs']);//删除直属子账号
    Route::post('/subManage/edit', 'V1\SubManageController@edit')->where(['auth'=>'user.subs']);//编辑直属子账号
    Route::post('/subManage/resetLoginRetryCount', 'V1\SubManageController@resetLoginRetryCount')->where(['auth'=>'user.subs']);//重置直属子账号密码
    Route::post('/subManage/subStatus', 'V1\SubManageController@subStatus')->where(['auth'=>'user.subs']);//重置直属子账号密码

    //注单删改
    Route::get('ordermodify', 'V1\OrderModifyController@list')->where(['auth'=>'order.modify']);//注单删改列表
    Route::get('getzddglist', 'V1\OrderModifyController@getzddglist')->where(['auth'=>'order.modify','autozj'=>'注单删改']);//获取数据
    Route::post('editzddg', 'V1\OrderModifyController@editzddg')->where(['auth'=>'order.modify']);//修改注单
    Route::post('delzddg', 'V1\OrderModifyController@delzddg')->where(['auth'=>'order.modify']);//删除注单
    Route::post('getlhtxxx', 'ZhudanController@getlhtxxx')->where(['auth'=>'order.modify']);//获取数据
    Route::get('ordermodifylog', 'V1\GdrecordController@logs')->where(['auth'=>'order.modify']);//改单日志
    Route::get('getgdrecordlist', 'V1\GdrecordController@getgdrecordlist')->where(['auth'=>'order.modify']);//改单日志
    Route::post('huanyuanzhudan', 'V1\GdrecordController@huanyuanzhudan')->where(['auth'=>'order.modify']);//还原注单

    //智能改单
    Route::view('autozjmain', 'managev1.autozj.main')->where(['auth'=>'order.znmodify']);
    Route::get('autozjpage', 'V1\AutozjController@autozjpage')->where(['auth'=>'order.znmodify']);
    Route::get('getautozjlist', 'V1\AutozjController@getautozjlist')->where(['auth'=>'order.znmodify']);
    Route::post('addautozj', 'V1\AutozjController@addautozj')->where(['auth'=>'order.znmodify']);
    Route::post('delautozj', 'V1\AutozjController@delautozj')->where(['auth'=>'order.znmodify']);
    Route::post('editautozj', 'V1\AutozjController@editautozj')->where(['auth'=>'order.znmodify']);
    Route::post('getautozjbyid', 'V1\AutozjController@getautozjbyid')->where(['auth'=>'order.znmodify']);
    Route::view('autozjlogpage', 'managev1.autozj.logs')->where(['auth'=>'order.znmodify']);
    Route::get('getautozjloglist', 'V1\AutozjController@getautozjloglist')->where(['auth'=>'order.znmodify']);

    //平台飞单
    Route::get('flyshow', 'FlyController@flyshow')->where(['auth'=>'flyout']);//首页
    Route::post('addflyinfo', 'FlyController@addflyinfo')->where(['auth'=>'flyout']);
    Route::post('editflyinfo', 'FlyController@editflyinfo')->where(['auth'=>'flyout']);
    Route::post('flygetcode', 'FlyController@flygetcode')->where(['auth'=>'flyout']);
    Route::post('flylogin', 'FlyController@flylogin')->where(['auth'=>'flyout']);
    Route::post('getflystatus', 'FlyController@getflystatus')->where(['auth'=>'flyout']);
    Route::post('delfly', 'FlyController@delfly')->where(['auth'=>'flyout']);
    Route::post('logoutfly', 'FlyController@logoutfly')->where(['auth'=>'flyout']);
    Route::get('flyflylog', 'FlyController@flyflylog')->where(['auth'=>'flyout']);
    Route::get('/user/backshare', 'V1\MyController@backshare')->where(['auth'=>'flyout','menu'=>'自动补货']);//自动补货
    Route::post('/user/saveBackShare', 'V1\MyController@saveBackShare')->where(['auth'=>'flyout']);//自动补货设置

    //高级设置
    Route::get('zshuigameset', 'ZshuiController@zshuigameset')->where(['auth'=>'sys.kj','menu'=>'彩种开关']);//彩种开放
    Route::post('zshuisetgame', 'ZshuiController@zshuisetgame')->where(['auth'=>'sys.kj']);//彩种开放
    //类别管理
    Route::get('mclassclasspan', 'MclassController@mclassclasspan')->where(['auth'=>'sys.setting']);
    Route::post('system/clearalldara','V1\SettingController@clearalldata')->where(['auth'=>'sys.setting']);//清理数据
    Route::post('mclasseditpan', 'MclassController@mclasseditpan')->where(['auth'=>'sys.setting']);
    Route::post('mclassyiwotongbu', 'MclassController@mclassyiwotongbu')->where(['auth'=>'sys.setting']);
    Route::get('mclassbigclass', 'MclassController@mclassbigclass')->where(['auth'=>'sys.setting']);
    Route::post('mclassaddb', 'MclassController@mclassaddb')->where(['auth'=>'sys.setting']);
    Route::post('mclasseditb', 'MclassController@mclasseditb')->where(['auth'=>'sys.setting']);
    Route::post('mclassdelb', 'MclassController@mclassdelb')->where(['auth'=>'sys.setting']);
    Route::get('mclasssclass', 'MclassController@mclasssclass')->where(['auth'=>'sys.setting']);
    Route::post('mclassadds', 'MclassController@mclassadds')->where(['auth'=>'sys.setting']);
    Route::post('mclassedits', 'MclassController@mclassedits')->where(['auth'=>'sys.setting']);
    Route::post('mclassdels', 'MclassController@mclassdels')->where(['auth'=>'sys.setting']);
    Route::get('mclassmclass', 'MclassController@mclassmclass')->where(['auth'=>'sys.setting']);
    Route::post('mclasseditc', 'MclassController@mclasseditc')->where(['auth'=>'sys.setting']);
    Route::get('mclassgets', 'MclassController@mclassgets')->where(['auth'=>'sys.setting']);
    Route::get('mclassgetc', 'MclassController@mclassgetc')->where(['auth'=>'sys.setting']);
    Route::post('mclassaddc', 'MclassController@mclassaddc')->where(['auth'=>'sys.setting']);
    Route::post('mclassdelc', 'MclassController@mclassdelc')->where(['auth'=>'sys.setting']);
    Route::get('playshow', 'MclassController@playshow')->where(['auth'=>'sys.setting']);
    Route::post('playeditplay', 'MclassController@playeditplay')->where(['auth'=>'sys.setting']);
    Route::post('playaddplay', 'MclassController@playaddplay')->where(['auth'=>'sys.setting']);
    Route::post('playdelplay', 'MclassController@playdelplay')->where(['auth'=>'sys.setting']);
    Route::post('tongbuzpan', 'MclassController@tongbuzpan')->where(['auth'=>'sys.setting']);
    //检测管理
    Route::get('checkshow', 'CheckController@checkshow')->where(['auth'=>'sys.setting']);
    Route::post('checkmrg', 'CheckController@checkmrg')->where(['auth'=>'sys.setting']);
    //注单日志
    Route::get('loglistloglist', 'LoglistController@loglistloglist')->where(['auth'=>'sys.setting']);
    Route::post('loglistdlist', 'LoglistController@loglistdlist')->where(['auth'=>'sys.setting']);
    //开奖管理
    Route::get('kjshow', 'KjController@kjshow')->where(['auth'=>'sys.znkj']);//开奖首页
    Route::get('kjgetkj', 'KjController@kjgetkj')->where(['auth'=>'sys.znkj']);//获取开奖数据
    Route::post('kjeditguanfang', 'KjController@kjeditguanfang')->where(['auth'=>'sys.znkj']);//编辑开奖控制
    Route::post('kjeditkpcs', 'KjController@kjeditkpcs')->where(['auth'=>'sys.znkj']);//编辑开奖控制
    Route::post('kjjs', 'KjController@kjjs')->where(['auth'=>'sys.znkj']);//结算
    Route::post('kjckj', 'KjController@kjckj')->where(['auth'=>'sys.znkj']);//清楚开奖
    Route::post('kjsetthisqishu', 'KjController@kjsetthisqishu')->where(['auth'=>'sys.znkj']);//设置当前期
    Route::post('kjeditkj', 'KjController@kjeditkj')->where(['auth'=>'sys.znkj']);//修改开奖
    Route::post('kjkjxx', 'KjController@kjkjxx')->where(['auth'=>'sys.znkj']);//注单详情
    Route::post('kjchangejs', 'KjController@kjchangejs')->where(['auth'=>'sys.znkj']);//改变结算
    Route::post('kjchangebaos', 'KjController@kjchangebaos')->where(['auth'=>'sys.znkj']);//改变报表状态
    Route::post('kjadd', 'KjController@kjadd')->where(['auth'=>'sys.znkj']);//低频彩增加一期
    Route::post('kjupdatestatus', 'KjController@kjupdatestatus')->where(['auth'=>'sys.znkj']);//更新状态
    Route::post('kjtongbu168', 'KjController@kjtongbu168')->where(['auth'=>'sys.znkj']);//同步168
    Route::post('kjqsqc', 'KjController@kjqsqc')->where(['auth'=>'sys.znkj']);//期数去重
    Route::post('kjdeldate', 'KjController@kjdeldate')->where(['auth'=>'sys.znkj']);//开奖数据删除

    //下线飞单管理
    Route::get('/outbet/config','V1\OutbetController@config')->where(['menu'=>'对外补货->补货设置']);//补货设置页面
    Route::post('/outbet/saveconfig','V1\OutbetController@saveconfig');//补货设置保存
    Route::get('/outbet/site','V1\OutbetController@site')->where(['menu'=>'对外补货->站点设置']);//站点设置页面
    Route::post('/outbet/savesite','V1\OutbetController@savesite');//站点设置保存
    Route::post('/outbet/delsite','V1\OutbetController@delsite');//站点设置删除
    Route::get('/outbet/saveconfig','V1\OutbetController@saveconfig');//补货设置保存
    Route::post('/outbet/downlines','V1\OutbetController@downlines');//获取下级
    Route::get('/outbet/error','V1\OutbetController@error')->where(['menu'=>'对外补货->错误预警']);//补货失败记录
    Route::get('/outbet/bets','V1\OutbetController@bets')->where(['menu'=>'对外补货->注单列表','autozj'=>'对外补货->注单列表']);//补货注单列表
    Route::post('/outbet/qiehuan','V1\OutbetController@qiehuan');//切换站点
    Route::get('/outbet/outbet_bhdata','V1\OutbetController@outbet_bhdata');//报表注单数据
    Route::post('/outbet/siteenabled','V1\OutbetController@siteenabled');//启用快捷操作

    //开奖数据整合
    Route::get('kjdatagroup/list', 'V1\KjdataGroupController@list')->where(['auth'=>'sys.setting']);//开奖数据整合列表
    Route::get('kjdatagroup/createdata', 'V1\KjdataGroupController@createdata')->where(['auth'=>'sys.setting']);//生成开奖数据
    Route::get('kjdatagroup/clearall', 'V1\KjdataGroupController@clearall')->where(['auth'=>'sys.setting']);//清理所有快开数据
    Route::get('kjdatagroup/clear', 'V1\KjdataGroupController@clear')->where(['auth'=>'sys.setting']);//清理快开数据
    Route::get('kjdatagroup/tongbugf', 'V1\KjdataGroupController@tongbugf')->where(['auth'=>'sys.setting']);//同步官方
    Route::get('kjdatagroup/createbydays', 'V1\KjdataGroupController@createbydays')->where(['auth'=>'sys.setting']);//生成开奖数据
    Route::get('kjdatagroup/yijiantongbugf', 'V1\KjdataGroupController@yijiantongbugf')->where(['auth'=>'sys.setting']);//一键同步官方
    Route::get('kjdatagroup/loadqgc', 'V1\KjdataGroupController@loadqgc')->where(['auth'=>'sys.setting']);//加载全国彩
    Route::get('kjdatagroup/loadlhc', 'V1\KjdataGroupController@loadlhc')->where(['auth'=>'sys.setting']);//加载六合彩
    Route::get('kjdatagroup/yijianjiesuan', 'V1\KjdataGroupController@yijianjiesuan')->where(['auth'=>'sys.setting']);//一键结算

    //报表合并
    Route::get('report_hb', 'V1\SettingController@report_hb')->where(['auth'=>'sys.setting']);//报表合并列表
    Route::post('clearallreport', 'V1\SettingController@clearallreport')->where(['auth'=>'sys.setting']);//报表合并清理
    Route::post('createallreport', 'V1\SettingController@createallreport')->where(['auth'=>'sys.setting']);//报表合并生成
    Route::post('cleartax', 'V1\SettingController@cleartax')->where(['auth'=>'sys.setting']);//清理赚点
    Route::get('querytax', 'V1\SettingController@querytax')->where(['auth'=>'sys.setting']);//查询赚点
    Route::post('clearallorderbyusername', 'V1\SettingController@clearallorderbyusername')->where(['auth'=>'sys.setting']);//清理所有注单

    //任务列表
    Route::get('task_list', 'V1\SettingController@task_list')->where(['auth'=>'sys.setting']);//任务列表
    Route::any('once_tack', 'V1\SettingController@once_tack')->where(['auth'=>'sys.setting']);//执行任务

    //开奖网管理
    Route::prefix('kjw')->group(function (){
        Route::get('gamelist', 'Kjw\GameController@list')->where(['auth'=>'sys.setting']);//游戏列表
        Route::get('kjdatagroup/list', 'Kjw\KjdataGroupController@list')->where(['auth'=>'sys.setting']);//开奖数据整合列表
        Route::get('kjdatagroup/createdata', 'Kjw\KjdataGroupController@createdata')->where(['auth'=>'sys.setting']);//生成开奖数据
        Route::get('kjdatagroup/clearall', 'Kjw\KjdataGroupController@clearall')->where(['auth'=>'sys.setting']);//清理所有快开数据
        Route::get('kjdatagroup/clear', 'Kjw\KjdataGroupController@clear')->where(['auth'=>'sys.setting']);//清理快开数据
        Route::get('kjdatagroup/tongbugf', 'Kjw\KjdataGroupController@tongbugf')->where(['auth'=>'sys.setting']);//同步官方
        Route::get('kjdatagroup/createbydays', 'Kjw\KjdataGroupController@createbydays')->where(['auth'=>'sys.setting']);//生成开奖数据
        Route::get('kjdatagroup/yijiantongbugf', 'Kjw\KjdataGroupController@yijiantongbugf')->where(['auth'=>'sys.setting']);//一键同步官方
        Route::get('kjdatagroup/loadqgc', 'Kjw\KjdataGroupController@loadqgc')->where(['auth'=>'sys.setting']);//加载全国彩
        Route::get('kjdatagroup/loadlhc', 'Kjw\KjdataGroupController@loadlhc')->where(['auth'=>'sys.setting']);//加载六合彩
    });


    //授权域名
    Route::get('authdomain/list', 'V1\DomainController@list')->where(['auth'=>'sys.setting']);//授权域名列表
    Route::post('authdomain/save', 'V1\DomainController@save')->where(['auth'=>'sys.setting']);//授权域名保存
    Route::post('authdomain/delete', 'V1\DomainController@delete')->where(['auth'=>'sys.setting']);//授权域名删除
    Route::post('authdomain/saveawsandbt', 'V1\DomainController@saveawsandbt')->where(['auth'=>'sys.setting']);//授权域名保存
    Route::post('authdomain/delawsandbt', 'V1\DomainController@delawsandbt')->where(['auth'=>'sys.setting']);
    Route::post('authdomain/suijiregister', 'V1\DomainController@suijiregister')->where(['auth'=>'sys.setting']);
    Route::post('authdomain/login138', 'V1\DomainController@login138')->where(['auth'=>'sys.setting']);
    Route::post('authdomain/get138sitelist', 'V1\DomainController@get138sitelist')->where(['auth'=>'sys.setting']);
    Route::post('authdomain/add138daohang', 'V1\DomainController@add138daohang')->where(['auth'=>'sys.setting']);
    Route::post('authdomain/saveanquanma', 'V1\DomainController@saveanquanma')->where(['auth'=>'sys.setting']);
    Route::post('authdomain/del138daohang', 'V1\DomainController@del138daohang')->where(['auth'=>'sys.setting']);

    //赚点设置
    Route::get('/tax/list','V1\TaxController@list')->where(['menu'=>'赚点列表']);//赚点设置页面
    Route::post('/tax/saveTax','V1\TaxController@saveTax');//赚点设置保存
    Route::post('/tax/resetUserTax','V1\TaxController@resetUserTax');//恢复赚点
    Route::post('/tax/resetTax','V1\TaxController@resetTax');//停用全部下线赚点设置
    Route::get('/tax/templates','V1\TaxController@templates')->where(['menu'=>'赚点模板']);//赚点模板页面
    Route::get('/tax/template','V1\TaxController@template');//添加赚点模板页面
    Route::post('/tax/delTemplate','V1\TaxController@delTemplate');//删除赚点模板
    Route::post('/tax/saveTemplate','V1\TaxController@saveTemplate');//赚点模板保存
    Route::get('/tax/param','V1\TaxController@param');//会员赚点模板明细
    Route::post('/tax/saveParam','V1\TaxController@saveParam');//会员赚点模板明细保存
    Route::get('/tax/bets','V1\TaxController@bets')->where(['autozj'=>'赚点-注单明细']);//下注详情
    Route::post('/tax/resetBetTax','V1\TaxController@resetBetTax');//恢复注单赚点
    Route::post('/tax/savetax_start_bishu','V1\TaxController@savetax_start_bishu');//
    Route::get('/tax/setting','V1\TaxController@setting')->where(['menu'=>'赚点设置']);//赚点设置
    Route::post('/tax/cleartaxbywhere', 'V1\TaxController@cleartaxbywhere');//清理赚点
    Route::get('/tax/querytax', 'V1\TaxController@querytax');//查询赚点
    Route::post('/tax/saveothersetting', 'V1\TaxController@saveothersetting');//保存赚点设置
    Route::post('/tax/yijiansetting', 'V1\TaxController@yijiansetting');//一键设置

    //统计
    Route::get('tj/datalist', 'V1\TjController@datalist')->where(['auth'=>'sys.setting']);
    Route::post('tj/datalistdata', 'V1\TjController@datalistdata')->where(['auth'=>'sys.setting']);
});

Route::fallback(function () {
    return '408';
});
















