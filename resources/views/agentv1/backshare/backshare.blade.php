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
    <script type="text/javascript" src="/default/js/backshare.js"></script>
    <script type="text/javascript">var backUrl = '';</script>
</head>

<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$layername}}（<span id="username">{{$username}}</span>）</span>
        <span class="right">{{$layername}}名称：{{$name}}</span>
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
                                                                                class="3D">体彩排列3</a>
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
                                <th>注额</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lottery['flylist'][0] as $item)
                            <tr id="{{$lottery['lottery']}}_{{$item['class']}}">
                                <th>{{$item['name']}}</th>
                                <td><input name="flag" class="flag" value="{{$item['je']}}"/></td>
                                <td><label><input @if($item['ifok']==1)checked="checked" @endif type="radio" name="{{$lottery['lottery']}}_{{$item['class']}}.enabled" value="true"/>启用</label>
                                    <label><input @if($item['ifok']==0)checked="checked" @endif type="radio" name="{{$lottery['lottery']}}_{{$item['class']}}.enabled" value="false" />停用</label>
                                </td>
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
                                <th>注额</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lottery['flylist'][1] as $item)
                                <tr id="{{$lottery['lottery']}}_{{$item['class']}}">
                                    <th>{{$item['name']}}</th>
                                    <td><input name="flag" class="flag" value="{{$item['je']}}"/></td>
                                    <td><label><input @if($item['ifok']==1)checked="checked" @endif type="radio" name="{{$lottery['lottery']}}_{{$item['class']}}.enabled" value="true"/>启用</label>
                                        <label><input @if($item['ifok']==0)checked="checked" @endif type="radio" name="{{$lottery['lottery']}}_{{$item['class']}}.enabled" value="false" />停用</label>
                                    </td>
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
    <div id="quickSetting">快速设置： <span class="input_panel">注额：<input/></span>&nbsp;&nbsp;<label><input
        type="radio" name="set" value="true"/>启用</label><label><input type="radio" name="set" value="false"
                                                                        checked="checked"/>停用</label>&nbsp;&nbsp;<input
        type="button" value="确定"/></div>
</div>
<div class="data_footer control"><input type="button" value="保存" onclick="save()" class="button"/>
    <input type="button" value="取消" onclick="back()" class="button"/>
</div>
</body>
</html>
