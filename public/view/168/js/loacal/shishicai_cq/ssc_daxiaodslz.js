function formatDate(t) {
    t.getFullYear();
    var e = t.getMonth() + 1;
    e = e < 10 ? "0" + e : e;
    var s = t.getDate();
    s = s < 10 ? "0" + s : s
}

function tongjiCount(t) {
    var e = $(t), s = e.parent().find(".txtNum").val(), a = e.parent().find(".secType").val(),
        l = e.parent().parent().find(".ifds").text(), i = "";
    "单双" == l ? i = 1 == a ? "单" : "双" : "大小" == l ? i = 1 == a ? "大" : "小" : "龙虎" == l && (i = 1 == a ? "龙" : "虎"), e.parent().parent().parent().parent().parent().find(".tablebox").html();
    var n = 0;
    e.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var e = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), e >= s && i == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), n += 1)
    }), e.parent().parent().find(".sec_count").text(n)
}

function doCheck(t, e) {
    var s = $("." + t + "  .item_" + e + " .lz_table_head td .txtNum").val(),
        a = $("." + t + "  .item_" + e + " .lz_table_head td .secType").val(), l = Number("0" + s), i = 0;
    $("." + t + "  .item_" + e + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == a && $(this).children("p").length >= l && ($(this).removeAttr("style"), $(this).addClass("shaw"), i++)
    }), $("." + t + "  .item_" + e + " .lz_table_head td .sec_count").html(i), $("." + t + "  .item_" + e + "  .lz_table_head td .count").each(function () {
        var s = $(this).attr("data"), a = 0;
        $("." + t + "  .item_" + e + " .lz_table_con td p").each(function () {
            $(this).html() == s && a++
        }), $(this).html(a)
    });
    var n = 0, c = $("." + t + "  .item_" + e + " .lz_table_con td:first-child p:last ");
    c.css("font-weight", "bold");
    var o = setTimeout(function () {
        c.fadeOut(100).fadeIn(100), 1 == ++n && (o = setInterval(arguments.callee, 600)), 30 == n && window.clearInterval(o)
    }, 1e3)
}

function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(t) {
    var e = setTimeout("sendj()", 100), s = "";
    lilength == t.length - 1 && (s = "li_after", clearTimeout(e), lilength = 0), $("#jnumber").append("<li class='nub" + t[lilength] + " " + s + "'></li>"), lilength++
}

function excutek() {
    for (var t = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], e = 0, s = t.length; e < s; e++) {
        var a = Math.floor(Math.random() * t.length);
        res[e] = t[a], t.splice(a, 1)
    }
    for (var l = 0, s = jnumber.length; l < s; l++) jnumber[l].className = "nub" + res[l], l == s - 1 && (jnumber[l].style.marginRight = "0");
    time++;
    var i = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(i), $("#jnumber").html("");
        sendj()
    }
}

function ajaxRequst(t) {
}

function listData(t) {
    var e = void 0 == t ? null : "date=" + t;
    $.ajax({
        url: urlbublic + "CQShiCai/queryComprehensiveRoadBead.do?" + e,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            createHtmlList(t)
        },
        error: function (t) {
            setTimeout(function () {
                loadotherData()
            }, config.listTime), config.ifdebug
        }
    })
}

function repeatGetData(t) {
    $.ajax({
        url: urlbublic + "pks/getRoadBeadStateByIssue.do?preIssue=" + t,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            createHtmlGetData(t)
        },
        error: function (t) {
            config.ifdebug
        }
    })
}

function parseTonum(t) {
    return 1 * t.charAt(0) <= 0 ? t.charAt(1) : t
}

function loadTodayData(t) {
}

