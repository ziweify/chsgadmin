<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>默认退水</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/zshuimyadmin.js?v=11111"></script>
		<style>
			td,
			th {
				height: 30px;
				line-height: 30px;
			}

			tr:hover {
				background: #DEEFD8
			}

			input {
				width: 52px;
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">默认退水设置</span><span class="right"></span>
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
                            @foreach($game as $vo)
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
					<TR>
						<th rowspan="2"><input type="checkbox" class="all" /></th>
						<th rowspan="2">大类</th>
						<th rowspan="2" style="display:none;">类别</th>
						<th rowspan="2" style="display:none;">赔率差最大</th>
						<th rowspan="2" style="display:none;">保底赔率</th>
						<th rowspan="2">单期最高</th>
						<th rowspan="2">单注最高</th>
						<th rowspan="2">单注最低</th>
						<th colspan="2">A盘退水%</th>
						<th colspan="2">B盘退水%</th>
						<th colspan="2">C盘退水%</th>
						<th colspan="2">D盘退水%</th>
					</TR>
					<tr>
						<th>A</th>
						<th>B</th>
						<th>A</th>
						<th>B</th>
						<th>A</th>
						<th>B</th>
						<th>A</th>
						<th>B</th>
					</tr>
                    @foreach($zpan as $vo)
					<TR>
						<td><input type="checkbox" /><input type="button" class="btn1 btnf pantb" value="同选中" /></td>
						<td>{{$vo['name']}}</td>
						<td style="display:none;">-</td>
						<td style="display:none;">-</td>
						<td style="display:none;">-</td>
						<td>{!! $vo['cmaxje'] !!}</td>
						<td>{!! $vo['maxje'] !!}</td>
						<td>{!! $vo['minje'] !!}</td>
                        @if($vo['abcd']==1)
                            @if($vo['ab']==1)
                            <td>{!! $vo['pointsaa'] !!}</td>
                            <td>{!! $vo['pointsab'] !!}</td>
                            <td>{!! $vo['pointsba'] !!}</td>
                            <td>{!! $vo['pointsbb'] !!}</td>
                            <td>{!! $vo['pointsca'] !!}</td>
                            <td>{!! $vo['pointscb'] !!}</td>
                            <td>{!! $vo['pointsda'] !!}</td>
                            <td>{!! $vo['pointsdb'] !!}</td>
                            @else
                            <td colspan="2">{!! $vo['pointsa0'] !!}</td>
                            <td colspan="2">{!! $vo['pointsb0'] !!}</td>
                            <td colspan="2">{!! $vo['pointsc0'] !!}</td>
                            <td colspan="2">{!! $vo['pointsd0'] !!}</td>
                            @endif
						@else
						    <td colspan="8">{!! $vo['pointsa0'] !!}</td>
						@endif
					</TR>
					@endforeach
				</table>
			</div>
			<div class="control">
				<input type="button" gid="{{$gid}}" class="button yiwotongbu" value="同步{{$flname}}">&nbsp;&nbsp;&nbsp;<input
					type="button" value="保存" class="button send">
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
