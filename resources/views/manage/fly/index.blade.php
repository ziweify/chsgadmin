<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>飞单设置</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=33" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript" src="/xypone/default/js/jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight + 500;
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
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

			.game_class a {
				text-align: left;
			}
		</style>
	</head>
	<body id="topbody">
		<script id=myjs language="javascript">
			var js = 0;
			$(function() {
				changeh();
				$(".pantb .edit").click(function() {
					var posi = $(this).position();
					var obj = $(this).parent().parent();
					$(".edittb").show();
					$(".edittb").css("left", posi.left + 30 - $(".edittb").width());
					$(".edittb").css("top", posi.top + 30);
					$(".edittb .isable").val(obj.find(".isable").attr("val"));
					$(".edittb .name").val(obj.find(".name").html());
					$(".edittb .webtype").val(obj.find(".webtype").attr("val"));
					$(".edittb .url1").val(obj.find(".url").attr("url1"));
					$(".edittb .url2").val(obj.find(".url").attr("url2"));
					$(".edittb .username").val(obj.find(".username").html());
					$(".edittb .abcd").val(obj.find(".abcd").html());
					$(".edittb .passwd").val(obj.find(".passwd").html());
					$(".edittb .searchcode").val(obj.find(".searchcode").html());
					$(".edittb .txje").val(obj.find(".txje").html());
					$(".edittb .flyjiabei").val(obj.find(".flyjiabei").html());
					$(".edittb .stopying").val(obj.find(".stopying").html());
					$(".edittb .stopshu").val(obj.find(".stopshu").html());
					$(".edittb .zhidingagent").val(obj.find(".zhidingagent").html());
					$(".edittb .zhidinguser").val(obj.find(".zhidinguser").html());
					$(".edittb .game").html(obj.find(".game").html());
					$(".edittb").attr("fid", obj.attr("fid"));
				});
				$(".edittb .close").click(function() {
					$(".edittb").hide();
				});
				$("input.add").click(function() {
					$.ajax({
						url: 'addflyinfo',
						type: 'POST',
						success: function(m) {
                            if(m.status == 200){
                                window.location.href = window.location.href;
                            }
                            alert(m.msg);
						}
					})
				});
				$("input.del").click(function() {
					var id = $(this).parent().parent().attr('fid');
					var pass = prompt("请输入密码:", "");
					if(pass){
						$.ajax({
							url: 'delfly',
							data: {id: id, pass: pass},
							type: 'POST',
							success: function(m) {
                                alert(m.msg);
                                if(m.status == 200){
                                    window.location.href = window.location.href;
                                }
							}
						})
					}
				});
				$("input.send").click(function() {
					var game = [];
					$(".edittb .game input:checkbox").each(function(i) {
						var vs = {};
						vs.gid = $(this).attr("gid");
						vs.ifok = 0;
						if ($(this).prop("checked")) {
							vs.ifok = 1
						}
						game[i] = vs
					});
					var obj = $(".edittb");
					var v = {};
					v.name = obj.find("input.name").val();
					v.webtype = obj.find("select.webtype").val();
					v.username = obj.find("input.username").val();
					v.abcd = obj.find("input.abcd").val();
					v.passwd = obj.find("input.passwd").val();
					v.txje = obj.find("input.txje").val();
					v.isable = obj.find("select.isable").val();
					v.searchcode = obj.find("input.searchcode").val();
					v.url1 = obj.find("input.url1").val();
					v.url2 = obj.find("input.url2").val();
					v.flyjiabei = obj.find("input.flyjiabei").val();
					v.stopying = obj.find("input.stopying").val();
					v.stopshu = obj.find("input.stopshu").val();
					v.zhidingagent = obj.find("input.zhidingagent").val();
					v.zhidinguser = obj.find("input.zhidinguser").val();
					v.id = obj.attr("fid");
					v.game = game;
					$.ajax({
						url: 'editflyinfo',
						data: {data:JSON.stringify(v)},
						type: 'POST',
						success: function(m) {
							if(m.status == 200){
                                window.location.href = window.location.href;
                            }
                            alert(m.msg);
						}
					})
				});
				getstatus();
				$(".login").click(function() {
					var fid = $(this).parent().parent().attr("fid");
					var obj = $(this);
					//alert(obj.attr("step"));
					if (obj.attr("step") == '0') {
						$("#loginjs").html("");
						var rr = Math.random();
						$.ajax({
							type: 'POST',
							url: 'flygetcode',
							data: {fid: fid, rr: rr},
							dataType: 'json',
							success: function(m) {
                                m = m.data;
								if (m.status == '1') {
									$("#webtype").val(m.webtype);
									if (m.webtype == 'WS') {
										var info = encodeURIComponent(m.data.user) + "," +
											encodeURIComponent(m.data.passwd);
										var result = callSecretBase2(info, m.data.gk);
										var vk = result.vk;
										var logpk = result.logpk;
										var code = "";
										$.ajax({
											type: 'POST',
											url: 'fly.php?xtype=login',
											data: "imgcode=" + code + "&info=" + vk +
												"&pk=" + logpk,
											dataType: 'json',
											success: function(m) {
												if (m.status == '1') {
													getstatus();
												} else {
													alert('登陆失败!');
												}
											}
										})
										return true;
									}
									if (m.webtype == 'IDC') {
										obj.parent().parent().find(".imgcode").attr("src", m.data);
										obj.attr("step", '1');
										return true;
									}
									if (m.webtype == 'SGWIN') {
										obj.parent().parent().find(".imgcode").attr("src", m.data);
										obj.attr("step", '1');
										return true;
									}
									if (m.webtype == 'BW' || m.webtype == 'BWSSC') {
										//$.getScript(m.loginjs);
										$("#loginjs").attr("src", m.loginjs);
										$("#loginhtml").html(m.loginhtml);
										obj.parent().parent().find(".imgcode").attr("src", m.data);
										$("#txtUid").val(m.user);
										$("#txtPwd").val(m.pass);
										obj.attr("step", '1');
										return true;
									}

									if (m.webtype == 'DL' || m.webtype == 'ZYSIX') {
										obj.attr("step", '1');
										obj.click();
										return true;
									}
								} else {
									alert('获取图片验证码失败!')
								}
							}
						})
					} else if (obj.attr("step") == '1') {
						var code = obj.parent().parent().find(".flycode").val();
						if ($("#webtype").val() == "BW" || $("#webtype").val() == "BWSSC") {
							$("#txtCode").val(code);
							code = buildCode();
						}
						$.ajax({
							type: 'POST',
							url: 'flylogin',
							data: {fid: fid, imgcode: code},
							dataType: 'json',
							success: function(m) {
                                m = m.data;
								if (m.status == '1') {
									obj.parent().parent().find(".imgcode").attr("src", m.data);
									alert(m['err']);
									obj.attr("step", 1);
								} else if (m.status == '200') {
									alert("登陆成功");
									playVoice('/xypone/default/js/sound/login.wav', 'cash-voice1');
									getstatus();
								} else {
									alert('获取图片验证码失败!')
								}
							}
						})
					}
				});

				$(".logout").click(function() {
					var fid = $(this).parent().parent().attr("fid");
					$.ajax({
						type: 'POST',
						url: 'logoutfly',
						data: {fid: fid},
						success: function(m) {
							getstatus();
						}
					});
				});
			});

			function setstatus(arr, obj) {
				try {
					if ((!isNaN(arr['balance']) || typeof(arr["balance"]) == 'number') && arr['balance'] != null && arr['balance'] != "") {
						obj.find(".loginstatuss").css("color", 'green');
						obj.find(".loginstatuss").html("正在挂机");
						obj.find(".balances").html(arr['balance']);
						obj.find(".wjss").html(arr['wjs']);
						obj.find(".sys").html(arr['sy']);
						obj.find(".names").html(arr['name']);
						obj.find(".login").hide();
						obj.find(".logout").show();
						obj.find(".login").attr("step", '2');
						if (arr["webtype"] == "BWSSC") {
							obj.find(".login").show();
							obj.find(".login").attr("step", '0');
						}
					} else {
						obj.find(".loginstatuss").css("color", 'red');
						obj.find(".loginstatuss").html("已经掉线...............");
						obj.find(".balances").html("");
						obj.find(".wjss").html("");
						obj.find(".sys").html("");
						obj.find(".names").html("");
						obj.find(".login").show();
						obj.find(".logout").hide();
						obj.find(".login").attr("step", '0');
					}
				} catch (e) {

				}
			}

			function getstatus() {
				var rr = Math.random();
				$("tr.nr").each(function() {
					var fid = $(this).attr("fid");
					var obj = $(this);
					$.ajax({
						type: 'POST',
						url: 'getflystatus',
						data: {fid: fid, rr: rr},
						dataType: 'json',
						success: function(m) {
							setstatus(m.data, obj)
						}
					})
				});
			}

			function playVoice(src, domId) {
				var $dom = $('#' + domId)
				if ($.browser.msie) {
					// IE用bgsound标签处理声音
					if ($dom.length) {
						$dom[0].src = src;
					} else {
						$('<bgsound>', {
							src: src,
							id: domId
						}).appendTo('body');
					}
				} else {
					// IE以外的其它浏览器用HTML5处理声音
					if ($dom.length) {
						$dom[0].play();
					} else {
						$('<audio>', {
							src: src,
							id: domId
						}).appendTo('body')[0].play();
					}
				}
			}
		</script>

		<style>
			.txt1 {
				width: 100px;
			}

			.txt2 {
				width: 300px;
			}

			.flycode {
				width: 50px;
			}

			.edittb th {
				width: 120px;
				text-align: right;
				padding-right: 5px;
			}

			.pantb td {
				line-height: 30px;
			}
		</style>
		<div class="main">
			<div class="top_info">
				<span class="title">平台飞单设置</span><span class="right"></span>
			</div>
			<h3 style="float: none;margin: 0px auto;text-align: center;margin-top: 20px;">飞单网站信息</h3>
			<table class="list data_table pantb">
				<thead>
					<TR>
						<th>id</th>
						<th>名称</th>
						<th>网站类型</th>
						<th>网址</th>
						<th>开关</th>
						<th>用户名</th>
						<th>ABCD盘</th>
						<th>登陆状态</th>
						<th style="display: none;">登陆账号</th>
						<th>账户余额</th>
						<th>今日输赢</th>
						<th>未结算金额</th>
						<!--<th>报表</th>-->
						<th>图片验证码</th>
						<th><input type="button" class="add" value="增加"></th>
						<th class="hide">密码</th>
						<th class="hide">提醒金额</th>
						<th class="hide">验证码</th>
						<th class="hide">飞单加倍</th>
						<th class="hide">飞单加倍止盈</th>
						<th class="hide">飞单加倍止损</th>
						<th class="hide">指定代理飞单</th>
						<th class="hide">指定会员飞单</th>
					</TR>
				</thead>
                @foreach($fly as $vo)
				<tr class="nr" fid='{{$vo['id']}}'>
					<td>{{$vo['id']}}</td>
					<td class="name">{{$vo['name']}}</td>
					<td class="webtype" val='{{$vo['webtype']}}'>{{$vo['webtype']}}</td>
					<td style="line-height: 120%" url1='{{$vo['url1']}}' url2='{{$vo['url2']}}' class="url">
						<a href='{{$vo['url1']}}' target="_blank">{{$vo['url1']}}</a><BR>
						<a href='{{$vo['url2']}}' target="_blank">{{$vo['url2']}}</a>
					</td>
					<td class="isable" val='{{$vo['isable']}}'>
						@if($vo['isable']==0)关闭 @else 启用 @endif
					</td>
					<td class="username">{{$vo['username']}}</td>
					<td class="abcd">{{$vo['abcd']}}</td>
					<td class="loginstatuss"></td>
					<td class="loginusers" style="display: none;"></td>
					<td class="balances"></td>
					<td class="sys"></td>
					<td class="wjss"></td>
					<!--<td class="bao"><a href='javascript:void(0)'>报表</a></td>-->
					<td><img src='' class="imgcode" /><input type="text" class="flycode" value="" /></td>
					<td>
						<input type="button" class="del" value="删除">
						<input type="button" class="edit" value="修改">
						<input type="button" value="登陆" class="login" step='0'>
						<input type="button" value="退出登陆" class="logout hide">
					</td>
					<td class="hide passwd">{{$vo['passwd']}}</td>
					<td class="hide txje">{{$vo['txje']}}</td>
					<td class="hide searchcode">{{$vo['searchcode']}}</td>
					<td class="hide flyjiabei">{{$vo['flyjiabei']}}</td>
					<td class="hide stopying">{{$vo['stopying']}}</td>
					<td class="hide stopshu">{{$vo['stopshu']}}</td>
					<td class="hide zhidingagent">{{$vo['zhidingagent']}}</td>
					<td class="hide zhidinguser">{{$vo['zhidinguser']}}</td>
					<td class="hide game">
                        @foreach($vo['game'] as $vb)
						<div class="game"><input type="checkbox" @if($vb['ifoks']==1)checked @endif gid="{{$vb['gid']}}" />{{$vb['gname']}}&nbsp;&nbsp;({{$vb['gid']}})</div>
						@endforeach
					</td>
				</tr>
                @endforeach
			</table>

			<table class="list data_table edittb"
				style="background: #fff;width: 800px;position: absolute;display: none;">
				<tr>
					<th colspan="2" style="text-align: center;"><input type="button" class="send" value="保存">
						<input type="button" class="close" value="关闭">
					</th>
				</tr>
				<tr>
					<th>名称</th>
					<td> <input type="text" class="name txt1" value="" /> </td>
				</tr>
				<tr>
					<th>网站类型</th>
					<td> <select class="webtype">
							<option value="IDC">IDC</option>
							<option value="SGWIN">SGWIN</option>
						</select> </td>
				</tr>
				<tr>
					<th>网址</th>
					<td>
						1、<input style="width: 300px" type="text" class="url1 txt2" value="" /><BR />
						2、<input style="width: 300px" type="text" class="url2 txt2" value="" />
					</td>
				</tr>
				<tr>
					<th>开关</th>
					<td>
						<select class="isable">
							<option value="0">关闭</option>
							<option value="1">启用</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>用户名</th>
					<td><input type="text" class="username txt1" value="" /></td>
				</tr>
				<tr>
					<th>密码</th>
					<td><input type="text" class="passwd txt1" value="" /></td>
				</tr>
				<tr>
					<th>验证码</th>
					<td><input type="text" class="searchcode txt1" value="" /></td>
				</tr>
				<tr>
					<th>余额提醒</th>
					<td><input type="text" class="txje txt1" value="" /></td>
				</tr>
				<tr>
					<th>飞单加倍</th>
					<td><input type="text" class="flyjiabei txt1" value="" />%&nbsp;&nbsp;*100%不加倍,50%飞一半,200%,加一倍</td>
				</tr>
				<tr>
					<th>飞单加倍止盈</th>
					<td><input type="text" class="stopying txt1" value="" />&nbsp;&nbsp;*超过飞单加倍设为100%</td>
				</tr>
				<tr>
					<th>飞单加倍止损</th>
					<td><input type="text" class="stopshu txt1" value="" />&nbsp;&nbsp;*超过飞单加倍设为100%</td>
				</tr>
				<tr>
					<th>指定代理飞单</th>
					<td><input type="text" class="zhidingagent" style="width: 300px;" value="" />&nbsp;&nbsp;*多个用,隔开
					</td>
				</tr>
				<tr>
					<th>指定会员飞单</th>
					<td><input type="text" class="zhidinguser" style="width: 300px;" value="" />&nbsp;&nbsp;*多个用,隔开</td>
				</tr>
				<tr>
					<th>ABCD盘</th>
					<td><input type="text" class="abcd txt1" value="" /></td>
				</tr>
				<tr>
					<th>游戏</th>
					<td class="game"></td>
				</tr>
			</table>

			<div id='tests'></div>

			<script src="/xypone/hide/js/BigInt.js" type="text/javascript"></script>
			<script src="/xypone/hide/js/Barrett.js" type="text/javascript"></script>
			<script src="/xypone/hide/js/RSA.js" type="text/javascript"></script>
			<script type="text/javascript" src="/xypone/hide/js/Secret.js"></script>

			<script type="text/javascript" id="loginjs"></script>
			<div id="loginhtml" style="display: none;"></div>
			<input type="hidden" id="webtype" value="" />
	</body>
</html>
