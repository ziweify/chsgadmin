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
    <script type="text/javascript" src="/default/js/user.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-timepicker-addon.min.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$username}} -> 下线</span>
        <div class="center">
            <div class="query_panel">
					<span class="input_panel">
						<label>搜索：</label> 账号或名称：<input id="userid" class="input" value=""/>
					</span>
                登录日期：<span id="date">
						<input type="text" id="begin" class="inputdate"/>
						到 <input type="text" id="end" class="inputdate"/>
					</span>
                登出日期：<span id="logoutDate">
						<input type="text" id="logoutBegin" class="inputdate"/>
						到 <input type="text" id="logoutEnd" class="inputdate"/>
					</span>
                <span class="input_panel"><label>IP:</label> <input type="text" name="ip" class="input" id="ip"
                                                                    value=""/> </span>
                <span class="input_panel"><label>IP归属地:</label> <input type="text" name="ipAdd" class="input"
                                                                          id="ipAdd" value=""/> </span>
                <label>登出方式：<select id="" name="logoutType">
                        <option value="" selected="selected">全部</option>
                        <option value="0">用户登出</option>
                        <option value="1">系统踢出</option>
                        <option value="2">超时注销</option>
                    </select>
                </label>
                <button type="button" class="query" onclick="queryLoginLogs()">查找</button>
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
                    <th>账号</th>
                    <th>登录日期</th>
                    <th>IP</th>
                    <th>IP归属地</th>
                    <th>登出时间</th>
                    <th>登出方式</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $vo)
                <tr>
                    <td>{{$vo['username']}}</td>
                    <td>{{$vo['time']}}</td>
                    <td>[请询问上级]</td>
                    <td>[请询问上级]</td>
                    <td>{{$vo['logout_time']}}</td>
                    <td>{{$vo['logout_type']}}</td>
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
                    @if(count($list) > 0)
                    <span class="record">共 {{$list->total()}} 笔记录</span>
                    <span class="page_count">共 {{$list->totalPage}} 页</span>
                    <span class="page_control">
  <a class="previous"><a href='{{$list->path()}}?&page=1' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}'@endif>前一页</a>『
                       @for($i=$startpcount;$i<=$endpcount;$i++)
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
