<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/balls.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_SSC.css"/>
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
    var template = '{{$template}}';
    var page = '{{$page}}';
    var index = '{{$index}}';
    var index2 = '{{$index2}}';
    LIBS.cookie('page', page);
    LIBS.cookie('index', index);
    LIBS.cookie('index2', index2);
    </script>
    <script type="text/javascript">
                var games = '{{$games}}';
                @if($page == '1z' || $page == '2z' || $page == '3z' || $page == '2zhs' || $page == '3zhs')
            var gameName = '{{$gameName}}';
                @endif
        @if($page == '3z')
            var curGame = '3ZTS'+ {{$tsz}};
                @endif
        @if($page == '2zdw' || $page == '3zdw')
            var MULTIPLE=[3,'{{$fl[0]}}','{{$fl[1]}}',false];
                @endif
        @if($page == 'zx3')
            var MULTIPLE=[1,'{{$fl[0]}}','{{$fl[1]}}',[5,10]];
                @endif
        @if($page == 'zx6')
            var MULTIPLE=[1,'{{$fl[0]}}','{{$fl[1]}}',[4,8]];
                @endif
        @if($page == 'fs')
            var MULTIPLE = [ 3, 'FS{{$index}}', '{{$gameName}}', false ];
                var ballOrientation = '{{$index}}';
                @endif
        @if($page != 'dn')
            $(function () {
                Results.init({
                    '': ['B{0}'],
                    '大小': ['DX{0}', 'dx'],
                    '单双': ['DS{0}', 'ds'],
                    '总和大小': ['ZDX', 'dx'],
                    '总和单双': ['ZDS', 'ds'],
                    '龙虎和': ['LH', 'lh']
                }, 0, 9, ['第一球', '第二球', '第三球', '第四球', '第五球'], 1);
            });
@elseif($page == 'dn')
            $(function(){
                Results.init({
                    '大小' : ['DNDX','dndx'],
                    '单双' : ['DNDS','dnds']
                },0,0,[]);
            });
@endif
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
        <div class="control n_anniu" @if($page == '2zdw')style="position: relative; top: -4px;"@endif
        @if($page == '3zdw' || $page == 'zx3' || $page == 'zx6' || $page == 'fs' || $page == 'kd')style="position: absolute; top: 36px;"@endif>
            <input type="button" class="button2 show-result-list-btn" value="查看近期开奖" onClick="showResultList();"
                   style="float:right;"/>
            @if($page != '2zdw' && $page != '3zdw' && $page != 'zx3' && $page != 'zx6' && $page != 'fs' && $page != 'kd')
            <div class="buttons">
                <label class="checkdefault"><input type="checkbox" class="checkbox"/><span
                    class="color_lv bold">预设</span></label>&nbsp;&nbsp;<label id="quickAmount"
                                                                                class="quickAmount"><span
                class="color_lv bold">金额</span> <input/></label>
                <input type="button" onclick="bet()" value="确定" class="button"/>
                <input type="button" onclick="resetBets()" value="重置" class="button"/>
                <input type="button" class="button" value="重覆上次下单" onclick="repeatbet()" style="width: 100px"/>
            </div>
            @endif
        </div>
        <div id="bet_panel" class="bet_panel input_panel">
            @if($page == '3z')
            <script type="text/javascript" src="/static/default/js/fc3DBase.js"></script>
            @endif
            @if($page == 'lm')
            <x-sgwin.sscplay.lm></x-sgwin.sscplay.lm>
            @elseif($page == 'ball')
            <x-sgwin.sscplay.15></x-sgwin.sscplay.15>
            @elseif($page == '1z')
            <x-sgwin.sscplay.1z></x-sgwin.sscplay.1z>
            @elseif($page == '2z')
            <x-sgwin.sscplay.2z></x-sgwin.sscplay.2z>
            @elseif($page == '3z')
            <x-sgwin.sscplay.3z></x-sgwin.sscplay.3z>
            @elseif($page == '2zdw')
            <x-sgwin.sscplay.2zdw></x-sgwin.sscplay.2zdw>
            <script>
                $(document).ready(function(){
                    var get2zdwList = function () {
                        console.log(bettingStatus);
                        if (!bettingStatus) {
                            return false;
                        }

                        $('#bet_panel .check input').prop('checked',false);
                        $('#bet_panel .check').toggleClass('selected',false);
                        if($('#instantCheck input:checked').length > 0 ||
                            $('#instantCheck input:text').filter(function() { return $(this).val() != '';}).length > 0) {
                            gen2zdwList();
                        }
                    }
                    $('#instantCheck input[type="checkbox"]').on('change', get2zdwList);
                    $('#instantCheck input:text').keyup(get2zdwList);
                    $('#instantCheck span').on('click', get2zdwList);
                });
            </script>
            @elseif($page == '3zdw')
            <x-sgwin.sscplay.3zdw></x-sgwin.sscplay.3zdw>
            <script>
                $(document).ready(function(){
                    var get3zdwList = function (){
                        if (!bettingStatus) {
                            return false;
                        }
                        $('#exprType .bet_table').html('');
                        $('#bet_panel .check input').prop('checked',false);
                        $('#bet_panel .check').toggleClass('selected',false);
                        if($('#instantCheck input:checked').length > 0 ||
                            $('#instantCheck input:text').filter(function() { return $(this).val() != '';}).length > 0 ){
                            gen3zdwList('佰','拾','个');
                        }
                    }
                    $('#instantCheck span').on('click', get3zdwList);
                    $('#instantCheck input:text').keyup(get3zdwList);
                    $('#instantCheck input[type="checkbox"]').on('change', get3zdwList);
                });
            </script>
            @elseif($page == '2zhs')
            <x-sgwin.sscplay.2zhs></x-sgwin.sscplay.2zhs>
            @elseif($page == '3zhs')
            <x-sgwin.sscplay.3zhs></x-sgwin.sscplay.3zhs>
            @elseif($page == 'zx3')
            <x-sgwin.sscplay.zx3></x-sgwin.sscplay.zx3>
            @elseif($page == 'zx6')
            <x-sgwin.sscplay.zx6></x-sgwin.sscplay.zx6>
            @elseif($page == 'fs')
            <script type="text/javascript" src="/default/js/f3dfs.js"></script>
            <script>
                var fs = new F3D_FS();
                $(function() {
                    loadClientOdds('o_FSTS1_0');
                    $("table.table_ball td").click(function(e) {
                        var input = $(this);
                        if ($(e.target).is(":checkbox")) {
                            input = $(e.target);
                        }
                        fs.ShowOdds(input);
                    });
                });
            </script>
            <x-sgwin.sscplay.fs></x-sgwin.sscplay.fs>
            @elseif($page == 'kd')
            <x-sgwin.sscplay.kd></x-sgwin.sscplay.kd>
            @elseif($page == 'dn')
            <x-sgwin.sscplay.dn></x-sgwin.sscplay.dn>
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
        <script type="text/javascript">
            $(document).ready(function(){
                $(".complexTab").click(function() {
                    window.location = $(this).find("a").attr("href");
                    return false;
                });

            });
        </script>
    </div>
</div>

<script type="text/javascript" src="/static/default/js/fastBet.js"></script>
<script type="text/javascript">
    var BALL_NUMBERS = 5;
    var RANK_BALL_NUMBERS = 9;
    var fastBets = [];
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
