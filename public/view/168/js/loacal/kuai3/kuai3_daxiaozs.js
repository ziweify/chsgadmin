function showTables(t)
{
    $("#table_weizhi").show(), drawLine("table_weizhi")
}

function yilouFc() {
    var t = $("#chartLinediv table"), s = "";
    $(t).each(function (t) {
        "table" == $(this).css("display") && (s = $(this).attr("id"))
    });
    for (var a = $("#" + s + " tbody tr[class='yiloutr']"), e = a.length, i = a.filter(":first").children("td").size(), n = 2; n < i; n++) for (var h = 0; h <= e; h++) {
        var l = a.eq(h).children("td").eq(n);
        if ("0" == l.attr("title")) break;
        l.addClass("yiloufc")
    }
}

function fengeX() {
    var t = $("#table_weizhi tbody tr");
    t.length;
    t.each(function (t, s) {
        var a = $(this).find("td").length;
        t > 0 && (t + 1) % 5 == 0 && $(s).after("<tr class='line_x' style='height:0px'><td class='botmline2' style='height:0px;background-color:#dbdbdb' colspan='" + a + "'></td></tr>")
    })
}

function formatDate(t) {
    var s = t.getFullYear(), a = t.getMonth() + 1;
    a = a < 10 ? "0" + a : a;
    var e = t.getDate();
    return e = e < 10 ? "0" + e : e, s + "-" + a + "-" + e
}

function tongjiCount(t) {
    var s = $(t), a = s.parent().find(".txtNum").val(), e = s.parent().find(".secType").val(),
        i = s.parent().parent().find(".ifds").text(), n = "";
    "单双" == i ? n = 1 == e ? "单" : "双" : "大小" == i ? n = 1 == e ? "大" : "小" : "龙虎" == i ? n = 1 == e ? "龙" : "虎" : "前后" == i && (n = 1 == e ? "前" : "后"), s.parent().parent().parent().parent().parent().find(".tablebox").html();
    var h = 0;
    s.parent().parent().parent().parent().parent().find(".tablebox").children().each(function (t) {
        var s = $(this).find("p").length;
        $(this).css({
            "background-color": "",
            color: "#666666"
        }), s >= a && n == $(this).children("p").html() && ($(this).css({
            "background-color": "rgb(253, 173, 86)",
            color: "#fff"
        }), h += 1)
    }), s.parent().parent().find(".sec_count").text(h)
}

function doCheck(t, s) {
    var a = $("." + t + "  .item_" + s + " .lz_table_head td .txtNum").val(),
        e = $("." + t + "  .item_" + s + " .lz_table_head td .secType").val(), i = Number("0" + a), n = 0;
    $("." + t + "  .item_" + s + " .lz_table_con td").each(function () {
        $(this).removeClass("shaw"), $(this).children("p").html() == e && $(this).children("p").length >= i && ($(this).removeAttr("style"), $(this).addClass("shaw"), n++)
    }), $("." + t + "  .item_" + s + " .lz_table_head td .sec_count").html(n), $("." + t + "  .item_" + s + "  .lz_table_head td .count").each(function () {
        var a = $(this).attr("data"), e = 0;
        $("." + t + "  .item_" + s + " .lz_table_con td p").each(function () {
            $(this).html() == a && e++
        }), $(this).html(e)
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
    var s = setTimeout("sendj()", 100), a = "";
    lilength == t.length - 1 && (a = "li_after", clearTimeout(s), lilength = 0), $("#jnumber").append("<li class='nub" + t[lilength] + " " + a + "'></li>"), lilength++
}

function excutek() {
    for (var t = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], s = 0, a = t.length; s < a; s++) {
        var e = Math.floor(Math.random() * t.length);
        res[s] = t[e], t.splice(e, 1)
    }
    for (var i = 0, a = jnumber.length; i < a; i++) jnumber[i].className = "nub" + res[i], i == a - 1 && (jnumber[i].style.marginRight = "0");
    time++;
    var n = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(n), $("#jnumber").html("");
        sendj()
    }
}

