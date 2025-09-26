<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/static/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/static/js/libs.js?v=1"></script>
    <script type="text/javascript" src="/static/js/json2.js"></script>
    <script type="text/javascript" src="/static/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="/static/js/json2.js"></script>
    <link href="/default/css/agent/tax.css" rel="stylesheet" type="text/css"/>
    <script>
        var water_name = '{{$water_name}}';
    </script>
    <script type="text/javascript" src="/default/js/tax.js?v=1"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$water_name}}模板</span>
        <div class="center"><a class="add aback" href="template">新增{{$water_name}}模板</a></div>
    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>使用数</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $k=>$vo)
            <tr>
                <td>{{$k+1}}</td>
                <td class="name">{{$vo['name']}}</td>
                <td class="name">{{$vo['usecount']}}</td>
                <td class="time">{{$vo['create_time']}}</td>
                <td class="op">
                    <a class="edit aback" href="template?tid={{$vo['id']}}">编辑</a>
                    <a class="del" onclick="delTemplate('{{$vo['id']}}','{{$vo['name']}}',{{$vo['usecount']}})">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
