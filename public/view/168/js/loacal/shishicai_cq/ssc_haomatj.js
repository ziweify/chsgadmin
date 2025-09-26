function choseNum() {
    yzHaomaduan();
    var s = $("#colorSet").find(".param");
    $(s).each(function () {
        if (!$(this).is(":hidden")) {
            var s = $(this).find(".input1").val(), t = $(this).find(".input2").val(), e = $("#table_cltj td");
            "sid1" == $(this).attr("id") ? $(e).each(function () {
                var e = $(this).text(), a = 1 * e <= 1 * t;
                1 * e >= 1 * s && a ? (config.ifdebug, "rgb(153, 153, 153)" == $(this).css("color") && $(this).css({color: "#f1010a"})) : "rgb(241, 1, 10)" == $(this).css("color") && $(this).css({color: "#999999"})
            }) : "sid2" == $(this).attr("id") ? $(e).each(function () {
                var e = $(this).text(), a = 1 * e <= 1 * t;
                1 * e >= 1 * s && a ? (config.ifdebug, void 0 != $(this).css("color") && $(this).css({color: "#0092dd"})) : "rgb(0, 146, 221)" == $(this).css("color") && $(this).css({color: "#999999"})
            }) : "sid3" == $(this).attr("id") && $(e).each(function () {
                var e = $(this).text(), a = 1 * e <= 1 * t;
                1 * e >= 1 * s && a ? (config.ifdebug, void 0 != $(this).css("color") && $(this).css({color: "#07bf00"})) : "rgb(7, 191, 0)" == $(this).css("color") && $(this).css({color: "#999999"})
            })
        }
    })
}

function yzHaomaduan() {
    var s = [15, 30], t = [31, 40], e = [41, 50], a = ($(this).attr("id"), $("#star1").val()), i = $("#end1").val(),
        l = $("#star2").val(), n = $("#end2").val(), c = $("#star3").val(), d = $("#end3").val();
    1 * a < s[0] ? $("#star1").val(s[0]) : 1 * a >= s[1] && $("#star1").val(s[0]), 1 * i < s[0] ? $("#end1").val(s[1]) : 1 * i >= s[1] && $("#end1").val(s[1]), 1 * l < t[0] ? $("#star2").val(t[0]) : 1 * l >= t[1] && $("#star2").val(t[0]), 1 * n < t[0] ? $("#end2").val(t[1]) : 1 * n >= t[1] && $("#end2").val(t[1]), 1 * c < e[0] ? $("#star3").val(e[0]) : 1 * c >= e[1] && $("#star3").val(e[0]), 1 * d < e[0] ? $("#end3").val(e[1]) : 1 * d >= e[1] && $("#end3").val(e[1])
}

function formatDate(s) {
    var t = s.getFullYear(), e = s.getMonth() + 1;
    e = e < 10 ? "0" + e : e;
    var a = s.getDate();
    return a = a < 10 ? "0" + a : a, t + "-" + e + "-" + a
}

function doCheck(s, t) {
    var e = $("." + s + "  .item_" + t + " .lz_table_head td .txtNum").val(),
        a = $("." + s + "  .item_" + t + " .lz_table_head td .secType").val(), i = Number("0" + e), l = 0;
    $("." + s + "  .item_" + t + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == a && $(this).children("p").length >= i && ($(this).removeAttr("style"), $(this).addClass("shaw"), l++)
    }), $("." + s + "  .item_" + t + " .lz_table_head td .sec_count").html(l), $("." + s + "  .item_" + t + "  .lz_table_head td .count").each(function () {
        var e = $(this).attr("data"), a = 0;
        $("." + s + "  .item_" + t + " .lz_table_con td p").each(function () {
            $(this).html() == e && a++
        }), $(this).html(a)
    });
    var n = 0, c = $("." + s + "  .item_" + t + " .lz_table_con td:first-child p:last ");
    c.css("font-weight", "bold");
    var d = setTimeout(function () {
        c.fadeOut(100).fadeIn(100), 1 == ++n && (d = setInterval(arguments.callee, 600)), 30 == n && window.clearInterval(d)
    }, 1e3)
}

