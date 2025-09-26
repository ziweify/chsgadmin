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

        @if($layer == 1)
        var lotterys = '{{$lotterysstr}}';
        @endif
        function FollowCountReset(a) {
            $.ajax({
                url: "FollowCountReset",
                type: "POST",
                loading: true,
                data: {
                    username: a
                },
                success: function (b) {
                    if (b.success) {
                        alert("成功重置跟投禁用次数。");
                        $("#followCountReset").html("0")
                    } else {
                        alert(b.message)
                    }
                }, error: function () {
                    alert("error")
                }
            })
        }
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
            <input name="type" type="hidden" value="2"/>
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
                    <th>{{$layername}}账号</th>
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
                    <th>{{$layername}}名称</th>
                    <td><input name="name" value="{{isset($user) ? $user['name'] : ''}}" class="input"/></td>
                </tr>
                <tr>
                    <th>绑定登录 IP</th>
                    <td><input name="ipFilter" class="input" value="{{isset($user) ? $user['ipfilter'] : ''}}"/></td>
                </tr>
                <tr>
                    <th>快开彩额度</th>
                    @if($layer == 1)
                        @if($isupdate)
                            <td class="input_panel account">
                                <span>{{$user['kmoney']}}
                                @if($user['kmoney'] > 0)
                                    <span class="dx">{{numbertodaxie($user['kmoney'])}}</span>
                                @endif
                               <a userid="{{$user['username']}}" type="0">修改</a></span>
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
                @if($plat_tax_status == 1 && $ftax_status == 1)
                    <tr>
                        <th>开放{{$tax_name}}</th>
                        <td>
                            @if($isupdate)
                                <label><input @if($user['tax_status']==1)checked="checked" @endif type="radio" name="tax_status" value="1"/>开放</label>
                                <label><input @if($user['tax_status']==0)checked="checked" @endif type="radio" name="tax_status" value="0" />关闭</label>
                            @else
                                <label><input type="radio" name="tax_status" value="1"/>开放</label>
                                <label><input type="radio" name="tax_status" value="0" checked="checked" />关闭</label>
                            @endif
                        </td>
                    </tr>
                    {{--<tr>
                        <th>{{$tax_name}}显示比例</th>
                        <td>
                            @if($isupdate)
                                <input name="tax_scale" value="{{isset($user) ? $user['tax_scale'] : 1}}" class="input"/>
                            @else
                                <input name="tax_scale" value="1" class="input"/>
                            @endif
                            0-1之间
                        </td>
                    </tr>--}}
                @endif
                @if($plat_water_status == 1 && $fwater_status == 1)
                    <tr>
                        <th>开放{{$water_name}}</th>
                        <td>
                            @if($isupdate)
                                <label><input @if($user['water_status']==1)checked="checked" @endif type="radio" name="water_status" value="1"/>开放</label>
                                <label><input @if($user['water_status']==0)checked="checked" @endif type="radio" name="water_status" value="0" />关闭</label>
                            @else
                                <label><input type="radio" name="water_status" value="1"/>开放</label>
                                <label><input type="radio" name="water_status" value="0" checked="checked" />关闭</label>
                            @endif
                        </td>
                    </tr>
                    {{--<tr>
                        <th>{{$water_name}}比例</th>
                        <td>
                            @if($isupdate)
                                <input name="water_scale" value="{{isset($user) ? $user['water_scale'] : 1}}" class="input"/>
                            @else
                                <input name="water_scale" value="1" class="input"/>
                            @endif
                            0-1之间
                        </td>
                    </tr>--}}
                @endif
                @if($plat_outbet_status == 1 && $foutbet_status == 1)
                <tr>
                    <th>开放{{$outbet_name}}</th>
                    <td>
                        @if($isupdate)
                            <label><input @if($user['outbet_status']==1)checked="checked" @endif type="radio" name="outbet_status" value="1"/>开放</label>
                            <label><input @if($user['outbet_status']==0)checked="checked" @endif type="radio" name="outbet_status" value="0" />关闭</label>
                        @else
                            <label><input type="radio" name="outbet_status" value="1"/>开放</label>
                            <label><input type="radio" name="outbet_status" value="0" checked="checked" />关闭</label>
                        @endif
                    </td>
                </tr>
                @endif
                @if($layer == 1)
                <tr>
                    <th>额度模式</th>
                    <td>
                        @if($isupdate==false)
                            <label><input type="radio" name="resetType" value="0" checked="checked" />信用模式</label>
                            <label><input type="radio" name="resetType" value="2" />现金模式</label>
                        @else
                            @if($user['fudong']==0)<label>信用模式</label>@endif
                            @if($user['fudong']==1)<label>现金模式</label>@endif
                        @endif
                    </td>
                </tr>
                @endif
                @if($isupdate)
                <tr>
                    <th>二次验证</th>
                    @if($user['google_open']==0)
                    <td>未绑定</td>
                    @else
                    <td><div style="color:#62bd12;">已启动<input name="passname" type="hidden" value="{{$user['username']}}"><input name="id" type="hidden" value="{{$user['userid']}}"><input type="button" value="重置" onclick="resetProp(5);"></div></td>
                    @endif
                </tr>
                @endif
                @if($isupdate && $isopenbankatm==1)
                <tr>
                    <th>操作密码</th>
                    @if(empty($user['moneypass']))
                        <td>未绑定</td>
                    @else
                        <td>
                            <div>已绑定
                                <input type="button" value="重置" onclick="openResetTransferPasswordDialog('{{$user['username']}}', true);">
                            </div>
                        </td>
                    @endif
                </tr>
                @endif
                <tr>
                    <th>开放盘口</th>
                    <td class="shareControl">
                        @foreach($pans as $vo)
                            @if($isupdate)
                            <label><input @if($isbet == 1)disabled @endif @if(in_array($vo,$pan))checked @endif value="{{$vo}}" type="checkbox" name="range" value="{{$vo}}" />{{$vo}}盘</label>
                            @else
                            <label><input value="{{$vo}}" type="checkbox" name="range" value="{{$vo}}" />{{$vo}}盘</label>
                            @endif
                        @endforeach
                    </td>
                </tr>
                @if($isupdate && $user['ifagent'] == 1 && in_array('agent.follow',$auths))
                    <tr class=""><th>重置跟投禁用</th>
                        <td class="input_panel">
                            <span id="followCountReset">{{$user['followerrors']}}</span>
                            <a href="javascript:FollowCountReset('{{$user['username']}}')">重置</a>
                        </td>
                    </tr>
                @endif
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
                @if($layer == 1)
                <tr>
                    <th>可玩彩种</th>
                    <td id="lotterys">
                        <input name="lotterys" type="hidden"
                               value="{{$lotterykeys}}">
                        <input type="button" value="设置"/> <span></span></td>
                </tr>
                <tr style="display: none">
                    <th>可玩彩种 - 棋牌类</th>
                    <td><label><input type="radio" name="productGame" value="true"
                            />开放</label>
                        <label><input type="radio" name="productGame" value="false" checked="checked"
                            />关闭</label>
                    </td>
                </tr>
                <tr>
                    <th>开放盘口设置</th>
                    <td>
                        @if($isupdate)
                            <label><input @if($user['ifexe']==1)checked="checked" @endif type="radio" name="odds" value="true"/>开放</label>
                            <label><input @if($user['ifexe']==0)checked="checked" @endif type="radio" name="odds" value="false" />关闭</label>
                        @else
                            <label><input type="radio" name="odds" value="true"/>开放</label>
                            <label><input type="radio" name="odds" value="false" checked="checked" />关闭</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>占成模式</th>
                    <td id="sharemode">
                        @if($isupdate)
                        <label><input @if($user['zcobj']==0)checked="checked" @endif type="radio" name="shareMode" value="0"/>默认模式</label>
                        <label><input @if($user['zcobj']==1)checked="checked" @endif type="radio" name="shareMode" value="1" />皇冠模式</label>
                        @else
                        <label><input type="radio" name="shareMode" value="0" checked="checked" />默认模式</label>
                        <label><input type="radio" name="shareMode" value="1" />皇冠模式</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>补货占成模式</th>
                    <td id="backmode">
                        @if($isupdate)
                        <label><input @if($user['backmode']==0)checked="checked" @endif type="radio" name="backMode" value="0" />按成分配</label>
                        <label><input @if($user['backmode']==1)checked="checked" @endif type="radio" name="backMode" value="1" />直补公司</label>
                        <label><input @if($user['backmode']==2)checked="checked" @endif type="radio" name="backMode" value="2" />上级全占</label>
                        @else
                            <label><input type="radio" name="backMode" value="0" checked="checked"/>按成分配</label>
                            <label><input type="radio" name="backMode" value="1" />直补公司</label>
                            <label><input type="radio" name="backMode" value="2" />上级全占</label>
                        @endif
                    </td>
                </tr>
                @endif
                </tbody>
            </table>
        </form>
        <table class="list data_table info_table share_panel input_panel">
            <thead>
            <tr>
                <th colspan="8" class="shareMode0" style="">占成设置 - 默认模式</th>
                <th colspan="8" class="shareMode1" style="display: none;">占成设置 - 皇冠模式</th>
            </tr>
            <tr class="shead">
                <th rowspan="2" class="shareMode0 shareMode1" style="display: table-cell;">类型</th>
                <th rowspan="2" class="shareMode0 shareMode1" style="display: table-cell;">{{$flayername}}<span class="shareMode0" style="">最高</span>占成</th>
                <th colspan="2" class="shareMode0 shareMode1" style="">{{$layername}}占成</th>
                {{--<th colspan="1" class="shareMode1" style="display: none;">{{$layername}}占成</th>
                <th colspan="1" class="shareMode1" style="display: none;">占成条件</th>--}}
                <th rowspan="2" class="shareMode1" style="display: none;">剩余占成</th>
                <th rowspan="2" class="shareMode0 shareMode1" style="display: table-cell;">开放补货</th>
            </tr>
            <tr class="shead">
                <th class="shareMode0 shareMode1" style="">最低 (%)</th>
                <th class="shareMode0 shareMode1" style="">最高 (%)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gamecs as $vo)
            <tr class="">
                <th>@if(isset($vo['ordercount']) && $vo['ordercount'] > 0)<span>【预设】</span>@endif{{$vo['typename']}}
                    种
                </th>
                <td class="shareMode0 shareMode1" style="">
                    @if(isset($vo['ordercount']) && $vo['ordercount'] > 0)
                        <span class="current">{{$vo['uupzcback']}}</span>
                    @endif
                    <input name="shares.{{$vo['typeid']}}.maxPshare" class="share" onchange="showValidateMsg((this.value!=''&&this.value<={{$vo['zc']}}&&this.value>={{$isupdate ? $vo['zcmin'] : $vo['zcmin']}}),'#shares_{{$vo['typeid']}}_maxPshare_msg','');" value="{{$isupdate ? $vo['uupzc'] : $vo['zcmin']}}" max="{{$vo['zc']}}" min="{{$isupdate ? $vo['uupzc'] : $vo['zcmin']}}"> %  ({{$vo['zcmin']}}% 至 {{$vo['zc']}}%)<span id="shares_{{$vo['typeid']}}_maxPshare_msg"></span>
                </td>
                {{--<td class="shareMode1" style="display: none;">
                    <input name="shares.{{$vo['typeid']}}.minPshare" class="share" onchange="showValidateMsg((this.value!=''&&this.value<=100),'#shares_{{$vo['typeid']}}_maxPshare_msg','');" value="" max="100" min="0"> %  <span id="shares_{{$vo['typeid']}}_maxPshare_msg"></span>
                </td>--}}
                <td class="shareMode0 shareMode1" style="">
                    @if(isset($vo['ordercount']) && $vo['ordercount'] > 0)
                        <span class="current">{{$vo['uzcminback']}}</span>
                    @endif
                    <input name="shares.{{$vo['typeid']}}.minShare" class="share" onchange="showValidateMsg((this.value!=''&&this.value<={{$vo['zc']}}),'#shares_{{$vo['typeid']}}_minShare_msg','');" value="{{$isupdate ? $vo['uzcmin'] : 0}}" max="{{$vo['zc']}}" min="0">%<span id="shares_{{$vo['typeid']}}_minShare_msg"></span>
                </td>
                <td class="shareMode0 shareMode1" style="display: table-cell;">
                    @if(isset($vo['ordercount']) && $vo['ordercount'] > 0)
                        <span class="current">{{$vo['uzcback']}}</span>
                    @endif
                    <input name="shares.{{$vo['typeid']}}.maxShare" class="share" onchange="showValidateMsg((this.value!=''&&this.value<={{$vo['zc']}}),'#shares_{{$vo['typeid']}}_maxShare_msg','');" value="{{$isupdate ? $vo['uzc'] : 0}}" required="" min="0" max="{{$vo['zc']}}"><span class="shareMode0" style="">% (最大 {{$vo['zc']}}%)</span><span class="shareMode1" style="display: none;">%</span><span id="shares_{{$vo['typeid']}}_maxShare_msg"></span>
                </td>
                {{--<td class="shareMode1" style=" display: none;">
                    (100% 至 100%)
                </td>--}}
                <td class="shareMode1" style="display: none;">
                    <label><input type="radio" name="shares.{{$vo['typeid']}}.allocateMode" value="0" checked="checked"> 归一级代理</label>
                    <label><input type="radio" name="shares.{{$vo['typeid']}}.allocateMode" value="1"> 归总公司</label>
                    <label><input type="radio" name="shares.{{$vo['typeid']}}.allocateMode" disabled="" value="2"> 管理员分配</label>
                </td>
                <td class="shareMode0 shareMode1" style="display: table-cell;">
                    @if($isupdate)
                    <label><input @disabled($vo['flytype'] == 0) @if($vo['uflytype']==1)checked="checked" @endif type="radio" name="shares.{{$vo['typeid']}}.canBack" value="true">开放</label>
                    <label><input @disabled($vo['flytype'] == 0) @if($vo['uflytype']==0)checked="checked" @endif type="radio" name="shares.{{$vo['typeid']}}.canBack" value="false">禁止</label>
                    @else
                    <label><input @disabled($vo['flytype'] == 0) type="radio" name="shares.{{$vo['typeid']}}.canBack" value="true" checked="checked">开放</label>
                    <label><input @disabled($vo['flytype'] == 0) type="radio" name="shares.{{$vo['typeid']}}.canBack" value="false">禁止</label>
                    @endif
                </td>
                <input name="shares.{{$vo['typeid']}}.lottery" type="hidden" value="0">
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
