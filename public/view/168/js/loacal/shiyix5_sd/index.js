function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(e) {
    var t = setTimeout("sendj()", 100), s = "";
    lilength == e.length - 1 && (s = "li_after", clearTimeout(t), lilength = 0), $("#jnumber").append("<li class='nub" + e[lilength] + " " + s + "'></li>"), lilength++
}

function excutek() {
    for (var e = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], t = 0, s = e.length; t < s; t++) {
        var a = Math.floor(Math.random() * e.length);
        res[t] = e[a], e.splice(a, 1)
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
        url: urlbublic + "ElevenFive/getElevenFiveList.do?date=",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (e) {
            createHtmlList(e), animateMethod.loadingList("#jrsmhmtj", !1)
        },
        error: function (e) {
            setTimeout(function () {
                loadotherData()
            }, config.listTime), config.ifdebug
        }
    })
}

function todayData() {
    $.ajax({
        url: urlbublic + "ElevenFive/queryDoubleNumber.do",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (e) {
            loadTodayData(e)
        },
        error: function (e) {
            config.ifdebug
        },
        complete: function () {
            tools.undefindeInitZero()
        }
    })
}

function longData() {
    $.ajax({
        url: urlbublic + "ElevenFive/getElevenFiveDailyDragon.do",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (e) {
            loadLongData(e)
        },
        error: function (e) {
            config.ifdebug
        }
    })
}

function parseTonum(e) {
    return 1 * e.charAt(0) <= 0 ? e.charAt(1) : e
}

function loadTodayData(e) {
    "object" != (void 0 === e ? "undefined" : _typeof(e)) ? data = JSON.parse(e) : (data = JSON.stringify(e), data = JSON.parse(data)), data = data.result.data;
    var t = $("#shuanmiandata");
    $(t).find(".cs1").text(data.numOne), $(t).find(".cs2").text(data.numTwo), $(t).find(".cs3").text(data.numThree), $(t).find(".cs4").text(data.numFour), $(t).find(".cs5").text(data.numFive), $(t).find(".cs6").text(data.numSix), $(t).find(".cs7").text(data.numSeven), $(t).find(".cs8").text(data.numEight), $(t).find(".cs9").text(data.numNine), $(t).find(".cs10").text(data.numTen), $(t).find(".cs11").text(data.numEleven);
    var s = $("#gylhcs");
    $(s).find(".tt1").text(data.sumSingle), $(s).find(".tt2").text(data.sumDouble), $(s).find(".tt3").text(data.sumBig), $(s).find(".tt4").text(data.sumSmall), $(s).find(".one1").text(data.firstSingle), $(s).find(".one2").text(data.firstDouble), $(s).find(".one3").text(data.firstBig), $(s).find(".one4").text(data.firstSmall), $(s).find(".two1").text(data.secondSingle), $(s).find(".two2").text(data.secondDouble), $(s).find(".two3").text(data.secondBig), $(s).find(".two4").text(data.secondSmall), $(s).find(".three1").text(data.thirdSingle), $(s).find(".three2").text(data.thirdDouble), $(s).find(".three3").text(data.thirdBig), $(s).find(".three4").text(data.thirdSmall), $(s).find(".four1").text(data.fourthSingle), $(s).find(".four2").text(data.fourthDouble), $(s).find(".four3").text(data.fourthBig), $(s).find(".four4").text(data.fourthSmall), $(s).find(".five1").text(data.fifthSingle), $(s).find(".five2").text(data.fifthDouble), $(s).find(".five3").text(data.fifthBig), $(s).find(".five4").text(data.fifthSmall)
}

