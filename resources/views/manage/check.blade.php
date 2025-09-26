<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>检测管理</title>
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
		</script>
		<style>
			body {
				overflow-y: hidden;
			}
		</style>
		<script language="javascript" src="/xypone/default/js/default/jshide/checkmyadmin.js?v=22222"></script>
	</head>
	<body>
		<div class="xbody1" style="width:1155px;">
			<!-- <table class="tinfo wd100">
				<tr>
					<th colspan="2">自动开关盘</th>
					<th colspan="2">自动补货</th>
					<th colspan="2">自动开奖结算</th>
					<th rowspan="3"><input type="button" class="edit btnf" value="修改" /></th>
				</tr>
				<tr>
					<th>开关</th>
					<th>时间</th>
					<th>开关</th>
					<th>时间</th>
					<th>开关</th>
					<th>时间</th>
				</tr>
				<tr>
					<td><input type="checkbox" class="autoopenpan" {if $autoopenpan==1}checked{/if} /></td>
					<td><label>{$autoopenpantime}</label></td>
					<td><input type="checkbox" class="autofly" {if $autofly==1}checked{/if} /></td>
					<td><label>{$autoflytime}</label></td>
					<td><input type="checkbox" class="kjjs" {if $kjjs==1}checked{/if} /></td>
					<td><label>{$kjjstime}</label></td>

				</tr>
			</table> -->
			<BR />
			<table class="tinfo wd100">
				<tr>
					<th>注单表UPDATE</th>
					<th>注单表DELETE</th>
					<th>PLAY表UPDATE</th>
					<th>操盘员功能开放</th>
				</tr>
				<tr>
					<td>
                        @if($updatelib==1)
						<label>存在</label><input type="button" value="删除" class="tg" ac='del' name='ulib' />
						@else
						<label>不存在</label><input type="button" value="增加" class="tg" ac='add' name='ulib' />
						@endif
					</td>
					<td>
                        @if($deletelib==1)
						<label>存在</label><input type="button" value="删除" class="tg" ac='del' name='dlib' />
						@else
						<label>不存在</label><input type="button" value="增加" class="tg" ac='add' name='dlib' />
						@endif
					</td>
					<td>
                        @if($updateplay==1)
						<label>存在</label><input type="button" value="删除" class="tg" ac='del' name='uplay' />
						@else
						<label>不存在</label><input type="button" value="增加" class="tg" ac='add' name='uplay' />
						@endif
					</td>
					<td>
						<input type="button" value="更新功能" class="upgn" /><BR />
                        @foreach($xpage as $vo)
						<input type="checkbox" class="{{$vo['xpage']}}" @if($vo['ifhide']==0) checked @endif />{{$vo['pagename']}}<BR />
						@endforeach
					</td>
				</tr>
			</table>
			<BR />
			<table class="tinfo wd100">
				<tr>
					<th>err表</th>
					<th>注单MRG</th>
					<th>MRG表</th>
				</tr>
				<tr>
					<td>
						<LABEL>{{$liberrnum}}</LABEL>
						<input type="button" value="清空" class="qkerr" />
					</td>
					<td>
                        @if($bigdata==1)
						<label>存在</label><input type="button" value="恢复" class="mrg" ac='hf' />
						@else
						<label>不存在</label><input type="button" value="生成" class="mrg" ac='sc' />
						@endif
					</td>
					<td style="text-align:left;padding-left:10px;">
                        @if($bigdata==1)
                        <input type="button" value="重新整理" class="mrg" ac='resc' />
                        @endif
                        <input
							type="button" value="删除选中" class="mrg" ac='scxz' />
						<BR />
						<input type="checkbox" class="clickall" />全选<BR />
                        @foreach($mrg as $vo)
						<input class='mrgs' value="{{$vo['tb']}}" @if(($vo['in']==1 && $bigdata==1)) checked @endif type="checkbox" />&nbsp;{{$vo['tb']}}(<LABEL>{{$vo['num']}}</LABEL>)<BR />
						@endforeach
					</td>
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
