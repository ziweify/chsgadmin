<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/balls.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/notice_popup.css?v=1221"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/sweetalert.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/domain.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/js/swfobject.js"></script>
    <script type="text/javascript" src="/static/default/js/member.js?v=1621"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/notices.js"></script>
    <script type="text/javascript" src="/static/default/js/hk6Base.js"></script>
    <script type="text/javascript" src="/static/default/js/drawurls.js"></script>
    <script type="text/javascript" src="/static/default/js/settingbet.js"></script>
    <script type="text/javascript" src="/static/default/js/notice_popup.js?v=1219"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="/static/default/js/gamecard.js"></script>
    <script type="text/javascript" src="/static/default/js/speed.js"></script>
    <script type="text/javascript">
        LIBS.cookie('oid', '1e709a4e98f1b0b0cfc609d0a4d99bb96984ee5b');
        var MAX_DIVIDEND = 5000000;
        var SOUND_URL = '/static/default/css/images/kaijiang.mp3';
        @foreach($news as $key=>$vo)
        noticePopupWithMore({{$cnews}}, {{$key+1}}, "{{$vo['content']}}", "{{$vo['time']}}");
        @endforeach

        var maxTransferLimit = 10000;
        var productList = new Map();
        var settings = new Array();
        settings.push('5');
        settings.push('10');
        settings.push('20');
        settings.push('50');
        settings.push('100');
        settings.push('200');
        settings.push('500');
        settings.push('1000');
        LIBS.cookie('defaultSetting', settings);
        var enabled = false;
        LIBS.cookie('settingChecked', enabled ? 1 : 0);
    </script>
</head>
<body>
<input type="hidden" id="currentLoginUser" value="sanying-{{$username}}"/>
<div id="header" class="header">
    <div class="logo">
        <span>{{$webname}}</span></div>
    <div class="top">
        <div class="menu">
            <div class="menu1">
                <div id="result_info" class="draw_number"></div>
                <a id="result_balls" target="_blank"></a>
            </div>
            <div class="menu2">
                <span><a target="frame" href="bets">未结明细</a></span> |
                <span><a href="bets?settled=true" target="frame">今天已结</a></span> |
                <span><a href="history" target="frame">两周报表</a></span> |
                <span><a href="dresult?lottery={lottery}" target="frame">开奖结果</a></span> <br/>
                <span><a target="frame" href="info?lottery={lottery}">个人资讯</a></span> |
                <span><a target="frame" href="password">修改密码</a></span> |
                <span><a href="rule?lottery={lottery}" target="frame">游戏规则</a></span> |
                <span id="skinPanel"></span>
            </div>
            <div class="menu3"><a href="logout" class="logout">退出</a></div>
            <div style="clear:both;"></div>
        </div>
        <div class="lotterys">
            <div id="lotterys" style="display: none">
                @foreach($lotterys as $key=>$vo)
                    <a href="javascript:void(0)" id="l_{{$vo['lottery']}}"
                       lang="{{$vo['template']}}_0"><span>{{$vo['gname']}}</span></a>
                @endforeach
            </div>
            <div class="show "></div>
            <a class="more_game"><span>更多游戏 </span></a>
            <a class="setting">设置</a>

        </div>

        <div class="sub">
            @foreach($lotterys as $key=>$vo)
                <div id="sub_{{$vo['lottery']}}" style="display:none">
                    @foreach($vo['sub'] as $k=>$v)
                        @if($v['index'] != '')
                            <a href="load?lottery={{$vo['lottery']}}&page={{$v['page']}}&index={{$v['index']}}">{{$v['name']}}</a>
                        @else
                            <a href="load?lottery={{$vo['lottery']}}&page={{$v['page']}}">{{$v['name']}}</a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>
</div>


