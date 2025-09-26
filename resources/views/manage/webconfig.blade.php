<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>网站配置</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/webconfigmyadmin.js?v=1111112"></script>
		<style>
			td,
			th {
				height: 30px;
				line-height: 30px
			}

			.edittb {
				position: absolute;
				width: 750px;
				display: none;
				background: #fff
			}

			.edittb th {
				width: 150px;
				text-align: right;
				padding-right: 5px
			}

			.edittb td {
				text-align: left
			}

			.h {
				display: none
			}

			.edittb .txt1 {
				width: 300px
			}

			.edittb .txt2 {
				width: 80px
			}

			.infotb th {
				text-align: right;
				padding-right: 5px;
				width: 160px;
				line-height: 150%;
				height: 30px
			}

			.infotb td {
				text-align: left;
				padding-left: 5px;
				line-height: 150%;
				height: 30px
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
				<span class="title">网站配置</span><span class="right"></span>
			</div>
			<input type="hidden" name="xtype" value="setsys" />
			<table class="data_table list infotb">
				<tr>
					<th>服务器1</th>
					<td><input type="text" value='{{$config['s1']}}' class="s1" size=12 /></td>
					<th>服务器2</th>
					<td><input type="text" value='{{$config['s2']}}' class="s2" size=12 /></td>
					<th>服务器3</th>
					<td><input type="text" value='{{$config['s3']}}' class="s3" size=12 />%</td>
				</tr>
				<tr>
					<th>服务器4</th>
					<td><input type="text" value='{{$config['s4']}}' class="s4" size=12 /></td>
					<th>幸运飞艇限制倍数</th>
					<td>1/<input type="text" value='{{$config['s5']}}' class="s5" size=12 /></td>
					<th>幸运飞艇限额限制开关</th>
					<td><input type="text" value='{{$config['s6']}}' class="s6" size=12 /></td>
				</tr>
				<tr>
					<th>自动删除登录日志</th>
					<td><input type="checkbox" @if($config['autodellogin']==1) checked @endif class="autodellogin" /><input
							type="text" value='{{$config['autodellogintime']}}' class="autodellogintime txt1" />天前</td>
					<th>自动删除修改日志</th>
					<td><input type="checkbox" @if($config['autodeledit']==1) checked @endif class="autodeledit" /><input
							type="text" value='{{$config['autodeledittime']}}' class="autodeledittime txt1" />天前</td>
					<th>自动删除赔率日志</th>
					<td><input type="checkbox" @if($config['autodelpl']==1) checked @endif class="autodelpl" /><input
							type="text" value='{{$config['autodelpltime']}}' class="autodelpltime txt1" />天前</td>
				</tr>
				<tr>
					<th>开奖网址</th>
					<td><input style="width: 100%;" type="text" value='{{$config['kjip']}}' class="kjip"/></td>
					<th>startid</th>
					<td><input type="text" value='{{$config['startid']}}' class="startid" size=11 /></td>
					<th>启用右键</th>
					<td><input type="checkbox" @if($config['rkey']==1) checked @endif class="rkey" /></td>
				</tr>
				<tr>
					<th>加密码</th>
					<td><input type="text" value='{{$config['allpass']}}' class="allpass txt1" /></td>
					<th>注单加密</th>
					<td><input type="checkbox" @if($config['libkey']==1) checked @endif class="libkey" /></td>
					<th>限制人数</th>
					<td><input type="checkbox" @if($config['maxrenflag']==1) checked @endif class="maxrenflag" /></td>
				</tr>

				<tr>
					<th>每页记录数1</th>
					<td><input type="text" value='{{$config['psize']}}' class="psize txt1" /></td>
					<th>每页记录数2</th>
					<td><input type="text" value='{{$config['psize1']}}' class="psize1 txt1" /></td>
					<th>每页记录数3</th>
					<td><input type="text" value='{{$config['psize2']}}' class="psize2 txt1" /></td>

				</tr>
				<tr>
					<th>每页记录数4</th>
					<td><input type="text" value='{{$config['psize3']}}' class="psize3 txt1" /></td>
					<th>每页记录数5</th>
					<td><input type="text" value='{{$config['psize5']}}' class="psize5 txt1" /></td>
					<th>使用验证码登录</th>
					<td><input type="checkbox" @if($config['logincode']==1) checked @endif class="logincode" /></td>
				</tr>
				<tr>
					<th>系统彩投递API</th>
					<td><input style="width: 90%;" type="text" value='{{$config['sys_lot_api']}}' class="txt1 sys_lot_api txt1" /></td>
					<th>系统彩投递token</th>
					<td><input type="text" value='{{$config['sys_lot_token']}}' class="sys_lot_token txt1" /></td>
				</tr>
				<tr>
					<th>登录方式</th>
					<td><select class="loginfs">
							<option value="url" @if($config['loginfs']=='url') selected @endif>网址</option>
							<OPTION value="dk" @if($config['loginfs']=='dk') selected @endif>端口</OPTION>
							<OPTION value="code" @if($config['loginfs']=='code') selected @endif>验证码</OPTION>
						</select></td>
					<th>系统彩计算次数</th>
					<td><input type="text" value='{{$config['trys']}}' class="psize3 trys" /></td>
					<td colspan="w" class="mid"><input type="button" value="修改" class="editall btn1 btnf" /></td>
				</tr>
				<tr>
					<th>全国开奖网</th>
					<td colspan="5"><input type='text' class="txt1 kfurl" value="{{$config['kfurl']}}"
							style="width:600px;" /></td>
				</tr>
			</table>
			<BR />
			<table class="data_table data_list list ztb">
				<thead>
					<tr>
						<th>网站ID</th>
						<th>名称</th>
						<th>手机网址</th>
						<th>会员网址</th>
						<th>代理网址</th>
						<th>管理网址</th>
						<th>手机端口</th>
						<th>会员端口</th>
						<th>代理端口</th>
						<th>管理端口</th>
						<th>赔率模式</th>
						<th>最大级数</th>
						<th>操作
							<input type="button" value="添加" class="add btn1 btnf" />
						</th>
					</tr>
				</thead>
                @foreach($web as $vo)
				<tr>
					<td class="wid">{{$vo['wid']}}</td>
					<td class="webname">{{$vo['webname']}}</td>
					<td class="murl">{{$vo['murl']}}</td>
					<td class="uurl">{{$vo['uurl']}}</td>
					<td class="aurl">{{$vo['aurl']}}</td>
					<td class="hurl">{{$vo['hurl']}}</td>
					<td class="mpo">{{$vo['mpo']}}</td>
					<td class="upo">{{$vo['upo']}}</td>
					<td class="apo">{{$vo['apo']}}</td>
					<td class="hpo">{{$vo['hpo']}}</td>
					<td class="patt">{{$vo['patt']}}</td>
					<td class="maxlayer">{{$vo['maxlayer']}}</td>
					<td><input type="button" value="修改" class="edit btn1 btnf" />
						<input type="button" value="删除" class="dels btn1 btnf" />
					</td>
					<td class="h moneytype">{{$vo['moneytype']}}</td>
					<td class="h slowtype">{{$vo['slowtype']}}</td>
					<td class="h fasttype">{{$vo['fasttype']}}</td>
					<td class="h zcagent">{{$vo['zcagent']}}</td>
					<td class="h guser">{{$vo['guser']}}</td>
					<td class="h uskin">{{$vo['uskin']}}</td>
					<td class="h skins">{{$vo['skins']}}</td>
					<td class="h namehead">{{$vo['namehead']}}</td>
					<td class="h layer">{{$vo['layer']}}</td>
					<td class="h mdi">{{$vo['mdi']}}</td>
					<td class="h udi">{{$vo['udi']}}</td>
					<td class="h adi">{{$vo['adi']}}</td>
					<td class="h mdi">{{$vo['mdi']}}</td>
					<td class="h hdi">{{$vo['hdi']}}</td>
					<td class="h mpo">{{$vo['mpo']}}</td>
					<td class="h upo">{{$vo['upo']}}</td>
					<td class="h apo">{{$vo['apo']}}</td>
					<td class="h hpo">{{$vo['hpo']}}</td>
					<td class="h mcode">{{$vo['mcode']}}</td>
					<td class="h ucode">{{$vo['ucode']}}</td>
					<td class="h acode">{{$vo['acode']}}</td>
					<td class="h hcode">{{$vo['hcode']}}</td>
					<td class="h webclose">{{$vo['webclose']}}</td>
					<td class="h fastinput">{{$vo['fastinput']}}</td>
					<td class="h uimg">{{$vo['uimg']}}</td>
					<td class="h aimg">{{$vo['aimg']}}</td>
					<td class="h mimg">{{$vo['mimg']}}</td>
					<td class="h himg">{{$vo['himg']}}</td>
					<td class="h times">{{$vo['times']}}</td>
				</tr>
				@endforeach
				</tr>
			</table>
		</div>
		<table class="data_table edittb">
			<tr>
				<th colspan="2" style="text-align:center"><input type="button" value="提交" class="editnext btn1 btnf" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" value="关闭" class="close btn1 btnf" /><input type="hidden" class="action"
						value="" />
				</th>
			</tr>
			<tr>
				<th>网站ID</th>
				<td><label class="wid"></label></td>
			</tr>
			<tr>
				<th>网站名称</th>
				<td><input type="text" class="webname txt1" /></td>
			</tr>
			<tr>
				<th>用户名头【共九级】</th>
				<td><input type="text" class="namehead txt1" /></td>
			</tr>
			<tr>
				<th>层级名称【共九级】</th>
				<td><input type="text" class="layer txt1" /></td>
			</tr>
			<tr>
				<th>赔率点水模式【限HK彩】</th>
				<td><input type="text" class="patt txt1" />[1-5]</td>
			</tr>
			<tr>
				<th>最大级数</th>
				<td><input type="text" class="maxlayer txt1" /></td>
			</tr>
			<tr>
				<th>现金/信用</th>
				<td><input type="text" class="moneytype txt1" />0-信用,1-现金</td>
			</tr>
			<tr>
				<th>低频彩种</th>
				<td><input type="text" class="slowtype txt1" />(0关闭/1开放)</td>
			</tr>
			<tr>
				<th>快开彩种</th>
				<td><input type="text" class="fasttype txt1" />(0关闭/1开放)</td>
			</tr>
			<tr>
				<th>自助注册代理</th>
				<td><input type="text" class="zcagent txt1" /></td>
			</tr>
			<tr>
				<th>试用会员</th>
				<td><input type="text" class="guser txt1" />多个以逗号(,)分开</td>
			</tr>
			<tr>
				<th>会员skin</th>
				<td><input type="text" class="uskin txt1" /></td>
			</tr>
			<tr>
				<th>SKINS</th>
				<td><input type="text" class="skins txt1" />【default】</td>
			</tr>
			<tr>
				<th>会员提示</th>
				<td><textarea class="umess" cols="30" rows="5"></textarea></td>
			</tr>
			<tr>
				<th>代理提示</th>
				<td><textarea class="amess" cols="30" rows="5"></textarea></td>
			</tr>
			<tr>
				<th>手机目录</th>
				<td><input type="text" class="mdi txt1" /></td>
			</tr>
			<tr>
				<th>会员目录</th>
				<td><input type="text" class="udi txt1" /></td>
			</tr>
			<tr>
				<th>代理目录</th>
				<td><input type="text" class="adi txt1" />[agent]</td>
			</tr>
			<tr>
				<th>管理目录</th>
				<td><input type="text" class="hdi txt1" /></td>
			</tr>
			<tr>
				<th>手机端口</th>
				<td><input type="text" class="mpo txt1" /></td>
			</tr>
			<tr>
				<th>会员端口</th>
				<td><input type="text" class="upo txt1" /></td>
			</tr>
			<tr>
				<th>代理端口</th>
				<td><input type="text" class="apo txt1" /></td>
			</tr>

			<tr>
				<th>管理端口</th>
				<td><input type="text" class="hpo txt1" /></td>
			</tr>
			<tr>
				<th>手机网址</th>
				<td><input type="text" class="murl txt1" /></td>
			</tr>
			<tr>
				<th>会员网址</th>
				<td><input type="text" class="uurl txt1" /></td>
			</tr>
			<tr>
				<th>代理网址</th>
				<td><input type="text" class="aurl txt1" /></td>
			</tr>

			<tr>
				<th>管理网址</th>
				<td><input type="text" class="hurl txt1" /></td>
			</tr>
			<tr>
				<th>手机背景图</th>
				<td><input type="text" class="mimg txt1" /></td>
			</tr>
			<tr>
				<th>会员背景图</th>
				<td><input type="text" class="uimg txt1" /></td>
			</tr>
			<tr>
				<th>代理背景图</th>
				<td><input type="text" class="aimg txt1" /></td>
			</tr>
			</td>
			</tr>
			<tr>
				<th>管理背景图</th>
				<td><input type="text" class="himg txt1" /></td>
			</tr>
			</td>
			</tr>

			<tr>
				<th>手机验证码</th>
				<td><input type="text" class="mcode txt1" /></td>
			</tr>
			</td>
			</tr>
			<tr>
				<th>会员验证码</th>
				<td><input type="text" class="ucode txt1" /></td>
			</tr>
			</td>
			</tr>
			<tr>
				<th>代理验证码</th>
				<td><input type="text" class="acode txt1" /></td>
			</tr>
			</td>
			</tr>
			<tr>
				<th>管理验证码</th>
				<td><input type="text" class="hcode txt1" /></td>
			</tr>
			</td>
			</tr>
			<tr>
				<th>网站开放</th>
				<td><input type="text" class="webclose txt1" />(0关闭/1开放)</td>
			</tr>
			</td>
			</tr>
			<tr>
				<th>会员快捷输入</th>
				<td><input type="text" class="fastinput txt1" />(0关闭/1开放)</td>
			</tr>
			</td>
			</tr>
			<tr>
				<th>开关盘参数</th>
				<td>
					<TABLE class="timestb tinfo wd100">
						<tr>
							<th>彩种</th>
							<th>开盘</th>
							<th>开盘时间推后[秒]</th>
							<th>关盘时间提前[秒]</th>
						</tr>
                        @foreach($game as $i=>$vo)
						<tr class='timescs g{{$vo['gid']}}' gid={{$vo['gid']}}>
							<td>{{$vo['gname']}}</td>
							<td><input type="checkbox" value=1 @if($vo['ifopen']==1) checked @endif /></td>
							<td><input type="text" class="txt2 o" value="" />
							</td>
							<td><input type="text" class="txt2 c" value="" /></td>
						</tr>
						@endforeach
					</TABLE>
				</td>
			</tr>
		</table>
		<div id='test'></div>
	</body>
	<script language="javascript">
		$(function() {
			myready();
		});
	</script>
</html>
