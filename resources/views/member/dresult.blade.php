<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_{{$template}}.css"/>
    <link rel="stylesheet" type="text/css" href="/js/jquery/ui-lightness/jquery-ui.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript">
        function change() {
            location.href = LIBS.url({
                'lottery': $('#lottery').val(),
                'date': $('#date').val(),
                'table': $('#tb').val()
            });
        }

        $(function () {
            $('#date').change(change).datepicker();
            $('#tb').val('');
        })
    </script>
</head>
<body class="L_{{$lottery}}">
<select id="lottery" name="lottery" onchange="change()">
    @foreach($lotterys as $lot)
        <option value="{{$lot['lottery']}}" @if($lot['lottery'] == $lottery) selected @endif>{{$lot['gname']}}</option>
    @endforeach
</select>
日期：<input id="date" value="{{$date}}"/>
<form id="search-drawNumber-form" style="display: inline;">
    期数:
    <span class="search-wrapper">
        <input class="with-search" id="drawNumber" value="">
        <button class="search-btn" type="submit"></button>
    </span>
</form>
<script>
    $(".search-wrapper .search-btn").click(function (e) {
        e.preventDefault();
        var lottery = $("#lottery").val();
        var date = $("#date").val();
        var drawNumber = $("#drawNumber").val();

        location.href = LIBS.url({
            'lottery': lottery, 'date': date,
            'table': $('#tb').val(), 'drawNumber': drawNumber
        });
    });
    $(".search-drawNumber-form").submit(function (e) {
        e.preventDefault();
        var lottery = $("#lottery").val();
        var date = $("#date").val();
        var drawNumber = $("#drawNumber").val();

        location.href = LIBS.url({
            'lottery': lottery, 'date': date,
            'table': $('#tb').val(), 'drawNumber': drawNumber
        });
    });
</script>


