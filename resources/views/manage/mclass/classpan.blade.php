<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>玩法归类</title>
		<link href="/xypone/css/all.css?v=1111" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript">
			function hideinfo() {
				if (event.srcElement.tagName == "A") {
					window.status = event.srcElement.innerText
				}
			}
			document.onmouseover = hideinfo;
			document.onmousemove = hideinfo;
			function changeh(h) {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<style>
			body {
				overflow-y: hidden;
			}
		</style>
		<script language="javascript" src="/xypone/default/js/default/jshide/classpanmyadmin.js?v=11111"></script>
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
			input.bc {
				background: #fff
			}
			.s_tb tr:hover {
				background: #FCF
			}
			.head_line{
				display: flex;
				align-items: center;
				justify-content: center;
				padding: 3px 0px;
			}
			.left1{
				margin-left: 5px;
			}
			.right1{
				margin-right: 5px;
			}
			select{
				padding: 3px;
			}
			.pad3{
				padding: 3px;
			}
		</style>
	</head>
	<body>
		<div class="xbody1" style="width: 100%;">
			<table class="tinfo wd100 s_tb">
				<tr>
					<th colspan="3" style="padding: 3px 0px;">
						<select class="game">
                            @foreach($game as $vo)
								<option value="{{$vo['gid']}}" @if($vo['gid']==$gid) selected @endif>{{$vo['gname']}}</option>
							@endforeach
						</select>
                        <button class="tongbuzpan">同步zpan</button>
					</th>
					<th style="padding: 3px 0px;" colspan="2"><input type="button" class="edit btn1 btnf pad3" value='修改' /></th>
				</tr>
				<TR>
					<th>ID</th>
					<th>名称</th>
					<th class="abcd">ABCD</th>
					<th class="ab">AB</th>
					<th class="ifok">ifok</th>
				</TR>
                @foreach($pan as $vo)
				<TR>
					<td><INPUT type='text' class="class" value="{{$vo['class']}}" style="display:none" />{{$vo['class']}}
					</td>
					<td class="name">{{$vo['name']}}</td>
					<TD><INPUT type='checkbox' class="abcd" value="{{$vo['abcd']}}" @if($vo['abcd']==1) checked @endif />
					</TD>
					<TD><INPUT type='checkbox' class="ab" value="{{$vo['ab']}}" @if($vo['ab']==1) checked @endif /></TD>
					<TD><INPUT type='checkbox' class="ifok" value="{{$vo['ifok']}}" @if($vo['ifok']==1) checked @endif />
					</TD>
				</TR>
                @endforeach
			</table>
		</div>
		<div id='test'></div>
	</body>
	<script language="javascript">
		$(function() {
			myready();
		});
	</script>
</html>
