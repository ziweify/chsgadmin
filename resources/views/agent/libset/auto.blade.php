<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>自动降赔</title>
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
		<script language="javascript" src="/xypone/default/js/default/jsagent/autoagent.js?v=11111"></script>
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
				<span class="title">自动降下倍设定</span><span class="right"></span>
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

				<table class="list data_table pantb">
					<thead>
						<TR>
							<th class="wd120"><input type="checkbox" class="all" />全选</th>
							<th class="wd120">类别</th>
							<th>开关</th>
							<th>预降</th>
							<th>计算方法</th>
							<th>开始下调金额-下调赔率</th>
							<th>金额变动值-下调赔率</th>
							<th>开始下调期数-下调赔率[限快开]</th>
							<th style="display:none">停止下注金额</th>
							<th>最低赔率</th>
						</TR>
					</thead>
                    @foreach($auto as $vo)
					<tr f='{{$vo['ftype']}}' class="nr">
						<td><input type="checkbox" /><input type="button" class="s1 pantb" value="同步选中" /></td>
						<th>{{$vo['name']}}</th>
						<td><input type="checkbox" class="ifok" @if($vo['ifok']==1)checked @endif /></td>
						<td><input type="checkbox" class="yj" @if($vo['yj']==1)checked @endif /></td>
						<td><select class='ifzc'>
								<option @if($vo['ifzc']==0)selected @endif value="0">全部</option>
								<option @if($vo['ifzc']==1)selected @endif value="1">占成</option>
							</select></td>
						<td><input type="text" class="flag startje" value="{{$vo['startje']}}" />
							-
							<input type="text" class="flag startpeilv" value="{{$vo['startpeilv']}}" />
						</td>
						<td><input type="text" class="flag addje" value="{{$vo['addje']}}" />
							-
							<input type="text" class="flag attpeilv" value="{{$vo['attpeilv']}}" />
						</td>
						<td><input type="text" class="flag qsnum" value="{{$vo['qsnum']}}" />
							-
							<input type="text" class="flag qspeilv" value="{{$vo['qspeilv']}}" />
						</td>
						<td style="display:none"><input type="text" class="flag stopje" value="{{$vo['stopje']}}" />
						</td>
						<td><input type="text" class="flag lowpeilv" value="{{$vo['lowpeilv']}}" /></td>
					</tr>
					@endforeach
				</table>
			</div>
			<div class="control">
				<input type="button" gid="{{$gid}}" class="button yiwotongbu" value="同步{{$flname}}">&nbsp;&nbsp;&nbsp;<input
					type="button" value="保存" class="button send"><input type="button" value="取消" class="button"
					style="display:none">
			</div>
		</div>
		<script language="javascript">
			var gid = {{$gid}};
			myready();
		</script>
		<div id='test'></div>
	</body>
</html>
