function fgxremove() {
    $(".line_wzzs").remove(), $(".line_gyh").remove()
}

function iframe() {
    var t = $(".animate").width(), a = 780 * t / 1125, s = t / 1125;
    setTimeout(function () {
        $(".animate iframe").contents().find("html").css("zoom", s);
        $(".animate iframe").contents().find(".container").height();
        $(".animate").animate({height: a + 50}, 600), $(".animate iframe").animate({height: a + 50}, 600), $(".content").animate({height: a + 25}, 600)
    }, 1), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("#preloader").fadeOut("slow")
    }, 1e3)
}

function startVideo() {
    $("#videoiframe").attr('src',config.videourl+"view/video/11x5_video/index.html?"+lotCode);
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        var t = 880 * $(".animate").width() / 1310;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            //iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
        })
    })
}

function createData() {
    var t = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        a = [];
    return $("#headerData").find("#pk10num li").each(function () {
        a.push(parseInt($(this).text()))
    }), {
        preDrawCode: a,
        sumNum: $("#sumNum").val(),
        sumBigSmall: $("#sumBigSmall").val(),
        sumSingleDouble: $("#sumSingleDouble").val(),
        drawIssue: $(".nextIssue").val(),
        drawTime: $(".drawTime").val(),
        preDrawTime: t
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
        a = a.substring(a.length - 8, a.length - 3), s += '<span class="graytime">' + a + "</span>", s += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", s += "</span>", s += "</div>", s += '<div class="rightspan">', s += '<div class="rightdiv padl0">', s += '<div class="haomali"><ul id="" class="ssclilist listli">';
        var e = this.preDrawCode.split(",");
        $(e).each(function (t) {
            "" != this && (e.length, s += '<li><span class="bluenum"><i>' + this + "</i></span></li>")
        }), s += "</ul></div>", s += '<div class="longhuli displaynone"><ul id="" class="syxwlilist ssclilistxt listli lhlist">';
        var l = "style='color:";
        if (!(e.length <= 1)) {
            this.sumBigSmall;
            var i = "0" == this.sumSingleDouble ? "单" : "双", n = "";
            "0" == this.dragonTiger ? n = "龙" : "1" == this.dragonTiger ? n = "虎" : "2" == this.dragonTiger && (n = "和")
        }
        s += "<li  style='color:#f12d35'>" + this.sumNum + "</li>";
        var d = tools.typeOf("dxh", this.sumBigSmall), i = "";
        "0" == this.sumSingleDouble ? i = "单" : "1" == this.sumSingleDouble ? i = "双" : "2" == this.sumSingleDouble && (i = "和");
        var o = "大" == d ? l + "#f12d35'" : "", c = "双" == i ? l + "#f12d35'" : "",
            r = "龙" == (n = "0" == this.dragonTiger ? "龙" : "虎") ? l + "#f12d35'" : "",
            h = tools.typeOf("san", this.behindThree), f = "顺子" == h ? l + "#f12d35'" : "",
            u = tools.typeOf("san", this.betweenThree), b = "顺子" == u ? l + "#f12d35'" : "",
            p = tools.typeOf("san", this.lastThree);
        s += "<li " + o + ">" + d + "</li>", s += "<li " + c + ">" + i + "</li>", s += "<li " + r + ">" + n + "</li>", s += "<li " + f + ">" + h + "</li>", s += "<li " + b + ">" + u + "</li>", s += "<li " + ("顺子" == p ? l + "#f12d35'" : "") + ">" + p + "</li>", s += "</ul>", s += "</div>", s += "</div>", s += "</div>", s += "</div>"
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
        var n = $(this).text(), d = n % 2 == 0, o = n >= 6;
        -1 != t.indexOf("单") ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : -1 != t.indexOf("双") ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("大") ? a ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : e ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("小") && (a ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
    })
}

