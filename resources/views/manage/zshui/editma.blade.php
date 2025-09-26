<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>号码属性</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=33" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript" src="/xypone/default/js//jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight+500;
				obj.style.height = h+"px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jshide/editmamyadmin.js?v=11111"></script>
		<style>
			.addtb {
				width: 200px;
				display: none;
				position: absolute;
				background: #fff
			}

			.addtb td {
				text-align: left;
			}

			.v {
				text-align: left;
				padding-left: 5px;
			}

			.v input {
				width: 600px;
			}

			.name {
				text-align: center
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">号码属性</span><span class="right"></span>
			</div>
			<table class="data_table list s_tb">
				<thead>
					<TR>
						<th style='width:10%'>项目</th>
						<th style='width:70%'>号码</th>
						<th style='width:10%'>操作</th>
						<th style='width:10%'>删除</th>
					</TR>
				</thead>
                @foreach($ma as $i=>$vo)
				<TR>
					<td><INPUT type='text' class="name" value="{{$i}}" size=10 /></td>
					<td class='v'><INPUT type='text' class="val" value="{{$vo}}" size=100 /></td>
					<td></td>
					<td><input type="button" class='del btnf' value='删除' /></td>
				</TR>
				@endforeach
			</table>
			<div class="control">
				<input type="button" class="button edit" value='提交' />&nbsp;&nbsp;&nbsp;<input type="button"
					class="button add" value='添加' />
			</div>
		</div>
		<div id='test'></div>
		<SCRIPT language="javascript">
			var ma = new Array();
			ma['單'] = new Array(1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29, 31, 33, 35, 37, 39, 41, 43, 45, 47, 49);
			ma['雙'] = new Array(2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40, 42, 44, 46, 48);
			ma['大'] = new Array(25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48,49);
			ma['合單'] = new Array(1, 3, 5, 7, 9, 10, 12, 14, 16, 18, 21, 23, 25, 27, 29, 30, 32, 34, 36, 38, 41, 43, 45, 47, 49);
			ma['合雙'] = new Array(2, 4, 6, 8, 11, 13, 15, 17, 19, 20, 22, 24, 26, 28, 31, 33, 35, 37, 39, 40, 42, 44, 46, 48);
			ma['尾大'] = new Array(5, 6, 7, 8, 9, 15, 16, 17, 18, 19, 25, 26, 27, 28, 29, 35, 36, 37, 38, 39, 45, 46, 47, 48, 49);
			ma['尾小'] = new Array(1, 2, 3, 4, 10, 11, 12, 13, 14, 20, 21, 22, 23, 24, 30, 31, 32, 33, 34, 40, 41, 42, 43, 44);
			ma['紅'] = new Array(1, 2, 7, 8, 12, 13, 18, 19, 23, 24, 29, 30, 34, 35, 40, 45, 46);
			ma['藍'] = new Array(3, 4, 9, 10, 14, 15, 20, 25, 26, 31, 36, 37, 41, 42, 47, 48);
			ma['綠'] = new Array(5, 6, 11, 16, 17, 21, 22, 27, 28, 32, 33, 38, 39, 43, 44, 49);
			ma['1头'] = new Array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19);
			ma['2头'] = new Array(20, 21, 22, 23, 24, 25, 26, 27, 28, 29);
			ma['3头'] = new Array(30, 31, 32, 33, 34, 35, 36, 37, 38, 39);
			ma['4头'] = new Array(40, 41, 42, 43, 44, 45, 46, 47, 48, 49);
			ma['0头'] = new Array(01, 02, 03, 04, 05, 06, 07, 08, 09);
			ma['1尾'] = new Array(01, 11, 21, 31, 41);
			ma['2尾'] = new Array(02, 12, 22, 32, 42);
			ma['3尾'] = new Array(03, 13, 23, 33, 43);
			ma['4尾'] = new Array(04, 14, 24, 34, 44);
			ma['5尾'] = new Array(05, 15, 25, 35, 45);
			ma['6尾'] = new Array(06, 16, 26, 36, 46);
			ma['7尾'] = new Array(07, 17, 27, 37, 47);
			ma['8尾'] = new Array(08, 18, 28, 38, 48);
			ma['9尾'] = new Array(09, 19, 29, 39, 49);
			ma['0尾'] = new Array(10, 20, 30, 40);
			ma['全部'] = new Array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
				27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49);
			ma['小'] = new Array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24);
			ma['家畜'] = new Array("牛", "馬", "羊", "雞", "狗", "豬");
			ma['野獸'] = new Array("鼠", "虎", "兔", "龍", "蛇", "猴");
			ma['前'] = new Array("鼠", "虎", "兔", "龍", "蛇", "牛");
			ma['後'] = new Array("猴", "馬", "羊", "雞", "狗", "豬");
			ma['紅單'] = new Array(1, 7, 13, 19, 23, 29, 35, 45);
			ma['紅雙'] = new Array(2, 8, 12, 18, 24, 30, 34, 40, 46);
			ma['紅大'] = new Array(29, 30, 34, 35, 40, 45, 46);
			ma['紅小'] = new Array(1, 2, 7, 8, 12, 13, 18, 19, 23, 24);
			ma['藍單'] = new Array(3, 9, 15, 25, 31, 37, 41, 47);
			ma['藍雙'] = new Array(4, 10, 14, 20, 26, 36, 42, 48);
			ma['藍大'] = new Array(25, 26, 31, 36, 37, 41, 42, 47, 48);
			ma['藍小'] = new Array(3, 4, 9, 10, 14, 15, 20);
			ma['綠單'] = new Array(5, 11, 17, 21, 27, 33, 39, 43, 49);
			ma['綠雙'] = new Array(6, 16, 22, 28, 32, 38, 44);
			ma['綠大'] = new Array(27, 28, 32, 33, 38, 39, 43, 44, 49);
			ma['綠小'] = new Array(5, 6, 11, 16, 17, 21, 22);
			ma['内围'] = new Array(9, 10, 11, 12, 13, 16, 17, 18, 19, 20, 23, 24, 25, 26, 27, 30, 31, 32, 33, 34, 37, 38, 39, 40,
				41);
			ma['外围'] = new Array(1, 2, 3, 4, 5, 6, 7, 8, 14, 15, 21, 22, 28, 29, 35, 36, 42, 43, 44, 45, 46, 47, 48, 49);
			ma['合大'] = new Array(7, 8, 9, 16, 17, 18, 19, 25, 26, 27, 28, 29, 34, 35, 36, 37, 38, 39, 43, 44, 45, 46, 47, 48,
			49);
			ma['合小'] = new Array(1, 2, 3, 4, 5, 6, 10, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 30, 31, 32, 33, 40, 41, 42);
			ma['合尾大'] = new Array(5, 6, 7, 8, 9, 14, 15, 16, 17, 18, 23, 24, 25, 26, 27, 32, 33, 34, 35, 36, 41, 42, 43, 44, 45);
			ma['合尾小'] = new Array(1, 2, 3, 4, 10, 11, 12, 13, 19, 20, 21, 22, 28, 29, 30, 31, 37, 38, 39, 40, 46, 47, 48, 49);
			$(function() {
				myready();
			});
		</SCRIPT>
	</body>
</html>
