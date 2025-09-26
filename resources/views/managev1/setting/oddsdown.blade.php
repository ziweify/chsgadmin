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
    <script type="text/javascript" src="/default/js/oddsdown.js"></script>
    <script>
        function tball(){
            var c = confirm("确定要同步所有用户吗？");
            if(!c){
                return false;
            }
            var username = $('#username').val();
            $.ajax({
                url:'/agent/oddsdown/tball',
                type:'post',
                dataType:'json',
                data:{username:username},
                success:function (data) {
                    alert(data.message);
                }
            })
        }
    </script>
</head>
<body style="">
<div class="main">
    <div class="top_info">
        <span class="title">降赔设置</span>
        <div class="right">
            <input type="button" value="同步所有用户" onclick="tball()">
            用户：<select id="username">
                @foreach($users as $user)
                    <option @if($user['username'] == $username)selected @endif value="{{$user['username']}}">
                        @if($user['layer'] == 0)[{{$user['username']}}]@else[{{$user['layername']}}]{{$user['username']}}({{$user['name']}})@endif
                    </option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="game_tab_class">
        <ul>
            <li>
                <a id="tab_0" href="javascript:;">快开彩</a>
            </li>
        </ul>
    </div>
    <div id="p_0" class="contents input_panel tab_panel odds_down">
        @foreach($lotterys as $lot)
        <table class="data_table list at_0" id="t_{{$lot['lottery']}}" data-t="{{$lot['template']}}" data-n="{{$lot['gname']}}" data-s="false">
            <thead>
            <tr>
                <th>玩法</th>
                <th>下注金额</th>
                <th>降赔值</th>
                <th>计算方式</th>
                <th>最低赔率</th>
                <th>最大货量</th>
                {{--<th>负值超额警示</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($lot['auto'] as $auto)
            <tr data-ok="{{$lot['lottery']}}_{{$auto['class']}}">
                <th>{{$auto['name']}}</th>
                <td class="flag"><input name="flag" value="{{$auto['addje']}}"></td>
                <td class="down"><input name="down" value="{{$auto['attpeilv']}}"></td>
                <td class="ifzc">
                    <select name="ifzc">
                        <option value="1" @if($auto['ifzc'] == 1)selected @endif>按占城</option>
                        <option value="0" @if($auto['ifzc'] == 0)selected @endif>按下注额</option>
                    </select>
                </td>
                <td class="min"><input name="minOdds" value="{{$auto['lowpeilv']}}"></td>
                <td class="maxFlag"><input name="maxFlag" value="{{$auto['stopje']}}"></td>
                {{--<td class="showFlag"><input name="showFlag" value="2147483647"></td>--}}
            </tr>
            @endforeach
            </tbody>
        </table>
        @endforeach
    </div>
    <div class="data_footer control">
        <input type="button" class="button" value="保存" onclick="save()">
        <input type="reset" class="button" value="重置">
    </div>
</div>
<script>

    //$(".list.data_table.at_0").children("tbody").children("tr").each(function () {
    // var id=$(this).attr('data-ok');

    //var trList = $(this).children("td").eq(0);
    //$(this).find("input[name^='flag']").attr("value",'<=$cm["'+id+'"]["flag"]?>');
    //	$(this).find("input[name^='down']").attr("value",'<=$cm["'+id+'"]["down"]?>');
    //	$(this).find("input[name^='minOdds']").attr("value",'<=$cm["'+id+'"]["minOdds"]?>');
    //$(this).find("input[name^='maxFlag']").attr("value",'<=$cm["'+id+'"]["maxFlag"]?>');
    ///  $(this).find("input[name^='showFlag']").attr("value",'<=$cm["'+id+'"]["showFlag"]?>');

    //	});

</script>

</body>
</html>
