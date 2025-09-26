<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>赔率参数</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/setattmyadmin.js?v=11111"></script>
		<style>
			td,
			th {
				height: 30px;
				line-height: 30px;
			}

			input.txt2 {
				width: 40px;
			}

			.setatt2 input.txt2 {
				width: 45px;
			}

			.hide {
				display: none;
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">赔率退水参数</span><span class="right"></span>
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
				<table class="data_table list setatt setatt2 patt">
					<thead>
						<TR>
							<Th colspan="11"></Th>
							<th colspan="4">模式1<input type="button" class="btn1 btnf modetb" v='1' value="同步其他模式" />
							</th>
							<th colspan="4" class="hide">模式2<input type="button" class="btn1 btnf modetb" v='2'
									value="同步其他模式" /></th>
							<th colspan="4" class="hide">模式3<input type="button" class="btn1 btnf modetb" v='3'
									value="同步其他模式" /></th>
							<th colspan="4" class="hide">模式4<input type="button" class="btn1 btnf modetb" v='4'
									value="同步其他模式" /></th>
							<th colspan="4" class="hide">模式5<input type="button" class="btn1 btnf modetb" v='5'
									value="同步其他模式" /></th>
						</TR>
						<TR>
							<th><input type="checkbox" class="all" /></th>
							<th class='hide'>ID</th>
							<th>大类</th>
							<th>类别</th>
							<th>退水最大值</th>
							<th>退水调节差</th>
							<th>赔率调节差</th>
							<th>赔率调节差2</th>
							<th>赚赔差最大</th>
							<th>补货赔率调整</th>
							<th>补货赔率调整开关</th>
							<th>A盘差</th>
							<th>B盘差</th>
							<th>C盘差</th>
							<th>D盘差</th>
							<th>AB差</th>
							<th class="hide">A盘差</th>
							<th class="hide">B盘差</th>
							<th class="hide">C盘差</th>
							<th class="hide">D盘差</th>
							<th class="hide">AB差</th>
							<th class="hide">A盘差</th>
							<th class="hide">B盘差</th>
							<th class="hide">C盘差</th>
							<th class="hide">D盘差</th>
							<th class="hide">AB差</th>
							<th class="hide">A盘差</th>
							<th class="hide">B盘差</th>
							<th class="hide">C盘差</th>
							<th class="hide">D盘差</th>
							<th class="hide">AB差</th>
							<th class="hide">A盘差</th>
							<th class="hide">B盘差</th>
							<th class="hide">C盘差</th>
							<th class="hide">D盘差</th>
							<th class="hide">AB差</th>


						</TR>
					</thead>
                    @foreach($cs as $vo)
					<TR>
						<td align="center"><input type="checkbox" /><input type="button" class="btn1 btnf patttb" value="同选中" /></td>
						<td align="center" class='hide'>{{$vo['class']}}</td>
						<td align="center" class="bcs">{{$vo['bcname']}}</td>
						<td align="center">{!! $vo['name'] !!}</td>
						<td align="center">{!! $vo['points'] !!}</td>
						<td align="center">{!! $vo['pointsatt'] !!}</td>
						<td align="center">{!! $vo['peilvatt'] !!}</td>
						<td align="center">{!! $vo['peilvatt1'] !!}</td>
						<td align="center">{!! $vo['maxatt'] !!}</td>
						<td align="center">{!! $vo['flypeilv'] !!}</td>
						<td align="center">{!! $vo['flyifok'] !!}[0/1]</td>

						<td align="center">{!! $vo['a1'] !!}</td>
						<td align="center">{!! $vo['b1'] !!}</td>
						<td align="center">{!! $vo['c1'] !!}</td>
						<td align="center">{!! $vo['d1'] !!}</td>
						<td align="center">{!! $vo['ab1'] !!}</td>

						<td class='hide'>{{$vo['a2']}}</td>
						<td class='hide'>{{$vo['b2']}}</td>
						<td class='hide'>{{$vo['c2']}}</td>
						<td class='hide'>{{$vo['d2']}}</td>
						<td class='hide'>{{$vo['ab2']}}</td>

						<td class='hide'>{{$vo['a3']}}</td>
						<td class='hide'>{{$vo['b3']}}</td>
						<td class='hide'>{{$vo['c3']}}</td>
						<td class='hide'>{{$vo['d3']}}</td>
						<td class='hide'>{{$vo['ab3']}}</td>

						<td class='hide'>{{$vo['a4']}}</td>
						<td class="hide">{{$vo['b4']}}</td>
						<td class="hide">{{$vo['c4']}}</td>
						<td class="hide">{{$vo['d4']}}</td>
						<td class="hide">{{$vo['ab4']}}</td>

						<td class='hide'>{{$vo['a5']}}</td>
						<td class="hide">{{$vo['b5']}}</td>
						<td class="hide">{{$vo['c5']}}</td>
						<td class="hide">{{$vo['d5']}}</td>
						<td class="hide">{{$vo['ab5']}}</td>
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
