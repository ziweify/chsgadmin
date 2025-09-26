function loadotherData() {
    listData(), todayData(), t = setTimeout(function () {
        longData()
    }, 1e3)
}

function ifselectedOpacity(t) {
    $(t).hasClass("selectedOpacity") ? ($(t).removeClass(), $(t).addClass("selectedOpacity")) : $(t).removeClass()
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
    $.ajax({
        url: urlbublic + "pks/getPksHistoryList.do",
        type: "GET",
        data: {lotCode: lotCode},
        beforeSend: function () {
        },
        success: function (t) {
            createHtmlList(t), animateMethod.loadingList("#jrsmhmtj", !1), tools.resetListColor()
        },
        error: function (t) {
            setTimeout(function () {
                listData()
            }, 1e3), config.ifdebug
        }
    })
}

function todayData() {
    $.ajax({
        url: urlbublic + "pks/getPksDoubleCount.do?date=",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            loadTodayData(t)
        },
        error: function (t) {
            setTimeout(function () {
                todayData()
            }, 1e3), config.ifdebug
        }
    })
}

function longData() {
    $.ajax({
        url: urlbublic + "pks/getPksLongDragonCount.do?date=",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            loadLongData(t)
        },
        error: function (t) {
            setTimeout(function () {
                longData()
            }, 1e3), config.ifdebug
        }
    })
}

function parseTonum(t) {
    return 1 * t.charAt(0) <= 0 ? t.charAt(1) : t
}

function loadTodayData(t) {
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), data = data.result.data, $("#shuanmiandata").html("<td>出现次数</td>");
    for (var e = [data.firstSingleCount, data.firstDoubleCount, data.firstBigCount, data.firstSmallCount, data.secondSingleCount, data.secondDoubleCount, data.secondBigCount, data.secondSmallCount, data.thirdSingleCount, data.thirdDoubleCount, data.thirdBigCount, data.thirdSmallCount, data.fourthSingleCount, data.fourthDoubleCount, data.fourthBigCount, data.fourthSmallCount, data.fifthSingleCount, data.fifthDoubleCount, data.fifthBigCount, data.fifthSmallCount, data.sixthSingleCount, data.sixthDoubleCount, data.sixthBigCount, data.sixthSmallCount, data.seventhSingleCount, data.seventhDoubleCount, data.seventhBigCount, data.seventhSmallCount, data.eighthSingleCount, data.eighthDoubleCount, data.eighthBigCount, data.eighthSmallCount, data.ninthSingleCount, data.ninthDoubleCount, data.ninthBigCount, data.ninthSmallCount, data.tenthSingleCount, data.tenthDoubleCount, data.tenthBigCount, data.tenthSmallCount], s = 0, a = e.length; s < a; s++) {
        n = "<td>" + e[s] + "</td>";
        $("#shuanmiandata").append(n)
    }
    config.ifdebug;
    var i = [data.sumSingleCount, data.sumDoubleCount, data.sumBigCount, data.sumSmallCount, data.firstDragonCount, data.firstTigerCount, data.secondDragonCount, data.secondTigerCount, data.thirdDragonCount, data.thirdTigerCount, data.fourthDragonCount, data.fourthTigerCount, data.fifthDragonCount, data.fifthTigerCount];
    $("#gylhcs").html("<td>出现次数</td>");
    for (var s = 0, a = i.length; s < a; s++) {
        var n = "<td>" + i[s] + "</td>";
        $("#gylhcs").append(n)
    }
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
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), data = data.result.data, config.ifdebug, $("#cltxul").empty("");
    for (var e = 0, s = data.length; e < s; e++) {
        var a = minci(data[e].rank, "rank"), i = minci(data[e].state, "state"),
            n = data[e].count >= 5 ? "<span style='color:#f11821'>" + data[e].count + "&nbsp;&nbsp;</span>" : "<span>" + data[e].count + "&nbsp;&nbsp;</span>",
            l = "<li>第<span>" + a + "</span>名：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + n + "期</li>";
        11 != data[e].rank && 1 != data[e].rank && 2 != data[e].rank || (l = "<li><span>" + a + "</span>：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + n + "期</li>"), $("#cltxul").append(l)
    }
}

function getSystime() {
    var t = new Date, e = t.getFullYear(), s = t.getMonth() + 1, a = t.getDate();
    t.getDay(), t.getHours(), t.getMinutes(), t.getSeconds(), document.getElementById("Date");
    return e + "-" + s + "-" + a
}

