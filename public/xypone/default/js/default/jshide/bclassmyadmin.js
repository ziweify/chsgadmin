
function myready(){
    $("#yiwotongbu").click(function(){
	   if(!confirm("确定同步玩法吗?")) return false;
       $.ajax({
	      type:'POST',
		  url:'mclassyiwotongbu',
		  data:{gid:gid},
		  success:function(m){
		      if(Number(m)==1){
				  alert("同步成功");
			       window.location.href=window.location.href;
			  }
		  }
	   });
	});
    $("#add").click(function(){
	   var name=$("#name").val();
	   if(name.trim() == ''){
	       alert("名称不能为空");
		   return false;
	   }
       $.ajax({
	      type:'POST',
		  url:'mclassaddb',
		  data:'name='+name+'&gid='+gid,
		  success:function(m){
		      if(Number(m)==1){
			       window.location.href=window.location.href;
			  }
		  }
	   });
	});
	$(".edit").click(function(){
	   var name=$(this).parent().parent().find(".name").val();
	   var xsort=$(this).parent().parent().find(".xsort").val();
	   var ifok;
	   if($(this).parent().parent().find(".ifok").prop('checked')==true){
	      ifok=1;
	   }else{
	      ifok=0;
	   }
	   var bid=$(this).parent().parent().find("td:eq(2)").html();
	   if(Number(xsort)%1!=0){
	      alert("排序请输入数字");
		  return false;
	   }
       $.ajax({
	      type:'POST',
		  url:'mclasseditb',
		  data:'name='+name+"&xst="+xsort+"&ifok="+ifok+"&bid="+bid+"&gid="+gid,
		  success:function(m){
		      if(Number(m)==1){
			       window.location.href=window.location.href;
			  }
		  }
	   });

	});
	$("input:text").addClass('txt2');

	$("#clickall").click(function(){
        if($(this).prop('checked')==true){
		   $(".s_tb tr").find("td:first").find("input:checkbox").attr('checked',true);
		}else{
		   $(".s_tb tr").find("td:first").find("input:checkbox").attr('checked',false);
		}
	});
	$("#delall").click(function(){
        var idstr='|';
	    $(".s_tb tr").find("td:first").each(function(){
		    if($(this).find("input:checkbox").prop("checked")==true){
			   idstr += $(this).find("input:checkbox").val() + "|";
			}
		});
		del(idstr);
	});

	$(".delone").click(function(){
	      var idstr = '|' + $(this).parent().parent().find("td:first").find("input:checkbox").val() + '|';
		  del(idstr);
	});

    $(".game").change(function() {
        window.location.href = "mclassbigclass?gid=" + $(".game").val();
    });
}

function del(idstr){
    if(!confirm("确定要删除吗？")) return false;
       $.ajax({
	      type:'POST',
		  url:'mclassdelb',
		  data:'idstr='+idstr+'&gid='+gid,
		  success:function(m){
		      if(Number(m)==1){
			       window.location.href=window.location.href;
			  }
		  }
	   });
}
