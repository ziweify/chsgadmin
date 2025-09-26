function yilouFc() {
    for (var t = $("#trend_table2 tbody tr[class='yiloutr']"), s = t.length, e = t.filter(":first").children("td").size(), a = 2; a < e; a++) for (var i = 0; i <= s; i++) {
        var n = t.eq(i).children("td").eq(a);
        if ("0" == n.attr("title")) break;
        n.addClass("yiloufc")
    }
}

function fengeX() {
    var t = $("#trend_table2 tbody tr");
    t.length;
    t.each(function (t, s) {
        var e = $(this).find("td").length;
        t > 0 && (t + 1) % 5 == 0 && $(s).after("<tr class='line_x' style='height:0px'><td class='botmline2' style='height:0px;background-color:#dbdbdb' colspan='" + e + "'></td></tr>")
    })
}

function formatDate(t) {
    var s = t.getFullYear(), e = t.getMonth() + 1;
    e = e < 10 ? "0" + e : e;
    var a = t.getDate();
    return a = a < 10 ? "0" + a : a, s + "-" + e + "-" + a
}

function tongjiCount(t) {
    var s = $(t), e = s.parent().find(".txtNum").val(), a = s.parent().find(".secType").val(),
        i = s.parent().parent().find(".ifds").text(), n = "";
    "单双" == i ? n = 1 == a ? "单" : "双" : "大小" == i ? n = 1 == a ? "大" : "小" : "龙虎" == i ? n = 1 == a ? "龙" : "虎" : "前后" == i && (n = 1 == a ? "前" : "后"), s.parent().parent().parent().parent().parent().find(".tablebox").html();
    var l = 0;
    s.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var s = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), s >= e && n == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), l += 1)
    }), s.parent().parent().find(".sec_count").text(l)
}

function doCheck(t, s) {
    var e = $("." + t + "  .item_" + s + " .lz_table_head td .txtNum").val(),
        a = $("." + t + "  .item_" + s + " .lz_table_head td .secType").val(), i = Number("0" + e), n = 0;
    $("." + t + "  .item_" + s + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == a && $(this).children("p").length >= i && ($(this).removeAttr("style"), $(this).addClass("shaw"), n++)
    }), $("." + t + "  .item_" + s + " .lz_table_head td .sec_count").html(n), $("." + t + "  .item_" + s + "  .lz_table_head td .count").each(function () {
        var e = $(this).attr("data"), a = 0;
        $("." + t + "  .item_" + s + " .lz_table_con td p").each(function () {
            $(this).html() == e && a++
        }), $(this).html(a)
    });
    var l = 0, r = $("." + t + "  .item_" + s + " .lz_table_con td:first-child p:last ");
    r.css("font-weight", "bold");
    var o = setTimeout(function () {
        r.fadeOut(100).fadeIn(100), 1 == ++l && (o = setInterval(arguments.callee, 600)), 5 == l && window.clearInterval(o)
    }, 1e3)
}

function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(t) {
    var s = setTimeout("sendj()", 100), e = "";
    lilength == t.length - 1 && (e = "li_after", clearTimeout(s), lilength = 0), $("#jnumber").append("<li class='nub" + t[lilength] + " " + e + "'></li>"), lilength++
}

function excutek() {
    for (var t = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], s = 0, e = t.length; s < e; s++) {
        var a = Math.floor(Math.random() * t.length);
        res[s] = t[a], t.splice(a, 1)
    }
    for (var i = 0, e = jnumber.length; i < e; i++) jnumber[i].className = "nub" + res[i], i == e - 1 && (jnumber[i].style.marginRight = "0");
    time++;
    var n = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(n), $("#jnumber").html("");
        sendj()
    }
}

function loadotherData() {
    listData("", "30"), $(".listheadrl span").siblings().removeClass("checked"), $("#thirty").addClass("checked")
}

