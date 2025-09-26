function myready(){
	$(".game").change(function(){
	   var gid = $(this).val();
	  window.location.href = "ruleshow?gid="+gid;
	});
}

