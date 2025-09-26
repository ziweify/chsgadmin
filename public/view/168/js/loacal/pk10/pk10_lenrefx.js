function formatDate(t) {
    var e = t.getFullYear(), a = t.getMonth() + 1;
    a = a < 10 ? "0" + a : a;
    var n = t.getDate();
    return n = n < 10 ? "0" + n : n, e + "-" + a + "-" + n
}

function tongjiCount(t) {
    var e = $(t), a = e.parent().find(".txtNum").val(), n = e.parent().find(".secType").val(),
        s = e.parent().parent().find(".ifds").text(), i = "";
    "单双" == s ? i = 1 == n ? "单" : "双" : "大小" == s ? i = 1 == n ? "大" : "小" : "龙虎" == s ? i = 1 == n ? "龙" : "虎" : "前后" == s && (i = 1 == n ? "前" : "后"), e.parent().parent().parent().parent().parent().find(".tablebox").html();
    var r = 0;
    e.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var e = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), e >= a && i == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), r += 1)
    }), e.parent().parent().find(".sec_count").text(r)
}

function doCheck(t, e) {
    var a = $("." + t + "  .item_" + e + " .lz_table_head td .txtNum").val(),
        n = $("." + t + "  .item_" + e + " .lz_table_head td .secType").val(), s = Number("0" + a), i = 0;
    $("." + t + "  .item_" + e + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == n && $(this).children("p").length >= s && ($(this).removeAttr("style"), $(this).addClass("shaw"), i++)
    }), $("." + t + "  .item_" + e + " .lz_table_head td .sec_count").html(i), $("." + t + "  .item_" + e + "  .lz_table_head td .count").each(function () {
        var a = $(this).attr("data"), n = 0;
        $("." + t + "  .item_" + e + " .lz_table_con td p").each(function () {
            $(this).html() == a && n++
        }), $(this).html(n)
    });
    var r = 0, o = $("." + t + "  .item_" + e + " .lz_table_con td:first-child p:last ");
    o.css("font-weight", "bold");
    var l = setTimeout(function () {
        o.fadeOut(100).fadeIn(100), 1 == ++r && (l = setInterval(arguments.callee, 600)), 5 == r && window.clearInterval(l)
    }, 1e3)
}

function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(t) {
    var e = setTimeout("sendj()", 100), a = "";
    lilength == t.length - 1 && (a = "li_after", clearTimeout(e), lilength = 0), $("#jnumber").append("<li class='nub" + t[lilength] + " " + a + "'></li>"), lilength++
}

function excutek() {
    for (var t = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], e = 0, a = t.length; e < a; e++) {
        var n = Math.floor(Math.random() * t.length);
        res[e] = t[n], t.splice(n, 1)
    }
    for (var s = 0, a = jnumber.length; s < a; s++) jnumber[s].className = "nub" + res[s], s == a - 1 && (jnumber[s].style.marginRight = "0");
    time++;
    var i = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(i), $("#jnumber").html("");
        sendj()
    }
}

function loadotherData() {
    $(".sinli").removeClass("checked"), listData("")
}