function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(s) {
    var t = setTimeout("sendj()", 100), e = "";
    lilength == s.length - 1 && (e = "li_after", clearTimeout(t), lilength = 0), $("#jnumber").append("<li class='nub" + s[lilength] + " " + e + "'></li>"), lilength++
}

function listData() {
    $("#tabdsdxcl").find("span[class*='xxselected']").find("i").text();
    var s = $("#tabdsdxcl").find("span[class*='xxselected']").find("i").attr("title");
    $("#tabdsdxcl").find("span[class*='xxselected']").find("i").text();
    0 == s ? $("#dxdsmc").find("li[class*='checked']").find("span").text() : $("#lhmc").find("li[class*='checked']").find("span").text(), $.ajax({
        url: urlbublic + "CQShiCai/queryCQShiCaiTrendCount.do",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (s) {
            createHtmlList(s)
        },
        error: function (s) {
            setTimeout(function () {
                loadotherData()
            }, config.listTime), config.ifdebug
        }
    })
}

function parseTonum(s) {
    return 1 * s.charAt(0) <= 0 ? s.charAt(1) : s
}

function loadTodayData(s) {
}

function minci(s, t) {
    if ("rank" == t) switch (1 * s) {
        case 1:
            return "冠军";
        case 2:
            return "亚军";
        case 3:
            return "三";
        case 4:
            return "四";
        case 5:
            return "五";
        case 6:
            return "六";
        case 7:
            return "七";
        case 8:
            return "八";
        case 9:
            return "九";
        case 10:
            return "十";
        case 11:
            return "冠亚和"
    } else if ("state" == t) switch (1 * s) {
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
            return "虎"
    }
}

function loadLongData(s) {
    "object" != (void 0 === s ? "undefined" : _typeof(s)) ? data = JSON.parse(s) : (data = JSON.stringify(s), data = JSON.parse(data)), data = data.result.data, $("#cltxul").html("");
    for (var t = 0, e = data.length; t < e; t++) {
        var a = minci(data[t].rank, "rank"), i = minci(data[t].state, "state"),
            l = data[t].count >= 5 ? "<span style='color:#f11821'>" + data[t].count + "</span>" : "<span>" + data[t].count + "</span>",
            n = "<li>第<span>" + a + "</span>名：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>";
        11 != data[t].rank && 1 != data[t].rank && 2 != data[t].rank || (n = "<li><span>" + a + "</span>：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>"), $("#cltxul").append(n)
    }
}

function excuteAnimate(s, t) {
    var t = t, e = (s = s).length, a = 0, i = $(t);
    $(i).html("");
    var l = setInterval(function () {
        if (a < e) {
            var t = "<li class='nub" + s[a] + "'><i style='font-size:10px'>" + s[a] + "</i></li>";
            $(i).append(t), a++
        } else clearInterval(l)
    }, 100)
}

function clearinterval(s) {
    clearInterval(intervalPk10)
}

function zhmsMcMethod(s, t) {
    var e = $(t);
    if ("all" == s) (zhmssxmc = []).length >= 10 || $($("#zhms").find(".sinli")).each(function (s) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (zhmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }); else if ("zhclear" == s) $($("#zhms").find(".sinli")).each(function (s) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), zhmssxmc = [])
    }); else if ("zhchecksing" == s) {
        var a = e.find("i").text();
        if (config.ifdebug, e.removeClass("hoverli"), e.hasClass("checked")) {
            e.removeClass("checked");
            for (var i = 0, l = zhmssxmc.length; i < l; i++) zhmssxmc[i] == a && zhmssxmc.splice(i, 1)
        } else if (e.addClass("hoverli"), e.addClass("checked"), zhmssxmc.length <= 0) zhmssxmc.push(a); else {
            for (var i = 0, l = zhmssxmc.length; i < l && zhmssxmc[i] != a; i++) ;
            zhmssxmc.push(a)
        }
        config.ifdebug
    }
    config.ifdebug, excuteZhmsSelect(zhmssxmc, zhmssxlz)
}

