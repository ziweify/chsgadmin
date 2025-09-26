function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(t) {
    var e = setTimeout("sendj()", 100), n = "";
    lilength == t.length - 1 && (n = "li_after", clearTimeout(e), lilength = 0), $("#jnumber").append("<li class='nub" + t[lilength] + " " + n + "'></li>"), lilength++
}

function excutek() {
    for (var t = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], e = 0, n = t.length; e < n; e++) {
        var s = Math.floor(Math.random() * t.length);
        res[e] = t[s], t.splice(s, 1)
    }
    for (var a = 0, n = jnumber.length; a < n; a++) jnumber[a].className = "nub" + res[a], a == n - 1 && (jnumber[a].style.marginRight = "0");
    time++;
    var i = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(i), $("#jnumber").html("");
        sendj()
    }
}

function loadotherData() {
    listData()
}

function listData() {
    $.ajax({
        url: urlbublic + "LuckTwenty/getBaseLuckTwentyList.do?date=",
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

function loadLongData(t) {
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), data = data.result.data, config.ifdebug, $("#cltxul").empty("");
    for (var e = 0, n = data.length; e < n; e++) {
        var s = typeOf("qiuqiu", data[e].rank), a = typeOf("state1", data[e].state),
            i = data[e].count >= 5 ? "<span style='color:#f11821'>" + data[e].count + "&nbsp;&nbsp;</span>" : "<span>" + data[e].count + "&nbsp;&nbsp;</span>",
            o = "<li>第<span>" + s + "</span>球：&nbsp;&nbsp;<span>" + a + "</span>&nbsp;&nbsp;" + i + "期</li>";
        9 == data[e].rank && (o = "<li><span>" + s + "</span>：&nbsp;&nbsp;<span>" + a + "</span>&nbsp;&nbsp;" + i + "期</li>"), $("#cltxul").append(o)
    }
}

function getSystime() {
    var t = new Date, e = t.getFullYear(), n = t.getMonth() + 1, s = t.getDate();
    t.getDay(), t.getHours(), t.getMinutes(), t.getSeconds(), document.getElementById("Date");
    return e + "-" + n + "-" + s
}

function createHtmlList(t) {
    var e = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e)), e = e.result.data;
    $("#jrsmhmtj>table").empty(), $("#jrsmhmtj>table").html('<tr><th width=136>时间</th><th>期数</th><th id="numberbtn" class="numberbtn" width=530><span id="kjhm">开奖号码</span></th><th colspan="3">总和</th><th>单双</th><th>前后</th><th>总和组合</th><th>五行</th></tr>'), $(e).each(function (t) {
        if (t > jsCode.count && -1 != $.inArray(lotCode, jsCode.code)) return !1;
        var e = "<td>" + this.preDrawTime + "</td><td>" + this.preDrawIssue + "</td>", n = "",
            s = this.preDrawCode.split(",");
        $(s).each(function (t) {
            t != s.length - 1 ? n += 9 == t ? this > 40 ? "<li class='numWeightblueKong tabLine' style='color:#012537'><i>" + this + "</i></li>" : "<li class='numLightblueKong tabLine' style='color:#0b84ad'><i>" + this + "</i></li>" : this > 40 ? "<li class='numWeightblueKong' style='color:#012537'><i>" + this + "</i></li>" : "<li class='numLightblueKong' style='color:#0b84ad'><i>" + this + "</i></li>" : "10054" == lotCode || "10082" == lotCode || "10073" == lotCode ? n += "<li class='numWeightblueKong tabLine' style='color:#012537'><i>" + this + "</i></li>" : n += "<li class='numOrangeKong' style='color:#f9982e'><i>" + this + "</i></li>"
        });
        var a = "style='color:", i = "<td>" + this.sumNum + "</td>";
        if (s.length <= 1) o = "<td class='blueqiu'></td>"; else {
            var o = "<td class='blueqiu'><ul>" + n + "</ul></td>", r = typeOf("dxh", this.sumBigSmall),
                l = "大" == r ? a + "#f12d35'" : "'", u = typeOf("dsh", this.sumSingleDouble),
                c = "双" == u ? a + "#f13d35'" : "'", d = typeOf("dsd", this.singleDoubleCount);
            if ("双多" == d) h = a + "#f12d35'"; else if ("单双和" == d) h = a + "#2EADDC'"; else var h = a + "'";
            var f = typeOf("qhh", this.frontBehindCount);
            if ("后多" == f) m = a + "#f12d35'"; else if ("前后和" == f) m = a + "#2EADDC'"; else m = a + "'";
            var m = "后多" == f ? a + "#f12d35'" : "'", p = typeOf("zhzh", this.sumBsSd), b = a + "'",
                g = typeOf("wuxing", this.sumWuXing), y = a + "'"
        }
        var j = "<tr>" + e + o + i + ("<td " + l + ">" + r + "</td><td " + c + ">" + u + "</td><td " + h + ">" + d + "</td><td " + m + ">" + f + "</td><td " + b + ">" + p + "</td><td " + y + ">" + g + "</td>") + "</tr>";
        $("#jrsmhmtj>table").append(j)
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
    animateMethod.loadingList("#jrsmhmtj", !0), $("#morelist").mouseover(function () {
        $(".sub_morelist").show(), $(".more").css("border-color", "#fa8e19").css("border-bottom-color", "#ffffff").css("color", "#fa8e19"), $(".graypre").css("display", "none"), $(".yellowpre").css("display", "inline-block")
    }).mouseout(function () {
        $(".sub_morelist").hide(), $(".more").css("border-color", "#ffffff").css("color", "#333333"), $(".graypre").css("display", "inline-block"), $(".yellowpre").css("display", "none")
    }), $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    })
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0, intervalPk10 = null, reloaddata = null, listdata = {};