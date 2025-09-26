<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/system.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/notice.js?v1"></script>
    <style>
        .middle-table {
            width: 100%;
            height: 23px;
            text-align: center;
            border-collapse: collapse;
            font-size: 13px;
        }
        .middle-table tbody td {
            padding: 1px 3px;
            height: 25px;
            border: 1px #b9c2cb solid;
        }
        .txt-paddin-right {
            padding-right: 3px;
        }
        .txt-right {
            text-align: right;
            background: #eeeeee;
            font-weight: bold;
        }
        .w30 {
            width: 30%;
        }
        .w10 {
            width: 10%;
        }
        .w5 {
            width: 5%;
        }
        .middle-table tbody td {
            padding: 1px 3px;
            height: 25px;
            border: 1px #b9c2cb solid;
        }
        .txt-left {
            text-align: left;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            LIBS.colorMoney('.color', 'minus')
        })
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">公告管理</span>
        <span class="setting"></span>
    </div>
    <div class="contents">
        <table class="middle-table">
            <tbody>
            <tr>
                <td class="txt-right txt-paddin-right w30">公告内容</td>
                <td class="txt-left txt-paddin-left">
                    <div>
                        <textarea style="width:470px;height:70px;margin-bottom:5px;resize:none;border:1px #ccc solid; margin-top:2px;" name="text"></textarea>
                    </div>
                    <div style="display: flex;align-items: center">可见:<select name="visibleId" style="margin-right: 10px">
                            <option value="0">全部</option>
                            {{--<option value="1">公司</option>--}}
                            <option value="1">代理</option>
                            <option value="2">会员</option>
                        </select>
                         可用:<input style="margin-right: 10px" checked type="checkbox" id="ifok" />
                         弹窗:<input style="margin-right: 10px" checked type="checkbox" id="alert" />
                         滚动:<input type="checkbox" id="gundong" />
                        <input type="hidden" id="newsid" value="" />
                    </div></td>
            </tr>
            </tbody>
            <tfoot><tr><td colspan="2" style="padding-top:10px;padding-bottom:10px;"><button class="button" onclick="save()">保存设置</button></td></tr></tfoot>
        </table>
        <table class="data_table data_list list report" id="lines">
            <thead>
            <tr>
                <th class="w10">新增日期</th>
                <th>新增内容</th>
                <th class="w10">操作者</th>
                <th class="w5">可见</th>
                <th class="w5">状态</th>
                <th class="w5">弹窗</th>
                <th class="w5">滚动</th>
                <th class="w10">功能</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $vo)
            <tr>
                <td>{{$vo['time']}}</td>
                <td>{{$vo['content']}}</td>
                <td>{{$vo['adminname']}}【公司】</td>
                <td>{{$vo['agentstr']}}</td>
                <td>{{$vo['ifokstr']}}</td>
                <td>{{$vo['alertstr']}}</td>
                <td>{{$vo['gundongstr']}}</td>
                <td>
                    <a id="btnEdit" onclick="edit({{$vo['id']}},{{$vo['agent']}},{{$vo['ifok']}},{{$vo['alert']}},{{$vo['gundong']}},'{{$vo['content']}}')">修改</a>
                    <a id="btnDelete" onclick="del({{$vo['id']}})">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
