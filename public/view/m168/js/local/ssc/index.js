function startVideo() {
    $("#videoiframe").attr('src',config.videourl+"view/video/SSC/index.html?"+lotCode);
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        var t = 880 * $(".animate").width() / 1310;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            //iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
        })
    })
}

function createData() {
    var t = 3600 * $("#headerData").find(".hour").text() + 60 * $("#headerData").find(".minute").text() + 1 * $("#headerData").find(".second").text() - 1;
    "-1" == t && (t = 0);
    var a = $("#pk10num").find("li").text();
    return {
        preDrawCode: [].slice.call(a),
        id: "#numBig",
        counttime: t,
        preDrawIssue: $(".preDrawIssue").text(),
        drawTime: "",
        sumNum: $("#headerData").find(".longhu li:nth-child(4)").text(),
        sumSingleDouble: $("#headerData").find(".longhu li:nth-child(5)").text(),
        sumBigSmall: $("#headerData").find(".longhu li:nth-child(6)").text(),
        dragonTiger: $("#headerData").find(".longhu li:nth-child(1)").text()
    }
}

function runFilterRender() {
    var t = $(".haomafb .dansdxbtn .lichecked").text();
    t ? runSelectedHm(t, !1) : runNumFilter()
}

function throttle(t, a, s) {
    var e, l = +new Date;
    return function () {
        var i = +new Date, n = this, d = arguments;
        clearTimeout(e), i - l >= s ? (t.apply(n, d), l = i) : e = setTimeout(function () {
            t.apply(n, d)
        }, a)
    }
}

function createHtmlStr(t, a) {
    var s = "";
    $(t).each(function (t) {
        s += '<div class="listotherline bortop001 ssclist">', s += '<div class="leftspan">', s += '<span class="boxflex">';
        var a = this.preDrawTime;
        a = a.substring(a.length - 8, a.length - 3), s += '<span class="graytime">' + a + "</span>", s += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", s += "</span>", s += "</div>", s += '<div class="rightspan">', s += '<div class="rightdiv" style="padding-left:0">', s += '<div class="haomali"><ul id="" class="ssclilist listli">';
        var e = this.preDrawCode.split(",");
        $(e).each(function (t) {
            "" != e && (10060 == lotCode ? (e.length, s += '<li><span class="hlnum' + this + '"><i style="display:none;">' + this + "</i></span></li>") : (e.length, s += '<li><span class="bluenum"><i>' + this + "</i></span></li>"))
        }), s += "</ul></div>", s += '<div class="longhuli displaynone"><ul id="" class="ssclilistxt listli lhlist">';
        if (!(e.length <= 1)) {
            var l = "0" == this.sumBigSmall ? "大" : "小", i = "0" == this.sumSingleDouble ? "单" : "双", n = "";
            "0" == this.dragonTiger ? n = "龙" : "1" == this.dragonTiger ? n = "虎" : "2" == this.dragonTiger && (n = "和")
        }
        s += "<li  style='color:#f12d35'>" + this.sumNum + "</li>", s += "大" == l ? "<li style='color:#f12d35'>" + l + "</li>" : "<li style='color:#184dd5'>" + l + "</li>", s += "双" == i ? "<li style='color:#f12d35'>" + i + "</li>" : "<li style='color:#184dd5'>" + i + "</li>", s += "龙" == n ? "<li style='color:#f12d35'>" + n + "</li>" : "和" == n ? "<li style='color:#00ab07 '>" + n + "</li>" : "<li style='color:#184dd5'>" + n + "</li>", "对子" == tools.typeOf("san", this.behindThree) ? s += "<li style='color:#f12d35'>" + tools.typeOf("san", this.behindThree) + "</li>" : s += "<li style='color:#184dd5'>" + tools.typeOf("san", this.behindThree) + "</li>", "对子" == tools.typeOf("san", this.betweenThree) ? s += "<li style='color:#f12d35'>" + tools.typeOf("san", this.betweenThree) + "</li>" : s += "<li style='color:#184dd5'>" + tools.typeOf("san", this.betweenThree) + "</li>", "对子" == tools.typeOf("san", this.lastThree) ? s += "<li style='color:#f12d35'>" + tools.typeOf("san", this.lastThree) + "</li>" : s += "<li style='color:#184dd5'>" + tools.typeOf("san", this.lastThree) + "</li>", s += "</ul>", s += "</div>", s += "</div>", s += "</div>", s += "</div>"
    }), "string" == typeof a ? $(a).append(s) : a.forEach(function (t) {
        return $(t).append(s)
    })
}

function runNumFilter() {
    var t = "";
    $(".numbtn .lichecked").each(function (a, s) {
        t += $(s).text() + ","
    }), t && $("#haomafblist li").addClass("selectedOpacity").each(function (a, s) {
        var e = $(s).text();
        t.indexOf(e) > -1 && $(s).removeClass("selectedOpacity")
    })
}

