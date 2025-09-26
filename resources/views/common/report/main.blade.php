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
    <script type="text/javascript">var TODAY ={{$today}};</script>
    <script type="text/javascript"> var currentUserName = "{{$username}}";</script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$layername}}报表查询</span>
        <a class="select" href="main?action=list">交收分类报表</a> |
        @if(in_array('report.logs',$auths))
            <a class="select" href="main?action=logs">后台更新日志</a> |
        @endif
        @if(in_array('report.batch.activate.user',$auths))
            <a href="userBatchActivate" target="cts_frame" onclick="clearSearchForm()">一键启用报表</a> |
        @endif
    </div>


    <div id="game_tab" class="game_tab_class">
        <a id="lotterys" href="#l" class="selected">彩票类</a>
    </div>

    <form id="search_form" action="list">
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
                    <td width="20%" class="ft_sd te-rt">种类</td>
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
                        <ul class="table_box table_box_products" style="display: none">
                            <li class="table_box_title">
                                <select id="product">
                                    <option value="SY">棋牌</option>
                                </select>
                                <a onclick="selectAll(true,this)" class="ico_tick2">全选</a>
                                &nbsp;&nbsp;&nbsp;<a onclick="selectAll(false,this)">全不选</a>
                            </li>
                            <li class="table_box_info product_box" id="product_box_info_SY" style="display: none">
                                <label><input type="checkbox" name="product-SY" value="3003" checked="checked"/>百人牛牛</label>
                                <label><input type="checkbox" name="product-SY" value="22001" checked="checked"/>百人龙虎</label>
                                <label><input type="checkbox" name="product-SY" value="23001" checked="checked"/>百人炸金花</label>
                                <label><input type="checkbox" name="product-SY" value="3008" checked="checked"/>通比牛牛</label>
                                <label><input type="checkbox" name="product-SY" value="3002" checked="checked"/>看牌抢庄牛牛</label>
                                <label><input type="checkbox" name="product-SY" value="3001" checked="checked"/>随机庄家牛牛</label>
                                <label><input type="checkbox" name="product-SY" value="25001" checked="checked"/>十三水</label>
                                <label><input type="checkbox" name="product-SY" value="24001" checked="checked"/>百家乐</label>
                                <label><input type="checkbox" name="product-SY" value="15003"
                                              checked="checked"/>三公</label>
                                <label><input type="checkbox" name="product-SY" value="1001"
                                              checked="checked"/>炸金花</label>
                                <label><input type="checkbox" name="product-SY" value="9004" checked="checked"/>二人斗地主</label>
                                <label><input type="checkbox" name="product-SY" value="10103" checked="checked"/>二人麻将</label>
                                <label><input type="checkbox" name="product-SY" value="26001" checked="checked"/>二八杠</label>
                                <label><input type="checkbox" name="product-SY" value="27001" checked="checked"/>二十一点</label>
                                <label><input type="checkbox" name="product-SY" value="28001" checked="checked"/>抢庄牌九</label>
                                <label><input type="checkbox" name="product-SY" value="15004" checked="checked"/>三公大吃小</label>
                                <label><input type="checkbox" name="product-SY" value="3020" checked="checked"/>十人牛牛</label>
                                <label><input type="checkbox" name="product-SY" value="2001" checked="checked"/>德州扑克</label>
                                <label><input type="checkbox" name="product-SY" value="22004" checked="checked"/>拼庄百人斗神兽</label>
                                <label><input type="checkbox" name="product-SY" value="23002" checked="checked"/>拼庄百人炸金花</label>
                                <label><input type="checkbox" name="product-SY" value="3017" checked="checked"/>拼庄百人牛牛</label>
                                <label><input type="checkbox" name="product-SY" value="22002" checked="checked"/>拼庄百人龙虎</label>
                                <label><input type="checkbox" name="product-SY" value="24002" checked="checked"/>拼庄百家乐</label>
                                <label><input type="checkbox" name="product-SY" value="10102" checked="checked"/>推倒胡</label>
                                <label><input type="checkbox" name="product-SY" value="9001"
                                              checked="checked"/>斗地主</label>
                                <label><input type="checkbox" name="product-SY" value="1002" checked="checked"/>极速炸金花</label>
                                <label><input type="checkbox" name="product-SY" value="4001" checked="checked"/>港式五张</label>
                                <label><input type="checkbox" name="product-SY" value="10104" checked="checked"/>点炮胡</label>
                                <label><input type="checkbox" name="product-SY" value="3013" checked="checked"/>疯狂点子牛</label>
                                <label><input type="checkbox" name="product-SY" value="2006" checked="checked"/>百人德州</label>
                                <label><input type="checkbox" name="product-SY" value="10108" checked="checked"/>红中麻将</label>
                                <label><input type="checkbox" name="product-SY" value="29001" checked="checked"/>血战到底</label>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr id="period">
                    <td class="ft_sd te-rt">期数</td>
                    <td>
                        <select name="period" style="width:200px;">
                            <option value="">--------请选择期数--------</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="ft_sd te-rt">{{$layername}}报表种类</td>
                    <td>
                        <label><input type="radio" name="types" value="" checked="checked"/>交收报表</label>
                        <label><input type="radio" name="types" value="true"/>分类报表</label>
                    </td>
                </tr>
                <tr id="settled">
                    <td class="ft_sd te-rt">结算状态</td>
                    <td>
                        <label><input type="radio" name="settle" value="1" checked="checked"/>已 结 算</label>&nbsp;
                        <label class="unsettled"><input type="radio" name="settle" value="2"/>未 结 算</label>
                    </td>
                </tr>
                <tr>
                    <th>用户名</th>
                    <td><input id="filter"/></td>
                </tr>
                <tr>
                    <th>会员金额</th>
                    <td><input id="amount"/></td>
                </tr>
                <tr>
                    <th>盈亏金额</th>
                    <td><input id="dividend"/></td>
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
