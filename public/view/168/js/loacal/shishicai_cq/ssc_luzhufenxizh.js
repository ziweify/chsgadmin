function formatDate(e) {
    var t = e.getFullYear(), s = e.getMonth() + 1;
    s = s < 10 ? "0" + s : s;
    var l = e.getDate();
    return l = l < 10 ? "0" + l : l, t + "-" + s + "-" + l
}

function tongjiCount(e) {
    var t = $(e), s = t.parent().find(".txtNum").val(), l = t.parent().find(".secType").val(),
        a = t.parent().parent().find(".ifds").text(), i = "";
    "单双" == a ? i = 1 == l ? "单" : "双" : "大小" == a ? i = 1 == l ? "大" : "小" : "龙虎" == a && (i = 1 == l ? "龙" : "虎"), t.parent().parent().parent().parent().parent().find(".tablebox").html();
    var n = 0;
    t.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (e) {
        var t = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), t >= s && i == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), n += 1)
    }), t.parent().parent().find(".sec_count").text(n)
}

function doCheck(e, t) {
    var s = $("." + e + "  .item_" + t + " .lz_table_head td .txtNum").val(),
        l = $("." + e + "  .item_" + t + " .lz_table_head td .secType").val(), a = Number("0" + s), i = 0;
    $("." + e + "  .item_" + t + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == l && $(this).children("p").length >= a && ($(this).removeAttr("style"), $(this).addClass("shaw"), i++)
    }), $("." + e + "  .item_" + t + " .lz_table_head td .sec_count").html(i), $("." + e + "  .item_" + t + "  .lz_table_head td .count").each(function () {
        var s = $(this).attr("data"), l = 0;
        $("." + e + "  .item_" + t + " .lz_table_con td p").each(function () {
            $(this).html() == s && l++
        }), $(this).html(l)
    });
    var n = 0, c = $("." + e + "  .item_" + t + " .lz_table_con td:first-child p:last ");
    c.css("font-weight", "bold");
    var h = setTimeout(function () {
        c.fadeOut(100).fadeIn(100), 1 == ++n && (h = setInterval(arguments.callee, 600)), 30 == n && window.clearInterval(h)
    }, 1e3)
}

function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(e) {
    var t = setTimeout("sendj()", 100), s = "";
    lilength == e.length - 1 && (s = "li_after", clearTimeout(t), lilength = 0), $("#jnumber").append("<li class='nub" + e[lilength] + " " + s + "'></li>"), lilength++
}

function excutek() {
    for (var e = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], t = 0, s = e.length; t < s; t++) {
        var l = Math.floor(Math.random() * e.length);
        res[t] = e[l], e.splice(l, 1)
    }
    for (var a = 0, s = jnumber.length; a < s; a++) jnumber[a].className = "nub" + res[a], a == s - 1 && (jnumber[a].style.marginRight = "0");
    time++;
    var i = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(i), $("#jnumber").html("");
        sendj()
    }
}

function listData(e) {
    var t = void 0 == e ? null : "date=" + e;
    $.ajax({
        url: urlbublic + "CQShiCai/queryComprehensiveRoadBead.do?" + t,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (e) {
            createHtmlList(e)
        },
        error: function (e) {
            setTimeout(function () {
                loadotherData()
            }, config.listTime), config.ifdebug
        }
    })
}

function repeatGetData(e) {
    $.ajax({
        url: urlbublic + "pks/getRoadBeadStateByIssue.do?preIssue=" + e,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (e) {
            createHtmlGetData(e)
        },
        error: function (e) {
            config.ifdebug
        }
    })
}

function parseTonum(e) {
    return 1 * e.charAt(0) <= 0 ? e.charAt(1) : e
}

function loadTodayData(e) {
}

