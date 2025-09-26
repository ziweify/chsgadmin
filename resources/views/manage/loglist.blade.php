<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>注单日志</title>
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
		<script language="javascript" src="/xypone/default/js/default/jshide/flylistmyadmin.js?v=11111"></script>
		<script language="javascript" type="text/javascript" src="/xypone/default/js/My97DatePicker/WdatePicker.js">
		</script>
		<style>
			a.red {
				color: #D50000
			}
			.nrtb tr:hover {
				background: #FCF
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">飞单记录</span><span class="right"></span>
			</div>
			<div class="contents param_panel">

				<div class="control">
					<span>{!! $page !!}</span><span><input type="button" value="删除" class="button del" /><INPUT
							type="text" value="{{$deldate}}" class="deldate" style="width: 80px;" size=8 />之前</span>
				</div>
				<table class="data_table data_list nrtb" style="width: 100%;word-break:break-all;">
					<thead>
						<TR>
							<th><input type="checkbox" id='clickall' />全选</th>
							<th>编号</th>
							<th>游戏</th>
							<th>会员</th>
							<th>IP</th>
							<th>时间</th>
							<th class="data">数据</th>
							<th><input type="button" class="btn3 btnf" id='delselect' value="删除选中" /></th>
						</TR>
					</thead>
                    @foreach($l as $vo)
					<TR>
						<td><input type="checkbox" value='{{$vo['id']}}' /></td>
						<td>{{$vo['id']}}</td>
						<td>{{$vo['gname']}}--{{$vo['type']}}</td>
						<td>{{$vo['user']}}</td>
						<td>{{$vo['ip']}}</td>
						<td>{{$vo['time']}}</td>
						<td style="width: 600px !important;">{{$vo['content']}}</td>
						<td><input type="button" class="delone btn1 btnf" value='删除' /></td>
					</TR>
					@endforeach
				</table>
			</div>
		</div>
		<script language="javascript">
			var page = 'show';
		</script>
		<div id='test'></div>
		<script type="text/javascript">
			$(function() {
				changeh(document.documentElement.scrollHeight + 500);
				$(".data_table tr").mouseover(function() {
					$(this).addClass('hover')
				}).mouseout(function() {
					$(this).removeClass('hover')
				});
				$(".deldate").click(function() {
					//WdatePicker();
				});


				$("select").unbind("change");
				$("select").change(function() {
					window.location.href = "loglist.php?xtype=loglist&PB_page=" + $(this).val();
				});

				$("#clickall").click(function() {
					if ($(this).prop('checked') == true) {
						$(this).parent().parent().parent().parent().find("input:checkbox").attr("checked", true)
					} else {
						$(this).parent().parent().parent().parent().find("input:checkbox").attr("checked", false)
					}
				});
				$("#delselect").click(function() {
					dellogin(1)
				});
				$(".delone").click(function() {
					$("input:checkbox").attr("checked", false);
					$(this).parent().parent().find("input:checkbox").attr("checked", true);
					dellogin(0)
				});
				$(".del").click(function() {
					dellogin('date')
				})
			});

			function winopen() {
				return false;
			}

			function getid() {
				var i = 0;
				var idarr = '[';
				$(".nrtb").find("input:checkbox").each(function() {
					if ($(this).prop('checked') == true && !isNaN($(this).val())) {
						if (i > 0) idarr += ','
						idarr += '"' + $(this).val() + '"';
						i++
					}
				});
				idarr += ']';
				return idarr
			}

			function dellogin(val) {
				if (val == 'date') {
					var idarr = $(".deldate").val() + "&type=date"
				} else {
					var idarr = getid()
				}

				$.ajax({
					type: 'POST',
					url: '/admin/loglistdlist',
					data: 'id=' + idarr,
					success: function(m) {
						if (Number(m) == 1) {
							window.location.href = "/admin/loglistloglist?page=" + 1
						}
					}
				})
			}
		</script>
	</body>
</html>
