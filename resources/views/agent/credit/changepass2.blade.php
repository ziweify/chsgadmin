<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {if $rkey==0}oncontextmenu="return false" {/if}>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>变更密码</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=2" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js?v=3333"></script>
		<script language="javascript" src="/xypone/default/js/ui/jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象  
				var h = document.body.clientHeight + 500;
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jsagent/changepass2agent.js?v=11111"></script>
		<script language="javascript" src="/js/md5.js"></script>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">变更密码</span>
			</div>
			<div class="contents">
				<table class="data_table info_table">
					<tr>
						<th>原始密码</th>
						<td><input id="oldpassword" type="password" class="input" /></td>
					</tr>
					<tr>
						<th>新设密码</th>
						<td><input id="password" type="password" class="input" /> ＊6-20字符必须由大小写字母和数字组合组成</td>
					</tr>
					<tr>
						<th>确认密码</th>
						<td><input id="ckpassword" type="password" class="input" /></td>
					</tr>
				</table>
			</div>
			<div class="data_footer control">&nbsp;<input class="button qd" type="button" value="确定修改" />&nbsp;</div>
		</div>
	</body>
	<script language="javascript">
		myready();
	</script>
</html>
