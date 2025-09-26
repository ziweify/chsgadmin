<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {if $rkey==0}oncontextmenu="return false" {/if}>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>补货变更记录</title>
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
		<script language="javascript" src="/xypone/default/js/default/jsagent/flyrecordagent.js?v=11111"></script>
	</head>
	<body id="topbody">
		<div class="main">
			<div class="top_info">
				<span class="title">资料更变记录</span>
				<span class="right"></span>
			</div>
			<div class="contents">
				<table class="data_table data_list list">
					<thead>
						<tr>
							<th>ID</th>
							<th>变更时间</th>
							<th>变更类别</th>
							<th>原始值</th>
							<th>变更值</th>
							<th>变更人</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($log as $vo)
						<tr>
							<td>{{$vo['id']}}</td>
							<td>{{$vo['moditime']}}</td>
							<td>{!! $vo['title'] !!}</td>
							<td>{!! $vo['oldvalue'] !!}</td>
							<td>{!! $vo['newvalue'] !!}</td>
							<td>{{$vo['modiuser']}}(代理)</td>
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
	<script language="javascript">
		myready();
	</script>
</html>
