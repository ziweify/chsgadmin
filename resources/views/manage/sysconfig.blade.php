<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>参数设置</title>
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
		<script languag="javascript" src="/xypone/default/js/default/jshide/sysconfigmyadmin.js?v=111112"></script>
		<style>
			.infotb th {
				text-align: right;
				padding-right: 5px;
				width: 160px;
				line-height: 150%;
				height: 30px;
			}

			.infotb td {
				text-align: left;
				padding-left: 5px;
				line-height: 150%;
				height: 30px;
			}

			.infotb td.mid {
				text-align: center
			}

			label {
				color: #D50000
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">参数设置</span><span class="right"></span>
			</div>
			<input type="hidden" name="xtype" value="setsys" />
			<table class="data_table list infotb">
				<tr>
					<th>网站开关</th>
					<td><input type="checkbox" @if($config['ifopen']==1) checked @endif class="ifopen" /></td>
					<th>密码修改提示</th>
					<td><input type="text" value='{{$config['passtime']}}' class="passtime txt1" />天</td>
				</tr>
				<tr>
					<th>登陆停留</th>
					<td><input type="text" value='{{$config['livetime']}}' class="livetime txt1" />分</td>
					<th>两次投注间隔</th>
					<td><input type="text" value='{{$config['tzjg']}}' class="tzjg txt1" />秒</td>
				</tr>
				<tr>
					<th>超级密码</th>
					<td><input type='text' class="txt1 supass" /></td>
					<th>网站类型</th>
					<td><select class="moneytype">
							<OPTION value="0" @if($config['moneytype']=='0') selected @endif>信用网</OPTION>
							<OPTION value="1" @if($config['moneytype']=='1') selected @endif>现金网</OPTION>
						</select></td>
				</tr>
				<tr>
					<th>转账密码</th>
					<td>@if($moneypassflag==1)已绑定@else未绑定@endif&nbsp;&nbsp;<a href="javascript:void(0)"
							class='czmoneypass'>重置</a></td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th>盈利限制倍数</th>
					<td><input type='text' class="txt1 yingxz" value='{{$config['yingxz']}}' /></td>
					<th>盈利限制金额</th>
					<td><input type='text' class="txt1 yingxzje" value='{{$config['yingxzje']}}' /></td>
				</tr>
				<tr>
					<!--<th>自动报码</th><td><input type="checkbox" @if($config['autobaoma']==1) checked @endif class="autobaoma" /></td>-->
					<th>PK10牛牛庄家选位</th>
					<td><input type="text" value='{{$config['pk10num']}}' class="pk10num txt3" /></td>
					<th>最高派彩</th>
					<td><input type="text" value='{{$config['maxpc']}}' class="maxpc txt1" /></td>
				</tr>
				<tr>
					<!--<th>自动报码</th><td><input type="checkbox" @if($config['autobaoma']==1) checked @endif class="autobaoma" /></td>-->
					<th>PK10无牛通杀点数</th>
					<td><input type="text" value='{{$config['pk10ts']}}' class="pk10ts txt3" /></td>
					<th>PK10牛牛玩法开关</th>
					<td><input type="checkbox" @if($config['pk10niu']==1) checked @endif class="pk10niu" /></td>
				</tr>
				<tr>
					<th>快开信用额度恢复</th>
					<td><select class="reseted">
							<OPTION value="week" @if($config['reseted']=='week') selected @endif>每周</OPTION>
							<OPTION value="day" @if($config['reseted']=='day') selected @endif>每天</OPTION>
						</select></td>
					<th>自动恢复赔率</th>
					<td><input type="checkbox" @if($config['autoresetpl']==1) checked @endif class="autoresetpl" /></td>
				</tr>
				<tr style="display: none;">
					<th>退水修改开始时间</th>
					<td><input type="text" value='{{$config['editstart']}}' class="editstart txt1" /></td>
					<th>退水修改结束时间</th>
					<td><input type="text" value='{{$config['editend']}}' class="editend txt1" /></td>
				</tr>
				<tr>
					<th>第一级运营自动降倍</th>
					<td><input type="checkbox" @if($config['comattpeilv']==1) checked @endif class="comattpeilv" /></td>
					<th>运营商自动补货</th>
					<td><input type="checkbox" @if($config['flyflag']==1) checked @endif class="flyflag" /></td>
				</tr>
				<tr>
					<th>运营商修改占成</th>
					<td><input type="checkbox" @if($config['editzc']==1) checked @endif class="editzc" /></td>
					<th>运营商删除用户</th>
					<td><input type="checkbox"  @if($config['deluser']==1) checked @endif class="deluser" /></td>
				</tr>
				<tr>
					<th>自动降倍双面联动</th>
					<td><input type="checkbox" @if($config['autold']==1) checked @endif class="autold" /> *如:降双同时降单</td>
					<th>自动识别手机/PC</th>
					<td><input type="checkbox" @if($config['loginfenli']==1) checked @endif class="loginfenli" /></td>
				</tr>
				<tr>
					<th>自动降倍赔率还原</th>
					<td><select class="plresetfs">
							<OPTION value="now" @if($config['plresetfs']=='now') selected @endif>开出即还原</OPTION>
							<OPTION value="next" @if($config['plresetfs']=='next') selected @endif>停留一期还原</OPTION>
						</select></td>
					<th>占成模式</th>
					<td>
						<select class="zcmode">
							<OPTION value="0" @if($config['zcmode']==0) selected @endif>默认</OPTION>
							<OPTION value="1" @if($config['zcmode']==1)} selected @endif>按彩种</OPTION>
						</select>
					</td>
				</tr>
				<tr>
					<th>赔率差设置</th>
					<td>
						<select class="plc">
							<OPTION value="0" @if($config['plc']==0) selected @endif>关闭</OPTION>
							<OPTION value="1" @if($config['plc']==1) selected @endif>开启</OPTION>
						</select>
					</td>
					<th>单注最小</th>
					<td><input type="text" class='minje txt1' value='{{$config['minje']}}'></td>
				</tr>
				<tr>
					<th>撤单功能状态</th>
					<td>
						<select class="chedan_status">
							<OPTION value="0" @if($config['chedan_status']==0) selected @endif>关闭</OPTION>
							<OPTION value="1" @if($config['chedan_status']==1) selected @endif>开启</OPTION>
						</select>
					</td>
                    @if($adminInfo['ifhide']==1)
					<th>站点类型</th>
					<td>
						<select class="sys_tmp">
							<OPTION value="138" @if($config['sys_tmp']=='138') selected @endif>138</OPTION>
							<OPTION value="idc" @if($config['sys_tmp']=='idc') selected @endif>idc</OPTION>
						</select>
					</td>
					@endif
				</tr>
			</table>
			<div class="control" style="margin-top: 10px;">
				<input type="button" value="保存" class="button editall" />
			</div>
		</div>
		<script language="javascript">
			$(function() {
				myready();
			});
		</script>
		<div id='test'></div>
	</body>
</html>
