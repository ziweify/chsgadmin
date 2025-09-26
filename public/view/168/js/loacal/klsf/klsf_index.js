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
        url: urlbublic + "klsf/getHistoryLotteryInfo.do?date=",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            createHtmlList(t), animateMethod.loadingList("#jrsmhmtj", !1)
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
        url: urlbublic + "klsf/getKlsfDoubleCount.do",
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
        url: urlbublic + "klsf/getKlsfLongDragonCount.do",
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
    $(e).find(".one1").text(data.firstSingleCount), $(e).find(".one2").text(data.firstDoubleCount), $(e).find(".one3").text(data.firstBigCount), $(e).find(".one4").text(data.firstSmallCount), $(e).find(".two1").text(data.secondSingleCount), $(e).find(".two2").text(data.secondDoubleCount), $(e).find(".two3").text(data.secondBigCount), $(e).find(".two4").text(data.secondSmallCount), $(e).find(".three1").text(data.thirdSingleCount), $(e).find(".three2").text(data.thirdDoubleCount), $(e).find(".three3").text(data.thirdBigCount), $(e).find(".three4").text(data.thirdSmallCount), $(e).find(".four1").text(data.fourthSingleCount), $(e).find(".four2").text(data.fourthDoubleCount), $(e).find(".four3").text(data.fourthBigCount), $(e).find(".four4").text(data.fourthSmallCount), $(e).find(".five1").text(data.fifthSingleCount), $(e).find(".five2").text(data.fifthDoubleCount), $(e).find(".five3").text(data.fifthBigCount), $(e).find(".five4").text(data.fifthSmallCount), $(e).find(".six1").text(data.sixthSingleCount), $(e).find(".six2").text(data.sixthDoubleCount), $(e).find(".six3").text(data.sixthBigCount), $(e).find(".six4").text(data.sixthSmallCount), $(e).find(".seven1").text(data.seventhSingleCount), $(e).find(".seven2").text(data.seventhDoubleCount), $(e).find(".seven3").text(data.seventhBigCount), $(e).find(".seven4").text(data.seventhSmallCount), $(e).find(".eight1").text(data.eighthSingleCount), $(e).find(".eight2").text(data.eighthDoubleCount), $(e).find(".eight3").text(data.eighthBigCount), $(e).find(".eight4").text(data.eighthSmallCount);
    var s = $("#gylhcs");
    $(s).find(".tt1").text(data.sumSingleCount), $(s).find(".tt2").text(data.sumDoubleCount), $(s).find(".tt3").text(data.sumBigCount), $(s).find(".tt4").text(data.sumSmallCount), $(s).find(".onel").text(data.firstDragonCount), $(s).find(".oneh").text(data.firstTigerCount), $(s).find(".twol").text(data.secondDragonCount), $(s).find(".twoh").text(data.secondTigerCount), $(s).find(".threel").text(data.thirdDragonCount), $(s).find(".threeh").text(data.thirdTigerCount), $(s).find(".fourl").text(data.fourthDragonCount), $(s).find(".fourh").text(data.fourthTigerCount)
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
        var a = typeOf("qiuqiu", data[e].rank), i = typeOf("state1", data[e].state),
            l = data[e].count >= 5 ? "<span style='color:#f11821'>" + data[e].count + "&nbsp;&nbsp;</span>" : "<span>" + data[e].count + "&nbsp;&nbsp;</span>",
            n = "<li>第<span>" + a + "</span>球：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>";
        9 == data[e].rank && (n = "<li><span>" + a + "</span>：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>"), $("#cltxul").append(n)
    }
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
    $("#jrsmhmtj>table").empty(), $("#jrsmhmtj>table").html('<tr><th width=150>时间</th><th width=80>期数</th><th id="numberbtn" class="numberbtn" width=330><span id="xshm" class="spanselect">显示号码</span><span id="xsdx">显示大小</span><span id="xsds">显示单双</span></th><th colspan="3">总和</th><th>尾大小</th><th colspan="4">龙虎</th></tr>'), $(e).each(function (t) {
        if (t > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
        var e = "<td>" + this.preDrawTime + "</td><td>" + this.preDrawIssue + "</td>", s = "",
            a = this.preDrawCode.split(",");
        $(a).each(function () {
            s += this >= 19 ? "<li class='numredkong' style='color:#012537'><i>" + this + "</i></li>" : "<li class='numblue' style='color:#012537'><i>" + this + "</i></li>"
        });
        var i = "style='color:", l = "<td>" + this.sumNum + "</td>";
        if (a.length <= 1) n = "<td class='blueqiu'></td>"; else var n = "<td class='blueqiu'><ul class='klsf_kaiul'>" + s + "</ul></td>",
            d = "0" == this.sumSingleDouble ? "单" : "双", o = "双" == d ? i + "#f12d35'" : "'",
            r = typeOf("dxh", this.sumBigSmall), c = "大" == r ? i + "#f13d35'" : "'",
            u = "0" == this.lastBigSmall ? "尾大" : "尾小", h = "尾大" == u ? i + "#f12d35'" : "'",
            f = "0" == this.firstDragonTiger ? "龙" : "虎", m = "龙" == f ? i + "#f12d35'" : "'",
            p = "0" == this.secondDragonTiger ? "龙" : "虎", C = "龙" == p ? i + "#f12d35'" : "'",
            g = "0" == this.thirdDragonTiger ? "龙" : "虎", b = "龙" == g ? i + "#f12d35'" : "'",
            v = "0" == this.fourthDragonTiger ? "龙" : "虎", y = "龙" == v ? i + "#f12d35'" : "'";
        var x = "<tr>" + e + n + l + ("<td " + o + ">" + d + "</td><td " + c + ">" + r + "</td><td " + h + ">" + u + "</td><td " + m + ">" + f + "</td><td " + C + ">" + p + "</td><td " + b + ">" + g + "</td><td " + y + ">" + v + "</td>") + "</tr>";
        $("#jrsmhmtj>table").append(x)
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
        if (n.length <= 0) n.push(t); else {
            for (var e = 0, s = n.length; e < s; e++) if (n[e] == t) return;
            n.push(t)
        }
    }

    function a(t, e) {
        $("#jrsmhmtj").find(".blueqiu li");
        var s = $("#dannum").hasClass("selected"), a = $("#shuangnum").hasClass("selected"),
            i = $("#danum").hasClass("selected"), n = $("#xiaonum").hasClass("selected");
        $("#jrsmhmtj .blueqiu li").each(function () {
            var l = $(this).text(), d = l % 2 == 0, o = l > 10;
            "1" == t ? e ? i ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "2" == t ? e ? i ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "3" == t ? e ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "4" == t && (e ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
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
            for (l = 1; l < a; l++) for (var n = $(s[l]).find("li"), d = 0; d < 10; d++) {
                var o = $(n[d]).text();
                o == e[d] && ($(n[d]).removeClass("selectedOpacity"), $($(s[l - 1]).find("li")[d]).removeClass("selectedOpacity")), e[d] = o
            }
        }
    }

    animateMethod.loadingList("#jrsmhmtj", !0), $("#morelist").mouseover(function () {
        $(".sub_morelist").show(), $(".more").css("border-color", "#fa8e19").css("border-bottom-color", "#ffffff").css("color", "#fa8e19"), $(".graypre").css("display", "none"), $(".yellowpre").css("display", "inline-block")
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
    var l = [];
    $("#chakanchfb").delegate("li", "click", function () {
        if ($("#daxiaodsfb").find("li").removeClass("selected"), $(this).hasClass("selected")) $(this).removeClass("selected"), t($(this).attr("class")), l.length + 1 == 1 && (l = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).hasClass("reset") ? (l = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : (t($(this).attr("class")), $(this).addClass("selected"))
        }
    });
    var n = [];
    $("#daxiaodsfb").delegate("li", "click", function () {
        $("#chakanchfb").find("li").removeClass("selected"), l = [];
        var t = $(this).attr("id"), e = $(this).hasClass("selected");
        "dannum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#shuangnum").removeClass("selected")) : "shuangnum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#dannum").removeClass("selected")) : "danum" == t ? e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#xiaonum").removeClass("selected")) : "xiaonum" == t && (e ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#danum").removeClass("selected"))), $(this).hasClass("kaijiltit") || ($(this).hasClass("reset") ? ($(this).siblings().removeClass("selected"), $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : "danum" == t ? ($("#duizinum").removeClass("selected"), s(2), a(3, e)) : "xiaonum" == t ? ($("#duizinum").removeClass("selected"), s(2), a(4, e)) : "dannum" == t ? ($("#duizinum").removeClass("selected"), s(1), a(1, e)) : "shuangnum" == t ? ($("#duizinum").removeClass("selected"), s(1), a(2, e)) : "duizinum" == t && i(e))
    }), $("#jrsmhmtj").on("click", "li", function () {
        var t = {bluebig: "danum", bluesmall: "xiaonum", bluesingular: "dannum", blueeven: "shuangnum"}, e = $("#hmfb");
        e.hasClass("selected") || e.trigger("click");
        var s, a = this.className.replace("selectedOpacity", "").trim();
        s = a.indexOf("numblue") > -1 ? "." + $(this).text() : "#" + t[a], $(s).trigger("click")
    }), $(".numberbtn span").live("click", function () {
        $(this).attr("id");
        $(this).siblings().removeClass("spanselect"), $(this).hasClass("spanselect") ? $(this).removeClass() : $(this).addClass("spanselect"), tools.bigOrSmall($(this).attr("id"), 11)
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