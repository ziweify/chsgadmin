<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>消息</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=33" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
		<script language="javascript" src="/xypone/default/js//jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight + 500;
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jshide/newsmyadmin.js?v=11111"></script>
		<style type="text/css">
			.conwidth {
				width: 400px;
				padding-left: 10px;
				text-align: left;
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">消息发布</span><span class="right"></span>
			</div>
			<form method="POST" style="margin:0">
				<input type="hidden" value="addnews" name="xtype">
				<table class="data_table data_list list news_tb">
					<tr>
						<td colspan="2">发布公司:
							<select name=wid>
								<OPTION value="0">所有公司</OPTION>
                                @foreach($web as $vo)
								<OPTION value="{{$vo['wid']}}">{{$vo['webname']}}</OPTION>
								@endforeach
							</select>
						</td>
						<td colspan="6">参数:{期数}、{公司名称}、{开盘时间}、{关盘时间}、{开奖时间}</td>
						<td colspan="1">
							<div style="width: 100%"><textarea style="width: 94%;margin: 5px 0;resize:none;" cols="20" rows="5" id="category" name="category"></textarea></div>
						</td>
						<td colspan="1"><div style="width: 100%"><textarea style="width: 94%;margin: 5px 0;resize:none; " cols="20" rows="5" id="title" name="title"></textarea></div></td>
						<td colspan="1"><div style="width: 100%"><textarea style="width: 94%;margin: 5px 0;resize:none; " cols="50" rows="5" id="content" name="content"></textarea></div></td>
						<td colspan="2">
							<input type="submit" value="发布" class="button">
						</td>

					</tr>
					<thead>
						<tr>
							<th><input type="checkbox" id="clickall">全选</th>
							<th>序号</th>
							<th>公司</th>
							<th>包含参数</th>
							<th>显示</th>
							<th>发布对象</th>
							<th>滚动</th>
							<th>弹出</th>
							<th>分类名称</th>
							<th>小小标题</th>
							<th class="conwidth">内容</th>
							<th>时间</th>
							<th><input type="button" class="btn3 btnf dels" id="delall" value="删除选中"></th>
						</tr>
					</thead>
                    @foreach($news as $vo)
					<tr>
						<td><input class='chk' type="checkbox" value='{{$vo['id']}}' /></td>
						<td>{{$vo['id']}}</td>
						<td><select class=wid>
								<OPTION @if($vo['wid']==0) selected @endif value="0">所有公司</OPTION>
                                @foreach($web as $vb)
								<OPTION @if($vb['wid']==$vo['wid']) selected @endif value="{{$vb['wid']}}">
									{{$vb['webname']}}</OPTION>
                                @endforeach
							</select></td>
						<td><input type="checkbox" class="cs" value='1' @if($vo['cs']==1) checked @endif /></td>
						<td><input type="checkbox" class="ifok" value='1' @if($vo['ifok']==1) checked @endif /></td>
						<td><SELECT class="agent">
								<OPTION value="2" @if($vo['agent']==2) selected @endif>全部</OPTION>
								<OPTION value="1" @if($vo['agent']==1) selected @endif>代理</OPTION>
								<OPTION value="0" @if($vo['agent']==0) selected @endif>会员</OPTION>
							</SELECT>
						</td>
						<td><input type="checkbox" class="gundong" value='1' @if($vo['gundong']==1) checked @endif /></td>
						<td><input type="checkbox" class="alert" value='1' @if($vo['alert']==1) checked @endif /></td>
						<td><div style="width: 100%"><textarea style="width: 94%;margin: 5px 0;resize:none;" cols="20" class="category" rows="5">{{$vo['category']}}</textarea></div></td>
						<td><div style="width: 100%"><textarea style="width: 94%;margin: 5px 0;resize:none;" cols="20" class="title" rows="5">{{$vo['title']}}</textarea></div></td>
						<td><div style="width: 100%"><textarea style="width: 94%;margin: 5px 0;resize:none;" cols="50" class="con" rows="5">{{$vo['content']}}</textarea></div></td>
						<td><input type="text" class="time" value='{{$vo['time']}}' /></td>
						<td><input type="button" class="edit btn1 btnf" value="修改">&nbsp;
							&nbsp;<input type="button" class="dels btn1 btnf" value="删除">
						</td>
					</tr>
					@endforeach
				</table>
			</form>
		</div>
		<div id="test">
			<script type="text/javascript">
				$(function() {
					myready();
				});
			</script>
	</body>
</html>
