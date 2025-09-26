<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="/default/css/agent/red/master.css" rel="stylesheet" type="text/css">
    <link href="/default/css/agent/red/layout.css" rel="stylesheet" type="text/css">
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/odds.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/quick.js"></script>
    <script type="text/javascript">
        var selectLottery = $("<select id='selectLottery'>");
        selectLottery.append($('<option>').val('').html('全选'));
        @foreach($lotterys as $lottery)
        var lot = $('<option>').val('{{$lottery['lottery']}}').html('{{$lottery['gname']}}');
        selectLottery.append(lot);
        @endforeach
    </script>

</head>
<body style="">
<div class="main">
    <div class="top_info">
        <span class="title">盘口设置</span>
    </div>

    <div class="tab-wrapper">
        <a id="quick" href="quick">彩票类</a>

    </div>
    <div class="game_tab_class">
        <ul>
            <li><a id="tab_0" href="javascript:;">快开彩</a>
            </li>
        </ul>
    </div>

    <div id="p_0" class="contents input_panel tab_panel">
        @foreach($results as $result)
        <table class="data_table list at_0" id="t_{{$result['lottery']}}" data-t="{{$result['template']}}" data-n="{{$result['gname']}}">
            <thead>
            <tr>
                <th colspan="2">种类</th>
                <th colspan="5">设置项</th>
            </tr>
            <tr class="shead">
                <th></th>
                <th></th>
                <th>赔率</th>
                <th>个人单注最低限额</th>
                <th>个人单注最高限额</th>
                <th>个人单期最高限额</th>
                <th>单期总限额</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result['list'] as $d=>$v)
            @foreach($v as $i=>$data)
            <tr data-ok="{{$data['ok']}}" @if($i==0)data-ck="{{$data['ck']}}"@endif>
                @if($i==0)<th rowspan="{{count($v)}}">{{$data['ckname']}}</th>@endif
                <td>@if($data['ckname'] != $data['plname']){{$data['plname']}}@endif<a href="javascript:showDialog('盘口设置--明细','{{$result['template']}}-{{$data['ck']}}','{{$result['lottery']}}');"></a></td>
                <td class="colA"><input name="odds" value="{{$data['pla']}}" data-init="{{$data['pla']}}"></td>
                @if($i==0)<td class="colminBetAmount" rowspan="{{count($v)}}"><input name="cm" value="{{$data['minBetAmount']}}" data-init="{{$data['minBetAmount']}}"></td>@endif
                @if($i==0)<td class="colmaxBetAmount" rowspan="{{count($v)}}"><input name="cm" value="{{$data['maxBetAmount']}}" data-init="{{$data['maxBetAmount']}}"></td>@endif
                @if($i==0)<td class="colmaxUserPeriodAmount" rowspan="{{count($v)}}"><input name="cm" value="{{$data['maxUserPeriodAmount']}}" data-init="{{$data['maxUserPeriodAmount']}}"></td>@endif
                @if($i==0)<td class="colmaxPeriodAmount" rowspan="{{count($v)}}"><input name="cm" value="{{$data['maxPeriodAmount']}}" data-init="{{$data['maxPeriodAmount']}}"></td>@endif
            </tr>
            @endforeach
            @endforeach
            </tbody>
        </table>
        @endforeach
    </div>

    <div class="data_footer control">
        <input type="button" class="button" value="保存" onclick="save(ADMIN)"> <input type="reset" class="button">
    </div>
</div>
</body>
</html>
