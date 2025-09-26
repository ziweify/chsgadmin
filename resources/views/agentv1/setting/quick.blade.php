<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="/default/css/agent/red/master.css" rel="stylesheet" type="text/css">
    <link href="/default/css/agent/red/layout.css" rel="stylesheet" type="text/css">
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/odds.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/quick.js"></script>
    <script type="text/javascript">
        var selectLottery = $("<select id='selectLottery'>");
        selectLottery.append($('<option>').val('').html('全选'));
        @foreach($lotterys as $lottery)
        var lot = $('<option>').val('{{$lottery['lottery']}}').html('{{$lottery['gname']}}');
        selectLottery.append(lot);
        @endforeach
    </script>

</head>
<body style="">
<div class="main">
    <div class="top_info">
        <span class="title">盘口设置</span>
    </div>

    <div class="tab-wrapper">
        <a id="quick" href="quick">彩票类</a>

    </div>
    <div class="game_tab_class">
        <ul>
            <li><a id="tab_0" href="javascript:;">快开彩</a>
            </li>
        </ul>
        <input id="btnCopy" type="button" value="快速设置">
        <input id="btnTball" type="button" value="tball">
    </div>

    <div id="p_0" class="contents input_panel tab_panel">
        @foreach($results as $result)
        <table class="data_table list at_0" id="t_{{$result['lottery']}}" data-t="{{$result['template']}}" data-n="{{$result['gname']}}">
            <thead>
            <tr>
                <th colspan="2">种类</th>
                <th colspan="2">A盘</th>
                <th colspan="2">B盘</th>
                <th colspan="2">C盘</th>
                <th colspan="2">D盘</th>
                <th>上限</th>
            </tr>
            <tr class="shead">
                <th></th>
                <th></th>
                <th>赔率</th>
                <th>退水</th>
                <th>赔率</th>
                <th>退水</th>
                <th>赔率</th>
                <th>退水</th>
                <th>赔率</th>
                <th>退水</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($result['list'] as $d=>$v)
            @foreach($v as $i=>$data)
            <tr data-ok="{{$data['ok']}}" @if($i==0)data-ck="{{$data['ck']}}"@endif>
                @if($i==0)<th rowspan="{{count($v)}}">{{$data['ckname']}}</th>@endif
                <td>@if($data['ckname'] != $data['plname']){{$data['plname']}}@endif<a href="javascript:showDialog('盘口设置--明细','{{$result['template']}}-{{$data['ck']}}','{{$result['lottery']}}');"></a></td>
                <td class="colA"><input name="odds" value="{{$data['pla']}}" data-init="{{$data['pla']}}"></td>
                @if($i==0)<td class="colA" rowspan="{{count($v)}}"><input name="cm" value="{{$data['cma']}}" data-init="{{$data['cma']}}">%</td>@endif
                <td class="colB"><input name="odds" value="{{$data['plb']}}" data-init="{{$data['plb']}}"></td>
                @if($i==0)<td class="colB" rowspan="{{count($v)}}"><input name="cm" value="{{$data['cmb']}}" data-init="{{$data['cmb']}}">%</td>@endif
                <td class="colC"><input name="odds" value="{{$data['plc']}}" data-init="{{$data['plc']}}"></td>
                @if($i==0)<td class="colC" rowspan="{{count($v)}}"><input name="cm" value="{{$data['cmc']}}" data-init="{{$data['cmc']}}">%</td>@endif
                <td class="colD"><input name="odds" value="{{$data['pld']}}" data-init="{{$data['pld']}}"></td>
                @if($i==0)<td class="colD" rowspan="{{count($v)}}"><input name="cm" value="{{$data['cmd']}}" data-init="{{$data['cmd']}}">%</td>@endif
                <td class="oddsmax max">99999</td>
            </tr>
            @endforeach
            @endforeach
            </tbody>
        </table>
        @endforeach
    </div>

    <div class="data_footer control">
        <input type="button" class="button" value="保存" onclick="save(ADMIN)"> <input type="reset" class="button"
                                                                                       value="重置">
    </div>
