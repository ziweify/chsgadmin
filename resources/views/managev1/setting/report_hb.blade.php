<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/static/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/sweetalert.min.js"></script>
    <link href="/static/default/css/agent/report.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/report.js?v=2"></script>

    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/user.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-timepicker-addon.min.js"></script>
    <script type="text/javascript">
        var TODAY ={{$today}};
        function cleartax(){
            var sdate = $("#begin").val();
            var edate = $("#end").val();
            var username = $("#username").val();
            if(username==''){
                alert('请输入账号');
                return false;
            }
            //再次确认是否清理
            var c = confirm('是否清理赚点？');
            if(!c){
                return false;
            }
            //ajax
            $.ajax({
                type: "POST",
                url: "/agent/cleartax",
                data: "username="+username+"&sdate="+sdate+"&edate="+edate,
                success: function(res){
                    if(res.success){
                        querytax();
                    }else{
                        alert(res.message);
                    }
                }
            });
        }
        function querytax(){
            var sdate = $("#begin").val();
            var edate = $("#end").val();
            var username = $("#username").val();
            if(username==''){
                alert('请输入账号');
                return false;
            }
            //ajax
            $.ajax({
                type: "GET",
                url: "/agent/querytax",
                data: "username="+username+"&sdate="+sdate+"&edate="+edate,
                success: function(res){
                    if(res.success){
                        $("#tax").html(res.data.totaltax);
                    }else{
                        alert(res.message);
                    }
                }
            });
        }

        function clearallreport(){
            //再次确认是否清理
            var c = confirm('是否清理所有报表？');
            if(!c){
                return false;
            }
            //ajax
            $.ajax({
                type: "POST",
                url: "/agent/clearallreport",
                data: {},
                success: function(res){
                    window.location.reload();
                }
            });
        }

        function createallreport(){
            //再次确认是否清理
            var c = confirm('是否创建所有报表？');
            if(!c){
                return false;
            }
            //ajax
            $.ajax({
                type: "POST",
                url: "/agent/createallreport",
                data: {},
                success: function(res){
                    window.location.reload();
                }
            });
        }
        function clearallorder(){
            var username = $("#clearusername").val();
            var days = $("#days").val();
            var c = confirm('是否确认清理'+username+'所有注单？');
            if(!c){
                return false;
            }
            var cc = confirm('再次确认是否清理'+username+'所有注单？');
            if(!cc){
                return false;
            }
            $.ajax({
                type: "POST",
                url: "/agent/clearallorderbyusername",
                data: {username:username,days:days},
                success: function(res){
                    alert(res.message);
                }
            });
        }
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">公司 -> 报表合并</span>

        {{--<div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>--}}
    </div>
    <form id="search_form" action="list">
        <div class="contents">
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">清理赚点</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">日期范围</td>
                    <td>
            <span id="date"><input id="begin" value="{{$sdate[10]}}"/> — <input
                    id="end" value="{{$sdate[10]}}"/></span>
                        <input type="button" class="btn today" value="今天" onclick="dt.day(0);loadPeriod();"/>
                        <input type="button" class="btn" value="昨天" onclick="dt.day(-1);loadPeriod();"/>
                        <input type="button" class="btn" value="本星期" onclick="dt.week(0);loadPeriod();"/>
                        <input type="button" class="btn" value="上星期" onclick="dt.week(-1);loadPeriod();"/>
                        <input type="button" class="btn" value="本月" onclick="dt.month(0);loadPeriod();"/>
                        <input type="button" class="btn" value="上月" onclick="dt.month(-1);loadPeriod();"/>

                        <input type="text" id="username" name="username" value="" placeholder="请输入账号"
                               class="input w-2"/>
                        <input type="button" class="btn" value="查询赚点" onclick="querytax();"/>
                        <input type="button" class="btn" value="清理赚点" onclick="cleartax();"/>
                        <span>赚点：<span id="tax"></span></span>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">会员下单数据全清理</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">会员账号</td>
                    <td>
                        天数：<input type="text" id="days" name="days" value="0" class="input w-2"/>
                    账号：<input type="text" id="clearusername" name="clearusername" value="" placeholder="请输入账号" class="input w-2"/>
                    <input type="button" class="btn" value="清理" onclick="clearallorder();"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
    <form action="list1">
        <div class="contents">
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">功能选择</td>
                    <td>
                        <input type="button" class="btn" value="清理所有报表" onclick="clearallreport();"/>
                        <input type="button" class="btn" value="生成所有报表" onclick="createallreport();"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
    <div class="contents">
        <div class="user_list">
            <table class="data_table list">
                <thead>
                <tr>
                    <th>报表文件</th>
                    <th>注单笔数</th>
                    <th>未结笔数</th>
                    <th>和局笔数</th>
                    <th>报表笔数</th>
                    <th>备注</th>
                    <th>下载</th>
                    <th>重新合并</th>
                </tr>
                </thead>
                <tbody>

                @foreach($list as $vo)
                <tr class="Ball_tr_H" onmouseout="this.style.backgroundColor=''"
                    onmouseover="this.style.backgroundColor='#FFFFA2'">
                    <td>{{$vo['bfb']}}</td>
                    <td>{{$vo['order_count']}}</td>
                    <td>{{$vo['wjscount']}}</td>
                    <td>{{$vo['hecount']}}</td>
                    <td>{{$vo['report_count']}}</td>
                    <td>{{$vo['bf']}}</td>
                    <td>{{$vo['str']}}</td>
                    <td class="t_list_caption" width="200">
                        <a href="#" onclick="javascript:location.href='report_hb?date={{$vo['date']}}&act=cxhb'">重新合并</a>
                        <a href="#" onclick="javascript:location.href='report_hb?date={{$vo['date']}}&act=qkhb'">清空合并</a>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td>報表備份只保畱{{$autodelothertime}}天。</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
</body>
</html>
