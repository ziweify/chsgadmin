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
    $("#videoiframe").attr('src',config.videourl+"view/video/GDklsf/index.html?"+lotCode);
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        var t = 880 * $(".animate").width() / 1310;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            //iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
        })
    })
}

function runFilterRender() {
    var t = $(".haomafb .dansdxbtn .lichecked").text();
    t ? runSelectedHm(t, !1) : runNumFilter()
}

function throttle(t, a, s) {
    var e, l = +new Date;
    return function () {
        var n = +new Date, i = this, o = arguments;
        clearTimeout(e), n - l >= s ? (t.apply(i, o), l = n) : e = setTimeout(function () {
            t.apply(i, o)
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
        }), s += "</ul></div>", s += '<div class="longhuli displaynone"><ul  style="color:#666" class="ssclilistxt listli lhlist listlitxt">';
        i = "style='color:";
        if (!(e.length <= 1)) {
            var l = tools.typeOf("dxh", this.sumBigSmall), n = "0" == this.sumSingleDouble ? "单" : "双";
            "0" == this.dragonTiger ? "龙" : "1" == this.dragonTiger ? "虎" : "2" == this.dragonTiger && "和"
        }
        s += "<li  style='color:#f12d35'>" + this.sumNum + "</li>", s += "<li style='color:#666'>" + l + "</li>", s += "<li style='color:#666'>" + n + "</li>";
        var i = "style='color:", o = "0" == this.lastBigSmall ? "尾大" : "尾小", d = "尾大" == o ? i + "#f12d35'" : "",
            r = "0" == this.firstDragonTiger ? "龙" : "虎", c = "龙" == r ? i + "#f12d35'" : "",
            h = "0" == this.secondDragonTiger ? "龙" : "虎", u = "龙" == h ? i + "#f12d35'" : "",
            p = "0" == this.thirdDragonTiger ? "龙" : "虎", f = "龙" == p ? i + "#f12d35'" : "",
            b = "0" == this.fourthDragonTiger ? "龙" : "虎";
        s += "<li " + d + ">" + o + "</li>", s += "<li " + c + ">" + r + "</li>", s += "<li " + u + ">" + h + "</li>", s += "<li " + f + ">" + p + "</li>", s += "<li " + ("龙" == b ? i + "#f12d35'" : "") + ">" + b + "</li>", s += "</ul>", s += "</div>", s += "</div>", s += "</div>", s += "</div>"
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
        n = $(".dansdxbtn li:nth-child(4)").hasClass("lichecked");
    $("#haomafblist li").each(function () {
        var i = $(this).text(), o = i % 2 == 0, d = i >= 10;
        -1 != t.indexOf("单") ? a ? l ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? d && !o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? d || o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : -1 != t.indexOf("双") ? a ? l ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? d && o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? !d && o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("大") ? a ? s ? o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? d && !o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : e ? d && o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("小") && (a ? s ? o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? d || o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? !d && o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
    })
}

function showExplain_smwf() {
    $(".explian_shows").css({height: $("body").height(), top: "0"})
}

function hideExplain_smwf() {
    $(".explian_shows").css({height: "0", top: "-20rem"})
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

function zonghe_listitem() {
    $(".lz_title").hide();
    for (var t = $("#F_zhongfabai_lz .check_tj"), a = 0; a < t.length; a++) {
        var s = $(t[a]).attr("data-value");
        $("." + s).each(function (t, a) {
            $(a).show()
        })
    }
}

function checkhmqhlzHm() {
    $(".lz_title").hide();
    var t = $("#haomalzmfen").find(".kuaisanct");
    $(t).each(function (t, a) {
        var s = "#" + $(a).attr("value");
        $(s).show()
    })
}

function fancongshow() {
    for (var t = $("#table_jiben tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 3; e < s; e++) for (var l = 0; l <= a; l++) {
        var n = t.eq(l).children("td").eq(e);
        if (n.hasClass("hot")) break;
        n.addClass("fancongcls")
    }
}

function fancongshowpl() {
    for (var t = $("#table_jibentop tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 0; e < s; e++) for (var l = 0; l <= a; l++) {
        var n = t.eq(l).children("td").eq(e);
        if (n.hasClass("hot")) break;
        n.addClass("fancongcls")
    }
}

function xiantiao_list() {
    setTimeout(function () {
        if (document.body.offsetWidth > 320) t = 1.5; else var t = 2;
        var a = $("#table_jiben tbody tr td:first").height() * t, s = $("canvas");
        $(s).each(function (t) {
            $(this).css("top", 1 * $(this).css("top").toString().replace(/px/gi, "") - a + "px")
        })
    })
}

function orshowConten() {
    if ($("#F_yixuan li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.hedahxh("table_jiben"), xiantiao_list()
    }, 500) : $(".jibenzsfen canvas").hide(), $("#F_yixuan li[data-value='fancong']").hasClass("check_tj") ? $(".zongfen_noe").hasClass("checkspan") ? fancongshow() : fancongshowpl() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_yixuan li[data-value='yilo']").hasClass("check_tj") ? ($("tr td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide(), $(".missUl td").show(), $("#table_jibentop tbody tr:not([class]) span").show()), $("#F_yixuan li[data-value='fgx']").hasClass("check_tj")) {
        if ($(".line_wzzs").remove(), $(".zongfen_noe").hasClass("checkspan")) t = $("#table_jiben tbody tr"); else {
            for (var t = $("#table_jibennot tbody tr"), a = 4; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>");
            t = $("#table_jibentop tbody tr")
        }
        for (a = 4; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>")
    } else $(".line_wzzs").remove()
}

function heshu_list() {
    $(".lz_title").hide();
    for (var t = $("#F_heshudslzpl_lz .check_tj"), a = 0; a < t.length; a++) {
        var s = $(t[a]).attr("data-value");
        $("." + s).each(function (t, a) {
            $(a).show()
        })
    }
}

function weishulz_list() {
    $(".lz_title").hide();
    for (var t = $("#F_weishuluzhu_lz .check_tj"), a = 0; a < t.length; a++) {
        var s = $(t[a]).attr("data-value");
        $("." + s).each(function (t, a) {
            $(a).show()
        })
    }
}

function longhu_list() {
    $(".lz_title").hide();
    for (var t = $("#F_longhu_lz .check_tj"), a = 0; a < t.length; a++) {
        var s = $(t[a]).attr("data-value");
        $("." + s).each(function (t, a) {
            $(a).show()
        })
    }
}

function dansdxlz_list() {
    $(".lz_title").hide();
    for (var t = $("#F_dansdxlz_lz .check_tj"), a = 0; a < t.length; a++) {
        var s = $(t[a]).attr("data-value"), e = dxdxlz_val[0] || "daxiaoShow";
        $("." + e).each(function (t, a) {
            $(a).hasClass(s) && $(a).show()
        })
    }
}

function zongkweik_list() {
    $(".marginTop>li").each(function (t, a) {
        $(a).hasClass("check_tj") ? $(".item_" + $(a).attr("data-text")).show() : $(".item_" + $(a).attr("data-text")).hide()
    }), $(".show_zonkai").hasClass("check_tj") ? $(".zongkai_item").show() : $(".zongkai_item").hide(), $(".show_weikai").hasClass("check_tj") ? $(".liankai_item").show() : $(".liankai_item").hide()
}

function dongnxb_list() {
    $(".lz_pl").hide();
    for (var t = $("#F_dongnanxbpl_lz .check_tj"), a = 0; a < t.length; a++) {
        var s = $(t[a]).attr("data-value");
        $("." + s).each(function (t, a) {
            $(a).show()
        })
    }
}

function fancongshow_daxizs() {
    if ("none" != $(".table_dxzs").css("display")) for (var t = (e = (e = $("#table_daxiao tbody tr")).slice(0, e.length)).length, a = e.filter(":first").children("td").size(), s = 0; s < a; s++) for (l = 0; l <= t && !(n = e.eq(l).children("td").eq(s)).hasClass("hot"); l++) n.addClass("fancongcls"); else for (var e = $("#daxiaob_table tbody tr"), t = (e = e.slice(0, e.length)).length, a = e.filter(":first").children("td").size(), s = 2; s < a; s++) for (var l = 0; l <= t; l++) {
        var n = e.eq(l).children("td").eq(s);
        if (n.hasClass("hot")) break;
        n.addClass("fancongcls")
    }
}

function orshowConten_daxizs() {
    if ($("#F_tiaojian_daxiaozs li[data-value='fancong']").hasClass("check_tj") ? fancongshow_daxizs() : $(".fancongcls").removeClass("fancongcls").addClass("showspan"), $("#F_tiaojian_daxiaozs li[data-value='yilo']").hasClass("check_tj") ? ("none" != $(".table_dxzs").css("display") ? $("#table_daxiao tbody tr td").find("span").show() : $("#daxiaob_table tbody tr td").find("span").show(), $("#table_daxiao tbody .fancongcls span").show(), $(".showspan span").show()) : ($("#table_daxiao tbody .fancongcls span").hide(), "none" != $(".table_dxzs").css("display") ? $("#table_daxiao tbody tr td:not([class])").find("span").hide() : ($("#daxiaob_table tbody tr td:not([class])").find("span").hide(), $("#daxiaob_table tbody .fancongcls span").hide()), $(".showspan span").hide()), $("#F_tiaojian_daxiaozs li[data-value='fgx']").hasClass("check_tj")) {
        if ("none" != $(".table_dxzs").css("display")) {
            $(".line_wzzs").remove();
            for (var t = $(".lefttable table tbody tr"), a = 2; a < t.length; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>");
            for (var s = $(".righttable table tbody tr"), a = 2; a < s.length; a += 5) $(s[a]).after("<tr class='line_wzzs'><td></td></tr>")
        } else if ("none" != $(".table_dxb").css("display")) {
            $(".line_wzzs").remove();
            for (var t = $("#daxiaob_table tbody tr"), a = 2; a < t.length; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>")
        }
    } else $(".line_wzzs").remove();
    $("#F_tiaojian_daxiaozs li[data-value='caix']").hasClass("check_tj") ? ($("canvas").remove(), "none" != $(".table_dxzs").css("display") && setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.daxiaozs("table_daxiao"), adjustment_letab()
    }, 500)) : $("canvas").remove(), $(".loteyPage").css("height", 0).removeClass("gotop"), $(".or_").removeClass("or_")
}

function adjustment_letab() {
    setTimeout(function () {
        var t = $(".table_dxzs .lefttable").width();
        $(".righttable canvas").each(function () {
            var a = 1 * $(this).css("left").replace("px", "");
            $(this).css({left: a - t + "px"})
        })
    }, 10)
}

function adjustment_rigtab() {
    setTimeout(function () {
        var t = 1.7 * $(".table_dxb tbody tr:first-child").height();
        $(".table_dxb canvas").each(function () {
            var a = 1 * $(this).css("top").replace("px", "");
            $(this).css({top: a + t + "px"})
        })
    }, 10)
}

function fancongshow_danszs() {
    if ("none" != $(".table_qyzs").css("display")) for (var t = (e = (e = $("#table_danshuang tbody tr")).slice(0, e.length)).length, a = e.filter(":first").children("td").size(), s = 0; s < a; s++) for (l = 0; l <= t && !(n = e.eq(l).children("td").eq(s)).hasClass("hot"); l++) n.addClass("fancongcls"); else for (var e = $("#danshuang_table tbody tr"), t = (e = e.slice(0, e.length)).length, a = e.filter(":first").children("td").size(), s = 2; s < a; s++) for (var l = 0; l <= t; l++) {
        var n = e.eq(l).children("td").eq(s);
        if (n.hasClass("hot")) break;
        n.addClass("fancongcls")
    }
}

function orshow_danszs() {
    if ($("#F_tiaojian_danshuangzs li[data-value='fancong']").hasClass("check_tj") ? fancongshow_danszs() : $(".fancongcls").removeClass("fancongcls").addClass("showspan"), $("#F_tiaojian_danshuangzs li[data-value='yilo']").hasClass("check_tj") ? ("none" != $(".table_qyzs").css("display") ? $("#table_danshuang tbody tr td").find("span").show() : $("#danshuang_table tbody tr td").find("span").show(), $("#table_danshuang tbody .fancongcls span").show(), $(".showspan span").show()) : ($("#table_danshuang tbody .fancongcls span").hide(), "none" != $(".table_qyzs").css("display") ? $("#table_danshuang tbody tr td:not([class])").find("span").hide() : ($("#danshuang_table tbody tr td:not([class])").find("span").hide(), $("#danshuang_table tbody .fancongcls span").hide()), $(".showspan span").hide()), $("#F_tiaojian_danshuangzs li[data-value='fgx']").hasClass("check_tj")) {
        if ("none" != $(".table_qyzs").css("display")) {
            $(".line_wzzs").remove();
            for (var t = $(".lefttabledans table tbody tr"), a = 2; a < t.length; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>");
            for (var s = $(".righttablepld table tbody tr"), a = 2; a < s.length; a += 5) $(s[a]).after("<tr class='line_wzzs'><td></td></tr>")
        } else if ("none" != $(".table_qyb").css("display")) {
            $(".line_wzzs").remove();
            for (var t = $("#danshuang_table tbody tr"), a = 2; a < t.length; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>")
        }
    } else $(".line_wzzs").remove();
    $("#F_tiaojian_danshuangzs li[data-value='caix']").hasClass("check_tj") ? ($("canvas").remove(), "none" != $(".table_qyzs").css("display") && setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.daxiaozs("table_danshuang"), danshuangzs_pkd()
    }, 500)) : $("canvas").remove(), $(".loteyPage").css("height", 0).removeClass("gotop"), $(".or_").removeClass("or_")
}

function danshuangzs_pkd() {
    setTimeout(function () {
        var t = $(".table_qyzs .lefttabledans").width();
        $(".righttablepld canvas").each(function () {
            var a = 1 * $(this).css("left").replace("px", "");
            $(this).css({left: a - t + "px"})
        })
    }, 10)
}

function danshuangzs_qiyub() {
    setTimeout(function () {
        var t = 3.2 * $(".table_qyb tbody tr:first-child").height();
        $(".table_qyb canvas").each(function () {
            var a = 1 * $(this).css("top").replace("px", "");
            $(this).css({top: a + t + "px"})
        })
    }, 10)
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

function listettablearr(t, a) {
    if (!t) return !1;
    var s = config.showrows;
    if ($("#jibenzsfen").hasClass("checkedbl") ? s = config.klsfrows_thre : ($("#daxiaozsfen").hasClass("checkedbl") || $("#danshuangzsfen").hasClass("checkedbl")) && (s = config.klsfrows), t.length <= s && "hzhmfb" != a ? $(".lomorediv").hide() : ($(".lomorediv").show().attr("data-text", 0), $(".nextlo").show()), void 0 == a) {
        klsftabledata = [];
        for (var e = 0, l = Math.ceil(t.length / s); e < l; e++) (n = []).push(t.slice(e * s, (e + 1) * s)), klsftabledata.push(n)
    } else if ("lhhzzs" == a) {
        klsftabledata_hz = [];
        for (var e = 0, l = Math.ceil(t.length / s); e < l; e++) (n = []).push(t.slice(e * s, (e + 1) * s)), klsftabledata_hz.push(n)
    } else if ("hzhmfb" == a) {
        klsftabledata_fb = [];
        for (var e = 0, l = Math.ceil(t.length / s); e < l; e++) {
            var n = [];
            n.push(t.slice(e * s, (e + 1) * s)), klsftabledata_fb.push(n)
        }
    }
    $(".prevlo").hide().parent().attr("data-text", 0)
}

function eachconten_jbzshtml(t) {
    var a = "<tr>";
    $(t).each(function (t) {
        var s = this.preDrawCode, e = this.missing.slice(20, 28);
        a += " <td>" + this.preDrawIssue + "</td><td class='tabred'><span>" + s.join(" ") + "</span></td>";
        for (var l = 0; l < e.length; l++) 2 * e[l] >= 0 ? l <= 0 ? a += "<td class='tabred'><span name='hotSpan' >" + e[l] + "</span></td>" : l <= 1 ? a += "<td class='hot'><span name='hotSpan'>大</span></td>" : l <= 2 ? a += "<td class='hot'><span name='hotSpan'>小</span></td>" : l <= 3 ? a += "<td class='hot'><span name='hotSpan'>和</span></td>" : l <= 4 ? a += "<td class='hot zese'><span name='hotSpan'>单</span></td>" : l <= 5 ? a += "<td class='hot zese'><span name='hotSpan'>双</span></td>" : l <= 6 ? a += "<td class='hot fense'><span name='hotSpan'>大</span></td>" : l <= 7 && (a += "<td class='hot fense'><span name='hotSpan'>小</span></td>") : a += "<td><span>" + Math.abs(e[l]) + "</span></td>";
        a += "</tr>"
    }), $("#jibenzsfenBox #table_jiben tbody").html(a)
}

function eachcontentdaxiazs(t) {
    var a = "", s = "";
    $(t).each(function (t) {
        var e = this.missing.slice(0, 16);
        s += t % 2 == 0 ? "<tr>" : "<tr class='dxcolor'>";
        for (var l = 0; l < e.length; l++) {
            var n = "";
            n = l <= 1 ? "hot_org" : l <= 3 ? "hot_blue" : l <= 5 ? "hot_green" : l <= 7 ? "hot_org" : l <= 9 ? "hot_blue" : l <= 11 ? "hot_green" : l <= 13 ? "hot_org" : l <= 15 ? "hot_blue" : "hot_org", (l + 1) % 2 != 0 && 1 * e[l] > 0 ? s += "<td class='hot'><span name='hotSpan' class='" + n + "'>大</span></td>" : (l + 1) % 2 == 0 && 1 * e[l] > 0 ? s += "<td class='hot'><span name='hotSpan' class='" + n + "'>小</span></td>" : s += "<td><span>" + Math.abs(e[l]) + "</span></td>"
        }
        s += "</tr>";
        var i = this.preDrawIssue.toString();
        a += t % 2 == 0 ? "<tr><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>" : "<tr class='dxcolor'><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>"
    }), $("#table_daxiao tbody").html(s), $(".daxiaozsfen .lefttable table tbody").html(a)
}

function eachcontentdanxuzs(t) {
    var a = "", s = "";
    $(t).each(function (t) {
        var e = this.missing.slice(0, 16);
        s += t % 2 == 0 ? "<tr>" : "<tr class='bgcolor'>";
        for (var l = 0; l < e.length; l++) {
            var n = "";
            n = l <= 1 ? "hot_org" : l <= 3 ? "hot_blue" : l <= 5 ? "hot_green" : l <= 7 ? "hot_org" : l <= 9 ? "hot_blue" : l <= 11 ? "hot_green" : l <= 13 ? "hot_org" : l <= 15 ? "hot_blue" : "hot_org", (l + 1) % 2 != 0 && 1 * e[l] > 0 ? s += "<td class='hot'><span name='hotSpan' class='" + n + "'>奇</span></td>" : (l + 1) % 2 == 0 && 1 * e[l] > 0 ? s += "<td class='hot'><span name='hotSpan' class='" + n + "'>偶</span></td>" : s += "<td><span>" + Math.abs(e[l]) + "</span></td>"
        }
        s += "</tr>";
        var i = this.preDrawIssue.toString();
        a += t % 2 == 0 ? "<tr><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>" : "<tr class='bgcolor'><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>"
    }), $(".danshuangzsfen .lefttabledans table tbody").html(a), $(".danshuangzsfen .righttablepld table tbody").html(s)
}

function checkDateFun(t, a) {
    a = void 0 == a ? "" : a;
    var s = $(".title_se_box .se_check").attr("target");
    s = (s = $("#" + s + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_shifen(s, t, a)
}

function lzfxdxms() {
    $(".checklz_lz_mc").text(lzcheckObj.dxms.checkVal_cn), $(".checkclick_lz").text("筛选路珠");
    new MobileSelect({
        trigger: ".checklz_lz_mc",
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
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.dxms.select_arr2
        }, trigger: ".checkclick_lz", title: "选择路珠", wheels: condition_zh_lz, callback: function (t, a, s) {
            lzcheckObj.dxms.select_arr2 = a, showlz_listitem(lzcheckObj.dxms.checkVal, lzcheckObj.dxms.select_arr2)
        }, onShow: function () {
            this.initSelectedState()
        }
    });
    showlz_listitem(lzcheckObj.dxms.checkVal, lzcheckObj.dxms.select_arr2)
}

function lzfxlmms() {
    $(".checklz_lz_mc").text("筛选名次"), $(".checkclick_lz").text(lzcheckObj.lmms.checkVal_cn);
    new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.lmms.select_arr1
        }, trigger: ".checklz_lz_mc", title: "选择名次", wheels: condition_zh_mc, callback: function (t, a, s) {
            lzcheckObj.lmms.select_arr1 = a, showlz_listitem(lzcheckObj.lmms.select_arr1, lzcheckObj.lmms.checkVal)
        }, onShow: function () {
            this.initSelectedState()
        }
    }), new MobileSelect({
        trigger: ".checkclick_lz",
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
    $(".checklz_lz_mc").text("筛选名次"), $(".checkclick_lz").text("筛选路珠");
    new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.zhms.select_arr1
        }, trigger: ".checklz_lz_mc", title: "选择名次", wheels: condition_zh_mc, callback: function (t, a, s) {
            lzcheckObj.zhms.select_arr1 = a, showlz_listitem(lzcheckObj.zhms.select_arr1, lzcheckObj.zhms.select_arr2)
        }, onShow: function () {
            this.initSelectedState()
        }
    }), new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: lzcheckObj.zhms.select_arr2
        }, trigger: ".checkclick_lz", title: "选择路珠", wheels: condition_zh_lz, callback: function (t, a, s) {
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
    $("#startVideo").on("touchstart", function () {
        //var t = tools.gdklsfDataStr();
        startVideo();
        //$("iframe")[0].contentWindow.fun.fillHtml(t.thisIssue, t.nextIssue, t.nextTime, t.countdown, t.arr), startVideo(), $("iframe")[0].contentWindow.ifopen = !0
    }), document.addEventListener("click", function () {
        //$("iframe")[0].contentWindow.ifopen && ($("iframe")[0].contentWindow.kaisound.play(), $("iframe")[0].contentWindow.bgsound.play(), $("iframe")[0].contentWindow.kaisound.pause())
    }, !1);
    $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-200%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"});
            $("#videoiframe").attr('src',"");
        });
        //$("iframe")[0].contentWindow.bgsound.pause(), $("iframe")[0].contentWindow.kaisound.pause(), $("iframe")[0].contentWindow.fun.clearTime(), $("iframe")[0].contentWindow.ifopen = !1
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
var ifishad = !1, boxId = "#headerData", method = {};
method.loadOther = function (t) {
    if ("" != t || tools.ifOnDay()) {
        setTimeout(function () {
            method.todayData(t)
        }, 1e3), setTimeout(function () {
            method.longData(t)
        }, 2e3);
        var a = $(".headTitle .checkedbl").attr("id");
        if ("" != t) {
            var s = t.split("-");
            t = s[0] + "-" + 1 * s[1] + "-" + (1 * s[2] < 10 ? "0" + 1 * s[2] : 1 * s[2])
        }
        tools.classGetDate_shifen(a, t, "")
    }
}, method.indexLoad = function (t) {
    var a = $(t).find(".nextIssue").val(), t = "#" + $(t).attr("id");
    headMethod.loadHeadData(a, t)
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "klsf/getHistoryLotteryInfo.do?date=" + t,
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
        url: config.publicUrl + "klsf/getKlsfDoubleCount.do?date=" + t,
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
        url: config.publicUrl + "klsf/getKlsfLongDragonCount.do?date=" + t,
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
    tools.bigOrSmall(t, a, "11")
}, method.selectedHm = function (t) {
    if ($(t).parents(".dansdxbtn").length > 0) {
        var a = $(t).hasClass("lichecked");
        $(".numbtn").find("li").removeClass("lichecked"), $(t).toggleClass("lichecked");
        var s = $(t).text(), e = [null, "双", "单", "小", "大"].indexOf(s);
        $(".dansdxbtn li:nth-child(" + e + ")").removeClass("lichecked"), runSelectedHm(s, a)
    } else $(".dansdxbtn li").removeClass("lichecked"), $(t).toggleClass("lichecked"), $(".numbtn .lichecked").length > 0 ? runNumFilter() : $("#haomafblist li").removeClass("selectedOpacity")
}, method.loadTodayData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data;
        var a = [{data: [data.firstSingleCount, data.firstDoubleCount, data.firstBigCount, data.firstSmallCount, data.firstDragonCount, data.firstTigerCount]}, {data: [data.secondSingleCount, data.secondDoubleCount, data.secondBigCount, data.secondSmallCount, data.secondDragonCount, data.secondTigerCount]}, {data: [data.thirdSingleCount, data.thirdDoubleCount, data.thirdBigCount, data.thirdSmallCount, data.thirdDragonCount, data.thirdTigerCount]}, {data: [data.fourthSingleCount, data.fourthDoubleCount, data.fourthBigCount, data.fourthSmallCount, data.fourthDragonCount, data.fourthTigerCount]}, {data: [data.fifthSingleCount, data.fifthDoubleCount, data.fifthBigCount, data.fifthSmallCount]}, {data: [data.sixthSingleCount, data.sixthDoubleCount, data.sixthBigCount, data.sixthSmallCount]}, {data: [data.seventhSingleCount, data.seventhDoubleCount, data.seventhBigCount, data.seventhSmallCount]}, {data: [data.eighthSingleCount, data.eighthDoubleCount, data.eighthBigCount, data.eighthSmallCount]}, {data: [data.sumSingleCount, data.sumDoubleCount, data.sumBigCount, data.sumSmallCount]}];
        $("#liangmianbox").empty(), $(a).each(function (t) {
            var a = "";
            $(this.data).each(function () {
                a += "<td>" + this + "</td>"
            });
            var s = tools.typeOf("qiuklsf", t + 1), e = "";
            0 == t ? e = "head1" : 1 == t && (e = "head2");
            var l = "";
            t >= 4 || (l = "<td>龙</td><td>虎</td>");
            var n = '<div class="lianmlist"><div  class="head ' + e + '">' + s + '</div><table cellpadding="0" cellspacing="0" border="0"><tr class="tr1"><td>单</td><td>双</td><td>大</td><td>小</td>' + l + '</tr><tr class="tr2">' + a + "</tr></table></div>";
            $("#liangmianbox").append(n)
        })
    }
}, method.loadLongData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data, config.ifdebug, $("#longDrag").empty("");
        for (var a = 0, s = data.length; a < s; a++) {
            var e = tools.typeOf("qiuklsf", data[a].rank), l = tools.typeOf("stated", data[a].state),
                n = data[a].count >= 5 ? "<span style='color:#f11821'>" + data[a].count + "</span>" : "<span>" + data[a].count + "</span>",
                i = "<li><span>" + e + "</span>：<span>" + l + "</span>" + n + "期</li>";
            11 != data[a].rank && 1 != data[a].rank && 2 != data[a].rank || (i = "<li><span>" + e + "</span>：<span>" + l + "</span>" + n + "期</li>"), $("#longDrag").append(i)
        }
    }
}, $("#kuailsfBtn_plok").on("touchstart", function () {
    showExplain_smwf()
}), $(".closesm").on("click", function () {
    hideExplain_smwf()
}), $("#haomalzmfen").find("li").on("click", function () {
    $(this).toggleClass("kuaisanct"), checkhmqhlzHm()
}), $(".haomalzfen #quanxuan").on("click", ".checkAll,.noAll", function () {
    "checkAll" == $(this).attr("class") ? $(".lineboxpl #haomalzmfen li").addClass("kuaisanct") : $(".lineboxpl #haomalzmfen li").removeClass("kuaisanct"), checkhmqhlzHm()
}), $(".navTab").on("touchstart", "span", function () {
    $(this).find("i").hasClass("iActClass") || $(this).find("i").addClass("iActClass").parent("span").siblings().find("i").removeClass(), "personCheck" == $(this).attr("id") ? ($("#zhkanList").css("display", "none"), $("#personList").css("display", "block")) : ($("#zhkanList").css("display", "block"), $("#personList").css("display", "none"))
}), $("#minciBox").find("ul").find("li").on("click", function () {
    $(this).hasClass("minciLiAct") || $(this).addClass("minciLiAct").siblings().removeClass();
    var t = $(this).find("i").text();
    $("#tbody" + t).hasClass("displaynone") && $("#tbody" + t).removeClass().siblings("tbody").addClass("displaynone")
}), $("#dsdxBox").find("ul").find("li").on("click", function () {
    $(this).hasClass("dsdxActcolor") || $(this).addClass("dsdxActcolor").siblings().removeClass();
    var t = $(this).find("i").text();
    $("#gtbody" + t).hasClass("displaynone") && $("#gtbody" + t).removeClass().siblings("tbody").addClass("displaynone")
}), $(".jibenpl").on("touchstart", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $(this).hasClass("zongfen_noe") ? ($("canvas").remove(), orshowConten(), $("#jibenzsfenBox").css("display", "block"), $("#jibenzsfentop").css("display", "none")) : ($("canvas").remove(), orshowConten(), $("#jibenzsfenBox").css("display", "none"), $("#jibenzsfentop").css("display", "block"))
}), $(".checkClick").on("click", function () {
    $("#jirihmtj_lz").addClass("gotop"), $(".gotop").css("height", $("body").height() + "px")
}), $("#jirihmtj_lz").on("touchstart", ".checkAll,.noAll", function () {
    "checkAll" == $(this).attr("class") ? $("#jirihmtj_lz li").addClass("check_tj") : $("#jirihmtj_lz li").removeClass("check_tj")
}), $("#jirihmtj_lz .Page_content").on("click", "ul>li", function () {
    $(this).toggleClass("check_tj or_")
}), $("#jirihmtj_lz").on("click", ".sure", function () {
    $(".gotop").css("height", "0rem"), $(".loteyPage").removeClass("gotop"), $(".or_").removeClass("or_"), zongkweik_list()
}), $(".daxiaozsfen").on("click", ".Pattern>span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), showtablename = $(this).attr("data-text"), $("." + showtablename).show().siblings().hide(), orshowConten_daxizs()
}), $("#tiaojian_daxiaozs").on("click", ".btngrulp>.sure", function () {
    orshowConten_daxizs()
}), $(".lookshjtj").on("touchstart", function (t) {
    t.preventDefault(), $("html,body").animate({scrollTop: $("#footerDiv").offset().top}, 500)
}), $(".danshuangzsfen").on("click", ".Pattern>span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), showtablename = $(this).attr("data-text"), $("." + showtablename).show().siblings().hide(), orshow_danszs()
}), $(".lookshjtj").on("touchstart", function (t) {
    t.preventDefault(), $("html,body").animate({scrollTop: $("#footerDiv").offset().top}, 500)
}), $(".lishihm").on("touchstart", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $(this).hasClass("haomack_noe") ? ($("#lishitj_ls").css("display", "block"), $("#xingtai_ck").css("display", "none")) : ($("#lishitj_ls").css("display", "none"), $("#xingtai_ck").css("display", "block"))
}), $("#limianBox").find("ul").find("li").on("click", function () {
    $(this).find("i").hasClass("iActClass") || $(this).find("i").addClass("iActClass").parent("span").siblings().find("i").removeClass(), $(this).hasClass("minciLiAct") || $(this).addClass("minciLiAct").siblings().removeClass();
    var t = $(this).find("i").text();
    $("#mian" + t).hasClass("displaynone") && $("#mian" + t).removeClass().siblings("mian").addClass("displaynone"), shifenFunObj.limtj.addlimtj(lianglist, t)
}), $("#meiri_tj").find("ul").find("li").on("click", function () {
    $(this).addClass("meiriLiAct").siblings().removeClass();
    var t = $(this).find("i").text();
    shifenFunObj.meiritj.getmeiritj(t, mrcltj_val[0] || 1)
}), $(".reset").on("click", function () {
    $(".gotop").css("height", "0rem"), $(".loteyPage").removeClass("gotop"), $(".or_").each(function (t) {
        $(this).hasClass("check_tj") ? $(this).removeClass("check_tj").removeClass("or_") : $(this).addClass("check_tj").removeClass("or_")
    })
});
var lianglist = "", meiritjpl = "", shifenFunObj = {
    limtj: {
        init: function () {
            this.getlimtj("", 20, 10)
        }, getlimtj: function (t, a, s) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryNewestDataForDsdx.do",
                data: {lotCode: lotCode, date: t, groups: a, steps: s},
                success: function (t) {
                    lianglist = t;
                    var a = 1 * $(".minciLiAct i").text();
                    shifenFunObj.limtj.addlimtj(t, a)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, addlimtj: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data;
            $("#tableliBox tbody").empty();
            var e = a, l = "";
            $(s).each(function (t) {
                var a = $(this)[0].list[e];
                l += "<tr><td style='height:33px'>" + this.date + "</td><td  style='height:33px'>" + a.singleCount + "</td><td  style='height:33px'>" + a.doubleCount + "</td>", l += "<td  style='height:33px'>" + a.bigCount + "</td><td  style='height:33px'>" + a.smallCount + "</td></tr>"
            }), $("#tableliBox #mian0").append(l)
        }
    }, meiritj: {
        init: function () {
            this.getmeiritj(1, 1)
        }, getmeiritj: function (t, a) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryKlsfDailyDragon.do",
                data: {lotCode: lotCode, type: t, rank: a},
                success: function (t) {
                    meiritjpl = t;
                    var a = 1 * $(".meiriLiAct i").text();
                    shifenFunObj.meiritj.addmeiritj(t, a)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addmeiritj: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            var s = a.result.data.list, e = "", l = [];
            if ($(s).each(function (t) {
                l.push(this.dragon.length)
            }), (e = Math.max.apply(null, l)) > 10) for (var n = "<tr><th rowspan='2'>日期</th>", i = 0; i < e; i++) n += "<th rowspan='2'>" + (1 * i + 2) + "<br/>期</th>"; else for (var n = "<tr><th >日期</th>", i = 0; i < e; i++) n += "<th>" + (1 * i + 2) + "<br/>期</th>";
            n += "</tr>", $("#table_meiri thead").html(n);
            var o = "";
            $(s).each(function (t) {
                var a = this.dragon;
                o += "<tr><td>" + this.date + "</td>";
                for (var s = 0; s < e; s++) o += "<td>" + (void 0 == a[s] ? "&nbsp;" : a[s]) + "</td>";
                o += "</tr>"
            }), $("#table_meiri tbody").html(o)
        }
    }, lzfx: {
        init: function () {
            this.getlist("")
        }, getlist: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.lzfx.addlzTable(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlzTable: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".luzhufx .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state;
                    if (1 == l) {
                        var n = "单", i = "双", o = "单双";
                        s = "danshuangShow"
                    } else if (2 == l) {
                        var n = "大", i = "小", d = "和", o = "大小";
                        s = "daxiaoShow"
                    } else if (3 == l) {
                        var n = "龙", i = "虎", o = "龙虎";
                        s = "longhuShow"
                    } else if (4 == l) {
                        var n = "大", i = "小", o = "尾大尾小";
                        s = "weishudxShow"
                    } else if (5 == l) {
                        var n = "单", i = "双", o = "合单合双";
                        s = "heshudsShow"
                    } else if (6 == l) {
                        var n = "中", i = "发", d = "白", o = "中发白";
                        s = "zhongfbShow"
                    } else if (7 == l) {
                        var n = "东", i = "南", d = "西", r = "北", o = "东南西北";
                        s = "fangweiShow"
                    }
                    var c = a.result.data[e].rank,
                        h = "<div class='lz_title " + s + " ball_" + c + "'><div class='left'><span>今日累计:</span>",
                        u = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var p = 0, f = 0, b = 0, _ = 0, g = 0; p < a.result.data[e].roadBeads.length && !(p >= 200); p++) {
                        var m = a.result.data[e].roadBeads[p];
                        1 == m ? (m = n, f += 1) : 0 == m ? (m = i, b += 1) : 2 == m ? (m = n, f += 1) : 9 == m ? (m = d, _ += 1) : 3 == m ? (m = i, b += 1) : 4 == m ? (m = d, _ += 1) : 5 == m ? (m = n, f += 1) : 6 == m ? (m = i, b += 1) : 7 == m ? (m = d, _ += 1) : 8 == m && (m = r, g += 1), 0 == p && (u += "<p>" + m + "</p>"), p > 0 & a.result.data[e].roadBeads[p - 1] == a.result.data[e].roadBeads[p] ? u += "<p>" + m + "</p>" : p > 0 & a.result.data[e].roadBeads[p - 1] != a.result.data[e].roadBeads[p] && (u += "</td><td><p>" + m + "</p>")
                    }
                    var v = "";
                    if (1 == c ? v = "第一球" : 2 == c ? v = "第二球" : 3 == c ? v = "第三球" : 4 == c ? v = "第四球" : 5 == c ? v = "第五球" : 6 == c ? v = "第六球" : 7 == c ? v = "第七球" : 8 == c ? v = "第八球" : 9 == c && (v = "总和"), l <= 5) z = "<span class='pld'>" + n + "（" + a.result.data[e].totals[0] + "）</span><span class='pld'>" + i + "（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='weizi'>" + v + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"; else if (l <= 6) z = "<span class='lok'>" + n + "（" + a.result.data[e].totals[0] + "）</span><span class='lok'>" + i + "（" + a.result.data[e].totals[1] + "）</span><span class='lok'>" + d + "（" + a.result.data[e].totals[2] + "）</span></div><div class='right'><span class='weizi'>" + v + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"; else z = "<span class='pld'>" + n + "（" + a.result.data[e].totals[0] + "）</span><span class='pld'>" + i + "（" + a.result.data[e].totals[1] + "）</span><p class='han'><span>" + d + "（" + a.result.data[e].totals[2] + "）</span><span class='loyh'>" + r + "（" + a.result.data[e].totals[3] + "）<span></p></div><div class='right'><span class='weizi'>" + v + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                    if (2 == l) {
                        z = "<span class='pld'>" + n + "（" + a.result.data[e].totals[0] + "）</span><span class='pld'>" + i + "（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='weizi'>" + v + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                        if (9 == c) z = "<span>" + n + "（" + a.result.data[e].totals[0] + "）</span><span>" + i + "（" + a.result.data[e].totals[1] + "）</span><span>" + d + "（" + a.result.data[e].totals[2] + "）</span></div><div class='right'><span class='weizi'>" + v + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"
                    } else if (4 == l) z = "<span class='pld'>尾大（" + a.result.data[e].totals[0] + "）</span><span class='pld'>尾小（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='weizi'>" + v + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"; else if (5 == l) var z = "<span class='pld'>合单（" + a.result.data[e].totals[0] + "）</span><span class='pld'>合双（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='weizi'>" + v + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".luzhufx .lz_content").append(h + z + u + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red"), $(".tablebox>td>p:contains('中')").css("color", "red"), $(".tablebox>td>p:contains('南')").css("color", "red");
                var x = $(".luzhufx .Pattern .checkspan");
                $("#F_checklz_lz_mc").parents(".mobileSelect").remove(), $("#F_checkclick_lz").parents(".mobileSelect").remove(), x.hasClass("zonghums") ? lzfxzhms() : x.hasClass("danxuanms") ? lzfxdxms() : lzfxlmms(), animate_lz()
            } else tools.weikaiji(".luzhufx .lz_content")
        }
    }, zonghe: {
        getzonghe: function (t) {
            "" == (t = void 0 == t ? "" : t) && $(".zonghelz .cheDate span:first").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.zonghe.addzonghe(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addzonghe: function (t) {
            if ("" != t) {
                var a = tools.parseObj(t);
                if (0 != a.result.data.length) {
                    $(".zonghelzfen .lz_content").html("");
                    for (var s = "", e = 0; e < a.result.data.length; e++) {
                        var l = a.result.data[e].state;
                        if (1 == l) {
                            var n = "双", i = "单", o = "单双";
                            s = "danshuangShow"
                        } else if (2 == l) {
                            var n = "小", i = "大", d = "和", o = "大小";
                            s = "daxiaoShow"
                        } else if (4 == l) {
                            var n = "小", i = "大", o = "尾大尾小";
                            s = "weishudxShow"
                        }
                        var r = a.result.data[e].rank;
                        if (9 == r) {
                            var c = "<div class='lz_title " + s + " ball_" + r + "'><div class='left'><span>今日累计:</span>",
                                h = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                            a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                            for (var u = 0, p = 0, f = 0, b = 0; u < a.result.data[e].roadBeads.length && !(u >= 200); u++) {
                                var _ = a.result.data[e].roadBeads[u];
                                0 == _ ? (_ = n, p += 1) : 1 == _ ? (_ = i, f += 1) : 9 == _ && (_ = d, b += 1), 0 == u && (h += "<p>" + _ + "</p>"), u > 0 & a.result.data[e].roadBeads[u - 1] == a.result.data[e].roadBeads[u] ? h += "<p>" + _ + "</p>" : u > 0 & a.result.data[e].roadBeads[u - 1] != a.result.data[e].roadBeads[u] && (h += "</td><td><p>" + _ + "</p>")
                            }
                            if (2 == l) g = "<span>" + i + "（" + a.result.data[e].totals[0] + "）</span><span>" + n + "（" + a.result.data[e].totals[1] + "）</span><span>" + d + "（" + a.result.data[e].totals[2] + "）</span></div><div class='right'><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"; else if (4 == l) g = "<span>尾大（" + a.result.data[e].totals[0] + "）</span><span>尾小（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"; else var g = "<span>" + i + "（" + a.result.data[e].totals[0] + "）</span><span>" + n + "（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                            $(".zonghelzfen .lz_content").append(c + g + h + "</td></tr></tbody></table></div></div>")
                        }
                    }
                    $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('大')").css("color", "red")
                } else tools.weikaiji(".zonghelzfen .lz_content")
            } else tools.weikaiji(".zonghelzfen .lz_content")
        }
    }, zhongfa: {
        getzhongfa: function (t) {
            "" == (t = void 0 == t ? "" : t) && $(".zongfabailz .cheDate span:first").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.zhongfa.addzhongfa(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addzhongfa: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".zongfabailz .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state, n = a.result.data[e].rank;
                    if (6 == l) {
                        var i = "<div class='lz_title " + (s = "zhongfbShow") + " ball_" + n + "'><div class='left'><span>今日累计:</span>",
                            o = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                        a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                        for (var d = 0, r = 0, c = 0, h = 0; d < a.result.data[e].roadBeads.length && !(d >= 200); d++) {
                            var u = a.result.data[e].roadBeads[d];
                            4 == u ? (u = "白", h += 1) : 2 == u ? (u = "中", r += 1) : 3 == u && (u = "发", c += 1), 0 == d && (o += "<p>" + u + "</p>"), d > 0 & a.result.data[e].roadBeads[d - 1] == a.result.data[e].roadBeads[d] ? o += "<p>" + u + "</p>" : d > 0 & a.result.data[e].roadBeads[d - 1] != a.result.data[e].roadBeads[d] && (o += "</td><td><p>" + u + "</p>");
                            var p = "";
                            1 == n ? p = "第一球" : 2 == n ? p = "第二球" : 3 == n ? p = "第三球" : 4 == n ? p = "第四球" : 5 == n ? p = "第五球" : 6 == n ? p = "第六球" : 7 == n ? p = "第七球" : 8 == n && (p = "第八球")
                        }
                        var f = "<span>中（" + a.result.data[e].totals[0] + "）</span><span>发（" + a.result.data[e].totals[1] + "）</span><span>白（" + a.result.data[e].totals[2] + "）</span></div><div class='right'><span class='mosh'>" + p + "</span><span class='mosh'>中白发</span><span class='zxi'>最新    &darr;</span></div>";
                        $(".zongfabailz .lz_content").append(i + f + o + "</td></tr></tbody></table></div></div>")
                    }
                }
                zonghe_listitem(), $(".tablebox>td>p:contains('中')").css("color", "red"), animate_lz()
            } else tools.weikaiji(".zongfabailz .lz_content")
        }
    }, haomalz: {
        init: function () {
            this.gethaomalz("")
        }, gethaomalz: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryDrawCodeRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.haomalz.haomalzlist(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, haomalzlist: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".haomalzfen").find(".lz_content").html("");
                for (var s = "", e = "", l = 0; l < a.result.data.length; l++) {
                    var n = a.result.data[l].drawCode;
                    if (1 == n) {
                        var i = "X", o = "✓";
                        s = "cuoduishow"
                    }
                    var d = "<div id='hm" + l + "' class='lz_title " + s + " ball_" + n + "'><div class='left'><span>今日累计:</span>",
                        r = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[l].roadBeads = a.result.data[l].roadBeads.reverse();
                    for (var c = 0, h = 0, u = 0; c < a.result.data[l].roadBeads.length && !(c >= 200); c++) {
                        var p = a.result.data[l].roadBeads[c];
                        0 == p ? (p = i, h += 1) : 1 == p && (p = o, u += 1), 0 == c && (r += "<p>" + p + "</p>"), c > 0 & a.result.data[l].roadBeads[c - 1] == a.result.data[l].roadBeads[c] ? r += "<p>" + p + "</p>" : c > 0 & a.result.data[l].roadBeads[c - 1] != a.result.data[l].roadBeads[c] && (r += "</td><td><p>" + p + "</p>")
                    }
                    e += d + ("<span>总来（" + a.result.data[l].totals[0] + "）</span><span>没来（" + a.result.data[l].totals[1] + "）</span></div><div class='right'><span class='mosh'>号码" + n + "</span><span class='zxi'>最新    &darr;</span></div>") + r + "</td></tr></tbody></table></div></div>"
                }
                $(".haomalzfen .lz_content").append(e), $(".tablebox>td>p:contains('✓')").css("color", "red"), animate_lz()
            } else tools.weikaiji(".haomalzfen .lz_content")
        }
    }, danshuan: {
        getdsdxls: function () {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryHistoryDataForDsdx.do",
                data: {lotCode: lotCode},
                success: function (t) {
                    shifenFunObj.danshuan.dsdxlslist(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, dsdxlslist: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            var s = a.result.data;
            $("#tableBox tbody").empty(), $(s).each(function (t) {
                for (var a = $(this)[0], s = "", e = "<td >" + a.date + "</td>", l = 0; l <= 7; l++) {
                    var n = "tr" + l;
                    n = "<tr style='height:33px'>" + e + ("<td >" + a.list[l].bigCount + "</td><td >" + a.list[l].smallCount + "</td><td >" + a.list[l].singleCount + "</td><td >" + a.list[l].doubleCount + "</td>") + "</tr>", $("#tbody" + l).append(n)
                }
                for (var i = 0; i < 4; i++) {
                    s = "getiTd" + i;
                    for (l = 0; l < a.list.length; l++) s += "<td>" + (0 == i ? a.list[l].singleCount : 1 == i ? a.list[l].doubleCount : 2 == i ? a.list[l].bigCount : a.list[l].smallCount) + "</td>";
                    getiTr = "<tr style='height:33px'>" + e + s + "</tr>", $("#gtbody" + i).append(getiTr)
                }
            })
        }
    }, jibendata: {
        init: function () {
            this.getjibenzs("", 30)
        }, getjibenzs: function (t, a) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryDrawCodeTrend.do",
                data: {lotCode: lotCode, date: t, periods: a},
                success: function (t) {
                    shifenFunObj.jibendata.jibenzslist(t)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, jibenzslist: function (t) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var a = data.result.data;
            if (0 == a.list) return tools.weikaiji("#table_jiben"), void tools.weikaiji("#jibenzsfentop");
            listettablearr(a.list), $("#table_jiben").html();
            var s = "";
            s += "<thead><tr><th rowspan='2' style='width: 19%;'>期号</th><th rowspan='2' style='width: 33%;'>开奖号码</th>", s += "<th rowspan='2' class='jibenend'>和值</th><th rowspan='2' class='jibenend'>和大</th><th rowspan='2' class='jibenend'>和小</th>", s += "<th rowspan='2' class='jibenend'>和</th><th rowspan='2' class='jibenend'>和单</th><th rowspan='2' class='jibenend'>和双</th>", s += "<th rowspan='2' class='jibenend'>尾大</th><th rowspan='2' class='jibenend'>尾小</th></tr></thead><tbody><tr>", $(a.list).each(function (t) {
                if (t >= config.klsfrows_thre) return !1;
                var a = this.preDrawCode, e = this.missing.slice(20, 28);
                s += " <td>" + this.preDrawIssue + "</td><td class='tabred'><span>" + a.join(" ") + "</span></td>";
                for (var l = 0; l < e.length; l++) 2 * e[l] >= 0 ? l <= 0 ? s += "<td class='tabred'><span name='hotSpan' >" + e[l] + "</span></td>" : l <= 1 ? s += "<td class='hot'><span name='hotSpan'>大</span></td>" : l <= 2 ? s += "<td class='hot'><span name='hotSpan'>小</span></td>" : l <= 3 ? s += "<td class='hot'><span name='hotSpan'>和</span></td>" : l <= 4 ? s += "<td class='hot zese'><span name='hotSpan'>单</span></td>" : l <= 5 ? s += "<td class='hot zese'><span name='hotSpan'>双</span></td>" : l <= 6 ? s += "<td class='hot fense'><span name='hotSpan'>大</span></td>" : l <= 7 && (s += "<td class='hot fense'><span name='hotSpan'>小</span></td>") : s += "<td><span>" + Math.abs(e[l]) + "</span></td>";
                s += "</tr>"
            });
            var e = a.title.appearCount.slice(21, 28), l = a.title.averageMissingValues.slice(21, 28);
                //n = a.title.currentMissingValues.slice(21, 28);
            var i = a.title.maxAppearValues.slice(21, 28),
                o = a.title.maxMissingValues.slice(21, 28);
            html_topp = "", html_topp += "</tbody><tfoot>", html_topp += "<tr class='pldke'><th  colspan='3' style='width: 57%;'>数据统计</th><th  class='jibenend'>和大</th>", html_topp += "<th class='jibenend'>和小</th><th  class='jibenend'>和</th><th  class='jibenend'>和单</th>", html_topp += "<th  class='jibenend'>和双</th><th  class='jibenend'>尾大</th><th class='jibenend'>尾小</th></tr>";
            for (var d = "<tr><td colspan='3'>出现次数</td>", r = "<tr><td colspan='3'>平均遗漏</td>", c = "<tr style='display: none;'><td colspan='3'>当前遗漏</td>", h = "<tr><td colspan='3'>最大连出</td>", u = "<tr><td colspan='3'>最大遗漏</td>", p = 0; p < e.length; p++) d += " <td>" + Math.abs(e[p]) + "</td>", r += " <td>" + Math.abs(l[p]) + "</td>", c += " <td></td>", h += " <td>" + Math.abs(i[p]) + "</td>", u += " <td>" + Math.abs(o[p]) + "</td>";
            html_topp += d + r + "</tr>" + c + "</tr>" + h + "</tr>" + u + "</tr>", s += html_topp + "</tfoot>", $(".jibenzsfen canvas").remove(), $("#table_jiben").html(s), $("#jibenzsfentop tbody tr").remove();
            var f = "";
            $(a.list).each(function (t, a) {
                if (t >= config.klsfrows_thre) return !1;
                var s = "";
                t % 2 == 1 && t > 0 && (s = "oddtr");
                var e = "<tr class='zslistUl " + s + "'>", l = this.preDrawIssue, n = this.missing.slice(0, 20);
                f += "<tr class='qishutr " + s + "'><td>" + l + "</td></tr>", $(n).each(function (t) {
                    e += this > 0 ? "<td class='hot'><span name='hotSpan'>" + this + "</span></td>" : "<td><span>" + Math.abs(this) + "</span></td>"
                }), e += "</tr>", $(".rightDate #table_jibentop tbody").append(e)
            }), f += "<tr class='missUl qishutr'><td>数据统计</td></tr><tr class='missUlWhite qishutr'><td>出现次数</td></tr><tr class='missUlWhite qishutr'><td>平均遗漏</td></tr>", f += "<tr class='missUlWhite qishutr'><td>当前遗漏</td></tr><tr class='missUlWhite qishutr'><td>最大遗漏</td></tr><tr class='missUlWhite qishutr'><td>最大连出</td></tr>", $("#table_jibennot tbody").append(f);
            $(".rightDate #table_jibentop tbody").append("<tr class='zslistUl missUl'><td>01</td><td>02</td><td>03</td><td>04</td><td>05</td><td>06</td><td>07</td><td>08</td><td>09</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td></tr>");
            var b = "<tr>", _ = "<tr>", g = "<tr>", m = "<tr>", v = "<tr>";
            $(a.title.appearCount).each(function (t) {
                if (t >= 20) return !1;
                b += "<td><span>" + Math.abs(this) + "</span></td>"
            }), $(a.title.averageMissingValues).each(function (t) {
                if (t >= 20) return !1;
                _ += "<td><span>" + Math.abs(this) + "</span></td>"
            }), $(a.title.currentMissingValues).each(function (t) {
                if (t >= 20) return !1;
                g += "<td><span>" + Math.abs(this) + "</span></td>"
            }), $(a.title.maxAppearValues).each(function (t) {
                if (t >= 20) return !1;
                m += "<td><span>" + Math.abs(this) + "</span></td>"
            }), $(a.title.maxMissingValues).each(function (t) {
                if (t >= 20) return !1;
                v += "<td><span>" + Math.abs(this) + "</span></td>"
            }), $(".rightDate table tbody").append(b + "</tr>" + _ + "</tr>" + g + "</tr>" + m + "</tr>" + v + "</tr>"), $(".jibenzsfen canvas").remove(), orshowConten()
        }
    }, heshudslz: {
        getheshudslz: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.heshudslz.addheshudslz(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addheshudslz: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".heshudanshuanglz .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state, n = a.result.data[e].rank;
                    if (5 == l) {
                        var i = "<div class='lz_title " + (s = "hedanhsshow") + " ball_" + n + "'><div class='left'><span>今日累计:</span>",
                            o = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                        a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                        for (var d = 0, r = 0, c = 0; d < a.result.data[e].roadBeads.length && !(d >= 200); d++) {
                            var h = a.result.data[e].roadBeads[d];
                            0 == h ? (h = "双", r += 1) : 1 == h && (h = "单", c += 1), 0 == d && (o += "<p>" + h + "</p>"), d > 0 & a.result.data[e].roadBeads[d - 1] == a.result.data[e].roadBeads[d] ? o += "<p>" + h + "</p>" : d > 0 & a.result.data[e].roadBeads[d - 1] != a.result.data[e].roadBeads[d] && (o += "</td><td><p>" + h + "</p>");
                            var u = "";
                            1 == n ? u = "第一球" : 2 == n ? u = "第二球" : 3 == n ? u = "第三球" : 4 == n ? u = "第四球" : 5 == n ? u = "第五球" : 6 == n ? u = "第六球" : 7 == n ? u = "第七球" : 8 == n && (u = "第八球")
                        }
                        var p = "<span>合单（" + a.result.data[e].totals[0] + "）</span><span>合双（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='mosh'>" + u + "</span><span class='mosh'>合单合双</span><span class='zxi'>最新    &darr;</span></div>";
                        $(".heshudanshuanglz .lz_content").append(i + p + o + "</td></tr></tbody></table></div></div>")
                    }
                }
                $(".tablebox>td>p:contains('双')").css("color", "red"), heshu_list(), animate_lz()
            } else tools.weikaiji(".heshudanshuanglz .lz_content")
        }
    }, weishudxlz: {
        getweishudxlz: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.weishudxlz.addweishudxlz(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addweishudxlz: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".weishudaxiaolz .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state, n = a.result.data[e].rank;
                    if (4 == l) {
                        var i = "<div class='lz_title " + (s = "weidawxshow") + " ball_" + n + "'><div class='left'><span>今日累计:</span>",
                            o = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                        a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                        for (var d = 0, r = 0, c = 0; d < a.result.data[e].roadBeads.length && !(d >= 200); d++) {
                            var h = a.result.data[e].roadBeads[d];
                            0 == h ? (h = "小", r += 1) : 1 == h && (h = "大", c += 1), 0 == d && (o += "<p>" + h + "</p>"), d > 0 & a.result.data[e].roadBeads[d - 1] == a.result.data[e].roadBeads[d] ? o += "<p>" + h + "</p>" : d > 0 & a.result.data[e].roadBeads[d - 1] != a.result.data[e].roadBeads[d] && (o += "</td><td><p>" + h + "</p>");
                            var u = "";
                            1 == n ? u = "第一球" : 2 == n ? u = "第二球" : 3 == n ? u = "第三球" : 4 == n ? u = "第四球" : 5 == n ? u = "第五球" : 6 == n ? u = "第六球" : 7 == n ? u = "第七球" : 8 == n && (u = "第八球")
                        }
                        if (n > 8) break;
                        var p = "<span>尾大（" + a.result.data[e].totals[0] + "）</span><span>尾小（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='mosh'>" + u + "</span><span class='mosh'>尾大尾小</span><span class='zxi'>最新    &darr;</span></div>";
                        $(".weishudaxiaolz .lz_content").append(i + p + o + "</td></tr></tbody></table></div></div>"), $(".tablebox>td>p:contains('大')").css("color", "red")
                    }
                }
                animate_lz(), weishulz_list()
            } else tools.weikaiji(".weishudaxiaolz .lz_content")
        }
    }, longhulz: {
        getlonghulz: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.longhulz.addlonghulz(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlonghulz: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".longhulzfen .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) if (3 == a.result.data[e].state) {
                    s = "longhulzshow";
                    var l = a.result.data[e].rank,
                        n = "<div class='lz_title " + s + " ball_" + l + "'><div class='left'><span>今日累计:</span>",
                        i = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var o = 0, d = 0, r = 0; o < a.result.data[e].roadBeads.length && !(o >= 200); o++) {
                        var c = a.result.data[e].roadBeads[o];
                        1 == c ? (c = "龙", d += 1) : 0 == c && (c = "虎", r += 1), 0 == o && (i += "<p>" + c + "</p>"), o > 0 & a.result.data[e].roadBeads[o - 1] == a.result.data[e].roadBeads[o] ? i += "<p>" + c + "</p>" : o > 0 & a.result.data[e].roadBeads[o - 1] != a.result.data[e].roadBeads[o] && (i += "</td><td><p>" + c + "</p>");
                        var h = "";
                        1 == l ? h = "第一球" : 2 == l ? h = "第二球" : 3 == l ? h = "第三球" : 4 == l && (h = "第四球")
                    }
                    var u = "<span>龙（" + a.result.data[e].totals[0] + "）</span><span>虎（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='mosh'>" + h + "</span><span class='mosh'>龙虎</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".longhulzfen .lz_content").append(n + u + i + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red"), longhu_list()
            } else tools.weikaiji(".longhulzfen .lz_content")
        }
    }, dansdxlz: {
        getdansdxlz: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.dansdxlz.adddansdxlz(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, adddansdxlz: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".danshuangdaxiaolz .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var l = a.result.data[e].state;
                    if (1 == l) {
                        var n = "单", i = "双", o = "单双";
                        s = "danshuangShow"
                    } else if (2 == l) {
                        var n = "大", i = "小", o = "大小";
                        s = "daxiaoShow"
                    } else if (3 == l) {
                        var n = "虎", i = "龙", o = "龙虎";
                        s = "longhuShow"
                    } else if (4 == l) {
                        var n = "大", i = "小", o = "尾大尾小";
                        s = "weishudxShow"
                    } else if (5 == l) {
                        var n = "单", i = "双", o = "合单合双";
                        s = "heshudsShow"
                    } else if (6 == l) {
                        var n = "中", i = "发", o = "白发中";
                        s = "zhongfbShow"
                    } else if (7 == l) {
                        var n = "东", i = "南", o = "东南西北";
                        s = "fangweiShow"
                    }
                    var d = a.result.data[e].rank,
                        r = "<div class='lz_title " + s + " ball_" + d + "'><div class='left'><span>今日累计:</span>",
                        c = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var h = 0, u = 0, p = 0; h < a.result.data[e].roadBeads.length && !(h >= 200); h++) {
                        var f = a.result.data[e].roadBeads[h];
                        1 == f ? (f = n, u += 1) : 0 == f && (f = i, p += 1), 0 == h && (c += "<p>" + f + "</p>"), h > 0 & a.result.data[e].roadBeads[h - 1] == a.result.data[e].roadBeads[h] ? c += "<p>" + f + "</p>" : h > 0 & a.result.data[e].roadBeads[h - 1] != a.result.data[e].roadBeads[h] && (c += "</td><td><p>" + f + "</p>");
                        var b = "";
                        1 == d ? b = "第一球" : 2 == d ? b = "第二球" : 3 == d ? b = "第三球" : 4 == d ? b = "第四球" : 5 == d ? b = "第五球" : 6 == d ? b = "第六球" : 7 == d ? b = "第七球" : 8 == d && (b = "第八球")
                    }
                    if (2 == l) _ = "<span>" + n + "（" + a.result.data[e].totals[0] + "）</span><span>" + i + "（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='mosh'>" + b + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>"; else var _ = "<span>" + n + "（" + a.result.data[e].totals[0] + "）</span><span>" + i + "（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='mosh'>" + b + "</span><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".danshuangdaxiaolz .lz_content").append(r + _ + c + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), dansdxlz_list()
            } else tools.weikaiji(".danshuangdaxiaolz .lz_content")
        }
    }, jrhmtj: {
        getjrhmtj: function (t) {
            void 0 == t && (t = ""), $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryToDayNumberLawOfStatistics.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.jrhmtj.addjrhmtj(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addjrhmtj: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode) for (var s = "", e = a.result.data, l = "", n = 0; n < 8; n++) {
                0 == n ? l = "第一球" : 1 == n ? l = "第二球" : 2 == n ? l = "第三球" : 3 == n ? l = "第四球" : 4 == n ? l = "第五球" : 5 == n ? l = "第六球" : 6 == n ? l = "第七球" : 7 == n && (l = "第八球"), s += "<div class='item_" + (n + 1) + " item_'><span class='item_title'>" + l + "</span><ul class='num_item'>", s += "<li class='li_first'>号码</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li><li>7</li> <li>8</li><li>9</li><li>10</li></ul>";
                for (var i = "<ul class='zongkai_item'><li class='li_first'>总开</li>", o = "<ul class='liankai_item'><li class='li_first'>未开</li>", d = 0; d < 20; d++) {
                    zkthisVal = e[d].list[n].accumulate, wkthisVal = Math.abs(e[d].list[n].missing);
                    var r = zkthisVal >= 50 ? "black" : zkthisVal >= 41 ? "green" : zkthisVal >= 31 ? "blue" : zkthisVal >= 10 ? "red" : "",
                        c = wkthisVal >= 50 ? "black" : wkthisVal >= 41 ? "green" : wkthisVal >= 31 ? "blue" : wkthisVal >= 10 ? "red" : "";
                    i += "<li class='" + r + "'>" + zkthisVal + "</li>", o += "<li class='" + c + "'>" + wkthisVal + "</li>", 9 == d && (s += i + "</ul>" + o + "</ul><ul class='num_item'><li class='li_first'>号码</li><li>11</li><li>12</li><li>13</li><li>14</li><li>15</li><li>16</li><li>17</li> <li>18</li><li>19</li><li>20</li></ul>", i = "<ul class='zongkai_item'><li class='li_first'>总开</li>", o = "<ul class='liankai_item'><li class='li_first'>未开</li>")
                }
                s += i + "</ul>" + o + "</ul></div>"
            }
            $(".jinrihaomatj .showconten").html(s)
        }
    }, dongnxb: {
        getdongnxb: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryComprehensiveRoadBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.dongnxb.adddongnxb(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, adddongnxb: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".dongxinanbei .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) if (7 == a.result.data[e].state) {
                    s = "fangweiShow";
                    var l = a.result.data[e].rank,
                        n = "<div class='lz_pl " + s + " ball_" + l + "'><div class='left'><span>今日累计:</span>",
                        i = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var o = 0, d = 0, r = 0, c = 0; o < a.result.data[e].roadBeads.length && !(o >= 200); o++) {
                        var h = a.result.data[e].roadBeads[o];
                        5 == h ? (h = "东", d += 1) : 6 == h ? (h = "南", r += 1) : 7 == h ? (h = "西", c += 1) : 8 == h && (h = "北", c += 1), 0 == o && (i += "<p>" + h + "</p>"), o > 0 & a.result.data[e].roadBeads[o - 1] == a.result.data[e].roadBeads[o] ? i += "<p>" + h + "</p>" : o > 0 & a.result.data[e].roadBeads[o - 1] != a.result.data[e].roadBeads[o] && (i += "</td><td><p>" + h + "</p>");
                        var u = "";
                        1 == l ? u = "第一球" : 2 == l ? u = "第二球" : 3 == l ? u = "第三球" : 4 == l ? u = "第四球" : 5 == l ? u = "第五球" : 6 == l ? u = "第六球" : 7 == l ? u = "第七球" : 8 == l && (u = "第八球")
                    }
                    var p = "<span>东（" + a.result.data[e].totals[0] + "）</span><span>南（" + a.result.data[e].totals[1] + "）</span><p><span>西（" + a.result.data[e].totals[2] + "）</span><span>北（" + a.result.data[e].totals[3] + "）</span></p></div><div class='right'><span class='mosh'>" + u + "</span><span class='mosh'>东南西北</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".dongxinanbei .lz_content").append(n + p + i + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('南')").css("color", "red"), dongnxb_list()
            } else tools.weikaiji(".dongxinanbei .lz_content")
        }
    }, dxzs: {
        init: function () {
            this.getdata("", 30)
        }, getdata: function (t, a) {
            t = void 0 == t || "" == t ? getDateStr(0, !0) : t, a = void 0 == a ? "" : a, "" != t && t != getDateStr(0, !0) || "" != a || ($(".shjian_daxiaozs").text("今天").attr("data-text", 0), $("#rank_daxiaozs ul li:first").addClass("checked").siblings().removeClass("checked")), $.ajax({
                url: config.publicUrl + "klsf/queryKslfDxTrend.do?date=" + t + "&periods=" + a,
                type: "GET",
                data: {lotCode: lotCode},
                success: function (t) {
                    shifenFunObj.dxzs.analysis(t)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, analysis: function (t) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var a = data.result.data;
            if (0 == a.length || 0 == a.list.length) return 0 == $(".daxiaozsfen .tableconten #weikaiji").length && $(".daxiaozsfen .tableconten").append("<div id='weikaiji'>今天暂未开奖</div>"), $(".tableconten #weikaiji").show().siblings(".table_dxzs").addClass("imporhide"), void tools.weikaiji(".table_dxb table tbody");
            if ($(".tableconten #weikaiji").hide(), $(".tableconten .table_dxzs").removeClass("imporhide"), $(".prevlo").hide(), $(".daxiaozsfen .table_dxzs table tbody").empty(), $(".daxiaozsfen .righttable table tfoot>tr:not([class])").empty(), $(".canvas").remove(), 0 == a.length) return !1;
            listettablearr(a.list);
            var s = "", e = "";
            $(a.list).each(function (t) {
                if (t >= config.klsfrows) return !1;
                var a = this.missing.slice(0, 16);
                e += t % 2 == 0 ? "<tr>" : "<tr class='dxcolor'>";
                for (var l = 0; l < a.length; l++) {
                    var n = "";
                    n = l <= 1 ? "hot_org" : l <= 3 ? "hot_blue" : l <= 5 ? "hot_green" : l <= 7 ? "hot_org" : l <= 9 ? "hot_blue" : l <= 11 ? "hot_green" : l <= 13 ? "hot_org" : l <= 15 ? "hot_blue" : "hot_org", (l + 1) % 2 != 0 && 1 * a[l] > 0 ? e += "<td class='hot'><span name='hotSpan' class='" + n + "'>大</span></td>" : (l + 1) % 2 == 0 && 1 * a[l] > 0 ? e += "<td class='hot'><span name='hotSpan' class='" + n + "'>小</span></td>" : e += "<td><span>" + Math.abs(a[l]) + "</span></td>"
                }
                e += "</tr>";
                var i = this.preDrawIssue.toString();
                s += t % 2 == 0 ? "<tr><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>" : "<tr class='dxcolor'><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>"
            }), $(".daxiaozsfen .lefttable table tbody").html(s), $(".daxiaozsfen .righttable table tbody").html(e);
            var l = "";
            $(".table_dxb table tbody").empty(), $(a.list).each(function (t) {
                var a = this.missing.slice(16), s = this.preDrawIssue.toString();
                l += t % 2 == 0 ? "<tr>" : "<tr class='dxcolor'>", l += "<td><span>" + (s.length > 5 ? s.slice(s.length - 5) : s) + "</span></td><td><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td>";
                for (var e = 0; e < a.length; e++) a[e] > 0 ? 0 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>0:8</span></td>" : 1 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>1:7</span></td>" : 2 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>2:6</span></td>" : 3 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>3:5</span></td>" : 4 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>4:4</span></td>" : 5 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>5:3</span></td>" : 6 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>6:2</span></td>" : 7 == e ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>7:1</span></td>" : 8 == e && (l += "<td class='hot'><span name='hotSpan' class='hot_squred'>8:0</span></td>") : l += " <td><span>" + Math.abs(a[e]) + "</span></td>";
                l += "</tr>"
            }), $(".table_dxb table tbody").html(l), $(".daxiaozsfen .righttable table tfoot>tr:not([class])").remove(), $(".daxiaozsfen .table_dxb table tfoot>tr:not([class])").remove(), dxzsfootarr = a.title, dxzsfoothtml = "", dxbfoothtml = "";
            for (var n = dxzsfootarr.appearCount.slice(0, 16), i = dxzsfootarr.averageMissingValues.slice(0, 16), o = dxzsfootarr.maxAppearValues.slice(0, 16), d = dxzsfootarr.maxMissingValues.slice(0, 16), r = dxzsfootarr.appearCount.slice(16), c = dxzsfootarr.averageMissingValues.slice(16), h = dxzsfootarr.maxAppearValues.slice(16), u = dxzsfootarr.maxMissingValues.slice(16), p = "<tr>", f = "<tr>", b = "<tr>", _ = "<tr>", g = "<tr><td colspan='2'>出现次数</td>", m = "<tr><td colspan='2'>平均遗漏</td>", v = "<tr><td colspan='2'>最大连出</td>", z = "<tr><td colspan='2'>最大遗漏</td>", x = 0; x < n.length; x++) p += "<td>" + n[x] + "</td>", f += "<td>" + i[x] + "</td>", b += "<td>" + o[x] + "</td>", _ += "<td>" + Math.abs(d[x]) + "</td>";
            for (var y = 0; y < r.length; y++) g += "<td>" + r[y] + "</td>", m += "<td>" + c[y] + "</td>", v += "<td>" + h[y] + "</td>", z += "<td>" + Math.abs(u[y]) + "</td>";
            var w = "</tr>";
            dxzsfoothtml = p + w + f + w + b + w + _ + w, dxbfoothtml = g + w + m + w + v + w + z + w, $(".daxiaozsfen .righttable table tfoot>tr:last-child").after(dxzsfoothtml), $(".daxiaozsfen .table_dxb table tfoot>tr:last-child").after(dxbfoothtml), orshowConten_daxizs()
        }
    }, dszs: {
        init: function () {
            this.getdszs("", 30)
        }, getdszs: function (t, a) {
            t = void 0 == t || "" == t ? getDateStr(0, !0) : t, a = void 0 == a ? "" : a, "" != t && t != getDateStr(0, !0) || "" != a || ($(".shjian_danszs").text("今天").attr("data-text", 0), $("#rank_danszs ul li:first").addClass("checkedpl").siblings().removeClass("checkedpl")), $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryKslfDsTrend.do",
                data: {periods: a, lotCode: lotCode, date: t},
                success: function (t) {
                    shifenFunObj.dszs.adddszs(t)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, adddszs: function (t) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var a = data.result.data;
            if (0 == a.length || 0 == a.list.length) return 0 == $(".danshuangzsfen .tableconten #weikaiji").length && $(".danshuangzsfen .tableconten").append("<div id='weikaiji'>今天暂未开奖</div>"), $(".tableconten #weikaiji").show().siblings(".table_qyzs").addClass("imporhide"), void tools.weikaiji(".table_qyb table tbody");
            if ($(".tableconten #weikaiji").hide(), $(".tableconten .table_qyzs").removeClass("imporhide"), $(".danshuangzsfen .table_qyzs table tbody").empty(), $(".danshuangzsfen .righttablepld table tfoot>tr:not([class])").empty(), $("canvas").remove(), 0 == a.length) return !1;
            listettablearr(a.list), $(".prevlo").hide();
            var s = "", e = "";
            $(a.list).each(function (t) {
                if (t >= config.klsfrows) return !1;
                var a = this.missing.slice(0, 16);
                e += t % 2 == 0 ? "<tr>" : "<tr class='bgcolor'>";
                for (var l = 0; l < a.length; l++) {
                    var n = "";
                    n = l <= 1 ? "hot_org" : l <= 3 ? "hot_blue" : l <= 5 ? "hot_green" : l <= 7 ? "hot_org" : l <= 9 ? "hot_blue" : l <= 11 ? "hot_green" : l <= 13 ? "hot_org" : l <= 15 ? "hot_blue" : "hot_org", (l + 1) % 2 != 0 && 1 * a[l] > 0 ? e += "<td class='hot'><span name='hotSpan' class='" + n + "'>奇</span></td>" : (l + 1) % 2 == 0 && 1 * a[l] > 0 ? e += "<td class='hot'><span name='hotSpan' class='" + n + "'>偶</span></td>" : e += "<td><span>" + Math.abs(a[l]) + "</span></td>"
                }
                e += "</tr>";
                var i = this.preDrawIssue.toString();
                s += t % 2 == 0 ? "<tr><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>" : "<tr class='bgcolor'><td><span class='xianytrc'>" + (i.length > 5 ? i.slice(i.length - 5) : i) + "</span><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td></tr>"
            }), $(".danshuangzsfen .lefttabledans table tbody").html(s), $(".danshuangzsfen .righttablepld table tbody").html(e);
            var l = "";
            $(".table_qyb table tbody").empty(), $(a.list).each(function (t) {
                if (10053 == lotCode) a = config.showrows; else var a = 200;
                if (t >= a) return !1;
                var s = this.missing.slice(16), e = this.preDrawIssue.toString();
                l += t % 2 == 0 ? "<tr>" : "<tr class='bgcolor'>", l += "<td><span>" + (e.length > 5 ? e.slice(e.length - 5) : e) + "</span></td><td><span class='color_red'>" + this.preDrawCode.toString().replace(/,/g, " ") + "</span></td>";
                for (var n = 0; n < s.length; n++) s[n] > 0 ? 0 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>0:8</span></td>" : 1 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>1:7</span></td>" : 2 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>2:6</span></td>" : 3 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>3:5</span></td>" : 4 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>4:4</span></td>" : 5 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>5:3</span></td>" : 6 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>6:2</span></td>" : 7 == n ? l += "<td class='hot'><span name='hotSpan' class='hot_squred'>7:1</span></td>" : 8 == n && (l += "<td class='hot'><span name='hotSpan' class='hot_squred'>8:0</span></td>") : l += " <td><span>" + Math.abs(s[n]) + "</span></td>";
                l += "</tr>"
            }), $(".table_qyb table tbody").html(l), $(".danshuangzsfen .righttablepld table tfoot>tr:not([class])").remove(), $(".danshuangzsfen .table_qyb table tfoot>tr:not([class])").remove(), dxzsfootarrpl = a.title, dansfoothtml = "", danszsfoothtml = "";
            for (var n = dxzsfootarrpl.appearCount.slice(0, 16), i = dxzsfootarrpl.averageMissingValues.slice(0, 16), o = dxzsfootarrpl.maxAppearValues.slice(0, 16), d = dxzsfootarrpl.maxMissingValues.slice(0, 16), r = dxzsfootarrpl.appearCount.slice(16), c = dxzsfootarrpl.averageMissingValues.slice(16), h = dxzsfootarrpl.maxAppearValues.slice(16), u = dxzsfootarrpl.maxMissingValues.slice(16), p = "<tr>", f = "<tr>", b = "<tr>", _ = "<tr>", g = "<tr><td colspan='2'>出现次数</td>", m = "<tr><td colspan='2'>平均遗漏</td>", v = "<tr><td colspan='2'>最大连出</td>", z = "<tr><td colspan='2'>最大遗漏</td>", x = 0; x < n.length; x++) p += "<td>" + n[x] + "</td>", f += "<td>" + i[x] + "</td>", b += "<td>" + o[x] + "</td>", _ += "<td>" + Math.abs(d[x]) + "</td>";
            for (var y = 0; y < r.length; y++) g += "<td>" + r[y] + "</td>", m += "<td>" + c[y] + "</td>", v += "<td>" + h[y] + "</td>", z += "<td>" + Math.abs(u[y]) + "</td>";
            var w = "</tr>";
            dansfoothtml = p + w + f + w + b + w + _ + w, danszsfoothtml = g + w + m + w + v + w + z + w, $(".danshuangzsfen .righttablepld table tfoot>tr:last-child").after(dansfoothtml), $(".danshuangzsfen .table_qyb table tfoot>tr:last-child").after(danszsfoothtml), orshow_danszs()
        }
    }, lishmtj: {
        getlishmtj: function (t) {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "klsf/queryHistoryDataForDrawCode.do",
                data: {lotCode: lotCode},
                success: function (t) {
                    shifenFunObj.lishmtj.addlishmtj(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addlishmtj: function (t) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var a = data.result.data;
            $("#table_riqi tbody tr").remove(), $("#table_lishihmtj tbody tr").remove(), $("#xingtai_le tbody tr").remove();
            var s = "";
            $(a).each(function (t, a) {
                if (10055 == lotCode) e = config.showrows; else var e = 200;
                if (t >= e) return !1;
                var l = "<tr class='hmck'>", n = this.date, i = this.dataArrays.slice(0, 20);
                s += "<tr class='qishutr'><td>" + n + "</td></tr>", $(i).each(function (t) {
                    l += this > 0 ? "<td >" + this + "</td>" : "<td>" + Math.abs(this) + "</td>"
                }), l += "</tr>", $(".lishiDate table tbody").append(l)
            }), $("#table_riqi tbody").append(s), $(".lishihaomatj #xingtai_ck").html("");
            var e = "";
            e += "<table id='xingtai_le' border='0' cellspacing='1' cellpadding='10'><thead><tr><th style='width: 18%;'>日期</th><th>单</th>", e += "<th>双</th><th>大</th><th>小</th><th>龙</th><th>虎</th></tr></thead><body>", $(a).each(function (t, a) {
                var s = this.date, l = this.dataArrays.slice(20, 26);
                e += "<tr><td>" + s + "</td>";
                for (var t = 0; t < l.length; t++) 1 * l[t] >= 0 ? e += "<td>" + l[t] + "</td>" : html_top += "<td>" + Math.abs(l[t]) + "</td>";
                e += "</tr>"
            }), e += "</body></table>", $(".lishihaomatj #xingtai_ck").html(e)
        }
    }
}, klsftabledata = [];
$(".jbzslodiv").on("click", "span", function (t) {
    $("canvas").remove();
    var a = $(this), s = klsftabledata.length, e = 1 * $(this).parent().attr("data-text");
    "jbzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "jbzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachconten_jbzshtml(klsftabledata[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500), orshowConten()
}), $(".daxiaozslodiv").on("click", "span", function (t) {
    $("canvas").remove();
    var a = $(this), s = klsftabledata.length, e = 1 * $(this).parent().attr("data-text");
    "jbzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "jbzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachcontentdaxiazs(klsftabledata[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500), orshowConten_daxizs()
}), $(".danxuzslodiv").on("click", "span", function (t) {
    $("canvas").remove();
    var a = $(this), s = klsftabledata.length, e = 1 * $(this).parent().attr("data-text");
    "jbzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "jbzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachcontentdanxuzs(klsftabledata[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500), orshow_danszs()
});
var fastClickDate = {today_lz: 0, yestoday_lz: -1, qitian_lz: -2};
$(".checkday").on("click", "span", function () {
    var t = $(this), a = "", s = this.classList[0];
    t.addClass("checkspan").siblings().removeClass("checkspan");
    var e = fastClickDate[s];
    if (!t.hasClass("checkclick_date") && !t.hasClass("screen")) {
        a = getDateStr(e, !0), t.siblings(".time_select").text(a);
        var l = $(".title_se_box .se_check").attr("target");
        l = (l = $("#" + l + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_shifen(l, a, ""), tools.revertHmfb()
    }
});
var condition_wz_mc = [{
        data: [{value: "第一球", id: "1"}, {value: "第二球", id: "2"}, {value: "第三球", id: "3"}, {
            value: "第四球",
            id: "4"
        }, {value: "第五球", id: "5"}, {value: "第六球", id: "6"}, {value: "第七球", id: "7"}, {value: "第八球", id: "8"}, {
            value: "总和",
            id: "9"
        }]
    }], mrcltj_val = [0], initTiaojian = new MobileSelect({
        trigger: ".meiri_qius",
        title: "选择名次",
        wheels: condition_wz_mc,
        position: mrcltj_val,
        callback: function (t, a, s) {
            mrcltj_val[0] = 1 * a[0].id;
            var e = 1 * $("#meiri_tj ul .meiriLiAct i").text();
            shifenFunObj.meiritj.getmeiritj(e, mrcltj_val[0] || 1)
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : mrcltj_val, s = 0; s < mrcltj_val.length; s++) t.locatePosition(s, a[s])
        }
    }), zfblz_mc = [{
        data: [{name: "第一球", value: "ball_1"}, {name: "第二球", value: "ball_2"}, {
            name: "第三球",
            value: "ball_3"
        }, {name: "第四球", value: "ball_4"}, {name: "第五球", value: "ball_5"}, {name: "第六球", value: "ball_6"}, {
            name: "第七球",
            value: "ball_7"
        }, {name: "第八球", value: "ball_8"}]
    }], initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8"]
        }, trigger: ".zhongfabai_lz", title: "选择条件", wheels: zfblz_mc, callback: function (t, a, s) {
            zonghe_listitem()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), condition_wzzs = [{
        data: [{name: "遗漏", value: "yilo"}, {name: "拆线", value: "caix"}, {
            name: "遗漏分层",
            value: "fancong"
        }, {name: "分割线", value: "fgx"}]
    }], initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".yixuan", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), condition_wz_qs = [{data: [{value: "近30期", id: "30"}, {value: "近60期", id: "60"}, {value: "近90期", id: "90"}]}],
    jbzs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".jbzzs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: jbzs_qs_val,
        callback: function (t, a, s) {
            jbzs_qs_val[0] = 1 * a[0].id, shifenFunObj.jibendata.getjibenzs("", jbzs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : jbzs_qs_val, s = 0; s < jbzs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8"]
        }, trigger: ".heshudslzpl_lz", title: "选择球号", wheels: zfblz_mc, callback: function (t, a, s) {
            heshu_list()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8"]
        }, trigger: ".weishuluzhu_lz", title: "选择球号", wheels: zfblz_mc, callback: function (t, a, s) {
            weishulz_list()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), lhlz_mc = [{
        data: [{name: "第一球", value: "ball_1"}, {name: "第二球", value: "ball_2"}, {
            name: "第三球",
            value: "ball_3"
        }, {name: "第四球", value: "ball_4"}]
    }], initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["ball_1", "ball_2", "ball_3", "ball_4"]
        }, trigger: ".longhu_lz", title: "选择球号", wheels: lhlz_mc, callback: function (t, a, s) {
            longhu_list()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8"]
        }, trigger: ".dansdxlz_lz", title: "选择球号", wheels: zfblz_mc, callback: function (t, a, s) {
            dansdxlz_list()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), dxdxlz_qs = [{data: [{value: "大小", id: "daxiaoShow"}, {value: "单双", id: "danshuangShow"}]}], dxdxlz_val = [0],
    initTiaojian = new MobileSelect({
        trigger: ".dansdxlz_xs",
        title: "筛选数据",
        wheels: dxdxlz_qs,
        position: dxdxlz_val,
        callback: function (t, a, s) {
            dxdxlz_val[0] = a[0].id, dansdxlz_list()
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dxdxlz_val, s = 0; s < dxdxlz_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8"]
        }, trigger: ".dongnanxbpl_lz", title: "选择球号", wheels: zfblz_mc, callback: function (t, a, s) {
            dongnxb_list()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".tiaojian_daxiaozs", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten_daxizs()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), dxzs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".daxiaozs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: dxzs_qs_val,
        callback: function (t, a, s) {
            dxzs_qs_val[0] = 1 * a[0].id, shifenFunObj.dxzs.getdata("", dxzs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dxzs_qs_val, s = 0; s < dxzs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".tiaojian_danshuangzs", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshow_danszs()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), danxzs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".danxuzs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: danxzs_qs_val,
        callback: function (t, a, s) {
            danxzs_qs_val[0] = 1 * a[0].id, shifenFunObj.dszs.getdszs("", danxzs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : danxzs_qs_val, s = 0; s < danxzs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), condition_dxms_mc = [{
        data: [{value: "第一球", id: "ball_1"}, {value: "第二球", id: "ball_2"}, {
            value: "第三球",
            id: "ball_3"
        }, {value: "第四球", id: "ball_4"}, {value: "第五球", id: "ball_5"}, {value: "第六球", id: "ball_6"}, {
            value: "第七球",
            id: "ball_7"
        }, {value: "第八球", id: "ball_8"}, {value: "总和", id: "ball_9"}]
    }], condition_zh_lz = [{
        data: [{name: "大小", value: "daxiaoShow"}, {name: "单双", value: "danshuangShow"}, {
            name: "龙虎",
            value: "longhuShow"
        }, {name: "尾数大小", value: "weishudxShow"}, {name: "合数单双", value: "heshudsShow"}, {
            name: "中发白",
            value: "zhongfbShow"
        }, {name: "方位", value: "fangweiShow"}]
    }], condition_zh_mc = [{
        data: [{name: "第一球", value: "ball_1"}, {name: "第二球", value: "ball_2"}, {
            name: "第三球",
            value: "ball_3"
        }, {name: "第四球", value: "ball_4"}, {name: "第五球", value: "ball_5"}, {name: "第六球", value: "ball_6"}, {
            name: "第七球",
            value: "ball_7"
        }, {name: "第八球", value: "ball_8"}, {name: "总和", value: "ball_9"}]
    }], condition_lmms_lz = [{
        data: [{value: "大小", id: "daxiaoShow"}, {value: "单双", id: "danshuangShow"}, {
            value: "龙虎",
            id: "longhuShow"
        }, {value: "尾数大小", id: "weishudxShow"}, {value: "合数单双", id: "heshudsShow"}, {
            value: "中发白",
            id: "zhongfbShow"
        }, {value: "方位", id: "fangweiShow"}]
    }], lzcheckObj = {
        zhms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8", "ball_9"],
            select_arr2: ["daxiaoShow", "danshuangShow", "longhuShow", "weishudxShow", "heshudsShow", "zhongfbShow", "fangweiShow"]
        },
        dxms: {
            checkIndex: [0],
            checkVal: ["ball_1"],
            checkVal_cn: "第一球",
            select_arr2: ["daxiaoShow", "danshuangShow", "longhuShow", "weishudxShow", "heshudsShow", "zhongfbShow", "fangweiShow"]
        },
        lmms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8", "ball_9"],
            checkIndex: [0],
            checkVal: ["daxiaoShow"],
            checkVal_cn: "大小"
        }
    };
$(".luzhufx  .Pattern").on("click", "span", function () {
    var t = $(this);
    t.addClass("checkspan").siblings().removeClass("checkspan"), $("#F_checklz_lz_mc").parents(".mobileSelect").remove(), $("#F_checkclick_lz").parents(".mobileSelect").remove(), t.hasClass("zonghums") ? lzfxzhms() : t.hasClass("danxuanms") ? lzfxdxms() : lzfxlmms()
}), $(".danshuangdaxiaols .Pattern").on("click", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan")
});