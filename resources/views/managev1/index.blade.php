<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="/default/js/agent.js"></script>
    <script type="text/javascript" src="/default/js/notices.js"></script>
    <script type="text/javascript">
        /* @foreach($notices as $notice)
        alert("{{$notice->content}}");
        @endforeach */
    </script>
</head>
<body id="topbody">
<div class="header">
    <div class="top" style="position:relative">
        <div class="logo"><span>{{$webname}}</span></div>
        <div class="menu">
            <div class="expire_info"></div>
            <ul class="menu_title">
                <li>
                    @if(in_array('control',$auths))<a href="javascript:;" class="control">即时注单</a>@endif
                    @if(in_array('order.warn',$auths))<a href="javascript:;">注单预警</a>@endif
                    @if(in_array('user.children',$auths))<a href="javascript:;">用户管理</a>@endif
                    <a href="javascript:;">个人管理</a>
                    @if(in_array('agent.follow',$auths) && $planenable==1)<a href="javascript:;">跟投</a>@endif
                    <a href="javascript:;">系统管理</a>
                    @if($adminInfo['ifhide']==1 || in_array('sys.setting',$auths))<a href="javascript:;">高级设置</a>@endif
                    @if(in_array('report.list',$auths) || in_array('report.logs',$auths))<a href="report/main" target="frame">报表查询</a>@endif
                    <a href="dresult?lottery={lottery}" target="frame">开奖结果</a>
                    <!-- <a href="notices" target="frame">站内消息</a> -->
                    <a href="/logout">退出</a>
                </li>
            </ul>
        </div>
        <ul class="tools">
            <!--  <li class="tools_skin"><a href="javascript:;"><span>皮&nbsp;肤</span></a></li>-->
            <li class="tools_user"><span class="ico"></span></li>
            <li class="tools_user" style="width:66%">在线会员：<span
                    id="online">网页端：0+APP：0总在线：0</span><br>公司：{{$username}}</li>
        </ul>
    </div>

    <div class="lottery nav" id="lotterys">
        <div class="lottery-wrapper">
            @foreach($lotterys as $lottery)
                <a id="{{$lottery['template']}}-{{$lottery['lottery']}}">{{$lottery['gname']}}</a>
            @endforeach
        </div>
    </div>
    @if(in_array('control',$auths))
        <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span id="lotteryType"></span></li>
        @foreach($lotterys as $key=>$vo)
            <li id="{{$vo['lottery']}}" class="menu_sub_links">
                @foreach($vo['sub'] as $k=>$v)
                    @if($k != count($vo['sub'])-1)
                        <a href="{{$v['url']}}" target="frame">{{$v['name']}}</a> |
                    @else
                        <a href="{{$v['url']}}" target="frame">{{$v['name']}}</a>
                    @endif
                @endforeach
            </li>
        @endforeach
    </ul>
    @endif
    @if(in_array('order.warn',$auths))
        <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>注单预警</span></li>
        <li class="menu_sub_link">
            <a href="warning/warning" target="frame">注单预警监控</a> |
            <a href="warning/setting" target="frame">设置提示金额</a><!-- |
            <a href="order/main" target="frame">注单搜索</a>
            <a href="orderbf/main" target="frame">注单备份查询</a>-->
        </li>
    </ul>
    @endif
    @if(in_array('user.children',$auths))
        <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>用户管理</span></li>
        <li class="menu_sub_link">
            <a href="user/list?roomid=0&type=2" target="frame">所有房主</a> |
            <a href="user/list?type=3" target="frame">所有代理</a> |
            <a href="user/list?type=4" target="frame">所有会员</a> |
            <a href="subManage/list" target="frame">直属子账号</a> |
            <a href="user/subAccounts?all=1" target="frame">下级子账号</a> |
            <a href="user/loginLogs" target="frame">登录IP</a>
        </li>
    </ul>
    @endif
    <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>个人管理</span></li>
        <li class="menu_sub_link">
            <a href="loginLogs" target="frame">登录日志</a> |
            <a href="password" target="frame">变更密码</a> |
            <a href="user/factoryauthenication" target="frame">二次验证</a> |
            @if($plat_tax_status == 1 && $tax_status == 1)
                <a href="tax/list" target="frame" class="">{{$tax_name}}列表</a> |
                <a href="tax/setting" target="frame" class="">{{$tax_name}}设置</a> |
                <a href="tax/templates" target="frame" class="">{{$tax_name}}模板</a> |
            @endif
            @if($plat_outbet_status == 1 && $outbet_status==1)
                <a href="outbet/bets" target="frame" class="selected">{{$outbet_name}}注单</a> |
                <a href="outbet/config" target="frame">{{$outbet_name}}设置</a> |
                <a href="outbet/error" target="frame">{{$outbet_name}}警报</a>
            @endif
        </li>
    </ul>
    @if(in_array('agent.follow',$auths) && $planenable==1)
        <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>跟投</span></li>
        <li class="menu_sub_link">
            <a href="agentFollowPlan/query" target="frame" class="selected">跟投</a>
        </li>
    </ul>
    @endif
    <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>系统管理</span></li>
        <li class="menu_sub_link">
            @if(in_array('sys.odds',$auths))<a href="system" target="frame">系统设置</a> |@endif
            @if(in_array('sys.kj',$auths))<a href="lotterys" target="frame">彩票管理</a> |@endif
            @if(in_array('sys.kj',$auths))<a href="zshuigameset" target="frame">彩票开关</a> |@endif
            @if(in_array('sys.odds',$auths))<a href="quick" target="frame">默认赔率</a> |
            <a href="user/commission" target="frame">默认退水</a> |@endif
            @if(in_array('sys.msg',$auths))<a href="gamemsg" target="frame">默认消息</a> |@endif
            @if(in_array('notices',$auths))<a href="notice/list" target="frame">公告管理</a> |@endif
            @if(in_array('sys.onlines',$auths))<a href="onlines?type=2" target="frame">在线统计</a> |@endif
            @if(in_array('order.modify',$auths))<a href="ordermodify" target="frame">注单删改</a> |
            <a href="ordermodifylog" target="frame">改单日志</a> |@endif
            @if(in_array('order.znmodify',$auths))<a href="autozjmain" target="frame">智能改单</a> |@endif
            @if($adminInfo['ifhide']==1 || in_array('sys.setting',$auths))<a href="report_hb" target="frame">报表合并</a> |@endif
            @if($adminInfo['ifhide']==1 || in_array('sys.setting',$auths))<a href="task_list" target="frame">任务列表</a> |@endif
            @if($adminInfo['ifhide']==1 || in_array('sys.setting',$auths))<a href="kjdatagroup/list" target="frame">数据整合</a> |@endif
            @if(in_array('sys.znkj',$auths))<a href="kjshow" target="frame">开奖管理</a> |@endif
        </li>
    </ul>
    @if($adminInfo['ifhide']==1 || in_array('sys.setting',$auths))
    <ul class="menu_sub">
            <li class="menu_sub_title">当前选中：<span>高级设置</span></li>
            <li class="menu_sub_link">
                <a href="authdomain/list" target="frame">授权域名</a> |
                <a href="kjshow" target="frame">开奖管理</a> |
                {{--<a href="zshuigameset" target="frame">彩种开关</a> |--}}
                <a href="mclassclasspan" target="frame">玩法归类</a> |
                <a href="mclassbigclass" target="frame">大分类</a> |
                <a href="mclasssclass" target="frame">小分类</a> |
                <a href="mclassmclass" target="frame">玩法分类</a> |
                <a href="playshow" target="frame">玩法列表</a> |
</li>
</ul>
@endif
<ul class="menu_sub" id="ordersub">
<li class="menu_sub_title">当前选中：<span id="lotteryTypes"></span></li>
</ul>
</div>
<div id="contents">
<iframe id="frame" name="frame" src="notices" frameborder="0"></iframe>
</div>
<div id="footer" class="footer">
<div class="notice">
<marquee id="notices" scrollamount="2">

</marquee>
</div>
<a href="notices" target="frame" class="more">更多</a>
</div>
</body>
</html>
<script type="text/javascript">
var ismobie = "{{$ismobie}}";
if(ismobie == 1){//给class="tools"添加样式 style="right: -67px;"
$(".tools").css("right","-67px");
}
</script>
