<head>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/complexBet.css?v=0115"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/fonts/font-awesome.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/dialog.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/complexBetMain.js"></script>
    <script type="text/javascript" src="/static/default/js/complexBet.js"></script>
    <script type="text/javascript" src="/static/default/js/rightpanel.js"></script>
    <script type="text/javascript">var lotteryid = '{{$lottery}}'</script>
</head>


<body>
<div id="complex_bet">
    <div id="main">
        <div id="header">
            <div class="complexTitle"><span>公式投注</span></div>
            <div class="complexTitleDescription">
                <span>公式投一旦启用，会员账号登出后，公式投会继续运行，除非止盈止损或者手动设置才会停止运行</span></div>
            <div class="batchButton">
                <input type="button" class="complexBatchEnabled" value="批量启动"
                       onclick="parentBatchEnableComplexDetail()"/>
                <input type="button" class="complexBatchDisabled" value="批量停止"
                       onclick="parentBatchDisableComplexDetail()"/>
                <input type="button" class="complexBatchDelete" value="批量删除"
                       onclick="parentBatchDelComplexDetail()"/>

                <input type="button" class="complexAddPlan" value="添加方案" onclick="addComplexDetail('{{$lottery}}','1')"/>

            </div>
            <div>
                <form id="complexSaveForm">
                    <table id="complexTableHeader" class="complexTableHeader">
                        <thead>
                        <tr>
                            <th colspan="1"><input type="checkbox" id="complexBatchSel" class="complexBatchSel"
                                                   onclick="complexKXplan(10)"></th>
                            <th colspan="1">序号</th>
                            <th colspan="2">方案名称</th>
                            <th colspan="1">方式</th>
                            <th colspan="1">投注金额</th>
                            <th colspan="1">止损金额</th>
                            <th colspan="1">止盈金额</th>
                            <th colspan="1">今日盈亏</th>
                            <th colspan="3">操作</th>

                        </tr>
                        </thead>
                        <tbody id="complexTableBody" class="complexTableBody">
                        @foreach($list as $k=>$vo)
                        <tr>
                            <th colspan="1"><input type="checkbox" id="complexBatchSel_{{$k+1}}" name="complexBatchSel_{{$k+1}}"
                                                   class="complexBatchSel" value="{{$vo['id']}}"></th>
                            <td colspan="1">{{$k+1}}</td>
                            <td colspan="2" style="max-width: 100px">{{$vo['planName']}}</td>
                            <td colspan="1">指定位置</td>
                            <td colspan="1" style="max-width: 100px">{{$vo['amount']}}</td>
                            <td colspan="1">{{$vo['stoploss']}}</td>
                            <td colspan="1">{{$vo['takeprofit']}}</td>
                            <td colspan="1">{{$vo['yk']}}</td>
                            <td colspan="3" style="max-width: 150px">
                                <div><span id="showComplexDetail" class="showComplexDetail"
                                           onclick="parentShowComplexDetail({{$vo['id']}}, '{{$vo['planName']}}', '{{$vo['lottery']}}')"></span>
                                    <span id="editComplexDetail" class="editComplexDetail"
                                          onclick="editComplexDetail('{{$vo['lottery']}}','{{$vo['id']}}','0')"></span>
                                    <div id="deleteComplexDetail"><span id="deleteComplexDetail"
                                                                        class="deleteComplexDetail"
                                                                        onclick="parentDelComplexDetail({{$vo['id']}})"></span>
                                    </div>
                                    @if($vo['enabled'] == 0)
                                        <span id="complexDetailStatus" class="complexDetailStatus" onclick="parentOnComplexBet({{$vo['id']}})"></span>
                                    @else
                                        <span id="complexDetailStatus" class="complexDetailStatus active" onclick="parentOffComplexBet({{$vo['id']}})"></span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($list)==0)
                        <tr>
                            <td colspan="12"><div id="complexTableNoData" class="complexTableNoData">暂无数据!</div></td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var BALL_NUMBERS = 5;
    var RANK_BALL_NUMBERS = 9;
    var fastBets = [];
    var games = 'DX1,DX2,DX3,DX4,DX5,DS1,DS2,DS3,DS4,DS5,ZDX,ZDS,LH,TS1,TS2,TS3,B1,B2,B3,B4,B5,DN,DNDX,DNDS,DNGP,' +
        'DNYD,DNLD,DNSANT,DNSHUNZ,DNHL,DNSIT,DNWT,1ZTS1,1ZTS2,1ZTS3,1ZTS5,2ZTS1,2ZTS2,2ZTS3,3ZTS1,3ZTS2,3ZTS3,DW21,' +
        'DW31,DW32,DW41,DW42,DW43,DW51,DW52,DW53,DW54,DW321,DW432,DW543,HS21,HS31,HS32,HS41,HS42,HS43,HS51,HS52,HS53,' +
        'HS54,HWS21,HWS31,HWS32,HWS41,HWS42,HWS43,HWS51,HWS52,HWS53,HWS54,HS543,HS432,HS321,HWS543,HWS432,HWS321,' +
        'ZX3TS1,ZX3TS2,ZX3TS3,ZX6TS1,ZX6TS2,ZX6TS3,FSTS1,FSTS2,FSTS3,KDTS1,KDTS2,KDTS3,ZX6TS1,ZX6TS2,ZX6TS3,ZX3';
    var guestDefault = ["DX_D", "DX_X", "DS_D", "DS_S", "TM_B1_D", "TM_B1_S", "TM_B1_B", "TM_B1_X", "TM_B2_D", "TM_B2_S", "TM_B2_B",
        "TM_B2_X", "TM_B3_D", "TM_B3_S", "TM_B3_B", "TM_B3_X"];
    const ballsNameMap = new Map([
        [1, "第一球"],
        [2, "第二球"],
        [3, "第三球"],
        [4, "第四球"],
        [5, "第五球"],
        ["B1", "第一球"],
        ["B2", "第二球"],
        ["B3", "第三球"],
        ["B4", "第四球"],
        ["B5", "第五球"]
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
        ["LH_L", "龙"],
        ["LH_H", "虎"],
        ["LH_T", "和"]
    ]);

    const options = new Map([
        ["DX_D", "1-5球大"],
        ["DX_X", "1-5球小"],
        ["DS_D", "1-5球单"],
        ["DS_S", "1-5球双"],
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
        ["BALL_DX_D", "全部大"],
        ["BALL_DX_X", "全部小"],
        ["BALL_DS_D", "全部单"],
        ["BALL_DS_S", "全部双"],
        ["FB_DX", "1-5球大小追同"],
        ["RB_DX", "1-5球大小追反"],
        ["FB_DS", "1-5球单双追同"],
        ["RB_DS", "1-5球单双追反"],
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
        ["CL_8_R", "长龙>=8 追反"],
        ["MFB_DX", "上期热门大小-追同"],
        ["MRB_DX", "上期热门大小-追反"],
        ["MFB_DS", "上期热门单双-追同"],
        ["MRB_DS", "上期热门单双-追反"],
        ["PFB_DX", "全部大小追同"],
        ["PRB_DX", "全部大小追反"],
        ["PFB_DS", "全部单双追同"],
        ["PRB_DS", "全部单双追反"]
    ]);
