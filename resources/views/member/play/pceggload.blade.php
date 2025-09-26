<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/balls.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_PCEGG.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/modal.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/dialog.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/period.js"></script>
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
                var games = 'HZ,DX,DS,JZDX,DXDS,BZ,TMB3';
            </script>
            <div class="split_panel">
                <table><tbody><tr class="head"><th>和值</th><th>赔率</th><th class="ha">金额</th></tr>
                    <tr><th class="GHZ_0 name" id="t_HZ_0" title=" 0"><input type="hidden" id="k_HZ_0" value="HZ"><span class="b0">0</span></th>
                        <td class="GHZ_0 odds" id="o_HZ_0">--</td>
                        <td class="GHZ_0 amount ha" id="a_HZ_0"><input name="HZ_0" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_1 name" id="t_HZ_1" title=" 1"><input type="hidden" id="k_HZ_1" value="HZ"><span class="b1">1</span></th>
                        <td class="GHZ_1 odds" id="o_HZ_1">--</td>
                        <td class="GHZ_1 amount ha" id="a_HZ_1"><input name="HZ_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_2 name" id="t_HZ_2" title=" 2"><input type="hidden" id="k_HZ_2" value="HZ"><span class="b2">2</span></th>
                        <td class="GHZ_2 odds" id="o_HZ_2">--</td>
                        <td class="GHZ_2 amount ha" id="a_HZ_2"><input name="HZ_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_3 name" id="t_HZ_3" title=" 3"><input type="hidden" id="k_HZ_3" value="HZ"><span class="b3">3</span></th>
                        <td class="GHZ_3 odds" id="o_HZ_3">--</td>
                        <td class="GHZ_3 amount ha" id="a_HZ_3"><input name="HZ_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_4 name" id="t_HZ_4" title=" 4"><input type="hidden" id="k_HZ_4" value="HZ"><span class="b4">4</span></th>
                        <td class="GHZ_4 odds" id="o_HZ_4">--</td>
                        <td class="GHZ_4 amount ha" id="a_HZ_4"><input name="HZ_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_5 name" id="t_HZ_5" title=" 5"><input type="hidden" id="k_HZ_5" value="HZ"><span class="b5">5</span></th>
                        <td class="GHZ_5 odds" id="o_HZ_5">--</td>
                        <td class="GHZ_5 amount ha" id="a_HZ_5"><input name="HZ_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_6 name" id="t_HZ_6" title=" 6"><input type="hidden" id="k_HZ_6" value="HZ"><span class="b6">6</span></th>
                        <td class="GHZ_6 odds" id="o_HZ_6">--</td>
                        <td class="GHZ_6 amount ha" id="a_HZ_6"><input name="HZ_6" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table><tbody><tr class="head"><th>和值</th><th>赔率</th><th class="ha">金额</th></tr>
                    <tr><th class="GHZ_7 name" id="t_HZ_7" title=" 7"><input type="hidden" id="k_HZ_7" value="HZ"><span class="b7">7</span></th>
                        <td class="GHZ_7 odds" id="o_HZ_7">--</td>
                        <td class="GHZ_7 amount ha" id="a_HZ_7"><input name="HZ_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_8 name" id="t_HZ_8" title=" 8"><input type="hidden" id="k_HZ_8" value="HZ"><span class="b8">8</span></th>
                        <td class="GHZ_8 odds" id="o_HZ_8">--</td>
                        <td class="GHZ_8 amount ha" id="a_HZ_8"><input name="HZ_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_9 name" id="t_HZ_9" title=" 9"><input type="hidden" id="k_HZ_9" value="HZ"><span class="b9">9</span></th>
                        <td class="GHZ_9 odds" id="o_HZ_9">--</td>
                        <td class="GHZ_9 amount ha" id="a_HZ_9"><input name="HZ_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_10 name" id="t_HZ_10" title=" 10"><input type="hidden" id="k_HZ_10" value="HZ"><span class="b10">10</span></th>
                        <td class="GHZ_10 odds" id="o_HZ_10">--</td>
                        <td class="GHZ_10 amount ha" id="a_HZ_10"><input name="HZ_10" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_11 name" id="t_HZ_11" title=" 11"><input type="hidden" id="k_HZ_11" value="HZ"><span class="b11">11</span></th>
                        <td class="GHZ_11 odds" id="o_HZ_11">--</td>
                        <td class="GHZ_11 amount ha" id="a_HZ_11"><input name="HZ_11" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_12 name" id="t_HZ_12" title=" 12"><input type="hidden" id="k_HZ_12" value="HZ"><span class="b12">12</span></th>
                        <td class="GHZ_12 odds" id="o_HZ_12">--</td>
                        <td class="GHZ_12 amount ha" id="a_HZ_12"><input name="HZ_12" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_13 name" id="t_HZ_13" title=" 13"><input type="hidden" id="k_HZ_13" value="HZ"><span class="b13">13</span></th>
                        <td class="GHZ_13 odds" id="o_HZ_13">--</td>
                        <td class="GHZ_13 amount ha" id="a_HZ_13"><input name="HZ_13" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table><tbody><tr class="head"><th>和值</th><th>赔率</th><th class="ha">金额</th></tr>
                    <tr><th class="GHZ_14 name" id="t_HZ_14" title=" 14"><input type="hidden" id="k_HZ_14" value="HZ"><span class="b14">14</span></th>
                        <td class="GHZ_14 odds" id="o_HZ_14">--</td>
                        <td class="GHZ_14 amount ha" id="a_HZ_14"><input name="HZ_14" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_15 name" id="t_HZ_15" title=" 15"><input type="hidden" id="k_HZ_15" value="HZ"><span class="b15">15</span></th>
                        <td class="GHZ_15 odds" id="o_HZ_15">--</td>
                        <td class="GHZ_15 amount ha" id="a_HZ_15"><input name="HZ_15" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_16 name" id="t_HZ_16" title=" 16"><input type="hidden" id="k_HZ_16" value="HZ"><span class="b16">16</span></th>
                        <td class="GHZ_16 odds" id="o_HZ_16">--</td>
                        <td class="GHZ_16 amount ha" id="a_HZ_16"><input name="HZ_16" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_17 name" id="t_HZ_17" title=" 17"><input type="hidden" id="k_HZ_17" value="HZ"><span class="b17">17</span></th>
                        <td class="GHZ_17 odds" id="o_HZ_17">--</td>
                        <td class="GHZ_17 amount ha" id="a_HZ_17"><input name="HZ_17" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_18 name" id="t_HZ_18" title=" 18"><input type="hidden" id="k_HZ_18" value="HZ"><span class="b18">18</span></th>
                        <td class="GHZ_18 odds" id="o_HZ_18">--</td>
                        <td class="GHZ_18 amount ha" id="a_HZ_18"><input name="HZ_18" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_19 name" id="t_HZ_19" title=" 19"><input type="hidden" id="k_HZ_19" value="HZ"><span class="b19">19</span></th>
                        <td class="GHZ_19 odds" id="o_HZ_19">--</td>
                        <td class="GHZ_19 amount ha" id="a_HZ_19"><input name="HZ_19" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_20 name" id="t_HZ_20" title=" 20"><input type="hidden" id="k_HZ_20" value="HZ"><span class="b20">20</span></th>
                        <td class="GHZ_20 odds" id="o_HZ_20">--</td>
                        <td class="GHZ_20 amount ha" id="a_HZ_20"><input name="HZ_20" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table><tbody><tr class="head"><th>和值</th><th>赔率</th><th class="ha">金额</th></tr>
                    <tr><th class="GHZ_21 name" id="t_HZ_21" title=" 21"><input type="hidden" id="k_HZ_21" value="HZ"><span class="b21">21</span></th>
                        <td class="GHZ_21 odds" id="o_HZ_21">--</td>
                        <td class="GHZ_21 amount ha" id="a_HZ_21"><input name="HZ_21" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_22 name" id="t_HZ_22" title=" 22"><input type="hidden" id="k_HZ_22" value="HZ"><span class="b22">22</span></th>
                        <td class="GHZ_22 odds" id="o_HZ_22">--</td>
                        <td class="GHZ_22 amount ha" id="a_HZ_22"><input name="HZ_22" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_23 name" id="t_HZ_23" title=" 23"><input type="hidden" id="k_HZ_23" value="HZ"><span class="b23">23</span></th>
                        <td class="GHZ_23 odds" id="o_HZ_23">--</td>
                        <td class="GHZ_23 amount ha" id="a_HZ_23"><input name="HZ_23" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_24 name" id="t_HZ_24" title=" 24"><input type="hidden" id="k_HZ_24" value="HZ"><span class="b24">24</span></th>
                        <td class="GHZ_24 odds" id="o_HZ_24">--</td>
                        <td class="GHZ_24 amount ha" id="a_HZ_24"><input name="HZ_24" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_25 name" id="t_HZ_25" title=" 25"><input type="hidden" id="k_HZ_25" value="HZ"><span class="b25">25</span></th>
                        <td class="GHZ_25 odds" id="o_HZ_25">--</td>
                        <td class="GHZ_25 amount ha" id="a_HZ_25"><input name="HZ_25" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_26 name" id="t_HZ_26" title=" 26"><input type="hidden" id="k_HZ_26" value="HZ"><span class="b26">26</span></th>
                        <td class="GHZ_26 odds" id="o_HZ_26">--</td>
                        <td class="GHZ_26 amount ha" id="a_HZ_26"><input name="HZ_26" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GHZ_27 name" id="t_HZ_27" title=" 27"><input type="hidden" id="k_HZ_27" value="HZ"><span class="b27">27</span></th>
                        <td class="GHZ_27 odds" id="o_HZ_27">--</td>
                        <td class="GHZ_27 amount ha" id="a_HZ_27"><input name="HZ_27" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
            </div>
            <table class="table_lm">
                <tbody><tr class="head"><th colspan="16">两面</th></tr>
                <tr><th class="GDX_D name" id="t_DX_D" title=" 大"><input type="hidden" id="k_DX_D" value="DX">大</th>
                    <td class="GDX_D odds" id="o_DX_D">--</td>
                    <td class="GDX_D amount ha" id="a_DX_D"><input name="DX_D" class="ba" disabled=""></td>
                    <th class="GDS_D name" id="t_DS_D" title=" 单"><input type="hidden" id="k_DS_D" value="DX">单</th>
                    <td class="GDS_D odds" id="o_DS_D">--</td>
                    <td class="GDS_D amount ha" id="a_DS_D"><input name="DS_D" class="ba" disabled=""></td>
                    <th class="GJZDX_D name" id="t_JZDX_D" title=" 极大"><input type="hidden" id="k_JZDX_D" value="JZDX">极大</th>
                    <td class="GJZDX_D odds" id="o_JZDX_D">--</td>
                    <td class="GJZDX_D amount ha" id="a_JZDX_D"><input name="JZDX_D" class="ba" disabled=""></td>
                    <th class="GDXDS_DD name" id="t_DXDS_DD" title=" 大单"><input type="hidden" id="k_DXDS_DD" value="DXDS">大单</th>
                    <td class="GDXDS_DD odds" id="o_DXDS_DD">--</td>
                    <td class="GDXDS_DD amount ha" id="a_DXDS_DD"><input name="DXDS_DD" class="ba" disabled=""></td>
                    <th class="GDXDS_DS name" id="t_DXDS_DS" title=" 大双"><input type="hidden" id="k_DXDS_DS" value="DXDS">大双</th>
                    <td class="GDXDS_DS odds" id="o_DXDS_DS">--</td>
                    <td class="GDXDS_DS amount ha" id="a_DXDS_DS"><input name="DXDS_DS" class="ba" disabled=""></td>
                </tr>
                <tr><th class="GDX_X name" id="t_DX_X" title=" 小"><input type="hidden" id="k_DX_X" value="DX">小</th>
                    <td class="GDX_X odds" id="o_DX_X">--</td>
                    <td class="GDX_X amount ha" id="a_DX_X"><input name="DX_X" class="ba" disabled=""></td>
                    <th class="GDS_S name" id="t_DS_S" title=" 双"><input type="hidden" id="k_DS_S" value="DS">双</th>
                    <td class="GDS_S odds" id="o_DS_S">--</td>
                    <td class="GDS_S amount ha" id="a_DS_S"><input name="DS_S" class="ba" disabled=""></td>
                    <th class="GJZDX_X name" id="t_JZDX_X" title=" 极小"><input type="hidden" id="k_JZDX_X" value="JZDX">极小</th>
                    <td class="GJZDX_X odds" id="o_JZDX_X">--</td>
                    <td class="GJZDX_X amount ha" id="a_JZDX_X"><input name="JZDX_X" class="ba" disabled=""></td>
                    <th class="GDXDS_XD name" id="t_DXDS_XD" title=" 小单"><input type="hidden" id="k_DXDS_XD" value="DXDS">小单</th>
                    <td class="GDXDS_XD odds" id="o_DXDS_XD">--</td>
                    <td class="GDXDS_XD amount ha" id="a_DXDS_XD"><input name="DXDS_XD" class="ba" disabled=""></td>
                    <th class="GDXDS_XS name" id="t_DXDS_XS" title=" 小双"><input type="hidden" id="k_DXDS_XS" value="DXDS">小双</th>
                    <td class="GDXDS_XS odds" id="o_DXDS_XS">--</td>
                    <td class="GDXDS_XS amount ha" id="a_DXDS_XS"><input name="DXDS_XS" class="ba" disabled=""></td>
                </tr>
                </tbody></table>
            <table class="table_lm">
                <tbody><tr class="head"><th colspan="12">色波/豹子/包三</th></tr>
                <tr>
                    <th class="GSB_R name redname" id="t_SB_R" title=" 红波"><input type="hidden" id="k_SB_R" value="SB">红波</th>
                    <td class="GSB_R odds redodds" id="o_SB_R">--</td>
                    <td class="GSB_R amount ha" id="a_SB_R"><input name="SB_R" class="ba" disabled=""></td>
                    <th class="GSB_G name greenname" id="t_SB_G" title=" 绿波"><input type="hidden" id="k_SB_G" value="SB">绿波</th>
                    <td class="GSB_G odds greenodds" id="o_SB_G">--</td>
                    <td class="GSB_G amount ha" id="a_SB_G"><input name="SB_G" class="ba" disabled=""></td>
                    <th class="GSB_B name bluename" id="t_SB_B" title=" 蓝波"><input type="hidden" id="k_SB_B" value="SB">蓝波</th>
                    <td class="GSB_B odds blueodds" id="o_SB_B">--</td>
                    <td class="GSB_B amount ha" id="a_SB_B"><input name="SB_B" class="ba" disabled=""></td>
                    <th class="GBZ_0 name" id="t_BZ_0" title=" 豹子"><input type="hidden" id="k_BZ_0" value="BZ">豹子</th>
                    <td class="GBZ_0 odds" id="o_BZ_0">--</td>
                    <td class="GBZ_0 amount ha" id="a_BZ_0"><input name="BZ_0" class="ba" disabled=""></td>
                </tr>
                <tr>
                </tr></tbody></table>
            <table class="table_lm">
                <tbody><tr>
                    <th colspan="2" class="GTMB3_0 name" id="t_TMB3_0" title=" 特码包三">
                        <input id="k_TMB3_0" value="TMB3" type="hidden">特码包三</th>
                    <td class="GTMB3_0 odds" id="o_TMB3_0">--</td>
                    <td colspan="3">
                        <div id="sTMB3"><select id="s0" style="margin:0px 10px;width:80px;border:#B9C2CB 1px solid;"><option value="0">0</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option></select><select id="s1" style="margin:0px 10px;width:80px;border:#B9C2CB 1px solid;"><option value="1">1</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option></select><select id="s2" style="margin:0px 10px;width:80px;border:#B9C2CB 1px solid;"><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option></select></div>
                    </td>
                    <td id="a_TMB3_0" class="GTMB3_0 amount ha"><input name="TMB3_0" class="ba" disabled=""></td>
                </tr><tr>
                </tr></tbody></table>
            <script type="text/javascript" src="/static/default/js/pcegg.js"></script>>
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
    {{--<div class="rptab1 ml"><span><a class="" href="complexBet?lottery=KLSFJSC&page=lm">公式投</a></span></div>--}}

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
