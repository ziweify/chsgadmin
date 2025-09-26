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
    <style type="text/css">.time {
            width: 15%
        }</style>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">资料更变记录</span>
        <span class="right"><a onclick="history.back()" class="back">返回</a></span>
    </div>
    <div class="contents">
        <table class="data_table data_list list">
            <thead>
            <tr>
                <th>ID</th>
                <th>变更时间</th>
                <th>变更类别</th>
                <th>原始值</th>
                <th>变更值</th>
                <th>变更人</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $key=>$log)
            <tr>
                <td>{{$key+1}}</td>
                <td class="time">{{$log['moditime']}}</td>
                <td>{{$log['action']}}</td>
                <td>{{$log['oldvalue']}}</td>
                <td>{{$log['newvalue']}}</td>
                <td>{{$log['modiuser']}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="page">注意：修改记录最少被保留15天、超过15天部分最多保留最后200笔。</div>
</div>
</body>
</html>