</script>
<div class="rightpanel">


    <div class="rptab1 ml"><span><a class="" href="load?lottery=SSCJSC&page=lm">长龙</a></span></div>
    <div class="rptab1 ml"><span><a class="" href="load?lottery=SSCJSC&page=lm&rightIndex=1">快投</a></span></div>
    <div class="rptab1 ml tabactive1"><span><a class="" href="complexBet?lottery=SSCJSC&page=lm">公式投</a></span></div>

    <table id="changlong">
        <thead>
        <tr>
            <th colspan="2" class="table_side" style="display: none;">两面长龙排行</th>
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
            <td id="DX_D" style="display:none;"> 1-5球大</td>
        </tr>
        <tr>
            <td id="DX_X" style="display:none;"> 1-5球小</td>
        </tr>
        <tr>
            <td id="DS_D" style="display:none;"> 1-5球单</td>
        </tr>
        <tr>
            <td id="DS_S" style="display:none;"> 1-5球双</td>
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
            <td id="FB_DX" style="display:none;"> 1-5球大小追同</td>
        </tr>
        <tr>
            <td id="RB_DX" style="display:none;"> 1-5球大小追反</td>
        </tr>
        <tr>
            <td id="FB_DS" style="display:none;"> 1-5球单双追同</td>
        </tr>
        <tr>
            <td id="RB_DS" style="display:none;"> 1-5球单双追反</td>
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
            <td id="MFB_DX" style="display:none;"> 上期热门大小-追同</td>
        </tr>
        <tr>
            <td id="MRB_DX" style="display:none;"> 上期热门大小-追反</td>
        </tr>
        <tr>
            <td id="MFB_DS" style="display:none;"> 上期热门单双-追同</td>
        </tr>
        <tr>
            <td id="MRB_DS" style="display:none;"> 上期热门单双-追反</td>
        </tr>
        <tr>
            <td id="PFB_DX" style="display:none;"> 全部大小追同</td>
        </tr>
        <tr>
            <td id="PRB_DX" style="display:none;"> 全部大小追反</td>
        </tr>
        <tr>
            <td id="PFB_DS" style="display:none;"> 全部单双追同</td>
        </tr>
        <tr>
            <td id="PRB_DS" style="display:none;"> 全部单双追反</td>
        </tr>
        <tr>
            <th id="fastBetSettingTh">
                <div id="fastBetSetting"> 设置快选选项</div>
            </th>
        </tr>
        </tbody>
    </table>
    <table id="complexTableLotteryFilter" class="complexTableLotteryFilter">
        <thead>
        <tr>
            <th colspan="2" class="">公式投注</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td @if($filterLottery=='')style="background-color: #FEC214" @endif id="complexLotteryFilter" class="complexLotteryFilter"><a
                href="complexBet?lottery={{$lottery}}&page={{$page}}">全部游戏</a></td>
        </tr>
        @foreach($lotterys as $lot)
        <tr>
            <td @if($filterLottery==$lot['lottery'])style="background-color: #FEC214" @endif id="complexLotteryFilter" class="complexLotteryFilter"><a
                href="complexBet?lottery={{$lottery}}&page={{$page}}&filterLottery={{$lot['lottery']}}&filter=true">{{$lot['lotteryname']}}</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>


</div>


<script type="text/javascript">
    $(document).ready(function () {


        $(".rptab1").click(function () {
            window.location = $(this).find("a").attr("href");
            return false;
        });

    });

</script>


</body>



