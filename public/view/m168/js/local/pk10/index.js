function startVideo() {
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        if($(".gamename").text().indexOf('飞艇') == -1){
            $("#videoiframe").attr('src',config.videourl+"view/video/PK10/video.html?"+lotCode);
        }else{
            $("#videoiframe").attr('src',config.videourl+"view/video/jisuft_video/index.html?"+lotCode);
        }
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

function throttle(t, a, e) {
    var s, l = +new Date;
    return function () {
        var i = +new Date, n = this, d = arguments;
        clearTimeout(s), i - l >= e ? (t.apply(n, d), l = i) : s = setTimeout(function () {
            t.apply(n, d)
        }, a)
    }
}

function createHtmlStr(t, a) {
    var e = "";
    $(t).each(function (t) {
        e += '<div class="listline bortop001"><div class="leftspan leftspanw"><span class="boxflex">';
        var a = this.preDrawTime, s = a.length;
        a = a.substring(s - 8, s - 3), e += '<span class="graytime">' + a + "</span>", e += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", e += "</span>", e += "</div>", e += '<div class="rightspan">', e += '<div class="rightdiv padl0">', e += '<ul id="" class="pk10li haomali listli">';
        var l = this.preDrawCode.split(",");
        if ($(l).each(function (t) {
            t == l.length - 1 ? e += '<li class="nubb' + this + ' li_after"><i>' + this + "</i></li>" : e += '<li class="nubb' + this + '"><i>' + this + "</i></li>"
        }), e += "</ul>", e += '<ul id="" class="pk10li longhuli listli lhlist displaynone">', !(l.length <= 1)) var i = "0" == this.sumBigSamll ? "大" : "小",
            n = "0" == this.sumSingleDouble ? "单" : "双", d = "0" == this.firstDT ? "longbg" : "hubg",
            o = "0" == this.secondDT ? "longbg" : "hubg", c = "0" == this.thirdDT ? "longbg" : "hubg",
            r = "0" == this.fourthDT ? "longbg" : "hubg", h = "0" == this.fifthDT ? "longbg" : "hubg";
        e += "<li  style='color:#f12d35'>" + this.preDrawCode.split(",")[0] + "</li>", e += "<li>" + i + "</li>", e += "<li>" + n + "</li>", e += "<li class='" + d + "'></li>", e += "<li class='" + o + "'></li>", e += "<li class='" + c + "'></li>", e += "<li class='" + r + "'></li>", e += "<li class='" + h + " li_after'></li>", e += "</ul>", e += "</div>", e += "</div>", e += "</div>"
    }), "string" == typeof a ? $(a).append(e) : a.forEach(function (t) {
        return $(t).append(e)
    })
}

function runNumFilter() {
    var t = "";
    $(".numbtn .lichecked").each(function (a, e) {
        t += $(e).text() + ","
    }), t && $("#haomafblist li").addClass("selectedOpacity").each(function (a, e) {
        var s = $(e).text();
        t.indexOf(s) > -1 && $(e).removeClass("selectedOpacity")
    })
}

function runSelectedHm(t, a) {
    var e = $(".dansdxbtn li:nth-child(1)").hasClass("lichecked"),
        s = $(".dansdxbtn li:nth-child(2)").hasClass("lichecked"),
        l = $(".dansdxbtn li:nth-child(3)").hasClass("lichecked"),
        i = $(".dansdxbtn li:nth-child(4)").hasClass("lichecked");
    $("#haomafblist li").each(function () {
        var n = $(this).text(), d = n % 2 == 0, o = n >= 6;
        -1 != t.indexOf("单") ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : -1 != t.indexOf("双") ? a ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("大") ? a ? e ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : s ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : -1 != t.indexOf("小") && (a ? e ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : e ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
    })
}

function iframe() {
    if(isfirthload){
        //$(".animate iframe").contents().find("#preloader").show();
        // $(".animate").find(".loading").fadeOut("slow");
        // $(".animate").find(".loading_jisusc").fadeOut("slow");
        // $(".animate").find(".loading_azxy10").fadeOut("slow");
        // $(".animate").find(".loading_ukLotto10").fadeOut("slow");
    }
   /* var t = $(".animate").width(), a = 880 * t / 1310, e = t / 1310;
    setTimeout(function () {
        $(".animate iframe").contents().find("html").css("zoom", e);
        $(".animate iframe").contents().find(".container").height();
        $(".animate").animate({height: a + 50}, 600), $(".animate iframe").animate({height: a + 50}, 600), $(".content").animate({height: a + 35}, 600)
    }, 1), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("#preloader").fadeOut("slow")
    }, 1e3)*/
}

function animate_lz() {
    var t = 0, a = $(".lz_content>div>.lz_item>table>tbody>.tablebox td:first-child p:last-child");
    a.css("font-weight", "bold");
    var e = setTimeout(function () {
        a.fadeOut(100).fadeIn(100), 1 == ++t && (e = setInterval(arguments.callee, 600)), 30 == t && window.clearInterval(e)
    }, 1e3);
    $(function () {
        var t = setInterval(function () {
            0 != $(".tb").length && clearInterval(t), $(".tb").css({color: "#fff", background: "#ED2842"})
        }, 200)
    })
}

function animate_lz_hmqh() {
    var t = 0, a = $(".lz_content>div .lz_item>table>tbody>.tablebox td:first-child p:last-child");
    a.css("font-weight", "bold");
    var e = setTimeout(function () {
        a.fadeOut(100).fadeIn(100), 1 == ++t && (e = setInterval(arguments.callee, 600)), 30 == t && window.clearInterval(e)
    }, 1e3);
    $(function () {
        var t = setInterval(function () {
            0 != $(".tb").length && clearInterval(t), $(".tb").css({color: "#fff", background: "#ED2842"})
        }, 200)
    })
}

function showlz_listitem(t, a) {
    $(".lz_title").hide();
    for (var e = 0; e < t.length; e++) {
        var s = t[e];
        $(a).each(function (t, a) {
            $("." + a).each(function (t, a) {
                $(a).hasClass(s) && $(a).show()
            })
        })
    }
}

function checklhlzMinci() {
    var t = $("#F_lhlzfx").find(".check_tj ");
    $(".tablelist").hide(), $(t).each(function (t, a) {
        var e = "#" + $(a).attr("data-value");
        $(e).show()
    })
}

function fancongshow() {
    if ($(".wezizs .hamafb").hasClass("checkspan")) {
        for (var t = (s = (s = $(".table_hamafb tbody tr")).slice(0, s.length - 6)).length, a = s.filter(":first").children("td").size(), e = 2; e < a; e++) for (l = 0; l <= t && !(i = s.eq(l).children("td").eq(e)).hasClass("hot"); l++) i.addClass("fancongcls");
        return !1
    }
    if ($(".wezizs .sttz").hasClass("checkspan")) s = $(".table_sttz tbody tr"); else if ($(".wezizs .lu012").hasClass("checkspan")) s = $(".table_lu012 tbody tr"); else if ($(".wezizs .spj").hasClass("checkspan")) var s = $(".table_spj tbody tr");
    for (var t = (s = s.slice(0, s.length - 6)).length, a = s.filter(":first").children("td").size(), e = 2; e < a; e++) for (var l = 0; l <= t; l++) {
        var i = s.eq(l).children("td").eq(e);
        if (i.hasClass("numodd") || i.hasClass("numeven")) break;
        i.addClass("fancongcls")
    }
}

function orshowConten() {
    var t = [];
    if ($("#F_bzsz .check_tj").each(function () {
        t.push($(this).attr("data-value"))
    }), t.includes("caix") ? $(".hamafb").hasClass("checkspan") && setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.weizhiLine("trend_table2")
    }, 500) : $(".table_conBox canvas").hide(), t.includes("fancong") ? fancongshow() : ($(".fancongcls").addClass("showspan"), $(".fancongcls").removeClass("fancongcls")), t.includes("yilo") ? ($("td:not([class])").find("span").show(), $(".showspan span").show(), $(".fancongcls span").show()) : ($("td:not([class])").find("span").hide(), $(".fancongcls span").hide(), $(".showspan span").hide()), t.includes("fgx")) {
        if ($(".line_wzzs").remove(), $(".wezizs .hamafb").hasClass("checkspan")) a = $(".table_hamafb tbody tr"); else if ($(".wezizs .sttz").hasClass("checkspan")) a = $(".table_sttz tbody tr"); else if ($(".wezizs .lu012").hasClass("checkspan")) a = $(".table_lu012 tbody tr"); else if ($(".wezizs .spj").hasClass("checkspan")) var a = $(".table_spj tbody tr");
        for (var e = 2; e < a.length - 6; e += 5) $(a[e]).after("<tr class='line_wzzs'><td></td></tr>")
    } else $(".line_wzzs").remove()
}

function checkhmqhlzHm() {
    var t = $("#F_hmqhlzfx .check_tj");
    $(".tablelist").hide(), $(t).each(function (t, a) {
        var e = "#" + $(a).attr("data-value");
        $(e).show()
    })
}

function typeOf(t, a) {
    if ("spj" == a) switch (1 * t) {
        case-1:
            return "降";
        case 0:
            return "平";
        case 1:
            return "升"
    }
}

function fancongshow_gyh() {
    for (var t = $(".gyhdateBox tbody tr"), a = (t = t.slice(0, t.length - 5)).length, e = t.filter(":first").children("td").size(), s = 1; s < e; s++) for (var l = 0; l <= a; l++) {
        var i = t.eq(l).children("td").eq(s);
        if (i.hasClass("hot_gyh")) break;
        i.addClass("fancongcls_gyh")
    }
}

