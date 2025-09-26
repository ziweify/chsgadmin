
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Wellcom...</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=2" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/ball.css?v=1q" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js?v=33233"></script>
		<script language="javascript" src="/xypone/default/js/ui/jquery-ui.js"></script>
		<script language="javascript">
			function hideinfo() {
				if (event.srcElement.tagName == "A") {
					window.status = event.srcElement.innerText
				}
			}
			document.onmouseover = hideinfo;
			document.onmousemove = hideinfo;
		</script>
		<script language="javascript" src="/xypone/default/js/default/jshide/topmyadmin.js?v=111"></script>
		<style type="text/css">
			.menus {
				width: 160px;
				background: url(/xypone/default/css/img/menu.png);
				text-align: center;
				cursor: pointer;
				float: left;
				height: 26px;
				display: flex;
				justify-content: center;
				align-items: center;
				background-size: 100% 26px;
			}

			.status {
				float: left;
			}

			.games {
				display: none;
				position: absolute;
				min-height: 400px;
				background: #FFF;
				z-index: 99;
				width: 323px;

			}

			.games li {
				list-style: none;
				float: left;
				height: 100%;
				width: 160px;
				border-bottom: solid 1px #fff;
			}

			.games li:nth-child(even) {
				border-left: solid 1px #fff;
			}

			.games a {
				float: left;
				width: 160px;
				display: block;
				height: 30px;
				color: #fff;
				line-height: 30px;
				background: #1554BE;
				text-shadow: 1px 1px 0 #426b9e;
				text-align: center;
				float: left;
				font-size: 14px;
				padding-left: 5px;
			}

			.games a:hover {
				background: #629EDA;
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

			.qzclose {
				margin-right: 3px;
				margin-left: 3px;
			}
		</style>
	</head>
	<body id="topbody">
		<ul class="games" id='nav'>
            @foreach($gamecs as $vo)
			<li><a gid="{{$vo['gid']}}" gname="{{$vo['gname']}}" fenlei="{{$vo['fenlei']}}" @if($gid==$vo['gid']) class='xz' @endif
					href='javascript:void(0)'>{{$vo['gname']}}</a></li>
			@endforeach
		</ul>
		<div class="header">
			<div class="top" style="position:relative">
				<div class="logo"><span>{{$webname}}</span></div>
				<div class="menu">
					<div class="expire_info">
						<div class="menus">{{$gname}}</div>
						<div class="status"><span style="margin-left:5px;">
							<label class=qishu>{{$qishu}}</label>期</span>
							<span class="panstatus" s='{{$panstatus}}' style="margin-left:5px;"><span>
								@if($panstatus==1)距离关盘:@else距离开盘:@endif</span>
								<label class="time0">{{$pantime}}</label>
							</span>
							@if($fenlei==100)
								<span s='{{$otherstatus}}' class="otherstatus hide" style="margin-left:5px;">
									<span>@if($otherstatus==1)距正码关盘:@else距正码开盘:@endif</span>
									<label class="time1">{{$othertime}}</label>
								</span>
							@endif
							<!--<input type="button" value="关盘" class="s1 qzclose" />-->
						</div>
						<Div style="float:left;margin-left: 14px;">
							<label class='upqishu chu blue' m='{{$upkj}}'>{{$upqishu}}</label><span class="hei">期开奖:</span>
						</Div>
						<div class="upkj"></div>
					</div>
					<ul class="menu_title topmenu">
						<li>
							@if($adminInfo['ifhide']==1 || $slib==1)<a href="javascript:void(0);" class="lib control" x="slib">即时注单</a>@endif
							@if($adminInfo['ifhide']==1 || $suser==1)<a href="javascript:void(0);" x='suser'>用户管理</a>@endif
							@if($adminInfo['ifhide']==1 || $slib==1)<!--<a href="javascript:void(0);" x='gentou'>跟投</a>-->@endif
							@if($adminInfo['ifhide']==1 || $baox==1)<a href="javascript:void(0);" target="frame" x="baox">报表查询</a>@endif
							<a href="javascript:void(0);" target="frame" x="longs">开奖结果</a>
							<a href="javascript:void(0);" target="frame" i=0 x="kj">系统功能</a>
							<!-- <a href="javascript:void(0);" target="frame" i=1 class='xjgl' x="money">现金管理</a> -->
							@if($adminInfo['ifhide']==1 || $hide==1 || $adminid == 10000) <a href="javascript:void(0);" target="frame" i=2 x="zshuigameset">高级功能</a>@endif
							<a href="javascript:void(0);" target="frame" x="modifypwd">密码修改</a>
							<a href="javascript:void(0);">退出</a>
						</li>
					</ul>
				</div>
				<ul class="tools">
					<!--  <li class="tools_skin"><a href="javascript:;"><span>皮&nbsp;肤</span></a></li>-->
					<li class="tools_user"><span class="ico"></span></li>
					<li class="tools_user">在线会员：<span class="online">{{$onlinenum}}</span><br />管理员：{{$name}}</li>
				</ul>
			</div>

			<div class="lottery nav" id="lotterys">
                @foreach($gamecs as $vo)
				<a gid="{{$vo['gid']}}" class='{{$vo['class']}}@if($gid==$vo['gid']) s @endif'>
                    @if($gid==$vo['gid']){{$vo['gname']}}@else{{$vo['gname']}}@endif</a>
				@endforeach
			</div>

			<ul class="menu_sub">
				<li class="menu_sub_title">当前选中：<span>系统功能</span></li>
				<li class="menu_sub_link">
					@if($adminInfo['ifhide']==1 || $kj==1)
					<a href="javascript:void(0);" target="frame" u="kj" type='show' class="selected">开奖管理</a> |
					@endif
					@if($adminInfo['ifhide']==1 || $buhuo==1)
					<a href="javascript:void(0)" target="frame" u='libset' type='show'>补货设置</a> |
					<a href="javascript:void(0);" target="frame" u="fly" type='show'>飞单设置</a> |
					<a href="javascript:void(0);" target="frame" u="fly" type='flylog'>飞单记录</a>|
					@endif
					@if($adminInfo['ifhide']==1 || $liushui==1)
					<a href="javascript:void(0);" target="frame" u="zuanfen" type='show'>赚分设置</a> |
					@endif
					@if($adminInfo['ifhide']==1 || $libset==1)
					<a href="javascript:void(0)" target="frame" u='libset' type='warn'>警示金额</a> |
					<a href="javascript:void(0)" target="frame" u='libset' type='auto'>自动降倍</a> |
					@endif
					@if($adminInfo['ifhide']==1 || $zshui==1)
					<a href="javascript:void(0)" target="frame" u='zshui' type='ma'>号码属性</a> |
					<a href="javascript:void(0)" target="frame" u='zshui' type='ptype'>默认赔率</a> |
					<a href="javascript:void(0)" target="frame" u='zshui' type='show'>默认退水</a> |
					<a href="javascript:void(0)" target="frame" u='zshui' type='setattshow'>赔率参数</a> |
					@endif
					@if($adminInfo['ifhide']==1 || $news==1)
					<a href="javascript:void(0)" target="frame" u='news' type='show'>消息</a> |
					@endif
					@if(($adminInfo['ifhide']==1 || $xxtz2==1))
					<a href="javascript:void(0)" target="frame" u='zhudan' type='modify'>注单删改</a> |
					@endif
					@if(($adminInfo['ifhide']==1 || $caopan==1))
					<a href="javascript:void(0)" target="frame" u='caopan' type='show'>操盘员</a> |
					@endif
					@if($adminInfo['ifhide']==1 || $err==1)
                    {{--<a href="javascript:void(0)" target="frame" u='err' type='show'>异常注单</a> |--}}
					<a href="javascript:void(0)" target="frame" u='history' type='show'>记录管理</a> |
					@endif
					@if(($adminInfo['ifhide']==1 || $hide==1 || $adminid == 10000))
					<a href="javascript:void(0)" target="frame" u='sysconfig' type='show'>参数</a> |
					<a href="javascript:void(0)" target="frame" u='online' type='show'>在线</a>
					@endif
				</li>
			</ul>

            <ul class="menu_sub">
                <li class="menu_sub_title">当前选中：<span>密码修改</span></li>
                <li class="menu_sub_link">

                </li>
            </ul>

{{--			<ul class="menu_sub">
				<li class="menu_sub_title">当前选中：<span>现金管理</span></li>
				<li class="menu_sub_link">
					<a href="javascript:void(0)" target="frame" u='money' type='chongzhi'>充值管理</a> |
					<a href="javascript:void(0)" target="frame" u='money' type='tikuan'>提现管理</a> |
					<a href="javascript:void(0)" target="frame" u='money' type='moneyuser'>现金会员</a> |
					<a href="javascript:void(0)" target="frame" u='money' type='bank'>银行</a> |
					<a href="javascript:void(0)" target="frame" u='money' type='chongzhifs'>充值方式</a> |
					<a href="javascript:void(0)" target="frame" u='money' type='banknum'>银行账号</a> |
					<a href="javascript:void(0)" target="frame" u='money' type='notices'>消息管理</a> |
					<a href='javascript:void(0);' u="now" type='show'>注单管理</a>
				</li>
			</ul>--}}

			@if($hide==1 || $adminInfo['ifhide']==1 || $adminid == 10000)
			<ul class="menu_sub">
				<li class="menu_sub_title">当前选中：<span>高级功能</span></li>
				<li class="menu_sub_link">
					<!-- <a href="javascript:void(0);" target="frame" u="baox" type='oldshow'>报表查询</a> |
					<a href="javascript:void(0)" target="frame" u='xxtz' type='show'>注单明细</a> |
					<a href="javascript:void(0)" target="frame" u='now' type='show'>注单管理</a> | -->
					<a href="javascript:void(0)" target="frame" u='webconfig' type='show'>网站配置</a> |
					<a href="javascript:void(0)" target="frame" u='zshui' type='gameset'>彩种开放</a> |
					<a href="javascript:void(0)" target="frame" u='mclass' type='classpan'>玩法归类</a> |
					<a href="javascript:void(0)" target="frame" u='mclass' type='bigclass'>大分类</a> |
					<a href="javascript:void(0)" target="frame" u='mclass' type='sclass'>小分类</a> |
					<a href="javascript:void(0)" target="frame" u='mclass' type='mclass'>玩法分类</a> |
					<a href="javascript:void(0)" target="frame" u='play' type='show'>玩法列表</a> |
					{{--<a href="javascript:void(0)" target="frame" u='err' type='show'>异常注单</a> |--}}
					<a href="javascript:void(0)" target="frame" u='check' type='show'>检测</a> |
					{{--<a href="javascript:void(0)" target="frame" u='message' type='show'>会员反馈</a> |--}}
					<!-- <a href="javascript:void(0)" target="frame" u='play' type='downlist'>下载记录</a> | -->
					@if($adminInfo['ifhide']==1)
					<a href="javascript:void(0)" target="frame" u='loglist' type='loglist'>注单记录</a> |
					<a href="javascript:void(0)" target="frame" u='autozjmain' type=''>智能改单</a>
					@endif
				</li>
			</ul>
			@endif
		</div>
		<div id="contents">
			<iframe id="frame" name="frame" src='/admin/news' frameborder="0"></iframe>
		</div>
		<div id="footer" class="footer">
			<div class="notice">
				<marquee scrolldelay="90" scrollamount="4"><a id="notices" href="javascript:void(0);"
						target="frame"></a>
				</marquee>
			</div>
			<a href="javascript:void(0)" target="frame" class="more">更多</a>
		</div>

		<div id="dialog" title="您有新的交易请求" style="display:none;">
			<p style="text-align:center">
				<button class="clqq s1">前往处理</button>
			</p>
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
