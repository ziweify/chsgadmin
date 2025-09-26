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
    <link href="/default/css/form_validate.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/user.js?v1"></script>
    <script type="text/javascript" src="/default/js/password.js"></script>
    <script type="text/javascript">
        var isupdate = {{$isupdate}};

        function create_randip(){
            var ipcity = $('#ipcity').val();
            $.ajax({
                url: '/agent/getip',
                type: 'get',
                dataType: 'json',
                data: {ipcity: ipcity},
                success: function (data) {
                    var ip = data.ip;
                    var address = data.address;
                    //赋值到属性name为ipcustom的input
                    $('input[name="ipcustom"]').val(ip);
                    $('#address').text(address);
                }
            });
        }
        function oncealertmsg(){
            var username = $('input[name="username"]').val();
            $.ajax({
                url: '/agent/user/oncealertmsg',
                type: 'post',
                dataType: 'json',
                data: {username: username},
                success: function (data) {
                    alert(data.message);
                }
            });
        }
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        @if($isupdate==false)
            <span class="title">新增</span>
        @else
            <span class="title">
            <span>{{$user['username']}}@if($user['name']!='')（{{$user['name']}}）@endif</span> -&gt; 更改</span>
        @endif
        <span class="right"><a class="back" onclick="back()">返回</a></span>
    </div>
    @if($isupdate)
        <ul class="tab">
            <li class="tab_title02">
                <a href="/agent/user/edit?username={{$user['username']}}" class="selected">基本资料</a>
                <a href="/agent/user/param?username={{$user['username']}}">退水设定</a>
            </li>
        </ul>
    @endif
    <div class="contents" id="saveForm">
        <form id="formUser">
            <input name="type" type="hidden" value="1"/>
            <table class="list data_table info_table user_panel">
                <thead>
                <tr>
                    <th colspan="2">账户资料</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>上级账号</th>
                    <td>{{$fusername}}<input type="hidden" name="parent" value="{{$parent}}"/><input type="hidden" name="ruid" value="{{$ruid}}"/></td>
                </tr>
                <tr>
                    <th>会员账号</th>
                    @if($isupdate==0)
                        <td><input maxlength="10" name="username" class="username"/><span id="usernameMsg"></span></td>
                    @else
                        <td>{{$user['username']}}<input name="username" type="hidden" value="{{$user['username']}}"><span class="statusControl">【
                                <label><input type="radio" name="status" value="0" @if($user['status']==0)checked="checked" @endif>启用</label>
                        <label><input type="radio" name="status" value="1" @if($user['status']==1)checked="checked" @endif>冻结</label>
                        <label><input type="radio" name="status" value="2" @if($user['status']==2)checked="checked" @endif>停用</label>
                    】</span></td>
                    @endif
                </tr>
                <tr>
                    <th>@if($isupdate)新密码@else登入密码@endif</th>
                    <td><input name="password" class="input"/></td>
                </tr>
                @if($isupdate)
                    <tr class=""><th>错误登录次数</th>
                        <td class="input_panel">
                            <span id="loginRetryCount">{{$userreg['errortimes']}}</span>
                            <a href="javascript:loginRetryCountReset('{{$user['username']}}')">重置</a>
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>会员名称</th>
                    <td><input name="name" value="{{isset($user) ? $user['name'] : ''}}" class="input"
                               onkeyup="value=value.replace(/[^\w\u4E00-\u9FA5]/g, '')"/></td>
                </tr>
                {{--<tr>
                    <th>绑定登录 IP</th>
                    <td><input name="ipFilter" class="input" value="{{isset($user) ? $user['ipfilter'] : ''}}"/></td>
                </tr>--}}
                <tr>
                    <th>每日盈利上限</th>
                    <td><input name="yingdeny" value="{{isset($user) ? $user['yingdeny'] : ''}}" class="input" /><span style="color: #ff0812">超过该值后无法下注，0无限制</span></td>
                </tr>
                <tr>
                    <th>快开彩额度</th>
                    @if($isupdate)
                        <td class="input_panel account">
                            <span>{{$user['kmoney']}}
                                @if($user['kmoney'] > 0)
                                    <span class="dx">{{numbertodaxie($user['kmoney'])}}</span>
                                @endif
                                <a userid="{{$user['username']}}" type="0">修改</a></span></td>
                    @else
                        <td class="input_panel account">
                            <input name="account.0.maxLimit" value="0" class="account" />
                            <span id="dx0" class="dx"></span>
                        </td>
                    @endif
                </tr>
                @if(in_array('order.znmodify',$auths))
                    <tr>
                        <th>自定义IP</th>
                        <td>
                            <input name="ipcustom" value="{{isset($user) ? $user['ipcustom'] : ''}}" class="input"/>
                            城市：<select id="ipcity">
                                <option value="">请选择</option>
                                <option value="guangzhou">广东=>广州市</option>
                                <option value="shenzhen">广东=>深圳市</option>
                                <option value="chaozhou">广东=>潮州市</option>
                                <option value="foshan">广东=>佛山市</option>
                                <option value="huizhou">广东=>惠州市</option>
                                <option value="jieyang">广东=>揭阳市</option>
                                <option value="meizhou">广东=>梅州市</option>
                                <option value="shantou">广东=>汕头市</option>
                                <option value="shanwei">广东=>汕尾市</option>
                                <option value="zhanjiang">广东=>湛江市</option>
                                <option value="zhuhai">广东=>珠海市</option>
                                <option value="fuzhou">福建=>福州市</option>
                                <option value="xiamen">福建=>厦门市</option>
                                <option value="putian">福建=>莆田市</option>
                                <option value="sanming">福建=>三明市</option>
                                <option value="quanzhou">福建=>泉州市</option>
                                <option value="zhangzhou">福建=>漳州市</option>
                                <option value="nanping">福建=>南平市</option>
                                <option value="longyan">福建=>龙岩市</option>
                                <option value="ningde">福建=>宁德市</option>
                                <option value="nanning">广西=>南宁市</option>
                                <option value="liuzhou">广西=>柳州市</option>
                                <option value="guilin">广西=>桂林市</option>
                                <option value="wuzhou">广西=>梧州市</option>
                                <option value="beihai">广西=>北海市</option>
                                <option value="yulin">广西=>玉林市</option>
                                <option value="baise">广西=>百色市</option>
                                <option value="xianggang">香港</option>
                                <option value="shanghai">上海市</option>
                            </select>
                            <input onclick="create_randip()" type="button" value="生成" />
                            位置：<span id="address">{{isset($user['ipaddress']) ? $user['ipaddress'] : ''}}</span>
                        </td>
                    </tr>
                @endif
                @if($isupdate == 0)
                <tr>
                    <th>赚取退水</th>
                    <td>
                        <select name="commission" class="commission">
                            <option value="0">水全退到底</option>
                            <option value="0.1">赚取 0.1% 退水</option>
                            <option value="0.3">赚取 0.3% 退水</option>
                            <option value="0.5">赚取 0.5% 退水</option>
                            <option value="1">赚取 1.0% 退水</option>
                            <option value="1.5">赚取 1.5% 退水</option>
                            <option value="2">赚取 2.0% 退水</option>
                            <option value="2.5">赚取 2.5% 退水</option>
                            <option value="100">赚取所有退水</option>
                        </select></td>
                </tr>
                @endif
                <input name='shareMode' type="hidden" value="0" readonly="readonly" disabled/>
                </tbody>
            </table>
        </form>
    </div>
    <div class="data_footer control"><input type="button" value="确定" onclick="saveUser()" class="button"/> <input
            type="button" value="取消" onclick="back()" class="button"/></div>
</div>
</body>
</html>
