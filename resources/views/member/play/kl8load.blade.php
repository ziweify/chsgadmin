<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/balls.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_KL8.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/modal.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/dialog.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/period.js?v=0113"></script>
    <script type="text/javascript" src="/static/default/js/bet.js?v=0113"></script>
    <script type="text/javascript" src="/static/default/js/moment.js"></script>
    <script type="text/javascript" src="/static/default/js/results.js"></script>
    <script type="text/javascript" src="/static/default/js/resultPanel.js"></script>
    <script type="text/javascript" src="/static/default/js/pagemap.js"></script>
    <script type="text/javascript" src="/static/default/js/drawurls.js"></script>
    <script type="text/javascript" src="/static/default/js/defaultbet.js"></script>
    <script type="text/javascript" src="/static/default/js/rightpanel.js"></script>
    <script type="text/javascript" src="/static/default/js/modal.js"></script>
    <script type="text/javascript">
        var lottery = '{{$lottery}}';
        var lotteryName = '{{$gname}}';
        var lotteryType = '0';
        var template = '{{$template}}'
        var page = '{{$page}}';
        var index = '{{$index}}';
        var index2 = '{{$index2}}';
        LIBS.cookie('page', '{{$page}}');
        LIBS.cookie('index', '{{$index}}');
        LIBS.cookie('index2', '{{$index2}}');
    </script>

    <!--
     -->
</head>
<body class="L_{{$lottery}} P_{{$page}}">
<div id="mainlottery">
    <div id="main">
        <div id="header">
            <div class="lottery_info">
                <div class="lottery_info_left floatleft"><span class="name" id="lotteryName">{{$gname}}</span> &mdash;
                    <span class="gameName" id="gameName"></span><span class="result">&nbsp;今日输赢：<span id="bresult">0.0</span></span>
                </div>
                <div class="lottery_info_right floatright"><span id="drawNumber"></span>期<span class="cdContainer">&nbsp;&nbsp;距离封盘：<span
                            class="color_lv bold"><span id="cdClose"></span></span></span>
                    <span class="cdContainer" style="display:none">&nbsp;&nbsp;距开盘：<span class="color_lv bold"><span
                                id="cdOpen"></span></span></span>
                    &nbsp;&nbsp;距离开奖：<span class="color_lv bold"><span id="cdDraw"></span></span>
                    <span id="cdRefresh" style="float:right;width: 50px;"><span>加载中…</span></span>
                </div>
                <div class="clearfloat"></div>
            </div>
        </div>
        <div class="control n_anniu">
            <input type="button" class="button2 show-result-list-btn" value="查看近期开奖" onClick="showResultList();"
                   style="float:right;"/>
            <div class="buttons">
                <label class="checkdefault"><input type="checkbox" class="checkbox"/><span
                        class="color_lv bold">预设</span></label>&nbsp;&nbsp;<label id="quickAmount"
                                                                                    class="quickAmount"><span
                        class="color_lv bold">金额</span> <input/></label>
                <input type="button" onclick="bet()" value="确定" class="button"/>
                <input type="button" onclick="resetBets()" value="重置" class="button"/>
                <input type="button" class="button" value="重覆上次下单" onclick="repeatbet()" style="width: 100px"/>
            </div>
        </div>
        <div id="bet_panel" class="bet_panel input_panel">
            <script type="text/javascript">
                var games = 'ZDX,ZDS,ZHT,DXDS,QHH,DSH,WX';
                $(function () {
                    Results.init({
                        '总和数': ['ZHT'],
                        '总和大小': ['ZDX', 'dx'],
                        '总和单双': ['ZDS', 'ds'],
                        '五行': ['WX', 'wx'],
                        '前後和': ['QHH', 'qh'],
                        '单双和': ['DSH', 'ds']
                    });
                });
            </script>
            @if($page == 'all')
            <x-sgwin.kl8.all></x-sgwin.kl8.all>
            @elseif($page == 'balls')
            <x-sgwin.kl8.balls></x-sgwin.kl8.balls>
            @endif
        </div>
        <div class="control bcontrol">
            <div class="lefts" style="display:none">已经选中 <span id="betcount"></span> 注</div>
            <div class="buttons">
                <input type="button" class="button2" value="快选金额" onclick="parent.showsetting()"/>
                <label class="checkdefault"><input type="checkbox" class="checkbox"/><span
                        class="color_lv bold">预设</span></label>&nbsp;&nbsp;<label id="quickAmount"
                                                                                    class="quickAmount"><span
                        class="color_lv bold">金额</span> <input/></label>
                <input type="button" class="button" value="确定" onclick="bet()"/>
                <input type="button" class="button" value="重置" onclick="resetBets()"/>
                <input type="button" class="button" value="重覆上次下单" onclick="repeatbet()" style="width: 100px"/>
            </div>
        </div>
    </div>
</div>
<table id="changlong">
    <thead>
    <tr>
        <th colspan="2" class="table_side">两面长龙排行</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>
</body>
</html>
