<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>外部注单</title>
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
    <link href="/default/css/agent/bets.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(function () {
            $('#date').change(function () {
                location.href = LIBS.url({
                    date: $(this).val()
                })
            }).datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });
            $('#status').change(function () {
                location.href = LIBS.url({
                    status: $(this).val()
                })
            });
            $('#userid').change(function () {
                location.href = LIBS.url({
                    userid: $(this).val()
                })
            });
            var ref = $('#refresh');
            if (ref.length) {
                var timeout = 10;
                window.setInterval(function () {
                    timeout -= 1;
                    if (timeout == 0) {
                        ref.click();
                    }
                    if (timeout >= 0) {
                        ref.text('刷新 (' + timeout + ')');
                    }
                }, 1000);
            }
        });
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$outbet_name}}注单&nbsp;&nbsp;&nbsp;合并订单总数:{{$zgcount}}&nbsp;&nbsp;合并订单成功数:{{$zccount}}&nbsp;&nbsp;合并订单失败数:{{$zscount}}</span>
        <span class="right"><button id="refresh" onclick="location.reload()">刷新 (10)</button><span>日期：<input
            id="date" value="{{$date}}"/></span> <span>状态：<select id="status" name="">
	<option value="" selected="selected">全部</option>
        <option @selected($status=='7') value="7">补货中</option>
        <option @selected($status=='8') value="8">成功</option>
        <option @selected($status=='9') value="9">失败</option>
</select>
@if(isset($ht))
所属代理：
    <select id="userid" name="">
    <option value="">全部</option>
    @foreach($flyuserlist as $vo)
    <option @selected($userid==$vo['userid']) value="{{$vo['userid']}}">{{$vo['username']}}</option>
    @endforeach
    </select>
@endif
                @if(isset($ht))<a class="back" onclick="history.back()">返回</a>@endif
</span></span>

    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th>注单号</th>
                <th>投注种类</th>
                <th>账号</th>
                <th>投注内容</th>
                <th>会员下注金额</th>
                <th>补货金额</th>
                <th>状态</th>
                <th>出货账号</th>
                <th>出货时间</th>
                <th>完成时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $vo)
            <tr>
                <td>{{$vo['orderno']}}#</td>
                <td class="period">{{$vo['gname']}}
                    <div class="drawNumber">{{$vo['qishu']}}期</div>
                </td>
                <td>{{$vo['username']}}
                    <div>{{$vo['abcd']}}盘</div>
                </td>
                <td>
                    <span class="text">{{$vo['wf']}}</span>@if($vo['ab'] != 'G') @ <span class="odds">{{$vo['peilv1']}}@endif</span>
                </td>
                <td class="money">{{$vo['mje']}}</td>
                <td class="money">{{$vo['je']}}</td>
                <td><span class="success">{{$vo['svstr']}}</span>@if(isset($vo['reason']))<br/><span>{{$vo['reason']}}</span>@endif</td>
                <td>{{$vo['sitename']}}-{{$vo['account']}}
                    @if($vo['ab'] != 'G')<div class="obid">{{$vo['code']}}</div>@endif
                </td>
                <td>{{$vo['xtime']}}</td>
                <td>{{$vo['time']}}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
    <div class="page">
        <div class="page_info">
            <span class="record">共 {{$rcount}} 笔注单</span>
            <span class="page_count">共 {{$pcount}} 页</span>
            <span class="page_control">
                <a class="first" href="?status={{$status}}&date={{$date}}&page=1&userid={{$userid}}">首页</a> |
                <span class="jump">跳转至<input style="width: 50px" onblur="var p=$(this).val();if(p>0&&p<={{$pcount}})location.href=LIBS.url({page:p});else $(this).val('');"/>页</span>
                <a class="previous" @if($page-1 >= 1)href="?status={{$status}}&date={{$date}}&page={{$page-1}}&userid={{$userid}}"@endif>前一页</a>『
                 @for($i=$startpcount;$i<=$endpcount;$i++)
                    @if($i == $page)
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $pcount)
                            <a href='?status={{$status}}&date={{$date}}&page={{$i}}&userid={{$userid}}' class="page">{{$i}}</a>
                        @else
                            <a href='?status={{$status}}&date={{$date}}&page={{$i}}&userid={{$userid}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                』<a class='next' @if($page+1 <= $pcount)href='?status={{$status}}&date={{$date}}&page={{$page+1}}&userid={{$userid}}'@endif>后一页</a>&nbsp;|
                <a class='next' href='?status={{$status}}&date={{$date}}&page={{$pcount}}&userid={{$userid}}'>末页</a>
            </span>
        </div>
    </div>
</div>
</body>
</html>
