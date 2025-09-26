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
    <link href="/default/css/agent/notices.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">最新公告</span>
    </div>
    <div class="contents">
        <table class="data_table data_list list">
            <thead>
            <tr>
                <th>时间</th>
                <th>公告详情</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($notices as $notice)
                <td class="created">{{$notice['time']}}</td>
                <td>
                    <div class="wrap">{{$notice['content']}}</div>
                </td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
    <div class="page">
        <div class="page_info">
            <span class="record">共 {{$count}} 条公告</span>
            <span class="page_count">共 1 页</span>
            <span class="page_control">
<a class="first">首页</a> |
<span class="jump">跳转至<input style="width: 50px"
                                onblur="var p=$(this).val();if(p>0&&p<=1)location.href=LIBS.url({page:p});else $(this).val('');"/>页</span>
<a class="previous">前一页</a>『
<span class="current">1</span>
』<a class="next">后一页</a> |
<a class="first">末页</a>
</span>
        </div>
    </div>
</div>
</body>
</html>
