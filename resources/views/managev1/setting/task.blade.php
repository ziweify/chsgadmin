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
        //日期改变时，重新加载数据
        function datechange(){
            var date = $("#begin").val();
            window.location.href = "task_list?date="+date;
        }
        //重新执行任务
        function once_tack(date,en){
            var c = confirm('是否重新执行任务？');
            if(!c){
                return false;
            }
            $.ajax({
                type: "POST",
                url: "/agent/once_tack",
                loading: !0,
                data: {date:date,taskname:en},
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
        <span class="title">公司 -> 任务列表</span>

        {{--<div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>--}}
    </div>
    <form id="search_form" action="list">
        <div class="contents">
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">查询条件</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">日期范围</td>
                    <td>
            <span id="date"><input onchange="datechange()" id="begin" value="{{$date}}"/></span>
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
                    <th>序号</th>
                    <th>任务名称</th>
                    <th>任务日期</th>
                    <th>任务状态</th>
                    <th>执行耗时</th>
                    <th>完成时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>

                @foreach($list as $vo)
                <tr class="Ball_tr_H" onmouseout="this.style.backgroundColor=''"
                    onmouseover="this.style.backgroundColor='#FFFFA2'">
                    <td>{{$vo['id']}}</td>
                    <td>{{$vo['name']}}</td>
                    <td>{{$vo['date']}}</td>
                    <td>{!! $vo['status'] !!}</td>
                    <td>{{$vo['time']}}</td>
                    <td>{{$vo['oktime']}}</td>
                    <td class="t_list_caption" width="200">
                        <a href="#" onclick="once_tack('{{$vo['date']}}','{{$vo['en']}}')">重新执行</a>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
