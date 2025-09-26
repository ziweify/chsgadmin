<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {if $rkey==0}oncontextmenu="return false" {/if}>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>报表查询</title>
		<link href="/xypone/default/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/master.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/layout.css?v=2" rel="stylesheet" type="text/css" />
		<link href="/xypone/default/css/info.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js?v=3333"></script>
		<script language="javascript" src="/xypone/default/js/ui/jquery-ui.js"></script>
		<script language="javascript">
			function changeh() {
				/*var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
				var h = document.body.clientHeight +500;
				obj.style.height = h+ "px"; //调整父页面中IFrame的高度为此页面的高度*/
			}
		</script>
		<script language="javascript" src="/xypone/default/js/default/jsagent/baonewagent.js?v=1111"></script>
		<link href="/xypone/css/default/bets.css" rel="stylesheet" type="text/css" />
		<link href="/xypone/css/default/report.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/xypone/default/js/jquery.ui.datepicker-zh-CN.js"></script>
        <style type="text/css">
            .data_table tbody tr{
                height: 26px;
            }
        </style>
	</head>
	<body>
		<div class="main">
            <div class="top_info">
                <span class="title">{{$lname}}({{$username}}）报表查询</span>
                <a class="select" href="main?action=list">交收分类报表</a> |
                <a href="main?action=logs">后台更新日志</a> |
            </div>
            <div class="game_tab_class">
                <a id="lotterys" href="#" class="selected">彩票类</a>
            </div>
			<form action="list">
				<div class="contents">
					<table class="data_table info_table panel">
						<thead>
							<tr>
								<th colspan="2">查询设定</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="ft_sd te-rt">日期范围</td>
								<td>
									<span id="date"><input id="begin" value="{{$sdate[10]}}" /> — <input id="end"
											value="{{$sdate[10]}}" /></span>
									<input type="button" class="s btn today" value="今天" d=1 />
									<input type="button" class="s btn" value="昨天" d=2 />
									<input type="button" class="s btn" value="本星期" d=3 />
									<input type="button" class="s btn" value="上星期" d=4 />
									<input type="button" class="s btn" value="本月" d=5 />
									<input type="button" class="s btn" value="上月" d=6 />
								</td>
							</tr>
							<tr>
								<td width="20%" class="ft_sd te-rt">种类</td>
								<td class="gametype">
									<a href='javascript:void(0)' class="ft_a ico_tick" type='2' v='1'>全部选择</a><a
										href='javascript:void(0)' class="ft_a" type='2' v='0'>全部不选择</a><br />
									<ul class="table_box">
                                        @if($config['fasttype']==1)
										<li class="table_box_title">
											<span>快开彩彩种</span><a href='javascript:void(0)' class="ico_tick2" type='1'
												v='1'>全选</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' type='1'
												v='0'>全不选</a>
										</li>
										<li class="table_box_info fast">
                                            @foreach($gamecs as $vo)
                                            @if($vo['fast'] != 0)
											<label><input lottery="{{$vo['lottery']}}" type="checkbox" name="lottery" value="{{$vo['gid']}}"
													checked="checked"
													gname='{{$vo['gname']}}' />{{$vo['gname']}}</label>
											@endif
											@endforeach
										</li>
										@endif
                                        @if($config['slowtype']==1)
										<li class="table_box_title">
											<span>低频彩种</span><a onClick="selectAll(true,this)" class="ico_tick2"
												type='0' v='1'>全选</a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)'
												type='0' v='0'>全不选</a>
										</li>
										<li class="table_box_info slow">
                                            @foreach($gamecs as $vo)
                                            @if($vo['fast']==0)
											<label><input type="checkbox" name="lottery" value="{{$vo['gid']}}"
													checked="checked"
													gname='{{$vo['gname']}}' />{{$vo['gname']}}</label>
											@endif
											@endforeach
										</li>
										@endif
									</ul>
								</td>
							</tr>

							<tr>
								<td class="ft_sd te-rt">期数</td>
								<td>
									<select name="qishu" class="qishu" style="width:200px;">
										<option value="">--------请选择单一彩种--------</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="ft_sd te-rt bbzl">五级代理报表种类</td>
								<td>
									<label><input type="radio" name="types" value="true"
											checked="checked" />交收报表</label>
									<label><input type="radio" name="types" value="false" />分类报表</label>
								</td>
							</tr>
							<tr>
								<td class="ft_sd te-rt">结算状态</td>
								<td>
									<label><input type="radio" name="settle" value="1" checked="checked" />已 结
										算</label>&nbsp;
									<label class="unsettled"><input type="radio" name="settle" value="2" />未 结
										算</label>
									{{--<label class="unsettled"><input type="radio" name="settle" value="3" />作 废 单</label>--}}
								</td>
							</tr>
							<tr>
								<th>用户名</th>
								<td><input id="filter" /></td>
							</tr>
							<tr>
								<th>会员金额</th>
								<td><input id="amount" /></td>
							</tr>
							<tr>
								<th>盈亏金额</th>
								<td><input id="dividend" /></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="data_footer" style="height: 30px;line-height: 30px;"><span
						style="width: 100%;color: red;text-align:center;clear: both;font-weight:normal;">备注：6AM-7AM是系统维护时间，会影响报表导出功能，敬请谅解</span>
				</div>
				<div class="data_footer control">
					<input type="button" value="确定" class="query button" />
					<input type='hidden' class="nowuser" value="{{$topid}}" uid='{{$topid}}' layer="{{$layer}}"
						username='{{$username}}' />
					<input type="hidden" id='topid' value="{{$topid}}" layer="{{$layer}}" username='{{$username}}' />
					<input type="hidden" id='saveuserid' value="{{$topid}}" layer="{{$layer}}" />
					<input type="button" value="取消" class="cancel button" />
				</div>
			</form>
		</div>

		<div class="main1 gdiv" style="display:none">
			<div class="top_info">
				<span class="title"></span><span class="right"><a class="back" uid="0"
						href="javascript:void(0);">返回</a></span>
			</div>
			<div class="contents">
				<table class="data_table list report">
					<caption>合计</caption>
					<thead>
						<tr class="shead">
							<th rowspan="2">彩种</th>
							<th rowspan="2" data-sort="string" class="sortable sorting-desc">玩法<i></i></th>
							<th rowspan="2" class="count sortable" data-sort="number">笔数<i></i></th>
							<th rowspan="2" data-sort="number" class="sortable">下注金额<i></i></th>
							<th rowspan="2">有效金额</th>
							<th colspan="3" class="mbname">会员输赢</th>
							<th colspan="7" class="syname">输赢</th>
							<th rowspan="2">上交货量</th>
							<th rowspan="2" data-sort="number" class="sortable ca">上级交收<i></i></th>
						</tr>
						<tr class="shead">
							<th>输赢</th>
							<th>退水</th>
							<th>盈亏结果</th>
                            <th class="tax" style="color:red;font-weight: bold">赚点</th>
							<th data-sort="number" class="sortable self ca">应收下线<i></i></th>
							<th>占成</th>
							<th>实占金额</th>
							<th>实占结果</th>
							<th>实占退水</th>
							<th>赚水</th>
                            <th class="tax" style="color:red;font-weight: bold">赚点</th>
							<th class="plc">赚赔</th>
							<th class="ca">盈亏结果</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="2"></th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="result color"></td>
                            <td class="tax"></td>
							<td class="nosum"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
                            <td class='tax'></td>
							<td class='plc'></td>
							<td class="result color minus"></td>
							<td></td>
							<td class="result color"></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="data_footer">
			</div>
		</div>
		<div class="main2 gdiv" style="display:none">
			<div class="top_info">
				<span class="title"></span><span class="right"><a class="back" uid="0"
						href="javascript:void(0);">返回</a></span>
			</div>
			<div class="contents">
				<table class="data_table list report">
					<caption>合计</caption>
					<thead>
						<tr class="shead">
							<th rowspan="2">级别</th>
							<th rowspan="2" data-sort="string" class="sortable sortdefault sorting-asc">账号<i></i></th>
							<th rowspan="2">名称</th>
							<th rowspan="2">余额</th>
							<th rowspan="2" class="count sortable" data-sort="number">笔数<i></i></th>
							<th rowspan="2" data-sort="number" class="sortable">下注金额<i></i></th>
							<th rowspan="2">有效金额</th>
							<th colspan="3" class="mbname">会员输赢</th>
							<th colspan="8" class="syname">输赢</th>
							<th rowspan="2">上交货量</th>
							<th rowspan="2" data-sort="number" class="sortable ca">上级交收<i></i></th>
						</tr>
						<tr class="shead">
							<th>输赢</th>
							<th>退水</th>
							<th>盈亏结果</th>
                            <th class="tax" style="color:red;font-weight: bold">赚点</th>
							<th data-sort="number" class="sortable self ca">应收下线<i></i></th>
							<th>占成</th>
							<th>实占金额</th>
							<th>实占结果</th>
							<th>实占退水</th>
							<th>赚水</th>
                            <th class="tax" style="color:red;font-weight: bold">赚点</th>
							<th class="plc">赚赔</th>
							<th class="ca">盈亏结果</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4"></th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="ff"></td>
                            <td class="tax"></td>
							<td class="result color ff"></td>
							<td class="nosum"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
                            <td class='tax'></td>
							<td class="plc"></td>
							<td class="result color ff"></td>
							<td></td>
							<td class="result color ff"></td>
						</tr>
					</tfoot>
				</table>
				<p class="more_detail">
					<a onClick="" class="showgame">+显示各彩种明细</a>
				</p>
			</div>
			<div class="data_footer" style="height: 8px;line-height: 8px;">
			</div>
		</div>
		<div class="maingame gdiv" style="display:none">
			<div class="contents">
				<table class="data_table list report">
					<caption>合计</caption>
					<thead>
						<tr class="shead">
							<th rowspan="2">级别</th>
							<th rowspan="2" data-sort="string" class="sortable sortdefault sorting-asc">账号<i></i></th>
							<th rowspan="2">名称</th>
							<th rowspan="2">余额</th>
							<th rowspan="2" class="count sortable" data-sort="number">笔数<i></i></th>
							<th rowspan="2" data-sort="number" class="sortable">下注金额<i></i></th>
							<th rowspan="2">有效金额</th>
							<th colspan="3" class="mbname">会员输赢</th>
							<th colspan="8" class="syname">输赢</th>
							<th rowspan="2">上交货量</th>
							<th rowspan="2" data-sort="number" class="sortable ca">上级交收<i></i></th>
						</tr>
						<tr class="shead">
							<th>输赢</th>
							<th>退水</th>
							<th>盈亏结果</th>
                            <th class="tax" style="color:red;font-weight: bold">赚点</th>
							<th data-sort="number" class="sortable self ca">应收下线<i></i></th>
							<th>占成</th>
							<th>实占金额</th>
							<th>实占结果</th>
							<th>实占退水</th>
							<th>赚水</th>
                            <th class="tax" style="color:red;font-weight: bold">赚点</th>
							<th class="plc">赚赔</th>
							<th class="ca">盈亏结果</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4"></th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="ff"></td>
                            <td class="tax"></td>
							<td class="result color ff"></td>
							<td class="nosum"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
                            <td class='tax'></td>
							<td class="plc"></td>
							<td class="result color ff"></td>
							<td></td>
							<td class="result color ff"></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="data_footer" style="height: 10px;line-height: 10px;">
			</div>
		</div>
		<div class="main3 gdiv" style="display:none">
			<div class="top_info">
				<span class="title"></span><span class="right"><a class="back" uid="0"
						href="javascript:void(0);">返回</a></span>
			</div>
			<div class="contents">
				<table class="data_table list report" data-colspan="6">
					<caption>合计</caption>
					<thead>
						<tr class="shead">
							<th rowspan="2" data-sort="string" data-sort-dir="asc" class="sortable sortdefault sorting-desc">日期<i></i></th>
							<th rowspan="2">级别</th>
							<th rowspan="2" data-sort="string" class="sortable">账号<i></i></th>
							<th rowspan="2">名称</th>
							<th rowspan="2" class="count sortable" data-sort="number">笔数<i></i></th>
							<th rowspan="2" data-sort="number" class="sortable">下注金额<i></i></th>
							<th rowspan="2">有效金额</th>
							<th colspan="3">会员输赢</th>
						</tr>
						<tr class="shead">
							<th>输赢</th>
							<th>退水</th>
							<th>盈亏结果</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4"></th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
				<p class="more_detail">
					<a href="javascript:void(0);" class="showgame"> 显示各彩种明细</a>
				</p>
			</div>
			<div class="data_footer">
			</div>
		</div>
		<div class="searchgame gdiv" style="display:none">
			<div class="top_info">
				<span class="title"></span><span class="right"></span>
			</div>
			<div class="contents">
				<table class="data_table list report" data-colspan="6">
					<caption>合计</caption>
					<thead>
						<tr class="shead">
							<th rowspan="2" data-sort="string" data-sort-dir="asc" class="sortable sortdefault sorting-desc">日期<i></i></th>
							<th rowspan="2">级别</th>
							<th rowspan="2" data-sort="string" class="sortable">账号<i></i></th>
							<th rowspan="2">名称</th>
							<th rowspan="2" class="count sortable" data-sort="number">笔数<i></i></th>
							<th rowspan="2" data-sort="number" class="sortable">下注金额<i></i></th>
							<th rowspan="2">有效金额</th>
							<th colspan="3">会员输赢</th>
						</tr>
						<tr class="shead">
							<th>输赢</th>
							<th>退水</th>
							<th>盈亏结果</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4"></th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="data_footer">
			</div>
		</div>
		<div class="main5 gdiv" style="display:none">
			<div class="top_info">
				<span class="title">注单明细</span><span class="right"><a class="back"
						href="javascript:void(0)">返回</a></span>
			</div>
			<div class="contents">
				<table class="data_table list">
					<thead>
						<tr>
							<th>注单号</th>
							<th>投注时间</th>
							<th>种类</th>
							<th style="display: none;">类型</th>
							<th>账号</th>
							<th>投注内容</th>
							<th>下注金额</th>
							<th>退水(%)</th>
							<th>下注结果</th>
							<th>本级占成</th>
							<th class="result">本级结果</th>
							<th>占成明细</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th colspan="5"></th>
							<td class="money"></td>
							<td></td>
							<td class="money color"></td>
							<td></td>
							<td class="money color"></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="page">
				<div class="page_info">
					<span class="record"></span><span class="page_count"></span><span class="page_control"></span>
				</div>
			</div>
		</div>
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable mx"
			tabindex="-1" role="dialog" aria-describedby="shares" aria-labelledby="ui-id-1"
			style="position: absolute; height: 152.28px; width: 360px; top: 257px; left: 564.5px; display:none; right: auto; bottom: auto;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span
					id="ui-id-1" class="ui-dialog-title">2988316036# 占成明细</span><button type="button"
					class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"
					role="button" title="Close"><span
						class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span
						class="ui-button-text">Close</span></button></div>
			<div id="shares" class="popdiv ui-dialog-content ui-widget-content"
				style="display: block; width: auto; min-height: 96px; max-height: 346px; height: auto;">
				<table class="data_table">
					<thead>
						<tr>
							<th>类型</th>
							<th>账号</th>
							<th>占成</th>
							<th>退水</th>
							<th>赔率</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;">
			</div>
			<div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div>
			<div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
		</div>
		<div id='test'></div>
		<div id='testtime'></div>
		<div class="ui-widget-overlay ui-front ui-fronts" style="z-index: 100;display:none;"></div>
		<script language="javascript">
			layername = new Array();
            @foreach($layername as $key=>$vo)
				layername[{{$key}}] = "{{$vo}}";
            @endforeach
			var layer = {{$layer}};
			sdate = new Array();
            @foreach($sdate as $key=>$vo)
				sdate[{{$key}}] = "{{$vo}}";
			@endforeach
			myready();
		</script>
	</body>
</html>
