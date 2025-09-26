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
    <link href="/default/css/agent/backshare.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/warnSetting.js"></script>
    <script type="text/javascript">var backUrl = '';</script>
</head>

<body>
<div class="main">
    <div class="top_info">
        <span class="title">公司（<span id="username">{{$username}}</span>）</span>
        <span class="right">公司名称：{{$name}}</span>
    </div>
    <div class="contents param_panel input_panel">
        <div class="game_class">
            <ul>
                <li><span>快开彩</span>
                    @foreach($lotterys as $lottery)
                    <a id="tab_{{$lottery['lottery']}}" href="javascript:;" class="{{$lottery['template']}}">{{$lottery['gname']}}</a>
                    @endforeach
                </li>
            </ul>
            {{--<ul>
                <li><span>全国彩</span>
                    <a id="tab_F3D" href="javascript:;" class="3D">福彩3D</a><a id="tab_PL3" href="javascript:;"
                </li>
            </ul>
            <ul>
                <li><span>香港彩</span>
                    <a id="tab_HK6" href="javascript:;" class="HK6">香港六合彩</a><a id="tab_TWDLT" href="javascript:;"
                                                                                     class="HK6">台湾大乐透</a><a
                        id="tab_MO6" href="javascript:;" class="HK6">澳门六合彩</a>
                </li>
            </ul>--}}
        </div>
        @foreach($lotterys as $lottery)
        <div id="p_{{$lottery['lottery']}}" class="tab_panel {{$lottery['template']}}">
            <table class="layout">
                <tr>
                    <td class="panel">
                        <table class="list data_table at_0">
                            <thead>
                            <tr>
                                <th>种类</th>
                                <th>第一次金额警示</th>
                                <th>增加此金额循环警示</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lottery['warnlist'][0] as $item)
                            <tr id="{{$lottery['lottery']}}_{{$item['class']}}">
                                <th>{{$item['name']}}</th>
                                <td><input name="warnAmount" class="warnAmount" value="{{$item['firstje']}}"/></td>
                                <td><input name="warnLoop" class="warnLoop" value="{{$item['je']}}"/></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td class="panel">
                        <table class="list data_table at_0">
                            <thead>
                            <tr>
                                <th>种类</th>
                                <th>第一次金额警示</th>
                                <th>增加此金额循环警示</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lottery['warnlist'][0] as $item)
                                <tr id="{{$lottery['lottery']}}_{{$item['class']}}">
                                    <th>{{$item['name']}}</th>
                                    <td><input name="warnAmount" class="warnAmount" value="{{$item['firstje']}}"/></td>
                                    <td><input name="warnLoop" class="warnLoop" value="{{$item['je']}}"/></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        @endforeach
        <p></p>
    </div>
    <div id="quickSetting">快速设置： <span class="input_panel">第一次金额警示：<input/></span>&nbsp;&nbsp;<span
            class="input_panel">增加此金额循环警示：<input/></span><input type="button" value="确定"/></div>
</div>
<div class="data_footer control"><input type="button" value="保存" onclick="save()" class="button"/>
    <input type="button" value="取消" onclick="back()" class="button"/>
</div>
</body>
</html>
