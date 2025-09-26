function yilouFc() {
    for (var t = $("#table_ganyah tbody tr[class='yiloutr']"), e = t.length, a = t.filter(":first").children("td").size(), s = 4; s < a; s++) for (var n = 0; n <= e; n++) {
        var i = t.eq(n).children("td").eq(s);
        if ("0" == i.attr("title")) break;
        i.addClass("yiloufc")
    }
}

function fengeX() {
    var t = $("#table_ganyah tbody tr");
    t.length;
    t.each(function (t, e) {
        var a = $(this).find("td").length;
        t > 0 && (t + 1) % 5 == 0 && $(e).after("<tr class='line_x' style='height:0px'><td class='botmline2' style='height:0px;background-color:#dbdbdb' colspan='" + a + "'></td></tr>")
    })
}

function formatDate(t) {
    var e = t.getFullYear(), a = t.getMonth() + 1;
    a = a < 10 ? "0" + a : a;
    var s = t.getDate();
    return s = s < 10 ? "0" + s : s, e + "-" + a + "-" + s
}

function tongjiCount(t) {
    var e = $(t), a = e.parent().find(".txtNum").val(), s = e.parent().find(".secType").val(),
        n = e.parent().parent().find(".ifds").text(), i = "";
    "单双" == n ? i = 1 == s ? "单" : "双" : "大小" == n ? i = 1 == s ? "大" : "小" : "龙虎" == n ? i = 1 == s ? "龙" : "虎" : "前后" == n && (i = 1 == s ? "前" : "后"), e.parent().parent().parent().parent().parent().find(".tablebox").html();
    var c = 0;
    e.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var e = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), e >= a && i == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), c += 1)
    }), e.parent().parent().find(".sec_count").text(c)
}

function doCheck(t, e) {
    var a = $("." + t + "  .item_" + e + " .lz_table_head td .txtNum").val(),
        s = $("." + t + "  .item_" + e + " .lz_table_head td .secType").val(), n = Number("0" + a), i = 0;
    $("." + t + "  .item_" + e + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == s && $(this).children("p").length >= n && ($(this).removeAttr("style"), $(this).addClass("shaw"), i++)
    }), $("." + t + "  .item_" + e + " .lz_table_head td .sec_count").html(i), $("." + t + "  .item_" + e + "  .lz_table_head td .count").each(function () {
        var a = $(this).attr("data"), s = 0;
        $("." + t + "  .item_" + e + " .lz_table_con td p").each(function () {
            $(this).html() == a && s++
        }), $(this).html(s)
    });
    var c = 0, r = $("." + t + "  .item_" + e + " .lz_table_con td:first-child p:last ");
    r.css("font-weight", "bold");
    var l = setTimeout(function () {
        r.fadeOut(100).fadeIn(100), 1 == ++c && (l = setInterval(arguments.callee, 600)), 5 == c && window.clearInterval(l)
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
        var s = Math.floor(Math.random() * t.length);
        res[e] = t[s], t.splice(s, 1)
    }
    for (var n = 0, a = jnumber.length; n < a; n++) jnumber[n].className = "nub" + res[n], n == a - 1 && (jnumber[n].style.marginRight = "0");
    time++;
    var i = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(i), $("#jnumber").html("");
        sendj()
    }
}

function loadotherData() {
    listData("", ""), $(".listheadrl span").siblings().removeClass("checked"), $("#today").addClass("checked")
}

function listData(t, e) {
    t = void 0 == t ? "" : t, e = void 0 == e ? "" : e, $.ajax({
        url: urlbublic + "pks/queryGysumTrend.do?date=" + t + "&periods=" + e,
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

function excuteAnimate(t, e) {
    var e = e, a = (t = t).length, s = 0, n = $(e);
    $(n).html("");
    var i = setInterval(function () {
        if (s < a) {
            var e = "<li class='nub" + t[s] + "'><i style='font-size:10px'>" + t[s] + "</i></li>";
            $(n).append(e), s++
        } else clearInterval(i)
    }, 100)
}

function getSystime() {
    var t = new Date, e = t.getFullYear(), a = t.getMonth() + 1, s = t.getDate();
    t.getDay(), t.getHours(), t.getMinutes(), t.getSeconds(), document.getElementById("Date");
    return e + "-" + a + "-" + s
}

function clearinterval(t) {
    clearInterval(intervalPk10)
}

function zoushiMethod(t, e) {
    var a = $(e);
    if (a.removeClass("hoverli"), "all" == t) (lmmssxmc = []).length >= 10 || $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (lmmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }), config.ifdebug; else if ("zhclear" == t) $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), lmmssxmc = [])
    }); else if ("zhchecksing" == t) {
        var s = a.find("i").text();
        if (a.hasClass("checked")) {
            a.removeClass("checked");
            for (var n = 0, i = lmmssxmc.length; n < i; n++) lmmssxmc[n] == s && lmmssxmc.splice(n, 1)
        } else if (a.addClass("hoverli"), a.addClass("checked"), lmmssxmc.length <= 0) lmmssxmc.push(s); else {
            for (var n = 0, i = lmmssxmc.length; n < i && lmmssxmc[n] != s; n++) ;
            lmmssxmc.push(s)
        }
    }
    config.ifdebug, $(lmmssxmc).each(function (t) {
        $("#box" + $(this) + "4").show()
    }), excuteZhmsSelect(lmmssxmc, ["4"])
}

