<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/balls.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_KLSF.css"/>
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
                var games = 'DX1,DX2,DX3,DX4,DX5,DX6,DX7,DX8,WDX1,WDX2,WDX3,WDX4,WDX5,WDX6,WDX7,WDX8,DS1,DS2,DS3,DS4,DS5,DS6,DS7,DS8,HDS1,HDS2,HDS3,HDS4,HDS5,HDS6,HDS7,HDS8,ZDX,ZDS,ZWDX,LH1,LH2,LH3,LH4';
                @if($page == 'zm')
                $(function(){
                    Results.init({
                        '总和大小' : ['ZDX','dx'],
                        '总和单双' : ['ZDS','ds'],
                        '总和尾数大小' : ['ZWDX','dx']
                    });
                    Results.changeIndex(3);
                });
                @elseif($page != 'zm' && $page != 'mp')
                $(function () {
                    Results.init({
                        '': ['B{0}'],
                        '大小': ['DX{0}', 'dx'],
                        '单双': ['DS{0}', 'ds'],
                        '龙虎': ['LH{0}', 'lh'],
                        '尾数大小': ['WDX{0}', 'dx'],
                        '合数单双': ['HDS{0}', 'ds'],
                        '总和大小': ['ZDX', 'dx'],
                        '总和单双': ['ZDS', 'ds'],
                        '总尾大小': ['ZWDX', 'dx']
                    }, 1, 20, ['第一球', '第二球', '第三球', '第四球', '第五球', '第六球', '第七球', '第八球'], 1, true);
                });
                @endif
                @if($page == 'mp')
                var MULTIPLE=[0];
                $(function() {
                    $(".n_anniu .buttons").remove();
                    $(".n_anniu").css("position", "relative");
                    $('.games input[name=game]').change(function(){
                        id = $(this).attr("id");
                        LIBS.cookie('index2', id);
                    })
                });
                @endif
            </script>
            @if($page == 'lm')
            <x-sgwin.klsf.lm></x-sgwin.klsf.lm>
            @elseif($page == 'balls')
            <x-sgwin.klsf.balls></x-sgwin.klsf.balls>
            @elseif($page == 'ball' && $index == 1)
            <x-sgwin.klsf.ball1></x-sgwin.klsf.ball1>
            @elseif($page == 'ball' && $index == 2)
            <x-sgwin.klsf.ball2></x-sgwin.klsf.ball2>
            @elseif($page == 'ball' && $index == 3)
            <x-sgwin.klsf.ball3></x-sgwin.klsf.ball3>
            @elseif($page == 'ball' && $index == 4)
            <x-sgwin.klsf.ball4></x-sgwin.klsf.ball4>
            @elseif($page == 'ball' && $index == 5)
            <x-sgwin.klsf.ball5></x-sgwin.klsf.ball5>
            @elseif($page == 'ball' && $index == 6)
            <x-sgwin.klsf.ball6></x-sgwin.klsf.ball6>
            @elseif($page == 'ball' && $index == 7)
            <x-sgwin.klsf.ball7></x-sgwin.klsf.ball7>
            @elseif($page == 'ball' && $index == 8)
            <x-sgwin.klsf.ball8></x-sgwin.klsf.ball8>
            @elseif($page == 'zm')
            <x-sgwin.klsf.zm></x-sgwin.klsf.zm>
            @elseif($page == 'mp')
            <x-sgwin.klsf.mp></x-sgwin.klsf.mp>
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

