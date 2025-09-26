
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/xypone/css/login2.css">
    <script language="javascript" src="/xypone/common/js/jquery-1.10.2.min.js"></script>
    <!--<script language="javascript" src="/xypone/default/js/md5.js"></script>
    <script type="text/javascript" src="/xypone/common/js/dialog.js"></script>-->
    <script language="javascript">
        $(function() {
            $("#imgcode").click(function(){
                $("#imgcode").attr('src',"/code?"+Math.random());
            });
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
            $('.fr.user_f').click(function(){
                $('.info.facode').slideToggle();
            });
        })

        function checkform(){
            var username = $("#account").val().trim();
            var password = $("#password").val().trim();
            var code = $("#code").val().trim();
            var _token = $("#_token").val().trim();
            if(username==''){
                alert("请输入登录账号");
                $("#username").focus();
                return false;
            }else if(password==''){
                alert("请输入登录密码");
                $("#password").focus();
                return false;
            }else if(code==''){
                alert("请输入验证码");
                $("#code").focus();
                return false;
            }else{
                $.ajax({
                    url: "/dologin",
                    type: "post",
                    data:{username:username,password:password,code:code,_token:_token},
                    dataType: "json",
                    success: function (res) {
                        if(res.status != 200){
                            alert(res.msg);
                            $("#imgcode").attr('src',"/code?"+Math.random());
                        }else{
                            window.location.href = res.data.url;
                        }
                    }
                });
            }
        }
        /*document.onmouseover=hideinfo;
        document.onmousemove=hideinfo;
        document.onkeydown = function (e) {
            //兼容FF和IE和Opera
            var theEvent = window.event || e;
            var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
            if (code == 13) {
                checkform();
            }
        }*/
    </script>
</head>

<body style="">
<div class="header"></div>
<div class="main">
    <div class="panel">
        <div class="login">
            <form>
                <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="type" value="2">
                <div class="form_t">
                    <span class="fl user_t">用户登录</span>
                    <span class="fr user_f"></span>
                </div>
                <div class="info username"><label>账号</label><input type="text" id="account" name="account" title="请输入您的账号" class="tip"></div>
                <div class="info password"><label>密码</label><input type="password" id="password" name="password" title="您的密码" class="tip"></div>
                <div class="info code"><label>验证码</label><input type="text" id="code" name="code" autocomplete="off" title="验证码" class="tip"><img src="/code" id="imgcode" title="看不清？点击更换一张验证图片" /></div>
                <div class="info facode"><label>验证码</label><input type="text" name="facode" autocomplete="off" placeholder="二次验证码" maxlength="10" class="tip"></div>
                <div class="control"><input onclick="checkform()" type="button" value="登录"></div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
