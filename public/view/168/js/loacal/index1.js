function ajaxRequst(e, t) {
    var a = t.replace("#", "").replace("_hot", "").replace("Hot", ""), n = LOTTERY_CATEGORY[a];
    if (void 0 !== n) switch (n.category) {
        case"ssc":
            indexObj.ajaxSsc(e, lotCode[a], t);
            break;
        case"pk10":
            indexObj.ajaxpk10(e, lotCode[a], t)
    } else{
        ("#pk10" == t || "#pk10_hot" == t) && indexObj.ajaxpk10(e, lotCode.pk10, t);
        ("#jisusc" == t || "#jisuscHot" == t) && indexObj.ajaxpk10(e, lotCode.jisusc, t);
        ("#jisuft" == t || "#jisuftHot" == t) && indexObj.ajaxpk10(e, lotCode.jisuft, t);
        ("#xingyft" == t || "#xingyft_hot" == t) && indexObj.ajaxpk10(e, lotCode.xingyft, t); 
        ("#sgAirship_hot" == t || "#sgAirship" == t) && indexObj.ajaxpk10(e, lotCode.sgAirship, t);
        "#aozxy10" == t && indexObj.ajaxpk10(e, lotCode.aozxy10, t);
        ("#cqSsc" == t || "#cqSsc_hot" == t) && indexObj.ajaxSsc(e, lotCode.cqssc, t); 
        ("#xySsc" == t || "#xySsc_hot" == t) && indexObj.ajaxSsc(e, lotCode.xyssc, t);
        ("#jisussc" == t || "#jisusscHot" == t) && indexObj.ajaxSsc(e, lotCode.jisussc, t);
        ("#happyCZ" == t || "#happyCZ_hot" == t) && indexObj.ajaxSsc(e, lotCode.happyCZ, t);
        "#tjSsc" == t && indexObj.ajaxSsc(e, lotCode.tjssc, t);
        ("#tw_5fencai" == t || "#tw_5fencaiHot" == t) && indexObj.ajaxSsc(e, lotCode.tw_5fencai, t);
        "#xjSsc" == t && indexObj.ajaxSsc(e, lotCode.xjssc, t); 
        "#jisuklsf" == t && indexObj.ajaxKlsf(e, lotCode.jisuklsf, t);
        "#bgklsf" == t && indexObj.ajaxKlsf(e, 20034, t);
        "#aozxy8" == t && indexObj.ajaxKlsf(e, lotCode.aozxy8, t);
        "#jisuksan" == t && indexObj.ajaxKuai3(e, lotCode.jisuksan, t);
        "#bgk3" == t && indexObj.ajaxKuai3(e, 20035, t);
        "#bjk3" == t && indexObj.ajaxKuai3(e, lotCode.bjft, t); 
        ("#bg11x5" == t || "#bg11x5_hot" == t) && indexObj.shiyix5(e, 20033, t);
        "#shiyix5_gd" == t && indexObj.shiyix5(e, lotCode.gdsyxw, t);
        "#jisuef" == t && indexObj.shiyix5(e, lotCode.jisuef, t); 
        "#11ckeck5_zjef" == t && indexObj.shiyix5(e, lotCode.zjef, t);
        "#cqnc" == t && indexObj.ajaxCqnc(e, lotCode.cqxync, t);
        "#egxy28" == t && indexObj.ajaxPCdd(e, lotCode.egxy28, t);
        "#tcpl3" == t && indexObj.ajaxTcpl3(e, lotCode.pailie3, t);
        "#fc3d" == t && indexObj.ajaxTcpl3(e, lotCode.fcsd, t);
        "#gxklsf" == t && indexObj.ajaGxklsf(e, lotCode.gxklsf, t);
        ("#sgSsc" == t || "#sgSsc_hot" == t) && indexObj.ajaxSsc(e, lotCode.sgssc, t);
        ("#kuai3_sg" == t || "#kuai3_sg_hot" == t) && indexObj.ajaxKuai3(e, lotCode.sgk3, t);
        ("#smallSixInfo_hot" == t || "#smallSixInfo" == t) && indexObj.ajaxSmallSixInfo(e, 10048, t);
        ("#aomenSixInfo_hot" == t || "#aomenSixInfo" == t) && indexObj.ajaxAomenSixInfo(e, 20049, t);
        "#speedSix" == t && indexObj.speedSixInfo(e, 10051, t);
        "#taiwanBigLottery" == t && indexObj.ajaxSsc(e, lotCode.tw_dlt, t);
    } 
}

function nextopenTime(e, t, a,drawIssue) {
    var n = e.replace(/-/g, "/"), t = t.replace(/-/g, "/"), i = $(a), o = i.find(".day"), s = i.find(".hours"),
        r = i.find(".minute"), d = i.find(".second"), l = new Date, u = (new Date(n) - new Date(t)) / 1e3;
    clearInterval(nexttimeinter[a]), nexttimeinter[a] = setInterval(function () {
        var e = Math.abs(new Date - l) / 1e3;
        if (l = new Date, (e = e.toString().split("."))[0] > 1 && (u -= e[0]), !(u > 1)) return clearInterval(nexttimeinter[a]), void ajaxRequst(drawIssue, a);
        u -= 1;
        var t = parseInt(u / 3600 / 24), n = Math.floor(u / 3600 - 24 * t), i = Math.floor(u / 60 % 60),
            c = Math.floor(u % 60);
        $(o).text(t < 10 ? "0" + t : t), $(s).text(n < 10 ? "0" + n : n), $(r).text(i < 10 ? "0" + i : i), $(d).text(c < 10 ? "0" + c : c)
    }, 1e3)
}

function typeOf(e, t) {
    if ("rank" == e) switch (1 * t) {
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
    } else if ("state" == e) switch (1 * t) {
        case 1:
            return "单双";
        case 2:
            return "大小";
        case 3:
            return "龙虎"
    } else if ("san" == e) switch (1 * t) {
        case 0:
            return "杂六";
        case 1:
            return "半顺";
        case 2:
            return "顺子";
        case 3:
            return "对子";
        case 4:
            return "豹子"
    } else if ("seafood" == e) switch (1 * t) {
        case 1:
            return "鱼";
        case 2:
            return "虾";
        case 3:
            return "葫芦";
        case 4:
            return "金钱";
        case 5:
            return "蟹";
        case 6:
            return "鸡"
    } else if ("Indxh" == e) switch (1 * t) {
        case 0:
            return "大";
        case 1:
            return "小";
        case 2:
            return "和"
    }
}

function isIE() {
    return !!(window.ActiveXObject || "ActiveXObject" in window)
}

function openVdio(e) {
    lc = e, ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
        $(".content").animate({
            bottom: "50%",
            right: "50%",
            width: "880px",
            height: "640px",
            "margin-bottom": "-298px"
        }, 500, function () {
            $(".big").hide(), $(".small").show(), $(".animate").height("575"), iframe(lc), isfirthload = !1
        })
    }), ifopen = !0)
}

