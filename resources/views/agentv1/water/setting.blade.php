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
        function clearwater(){
            var sdate = $("#begin").val();
            var edate = $("#end").val();
            var username = $("#username").val();
            var mode = $("select[name='water_clear_mode']").val();
            var gid = $("select[name='gid']").val();
            var qishu = $("input[name='qishu']").val();
            if(username==''){
                alert('请输入账号');
                return false;
            }
            //再次确认是否清理
            var c = confirm('是否清理？');
            if(!c){
                return false;
            }
            //ajax
            $.ajax({
                type: "POST",
                url: "/agent/water/clearwaterbywhere",
                data: {username:username,sdate:sdate,edate:edate,mode:mode,qishu:qishu,gid:gid},
                success: function(res){
                    if(res.success){
                        alert(res.message);
                        querywater();
                    }else{
                        alert(res.message);
                    }
                }
            });
        }
        function querywater(){
            var sdate = $("#begin").val();
            var edate = $("#end").val();
            var username = $("#username").val();
            var water_clear_mode = $("select[name='water_clear_mode']").val();
            var qishu = $("input[name='qishu']").val();
            var gid = $("select[name='gid']").val();
            if(username==''){
                alert('请输入账号');
                return false;
            }
            //ajax
            $.ajax({
                type: "GET",
                url: "/agent/water/querywater",
                data: {username:username,sdate:sdate,edate:edate,mode:water_clear_mode,qishu:qishu,gid:gid},
                success: function(res){
                    if(res.success){
                        $("#water").html(res.data.totalwater);
                    }else{
                        alert(res.message);
                    }
                }
            });
        }
        //select water_clear_mode切换的时候显示
        //文档加载完成后执行
        $(function(){
            $("select[name='water_clear_mode']").change(function(){
                var water_clear_mode = $(this).val();
                if(water_clear_mode==1){
                    $("#watertype2").hide();
                    //$("#date").show();
                }else{
                    $("#watertype2").show();
                    //$("#date").hide();
                }
            });
        });

        function saveothersetting(){
            var dfwatertemplateid = $("select[name='dfwatertemplateid']").val();
            var dfwaterstatus = $("select[name='dfwaterstatus']").val();
            $.ajax({
                type: "POST",
                url: "/agent/water/saveothersetting",
                data: {dfwatertemplateid:dfwatertemplateid,dfwaterstatus:dfwaterstatus},
                success: function(res){
                    alert(res.message);
                }
            });
        }

        function yijiansetting(type,param){
            var online = $("select[name='online']").val();
            $.ajax({
                url: "/agent/water/yijiansetting",
                method: "POST",
                /*contentType: "application/json",*/
                data: {type:type,param:param,online:online},
                loading: true,
                success: function(g) {

                }
            })
        }
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$water_name}}设置</span>
    </div>
    <form id="search_form" action="list">
        <div class="contents">
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">清理{{$water_name}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">条件</td>
                    <td>
                        清理模式：
                        <select name="water_clear_mode">
                            <option value="1">当天</option>
                            <option value="2">期数</option>
                        </select>
                        <span id="watertype2" style="display: none;">
                        彩种：
                        <select name="gid">
                            @foreach($lotterys as $lot)
                            <option value="{{$lot->gid}}">{{$lot->gname}}</option>
                            @endforeach
                        </select>
                        期数：<input type="text" name="qishu" value="" placeholder="请输入期数" class="input w-2"/>
                            </span>
                    <span id="date" style="display: none;">
                    <input id="begin" value="{{$sdate[10]}}"/> — <input id="end" value="{{$sdate[10]}}"/>
                        <input type="button" class="btn today" value="今天" onclick="dt.day(0);loadPeriod();"/>
                        <input type="button" class="btn" value="昨天" onclick="dt.day(-1);loadPeriod();"/>
                        <input type="button" class="btn" value="本星期" onclick="dt.week(0);loadPeriod();"/>
                        <input type="button" class="btn" value="上星期" onclick="dt.week(-1);loadPeriod();"/>
                        <input type="button" class="btn" value="本月" onclick="dt.month(0);loadPeriod();"/>
                        <input type="button" class="btn" value="上月" onclick="dt.month(-1);loadPeriod();"/>
                        </span>
                        <input style="margin-left: 10px;" type="text" id="username" name="username" value="" placeholder="请输入账号"
                               class="input w-2"/>
                        <input type="button" class="btn" value="查询{{$water_name}}" onclick="querywater();"/>
                        <input type="button" class="btn" value="清理{{$water_name}}" onclick="clearwater();"/>
                        <span>{{$water_name}}：<span id="water"></span></span>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">新增账号设置</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">设置</td>
                    <td>
                        新增账号使用的模版：
                        <select name="dfwatertemplateid" style="margin-right: 10px;">
                            @foreach($watertmplist as $tmp)
                            <option @selected($tmp['id']==$dfwatertemplateid) value="{{$tmp['id']}}">{{$tmp['name']}}</option>
                            @endforeach
                        </select>
                        新增账号是否开启{{$water_name}}：
                        <select name="dfwaterstatus" style="margin-right: 20px;">
                            <option @selected($dfwaterstatus==1) value="1">开启</option>
                            <option @selected($dfwaterstatus==0) value="0">关闭</option>
                        </select>
                        <input type="button" class="btn" value="保存" onclick="saveothersetting();"/>
                    </td>
                </tr>
                </tbody>
            </table>
            {{--<table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">一键化操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">设置</td>
                    <td>
                        在线条件：
                        <select name="online">
                            <option value="">全部</option>
                            <option value="1">在线</option>
                            <option value="0">离线</option>
                        </select>
                        <input style="margin-left: 5px;" type="button" class="btn" value="一键关闭所有会员赚点开关" onclick="yijiansetting(1,0);"/>
                        <input style="margin-left: 5px;" type="button" class="btn" value="一键开启所有会员赚点开关" onclick="yijiansetting(2,1);"/>
                    </td>
                </tr>
                </tbody>
            </table>--}}
        </div>
    </form>
</div>
</body>
</html>
