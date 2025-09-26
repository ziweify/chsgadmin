<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>记录管理</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=33" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript" src="/xypone/default/js//jquery-ui.js"></script>

		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight +500;
				obj.style.height = h +"px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" type="text/javascript" src="/xypone/default/js/My97DatePicker/WdatePicker.js">
		</script>
		<script languag="javascript" src="/xypone/default/js/default/jshide/hismyadmin.js?v=11111"></script>
		<style>
			a.red {
				color: #D50000
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">管理赔率记录<span class="right"></span>
			</div>
			<div class="contents param_panel">
				<div class="game_class pages">
					<ul>
						<li><a href="javascript:void(0)" class="show" page="show">登陆记录</a>
							<a href="javascript:void(0)" class="useredit" page="useredit">会员操作记录</a>
							<a href="javascript:void(0)" class="adminedit" page="adminedit">管理操作记录</a>
							<a href="javascript:void(0)" class="agentpeilv" page="agentpeilv">公司赔率记录</a>
							<a href="javascript:void(0)" class="adminpeilv" page="adminpeilv">管理赔率记录</a>
					</ul>
				</div>
				<div class="control">
					<span>{!! $page !!}</span><span><input type="button" value="删除" class="button del" /><INPUT type="text"
							value="{{$deldate}}" class="deldate" style="width: 80px;" size=8 />之前</span>
				</div>
				<table class="data_table data_list list nrtb">
					<thead>
						<th><input type="checkbox" id='clickall' />
							全选</th>
						<th>
							<select class="game wd120">
                                @foreach($game as $vo)
								<option value="{{$vo['gid']}}" @if($vo['gid']==$gid) selected @endif>{{$vo['gname']}}</option>
								@endforeach
							</select>
						</th>
						<th>类别</th>
						<th>赔率值</th>
						<th>备注</th>
						<th>时间</th>
						<th>用户</th>
						<th><input type="button" class="btn3 btnf" id='delselect' value="删除选中" /></th>
						</TR>
					</thead>
                    @foreach($p as $vo)
					<TR>
						<td><input type="checkbox" value='{{$vo['id']}}' /></td>
						<td>{{$vo['gname']}}</td>
						<td>{{$vo['pid']}}</td>
						<td>{{$vo['peilv']}}</td>
						<td>{{$vo['auto']}}</td>
						<td>{{$vo['time']}}</td>
						<td>{{$vo['sonuser']}}</td>
						<td><input type="button" class="delone btn1 btnf" value='删除' /></td>
					</TR>
					@endforeach
				</table>
			</div>
			<script language="javascript">
				var page = 'adminpeilv';
				$(function() {
					myready();
				});
			</script>
			<div id='test'></div>
	</body>
</html>
