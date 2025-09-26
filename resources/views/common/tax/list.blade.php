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
        var tax_name = '{{$tax_name}}';
        function changefid1() {
            var fid1 = $("#fid1").val();
            location.href = "list?fid1=" + fid1;
        }
        function yijian(type){
            var fid1 = $("#fid1").val();
            var yjstatus = $("select[name='yjstatus']").val();
            var yjtax_auto_close = $("select[name='yjtax_auto_close']").val();
            var yjtaxtemplateid = $("select[name='yjtaxtemplateid']").val();
            var yjis_show_jpei = $("select[name='is_show_jpei']").val();
            if(!confirm("确定要操作吗？")){
                return;
            }
            $.ajax({
                url: "/agent/tax/yijiansetting",
                type: "post",
                dataType: "json",
                data: {
                    fid1: fid1,
                    yjstatus: yjstatus,
                    yjtax_auto_close: yjtax_auto_close,
                    yjtaxtemplateid: yjtaxtemplateid,
                    yjis_show_jpei: yjis_show_jpei,
                    type: type
                },
                success: function (data) {
                    alert(data.message);
                    window.location.reload();
                }
            });
        }
    </script>
    <script type="text/javascript" src="/default/js/tax.js?v=113"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$tax_name}}设置</span>
        <div class="center">
            <div class="query_panel">
        @if($layer==0)
        <label>
            所属一级代理：
            <select name="fid1" id="fid1" onchange="changefid1()">
                @foreach($ulist as $u)
                <option @selected($fid1==$u['userid']) value="{{$u['userid']}}">{{$u['username']}}</option>
                @endforeach
            </select>
        </label>
        @endif
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
            {{--<a class="add aback" href="template">新增模板</a>--}}
            <span style="margin-left: 50px">每页显示：</span><input style="width: 50px;" id="pagesize" value="{{$pagesize}}" type="number"/>条
            <span style="margin-left: 10px">下注多少笔开始{{$tax_name}}</span><input style="width: 50px;" id="tax_start_bishu" value="{{$tax_start_bishu}}" type="number"/>
            <button onclick="savetax_start_bishu()">保存</button>
        </div>
        <div class="right">
            <button id="resetTax">停用全部下线{{$tax_name}}设置</button>
        </div>
    </div>
    @if($layer==0)
    <div class="top_info">
       {{-- <span class="" style="">一键化操作</span>--}}
        <div class="center">
            <div class="query_panel">
                一键开关操作：
                <label>
                    <select name="yjstatus">
                        <option value="0">关闭</option>
                        <option value="1">开启</option>
                    </select>
                    <button onclick="yijian(0)">操作</button>
                    一键模版操作：
                    <select name="yjtaxtemplateid">
                        <option value="0">0[无]</option>
                        @foreach($taxtmplist as $t)
                            <option value="{{$t['id']}}">{{$t['name']}}</option>
                        @endforeach
                    </select>
                    <button onclick="yijian(1)">操作</button>
                    一键离线开关操作：
                    <select name="yjtax_auto_close">
                        <option value="0">关闭</option>
                        <option value="1">开启</option>
                    </select>
                    <button onclick="yijian(2)">操作</button>
                    一键降赔显示操作：
                    <select name="is_show_jpei">
                        <option value="0">不显示</option>
                        <option value="1">显示</option>
                        <option value="2">显示[不含首页]</option>
                    </select>
                    <button onclick="yijian(3)">操作</button>
                </label>
            </div>
        </div>
    </div>
    @endif
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
                    <th rowspan="2" class="tax_auto_close">离线自动关闭</th>
                    <th rowspan="2" class="op">点数/模板</th>
                    <th rowspan="2" class="is_show_jpei">降赔显示</th>
                    <th rowspan="2" class="weizhi">当前位置</th>
                    <th rowspan="2" class="account">额度</th>
                    <th rowspan="2" class="share">占成</th>
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
                    <th>{{$tax_name}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $vo)
                <tr>
                    <td class="online"><span class="s{{$vo['online']}}"></span></td>
                    <td class="name">{{$vo['username']}}</td>
                    <td class="name">{{$vo['name']}}</td>
                    <td><input class="tax_status" @checked($vo['tax_status']==1) type="checkbox" name="{{$vo['userid']}}"/></td>
                    <td><input class="tax_auto_close" @checked($vo['tax_auto_close']==1) type="checkbox" name="{{$vo['userid']}}"/></td>
                    <td class="template">
                        <select name="tid">
                            @if($vo['tax_template_id']==-1)<option @selected($vo['tax_template_id']==-1) value="-1">自定义</option>@endif
                            <option @selected($vo['tax_template_id']==0) value="0">0[无]</option>
                            @foreach($taxtmplist as $t)
                                <option @selected($vo['tax_template_id']==$t['id']) value="{{$t['id']}}">{{$t['name']}}</option>
                            @endforeach
                        </select>
                        {{--<a class="aback" href="param?userid={{$vo['userid']}}">明细</a>--}}
                    </td>
                    <td class="is_show_jpei">
                        <select name="is_show_jpei">
                            <option @selected($vo['is_show_jpei']==0) value="0">不显示</option>
                            <option @selected($vo['is_show_jpei']==1) value="1">显示</option>
                            <option @selected($vo['is_show_jpei']==2) value="2">显示[不含首页]</option>
                        </select>
                        {{--<a class="aback" href="param?userid={{$vo['userid']}}">明细</a>--}}
                    </td>
                    <td class="weizhi">{{$vo['xpage']}}</td>
                    <td>{{$vo['kmoney']}}/{{$vo['kmaxmoney']}}</td>
                    <td class="share"><a userid="{{$vo['username']}}" username="{{$vo['username']}}">明细</a></td>
                    <td>{{$vo['defaultpan']}}</td>
                    <td>{{$vo['wjs_count']}}</td>
                    <td><a target="_blank" href="bets?username={{$vo['username']}}">{{$vo['wjs_money']}}</a></td>
                    <td>{{$vo['yjs_count']}}</td>
                    <td><a target="_blank" href="bets?username={{$vo['username']}}&settle=true">{{$vo['yjs_money']}}</a></td>
                    <td>{{$vo['yjs_sy']}}</td>
                    <td>{{$vo['tax_money']}}</td>
                    <td>
                        <a class="reset" onclick="resetUserTax('{{$vo['userid']}}','{{$vo['username']}}')">恢复当天{{$tax_name}}</a>
                        <a href="/agent/user/logs?id={{$vo['username']}}&moduleKey=usertax" class="op_log">记录</a>
                        {{--<a class="aback logs" href="../logs?type=tax&id={{$vo['username']}}">记录</a>--}}
                    </td>
                    {{--<td>{{$vo['ip']}}</td>
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
  <a class="previous"><a href='{{$list->path()}}?&page=1&username={{$username}}&parent={{$parent}}&online={{$online}}&fid1={{$fid1}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?&page={{$list->currentPage()-1}}&username={{$username}}&parent={{$parent}}&online={{$online}}&fid1={{$fid1}}'@endif>前一页</a>『
                       @for($i=1;$i<=$list->totalPage;$i++)
                            @if($i == $list->currentPage())
                                <span class="current">{{$i}}</span>&nbsp;
                            @else
                                @if($i == $list->totalPage)
                                    <a href='{{$list->path()}}?&page={{$i}}&username={{$username}}&parent={{$parent}}&online={{$online}}&fid1={{$fid1}}' class="page">{{$i}}</a>
                                @else
                                    <a href='{{$list->path()}}?&page={{$i}}&username={{$username}}&parent={{$parent}}&online={{$online}}&fid1={{$fid1}}' class="page">{{$i}}</a>&nbsp;
                                @endif
                            @endif
                        @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?&page={{$list->currentPage()+1}}&username={{$username}}&parent={{$parent}}&online={{$online}}&fid1={{$fid1}}'@endif>后一页</a>&nbsp;&nbsp; |
 <a class='next' href='{{$list->path()}}?&page={{$list->lastPage()}}&username={{$username}}&parent={{$parent}}&online={{$online}}&fid1={{$fid1}}'>末页</a>&nbsp;&nbsp;</span>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
<script>
    $(".share a").click(function() {
        var c = $("#shares");
        if (c.length == 0) {
            c = $('<div id="shares">').addClass("popdiv");
            c.dialog({
                autoOpen: false,
                width: 500,
                maxHeight: 400
            })
        }
        var k = $(this).attr("username");
        var i = $(this).attr("userid");
        c.dialog("option", {
            title: k + "# 占成明细"
        });
        c.empty();
        c.append('<span class="loading">载入中……</span>').load("/agent/user/shares", {
            userid: i
        });
        c.dialog("open")
    });
</script>
</html>
