<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/balls.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_PK10.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/modal.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/dialog.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/period.js?v=11"></script>
    <script type="text/javascript" src="/static/default/js/bet.js?v=0116"></script>
    <script type="text/javascript" src="/static/default/js/moment.js"></script>
    <script type="text/javascript" src="/static/default/js/results.js"></script>
    <script type="text/javascript" src="/static/default/js/resultPanel.js"></script>
    <script type="text/javascript" src="/static/default/js/pagemap.js"></script>
    <script type="text/javascript" src="/static/default/js/drawurls.js"></script>
    <script type="text/javascript" src="/static/default/js/defaultbet.js"></script>
    <script type="text/javascript" src="/static/default/js/rightpanel.js"></script>
    <script type="text/javascript" src="/static/default/js/modal.js?v1"></script>
    <script type="text/javascript">
        var lottery = '{{$lottery}}';
        var lotteryName = '{{$gname}}';
        var lotteryType = '0';
        var template = '{{$template}}';
        var page = '{{$page}}';
        var index = '{{$index}}';
        var index2 = '{{$index2}}';
        LIBS.cookie('page', page);
        LIBS.cookie('index', index);
        LIBS.cookie('index2', index2);
    </script>
</head>
<body class="L_{{$lottery}} P_{{$page}}">
<div id="main">
    <div id="header">
        <div class="lottery_info">
            <div class="lottery_info_left floatleft">
                <span class="name" id="lotteryName">{{$gname}}</span> &mdash;
                <span class="gameName" id="gameName"></span>
                <span class="result">&nbsp;今日输赢：<span id="bresult">{{$jrsy}}</span></span>
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
        <div class="control n_anniu">
            <input type="button" class="button2 show-result-list-btn" value="查看近期开奖" onclick="showResultList();"
                   style="float:right;">
            <div class="buttons">
                <label class="checkdefault"><input type="checkbox" class="checkbox"/><span
                        class="color_lv bold">预设</span></label>&nbsp;&nbsp;<label id="quickAmount"
                                                                                    class="quickAmount"><span
                        class="color_lv bold">金额</span> <input/></label>
                <input type="button" onclick="bet()" value="确定" class="button"/>
                <input type="button" onclick="resetBets()" value="重置" class="button"/>
                <input type="button" class="button" value="重覆上次下单" onclick="repeatbet()" style="width: 100px">
            </div>
        </div>
    </div>
    <div id="bet_panel" class="bet_panel input_panel">
        <script type="text/javascript">
            var games = 'DX1,DX2,DX3,DX4,DX5,DX6,DX7,DX8,DX9,DX10,DS1,DS2,DS3,DS4,DS5,DS6,DS7,DS8,DS9,DS10,GDX,GDS,LH1,LH2,LH3,LH4,LH5';
            $(function () {
                Results.init({
                    '': ['B{0}'],
                    '大小': ['DX{0}', 'dx'],
                    '单双': ['DS{0}', 'ds'],
                    '冠、亚军和': ['GYH'],
                    '冠、亚军和 大小': ['GDX', 'dx'],
                    '冠、亚军和 单双': ['GDS', 'ds']
                }, 1, 10, ['冠军', '亚军', '第三名', '第四名', '第五名', '第六名', '第七名', '第八名', '第九名', '第十名'], 1);
            });
        </script>
        @if($page == 'lm')
            <table class="table_lm">
                <tr class="head">
                    <th colspan="12">冠、亚军和</th>
                </tr>
                <tr>
                    <th class="GGDX_D name" id="t_GDX_D" title=" 冠亚大"><input type="hidden" id="k_GDX_D" value="GDX"/>冠亚大
                    </th>

                    <td class="GGDX_D odds" id="o_GDX_D"></td>
                    <td class="GGDX_D amount ha" id="a_GDX_D"><input name="GDX_D" class="ba"/></td>

                    <th class="GGDX_X name" id="t_GDX_X" title=" 冠亚小"><input type="hidden" id="k_GDX_X" value="GDX"/>冠亚小
                    </th>

                    <td class="GGDX_X odds" id="o_GDX_X"></td>
                    <td class="GGDX_X amount ha" id="a_GDX_X"><input name="GDX_X" class="ba"/></td>
                    <th class="GGDS_D name" id="t_GDS_D" title=" 冠亚单"><input type="hidden" id="k_GDS_D" value="GDS"/>冠亚单
                    </th>

                    <td class="GGDS_D odds" id="o_GDS_D"></td>
                    <td class="GGDS_D amount ha" id="a_GDS_D"><input name="GDS_D" class="ba"/></td>
                    <th class="GGDS_S name" id="t_GDS_S" title=" 冠亚双"><input type="hidden" id="k_GDS_S" value="GDS"/>冠亚双
                    </th>

                    <td class="GGDS_S odds" id="o_GDS_S"></td>
                    <td class="GGDS_S amount ha" id="a_GDS_S"><input name="GDS_S" class="ba"/></td>
                </tr>
            </table>
            <div class="split_panel">
                <table>
                    <tr class="head">
                        <th colspan="3">冠军</th>
                    </tr>
                    <tr>
                        <th class="GDX1_D name" id="t_DX1_D" title="冠军 大"><input type="hidden" id="k_DX1_D" value="DX"/>大
                        </th>

                        <td class="GDX1_D odds" id="o_DX1_D"></td>
                        <td class="GDX1_D amount ha" id="a_DX1_D"><input name="DX1_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX1_X name" id="t_DX1_X" title="冠军 小"><input type="hidden" id="k_DX1_X" value="DX"/>小
                        </th>

                        <td class="GDX1_X odds" id="o_DX1_X"></td>
                        <td class="GDX1_X amount ha" id="a_DX1_X"><input name="DX1_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS1_D name" id="t_DS1_D" title="冠军 单"><input type="hidden" id="k_DS1_D" value="DS"/>单
                        </th>

                        <td class="GDS1_D odds" id="o_DS1_D"></td>
                        <td class="GDS1_D amount ha" id="a_DS1_D"><input name="DS1_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS1_S name" id="t_DS1_S" title="冠军 双"><input type="hidden" id="k_DS1_S" value="DS"/>双
                        </th>

                        <td class="GDS1_S odds" id="o_DS1_S"></td>
                        <td class="GDS1_S amount ha" id="a_DS1_S"><input name="DS1_S" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH1_L name" id="t_LH1_L" title="冠军 龙"><input type="hidden" id="k_LH1_L" value="LH"/>龙
                        </th>

                        <td class="GLH1_L odds" id="o_LH1_L"></td>
                        <td class="GLH1_L amount ha" id="a_LH1_L"><input name="LH1_L" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH1_H name" id="t_LH1_H" title="冠军 虎"><input type="hidden" id="k_LH1_H" value="LH"/>虎
                        </th>

                        <td class="GLH1_H odds" id="o_LH1_H"></td>
                        <td class="GLH1_H amount ha" id="a_LH1_H"><input name="LH1_H" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">亚军</th>
                    </tr>
                    <tr>
                        <th class="GDX2_D name" id="t_DX2_D" title="亚军 大"><input type="hidden" id="k_DX2_D" value="DX"/>大
                        </th>

                        <td class="GDX2_D odds" id="o_DX2_D"></td>
                        <td class="GDX2_D amount ha" id="a_DX2_D"><input name="DX2_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX2_X name" id="t_DX2_X" title="亚军 小"><input type="hidden" id="k_DX2_X" value="DX"/>小
                        </th>

                        <td class="GDX2_X odds" id="o_DX2_X"></td>
                        <td class="GDX2_X amount ha" id="a_DX2_X"><input name="DX2_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS2_D name" id="t_DS2_D" title="亚军 单"><input type="hidden" id="k_DS2_D" value="DS"/>单
                        </th>

                        <td class="GDS2_D odds" id="o_DS2_D"></td>
                        <td class="GDS2_D amount ha" id="a_DS2_D"><input name="DS2_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS2_S name" id="t_DS2_S" title="亚军 双"><input type="hidden" id="k_DS2_S" value="DS"/>双
                        </th>

                        <td class="GDS2_S odds" id="o_DS2_S"></td>
                        <td class="GDS2_S amount ha" id="a_DS2_S"><input name="DS2_S" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH2_L name" id="t_LH2_L" title="亚军 龙"><input type="hidden" id="k_LH2_L" value="LH"/>龙
                        </th>

                        <td class="GLH2_L odds" id="o_LH2_L"></td>
                        <td class="GLH2_L amount ha" id="a_LH2_L"><input name="LH2_L" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH2_H name" id="t_LH2_H" title="亚军 虎"><input type="hidden" id="k_LH2_H" value="LH"/>虎
                        </th>

                        <td class="GLH2_H odds" id="o_LH2_H"></td>
                        <td class="GLH2_H amount ha" id="a_LH2_H"><input name="LH2_H" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第三名</th>
                    </tr>
                    <tr>
                        <th class="GDX3_D name" id="t_DX3_D" title="第三名 大"><input type="hidden" id="k_DX3_D"
                                                                                      value="DX"/>大
                        </th>

                        <td class="GDX3_D odds" id="o_DX3_D"></td>
                        <td class="GDX3_D amount ha" id="a_DX3_D"><input name="DX3_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX3_X name" id="t_DX3_X" title="第三名 小"><input type="hidden" id="k_DX3_X"
                                                                                      value="DX"/>小
                        </th>

                        <td class="GDX3_X odds" id="o_DX3_X"></td>
                        <td class="GDX3_X amount ha" id="a_DX3_X"><input name="DX3_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS3_D name" id="t_DS3_D" title="第三名 单"><input type="hidden" id="k_DS3_D"
                                                                                      value="DS"/>单
                        </th>

                        <td class="GDS3_D odds" id="o_DS3_D"></td>
                        <td class="GDS3_D amount ha" id="a_DS3_D"><input name="DS3_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS3_S name" id="t_DS3_S" title="第三名 双"><input type="hidden" id="k_DS3_S"
                                                                                      value="DS"/>双
                        </th>

                        <td class="GDS3_S odds" id="o_DS3_S"></td>
                        <td class="GDS3_S amount ha" id="a_DS3_S"><input name="DS3_S" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH3_L name" id="t_LH3_L" title="第三名 龙"><input type="hidden" id="k_LH3_L"
                                                                                      value="LH"/>龙
                        </th>

                        <td class="GLH3_L odds" id="o_LH3_L"></td>
                        <td class="GLH3_L amount ha" id="a_LH3_L"><input name="LH3_L" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH3_H name" id="t_LH3_H" title="第三名 虎"><input type="hidden" id="k_LH3_H"
                                                                                      value="LH"/>虎
                        </th>

                        <td class="GLH3_H odds" id="o_LH3_H"></td>
                        <td class="GLH3_H amount ha" id="a_LH3_H"><input name="LH3_H" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第四名</th>
                    </tr>
                    <tr>
                        <th class="GDX4_D name" id="t_DX4_D" title="第四名 大"><input type="hidden" id="k_DX4_D"
                                                                                      value="DX"/>大
                        </th>

                        <td class="GDX4_D odds" id="o_DX4_D"></td>
                        <td class="GDX4_D amount ha" id="a_DX4_D"><input name="DX4_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX4_X name" id="t_DX4_X" title="第四名 小"><input type="hidden" id="k_DX4_X"
                                                                                      value="DX"/>小
                        </th>

                        <td class="GDX4_X odds" id="o_DX4_X"></td>
                        <td class="GDX4_X amount ha" id="a_DX4_X"><input name="DX4_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS4_D name" id="t_DS4_D" title="第四名 单"><input type="hidden" id="k_DS4_D"
                                                                                      value="DS"/>单
                        </th>

                        <td class="GDS4_D odds" id="o_DS4_D"></td>
                        <td class="GDS4_D amount ha" id="a_DS4_D"><input name="DS4_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS4_S name" id="t_DS4_S" title="第四名 双"><input type="hidden" id="k_DS4_S"
                                                                                      value="DS"/>双
                        </th>

                        <td class="GDS4_S odds" id="o_DS4_S"></td>
                        <td class="GDS4_S amount ha" id="a_DS4_S"><input name="DS4_S" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH4_L name" id="t_LH4_L" title="第四名 龙"><input type="hidden" id="k_LH4_L"
                                                                                      value="LH"/>龙
                        </th>

                        <td class="GLH4_L odds" id="o_LH4_L"></td>
                        <td class="GLH4_L amount ha" id="a_LH4_L"><input name="LH4_L" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH4_H name" id="t_LH4_H" title="第四名 虎"><input type="hidden" id="k_LH4_H"
                                                                                      value="LH"/>虎
                        </th>

                        <td class="GLH4_H odds" id="o_LH4_H"></td>
                        <td class="GLH4_H amount ha" id="a_LH4_H"><input name="LH4_H" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第五名</th>
                    </tr>
                    <tr>
                        <th class="GDX5_D name" id="t_DX5_D" title="第五名 大"><input type="hidden" id="k_DX5_D"
                                                                                      value="DX"/>大
                        </th>

                        <td class="GDX5_D odds" id="o_DX5_D"></td>
                        <td class="GDX5_D amount ha" id="a_DX5_D"><input name="DX5_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX5_X name" id="t_DX5_X" title="第五名 小"><input type="hidden" id="k_DX5_X"
                                                                                      value="DX"/>小
                        </th>

                        <td class="GDX5_X odds" id="o_DX5_X"></td>
                        <td class="GDX5_X amount ha" id="a_DX5_X"><input name="DX5_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS5_D name" id="t_DS5_D" title="第五名 单"><input type="hidden" id="k_DS5_D"
                                                                                      value="DS"/>单
                        </th>

                        <td class="GDS5_D odds" id="o_DS5_D"></td>
                        <td class="GDS5_D amount ha" id="a_DS5_D"><input name="DS5_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS5_S name" id="t_DS5_S" title="第五名 双"><input type="hidden" id="k_DS5_S"
                                                                                      value="DS"/>双
                        </th>

                        <td class="GDS5_S odds" id="o_DS5_S"></td>
                        <td class="GDS5_S amount ha" id="a_DS5_S"><input name="DS5_S" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH5_L name" id="t_LH5_L" title="第五名 龙"><input type="hidden" id="k_LH5_L"
                                                                                      value="LH"/>龙
                        </th>

                        <td class="GLH5_L odds" id="o_LH5_L"></td>
                        <td class="GLH5_L amount ha" id="a_LH5_L"><input name="LH5_L" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GLH5_H name" id="t_LH5_H" title="第五名 虎"><input type="hidden" id="k_LH5_H"
                                                                                      value="LH"/>虎
                        </th>

                        <td class="GLH5_H odds" id="o_LH5_H"></td>
                        <td class="GLH5_H amount ha" id="a_LH5_H"><input name="LH5_H" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第六名</th>
                    </tr>
                    <tr>
                        <th class="GDX6_D name" id="t_DX6_D" title="第六名 大"><input type="hidden" id="k_DX6_D"
                                                                                      value="DX"/>大
                        </th>

                        <td class="GDX6_D odds" id="o_DX6_D"></td>
                        <td class="GDX6_D amount ha" id="a_DX6_D"><input name="DX6_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX6_X name" id="t_DX6_X" title="第六名 小"><input type="hidden" id="k_DX6_X"
                                                                                      value="DX"/>小
                        </th>

                        <td class="GDX6_X odds" id="o_DX6_X"></td>
                        <td class="GDX6_X amount ha" id="a_DX6_X"><input name="DX6_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS6_D name" id="t_DS6_D" title="第六名 单"><input type="hidden" id="k_DS6_D"
                                                                                      value="DS"/>单
                        </th>

                        <td class="GDS6_D odds" id="o_DS6_D"></td>
                        <td class="GDS6_D amount ha" id="a_DS6_D"><input name="DS6_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS6_S name" id="t_DS6_S" title="第六名 双"><input type="hidden" id="k_DS6_S"
                                                                                      value="DS"/>双
                        </th>

                        <td class="GDS6_S odds" id="o_DS6_S"></td>
                        <td class="GDS6_S amount ha" id="a_DS6_S"><input name="DS6_S" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第七名</th>
                    </tr>
                    <tr>
                        <th class="GDX7_D name" id="t_DX7_D" title="第七名 大"><input type="hidden" id="k_DX7_D"
                                                                                      value="DX"/>大
                        </th>

                        <td class="GDX7_D odds" id="o_DX7_D"></td>
                        <td class="GDX7_D amount ha" id="a_DX7_D"><input name="DX7_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX7_X name" id="t_DX7_X" title="第七名 小"><input type="hidden" id="k_DX7_X"
                                                                                      value="DX"/>小
                        </th>

                        <td class="GDX7_X odds" id="o_DX7_X"></td>
                        <td class="GDX7_X amount ha" id="a_DX7_X"><input name="DX7_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS7_D name" id="t_DS7_D" title="第七名 单"><input type="hidden" id="k_DS7_D"
                                                                                      value="DS"/>单
                        </th>

                        <td class="GDS7_D odds" id="o_DS7_D"></td>
                        <td class="GDS7_D amount ha" id="a_DS7_D"><input name="DS7_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS7_S name" id="t_DS7_S" title="第七名 双"><input type="hidden" id="k_DS7_S"
                                                                                      value="DS"/>双
                        </th>

                        <td class="GDS7_S odds" id="o_DS7_S"></td>
                        <td class="GDS7_S amount ha" id="a_DS7_S"><input name="DS7_S" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第八名</th>
                    </tr>
                    <tr>
                        <th class="GDX8_D name" id="t_DX8_D" title="第八名 大"><input type="hidden" id="k_DX8_D"
                                                                                      value="DX"/>大
                        </th>

                        <td class="GDX8_D odds" id="o_DX8_D"></td>
                        <td class="GDX8_D amount ha" id="a_DX8_D"><input name="DX8_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX8_X name" id="t_DX8_X" title="第八名 小"><input type="hidden" id="k_DX8_X"
                                                                                      value="DX"/>小
                        </th>

                        <td class="GDX8_X odds" id="o_DX8_X"></td>
                        <td class="GDX8_X amount ha" id="a_DX8_X"><input name="DX8_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS8_D name" id="t_DS8_D" title="第八名 单"><input type="hidden" id="k_DS8_D"
                                                                                      value="DS"/>单
                        </th>

                        <td class="GDS8_D odds" id="o_DS8_D"></td>
                        <td class="GDS8_D amount ha" id="a_DS8_D"><input name="DS8_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS8_S name" id="t_DS8_S" title="第八名 双"><input type="hidden" id="k_DS8_S"
                                                                                      value="DS"/>双
                        </th>

                        <td class="GDS8_S odds" id="o_DS8_S"></td>
                        <td class="GDS8_S amount ha" id="a_DS8_S"><input name="DS8_S" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第九名</th>
                    </tr>
                    <tr>
                        <th class="GDX9_D name" id="t_DX9_D" title="第九名 大"><input type="hidden" id="k_DX9_D"
                                                                                      value="DX"/>大
                        </th>

                        <td class="GDX9_D odds" id="o_DX9_D"></td>
                        <td class="GDX9_D amount ha" id="a_DX9_D"><input name="DX9_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX9_X name" id="t_DX9_X" title="第九名 小"><input type="hidden" id="k_DX9_X"
                                                                                      value="DX"/>小
                        </th>

                        <td class="GDX9_X odds" id="o_DX9_X"></td>
                        <td class="GDX9_X amount ha" id="a_DX9_X"><input name="DX9_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS9_D name" id="t_DS9_D" title="第九名 单"><input type="hidden" id="k_DS9_D"
                                                                                      value="DS"/>单
                        </th>

                        <td class="GDS9_D odds" id="o_DS9_D"></td>
                        <td class="GDS9_D amount ha" id="a_DS9_D"><input name="DS9_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS9_S name" id="t_DS9_S" title="第九名 双"><input type="hidden" id="k_DS9_S"
                                                                                      value="DS"/>双
                        </th>

                        <td class="GDS9_S odds" id="o_DS9_S"></td>
                        <td class="GDS9_S amount ha" id="a_DS9_S"><input name="DS9_S" class="ba"/></td>
                    </tr>
                </table>
                <table>
                    <tr class="head">
                        <th colspan="3">第十名</th>
                    </tr>
                    <tr>
                        <th class="GDX10_D name" id="t_DX10_D" title="第十名 大"><input type="hidden" id="k_DX10_D"
                                                                                        value="DX"/>大
                        </th>

                        <td class="GDX10_D odds" id="o_DX10_D"></td>
                        <td class="GDX10_D amount ha" id="a_DX10_D"><input name="DX10_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDX10_X name" id="t_DX10_X" title="第十名 小"><input type="hidden" id="k_DX10_X"
                                                                                        value="DX"/>小
                        </th>

                        <td class="GDX10_X odds" id="o_DX10_X"></td>
                        <td class="GDX10_X amount ha" id="a_DX10_X"><input name="DX10_X" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS10_D name" id="t_DS10_D" title="第十名 单"><input type="hidden" id="k_DS10_D"
                                                                                        value="DS"/>单
                        </th>

                        <td class="GDS10_D odds" id="o_DS10_D"></td>
                        <td class="GDS10_D amount ha" id="a_DS10_D"><input name="DS10_D" class="ba"/></td>
                    </tr>
                    <tr>
                        <th class="GDS10_S name" id="t_DS10_S" title="第十名 双"><input type="hidden" id="k_DS10_S"
                                                                                        value="DS"/>双
                        </th>

                        <td class="GDS10_S odds" id="o_DS10_S"></td>
                        <td class="GDS10_S amount ha" id="a_DS10_S"><input name="DS10_S" class="ba"/></td>
                    </tr>
                </table>
            </div>
        @endif
        @if($page == '110')
            <div class="split_panel table_ball">
                <table>
                    <tbody><tr class="head"><th colspan="3">冠军</th></tr>
                    <tr><th class="GB1_1 name" id="t_B1_1" title="冠军 1"><input type="hidden" id="k_B1_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB1_1 odds" id="o_B1_1">--</td>
                        <td class="GB1_1 amount ha" id="a_B1_1"><input name="B1_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_2 name" id="t_B1_2" title="冠军 2"><input type="hidden" id="k_B1_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB1_2 odds" id="o_B1_2">--</td>
                        <td class="GB1_2 amount ha" id="a_B1_2"><input name="B1_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_3 name" id="t_B1_3" title="冠军 3"><input type="hidden" id="k_B1_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB1_3 odds" id="o_B1_3">--</td>
                        <td class="GB1_3 amount ha" id="a_B1_3"><input name="B1_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_4 name" id="t_B1_4" title="冠军 4"><input type="hidden" id="k_B1_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB1_4 odds" id="o_B1_4">--</td>
                        <td class="GB1_4 amount ha" id="a_B1_4"><input name="B1_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_5 name" id="t_B1_5" title="冠军 5"><input type="hidden" id="k_B1_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB1_5 odds" id="o_B1_5">--</td>
                        <td class="GB1_5 amount ha" id="a_B1_5"><input name="B1_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_6 name" id="t_B1_6" title="冠军 6"><input type="hidden" id="k_B1_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB1_6 odds" id="o_B1_6">--</td>
                        <td class="GB1_6 amount ha" id="a_B1_6"><input name="B1_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_7 name" id="t_B1_7" title="冠军 7"><input type="hidden" id="k_B1_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB1_7 odds" id="o_B1_7">--</td>
                        <td class="GB1_7 amount ha" id="a_B1_7"><input name="B1_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_8 name" id="t_B1_8" title="冠军 8"><input type="hidden" id="k_B1_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB1_8 odds" id="o_B1_8">--</td>
                        <td class="GB1_8 amount ha" id="a_B1_8"><input name="B1_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_9 name" id="t_B1_9" title="冠军 9"><input type="hidden" id="k_B1_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB1_9 odds" id="o_B1_9">--</td>
                        <td class="GB1_9 amount ha" id="a_B1_9"><input name="B1_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB1_10 name" id="t_B1_10" title="冠军 10"><input type="hidden" id="k_B1_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB1_10 odds" id="o_B1_10">--</td>
                        <td class="GB1_10 amount ha" id="a_B1_10"><input name="B1_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">亚军</th></tr>
                    <tr><th class="GB2_1 name" id="t_B2_1" title="亚军 1"><input type="hidden" id="k_B2_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB2_1 odds" id="o_B2_1">--</td>
                        <td class="GB2_1 amount ha" id="a_B2_1"><input name="B2_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_2 name" id="t_B2_2" title="亚军 2"><input type="hidden" id="k_B2_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB2_2 odds" id="o_B2_2">--</td>
                        <td class="GB2_2 amount ha" id="a_B2_2"><input name="B2_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_3 name" id="t_B2_3" title="亚军 3"><input type="hidden" id="k_B2_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB2_3 odds" id="o_B2_3">--</td>
                        <td class="GB2_3 amount ha" id="a_B2_3"><input name="B2_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_4 name" id="t_B2_4" title="亚军 4"><input type="hidden" id="k_B2_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB2_4 odds" id="o_B2_4">--</td>
                        <td class="GB2_4 amount ha" id="a_B2_4"><input name="B2_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_5 name" id="t_B2_5" title="亚军 5"><input type="hidden" id="k_B2_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB2_5 odds" id="o_B2_5">--</td>
                        <td class="GB2_5 amount ha" id="a_B2_5"><input name="B2_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_6 name" id="t_B2_6" title="亚军 6"><input type="hidden" id="k_B2_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB2_6 odds" id="o_B2_6">--</td>
                        <td class="GB2_6 amount ha" id="a_B2_6"><input name="B2_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_7 name" id="t_B2_7" title="亚军 7"><input type="hidden" id="k_B2_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB2_7 odds" id="o_B2_7">--</td>
                        <td class="GB2_7 amount ha" id="a_B2_7"><input name="B2_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_8 name" id="t_B2_8" title="亚军 8"><input type="hidden" id="k_B2_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB2_8 odds" id="o_B2_8">--</td>
                        <td class="GB2_8 amount ha" id="a_B2_8"><input name="B2_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_9 name" id="t_B2_9" title="亚军 9"><input type="hidden" id="k_B2_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB2_9 odds" id="o_B2_9">--</td>
                        <td class="GB2_9 amount ha" id="a_B2_9"><input name="B2_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB2_10 name" id="t_B2_10" title="亚军 10"><input type="hidden" id="k_B2_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB2_10 odds" id="o_B2_10">--</td>
                        <td class="GB2_10 amount ha" id="a_B2_10"><input name="B2_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">第三名</th></tr>
                    <tr><th class="GB3_1 name" id="t_B3_1" title="第三名 1"><input type="hidden" id="k_B3_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB3_1 odds" id="o_B3_1">--</td>
                        <td class="GB3_1 amount ha" id="a_B3_1"><input name="B3_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_2 name" id="t_B3_2" title="第三名 2"><input type="hidden" id="k_B3_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB3_2 odds" id="o_B3_2">--</td>
                        <td class="GB3_2 amount ha" id="a_B3_2"><input name="B3_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_3 name" id="t_B3_3" title="第三名 3"><input type="hidden" id="k_B3_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB3_3 odds" id="o_B3_3">--</td>
                        <td class="GB3_3 amount ha" id="a_B3_3"><input name="B3_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_4 name" id="t_B3_4" title="第三名 4"><input type="hidden" id="k_B3_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB3_4 odds" id="o_B3_4">--</td>
                        <td class="GB3_4 amount ha" id="a_B3_4"><input name="B3_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_5 name" id="t_B3_5" title="第三名 5"><input type="hidden" id="k_B3_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB3_5 odds" id="o_B3_5">--</td>
                        <td class="GB3_5 amount ha" id="a_B3_5"><input name="B3_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_6 name" id="t_B3_6" title="第三名 6"><input type="hidden" id="k_B3_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB3_6 odds" id="o_B3_6">--</td>
                        <td class="GB3_6 amount ha" id="a_B3_6"><input name="B3_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_7 name" id="t_B3_7" title="第三名 7"><input type="hidden" id="k_B3_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB3_7 odds" id="o_B3_7">--</td>
                        <td class="GB3_7 amount ha" id="a_B3_7"><input name="B3_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_8 name" id="t_B3_8" title="第三名 8"><input type="hidden" id="k_B3_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB3_8 odds" id="o_B3_8">--</td>
                        <td class="GB3_8 amount ha" id="a_B3_8"><input name="B3_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_9 name" id="t_B3_9" title="第三名 9"><input type="hidden" id="k_B3_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB3_9 odds" id="o_B3_9">--</td>
                        <td class="GB3_9 amount ha" id="a_B3_9"><input name="B3_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB3_10 name" id="t_B3_10" title="第三名 10"><input type="hidden" id="k_B3_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB3_10 odds" id="o_B3_10">--</td>
                        <td class="GB3_10 amount ha" id="a_B3_10"><input name="B3_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">第四名</th></tr>
                    <tr><th class="GB4_1 name" id="t_B4_1" title="第四名 1"><input type="hidden" id="k_B4_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB4_1 odds" id="o_B4_1">--</td>
                        <td class="GB4_1 amount ha" id="a_B4_1"><input name="B4_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_2 name" id="t_B4_2" title="第四名 2"><input type="hidden" id="k_B4_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB4_2 odds" id="o_B4_2">--</td>
                        <td class="GB4_2 amount ha" id="a_B4_2"><input name="B4_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_3 name" id="t_B4_3" title="第四名 3"><input type="hidden" id="k_B4_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB4_3 odds" id="o_B4_3">--</td>
                        <td class="GB4_3 amount ha" id="a_B4_3"><input name="B4_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_4 name" id="t_B4_4" title="第四名 4"><input type="hidden" id="k_B4_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB4_4 odds" id="o_B4_4">--</td>
                        <td class="GB4_4 amount ha" id="a_B4_4"><input name="B4_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_5 name" id="t_B4_5" title="第四名 5"><input type="hidden" id="k_B4_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB4_5 odds" id="o_B4_5">--</td>
                        <td class="GB4_5 amount ha" id="a_B4_5"><input name="B4_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_6 name" id="t_B4_6" title="第四名 6"><input type="hidden" id="k_B4_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB4_6 odds" id="o_B4_6">--</td>
                        <td class="GB4_6 amount ha" id="a_B4_6"><input name="B4_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_7 name" id="t_B4_7" title="第四名 7"><input type="hidden" id="k_B4_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB4_7 odds" id="o_B4_7">--</td>
                        <td class="GB4_7 amount ha" id="a_B4_7"><input name="B4_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_8 name" id="t_B4_8" title="第四名 8"><input type="hidden" id="k_B4_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB4_8 odds" id="o_B4_8">--</td>
                        <td class="GB4_8 amount ha" id="a_B4_8"><input name="B4_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_9 name" id="t_B4_9" title="第四名 9"><input type="hidden" id="k_B4_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB4_9 odds" id="o_B4_9">--</td>
                        <td class="GB4_9 amount ha" id="a_B4_9"><input name="B4_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB4_10 name" id="t_B4_10" title="第四名 10"><input type="hidden" id="k_B4_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB4_10 odds" id="o_B4_10">--</td>
                        <td class="GB4_10 amount ha" id="a_B4_10"><input name="B4_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">第五名</th></tr>
                    <tr><th class="GB5_1 name" id="t_B5_1" title="第五名 1"><input type="hidden" id="k_B5_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB5_1 odds" id="o_B5_1">--</td>
                        <td class="GB5_1 amount ha" id="a_B5_1"><input name="B5_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_2 name" id="t_B5_2" title="第五名 2"><input type="hidden" id="k_B5_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB5_2 odds" id="o_B5_2">--</td>
                        <td class="GB5_2 amount ha" id="a_B5_2"><input name="B5_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_3 name" id="t_B5_3" title="第五名 3"><input type="hidden" id="k_B5_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB5_3 odds" id="o_B5_3">--</td>
                        <td class="GB5_3 amount ha" id="a_B5_3"><input name="B5_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_4 name" id="t_B5_4" title="第五名 4"><input type="hidden" id="k_B5_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB5_4 odds" id="o_B5_4">--</td>
                        <td class="GB5_4 amount ha" id="a_B5_4"><input name="B5_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_5 name" id="t_B5_5" title="第五名 5"><input type="hidden" id="k_B5_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB5_5 odds" id="o_B5_5">--</td>
                        <td class="GB5_5 amount ha" id="a_B5_5"><input name="B5_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_6 name" id="t_B5_6" title="第五名 6"><input type="hidden" id="k_B5_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB5_6 odds" id="o_B5_6">--</td>
                        <td class="GB5_6 amount ha" id="a_B5_6"><input name="B5_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_7 name" id="t_B5_7" title="第五名 7"><input type="hidden" id="k_B5_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB5_7 odds" id="o_B5_7">--</td>
                        <td class="GB5_7 amount ha" id="a_B5_7"><input name="B5_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_8 name" id="t_B5_8" title="第五名 8"><input type="hidden" id="k_B5_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB5_8 odds" id="o_B5_8">--</td>
                        <td class="GB5_8 amount ha" id="a_B5_8"><input name="B5_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_9 name" id="t_B5_9" title="第五名 9"><input type="hidden" id="k_B5_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB5_9 odds" id="o_B5_9">--</td>
                        <td class="GB5_9 amount ha" id="a_B5_9"><input name="B5_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB5_10 name" id="t_B5_10" title="第五名 10"><input type="hidden" id="k_B5_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB5_10 odds" id="o_B5_10">--</td>
                        <td class="GB5_10 amount ha" id="a_B5_10"><input name="B5_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
            </div>
            <div class="split_panel table_ball">
                <table>
                    <tbody><tr class="head"><th colspan="3">第六名</th></tr>
                    <tr><th class="GB6_1 name" id="t_B6_1" title="第六名 1"><input type="hidden" id="k_B6_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB6_1 odds" id="o_B6_1">--</td>
                        <td class="GB6_1 amount ha" id="a_B6_1"><input name="B6_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_2 name" id="t_B6_2" title="第六名 2"><input type="hidden" id="k_B6_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB6_2 odds" id="o_B6_2">--</td>
                        <td class="GB6_2 amount ha" id="a_B6_2"><input name="B6_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_3 name" id="t_B6_3" title="第六名 3"><input type="hidden" id="k_B6_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB6_3 odds" id="o_B6_3">--</td>
                        <td class="GB6_3 amount ha" id="a_B6_3"><input name="B6_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_4 name" id="t_B6_4" title="第六名 4"><input type="hidden" id="k_B6_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB6_4 odds" id="o_B6_4">--</td>
                        <td class="GB6_4 amount ha" id="a_B6_4"><input name="B6_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_5 name" id="t_B6_5" title="第六名 5"><input type="hidden" id="k_B6_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB6_5 odds" id="o_B6_5">--</td>
                        <td class="GB6_5 amount ha" id="a_B6_5"><input name="B6_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_6 name" id="t_B6_6" title="第六名 6"><input type="hidden" id="k_B6_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB6_6 odds" id="o_B6_6">--</td>
                        <td class="GB6_6 amount ha" id="a_B6_6"><input name="B6_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_7 name" id="t_B6_7" title="第六名 7"><input type="hidden" id="k_B6_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB6_7 odds" id="o_B6_7">--</td>
                        <td class="GB6_7 amount ha" id="a_B6_7"><input name="B6_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_8 name" id="t_B6_8" title="第六名 8"><input type="hidden" id="k_B6_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB6_8 odds" id="o_B6_8">--</td>
                        <td class="GB6_8 amount ha" id="a_B6_8"><input name="B6_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_9 name" id="t_B6_9" title="第六名 9"><input type="hidden" id="k_B6_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB6_9 odds" id="o_B6_9">--</td>
                        <td class="GB6_9 amount ha" id="a_B6_9"><input name="B6_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB6_10 name" id="t_B6_10" title="第六名 10"><input type="hidden" id="k_B6_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB6_10 odds" id="o_B6_10">--</td>
                        <td class="GB6_10 amount ha" id="a_B6_10"><input name="B6_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">第七名</th></tr>
                    <tr><th class="GB7_1 name" id="t_B7_1" title="第七名 1"><input type="hidden" id="k_B7_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB7_1 odds" id="o_B7_1">--</td>
                        <td class="GB7_1 amount ha" id="a_B7_1"><input name="B7_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_2 name" id="t_B7_2" title="第七名 2"><input type="hidden" id="k_B7_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB7_2 odds" id="o_B7_2">--</td>
                        <td class="GB7_2 amount ha" id="a_B7_2"><input name="B7_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_3 name" id="t_B7_3" title="第七名 3"><input type="hidden" id="k_B7_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB7_3 odds" id="o_B7_3">--</td>
                        <td class="GB7_3 amount ha" id="a_B7_3"><input name="B7_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_4 name" id="t_B7_4" title="第七名 4"><input type="hidden" id="k_B7_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB7_4 odds" id="o_B7_4">--</td>
                        <td class="GB7_4 amount ha" id="a_B7_4"><input name="B7_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_5 name" id="t_B7_5" title="第七名 5"><input type="hidden" id="k_B7_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB7_5 odds" id="o_B7_5">--</td>
                        <td class="GB7_5 amount ha" id="a_B7_5"><input name="B7_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_6 name" id="t_B7_6" title="第七名 6"><input type="hidden" id="k_B7_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB7_6 odds" id="o_B7_6">--</td>
                        <td class="GB7_6 amount ha" id="a_B7_6"><input name="B7_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_7 name" id="t_B7_7" title="第七名 7"><input type="hidden" id="k_B7_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB7_7 odds" id="o_B7_7">--</td>
                        <td class="GB7_7 amount ha" id="a_B7_7"><input name="B7_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_8 name" id="t_B7_8" title="第七名 8"><input type="hidden" id="k_B7_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB7_8 odds" id="o_B7_8">--</td>
                        <td class="GB7_8 amount ha" id="a_B7_8"><input name="B7_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_9 name" id="t_B7_9" title="第七名 9"><input type="hidden" id="k_B7_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB7_9 odds" id="o_B7_9">--</td>
                        <td class="GB7_9 amount ha" id="a_B7_9"><input name="B7_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB7_10 name" id="t_B7_10" title="第七名 10"><input type="hidden" id="k_B7_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB7_10 odds" id="o_B7_10">--</td>
                        <td class="GB7_10 amount ha" id="a_B7_10"><input name="B7_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">第八名</th></tr>
                    <tr><th class="GB8_1 name" id="t_B8_1" title="第八名 1"><input type="hidden" id="k_B8_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB8_1 odds" id="o_B8_1">--</td>
                        <td class="GB8_1 amount ha" id="a_B8_1"><input name="B8_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_2 name" id="t_B8_2" title="第八名 2"><input type="hidden" id="k_B8_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB8_2 odds" id="o_B8_2">--</td>
                        <td class="GB8_2 amount ha" id="a_B8_2"><input name="B8_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_3 name" id="t_B8_3" title="第八名 3"><input type="hidden" id="k_B8_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB8_3 odds" id="o_B8_3">--</td>
                        <td class="GB8_3 amount ha" id="a_B8_3"><input name="B8_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_4 name" id="t_B8_4" title="第八名 4"><input type="hidden" id="k_B8_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB8_4 odds" id="o_B8_4">--</td>
                        <td class="GB8_4 amount ha" id="a_B8_4"><input name="B8_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_5 name" id="t_B8_5" title="第八名 5"><input type="hidden" id="k_B8_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB8_5 odds" id="o_B8_5">--</td>
                        <td class="GB8_5 amount ha" id="a_B8_5"><input name="B8_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_6 name" id="t_B8_6" title="第八名 6"><input type="hidden" id="k_B8_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB8_6 odds" id="o_B8_6">--</td>
                        <td class="GB8_6 amount ha" id="a_B8_6"><input name="B8_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_7 name" id="t_B8_7" title="第八名 7"><input type="hidden" id="k_B8_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB8_7 odds" id="o_B8_7">--</td>
                        <td class="GB8_7 amount ha" id="a_B8_7"><input name="B8_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_8 name" id="t_B8_8" title="第八名 8"><input type="hidden" id="k_B8_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB8_8 odds" id="o_B8_8">--</td>
                        <td class="GB8_8 amount ha" id="a_B8_8"><input name="B8_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_9 name" id="t_B8_9" title="第八名 9"><input type="hidden" id="k_B8_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB8_9 odds" id="o_B8_9">--</td>
                        <td class="GB8_9 amount ha" id="a_B8_9"><input name="B8_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB8_10 name" id="t_B8_10" title="第八名 10"><input type="hidden" id="k_B8_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB8_10 odds" id="o_B8_10">--</td>
                        <td class="GB8_10 amount ha" id="a_B8_10"><input name="B8_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">第九名</th></tr>
                    <tr><th class="GB9_1 name" id="t_B9_1" title="第九名 1"><input type="hidden" id="k_B9_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB9_1 odds" id="o_B9_1">--</td>
                        <td class="GB9_1 amount ha" id="a_B9_1"><input name="B9_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_2 name" id="t_B9_2" title="第九名 2"><input type="hidden" id="k_B9_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB9_2 odds" id="o_B9_2">--</td>
                        <td class="GB9_2 amount ha" id="a_B9_2"><input name="B9_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_3 name" id="t_B9_3" title="第九名 3"><input type="hidden" id="k_B9_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB9_3 odds" id="o_B9_3">--</td>
                        <td class="GB9_3 amount ha" id="a_B9_3"><input name="B9_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_4 name" id="t_B9_4" title="第九名 4"><input type="hidden" id="k_B9_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB9_4 odds" id="o_B9_4">--</td>
                        <td class="GB9_4 amount ha" id="a_B9_4"><input name="B9_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_5 name" id="t_B9_5" title="第九名 5"><input type="hidden" id="k_B9_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB9_5 odds" id="o_B9_5">--</td>
                        <td class="GB9_5 amount ha" id="a_B9_5"><input name="B9_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_6 name" id="t_B9_6" title="第九名 6"><input type="hidden" id="k_B9_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB9_6 odds" id="o_B9_6">--</td>
                        <td class="GB9_6 amount ha" id="a_B9_6"><input name="B9_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_7 name" id="t_B9_7" title="第九名 7"><input type="hidden" id="k_B9_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB9_7 odds" id="o_B9_7">--</td>
                        <td class="GB9_7 amount ha" id="a_B9_7"><input name="B9_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_8 name" id="t_B9_8" title="第九名 8"><input type="hidden" id="k_B9_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB9_8 odds" id="o_B9_8">--</td>
                        <td class="GB9_8 amount ha" id="a_B9_8"><input name="B9_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_9 name" id="t_B9_9" title="第九名 9"><input type="hidden" id="k_B9_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB9_9 odds" id="o_B9_9">--</td>
                        <td class="GB9_9 amount ha" id="a_B9_9"><input name="B9_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB9_10 name" id="t_B9_10" title="第九名 10"><input type="hidden" id="k_B9_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB9_10 odds" id="o_B9_10">--</td>
                        <td class="GB9_10 amount ha" id="a_B9_10"><input name="B9_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
                <table>
                    <tbody><tr class="head"><th colspan="3">第十名</th></tr>
                    <tr><th class="GB10_1 name" id="t_B10_1" title="第十名 1"><input type="hidden" id="k_B10_1" value="BALL"><span class="b1">1</span></th>

                        <td class="GB10_1 odds" id="o_B10_1">--</td>
                        <td class="GB10_1 amount ha" id="a_B10_1"><input name="B10_1" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_2 name" id="t_B10_2" title="第十名 2"><input type="hidden" id="k_B10_2" value="BALL"><span class="b2">2</span></th>

                        <td class="GB10_2 odds" id="o_B10_2">--</td>
                        <td class="GB10_2 amount ha" id="a_B10_2"><input name="B10_2" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_3 name" id="t_B10_3" title="第十名 3"><input type="hidden" id="k_B10_3" value="BALL"><span class="b3">3</span></th>

                        <td class="GB10_3 odds" id="o_B10_3">--</td>
                        <td class="GB10_3 amount ha" id="a_B10_3"><input name="B10_3" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_4 name" id="t_B10_4" title="第十名 4"><input type="hidden" id="k_B10_4" value="BALL"><span class="b4">4</span></th>

                        <td class="GB10_4 odds" id="o_B10_4">--</td>
                        <td class="GB10_4 amount ha" id="a_B10_4"><input name="B10_4" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_5 name" id="t_B10_5" title="第十名 5"><input type="hidden" id="k_B10_5" value="BALL"><span class="b5">5</span></th>

                        <td class="GB10_5 odds" id="o_B10_5">--</td>
                        <td class="GB10_5 amount ha" id="a_B10_5"><input name="B10_5" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_6 name" id="t_B10_6" title="第十名 6"><input type="hidden" id="k_B10_6" value="BALL"><span class="b6">6</span></th>

                        <td class="GB10_6 odds" id="o_B10_6">--</td>
                        <td class="GB10_6 amount ha" id="a_B10_6"><input name="B10_6" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_7 name" id="t_B10_7" title="第十名 7"><input type="hidden" id="k_B10_7" value="BALL"><span class="b7">7</span></th>

                        <td class="GB10_7 odds" id="o_B10_7">--</td>
                        <td class="GB10_7 amount ha" id="a_B10_7"><input name="B10_7" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_8 name" id="t_B10_8" title="第十名 8"><input type="hidden" id="k_B10_8" value="BALL"><span class="b8">8</span></th>

                        <td class="GB10_8 odds" id="o_B10_8">--</td>
                        <td class="GB10_8 amount ha" id="a_B10_8"><input name="B10_8" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_9 name" id="t_B10_9" title="第十名 9"><input type="hidden" id="k_B10_9" value="BALL"><span class="b9">9</span></th>

                        <td class="GB10_9 odds" id="o_B10_9">--</td>
                        <td class="GB10_9 amount ha" id="a_B10_9"><input name="B10_9" class="ba" disabled=""></td>
                    </tr>
                    <tr><th class="GB10_10 name" id="t_B10_10" title="第十名 10"><input type="hidden" id="k_B10_10" value="BALL"><span class="b10">10</span></th>

                        <td class="GB10_10 odds" id="o_B10_10">--</td>
                        <td class="GB10_10 amount ha" id="a_B10_10"><input name="B10_10" class="ba" disabled=""></td>
                    </tr>
                    </tbody></table>
            </div>
        @endif
        @if($page == 'gy')
            <table class="table_lm">
                <tbody><tr class="head"><th colspan="12">冠、亚军和</th></tr>
                <tr>
                    <th class="GGYH_3 name" id="t_GYH_3" title=" 3"><input type="hidden" id="k_GYH_3" value="GYH">3</th>

                    <td class="GGYH_3 odds" id="o_GYH_3">--</td>
                    <td class="GGYH_3 amount ha" id="a_GYH_3"><input name="GYH_3" class="ba" disabled=""></td>
                    <th class="GGYH_4 name" id="t_GYH_4" title=" 4"><input type="hidden" id="k_GYH_4" value="GYH">4</th>

                    <td class="GGYH_4 odds" id="o_GYH_4">--</td>
                    <td class="GGYH_4 amount ha" id="a_GYH_4"><input name="GYH_4" class="ba" disabled=""></td>
                    <th class="GGYH_5 name" id="t_GYH_5" title=" 5"><input type="hidden" id="k_GYH_5" value="GYH">5</th>

                    <td class="GGYH_5 odds" id="o_GYH_5">--</td>
                    <td class="GGYH_5 amount ha" id="a_GYH_5"><input name="GYH_5" class="ba" disabled=""></td>
                    <th class="GGYH_6 name" id="t_GYH_6" title=" 6"><input type="hidden" id="k_GYH_6" value="GYH">6</th>

                    <td class="GGYH_6 odds" id="o_GYH_6">--</td>
                    <td class="GGYH_6 amount ha" id="a_GYH_6"><input name="GYH_6" class="ba" disabled=""></td>
                </tr>
                <tr>
                    <th class="GGYH_7 name" id="t_GYH_7" title=" 7"><input type="hidden" id="k_GYH_7" value="GYH">7</th>

                    <td class="GGYH_7 odds" id="o_GYH_7">--</td>
                    <td class="GGYH_7 amount ha" id="a_GYH_7"><input name="GYH_7" class="ba" disabled=""></td>
                    <th class="GGYH_8 name" id="t_GYH_8" title=" 8"><input type="hidden" id="k_GYH_8" value="GYH">8</th>

                    <td class="GGYH_8 odds" id="o_GYH_8">--</td>
                    <td class="GGYH_8 amount ha" id="a_GYH_8"><input name="GYH_8" class="ba" disabled=""></td>
                    <th class="GGYH_9 name" id="t_GYH_9" title=" 9"><input type="hidden" id="k_GYH_9" value="GYH">9</th>

                    <td class="GGYH_9 odds" id="o_GYH_9">--</td>
                    <td class="GGYH_9 amount ha" id="a_GYH_9"><input name="GYH_9" class="ba" disabled=""></td>
                    <th class="GGYH_10 name" id="t_GYH_10" title=" 10"><input type="hidden" id="k_GYH_10" value="GYH">10</th>

                    <td class="GGYH_10 odds" id="o_GYH_10">--</td>
                    <td class="GGYH_10 amount ha" id="a_GYH_10"><input name="GYH_10" class="ba" disabled=""></td>
                </tr>
                <tr>
                    <th class="GGYH_11 name" id="t_GYH_11" title=" 11"><input type="hidden" id="k_GYH_11" value="GYH">11</th>

                    <td class="GGYH_11 odds" id="o_GYH_11">--</td>
                    <td class="GGYH_11 amount ha" id="a_GYH_11"><input name="GYH_11" class="ba" disabled=""></td>
                    <th class="GGYH_12 name" id="t_GYH_12" title=" 12"><input type="hidden" id="k_GYH_12" value="GYH">12</th>

                    <td class="GGYH_12 odds" id="o_GYH_12">--</td>
                    <td class="GGYH_12 amount ha" id="a_GYH_12"><input name="GYH_12" class="ba" disabled=""></td>
                    <th class="GGYH_13 name" id="t_GYH_13" title=" 13"><input type="hidden" id="k_GYH_13" value="GYH">13</th>

                    <td class="GGYH_13 odds" id="o_GYH_13">--</td>
                    <td class="GGYH_13 amount ha" id="a_GYH_13"><input name="GYH_13" class="ba" disabled=""></td>
                    <th class="GGYH_14 name" id="t_GYH_14" title=" 14"><input type="hidden" id="k_GYH_14" value="GYH">14</th>

                    <td class="GGYH_14 odds" id="o_GYH_14">--</td>
                    <td class="GGYH_14 amount ha" id="a_GYH_14"><input name="GYH_14" class="ba" disabled=""></td>
                </tr>
                <tr>
                    <th class="GGYH_15 name" id="t_GYH_15" title=" 15"><input type="hidden" id="k_GYH_15" value="GYH">15</th>

                    <td class="GGYH_15 odds" id="o_GYH_15">--</td>
                    <td class="GGYH_15 amount ha" id="a_GYH_15"><input name="GYH_15" class="ba" disabled=""></td>
                    <th class="GGYH_16 name" id="t_GYH_16" title=" 16"><input type="hidden" id="k_GYH_16" value="GYH">16</th>

                    <td class="GGYH_16 odds" id="o_GYH_16">--</td>
                    <td class="GGYH_16 amount ha" id="a_GYH_16"><input name="GYH_16" class="ba" disabled=""></td>
                    <th class="GGYH_17 name" id="t_GYH_17" title=" 17"><input type="hidden" id="k_GYH_17" value="GYH">17</th>

                    <td class="GGYH_17 odds" id="o_GYH_17">--</td>
                    <td class="GGYH_17 amount ha" id="a_GYH_17"><input name="GYH_17" class="ba" disabled=""></td>
                    <th class="GGYH_18 name" id="t_GYH_18" title=" 18"><input type="hidden" id="k_GYH_18" value="GYH">18</th>

                    <td class="GGYH_18 odds" id="o_GYH_18">--</td>
                    <td class="GGYH_18 amount ha" id="a_GYH_18"><input name="GYH_18" class="ba" disabled=""></td>
                </tr>
                <tr><th class="GGYH_19 name" id="t_GYH_19" title=" 19"><input type="hidden" id="k_GYH_19" value="GYH">19</th>

                    <td class="GGYH_19 odds" id="o_GYH_19">--</td>
                    <td class="GGYH_19 amount ha" id="a_GYH_19"><input name="GYH_19" class="ba" disabled=""></td>
                    <th id="e_EP0" class="GEP0 name empty"></th><td class="GEP0 odds empty"></td><td class="GEP0 amount ha"></td>
                    <th id="e_EP1" class="GEP1 name empty"></th><td class="GEP1 odds empty"></td><td class="GEP1 amount ha"></td>
                    <th id="e_EP2" class="GEP2 name empty"></th><td class="GEP2 odds empty"></td><td class="GEP2 amount ha"></td>
                </tr>
                <tr><th class="GGDX_D name" id="t_GDX_D" title=" 冠亚大"><input type="hidden" id="k_GDX_D" value="GDX">冠亚大</th>

                    <td class="GGDX_D odds" id="o_GDX_D">--</td>
                    <td class="GGDX_D amount ha" id="a_GDX_D"><input name="GDX_D" class="ba" disabled=""></td>

                    <th class="GGDX_X name" id="t_GDX_X" title=" 冠亚小"><input type="hidden" id="k_GDX_X" value="GDX">冠亚小</th>

                    <td class="GGDX_X odds" id="o_GDX_X">--</td>
                    <td class="GGDX_X amount ha" id="a_GDX_X"><input name="GDX_X" class="ba" disabled=""></td>
                    <th class="GGDS_D name" id="t_GDS_D" title=" 冠亚单"><input type="hidden" id="k_GDS_D" value="GDS">冠亚单</th>

                    <td class="GGDS_D odds" id="o_GDS_D">--</td>
                    <td class="GGDS_D amount ha" id="a_GDS_D"><input name="GDS_D" class="ba" disabled=""></td>
                    <th class="GGDS_S name" id="t_GDS_S" title=" 冠亚双"><input type="hidden" id="k_GDS_S" value="GDS">冠亚双</th>

                    <td class="GGDS_S odds" id="o_GDS_S">--</td>
                    <td class="GGDS_S amount ha" id="a_GDS_S"><input name="GDS_S" class="ba" disabled=""></td>
                </tr>
                </tbody></table>
        @endif
    </div>
    <div class="control bcontrol">
        <div class="lefts" style="display:none">已经选中 <span id="betcount"></span> 注</div>
        <div class="buttons">
            <input type="button" class="button2" value="快选金额" onclick="parent.showsetting()"/>
            <label class="checkdefault"><input type="checkbox" class="checkbox"/><span class="color_lv bold">预设</span></label>&nbsp;&nbsp;<label
                id="quickAmount" class="quickAmount"><span class="color_lv bold">金额</span> <input/></label>
            <input type="button" class="button" value="确定" onclick="bet()"/><input type="button" class="button"
                                                                                     value="重置"
                                                                                     onclick="resetBets()"/>
            <input type="button" class="button" value="重覆上次下单" onclick="repeatbet()" style="width: 100px">
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/default/js/fastBet.js"></script>
<script type="text/javascript">
    var BALL_NUMBERS = 10; var RANK_BALL_NUMBERS =10; var fastBets=[];
    var games = 'DX1,DX2,DX3,DX4,DX5,DX6,DX7,DX8,DX9,DX10,DS1,DS2,DS3,DS4,DS5,DS6,DS7,DS8,DS9,DS10,GDX,GDS,LH1,LH2,LH3,LH4,LH5,' +
        'B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,GDX,GDS,GYH';
    var guestDefault = ["GDX_X","GDX_D","GDS_D","GDS_S","DX_X_T","DX_D_T","DS_D_T","DS_S_T","DX_X_L",
        "DX_D_L","DS_D_L","DS_S_L","TM_B1_D","TM_B1_S","TM_B1_B","TM_B1_X"];
    const ballsNameMap = new Map([
        [1, "冠军"],
        [2, "亚军"],
        [3, "第三名"],
        [4, "第四名"],
        [5, "第五名"],
        [6, "第六名"],
        [7, "第七名"],
        [8, "第八名"],
        [9, "第九名"],
        [10, "第十名"],
        ["B1", "冠军"],
        ["B2", "亚军"],
        ["B3", "第三名"],
        ["B4", "第四名"],
        ["B5", "第五名"],
        ["B6", "第六名"],
        ["B7", "第七名"],
        ["B8", "第八名"],
        ["B9", "第九名"],
        ["B10", "第十名"]
    ]);
    const betNameMap = new Map([
        ["GDX_D", "冠亚大"],
        ["GDX_X", "冠亚小"],
        ["GDS_D", "冠亚单"],
        ["GDS_S", "冠亚双"],
        ["DX_D", "大"],
        ["DX_X", "小"],
        ["DS_D", "单"],
        ["DS_S", "双"],
        ["LH_L", "龙"],
        ["LH_H", "虎"]
    ]);

    const options = new Map([
        ["GDX_X", "冠，亚+冠亚和-小"],
        ["GDX_D", "冠，亚+冠亚和-大"],
        ["GDS_D", "冠，亚+冠亚和-单"],
        ["GDS_S", "冠，亚+冠亚和-双"],
        ["DX_X_T", "1-5名小"],
        ["DX_D_T", "1-5名大"],
        ["DS_D_T", "1-5名单"],
        ["DS_S_T", "1-5名双"],
        ["DX_X_L", "6-10名小"],
        ["DX_D_L", "6-10名大"],
        ["DS_D_L", "6-10名单"],
        ["DS_S_L", "6-10名双"],
        ["TM_B1_D",	"1名特码-单"],
        ["TM_B1_S",	"1名特码-双"],
        ["TM_B1_B",	"1名特码-大"],
        ["TM_B1_X",	"1名特码-小"],
        ["TM_B2_D",	"2名特码-单"],
        ["TM_B2_S",	"2名特码-双"],
        ["TM_B2_B",	"2名特码-大"],
        ["TM_B2_X",	"2名特码-小"],
        ["TM_B3_D",	"3名特码-单"],
        ["TM_B3_S",	"3名特码-双"],
        ["TM_B3_B",	"3名特码-大"],
        ["TM_B3_X",	"3名特码-小"],
        ["TM_B4_D",	"4名特码-单"],
        ["TM_B4_S",	"4名特码-双"],
        ["TM_B4_B",	"4名特码-大"],
        ["TM_B4_X",	"4名特码-小"],
        ["TM_B5_D",	"5名特码-单"],
        ["TM_B5_S",	"5名特码-双"],
        ["TM_B5_B",	"5名特码-大"],
        ["TM_B5_X",	"5名特码-小"],
        ["TM_B6_D",	"6名特码-单"],
        ["TM_B6_S",	"6名特码-双"],
        ["TM_B6_B",	"6名特码-大"],
        ["TM_B6_X",	"6名特码-小"],
        ["TM_B7_D",	"7名特码-单"],
        ["TM_B7_S",	"7名特码-双"],
        ["TM_B7_B",	"7名特码-大"],
        ["TM_B7_X",	"7名特码-小"],
        ["TM_B8_D",	"8名特码-单"],
        ["TM_B8_S",	"8名特码-双"],
        ["TM_B8_B",	"8名特码-大"],
        ["TM_B8_X",	"8名特码-小"],
        ["TM_B9_D",	"9名特码-单"],
        ["TM_B9_S",	"9名特码-双"],
        ["TM_B9_B",	"9名特码-大"],
        ["TM_B9_X",	"9名特码-小"],
        ["TM_B10_D", "10名特码-单"],
        ["TM_B10_S", "10名特码-双"],
        ["TM_B10_B", "10名特码-大"],
        ["TM_B10_X", "10名特码-小"],
        ["FB_DX_T",	"1-5名大小追同"],
        ["RB_DX_T",	"1-5名大小追反"],
        ["FB_DS_T",	"1-5名单双追同"],
        ["RB_DS_T",	"1-5名单双追反"],
        ["FB_DX_L",	"6-10名大小追同"],
        ["RB_DX_L",	"6-10名大小追反"],
        ["FB_DS_L",	"6-10名单双追同"],
        ["RB_DS_L",	"6-10名单双追反"],
        ["FB_DS", "1-10名单双追同"],
        ["RB_DS", "1-10名单双追反"],
        ["RB_DX", "1-10名大小追反"],
        ["FB_DX", "1-10名大小追同"],
        ["MFB_DX_T", "1-5名上期热门大小-追同"],
        ["MRB_DX_T", "1-5名上期热门大小-追反"],
        ["MFB_DS_T", "1-5名上期热门单双-追同"],
        ["MRB_DS_T", "1-5名上期热门单双-追反"],
        ["MRB_DS_L", "6-10名上期热门单双-追反"],
        ["MFB_DS_L", "6-10名上期热门单双-追同"],
        ["MRB_DX_L", "6-10名上期热门大小-追反"],
        ["MFB_DX_L", "6-10名上期热门大小-追同"],
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
    <div class="rptab1 ml complexTab"><span><a class="" href="complexBet?lottery={{$lottery}}&page={{$page}}">公式投</a></span></div>
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
            <th class="table_side">快选项目</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td id="GDX_X" style="display:none;"> 冠，亚+冠亚和-小</td>
        </tr>
        <tr>
            <td id="GDX_D" style="display:none;"> 冠，亚+冠亚和-大</td>
        </tr>
        <tr>
            <td id="GDS_D" style="display:none;"> 冠，亚+冠亚和-单</td>
        </tr>
        <tr>
            <td id="GDS_S" style="display:none;"> 冠，亚+冠亚和-双</td>
        </tr>
        <tr>
            <td id="DX_X_T" style="display:none;"> 1-5名小</td>
        </tr>
        <tr>
            <td id="DX_D_T" style="display:none;"> 1-5名大</td>
        </tr>
        <tr>
            <td id="DS_D_T" style="display:none;"> 1-5名单</td>
        </tr>
        <tr>
            <td id="DS_S_T" style="display:none;"> 1-5名双</td>
        </tr>
        <tr>
            <td id="DX_X_L" style="display:none;"> 6-10名小</td>
        </tr>
        <tr>
            <td id="DX_D_L" style="display:none;"> 6-10名大</td>
        </tr>
        <tr>
            <td id="DS_D_L" style="display:none;"> 6-10名单</td>
        </tr>
        <tr>
            <td id="DS_S_L" style="display:none;"> 6-10名双</td>
        </tr>
        <tr>
            <td id="TM_B1_D" style="display:none;"> 1名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B1_S" style="display:none;"> 1名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B1_B" style="display:none;"> 1名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B1_X" style="display:none;"> 1名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B2_D" style="display:none;"> 2名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B2_S" style="display:none;"> 2名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B2_B" style="display:none;"> 2名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B2_X" style="display:none;"> 2名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B3_D" style="display:none;"> 3名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B3_S" style="display:none;"> 3名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B3_B" style="display:none;"> 3名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B3_X" style="display:none;"> 3名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B4_D" style="display:none;"> 4名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B4_S" style="display:none;"> 4名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B4_B" style="display:none;"> 4名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B4_X" style="display:none;"> 4名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B5_D" style="display:none;"> 5名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B5_S" style="display:none;"> 5名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B5_B" style="display:none;"> 5名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B5_X" style="display:none;"> 5名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B6_D" style="display:none;"> 6名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B6_S" style="display:none;"> 6名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B6_B" style="display:none;"> 6名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B6_X" style="display:none;"> 6名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B7_D" style="display:none;"> 7名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B7_S" style="display:none;"> 7名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B7_B" style="display:none;"> 7名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B7_X" style="display:none;"> 7名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B8_D" style="display:none;"> 8名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B8_S" style="display:none;"> 8名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B8_B" style="display:none;"> 8名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B8_X" style="display:none;"> 8名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B9_D" style="display:none;"> 9名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B9_S" style="display:none;"> 9名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B9_B" style="display:none;"> 9名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B9_X" style="display:none;"> 9名特码-小</td>
        </tr>
        <tr>
            <td id="TM_B10_D" style="display:none;"> 10名特码-单</td>
        </tr>
        <tr>
            <td id="TM_B10_S" style="display:none;"> 10名特码-双</td>
        </tr>
        <tr>
            <td id="TM_B10_B" style="display:none;"> 10名特码-大</td>
        </tr>
        <tr>
            <td id="TM_B10_X" style="display:none;"> 10名特码-小</td>
        </tr>
        <tr>
            <td id="FB_DX_T" style="display:none;"> 1-5名大小追同</td>
        </tr>
        <tr>
            <td id="RB_DX_T" style="display:none;"> 1-5名大小追反</td>
        </tr>
        <tr>
            <td id="FB_DS_T" style="display:none;"> 1-5名单双追同</td>
        </tr>
        <tr>
            <td id="RB_DS_T" style="display:none;"> 1-5名单双追反</td>
        </tr>
        <tr>
            <td id="FB_DX_L" style="display:none;"> 6-10名大小追同</td>
        </tr>
        <tr>
            <td id="RB_DX_L" style="display:none;"> 6-10名大小追反</td>
        </tr>
        <tr>
            <td id="FB_DS_L" style="display:none;"> 6-10名单双追同</td>
        </tr>
        <tr>
            <td id="RB_DS_L" style="display:none;"> 6-10名单双追反</td>
        </tr>
        <tr>
            <td id="RB_DS" style="display:none;"> 1-10名单双追反</td>
        </tr>
        <tr>
            <td id="FB_DS" style="display:none;"> 1-10名单双追同</td>
        </tr>
        <tr>
            <td id="RB_DX" style="display:none;"> 1-10名大小追反</td>
        </tr>
        <tr>
            <td id="FB_DX" style="display:none;"> 1-10名大小追同</td>
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
            <td id="MFB_DX_T" style="display:none;"> 1-5名上期热门大小-追同</td>
        </tr>
        <tr>
            <td id="MRB_DX_T" style="display:none;"> 1-5名上期热门大小-追反</td>
        </tr>
        <tr>
            <td id="MFB_DS_T" style="display:none;"> 1-5名上期热门单双-追同</td>
        </tr>
        <tr>
            <td id="MRB_DS_T" style="display:none;"> 1-5名上期热门单双-追反</td>
        </tr>
        <tr>
            <td id="MRB_DS_L" style="display:none;"> 6-10名上期热门单双-追反</td>
        </tr>
        <tr>
            <td id="MFB_DS_L" style="display:none;"> 6-10名上期热门单双-追同</td>
        </tr>
        <tr>
            <td id="MRB_DX_L" style="display:none;"> 6-10名上期热门大小-追反</td>
        </tr>
        <tr>
            <td id="MFB_DX_L" style="display:none;"> 6-10名上期热门大小-追同</td>
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
</body>
</html>
