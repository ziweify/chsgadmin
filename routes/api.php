<?php

use Illuminate\Support\Facades\Route;

//测试接口
Route::any('api/member/downloadAllImage','Member\app\AuthController@downloadAllImage');
Route::any('api/member/test','Member\app\CommonController@test');
Route::any('api/common/tokenauth','Member\app\CommonController@tokenAuth');
Route::any('api/uploadResult','Common\ComController@uploadResult');//上传开奖结果

//需要授权
Route::prefix('api')->group(function (){
    Route::prefix('common')->group(function (){
        Route::get('/siteConfig', 'Common\ComController@siteConfig');//获取平台配置信息
        Route::post('/captcha', 'Common\ComController@captcha');//获取验证码
        Route::post('/logout','Common\ComController@logout');//退出登录
        //验证登陆权限和房间
        Route::middleware(['api.auth','api.room.auth'])->group(function (){
            //在线客服
            Route::get('/customChatRecords','Common\ComController@customChatRecords');//聊天记录
            Route::post('/uploadChatImage','Common\ComController@uploadChatImage');//上传聊天图片

            Route::get('/period','Common\ComController@period');//获取时间数据
            Route::get('/lotteryPredictInfo','Common\ComController@lotteryPredictInfo');//获取预测结果
            Route::get('/longdragon','Common\ComController@longdragon');//获取长龙榜数据

            Route::get('/chatRecords','Common\ComController@chatRecords');//聊天记录
            Route::post('/updatePwd','Common\ComController@updatePwd');//修改密码
            Route::get('/resultByDate','Common\ComController@resultByDate');//根据条件查询开奖结果

            Route::get('/getOtherConfig','Common\ComController@getOtherConfig');//获取其他配置信息
            Route::get('/getGameListByIfok','Common\ComController@getGameListByIfok');//获取游戏列表
            Route::get('/getRoomConfig','Common\ComController@getRoomConfig');//获取房间配置
            
            // 打单中心相关接口
            Route::get('/getBettingCenterRecords','Member\app\CommonController@getBettingCenterRecords');//获取打单中心记录
            Route::get('/getTodayBettingFailCount','Member\app\CommonController@getTodayBettingFailCount');//获取今日失败次数
            Route::post('/increaseBettingFailCount','Member\app\CommonController@increaseBettingFailCount');//增加失败次数
            Route::get('/getBettingConfig','Member\app\CommonController@getBettingConfig');//获取打单配置
            Route::get('/getBettingSites','Member\app\CommonController@getBettingSites');//获取打单站点
            Route::post('/updateBettingConfig','Member\app\CommonController@updateBettingConfig');//更新打单配置
            Route::post('/updateSiteStatus','Member\app\CommonController@updateSiteStatus');//更新站点状态
            Route::post('/deleteSite','Member\app\CommonController@deleteSite');//删除站点
            Route::post('/addSite','Member\app\CommonController@addSite');//添加站点
        });
    });
    Route::prefix('member')->group(function (){
        //不需要授权
        Route::post('/login', 'Member\app\AuthController@login');
        Route::post('/register', 'Member\app\AuthController@register');
        Route::get('/time','Member\app\CommonController@time');
        Route::middleware(['api.auth','api.mtype'])->group(function (){
            //用户接口
            Route::post('/uploadheadimg','Member\app\UserinfoController@uploadheadimg');//上传头像
            Route::post('/enterroom','Member\app\CommonController@enterroom');//进入房间初始化
            Route::get('/getHistoryRoomList','Member\app\UserinfoController@getHistoryRoomList');//获取历史房间列表
            Route::post('/delRoomhistory','Member\app\UserinfoController@delRoomhistory');//删除历史房间
            Route::post('/updateNickName','Member\app\UserinfoController@updateNickName');//修改昵称
            Route::post('/initFirstPwd','Member\app\UserinfoController@initFirstPwd');//设置初始密码

            //下分密码
            Route::get('/haveTpsw','Member\app\UserinfoController@haveTpsw');//是否启用了下分密码
            Route::post('/setTpsw','Member\app\UserinfoController@setTpsw');//设置下分密码
            Route::post('/closeTpsw','Member\app\UserinfoController@closeTpsw');//关闭下分密码
            Route::post('/resetTpsw','Member\app\UserinfoController@resetTpsw');//修复下分密码

            Route::get('/getRegUserinfo','Member\app\UserinfoController@getRegUserinfo');//获取用户信息

            //需要验证房间号
            Route::middleware(['api.room.auth'])->group(function (){
                Route::get('/periodlistorsingle','Member\app\CommonController@periodlistorsingle');//获取所有彩种、封盘时间、上期开奖结果
                Route::get('/openResult','Member\app\CommonController@openResult');//获取当前开奖结果


                Route::get('/userIsAgent','Member\app\UserinfoController@userIsAgent');//是否是代理

                //赔率
                Route::get('/quickPlayDetail','Member\app\RoomController@quickPlayDetail');//快捷玩法赔率

                //公共接口
                Route::get('/getBetsSumByLotteryId','Member\app\RoomController@getBetsSumByLotteryId');
                Route::get('/getLotterySettledList','Member\app\RoomController@getLotterySettledList');

                //钱包中心
                Route::get('/getBalanceInfo','Member\app\WalletController@getBalanceInfo');//获取余额信息
                Route::get('/getApplyList','Member\app\WalletController@getApplyList');//获取申请列表
                Route::get('/report','Member\app\WalletController@report');//报表
                Route::get('/getBetrecord','Member\app\WalletController@getBetrecord');//投注记录
                Route::get('/getWjsRecord','Member\app\WalletController@getWjsRecord');//未结算记录
                Route::get('/getMoneyLogList','Member\app\WalletController@getMoneyLogList');//资金记录

                //大厅接口
                Route::get('/getRoomNotice','Member\app\RoomController@getRoomNotice');//获取房间公告

                //游戏介绍
                Route::get('/gameintroduce','Member\app\CommonController@gameintroduce');//获取游戏介绍
            });
        });
    });
    Route::prefix('agent')->group(function (){
        Route::post('/login', 'Agent\app\AuthController@login');
        Route::post('/captcha', 'Agent\app\AuthController@captcha');

        Route::middleware(['api.auth','api.atype'])->group(function (){
            //游戏大厅
            Route::get('/getGameAndTimedata', 'Agent\app\RoomController@getGameAndTimedata');
            Route::get('/getRoomNotice','Agent\app\RoomController@getRoomNotice');//获取房间公告
            Route::get('/updateGameStatus','Agent\app\RoomController@updateGameStatus');//更新游戏状态
            Route::get('/getOnlineCount','Agent\app\RoomController@getOnlineCount');//获取在线人数

            //在线客服
            Route::get('/getRecentChatUserList', 'Agent\app\RecentChatController@getRecentChatUserList');//最近聊天会员列表
            Route::post('/deleteRecentChat', 'Agent\app\RecentChatController@deleteRecentChat');//删除最近聊天记录

            //游戏数据
            Route::get('/gameData', 'Agent\app\GameDataController@gameData');//获取游戏数据
            Route::get('/betDataByPeriod', 'Agent\app\GameDataController@betDataByPeriod');//当期投注数据
            Route::get('/betDataRecord', 'Agent\app\GameDataController@betDataRecord');//投注记录

            //公共部分
            Route::get('/getGameListAll','Agent\app\CommonController@getGameListAll');//获取游戏列表
            Route::get('/getOnlineUserList', 'Agent\app\CommonController@getOnlineUserList');//获取在线会员列表

            //房间配置
            Route::get('/roomConfig/configInfo', 'Agent\app\RoomConfigController@configInfo');//获取房间配置信息
            Route::post('/roomConfig/saveConfig', 'Agent\app\RoomConfigController@saveConfig');//保存房间配置信息
            Route::post('/roomConfig/refreshRoomId', 'Agent\app\RoomConfigController@refreshRoomId');//刷新房间号
            Route::get('/roomConfig/getGameSettingList', 'Agent\app\RoomConfigController@getGameSettingList');//获取游戏列表
            Route::post('/roomConfig/switchGame', 'Agent\app\RoomConfigController@switchGame');//游戏开关设置
            Route::post('/roomConfig/saveGameSetting', 'Agent\app\RoomConfigController@saveGameSetting');//保存游戏设置
            Route::get('/roomConfig/getGameMsgList', 'Agent\app\RoomConfigController@getGameMsgList');//获取游戏消息列表
            Route::post('/roomConfig/saveGameMsg', 'Agent\app\RoomConfigController@saveGameMsg');//保存游戏消息
            Route::post('/roomConfig/synAllGameMsg', 'Agent\app\RoomConfigController@synAllGameMsg');//同步所有游戏消息
            Route::post('/roomConfig/resetGameMsg', 'Agent\app\RoomConfigController@resetGameMsg');//重置游戏消息

            //申请管理
            Route::get('/apply/getApplyList', 'Agent\app\ApplyController@getApplyList');//获取申请列表
            Route::post('/apply/doApply', 'Agent\app\ApplyController@doApply');//处理申请

            //管理中心
            Route::get('/center/centerInfo', 'Agent\app\MangeCenterController@centerInfo');//管理中心信息
            Route::get('/center/getUserList', 'Agent\app\MangeCenterController@getUserList');//获取用户列表
            Route::post('/center/registerAccount', 'Agent\app\MangeCenterController@registerAccount');//注册账号
            Route::post('/center/updateAccount', 'Agent\app\MangeCenterController@updateAccount');//修改账号
            Route::post('/center/generateLink', 'Agent\app\MangeCenterController@generateLink');//生成链接
            Route::post('/center/modifyStatus', 'Agent\app\MangeCenterController@modifyStatus');//修改用户状态
            Route::post('/center/delAllZeroUser', 'Agent\app\MangeCenterController@delAllZeroUser');//删除所有余额为0的用户
            Route::post('/center/shangxiafen', 'Agent\app\MangeCenterController@shangxiafen');//上下分
            Route::get('/center/getSonAccountList', 'Agent\app\MangeCenterController@getSonAccountList');//获取子账号列表
            Route::post('/center/addSonAccount', 'Agent\app\MangeCenterController@addSonAccount');//添加子账号
            Route::post('/center/delSonAccount', 'Agent\app\MangeCenterController@delSonAccount');//删除子账号
            Route::post('/center/updateSonStatus', 'Agent\app\MangeCenterController@updateSonStatus');//修改子账号状态1
            Route::post('/center/resetErrors', 'Agent\app\MangeCenterController@resetErrors');//重置错误次数
            Route::post('/center/updateSonAccount', 'Agent\app\MangeCenterController@updateSonAccount');//修改子账号
            Route::post('/center/resetGoogle', 'Agent\app\MangeCenterController@resetGoogle');//重置谷歌验证
            Route::get('/center/getLinkRecord', 'Agent\app\MangeCenterController@getLinkRecord');//获取链接列表
            

            //二次验证
            Route::get('/verify/getSecondver', 'Agent\app\MangeCenterController@getSecondver');//获取二次验证
            Route::post('/verify/saveSecondver', 'Agent\app\MangeCenterController@saveSecondver');//保存二次验证
            Route::post('/verify/resetSecondver', 'Agent\app\MangeCenterController@resetSecondver');//重置二次验证

            //赔率设置
            Route::get('/odds/getOddsSet', 'Agent\app\MangeCenterController@getOddsSet');//获取赔率列表
            Route::post('/odds/saveOddsSet', 'Agent\app\MangeCenterController@saveOddsSet');//保存赔率设置
            Route::post('/odds/synOddsSet', 'Agent\app\MangeCenterController@synOddsSet');//同步赔率设置

            //报表
            Route::get('/report/getReportAll', 'Agent\app\ReportController@getReportAll');//获取报表
            Route::get('/report/getReportUser', 'Agent\app\ReportController@getReportUser');//获取用户报表
            Route::get('/report/getReportWjs', 'Agent\app\ReportController@getReportWjs');//获取未结算报表
            Route::get('/report/getReportLogs', 'Agent\app\ReportController@getReportLogs');//获取日志报表
            Route::get('/report/getBetrecordByUser', 'Agent\app\ReportController@getBetrecordByUser');//获取投注报表

            //飞单
            Route::get('/outbet/getUserListForOutbet', 'Agent\app\MangeCenterController@getUserListForOutbet');//获取会员列表，用于飞单选择
            Route::post('/outbet/addOutbetOrEdit', 'Agent\app\MangeCenterController@addOutbetOrEdit');//添加飞单
            Route::get('/outbet/getOutbetList', 'Agent\app\MangeCenterController@getOutbetList');//获取飞单列表
            Route::get('/outbet/getOutbetInfo', 'Agent\app\MangeCenterController@getOutbetInfo');//获取飞单信息
            Route::post('/outbet/delOutbet', 'Agent\app\MangeCenterController@delOutbet');//删除飞单
            Route::post('/outbet/updateOutbetStatus', 'Agent\app\MangeCenterController@updateOutbetStatus');//更新飞单状态
            Route::get('/outbet/getOutbetRecord', 'Agent\app\MangeCenterController@getOutbetRecord');//获取飞单记录
            Route::get('/outbet/getOutbetConfig', 'Agent\app\MangeCenterController@getOutbetConfig');//获取飞单配置信息
            Route::post('/outbet/updateOutbetSwitch', 'Agent\app\MangeCenterController@updateOutbetSwitch');//更新飞单总开关
            Route::post('/outbet/applyOutbet', 'Agent\app\MangeCenterController@applyOutbet');//申请试用
            Route::get('/outbet/getOutbetTypeList', 'Agent\app\MangeCenterController@getOutbetTypeList');//获取飞单类型列表
            
        });
    });
});

Route::fallback(function () {
    return '404';
});


















