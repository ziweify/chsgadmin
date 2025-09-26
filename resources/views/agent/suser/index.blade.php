<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta   http-equiv= "Pragma"   content= "no-cache" />
		<meta   http-equiv= "Cache-Control"   content= "no-cache" />
		<meta   http-equiv= "Expires"   content= "0" />
		<title>Welcome</title>
		<link href="/xypone/css/default/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/css/default/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/css/default/layout.css?v=2" rel="stylesheet" type="text/css" />
		<link href="/xypone/css/default/form_validate.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js?v=3333"></script>
		<script language="javascript" src="/xypone/default/js/public.js"></script>
		<script language="javascript" src="/xypone/default/js/md5.js"></script>
		<script language="javascript">
			function hideinfo() {
				if (event.srcElement.tagName == "A") {
					window.status = event.srcElement.innerText
				}
			}
			document.onmouseover = hideinfo;
			document.onmousemove = hideinfo;
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight + 500;
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" src="/xypone/default/js/ui/jquery-ui.js"></script>
		<link href="/xypone/css/default/user.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="/xypone/default/js/default/jsagent/suseragent.js?v=111w2"></script>
		<style type="text/css">
			.user_tb .account {
				text-align: left;
				padding-left: 5px;
			}

			.query_panel input.s1 {
				padding: 2px;
			}

			.tinfo {
				display: none;
				position: absolute
			}

			input.tytxt {
				width: 60px !important;
			}

			#usernameMsg {
				margin-left: 5px;
			}

			em.success {
				background: url(/xypone/css/images/checked.gif) no-repeat 0px 0px;
				margin-left: 3px;
				padding-left: 16px;
				color: blue;
			}

			em {
				font-style: italic;
			}

			.error {
				color: #f97c00;
			}

			em.error {
				background: url(/xypone/css/images/unchecked.gif) no-repeat 0px 0px;
				margin-left: 3px;
				padding-left: 16px;
				color: red;
			}
			.us{
				width: 30px;
			}
		</style>
	</head>
	<body style="overflow:hidden">
		<div class="main">
			<div class="top_info">
				<span class="title"><label>{{$username}}</label> -&gt; <label>直属代理</label></span>
				<div class="center">
					<div class="query_panel">
						<span class="input_panel">
							<label>模式：<select id="" name="resetType" class="fudong">
									<option value="all" selected="selected">全部</option>
									<option value="0">信用</option>
									<option value="1">现金</option>
								</select>
							</label>
							<label>状态：<select id="status" class="status">
									<option value="all" selected="selected">全部</option>
									<option value="1">启用</option>
									<option value="2">冻结</option>
									<option value="0">停用</option>
								</select>
							</label> <label>搜索：</label> 账号或名称：<input type="text" readonly autocomplete=”off” class="input" id="usernames">
						</span> <input type="button" value="查找" class="query searchbtn">
						<input type="hidden" name="fid" id="fid" value="{{$fid}}" username='{{$username}}' />
						<input type="hidden" name='layer' id='layer' toplayer='{{$flayer}}'
							value='{{$flayers}}' />
						<input type="hidden" id='saveuserid' />
						<input type="hidden" id='topid' value="{{$fid}}" />
						选定:
						<input id='openselect' value='启用' type="button" class="s1" />
						<input id='pauseselect' value='冻结' type="button" class="s1" />
						<input id='closeselect' value='停用' type="button" class="s1" />

					</div>
					@if($flayer<8)<a class="addtop add" href="javascript:void(0);" type='ag'>新增{{$dlayername}}</a>@endif <a
							class="addtop add" href="javascript:void(0);" type='us'>新增会员</a>
				</div>
				<div class="right">
					<a class="back" href='javascript:void(0)'>返回</a>
				</div>
			</div>
			<div class="contents">
				<ul class="left_panel">
					<li class="title">[{{$username}}] 下线管理</li>
				</ul>
				<div class="user_list">
					<table class="data_table list user_tb">
						<thead>
							<tr>
								<th><input type="checkbox" value="all" class="selectall" /></th>
								<th class="online">在线</th>
								<th class="online">APP</th>
								<th class="parent">上级账号</th>
								<th class="type">用户类型</th>
								<th class="username">账号</th>
                                @if($config['fasttype']==1)
								<th class="account">快开彩额度</th>
								@endif
                                @if($config['slowtype']==1)
								<th class="account" style="display: none;">低频彩额度</th>
								@endif
								<th class="share">占成</th>
								<!--<th class="branch ag">下线</th>-->
								<th class="branch ag">代理</th>
								<th class="branch ag">会员</th>
								<th class="ag">新增</th>
								<th class="us">盘口</th>
								<th class="created">新增日期</th>
								<th class="status">状态</th>
								<th class="op">功能</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="page">
						<div class="page_info">
							<span class="record">共 <span>5</span> 条记录</span>
							<span class="page_count">共 <span>1</span> 页</span>
							<span class="page_control">
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="utb"></div>
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable zcmxtb"
			tabindex="-1" role="dialog" aria-describedby="shares" aria-labelledby="ui-id-1"
			style="position: absolute; height: auto; width: 900px; display: none;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">pei099# 占成明细</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="shares" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 96px; max-height: 346px; height: auto;">
				<table class="data_table info_table zctb"></table>
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
		<div id="statusPanel" class="popdiv" style="position:absolute; display: none;">
			<div class="title">修改帐户状态<i></i></div>
			<div class="statuslist"><label><input name="ustatus" type="radio" value="1">启用</label><label><input
						name="ustatus" type="radio" value="2">冻结</label><label><input name="ustatus" type="radio"
						value="0">停用</label></div>
		</div>
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable xxdiv"
			tabindex="-1" role="dialog" aria-describedby="shares" aria-labelledby="ui-id-1"
			style="position: absolute; height: auto; width: 900px; display: none;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">pei099# 占成明细</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="shares" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 96px; max-height: 346px; height: auto;">
				<table class="data_table info_table xxtb">
					<thead>
						<tr class="bt">
							<th>彩种</th>
							<th>期數</th>
							<th>類別</th>
							<th>金額</th>
							<th>赔率</th>
							<th>退水</th>
							<th>會員</th>
							<th>時間</th>
						</tr>
					</thead>
					<tbody></tbody>
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
		<input type="hidden" class='sort' orderby='time' sorttype='DESC' page='1' xtype='2' js='0' gid='99' con='' />
		<table class="recordtb info_table hide">
			<tr>
				<td class="e" valign="top"></td>
				<td class="l" valign="top"></td>
			</tr>

		</table>

		<table class="moneypasstb" style="width: 400px;display: none;">
			<tbody>
				<tr>
					<th>账号</th>
					<td></td>
				</tr>
				<tr>
					<th>转账密码</th>
					<td><input id="transferPassword" type="password" class="input"></td>
				</tr>
				<tr>
					<th>确认转账密码</th>
					<td><input id="ckTransferPassword" type="password" class="input"></td>
				</tr>
				<tr>
					<th></th>
					<td><input class="moneypasssend" type="button" value="确定"></td>
				</tr>
			</tbody>
		</table>

		<table class="tinfo info_table copytb">
			<tr>
				<th>新账号</th>
				<td><input type="text" class="copyusername input" uid='0' /></td>
				<td rowspan="2"><input type="button" value="复制" class="copysend button" /></td>
			</tr>
			<tr>
				<th>名称</th>
				<td><input type="text" class="copyname input" /></td>
			</tr>
		</table>
		<table class="tinfo cpasstb">
			<tr>
				<th>账号</th>
				<td><label class="cpassusername"></label></td>
				<td rowspan="2"><input type="button" value="修改密码" class="cpasssend button" /></td>
			</tr>
			<tr>
				<th>新密码</th>
				<td><input type="text" class="cpass input" /></td>
			</tr>
		</table>
		<table class="tinfo moneytb">
			<tr>
				<th>低频彩额度</th>
				<td><input type="text" class="maxmoney input" uid='0' /><input type="text" class="money input"
						uid='0' /></td>
				<td rowspan="2"><input type="button" value="提交" class="moneysend button" /></td>
			</tr>
			<tr>
				<th>快开彩额度</th>
				<td><input type="text" class="kmaxmoney input" /><input type="text" class="kmoney input" /></td>
			</tr>
		</table>
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable edudiv"
			tabindex="-1" role="dialog" aria-describedby="shares" aria-labelledby="ui-id-1"
			style="position: absolute; height: auto; width: 900px; display: none;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">pei099# 占成明细</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="shares" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 96px; max-height: 346px; height: auto;">
				<table class="data_table info_table edutb">
					<tbody>
						<tr>
							<th>账号</th>
							<td></td>
						</tr>
						<tr>
							<th>快开彩额度</th>
							<td><span></span>&nbsp;<input type="button" class="s1 tiquall" value="提取全部额度"></td>
						</tr>
						<tr>
							<th>当前余额：</th>
							<td>0</td>
						</tr>
						<tr>
							<th>上级可用额度</th>
							<td>0</td>
						</tr>
						<tr>
							<th>类型</th>
							<td><label><input type="radio" name="types" value="0">存款</label> <label><input type="radio"
										name="types" value="1">提款</label></td>
						</tr>
						<tr>
							<th>金额</th>
							<td><input name="balance" class="input"> <span id="popDx" style="color:red"
									class="dx"></span></td>
						</tr>
						<tr>
							<th></th>
							<td><input id="btnOK" class="s1 setmoney" type="button" value="确定"></td>
						</tr>
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

		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable zztb"
			tabindex="-1" role="dialog" aria-describedby="transferPasswordDialogue" aria-labelledby="ui-id-2"
			style="position: absolute; height: 142.28px; width: 550.28px; top: 230px; left: 400px; display: block; z-index: 101; right: auto; bottom: auto;display: none;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-2" class="ui-dialog-title">请输入转账密码</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close closezz"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="transferPasswordDialogue" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 95px; max-height: none; height: auto;">
				<table class="list data_table info_table">
					<tbody>
						<tr>
							<th>转账密码</th>
							<td><input id="inputTransferPassword" type="password" class="input"></td>
						</tr>
					</tbody>
				</table>
				<div style="position:absolute;right:170px;bottom:20px;"><input id="transferOk" type="button" value="确定">
				</div>
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

		<table class="tinfo fedittb">
			<tr>
				<th></th>
				<td><input type="text" class="feditmoney input" uid='0' /></td>
			</tr>
			<tr>
				<td colspan=2><input type="button" value="提交" class="feditsend button" /><input type="button" value="关闭"
						class="feditclose button" /></td>
			</tr>

		</table>

		<div id='test'></div>
		<input type='text' id='test2' class="hide" />
		<input type="text" id='tests' class="hide" />
		<input type="text" id='testss' class="hide" />
		<script language="javascript">
			layername = new Array();
            var flayer = {{$flayer}};
            @foreach($layer as $key=>$vo)
				layername[{{$key}}] = "{{$vo}}";
			@endforeach
			var maxlayer = {{$maxlayer}};
			var maxrenflag = {{$maxrenflag}};
			var ustatus = 'all';
			var treeflag = false;
			var fidarr = [];
			var fidindex = -1;
			var slowtype = {{$config['slowtype']}};
			var fasttype = {{$config['fasttype']}};
			var zcmode = {{$config['zcmode']}};
			var moneypassflag = {{$moneypassflag}};
			var transferok = false;
			$(function() {
				myready();
				$('#usernames').val('');
				$('#usernames').blur();
			});
		</script>
	</body>
</html>