function runSelectedHm(t, a) {
    var s = $(".dansdxbtn li:nth-child(1)").hasClass("lichecked"),
        e = $(".dansdxbtn li:nth-child(2)").hasClass("lichecked"),
        l = $(".dansdxbtn li:nth-child(3)").hasClass("lichecked"),
        i = $(".dansdxbtn li:nth-child(4)").hasClass("lichecked");
    $("#haomafblist li").each(function () {
        var n = $(this).text(), d = n % 2 == 0, o = n >= 5;
        -1 != t.indexOf("单") ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : -1 != t.indexOf("双") ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("大") ? a ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : e ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("小") && (a ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
    })
}

function eachconten_lhzs(t) {
    $("#trend_table2_gyhzs tbody tr:not([class])").remove(), $(t).each(function (t, a) {
        if (10036 == lotCode) s = config.showrows; else var s = 200;
        if (t >= s) return !1;
        var e = a.issue, l = a.code.split(",");
        l = "<span style='color:red'>" + l[0] + "</span>&nbsp;&nbsp; " + l[1] + "&nbsp;&nbsp;" + l[2] + "&nbsp;&nbsp;" + l[3] + " &nbsp;&nbsp;<span style='color:red'>" + l[4] + "</span>";
        var i = a.array, n = "", d = "", o = i.slice(i.length - 3);
        d += "<tr><td class='nohide'>" + e + "</td><td class='nohide'>" + l + "</td>", $(o).each(function (t) {
            this > 0 ? d += "<td class='hot_gyh'><span style='background:#1fa6e8'>" + (n = 0 == t ? "龙" : 1 == t ? "虎" : "和") + "</span></td>" : (n = Math.abs(this), d += "<td><span>" + n + "</span></td>")
        }), d += "</tr>", 0 != $("#trend_table2_gyhzs tbody tr.clospan_gyh:first").length ? $("#trend_table2_gyhzs tbody tr.clospan_gyh:first").before(d) : $("#trend_table2_gyhzs tbody").append(d)
    })
}

function fancongshow_gyh() {
    for (var t = $(".gyhdateBox tbody tr"), a = (t = t.slice(0, t.length - 5)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var l = 0; l <= a; l++) {
        var i = t.eq(l).children("td").eq(e);
        if (i.hasClass("hot_gyh")) break;
        i.addClass("fancongcls_gyh")
    }
}

function orshowConten_gyh() {
    if ($("#F_gyhzs_fx li[data-value='fgx']").hasClass("check_tj")) {
        $(".line_gyh").remove();
        for (var t = $(".gyhdateBox tbody tr"), a = 2, s = t.length - 5; a < s; a += 5) $(t[a]).after("<tr class='line_gyh'><td colspan='5'></td></tr>")
    } else $(".line_gyh").remove();
    $("#F_gyhzs_fx li[data-value='fancong']").hasClass("check_tj") ? fancongshow_gyh() : $(".fancongcls_gyh").removeClass("fancongcls_gyh").addClass("showspan"), $("#F_gyhzs_fx li[data-value='yilo']").hasClass("check_tj") ? $("#trend_table2_gyhzs tbody tr td span").show() : ($(".fancongcls_gyh span").hide(), $("#trend_table2_gyhzs tbody tr td:not([class]) span").hide(), $(".showspan span").hide()), $("#F_gyhzs_fx li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.guanyaheLine("trend_table2_gyhzs")
    }, 500) : $("canvas").remove()
}

function animate_lz_hmqh() {
    var t = 0, a = $(".lz_content>div .lz_item>table>tbody>.tablebox td:first-child p:last-child");
    a.css("font-weight", "bold");
    var s = setTimeout(function () {
        a.fadeOut(100).fadeIn(100), 1 == ++t && (s = setInterval(arguments.callee, 600)), 30 == t && window.clearInterval(s)
    }, 1e3);
    $(function () {
        var t = setInterval(function () {
            0 != $(".tb").length && clearInterval(t), $(".tb").css({color: "#fff", background: "#ED2842"})
        }, 200)
    })
}

function typeOf_lhlz(t, a) {
    if ("code" == a) switch (1 * t) {
        case 1:
            return "号码 0";
        case 2:
            return "号码 1";
        case 3:
            return "号码 2";
        case 4:
            return "号码 3";
        case 5:
            return "号码 4";
        case 6:
            return "号码 5";
        case 7:
            return "号码 6";
        case 8:
            return "号码 7";
        case 9:
            return "号码 8";
        case 10:
            return "号码 9"
    }
}

function checkhmqhlzHm() {
    var t = $("#hmqhlzmcul").find(".hmqhlzHMAct");
    $(".tablelist").hide(), $(t).each(function (t, a) {
        var s = "#" + $(a).attr("value");
        $(s).show()
    })
}

function showSxend() {
    $("#dsdxlzlist .lz_title").hide();
    var t = $("#F_dsdxlzfx").find(".check_tj");
    $(t).each(function (t, a) {
        var s = "." + $(a).attr("data-value"), e = $("#dsdxlzlist").find(s);
        "daxiao" == dxdxlz_val[0] || 0 == dxdxlz_val[0] ? $(e).each(function () {
            $(this).hasClass("daxiaoShow") ? $("#dsdxlzlist").find(this).show() : $("#dsdxlzlist").find(this).hide()
        }) : "danshaung" == dxdxlz_val[0] && $(e).each(function () {
            $(this).hasClass("dansuShow") ? $("#dsdxlzlist").find(this).show() : $("#dsdxlzlist").find(this).hide()
        })
    })
}

function animate_lz_dsdxlz() {
    var t = 0, a = $(".dsdxlz_content>div>.lz_item>table>tbody>.tablebox td:first-child p:last-child");
    a.css("font-weight", "bold");
    var s = setTimeout(function () {
        a.fadeOut(100).fadeIn(100), 1 == ++t && (s = setInterval(arguments.callee, 600)), 30 == t && window.clearInterval(s)
    }, 1e3);
    $(function () {
        var t = setInterval(function () {
            0 != $(".tb").length && clearInterval(t), $(".tb").css({color: "#fff", background: "#ED2842"})
        }, 200)
    })
}

function orshowConten() {
    if ($("#F_dwzs_bzxz li[data-value='caix']").hasClass("check_tj") ? $(".wezizs .hamafb").hasClass("checkspan") && setTimeout(function () {
        $(".wezizs canvas").remove(), chartOfBaseTrend.weizhiLine("trend_table2")
    }, 500) : $(".table_conBox canvas").hide(), $("#F_dwzs_bzxz li[data-value='fancong']").hasClass("check_tj") ? fancongshow_dwzs() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_dwzs_bzxz li[data-value='yilo']").hasClass("check_tj") ? ($("td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), $("#F_dwzs_bzxz li[data-value='fgx']").hasClass("check_tj")) {
        if ($(".line_wzzs").remove(), $(".wezizs .hamafb").hasClass("checkspan")) t = $(".table_hamafb tbody tr"); else if ($(".wezizs .sttz").hasClass("checkspan")) t = $(".table_sttz tbody tr"); else if ($(".wezizs .lu012").hasClass("checkspan")) t = $(".table_lu012 tbody tr"); else if ($(".wezizs .spj").hasClass("checkspan")) var t = $(".table_spj tbody tr");
        for (var a = 2; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>")
    } else $(".line_wzzs").remove()
}

function eachcontent(t) {
    var a = "", s = wz_mc_val[0];
    $(t).each(function (t) {
        a += "<tr>";
        var e = this.code.split(","), l = this.array.slice(0, 10);
        a += " <td>" + this.issue.slice(4) + "</td><td class='tabred'><span>" + e[s] + "</span></td>";
        for (var i = 0; i < l.length; i++) 1 * l[i] > 0 || 1 * l[i] == 0 ? a += "<td class='hot'><span name='hotSpan'>" + l[i] + "</span></td>" : a += "<td><span>" + Math.abs(l[i]) + "</span></td>";
        a += "</tr>"
    }), $("#trend_table2 tbody").html(a + weizifooter)
}

function animate_lz() {
    var t = 0, a = $(".lz_content>div>.lz_item>table>tbody>.tablebox td:first-child p:last-child");
    a.css("font-weight", "bold");
    var s = setTimeout(function () {
        a.fadeOut(100).fadeIn(100), 1 == ++t && (s = setInterval(arguments.callee, 600)), 30 == t && window.clearInterval(s)
    }, 1e3);
    $(function () {
        var t = setInterval(function () {
            0 != $(".tb").length && clearInterval(t), $(".tb").css({color: "#fff", background: "#ED2842"})
        }, 200)
    })
}

function assclass(t) {
    return (t *= 1) >= 15 && t <= 30 ? "rednum_tj" : t >= 31 && t <= 40 ? "bluenum_tj" : t >= 41 && t <= 50 ? "greennum_tj" : ""
}

function fancongshow_dwzs() {
    if ($(".wezizs .hamafb").hasClass("checkspan")) {
        for (var t = (e = (e = $("#trend_table2 tbody tr")).slice(0, e.length - 6)).length, a = e.filter(":first").children("td").size(), s = 2; s < a; s++) for (l = 0; l <= t && !(i = e.eq(l).children("td").eq(s)).hasClass("hot"); l++) i.addClass("fancongcls");
        return !1
    }
    if ($(".wezizs .sttz").hasClass("checkspan")) e = $(".table_sttz tbody tr"); else if ($(".wezizs .lu012").hasClass("checkspan")) e = $(".table_lu012 tbody tr"); else if ($(".wezizs .spj").hasClass("checkspan")) var e = $(".table_spj tbody tr");
    for (var t = (e = e.slice(0, e.length - 6)).length, a = e.filter(":first").children("td").size(), s = 2; s < a; s++) for (var l = 0; l <= t; l++) {
        var i = e.eq(l).children("td").eq(s);
        if (i.hasClass("numeven") || i.hasClass("numodd")) break;
        i.addClass("fancongcls")
    }
}

function orshowConten_siantai() {
    if ($("#F_xtbzxz li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        $(".singtaizs canvas").remove(), chartOfBaseTrend.singtaione("singtai_content"), chartOfBaseTrend.singtaitwo("singtai_content")
    }, 500) : $(".singtaizs canvas").hide(), $("#F_xtbzxz li[data-value='fancong']").hasClass("check_tj")) for (var t = (i = (i = $("#singtai_content tbody tr")).slice(0, i.length - 6)).length, a = i.filter(":first").children("td").size(), s = 4; s < a; s++) for (var e = 0; e <= t; e++) {
        var l = i.eq(e).children("td").eq(s);
        if (l.hasClass("hot")) break;
        l.addClass("fancongcls")
    } else $(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls");
    if ($("#F_xtbzxz li[data-value='yilo']").hasClass("check_tj") ? ($("#singtai_content td:not([class])").find("span").show(), $("#singtai_content .showspan span").show(), $("#singtai_content .fancongcls span").show()) : ($("#singtai_content tbody tr td:not([class])").find("span").hide(), $("#singtai_content .fancongcls span").hide(), $("#singtai_content .showspan span").hide()), $("#F_xtbzxz li[data-value='fgx']").hasClass("check_tj")) {
        var i = $("#singtai_content tbody tr");
        $(".line_wzzs").remove();
        for (s = 2; s < i.length - 6; s += 5) $(i[s]).after("<tr class='line_wzzs'><td></td></tr>")
    } else $(".line_wzzs").remove()
}

function eachconten_stzs(t, a) {
    var s = "";
    0 != $("#singtai_content tbody tr.clospan").length && ($("#singtai_content tbody tr.clospan").remove(), $(".closas").remove());
    $(t).each(function (t) {
        if (10036 == lotCode) e = config.showrows; else var e = 200;
        if (t >= e) return !1;
        var l = $(this)[0].code.split(",");
        if (1 == a) {
            i = l.splice(0, 3);
            $(".bal_index").text("第一球").next().text("第二球").next().text("第三球")
        } else if (2 == a) {
            i = l.splice(1, 3);
            $(".bal_index").text("第二球").next().text("第三球").next().text("第四球")
        } else if (3 == a) {
            var i = l.splice(2, 3);
            $(".bal_index").text("第三球").next().text("第四球").next().text("第五球")
        }
        var n = $(this)[0].array.slice(30);
        s += "<tr><td >" + $(this)[0].issue.toString().slice(4) + "</td><td class='nohide'><span>" + i[0] + "</span></td><td class='nohide'><span>" + i[1] + "</span></td><td class='nohide'><span>" + i[2] + "</span></td>";
        for (var d = 0; d < n.length; d++) {
            var o = "", c = "";
            1 * n[d] > 0 ? (0 == d ? o = "豹子" : 1 == d ? o = "顺子" : 2 == d ? o = "对子" : 3 == d ? o = "半顺" : 4 == d ? o = "杂六" : 5 == d ? (o = "组三", c = "orcls") : 6 == d ? (o = "组六", c = "orcls") : 7 == d && (o = "豹子", c = "orcls"), s += "<td class='hot'><span name='hotSpan' class='" + c + "'>" + o + "</span></td>") : s += "<td><span>" + -1 * n[d] + "</span></td>"
        }
        s += "</tr>"
    }), $("#singtai_content tbody").html(s + stfoterarr)
}

function listettablearr(t) {
    t.length <= config.showrows ? $(".lomorediv").hide() : "none" != $(".haomazs").css("display") ? $(".haomazs  .hamafb").hasClass("checkspan") ? ($(".lomorediv").show().attr("data-text", 0), $(".nextlo").show()) : $(".lomorediv").hide() : ($(".lomorediv").show().attr("data-text", 0), $(".nextlo").show()), dewitabledata = [];
    for (var a = 0, s = Math.ceil(t.length / config.showrows); a < s; a++) {
        var e = [];
        e.push(t.slice(a * config.showrows, (a + 1) * config.showrows)), dewitabledata.push(e)
    }
    $(".prevlo").hide().parent().attr("data-text", 0)
}

function checkDateFun(t, a) {
    a = void 0 == a ? "" : a;
    var s = $(".title_se_box .se_check").attr("target");
    s = (s = $("#" + s + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_ssc(s, t, a)
}

function lzfxdxms() {
    $(".zhfx_meci").text(lzcheckObj.dxms.checkVal_cn), $(".zhfx_model").text("筛选路珠");
    new MobileSelect({
        trigger: ".zhfx_meci",
        title: "选择名次",
        wheels: condition_dxms_mc,
        position: lzcheckObj.dxms.checkIndex,
        callback: function (t, a, s) {
            lzcheckObj.dxms.checkIndex = t, lzcheckObj.dxms.checkVal[0] = a[0].id, lzcheckObj.dxms.checkVal_cn = a[0].value, showlz_listitem(lzcheckObj.dxms.checkVal, lzcheckObj.dxms.select_arr2)
        },
        onShow: function (t) {
            var a = t.curIndexArr.length > 0 ? t.curIndexArr : lzcheckObj.dxms.checkVal[0];
            t.locatePosition(0, a[0])
        }
    }), new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.dxms.select_arr2
        }, trigger: ".zhfx_model", title: "选择路珠", wheels: condition_zh_lz, callback: function (t, a, s) {
            lzcheckObj.dxms.select_arr2 = a, showlz_listitem(lzcheckObj.dxms.checkVal, lzcheckObj.dxms.select_arr2)
        }, onShow: function () {
            this.initSelectedState()
        }
    });
    showlz_listitem(lzcheckObj.dxms.checkVal, lzcheckObj.dxms.select_arr2)
}

