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
    <script>
        $(document).ready(function () {
            $(".page-jump input").on("keydown", function (e) {
                if (e.keyCode === 13) {
                    e.stopPropagation();
                    $(this).blur();
                    if ($(this).val() <= 0 || $(this).parent().data("total-page") < $(this).val()) {
                        alert("页面不存在");
                        return;
                    } else {
                        var navigatePage = $(this).parent().data("page-url").replace("page=1", "page=" + $(this).val());
                        location.href = location.origin + location.pathname + navigatePage;
                    }
                }
            })
        })

    </script>
    <link href="/default/css/agent/online.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/online.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">公司 {{$username}} -&gt;在綫统计</span>
        <input id="username" type="hidden" value="pk169"/>
    </div>
    <div class="contents">
        <table class="data_table data_list">
            <tr class="head">
                <th>管理</th>
                <th>子账号</th>
                <th>代理</th>
                <th>会员</th>
            </tr>
            <tr class="foot">
                <td><a href="?type=0">{{$guanli}}</a></td>
                <td><a href="?type=3">{{$zidaili}}</a></td>
                <td>
                    <a href="?type=1">{{$daili}}</a>
                </td>
                <td>
                    <a href="?type=2">{{$huiyuan}}</a>
                    + <a href="?type=2&platform=app">0</a>
                </td>
            </tr>
        </table>
        <table class="data_table data_list list">
            <thead>
            <tr>
                <th>ID</th>
                <th>帐号</th>
                <th>名称</th>
                <th>上级</th>
                <th>在线时间</th>
                <th>活动页面</th>
                <th>活动时间</th>
                <th>IP</th>
                <th>IP归属</th>
                <th>来源</th>
                <th>基本操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $key=>$vo)
            <tr>
                <td class="id">{{$key+1}}</td>
                <td class="name">{{$vo['username']}} ({{$vo['layername']}})</td>
                <td class="name">{{$vo['name']}}</td>
                <td class="name">{{$vo['fusername']}}</td>
                <td class="time">{{$vo['chatime']}}</td>
                <td class="lastpage">{{$vo['page']}}</td>
                <td class="time">{{$vo['savetime']}}</td>
                <td class="ip">{{$vo['ip']}}</td>
                <td>{{$vo['addr']}}</td>
                <td>网页端</td>
                <td class="op"><a class="info" href="javascript:void(0)" onclick="kick('{{$vo['userid']}}','{{$vo['xtype']}}')">登出</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="page">
        <div class="page_info">
            <span class="record">共 {{$total_count}} 笔记录</span>
            <span class="page_count">共 {{$total_page}} 页</span>
            <span class="page_control">
  <a class="previous"><a href='?&page=1&type={{$type}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$total_page}}" data-page-url="?&page=1&type={{$type}}">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($page-1 >= 1)href='?&page={{$page-1}}&type={{$type}}'@endif>前一页</a>『
                       @for($i=1;$i<=$total_page;$i++)
                    @if($i == $page)
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $total_page)
                            <a href='?&page={{$i}}&type={{$type}}' class="page">{{$i}}</a>
                        @else
                            <a href='?&page={{$i}}&type={{$type}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                            』<a class='next' @if($page+1 <= $total_page)href='?&page={{$page+1}}&type={{$type}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='?&page={{$total_page}}&type={{$type}}'>末页</a>&nbsp;&nbsp;</span>
        </div>
    </div>
</div>
</body>
</html>
