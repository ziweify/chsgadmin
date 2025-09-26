function takeOutUrlToken() {
    var e = window.location.href, t = e.indexOf("token");
    t > -1 && (e = e.slice(0, t)), sessionStorage.setItem("takeOut", "takeOut"), window.location.href = e
}

var ajaxList = {}, toolBoxs = {};
toolBoxs.isIE = function () {
    return !!(window.ActiveXObject || "ActiveXObject" in window)
}, ajaxList.qgc = function (e) {
    var t = e.url, o = e.id, s = e.lotCode, i = !1;
    $.ajax({
        url: t, type: "GET", data: {lotCode: s}, beforeSend: function () {
            void 0 == animateID[o] && animateMethod.sscAnimate(o)
        }, success: function (e) {
            try {
                creatDataHead(e, o), clearInterval(animateID[o]), delete animateID[o]
            } catch (e) {
                setTimeout(function () {
                    ajaxRequst(o)
                }, "1000")
            }
        }, error: function (e) {
            setTimeout(function () {
                ajaxRequst(o)
            }, "1000"), i = !0
        }, complete: function (e, t) {
            (i = !1) || "timeout" == t && setTimeout(function () {
                ajaxRequst(o)
            }, "1000")
        }
    })
}, publicmethod.insertHeadQGC = function (e, t) {
    var o = tools.parseObj(e);
    if ("100002" == o.result.businessCode) throw new Error("error");
    if (o = o.result.data, tools.operatorTime("" == o.drawTime ? "0" : o.drawTime, o.serverTime) <= 0) throw new Error("error");
    o.totalCount;
    $(t).find(".preDrawIssue").text(o.preDrawIssue), $(t).find(".nextIssue").text(o.drawIssue), void 0 !== $("#drawTime").val() && ($("#drawTime").val(o.drawTime.substr(o.drawTime.length - 8, 8)), $("#nextDate").val(o.drawTime.substr(0, 10)), $(t).find("#preDrawIssue").val(o.preDrawIssue)), $(".lenresinli").removeClass("checked"), tools.countDown(o.drawTime, o.serverTime, t, o.lotteryStatus), animateMethod.sscAnimateEnd(o.preDrawCode, t), toolBoxs.resetRed(t), $("#waringbox").hide(300), setTimeout(function () {
        tools.ifCheckedOnToday() && loadotherData()
    }, config.listTime)
}, toolBoxs.resetRed = function (e) {
    var t = $(e).find(".kajianhao li").length;
    $(e).find(".kajianhao li").each(function (e) {
        "10039" == lotCode || "10042" == lotCode ? e != t - 1 ? $(this).addClass("numred") : $(this).removeClass("numred") : "10040" == lotCode ? e == t - 1 || e == t - 2 ? $(this).removeClass("numred") : $(this).addClass("numred") : "10041" == lotCode || "10043" == lotCode ? $(this).addClass("numred") : "10044" == lotCode && $(this).addClass("numred")
    })
}, toolBoxs.qgcTools = {
    bigOrSmall: function (e, t) {
        $("#jrsmhmtj .blueqiu li").each(function (o) {
            var s = $(this).text(), i = s % 2 == 0, n = s >= t;
            if ($(this).find("i").hide(), "xshm" == e) {
                if (tools.ifselectedOpacity($(this)), $(this).addClass("numblue"), $(this).addClass("numred"), "10041" == lotCode) ; else if ("10060" == lotCode) {
                    $(this).removeClass();
                    var a = 1 * $(this).find("i").text();
                    a = a <= 9 ? "0" + a : a, $(this).addClass("cznum" + a)
                } else (o + 1) % 7 == 0 && ($(this).removeClass("numred"), $(this).prev().removeClass("numred"));
                $(this).find("i").show()
            } else "xsdx" == e ? (tools.ifselectedOpacity($(this)), n ? ($(this).addClass("bluebig"), (o + 1) % 10 == 0 && $(this).addClass("bluebig li_after")) : ($(this).addClass("bluesmall"), (o + 1) % 10 == 0 && $(this).addClass("bluesmall li_after"))) : "xsds" == e && (tools.ifselectedOpacity($(this)), i ? ($(this).addClass("blueeven"), (o + 1) % 10 == 0 && $(this).addClass("blueeven li_after")) : ($(this).addClass("bluesingular"), (o + 1) % 10 == 0 && $(this).addClass("bluesingular li_after")))
        })
    }
}, toolBoxs.setK = function () {
    var e = window.location.host;
    -1 != e.indexOf(":") && (e = "1680218.com"), $(".kaijdy").attr("href", "//kj.1685770.com/?" + e)
}, toolBoxs.setSwtzUrl = function () {
    sessionStorage.getItem("swtzUrl") && window.history.length >= 2 ? $(".menubox #tryplay a").attr("href", sessionStorage.getItem("swtzUrl")) : $.ajax({
        type: "get",
        url: config.publicUrl + "parameters/getDynamicUrl.do?terminalType=5",
        async: !0,
        data: "",
        success: function (e) {
            if ("string" == typeof e) {
                var t = (e = JSON.parse(e)).result.data.swtzUrl;
                sessionStorage.setItem("swtzUrl", t), $(".menubox #tryplay a").attr("href", t)
            }
        },
        error: function (e) {
        }
    })
}, tools.username = function () {
    var e = window.location.search.split("?")[1], t = window.location.search.split("?")[2];
    if (tools.getQueryString("token")) return tools.register(o), $(".login").hide(), $(".register").hide(), void $("#nametext").show();
    if ($(".login").show(), $(".register").show(), $("#nametext").hide(), "succeed" == e || "log" == t || "logtop" == t || "succeed" == t || null != sessionStorage.getItem("tokens")) {
        var o = sessionStorage.getItem("tokens");
        tools.register(o), $(".login").hide(), $(".register").hide(), $("#nametext").show()
    }
    null == sessionStorage.getItem("tokens") && void 0 == sessionStorage.getItem("tokens") && ($(".login").show(), $(".register").show(), $("#nametext").hide())
}, tools.getQueryString = function (e) {
    var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)"), o = window.location.search.split("?").pop().match(t);
    return null != o ? unescape(o[2]) : null
}, tools.nameDate = function (e) {
    e = e || window.location.search.split("=")[1];
    var t = !0;
    return tools.ajax(e, "user/info.do", "", !0, function (e) {
        null != e && (t = !1)
    }, "#namevd", "GET"), t
}, tools.register = function (e) {
    e = e || window.location.search.split("=")[1], sessionStorage.setItem("tokens", e), tools.ajax(e, "user/info.do", "", !0, tools.Namehtml, "#namevd", "GET")
};
var takeOut = !0, urlbublic = config.publicUrl;
tools.ajax = function (e, t, o, s, i, n, a) {
    $.ajax({
        headers: {token: e},
        url: urlbublic + t,
        type: a,
        dataType: "json",
        data: o,
        timeout: 6e4,
        async: !1,
        beforeSend: function (e) {
        },
        success: function (e) {
            i(e, n)
        },
        error: function (e) {
        },
        complete: function (e, t) {
        }
    })
}, tools.Namehtml = function (e, t) {
    var o = tools.parseObj(e);
    if (0 == e.errorCode) {
        if (null == (o = o.result.data)) return void tools.token_past(o);
        var s = "";
        sessionStorage.getItem("tokens");
        s += '<a href="#" id="nametext">欢迎<span>' + o.userName + '</span></a><div id="pop-up"><p class="poptext">现在积分有:<span>' + o.balance + '</span></p><p><a class="upleft" href="/view/Quizzes/userCnter.html?succeed?centre">个人中心 >></a><span class="upright" id="quit">退出</span></p></div>', $(t).html(s), tools.quit(), "takeOut" != sessionStorage.getItem("takeOut") && takeOutUrlToken()
    }
};
var hos = window.location.hostname, urlPost = window.location.host, urlAddress = urlPost.split(".");
if (void 0 != urlAddress[3]) {
    var urlList = urlAddress[0] + "." + urlAddress[1];
    if (-1 != hos.indexOf(urlList) && window.location.href.split(":")[2]) {
        var dkh = window.location.href.split(":")[2].split("/")[0];
        hos += ":" + dkh
    }
}
tools.quit = function () {
    var e = window.location.search.split("?")[2];
    $("#quit").on("click", function () {
        if (window.sessionStorage.removeItem("takeOut"), window.sessionStorage.removeItem("tokens"), "centre" == e) window.location.href = config.loginUrl + "login?callbackUrl=http://" + hos + "/view/Quizzes/userCnter.html?succeed?centre"; else {
            var t = window.location.href, o = t.indexOf("succeed");
            if (o > -1 && (t = t.slice(0, o)), window.location.href = t, "succeed" == window.location.search.split("?")[1]) return $(".login").show(), $(".register").show(), void $("#nametext").hide()
        }
    })
}, tools.token_past = function (e) {
    $(".login").show(), $(".register").show(), $("#nametext").hide(), window.sessionStorage.removeItem("tokens"), $(".contenfd").on("click", function () {
        window.location.href = config.loginUrl + "login?callbackUrl=http://" + hos
    })
}, tools.setPubQQNum = function (e) {
    e.forEach(function (e) {
        $("." + e.type).text(e.numbers[0])
    })
};