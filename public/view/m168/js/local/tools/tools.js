function getDateStr(e, t) {
    if (void 0 == e) return "";
    var i = new Date;
    i.setDate(i.getDate() + e);
    var a = i.getFullYear(), n = i.getMonth() + 1, s = i.getDate(), o = a + "-" + n + "-" + s;
    return t && (o = a + "-" + (n < 10 ? "0" + n : n) + "-" + (s < 10 ? "0" + s : s)), o
}

function topPromoteApp() {
    $(document).on("scroll", function () {
        var e = $("#appPromoteBanner");
        $(this).scrollTop() >= e.outerHeight() / 3 ? e.addClass("app-promote-sticky-banner") : e.removeClass("app-promote-sticky-banner")
    })
}

function bodyHtmlvis() {
}

function bodyHtmlhide() {
}

function handleOrientationChange(e) {
    window.location.reload()
}

function excutenum() {
    return Math.floor(10 * Math.random())
}

function stopLottery(e, t, i) {
    var a = e.preDrawCode.split(",");
    animate[i](a, t), clearInterval(animateID[t]), delete animateID[t];
    $(t).find(".opentyle").html("<span class='label-warning'>停止销售</span>"), $(t).find(".cuttime_ZJTJ").length > 0 ? $(t).find(".cuttime_ZJTJ").hide() : $(t).find(".opentyle").addClass("status-wrapper"), $(t).find(".opentyle").show(), $(t).find(".cuttime").hide(), $(t).find(".drawCount").hide()
}

function releaseQuizMessage() {
    if (0 == $("#headerData").find(".qishu .timeBox .minute").length) return !1;
    var e = $("#headerData").find(".qishu .timeBox .minute").text(),
        t = $("#headerData").find(".qishu .timeBox .second").text(),
        i = $("#headerData").find(".qishu .qiliat .caiNametop").text(), a = 60 * e + 1 * t - 2, n = "", s = "";
    localStorage.getItem("userId");
    10001 == lotCode ? s += "北京pk10" : 10058 == lotCode ? s += "SG飞艇" : 10057 == lotCode ? s += "幸运飞艇" : 10037 == lotCode ? s += "极速赛车" : 10012 == lotCode ? s += "澳洲幸运10" : 10035 == lotCode && (s += "极速飞艇"), a--;
    Math.floor(a / 60);
    0 == $(".divline").is(":hidden") ? (n += "<p>" + s + "</p><span id='status' style='color:red'>正在开奖...</span>", $("#submit").css("cursor", "no-drop"), "my_quiz" == $(".genre .genreclick").attr("data-text") && RealTimeRefresh()) : n += "<p>" + s + "</p><span>" + i + "</span>期竞猜发布", $("#QuizPop-up .deadline").html(n)
}

function RealTimeRefresh() {
    setTimeout(function () {
        "Name" == window.location.search.split("?")[1] && (listpook = !0, guessing.my_guessing.getMyGuessing(), guessing.my_guessingTrail.getMyTrail("", 1, setMyPage))
    }, 5e3)
}

function ACertainPeriod() {
    var e = window.location.search.split("?")[1];
    VerifyThe && "Name" == e && guessing.Verify.getVerify()
}

function loadoverpage() {
    var e = localStorage.getItem("overpage");
    if (null == e || 0 == $(".checkedbl").length || "" == e) return !1;
    0 != $("#allSele #" + e).length ? $("#allSele #" + e).click() : localStorage.setItem("overpage", "");
    var t = 1 * $(".checkedbl").offset().left;
    $(".headTitle_view").scrollLeft(Math.abs(t))
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    }, animate = {}, tools = {}, intervalSsc = null, animateID = {}, pubmethod = {}, publicHeadOrf = {},
    title = $("title").text(), strTitle = title.split("-")[0], lotRule = $("body").data("rule"), QuizzesList = !1,
    initTimeSelect;
