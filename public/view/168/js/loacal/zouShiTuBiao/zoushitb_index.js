function updateSet() {
    setInterval(function () {
        funObj.requestDate()
    }, 1e4)
}

function showBlock_Model(t) {
    "#listModelKlsf" == t ? ($(t).addClass("displayNone").siblings().removeClass("showBlock"), $(".tubiaoBox").addClass("padding0")) : ($(".tubiaoBox").removeClass("padding0"), $(t).addClass("showBlock").siblings().removeClass("showBlock"))
}

function showDetail_Model(t) {
    $(t).addClass("showDetail").siblings().removeClass("showDetail")
}

function recoverBallMinc(t) {
    $(t).find("ul").each(function () {
        $(this).find("li i").removeClass(), $(this).find("li").eq(0).find("i").addClass("iboder"), $(this).find("li").eq(0).addClass("actNav").siblings().removeClass("actNav")
    })
}

function createListData_pk10(t) {
    var a, e, i = rankSpan;
    $.each(t, function (n, s) {
        if (a = [], e = [], n == i - 1) {
            var l = t[n].bodyList;
            $.each(l, function (t, i) {
                var s = "", o = l[t].drawCode[n];
                s = (s = "" + l[t].preIssue).substring(s.length - 3), a.push(s), e.push(o)
            }), funObj.trendLine(a, e)
        }
    })
}

function createListData_SSC(t) {
    var a = rankSpan, e = [], i = [], n = "", s = "";
    $.each(t, function (l, o) {
        n = "" + t[l].issue, n = n.substring(n.length - 3), s = t[l].code.split(",")[a - 1], e.push(n), i.push(s)
    }), funObj.trendLine(e, i)
}

function createListData_shiYX5(t) {
    var a = rankSpan, e = [], i = [], n = "", s = "";
    $.each(t, function (l, o) {
        n = "" + t[l].issue, n = n.substring(n.length - 3), 0 == (s = t[l].code.split(",")[a - 1]).substr(0, 1) && (s = s.slice(1)), e.push(n), i.push(s)
    }), funObj.trendLine(e, i)
}

function createListData_Kuai3(t) {
    var a = rankSpan, e = [], i = [], n = "", s = "";
    $.each(t, function (l, o) {
        n = "" + t[l].preIssue, n = n.substring(n.length - 3), s = t[l].drawCode[a - 1], e.push(n), i.push(s)
    }), funObj.trendLine(e, i)
}

var publicUrl = config.publicUrl, kinds = {}, funObj = {}, lotType = "10035", dataArr = "", navId = "PK拾",
    errTimeOut = "", ctx = c1.getContext("2d");
