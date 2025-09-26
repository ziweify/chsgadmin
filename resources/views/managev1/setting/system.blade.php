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
    <link href="/default/css/agent/system.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/system.js?v=1211"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">公司 {{$username}} -&gt; 系统设置</span>
    </div>
    <div class="contents">
        <input id="username" type="hidden" value="{{$username}}"/>

        <table class="data_table info_table" id="configs">
            <tr class="head">
                <th colspan="2">系统设置</th>
            </tr>
            <tr>
                <th>平台开关</th>
                <td><label><input @if($config['ifopen'] == 1)checked @endif type="radio" name="ifopen" value="1"/>开启</label>
                    <label><input @if($config['ifopen'] == 0)checked @endif type="radio" name="ifopen" value="0"/>关闭</label>
                </td>
            </tr>
            {{-- <tr>
                <th>最低投注额</th>
                <td><input name="minje" value="{{$config['minje']}}"/></td>
            </tr> --}}
            <tr>
                <th>密码使用期限（天）</th>
                <td><input name="passtime" value="{{$config['passtime']}}"/></td>
            </tr>
            <tr>
                <th>登录停留（分钟）</th>
                <td><input name="livetime" value="{{$config['livetime']}}"/></td>
            </tr>
            {{-- <tr>
                <th>自动清除停用账号（天）</th>
                <td><input name="clear_account_day" value="{{$config['clear_account_day']}}"/><span
                        class="msg">停用账号及下线的额度为0才会自动清除</span></td>
            </tr> --}}
            <tr>
                <th>保留多少天登录日志（天）</th>
                <td><input name="autodellogintime" value="{{$config['autodellogintime']}}"/></td>
            </tr>
            <tr>
                <th>保留多少天操作日志（天）</th>
                <td><input name="autodeledittime" value="{{$config['autodeledittime']}}"/><span class="msg">包括修改记录、资金记录</span></td>
            </tr>
            <tr>
                <th>保留多少天聊天记录（天）</th>
                <td><input name="autodelchsgtime" value="{{$config['autodelchsgtime']}}"/></td>
            </tr>
            <tr>
                <th>保留多少天其他日志（天）</th>
                <td><input name="autodelothertime" value="{{$config['autodelothertime']}}"/><span class="msg">包括报表、开奖、下注记录</span></td>
            </tr>
            <tr>
                <th>平台名称</th>
                <td><input name="webname" value="{{$config['webname']}}" /></td>
            </tr>
            <tr>
                <th>全国开奖网</th>
                <td><input name="kjwurl" value="{{$config['kjwurl']}}"/></td>
            </tr>
            <tr>
                <th>赚点自定义名称</th>
                <td><input name="tax_name" value="{{$config['tax_name']}}" /></td>
            </tr>
            <tr>
                <th>飞单自定义名称</th>
                <td><input name="outbet_name" value="{{$config['outbet_name']}}" /></td>
            </tr>
            <tr><th>启用跟单</th>
                <td>
                    <label><input @if($config['planenable'] == 1)checked @endif type="radio" name="planenable" value="1">开启</label>
                    <label><input @if($config['planenable'] == 0)checked @endif type="radio" name="planenable" value="0">关闭</label>
                </td>
            </tr>
            <tr>
                <th>额度效验&nbsp;</th>
                <td>&nbsp;<input type="button" value="额度校检" onclick="jioayan()"></td>
            </tr>
            <tr>
                <th>全清数据&nbsp;</th>
                <td>&nbsp;<input type="button" value="全清数据" onclick="clearalldara()"><input style="margin-left: 5px;" type="button" value="复盘ftime" onclick="resetftime()"></td>
            </tr>
            <tr>
                <th>超级密码</th>
                <td><input name="supass" value="{{$config['supass']}}"/></td>
            </tr>
            <tr><th>赚点开关</th>
                <td>
                    <label><input @if($config['plat_tax_status'] == 1)checked @endif type="radio" name="plat_tax_status" value="1">开启</label>
                    <label><input @if($config['plat_tax_status'] == 0)checked @endif type="radio" name="plat_tax_status" value="0">关闭</label>
                </td>
            </tr>
            <tr><th>飞单开关</th>
                <td>
                    <label><input @if($config['plat_outbet_status'] == 1)checked @endif type="radio" name="plat_outbet_status" value="1">开启</label>
                    <label><input @if($config['plat_outbet_status'] == 0)checked @endif type="radio" name="plat_outbet_status" value="0">关闭</label>
                </td>
            </tr>
            <tr>
                <th>每天可以试用飞单次数</th>
                <td><input name="outbet_sy_count" value="{{$config['outbet_sy_count']}}"/></td>
            </tr>
            <tr>
                <th>每次试用时间（分钟）</th>
                <td><input name="outbet_sy_time" value="{{$config['outbet_sy_time']}}"/></td>
            </tr>
            <tr>
                <th>开通飞单的一天价格</th>
                <td><input name="outbet_money1" value="{{$config['outbet_money1']}}"/></td>
            </tr>
            <tr>
                <th>开通飞单的一个月价格</th>
                <td><input name="outbet_money2" value="{{$config['outbet_money2']}}"/></td>
            </tr>
            <tr>
                <th>会员端URL</th>
                <td><input style="width: 400px;" name="mem_url" value="{{$config['mem_url']}}"/></td>
            </tr>
            <tr><th>是否开放会员自助注册</th>
                <td>
                    <label><input @if($config['open_register'] == 1)checked @endif type="radio" name="open_register" value="1">开放</label>
                    <label><input @if($config['open_register'] == 0)checked @endif type="radio" name="open_register" value="0">关闭</label>
                </td>
            </tr>
            <tr><th>聊天室分页模式</th>
                <td>
                    <label><input @if($config['gameChatPageMode'] == 1)checked @endif type="radio" name="gameChatPageMode" value="1">redis固定缓存条数</label>
                    <label><input @if($config['gameChatPageMode'] == 2)checked @endif type="radio" name="gameChatPageMode" value="2">mysql分页</label>
                </td>
            </tr>
            <tr><th>在线客服聊天分页模式</th>
                <td>
                    <label><input @if($config['custChatPageMode'] == 1)checked @endif type="radio" name="custChatPageMode" value="1">redis固定缓存条数</label>
                    <label><input @if($config['custChatPageMode'] == 2)checked @endif type="radio" name="custChatPageMode" value="2">mysql分页</label>
                </td>
            </tr>
            <tr>
                <th>维护时间</th>
                <td><input name="editstart" value="{{$config['editstart']}}"/>-<input name="editend" value="{{$config['editend']}}"/></td>
            </tr>
            <tr>
                <th>聊天图片域名</th>
                <td><input style="width: 400px;" name="chatImageDomain" value="{{$config['chatImageDomain']}}"/></td>
            </tr>
            <tr><th>聊天图片上传模式</th>
                <td>
                    <label><input @if($config['chatImageUploadMode'] == 'oss')checked @endif type="radio" name="chatImageUploadMode" value="oss">阿里云OSS</label>
                    <label><input @if($config['chatImageUploadMode'] == 'local')checked @endif type="radio" name="chatImageUploadMode" value="local">本地服务器</label>
                </td>
            </tr>
            <tr>
                <th>头像图片域名</th>
                <td><input style="width: 400px;" name="headImageDomain" value="{{$config['headImageDomain']}}"/></td>
            </tr>
            <tr><th>头像图片上传模式</th>
                <td>
                    <label><input @if($config['headImageUploadMode'] == 'oss')checked @endif type="radio" name="headImageUploadMode" value="oss">阿里云OSS</label>
                    <label><input @if($config['headImageUploadMode'] == 'local')checked @endif type="radio" name="headImageUploadMode" value="local">本地服务器</label>
                </td>
            </tr>

            <tr>
                <th>开奖图片域名</th>
                <td><input style="width: 400px;" name="openImageDomain" value="{{$config['openImageDomain']}}"/></td>
            </tr>
            <tr><th>开奖图片上传模式</th>
                <td>
                    <label><input @if($config['openImageUploadMode'] == 'oss')checked @endif type="radio" name="openImageUploadMode" value="oss">阿里云OSS</label>
                    <label><input @if($config['openImageUploadMode'] == 'local')checked @endif type="radio" name="openImageUploadMode" value="local">本地服务器</label>
                </td>
            </tr>

            <tr>
                <th>apk上传域名</th>
                <td><input style="width: 400px;" name="apkDomain" value="{{$config['apkDomain']}}"/></td>
            </tr>
            <tr><th>apk上传模式</th>
                <td>
                    <label><input @if($config['apkUploadMode'] == 'oss')checked @endif type="radio" name="apkUploadMode" value="oss">阿里云OSS</label>
                    <label><input @if($config['apkUploadMode'] == 'local')checked @endif type="radio" name="apkUploadMode" value="local">本地服务器</label>
                </td>
            </tr>
        </table>
    </div>
    <div class="data_footer control">
        <input type="button" value="确定" onclick="saveSetting()" class="button"/> <input type="button" value="取消"
                                                                                          onclick="back()"
                                                                                          class="button"/>
    </div>
</div>
<script>
    function getbtdata(){
        $.ajax({
            url: "/agent/system/getbtdata",
            type: "GET",
            data: {},
            loading: !0,
            success: function (e) {
                alert(e.message);
                if(e.success){
                    location.reload();
                }
            },
            error: function () {
                alert("网络错误，请稍后重试")
            }
        })
    }
</script>
</body>
</html>
