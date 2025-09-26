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
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        @if($type==2)
        <span class="title"><a href="loginLogs?id={{$username}}">登陆日志</a>@if($ifagent==0) / 产品登陆日志@endif</span>
        @else
        <span class="title">登陆日志@if($ifagent==0) / <a href="productLoginLogs?id={{$username}}">产品登陆日志</a>@endif</span>
        @endif
        <span class="right"><a onclick="history.back()" class="back">返回</a></span>
    </div>
    <div class="contents">
        <table class="data_table data_list list">
            <thead>
            <tr>
                <th>序号</th>
                <th>登陆时间</th>
                <th>IP</th>
                <th>IP归属地</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $k=>$v)
            <tr>
                <td>{{$k+1}}</td>
                <td>{{$v->time}}</td>
                <td>{{$v->ip}}</td>
                <td>{{$v->addr}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="page">注意：登陆日志最少被保留7天、超过7天部分最多保留最后20笔。</div>
</div>
</body>
</html>
