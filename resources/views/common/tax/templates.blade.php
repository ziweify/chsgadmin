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
        var tax_name = '{{$tax_name}}';
        function changefid1() {
            var fid1 = $("#fid1").val();
            location.href = "templates?fid1=" + fid1;
        }
    </script>
    <script type="text/javascript" src="/default/js/tax.js?v=1"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$tax_name}}模板</span>
        @if($layer==0)
        <div class="center">
            所属一级代理：
            <select name="fid1" id="fid1" onchange="changefid1()">
                @foreach($ulist as $u)
                    <option @selected($fid1==$u['userid']) value="{{$u['userid']}}">{{$u['username']}}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="center"><a class="add aback" href="template?fid1={{$fid1}}">新增模板</a></div>
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
                    <a class="edit aback" href="template?tid={{$vo['id']}}&fid1={{$fid1}}">编辑</a>
                    <a class="del" onclick="delTemplate('{{$vo['id']}}','{{$vo['name']}}',{{$vo['usecount']}},{{$fid1}})">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