function listData(t) {
    t = void 0 == t ? "" : t, $.ajax({
        url: urlbublic + "pks/queryDrawCodeHeatState.do",
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
    for (var e = 0, a = data.length; e < a; e++) {
        var n = minci(data[e].rank, "rank"), s = minci(data[e].state, "state"),
            i = data[e].count >= 5 ? "<span style='color:#f11821'>" + data[e].count + "</span>" : "<span>" + data[e].count + "</span>",
            r = "<li>第<span>" + n + "</span>名：&nbsp;&nbsp;<span>" + s + "</span>&nbsp;&nbsp;" + i + "期</li>";
        11 != data[e].rank && 1 != data[e].rank && 2 != data[e].rank || (r = "<li><span>" + n + "</span>：&nbsp;&nbsp;<span>" + s + "</span>&nbsp;&nbsp;" + i + "期</li>"), $("#cltxul").append(r)
    }
}

function excuteAnimate(t, e) {
    var e = e, a = (t = t).length, n = 0, s = $(e);
    $(s).html("");
    var i = setInterval(function () {
        if (n < a) {
            var e = "<li class='nub" + t[n] + "'><i style='font-size:10px'>" + t[n] + "</i></li>";
            $(s).append(e), n++
        } else clearInterval(i)
    }, 100)
}

function getSystime() {
    var t = new Date, e = t.getFullYear(), a = t.getMonth() + 1, n = t.getDate();
    t.getDay(), t.getHours(), t.getMinutes(), t.getSeconds(), document.getElementById("Date");
    return e + "-" + a + "-" + n
}

function clearinterval(t) {
    clearInterval(intervalPk10)
}

function lmmsMcMethod(t, e) {
    var a = $(e);
    a.removeClass("hoverli");
    a.find("i").text();
    a.hasClass("checked") ? (a.removeClass("checked"), $("#lensetable").find("i").hide()) : (a.addClass("hoverli"), a.addClass("checked"), $("#lensetable").find("i").show())
}

function excuteZhmsSelect(t, e) {
    for (var a = [], n = 0, s = t.length; n < s; n++) for (var i = 0, r = e.length; i < r; i++) a.push(t[n] + "" + e[i]);
    config.ifdebug, $(".box .item").hide(), $(a).each(function (t) {
        $("#box" + a[t]).show()
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

function typeOf(t, e) {
    if ("rank" == e) switch (1 * t) {
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
    } else switch (1 * t) {
        case 1:
            return "单双";
        case 2:
            return "大小";
        case 3:
            return "龙虎";
        case 4:
            return "前后"
    }
}

function createHtmlList(t) {
    var e = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e)), forRank(e.result.data)
}

function bgPostionX(t) {
    t.find(".tablebox td").length % 2 != 0 ? t.find(".item_con").css({"background-positionX": "0"}) : t.find(".item_con").css({"background-positionX": "-29px"})
}

function forRank(t) {
    $("#lensetable").empty();
    $("#lensetable").append("<tr height='50'><th>名次</th><th>热</th><th>温</th><th>冷</th></tr>"), $(t).each(function (t) {
        var e, a, n, s, i = "", r = "";
        e = $(this)[0].list[0].list, a = $(this)[0].list[1].list, i = $(this)[0].list[2].list, n = void 0 == n ? "" : n, s = void 0 == s ? "" : s, r = void 0 == r ? "" : r, $(e).each(function () {
            var t = $(this)[0].drawCode >= "10" ? $(this)[0].drawCode : "0" + $(this)[0].drawCode;
            n += "<li class='numsm" + t + "'><i>" + $(this)[0].count + "</i></li>"
        }), $(a).each(function () {
            var t = $(this)[0].drawCode >= "10" ? $(this)[0].drawCode : "0" + $(this)[0].drawCode;
            s += "<li class='numsm" + t + "'></li>"
        }), $(i).each(function () {
            var t = $(this)[0].drawCode >= "10" ? $(this)[0].drawCode : "0" + $(this)[0].drawCode;
            r += "<li class='numsm" + t + "'></li>"
        });
        var o = "<tr height='50'>" + ("<td width='100'>" + typeOf($(this)[0].rank, "rank") + "</td>") + ("<td width='300'><ul>" + n + "</ul></td>") + ("<td width='400'><ul>" + s + "</ul></td>") + ("<td width='400'><ul>" + r + "</ul></td>") + "</tr>";
        config.ifdebug, $("#lensetable").append(o)
    })
}

function boxList(t, e) {
    var a = "";
    return 1 == t && 1 == e.state ? a = "" + t + e.state : 1 == t && 2 == e.state ? a = "" + t + e.state : 1 == t && 3 == e.state ? a = "" + t + e.state : 2 == t && 1 == e.state ? a = "" + t + e.state : 2 == t && 2 == e.state ? a = "" + t + e.state : 2 == t && 3 == e.state ? a = "" + t + e.state : 3 == t && 1 == e.state ? a = "" + t + e.state : 3 == t && 2 == e.state ? a = "" + t + e.state : 3 == t && 3 == e.state ? a = "" + t + e.state : 4 == t && 1 == e.state ? a = "" + t + e.state : 4 == t && 2 == e.state ? a = "" + t + e.state : 4 == t && 3 == e.state ? a = "" + t + e.state : 5 == t && 1 == e.state ? a = "" + t + e.state : 5 == t && 2 == e.state ? a = "" + t + e.state : 5 == t && 3 == e.state ? a = "" + t + e.state : 6 == t && 1 == e.state ? a = "" + t + e.state : 6 == t && 2 == e.state ? a = "" + t + e.state : 7 == t && 1 == e.state ? a = "" + t + e.state : 7 == t && 2 == e.state ? a = "" + t + e.state : 8 == t && 1 == e.state ? a = "" + t + e.state : 8 == t && 2 == e.state ? a = "" + t + e.state : 9 == t && 1 == e.state ? a = "" + t + e.state : 9 == t && 2 == e.state ? a = "" + t + e.state : 10 == t && 1 == e.state ? a = "" + t + e.state : 10 == t && 2 == e.state ? a = "" + t + e.state : 11 == t && 1 == e.state ? a = "" + t + e.state : 11 == t && 2 == e.state ? a = "" + t + e.state : 1 == t && 4 == e.state ? a = "" + t + e.state : 2 == t && 4 == e.state ? a = "" + t + e.state : 3 == t && 4 == e.state ? a = "" + t + e.state : 4 == t && 4 == e.state ? a = "" + t + e.state : 5 == t && 4 == e.state ? a = "" + t + e.state : 6 == t && 4 == e.state ? a = "" + t + e.state : 7 == t && 4 == e.state ? a = "" + t + e.state : 8 == t && 4 == e.state ? a = "" + t + e.state : 9 == t && 4 == e.state ? a = "" + t + e.state : 10 == t && 4 == e.state && (a = "" + t + e.state), a
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
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
    });
    $(".box .btnCheck").live("click", function () {
        tongjiCount($(this))
    }), $("#daxiaodsfb").delegate("li", "click", function () {
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    }), $("#datebox").calendar({
        trigger: "#date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (t, e, a) {
            var n = (e = formatDate(e)).split("-");
            checkseletime(n), config.ifdebug
        }, onClose: function (t, e, a) {
            config.ifdebug
        }
    })
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var localllistdata = {}, localheaddata = {}, intervalPk10 = null, lmmssxmc = [], lmmssxlz = [];