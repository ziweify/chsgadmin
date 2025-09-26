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
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/control.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/default/css/g_{{$template}}.css"/>
    <script type="text/javascript" src="/default/js/period.js"></script>
    <script type="text/javascript" src="/default/js/control.js"></script>
    <script type="text/javascript" src="/default/js/resultPanel.js"></script>
    <script type="text/javascript" src="/default/js/drawurls.js"></script>
    <script type="text/javascript" src="/default/js/hk6Base.js"></script>
    <script type="text/javascript" src="/default/js/balls.js"></script>
    <script type="text/javascript">
        var lottery = '{{$lottery}}';
        var template = '{{$template}}';
        var gameName = '{{$gameName}}';
        @if($varCanBack == 1)
        var varCanBack = true;
        var _BACK=true;
        @else
        var varCanBack = false;
        var _BACK=false;
        @endif
    </script>
</head>
<body class="L_{{$lottery}}">
<div class="main">
    <div class="top_info">
        <span id="drawNumber" class="title"></span>
        <div class="period">
            <span id="gameName"></span>
            <label id="cdOpen" style="display:none">距开盘：<span>00:00</span></label>
            <label id="cdClose" style="display:none">距封盘：<span>00:00</span></label>
            <label id="cdDraw">距开奖：<span>00:00</span></label>
            <label class="bresult">今日输赢：<span id="bresult">0.0</span></label>
        </div>
        <div class="op">
            <select id="range">
                <option value="">全部</option>
            </select>
            <select id="amountMode">
                <option value="SZ">实占</option>
                <option value="XZ">虚注</option>
                <option value="BH">补货</option>
            </select>
            <select id="sortMode">
                <option value="1">按盈亏排序</option>
                <option value="2">按金额排序</option>
                <option value="0">按号码排序</option>
            </select>
        </div>
        <div class="right">
            <div id="drawInfo">
                <ul class="balls"></ul>
                <span class="draw_number"></span>
            </div>
            <input id="btnRefresh" type="button" value="刷新"/>
            <div id="cdRefresh"></div>
            <select id="refreshInteval">
                <option value="-1">手动</option>
                <option value="10" selected="selected">10秒</option>
                <option value="20">20秒</option>
                <option value="30">30秒</option>
                <option value="40">40秒</option>
                <option value="50">50秒</option>
                <option value="60">60秒</option>
                <option value="99">99秒</option>
            </select>
        </div>
    </div>
    <div id="totals"></div>
    <div id="main" class="contents lt_{{$template}}">
        <script>
            var games = '{{$games}}';
            @if($template == 'PK10')
            var TOTAL = true;
            @if($page == 12)
            var totalGame = 'GYH';
            @endif
            @endif
            @if($page == 'dw2' || $page == 'dw3' || $page == 'zx3' || $page == 'zx6' || $page == 'fs' || $page == 'mp')
            var MULTIPLE = true;
            @endif
            @if($template == 'KLSF' && $page == 'ball')
            var TOTAL = true;
            var totalGame = '{{$qiu}}';
            var backGame = totalGame;
            @endif
            @if($template == 'K3')
            var TOTAL = 2;
            $(function () {
                ResultPanel.init($('#historyResult tbody'), [['period', -2], ['ball', 0], ['ball', 1], ['ball', 2], ['total'], ['zdx', 11, -1, true]]);
            });
            @endif
        </script>
        @if($template == 'PK10' && $page == '12')
            <x-htsgwin.pk10.12></x-htsgwin.pk10.12>
        @elseif($template == 'PK10' && $page == '3456')
            <x-htsgwin.pk10.3456></x-htsgwin.pk10.3456>
        @elseif($template == 'PK10' && $page == '78910')
            <x-htsgwin.pk10.78910></x-htsgwin.pk10.78910>
        @elseif($template == 'SSC' && $page == 'lm')
            <x-htsgwin.ssc.plm></x-htsgwin.ssc.plm>
        @elseif($template == 'SSC' && $page == 'dh')
            <x-htsgwin.ssc.pdh></x-htsgwin.ssc.pdh>
        @elseif($template == 'SSC' && $page == 'ts')
            <x-htsgwin.ssc.pts></x-htsgwin.ssc.pts>
        @elseif($template == 'SSC' && $page == '1z')
            <x-htsgwin.ssc.p1z></x-htsgwin.ssc.p1z>
        @elseif($template == 'SSC' && $page == '2z')
            <x-htsgwin.ssc.p2z></x-htsgwin.ssc.p2z>
        @elseif($template == 'SSC' && $page == '3z')
            <x-htsgwin.ssc.p3z></x-htsgwin.ssc.p3z>
        @elseif($template == 'SSC' && $page == 'dw2')
            <x-htsgwin.ssc.pdw2></x-htsgwin.ssc.pdw2>
        @elseif($template == 'SSC' && $page == 'dw3')
            <x-htsgwin.ssc.pdw3></x-htsgwin.ssc.pdw3>
        @elseif($template == 'SSC' && $page == '2zhs')
            <x-htsgwin.ssc.p2zhs></x-htsgwin.ssc.p2zhs>
        @elseif($template == 'SSC' && $page == '3zhs')
            <x-htsgwin.ssc.p3zhs></x-htsgwin.ssc.p3zhs>
        @elseif($template == 'SSC' && $page == 'zx3')
            <x-htsgwin.ssc.pzx3></x-htsgwin.ssc.pzx3>
        @elseif($template == 'SSC' && $page == 'zx6')
            <x-htsgwin.ssc.pzx6></x-htsgwin.ssc.pzx6>
        @elseif($template == 'SSC' && $page == 'fs')
            <x-htsgwin.ssc.pfs></x-htsgwin.ssc.pfs>
        @elseif($template == 'SSC' && $page == 'kd')
            <x-htsgwin.ssc.pkd></x-htsgwin.ssc.pkd>
        @elseif($template == 'SSC' && $page == 'dn')
            <x-htsgwin.ssc.pdn></x-htsgwin.ssc.pdn>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 1)
            <x-htsgwin.klsf.pball1></x-htsgwin.klsf.pball1>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 2)
            <x-htsgwin.klsf.pball2></x-htsgwin.klsf.pball2>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 3)
            <x-htsgwin.klsf.pball3></x-htsgwin.klsf.pball3>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 4)
            <x-htsgwin.klsf.pball4></x-htsgwin.klsf.pball4>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 5)
            <x-htsgwin.klsf.pball5></x-htsgwin.klsf.pball5>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 6)
            <x-htsgwin.klsf.pball6></x-htsgwin.klsf.pball6>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 7)
            <x-htsgwin.klsf.pball7></x-htsgwin.klsf.pball7>
        @elseif($template == 'KLSF' && $page == 'ball' && $index == 8)
            <x-htsgwin.klsf.pball8></x-htsgwin.klsf.pball8>
        @elseif($template == 'KLSF' && $page == 'zh')
            <x-htsgwin.klsf.pzh></x-htsgwin.klsf.pzh>
        @elseif($template == 'KLSF' && $page == 'mp')
            <x-htsgwin.klsf.pmp></x-htsgwin.klsf.pmp>
        @elseif($template == '11X5' && $page == 'lm')
            <x-htsgwin.11x5.plm></x-htsgwin.11x5.plm>
        @elseif($template == '11X5' && $page == 'dh')
            <x-htsgwin.11x5.pdh></x-htsgwin.11x5.pdh>
        @elseif($template == '11X5' && $page == 'mp')
            <x-htsgwin.11x5.pmp></x-htsgwin.11x5.pmp>
        @elseif($template == 'KL8' && $page == 'all')
            <x-htsgwin.kl8.pall></x-htsgwin.kl8.pall>
        @elseif($template == 'KL8' && $page == 'ball')
            <x-htsgwin.kl8.pball></x-htsgwin.kl8.pball>
        @elseif($template == 'K3' && $page == 'all')
            <x-htsgwin.k3.pall></x-htsgwin.k3.pall>
        @endif
    </div>
    <div class="control data_footer input_panel">