function zhmsLzMethod(s, t) {
    if ("all" == s) (zhmssxlz = []).length >= 10 || $($("#zhms .zhmslz").find(".lztype")).each(function (s) {
        zhmssxlz.push($(this).find("i").text()), $(this).addClass("checked")
    }); else {
        var e = $(t), a = e.find("i").text();
        if (e.removeClass("hoverli"), e.hasClass("checked")) {
            e.removeClass("checked");
            for (var i = 0, l = zhmssxlz.length; i < l; i++) zhmssxlz[i] == a && zhmssxlz.splice(i, 1)
        } else if (e.addClass("hoverli"), e.addClass("checked"), zhmssxlz.length <= 0) zhmssxlz.push(a); else {
            for (var i = 0, l = zhmssxlz.length; i < l && zhmssxlz[i] != a; i++) ;
            zhmssxlz.push(a)
        }
        config.ifdebug
    }
    excuteZhmsSelect(zhmssxmc, zhmssxlz)
}

function dxmsLzMethod(s, t) {
    if ("all" != s) {
        var e = $(t), a = e.find("i").text();
        if (config.ifdebug, e.removeClass("hoverli"), e.hasClass("checked")) {
            e.removeClass("checked");
            for (var i = 0, l = dxmssxlz.length; i < l; i++) dxmssxlz[i] == a && dxmssxlz.splice(i, 1)
        } else if (e.addClass("hoverli"), e.addClass("checked"), dxmssxlz.length <= 0) dxmssxlz.push(a); else {
            for (var i = 0, l = dxmssxlz.length; i < l && dxmssxlz[i] != a; i++) ;
            dxmssxlz.push(a)
        }
        config.ifdebug, excuteZhmsSelect(dxmssxmc, dxmssxlz)
    } else $("#dxms .lztype").each(function (s) {
        dxmssxlz.push($(this).find("i").text()), $(this).addClass("checked")
    })
}

function dxmsMcMethod(s, t) {
    if (dxmssxmc = [], "all" == s) {
        var e = $("#dxms .xuanzhemc li:nth-child(2) span");
        return dxmssxmc.push(e.text()), e.parent().addClass("selected"), void excuteZhmsSelect(dxmssxmc, dxmssxlz)
    }
    var a = $(t), i = a.find("span").text();
    config.ifdebug, a.siblings().removeClass("selected"), a.removeClass("hoverli"), a.addClass("selected"), dxmssxmc.push(i), config.ifdebug, excuteZhmsSelect(dxmssxmc, dxmssxlz)
}

function lmmsMcMethod(s, t) {
    var e = $(t);
    if (e.removeClass("hoverli"), "all" == s) (lmmssxmc = []).length >= 10 || $($("#lmms").find(".sinli")).each(function (s) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (lmmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }), config.ifdebug; else if ("zhclear" == s) $($("#lmms").find(".sinli")).each(function (s) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), lmmssxmc = [])
    }); else if ("zhchecksing" == s) {
        var a = e.find("i").text();
        if (e.hasClass("checked")) {
            e.removeClass("checked");
            for (var i = 0, l = lmmssxmc.length; i < l; i++) lmmssxmc[i] == a && lmmssxmc.splice(i, 1)
        } else if (e.addClass("hoverli"), e.addClass("checked"), lmmssxmc.length <= 0) lmmssxmc.push(a); else {
            for (var i = 0, l = lmmssxmc.length; i < l && lmmssxmc[i] != a; i++) ;
            lmmssxmc.push(a)
        }
    }
    config.ifdebug, excuteZhmsSelect(lmmssxmc, lmmssxlz)
}

