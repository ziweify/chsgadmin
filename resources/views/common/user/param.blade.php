<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script>
        var path = '/agent/user/param/saveParam';
    </script>
    <script type="text/javascript" src="/default/js/param.js"></script>
</head>
<input id="userid" type="hidden" value="{{$userid}}">
<input id="ruid" type="hidden" value="{{$ruid}}">
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$layername}} <span>{{$username}}（{{$name}}）</span> -&gt; 退水</span>
        <span class="right">
            <input type="hidden" id="username" value="{{$username}}"/>
            <a class="back" onclick="back()">返回</a>
        </span>
    </div>
    <ul class="tab">
        <li class="tab_title02">
            <a href="/agent/user/edit?username={{$username}}">
                基本资料
            </a>
            <a href="/agent/user/param?username={{$username}}" class="selected">退水设定</a>
        </li>
    </ul>
    <div class="tab-wrapper backable-tab">
        <a id="param" href="?">彩票类</a>
    </div>
    <div class="game_tab_class">
        <a id="tab_0" href="javascript:;">快开彩</a>
        <div id="cmcontrol">赚取退水：<input  id="commission" /> <input id="btn_commission" type="button" value="确定"/></div>
        <div style="margin-left: 5px;" id="cmcontrol">批量设置：<input id="point" type="number" /> <input id="btn_point" type="button" value="确定"/></div>
    </div>
    <div id="p_0" class="contents param_panel input_panel tab_panel">
        @foreach($lotterys as $lottery)
        <table class="layout">
            <tr class="{{$lottery['template']}}">
                <td class="panel">
                    <table class="list data_table at_0">
                        <thead>
                        <tr>
                            <th>种类</th>
                            <th>退水(%)</th>
                        </tr>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="t_0">
                            <th class="color head">{{$lottery['gname']}}<input name="id" type="hidden" value="{{$lottery['gid']}}"/></th>
                            <td>
                                <div><input name="p" value="{{$lottery['point']}}" class="commission"></div>
                                <div>( <span class="data">{{$lottery['fpoint']}}</span> )</div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        @endforeach
    </div>
</div>
<div class="data_footer control">
    保存时下线是否等量增加: <input type="radio" name="downline" value="all" checked="checked"/>不增加 <input
        type="radio" name="downline" value="agent"/>只代理 <input type="radio" name="downline" value="member"/>代理和会员
    <input type="button" value="保存" onclick="saveParam()" class="button"/>
    <input type="button" value="取消" onclick="back()" class="button"/>
</div>
</body>
</html>
