function iframe() {
    var t = $(".animate").width(), a = 780 * t / 1125, e = t / 1125;
    setTimeout(function () {
        $(".animate iframe").contents().find("html").css("zoom", e);
        $(".animate iframe").contents().find(".container").height();
        $(".animate").animate({height: a + 50}, 600), $(".animate iframe").animate({height: a + 50}, 600), $(".content").animate({height: a + 25}, 600)
    }, 1), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("#preloader").fadeOut("slow")
    }, 1e3)
}

function startVideo() {
    $("#videoiframe").attr('src',config.videourl+vurl+"?"+lotCode);
    $("#videobox").animate({"z-index": "999999"}, 10, function () {
        var t = 880 * $(".animate").width() / 1310;
        $(".content").css({height: t + 35}), $(".content").animate({top: "0"}, 500, function () {
            //iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
        })
    })
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
        e += '<div class="listotherline bjkl8_listotherline bortop001 ssclist">', e += '<div class="leftspan">', e += '<span class="boxflex">';
        var a = this.preDrawTime;
        a = a.substring(a.length - 8, a.length - 3), e += '<span class="graytime">' + a + "</span>", e += '<span class="graytime">' + tools.subStr(this.preDrawIssue) + "</span>", e += "</span>", e += "</div>", e += '<div class="rightspan">', e += '<div class="rightdiv" style="padding-left:0">', e += '<div class="haomali"><ul id="hoamaul" class="ssclilist listli zhxtlilist">';
        var s = this.preDrawCode.split(",");
        if ("10054" != lotCode && "10082" != lotCode || s.splice(-1, 1), $(s).each(function (t) {
            "" != this && (t == s.length - 1 ? e += '<li><span class="Orange"><i>' + this + "</i></span></li>" : e += this > 40 ? '<li><span class="bluenum"><i>' + this + "</i></span></li>" : '<li><span class="lightblue"><i>' + this + "</i></span></li>")
        }), e += "</ul></div>", e += '<div class="longhuli displaynone"><ul id="" class="ssclilistxt listli lhlist">', !(s.length <= 1)) {
            var l = tools.typeOf("sumBigSmall", this.sumBigSmall),
                i = tools.typeOf("sumSingleDouble", this.sumSingleDouble),
                n = tools.typeOf("singleDoubleCount", this.singleDoubleCount),
                d = tools.typeOf("frontBehindCount", this.frontBehindCount), o = tools.typeOf("sumBsSd", this.sumBsSd),
                c = tools.typeOf("sumWuXing", this.sumWuXing);
            "0" == this.dragonTiger ? "龙" : "1" == this.dragonTiger ? "虎" : "2" == this.dragonTiger && "和"
        }
        e += "<li style='color:#f12d35'>" + this.sumNum + "</li><li style='color:#666'>" + l + "</li><li style='color:#666'>" + i + "</li><li style='color:#666'>" + n + "</li><li style='color:#666'>" + d + "</li><li style='color:#666'>" + o + "</li><li style='color:#666'>" + c + "</li>", e += "</ul>", e += "</div>", e += "</div>", e += "</div>", e += "</div>"
    }), "string" == typeof a ? $(a).append(e) : a.forEach(function (t) {
        return $(t).append(e)
    })
}

function showlz_listitem() {
    $(".lz_title").hide();
    var t = $("#F_checkclick_lz .check_tj");
    $(t).each(function (t, a) {
        var e = $(this).attr("data-value");
        $("." + e).show()
    })
}

