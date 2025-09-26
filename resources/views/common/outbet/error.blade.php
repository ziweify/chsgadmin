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
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$username}}-{{$outbet_name}}警报</span>
        @if(isset($ht))
            所属代理：
            <select id="quserid">
                @foreach($flyuserlist as $vo)
                    <option @selected($userid==$vo['userid']) value="{{$vo['userid']}}">{{$vo['username']}}</option>
                @endforeach
            </select>
        @endif
        <span class="right"></span>
    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th>类型</th>
                <th>时间</th>
                <th>站点信息</th>
                <th>内容</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $vo)
                <tr>
                    <td>{{$vo['type']}}</td>
                    <td>{{$vo['create_time']}}</td>
                    <td>{{$vo['sitename']}}</td>
                    <td>{{$vo['bz']}}</td>
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
  <a class="previous"><a href='{{$list->path()}}?&page=1&userid={{$userid}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}&userid={{$userid}}'@endif>前一页</a>『
                       @for($i=1;$i<=$list->totalPage;$i++)
                    @if($i == $list->currentPage())
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $list->totalPage)
                            <a href='{{$list->path()}}?&page={{$i}}&userid={{$userid}}' class="page">{{$i}}</a>
                        @else
                            <a href='{{$list->path()}}?&page={{$i}}&userid={{$userid}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}&userid={{$userid}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}&userid={{$userid}}'>末页</a>&nbsp;&nbsp;</span>
        </div>
    </div>
</div>
<script>
    $('#quserid').change(function () {
        window.location.href = LIBS.url({userid: $(this).val()});
    });
</script>
</body>
</html>
