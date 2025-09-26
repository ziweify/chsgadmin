<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>信用资料</title>
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
		<script language="javascript" src="/xypone/default/js/default/jsagent/creditnewagent.js?v=11111"></script>
		<style type="text/css">
			tr:hover {
				background: #deedfe
			}
			.tab-wrapper {
				font-size: 13px;
				line-height: 30px;
				background: #ECEFF2;
				border-bottom: 1px solid #d0dff2;
				padding: 0 0 0 35px;
			}
			.tab-wrapper a.active {
				color: #FF8C3F;
			}
			.tab-wrapper a {
				margin-right: 8px;
				font-weight: bold;
				color: #333;
			}
		</style>
	</head>
	<body id="topbody">
		<div class="main">
			<div class="top_info">
				<span class="title">用户资料</span>
			</div>
			<div class="contents">
				<table class="data_table user_info">
					<thead>
						<tr>
							<th colspan="2">基本信息</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>账号</th>
							<td>{{$username}}({{$name}})[{{$usertype}}]</td>
						</tr>
                        @if($config['fasttype']==1)
						<tr>
							<th>快开彩额度</th>
							<td>{{$kmaxmoney}} (余额:{{$kmoney}})
							</td>
						</tr>
						@endif
                        @if($config['slowtype']==1)
						<tr style="display: none">
							<th>低频彩额度</th>
							<td>{{$maxmoney}}
								<!-- (余额:{{$money}})-->
							</td>
						</tr>
						@endif
                        @if($maxrenflag==1)
						<tr>
							<th>最多下线数</th>
							<td>{{$maxren}} (余:{{$ren}})</td>
						</tr>
						</tr>
						@endif
						<TR>
							<th>盘口类型</th>
							<TD>
                                @foreach($pan as $vo)
								<label>{{$vo}}</label>
								@endforeach
							</td>
						</TR>
						<tr style="display:none">
							<th>默认盘口</th>
							<TD><select class="pan">
                                    @foreach($pan as $vo)
									<option value="{{$vo}}" @if($vo==$defaultpan)selected @endif>{{$vo}}</option>
									@endforeach
								</select><input style="margin-left:5px;" type="button" value="更改"
									class="editpan btn2 btnf" /></td>
						</tr>
						<tr style="display: none;">
							<th>登录默认彩种</th>
							<TD><select class="gametype">
                                    @foreach($ugame as $vo)
									<OPTION value="{{$vo['gid']}}" @if($vo['gid']==$ugid)selected @endif>
										{{$vo['gname']}}</OPTION>
									@endforeach
								</select><input style="margin-left:5px;" type="button" value="更改"
									class="editgid btn2 btnf" /></td>
						</tr>
                        @if($layer==1 && $ifexe==1)
						<TR style="display:none">
							<Th>赔率模式</Th>
							<Td>
								<select class="pself">
									<option value="0" @if($pself==0)selected @endif>使用上级赔率</option>
									<option value="1" @if($pself==1)selected @endif>使用自定赔率</option>
								</select>
								<input type="button" class="btn1 btnf editpself" value="修改" />
							</Td>
						</TR> @endif
					</tbody>
				</table>
				<br />
				<div>
					<div class="tab-wrapper">
						<a id="info" href="#" class="active">彩票类</a>
					</div>
				</div>
				<div class="info_body">
					<div class="game_class">
						<ul>
                            @if($config['fasttype']==1)
							<li><span>快开彩</span>
                                @foreach($game as $vo)
                                @if($vo['fast'] != 0)
                                    <a href="javascript:void(0)" class="g{{$vo['gid']}}"
									gid='{{$vo['gid']}}'>{{$vo['gname']}}</a>
                                @endif
								@endforeach
							</li>
							@endif
                            @if($config['slowtype']==1)
							<li style="display: none"><span>低频彩</span>
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
					<table class="table data_table">
						<thead>
							<tr>
								<th>类别</th>
                                @foreach($span as $vo)
								<th class="{{$vo}} p">{{$vo}}盘退水</th>
								@endforeach
                                <th>单注最低</th>
								<th>单注最高</th>
								<th>单期最高</th>
							</tr>
							<tr>
						</thead>
						<tbody>
                            @foreach($game as $vo)
                                @foreach($vo['pan'] as $j)
								<tr gid='{{$vo['gid']}}' class="gametr g{{$vo['gid']}}">
									<th class="{{$j['class']}}" gid='{{$vo['gid']}}'>{{$j['name']}}</th>
                                    @if($j['abcd']==1)
                                        @foreach($span as $k)
                                            @if($j['ab'] == 1)
												<td class='cm'>{{data_handler1($j,$k,1)}}/{{data_handler1($j,$k,2)}}%</td>
											@else
												<td class='cm'>{{data_handler1($j,$k,3)}}%</td>
											@endif
                                        @endforeach
									@else
										<td colspan="{{data_handler2($span)}}" class='cm'>{{$j['pointsa0']}}%</td>
									@endif
									<td>{{$j['minje']}}</td>
									<td>{{$j['maxje']}}</td>
									<td>{{$j['cmaxje']}}</td>
								</tr>
                                @endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
	<script language="javascript">
		var gid = {{$gid}};
		myready();
	</script>
</html>
