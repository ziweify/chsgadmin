<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
    {{--<link href="/static/default/css/login2.css" rel="stylesheet" type="text/css">--}}
    <link rel="icon" type="image/x-icon" href="/imgww/general/generic_favicon.ico"><script type="text/javascript" src="/static/js/jquery-1.10.2.min.js"></script>
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
    @if(session('opMsg'))
        <script>alert("{{session('opMsg')}}");</script>
    @endif
    <style>
        body {
            margin: 0;
            padding: 0;
            background: white;
            color: #333;
            /*font: 14px/1.231 Verdana, Arial, Helvetica, sans-serif;*/
        }

        input {
            border: none;
            padding: 0;
        }

        .header {
            height: 100px;
            margin: 0 auto;
            width: 950px;
        }

        .main {
            background: url("/imgww/general/year_banner_bg.png?v=2") center no-repeat #CF3F3F;
            height: 475px;
        }

        .panel {
            background: url("/imgww/general/year_banner.png?v=2") no-repeat left;
            width: 950px;
            height: 475px;
            margin: 0 auto;
        }

        .login {
            float: right;
            width: 270px;
            height: auto;
            margin-top: 72px;
            background: rgba(0,0,0,0.3);
            border-radius: 10px;
        }

        .login .info {
            background: url("/static/default/css/login/input_bg.png") no-repeat left top;
            height: 50px;
            width: 220px;
            margin: 10px auto;
        }

        .login .info label {
            background: url("/static/default/css/login/login_ico.png") no-repeat top;
            display: block;
            font-size: 0;
            text-indent: -99999px;
            height: 35px;
            width: 38px;
            margin: 6px 0px 0 10px;
            float: left;
        }

        .login .password label {
            background-position: center;
        }

        .login .code label {
            background-position: bottom;
        }

        .login .facode label {
            background: url("/static/default/css/login/login_ico2.png") no-repeat bottom;
        }

        .login .info input {
            float: left;
            font-size: 16px;
            margin: 12px 0 0 0;
            width: 155px;
            /*font-family: Microsoft YaHei;*/
        }

        input[type="password"] {
            caret-color: black;
            font-size: 20px !important;
            line-height: 1 !important;
            padding: 0 !important;
        }

        .login .info .tip {
            color: #999;
        }

        .login .code input {
            width: 60px;
        }

        .login .code img {
            cursor: pointer;
            float: right;
            margin: 9px 15px 0 0;
        }

        .login .control input {
            background: url("/static/default/css/login/submit.png");
            display: block;
            height: 36px;
            margin: 15px auto 15px auto;
            width: 215px;
            text-indent: -9999em;
        }

        .form_t {
            height: 36px;
            margin-top: 15px;
            line-height: 36px;
            margin-left: 30px;
        }

        .form_t span {
            display: inline-block;
            width: 110px;
            height: 36px;
            line-height: 36px;
            color: #fff;
            font-weight: 600;
        }

        span.user_t {
            font-size: 24px;
        }

        span.user_f {
            background: url("/static/default/css/login/mfa_ico.png") top center no-repeat;
            text-indent: 40px;
            margin-top: 5px;
            cursor: pointer;
        }

        .fl {
            float: left;
        }

        .fr {
            float: right;
        }

        .login .facode {
            display: none;
        }
    </style>
</head>
<body style="">
<div class="header"></div>
<div class="main">
    <div class="panel">
        <div class="login">

            <form action="login" method="post">
                <input type="hidden" name="type" value="2">
                <div class="form_t">
                    <span class="fl user_t">用户登录</span>
                    <span class="fr user_f"></span>
                </div>
                <div class="info username"><label>账号</label><input type="text" name="account" title="请输入您的账号" class=""></div>
                <div class="info password"><label>密码</label><input type="password" name="password" title="您的密码" class=""></div>
                <div class="info code"><label>验证码</label><input type="text" name="code" autocomplete="off" title="验证码" class="tip"><img src="code?_=1682246521675" alt="none" title="看不清？点击更换一张验证图片"></div>
                <div class="info facode"><label>验证码</label><input type="text" name="facode" autocomplete="off" placeholder="二次验证码" maxlength="10" class="tip"></div>
                <div class="control"><input type="submit" value="登录"></div>
            </form>
        </div>

    </div>
</div>

</body></html>