function orshowConten_gyh() {
    var t = [];
    if ($("#F_gyhzs_fx .check_tj").each(function () {
        t.push($(this).attr("data-value"))
    }), t.includes("fancong") ? fancongshow_gyh() : ($(".fancongcls_gyh").addClass("showspan"), $(".fancongcls_gyh").removeClass("fancongcls_gyh")), t.includes("yilo") ? ($(".yilou").find("span").show(), $(".showspan span").show()) : ($(".yilou").find("span").hide(), $(".fancongcls_gyh span").hide(), $(".showspan span").hide()), t.includes("fgx")) {
        $(".line_gyh").remove();
        for (var a = $(".gyhdateBox tbody tr"), e = 2; e < a.length - 5; e += 5) $(a[e]).after("<tr class='line_gyh'><td></td></tr>")
    } else $(".line_gyh").remove();
    t.includes("caix") ? setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.guanyaheLine("trend_table2_gyhzs")
    }, 500) : $("canvas").remove()
}

function showExplain_smwf() {
    $(".explian_smwf").css({height: $("body").height(), top: "0"})
}

function hideExplain_smwf() {
    $(".explian_smwf").css({height: "0", top: "-20rem"})
}

function showSxend() {
    $("#dsdxlzlist .lz_title").hide();
    var t = $("#F_dsdxlzfx").find(".check_tj");
    $(t).each(function (t, a) {
        var e = "." + $(a).attr("data-value"), s = $("#dsdxlzlist").find(e);
        "daxiao" == dxdxlz_val[0] || 0 == dxdxlz_val[0] ? $(s).each(function () {
            $(this).hasClass("daxiaoShow") ? $("#dsdxlzlist").find(this).show() : $("#dsdxlzlist").find(this).hide()
        }) : "danshaung" == dxdxlz_val[0] && $(s).each(function () {
            $(this).hasClass("dansuShow") ? $("#dsdxlzlist").find(this).show() : $("#dsdxlzlist").find(this).hide()
        })
    })
}

function animate_lz_dsdxlz() {
    var t = 0, a = $(".dsdxlz_content>div>.lz_item>table>tbody>.tablebox td:first-child p:last-child");
    a.css("font-weight", "bold");
    var e = setTimeout(function () {
        a.fadeOut(100).fadeIn(100), 1 == ++t && (e = setInterval(arguments.callee, 600)), 30 == t && window.clearInterval(e)
    }, 1e3);
    $(function () {
        var t = setInterval(function () {
            0 != $(".tb").length && clearInterval(t), $(".tb").css({color: "#fff", background: "#ED2842"})
        }, 200)
    })
}

function listettablearr(t) {
    if (!t) return !1;
    t.length <= config.showrows ? $(".lomorediv").hide() : "none" != $(".haomazs").css("display") ? $(".hamafb").hasClass("checkspan") ? ($(".lomorediv").show().attr("data-text", 0), $(".nextlo").show()) : $(".lomorediv").hide() : ($(".lomorediv").show().attr("data-text", 0), $(".nextlo").show()), pk10tabledata = [];
    for (var a = 0, e = Math.ceil(t.length / config.showrows); a < e; a++) {
        var s = [];
        s.push(t.slice(a * config.showrows, (a + 1) * config.showrows)), pk10tabledata.push(s)
    }
    $(".prevlo").hide().parent().attr("data-text", 0)
}

function eachconten_pk10(t) {
    var a = "<tr>", e = 1 * wz_mc_val[0];
    $(t).each(function (t) {
        var s = this.drawCode, l = this.array.slice(0, 10);
        a += " <td>" + this.preIssue + "</td><td class='tabred'><span>" + s[e] + "</span></td>";
        for (var i = 0; i < l.length; i++) 1 * l[i] > 0 ? a += "<td class='hot'><span name='hotSpan'>" + l[i] + "</span></td>" : a += "<td><span>" + Math.abs(l[i]) + "</span></td>";
        a += "</tr>"
    }), $("#trend_table2 tbody").html(a + wzzstablefooter), orshowConten()
}

function eachcontengyhzs(t) {
    $(".gyhdateBox tbody").empty(), $(t).each(function (t) {
        if (10037 == lotCode) a = config.showrows; else var a = 200;
        if (!(t > a)) {
            var e = "<td>" + this.preIssue + "</td>", s = "", l = this.gySum;
            $(this.missing).each(function (t) {
                var a = "", e = "", i = l;
                1 * this > 0 ? (a = "title='0' class='hot_gyh'", e = "style='background:" + color[1] + "'") : (i = Math.abs(this), a = "class='yilou'"), t > 16 || (s += "<td " + a + "><span " + e + ">" + i + "</span></td>")
            });
            var i = "<tr class='yiloutr'>" + e + s + "</tr>";
            $(".gyhdateBox tbody").append(i)
        }
    }), $(".gyhdateBox tbody").append(gyhzsfooter)
}

function lzfxdxms() {
    $(".zhfx_meci").text(lzcheckObj.dxms.checkVal_cn), $(".zhfx_model").text("筛选路珠");
    new MobileSelect({
        trigger: ".zhfx_meci",
        title: "选择名次",
        wheels: condition_dxms_mc,
        position: lzcheckObj.dxms.checkIndex,
        callback: function (t, a, e) {
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
        }, trigger: ".zhfx_model", title: "选择路珠", wheels: condition_zh_lz, callback: function (t, a, e) {
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
        }, trigger: ".zhfx_meci", title: "选择名次", wheels: condition_zh_mc, callback: function (t, a, e) {
            lzcheckObj.lmms.select_arr1 = a, showlz_listitem(lzcheckObj.lmms.select_arr1, lzcheckObj.lmms.checkVal)
        }, onShow: function () {
            this.initSelectedState()
        }
    }), new MobileSelect({
        trigger: ".zhfx_model",
        title: "选择路珠",
        wheels: condition_lmms_lz,
        position: lzcheckObj.lmms.checkIndex,
        callback: function (t, a, e) {
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
        }, trigger: ".zhfx_meci", title: "选择名次", wheels: condition_zh_mc, callback: function (t, a, e) {
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
        }, trigger: ".zhfx_model", title: "选择路珠", wheels: condition_zh_lz, callback: function (t, a, e) {
            lzcheckObj.zhms.select_arr2 = a, showlz_listitem(lzcheckObj.zhms.select_arr1, lzcheckObj.zhms.select_arr2)
        }, onShow: function () {
            this.initSelectedState()
        }
    });
    showlz_listitem(lzcheckObj.zhms.select_arr1, lzcheckObj.zhms.select_arr2)
}

