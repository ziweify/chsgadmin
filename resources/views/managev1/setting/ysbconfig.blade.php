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
    <script>
        function saveanquanma() {
            //再次确认
            if (!confirm("确定要保存吗？")) {
                return;
            }
            var anquanma = $("#anquanma").val();
            var anquanmagl = $("#anquanmagl").val();
            var iskjw = $("#iskjw").is(':checked') ? 1 : 0;
            var isip = $("#isip").is(':checked') ? 1 : 0;
            var webname = $("#webname").val();
            $.ajax({
                url: "/agent/ysbconfig/saveanquanma",
                type: "POST",
                data: {anquanma:anquanma,anquanmagl:anquanmagl,iskjw:iskjw,webname:webname,isip:isip},
                loading: !0,
                success: function (e) {
                    alert(e.message);
                },
                error: function () {
                    alert("网络错误，请稍后重试")
                }
            })
        }
        function suijianquanma(id) {
            var text = "";
            var possible1 = "0123456789";
            var possible2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            for (var i = 0; i < 6; i++) {
                text += possible1.charAt(Math.floor(Math.random() * possible1.length));
            }
            for (var i = 0; i < 2; i++) {
                text += possible2.charAt(Math.floor(Math.random() * possible2.length));
            }
            $("#"+id).val(text);
        }
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">138导航配置</span>
    </div>
    <div class="contents" style="">
        <table class="data_table list">
            <thead>
            <tr>
                <th align="center" colspan="4" style="color: #0b8fff;font-weight: bold;">138导航配置</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td align="center">
                    站点名称：<input id="webname" type="text" value="{{$webname}}" />
                    <input style="margin-left: 8px;" class="save" type="button" value="保存" onclick="saveanquanma()"/>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