function fancongshow() {
    for (var t = $(".table_hamafb tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var l = 0; l <= a; l++) {
        var i = t.eq(l).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function orshowConten() {
    $("#F_bzsz li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.jbzsLine("trend_table2")
    }, 500) : $(".table_conBox canvas").hide(), $("#F_bzsz li[data-value='fancong']").hasClass("check_tj") ? fancongshow_dwzs() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_bzsz li[data-value='yilo']").hasClass("check_tj") ? ($("td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), $("#F_bzsz li[data-value='fgx']").hasClass("check_tj") ? (fgxremove(), setTimeout(function () {
        for (var t = $(".table_hamafb tbody tr"), a = t.length - 6, s = 2; s < a; s += 5) $(t[s]).after("<tr class='line_wzzs'><td colspan='13'></td></tr>")
    }, 100)) : $(".line_wzzs").remove()
}

function fancongshow_dwzs() {
    for (var t = $(".table_hamafb tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var l = 0; l <= a; l++) {
        var i = t.eq(l).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function checkhmqhlzHm() {
    var t = $("#hmqhlzmcul").find(".hmqhlzHMAct");
    $(".tablelist").hide(), $(t).each(function (t, a) {
        var s = "#" + $(a).attr("value");
        $(s).show()
    })
}

function fancongshow() {
    for (var t = $("#singtai_content tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var l = 0; l <= a; l++) {
        var i = t.eq(l).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function orshowConten_siantai() {
    $("#F_tiaojian_singtai li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.diweione("singtai_content"), chartOfBaseTrend.diweitwo("singtai_content")
    }, 500) : $(".singtaizs canvas").hide(), $("#F_tiaojian_singtai li[data-value='fancong']").hasClass("check_tj") ? fancongshow() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_tiaojian_singtai li[data-value='yilo']").hasClass("check_tj") ? ($("#singtai_content td").find("span").show(), $("#singtai_content .showspan span").show()) : ($("#singtai_content tbody tr td:not([class])").find("span").hide(), $("#singtai_content .fancongcls span").hide(), $("#singtai_content .showspan span").hide()), $("#F_tiaojian_singtai li[data-value='fgx']").hasClass("check_tj") ? (fgxremove(), setTimeout(function () {
        for (var t = $("#singtai_content tbody tr"), a = t.length - 6, s = 2; s < a; s += 5) $(t[s]).after("<tr class='line_wzzs'><td colspan='8'></td></tr>")
    }, 100)) : $(".line_wzzs").remove()
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
    -1 != a.indexOf("show_lohu") && $(".luzufx .longhuShow").show()
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

function showExplain_smwf() {
    $(".explian_smwf").css({height: $("body").height(), top: "0", display: "block"})
}

function hideExplain_smwf() {
    $(".explian_smwf").css({height: "0", top: "-200rem", display: "none"})
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

function assclass(t) {
    return (t *= 1) >= 15 && t <= 30 ? "rednum_tj" : t >= 31 && t <= 40 ? "bluenum_tj" : t >= 41 && t <= 50 ? "greennum_tj" : ""
}

function orshowConten_lhzs(t) {
    var a = void 0 == t || "" == t ? "#F_gyhzs_fx" : t;
    $(a + " li[data-value='fancong']").hasClass("check_tj") ? fancongshow_lhzs() : ($(".fancongcls_gyh").addClass("showspan"), $(".fancongcls_gyh").removeClass("fancongcls_gyh")), $(a + " li[data-value='yilo']").hasClass("check_tj") ? ($("#table_lhzs tr td span").show(), $("#table_lhhmzs tr td span").show()) : ($("#table_lhzs .fancongcls_gyh span").hide(), $("#table_lhzs tr td:not([class])").find("span").hide(), $(".showspan span").hide(), $("#table_lhhmzs .fancongcls_gyh span").hide(), $("#table_lhhmzs tr td:not([class])").find("span").hide()), $(a + " li[data-value='fgx']").hasClass("check_tj") ? (fgxremove(), setTimeout(function () {
        if (fgxremove(), $(".Pattern .longhzs").hasClass("checkspan")) var t = $("#table_lhhmzs tbody tr"),
            a = 4; else var a = 12, t = $("#table_lhzs tbody tr");
        for (var s = t.length - 5, e = 2; e < s; e += 5) $(t[e]).after("<tr class='line_gyh'><td colspan='" + a + "'></td></tr>")
    }, 100)) : fgxremove(), $(a + " li[data-value='caix']").hasClass("check_tj") ? ($("canvas").remove(), setTimeout(function () {
        $("canvas").remove(), $(".Pattern .longhzs").hasClass("checkspan") ? chartOfBaseTrend.guanyaheLine("table_lhhmzs") : chartOfBaseTrend.syxwlhzsLine("table_lhzs")
    }, 500)) : $("canvas").remove()
}

function fancongshow_lhzs() {
    if ($(".Pattern .longhzs").hasClass("checkspan")) var t = $("#table_lhhmzs tbody tr"),
        a = 2; else var t = $("#table_lhzs tbody tr"), a = 1;
    for (var s = (t = t.slice(0, t.length - 5)).length, e = t.filter(":first").children("td").size(), l = a; l < e; l++) for (var i = 0; i <= s; i++) {
        var n = t.eq(i).children("td").eq(l);
        if (n.hasClass("hot_gyh")) break;
        n.addClass("fancongcls_gyh")
    }
}

function orshowConten_hzzs() {
    $("#F_hzhmfb_bz li[data-value='fancong']").hasClass("check_tj") ? fancongshow_hzzs() : ($(".fancongcls_gyh").addClass("showspan"), $(".fancongcls_gyh").removeClass("fancongcls_gyh")), $("#F_hzhmfb_bz li[data-value='yilo']").hasClass("check_tj") ? ($("#table_hzhaomafb tr td span").show(), $("#table_hzhaomafb tr td span").show()) : ($("#table_hzhaomafb .fancongcls_gyh span").hide(), $("#table_hzhaomafb tr.zslistUl td:not([class])").find("span").hide(), $(".showspan span").hide(), $("#table_hzhaomafb .fancongcls_gyh span").hide(), $("#table_hzhaomafb tr td:not([class])").find("span").hide()), $("#F_hzhmfb_bz li[data-value='fgx']").hasClass("check_tj") ? (fgxremove(), setTimeout(function () {
        for (var t = $("#table_hzhaomafb tbody tr"), a = $("#table_hzhwei tbody tr"), s = t.length - 5, e = 2; e < s; e += 5) $(t[e]).after("<tr class='line_gyh'><td colspan='31'></td></tr>"), $(a[e]).after("<tr class='line_gyh'><td colspan='1'></td></tr>")
    }, 100)) : $(".line_gyh").remove(), $("#F_hzhmfb_bz li[data-value='caix']").hasClass("check_tj") ? (setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.syxwhzzsLine("table_hzhaomafb")
    }, 500), setTimeout(function () {
        var t = $(".leftDate").width();
        $(".rightDate canvas").each(function () {
            var a = 1 * $(this).css("left").replace("px", "");
            $(this).css("left", a - t + "px")
        })
    }, 550)) : $(".rightDate canvas").hide()
}

function fancongshow_hzzs() {
    for (var t = $("#table_hzhaomafb tbody tr"), a = (t = t.slice(0, t.length - 5)).length, s = 0; s < 31; s++) for (var e = 0; e <= a; e++) {
        var l = t.eq(e).children("td").eq(s);
        if (l.hasClass("hot")) break;
        l.addClass("fancongcls_gyh")
    }
}

function listettablearr(t, a) {
    if (t.length <= config.showrows && "hzhmfb" != a ? $(".lomorediv").hide() : ($(".lomorediv").show().attr("data-text", 0), $(".nextlo").show()), void 0 == a) {
        syxwtabledata = [];
        for (var s = 0, e = Math.ceil(t.length / config.showrows); s < e; s++) (l = []).push(t.slice(s * config.showrows, (s + 1) * config.showrows)), syxwtabledata.push(l)
    } else if ("lhhzzs" == a) {
        syxwtabledata_hz = [];
        for (var s = 0, e = Math.ceil(t.length / config.showrows); s < e; s++) (l = []).push(t.slice(s * config.showrows, (s + 1) * config.showrows)), syxwtabledata_hz.push(l)
    } else if ("hzhmfb" == a) {
        syxwtabledata_fb = [];
        for (var s = 0, e = Math.ceil(t.length / config.showrows); s < e; s++) {
            var l = [];
            l.push(t.slice(s * config.showrows, (s + 1) * config.showrows)), syxwtabledata_fb.push(l)
        }
    }
    $(".prevlo").hide().parent().attr("data-text", 0)
}

function eachcontent_dwzs(t) {
    $("#singtai_content tbody").empty(), $("canvas").remove();
    var a = "", s = dw_mc_val[0] || 0;
    $(t).each(function (t) {
        var e = $(this)[0].code.toString().split(","), l = $(this)[0].array.slice($(this)[0].array.length - 6);
        a += "<tr><td >" + $(this)[0].issue + "</td><td ><span>" + e[s] + "</span></td>";
        for (var i = 0; i < l.length; i++) {
            var n = "", d = "";
            1 * l[i] > 0 ? (0 == i ? n = "大" : 1 == i ? n = "小" : 2 == i ? n = "和" : 3 == i ? (n = "单", d = "orcls") : 4 == i ? (n = "双", d = "orcls") : 5 == i && (n = "和", d = "orcls"), a += "<td class='hot'><span name='hotSpan' class='" + d + "'>" + n + "</span></td>") : a += "<td><span>" + -1 * l[i] + "</span></td>"
        }
        a += "</tr>"
    }), $("#singtai_content tbody").html(a + dwzsfooter), orshowConten_siantai()
}

function eachconten_jbzs(t) {
    $(".wezizs #chartLinediv").empty();
    var a = wz_mc_val[0], s = "";
    s += " <table  class='table_hamafb' id='trend_table2'>", s += "<thead><tr><th>期号</th><th>号码</th><th>1</th><th>2</th>", s += "<th>3</th><th>4</th><th>5</th>", s += "<th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th></tr></thead><tbody><tr>", $(t).each(function (t) {
        if (10055 == lotCode) e = config.showrows; else var e = 200;
        if (t >= e) return !1;
        var l = this.code.split(","), i = this.array.slice(11 * a, 11 * a + 11);
        s += " <td>" + this.issue.toString().slice(4) + "</td><td class='tabred'><span>" + l[a] + "</span></td>";
        for (var n = 0; n < i.length; n++) 1 * i[n] > 0 || 1 * i[n] == 0 ? s += "<td class='hot'><span name='hotSpan'>" + i[n] + "</span></td>" : s += "<td><span>" + Math.abs(i[n]) + "</span></td>";
        s += "</tr>"
    }), s += jbzsfooter + "</tbody></table>", $(".wezizs #chartLinediv").html(s)
}

function eachconten_lhzs(t) {
    $("#table_lhhmzs tbody").empty(), fgxremove();
    var a = "";
    $(t).each(function (t, s) {
        var e = s.issue, l = s.code.split(",");
        l = "<span style='color:red'>" + l[0] + "</span>&nbsp; " + l[1] + "&nbsp;" + l[2] + "&nbsp;" + l[3] + "&nbsp;<span style='color:red'>" + l[4] + "</span>";
        var i = s.array, n = "", d = i.slice(i.length - 2);
        a += "<tr><td>" + e + "</td><td>" + l + "</td>", $(d).each(function (t) {
            this > 0 ? (0 == t ? n = "龙" : 1 == t && (n = "虎"), a += "<td class='hot_gyh'><span style='background:#1fa6e8'>" + n + "</span></td>") : (n = Math.abs(this), a += "<td><span>" + n + "</span></td>")
        }), a += "</tr>"
    }), $("#table_lhhmzs tbody").append(a + lhzsfooter), orshowConten_lhzs()
}

function eachconten_lhhzzs(t) {
    var a = "";
    $("#table_lhzs tbody").empty();
    var s = 0 == hm_mc_val[0] ? 1 : hm_mc_val[0];
    $(t).each(function (t, e) {
        var l = e.issue, i = e.array;
        if ("1" == s) n = i.slice(0, i.length - 13); else var n = i.slice(11, i.length - 2);
        a += "<tr><td>" + l + "</td>", $(n).each(function (t) {
            if (t >= 300) return !1;
            a += this > 0 ? "<td class='hot_gyh'><span style='background:#1fa6e8'>" + this + "</span></td>" : "<td><span>" + Math.abs(this) + "</span></td>"
        }), a += "</tr>"
    }), $("#table_lhzs tbody").append(a + lhhzzsfooter), orshowConten_lhzs("#F_hmzs_bzsz")
}

function eachcontenhzhmfb(t, a) {
    $("#table_hzhwei tbody tr").remove(), $(".rightDate").find(".zslistUl").remove(), fgxremove(), $("canvas").remove();
    var s = "", e = "<tr class='zslistUl'>";
    $("#table_hzhaomafb tbody").empty(), $(t).each(function (t, a) {
        var l = a.issue.slice(4), i = a.array, n = i.slice(0, i.length - 2);
        s += "<tr class='qishutr'><td>" + l + "</td></tr>", $(n).each(function (t) {
            e += this > 0 ? "<td class='hot'><span name='hotSpan'>" + this + "</span></td>" : "<td><span>" + Math.abs(this) + "</span></td>"
        }), e += "</tr>"
    }), $(".rightDate table tbody").append(e), s += "<tr class='missUl qishutr'><td>数据统计</td></tr><tr class='missUlWhite qishutr'><td>出现总数</td></tr><tr class='missUlWhite qishutr'><td>平均遗漏</td></tr><tr class='missUlWhite qishutr'><td>最大遗漏</td></tr><tr class='missUlWhite qishutr'><td>最大连出</td></tr>", $("#table_hzhwei tbody").append(s);
    $(".rightDate table tbody").append("<tr class='zslistUl missUl'><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td><td>32</td><td>33</td><td>34</td><td>35</td><td>36</td><td>37</td><td>38</td><td>39</td><td>40</td><td>41</td><td>42</td><td>43</td><td>44</td><td>45</td></tr>"), $(a).each(function (t) {
        var a = "", s = "", e = "", l = "", i = "", n = this.array;
        0 == t ? ($(n).each(function () {
            a += "<td><span>" + Math.abs(this) + "</span></td>"
        }), i = "<tr class='zslistUl missUlWhite'>" + a + "</tr>") : 1 == t ? ($(n).each(function () {
            s += "<td><span>" + Math.abs(this) + "</span></td>"
        }), i = "<tr class='zslistUl missUlWhite'>" + s + "</tr>") : 2 == t ? ($(n).each(function () {
            e += "<td><span>" + Math.abs(this) + "</span></td>"
        }), i = "<tr class='zslistUl missUlWhite'>" + e + "</tr>") : 3 == t && ($(n).each(function () {
            l += "<td><span>" + Math.abs(this) + "</span></td>"
        }), i = "<tr class='zslistUl missUlWhite'>" + l + "</tr>"), $(".rightDate table tbody").append(i)
    }), orshowConten_hzzs()
}

function checkDateFun(t, a) {
    a = void 0 == a ? "" : a;
    var s = $(".title_se_box .se_check").attr("target");
    s = (s = $("#" + s + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_syxw(s, t, a)
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

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    pubmethod.initAdata(), method.indexLoad(boxId), ifishad = !0;
    $("#startVideo").on("click", function () {
        startVideo();//$("iframe")[0].contentWindow.ifopen = !0, startVideo(), $("iframe")[0].contentWindow.k3v.startVideo(createData())
    }), document.addEventListener("click", function () {
       // $("iframe")[0].contentWindow.ifopen && $("iframe")[0].contentWindow.k3v.sound.play("audioidB")
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-200rem", height: "0", display: "block"}, 200, function () {
            $("#videobox").css({"z-index": "-1"});
            $("#videoiframe").attr('src',"");
        });
        //$("iframe")[0].contentWindow.k3v.sound.stop("audioidB"), $("iframe")[0].contentWindow.k3v.sound.stop("audioidR"), $("iframe")[0].contentWindow.ifopen = !1, $("iframe")[0].contentWindow.k3v.clearTime()
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
var ifishad = !1, boxId = "#headerData", method = {}, checlick = !1;
method.loadOther = function (t) {
    if ("" != t || tools.ifOnDay()) {
        setTimeout(function () {
            method.todayData(t)
        }, 1e3), setTimeout(function () {
            method.longData(t)
        }, 2e3), $(".numbtn").find("li").removeClass("lichecked"), $(".dansdxbtn").find("li").removeClass("lichecked");
        var a = $(".headTitle .checkedbl").attr("id");
        tools.classGetDate_syxw(a, t, "")
    }
}, method.indexLoad = function (t) {
    headMethod.loadHeadData($(t).find(".nextIssue").val(), t)
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "ElevenFive/getElevenFiveList.do?date=" + t,
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
        url: config.publicUrl + "ElevenFive/queryDoubleNumber.do?date=" + t,
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
        url: config.publicUrl + "ElevenFive/getElevenFiveDailyDragon.do?lotCode=" + lotCode + "&date=" + t,
        type: "GET",
        data: {lottObj: ""},
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
        scrollRender.init(a), method.selectedBS($(".rightdiv").find(".spanchecked"), !0)
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
    tools.bigOrSmall(t, a, "6", "shiyi5")
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
        var a = [{data: [data.numOne, data.numTwo, data.numThree, data.numFour, data.numFive, data.numSix, data.numSeven, data.numEight, data.numNine, data.numTen, data.numEleven]}, {data: [data.firstSingle, data.firstDouble, data.firstBig, data.firstSmall]}, {data: [data.secondSingle, data.secondDouble, data.secondBig, data.secondSmall]}, {data: [data.thirdSingle, data.thirdDouble, data.thirdBig, data.thirdSmall]}, {data: [data.fourthSingle, data.fourthDouble, data.fourthBig, data.fourthSmall]}, {data: [data.fifthSingle, data.fifthDouble, data.fifthBig, data.fifthSmall]}, {data: [data.sumSingle, data.sumDouble, data.sumBig, data.sumSmall]}];
        $("#liangmianbox").empty(), $(a).each(function (t) {
            var a = "";
            $(this.data).each(function () {
                a += "<td>" + this + "</td>"
            });
            var s = tools.typeOf("liangm", t), e = "";
            0 == t ? e = "head1" : 1 == t && (e = "head2");
            var l = "";
            l = '<div class="lianmlist"><div  class="head ' + e + '">' + s + '</div><table cellpadding="0" cellspacing="0" border="0"><tr class="tr1">' + (t > 0 ? "<td>单</td><td>双</td><td>大</td><td>小</td>" : "<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td>") + '</tr><tr class="tr2">' + a + "</tr></table></div>", $("#liangmianbox").append(l)
        })
    }
}, method.loadLongData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data, config.ifdebug, $("#longDrag").empty("");
        for (var a = 0, s = data.length; a < s; a++) {
            var e = tools.typeOf("qiusyxw", data[a].rank), l = tools.typeOf("statedsyxw", data[a].state),
                i = data[a].count >= 5 ? "<span style='color:#f11821'>" + data[a].count + "</span>" : "<span>" + data[a].count + "</span>",
                n = "<li><span>" + e + "</span>：<span>" + l + "</span>" + i + "期</li>";
            11 != data[a].rank && 1 != data[a].rank && 2 != data[a].rank || (n = "<li><span>" + e + "</span>：<span>" + l + "</span>" + i + "期</li>"), $("#longDrag").append(n)
        }
    }
}, $(".reset").on("click", function () {
    $(".gotop").css("height", "0rem"), $(".loteyPage").removeClass("gotop"), $(".or_").each(function (t) {
        $(this).hasClass("check_tj") ? $(this).removeClass("check_tj").removeClass("or_") : $(this).addClass("check_tj").removeClass("or_")
    })
}), $(".lookshjtj").on("touchstart", function (t) {
    t.preventDefault();
    var a = $("#footerDiv");
    $("html,body").animate({scrollTop: a.offset().top}, 500)
}), $("#tiaojian_wzzs").on("click", ".marginTop>li", function () {
    $(this).toggleClass("check_tj or_")
}), $("#explainBtn_wfsm").on("touchstart", function () {
    showExplain_smwf()
}), $(".closesm").on("click", function () {
    hideExplain_smwf()
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
}), $(".longhuzs .Pattern span").on("click", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), "龙虎走势" == $(this).text() ? ($("canvas").remove(), orshowConten_lhzs(), $("#longhzsbox").removeClass(), $("#hmzsbox").removeClass().addClass("displaynone")) : "号码走势" == $(this).text() && ($("canvas").remove(), orshowConten_lhzs("#F_hmzs_bzsz"), $("#hmzsbox").removeClass(), $("#longhzsbox").removeClass().addClass("displaynone"))
}), $(".hezhizs .Pattern span").on("click", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), "和值和尾" == $(this).text() ? ($("#hzweizsbox").removeClass(), $("#hzhmfbzsbox").removeClass().addClass("displaynone")) : "和值号码分布" == $(this).text() && ($("#hzhmfbzsbox").removeClass(), $("#hzweizsbox").removeClass().addClass("displaynone"), orshowConten_hzzs())
});
var dwzsfooter = "", jbzsfooter = "", gyhzsfooter = "", lhzsfooter = "", syxwtabledata = "", syxwtabledata_hz = "",
    syxwtabledata_fb = "";
