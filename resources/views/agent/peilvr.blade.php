<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>自动补货</title>
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
		<script language="javascript" src="/xypone/default/js/default/jsagent/peilvragent.js?v=11111"></script>
		<style type="text/css">
			.data_table .flag {
				width: 70px;
			}

			.data_table td {
				height: 30px;
			}

			.pantb td {
				text-align: center
			}

			input.s1 {
				padding: 1.5px;
			}
		</style>
	</head>
	<body id="topbody">
		<div class="main">
			<div class="top_info">
				<span class="title">操盘记录</span><span class="right"></span>
			</div>
			<div class="contents param_panel">
				<div class="game_class">
					<ul>
                        @if($config['fasttype']==1)
						<li><span>快开彩</span>
                            @foreach($game as $vo)
                            @if($vo['fast'] == 1)
                                <a href="javascript:void(0)" class="g{{$vo['gid']}}"
								gid='{{$vo['gid']}}'>{{$vo['gname']}}</a>
                            @endif
							@endforeach
						</li>
						@endif
                        @if($config['slowtype']==1)
						<li><span>低频彩</span>
                            @foreach($game as $vo)
                            @if($vo['fast'] == 0)
                                <a href="javascript:void(0)" class="g{{$vo['gid']}}"
								gid='{{$vo['gid']}}'>{{$vo['gname']}}</a>
                            @endif
							@endforeach
						</li>
						@endif
					</ul>
				</div>
				<table class="list data_table nrtb">
					<thead>
						<TR>
							<th>彩种</th>
							<th>类别</th>
							<th>赔率值</th>
							<th>备注</th>
							<th>时间</th>
							<th>操作员</th>

						</TR>
					</thead>
                    @foreach($p as $vo)
					<TR>
						<td>{{$vo['gname']}}</td>
						<td>{{$vo['pid']}}</td>
						<td>{{$vo['peilv']}}</td>
						<td>{{$vo['auto']}}</td>
						<td>{{$vo['time']}}</td>
						<td>{{$vo['sonuser']}}</td>
					</TR>
					@endforeach
				</table>
				<div class="page">
					<div class="page_info" page='{{$page}}' pcount='{{$pcount}}'>
						<span class="record">共 <span>{{$rcount}}</span> 条记录</span>
						<span class="page_count">共 <span>{{$pcount}}</span> 页</span>
						<span class="page_control">
						</span>
					</div>
				</div>
			</div>
		</div>
		<div id='test'></div>
		<script language="javascript">
			var gid = {{$gid}};
			myready();
		</script>
	</body>
</html>