function createHtmlList(t) {
    var e = tools.parseObj(t);
    e = e.result.data;
    var s = "";
    $("#jrsmhmtj>table").html('<tr><th>时间</th><th>期数</th><th id="numberbtn" class="numberbtn"><span id="xshm" class="spanselect">显示号码</span><span id="xsdx">显示大小</span><span id="xsds">显示单双</span></th><th colspan="3">冠亚和</th><th colspan="5">1-5龙虎</th></tr>');
    for (var a = 0, i = e.length; a < i; a++) {
        if (a > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
        for (var n = "", l = 0, d = (s = e[a].preDrawCode.split(",")).length; l < d; l++) {
            var o = "";
            l == d - 1 && (o = "li_after"), n += "<li class='numsm" + s[l] + " " + o + "'><i>" + s[l] + "</i></li>"
        }
        var r = "style='color:";
        if (!(s.length <= 1)) var c = "0" == e[a].sumBigSamll ? "大" : "小", u = "大" == c ? r + "#f12d35'" : "",
            h = "0" == e[a].sumSingleDouble ? "单" : "双", m = "双" == h ? r + "#f12d35'" : "",
            f = "0" == e[a].firstDT ? "龙" : "虎", C = "龙" == f ? r + "#f12d35'" : "",
            p = "0" == e[a].secondDT ? "龙" : "虎", g = "龙" == p ? r + "#f12d35'" : "",
            b = "0" == e[a].thirdDT ? "龙" : "虎", v = "龙" == b ? r + "#f12d35'" : "",
            y = "0" == e[a].fourthDT ? "龙" : "虎", O = "龙" == y ? r + "#f12d35'" : "",
            j = "0" == e[a].fifthDT ? "龙" : "虎", D = "龙" == j ? r + "#f12d35'" : "";
        var k = "<td " + u + ">" + c + "</td><td " + m + ">" + h + "</td><td " + C + ">" + f + "</td><td " + g + ">" + p + "</td><td " + v + ">" + b + "</td><td " + O + ">" + y + "</td><td " + D + ">" + j + "</td>",
            x = "<tr>" + ("<td>" + e[a].preDrawTime + "</td><td>" + e[a].preDrawIssue + "</td><td><ul class='imgnumber'>" + n + "</ul></td><td>" + e[a].sumFS + "</td>" + k) + "</tr>";
        $("#jrsmhmtj>table").append(x)
    }
    $("table").find("td").each(function () {
        "undefined" == $(this).text() && $(this).text("")
    })
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    function t(t) {
        if (n.length) {
            for (var s = !1, a = 0; a < n.length; a++) t == n[a] && (n.splice(a, 1), s = !0);
            s || n.push(t)
        } else n.push(t);
        e(!1)
    }

    function e(t) {
        $("#jrsmhmtj").find(".imgnumber").children().addClass("selectedOpacity");
        for (var e = 0, s = n.length; e < s; e++) $("#jrsmhmtj .imgnumber li").each(function () {
            $(this).text() == n[e] && $(this).removeClass("selectedOpacity")
        })
    }

    function s(t) {
        if (l.length <= 0) l.push(t); else {
            for (var e = 0, s = l.length; e < s; e++) if (l[e] == t) return;
            l.push(t)
        }
    }

    function a(t, e) {
        $("#jrsmhmtj").find(".imgnumber").children();
        var s = $("#dannum").hasClass("selected"), a = $("#shuangnum").hasClass("selected"),
            i = $("#danum").hasClass("selected"), l = $("#xiaonum").hasClass("selected");
        $("#jrsmhmtj .imgnumber li").each(function () {
            var n = $(this).text(), d = n % 2 == 0, o = n >= 6;
            "1" == t ? e ? i ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : l && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : l ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "2" == t ? e ? i ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : l && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : l ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "3" == t ? e ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "4" == t && (e ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
        }), $("#jrsmhmtj .imgnumber li").each(function (t) {
            $(this).text() == n[t] && $(this).removeClass("selectedOpacity")
        })
    }

    function i(t) {
        $("#jrsmhmtj").find(".imgnumber").children(), $("#jrsmhmtj>table>tbody").children();
        if ($("#daxiaodsfb").find("li").removeClass("selected"), t) return $("#duizinum").removeClass("selected"), void $("#jrsmhmtj .imgnumber li").removeClass("selectedOpacity");
        $("#duizinum").addClass("selected"), $("#jrsmhmtj .imgnumber li").addClass("selectedOpacity");
        var e = [], s = $("#jrsmhmtj tr"), a = s.length;
        if (!(a <= 1)) {
            for (var i = $(s[0]).find("li"), n = 0; n < 10; n++) e.push($(i[n]).text());
            for (n = 1; n < a; n++) for (var l = $(s[n]).find("li"), d = 0; d < 10; d++) {
                var o = $(l[d]).text();
                o == e[d] && ($(l[d]).removeClass("selectedOpacity"), $($(s[n - 1]).find("li")[d]).removeClass("selectedOpacity")), e[d] = o
            }
        }
    }

    animateMethod.loadingList("#jrsmhmtj", !0), $("#morelist").mouseover(function () {
        $(".sub_morelist").show(), $(".more").css({
            "border-color": "#fa8e19",
            "border-bottom-color": "#ffffff",
            color: "#fa8e19"
        }), $(".graypre").css("display", "none"), $(".yellowpre").css("display", "inline-block")
    }).mouseout(function () {
        $(".sub_morelist").hide(), $(".more").css("border-color", "#ffffff").css("color", "#333333"), $(".graypre").css("display", "inline-block"), $(".yellowpre").css("display", "none")
    }), $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#kaijiangjl").delegate("li", "click", function () {
        var t = $(this).attr("id");
        if ($(this).hasClass("selected")) $(this).removeClass("selected"), "jrsmtj" == t ? $("." + t).hide("200") : "cltx" == t ? $("." + t).hide("200") : "hmfb" == t && ($("." + t).hide("100"), $("." + t).animate({opacity: "0"}, 200)); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).addClass("selected"), "jrsmtj" == t ? $("." + t).show("200") : "cltx" == t ? $("." + t).show("200") : "hmfb" == t && ($("." + t).show("100"), $("." + t).animate({opacity: "1"}, 200))
        }
    });
    var n = [];
    $("#chakanchfb").delegate("li", "click", function () {
        if ($("#daxiaodsfb").find("li").removeClass("selected"), $(this).hasClass("selected")) $(this).removeClass("selected"), t($(this).attr("class")), n.length + 1 == 1 && (n = [], $("#jrsmhmtj").find(".imgnumber").children().removeClass("selectedOpacity")); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).hasClass("reset") ? (n = [], $("#jrsmhmtj").find(".imgnumber").children().removeClass("selectedOpacity")) : (t($(this).attr("class")), $(this).addClass("selected"))
        }
    });
    var l = [];
    $("#daxiaodsfb").delegate("li", "click", function () {
        $("#chakanchfb").find("li").removeClass("selected"), n = [];
        var t = $(this).attr("id"), e = $(this).hasClass("selected");
        "dannum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#shuangnum").removeClass("selected")) : "shuangnum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#dannum").removeClass("selected")) : "danum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#xiaonum").removeClass("selected")) : "xiaonum" == t && (e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#danum").removeClass("selected"))), $(this).hasClass("kaijiltit") || ($(this).hasClass("reset") ? ($(this).siblings().removeClass("selected"), $("#jrsmhmtj").find(".imgnumber").children().removeClass("selectedOpacity")) : "danum" == t ? ($("#duizinum").removeClass("selected"), s(2), a(3, e)) : "xiaonum" == t ? ($("#duizinum").removeClass("selected"), s(2), a(4, e)) : "dannum" == t ? ($("#duizinum").removeClass("selected"), s(1), a(1, e)) : "shuangnum" == t ? ($("#duizinum").removeClass("selected"), s(1), a(2, e)) : "duizinum" == t && i(e))
    }), $("#jrsmhmtj").on("click", "li", function () {
        var t = {bignum: "danum", smallnum: "xiaonum", singularnum: "dannum", evennum: "shuangnum"}, e = $("#hmfb");
        e.hasClass("selected") || e.trigger("click");
        var s, a = this.className.replace("selectedOpacity", "").trim();
        s = a.indexOf("numsm") > -1 ? "." + a.replace(/[^0-9]/gi, "") : "#" + t[a], $(s).trigger("click")
    }), $(".numberbtn span").live("click", function () {
        var t = $(this).attr("id");
        $(this).siblings().removeClass("spanselect"), $(this).hasClass("spanselect") ? $(this).removeClass() : $(this).addClass("spanselect"), $("#jrsmhmtj .imgnumber li").each(function (e) {
            var s = $(this).text(), a = s % 2 == 0, i = s >= 6;
            if ("xshm" == t) {
                switch (ifselectedOpacity($(this)), s) {
                    case"01":
                        $(this).addClass("numsm01");
                        break;
                    case"02":
                        $(this).addClass("numsm02");
                        break;
                    case"03":
                        $(this).addClass("numsm03");
                        break;
                    case"04":
                        $(this).addClass("numsm04");
                        break;
                    case"05":
                        $(this).addClass("numsm05");
                        break;
                    case"06":
                        $(this).addClass("numsm06");
                        break;
                    case"07":
                        $(this).addClass("numsm07");
                        break;
                    case"08":
                        $(this).addClass("numsm08");
                        break;
                    case"09":
                        $(this).addClass("numsm09");
                        break;
                    case"10":
                        $(this).addClass("numsm10")
                }
                (e + 1) % 10 == 0 && $(this).addClass("numsm" + s + " li_after")
            } else "xsdx" == t ? (ifselectedOpacity($(this)), i ? ($(this).addClass("bignum"), (e + 1) % 10 == 0 && $(this).addClass("bignum li_after")) : ($(this).addClass("smallnum"), (e + 1) % 10 == 0 && $(this).addClass("smallnum li_after"))) : "xsds" == t && (ifselectedOpacity($(this)), a ? ($(this).addClass("evennum"), (e + 1) % 10 == 0 && $(this).addClass("evennum li_after")) : ($(this).addClass("singularnum"), (e + 1) % 10 == 0 && $(this).addClass("singularnum li_after")))
        })
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    })
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});
var urlbublic = config.publicUrl, localllistdata = {}, localheaddata = {}, intervalPk10 = null, listdata = {};