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
    <link href="/default/css/agent/notices.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">最新公告</span>
    </div>
    <div class="contents">
        <table class="data_table data_list list">
            <thead>
            <tr>
                <th>时间</th>
                <th>公告详情</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $notice)
            <tr>
            <td class="created">{{$notice['time']}}</td>
            <td><div class="wrap">{{$notice['content']}}</div></td>
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

        <div class="page">
            <div class="page_info">
                <span class="record">共 {{$list->total()}} 条公告</span>
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
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}'>末页</a>&nbsp;&nbsp;</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