function lmmsLzMethod(s, t) {
    if ("all" == s) {
        var e = $("#lmms>.xuanzhemc .lztype:nth-child(2)");
        e.html();
        return lmmssxlz.push(e.find("span").text()), e.addClass("selected"), void excuteZhmsSelect(lmmssxmc, lmmssxlz)
    }
    var a = $(t);
    a.removeClass("hoverli");
    var i = a.find("span").text();
    config.ifdebug, a.siblings().removeClass("selected"), a.addClass("selected"), (lmmssxlz = []).push(i), config.ifdebug, excuteZhmsSelect(lmmssxmc, lmmssxlz)
}

function excuteZhmsSelect(s, t) {
    for (var e = [], a = 0, i = s.length; a < i; a++) for (var l = 0, n = t.length; l < n; l++) if (s[a] >= 6) {
        if (t[l] > 2) continue;
        e.push(s[a] + "" + t[l])
    } else e.push(s[a] + "" + t[l]);
    config.ifdebug, $(".box .item").hide(), $(e).each(function (s) {
        $("#box" + e[s]).show()
    })
}

function dxmsMethod() {
    $($("#zhms").find("li")).each(function (s) {
        config.ifdebug
    })
}

function lmmsMethod() {
    $($("#zhms").find("li")).each(function (s) {
        config.ifdebug
    })
}

function typeOf(s, t) {
    if ("rank" == t) switch (1 * s) {
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
    } else switch (1 * s) {
        case 1:
            return "单双";
        case 2:
            return "大小";
        case 3:
            return "龙虎"
    }
}

function createHtmlList(s) {
    var t = null;
    "object" != (void 0 === s ? "undefined" : _typeof(s)) ? t = JSON.parse(s) : (t = JSON.stringify(s), t = JSON.parse(t)), forRank(t.result.data)
}

function forRank(s) {
    $("#table_cltj>tbody").empty();
    $(s).each(function (s) {
        var t = "";
        this.code, this.code;
        t += "<td>" + s + "</td>";
        var e = this.list;
        $(e).each(function (b) {
            t += "<td>" + Math.abs(this.accumulate) + "</td>"+"<td>" + Math.abs(this.liankai) + "</td>"+"<td>" + Math.abs(this.missing) + "</td>"+"<td>" + Math.abs(this.maxmissing) + "</td>";
        });
        $("#table_cltj>tbody").append("<tr>" + t + "</tr>")
    })
}

function boxList(s, t) {
    var e = "";
    return 1 == s && 1 == t.state ? e = "" + s + t.state : 1 == s && 2 == t.state ? e = "" + s + t.state : 1 == s && 3 == t.state ? e = "" + s + t.state : 2 == s && 1 == t.state ? e = "" + s + t.state : 2 == s && 2 == t.state ? e = "" + s + t.state : 2 == s && 3 == t.state ? e = "" + s + t.state : 3 == s && 1 == t.state ? e = "" + s + t.state : 3 == s && 2 == t.state ? e = "" + s + t.state : 3 == s && 3 == t.state ? e = "" + s + t.state : 4 == s && 1 == t.state ? e = "" + s + t.state : 4 == s && 2 == t.state ? e = "" + s + t.state : 4 == s && 3 == t.state ? e = "" + s + t.state : 5 == s && 1 == t.state ? e = "" + s + t.state : 5 == s && 2 == t.state ? e = "" + s + t.state : 5 == s && 3 == t.state && (e = "" + s + t.state), e
}