function listData() {
    var t = void 0 == ifChecked().time ? "" : ifChecked().time,
        s = (void 0 == ifChecked().num || ifChecked().num, void 0 == ifChecked().issue ? "" : ifChecked().issue),
        a = void 0 == ifChecked().periods ? "" : ifChecked().periods;
    $.ajax({
        url: urlbublic + "lotteryJSFastThree/queryBigAndSmallTrend.do?date=" + t + "&issue=" + s + "&periods=" + a,
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
        s = $("#biaozxz").find("li[class='sinli selected']").find("span").text(), a = null, e = null;
    return "today" == t ? a = getDateStr(0) : "yesterday" == t ? a = getDateStr(-1) : "qianday" == t ? a = getDateStr(-2) : "thirty" == t ? e = "30" : "sixty" == t ? e = "60" : "ninety" == t && (e = "90"), {
        num: s,
        issue: null,
        time: a,
        periods: e
    }
}

function parseTonum(t) {
    return 1 * t.charAt(0) <= 0 ? t.charAt(1) : t
}

function excuteAnimate(t, s) {
    var s = s, a = (t = t).length, e = 0, i = $(s);
    $(i).html("");
    var n = setInterval(function () {
        if (e < a) {
            var s = "<li class='nub" + t[e] + "'><i style='font-size:10px'>" + t[e] + "</i></li>";
            $(i).append(s), e++
        } else clearInterval(n)
    }, 100)
}

function getSystime() {
    var t = new Date, s = t.getFullYear(), a = t.getMonth() + 1, e = t.getDate();
    t.getDay(), t.getHours(), t.getMinutes(), t.getSeconds(), document.getElementById("Date");
    return s + "-" + a + "-" + e
}

function clearinterval(t) {
    clearInterval(intervalPk10)
}

function zoushiMethod(t, s) {
    var a = $(s);
    if (a.removeClass("hoverli"), "all" == t) (lmmssxmc = []).length >= 10 || $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("title") || $(this).hasClass("zhcheckall") || $(this).hasClass("zhclear") || (lmmssxmc.push($(this).find("i").text()), $(this).addClass("checked"))
    }), config.ifdebug; else if ("zhclear" == t) $($("#biaozxz").find(".sinli")).each(function (t) {
        $(this).hasClass("checked") && ($(this).removeClass("checked"), lmmssxmc = [])
    }); else if ("zhchecksing" == t) {
        var e = a.find("i").text();
        if (a.hasClass("checked")) {
            a.removeClass("checked");
            for (var i = 0, n = lmmssxmc.length; i < n; i++) lmmssxmc[i] == e && lmmssxmc.splice(i, 1)
        } else if (a.addClass("hoverli"), a.addClass("checked"), lmmssxmc.length <= 0) lmmssxmc.push(e); else {
            for (var i = 0, n = lmmssxmc.length; i < n && lmmssxmc[i] != e; i++) ;
            lmmssxmc.push(e)
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
    var a = s.result.data;
    tools.toggleNoTodayOpenTip({data: a, nextCb: forRank, contentClass: "#waitBox", insertClass: ".listcontent .box"})
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
            var s = "<td>" + this.preIssue + "</td>", a = "", e = this.drawCode;
            $(e).each(function (t) {
                a += 0 == t ? "<span style='color:#f1010a'>" + this + "</span>&nbsp;" : "<span>" + this + "</span>&nbsp;"
            });
            var i = "<td>" + a + "</td>", n = "", h = "", l = "", o = "", c = "", r = "", d = "", f = "", u = "",
                m = "", b = "", p = "", g = "";
            $(this.numberDistribution).each(function (t) {
                var s = "", a = "", i = "";
                1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", i = Math.abs(this)) : (i = Math.abs(this), s = "class='yilou'");
                var h = "";
                t < 7 && (h = "style='background-color:#fcf9f2'");
                var l = "", o = function (t) {
                    for (var s = t, a = s, e = 0, i = {}, n = 0; n < s.length; n++) {
                        for (var h = 0; h < a.length; h++) s[n] == a[h] && (e += 1, i[s[n]] = e);
                        e = 0
                    }
                    return config.ifdebug, i
                }(e)[i];
                o > 1 && (l = "<i class = ''>" + o + "</i>"), n += "<td " + h + " " + s + "><span " + a + ">" + i + "</span>" + l + "</td>"
            }), $(this.hundredForm).each(function (t) {
                var s = "", a = "", e = "";
                0 == t ? (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "大") : (s = "class='yilou'", e = Math.abs(this)), h += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>") : 1 == t && (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "小") : (s = "class='yilou'", e = Math.abs(this)), l += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>");
                var i = "";
                t < 7 && (i = "style='background-color:#fcf9f2'")
            }), $(this.tenForm).each(function (t) {
                var s = "", a = "", e = "";
                0 == t ? (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "大") : (s = "class='yilou'", e = Math.abs(this)), o += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>") : 1 == t && (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "小") : (s = "class='yilou'", e = Math.abs(this)), c += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>");
                var i = "";
                t < 7 && (i = "style='background-color:#fcf9f2'")
            }), $(this.unitForm).each(function (t) {
                var s = "", a = "", e = "";
                0 == t ? (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "大") : (s = "class='yilou'", e = Math.abs(this)), r += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>") : 1 == t && (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "小") : (s = "class='yilou'", e = Math.abs(this)), d += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>");
                var i = "";
                t < 7 && (i = "style='background-color:#fcf9f2'")
            }), $(this.sizeCompare).each(function (t) {
                var s = "", a = "", e = "";
                0 == t ? (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "3:0") : (s = "class='yilou'", e = Math.abs(this)), f += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>") : 1 == t ? (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "2:1") : (s = "class='yilou'", e = Math.abs(this)), u += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>") : 2 == t ? (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "1:2") : (s = "class='yilou'", e = Math.abs(this)), m += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>") : 3 == t && (1 * this > 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = "0:3") : (s = "class='yilou'", e = Math.abs(this)), b += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>");
                var i = "";
                t < 7 && (i = "style='background-color:#fcf9f2'")
            }), $(this.bigNumber).each(function (t) {
                var s = "", a = "", e = "";
                1 * this >= 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = 6 == t ? "大" : 7 == t ? "小" : 8 == t ? "单" : 9 == t ? "双" : Math.abs(this)) : (e = Math.abs(this), s = "class='yilou'");
                var i = "";
                t < 7 && (i = "style='background-color:#fcf9f2'"), p += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>"
            }), $(this.smallNumber).each(function (t) {
                var s = "", a = "", e = "";
                1 * this >= 0 ? (s = "title='0'", a = "style='background:" + color[1] + "'", e = 6 == t ? "大" : 7 == t ? "小" : 8 == t ? "单" : 9 == t ? "双" : Math.abs(this)) : (e = Math.abs(this), s = "class='yilou'");
                var i = "";
                t < 7 && (i = "style='background-color:#fcf9f2'"), g += "<td " + i + " " + s + "><span " + a + ">" + e + "</span></td>"
            });
            var v = "<tr class='yiloutr'>" + s + i + n + h + l + o + c + r + d + f + u + m + b + p + g + "</tr>";
            $("#table_weizhi tbody").append(v)
        });
        $("#table_weizhi tbody").append('<tr><th rowspan="2" colspan="2" width="85" height="38" class="left_border left_b left_strong_down">数据统计</th><th colspan="6" width="40">开奖号码分布</th><th colspan="2" width="40">百位</th><th colspan="2" width="40">十位</th><th colspan="2" width="40">个位</th><th colspan="4" width="40">大小比走势</th><th colspan="4" width="40">大数个数</th><th colspan="4" width="40">小数个数</th></tr><tr><th width="40" class="font14">1</th><th width="40" class="font14">2</th><th width="40" class="font14">3</th><th width="40" class="font14">4</th><th width="40" class="font14">5</th><th width="40" class="font14">6</th><th width="40" class="font14">大</th><th width="40" class="font14">小</th><th width="40" class="font14">大</th><th width="40" class="font14">小</th><th width="40" class="font14">大</th><th width="40" class="font14">小</th><th width="40" class="font14">3:0</th><th width="40" class="font14">2:1</th><th width="40" class="font14">1:2</th><th width="40" class="font14">0:3</th><th width="40" class="font14">0</th><th width="40" class="font14">1</th><th width="40" class="font14">2</th><th width="40" class="font14">3</th><th width="40" class="font14">0</th><th width="40" class="font14">1</th><th width="40" class="font14">2</th><th width="40" class="font14">3</th></tr>');
        var s = "<td class='font14' colspan='2'>出现次数</td>", a = "<td class='font14' colspan='2'>平均遗漏</td>",
            e = "<td class='font14' colspan='2'>最大连出</td>", i = "<td class='font14' colspan='2'>最大遗漏</td>";
        $(this.bigAndSmallTrendTitle).each(function (t) {
            $(this.appearCount).each(function () {
                s += "<td class='font14'>" + Math.abs(this) + "</td>"
            }), $(this.averageMissingValues).each(function () {
                a += "<td class='font14'>" + Math.abs(this) + "</td>"
            }), $(this.maxAppearValues).each(function () {
                e += "<td class='font14'>" + Math.abs(this) + "</td>"
            }), $(this.maxMissingValues).each(function () {
                i += "<td class='font14'>" + Math.abs(this) + "</td>"
            })
        }), $("#table_weizhi tbody").append("<tr>" + s + "</tr><tr>" + a + "</tr><tr>" + e + "</tr><tr>" + i + "</tr>")
    }), showTables("1")
}

