function myready() {
	changeh(document.documentElement.scrollHeight+500);
	$("label").addClass('red');
	$("select.menu").change(function(){
	   window.location.href= $(this).val();
	});
	$(".send").click(function() {
		var str = '[';
		$(".ifopen").each(function(i) {
			if(i>0) str += ',';
			str += '{"gid":'+'"'+$(this).val()+'",';
			if($(this).prop("checked")){
			   str += '"ifopen":'+'"1"';
			}else{
			   str += '"ifopen":'+'"0"';
			}
			str += ',"px":'+'"'+$(this).parent().parent().find("input:text").val()+'"';
			str += ',"taskgroup":'+'"'+$(this).parent().parent().find(".taskgroup").val()+'"}';
		});
		str += ']';
		//alert(str);
		$.ajax({
			type: 'POST',
			url: '/agent/zshuisetgame',
			data: 'str=' + str,
			success: function(m) {
				if (m.success) {
					alert("修改成功");
					window.location.href = window.location.href
				}else{
				    alert(m.message);
				}
			}
		})
	})
}