function listData(t, s) {
    t = void 0 == t ? "" : t, s = void 0 == s ? "" : s, $.ajax({
        url: urlbublic + "pks/queryDrawCodeTrend.do?date=" + t + "&periods=" + s,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            createHtmlList(t), $("#hovediv").height($("#trend_table2").height())
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

function minci(t, s) {
    if ("rank" == s) switch (1 * t) {
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
    } else if ("state" == s) switch (1 * t) {
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

function getSystime() {
    var t = new Date, s = t.getFullYear(), e = t.getMonth() + 1, a = t.getDate();
    t.getDay(), t.getHours(), t.getMinutes(), t.getSeconds(), document.getElementById("Date");
    return s + "-" + e + "-" + a
}

function clearinterval(t) {
    clearInterval(intervalPk10)
}

function zoushiMethod(t, s) {
    var e = $(s);
    if (e.removeClass("hoverli"), "all" == t) (lmmssxmc = []).length >= 10 || $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (lmmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }), config.ifdebug; else if ("zhclear" == t) $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), lmmssxmc = [])
    }); else if ("zhchecksing" == t) {
        var a = e.find("i").text();
        if (e.hasClass("checked")) {
            e.removeClass("checked");
            for (var i = 0, n = lmmssxmc.length; i < n; i++) lmmssxmc[i] == a && lmmssxmc.splice(i, 1)
        } else if (e.addClass("hoverli"), e.addClass("checked"), lmmssxmc.length <= 0) lmmssxmc.push(a); else {
            for (var i = 0, n = lmmssxmc.length; i < n && lmmssxmc[i] != a; i++) ;
            lmmssxmc.push(a)
        }
    }
    config.ifdebug, $(lmmssxmc).each(function (t) {
        $("#box" + $(this) + "4").show()
    }), excuteZhmsSelect(lmmssxmc, ["4"])
}

