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
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/static/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/static/js/libs.js?v=1"></script>
    <script type="text/javascript" src="/static/js/json2.js"></script>
    <script type="text/javascript" src="/static/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/tax.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/static/js/json2.js"></script>
    <script>
        var tax_name = '{{$tax_name}}';
    </script>
    <script type="text/javascript" src="/default/js/tax.js?v=1"></script>
</head>
<!--
-->
<body class="tax_param">
<div class="main">
    <div class="top_info">
			<span class="title">会员 <span>{{$username}}（{{$name}}）</span> -&gt; 赚点设置
		</span>
        <span class="right"><input type="hidden" id="username" value="{{$username}}"/><input type="hidden" id="userid" value="{{$uid}}"/><a class="back" onclick="back()">返回</a></span>
    </div>
    <div class="quick_panel">
        <div class="game_tab"><a>快速设置</a></div>
        <table class="data_table">
            <thead>
            <tr>
                <th><input type="checkbox" checked name="all"/></th>
                <th><label><input type="checkbox" checked name="value" value="BALL"/>号码类</label></th>
                <th><label><input type="checkbox" checked name="value" value="LM"/>两面类</label></th>
                <th><label><input type="checkbox" checked name="value" value="ITEM"/>多项类</label></th>
                <th><label><input type="checkbox" checked name="value" value="MP"/>连码类</label></th>
                <th><label><input type="checkbox" checked name="value" value=""/>其它</label></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th><label><input type="checkbox" checked name="account" value="0"/>快开彩</label></th>
                <td class="color t_BALL">
                    <input type="checkbox" checked value="BALL" account="0" title="球号、车号、正码等"/>
                </td>
                <td class="color t_LM">
                    <input type="checkbox" checked value="LM" account="0" title="大小、单双、龙虎、三军等"/>
                </td>
                <td class="color t_ITEM">
                    <input type="checkbox" checked value="ITEM" account="0" title="方位、中发白、总和过关等"/>
                </td>
                <td class="color t_MP">
                    <input type="checkbox" checked value="MP" account="0" title="任选二、任选三、前二组选等"/>
                </td>
                <td class="color t_">
                    <input type="checkbox" checked value="" account="0" title="冠亚和、前中后三等"/>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" class="control">
                    <span>快速设置点数：<input id="quickTax" class="tax" value="0"/></span>
                    <button id="quickButton">设置</button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="data_panel">
        @foreach($lotterys as $lot)
            <div class="game_tab"><a>{{$lot['gname']}}</a></div>
            <table class="data_table at_0">
                <thead>
                <tr>
                    <th>种类</th>
                    <th>{{$tax_name}}</th>
                    <th>种类</th>
                    <th>{{$tax_name}}</th>
                    <th>种类</th>
                    <th>{{$tax_name}}</th>
                    <th>种类</th>
                    <th>{{$tax_name}}</th>
                    <th>种类</th>
                    <th>{{$tax_name}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lot['taxlist'] as $row)
                    <tr>
                        @foreach($row as $val)
                            <th>{{$val['ckname']}}</th>
                            <td class="color t_{{$val['k']}}"><input class="tax" name="{{$lot['lottery']}}_{{$val['ck']}}" value="{{$val['tax']}}"/></td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
</div>
<div class="data_footer control">
    @if($taxtemplatename != '')<span class="cur_tpl">当前使用模板：{{$taxtemplatename}}</span>@endif
    <input type="button" value="保存" onclick="saveParam()" class="button"/>
    <input type="button" value="取消" onclick="back()" class="button"/>
</div>
</body>
</html>