function drawLine(t) {
    $("#chartLinediv canvas").remove(), tablename = t, $("#" + tablename).find("tr").each(function () {
        $(this).find("td").each(function () {
            "0" == $(this).attr("title") && ($(this).index() >= 2 && $(this).index() <= 7 ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[1]), $(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("i").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "smallQiu")) : 8 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 9 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 10 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 11 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 12 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 13 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 14 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 15 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : 16 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf jitdbg"), $(this).find("span").css("background", "#fa9932")) : 17 == $(this).index() ? ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiuf outdbg"), $(this).find("span").css("background", "#3cb0ec")) : $(this).index() >= 18 && $(this).index() <= 27 && ($(this).attr("class", "hot " + $(this).removeClass("grey").attr("class")).find("span").attr("name", "hotSpan").text($(this).attr("name")).attr("class", "zoushiqiu bBK"), $(this).find("span").css("background", color[1])))
        })
    }), $("#" + tablename + " tr").eq($("#" + tablename + " tr").length - 8).find("td").removeClass("tdbb").addClass("tdbbs"), chartOfBaseTrend.kuai3dwzs4(), chartOfBaseTrend.kuai3dwzs5()
}

function diyString(t) {
    var s = "";
    return $(t).each(function () {
        s += "&nbsp;" + this
    }), s
}

