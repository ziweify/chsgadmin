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
    <script type="text/javascript" src="/default/js/user.js?v21"></script>
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
        function zh_delete(ID,name,type) {
            if(window.confirm('你确定要删除：'+name+'及下级所有账户？此操作不可逆，请谨慎操作！！')){
                window.location="zh_delete?id="+ID+'&type='+type+'&name='+name;
                return true;
            }else{
                //alert("取消");
                return false;
            }
        }


        function showuser(ID,name,type) {
            $.ajax({
                url: "relation",
                method: "POST",
                dataType: "text",
                data: {
                    id: ID,
                    name: name,
                    type:type
                },
                success: function (d) {
                    layer.open({
                        type: 1,
                        title: '上下级',
                        shadeClose: true,
                        shade: false,
                        maxmin: false, //开启最大化最小化按钮
                        area: ['30%', '50%'],
                        content: d
                    });
                }
            })
        }

        function deleteuser(ID,name,type) {
            $.ajax({
                url: "delUser",
                method: "POST",
                dataType: "text",
                data: {
                    id: ID,
                    name: name,
                    type:type
                },
                success: function (d) {
                    layer.open({
                        type: 1,
                        title: '请输入密码',
                        shadeClose: true,
                        shade: false,
                        maxmin: false, //开启最大化最小化按钮
                        area: ['20%', '20%'],
                        content: d
                    });
                }
            })
        }
    </script>
    <script type="text/javascript">
        var newTransferPasswordRequired =  'false';
        var transferPasswordEnabled =  'false';
        var transferPasswordIPEnabled =  'false';
    </script>
