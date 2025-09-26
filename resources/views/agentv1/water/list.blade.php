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
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/static/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/static/js/libs.js?v=1"></script>
    <script type="text/javascript" src="/static/js/json2.js"></script>
    <script type="text/javascript" src="/static/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="/static/js/json2.js"></script>
    <link href="/default/css/agent/tax.css" rel="stylesheet" type="text/css"/>
    <script>
        var water_name = '{{$water_name}}';
    </script>
    <script type="text/javascript" src="/default/js/water.js?v=111"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$water_name}}设置</span>
        <div class="center">
            <div class="query_panel">
		<span class="input_panel">
		<label>会员名：<input name="username" value="{{$username}}"/></label>
		<label>上级代理：<input name="parent" value="{{$parent}}"/></label>
        <label>
            在线状态：
            <select name="online" id="online">
                <option @selected($online==-1) value="-1">全部</option>
                <option @selected($online==1) value="1">在线</option>
                <option @selected($online==0) value="0">离线</option>
            </select>
        </label>
		</span>
                <button id="query" class="query">搜索</button>
                <button id="refresh" class="refresh" onclick="location.reload()">刷新</button>
            </div>
            <a class="add aback" href="template">新增模板</a>
            <span style="margin-left: 50px">下注多少笔开始{{$water_name}}</span><input style="width: 50px;" id="water_start_bishu" value="{{$water_start_bishu}}" type="number"/>
            <button onclick="savewater_start_bishu()">保存</button>
        </div>
        <div class="right">
            <button id="resetTax">停用全部下线{{$water_name}}设置</button>
        </div>
    </div>
    <div class="contents">
        <div class="left_panel">
            <div class="title">代理列表</div>
            <ul id="parents">
                @foreach($leftuser as $left)
                <li><a onclick="pick('{{$left['username']}}')">（{{$left['layername']}}）{{$left['username']}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="tax_list">
            <table class="data_table list">
                <thead>
                <tr>
                    <th rowspan="2" class="online">在线</th>
                    <th rowspan="2" class="passname">会员账号</th>
                    <th rowspan="2" class="name">名称</th>
                    <th rowspan="2" class="enabled">开关</th>
                    <th rowspan="2" class="water_auto_close">离线自动关闭</th>
                    <th rowspan="2" class="op">点数/模板</th>
                    <th rowspan="2" class="account">额度</th>
                    <th rowspan="2" class="range">盘口</th>
                    <th colspan="2">未结算</th>
                    <th colspan="4">已结算</th>
                    <th rowspan="2" class="op">操作</th>
                    {{--<th rowspan="2" class="ip">IP</th>
                    <th rowspan="2" class="ip">IP归属</th>--}}
                </tr>
                <tr>
                    <th>笔数</th>
                    <th>金额</th>
                    <th>笔数</th>
                    <th>金额</th>
                    <th>盈亏结果</th>
                    <th>{{$water_name}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $vo)
                <tr>
                    <td class="online"><span class="s{{$vo['online']}}"></span></td>
                    <td class="name">{{$vo['username']}}</td>
                    <td class="name">{{$vo['name']}}</td>
                    <td><input class="water_status" @checked($vo['water_status']==1) type="checkbox" name="{{$vo['userid']}}"/></td>
                    <td><input class="water_auto_close" @checked($vo['water_auto_close']==1) type="checkbox" name="{{$vo['userid']}}"/></td>
                    <td class="template">
                        <select name="tid">
                            @if($vo['water_template_id']==-1)<option @selected($vo['water_template_id']==-1) value="-1">自定义</option>@endif
                            <option @selected($vo['water_template_id']==0) value="0">0[系统]</option>
                            @foreach($watertmplist as $t)
                            <option @selected($vo['water_template_id']==$t['id']) value="{{$t['id']}}">{{$t['name']}}</option>
                            @endforeach
                        </select>
                        {{--<a class="aback" href="param?userid={{$vo['userid']}}">明细</a>--}}
                    </td>
                    <td>{{$vo['kmoney']}}/{{$vo['kmaxmoney']}}</td>
                    <td>{{$vo['defaultpan']}}</td>
                    <td>{{$vo['wjs_count']}}</td>
                    <td><a target="_blank" href="bets?username={{$vo['username']}}">{{$vo['wjs_money']}}</a></td>
                    <td>{{$vo['yjs_count']}}</td>
                    <td><a target="_blank" href="bets?username={{$vo['username']}}&settle=true">{{$vo['yjs_money']}}</a></td>
                    <td>{{$vo['yjs_sy']}}</td>
                    <td>{{$vo['water_money']}}</td>
                    <td>
                        <a class="reset" onclick="resetUserTax('{{$vo['userid']}}','{{$vo['username']}}')">恢复当天{{$water_name}}</a>
                        {{--<a class="aback logs" href="../logs?type=tax&id={{$vo['username']}}">记录</a>--}}
                    </td>
                   {{-- <td>{{$vo['ip']}}</td>
                    <td>{{$vo['addr']}}</td>--}}
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
  <a class="previous"><a href='{{$list->path()}}?&page=1&username={{$username}}&parent={{$parent}}&online={{$online}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}&username={{$username}}&parent={{$parent}}&online={{$online}}'@endif>前一页</a>『
                       @for($i=1;$i<=$list->totalPage;$i++)
                            @if($i == $list->currentPage())
                                <span class="current">{{$i}}</span>&nbsp;
                            @else
                                @if($i == $list->totalPage)
                                    <a href='{{$list->path()}}?&page={{$i}}&username={{$username}}&parent={{$parent}}&online={{$online}}' class="page">{{$i}}</a>
                                @else
                                    <a href='{{$list->path()}}?&page={{$i}}&username={{$username}}&parent={{$parent}}&online={{$online}}' class="page">{{$i}}</a>&nbsp;
                                @endif
                            @endif
                        @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}&username={{$username}}&parent={{$parent}}&online={{$online}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}&username={{$username}}&parent={{$parent}}&online={{$online}}'>末页</a>&nbsp;&nbsp;</span>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
