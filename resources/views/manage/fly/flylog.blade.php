<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>飞单设置</title>
    <link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css"/>
    <link href="/xypone/default/css/layout.css?v=33" rel="stylesheet" type="text/css"/>
    <link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css"/>
    <script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
    <script language="javascript" src="/xypone/default/js/jquery-ui.js"></script>
    <script language="javascript">
        function changeh() {
            var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
            var h = document.body.clientHeight + 500;
            obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
        }
    </script>
    <script language="javascript" type="text/javascript"
            src="/xypone/default/js/My97DatePicker/WdatePicker.js"></script>
    <style>
        a.red {
            color: #D50000
        }
    </style>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">平台飞单日志</span><span class="right"></span>
    </div>
    <div class="contents param_panel">

        <div class="control">
            <span>{!! $page !!}</span><!--<span><input type="button" value="删除" class="button del"/><INPUT type="text"
                                                                                                   value="{$deldate}"
                                                                                                   class="deldate"
                                                                                                   style="width: 80px;"
                                                                                                   size=8/>之前</span>-->
        </div>
        <table class="data_table data_list nrtb" style="width: 100%;word-break:break-all;">
            <thead>
            <TR>
                <th><input type="checkbox" id='clickall'/>全选</th>
                <th>编号</th>
                <th>游戏</th>
                <th>期数</th>
                <th>时间</th>
                <th>盘口类型</th>
                <th>网址</th>
                <th class="data">发送数据</th>
                <th class="data">接收数据</th>
                <th><input type="button" class="btn3 btnf" id='delselect' value="删除选中"/></th>
            </TR>
            </thead>
            @foreach($l as $vo)
            <TR>
                <td><input type="checkbox" value='{{$vo['id']}}'/></td>
                <td>{{$vo['id']}}</td>
                <td>{{$vo['gname']}}</td>
                <td>{{$vo['qishu']}}</td>
                <td>{{$vo['time']}}</td>
                <td>{{$vo['webtype']}}</td>
                <td>{{$vo['url']}}</td>
                <td style="width: 300px !important;">{{$vo['sendtext']}}</td>
                <td style="width: 300px !important;">{{$vo['retext']}}</td>
                <td><input type="button" class="delone btn1 btnf" value='删除'/></td>
            </TR>
            @endforeach
        </table>
    </div>
</div>
<script language="javascript">
    var page = 'show';
</script>
<div id='test'></div>
</body>
</html>
