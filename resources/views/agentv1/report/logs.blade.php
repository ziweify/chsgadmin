<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>
    <link href="/static/default/css/agent/report.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/stupidtable.js"></script>
    <script type="text/javascript" src="/static/default/js/report.js"></script>
</head>
<!--
 -->
<body>
<div class="main">
    <div class="top_info">
        <span class="title"> 更新日志 [{{$begin}} — {{$end}}]</span>
        <span class="right"><a class="back" href="javascript:history.back()">返回</a></span>
    </div>
    <div class="contents">
        <table class="data_table list report ">
            <caption>合计</caption>
            <thead>
            <tr class="shead">
                <th rowspan="2" class="info sortable sortdefault" data-sort-dir="asc" data-sort="string">变更时间</th>
                <th>模块</th>
                <th>功能</th>
                <th>操作</th>
                <th>变更类别</th>
                <th rowspan="2">变更人</th>
                <th rowspan="2">变更对象</th>
                <th rowspan="2">原始值</th>
                <th rowspan="2">变更值</th>
                <th rowspan="2">IP</th>
                <th rowspan="2">IP归属</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $vo)
            <tr>
                <td class="info">{{$vo['moditime']}}</td>
                <td>{{$vo['modulename']}}</td>
                <td>{{$vo['functionname']}}</td>
                <td>{{$vo['actionname']}}</td>
                <td class="string-column">{{$vo['action']}}</td>
                <td class="string-column">{{$vo['modiuser']}}</td>
                <td class="string-column">{{$vo['username']}}</td>
                <td class="string-column">{{$vo['oldvalue']}}</td>
                <td class="string-column">{{$vo['newvalue']}}</td>
                <td>{{$vo['modiip']}}</td>
                <td>{{$vo['addr']}}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot id="tfootexist">
            <tr>
                <th>总计：{{count($list)}} 行</th>
                <th colspan="10"></th>
            </tr>
            </tfoot>
        </table>
    </div>
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
  <a class="previous"><a href='{{$list->path()}}?&page=1&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}&functionKey={{$functionKey}}&actionKey={{$actionKey}}&period={{$period}}&lottery={{$lottery}}&operator={{$operator}}&targetUserId={{$targetUserId}}&ipAdd={{$ipAdd}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}&functionKey={{$functionKey}}&actionKey={{$actionKey}}&period={{$period}}&lottery={{$lottery}}&operator={{$operator}}&targetUserId={{$targetUserId}}&ipAdd={{$ipAdd}}'@endif>前一页</a>『
                       @for($i=1;$i<=$list->totalPage;$i++)
                    @if($i == $list->currentPage())
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $list->totalPage)
                            <a href='{{$list->path()}}?&page={{$i}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}&functionKey={{$functionKey}}&actionKey={{$actionKey}}&period={{$period}}&lottery={{$lottery}}&operator={{$operator}}&targetUserId={{$targetUserId}}&ipAdd={{$ipAdd}}' class="page">{{$i}}</a>
                        @else
                            <a href='{{$list->path()}}?&page={{$i}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}&functionKey={{$functionKey}}&actionKey={{$actionKey}}&period={{$period}}&lottery={{$lottery}}&operator={{$operator}}&targetUserId={{$targetUserId}}&ipAdd={{$ipAdd}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}&functionKey={{$functionKey}}&actionKey={{$actionKey}}&period={{$period}}&lottery={{$lottery}}&operator={{$operator}}&targetUserId={{$targetUserId}}&ipAdd={{$ipAdd}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}&begin={{$begin}}&end={{$end}}&moduleKey={{$moduleKey}}&functionKey={{$functionKey}}&actionKey={{$actionKey}}&period={{$period}}&lottery={{$lottery}}&operator={{$operator}}&targetUserId={{$targetUserId}}&ipAdd={{$ipAdd}}'>末页</a>&nbsp;&nbsp;</span>
        </div>
    </div>
</div>
</body>
</html>