function lzfxlmms() {
    $(".zhfx_meci").text("筛选名次"), $(".zhfx_model").text(lzcheckObj.lmms.checkVal_cn);
    new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.lmms.select_arr1
        }, trigger: ".zhfx_meci", title: "选择名次", wheels: condition_zh_mc, callback: function (t, a, s) {
            lzcheckObj.lmms.select_arr1 = a, showlz_listitem(lzcheckObj.lmms.select_arr1, lzcheckObj.lmms.checkVal)
        }, onShow: function () {
            this.initSelectedState()
        }
    }), new MobileSelect({
        trigger: ".zhfx_model",
        title: "选择路珠",
        wheels: condition_lmms_lz,
        position: lzcheckObj.lmms.checkIndex,
        callback: function (t, a, s) {
            lzcheckObj.lmms.checkIndex = t, lzcheckObj.lmms.checkVal[0] = a[0].id, lzcheckObj.lmms.checkVal_cn = a[0].value, showlz_listitem(lzcheckObj.lmms.select_arr1, lzcheckObj.lmms.checkVal)
        },
        onShow: function (t) {
            var a = t.curIndexArr.length > 0 ? t.curIndexArr : lzcheckObj.lmms.checkIndex;
            t.locatePosition(0, a[0])
        }
    });
    showlz_listitem(lzcheckObj.lmms.select_arr1, lzcheckObj.lmms.checkVal)
}

function lzfxzhms() {
    $(".zhfx_meci").text("筛选名次"), $(".zhfx_model").text("筛选路珠");
    new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.zhms.select_arr1
        }, trigger: ".zhfx_meci", title: "选择名次", wheels: condition_zh_mc, callback: function (t, a, s) {
            lzcheckObj.zhms.select_arr1 = a, showlz_listitem(lzcheckObj.zhms.select_arr1, lzcheckObj.zhms.select_arr2)
        }, onShow: function () {
            this.initSelectedState()
        }
    }), new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.zhms.select_arr2
        }, trigger: ".zhfx_model", title: "选择路珠", wheels: condition_zh_lz, callback: function (t, a, s) {
            lzcheckObj.zhms.select_arr2 = a, showlz_listitem(lzcheckObj.zhms.select_arr1, lzcheckObj.zhms.select_arr2)
        }, onShow: function () {
            this.initSelectedState()
        }
    });
    showlz_listitem(lzcheckObj.zhms.select_arr1, lzcheckObj.zhms.select_arr2)
}

