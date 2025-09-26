<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
    {{--<link href="/static/default/css/login2.css" rel="stylesheet" type="text/css">--}}
    <link rel="icon" type="image/x-icon" href="/imgww/general/generic_favicon.ico"><script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
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
                <input type="hidden" name="type" value="1">
                <div class="form_t">
                    <span class="fl user_t">用户登录</span>

                </div>
                <div class="info username"><label>账号</label><input type="text" name="account" title="请输入您的账号" class="tip"></div>
                <div class="info password"><label>密码</label><input type="password" name="password" title="您的密码" class="tip"></div>
                <div class="info code"><label>验证码</label><input type="text" name="code" autocomplete="off" title="验证码" class="tip"><img src="code?_=1682091201396" alt="none" title="看不清？点击更换一张验证图片"></div>

                <div class="control"><input type="submit" value="登录"></div>
            </form>
        </div>

        <div class="left_adv">
            <div class="appqr-wrapper">
                <div class="appqrcode">
                    <img id="qr-code">
                    <div class="text">手机扫码安装<br>苹果安卓APP</div>
                </div>
                <div id="barcodeURL" class="appdlurl">
                    <a id="linkUrl" href="https://luckiapp88.com">请点击下载APP</a>
                </div>
            </div>
            <div class="appqr" id="qr" title="https://luckiapp88.com"><canvas width="256" height="256" style="display: none;"></canvas><img src="data:image/png;base64,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" style="display: block;"></div>
        </div>
        <link href="/static/default/css/footer.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/static/default/js/qrcode.min.js"></script>
        <script type="text/javascript">
  var qr = "https://luckiapp88.com";
  if(qr !== ""){
    new QRCode(document.getElementById("qr"), qr);
    document.getElementById("linkUrl").href=""+qr;
  }
</script>
    </div>
</div>
<style>
    .generated-sidebar {
        position: fixed;
        top:  50%;
        right: 20px;
        transform: translateY(-50%);
        z-index: 100;
    }
    .generated-sidebar .generated-sidebar--btn {
        width: 50px;
        height: 50px;
        border-radius: 40%;
        display: block;
        background-repeat: no-repeat;
        position: relative;
        background-position: center;
    }

    .generated-sidebar .generated-sidebar--btn:not(:last-child) {
        margin-bottom: 4px;
    }

    .generated-sidebar .generated-sidebar--btn:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border-radius: 40%;
        border: 4px solid rgba(255,255,255,0.5);
        transition: all 200ms cubic-bezier(0.4, 0.0, 0.2, 1);
        opacity: 0;
    }


    .generated-sidebar .generated-sidebar--btn:hover:before {
        opacity: 1;
    }

    .generated-sidebar .generated-sidebar--btn.mac {
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxwYXRoIGQ9Ik0zOTUuNzQ4LDI3Mi4wNDZjLTAuNjQ2LTY0Ljg0MSw1Mi44OC05NS45MzgsNTUuMjcxLTk3LjQ4M2MtMzAuMDc1LTQ0LjAxLTc2LjkyNS01MC4wMzktOTMuNjItNTAuNzM2ICAgYy0zOS44NzEtNC4wMzctNzcuNzk4LDIzLjQ3NC05OC4wMzMsMjMuNDc0Yy0yMC4xODQsMC01MS40MDktMjIuODc3LTg0LjQ3Ni0yMi4yNzZjLTQzLjQ1OCwwLjY0Ni04My41MjksMjUuMjY5LTEwNS45MDYsNjQuMTkgICBjLTQ1LjE1Miw3OC4zNS0xMS41NjMsMTk0LjQyLDMyLjQ0NSwyNTcuOTYzYzIxLjUwNCwzMS4xMDQsNDcuMTQ2LDY2LjAzOCw4MC44MTMsNjQuNzljMzIuNDIxLTEuMjk0LDQ0LjY4MS0yMC45NzksODMuODc4LTIwLjk3OSAgIGMzOS4xOTYsMCw1MC4yMTUsMjAuOTc5LDg0LjUyNCwyMC4zMzVjMzQuODg4LTAuNjQ4LDU2Ljk5MS0zMS42OTksNzguMzQ3LTYyLjg5OGMyNC42OTQtMzYuMDg0LDM0Ljg2Mi03MS4wMTksMzUuNDYyLTcyLjgxMiAgIEM0NjMuNjc4LDM3NS4yNiwzOTYuNDIyLDM0OS40OTUsMzk1Ljc0OCwyNzIuMDQ2eiBNMzMxLjI4LDgxLjc2MUMzNDkuMTQ5LDYwLjA4MiwzNjEuMjEsMzAuMDA1LDM1Ny45MiwwICAgYy0yNS43MzksMS4wNDgtNTYuOTM4LDE3LjE0NS03NS40MDUsMzguNzc1Yy0xNi41NywxOS4xODgtMzEuMDc1LDQ5LjgxMy0yNy4xODgsNzkuMjE4ICAgQzI4NC4wNjEsMTIwLjIzNSwzMTMuMzkyLDEwMy4zOTEsMzMxLjI4LDgxLjc2MXoiIGZpbGw9IiNGRkZGRkYiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
        background-color: #d5208a;
        background-size: 54% auto;
        background-position-y: 10px;
    }
    .generated-sidebar .generated-sidebar--btn.windows {
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDgwIDQ4MCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDgwIDQ4MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxwYXRoIGQ9Ik0wLjE3NiwyMjRMMC4wMDEsNjcuOTYzbDE5Mi0yNi4wNzJWMjI0SDAuMTc2eiBNMjI0LjAwMSwzNy4yNDFMNDc5LjkzNywwdjIyNEgyMjQuMDAxVjM3LjI0MXogTTQ3OS45OTksMjU2bC0wLjA2MiwyMjQgICBsLTI1NS45MzYtMzYuMDA4VjI1Nkg0NzkuOTk5eiBNMTkyLjAwMSw0MzkuOTE4TDAuMTU3LDQxMy42MjFMMC4xNDcsMjU2aDE5MS44NTRWNDM5LjkxOHoiIGZpbGw9IiNGRkZGRkYiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
        background-color: #7225c1;
        background-size: 47% auto;
        background-position-x: 13px;
    }
</style>
<div class="generated-sidebar">
    <a class="generated-sidebar--btn mac" download="" href="https://xypcappxiazai.com/download/mac/Xinyong-Official-darwin-x64.dmg"></a>
    <a class="generated-sidebar--btn windows" download="" href="https://xypcappxiazai.com/download/windows/Xinyong-Official-win32-x64.exe"></a>
</div>

</body></html>
