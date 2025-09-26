function showTables(t) {
    $("#table_weizhi").show(), drawLine("table_weizhi")
}

function yilouFc() {
    var t = $("#chartLinediv table"), e = "";
    $(t).each(function (t) {
        "table" == $(this).css("display") && (e = $(this).attr("id"))
    });
    for (var s = $("#" + e + " tbody tr[class='yiloutr']"), a = s.length, i = s.filter(":first").children("td").size(), n = 3; n < i; n++) for (var h = 0; h <= a; h++) {
        var l = s.eq(h).children("td").eq(n);
        if ("0" == l.attr("title")) break;
        l.addClass("yiloufc")
    }
}

function fengeX() {
    var t = $("#table_weizhi tbody tr");
    t.length;
    t.each(function (t, e) {
        var s = $(this).find("td").length;
        t > 0 && (t + 1) % 5 == 0 && $(e).after("<tr class='line_x' style='height:0px'><td class='botmline2' style='height:0px;background-color:#dbdbdb' colspan='" + s + "'></td></tr>")
    })
}

function formatDate(t) {
    var e = t.getFullYear(), s = t.getMonth() + 1;
    s = s < 10 ? "0" + s : s;
    var a = t.getDate();
    return a = a < 10 ? "0" + a : a, e + "-" + s + "-" + a
}

function tongjiCount(t) {
    var e = $(t), s = e.parent().find(".txtNum").val(), a = e.parent().find(".secType").val(),
        i = e.parent().parent().find(".ifds").text(), n = "";
    "单双" == i ? n = 1 == a ? "单" : "双" : "大小" == i ? n = 1 == a ? "大" : "小" : "龙虎" == i ? n = 1 == a ? "龙" : "虎" : "前后" == i && (n = 1 == a ? "前" : "后"), e.parent().parent().parent().parent().parent().find(".tablebox").html();
    var h = 0;
    e.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var e = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), e >= s && n == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), h += 1)
    }), e.parent().parent().find(".sec_count").text(h)
}

function doCheck(t, e) {
    var s = $("." + t + "  .item_" + e + " .lz_table_head td .txtNum").val(),
        a = $("." + t + "  .item_" + e + " .lz_table_head td .secType").val(), i = Number("0" + s), n = 0;
    $("." + t + "  .item_" + e + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == a && $(this).children("p").length >= i && ($(this).removeAttr("style"), $(this).addClass("shaw"), n++)
    }), $("." + t + "  .item_" + e + " .lz_table_head td .sec_count").html(n), $("." + t + "  .item_" + e + "  .lz_table_head td .count").each(function () {
        var s = $(this).attr("data"), a = 0;
        $("." + t + "  .item_" + e + " .lz_table_con td p").each(function () {
            $(this).html() == s && a++
        }), $(this).html(a)
    });
    var h = 0, l = $("." + t + "  .item_" + e + " .lz_table_con td:first-child p:last ");
    l.css("font-weight", "bold");
    var c = setTimeout(function () {
        l.fadeOut(100).fadeIn(100), 1 == ++h && (c = setInterval(arguments.callee, 600)), 30 == h && window.clearInterval(c)
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
    for (var i = 0, s = jnumber.length; i < s; i++) jnumber[i].className = "nub" + res[i], i == s - 1 && (jnumber[i].style.marginRight = "0");
    time++;
    var n = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(n), $("#jnumber").html("");
        sendj()
    }
}

function listData() {
    var t = void 0 == ifChecked().time ? "" : ifChecked().time,
        e = (void 0 == ifChecked().num || ifChecked().num, void 0 == ifChecked().issue ? "" : ifChecked().issue),
        s = void 0 == ifChecked().periods ? "" : ifChecked().periods;
    $.ajax({
        url: urlbublic + "lotteryJSFastThree/querySumTrend.do?date=" + t + "&issue=" + e + "&periods=" + s,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            createHtmlList(t)
        },
        error: function (t) {
            setTimeout(function () {
                loadotherData()
            }, config.listTime)
        }
    })
}

function ifChecked() {
    var t = $(".listheadrl").find("span[class='checked']").attr("id"),
        e = $("#biaozxz").find("li[class='sinli selected']").find("span").text(), s = null, a = null;
    return "today" == t ? s = getDateStr(0) : "yesterday" == t ? s = getDateStr(-1) : "qianday" == t ? s = getDateStr(-2) : "thirty" == t ? a = "30" : "sixty" == t ? a = "60" : "ninety" == t && (a = "90"), {
        num: e,
        issue: null,
        time: s,
        periods: a
    }
}

function parseTonum(t) {
    return 1 * t.charAt(0) <= 0 ? t.charAt(1) : t
}