function minci(t, e) {
    if ("rank" == e) switch (1 * t) {
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
    } else if ("state" == e) switch (1 * t) {
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

function loadLongData(t) {
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), data = data.result.data, $("#cltxul").html("");
    for (var e = 0, s = data.length; e < s; e++) {
        var a = minci(data[e].rank, "rank"), l = minci(data[e].state, "state"),
            i = data[e].count >= 5 ? "<span style='color:#f11821'>" + data[e].count + "</span>" : "<span>" + data[e].count + "</span>",
            n = "<li>第<span>" + a + "</span>名：&nbsp;&nbsp;<span>" + l + "</span>&nbsp;&nbsp;" + i + "期</li>";
        11 != data[e].rank && 1 != data[e].rank && 2 != data[e].rank || (n = "<li><span>" + a + "</span>：&nbsp;&nbsp;<span>" + l + "</span>&nbsp;&nbsp;" + i + "期</li>"), $("#cltxul").append(n)
    }
}

function excuteAnimate(t, e) {
    var e = e, s = (t = t).length, a = 0, l = $(e);
    $(l).html("");
    var i = setInterval(function () {
        if (a < s) {
            var e = "<li class='nub" + t[a] + "'><i style='font-size:10px'>" + t[a] + "</i></li>";
            $(l).append(e), a++
        } else clearInterval(i)
    }, 100)
}

function getSystime() {
    var t = new Date, e = t.getFullYear(), s = t.getMonth() + 1, a = t.getDate();
    t.getDay(), t.getHours(), t.getMinutes(), t.getSeconds(), document.getElementById("Date");
    return e + "-" + s + "-" + a
}

function clearinterval(t) {
    clearInterval(intervalPk10)
}

function zhmsMcMethod(t, e) {
    var s = $(e);
    if ("all" == t) (zhmssxmc = []).length >= 10 || $($("#zhms").find(".sinli")).each(function (t) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (zhmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }); else if ("zhclear" == t) $($("#zhms").find(".sinli")).each(function (t) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), zhmssxmc = [])
    }); else if ("zhchecksing" == t) {
        var a = s.find("i").text();
        if (s.removeClass("hoverli"), s.hasClass("checked")) {
            s.removeClass("checked");
            for (var l = 0, i = zhmssxmc.length; l < i; l++) zhmssxmc[l] == a && zhmssxmc.splice(l, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), zhmssxmc.length <= 0) zhmssxmc.push(a); else {
            for (var l = 0, i = zhmssxmc.length; l < i && zhmssxmc[l] != a; l++) ;
            zhmssxmc.push(a)
        }
        config.ifdebug
    }
    config.ifdebug, excuteZhmsSelect(zhmssxmc, zhmssxlz)
}

function zhmsLzMethod(t, e) {
    if ("all" == t) (zhmssxlz = []).length >= 10 || $($("#zhms .zhmslz").find(".lztype")).each(function (t) {
        zhmssxlz.push($(this).find("i").text()), $(this).addClass("checked")
    }); else {
        var s = $(e), a = s.find("i").text();
        if (s.removeClass("hoverli"), s.hasClass("checked")) {
            s.removeClass("checked");
            for (var l = 0, i = zhmssxlz.length; l < i; l++) zhmssxlz[l] == a && zhmssxlz.splice(l, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), zhmssxlz.length <= 0) zhmssxlz.push(a); else {
            for (var l = 0, i = zhmssxlz.length; l < i && zhmssxlz[l] != a; l++) ;
            zhmssxlz.push(a)
        }
        config.ifdebug
    }
    excuteZhmsSelect(zhmssxmc, zhmssxlz)
}

function dxmsLzMethod(t, e) {
    if ("all" == t) return $("#dxms .lztype").each(function (t) {
        dxmssxlz.push($(this).find("i").text()), $(this).addClass("checked")
    }), void excuteZhmsSelect(dxmssxmc, dxmssxlz);
    var s = $(e), a = s.find("i").text();
    if (config.ifdebug, s.removeClass("hoverli"), s.hasClass("checked")) {
        s.removeClass("checked");
        for (var l = 0, i = dxmssxlz.length; l < i; l++) dxmssxlz[l] == a && dxmssxlz.splice(l, 1)
    } else if (s.addClass("hoverli"), s.addClass("checked"), dxmssxlz.length <= 0) dxmssxlz.push(a); else {
        for (var l = 0, i = dxmssxlz.length; l < i && dxmssxlz[l] != a; l++) ;
        dxmssxlz.push(a)
    }
    config.ifdebug, excuteZhmsSelect(dxmssxmc, dxmssxlz)
}

