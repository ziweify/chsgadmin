<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>彩种管理</title>
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
    <script type="text/javascript" src="/default/js/lotterys.js?v1"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">彩种管理</span>
        <span class="setting">
</span>
    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th>种类</th>
                <th>ID</th>
                <th>名称</th>
                <th>当前期数</th>
                <th>开盘时间</th>
                <th>设置封盘时间</th>
                <th>系统封盘时间</th>
                <th>开奖时间</th>
                <th>已结期数</th>
                <th>状态</th>
                <th>封盘时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lotterys as $vo)
            <tr>
                <td>快开彩</td>
                <td>{{$vo['lottery']}}</td>
                <td>{{$vo['gname']}}</td>
                <td>{{$vo['thisqishu']}}</td>
                <td>{{$vo['opentime']}}</td>
                <td @if($vo['myclosetime'] != $vo['closetime'])style="color:red"@endif>{{$vo['myclosetime']}}</td>
                <td>{{$vo['closetime']}}</td>
                <td>{{$vo['kjtime']}}</td>
                <td>{{$vo['jsqishu']}}</td>
                <td class="pause{{$vo['pause']}}">@if($vo['pause'] == 1)暂停@else正常@endif</td>
                <td>
                    <input style="width: 50px;" type="text" class="userclosetime uc{{$vo['gid']}}" value="{{$vo['userclosetime']}}">+<span class="closetime">{{$vo['closetime']}}</span>=<span class="closepant">{{$vo['closepant']}}</span>
                </td>
                <td>
                    <a onclick="modify({{$vo['gid']}})">修改</a>
                    <a onclick="savePause2('{{$vo['gname']}}','{{$vo['lottery']}}',{{$vo['pause']}})">设置</a>
                    {{--<a onclick="savePause_tm('幸运飞艇','XYFT',0)">时间设置</a>--}}
                    <a class="pause0" onclick="savePause('{{$username}}','{{$vo['lottery']}}',{{!$vo['pause']}})">@if($vo['pause'] == 0)暂停@else正常@endif</a>
                    {{--<a href="/agent/lotterys/logs?type=1" class="pause0">开奖记录</a>--}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    //当userclosetime改变时，计算closepant,并显示closepant=userclosetime+closetime
    $('.userclosetime').change(function () {
        var userclosetime = $(this).val();
        var closetime = $(this).parent().find('.closetime').html();
        var closepant = parseInt(userclosetime) + parseInt(closetime);
        $(this).parent().find('.closepant').html(closepant);
    });
    //修改
    function modify(gid) {
        var userclosetime = $('.uc'+gid).val();
        $.ajax({
            url: '/agent/lotterys/modifyfptime',
            type: 'post',
            data: {
                gid: gid,
                userclosetime: userclosetime
            },
            success: function (data) {
                alert(data.message);
            }
        });
    }
</script>
</body>
</html>
