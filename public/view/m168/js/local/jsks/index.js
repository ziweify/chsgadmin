function iframe() {
    var t = $(".animate").width(), a = 780 * t / 1125, s = t / 1125;
    setTimeout(function () {
        $(".animate iframe").contents().find("html").css("zoom", s);
        $(".animate iframe").contents().find(".container").height();
        $(".animate").animate({height: a + 50}, 600), $(".animate iframe").animate({height: a + 50}, 600), $(".content").animate({height: a + 35}, 600)
    }, 1), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("#preloader").fadeOut("slow")
    }, 1e3)
}

function startVideo() {
    $("#videoiframe").attr('src',config.videourl+"view/video/kuai3_video/Kuai3.html?"+lotCode);
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        var t = 880 * $(".animate").width() / 1310;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            //iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
        })
    })
}

function createData() {
    var t, a, s, e, n, i = $("#pk10num").find("li"), o = [];
    $(i).each(function (t) {
        var a = $(this).attr("class").substr(3, 1);
        o.push(a)
    }), t = $(".longhu").find("li").eq(1).text(), a = $(".longhu").find("li").eq(3).text(), n = $(".preDrawIssue").text(), e = $(".drawTime").val(), s = $(".drawIssue").val();
    var l = $("#headerData").find(".hour").text(), d = $("#headerData").find(".minute").text(),
        h = $("#headerData").find(".second").text();
    return {
        preDrawCode: o,
        sumNum: t,
        sumBigSmall: a,
        drawIssue: s,
        preDrawIssue: n,
        drawTime: e,
        time: 60 * l * 60 + 60 * d + 1 * h
    }
}

function throttle(t, a, s) {
    var e, n = +new Date;
    return function () {
        var i = +new Date, o = this, l = arguments;
        clearTimeout(e), i - n >= s ? (t.apply(o, l), n = i) : e = setTimeout(function () {
            t.apply(o, l)
        }, a)
    }
}

function createHtmlStr(t, a) {
    var s = "";
    $(t).each(function () {
        s += '<div class="listotherline bortop001 ssclist">', s += '<div class="leftspan">', s += '<span class="boxflex">';
        var t = this.preDrawTime;
        t = t.substring(t.length - 8, t.length - 3), s += '<span class="graytime">' + t + "</span>", s += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", s += "</span>", s += "</div>", s += '<div class="rightspan">', s += '<div class="rightdiv padl0">', s += '<div class="haomali"><ul id="" class="pk10li kuaisanlist haomali numul">';
        var a = this.preDrawCode.split(",");
        if ($(a).each(function (t) {
            t == a.length - 1 ? s += '<li class="num' + this + ' li_after"><i>' + this + "</i></li>" : s += '<li class="num' + this + '"><i>' + this + "</i></li>"
        }), !(a.length <= 1)) var e = tools.typeOf("dxtc", this.sumBigSmall),
            n = "0" == this.sumSingleDouble ? "单" : "2" == this.sumSingleDouble ? "通吃" : "双";
        var i = "大" == e ? "style='color:#f12d35'" : "", o = "双" == n ? "style='color:#f12d35'" : "";
        s += "<li>" + this.sumNum + "</li>", s += "<li " + i + ">" + e + "</li>", s += "<li " + o + ">" + n + "</li>";
        var l = tools.typeOf("seafood", this.firstSeafood), d = tools.typeOf("seafood", this.secondSeafood),
            h = tools.typeOf("seafood", this.thirdSeafood);
        "1" == l ? l = "鱼" : "2" == l ? l = "虾" : "3" == l ? l = "葫芦" : "4" == l ? l = "金钱" : "5" == l ? l = "蟹" : "6" == l && (l = "鸡"), "1" == d ? d = "鱼" : "2" == d ? d = "虾" : "3" == d ? d = "葫芦" : "4" == d ? d = "金钱" : "5" == d ? d = "蟹" : "6" == d && (d = "鸡"), "1" == h ? h = "鱼" : "2" == h ? h = "虾" : "3" == h ? h = "葫芦" : "4" == h ? h = "金钱" : "5" == h ? h = "蟹" : "6" == h && (h = "鸡"), s += "<li >" + l + "</li>", s += "<li >" + d + "</li>", s += "<li >" + h + "</li>", s += "</ul></div>", s += "</div>", s += "</div>", s += "</div>"
    }), "string" == typeof a ? $(a).append(s) : a.forEach(function (t) {
        return $(t).append(s)
    })
}

function checkhmqhlzHm() {
    var t = $("#haomalzmcul").find(".kuaisanct");
    $(".lz_title").hide(), $(t).each(function (t, a) {
        var s = "#" + $(a).attr("value");
        $(s).show()
    })
}

