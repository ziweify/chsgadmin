var url = "/agent/report/shares";
$(function () {
    LIBS.colorMoney(".color", "minus");
    $(".detail a").click(function () {
        var a = $("#shares");
        if (a.length == 0) {
            a = $('<div id="shares">').addClass("popdiv");
            a.dialog({
                autoOpen: false,
                width: 300,
                maxHeight: 400
            })
        }
        var b = $(this).attr("bid");
        var drawDate = $(this).attr("drawDate");
        a.dialog("option", {
            title: b + "# 占成明细"
        });
        a.empty();
        a.append('<span class="loading">载入中……</span>').load(url, {
            bid: b,
            drawDate: drawDate
        });
        a.dialog("open")
    });
    $(".th_icon").click(function (b) {
        var a = $(this).parents(".th-box").width() - 30;
        b.preventDefault();
        $(this).siblings(".th_search").toggleClass("expanded").css("max-width", a);
        $(".th_search").not($(this).siblings(".th_search")).removeClass("expanded")
    });
    $(".th_icon1").click(function (b) {
        var a = $(".display_amount").attr("style");
        if (a == "display: none;") {
            $(".display_amount").css("display", "");
            $(".input_amount").css("display", "none")
        } else {
            $(".display_amount").css("display", "none");
            $(".input_amount").css("display", "")
        }
    });
    $(".th_search").blur(function (b) {
        var a = $(this).val();
        if (a != null && a.trim().length > 0) {
            $(this).siblings(".th_icon").css("background-image", "url(../../default/images/player/filterbtn_after.jpg)")
        } else {
            $(this).siblings(".th_icon").css("background-image", "url(../../default/images/player/filterbtn_before.jpg)")
        }
    });
    $("input[name='minAmount1']").keydown(function (a) {
        if (a.keyCode == 13) {
            initNewBetsQuery()
        }
    });
    $("input[name='maxAmount1']").keydown(function (a) {
        if (a.keyCode == 13) {
            initNewBetsQuery()
        }
    })
});

function initNewBetsQuery() {
    var c = window.location.href;
    var a = $("input[name='minAmount1']").val();
    var e = $("input[name='maxAmount1']").val();
    var d = updateURLParameter(c, "minAmount", a);
    var b = updateURLParameter(d, "maxAmount", e);
    window.location = b
}

function updateURLParameter(b, d, h) {
    var k = "";
    var g = b.split("?");
    var c = g[0];
    var f = g[1];
    var j = "";
    if (f) {
        g = f.split("&");
        for (var e = 0; e < g.length; e++) {
            if (g[e].split("=")[0] != d) {
                k += j + g[e];
                j = "&"
            }
        }
    }
    var a = j + "" + d + "=" + h;
    return c + "?" + k + a
}

function queryBetlist() {
    var d = $("input[name='bid1']").val();
    if (d != null) {
        d = d.trim();
        $("input[name='bid']").val(d)
    }
    var a = $("input[name='minAmount1']").val();
    if (a != null) {
        a = a.trim();
        $("input[name='minAmount']").val(a)
    }
    var b = $("input[name='maxAmount1']").val();
    if (b != null) {
        b = b.trim();
        $("input[name='maxAmount']").val(b)
    }
    var c = $("select[name='lottery1']").val();
    if (c != null) {
        $("select[name='lottery']").val(c)
    }
};
