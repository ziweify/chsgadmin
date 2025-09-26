function checkDateFun(t, e) {
    e = void 0 == e ? "" : e, "kaijianghm" == $("#allSele .checkedbl").attr("id") && method.listData(t)
}

function iframe() {
    var t = $(".animate").width(), e = 780 * t / 1125, a = t / 1125;
    setTimeout(function () {
        $(".animate iframe").contents().find("html").css({
            "transform-origin": "top left",
            transform: "scale(" + a + ")"
        });
        $(".animate iframe").contents().find(".container").height();
        $(".animate").animate({height: e + 50}, 600), $(".animate iframe").animate({height: e + 50}, 600), $(".content").animate({height: e + 25}, 600)
    }, 1), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("#preloader").fadeOut("slow")
    }, 1e3)
}

function startVideo() {
    $("#videoiframe").attr('src',config.videourl+"view/video/pcEgg_video/index.html?"+lotCode);
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        var t = 880 * $(".animate").width() / 1310;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            //iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
        })
    })
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    pubmethod.initAdata(), method.indexLoad(boxId, lotCode), ifishad = !0;
    $("#startVideo").on("touchstart", function () {
        startVideo();//$("iframe")[0].contentWindow.pcEgg.startVid(tools.pcEggDataStr()), startVideo(), $("iframe")[0].contentWindow.ifopen = !0
    }), document.addEventListener("click", function () {
        //$("iframe")[0].contentWindow.ifopen && ($("iframe")[0].contentWindow.pcEgg.sound.play("audioidKai"), $("iframe")[0].contentWindow.pcEgg.sound.play("audioidBg"), $("iframe")[0].contentWindow.pcEgg.sound.stop("audioidKai"))
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-200%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"});
            $("#videoiframe").attr('src',"");
        });
        //$("iframe")[0].contentWindow.pcEgg.sound.stop("audioidBg"), $("iframe")[0].contentWindow.pcEgg.sound.stop("audioidKai"), $("iframe")[0].contentWindow.pcEgg.clearTime(), $("iframe")[0].contentWindow.ifopen = !1
    }), setTimeout(function () {
        config.ifFirstLoad = !0
    }, 4e3)
}), function () {
    tools.initDate();
    var t = "number" == typeof window.orientation && "object" === _typeof(window.onorientationchange);
    window.addEventListener("DOMContentLoaded", function () {
        document.body.parentNode;
        var e, a = function () {
            t && (e = window.orientation, "0px" == $("#videobox").find(".content").css("top") && startVideo())
        };
        t ? window.addEventListener("orientationchange", a, !1) : window.addEventListener("resize", a, !1), a()
    }, !1)
}();
var ifishad = !1, method = {};
method.loadOther = function (t) {
    ("" != t || tools.ifOnDay()) && method.listData(t)
}, method.indexLoad = function (t) {
    var e = $(t).find(".nextIssue").val(), t = "#" + $(t).attr("id");
    headMethod.loadHeadData(e, t), method.loadOther("")
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "LuckTwenty/getPcLucky28List.do?date=" + t,
        type: "GET",
        data: {lotCode: lotCode},
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
    var e = null;
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e)), 0 == e.errorCode && 0 == e.result.businessCode) {
        if (0 == (e = e.result.data).length) return void tools.weikaiji("#numlist");
        $("#numlist").empty(), $("#haomafblist").empty(), $(e).each(function () {
            var t = "";
            t += '<div class="listotherline bortop001 ssclist">', t += '<div class="leftspan">', t += '<span class="boxflex">';
            var e = this.preDrawTime;
            e = e.substring(e.length - 8, e.length - 3), t += '<span class="graytime">' + e + "</span>", t += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", t += "</span>", t += "</div>", t += '<div class="rightspan">', t += '<div class="rightdiv" style="padding-left:0;position:relative">', t += '<div class="haomali eghaomali"><ul class="ssclilist listli egxy_ssclilist">';
            var a = this.preDrawCode.split(",");
            $(a).each(function (e) {
                if ("" != this) {
                    var a = "";
                    0 != e && 1 != e || (a = '<li><span class="addicon" style="width:0.2rem"></span></li>'), t += '<li><span class="bluenum"><i>' + this + "</i></span></li>" + a
                }
            }), t += "</ul></div>", t += '<div class="longhuli displaynone"><ul id="" class="ssclilistxt listli lhlist">';
            if (!(a.length <= 1)) {
                var i = tools.typeOf("sumBigSmall", this.sumBigSmall),
                    s = tools.typeOf("sumSingleDouble", this.sumSingleDouble),
                    d = tools.typeOf("singleDoubleCount", this.singleDoubleCount),
                    l = tools.typeOf("frontBehindCount", this.frontBehindCount),
                    n = tools.typeOf("sumBsSd", this.sumBsSd), o = tools.typeOf("sumWuXing", this.sumWuXing);
                "0" == this.dragonTiger ? "龙" : "1" == this.dragonTiger ? "虎" : "2" == this.dragonTiger && "和"
            }
            t += "<li style='color:#f12d35'>" + this.sumNum + "</li><li style='color:#666'>" + i + "</li><li style='color:#666'>" + s + "</li><li style='color:#666'>" + d + "</li><li style='color:#666'>" + l + "</li><li style='color:#666'>" + n + "</li><li style='color:#666'>" + o + "</li>", t += "</ul>", t += "</div>", t += "</div>", t += "</div>", t += "</div>", $("#numlist").append(t), $("#haomafblist").append(t)
        })
    }
}, method.selectedBS = function (t, e) {
    tools.bigOrSmall(t, e, "41")
}, method.selectedHm = function (t, e) {
    var a = $(t).hasClass("lichecked");
    if ("dansdxbtn" == $(t).parent().parent().attr("class")) {
        $(".numbtn").find("li").removeClass("lichecked"), $(t).hasClass("lichecked") ? $(t).removeClass("lichecked") : $(t).addClass("lichecked");
        var i = $(t).text();
        "单" == i ? $(".dansdxbtn li:nth-child(2)").removeClass("lichecked") : "双" == i ? $(".dansdxbtn li:nth-child(1)").removeClass("lichecked") : "大" == i ? $(".dansdxbtn li:nth-child(4)").removeClass("lichecked") : "小" == i && $(".dansdxbtn li:nth-child(3)").removeClass("lichecked")
    } else $(".dansdxbtn").find("li").removeClass("lichecked"), $(t).hasClass("lichecked") ? $(t).removeClass("lichecked") : $(t).addClass("lichecked").siblings().removeClass("lichecked"), $(".numbtn").find(".lichecked").text() ? ($("#haomafblist li").addClass("selectedOpacity"), $("#haomafblist li").each(function () {
        $(this).text() == $(".numbtn").find(".lichecked").text() && $(this).removeClass("selectedOpacity").siblings()
    })) : $("#haomafblist li").removeClass("selectedOpacity");
    var s = $(".dansdxbtn li:nth-child(1)").hasClass("lichecked"),
        d = $(".dansdxbtn li:nth-child(2)").hasClass("lichecked"),
        l = $(".dansdxbtn li:nth-child(3)").hasClass("lichecked"),
        n = $(".dansdxbtn li:nth-child(4)").hasClass("lichecked");
    $("#haomafblist li").each(function () {
        var t = $(this).text(), e = t % 2 == 0, o = t >= 6;
        "单" == i ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && !e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? o || e ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "双" == i ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? !o && e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "大" == i ? a ? s ? e ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o && !e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? o && e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "小" == i && (a ? s ? e ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o || e ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? !o && e ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
    })
}, method.loadTodayData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data;
        var e = [{data: [data.numZero, data.numOne, data.numTwo, data.numThree, data.numFour, data.numFive, data.numSix, data.numSeven, data.numEight, data.numNine]}, {data: [data.firstSingle, data.firstDouble, data.firstBig, data.firstSmall]}, {data: [data.secondSingle, data.secondDouble, data.secondBig, data.secondSmall]}, {data: [data.thirdSingle, data.thirdDouble, data.thirdBig, data.thirdSmall]}, {data: [data.fourthSingle, data.fourthDouble, data.fourthBig, data.fourthSmall]}, {data: [data.fifthSingle, data.fifthDouble, data.fifthBig, data.fifthSmall]}, {data: [data.sumSingle, data.sumDouble, data.sumBig, data.sumSmall]}];
        $("#liangmianbox").empty(), $(e).each(function (t) {
            var e = "";
            $(this.data).each(function () {
                e += "<td>" + this + "</td>"
            });
            var a = tools.typeOf("liangm", t), i = "";
            0 == t ? i = "head1" : 1 == t && (i = "head2");
            var s = "";
            s = '<div class="lianmlist"><div  class="head ' + i + '">' + a + '</div><table cellpadding="0" cellspacing="0" border="0"><tr class="tr1">' + (t > 0 ? "<td>单</td><td>双</td><td>大</td><td>小</td>" : "<td>0</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td>") + '</tr><tr class="tr2">' + e + "</tr></table></div>", $("#liangmianbox").append(s)
        })
    }
}, method.loadLongData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data, config.ifdebug, $("#longDrag").empty("");
        for (var e = 0, a = data.length; e < a; e++) {
            var i = tools.typeOf("qiuqiu1", data[e].rank), s = tools.typeOf("stated", data[e].state),
                d = data[e].count >= 5 ? "<span style='color:#f11821'>" + data[e].count + "</span>" : "<span>" + data[e].count + "</span>",
                l = "<li><span>" + i + "</span>：<span>" + s + "</span>" + d + "期</li>";
            11 != data[e].rank && 1 != data[e].rank && 2 != data[e].rank || (l = "<li><span>" + i + "</span>：<span>" + s + "</span>" + d + "期</li>"), $("#longDrag").append(l)
        }
    }
};
var fastClickDate = {today_lz: 0, yestoday_lz: -1, qitian_lz: -2};
$(".checkday").on("click", "span", function () {
    var t = $(this), e = "", a = this.classList[0];
    t.addClass("checkspan").siblings().removeClass("checkspan");
    var i = fastClickDate[a];
    t.hasClass("checkclick_date") || t.hasClass("screen") || (e = getDateStr(i, !0), t.siblings(".time_select").text(e), method.listData(e), tools.revertHmfb())
});