function minci(e, t) {
    if ("rank" == t) switch (1 * e) {
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
    } else if ("state" == t) switch (1 * e) {
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

function loadLongData(e) {
    "object" != (void 0 === e ? "undefined" : _typeof(e)) ? data = JSON.parse(e) : (data = JSON.stringify(e), data = JSON.parse(data)), data = data.result.data, $("#cltxul").html("");
    for (var t = 0, s = data.length; t < s; t++) {
        var l = minci(data[t].rank, "rank"), a = minci(data[t].state, "state"),
            i = data[t].count >= 5 ? "<span style='color:#f11821'>" + data[t].count + "</span>" : "<span>" + data[t].count + "</span>",
            n = "<li>第<span>" + l + "</span>名：&nbsp;&nbsp;<span>" + a + "</span>&nbsp;&nbsp;" + i + "期</li>";
        11 != data[t].rank && 1 != data[t].rank && 2 != data[t].rank || (n = "<li><span>" + l + "</span>：&nbsp;&nbsp;<span>" + a + "</span>&nbsp;&nbsp;" + i + "期</li>"), $("#cltxul").append(n)
    }
}

function excuteAnimate(e, t) {
    var t = t, s = (e = e).length, l = 0, a = $(t);
    $(a).html("");
    var i = setInterval(function () {
        if (l < s) {
            var t = "<li class='nub" + e[l] + "'><i style='font-size:10px'>" + e[l] + "</i></li>";
            $(a).append(t), l++
        } else clearInterval(i)
    }, 100)
}

function getSystime() {
    var e = new Date, t = e.getFullYear(), s = e.getMonth() + 1, l = e.getDate();
    e.getDay(), e.getHours(), e.getMinutes(), e.getSeconds(), document.getElementById("Date");
    return t + "-" + s + "-" + l
}

function clearinterval(e) {
    clearInterval(intervalPk10)
}

function zhmsMcMethod(e, t) {
    var s = $(t);
    if ("all" == e) (zhmssxmc = []).length >= 10 || $($("#zhms").find(".sinli")).each(function (e) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (zhmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }); else if ("zhclear" == e) $($("#zhms").find(".sinli")).each(function (e) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), zhmssxmc = [])
    }); else if ("zhchecksing" == e) {
        var l = s.find("i").text();
        if (config.ifdebug, s.removeClass("hoverli"), s.hasClass("checked")) {
            s.removeClass("checked");
            for (var a = 0, i = zhmssxmc.length; a < i; a++) zhmssxmc[a] == l && zhmssxmc.splice(a, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), zhmssxmc.length <= 0) zhmssxmc.push(l); else {
            for (var a = 0, i = zhmssxmc.length; a < i && zhmssxmc[a] != l; a++) ;
            zhmssxmc.push(l)
        }
        config.ifdebug
    }
    config.ifdebug, excuteZhmsSelect(zhmssxmc, zhmssxlz)
}

function zhlzlh() {
    var e = $(".listheadl").find(".xxselected").attr("class");
    if (-1 != e.indexOf("zhms")) {
        var t = $("#zhms ul").eq(0).find(".checked").eq(0).find("i").text(),
            s = $("#zhms ul").eq(1).find(".checked:last").find("i").text();
        1 == t && 3 == s ? $("#box123").show() : $("#box123").hide()
    } else if (-1 != e.indexOf("lmms")) {
        var t = $("#lmms ul").eq(0).find(".checked").eq(0).find("i").text(),
            s = $("#lmms ul").eq(1).find(".selected").find("span").text();
        1 == t && 3 == s ? $("#box123").show() : $("#box123").hide()
    }
}

function zhmsLzMethod(e, t) {
    if ("all" == e) (zhmssxlz = []).length >= 10 || $($("#zhms .zhmslz").find(".lztype")).each(function (e) {
        zhmssxlz.push($(this).find("i").text()), $(this).addClass("checked")
    }); else {
        var s = $(t), l = s.find("i").text();
        if (s.removeClass("hoverli"), s.hasClass("checked")) {
            s.removeClass("checked");
            for (var a = 0, i = zhmssxlz.length; a < i; a++) zhmssxlz[a] == l && zhmssxlz.splice(a, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), zhmssxlz.length <= 0) zhmssxlz.push(l); else {
            for (var a = 0, i = zhmssxlz.length; a < i && zhmssxlz[a] != l; a++) ;
            zhmssxlz.push(l)
        }
        config.ifdebug
    }
    excuteZhmsSelect(zhmssxmc, zhmssxlz)
}

function dxmsLzMethod(e, t) {
    if ("all" != e) {
        var s = $(t), l = s.find("i").text();
        if (config.ifdebug, s.removeClass("hoverli"), s.hasClass("checked")) {
            s.removeClass("checked");
            for (var a = 0, i = dxmssxlz.length; a < i; a++) dxmssxlz[a] == l && dxmssxlz.splice(a, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), dxmssxlz.length <= 0) dxmssxlz.push(l); else {
            for (var a = 0, i = dxmssxlz.length; a < i && dxmssxlz[a] != l; a++) ;
            dxmssxlz.push(l)
        }
        "dmchexkall" == e && (dxmssxlz = [], $("#dxms ul .lztype").each(function () {
            dxmssxlz.push($(this).find("i").text())
        })), config.ifdebug, excuteZhmsSelect(dxmssxmc, dxmssxlz)
    } else $("#dxms .lztype").each(function (e) {
        dxmssxlz.push($(this).find("i").text()), $(this).addClass("checked")
    })
}

