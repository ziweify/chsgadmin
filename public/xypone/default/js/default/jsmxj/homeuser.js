  var index = 1;
function myready(){
    $(".naviga3").click(function() {
        $(".zhao").removeClass("ivfTfC").addClass("OSUUp");
        $(".menu").removeClass("iJamhB").addClass("efUsXr");
    });
    $(".zhao").click(function() {
        $(".zhao").removeClass("OSUUp").addClass("ivfTfC");
        $(".menu").removeClass("efUsXr").addClass("iJamhB");
    });
	$(".game-type ul li").click(function(){
		$(".game-type ul li").removeClass('active');
		$(this).addClass('active');
		var index = $(this).index();
		var m = index*100;
		$(".jkitbP").css({'transform':'translateX(-'+m+'%)'});
	});
    $("a.refresh").click(function() {
        window.location.href = window.location.href;
    });
    if (cnews > 0) {
        $(".prev-btn").click(function() {
            index--;
            if (index < 1) index = 1;
            $("pre").hide();
            $("#r" + index).show();
            $(".total").html(index + "/" + cnews);
        });
        $(".next-btn").click(function() {
            index++;
            if (index > cnews) {
                $(".ReactModalPortal").html('');
                return false;
            }
            $("pre").hide();
            $("#r" + index).show();
            $(".total").html(index + "/" + cnews);
        });
        $(".close-btn").click(function() {
            $(".ReactModalPortal").html('');
        });
        $("#r" + index).show();
        $(".total").html(index + "/" + cnews);
    }
   /* $(".menu_type a").click(function() {
        var type = $(this).attr("type");
        if (type == 'home') {
            $(".menu").hide();
            $(".zhao").hide();
        } else if (type == "logout") {
           window.location.href = "/stsh/logout";
        } else {
           window.location.href = "/stsh/othershow&type=" + type;
        }
    }); */
    $(".game-list ul li").click(function() {
         window.location.href = "/stsh/makeshow?type=lib&gids="+$(this).attr("gid");
    });
}