function excuteZhmsSelect(t, s) {
    $(t).each(function () {
        "1" == this && $("#trend_table2 .yilou").find("span").hide()
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

function typeOf(t, s) {
    if ("rank" == s) switch (1 * t) {
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
    var s = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? s = JSON.parse(t) : (s = JSON.stringify(t), s = JSON.parse(s));
    var e = s.result.data;
    tools.toggleNoTodayOpenTip({data: e, nextCb: forRank, contentClass: "#waitBox", insertClass: ".listcontent .box"})
}

function bgPostionX(t) {
    t.find(".tablebox td").length % 2 != 0 ? t.find(".item_con").css({"background-positionX": "0"}) : t.find(".item_con").css({"background-positionX": "-29px"})
}

function forRank(t) {
    $("#trend_table2 tbody").empty(), $(t.bodyList).each(function (t) {
        if (t > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
        var s = '<td class="leftth">' + this.preIssue + "</td>",
            e = '<td><span class="kaijnum">' + diyString(this.preDrawCode) + "</span></td>", a = "", i = "", n = "",
            l = "", r = "", o = "", c = "", h = "", d = "", u = "", f = "</span></td>", p = this.subBodyList;
        $(p).each(function () {
            var t = this.rank, s = this.missing;
            $(s).each(function () {
                if ("1" == t) {
                    a += "<td " + (1 * this > 0 ? "title='0'" : "class='rank1 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("2" == t) {
                    i += "<td " + (1 * this > 0 ? "title='0'" : "class='rank2 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("3" == t) {
                    n += "<td " + (1 * this > 0 ? "title='0'" : "class='rank3 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("4" == t) {
                    l += "<td " + (1 * this > 0 ? "title='0'" : "class='rank4 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("5" == t) {
                    r += "<td " + (1 * this > 0 ? "title='0'" : "class='rank5 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("6" == t) {
                    o += "<td " + (1 * this > 0 ? "title='0'" : "class='rank6 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("7" == t) {
                    c += "<td " + (1 * this > 0 ? "title='0'" : "class='rank7 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("8" == t) {
                    h += "<td " + (1 * this > 0 ? "title='0'" : "class='rank8 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("9" == t) {
                    d += "<td " + (1 * this > 0 ? "title='0'" : "class='rank9 yilou'") + "><span>" + Math.abs(this) + f
                } else if ("10" == t) {
                    u += "<td " + (1 * this > 0 ? "title='0'" : "class='rank yilou'") + "><span>" + Math.abs(this) + f
                }
            })
        });
        var m = "<tr class='yiloutr' height='32'>" + s + e + a + i + n + l + r + o + c + h + d + u + "</tr>";
        $("#trend_table2 tbody").append(m)
    }), drawLine(), $("#trend_table2 tbody").append($("#chartbottom tbody").html());
    var s = "<td class='font14' colspan='2'>出现次数</td>", e = "<td class='font14' colspan='2'>平均遗漏</td>",
        a = "<td class='font14' colspan='2'>当前遗漏</td>", i = "<td class='font14' colspan='2'>最大连出</td>",
        n = "<td class='font14' colspan='2'>最大遗漏</td>";
    $(t.titleList).each(function (t) {
        $(this.appearCount).each(function () {
            s += "<td>" + Math.abs(this) + "</td>"
        }), $(this.averageMissingValues).each(function () {
            e += "<td>" + Math.abs(this) + "</td>"
        }), $(this.currentMissingValues).each(function () {
            a += "<td>" + Math.abs(this) + "</td>"
        }), $(this.maxAppearValues).each(function () {
            i += "<td>" + Math.abs(this) + "</td>"
        }), $(this.maxMissingValues).each(function () {
            n += "<td>" + Math.abs(this) + "</td>"
        })
    }), $("#trend_table2 tbody").append("<tr>" + s + "</tr><tr>" + e + "</tr><tr style='display: none'>" + a + "</tr><tr>" + i + "</tr><tr>" + n + "</tr>")
}

function drawLine() {
    $("#chartLinediv canvas").remove(), tablename = "trend_table2", $("#" + tablename).find("tr").each(function () {
        $(this).find("td").each(function () {
            "0" == $(this).attr("title") && ($(this).index() >= 2 && $(this).index() <= 11 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[0])) : $(this).index() >= 12 && $(this).index() <= 21 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu gB"), $(this).find("span").css("background", color[1]), $(this).addClass("rank2")) : $(this).index() >= 22 && $(this).index() <= 31 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu oB"), $(this).find("span").css("background", color[2]), $(this).addClass("rank3")) : $(this).index() >= 32 && $(this).index() <= 41 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu gqB"), $(this).find("span").css("background", color[3]), $(this).addClass("rank4")) : $(this).index() >= 42 && $(this).index() <= 51 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu grB"), $(this).find("span").css("background", color[4]), $(this).addClass("rank5")) : $(this).index() >= 52 && $(this).index() <= 61 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[5]), $(this).addClass("rank6")) : $(this).index() >= 62 && $(this).index() <= 71 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu gB"), $(this).find("span").css("background", color[6]), $(this).addClass("rank7")) : $(this).index() >= 72 && $(this).index() <= 81 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu oB"), $(this).find("span").css("background", color[7]), $(this).addClass("rank8")) : $(this).index() >= 82 && $(this).index() <= 91 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu gqB"), $(this).find("span").css("background", color[8]), $(this).addClass("rank9")) : $(this).index() >= 92 && $(this).index() <= 101 && ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu grB"), $(this).find("span").css("background", color[9]), $(this).addClass("rank")))
        })
    }), $("#" + tablename + " tr").eq($("#" + tablename + " tr").length - 8).find("td").removeClass("tdbb").addClass("tdbbs"), chartOfBaseTrend.brokenLine()
}

function diyString(t) {
    var s = "";
    return $(t).each(function () {
        s += "&nbsp;" + this
    }), s
}

function boxList(t, s) {
    var e = "";
    return 1 == t && 1 == s.state ? e = "" + t + s.state : 1 == t && 2 == s.state ? e = "" + t + s.state : 1 == t && 3 == s.state ? e = "" + t + s.state : 2 == t && 1 == s.state ? e = "" + t + s.state : 2 == t && 2 == s.state ? e = "" + t + s.state : 2 == t && 3 == s.state ? e = "" + t + s.state : 3 == t && 1 == s.state ? e = "" + t + s.state : 3 == t && 2 == s.state ? e = "" + t + s.state : 3 == t && 3 == s.state ? e = "" + t + s.state : 4 == t && 1 == s.state ? e = "" + t + s.state : 4 == t && 2 == s.state ? e = "" + t + s.state : 4 == t && 3 == s.state ? e = "" + t + s.state : 5 == t && 1 == s.state ? e = "" + t + s.state : 5 == t && 2 == s.state ? e = "" + t + s.state : 5 == t && 3 == s.state ? e = "" + t + s.state : 6 == t && 1 == s.state ? e = "" + t + s.state : 6 == t && 2 == s.state ? e = "" + t + s.state : 7 == t && 1 == s.state ? e = "" + t + s.state : 7 == t && 2 == s.state ? e = "" + t + s.state : 8 == t && 1 == s.state ? e = "" + t + s.state : 8 == t && 2 == s.state ? e = "" + t + s.state : 9 == t && 1 == s.state ? e = "" + t + s.state : 9 == t && 2 == s.state ? e = "" + t + s.state : 10 == t && 1 == s.state ? e = "" + t + s.state : 10 == t && 2 == s.state ? e = "" + t + s.state : 11 == t && 1 == s.state ? e = "" + t + s.state : 11 == t && 2 == s.state ? e = "" + t + s.state : 1 == t && 4 == s.state ? e = "" + t + s.state : 2 == t && 4 == s.state ? e = "" + t + s.state : 3 == t && 4 == s.state ? e = "" + t + s.state : 4 == t && 4 == s.state ? e = "" + t + s.state : 5 == t && 4 == s.state ? e = "" + t + s.state : 6 == t && 4 == s.state ? e = "" + t + s.state : 7 == t && 4 == s.state ? e = "" + t + s.state : 8 == t && 4 == s.state ? e = "" + t + s.state : 9 == t && 4 == s.state ? e = "" + t + s.state : 10 == t && 4 == s.state && (e = "" + t + s.state), e
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
        var t = $("#chartLinediv").height();
        config.ifdebug, t > 0 && t < 350 ? $(this).scrollTop() > 10 ? ($("#gotop").show(), $(this).scrollTop() > 15 && ($(".prev_li").css({top: -$(this).scrollTop() + "px"}), $(".next_li").css({top: -$(this).scrollTop() + "px"}))) : $("#gotop").hide() : t >= 350 && t < 1200 ? $(this).scrollTop() > 10 ? ($("#gotop").show(), $(this).scrollTop() > 15 && ($(".prev_li").css({top: -($(this).scrollTop() - 200) + "px"}), $(".next_li").css({top: -($(this).scrollTop() - 200) + "px"}))) : $("#gotop").hide() : $(this).scrollTop() > 10 ? ($("#gotop").show(), $(this).scrollTop() > 1050 ? ($(".prev_li").css({top: "-520px"}), $(".next_li").css({top: "-520px"})) : $(this).scrollTop() < 580 && ($(".prev_li").css({top: "30px"}), $(".next_li").css({top: "30px"}))) : $("#gotop").hide()
    }), $("#hovediv").live("hover", function () {
        var t = $("#waitBox").scrollLeft();
        config.ifdebug, t <= 0 ? (t = 1e3, $(".prev_li").hide(), $(".next_li").show(), $(".prev_li,.next_li").live("hover", function () {
            $(".next_li").show()
        })) : t > 0 && t < e ? (config.ifdebug, $(".prev_li").show(), $(".next_li").show(), $(".prev_li,.next_li").live("hover", function () {
            $(".prev_li").show(), $(".next_li").show()
        })) : ($(".prev_li").show(), $(".next_li").hide(), $(".prev_li,.next_li").live("hover", function () {
            $(".prev_li").show(), $(".next_li").hide()
        }))
    }), $("#hovediv").live("mouseout", function () {
        $(".prev_li").hide(), $(".next_li").hide()
    });
    var t = $("#trend_table2").width(), s = $("#chartLinediv").width(), e = t - s, a = t - s, i = 1e3;
    $(".next_li").click(function (t) {
        config.ifdebug, a >= 1e3 ? ($("#waitBox").animate({scrollLeft: i}, 500), i += i, a -= 1e3, $(".prev_li").show()) : ($("#waitBox").animate({scrollLeft: i}, 500), $(".next_li").hide(), $(".prev_li").show(), $(".prev_li,.next_li").live("hover", function () {
            $(".prev_li").show(), $(".next_li").hide()
        }), $(".prev_li,.next_li").on("mouseout", function () {
            $(".next_li").hide()
        }), a = e)
    }), $(".prev_li").click(function (t) {
        var s = $("#waitBox").scrollLeft();
        s >= 1e3 ? (s -= 1e3, $("#waitBox").animate({scrollLeft: s}, 500), $(".next_li").show(), $(".prev_li,.next_li").live("mouseout", function () {
            $(".prev_li").show(), $(".next_li").show()
        }), $(".prev_li,.next_li").live("hover", function () {
            $(".prev_li").show(), $(".next_li").show()
        })) : (s -= s, $("#waitBox").animate({scrollLeft: s}, 500), $(".prev_li").hide(), $(".next_li").show(), $(".prev_li,.next_li").live("hover", function () {
            $(".prev_li").hide(), $(".next_li").show()
        }), i = 1e3)
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
        "1" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $(".yilou span").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $(".yilou span").css("display", "block")) : "2" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv canvas").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $("#chartLinediv canvas").css("display", "block")) : "3" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv .yilou").removeClass("yiloufc")) : (yilouFc(), $(this).addClass("hoverli"), $(this).addClass("checked")) : "4" == t && ($(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#trend_table2").find("tr[class='line_x']").remove()) : (fengeX(), $(this).addClass("hoverli"), $(this).addClass("checked")), $("#biaozxz .sinli").eq(1).hasClass("sinli checked") && drawLine())
    });
    $(".box .btnCheck").live("click", function () {
        tongjiCount($(this))
    }), $("#daxiaodsfb").delegate("li", "click", function () {
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    }), $("#datebox").calendar({
        trigger: "#date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (t, s, e) {
            var a = (s = formatDate(s)).split("-");
            checkseletime(a), listData(s), config.ifdebug
        }, onClose: function (t, s, e) {
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