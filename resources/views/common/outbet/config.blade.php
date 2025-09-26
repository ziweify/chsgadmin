<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <link href="/default/css/agent/outbet.css?v=1" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/outbet.js"></script>

    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css"/>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
</head>
<body>
<div class="main" style="width: 100% !important;background: white !important;">
    <div class="top_info">
        <span class="title">{{$outbet_name}}设置</span>
        @if(isset($ht))
        所属代理：
        <select id="quserid">
            @foreach($flyuserlist as $vo)
                <option @selected($userid==$vo['userid']) value="{{$vo['userid']}}">{{$vo['username']}}</option>
            @endforeach
        </select>
        @endif
        @if(isset($ht))<div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>@endif
    </div>
    <div class="contents">
        <table class="data_table info_table" id="configForm">
            <thead>
            <tr><th colspan="4">基本设置</th></tr>
            </thead>
            <tbody>
            <tr>
                <th>开关</th>
                <td>
                    <label><input @if($outbet_switch==1)checked="checked" @endif type="radio" name="enabled" value="1"  />启用</label>
                    <label><input @if($outbet_switch==0)checked="checked" @endif type="radio" name="enabled" value="0" />停用</label>
                    @if(isset($ht))<input type="hidden" value="{{$userid}}" name="userid" />@endif
                </td>
                <th>订单模式</th>
                <td>
                    <label><input @if($outbet_mode==1)checked="checked" @endif type="radio" name="outbet_mode" value="1"  />不合订单</label>
                    <label><input @if($outbet_mode==2)checked="checked" @endif type="radio" name="outbet_mode" value="2" />合并订单</label>
                    <label><input @if($outbet_mode==3)checked="checked" @endif type="radio" name="outbet_mode" value="3" />分段模式<span style="color: #0b8fff">(推荐)</span></label>
                    {{--<label><input @if($outbet_mode==3)checked="checked" @endif type="radio" name="outbet_mode" value="3" />合并去重</label>--}}
                </td>
            </tr>
            <!-- <tr><th>补货比例</th><td><label>A盘：<input value="100" />%</label><label>B盘：<input value="100" />%</label><label>C盘：<input value="100" />%</label><label>D盘：<input value="100" />%</label><span>未生效</span></td></tr>
            <tr><th>通知邮箱</th><td><input class="email" /> <span>未生效</span></td></tr>
            <tr><th>通知TG</th><td><a href="about:blank" target="_blank">https://t.me/example</a> <span>未生效</span></td></tr> -->
            </tbody>
            <tfoot>
            <tr>
                <th colspan="4"><input class="save" type="button" value="保存" onclick="saveConfig()"/></th>
            </tr>
            </tfoot>
        </table>

        <table class="data_table list">
            <thead>
            <tr>
                <th>ID</th>
                <th>站点</th>
                <th>类型</th>
                <th>主副站类型</th>
                <th>网址</th>
                <th>账户状态</th>
                <th>账户余额</th>
                <th>报表</th>
                <th>未结明细</th>
                <th>开关</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $vo)
            <tr>
                <td>{{$vo['id']}}</td>
                <td>{{$vo['name']}}</td>
                <td>{{$vo['type']}}</td>
                <td>{!! $vo['main_fu_typestr'] !!}</td>
                <td>
                    @foreach($vo['urls'] as $url)
                    <a href="{{$url}}" target="_blank">{{$url}}</a><br/>
                    @endforeach
                </td>
                <td>离线:{{$vo['lixiancount']}} 在线:{{$vo['onlinecount']}} 错误:{{$vo['yichangcount']}} 总数:{{$vo['totalcount']}}</td>
                <td>余额:{{$vo['totalbalance']}} 未结算:{{$vo['totalbet']}} 盈亏:{{$vo['totalwin']}}</td>
                <td>
                    <select id="selectreport{{$vo['id']}}">
                        @foreach($vo['accs'] as $account)
                        <option value="{{$account['id']}}">{{$account['username']}}</option>
                        @endforeach
                    </select> <input type="button" value="查询" onclick="reportquery('{{$vo['id']}}',2)"/>
                </td>
                <td>
                    <select id="selectwjs{{$vo['id']}}">
                        @foreach($vo['accs'] as $account)
                            <option value="{{$account['id']}}">{{$account['username']}}</option>
                        @endforeach
                    </select> <input type="button" value="查询" onclick="reportquery('{{$vo['id']}}',1)"/>
                </td>
                <td>
                    @if(isset($ht))
                    @if($vo['enabled']==1)<span onclick="enabled({{$vo['id']}},{{$vo['enabled']}})" class="s-1">启用</span>@else<span onclick="enabled({{$vo['id']}},{{$vo['enabled']}})" class="s-0">停用</span>@endif
                    @else
                    @if($vo['enabled']==1)<span class="s-1">启用</span>@else<span class="s-0">停用</span>@endif
                    @endif
                </td>
                <td>{{$vo['create_time']}}</td>
                <td class="op">
                    @if($vo['main_fu_type'] == 2)
                    <a onclick="qiehuan('{{$vo['id']}}')">主副切换</a>
                    @endif
                    <a href="site?id={{$vo['id']}}&userid={{$userid}}">编辑</a>
                    <a href="javascript:void(0)" onclick="delSite('{{$vo['id']}}','{{$vo['name']}}','{{$userid}}')">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="11"><input class="save" type="button" value="添加站点" onclick="location.href='site?userid={{$userid}}'"/></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
<script>
    function qiehuan(siteid){
        //弹窗确认
        if(!confirm("确认切换？")){
            return false;
        }
        $.ajax({
            url: '/agent/outbet/qiehuan',
            type: 'POST',
            dataType: 'json',
            data: {siteid:siteid},
            success: function (data) {
                alert(data.message);
                window.location.reload();
            }
        });
    }
    $('#quserid').change(function () {
        window.location.href = '/agent/outbet/config?userid='+$(this).val();
    });
    /*function uidchange(){
        console.log('ssssssssssss');
        window.location.href = '/agent/outbet/config?userid='+$(this).val();
    }*/

    function reportquery(siteid,type){
        if(type==2) {
            accusername = $('#selectreport'+siteid+' option:selected').text();
            accid = $('#selectreport'+siteid).val();
            title = accusername + " 报表明细";
        }else{
            accusername = $('#selectwjs'+siteid+' option:selected').text();
            accid = $('#selectwjs'+siteid).val();
            title = accusername + " 未结注单";
        }
        $.ajax({
            url: "outbet_bhdata",
            type: "GET",
            loading: !0,
            data: {accid:accid,type:type},
            success: function (e) {
                if(e.success){
                    var b = $("#wjsDialog").dialog({
                        autoOpen: false,
                        modal: true,
                        title: title,
                        width: "900",
                        height: "auto",
                    });
                    //不能变形
                    b.html(e.data.html);
                    b.dialog("open");
                    LIBS.colorMoney('.color', 'minus');
                }else{
                    alert(e.message);
                }
            },
            error: function () {
                alert("网络错误，请稍后重试")
            }
        })
    }

    function enabled(id,e){
        var enabled = e == 1 ? 0 : 1;
        $.ajax({
            url: "siteenabled",
            type: "POST",
            loading: !0,
            data: {enabled:enabled,id:id},
            success: function (e) {
                window.location.reload();
            },
            error: function () {
                alert("网络错误，请稍后重试")
            }
        })
    }
</script>
<div id="reportDialog"></div>
<div id="wjsDialog"></div>
</html>