$(function () {
    $(window).on("pageshow", function (e) {
        e.originalEvent.persisted && window.location.reload()
    }), topPromoteApp();
    var e = new Date;
    setInterval(function () {
        Math.abs(new Date - e) > 1e4 && (config.ifdebug || window.location.reload()), e = new Date
    }, 1e3), setTimeout(function () {
        config.ifFirstLoad = !0
    }, 3e3)
}), window.onload = function () {
    loadoverpage()
}, "168kjw" != window.name ? (location.reload(), window.name = "168kjw") : window.name = "";
var mql = window.matchMedia("(orientation: portrait)");
$(document).scrollTop(0), mql.addListener(handleOrientationChange);
var indexObj = {};
indexObj.YM = function () {
    var e = window.location.href, t = e = e.split("//")[1].split("/")[0].split(".");
    "www" == t[0] ? "m" == (e = t[1]) && (e = t[2]) : "www" != t[0] && "m" == (e = t[0]) && (e = t[1]);
    var i = window.location.hostname.split("."), a = i[i.length - 1];
    return  e + "." + a
}, $("#headdivbox").load("../public/head.html?v=1.0.0", function () {
    var e = new Date;
    $("#yearmothnday").val(e.getFullYear()), $("#showtime").text((e.getMonth() + 1 < 10 ? "0" + (e.getMonth() + 1) : e.getMonth() + 1) + "月" + e.getDate() + "日"), $("#headdivbox #caizhong_name").find("span").html(strTitle), void 0 !== lotRule ? $("#lotRule").attr("href", "../wanfaguize/" + lotRule + ".html") : $("#lotRule svg").hide(), -1 != window.location.pathname.indexOf("/aboutUs") && $("#headdivbox #caizhong_name").attr("id", "").find("i").remove()
}), $("#nonLotteryHeadDivBox").load("../public/non-lottery-head.html?v=1.0.0"), $("#footerDiv").load("../public/footer.html?v=1.0.2", function () {
    "" != window.location.search && ($("#aboutMess #nonLotteryHeadDivBox #titlespan").text(strTitle), $("#aboutMess #nonLotteryHeadDivBox").find(".top_menu_more").css("display", "none")), pupajax()
}), $(".bodybox #back a").on("click", function (e) {
    return window.history.back(), !1
}), $("body").on("click", "#lotMainBack a", function (e) {
    e.preventDefault(), 1 == sessionStorage.getItem("czBackToHomepage") ? (sessionStorage.removeItem("czBackToHomepage"), window.location.href = "/html/public/home.html") : window.location.href = "../lot_menu/lot_menu.html"
}), $("body").on("click", ".go_back", function (e) {
    e.preventDefault(), sessionStorage.setItem("backToHomePage", 1), window.location.href = "../../index.html"
});
var ofsetop = 0 != $(".title_fix_top").length ? $(".title_fix_top").offset().top : null;
"kaijianghm haomafb".indexOf($("#allSele .checkedbl").attr("id")), $(".title_se_box").on("click", "span", function () {
    $(this).addClass("se_check").siblings().removeClass("se_check"), $("#" + $(this).attr("target")).show().siblings().hide()
}), animate.loadingList = function (e, t) {
    t ? ($(e).find("#loadingbox").remove(), $(e).find("div").eq(0).before('<div id="loadingbox">Loading...</div>'), $("#loadingbox").stop().animate({height: "0.2rem"}, 500)) : setTimeout(function () {
        $("#loadingbox").stop().animate({height: "0"}, 500)
    }, 500)
}, animate.pk10OpenAnimate = function (e) {
    $(e).find(".cuttime").hide(), $(e).find(".cuttime_ZJTJ").hide(), $(e).find(".opentyle").show(), clearInterval(animateID[e]);
    var t = setInterval(function () {
        var t = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], i = t.length;
        t.sort(function (e, t) {
            return Math.random() > .5 ? -1 : 1
        });
        for (var a = "", n = 0; n < i; n++) {
            var s = t[n] < i ? "nub0" + t[n] : "nub" + t[n];
            a += n == i - 1 ? "<li style='margin-right: 0px;' class='li_after " + s + "'></li>" : "<li class='" + s + "'></li>"
        }
        $(e).find(".numberbox").empty().append(a)
    }, 100);
    animateID[e] = t
}, animate.pk10AnimateEnd = function (e, t) {
    var i = e.length, a = 0, n = $(t).find(".numberbox"),
        s = -1 != window.location.pathname.indexOf("/html/public/home.html");
    $(n).empty();
    var o = setInterval(function () {
        var t = "";
        if (a < i) {
            a == i - 1 && (t = "li_after");
            var s = "<li class='nub" + e[a] + " " + t + "'><i style='font-size:10px; display:none'>" + e[a] + "</i></li>";
            $(n).find("li").length < 10 && $(n).append(s), a += 1
        } else clearInterval(o)
    }, 100);
    animateID.pk10AnimateEnd = o, $(t).find(".opentyle").hide(), $(t).find(".cuttime").show()
}, animate.sscAnimate = function (e) {
    var t = 600;
    $(e).find(".opentyle").show(), $(e).find(".cuttime_ZJTJ").hide(), $(e).find(".cuttime").hide();
    var i = $(e).find("#pk10num"), a = $(e).find(".sscli li");
    if (!a.length) {
        $(i).empty().append("<li>03</li><li>01</li><li>05</li><li>06</li><li>04</li>");
        var n = "sscli";
        10060 == lotCode && (n += " ssc_lhsx"), $("#pk10num").addClass(n), a = $(e).find(".sscli li")
    }
    var s = a.length;
    intervalSsc = 10060 != lotCode ? setInterval(function () {
        $(e).find(".sscli li:last-child").css({"margin-right": "0"}), t--;
        for (var i = 0; i < s; i++) {
            $(e).find("li").eq(i).css({lineHeight: "0"}), $(e).find("li").eq(i).text(excutenum());
            excutenum();
            $(e).find("li").eq(i).stop().animate({lineHeight: "0.25rem"}, 100)
        }
    }, 100) : setInterval(function () {
        var e = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], a = [];
        t--;
        for (var n = 0; n < 5; n++) {
            var s = Math.floor(Math.random() * e.length);
            a[n] = e[s], e.splice(s, 1)
        }
        for (var o = "", l = 0; l < 5; l++) o += "<li class='hlnum" + a[l] + "'>" + a[l] + "</li>";
        $(i).empty(), $(i).append(o), 100 == t && $("#waringbox").show(300)
    }, 100), animateID[e] = intervalSsc, config.ifdebug
}, animate.sscAnimateEnd = function (e, t) {
    for (var i = 0, a = e.length + 1; i < a; i++) {
        i < e.length && $(t).find("#pk10num").find("li:last-child").css({"margin-right": "0"}), $(t).find(".numberbox li").eq(i).css({paddingTop: "0px"}), 10060 == lotCode || "#cz_10060" == t ? $(t).find("li").eq(i).removeClass().addClass("hlnum" + e[i]).text(e[i]) : $(t).find("li").eq(i).text(e[i]);
        var n = 50 * excutenum();
        $(t).find(".numberbox .sscli li").eq(i).stop().animate({lineHeight: "0.25rem"}, n)
    }
    $(t).find(".opentyle").hide(), $(t).find(".cuttime").show()
}, animate.lhcAnimateEnd = function (e, uu) {
    var n = $(uu);
    var a = n.find("#sixLotteryContent"), l = n.find(".numbox"), t = n.find("#openingLottery"),
        o = n.find(".sh_xzlist>li>span:first-child"), r = n.find(".sh_xzlist>li>span:last-child"),
        d = n.find("#pk10num>li:not(.addpic)"), c = n.find("#zongfen"), u = {};
    u.ThisCode = e.preDrawCode.split(","), c.text(""), o.text(""), r.text(""), d.text(""), d.removeClass(), u.ThisCode.length >= 6 ? (n.find(".addpic").show(), n.find(".zongfen").show()) : (n.find(".addpic").hide(), n.find(".zongfen").hide()), u.ThisCode[0] <= "" ? (t.show(), l.hide(), a.hide()) : (l.show(), a.show(), t.hide()), c.text(e.sumTotal);
    for (var p = 0; p < u.ThisCode.length; p++) {
        if (void 0 == u.ThisCode[p] || void 0 == proto.fiveLineArr[e.fiveElements[p]]) return !1;
        if (void 0 == e.fiveElements[p]) return !1;
        o[p].innerHTML = proto.Zoo[e.chineseZodiac[p]], r[p].innerHTML = proto.fiveLineArr[e.fiveElements[p]], d[p].className = proto.colorEng[e.color[p]], d[p].innerHTML = u.ThisCode[p] > 9 ? u.ThisCode[p] : "0" + u.ThisCode[p]
    }
    n.find(".opentyle").hide(), n.find(".cuttime").show()
}, animate.kuai3Animate = function (e) {
    var t = 600;
    $(e).find(".opentyle").show(), $(e).find(".cuttime").hide(), intervalSsc = setInterval(function () {
        t--;
        for (var i = 0, a = $(e).find(".numberbox li").length; i < a; i++) {
            var n = tools.excutenum1_6();
            $(e).find(".numberbox li").eq(i).className = "num" + 1 * n + 1;
            var s = 1 * n, o = tools.kuaicase(1 * tools.excutenum1_6() + 1);
            $(e).find(".numberbox li").eq(i).stop().animate({backgroundPositionY: o}, s)
        }
    }, 100), animateID[e] = intervalSsc
}, animate.kuai3AnimateEnd = function (e, t) {
    for (var i = 0, a = e.length; i < a; i++) {
        $(t).find(".numberbox li").eq(i).css({paddingTop: "0px"}), $(t).find(".numberbox li")[i].className = "num" + e[i], $($(t).find(".numberbox li")[i]).css({"background-position-y": ""});
        var n = 50 * excutenum();
        $(t).find(".numberbox li").eq(i).stop().animate({lineHeight: "36px"}, n)
    }
    $(t).find(".opentyle").hide(), $(t).find(".cuttime").show()
}, animate.cqncAnimate = function (e) {
    var t = 600, i = $(e).find(".numberbox");
    $(".opening").show(), $(".clock").hide(), intervalSsc = setInterval(function () {
        var e = ["01", "02", "03", "04", "05", "06", "07", "08"], a = [];
        t--;
        for (var n = 0; n < 10; n++) {
            var s = Math.floor(Math.random() * e.length);
            a[n] = e[s], e.splice(s, 1)
        }
        for (var o = "", l = 0; l < 10; l++) o += "<li class='ncnum0" + a[l] + "'></li>";
        $(i).empty(), $(i).append(o), 100 == t && $("#waringbox").show(300)
    }, 100), animateID[e] = intervalSsc
}, animate.cqncAnimateEnd = function (e, t) {
    var t = t, i = e.length, a = 0, n = $(t).find(".numberbox");
    $(n).html("");
    var s = setInterval(function () {
        if (a < i) {
            var t = "<li class='ncnum" + e[a] + "'><i style='font-size:10px;display:none'>" + e[a] + "</i></li>";
            $(n).append(t), a++
        } else clearInterval(s)
    }, 100);
    $(t).find(".opentyle").hide(), $(t).find(".cuttime").show()
}, tools.excutenum1_6 = function () {
    return Math.floor(6 * Math.random())
}, tools.kuaicase = function (e) {
    switch (e) {
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
};
var timer = "";
tools.cutTime = function (e, t, i) {
    clearInterval(timer);
    var a = e.replace("-", "/"), t = t.replace("-", "/");
    a = a.replace("-", "/"), t = t.replace("-", "/");
    var n = $(i).find(".hour"), s = $(i).find(".minute"), o = $(i).find(".second"), l = $(i).find(".opentyle"),
        r = $(i).find(".cuttime"), d = new Date(a), c = (d - new Date(t)) / 1e3, u = (d - new Date(t)) / 1e3;
    timer = setInterval(function () {
        var e = c / u;
        if (e < 1 && NaN != e) {
            var t = (e + "").split(".")[1].substr(0, 2);
            t = t.length < 2 ? t + "0" : t, $(i).find(".redpro ").css({width: t + "%"})
        }
        if (c > 1) {
            c -= 1;
            var a = Math.floor(c / 3600), d = Math.floor(c / 60 % 60), f = Math.floor(c % 60);
            $(n).text(a < 10 ? "0" + a : a), $(s).text(d < 10 ? "0" + d : d), $(o).text(f < 10 ? "0" + f : f), a <= 0 ? $(".hourid").hide() : $(".hourid").show()
        } else $(l).show(), $(r).hide(), clearInterval(timer), method.indexLoad(i);
        try {
            releaseQuizMessage()
        } catch (e) {
        }
    }, 1e3)
}, tools.typeOf = function (e, t) {
    if ("sumBigSmall" == e) switch (1 * t) {
        case-1:
            return "小";
        case 0:
            return "和";
        case 1:
            return "大"
    } else if ("sumSingleDouble" == e) switch (1 * t) {
        case-1:
            return "双";
        case 0:
            return "和";
        case 1:
            return "单"
    } else if ("singleDoubleCount" == e) switch (1 * t) {
        case-1:
            return "双多";
        case 0:
            return "单双和";
        case 1:
            return "单多"
    } else if ("frontBehindCount" == e) switch (1 * t) {
        case-1:
            return "后多";
        case 0:
            return "和";
        case 1:
            return "前多"
    } else if ("sumBsSd" == e) switch (1 * t) {
        case 1:
            return "大单";
        case 2:
            return "大双";
        case 3:
            return "小单";
        case 4:
            return "小双";
        case 5:
            return "和"
    } else if ("sumWuXing" == e) switch (1 * t) {
        case 1:
            return "金";
        case 2:
            return "木";
        case 3:
            return "水";
        case 4:
            return "火";
        case 5:
            return "土"
    } else if ("state" == e) switch (1 * t) {
        case 1:
            return "单双";
        case 2:
            return "大小";
        case 3:
            return "龙虎"
    } else if ("san" == e) switch (1 * t) {
        case 0:
            return "杂六";
        case 1:
            return "半顺";
        case 2:
            return "顺子";
        case 3:
            return "对子";
        case 4:
            return "豹子"
    } else if ("lhh" == e) switch (1 * t) {
        case 0:
            return "龙";
        case 1:
            return "虎";
        case 2:
            return "和"
    } else if ("qiu" == e) switch (1 * t) {
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 6:
            return "总和";
        case 12:
            return "龙虎"
    } else if ("qiuklsf" == e) switch (1 * t) {
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 6:
            return "第六球";
        case 7:
            return "第七球";
        case 8:
            return "第八球";
        case 9:
            return "总和"
    } else if ("qiusyxw" == e) switch (1 * t) {
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 6:
            return "和值";
        case 7:
            return "尾数"
    } else if ("gxqiuklsf" == e) switch (1 * t) {
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 6:
            return "总和"
    } else if ("qiuonebig" == e) switch (1 * t) {
        case 1:
            return "第一名";
        case 2:
            return "第二名";
        case 3:
            return "第三名";
        case 4:
            return "第四名";
        case 5:
            return "第五名";
        case 11:
            return "总和";
        case 12:
            return "龙虎"
    } else if ("lai" == e) switch (1 * t) {
        case 1:
            return "总来";
        case 0:
            return "没来"
    } else if ("qiuqiu" == e) switch (1 * t) {
        case 1:
            return "一";
        case 2:
            return "二";
        case 3:
            return "三";
        case 4:
            return "四";
        case 5:
            return "五";
        case 11:
            return "总和"
    } else if ("qiuqiu1" == e) switch (1 * t) {
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 11:
            return "总和"
    } else if ("liangm" == e) switch (1 * t) {
        case 0:
            return "号码出现次数";
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 6:
            return "总和"
    } else if ("statedsyxw" == e) switch (1 * t) {
        case 1:
            return "单";
        case 2:
            return "双";
        case 3:
            return "大";
        case 4:
            return "小";
        case 5:
            return "和";
        case 6:
            return "龙";
        case 7:
            return "虎"
    } else if ("stated" == e) switch (1 * t) {
        case 1:
            return "单";
        case 2:
            return "双";
        case 3:
            return "大";
        case 4:
            return "小";
        case 5:
            return "龙";
        case 6:
            return "虎";
        case 7:
            return "尾大";
        case 8:
            return "尾小";
        case 9:
            return "合单";
        case 10:
            return "合双";
        case 11:
            return "总和"
    } else if ("dxh" == e) switch (1 * t) {
        case 0:
            return "大";
        case 1:
            return "小";
        case 2:
            return "和"
    } else if ("seafood" == e) switch (1 * t) {
        case 1:
            return "鱼";
        case 2:
            return "虾";
        case 3:
            return "葫芦";
        case 4:
            return "金钱";
        case 5:
            return "蟹";
        case 6:
            return "鸡"
    } else if ("dxtc" == e) switch (1 * t) {
        case 0:
            return "大";
        case 1:
            return "小";
        case 2:
            return "通吃"
    } else if ("zhdx" == e) switch (1 * t) {
        case 0:
            return "大";
        case 1:
            return "小";
        case 2:
            return "和"
    } else if ("dsh" == e) switch (1 * t) {
        case 0:
            return "单";
        case 1:
            return "双";
        case 2:
            return "和"
    } else if ("rank" == e) switch (1 * t) {
        case 1:
            return "冠军";
        case 2:
            return "亚军";
        case 3:
            return "第三名";
        case 4:
            return "第四名";
        case 5:
            return "第五名";
        case 6:
            return "第六名";
        case 7:
            return "第七名";
        case 8:
            return "第八名";
        case 9:
            return "第九名";
        case 10:
            return "第十名";
        case 11:
            return "冠亚和"
    }
}, tools.checkDay = function (e) {
    $("#top_menu").find(".checked").removeClass("checked");
    var t = $("#top_menu").find(".btn");
    $(t).each(function () {
        e == $(this).text() && $(this).addClass("checked")
    })
}, tools.classGetDate_ssc = function (e, t, i) {
    t = void 0 == t || "" == t ? "" : t, i = void 0 == i || "" == i ? config.periods : i, "kaijianghm" == e || "haomafb" == e ? method.listData(t) : "dsdxls" == e ? sscFunObj.dsdxls.listData() : "dsdxlz" == e ? sscFunObj.dsdxlz.dsdxlzsData(t) : "lishihmtj" == e ? sscFunObj.lshmtj.listData() : "longhuzs" == e ? sscFunObj.lhzs.listData(t, "") : "luzufx" == e ? sscFunObj.lzfx.getlist(t) : "guyahelz" == e ? sscFunObj.gyhlz.getlist(t) : "todayhaomatj" == e ? sscFunObj.jrhmtj.getdata(t) : "singtaizs" == e ? sscFunObj.singtaizs.getlist(t, "") : "hmqhlz" == e ? sscFunObj.hmlz.listData(t) : "lenrefx" == e ? sscFunObj.lrfx.listData(t) : "haomazs" != e && "wezizs" != e || sscFunObj.wzzs.getlist(t, "")
}, tools.classGetDate_pk10 = function (e, t, i) {
    t = void 0 == t || "" == t ? "" : t, i = void 0 == i || "" == i ? config.periods : i, "kaijianghm" == e || "haomafb" == e ? method.listData(t) : "haomazs" == e || "wezizs" == e ? pk10FunObj.wzzs.getlist(t, "") : "luzufx" == e ? pk10FunObj.lzfx.getlist(t) : "hmqhlz" == e ? pk10FunObj.hmqhlz.hmqhlzData(t) : "lenrefx" == e ? pk10FunObj.lerefx.getdata() : "guyahelz" == e ? pk10FunObj.gyhlz.getlist(t) : "guyahezs" == e ? pk10FunObj.gyhzs.listData(t, "") : "dsdxls" == e ? pk10FunObj.dsdxlsObj.dsdxlsData() : "longhutj" == e ? pk10FunObj.longhutjObj.longhutjData() : "longhulz" == e ? pk10FunObj.lhlz.lhlzsData(t) : "haomagltj" == e ? pk10FunObj.hmgltj.gltjData(i, t) : "todayhaomatj" == e ? pk10FunObj.jrhmtj.getdata(t) : "gyhlmlishi" == e ? pk10FunObj.gyhlmlsObj.gyhlmlsData() : "dsdxlz" == e && pk10FunObj.dsdxlz.dsdxlzsData(t)
}, tools.classGetDate_syxw = function (e, t, i) {
    t = void 0 == t || "" == t ? "" : t, i = void 0 == i || "" == i ? config.periods : i, "kaijianghm" == e || "haomafb" == e ? method.listData(t) : "wezizs" == e ? syxwFunObj.jbzs.getlist(t, "") : "luzufx" == e ? syxwFunObj.lzfx.getlist(t) : "singtaizs" == e ? syxwFunObj.dwzs.getlist(t, "") : "dsdxls" == e ? syxwFunObj.dsdxls.listData() : "dsdxlz" == e ? syxwFunObj.dsdxlz.listData(t) : "todayhaomatj" == e ? syxwFunObj.jrhmtj.listData(t) : "zonghelz" == e ? syxwFunObj.zhlz.listData(t) : "longhuzs" == e ? syxwFunObj.lhzs.listData(t, "") : "hezhizs" == e && syxwFunObj.hzzs.listData(t, "")
}, tools.classGetDate_kuai = function (e, t, i) {
    config.xyncHeadHeight = 0, t = void 0 == t || "" == t ? "" : t, i = void 0 == i || "" == i ? config.periods : i, "kaijianghm" == e || "haomafb" == e ? method.listData(t) : "haomalz" == e ? kuai3FunObj.dewdrop.getdata(t) : "locationzs" == e ? kuai3FunObj.wzzs.getlist(t, "") : "sizezs" == e ? (config.xyncHeadHeight = 70, kuai3FunObj.market.getmarket(t, "")) : "lishihm" == e ? kuai3FunObj.lishi.getlishi() : "hezhizspl" == e ? kuai3FunObj.hezhizspl.gethezhi(t, "") : "jibenzs" == e ? kuai3FunObj.jibenzs.getjiben(t, "") : "zonghelz" == e ? kuai3FunObj.zonghe.getzong(t) : "qiyuzs" == e && kuai3FunObj.qiyuzs.getqiyu(t, "")
}, tools.classGetDate_shifen = function (e, t, i) {
    if (config.xyncHeadHeight = 0, t = void 0 == t || "" == t ? "" : t, i = void 0 == i || "" == i ? config.periods : i, "kaijianghm" == e || "haomafb" == e) method.listData(t); else if ("liangmtj" == e) shifenFunObj.limtj.getlimtj(t, 20, 10); else if ("meiricltj" == e) {
        var a = $("#meiri_tj .meiriLiAct").find("i").text();
        shifenFunObj.meiritj.getmeiritj(a, 1)
    } else "luzhufx" == e ? shifenFunObj.lzfx.getlist(t) : "zonghelzfen" == e ? shifenFunObj.zonghe.getzonghe(t) : "zongfabailz" == e ? shifenFunObj.zhongfa.getzhongfa(t) : "haomalzfen" == e ? shifenFunObj.haomalz.gethaomalz(t) : "danshuangdaxiaols" == e ? shifenFunObj.danshuan.getdsdxls(t) : "jibenzsfen" == e ? (config.xyncHeadHeight = 70, shifenFunObj.jibendata.getjibenzs(t, "")) : "heshudanshuanglz" == e ? shifenFunObj.heshudslz.getheshudslz(t) : "weishudaxiaolz" == e ? shifenFunObj.weishudxlz.getweishudxlz(t) : "longhulzfen" == e ? shifenFunObj.longhulz.getlonghulz(t) : "danshuangdaxiaolz" == e ? shifenFunObj.dansdxlz.getdansdxlz(t) : "jinrihaomatj" == e ? shifenFunObj.jrhmtj.getjrhmtj(t) : "dongxinanbei" == e ? shifenFunObj.dongnxb.getdongnxb(t) : "daxiaozsfen" == e ? shifenFunObj.dxzs.getdata(t, "") : "danshuangzsfen" == e ? shifenFunObj.dszs.getdszs(t, "") : "lishihaomatj" == e && shifenFunObj.lishmtj.getlishmtj(t)
}, tools.classGetDate_gxklsf = function (e, t, i) {
    if (t = void 0 == t || "" == t ? "" : t, i = void 0 == i || "" == i ? config.periods : i, "kaijianghm" == e || "haomafb" == e) method.listData(t); else if ("gx_luzhufx" == e) guangxiFunObj.gxlzfx.getlist(t, ""); else if ("gx_meiricltj" == e) {
        var a = $("#meiri_tj ul li.meiriLiAct i").text();
        guangxiFunObj.gxmeiritj.getgxmeiritj(a, 1)
    } else "gx_haomalzfen" == e ? guangxiFunObj.gxhaomalz.getgxhaomalz(t, "") : "gx_liangmtj" == e ? guangxiFunObj.gxlimtj.getlimtj(t, 20, 10) : "gx_danshuan" == e && guangxiFunObj.gxdanshuan.getdsdxls(t, "")
}, tools.initDate = function () {
    0 != $("#time_select").length && (initTimeSelect = new TimeSelect({
        trigger: "#time_select",
        minDate: new Date("2010/05/10"),
        checkDate: new Date,
        callback: function (e, t) {
            t = t[0].id + "-" + t[1].id + "-" + t[2].id;
            try {
                checkDateFun(t), tools.revertHmfb()
            } catch (e) {
            }
        }
    }))
}, tools.revertHmfb = function () {
    $(".numbtn ul li").removeClass("lichecked"), $(".dansdxbtn ul li").removeClass("lichecked")
}, pubmethod.initAdata = function (e) {
    var t = new Date;
    $("#yearmothnday").val(t.getFullYear()), $("#showtime").text((t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1) + "月" + t.getDate() + "日"), e && tools.initDate(), $(".headTitle").on("click", "div,button", function (e) {
        $(".cheDate .checkday .today_lz").addClass("checkspan").siblings().removeClass("checkspan"), tools.revertHmfb(), $("canvas").remove(), $(".tabBox").removeClass("hasheight"), hisEl = $(this).attr("id"), localStorage.setItem("overpage", hisEl), $(".headTitle .checkedbl").removeClass("checkedbl"), $(this).addClass("checkedbl"), $(".drawCodebox").css({
            left: "7rem",
            display: "none"
        }), $("." + hisEl).css({display: "block"}), $("." + hisEl).stop().animate({left: "0rem"}, "100"), "haomazs" == hisEl ? ($(".haomazs .Pattern").hide(), $(".haomazsbgcls").show(), $(".Pattern .hamafb").addClass("checkspan").siblings().removeClass("checkspan"), $(".weizilodiv").show()) : ($(".haomazs .Pattern").show(), $(".haomazsbgcls").hide());
        var t = hisEl, i = {kaijianghm: "#numlist", haomafb: "#haomafblist"};
        i = i[hisEl];
        try {
            if (scrollRender && i) {
                scrollRender.parentClass = i;
                var a = $(i + " div:first").attr("class");
                a && (a = " ." + a.split(" ")[0] + ":last-child", scrollRender.watchDom = $(i + a)[0])
            }
        } catch (e) {
        }
        $(".time_select").attr("id", ""), $("." + t).find(".time_select").attr("id", "time_select"), $("#F_time_select").parents(".mobileSelect").remove(), tools.initDate();
        var n = window.location.pathname, s = $(".headTitle .checkdbl").attr("id"), o = "#" + s + "_sm";
        if (-1 != n.indexOf("pk10") || -1 != n.indexOf("aozxy10") || -1 != n.indexOf("xyft") || -1 != n.indexOf("xingyft") || -1 != n.indexOf("jisusaiche") || -1 != n.indexOf("sgAirship") || -1 != n.indexOf("ukLotto10")) tools.classGetDate_pk10(t, "", ""), "haomagltj" == s || "longhutj" == s || "gyhlmlishi" == s || "hmqhlz" == s || "longhulz" == s || "lenrefx" == s || "wezizs" == s || "guyahelz" == s ? ($("#explainBtn_wfsm").show(), $(o).addClass("displayblock").siblings("div").addClass("displaynone"), $(o).siblings("div").removeClass("displayblock")) : ($("#explainBtn_wfsm").hide(), $(o).addClass("displaynone").siblings("div").addClass("displaynone")); else if (-1 != n.indexOf("ssc_") || -1 != n.indexOf("aozxy5") || -1 != n.indexOf("shishicai_xy") || -1 != n.indexOf("shishicai_sg") || -1 != n.indexOf("happyCZ") || -1 != n.indexOf("tw_5fencai") || -1 != n.indexOf("ukLotto5")) tools.classGetDate_ssc(t, "", ""), "longhuzs" == s || "wezizs" == s || "lenrefx" == s || "singtaizs" == s ? ($("#explainBtn_wfsm").show(), $(o).addClass("displayblock").siblings("div").addClass("displaynone"), $(o).siblings("div").removeClass("displayblock")) : ($("#explainBtn_wfsm").hide(), $(o).addClass("displaynone").siblings("div").addClass("displaynone")); else if (-1 != n.indexOf("11_") || -1 != n.indexOf("sg11x5")) tools.classGetDate_syxw(t, "", ""), "dsdxlz" == s || "singtaizs" == s || "hezhizs" == s || "wezizs" == s || "longhuzs" == s || "luzufx" == s || "zonghelz" == s ? ($("#explainBtn_wfsm").show(), $(o).addClass("displayblock").siblings("div").addClass("displaynone"), $(o).siblings("div").removeClass("displayblock")) : ($("#explainBtn_wfsm").hide(), $(o).addClass("displaynone").siblings("div").addClass("displaynone")); else if (-1 != n.indexOf("k3_")) {
            tools.classGetDate_kuai(t, "", "");
            var l = "#" + s + "_pm";
            "haomalz" == s || "locationzs" == s || "sizezs" == s || "hezhizspl" == s || "jibenzs" == s || "qiyuzs" == s || "zonghelz" == s ? ($("#explainBtn_plok").show(), $(l).removeClass("displaynone").addClass("displayblock").siblings("div").addClass("displaynone"), $(l).siblings("div").removeClass("displayblock")) : ($("#explainBtn_plok").hide(), $(l).addClass("displaynone").siblings("div").addClass("displaynone"))
        } else if (-1 != n.indexOf("gxklsf")) {
            tools.classGetDate_gxklsf(t, "", "");
            var r = "#" + s + "_sf";
            "gx_luzhufx" == s || "gx_meiricltj" == s || "gx_haomalzfen" == s || "gx_liangmtj" == s || "gx_danshuan" == s ? ($("#kuailsfBtn_plok").show(), $(r).removeClass("displaynone").addClass("displayblock").siblings("div").addClass("displaynone"), $(r).siblings("div").removeClass("displayblock")) : ($("#kuailsfBtn_plok").hide(), $(r).addClass("displaynone").siblings("div").addClass("displaynone"))
        } else if (-1 != n.indexOf("klsf") || -1 != n.indexOf("aozxy8") || -1 != n.indexOf("xync") || -1 != n.indexOf("ukLotto8") || -1 != n.indexOf("sgHappy10")) {
            tools.classGetDate_shifen(t, "", "");
            var d = "#" + s + "_sf";
            "zongfabailz" == s || "zonghelzfen" == s || "haomalzfen" == s || "daxiaozsfen" == s || "danshuangzsfen" == s || "dongxinanbei" == s || "jibenzsfen" == s || "weishudaxiaolz" == s ? ($("#kuailsfBtn_plok").show(), $(d).removeClass("displaynone").addClass("displayblock").siblings("div").addClass("displaynone"), $(d).siblings("div").removeClass("displayblock")) : ($("#kuailsfBtn_plok").hide(), $(d).addClass("displaynone").siblings("div").addClass("displaynone"))
        }
        oddscrollleft = ""
    }), $(".rightdiv").on("touchstart", "span", function () {
        method.selectedBS($(this), !1)
    }), $(".numbtn").on("touchstart", "li", function () {
        method.selectedHm($(this), !1)
    }), $(".dansdxbtn").on("touchstart", "li", function () {
        method.selectedHm($(this), !1)
    }), $(".lhdzlDiv").on("touchstart", "span", function () {
        method.selectedLHD($(this), !1)
    }), $("#top_menu").on("touchstart", ".btn", function () {
        $(this).addClass("checked").siblings().removeClass("checked");
        var e = $("#yearmothnday").val(), t = $("#showtime").text();
        t = t.split("月");
        var i = $(this).find("span").text();
        $("#showtime").text(t[0] + "月" + i + "日"), animate.loadingList("body", !0), method.loadOther(e + "-" + t[0] + "-" + i)
    })
}, tools.bigOrSmall = function (e, t, i, a) {
    var n = $(e).attr("id");
    $(e).siblings().removeClass("spanchecked"), t || $(e).addClass("spanchecked"), "gjlh" == n ? ($("#numlist .haomali").removeClass("displayblock").addClass("displaynone"), $("#numlist .longhuli").removeClass("displaynone").addClass("displayblock")) : ($("#numlist .haomali").removeClass("displaynone").addClass("displayblock"), $("#numlist .longhuli").removeClass("displayblock").addClass("displaynone")), $("#numlist .haomali li").each(function (e) {
        var t = $(this).text(), a = (t *= 1) % 2 == 0, s = t >= i;
        if ("xshm" == n) {
            if (tools.hadCode(lotCode, "klsf")) $(this).text() >= 19 ? ($(this).find("span").removeClass(), $(this).find("span").addClass("rednum")) : ($(this).find("span").removeClass(), $(this).find("span").addClass("bluenum")); else if (tools.hadCode(lotCode, "bjkl8")) $(this).text() > 40 ? ($(this).find("span").removeClass(), "10047" == lotCode ? 20 == e || (e - 20) % 21 == 0 ? $(this).find("span").addClass("Orange") : $(this).find("span").addClass("bluenum") : ("10073" == lotCode || "10054" == lotCode || lotCode, $(this).find("span").addClass("bluenum"))) : ($(this).find("span").removeClass(), "10073" == lotCode || "10054" == lotCode || "10082" == lotCode ? $(this).find("span").addClass("lightblue") : 20 == e || (e - 20) % 21 == 0 ? $(this).find("span").addClass("Orange") : $(this).find("span").addClass("lightblue")); else if (tools.hadCode(lotCode, "gxklsf")) $(this).find("span").removeClass(), 1 == t || 4 == t || 7 == t || 10 == t || 13 == t || 16 == t || 19 == t ? $(this).find("span").addClass("rednum") : 3 == t || 6 == t || 9 == t || 12 == t || 15 == t || 18 == t || 21 == t ? $(this).find("span").addClass("greennum") : $(this).find("span").addClass("bluenum"); else if (10060 != lotCode) $(this).find("span").removeClass(), $(this).find("span").addClass("bluenum"); else {
                var o = "hlnum" + $(this).find("i").text();
                $(this).find("span").removeClass(), $(this).find("span").addClass(o)
            }
            10060 != lotCode && $(this).find("i").show()
        } else "xsdx" == n ? ($(this).find("i").hide(), $(this).find("span").removeClass(), s ? tools.hadCode(lotCode, "shiyi5") ? 11 == t ? $(this).find("span").addClass("blueCount") : $(this).find("span").addClass("bluebig") : tools.hadCode(lotCode, "bjkl8") ? t > 40 ? $(this).find("span").addClass("bluebig") : $(this).find("span").addClass("bluesm") : tools.hadCode(lotCode, "gxklsf") && 21 == t ? $(this).find("span").addClass("blueCount") : $(this).find("span").addClass("bluebig") : $(this).find("span").addClass("bluesm")) : "xsds" == n && ($(this).find("i").hide(), $(this).find("span").removeClass(), a ? $(this).find("span").addClass("blueeve") : tools.hadCode(lotCode, "shiyi5") ? 11 == t ? $(this).find("span").addClass("blueCount") : $(this).find("span").addClass("bluesig") : tools.hadCode(lotCode, "gxklsf") && 21 == t ? $(this).find("span").addClass("blueCount") : $(this).find("span").addClass("bluesig"))
    })
}, tools.repeatAjaxt = {
    kuai3: function (e) {
        clearInterval(animateID[e]), setTimeout(function () {
            headMethod.loadHeadData($(e).find(".nextIssue").val(), e)
        }, 1e3)
    }
}, tools.replaceUnde = function (e) {
    $(e).each(function (e) {
        "undefined" == $(this).text() && $(this).text("")
    })
}, tools.geturlData = function (e) {
    alert(window.location.href)
}, tools.hadCode = function (e, t) {
    var i = ["10001", "10057", "10058", "10037", "10035", "10012", "10079","20031"],
        a = ["10002", "10050", "10003", "10004", "10036", "10010", "10059", "10075", "10060", "10064", "10077", "10056", "20032"],
        n = ["20034","10005", "10053", "10034", "10011", "10078", "10083"], s = ["10038"],
        o = ["20036","10054", "10014", "10073", "10013", "10047", "10082", "10080"], l = ["10009"],
        r = ["10070", "10071", "10072"],
        d = ["20035","10007", "10052", "10076", "10026", "10027", "10028", "10029", "10030", "10031", "10032", "10033", "10061", "10062", "10063"],
        c = ["20033","10006", "10008", "10055", "10015", "10016", "10017", "10018", "10019", "10020", "10021", "10022", "10023", "10024", "10025", "10084"],
        u = ["10046", "10074", "10081"], f = ["10048"], h = ["10051"], m = ["10039", "10042", "10040", "10045"],
        p = ["10041", "10043", "10044"], g = ["10013", "10014", "10047", "10054", "10073", "10080", "10082"], x = !1;
    return "pk10" == t ? $(i).each(function (t) {
        e == this && (x = !0)
    }) : "ssc" == t ? $(a).each(function (t) {
        e == this && (x = !0)
    }) : "klsf" == t ? $(n).each(function (t) {
        e == this && (x = !0)
    }) : "bjkl8" == t ? $(g).each(function (t) {
        e == this && (x = !0)
    }) : "gxklsf" == t ? $(s).each(function (t) {
        e == this && (x = !0)
    }) : "cqnc" == t ? $(l).each(function (t) {
        e == this && (x = !0)
    }) : "kuai3" == t ? $(d).each(function (t) {
        e == this && (x = !0)
    }) : "shiyi5" == t ? $(c).each(function (t) {
        e == this && (x = !0)
    }) : "jisukl8" == t ? $(o).each(function () {
        e == this && (x = !0)
    }) : "twc_new" == t ? $(r).each(function () {
        e == this && (x = !0)
    }) : "egxy" == t ? $(u).each(function () {
        e == this && (x = !0)
    }) : "smallSix" == t ? $(f).each(function () {
        e == this && (x = !0)
    }) : "speedSix" == t ? $(h).each(function () {
        e == this && (x = !0)
    }) : "qgc" == t ? $(m).each(function () {
        e == this && (x = !0)
    }) : "qgc1" == t && $(p).each(function () {
        e == this && (x = !0)
    }), x
}, tools.parseObj = function (e) {
    var t = null;
    return "object" != (void 0 === e ? "undefined" : _typeof(e)) ? t = JSON.parse(e) : (t = JSON.stringify(e), t = JSON.parse(t)), t
}, tools.ifOnDay = function () {
    var e = !1;
    return $("#top_menu").find(".checked").find("span").text() == $("#top_menu").find(".onday").find("span").text() && (e = !0), e
}, tools.subStr = function (e) {
    return (e = e + "").length < 7 ? e : e.substr(1 * e.length - 6, 1 * e.length - 1)
};
var cZ = {
    toRMC: [{id: lotCode.jisusaiche, name: "极速赛车", href: "/html/jisusaiche/index.html?code="+lotCode.jisusaiche}, {
        id: lotCode.xglhc,
        name: "香港六合彩",
        href: "/html/sixsmall/index.html"
    }, {
        id: lotCode.amlhc,
        name: "澳门六合彩",
        href: "/html/sixaomen/index.html"
    }, {id: lotCode.sgssc, name: "SG时时彩", href: "/html/ssc_jisu/index.html?code="+lotCode.sgssc}, {
        id: lotCode.sgksan,
        name: "SG快3",
        href: "/html/k3_jisu/index.html?code="+lotCode.sgksan
    }, {id: lotCode.sgAirship, name: "SG飞艇", href: "/html/jisusaiche/index.html?code="+lotCode.sgAirship}, {
        id: lotCode.xyssc,
        name: "幸运时时彩",
        href: "/html/ssc_jisu/index.html?code="+lotCode.xyssc
    }, {id: lotCode.xingyft, name: "幸运飞艇", href: "/html/jisusaiche/index.html?code="+lotCode.xingyft}, {
        id: lotCode.xyft,
        name: "极速飞艇",
        href: "/html/jisusaiche/index.html?code="+lotCode.xyft
    }, {id: lotCode.jisussc, name: "极速时时彩", href: "/html/ssc_jisu/index.html?code="+lotCode.jisussc}, {
        id: lotCode.egxy28,
        name: "pc蛋蛋幸运28",
        href: "../Egxy28/index.html"
    }, {id: lotCode.tw_5fencai, name: "台湾5分彩", href: "/html/ssc_jisu/index.html?code="+lotCode.tw_5fencai}],
    toJSC: [{id: 10051, name: "极速六合彩", href: "/html/sixjisu/index.html"}, {
        id: lotCode.jisusaiche,
        name: "极速赛车",
        href: "/html/jisusaiche/index.html?code="+lotCode.jisusaiche
    }, {id: lotCode.xyft, name: "极速飞艇", href: "/html/jisusaiche/index.html?code="+lotCode.xyft}, {
        id: lotCode.jisussc,
        name: "极速时时彩",
        href: "/html/ssc_jisu/index.html?code="+lotCode.jisussc
    }, {id: lotCode.jisuksan, name: "极速快3", href: "/html/k3_jisu/index.html?code="+lotCode.jisuksan}, {
        id: lotCode.jisuklsf,
        name: "极速快乐十分",
        href: "/html/klsf_jisu/index.html?code="+lotCode.jisuklsf
    }, {id: lotCode.jisukl8, name: "极速快乐8", href: "/html/jisukl8/index.html?code="+lotCode.jisukl8}, {
        id: lotCode.jisuef,
        name: "极速11选5",
        href: "/html/11_jisuef/index.html?code="+lotCode.jisuef
    }],
    toSGC: [{id: lotCode.sgAirship, name: "SG飞艇", href: "/html/jisusaiche/index.html?code="+lotCode.sgAirship}, {
        id: lotCode.sgHappy8,
        name: "SG快乐8",
        href: "/html/aozxy20/index.html?code="+lotCode.sgHappy8
    }, {id: lotCode.sgHappy10, name: "SG快乐十分", href: "/html/klsf_jisu/index.html?code="+lotCode.sgHappy10}, {
        id: lotCode.sgssc,
        name: "SG时时彩",
        href: "/html/ssc_jisu/index.html?code="+lotCode.sgssc
    }, {id: lotCode.sgksan, name: "SG快3", href: "/html/k3_jisu/index.html?code="+lotCode.sgksan}, {
        id: lotCode.sg11x5,
        name: "SG11选5",
        href: "/html/11_jisuef/index.html?code="+lotCode.sg11x5
    }],
    toGPC: [{id: lotCode.cqxync, name: "重庆幸运农场", href: "../xync/index.html", enable: !1}, {
        id: lotCode.sdsyydj,
        name: "十一运夺金",
        href: "../11_syydj/index.html",
        enable: !1
    }, {id: lotCode.gdklsf, name: "广东快乐十分", href: "../gdklsf/index.html", enable: !1}, {
        id: lotCode.tjklsf,
        name: "天津快乐十分",
        href: "../tianjinklsf/index.html",
        enable: !1
    }, {id: lotCode.gdsyxw, name: "广东11选5", href: "../11_gdsyxw/index.html", enable: !1}, {
        id: lotCode.shef,
        name: "上海11选5",
        href: "../11_shef/index.html",
        enable: !1
    }, {id: lotCode.ahef, name: "安徽11选5", href: "../11_ahef/index.html", enable: !1}, {
        id: lotCode.jxef,
        name: "江西11选5",
        href: "../11_jxef/index.html",
        enable: !1
    }, {id: lotCode.jlef, name: "吉林11选5", href: "../11_jlef/index.html", enable: !1}, {
        id: lotCode.gxef,
        name: "广西11选5",
        href: "../11_gxef/index.html",
        enable: !1
    }, {id: lotCode.hbef, name: "湖北11选5", href: "../11_hbef/index.html", enable: !1}, {
        id: lotCode.lnef,
        name: "辽宁11选5",
        href: "../11_lnef/index.html",
        enable: !1
    }, {id: lotCode.jsef, name: "江苏11选5", href: "../11_jsef/index.html", enable: !1}, {
        id: lotCode.zjef,
        name: "浙江11选5",
        href: "../11_zjef/index.html",
        enable: !1
    }, {id: lotCode.nmgef, name: "内蒙古11选5", href: "../11_nmgef/index.html", enable: !1}, {
        id: lotCode.jisuksan,
        name: "江苏快3",
        href: "../k3_jsks/index.html",
        enable: !1
    }, {id: lotCode.hebft, name: "河北快3", href: "../k3_hebft/index.html", enable: !1}, {
        id: lotCode.ahft,
        name: "安徽快3",
        href: "../k3_ahft/index.html",
        enable: !1
    }, {id: lotCode.nmgft, name: "内蒙古快3", href: "../k3_nmgft/index.html", enable: !1}, {
        id: lotCode.hubft,
        name: "湖北快3",
        href: "../k3_hubft/index.html",
        enable: !1
    }, {id: lotCode.bjft, name: "北京快3", href: "../k3_bjft/index.html", enable: !1}, {
        id: lotCode.gxft,
        name: "广西快3",
        href: "../k3_gxft/index.html",
        enable: !1
    }, {id: lotCode.shft, name: "上海快3", href: "../k3_shks/index.html", enable: !1}, {
        id: lotCode.gzft,
        name: "贵州快3",
        href: "../k3_gzks/index.html",
        enable: !1
    }, {id: lotCode.gsft, name: "甘肃快3", href: "../k3_gsks/index.html", enable: !1}, {
        id: lotCode.jlft,
        name: "吉林快3",
        href: "../k3_jlft/index.html",
        enable: !1
    }],
    toJWC: [{id: lotCode.aozxy5, name: "澳洲幸运5", href: "/html/ssc_jisu/index.html?code="+lotCode.aozxy5}, {
        id: lotCode.aozxy8,
        name: "澳洲幸运8",
        href: "/html/klsf_jisu/index.html?code="+lotCode.aozxy8
    }, {id: lotCode.aozxy10, name: "澳洲幸运10", href: "/html/jisusaiche/index.html?code="+lotCode.aozxy10}, {
        id: lotCode.aozxy20,
        name: "澳洲幸运20",
        href: "/html/aozxy20/index.html?code="+lotCode.aozxy20
    }, {id: lotCode.tw_dlt, name: "台湾大乐透", href: "../tw_dlt/index.html"}, {
        id: lotCode.twbg,
        name: "台湾宾果",
        href: "/html/taiwanbg/index.html"
    }, {id: lotCode.tw_wlc, name: "台湾威力彩", href: "../tw_wlc/index.html"}, {
        id: lotCode.tw_jc539,
        name: "台湾今彩539",
        href: "../tw_jc539/index.html"
    }],
    toQGC: [{
        id: lotCode.fcssq,
        name: "福彩双色球",
        href: "../fcssq/index.html"
    }, {
        id: lotCode.cjdlt,
        name: "超级大乐透",
        href: "../cjdlt/index.html"
    }, {
        id: lotCode.fcsd,
        name: "福彩3D",
        href: "../fc3D/index.html"
    }, {
        id: lotCode.fcqlc,
        name: "福彩七乐彩",
        href: "../fc7lc/index.html"
    }, {
        id: lotCode.pailie3,
        name: "体彩排列3",
        href: "../tcpl3/index.html"
    }, {
        id: lotCode.pailie5,
        name: "体彩排列5",
        href: "../tcpl5/index.html"
    }, {
        id: lotCode.qxc,
        name: "体彩七星彩",
        href: "../tc7xc/index.html"
    }]
};
tools.openAllCz = function (e) {
    $("#navList").css({
        top: "-1.2rem",
        opacity: "0.1"
    }), $(".whiteTip").css("transform", "rotate(0deg)"), e ? ($("html,body").css("height", "100%"), $("#headdivbox").css({display: "none"}), $("#cZList").css({display: "block"}), $(".bodybox").css({height: "100%"}), $(".pagediv").css({
        height: "0",
        overflow: "hidden",
        minHeight: "0"
    }), $("#cZList").stop().animate({height: "100%"}, 500)) : ($("html,body").css("height", "initial"), $("#headdivbox").css({display: "block"}), $("#cZList").stop().animate({height: "0"}, 200, null, function () {
        $(".bodybox").css({height: "auto"}), $(".pagediv").css({height: "auto", overflowY: "scroll", minHeight: "0"})
    }))
}, tools.getLotInfoApiUrl = function (e) {
    return tools.hadCode(e, "pk10") ? lotInfoApi.pk10 : tools.hadCode(e, "ssc") ? lotInfoApi.ssc : tools.hadCode(e, "klsf") ? lotInfoApi.klsf : tools.hadCode(e, "gxklsf") ? lotInfoApi.gxklsf : tools.hadCode(e, "jisukl8") ? lotInfoApi.jisukl8 : tools.hadCode(e, "cqnc") ? lotInfoApi.cqnc : tools.hadCode(e, "twc_new") ? lotInfoApi.twc_new : tools.hadCode(e, "kuai3") ? lotInfoApi.kuai3 : tools.hadCode(e, "shiyi5") ? lotInfoApi.shiyi5 : tools.hadCode(e, "egxy") ? lotInfoApi.egxy : tools.hadCode(e, "smallSix") ? lotInfoApi.smallSix : tools.hadCode(e, "speedSix") ? lotInfoApi.speedSix : tools.hadCode(e, "qgc") ? lotInfoApi.qgc : tools.hadCode(e, "qgc1") ? lotInfoApi.qgc1 : void 0
}, tools.getNewCountdown = function (e, t, i, a, n, s) {
    var n = void 0 == n ? "" : n, o = tools.getLotInfoApiUrl(i), l = !1;
    $.ajax({
        url: config.publicUrl + o,
        type: "GET",
        async: "false",
        data: {lotCode: i, issue: n},
        timeout: 6e4,
        success: function (e) {
            var t = tools.parseObj(e);
            t = t.result.data, tools.countDown(t.drawTime, t.serverTime, i, a, t.drawIssue, s)
        },
        error: function (e) {
            l = !0
        },
        complete: function (o, r) {
            l || "timeout" == r && setTimeout(function () {
                tools.getNewCountdown(e, t, i, a, n, s)
            }, 1e3)
        }
    })
}, tools.getLotListByCategory = function () {
    $.ajax({
        url: config.publicUrl + "lottery/getLotteryListByCategory.do",
        type: "GET",
        data: {isUse: 1, category: 99},
        success: function (e) {
            tools.loadCZ(tools.parseObj(e).result.data)
        },
        error: function (e) {
        }
    })
}, tools.countDown = function (e, t, i, a, n, s) {
    var o = e.replace("-", "/"), t = t.replace("-", "/");
    o = o.replace("-", "/"), t = t.replace("-", "/");
    var l = "." + s, r = $(l).find(".cuttime"), d = (new Date(o).getTime() - new Date(t).getTime()) / 1e3;
    $(r).empty(), parseInt(d / 3600 / 24) <= 0 ? $(r).html('<span class="hour">00</span><span class="hourtxt colon">:</span><span class="minute">00</span><span class="colon">:</span><span class="second">00</span>') : $(r).html('<span class="bgtime day">00</span><span class="daytxt colon">天</span><span class="bgtime hour">00</span><span class="hourtxt colon">时</span><span class="bgtime minute">00</span><span class="minutetxt colon">分</span><span class="bgtime second">00</span><span class="secondtxt colon">秒</span>');
    var c = $(l).find(".day"), u = $(l).find(".hour"), f = $(l).find(".hourtxt"), h = $(l).find(".minute"),
        m = $(l).find(".second"), p = $(l).find(".opentyle"), g = "";
    clearInterval(g), g = setInterval(function () {
        if (d > 1) {
            d -= 1;
            var o = parseInt(d / 3600 / 24), x = Math.floor(d / 3600 - 24 * o), w = Math.floor(d / 60 % 60),
                b = Math.floor(d % 60);
            $(p).hide(), $(r).show(), $(c).text(o < 10 ? "0" + o : o), $(u).text(x < 10 ? "0" + x : x), $(h).text(w < 10 ? "0" + w : w), $(m).text(b < 10 ? "0" + b : b), o <= 0 ? ($(l).find(".second").show(), $(l).find(".secondtxt").show(), $(l).find(".daytxt").hide(), $(l).find(".day").hide()) : ($(l).find(".daytxt").show(), $(l).find(".day").show(), $(l).find(".second").hide(), $(l).find(".secondtxt").hide()), x <= 0 ? (u.hide(), f.hide()) : (u.show(), f.show())
        } else $(p).show(), $(r).hide(), clearInterval(g), tools.getNewCountdown(e, t, i, a, n, s)
    }, 1e3)
}, tools.loadCZ = function (e) {
    var t = "", i = "", a = "", n = "", s = "", o = "",
        l = "<img class='stop-icon' src='../../img/icon/icon_stop_0621.png'>", r = [],
        d = '<div class="countdown-wrap"><span class="opentyle" style="display: none">开奖中...</span><span><span class="cuttime"></span></span></div>';
    $(cZ.toRMC).each(function () {
        var e = "", i = "rmc" + this.id;
        e = 0 == this.enable ? l : d, r.push({
            lotCode: this.id,
            lotClassName: i
        }), t += '<li class="' + i + '"><a href="' + this.href + '"><span class="lot-name">' + this.name + "</span>" + e + "</a></li>"
    }), $(cZ.toJSC).each(function () {
        var e = "", t = "jsc" + this.id;
        e = 0 == this.enable ? l : d, r.push({
            lotCode: this.id,
            lotClassName: t
        }), i += '<li class="' + t + '"><a href="' + this.href + '"><span class="lot-name">' + this.name + "</span>" + e + "</a></li>"
    }), $(cZ.toSGC).each(function () {
        var e = "", t = "sgc" + this.id;
        e = 0 == this.enable ? l : d, r.push({
            lotCode: this.id,
            lotClassName: t
        }), a += '<li class="' + t + '"><a href="' + this.href + '"><span class="lot-name">' + this.name + "</span>" + e + "</a></li>"
    }), $([]).each(function () {//cZ.toGPC
        var e = "", t = "gpc" + this.id;
        e = 0 == this.enable ? l : d, r.push({
            lotCode: this.id,
            lotClassName: t
        }), n += '<li class="' + t + '"><a href="' + this.href + '"><span class="lot-name">' + this.name + "</span>" + e + "</a></li>"
    }), $(cZ.toJWC).each(function () {
        var e = "", t = "jwc" + this.id;
        e = 0 == this.enable ? l : d, r.push({
            lotCode: this.id,
            lotClassName: t
        }), s += '<li class="' + t + '"><a href="' + this.href + '"><span class="lot-name">' + this.name + "</span>" + e + "</a></li>"
    }), $(cZ.toQGC).each(function () {
        var e = "", t = "qgc" + this.id;
        e = 0 == this.enable ? l : d, r.push({
            lotCode: this.id,
            lotClassName: t
        }), o += '<li class="' + t + '"><a href="' + this.href + '"><span class="lot-name">' + this.name + "</span>" + e + "</a></li>"
    });
    var c = '<div id="cZList" class="fixed-menu-padding-bottom"><div class="backbtn"><span><a href="../../index.html"></a></span><span>彩种</span><span>&nbsp;</span></div><div class="toRMC" id="toRMC"><div class="title"><span>热门彩</span></div><div class="content"><ul>' + t + '</ul></div></div><div class="toRMC" id="toJSC"><div class="title"><span>极速彩</span></div><div class="content"><ul>' + i + '</ul></div></div><div class="toRMC" id="toSGC"><div class="title"><span>SG彩</span></div><div class="content"><ul>' + a + '</ul></div></div><div style="display:none;" class="toRMC" id="toGPC"><div class="title"><span>高频彩</span></div><div class="content"><ul>' + n + '</ul></div></div><div class="toRMC" id="toJWC"><div class="title"><span>境外彩</span></div><div class="content"><ul>' + s + '</ul></div></div><div class="toRMC" id="toQGC"><div class="title"><span>全国彩</span></div><div class="content"><ul>' + o + "</ul></div></div></div>";
    $("body.caizong").append(c), r.forEach(function (t) {
        var i = e.filter(function (e) {
            return e.lotCode === t.lotCode
        })[0];
        0 === i.lotteryStatus && tools.countDown(i.drawTime, i.serverTime, i.lotCode, i.category, i.drawIssue, t.lotClassName)
    }), $("a[href^='https://m.6hch.cc']").on("click", function (e) {
        e.preventDefault(), tools.redirect6hco()
    })
}, tools.redirect6hco = function () {
    var e = !1;
    "true" === (e = sessionStorage.getItem("isDomainNoAdv")) ? window.open("https://nd6hch003.com", "_blank") : "false" === e ? window.open("https://6hch1.com", "_blank") : $.ajax({
        type: "get",
        url: config.publicUrl + "parameters/getNoAdvertisingDomain.do",
        async: !0,
        data: {platform: "168"},
        success: function (e) {
            "string" == typeof e && (e = JSON.parse(e));
            var t = e.result.data.domainList, i = window.location.hostname.split(":")[0].replace("m.", "");
            void 0 == t || "" == t || -1 != t.indexOf(i) ? (sessionStorage.setItem("isDomainNoAdv", !0), window.location.href = "https://nd6hch003.com") : (sessionStorage.setItem("isDomainNoAdv", !1), window.location.href = "https://6hch1.com")
        },
        error: function () {
        }
    })
}, tools.noChinesFont = function (e) {
    return !/[\u4E00-\u9FA5]/.test(e)
}, tools.repeatAjax = function (e, t) {
    setTimeout(function () {
        headMethod.loadHeadData(e, t)
    }, "1000")
}, tools.repeatAjaxOBj = function (e) {
    setTimeout(function () {
        headMethod.loadHeadData(e)
    }, "1000")
}, pubmethod.creatHead = {
    pk10: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 != i.errorCode || 0 != i.result.businessCode) throw new Error("error");
        if (1 !== (i = i.result.data).lotteryStatus) {
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            setTimeout(function () {
                var e = $(".headTitle .checkedbl").attr("id");
                config.ifFirstLoad ? config.ifFirstLoad = !config.ifFirstLoad : tools.timeSelectCompareToday() && tools.classGetDate_pk10(e, "", "")
            }, 6e3), $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount);
            $(t).find(".nextIssue").val();
            for (var a = "", n = 0, s = $(".longhu").find("li").length; n < s; n++) switch (n) {
                case 0:
                    a += "<li>" + ("0" == i.firstDT ? "龙" : "虎") + "</li>";
                    break;
                case 1:
                    a += "<li>" + ("0" == i.secondDT ? "龙" : "虎") + "</li>";
                    break;
                case 2:
                    a += "<li>" + ("0" == i.thirdDT ? "龙" : "虎") + "</li>";
                    break;
                case 3:
                    a += "<li>" + ("0" == i.fourthDT ? "龙" : "虎") + "</li>";
                    break;
                case 4:
                    a += "<li class='li_after'>" + ("0" == i.fifthDT ? "龙" : "虎") + "</li>";
                    break;
                case 5:
                    a += "<li class='verline li_after'>|</li><li class='guanyahe li_after'>冠亚和：</li><li guanyaheli li_after>" + i.sumFS + "</li>";
                    break;
                case 6:
                    a += "<li guanyaheli li_after>" + ("0" == i.sumBigSamll ? "大" : "小") + "</li>";
                    break;
                case 7:
                    a += "<li guanyaheli li_after style='margin-right:0'>" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(a), $(t).find(".cuttime_ZJTJ").show(), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), config.ifdebug, tools.cutTime(i.drawTime, i.serverTime, t);
            var o = i.preDrawCode.split(",");
            animate.pk10AnimateEnd(o, t),setTimeout(function () {
                $("#IsSMTJPage").length > 0 ? method.loadOther("") : (tools.ifToday() || QuizzesList) && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        } else stopLottery(i, t, "pk10AnimateEnd")
    }, ssc: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "sscAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            setTimeout(function () {
                var e = $(".headTitle .checkedbl").attr("id");
                config.ifFirstLoad ? config.ifFirstLoad = !config.ifFirstLoad : tools.classGetDate_ssc(e, "", "")
            }, 6e3), $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount);
            $(t).find(".nextIssue").val();
            $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue);
            var a = $(".longhu").find("li"), n = "", s = i.dragonTiger;
            s = "0" == s ? "龙" : "1" == s ? "虎" : "2" == s ? "和" : "";
            for (var o = 0, l = a.length; o < l; o++) switch (o) {
                case 0:
                    n += "<li class='li_after'>" + s + "</li>";
                    break;
                case 1:
                    n += "<li class='verline li_after'>|</li><li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 2:
                    n += "<li  class='guanyaheli li_after' >" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>";
                    break;
                case 3:
                    n += "<li  class='guanyaheli li_after'>" + ("0" == i.sumBigSmall ? "大" : "小") + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(n), $(t).find(".cuttime_ZJTJ").show(), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), tools.cutTime(i.drawTime, i.serverTime, t);
            var r = i.preDrawCode.split(",");
            animate.sscAnimateEnd(r, t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, bjkl8: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "pk10AnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount);
            $(t).find(".nextIssue").val();
            $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), void 0 !== $("#drawTime").val() && ($(t).find("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $(t).find("#preDrawIssue").val(i.preDrawIssue));
            for (var a = "", n = 0, s = $(".longhu").find("li").length; n < s; n++) switch (n) {
                case 0:
                    a += "<li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 1:
                    a += "<li  class='guanyaheli li_after' style='margin-right:0'>" + tools.typeOf("sumBigSmall", i.sumBigSmall) + "</li>";
                    break;
                case 2:
                    a += "<li  class='guanyaheli li_after'>" + tools.typeOf("sumSingleDouble", i.sumSingleDouble) + "</li>";
                    break;
                case 3:
                    a += "<li  class='guanyaheli li_after'>" + tools.typeOf("sumWuXing", i.sumWuXing) + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(a), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), tools.cutTime(i.drawTime, i.serverTime, t);
            var o = i.preDrawCode.split(",");
            "10054" != lotCode && "10082" != lotCode || o.splice(-1, 1), animate.sscAnimateEnd(o, t), tools.bjkl8BagColor(o, t), "10054" == lotCode || "10073" == lotCode || "10082" == lotCode || $(t).find("#pk10num").find("li:last-child").css({background: "#FA8E19"}), setTimeout(function () {
                tools.timeSelectCompareToday() && method.loadOther("", i.preDrawIssue)
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, egxy28: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "sscAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount);
            $(t).find(".nextIssue").val();
            $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), void 0 !== $("#drawTime").val() && $("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8));
            for (var a = "", n = 0, s = $(".longhu").find("li").length; n < s; n++) switch (n) {
                case 0:
                    a += "<li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 1:
                    a += "<li  class='guanyaheli li_after' style='margin-right:0'>" + tools.typeOf("sumBigSmall", i.sumBigSmall) + "</li>";
                    break;
                case 2:
                    a += "<li  class='guanyaheli li_after'>" + tools.typeOf("sumSingleDouble", i.sumSingleDouble) + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(a), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), tools.cutTime(i.drawTime, i.serverTime, t);
            var o = i.preDrawCode.split(",");
            o.push(i.sumNum), animate.sscAnimateEnd(o, t), $(t).find("#pk10num").find("li:last-child").css({background: "red"}), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, klsf: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "sscAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            setTimeout(function () {
                var e = $(".headTitle .checkedbl").attr("id");
                config.ifFirstLoad ? config.ifFirstLoad = !config.ifFirstLoad : tools.classGetDate_shifen(e, "", "")
            }, 6e3), $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount), $(t).find("#pk10num li").each(function () {
                $(this).text() >= 19 && $(this).css("background", "red")
            }), $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), void 0 !== $("#drawTime").val() && ($(t).find("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $(t).find("#nextIssue").val(i.drawIssue), $(t).find("#preDrawIssue").val(i.preDrawIssue));
            var a = $(".longhu").find("li"), n = "", s = i.dragonTiger;
            s = "0" == s ? "龙" : "1" == s ? "虎" : "2" == s ? "和" : "";
            for (var o = 0, l = a.length; o < l; o++) switch (o) {
                case 0:
                    n += "<li class=''>" + ("0" == i.firstDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 1:
                    n += "<li class=''>" + ("0" == i.secondDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 2:
                    n += "<li class=''>" + ("0" == i.thirdDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 3:
                    n += "<li class=''>" + ("0" == i.fourthDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 4:
                    n += "<li class='verline li_after'>|</li><li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 5:
                    n += "<li  class='guanyaheli li_after' style='margin-right:0'>" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>";
                    break;
                case 6:
                    n += "<li  class='guanyaheli li_after'>" + tools.typeOf("dxh", i.sumBigSmall) + "</li>";
                    break;
                case 7:
                    n += "<li  class='li_after' style='width:0.5rem'>" + ("0" == i.lastBigSmall ? "尾大" : "尾小") + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(n), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), config.ifdebug;
            var r = i.preDrawCode.split(",");
            animate.sscAnimateEnd(r, t), tools.klsfBagColor(r, t), tools.cutTime(i.drawTime, i.serverTime, t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, gxklsf: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "sscAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            setTimeout(function () {
                var e = $(".headTitle .checkedbl").attr("id");
                config.ifFirstLoad ? config.ifFirstLoad = !config.ifFirstLoad : tools.classGetDate_gxklsf(e, "", "")
            }, 6e3), $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount);
            r = i.preDrawCode.split(",");
            tools.gxklsfBagColor(r, t), $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), void 0 !== $("#drawTime").val() && $(t).find("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8));
            var a = $(".longhu").find("li"), n = "", s = i.firstDragonTiger;
            s = "0" == s ? "龙" : "1" == s ? "虎" : "2" == s ? "和" : "";
            for (var o = 0, l = a.length; o < l; o++) switch (o) {
                case 0:
                    n += "<li class=''>" + ("0" == i.firstDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 1:
                    n += "<li class='verline li_after'>|</li><li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 2:
                    n += "<li  class='guanyaheli li_after' style='margin-right:0'>" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>";
                    break;
                case 3:
                    n += "<li  class='guanyaheli li_after'>" + tools.typeOf("dxh", i.sumBigSmall) + "</li>";
                    break;
                case 4:
                    n += "<li  class='li_after' style='width:0.5rem'>" + ("0" == i.lastBigSmall ? "尾大" : "尾小") + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(n), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), config.ifdebug;
            var r = i.preDrawCode.split(",");
            animate.sscAnimateEnd(r, t), tools.cutTime(i.drawTime, i.serverTime, t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, syx5: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "sscAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            setTimeout(function () {
                var e = $(".headTitle .checkedbl").attr("id");
                config.ifFirstLoad ? config.ifFirstLoad = !config.ifFirstLoad : tools.classGetDate_syxw(e, "", "")
            }, 6e3), $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount), $(t).find(".nextIssue").val(i.drawIssue), $(t).find("#nextIssue").val(i.drawIssue), $(t).find("#sumNum").val(i.sumNum), $(t).find("#sumSingleDouble").val(tools.typeOf("dsh", i.sumSingleDouble)), $(t).find("#sumBigSmall").val(tools.typeOf("zhdx", i.sumBigSmall)), $(t).find(".drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $(t).find(".preDrawIssue").text(i.preDrawIssue);
            var a = $(".longhu").find("li"), n = "", s = i.dragonTiger;
            s = "0" == s ? "龙" : "1" == s ? "虎" : "2" == s ? "和" : "";
            for (var o = 0, l = a.length; o < l; o++) switch (o) {
                case 0:
                    n += "<li class=''>" + tools.typeOf("san", i.behindThree) + "</li>";
                    break;
                case 1:
                    n += "<li class=''>" + tools.typeOf("san", i.betweenThree) + "</li>";
                    break;
                case 2:
                    n += "<li class=''>" + tools.typeOf("san", i.lastThree) + "</li>";
                    break;
                case 3:
                    n += "<li class='verline li_after'>|</li><li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 4:
                    n += "<li  class='guanyaheli li_after' style='margin-right:0'>" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>";
                    break;
                case 5:
                    n += "<li  class='guanyaheli li_after'>" + tools.typeOf("dxh", i.sumBigSmall) + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(n), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), config.ifdebug;
            var r = i.preDrawCode.split(",");
            animate.sscAnimateEnd(r, t), tools.cutTime(i.drawTime, i.serverTime, t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, jsk3: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (i = i.result.data, $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount), 1 === i.lotteryStatus) return void stopLottery(i, t, "kuai3AnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            setTimeout(function () {
                var e = $(".headTitle .checkedbl").attr("id");
                config.ifFirstLoad ? config.ifFirstLoad = !config.ifFirstLoad : tools.classGetDate_kuai(e, "", "")
            }, 6e3), $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue);
            for (var a = "", n = 0, s = $(".longhu").find("li").length; n < s; n++) switch (n) {
                case 0:
                    a += "<li class='li_after'>总和：</li><li class='li_after'>" + i.sumNum + "</li>";
                    break;
                case 1:
                    a += "<li  class='guanyaheli li_after' style='margin-right:0'>" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>";
                    break;
                case 2:
                    a += "<li  class='guanyaheli li_after'>" + ("0" == i.sumBigSmall ? "大" : "小") + "</li>"
            }
            $(".longhu").empty(""), $(".longhu").append(a), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), config.ifdebug, $(t).find(".drawTime").val(i.drawTime), $(t).find(".drawIssue").val(i.drawIssue), tools.cutTime(i.drawTime, i.serverTime, t);
            var o = i.preDrawCode.split(",");
            animate.kuai3AnimateEnd(o, t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, cqnc: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "cqncAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            setTimeout(function () {
                var e = $(".headTitle .checkedbl").attr("id");
                config.ifFirstLoad ? config.ifFirstLoad = !config.ifFirstLoad : tools.classGetDate_shifen(e, "", "")
            }, 6e3), $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount), $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue);
            var a = $(".longhu").find("li"), n = "", s = i.dragonTiger;
            s = "0" == s ? "龙" : "1" == s ? "虎" : "2" == s ? "和" : "";
            for (var o = 0, l = a.length; o < l; o++) switch (o) {
                case 0:
                    n += "<li class=''>" + ("0" == i.firstDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 1:
                    n += "<li class=''>" + ("0" == i.secondDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 2:
                    n += "<li class=''>" + ("0" == i.thirdDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 3:
                    n += "<li class=''>" + ("0" == i.fourthDragonTiger ? "龙" : "虎") + "</li>";
                    break;
                case 4:
                    n += "<li class='verline li_after'>|</li><li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 5:
                    n += "<li  class='guanyaheli li_after' style='margin-right:0'>" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>";
                    break;
                case 6:
                    n += "<li  class='guanyaheli li_after'>" + tools.typeOf("dxh", i.sumBigSmall) + "</li>";
                    break;
                case 7:
                    n += "<li  class='li_after' style='width:0.5rem'>" + ("0" == i.lastBigSmall ? "尾大" : "尾小") + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(n), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), config.ifdebug;
            var r = i.preDrawCode.split(",");
            animate.cqncAnimateEnd(r, $(t)), tools.cutTime(i.drawTime, i.serverTime, t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, qgc: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "sscAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount);
            $(t).find(".nextIssue").val();
            $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), void 0 !== $("#drawTime").val() && ($("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $("#nextDate").val(i.drawTime.substr(0, 10)), $(t).find("#preDrawIssue").val(i.preDrawIssue));
            var a = $(".longhu").find("li"), n = "", s = i.dragonTiger;
            s = "0" == s ? "龙" : "1" == s ? "虎" : "2" == s ? "和" : "";
            for (var o = 0, l = a.length; o < l; o++) switch (o) {
                case 0:
                    n += "<li class='li_after'>" + s + "</li>";
                    break;
                case 1:
                    n += "<li class='verline li_after'>|</li><li class='guanyahe li_after'>总和：</li><li class='guanyaheli li_after'>" + i.sumNum + "</li>";
                    break;
                case 2:
                    n += "<li  class='guanyaheli li_after' style='margin-right:0'>" + ("0" == i.sumSingleDouble ? "单" : "双") + "</li>";
                    break;
                case 3:
                    n += "<li  class='guanyaheli li_after'>" + ("0" == i.sumBigSmall ? "大" : "小") + "</li>"
            }
            $(".longhu").html(""), $(".longhu").append(n), $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), tools.cutTime(i.drawTime, i.serverTime, t);
            var r = i.preDrawCode.split(",");
            animate.sscAnimateEnd(r, t), tools.resetRed(t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }, lhc: function (e, t) {
        var i = tools.parseObj(e);
        if ("100002" == i.result.businessCode) throw new Error("error");
        if (0 == i.errorCode) {
            if (0 != i.result.businessCode) throw new Error("error");
            if (1 === (i = i.result.data).lotteryStatus) return void stopLottery(i, t, "sscAnimateEnd");
            if (tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
            $(t).find(".drawCountnum").text(i.drawCount), $(t).find(".sdrawCountnext").text(1 * i.totalCount - 1 * i.drawCount);
            $(t).find(".nextIssue").val();
            $(t).find(".nextIssue").val(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), void 0 !== $("#drawTime").val() && ($("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $("#nextDate").val(i.drawTime.substr(0, 10)), $(t).find("#preDrawIssue").val(i.preDrawIssue));

             $(t).find(".cuttime").css({
                opacity: "0",
                "margin-right": "100%"
            }), setTimeout(function () {
                $(t).find(".cuttime").animate({opacity: "1"}, 200)
            }, 1e3), $(t).find(".redpro").animate({width: "0"}, 500), setTimeout(function () {
                $(t).find(".redpro").animate({width: "100%"}, 600)
            }, 1e3), tools.cutTime(i.drawTime, i.serverTime, t);
            var r = i.preDrawCode.split(",");
            animate.lhcAnimateEnd(i, t), tools.resetRed(t), setTimeout(function () {
                tools.ifToday() && method.loadOther("")
            }, 1e3), clearInterval(animateID[t]), delete animateID[t]
        }
    }
}, pubmethod.ajaxHead = {
    pk10: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "pks/getLotteryPksInfo.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                void 0 == animateID[t] && animate.pk10OpenAnimate(t)
            },
            success: function (i) {
                try {
                    //标题变更
                    $(".gamename").text(i.result.data.lotName);
                    var title = $("title").text();
                    title = title.replace('加载中...',i.result.data.lotName);
                    $("title").text(title);
                    $("#titlespan").text(i.result.data.lotName);

                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, ssc: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "CQShiCai/getBaseCQShiCai.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                void 0 == animateID[t] && animate.sscAnimate("#headerData")
            },
            success: function (i) {
                try {
                    //标题变更
                    $(".gamename").text(i.result.data.lotName);
                    var title = $("title").text();
                    title = title.replace('加载中...',i.result.data.lotName);
                    $("title").text(title);
                    $("#titlespan").text(i.result.data.lotName);
                    
                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, bjkl8: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "LuckTwenty/getBaseLuckTewnty.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                $(t).find("#pk10num li").each(function () {
                    $(this).css("background", "#0092dd")
                }), void 0 == animateID[t] && animate.sscAnimate("#headerData")
            },
            success: function (i) {
                try {
                    //标题变更
                    $(".gamename").text(i.result.data.lotName);
                    var title = $("title").text();
                    title = title.replace('加载中...',i.result.data.lotName);
                    $("title").text(title);
                    $("#titlespan").text(i.result.data.lotName);

                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, egxy28: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "LuckTwenty/getPcLucky28.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                $(t).find("#pk10num li").each(function () {
                    $(this).css("background", "#19A6DA")
                }), void 0 == animateID[t] && animate.sscAnimate("#headerData")
            },
            success: function (i) {
                try {
                    //标题变更
                    $(".gamename").text(i.result.data.lotName);
                    var title = $("title").text();
                    title = title.replace('加载中...',i.result.data.lotName);
                    $("title").text(title);
                    $("#titlespan").text(i.result.data.lotName);

                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, klsf: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "klsf/getLotteryInfo.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                $(t).find("#pk10num li").each(function () {
                    $(this).css("background", "#0092dd")
                }), void 0 == animateID[t] && animate.sscAnimate(t)
            },
            success: function (i) {
                try {
                    //标题变更
                    $(".gamename").text(i.result.data.lotName);
                    var title = $("title").text();
                    title = title.replace('加载中...',i.result.data.lotName);
                    $("title").text(title);
                    $("#titlespan").text(i.result.data.lotName);
                    
                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, gxklsf: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "gxklsf/getLotteryInfo.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                $(t).find("#pk10num li").each(function () {
                    $(this).css("background", "#0092dd")
                }), void 0 == animateID[t] && animate.sscAnimate(t)
            },
            success: function (i) {
                try {
                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, syx5: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "ElevenFive/getElevenFiveInfo.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                void 0 == animateID[t] && animate.sscAnimate(t)
            },
            success: function (i) {
                try {
                    //标题变更
                    $(".gamename").text(i.result.data.lotName);
                    var title = $("title").text();
                    title = title.replace('加载中...',i.result.data.lotName);
                    $("title").text(title);
                    $("#titlespan").text(i.result.data.lotName);

                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, jsk3: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "lotteryJSFastThree/getBaseJSFastThree.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                void 0 == animateID[t] && animate.kuai3Animate(t)
            },
            success: function (i) {
                try {
                    //标题变更
                    $(".gamename").text(i.result.data.lotName);
                    var title = $("title").text();
                    title = title.replace('加载中...',i.result.data.lotName);
                    $("title").text(title);
                    $("#titlespan").text(i.result.data.lotName);

                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, cqnc: function (e, t) {
        var e = void 0 == e ? "" : e, i = !1;
        $.ajax({
            url: config.publicUrl + "klsf/getLotteryInfo.do?issue=" + e,
            type: "GET",
            data: {lotCode: lotCode},
            beforeSend: function () {
                void 0 == animateID[t] && animate.cqncAnimate(t)
            },
            success: function (i) {
                try {
                    headMethod.headData(i, t)
                } catch (i) {
                    tools.repeatAjax(e, t)
                }
            },
            error: function (a) {
                tools.repeatAjax(e, t), i = !0
            },
            complete: function (a, n) {
                (i = !1) || "timeout" == n && tools.repeatAjax(e, t)
            }
        })
    }, qgc: function (e) {
        var t = e.url, i = e.id, a = e.lotCode, n = !1;
        config.ifdebug, $.ajax({
            url: t, type: "GET", data: {lotCode: a}, beforeSend: function () {
                void 0 == animateID[i] && animate.sscAnimate(i)
            }, success: function (t) {
                try {
                    headMethod.headData(t, i)
                } catch (t) {
                    tools.repeatAjaxOBj(e)
                }
            }, error: function (t) {
                tools.repeatAjaxOBj(e), n = !0
            }, complete: function (t, i) {
                (n = !1) || "timeout" == i && tools.repeatAjaxOBj(e)
            }
        })
    }, lhc: function (e) {
        var t = e.url, i = e.id, a = e.lotCode, n = !1;
        config.ifdebug, $.ajax({
            url: t, type: "GET", data: {lotCode: a}, beforeSend: function () {
                void 0 == animateID[i] && animate.sscAnimate(i)
            }, success: function (t) {
                try {
                    headMethod.headData(t, i)
                } catch (t) {
                    console.log(t)
                    tools.repeatAjaxOBj(e)
                }
            }, error: function (t) {
                tools.repeatAjaxOBj(e), n = !0
            }, complete: function (t, i) {
                (n = !1) || "timeout" == i && tools.repeatAjaxOBj(e)
            }
        })
    }
}, tools.ifToday = function () {
    var e = $("#time_select").text();
    return "" != e && (e = e.split("-")[1].split("-")[0], !(!(tools.getDate("d") == e) || !config.ifFirstLoad))
}, tools.getDate = function (e, t) {
    var i = "", a = new Date, n = a.getFullYear(), s = a.getMonth() + 1, o = a.getDate(), l = a.getHours(),
        r = a.getMinutes(), d = a.getSeconds();
    return t && (s < 10 && (s = "0" + s), o < 10 && (o = "0" + o)), "ymd" == e ? i = n + "-" + s + "-" + o : "ymdhms" == e ? i = n + "-" + s + "-" + o + " " + l + ":" + r + ":" + d : "d" == e && (i = o), i
}, tools.timeSelectCompareToday = function () {
    var e = $("#time_select").text();
    if ("" == e) {
        var t = $(".headTitle .checkedbl").attr("id"), i = $("." + t + " .checkday");
        return 0 == i.length || (0 == i.find(".checkspan").length || -1 != i.find(".checkspan").text().indexOf("今天"))
    }
    return getDateStr(0, !0) === e
}, tools.catchUndefined = function (e) {
    $(e).find("li").each(function () {
        "undefined" == $(this).text() && $(this).text("")
    })
}, tools.bjkl8BagColor = function (e, t) {
    $(t).find(".sscli li").css("background", "#19A6DA");
    for (var i = 0, a = e.length; i < a; i++) e[i] >= 41 && $(t).find(".sscli li").eq(i).css("background", "#0092DD")
}, tools.klsfBagColor = function (e, t) {
    for (var i = 0, a = e.length; i < a; i++) e[i] >= 19 && $(t).find("li").eq(i).css("background", "red")
}, tools.gxklsfBagColor = function (e, t) {
    for (var i = 0; i < e.length; i++) 1 == e[i] || 4 == e[i] || 7 == e[i] || 10 == e[i] || 13 == e[i] || 16 == e[i] || 19 == e[i] ? $(t).find("#pk10num").find("li").eq(i).css("background", "red") : 3 != e[i] && 6 != e[i] && 9 != e[i] && 12 != e[i] && 15 != e[i] && 18 != e[i] && 21 != e[i] || $(t).find("#pk10num").find("li").eq(i).css("background", "#02CB44")
}, tools.setPK10TB = function () {
    pk10jiuchuo = setInterval(function () {
        -1 != $("#videobox").css("z-index") && ("00:00" != $(".animate iframe").contents().find(".countdownnum").text() ? (tools.insertVideo(), config.ifdebug) : config.ifdebug)
    }, 5e3)
}, tools.operatorTime = function (e, t) {
    var i = e.replace(/-/g, "/"), t = t.replace(/-/g, "/");
    return (new Date(i) - new Date(t)) / 1e3
}, tools.insertVideo = function () {
    var e = 3600 * $("#headerData").find(".hour").text() + 60 * $("#headerData").find(".minute").text() + 1 * $("#headerData").find(".second").text() - 1;
    "-1" == e && (e = 0), $("iframe")[0].contentWindow.startcountdown(e);
    var t = "", i = $("#pk10num").find("li");
    $(i).each(function () {
        t += $(this).text() + ","
    });
    var a = null;
    a = t.length < 11 ? "5,6,3,4,8,7,9,10,2,1" : t.substring(0, t.length - 1), $("iframe")[0].contentWindow.showcurrentresult(a), $(".animate iframe").contents().find("#currentdrawid").text($("#headerData").find(".drawCountnum").text()), $(".animate iframe").contents().find("#nextdrawtime").text($("#headerData").find(".preDrawIssue").text());
    i = $("#headerData .longhu").find("li");
    $(".animate iframe").contents().find("#stat1_1").text($(i).eq(7).text()), $(".animate iframe").contents().find("#stat1_2").text($(i).eq(8).text()), $(".animate iframe").contents().find("#stat1_3").text($(i).eq(9).text()), $(".animate iframe").contents().find("#stat2_1").text($(i).eq(0).text()), $(".animate iframe").contents().find("#stat2_2").text($(i).eq(1).text()), $(".animate iframe").contents().find("#stat2_3").text($(i).eq(2).text()), $(".animate iframe").contents().find("#stat2_4").text($(i).eq(3).text()), $(".animate iframe").contents().find("#stat2_5").text($(i).eq(4).text())
}, tools.testWWW = function () {
    for (var e = window.location.href, t = ["localhost", "1680100.com", "1680101kai.com", "1680101kai.co", "1680102kai.co", "1680103kai.co", "1680104kai.co", "1680105kai.co", "1683990.com", "1685080.com", "1685110.com", "1685150.com", "1685180.com", "1685200.com", "1685220.com", "1685250.com"], i = 0; i < t.length; i++) -1 != e.indexOf(t[i]) && (window.isNoAdv = !0, $(".footer_up").find(".computer_ver").attr("onclick", "javascript:window.location.href='http://www.1680100.com/html/public/home.html'"), $(".main_image").empty().append("<img style='float:left;width:100%' src='../../img/NOprBanner.jpg'/>"), $(".flicking_con").hide())
}, tools.resetRed = function (e) {
    var t = $(e).find(".sscli li").length;
    $(e).find(".sscli li").each(function (e) {
        "10039" == lotCode || "10042" == lotCode ? e != t - 1 ? $(this).css("background-color", "red") : $(this).css("background-color", "#0092dd") : "10040" == lotCode ? e == t - 1 || e == t - 2 ? $(this).css("background-color", "#0092dd") : $(this).css("background-color", "red") : "10041" == lotCode || "10043" == lotCode ? $(this).css("background-color", "red") : "10044" == lotCode ? $(this).css("background-color", "red") : "10045" == lotCode && (e <= 3 ? $(this).css("background-color", "#0092dd") : $(this).css("background-color", "#19a6da"))
    })
}, tools.setTimefun = function () {
    setTimeout(function () {
        !$("#videobox").length < 1 && $("iframe")[0].contentWindow.ifopen && $("iframe")[0].contentWindow.k3v.stopVideo(createData())
    }, 1e3)
}, tools.setTimefun_cqnc = function () {
    setTimeout(function () {
        if (!$("#videobox").length < 1 && $("iframe")[0].contentWindow.ifopen) {
            var e = createData();
            if (e.codearr.length < 8) return void setTimeout(function () {
                tools.setTimefun_cqnc()
            }, 500);
            $("iframe")[0].contentWindow.stopanimate(e.codearr, e.counttime)
        }
    }, 1e3)
}, tools.setTimefun_shiyixw = function () {
    !$("#videobox").length < 1 && "block" != $(".opentyle").css("display") && $("iframe")[0].contentWindow.ifopen && setTimeout(function () {
        $("iframe")[0].contentWindow.k3v.stopVideo(tools.getDataStr())
    }, 3e3)
}, tools.getDataStr = function () {
    var e = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        t = [];
    return $("#headerData").find("#pk10num li").each(function () {
        t.push(parseInt($(this).text()))
    }), {
        preDrawCode: t,
        sumNum: $("#sumNum").val(),
        sumBigSmall: $("#sumBigSmall").val(),
        sumSingleDouble: $("#sumSingleDouble").val(),
        drawIssue: $(".nextIssue").val(),
        drawTime: $(".drawTime").val(),
        preDrawTime: e
    }
}, tools.bjkl8DataStr = function () {
    var e = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        t = [];
    return $("#headerData").find("#pk10num li").each(function () {
        t.push(parseInt($(this).text()))
    }), "10073" != lotCode && "10054" != lotCode && "10082" != lotCode || t.push("101"), {
        preDrawCode: t,
        drawIssue: $("#preDrawIssue").val(),
        drawTime: $("#drawTime").val(),
        preDrawTime: e
    }
}, tools.setTimefun_bjkl8 = function () {
    !$("#videobox").length < 1 && "block" != $(".opentyle").css("display") && $("iframe")[0].contentWindow.ifopen && setTimeout(function () {
        $("iframe")[0].contentWindow.syxwV.stopVid(tools.bjkl8DataStr()), $("iframe")[0].contentWindow.syxwV.bgMusic()
    }, 3e3)
}, tools.pcEggDataStr = function () {
    var e = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        t = [];
    return $("#headerData").find("#pk10num li").each(function (e) {
        e < 3 && t.push(parseInt($(this).text()))
    }), {numArr: t, nextIssue: $(".nextIssue").val(), drawTime: $("#drawTime").val(), preDrawTime: e}
}, tools.setTimefun_pcEgg = function () {
    !$("#videobox").length < 1 && "block" != $(".opentyle").css("display") && $("iframe")[0].contentWindow.ifopen && setTimeout(function () {
        $("iframe")[0].contentWindow.pcEgg.stopVid(tools.pcEggDataStr())
    }, 3e3)
}, tools.gdklsfDataStr = function () {
    var e = 3600 * $("#timebox").find(".hour").text() + 60 * $("#timebox").find(".minute").text() + 1 * $("#timebox").find(".second").text() - 2,
        t = [];
    return $("#headerData").find("#pk10num li").each(function () {
        t.push(parseInt($(this).text()))
    }), {
        arr: t,
        thisIssue: $("#preDrawIssue").val(),
        nextIssue: $("#nextIssue").val(),
        nextTime: $("#drawTime").val(),
        countdown: e
    }
}, tools.setTimefun_gdklsf = function () {
    !$("#videobox").length < 1 && "block" != $(".opentyle").css("display") && $("iframe")[0].contentWindow.ifopen && setTimeout(function () {
        var e = tools.gdklsfDataStr();
        $("iframe")[0].contentWindow.fun.Trueresult(e.arr), $("iframe")[0].contentWindow.fun.fillHtml(e.thisIssue, e.nextIssue, e.nextTime, e.countdown)
    }, 3e3)
}, tools.gxklsfDataStr = function () {
    var e = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        t = [];
    return $("#headerData").find("#pk10num li").each(function () {
        t.push(parseInt($(this).text()))
    }), {
        numArr: t,
        thisIssue: $(".preDrawIssue").text(),
        nextIssue: $(".nextIssue").val(),
        drawTime: $("#drawTime").val(),
        cutdonwTime: e
    }
}, tools.setTimefun_gxklsf = function () {
    !$("#videobox").length < 1 && "block" != $(".opentyle").css("display") && $("iframe")[0].contentWindow.ifopen && setTimeout(function () {
        var e = tools.gxklsfDataStr();
        $("iframe")[0].contentWindow.gxklsf.stopVid(e)
    }, 3e3)
}, tools.fc3dDataStr = function () {
    var e = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        t = [];
    return $("#headerData").find("#pk10num li").each(function () {
        t.push(parseInt($(this).text()))
    }), {preDrawCode: t, drawIssue: $("#preDrawIssue").val(), drawTime: $("#drawTime").val(), preDrawTime: e}
}, tools.setTimefun_fc3d = function () {
    !$("#videobox").length < 1 && "block" != $(".opentyle").css("display") && $("iframe")[0].contentWindow.ifopen && setTimeout(function () {
        $("iframe")[0].contentWindow.fc3d.stopVid(tools.fc3dDataStr())
    }, 3e3)
}, tools.fcssqDataStr = function () {
    var e = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        t = [];
    return $("#headerData").find("#pk10num li").each(function () {
        t.push(parseInt($(this).text()))
    }), {
        preDrawCode: t,
        drawIssue: $("#preDrawIssue").val(),
        data: $("#nextDate").val(),
        drawTime: $("#drawTime").val(),
        preDrawTime: e
    }
}, tools.setTimefun_fcssq = function () {
    !$("#videobox").length < 1 && "block" != $(".opentyle").css("display") && $("iframe")[0].contentWindow.ifopen && setTimeout(function () {
        $("iframe")[0].contentWindow.ssq.stopVid(tools.fcssqDataStr())
    }, 3e3)
};
var VerifyThe = !1;
tools.publicPk10 = function (e, t, i, a) {
    // if ($(t).find(".caiNametop").text(i.drawIssue), $(t).find(".preDrawIssue").text(i.preDrawIssue), VerifyThe && (ACertainPeriod(), VerifyThe = !1), a <= 0) throw new Error("error");
    // config.ifdebug, $("#videobox").length > 0 && -1 != $("#videobox").css("z-index") ? ($("iframe")[0].contentWindow.finishgame(i.preDrawCode), setTimeout(function () {
    //     pubmethod.creatHead.pk10(e, t)
    // }, 3e3), setTimeout(function () {
    //     tools.insertVideo()
    // }, 1e4)) : 
    pubmethod.creatHead.pk10(e, t)
}, tools.publicJsft = function (e, t, i, a) {
    for (var n = i.preDrawCode.split(","), s = [], o = 0; o < n.length; o++) {
        if (1 != n[o].charAt(0)) l = n[o].charAt(1); else var l = n[o];
        s.push(l)
    }
    var r = s.toString();
    if (a <= 0) throw config.ifdebug, new Error("error");
    config.ifdebug, !$("#videobox").length < 1 && -1 != $("#videobox").css("z-index") ? ($("iframe")[0].contentWindow.finishgame(r, a), setTimeout(function () {
        pubmethod.creatHead.pk10(e, t)
    }, 3e3), setTimeout(function () {
        tools.insertVideo()
    }, 1e4)) : pubmethod.creatHead.pk10(e, t)
}, $("body").on("click", "#beginTime", function () {
    $("#dateshadow").css("height", $("body").height() + "px")
}), tools.weikaiji = function (e) {
    $(e).html("<div id='weikaiji'>今日暂未开奖</div>")
}, tools.newsTicker = function (e) {
    var t = document.getElementById(e), i = t.scrollWidth + document.documentElement.clientWidth, a = 0, n = 0;
    t.addEventListener("touchstart", function () {
        n = 1
    }), t.addEventListener("touchend", function () {
        n = 0
    }), t.style.transform = "translateX(100vw)";
    setInterval(function () {
        if (0 == n) {
            (a += 1) == i && (a = 0);
            var e = document.documentElement.clientWidth - a;
            t.style.transform = "translateX(" + e + "px)"
        }
    }, 15)
};