function dxmsMcMethod(t, e) {
    if (dxmssxmc = [], "all" == t) {
        var s = $("#dxms .xuanzhemc li:nth-child(2) span");
        return dxmssxmc.push(s.text()), s.parent().addClass("selected"), void excuteZhmsSelect(dxmssxmc, dxmssxlz)
    }
    var a = $(e), l = a.find("span").text();
    config.ifdebug, a.siblings().removeClass("selected"), a.removeClass("hoverli"), a.addClass("selected"), dxmssxmc.push(l), config.ifdebug, excuteZhmsSelect(dxmssxmc, dxmssxlz)
}

function lmmsMcMethod(t, e) {
    var s = $(e);
    if (s.removeClass("hoverli"), "all" == t) (lmmssxmc = []).length >= 10 || $($("#lmms").find(".sinli")).each(function (t) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (lmmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }), config.ifdebug; else if ("zhclear" == t) $($("#lmms").find(".sinli")).each(function (t) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), lmmssxmc = [])
    }); else if ("zhchecksing" == t) {
        var a = s.find("i").text();
        if (s.hasClass("checked")) {
            s.removeClass("checked");
            for (var l = 0, i = lmmssxmc.length; l < i; l++) lmmssxmc[l] == a && lmmssxmc.splice(l, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), lmmssxmc.length <= 0) lmmssxmc.push(a); else {
            for (var l = 0, i = lmmssxmc.length; l < i && lmmssxmc[l] != a; l++) ;
            lmmssxmc.push(a)
        }
    }
    config.ifdebug, excuteZhmsSelect(lmmssxmc, lmmssxlz)
}

function lmmsLzMethod(t, e) {
    if ("all" == t) {
        var s = $("#lmms>.xuanzhemc .lztype:nth-child(2)");
        s.html();
        return lmmssxlz.push(s.find("span").text()), s.addClass("selected"), void excuteZhmsSelect(lmmssxmc, lmmssxlz)
    }
    var a = $(e);
    a.removeClass("hoverli");
    var l = a.find("span").text();
    config.ifdebug, a.siblings().removeClass("selected"), a.addClass("selected"), (lmmssxlz = []).push(l), config.ifdebug, excuteZhmsSelect(lmmssxmc, lmmssxlz)
}

function excuteZhmsSelect(t, e) {
    for (var s = [], a = 0, l = t.length; a < l; a++) for (var i = 0, n = e.length; i < n; i++) t[a], s.push(t[a] + "" + e[i]);
    config.ifdebug, $(".box .item").hide(), $(s).each(function (t) {
        $("#box" + s[t]).show()
    })
}

function dxmsMethod() {
    $($("#zhms").find("li")).each(function (t) {
        config.ifdebug
    })
}

function lmmsMethod() {
    $($("#zhms").find("li")).each(function (t) {
        config.ifdebug
    })
}

function createHtmlList(t) {
    var e = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e));
    var s = e.result.data;
    tools.toggleNoTodayOpenTip({
        data: s, nextCb: function (t) {
            $(t).each(function (e) {
                forRank(t[e].rank, t[e])
            })
        }, contentClass: ".listcontent .box", insertClass: ".listcontent"
    })
}

function createHtmlGetData(t) {
    config.ifdebug;
    var e = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e));
    var s = e.result.data;
    $(s).each(function (t) {
        forRankYibu(s[t].rank, s[t])
    })
}

function bgPostionX(t) {
    t.find(".tablebox td").length % 2 != 0 ? t.find(".item_con").css({"background-positionX": "0"}) : t.find(".item_con").css({"background-positionX": "-29px"})
}

