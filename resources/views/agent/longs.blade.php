<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Welcome</title>
		<link href="/xypone/css/default/jquery-ui.css" rel="stylesheet" type="text/css">
		<link href="/xypone/css/default/master.css" rel="stylesheet" type="text/css">
		<link href="/xypone/css/default/layout.css" rel="stylesheet" type="text/css">
		<link href="/xypone/css/default/form_validate.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js?v=3333"></script>
		<script language="javascript" src="/xypone/default/js/public.js"></script>
		<script language="javascript" src="/xypone/default/js/md5.js"></script>
		<script language="javascript">
			function hideinfo() {
				if (event.srcElement.tagName == "A") {
					window.status = event.srcElement.innerText
				}
			}
			document.onmouseover = hideinfo;
			document.onmousemove = hideinfo;
			function changeh() {
				var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight + 500;
				obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
			}
		</script>
		<script type="text/javascript" src="/xypone/default/js/jquery-ui.js"></script>
		<script type="text/javascript" src="/xypone/default/js/jquery.ui.datepicker-zh-CN.js"></script>
		<link href="/xypone/css/default/result.css" rel="stylesheet" type="text/css">
        @if($gid==101)
		<link href="/xypone/css/default/hlsx.css" rel="stylesheet" type="text/css">
        @elseif($nc==1)
		<link href="/xypone/css/default/135.css" rel="stylesheet" type="text/css">
		@else
		<link href="/xypone/css/default/{{$fenlei}}.css?v=11" rel="stylesheet" type="text/css">
		@endif
		<script language="javascript" src="/xypone/default/js/default/jsagent/longsagent.js?v=11111"></script>
        <style type="text/css">
            .list td.he {
                color: #22BD1E !important;
            }

            .list td.g1 {
                color: red !important
            }

            .list td.g2 {
                color: black;
            }

            .list td.g3 {
                color: blue !important
            }
        </style>
	</head>
	<body class="L_PK10JSC">
		<div class="main">
			<div class="top_info">
				<span class="title">历史开奖结果</span>
				<span class="right">
					彩种：<select id="game" name="game">
                        @foreach($game as $vo)
						<option value="{{$vo['gid']}}" @if($vo['gid']==$gid)selected @endif>{{$vo['gname']}}</option>
						@endforeach
					</select>
                    @if($fast != 0)
					日期：<input id="date" value="{{$thisday}}" />
					@endif
				</span>
			</div>
			<div id="drawInfo" class="contents">
				<table class="list data_table table_ball">
					<thead>
						<tr>
							<th>期数</th>
							<th>开奖时间</th>
							<th colspan="{{$mnums}}">开出号码</th>
                            @if($fenlei==107)
							<th colspan="3" class="strong">冠亚军和</th>
							<th colspan="5" class="strong">1～5 龙虎</th>
							<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
							<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==101)
						<th colspan="3" class="strong">总和</th>
						<th>龙虎</th>
						<th>前三</th>
						<th>中三</th>
						<th>后三</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==163)
						<th colspan="3" class="strong">总和</th>
						<th>前三</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==103)
						<th colspan="4" class="strong">总和</th>
						<th colspan="4">1～4 龙虎</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==121)
						<th colspan="4" class="strong">总和</th>
						<th>龙虎</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==444)
						<th colspan="4" class="strong">总和</th>
						<th>龙虎</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==555)
						<th colspan="4" class="strong">总和</th>
						<th>龙虎</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==161)
						<th colspan="4" class="strong">总和</th>
						<th colspan="2" class="strong">比数量</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
                        @elseif($fenlei==151)
						<th colspan="2" class="strong">总和</th>
                        @elseif($fenlei==100)
						<th colspan="3" class="strong">总和</th>
						<th colspan="6" class="strong">特码</th>
						<th @if($ft!=1)style='display:none;' @endif>结果={{$ftnum}}</th>
						<th @if($ft!=1)style='display:none;' @endif>番</th>
						</tr>
						@endif
					</thead>
					<tbody>
                        @foreach($list as $vo)
						<tr>
							<td class="period">{{$vo['qishu']}}</td>
							<td class="drawTime">{{$vo['time']}}</td>
                            @foreach($vo['ma'] as $k)
							<td class="name ballname">
                                @if($k!='')
                                    <span class="b{{substr($k,0,2)}}">{{substr($k,0,2)}}</span>
                                    @if($fenlei==100)<label class="sxs">{{substr($k,3)}}</label>@endif
                                @endif
                            </td>
							@endforeach
                            @foreach($vo['m'] as $n)
							<td class="other @if($n=='和' | $n=='前后(和)' | $n=='单双(和)') he @elseif(($n=="大" | $n=="合单" | $n=="尾大" | $n=="家" | $n=="前(多)" | $n=="双(多)" | $n=="龙" | $n=="双" )) g1 @elseif(($n=="小" | $n=="合双"
								| $n=="尾小" | $n=="野" | $n=="双(多)" | $n=="单(多)" | $n=="虎" | $n=="单" )) g2 @elseif(( $n=="单双(和)" | $n=="前后(和)" )) g3 @endif">{{$n}}</td>
							@endforeach
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</body>
	<script language="javascript">
		myready();
	</script>
</html>
