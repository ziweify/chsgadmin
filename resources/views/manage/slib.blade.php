<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>即时注单</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/control.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/ball.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/betslib.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="/xypone/default/js/ui/jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight + 500;
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jshide/slibnewmyadmin.js?v=2221"></script>
		<!--<link href="/css/default/uitz.css" rel="stylesheet" type="text/css" />-->
		<style type="text/css">
			.flys {
				background: yellow
			}

			.black {
				color: #000
			}

			.red {
				color: Red !important
			}

			.lv {
				color: green !important
			}

			.warn {
				background: #F2F2F2
			}

			.now th.bred {
				background: #0284c3;
				color: #eee
			}

			.now td.bover {}

			input.small {
				width: 45px;
			}

			td.byellow {
				background: #FC3
			}

			td.bc {
				background: #DDE1FD
			}

			.onepeilvtb {
				position: absolute;
				display: none;
				background: #fff;
				width: 180px;
			}

			.xxtb {
				position: absolute;
				display: none;
				background: #fff;
				width: 1000px;
			}

			.flytb {
				position: absolute;
				display: none;
				background: #fff;
				width: 1000px;
			}

			.sendtb td {
				text-align: center
			}

			.atts {
				font-weight: normal;
				cursor: pointer;
			}

			.downs {
				margin-right: 5px;
				color: red;
			}

			.ups {
				margin-left: 5px;
				color: green;
			}
			.ts1 {
			    display: flex;
			    align-items: center;
			    justify-content: center;
			}
		</style>
		<style type="text/css">
			.T107 .item  .b1 {color: #90926a !important;}
			.T107 .item .b2 {color: #3a84c1 !important;}
			.T107 .item .b3 {color: #0e111a !important;}
			.T107 .item .b4 {color: #db7e31 !important;}
			.T107 .item .b5 {color: #4bc2c0 !important;}
			.T107 .item .b6 {color: #210569 !important;}
			.T107 .item .b7 {color: #616370 !important;}
			.T107 .item .b8 {color: #be0d17 !important;}
			.T107 .item .b9 {color: #82454a !important;}
			.T107 .item .b10 {color: #206538 !important;}
			.T107 .item b {
				margin: 0px;
				height: 20px;
				color: #2836f4;
				font-size: 15px;
				font-family: Arial, Helvetica, Verdana, Geneva, sans-serif;
				font-weight: bold !important;
				background: #F2F2F2 !important;
				text-indent:0;
			}
		</style>
	</head>
	<body class="skin_blue">
		<script id=myjs language="javascript">
			function json_encode_js(aaa) {
				var i, s, a, aa = [];
				if (typeof(aaa) != "object") {
					alert("ERROR json");
					return
				}
				for (i in aaa) {
					s = aaa[i];
					a = '"' + i + '":';
					if (typeof(s) == 'object') {
						a += json_encode_js(s)
					} else {
						a += '"' + s + '"'
					}
					aa[aa.length] = a
				}
				return "{" + aa.join(",") + "}"
			}

			function getResult(num, n) {
				return Math.round(num * Math.pow(10, n)) / Math.pow(10, n)
			}

			function getresult(num, n) {
				return num.toString().replace(new RegExp("^(\\-?\\d*\\.?\\d{0," + n + "})(\\d*)$"), "$1") + 0
			}

			function strlen(sString) {
				var sStr, iCount, i, strTemp;
				iCount = 0;
				sStr = sString.split("");
				for (i = 0; i < sStr.length; i++) {
					strTemp = escape(sStr[i]);
					if (strTemp.indexOf("%u", 0) == -1) {
						iCount = iCount + 1
					} else {
						iCount = iCount + 2
					}
				}
				return iCount
			}

			function rhtml(str) {
				return str.match(/<a\b[^>]*>[\s\S]*?<\/a>/ig)
			}
		</script>

		<div class="main">
			<div class="top_info">
				<span id="drawNumber" class="title">&nbsp;</span>
				<div class="op">
					<select id='qishu'>
                        @foreach($qishu as $vo)
							<option value="{{$vo}}">{{$vo}}期</option>
						@endforeach
					</select>
					<input type="button" class="btn1 btnf" value="刷新" id='reload' />
					<label class="time" style='color:red'></label>
					<span>秒</span><input style="margin-left: 4px" type="button" class="btn3 btnf" value="暂停" id='zanting' />
					<select id='reloadtime'>
						<option value="10">10秒</option>
						<option value="15">15秒</option>
						<option value="20">20秒</option>
						<option value="30">30秒</option>
						<option value="45">45秒</option>
						<option value="60" selected>60秒</option>
					</select>
					<label class="bresult">今日输赢：<span id="bresult">{{$jrsy}}</span></label>
					<select id="abcd">
						<option value="">全部</option>
						<option value="A">A盘</option>
						<option value="B">B盘</option>
						<option value="C">C盘</option>
						<option value="D">D盘</option>
					</select>
					<select id=ab style="display:none">
						<option value="0">AB盤</option>
						<option value="A">A</option>
						<option value="B">B</option>
					</select>
					<select id='xsort'>
						<option value="ks" selected>按盈亏排</option>
						<option value="zje">按虚货排</option>
						<option value="zc">按实货排</option>
						<option value="zs">按注数</option>
					</select>
					<select id='userid' layer='{{$layer}}'>
						<option value="">选择下线</option>
                        @foreach($topuser as $vo)
							<option value="{{$vo['userid']}}">{{$vo['username']}}</option>
						@endforeach
					</select>
					<select id="amountMode" class='libstyle'>
						<option value="0" v='zc'>实占</option>
						<option value="1" v='zje'>虚注</option>
						<option value="2" v='fly'>补货</option>
					</select>

					<input type="button" class="btn3 btnf hide" value="赔率設置" id='pset' />
					<span>显示:</span>
					<select class="plmode">
						<option value="1" selected>当前赔率</option>
						<option value="4">默认赔率</option>
					</select>
					<input type="button" class="btn3 btnf moren" value="写入默认" ac='writemoren' />
					<input type="button" class="btn3 btnf moren" value="恢复默认" ac='resetmoren' />

					<select id="selectitem">
						<option value="">选择类型</option>
						<option value="全部">全部</option>
						<option value="数字">数字</option>
						<option value="双面">双面</option>
                        @if($fenlei==103)
						<option value="四季">四季</option>
						<option value="五行">四季</option>
						<option value="方位">方位</option>
						<option value="中发白">中发白</option>
                        @endif
					</select>
					<select id='psettype'>
						<option value="0">減</option>
						<option value="1">加</option>
					</select>
					<input type="number" style="width:60px;" value="0.1" id='psetattvalue' />
					<input type="button" class="btn1 btnf" value="加/減" id='psetatt' />
					<input type="button" class="btn1 btnf" value="送出" id='psetsend' />
					<input type="button" class="btn1 btnf" value="提交" id='psetpost' />
					<input type="button" class="btn3 btnf" value="取消" id='psetcancel' />
					<input type="button" class="btnf" value="设置所有双面" id='pism' />
					<input type="button" class="btnf" value="同步{{$flname}}" id='yiwotongbu' />
					<!--<input type="button" class="btn1 downfast btnf" value="下载未结算" />-->
				</div>
				<div class="right">

				</div>
			</div>

			<div id="totals">
				<table class="data_table now">
					<thead>
						<tr>
                            @foreach($b as $vo)
								<th bid='{{$vo['bid']}}' class="n{{$vo['bid']}}">{{$vo['name']}}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
                        @foreach($b as $vo)
						<td bid='{{$vo['bid']}}' bname='{{$vo['name']}}' class="n nx{{$vo['bid']}}"></td>
                        @endforeach
					</tbody>
				</table>
			</div>

			<div id="main" class="contents">
				<table class="layout list lib T{{$fenlei}}">
					<tbody></tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
			</div>

			<div class="control data_footer input_panel">
				<span id="backControl">
					<!--<span>快速补货：</span><input type="text" class="input">    <label><input type="radio" name="backAmountType" value="0" checked="checked">平均盈亏</label>
					<label><input type="radio" name="backAmountType" value="1">占成金额</label>
					<input type="button" class="calc button" value="计算补货"> -->
					<select id='fly' class='hide'>
						<option value="2">外补</option>
					</select><input type="button" class='button hide' id='pfly' value="批量补货" />
				</span>
			</div>
		</div>

		<table class="xxs data_table list xxtb">
			<thead>
				<tr>
					<th>注单号</th>
					<th><a href="javascript:void(0);" class="time ts1">投注时间<img style="margin-left: 3px;" src="/xypone/default/img/down.gif" s='down' /></a></th>
					<th>种类</th>
					<th>类型</th>
					<th>账号</th>
					<th>投注内容</th>
					<th><a href="javascript:void(0);" class="je ts1">金額<img style="margin-left: 3px;" src="/xypone/default/img/down.gif" s='up' /></a></th>
					<th>退水(%)</th>
					<th>本级占成</th>
					<th>占成明细</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<table class="xxs data_table list flytb">
			<thead>
				<tr>
					<th>注单号</th>
					<th><a href="javascript:void(0);" class="time ts1">投注时间<img src="/xypone/default/img/down.gif" s='down' /></a></th>
					<th>投注种类</th>
					<th>账号</th>
					<th>投注内容</th>
					<th><a href="javascript:void(0);" class="je ts1">金額<img src="/xypone/default/img/down.gif" s='up' /></a></th>
					<th>退水(%)</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<table class="data_table onepeilvtb T{{$fenlei}} mms">
			<thead>
				<th colspan="2">赔率设置</th>
			</thead>
			<tr>
				<th>項目</th>
				<TD></td>
			</tr>
			<TR>
				<th>赔率</th>
				<TD><input type='text' class="txt1" style="width:50px;" /></TD>
			</TR>
			<TR>
				<td colspan="2" align="center"><input type="button" class="btn1 btnf onesend" value='提交' />
					<input type="button" value='关闭' class="btn1 btnf oneclose" style="margin-left:10px;" />
				</td>
			</TR>
		</table>

		<table class="tinfo sendtb">

		</table>
		<input type="hidden" class='sort' orderby='time' sorttype='DESC' page='1' xtype='5' con='' />

		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable mx"
			tabindex="-1" role="dialog" aria-describedby="shares" aria-labelledby="ui-id-1"
			style="position: absolute; height: 152.28px; width: 360px; top: 257px; left: 564.5px; display:none; right: auto; bottom: auto;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">2988316036# 占成明细</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="shares" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 96px; max-height: 346px; height: auto;">
				<table class="data_table">
					<thead>
						<tr>
							<th>类型</th>
							<th>账号</th>
							<th>占成</th>
							<th>退水</th>
							<th>赔率</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;">
			</div>
			<div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
		</div>




		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable sendtb"
			tabindex="-1"
			style="display:none;position:absolute; height: auto; width: 600px; top: 100px; left: 300px;  z-index: 101;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">补货明细（请确认注单）</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="betsBox" class="ui-dialog-content ui-widget-content"
				style="width: auto; min-height: 0px; max-height: none; height: auto;">
				<div class="betList">
					<table class="data_table list">
						<thead>
							<tr>
								<th>序号</th>
								<th>号码</th>
								<th>赔率</th>
								<th class='tpoints'>退水</th>
								<th>金额</th>
								<th>删除</th>
							</tr>
						</thead>
						<tbody id="betlist"></tbody>
					</table>
				</div>
				<div class="bottom"><span id="bcount"></span><span id="btotal"></span></div>
				<div><label class='plts'><input style="display:none;" type="checkbox"
							id="ignoreOdds">如赔率变化，按最新赔率投注，成功后提示赔率变化</label><label style="display:none;"
						class='cgts red'>请[点击左上角]或[按回车键]关闭本窗口中,5秒后自动关闭本窗口!</label></div>
			</div>
			<div class="ui-dialog-buttonset" style="text-align: center"><button type="button" class="ui-button qr"><span
						class="ui-button-text">确定</span></button><button type="button" class="ui-button close"
					role="button"><span class="ui-button-text">取消</span></button></div>
		</div>

		<div class="ui-widget-overlay ui-front ui-fronts" style="z-index: 100;display:none;"></div>
		<iframe id="downfastfrm" style="display:none;"></iframe>
		<input id='test2' type="text" class="hide" />
		<div id='test'></div>

		<script language="javascript">
			layername = new Array();
            @foreach($layername as $key=>$vo)
                layername[{{$key}}] = "{{$vo}}";
            @endforeach
			var maxlayer = layername.length;
			var layer = {{$layer}};
			var pself = 0;
			var ifexe = 0;
            @if($layer == 1)
				ifexe = {{$ifexe}};
				pself = {{$pself}};
			@endif
			var style = '{{$class}}';
			var ngid = {{$gid}};
			var fenlei = {{$fenlei}};
			sma = new Array();
			sma['g101'] = new Array();
			sma['g101'][0] = new Array();
			sma['g101'][0]['name'] = "单";
			sma['g101'][0]['ma'] = new Array(1, 3, 5, 7, 9);
			sma['g101'][1] = new Array();
			sma['g101'][1]['name'] = "双";
			sma['g101'][1]['ma'] = new Array(0, 2, 4, 6, 8);
			sma['g101'][2] = new Array();
			sma['g101'][2]['name'] = "大";
			sma['g101'][2]['ma'] = new Array(5, 6, 7, 8, 9);
			sma['g101'][3] = new Array();
			sma['g101'][3]['name'] = "小";
			sma['g101'][3]['ma'] = new Array(0, 1, 2, 3, 4);
			sma['g101'][4] = new Array();
			sma['g101'][4]['name'] = "质";
			sma['g101'][4]['ma'] = new Array(1, 2, 3, 5, 7);
			sma['g101'][5] = new Array();
			sma['g101'][5]['name'] = "合";
			sma['g101'][5]['ma'] = new Array(0, 2, 4, 6, 7);
			sma['g103'] = new Array();
			sma['g103'][0] = new Array();
			sma['g103'][0]['name'] = "单";
			sma['g103'][0]['ma'] = new Array(1, 3, 5, 7, 9, 11, 13, 15, 17, 19);
			sma['g103'][1] = new Array();
			sma['g103'][1]['name'] = "双";
			sma['g103'][1]['ma'] = new Array(2, 4, 6, 8, 10, 12, 14, 16, 18, 20);
			sma['g103'][2] = new Array();
			sma['g103'][2]['name'] = "大";
			sma['g103'][2]['ma'] = new Array(11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
			sma['g103'][3] = new Array();
			sma['g103'][3]['name'] = "小";
			sma['g103'][3]['ma'] = new Array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
			sma['g103'][4] = new Array();
			sma['g103'][4]['name'] = "合单";
			sma['g103'][4]['ma'] = new Array(1, 3, 5, 7, 9, 10, 12, 14, 16, 18);
			sma['g103'][5] = new Array();
			sma['g103'][5]['name'] = "合双";
			sma['g103'][5]['ma'] = new Array(2, 4, 6, 8, 11, 13, 15, 17, 19, 20);
			sma['g103'][6] = new Array();
			sma['g103'][6]['name'] = "尾大";
			sma['g103'][6]['ma'] = new Array(5, 6, 7, 8, 9, 15, 16, 17, 18, 19);
			sma['g103'][7] = new Array();
			sma['g103'][7]['name'] = "尾小";
			sma['g103'][7]['ma'] = new Array(1, 2, 3, 4, 10, 11, 12, 13, 14, 20);
			sma['g103'][8] = new Array();
			sma['g103'][8]['name'] = "春";
			sma['g103'][8]['ma'] = new Array(1, 2, 3, 4, 5);
			sma['g103'][9] = new Array();
			sma['g103'][9]['name'] = "夏";
			sma['g103'][9]['ma'] = new Array(6, 7, 8, 9, 10);
			sma['g103'][10] = new Array();
			sma['g103'][10]['name'] = "秋";
			sma['g103'][10]['ma'] = new Array(11, 12, 13, 14, 15);
			sma['g103'][11] = new Array();
			sma['g103'][11]['name'] = "冬";
			sma['g103'][11]['ma'] = new Array(16, 17, 18, 19, 20);
			sma['g103'][12] = new Array();
			sma['g103'][12]['name'] = "金";
			sma['g103'][12]['ma'] = new Array(1, 6, 11, 16);
			sma['g103'][13] = new Array();
			sma['g103'][13]['name'] = "木";
			sma['g103'][13]['ma'] = new Array(2, 7, 12, 17);
			sma['g103'][14] = new Array();
			sma['g103'][14]['name'] = "水";
			sma['g103'][14]['ma'] = new Array(3, 8, 13, 18);
			sma['g103'][15] = new Array();
			sma['g103'][15]['name'] = "火";
			sma['g103'][15]['ma'] = new Array(4, 9, 14, 19);
			sma['g103'][16] = new Array();
			sma['g103'][16]['name'] = "土";
			sma['g103'][16]['ma'] = new Array(5, 10, 15, 20);

			sma['g103'][17] = new Array();
			sma['g103'][17]['name'] = "东";
			sma['g103'][17]['ma'] = new Array(1, 5, 9, 13, 17);
			sma['g103'][18] = new Array();
			sma['g103'][18]['name'] = "南";
			sma['g103'][18]['ma'] = new Array(2, 6, 10, 14, 18);
			sma['g103'][19] = new Array();
			sma['g103'][19]['name'] = "西";
			sma['g103'][19]['ma'] = new Array(3, 7, 11, 15, 19);
			sma['g103'][20] = new Array();
			sma['g103'][20]['name'] = "北";
			sma['g103'][20]['ma'] = new Array(4, 8, 12, 16, 20);

			sma['g103'][21] = new Array();
			sma['g103'][21]['name'] = "中";
			sma['g103'][21]['ma'] = new Array(1, 2, 3, 4, 5, 6, 7);
			sma['g103'][22] = new Array();
			sma['g103'][22]['name'] = "发";
			sma['g103'][22]['ma'] = new Array(8, 9, 10, 11, 12, 13, 14);
			sma['g103'][23] = new Array();
			sma['g103'][23]['name'] = "白";
			sma['g103'][23]['ma'] = new Array(15, 16, 17, 18, 19, 20);

			sma['g105'] = new Array();
			sma['g105'][0] = new Array();
			sma['g105'][0]['name'] = "单";
			sma['g105'][0]['ma'] = new Array(1, 3, 5, 7, 9);
			sma['g105'][1] = new Array();
			sma['g105'][1]['name'] = "双";
			sma['g105'][1]['ma'] = new Array(2, 4, 6, 8, 10);
			sma['g105'][2] = new Array();
			sma['g105'][2]['name'] = "大";
			sma['g105'][2]['ma'] = new Array(6, 7, 8, 9, 10);
			sma['g105'][3] = new Array();
			sma['g105'][3]['name'] = "小";
			sma['g105'][3]['ma'] = new Array(1, 2, 3, 4, 5);

			sma['g107'] = new Array();
			sma['g107'][0] = new Array();
			sma['g107'][0]['name'] = "单";
			sma['g107'][0]['ma'] = new Array(1, 3, 5, 7, 9);
			sma['g107'][1] = new Array();
			sma['g107'][1]['name'] = "双";
			sma['g107'][1]['ma'] = new Array(2, 4, 6, 8, 10);
			sma['g107'][2] = new Array();
			sma['g107'][2]['name'] = "大";
			sma['g107'][2]['ma'] = new Array(6, 7, 8, 9, 10);
			sma['g107'][3] = new Array();
			sma['g107'][3]['name'] = "小";
			sma['g107'][3]['ma'] = new Array(1, 2, 3, 4, 5);
			sma['g107'][4] = new Array();
			sma['g107'][4]['name'] = "质";
			sma['g107'][4]['ma'] = new Array(1, 2, 3, 5, 7);
			sma['g107'][5] = new Array();
			sma['g107'][5]['name'] = "合";
			sma['g107'][5]['ma'] = new Array(4, 6, 8, 9, 10);
			$(function() {
				myready();
			});
		</script>
		<iframe name=sfrm id=sfrm style="display:none;"></iframe>
	</body>
</html>
