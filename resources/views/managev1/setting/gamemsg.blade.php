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
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">
            默认消息
            <select name="gid">
            @foreach($lotterys as $lot)
                    <option @selected($lot['gid'] == $gid) value="{{$lot['gid']}}">{{$lot['gname']}}</option>
                @endforeach
        </select>
        </span>
        <span class="setting"></span>
    </div>
    <div class="contents">
        <table class="data_table list">
            <thead>
            <tr>
                <th>消息名称</th>
                <th>消息内容</th>
                <th>消息时间</th>
                <th>说明</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $vo)
            <tr>
                <td align="center">{{$vo['msg_name']}}<input type="hidden" name="keyname" value="{{$vo['keyname']}}" /></td>
                <td><textarea name="msg_content" style="width: 100%" rows='8' cols="50">{{$vo['msg_content']}}</textarea></td>
                <td>
                    @if($vo['is_time'] == 1)
                    距封盘<input type="number" name="msg_time" value="{{$vo['msg_time']}}" />秒
                    @endif
                </td>
                <td><textarea name="remark" style="width: 100%" rows='8' cols="50">{{$vo['remark']}}</textarea></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="data_footer control">
        <input type="button" class="button" value="保存" onclick="save()">
        <!--是否同步所有彩种 checkbox -->
        <input type="checkbox" id="tball">同步所有彩种
    </div>
</div>
<script>
    var gid = {{$gid}};
    //gid改变重新加载页面
    $('select[name="gid"]').change(function(){
        window.location.href = '/agent/gamemsg?gid=' + $(this).val();
    });
    //修改
    function save() {
        var data = [];
        $(".data_table tbody tr").each(function () {
            var keyname = $(this).find("input[name='keyname']").val();
            var msg_content = $(this).find("textarea[name='msg_content']").val();
            var remark = $(this).find("textarea[name='remark']").val();
            var msg_time = $(this).find("input[name='msg_time']").val();
            msg_time ? msg_time = parseInt(msg_time) : msg_time = 0;
            data.push({keyname: keyname, msg_content: msg_content, msg_time: msg_time, remark: remark});
        });
        //是否选中同步所有彩种
        var tball = $('#tball').is(':checked');
        tball = tball ? 1 : 0;
        $.ajax({
            url: '/agent/savegamemsg',
            type: 'post',
            data: {
                gid: gid,
                data: JSON.stringify(data),
                tball:tball
            },
            success: function (data) {
                alert(data.message);
                //重新加载
                window.location.reload();
            }
        });
    }
</script>
</body>
</html>
