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
    <script type="text/javascript" src="/default/js/domain.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">授权域名</span>
    </div>
    @foreach($list as $k=>$l)
    <div class="contents" style="{{$k > 0 ? 'margin-top: 5px;' : ''}}">
        <table class="data_table list">
            <thead>
            <tr>
                <th align="center" colspan="4" style="color: {{$l['color']}};font-weight: bold;">{{$l['name']}}</th>
            </tr>
            <tr>
                <th><input type="checkbox" onclick="checkall(this,{{$l['type']}})" /></th>
                <th>授权域名</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="dolist{{$l['type']}}">
            @foreach($l['list'] as $vo)
            <tr>
                <td align="center">
                    <input type="checkbox" value="{{$vo['id']}}" />
                    <input type="hidden" name="id" value="{{$vo['id']}}" />
                </td>
                <td align="center">
                    <input name="domain" style="width: 400px;" type="text" value="{{$vo['domain']}}" />
                </td>
                <td align="center">
                    <select name="status">
                        <option @selected($vo['status']==1) value="1">正常</option>
                        <option @selected($vo['status']==0) value="0">禁用</option>
                    </select>
                </td>
                <td class="op">
                    <a href="javascript:void(0)" onclick="delauthdomain('{{$vo['id']}}')">删除</a>
                    {{--<a href="javascript:void(0)" onclick="tbaws('{{$vo['id']}}')">同步aws</a>--}}
                </td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="4">
                    <input class="save" type="button" value="新增" onclick="addauthhtml({{$l['type']}})"/>
                    <input style="margin-left: 8px;" class="save" type="button" value="保存数据" onclick="saveauthdomain({{$l['type']}})"/>
                    <input style="margin-left: 8px;" class="save" type="button" value="保存AWS和BT" onclick="saveawsandbt({{$l['type']}})"/>
                    <input style="margin-left: 8px;" class="save" type="button" value="删除AWS和BT" onclick="delawsandbt({{$l['type']}})"/>
                    <input style="margin-left: 8px;" class="save" type="button" value="随机生成前缀" onclick="suijipre({{$l['type']}})"/>
                    <input style="width: 50px;" type="text" id="pre{{$l['type']}}" value="" />
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
    @endforeach
</div>
</body>
</html>