function excuteAnimate(t, e) {
    var e = e, s = (t = t).length, a = 0, i = $(e);
    $(i).html("");
    var n = setInterval(function () {
        if (a < s) {
            var e = "<li class='nub" + t[a] + "'><i style='font-size:10px'>" + t[a] + "</i></li>";
            $(i).append(e), a++
        } else clearInterval(n)
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

function zoushiMethod(t, e) {
    var s = $(e);
    if (s.removeClass("hoverli"), "all" == t) (lmmssxmc = []).length >= 10 || $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (lmmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }); else if ("zhclear" == t) $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), lmmssxmc = [])
    }); else if ("zhchecksing" == t) {
        var a = s.find("i").text();
        if (s.hasClass("checked")) {
            s.removeClass("checked");
            for (var i = 0, n = lmmssxmc.length; i < n; i++) lmmssxmc[i] == a && lmmssxmc.splice(i, 1)
        } else if (s.addClass("hoverli"), s.addClass("checked"), lmmssxmc.length <= 0) lmmssxmc.push(a); else {
            for (var i = 0, n = lmmssxmc.length; i < n && lmmssxmc[i] != a; i++) ;
            lmmssxmc.push(a)
        }
    }
    $(lmmssxmc).each(function (t) {
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
    })
}

function createHtmlList(t) {
    var e = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e));
    var s = e.result.data;
    tools.toggleNoTodayOpenTip({data: s, nextCb: forRank, contentClass: "#waitBox", insertClass: ".listcontent .box"})
}

function bgPostionX(t) {
    t.find(".tablebox td").length % 2 != 0 ? t.find(".item_con").css({"background-positionX": "0"}) : t.find(".item_con").css({"background-positionX": "-29px"})
}

function forRank(t) {
    config.ifdebug;
    var e = typeOf("qiuqiu", ifChecked().num);
    $("#qiuhao").find("span").text(e);
    $("#table_weizhi tbody").empty(), $(t).each(function (t) {
        $(this.bodyList).each(function (t) {
            if (t > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
            var e = "<td>" + this.preIssue + "</td>", s = "", a = this.drawCode;
            $(a).each(function (t) {
                s += 0 == t ? "<span style='color:#f1010a'>" + this + "</span>&nbsp;" : "<span>" + this + "</span>&nbsp;"
            });
            var i = "<td>" + s + "</td>", n = "<td>" + this.sumTotal + "</td>", h = "";
            $(this.sumNum).each(function (t) {
                var e = "", s = "", a = "";
                1 * this > 0 ? (e = "title='0'", s = "style='background:" + color[1] + "'", a = 16 == t ? "大" : 17 == t ? "小" : 18 == t ? "单" : 19 == t ? "双" : Math.abs(this)) : (a = Math.abs(this), e = "class='yilou'");
                var i = "";
                t < 16 && (i = "style='background-color:#fcf9f2'"), h += "<td " + i + " " + e + "><span " + s + ">" + a + "</span></td>"
            });
            var l = "<tr class='yiloutr'>" + e + i + n + h + "</tr>";
            $("#table_weizhi tbody").append(l)
        });
        $("#table_weizhi tbody").append('<tr><th rowspan="2" colspan="2" width="85" height="38" class="left_border left_b left_strong_down">数据统计</th><th colspan="17" width="40">和值走势</th><th colspan="4" width="40">和值形态</th></tr><tr><th width="40" class="font14">和</th><th width="40" class="font14">3</th><th width="40" class="font14">4</th><th width="40" class="font14">5</th><th width="40" class="font14">6</th><th width="40" class="font14">7</th><th width="40" class="font14">8</th><th width="40" class="font14">9</th><th width="40" class="font14">10</th><th width="40" class="font14">11</th><th width="40" class="font14">12</th><th width="40" class="font14">13</th><th width="40" class="font14">14</th><th width="40" class="font14">15</th><th width="40" class="font14">16</th><th width="40" class="font14">17</th><th width="40" class="font14">18</th><th width="40" class="font14">大</th><th width="40" class="font14">小</th><th width="40" class="font14">单</th><th width="40" class="font14">双</th></tr>');
        var e = "<td>&nbsp;</td>", s = "<td class='font14' colspan='2'>出现次数</td>" + e,
            a = "<td class='font14' colspan='2'>平均遗漏</td>" + e, i = "<td class='font14' colspan='2'>当前遗漏</td>" + e,
            n = "<td class='font14' colspan='2'>最大连出</td>" + e, h = "<td class='font14' colspan='2'>最大遗漏</td>" + e;
        $(this.basicTrendTitle).each(function (t) {
            $(this.appearCount).each(function () {
                s += "<td>" + Math.abs(this) + "</td>"
            }), $(this.averageMissingValues).each(function () {
                a += "<td>" + Math.abs(this) + "</td>"
            }), $(this.currentMissingValues).each(function () {
                i += "<td>" + Math.abs(this) + "</td>"
            }), $(this.maxAppearValues).each(function () {
                n += "<td>" + Math.abs(this) + "</td>"
            }), $(this.maxMissingValues).each(function () {
                h += "<td>" + Math.abs(this) + "</td>"
            })
        }), $("#table_weizhi tbody").append("<tr>" + s + "</tr><tr>" + a + "</tr><tr style='display:none'>" + i + "</tr><tr>" + n + "</tr><tr>" + h + "</tr>")
    }), showTables("1")
}

function drawLine(t) {
    $("#chartLinediv canvas").remove(), tablename = t, $("#" + tablename).find("tr").each(function () {
        $(this).find("td").each(function () {
            "0" == $(this).attr("title") && ($(this).index() >= 3 && $(this).index() <= 18 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[1])) : 19 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 20 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 21 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 22 == $(this).index() && ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")))
        })
    }), chartOfBaseTrend.kuai3hzzs()
}