function dxmsMcMethod(e, t) {
    if (dxmssxmc = [], "all" == e) {
        var s = $("#dxms .xuanzhemc li:nth-child(2) span");
        return dxmssxmc.push(s.text()), s.parent().addClass("selected"), void excuteZhmsSelect(dxmssxmc, dxmssxlz)
    }
    var l = $(t), a = l.find("span").text();
    l.siblings().removeClass("selected"), l.removeClass("hoverli"), l.addClass("selected"), dxmssxmc.push(a), config.ifdebug, excuteZhmsSelect(dxmssxmc, dxmssxlz)
}

function lmmsMcMethod(e, t) {
    var s = $(t);
    if (s.removeClass("hoverli"), "all" == e) (lmmssxmc = []).length >= 10 || $($("#lmms").find(".sinli")).each(function (e) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (lmmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }), config.ifdebug; else if ("zhclear" == e) $($("#lmms").find(".sinli")).each(function (e) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), lmmssxmc = [])
    }); else if ("zhchecksing" == e) {
        var l = s.find("i").text();
        if (s.hasClass("checked")) {
            s.removeClass("checked");
            for (var a = 0, i = lmmssxmc.length; a < i; a++) lmmssxmc[a] == l && lmmssxmc.splice(a, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), lmmssxmc.length <= 0) lmmssxmc.push(l); else {
            for (var a = 0, i = lmmssxmc.length; a < i && lmmssxmc[a] != l; a++) ;
            lmmssxmc.push(l)
        }
    }
    config.ifdebug, excuteZhmsSelect(lmmssxmc, lmmssxlz)
}

function lmmsLzMethod(e, t) {
    if ("all" == e) {
        var s = $("#lmms>.xuanzhemc .lztype:nth-child(2)");
        s.html();
        return lmmssxlz.push(s.find("span").text()), s.addClass("selected"), void excuteZhmsSelect(lmmssxmc, lmmssxlz)
    }
    var l = $(t);
    l.removeClass("hoverli");
    var a = l.find("span").text();
    config.ifdebug, l.siblings().removeClass("selected"), l.addClass("selected"), (lmmssxlz = []).push(a), config.ifdebug, excuteZhmsSelect(lmmssxmc, lmmssxlz)
}

function excuteZhmsSelect(e, t) {
    for (var s = [], l = 0, a = e.length; l < a; l++) for (var i = 0, n = t.length; i < n; i++) e[l], s.push(e[l] + "" + t[i]);
    config.ifdebug, $(".box .item").hide(), $(s).each(function (e) {
        $("#box" + s[e]).show()
    })
}

function dxmsMethod() {
    $($("#zhms").find("li")).each(function (e) {
        config.ifdebug
    })
}

function lmmsMethod() {
    $($("#zhms").find("li")).each(function (e) {
        config.ifdebug
    })
}

function createHtmlList(e) {
    var t = null;
    "object" != (void 0 === e ? "undefined" : _typeof(e)) ? t = JSON.parse(e) : (t = JSON.stringify(e), t = JSON.parse(t));
    var s = t.result.data;
    tools.toggleNoTodayOpenTip({
        data: s, nextCb: function (e) {
            $(e).each(function (t) {
                forRank(e[t].rank, e[t])
            })
        }, contentClass: ".listcontent .box", insertClass: ".listcontent"
    })
}

function createHtmlGetData(e) {
    config.ifdebug;
    var t = null;
    "object" != (void 0 === e ? "undefined" : _typeof(e)) ? t = JSON.parse(e) : (t = JSON.stringify(e), t = JSON.parse(t));
    var s = t.result.data;
    $(s).each(function (e) {
        forRankYibu(s[e].rank, s[e])
    })
}

function bgPostionX(e) {
    e.find(".tablebox td").length % 2 != 0 ? e.find(".item_con").css({"background-positionX": "0"}) : e.find(".item_con").css({"background-positionX": "-29px"})
}