function forRank(t, e) {
    var s = $("#box" + boxList(t, e));
    s.find(".left_count").text(e.totals[0]), s.find(".right_count").text(e.totals[1]), s.find(".ifgj").text(typeOf("qiu", e.rank)), s.find(".ifds").text(typeOf("state", e.state));
    var a = "";
    s.find(".tablebox").empty();
    var l = e.roadBeads.length - jsCode.count;
    $(e.roadBeads).each(function (t) {
        if (!(t < l && -1 != $.inArray(lotCode, jsCode.code))) {
            var i = "", n = s.find(".tablebox td:nth-child(1) p:last-child").text();
            s.find(".tablebox td:nth-child(1) p:last-child").css({"font-weight": "normal"});
            var c = e.state, o = "";
            if ("1" == c ? o = 1 == e.roadBeads[t] ? "单" : "双" : "2" == c ? o = 1 == e.roadBeads[t] ? "大" : "小" : "3" == c && (o = 1 == e.roadBeads[t] ? "龙" : "虎"), "双" != o && "龙" != o && "大" != o || (i = "style='color:#f1020b'"), n == o) a = "<p  " + i + ">" + n + "</p>", s.find(".tablebox td:nth-child(1)").append(a); else {
                var h = "";
                s.find(".tablebox td:nth-child(1)").hasClass("bgcolor") || (h = "bgcolor"), a = "<td class='" + h + "'><p " + i + ">" + o + "</p></td>", "" == n ? s.find(".tablebox").append(a) : s.find(".tablebox td:nth-child(1)").before(a)
            }
        }
    }), bgPostionX(s);
    var i = 0, n = s.find(".tablebox td:nth-child(1) p:last-child");
    n.css({"font-weight": "bold"});
    var c = setTimeout(function () {
        n.fadeOut(100).fadeIn(100), 1 == ++i && (c = setInterval(arguments.callee, 600)), 30 == i && window.clearInterval(c)
    }, 1e3)
}

function boxList(t, e) {
    var s = "";
    return 1 == t && 1 == e.state ? s = "" + t + e.state : 1 == t && 2 == e.state ? s = "" + t + e.state : 1 == t && 3 == e.state ? s = "" + t + e.state : 2 == t && 1 == e.state ? s = "" + t + e.state : 2 == t && 2 == e.state ? s = "" + t + e.state : 2 == t && 3 == e.state ? s = "" + t + e.state : 3 == t && 1 == e.state ? s = "" + t + e.state : 3 == t && 2 == e.state ? s = "" + t + e.state : 3 == t && 3 == e.state ? s = "" + t + e.state : 4 == t && 1 == e.state ? s = "" + t + e.state : 4 == t && 2 == e.state ? s = "" + t + e.state : 4 == t && 3 == e.state ? s = "" + t + e.state : 5 == t && 1 == e.state ? s = "" + t + e.state : 5 == t && 2 == e.state ? s = "" + t + e.state : 5 == t && 3 == e.state ? s = "" + t + e.state : 6 == t && 1 == e.state ? s = "" + t + e.state : 6 == t && 2 == e.state ? s = "" + t + e.state : 7 == t && 1 == e.state ? s = "" + t + e.state : 7 == t && 2 == e.state ? s = "" + t + e.state : 8 == t && 1 == e.state ? s = "" + t + e.state : 8 == t && 2 == e.state ? s = "" + t + e.state : 9 == t && 1 == e.state ? s = "" + t + e.state : 9 == t && 2 == e.state ? s = "" + t + e.state : 10 == t && 1 == e.state ? s = "" + t + e.state : 10 == t && 2 == e.state ? s = "" + t + e.state : 11 == t && 1 == e.state ? s = "" + t + e.state : 11 == t && 2 == e.state ? s = "" + t + e.state : 12 == t && 3 == e.state && (s = "" + t + e.state), s
}

function forRankYibu(t, e) {
    var s = $("#box" + boxList(t, e)), a = "", l = "", i = s.find(".tablebox td:nth-child(1) p:last-child").text();
    s.find(".tablebox td:nth-child(1) p:last-child").css({"font-weight": "normal"});
    var n = e.state, c = "";
    "1" == n ? c = 1 == e.value ? "单" : "双" : "2" == n ? c = 1 == e.value ? "大" : "小" : "3" == n && (c = 1 == e.value ? "龙" : "虎"), "双" != c && "龙" != c && "大" != c || (l = "style='color:#f1020b'");
    var o = s.find(".left_count"), h = s.find(".right_count"), d = 1 * o.text() + 1, r = 1 * h.text() + 1;
    if ("单" == c ? o.text(d) : "双" == c ? h.text(r) : "大" == c ? o.text(d) : "小" == c ? h.text(r) : "龙" == c ? o.text(d) : "虎" == c && h.text(r), i == c) a = "<p  " + l + ">" + i + "</p>", s.find(".tablebox td:nth-child(1)").append(a); else {
        var m = "";
        s.find(".tablebox td:nth-child(1)").hasClass("bgcolor") || (m = "bgcolor"), a = "<td class='" + m + "'><p " + l + ">" + c + "</p></td>", "" == i ? s.find(".tablebox").append(a) : s.find(".tablebox td:nth-child(1)").before(a)
    }
    bgPostionX(s);
    var f = 0, u = s.find(".tablebox td:nth-child(1) p:last-child");
    u.css({"font-weight": "bold"});
    var x = setTimeout(function () {
        u.fadeOut(100).fadeIn(100), 1 == ++f && (x = setInterval(arguments.callee, 600)), 30 == f && window.clearInterval(x)
    }, 1e3)
}