<script type="text/javascript" src="/static/default/js/fastBet.js"></script>
<script type="text/javascript">
    var BALL_NUMBERS = 8;
    var RANK_BALL_NUMBERS = 20;
    var fastBets = [];
    var games = 'DX1,DX2,DX3,DX4,DX5,DX6,DX7,DX8,WDX1,WDX2,WDX3,WDX4,WDX5,WDX6,WDX7,WDX8,DS1,DS2,DS3,DS4,DS5,DS6,DS7,DS8,' +
        'HDS1,HDS2,HDS3,HDS4,HDS5,HDS6,HDS7,HDS8,ZDX,ZDS,ZWDX,LH1,LH2,LH3,LH4,B1,B2,B3,B4,B5,B6,B7,B8,' +
        'ZM,MP,ZFB,WDX1,WDX2,WDX3,WDX4,WDX5,WDX6,WDX7,WDX8,HDS1,HDS2,HDS3,HDS4,HDS5,HDS6,HDS7,HDS8,' +
        'FS,FW,FW1,FW2,FW3,FW4,FW5,FW6,FW7,FW8,ZFB1,ZFB2,ZFB3,ZFB4,ZFB5,ZFB6,ZFB7,ZFB8,LH1,LH2,LH3,LH4,' +
        'LM2,LM22,LM3,LM32,LM4,LM5';
    var guestDefault = ["DX_D", "DX_X", "DS_D", "DS_S", "WDX_D", "WDX_X", "HDS_D", "HDS_S", "LH_L", "LH_H",
        "BALL_DX_D", "BALL_DX_X", "BALL_DS_D", "BALL_DS_S", "BALL_WDX_D", "BALL_WDX_X"];
    const ballsNameMap = new Map([
        [1, "第一球"],
        [2, "第二球"],
        [3, "第三球"],
        [4, "第四球"],
        [5, "第五球"],
        [6, "第六球"],
        [7, "第七球"],
        [8, "第八球"],
        ["B1", "第一球"],
        ["B2", "第二球"],
        ["B3", "第三球"],
        ["B4", "第四球"],
        ["B5", "第五球"],
        ["B6", "第六球"],
        ["B7", "第七球"],
        ["B8", "第八球"]
    ]);
    const betNameMap = new Map([
        ["DX_D", "大"],
        ["ZDX_D", "总和大"],
        ["DX_X", "小"],
        ["ZDX_X", "总和小"],
        ["DS_D", "单"],
        ["ZDS_D", "总和单"],
        ["DS_S", "双"],
        ["ZDS_S", "总和双"],
        ["WDX_D", "尾大"],
        ["ZWDX_D", "总和尾大"],
        ["WDX_X", "尾小"],
        ["ZWDX_X", "总和尾小"],
        ["HDS_D", "合单"],
        ["HDS_S", "合双"],
        ["LH_L", "龙"],
        ["LH_H", "虎"]
    ]);
    const options = new Map([
        ["DX_D", "1-8球大"],
        ["DX_X", "1-8球小"],
        ["DS_D", "1-8球单"],
        ["DS_S", "1-8球双"],
        ["WDX_D", "1-8球尾大"],
        ["WDX_X", "1-8球尾小"],
        ["HDS_D", "1-8球合单"],
        ["HDS_S", "1-8球合双"],
        ["LH_L", "1-4球龙"],
        ["LH_H", "1-4球虎"],
        ["BALL_DX_D", "全部大"],
        ["BALL_DX_X", "全部小"],
        ["BALL_DS_D", "全部单"],
        ["BALL_DS_S", "全部双"],
        ["BALL_WDX_D", "全部尾大"],
        ["BALL_WDX_X", "全部尾小"],
        ["TM_B1_D", "1球特码-单"],
        ["TM_B1_S", "1球特码-双"],
        ["TM_B1_B", "1球特码-大"],
        ["TM_B1_X", "1球特码-小"],
        ["TM_B2_D", "2球特码-单"],
        ["TM_B2_S", "2球特码-双"],
        ["TM_B2_B", "2球特码-大"],
        ["TM_B2_X", "2球特码-小"],
        ["TM_B3_D", "3球特码-单"],
        ["TM_B3_S", "3球特码-双"],
        ["TM_B3_B", "3球特码-大"],
        ["TM_B3_X", "3球特码-小"],
        ["TM_B4_D", "4球特码-单"],
        ["TM_B4_S", "4球特码-双"],
        ["TM_B4_B", "4球特码-大"],
        ["TM_B4_X", "4球特码-小"],
        ["TM_B5_D", "5球特码-单"],
        ["TM_B5_S", "5球特码-双"],
        ["TM_B5_B", "5球特码-大"],
        ["TM_B5_X", "5球特码-小"],
        ["TM_B6_D", "6球特码-单"],
        ["TM_B6_S", "6球特码-双"],
        ["TM_B6_B", "6球特码-大"],
        ["TM_B6_X", "6球特码-小"],
        ["TM_B7_D", "7球特码-单"],
        ["TM_B7_S", "7球特码-双"],
        ["TM_B7_B", "7球特码-大"],
        ["TM_B7_X", "7球特码-小"],
        ["TM_B8_D", "8球特码-单"],
        ["TM_B8_S", "8球特码-双"],
        ["TM_B8_B", "8球特码-大"],
        ["TM_B8_X", "8球特码-小"],
        ["FB_DX", "1-8球大小追同"],
        ["RB_DX", "1-8球大小追反"],
        ["FB_DS", "1-8球单双追同"],
        ["RB_DS", "1-8球单双追反"],
        ["FB_WDX", "1-8球尾大小追同"],
        ["RB_WDX", "1-8球尾大小追反"],
        ["FB_HDS", "1-8球合单双追同"],
        ["RB_HDS", "1-8球合单双追反"],
        ["CL_2_S", "长龙>=2 追同"],
        ["CL_2_R", "长龙>=2 追反"],
        ["CL_3_S", "长龙>=3 追同"],
        ["CL_3_R", "长龙>=3 追反"],
        ["CL_4_S", "长龙>=4 追同"],
        ["CL_4_R", "长龙>=4 追反"],
        ["CL_5_S", "长龙>=5 追同"],
        ["CL_5_R", "长龙>=5 追反"],
        ["CL_6_S", "长龙>=6 追同"],
        ["CL_6_R", "长龙>=6 追反"],
        ["CL_7_S", "长龙>=7 追同"],
        ["CL_7_R", "长龙>=7 追反"],
        ["CL_8_S", "长龙>=8 追同"],
        ["CL_8_R", "长龙>=8 追反"]
    ]);
