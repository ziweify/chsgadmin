<!DOCTYPE html>
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
    <link href="/default/css/agent/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/param.js"></script>
</head>

<body style="">
<div class="main">
    <div class="top_info">
	<span class="title">{{$layername}} <span>{{$username}}（{{$name}}）</span> -> 退水
	</span>
        <span class="right"><input type="hidden" id="username" value="{{$username}}"><a class="back" onclick="back()">返回</a></span>
    </div>
    <ul class="tab">
        <li class="tab_title02">
            <a href="/agent/user/edit?username={{$username}}">基本资料</a>
            <a href="/agent/user/param?username={{$username}}" class="selected">退水设定</a>
        </li>
    </ul>
    <div class="tab-wrapper">
        <a id="param" href="?username={{$username}}">彩票类</a>
    </div>
    <div class="game_tab_class">
        <a id="tab_0" href="javascript:;">快开彩</a>
        <div id="cmcontrol">赚取退水：<input> <input type="button" value="确定"></div>
    </div>
    <div id="p_0" class="contents param_panel input_panel tab_panel">
        <table class="data_table quick">
            <thead><tr>
                <th>种类</th>
                @foreach($pan as $v)
                    <th>{{$v}}盘(%)</th>
                @endforeach
                <th>操作</th>
                <th>注单限额</th>
                <th>单期限额</th>
                <th>操作</th></tr></thead>
            <tbody>
            <tr class="t_BALL"><th class="color">号码类（球号、车号、正码等）</th>
                @foreach($pan as $v)
                    <td><input name="{{$v}}" class="commission" value="2"></td>
                @endforeach
                <td><input type="button" class="commisionButton" value="修改"></td>
                <td><div><input name="maxAmount" class="amount"></div></td>
                <td><div><input name="maxPeriod" class="amount"></div></td>
                <td><input type="button" class="amountButton" value="修改"></td>
            </tr>
            <tr class="t_LM"><th class="color">两面类（大小、单双、龙虎、三军等）</th>
                @foreach($pan as $v)
                    <td><input name="{{$v}}" class="commission" value="2"></td>
                @endforeach
                <td><input type="button" class="commisionButton" value="修改"></td>
                <td><div><input name="maxAmount" class="amount"></div></td>
                <td><div><input name="maxPeriod" class="amount"></div></td>
                <td><input type="button" class="amountButton" value="修改"></td>
            </tr>
            <tr class="t_ITEM"><th class="color">多项类（方位、中发白、总和过关等）</th>
                @foreach($pan as $v)
                    <td><input name="{{$v}}" class="commission" value="2"></td>
                @endforeach
                <td><input type="button" class="commisionButton" value="修改"></td>
                <td><div><input name="maxAmount" class="amount"></div></td>
                <td><div><input name="maxPeriod" class="amount"></div></td>
                <td><input type="button" class="amountButton" value="修改"></td>
            </tr>
            <tr class="t_MP"><th class="color">连码类（任选二、任选三、前二组选等）</th>
                @foreach($pan as $v)
                    <td><input name="{{$v}}" class="commission" value="2"></td>
                @endforeach
                <td><input type="button" class="commisionButton" value="修改"></td>
                <td><div><input name="maxAmount" class="amount"></div></td>
                <td><div><input name="maxPeriod" class="amount"></div></td>
                <td><input type="button" class="amountButton" value="修改"></td>
            </tr>
            <tr class="t_"><th class="color">其它（冠亚和、前中后三等）</th>
                @foreach($pan as $v)
                    <td><input name="{{$v}}" class="commission" value="2"></td>
                @endforeach
                <td><input type="button" class="commisionButton" value="修改"></td>
                <td><div><input name="maxAmount" class="amount"></div></td>
                <td><div><input name="maxPeriod" class="amount"></div></td>
                <td><input type="button" class="amountButton" value="修改"></td>
            </tr>
            </tbody>
        </table>
        @foreach($lotterys as $lottery)
        <div class="game_tab"><a>{{$lottery['gname']}}</a>@if($lottery['md']==1)<span>【预设】</span>@endif</div>
        <table class="layout">
            <tbody>
            <tr class="{{$lottery['template']}}">
                <td class="panel">
                    <table class="list data_table at_0">
                        <thead>
                        <tr>
                            <th>种类</th>
                            @foreach($pan as $v)
                            <th>{{$v}}盘(%)</th>
                            @endforeach
                            <th>注单限额</th>
                            <th>单期限额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lottery['pan'][0] as $item)
                        <tr class="t_{{$item['gc']}}">
                            <th class="color">{{$item['name']}}<input name="id" type="hidden" value="{{$lottery['lottery']}}_{{$item['class']}}"></th>
                            @foreach($item['mypan'] as $p=>$v)
                            <td>
                                <div><input name="{{$p}}" value="{{$v}}" class="commission"></div>
                                <div>( <span class="data">{{$item['fpan'][$p]}}</span> )</div>
                            </td>
                            @endforeach
                            <td>
                                <div><input name="maxAmount" value="{{$item['mymaxje']}}" class="amount" lang="{{$item['mymaxje']}}"></div>
                                <div>( <span class="data">{{$item['fmaxje']}}</span> )</div>
                            </td>
                            <td>
                                <div><input name="maxPeriod" value="{{$item['mycmaxje']}}" class="amount" lang="{{$item['mycmaxje']}}"></div>
                                <div>( <span class="data">{{$item['fcmaxje']}}</span> )</div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
                <td class="panel">
                    <table class="list data_table at_0">
                        <thead>
                        <tr>
                            <th>种类</th>
                            @foreach($pan as $v)
                            <th>{{$v}}盘(%)</th>
                            @endforeach
                            <th>注单限额</th>
                            <th>单期限额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lottery['pan'][1] as $item)
                            <tr class="t_{{$item['gc']}}">
                                <th class="color">{{$item['name']}}<input name="id" type="hidden" value="{{$lottery['lottery']}}_{{$item['class']}}"></th>
                                @foreach($item['mypan'] as $p=>$v)
                                    <td>
                                        <div><input name="{{$p}}" value="{{$v}}" class="commission"></div>
                                        <div>( <span class="data">{{$item['fpan'][$p]}}</span> )</div>
                                    </td>
                                @endforeach
                                <td>
                                    <div><input name="maxAmount" value="{{$item['mymaxje']}}" class="amount" lang="{{$item['mymaxje']}}"></div>
                                    <div>( <span class="data">{{$item['fmaxje']}}</span> )</div>
                                </td>
                                <td>
                                    <div><input name="maxPeriod" value="{{$item['mycmaxje']}}" class="amount" lang="{{$item['mycmaxje']}}"></div>
                                    <div>( <span class="data">{{$item['fcmaxje']}}</span> )</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
        @endforeach
    </div>
