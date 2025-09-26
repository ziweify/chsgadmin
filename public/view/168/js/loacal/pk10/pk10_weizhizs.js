function showTables(t) {
    $("#chartLinediv table").hide(), $("#table_weizhi" + t).show(), drawLine("table_weizhi" + t);
    $("#table_weizhi" + t).attr("id")
}

function yilouFc() {
    var t = $("#chartLinediv table"), s = "";
    $(t).each(function (t) {
        "table" == $(this).css("display") && (s = $(this).attr("id"))
    });
    for (var e = $("#" + s + " tbody tr[class='yiloutr']"), a = e.length, i = e.filter(":first").children("td").size(), n = 2; n < i; n++) for (var c = 0; c <= a; c++) {
        var h = e.eq(c).children("td").eq(n);
        if ("0" == h.attr("title")) break;
        h.addClass("yiloufc")
    }
}

function fengeX(t) {
    var s = $(t).find("tr");
    s.length;
    s.each(function (t, s) {
        var e = $(this).find("td").length;
        t > 0 && (t + 1) % 5 == 0 && $(s).after("<tr class='line_x' style='height:0px'><td class='botmline2' style='height:0px;background-color:#dbdbdb' colspan='" + e + "'></td></tr>")
    });
    $("#biaozxz").find(".selected span").text()
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
    var c = 0;
    s.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var s = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), s >= e && n == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), c += 1)
    }), s.parent().parent().find(".sec_count").text(c)
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
    var c = 0, h = $("." + t + "  .item_" + s + " .lz_table_con td:first-child p:last ");
    h.css("font-weight", "bold");
    var l = setTimeout(function () {
        h.fadeOut(100).fadeIn(100), 1 == ++c && (l = setInterval(arguments.callee, 600)), 5 == c && window.clearInterval(l)
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
        url: urlbublic + "pks/queryLocationTrend.do?date=" + t + "&periods=" + s,
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

function excuteAnimate(t, s) {
    var s = s, e = (t = t).length, a = 0, i = $(s);
    $(i).html("");
    var n = setInterval(function () {
        if (a < e) {
            var s = "<li class='nub" + t[a] + "'><i style='font-size:10px'>" + t[a] + "</i></li>";
            $(i).append(s), a++
        } else clearInterval(n)
    }, 100)
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
        "1" == this && $("#table_ganyah .yilou").find("span").hide()
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

function checkNum() {
    var t = $("#biaozxz").find(".selected").find("span").text();
    $("#table_weizhi" + t).find(".fpredrawSpan span:nth-child(" + t + ")").siblings().removeClass("colorred"), $("#table_weizhi" + t).find(".fpredrawSpan span:nth-child(" + t + ")").addClass("colorred")
}

function forRank(t) {
    $("#table_weizhi1 tbody").empty(), $(t).each(function (t) {
        $("#table_weizhi" + (t + 1) + " tbody").empty(), $(this.bodyList).each(function (s) {
            if (s > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
            var e = "<td>" + this.preIssue + "</td>", a = "";
            $(this.drawCode).each(function (t) {
                a += 0 == t ? "<span class='colorred'>" + this + "</span>&nbsp;" : "<span>" + this + "</span>&nbsp;"
            });
            var i = '<td class="fpredrawSpan">' + a + "</td>", n = "";
            $(this.array).each(function (t) {
                var s = "", e = "", a = "";
                1 * this > 0 ? (s = "title='0'", e = "style='background:" + color[1] + "'", a = 10 == t ? "奇" : 11 == t ? "偶" : 12 == t ? "大" : 13 == t ? "小" : 14 == t ? "质" : 15 == t ? "合" : 16 == t ? "0" : 17 == t ? "1" : 18 == t ? "2" : 19 == t ? "升" : 20 == t ? "平" : 21 == t ? "降" : Math.abs(this)) : (a = Math.abs(this), s = "class='yilou'");
                var i = "";
                t < 10 && (i = "style='background-color:#fcf9f2'"), n += "<td " + i + " " + s + "><span " + e + ">" + a + "</span></td>"
            });
            var c = "<tr class='yiloutr'>" + e + i + n + "</tr>";
            $("#table_weizhi" + (t + 1) + " tbody").append(c)
        });
        var s = '<tr><th rowspan="2" colspan="2" width="85" height="38" class="left_border left_b left_strong_down">数据统计</th><th colspan="10" width="40">' + typeOf(t + 1, "rank") + '分布</th><th colspan="6" width="40">形态特征</th><th colspan="3" width="40">012路</th><th colspan="3" width="40">升平降</th></tr><tr><th width="40" class="font14">1</th><th width="40" class="font14">2</th><th width="40" class="font14">3</th><th width="40" class="font14">4</th><th width="40" class="font14">5</th><th width="40" class="font14">6</th><th width="40" class="font14">7</th><th width="40" class="font14">8</th><th width="40" class="font14">9</th><th width="40" class="font14">10</th><th width="40" class="font14">奇</th><th width="40" class="font14">偶</th><th width="40" class="font14">大</th><th width="40" class="font14">小</th><th width="40" class="font14">质</th><th width="40" class="font14">合</th><th width="40" class="font14">0</th><th width="40" class="font14">1</th><th width="40" class="font14">2</th><th width="40" class="font14">升</th><th width="40" class="font14">平</th><th width="40" class="font14">降</th></tr>';
        $("#table_weizhi" + (t + 1) + " tbody").append(s);
        var e = "<td class='font14' colspan='2'>总次数</td>", a = "<td class='font14' colspan='2'>平均遗漏</td>",
            i = "<td style='display:none' class='font14' colspan='2'>当前遗漏</td>", n = "<td class='font14' colspan='2'>最大连出</td>",
            c = "<td class='font14' colspan='2'>最大遗漏</td>";
        $(this.title.appearCount).each(function () {
            e += "<td>" + Math.abs(this) + "</td>"
        }), $(this.title.averageMissingValues).each(function () {
            a += "<td>" + Math.abs(this) + "</td>"
        }), $(this.title.currentMissingValues).each(function () {
            i += "<td>" + Math.abs(this) + "</td>"
        }), $(this.title.maxAppearValues).each(function () {
            n += "<td>" + Math.abs(this) + "</td>"
        }), $(this.title.maxMissingValues).each(function () {
            c += "<td>" + Math.abs(this) + "</td>"
        }), $("#table_weizhi" + (t + 1) + " tbody").append("<tr>" + e + "</tr><tr>" + a + "</tr><tr style='display:none'>" + i + "</tr><tr>" + n + "</tr><tr>" + c + "</tr>")
    }), checkNum();
    var s = window.location.search;
    "" == s ? showTables("1") : "second" == (s = s.replace("?", "")) ? ($(".second_btn").addClass("selected").siblings(".selected").removeClass("selected"), showTables("2")) : "third" == s ? ($(".third_btn").addClass("selected").siblings(".selected").removeClass("selected"), showTables("3")) : "fourth" == s ? ($(".fourth_btn").addClass("selected").siblings(".selected").removeClass("selected"), showTables("4")) : showTables("1")
}

function drawLine(t) {
    $("#chartLinediv canvas").remove(), tablename = t, $("#" + tablename).find("tr").each(function () {
        $(this).find("td").each(function () {
            "0" == $(this).attr("title") && ($(this).index() >= 2 && $(this).index() <= 11 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[1])) : 12 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 13 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 14 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 15 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 16 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 17 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 18 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 19 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 20 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 21 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 22 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 23 == $(this).index() && ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")))
        })
    }), $("#" + tablename + " tr").eq($("#" + tablename + " tr").length - 8).find("td").removeClass("tdbb").addClass("tdbbs"), chartOfBaseTrend.weizhiLine()
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
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#biaozxz .zhclear").live("click", function () {
        zoushiMethod("zhclear", this)
    }), $("#biaozxz .zhcheckall").live("click", function () {
        zoushiMethod("all", this)
    }), $("#biaozxz li").hover(function () {
        $(this).hasClass("checked") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $(".xuanzhemc .sinli").live("click", function () {
        $(this).siblings().removeClass("selected"), $(this).addClass("selected");
        var t = $("#biaozxz").find(".selected span").text();
        $("#table_weizhi" + t).find("tr[class='line_x']").remove(), $("#chartLinediv .yilou").removeClass("yiloufc");
        var s = $("#biaozxz .sinli:nth-child(4)"), e = $("#biaozxz .sinli:nth-child(5)");
        s.hasClass("checked") && s.removeClass("checked"), e.hasClass("checked") && e.removeClass("checked"), checkNum(), showTables($(this).find("span").text())
    }), $("#biaozxz .sinli").live("click", function () {
        $(this).removeClass("hoverli");
        var t = $(this).find("i").text(), s = $("#biaozxz").find(".selected span").text();
        "1" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $(".yilou span").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $(".yilou span").css("display", "block")) : "2" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv canvas").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $("#chartLinediv canvas").css("display", "block"), drawLine("table_weizhi" + s)) : "3" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv .yilou").removeClass("yiloufc")) : (yilouFc(), $(this).addClass("hoverli"), $(this).addClass("checked")) : "4" == t && ($(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#table_weizhi" + s).find("tr[class='line_x']").remove()) : (fengeX($("#table_weizhi" + s)), $(this).addClass("hoverli"), $(this).addClass("checked")), $(".wzzsRightUl").find("li").eq(1).hasClass("sinli checked") && drawLine("table_weizhi" + s))
    });
    $(".box .btnCheck").live("click", function () {
        tongjiCount($(this))
    }), $("#daxiaodsfb").delegate("li", "click", function () {
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    }), $("#datebox").calendar({
        trigger: ".date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (t, s, e) {
            var a = (s = formatDate(s)).split("-");
            checkseletime(a), listData(s), config.ifdebug
        }, onClose: function (t, s, e) {
            config.ifdebug
        }
    }), listData("", "30")
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var localllistdata = {}, localheaddata = {}, intervalPk10 = null, lmmssxmc = [], lmmssxlz = [];