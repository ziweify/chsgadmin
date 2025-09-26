function iframe() {
    var i = $(".animate").width(), t = 780 * i / 1125, n = i / 1125;
    setTimeout(function () {
        $(".animate iframe").contents().find("html").css("zoom", n);
        $(".animate iframe").contents().find(".container").height();
        $(".animate").animate({height: t + 50}, 600), $(".animate iframe").animate({height: t + 50}, 600), $(".content").animate({height: t + 25}, 600)
    }, 1), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("#preloader").fadeOut("slow")
    }, 1e3)
}

function startVideo() {
    $("#videoiframe").attr('src',config.videourl+"view/video/fc3DVideo/index.html?"+lotCode);
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        var t = 880 * $(".animate").width() / 1310;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            //iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
        })
    })
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (i) {
    return typeof i
} : function (i) {
    return i && "function" == typeof Symbol && i.constructor === Symbol && i !== Symbol.prototype ? "symbol" : typeof i
};
$(function () {
    pubmethod.initAdata(), method.indexLoad(boxId), ifishad = !0;
    $("#startVideo").on("touchstart", function () {
        startVideo();//$("iframe")[0].contentWindow.fc3d.startVid(tools.fc3dDataStr()), startVideo(), $("iframe")[0].contentWindow.ifopen = !0
    }), document.addEventListener("click", function () {
        //$("iframe")[0].contentWindow.ifopen && ($("iframe")[0].contentWindow.fc3d.sound.play("audioidKai"), $("iframe")[0].contentWindow.fc3d.sound.play("audioidBg"), $("iframe")[0].contentWindow.fc3d.sound.stop("audioidKai"))
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-200%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"});
            $("#videoiframe").attr('src',"");
        });
        //$("iframe")[0].contentWindow.fc3d.sound.stop("audioidBg"), $("iframe")[0].contentWindow.fc3d.sound.stop("audioidKai"), $("iframe")[0].contentWindow.fc3d.clearTime(), $("iframe")[0].contentWindow.ifopen = !1
    })
}), function () {
    var i = "number" == typeof window.orientation && "object" === _typeof(window.onorientationchange);
    window.addEventListener("DOMContentLoaded", function () {
        document.body.parentNode;
        var t, n = function () {
            i && (t = window.orientation, "0px" == $("#videobox").find(".content").css("top") && startVideo())
        };
        i ? window.addEventListener("orientationchange", n, !1) : window.addEventListener("resize", n, !1), n()
    }, !1)
}();
var ifishad = !1, method = {};
method.loadOther = function (i) {
    ("" != i || tools.ifOnDay()) && method.listData(i)
}, method.indexLoad = function (i) {
    $(i).find(".nextIssue").val();
    var i = "#" + $(i).attr("id"),
        t = {url: config.publicUrl + "QuanGuoCai/getLotteryInfo1.do", id: boxId, lotCode: lotCode};
    config.ifdebug, headMethod.loadHeadData(t), method.loadOther("")
}, method.selectedBS = function (i, t) {
    var n = $(i).attr("id");
    $(i).siblings().removeClass("spanchecked"), t || $(i).addClass("spanchecked"), "gjlh" == n ? ($("#numlist .haomali").removeClass("displayblock").addClass("displaynone"), $("#numlist .longhuli").removeClass("displaynone").addClass("displayblock")) : ($("#numlist .haomali").removeClass("displaynone").addClass("displayblock"), $("#numlist .longhuli").removeClass("displayblock").addClass("displaynone"))
}, method.listData = function (i) {
    $.ajax({
        url: config.publicUrl + "QuanGuoCai/getLotteryInfoList.do?date=" + i,
        type: "GET",
        data: {lotCode: lotCode},
        beforeSend: function () {
            ifishad || $("#numlist").html("<span class='loading'>努力加载中...</span>")
        },
        success: function (i) {
            method.createHtmlList(i), animate.loadingList("body", !1)
        },
        error: function (i) {
            config.ifdebug
        }
    })
}, method.createHtmlList = function (i) {
    var t = null;
    "object" != (void 0 === i ? "undefined" : _typeof(i)) ? t = JSON.parse(i) : (t = JSON.stringify(i), t = JSON.parse(t)), 0 == t.errorCode && (0 == t.result.businessCode ? (t = t.result.data, $("#numlist").empty(), $("#haomafblist").empty(), $(t).each(function () {
        var i = "";
        i += '<div class="listotherline bortop001 ssclist">', i += '<div class="leftspan">', i += '<span class="boxflex">';
        var t = this.preDrawTime;
        if (t = t.substring(t.length - 8, t.length - 3), i += '<span class="graytime">' + t + "</span>", i += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", i += "</span>", i += "</div>", i += '<div class="rightspan">', i += '<div class="rightdiv" style="padding-left:0">', "10041" == lotCode) {
            var n = "";
            n = "<span style='color:#f12d35'>" + this.sjh + "</span>", i += '<div class="haomali"><div class="leftdivsjh" style="display:none;">' + n + '</div><div  class="leftdivsjh"><ul id="" class="ssclilist listli">';
            o = this.preDrawCode.split(",");
            $(o).each(function (t) {
                i += '<li><span class="rednum"><i>' + this + "</i></span></li>"
            }), i += "</ul></div></div>"
        } else {
            i += '<div class="haomali"><ul id="" class="ssclilist listli">';
            var o = this.preDrawCode.split(",");
            $(o).each(function (t) {
                i += '<li><span class="rednum"><i>' + this + "</i></span></li>"
            }), i += "</ul></div>"
        }
        i += '<div class="longhuli displaynone"><ul id="" class="ssclilistxt listli lhlist">';
        if (!(o.length <= 1)) {
            var e = "0" == this.sumBigSmall ? "大" : "小", a = "0" == this.sumSingleDouble ? "单" : "双";
            "0" == this.dragonTiger ? "龙" : "1" == this.dragonTiger ? "虎" : "2" == this.dragonTiger && "和"
        }
        "10041" == lotCode && (i += "<li  style='color:#f12d35'></li>"), i += "<li  style='color:#f12d35'>" + this.sumNum + "</li>", i += "<li style='color:#666'>" + e + "</li>", i += "<li style='color:#666'>" + a + "</li>", i += "</ul>", i += "</div>", i += "</div>", i += "</div>", i += "</div>", $("#numlist").append(i), $("#haomafblist").append(i)
    })) : $("#numlist").find(".loading").text(t.result.message))
};