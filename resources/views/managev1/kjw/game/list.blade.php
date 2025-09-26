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
    <script type="text/javascript" src="/default/js/kjwgame.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-timepicker-addon.min.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">彩种管理</span>
        <div class="center">
            <div class="query_panel">
					<span class="input_panel">
						<label>搜索：</label> 彩种名称：<input name="gname" class="input" value="{{$gname ?? ''}}"/>
					</span>
                <label>彩种类别：<select id="" name="fenlei">
                        <option @selected($fenlei=='') value="">全部</option>
                        <option @selected($fenlei=='107') value="107">赛车系列</option>
                        <option @selected($fenlei=='101') value="101">时时彩系列</option>
                        <option @selected($fenlei=='121') value="121">11选5系列</option>
                        <option @selected($fenlei=='103') value="103">快乐系列</option>
                        <option @selected($fenlei=='161') value="161">快乐8系列</option>
                        <option @selected($fenlei=='151') value="151">快3系列</option>
                    </select>
                </label>
                <label>快慢分类：<select id="" name="fast">
                        <option @selected($fast=='') value="">全部</option>
                        <option @selected($fast=='1') value="1">快开</option>
                        <option @selected($fast=='0') value="0">慢开</option>
                    </select>
                </label>
                <button type="button" class="query" onclick="querygamelist()">查找</button>
            </div>
        </div>
        <div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>
    </div>
    <div class="contents">
        <div class="user_list">
            <table class="data_table list">
                <thead>
                <tr>
                    <th>GID</th>
                    <th>彩种标识</th>
                    <th>彩种名称</th>
                    <th>状态</th>
                    <th>官方/系统</th>
                    <th>开始/结束时间</th>
                    <th>期数</th>
                    <th>封盘(秒)</th>
                    <th>开始期数</th>
                    <th>开始日期</th>
                    <th>总期数</th>
                    <th>来源</th>
                    <th>任务组</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $vo)
                    <tr>
                        <td>{{$vo['gid']}}</td>
                        <td>{{$vo['lottery']}}</td>
                        <td>{{$vo['gname']}}</td>
                        <td class="status">{{$vo['status']}}</td>
                        <td>{{$vo['guanfang']}}</td>
                        <td>{{$vo['starttime']}}/{{$vo['starttime2']}}</td>
                        <td>{{$vo['qsnums']}}</td>
                        <td>{{$vo['qsjg']}}</td>
                        <td>{{$vo['startqs']}}</td>
                        <td>{{$vo['startdate']}}</td>
                        <td>{{$vo['qishunum']}}</td>
                        <td>{{$vo['laiyuan']}}</td>
                        <td>{{$vo['taskgroup']}}</td>
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
  <a class="previous"><a href='{{$list->path()}}?&page=1' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous"
   @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}'@endif>前一页</a>『
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
                            』<a class='next'
                                @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}'>末页</a>&nbsp;&nbsp;</span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
