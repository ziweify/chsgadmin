<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>资金日志</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=33" rel="stylesheet" type="text/css" />
		<link href="/xypone/css/default/form_validate.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript" src="/xypone/default/js/public.js"></script>
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
				//obj.scrollTo(0, 0);
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jshide/money_logmyadmin.js?v=11111"></script>
		<style type="text/css">
			.button {
				color: #fff !important
			}

			.tcenter {
				text-align: center
			}
		</style>
	</head>
	<body id="topbody">
		<script id=myjs language="javascript">
			$(function() {
				myready();
			});
		</script>
		<div class="main">
			<div class="top_info">
				<span class="title">{{$username}} 资金日志</span>
				<span class="right"></span>
			</div>
			<div class="contents">
				<table class="data_table data_list list">
					<thead>
						<tr>
							<th>时间</th>
							<th>类型</th>
							<th>发生金额</th>
							<th>余额</th>
							<th>备注</th>
							<th>ip</th>
							<th>IP归属地</th>
							<th>操作员</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($log as $vo)
						<tr>
							<td class="time">{{$vo['time']}}</td>
							<td>@if($vo['type']==0)低频 @elseif($fudong==1)现金 @else快开@endif</td>
							<td>{{$vo['money']}}</td>
							<td>{{$vo['usermoney']}}</td>
							<td>{{$vo['bz']}}</td>
							<td>{{$vo['ip']}}</td>
							<td>{{$vo['addr']}}</td>
							<td>{{$vo['modiuser']}}({{$vo['modisonuser']}})</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="page">
				<div class="page_info" page="{{$page}}" pcount="{{$pcount}}" uid='{{$uid}}'>
					<span class="record">共 <span>{{$rcount}}</span> 条记录</span>
					<span class="page_count">共 <span>{{$pcount}}</span> 页</span>
					<span class="page_control"><a class="prev">前一页</a>『<span
							class="current">&nbsp;1&nbsp;</span>&nbsp;<a href="javascript:void(0)"
							class="p">2</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="p">3</a>&nbsp;&nbsp;<a
							href="javascript:void(0)" class="p">4</a>&nbsp;&nbsp;<a href="javascript:void(0)"
							class="p">5</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="p">6</a>&nbsp;&nbsp;<a
							href="javascript:void(0)" class="p">7</a>&nbsp;&nbsp;<a href="javascript:void(0)"
							class="p">8</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="p">9</a>&nbsp;&nbsp;<a
							href="javascript:void(0)" class="p">10</a>&nbsp;&nbsp;<a href="javascript:void(0)"
							class="p">11</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="p">12</a>&nbsp;&nbsp;<a
							href="javascript:void(0)" class="p">13</a>&nbsp;&nbsp;<a href="javascript:void(0)"
							class="p">14</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="p">15</a>&nbsp;』<a
							class="next">后一页</a></span>
				</div>
			</div>

		</div>
	</body>
</html>