$(".dwzslodiv").on("click", "span", function (t) {
    var a = $(this), s = syxwtabledata.length, e = 1 * $(this).parent().attr("data-text");
    "dwzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "dwzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachcontent_dwzs(syxwtabledata[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
}), $(".jbzslodiv").on("click", "span", function (t) {
    var a = $(this), s = syxwtabledata.length, e = 1 * $(this).parent().attr("data-text");
    "jbzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "jbzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachconten_jbzs(syxwtabledata[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500), orshowConten()
}), $(".lh_lhzslodiv").on("click", "span", function (t) {
    var a = $(this), s = syxwtabledata.length, e = 1 * $(this).parent().attr("data-text");
    "lh_lhzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "lh_lhzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachconten_lhzs(syxwtabledata[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
}), $(".lh_hmzslodiv").on("click", "span", function (t) {
    var a = $(this), s = syxwtabledata.length, e = 1 * $(this).parent().attr("data-text");
    "lh_hmzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "lh_hmzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachconten_lhhzzs(syxwtabledata_hz[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
}), $(".hzhmfblodiv").on("click", "span", function (t) {
    var a = $(this), s = syxwtabledata.length, e = 1 * $(this).parent().attr("data-text");
    "hzhmfblo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "hzhmfblo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachcontenhzhmfb(syxwtabledata[e][0], syxwtabledata_fb[0][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
});
var hezhizsDataarr = "", lhzsDataarr = "", jbzsarr = "", dwzsarr = "", syxwFunObj = {
    jbzs: {
        init: function () {
            this.getlist("", 30)
        }, getlist: function (t, a) {
            var s = wz_mc_val[0];
            a = void 0 == a ? "" : a, "" != (t = void 0 != t && "" != t || "" != a ? t : getDateStr(0, !0)) && t != getDateStr(0, !0) || "" != a || ($(".shjian").text("今天"), $("#periods_wzzs ul li:first").addClass("checked").siblings().removeClass("checked")), $.ajax({
                url: config.publicUrl + "ElevenFive/queryElevnFiveTrendByIssue.do?date=" + t + "&issue=" + a,
                type: "GET",
                data: {lotCode: lotCode},
                beforeSend: function () {
                    $(".wezizs #chartLinediv").empty(), $("canvas").remove(), checlick = !1
                },
                success: function (t) {
                    checlick = !0, syxwFunObj.jbzs.createHtmlList(t, s), jbzsarr = t
                },
                error: function (t) {
                    checlick = !0, setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, createHtmlList: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data[0];
            if (void 0 != s.bodyList && 0 != s.bodyList.length) {
                listettablearr(s.bodyList), $(".wezizs #chartLinediv").empty();
                var e = "";
                e += " <table  class='table_hamafb' id='trend_table2'>", e += "<thead><tr><th>期号</th><th>号码</th><th>1</th><th>2</th>", e += "<th>3</th><th>4</th><th>5</th>", e += "<th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th></tr></thead><tbody><tr>", $(s.bodyList).each(function (t) {
                    if (10055 == lotCode) s = config.showrows; else var s = 200;
                    if (t >= s) return !1;
                    var l = this.code.split(","), i = this.array.slice(11 * a, 11 * a + 11);
                    e += " <td>" + this.issue.toString().slice(4) + "</td><td class='tabred'><span>" + l[a] + "</span></td>";
                    for (var n = 0; n < i.length; n++) 1 * i[n] > 0 || 1 * i[n] == 0 ? e += "<td class='hot'><span name='hotSpan'>" + i[n] + "</span></td>" : e += "<td><span>" + Math.abs(i[n]) + "</span></td>";
                    e += "</tr>"
                });
                var l = s.missList[0].array.slice(11 * a, 11 * a + 11),
                    i = s.missList[1].array.slice(11 * a, 11 * a + 11),
                    // n = s.missList[4].array.slice(11 * a, 11 * a + 11),
                    d = s.missList[3].array.slice(11 * a, 11 * a + 11),
                    o = s.missList[2].array.slice(11 * a, 11 * a + 11),
                    c = "</tr><tr class='clospan'><td colspan='2'>数据统计</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td></tr>";
                c += "<tr><td colspan='2'>出现次数</td>";
                for (var r = "<tr><td colspan='2'>平均遗漏</td>", h = "<tr style='display: none'><td colspan='2'>当前遗漏</td>", f = "<tr><td colspan='2'>最大连出</td>", u = "<tr><td colspan='2'>最大遗漏</td>", b = 0; b < l.length; b++) c += " <td>" + Math.abs(l[b]) + "</td>", r += " <td>" + Math.abs(i[b]) + "</td>", h += " <td></td>", f += " <td>" + Math.abs(d[b]) + "</td>", u += " <td>" + Math.abs(o[b]) + "</td>";
                e += (jbzsfooter = c + "</tr>" + r + "</tr>" + h + "</tr>" + f + "</tr>" + u + "</tr>") + "</tbody></table>", $(".wezizs #chartLinediv").html(e), orshowConten()
            } else tools.weikaiji(".wezizs #chartLinediv")
        }
    }, dwzs: {
        init: function () {
            this.getlist("", 30)
        }, getlist: function (t, a) {
            var s = 1 * dw_mc_val[0] + 1;
            a = void 0 == a ? "" : a, "" != (t = void 0 != t && "" != t || "" != a ? t : getDateStr(0, !0)) && t != getDateStr(0, !0) || "" != a || ($(".shjian_singtai").text("今天"), $("#rank_singtaizs ul li:first").addClass("checked").siblings().removeClass("checked")), $.ajax({
                url: config.publicUrl + "ElevenFive/queryElevnFiveLocalTrend.do?date=" + t + "&issue=" + a + "&num=" + 1 * s,
                type: "GET",
                data: {lotCode: lotCode},
                beforeSend: function () {
                    $("#singtai_content tbody").empty(), $("canvas").remove(), checlick = !1
                },
                success: function (t) {
                    syxwFunObj.dwzs.createHtmlList(t, 1 * s - 1), dwzsarr = t, checlick = !0
                },
                error: function (t) {
                    checlick = !0, setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, createHtmlList: function (t, a) {
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), $("#singtai_content tbody").empty(), data = data.result.data[0], void 0 != data.bodyList && 0 != data.bodyList.length) {
                listettablearr(data.bodyList);
                var s = "";
                $(data.bodyList).each(function (t) {
                    if (10055 == lotCode) e = config.showrows; else var e = 200;
                    if (t >= e) return !1;
                    var l = $(this)[0].code.toString().split(","),
                        i = $(this)[0].array.slice($(this)[0].array.length - 6);
                    s += "<tr><td >" + $(this)[0].issue + "</td><td class='nohide'><span>" + l[a] + "</span></td>";
                    for (var n = 0; n < i.length; n++) {
                        var d = "", o = "";
                        1 * i[n] > 0 ? (0 == n ? d = "大" : 1 == n ? d = "小" : 2 == n ? d = "和" : 3 == n ? (d = "单", o = "orcls") : 4 == n ? (d = "双", o = "orcls") : 5 == n && (d = "和", o = "orcls"), s += "<td class='hot'><span name='hotSpan' class='" + o + "'>" + d + "</span></td>") : s += "<td><span>" + -1 * i[n] + "</span></td>"
                    }
                    s += "</tr>"
                }), $("#singtai_content tbody").html(s), html2 = "<tr class='clospan'><td rowspan='2' colspan='2'>数据统计</td><td colspan='3'>大小</td><td colspan='3'>单双</td><tr class='clospan'><td>大</td><td>小</td><td>和</td><td>单</td><td>双</td><td>和</td></tr>";
                var e = data.missList[0].array.length - 6, l = data.missList[0].array.slice(e),
                    i = data.missList[1].array.slice(e), n = data.missList[3].array.slice(e),
                    d = data.missList[2].array.slice(e);
                //var o = data.missList[4].array.slice(e);
                var c = "</tr>",
                    r = "<tr><td colspan='2'>出现次数</td>", h = "<tr><td colspan='2'>平均遗漏</td>",
                    f = "<tr><td colspan='2'>最大连出</td>", u = "<tr><td colspan='2'>最大遗漏</td>";
                html_5 = "<tr style='display: none'><td colspan='2'>当前遗漏</td>";
                for (var b = 0; b < l.length; b++) r += "<td>" + Math.abs(l[b]) + "</td>", h += "<td>" + Math.abs(i[b]) + "</td>", f += "<td>" + Math.abs(n[b]) + "</td>", u += "<td>" + Math.abs(d[b]) + "</td>", html_5 += "<td></td>";
                dwzsfooter = html2 + r + c + h + c + f + c + u + c + html_5 + c, $("#singtai_content tbody>tr:last-child").after(dwzsfooter), orshowConten_siantai()
            } else tools.weikaiji("#singtai_content tbody")
        }
    }, lzfx: {
        init: function () {
            this.getlist("")
        }, getlist: function (t) {
            "" == t && $(".today_lz").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                url: config.publicUrl + "ElevenFive/queryComprehensiveRoadBead.do",
                type: "GET",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    syxwFunObj.lzfx.addlzTable(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlzTable: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".luzufx .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state;
                    if (1 == l) {
                        var i = "单", n = "双", d = "和", o = "单双";
                        s = "dansuShow"
                    } else if (2 == l) {
                        var i = "小", n = "大", d = "和", o = "大小";
                        s = "daxiaoShow"
                    } else if (3 == l) {
                        var i = "虎", n = "龙", d = "", o = "龙虎";
                        s = "longhuShow"
                    }
                    var c = a.result.data[e].rank,
                        r = "<div class='lz_title " + s + " ball_" + c + "'><div class='left'><span>今日累计:</span>",
                        h = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var f = 0, u = 0, b = 0, p = 0; f < a.result.data[e].roadBeads.length && !(f >= 200); f++) {
                        var m = a.result.data[e].roadBeads[f];
                        3 != l ? 0 == m ? (m = d, p += 1) : 1 == m ? (m = n, b += 1) : -1 == m && (m = i, u += 1) : 0 == m ? (m = i, u += 1) : (m = n, b += 1), 0 == f && (h += "<p>" + m + "</p>"), f > 0 & a.result.data[e].roadBeads[f - 1] == a.result.data[e].roadBeads[f] ? h += "<p>" + m + "</p>" : f > 0 & a.result.data[e].roadBeads[f - 1] != a.result.data[e].roadBeads[f] && (h += "</td><td><p>" + m + "</p>")
                    }
                    var _ = "";
                    if (1 == c ? _ = "第一球" : 2 == c ? _ = "第二球" : 3 == c ? _ = "第三球" : 4 == c ? _ = "第四球" : 5 == c ? _ = "第五球" : 6 == c ? _ = "总和" : 7 == c && (_ = "和尾"), "" == d) v = "<span>" + i + "（" + u + "）</span><span>" + n + "（" + b + "）</span></div><div class='right'><span class='weizi'>" + _ + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"; else var v = "<span>" + i + "（" + u + "）</span><span>" + n + "（" + b + "）</span><span>" + d + "（" + p + "）</span></div><div class='right'><span class='weizi'>" + _ + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".luzufx .lz_content").append(r + v + h + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red"), $(".tablebox>td>p:contains('和')").css("color", "#0092DD");
                var z = $(".luzufx .Pattern .checkspan");
                $("#F_zhfx_meci").parents(".mobileSelect").remove(), $("#F_zhfx_model").parents(".mobileSelect").remove(), z.hasClass("zonghu") ? lzfxzhms() : z.hasClass("danxms") ? lzfxdxms() : lzfxlmms(), animate_lz()
            } else tools.weikaiji(".luzufx .lz_content")
        }
    }, dsdxls: {
        listData: function (t) {
            t = void 0 == t ? "" : t, $.ajax({
                url: config.publicUrl + "ElevenFive/queryHistoryDataForDsdx.do",
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    syxwFunObj.dsdxls.dsdxlsHtmlList(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, dsdxlsHtmlList: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            var s = a.result.data;
            $("#dsdxlstable tbody").empty(), $("#tableBox tbody").empty(), fgxremove(), $(s).each(function (t) {
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
        listData: function (t) {
            "" == (t = void 0 == t ? "" : t) && $("#today_dsdxlz").addClass("todayAct_dsdxlz").siblings().removeClass("todayAct_dsdxlz"), $.ajax({
                url: config.publicUrl + "ElevenFive/queryComprehensiveRoadBead.do?date=" + t,
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    syxwFunObj.dsdxlz.addlzTable_dsdxlz(t)
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
                        var i = "单", n = "双", d = "和";
                        s = "dansuShow"
                    } else if (2 == l) {
                        var i = "小", n = "大", d = "和";
                        s = "daxiaoShow"
                    } else if (3 == l) {
                        var i = "虎", n = "龙", d = "和";
                        s = "longhuShow displaynone"
                    }
                    var o = a.result.data[e].rank,
                        c = "<div class='lz_title " + s + " t" + (o - 1) + "'><div class='left'><span>累计:</span>",
                        r = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var h = 0, f = 0, u = 0, b = 0; h < a.result.data[e].roadBeads.length && !(h >= 200); h++) {
                        var p = a.result.data[e].roadBeads[h];
                        -1 == p ? (p = i, f += 1) : 0 == p ? (p = d, u += 1) : 1 == p && (p = n, b += 1), 0 == h && (r += "<p>" + p + "</p>"), h > 0 & a.result.data[e].roadBeads[h - 1] == a.result.data[e].roadBeads[h] ? r += "<p>" + p + "</p>" : h > 0 & a.result.data[e].roadBeads[h - 1] != a.result.data[e].roadBeads[h] && (r += "</td><td><p>" + p + "</p>")
                    }
                    var m = "";
                    1 == o ? m = "第一球" : 2 == o ? m = "第二球" : 3 == o ? m = "第三球" : 4 == o ? m = "第四球" : 5 == o ? m = "第五球" : 6 == o ? m = "总和" : 7 == o && (m = "和尾");
                    var _ = "<span>" + i + "（" + a.result.data[e].totals[1] + "）</span><span>" + n + "（" + a.result.data[e].totals[0] + "）</span><span> 和（" + a.result.data[e].totals[2] + "）</span></div><div class='right'><span class='weizi'>" + m + "</span><span class='mosh'>" + n + i + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".dsdxlz .dsdxlz_content").append(c + _ + r + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('和')").css("color", "blue"), $("#dsdxlzlist .dansuShow ").hide(), showSxend(), animate_lz_dsdxlz()
            } else tools.weikaiji(".dsdxlz .dsdxlz_content")
        }
    }, jrhmtj: {
        listData: function (t) {
            void 0 == t && (t = ""), $.ajax({
                url: config.publicUrl + "ElevenFive/queryNumberCount.do?",
                type: "GET",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    syxwFunObj.jrhmtj.dsdxlsHtmlList(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, dsdxlsHtmlList: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode) for (var s = "", e = a.result.data, l = "", i = 1, n = 0; n < e.length - 6; n++) {
                0 == n ? l = "第一球" : 1 == n ? l = "第二球" : 2 == n ? l = "第三球" : 3 == n ? l = "第四球" : 4 == n && (l = "第五球"), s += "<div class='item_" + (n + 1) + " item_'><span class='item_title'>" + l + "</span><ul class='num_item'>", s += "<li class='li_first'>号码</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li><li>7</li> <li>8</li><li>9</li><li>10</li><li>11</li></ul>";
                var d = "<ul class='zongkai_item'><li class='li_first'>总开</li>";
                maxopen = "<ul class='liankai_item'><li class='li_first'>未开</li>";
                for (var o = 0; o < e.length; o++) {
                    var c = "", r = "";
                    1 == i ? (c = e[o].array[0], r = Math.abs(e[o].array[1])) : 2 == i ? (c = e[o].array[2], r = Math.abs(e[o].array[3])) : 3 == i ? (c = e[o].array[4], r = Math.abs(e[o].array[5])) : 4 == i ? (c = e[o].array[6], r = Math.abs(e[o].array[7])) : 5 == i && (c = e[o].array[8], r = Math.abs(e[o].array[9]));
                    var h = assclass(c), f = assclass(r);
                    d += "<li class='" + h + "'>" + c + "</li>", maxopen += "<li class='" + f + "'>" + r + "</li>"
                }
                s += d + "</ul>" + maxopen + "</ul></div>", i++
            }
            $(".todayhaomatj .showconten").html(s)
        }
    }, zhlz: {
        listData: function (t) {
            "" == (t = void 0 == t ? "" : t) && $(".today_lz").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                url: config.publicUrl + "ElevenFive/queryComprehensiveRoadBead.do",
                type: "GET",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    syxwFunObj.zhlz.addlzTable_dsdxlz(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlzTable_dsdxlz: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".zonghelz .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state;
                    if (1 == l) {
                        var i = "单", n = "双", d = "和";
                        s = "dansuShow"
                    } else if (2 == l) {
                        var i = "小", n = "大", d = "和";
                        s = "daxiaoShow"
                    }
                    if (6 == a.result.data[e].rank) {
                        var o = "<div class='lz_title " + s + " ball_" + l + "'><div class='left'><span>今日累计:</span>",
                            c = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                        a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                        for (var r = 0, h = 0, f = 0, u = 0; r < a.result.data[e].roadBeads.length && !(r >= 200); r++) {
                            var b = a.result.data[e].roadBeads[r];
                            -1 == b ? (b = i, h += 1) : 1 == b ? (b = n, u += 1) : 0 == b && (b = d, f += 1), 0 == r && (c += "<p>" + b + "</p>"), r > 0 & a.result.data[e].roadBeads[r - 1] == a.result.data[e].roadBeads[r] ? c += "<p>" + b + "</p>" : r > 0 & a.result.data[e].roadBeads[r - 1] != a.result.data[e].roadBeads[r] && (c += "</td><td><p>" + b + "</p>")
                        }
                        if (void 0 != a.result.data[e].totals[2]) p = "<span>" + i + "（" + a.result.data[e].totals[1] + "）</span><span>" + n + "（" + a.result.data[e].totals[0] + "）</span><span>" + d + "（" + a.result.data[e].totals[2] + "）</span></div><div class='right'><span class='weizi'>总和</span><span class='mosh'>" + i + n + "</span><span class='zxi'>最新    &darr;</span></div>"; else var p = "<span>" + i + "（" + a.result.data[e].totals[1] + "）</span><span>" + n + "（" + a.result.data[e].totals[0] + "）</span></div><div class='right'><span class='weizi'>总和</span><span class='mosh'>" + i + n + "</span><span class='zxi'>最新    &darr;</span></div>";
                        $(".zonghelz .lz_content").append(o + p + c + "</td></tr></tbody></table></div></div>")
                    }
                }
                $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), animate_lz()
            } else tools.weikaiji(".zonghelz .lz_content")
        }
    }, lhzs: {
        listData: function (t, a) {
            a = void 0 == a ? "" : a, "" != (t = void 0 != t && "" != t || "" != a ? t : getDateStr(0, !0)) && t != getDateStr(0, !0) || "" != a || ($(".gyhtodayBtn span").text("今天"), $("#gyhshowBox ul li:first").addClass("gyhtimesAtc").siblings().removeClass("gyhtimesAtc")), $.ajax({
                url: config.publicUrl + "ElevenFive/queryElevnFiveDTTrend.do?issue=" + a + "&date=" + t,
                type: "GET",
                data: {lotCode: lotCode},
                beforeSend: function () {
                    $("#table_lhhmzs tbody").empty(), $("#table_lhzs tbody").empty(), $("canvas").remove(), checlick = !1
                },
                success: function (t) {
                    syxwFunObj.lhzs.createList(t), checlick = !0
                },
                error: function (t) {
                    checlick = !0, config.ifdebug
                }
            })
        }, createList: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.result.data.length) return tools.weikaiji("#table_lhhmzs tbody"), tools.weikaiji("#table_lhzs tbody"), !1;
            listettablearr((lhzsDataarr = a.result.data[0]).bodyList), syxwFunObj.lhzs.qiuDate(lhzsDataarr, "1"), $("#table_lhhmzs tbody").empty(), fgxremove(), $(lhzsDataarr.bodyList).each(function (t, a) {
                if (10055 == lotCode) s = config.showrows; else var s = 200;
                if (t >= s) return !1;
                var e = a.issue, l = a.code.split(",");
                l = "<span style='color:red'>" + l[0] + "</span>&nbsp; " + l[1] + "&nbsp;" + l[2] + "&nbsp;" + l[3] + "&nbsp;<span style='color:red'>" + l[4] + "</span>";
                var i = a.array, n = "", d = "", o = i.slice(i.length - 2);
                d += "<tr><td>" + e + "</td><td class='nohide'>" + l + "</td>", $(o).each(function (t) {
                    this > 0 ? (0 == t ? n = "龙" : 1 == t && (n = "虎"), d += "<td class='hot_gyh'><span style='background:#1fa6e8'>" + n + "</span></td>") : (n = Math.abs(this), d += "<td><span>" + n + "</span></td>")
                }), d += "</tr>", $("#table_lhhmzs tbody").append(d)
            });
            var s = "<td colspan='2'>出现总数</td>", e = "<td colspan='2'>平均遗漏</td>", l = "<td colspan='2'>最大遗漏</td>",
                i = "<td colspan='2'>最大连出</td>";
            $(lhzsDataarr.missList).each(function (t) {
                var a = this.array.splice(this.array.length - 2);
                0 == t ? $(a).each(function () {
                    s += "<td>" + Math.abs(this) + "</td>"
                }) : 1 == t ? $(a).each(function () {
                    e += "<td>" + Math.abs(this) + "</td>"
                }) : 2 == t ? $(a).each(function () {
                    l += "<td>" + Math.abs(this) + "</td>"
                }) : 3 == t && $(a).each(function () {
                    i += "<td>" + Math.abs(this) + "</td>"
                })
            }), lhzsfooter = "<tr><th colspan='2'>数据统计</th><th>龙</th><th>虎</th></tr><tr class='clospan_gyh'>" + s + "</tr><tr class='clospan_gyh'>" + e + "</tr><tr class='clospan_gyh'>" + l + "</tr><tr class='clospan_gyh'>" + i + "</tr>", $("#table_lhhmzs tbody").append(lhzsfooter), orshowConten_lhzs()
        }, qiuDate: function (t, a) {
            fgxremove(), $("#table_lhzs tbody").empty(), listettablearr(t.bodyList, "lhhzzs"), $(t.bodyList).each(function (t, s) {
                if (10055 == lotCode) e = config.showrows; else var e = 200;
                if (t >= e) return !1;
                var l = s.issue, i = s.array, n = "";
                if ("1" == a) d = i.slice(0, i.length - 13); else var d = i.slice(11, i.length - 2);
                n += "<tr><td>" + l + "</td>", $(d).each(function (t) {
                    if (t >= 300) return !1;
                    n += this > 0 ? "<td class='hot_gyh'><span style='background:#1fa6e8'>" + this + "</span></td>" : "<td><span>" + Math.abs(this) + "</span></td>"
                }), n += "</tr>", $("#table_lhzs tbody").append(n)
            });
            var s = "<td>出现总数</td>", e = "<td>平均遗漏</td>", l = "<td>最大遗漏</td>", i = "<td>最大连出</td>";
            $(t.missList).each(function (t) {
                if ("1" == a) n = this.array.slice(0, 11); else var n = this.array.slice(11, 22);
                0 == t ? $(n).each(function () {
                    s += "<td>" + Math.abs(this) + "</td>"
                }) : 1 == t ? $(n).each(function () {
                    e += "<td>" + Math.abs(this) + "</td>"
                }) : 2 == t ? $(n).each(function () {
                    l += "<td>" + Math.abs(this) + "</td>"
                }) : 3 == t && $(n).each(function () {
                    i += "<td>" + Math.abs(this) + "</td>"
                })
            }), lhhzzsfooter = "<tr><th>数据统计</th><th>01</th><th>02</th><th>03</th><th>04</th><th>05</th><th>06</th><th>07</th><th>08</th><th>09</th><th>10</th><th>11</th></tr><tr class='clospan_gyh'>" + s + "</tr><tr class='clospan_gyh'>" + e + "</tr><tr class='clospan_gyh'>" + l + "</tr><tr class='clospan_gyh'>" + i + "</tr>", $("#table_lhzs tbody").append(lhhzzsfooter), orshowConten_lhzs("#F_hmzs_bzsz")
        }
    }, hzzs: {
        listData: function (t, a) {
            a = void 0 == a ? "" : a, "" != (t = void 0 != t && "" != t || "" != a ? t : getDateStr(0, !0)) && t != getDateStr(0, !0) || "" != a || ($(".hztodayBtn span").text("今天"), $("#hezhiToday").addClass("hztimesAtc").siblings().removeClass("hztimesAtc")), $.ajax({
                url: config.publicUrl + "ElevenFive/queryElevnFiveSumTrend.do?issue=" + a + "&date=" + t,
                type: "GET",
                data: {lotCode: lotCode},
                beforeSend: function () {
                    $("#table_hzweizs tbody").empty(), $("#table_hzhwei tbody").empty(), $(".rightDate table tbody").empty(), checlick = !1
                },
                success: function (t) {
                    checlick = !0, syxwFunObj.hzzs.createList(t)
                },
                error: function (t) {
                    checlick = !0, config.ifdebug
                }
            })
        }, createList: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), !(hezhizsDataarr = a.result.data[0])) return tools.weikaiji("#table_hzweizs tbody"), tools.weikaiji("#table_hzhwei tbody"), !1;
            listettablearr(hezhizsDataarr.missList, "hzhmfb"), listettablearr(hezhizsDataarr.bodyList), syxwFunObj.hzzs.heweiDate(hezhizsDataarr), syxwFunObj.hzzs.hzhmDate(hezhizsDataarr)
        }, heweiDate: function (t) {
            fgxremove(), $("#table_hzweizs tbody").empty(), $(t.bodyList).each(function (t, a) {
                if (t >= 200 && "10055" == lotCode) return !1;
                var s = a.issue, e = a.code.split(",");
                e = e[0] + " &nbsp;" + e[1] + "&nbsp;" + e[2] + "&nbsp;" + e[3] + "&nbsp;" + e[4];
                var l = a.array, i = "", n = l.slice(l.length - 2);
                i += "<tr><td>" + s + "</td><td style='color:red'>" + e + "</td>", $(n).each(function (t) {
                    i += "<td>" + Math.abs(this) + "</td>"
                }), i += "</tr>", $("#table_hzweizs tbody").append(i)
            });
            var a = "<td colspan='2'>出现总数</td>", s = "<td colspan='2'>平均遗漏</td>", e = "<td colspan='2'>最大遗漏</td>",
                l = "<td colspan='2'>最大连出</td>", i = "<td colspan='2'>当前遗漏</td>";
            $(t.missList).each(function (t) {
                var n = this.array.splice(this.array.length - 2);
                0 == t ? $(n).each(function () {
                    a += "<td><span>" + Math.abs(this) + "</span></td>"
                }) : 1 == t ? $(n).each(function () {
                    s += "<td><span>" + Math.abs(this) + "</span></td>"
                }) : 2 == t ? $(n).each(function () {
                    e += "<td><span>" + Math.abs(this) + "</span></td>"
                }) : 3 == t ? $(n).each(function () {
                    l += "<td><span>" + Math.abs(this) + "</span></td>"
                }) : 4 == t && $(n).each(function () {
                    i += "<td><span>" + Math.abs(this) + "</span></td>"
                })
            }), hzhmfbonefooter = "<tr><th colspan='2'>数据统计</th><th>龙</th><th>虎</th></tr><tr class='clospan_gyh'>" + a + "</tr><tr class='clospan_gyh'>" + s + "</tr><tr class='clospan_gyh'>" + e + "</tr><tr class='clospan_gyh'>" + l + "</tr><tr class='clospan_gyh'>" + i + "</tr>", $("#table_hzweizs tbody").append(hzhmfbonefooter)
        }, hzhmDate: function (t) {
            $("#table_hzhwei tbody tr").remove(), $(".rightDate").find(".zslistUl").remove(), fgxremove(), $("canvas").remove();
            var a = "";
            $(t.bodyList).each(function (t, s) {
                if (10055 == lotCode) e = config.showrows; else var e = 200;
                if (t >= e) return !1;
                var l = "<tr class='zslistUl'>", i = s.issue.toString().slice(4), n = s.array, d = n.slice(0, n.length - 2);
                a += "<tr class='qishutr'><td>" + i + "</td></tr>", $(d).each(function (t) {
                    l += this > 0 ? "<td class='hot'><span name='hotSpan'>" + this + "</span></td>" : "<td><span>" + Math.abs(this) + "</span></td>"
                }), l += "</tr>", $(".rightDate table tbody").append(l)
            }), a += "<tr class='missUl qishutr'><td>数据统计</td></tr><tr class='missUlWhite qishutr'><td>出现总数</td></tr><tr class='missUlWhite qishutr'><td>平均遗漏</td></tr><tr class='missUlWhite qishutr'><td>最大遗漏</td></tr><tr class='missUlWhite qishutr'><td>最大连出</td></tr><tr class='missUlWhite qishutr'><td>当前遗漏</td></tr>", $("#table_hzhwei tbody").append(a);
            $(".rightDate table tbody").append("<tr class='zslistUl missUl'><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td><td>32</td><td>33</td><td>34</td><td>35</td><td>36</td><td>37</td><td>38</td><td>39</td><td>40</td><td>41</td><td>42</td><td>43</td><td>44</td><td>45</td></tr>"), $(t.missList).each(function (t) {
                if (10055 == lotCode) a = config.showrows; else var a = 200;
                if (t >= a) return !1;
                var s = "", e = "", l = "", i = "", n = "", d = "", o = this.array;
                0 == t ? ($(o).each(function () {
                    s += "<td><span>" + Math.abs(this) + "</span></td>"
                }), d = "<tr class='zslistUl missUlWhite'>" + s + "</tr>") : 1 == t ? ($(o).each(function () {
                    e += "<td><span>" + Math.abs(this) + "</span></td>"
                }), d = "<tr class='zslistUl missUlWhite'>" + e + "</tr>") : 2 == t ? ($(o).each(function () {
                    l += "<td><span>" + Math.abs(this) + "</span></td>"
                }), d = "<tr class='zslistUl missUlWhite'>" + l + "</tr>") : 3 == t ? ($(o).each(function () {
                    i += "<td><span>" + Math.abs(this) + "</span></td>"
                }), d = "<tr class='zslistUl missUlWhite'>" + i + "</tr>") : 4 == t && ($(o).each(function () {
                    n += "<td><span>" + Math.abs(this) + "</span></td>"
                }), d = "<tr class='zslistUl missUlWhite'>" + n + "</tr>"), $(".rightDate table tbody").append(d)
            }), orshowConten_hzzs()
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
        l = (l = $("#" + l + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_syxw(l, a, ""), tools.revertHmfb()
    }
});
var condition_wzzs = [{
        data: [{name: "遗漏", value: "yilo"}, {name: "拆线", value: "caix"}, {
            name: "遗漏分层",
            value: "fancong"
        }, {name: "分割线", value: "fgx"}]
    }], condition_wz_qs = [{data: [{value: "近30期", id: "30"}, {value: "近60期", id: "60"}, {value: "近90期", id: "90"}]}],
    condition_wz_mc = [{
        data: [{value: "第一球", id: "0"}, {value: "第二球", id: "1"}, {value: "第三球", id: "2"}, {
            value: "第四球",
            id: "3"
        }, {value: "第五球", id: "4"}]
    }], condition_hmzs_mc = [{data: [{value: "第一球", id: "1"}, {value: "第五球", id: "2"}]}],
    condition_tj = [{data: [{value: "大小", id: "daxiao"}, {value: "单双", id: "danshaung"}]}], condition_Arr = [{
        data: [{name: "第一球", value: "t0"}, {name: "第二球", value: "t1"}, {
            name: "第三球",
            value: "t2"
        }, {name: "第四球", value: "t3"}, {name: "第五球", value: "t4"}, {name: "总和", value: "t5"}, {name: "和尾", value: "t6"}]
    }], initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".bzsz", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), wz_mc_val = [0], initTiaojian = new MobileSelect({
        trigger: ".wz_mc",
        title: "选择名次",
        wheels: condition_wz_mc,
        position: wz_mc_val,
        callback: function (t, a, s) {
            wz_mc_val[0] = 1 * a[0].id, syxwFunObj.jbzs.createHtmlList(jbzsarr, wz_mc_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : wz_mc_val, s = 0; s < wz_mc_val.length; s++) t.locatePosition(s, a[s])
        }
    }), wz_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".wz_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: wz_qs_val,
        callback: function (t, a, s) {
            wz_qs_val[0] = 1 * a[0].id, syxwFunObj.jbzs.getlist("", wz_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : wz_qs_val, s = 0; s < wz_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".tiaojian_singtai", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten_siantai()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), dw_mc_val = [0], initTiaojian = new MobileSelect({
        trigger: ".weai_singtai",
        wheels: condition_wz_mc,
        position: dw_mc_val,
        callback: function (t, a, s) {
            dw_mc_val[0] = 1 * a[0].id;
            var e = $(".wezizs .checkday .checkspan");
            if (0 == e.length) syxwFunObj.dwzs.getlist("", ""); else if (e.hasClass("screen")) e.hasClass("screen") && "更多" != e.text() && syxwFunObj.dwzs.getlist("", e.text().replace(/[\u4e00-\u9fa5]/g, "")); else {
                var l = e[0].classList[0], i = getDateStr(fastClickDate[l], !0);
                syxwFunObj.dwzs.getlist(i, "")
            }
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dw_mc_val, s = 0; s < dw_mc_val.length; s++) t.locatePosition(s, a[s])
        }
    }), dw_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".dwzs_gd",
        wheels: condition_wz_qs,
        position: dw_qs_val,
        callback: function (t, a, s) {
            dw_qs_val[0] = 1 * a[0].id, syxwFunObj.dwzs.getlist("", dw_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dw_qs_val, s = 0; s < dw_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["t0", "t1", "t2", "t3", "t4", "t5", "t6"]
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
            orshowConten_lhzs()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), gyh_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".gyh_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: gyh_qs_val,
        callback: function (t, a, s) {
            gyh_qs_val[0] = 1 * a[0].id, syxwFunObj.lhzs.listData("", gyh_qs_val[0])
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
        }, trigger: ".hmzs_bzsz", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten_lhzs("#F_hmzs_bzsz")
        }, onShow: function () {
            this.initSelectedState()
        }
    }), hm_mc_val = [0], initTiaojian = new MobileSelect({
        trigger: ".hmzs_wz_mc",
        title: "选择名次",
        wheels: condition_hmzs_mc,
        position: hm_mc_val,
        callback: function (t, a, s) {
            hm_mc_val[0] = 1 * a[0].id, syxwFunObj.lhzs.qiuDate(lhzsDataarr, hm_mc_val[0]), $("#table_lhzs tr:first th:nth-child(2)").text(a[0].value)
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : hm_mc_val, s = 0; s < hm_mc_val.length; s++) t.locatePosition(s, a[s])
        }
    }), wz_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".hmzs_wz_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: wz_qs_val,
        callback: function (t, a, s) {
            wz_qs_val[0] = 1 * a[0].id, syxwFunObj.lhzs.listData("", wz_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : wz_qs_val, s = 0; s < wz_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), hzhw_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".hzhw_wz_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: hzhw_qs_val,
        callback: function (t, a, s) {
            hzhw_qs_val[0] = 1 * a[0].id, syxwFunObj.hzzs.listData("", hzhw_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : hzhw_qs_val, s = 0; s < hzhw_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), hzhmfb_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".hzhmfb_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: hzhmfb_qs_val,
        callback: function (t, a, s) {
            hzhmfb_qs_val[0] = 1 * a[0].id, syxwFunObj.hzzs.listData("", hzhmfb_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : hzhmfb_qs_val, s = 0; s < hzhmfb_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".hzhmfb_bz", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten_hzzs()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), condition_dxms_mc = [{
        data: [{value: "第一球", id: "ball_1"}, {value: "第二球", id: "ball_2"}, {
            value: "第三球",
            id: "ball_3"
        }, {value: "第四球", id: "ball_4"}, {value: "第五球", id: "ball_5"}, {value: "总和", id: "ball_6"}, {
            value: "和尾",
            id: "ball_7"
        }]
    }], condition_zh_lz = [{
        data: [{name: "单双", value: "dansuShow"}, {name: "大小", value: "daxiaoShow"}, {
            name: "龙虎",
            value: "longhuShow"
        }]
    }], condition_zh_mc = [{
        data: [{name: "第一球", value: "ball_1"}, {name: "第二球", value: "ball_2"}, {
            name: "第三球",
            value: "ball_3"
        }, {name: "第四球", value: "ball_4"}, {name: "第五球", value: "ball_5"}, {name: "总和", value: "ball_6"}, {
            name: "和尾",
            value: "ball_7"
        }]
    }], condition_lmms_lz = [{
        data: [{value: "大小", id: "daxiaoShow"}, {value: "单双", id: "dansuShow"}, {
            value: "龙虎",
            id: "longhuShow"
        }]
    }], lzcheckObj = {
        zhms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7"],
            select_arr2: ["dansuShow", "daxiaoShow", "longhuShow"]
        },
        dxms: {
            checkIndex: [0],
            checkVal: ["ball_1"],
            checkVal_cn: "第一球",
            select_arr2: ["dansuShow", "daxiaoShow", "longhuShow"]
        },
        lmms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7"],
            checkIndex: [0],
            checkVal: ["daxiaoShow"],
            checkVal_cn: "大小"
        }
    };
$(".luzufx  .Pattern").on("click", "span", function () {
    var t = $(this);
    $("#F_zhfx_meci").parents(".mobileSelect").remove(), $("#F_zhfx_model").parents(".mobileSelect").remove(), t.hasClass("zonghu") ? lzfxzhms() : t.hasClass("danxms") ? lzfxdxms() : lzfxlmms()
}), $(".Pattern").on("click", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $("." + $(this).attr("target") + "_mod").addClass("_shows").siblings().removeClass("_shows")
});