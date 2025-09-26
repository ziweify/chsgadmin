<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>在线管理</title>
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
		<script languag="javascript" src="/xypone/default/js/default/jshide/onlinemyadmin.js?v=11111"></script>
		<style>
			.xxtb {
				display: none;
				position: absolute;
				width: 1000px;
				background: #fff
			}

			.click {
				background: #E3F1FF
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">在线会员</span>
			</div>

			<TABLE class="data_table data_list">
				<tr>
					<th>管理员</th>
					<th>代理</th>
					<th>会员</th>
				</tr>
				<tr>
                    @foreach($num as $i=>$vo)
						<td class="type @if($type==$i)click @endif" type='{{$i}}' style="cursor: pointer;text-decoration: underline;">{{$vo}}</td>
					@endforeach
				</tr>
			</TABLE><BR />

			<table class="data_table data_list list on_tb">
				<tr>
					<td colspan="14">{!! $page !!}</td>
				</tr>
				<thead>
					<TR>
						<th><input type="checkbox" id='clickall' />全选</th>
						<th>用户名</th>
						<th>
							<SELECT class="selectcom">
								<OPTION value="">所属</OPTION>
                                @foreach($com as $vo)
								<OPTION value="{{$vo['id']}}">{{$vo['name']}}</OPTION>
								@endforeach
							</SELECT>
							<LABEL class="chu red"></LABEL>
						</th>
                        @if($type==2)
						<th>信用度</th>
						<th>余额</th>
						<th>未结算</th>
						@endif
						<th>位置</th>
						<th>登陆时间</th>
						<th>最后活动</th>
						<th>IP</th>
						<th>来源</th>
						<th>服务器</th>
						<th>客户端</th>
						<th><input type="button" value="踢出选中" id='delall' class='btn3 btnf' /></th>
					</TR>
				</thead>
                @foreach($on as $vo)
				<TR class="com" id="{{$vo['com']}}">
					<TD><input type="checkbox" value="{{$vo['uid']}}" />{{$vo['i']}}</TD>
					<Td class='tl'>{{$vo['username']}}({{$vo['name']}})</Td>
					<td class='up'><span>{{$vo['up']}}</span>
						<div class="hide">{{$vo['uplist']}}</div>
					</td>
                    @if($type==2)
					<td class="tl">{{$vo['maxmoney']}}</td>
					<td class="tl">{{$vo['money']}}</td>
					<td class='wjs tl' uid='{{$vo['uid']}}'>{{$vo['z9']}}</td>
					@endif
					<Td>{{$vo['posi']}}</Td>
					<Td>{{$vo['logintime']}}</Td>
					<Td>{{$vo['savetime']}}</Td>
					<Td>{{$vo['ip']}}</Td>
					<Td class="ip" ip=''>{{$vo['addr']}}</Td>
					<td>{{$vo['server']}}号</td>
					<td class='os'>{{$vo['os']}}</td>
					<Td><input type="button" value="踢出" class="btn1 btnf" /></Td>
				</TR>
				@endforeach
			</table>

		</div>

		<table class="data_table data_list list xxtb">
			<tr class="bt">
				<th>彩种</th>
				<th>期數</th>
				<th>類別</th>
				<th>金額</th>
				<th>赔率</th>
				<th>退水</th>
				<th>會員</th>
				<th>時間</th>
			</tr>
		</table>
		<input type="hidden" class='sort' orderby='time' sorttype='DESC' page='1' xtype='2' js='0' gid='99' con='' />
		<script language="javascript">
			$(function() {
				myready();
			});
		</script>
		<div id='test'></div>
	</body>
</html>
