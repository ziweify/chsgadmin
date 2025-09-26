<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>默认赔率</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/ptypemyadmin.js?v=11111"></script>
		<style>
			td,
			th {
				height: 30px;
				line-height: 30px;
			}

			tr:hover {
				background: #DEEFD8
			}

			.txt {
				width: 150px;
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">默认赔率设置</span><span class="right"></span>
			</div>
			<div class="contents param_panel">
				<div class="game_class">
					<ul>
                        @if($config['fasttype']==1)
						<li><span>快开彩</span>
                            @foreach($game as $vo)
                                @if($vo['fast']!=0)
                                    <a href="javascript:void(0)" class="g{{$vo['gid']}}"
                                    gid='{{$vo['gid']}}'>{{$vo['gname']}}</a>
                                @endif
							@endforeach
						</li>
						@endif
                        @if($config['slowtype']==1)
						<li><span>低频彩</span>
                            @foreach($game as $i=>$vo)
                            @if($vo['fast']==0)
                                <a href="javascript:void(0)" class="g{{$vo['gid']}}"
								gid='{{$vo['gid']}}'>{{$vo['gname']}}</a>
                                @endif
							@endforeach
						</li>
						@endif
					</ul>
				</div>
				<table class="data_table list">
					<thead>
						<tr>
							<th>ID</th>
							<th>类别</th>
							<th>赔率</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($ptype as $i=>$vo)
						<tr>
							<td>{{$vo['id']}}</td>
							<td><input type="text" class="txt c" value="{{$vo['c']}}" /></td>
							<td><input type="text" class="txt p" value="{{$vo['p']}}" /></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="control">
				<input type="button" gid="{{$gid}}" class="button yiwotongbu" value="同步{{$flname}}">&nbsp;&nbsp;&nbsp;<input
					type="button" value="保存" class="button send">&nbsp;&nbsp;&nbsp;<input type="button" value="新增"
					class="button add">&nbsp;&nbsp;&nbsp;<input type="button" value="删除" class="button del">
			</div>
		</div>
		<script language="javascript">
			var gid = {{$gid}};
			$(function() {
				myready();
			});
		</script>
		<div id='test'></div>
	</body>
</html>
