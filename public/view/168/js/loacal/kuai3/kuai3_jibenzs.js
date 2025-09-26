function showTables(t) {
    $("#table_weizhi").show(), drawLine("table_weizhi")
}

function yilouFc() {
    var t = $("#chartLinediv table"), s = "";
    $(t).each(function (t) {
        "table" == $(this).css("display") && (s = $(this).attr("id"))
    });
    for (var e = $("#" + s + " tbody tr[class='yiloutr']"), a = e.length, i = e.filter(":first").children("td").size(), n = 2; n < i; n++) for (var h = 0; h <= a; h++) {
        var l = e.eq(h).children("td").eq(n);
        if ("0" == l.attr("title")) break;
        l.addClass("yiloufc")
    }
}

function fengeX() {
    var t = $("#table_weizhi tbody tr");
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
    var h = 0;
    s.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var s = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), s >= e && n == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), h += 1)
    }), s.parent().parent().find(".sec_count").text(h)
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
    var h = 0, l = $("." + t + "  .item_" + s + " .lz_table_con td:first-child p:last ");
    l.css("font-weight", "bold");
    var o = setTimeout(function () {
        l.fadeOut(100).fadeIn(100), 1 == ++h && (o = setInterval(arguments.callee, 600)), 30 == h && window.clearInterval(o)
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

function listData(t) {
    var t = void 0 == ifChecked().time ? "" : ifChecked().time,
        s = (void 0 == ifChecked().num || ifChecked().num, void 0 == ifChecked().issue ? "" : ifChecked().issue),
        e = void 0 == ifChecked().periods ? "" : ifChecked().periods;
    $.ajax({
        url: urlbublic + "lotteryJSFastThree/queryBasicTrend.do?date=" + t + "&issue=" + s + "&periods=" + e,
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

function ifChecked() {
    var t = $(".listheadrl").find("span[class='checked']").attr("id"),
        s = $("#biaozxz").find("li[class='sinli selected']").find("span").text(), e = null, a = null;
    return "today" == t ? e = getDateStr(0) : "yesterday" == t ? e = getDateStr(-1) : "qianday" == t ? e = getDateStr(-2) : "thirty" == t ? a = "30" : "sixty" == t ? a = "60" : "ninety" == t && (a = "90"), {
        num: s,
        issue: null,
        time: e,
        periods: a
    }
}

function parseTonum(t) {
    return 1 * t.charAt(0) <= 0 ? t.charAt(1) : t
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
    var s = typeOf("qiuqiu", ifChecked().num);
    $("#qiuhao").find("span").text(s);
    $("#table_weizhi tbody").empty(), $(t).each(function (t) {
        $(this.bodyList).each(function (t) {
            if (t > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
            var s = "<td>" + this.preIssue + "</td>", e = "", a = this.drawCode, i = [];
            $(a).each(function (t) {
                e += 0 == t ? "<span style='color:#f1010a'>" + this + "</span>&nbsp;" : "<span>" + this + "</span>&nbsp;", i.push(this);
                for (var s = 0, n = 0; n < i.length; n++) for (var h = n + 1; h < a.length; h++) {
                    if (i[n] != a[h]) return;
                    s += 1, i[n]
                }
            });
            var n = "<td>" + e + "</td>", h = "", l = "", o = "", c = "", r = "";
            $(this.distribution).each(function (t) {
                var s = "", e = "", i = "";
                1 * this > 0 ? (s = "title='0'", e = "style='background:" + color[1] + "'", i = Math.abs(this)) : (i = Math.abs(this), s = "class='yilou'");
                var n = "";
                t < 7 && (n = "style='background-color:#fcf9f2'");
                var l = "", o = function (t) {
                    for (var s = t, e = s, a = 0, i = {}, n = 0; n < s.length; n++) {
                        for (var h = 0; h < e.length; h++) s[n] == e[h] && (a += 1, i[s[n]] = a);
                        a = 0
                    }
                    return config.ifdebug, i
                }(a)[i], l = "";
                o > 1 && (l = "<i class=''>" + o + "</i>"), h += "<td " + n + " " + s + "><span " + e + ">" + i + "</span>" + l + "</td>"
            }), $(this.numberForm).each(function (t) {
                var s = "", e = "", a = "";
                0 == t ? (1 * this > 0 ? (s = "title='0'", e = "style='background:" + color[1] + "'", a = "豹子") : (s = "class='yilou'", a = Math.abs(this)), l += "<td " + i + " " + s + "><span " + e + ">" + a + "</span></td>") : 1 == t ? (1 * this > 0 ? (s = "title='0'", e = "style='background:" + color[1] + "'", a = "三不同") : (s = "class='yilou'", a = Math.abs(this)), o += "<td " + i + " " + s + "><span " + e + ">" + a + "</span></td>") : 2 == t && (1 * this > 0 ? (s = "title='0'", e = "style='background:" + color[1] + "'", a = "对子") : (s = "class='yilou'", a = Math.abs(this)), c += "<td " + i + " " + s + "><span " + e + ">" + a + "</span></td>");
                var i = "";
                t < 26 && (i = "style='background-color:#fcf9f2'")
            }), $(this.sumNum).each(function (t) {
                if (!(t >= 16)) {
                    var s = "", e = "", a = "";
                    1 * this > 0 ? (s = "title='0'", e = "style='background:" + color[1] + "'", a = Math.abs(this)) : (a = Math.abs(this), s = "class='yilou'");
                    var i = "";
                    t < 26 && (i = "style='background-color:#fcf9f2'"), r += "<td " + i + " " + s + "><span " + e + ">" + a + "</span></td>"
                }
            });
            var d = "<tr class='yiloutr'>" + s + n + h + l + o + c + r + "</tr>";
            $("#table_weizhi tbody").append(d)
        });
        $("#table_weizhi tbody").append('<tr><th rowspan="2" colspan="2" width="85" height="38" class="left_border left_b left_strong_down">数据统计</th><th colspan="6" width="40">开奖号码分布</th><th colspan="3">号码形态</th><th colspan="16" width="40">和值走势</th></tr><tr><th width="40"  class="font14">1</th><th width="40"  class="font14">2</th><th width="40"  class="font14">3</th><th width="40"  class="font14">4</th><th width="40"  class="font14">5</th><th width="40"  class="font14">6</th><th width="100"  class="font14">豹子</th><th width="100"  class="font14">三不同</th><th width="100"  class="font14">对子</th><th width="40"  class="font14">3</th><th width="40"  class="font14">4</th><th width="40"  class="font14">5</th><th width="40"  class="font14">6</th><th width="40"  class="font14">7</th><th width="40"  class="font14">8</th><th width="40"  class="font14">9</th><th width="40"  class="font14">10</th><th width="40"  class="font14">11</th><th width="40"  class="font14">12</th><th width="40"  class="font14">13</th><th width="40"  class="font14">14</th><th width="40"  class="font14">15</th><th width="40"  class="font14">16</th><th width="40"  class="font14">17</th><th width="40" >18</th></tr>');
        var s = "<td class='font14' colspan='2'>出现次数</td>", e = "<td class='font14' colspan='2'>平均遗漏</td>",
            a = "<td class='font14' colspan='2'>当前遗漏</td>", i = "<td class='font14' colspan='2'>最大连出</td>",
            n = "<td class='font14' colspan='2'>最大遗漏</td>";
        $(this.basicTrendTitle).each(function (t) {
            $(this.appearCount).each(function () {
                s += "<td class='font14'>" + Math.abs(this) + "</td>"
            }), $(this.averageMissingValues).each(function () {
                e += "<td class='font14'>" + Math.abs(this) + "</td>"
            }), $(this.currentMissingValues).each(function () {
                a += "<td class='font14'>" + Math.abs(this) + "</td>"
            }), $(this.maxAppearValues).each(function () {
                i += "<td class='font14'>" + Math.abs(this) + "</td>"
            }), $(this.maxMissingValues).each(function () {
                n += "<td class='font14'>" + Math.abs(this) + "</td>"
            })
        }), $("#table_weizhi tbody").append("<tr>" + s + "</tr><tr>" + e + "</tr><tr style='display:none'>" + a + "</tr><tr>" + i + "<tr></tr>" + n + "</tr>")
    }), showTables("1")
}

function drawLine(t) {
    $("#chartLinediv canvas").remove(), tablename = t, $("#" + tablename).find("tr").each(function () {
        $(this).find("td").each(function (t) {
            "0" == $(this).attr("title") && ($(this).index() >= 2 && $(this).index() <= 7 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[1]), $(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("i").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "smallQiu")) : 8 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 9 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 10 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : $(this).index() >= 11 && $(this).index() <= 26 && ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[1])))
        })
    }), $("#" + tablename + " tr").eq($("#" + tablename + " tr").length - 8).find("td").removeClass("tdbb").addClass("tdbbs"), chartOfBaseTrend.kuai3dwzs6()
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
        var t = $("#biaozxz .sinli:nth-child(4)"), s = $("#biaozxz .sinli:nth-child(5)");
        t.hasClass("checked") && t.removeClass("checked"), s.hasClass("checked") && s.removeClass("checked"), listData()
    }), $("#biaozxz .sinli").live("click", function () {
        $(this).removeClass("hoverli");
        var t = $(this).find("i").text();
        "1" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $(".yilou span").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $(".yilou span").css("display", "block")) : "2" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv canvas").css("display", "none")) : ($(this).addClass("hoverli"), $(this).addClass("checked"), $("#chartLinediv canvas").css("display", "block")) : "3" == t ? $(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#chartLinediv .yilou").removeClass("yiloufc")) : (yilouFc(), $(this).addClass("hoverli"), $(this).addClass("checked")) : "4" == t && ($(this).hasClass("checked") ? ($(this).removeClass("checked"), $("#table_weizhi").find("tr[class='line_x']").remove()) : (fengeX(), $(this).addClass("hoverli"), $(this).addClass("checked")), $("#biaozxz").find("li").eq(2).hasClass("sinli checked") && drawLine("table_weizhi"))
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
    })
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var intervalPk10 = null, lmmssxmc = [], lmmssxlz = [];