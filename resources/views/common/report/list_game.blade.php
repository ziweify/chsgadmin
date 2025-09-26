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
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>
    <link href="/static/default/css/agent/report.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/stupidtable.js"></script>
    <script type="text/javascript" src="/static/default/js/report.js?v161004"></script>
    <script type="text/javascript">$(function(){LIBS.colorMoney('.color','minus')})</script>
</head>
<!--
 -->
<body>
<div class="main">
    <div class="top_info">
        <span class="title">@if(!empty($layername)){{$layername}}（{{$cuser}}) -@endif分类报表 [{{$begin}} — {{$end}}] @if($period!='') [ 期数：{{$period}} ]@endif</span>
        <span class="right"><a class="back" href="javascript:history.go(-1)">返回</a></span>
    </div>
    <div class="contents">
        @if(!isset($msg))
            <table class="data_table list report ">
                <caption>合计</caption>
                <thead>
                <tr class="shead">
                    <th rowspan="2">彩种</th>
                    <th rowspan="2" data-sort="string" class="sortable">玩法</th>
                    <th rowspan="2" class="count sortable" data-sort="number">笔数</th>
                    <th rowspan="2" data-sort="number" class="sortable">下注金额</th>
                    <th rowspan="2">有效金额</th>
                    <th colspan="{{($tax==1 && $water==1) ? 6 : ($tax==1 ? 4 : ($water==1 ? 5 : 3))}}">会员输赢</th>
                    <th colspan="{{$tax == 1 ? 8 : 7}}">{{$layername}}输赢</th>
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
                </tr>
                </thead>
                <tbody>
                @foreach($bao as $vo)
                <tr>
                    <td class="info">{{$vo['gname']}}</td>
                    <td class="info" data-sort-val="0">{{$vo['bname']}}</td>
                    <td>{{$vo['zs']}}</td>
                    <td>
                        @if($isagent==0 || in_array('report.member.bets',$auths))<a href="    javascript:pick('',1,'{{$vo['lottery']}}','{{$vo['bid']}}')
">{{$vo['sje']}}</a>@else{{$vo['sje']}}@endif
                    </td>
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
                    <td>{{$vo['sendje']}}</td>
                    <td class="result color">{{$vo['sendyk']}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        @else
            {{$msg}}
        @endif
    </div>
    <div class="data_footer"></div>
</div>
</body>
</html>