</div>
@if($tmd > 0)
    <div class="warning_panel">
        当前用户已下注，【预设】退水设置将在明天开盘前生效。
    </div>
@endif
<div class="data_footer control">
    保存时下线是否等量增加: <input type="radio" name="downline" value="all" checked="checked">不增加 <input type="radio"
                                                                                                            name="downline"
                                                                                                            value="agent">只代理
    <input type="radio" name="downline" value="member">代理和会员
    <input type="button" value="保存" onclick="saveParam()" class="button">
    <input type="button" value="取消" onclick="back()" class="button">
</div>
<script type="text/javascript">

    //$("table").each(function () {
    /* //  console.log($(this).attr('id'));
			var table=$(this).attr('id');
			var trList = $("#"+table).children("tbody").children("tr");
		var table1=table.substr(2);
		console.log(table1);

var str='';
var str1='';
    for (var i=0;i<trList.length;i++) {//("input[name^='news']")
		var ok=trList.eq(i).attr('data-ok');
		var ck=trList.eq(i).attr('data-ck');

		trList.eq(i).children("td").children("input[name^='odds']").eq(0).attr("value",'');
		trList.eq(i).children("td").children("input[name^='odds']").eq(1).attr("value",'');
		trList.eq(i).children("td").children("input[name^='odds']").eq(2).attr("value",'');
		trList.eq(i).children("td").children("input[name^='odds']").eq(3).attr("value",'');

		trList.eq(i).children("td").children("input[name^='cm']").eq(0).attr("value",'');
		trList.eq(i).children("td").children("input[name^='cm']").eq(1).attr("value",'');
		trList.eq(i).children("td").children("input[name^='cm']").eq(2).attr("value",'');
		trList.eq(i).children("td").children("input[name^='cm']").eq(3).attr("value",'');

		trList.eq(i).children("td").children("input[name^='odds']").eq(0).attr("data-init",'');
		trList.eq(i).children("td").children("input[name^='odds']").eq(1).attr("data-init",'');
		trList.eq(i).children("td").children("input[name^='odds']").eq(2).attr("data-init",'');
		trList.eq(i).children("td").children("input[name^='odds']").eq(3).attr("data-init",'');

		trList.eq(i).children("td").children("input[name^='cm']").eq(0).attr("data-init",'');
		trList.eq(i).children("td").children("input[name^='cm']").eq(1).attr("data-init",'');
		trList.eq(i).children("td").children("input[name^='cm']").eq(2).attr("data-init",'');
		trList.eq(i).children("td").children("input[name^='cm']").eq(3).attr("data-init",'');

		//console.log(trList.eq(i).children("td").children(":input").eq(0).val());
		if(trList.eq(i).attr('data-ck')){
		//str +=trList.eq(i).attr('data-ck')+'|';
		//str1 +=trList.eq(i).find("input").eq(0).text()+'|'
		}
			}
        });



		$(".list.data_table.at_0").children("tbody").children("tr").each(function () {
            var id=$(this).children("th").children("input[name^='id']").attr('value');
			//var trList =

			$(this).children("td").eq(0).before("');
			$(this).children("td").eq(1).before("	");
			$(this).children("td").eq(1).after('');
			$(this).children("td").eq(2).before("');
			$(this).children("td").eq(3).before("');

			///console.log(trList);
				$(this).find("input[name^='A']").attr("value",'');
			     $(this).find("span").eq(0).text('');

				$(this).find("input[name^='B']").attr("value",'');
			    $(this).find("span").eq(1).text('');

		     	$(this).find("input[name^='C']").attr("value",'');
			    $(this).find("span").eq(2).text('');

		    	$(this).find("input[name^='D']").attr("value",'');
			    $(this).find("span").eq(3).text('');

			    $(this).find("input[name^='maxAmount']").attr("value",'');
			    $(this).find("input[name^='maxAmount']").attr("lang",'');
			    $(this).find("span").eq(4).text('');

		     	$(this).find("input[name^='maxPeriod']").attr("value",'');
			  	$(this).find("input[name^='maxPeriod']").attr("lang",'');
			    $(this).find("span").eq(5).text('');
					//});

		});


		$(".data_table.quick").each(function () {
			var table=$(this).attr('id');
			var trList = $(this).children("tbody").children("tr");
		for (var i=0;i<trList.length;i++) {//("input[name^='news']")
		var ok=trList.eq(i).attr('class');
			console.log(ok);
		var ck=trList.eq(i).attr('data-ck');
		trList.eq(i).children("td").eq(0).children("input").attr("value",'');
		trList.eq(i).children("td").eq(1).children("input").attr("value",'');
		trList.eq(i).children("td").eq(2).children("input").attr("value",'');
		trList.eq(i).children("td").eq(3).children("input").attr("value",'');
		trList.eq(i).children("td").eq(4).children("input").attr("value",'');
		trList.eq(i).children("td").eq(5).children("input").attr("value",'');
				}
           // var id=$(this).children("th").children("input[name^='id']").attr('value');
			//var trList = $(this).children("td").eq(0);
		 //  $(this).children('td').find("input[name^='A']").attr("value",'111');
		 //  $(".data_table.quick").children("tbody").children("tr").children('td').find("input[name^='B']").attr("value",'');
		  // $(".data_table.quick").children("tbody").children("tr").children('td').find("input[name^='C']").attr("value",'');
		 //  $(".data_table.quick").children("tbody").children("tr").children('td').find("input[name^='D']").attr("value",'');
		  // $(".data_table.quick").children("tbody").children("tr").children('td').find("input[name^='maxAmount']").attr("value",'');
		  // $(".data_table.quick").children("tbody").children("tr").children('td').find("input[name^='maxPeriod']").attr("value",'');
					});
			*/

var pathname = '/agent/user/param/';
</script>

</body>
</html>

</html>
