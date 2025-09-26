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
    <script type="text/javascript" src="/static/default/js/report.js"></script>
    <script type="text/javascript">var TODAY ={{$today}};</script>
    <script type="text/javascript"> var currentUserName = "{{$username}}";</script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$layername}}报表查询</span>
        <a href="main?action=list">交收分类报表</a> |
        @if(in_array('report.logs',$auths))
        <a class="select" href="main?action=logs">后台更新日志</a> |
        @endif
        @if(in_array('report.batch.activate.user',$auths))
            <a href="userBatchActivate" target="cts_frame" onclick="clearSearchForm()">一键启用报表</a> |
        @endif
    </div>
    <form id="search_form" action="logs">
        <div class="contents">
            <table class="data_table info_table panel">
                <thead>
                <tr>
                    <th colspan="2">查询设定</th>
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
                    </td>
                </tr>
                <tr>
                    <th>模块</th>
                    <td>
                        模块
                        <select id="module" onchange="moduleOnChange();">
                            <option value="" selected>--全选--</option>
                            <option value="autoback">自动补货</option>
                            <option value="user">用户管理</option>
                            <option value="instantbet">即时注单</option>
                            <option value="agentfollowbet">跟投</option>
                        </select>
                        功能
                        <select id="function" onchange="functionOnChange();">
                            <option value="" selected>--全选--</option>
                        </select>
                        操作
                        <select id="action">
                            <option value="" selected>--全选--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>变更人</th>
                    <td><input id="operator"/></td>
                </tr>
                <tr>
                    <th>变更对象</th>
                    <td><input id="targetUserId"/></td>
                </tr>
                <tr>
                    <th>IP地址</th>
                    <td><input id="ipAdd"/></td>
                </tr>
                <tr id="lotteryDDL" style="display:none">
                    <td width="20%" class="ft_sd te-rt">彩票种类</td>
                    <td>
                        <a onclick="selectAll(true,this)" class="ft_a ico_tick">全部选择</a><a
                            onclick="selectAll(false,this)" class="ft_a">全部不选择</a><br/>
                        <ul class="table_box table_box_lotterys">
                            <li class="table_box_title"><span>快开彩彩种</span><a
                                    onclick="selectAll(true,this)" class="ico_tick2">全选</a>&nbsp;&nbsp;&nbsp;<a
                                    onclick="selectAll(false,this)">全不选</a></li>
                            <li class="table_box_info">
                                @foreach($lotterys as $lot)
                                    <label><input type="checkbox" name="lottery" value="{{$lot['lottery']}}" checked="checked"/>{{$lot['gname']}}</label>
                                @endforeach
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr id="periodDDL" style="display:none">
                    <td class="ft_sd te-rt">期数</td>
                    <td>
                        <select name="period" style="width:200px;">
                            <option value="">--------请选择期数--------</option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="color:red;text-align: center;">备注：6AM-7AM是系统维护时间，会影响报表导出功能，敬请谅解</div>
        <div class="data_footer control">
            <input type="button" value="确定" onclick="query()" class="button"/>
            <input type="button" value="取消" onclick="history.back()" class="button"/>
        </div>
    </form>
    <div class="contents" style="height: calc(100vh - 40px);">
        <iframe id="cts_frame" name="cts_frame" frameborder="0" class="frame"></iframe>
    </div>
</div>

<script type="text/javascript">
  $('document').ready(function(){
    var reportValue = window.parent.document.getElementById('subreport');
    if(reportValue.value !== '' && reportValue.value.length !== 0) {
        var d1 = $('#cts_frame');
        d1[0].src=reportValue.value;
        reportValue.value = '';
        clearSearchForm();
    }
  })

</script>

</body>
</html>
