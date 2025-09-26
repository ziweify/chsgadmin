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
    <link href="/default/css/agent/report.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">var TODAY = 1675440000000;</script>
    <script type="text/javascript" src="/default/js/agentFollowPlanLog.js"></script>
    <style type="text/css">.time {
            width: 15%
        }
        .detail {
            white-space: pre-line;
        }

    </style>
</head>
<body>
<div class="main">
    <form id="search_form" action="logs">
        <div class="top_info">
            <span class="title" style="padding-right: 10px;">{{$layername}} {{$username}} -> 跟投日志 </span>
            <input id="username" type="hidden" value="{{$username}}"/>
            <span id="date" class="titleDatepicker" style="padding-right: 10px;">
                <input type="hidden" id="planId" value="{{$planId}}"/>
                日期：
                <input id="begin" value="{{$date}}"/>
                游戏：<select id="lottery" name="lottery">
                    <option @selected($module=='CHANGE') value="CHANGE">状态变化</option>
                    @foreach($lotterys as $lottery)
                        <option @selected($module==$lottery->lottery) value="{{$lottery->lottery}}">{{$lottery->gname}}</option>
                    @endforeach
</select>

            </span>
            <input type="button" value="查询" onclick="query()" class="btn"/>
            <span class="right"><a href="query" class="back">返回</a></span>
        </div>
    </form>
    <div class="contents">
        <table class="data_table data_list list">
            <thead>
            <tr>
                <th>序号</th>
                <th>组名</th>
                <th>日志类型</th>
                <th>变动前状态</th>
                <th>变动后状态</th>
                <th>变动描述</th>
                <th>创建时间</th>
                <th>变更人</th>
            </thead>
            <tbody>
            @foreach($list as $i=>$log)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$log->planName}}</td>
                    <td>跟投状态变化</td>
                    <td>{{$log->oldvalue}}</td>
                    <td>{{$log->newvalue}}</td>
                    <td>{{$log->action}}</td>
                    <td>{{$log->moditime}}</td>
                    <td>{{$log->modiuser}}@if($log->modisonuser!=''){{$log->modisonuser}}@endif</td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
                <span class="record">共 {{$list->total()}} 笔记录</span>
                <span class="page_count">共 {{$list->totalPage}} 页</span>
                <span class="page_control">
  <a class="previous"><a href='{{$list->path()}}?&page=1&date={{$date}}&planId={{$planId}}&module={{$module}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1&date={{$date}}&planId={{$planId}}&module={{$module}}
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}&date={{$date}}&planId={{$planId}}&module={{$module}}'@endif>前一页</a>『
                       @for($i=1;$i<=$list->totalPage;$i++)
                        @if($i == $list->currentPage())
                            <span class="current">{{$i}}</span>&nbsp;
                        @else
                            @if($i == $list->totalPage)
                                <a href='{{$list->path()}}?&page={{$i}}&date={{$date}}&planId={{$planId}}&module={{$module}}' class="page">{{$i}}</a>
                            @else
                                <a href='{{$list->path()}}?&page={{$i}}&date={{$date}}&planId={{$planId}}&module={{$module}}' class="page">{{$i}}</a>&nbsp;
                            @endif
                        @endif
                    @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}&date={{$date}}&planId={{$planId}}&module={{$module}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}&date={{$date}}&planId={{$planId}}&module={{$module}}'>末页</a>&nbsp;&nbsp;</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
