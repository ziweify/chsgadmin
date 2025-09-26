<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>开奖管理</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript" src="/xypone/default/js/ui/jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight500;
				obj.style.height = h+"px"; //调整父页面中IFrame的高度为此页面的高度
			}
            var gid = "{{$gid}}";
		</script>
		<script language="javascript" src="/xypone/default/js/default/jshide/kjmyadmin.js?v=2222"></script>
		<link href="/xypone/default/css/control.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/ball.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/betslib.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="/xypone/default/js/My97DatePicker/WdatePicker.js">
		</script>
		<style>
			.top_tb th {
				width: 130px;
				cursor: pointer
			}
			.top_tb th,
			.top_tb td {
				height: 30px;
				line-height: 30px;
				text-align: left;
			}

			.top_tb td {
				padding-left: 10px;
				text-align: left;
			}

			.top_tb th {
				padding-left: 10px;
				text-align: left;
			}

			.kjtb {
				margin-bottom: 10px;
			}

			.small {
				width: 40px;
			}

			.kjtb img {
				clear: both
			}

			.txt1 {
				width: 30px;
			}

			.txt2 {
				width: 85px;
			}

			.txt3 {
				width: 105px;
			}

			.txt31 {
				width: 145px;
			}

			.txt5 {
				width: 80px;
			}

			.txt6 {
				width: 60px;
			}

			.wd100 {
				margin-bottom: 10px;
			}

			.cmd input {
				margin-left: 5px;
			}

			.cmd select {
				margin-left: 5px;
			}

			.kjjr .ma {
				font-weight: bold;
				font-size: 16px;
			}

			.editkj {
				position: absolute;
				width: 1260px;
				background: #fff;
				border: 2px solid #000;
				display: none
			}

			.cmd .textb {
				width: 65px;
			}

			body {
				font-size: 11px;
			}

			.xbody1 {
				width: 1260px;
			}

			.qiua {
				margin: 0px;
				float: left;
				width: 26px;
				height: 26px;
				background: url(/xypone/default/imgn/ball_blue1.png);
				line-height: 26px;
				text-align: center;
				margin-right: 2px;
				font-weight: bold;
				margin-left: 5px;
			}

			.hm{
				/* display: flex; */
				justify-content: center;
			}

			.qiub {
				margin: 0px;
				float: left;
				width: 26px;
				height: 26px;
				background: url(/xypone/default/imgn/ball_red1.png);
				line-height: 26px;
				text-align: center;
				margin-right: 2px;
				font-weight: bold;
					margin-left: 5px;
			}

			.pikj {
				position: absolute;
				width: 630px;
				background: #fff;
				border: 2px solid #000;
				display: none;
				z-index: 100
			}

			.xxtb {
				width: 1100px;
				position: absolute;
				background: #fff;
				display: none;
				border: 2px solid #000
			}

			.zes {
				cursor: pointer;
				text-decoration: underline;
				color: #D50000
			}

			.hm img {
				margin-right: 5px;
			}

			tr.z1 {
				background: #69F
			}

			a.red {
				color: red
			}

			.btnf {
				margin-right: 5px;
			}

			.chu {
				color: red;
				font-weight: bold
			}

			.data_table {
				margin-bottom: 5px;
			}

			label {
				color: red
			}
		</style>
	</head>
	<body class="skin_blue">
		<div class="main">
			<div class="top_info">
				<span class="title">开奖管理</span><span class="right"></span>
                <select class="game">
                    @foreach($lotterys as $vo)
                        <option value="{{$vo['gid']}}" @if($vo['gid']==$gid) selected @endif>{{$vo['gname']}}</option>
                    @endforeach
                </select>
			</div>
			<table class="data_table">
				<thead>
					<tr>
						<th>彩种选择</th>
						<th>当前期</th>
						<th>自动开奖</th>
						<th>自动开关盘</th>
						{{--<th>特码状态</th>
						<th>正码状态</th>--}}
					</tr>
				</thead>
				<tr>
					<td>{{$game[0]['gname']}}</td>
					<td><label>{{$game[0]['thisqishu']}}</label></td>
					<td><img src='/xypone/default/img/{{$game[0]["autokj"]}}.gif' id="autokj" class="status" /></td>
					<td><img src='/xypone/default/img/{{$game[0]["autoopenpan"]}}.gif' id="autoopenpan" class="status" /></td>
				</tr>
				</tr>
			</table>
            @if($game[0]['guanfang']==1)
			<table class="data_table">
				<thead>
					<th>自动开奖设置</th>
					<th>控制方式</th>
					<th>开奖模式(庄)</th>
					<th>开始控制金额</th>
					<th>随机数[100-500]</th>
					<th style="display: none;">指定会员输赢</th>
					<th>占成模式</th>
					<th>盈利上限</th>
					<th>
						操作
					</th>
					</tr>
				</thead>
				<tr>
					<td>{{$game[0]['gname']}}</td>
					<td>
						<input type="radio" name='cjmode' value="0" @if($cs['cjmode']==0)checked @endif />采集官方&nbsp;
						<input type="radio" name='cjmode' value="1" @if($cs['cjmode']==1)checked @endif />系统开奖
						{{--<input type="radio" name='cjmode' value="2" @if($cs['cjmode']==2)checked @endif />系开投递--}}
					</td>
					<td>
						<div style="float: left;width:10%">
							<input type="radio" name='xtmode' value="0" @if($cs['xtmode']==0) checked @endif />随机开
						</div>
						<div style="float: left;color: red;width:30%">
							<input type="radio" name='xtmode' value="3" @if($cs['xtmode'] == 3) checked @endif />随机赢&nbsp;
							<input type="radio" name='xtmode' value="2" @if($cs['xtmode']==2) checked @endif />赢最多&nbsp;
							<input type="radio" name='xtmode' value="1" @if($cs['xtmode']==1) checked @endif />赢最少
						</div>
						<div style="float: left;color: green;width:30%">
							<input type="radio" name='xtmode' value="-1" @if($cs['xtmode']==-1) checked @endif />输最少&nbsp;
							<input type="radio" name='xtmode' value="-2" @if($cs['xtmode']==-2) checked @endif />输最多&nbsp;
							<input type="radio" name='xtmode' value="-3" @if($cs['xtmode']==-3) checked @endif />随机输&nbsp;
						</div>
						<div style="float: left;color: blue;width:30%;display: none">
							<input type="radio" name='xtmode' value="5" @if($cs['xtmode']==5) checked @endif />指定中奖率&nbsp;
							<select class="txt2 shenglv" style="width: 70px;">
								<option value="21" @if($cs['shenglv']==21) selected @endif>2期中1</option>
								<option value="31" @if($cs['shenglv']==31) selected @endif>3期中1</option>
								<option value="32" @if($cs['shenglv']==32) selected @endif>3期中2</option>
								<option value="41" @if($cs['shenglv']==41) selected @endif>4期中1</option>
								<option value="42" @if($cs['shenglv']==42) selected @endif>4期中2</option>
								<option value="43" @if($cs['shenglv']==43) selected @endif>4期中3</option>
								<option value="51" @if($cs['shenglv']==51) selected @endif>5期中1</option>
								<option value="52" @if($cs['shenglv']==52) selected @endif>5期中2</option>
								<option value="53" @if($cs['shenglv']==53) selected @endif>5期中3</option>
								<option value="54" @if($cs['shenglv']==54) selected @endif>5期中4</option>
								<option value="61" @if($cs['shenglv']==61) selected @endif>6期中1</option>
								<option value="71" @if($cs['shenglv']==71) selected @endif>7期中1</option>
								<option value="72" @if($cs['shenglv']==72) selected @endif>7期中2</option>
								<option value="73" @if($cs['shenglv']==73) selected @endif>7期中3</option>
								<option value="81" @if($cs['shenglv']==81) selected @endif>8期中1</option>
								<option value="83" @if($cs['shenglv']==83) selected @endif>8期中3</option>
								<option value="91" @if($cs['shenglv']==91) selected @endif>9期中1</option>
								<option value="92" @if($cs['shenglv']==92) selected @endif>9期中2</option>
							</select>
						</div>
					</td>
					<td>
						<input type="number" class="txt2 kongje" value="{{$cs['kongje']}}" />元
					</td>
					<td>
						<input type="number" class="txt2 suiji" value="{{$cs['suiji']}}" />
					</td>
					<td style="display: none;">
						<input type="radio" name='zhiding' value="0" @if($cs['zhiding']==0) checked @endif />不指定&nbsp;
						<input type="radio" name='zhiding' value="1" @if($cs['zhiding']==1) checked @endif />赢&nbsp;
						<input type="radio" name='zhiding' value="-1" @if($cs['zhiding']==11) checked @endif />输&nbsp;
						<input type="text" class="txt2 zduser" value="{{$cs['zduser']}}" />
					</td>
					<td>
						<input type="radio" name='zcmode' value="0" @if($cs['zcmode']==0) checked @endif />总额&nbsp;
						<input type="radio" name='zcmode' value="1" @if($cs['zcmode']==1) checked @endif />占成
					</td>
					<td>
						<input type="number" class="txt2 ylup" value="{{$cs['ylup']}}" />元
					</td>
					<td><input type="button" value="修改" class="editguanfang" /></td>
				</tr>
				</tr>
				<tr>
					<td colspan="8">随机数越大越精确，但计算速度比较慢!任何模式只要总投注金额小于【起控金额】，都是随机开!当天盈利大于【盈利上限】后随机开,【盈利上限】为0不限制。</td>
				</tr>
			</table>
			@endif
            @if($game[0]['fast']!=0 && $adminInfo['ifhide']==1)
			<table class="data_table kpcs">
				<thead>
					<tr>
						<th>开盘参数设置</th>
						<th>首期开盘时间</th>
						<th>开盘时间2</th>
						<th>期数间隔(分)</th>
						<th>提前关盘时间(秒)</th>
						<th>期数</th>
						<th>总期数</th>
						<th>开始日期</th>
						<th>开始期数</th>
						<th>调整期数</th>
						<th>开奖推迟(秒)</th>
						<th>开盘推迟(秒)</th>
						<th>操作</th>
					</tr>
				</thead>
				</tr>
				<tr>
					<td>{{$game[0]['gname']}}</td>
					<td><input type="text" class="txt2 starttime" value="{{$cs['starttime']}}" /></td>
					<td><input type="text" class="txt2 starttime2" value="{{$cs['starttime2']}}" /></td>
					<td><input type="text" class="txt2 qsjg" value="{{$cs['qsjg']}}" /></td>
					<td><input type="text" class="txt2 closetime" value="{{$cs['closetime']}}" /></td>
					<td><input type="text" class="txt2 qsnums" value="{{$cs['qsnums']}}" /></td>
					<td><input type="text" class="txt2 qishunum" value="{{$cs['qishunum']}}" /></td>
					<td><input type="text" class="txt2 startdate" value="{{$cs['startdate']}}" /></td>
					<td><input type="text" class="txt2 startqs" value="{{$cs['startqs']}}" /></td>
					<td><input type="text" class="txt2 tzqs" value="{{$cs['tzqs']}}" /></td>
					<td><input type="text" class="txt2 tuichi" value="{{$cs['tuichi']}}" /></td>
					<td><input type="text" class="txt2 tuichikp" value="{{$cs['tuichikp']}}" /></td>
					<td><input type="button" value="修改" class="editkpcs" /> </td>
				</tr>
				<tr>
					<td colspan="13">注:请不要随便修改，不明白咨询管理员!</td>
				</tr>
			</table>
			@endif
			<table class="data_table pikj">
				<tr>
					<th><input type="button" class="pikjsend" value="提交数据" /><input type="button" class="pikjclose"
							value="关闭" style="margin-left:20px;" /><input type="button" class="pikjclear" value="清空"
							style="margin-left:20px;" /></th>
				</tr>
				<tr>
					<th><textarea class='pikjtxt' cols="70" rows="8"></textarea></th>
				</tr>
				<tr>
					<th style="text-align:left;padding-left:5px;">数据格式：期数开奖号码，中间用半角逗号(,)隔开,结尾也必须有一个逗号.<BR />
						如重庆时时彩：201201012,6,7,1,2,6,<BR />
						如广东快乐十分：2013011243,19,12,02,08,18,07,17,03,<BR />
					</th>
				</tr>
			</table>
			<table class="data_table addkj">
				<tr>
					<th>期数</th>
					<th>开盘时间</th>
					<th>关盘时间</th>
					<th>开奖时间</th>
					<th rowspan=2><input type="button" value="增加期数" class="add" /></th>
					<td rowspan="2" style="display: none;">
						日期:<input type="text" class="pdate txt5 date" value="{{$sdate[10]}}" /><BR />
						<input type="button" value="批量增加期数" class="padd" />
					</td>
				</tr>
				<tr>
					<td><input type="text" class='qishu txt2' value="{{$game[0]['thisqishu']+1}}" /></td>
					<td><input type="text" class="opendate txt5 date" value="{{$sdate[10]}}" />&nbsp;<input type="text"
							class="opentime txt6" value="17:00:00" /></td>
					<td><input type="text" class="closedate txt5 date" value="{{$sdate[10]}}" />&nbsp;<input type="text"
							class="closetime txt6" value="21:30:00" /></td>
					<td><input type="text" value="{{$sdate[10]}}" class="kjdate txt5 date" />&nbsp;<input type="text"
							value="21:35:00" class="kjtime txt6" /></td>
				</tr>
			</table>
			<table class="data_table cmd">
				<tr>
					<td colspan="2" style="text-align:left">日期:<input class='txt5 date' id="start" value='{{$sdate[10]}}'
							size='11' />
						&nbsp;—&nbsp;
						<input class='txt5 date' id="end" name='end' value='{{$sdate[10]}}' size='11' />
						<input type="button" class="s" d=1 value="今天" />
						<input type="button" class="s" d=2 value="昨天" />
						<input type="button" class="s" d=3 value="本星期" />
						<input type="button" class="s" d=4 value="上星期" />
						<input type="button" class="s" d=5 value="本月" />
						<input type="button" class="s" d=6 value="上月" />
                        @if($adminInfo['ifhide']==1)
						<input type="button" value='删除选定日期数据' class="deldate" t=1 />
						<input type="button" value='删除指定日期之前' class="deldate" t=2 />
						<span>选定项:</span>
						<input type="button" value='期数去重复' class="qsqc" date='{{$sdate[10]}}' />
                        @endif
					</td>
				</tr>
				<tr>
					<td><input type="radio" class="jsstatus" name="jsstatus" value="2" />全部<input type="radio"
							class="jsstatus" name="jsstatus" value="0" />未结算<input type="radio" class="jsstatus"
							name="jsstatus" value="1" checked />已结算<!--<input type="button" value="更新开奖"
							class="updatekj" /><input type="button" value='批量开奖' class="pikjcmd" /><input type="button"
							value='批量结算' class="pijs" />--><input type="button"
																   value='同步168' class="tb168" /><select class="psize">
							<option value="50">每页50条</option>
							<option value="120" selected>每页120条</option>
							<option value="250">每页250条</option>
							<option value="500">每页500条</option>
							<option value="1200">每页1200条</option>
						</select><input type="hidden" value="1" class="page" />
						&nbsp;&nbsp;<input type="checkbox" class="ze" value="1" />有注单&nbsp;&nbsp;共<label
							class="rcount chu"></label>期
					</td>
					<td style="width:42%"></td>
				</tr>
			</table>
			<table class="data_table list kjjr table_ball"></table>

			<table class="data_table editkj">

				<tr>
					<th>期数</th>
					<th>开盘时间</th>
					<th>关盘时间</th>
					<th>开奖时间</th>
					<th>号码</th>
					<th rowspan="2"><input type="button" value="修改" class="editkjsend" /><BR /><input type="button"
							value="关闭" class="editkjclose" /></th>
				</tr>

				<tr>
					<td><label></label></td>
					<td><input type="text" class="txt31 eopentime" /></td>
					<td><input type="text" class="txt31 eclosetime" /></td>
					<td><input type="text" class="txt31 ekjtime" /></td>
					<td class="kjhm"></td>
				</tr>
			</table>
		</div>
		<table class="data_table list xxtb">
			<thead>
				<style>
					.ts1{
						display: flex;
						align-items: center;
						justify-content: center;
					}
				</style>
				<tr class="bt">
					<th style="width:80px">彩种</th>
					<th>期數</th>
					<th>类别</th>
					<th><a href="javascript:void(0);" class="je ts1">金額<img style="margin-left: 3px;" src="/xypone/default/img/down.gif" s='up' /></th>
					<th>赔率</th>
					<th>退水</th>
					<th>会员</th>
					<th><a href="javascript:void(0);" class="time ts1">时间<img style="margin-left: 3px;" src="/xypone/default/img/down.gif" s='down' />
					</th>
				</tr>
			</thead>
		</table>

		<input type="hidden" class='sort' orderby='time' sorttype='DESC' page='1' xtype='2' tztype='0' con='' />
		<iframe id='longfrm' style="display:none;"></iframe>
		<div id='test' style="clear:both"></div>
		<script language="javascript">
			sdate = new Array();
            @foreach($sdate as $i=>$vo)
				sdate[{{$i}}] = "{{$vo}}";
			@endforeach
			var fenlei = {{$fenlei}};
			var ngid = {{$gid}};
            $(function() {
                myready();
            });
		</script>
	</body>
</html>
