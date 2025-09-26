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
    <script type="text/javascript" src="/default/js/subManage.js"></script>
    <script type="text/javascript" src="/default/js/user.js"></script>
    <script type="text/javascript" src="/default/js/factoryauthenication.js"></script>
    <style>
        .user_panel .popedom {
            width: 20% !important;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">子帐号 -&gt; @if($isupdate)修改@else新增@endif</span>
    </div>
    <div class="contents">
        <form id="saveForm" action="">
            <table class="data_table info_table user_panel input_panel">
                <thead>
                <tr>
                    <th colspan="2">账户资料</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>公司子帐号</th>
                    @if($isupdate)
                        <td>{{$sub['adminname']}}
                            <input name="passname" type="hidden" value="{{$sub['adminname']}}">
                            <input type="hidden" name="isupdate" value="{{$isupdate}}"/>
                        </td>
                    @else
                        <td><input name="passname" class="username"/><span id="usernameMsg"></span></td>
                    @endif
                </tr>
                <tr>
                    <th>登入密码</th>
                    <td><input name="password" class="input"/></td>
                </tr>
                @if($isupdate)
                    <tr>
                        <th>错误登录次数</th>
                        <td><span id="loginRetryCount">{{$sub['loginerrors']}}</span> <a
                                href="javascript:loginRetryCountReset('{{$sub['adminname']}}')">重置</a></td>
                    </tr>
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
                            <td>
                                <div style="color:#62bd12;">已启动<input name="passname" type="hidden"
                                                                         value="{{$sub['adminname']}}"><input name="id"
                                                                                                             type="hidden"
                                                                                                             value="{{$sub['adminid']}}"><input
                                        type="button" value="重置" onclick="resetProp(5);"></div>
                            </td>
                        @endif
                    </tr>
                @endif
                <tr>
                    <th>绑定登录IP</th>
                    <td><input name="ipLimit" value="{{$isupdate ? $sub['ipfilter'] : ''}}" class="input"/></td>
                </tr>
                @if($adminInfo['ifhide'] == 1 && $isupdate)
                    <tr>
                        <th>独立消息</th>
                        <td>
                            <textarea rows="5" cols="50" name="alertmsg">{{$alertmsg}}</textarea>
                        </td>
                    </tr>
                @endif
                <tr>
                    <th rowspan="5">各权限设定</th>
                    <td>
                        @foreach($fxpages[0] ?? [] as $page)
                        <label class="popedom"><input @if($isupdate && in_array($page['xpage'],$xpages))checked @endif name="popedoms[]" type="checkbox" value="{{$page['xpage']}}"/>{{$page['pagename']}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        @foreach($fxpages[1] ?? [] as $page)
                        <label class="popedom"><input @if($isupdate && in_array($page['xpage'],$xpages))checked @endif name="popedoms[]" type="checkbox" value="{{$page['xpage']}}"/>{{$page['pagename']}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        @foreach($fxpages[2] ?? [] as $page)
                        <label class="popedom"><input @if($isupdate && in_array($page['xpage'],$xpages))checked @endif name="popedoms[]" type="checkbox" value="{{$page['xpage']}}"/>{{$page['pagename']}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        @foreach($fxpages[3] ?? [] as $page)
                        <label class="popedom"><input @if($isupdate && in_array($page['xpage'],$xpages))checked @endif name="popedoms[]" type="checkbox" value="{{$page['xpage']}}"/>{{$page['pagename']}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        @foreach($fxpages[4] ?? [] as $page)
                            <label class="popedom"><input @if($isupdate && in_array($page['xpage'],$xpages))checked @endif name="popedoms[]" type="checkbox" value="{{$page['xpage']}}"/>{{$page['pagename']}}</label>
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class="data_footer control"><input type="button" value="确定" onclick="saveSub()" class="button"/> <input
            type="button" value="取消" onclick="back()" class="button"/></div>
</div>
</body>
</html>
