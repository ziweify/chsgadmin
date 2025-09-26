<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>一键启用报表</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="/static/default/css/agent/red/master.css" rel="stylesheet" type="text/css" />
    <link href="/static/default/css/agent/red/layout.css" rel="stylesheet" type="text/css" />
    <link href="/static/default/css/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="/static/default/css/loading.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".page-jump input").on("keydown", function(e){
                if(e.keyCode === 13){
                    e.stopPropagation();
                    $(this).blur();
                    if($(this).val() <= 0 || $(this).parent().data("total-page") < $(this).val()){
                        alert("页面不存在");
                        return;
                    } else{
                        var navigatePage = $(this).parent().data("page-url").replace("page=1", "page=" + $(this).val());
                        location.href = location.origin + location.pathname + navigatePage;
                    }
                }
            })
        })

    </script>    <script type="text/javascript" src="/js/stupidtable.js"></script>
    <script type="text/javascript" src="/static/default/js/report.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <form id="search_form" action="userBatchActivate">
            上级账号: <input id="parent" value="{{$parent}}" name="parent" type="text"/>
            账号: <input id="username" value="{{$username}}" name="username" type="text"/>
            <input type="submit" value="查询" onclick="queryBatchUserActivationReport()"/>

        </form>
    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th>上级账号</th>
                <th>账号</th>
                <th>原始状态</th>
                <th>状态</th>
                <th>更新时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $vo)
            <tr>
                <td>{{$vo['parent']}}</td>
                <td>{{$vo['username']}}</td>
                <td>{{$vo['oldvalue']}}</td>
                <td>{{$vo['newvalue']}}</td>
                <td>
                    {{$vo['moditime']}} 星期{{$vo['week']}}
                </td>
            </tr>
            @endforeach
            </tbody>

        </table>
        </table>
    </div>
    <div class="page">
        <div class="page_info">
            <span class="record">共 {{$list->total()}} 笔记录</span>
            <span class="page_count">共 {{$list->totalPage}} 页</span>
            <span class="page_control">
  <a class="previous"><a href='{{$list->path()}}?&page=1&parent={{$parent}}&username={{$username}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}&parent={{$parent}}&username={{$username}}'@endif>前一页</a>『
                       @for($i=1;$i<=$list->totalPage;$i++)
                    @if($i == $list->currentPage())
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $list->totalPage)
                            <a href='{{$list->path()}}?&page={{$i}}&parent={{$parent}}&username={{$username}}' class="page">{{$i}}</a>
                        @else
                            <a href='{{$list->path()}}?&page={{$i}}&parent={{$parent}}&username={{$username}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}&parent={{$parent}}&username={{$username}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}&parent={{$parent}}&username={{$username}}'>末页</a>&nbsp;&nbsp;</span>
        </div>
    </div>
</div>
</body>
</html>
