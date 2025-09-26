<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>彩种开关</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/gamesetmyadmin.js?v=11112"></script>
		<style>
			.addtb {
				width: 200px;
				display: none;
				position: absolute;
				background: #fff
			}

			.addtb td {
				text-align: left;
			}

			.s_tb .name {
				width: 50px;
			}

			.v {
				text-align: left;
				padding-left: 5px;
			}

			.v input {
				width: 300px;
			}

			.px {
				width: 50px;
			}

			tr:hover {
				background: #deedfe
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">彩票开关设置</span><span class="right"></span>
			</div>
			<table class="data_table s_tb" style="width: 1000px;">

				<thead>
					<TR>
						<th style='width:20%'>彩种</th>
						<th style='width:20%'>标识</th>
					{{--	<th style='width:20%'>总开关</th>--}}
						<th style='width:20%'>开放</th>
						<th style='width:20%'>排序</th>
                        <th style='width:20%'>任务组</th>
					</TR>
				</thead>
                @foreach($game as $vo)
				<TR>
					<th><label>{{$vo['gname']}}</label></th>
					<td><label>{{$vo['lottery']}}</label></td>
					<td class='v'><INPUT type='checkbox' class="ifopen" value="{{$vo['gid']}}" @if($vo['ifopen']==1) checked @endif /></td>
					{{--<td class='v'><INPUT type='checkbox' class="ifok" value="{{$vo['gid']}}" @if($vo['ifok']==1) checked @endif /></td>--}}
					<td><INPUT type='text' class="px" value="{{$vo['xsort']}}" /></td>
                    <td><INPUT type='text' class="taskgroup" value="{{$vo['taskgroup']}}" /></td>
				</TR>
				@endforeach
			</table>
			<div class="control" style="width: 1000px;">
				<input type="button" value="保存" class="button send">
			</div>
		</div>
		<div id='test'></div>
	</body>
	<script language="javascript">
		$(function() {
			myready();
		});
	</script>
</html>
