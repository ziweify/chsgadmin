<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>操盘员</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=33" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript" src="/xypone/default/js//jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight + 500;
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jshide/caopanmyadmin.js?v=11111"></script>
		<script language="javascript" src="/xypone/default/js/md5.js"></script>
		<link href="/xypone/css/admins.css" type="text/css" rel="stylesheet" />
		<style>
			.page {
				table-layout: fixed;
			}

			.page td:hover {
				background: #FCF
			}

			.recordtb .e tr:hover {
				background: #FCF
			}

			.recordtb .l tr:hover {
				background: #FCF
			}

			body {
				font-size: 12px;
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">操盘员</span><span class="right"></span>
			</div>
			<table class="data_table data_list list">
				<thead>
					<TR>
						<th>管理员</th>
						<th>新增时间</th>
						<th>登陆次数</th>
						<th>最后登录IP</th>
						<th>最后登录时间</th>
						<th>最后修改密码时间</th>
						<th>操作</th>
					</TR>
				</thead>
                @foreach($data as $vo)
				<tr>
					<td>{{$vo['adminname']}}</td>
					<td>{{$vo['regtime']}}</td>
					<td>{{$vo['logintimes']}}</td>
					<td>{{$vo['lastloginip']}}<!-- [{{$vo['lastloginfrom']}}] --></td>
					<td>{{$vo['lastlogintime']}}</td>
					<td>{{$vo['passtime']}}</td>
					<td style="width:200px;">
                        @if($vo['adminid']!=10000)
						<input type='button' class='del btn1 btnf' value='删除' id=del"{{$vo['adminid']}}"
							aid="{{$vo['adminid']}}" />
						@endif
						<input class='edit btn1 btnf' id=edit"{{$vo['adminid']}}" value='修改密码' aid="{{$vo['adminid']}}"
							type='button' />
                        @if($vo['adminid']==10000)
						<input class='add btn1 btnf' value='新增' id=add"{{$vo['adminid']}}" type='button' />
						@endif
						<input class='record btn1 btnf' value='记录' aid='{{$vo['adminid']}}'
							username='{{$vo['adminname']}}' id=showrecord"{{$vo['adminid']}}" type='button' />
						<input class='logininfo btn1 btnf' value='日志' aid='{{$vo['adminid']}}'
							username='{{$vo['adminname']}}' id="showlogininfo{{$vo['adminid']}}" type='button' />
					</td>
				</tr>
				@endforeach
			</table>
			<table class="data_table data_list list pages" style="margin-top:20px;">
                @foreach($page as $i=>$vo)
					@if($i==0)<thead>@endif
					<tr>
                        @foreach($vo as $e=>$vb)
							@if(($vo==0 || $e==0)) <Th>{!! $vb !!}</Th>@else<TD>{!! $vb !!}</TD>@endif
						@endforeach
					</tr>
                    @if($i==0)</thead>@endif
				@endforeach
			</table>
			<input type="hidden" value="" name='aid' id='aid' />
		</div>
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable addtb"
			tabindex="-1" role="dialog" aria-describedby="shares" aria-labelledby="ui-id-1"
			style="position: absolute; height: auto; width: 360px; top: 257px; left: 564.5px; display:none; right: auto; bottom: auto;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">2988316036#明细</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="shares" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 96px; max-height: 346px; height: auto;">
				<table class="data_table">
					<tbody>
						<TR>
							<Th>操盘员</Th>
							<TD><label id='user0'></label><input type="text" id='user1' maxlength="10"
									class="txt1" /><input type="hidden" id='action' value="add" />
							</TD>
						</TR>
						<TR>
							<Th>密码</Th>
							<TD><input type="password" id='pass1x' class="intext" /></TD>
						</TR>
						<TR>
							<Th>重复密码</Th>
							<TD><input type="password" id='pass2x' class="intext" /></TD>
						</TR>
						<TR>
							<th colspan="2" class="tcenter"><input type="button" id='addbtn' class="btn1 btnf"
									value="新增子帐号" />&nbsp;<input type="button" id='closebtn' class="btn1 btnf"
									value="关闭" /></th>
						</TR>
					</tbody>
				</table>
			</div>
			<div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;">
			</div>
			<div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
		</div>

		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable recordtb"
			tabindex="-1" role="dialog" aria-describedby="shares" aria-labelledby="ui-id-1"
			style="position: absolute; height:400px; width: 360px; top: 257px; left: 564.5px; display:none; right: auto; bottom: auto;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">2988316036# 占成明细</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="shares" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 96px; max-height: 346px; height: auto;">
				<table class="data_table list ltb">
				</table>
			</div>
			<div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;">
			</div>
			<div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
		</div>
		<div id='test'></div>
	</body>
	<script language="javascript">
		$(function() {
			myready();
		});
	</script>
</html>
