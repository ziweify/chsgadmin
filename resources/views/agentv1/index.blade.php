<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>

    <script type="text/javascript" src="/static/default/js/agent.js"></script>
    <script type="text/javascript" src="/static/default/js/notices.js"></script>
    <script type="text/javascript" src="/js/laydate/layer.min.js"></script>
    <script type="text/javascript" src="/js/dialog.js"></script>
    <script type="text/javascript">
        @if(empty($alertmsg))
            @if($status==1)
            alert('抱歉!你的账号已被冻结（只限结账功能可用），请和上级联系。');
            @endif
            @foreach($notices as $notice)
            alert('{{$notice->content}}');
            @endforeach
        @else
            alert('{{$alertmsg}}');
        @endif
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
                    @if(in_array('control',$auths) && $status==0)
                        <a href="javascript:;" class="control">即时注单</a>
                    @endif
                    @if(in_array('betback',$auths) && $flytypecount > 0 && $status==0)
                        <a href="javascript:;">自动补货</a>
                    @endif
                    @if(in_array('user.children',$auths) && $status==0)
                        <a href="javascript:;">用户管理</a>
                    @endif
                    @if($status==0)
                        <a href="javascript:;">个人管理</a>
                    @endif
                    @if(in_array('agent.follow',$auths) && $planenable==1 && $status==0)
                        <a href="javascript:;">跟投</a>
                    @endif
                    @if($outbet_status==1 && $status==0 && $plat_outbet_status==1)
                        <a href="javascript:;">{{$outbet_name}}</a>
                    @endif
                    @if(in_array('sys.odds',$auths) && ($ifexe == 1 && $pself == 1) && $status==0)
                        <a href="javascript:;">系统管理</a>
                    @endif
                    @if(in_array('report.list',$auths) || in_array('report.logs',$auths) && $status==0)
                        <a href="report/main" target="frame">报表查询</a>
                    @endif
                    <input type="hidden" id="subreport" class="subreport">
                    <a href="dresult?lottery={lottery}" target="frame">开奖结果</a>
                    <!-- <a href="notices" target="frame">站内消息</a> -->
                    <div>
                        <a href="/logout">退出</a>
                    </div>
                </li>
            </ul>
        </div>
        <ul class="tools">
            <!--  <li class="tools_skin"><a href="javascript:;"><span>皮&nbsp;肤</span></a></li>-->
            <li class="tools_user"><span class="ico"></span></li>
            <li class="tools_user" style="width:66%">在线会员：<span id="online"></span><br/>{{$layername}}：{{$username}}
            </li>
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
    @if(in_array('betback',$auths) && $flytypecount > 0)
    <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>自动补货</span></li>
        <li class="menu_sub_link">
            <a href="user/backshare" target="frame">自动补货设定</a> |
            <a href="autobacklogs" target="frame">自动补货变更记录</a>
        </li>
    </ul>
    @endif
    @if(in_array('user.children',$auths))
    <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>用户管理</span></li>
        <li class="menu_sub_link">
            <a href="user/list?lv=0&type=2" target="frame">直属代理</a> |
            <a href="user/list?lv=0&type=1" target="frame">直属会员</a> |
            <a href="user/list?type=2" target="frame">全部代理</a> |
            <a href="user/list?type=1" target="frame">全部会员</a>
            @if($ifson==0)| <a href="user/subs" target="frame">直属子账号</a>@endif
            | <a href="user/loginLogsip" target="frame">登录IP</a>
        </li>
    </ul>
    @endif

    <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>个人管理</span></li>
        <li class="menu_sub_link">
            <a href="info?lottery={lottery}" target="frame">信用资料</a> |
            <a href="loginLogs" target="frame">登录日志</a> |
            <a href="password" target="frame">变更密码</a> |
            @if($bankatm==1)<a href="transferPassword" target="frame" class="">变更操作密码</a> |@endif
            <a href="user/factoryauthenication" target="frame">二次验证</a> |
            @if($plat_tax_status == 1 && $tax_status == 1)
                <a href="tax/list" target="frame" class="">{{$tax_name}}列表</a> |
                <a href="tax/setting" target="frame" class="">{{$tax_name}}设置</a> |
                <a href="tax/templates" target="frame" class="">{{$tax_name}}模板</a> |
            @endif
            @if($plat_water_status == 1 && $water_status == 1)
                <a href="water/list" target="frame" class="">{{$water_name}}列表</a> |
                <a href="water/setting" target="frame" class="">{{$water_name}}设置</a> |
                <a href="water/templates" target="frame" class="">{{$water_name}}模板</a> |
            @endif
        </li>
    </ul>
    @if(in_array('agent.follow',$auths) && $planenable==1)
    <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>跟投</span></li>
        <li class="menu_sub_link">
            <a href="agentFollowPlan/query" target="frame">跟投</a>
        </li>
    </ul>
    @endif

    @if($outbet_status==1 && $status==0 && $plat_outbet_status==1)
        <ul class="menu_sub">
            <li class="menu_sub_title">当前选中：<span>{{$outbet_name}}</span></li>
            <li class="menu_sub_link">
                <a href="outbet/bets" target="frame" class="selected">{{$outbet_name}}注单</a> |
                <a href="outbet/config" target="frame">{{$outbet_name}}设置</a> |
                <a href="outbet/error" target="frame">{{$outbet_name}}警报</a>
            </li>
        </ul>
    @endif

    @if(in_array('sys.odds',$auths) && ($ifexe == 1 && $pself == 1))
    <ul class="menu_sub">
        <li class="menu_sub_title">当前选中：<span>系统管理</span></li>
        <li class="menu_sub_link">
            <a href="quick" target="frame">盘口设置</a> |
        </li>
    </ul>
    @endif

    @if(in_array('report.list',$auths) || in_array('report.logs',$auths))<ul class="menu_sub" id="ordersub">
        <li class="menu_sub_title">当前选中：<span id="lotteryTypes"></span></li>
    </ul>@endif
</div>
<div id="contents">
    <iframe id="frame" name="frame" src="notices" frameborder="0"></iframe>
</div>
<div id="footer" class="footer">
    <div class="notice">
        <marquee scrolldelay="90" scrollamount="4"><a id="notices" href="notices" target="frame"></a></marquee>
    </div>
    <a href="notices" target="frame" class="more">更多</a></div>
</body>
</html>
