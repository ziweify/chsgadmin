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
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/info.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">用户资料</span>
    </div>
    <div class="contents">
        <table class="data_table user_info">
            <thead>
            <tr>
                <th colspan="2">基本信息</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>账号</th>
                <td>{{$username}}</td>
            </tr>
            <tr>
                <th>快开彩额度</th>
                <td>{{$fudong==0?$kmaxmoney : 0}} (余额:{{$kmoney}})</td>
            </tr>
            </tbody>
        </table>
        <br/>
        <script language="javaScript">
            $(function () {
                //设置当前页菜单默认值
                var curLocation = location.href.split("/");
                var params = curLocation.slice(curLocation.length - 1, curLocation.length).toString(String).split(".").slice(0, 1).toString(String).toLowerCase().split("?");
                if (params.length > 1) {
                    $('#info').addClass("active");
                } else {
                    $('#infogame').addClass("active");
                }
            })
        </script>
        <div>
            <div class="tab-wrapper">
                <a id="info" href="info?lottery={{$lottery}}">彩票类</a>
            </div>
        </div>
        <div class="info_body">
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
                            <th>{{$j['name']}}</th>
                            @if($j['abcd'] == 1)
                                @foreach($span as $k)
                                    @if($j['ab'] == 1)
                                        <td class="cm">{{data_handler1($j,$k,1)}}/{{data_handler1($j,$k,2)}}%</td>
                                    @else
                                        <td class="cm">{{data_handler1($j,$k,3)}}%</td>
                                    @endif
                                @endforeach
                            @else
                                <td class="cm">{{$j['pointsa0']}}%</td>
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
    </div>
</div>
</body>
</html>