function forRank(e, t) {
    var s = $("#box" + boxList(e, t));
    s.find(".left_count").text(t.totals[0]), s.find(".right_count").text(t.totals[1]), s.find(".total").text(t.totals[2]), s.find(".ifgj").text(typeOf("qiu", t.rank)), s.find(".ifds").text(typeOf("state", t.state));
    var l = "";
    s.find(".tablebox").empty();
    var a = t.roadBeads.length - jsCode.count;
    $(t.roadBeads).each(function (e) {
        if (!(e < a && -1 != $.inArray(lotCode, jsCode.code))) {
            var i = "", n = s.find(".tablebox td:nth-child(1) p:last-child").text();
            s.find(".tablebox td:nth-child(1) p:last-child").css({"font-weight": "normal"});
            var c = t.state, h = "";
            if ("1" == c ? h = 1 == t.roadBeads[e] ? "单" : "双" : "2" == c ? h = 1 == t.roadBeads[e] ? "大" : "小" : "3" == c && (h = 1 == t.roadBeads[e] ? "龙" : "虎", 2 == t.roadBeads[e] && (h = "和")), "双" != h && "龙" != h && "大" != h || (i = "style='color:#f1020b'"), n == h) l = "<p  " + i + ">" + n + "</p>", s.find(".tablebox td:nth-child(1)").append(l); else {
                var o = "";
                s.find(".tablebox td:nth-child(1)").hasClass("bgcolor") || (o = "bgcolor"), l = "<td class='" + o + "'><p " + i + ">" + h + "</p></td>", "" == n ? s.find(".tablebox").append(l) : s.find(".tablebox td:nth-child(1)").before(l)
            }
        }
    }), bgPostionX(s);
    var i = 0, n = s.find(".tablebox td:nth-child(1) p:last-child");
    n.css({"font-weight": "bold"});
    var c = setTimeout(function () {
        n.fadeOut(100).fadeIn(100), 1 == ++i && (c = setInterval(arguments.callee, 600)), 30 == i && window.clearInterval(c)
    }, 1e3)
}

function boxList(e, t) {
    var s = "";
    return 1 == e && 1 == t.state ? s = "" + e + t.state : 1 == e && 2 == t.state ? s = "" + e + t.state : 1 == e && 3 == t.state ? s = "" + e + t.state : 2 == e && 1 == t.state ? s = "" + e + t.state : 2 == e && 2 == t.state ? s = "" + e + t.state : 2 == e && 3 == t.state ? s = "" + e + t.state : 3 == e && 1 == t.state ? s = "" + e + t.state : 3 == e && 2 == t.state ? s = "" + e + t.state : 3 == e && 3 == t.state ? s = "" + e + t.state : 4 == e && 1 == t.state ? s = "" + e + t.state : 4 == e && 2 == t.state ? s = "" + e + t.state : 4 == e && 3 == t.state ? s = "" + e + t.state : 5 == e && 1 == t.state ? s = "" + e + t.state : 5 == e && 2 == t.state ? s = "" + e + t.state : 5 == e && 3 == t.state ? s = "" + e + t.state : 6 == e && 1 == t.state ? s = "" + e + t.state : 6 == e && 2 == t.state ? s = "" + e + t.state : 7 == e && 1 == t.state ? s = "" + e + t.state : 7 == e && 2 == t.state ? s = "" + e + t.state : 8 == e && 1 == t.state ? s = "" + e + t.state : 8 == e && 2 == t.state ? s = "" + e + t.state : 9 == e && 1 == t.state ? s = "" + e + t.state : 9 == e && 2 == t.state ? s = "" + e + t.state : 10 == e && 1 == t.state ? s = "" + e + t.state : 10 == e && 2 == t.state ? s = "" + e + t.state : 11 == e && 1 == t.state ? s = "" + e + t.state : 11 == e && 2 == t.state ? s = "" + e + t.state : 12 == e && 3 == t.state && (s = "" + e + t.state), s
}

