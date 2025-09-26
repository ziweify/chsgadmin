function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function kuaicase(n) {
    switch (n) {
        case 1:
            return "0px";
        case 2:
            return "-43px";
        case 3:
            return "-86px";
        case 4:
            return "-129px";
        case 5:
            return "-172px";
        case 6:
            return "-215px"
    }
}

var animateMethod = {}, intervalSsc = null, animateID = {}, time = 600, pk10animate = !1, pkid, publicHeadOrf = {};
animateMethod.loadingList = function (n, e) {
    e ? $(n).append('<div id="loadingbox"></div>') : $(n).find("#loadingbox").remove()
}, animateMethod.sscAnimate = function (n) {
    "gdklsf" == n && ($(n).find(".numred").removeClass("numred"), $(n).find(".numred").removeClass("numgreen"));
    var e = $(n).find(".kajianhao"), i = 600;
    $(n).find(".opentyle").show(), $(n).find(".cuttime").hide();
    var a = setInterval(function () {
        $(n).find(".kajianhao li:last-child").css({"margin-right": "0", "margin-left": "30px"});
        var a = $(e).find("li").length;
        i--;
        for (var t = 0; t < a; t++) {
            $(e).find("li").eq(t).css({paddingTop: "0px"}), $(e).find("li").eq(t).css({lineHeight: "0px"}), $(e).find("li").eq(t).text(excutenum());
            var d = 50 * excutenum();
            $(e).find("li").eq(t).stop().animate({paddingTop: "35px"}, d), $(e).find("li").eq(t).stop().animate({lineHeight: "60px"}, 100)
        }
        100 == i && $("#waringbox").show(300)
    }, 100);
    animateID[n] = a
}, animateMethod.sscAnimateEnd = function (n, e, i) {
    n = n.split(",");
    var a = $(e).find(".kajianhao");
    $(a).find("li").removeClass("numred"), $(a).find("li").removeClass("numgreen"), $(a).find("li").removeClass("numblue");
    for (var t = 0, d = n.length; t < d; t++) {
        "#gxklsf" != e && (1 == i[t] ? $(a).find("li").eq(t).addClass("numred") : 2 == i[t] ? $(a).find("li").eq(t).addClass("numgreen") : $(a).find("li").eq(t).addClass("numblue")), t < n.length && $(a).find("li:last-child").css({
            "margin-right": "0",
            "margin-left": "30px"
        }), $(a).find("li").eq(t).css({paddingTop: "0px"}), $(a).find("li").eq(t).text(n[t]);
        var r, l = 50 * excutenum();
        r = -1 != window.location.href.indexOf("/index") ? "48px" : "36px", $(a).find("li").eq(t).stop().animate({lineHeight: r}, l)
    }
    $("#waringbox").hide("200")
};