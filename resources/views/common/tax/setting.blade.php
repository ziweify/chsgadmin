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
            var mode = $("select[name='tax_clear_mode']").val();
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
                url: "/agent/tax/cleartaxbywhere",
                data: {username:username,sdate:sdate,edate:edate,mode:mode,qishu:qishu,gid:gid},
                success: function(res){
                    if(res.success){
                        alert(res.message);
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
            var tax_clear_mode = $("select[name='tax_clear_mode']").val();
            var qishu = $("input[name='qishu']").val();
            var gid = $("select[name='gid']").val();
            if(username==''){
                alert('请输入账号');
                return false;
            }
            //ajax
            $.ajax({
                type: "GET",
                url: "/agent/tax/querytax",
                data: {username:username,sdate:sdate,edate:edate,mode:tax_clear_mode,qishu:qishu,gid:gid},
                success: function(res){
                    if(res.success){
                        $("#tax").html(res.data.totaltax);
                    }else{
                        alert(res.message);
                    }
                }
            });
        }
        //select tax_clear_mode切换的时候显示
        //文档加载完成后执行
        $(function(){
            $("select[name='tax_clear_mode']").change(function(){
                var tax_clear_mode = $(this).val();
                if(tax_clear_mode==1){
                    $("#taxtype2").hide();
                    //$("#date").show();
                }else{
                    $("#taxtype2").show();
                    //$("#date").hide();
                }
            });
        });

        function saveothersetting(){
            var dftaxtemplateid = $("select[name='dftaxtemplateid']").val();
            var dftaxstatus = $("select[name='dftaxstatus']").val();
            var fid1 = $("#fid1").val();
            $.ajax({
                type: "POST",
                url: "/agent/tax/saveothersetting",
                data: {dftaxtemplateid:dftaxtemplateid,dftaxstatus:dftaxstatus,fid1:fid1},
                success: function(res){
                    alert(res.message);
                }
            });
        }

        function yijiansetting(type,param){
            var online = $("select[name='online']").val();
            $.ajax({
                url: "/agent/tax/yijiansetting",
                method: "POST",
                /*contentType: "application/json",*/
                data: {type:type,param:param,online:online},
                loading: true,
                success: function(g) {

                }
            })
        }

        function changefid1() {
            var fid1 = $("#fid1").val();
            location.href = "setting?fid1=" + fid1;
        }
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$tax_name}}设置</span>
    </div>
    <form id="search_form" action="list">
        <div class="contents">
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    @if($layer==0)
                    <th>所属一级代理：
                        <select name="fid1" id="fid1" onchange="changefid1()">
                            @foreach($ulist as $u)
                                <option @selected($fid1==$u['userid']) value="{{$u['userid']}}">{{$u['username']}}</option>
                            @endforeach
                        </select>
                    <th>清理{{$tax_name}}</th>
                    @else
                    <th colspan="2">清理{{$tax_name}}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="ft_sd te-rt">条件</td>
                    <td>
                        清理模式：
                        <select name="tax_clear_mode">
                            <option value="1">当天</option>
                            <option value="2">期数</option>
                        </select>
                        <span id="taxtype2" style="display: none;">
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
                        <input type="button" class="btn" value="查询{{$tax_name}}" onclick="querytax();"/>
                        <input type="button" class="btn" value="清理{{$tax_name}}" onclick="cleartax();"/>
                        <span>{{$tax_name}}：<span id="tax"></span></span>
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
                        <select name="dftaxtemplateid" style="margin-right: 10px;">
                            @foreach($taxtmplist as $tmp)
                            <option @selected($tmp['id']==$dftaxtemplateid) value="{{$tmp['id']}}">{{$tmp['name']}}</option>
                            @endforeach
                        </select>
                        新增账号是否开启{{$tax_name}}：
                        <select name="dftaxstatus" style="margin-right: 20px;">
                            <option @selected($dftaxstatus==1) value="1">开启</option>
                            <option @selected($dftaxstatus==0) value="0">关闭</option>
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
