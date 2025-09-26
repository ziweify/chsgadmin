<!doctype html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>滚单</title>
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
    <script type="text/javascript" src="/frame/layui/layui.js"></script>
    <!-- jQuery -->
    <link rel="stylesheet" type="text/css" href="/frame/layui/css/layui.css" media="all">
    <link rel="stylesheet" type="text/css" href="/frame/css//style.css" media="all">
    <script type="text/javascript" charset="utf8" src="/frame/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/frame/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".page-jump input").on("keydown", function (e) {
                if (e.keyCode === 13) {
                    e.stopPropagation();
                    $(this).blur();
                    if ($(this).val() <= 0 || $(this).parent().data("total-page") < $(this).val()) {
                        alert("页面不存在");
                        return;
                    } else {
                        var navigatePage = $(this).parent().data("page-url").replace("page=1", "page=" + $(this).val());
                        location.href = location.origin + location.pathname + navigatePage;
                    }
                }
            })
        })

    </script>
    <link href="/default/css/agent/bets.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/betExtra.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/bets.js"></script>
    <script type="text/javascript" src="/default/js/betExtra.js"></script>

    <style type="text/css">
        .posting {
            position: fixed;
            _position: absolute;
            z-index: 9000;
            top: 50%;
            left: 50%;
            margin: 0px 0 0 -201px;
            width: 400px;
            height: 28px;
            line-height: 28px;
            border: 1px solid #DDD;
            text-align: center;
            font-size: 14px;
            background: url("/Contents/images/m/t-title.png") repeat-x scroll 0% 0%;
            overflow: hidden;
            font-weight: bold;
            color: #304852;
            display: none;
        }

        #overlay {
            position: fixed;
            _position: absolute;
            z-index: 8000;
            overflow: hidden;
            display: none;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            background-color: #000;
            filter: alpha(opacity=50);
            opacity: 0.75;
        }

    </style>
    <script type="text/javascript">
        layui.use(['form', 'upload', 'jquery'], function () {
            var $ = layui.jquery,
                form = layui.form;
            // 子页面添加选项卡

        });
    </script>
    <script type="text/javascript">
        var lastId = '';
        var lastcount = 0;
        var gid = '{{$gid}}';
        var timer, leave = 0;

        function getmingxi(id) {
            var url = "shares?bid=" + id;

            layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.7,
                fixed: false, //不固定
                maxmin: true,
                area: ['560px', '400px'],
                skin: 'layui-layer-rim', //加上边框
                content: [url, 'no']
            });

            /*
                    var a = $("#shares");
                    if (a.length == 0) {
                        a = $('<div id="shares">').addClass("popdiv");
                        a.dialog({
                            autoOpen: false,
                            width: 300,
                            maxHeight: 400
                        })
                    }
                    var b = $(this).attr("bid");
                    a.dialog("option", {
                        title: b + "# 占成明细"
                    });
                    a.empty();
                    a.append('<span class="loading">载入中……</span>').load(url, {
                        bid: b
                    });*/


        }

        function change() {
            location.href = 'real?type=' + $('#lottery option:selected').val();

        }

        $(function () {
            $("#skip").bind('change', function () {
                console.log($("#skip").val());
                if (isNaN($("#skip").val())) {
                    $("#skip").val("0");
                } else {
                    $("#myTable tbody tr").remove();
                    leave = 0;
                }
            });

            $("#reloadTime").bind("change", function () {
                $("#myTable tbody tr").remove();
                leave = 0;
            });

            timer = setInterval(checkTimer, 1000);
        });

        function checkTimer() {
            if (leave-- <= 0) {
                clearInterval(timer);
                $("#tips").text("(...)");
                loadData();
            } else {
                $("#tips").text("(" + (leave + 1) + "秒)");
            }
        }

        function loadData() {
            $.post('real?type=', {gid: gid, skip: $("#skip").val(), last: lastId, uid: '',lastcount:lastcount}, function (resp) {
                if (resp.success && resp.total > 0) {
                    var t = resp.type;
                    var row = "";
                    $('#myTable tbody').html('');
                    for (var i = resp.rows.length - 1; i >= 0; i--) {
                        var o = resp.rows[i];
                        //console.log(o.g_orderid);
                        row = "<tr><td>" + o.g_orderid + " </td><td>" + o.g_date + '</td><td class="period">' + o.cztype + '<div class="drawNumber1">' + o.g_qishu + '</div></td><td>' + o.g_name + '<div>' + o.g_panlu + '盘</div></td><td>' + o.mingxi + '</td><td class="money">' + o.g_jiner + '</td><td class="commission">' + o.g_tueishui + '</td><td class="money dividend color">' + o.g_win + '</td><td class="share">' + o.zc + '</td></tr>';
                        $('#myTable tbody').prepend(row);
                        if (i == 0) {
                            lastId = o.g_id;
                            lastcount = resp.total;
                        }
                    }
                }
                ////<td class="detail"><a onclick="getmingxi('+"'"+o.g_orderid+"'"+')">明细</a></td>
                leave = parseInt($("#reloadTime").val());
                timer = setInterval(checkTimer, 1000);
            }, 'json');
        }
    </script>

    <script type="text/javascript">
        var stylename = 'green';

        function showpostmsg() {
            $(".posting").show();
        }

        function showpostmsg1() {
            $("#overlay").show();
            $(".posting").show();
        }

        function hidepostmsg1() {
            $("#overlay").hide();
            $(".posting").hide();
        }
    </script>
</head>
<body style="background:#fefdfb">

<div class="fixWidth">
    <div class="main">
        <div class="top_info"><span class="ico"></span> 實時滾單</div>
        <div class="panel-toolbar">
            <span>注額高於</span>
            <input class="txt" id="skip" type="text" value="0" style="width:50px"/>
            <span>的注單滾入本列表</span>
            <span>|</span>
            <span>彩种</span>
            <select id="lottery" name="lottery" onchange="change()">
                <option value="">全部</option>
                @foreach($lotterys as $vo)
                    <option @if($vo['gid'] == $gid)selected @endif value="{{$vo['gid']}}">{{$vo['gname']}}</option>
                @endforeach
            </select>
            <span>更新頻率：</span>
            <select id="reloadTime" style="width:45px;">
                <option value="2">2秒</option>
                <option value="5" selected>5秒</option>
                <option value="10">10秒</option>
                <option value="30">30秒</option>
                <option value="60">60秒</option>
            </select>
            <span id="tips" class="cBlue"></span>
        </div>
        <div class="panel-content">
            <table id="myTable" class="data_table list">
                <thead>
                <tr>
                    <th class="th-box">注单号
                    </th>
                    <th>投注时间</th>
                    <th class="type th-box">投注种类
                    </th>
                    <th>账号</th>
                    <th>投注内容</th>
                    <th>下注金额</th>
                    <th>退水</th>
                    <th>可赢</th>
                    <th>本级占成</th>

                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="betExtraDialog"></div>

<div id="overlay">
    <div id="shares">
    </div>
</body>
</html>
