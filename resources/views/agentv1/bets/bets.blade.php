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
    <link href="/default/css/agent/bets.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/betExtra.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/bets.js"></script>
    <script type="text/javascript" src="/default/js/betExtra.js"></script>
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
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">下注明细</span>
        <span class="right"><a class="close" href="javascript:window.close()">关闭</a></span>
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
                <th>退水</th>
                <th>下注结果</th>
                <th>本级占成</th>
                <th class="result">本级结果</th>
                <th>占成明细</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bao as $vo)
            <tr>
                <td>
                    <a href='javascript:queryBetExtraDetail("sss666", "20221124220827350581880001", "SGFT","2022-11-24 00:00:00")'>{{$vo['code']}}#</a>
                    @if(isset($vo['fly']) && $vo['fly'] == 1)<span class="back">代理补货</span>@endif
                    </span>
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
                <td class="detail"><a bid="{{$vo['code']}}" drawDate="{{$vo['time']}}">明细</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="betExtraDialog"></div>
    <div class="page">
        @if($rcount > 0)
        <div class="page_info" pcount="{{$pcount}}" page="{{$page}}">
            <span class="record">共 {{$rcount}} 笔注单</span>
            <span class="page_count">共 {{$pcount}} 页</span>
            <span class="page_control">
  <a class="previous">首页</a> |
<span class="page-jump" data-total-page="1" data-page-url="?lottery=SGFT&number=20221124266&game=GDX&item=D&page=1">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous">前一页</a>『
                <span class="current">1</span>
』<a class="next">后一页</a> |
  <a class="next">末页</a>
</span>
        </div>
    </div>
    @endif
</div>
</body>
<script>
    var page =1;
    var pcount = Number($(".page_info").attr('pcount'));
    page = Number($(".page_info").attr('page'));
    var pstr = "<a class='first'>首页</a> | <a class='prev'>前一页</a>『";
    for (i = 1; i <= pcount; i++) {
        if (i == page) {
            pstr += "<span class='current'>&nbsp;" + i + "&nbsp;</span>"
        } else {
            pstr += "&nbsp;<a href='javascript:void(0)' class='p'>" + i + "</a>&nbsp;"
        }
    }
    pstr += "』<a class='next'>后一页</a>";
    $(".page_control").html(pstr);
    pstr = null;
    $(".page a").click(function() {
        if ($(this).hasClass('first')) {
            page = 1
        } else if ($(this).hasClass('prev')) {
            page -= 1
        } else if ($(this).hasClass('next')) {
            page += 1
        } else {
            page = Number($(this).html())
        }
        if (page < 1) page = 1;
        if (page > pcount) page = pcount;
        window.location.href = "./bets?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&number={{$number}}&game={{$game}}&item={{$item}}&state={{$state}}&page=" + page;
    })
</script>
</html>