function excuteZhmsSelect(t, e) {
    $(t).each(function () {
        "1" == this && $("#table_ganyah .yilou").find("span").hide()
    })
}

function dxmsMethod() {
    $($("#zhms").find("li")).each(function (t) {
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
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e));
    var a = e.result.data;
    tools.toggleNoTodayOpenTip({data: a, nextCb: forRank, contentClass: "#waitBox", insertClass: ".listcontent .box"})
}

function bgPostionX(t) {
    t.find(".tablebox td").length % 2 != 0 ? t.find(".item_con").css({"background-positionX": "0"}) : t.find(".item_con").css({"background-positionX": "-29px"})
}

function forRank(t) {
    $("#table_ganyah tbody").empty(), $(t.list).each(function (t) {
        if (t > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
        var e = "<td>" + this.preIssue + "</td>", a = "<td>" + this.preDrawTime + "</td>", s = "";
        $(this.preDrawCode).each(function (t) {
            s += 0 == t ? "<span style='color:#f1010a'>" + this + "</span>&nbsp;" : 1 == t ? "<span style='color:#0096ff'>" + this + "</span>&nbsp;" : "<span>" + this + "</span>&nbsp;"
        });
        var n = "<td>" + s + "</td>", i = this.gySum, c = '<td style="background:#fdfaf5">' + i + "</td>", r = "";
        $(this.missing).each(function (t) {
            var e = "", a = "", s = i;
            1 * this > 0 ? (e = "title='0'", a = "style='background:" + color[1] + "'") : (s = Math.abs(this), e = "class='yilou'"), t > 16 || (r += "<td " + e + "><span " + a + ">" + s + "</span></td>")
        });
        var l = "<tr class='yiloutr'>" + e + a + s + n + c + r + "</tr>";
        $("#table_ganyah tbody").append(l)
    }), drawLine();
    $("#table_ganyah tbody").append("<tr><th colspan='4' height='38'>数据统计</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th></tr>");
    var e = "<td class='font14' colspan='4'>出现总次数</td>", a = "<td class='font14' colspan='4'>平均遗漏值</td>",
        s = "<td class='font14' colspan='4'>最大连出值</td>", n = "<td class='font14' colspan='4'>最大遗漏值</td>";
    $(t.title).each(function (t) {
        $(this.appearCount).each(function () {
            e += "<td>" + Math.abs(this) + "</td>"
        }), $(this.averageMissingValues).each(function () {
            a += "<td>" + Math.abs(this) + "</td>"
        }), $(this.maxAppearValues).each(function () {
            s += "<td>" + Math.abs(this) + "</td>"
        }), $(this.maxMissingValues).each(function () {
            n += "<td>" + Math.abs(this) + "</td>"
        })
    }), $("#table_ganyah tbody").append("<tr>" + e + "</tr><tr>" + a + "</tr><tr>" + s + "</tr><tr>" + n + "</tr>")
}

function drawLine() {
    $("#chartLinediv canvas").remove(), tablename = "table_ganyah", $("#" + tablename).find("tr").each(function () {
        $(this).find("td").each(function () {
            "0" == $(this).attr("title") && $(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK")
        })
    }), $("#" + tablename + " tr").eq($("#" + tablename + " tr").length - 8).find("td").removeClass("tdbb").addClass("tdbbs"), chartOfBaseTrend.guanyaheLine()
}

function diyString(t) {
    var e = "";
    return $(t).each(function () {
        e += "&nbsp;" + this
    }), e
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
    config.formatDate();
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#biaozxz .zhclear").live("click", function () {
        zoushiMethod("zhclear", this)
    }), $("#biaozxz .zhcheckall").live("click", function () {
        zoushiMethod("all", this)
    }), $("#biaozxz li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $("#biaozxz .sinli").live("click", function () {
        $(this).removeClass("hoverli");
        var t = $(this).find("i").text();
        "1" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $(".yilou span").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $(".yilou span").css("display", "block")) : "2" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv canvas").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $("#chartLinediv canvas").css("display", "block")) : "3" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv .yilou").removeClass("yiloufc")) : (yilouFc(), $(this).addClass("hoverli"), $(this).addClass("checked")) : "4" == t && ($(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#table_ganyah").find("tr[class='line_x']").remove()) : (fengeX(), $(this).addClass("hoverli"), $(this).addClass("checked")), $("#biaozxz .sinli").eq(1).hasClass("sinli checked") && drawLine())
    });
    $(".box .btnCheck").live("click", function () {
        tongjiCount($(this))
    }), $("#daxiaodsfb").delegate("li", "click", function () {
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    }), $("#datebox").calendar({
        trigger: ".date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (t, e, a) {
            var s = (e = config.formatDate(e)).split("-");
            checkseletime(s), listData(e), config.ifdebug
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