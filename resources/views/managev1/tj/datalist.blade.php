<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/default/css/agent/result.css"/>
    <link rel="stylesheet" type="text/css" href="/default/css/g_PK10.css"/>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <style>
        #drawInfo tbody tr td {
            text-align: center;
            padding: 3px;
        }
    </style>
</head>
<body class="L_JSSC">

<div class="main">
    <div class="top_info">
        <span class="title">多时段统计</span>
        <span class="right">
            日期：
            <span id="date"><input id="begin" value="{{$sdate[10]}} 07:00:00"/></span>
            彩种：
            <select id="gid" name="gid">
                <option value="">全部</option>
                @foreach($lotterys as $lottery)
                    <option value="{{$lottery['gid']}}">{{$lottery['gname']}}</option>
                @endforeach
            </select>
            显示多少段：
            <input type="text" id="duoshiduan" name="duoshiduan" value="10" style="width: 50px;">
            一段多少分钟：
            <select id="mutiue" name="mutiue">
                <option value="5">5分钟</option>
                <option value="10">10分钟</option>
                <option value="15">15分钟</option>
                <option value="20">20分钟</option>
                <option selected value="30">30分钟</option>
                <option value="40">40分钟</option>
                <option value="50">50分钟</option>
                <option value="60">1小时</option>
                <option value="120">2小时</option>
                <option value="180">3小时</option>
                <option value="240">4小时</option>
            </select>
            <input type="button" value="查询" onclick="loaddata()">
        </span>
    </div>
    <div style="font-size: 20px;text-align: center;font-weight: bold;margin:10px 0;">
        <span>总金额：<span id="totalje">0</span></span>
        <span style="margin-left: 20px;">总盈亏：<span id="totalyk">0</span></span>
    </div>
    <div id="drawInfo" class="contents">
        <table class="list data_table table_ball" style="width: 450px;">
            <thead>
            <tr>
                <th>序号</th>
                <th>分段时间</th>
                <th>下注金额</th>
                <th>盈亏结果</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    function loaddata(){
        var date = $('#begin').val();
        var gid = $('#gid').val();
        var duoshiduan = $('#duoshiduan').val();
        var mutiue = $('#mutiue').val();
        $.ajax({
            url: '/agent/tj/datalistdata',
            type: 'POST',
            dataType: 'json',
            data: {
                gid: gid,
                duoshiduan: duoshiduan,
                mutiue: mutiue,
                date: date
            },
            loading: !0,
            success: function (data) {
                var totalje = data.totalje;
                var totalyk = data.totalyk;
                var hulv = data.hulv;
                var data = data.list;
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    //盈亏小于0红色
                    var color = data[i].yk < 0 ? 'red' : 'green';
                    html += '<tr>';
                    html += '<td>' + data[i].i + '</td>';
                    html += '<td>' + data[i].showdate + '</td>';
                    html += '<td>' + data[i].je + '</td>';
                    html += '<td style="color:' + color + '">' + data[i].yk + '</td>';
                    html += '</tr>';
                }
                $('#drawInfo tbody').html(html);
                //总金额
                $('#totalje').text(totalje);
                //总盈亏
                $('#totalyk').text(totalyk);
                //总忽略
                //$('#hulv').text(hulv);
                //总盈亏颜色
                var color = totalyk < 0 ? 'red' : 'green';
                $('#totalyk').css('color', color);
            }
        });
    }
</script>
</body>
</html>