<span id="backControl"><span>快速补货：</span><input type="text" class="input"/> <label><input type="radio"
                                                                                              name="backAmountType"
                                                                                              value="0"
                                                                                              checked="checked"/>平均盈亏</label>
<label><input type="radio" name="backAmountType" value="1"/>占成金额</label>
<input type="button" class="calc button" value="计算补货"/></span>
    </div>
    @if($ifexe == 1)
    <div id="oddsSetting">
        <div class="oddsControl"><span class="step">调赔幅度：<select id="oddsStep" name="">
<option value="0.001">0.001</option>
<option value="0.002">0.002</option>
<option value="0.003">0.003</option>
<option value="0.004">0.004</option>
<option value="0.005">0.005</option>
<option value="0.01" selected="selected">0.01</option>
<option value="0.02">0.02</option>
<option value="0.03">0.03</option>
<option value="0.04">0.04</option>
<option value="0.05">0.05</option>
<option value="0.1">0.1</option>
<option value="0.2">0.2</option>
<option value="0.3">0.3</option>
<option value="0.4">0.4</option>
<option value="0.5">0.5</option>
<option value="1">1</option>
</select>
</span><span class="oddsCtl oc0"></span> <span class="oddsCtl oc1"></span></div>
        <div id="inputodds">输入调赔：<input type="text" id="oddsInput" class="input_text"/><input type="button"
                                                                                                  value="确定"
                                                                                                  class="edit"></div>
        <div class="quick"><a onclick="toggleAll(true)">全选</a> <a onclick="toggleAll()">反选</a> <a
                onclick="toggleAll(false)">取消</a></div>
    </div>
</div>
@endif
<div id="backPanel" class="ui-dialog popdiv" style="display:none">
    <div class="title">补货单</div>
    <div><label>类型</label><span class="text">总和大</span></div>
    <div><label>赔率</label><span class="odds">1.958</span></div>
    <div class="input_panel"><label>金额</label><span><input class="input"/></span></div>
    <div><label>限额</label><span class="limit">50</span></div>
    <div class="bottom">
        <input type="button" class="but" value="补出" onclick="doBet()"/>
        <input type="button" class="but" value="取消" onclick="backClose()"/>
    </div>
</div>
</body>
</html>
