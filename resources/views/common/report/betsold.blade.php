<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>注单明细</title>
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
    <script>
        $(document).ready(function () {
            $(".jump input").on("keydown", function (e) {
                if (e.keyCode === 13) {
                    e.stopPropagation();
                    $(this).blur();
                    if ($(this).val() <= 0 || $(this).parent().data("total-page") < $(this).val()) {
                        alert("页面不存在");
                        return;
                    } else {
                        var navigatePage = $(this).parent().data("page-url").replace("page=1", "page=" + $(this).val());
                        //console.log(location.origin + location.pathname + navigatePage);return ;
                        location.href = location.origin + location.pathname + navigatePage;
                    }
                }
            })
        })

    </script>
    <link href="/default/css/agent/bets.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/betExtra.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/bets.js"></script>
    <script type="text/javascript" src="/default/js/betExtra.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">注单明细</span>
        <span class="right">
            @if(count($datearr) > 0 && $begin != $end && $ifson==0)
	<span class="bet_date">选择日期：
        <select onchange="location.href=LIBS.url({date:$(this).val()})">
            @foreach($datearr as $vo)
                <option value="{{$vo['date']}}" @if($vo['date'] == $date) selected @endif>{{$vo['date']}} {{$vo['week']}} 【{{$vo['count']}} 笔】</option>
            @endforeach
		</select>
    </span>
            @endif
	<a class="back" href="javascript:history.go(-1)">返回</a>
</span>
    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th class="th-box">注单号
                </th>
                <th>投注时间</th>
                <th class="type th-box">投注种类
                </th>
                <th>账号</th>
                <th>投注内容</th>
                <th class="range th-box" style="width:250px">
                    <div class="display_amount">
                        下注金额
                    </div>
                    <div class="input_amount" style="display:none">
                        <input type="search" placeholder="最小下注金额" name="minAmount1" value="" style="width:80px" />&nbsp;
                        <input type="search" placeholder="最大下注金额" name="maxAmount1" value="" style="width:80px"/>
                    </div>
                    <button class="th_icon1"></button>
                </th>
                </th>
                <th>退水(%)</th>
                <th>下注结果</th>
                <th>本级占成</th>
                <th class="result">本级结果</th>
                @if($tax==1)<th class="result">赚点</th>@endif
                <th>占成明细</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bao as $vo)
                <tr>
                    <td>
                        <a href='javascript:queryBetExtraDetail("sss666", "20221124220827350581880001", "SGFT","2022-11-24 00:00:00")'>{{$vo['code']}}#</a>
                        @if(isset($vo['fly']) && $vo['fly'] == 1)<span class="back">代理补货</span>@endif</span>
                    </td>
                    <td>{{$vo['time']}} 星期{{$vo['week']}}</td>
                    <td class="period">{{$vo['game']}}
                        <div class="drawNumber1">{{$vo['qishu']}}期</div>
                    </td>
                    <td>{{$vo['user']}}
                        <div>{{$vo['abcd']}}盘</div>
                    </td>
                    <td><span class="drawNumber1">{{$vo['wf']}}</span> @if($vo['con'] != ''){{$vo['con']}}@endif @ <span class="odds">{{$vo['peilv1']}}</span>
                    </td>
                    <td class="money">{{$vo['je']}}</td>
                    <td class="commission">{{$vo['points']}}%</td>
                    <td class="money dividend color">@if($vo['z'] == 9)未结算@else{{$vo['rs']}}@endif</td>
                    <td class="share">{{$vo['mezc']}}%</td>
                    <td class="money color">@if($vo['z'] == 9)@else{{$vo['mers']}}@endif</td>
                    @if($tax==1)<td>{{$vo['tax']}}</td>@endif
                    <td class="detail"><a bid="{{$vo['code']}}" drawDate="{{$vo['time']}}">明细</a></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="5">总计：{{$total['zs']}}笔</th>
                <td class="money">{{$total['je']}}</td>
                <td></td>
                <td class="money color">@if($settle == 1){{$total['jg']}}@endif</td>
                <td></td>
                <td class="money color">@if($settle == 1){{$total['bj']}}@endif</td>
                @if($tax==1)<td align="center">@if($settle == 1){{$total['total_tax']}}@endif</td>@endif
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div id="betExtraDialog"></div>
    <div class="page">
        <div class="page_info">
            <span class="record">共 {{$rcount}} 笔注单</span>
            <span class="page_count">共 {{$pcount}} 页</span>
            <span class="page_control">
                <a class="first" href="?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&date={{$date}}&username={{$username}}&begin={{$begin}}&end={{$end}}&settle={{$settle}}&page=1">首页</a> |
                <span class="jump" data-total-page="{{$pcount}}">跳转至<input style="width: 50px" onblur="var p=$(this).val();if(p>0&&p<={{$pcount}})location.href=LIBS.url({page:p});else $(this).val('');"/>页</span>
                <a class="previous" @if($page-1 >= 1)href="?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&date={{$date}}&username={{$username}}&begin={{$begin}}&end={{$end}}&settle={{$settle}}&page={{$page-1}}"@endif>前一页</a>『
                 @for($i=$startpcount;$i<=$endpcount;$i++)
                    @if($i == $page)
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $pcount)
                            <a href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&date={{$date}}&username={{$username}}&begin={{$begin}}&end={{$end}}&settle={{$settle}}&page={{$i}}' class="page">{{$i}}</a>
                        @else
                            <a href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&date={{$date}}&username={{$username}}&begin={{$begin}}&end={{$end}}&settle={{$settle}}&page={{$i}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                』<a class='next' @if($page+1 <= $pcount)href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&date={{$date}}&username={{$username}}&begin={{$begin}}&end={{$end}}&settle={{$settle}}&page={{$page+1}}'@endif>后一页</a>&nbsp;|
                <a class='next' href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&date={{$date}}&username={{$username}}&begin={{$begin}}&end={{$end}}&settle={{$settle}}&page={{$pcount}}'>末页</a>
            </span>
        </div>
    </div>
</div>
</body>
</html>
