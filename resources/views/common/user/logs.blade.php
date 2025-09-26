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
    <script type="text/javascript">var TODAY =1678550400000;</script>
    <script type="text/javascript">var BEGIN =1677945600000;</script>
    <script type="text/javascript" src="/default/js/report.js"></script>
    <style type="text/css">.time {
            width: 15%
        }</style>
</head>
<body>
<div class="main">
    <form id="search_form" action="logs">
        <div class="top_info">
            <span class="title" style="padding-right: 10px;">资料更变记录</span>
            <span id="date" log-user-id="{{$username}}" class="titleDatepicker" style="padding-right: 10px;">
                搜索日志的日期范围：
                <input id="begin" value="{{$begin}}"/>
                ~
                <input id="end" value="{{$end}}"/>
            </span>
            <input type="button" value="搜索" onclick="query()" class="btn"/>
            <span class="right"><a onclick="history.back()" class="back">返回</a></span>
            <input type="hidden" id="module" value="{{$moduleKey}}"/>
        </div>
    </form>
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
                    <td>
                        @if(count($log['action']) > 1)
                            @foreach($log['action'] as $action)
                                {{$action}}<br/>
                            @endforeach
                        @else
                            {{$log['action'][0]}}
                        @endif
                    </td>
                    <td>{{$log['oldvalue']}}</td>
                    <td>{{$log['newvalue']}}</td>
                    <td>{{$log['modiuser']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="page">
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


            </script>
            <div class="page_info">
                <span class="record">共 {{$list->total()}} 笔记录</span>
                <span class="page_count">共 {{$list->totalPage}} 页</span>
                <span class="page_control">
  <a class="previous"><a href='{{$list->path()}}?&page=1&id={{$username}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}&id={{$username}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}'@endif>前一页</a>『
                       @for($i=$startpcount;$i<=$endpcount;$i++)
                        @if($i == $list->currentPage())
                            <span class="current">{{$i}}</span>&nbsp;
                        @else
                            @if($i == $list->totalPage)
                                <a href='{{$list->path()}}?&page={{$i}}&id={{$username}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}' class="page">{{$i}}</a>
                            @else
                                <a href='{{$list->path()}}?&page={{$i}}&id={{$username}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}' class="page">{{$i}}</a>&nbsp;
                            @endif
                        @endif
                    @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}&id={{$username}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}'@endif>后一页</a> |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}&id={{$username}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}'>末页</a>&nbsp;&nbsp;</span>
            </div>
        </div>
    </div>
    <div class="page">注意：修改记录默认显示一周结果，如有需求，请手动查询需要的范围（搜索范围在92天以内）。</div>
</div>
</body>
</html>
