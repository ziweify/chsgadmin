var page=1;
var pcount = 1;
function myready(){
   page = Number($(".page_info").attr('tpage'));
   var rcount =Number($(".page_info").attr("rcount"));
   var psize = Number($(".page_info").attr("psize"));
   pcount = rcount%psize==0 ? rcount/psize : ((rcount-rcount%psize)/psize)+1;
   $(".page_count").html("共 "+pcount+" 页");
   var str='';
   for(i=1;i<=pcount;i++){
       str += "&nbsp;<span class='current'><a ";
	   if(i==page) str += "class='red' ";
	   str += " href='javascript:void(0);'>"+i+"</a></span>&nbsp;";
   }
   $(".current").replaceWith(str);
   $(".page_info a").click(function(){
      if($(this).hasClass('next')){
	     page++;
	  }else if($(this).hasClass('previous')){
	     page--;
	  }else{
	     page= Number($(this).html());
	  }
	 
	  if(isNaN(page) | page<1 | page%1!=0 | page>pcount)  return false;
	 
	 window.location.href = "/stsm/libshow&tpage="+page;
	  return false;
   });
   
   $(".list tr").hover(function(){$(this).find("td").addClass("hover")},function(){$(this).find("td").removeClass("hover")});
   $(".chedan").click(function(){
	   var tid = $(this).attr("tid");
	   var zid = $(this).attr("zid");
	   $.ajax({
	   	type: 'post',
	   	url: '/stsm/chedan',
	   	data: {id:zid,tid:tid},
	   	dataType: 'json',
	   	cache: false,
	   	success: function(m) {
	   		if(m.code == 1){
				parent.getusermoney();
				parent.getlast15();
	   			window.location.href = "/stsm/libshow&tpage="+page;
	   		}else{
	   			alert(m.msg);
	   		}
	   	}
	   })
   });
}