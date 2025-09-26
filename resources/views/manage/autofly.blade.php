<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>补货设置</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/autoflymyadmin.js?v=111211"></script>
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
				<span class="title">自动补货设定</span><span class="right"></span>
			</div>
			<form style="margin:0;padding:0" method="post">
				<div class="contents param_panel">
					<div class="game_class">
						<ul>
                            @if($config['fasttype']==1)
							<li><span>快开彩</span>
                                @foreach($game as $vo)
                                @if($vo['fast']!=0)
                                    <a href="javascript:void(0)" class="g{{$vo['gid']}}" gid='{{$vo['gid']}}'>{{$vo['gname']}}</a>
                                @endif
								@endforeach
							</li>
							@endif
                            @if($config['slowtype']==1)
							<li><span>低频彩</span>
                                @foreach($game as $vo)
                                @if($vo['fast']==0)
                                    <a href="javascript:void(0)" class="g{{$vo['gid']}}" gid='{{$vo['gid']}}'>{{$vo['gname']}}</a>
                                @endif
								@endforeach
							</li>
							@endif
						</ul>
					</div>
					<table class="layout pantb">
						<tbody>
							<tr>
								<td class="panel">
									<table class="list data_table at_0">
										<thead>
											<tr>
												<th><input type="checkbox" class="all">全选</th>
												<th>种类</th>
												<th>计算方式</th>
												<th>占成</th>
												<th>飞单限额</th>
												<th>开关</th>
											</tr>
										</thead>
										<tbody>
                                            @foreach($fly as $i=>$vo)
                                            @if($i <= $nums)
											<TR class='nr' f='{{$vo['ftype']}}' ab='{{$vo['ab']}}'>
												<td><input type="checkbox" class="pantbc" /><input type="button"
														class="s1 pantb" value="同步选中" /></td>
												<th>{{$vo['name']}}</th>
												<th>下注额</th>
												<td>
                                                    @if($vo['ab']==1)
													总额(含AB盘):
													<input type="text" value='{{$vo['A']}}' class="flag je a" />
													其中B盘：
													<input type="text" value='{{$vo['B']}}' class="flag je b" />
                                                    @else
													<input type="text" value='{{$vo['A']}}' class="flag je a" />
													@endif
												</td>
												<td><input type="text" value='{{$vo['maxje']}}' class="flag maxje" /></td>
												<td><input type="checkbox" class='ifok' value="1" @if($vo['ifok']==1)checked @endif /></td>
											</TR>
										 @endif
										    @endforeach
						</tbody>
					</table>
					</td>
					{{--<td class="panel" style="display: none">
						<table class="list data_table at_0">
							<thead>
								<tr>
									<th>
										<input type="checkbox" class="all">全选
									</th>
									<th>种类</th>
									<th>占成</th>
									<th>飞单限额</th>
									<th>开关</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($fly as $i=>$vo)
                                @if($i <= $nums)
								<TR class='nr' f='{{$vo['ftype']}}' ab='{{$vo['ab']}}'>
									<td><input type="checkbox" class="pantbc" /><input type="button" class="s1 pantb"
											value="同步选中" /></td>
									<th>{{$vo['name']}}</th>
									<td>
                                        @if($vo['ab']==1)
										总额(含AB盘):
										<input type="text" value='{{$vo['A']}}' class="flag je a" />
										其中B盘：
										<input type="text" value='{{$vo['B']}}' class="flag je b" />
                                        @else
										<input type="text" value='{{$vo['A']}}' class="flag je a" />
										@endif
									</td>
									<td><input type="text" value='{{$vo['maxje']}}' class="flag maxje" /></td>
									<td><input type="checkbox" class='ifok' value="1" @if($vo['ifok']==1) checked @endif /></td>
								</TR>
								@endif
								@endforeach
							</tbody>
						</table>
					</td>--}}
					</tr>
					</tbody>
					</table>
				</div>

				<div id="quickSetting"><BR />
					补货盘口:
					<select class="defaultpan">
                        @foreach($pan as $vo)
						<option value="{{$vo}}" @if($vo==$defaultpan) selected @endif>{{$vo}}盘</option>
						@endforeach
					</select>
					<input type="button" gid="{{$gid}}" class="yiwotongbu" value="以我同步{{$flname}}"><input name="xtype"
						value="setautofly" type="hidden">
				</div>

				<div class="control">
					<input type="button" value="保存" class="button send"><input type="button" value="取消" class="button"
						style="display:none">
				</div>
                @if($fenlei==100)
				<table class="data_table data_list">
					<tr>
						<Td style="text-align:left;padding:10px;line-height:150%;"> 说明：<BR />
							1、（特码B）和（正特B）在总收单金额大于(总额)的情况下才会补货，B盘优先。如总额设[1000元],B盘设[300元]，收单金额A:300元、收单金额B：500，不会自动补货。若收单金额A:300元、收单金额B:800元,向B盘补货100。若收单金额A:800元、收单金额B:500元,优先向B盘走200，然后向A盘补货100。<BR />
							2、只有允许(内补)，才会自动补货。<BR />
							3、只有当(总开关)和(分类开关都)开启时， 才会发生自动补货！<BR />
							4、两面玩法以两边金额的差额来计算，连码、过关、生肖连、尾数连、特肖连最大占成为(单组金额)，其余为(单号金额)！<BR />
							5、系统将对超过〈最高占成〉金额1元以上自动补货，不足1元不会自动补货.<BR />
							6、随时可以更改(最高占成)金额 及 手动补货，请仔细设置，如有不明应咨询上级！ </d>
					</tr>
				</table>
				@endif
			</form>
		</div>
		</div>
		<div id='test'></div>
		<script language="javascript">
			var gid = {{$gid}};
			$(function() {
				myready();
			});
		</script>
	</body>
</html>