$(function () {
    kinds.tabSubject(), funObj.listData_pk10(lotType), updateSet()
});
var rankSpan = $(".tubiaoBox .showBlock #zoushiMinc").find(".actNav").find("span").text();
kinds.tabSubject = function () {
    $("#navBox").find("li").on("click", function () {
        rankSpan = 1, ctx.clearRect(0, 0, c1.width, c1.height), ctx.fillText("正在努力绘制...", 500, 120), $(this).addClass("actNavBig").siblings().removeClass("actNavBig"), navId = $(".actNavBig").text();
        var t = $(this).text();
        "快乐十分" == t ? (showBlock_Model("#listModelKlsf"), showDetail_Model("#detailBox #detailKlsf"), $("#zhexiantu").addClass("displayNone")) : ($("#zhexiantu").hasClass("displayNone") && $("#zhexiantu").removeClass("displayNone"), "PK拾" == t ? (showBlock_Model("#listModelPK10"), showDetail_Model("#detailBox #detailPK10"), funObj.listData_pk10("10058"), recoverBallMinc("#listModelPK10")) : "时时彩" == t ? (showBlock_Model("#listModelSSC"), showDetail_Model("#detailBox #detailSSC"), funObj.listData_SSC("10075"), recoverBallMinc("#listModelSSC")) : "快三" == t ? (showBlock_Model("#listModelKuai3"), showDetail_Model("#detailBox #detailKuai3"), funObj.listData_Kuai3("10076"), recoverBallMinc("#listModelKuai3")) : (showBlock_Model("#listModelSYXW"), showDetail_Model("#detailBox #detailSYXW"), funObj.listData_shiYX5("10006"), recoverBallMinc("#listModelSYXW")))
    }), kinds.clickCaiName(), kinds.rankMinCi()
}, kinds.clickCaiName = function () {
    $(".tubiaoBox .kindsCaName").find("li").on("click", function () {
        rankSpan = 1, $(this).addClass("actNav").siblings().removeClass("actNav"), $(this).find("i").addClass("iboder").parent().siblings().find("i").removeClass();
        var t = $(this).attr("data-text");
        $(".tubiaoBox .showBlock #zoushiMinc").find("li").eq(0).addClass("actNav").siblings().removeClass("actNav"), lotType = t, "PK拾" == navId ? funObj.listData_pk10(lotType) : "时时彩" == navId ? funObj.listData_SSC(lotType) : "11选5" == navId ? funObj.listData_shiYX5(lotType) : "快三" == navId && funObj.listData_Kuai3(lotType), ctx.clearRect(0, 0, c1.width, c1.height), ctx.fillText("正在努力绘制...", 500, 120)
    })
}, kinds.rankMinCi = function () {
    $(".tubiaoBox #zoushiMinc").find("li").on("click", function () {
        $(this).addClass("actNav").siblings().removeClass("actNav"), rankSpan = $(this).find("span").text(), "PK拾" == navId ? createListData_pk10(dataArr) : "时时彩" == navId ? createListData_SSC(dataArr) : "11选5" == navId ? createListData_shiYX5(dataArr) : "快三" == navId && createListData_Kuai3(dataArr)
    })
}, kinds.listContent = function () {
    $("#detailBox #detailPK10").addClass("detailPK10").siblings().removeClass("detailPK10")
}, funObj.listData_pk10 = function (t) {
    var a = {date: "", periods: 25, lotCode: t};
    $.ajax({
        url: publicUrl + "pks/queryLocationTrend.do", type: "GET", data: a, success: function (t) {
            funObj.pk10_dataDeal(t)
        }, error: function () {
        }
    })
}, funObj.pk10_dataDeal = function (t) {
    if ("string" == typeof t && (t = JSON.parse(t)), 0 == t.result.data.length) return errTimeOut = setTimeout(function () {
        funObj.requestDate()
    }, 1e3), !1;
    createListData_pk10(dataArr = t.result.data)
}, funObj.listData_SSC = function (t) {
    var a = {date: "", issue: 25, lotCode: t};
    $.ajax({
        url: publicUrl + "CQShiCai/queryCQShiCaiTrendByIssue.do", type: "GET", data: a, success: function (t) {
            funObj.SSC_dataDeal(t)
        }, error: function () {
        }
    })
}, funObj.SSC_dataDeal = function (t) {
    if ("string" == typeof t && (t = JSON.parse(t)), 0 == t.result.data[0].length) return errTimeOut = setTimeout(function () {
        funObj.requestDate()
    }, 1e3), !1;
    createListData_SSC(dataArr = t.result.data[0].bodyList, 1)
}, funObj.listData_shiYX5 = function (t) {
    var a = {date: "", issue: 25, lotCode: t};
    $.ajax({
        url: publicUrl + "ElevenFive/queryElevnFiveTrendByIssue.do", type: "GET", data: a, success: function (t) {
            funObj.shiYX5_dataDeal(t)
        }, error: function () {
        }
    })
}, funObj.shiYX5_dataDeal = function (t) {
    if ("string" == typeof t && (t = JSON.parse(t)), 0 == t.result.data.length) return errTimeOut = setTimeout(function () {
        funObj.requestDate()
    }, 1e3), !1;
    createListData_shiYX5(dataArr = t.result.data[0].bodyList, 1)
}, funObj.listData_Kuai3 = function (t) {
    var a = {date: "", issue: "", periods: 25, lotCode: t};
    $.ajax({
        url: publicUrl + "lotteryJSFastThree/queryOrientationTrend.do",
        type: "GET",
        data: a,
        success: function (t) {
            funObj.Kuai3_dataDeal(t)
        },
        error: function () {
        }
    })
}, funObj.Kuai3_dataDeal = function (t) {
    if ("string" == typeof t && (t = JSON.parse(t)), 0 == t.result.data.length) return errTimeOut = setTimeout(function () {
        funObj.requestDate()
    }, 1e3), !1;
    createListData_Kuai3(dataArr = t.result.data.bodyList, 1)
}, funObj.requestDate = function () {
    clearTimeout(errTimeOut);
    var t = $("#navBox .actNavBig").text(),
        a = $(".tubiaoBox .showBlock").find(".kindsCaName").find(".actNav").attr("data-text");
    "PK拾" == t ? funObj.listData_pk10("" + a) : "时时彩" == t ? funObj.listData_SSC("" + a) : "快三" == t ? funObj.listData_Kuai3("" + a) : funObj.listData_shiYX5("" + lotCode[a])
}, funObj.trendLine = function (t, a) {
    function e(t, a) {
        n.beginPath(), n.strokeStyle = "#DEDEDE", n.lineWidth = 1, i(n, o, s, l, s, 2), n.stroke(), n.font = "16px Arial Regular", n.fillStyle = "#999999", n.fillText(r, o - 25, s), "快三" !== $("#navBox .actNavBig").text() ? r -= 5 : r -= 2, s += a ? 53 : 80, 0 == r && n.fillText("号", o - 25, s)
    }

    function i(t, a, e, i, n, s) {
        s = void 0 === s ? 5 : s;
        for (var l = i - a, o = n - e, r = Math.floor(Math.sqrt(l * l + o * o) / s), d = 0; d < r; ++d) t[d % 2 == 0 ? "moveTo" : "lineTo"](a + l / r * d, e + o / r * d);
        t.stroke()
    }

    t = t.reverse(), a = a.reverse();
    var n = c1.getContext("2d");
    n.clearRect(0, 0, c1.width, c1.height), n.font = "14px Arial Regular", n.textBaseline = "alphabetic", n.shadowBlur = "", n.beginPath(), n.strokeStyle = "#B4B4B4", n.lineWidth = 1, n.lineJoin = "round", n.moveTo(1128, 200.5), n.lineTo(40.5, 200.5), n.lineTo(40.5, 25.5), n.stroke();
    var s = 40.5, l = 1130, o = 40, r = "";
    r = "11选5" == $("#navBox .actNavBig").text() ? 15 : "快三" == $("#navBox .actNavBig").text() ? 6 : 10;
    for (var d = 0; d < 2; d++) "11选5" == $("#navBox .actNavBig").text() || "快三" == $("#navBox .actNavBig").text() ? e(0, !0) : e(0, !1), ("11选5" == $("#navBox .actNavBig").text() && 1 == d || "快三" == $("#navBox .actNavBig").text() && 1 == d) && e(0, !0);
    var u = 80;
    n.font = "14px Arial Regular", n.fillText("期", 40, 220);
    for (var c = 0; c < t.length; c++) n.beginPath(), n.moveTo(u, 200), n.lineTo(u, 190), n.strokeStyle = "#ccc", n.lineWidth = .5, n.stroke(), n.fillText(t[c], u - 10, 220), u += 42.5;
    for (var f = [], h = 80, v = 0; v < a.length; v++) {
        var b = 0;
        n.beginPath(), "快三" == $("#navBox .actNavBig").text() ? a[v] >= 4 ? b = 53 - 10 * (a[v] - 4) / 22 * 53 + 40 : a[v] >= 2 ? b = 53 - 10 * (a[v] - 2) / 22 * 53 + 93 : a[v] < 2 && (b = 53 - 10 * a[v] / 22 * 53 + 146) : "11选5" == $("#navBox .actNavBig").text() ? a[v] >= 10 ? b = 53 - 10 * (a[v] - 10) / 50 * 53 + 40 : a[v] >= 5 ? b = 53 - 10 * (a[v] - 5) / 50 * 53 + 93 : a[v] < 5 && (b = 53 - 10 * a[v] / 50 * 53 + 146) : b = a[v] > 5 ? 80 - 10 * (a[v] - 5) / 50 * 80 + 40 : 80 - 10 * a[v] / 50 * 80 + 120, f.push(b), n.arc(h, b, 3.5, 0, 2 * Math.PI), n.fillStyle = "#FC223B", n.fill(), n.fillStyle = "#666666", n.fillText(a[v], h - 8, b - 13), h += 42.5
    }
    var p = 80;
    n.beginPath();
    for (v = 0; v < f.length; v++) n.lineTo(p, f[v]), n.strokeStyle = "#F8213B", n.lineWidth = .8, p += 42.5;
    n.stroke()
};