</head>
<body>
<div class="main">
    <input type="hidden" id="oid" value="64cd4969a3472c3b54bf87d8d5bc2ad20386f948"/>
    <div class="top_info">
        <span class="title">{{$username}}</span>
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
                </div>
            <a class="add" href="edit?fid={{$fuserid}}&type={{$type}}">新增房主</a>
        </div>
        <div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>
    </div>

    <div class="contents">
        <div class="user_list">
            <table class="data_table list">
                <thead>
                <tr>
                    <th class="online">在线</th>
                    <th class="parent">上级账号</th>
                    <th class="type">用户类型</th>
                    <th class="bsb_coin">百胜币余额</th>
                    <th class="is_exclusive">注册类型</th>
                    <th class="username">账号</th>
                    <th class="roomid">房间号</th>
                    @if($type == 1)
                    <th class="account">余额</th>
                    @endif
                    @if($type == 2)
                    <th class="branch">子账号</th>
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
                    <td class="parent">{{$item['pusername']}}</td>
                    <td class="type">{{$item['layername']}}</td>
                    <td class="account">
                        <span class="max_limit"><a ruid="{{$item['ruid']}}" userid="{{$item['userid']}}" type="0">{{$item['bsb_coin']}}</a></span>
                    </td>
                    <td class="is_exclusive">@if($item['is_exclusive']==0)注册账户@else专属账户@endif</td>
                    <td class="username">
                        @if($item['ifagent'] == 1)
                        <a href="list?fid={{$item['userid']}}&ruid={{$item['ruid']}}">{{$item['username']}} </a>@if($item['name'] != '')<span>[{{$item['name']}}]</span>@endif
                        @else
                        <span>{{$item['username']}}</span>@if($item['name'] != '')<span>[{{$item['name']}}]</span>@endif
                        @endif
                    </td>
                    <td class="roomid">
                        @if($item['layer'] == 1)
                            <a userid="{{$item['userid']}}">{{$item['roomid']}}</a>
                        @else
                            {{$item['roomid']}}
                        @endif
                    </td>
                    @if($type == 1)
                    <td class="account">
                        <span class="max_limit"><a userid="{{$item['username']}}" type="0">{{$item['kmoney']}}</a></span>
                    </td>
                    @endif
                    @if($type == 2)
                    <td class="branch">@if($item['ifagent'] == 1)<a href="subAccounts?all=true&mainAcc={{$item['username']}}">{{$item['downson']}}</a>@endif</td>
                    <td class="branch">@if($item['ifagent'] == 1)<a href="list?fid={{$item['userid']}}&type=2&ruid={{$item['ruid']}}">{{$item['downnum1']}}</a>@endif</td>
                    <td class="branch">@if($item['ifagent'] == 1)<a href="list?fid={{$item['userid']}}&type=1&ruid={{$item['ruid']}}">{{$item['downnum2']}}</a>@endif</td>
                    <td class="new">
                        @if($item['ifagent'] == 1)
                        @if($item['layer'] < 4)<a href="edit?fid={{$item['userid']}}&type=2&ruid={{$item['ruid']}}" class="bu_ico ico_dl">代理</a>@endif
                        <a href="edit?fid={{$item['userid']}}&type=1&ruid={{$item['ruid']}}" class="bu_ico ico_hy">会员</a>
                        @endif
                    </td>
                    @endif
                    <td class="created">{{$item['regtime']}}</td>
                    <td class="status"><input type="button" class="s{{$item['userreg']['status']}}" onclick="showChangeStatusPanel(this,'{{$item['username']}}',{{$item['userreg']['status']}})" value="{{$item['statusz']}}"/></td>
                    <td class="op">
                        <a href="edit?username={{$item['username']}}&type={{$type}}" class="modify">修改</a>
                        <a href="param?username={{$item['userid']}}&ruid={{$item['ruid']}}" class="commission">退水</a>
                        <a href="/agent/loginLogs?id={{$item['username']}}" class="login_log info">日志</a>
                        <a href="logs?id={{$item['username']}}" class="op_log">记录</a>
                        <input style="cursor: pointer" type='button' class="btn_1" value='删除' language='javascript' onClick="zdelete('{{$item['ruid']}}','{{$item['userid']}}','{{$item['username']}}')"/>
                       @if($item['ifagent'] == 1 && $plat_outbet_status == 1 && $item['outbet_status'] == 1  && in_array('flyout',$auths))
                       <a href="/agent/outbet/config?userid={{$item['userid']}}" class="login_log info">{{$outbet_name}}</a>
                       <a href="/agent/outbet/bets?userid={{$item['userid']}}" class="login_log info">{{$outbet_name}}注单</a>
                       <a href="/agent/outbet/error?userid={{$item['userid']}}" class="login_log info">{{$outbet_name}}警报</a>
                        @endif
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
  <a class="previous"><a href='{{$list->path()}}?fid={{$fid}}&name={{$name}}&status={{$status}}&page=1&type={{$type}}' class="previous">首页</a></a> |
<span class="page-jump" data-total-page="{{$list->totalPage}}" data-page-url="?&page=1
">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
<a class="previous" @if($list->currentPage()-1 >= 1)href='{{$list->path()}}?fid={{$fid}}&name={{$name}}&status={{$status}}&page={{$list->currentPage()-1}}&type={{$type}}'@endif>前一页</a>『
                       @for($i=$startpcount;$i<=$endpcount;$i++)
                                @if($i == $list->currentPage())
                                    <span class="current">{{$i}}</span>&nbsp;
                                @else
                                    @if($i == $list->totalPage)
                                        <a href='{{$list->path()}}?fid={{$fid}}&name={{$name}}&status={{$status}}&page={{$i}}&type={{$type}}' class="page">{{$i}}</a>
                                    @else
                                        <a href='{{$list->path()}}?fid={{$fid}}&name={{$name}}&status={{$status}}&page={{$i}}&type={{$type}}' class="page">{{$i}}</a>&nbsp;
                                    @endif
                                @endif
                            @endfor
                            』<a class='next' @if($list->currentPage()+1 <= $list->totalPage)href='{{$list->path()}}?fid={{$fid}}&name={{$name}}&status={{$status}}&page={{$list->currentPage()+1}}&type={{$type}}'@endif>后一页</a> |
 <a class='next' href='{{$list->path()}}?fid={{$fid}}&name={{$name}}&status={{$status}}&page={{$list->lastPage()}}&type={{$type}}'>末页</a>&nbsp;&nbsp;</span>
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