function forRankYibu(e, t) {
    var s = $("#box" + boxList(e, t)), l = "", a = "", i = s.find(".tablebox td:nth-child(1) p:last-child").text();
    s.find(".tablebox td:nth-child(1) p:last-child").css({"font-weight": "normal"});
    var n = t.state, c = "";
    "1" == n ? c = 1 == t.value ? "单" : "双" : "2" == n ? c = 1 == t.value ? "大" : "小" : "3" == n && (c = 1 == t.value ? "龙" : "虎", 2 == t.value && (c = "和")), "双" != c && "龙" != c && "大" != c || (a = "style='color:#f1020b'");
    var h = s.find(".left_count"), o = s.find(".right_count"), d = 1 * h.text() + 1, r = 1 * o.text() + 1;
    if ("单" == c ? h.text(d) : "双" == c ? o.text(r) : "大" == c ? h.text(d) : "小" == c ? o.text(r) : "龙" == c ? h.text(d) : "虎" == c && o.text(r), i == c) l = "<p  " + a + ">" + i + "</p>", s.find(".tablebox td:nth-child(1)").append(l); else {
        var m = "";
        s.find(".tablebox td:nth-child(1)").hasClass("bgcolor") || (m = "bgcolor"), l = "<td class='" + m + "'><p " + a + ">" + c + "</p></td>", "" == i ? s.find(".tablebox").append(l) : s.find(".tablebox td:nth-child(1)").before(l)
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

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
    return typeof e
} : function (e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
};
$(function () {
    config.formatDate();
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    });
    var e = "";
    $(".listheadl").find("span").live("click", function () {
        $(this).siblings().removeClass("xxselected"), $(this).addClass("xxselected");
        var t = $(this).find("i").text();
        "1" == t ? (e = "1", $("#dxms,#lmms").hide(200), $("#zhms").show(200), excuteZhmsSelect(zhmssxmc, zhmssxlz), zhlzlh()) : "2" == t ? (e = "1", $("#zhms,#lmms").hide(200), $("#dxms").show(200), excuteZhmsSelect(dxmssxmc, dxmssxlz)) : "3" == t && (e = "3", $("#dxms,#zhms").hide(200), $("#lmms").show(200), excuteZhmsSelect(lmmssxmc, lmmssxlz))
    }), $(".zhclear").live("click", function () {
        zhmsMcMethod("zhclear", this)
    }), $(".zhcheckall").live("click", function () {
        zhmsMcMethod("all", this)
    }), $("#zhms li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $("#zhms .sinli").live("click", function () {
        zhmsMcMethod("zhchecksing", this), zhlzlh()
    }), $("#zhms .zhmslz .lztype").live("click", function () {
        zhmsLzMethod("zhchecksing", this), zhlzlh()
    }), $("#dxms li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $("#dxms .lztype").live("click", function () {
        dxmsLzMethod("", this)
    }), $("#dxms .sinli").live("click", function () {
        dxmsMcMethod("", this), zhlzlh()
    }), $("#dxms .zhcheckall_a").on("click", function () {
        $("#dxms .lztype").removeClass("checked"), $("#dxms>ul:first-child").find(".lztype").each(function () {
            dxmsLzMethod("dmchexkall", this)
        })
    }), $("#dxms .zhclear_a").live("click", function () {
        $("#dxms .lztype").addClass("checked"), $("#dxms>ul:first-child").find(".lztype").each(function () {
            dxmsLzMethod("", this)
        })
    }), $("#lmms .zhclear").live("click", function () {
        lmmsMcMethod("zhclear", this)
    }), $("#lmms .zhcheckall").live("click", function () {
        lmmsMcMethod("all", this)
    }), $("#lmms li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $("#lmms .sinli").live("click", function () {
        lmmsMcMethod("zhchecksing", this), zhlzlh()
    }), $("#lmms .lztype").live("click", function () {
        lmmsLzMethod("zhchecksing", this), zhlzlh()
    }), $("#kaijiangjl").delegate("li", "click", function () {
        var e = $(this).attr("id");
        if ($(this).hasClass("selected")) $(this).removeClass("selected"), "jrsmtj" == e ? $("." + e).hide("200") : "cltx" == e ? $("." + e).hide("200") : "hmfb" == e && ($("." + e).hide("100"), $("." + e).animate({opacity: "0"}, 200)); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).addClass("selected"), "jrsmtj" == e ? $("." + e).show("200") : "cltx" == e ? $("." + e).show("200") : "hmfb" == e && ($("." + e).show("100"), $("." + e).animate({opacity: "1"}, 200))
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
        trigger: "#date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (e, t, s) {
            listData(t = config.formatDate(t)), config.ifdebug;
            var l = t.split("-");
            checkseletime(l);
            var a = parseInt(l[1]) + "/" + parseInt(l[2]);
            $(".now_l").css("display", "none"), $(".jinri").css("display", "inline-block").text(a)
        }, onClose: function (e, t, s) {
            config.ifdebug
        }
    }), dxmsMcMethod("all", null), dxmsLzMethod("all", null), lmmsMcMethod("all", null), lmmsLzMethod("all", null), zhmsMcMethod("all", null), zhmsLzMethod("all", null)
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var localllistdata = {}, localheaddata = {}, intervalPk10 = null, zhmssxmc = [], zhmssxlz = [], dxmssxlz = [],
    dxmssxmc = [], lmmssxmc = [], lmmssxlz = [];