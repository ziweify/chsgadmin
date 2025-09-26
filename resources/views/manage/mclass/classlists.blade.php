<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>小分类</title>
		<link href="/xypone/css/all.css?v=12" rel="stylesheet" type="text/css" />
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
            var gid = "{{$gid}}";
		</script>
		<style>
			body {
				overflow-y: hidden;
			}
		</style>
		<script language="javascript" src="/xypone/default/js/default/jshide/sclassmyadmin.js?v=11111"></script>
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
		<div class="xbody1" style="width:100%;">
			<table class="tinfo wd100 s_tb">
				<tr>
					<th colspan="7">
						<div class="head_line">
                            <select class="game">
                                @foreach($lotterys as $vo)
                                    <option value="{{$vo['gid']}}" @if($vo['gid']==$gid) selected @endif>{{$vo['gname']}}</option>
                                @endforeach
                            </select>
							大分类：<select id='bid'>
                                @foreach($b as $vo)
								<option value="{{$vo['bid']}}">{{$vo['name']}}</option>
								@endforeach
							</select>
							<input class="pad3 left1" type="text" id='name' />
							<input type="button" class="btn3 btnf left1 pad3" id='add' value="添加小分类" />
						</div>
					</th>
				</tr>
				<TR>
					<th><input type="checkbox" id='clickall' />
						全选</th>
					<th> <select class='bid'>
							<option value="">选择大分类</option>
                            @foreach($b as $vo)
							<option value="{{$vo['bid']}}">{{$vo['name']}}</option>
							@endforeach
						</select></th>
					<th>编号</th>
					<th>名称</th>
					<th>可用</th>
					<th>排序</th>
					<th><input type="button" class="btn3 btnf" id='delall' value="删除选中" /></th>
				</TR>
                @foreach($s as $vo)
				<TR>
					<td><input type="checkbox" value='{{$vo['sid']}}' /></td>
					<td><input type="text" value='{{$vo['bid']}}' class=bids />{{$vo['bname']}}</td>
					<td>{{$vo['sid']}}</td>
					<td><input type="text" value='{{$vo['name']}}' class=name /></td>
					<td><input type="checkbox" class=ifok @if($vo['ifok']==1)checked @endif /></td>
					<td><input type="text" value='{{$vo['xsort']}}' class=xsort /></td>
					<td><input type="button" class="edit btn1 btnf" value='修改' />
						<input type="button" class="delone btn1 btnf" value='删除' />
					</td>
				</TR>
				@endforeach
			</table>
		</div>
		<script language="javascript">
			$(".bid").val('{{$bid}}');
			myready();
		</script>
		<div id='test'></div>
	</body>
</html>