</div>
<div id="details" style="display: none;">
    <table class="data_table list">
        <thead>
        <tr>
            <th>种类</th>
            <th>A盘</th>
            <th>B盘</th>
            <th>C盘</th>
            <th>D盘</th>
            <th>上限</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div id="dialog" title="Basic dialog" style="display: none;">
    <div id="dialog_content"></div>
</div>


<script type="text/javascript">
    /*
	$("table").each(function () {
          //  console.log($(this).attr('id'));
			var table=$(this).attr('id');
			var trList = $("#"+table).children("tbody").children("tr");
		var table1=table.substr(2);
		console.log(table1);

var str='';
var str1='';
    for (var i=0;i<trList.length;i++) {//("input[name^='news']")
		var ok=trList.eq(i).attr('data-ok');
		var ck=trList.eq(i).attr('data-ck');

		trList.eq(i).children("td").children("input[name^='odds']").eq(0).attr("value",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_a"]?>');
		trList.eq(i).children("td").children("input[name^='odds']").eq(1).attr("value",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_b"]?>');
		trList.eq(i).children("td").children("input[name^='odds']").eq(2).attr("value",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_c"]?>');
		trList.eq(i).children("td").children("input[name^='odds']").eq(3).attr("value",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_d"]?>');

		trList.eq(i).children("td").children("input[name^='cm']").eq(0).attr("value",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_a"]?>');
		trList.eq(i).children("td").children("input[name^='cm']").eq(1).attr("value",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_b"]?>');
		trList.eq(i).children("td").children("input[name^='cm']").eq(2).attr("value",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_c"]?>');
		trList.eq(i).children("td").children("input[name^='cm']").eq(3).attr("value",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_d"]?>');

		trList.eq(i).children("td").children("input[name^='odds']").eq(0).attr("data-init",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_a"]?>');
		trList.eq(i).children("td").children("input[name^='odds']").eq(1).attr("data-init",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_b"]?>');
		trList.eq(i).children("td").children("input[name^='odds']").eq(2).attr("data-init",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_c"]?>');
		trList.eq(i).children("td").children("input[name^='odds']").eq(3).attr("data-init",'<=$odds["'+table1+'"]["'+ok+'"]["g_panlu_d"]?>');

		trList.eq(i).children("td").children("input[name^='cm']").eq(0).attr("data-init",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_a"]?>');
		trList.eq(i).children("td").children("input[name^='cm']").eq(1).attr("data-init",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_b"]?>');
		trList.eq(i).children("td").children("input[name^='cm']").eq(2).attr("data-init",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_c"]?>');
		trList.eq(i).children("td").children("input[name^='cm']").eq(3).attr("data-init",'<=$cm["'+table1+'"]["'+ck+'"]["g_panlu_d"]?>');

		//console.log(trList.eq(i).children("td").children(":input").eq(0).val());
		if(trList.eq(i).attr('data-ck')){
		//str +=trList.eq(i).attr('data-ck')+'|';
		//str1 +=trList.eq(i).find("input").eq(0).text()+'|'
		}
			}
        });

var trList = $("#t_XYFT").children("tbody").children("tr");
var str='';
var str1='';
    for (var i=0;i<trList.length;i++) {
		//trList.eq(i).children("td").children(":input").eq(0).attr("value",'dfdsdfsdfsfds');
		//console.log(trList.eq(i).children("td").children(":input").eq(0).val());
		if(trList.eq(i).attr('data-ck')){
		//str +=trList.eq(i).attr('data-ck')+'|';
		//str1 +=trList.eq(i).find("input").eq(0).text()+'|'
		}
       // var tdArr = trList.eq(i).find("td");
       // var history_income_type = tdArr.eq(0).find('input').val();//收入类别
       /// var history_income_money = tdArr.eq(1).find('input').val();//收入金额
       // var history_income_remark = tdArr.eq(2).find('input').val();//    备注

       // alert(history_income_type);
       // alert(history_income_money);
        //alert(history_income_remark);
    }
	//console.log(str+str1);
	*/
</script>
</body>
</html>