function loadotherData() {
    listData(""), $(".listheadrl span").siblings().removeClass("checked"), $("#today").addClass("checked"), $(".jinri").text("今天")
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    config.formatDate();
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    });
    var t = "";
    $(".listheadl").find("span").live("click", function () {
        $(this).siblings().removeClass("xxselected"), $(this).addClass("xxselected");
        var e = $(this).find("i").text();
        "1" == e ? (t = "1", $("#dxms,#lmms").hide(200), $("#zhms").show(200), excuteZhmsSelect(zhmssxmc, zhmssxlz)) : "2" == e ? (t = "1", $("#zhms,#lmms").hide(200), $("#dxms").show(200), excuteZhmsSelect(dxmssxmc, dxmssxlz)) : "3" == e && (t = "3", $("#dxms,#zhms").hide(200), $("#lmms").show(200), excuteZhmsSelect(lmmssxmc, lmmssxlz))
    }), $(".zhclear").live("click", function () {
        zhmsMcMethod("zhclear", this)
    }), $(".zhcheckall").live("click", function () {
        zhmsMcMethod("all", this)
    }), $("#zhms li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $("#zhms .sinli").live("click", function () {
        zhmsMcMethod("zhchecksing", this)
    }), $("#zhms .zhmslz .lztype").live("click", function () {
        zhmsLzMethod("zhchecksing", this)
    }), $("#dxms li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $("#dxms .lztype").live("click", function () {
        dxmsLzMethod("", this)
    }), $("#dxms .sinli").live("click", function () {
        dxmsMcMethod("", this)
    }), $("#lmms .zhclear").live("click", function () {
        lmmsMcMethod("zhclear", this)
    }), $("#lmms .zhcheckall").live("click", function () {
        lmmsMcMethod("all", this)
    }), $("#lmms li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $("#lmms .sinli").live("click", function () {
        lmmsMcMethod("zhchecksing", this)
    }), $("#lmms .lztype").live("click", function () {
        lmmsLzMethod("zhchecksing", this)
    }), $("#kaijiangjl").delegate("li", "click", function () {
        var t = $(this).attr("id");
        if ($(this).hasClass("selected")) $(this).removeClass("selected"), "jrsmtj" == t ? $("." + t).hide("200") : "cltx" == t ? $("." + t).hide("200") : "hmfb" == t && ($("." + t).hide("100"), $("." + t).animate({opacity: "0"}, 200)); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).addClass("selected"), "jrsmtj" == t ? $("." + t).show("200") : "cltx" == t ? $("." + t).show("200") : "hmfb" == t && ($("." + t).show("100"), $("." + t).animate({opacity: "1"}, 200))
        }
    });
    $("#chakanchfb").delegate("li", "click", function () {
    });
    $(".box .btnCheck").live("click", function () {
        tongjiCount($(this))
    }), $("#daxiaodsfb").delegate("li", "click", function () {
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    }), $("#datebox").calendar({
        trigger: "#date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (t, e, s) {
            listData(e = config.formatDate(e)), config.ifdebug;
            var a = e.split("-");
            checkseletime(a);
            var l = parseInt(a[1]) + "/" + parseInt(a[2]);
            $(".now_l").css("display", "none"), $(".jinri").css("display", "inline-block").text(l)
        }, onClose: function (t, e, s) {
            config.ifdebug
        }
    }), dxmsMcMethod("all", $("#dxms").find(".selected")), dxmsLzMethod("all", $("#dxms").find(".checked"))
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var localllistdata = {}, localheaddata = {}, intervalPk10 = null, zhmssxmc = [], zhmssxlz = [], dxmssxlz = [],
    dxmssxmc = [], lmmssxmc = [], lmmssxlz = [];