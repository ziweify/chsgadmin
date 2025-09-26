<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>下注明细</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>
    <script>
  $(document).ready(function(){
    $(".page-jump input").on("keydown", function(e){
      if(e.keyCode === 13){
        e.stopPropagation();
        $(this).blur();
        if($(this).val() <= 0 || $(this).parent().data("total-page") < $(this).val()){
          alert("页面不存在");
          return;
        } else{
          var navigatePage = $(this).parent().data("page-url").replace("page=1", "page=" + $(this).val());
          location.href = location.origin + location.pathname + navigatePage;
        }
      }
    })
  })
    </script>
    <link href="/static/default/css/agent/bets.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/betExtra.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/static/default/js/bets.js"></script>
    <script type="text/javascript" src="/static/default/js/betExtra.js"></script>
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
                <th class="range th-box" style="width:170px">
                    <div class="bet_content">
                        投注内容
                    </div>
                    <div class="input_gameText" style="display:none;child-align: left">
                        <input type"search" placeholder="投注种类" name="gameText" value="{{$gameText}}" style="width:55px" />&nbsp;
                        <input type"search" placeholder="注单明细" name="text" value="{{$text}}" style="width:55px"/>
                    </div>
                    <button class="th_icon2"></button>
                </th>
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
        <div class="page_info">
            <span class="record">共 {{$rcount}} 笔注单</span>
            <span class="page_count">共 {{$pcount}} 页</span>
            <span class="page_control">
                <a class="first" href="?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&number={{$number}}&game={{$game}}&item={{$item}}&state={{$state}}&page=1">首页</a> |
                <span class="jump page-jump" data-total-page="{{$pcount}}">跳转至<input style="width: 50px" onblur="var p=$(this).val();if(p>0&&p<={{$pcount}})location.href=LIBS.url({page:p});else $(this).val('');"/>页</span>
                <a class="previous" @if($page-1 >= 1)href="?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&number={{$number}}&game={{$game}}&item={{$item}}&state={{$state}}&page={{$page-1}}"@endif>前一页</a>『
                 @for($i=$startpcount;$i<=$endpcount;$i++)
                    @if($i == $page)
                        <span class="current">{{$i}}</span>&nbsp;
                    @else
                        @if($i == $pcount)
                            <a href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&number={{$number}}&game={{$game}}&item={{$item}}&state={{$state}}&page={{$i}}' class="page">{{$i}}</a>
                        @else
                            <a href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&number={{$number}}&game={{$game}}&item={{$item}}&state={{$state}}&page={{$i}}' class="page">{{$i}}</a>&nbsp;
                        @endif
                    @endif
                @endfor
                』<a class='next' @if($page+1 <= $pcount)href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&number={{$number}}&game={{$game}}&item={{$item}}&state={{$state}}&page={{$page+1}}'@endif>后一页</a>&nbsp;|
                <a class='next' href='?minAmount={{$minAmount}}&maxAmount={{$maxAmount}}&lottery={{$lottery}}&number={{$number}}&game={{$game}}&item={{$item}}&state={{$state}}&page={{$pcount}}'>末页</a>
            </span>
        </div>
    </div>
</div>
</body>
</html>
