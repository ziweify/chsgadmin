<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css?v=1" />
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
</head>
<body>
<div class="user_info_table">
    <table class="table user_info">
        <thead><tr><th colspan="2">会员资料</th></tr></thead>
        <tbody>
        <tr><th>会员账号</th><td>{{$username}}</td></tr>
        <tr><th>会员名称</th><td>{{$name}}</td></tr>
        <tr><th>所属盘口</th><td>{{$defaultpan}} 盘</td></tr>
        <tr><th>账户状态</th><td>{{$status}}</td></tr>
        <tr><th>快开彩额度</th>
            <td>{{$kmaxmoney}} (余额:{{$kmoney}})</td></tr>
        </tbody>
    </table>
</div>
<br/>
<script language="javaScript">
    $(function() {
        //设置当前页菜单默认值
        var curLocation = location.href.split("/");
        var params = curLocation.slice(curLocation.length-1, curLocation.length).toString(String).split(".").slice(0, 1).toString(String).toLowerCase().split("?");
        if(params.length > 1){
            $('#info').addClass("active");
        }else{
            $('#infogame').addClass("active");
        }
    })
</script>
@if($lottery != '')<div>
    <div class="tab-wrapper">
        <a id="info" href="info?lottery={{$dflottery}}">彩票类</a>

    </div>
</div>    <div class="info_body">
        <div class="game_class">
            <ul>
                <li><span>快开彩</span>
                    @foreach($lotterys as $lot)
                        <a @if($lot['lottery'] == $lottery)class="selected" @endif href="info?lottery={{$lot['lottery']}}">{{$lot['gname']}}</a>
                    @endforeach
                </li>
            </ul>
        </div>
        <table class="list table data_table">
            <thead>
            <tr>
                <th>玩法</th>
                @foreach($span as $vo)
                    <th>{{$vo}}盘退水</th>
                @endforeach
                <th>单注最低</th>
                <th>单注最高</th>
                <th>单期最高</th>
            </tr>
            </thead>
            <tbody>
            @foreach($game as $vo)
                @foreach($vo['pan'] as $j)
                    <tr>
                        <td>{{$j['name']}}</td>
                        @if($j['abcd'] == 1)
                            @foreach($span as $k)
                                @if($j['ab'] == 1)
                                    <td class="cm">{{data_handler1($j,$k,1)}}/{{data_handler1($j,$k,2)}}</td>
                                @else
                                    <td class="cm">{{data_handler1($j,$k,3)}}</td>
                                @endif
                            @endforeach
                        @else
                            <td class="cm">{{$j['pointsa0']}}</td>
                        @endif
                        <td>{{$j['minje']}}</td>
                        <td>{{$j['maxje']}}</td>
                        <td>{{$j['cmaxje']}}</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@else
<div>
    <div class="tab-wrapper">
        <a id="info" href="info?lottery={{$dflottery}}">彩票类</a>

    </div>
</div>    <div class="info_body">
    <div class="game_tab"><a>棋牌</a></div>
    <table class="list table data_table">
        <thead>
        <tr>
            <th>玩法</th>
            <th>A盘退水</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>棋牌</th>
            <td class="cm">0%</td>
        </tr>
        </tbody>
    </table>
</div>
@endif
</body>
</html>
