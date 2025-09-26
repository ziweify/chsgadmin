<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>注单删改</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/xxtz2myadmin.js?v=11111"></script>
		<script language="javascript" type="text/javascript" src="/xypone/default/js/My97DatePicker/WdatePicker.js"></script>
		<style>
			.zd th {}
			input.vsmall {
				width: 20px;
				padding: 0px;
			}

			.points {
				width: 30px;
			}

			.kpoints {
				width: 30px;
			}

			input.bred {
				background: red
			}

			a.red {
				color: #D50000
			}

			.nowtb td {
				font-size: 10px;
			}

			.nowtb th {
				font-size: 10px;
			}

			.nowtb tr:hover {
				background: #FCF
			}

			.user tr:hover {
				background: #FCF
			}

			select {
				width: 120px;
			}

			.qishu {
				width: 210px;
			}

			.txts {
				width: 50px;
				border: 1px solid #36F
			}

			.txts2 {
				width: 90px;
				border: 1px solid #36F
			}

			.s_head .r {
				text-align: left;
				padding-left: 10px;
			}

			.con {
				width: 120px;
			}

			label {
				color: red
			}

			.contents {
				overflow-x: auto
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">注单删改<span class="right"></span>
			</div>
			<table class="data_table s_head">
				<tr style="display: none;">
					<th style="width:150px;">查询方式</th>
					<td class="r" colspan="2"><input type="radio" value="0" name="fs" checked />
						按日期
						<input type="radio" value="1" name="fs" />
						按期数&nbsp;&nbsp;
					</td>
				</tr>
				<TR style="display: none;">
					<th>期数选择</th>
					<Td style="text-align:left;padding-left:10px;" colspan="2">
						<select name="select" class=qishu>
                            @foreach($qishu as $vo)
							<option value="{{$vo}}">{$vo}}期</option>
							@endforeach
						</select>
					</Td>
				</TR>
				<tr>
					<th>日期选择</th>
					<td class="r" colspan="2"><input class='textb' id="start" value='{{$sdate[10]}}' size='11' />
						&nbsp;—&nbsp;
						<input class='textb' id="end" name='end' value='{{$sdate[10]}}' size='11' />
						<input type="button" class="s btnf" d=1 value="今天" />
						<input type="button" class="s btnf" d=2 value="昨天" />
						<input type="button" class="s btnf" d=3 value="本星期" />
						<input type="button" class="s btnf" d=4 value="上星期" />
						<input type="button" class="s btnf" d=5 value="本月" />
						<input type="button" class="s btnf" d=6 value="上月" />
					</td>
				</tr>
				<tr>
					<th>其他条件</th>
					<td class="r" colspan="3">
						会员：<input id="username" value='' />
						期数：<input id="qishu" value='' />
						彩种：<select id="gid">
								<option selected="" value="">全部</option>
                                @foreach($gamecs as $vo)
								<option value="{{$vo['gid']}}">{{$vo['gname']}}</option>
								@endforeach
							</select>
						注单状态：<select id="z">
								<option selected="" value="">全部</option>
								<option value="1">中奖</option>
								<option value="0">不中奖</option>
								<option value="2">和</option>
								<option value="7">注单取消</option>
								<option value="9">未结算</option>
							</select>
					</td>
				</tr>
				<tr>
					<th>分类选择</th>
					<td class="r" colspan="2">
						<select name="select" class='bid'>
							<option value="">全部</option>
                            @foreach($b as $vo)
							<option value="{{$vo['bid']}}">{{$vo['name']}}</option>
							@endforeach
						</select>
						<select name="select" class='sid'>
						</select>
						<select name="select" class='cid'>
						</select>
					</td>
				</tr>
				<tr>
					<th></th>
					<td colspan="2" class="r"><input class="btn1 btnf query" type="button" value="查询"
							style="margin:1px;" />
						<input class="btn1 btnf winprint" type="button" value="打印" style="margin:1px;" />
						<input type="hidden" value="{{$topid}}" id='saveuserid' LAYER="{{$layer}}" />
						<input type="hidden" id=page value="1" />
						<input type="hidden" id='topid' value="{{$topid}}" LAYER="{{$layer}}" username='{{$username}}' />
					</td>
				</tr>
				<tr style="display: none;">
					<TD></TD>
					<td style="text-align:left;padding-left:10px;"> 当前用户：
						<label class="nowuser" uid='{{$topid}}' LAYER="{{$layer}}">{{$username}}</label>
					</td>
					<td style="text-align:left;padding-left:10px;">
						<font color="blue">[返回上线]</font>：<a href='javascript:void(0)'>
							<label class="upuser" uid='{{$topid}}' LAYER="{{$layer}}"></label>
						</a>
					</td>
				</TR>
			</table>
			<!-- <table class="data_table data_list list user" style="margin-top:10px;">
			</table> -->
			<div class="contents param_panel">
				<table class="data_table data_list nowtb" style='margin-top:10px;background:#fff;width:3000px;'>
					<tr class="bt">
						<th><input type="checkbox" class="clickall" /></th>
						<th>操作</th>
						<th>彩种</th>
						<th>期数</th>
						<th>交易号</th>
						<th>类型</th>
						<th>类别</th>
						<th>大盘</th>
						<!-- <th>小盘</th> -->
						<th>注单状态</th>
						<th>内容</th>
						<th>金额</th>
						<th>赔率</th>
						<th>退水%</th>
						<th>会员</th>
						<th>时间</th>
					</tr>
				</table>
			</div>
		</div>

		<div id='test' style="margin-top:0px;"></div>
		<script language="javascript">
			layernames = new Array();
			layername = new Array();
            @foreach($layername as $i=>$vo)
			layernames[{{$i}}] = new Array();
			layernames[{{$i}}]['wid'] = {{$vo['wid']}};
			layernames[{{$i}}]['layer'] = new Array();
            @foreach($vo['layer'] as $c=>$vb)
				layernames[{{$i}}]['layer'][{{$c}}] = '{{$vb}}';
			@endforeach
			layernames[{{$i}}]['namehead'] = '{{$vo['namehead']}}';
			@endforeach
            @foreach($layername[0]['layer'] as $i=>$vo)
			layername[{{$i}}] = '{{$vo}}';
			@endforeach
			var maxlayer = layername.length;
			var layer = {{$layer}};
			sdate = new Array();
            @foreach($sdate as $i=>$vo)
			sdate[{{$i}}] = "{{$vo}}";
			@endforeach
			$(function() {
				myready();
			});
		</script>
	</body>
</html>
