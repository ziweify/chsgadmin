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
    <script type="text/javascript" src="/default/js/user.js?v2"></script>
    <script type="text/javascript" src="/default/js/password.js?v2"></script>
    <script type="text/javascript">
        var isupdate = {{ var_export($isupdate, true) }};
        var needNewTransferPassword = {{$needNewTransferPassword}};
        var isAddUser = '{{$isAddUser}}';
        var transferPasswordIPEnabled = '{{$transferPasswordIPEnabled}}';
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        @if($isupdate==false)
        <span class="title">{{$layername}}
                 -&gt; 新增</span>
        @else
        <span class="title">{{$layername}}
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
                    <th>{{$flayername}}账号</th>
                    <td>{{$parent}}<input type="hidden" name="parent" value="{{$parent}}"/></td>
                </tr>
                <tr>
                    <th>会员账号</th>
                    @if($isupdate==false)
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
                            <span id="loginRetryCount">{{$user['errortimes']}}</span>
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
                    <th>快开彩额度</th>
                    @if($layer == 1)
                        @if($isupdate)
                            <td class="input_panel account">
                                <span>
                                    {{$user['kmoney']}}
                                    @if($user['kmoney'] > 0)
                                    <span class="dx">{{numbertodaxie($user['kmoney'])}}</span>
                                    @endif
                                    <a userid="{{$user['username']}}" type="0">修改</a>
                                </span>
                            </td>
                        @else
                            <td class="input_panel account">
                                <input name="account.0.maxLimit" value="0" class="account" />
                                <span id="dx0" class="dx"></span>
                            </td>
                        @endif
                    @else
                        @if($isupdate)
                            <td class="input_panel account">
                                <span>{{$user['kmoney']}}<span class="dx">{{numbertodaxie($user['kmoney'])}}</span> <a userid="{{$user['username']}}" type="0">修改</a></span></td>
                        @else
                            <td class="input_panel account">
                                <input name="account.0.maxLimit" value="0" class="account" onchange="showValidateMsg((this.value!=''&amp;&amp; this.value<={{$kmaxmoney}}),'#account_0_maxLimit_msg','');">
                                <span id="dx0" class="dx"></span>
                                <span id="account_0_maxLimit_msg"><em class="error"></em></span> (上级余额：{{$kmaxmoney}})
                            </td>
                        @endif
                    @endif
                </tr>
                <tr>
                    <th>开放盘口</th>
                    <td class="shareControl">
                        @foreach($pans as $key=>$vo)
                            @if($isupdate)
                                <label><input @if($isbet == 1)disabled @endif type="radio" name="range" value="{{$vo}}" @if(in_array($vo,$pan))checked="checked" @endif/>{{$vo}}盘</label>
                            @else
                                <label><input type="radio" name="range" value="{{$vo}}" @if($key==0)checked="checked" @endif/>{{$vo}}盘</label>
                            @endif
                        @endforeach
                    </td>
                </tr>
                @if($isupdate == false)
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
        <table class="list data_table info_table share_panel input_panel">
            <thead>
            <tr>
                <th colspan="3">占成设置</th>
            </tr>
            <tr>
                <td class="ft_ti te-ct">类型</td>
                <td class="ft_ti te-ct">代理占成</td>
                <td class="ft_ti te-ct">可分配占成</td>
            </tr>
            </thead>
            <tbody>
            @foreach($gamecs as $key=>$vo)
                <tr>
                    <th>@if(isset($vo['ordercount']) && $vo['ordercount'] > 0)<span>【预设】</span>@endif{{$vo['typename']}}
                        种
                    </th>
                    <td>
                        @if(isset($vo['ordercount']) && $vo['ordercount'] > 0)
                            <span class="current">{{$vo['uupzcback']}}</span>
                        @endif
                        <input name="shares.{{$vo['typeid']}}.maxPshare"
                               onchange="showValidateMsg((this.value!=''&&this.value<={{$vo['zc']}}&&this.value>={{$vo['zcmin']}}),'#shares_{{$vo['typeid']}}_minPshare','');"
                               value="{{$isupdate ? $vo['uupzc'] : $vo['zcmin']}}" class="share"/>%<span id="shares_{{$vo['typeid']}}_minPshare"></span></td>
                    <td>{{$vo['zcmin']}}~{{$vo['zc']}}%</td>
                    <input name="shares.{{$vo['typeid']}}.lottery" type="hidden" value="0"/>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(isset($ishasorder) && $ishasorder > 0)
            <div class="warning_panel">
                当前用户已下注，【预设】占成设置将在明天开盘前生效。
            </div>
        @endif
    </div>
    <div class="data_footer control"><input type="button" value="确定" onclick="saveUserValidateTransferPassword({{$bankatm}})" class="button"/> <input
            type="button" value="取消" onclick="back()" class="button"/></div>
</div>
</body>
</html>