function boxList(t, s) {
    var a = "";
    return 1 == t && 1 == s.state ? a = "" + t + s.state : 1 == t && 2 == s.state ? a = "" + t + s.state : 1 == t && 3 == s.state ? a = "" + t + s.state : 2 == t && 1 == s.state ? a = "" + t + s.state : 2 == t && 2 == s.state ? a = "" + t + s.state : 2 == t && 3 == s.state ? a = "" + t + s.state : 3 == t && 1 == s.state ? a = "" + t + s.state : 3 == t && 2 == s.state ? a = "" + t + s.state : 3 == t && 3 == s.state ? a = "" + t + s.state : 4 == t && 1 == s.state ? a = "" + t + s.state : 4 == t && 2 == s.state ? a = "" + t + s.state : 4 == t && 3 == s.state ? a = "" + t + s.state : 5 == t && 1 == s.state ? a = "" + t + s.state : 5 == t && 2 == s.state ? a = "" + t + s.state : 5 == t && 3 == s.state ? a = "" + t + s.state : 6 == t && 1 == s.state ? a = "" + t + s.state : 6 == t && 2 == s.state ? a = "" + t + s.state : 7 == t && 1 == s.state ? a = "" + t + s.state : 7 == t && 2 == s.state ? a = "" + t + s.state : 8 == t && 1 == s.state ? a = "" + t + s.state : 8 == t && 2 == s.state ? a = "" + t + s.state : 9 == t && 1 == s.state ? a = "" + t + s.state : 9 == t && 2 == s.state ? a = "" + t + s.state : 10 == t && 1 == s.state ? a = "" + t + s.state : 10 == t && 2 == s.state ? a = "" + t + s.state : 11 == t && 1 == s.state ? a = "" + t + s.state : 11 == t && 2 == s.state ? a = "" + t + s.state : 1 == t && 4 == s.state ? a = "" + t + s.state : 2 == t && 4 == s.state ? a = "" + t + s.state : 3 == t && 4 == s.state ? a = "" + t + s.state : 4 == t && 4 == s.state ? a = "" + t + s.state : 5 == t && 4 == s.state ? a = "" + t + s.state : 6 == t && 4 == s.state ? a = "" + t + s.state : 7 == t && 4 == s.state ? a = "" + t + s.state : 8 == t && 4 == s.state ? a = "" + t + s.state : 9 == t && 4 == s.state ? a = "" + t + s.state : 10 == t && 4 == s.state && (a = "" + t + s.state), a
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
        trigger: ".date", zIndex: 999, format: "yyyy-mm-dd", onSelected: function (t, s, a) {
            var e = (s = formatDate(s)).split("-");
            checkseletime(e), listData(s), config.ifdebug
        }, onClose: function (t, s, a) {
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