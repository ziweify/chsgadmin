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
    <link href="/default/css/agent/notices.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/factoryauthenication.js"></script>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/qrcode.js"></script>
    <script type="text/javascript" language="javascript">
        $(function () {
            var code = '{!! $codeurl !!}';
            var oQRCode = new QRCode("qrcode", {
                width: 200,
                height: 200
            });
            oQRCode.clear();
            oQRCode.makeCode(code);
        });
    </script>

    <style>
        #divLargerImage {
            display: none;
            width: 200px;
            height: 200px;
            position: absolute;
            left: 0;
            right: 0;
            margin: auto;
            z-index: 99;
        }

        #divOverlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #CCC;
            opacity: 0.6;
            width: 100%;
            height: 100%;
            z-index: 98;
        }
    </style>
</head>

<body>
<div class="main">
    <div class="top_info">
        <span class="title">二次验证</span>
    </div>
    <div class="contents">
        <table class="data_table info_table user_panel" style="width:50%;margin: 0 auto;">
            <thead>
            <tr>
                <th colspan="2">个人二次验证</th>
            </tr>
            </thead>
            <input name="id" type="hidden" value="{{$u1}}"/>
            <input name="passname" type="hidden" value="{{$username}}"/>
            <input name="secretkey" type="hidden" value="{{$secret}}"/>
            <tbody>
            @if($google_open == 0)
            <tr>
                <th>用途</th>
                <td>
                    通过二次验证（也称为双重身份验证），您可以为自己的帐号添加一道额外的安全保障。在完成设置后，您将使用以下对象通过两个步骤登录帐号：</br></br>
                    您的密码</br>
                    您设备上安装的Google认证器为您生成的二次验证码
                </td>
            </tr>
            <tr>
                <th>步骤</th>
                <td>
                    <div style="margin-top: 25px; color:red;font-weight: bold; padding:10px 0;margin: 0 auto;">
                        1.下载安装Google认证器 （Google Authenticator）客户端。<br/>
                        目前客户端有:
                        <a href="#"
                           onClick="showQrLink('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADIAQAAAACFI5MzAAABcUlEQVR42u2Xy43DMAxEKeSgo0pQJ3ZjBmLAjSWdqIQcdTDEHVL7s4McM8YuLMBG5HcZkMNPRF8dOclJ/gApInJRCY+r1lFn3BKb4FlUb2kpsSX8anRSBXcJFpO7LkWGQ0ipQbu248ggV2TqGOL5kfFx+cxUoxPzKLS5wPTkXgLpJzZEB0Z9ruD3kxL1IRlZmbMZFVc2URlkytYkMgKzSg10AjFzjre05ti2cSORos20BWDc1swnWoPlZ8QLDgH+rhIWKeiRyMqA8qheL8ImGm82s6DN8CTwCpsgOmiUA2RZpoATmRT5GhbqHv3RRiOuDfdVkKlNH2URKDJn4hNUAjc6gTOvfW772PhVwSzi1RlRKuhVXiqJTPzY5jBZv95MDBLpc1sxuKTvLiOd2MZS+txupu1OJ77DomFN1i1F4m6LphGMK6+SXIdjCF7wqMVJd9EhEM9PDb1XYZvdbtEM4h71NhVd6s697yfnv/eT/DfyAY/vd1PWIyp4AAAAAElFTkSuQmCC')"
                           style="color:blue;">android版</a> |
                        <a href="#"
                           onClick="showQrLink('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADIAQAAAACFI5MzAAABV0lEQVR42u2X4YrEIAyEA3ktIa8eyGsJ3kzsQo/l/jn3y+J2NV9BE8ektfXXZZdccomKpJnPmL7Sp3MgIoWWAxD/VT3WkPSaFukLdw6EJMcYNoI9KaGP08CUZG37CAT1K9bnCEVRn+tLO+fIvirh5baKCMZsAdQ7GCJCmSdjia0LdF1EZs8MKzk3UEQW3IMdD6ATVUtEkIig9RG9dcNCRehc7ZNlXImLSC8CDyBLMPnNEBGk7yeQMCKuS0S4gNZIdIr9tbaTZJeKRa3PwSYii1a663R3vhV/lLT+ujIlZfiK6FmCObGCmBS97YorIRn7vg/wO6JnCY6U8xT7pwqqyKLi8WNOfxKshNRurLNkJSIPhcfeolSRruh8e+yjnBYi0pN3kv2O9VHyzEua9q4Y50lVaxHUXEp2fcqo56ApSMN+a9hfFCJChTxBxRLmCBG535qXXPJv5Afgv60mTJNXEgAAAABJRU5ErkJggg==')"
                           style="color:blue;">iOS版</a><br/>
                        2.然后选择“扫描条形码”。
                    </div>
                    <div id="divLargerImage"></div>
                    <div id="divOverlay"></div>
                </td>
            </tr>
            <tr>
                <th>二维码</th>
                <td>
                    <div style="margin-top: 25px; color:red;font-weight: bold;text-align: center;">
                        3. 扫描以下二维码，再输入下方二次验证码完成认证。
                    </div>
                    <div id="qrpanel"
                         style="width: 300px; text-align:center;padding:10px 0;margin: 0 auto;position:relative; ">
                        <div id="qrcode"
                             style="width:200px;height:200px;margin:0 auto;overflow:hidden; text-align: center; border:1px solid #ddd;z-index:1; "></div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>二次验证码</th>
                <td><input type="number" name="faCode" placeholder="未绑定" min="0" maxlength="10"/></td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <div style="margin-top: 25px; color:red;font-weight: bold; padding:10px 0;margin: 0 auto;">
                        4.二次验证启用后，这时您也可以看到刚添加的二次验证已经出现在Google认证器里了。</br>
                        之后登录需要输入二次验证码的时候，打开Google认证器，把对应的验证码添到登录页面进行验证就可以了。
                    </div>
                </td>
            </tr>
            @else
            <tr>
                <th>二次验证码</th>
                <td style="color:#62bd12;">已启动 <input type="button" value="重置" onclick="resetProp(0);"></td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@if($google_open == 0)
<div class="data_footer control">
    <input type="button" value="确定" onclick="saveFaCode()" class="button"/>
</div>
@endif
</body>
</html>