function minci(e, t) {
    if ("rank" == t) switch (1 * e) {
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
    } else if ("state" == t) switch (1 * e) {
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

function loadLongData(e) {
    "object" != (void 0 === e ? "undefined" : _typeof(e)) ? data = JSON.parse(e) : (data = JSON.stringify(e), data = JSON.parse(data)), data = data.result.data, config.ifdebug, $("#cltxul").empty("");
    for (var t = 0, s = data.length; t < s; t++) {
        var a = typeOf("qiu2", data[t].rank), i = typeOf("state1", data[t].state),
            l = data[t].count >= 5 ? "<span style='color:#f11821'>" + data[t].count + "&nbsp;&nbsp;</span>" : "<span>" + data[t].count + "&nbsp;&nbsp;</span>";
        data[t].state;
        if (data[t].rank < 6) n = "<li>第<span>" + a + "</span>球：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>"; else if (6 == data[t].rank) n = "<li>和值 :&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>"; else if (7 == data[t].rank) var n = "<li>尾数 :&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>";
        11 == data[t].rank && (n = "<li><span>" + a + "</span>：&nbsp;&nbsp;<span>" + i + "</span>&nbsp;&nbsp;" + l + "期</li>"), $("#cltxul").append(n)
    }
}

function getSystime() {
    var e = new Date, t = e.getFullYear(), s = e.getMonth() + 1, a = e.getDate();
    e.getDay(), e.getHours(), e.getMinutes(), e.getSeconds(), document.getElementById("Date");
    return t + "-" + s + "-" + a
}

function clearinterval(e) {
    clearInterval(intervalPk10)
}

function createHtmlList(e) {
    var t = null;
    "object" != (void 0 === e ? "undefined" : _typeof(e)) ? t = JSON.parse(e) : (t = JSON.stringify(e), t = JSON.parse(t)), t = t.result.data;
    $("#jrsmhmtj>table").empty(), $("#jrsmhmtj>table").html('<tr><th width=150>时间</th><th width=80>期数</th><th id="numberbtn" class="numberbtn" width=286><span id="xshm" class="spanselect">显示号码</span><span id="xsdx">显示大小</span><span id="xsds">显示单双</span></th><th colspan="3">总和</th><th>龙虎</th><th>前三</th><th>中三</th><th>后三</th></tr>'), $(t).each(function (e) {
        if (e > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
        var t = "<td>" + this.preDrawTime + "</td><td>" + this.preDrawIssue + "</td>", s = "",
            a = this.preDrawCode.split(",");
        $(a).each(function () {
            s += "<li class='sscnumblue' style='color:#012537'><i>" + this + "</i></li>"
        });
        var i = "style='color:", l = "<td>" + this.sumNum + "</td>";
        if (a.length <= 1) n = "<td class='blueqiu'></td>"; else {
            var n = "<td class='blueqiu'><ul style='width:242px'>" + s + "</ul></td>",
                d = typeOf("dxh", this.sumBigSmall), r = "";
            "0" == this.sumSingleDouble ? r = "单" : "1" == this.sumSingleDouble ? r = "双" : "2" == this.sumSingleDouble && (r = "和");
            var c = "大" == d ? i + "#f12d35'" : "'", o = "双" == r ? i + "#f12d35'" : "''",
                u = "0" == this.dragonTiger ? "龙" : "虎", h = "龙" == u ? i + "#f12d35'" : "'",
                m = typeOf("san", this.behindThree), f = "顺子" == m ? i + "#f12d35'" : "'",
                p = typeOf("san", this.betweenThree), b = "顺子" == p ? i + "#f12d35'" : "'",
                v = typeOf("san", this.lastThree), y = "顺子" == v ? i + "#f12d35'" : "'"
        }
        var C = "<tr>" + t + n + l + ("<td " + c + ">" + d + "</td><td " + o + ">" + r + "</td><td " + h + ">" + u + "</td><td " + f + ">" + m + "</td><td " + b + ">" + p + "</td><td " + y + ">" + v + "</td>") + "</tr>";
        $("#jrsmhmtj>table").append(C)
    }), $("table").find("td").each(function () {
        "undefined" == $(this).text() && $(this).text("")
    })
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
    return typeof e
} : function (e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
};
$(function () {
    function e(e) {
        if (l.length) {
            for (var s = !1, a = 0; a < l.length; a++) e == l[a] && (l.splice(a, 1), s = !0);
            s || l.push(e)
        } else l.push(e);
        t(!1)
    }

    function t(e) {
        $("#jrsmhmtj").find(".blueqiu li").addClass("selectedOpacity");
        for (var t = 0, s = l.length; t < s; t++) $("#jrsmhmtj .blueqiu li").each(function () {
            $(this).text() == l[t] && $(this).removeClass("selectedOpacity")
        })
    }

    function s(e) {
        if (n.length <= 0) n.push(e); else {
            for (var t = 0, s = n.length; t < s; t++) if (n[t] == e) return;
            n.push(e)
        }
    }

    function a(e, t) {
        $("#jrsmhmtj").find(".blueqiu li");
        var s = $("#dannum").hasClass("selected"), a = $("#shuangnum").hasClass("selected"),
            i = $("#danum").hasClass("selected"), n = $("#xiaonum").hasClass("selected");
        $("#jrsmhmtj .blueqiu li").each(function () {
            var l = $(this).text(), d = l % 2 == 0, r = l > 5;
            "1" == e ? t ? i ? r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? r && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? r || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "2" == e ? t ? i ? r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? !r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "3" == e ? t ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? r && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a ? r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "4" == e && (t ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? r || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : a ? !r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
        }), $("#jrsmhmtj .blueqiu li").each(function (e) {
            $(this).text() == l[e] && $(this).removeClass("selectedOpacity")
        })
    }

    function i(e) {
        $("#jrsmhmtj").find(".blueqiu li"), $("#jrsmhmtj>table>tbody").children();
        if ($("#daxiaodsfb").find("li").removeClass("selected"), e) return $("#duizinum").removeClass("selected"), void $("#jrsmhmtj .blueqiu li").removeClass("selectedOpacity");
        $("#duizinum").addClass("selected"), $("#jrsmhmtj .blueqiu li").addClass("selectedOpacity");
        var t = [], s = $("#jrsmhmtj tr"), a = s.length;
        if (!(a <= 1)) {
            for (var i = $(s[0]).find("li"), l = 0; l < 10; l++) t.push($(i[l]).text());
            for (l = 1; l < a; l++) for (var n = $(s[l]).find("li"), d = 0; d < 10; d++) {
                var r = $(n[d]).text();
                r == t[d] && ($(n[d]).removeClass("selectedOpacity"), $($(s[l - 1]).find("li")[d]).removeClass("selectedOpacity")), t[d] = r
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
        var e = $(this).attr("id");
        if ($(this).hasClass("selected")) $(this).removeClass("selected"), "jrsmtj" == e ? $("." + e).hide("200") : "cltx" == e ? $("." + e).hide("200") : "hmfb" == e && ($("." + e).hide("100"), $("." + e).animate({opacity: "0"}, 200)); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).addClass("selected"), "jrsmtj" == e ? $("." + e).show("200") : "cltx" == e ? $("." + e).show("200") : "hmfb" == e && ($("." + e).show("100"), $("." + e).animate({opacity: "1"}, 200))
        }
    });
    var l = [];
    $("#chakanchfb").delegate("li", "click", function () {
        if ($("#daxiaodsfb").find("li").removeClass("selected"), $(this).hasClass("selected")) $(this).removeClass("selected"), e($(this).attr("class")), l.length + 1 == 1 && (l = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).hasClass("reset") ? (l = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : (e($(this).attr("class")), $(this).addClass("selected"))
        }
    });
    var n = [];
    $("#daxiaodsfb").delegate("li", "click", function () {
        $("#chakanchfb").find("li").removeClass("selected"), l = [];
        var e = $(this).attr("id"), t = $(this).hasClass("selected");
        "dannum" == e ? t ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#shuangnum").removeClass("selected")) : "shuangnum" == e ? t ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#dannum").removeClass("selected")) : "danum" == e ? t ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#xiaonum").removeClass("selected")) : "xiaonum" == e && (t ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#danum").removeClass("selected"))), $(this).hasClass("kaijiltit") || ($(this).hasClass("reset") ? ($(this).siblings().removeClass("selected"), $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : "danum" == e ? ($("#duizinum").removeClass("selected"), s(2), a(3, t)) : "xiaonum" == e ? ($("#duizinum").removeClass("selected"), s(2), a(4, t)) : "dannum" == e ? ($("#duizinum").removeClass("selected"), s(1), a(1, t)) : "shuangnum" == e ? ($("#duizinum").removeClass("selected"), s(1), a(2, t)) : "duizinum" == e && i(t))
    }), $("#jrsmhmtj").on("click", "li", function () {
        var e = {bluebig: "danum", bluesmall: "xiaonum", bluesingular: "dannum", blueeven: "shuangnum"}, t = $("#hmfb");
        t.hasClass("selected") || t.addClass("selected");
        var s, a = this.className.replace("selectedOpacity", "").trim();
        s = a.indexOf("sscnumblue") > -1 ? "." + $(this).text() : "#" + e[a], $(s).trigger("click")
    }), $(".numberbtn span").live("click", function () {
        $(this).attr("id");
        $(this).siblings().removeClass("spanselect"), $(this).hasClass("spanselect") ? $(this).removeClass() : $(this).addClass("spanselect"), tools.bigOrSmallTot($(this).attr("id"), 6)
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
var reloadotherData = null, listdata = {};