function showlz_listitem(t, a) {
    $(".lz_title").hide();
    for (var s = 0; s < t.length; s++) {
        var e = t[s];
        $(a).each(function (t, a) {
            $("." + a).each(function (t, a) {
                $(a).hasClass(e) && $(a).show()
            })
        })
    }
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    //视频url初始化
    //$("#videoiframe").attr('src',config.videourl+"view/video/SSC/index.html?"+lotCode);
    pubmethod.initAdata(), method.indexLoad(boxId, lotCode), ifishad = !0;
    $("#startVideo").on("click", function () {
        startVideo();//$("iframe")[0].contentWindow.ifopen = !0, $("iframe")[0].contentWindow.sscAnimateEnd(createData(), lotCode)
    }), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-150%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"});
            $("#videoiframe").attr('src',"");
        });
        //$("iframe")[0].contentWindow.videoTools.sounds.soundsT.stop("bgsound"), $("iframe")[0].contentWindow.videoTools.clearInterval(), $("iframe")[0].contentWindow.ifopen = !1
    }), method.loadOther(""), setTimeout(function () {
        config.ifFirstLoad = !0
    }, 4e3)
}), function () {
    tools.initDate();
    var t = "number" == typeof window.orientation && "object" === _typeof(window.onorientationchange);
    window.addEventListener("DOMContentLoaded", function () {
        document.body.parentNode;
        var a, s = function () {
            t && (a = window.orientation, "0px" == $("#videobox").find(".content").css("top") && startVideo())
        };
        t ? window.addEventListener("orientationchange", s, !1) : window.addEventListener("resize", s, !1), s()
    }, !1)
}();
var ifishad = !1, method = {}, stfoterarr = "";
method.loadOther = function (t) {
    if ("" != t || tools.ifOnDay()) {
        setTimeout(function () {
            method.todayData(t)
        }, 1e3), setTimeout(function () {
            method.longData(t)
        }, 2e3);
        var a = $(".headTitle .checkedbl").attr("id");
        tools.classGetDate_ssc(a, t, "")
    }
}, method.indexLoad = function (t) {
    var a = $(t).find(".nextIssue").val(), t = "#" + $(t).attr("id");
    headMethod.loadHeadData(a, t)
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "CQShiCai/getBaseCQShiCaiList.do?date=" + t,
        type: "GET",
        data: {lotCode: lotCode},
        beforeSend: function () {
            ifishad || $("#numlist").html("<span class='loading'>努力加载中...</span>")
        },
        success: function (t) {
            method.createHtmlList(t), animate.loadingList("body", !1)
        },
        error: function (t) {
            config.ifdebug
        }
    })
}, method.todayData = function (t) {
    $.ajax({
        url: config.publicUrl + "CQShiCai/queryDoubleNumber.do?date=" + t,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            method.loadTodayData(t)
        },
        error: function (t) {
            config.ifdebug
        }
    })
}, method.longData = function (t) {
    $.ajax({
        url: config.publicUrl + "CQShiCai/getShiCaiDailyDragonCount.do?date=" + t,
        type: "GET",
        data: {lotCode: lotCode},
        success: function (t) {
            method.loadLongData(t)
        },
        error: function (t) {
            config.ifdebug
        }
    })
}, method.createHtmlList = function (t) {
    var a = null;
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode && 0 == a.result.businessCode) {
        if (0 == (a = a.result.data).length) return void tools.weikaiji("#numlist");
        scrollRender.init(a), tools.catchUndefined(".lhlist")
    }
};
var scrollRender = {
    init: function (t) {
        var a = this;
        this.data = t, this.once = 200, this.contArr = ["#numlist", "#haomafblist"], this.contArr.forEach(function (s) {
            $(s).empty(), a[s] = {curIndex: 0, totalPage: Math.ceil(t.length / a.once) - 1}
        }), "haomafb" === $("#allSele .checkedbl").attr("id") ? this.parentClass = "#haomafblist" : this.parentClass = "#numlist", createHtmlStr(t.slice(this[this.parentClass].curIndex, this.once), this.contArr), this.watchDom = $(this.parentClass + " .ssclist:last-child")[0], $(window).off("scroll").on("scroll", throttle(this.scrollCb.bind(this), 400, 1e3))
    }, scrollCb: function () {
        if (!this.scrollFlag && this.watchDom.getBoundingClientRect().top < window.screen.height + 200) {
            var t = this[this.parentClass];
            0 === t.totalPage && (this.watchDom = null, $(window).off("scroll")), this.scrollFlag = !0, t.curIndex = t.curIndex + this.once, createHtmlStr(this.data.slice(t.curIndex, t.curIndex + this.once), this.parentClass), this.watchDom = $(this.parentClass + " .ssclist:last-child")[0], "#haomafblist" === this.parentClass ? runFilterRender() : method.selectedBS($(".rightdiv").find(".spanchecked"), !0), --t.totalPage, this.scrollFlag = !1
        }
    }
};
method.selectedBS = function (t, a) {
    tools.bigOrSmall(t, a, "5")
}, method.selectedHm = function (t) {
    if ($(t).parents(".dansdxbtn").length > 0) {
        var a = $(t).hasClass("lichecked");
        $(".numbtn").find("li").removeClass("lichecked"), $(t).toggleClass("lichecked");
        var s = $(t).text(), e = [null, "双", "单", "小", "大"].indexOf(s);
        $(".dansdxbtn li:nth-child(" + e + ")").removeClass("lichecked"), runSelectedHm(s, a)
    } else $(".dansdxbtn").find("li").removeClass("lichecked"), $(t).toggleClass("lichecked"), $(".numbtn .lichecked").length > 0 ? runNumFilter() : $("#haomafblist li").removeClass("selectedOpacity")
}, method.loadTodayData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data;
        var a = [{data: [data.numZero, data.numOne, data.numTwo, data.numThree, data.numFour, data.numFive, data.numSix, data.numSeven, data.numEight, data.numNine]}, {data: [data.firstSingle, data.firstDouble, data.firstBig, data.firstSmall]}, {data: [data.secondSingle, data.secondDouble, data.secondBig, data.secondSmall]}, {data: [data.thirdSingle, data.thirdDouble, data.thirdBig, data.thirdSmall]}, {data: [data.fourthSingle, data.fourthDouble, data.fourthBig, data.fourthSmall]}, {data: [data.fifthSingle, data.fifthDouble, data.fifthBig, data.fifthSmall]}, {data: [data.sumSingle, data.sumDouble, data.sumBig, data.sumSmall]}];
        $("#liangmianbox").empty(), $(a).each(function (t) {
            var a = "";
            $(this.data).each(function () {
                a += "<td>" + this + "</td>"
            });
            var s = tools.typeOf("liangm", t), e = "";
            0 == t ? e = "head1" : 1 == t && (e = "head2");
            var l = "";
            l = '<div class="lianmlist"><div  class="head ' + e + '">' + s + '</div><table cellpadding="0" cellspacing="0" border="0"><tr class="tr1">' + (t > 0 ? "<td>单</td><td>双</td><td>大</td><td>小</td>" : "<td>0</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td>") + '</tr><tr class="tr2">' + a + "</tr></table></div>", $("#liangmianbox").append(l)
        })
    }
}, method.loadLongData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data, config.ifdebug, $("#longDrag").empty("");
        for (var a = 0, s = data.length; a < s; a++) {
            var e = tools.typeOf("qiuqiu1", data[a].rank), l = tools.typeOf("stated", data[a].state),
                i = data[a].count >= 5 ? "<span style='color:#f11821'>" + data[a].count + "</span>" : "<span>" + data[a].count + "</span>",
                n = "<li><span>" + e + "</span>：<span>" + l + "</span>" + i + "期</li>";
            11 != data[a].rank && 1 != data[a].rank && 2 != data[a].rank || (n = "<li><span>" + e + "</span>：<span>" + l + "</span>" + i + "期</li>"), $("#longDrag").append(n)
        }
    }
}, $("#hmqhlzmcul").find("li").on("click", function () {
    $(this).toggleClass("hmqhlzHMAct"), checkhmqhlzHm()
}), $(".longhuzs .lomorediv").on("click", "span", function (t) {
    var a = $(this), s = dewitabledata.length, e = 1 * $(this).parent().attr("data-text");
    "lhzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "lhzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachconten_lhzs(dewitabledata[e][0]), orshowConten_gyh(), $("html,body").animate({scrollTop: $(".longhuzs").offset().top}, 500)
}), $(".gyhcksjtj").on("touchstart", function (t) {
    t.preventDefault(), $("html,body").animate({scrollTop: $(".clospan_gyh").offset().top}, 500)
}), $("#explainBtn_wfsm").on("touchstart", function () {
    showExplain_smwf()
}), $(".closesm").on("click", function () {
    hideExplain_smwf()
}), $(".lshmtj_navTab").on("touchstart", "span", function () {
    $(this).find("i").hasClass("iActClass") || $(this).find("i").addClass("iActClass").parent("span").siblings().find("i").removeClass(), "xtCheck" == $(this).attr("id") ? ($("#lshmtj_hmkanList").css("display", "none"), $("#lshmtj_xtList").css("display", "block")) : ($("#lshmtj_hmkanList").css("display", "block"), $("#lshmtj_xtList").css("display", "none"))
}), $(".navTab").on("touchstart", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), "personCheck" == $(this).attr("id") ? ($("#zhkanList").css("display", "none"), $("#personList").css("display", "block")) : ($("#zhkanList").css("display", "block"), $("#personList").css("display", "none"))
}), $("#minciBox").find("ul").find("li").on("click", function () {
    $(this).hasClass("minciLiAct") || $(this).addClass("minciLiAct").siblings().removeClass();
    var t = $(this).find("i").text();
    $("#tbody" + t).hasClass("displaynone") && $("#tbody" + t).removeClass().siblings("tbody").addClass("displaynone")
}), $("#dsdxBox").find("ul").find("li").on("click", function () {
    $(this).hasClass("dsdxActcolor") || $(this).addClass("dsdxActcolor").siblings().removeClass();
    var t = $(this).find("i").text();
    $("#gtbody" + t).hasClass("displaynone") && $("#gtbody" + t).removeClass().siblings("tbody").addClass("displaynone")
});
var danxfirstclick = !0, weizifooter = "";
$("#sortable").on("click", "button", function () {
    localStorage.setItem("overpage", $(this).attr("id")), $(this).addClass("checkedbl").siblings().removeClass("checkedbl"), $(".headTitle").find("#" + $(this).attr("id")).addClass("checkedbl").siblings().removeClass("checkedbl"), $(".drawCodebox").css({
        left: "7rem",
        display: "none"
    }), $("." + $(this).attr("id")).css({display: "block"}), $("." + $(this).attr("id")).stop().animate({left: "0rem"}, "100"), "haomazs" == $(this).attr("id") ? ($(".haomazs .Pattern").hide(), $(".haomazsbgcls").show(), $(".weizilodiv").show()) : ($(".haomazs .Pattern").show(), $(".haomazsbgcls").hide()), $(".tabBox").removeClass("hasheight"), $(".gotop").css("height", "0rem"), $("#touchlongmove").removeClass("gotop"), $(".sort").removeClass("bgsize"), $(".ListHead").css("min-height", "0");
    var t = $(this).attr("id");
    $obj = $obj || hisEl, tools.classGetDate_ssc(t, "", ""), $(".Pattern .hamafb").addClass("checkspan").siblings().removeClass("checkspan");
    var a = $("#sortable .checkedbl").attr("id"), s = "#" + a + "_sm";
    "longhuzs" == a || "wezizs" == a || "lenrefx" == a || "singtaizs" == a ? ($("#explainBtn_wfsm").show(), $(s).addClass("displayblock").siblings("div").addClass("displaynone"), $(s).siblings("div").removeClass("displayblock")) : ($("#explainBtn_wfsm").hide(), $(s).addClass("displaynone").siblings("div").addClass("displaynone")), $(".headTitle>button").each(function (t, a) {
        $(a).hasClass("checkedbl") && (newscrollleft = 1 * $(a).offset().left, (newscrollleft > 1 || newscrollleft < -1) && (oddscrollleft = 1 * oddscrollleft + 1 * newscrollleft, $(".headTitle_view").scrollLeft(Math.abs(oddscrollleft))))
    })
}), $(".lookshjtj").on("touchstart", function (t) {
    t.preventDefault();
    var a = $("#footerDiv");
    $("html,body").animate({scrollTop: a.offset().top}, 500)
}), $(".wezizs").on("click", ".Pattern span", function () {
    -1 != $(this).attr("class").indexOf("hamafb") ? $(".weizilodiv").show() : $(".weizilodiv").hide(), $(this).addClass("checkspan").siblings().removeClass("checkspan");
    var t = $(this).attr("class").replace(" ", "").replace("checkspan", "");
    $(".table_" + t).show().siblings().hide(), orshowConten()
}), $(".table_conditions").on("click", "p>span", function () {
    var t = $(this).attr("class");
    "weai" == t ? $("#rank_wzzs").addClass("gotop") : "shjian" == t ? $("#periods_wzzs").addClass("gotop") : "tiaojian" == t ? $("#tiaojian_wzzs").addClass("gotop") : "shjian_singtai" == t ? $("#rank_singtaizs").addClass("gotop") : "tiaojian_singtai" == t && $("#tiaojian_singtaizs").addClass("gotop"), $(".gotop").css("height", $("body").height() + "px"), bodyHtmlhide()
});
var dewitabledata = [];
$(".wezizs .lomorediv").on("click", "span", function (t) {
    var a = $(this), s = dewitabledata.length, e = 1 * $(this).parent().attr("data-text");
    "weizilo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "weizilo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachcontent(dewitabledata[e][0]), orshowConten(), $("html,body").animate({scrollTop: $("#trend_table2").offset().top}, 500)
}), $("#gcCheckqisho").on("click", ".sure", function () {
    $(".gotop").css("height", "0rem"), $(".loteyPage").removeClass("gotop"), $(".or_").removeClass("or_"), $(".marginTop>li").each(function (t, a) {
        $(a).hasClass("check_tj") ? $(".item_" + $(a).attr("data-text")).show() : $(".item_" + $(a).attr("data-text")).hide()
    }), $(".show_zonkai").hasClass("check_tj") ? $(".zongkai_item").show() : $(".zongkai_item").hide(), $(".show_maxliankai").hasClass("check_tj") ? $(".liankai_item").show() : $(".liankai_item").hide(), $(".show_dingqian").hasClass("check_tj") ? $(".dingqian_item").show() : $(".dingqian_item").hide(), $(".show_big").hasClass("check_tj") ? $(".big_item").show() : $(".big_item").hide(), bodyHtmlvis()
}), $(".singtaizs .lomorediv").on("click", "span", function (t) {
    var a = 1 * $(".singtaizs .Pattern .checkspan").attr("data-text") + 1, s = $(this), e = dewitabledata.length,
        l = 1 * $(this).parent().attr("data-text");
    "singtilo_left" == s.attr("id") ? (l - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", l -= 1)) : "singtilo_right" == s.attr("id") && (l + 2 == e && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", l += 1)), eachconten_stzs(dewitabledata[l][0], a), orshowConten_siantai(), $("html,body").animate({scrollTop: $(".singtaizs").offset().top}, 500)
});
var sscFunObj = {
    wzzs: {
        init: function () {
            this.getlist("", 30)
        }, getlist: function (t, a) {
            var s = wz_mc_val[0], e = s;
            "" != (t = void 0 == t ? "" : t) && t != getDateStr(0, !0) || "" != a || ($(".shjian").text("今天").attr("data-text", 0), $("#periods_wzzs ul li:first").addClass("checked").siblings().removeClass("checked")), a = void 0 == a ? "" : a, $.ajax({
                url: config.publicUrl + "CQShiCai/queryCQShiCaiTrendByLocation.do?date=" + t + "&issue=" + a + "&num=" + (1 * e + 1),
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.wzzs.createHtmlList(t, s)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, createHtmlList: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data[0];
            if (void 0 == s) return $(".lomorediv").hide(), $(".wezizs #chartLinediv").html(""), tools.weikaiji(".wezizs #chartLinediv"), !1;
            listettablearr(s.bodyList), $(".prevlo").hide(), $(".wezizs #chartLinediv").html("");
            var e = "", l = "", i = "", n = "";
            e += " <table  class='table_hamafb displaynone' id='trend_table2'>", e += "<thead><tr><th>期号</th><th>号码</th><th>0</th><th>1</th><th>2</th>", e += "<th>3</th><th>4</th><th>5</th>", e += "<th>6</th><th>7</th><th>8</th><th>9</th></tr></thead><tbody>", l += "<table class='table_sttz displaynone'>", l += "<thead><tr><th>期数</th><th>号码</th><th colspan='2'>大小</th>", l += "<th colspan='2'>奇偶</th><th colspan='2'>合质</th></tr></thead><tbody><tr>", i += "<table class='table_lu012 displaynone'><thead><tr><th>期号</th><th class='short'>号码</th><th>0</th><th>1</th><th>2</th></tr></thead><tbody><tr>", n += "<table class='table_spj displaynone'><thead><tr><th>期号</th><th class='short'>号码</th><th>升</th><th>平</th><th>降</th></tr></thead><tbody><tr>", $(s.bodyList).each(function (t) {
                var s = this.code.split(","), d = this.array.slice(0, 10), o = this.array.slice(10, 16),
                    c = this.array.slice(16, 19), r = this.array.slice(19);
                if (10036 == lotCode) h = config.showrows; else var h = 200;
                if (t < h) {
                    e += " <td>" + this.issue.toString().slice(4) + "</td><td class='tabred'><span>" + s[a] + "</span></td>";
                    for (var u = 0; u < d.length; u++) 1 * d[u] > 0 || 1 * d[u] == 0 ? e += "<td class='hot'><span name='hotSpan'>" + d[u] + "</span></td>" : e += "<td><span>" + Math.abs(d[u]) + "</span></td>";
                    e += "</tr>"
                }
                l += "<td>" + this.issue.toString().slice(4) + "</td> <td class='tabred'><span>" + s[a] + "</span></td>", $(o).each(function (t) {
                    var a = "";
                    a = 1 * this >= 0 ? 0 == t ? "<td class='numeven'><span>大</span></td>" : 1 == t ? "<td class='numodd'><span>小</span></td>" : 2 == t ? "<td class='numeven'><span>奇</span></td>" : 3 == t ? "<td class='numodd'><span>偶</span></td>" : 4 == t ? "<td class='numeven'><span>合</span></td>" : 5 == t ? "<td class='numodd'><span>质</span></td>" : Math.abs(this) : "<td><span>" + Math.abs(this) + "</span></td>", l += a
                }), l += "</tr>", i += "<td>" + this.issue.toString().slice(4) + "</td> <td class='tabred'><span>" + s[a] + "</span></td>", $(c).each(function (t) {
                    var a = "";
                    a = 1 * this >= 0 ? 0 == t ? "<td class='numeven'><span>0</span></td>" : 1 == t ? "<td class='numodd'><span>1</span></td>" : 2 == t ? "<td class='numeven'><span>2</span></td>" : Math.abs(this) : "<td><span>" + Math.abs(this) + "</span></td>", i += a
                }), i += "</tr>", n += "<td>" + this.issue.toString().slice(4) + "</td> <td class='tabred'><span>" + s[a] + "</span></td>", $(r).each(function (t) {
                    var a = "";
                    a = 1 * this >= 0 ? 0 == t ? "<td class='numeven'><span>升</span></td>" : 1 == t ? "<td class='numodd'><span>平</span></td>" : 2 == t ? "<td class='numeven'><span>降</span></td>" : Math.abs(this) : "<td><span>" + Math.abs(this) + "</span></td>", n += a
                }), n += "</tr>"
            });
            var d = s.missList[0].array.slice(0, 10), o = s.missList[1].array.slice(0, 10),
                c = s.missList[3].array.slice(0, 10), r = s.missList[2].array.slice(0, 10),
                h = s.missList[0].array.slice(10, 16), u = s.missList[1].array.slice(10, 16),
                f = s.missList[3].array.slice(10, 16), p = s.missList[2].array.slice(10, 16),
                m = s.missList[0].array.slice(16, 19), b = s.missList[1].array.slice(16, 19),
                _ = s.missList[3].array.slice(16, 19), g = s.missList[2].array.slice(16, 19),
                v = s.missList[0].array.slice(19), y = s.missList[1].array.slice(19), z = s.missList[3].array.slice(19),
                x = s.missList[2].array.slice(19),
                w = "</tr><tr class='clospan'><td colspan='2'>数据统计</td><td>0</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td></tr>";
            l += "</tr><tr class='clospan'><td colspan='2'>数据统计</td><td colspan='2'>大小</td><td colspan='2'>奇偶</td><td colspan='2'>合质</td></tr>", i += "<tr class='clospan'><td colspan='2'>数据统计</td><td>0</td><td>1</td><td>2</td></tr>", n += "<tr class='clospan'><td colspan='2'>数据统计</td><td>升</td><td>平</td><td>降</td></tr>", w += "<tr><td colspan='2'>总次数</td>";
            for (var C = "<tr><td colspan='2'>平均遗漏</td>", k = "<tr><td colspan='2'>最大连出</td>", S = "<tr><td colspan='2'>最大遗漏</td>", O = "<tr><td colspan='2'>总次数</td>", j = "<tr><td colspan='2'>平均遗漏</td>", T = "<tr><td colspan='2'>最大连出</td>", D = "<tr><td colspan='2'>最大遗漏</td>", L = "<tr><td colspan='2'>总次数</td>", q = "<tr><td colspan='2'>平均遗漏</td>", B = "<tr><td colspan='2'>最大连出</td>", M = "<tr><td colspan='2'>最大遗漏</td>", N = "<tr><td colspan='2'>总次数</td>", I = "<tr><td colspan='2'>平均遗漏</td>", F = "<tr><td colspan='2'>最大连出</td>", A = "<tr><td colspan='2'>最大遗漏</td>", J = 0; J < d.length; J++) w += " <td>" + Math.abs(d[J]) + "</td>", C += " <td>" + Math.abs(o[J]) + "</td>", k += " <td>" + Math.abs(c[J]) + "</td>", S += " <td>" + Math.abs(r[J]) + "</td>";
            for (var H = 0; H < h.length; H++) O += " <td>" + Math.abs(h[H]) + "</td>", j += " <td>" + Math.abs(u[H]) + "</td>", T += " <td>" + Math.abs(f[H]) + "</td>", D += " <td>" + Math.abs(p[H]) + "</td>";
            for (var P = 0; P < m.length; P++) L += " <td>" + Math.abs(m[P]) + "</td>", q += " <td>" + Math.abs(b[P]) + "</td>", B += " <td>" + Math.abs(_[P]) + "</td>", M += " <td>" + Math.abs(g[P]) + "</td>";
            for (var E = 0; E < v.length; E++) N += " <td>" + Math.abs(v[E]) + "</td>", I += " <td>" + Math.abs(y[E]) + "</td>", F += " <td>" + Math.abs(z[E]) + "</td>", A += " <td>" + Math.abs(x[E]) + "</td>";
            var V = "</tr>";
            weizifooter = w + V + C + V + k + V + S + V, e += w + V + C + V + k + V + S + V + "</tbody></table>", l += O + V + j + V + T + V + D + V + "</tbody></table>", i += L + V + q + V + B + V + M + V + "</tbody></table>", n += N + V + I + V + F + V + A + V + "</tbody></table>", $(".wezizs #chartLinediv").html(e + l + i + n);
            var G = $(".wezizs .Pattern .checkspan").attr("class").replace(" ", "").replace("checkspan", "");
            $(".table_" + G).show().siblings().hide(), orshowConten()
        }
    }, dsdxls: {
        listData: function () {
            $.ajax({
                url: config.publicUrl + "CQShiCai/queryHistoryDataForDsdx.do",
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.dsdxls.dsdxlsHtmlList(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, dsdxlsHtmlList: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            var s = a.result.data;
            $("#dsdxlstable tbody").empty(), $("#tableBox tbody").empty(), $(s).each(function (t) {
                for (var a = $(this)[0], s = "", e = "<td >" + a.date + "</td>", l = 0; l < 5; l++) {
                    var i = "tr" + l;
                    i = "<tr style='height:38px'>" + e + ("<td >" + a.list[l].bigCount + "</td><td >" + a.list[l].smallCount + "</td><td >" + a.list[l].singleCount + "</td><td >" + a.list[l].doubleCount + "</td>") + "</tr>", $("#tbody" + l).append(i)
                }
                for (var n = 0; n < 4; n++) {
                    s = "getiTd" + n;
                    for (l = 0; l < a.list.length; l++) s += "<td>" + (0 == n ? a.list[l].singleCount : 1 == n ? a.list[l].doubleCount : 2 == n ? a.list[l].bigCount : a.list[l].smallCount) + "</td>";
                    getiTr = "<tr style='height:38px'>" + e + s + "</tr>", $("#gtbody" + n).append(getiTr)
                }
            })
        }
    }, dsdxlz: {
        dsdxlzsData: function (t) {
            "" == (t = void 0 == t ? "" : t) && $("#today_dsdxlz").addClass("todayAct_dsdxlz").siblings().removeClass("todayAct_dsdxlz"), $.ajax({
                url: config.publicUrl + "CQShiCai/queryComprehensiveRoadBead.do?date=" + t,
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.dsdxlz.addlzTable_dsdxlz(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlzTable_dsdxlz: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".dsdxlz .dsdxlz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state;
                    if (1 == l) {
                        var i = "双", n = "单", d = "单双";
                        s = "dansuShow"
                    } else if (2 == l) {
                        var i = "小", n = "大", d = "大小";
                        s = "daxiaoShow"
                    } else if (3 == l) {
                        var i = "虎", n = "龙", o = "和", d = "龙虎";
                        s = "longhuShow displaynone"
                    } else if (11 == l) {
                        var i = "单", n = "双", d = "单双";
                        s = "ganyudanxShow"
                    } else if (12 == l) {
                        var i = "大", n = "小", d = "大小";
                        s = "guanyudaxiaoshow"
                    }
                    if (void 0 != o) c = "<span>" + o + "（" + a.result.data[e].totals[2] + "）</span>"; else var c = "";
                    var r = a.result.data[e].rank;
                    11 == r && 1 == l ? s = "ganyudanxShow" : 11 == r && 2 == l && (s = "guanyudaxiaoshow");
                    var h = "<div class='lz_title " + s + " t" + (r - 1) + "'><div class='left'><span>今日累计:</span>",
                        u = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var f = 0, p = 0, m = 0, b = 0; f < a.result.data[e].roadBeads.length && !(f >= 200); f++) {
                        var _ = a.result.data[e].roadBeads[f];
                        0 == _ ? (_ = i, p += 1) : 1 == _ ? (_ = n, m += 1) : 2 == _ && (_ = o, b += 1), 0 == f && (u += "<p>" + _ + "</p>"), f > 0 & a.result.data[e].roadBeads[f - 1] == a.result.data[e].roadBeads[f] ? u += "<p>" + _ + "</p>" : f > 0 & a.result.data[e].roadBeads[f - 1] != a.result.data[e].roadBeads[f] && (u += "</td><td><p>" + _ + "</p>")
                    }
                    var g = "";
                    1 == r ? g = "第一球" : 2 == r ? g = "第二球" : 3 == r ? g = "第三球" : 4 == r ? g = "第四球" : 5 == r && (g = "第五球");
                    var v = "<span>" + i + "（" + a.result.data[e].totals[1] + "）</span><span>" + n + "（" + a.result.data[e].totals[0] + "）</span>" + c + "</div><div class='right'><span class='weizi'>" + g + "</span><span class='mosh'>" + d + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".dsdxlz .dsdxlz_content").append(h + v + u + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red"), $("#dsdxlzlist .dansuShow ").hide(), showSxend(), animate_lz_dsdxlz()
            } else tools.weikaiji(".dsdxlz .dsdxlz_content")
        }
    }, lshmtj: {
        listData: function () {
            $.ajax({
                url: config.publicUrl + "CQShiCai/queryHistoryDataForNumber.do",
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.lshmtj.createList(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, createList: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            var s = a.result.data;
            $("#lshmtj_hmkanList .ulDiv").empty(), $("#lshmtj_xtList .ulDiv").empty(), $(s).each(function (t, a) {
                var s = this.list, e = "", l = "", i = "", n = "", d = "<ul><li>" + this.date + "</li>";
                $(s).each(function (t) {
                    t < 10 ? i += "<li>" + this.counts + "</li>" : n += "<li>" + this.counts + "</li>"
                });
                e = d + i + "</ul>", l = d + n + "</ul>", $("#lshmtj_hmkanList .ulDiv").append(e), $("#lshmtj_xtList .ulDiv").append(l)
            })
        }
    }, lhzs: {
        listData: function (t, a) {
            t = void 0 == t ? "" : t, a = void 0 == a ? "" : a, "" != t && t != getDateStr(0, !0) || "" != a || ($("#gyhtodayBtn span").text("今天"), $("#gyhToday").addClass("gyhtimesAtc").siblings().removeClass("gyhtimesAtc")), $.ajax({
                url: config.publicUrl + "CQShiCai/queryCQShiCaiTrendByDT.do?issue=" + a + "&date=" + t,
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.lhzs.createList(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, createList: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            var s = a.result.data[0];
            if (void 0 == s) return tools.weikaiji("#trend_table2_gyhzs tbody"), !1;
            listettablearr(s.bodyList), $(".prevlo").hide(), $("#trend_table2_gyhzs tbody").empty(), eachconten_lhzs(s.bodyList);
            var e = "<td colspan='2'>出现总数</td>", l = "<td colspan='2'>平均遗漏</td>", i = "<td colspan='2'>最大遗漏</td>",
                n = "<td colspan='2'>最大连出</td>";
            $(s.missList).each(function (t) {
                var a = this.array.splice(this.array.length - 3);
                0 == t ? $(a).each(function () {
                    e += "<td>" + Math.abs(this) + "</td>"
                }) : 1 == t ? $(a).each(function () {
                    l += "<td>" + Math.abs(this) + "</td>"
                }) : 2 == t ? $(a).each(function () {
                    i += "<td>" + Math.abs(this) + "</td>"
                }) : 3 == t && $(a).each(function () {
                    n += "<td>" + Math.abs(this) + "</td>"
                })
            }), $("#trend_table2_gyhzs tbody").append("<tr><th colspan='2'>数据统计</th><th>龙</th><th>虎</th><th>和</th></tr><tr class='clospan_gyh'>" + e + "</tr><tr class='clospan_gyh'>" + l + "</tr><tr class='clospan_gyh'>" + i + "</tr><tr class='clospan_gyh'>" + n + "</tr>"), orshowConten_gyh()
        }
    }, lzfx: {
        init: function () {
            this.getlist("")
        }, getlist: function (t) {
            "" == t && $(".today_lz").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                url: config.publicUrl + "CQShiCai/queryComprehensiveRoadBead.do",
                type: "GET",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    sscFunObj.lzfx.addlzTable(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlzTable: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.result.data.length) return tools.weikaiji(".luzufx .lz_content"), !1;
            $(".luzufx .lz_content").html("");
            for (var s = "", e = 0; e < a.result.data.length; e++) {
                var l = a.result.data[e].rank, i = a.result.data[e].state, n = "";
                if (1 == i) {
                    var d = "双", o = "单", c = "单双";
                    s = "dansuShow"
                } else if (2 == i) {
                    var d = "小", o = "大", c = "大小";
                    s = "daxiaoShow"
                } else if (3 == i) {
                    var d = "虎", o = "龙", r = "和", c = "龙虎";
                    s = "longhuShow", l = 1, n = "<span>和（" + a.result.data[e].totals[2] + "）</span>"
                }
                var h = "<div class='lz_title " + s + " ball_" + l + "'><div class='left'><span>今日累计:</span>",
                    u = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                for (var f = 0, p = 0, m = 0, b = 0; f < a.result.data[e].roadBeads.length && !(f >= 200); f++) {
                    var _ = a.result.data[e].roadBeads[f];
                    0 == _ ? (_ = d, p += 1) : 1 == _ ? (_ = o, m += 1) : 2 == _ && (_ = r, b += 1), 0 == f && (u += "<p>" + _ + "</p>"), f > 0 & a.result.data[e].roadBeads[f - 1] == a.result.data[e].roadBeads[f] ? u += "<p>" + _ + "</p>" : f > 0 & a.result.data[e].roadBeads[f - 1] != a.result.data[e].roadBeads[f] && (u += "</td><td><p>" + _ + "</p>")
                }
                var g = "";
                1 == l ? g = "第一球" : 2 == l ? g = "第二球" : 3 == l ? g = "第三球" : 4 == l ? g = "第四球" : 5 == l ? g = "第五球" : 6 == l ? g = "总和" : 11 == l && (g = "总和");
                var v = "<span>" + d + "（" + a.result.data[e].totals[1] + "）</span><span>" + o + "（" + a.result.data[e].totals[0] + "）</span>" + n + "</div><div class='right'><span class='weizi'>" + g + "</span><span class='mosh'>" + c + "</span><span class='zxi'>最新    &darr;</span></div>";
                $(".luzufx .lz_content").append(h + v + u + "</td></tr></tbody></table></div></div>")
            }
            $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red");
            var y = $(".luzufx .Pattern .checkspan");
            $("#F_zhfx_meci").parents(".mobileSelect").remove(), $("#F_zhfx_model").parents(".mobileSelect").remove(), y.hasClass("zonghu") ? lzfxzhms() : y.hasClass("danxms") ? lzfxdxms() : lzfxlmms(), animate_lz()
        }
    }, gyhlz: {
        init: function () {
            this.getlist("")
        }, getlist: function (t) {
            "" == t && $(".today_lz").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                url: config.publicUrl + "CQShiCai/queryComprehensiveRoadBead.do",
                type: "GET",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    sscFunObj.gyhlz.addlzTable(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlzTable: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.result.data.length) return tools.weikaiji(".guyahelz .lz_content"), !1;
            $(".guyahelz .lz_content").html("");
            for (var s = "", e = 0; e < a.result.data.length; e++) {
                var l = a.result.data[e].state;
                if (1 == l) {
                    var i = "双", n = "单", d = "单双";
                    s = "dansuShow"
                } else if (2 == l) {
                    var i = "小", n = "大", d = "大小";
                    s = "daxiaoShow"
                }
                if (6 == a.result.data[e].rank) {
                    var o = "<div class='lz_title " + s + " ball_" + l + "'><div class='left'><span>今日累计:</span>",
                        c = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var r = 0, h = 0, u = 0, f = 0; r < a.result.data[e].roadBeads.length && !(r >= 200); r++) {
                        var p = a.result.data[e].roadBeads[r];
                        0 == p ? (p = i, h += 1) : 1 == p ? (p = n, u += 1) : 2 == p && (p = text3, f += 1), 0 == r && (c += "<p>" + p + "</p>"), r > 0 & a.result.data[e].roadBeads[r - 1] == a.result.data[e].roadBeads[r] ? c += "<p>" + p + "</p>" : r > 0 & a.result.data[e].roadBeads[r - 1] != a.result.data[e].roadBeads[r] && (c += "</td><td><p>" + p + "</p>")
                    }
                    var m = "<span>" + i + "（" + a.result.data[e].totals[1] + "）</span><span>" + n + "（" + a.result.data[e].totals[0] + "）</span></div><div class='right'><span class='weizi'>总和</span><span class='mosh'>" + d + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".guyahelz .lz_content").append(o + m + c + "</td></tr></tbody></table></div></div>")
                }
            }
            $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red"), animate_lz()
        }
    }, jrhmtj: {
        init: function () {
            this.getdata()
        }, getdata: function (t) {
            void 0 == t && (t = ""), $.ajax({
                url: config.publicUrl + "CQShiCai/queryToDayNumberLawOfStatistics.do?",
                type: "GET",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    sscFunObj.jrhmtj.createHtml(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, createHtml: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode) for (var s = "", e = a.result.data, l = "", i = 0; i < e.length; i++) {
                0 == i ? l = "第一球" : 1 == i ? l = "第二球" : 2 == i ? l = "第三球" : 3 == i ? l = "第四球" : 4 == i && (l = "第五球"), s += "<div class='item_" + (i + 1) + " item_'><span class='item_title'>" + l + "</span><ul class='num_item'>", s += "<li class='li_first'>号码</li><li>0</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li> <li>7</li><li>8</li><li>9</li></ul>";
                for (var n = "<ul class='zongkai_item'><li class='li_first'>总开</li>", d = "<ul class='liankai_item'><li class='li_first'>最多连开</li>", o = "<ul class='dingqian_item'><li class='li_first'>当前遗漏</li>", c = "<ul class='big_item'><li class='li_first'>最大遗漏</li>", r = 0; r < e[i].list.length; r++) {
                    var h = e[i].list[r], u = assclass(h.totalopen), f = assclass(h.maxopen),
                        p = assclass(h.currentmiss), m = assclass(h.maxmiss);
                    n += "<li class='" + u + "'>" + h.totalopen + "</li>", d += "<li class='" + f + "'>" + h.maxopen + "</li>", o += "<li class='" + p + "'>" + h.currentmiss + "</li>", c += "<li class='" + m + "'>" + h.maxmiss + "</li>"
                }
                s += n + "</ul>" + d + "</ul>" + o + "</ul>" + c + "</ul></div>"
            }
            $(".todayhaomatj .showconten").html(s)
        }
    }, singtaizs: {
        init: function () {
            this.getlist("", 30)
        }, getlist: function (t, a) {
            var s = $(".singtaizs .Pattern .checkspan").attr("data-text"), e = void 0 == s ? 0 : s;
            0 == e ? $(".bal_index").text("第一球").next().text("第二球").next().text("第三球") : 1 == e ? $(".bal_index").text("第二球").next().text("第三球").next().text("第四球") : $(".bal_index").text("第三球").next().text("第四球").next().text("第五球");
            var l = 1 * $("#rank_singtaizs .pk10rank .checked").attr("data-text");
            l = 0 == l ? getDateStr(0, !0) : 1 == l ? getDateStr(-1, !0) : 2 == l ? getDateStr(-2, !0) : "", t = void 0 == t || "" == t ? "" : t, a = void 0 == a ? "" : a, "" != t && t != getDateStr(0, !0) || "" != a || ($(".shjian_singtai").text("今天").attr("data-text", 0), $("#rank_singtaizs ul li:first").addClass("checked").siblings().removeClass("checked")), $.ajax({
                url: config.publicUrl + "CQShiCai/queryCQShiCaiTrendByType.do?date=" + t + "&issue=" + a + "&type=" + (1 * e + 1),
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.singtaizs.createHtmlList(t, 1 * e + 1)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, createHtmlList: function (t, a) {
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), data = data.result.data[0], void 0 == data) return tools.weikaiji("#singtai_content tbody"), !1;
            listettablearr(data.bodyList), $(".prevlo").hide(), eachconten_stzs(data.bodyList, a), html2 = "<tr class='clospan'><td rowspan='2' colspan='4'>数据统计</td><td colspan='5'>形态</td><td colspan='5'>组选类型</td></tr> <tr class='clospan'><td>豹子</td><td>顺子</td><td>对子</td><td>半顺心</td><td>杂六</td><td>组三</td><td>组六</td><td>豹子</td></tr>";
            for (var s = data.missList[0].array.slice(30), e = data.missList[1].array.slice(30), l = data.missList[3].array.slice(30), i = data.missList[2].array.slice(30), n = "</tr>", d = "<tr class='closas'><td colspan='4'>出现次数</td>", o = "<tr class='closas'><td colspan='4'>平均遗漏</td>", c = "<tr class='closas'><td colspan='4'>最大连出</td>", r = "<tr class='closas'><td colspan='4'>最大遗漏</td>", h = 0; h < s.length; h++) d += "<td>" + Math.abs(s[h]) + "</td>", o += "<td>" + Math.abs(e[h]) + "</td>", c += "<td>" + Math.abs(l[h]) + "</td>", r += "<td>" + Math.abs(i[h]) + "</td>";
            stfoterarr = html2 + d + n + o + n + c + n + r + n, 0 != $("#singtai_content tbody tr.clospan").length && ($("#singtai_content tbody tr.clospan").remove(), $(".closas").remove()), $("#singtai_content tbody>tr:last-child").after(stfoterarr), orshowConten_siantai()
        }
    }, hmlz: {
        listData: function (t) {
            "" == (t = void 0 == t ? "" : t) && $("#qhlztoday").addClass("hmqhlxdayAct").siblings().removeClass("hmqhlxdayAct"), $.ajax({
                url: config.publicUrl + "CQShiCai/queryNumberRoadBead.do?date=" + t,
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.hmlz.createList(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, createList: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            var s = a.result.data;
            if (0 == s.length) return tools.weikaiji("#hmqhlzlist .hmqhlzItems"), !1;
            $("#hmqhlzlist").find(".hmqhlzItems ").empty(), $(s).each(function (t) {
                sscFunObj.hmlz.forRank(this.rank + 1, this)
            })
        }, forRank: function (t, a) {
            var s = a.totals[0], e = a.totals[1], l = a.roadBeads, i = typeOf_lhlz(a.rank + 1, "code"), n = "", d = "";
            n = "<div id='hm" + t + "' class='tablelist " + (1 * t > 2 ? "displaynone" : "displayblock") + "'><div class='itemHead'><div class='l_jrlj'>今日累计：<span class='lspan'>总来（<i class='longNum'>" + s + "</i>）</span><span class='rspan'>没来（<i class='huNum'>" + e + "</i>）</span></div><div class='r_new'><span>" + i + "</span><span>最新 &darr;</span></div></div>" + "" + "<div class='itemBody'><div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'>" + "</tr></tbody></table></div></div></div>", $("#hmqhlzlist").find(".hmqhlzItems").append(n), $(l.reverse()).each(function (a) {
                if (!(a >= 200)) {
                    var s = "", e = "", i = 0 == this ? "×" : "✓", n = "";
                    n = 0 == this ? "style = 'color:#999'" : "style = 'color:red'", a > 0 ? l[a] != l[a - 1] ? l[a] > 0 && l[a - 1] > 0 ? (e = "<p " + n + ">" + i + "</p>", $("#hm" + t + " .tablebox").find("td:last-child").append(e)) : (s = "<td><p " + n + ">" + i + "</p></td>", $("#hm" + t + " .tablebox").append(s)) : (e = "<p " + n + ">" + i + "</p>", $("#hm" + t + " .tablebox").find("td:last-child").append(e)) : (d = "<td><p " + n + ">" + i + "</p></td>", $("#hm" + t + " .tablebox").append(d))
                }
            }), checkhmqhlzHm(), 9 == t && animate_lz_hmqh()
        }
    }, lrfx: {
        listData: function (t) {
            t = void 0 == t ? "" : t, $.ajax({
                url: config.publicUrl + "CQShiCai/queryDrawCodeHeatState.do?recentPeriods=20",
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    sscFunObj.lrfx.createHtmlList(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, createHtmlList: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode) for (var s = "", e = a.result.data, l = "", i = 0; i < e.length; i++) {
                0 == i ? l = "冠军" : 1 == i ? l = "亚军" : 2 == i ? l = "第三名" : 3 == i ? l = "第四名" : 4 == i ? l = "第五名" : 5 == i ? l = "第六名" : 6 == i ? l = "第七名" : 7 == i ? l = "第八名" : 8 == i ? l = "第九名" : 9 == i && (l = "第十名"), s += "<div class='item_lere" + (i + 1) + " item_'><span class='item_title'>" + l + "</span><ul class='num_item'>", s += "<li class='li_first'>热号</li>";
                var n = "<ul class='zongkai_item'><li class='li_first'>温号</li>",
                    d = "<ul class='weikai_item'><li class='li_first'>冷号</li>", o = "", c = e[i].list[0].list,
                    r = e[i].list[1].list, h = e[i].list[2].list, u = "";
                10060 == lotCode && (u = "hl_li hlnum");
                for (var f = 0; f < c.length; f++) o += "<li class='hotnum " + u + c[f].drawCode + "'><span>" + c[f].drawCode + "</span><span class='spanclass'>" + c[f].count + "</span></li>";
                for (var p = 0; p < r.length; p++) n += "<li class='hotnum " + u + r[p].drawCode + "'>" + r[p].drawCode + "</li>";
                for (var m = 0; m < h.length; m++) d += "<li class='hotnum " + u + h[m].drawCode + "'>" + h[m].drawCode + "</li>";
                s += o + "</ul>" + n + "</ul>" + d + "</ul></div>"
            }
            $(".lenrefx .showconten").html(s)
        }
    }
}, fastClickDate = {today_lz: 0, yestoday_lz: -1, qitian_lz: -2};
$(".checkday").on("click", "span", function () {
    var t = $(this), a = "", s = this.classList[0];
    t.addClass("checkspan").siblings().removeClass("checkspan");
    var e = fastClickDate[s];
    if (!t.hasClass("checkclick_date") && !t.hasClass("screen")) {
        a = getDateStr(e, !0), t.siblings(".time_select").text(a);
        var l = $(".title_se_box .se_check").attr("target");
        l = (l = $("#" + l + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_ssc(l, a, ""), tools.revertHmfb()
    }
}), $(".Pattern").on("click", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $("." + $(this).attr("target") + "_mod").addClass("_shows").siblings().removeClass("_shows"), $(this).parents().hasClass("singtaizs") && sscFunObj.singtaizs.getlist("", "")
});
var condition_wzzs = [{
        data: [{name: "遗漏", value: "yilo"}, {name: "拆线", value: "caix"}, {
            name: "遗漏分层",
            value: "fancong"
        }, {name: "分割线", value: "fgx"}]
    }], condition_wz_qs = [{data: [{value: "近30期", id: "30"}, {value: "近60期", id: "60"}, {value: "近90期", id: "90"}]}],
    dwzs_Arr = [{
        data: [{value: "第一球", id: "0"}, {value: "第二球", id: "1"}, {value: "第三球", id: "2"}, {
            value: "第四球",
            id: "3"
        }, {value: "第五球", id: "4"}]
    }], condition_Arr = [{
        data: [{name: "第一球", value: "t0"}, {name: "第二球", value: "t1"}, {
            name: "第三球",
            value: "t2"
        }, {name: "第四球", value: "t3"}, {name: "第五球", value: "t4"}]
    }], condition_tj = [{data: [{value: "大小", id: "daxiao"}, {value: "单双", id: "danshaung"}]}],
    initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["t0", "t1", "t2", "t3", "t4"]
        }, trigger: ".dsdxlzfx", title: "选择名次", wheels: condition_Arr, callback: function (t, a, s) {
            showSxend()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), dxdxlz_val = [0], initTiaojian = new MobileSelect({
        trigger: ".dsdxlztj",
        title: "选择路珠",
        wheels: condition_tj,
        position: dxdxlz_val,
        callback: function (t, a, s) {
            dxdxlz_val[0] = a[0].id, showSxend()
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dxdxlz_val, s = 0; s < dxdxlz_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".gyhzs_fx", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten_gyh()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), gyh_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".gyh_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: gyh_qs_val,
        callback: function (t, a, s) {
            gyh_qs_val[0] = 1 * a[0].id, sscFunObj.lhzs.listData("", gyh_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : gyh_qs_val, s = 0; s < gyh_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".xtbzxz", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten_siantai()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), gyh_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".xtzsgd",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: gyh_qs_val,
        callback: function (t, a, s) {
            gyh_qs_val[0] = 1 * a[0].id, sscFunObj.singtaizs.getlist("", gyh_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : gyh_qs_val, s = 0; s < gyh_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), wz_mc_val = [0], initTiaojian = new MobileSelect({
        trigger: ".wz_mc",
        title: "选择名次",
        wheels: dwzs_Arr,
        position: wz_mc_val,
        callback: function (t, a, s) {
            wz_mc_val[0] = 1 * a[0].id;
            var e = $(".wezizs .checkday .checkspan");
            if (0 == e.length) sscFunObj.wzzs.getlist("", ""); else if (e.hasClass("screen")) e.hasClass("screen") && "更多" != e.text() && sscFunObj.wzzs.getlist("", e.text().replace(/[\u4e00-\u9fa5]/g, "")); else {
                var l = e[0].classList[0], i = getDateStr(fastClickDate[l], !0);
                sscFunObj.wzzs.getlist(i, "")
            }
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : wz_mc_val, s = 0; s < wz_mc_val.length; s++) t.locatePosition(s, a[s])
        }
    }), dwzs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".dwzs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: dwzs_qs_val,
        callback: function (t, a, s) {
            dwzs_qs_val[0] = 1 * a[0].id, sscFunObj.wzzs.getlist("", dwzs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dwzs_qs_val, s = 0; s < dwzs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".dwzs_bzxz", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), lzcheckObj = {
        zhms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6"],
            select_arr2: ["dansuShow", "daxiaoShow", "longhuShow"]
        },
        dxms: {
            checkIndex: [0],
            checkVal: ["ball_1"],
            checkVal_cn: "第一球",
            select_arr2: ["dansuShow", "daxiaoShow", "longhuShow"]
        },
        lmms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6"],
            checkIndex: [0],
            checkVal: ["daxiaoShow"],
            checkVal_cn: "大小"
        }
    }, condition_dxms_mc = [{
        data: [{value: "第一球", id: "ball_1"}, {value: "第二球", id: "ball_2"}, {
            value: "第三球",
            id: "ball_3"
        }, {value: "第四球", id: "ball_4"}, {value: "第五球", id: "ball_5"}, {value: "总和", id: "ball_6"}]
    }], condition_zh_lz = [{
        data: [{name: "单双", value: "dansuShow"}, {name: "大小", value: "daxiaoShow"}, {
            name: "龙虎",
            value: "longhuShow"
        }]
    }], condition_lmms_lz = [{
        data: [{value: "大小", id: "daxiaoShow"}, {value: "单双", id: "dansuShow"}, {
            value: "龙虎",
            id: "longhuShow"
        }]
    }], condition_zh_mc = [{
        data: [{name: "第一球", value: "ball_1"}, {name: "第二球", value: "ball_2"}, {
            name: "第三球",
            value: "ball_3"
        }, {name: "第四球", value: "ball_4"}, {name: "第五球", value: "ball_5"}, {name: "总和", value: "ball_6"}]
    }];
lzfxzhms(), $(".luzufx  .Pattern").on("click", "span", function () {
    var t = $(this);
    $("#F_zhfx_meci").parents(".mobileSelect").remove(), $("#F_zhfx_model").parents(".mobileSelect").remove(), t.hasClass("zonghu") ? lzfxzhms() : t.hasClass("danxms") ? lzfxdxms() : lzfxlmms()
});