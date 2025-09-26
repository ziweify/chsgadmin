<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/system.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/agentFollowPlan.js?v1"></script>
    <script type="text/javascript">
        $(function () {
            LIBS.colorMoney('.color', 'minus')
        })
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$layername}} {{$username}}</span>

    </div>
    <div class="contents">
        <input id="username" type="hidden" value="{{$username}}"/>
        <table class="data_table data_list list report" id="lines">
            <div>跟投<input id="btnRefresh" type="button" value="刷新" class="button"/><span
                    id="cdRefresh"></span><input id="btnAdd" type="button" value="新增" class="button" onclick="add()"/>
            </div>
            <thead>
            <tr>
                <th colspan="3"></th>
                <th colspan="3">跟投对象</th>
                <th colspan="3">投注会员</th>
                <th colspan="2"></th>
            </tr>
            <tr class="shead">
                <th>序号</th>
                @if($layer == 0)
                    <th>所属用户</th>
                @endif
                <th>组名</th>
                <th>信用额度/基本额度</th>
                <th>信用余额/现金余额</th>
                <th>跟投比例(%)</th>
                <th>信用额度/基本额度</th>
                <th>信用余额/现金余额</th>
                <th>盈亏</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $k=>$vo)
            <tr>
                <td><input type="hidden" id="sequence" name="sequence" value="{{$k+1}}"/>{{$k+1}}</td>
                @if($layer == 0)
                <td><input type="hidden" id="username" name="username" value="{{$vo['username']}}"/>{{$vo['username']}}</td>
                @endif
                <td><input type="hidden" id="planName" name="planName" value="{{$vo['planName']}}"/>{{$vo['planName']}}</td>
                <td><input type="hidden" id="sourceMax" name="sourceMax" value="{{$vo['sourceMax']}}"/>{{$vo['sourceMax']}}</td>
                <td><input type="hidden" id="sourceBalance" name="sourceBalance" value="{{$vo['sourceBalance']}}"/>{{$vo['sourceBalance']}}</td>
                <td><input type="hidden" id="percentage" name="percentage" value="{{$vo['percentage']}}"/>{{$vo['percentage']}}</td>
                <td><input type="hidden" id="targetMax" name="targetMax" value="{{$vo['targetMax']}}"/>{{$vo['targetMax']}}</td>
                <td><input type="hidden" id="targetBalance" name="targetBalance" value="{{$vo['targetMax']}}"/>{{$vo['targetBalance']}}</td>
                <td class="color"><input type="hidden" id="targetWinLoss" name="targetWinLoss" value="{{$vo['targetWinLoss']}}"/>{{$vo['targetWinLoss']}}</td>
                <td><input type="hidden" id="enabled" name="enabled" value="{{$vo['enabled']}}"/>@if($vo['enabled']==0)未跟投@else跟投中@endif</td>
                <td>
                    <a id="btnEnabled" onclick="enabled({{$vo['id']}}, {{$vo['enabled']==1 ? 0 : 1}})">跟投</a>
                    <a id="btnEdit" onclick="edit({{$vo['id']}})">修改</a>
                    <a id="btnDelete" onclick="deleted({{$vo['id']}})">删除</a> <a id="btnLog" onclick="logs({{$vo['id']}})">日志</a>
                </td>
            </tr>
            @endforeach
            @if(count($list)==0)
                <tr class=""><td class="nodata" colspan="10">暂无数据!</td></tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
