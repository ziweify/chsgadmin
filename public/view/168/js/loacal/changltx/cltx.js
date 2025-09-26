$(function () {
    cltxmethod.start()
});
var cltxmethod = {};
cltxmethod.start = function () {
    var s = window.location.href;
    if (void 0 != s.split("?")[1]) {
        var e = s.split("?")[1], l = s.split("?")[2], i = s.split("?")[3];
        $("#box" + cltxmethod.getBoxId(e, l, i)).show().siblings().hide()
    }
}, cltxmethod.getBoxId = function (s, e, l) {
    if (zhmssxlz = [], zhmssxmc = [], zhmssxmc.push(e), "10001" == s) {
        if ($($("#zhms").find(".sinli")).each(function (s) {
            $(this).hasClass("checked") && $(this).find("i").text() != e && $(this).removeClass("checked")
        }), "1" == l || "2" == l) return $("#zhms .zhmslz").find(".lztype").eq(1).addClass().siblings().removeClass("checked"), zhmssxlz.push(1), e + "1";
        if ("3" == l || "4" == l) return $("#zhms .zhmslz").find(".lztype").eq(0).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2";
        if ("5" == l || "6" == l) return $("#zhms .zhmslz").find(".lztype").eq(2).addClass().siblings().removeClass("checked"), zhmssxlz.push(3), e + "3"
    } else if ("10002" == s || "10004" == s || "10003" == s) {
        if ($($("#zhms").find(".sinli")).each(function (s) {
            if ($(this).hasClass("checked")) {
                var l = $(this).find("i").text();
                l != e && ("11" == e ? (zhmssxmc = [], zhmssxmc.push("6"), e = 6, "6" != l && $(this).removeClass("checked")) : $(this).removeClass("checked"))
            }
        }), "1" == l || "2" == l) return $("#zhms .zhmslz").find(".lztype").eq(1).addClass().siblings().removeClass("checked"), zhmssxlz.push(1), e + "1";
        if ("3" == l || "4" == l) return $("#zhms .zhmslz").find(".lztype").eq(0).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2";
        if ("5" == l || "6" == l || "7" == l) return $("#zhms .zhmslz").find(".lztype").eq(2).addClass().siblings().removeClass("checked"), zhmssxlz.push(3), "123"
    } else if ("10005" == s || "10009" == s) {
        if ($($("#zhms").find(".sinli")).each(function (s) {
            if ($(this).hasClass("checked")) {
                var l = $(this).find("i").text();
                l != e && ("11" == e ? (zhmssxmc = [], zhmssxmc.push("6"), e = 9, "6" != l && $(this).removeClass("checked")) : $(this).removeClass("checked"))
            }
        }), "1" == l || "2" == l || "11" == l) return $("#zhms .zhmslz").find(".lztype").eq(1).addClass().siblings().removeClass("checked"), zhmssxlz.push(1), e + "1";
        if ("3" == l || "4" == l) return $("#zhms .zhmslz").find(".lztype").eq(0).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2";
        if ("5" == l || "6" == l) return $("#zhms .zhmslz").find(".lztype").eq(2).addClass().siblings().removeClass("checked"), zhmssxlz.push(3), e + "3";
        if ("8" == l || "7" == l) return $("#zhms .zhmslz").find(".lztype").eq(3).addClass().siblings().removeClass("checked"), zhmssxlz.push(4), e + "4";
        if ("9" == l || "10" == l) return $("#zhms .zhmslz").find(".lztype").eq(4).addClass().siblings().removeClass("checked"), zhmssxlz.push(5), e + "5"
    } else if ("10038" == s) {
        if ($($("#zhms").find(".sinli")).each(function (s) {
            if ($(this).hasClass("checked")) {
                var l = $(this).find("i").text();
                l != e && ("11" == e ? (zhmssxmc = [], zhmssxmc.push("6"), e = 6, "6" != l && $(this).removeClass("checked")) : $(this).removeClass("checked"))
            }
        }), "1" == l || "2" == l) return $("#zhms .zhmslz").find(".lztype").eq(0).addClass().siblings().removeClass("checked"), zhmssxlz.push(1), e + "1";
        if ("3" == l || "4" == l) return $("#zhms .zhmslz").find(".lztype").eq(1).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2";
        if ("5" == l || "6" == l) return $("#zhms .zhmslz").find(".lztype").eq(4).addClass().siblings().removeClass("checked"), zhmssxlz.push(5), e + "5";
        if ("7" == l || "8" == l) return $("#zhms .zhmslz").find(".lztype").eq(2).addClass().siblings().removeClass("checked"), zhmssxlz.push(3), e + "3";
        if ("9" == l || "10" == l) return $("#zhms .zhmslz").find(".lztype").eq(3).addClass().siblings().removeClass("checked"), zhmssxlz.push(4), e + "4";
        if ("11" == l) return $("#zhms .zhmslz").find(".lztype").eq(1).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2"
    } else if ("10008" == s || "10006" == s) {
        if ($($("#zhms").find(".sinli")).each(function (s) {
            if ($(this).hasClass("checked")) {
                var l = $(this).find("i").text();
                l != e && ("11" == e ? (zhmssxmc = [], zhmssxmc.push("6"), e = 6, "6" != l && $(this).removeClass("checked")) : $(this).removeClass("checked"))
            }
        }), "1" == l || "2" == l) return $("#zhms .zhmslz").find(".lztype").eq(1).addClass().siblings().removeClass("checked"), zhmssxlz.push(1), e + "1";
        if ("3" == l || "4" == l) return $("#zhms .zhmslz").find(".lztype").eq(0).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2";
        if ("5" == l) return $("#zhms .zhmslz").find(".lztype").eq(0).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2";
        if ("6" == l) return $("#zhms .zhmslz").find(".lztype").eq(2).addClass().siblings().removeClass("checked"), zhmssxlz.push(3), e + "3";
        if ("7" == l || "8" == l) return $("#zhms .zhmslz").find(".lztype").eq(2).addClass().siblings().removeClass("checked"), zhmssxlz.push(3), e + "3";
        if ("9" == l || "10" == l) return $("#zhms .zhmslz").find(".lztype").eq(3).addClass().siblings().removeClass("checked"), zhmssxlz.push(4), e + "4";
        if ("11" == l) return $("#zhms .zhmslz").find(".lztype").eq(1).addClass().siblings().removeClass("checked"), zhmssxlz.push(2), e + "2"
    } else if ("10014" == s) {
        if ($($("#dxms").find(".sinli")).each(function (s) {
            if ($(this).hasClass("selected")) {
                var l = $(this).find("i").text();
                l != e && ("11" == e ? (zhmssxmc = [], zhmssxmc.push("6"), e = 6, "6" != l && $(this).removeClass("selected")) : $(this).removeClass("selected"))
            }
        }), "1" == l || "2" == l) return $("#dxms").find(".sinli").eq(1).addClass("selected").siblings().removeClass("selected"), zhmssxlz.push(1), 11;
        if ("3" == l || "4" == l || "5" == l) return $("#dxms").find(".sinli").eq(0).addClass("selected").siblings().removeClass("selected"), zhmssxlz.push(2), "01";
        if ("6" == l || "7" == l || "8" == l) return $("#dxms").find(".sinli").eq(4).addClass("selected").siblings().removeClass("selected"), zhmssxlz.push(4), 41;
        if ("9" == l || "10" == l || "11" == l) return $("#dxms").find(".sinli").eq(3).addClass("selected").siblings().removeClass("selected"), zhmssxlz.push(3), 31;
        if ("12" == l || "13" == l || "14" == l || "15" == l || "16" == l) return $("#dxms").find(".sinli").eq(2).addClass("selected").siblings().removeClass("selected"), zhmssxlz.push(4), 21;
        if ("17" == l || "18" == l || "19" == l || "20" == l || "21" == l) return $("#dxms").find(".sinli").eq(5).addClass("selected").siblings().removeClass("selected"), zhmssxlz.push(2), 51
    }
};