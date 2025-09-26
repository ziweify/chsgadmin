<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <script type="text/javascript">
        var currentUserName = "{{$cuser}}";
    </script>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>
    <link href="/static/default/css/agent/report.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/stupidtable.js"></script>
    <script type="text/javascript" src="/static/default/js/report.js?v=1111"></script>
    <script type="text/javascript">
        $(function() {
            LIBS.colorMoney('.color', 'minus')
        })
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">@if(isset($layername)){{$layername}}（{{$cuser}}） - @endif交收报表 [{{$begin}} — {{$end}}] @if($period!='') [ 期数：{{$period}} ]@endif</span>
        <span class="right"><a class="back" href="javascript:history.go(-1)">返回</a></span>
    </div>
    <div class="contents">
        @if(!isset($msg))
        <table class="data_table list report">
            <caption>合计</caption>
            <thead>
            <tr class="shead">
                <th rowspan="2">级别</th>
                <th rowspan="2" data-sort="string" class="sortable sortdefault sorting-asc">账号</th>
                <th rowspan="2">名称</th>
                <th rowspan="2">余额</th>
                <th rowspan="2" class="count sortable" data-sort="number">笔数</th>
                <th rowspan="2" data-sort="number" class="sortable">下注金额</th>
                <th rowspan="2">有效金额</th>
                <th colspan="{{($tax==1 && $water==1) ? 6 : ($tax==1 ? 4 : ($water==1 ? 5 : 3))}}">会员输赢</th>
                <th colspan="{{$tax == 1 ? 8 : 7}}">{{$layername}}输赢</th>
                @if($layer==0 && $enable_mjpei==1)<th rowspan="2" style="color: red; font-weight: bold;">明降</th> @endif
                <th rowspan="2">上交货量</th>
                <th rowspan="2" data-sort="number" class="sortable ca">上级交收</th>
            </tr>
            <tr class="shead">
                <th>输赢</th>
                <th>退水</th>
                <th>盈亏结果</th>
                @if($tax==1)
                <th style="color: red; font-weight: bold;">{{$tax_name}}</th>
                @endif
                @if($water==1)
                <th style="color: red; font-weight: bold;">{{$water_name}}1</th>
                <th style="color: red; font-weight: bold;">{{$water_name}}2</th>
                @endif
                <th data-sort="number" class="sortable self ca">应收下线</th>
                <th>占成</th>
                <th>实占金额</th>
                <th>实占结果</th>
                <th>实占退水</th>
                <th>赚水</th>
                @if($tax==1)
                <th style="color: red; font-weight: bold;">{{$tax_name}}</th>
                @endif
                <th class="ca">盈亏结果</th>
                <!--<th class="ca">降赔利润</th><th class="ca">实占降赔</th>-->
            </tr>
            </thead>
            @if(count($mbao) > 0)
            <tbody>
            @foreach($mbao as $vo)
            <tr>
                @if($vo['fly']==0)
                <td class="info">{{$vo['layername']}}</td>
                <td class="info">@if($isagent==0 || in_array('report.member.bets',$auths) || $vo['ifagent']==1)<a href="javascript:pick('{{$vo['user']}}',{{$vo['ifagent']==1 ? 2 : 1}})">{{$vo['user']}}</a>@else{{$vo['user']}}@endif</td>
                <td class="info">{{$vo['name']}}</td>
                <td class="info">{{$vo['money']}}</td>
                @else
                <td colspan="4" class="info"><a href="javascript:pick('{{$vo['user']}}',{{$vo['ifagent']==1 ? 2 : 1}})">补货</a></td>
                @endif
                <td>{{$vo['zs']}}</td>
                <td>@if($isagent==0 || in_array('report.member.bets',$auths) || $vo['ifagent']==1)<a href="javascript:pick('{{$vo['user']}}',{{$vo['ifagent']==1 ? 2 : 1}})">{{$vo['sje']}}</a>@else{{$vo['sje']}}@endif</td>
                <td>{{$vo['uje']}}</td>
                <td>{{$vo['ushuying']}}</td>
                <td>{{$vo['ushui']}}</td>
                <td>{{$vo['uyk']}}</td>
                @if($tax==1)
                <td>{{$vo['tax']}}</td>
                @endif
                @if($water==1)
                    <td>{{$vo['zeje']}}</td>
                    <td>{{$vo['water_result']}}</td>
                @endif
                <td class="result color">{{0-$vo['yk']}}</td>
                <td>{{$vo['mezcp']}}</td>
                <td>{{$vo['mezc']}}</td>
                <td>{{$vo['shizhanjieguo']}}</td>
                <td>{{0-$vo['meshui']}}</td>
                <td>{{$vo['zuanshui']}}</td>
                    @if($tax==1)
                <td>{{$vo['metax']}}</td>
                    @endif
                <td class="result color">{{$vo['yingkuijieguo']}}</td>
                @if($layer==0 && $enable_mjpei==1)<td>{{isset($vo['jpei_money']) ? $vo['jpei_money'] :0}}</td>@endif
                <td>{{$vo['sendje']}}</td>
                <td class="result color">{{$vo['sendyk']}}</td>
            </tr>
            @endforeach
            </tbody>
            @endif
        </table>
        @if(count($mbao) > 0 && $detail == 0)
        <p class="more_detail"><a onclick="location.href=LIBS.url({detail:1})">+ 显示各彩种明细</a></p>
        @endif
        @else
        {{$msg}}
        @endif
        @if($detail == 1)
        @foreach($gbao as $gb)
        <table class="data_table list report data_table1">
            <caption>{{$gb['gname']}}</caption>
            <thead>
            <tr class="shead">
                <th rowspan="2">级别</th>
                <th rowspan="2" data-sort="string" class="sortable sortdefault sorting-asc">账号</th>
                <th rowspan="2">名称</th>
                <th rowspan="2">余额</th>
                <th rowspan="2" class="count sortable" data-sort="number">笔数</th>
                <th rowspan="2" data-sort="number" class="sortable">下注金额</th>
                <th rowspan="2">有效金额</th>
                <th colspan="{{($tax==1 && $water==1) ? 6 : ($tax==1 ? 4 : ($water==1 ? 5 : 3))}}">会员输赢</th>
                <th colspan="{{$tax == 1 ? 8 : 7}}">{{$layername}}输赢</th>
                @if($layer==0 && $enable_mjpei==1)<th rowspan="2" style="color: red; font-weight: bold;">明降</th> @endif
                <th rowspan="2">上交货量</th>
                <th rowspan="2" data-sort="number" class="sortable ca">上级交收</th>
            </tr>
            <tr class="shead">
                <th>输赢</th>
                <th>退水</th>
                <th>盈亏结果</th>
                @if($tax==1)
                    <th style="color: red; font-weight: bold;">{{$tax_name}}</th>
                @endif
                @if($water==1)
                    <th style="color: red; font-weight: bold;">{{$water_name}}1</th>
                    <th style="color: red; font-weight: bold;">{{$water_name}}2</th>
                @endif
                <th data-sort="number" class="sortable self ca">应收下线</th>
                <th>占成</th>
                <th>实占金额</th>
                <th>实占结果</th>
                <th>实占退水</th>
                <th>赚水</th>
                @if($tax==1)
                <th style="color: red; font-weight: bold;">{{$tax_name}}</th>
                @endif
                <th class="ca">盈亏结果</th>
                <!--<th class="ca">降赔利润</th><th class="ca">实占降赔</th>-->
            </tr>
            </thead>
            <tbody>
            @foreach($gb['bao'] as $vo)
                <tr>
                    @if($vo['fly']==0)
                        <td class="info">{{$vo['layername']}}</td>
                        @if($vo['ifagent']==1 && $vo['fly']==0)
                            <td class="info"><a href="javascript:pick('{{$vo['user']}}',2)">{{$vo['user']}}</a></td>
                        @else
                            <td class="info">@if($isagent==0 || in_array('report.member.bets',$auths))<a href="javascript:pick('{{$vo['user']}}',1,'{{$gb['lottery']}}')">{{$vo['user']}}</a>@else{{$vo['user']}}@endif</td>
                        @endif
                        <td class="info">{{$vo['name']}}</td>
                        <td class="info">{{$vo['money']}}</td>
                    @else
                        <td colspan="4" class="info"><a href="javascript:pick('{{$vo['user']}}',1,'{{$gb['lottery']}}')">补货</a></td>
                    @endif
                    <td>{{$vo['zs']}}</td>
                    @if($vo['ifagent']==1 && $vo['fly']==0)
                    <td><a href="javascript:pick('{{$vo['user']}}',2)">{{$vo['sje']}}</a></td>
                    @else
                    <td>@if($isagent==0 || in_array('report.member.bets',$auths))<a href="javascript:pick('{{$vo['user']}}',1,'{{$gb['lottery']}}')">{{$vo['sje']}}</a>@else{{$vo['sje']}}@endif</td>
                    @endif
                    <td>{{$vo['uje']}}</td>
                    <td>{{$vo['ushuying']}}</td>
                    <td>{{$vo['ushui']}}</td>
                    <td>{{$vo['uyk']}}</td>
                    @if($tax==1)
                        <td>{{$vo['tax']}}</td>
                    @endif
                    @if($water==1)
                        <td>{{$vo['zeje']}}</td>
                        <td>{{$vo['water_result']}}</td>
                    @endif
                    <td class="result color">{{0-$vo['yk']}}</td>
                    <td>{{$vo['mezcp']}}</td>
                    <td>{{$vo['mezc']}}</td>
                    <td>{{$vo['shizhanjieguo']}}</td>
                    <td>{{0-$vo['meshui']}}</td>
                    <td>{{$vo['zuanshui']}}</td>
                        @if($tax==1)
                            <td>{{$vo['metax']}}</td>
                        @endif
                    <td class="result color">{{$vo['yingkuijieguo']}}</td>
                    @if($layer==0 && $enable_mjpei==1)<td>{{isset($vo['jpei_money']) ? $vo['jpei_money'] :0}}</td>@endif
                    <td>{{$vo['sendje']}}</td>
                    <td class="result color">{{$vo['sendyk']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endforeach
        @endif
        @if($detail==1)<p class="more_detail"><a onclick="location.href=LIBS.url({detail:0})">- 隐藏彩种明细</a></p>@endif
    </div>
    <div class="data_footer"></div>
</div>
</body>

</html>
