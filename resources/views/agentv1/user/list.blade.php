<!DOCTYPE html>
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
    <script type="text/javascript" src="/frame/layui/layui.all.js"></script>
    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/user.js?v3"></script>
    <script type="text/javascript" src="/default/js/password.js?v2"></script>
    <script>
        function unlock(ID,name,type) {
            if(window.confirm('你确定要解锁：'+name+'账户？')){
                window.location="unlock?id="+ID+'&type='+type+'&name='+name;
                return true;
            }else{
                return false;
            }
        }
    </script>
    <script type="text/javascript">
        var newTransferPasswordRequired =  '{{$newTransferPasswordRequired}}';
        var transferPasswordEnabled =  '{{$transferPasswordEnabled}}';
        var transferPasswordIPEnabled =  '{{$transferPasswordIPEnabled}}';
    </script>
</head>
<body>
<div class="main">
    <input type="hidden" id="oid" value="64cd4969a3472c3b54bf87d8d5bc2ad20386f948"/>
    <div class="top_info">
        <span class="title">{{$username}} -> @if($lv==0&&($type==2||$type==''))直属代理@elseif($lv==0&&$type==1)直属会员@elseif($lv==''&&$type==2)全部代理@elseif($lv==''&&$type==1)全部会员@elseif($parent!='')直属下线@endif</span>
        <div class="center">
            <div class="query_panel">
					<span class="input_panel">
					<label>模式：<select id="" name="resetType">
                             <option @selected($resetType=='') value="">全部</option>
                            <option @selected($resetType==0) value="0">信用</option>
                            <option @selected($resetType==1) value="1">现金</option>
                            </select>
                    </label>
					<label>状态：<select id="" name="status">
                                <option @selected($status=='') value="">全部</option>
                                <option @selected($status==0) value="0">启用</option>
                                <option @selected($status==1) value="1">冻结</option>
                                <option @selected($status==2) value="2">停用</option>
                                </select>
                    </label>
                        <label>搜索：</label> 账号或名称：<input name="name" class="input"/>
					</span>
                <input type="button" value="查找" class="query"/>
                {{--<input type="button" value="导出" class="query" onclick="exportXlsUserList(window.location.toString())"/>--}}</div>
            @if($layer < 10)<a class="add" href="edit?parent={{$username}}&type=2">新增{{$donwlayername}} </a>@endif
            @if($layer > 0)<a class="add" href="edit?parent={{$username}}&type=1">新增会员</a>@endif
        </div>
        <div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>
    </div>

    <div class="contents">
        <ul class="left_panel">
            <li class="title">[{{$username}}] 下线管理</li>
            @foreach($tree as $v)
                <li><a href="list?parent={{$v['parent']}}&lv={{$v['layer']}}&type={{$v['type']}}">{{$v['name']}}</a><span>{{$v['num']}}</span></li>
            @endforeach
            {{--<li><a href="list?parent={{$username}}&lv=0&type=2">直属代理</a><span>7</span></li>
            <li><a href="list?parent={{$username}}&lv=0&type=1">直属会员</a><span>0</span></li>
            <li><a href="list?parent={{$username}}&type=2">全部代理</a><span id="t2All">7</span></li>
            <li class="t2"><a href="list?parent={{$username}}&type=2&lv=1">一级代理</a><span>7</span></li>
            <li class="t1"><a href="list?parent={{$username}}&type=1&lv=">全部会员</a><span>13</span></li>--}}
        </ul>
        <div class="user_list">
            <table class="data_table list">
                <thead>
                <tr>
                    <th class="online">在线</th>
                    <th class="online">APP</th>
                    <th class="parent">上级账号</th>
                    <th class="type">用户类型</th>
                    <th class="username">账号</th>
                    <th class="account">快开彩额度</th>
                    <th class="share">占成</th>
                    @if($layer > 0 && $type == 1)<th class="range">盘口</th>@endif
                    @if(($type == 2 || $type == '') || ($parent != '' && $type == 2) || ($parent != '' && $lv > 0))
                    <th class="branch">下线</th>
                    {{--<th class="branch">子账号</th>--}}
                    <th class="branch">代理</th>
                    <th class="branch">会员</th>
                    <th>新增</th>
                    @endif
                    <th class="created">新增日期</th>
                    <th class="status">状态</th>
                    <th class="op">功能</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $key=>$item)
                <tr>
                    <td class="online">
                        @if($item['online']==1)
                        <a href="javascript:void(0)" onclick="kick('{{$item['userid']}}')" title="注销"><span class="s{{$item['online']}}"></span></a>
                        @else
                        <span class="s{{$item['online']}}"></span>
                        @endif
                    </td>
                    <td class="online"><span class="s0"></span></td>
                    <td class="parent"><a href="list?parent={{$item['pusername']}}&lv={{$item['layer']}}">{{$item['pusername']}}</a>
                    </td>
                    <td class="type">@if($item['fudong']==0)信用@else现金@endif<br/>{{$item['layername']}}</td>
                    <td class="username">
                        @if($item['ifagent'] == 1)
                        <a href="list?parent={{$item['username']}}&lv={{$item['layer']+1}}">{{$item['username']}} </a>@if($item['name'] != '')<span>[{{$item['name']}}]</span>@endif
                        @else
                        <span>{{$item['username']}}</span>@if($item['name'] != '')<span>[{{$item['name']}}]</span>@endif
                        @endif
                    </td>
                    <td class="account">
                        <span class="max_limit"><a userid="{{$item['username']}}" type="0">@if($item['fudong']==0){{$item['kmaxmoney']}}@else{{$item['kmoney']}}@endif</a></span>
                    </td>
                    <td class="share"><a userid="{{$item['username']}}" username="{{$item['username']}}">明细</a></td>
                    @if($layer > 0 && $type == 1)
                    <td class="range">@if($item['ifagent'] == 0){{$item['pan']}}盘@endif</td>
                    @endif
                    @if(($type == 2 || $type == '') || ($parent != '' && $type == 2) || ($parent != '' && $lv > 0))
                    <td class="branch">
                        @if($item['ifagent'] == 1)
                        <a href="list?parent={{$item['username']}}&lv=0">{{$item['downnumag']}}</a>
                        (<a href="list?parent={{$item['username']}}&type=1&lv=0" title="会员">{{$item['downnumu']}}</a>)
                        @endif
                    </td>
                    {{--<td class="branch">@if($item['ifagent'] == 1)<a href="subAccounts?all=true&mainAcc={{$item['username']}}">{{$item['downson']}}</a>@endif</td>--}}
                    <td class="branch">@if($item['ifagent'] == 1)<a href="list?parent={{$item['username']}}&type=2">{{$item['downnum1']}}</a>@endif</td>
                    <td class="branch">@if($item['ifagent'] == 1)<a href="list?parent={{$item['username']}}&type=1">{{$item['downnum2']}}</a>@endif</td>
                    <td class="new">
                        @if($item['ifagent'] == 1)
                        @if($item['layer'] < 10)<a href="edit?parent={{$item['username']}}&type=2" class="bu_ico ico_dl">代理</a>@endif
                        <a href="edit?parent={{$item['username']}}&type=1" class="bu_ico ico_hy">会员</a>
                        @endif
                    </td>
                    @endif
                    <td class="created">{{$item['regtime']}}</td>
                    <td class="status">
                        <input type="button" class="s{{$item['status']}}" onclick="showChangeStatusPanel(this,'{{$item['username']}}',{{$item['status']}})" value="{{$item['statusz']}}"/>
                        @if($item['status'] == 0 && $item['ifagent'] == 1 && in_array('user.batch.activate',$auths))
                            <input type="button" class="btn" value="一键启用" onclick="enableDownline('{{$item['username']}}')">
                        @endif
                    </td>
                    <td class="op">
                        <a href="edit?username={{$item['username']}}" class="modify">修改</a>
                        <a href="param?username={{$item['username']}}" class="commission">退水</a>
                        <a href="/agent/loginLogs?id={{$item['username']}}" class="login_log info">日志</a>
                        <a href="logs?id={{$item['username']}}" class="op_log">记录</a>
                       {{-- <input type='button' class="btn_1" value='删除' language='javascript' onClick="deleteuser('{{$item['userid']}}','{{$item['username']}}','{{$item['ifagent']}}')"/>
                        <a href="moneylogs?id={{$item['username']}}" class="login_log info">资金变动</a>--}}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="page">
                <script>
                    $(document).ready(function () {
                        $(".page-jump input").on("keydown", function (e) {
                            if (e.keyCode === 13) {
                                e.stopPropagation();
                                $(this).blur();
                                if ($(this).val() <= 0 || $(this).parent().data("total-page") < $(this).val()) {
                                    alert("页面不存在");
                                    return;
                                } else {
                                    var navigatePage = $(this).parent().data("page-url").replace("page=1", "page=" + $(this).val());
                                    location.href = location.origin + location.pathname + navigatePage;
                                }
                            }
                        })
                    })

                </script>
                <div class="page">
                    <div class="page_info">
                        @if(count($list) > 0)
                        <span class="record">共 {{$list->total()}} 笔记录</span>
                        <span class="page_count">共 {{$list->totalPage}} 页</span>
                        <span class="page_control">
  <a class="previous"><a href='{{$list->path()}}?parent={{$parent}}&name={{$name}}&status={{$status}}&page=1&lv={{$lv}}&type={{$type}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?parent={{$parent}}&name={{$name}}&status={{$status}}&page={{$list->currentPage()-1}}&lv={{$lv}}&type={{$type}}'@endif>前一页</a>『
                       @for($i=$startpcount;$i<=$endpcount;$i++)
                                @if($i == $list->currentPage())
                                    <span class="current">{{$i}}</span>&nbsp;
                                @else
                                    @if($i == $list->totalPage)
                                        <a href='{{$list->path()}}?parent={{$parent}}&name={{$name}}&status={{$status}}&page={{$i}}&lv={{$lv}}&type={{$type}}' class="page">{{$i}}</a>
                                    @else
                                        <a href='{{$list->path()}}?parent={{$parent}}&name={{$name}}&status={{$status}}&page={{$i}}&lv={{$lv}}&type={{$type}}' class="page">{{$i}}</a>&nbsp;
                                    @endif
                                @endif
                            @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?parent={{$parent}}&name={{$name}}&status={{$status}}&page={{$list->currentPage()+1}}&lv={{$lv}}&type={{$type}}'@endif>后一页</a> |
 <a class='next' href='{{$list->path()}}?parent={{$parent}}&name={{$name}}&status={{$status}}&page={{$list->lastPage()}}&lv={{$lv}}&type={{$type}}'>末页</a>&nbsp;&nbsp;</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="apiDialog" style="display: none;">
    <div class="user_list">
        <table class="data_table list">
            <thead>
            <tr>
                <th>API平台</th>
                <th>余额</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>双赢棋牌</td>
                <td id="apiBalance"></td>
                <td id="transferButton"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="loading-wrapper"></div>
</body>
</html>
