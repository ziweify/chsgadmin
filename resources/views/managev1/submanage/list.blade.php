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
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script>var isupdate=0;</script>
    <script type="text/javascript" src="/default/js/subManage.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">直属子帐号管理</span>
        @if($admin['level'] <= 2)
        <div class="right">
            <a href="save">新增子账号</a>
        </div>
        @endif
    </div>
    <div class="contents">
        <table class="data_table list user_list">
            <thead>
            <tr>
                <th class="online">在线</th>
                @if($admin['ifhide']==1)<th class="fadminname">上级</th>@endif
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
                @if($admin['ifhide']==1)<td class="fadminname">{{$sub['fadminname']}}</td>@endif
                <td class="passname">{{$sub['adminname']}}</td>
                <td class="name">{{$sub['name']}}</td>
                <td class="created">{{$sub['regtime']}}</td>
                <td class="op">
                    <a href="javascript:void(0)" class="delete" onclick="delSub({{$sub['adminid']}})">删除</a>
                    <a href="save?adminid={{$sub['adminid']}}" class="modify">修改</a>
                    <a href="../loginLogs?id={{$sub['adminid']}}&type=admin" class="login_log info">日志</a>
                </td>
                <td class="status">
                    <input type="button" class="ss{{$sub['status']}}" onclick="showChangeStatusPanel(this,{{$sub['adminid']}},{{$sub['status']}})" value="{{$sub['statusstr']}}"/></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="page">
        <div class="page_info">
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
        </div>
    </div>
</div>
</body>
</html>
