<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>注单明细</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/static/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/js/sweetalert.min.js"></script>
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
        var tax_name = '{{$tax_name}}';
    </script>
    <link href="/default/css/agent/bets.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/tax.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/bets.js?v=1"></script>
    <script type="text/javascript" src="/default/js/tax.js?v=1"></script>
</head>
<body>
<div class="main tax_bets">
    <div class="top_info">
        <span class="title">注单明细<button id="resetBetButton">恢复注单{{$tax_name}}</button></span>
    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th class="check"><input id="checkAll" type="checkbox" value="{{$username}}"/></th>
                <th class="th-box">注单号</th>
                <th>投注时间</th>
                <th class="type">投注种类</th>
                <th>账号</th>
                <th>投注内容</th>
                <th class="range">下注金额</th>
                <th>退水(%)</th>
                <th>下注结果</th>
                <th>本级占成</th>
                {{--<th class="result">本级结果</th>--}}
                <th class="result">{{$tax_name}}</th>
                <th>占成明细</th>
            </tr>
            </thead>
            @foreach($bao as $vo)
            <tbody>
            <tr>
                <td class="check"><input type="checkbox" value="{{$vo['code']}}" @disabled($vo['uzp'] <= 0) /></td>
                <td><a href='javascript:queryBetExtraDetail("{{$vo['user']}}", "{{$vo['code']}}", "{{$vo['lottery']}}","{{$vo['time']}}")'>{{$vo['code']}}#</a> </span>
                </td>
                <td>{{$vo['time']}} 星期{{$vo['week']}}</td>
                <td class="period">{{$vo['game']}}
                    <div class="drawNumber1">{{$vo['qishu']}}期</div>
                </td>
                <td>{{$vo['user']}}
                    <div>{{$vo['abcd']}}盘</div>
                </td>
                <td><span class="drawNumber1">{{$vo['wf1']}}『{{$vo['wf2']}}{{$vo['con']}}』</span> @ <span class="odds">{{$vo['peilv1']}}</span>
                </td>
                <td class="money">{{$vo['je']}}</td>
                <td class="commission">{{$vo['points']}}%</td>
                <td class="money dividend color">@if($settle == 'true'){{$vo['rs']}}@else<span>未结算</span>@endif</td>
                <td class="share">{{$vo['mezc']}}%</td>
               {{-- <td class="money color">@if($settle == 'true'){{$vo['mers']}}@else @endif</td>--}}
                <td class="money">{{$vo['tax']}} ({{$vo['uzp']}}%)</td>
                <td class="detail"><a bid="{{$vo['code']}}" drawDate="{{$vo['time']}}">明细</a></td>
            </tr>
            <tbody>
            @endforeach
            <tfoot>
            <tr>
                <th colspan="6">总计：{{$total['zs']}}笔</th>
                <td class="money">{{$total['je']}}</td>
                <td></td>
                <td class="money color">@if($settle == 'true'){{$total['jg']}}@endif</td>
                <td></td>
                {{--<td class="money color">@if($settle == 'true'){{$total['bj']}}@endif</td>--}}
                <td class="money">@if($settle == 'true'){{$total['bjtax']}}@endif</td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="page">
        <div class="page_info">
            <span class="record">共 {{$rcount}} 笔注单</span>
            <span class="page_count">共 {{$pcount}} 页</span>
            <span class="page_control">
                <a class="first" href="?username={{$username}}&settle={{$settle}}&page=1">首页</a> |
                <span class="jump" data-total-page="{{$pcount}}">跳转至<input style="width: 50px" onblur="var p=$(this).val();if(p>0&&p<={{$pcount}})location.href=LIBS.url({page:p});else $(this).val('');"/>页</span>
                <a class="previous" @if($page-1 >= 1)href="?username={{$username}}&settle={{$settle}}&page={{$page-1}}"@endif>前一页</a>『
                 @for($i=$startpcount;$i<=$endpcount;$i++)
                    @if($i == $page)
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $pcount)
                            <a href='?username={{$username}}&settle={{$settle}}&page={{$i}}' class="page">{{$i}}</a>
                        @else
                            <a href='?username={{$username}}&settle={{$settle}}&page={{$i}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                』<a class='next' @if($page+1 <= $pcount)href='?username={{$username}}&settle={{$settle}}&page={{$page+1}}'@endif>后一页</a>&nbsp;|
                <a class='next' href='?username={{$username}}&settle={{$settle}}&page={{$pcount}}'>末页</a>
            </span>
        </div>
    </div>
</div>
</body>
</html>
