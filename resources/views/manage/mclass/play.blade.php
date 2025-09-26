<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>玩法列表</title>
		<link href="/xypone/css/all.css?v=12222" rel="stylesheet" type="text/css" />
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
		<script language="javascript" src="/xypone/default/js/default/jshide/playmyadmin.js?v=111211"></script>
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
			td {
				font-size: 11px;
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
					<th colspan="17">
						<div class="head_line">
                            <select class="game">
                                @foreach($lotterys as $vo)
                                    <option value="{{$vo['gid']}}" @if($vo['gid']==$gid) selected @endif>{{$vo['gname']}}</option>
                                @endforeach
                            </select>
							名称：<input class="pad3" type="text" id='name' />
							<select id="bid" class="left1">
								<option value="">大分类</option>
                                @foreach($b as $vo)
								<option value='{{$vo['bid']}}'>{{$vo['name']}}</option>
								@endforeach
							</select>
							<select id="sid" class="left1">
								<option value="">小分类</option>
							</select>
							<select id="cid" class="left1">
								<option value="">分类</option>
							</select>
							<div class="left1">赔率1：<input class="pad3" type="text" value="" id='peilv1' /></div>
							<select id='ztype' class="left1">
								<option value="">中奖类型</option>
                                @foreach($ztype as $vo)
								<option value="{{$vo}}">{{$vo}}</option>
								@endforeach
							</select>
							<div class="left1">中奖个数1：<input class="pad3" type="text" value="" id='znum1' /></div>
							<div class="left1">中奖个数2：<input class="pad3" type="text" value="" id='znum2' /></div>
							<input type="button" class="btn3 btnf pad3 left1" id='add' value="添加玩法" />
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
							<option value='{{$vo['bid']}}' @if($vo['bid']==$bid)selected @endif>{{$vo['name']}}</option>
							@endforeach
						</select></th>
					<th><select class="sid">
							<option value="">小分类</option>
                            @foreach($s as $vo)
							<option value='{{$vo['sid']}}' @if($vo['sid']==$sid) selected @endif>{{$vo['name']}}</option>
							@endforeach
						</select></th>
					<th><select class="cid">
							<option value="">分类</option>
                            @foreach($c as $vo)
							<option value='{{$vo['cid']}}' @if($vo['cid']==$cid) selected @endif>{{$vo['name']}}</option>
							@endforeach
						</select></th>
					<th>名称</th>
                    <th>标识</th>
					<th>可用</th>
					<th>赔率1</th>
					<th>中奖类型</th>
					<th>中奖个数1</th>
					<th>排序</th>
					<th>赔率类型</th>
					<th><input type="button" class="btn3 btnf" id='delall' value="删除选中" /><input type="button"
							class="btn3 btnf" id='edit' value="修改选中" /></th>
				</TR>
                @foreach($p as $vo)
				<TR>
					<td><input type="checkbox" value='{{$vo['pid']}}' /></td>
					<td>{{$vo['pid']}}</td>
					<td bid='{{$vo['bid']}}'><input type="text" value="{{$vo['bid']}}" class="bids" />{{$vo['bname']}}</td>
					<td sid='{{$vo['sid']}}'><input type="text" value="{{$vo['sid']}}" class="sids" />{{$vo['sname']}}</td>
					<td cid='{{$vo['cid']}}'><input type="text" value="{{$vo['cid']}}" class="cids" />{{$vo['cname']}}</td>
					<td><input type="text" value="{{$vo['name']}}" class="names" /></td>
                    <td><input type="text" value="{{$vo['cy']}}" class="cy" /></td>
					<td><input type="checkbox" class="ifok" value="1" @if($vo['ifok']==1) checked @endif /></td>
					<td><input type="text" value="{{$vo['peilv1']}}" class="peilv1" /></td>
					<td><select class="ztype">
                            @foreach($ztype as $j)
							<option value='{{$j}}' @if($j==$vo['ztype']) selected @endif>{{$j}}</option>
							@endforeach
						</select></td>
					<td><input type="text" value="{{$vo['znum1']}}" class="znum1" /></td>
					<TD><input type="text" class='xsort' value="{{$vo['xsort']}}" /></TD>
					<td><select class="ptype">
                            @foreach($ptype as $key=>$j)
							<option value='{{$key}}' @if($key==$vo['ptype']) selected @endif>{{$j['name']}}
							</option>
							@endforeach
						</select></td>
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
