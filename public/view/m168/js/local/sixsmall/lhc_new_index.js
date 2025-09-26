function checkDateFun(t, i) {
    i = void 0 == i ? "" : i, "kaijianghm" == $("#allSele .checkedbl").attr("id") && method.listData(t)
}

function iframe() {
    var t = $(".animate").width(), i = 780 * t / 1125, n = t / 1125;
    setTimeout(function () {
        $(".animate iframe").contents().find("html").css("zoom", n);
        $(".animate iframe").contents().find(".container").height();
        $(".animate").animate({height: i + 50}, 600), $(".animate iframe").animate({height: i + 50}, 600), $(".content").animate({height: i + 25}, 600)
    }, 1), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("#preloader").fadeOut("slow")
    }, 1e3)
}

function startVideo() {
    $("#videobox").animate({"z-index": "19999"}, 10, function () {
        var t = 780 * $(".animate").width() / 1125;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            iframe()
        })
    })
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    pubmethod.initAdata(), method.indexLoad(boxId), ifishad = !0;
    $("#startVideo").on("touchstart", function () {
        $("iframe")[0].contentWindow.ssq.startVid(tools.fcssqDataStr()), startVideo(), $("iframe")[0].contentWindow.ifopen = !0
    }), document.addEventListener("click", function () {
        $("iframe")[0] && $("iframe")[0].contentWindow.ifopen && ($("iframe")[0].contentWindow.ssq.sound.play("audioidKai"), $("iframe")[0].contentWindow.ssq.sound.play("audioidBg"), $("iframe")[0].contentWindow.ssq.sound.stop("audioidKai"))
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-200%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"})
        }), $("iframe")[0].contentWindow.ssq.sound.stop("audioidBg"), $("iframe")[0].contentWindow.ssq.sound.stop("audioidKai"), $("iframe")[0].contentWindow.ssq.clearTime(), $("iframe")[0].contentWindow.ifopen = !1
    })
}), function () {
    var t = "number" == typeof window.orientation && "object" === _typeof(window.onorientationchange);
    window.addEventListener("DOMContentLoaded", function () {
        document.body.parentNode;
        var i, n = function () {
            t && (i = window.orientation, "0px" == $("#videobox").find(".content").css("top") && startVideo())
        };
        t ? window.addEventListener("orientationchange", n, !1) : window.addEventListener("resize", n, !1), n()
    }, !1)
}();
var ifishad = !1, method = {};
method.loadOther = function (t) {
    ("" != t || tools.ifOnDay()) && method.listData(t)
}, method.indexLoad = function (t) {
    var isss = $(t).find(".nextIssue").val();
    var t = "#" + $(t).attr("id"),
        i = {url: config.publicUrl + "smallSix/findSmallSixInfo.do?issue="+isss, id: boxId, lotCode: lotCode};
    config.ifdebug, headMethod.loadHeadData(i);
    //method.loadOther("")
}, method.selectedBS = function (t, i) {
    var n = $(t).attr("id");
    $(t).siblings().removeClass("spanchecked"), i || $(t).addClass("spanchecked"), "gjlh" == n ? ($("#numlist .haomali").removeClass("displayblock").addClass("displaynone"), $("#numlist .longhuli").removeClass("displaynone").addClass("displayblock")) : ($("#numlist .haomali").removeClass("displaynone").addClass("displayblock"), $("#numlist .longhuli").removeClass("displayblock").addClass("displaynone"))
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "taiWanCai/getHistoryLotteryInfo.do",
        type: "GET",
        data: {lotCode: lotCode, date: t},
        beforeSend: function () {
            ifishad || $("#numlist").html("<span class='loading'>努力加载中...</span>")
        },
        success: function (t) {
            method.createHtmlList(t), animate.loadingList("body", !1)
        },
        error: function (t) {
            config.ifdebug
        }
    })
}, method.createHtmlList = function (t) {
    var i = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? i = JSON.parse(t) : (i = JSON.stringify(t), i = JSON.parse(i)), 0 == i.errorCode && (0 == i.result.businessCode ? (i = i.result.data, $("#numlist").empty(), $("#haomafblist").empty(), $(i).each(function () {
        var t = "";
        t += '<div class="listotherline bortop001 ssclist">', t += '<div class="leftspan">', t += '<span class="boxflex">';
        var i = this.preDrawTime;
        i = i.substring(i.length - 8, i.length - 3), t += '<span class="graytime">' + i + "</span>", t += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", t += "</span>", t += "</div>", t += '<div class="rightspan">', t += '<div class="rightdiv" style="padding-left:0">', t += '<div class="haomali"><ul id="" class="ssclilist listli">';
        var n = this.preDrawCode.split(",");
        $(n).each(function (i) {
            if ("" != this) {
                var e = "10070" == lotCode ? "tw_orange" : "10071" == lotCode ? "tw_green" : "tw_yellow",
                    o = "10070" == lotCode ? "tw_red" : "10071" == lotCode ? "tw_red" : "tw_yellow";
                i == n.length - 1 ? t += '<li><span class="' + o + '"><i>' + this + "</i></span></li>" : t += '<li><span class="' + e + '"><i>' + this + "</i></span></li>"
            }
        }), t += "</ul></div>", t += '<div class="longhuli displaynone"><ul id="" class="ssclilistxt listli lhlist">';
        if (!(n.length <= 1)) {
            this.sumBigSmall;
            var e = "1" == this.sumSingleDouble ? "单" : "双";
            "0" == this.dragonTiger ? "龙" : "1" == this.dragonTiger ? "虎" : "2" == this.dragonTiger && "和"
        }
        t += "<li  style='color:#f12d35'>" + this.sumNum + "</li>", t += "<li style='color:#666'>" + e + "</li>", t += "</ul>", t += "</div>", t += "</div>", t += "</div>", t += "</div>", $("#numlist").append(t), $("#haomafblist").append(t)
    })) : $("#numlist").find(".loading").text(i.result.message))
};