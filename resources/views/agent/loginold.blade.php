<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="/default/css/login2.css?v=1" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.login .info input[title!=""]').focus(function() {
                var t = $(this);
                if (t.hasClass('tip')) {
                    t.removeClass('tip').val('').attr('type', t.data('ot'));
                }
            }).blur(function() {
                var t = $(this);
                if (t.val() == '') {
                    t.addClass('tip').val(t.attr('title')).data('ot', t.attr('type')).attr('type', 'text');
                }
            }).each(function() {
                var t = $(this);
                if (!t.attr('value')) {
                    t.addClass('tip').val(t.attr('title')).data('ot', t.attr('type')).attr('type', 'text');
                }
            });
            $('.login .code img').click(function(){
                $(this).attr('src','code?_='+(new Date()).getTime());
            });
            $('.fr.user_f').click(function(){
                $('.info.facode').slideToggle();
            });
        })
    </script>
</head>
<body>
<div class="header"><a href="" target="_blank"></a></div>
<div class="main">
    <div class="panel">
        <div class="login">

            <form action="login" method="post">
                <input type="hidden" name="type" value="4">
                <div class="form_t">
                    <span class="fl user_t">用户登录</span>
                    <span class="fr user_f"></span>
                </div>
                <div class="info username"><label>账号</label><input type="text" name="account" title="请输入您的账号"></div>
                <div class="info password"><label>密码</label><input type="password" name="password" title="您的密码"></div>
                <div class="info code"><label>验证码</label><input type="text" name="code" autocomplete="off" title="验证码"><img src="code?_=1557997956886" alt="none" title="看不清？点击更换一张验证图片" /></div>
                <div class="info facode"><label>验证码</label><input type="text" name="facode" autocomplete="off" placeholder="二次验证码" maxlength="10" /></div>
                <div class="control"><input type="submit" value="登录" ></div>
            </form>
        </div>
    </div>
    @if(session('opMsg'))
        <script>alert("{{session('opMsg')}}");</script>
    @endif
</div>
</body>
</html>
