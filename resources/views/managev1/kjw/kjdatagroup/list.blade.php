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
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>

    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/kjwkjdatagroup.js?v23"></script>
    <script type="text/javascript" src="/js/jquery-ui-timepicker-addon.min.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">开奖数据整合管理</span>
        <div class="center">
            <div class="query_panel">
                <label>彩种：<select id="" name="gid">
                        <option @selected($gid=='') value="">全部</option>
                        @foreach($gamelist as $vo)
                            <option @selected($gid==$vo->gid) value="{{$vo->gid}}">{{$vo->gname}}</option>
                        @endforeach
                    </select>
                </label>
                <button type="button" class="query" onclick="clearall(1)">清理所有快开彩</button>
                <button type="button" class="query" onclick="clearall(0)">清理所有慢开彩</button>
                <button type="button" class="query" onclick="createbydays({{$gid}})">根据天数生成数据</button>
                <button type="button" class="query" onclick="yijiantongbugf({{$gid}})">根据天数同步官方</button>
                <input style="width: 40px" type="number" id="days" value="30" />天
                <button type="button" class="query" onclick="loadqgc()">加载全国慢开</button>
                <button type="button" class="query" onclick="loadlhc()">加载六合彩</button>
            </div>
        </div>
        <div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>
    </div>
    <div class="contents">
        <div class="user_list">
            <table class="data_table list">
                <thead>
                <tr>
                    <th>日期</th>
                    <th>彩种</th>
                    <th>已开奖数量</th>
                    <th>未开奖数量</th>
                    <th>开奖数据</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $vo)
                    <tr>
                        <td>{{$vo['date']}}</td>
                        <td>{{$vo['gname']}}</td>
                        <td>{{$vo['ykjcount']}}</td>
                        <td>{{$vo['wkjcount']}}</td>
                        <td>{{$vo['isdatastr']}}</td>
                        <td>
                            <a onclick="createdata('{{$vo['date']}}', {{$gid}})">生成</a>
                            <a onclick="cleardata('{{$vo['date']}}', {{$gid}})">清空</a>
                            <a onclick="tongbugf('{{$vo['date']}}', {{$gid}})">同步官方开奖</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