function fancongshow() {
    for (var t = $(".table_dingwezs tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function orshowConten() {
    if ($("#F_tiaojian li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.kuaisandingweiLine("trend_ding"), chartOfBaseTrend.kuaisandaxiaoLine("trend_ding"), chartOfBaseTrend.kuaisandanshuangLine("trend_ding")
    }, 500) : $(".table_conBox canvas").hide(), $("#F_tiaojian li[data-value='fancong']").hasClass("check_tj") ? fancongshow() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_tiaojian li[data-value='yilo']").hasClass("check_tj") ? ($("td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), $("#F_tiaojian li[data-value='fgx']").hasClass("check_tj")) {
        $(".line_wzzs").remove();
        for (var t = $("#trend_ding tbody tr"), a = 4; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>")
    } else $(".line_wzzs").remove()
}

function daxiaoshow() {
    for (var t = $("#table_daxiao tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function daxiaoshowpl() {
    for (var t = $("#table_daxiaotop tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function daxiaoConten() {
    if ($("#F_yixuan li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        if (document.body.offsetWidth > 320) t = 1.5; else var t = 2;
        var a = $("#table_daxiao tbody tr:first").height() * t;
        $("canvas").remove(), chartOfBaseTrend.kuaisansizeLine("table_daxiao"), chartOfBaseTrend.kuaisansizexiaoLine("table_daxiao"), setTimeout(function () {
            $("canvas").each(function () {
                $(this).css("top", 1 * $(this).css("top").replace("px", "") - a + "px")
            })
        }, 10)
    }, 500) : $("#daxiaoBox canvas").hide(), $("#F_yixuan li[data-value='fancong']").hasClass("check_tj") ? $(".daxiaogeshu_noe").hasClass("checkspan") ? daxiaoshow() : daxiaoshowpl() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_yixuan li[data-value='yilo']").hasClass("check_tj") ? ($("td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), $("#F_yixuan li[data-value='fgx']").hasClass("check_tj")) {
        if ($(".daxiaogeshu_noe").hasClass("checkspan")) t = $("#table_daxiao tbody tr"); else var t = $("#table_daxiaotop tbody tr");
        $(".line_wzzs").remove();
        for (var a = 4; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs'><td></td></tr>")
    } else $(".line_wzzs").remove()
}

function hezhiplshow() {
    for (var t = $("#table_hezhi tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function hezhiplshowpl() {
    for (var t = $("#table_danxuanon tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 3; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot") || i.hasClass("hotp")) break;
        i.addClass("fancongcls")
    }
}

function hezhiConten() {
    if ($("#F_kjdsbskj li[data-value='caix']").hasClass("check_tj") ? setTimeout(function () {
        if ($(".qianhuan_noe").hasClass("checkspan")) {
            t = .7 * $("#hezhiBox_noe tbody tr:first").height();
            $("canvas").remove(), chartOfBaseTrend.kuaisanzongheLine("table_hezhi"), setTimeout(function () {
                $("canvas").each(function () {
                    $(this).css("top", 1 * $(this).css("top").replace("px", "") + t + "px")
                })
            }, 10)
        } else {
            var t = .55 * $("#hezhiBox_top tbody tr:first").height();
            $(" canvas").remove(), chartOfBaseTrend.kuaisandanxuandaLine("table_danxuanon"), chartOfBaseTrend.kuaisandanxuandanLine("table_danxuanon"), setTimeout(function () {
                $("canvas").each(function () {
                    $(this).css("top", 1 * $(this).css("top").replace("px", "") + t + "px")
                })
            }, 10)
        }
    }, 500) : $(".hezhizspl canvas").hide(), $("#F_kjdsbskj li[data-value='fancong']").hasClass("check_tj") ? $(".qianhuan_noe").hasClass("checkspan") ? hezhiplshow() : hezhiplshowpl() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_kjdsbskj li[data-value='yilo']").hasClass("check_tj") ? ($("td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), $("#F_kjdsbskj li[data-value='fgx']").hasClass("check_tj")) {
        if ($(".qianhuan_noe").hasClass("checkspan")) t = $("#table_hezhi tbody tr"); else var t = $("#table_danxuanon tbody tr");
        $(".line_wzzs").remove();
        for (var a = 4; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs' style='height: auto;'><td style='height: auto;'></td></tr>")
    } else $(".line_wzzs").remove()
}

function jibneshow() {
    for (var t = $("#table_jiben tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function jibenConten() {
    if ($("#bengrot_wzze .caix").hasClass("check_tj") || $("#jibenzsBox canvas").hide(), $("#bengrot_wzze .fancong").hasClass("check_tj") ? jibneshow() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#bengrot_wzze .yilo").hasClass("check_tj") ? ($("td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), $("#bengrot_wzze .fgx").hasClass("check_tj")) {
        var t = $("#table_jiben tbody tr");
        $(".line_wzzs").remove();
        for (var a = 4; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs' style='height: auto;'><td style='height: auto;'></td></tr>")
    } else $(".line_wzzs").remove()
}

function qiyueshow() {
    for (var t = $("#table_qiyu tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function qiyueshowtop() {
    for (var t = $("#table_qiyutop tbody tr"), a = (t = t.slice(0, t.length - 6)).length, s = t.filter(":first").children("td").size(), e = 2; e < s; e++) for (var n = 0; n <= a; n++) {
        var i = t.eq(n).children("td").eq(e);
        if (i.hasClass("hot")) break;
        i.addClass("fancongcls")
    }
}

function qiyuConten() {
    if ($("#F_tiaojianyu li[data-value='caix']").hasClass("check_tj") ? $(".Pattern_noe").hasClass("checkspan") && ($(".qiyuzs canvas").remove(), setTimeout(function () {
        var t = .5 * $("#table_qiyu tbody tr:first").height();
        $("canvas").remove(), chartOfBaseTrend.kuaisansizeLine("table_qiyu"), chartOfBaseTrend.kuaisansizexiaoLine("table_qiyu"), setTimeout(function () {
            $("canvas").each(function () {
                $(this).css("top", 1 * $(this).css("top").replace("px", "") + t + "px")
            })
        }, 10)
    }, 500)) : $("#qiyuzsBox canvas").hide(), $("#F_tiaojianyu li[data-value='fancong']").hasClass("check_tj") ? $(".Pattern_noe").hasClass("checkspan") ? qiyueshow() : qiyueshowtop() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), $("#F_tiaojianyu li[data-value='yilo']").hasClass("check_tj") ? ($("td").find("span").show(), $(".showspan span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), $("#F_tiaojianyu li[data-value='fgx']").hasClass("check_tj")) {
        if ($(".Pattern_noe").hasClass("checkspan")) t = $("#table_qiyu tbody tr"); else var t = $("#table_qiyutop tbody tr");
        $(".line_wzzs").remove();
        for (var a = 4; a < t.length - 6; a += 5) $(t[a]).after("<tr class='line_wzzs' style='height: auto;'><td style='height: auto;'></td></tr>")
    } else $(".line_wzzs").remove()
}

function showExplain_smwf() {
    $(".explian_shows").css({height: $("body").height(), top: "0"})
}

function hideExplain_smwf() {
    $(".explian_shows").css({height: "0", top: "-20rem"})
}

function listettablearr(t) {
    t.length <= config.showrows ? ($(".lomorediv").hide(), $(".footer_up").css("margin-top", "0rem")) : ($(".lomorediv").show(), $(".nextlo").show(), $(".footer_up").css("margin-top", "0.2rem")), jskstabledata = [];
    for (var a = 0, s = Math.ceil(t.length / config.showrows); a < s; a++) {
        var e = [];
        e.push(t.slice(a * config.showrows, (a + 1) * config.showrows)), jskstabledata.push(e)
    }
    $(".prevlo").hide().parent().attr("data-text", 0)
}

function eachcontent_dwzs(t) {
    var a = wz_mc_val[0] || 0;
    $(".locationzs #chartLinediv table tbody").html("");
    var s = "<tr>";
    $(t).each(function (t) {
        if (0 == a) e = "oneCode"; else if (1 == a) e = "twoCode"; else var e = "threeCode";
        for (var n = this.drawCode, i = this[e], o = "", l = 0; l < n.length; l++) o += l == a ? "<span style='color:red'>" + n[l] + "</span>&nbsp;" : "<span>" + n[l] + "</span>&nbsp;";
        s += " <td>" + this.preIssue.toString().split(n) + "</td><td class='tabred'>" + o + "</td>";
        for (var d = 0; d < i.length; d++) 1 * i[d] > 0 || 1 * i[d] == 0 ? d < 6 ? s += "<td class='hot ding'><span name='hotSpan'>" + i[d] + "</span></td>" : 6 == d ? s += "<td class='hot pol'><span name='hotSpan'>大</span></td>" : 7 == d ? s += "<td class='hot pol'><span name='hotSpan'>小</span></td>" : 8 == d ? s += "<td class='hot'><span name='hotSpan'>单</span></td>" : 9 == d && (s += "<td class='hot'><span name='hotSpan'>双</span></td>") : s += d < 6 ? "<td style='background: #fdf7ed;'><span>" + Math.abs(i[d]) + "</span></td>" : "<td><span>" + Math.abs(i[d]) + "</span></td>";
        s += "</tr>"
    }), $(".locationzs #chartLinediv table tbody").html(s + dwzsfooter), $("canvas").remove(), orshowConten()
}

function eachdxzsdxgs(t) {
    $("#table_daxiao tbody").empty();
    var a = "<tr>";
    $(t).each(function (t) {
        var s = this.drawCode, e = this.numberDistribution, n = this.bigNumber, i = this.smallNumber, o = 0;
        a += " <td>" + (this.preIssue.toString().length > 5 ? this.preIssue.toString().slice(this.preIssue.toString().length - 5) : this.preIssue) + "</td><td class='tabred'><span>" + s.join(" ") + "</span></td>", 1 * s[1] == s[0] && 1 * s[1] == 1 * s[2] ? o = 3 : 1 * s[1] != s[0] && 1 * s[1] != 1 * s[2] || (o = 2);
        for (var l = 0; l < e.length; l++) 1 * e[l] > 0 || 1 * e[l] == 0 ? 1 * e[l] == 1 * s[1] && 0 != o ? a += "<td class='hot da'><span name='hotSpan'>" + e[l] + "<i class='smallQiu'>" + o + "</i></span></td>" : a += "<td class='hot da'><span name='hotSpan'>" + e[l] + "</span></td>" : a += "<td style='background: #fdf7ed;'><span>" + Math.abs(e[l]) + "</span></td>";
        for (var d = 0; d < n.length; d++) 1 * n[d] > 0 || 1 * n[d] == 0 ? a += "<td class='hot pol'><span name='hotSpan'>" + n[d] + "</span></td>" : a += "<td><span>" + Math.abs(n[d]) + "</span></td>";
        for (var h = 0; h < i.length; h++) 1 * i[h] > 0 || 1 * i[h] == 0 ? a += "<td class='hot da'><span name='hotSpan'>" + i[h] + "</span></td>" : a += "<td style='background: #fdf7ed;'><span>" + Math.abs(i[h]) + "</span></td>";
        a += "</tr>"
    }), a += dxzsdxgsfooter, $("#table_daxiao tbody").html(a)
}

function eachhzzs_s(t) {
    $(".hezhizspl #hezhiBox_noe #table_hezhi tbody").empty();
    var a = "<tr>";
    $(t).each(function (t) {
        if (10052 == lotCode) s = config.showrows; else var s = 200;
        if (t >= s) return !1;
        var e = this.sumTotal, n = this.sumNum.slice(0, 16);
        this.preIssue.toString().length > 5 && (this.preIssue = this.preIssue.toString().slice(3)), a += " <td>" + this.preIssue + "</td><td class='tabred'><span class='yanse' style='color: #E90009;'>" + e + "</span></td>";
        for (var i = 0; i < n.length; i++) 1 * n[i] >= 0 ? a += "<td class='hot'><span name='hotSpan'>" + n[i] + "</span></td>" : a += "<td><span>" + Math.abs(n[i]) + "</span></td>";
        a += "</tr>"
    }), $(".hezhizspl #hezhiBox_noe #table_hezhi tbody").html(a + hzzs_hzzsfooter)
}

function eachhzzs_st(t) {
    $(".hezhizspl #hezhiBox_top #table_danxuanon tbody").empty();
    var a = "<tr>";
    $(t).each(function (t) {
        var s = this.drawCode, e = this.sumTotal, n = this.sumNum.slice(16, 20);
        a += " <td>" + this.preIssue + "</td><td class='tabred'><span class='yanse'>" + s.join(" ") + "</span></td><td><span style='color: #E90009;'>" + e + "</span></td>";
        for (var i = 0; i < n.length; i++) 1 * n[i] >= 0 ? a += 4 == i ? "<td class='zhilinst'><span name='hotSpan'>" + n[i] + "</span></td>" : i <= 0 ? "<td class='hot'><span name='hotSpan'>大</span></td>" : i <= 1 ? "<td class='hot'><span name='hotSpan'>小</span></td>" : i <= 2 ? "<td class='hotp'><span name='hotSpan'>单</span></td>" : "<td class='hotp'><span name='hotSpan'>双</span></td>" : a += "<td><span>" + Math.abs(n[i]) + "</span></td>";
        a += "</tr>"
    }), $(".hezhizspl #hezhiBox_top #table_danxuanon tbody").html(a + hzzs_hzstfooter)
}

function eachjozs_gs(t) {
    $("#qiyuzsBox table tbody").empty();
    var a = "<tr>";
    $(t).each(function (t) {
        var s = this.drawCode, e = this.numberDistribution, n = this.oddNumber, i = this.evenNumber, o = 0;
        this.preIssue.toString().length > 5 && (this.preIssue = this.preIssue.toString().slice(3)), a += " <td>" + this.preIssue + "</td><td class='tabred'><span>" + s.join(" ") + "</span></td>", 1 * s[1] == s[0] && 1 * s[1] == 1 * s[2] ? o = 3 : 1 * s[1] != s[0] && 1 * s[1] != 1 * s[2] || (o = 2);
        for (var l = 0; l < e.length; l++) 1 * e[l] > 0 || 1 * e[l] == 0 ? 1 * e[l] == 1 * s[1] && 0 != o ? a += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + e[l] + "<i class='smallQiu'>" + o + "</i></span></td>" : a += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + e[l] + "</span></td>" : a += l < 6 ? "<td style='background: #fdf7ed;'><span>" + Math.abs(e[l]) + "</span></td>" : "<td><span>" + Math.abs(e[l]) + "</span></td>";
        for (var d = 0; d < n.length; d++) 1 * n[d] > 0 || 1 * n[d] == 0 ? a += "<td class='hot pol'><span name='hotSpan'>" + n[d] + "</span></td>" : a += "<td><span>" + Math.abs(n[d]) + "</span></td>";
        for (var h = 0; h < i.length; h++) 1 * i[h] > 0 || 1 * i[h] == 0 ? a += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + i[h] + "</span></td>" : a += "<td style='background: #fdf7ed;'><span>" + Math.abs(i[h]) + "</span></td>";
        a += "</tr>"
    }), $("#qiyuzsBox table tbody").html(a + jozs_jogsfooter)
}

function checkDateFun(t, a) {
    a = void 0 == a ? "" : a;
    var s = $(".title_se_box .se_check").attr("target");
    s = (s = $("#" + s + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_kuai(s, t, a)
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
}, ifishad = !1;
$(function () {
    pubmethod.initAdata(), method.indexLoad(boxId, lotCode), ifishad = !0;
    $("#startVideo").on("touchstart", function () {
        startVideo()
    }), document.addEventListener("click", function () {
        //$("iframe")[0].contentWindow.ifopen && $("iframe")[0].contentWindow.k3v.sound.play("audioidB")
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-200%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"});
            $("#videoiframe").attr('src',"");
        })
    }), method.loadOther(""), setTimeout(function () {
        config.ifFirstLoad = !0
    }, 4e3)
}), function () {
    tools.initDate();
    var t = "number" == typeof window.orientation && "object" === _typeof(window.onorientationchange);
    window.addEventListener("DOMContentLoaded", function () {
        document.body.parentNode;
        var a, s = function () {
            t && (a = window.orientation, "0px" == $("#videobox").find(".content").css("top") && (startVideo(), $("iframe")[0].contentWindow.ifopen = !0, $("iframe")[0].contentWindow.k3v.stopVideo(createData())))
        };
        t ? window.addEventListener("orientationchange", s, !1) : window.addEventListener("resize", s, !1), s()
    }, !1)
}();
var method = {};
method.loadOther = function (t) {
    if ("" != t || tools.ifOnDay()) {
        var a = $(".headTitle .checkedbl").attr("id");
        tools.classGetDate_kuai(a, t, "")
    }
}, method.indexLoad = function (t) {
    var a = $(t).find(".nextIssue").val(), t = "#" + $(t).attr("id");
    headMethod.loadHeadData(a, t)
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "lotteryJSFastThree/getJSFastThreeList.do?date=" + t,
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
}, method.createHtmlList = function (t) {
    var a = null;
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode && 0 == a.result.businessCode) {
        if (0 == (a = a.result.data).length) return void tools.weikaiji("#numlist");
        scrollRender.init(a), tools.replaceUnde($(".kuaisanlist").find("li"))
    }
};
var scrollRender = {
    init: function (t) {
        var a = this;
        this.data = t, this.once = 200, this.contArr = ["#numlist"], this.contArr.forEach(function (s) {
            $(s).empty(), a[s] = {curIndex: 0, totalPage: Math.ceil(t.length / a.once) - 1}
        }), "haomafb" === $("#allSele .checkedbl").attr("id") ? this.parentClass = "#haomafblist" : this.parentClass = "#numlist", createHtmlStr(t.slice(this[this.parentClass].curIndex, this.once), this.contArr), this.watchDom = $(this.parentClass + " .ssclist:last-child")[0], $(window).off("scroll").on("scroll", throttle(this.scrollCb.bind(this), 400, 1e3))
    }, scrollCb: function () {
        if (!this.scrollFlag && this.watchDom.getBoundingClientRect().top < window.screen.height + 200) {
            var t = this[this.parentClass];
            0 === t.totalPage && (this.watchDom = null, $(window).off("scroll")), this.scrollFlag = !0, t.curIndex = t.curIndex + this.once, createHtmlStr(this.data.slice(t.curIndex, t.curIndex + this.once), this.parentClass), this.watchDom = $(this.parentClass + " .ssclist:last-child")[0], --t.totalPage, this.scrollFlag = !1
        }
    }
};
method.selectedBS = function (t, a) {
    var s = $(t).attr("id");
    $(t).siblings().removeClass("spanchecked"), a || $(t).addClass("spanchecked"), "gjlh" == s ? ($("#numlist .haomali").removeClass("displayblock").addClass("displaynone"), $("#numlist .longhuli").removeClass("displaynone").addClass("displayblock")) : ($("#numlist .haomali").removeClass("displaynone").addClass("displayblock"), $("#numlist .longhuli").removeClass("displayblock").addClass("displaynone")), $("#numlist .haomali li").each(function (t) {
        var a = $(this).text(), e = a % 2 == 0, n = a >= 6;
        "xshm" == s ? ($(this).removeClass(), $(this).addClass("num" + $(this).find("i").text()), $(this).find("i").hide()) : "xsdx" == s ? ($(this).find("i").hide(), $(this).removeClass(), n ? ($(this).addClass("numbig"), $(this).css({"background-position-x": "-0.026rem"}), (t + 1) % 10 == 0 && $(this).addClass("numbig")) : ($(this).css({"background-position-x": "-0.331rem"}), $(this).addClass("numsm"), (t + 1) % 10 == 0 && $(this).addClass("numsm"))) : "xsds" == s && ($(this).find("i").hide(), $(this).removeClass(), e ? ($(this).css({"background-position-x": "-0.626rem"}), $(this).addClass("nums"), (t + 1) % 10 == 0 && $(this).addClass("nums")) : ($(this).css({"background-position-x": "-0.93rem"}), $(this).addClass("numd"), (t + 1) % 10 == 0 && $(this).addClass("numd")))
    })
}, $("#haomalzmcul").find("li").on("click", function () {
    $(this).toggleClass("kuaisanct"), checkhmqhlzHm()
}), $(".locationzs .table_dingwei").on("click", "p>span", function () {
    var t = $(this).attr("class");
    "diyiwei" == t ? $("#rank_wzzs").addClass("gotop") : "shjian" == t ? $("#periods_wzzs").addClass("gotop") : "tiaojian" == t && $("#tiaojian_wzzs").addClass("gotop"), $(".gotop").css("height", $("body").height() + "px")
}), $(".qiyu").on("touchstart", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $(this).hasClass("Pattern_pl") ? ($("#table_qiyu canvas").remove(), qiyuConten(), $("#qiyuzsBox").css("display", "none"), $("#qiyuzsBoxtop").css("display", "block")) : ($("#table_qiyutop canvas").remove(), qiyuConten(), $("#qiyuzsBox").css("display", "block"), $("#qiyuzsBoxtop").css("display", "none"))
}), $(".daxiaopl").on("touchstart", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $(this).hasClass("daxiaogeshu_noe") ? ($("#table_daxiao canvas").remove(), daxiaoConten(), $("#daxiaoBox").css("display", "block"), $("#daxiaoBoxtop").css("display", "none")) : ($("#table_daxiaotop canvas").remove(), daxiaoConten(), $("#daxiaoBox").css("display", "none"), $("#daxiaoBoxtop").css("display", "block"))
}), $(".qianhuan_pl").on("touchstart", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $(this).hasClass("qianhuan_noe") ? ($("canvas").remove(), hezhiConten(), $("#hezhiBox_noe").css("display", "block"), $("#hezhiBox_top").css("display", "none")) : ($("canvas").remove(), hezhiConten(), $("#hezhiBox_noe").css("display", "none"), $("#hezhiBox_top").css("display", "block"))
}), $("#explainBtn_plok").on("touchstart", function () {
    showExplain_smwf()
}), $(".closesm").on("click", function () {
    hideExplain_smwf()
});
var dwzsfooter = "", dxzsdxgsfooter = "", hzzs_hzzsfooter = "", hzzs_hzstfooter = "", jozs_jogsfooter = "",
    jskstabledata = "", jskstabledata_hz = "", syxwtabledata_fb = "";
$(".dwzslodiv").on("click", "span", function (t) {
    var a = $(this), s = jskstabledata.length, e = 1 * $(this).parent().attr("data-text");
    "dwzslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "dwzslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachcontent_dwzs(jskstabledata[e][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
}), $(".dxzsdxgslodiv").on("click", "span", function (t) {
    var a = $(this), s = jskstabledata.length, e = 1 * $(this).parent().attr("data-text");
    "dxzsdxgslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "dxzsdxgslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachdxzsdxgs(jskstabledata[e][0]), $("canvas").remove(), daxiaoConten(), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
}), $(".hzzs_zslodiv").on("click", "span", function (t) {
    var a = $(this), s = jskstabledata.length, e = 1 * $(this).parent().attr("data-text");
    "hzzs_zslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "hzzs_zslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachhzzs_s(jskstabledata[e][0]), $("canvas").remove(), hezhiConten(), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
}), $(".hzzs_stlodiv").on("click", "span", function (t) {
    var a = $(this), s = jskstabledata.length, e = 1 * $(this).parent().attr("data-text");
    "hzzs_stlo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "hzzs_stlo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachhzzs_st(jskstabledata[e][0]), $("canvas").remove(), hezhiConten(), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
}), $(".jozs_gslodiv").on("click", "span", function (t) {
    var a = $(this), s = jskstabledata.length, e = 1 * $(this).parent().attr("data-text");
    "jozs_gslo_left" == a.attr("id") ? (e - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e -= 1)) : "jozs_gslo_right" == a.attr("id") && (e + 2 == s && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", e += 1)), eachjozs_gs(jskstabledata[e][0]), $("canvas").remove(), qiyuConten(), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500)
});
var wzzsdataarr = "", jbzsarr = "", kuai3FunObj = {
    dewdrop: {
        init: function () {
            this.getdata("")
        }, getdata: function (t) {
            "" == t && $(".cheDate span:first").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                type: "GET",
                url: config.publicUrl + "lotteryJSFastThree/getNumberRoadOfBead.do",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    kuai3FunObj.dewdrop.addhaoma(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, addhaoma: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".haomalz").find(".lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    if (0 == a.result.data[e].state) {
                        var n = "X", i = "✓";
                        s = "cuoduishow"
                    }
                    var o = a.result.data[e].rank,
                        l = "<div id='hm" + e + "' class='lz_title " + s + " ball_" + o + "'><div class='left'><span>今日累计:</span>",
                        d = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var h = 0, r = 0, c = 0; h < a.result.data[e].roadBeads.length && !(h >= 200); h++) {
                        var p = a.result.data[e].roadBeads[h];
                        0 == p ? (p = n, r += 1) : 1 == p && (p = i, c += 1), 0 == h && (d += "<p>" + p + "</p>"), h > 0 & a.result.data[e].roadBeads[h - 1] == a.result.data[e].roadBeads[h] ? d += "<p>" + p + "</p>" : h > 0 & a.result.data[e].roadBeads[h - 1] != a.result.data[e].roadBeads[h] && (d += "</td><td><p>" + p + "</p>")
                    }
                    var u = "<span>总来（" + a.result.data[e].totals[0] + "）</span><span>没来（" + a.result.data[e].totals[1] + "）</span></div><div class='right'><span class='weizi'></span><span class='mosh'>号码" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".haomalz .lz_content").append(l + u + d + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('✓')").css("color", "red"), checkhmqhlzHm()
            } else tools.weikaiji(".haomalz .lz_content")
        }
    }, wzzs: {
        init: function () {
            this.getlist("", 30)
        }, getlist: function (t, a) {
            "" != t && t != getDateStr(0, !0) || "" != a || ($(".shjian").text("今天"), $("#periods_wzzs ul li:first").addClass("checkedpl").siblings().removeClass("checkedpl")), $.ajax({
                type: "GET",
                url: config.publicUrl + "lotteryJSFastThree/queryOrientationTrend.do",
                data: {lotCode: lotCode, date: t, periods: a},
                success: function (t) {
                    wzzsdataarr = t, kuai3FunObj.wzzs.dingweilist(t, wz_mc_val[0])
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, dingweilist: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data;
            if (0 != s.length) {
                $(".locationzs #chartLinediv").html("");
                var e = "";
                e += "<table class='table_dingwezs' id='trend_ding'>", e += "<thead><tr><th>期号</th><th>开奖号</th><th>1</th><th>2</th><th>3</th>", e += "<th>4</th><th>5</th><th>6</th>", e += "<th>大</th><th>小</th><th>单</th><th>双</th></tr></thead><tbody><tr>", listettablearr(s.bodyList), $(s.bodyList).each(function (t) {
                    if (10052 == lotCode) s = config.showrows; else var s = 200;
                    if (t >= s) return !1;
                    if (0 == a) n = "oneCode"; else if (1 == a) n = "twoCode"; else var n = "threeCode";
                    for (var i = this.drawCode, o = this[n], l = "", d = 0; d < i.length; d++) l += d == a ? "<span style='color:red'>" + i[d] + "</span>&nbsp;" : "<span>" + i[d] + "</span>&nbsp;";
                    e += " <td>" + this.preIssue.toString().split(i) + "</td><td class='tabred'>" + l + "</td>";
                    for (var h = 0; h < o.length; h++) 1 * o[h] > 0 || 1 * o[h] == 0 ? h < 6 ? e += "<td class='hot ding'><span name='hotSpan'>" + o[h] + "</span></td>" : 6 == h ? e += "<td class='hot pol'><span name='hotSpan'>大</span></td>" : 7 == h ? e += "<td class='hot pol'><span name='hotSpan'>小</span></td>" : 8 == h ? e += "<td class='hot'><span name='hotSpan'>单</span></td>" : 9 == h && (e += "<td class='hot'><span name='hotSpan'>双</span></td>") : e += h < 6 ? "<td style='background: #fdf7ed;'><span>" + Math.abs(o[h]) + "</span></td>" : "<td><span>" + Math.abs(o[h]) + "</span></td>";
                    e += "</tr>"
                });
                var n = s.basicTrendTitle.appearCount.slice(10 * a, 10 * a + 10),
                    i = s.basicTrendTitle.averageMissingValues.slice(10 * a, 10 * a + 10),
                    // o = s.basicTrendTitle.currentMissingValues.slice(10 * a, 10 * a + 10),
                    l = s.basicTrendTitle.maxAppearValues.slice(10 * a, 10 * a + 10),
                    d = s.basicTrendTitle.maxMissingValues.slice(10 * a, 10 * a + 10),
                    h = "</tr><tr class='clospan'><td colspan='2'>数据统计</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>大</td><td>小</td><td>单</td><td>双</td></tr>";
                h += "<tr><td colspan='2'>出现次数</td>";
                for (var r = "<tr><td colspan='2'>平均遗漏</td>", c = "<tr style='display:none;'><td colspan='2'>当前遗漏</td>", p = "<tr><td colspan='2'>最大连出</td>", u = "<tr><td colspan='2'>最大遗漏</td>", f = 0; f < n.length; f++) h += " <td>" + Math.abs(n[f]) + "</td>", r += " <td>" + Math.abs(i[f]) + "</td>", c += " <td></td>", p += " <td>" + Math.abs(l[f]) + "</td>", u += " <td>" + Math.abs(d[f]) + "</td>";
                e += (dwzsfooter = h + "</tr>" + r + "</tr>" + c + "</tr>" + p + "</tr>" + u + "</tr>") + "</tbody></table>", $(".locationzs #chartLinediv").html(e), $(".locationzs canvas").remove(), orshowConten();
                var b = $(".locationzs").attr("class").replace(" ", "").replace("checkspan", "");
                $(".table_" + b).show().siblings().hide()
            } else tools.weikaiji(".locationzs #chartLinediv")
        }
    }, market: {
        init: function () {
            this.getmarket("", 30)
        }, getmarket: function (t, a) {
            "" != t && t != getDateStr(0, !0) || "" != a || ($(".daxaioyelp").text("今天"), $("#dapook_wzze ul li:first").addClass("checkedpl").siblings().removeClass("checkedpl")), $.ajax({
                type: "GET",
                url: config.publicUrl + "lotteryJSFastThree/queryBigAndSmallTrend.do",
                data: {lotCode: lotCode, date: t, periods: a},
                success: function (t) {
                    kuai3FunObj.market.daxiaozslist(t, 0)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, daxiaozslist: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data;
            if (0 == s.bodyList.length) return tools.weikaiji("#table_daxiao"), void tools.weikaiji("#daxiaoBoxtop");
            listettablearr(s.bodyList), $("#table_daxiao").html("");
            var e = "";
            e += "<thead><tr><th rowspan='2' style='width: 15%;'>日期</th>", e += "<th rowspan='2' class='qiyu_app'>开奖号码</th>", e += "<th colspan='6' class='qiyu_arr'>开奖号码分布</th><th colspan='4' class='qiyu_arr'>大数个数</th>", e += "<th colspan='4' class='qiyu_arr'>小数个数</th></tr>", e += "<tr><th style='width: 5%;'>1</th><th style='width: 5%;'>2</th><th style='width: 5%;'>3</th>", e += "<th style='width: 5%;'>4</th><th style='width: 5%;'>5</th><th style='width: 5%;'>6</th>", e += "<th style='width: 5%;'>0</th><th style='width: 5%;'>1</th><th style='width: 5%;'>2</th>", e += "<th style='width: 5%;'>3</th><th style='width: 5%;'>0</th><th style='width: 5%;'>1</th>", e += "<th style='width: 5%;'>2</th><th style='width: 5%;'>3</th></tr></thead><tbody><tr>", $(s.bodyList).each(function (t) {
                if (10052 == lotCode) a = config.showrows; else var a = 200;
                if (t >= a) return !1;
                var s = this.drawCode, n = this.numberDistribution, i = this.bigNumber, o = this.smallNumber, l = 0;
                e += " <td>" + (this.preIssue.toString().length > 5 ? this.preIssue.toString().slice(this.preIssue.toString().length - 5) : this.preIssue) + "</td><td class='tabred'><span>" + s.join(" ") + "</span></td>", 1 * s[1] == s[0] && 1 * s[1] == 1 * s[2] ? l = 3 : 1 * s[1] != s[0] && 1 * s[1] != 1 * s[2] || (l = 2);
                for (var d = 0; d < n.length; d++) 1 * n[d] > 0 || 1 * n[d] == 0 ? 1 * n[d] == 1 * s[1] && 0 != l ? e += "<td class='hot da'><span name='hotSpan'>" + n[d] + "<i class='smallQiu'>" + l + "</i></span></td>" : e += "<td class='hot da'><span name='hotSpan'>" + n[d] + "</span></td>" : e += "<td style='background: #fdf7ed;'><span>" + Math.abs(n[d]) + "</span></td>";
                for (var h = 0; h < i.length; h++) 1 * i[h] > 0 || 1 * i[h] == 0 ? e += "<td class='hot pol'><span name='hotSpan'>" + i[h] + "</span></td>" : e += "<td><span>" + Math.abs(i[h]) + "</span></td>";
                for (var r = 0; r < o.length; r++) 1 * o[r] > 0 || 1 * o[r] == 0 ? e += "<td class='hot da'><span name='hotSpan'>" + o[r] + "</span></td>" : e += "<td style='background: #fdf7ed;'><span>" + Math.abs(o[r]) + "</span></td>";
                e += "</tr>"
            });
            var n = s.bigAndSmallTrendTitle.appearCount.slice(0, 6).concat(s.bigAndSmallTrendTitle.appearCount.slice(16)),
                i = s.bigAndSmallTrendTitle.averageMissingValues.slice(0, 6).concat(s.bigAndSmallTrendTitle.averageMissingValues.slice(16)),
                o = s.bigAndSmallTrendTitle.maxAppearValues.slice(0, 6).concat(s.bigAndSmallTrendTitle.maxAppearValues.slice(16)),
                l = s.bigAndSmallTrendTitle.maxMissingValues.slice(0, 6).concat(s.bigAndSmallTrendTitle.maxMissingValues.slice(16));
            dxzsdxgsfooter = "", dxzsdxgsfooter += "<tr class='plo'><th rowspan='2' colspan='2' style='width: 15%;'>数据统计</th>", dxzsdxgsfooter += "<th colspan='6' class='qiyu_arr'>开奖号码分布</th><th colspan='4' class='qiyu_arr'>大数个数</th>", dxzsdxgsfooter += "<th colspan='4' class='qiyu_arr'>小数个数</th></tr>", dxzsdxgsfooter += "<tr class='plo'><th style='width: 5%;'>1</th><th style='width: 5%;'>2</th><th style='width: 5%;'>3</th>", dxzsdxgsfooter += "<th style='width: 5%;'>4</th><th style='width: 5%;'>5</th><th style='width: 5%;'>6</th>", dxzsdxgsfooter += "<th style='width: 5%;'>0</th><th style='width: 5%;'>1</th><th style='width: 5%;'>2</th>", dxzsdxgsfooter += "<th style='width: 5%;'>3</th><th style='width: 5%;'>0</th><th style='width: 5%;'>1</th>", dxzsdxgsfooter += "<th style='width: 5%;'>2</th><th style='width: 5%;'>3</th></tr>";
            for (var d = "<tr><td colspan='2'>出现次数</td>", h = "<tr><td colspan='2'>平均遗漏</td>", r = "<tr><td colspan='2'>最大连出</td>", c = "<tr><td colspan='2'>最大遗漏</td>", p = 0; p < n.length; p++) p < 6 || p > 9 ? (d += " <td style='background: #fdf7ed;'>" + Math.abs(n[p]) + "</td>", h += " <td style='background: #fdf7ed;'>" + Math.abs(i[p]) + "</td>", r += " <td style='background: #fdf7ed;'>" + Math.abs(o[p]) + "</td>", c += " <td style='background: #fdf7ed;'>" + Math.abs(l[p]) + "</td>") : (d += " <td>" + Math.abs(n[p]) + "</td>", h += " <td>" + Math.abs(i[p]) + "</td>", r += " <td>" + Math.abs(o[p]) + "</td>", c += " <td>" + Math.abs(l[p]) + "</td>");
            var u = "</tr>";
            e += (dxzsdxgsfooter += d + u + h + u + r + u + c + u) + "</tbody>", $("#table_daxiao").html(e), $("#daxiaoBoxtop").html("");
            var f = "";
            f += "<table border='0' cellspacing='1' cellpadding='1' id='table_daxiaotop'>", f += "<thead><tr><th rowspan='2'>日期</th>", f += "<th rowspan='2' style='width: 8%; padding: 0 0.05rem 0 0.05rem;'>开奖号码</th>", f += "<th colspan='2' class='qiyu_arr'>百位</th><th colspan='2' class='qiyu_arr'>十位</th>", f += "<th colspan='2' class='qiyu_arr'>个位</th><th colspan='4' class='qiyu_arr'>大小比</th></tr>", f += "<tr><th style='width: 5%;'>大</th><th style='width: 5%;'>小</th><th style='width: 5%;'>大</th>", f += "<th style='width: 5%;'>小</th><th style='width: 5%;'>大</th><th style='width: 5%;'>小</th>", f += "<th style='width: 5%;'>3:0</th><th style='width: 5%;'>2:1</th><th style='width: 5%;'>1:2</th>", f += "<th style='width: 5%;'>0:3</th></tr></thead><tbody>", $(s.bodyList).each(function (t) {
                if (10052 == lotCode && t >= 200) return !1;
                var a = this.drawCode, s = this.hundredForm.slice(0, 2), e = this.tenForm.slice(0, 2),
                    n = this.unitForm.slice(0, 2), i = this.smallNumber;
                f += " <td>" + this.preIssue + "</td><td class='tabred'><span class='yanse'>" + a.join(" ") + "</span></td>";
                for (var o = 0; o < s.length; o++) 1 * s[o] >= 0 ? f += 2 == o ? "<td class='hot'><span name='hotSpan'>" + s[o] + "</span></td>" : o > 0 ? "<td class='hot one'><span name='hotSpan' style='background:transparent'>小</span></td>" : "<td class='hot top'><span name='hotSpan' style='background:transparent'>大</span></td>" : f += "<td><span>" + Math.abs(s[o]) + "</span></td>";
                for (var l = 0; l < e.length; l++) 1 * e[l] >= 0 ? f += 2 == l ? "<td class='hot'><span name='hotSpan'>" + e[l] + "</span></td>" : l > 0 ? "<td class='hot one'><span name='hotSpan' style='background:transparent'>小</span></td>" : "<td class='hot top'><span name='hotSpan' style='background:transparent'>大</span></td>" : f += "<td><span>" + Math.abs(e[l]) + "</span></td>";
                for (var d = 0; d < n.length; d++) 1 * n[d] >= 0 ? f += 2 == d ? "<td class='hot'><span name='hotSpan'>" + n[d] + "</span></td>" : d > 0 ? "<td class='hot one'><span name='hotSpan' style='background:transparent'>小</span></td>" : "<td class='hot top'><span name='hotSpan' style='background:transparent'>大</span></td>" : f += "<td><span>" + Math.abs(n[d]) + "</span></td>";
                for (var h = 0; h < i.length; h++) 1 * i[h] > 0 || 1 * i[h] == 0 ? h >= 4 ? f += "<td class='hot'><span name='hotSpan'>" + i[h] + "</span></td>" : 0 == h ? f += "<td class='hot' style='background: #00BAFF; font-zise:13px;'><span name='hotSpan' style='background: transparent;'>3:0</span></td>" : 1 == h ? f += "<td class='hot' style='background: #fcb103; font-zise:13px;'><span name='hotSpan' style='background: transparent;'>2:1</span></td>" : 2 == h ? f += "<td class='hot' style='background: #00BAFF; font-zise:13px;'><span name='hotSpan' style='background: transparent;'>1:2</span></td>" : 3 == h && (f += "<td class='hot' style='background: #fcb103; font-zise:13px;'><span name='hotSpan' style='background: transparent;'>0:3</span></td>") : f += "<td><span>" + Math.abs(i[h]) + "</span></td>";
                f += "</tr>"
            });
            var n = s.bigAndSmallTrendTitle.appearCount.slice(6, 16),
                i = s.bigAndSmallTrendTitle.averageMissingValues.slice(6, 16),
                o = s.bigAndSmallTrendTitle.maxAppearValues.slice(6, 16),
                l = s.bigAndSmallTrendTitle.maxMissingValues.slice(6, 16);
            f += "<tr class='toplek'><th rowspan='2' colspan='2' style='width: 15%;'>数据统计</th>", f += "<th colspan='2' class='qiyu_arr'>百位</th><th colspan='2' class='qiyu_arr'>十位</th>", f += "<th colspan='2' class='qiyu_arr'>个位</th><th colspan='4' class='qiyu_arr'>大小比</th></tr>", f += "<tr class='toplek'><th style='width: 5%;'>大</th><th style='width: 5%;'>小</th><th style='width: 5%;'>大</th>", f += "<th style='width: 5%;'>小</th><th style='width: 5%;'>大</th><th style='width: 5%;'>小</th>", f += "<th style='width: 5%;'>3:0</th><th style='width: 5%;'>2:1</th><th style='width: 5%;'>1:2</th>", f += "<th style='width: 5%;'>0:3</th></tr></thead><tbody>";
            for (var b = "<tr><td colspan='2'>出现次数</td>", g = "<tr><td colspan='2'>平均遗漏</td>", y = "<tr><td colspan='2'>最大连出</td>", m = "<tr><td colspan='2'>最大遗漏</td>", p = 0; p < n.length; p++) b += " <td>" + Math.abs(n[p]) + "</td>", g += " <td>" + Math.abs(i[p]) + "</td>", y += " <td>" + Math.abs(o[p]) + "</td>", m += " <td>" + Math.abs(l[p]) + "</td>";
            f += b + (u = "</tr>") + g + u + y + u + m + u + "</tbody></table>", $("#daxiaoBoxtop").html(f), $(".sizezs canvas").remove(), daxiaoConten();
            var z = $(".sizezs").attr("class").replace(" ", "").replace("checkspan", "");
            $(".table_" + z).show().siblings().hide()
        }
    }, lishi: {
        getlishi: function () {
            $.ajax({
                type: "GET",
                url: config.publicUrl + "lotteryJSFastThree/getJSFastThreeNumberList.do",
                data: {lotCode: lotCode},
                success: function (t) {
                    kuai3FunObj.lishi.lishihmlist(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, lishihmlist: function (t) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var a = data.result.data;
            $(a).each(function () {
                var t = "" + ("<tr><th>" + this.preDrawDate + "</th>") + ("<th>" + this.oneTimes + "</th>") + ("<th>" + this.twoTimes + "</th>") + ("<th>" + this.threeTimes + "</th>") + ("<th>" + this.fourTimes + "</th>") + ("<th>" + this.fiveTimes + "</th>") + ("<th>" + this.sixTimes + "</th>") + ("<th>" + this.bigTimes + "</th>") + ("<th>" + this.smallTimes + "</th></tr>") + "</tr>";
                $("#lishihm_Box").find("tbody").append(t)
            })
        }
    }, hezhizspl: {
        init: function () {
            this.gethezhi("", 30)
        }, gethezhi: function (t, a) {
            "" != t && t != getDateStr(0, !0) || "" != a || ($(".weaipl").text("今天"), $("#hetrem_wzze ul li:first").addClass("checkedpl").siblings().removeClass("checkedpl")), $.ajax({
                type: "GET",
                url: config.publicUrl + "lotteryJSFastThree/querySumTrend.do",
                data: {lotCode: lotCode, date: t, periods: a},
                success: function (t) {
                    kuai3FunObj.hezhizspl.hezhizsliat(t, 0)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, hezhizsliat: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data;
            if (0 == s.bodyList.length) return tools.weikaiji(".hezhizspl #hezhiBox_noe"), void tools.weikaiji(".hezhizspl #hezhiBox_top");
            listettablearr(s.bodyList), $(".hezhizspl #hezhiBox_noe table").remove();
            var e = "";
            e += "<table border='0' cellspacing='1' cellpadding='1' id='table_hezhi'><thead><tr><th class='diyige'>期号</th><th class='dier'>和</th>", e += "<th class='disan'>3</th><th class='disan'>4</th><th class='disan'>5</th><th class='disan'>6</th><th class='disan'>7</th>", e += "<th class='disan'>8</th><th class='disan'>9</th><th class='disan'>10</th><th class='disan'>11</th>", e += "<th class='disan'>12</th><th class='disan'>13</th><th class='disan'>14</th><th class='disan'>15</th>", e += "<th class='disan'>16</th><th class='disan'>17</th><th class='disan'>18</th></tr></thead><tbody class='table_sttz'><tr>", $(s.bodyList).each(function (t) {
                if (10052 == lotCode) a = config.showrows; else var a = 200;
                if (t >= a) return !1;
                var s = this.sumTotal, n = this.sumNum.slice(0, 16);
                if (this.preIssue.toString().length > 5) this.preIssue.toString().slice(3); else this.preIssue;
                e += " <td>" + this.preIssue + "</td><td class='tabred'><span class='yanse' style='color: #E90009;'>" + s + "</span></td>";
                for (var i = 0; i < n.length; i++) 1 * n[i] >= 0 ? e += "<td class='hot'><span name='hotSpan'>" + n[i] + "</span></td>" : e += "<td><span>" + Math.abs(n[i]) + "</span></td>";
                e += "</tr>"
            });
            var n = s.basicTrendTitle.appearCount.slice(0, 16), i = s.basicTrendTitle.averageMissingValues.slice(0, 16),
                // o = s.basicTrendTitle.currentMissingValues.slice(0, 16),
                l = s.basicTrendTitle.maxAppearValues.slice(0, 16), d = s.basicTrendTitle.maxMissingValues.slice(0, 16);
            hzzs_hzzsfooter = "", hzzs_hzzsfooter += "<tr class='zouship'><th colspan='2'>数据统计</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th>", hzzs_hzzsfooter += "<th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th>", hzzs_hzzsfooter += "<th>16</th><th>17</th><th>18</th></tr>";
            for (var h = "<tr><td colspan='2'>出现次数</td>", r = "<tr><td colspan='2'>平均遗漏</td>", c = "<tr style='display:none;'><td colspan='2'>当前遗漏</td>", p = "<tr><td colspan='2'>最大连出</td>", u = "<tr><td colspan='2'>最大遗漏</td>", f = 0; f < n.length; f++) h += " <td>" + Math.abs(n[f]) + "</td>", r += " <td>" + Math.abs(i[f]) + "</td>", c += " <td></td>", p += " <td>" + Math.abs(l[f]) + "</td>", u += " <td>" + Math.abs(d[f]) + "</td>";
            var b = "</tr>";
            e += (hzzs_hzzsfooter += h + b + r + b + c + b + p + b + u + b) + "</tbody></table>", 0 != $(".hezhizspl #hezhiBox_noe .lomorediv").length ? $(".hezhizspl #hezhiBox_noe .lomorediv").before(e) : $(".hezhizspl #hezhiBox_noe").append(e), $(".hezhizspl #hezhiBox_top #table_danxuanon").remove();
            var g = "";
            g += "<table border='0' cellspacing='1' cellpadding='1' id='table_danxuanon'><thead><tr style='height: 0.28rem; font-size: 15px;'>", g += "<th style='width: 25%;'>期号</th><th style='width: 20%;'>开奖号码</th>", g += "<th style='width: 8%;'>和</th><th>大</th><th>小</th><th>单</th><th>双</th></thead><tbody class='table_lese'>", $(s.bodyList).each(function (t) {
                if (10052 == lotCode) a = config.showrows; else var a = 200;
                if (t >= a) return !1;
                var s = this.drawCode, e = this.sumTotal, n = this.sumNum.slice(16, 20);
                g += " <td>" + this.preIssue + "</td><td class='tabred'><span class='yanse'>" + s.join(" ") + "</span></td><td class='hez'><span style='color: #E90009;'>" + e + "</span></td>";
                for (var i = 0; i < n.length; i++) 1 * n[i] >= 0 ? g += 4 == i ? "<td class='zhilinst'><span name='hotSpan'>" + n[i] + "</span></td>" : i <= 0 ? "<td class='hot'><span name='hotSpan'>大</span></td>" : i <= 1 ? "<td class='hot'><span name='hotSpan'>小</span></td>" : i <= 2 ? "<td class='hotp'><span name='hotSpan'>单</span></td>" : "<td class='hotp'><span name='hotSpan'>双</span></td>" : g += "<td><span>" + Math.abs(n[i]) + "</span></td>";
                g += "</tr>"
            });
            var n = s.basicTrendTitle.appearCount.slice(16, 20),
                i = s.basicTrendTitle.averageMissingValues.slice(16, 20),
                // o = s.basicTrendTitle.currentMissingValues.slice(16, 20),
                l = s.basicTrendTitle.maxAppearValues.slice(16, 20),
                d = s.basicTrendTitle.maxMissingValues.slice(16, 20);
            hzzs_hzstfooter = "", hzzs_hzstfooter += "<tr class='danmoshi'><th colspan='3' style='text-align: center;color: #0c0c0c;'>数据统计</th><th style='text-align: center;color: #0c0c0c;'>大</th>", hzzs_hzstfooter += "<th style='text-align: center;color: #0c0c0c;'>小</th><th style='text-align: center;color: #0c0c0c;'>单</th><th style='text-align: center;color: #0c0c0c;'>双</th>";
            for (var y = "<tr><td colspan='3'>出现次数</td>", m = "<tr><td colspan='3'>平均遗漏</td>", z = "<tr style='display:none;'><td colspan='3'>当前遗漏</td>", v = "<tr><td colspan='3'>最大连出</td>", w = "<tr><td colspan='3'>最大遗漏</td>", f = 0; f < n.length; f++) y += " <td>" + Math.abs(n[f]) + "</td>", m += " <td>" + Math.abs(i[f]) + "</td>", z += " <td></td>", v += " <td>" + Math.abs(l[f]) + "</td>", w += " <td>" + Math.abs(d[f]) + "</td>";
            g += (hzzs_hzstfooter += y + (b = "</tr>") + m + b + z + b + v + b + w + b) + "</tbody></table>", 0 != $(".hezhizspl #hezhiBox_top .lomorediv").length ? $(".hezhizspl #hezhiBox_top .lomorediv").before(g) : $(".hezhizspl #hezhiBox_top").append(g), $(".hezhizspl canvas").remove(), hezhiConten();
            var _ = $(".hezhizspl").attr("class").replace(" ", "").replace("checkspan", "");
            $(".table_" + _).show().siblings().hide()
        }
    }, jibenzs: {
        init: function () {
            this.getjiben("", 30)
        }, getjiben: function (t, a) {
            "" != t && t != getDateStr(0, !0) || "" != a || ($(".xuanxiang").text("今天"), $("#sanjigrot_wzze ul li:first").addClass("checkedpl").siblings().removeClass("checkedpl")), $.ajax({
                type: "GET",
                url: config.publicUrl + "lotteryJSFastThree/queryBasicTrend.do",
                data: {lotCode: lotCode, date: t, periods: a},
                success: function (t) {
                    kuai3FunObj.jibenzs.jibenzslist(t, 0)
                },
                rerror: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, jibenzslist: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data;
            if (0 != s.bodyList.length) {
                $("#jibenzsBox").html();
                var e = "";
                e += "<table border='0' cellspacing='1' cellpadding='1' id='table_jiben'><thead><tr><th rowspan='2' style='width: 22%';>期号</th>", e += "<th rowspan='2' style='width: 10%;padding: 0 0.05rem 0 0.05rem;'>开奖号码</th>", e += "<th colspan='6'>开奖号码分布</th><th colspan='3'>号码形态</th></tr><tr><th style='width: 5%;'>1</th><th style='width: 5%;'>2</th>", e += "<th style='width: 5%;'>3</th><th style='width: 5%;'>4</th>", e += "<th style='width: 5%;'>5</th><th style='width: 5%;'>6</th><th style='width: 12%'>豹子</th><th style='width: 12%'>三不同</th>", e += "<th style='width: 12%'>对子</th></tr></thead><tbody>", s.bodyList.length > 100 && (s.bodyList = s.bodyList.slice(0, 100)), $(s.bodyList).each(function (t) {
                    var a = this.drawCode, s = this.distribution, n = this.numberForm, i = 0;
                    e += " <td>" + this.preIssue + "</td><td class='tabred'><span class='yanse'>" + a.join(" ") + "</span></td>", 1 * a[1] == a[0] && 1 * a[1] == 1 * a[2] ? i = 3 : 1 * a[1] != a[0] && 1 * a[1] != 1 * a[2] || (i = 2);
                    for (o = 0; o < s.length; o++) 1 * s[o] >= 0 ? 1 * s[o] == 1 * a[1] && 0 != i ? e += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + s[o] + "<i class='smallQiu'>" + i + "</i></span></td>" : e += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + s[o] + "</span></td>" : e += "<td style='background: #fdf7ed;'><span>" + Math.abs(s[o]) + "</span></td>";
                    for (var o = 0; o < n.length; o++) 1 * n[o] >= 0 ? e += 3 == o ? "<td class='hot'><span name='hotSpan'>" + n[o] + "</span></td>" : o <= 0 ? "<td class='hot pk'><span name='hotSpan' style='display: initial;background: transparent;'>豹子</span></td>" : o <= 1 ? "<td class='hot pl'><span name='hotSpan' style='display: initial;background: transparent;'>三不同</span></td>" : "<td class='hot pk'><span name='hotSpan' style='display: initial;background: transparent;'>对子</span></td>" : e += "<td><span>" + Math.abs(n[o]) + "</span></td>";
                    e += "</tr>"
                });
                var n = s.basicTrendTitle.appearCount.slice(0, 9),
                    i = s.basicTrendTitle.averageMissingValues.slice(0, 9),
                    // o = s.basicTrendTitle.currentMissingValues.slice(0, 9),
                    l = s.basicTrendTitle.maxAppearValues.slice(0, 9),
                    d = s.basicTrendTitle.maxMissingValues.slice(0, 9);
                e += "<tr class='huery'><th rowspan='2' colspan='2'>数据统计</th>", e += "<th colspan='6'>开奖号码分布</th><th colspan='3'>号码形态</th></tr><tr class='huery'><th style='width: 5%;'>1</th>", e += "<th style='width: 5%;'>2</th><th style='width: 5%;'>3</th><th style='width: 5%;'>4</th>", e += "<th style='width: 5%;'>5</th><th style='width: 5%;'>6</th><th style='width: 12%'>豹子</th><th style='width: 12%;'>三不同</th>", e += "<th style='width: 12%'>对子</th></tr>";
                for (var h = "<tr><td colspan='2'>出现次数</td>", r = "<tr><td colspan='2'>平均遗漏</td>", c = "<tr style='display:none;'><td colspan='2'>当前遗漏</td>", p = "<tr><td colspan='2'>最大连出</td>", u = "<tr><td colspan='2'>最大遗漏</td>", f = 0; f < n.length; f++) f < 6 ? (h += " <td class='lop'>" + Math.abs(n[f]) + "</td>", r += " <td class='lop'>" + Math.abs(i[f]) + "</td>", c += " <td class='lop'></td>", p += " <td class='lop'>" + Math.abs(l[f]) + "</td>", u += " <td class='lop'>" + Math.abs(d[f]) + "</td>") : (h += " <td>" + Math.abs(n[f]) + "</td>", r += " <td>" + Math.abs(i[f]) + "</td>", c += " <td></td>", p += " <td>" + Math.abs(l[f]) + "</td>", u += " <td>" + Math.abs(d[f]) + "</td>");
                e += h + "</tr>" + r + "</tr>" + c + "</tr>" + p + "</tr>" + u + "</tr></tbody></table>", $("#jibenzsBox").html(e), $(".jibenzs canvas").remove();
                var b = $(".jibenzs").attr("class").replace(" ", "").replace("checkspan", "");
                $(".table_" + b).show().siblings().hide()
            } else tools.weikaiji("#jibenzsBox")
        }
    }, zonghe: {
        getzong: function (t) {
            "" == (t = void 0 == t ? "" : t) && $(".zonghelz .cheDate span:first").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                url: config.publicUrl + "lotteryJSFastThree/getRoadOfBeadTotal.do",
                type: "GET",
                data: {lotCode: lotCode, date: t},
                success: function (t) {
                    kuai3FunObj.zonghe.zonghezslist(t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, zonghezslist: function (t) {
            var a = null;
            if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                $(".zonghelz .lz_content").html("");
                for (var s = "", e = 0; e < a.result.data.length; e++) {
                    var n = a.result.data[e].state;
                    if (1 == n) {
                        var i = "双", o = "单", l = "通吃", d = "单双";
                        s = "dansuShow"
                    } else if (2 == n) {
                        var i = "小", o = "大", l = "通吃", d = "大小";
                        s = "daxiaoShow"
                    }
                    a.result.data[e].rank;
                    var h = "<div class='lz_title " + s + " ball_" + n + "'><div class='left'><span>今日累计:</span>",
                        r = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                    a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                    for (var c = 0, p = 0, u = 0, f = 0; c < a.result.data[e].roadBeads.length && !(c >= 200); c++) {
                        var b = a.result.data[e].roadBeads[c];
                        1 == b ? (b = i, p += 1) : 0 == b ? (b = o, u += 1) : 2 == b && (b = l, f += 1), 0 == c && (r += "<p>" + b + "</p>"), c > 0 & a.result.data[e].roadBeads[c - 1] == a.result.data[e].roadBeads[c] ? r += "<p>" + b + "</p>" : c > 0 & a.result.data[e].roadBeads[c - 1] != a.result.data[e].roadBeads[c] && (r += "</td><td><p>" + b + "</p>")
                    }
                    var g = "<span>" + i + "（" + a.result.data[e].totals[1] + "）</span><span>" + o + "（" + a.result.data[e].totals[0] + "）</span><span>" + l + "（" + a.result.data[e].totals[2] + "）</span></div><div class='right'><span class='weizi'>总和</span><span class='weizi'>" + d + "</span><span class='zxi'>最新    &darr;</span></div>";
                    $(".zonghelz .lz_content").append(h + g + r + "</td></tr></tbody></table></div></div>")
                }
                $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red")
            } else tools.weikaiji(".zonghelz .lz_content")
        }
    }, qiyuzs: {
        init: function () {
            this.getqiyu("", 30)
        }, getqiyu: function (t, a) {
            "" != t && t != getDateStr(0, !0) || "" != a || ($(".weaiqi").text("今天"), $("#qiyulist_wzze ul li:first").addClass("checkedpl").siblings().removeClass("checkedpl")), $.ajax({
                type: "GET",
                url: config.publicUrl + "lotteryJSFastThree/queryOddAndEvenTrend.do",
                data: {lotCode: lotCode, date: t, periods: a},
                success: function (t) {
                    kuai3FunObj.qiyuzs.qiyuzslist(t, 0)
                },
                error: function (t) {
                    setTimeout(function () {
                        loadotherData()
                    }, 1e3), config.ifdebug
                }
            })
        }, qiyuzslist: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var s = data.result.data;
            if (0 == s.bodyList.length) return tools.weikaiji("#qiyuzsBox"), void tools.weikaiji("#qiyuzsBoxtop");
            listettablearr(s.bodyList), $("#qiyuzsBox table").remove();
            var e = "";
            e += "<table border='0' cellspacing='1' cellpadding='1' id='table_qiyu'>", e += "<thead><tr><th rowspan='2' style='width: 15%;'>日期</th>", e += "<th rowspan='2' class='qiyu_app'>开奖</br>号码</th>", e += "<th colspan='6' class='qiyu_arr'>开奖号码分布</th><th colspan='4' class='qiyu_arr'>奇数个数</th>", e += "<th colspan='4' class='qiyu_arr'>偶数个数</th></tr>", e += "<tr><th style='width: 4%;'>1</th><th style='width: 4%;'>2</th><th style='width: 4%;'>3</th>", e += "<th style='width: 4%;'>4</th><th style='width: 4%;'>5</th><th style='width: 4%;'>6</th>", e += "<th style='width: 4%;'>0</th><th style='width: 4%;'>1</th><th style='width: 4%;'>2</th>", e += "<th style='width: 4%;'>3</th><th style='width: 4%;'>0</th><th style='width: 4%;'>1</th>", e += "<th style='width: 4%;'>2</th><th style='width: 4%;'>3</th></tr></thead><tbody>", $(s.bodyList).each(function (t) {
                if (10052 == lotCode) a = config.showrows; else var a = 200;
                if (t >= a) return !1;
                var s = this.drawCode, n = this.numberDistribution, i = this.oddNumber, o = this.evenNumber, l = 0;
                this.preIssue.toString().length > 5 && (this.preIssue = this.preIssue.toString().slice(3)), e += " <td>" + this.preIssue + "</td><td class='tabred'><span>" + s.join(" ") + "</span></td>", 1 * s[1] == s[0] && 1 * s[1] == 1 * s[2] ? l = 3 : 1 * s[1] != s[0] && 1 * s[1] != 1 * s[2] || (l = 2);
                for (var d = 0; d < n.length; d++) 1 * n[d] > 0 || 1 * n[d] == 0 ? 1 * n[d] == 1 * s[1] && 0 != l ? e += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + n[d] + "<i class='smallQiu'>" + l + "</i></span></td>" : e += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + n[d] + "</span></td>" : e += d < 6 ? "<td style='background: #fdf7ed;'><span>" + Math.abs(n[d]) + "</span></td>" : "<td><span>" + Math.abs(n[d]) + "</span></td>";
                for (var h = 0; h < i.length; h++) 1 * i[h] > 0 || 1 * i[h] == 0 ? e += "<td class='hot pol'><span name='hotSpan'>" + i[h] + "</span></td>" : e += "<td><span>" + Math.abs(i[h]) + "</span></td>";
                for (var r = 0; r < o.length; r++) 1 * o[r] > 0 || 1 * o[r] == 0 ? e += "<td class='hot' style='background: #fdf7ed;'><span name='hotSpan'>" + o[r] + "</span></td>" : e += "<td style='background: #fdf7ed;'><span>" + Math.abs(o[r]) + "</span></td>";
                e += "</tr>"
            });
            var n = s.title.appearCount.slice(0, 6).concat(s.title.appearCount.slice(16)),
                i = s.title.averageMissingValues.slice(0, 6).concat(s.title.averageMissingValues.slice(16)),
                o = s.title.maxAppearValues.slice(0, 6).concat(s.title.maxAppearValues.slice(16)),
                l = s.title.maxMissingValues.slice(0, 6).concat(s.title.maxMissingValues.slice(16));
            jozs_jogsfooter = "", jozs_jogsfooter += "<tr class='ptin'><th rowspan='2' colspan='2' style='width: 15%;'>数据统计</th>", jozs_jogsfooter += "<th colspan='6' class='qiyu_arr'>开奖号码分布</th><th colspan='4' class='qiyu_arr'>奇数个数</th>", jozs_jogsfooter += "<th colspan='4' class='qiyu_arr'>偶数个数</th></tr>", jozs_jogsfooter += "<tr class='ptin'><th style='width: 4%;'>1</th><th style='width: 4%;'>2</th><th style='width: 4%;'>3</th>", jozs_jogsfooter += "<th style='width: 4%;'>4</th><th style='width: 4%;'>5</th><th style='width: 4%;'>6</th>", jozs_jogsfooter += "<th style='width: 4%;'>0</th><th style='width: 4%;'>1</th><th style='width: 4%;'>2</th>", jozs_jogsfooter += "<th style='width: 4%;'>3</th><th style='width: 4%;'>0</th><th style='width: 4%;'>1</th>", jozs_jogsfooter += "<th style='width: 4%;'>2</th><th style='width: 4%;'>3</th></tr>";
            for (var d = "<tr><td colspan='2'>出现次数</td>", h = "<tr><td colspan='2'>平均遗漏</td>", r = "<tr><td colspan='2'>最大连出</td>", c = "<tr><td colspan='2'>最大遗漏</td>", p = 0; p < n.length; p++) p < 6 || p > 9 ? (d += " <td class='yu'>" + Math.abs(n[p]) + "</td>", h += " <td class='yu'>" + Math.abs(i[p]) + "</td>", r += " <td class='yu'>" + Math.abs(o[p]) + "</td>", c += " <td class='yu'>" + Math.abs(l[p]) + "</td>") : (d += " <td>" + Math.abs(n[p]) + "</td>", h += " <td>" + Math.abs(i[p]) + "</td>", r += " <td>" + Math.abs(o[p]) + "</td>", c += " <td>" + Math.abs(l[p]) + "</td>");
            var u = "</tr>";
            e += (jozs_jogsfooter += d + u + h + u + r + u + c + u) + "</tbody></table>", 0 != $("#qiyuzsBox .lomorediv").length ? $("#qiyuzsBox .lomorediv").before(e) : $("#qiyuzsBox").html(e), $("#qiyuzsBoxtop").html("");
            var f = "";
            f += "<table border='0' cellspacing='1' cellpadding='1' id='table_qiyutop'>", f += "<thead><tr><th rowspan='2'>日期</th>", f += "<th rowspan='2' class='qiyupl_app'>开奖号码</th>", f += "<th colspan='2' class='qiyu_arr'>百位</th><th colspan='2' class='qiyu_arr'>十位</th>", f += "<th colspan='2' class='qiyu_arr'>个位</th><th colspan='4' class='qiyu_arr'>奇偶比</th></tr>", f += "<tr><th style='width: 5%;'>奇</th><th style='width: 5%;'>偶</th><th style='width: 5%;'>奇</th>", f += "<th style='width: 5%;'>偶</th><th style='width: 5%;'>奇</th><th style='width: 5%;'>偶</th>", f += "<th style='width: 5%;'>3:0</th><th style='width: 5%;'>2:1</th><th style='width: 5%;'>1:2</th>", f += "<th style='width: 5%;'>0:3</th></tr></thead><tbody>", $(s.bodyList).each(function (t) {
                var a = this.drawCode, s = this.hundredForm.slice(2), e = this.tenForm.slice(2),
                    n = this.unitForm.slice(2), i = this.evenNumber;
                f += " <td>" + this.preIssue + "</td><td class='tabred'><span class='yanse'>" + a.join(" ") + "</span></td>";
                for (var o = 0; o < s.length; o++) 1 * s[o] >= 0 ? f += 2 == o ? "<td class='hot'><span name='hotSpan'>" + s[o] + "</span></td>" : o <= 0 ? "<td class='hot one'><span name='hotSpan' style='background:transparent'>奇</span></td>" : "<td class='hot top'><span name='hotSpan' style='background:transparent'>偶</span></td>" : f += "<td><span>" + Math.abs(s[o]) + "</span></td>";
                for (var l = 0; l < e.length; l++) 1 * e[l] >= 0 ? f += 2 == l ? "<td class='hot'><span name='hotSpan'>" + e[l] + "</span></td>" : l <= 0 ? "<td class='hot one'><span name='hotSpan' style='background:transparent'>奇</span></td>" : "<td class='hot top'><span name='hotSpan' style='background:transparent'>偶</span></td>" : f += "<td><span>" + Math.abs(e[l]) + "</span></td>";
                for (var d = 0; d < n.length; d++) 1 * n[d] >= 0 ? f += 2 == d ? "<td class='hot'><span name='hotSpan'>" + n[d] + "</span></td>" : d <= 0 ? "<td class='hot one'><span name='hotSpan' style='background:transparent'>奇</span></td>" : "<td class='hot top'><span name='hotSpan' style='background:transparent'>偶</span></td>" : f += "<td><span>" + Math.abs(n[d]) + "</span></td>";
                for (var h = 0; h < i.length; h++) 1 * i[h] > 0 || 1 * i[h] == 0 ? h >= 4 ? f += "<td class='hot'><span name='hotSpan'>" + i[h] + "</span></td>" : 0 == h ? f += "<td class='hot' style='background: #00BAFF; font-zise:13px; color: #fff;'><span name='hotSpan' style='background: transparent;'>3:0</span></td>" : 1 == h ? f += "<td class='hot' style='background: #fcb103; font-zise:13px; color: #fff;'><span name='hotSpan' style='background: transparent;'>2:1</span></td>" : 2 == h ? f += "<td class='hot' style='background: #00BAFF; font-zise:13px; color: #fff;'><span name='hotSpan' style='background: transparent;'>1:2</span></td>" : 3 == h && (f += "<td class='hot' style='background: #fcb103; font-zise:13px; color: #fff;'><span name='hotSpan' style='background: transparent;'>0:3</span></td>") : f += "<td><span>" + Math.abs(i[h]) + "</span></td>";
                f += "</tr>"
            });
            var n = s.title.appearCount.slice(6, 16), i = s.title.averageMissingValues.slice(6, 16),
                o = s.title.maxAppearValues.slice(6, 16), l = s.title.maxMissingValues.slice(6, 16);
            f += "<tr class='meek'><th rowspan='2' colspan='2' style='width: 15%;'>数据统计</th>", f += "<th colspan='2' class='qiyu_arr'>百位</th><th colspan='2' class='qiyu_arr'>十位</th>", f += "<th colspan='2' class='qiyu_arr'>个位</th><th colspan='4' class='qiyu_arr'>奇偶比</th></tr>", f += "<tr class='meek'><th style='width: 5%;'>奇</th><th style='width: 5%;'>偶</th><th style='width: 5%;'>奇</th>", f += "<th style='width: 5%;'>偶</th><th style='width: 5%;'>奇</th><th style='width: 5%;'>偶</th>", f += "<th style='width: 5%;'>3:0</th><th style='width: 5%;'>2:1</th><th style='width: 5%;'>1:2</th>", f += "<th style='width: 5%;'>0:3</th></tr></thead><tbody>";
            for (var b = "<tr><td colspan='2'>出现次数</td>", g = "<tr><td colspan='2'>平均遗漏</td>", y = "<tr><td colspan='2'>最大连出</td>", m = "<tr><td colspan='2'>最大遗漏</td>", p = 0; p < n.length; p++) b += " <td>" + Math.abs(n[p]) + "</td>", g += " <td>" + Math.abs(i[p]) + "</td>", y += " <td>" + Math.abs(o[p]) + "</td>", m += " <td>" + Math.abs(l[p]) + "</td>";
            f += b + (u = "</tr>") + g + u + y + u + m + u + "</tbody></table>", $("#qiyuzsBoxtop").html(f), $(".qiyuzs canvas").remove(), qiyuConten();
            var z = $(".qiyuzs").attr("class").replace(" ", "").replace("checkspan", "");
            $(".table_" + z).show().siblings().hide()
        }
    }
}, fastClickDate = {today_lz: 0, yestoday_lz: -1, qitian_lz: -2};
$(".checkday").on("click", "span", function () {
    var t = $(this), a = "", s = this.classList[0];
    t.addClass("checkspan").siblings().removeClass("checkspan");
    var e = fastClickDate[s];
    if (!t.hasClass("checkclick_date") && !t.hasClass("screen")) {
        a = getDateStr(e, !0), t.siblings(".time_select").text(a);
        var n = $(".title_se_box .se_check").attr("target");
        n = (n = $("#" + n + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_kuai(n, a, ""), tools.revertHmfb()
    }
});
var condition_wzzs = [{
        data: [{name: "遗漏", value: "yilo"}, {name: "拆线", value: "caix"}, {
            name: "遗漏分层",
            value: "fancong"
        }, {name: "分割线", value: "fgx"}]
    }], condition_wz_mc = [{data: [{value: "第一位号码", id: "0"}, {value: "第二位号码", id: "1"}, {value: "第三位号码", id: "2"}]}],
    condition_wz_qs = [{data: [{value: "近30期", id: "30"}, {value: "近60期", id: "60"}, {value: "近90期", id: "90"}]}],
    initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".tiaojian", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            orshowConten()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), wz_mc_val = [0], initTiaojian = new MobileSelect({
        trigger: ".diyiwei",
        title: "选择名次",
        wheels: condition_wz_mc,
        position: wz_mc_val,
        callback: function (t, a, s) {
            wz_mc_val[0] = 1 * a[0].id, kuai3FunObj.wzzs.dingweilist(wzzsdataarr, wz_mc_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : wz_mc_val, s = 0; s < wz_mc_val.length; s++) t.locatePosition(s, a[s])
        }
    }), wz_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".dwzs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: wz_qs_val,
        callback: function (t, a, s) {
            wz_qs_val[0] = 1 * a[0].id, kuai3FunObj.wzzs.getlist("", wz_qs_val[0])
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
        }, trigger: ".yixuan", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            daxiaoConten()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), dxiaozs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".dxiaozs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: dxiaozs_qs_val,
        callback: function (t, a, s) {
            dxiaozs_qs_val[0] = 1 * a[0].id, kuai3FunObj.market.getmarket("", dxiaozs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dxiaozs_qs_val, s = 0; s < dxiaozs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".kjdsbskj", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            hezhiConten()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), hzzs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".hezzs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: hzzs_qs_val,
        callback: function (t, a, s) {
            hzzs_qs_val[0] = 1 * a[0].id, kuai3FunObj.hezhizspl.gethezhi("", hzzs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : hzzs_qs_val, s = 0; s < hzzs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), jbzs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".jbzs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: jbzs_qs_val,
        callback: function (t, a, s) {
            jbzs_qs_val[0] = 1 * a[0].id, kuai3FunObj.jibenzs.getjiben("", jbzs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : jbzs_qs_val, s = 0; s < jbzs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    }), initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !1,
            _mulitSelect: !0,
            _selectedArr: ["yilo", "caix"]
        }, trigger: ".tiaojianyu", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, s) {
            qiyuConten()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), jyzs_qs_val = [0], initTiaojian = new MobileSelect({
        trigger: ".jyzs_qish",
        title: "选择期数",
        wheels: condition_wz_qs,
        position: jyzs_qs_val,
        callback: function (t, a, s) {
            jyzs_qs_val[0] = 1 * a[0].id, kuai3FunObj.qiyuzs.getqiyu("", jyzs_qs_val[0])
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : jyzs_qs_val, s = 0; s < jyzs_qs_val.length; s++) t.locatePosition(s, a[s])
        }
    });