function diyString(t) {
    var e = "";
    return $(t).each(function () {
        e += "&nbsp;" + this
    }), e
}

function boxList(t, e) {
    var s = "";
    return 1 == t && 1 == e.state ? s = "" + t + e.state : 1 == t && 2 == e.state ? s = "" + t + e.state : 1 == t && 3 == e.state ? s = "" + t + e.state : 2 == t && 1 == e.state ? s = "" + t + e.state : 2 == t && 2 == e.state ? s = "" + t + e.state : 2 == t && 3 == e.state ? s = "" + t + e.state : 3 == t && 1 == e.state ? s = "" + t + e.state : 3 == t && 2 == e.state ? s = "" + t + e.state : 3 == t && 3 == e.state ? s = "" + t + e.state : 4 == t && 1 == e.state ? s = "" + t + e.state : 4 == t && 2 == e.state ? s = "" + t + e.state : 4 == t && 3 == e.state ? s = "" + t + e.state : 5 == t && 1 == e.state ? s = "" + t + e.state : 5 == t && 2 == e.state ? s = "" + t + e.state : 5 == t && 3 == e.state ? s = "" + t + e.state : 6 == t && 1 == e.state ? s = "" + t + e.state : 6 == t && 2 == e.state ? s = "" + t + e.state : 7 == t && 1 == e.state ? s = "" + t + e.state : 7 == t && 2 == e.state ? s = "" + t + e.state : 8 == t && 1 == e.state ? s = "" + t + e.state : 8 == t && 2 == e.state ? s = "" + t + e.state : 9 == t && 1 == e.state ? s = "" + t + e.state : 9 == t && 2 == e.state ? s = "" + t + e.state : 10 == t && 1 == e.state ? s = "" + t + e.state : 10 == t && 2 == e.state ? s = "" + t + e.state : 11 == t && 1 == e.state ? s = "" + t + e.state : 11 == t && 2 == e.state ? s = "" + t + e.state : 1 == t && 4 == e.state ? s = "" + t + e.state : 2 == t && 4 == e.state ? s = "" + t + e.state : 3 == t && 4 == e.state ? s = "" + t + e.state : 4 == t && 4 == e.state ? s = "" + t + e.state : 5 == t && 4 == e.state ? s = "" + t + e.state : 6 == t && 4 == e.state ? s = "" + t + e.state : 7 == t && 4 == e.state ? s = "" + t + e.state : 8 == t && 4 == e.state ? s = "" + t + e.state : 9 == t && 4 == e.state ? s = "" + t + e.state : 10 == t && 4 == e.state && (s = "" + t + e.state), s
}

function loadotherData() {
    listData("", "30"), $(".listheadrl span").siblings().removeClass("checked"), $("#thirty").addClass("checked")
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
        var t = $("#biaozxz .sinli:nth-child(4)"), e = $("#biaozxz .sinli:nth-child(5)");
        t.hasClass("checked") && t.removeClass("checked"), e.hasClass("checked") && e.removeClass("checked"), listData()
    }), $("#biaozxz .sinli").live("click", function () {
        $(this).removeClass("hoverli");
        var t = $(this).find("i").text();
        "1" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $(".yilou span").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $(".yilou span").css("display", "block")) : "2" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv canvas").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $("#chartLinediv canvas").css("display", "block")) : "3" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv .yilou").removeClass("yiloufc"), $("#chartLinediv .sum").removeClass("yiloufc")) : (yilouFc(), $(this).addClass("hoverli"), $(this).addClass("checked")) : "4" == t && ($(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#table_weizhi").find("tr[class='line_x']").remove()) : (fengeX(), $(this).addClass("hoverli"), $(this).addClass("checked")), $("#biaozxz").find("li").eq(2).hasClass("sinli checked") && drawLine("table_weizhi"))
    });
    $(".box .btnCheck").live("click", function () {
        tongjiCount($(this))
    }), $("#daxiaodsfb").delegate("li", "click", function () {
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    }), $("#datebox").calendar({
        trigger: ".date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (t, e, s) {
            var a = (e = formatDate(e)).split("-");
            checkseletime(a), listData(e)
        }, onClose: function (t, e, s) {
        }
    })
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var intervalPk10 = null, lmmssxmc = [], lmmssxlz = [];