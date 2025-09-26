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
    <script type="text/javascript" src="/default/js/dfpoints.js?v=112"></script>
</head>
<body style="">
<div class="main">
    <div class="top_info">
	<span class="title">默认退水</span>
        <span class="right"></span>
    </div>
    <div class="tab-wrapper">
        <a id="param" href="?username=pk168">彩票类</a>
    </div>
    <div class="game_tab_class">
        <a id="tab_0" href="javascript:;">快开彩</a>
        <div id="cmcontrol">批量设置：<input id="point" type="number" /> <input onclick="yijian()" type="button" value="确定"/></div>
    </div>
    <div id="p_0" class="contents param_panel input_panel tab_panel" style="display: flex;flex-wrap: wrap;">
        @foreach($lotterys as $lottery)
        <div style="font-weight: bold;display: flex;padding: 5px;align-items: center;width: 160px;">
            <div style="margin-right: 5px;">{{$lottery['gname']}}</div>
            <input gid="{{$lottery['gid']}}" name="point" value="{{$lottery['point']}}" class="commission"><span style="margin-left: 5px;">%</span>
        </div>
        @endforeach
    </div>
</div>
<div class="data_footer control">
    {{--保存时下线是否等量增加: <input type="radio" name="downline" value="all" checked="checked">不增加 <input type="radio"
                                                                                                            name="downline"
                                                                                                            value="agent">只代理
    <input type="radio" name="downline" value="member">代理和会员--}}
    <input type="button" value="保存" onclick="saveParam()" class="button">
    <input type="button" value="取消" onclick="back()" class="button">
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
			var trList = $(this).children("td").eq(0);
				$(this).find("input[name^='A']").attr("value",'');
				$(this).find("input[name^='B']").attr("value",'');
		     	$(this).find("input[name^='C']").attr("value",'');
		    	$(this).find("input[name^='D']").attr("value",'');
			    $(this).find("input[name^='maxAmount']").attr("value",'');
		     	$(this).find("input[name^='maxPeriod']").attr("value",'');
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
    var pathname = '/agent/user/';
</script>


</body>
</html>
