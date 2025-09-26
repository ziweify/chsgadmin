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
    <script type="text/javascript" src="/default/js/password.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">变更密码</span>
    </div>
    <div class="contents">
        <table class="list data_table info_table">
            <tr>
                <th>原始密码</th>
                <td><input id="oldPassword" type="password" class="input"/></td>
            </tr>
            <tr>
                <th>新设密码</th>
                <td><input id="password" type="password" class="input"/>＊6-20字符必须由大小写字母和数字组合组成</td>
            </tr>
            <tr>
                <th>确认密码</th>
                <td><input id="ckPassword" type="password" class="input"/></td>
            </tr>
        </table>
    </div>
    <div class="data_footer control">&nbsp;<input class="button" type="button" value="确定修改"
                                                  onclick="changePassword()"/>&nbsp;
    </div>
</div>
</body>
</html>