function checkDateFun(t, a) {
    a = void 0 == a ? "" : a;
    var e = $(".title_se_box .se_check").attr("target");
    e = (e = $("#" + e + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_pk10(e, t, a)
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    //视频url初始化
    //$("#videoiframe").attr('src',config.videourl+"view/video/PK10/video.html?"+lotCode);
    pubmethod.initAdata(), method.indexLoad(boxId), ifishad = !0;
    document.addEventListener("touchstart", function () {
        //$("iframe")[0].contentWindow.ifopen && $("iframe")[0].contentWindow.videoTools && $("iframe")[0].contentWindow.videoTools.sounds.play("sound")
    }, !1);
    $("#startVideo").on("click", function () {
        startVideo();//$("iframe")[0].contentWindow.ifopen = !0, $("iframe")[0].contentWindow.ifopen && $("iframe")[0].contentWindow.videoTools && $("iframe")[0].contentWindow.videoTools.sounds.play("sound")
    });
    $("#videobox .closevideo").on("click", function () {
        //clearInterval(pk10jiuchuo);
        $(".content").animate({top: "-80%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"});
            $("#videoiframe").attr('src',"");
        });
        //$("iframe")[0].contentWindow.ifopen = !1, $("iframe")[0].contentWindow.videoTools && $("iframe")[0].contentWindow.videoTools.sounds.stop("sound")
    }), method.loadOther(""), setTimeout(function () {
        config.ifFirstLoad = !0
    }, 4e3)
}), function () {
    tools.initDate();
    var t = "number" == typeof window.orientation && "object" === _typeof(window.onorientationchange);
    window.addEventListener("DOMContentLoaded", function () {
        document.body.parentNode;
        var a, e = function () {
            t && (a = window.orientation, "0px" == $("#videobox").find(".content").css("top") && startVideo())
        };
        t ? window.addEventListener("orientationchange", e, !1) : window.addEventListener("resize", e, !1), e()
    }, !1)
}();
var ifishad = !1, method = {}, isfirthload = !0, pk10weizzsdata = "";
method.loadOther = function (t) {
    if ("" != t || tools.ifOnDay()) {
        setTimeout(function () {
            method.todayData(t)
        }, 1e3), setTimeout(function () {
            method.longData(t)
        }, 2e3);
        var a = $(".headTitle .checkedbl").attr("id");
        if ("" != t) {
            var e = t.split("-");
            t = e[0] + "-" + 1 * e[1] + "-" + (1 * e[2] < 10 ? "0" + 1 * e[2] : 1 * e[2])
        }
        tools.classGetDate_pk10(a, t, ""), void 0 != t && "" != t && $("." + $(".checkedbl").attr("id")).find(".showtime_box").addClass("checkspan").siblings(".checkday").find("span").removeClass("checkspan")
    }
}, method.indexLoad = function (t) {
    var a = $(t).find(".nextIssue").val(), t = "#" + $(t).attr("id");
    headMethod.loadHeadData(a, t)
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "pks/getPksHistoryList.do?date=" + t,
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
    void 0 == t && (t = ""), $.ajax({
        url: config.publicUrl + "pks/getPksDoubleCount.do?date=" + t,
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
        url: config.publicUrl + "pks/getPksLongDragonCount.do?date=" + t,
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
        this.data = t, this.once = 200, this.contArr = ["#numlist", "#haomafblist"], this.contArr.forEach(function (e) {
            $(e).empty(), a[e] = {curIndex: 0, totalPage: Math.ceil(t.length / a.once) - 1}
        }), "haomafb" === $("#allSele .checkedbl").attr("id") ? this.parentClass = "#haomafblist" : this.parentClass = "#numlist", createHtmlStr(t.slice(this[this.parentClass].curIndex, this.once), this.contArr), this.watchDom = $(this.parentClass + " .listline:last-child")[0], $(window).off("scroll").on("scroll", throttle(this.scrollCb.bind(this), 400, 1e3))
    }, scrollCb: function () {
        if (!this.scrollFlag && this.watchDom.getBoundingClientRect().top < window.screen.height + 200) {
            var t = this[this.parentClass];
            0 === t.totalPage && (this.watchDom = null, $(window).off("scroll")), this.scrollFlag = !0, t.curIndex = t.curIndex + this.once, createHtmlStr(this.data.slice(t.curIndex, t.curIndex + this.once), this.parentClass), this.watchDom = $(this.parentClass + " .listline:last-child")[0], "#haomafblist" === this.parentClass ? runFilterRender() : method.selectedBS($(".rightdiv").find(".spanchecked"), !0), --t.totalPage, this.scrollFlag = !1
        }
    }
};
method.selectedBS = function (t, a) {
    var e = $(t).attr("id");
    $(t).siblings().removeClass("spanchecked"), a || $(t).addClass("spanchecked"), "gjlh" == e ? ($("#numlist .haomali").removeClass("displayblock").addClass("displaynone"), $("#numlist .longhuli").removeClass("displaynone").addClass("displayblock")) : ($("#numlist .haomali").removeClass("displaynone").addClass("displayblock"), $("#numlist .longhuli").removeClass("displayblock").addClass("displaynone")), $("#numlist .haomali li").each(function (t) {
        var a = $(this).text(), s = a % 2 == 0, l = a >= 6;
        "xshm" == e ? ($(this).removeClass(), $(this).addClass("nubb" + a), (t + 1) % 10 == 0 && $(this).addClass("nubb" + a + " li_after")) : "xsdx" == e ? ($(this).removeClass(), l ? ($(this).addClass("numbig"), (t + 1) % 10 == 0 && $(this).addClass("numbig li_after")) : ($(this).addClass("numsm"), (t + 1) % 10 == 0 && $(this).addClass("numsm li_after"))) : "xsds" == e && ($(this).removeClass(), s ? ($(this).addClass("nums"), (t + 1) % 10 == 0 && $(this).addClass("nums li_after")) : ($(this).addClass("numd"), (t + 1) % 10 == 0 && $(this).addClass("numd li_after")))
    })
}, method.selectedHm = function (t) {
    if ($(t).parents(".dansdxbtn").length > 0) {
        var a = $(t).hasClass("lichecked");
        $(".numbtn").find("li").removeClass("lichecked"), $(t).toggleClass("lichecked");
        var e = $(t).text(), s = [null, "双", "单", "小", "大"].indexOf(e);
        $(".dansdxbtn li:nth-child(" + s + ")").removeClass("lichecked"), runSelectedHm(e, a)
    } else $(".dansdxbtn li").removeClass("lichecked"), $(t).toggleClass("lichecked"), $(".numbtn .lichecked").length > 0 ? runNumFilter() : $("#haomafblist li").removeClass("selectedOpacity")
}, method.loadTodayData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data;
        var a = [{data: [data.firstSingleCount, data.firstDoubleCount, data.firstBigCount, data.firstSmallCount, data.firstDragonCount, data.firstTigerCount]}, {data: [data.secondSingleCount, data.secondDoubleCount, data.secondBigCount, data.secondSmallCount, data.secondDragonCount, data.secondTigerCount]}, {data: [data.thirdSingleCount, data.thirdDoubleCount, data.thirdBigCount, data.thirdSmallCount, data.thirdDragonCount, data.thirdTigerCount]}, {data: [data.fourthSingleCount, data.fourthDoubleCount, data.fourthBigCount, data.fourthSmallCount, data.fourthDragonCount, data.fourthTigerCount]}, {data: [data.fifthSingleCount, data.fifthDoubleCount, data.fifthBigCount, data.fifthSmallCount, data.fifthDragonCount, data.fifthTigerCount]}, {data: [data.sixthSingleCount, data.sixthDoubleCount, data.sixthBigCount, data.sixthSmallCount]}, {data: [data.seventhSingleCount, data.seventhDoubleCount, data.seventhBigCount, data.seventhSmallCount]}, {data: [data.eighthSingleCount, data.eighthDoubleCount, data.eighthBigCount, data.eighthSmallCount]}, {data: [data.ninthSingleCount, data.ninthDoubleCount, data.ninthBigCount, data.ninthSmallCount]}, {data: [data.tenthSingleCount, data.tenthDoubleCount, data.tenthBigCount, data.tenthSmallCount]}, {data: [data.sumSingleCount, data.sumDoubleCount, data.sumBigCount, data.sumSmallCount]}];
        $("#liangmianbox").empty(), $(a).each(function (t) {
            var a = "";
            $(this.data).each(function () {
                a += "<td>" + this + "</td>"
            });
            var e = tools.typeOf("rank", t + 1), s = "";
            0 == t ? s = "head1" : 1 == t && (s = "head2");
            var l = "";
            t >= 5 || (l = "<td>龙</td><td>虎</td>");
            var i = '<div class="lianmlist"><div  class="head ' + s + '">' + e + '</div><table cellpadding="0" cellspacing="0" border="0"><tr class="tr1"><td>单</td><td>双</td><td>大</td><td>小</td>' + l + '</tr><tr class="tr2">' + a + "</tr></table></div>";
            $("#liangmianbox").append(i)
        })
    }
}, method.loadLongData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data, config.ifdebug, $("#longDrag").empty("");
        for (var a = 0, e = data.length; a < e; a++) {
            var s = tools.typeOf("rank", data[a].rank), l = tools.typeOf("stated", data[a].state),
                i = data[a].count >= 5 ? "<span style='color:#f11821'>" + data[a].count + "</span>" : "<span>" + data[a].count + "</span>",
                n = "<li><span>" + s + "</span>：<span>" + l + "</span>" + i + "期</li>";
            11 != data[a].rank && 1 != data[a].rank && 2 != data[a].rank || (n = "<li><span>" + s + "</span>：<span>" + l + "</span>" + i + "期</li>"), $("#longDrag").append(n)
        }
    }
}, $(".checkClick").on("click", function () {
    $("#gcCheckqisho").addClass("gotop"), $(".gotop").css("height", $("body").height())
}), $("#gcCheckqisho .Page_content").on("click", "ul>li", function () {
    $(this).toggleClass("check_tj or_")
}), $("#gcCheckqisho").on("click", ".checkAll,.noAll", function () {
    "checkAll" == $(this).attr("class") ? $("#gcCheckqisho li").addClass("check_tj") : $("#gcCheckqisho li").removeClass("check_tj")
}), $("#gcCheckqisho").on("click", ".sure", function () {
    $(".gotop").css("height", "0rem"), $(".loteyPage").removeClass("gotop"), $(".or_").removeClass("or_"), $(".marginTop>li").each(function (t, a) {
        $(a).hasClass("check_tj") ? $(".item_" + $(a).attr("data-text")).show() : $(".item_" + $(a).attr("data-text")).hide()
    }), $(".show_zonkai").hasClass("check_tj") ? $(".zongkai_item").show() : $(".zongkai_item").hide(), $(".show_weikai").hasClass("check_tj") ? $(".weikai_item").show() : $(".weikai_item").hide()
}), $(".navTab").on("click", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), "personCheck" == $(this).attr("id") ? ($("#zhkanList").css("display", "none"), $("#personList").css("display", "block")) : ($("#zhkanList").css("display", "block"), $("#personList").css("display", "none"))
}), $("#minciBox").find("ul").find("li").on("click", function () {
    $(this).hasClass("minciLiAct") || $(this).addClass("minciLiAct").siblings().removeClass();
    var t = $(this).find("i").text();
    $("#tbody" + t).hasClass("displaynone") && $("#tbody" + t).removeClass().siblings("tbody").addClass("displaynone")
}), $("#dsdxBox").find("ul").find("li").on("click", function () {
    $(this).hasClass("dsdxActcolor") || $(this).addClass("dsdxActcolor").siblings().removeClass();
    var t = $(this).find("i").text();
    $("#gtbody" + t).hasClass("displaynone") && $("#gtbody" + t).removeClass().siblings("tbody").addClass("displaynone")
}), $("#hmqhlzmcul").find("li").on("click", function () {
    $(this).toggleClass("hmqhlzHMAct or_e")
}), $(".qhlzallxuan").on("click", function () {
    $("#hmqhlzmcul li").addClass("hmqhlzHMAct")
}), $(".qhlzclearall").on("click", function () {
    $("#hmqhlzmcul li").removeClass("hmqhlzHMAct")
}), $(".lookshjtj").on("click", function (t) {
    t.preventDefault();
    var a = $(".wezizs .Pattern .checkspan").attr("class").replace(" ", "").replace("checkspan", "");
    $(".table_" + a).find(".clospan");
    $("html,body").animate({scrollTop: $(".footer").offset().top}, 500)
}), $(".wezizs").on("click", ".Pattern span", function (t) {
    var a = $(this).attr("class").replace(" ", "").replace("checkspan", "");
    $(".table_" + a).show().siblings().hide(), $(t.target).hasClass("hamafb") ? $(".wzzslodiv").show() : $(".wzzslodiv").hide(), orshowConten()
}), $("#tiaojian_wzzs").on("click", ".marginTop>li", function () {
    $(this).toggleClass("check_tj or_")
}), $("#gltjhmNum li").on("click", function () {
    $(this).addClass("hmglNumAct").siblings().removeClass("hmglNumAct");
    $("#gltjhmNum li").length;
    code = $("#gltjhmNum li[class='hmglNumAct']").text();
    var t = "", a = "", e = $(".btnList .checkday .checkspan");
    void 0 != e.attr("data-value") ? a = getDateStr(1 * e.attr("data-value"), !0) : t = e.text().replace(/[\u4E00-\u9FA5]/gi, ""), pk10FunObj.hmgltj.gltjData(t, a), $(".circle" + code).removeClass("defalut_circle");
    for (var s = 1; s < 11; s++) s != code && $(".circle" + s).addClass("defalut_circle")
}), $(".tusjbox span").on("click", function () {
    $(this).addClass("tubiaocheck").siblings().removeClass("tubiaocheck");
    var t = $(".tubiaocheck").text();
    "图表" == t ? ($("#tblist").removeClass("displaynone"), $("#datelist").removeClass().addClass("displaynone")) : "数据" == t && ($("#tblist").removeClass().addClass("displaynone"), $("#datelist").removeClass("displaynone"))
}), $(".qihsj").find("span").on("click", function () {
    $(this).addClass("gltjHMfb").siblings("span").removeClass("gltjHMfb");
    var t = $(".gltjHMfb").attr("id");
    "dsdxId" == t ? ($("#sjdsdxList").removeClass("displaynone"), $(".sjhmfbList").addClass("displaynone")) : "hmfbId" == t && ($("#sjdsdxList").addClass("displaynone"), $(".sjhmfbList").removeClass("displaynone"), setTimeout(function () {
        $("canvas").remove(), chartOfBaseTrend.haomagltj("trend_table2_hmgltj")
    }, 500))
}), $(".gyhcksjtj").on("click", function (t) {
    t.preventDefault(), $("html,body").animate({scrollTop: $(".clospan_gyh").offset().top}, 500)
}), $("#explainBtn_wfsm").on("click", function () {
    showExplain_smwf()
}), $(".closesm").on("click", function () {
    hideExplain_smwf()
});
var wzzstablefooter = "", gyhzsfooter = "", pk10tabledata = "";
$(".wzzslodiv").on("click", "span", function (t) {
    var a = $(this), e = pk10tabledata.length, s = 1 * $(this).parent().attr("data-text");
    "wzzslo_left" == a.attr("id") ? (s - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", s -= 1)) : "wzzslo_right" == a.attr("id") && (s + 2 == e && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", s += 1)), eachconten_pk10(pk10tabledata[s][0]), $("html,body").animate({scrollTop: $(".haomazs").offset().top}, 500)
}), $(".gyhzslodiv").on("click", "span", function (t) {
    var a = $(this), e = pk10tabledata.length, s = 1 * $(this).parent().attr("data-text");
    "gyhzslo_left" == a.attr("id") ? (s - 1 == 0 && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", s -= 1)) : "gyhzslo_right" == a.attr("id") && (s + 2 == e && $(this).hide(), $(this).siblings().css("display", "inline-block").parent().attr("data-text", s += 1)), eachcontengyhzs(pk10tabledata[s][0]), $("html,body").animate({scrollTop: $(".headTitle").offset().top}, 500), orshowConten_gyh()
});
var pk10FunObj = {
        jrhmtj: {
            init: function () {
                this.getdata()
            }, getdata: function (t) {
                t = void 0 == t ? "" : t, $.ajax({
                    url: config.publicUrl + "pks/queryToDayNumberLawOfStatistics.do?date=" + t,
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.jrhmtj.createHtml(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, createHtml: function (t) {
                var a = null;
                if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode) {
                    for (var e = "", s = a.result.data, l = "", i = "", n = 0; n < s.length; n++) {
                        0 == n ? l = "冠军" : 1 == n ? l = "亚军" : 2 == n ? l = "第三" : 3 == n ? l = "第四" : 4 == n ? l = "第五" : 5 == n ? l = "第六" : 6 == n ? l = "第七" : 7 == n ? l = "第八" : 8 == n ? l = "第九" : 9 == n && (l = "第十"), e += "<div class='item_" + (n + 1) + " item_'><span class='item_title'>" + l + "</span><ul class='num_item'>", e += "<li class='li_first'>号码</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li> <li>7</li><li>8</li><li>9</li><li>10</li></ul>";
                        for (var d = "<ul class='zongkai_item'><li class='li_first'>总开</li>", o = "<ul class='weikai_item'><li class='li_first'>未开</li>", c = 0; c < 10; c++) {
                            var r = s[c].list[n];
                            if (r.accumulate >= 15 && r.accumulate <= 30) h = "rednum_tj"; else if (r.accumulate >= 31 && r.accumulate <= 40) h = "bluenum_tj"; else if (r.accumulate >= 41 && r.accumulate <= 50) h = "greennum_tj"; else var h = "";
                            if (r.missing >= 15 && r.missing <= 30) u = "rednum_tj"; else if (r.missing >= 31 && r.missing <= 40) u = "bluenum_tj"; else if (r.missing >= 41 && r.missing <= 50) u = "greennum_tj"; else var u = "";
                            d += "<li class='" + h + "'>" + r.accumulate + "</li>", o += "<li class='" + u + "'>" + r.missing + "</li>"
                        }
                        e += d + "</ul>" + o + "</ul></div>"
                    }
                    i += e
                }
                $(".todayhaomatj .showconten").html(e)
            }
        }, lzfx: {
            init: function () {
                this.getlist("")
            }, getlist: function (t) {
                $.ajax({
                    url: config.publicUrl + "pks/queryComprehensiveRoadBead.do",
                    type: "GET",
                    data: {lotCode: lotCode, date: t},
                    success: function (t) {
                        pk10FunObj.lzfx.addlzTable(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, addlzTable: function (t) {
                var a = null;
                if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                    $(".luzufx .lz_content").html("");
                    for (var e = "", s = 0; s < a.result.data.length; s++) {
                        var l = a.result.data[s].state;
                        if (1 == l) {
                            var i = "双", n = "单", d = "单双";
                            e = "dansuShow"
                        } else if (2 == l) {
                            var i = "小", n = "大", d = "大小";
                            e = "daxiaoShow"
                        } else if (3 == l) {
                            var i = "虎", n = "龙", d = "龙虎";
                            e = "longhuShow"
                        }
                        var o = a.result.data[s].rank,
                            c = "<div class='lz_title " + e + " ball_" + o + "'><div class='left'><span>今日累计:</span>",
                            r = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                        a.result.data[s].roadBeads = a.result.data[s].roadBeads.reverse();
                        for (var h = 0, u = 0, f = 0, p = 0; h < a.result.data[s].roadBeads.length && !(h >= 200); h++) {
                            var m = a.result.data[s].roadBeads[h];
                            0 == m ? (m = i, u += 1) : 1 == m ? (m = n, f += 1) : 2 == m && (m = text3, p += 1), 0 == h && (r += "<p>" + m + "</p>"), h > 0 & a.result.data[s].roadBeads[h - 1] == a.result.data[s].roadBeads[h] ? r += "<p>" + m + "</p>" : h > 0 & a.result.data[s].roadBeads[h - 1] != a.result.data[s].roadBeads[h] && (r += "</td><td><p>" + m + "</p>")
                        }
                        var b = "";
                        1 == o ? b = "冠军" : 2 == o ? b = "亚军" : 3 == o ? b = "第三名" : 4 == o ? b = "第四名" : 5 == o ? b = "第五名" : 6 == o ? b = "第六名" : 7 == o ? b = "第七名" : 8 == o ? b = "第八名" : 9 == o ? b = "第九名" : 10 == o ? b = "第十名" : 11 == o && (b = "冠亚和");
                        var g = "<span>" + i + "（" + a.result.data[s].totals[1] + "）</span><span>" + n + "（" + a.result.data[s].totals[0] + "）</span></div><div class='right'><span class='weizi'>" + b + "</span><span class='mosh'>" + d + "</span><span class='zxi'>最新    &darr;</span></div>";
                        $(".luzufx .lz_content").append(c + g + r + "</td></tr></tbody></table></div></div>")
                    }
                    $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red");
                    var v = $(".luzufx .Pattern .checkspan");
                    $("#F_zhfx_meci").parents(".mobileSelect").remove(), $("#F_zhfx_model").parents(".mobileSelect").remove(), v.hasClass("zonghu") ? lzfxzhms() : v.hasClass("danxms") ? lzfxdxms() : lzfxlmms(), animate_lz()
                } else tools.weikaiji(".luzufx .lz_content")
            }
        }, dsdxlsObj: {
            dsdxlsData: function () {
                $.ajax({
                    url: config.publicUrl + "pks/queryHistoryDataForDsdx.do",
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.dsdxlsObj.dsdxliHtmlList(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, dsdxliHtmlList: function (t) {
                var a = null;
                "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
                var e = a.result.data, s = "";
                $("#tableBox tbody").empty(), $(e).each(function (t) {
                    for (var a = $(this)[0], e = "", l = "<td >" + a.date + "</td>", i = 0; i < 10; i++) {
                        var n = "tr" + i;
                        n = "<tr style='height:38px'>" + l + ("<td >" + a.list[i].bigCount + "</td><td >" + a.list[i].smallCount + "</td><td >" + a.list[i].singleCount + "</td><td >" + a.list[i].doubleCount + "</td>") + "</tr>", $("#tbody" + i).append(n)
                    }
                    for (var d = 0; d < 4; d++) {
                        e = "getiTd" + d;
                        for (i = 0; i < a.list.length; i++) e += "<td>" + (0 == d ? a.list[i].singleCount : 1 == d ? a.list[i].doubleCount : 2 == d ? a.list[i].bigCount : a.list[i].smallCount) + "</td>";
                        s = "<tr style='height:38px'>" + l + e + "</tr>", $("#gtbody" + d).append(s)
                    }
                })
            }
        }, longhutjObj: {
            longhutjData: function () {
                $.ajax({
                    url: config.publicUrl + "pks/queryHistoryDataForDt.do",
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.longhutjObj.cltjHtmlList(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, cltjHtmlList: function (t) {
                var a = null;
                "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
                var e = a.result.data;
                $("#longhutjBox").find("tbody").empty(), $(e).each(function (t) {
                    var a = "<tr>" + ("<td>" + $(this)[0].date + "</td>") + ("<td height='33'>" + $(this)[0].firstDragon + "</td>") + ("<td>" + $(this)[0].firstTiger + "</td>") + ("<td>" + $(this)[0].secondDragon + "</td>") + ("<td>" + $(this)[0].secondTiger + "</td>") + ("<td>" + $(this)[0].thirdDragon + "</td>") + ("<td>" + $(this)[0].thirdTiger + "</td>") + ("<td>" + $(this)[0].fourthDragon + "</td>") + ("<td>" + $(this)[0].fourthTiger + "</td>") + ("<td>" + $(this)[0].fifthDragon + "</td>") + ("<td>" + $(this)[0].fifthTiger + "</td>") + "</tr>";
                    $("#longhutjBox").find("tbody").append(a)
                })
            }
        }, gyhlmlsObj: {
            gyhlmlsData: function () {
                $.ajax({
                    url: config.publicUrl + "pks/queryHistoryDataForGyh.do",
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.gyhlmlsObj.gyhlmlsHtmlList(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, gyhlmlsHtmlList: function (t) {
                var a = null;
                "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
                var e = a.result.data;
                $("#gyhlmlsBox").find("tbody").empty(), $(e).each(function () {
                    var t = "<tr height='40'>" + ("<td>" + this.date + "</td>") + ("<td>" + this.gyhBig + "</td>") + ("<td>" + this.gyhSmall + "</td>") + ("<td>" + this.gyhSingle + "</td>") + ("<td>" + this.gyhDouble + "</td>") + "</tr>";
                    $("#gyhlmlsBox").find("tbody").append(t)
                })
            }
        }, lhlz: {
            lhlzsData: function (t) {
                "" == (t = void 0 == t ? "" : t) && $("#today").addClass("todayAct hmqhlxdayAct").siblings().removeClass("todayAct hmqhlxdayAct"), $.ajax({
                    url: config.publicUrl + "pks/queryComprehensiveRoadBead.do?date=" + t,
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.lhlz.lhlzHtmlList(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, lhlzHtmlList: function (t) {
                var a = null;
                "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
                var e = a.result.data;
                0 != e.length ? ($("#lhlzlist").find(".lhlzItems").empty(), $(e).each(function (t) {
                    this.rank <= 5 && 3 == this.state && (pk10FunObj.lhlz.forRank(this.rank, this), 14 == t && animate_lz_hmqh())
                })) : tools.weikaiji("#lhlzlist .lhlzItems")
            }, forRank: function (t, a) {
                var e = a.totals[0], s = a.totals[1], l = a.roadBeads, i = pk10FunObj.lhlz.typeOf_lhlz(a.rank, "rank"),
                    n = "", d = "";
                n = "<div id='t" + (t - 1) + "' class='tablelist " + (1 * t > 2 ? "displaynone" : "displayblock") + "'><div class='itemHead'><div class='l_jrlj'>今日累计：<span class='lspan'>龙（<i class='longNum'>" + e + "</i>）</span><span class='rspan'>虎（<i class='huNum'>" + s + "</i>）</span></div><div class='r_new'><span>" + i + "</span><span>龙虎</span><span>最新 &darr;</span></div></div>" + "" + "<div class='itemBody'><div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'>" + "</tr></tbody></table></div></div></div>", $("#lhlzlist").find(".lhlzItems").append(n), $(l.reverse()).each(function (a) {
                    if (!(a >= 200)) {
                        var e = "", s = "", i = 1 == this ? "龙" : "虎";
                        a > 0 ? l[a] != l[a - 1] ? (e = "<td><p>" + i + "</p></td>", $("#t" + (t - 1) + " .tablebox").append(e)) : (s = "<p>" + i + "</p>", $("#t" + (t - 1) + " .tablebox").find("td:last-child").append(s)) : (d = "<td><p>" + i + "</p></td>", $("#t" + (t - 1) + " .tablebox").append(d))
                    }
                }), checklhlzMinci()
            }, typeOf_lhlz: function (t, a) {
                if ("rank" == a) switch (1 * t) {
                    case 1:
                        return "冠军";
                    case 2:
                        return "亚军";
                    case 3:
                        return "第三名";
                    case 4:
                        return "第四名";
                    case 5:
                        return "第五名"
                } else if ("code" == a) switch (1 * t) {
                    case 1:
                        return "号码1";
                    case 2:
                        return "号码2";
                    case 3:
                        return "号码3";
                    case 4:
                        return "号码4";
                    case 5:
                        return "号码5";
                    case 6:
                        return "号码6";
                    case 7:
                        return "号码7";
                    case 8:
                        return "号码8";
                    case 9:
                        return "号码9";
                    case 10:
                        return "号码10"
                }
            }
        }, gyhlz: {
            init: function () {
                this.getlist("")
            }, getlist: function (t) {
                "" == t && $(".today_lz").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                    url: config.publicUrl + "pks/queryComprehensiveRoadBead.do",
                    type: "GET",
                    data: {lotCode: lotCode, date: t},
                    success: function (t) {
                        pk10FunObj.gyhlz.addlzTable(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, addlzTable: function (t) {
                var a = null;
                if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                    $(".guyahelz .lz_content").html("");
                    for (var e = "", s = 0; s < a.result.data.length; s++) {
                        var l = a.result.data[s].state;
                        if (1 == l) {
                            var i = "双", n = "单", d = "单双";
                            e = "dansuShow"
                        } else if (2 == l) {
                            var i = "小", n = "大", d = "大小";
                            e = "daxiaoShow"
                        }
                        if (11 == a.result.data[s].rank) {
                            var o = "<div class='lz_title " + e + " ball_" + l + "'><div class='left'><span>今日累计:</span>",
                                c = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                            a.result.data[s].roadBeads = a.result.data[s].roadBeads.reverse();
                            for (var r = 0, h = 0, u = 0, f = 0; r < a.result.data[s].roadBeads.length && !(r >= 200); r++) {
                                var p = a.result.data[s].roadBeads[r];
                                0 == p ? (p = i, h += 1) : 1 == p ? (p = n, u += 1) : 2 == p && (p = text3, f += 1), 0 == r && (c += "<p>" + p + "</p>"), r > 0 & a.result.data[s].roadBeads[r - 1] == a.result.data[s].roadBeads[r] ? c += "<p>" + p + "</p>" : r > 0 & a.result.data[s].roadBeads[r - 1] != a.result.data[s].roadBeads[r] && (c += "</td><td><p>" + p + "</p>")
                            }
                            var m = "<span>" + i + "（" + a.result.data[s].totals[1] + "）</span><span>" + n + "（" + a.result.data[s].totals[0] + "）</span></div><div class='right'><span class='weizi'>冠亚和</span><span class='mosh'>" + d + "</span><span class='zxi'>最新    &darr;</span></div>";
                            $(".guyahelz .lz_content").append(o + m + c + "</td></tr></tbody></table></div></div>")
                        }
                    }
                    $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red"), animate_lz()
                } else tools.weikaiji(".guyahelz .lz_content")
            }
        }, lerefx: {
            init: function () {
                this.getdata()
            }, getdata: function () {
                $.ajax({
                    url: config.publicUrl + "pks/queryDrawCodeHeatState.do",
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.lerefx.createHtml(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, createHtml: function (t) {
                var a = null;
                if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 == a.errorCode) for (var e = "", s = a.result.data, l = "", i = 0; i < s.length; i++) {
                    0 == i ? l = "冠军" : 1 == i ? l = "亚军" : 2 == i ? l = "第三名" : 3 == i ? l = "第四名" : 4 == i ? l = "第五名" : 5 == i ? l = "第六名" : 6 == i ? l = "第七名" : 7 == i ? l = "第八名" : 8 == i ? l = "第九名" : 9 == i && (l = "第十名"), e += "<div class='item_lere" + (i + 1) + " item_'><span class='item_title'>" + l + "</span><ul class='num_item'>", e += "<li class='li_first'>热号</li>";
                    for (var n = "<ul class='zongkai_item'><li class='li_first'>温号</li>", d = "<ul class='weikai_item'><li class='li_first'>冷号</li>", o = "", c = s[i].list[0].list, r = s[i].list[1].list, h = s[i].list[2].list, u = 0; u < c.length; u++) o += "<li class='hotnum'><span>" + c[u].drawCode + "</span><span class='spanclass'>" + c[u].count + "</span></li>";
                    for (var f = 0; f < r.length; f++) n += "<li class='hotnum'>" + r[f].drawCode + "</li>";
                    for (var p = 0; p < h.length; p++) d += "<li class='hotnum'>" + h[p].drawCode + "</li>";
                    e += o + "</ul>" + n + "</ul>" + d + "</ul></div>"
                }
                $(".lenrefx .showconten").html(e)
            }
        }, hmqhlz: {
            hmqhlzData: function (t) {
                "" == (t = void 0 == t ? "" : t) && $("#qhlztoday").addClass("todayAct hmqhlxdayAct").siblings().removeClass("todayAct hmqhlxdayAct"), $.ajax({
                    url: config.publicUrl + "pks/queryFbRoadBead.do?date=" + t,
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.hmqhlz.hmqhlzHtmlList(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, hmqhlzHtmlList: function (t) {
                var a = null;
                "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
                var e = a.result.data;
                0 != e.length ? ($("#hmqhlzlist").find(".hmqhlzItems ").empty(), $(e).each(function (t) {
                    pk10FunObj.hmqhlz.forRank(this.code, this)
                })) : tools.weikaiji("#hmqhlzlist .hmqhlzItems")
            }, forRank: function (t, a) {
                var e = a.totals[0], s = a.totals[1], l = a.roadBeads, i = pk10FunObj.lhlz.typeOf_lhlz(a.code, "code"),
                    n = "", d = "";
                n = "<div id='hm" + t + "' class='tablelist " + (1 * t > 2 ? "displaynone" : "displayblock") + "'><div class='itemHead'><div class='l_jrlj'>今日累计：<span class='lspan'>前（<i class='longNum'>" + e + "</i>）</span><span class='rspan'>后（<i class='huNum'>" + s + "</i>）</span></div><div class='r_new'><span>" + i + "</span><span>前后</span><span>最新 &darr;</span></div></div>" + "" + "<div class='itemBody'><div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'>" + "</tr></tbody></table></div></div></div>", $("#hmqhlzlist").find(".hmqhlzItems").append(n), $(l.reverse()).each(function (a) {
                    if (!(a >= 200)) {
                        var e = "", s = "", i = 1 == this ? "前" : "后";
                        a > 0 ? l[a] != l[a - 1] ? (e = "<td><p>" + i + "</p></td>", $("#hm" + t + " .tablebox").append(e)) : (s = "<p>" + i + "</p>", $("#hm" + t + " .tablebox").find("td:last-child").append(s)) : (d = "<td><p>" + i + "</p></td>", $("#hm" + t + " .tablebox").append(d))
                    }
                }), checkhmqhlzHm(), 10 == t && animate_lz_hmqh()
            }
        }, wzzs: {
            init: function () {
                this.getlist("", 30)
            }, getlist: function (t, a) {
                t = void 0 == t ? "" : t, a = void 0 == a ? "" : a, "" != t && t != getDateStr(0, !0) || "" != a || ($(".shjian").text("今天"), $("#periods_wzzs ul li:first").addClass("checked").siblings().removeClass("checked")), $.ajax({
                    url: config.publicUrl + "pks/queryLocationTrend.do?date=" + t + "&periods=" + a,
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10weizzsdata = t;
                        $(".weai").attr("data-text");
                        var a = wz_mc_val[0] || 0;
                        pk10FunObj.wzzs.createHtmlList(t, a)
                    },
                    error: function (t) {
                        setTimeout(function () {
                            loadotherData()
                        }, 1e3), config.ifdebug
                    }
                })
            }, createHtmlList: function (t, a) {
                if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.result.data.length) return tools.weikaiji(".wezizs #chartLinediv"), !1;
                var e = data.result.data[a];
                if (!e) return $(".wezizs #chartLinediv").html(""), !1;
                listettablearr(e.bodyList), $(".prevlo").hide(), $(".wezizs #chartLinediv").html("");
                var s = "", l = "", i = "", n = "";
                s += " <table  class='table_hamafb displaynone' id='trend_table2'>", s += "<thead><tr><th>期号</th><th>号码</th><th>1</th><th>2</th>", s += "<th>3</th><th>4</th><th>5</th>", s += "<th>6</th><th>7</th><th>8</th><th>9</th><th>10</th></tr></thead><tbody><tr>", l += "<table class='table_sttz displaynone'>", l += "<thead><tr><th>期数</th><th>号码</th><th colspan='2'>奇偶</th>", l += "<th colspan='2'>大小</th><th colspan='2'>质合</th></tr></thead><tbody><tr>", i += "<table class='table_lu012 displaynone'><thead><tr><th>期号</th><th class='short'>号码</th><th>0</th><th>1</th><th>2</th></tr></thead><tbody><tr>", n += "<table class='table_spj displaynone'><thead><tr><th>期号</th><th class='short'>号码</th><th>升</th><th>平</th><th>降</th></tr></thead><tbody><tr>", $(e.bodyList).each(function (t) {
                    var e = this.drawCode, d = this.array.slice(0, 10), o = this.array.slice(10, 16),
                        c = this.array.slice(16, 19), r = this.array.slice(19);
                    if (10037 == lotCode) h = config.showrows; else var h = 200;
                    if (t < h) {
                        s += " <td>" + this.preIssue + "</td><td class='tabred'><span>" + e[a] + "</span></td>";
                        for (var u = 0; u < d.length; u++) 1 * d[u] > 0 ? s += "<td class='hot'><span name='hotSpan'>" + d[u] + "</span></td>" : s += "<td><span>" + Math.abs(d[u]) + "</span></td>";
                        s += "</tr>"
                    }
                    l += "<td>" + this.preIssue + "</td> <td class='tabred'><span>" + e[a] + "</span></td>", $(o).each(function (t) {
                        var a = "";
                        a = 1 * this > 0 ? 0 == t ? "<td class='numeven'><span>奇</span></td>" : 1 == t ? "<td class='numodd'><span>偶</span></td>" : 2 == t ? "<td class='numeven'><span>大</span></td>" : 3 == t ? "<td class='numodd'><span>小</span></td>" : 4 == t ? "<td class='numeven'><span>质</span></td>" : 5 == t ? "<td class='numodd'><span>合</span></td>" : Math.abs(this) : "<td><span>" + Math.abs(this) + "</span></td>", l += a
                    }), l += "</tr>", i += "<td>" + this.preIssue + "</td> <td class='tabred'><span>" + e[a] + "</span></td>", $(c).each(function (t) {
                        var a = "";
                        a = 1 * this > 0 ? 0 == t ? "<td class='numeven'><span>0</span></td>" : 1 == t ? "<td class='numodd'><span>1</span></td>" : 2 == t ? "<td class='numeven'><span>2</span></td>" : Math.abs(this) : "<td><span>" + Math.abs(this) + "</span></td>", i += a
                    }), i += "</tr>", n += "<td>" + this.preIssue + "</td> <td class='tabred'><span>" + e[a] + "</span></td>", $(r).each(function (t) {
                        var a = "";
                        a = 1 * this > 0 ? 0 == t ? "<td class='numeven'><span>升</span></td>" : 1 == t ? "<td class='numodd'><span>平</span></td>" : 2 == t ? "<td class='numeven'><span>降</span></td>" : Math.abs(this) : "<td><span>" + Math.abs(this) + "</span></td>", n += a
                    }), n += "</tr>"
                });
                var d = e.title.appearCount.slice(0, 10), o = e.title.averageMissingValues.slice(0, 10),
                    c = [], r = e.title.maxAppearValues.slice(0, 10),
                    h = e.title.maxMissingValues.slice(0, 10), u = e.title.appearCount.slice(10, 16),
                    f = e.title.averageMissingValues.slice(10, 16), p = [],
                    m = e.title.maxAppearValues.slice(10, 16), b = e.title.maxMissingValues.slice(10, 16),
                    g = e.title.appearCount.slice(16, 19), v = e.title.averageMissingValues.slice(16, 19),
                    _ = [], y = e.title.maxAppearValues.slice(16, 19),
                    z = e.title.maxMissingValues.slice(16, 19), C = e.title.appearCount.slice(19),
                    x = e.title.averageMissingValues.slice(19), k = [],
                    w = e.title.maxAppearValues.slice(19), j = e.title.maxMissingValues.slice(19);
                s += "</tr>";
                var S = "<tr class='clospan'><td colspan='2'>数据统计</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td></tr>";
                l += "</tr><tr class='clospan'><td colspan='2'>数据统计</td><td colspan='2'>奇偶</td><td colspan='2'>大小</td><td colspan='2'>质和</td></tr>", i += "<tr class='clospan'><td colspan='2'>数据统计</td><td>0</td><td>1</td><td>2</td></tr>", n += "<tr class='clospan'><td colspan='2'>数据统计</td><td>升</td><td>平</td><td>降</td></tr>", S += "<tr><td colspan='2'>总次数</td>";
                for (var O = "<tr><td colspan='2'>平均遗漏</td>", q = "<tr style='display:none;'><td colspan='2'>当前遗漏</td>", T = "<tr><td colspan='2'>最大连出</td>", D = "<tr><td colspan='2'>最大遗漏</td>", M = "<tr><td colspan='2'>总次数</td>", B = "<tr><td colspan='2'>平均遗漏</td>", N = "<tr><td colspan='2'>当前遗漏</td>", L = "<tr><td colspan='2'>最大连出</td>", I = "<tr><td colspan='2'>最大遗漏</td>", A = "<tr><td colspan='2'>总次数</td>", F = "<tr><td colspan='2'>平均遗漏</td>", H = "<tr><td colspan='2'>当前遗漏</td>", J = "<tr><td colspan='2'>最大连出</td>", V = "<tr><td colspan='2'>最大遗漏</td>", E = "<tr><td colspan='2'>总次数</td>", P = "<tr><td colspan='2'>平均遗漏</td>", G = "<tr><td colspan='2'>当前遗漏</td>", R = "<tr><td colspan='2'>最大连出</td>", U = "<tr><td colspan='2'>最大遗漏</td>", W = 0; W < d.length; W++) S += " <td>" + Math.abs(d[W]) + "</td>", O += " <td>" + Math.abs(o[W]) + "</td>", q += " <td></td>", T += " <td>" + Math.abs(r[W]) + "</td>", D += " <td>" + Math.abs(h[W]) + "</td>";
                for (var K = 0; K < u.length; K++) M += " <td>" + Math.abs(u[K]) + "</td>", B += " <td>" + Math.abs(f[K]) + "</td>", N += " <td></td>", L += " <td>" + Math.abs(m[K]) + "</td>", I += " <td>" + Math.abs(b[K]) + "</td>";
                for (var Q = 0; Q < g.length; Q++) A += " <td>" + Math.abs(g[Q]) + "</td>", F += " <td>" + Math.abs(v[Q]) + "</td>", H += " <td></td>", J += " <td>" + Math.abs(y[Q]) + "</td>", V += " <td>" + Math.abs(z[Q]) + "</td>";
                for (var X = 0; X < C.length; X++) E += " <td>" + Math.abs(C[X]) + "</td>", P += " <td>" + Math.abs(x[X]) + "</td>", G += " <td></td>", R += " <td>" + Math.abs(w[X]) + "</td>", U += " <td>" + Math.abs(j[X]) + "</td>";
                var Y = "</tr>";
                s += (wzzstablefooter = S + Y + O + Y + q + Y + T + Y + D + Y) + "</tbody></table>", l += M + Y + B + Y + N + Y + L + Y + I + Y + "</tbody></table>", i += A + Y + F + Y + H + Y + J + Y + V + Y + "</tbody></table>", n += E + Y + P + Y + G + Y + R + Y + U + Y + "</tbody></table>", $(".wezizs #chartLinediv").html(s + l + i + n);
                var Z = $(".wezizs .Pattern .checkspan").attr("class").replace(" ", "").replace("checkspan", "");
                $(".table_" + Z).show().siblings().hide(), orshowConten()
            }
        }, hmgltj: {
            gltjData: function (t, a) {
                var e = $("#gltjhmNum .hmglNumAct").text();
                t = void 0 == t ? config.periods : t, a = void 0 == a ? "" : a, $.ajax({
                    url: config.publicUrl + "pks/queryNumberLawOfStatistics.do?periods=" + t + "&code=" + e + "&date=" + a,
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.hmgltj.gltjHtmlList(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, gltjHtmlList: function (t) {
                var a = null;
                "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
                var e = a.result.data;
                if (void 0 == e.tableList || 0 == e.tableList.length) return tools.weikaiji("#tbSqur"), tools.weikaiji("#sjdsdxList"), void tools.weikaiji(".sjhmfbList table");
                pk10FunObj.hmgltj.listdata(e)
            }, listdata: function (t) {
                $("#tbSqur").empty(), $("#sjdsdxList").empty(), $(".sjhmfbList").find("table").empty();
                for (var a = t.diagramList, e = "", s = [], l = 0; l < a.length; l++) s[l] = a[l];
                var i = (s = s.sort(function (t, a) {
                    return a - t
                }))[0];
                i = i < 10 ? 10 : 10 * Math.ceil(i / 10), $(a).each(function (t, a) {
                    var s = "", l = t + 1 < 10 ? "0" + (t + 1) : t + 1;
                    s = a / i * 100, 0 == a && (a = ""), s >= 92 && (s = 92), e += '<li><i class="codenum">' + l + '</i><span class="gayPip" style="width:' + s + '%"><i class="kainum">' + a + "</i></span></li>"
                });
                var n = "", d = "";
                $(t.tableList).each(function (t, a) {
                    var e = this.preDrawCode, s = "", l = "", i = "", o = this.displayCode,
                        c = typeOf(this.changeState, "spj"), r = "1" == this.singleState ? "单" : "双",
                        h = "1" == this.bigState ? "大" : "小", u = this.preIssue + "";
                    u = u.substr(u.length - 4, 4), s = "双" == r ? "color:#ff2600" : "color:#999", l = "大" == h ? "color:#ff2600" : "color:#999", i = "升" == c ? "color:#ff2600" : "color:#999", n += "<ul><li><span>" + u + "</span>" + this.preDrawTime + "</li><li>" + o + "</li><li style='" + i + "'>" + c + "</li><li style='" + s + "'>" + r + "</li><li style='" + l + "'>" + h + "</li></ul>";
                    var f = "", p = $(".hmglNumAct").text(), m = "";
                    $(e).each(function (t) {
                        m = this == p ? "circle" + this : "defalut_circle circle" + this, this == o ? (qiubg = "lineBall" + this, f += '<td class="hot"><span name="hotSpan" class="' + m + " " + qiubg + '">' + this + "</span></td>") : (qiubg = "", f += '<td><span class="' + m + " " + qiubg + '">' + this + "</span></td>")
                    }), d += '<tr><td style="width:38%"><span>' + u + "</span>" + this.preDrawTime + "</td>" + f + "</tr>"
                }), $("#tbSqur").append(e), $("#sjdsdxList").append(n), $(".sjhmfbList").find("table").append(d), setTimeout(function () {
                    $("canvas").remove(), chartOfBaseTrend.haomagltj("trend_table2_hmgltj")
                }, 500)
            }
        }, gyhzs: {
            listData: function (t, a) {
                t = void 0 == t ? "" : t, a = void 0 == a ? "" : a, $.ajax({
                    url: config.publicUrl + "pks/queryGysumTrend.do?date=" + t + "&periods=" + a,
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.gyhzs.gyhHtmlList(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, gyhHtmlList: function (t) {
                var a = null;
                "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
                var e = a.result.data;
                if (0 == e.length || 0 == e.list) return $("canvas").remove(), tools.weikaiji(".gyhdateBox tbody"), !1;
                pk10FunObj.gyhzs.forRank_gyh(e)
            }, forRank_gyh: function (t) {
                $(".gyhdateBox tbody").empty(), listettablearr(t.list), $(t.list).each(function (t) {
                    if (10037 == lotCode) a = config.showrows; else var a = 200;
                    if (!(t > a)) {
                        var e = "<td>" + this.preIssue + "</td>", s = "", l = this.gySum;
                        $(this.missing).each(function (t) {
                            var a = "", e = "", i = l;
                            1 * this > 0 ? (a = "title='0' class='hot_gyh'", e = "style='background:" + color[1] + "'") : (i = Math.abs(this), a = "class='yilou'"), t > 16 || (s += "<td " + a + "><span " + e + ">" + i + "</span></td>")
                        });
                        var i = "<tr class='yiloutr'>" + e + s + "</tr>";
                        $(".gyhdateBox tbody").append(i)
                    }
                });
                var a = "<td>出现总数</td>", e = "<td>平均遗漏</td>", s = "<td>最大连出</td>", l = "<td>最大遗漏</td>";
                $(t.title).each(function () {
                    $(this.appearCount).each(function () {
                        a += "<td>" + Math.abs(this) + "</td>"
                    }), $(this.averageMissingValues).each(function () {
                        e += "<td>" + Math.abs(this) + "</td>"
                    }), $(this.maxAppearValues).each(function () {
                        s += "<td>" + Math.abs(this) + "</td>"
                    }), $(this.maxMissingValues).each(function () {
                        l += "<td>" + Math.abs(this) + "</td>"
                    })
                }), gyhzsfooter = "<tr><th>数据统计</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th></tr><tr class='clospan_gyh'>" + a + "</tr><tr class='clospan_gyh'>" + e + "</tr><tr class='clospan_gyh'>" + s + "</tr><tr class='clospan_gyh'>" + l + "</tr>", $(".gyhdateBox tbody").append(gyhzsfooter), orshowConten_gyh()
            }
        }, dsdxlz: {
            dsdxlzsData: function (t) {
                "" == (t = void 0 == t ? "" : t) && $("#today_dsdxlz").addClass("todayAct_dsdxlz").siblings().removeClass("todayAct_dsdxlz"), $.ajax({
                    url: config.publicUrl + "pks/queryComprehensiveRoadBead.do?date=" + t,
                    type: "GET",
                    data: {lotCode: lotCode},
                    success: function (t) {
                        pk10FunObj.dsdxlz.addlzTable_dsdxlz(t)
                    },
                    error: function (t) {
                        config.ifdebug
                    }
                })
            }, addlzTable_dsdxlz: function (t) {
                var a = null;
                if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a)), 0 != a.result.data.length) {
                    $(".dsdxlz .dsdxlz_content").html("");
                    for (var e = "", s = 0; s < a.result.data.length; s++) {
                        var l = a.result.data[s].state;
                        if (1 == l) {
                            var i = "双", n = "单", d = "单双";
                            e = "dansuShow"
                        } else if (2 == l) var i = "小", n = "大", d = "大小", e = "daxiaoShow"; else if (3 == l) {
                            var i = "虎", n = "龙", d = "龙虎";
                            e = "longhuShow displaynone"
                        } else if (11 == l) {
                            var i = "双", n = "单", d = "单双";
                            e = "ganyudanxShow"
                        } else if (12 == l) {
                            var i = "小", n = "大", d = "大小";
                            e = "guanyudaxiaoshow"
                        }
                        var o = a.result.data[s].rank;
                        11 == o && 1 == l ? e = "ganyudanxShow" : 11 == o && 2 == l && (e = "guanyudaxiaoshow");
                        var c = "<div class='lz_title " + e + " t" + (o - 1) + "'><div class='left'><span>今日累计:</span>",
                            r = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td>";
                        a.result.data[s].roadBeads = a.result.data[s].roadBeads.reverse();
                        for (var h = 0, u = 0, f = 0, p = 0; h < a.result.data[s].roadBeads.length && !(h >= 200); h++) {
                            var m = a.result.data[s].roadBeads[h];
                            0 == m ? (m = i, u += 1) : 1 == m ? (m = n, f += 1) : 2 == m && (m = text3, p += 1), 0 == h && (r += "<p>" + m + "</p>"), h > 0 & a.result.data[s].roadBeads[h - 1] == a.result.data[s].roadBeads[h] ? r += "<p>" + m + "</p>" : h > 0 & a.result.data[s].roadBeads[h - 1] != a.result.data[s].roadBeads[h] && (r += "</td><td><p>" + m + "</p>")
                        }
                        var b = "";
                        1 == o ? b = "冠军" : 2 == o ? b = "亚军" : 3 == o ? b = "第三名" : 4 == o ? b = "第四名" : 5 == o ? b = "第五名" : 6 == o ? b = "第六名" : 7 == o ? b = "第七名" : 8 == o ? b = "第八名" : 9 == o ? b = "第九名" : 10 == o ? b = "第十名" : 11 == o && (b = "冠亚和");
                        var g = "<span>" + i + "（" + a.result.data[s].totals[1] + "）</span><span>" + n + "（" + a.result.data[s].totals[0] + "）</span></div><div class='right'><span class='weizi'>" + b + "</span><span class='mosh'>" + d + "</span><span class='zxi'>最新    &darr;</span></div>";
                        $(".dsdxlz .dsdxlz_content").append(c + g + r + "</td></tr></tbody></table></div></div>")
                    }
                    $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('龙')").css("color", "red"), $("#dsdxlzlist .dansuShow ").hide(), showSxend(), animate_lz_dsdxlz()
                } else tools.weikaiji(".dsdxlz .dsdxlz_content")
            }, typeOf_dsdxlz: function (t, a) {
                if ("rank" == a) switch (1 * t) {
                    case 1:
                        return "冠军";
                    case 2:
                        return "亚军";
                    case 3:
                        return "第三名";
                    case 4:
                        return "第四名";
                    case 5:
                        return "第五名";
                    case 6:
                        return "第六名";
                    case 7:
                        return "第七名";
                    case 8:
                        return "第八名";
                    case 9:
                        return "第九名";
                    case 10:
                        return "第十名";
                    case 11:
                        return "冠亚和"
                }
            }
        }
    }, condition_Arr = [{
        data: [{name: "冠军", value: "t0"}, {name: "亚军", value: "t1"}, {
            name: "第三",
            value: "t2"
        }, {name: "第四", value: "t3"}, {name: "第五", value: "t4"}, {name: "第六", value: "t5"}, {
            name: "第七",
            value: "t6"
        }, {name: "第八", value: "t7"}, {name: "第九", value: "t8"}, {name: "第十", value: "t9"}]
    }], condition_num = [{
        data: [{name: "号码1", value: "hm1"}, {name: "号码2", value: "hm2"}, {
            name: "号码3",
            value: "hm3"
        }, {name: "号码4", value: "hm4"}, {name: "号码5", value: "hm5"}, {name: "号码6", value: "hm6"}, {
            name: "号码7",
            value: "hm7"
        }, {name: "号码8", value: "hm8"}, {name: "号码9", value: "hm9"}, {name: "号码10", value: "hm10"}]
    }], condition_zh_mc = [{
        data: [{name: "冠军", value: "ball_1"}, {name: "亚军", value: "ball_2"}, {
            name: "第三",
            value: "ball_3"
        }, {name: "第四", value: "ball_4"}, {name: "第五", value: "ball_5"}, {name: "第六", value: "ball_6"}, {
            name: "第七",
            value: "ball_7"
        }, {name: "第八", value: "ball_8"}, {name: "第九", value: "ball_9"}, {name: "第十", value: "ball_10"}, {
            name: "冠亚和",
            value: "ball_11"
        }]
    }], condition_zh_lz = [{
        data: [{name: "单双", value: "dansuShow"}, {name: "大小", value: "daxiaoShow"}, {
            name: "龙虎",
            value: "longhuShow"
        }]
    }], condition_lhlz = [{
        data: [{name: "冠军", value: "t0"}, {name: "亚军", value: "t1"}, {
            name: "第三",
            value: "t2"
        }, {name: "第四", value: "t3"}, {name: "第五", value: "t4"}]
    }], condition_tj = [{data: [{value: "大小", id: "daxiao"}, {value: "单双", id: "danshaung"}]}], condition_wzzs = [{
        data: [{name: "遗漏", value: "yilo"}, {name: "拆线", value: "caix"}, {
            name: "遗漏分层",
            value: "fancong"
        }, {name: "分割线", value: "fgx"}]
    }], condition_wz_mc = [{
        data: [{value: "冠军", id: "0"}, {value: "亚军", id: "1"}, {value: "第三", id: "2"}, {
            value: "第四",
            id: "3"
        }, {value: "第五", id: "4"}, {value: "第六", id: "5"}, {value: "第七", id: "6"}, {value: "第八", id: "7"}, {
            value: "第九",
            id: "8"
        }, {value: "第十", id: "9"}]
    }], condition_dxms_mc = [{
        data: [{value: "冠军", id: "ball_1"}, {value: "亚军", id: "ball_2"}, {
            value: "第三",
            id: "ball_3"
        }, {value: "第四", id: "ball_4"}, {value: "第五", id: "ball_5"}, {value: "第六", id: "ball_6"}, {
            value: "第七",
            id: "ball_7"
        }, {value: "第八", id: "ball_"}, {value: "第九", id: "ball_9"}, {value: "第十", id: "ball_10"}, {
            value: "冠亚和",
            id: "ball_11"
        }]
    }], condition_lmms_lz = [{
        data: [{value: "大小", id: "daxiaoShow"}, {value: "单双", id: "dansuShow"}, {
            value: "龙虎",
            id: "longhuShow"
        }]
    }], condition_wz_qs = [{data: [{value: "近30期", id: "30"}, {value: "近60期", id: "60"}, {value: "近90期", id: "90"}]}],
    initTiaojian = new MobileSelect({
        _mySelectOpts: {
            _type: "CP168",
            _fastCtr: !0,
            _mulitSelect: !0,
            _selectedArr: ["t0", "t1", "t2", "t3", "t4", "t5", "t6", "t7", "t8", "t9", "t10"]
        }, trigger: ".dsdxlzfx", title: "选择名次", wheels: condition_Arr, callback: function (t, a, e) {
            showSxend()
        }, onShow: function () {
            this.initSelectedState()
        }
    }), dxdxlz_val = [0], initTiaojian = new MobileSelect({
        trigger: ".dsdxlztj",
        title: "选择路珠",
        wheels: condition_tj,
        position: dxdxlz_val,
        callback: function (t, a, e) {
            dxdxlz_val[0] = a[0].id, showSxend()
        },
        onShow: function (t) {
            for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : dxdxlz_val, e = 0; e < dxdxlz_val.length; e++) t.locatePosition(e, a[e])
        }
    }), lzcheckObj = {
        zhms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8", "ball_9", "ball_10", "ball_11"],
            select_arr2: ["dansuShow", "daxiaoShow", "longhuShow"]
        },
        dxms: {
            checkIndex: [0],
            checkVal: ["ball_1"],
            checkVal_cn: "冠军",
            select_arr2: ["dansuShow", "daxiaoShow", "longhuShow"]
        },
        lmms: {
            select_arr1: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6", "ball_7", "ball_8", "ball_9", "ball_10", "ball_11"],
            checkIndex: [0],
            checkVal: ["daxiaoShow"],
            checkVal_cn: "大小"
        }
    };
$(".luzufx  .Pattern").on("click", "span", function () {
    var t = $(this);
    $("#F_zhfx_meci").parents(".mobileSelect").remove(), $("#F_zhfx_model").parents(".mobileSelect").remove(), t.hasClass("zonghu") ? lzfxzhms() : t.hasClass("danxms") ? lzfxdxms() : lzfxlmms()
});
var initTiaojian = new MobileSelect({
    _mySelectOpts: {
        _type: "CP168",
        _fastCtr: !0,
        _mulitSelect: !0,
        _selectedArr: ["t0", "t1", "t2", "t3", "t4"]
    }, trigger: ".lhlzfx", title: "选择名次", wheels: condition_lhlz, callback: function (t, a, e) {
        checklhlzMinci()
    }, onShow: function () {
        this.initSelectedState()
    }
}), initTiaojian = new MobileSelect({
    _mySelectOpts: {
        _type: "CP168",
        _fastCtr: !0,
        _mulitSelect: !0,
        _selectedArr: ["hm1", "hm2", "hm3", "hm4", "hm5", "hm6", "hm7", "hm8", "hm9", "hm10"]
    }, trigger: "#hmqhlzfx", title: "选择号码", wheels: condition_num, callback: function (t, a, e) {
        checkhmqhlzHm()
    }, onShow: function () {
        this.initSelectedState()
    }
}), initTiaojian = new MobileSelect({
    _mySelectOpts: {
        _type: "CP168",
        _fastCtr: !1,
        _mulitSelect: !0,
        _selectedArr: ["yilo", "caix"]
    }, trigger: ".bzsz", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, e) {
        orshowConten()
    }, onShow: function () {
        this.initSelectedState()
    }
}), initTiaojian = new MobileSelect({
    _mySelectOpts: {
        _type: "CP168",
        _fastCtr: !1,
        _mulitSelect: !0,
        _selectedArr: ["yilo", "caix"]
    }, trigger: ".gyhzs_fx", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, e) {
        orshowConten_gyh()
    }, onShow: function () {
        this.initSelectedState()
    }
}), gyh_qs_val = [0], initTiaojian = new MobileSelect({
    trigger: ".gyh_qish",
    title: "选择期数",
    wheels: condition_wz_qs,
    position: gyh_qs_val,
    callback: function (t, a, e) {
        gyh_qs_val[0] = 1 * a[0].id, pk10FunObj.gyhzs.listData("", gyh_qs_val[0])
    },
    onShow: function (t) {
        for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : gyh_qs_val, e = 0; e < gyh_qs_val.length; e++) t.locatePosition(e, a[e])
    }
}), hmgltj_qs_val = [0], initTiaojian = new MobileSelect({
    trigger: ".hmgltj_qish",
    title: "选择期数",
    wheels: condition_wz_qs,
    position: hmgltj_qs_val,
    callback: function (t, a, e) {
        hmgltj_qs_val[0] = 1 * a[0].id, pk10FunObj.hmgltj.gltjData(hmgltj_qs_val[0], "")
    },
    onShow: function (t) {
        for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : hmgltj_qs_val, e = 0; e < hmgltj_qs_val.length; e++) t.locatePosition(e, a[e])
    }
}), wz_mc_val = [0], initTiaojian = new MobileSelect({
    trigger: ".wz_mc",
    title: "选择名次",
    wheels: condition_wz_mc,
    position: wz_mc_val,
    callback: function (t, a, e) {
        wz_mc_val[0] = 1 * a[0].id, pk10FunObj.wzzs.createHtmlList(pk10weizzsdata, wz_mc_val[0])
    },
    onShow: function (t) {
        for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : wz_mc_val, e = 0; e < wz_mc_val.length; e++) t.locatePosition(e, a[e])
    }
}), wz_qs_val = [0], initTiaojian = new MobileSelect({
    trigger: ".wz_qish",
    title: "选择期数",
    wheels: condition_wz_qs,
    position: wz_qs_val,
    callback: function (t, a, e) {
        wz_qs_val[0] = 1 * a[0].id, pk10FunObj.wzzs.getlist("", wz_qs_val[0])
    },
    onShow: function (t) {
        for (var a = t.curIndexArr.length > 0 ? t.curIndexArr : wz_qs_val, e = 0; e < wz_qs_val.length; e++) t.locatePosition(e, a[e])
    }
}), fastClickDate = {today_lz: 0, yestoday_lz: -1, qitian_lz: -2};
$(".checkday").on("click", "span", function () {
    var t = $(this), a = "", e = this.classList[0];
    t.addClass("checkspan").siblings().removeClass("checkspan");
    var s = fastClickDate[e];
    if (!t.hasClass("checkclick_date") && !t.hasClass("screen")) {
        a = getDateStr(s, !0), t.siblings(".time_select").text(a), initTimeSelect.refreshState(s, a);
        var l = $(".title_se_box .se_check").attr("target");
        l = (l = $("#" + l + " .checkedbl").attr("id")) || hisEl, tools.classGetDate_pk10(l, a, ""), tools.revertHmfb()
    }
}), $(".Pattern").on("click", "span", function () {
    $(this).addClass("checkspan").siblings().removeClass("checkspan"), $("." + $(this).attr("target") + "_mod").addClass("_shows").siblings().removeClass("_shows")
});