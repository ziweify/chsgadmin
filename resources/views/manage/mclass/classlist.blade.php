<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>玩法分类</title>
		<link href="/xypone/css/all.css?v=1222" rel="stylesheet" type="text/css" />
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
		<script language="javascript" src="/xypone/default/js/default/jshide/classmyadmin.js?v=11111"></script>
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
		<div class="xbody1" style="width:100%">
			<table class="tinfo wd100 s_tb">
				<tr>
					<th colspan="13">
						<div class="head_line">
                            <select class="game">
                                @foreach($lotterys as $vo)
                                    <option value="{{$vo['gid']}}" @if($vo['gid']==$gid) selected @endif>{{$vo['gname']}}</option>
                                @endforeach
                            </select>
							<div>名称：<input class="pad3" type="text" id='name' /></div>
							<select id="bid" class="left1">
								<option value="">大分类</option>
                                @foreach($b as $vo)
								<option value='{{$vo['bid']}}'>{{$vo['name']}}</option>
								@endforeach
							</select>
							<select id="sid" class="left1">
								<option value="">小分类</option>
							</select>
							<input type="button" class="btn3 btnf left1 pad3" id='add' value="添加分类" />
						</div>
					</th>
				</tr>
				<TR>
					<th><input type="checkbox" id='clickall' />
						全选</th>
					<th>编号</th>
					<th><select class="bid">
							<option value="">大分类</option>
                            @foreach($b as $vo)
							<option value='{{$vo['bid']}}' @if($vo['bid']==$bid) selected @endif>{{$vo['name']}}</option>
							@endforeach
						</select>
					</th>
					<th><select class="sid">
							<option value="">小分类</option>
                            @foreach($s as $vo)
							<option value='{{$vo['sid']}}' @if($vo['sid']==$sid) selected @endif>{{$vo['name']}}</option>
							@endforeach
						</select>
					</th>
					<th>名称</th>
                    <th>标识</th>
					<th>可用</th>
					<th>码类型</th>
					<th>面类型</th>
					<th>大面类型</th>
					<th>排序</th>

					<th>分类</th>
					<th>唯一</th>
					<th><input type="button" class="btn3 btnf" id='delall' value="删除选中" /><input type="button"
							class="edit btn1 btnf" id='edit' value='修改选中' /></th>
				</TR>
                @foreach($c as $vo)
				<TR>
					<td><input type="checkbox" value='{{$vo['cid']}}' /></td>
					<td>{{$vo['cid']}}</td>
					<td><input type="text" value="{{$vo['bid']}}" cid='{{$vo['cid']}}' class="bid" />
						[{{$vo['bname']}}] </td>
					<td><input type="text" value="{{$vo['sid']}}" cid='{{$vo['cid']}}' class="sid" />
						[{{$vo['sname']}}] </td>
					<td><input type="text" value="{{$vo['name']}}" cid='{{$vo['cid']}}' class="name" /></td>
                    <td><input type="text" value="{{$vo['cs']}}" class="cs" /></td>
					<td><input type="checkbox" class="ifok" @if($vo['ifok']==1) checked @endif /></td>
					<td><select class="mtype">
                            @foreach($mtype as $k=>$j)
							<option value='{{$j}}' @if($j==$vo['mtype']) selected @endif}>{{$j}}</option>
							@endforeach
						</select></td>
					<td><select class="ftype">
                            @foreach($ftype as $k=>$j)
							<option value='{{$k}}' @if($k==$vo['ftype'])selected @endif>{{$j['name']}}</option>
							@endforeach
						</select></td>
					<td><select class="dftype">
                            @foreach($dftype as $k=>$j)
							<option value='{{$k}}' @if($k==$vo['dftype'])selected @endif>{{$j}}</option>
							@endforeach
						</select></td>
					<TD><input type="text" class='xsort' value="{{$vo['xsort']}}" /></TD>

					<td><input type="checkbox" class="xshow" @if($vo['xshow']==1)checked @endif /></td>
					<td><input type="checkbox" class="one" @if($vo['one']==1)checked @endif /></td>
					<td><input type="button" class="delone btn1 btnf" value='删除' />
					</td>
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