<div id="main">
    <div class="side_left" id="side">
        <div class="user_info">
            <div class="title">账户信息</div>

            <div class="zhanghu">
                <div class="info">
                    <label>账号：</label>
                    <div class="inline-name">
                        <span>{{$username}} ({{$defaultpan}}盘)</span>
                    </div>
                </div>
                <div id="account0" class="accounts" style="display:none">
                    <div class="info"><label>快开彩额度：</label><span class="balance">{{$kmoney}}</span>
                    </div>
                    <div class="info"><label>未结算金额：</label><span class="betting">{{$wjs}}</span></div>
                </div>
                <div id="account1" class="accounts" style="display:none">
                    <div class="info"><label>全国彩额度：</label><span class="balance">0</span>
                    </div>
                    <div class="info"><label>未结算金额：</label><span class="betting">0</span></div>
                </div>
                <div id="account2" class="accounts" style="display:none">
                    <div class="info"><label>香港彩额度：</label><span class="balance">0</span>
                    </div>
                    <div class="info"><label>未结算金额：</label><span class="betting">0</span></div>
                </div>
                <div id="account3" class="accounts" style="display:none">
                    <div class="info"><label>第三方额度：</label><span class="balance">0</span>
                    </div>
                    <div class="info"><label>未结算金额：</label><span class="betting">0</span></div>
                </div>
            </div>
        </div>

        <input type="hidden" id="userType" value="1"/>

        <div class="betdone" id="drawOfficial">
            <div class="title"><a href="{{$kfurl}}"
                                  target="_blank">开奖网</a></div>
        </div>

        <div class="betdone" id="lastBets">
            <div class="title"><span>最新注单</span></div>
            <ul class="bets">
            </ul>
        </div>
        <div style="display:none" id="betResultPanel">

            <div class="control s0">
                <a onclick="resetPanel()" href="javascript:void(0)">返 回</a>
            </div>
            <div id="betResultDrawNumber" class="Paneltitle"></div>
            <div class="bresults">
                <ul class="bets" id="betReulstList"></ul>
                <table class="total s0">
                    <tbody>
                    <tr>
                        <td class="label">下注金额</td>
                        <td id="betResultCount"></td>
                    </tr>
                    <tr>
                        <td class="label">合计金额</td>
                        <td id="betResultTotal"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="Notice"></div>
    <div class="details">
        <div class="back_body"></div>
        <div id="dtlColor" class="details_div">
            <a href="#">
                <div class="close_icon"></div>
            </a>
            <div class="details_icon">
                <div></div>
            </div>
            <div id="dtlFont" class="details_font"></div>
        </div>
    </div>

    <div id="redPack" hidden>
        <div class="back_body"></div>
        <div class="redpack_body">
            <img src="/static/default/images/close.png" onClick="$('#redPack').hide();" class="redpack_close"/>
            <div class="redpack_amt_con">
                <span class="redpack_amount">0</span>
                <span class="redpack_currency"> 元</span>
            </div>
            <div class="redpack_remark"></div>
            <!--<img src="default/images/hongbao_popup.png" />-->
        </div>
    </div>
    <div class="frame">
        <iframe id="frame" name="frame" frameborder="0"></iframe>
    </div>
</div>
<div id="footer">
    <div class="info">
        <marquee id="notices" scrollamount="2"></marquee>
    </div>
    <a href="javascript:void(0)" class="more">更多</a></div>
<div id="resultList" class="result_list" hidden>
    <div class="result_list_header">
        <span>弹窗可拖动</span>
        <div class="result_list_close" onClick="$('#resultList').hide();">&times;</div>
        <div id="resultListHeader" style="background:Gainsboro;text-align:center;font-weight: bold;"></div>
    </div>
    <div class="result_list_block"></div>
    <iframe id="resultFrame" name="resultFrame" class="result_frame" frameborder="0"></iframe>
</div>
<div id="settingbet" title="快选金额" style="display:none;">
    <input name="bet_1" placeholder="快选金额" class="ds" maxlength="9"/><br/>
    <input name="bet_2" placeholder="快选金额" class="ds" maxlength="9"/><br/>
    <input name="bet_3" placeholder="快选金额" class="ds" maxlength="9"/><br/>
    <input name="bet_4" placeholder="快选金额" class="ds" maxlength="9"/><br/>
    <input name="bet_5" placeholder="快选金额" class="ds" maxlength="9"/><br/>
    <input name="bet_6" placeholder="快选金额" class="ds" maxlength="9"/><br/>
    <input name="bet_7" placeholder="快选金额" class="ds" maxlength="9"/><br/>
    <input name="bet_8" placeholder="快选金额" class="ds" maxlength="9"/><br/>

    <label>
        <input name="settingbet" type="radio" id="settingbet_0" value="1" checked="checked"/>
        启动
    </label>
    <label>
        <input name="settingbet" type="radio" id="settingbet_1" value="0"/>
        停用
    </label>
    <br/>
    <br/>
    <input type="button" class="button" value="储存" onClick="submitsetting()"/>
</div>
<script>
    $(document).on("keydown", function (e) {
        if (e.keyCode === 13) {
            $('.Notice > div:not([style="display: none;"]) .notice_button').click();
            if ($('.Notice > div[style="display: none;"]').length === $('.Notice > div').length) {
                $(document).off("keydown");
            }
        }
    })
</script>
<div class="loading-wrapper"></div>
<div id="domainModal" style="overflow:auto">
    <div id="domainDetail" style="display: none;max-height: 350px;">
        <div class="label">当前IP：<span class="red-font label" id="currentIp"></span></div>
        <div class="red-font label">最小值速度最佳</div>
        <div class="label">当前时间：<span class="red-font label" id="serverTime"></span></div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="domainList">
            <tbody>
            </tbody>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="sampleList">
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
