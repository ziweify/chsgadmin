var lottery = "";
var lotterys;
var controlMenu = null;
var resetTimer;
$(function () {
    if (/MSIE (6|7)/.test(navigator.userAgent)) {
        var a = function () {
            $("#frame").height($("#contents").height())
        };
        a();
        $("#contents").resize(a)
    }
    $("#lotterys").hide();
    $(".menu_sub").hide();
    $("#contents").css("top", "62px");
    var b = $(".header .menu .menu_title li a").click(function () {
        b.removeClass("selected");
        var d = $(this);
        var g;
        d.addClass("selected");
        if (d.hasClass("control")) {
            $("#contents").css("top", "122px");
            $("#contents").addClass("current-bet");
            g = $("#lotterys").show().find("a:eq(0)")
        } else {
            $("#contents").removeClass("current-bet");
            $("#lotterys").hide();
            $("#contents").css("top", "91px")
        }
        $(".menu_sub").hide();
        var f = $(".menu_sub:eq(" + d.index() + ")");
        if (f.length == 1 && !f.attr("id")) {
            f.show();
            if (g) {
                g.click()
            } else {
                f.find("a:visible:eq(0)").click()
            }
        } else {
            $("#lotteryTypes").text(d.text());
            $("#ordersub").show()
        }
        var e = d.html();
        if (e == "开奖结果" || e == "报表查询") {
            $("#lotterys").hide();
            $(".menu_sub").hide();
            $("#contents").css("top", "62px")
        }
    });
    $(".header a").click(function () {
        var d = $(this).attr("href");
        if (d && d.indexOf("{lottery}") != -1) {
            d = d.replace("{lottery}", lottery)
        }
        var e = $(this).attr("target");
        if (e) {
            $("#" + e).attr("src", d)
        } else {
            if (d) {
                location.href = d
            }
        }
        return false
    });
    lotterys = $(".header .nav a").click(function () {
        lotterys.removeClass("selected");
        var d = $(this);
        $("#lotteryType").text(d.text());
        var f = d.addClass("selected").prop("id");
        var e = f.split("-");
        lottery = e[1];
        $(".header .menu_sub_links").hide();
        $("#" + lottery).show().find("a:eq(0)").click()
    });
    lotterys.eq(0).addClass("selected");
    $("#lotteryType").text(lotterys.eq(0).text());
    lottery = lotterys.eq(0).attr("id").split("-")[1];
    $(".header .menu_sub a").click(function () {
        var d = $(this);
        d.parent().children().removeClass("selected");
        $(this).addClass("selected")
    });
    if ($("#online").length == 1) {
        var c = function () {
            LIBS.get("online?_=" + (new Date()).getTime(), function (d) {
                $("#online").text(d)
            })
        };
        c();
        setInterval(c, 60000)
    }
});