</script>
<div class="rightpanel">


    <div class="rptab1 ml tabactive1">长龙</div>
    <div class="rptab1 ml">快投</div>
    {{--<div class="rptab1 ml complexTab"><span><a class="" href="#">公式投</a></span></div>--}}

    <table id="changlong">
        <thead>
        <tr>
            <th colspan="2" class="table_side">两面长龙排行</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
    <table id="quick_num_table" class="quick_sec_table" style="display: none;">
        <thead>
        <tr>
            <th class="table_side" colspan="3">快选项目</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td id="DX_D" style="display:none;"> 1-8球大</td>
        </tr>
        <tr>
            <td id="DX_X" style="display:none;"> 1-8球小</td>
        </tr>
        <tr>
            <td id="DS_D" style="display:none;"> 1-8球单</td>
        </tr>
        <tr>
            <td id="DS_S" style="display:none;"> 1-8球双</td>
        </tr>
        <tr>
            <td id="WDX_D" style="display:none;"> 1-8球尾大</td>
        </tr>
        <tr>
            <td id="WDX_X" style="display:none;"> 1-8球尾小</td>
        </tr>
        <tr>
            <td id="HDS_D" style="display:none;"> 1-8球合单</td>
        </tr>
        <tr>
            <td id="HDS_S" style="display:none;"> 1-8球合双</td>
        </tr>
        <tr>
            <td id="LH_L" style="display:none;"> 1-4球龙</td>
        </tr>
        <tr>
            <td id="LH_H" style="display:none;"> 1-4球虎</td>
        </tr>
        <tr>
            <td id="BALL_DX_D" style="display:none;"> 全部大</td>
        </tr>
        <tr>
            <td id="BALL_DX_X" style="display:none;"> 全部小</td>
        </tr>
        <tr>
            <td id="BALL_DS_D" style="display:none;"> 全部单</td>
        </tr>
        <tr>
            <td id="BALL_DS_S" style="display:none;"> 全部双</td>
        </tr>
        <tr>
            <td id="BALL_WDX_D" style="display:none;"> 全部尾大</td>
        </tr>
        <tr>
            <td id="BALL_WDX_X" style="display:none;"> 全部尾小</td>
        </tr>
        <tr>
            <td id="TM_B1_D" style="display:none;"> 1球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B1_S" style="display:none;"> 1球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B1_B" style="display:none;"> 1球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B1_X" style="display:none;"> 1球特码-小</td>
        </tr>
        <tr>
            <td id="TM_B2_D" style="display:none;"> 2球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B2_S" style="display:none;"> 2球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B2_B" style="display:none;"> 2球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B2_X" style="display:none;"> 2球特码-小</td>
        </tr>
        <tr>
            <td id="TM_B3_D" style="display:none;"> 3球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B3_S" style="display:none;"> 3球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B3_B" style="display:none;"> 3球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B3_X" style="display:none;"> 3球特码-小</td>
        </tr>
        <tr>
            <td id="TM_B4_D" style="display:none;"> 4球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B4_S" style="display:none;"> 4球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B4_B" style="display:none;"> 4球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B4_X" style="display:none;"> 4球特码-小</td>
        </tr>
        <tr>
            <td id="TM_B5_D" style="display:none;"> 5球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B5_S" style="display:none;"> 5球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B5_B" style="display:none;"> 5球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B5_X" style="display:none;"> 5球特码-小</td>
        </tr>
        <tr>
            <td id="TM_B6_D" style="display:none;"> 6球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B6_S" style="display:none;"> 6球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B6_B" style="display:none;"> 6球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B6_X" style="display:none;"> 6球特码-小</td>
        </tr>
        <tr>
            <td id="TM_B7_D" style="display:none;"> 7球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B7_S" style="display:none;"> 7球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B7_B" style="display:none;"> 7球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B7_X" style="display:none;"> 7球特码-小</td>
        </tr>
        <tr>
            <td id="TM_B8_D" style="display:none;"> 8球特码-单</td>
        </tr>
        <tr>
            <td id="TM_B8_S" style="display:none;"> 8球特码-双</td>
        </tr>
        <tr>
            <td id="TM_B8_B" style="display:none;"> 8球特码-大</td>
        </tr>
        <tr>
            <td id="TM_B8_X" style="display:none;"> 8球特码-小</td>
        </tr>
        <tr>
            <td id="FB_DX" style="display:none;"> 1-8球大小追同</td>
        </tr>
        <tr>
            <td id="RB_DX" style="display:none;"> 1-8球大小追反</td>
        </tr>
        <tr>
            <td id="FB_DS" style="display:none;"> 1-8球单双追同</td>
        </tr>
        <tr>
            <td id="RB_DS" style="display:none;"> 1-8球单双追反</td>
        </tr>
        <tr>
            <td id="FB_WDX" style="display:none;"> 1-8球尾大小追同</td>
        </tr>
        <tr>
            <td id="RB_WDX" style="display:none;"> 1-8球尾大小追反</td>
        </tr>
        <tr>
            <td id="FB_HDS" style="display:none;"> 1-8球合单双追同</td>
        </tr>
        <tr>
            <td id="RB_HDS" style="display:none;"> 1-8球合单双追反</td>
        </tr>
        <tr>
            <td id="CL_2_S" style="display:none;"> 长龙>=2 追同</td>
        </tr>
        <tr>
            <td id="CL_2_R" style="display:none;"> 长龙>=2 追反</td>
        </tr>
        <tr>
            <td id="CL_3_S" style="display:none;"> 长龙>=3 追同</td>
        </tr>
        <tr>
            <td id="CL_3_R" style="display:none;"> 长龙>=3 追反</td>
        </tr>
        <tr>
            <td id="CL_4_S" style="display:none;"> 长龙>=4 追同</td>
        </tr>
        <tr>
            <td id="CL_4_R" style="display:none;"> 长龙>=4 追反</td>
        </tr>
        <tr>
            <td id="CL_5_S" style="display:none;"> 长龙>=5 追同</td>
        </tr>
        <tr>
            <td id="CL_5_R" style="display:none;"> 长龙>=5 追反</td>
        </tr>
        <tr>
            <td id="CL_6_S" style="display:none;"> 长龙>=6 追同</td>
        </tr>
        <tr>
            <td id="CL_6_R" style="display:none;"> 长龙>=6 追反</td>
        </tr>
        <tr>
            <td id="CL_7_S" style="display:none;"> 长龙>=7 追同</td>
        </tr>
        <tr>
            <td id="CL_7_R" style="display:none;"> 长龙>=7 追反</td>
        </tr>
        <tr>
            <td id="CL_8_S" style="display:none;"> 长龙>=8 追同</td>
        </tr>
        <tr>
            <td id="CL_8_R" style="display:none;"> 长龙>=8 追反</td>
        </tr>
        <tr>
            <th id="fastBetSettingTh">
                <div id="fastBetSetting"> 设置快选选项</div>
            </th>
        </tr>
        </tbody>
    </table>
    <table id="complexTableLotteryFilter" class="complexTableLotteryFilter" style="display: none;">
        <thead>
        <tr>
            <th colspan="2" class="">公式投注</th>
        </tr>
        </thead>
    </table>


</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".complexTab").click(function () {
            window.location = $(this).find("a").attr("href");
            return false;
        });
    });
</script>


</body>
</html>
