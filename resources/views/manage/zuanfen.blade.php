<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" @if($rkey==0)oncontextmenu="return false" @endif>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>赚分设置</title>
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
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top_info">
				<span class="title">赚分设置</span><span class="right"></span>
			</div>
			<div class="contents param_panel">

				<div class="control">
					<span><input type="button" value="提交修改" class="button edit" />&nbsp;&nbsp;&nbsp;&nbsp;
						输入代理账号:<INPUT type="text" class='agent' /><input type="button" value="查询"
							class="button search" />
					</span>
				</div>
				<div class="control">
					<span>
						赚分:<INPUT type="number" class='shuis' />
						变动类型:<select class='stypes'>
							<option value="0">只变金额</option>
							<option value="1">赔率一起变</option>
						</select>
						生效的期数尾数:<INPUT type="text" class='qishus' />
						最小值:<INPUT type="text" class='zuixs' />
						最大值:<INPUT type="text" class='zuids' />
						是否启用:<select class='isoks'>
							<option value="0">不启用</option>
							<option value="1">启用</option>
						</select>
						<input type="button" value="批量设置选中" class="button send" style="display: none;" /></span>
				</div>
				<div class="control">
					<span>赚分结果=金额*赔率*赚分。在“只变金额”的情况下，赚分结果如小于最小值，此注单就不赚，赚分结果如大于最大值，此赚分结果就为最大值。</span>
				</div>
				<table class="list data_table data_list nrtb" style="width: 100%;word-break:break-all;">
					<thead>
						<TR>
							<th><input type="checkbox" id='clickall' />全选</th>
							<th>上级</th>
							<th>会员</th>
							<th>赚分</th>
							<th>变动类型</th>
							<th>生效的期数尾数(逗号,隔开)</th>
							<th>最小值</th>
							<th>最大值</th>
							<th>是否启用</th>
						</TR>
					</thead>
					<tbody>
                        @foreach($us as $vo)
						<tr>
							<td><input type="checkbox" uid='{{$vo['userid']}}' class="xz" username='{{$vo['username']}}' /></td>
							<td><label>查看</label>
								<div style="display: none;color:Red">{{$vo['fids']}}</div>
							</td>
							<td>{{$vo['username']}}&nbsp;({{$vo['name']}})&nbsp;</td>
							<td><INPUT type="number" class='shui' value='{{$vo['shui']}}' />0-0.9999之间</td>
							<td><input type="radio" name='stype{{$vo['userid']}}' value="0" @if($vo['stype']==0)checked @endif>只变金额
								<input type="radio" name='stype{{$vo['userid']}}' value="1" @if($vo['stype']==1)checked @endif>赔率一起变
							</td>
							<td><INPUT type="text" class='qishu' value='{{$vo['qishu']}}' /></td>
							<td><INPUT type="text" class='zuix' value='{{$vo['zuix']}}' /></td>
							<td><INPUT type="text" class='zuid' value='{{$vo['zuid']}}' /></td>
							<td><input type="checkbox" class="isok" value="1" @if($vo['isok']==1) checked @endif></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<script language="javascript">
			$(function() {
				changeh(document.documentElement.scrollHeight + 500);
				$("input#clickall").click(function() {
					if ($(this).prop("checked")) {
						$("input.xz").prop("checked", true);
					} else {
						$("input.xz").prop("checked", false);
					}
				})

				$(".data_table td").mouseover(function() {
					$(this).parent().addClass("hover");
				}).mouseout(function() {
					$(this).parent().removeClass("hover");
				});

				$(".data_table label").click(function() {
					$(this).parent().find("div").toggle();
				});

				$("input.send").click(function() {
					var shui = $("input.shuis").val();
					var qishu = $("input.qishus").val();
					var stype = $("select.stypes").val();
					var zuix = $("input.zuixs").val();
					var zuid = $("input.zuids").val();
					var isok = $("select.isoks").val();
					var obj;
					$("input.xz:checked").each(function() {
						obj = $(this).parent().parent();
						obj.find("input.zuix").val(zuix);
						obj.find("input.zuid").val(zuid);
						obj.find("input.shui").val(shui);
						obj.find("input.qishu").val(qishu);
						if (isok == 1) {
							obj.find("input.isok").prop("checked", true);
						} else {
							obj.find("input.isok").prop("checked", false);
						}
						obj.find("input:radio").each(function() {
							if ($(this).val() == stype) {
								$(this).click();
							}
						});
					});
				});
				$("input.shuis").blur(function() {
					var val = $(this).val();
					$("input.xz:checked").each(function() {
						var obj = $(this).parent().parent();
						obj.find("input.shui").val(val);
					});
				});
				$("input.qishus").blur(function() {
					var val = $(this).val();
					$("input.xz:checked").each(function() {
						var obj = $(this).parent().parent();
						obj.find("input.qishu").val(val);
					});
				});
				$("input.zuixs").blur(function() {
					var val = $(this).val();
					$("input.xz:checked").each(function() {
						var obj = $(this).parent().parent();
						obj.find("input.zuix").val(val);
					});
				});

				$("input.zuids").blur(function() {
					var val = $(this).val();
					$("input.xz:checked").each(function() {
						var obj = $(this).parent().parent();
						obj.find("input.zuid").val(val);
					});
				});
				$("select.stypes").change(function() {
					var val = $(this).val();
					$("input.xz:checked").each(function() {
						var obj = $(this).parent().parent();
						obj.find("input:radio").each(function() {
							if ($(this).val() == val) {
								$(this).click();
							}
						});
					});
				})
				$("select.isoks").change(function() {
					var val = $(this).val();
					$("input.xz:checked").each(function() {
						var obj = $(this).parent().parent();
						if (val == 1) {
							obj.find("input.isok").prop("checked", true);
						} else {
							obj.find("input.isok").prop("checked", false);
						}
					});
				})

				$("input.search").click(function() {
					var agent = $(".agent").val();
					window.location.href = "/admin/zuanfenshow?agent=" + agent;
				});

				$("input.edit").click(function() {
					var data = [];
					$(".data_table tbody tr").each(function(i) {
						var tmp = {};
						tmp.userid = $(this).find("input:checkbox").attr("uid");
						tmp.username = $(this).find("input:checkbox").attr("username");
						tmp.shui = $(this).find("input.shui").val();
						tmp.isok = $(this).find("input.isok").prop("checked") ? 1 : 0;
						tmp.qishu = $(this).find("input.qishu").val();
						tmp.zuix = $(this).find("input.zuix").val();
						tmp.zuid = $(this).find("input.zuid").val();
						tmp.stype = $(this).find("input:radio:checked").val();
						data[i] = tmp;

					});
					$.post("/admin/setzuanfen", {
						data: JSON.stringify(data)
					}, function(m) {
                        if(m.status == 200){
                            window.location.href = window.location.href;
                        }
                        alert(m.msg);
					});
				});
			})
		</script>
		<div id='test'></div>
	</body>
</html>
