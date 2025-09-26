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
    <link href="/default/css/agent/warning.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/warning.js"></script>
    <script type="text/javascript">var backUrl = '';
        var SOUND_URL = '/default/css/images/kaijiang.mp3';</script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">公司（<span id="username">{{$username}}</span>）</span>
        <div class="right">
            显示最近
            <select id="keepTime">
                <option value="20">20秒</option>
                <option value="40">40秒</option>
                <option value="60" selected="selected">60秒</option>
                <option value="120">2分钟</option>
                <option value="300">5分钟</option>
                <option value="600">10分钟</option>
                <option value="1800">半小时</option>
                <option value="3600">1小时</option>
                <option value="7200">2小时</option>
            </select>
            <input id="btnRefresh" type="button" value="刷新"/>
            <span id="cdRefresh"></span>
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
</div>
<div class="contents param_panel input_panel">
    <table class="data_table warnTotal">
        <tr>
            @foreach($lotterys as $vo)
            <th>{{$vo['gname']}}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($lotterys as $vo)
                <td><a id='_{{$vo['lottery']}}' href="javascript:void(0)"
                       onclick="WarningPanel.selectLottery('{{$vo['lottery']}}','{{$vo['gname']}}')">0</a></td>
            @endforeach
        </tr>
    </table>
    <span id="curnLottery">选择分类</span>
    <select id="refreshWarn">
    </select>
    <table class="layout">
        <tr>
            <td class="data panel">
                <table class="data_table">
                    <caption>第一次金额预警</caption>
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>项目</th>
                        <th>金额</th>
                        <th>更新时间</th>
                    </tr>
                    </thead>
                </table>
            </td>
            <td class="data panel">
                <table class="data_table">
                    <caption>第二次金额预警</caption>
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>项目</th>
                        <th>金额</th>
                        <th>更新时间</th>
                    </tr>
                    </thead>
                </table>
            </td>
            <td class="data panel">
                <table class="data_table">
                    <caption>选择分类金额预警</caption>
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>项目</th>
                        <th>金额</th>
                        <th>更新时间</th>
                    </tr>
                    </thead>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