function animate_lzfx() {
    var t = 0, a = $(".lz_content>.lz_title>.lz_item>table>tbody>tr>td:first-child p:last-child");
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

function checkDateFun(t, a) {
    a = void 0 == a ? "" : a;
    var e = $("#allSele .checkedbl").attr("id");
    "kaijianghm" == e ? method.listData(t) : "luzufx" == e && kl8funobj.lzfx.getdata(t)
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    var t = localStorage.getItem("overpage");
    null != t && void 0 != t && "" != t && 0 != $("#allSele #" + t).length || method.listData(""), pubmethod.initAdata(), method.indexLoad(boxId, lotCode), ifishad = !0;
    $("#startVideo").on("touchstart", function () {
        startVideo();//$("iframe")[0].contentWindow.syxwV.startVid(tools.bjkl8DataStr()), startVideo(), $("iframe")[0].contentWindow.ifopen = !0
    }), document.addEventListener("click", function () {
        //$("iframe")[0].contentWindow.ifopen && ($("iframe")[0].contentWindow.syxwV.sound.play("audioidKai"), $("iframe")[0].contentWindow.syxwV.sound.play("audioidBg"), $("iframe")[0].contentWindow.syxwV.sound.stop("audioidKai"))
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({top: "-200%"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"});
            $("#videoiframe").attr('src',"");
        })
        //$("iframe")[0].contentWindow.syxwV.sound.stop("audioidBg"), $("iframe")[0].contentWindow.syxwV.sound.stop("audioidKai"), $("iframe")[0].contentWindow.syxwV.clearTime(), $("iframe")[0].contentWindow.ifopen = !1
    }), setTimeout(function () {
        config.ifFirstLoad = !0
    }, 4e3), $(".headTitle").on("click", "div", function () {
        if ($("#numlist").empty(), $("#haomafblist").empty(), $(".tablecontent table thead").empty(), $(".tablecontent table tbody").empty(), $(".luzufx .lz_content").empty(), "kaijianghm" == $(this).attr("id")) {
            var t = getDateStr(0, !0);
            method.listData(t)
        } else "changlongtj" == $(this).attr("id") ? (gettpye = $(".dragon_list .cehcked").attr("data-text"), kl8funobj.mrlctx.getdata(gettpye)) : kl8funobj.lzfx.getdata("")
    })
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
var ifishad = !1, method = {};
method.loadOther = function (t, a) {
    ("" != t || tools.ifOnDay()) && ($("#kaijianghm").hasClass("checkedbl") ? method.listData(t) : $("#changlongtj").hasClass("checkedbl") ? kl8funobj.mrlctx.getdata() : kl8funobj.lzfx.getdata(t, a))
}, method.indexLoad = function (t) {
    var a = $(t).find(".nextIssue").val(), t = "#" + $(t).attr("id");
    headMethod.loadHeadData(a, t)
}, method.listData = function (t) {
    $.ajax({
        url: config.publicUrl + "LuckTwenty/getBaseLuckTwentyList.do?date=" + t,
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
        scrollRender.init(a), method.selectedBS($(".rightdiv").find(".spanchecked"), !0)
    }
};
var scrollRender = {
    init: function (t) {
        var a = this;
        this.data = t, this.once = 200, this.contArr = ["#numlist"], this.contArr.forEach(function (e) {
            $(e).empty(), a[e] = {curIndex: 0, totalPage: Math.ceil(t.length / a.once) - 1}
        }), this.parentClass = "#numlist", createHtmlStr(t.slice(this[this.parentClass].curIndex, this.once), this.contArr), this.watchDom = $(this.parentClass + " .ssclist:last-child")[0], $(window).off("scroll").on("scroll", throttle(this.scrollCb.bind(this), 400, 1e3))
    }, scrollCb: function () {
        if (!this.scrollFlag && this.watchDom.getBoundingClientRect().top < window.screen.height + 200) {
            var t = this[this.parentClass];
            0 === t.totalPage && (this.watchDom = null, $(window).off("scroll")), this.scrollFlag = !0, t.curIndex = t.curIndex + this.once, createHtmlStr(this.data.slice(t.curIndex, t.curIndex + this.once), this.parentClass), this.watchDom = $(this.parentClass + " .ssclist:last-child")[0], method.selectedBS($(".rightdiv").find(".spanchecked"), !0), --t.totalPage, this.scrollFlag = !1
        }
    }
};
method.selectedBS = function (t, a) {
    tools.bigOrSmall(t, a, "5")
}, method.selectedHm111 = function (t) {
    var a = $(t).hasClass("lichecked");
    if ("dansdxbtn" == $(t).parent().parent().attr("class")) {
        $(".numbtn").find("li").removeClass("lichecked"), $(t).hasClass("lichecked") ? $(t).removeClass("lichecked") : $(t).addClass("lichecked");
        var e = $(t).text();
        "单" == e ? $(".dansdxbtn li:nth-child(2)").removeClass("lichecked") : "双" == e ? $(".dansdxbtn li:nth-child(1)").removeClass("lichecked") : "大" == e ? $(".dansdxbtn li:nth-child(4)").removeClass("lichecked") : "小" == e && $(".dansdxbtn li:nth-child(3)").removeClass("lichecked")
    } else $(".dansdxbtn").find("li").removeClass("lichecked"), $(t).hasClass("lichecked") ? $(t).removeClass("lichecked") : $(t).addClass("lichecked").siblings().removeClass("lichecked"), $(".numbtn").find(".lichecked").text() ? ($("#haomafblist li").addClass("selectedOpacity"), $("#haomafblist li").each(function () {
        $(this).text() == $(".numbtn").find(".lichecked").text() && $(this).removeClass("selectedOpacity").siblings()
    })) : $("#haomafblist li").removeClass("selectedOpacity");
    var s = $(".dansdxbtn li:nth-child(1)").hasClass("lichecked"),
        l = $(".dansdxbtn li:nth-child(2)").hasClass("lichecked"),
        i = $(".dansdxbtn li:nth-child(3)").hasClass("lichecked"),
        n = $(".dansdxbtn li:nth-child(4)").hasClass("lichecked");
    $("#haomafblist li").each(function () {
        var t = $(this).text(), d = t % 2 == 0, o = t >= 6;
        "单" == e ? a ? i ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "双" == e ? a ? i ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : n ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "大" == e ? a ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : l ? o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "小" == e && (a ? s ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? o || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? !o && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
    })
}, method.loadTodayData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data;
        var a = [{data: [data.numZero, data.numOne, data.numTwo, data.numThree, data.numFour, data.numFive, data.numSix, data.numSeven, data.numEight, data.numNine]}, {data: [data.firstSingle, data.firstDouble, data.firstBig, data.firstSmall]}, {data: [data.secondSingle, data.secondDouble, data.secondBig, data.secondSmall]}, {data: [data.thirdSingle, data.thirdDouble, data.thirdBig, data.thirdSmall]}, {data: [data.fourthSingle, data.fourthDouble, data.fourthBig, data.fourthSmall]}, {data: [data.fifthSingle, data.fifthDouble, data.fifthBig, data.fifthSmall]}, {data: [data.sumSingle, data.sumDouble, data.sumBig, data.sumSmall]}];
        $("#liangmianbox").empty(), $(a).each(function (t) {
            var a = "";
            $(this.data).each(function () {
                a += "<td>" + this + "</td>"
            });
            var e = tools.typeOf("liangm", t), s = "";
            0 == t ? s = "head1" : 1 == t && (s = "head2");
            var l = "";
            l = '<div class="lianmlist"><div  class="head ' + s + '">' + e + '</div><table cellpadding="0" cellspacing="0" border="0"><tr class="tr1">' + (t > 0 ? "<td>单</td><td>双</td><td>大</td><td>小</td>" : "<td>0</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td>") + '</tr><tr class="tr2">' + a + "</tr></table></div>", $("#liangmianbox").append(l)
        })
    }
}, method.loadLongData = function (t) {
    if ("object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data)), 0 == data.errorCode && 0 == data.result.businessCode) {
        data = data.result.data, config.ifdebug, $("#longDrag").empty("");
        for (var a = 0, e = data.length; a < e; a++) {
            var s = tools.typeOf("qiuqiu1", data[a].rank), l = tools.typeOf("stated", data[a].state),
                i = data[a].count >= 5 ? "<span style='color:#f11821'>" + data[a].count + "</span>" : "<span>" + data[a].count + "</span>",
                n = "<li><span>" + s + "</span>：<span>" + l + "</span>" + i + "期</li>";
            11 != data[a].rank && 1 != data[a].rank && 2 != data[a].rank || (n = "<li><span>" + s + "</span>：<span>" + l + "</span>" + i + "期</li>"), $("#longDrag").append(n)
        }
    }
};
var kl8funobj = {
    mrlctx: {
        getdata: function (t) {
            t = void 0 == t || "" == t ? 1 : t, $.ajax({
                url: config.publicUrl + "LuckTwenty/queryLuckTwentyDailyDragon.do",
                type: "GET",
                beforeSend: function () {
                    $(".tablecontent table thead").empty(), $(".tablecontent table tbody").empty()
                },
                data: {lotCode: lotCode, rank: 1, type: t},
                success: function (a) {
                    kl8funobj.mrlctx.analydom(a, t)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, analydom: function (t, a) {
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? data = JSON.parse(t) : (data = JSON.stringify(t), data = JSON.parse(data));
            var e = data.result.data.list, s = "", l = [];
            if ($(e).each(function (t) {
                l.push(this.dragon.length)
            }), s = Math.max.apply(null, l), 5 == a) i = "<tr><th>日期</th><th >2 期</th></tr>"; else {
                if (s > 10) {
                    i = "<tr><th rowspan='2'>日期</th>";
                    i += "<th class='text_left' colspan='" + s + "'>2-" + (s + 1) + "期 （左右滑动查看）</th></tr><tr>";
                    for (n = 0; n < s; n++) i += "<th rowspan='2'>" + (1 * n + 2) + "<br/>期</th>"
                } else for (var i = "<tr><th >日期</th>", n = 0; n < s; n++) i += "<th>" + (1 * n + 2) + "<br/>期</th>";
                i += "</tr>"
            }
            $(".tablecontent table thead").html(i);
            var d = "";
            $(e).each(function (t) {
                var a = this.dragon;
                d += "<tr><td>" + this.date + "</td>";
                for (var e = 0; e < s; e++) d += "<td>" + (void 0 == a[e] ? "&nbsp;" : a[e]) + "</td>";
                d += "</tr>"
            }), $(".tablecontent table tbody").html(d)
        }
    }, lzfx: {
        preDrawIssue: null, lzResult: null, lzInterval: null, getdata: function (t, a) {
            "" == (t = void 0 == t ? "" : t) && $(".today_lz").addClass("checkspan").siblings().removeClass("checkspan"), $.ajax({
                url: config.publicUrl + "LuckTwenty/queryComprehensiveRoadBead.do?date=" + t,
                type: "GET",
                data: {lotCode: lotCode},
                success: function (e) {
                    var s = kl8funobj.lzfx, l = JSON.stringify(e);
                    s.lzResult != l && s.preDrawIssue == a && void 0 !== a ? (clearInterval(s.lzInterval), s.lzResult = l) : s.lzResult == l && s.preDrawIssue != a && void 0 !== a ? (s.preDrawIssue = a, s.lzInterval = setInterval(function () {
                        s.getdata(t, a)
                    }, 2e3)) : void 0 === a || s.lzResult && null == s.lzResult || (s.lzResult = l, s.preDrawIssue = a), s.analydom(e)
                },
                error: function (t) {
                    config.ifdebug
                }
            })
        }, analydom: function (t) {
            var a = null;
            "object" != (void 0 === t ? "undefined" : _typeof(t)) ? a = JSON.parse(t) : (a = JSON.stringify(t), a = JSON.parse(a));
            a.result.data;
            $(".luzufx .lz_content").html("");
            for (var e = 0; e < a.result.data.length; e++) {
                var s = "", l = "", i = "", n = "", d = "", o = "", c = "", r = a.result.data[e].rank;
                0 == r ? (s = "大", l = "小", i = "和", o = "总和大小") : 1 == r ? (s = "单", l = "双", i = "和", o = "总和单双") : 2 == r ? (s = "总大单", l = "总大双", i = "总小单", n = "总小双", d = "总和", o = "大小单双", c = "width_td") : 3 == r ? (s = "前多", l = "后多", i = "前后和", o = "前后和", c = "width_td") : 4 == r ? (s = "单多", l = "双多", i = "单双和", o = "单双和", c = "width_td") : 5 == r && (s = "金", l = "木", i = "水", n = "火", d = "土", o = "五行");
                var h = "<div class='lz_title ball_" + (r + 1) + "'><div class='left'><span>今日累计: </span>",
                    u = "<div class='lz_item'><table class='lz_table_con' border='0' cellpadding='1' cellspacing='1'><tbody><tr class='tablebox'><td class='" + c + "'>";
                a.result.data[e].roadBeads = a.result.data[e].roadBeads.reverse();
                for (var p = 0, f = 0, m = 0, v = 0, b = 0; p < a.result.data[e].roadBeads.length && !(p >= 200 && "10054" == lotCode); p++) {
                    var g = a.result.data[e].roadBeads[p];
                    g < 0 ? (g = l, m += 1) : 0 == g ? (g = i, v += 1) : 1 == g ? (g = s, f += 1) : 2 == g ? (g = l, m += 1) : 3 == g ? (g = i, v += 1) : 4 == g ? (g = n, b += 1) : 5 == g && (g = d, b += 1), 0 == p && (u += "<p>" + g + "</p>"), p > 0 & a.result.data[e].roadBeads[p - 1] == a.result.data[e].roadBeads[p] ? u += "<p>" + g + "</p>" : p > 0 & a.result.data[e].roadBeads[p - 1] != a.result.data[e].roadBeads[p] && (u += "</td><td class='" + c + "'><p>" + g + "</p>")
                }
                var y = "";
                if (y = "" != d ? "<span>" + s + "（" + a.result.data[e].totals[0] + "）</span><span>" + l + "（" + a.result.data[e].totals[1] + "）</span><br/><span>" + i + "（" + a.result.data[e].totals[2] + "）</span><span>" + n + "（" + a.result.data[e].totals[3] + "）</span><span>" + d + "（" + a.result.data[e].totals[4] + "）</span></div>" : "" != n ? "<span>" + s + "（" + a.result.data[e].totals[1] + "）</span><span>" + l + "（" + a.result.data[e].totals[0] + "）</span><br/><span>" + i + "（" + a.result.data[e].totals[2] + "）</span><span>" + n + "（" + a.result.data[e].totals[3] + "）</span></div>" : "" != i ? "<span>" + s + "（" + a.result.data[e].totals[0] + "）</span><span>" + l + "（" + a.result.data[e].totals[1] + "）</span><span>" + i + "（" + a.result.data[e].totals[2] + "）</span></div>" : "<span>" + s + "（" + a.result.data[e].totals[1] + "）</span><span>" + l + "（" + a.result.data[e].totals[0] + "）</span><</div>", 0 == r || 1 == r || 3 == r) {
                    C = i.length >= 3 ? "<p><span>" + i + "（" + a.result.data[e].totals[2] + "）</span></p>" : "<span>" + i + "（" + a.result.data[e].totals[2] + "）</span>";
                    y = "<span>" + s + "（" + a.result.data[e].totals[1] + "）</span><span>" + l + "（" + a.result.data[e].totals[0] + "）</span>" + C + "</div>"
                } else {
                    var C = i.length >= 3 ? "<p><span>" + i + "（" + a.result.data[e].totals[2] + "）</span></p>" : "<span>" + i + "（" + a.result.data[e].totals[2] + "）</span>";
                    y = "<span>" + s + "（" + a.result.data[e].totals[0] + "）</span><span>" + l + "（" + a.result.data[e].totals[1] + "）</span>" + C + "</div>"
                }
                var x = y + "<div class='right'><span class='mosh'>" + o + "</span><span class='zxi'>最新    &darr;</span></div>";
                $(".luzufx .lz_content").append(h + x + u + "</td></tr></tbody></table></div></div>")
            }
            $(".tablebox>td>p:contains('大')").css("color", "red"), $(".tablebox>td>p:contains('双')").css("color", "red"), $(".tablebox>td>p:contains('总大双')").css("color", "#F10078"), $(".tablebox>td>p:contains('总小双')").css("color", "#FF2FFF"), $(".tablebox>td>p:contains('总小单')").css("color", "#009100"), $(".tablebox>td>p:contains('后多')").css("color", "#F00078"), $(".tablebox>td>p:contains('多双')").css("color", "#F00078"), $(".tablebox>td>p:contains('单双和')").css("color", "#009100"), $("#dsdxlzlist .dansuShow ").hide(), showlz_listitem(), animate_lzfx()
        }
    }
};
$(".dragon_list").on("click", "ul>li", function () {
    $(this).addClass("checked").siblings().removeClass("checked");
    var t = $(this).attr("data-text");
    kl8funobj.mrlctx.getdata(t)
}), $(".headTitle").on("click", "div>span", function () {
    "changlongtj" == $(this).parent().attr("id") ? $("#explainBtn_wfsm").show() : $("#explainBtn_wfsm").hide()
}), $("#explainBtn_wfsm").click(function () {
    $("#fxpage_sm").addClass("gotop").css("height", $("body").height())
}), $(".closesm").click(function () {
    $("#fxpage_sm").css("height", 0).removeClass("gotop")
});
var fastClickDate = {today_lz: 0, yestoday_lz: -1, qitian_lz: -2};
$(".checkday").on("click", "span", function () {
    var t = $(this), a = "", e = this.classList[0];
    t.addClass("checkspan").siblings().removeClass("checkspan");
    var s = fastClickDate[e];
    t.hasClass("checkclick_date") || t.hasClass("screen") || (a = getDateStr(s, !0), t.siblings(".time_select").text(a), checkDateFun(a, ""), tools.revertHmfb())
});
var condition_wzzs = [{
    data: [{name: "总和大小", value: "ball_1"}, {name: "总和单双", value: "ball_2"}, {
        name: "总和大小单双",
        value: "ball_3"
    }, {name: "前后和", value: "ball_4"}, {name: "单双和", value: "ball_5"}, {name: "总和五行", value: "ball_6"}]
}], initTiaojian = new MobileSelect({
    _mySelectOpts: {
        _type: "CP168",
        _fastCtr: !0,
        _mulitSelect: !0,
        _selectedArr: ["ball_1", "ball_2", "ball_3", "ball_4", "ball_5", "ball_6"]
    }, trigger: ".checkclick_lz", title: "选择标注", wheels: condition_wzzs, callback: function (t, a, e) {
        showlz_listitem()
    }, onShow: function () {
        this.initSelectedState()
    }
});