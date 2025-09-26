<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css" />
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/password.js"></script>
    <script type="text/javascript">var STATUS={{$first}};</script>
</head>
<body>
<div class="main password">
    <table class="table user_info pass_panel input_panel">
        <input type="hidden" id="url" value="login" />
        <thead><tr><th colspan="2">修改密码</th></tr></thead>
        <form>
            <tbody>
            <tr><th>旧密码</th><td><input id="oldPassword" type="password" /></td></tr>
            <tr><th>新密码</th><td><input id="password" type="password" />＊6-20字符必须由大小写字母和数字组合组成</td></tr>
            <tr><th>确认密码</th><td><input id="ckPassword" type="password" /></td></tr>
            </tbody>
    </table>
    <div class="control"><input type="button" class="button" value="确定" onclick="changePassword()" /> <input type="reset" class="button" value="重置" /></div>
    </form>
</div>
</body>
</html>