function iframe(e) {
    var t = "", a = "", n = {
        pk10: "PK10/video.html?10001",
        cqssc: "SSC/index.html?10002",
        happyCZ: "SSC/index.html?10060",
        xyssc: "SSC/index.html?10059",
        tjssc: "SSC/index.html?10003",
        xjssc: "SSC/index.html?10004",
        jisussc: "SSC/index.html?10036",
        egxy28: "pcEgg_video/index.html?10074",
        tw_5fencai: "SSC/index.html?10064",
        jisuklsf: "GDklsf/index.html?10053",
        bgklsf: "GDklsf/index.html?20034",
        sdsyydj: "11x5_video/index.html?10008",
        gdsyxw: "11x5_video/index.html?10006",
        jsksan: "kuai3_video/Kuai3.html?10052",
        jisusc: "PK10/video.html?10037",
        jisuft: "jisuft_video/index.html?10035",
        xingyft: "jisuft_video/index.html?10057",
        sgAirship: "jisuft_video/index.html?10058",
        tjklsf: "GDklsf/index.html?10034",
        aozxy8: "GDklsf/index.html?10011",
        zjef: "11x5_video/index.html?10025",
        bgk3: "kuai3_video/Kuai3.html?20035",
        bjft: "kuai3_video/Kuai3.html?10033",
        cqxync: "cqnc/index.html?10009",
        pailie3: "fc3DVideo/index.html?10043",
        fcsd: "fc3DVideo/index.html?10041",
        gxklsf: "gxklsf_video/index.html?10038",
        sgssc: "SSC/index.html?10075",
        sgk3: "kuai3_video/Kuai3.html?10076",
        bg11x5: "11x5_video/index.html?20033",
        jisuef: "11x5_video/index.html?10055"
    }, i = {
        pk10: "北京PK10",
        cqssc: "重庆时时彩",
        happyCZ: "重庆欢乐生肖",
        xyssc: "幸运时时彩",
        tjssc: "天津时时彩",
        xjssc: "新疆时时彩",
        tw_5fencai: "台湾5分彩",
        jisuklsf: "极速快乐十分",
        sdsyydj: "十一运夺金",
        gdsyxw: "广东11选5",
        jsksan: "极速快3",
        jisusc: "极速赛车",
        jisuft: "极速飞艇",
        xingyft: "幸运飞艇",
        sgAirship: "SG飞艇",
        bgklsf: "BG快乐十分",
        aozxy8: "澳洲幸运8",
        zjef: "浙江11选5",
        bgk3: "BG快3",
        bjft: "北京快3",
        cqxync: "重庆幸运农场",
        egxy28: "PC蛋蛋幸运28",
        qxc: "体彩七星彩",
        pailie3: "体彩排列3",
        fcsd: "福彩3D",
        gxklsf: "广西快乐十分",
        jisussc: "极速时时彩",
        bg11x5: "BG11选5"
    }, o = e, s = LOTTERY_CATEGORY[o];
    if (void 0 !== s) switch (s.category) {
        case"ssc":
            t = "SSC/index.html?" + s.lotCode, a = s.title;
            break;
        case"pk10":
            t = "PK10/video.html?" + s.lotCode, a = s.title;
            break;
        case"kuai3":
            t = "kuai3_video/Kuai3.html?" + s.lotCode, a = s.title
    } else a = i[e], t = n[e];
    console.log('t',t);
    $("#videobox").find("#vtitle").text(a), $("#videoIframe").find("iframe").attr("src", "/view/video/" + t)
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
    return typeof e
} : function (e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
};
$(function () {
    $("#headdivbox").load("./view/public/head.html?v=22222", function () {
        config.ifdebug
    });
    $("#fooderbox").load("./view/public/fooder.html", function () {
        config.ifdebug
    });
   
    // ajaxRequst("", "#sgAirship");
    // ajaxRequst("", "#sgAirship_hot");
    // ajaxRequst("", "#cqSsc");
    // ajaxRequst("", "#cqSsc_hot");
   
    // ajaxRequst("", "#xjSsc");
    
    // ajaxRequst("", "#shiyix5_sd");
    // ajaxRequst("", "#shiyix5_sd_hot");
    // ajaxRequst("", "#shiyix5_gd");
    // ajaxRequst("", "#11ckeck5_zjef");
    
    // ajaxRequst("", "#bjk3");
    // ajaxRequst("", "#cqnc");
    // ajaxRequst("", "#fc3d");
    // ajaxRequst("", "#tcpl3");
    // ajaxRequst("", "#sdsyydj");
    // ajaxRequst("", "#sgSsc");
    // ajaxRequst("", "#sgSsc_hot");
    // ajaxRequst("", "#kuai3_sg_hot");
    // ajaxRequst("", "#kuai3_sg");
    // ajaxRequst("", "#uklotto5");
    // ajaxRequst("", "#uklotto10");

    // ajaxRequst("", "#jisusc");
    // ajaxRequst("", "#jisuscHot");
    // ajaxRequst("", "#jisuft");
    // ajaxRequst("", "#jisuftHot");
    // ajaxRequst("", "#xingyft");
    // ajaxRequst("", "#xingyft_hot");
    // ajaxRequst("", "#xySsc");
    // ajaxRequst("", "#tw_5fencai");
    // ajaxRequst("", "#tw_5fencaiHot");
    // ajaxRequst("", "#xySsc_hot");
    // ajaxRequst("", "#jisussc");
    // ajaxRequst("", "#jisusscHot");
    // ajaxRequst("", "#jisuef");
    ajaxRequst("", "#jisuklsf");
    // ajaxRequst("", "#aozxy8");
    // ajaxRequst("", "#jisuksan");
    // ajaxRequst("", "#bgk3");
    // ajaxRequst("", "#egxy28");
    // ajaxRequst("", "#smallSixInfo_hot");
    // ajaxRequst("", "#speedSix");
    // ajaxRequst("", "#smallSixInfo");
    // ajaxRequst("", "#aomenSixInfo");
    // ajaxRequst("", "#taiwanBigLottery");
    // ajaxRequst("", "#aozxy5");
    // ajaxRequst("", "#aozxy10");
    // ajaxRequst("", "#bg11x5");

    //ajaxRequst("", "#bgklsf");
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    });
    $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    });
    $("#bannernews").on("click", "p>a", function (e) {
        var t = {data: bannernews, funame: "checkRight()", programaId: " ", pageNo: 1, pageSize: 7};
        JSON.stringify(t), sessionStorage.setItem("sessData", JSON.stringify(t))
    });
    $("#fanganyc").on("click", "li>a", function (e) {
        var t = {data: fanganyc, funame: "checkRight()", newAll: !0, pageNo: 1, pageSize: 10};
        JSON.stringify(t), sessionStorage.setItem("sessData", JSON.stringify(t))
    })
});
var publicUrl = config.publicUrl, url6 = config.url6, urljisu6 = config.urljisu6, imgUrl = config.imgUrl,
    indexObj = new Object, indextools = {}, bannernews = "", fanganyc = "";