<div id="drawTable">
    <table class="list table_ball table">
        <thead>
        <tr>
            <th>期数</th>
            <th>开奖时间</th>
            @if($fenlei == 107)
            <th colspan="10">开出号码</th>
            <th colspan="3" class="strong">冠亚军和</th>
            <th colspan="5" class="strong">1～5 龙虎</th>
            @elseif($fenlei == 101)
            <th colspan="5">开出号码</th>
            <th colspan="3" class="strong">总和</th>
            <th class="strong">龙虎</th>
            <th class="strong">前三</th>
            <th class="strong">中三</th>
            <th class="strong">後三</th>
            <th class="strong">斗牛</th>
            <th class="strong">斗牛单双</th>
            <th class="strong">斗牛大小</th>
            <th class="strong">斗牛梭哈</th>
            @elseif($fenlei == 151)
            <th colspan="3">开出骰子</th>
            <th colspan="3">鱼虾蟹</th>
            <th colspan="2" class="strong">总和</th>
            @elseif($fenlei == 121)
            <th colspan="5">开出号码</th>
            <th colspan="4" class="strong">总和</th>
            <th class="strong">龙虎</th>
            <th colspan="5" class="strong">1～5 大小</th>
            @elseif($fenlei == 103)
            <th colspan="8">开出号码</th>
            <th colspan="4" class="strong">总和</th>
            <th colspan="4" class="strong">1～4 龙虎</th>
            @elseif($fenlei == 161)
            <th colspan="20">开出号码</th>
            <th colspan="4" class="strong">总和</th>
            <th colspan="2" class="strong">比数量</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($list as $vo)
        <tr>
            <td class="period">{{$vo['drawNumber']}}</td>
            <td class="drawTime">{{$vo['drawTime']}}</td>
            @if($fenlei == 107 || $fenlei == 101 || $fenlei == 151 || $fenlei == 121 || $fenlei == 103 || $fenlei == 161)
            @foreach($vo['result'] as $o)
            <td class="name @if($fenlei==107)ballname @endif"><span class="b{{$o}}">{{$o}}</span></td>
            @endforeach
            @endif
            @if($fenlei == 107)
            <td class="other1">{{$vo['GYH']}}</td>
            <td class="other GDX_{{$vo['GDX'][1]}}">{{$vo['GDX'][0]}}</td>
            <td class="other GDS_{{$vo['GDS'][1]}}">{{$vo['GDS'][0]}}</td>
            <td class="other GLH_{{$vo['LH1'][1]}}">{{$vo['LH1'][0]}}</td>
            <td class="other GLH_{{$vo['LH2'][1]}}">{{$vo['LH2'][0]}}</td>
            <td class="other GLH_{{$vo['LH3'][1]}}">{{$vo['LH3'][0]}}</td>
            <td class="other GLH_{{$vo['LH4'][1]}}">{{$vo['LH4'][0]}}</td>
            <td class="other GLH_{{$vo['LH5'][1]}}">{{$vo['LH5'][0]}}</td>
            @elseif($fenlei == 101)
            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            <td class="other GDS_{{$vo['ZDS'][1]}}">{{$vo['ZDS'][0]}}</td>
            <td class="other GLHT_{{$vo['LH'][1]}}">{{$vo['LH'][0]}}</td>
            <td class="other1 others GTS_{{$vo['QS'][1]}}">{{$vo['QS'][0]}}</td>
            <td class="other1 others GTS_{{$vo['ZS'][1]}}">{{$vo['ZS'][0]}}</td>
            <td class="other1 others GTS_{{$vo['HS'][1]}}">{{$vo['HS'][0]}}</td>
            <td class="other1 others GDN_{{$vo['DN'][1]}}">{{$vo['DN'][0]}}</td>
            <td class="other1 others GDNDS_{{$vo['DNDS'][1]}}">{{$vo['DNDS'][0]}}</td>
            <td class="other1 others GDNDX_{{$vo['DNDX'][1]}}">{{$vo['DNDX'][0]}}</td>
            <td class="other1 others GDNSH_{{$vo['DNSH'][1]}}">{{$vo['DNSH'][0]}}</td>
            @elseif($fenlei == 151)
            <td class="other1 Gyxx{{$vo['yxxone'][1]}}">{{$vo['yxxone'][0]}}</td>
            <td class="other1 Gyxx{{$vo['yxxtwo'][1]}}">{{$vo['yxxtwo'][0]}}</td>
            <td class="other1 Gyxx{{$vo['yxxthree'][1]}}">{{$vo['yxxthree'][0]}}</td>
            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            @elseif($fenlei == 121)
                <td class="other1">{{$vo['ZH']}}</td>
                @if($vo['ZDX'][0] == '和')
                <td class="TIE">和</td>
                @else
                <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
                @endif
                @if($vo['ZDS'][0] == '和')
                    <td class="TIE">和</td>
                @else
                    <td class="other GDS_{{$vo['ZDS'][1]}}">{{$vo['ZDS'][0]}}</td>
                @endif
                <td class="other1 GWDX_{{$vo['ZWDX'][1]}}">{{$vo['ZWDX'][0]}}</td>
                <td class="other GLH_{{$vo['LH'][1]}}">{{$vo['LH'][0]}}</td>
                @foreach($vo['result'] as $key=>$val)
                    @if($val == 11)
                        <td class="TIE">和</td>
                    @else
                        <td class="other GDX_{{$vo['DX'.($key+1)][1]}}">{{$vo['DX'.($key+1)][0]}}</td>
                    @endif
                @endforeach
            @elseif($fenlei == 103)
            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            <td class="other GDS_{{$vo['ZDS'][1]}}">{{$vo['ZDS'][0]}}</td>
            <td class="other1 GWDX_{{$vo['ZWDX'][1]}}">{{$vo['ZWDX'][0]}}</td>
            <td class="other GLH_{{$vo['LH1'][1]}}">{{$vo['LH1'][0]}}</td>
            <td class="other GLH_{{$vo['LH2'][1]}}">{{$vo['LH2'][0]}}</td>
            <td class="other GLH_{{$vo['LH3'][1]}}">{{$vo['LH3'][0]}}</td>
            <td class="other GLH_{{$vo['LH4'][1]}}">{{$vo['LH4'][0]}}</td>
            @elseif($fenlei == 161)
            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            <td class="other GDS_{{$vo['ZDS'][1]}}">{{$vo['ZDS'][0]}}</td>
            <td class="other GWX_{{$vo['WX'][1]}}">{{$vo['WX'][0]}}</td>
            <td class="other2 GQHH_{{$vo['QHH'][1]}}">{{$vo['QHH'][0]}}</td>
            <td class="other2 GDSH_{{$vo['DSH'][1]}}">{{$vo['DSH'][0]}}</td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
