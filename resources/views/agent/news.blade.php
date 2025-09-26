<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>公告</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=2" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js?v=33343"></script>
		<script language="javascript" src="/xypone/default/js/ui/jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight+500;
				obj.style.height = h+ "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jsagent/newsagent.js?v=11111"></script>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">最新公告</span>
			</div>
			<div class="contents">
				<table class="data_table data_list list">
					<thead>
						<tr>
							<th>时间</th>
							<th>公告详情</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($news as $vo)
						<tr>
							<td>{{$vo['time']}}</td>
							<td>{{$vo['content']}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="page">
				<div class="page_info">
					<span class="record">共 {{$count}} 条公告</span>
					<span class="page_count">共 1 页</span>
					<span class="page_control">
  <a class="previous"></a><a class="previous">首页</a> |
<span class="page-jump" data-total-page="1"
	  data-page-url="/stsa/newsshow">跳转至<input type="number" style="width: 50px" maxlength="3">页 </span>
<a class="previous">前一页</a>『
&nbsp;<span class="current">1</span>&nbsp;』<a class="next">后一页</a> |
 <a class="next">末页</a></span>
				</div>
			</div>
		</div>
	</body>
	<script language="javascript">
		$(function() {
			myready();
		});
	</script>
</html>
