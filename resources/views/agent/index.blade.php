<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Welcome</title>
		<link href="/xypone/css/default/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/css/default/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/css/default/layout.css?v=211" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js?v=33113"></script>
		<script language="javascript">
			function hideinfo() {
				if (event.srcElement.tagName == "A") {
					window.status = event.srcElement.innerText
				}
			}
			document.onmouseover = hideinfo;
			document.onmousemove = hideinfo;
			@if($cnews > 0)
                @foreach($news as $vo)
				alert("{{$vo['content']}}");
				@endforeach
			@endif
		</script>
		<style type="text/css">
			.menus {
				width: 160px;
				background: url(/xypone/css/default/img/menu.png);
				text-align: center;
				cursor: pointer;
				float: left;
			}

			.status {
				float: left;
			}

			.games {
				display: none;
				position: absolute;
				height: 28px;
				background: #FFF;
				z-index: 99;
				width: 100%
			}

			.games li {
				height: 100%
			}

			.games a {
				display: block;
				height: 28px;
				color: #fff;
				line-height: 28px;
				background: url(/xypone/css/default/img/nav_bu.png) no-repeat left -67px;
				text-shadow: 1px 1px 0 #426b9e;
				text-align: center;
				margin: 0 2px 0 0;
				float: left;
				font-size: 14px;
				padding-left: 5px;
				padding-right: 5px;
			}

			.games a:hover {
				color: #1554BE;
				background: url(/xypone/css/default/img/nav_bu.png) no-repeat left -32px;
				text-shadow: 1px 1px 0 #f8fafd;
				font-weight: bold;
				font-size: 14px;
			}

			#online {
				cursor: pointer
			}

			.qzclose {
				padding: 2px;
			}

			.upkj {
				float: left;
				font-weight: bold;
				color: #000;
			}

			#lotterys a {
				min-width: 60px;
				height: auto;
				display: flex;
				align-items: center;
			}
		</style>
		<link href="/xypone/css/default/ball.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/default/jsagent/topagent.js?v=111111"></script>
	</head>
	<body id="topbody">
		<ul class="games" id='nav'>
			<li>
                @foreach($gamecs as $vo)
				<a gid="{{$vo['gid']}}" gname="{{$vo['gname']}}" fenlei="{{$vo['fenlei']}}" @if($gid==$vo['gid']) class="xz" @endif href="javascript:void(0)">{{$vo['gname']}}</a>
				@endforeach
			</li>
		</ul>
		<div class="header">
			<div class="top" style="position:relative">
				<div class="logo"><span>{{$webname}}</span></div>
				<div class="menu">
					<div class="expire_info">
						<div class="menus" style="display: none;"></div>
						<div class="status" style="display: none;">
							<span style="margin-left:5px;"><label class="qishu">{{$qishu}}</label>期</span><span
								class="panstatus" s='{{$panstatus}}' style="margin-left:5px;"><span>@if($panstatus==1)距封盘:@else距开盘:@endif</span><label
									class="time0">{{$pantime}}</label></span>@if($gid==100)<span s='{{$otherstatus}}'
								class="otherstatus hide" style="margin-left:5px;"><span>@if($otherstatus==1)距正码关盘:@else距正码开盘:@endif</span><label
									class="time1">{{$othertime}}</label></span>@endif&nbsp;<input type="button" value="关盘"
								class="s1 qzclose" style="display:none;" />
						</div>
						<div style="float:left;display: none;">
							<label class='upqishu chu blue' m='{{$upkj}}'>{{$upqishu}}</label><span class="hei">期开奖:</span>
						</div>
						<div class="upkj" style="display: none;">
						</div>
					</div>
					<ul class="menu_title topmenu">
						<li>
							@if($slib==1 && $status==1)<a href="javascript:void(0);" class="lib control" i=0 x="slib">即时注单</a>@endif
							@if($libset==1 && $status==1)<a href='javascript:void(0);' x="libset">自动补货</a>@endif
							@if($suser==1 && $status==1)<a href="javascript:void(0);" x='suser' i=1>用户管理</a>@endif
							@if($credit==1 && $status==1)<a href="javascript:void(0);" i=2 x='credit'>个人管理</a>@endif
							@if($slib==1 && $status==1)<!--<a href="javascript:void(0);" x='gentou'>跟投</a>-->@endif
							@if($baox==1)<a href="javascript:void(0);" target="frame" x="baox">报表查询</a>@endif
							<a href="javascript:void(0);" target="frame" x="longs">开奖结果</a>
							@if($ifexe==1 & $cssz==1 & $status==1)<a href="javascript:void(0);" target="frame" i=4 x="pset">高级功能</a>@endif
							<a href="javascript:void(0);">退出</a>
						</li>
					</ul>
				</div>
				<ul class="tools">
					<!--  <li class="tools_skin"><a href="javascript:;"><span>皮&nbsp;肤</span></a></li>-->
					<li class="tools_user"><span class="ico"></span></li>
					<li class="tools_user" style="width:66%">在线会员： 网页端：<label class="online">0</label> APP：0总在线：<label
							class="online">0</label></span><br>{{$layername}}：{{$username}}</li>
				</ul>
			</div>

			<div class="lottery nav" id="lotterys" style="display: none;">
                @foreach($gamecs as $vo)
				<a gid='{{$vo['gid']}}' fenlei='{{$vo['fenlei']}}' class='{{$vo['class']}} g{{$vo['gid']}}'>{{$vo['gname']}}</a>
				@endforeach
			</div>
            @if($slib==1)
			<ul class="menu_sub" style="display: block;">
				<li></li>
			</ul>
			@endif
            @if($libset==1)
			<ul class="menu_sub">
				<li class="menu_sub_title">当前选中：<span>注单设置</span></li>
				<li class="menu_sub_link">
					<a href="javascript:void(0)" target="frame" u='libset' type='show'>自动补货设定</a> |
					<a href="javascript:void(0)" target="frame" u='libset' type='flyrecord'>自动补货变更记录</a> <!-- |
					<a href="javascript:void(0)" target="frame" u='libset' style="display: none;" type='warn'>警示金额</a> -->
					@if($ifexe==1) |
					<a href="javascript:void(0)" target="frame" u='libset' type='auto'>自动降倍</a>@endif
				</li>
			</ul>
			@endif
            @if($suser==1)
			<ul class="menu_sub">
				<li class="menu_sub_title">当前选中：<span>用户管理</span></li>
				<li class="menu_sub_link">
					<a href="javascript:void(0)" class="usermenu selected userzsdl">直属代理</a> |
					<a href="javascript:void(0)" class="usermenu userzshy">直属会员</a> |
					<a href="javascript:void(0)" class="usermenu userqbdl">全部代理</a> |
					<a href="javascript:void(0)" class="usermenu userqbhy">全部会员</a>
					| <a href="javascript:void(0)" class="usermenu userzzh">直属子账号</a>
				</li>
			</ul>@endif
            @if($credit==1)
			<ul class="menu_sub">
				<li class="menu_sub_title">当前选中：<span>个人管理</span></li>
				<li class="menu_sub_link">
					<a href='javascript:void(0);' u='credit' type='show'>信用资料</a> |
					<a href='javascript:void(0);' u='credit' type='logininfo'>登录日志</a> |
					<a href='javascript:void(0);' u='changepass2' type='show'>变更密码</a><!-- |
					 <a href='javascript:void(0);' u='suser' type='cmoneypasse'>变更转账密码</a> |
					<a href='javascript:void(0);' u='twoyan' type='show'>二次验证</a> -->
				</li>
			</ul>
			@endif
            @if($baox==1)
			<ul class="menu_sub">
				<li></li>
			</ul>
			@endif
			<ul class="menu_sub">
				<li></li>
			</ul>
			<!-- <ul class="menu_sub">
				<li></li>
			</ul> -->
            @if($ifexe==1 && $cssz==1)
			<ul class="menu_sub">
				<li class="menu_sub_title">当前选中：<span>高级功能</span></li>
				<li class="menu_sub_link">
					<a href='javascript:void(0);' u="pset" type='show'>操盘记录</a><!-- |
					<a href='javascript:void(0);' u="cssz" type='show'>赔率参数</a> |
					<a href='javascript:void(0);' u="cssz" type='times'>开关盘时间</a> -->
				</li>
			</ul>
			@endif
		</div>
		<div id="contents">
			<iframe id="frame" name="frame" frameborder="0"
				src="/stsa/newsshow"></iframe>
		</div>
		<div id="footer" class="footer">
			<div class="notice">
				<marquee scrolldelay="90" scrollamount="4"><a id="notices" href="javascript:void(0);"
						target="frame"></a></marquee>
			</div><a href="javascript:void(0)" target="frame" class="more">更多</a>
		</div>
		<script language="javascript" id='zhishu'>
			var ngid = {{$gid}};
			var fenlei = {{$fenlei}};
			var layer = {{$layer}};
			ma = [];
			ma['紅'] = new Array(01, 02, 07, 08, 12, 13, 18, 19, 23, 24, 29, 30, 34, 35, 40, 45, 46);
			ma['藍'] = new Array(03, 04, 09, 10, 14, 15, 20, 25, 26, 31, 36, 37, 41, 42, 47, 48);
			ma['綠'] = new Array(05, 06, 11, 16, 17, 21, 22, 27, 28, 32, 33, 38, 39, 43, 44, 49);
			$(function() {
				myready();
			});
		</script>
	</body>
</html>
