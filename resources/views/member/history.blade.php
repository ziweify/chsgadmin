<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript">$(function () {
            LIBS.colorMoney('.color', 'minus')
        })</script>
    <script type="text/javascript">
    function change(){
      location.href=LIBS.url({'lottery':$('#lottery').val()});
    }
  </script>
</head>
<body>
<div class="main history">
    <div class="search">
        <select id="lottery" name="lottery" onchange="change()">
            <option value="" @selected($lottery=="")>全部游戏</option>
            @foreach($lotterys as $lot)
            <option value="{{$lot['lottery']}}" @selected($lot['lottery']==$lottery)>{{$lot['gname']}}</option>
            @endforeach
        </select>
        <span class="title">两周报表</span>
    </div>
    <table class="list table">
        <thead>
        <tr>
            <th class="date">日期</th>
            <th class="count">注数</th>
            <th class="amount">下注金额</th>
            <th class="amount2">有效金额</th>
            <th class="cm">佣金</th>
            <th class="dividend">盈亏</th>
        </tr>
        </thead>
        <tbody>
        @foreach($upbao as $vo)
        <tr>
            <td clss="date"><a href="bets?date={{$vo['date']}}&lottery={{$lottery}}"> {{$vo['date']}} 星期{{$vo['week']}}</a></td>
            <td>{{$vo['zs']}}</td>
            <td class="money">{{$vo['xzje']}}</td>
            <td class="money">{{$vo['zje']}}</td>
            <td class="money">{{$vo['points']}}</td>
            <td class="result">
                <a href="bets?date={{$vo['date']}}&lottery={{$lottery}}" class="color">{{$vo['rs']}}</a></td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>上周</th>
            <td>{{$t['uzs']}}</td>
            <td class="money">{{$t['uxzje']}}</td>
            <td class="money">{{$t['uzje']}}</td>
            <td class="money">{{$t['upoints']}}</td>
            <td class="result color">{{$t['urs']}}</td>
        </tr>
        </tfoot>
    </table>
    <table class="list mt table">
        <thead>
        <tr>
            <th class="date">日期</th>
            <th class="count">注数</th>
            <th class="amount">下注金额</th>
            <th class="amount2">有效金额</th>
            <th class="cm">佣金</th>
            <th class="dividend">盈亏</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bao as $vo)
        <tr @if($vo['week'] == $cweek)class="today"@endif>
            <td class="date"><a href="bets?date={{$vo['date']}}&lottery={{$lottery}}"> {{$vo['date']}} 星期{{$vo['week']}}</a></td>
            <td>{{$vo['zs']}}</td>
            <td class="money">{{$vo['xzje']}}</td>
            <td class="money">{{$vo['zje']}}</td>
            <td class="money">{{$vo['points']}}</td>
            <td class="result">
                <a href="bets?date={{$vo['date']}}&lottery={{$lottery}}" class="color">{{$vo['rs']}}</a></td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>本周</th>
            <td>{{$t['zs']}}</td>
            <td class="money">{{$t['xzje']}}</td>
            <td class="money">{{$t['zje']}}</td>
            <td class="money">{{$t['points']}}</td>
            <td class="result color">{{$t['rs']}}</td>
        </tr>
        </tfoot>
    </table>
</div>
<style>
    .history td {
        width: 16.67%;
    }
</style>
</body>
</html>