indexObj.ajaGxklsf = function (e, t, a) {
    var e = void 0 == e ? "" : e, n = !1;
    $.ajax({
        url: publicUrl + "gxklsf/getLotteryInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        timeout: 6e4,
        success: function (t) {
            try {
                var n = tools.parseObj(t);
                if ("100002" == n.result.businessCode) throw new Error("error");
                if (n = n.result.data, tools.operatorTime("" == n.drawTime ? "0" : n.drawTime, n.serverTime) <= 0) throw new Error("error");
                tools.countDown(n.drawTime, n.serverTime, a, n.lotteryStatus)
            } catch (t) {
                console.log(t);
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (t, i) {
            (n = !1) || "timeout" == i && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.ajaxpk10 = function (e, t, a) {
    var e = void 0 == e ? "" : e, n = !1;
    $.ajax({
        url: publicUrl + "pks/getLotteryPksInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        timeout: 6e4,
        beforeSend: function () {
            void 0 == animateID[a] && animateMethod.pk10OpenAnimate_GaryAddIndex(a)
        },
        success: function (n) {
            try {
                indexObj.pk10Data(n, t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                console.log(t);
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (t, i) {
            (n = !1) || "timeout" == i && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.ajaxSsc = function (e, t, a) {
    var n = !1, i = publicUrl + "CQShiCai/getBaseCQShiCai.do?issue=" + (e = void 0 == e ? "" : e);
    "10070" == t && (i = publicUrl + "taiWanCai/getLotteryInfo.do"), $.ajax({
        url: i,
        type: "GET",
        data: {lotCode: t},
        timeout: 6e4,
        beforeSend: function () {
            void 0 == animateID[a] && ("10060" == t ? animateMethod.happyCZAnimate(a) : animateMethod.sscAnimate(a))
        },
        success: function (n) {
            try {
                indexObj.sscData(n, t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                console.log(t);
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (t, i) {
            (n = !1) || "timeout" == i && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.ajaxPCdd = function (e, t, a) {
    var e = void 0 == e ? "" : e, n = !1;
    $.ajax({
        url: publicUrl + "LuckTwenty/getPcLucky28.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        beforeSend: function () {
            void 0 == animateID[a] && animateMethod.sscAnimate(a)
        },
        success: function (n) {
            try {
                indexObj.creatDataHead(n, t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (t, i) {
            (n = !1) || "timeout" == i && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.typeOf = function (e, t) {
    if ("dxh" == e) switch (1 * t) {
        case-1:
            return "小";
        case 0:
            return "和";
        case 1:
            return "大"
    } else if ("dsh" == e) switch (1 * t) {
        case-1:
            return "双";
        case 0:
            return "和";
        case 1:
            return "单"
    }
}, indexObj.creatDataHead = function (e, t, a) {
    var n = tools.parseObj(e);
    if ("100002" == n.result.businessCode) throw new Error("error");
    if (n = n.result.data, tools.operatorTime("" == n.drawTime ? "0" : n.drawTime, n.serverTime) <= 0) throw new Error("error");
    n.totalCount;
    var i = n.totalCount;
    if ($(a).find(".preDrawIssue").text(n.preDrawIssue), $(a).find(".drawCount").text(n.drawCount), $(a).find(".sdrawCountnext").text(1 * i - 1 * n.drawCount), $(a).find(".sumNum").text(n.sumNum), "#egxy28" == a) {
        var o = $(a).find(".kajianhao");
        $(o).find("li:last-child").text(n.sumNum)
    }
    $(a).find(".sumBigSmall").text(indexObj.typeOf("dxh", n.sumBigSmall)), $(a).find(".sumSingleDouble").text(indexObj.typeOf("dsh", n.sumSingleDouble)), animateMethod.sscAnimateEnd(n.preDrawCode, a), tools.countDown(n.drawTime, n.serverTime, a, n.lotteryStatus)
}, indexObj.ajaxKlsf = function (e, t, a) {
    var e = void 0 == e ? "" : e, n = !1;
    $.ajax({
        url: publicUrl + "klsf/getLotteryInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        timeout: 6e4,
        beforeSend: function () {
            void 0 == animateID[a] && animateMethod.sscAnimate(a)
        },
        success: function (n) {
            try {
                indexObj.klsfData(n, t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (t, i) {
            (n = !1) || "timeout" == i && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.ajaxCqnc = function (e, t, a) {
    var e = void 0 == e ? "" : e, n = !1;
    $.ajax({
        url: publicUrl + "klsf/getLotteryInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        timeout: 6e4,
        beforeSend: function () {
            void 0 == animateID[a] && animateMethod.cqncAnimate(a)
        },
        success: function (t) {
            try {
                indexObj.cqncData(t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (t, i) {
            (n = !1) || "timeout" == i && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.ajaxKuai3 = function (e, t, a) {
    e = void 0 == e ? "" : e, $.ajax({
        url: publicUrl + "lotteryJSFastThree/getBaseJSFastThree.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        timeout: 6e4,
        beforeSend: function () {
            void 0 == animateID[a] && animateMethod.kuai3Animate(a)
        },
        success: function (n) {
            try {
                indexObj.kuai3Data(n, t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), iferror = !0
        },
        complete: function (t, n) {
            iferror = !1, iferror || "timeout" == n && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.shiyix5 = function (e, t, a) {
    var e = void 0 == e ? "" : e, n = !1;
    $.ajax({
        url: publicUrl + "ElevenFive/getElevenFiveInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        timeout: 6e4,
        beforeSend: function () {
            void 0 == animateID[a] && animateMethod.sscAnimate(a)
        },
        success: function (n) {
            try {
                indexObj.shiyix5Data(n, t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (t, i) {
            (n = !1) || "timeout" == i && indextools.repeatAjax(e, a)
        }
    })
};
var nexttimeinter = {};
indexObj.ajaxSmallSixInfo = function (e, t, a) {
    e = void 0 == e ? "" : e, $.ajax({
        url: publicUrl + "smallSix/findSmallSixInfo.do?issue="+e,
        type: "GET",
        timeout: 6e4,
        data: {lotCode: t},
        dataType: "json",
        beforeSend: function () {
            animateID[a]
        },
        success: function (t) {
            try {
                clearInterval(nexttimeinter[a]), nextopenTime(t.result.data.drawTime, t.result.data.serverTime, a,t.result.data.drawIssue), indexObj.renderSmallSixLottery(t, a)
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), iferror = !0
        },
        complete: function (t, n) {
            iferror = !1, iferror || "timeout" == n && indextools.repeatAjax(e, a)
        }
    })
},indexObj.ajaxAomenSixInfo = function (e, t, a) {
    e = void 0 == e ? "" : e, $.ajax({
        url: publicUrl + "smallSix/findSmallSixInfo.do?issue="+e,
        type: "GET",
        timeout: 6e4,
        data: {lotCode: t},
        dataType: "json",
        beforeSend: function () {
            animateID[a]
        },
        success: function (t) {
            try {
                clearInterval(nexttimeinter[a]), nextopenTime(t.result.data.drawTime, t.result.data.serverTime, a,t.result.data.drawIssue), indexObj.renderSmallSixLottery(t, a)
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), iferror = !0
        },
        complete: function (t, n) {
            iferror = !1, iferror || "timeout" == n && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.speedSixInfo = function (e, t, a) {
    e = void 0 == e ? "" : e;
    var n = "" == urljisu6 ? publicUrl : urljisu6;
    $.ajax({
        url: publicUrl + "speedSix/findSpeedSixInfo.do?issue="+e,
        type: "GET",
        timeout: 6e4,
        data: {lotCode: t},
        dataType: "json",
        beforeSend: function () {
            animateID[a]
        },
        success: function (t) {
            try {
                clearInterval(nexttimeinter[a]), nextopenTime(t.result.data.drawTime, t.result.data.serverTime, a,t.result.data.drawIssue), indexObj.renderSmallSixLottery(t, a)
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), iferror = !0
        },
        complete: function (t, n) {
            iferror = !1, iferror || "timeout" == n && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.renderSmallSixLottery = function (e, t, a) {
    var n = {};
    n.nextTime = e.result.data.drawTime, n.ThisCode = e.result.data.preDrawCode.split(","), indexObj.ifAnimateFun(e.result.data.type, e, n, t, a)
}, indexObj.elseFun = function (e, t, a) {
    var n = $(a);
    n.find(".nextIssue").text(e.result.data.drawIssue), n.find(".preDrawIssue").text(e.result.data.preDrawIssue), n.find(".opentyle").hide();
    var i = n.find(".numbox"), o = n.find(".sh_xzlist>li>span:first-child"),
        s = n.find(".sh_xzlist>li>span:last-child"), r = n.find("#openingLottery"),
        d = n.find("#jnumber>li:not(.addpic)"), l = n.find("#zongfen");
    o.text(""), s.text(""), d.text(""), d.removeClass(), t.ThisCode.length >= 6 ? (n.find(".addpic").show(), n.find(".zongfen").show()) : (n.find(".addpic").hide(), n.find(".zongfen").hide()), t.ThisCode[0] <= "" ? (r.show(), i.hide()) : (i.show(), r.hide()), l.text(e.result.data.sumTotal);
    for (var u = 0; u < t.ThisCode.length; u++) {
        if (void 0 == t.ThisCode[u] || void 0 == proto.fiveLineArr[e.result.data.fiveElements[u]]) return !1;
        if (void 0 == e.result.data.fiveElements[u]) return !1;
        o[u].innerHTML = proto.Zoo[e.result.data.chineseZodiac[u]], s[u].innerHTML = proto.fiveLineArr[e.result.data.fiveElements[u]], d[u].classList.add(proto.colorEng[e.result.data.color[u]]), d[u].classList.add("numblueHead"), d[u].innerHTML = t.ThisCode[u] > 9 ? t.ThisCode[u] : "0" + t.ThisCode[u]
    }
    $(a).find(".preDrawIssue").text(e.result.data.preDrawIssue)
}, indexObj.ifAnimateFun = function (e, t, a, n, i) {
    if (8 != e) {
        indexObj.elseFun(t, a, n);
        var o = setTimeout(function () {
            ajaxRequst("", "#smallSixInfo_hot"), ajaxRequst("", "#smallSixInfo"), clearTimeout(o)
        }, 2e3)
    }
    8 == e && ($(n).find(".addpic").show(), $(n).find(".zongfen").show(), indexObj.elseFun(t, a, n))
}, indexObj.pk10Data = function (e, t, a) {
    var n = tools.parseObj(e);
    if ("100002" == n.result.businessCode) throw new Error("error");
    if (1 !== (n = n.result.data).lotteryStatus) {
        if (tools.operatorTime("" == n.drawTime ? "0" : n.drawTime, n.serverTime) <= 0) throw new Error("error");
        $(a).find(".opentyle").hide(), $(a).find(".cuttime").css({display: "inline-block"});
        var i = n.totalCount;
        $(a).find(".drawCount").text(n.drawCount), $(a).find(".sdrawCountnext").text(i - 1 * n.drawCount);
        $(a).find(".nextIssue").text();
        $(a).find(".nextIssue").text(n.drawIssue), $(a).find(".preDrawIssue").text(n.preDrawIssue), $("#drawCount1").text(n.drawCount), $("#sdrawCount1").text(i - 1 * n.drawCount);
        for (var o = "", s = 0, r = $(a).find(".longhu").find("td").length; s < r; s++) switch (s) {
            case 0:
                o += "<td>" + ("0" == n.firstDT ? "龙" : "虎") + "</td>";
                break;
            case 1:
                o += "<td>" + ("0" == n.secondDT ? "龙" : "虎") + "</td>";
                break;
            case 2:
                o += "<td>" + ("0" == n.thirdDT ? "龙" : "虎") + "</td>";
                break;
            case 3:
                o += "<td>" + ("0" == n.fourthDT ? "龙" : "虎") + "</td>";
                break;
            case 4:
                o += "<td>" + ("0" == n.fifthDT ? "龙" : "虎") + "</td>";
                break;
            case 5:
                o += "<td>" + n.sumFS + "</td>";
                break;
            case 6:
                o += "<td>" + ("0" == n.sumBigSamll ? "大" : "小") + "</td>";
                break;
            case 7:
                o += "<td>" + ("0" == n.sumSingleDouble ? "单" : "双") + "</td>"
        }
        $(a).find(".longhu").html(""), $(a).find(".longhu").append(o);
        var d = n.preDrawCode.split(",");
        tools.countDown(n.drawTime, n.serverTime, a, n.lotteryStatus), animateMethod.pk10end_GaryAddIndex(d, a)
    } else tools.stopLottery(n, a, "pk10end_GaryAddIndex")
}, indexObj.sscData = function (e, t, a) {
    var n = tools.parseObj(e);
    if ("100002" == n.result.businessCode) throw new Error("error");
    if (1 !== (n = n.result.data).lotteryStatus) {
        if (tools.operatorTime("" == n.drawTime ? "0" : n.drawTime, n.serverTime) <= 0) throw new Error("error");
        var i = n.totalCount;
        $(a).find(".preDrawIssue").text(n.preDrawIssue), $(a).find(".nextIssue").text(n.drawIssue), $(a).find(".drawCount").text(n.drawCount), $(a).find(".sdrawCountnext").text(1 * i - 1 * n.drawCount), $(a).find(".sumNum").text(n.sumNum), $(a).find(".sumSingleDouble").text(0 == n.sumSingleDouble ? "单" : "双"), $(a).find(".sumBigSmall").text(0 == n.sumBigSmall ? "大" : "小");
        var o = "";
        "0" == n.dragonTiger ? o = "龙" : "1" == n.dragonTiger ? o = "虎" : "2" == n.dragonTiger && (o = "和"), $(a).find(".dragonTiger").text(o), $(a).find(".behindThree").text(typeOf("san", n.behindThree)), $(a).find(".betweenThree").text(typeOf("san", n.betweenThree)), $(a).find(".lastThree").text(typeOf("san", n.lastThree)), "10060" == t ? animateMethod.happyCZAnimateEnd(n.preDrawCode, a) : animateMethod.sscAnimateEnd(n.preDrawCode, a), tools.countDown(n.drawTime, n.serverTime, a, n.lotteryStatus)
    } else "10060" == t ? tools.stopLottery(n, a, "happyCZAnimateEnd") : tools.stopLottery(n, a, "sscAnimateEnd")
}, indexObj.shiyix5Data = function (e, t, a) {
    var n = tools.parseObj(e);
    if ("100002" == n.result.businessCode) throw new Error("error");
    if (1 !== (n = n.result.data).lotteryStatus) {
        if (tools.operatorTime("" == n.drawTime ? "0" : n.drawTime, n.serverTime) <= 0) throw new Error("error");
        var i = n.totalCount;
        $(a).find(".preDrawIssue").text(n.preDrawIssue), $(a).find(".nextIssue").text(n.drawIssue), $(a).find(".drawCount").text(n.drawCount), $(a).find(".sdrawCountnext").text(1 * i - 1 * n.drawCount), $(a).find(".sumNum").text(n.sumNum), $(a).find(".sumSingleDouble").text(0 == n.sumSingleDouble ? "单" : "双"), $(a).find(".sumBigSmall").text(typeOf("Indxh", n.sumBigSmall));
        "0" == n.dragonTiger ? "龙" : "1" == n.dragonTiger ? "虎" : "2" == n.dragonTiger && "和", $(a).find(".behindThree").text(typeOf("san", n.behindThree)), $(a).find(".betweenThree").text(typeOf("san", n.betweenThree)), $(a).find(".lastThree").text(typeOf("san", n.lastThree));
        $(a).find(".nextIssue").text();
        animateMethod.sscAnimateEnd(n.preDrawCode, a), tools.countDown(n.drawTime, n.serverTime, a, n.lotteryStatus)
    } else tools.stopLottery(n, a, "sscAnimateEnd")
}, indexObj.kuai3Data = function (e, t, a) {
    var n = tools.parseObj(e);
    if ("100002" == n.result.businessCode) throw new Error("error");
    if (1 !== (n = n.result.data).lotteryStatus) {
        if (tools.operatorTime("" == n.drawTime ? "0" : n.drawTime, n.serverTime) <= 0) throw new Error("error");
        var i = n.totalCount;
        $(a).find(".preDrawIssue").text(n.preDrawIssue), $(a).find(".nextIssue").text(n.drawIssue), $(a).find(".sumNum").text(n.sumNum), $(a).find(".sumSingleDouble").text(0 == n.sumSingleDouble ? "单" : "双"), $(a).find(".sumBigSmall").text(0 == n.sumBigSmall ? "大" : "小"), $(a).find(".firstSeafood").text(typeOf("seafood", n.firstSeafood)), $(a).find(".secondSeafood").text(typeOf("seafood", n.secondSeafood)), $(a).find(".thirdSeafood").text(typeOf("seafood", n.thirdSeafood)), $(a).find(".drawCount").text(n.drawCount), $(a).find(".drawCount").text(n.drawCount), $(a).find(".sdrawCountnext").text(1 * i - 1 * n.drawCount);
        $(a).find(".dragonTiger").text(""), animateMethod.kuai3AnimateEnd(n.preDrawCode, a), tools.countDown(n.drawTime, n.serverTime, a, n.lotteryStatus)
    } else tools.stopLottery(n, a, "kuai3AnimateEnd")
}, indexObj.klsfData = function (e, t, a) {
    var n = tools.parseObj(e);
    if ("100002" == n.result.businessCode) throw new Error("error");
    if (1 !== (n = n.result.data).lotteryStatus) {
        if (tools.operatorTime("" == n.drawTime ? "0" : n.drawTime, n.serverTime) <= 0) throw new Error("error");
        var i = n.totalCount;
        $(a).find(".preDrawIssue").text(n.preDrawIssue), $(a).find(".nextIssue").text(n.drawIssue), $(a).find(".drawCount").text(n.drawCount), $(a).find(".sdrawCountnext").text(1 * i - 1 * n.drawCount), $(a).find(".sumNum").text(n.sumNum), $(a).find(".sumSingleDouble").text(0 == n.sumSingleDouble ? "单" : "双"), $(a).find(".sumBigSmall").text(typeOf("Indxh", n.sumBigSmall)), $(a).find(".lastBigSmall").text(0 == n.lastBigSmall ? "尾大" : "尾小");
        "0" == n.dragonTiger ? "龙" : "1" == n.dragonTiger ? "虎" : "2" == n.dragonTiger && "和", $(a).find(".firstDragonTiger").text(0 == n.firstDragonTiger ? "龙" : "虎"), $(a).find(".secondDragonTiger").text(0 == n.secondDragonTiger ? "龙" : "虎"), $(a).find(".thirdDragonTiger").text(0 == n.thirdDragonTiger ? "龙" : "虎"), $(a).find(".fourthDragonTiger").text(0 == n.fourthDragonTiger ? "龙" : "虎"), $(a).find(".numblue").each(function () {
            $(this).text() >= 19 && $(this).addClass("numred")
        }), animateMethod.sscAnimateEnd(n.preDrawCode, a), tools.countDown(n.drawTime, n.serverTime, a, n.lotteryStatus)
    } else tools.stopLottery(n, a, "sscAnimateEnd")
}, indexObj.cqncData = function (e, t) {
    var a = tools.parseObj(e);
    if ("100002" == a.result.businessCode) throw new Error("error");
    if (1 !== (a = a.result.data).lotteryStatus) {
        if (tools.operatorTime("" == a.drawTime ? "0" : a.drawTime, a.serverTime) <= 0) throw new Error("error");
        $(t).find(".preDrawIssue").text(a.preDrawIssue), $(t).find(".nextIssue").text(a.drawIssue), $(t).find(".drawCount").text(a.drawCount), $(t).find(".sdrawCountnext").text(84 - 1 * a.drawCount), $(t).find(".sumNum").text(a.sumNum), $(t).find(".sumSingleDouble").text(0 == a.sumSingleDouble ? "单" : "双"), $(t).find(".sumBigSmall").text(0 == a.sumBigSmall ? "大" : "小"), $(t).find(".lastBigSmall").text(0 == a.lastBigSmall ? "尾大" : "尾小");
        "0" == a.dragonTiger ? "龙" : "1" == a.dragonTiger ? "虎" : "2" == a.dragonTiger && "和", $(t).find(".firstDragonTiger").text(0 == a.firstDragonTiger ? "龙" : "虎"), $(t).find(".secondDragonTiger").text(0 == a.secondDragonTiger ? "龙" : "虎"), $(t).find(".thirdDragonTiger").text(0 == a.thirdDragonTiger ? "龙" : "虎"), $(t).find(".fourthDragonTiger").text(0 == a.fourthDragonTiger ? "龙" : "虎"), clearInterval(animateID[t]), animateMethod.cqncAnimateEnd_GaryAddNotUl(a.preDrawCode, t), tools.countDown(a.drawTime, a.serverTime, t, a.lotteryStatus), $(t).find(".opentyle").hide(), $(t).find(".cuttime").css({display: "inline-block"})
    } else tools.stopLottery(a, t, "cqncAnimateEnd_GaryAddNotUl")
}, indexObj.ajaxTcpl3 = function (e, t, a) {
    var n = !1;
    $.ajax({
        url: config.publicUrl + "QuanGuoCai/getLotteryInfo1.do?issue=" + e,
        type: "GET",
        data: {lotCode: t},
        beforeSend: function () {
            void 0 == animateID[a] && animateMethod.sscAnimate(a)
        },
        success: function (t) {
            try {
                indexObj.insertHeadQGC(t, a), clearInterval(animateID[a]), delete animateID[a]
            } catch (t) {
                indextools.repeatAjax(e, a)
            }
        },
        error: function (t) {
            indextools.repeatAjax(e, a), n = !0
        },
        complete: function (e, t) {
            (n = !1) || "timeout" == t && indextools.repeatAjax(e, a)
        }
    })
}, indexObj.insertHeadQGC = function (e, t) {
    var a = tools.parseObj(e);
    if ("100002" == a.result.businessCode) throw new Error("error");
    if (a = a.result.data, tools.operatorTime("" == a.drawTime ? "0" : a.drawTime, a.serverTime) <= 0) throw new Error("error");
    a.totalCount;
    $(t).find(".preDrawIssue").text(a.preDrawIssue), $(t).find(".nextIssue").text(a.drawIssue), tools.countDown(a.drawTime, a.serverTime, t, a.lotteryStatus), animateMethod.sscAnimateEnd(a.preDrawCode, t), toolBoxs.resetRed(t), $("#waringbox").hide(300);
    var n = "<td style='color:#a91818'>" + a.sumHundredTen + "</td><td>" + (0 == a.htSingleDouble ? "单" : "双") + "</td><td>" + (0 == a.httailBigSmall ? "尾大" : "尾小") + "</td>";
    n += "<td style='color:#a91818'>" + a.sumHundredOne + "</td><td>" + (0 == a.hoSingleDouble ? "单" : "双") + "</td><td>" + (0 == a.hotailBigSmall ? "尾大" : "尾小") + "</td>", n += "<td style='color:#a91818'>" + a.sumTenOne + "</td><td>" + (0 == a.toSingleDouble ? "单" : "双") + "</td><td>" + (0 == a.totailBigSmall ? "尾大" : "尾小") + "</td>", n += "<td style='color:#a91818'>" + a.sumNum + "</td><td>" + (0 == a.sumSingleDouble ? "单" : "双") + "</td><td>" + (0 == a.sumBigSmall ? "大" : "小") + "</td>", $(t).find(".tabTr").html(n)
}, indexObj.loadBannerNews = function () {
    $.ajax({
        url: publicUrl + "news/findNewestHPNews.do",
        type: "GET",
        data: {limit: config.newRows, platform: "168"},
        dataType: "json",
        timeout: 6e4,
        beforeSend: function () {
            $("#bannernews").empty().text("正在加载...")
        },
        success: function (e) {
            if ("object" == (void 0 === (e = e) ? "undefined" : _typeof(e)) || (e = JSON.parse(e)), "0" == e.errorCode) if ("0" == e.result.businessCode) {
                $("#bannernews").empty();
                var t = "";
                bannernews = e.result.data, $(e.result.data).each(function () {
                    t += "<p><a target='_blank' href='/view/news/zx_detail.html?" + this.newsId + "'>" + this.title + "</a></p>"
                }), $("#bannernews").append(t)
            } else $("#bannernews").empty().text("数据加载异常！")
        },
        error: function (e) {
            $("#bannernews").empty().text("正在加载..."), indexObj.loadBannerNews()
        },
        complete: function (e, t) {
            null
        }
    })
}, indexObj.loadFangAanNews = function () {
    $.ajax({
        url: publicUrl + "news/findProjectPrediction.do",
        type: "GET",
        dataType: "json",
        data: {programaId: "", pageNo: 1, pageSize: 10, platform: "168"},
        timeout: 6e4,
        beforeSend: function () {
            $("#fanganyc").empty().text("正在加载...")
        },
        success: function (e) {
            if ("object" == (void 0 === (e = e) ? "undefined" : _typeof(e)) || (e = JSON.parse(e)), "0" == e.errorCode) if ("0" == e.result.businessCode) {
                $("#fanganyc").empty();
                var t = "";
                fanganyc = e.result.data.list, $(e.result.data.list).each(function () {
                    t += "<li><a target='_blank' href='/view/news/zx_detail.html?" + this.newsId + "'>" + this.title + "</a></li>"
                }), $("#fanganyc").append(t)
            } else $("#fanganyc").empty().text("数据加载异常！")
        },
        error: function (e) {
            $("#fanganyc").empty().text("正在加载..."), indexObj.loadFangAanNews()
        },
        complete: function (e, t) {
            null
        }
    })
}, indexObj.loadBanner = function () {
    $.ajax({
        url: publicUrl + "focusPicture/findPictureAndNotice.do",
        type: "GET",
        dataType: "json",
        data: {type: "0", position: "0", sourceUrl: tools.YM(), platform: "168"},
        timeout: 6e4,
        beforeSend: function () {
            $("#bannerContent").text("努力加载中...")
        },
        success: function (e) {
            "object" == (void 0 === (e = e) ? "undefined" : _typeof(e)) || (e = JSON.parse(e)), "0" == e.errorCode && ("0" == e.result.businessCode ? tools.bannerImg(e.result.data) : $("#bannerContent").empty().text("数据加载异常！"))
        },
        error: function (e) {
            $("#bannerContent").empty().text("正在加载..."), setTimeout(indexObj.loadBanner(), 1e3)
        },
        complete: function (e, t) {
            null
        }
    })
}, indexObj.defaultViewigm = function (e) {
    $(e).attr("src", "img/banner/banner01.jpg"), $(e).parent().css({"background-color": "#d70042"})
}, indextools.repeatAjax = function (e, t) {
    setTimeout(function () {
        ajaxRequst(e, t)
    }, 1e3)
}, indextools.LiText = function () {
    "block" == $(".11check5_ran").css("display") && $(".check_zhuOrXa").text($(".11check5_ran>.check_ran").text())
};
var canLeft = 0, canRight = "default", vlength = 0, viewCount = 2, defWidth = 167, moveLeft = 0;
indextools.videoMove = function (e) {
    if ((vlength = $(".video_box>ul>li").length) <= 5) return !1;
    if ("default" == canRight && (canRight = vlength - 5), canLeft && "v_left" == e) canLeft - viewCount >= 0 ? (moveLeft = defWidth * viewCount, canLeft -= viewCount, canRight += viewCount) : (moveLeft = defWidth * canLeft, canRight += canLeft, canLeft = 0); else {
        if (!canRight || "v_right" != e) return !1;
        canRight - viewCount >= 0 ? (moveLeft = defWidth * viewCount * -1, canRight -= viewCount, canLeft += viewCount) : (moveLeft = -1 * defWidth * canRight, canLeft += canRight, canRight = 0)
    }
    var t = 1 * $(".video_box>ul").css("left").replace("px", "");
    $(".video_box>ul").css("left", t + moveLeft + "px"), 0 == canLeft ? $(".v_left").addClass("v_opacity") : $(".v_left").removeClass("v_opacity"), 0 == canRight ? $(".v_right").addClass("v_opacity") : $(".v_right").removeClass("v_opacity")
}, $(".video_box").on("click", "span", function () {
    indextools.videoMove($(this).attr("class"))
}), $(".lottey_title").on("click", "li", function () {
    var e = $(this).addClass("check").attr("data-text");
    $(this).siblings(".check").removeClass("check"), $(e).siblings().css("height", 0);
    var t = $("#myFav").height(), a = $("#myFavConfig").height();
    a > t && (t = a);
    var n = $(e).children().length, i = 240 * n - 20, o = 206 * n + 20 * n + 676 + 40 + t;
    $(e).css({height: i + "px", "z-index": 1}), $(".menubannboxc").css({height: o + "px"})
}), $(".movedowm").on({
    hover: function () {
        $(".tjlottey").addClass("hover")
    }
}), $(".tjlottey").mouseleave(function () {
    $(this).removeClass("hover")
});
var ifopen = !1, isfirthload = !0, lc = "";
$(function () {
    $(".video_a").click(function () {
        openVdio($(this).attr("data-text"))
    }), $("#videobox").click(function () {
        $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            })
        }), ifopen = !1, $("#videoIframe").find("iframe").removeAttr("src")
    }), $(".video_box").on("click", "ul>li>a", function (e) {
        e.preventDefault(), openVdio($(this).attr("href"))
    })
}), indextools.userXahao = function (e, t, a) {
    $.ajax({
        type: "get",
        url: publicUrl + "KillNum/getPksKillPlanList.do?lotCode=" + e,
        async: !1,
        data: {lasCount: t, hisCount: a},
        dataType: "json",
        success: function (e) {
            "object" == (void 0 === e ? "undefined" : _typeof(e)) || (e = JSON.parse(e));
            var e = e.result.data, t = $(".px10sanhao>.rank>span.active").attr("data-text");
            indextools.userXahao_adddom(t, e), $(".px10sanhao>.rank").on("click", "span", function () {
                var t = $(this).attr("data-text");
                $(this).addClass("active").siblings(".active").removeClass(), indextools.userXahao_adddom(t, e)
            })
        },
        error: function (e) {
        }
    })
}, indextools.userXahao_adddom = function (e, t) {
    for (var a = [], n = 0; n < t[e + "Num"].length; n++) {
        var i = t[e + "Num"][n];
        n % 2 == 0 && a.push(i)
    }
    var o = "";
    $.each(a, function (a, n) {
        o += "<li><div class='head_div'><a href='/view/zsh/index.html?lottype=pk10_Kill'> <img src='img/head_png/headicon_" + a + ".png' /></a>", o += "<span>" + config.Uname[a] + "</span> </div><div class='result'>", o += "<h3>最新冠军杀号: <span>" + n + "</span></h3><p>近10期成功率： <span class='clo_red'>" + t[e + "Percent"][a] + "</span></p>", o += "<p>历史战绩： <span>" + t[e + "HisPercent"][a] + "</span></p></div></li>"
    }), $(".px10sanhao>.user_score>ul").html(o)
}, indextools.userXahaoSsc = function (e, t, a) {
    $.ajax({
        type: "get",
        url: publicUrl + "KillNum/getSscKillPlanList.do?lotCode=" + e,
        async: !1,
        data: {lasCount: t, hisCount: a},
        dataType: "json",
        success: function (e) {
            "object" == (void 0 === e ? "undefined" : _typeof(e)) || (e = JSON.parse(e));
            var e = e.result.data, t = $(".SSCsanhao>.rank>span.active").attr("data-text");
            indextools.userXahaoSsc_adddom(t, e), $(".SSCsanhao>.rank").on("click", "span", function () {
                var t = $(this).attr("data-text");
                $(this).addClass("active").siblings(".active").removeClass(), indextools.userXahaoSsc_adddom(t, e)
            })
        },
        error: function (e) {
        }
    })
}, indextools.userXahaoSsc_adddom = function (e, t) {
    for (var a = [], n = 0; n < t[e + "Num"].length; n++) {
        var i = t[e + "Num"][n];
        n % 2 == 0 && a.push(i)
    }
    var o = "";
    $.each(a, function (a, n) {
        o += "<li><div class='head_div'><a href='/view/zsh/index.html?lottype=happyCZ_Kill'> <img src='img/head_png/headicon_" + a + ".png' /></a>", o += "<span>" + config.SscUname[a] + "</span> </div><div class='result'>", o += "<h3>最新冠军杀号: <span>" + n + "</span></h3><p>近10期成功率： <span class='clo_red'>" + t[e + "Percent"][a] + "</span></p>", o += "<p>历史战绩： <span>" + t[e + "HisPercent"][a] + "</span></p></div></li>"
    }), $(".SSCsanhao>.user_score>ul").html(o)
}, $(function () {
    fanganyc = JSON.parse($("#fanganycdata").val())
    //bannernews = JSON.parse($("#bannernewsdata").val())
});
var smallSixInfoCountDownTimer, MyFavObj = {
    loginInfo: null,
    defaultData: [],//10057, 10037, 10012, , 10073
    lotteryReqInfo: {
        url: {
            pk10: "pks/getLotteryPksInfo.do",
            kuai3: "lotteryJSFastThree/getBaseJSFastThree.do",
            cqnc: "klsf/getLotteryInfo.do",
            ssc: "CQShiCai/getBaseCQShiCai.do",
            shiyi5: "ElevenFive/getElevenFiveInfo.do",
            klsf: "klsf/getLotteryInfo.do",
            gxklsf: "gxklsf/getLotteryInfo.do",
            egxy: "LuckTwenty/getPcLucky28.do",
            bjkl8: "LuckTwenty/getBaseLuckTewnty.do",
            qgc: "QuanGuoCai/getLotteryInfo.do",
            qgc1: "QuanGuoCai/getLotteryInfo1.do",
            twc: "taiWanCai/getLotteryInfo.do",
            sixLotteryInfo: "smallSix/findSmallSixInfo.do",
            sixLotterySpeed: "speedSix/findSpeedSixInfo.do"
        },
        animate: {
            pk10: "pk10end",
            kuai3: "kuai3AnimateEnd",
            cqnc: "cqncAnimateEnd",
            ssc: "sscAnimateEnd",
            shiyi5: "sscAnimateEnd",
            klsf: "sscAnimateEnd",
            gxklsf: "sscAnimateEnd",
            egxy: "sscAnimateEnd",
            bjkl8: "sscAnimateEnd",
            qgc: "sscAnimateEnd",
            qgc1: "sscAnimateEnd",
            twc: "sscAnimateEnd",
            sixLotteryInfo: "sscAnimateEnd",
            sixLotterySpeed: "sscAnimateEnd"
        }
    },
    LotterySeries: {
        pk10: ["10001", "10012", "10037", "10035", "10057", "10058", "10079"],
        ssc: ["10002", "10003", "10004", "10010", "10036", "10050", "10056", "10059", "10060", "10064", "10075", "10077"],
        klsf: ["10005", "10011", "10034", "10053", "10078", "10083"],
        cqnc: ["10009"],
        kuai3: ["10007", "10026", "10027", "10028", "10029", "10030", "10032", "10033", "10052", "10061", "10062", "10063", "10076"],
        shiyi5: ["10006", "10008", "10015", "10016", "10017", "10018", "10019", "10020", "10021", "10022", "10023", "10024", "10025", "10055", "10084"],
        bjkl8: ["10013", "10014", "10047", "10054", "10073", "10080", "10082"],
        qgc: ["10039", "10040", "10042", "10044", "10045"],
        qgc1: ["10041", "10043"],
        gxklsf: ["10038"],
        egxy: ["10046", "10074", "10081"],
        twc: ["10070", "10071", "10072"],
        sixLotteryInfo: ["10048"],
        sixLotterySpeed: ["10051"]
    },
    initMyFav: function () {
        this.loadData();
        var e = $(".headboxhr .login").attr("href"), t = $(".headboxhr .register").attr("href");
        $("#myFav .login").attr("href", e), $("#myFav .register").attr("href", t), this.eventUnit()
    },
    proxyDefaultData: {
        allClear: function () {
            $(".choiceContent").empty(), this.setGaryBox(5), $(".kindslist li").removeClass("check"), $(".saveBtn").addClass("saveDisable"), this.switchErr()
        }, deleteOne: function (e) {
            $(".choiceContent #box_" + e).remove(), $(".kindslist #" + e).removeClass("check"), this.setGaryBox(1), this.switchErr()
        }, checkOne: function (e) {
            MyFavObj.defaultData.length > 5 ? (this.switchErr("visible"), MyFavObj.defaultData.pop()) : (MyFavObj.initConfigPage(e), this.switchErr())
        }, setGaryBox: function (e) {
            for (var t = "", a = 0; a < e; a++) t += '<div class="box forbidden" draggable="false"></div>';
            $(".choiceContent").append(t)
        }, switchErr: function (e) {
            var e = e || "hidden", t = "addClass";
            MyFavObj.defaultData.length > 0 && (t = "removeClass"), $(".saveBtn")[t]("saveDisable"), $(".errContent").css("visibility", e)
        }
    },
    loadData: function () {
        var e = sessionStorage.getItem("tokens");
        this.loginInfo = e, e ? this.loadUserData(e) : this.loadLotteryInfo()
    },
    eventUnit: function () {
        var e = this;
        // $(".showLot").on("click", ".cz,.kjhm", function (e) {
        //     var t = $(e.currentTarget).parent().find("a")[0].href;
        //     "https://6hch.cc/" === t ? redirectTo6hco() : window.open(t)
        // });
        $(".btnCon").on("click", function (t) {
            var a = $(t.target);
            if (a.hasClass("upBtn")) {
                var n = $(".menubannboxc").height();
                a.hasClass("downIcon") ? ($(".tablehead").slideDown(), a.removeClass("downIcon").text("收起"), n += 304) : ($(".tablehead").slideUp(), a.addClass("downIcon").text("展开"), n -= 304), $(".menubannboxc").css("height", n + "px")
            }
            a.hasClass("editBtn") && !a.hasClass("editDisable") && ($("#myFav").hide(), $("#myFavConfig").show("slow")), a.hasClass("saveBtn") && !a.hasClass("saveDisable") && e.upDataUserPerference()
        }), $(".dialogBtn").on("click", function () {
            var t = $(this);
            t.hasClass("helpBtn") ? $("#myFavSetCom .helpDialog").removeClass("disnone") : t.hasClass("close") ? t.parents(".helpDialog").addClass("disnone") : e.defaultData.length > 0 && $(".clearDialog").removeClass("disnone")
        }), $(".clearDialog .modalFooter").on("click", function (t) {
            var a = $(t.target);
            a.hasClass("comfirm") && (e.defaultData.length = 0, e.proxyDefaultData.allClear()), a.parents(".clearDialog").addClass("disnone")
        }), $("#ShowTul").on("mouseover", ".cailist", function (e) {
            $(this).addClass("ahover").siblings().removeClass("ahover");
            var t = $(this).attr("id");
            $("#ul" + t).removeClass("disnone").siblings().addClass("disnone")
        }), $(".kindslist").on("click", "li", function (t) {
            var a = t.target, n = +a.id, i = e.defaultData;
            if ("check" == a.className) {
                var o = i.indexOf(n);
                i.splice(o, 1), e.proxyDefaultData.deleteOne(n)
            } else i.push(n), e.proxyDefaultData.checkOne(n)
        }), $(".choiceContent").on("click", ".check", function (t) {
            var a = +$(this).attr("id").split("_")[1], n = e.defaultData.indexOf(a);
            e.defaultData.splice(n, 1), e.proxyDefaultData.deleteOne(a)
        }), $("#drag-wrap").on("dragstart", function (e) {
            var t = (e = e || window.event).target;
            if (t.className.indexOf("forbidden") > -1) return !1;
            e.originalEvent.dataTransfer.setData("Text", t.id + ";" + t.parentElement.id)
        }), $("#drag-wrap").on("dragover", function (e) {
            (e = e || window.event).preventDefault()
        }), $("#drag-wrap").on("drop", function (e) {
            (e = e || window.event).preventDefault();
            var t = e.target;
            if (t.className.indexOf("forbidden") > -1) return !1;
            var a, n;
            if ("div" !== t.tagName.toLowerCase() ? (a = t.parentElement, n = t) : (a = t, n = t.querySelector("a")), a.classList.contains("box")) {
                var i = e.originalEvent.dataTransfer.getData("Text").split(";");
                document.getElementById(i[1]).appendChild(n), a.appendChild(document.getElementById(i[0])), a.id = i[1];
                var o = n.id.replace(/[^0-9]/gi, "");
                $(n).parent().attr("id", "box_" + o)
            }
        })
    },
    loadUserData: function (e) {
        var t = this;
        $.ajax({
            type: "get",
            url: publicUrl + "user/userPreferences.do",
            headers: {token: e},
            dataType: "json",
            success: function (e) {
                if (e.result && 0 === e.result.businessCode) {
                    var a = e.result.data.userPreferences.userPreferences;
                    t.defaultData = a.split(","), t.loadLotteryInfo(), $("#myFavLot .dialog").addClass("disnone"), $("#myFav .editBtn").removeClass("editDisable")
                }
            },
            error: function (e) {
            }
        })
    },
    loadLotteryInfo: function () {
        var e = this;
        console.log('this.defaultData',this.defaultData);
        $(".choiceContent").empty(), this.proxyDefaultData.setGaryBox(5), this.defaultData.forEach(function (t) {
            var a = e.isLotterySeries(t);
            if (void 0 !== a) {
                e.initConfigPage(t);
                var n = e.lotteryReqInfo.url[a], i = $("#cz_" + t).find(".nextIssue").text();
                "..." == i && (i = ""), params = {url: n, issue: i, lotCode: t, LotSeries: a}, e.ajaxLotteryInfo(params)
            }
        })
    },
    ajaxLotteryInfo: function (e) {
        var t = this, a = !1, n = e.url, i = publicUrl + n, o = e.issue, s = e.lotCode, r = e.LotSeries, d = !0;
        "sixLotteryInfo" == r && (i = url6 + n, d = !1), $.ajax({
            url: i,
            type: "GET",
            dataType: "json",
            data: {lotCode: s, issue: o},
            timeout: 6e4,
            beforeSend: function () {
                d && t.loadingFn(s, !0)
            },
            success: function (e) {
                try {
                    var a = {data: e, lotCode: s, url: n, LotSeries: r};
                    t.renderData(a), t.loadingFn(s, !1)
                } catch (e) {
                    setTimeout(function () {
                        t.ajaxLotteryInfo(a)
                    }, 1e3, n)
                }
            },
            error: function () {
                setTimeout(function () {
                    t.ajaxLotteryInfo(e)
                }, 1e3), a = !0
            },
            complete: function (n, i) {
                a || "timeout" == i && setTimeout(function () {
                    t.ajaxLotteryInfo(e)
                }, 1e3)
            }
        })
    },
    resizeLotteryList: function () {
        $("#myFavLot .list").hide();
        var e = document.createDocumentFragment(), t = $("#myFavLot .list").length, a = this, n = 0;
        this.defaultData.forEach(function (t) {
            if (void 0 !== a.isLotterySeries(t)) {
                var i = $("#cz_" + t), o = i.clone(!0)[0];
                void 0 !== o && (e.appendChild(o), i.remove(), n++)
            }
        });
        var i = t - n - 1;
        document.querySelector("#myFavLot ul").appendChild(e), $("#myFavLot .list:gt(" + i + ")").show()
    },
    setKajianhaoColor: {
        klsf: function (e) {
            $(e).find(".numblue").each(function () {
                $(this).text() >= 19 && $(this).addClass("numred")
            })
        }, gxklsf: function (e) {
            $(e).find(".kajianhao").find("li").each(function (e, t) {
                +t.innerText % 3 == 0 && $(t).removeClass().addClass("numgreen"), (t.innerText - 1) % 3 == 0 && $(t).removeClass().addClass("numred")
            })
        }, egxy: function (e) {
            $(e).find(".kajianhao").find("li:last-child").addClass("numred")
        }, bjkl8: function (e) {
            var t = 1 * e.split("_")[1], a = lotCode, n = [a.sgHappy8, a.jisukl8, a.kl8];
            $(e).find(".numberbox li").removeClass().addClass("numLightblue"), $(e).find(".numLightblue").each(function () {
                $(this).text() >= 41 && $(this).addClass("numWeightblue")
            }), n.includes(t) || $(e).find(".kajianhao").find("li:last-child").addClass("numOrange")
        }, qgc: function (e) {
            var t = $(e).find(".numberbox li"), a = e.split("_")[1];
            "10039,10042".indexOf(a) > -1 && t.addClass("numred").slice(-1).removeClass("numred"), "10041,10043,10044".indexOf(a) > -1 && t.addClass("numred"), "10040" == a && t.addClass("numred").slice(-2).removeClass("numred")
        }
    },
    verifySmallSixLotteryInfo: function (e, t) {
        console.log("33333333333333")
        var a = this, n = e.data.result.data.type, i = a.isLotterySeries(e.lotCode),
            o = {url: e.url, issue: "", lotCode: e.lotCode, LotSeries: i};
        if (8 != n) {
            a.renderSmallSixLotteryData(e, t);
            var s = setTimeout(function () {
                a.ajaxLotteryInfo(o), clearTimeout(s)
            }, 2e3)
        }
        8 == n && ($(t).find(".addpic").show(), $(t).find(".zongfen").show(), a.renderSmallSixLotteryData(e, t))
    },
    renderSmallSixLotteryData: function (e, t) {
        var a = {}, n = $(t), i = e.data, o = n.find(".numbox"), s = n.find("#openingLottery"),
            r = n.find(".sh_xzlist>li>span:first-child"), d = n.find(".sh_xzlist>li>span:last-child"),
            l = n.find("#jnumber>li:not(.addpic)"), u = n.find("#zongfen");
        a.ThisCode = i.result.data.preDrawCode.split(","), u.text(""), r.text(""), d.text(""), l.text(""), l.removeClass(), a.ThisCode.length >= 6 ? (n.find(".addpic").show(), n.find(".zongfen").show()) : (n.find(".addpic").hide(), n.find(".zongfen").hide()), a.ThisCode[0] <= "" ? (s.show(), o.hide()) : (o.show(), s.hide()), u.text(i.result.data.sumTotal);
        for (var c = 0; c < a.ThisCode.length; c++) {
            if (void 0 == a.ThisCode[c] || void 0 == proto.fiveLineArr[i.result.data.fiveElements[c]]) return !1;
            if (void 0 == i.result.data.fiveElements[c]) return !1;
            r[c].innerHTML = proto.Zoo[i.result.data.chineseZodiac[c]], d[c].innerHTML = proto.fiveLineArr[i.result.data.fiveElements[c]], l[c].classList.add(proto.colorEng[i.result.data.color[c]]), l[c].classList.add("numblueHead"), l[c].innerHTML = a.ThisCode[c] > 9 ? a.ThisCode[c] : "0" + a.ThisCode[c]
        }
    },
    renderData: function (e) {
        var t = (t = e.data).result.data, a = e.lotCode, n = e.url, i = e.LotSeries, o = "#cz_" + a,
            s = "" == t.drawTime ? "0" : t.drawTime, r = this.lotteryReqInfo.animate[i], d = this.setKajianhaoColor[i],
            l = $(o), u = t.preDrawCode;
        if (1 !== t.lotteryStatus) {
            if (tools.operatorTime(s, t.serverTime) <= 0) throw new Error("error");
            if (l.find(".lotName").text(t.lotName), "pk10" === i ? u = u.split(",") : "egxy" === i && (u = t.preDrawCode + "," + t.sumNum), "10060" == a ? animateMethod.happyCZAnimateEnd(u, o) : animateMethod[r](u, o), "qgc1" === i && (d = this.setKajianhaoColor.qgc), d && d(o), l.find(".nextIssue").text(t.drawIssue), l.find(".preDrawIssue").text(t.preDrawIssue), l.find(".opentyle").hide(), "sixLotterySpeed" === i || "sixLotteryInfo" === i) {
                if ("sixLotteryInfo" === i) return this.verifySmallSixLotteryInfo(e, o), void this.smallSixInfoCountDown(s, t.serverTime, a, n);
                this.renderSmallSixLotteryData(e, o)
            }
            this.countDown(s, t.serverTime, a, n)
        } else "10060" == a ? tools.stopLottery(t, o, "happyCZAnimateEnd") : tools.stopLottery(t, o, r)
    },
    isLotterySeries: function (e) {
        var t = this.LotterySeries, e = e + "";
        for (var a in t) if (t[a].indexOf(e) > -1) return a
    },
    loadingFn: function (e, t) {
        e = "#cz_" + e;
        var a = $(e + " .kajianhao"), n = $(e + " .kajianhao").find(".numberbox"),
            i = $(e + " .kajianhao").find(".zongfen"), o = $(e + " .kaijintime").find(".cuttime"),
            s = $(e + " .egxy_kajianhao").find(".addF1"), r = $(e + " .egxy_kajianhao").find(".equalF");
        if (t) {
            n.hide(), "#cz_10051" === e && i.hide();
            var d = a.find(".progress");
            d.length ? d.show() : a.append('<div class="progress" style="display: block;"><img src="../../img/icon/piaog.gif"></div>'), o.hide(), s.hide(), r.hide()
        } else n.show(), "#cz_10051" === e && i.show(), a.find(".progress").hide(), o.show(), s.show(), r.show()
    },
    countDown: function (e, t, a, n) {
        var i, o = e.replace(/-/g, "/"), t = t.replace(/-/g, "/"), s = $("#cz_" + a), r = this, d = s.find(".day"),
            l = s.find(".hour"), u = s.find(".minute"), c = s.find(".second"), f = s.find(".opentyle"),
            x = s.find(".addF1"), h = s.find(".equalF"), m = s.find(".cuttime"), p = (new Date(o) - new Date(t)) / 1e3,
            g = new Date;
        clearInterval(i), i = setInterval(function () {
            var e = Math.abs(new Date - g) / 1e3;
            if (g = new Date, (e = e.toString().split("."))[0] > 1 && (p -= e[0]), p > 1) {
                p -= 1;
                var t = parseInt(p / 3600 / 24), o = Math.floor(p / 3600 - 24 * t), v = Math.floor(p / 60 % 60),
                    y = Math.floor(p % 60);
                $(d).text(t < 10 ? "0" + t : t), $(l).text(o < 10 ? "0" + o : o), $(u).text(v < 10 ? "0" + v : v), $(c).text(y < 10 ? "0" + y : y), t <= 0 ? (s.find(".daytxt").hide(), s.find(".day").hide()) : (s.find(".daytxt").show(), s.find(".day").show()), o <= 0 ? (s.find(".hourtxt").hide(), s.find(".hour").hide()) : (s.find(".hourtxt").show(), s.find(".hour").show())
            } else {
                $(x).hide(), $(h).hide(), $(f).show(), $(m).hide(), clearInterval(i);
                var j = s.find(".nextIssue").text(), w = r.isLotterySeries(a),
                    b = {url: n, issue: j, lotCode: a, LotSeries: w};
                r.ajaxLotteryInfo(b)
            }
        }, 1e3, n)
    },
    smallSixInfoCountDown: function (e, t, a, n) {
        var i = e.replace(/-/g, "/"), t = t.replace(/-/g, "/"), o = $("#cz_" + a), s = this, r = o.find(".day"),
            d = o.find(".hour"), l = o.find(".minute"), u = o.find(".second"), c = o.find(".opentyle"),
            f = o.find(".addF1"), x = o.find(".equalF"), h = o.find(".cuttime"), m = (new Date(i) - new Date(t)) / 1e3,
            p = new Date;
        clearInterval(smallSixInfoCountDownTimer), smallSixInfoCountDownTimer = setInterval(function () {
            var e = Math.abs(new Date - p) / 1e3;
            if (p = new Date, (e = e.toString().split("."))[0] > 1 && (m -= e[0]), m > 1) {
                m -= 1;
                var t = parseInt(m / 3600 / 24), i = Math.floor(m / 3600 - 24 * t), g = Math.floor(m / 60 % 60),
                    v = Math.floor(m % 60);
                $(r).text(t < 10 ? "0" + t : t), $(d).text(i < 10 ? "0" + i : i), $(l).text(g < 10 ? "0" + g : g), $(u).text(v < 10 ? "0" + v : v), t <= 0 ? (o.find(".daytxt").hide(), o.find(".day").hide()) : (o.find(".daytxt").show(), o.find(".day").show()), i <= 0 ? (o.find(".hourtxt").hide(), o.find(".hour").hide()) : (o.find(".hourtxt").show(), o.find(".hour").show())
            } else {
                $(f).hide(), $(x).hide(), $(c).show(), $(h).hide(), clearInterval(smallSixInfoCountDownTimer);
                var y = o.find(".nextIssue").text(), j = s.isLotterySeries(a),
                    w = {url: n, issue: y, lotCode: a, LotSeries: j};
                s.ajaxLotteryInfo(w)
            }
        }, 1e3)
    },
    initConfigPage: function (e) {
        var t = $("#" + e), a = t.text();
        t.addClass("check");
        var n = '<div class="box check" draggable="true" id="box_' + e + '" ><a id="a' + e + '" href="javascript:void(0)">' + a + "</a></div>";
        $(".choiceContent .forbidden").eq(0).replaceWith(n)
    },
    upDataUserPerference: function () {
        var e = [], t = this.loginInfo;
        $("#drag-wrap .check").each(function (t, a) {
            e.push(a.id.split("_")[1])
        }), $.ajax({
            type: "post",
            url: publicUrl + "user/updateUserPreferences.do",
            headers: {token: t},
            dataType: "json",
            data: {userPreferences: e.join(",")},
            success: function (t) {
                t.result && 0 === t.result.businessCode ? "success" === t.result.data.status && (MyFavObj.defaultData = e, $("#myFavConfig").hide(), $("#myFav").show("slow"), MyFavObj.loadLotteryInfo()) : alert("保存偏好彩种失败，请重试！")
            },
            error: function (e) {
            }
        })
    }
};
MyFavObj.initMyFav();