function forRankYibu(s, t) {
    var e = $("#box" + boxList(s, t)), a = "", i = "", l = e.find(".tablebox td:nth-child(1) p:last-child").text();
    e.find(".tablebox td:nth-child(1) p:last-child").css({"font-weight": "normal"});
    var n = t.state, c = "";
    "1" == n ? c = 1 == t.value ? "单" : "双" : "2" == n ? c = 1 == t.value ? "大" : "小" : "3" == n && (c = 1 == t.value ? "龙" : "虎"), "双" != c && "龙" != c && "大" != c || (i = "style='color:#f1020b'");
    var d = e.find(".left_count"), h = e.find(".right_count"), o = 1 * d.text() + 1, r = 1 * h.text() + 1;
    if ("单" == c ? d.text(o) : "双" == c ? h.text(r) : "大" == c ? d.text(o) : "小" == c ? h.text(r) : "龙" == c ? d.text(o) : "虎" == c && h.text(r), l == c) a = "<p  " + i + ">" + l + "</p>", e.find(".tablebox td:nth-child(1)").append(a); else {
        var m = "";
        e.find(".tablebox td:nth-child(1)").hasClass("bgcolor") || (m = "bgcolor"), a = "<td class='" + m + "'><p " + i + ">" + c + "</p></td>", "" == l ? e.find(".tablebox").append(a) : e.find(".tablebox td:nth-child(1)").before(a)
    }
    bgPostionX(e);
    var f = 0, u = e.find(".tablebox td:nth-child(1) p:last-child");
    u.css({"font-weight": "bold"});
    var x = setTimeout(function () {
        u.fadeOut(100).fadeIn(100), 1 == ++f && (x = setInterval(arguments.callee, 600)), 30 == f && window.clearInterval(x)
    }, 1e3)
}

function loadotherData(s) {
    listData(s)
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (s) {
    return typeof s
} : function (s) {
    return s && "function" == typeof Symbol && s.constructor === Symbol && s !== Symbol.prototype ? "symbol" : typeof s
};
$(function () {
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#tabdsdxcl").find("span").live("click", function () {
        $(this).siblings().removeClass("xxselected"), $(this).addClass("xxselected");
        var s = $(this).find("i").attr("title");
        "0" == s ? ($("#dxdsmc").show(200), $("#lhmc").hide(200)) : "1" == s && ($("#dxdsmc").hide(200), $("#lhmc").show(200)), listData()
    }), $("#lhmc").find(".sinli").live("click", function () {
        $(this).siblings().removeClass("checked"), $(this).addClass("checked"), listData()
    }), $("#dxdsmc").find(".sinli").live("click", function () {
        $(this).siblings().removeClass("checked"), $(this).addClass("checked"), listData()
    }), $(".listheadrl span").live("click", function () {
        $(this).siblings().removeClass("checked"), $(this).addClass("checked");
        var s = $(this).attr("id");
        "today" == s ? listData(getDateStr(0)) : "yesterday" == s ? listData(getDateStr(-1)) : "qianday" == s && listData(getDateStr(-2))
    }), $("#daxiaodsfb").delegate("li", "click", function () {
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    }), $("#datebox").calendar({
        trigger: "#date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (s, t, e) {
            var a = (t = formatDate(t)).split("-");
            checkseletime(a), listData(t), config.ifdebug
        }, onClose: function (s, t, e) {
            config.ifdebug
        }
    }), $("#btn1").live("click", function () {
        $(this).hasClass("sa2") ? ($("#sid2").hide("200"), $("#sid3").hide("200"), $(this).removeClass("sa2")) : ($("#sid2").show("200"), $(this).addClass("sa2"))
    }), $("#btn2").live("click", function () {
        $(this).hasClass("sa2") ? ($("#sid3").hide("200"), $(this).removeClass("sa2")) : ($("#sid3").show("200"), $(this).addClass("sa2"))
    }), $("#changedata").live("click", function () {
        choseNum()
    }), $("#colorSet").find(".spanAdd2").live("click", function () {
        choseNum()
    })
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var localllistdata = {}, localheaddata = {}, intervalPk10 = null, zhmssxmc = [], zhmssxlz = [], dxmssxlz = [],
    dxmssxmc = [], lmmssxmc = [], lmmssxlz = [];