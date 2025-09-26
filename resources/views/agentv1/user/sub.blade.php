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
    <script type="text/javascript" src="/js/json2.js"></script>
    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/sub.js?v=1"></script>
    <script type="text/javascript" src="/default/js/user.js"></script>
    <script type="text/javascript" src="/default/js/factoryauthenication.js"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">子帐号 -&gt; @if($isupdate)修改@else新增@endif</span>
    </div>
    <div class="contents">
        <form id="saveForm" action="">
            <table class="data_table info_table user_panel input_panel">
                <thead><tr><th colspan="2">账户资料</th></tr></thead>
                <tbody>
                <tr>
                    <th>{{$layername}}子帐号</th>
                    @if($isupdate)
                        <td>{{$sub['username']}}<input name="passname" type="hidden" value="{{$sub['username']}}"></td>
                    @else
                    <td><input name="passname" class="username"/><span id="usernameMsg"></span></td>
                    @endif
                </tr>
                <tr>
                    <th>登入密码</th>
                    <td><input name="password" class="input"/></td>
                </tr>
                @if($isupdate)
                <tr><th>错误登录次数</th><td><span id="loginRetryCount">{{$sub['errortimes']}}</span> <a href="javascript:loginRetryCountReset('{{$sub['username']}}')">重置</a></td></tr>
                @endif
                <tr>
                    <th>子帐户名称</th>
                    <td><input value="{{$isupdate ? $sub['name'] : ''}}" name="name" class="input"/></td>
                </tr>
                @if($isupdate)
                <tr>
                    <th>二次验证</th>
                    @if($sub['google_open']==0)
                        <td>未绑定</td>
                    @else
                        <td><div style="color:#62bd12;">已启动<input name="passname" type="hidden" value="{{$sub['username']}}"><input name="id" type="hidden" value="{{$sub['userid']}}"><input type="button" value="重置" onclick="resetProp(5);"></div></td>
                    @endif
                </tr>
                <tr><th>转账密码</th><td>未绑定</td></tr>
                @endif
                <tr>
                    <th>绑定登录 IP</th>
                    <td><input name="ipLimit" value="{{$isupdate ? $sub['ipfilter'] : ''}}" class="input"/></td>
                </tr>
                @if($plat_tax_status == 1 && $ftax_status == 1)
                    <tr>
                        <th>开放{{$tax_name}}</th>
                        <td>
                            @if($isupdate)
                                <label><input @if($sub['tax_status']==1)checked="checked" @endif type="radio" name="tax_status" value="1"/>开放</label>
                                <label><input @if($sub['tax_status']==0)checked="checked" @endif type="radio" name="tax_status" value="0" />关闭</label>
                            @else
                                <label><input type="radio" name="tax_status" value="1"/>开放</label>
                                <label><input type="radio" name="tax_status" value="0" checked="checked" />关闭</label>
                            @endif
                        </td>
                    </tr>
                @endif
                @if($plat_water_status == 1 && $fwater_status == 1)
                    <tr>
                        <th>开放{{$water_name}}</th>
                        <td>
                            @if($isupdate)
                                <label><input @if($sub['water_status']==1)checked="checked" @endif type="radio" name="water_status" value="1"/>开放</label>
                                <label><input @if($sub['water_status']==0)checked="checked" @endif type="radio" name="water_status" value="0" />关闭</label>
                            @else
                                <label><input type="radio" name="water_status" value="1"/>开放</label>
                                <label><input type="radio" name="water_status" value="0" checked="checked" />关闭</label>
                            @endif
                        </td>
                    </tr>
                @endif
                @if($layer == 1)
                <tr>
                    <th rowspan="5">各权限设定</th>
                    <td>
                        <label class="popedom"><input @if($isupdate && in_array('user.children',$xpages))checked @endif name="popedoms[]" type="checkbox" value="user.children"/>下线管理</label>
                        <label class="popedom"><input @if($isupdate && in_array('control',$xpages))checked @endif name="popedoms[]" type="checkbox" name="popedoms[]" value="control"/>即时注单</label>
                        <label class="popedom"><input @if($isupdate && in_array('sys.odds',$xpages))checked @endif name="popedoms[]" type="checkbox" name="popedoms[]" value="sys.odds"/>盘口设置</label>
                    </td>
                </tr>
                <tr>
                    <td><label class="popedom"><input @if($isupdate && in_array('agent.private.ipfilter',$xpages))checked @endif type="checkbox" name="popedoms[]" value="agent.private.ipfilter"/>修理代理IP绑定</label>
                        <label class="popedom"><input @if($isupdate && in_array('betback',$xpages))checked @endif type="checkbox" name="popedoms[]" value="betback"/>自动补货</label>
                        <label class="popedom"><input @if($isupdate && in_array('user.private.reset.login.count',$xpages))checked @endif type="checkbox" name="popedoms[]" value="user.private.reset.login.count"/>重置错误登录次数</label>
                    </td>
                </tr>
                <tr>
                    <td><label class="popedom"><input @if($isupdate && in_array('user.reset.transfer.password',$xpages))checked @endif type="checkbox" name="popedoms[]" value="user.reset.transfer.password"/>重置转账密码</label>
                        <label class="popedom"><input @if($isupdate && in_array('agent.follow',$xpages))checked @endif type="checkbox" name="popedoms[]" value="agent.follow"/>跟投</label>
                        <label class="popedom"><input @if($isupdate && in_array('report.transfer',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.transfer"/>额度转换记录报表</label>
                    </td>
                </tr>
                <tr>
                    <td><label class="popedom"><input @if($isupdate && in_array('report.logs',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.logs"/>后台更新日志</label>
                        <label class="popedom"><input @if($isupdate && in_array('report.list',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.list"/>交收分类报表</label>
                        <label class="popedom"><input @if($isupdate && in_array('user.batch.activate',$xpages))checked @endif type="checkbox" name="popedoms[]" value="user.batch.activate" />一键启用</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="popedom"><input @if($isupdate && in_array('report.batch.activate.user',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.batch.activate.user" />一键启用报表</label>
                        <label class="popedom"><input @if($isupdate && in_array('report.member.bets',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.member.bets" />查看注单</label>
                    </td>
                </tr>
                @else
                <tr>
                    <th rowspan="5">各权限设定</th>
                    <td>
                        <label class="popedom"><input @if($isupdate && in_array('user.children',$xpages))checked @endif type="checkbox" name="popedoms[]" value="user.children" />下线管理</label>
                        <label class="popedom"><input @if($isupdate && in_array('control',$xpages))checked @endif type="checkbox" name="popedoms[]" value="control" />即时注单</label>
                        <label class="popedom"><input @if($isupdate && in_array('agent.private.ipfilter',$xpages))checked @endif type="checkbox" name="popedoms[]" value="agent.private.ipfilter" />修理代理IP绑定</label>
                    </td>
                </tr>
                <tr>
                    <td><label class="popedom"><input @if($isupdate && in_array('betback',$xpages))checked @endif type="checkbox" name="popedoms[]" value="betback" />自动补货</label>
                        <label class="popedom"><input @if($isupdate && in_array('user.private.reset.login.count',$xpages))checked @endif type="checkbox" name="popedoms[]" value="user.private.reset.login.count" />重置错误登录次数</label>
                        <label class="popedom"><input @if($isupdate && in_array('user.reset.transfer.password',$xpages))checked @endif type="checkbox" name="popedoms[]" value="user.reset.transfer.password" />重置转账密码</label>
                    </td>
                </tr>
                <tr>
                    <td><label class="popedom"><input @if($isupdate && in_array('agent.follow',$xpages))checked @endif type="checkbox" name="popedoms[]" value="agent.follow" />跟投</label>
                        <label class="popedom"><input @if($isupdate && in_array('report.list',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.list" />交收分类报表</label>
                        <label class="popedom"><input @if($isupdate && in_array('user.batch.activate',$xpages))checked @endif type="checkbox" name="popedoms[]" value="user.batch.activate" />一键启用</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="popedom"><input @if($isupdate && in_array('report.batch.activate.user',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.batch.activate.user" />一键启用报表</label>
                        <label class="popedom"><input @if($isupdate && in_array('report.transfer',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.transfer" />额度转换记录报表</label>
                        <label class="popedom"><input @if($isupdate && in_array('report.member.bets',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.member.bets" />查看注单</label>
                    </td>
                </tr>
                <tr>
                    <td><label class="popedom"><input @if($isupdate && in_array('report.logs',$xpages))checked @endif type="checkbox" name="popedoms[]" value="report.logs" />后台更新日志</label></td>
                </tr>
                @endif
                </tbody>
            </table>
        </form>
    </div>
    <div class="data_footer control">
        @if($bankatm == 1)
        <input type="button" value="确定" onclick="openInputTransferPasswordDialogSaveSub('true');" class="button">
        @else
        <input type="button" value="确定" onclick="saveSub('true');" class="button"/>
        @endif
        <input type="button" value="取消" onclick="back()" class="button"/></div>
</div>
</body>
</html>
