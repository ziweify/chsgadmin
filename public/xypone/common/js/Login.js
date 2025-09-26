define([], function () {

    function Login(d) {
        this.d = $(d);
    }

    Login.prototype = {
        init: function () {
            var _this = this;
            document.forms[0].account.focus();
            $(document.forms[0]).validate({
                submitHandler: function (form) {
                    _this.do_save(form);
                }
            });
            this.d.on('click', '#imgCaptcha', function () {
                _this.get_captcha();
            });

            this.checkCaptcha();
        },
        beforeSend: function (form) {
            var data = {},
                account = $('input[name="account"]').val(),
                password = $('input[name="password"]').val(),
                captcha = $('input[name="captcha"]').val();

            data.Info = callSecret(encodeURIComponent(account) + "," + encodeURIComponent(password));
            data.Captcha = captcha;
            data.Token = G.util.getQueryString("Token");
            return data;
        },
        do_save: function (form) {
            var data = this.beforeSend(form);
            G.get({
                url: "/Member/DoLogin",
                data: data,
                bussiness: function (msg) {
                    form.password.value = "";
                    $.alert(msg);
                },
                success: function (x) {
                    location.href = SESSIONID + "/Member/GetAgreement";
                }
            });
        },
        get_captcha: function () {
            $('#captcha').val('');
            $("#imgCaptcha").removeClass('hide');
            $.ajax({
                url: SESSIONID + "/Member/GetCaptcha",
                type: "get",
                dataType: "json",
                success: function (d) {
                    if (d.Status === 1) {
                        $('#imgCaptcha').attr("src", "https://f1.safelogin.cc/Captcha/GetCaptcha?AppId=AppSSC&Token=" + d.Data);
                    }
                    else {
                        alert(d.Data);
                    }
                }
            });
        },
        checkCaptcha: function () {
            var CAPTCHA_STATUS = $('.captchaContent').hasClass('hide') ? false : true;
            if (CAPTCHA_STATUS) {
                $('#imgCaptcha').click();
            }
        }
    };

    return Login;
});