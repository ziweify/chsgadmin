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
    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/subAccount.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">子帐号管理</span>
        <div class="center">
            <span> <label>主账号：</label> <input type="text" class="input" name="mainusername" value=""/></span>
            <span> <label>子帐号：</label> <input type="text" class="input" name="username" value=""/></span>
            <span> <input type="button" value="查找" class="query" onclick="querySubList(true)"/></span>
        </div>
    </div>
    <div class="contents">
        <table class="data_table list user_list">
            <thead>
            <tr>
                <th class="online">在线</th>
                <th class="passname">主账号</th>
                <th class="passname">子帐号</th>
                <th class="name">名称</th>
                <th class="created">新增日期</th>
                <th class="op">功能</th>
                <th class="status">状态</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $sub)
            <tr>
                <td class="online"><span class="s{{$sub['online']}}"></span></td>
                <td class="ame">{{$sub['pusername']}}</td>
                <td class="passname">{{$sub['username']}}</td>
                <td class="name">{{$sub['name']}}</td>
                <td class="created">{{$sub['regtime']}}</td>
                <td class="op">
                    <a href="javascript:void(0)" class="delete" onclick="delSub('{{$sub['pusername']}}-{{$sub['username']}}')">删除</a> <a
                        href="subAccount?passname={{$sub['pusername']}}-{{$sub['username']}}" class="modify">修改</a>
                    <a href="../loginLogs?id={{$sub['username']}}" class="login_log info">日志</a>
                </td>
                <td class="status"><input type="button" class="ss{{$sub['status']}}" onclick="showChangeStatusPanel(this,'{{$sub['pusername']}}-{{$sub['username']}}',{{$sub['status']}})"
                                          value="{{$sub['statusstr']}}"/></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="page">
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
        <div class="page_info">
            @if(count($list) > 0)
            <span class="record">共 {{$list->total()}} 笔记录</span>
            <span class="page_count">共 {{$list->totalPage}} 页</span>
            <span class="page_control">
  <a class="previous"><a href='{{$list->path()}}?&page=1' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}'@endif>前一页</a>『
                       @for($i=1;$i<=$list->totalPage;$i++)
                    @if($i == $list->currentPage())
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $list->totalPage)
                            <a href='{{$list->path()}}?&page={{$i}}' class="page">{{$i}}</a>
                        @else
                            <a href='{{$list->path()}}?&page={{$i}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}'@endif>后一页</a> |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}'>末页</a>&nbsp;&nbsp;</span>
            @endif
        </div>
    </div>
</div>
</body>
</html>
