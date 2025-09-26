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
        @if($type == 2)
        var lotterys = '{{$lotterysstr}}';
        @endif

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
        $(document).ready(function() {
            $('#avatar').on('change', function(e) {
                var formData = new FormData();
                formData.append('avatar', $('#avatar')[0].files[0]);
                $.ajax({
                    url: '/agent/uploadimg',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.code == 200) {
                            $("input[name='avatar']").val(res.data);
                        }else{
                            alert('上传失败，请重新上传！');
                        }
                    }
                });
            });
        });

        // 添加天数功能
        function addDays(inputName, days) {
            var input = $('input[name="' + inputName + '"]');
            var currentValue = input.val();
            var currentDate;
            
            if (currentValue === '' || currentValue === '0') {
                // 如果当前值为空或0，使用当前时间
                currentDate = new Date();
            } else {
                // 解析当前日期
                if (currentValue.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    // YYYY-MM-DD 格式
                    currentDate = new Date(currentValue);
                } else if (currentValue.match(/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/)) {
                    // YYYY-MM-DD HH:MM:SS 格式
                    currentDate = new Date(currentValue);
                } else {
                    // 其他格式或无效，使用当前时间
                    currentDate = new Date();
                }
            }
            
            // 添加天数
            currentDate.setDate(currentDate.getDate() + days);
            
            // 格式化日期为 YYYY-MM-DD HH:MM:SS
            var year = currentDate.getFullYear();
            var month = String(currentDate.getMonth() + 1).padStart(2, '0');
            var day = String(currentDate.getDate()).padStart(2, '0');
            var hours = String(currentDate.getHours()).padStart(2, '0');
            var minutes = String(currentDate.getMinutes()).padStart(2, '0');
            var seconds = String(currentDate.getSeconds()).padStart(2, '0');
            
            var newValue = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
            input.val(newValue);
        }

        // 自定义添加天数功能
        function addCustomDays(inputName) {
            var customDays = prompt('请输入要添加的天数:', '1');
            if (customDays !== null && customDays !== '') {
                var days = parseInt(customDays);
                if (!isNaN(days) && days > 0) {
                    addDays(inputName, days);
                } else {
                    alert('请输入有效的天数（大于0的整数）！');
                }
            }
        }
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        @if($isupdate==false)
            <span class="title">房主-&gt; 新增</span>
        @else
            <span class="title">房主
            <span>{{$userreg['username']}}@if($userreg['name']!='')（{{$userreg['name']}}）@endif</span> -&gt; 更改</span>
        @endif
        <span class="right"><a class="back" onclick="back()">返回</a></span>
    </div>
    @if($isupdate)
    <ul class="tab">
        <li class="tab_title02">
            <a href="/agent/user/edit?username={{$userreg['username']}}" class="selected">基本资料</a>
            <a href="/agent/user/param?username={{$userreg['username']}}">退水设定</a>
        </li>
    </ul>
    @endif
    <div class="contents" id="saveForm">
        <form id="formUser">
            <input name="type" type="hidden" value="2"/>
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
                    <th>头像</th>
                    @if($isupdate==false)
                        <td>
                            <input id="avatar" accept="image/*" type="file">
                            <input type="hidden" name="avatar" />
                        </td>
                    @else
                        <td><input type="file"></td>
                    @endif
                </tr>
                <tr>
                    <th>房主账号</th>
                    @if($isupdate==false)
                    <td><input name="username" class="username"/><span id="usernameMsg"></span></td>
                    @else
                        <td>{{$userreg['username']}}<input name="username" type="hidden" value="{{$userreg['username']}}"><span class="statusControl">【
                                <label><input type="radio" name="status" value="0" @if($userreg['status']==0)checked="checked" @endif>启用</label>
                        <label><input type="radio" name="status" value="1" @if($userreg['status']==1)checked="checked" @endif>冻结</label>
                        <label><input type="radio" name="status" value="2" @if($userreg['status']==2)checked="checked" @endif>停用</label>
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
                        <a href="javascript:loginRetryCountReset('{{$userreg['username']}}')">重置</a>
                    </td>
                </tr>
                @endif
                <!--房间状态-->
                <tr>
                    <th>房间状态</th>
                    <td>
                        <label><input type="radio" name="roomStatus" value="1" @if((($isupdate && $userroom['roomStatus']) || $isupdate==false))checked="checked" @endif>启用</label>
                        <label><input type="radio" name="roomStatus" value="0" @if($isupdate && $userroom['roomStatus']==0)checked="checked" @endif>停用</label>
                    </td>
                </tr>
                <tr>
                    <th>绑定登录 IP</th>
                    <td><input name="ipFilter" class="input" value="{{$isupdate ? $userreg['ipfilter'] : ''}}"/></td>
                </tr>
                <tr>
                    <th>房间名称</th>
                    <td><input name="roomName" value="{{$isupdate ? $userroom['roomName'] : ''}}" class="input"/></td>
                </tr>
                <tr>
                    <th>聊天昵称</th>
                    <td><input name="roomNickname" value="{{$isupdate ? $userroom['roomNickname'] : '群主'}}" class="input"/></td>
                </tr>
                <tr>
                    <th>房间号</th>
                    @if($isupdate)
                        <td><input name="roomid" class="input" placeholder="留空自动生成" type="text" value="{{$userroom['roomid']}}"></td>
                    @else
                        <td><input name="roomid" class="input" placeholder="留空自动生成" type="text" value=""></td>
                    @endif
                </tr>
                <tr>
                    <th>房间到期时间</th>
                    <td>
                        <input style="width: 160px;" name="expiryDate" value="{{$isupdate ? $userroom['expiryDate'] : $expiryDate}}" class="input"/>
                        <input type="button" value="+1天" onclick="addDays('expiryDate', 1)"/>
                        <input type="button" value="+30天" onclick="addDays('expiryDate', 30)"/>
                        <input type="button" value="自定义" onclick="addCustomDays('expiryDate')"/>
                    </td>
                </tr>
                <tr>
                    <th>飞单到期时间</th>
                    <td>
                        <input style="width: 160px;" name="outbet_overtime" value="{{$isupdate ? $userroom['outbet_overtime'] : 0}}" class="input"/>
                        <input type="button" value="+1天" onclick="addDays('outbet_overtime', 1)"/>
                        <input type="button" value="+30天" onclick="addDays('outbet_overtime', 30)"/>
                        <input type="button" value="自定义" onclick="addCustomDays('outbet_overtime')"/>
                    </td>
                </tr>
                {{-- <tr>
                    <th>开放赚点</th>
                    <td>
                        @if($isupdate)
                            <label><input @if($userroom['tax_status']==1)checked="checked" @endif type="radio" name="tax_status" value="1"/>开放</label>
                            <label><input @if($userroom['tax_status']==0)checked="checked" @endif type="radio" name="tax_status" value="0" />关闭</label>
                        @else
                            <label><input type="radio" name="tax_status" value="1"/>开放</label>
                            <label><input type="radio" name="tax_status" value="0" checked="checked" />关闭</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>开放飞单</th>
                    <td>
                        @if($isupdate)
                            <label><input @if($userroom['outbet_status']==1)checked="checked" @endif type="radio" name="outbet_status" value="1"/>开放</label>
                            <label><input @if($userroom['outbet_status']==0)checked="checked" @endif type="radio" name="outbet_status" value="0" />关闭</label>
                        @else
                            <label><input type="radio" name="outbet_status" value="1"/>开放</label>
                            <label><input type="radio" name="outbet_status" value="0" checked="checked" />关闭</label>
                        @endif
                    </td>
                </tr> --}}
                <tr>
                    <th>授权飞单服务器IP</th>
                    <td><input name="auth_outbet_ip" class="input" value="{{$isupdate ? $userroom['auth_outbet_ip'] : $server_ip}}"/></td>
                </tr>
                @if(in_array('order.znmodify',$auths))
                <tr>
                    <th>自定义IP</th>
                    <td>
                        <input name="ipcustom" value="{{$isupdate ? $userreg['ipcustom'] : ''}}" class="input"/>
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
                        位置：<span id="address">{{$isupdate ? $userreg['ipaddress'] : ''}}</span>
                    </td>
                </tr>
                @endif
                @if($isupdate == 1)
                <tr>
                    <th>二次验证</th>
                    @if($userreg['google_open']==0)
                    <td>未绑定</td>
                    @else
                    <td><div style="color:#62bd12;">已启动<input name="passname" type="hidden" value="{{$userreg['username']}}"><input name="id" type="hidden" value="{{$userreg['userid']}}"><input type="button" value="重置" onclick="resetProp(5);"></div></td>
                    @endif
                </tr>
                @endif
                <tr>
                    <th>可玩彩种</th>
                    <td id="lotterys">
                        <input name="lotterys" type="hidden"
                               value="{{$lotterykeys}}">
                        <input type="button" value="设置"/> <span></span></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class="data_footer control"><input type="button" value="确定" onclick="saveUser()" class="button"/> <input
            type="button" value="取消" onclick="back()" class="button"/></div>
</div>
</body>
</html>
