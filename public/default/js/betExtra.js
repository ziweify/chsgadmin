/*$(document).ready(function(){
	var page=$('.next').attr('href');
	console.log(page);
	var str =$('.page_count').text();
	
		var num= parseInt(str.replace(/[^0-9]/ig,""))+1;
	var table=$('tbody').find('tr');
       var  arr=[]; 
	for(var i=0;i<table.length;i++){
		var tr=table.eq(i).children('td');
		var qishu=tr.eq(2).text();
		qishu=qishu.replace(/[^0-9]/ig,"");
		var id=tr.eq(0).text();
		id=id.replace(/[^0-9]/ig,"");
		var money=tr.eq(5).text();
		money=parseInt(money);
		var win=tr.eq(7).text();
		win=parseInt(win);
		var type=tr.eq(2).text();
		
		type=type.replace(/[0-9]/ig,"");	
		type=type.replace('期',"");
		var time=tr.eq(1).text();
		
		console.log(time.substring(0,19));
		arr[i]=[qishu,money,win,id,type,time];
		
	}
	
	var url="http://web.bw.com/bet.php";
   $.ajax({
             url: url,//提交访问的URL
             type: 'post',//提交的方法
             async:true, 
             data:{"data":JSON.stringify(arr), //POS提交用户名字段
               },
             dataType: 'text',//返回的内容的类型，由于PHP文件是直接echo的，那么这里就是text
             timeout: 10000,//超时时间

             success: function(data){
             ///var jsonData = eval('(' + data + ')');
             }
         });

	
if(page!=undefined){
   		window.location.href=page;
   }

	   
	  
		
		
	
		

});
*/

function formatDate(a) {
    var b = ["日", "一", "二", "三", "四", "五", "六"];
    return a.format("yyyy-MM-dd hh:mm:ss") + " 星期" + b[a.getDay()]
}

function getStatusDesc(a) {
    var b = a;
    if (a != null) {
        if (a == "0") {
            b = "正常结算"
        } else {
            if (a == "1") {
                b = "已取消"
            } else {
                if (a == "2") {
                    b = "无成绩取消"
                }
            }
        }
    }
    return b
}

function queryBetExtraDetail(c, a, b) {
    $.ajax({
        url: "/agent/report/betExtraDetail",
        method: "GET",
        dataType: "json",
        data: {
            userName: c,
            bid: a,
            gameId: b
        },
        success: function (d) {
            betExtraDetail(d)
        }
    })
}

function betExtraDetail(c) {
    var a = "";
    a += '<div class="bet-extra-table-wrapper">';
    a += '<table class="bet-extra-table">';
    a += "<thead>";
    a += "<tr>";
    a += "<th>结算时间</th>";
    a += "<th>状态</th>";
    a += "<th>渠道</th>";
    a += "<th>IP</th>";
    a += "<th>备注</th>";
    a += "</tr>";
    a += "</thead>";
    a += "<tbody>";
    a += "<tr>";
    if (c.success) {
        a += "<td>" + formatDate(new Date(c.data.settleTime)) + "</td>";
        a += "<td>" + getStatusDesc(c.data.status) + "</td>";
        a += "<td>" + (c.data.channel == null ? "" : c.data.channel) + "</td>";
        a += "<td>" + (c.data.ip == null ? "" : c.data.ip) + "</td>";
        a += "<td>" + (c.data.remark == null ? "" : c.data.remark) + "</td>"
    } else {
        a += '<td colspan="5" style="text-align: center;">' + c.message + "</td>"
    }
    a += "</tr>";
    a += "</tbody>";
    a += "</table>";
    a += "</div>";
    var b = $("#betExtraDialog").dialog({
        autoOpen: false,
        modal: true,
        title: c.data.bid + " 注单明细",
        width: "600"
    });
    b.html(a);
    b.dialog("open");
    setTimeout(function () {
        $(".bet-extra-table").fixedHeaderTable({
            footer: true,
            fixedColumn: false
        })
    }, 0)
};