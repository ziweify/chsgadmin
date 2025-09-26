<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>登录日志</title>
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
		<script language="javascript" src="/xypone/default/js/default/jsagent/logininfoagent.js?v=11111"></script>
	</head>
	<body id="topbody">
		<div class="main">
			<div class="top_info">
				<span class="title">登陆日志</span>
				<span class="right"></span>
			</div>
			<div class="contents">
				<table class="data_table data_list list">
					<thead>
						<tr>
							<th>序号</th>
							<th>登陆时间</th>
							<th>IP</th>
							<th>IP归属地</th>
							<!--<th>状态</th>-->
						</tr>
					</thead>
					<tbody>
                        @foreach($login as $vo)
						<tr>
							<td>{{$vo['i']}}</td>
							<td class="time">{{$vo['time']}}</td>
							<td>{{$vo['ip']}}</td>
							<td>{{$vo['addr']}}</td>
							<!--<td>{{$vo['zt']}}</td>-->
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="page">注意：登陆日志最少被保留{{$autodellogintime}}天。</div>
		</div>
	</body>
	<script language="javascript">
		myready();
	</script>
</html>
