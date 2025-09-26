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
    var l = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(l), $("#jnumber").html("");
        sendj()
    }
}

function loadotherData() {
    listData(), todayData(), longData()
}

function listData() {
    $.ajax({
        url: urlbublic + "CQShiCai/getBaseCQShiCaiList.do",
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

function todayData() {
    $.ajax({
        url: urlbublic + "CQShiCai/queryDoubleNumber.do",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            loadTodayData(t)
        },
        error: function (t) {
            config.ifdebug
        },
        complete: function () {
            tools.undefindeInitZero()
        }
    })
}

function longData() {
    $.ajax({
        url: urlbublic + "CQShiCai/getShiCaiDailyDragonCount.do",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            loadLongData(t)
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
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), data = data.result.data;
    var e = $("#shuanmiandata");
    $(e).find(".cs0").text(data.numZero), $(e).find(".cs1").text(data.numOne), $(e).find(".cs2").text(data.numTwo), $(e).find(".cs3").text(data.numThree), $(e).find(".cs4").text(data.numFour), $(e).find(".cs5").text(data.numFive), $(e).find(".cs6").text(data.numSix), $(e).find(".cs7").text(data.numSeven), $(e).find(".cs8").text(data.numEight), $(e).find(".cs9").text(data.numNine);
    var s = $("#gylhcs");
    $(s).find(".tt1").text(data.sumSingle), $(s).find(".tt2").text(data.sumDouble), $(s).find(".tt3").text(data.sumBig), $(s).find(".tt4").text(data.sumSmall), $(s).find(".one1").text(data.firstSingle), $(s).find(".one2").text(data.firstDouble), $(s).find(".one3").text(data.firstBig), $(s).find(".one4").text(data.firstSmall), $(s).find(".two1").text(data.secondSingle), $(s).find(".two2").text(data.secondDouble), $(s).find(".two3").text(data.secondBig), $(s).find(".two4").text(data.secondSmall), $(s).find(".three1").text(data.thirdSingle), $(s).find(".three2").text(data.thirdDouble), $(s).find(".three3").text(data.thirdBig), $(s).find(".three4").text(data.thirdSmall), $(s).find(".four1").text(data.fourthSingle), $(s).find(".four2").text(data.fourthDouble), $(s).find(".four3").text(data.fourthBig), $(s).find(".four4").text(data.fourthSmall), $(s).find(".five1").text(data.fifthSingle), $(s).find(".five2").text(data.fifthDouble), $(s).find(".five3").text(data.fifthBig), $(s).find(".five4").text(data.fifthSmall)
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
    }
}

function loadLongData(t) {
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), data = data.result.data, config.ifdebug, $("#cltxul").empty("");
    for (var e = 0, s = data.length; e < s; e++) {
        var a = typeOf("qiuqiu1", data[e].rank), i = typeOf("stated", data[e].state),
            l = data[e].count >= 5 ? "<span style='color:#f11821'>" + data[e].count + "&nbsp;&nbsp;</span>" : "<span>" + data[e].count + "</span>&nbsp;&nbsp;",
            d = "<li><span>" + a + "</span>：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>";
        11 != data[e].rank && 1 != data[e].rank && 2 != data[e].rank || (d = "<li><span>" + a + "</span>：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>"), $("#cltxul").append(d)
    }
}

function excuteAnimate(t, e) {
    var e = e, s = (t = t).length, a = 0, i = $(e);
    $(i).html("");
    var l = setInterval(function () {
        if (a < s) {
            var e = "<li class='nub" + t[a] + "'><i style='font-size:10px'>" + t[a] + "</i></li>";
            $(i).append(e), a++
        } else clearInterval(l)
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

function createHtmlList(t) {
    var e = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e)), e = e.result.data;
    $("#jrsmhmtj>table").empty(), $("#jrsmhmtj>table").html('<tr><th>期数</th><th id="numberbtn" width="224" class="numberbtn">开奖号码</th><th width=90 colspan="3">总和</th><th>龙虎</th><th colspan="5">1-5球大小</th><th colspan="5">1-5球单双</th><th>前三</th><th>中三</th><th>后三</th></tr>'), $(e).each(function (t) {
        if (t > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
        var e = "", s = this.preDrawCode.split(",");
        if ($(s).each(function () {
            e += "<li class='sscnumblue' style='color:#012537'>" + this + "</li>"
        }), s.length <= 1) i = "<td>" + this.preDrawIssue + "</td><td class='blueqiu'></td><td></td>"; else var a = "style='color:",
            i = "<td>" + this.preDrawIssue + "</td><td class='blueqiu'><ul>" + e + "</ul></td>",
            l = "<td>" + this.sumNum + "</td>", d = "0" == this.sumBigSmall ? "大" : "小",
            n = "大" == d ? a + "#f12d35'" : "'", r = "0" == this.sumSingleDouble ? "单" : "双",
            c = "双" == r ? a + "#f12d35'" : "'", o = typeOf("lhh", this.dragonTiger),
            h = "龙" == o ? a + "#f12d35'" : "'", u = "0" == this.firstBigSmall ? "大" : "小",
            f = "大" == u ? a + "#f12d35'" : "'", m = "0" == this.secondBigSmall ? "大" : "小",
            p = "大" == m ? a + "#f12d35'" : "'", C = "0" == this.thirdBigSmall ? "大" : "小",
            v = "大" == C ? a + "#f12d35'" : "'", b = "0" == this.fourthBigSmall ? "大" : "小",
            y = "大" == b ? a + "#f12d35'" : "'", g = "0" == this.fifthBigSmall ? "大" : "小",
            x = "大" == g ? a + "#f12d35'" : "'", O = "0" == this.firstSingleDouble ? "单" : "双",
            j = "双" == O ? a + "#f12d35'" : "'", S = "0" == this.secondSingleDouble ? "单" : "双",
            D = "双" == S ? a + "#f12d35'" : "'", k = "0" == this.thirdSingleDouble ? "单" : "双",
            T = "双" == k ? a + "#f12d35'" : "'", w = "0" == this.fourthSingleDouble ? "单" : "双",
            q = "双" == w ? a + "#f12d35'" : "'", B = "0" == this.fifthSingleDouble ? "单" : "双",
            N = "双" == B ? a + "#f12d35'" : "'", _ = typeOf("san", this.behindThree),
            F = "对子" == _ ? a + "#f12d35'" : "'", J = typeOf("san", this.betweenThree),
            z = "对子" == J ? a + "#f12d35'" : "'", M = typeOf("san", this.lastThree),
            I = "对子" == M ? a + "#f12d35'" : "'";
        var E = "<tr>" + i + l + "<td " + n + ">" + d + "</td><td " + c + ">" + r + "</td><td " + h + ">" + o + "</td><td " + f + ">" + u + "</td><td " + p + ">" + m + "</td><td " + v + ">" + C + "</td><td " + y + ">" + b + "</td><td " + x + ">" + g + "</td><td " + j + ">" + O + "</td><td " + D + ">" + S + "</td><td " + T + ">" + k + "</td><td " + q + ">" + w + "</td><td " + N + ">" + B + "</td><td " + F + ">" + _ + "</td><td " + z + ">" + J + "</td><td " + I + ">" + M + "</td></tr>";
        $("#jrsmhmtj>table").append(E)
    }), $("table").find("td").each(function () {
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
        if (l.length) {
            for (var s = !1, a = 0; a < l.length; a++) t == l[a] && (l.splice(a, 1), s = !0);
            s || l.push(t)
        } else l.push(t);
        e(!1)
    }

    function e(t) {
        $("#jrsmhmtj").find(".blueqiu li").addClass("selectedOpacity");
        for (var e = 0, s = l.length; e < s; e++) $("#jrsmhmtj .blueqiu li").each(function () {
            $(this).text() == l[e] && $(this).removeClass("selectedOpacity")
        })
    }

    function s(t) {
        if (d.length <= 0) d.push(t); else {
            for (var e = 0, s = d.length; e < s; e++) if (d[e] == t) return;
            d.push(t)
        }
    }

    function a(t, e) {
        $("#jrsmhmtj").find(".blueqiu li");
        var s = $("#dannum").hasClass("selected"), a = $("#shuangnum").hasClass("selected"),
            i = $("#danum").hasClass("selected"), d = $("#xiaonum").hasClass("selected");
        $("#jrsmhmtj .blueqiu li").each(function () {
            var l = $(this).text(), n = l % 2 == 0, r = l >= 5;
            "1" == t ? e ? i ? r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d && r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? r && !n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? r || n ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : n ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "2" == t ? e ? i ? r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d && r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? r && n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? !r && n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "3" == t ? e ? s ? n ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? r && !n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a ? r && n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "4" == t && (e ? s ? n ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? r || n ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? !r && n ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
        }), $("#jrsmhmtj .blueqiu li").each(function (t) {
            $(this).text() == l[t] && $(this).removeClass("selectedOpacity")
        })
    }

    function i(t) {
        $("#jrsmhmtj").find(".blueqiu li"), $("#jrsmhmtj>table>tbody").children();
        if ($("#daxiaodsfb").find("li").removeClass("selected"), t) return $("#duizinum").removeClass("selected"), void $("#jrsmhmtj .blueqiu li").removeClass("selectedOpacity");
        $("#duizinum").addClass("selected"), $("#jrsmhmtj .blueqiu li").addClass("selectedOpacity");
        var e = [], s = $("#jrsmhmtj tr"), a = s.length;
        if (!(a <= 1)) {
            for (var i = $(s[0]).find("li"), l = 0; l < 10; l++) e.push($(i[l]).text());
            for (l = 1; l < a; l++) for (var d = $(s[l]).find("li"), n = 0; n < 10; n++) {
                var r = $(d[n]).text();
                r == e[n] && ($(d[n]).removeClass("selectedOpacity"), $($(s[l - 1]).find("li")[n]).removeClass("selectedOpacity")), e[n] = r
            }
        }
    }

    $("#gotop").click(function () {
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
    var l = [];
    $("#chakanchfb").delegate("li", "click", function () {
        if ($("#daxiaodsfb").find("li").removeClass("selected"), $(this).hasClass("selected")) $(this).removeClass("selected"), t($(this).attr("class")), l.length + 1 == 1 && (l = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).hasClass("reset") ? (l = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : (t($(this).attr("class")), $(this).addClass("selected"))
        }
    });
    var d = [];
    $("#daxiaodsfb").delegate("li", "click", function () {
        $("#chakanchfb").find("li").removeClass("selected"), l = [];
        var t = $(this).attr("id"), e = $(this).hasClass("selected");
        "dannum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#shuangnum").removeClass("selected")) : "shuangnum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#dannum").removeClass("selected")) : "danum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#xiaonum").removeClass("selected")) : "xiaonum" == t && (e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#danum").removeClass("selected"))), $(this).hasClass("kaijiltit") || ($(this).hasClass("reset") ? ($(this).siblings().removeClass("selected"), $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : "danum" == t ? ($("#duizinum").removeClass("selected"), s(2), a(3, e)) : "xiaonum" == t ? ($("#duizinum").removeClass("selected"), s(2), a(4, e)) : "dannum" == t ? ($("#duizinum").removeClass("selected"), s(1), a(1, e)) : "shuangnum" == t ? ($("#duizinum").removeClass("selected"), s(1), a(2, e)) : "duizinum" == t && i(e))
    }), $(".numberbtn span").live("click", function () {
        var t = $(this).attr("id");
        $(this).siblings().removeClass("spanselect"), $(this).hasClass("spanselect") ? $(this).removeClass() : $(this).addClass("spanselect"), $("#jrsmhmtj .blueqiu li").each(function (e) {
            var s = $(this).text(), a = s % 2 == 0, i = s >= 5;
            "xshm" == t ? ($(this).removeClass(), (e + 1) % 10 == 0 && $(this).addClass("numsm" + s + " li_after")) : "xsdx" == t ? ($(this).removeClass(), i ? ($(this).addClass("bignum"), (e + 1) % 10 == 0 && $(this).addClass("bignum li_after")) : ($(this).addClass("smallnum"), (e + 1) % 10 == 0 && $(this).addClass("smallnum li_after"))) : "xsds" == t && ($(this).removeClass(), a ? ($(this).addClass("evennum"), (e + 1) % 10 == 0 && $(this).addClass("evennum li_after")) : ($(this).addClass("singularnum"), (e + 1) % 10 == 0 && $(this).addClass("singularnum li_after")))
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
var localllistdata = {}, localheaddata = {}, intervalPk10 = null, reloadotherData = null, listdata = {};