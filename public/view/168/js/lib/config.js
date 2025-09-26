function filterRemoveLotteryList(t, e) {
    var i = ["title", "url", "lotCode"];
    return result = t.filter(function (t) {
        return !e.some(function (e) {
            return t.code === e.code
        })
    }).map(function (t) {
        return i.reduce(function (e, i) {
            return e[i] = t[i], e
        }, {})
    })
}

function getDateStr(t) {
    var e = new Date;
    e.setDate(e.getDate() + t);
    var i = e.getFullYear(), n = e.getMonth() + 1;
    n = n < 10 ? "0" + n : n;
    var o = e.getDate();
    return o = o < 10 ? "0" + o : o, i + "-" + n + "-" + o
}

function checkseletime(t) {
    var e = t[0] + "-" + 1 * t[1] + "-" + 1 * t[2];
    e == getDateStr(0) ? $("#today").addClass("checked").siblings().removeClass("checked") : e == getDateStr(-1) ? $("#yesterday").addClass("checked").siblings().removeClass("checked") : e == getDateStr(-2) ? $("#qianday").addClass("checked").siblings().removeClass("checked") : $(".listheadrl .checked").removeClass("checked")
}

function SetHome(t) {
    document.all ? (document.body.style.behavior = "url(#default#homepage)", document.body.setHomePage(t)) : alert("您好,您的浏览器不支持自动设置页面为首页功能,请您手动在浏览器里设置该页面为首页!")
}

function addFavorite2() {
    var t = window.location, e = document.title, i = navigator.userAgent.toLowerCase();
    if (i.indexOf("360se") > -1) alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！"); else if (i.indexOf("msie 8") > -1) window.external.AddToFavoritesBar(t, e); else if (document.all) try {
        window.external.addFavorite(t, e)
    } catch (t) {
        alert("您的浏览器不支持,请按 Ctrl+D 手动收藏!")
    } else window.sidebar ? window.sidebar.addPanel(e, t, "") : alert("您的浏览器不支持,请按 Ctrl+D 手动收藏!")
}

function defaultIMG(t) {
    $(t).attr("src", "/img/banner/default.gif")
}

function popup(t) {
    return;
    var e = "homepagePopUpbanner", i = sessionStorage.getItem(e), n = window.location.href;
    if (1 != config.cny || null !== i || -1 != n.indexOf("view/") || $("div").is("#popup")) {
        if (0 == config.cny && !$("div").is("#popup") && -1 == n.indexOf("lotCode") && -1 == n.indexOf("view/zsh/expert_pk10.html?lottype=sgAirship") && -1 == n.indexOf("view/zhuiShaHao/businessGuessing.html?lottype=guess") && -1 == n.indexOf("pop_pu")) {
            o = "<div id='popup'><div class='pupbox' id='pupbox'><button id='pupbtn'></button><img src='/img/" + (!0 === JSON.parse(sessionStorage.getItem("isDomainNoAdv")) ? "promo-app-web-banner-no-ads-02122021" : "promo-app-web-banner-ads-02122021") + ".png'/></div></div>";
            $("body").append(o), $("html,body").css({overflow: "hidden"})
        }
    } else {
        var o = "<div id='popup' style='display: flex; justify-content: center;align-items: center;'><div class='' id='pupbox' style='position:relative'><button id='pupbtn' style='width:50px;height:50px;right:0;position:absolute;opacity:0' ></button><img src=" + (imgUrl + t.image) + "></div></div>";
        $("body").append(o), $("html,body").css({overflow: "hidden"})
    }
    $("#pupbtn").on("click", function (t) {
        t.stopPropagation();
        var i = $(t.target);
        if ("pupbtn" == i.attr("id") || void 0 == i.attr("id")) {
            void 0 == i.attr("id") && config.cny, $("#popup").hide(), $("html,body").css({overflow: "visible"});
            var n = config.formatDate();
            sessionStorage.setItem(e, 1), localStorage.setItem("pupday", n)
        }
    })
}

function pupout(t,p) {
    var e = localStorage.getItem("pupday"),
        i = (config.formatDate(), window.location.origin.split("//")[1].split(":")[0].replace("www.", "")),
        n = "isDomainNoAdv";
    void 0 == t || "" == t || -1 != t.indexOf(i) ?
    ($("#popup").find("img").attr("src", "/img/imginfo-pc-noadv.png"),
    $(".new_mobiledetail").find("img").attr("src", "/img/Revision_img/168phone2-noadv.png"),
    $(".fix1200").find(".wxewmicon").attr("style", "background: url(/img/icon/168phone2-noadv.png) 0px 0px no-repeat;"),
    $(".kair_right").html("<img src='../../img/jusc.jpg'/>"), $(".fix1200").find(".backold").attr("href", p.dhurl),
    $(".6hch").attr("href", p.lhcurl), $(".zzwzdh").attr("href", p.dhurl), $(".libusschecked").hide(),
    sessionStorage.setItem(n, !0)) : sessionStorage.setItem(n, !1), $.ajax({
        type: "get",
        url: config.publicUrl + "focusPicture/findPopUpPictureByType.do",
        async: !0,
        data: {type: 2, platform: "168"},
        success: function (t) {
            var i = "";
            "string" == typeof t && (t = JSON.parse(t));
            var n = (i = t.result.data).startDate, o = i.endDate, s = new Date(n), a = new Date(o), d = new Date;
            if ("" === i || 0 === i.length ? config.cny = 0 : 0 == n.length && 0 == o.length ? config.cny = 1 : 0 != n.length && 0 == o.length ? d >= s && (config.cny = 1) : 0 == n.length && 0 != o.length ? d <= a && (config.cny = 1) : 0 != n.length && 0 != o.length && d < a && (config.cny = 1), 1 === config.cny) popup(i); else if (e) {
                var r = Date.parse(c), l = new Date(e), c = l.getTime();
                r > c + 864e5 * (7 - l.getDay()) && popup(i)
            } else popup(i)
        }
    })
}

function pupajax() {
    $.ajax({
        type: "get",
        url: config.publicUrl + "parameters/getNoAdvertisingDomain.do",
        async: !0,
        data: "",
        success: function (t) {
            "string" == typeof t && (t = JSON.parse(t)),
             mconfig = t.result.data.mconfig,
             hideList = t.result.data.domainList, pupout(hideList,mconfig)
        },
        error: function () {
            console.log("域名请求出错了")
        }
    })
}

function queryPublicQQ() {
    $.ajax({
        url: config.publicUrl + "parameters/getQQnumbers.do", success: function (t) {
            var e = t.result;
            0 === t.errorCode && e && 0 === e.businessCode && e.data.QQList && (config.PubQQNum = e.data.QQList, setPubQQNum(e.data.QQList))
        }, error: function (t) {
            console.log(t)
        }
    })
}

function setPubQQNum(t) {
    t.forEach(function (t) {
        "GuessQQnumbers" === t.type ? $("." + t.type).val(t.numbers[0]).text(t.numbers[0]) : $("." + t.type).text(t.numbers[0])
    })
}

function currentDay(t) {
    var e = t.split("-");
    return parseInt(e[1]) + "/" + (t = parseInt(e[2]))
}

function getDate() {
    var t = new Date;
    return t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate() + " " + t.getHours() + ":" + t.getMinutes() + ":" + t.getSeconds()
}

function ifNumIsNull(t, e) {
    return "" == t ? (0 != $(e).find(".errorbox").length && $(e).find(".errorbox").remove(), $(e).find(".rowbox2").append("<span class='errorbox' style='font-size:11px;color:orangered;'>开奖号码未开出，请尝试刷新页面或稍后再试！</span>"), $(e).find(".kajianhao").hide(), !0) : ($(e).find(".errorbox").hide(), $(e).find(".kajianhao").show(), !1)
}

function clickSelected(t) {
    var e = [], i = [];
    if ($("#daxiaodsfb").find("li").each(function () {
        $(this).hasClass("selected") && e.push($(this).attr("id"))
    }), $("#chakanchfb").find("li").each(function () {
        $(this).hasClass("selected") && i.push($(this).attr("class"))
    }), i.length > 0) $("#jrsmhmtj " + t + " li").addClass("selectedOpacity"), $(i).each(function () {
        var e = this.split(" ")[0];
        ".imgnumber" == t ? $("#jrsmhmtj .imgnumber li").each(function () {
            $(this).text() == e && $(this).removeClass("selectedOpacity")
        }) : ".blueqiu" == t && $("#jrsmhmtj .blueqiu li").each(function () {
            $(this).text() == e && $(this).removeClass("selectedOpacity")
        })
    }); else if (e.length > 0) {
        var n = $("#chakanchfb").find("li").hasClass("selected");
        $(e).each(function () {
            "danum" == this ? ($("#duizinum").removeClass("selected"), ifArrHas(2), excuteDx(2, n, t)) : "xiaonum" == this ? ($("#duizinum").removeClass("selected"), ifArrHas(2), excuteDx(2, n, t)) : "dannum" == this ? ($("#duizinum").removeClass("selected"), ifArrHas(1), excuteDx(2, n, t)) : "shuangnum" == this ? ($("#duizinum").removeClass("selected"), ifArrHas(1), excuteDx(2, n, t)) : "duizinum" == this && shodouble(n, t)
        })
    }
}

function shodouble(t, e) {
    $("#jrsmhmtj").find(e).children(), $("#jrsmhmtj>table>tbody").children();
    if ($("#daxiaodsfb").find("li").removeClass("selected"), t) return $("#duizinum").removeClass("selected"), void $("#jrsmhmtj " + e + " li").removeClass("selectedOpacity");
    $("#duizinum").addClass("selected"), $("#jrsmhmtj " + e + " li").addClass("selectedOpacity");
    var i = [], n = $("#jrsmhmtj tr"), o = n.length;
    if (!(o <= 1)) {
        for (var s = $(n[0]).find("li"), a = 0; a < 10; a++) i.push($(s[a]).text());
        for (a = 1; a < o; a++) for (var d = $(n[a]).find("li"), r = 0; r < 10; r++) {
            var l = $(d[r]).text();
            l == i[r] && ($(d[r]).removeClass("selectedOpacity"), $($(n[a - 1]).find("li")[r]).removeClass("selectedOpacity")), i[r] = l
        }
    }
}

function excuteDx(t, e, i) {
    $("#jrsmhmtj").find(i).children();
    var n = $("#dannum").hasClass("selected"), o = $("#shuangnum").hasClass("selected"),
        s = $("#danum").hasClass("selected"), a = $("#xiaonum").hasClass("selected");
    $("#jrsmhmtj " + i + " li").each(function () {
        var i = $(this).text(), d = i % 2 == 0, r = i >= 6;
        "1" == t ? e ? s ? r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a && r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? r && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a ? r || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "2" == t ? e ? s ? r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a && r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : s ? r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : a ? !r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "3" == t ? e ? n ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : o ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : n ? r && !d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : r ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "4" == t && (e ? n ? d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : o ? d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : n ? r || d ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : o ? !r && d ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : r ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
    }), $("#jrsmhmtj " + i + " li").each(function (t) {
        $(this).text() == tabarr[t] && $(this).removeClass("selectedOpacity")
    })
}

function ifArrHas(t) {
    if (ifarrDxDs.length <= 0) ifarrDxDs.push(t); else {
        for (var e = 0, i = ifarrDxDs.length; e < i; e++) if (ifarrDxDs[e] == t) return;
        ifarrDxDs.push(t)
    }
}

function getLotteryResults() {
    setTimeout(function () {
        var t = {lotCode: lotCode, pageNo: pageNum, pageSize: pagesize}, e = sessionStorage.getItem("tokens");
        listpook = !0, console.log("111111111111111111"), tools.ajax(e, "guessingCompetition/myGuessHead.do", "", !1, tools.myjcHtml, "#my_guessing", "GET"), tools.ajax(e, "guessingCompetition/myGuessList.do", t, !1, tools.myjcHtml1, "#table_mssgea", "GET")
    }, 5e3)
}

function setTextColor(t) {
    listColor = "#" + t, $("#jrsmhmtj table tr:odd").find("td").css("background", listColor)
}

function dialogAjax() {
    var t = function (t) {
        var e = "<div id='popup'><div class='pupbox'><button id='pupbtn'></button><a href='" + t.url + "' target='" + t.openWith + "'><img src='" + config.imgUrl + t.imgName + "'/></div></div>";
        $("body").append(e), $("html,body").css({overflow: "hidden"}), setTimeout(function () {
            $("#popup").hide(), $("html,body").css({overflow: "visible"})
        }, 5e3), $("#popup").on("click", function (t) {
            t.stopPropagation();
            var e = $(t.target);
            "popup" != e.attr("id") && "pupbtn" != e.attr("id") || ($("#popup").hide(), $("html,body").css({overflow: "visible"}))
        })
    };
    $.ajax({
        type: "get",
        url: config.publicUrl + "advertis/getWindowsAdvertis.do",
        async: !0,
        data: {
            type: 0,
            source: window.location.hostname
        },
        success: function (e) {
            "string" == typeof e && (e = JSON.parse(e)), "1" == e.result.data.display && "index" == $("#ifindex").val() && t(e.result.data)
        },
        error: function () {
            console.log("域名请求出错了")
        },
        complete: function () {
            console.log("请求结束~")
        }
    })
}

var env = "productionEnv", config = {
    publicUrl: "http://kjwapi.xypv1.com/api/",
    videourl:"http://kjwpc.xypv1.com/",
    url6: "",
    urljisu6: "",
    loginUrl: "",
    imgUrl: "",
    listTime: 1e4,
    msit: "",
    firstLoad: !1,
    ifdebug: !1,
    ifScalse: .782,
    newRows: 7,
    Uname: ["冷雨夜", "木木三", "醉书生", "司令爷", "沐子眠"],
    SscUname: ["忆离笙", "值半钱", "楼满风", "沐雪柔", "寒千落"],
    PubQQNum: [{type: "DownLoadQQnumbers", numbers: [8141884]}, {
        type: "RightQQnumbers",
        numbers: [123456]
    }, {type: "GuessQQnumbers", numbers: [6540763]}],
    cny: 0
};
"stagingEnv" == env && (config.publicUrl = "http://staging-api2-168-al2.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/", config.url6 = "http://staging-x6-api-al2.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/", config.urljisu6 = "http://staging-api2-168-al2.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/"), 2 === performance.navigation.type && location.reload();
var jsCode = {code: [10037, 10035, 10036, 10052, 10053, 10054, 10055, 10084], count: 200}, LOTTERY_CATEGORY = {
    aozxy5: {title: "澳洲幸运5", lotCode: "10010", category: "ssc"},
    uklotto5: {title: "英国乐透5", lotCode: "10077", category: "ssc"},
    uklotto10: {title: "英国乐透10", lotCode: "10079", category: "pk10"},
    aozxy10: {title: "澳洲幸运10", lotCode: "10012", category: "pk10"},
    sgssc: {title: "SG时时彩", lotCode: "10075", category: "ssc"},
    sgk3: {title: "SG快3", lotCode: "10076", category: "kuai3"}
}, LOTTERY_LOTCODE = {
    10079: {title: "英国乐透10", lotCodeType: "uklotto10", category: "pk10"},
    10057: {title: "幸运飞艇", lotCodeType: "xingyft", category: "pk10"},
    10037: {title: "极速赛车", lotCodeType: "jisusc", category: "pk10"},
    10035: {title: "极速飞艇", lotCodeType: "jisuft", category: "pk10"},
    10012: {title: "澳洲幸运10", lotCodeType: "aozxy10", category: "pk10"}
}, lotCode = {
    jisusc: 10037,
    jisussc: 10036,
    jisuft: 10035,
    jisuklsf: 10053,
    jisuef: 10055,
    jisuksan: 10052,
    jisukl8: 10054,
    pk10: 10001,
    aozxy10: 10012,
    uklotto10: 10079,
    cqssc: 10002,
    cqqxc: 10050,
    tjssc: 10003,
    happyCZ: 10060,
    xjssc: 10004,
    aozxy5: 10010,
    uklotto5: 10077,
    gdklsf: 10005,
    aozxy8: 10011,
    tjklsf: 10034,
    cqxync: 10009,
    gxklsf: 10038,
    uklotto8: 10078,
    gdsyxw: 10006,
    jxef: 10015,
    jsef: 10016,
    ahef: 10017,
    shef: 10018,
    lnef: 10019,
    hbef: 10020,
    cqef: 10021,
    gxef: 10022,
    jlef: 10023,
    nmgef: 10024,
    zjef: 10025,
    sdsyydj: 10008,
    jsksan: 10007,
    gxft: 10026,
    jlft: 10027,
    hebft: 10028,
    nmgft: 10029,
    ahft: 10030,
    hubft: 10032,
    bjft: 10033,
    shft: 10061,
    gzft: 10062,
    gsft: 10063,
    aozxy20: 10013,
    bjkl8: 10014,
    twbg: 10047,
    uklotto20: 10080,
    fcssq: 10039,
    cjdlt: 10040,
    fcsd: 10041,
    fcqlc: 10042,
    pailie3: 10043,
    pailie5: 10044,
    qxc: 10045,
    egxy28_old: 10046,
    egxy: 10046,
    xingyft: 10057,
    sgAirship: 10058,
    tencentffc: 10056,
    xyssc: 10059,
    tw_5fencai: 10064,
    tw_dlt: 10070,
    tw_wlc: 10071,
    tw_jc539: 10072,
    kl8: 10073,
    egxy28: 10074,
    sgssc: 10075,
    sgk3: 10076,
    speedPcEgg: 10081,
    sgHappy8: 10082,
    sgHappy10: 10083,
    sg11x5: 10084,
    bgsc:20031,
    bgssc:20032,
    bg11x5:20033,
    bgklsf:20034,
    bgk3:20035,
    bgkl8:20036,
    xglhc:10048,
    amlhc:20049,
    jslhc:10051
}, proto = {
    issuc: "2017019",
    Zoo: ["", "鼠", "牛", "虎", "兔", "龙", "蛇", "马", "羊", "猴", "鸡", "狗", "猪"],
    fiveLineArr: ["", "金", "木", "水", "火", "土"],
    colorArr: ["", "#F8253E", "#1FC26B", "#0093E8"],
    colorEng: ["", "red", "green", "blue"],
    colorCh: ["", "红", "蓝", "绿"],
    jiaqzs: ["", "家", "野"],
    jiaqzs_text: ["", "家禽", "野兽"],
    boy_girl: ["", "男", "女"],
    top_bottom: ["", "天", "地"],
    four_season: ["", "春", "夏", "秋", "冬"],
    cqsh: ["", "琴", "棋", "书", "画"]
}, lotteryList = {};
lotteryList.SGK3 = [{title: "SG时时彩", url: "/view/shishicai_sg/ssc_index.html", lotCode: "10075"}, {
    title: "SG快3",
    url: "www.vvere",
    lotCode: "10076"
}, {title: "SG飞艇", url: "www.vvere", lotCode: "10058"}, {
    title: "幸运时时彩",
    url: "www.vvere",
    lotCode: "10059"
}, {title: "幸运飞艇", url: "www.vvere", lotCode: "10057"}, {
    title: "台湾5分彩",
    url: "www.vvere",
    lotCode: "10064"
}], lotteryList["11chosen5"] = [{title: "11asd", url: "www.vvere", lotCode: "10075"}, {
    title: "12asd",
    url: "www.vvere",
    lotCode: "10076"
}];
var lotteryRemoveList = [{title: "sfd", code: "10074"}, {title: "sfd", code: "10076"}];
if ($(function () {
    "168kjw" != window.name ? window.name = "168kjw" : window.name = ""
}), !config.ifdebug) {
    var oldLog = console.log;
    console.log = function () {
        config.ifdebug && oldLog.apply(console, arguments)
    }
}
config.formatDate = function (t) {
    t || (t = new Date);
    var e = t.getFullYear(), i = t.getMonth() + 1;
    i = i < 10 ? "0" + i : i;
    var n = t.getDate();
    return n = n < 10 ? "0" + n : n, e + "-" + i + "-" + n
}, $(function () {
    function t(t, e) {
        t ? ($("#ifSoundOpen").find(".ifSoundIcon").removeClass("stopsound"), $("#ifSoundOpen").find("i").text("关闭声音"), e && (localStorage.ifopenSoundsBtn = !1), $(".soundbtn").css("background", "#ff7b00"), $("#soundSet").find(".soundbtn").removeClass("disabled"), $("#soundKindsIcon").removeClass().addClass("soundDefY"), console.log("ifopenSoundsBtn   " + t)) : ($("#ifSoundOpen").find(".ifSoundIcon").addClass("stopsound"), $("#ifSoundOpen").find("i").text("打开声音"), e && (localStorage.ifopenSoundsBtn = !0), $("#soundSet").find(".soundbtn").addClass("disabled"), $(".soundbtn").css("background", "#ccc"), $("#soundSet").find(".soundpanel").hide("200"), $("#soundKindsIcon").removeClass().addClass("soundDef"), console.log("ifopenSoundsBtn   " + t))
    }

    if (pupajax(), tools.hideCQSSC(), queryPublicQQ(), $("#littleimg").length >= 1 && "index" != $("#ifindex").val() && ( $("#littleimg").find(".swiper-container").addClass("swiperother")), publicmethod.fixBox(), $(".fixedgoBack .fix1200").on("click", function (t) {
        if ("customerService" == t.target.className) {
            var e = $(".customerService").toggleClass("butService");
            -1 != $(e).attr("class").indexOf("butService") ? $(".kfService").show() : $(".kfService").hide()
        } else $(".customerService").removeClass("butService"), $(".kfService").hide()
    }), $(".kfService button").on("click", function () {
        window.open("https://vue.livelyhelp.chat/chatWindow.aspx?siteId=60002182&planId=37df1c47-950e-4063-800f-1408bbf66c6a", "winName", "top=150,left=100,width=400,height=600")
    }), $(".wxkefuicon").on("mouseover", function () {
        $(".wxewmicon").css("display", "inline-block")
    }), $(".wxkefuicon").on("mouseout", function () {
        $(".wxewmicon").css("display", "none")
    }), $(".wxkekufu").on("mouseover", function () {
        $(".wechatImg").css("display", "inline-block")
    }), $(".wxkekufu").on("mouseout", function () {
        $(".wechatImg").css("display", "none")
    }), $("#localyears").text((new Date).getFullYear()), $(".fankuicon").live("click", function () {
        if ("" != localStorage.current_time && void 0 != localStorage.current_time) {
            var t = localStorage.current_time, e = getDate(), i = t.replace("-", "/"), n = e.replace("-", "/");
            i = new Date(i.replace("-", "/")).getTime(), ((n = new Date(n.replace("-", "/")).getTime()) - i) / 1e3 / 60 <= 10 ? ($("#info1").hide(), $("#info2").hide(), $("#info3").show()) : ($("#btn_submit").show(), $("#info3").hide(), $("#info2").hide(), $("#info1").show())
        } else $("#btn_submit").show(), $("#info3").hide(), $("#info2").hide(), $("#info1").show()
    }), $("#btn_submit").live("click", function () {
        var t = $("#nickName").val().trim(), e = $("#linkType").val(), i = parseInt(e),
            n = $("#linkNumber").val().trim(), o = $("#advice").val().trim();
        if ("" === o) return alert("请填写意见后，再进行提交。"), !1;
        var s = {nickName: t, linkNumber: n, fedBack: o};
        for (var a in s) s[a] = tools._PUBMETHOD.HtmlUtil.filterKeyword(s[a]), s[a] = tools._PUBMETHOD.HtmlUtil.htmlEncode(s[a]);
        s.linkType = i, yonghufankui.listData(s)
    }), "index" == $("#ifindex").val() || $("#user_adv").load("/view/public/user_adv.html", function () {
    }), $("#ifSoundOpen").on("click", ".ifSoundOpen", function (e) {
        t("false" != localStorage.ifopenSoundsBtn, !0), e.stopPropagation()
    }), $("#soundSet").on("click", ".soundbtn:not('.disabled')", function (t) {
        $(this).find(".soundpanel").show("200"), t.stopPropagation()
    }), $(".bodybox").on("click", function (t) {
        $(this).parent().parent().find(".soundpanel").hide("200")
    }), $("#soundSet").on("click", ".close", function (t) {
        $(this).parent().parent().find(".soundpanel").hide("200");
        var e = $("#soundSet").find("input:[checked='checked']").val();
        "RING_01" == e ? $("#soundKindsIcon").removeClass().addClass("soundDefY") : "RING_02" == e ? $("#soundKindsIcon").removeClass().addClass("sound2Y") : "RING_03" == e ? $("#soundKindsIcon").removeClass().addClass("sound3Y") : "RING_04" == e ? $("#soundKindsIcon").removeClass().addClass("sound4Y") : "RING_05" == e && $("#soundKindsIcon").removeClass().addClass("sound5Y"), t.stopPropagation()
    }), $("#soundSet").on("click", "input", function () {
        void 0 != $(this).val() && ("RING_01" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("soundDefY") : "RING_02" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound2Y") : "RING_03" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound3Y") : "RING_04" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound4Y") : "RING_05" == $(this).val() && $("#soundKindsIcon").removeClass().addClass("sound5Y"), $("#soundSet").find("audio").attr("src", "../../media/" + $(this).val() + ".wav"))
    }), "operator" == $("#operator").val() && $(window).on("scroll", function () {
        $(this).scrollTop() > 195 ? $(".haomabox").addClass("fixedHead") : $(".haomabox").removeClass("fixedHead")
    }), setTimeout(function () {
        try {
            tools.addSund(), console.log("localStorage.ifopenSoundsBtn start:" + localStorage.ifopenSoundsBtn), void 0 == localStorage.ifopenSoundsBtn ? localStorage.ifopenSoundsBtn = !1 : t("false" == localStorage.ifopenSoundsBtn, !1), console.log("localStorage.ifopenSoundsBtn end:" + localStorage.ifopenSoundsBtn)
        } catch (t) {
        }
    }, 1e3), "noLoad" == $("#ofNoLoad").val()) ; else try {
        loadotherData()
    } catch (t) {
    }
    setTimeout(function () {
        config.firstLoad = !0
    }, 2e3), tools.initListen(), $("#showRule img").on("click", function () {
        $("#rulebox").css("z-index", "200"), $(".ruleContent").animate({width: "735px", "margin-right": "-440px"}, 200)
    }), $("#rulebox .closeRule").on("click", function () {
        $(".ruleContent").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#rulebox").css("z-index", "-1")
        })
    }), dialogAjax()
});
var publicUrl = config.publicUrl, yonghufankui = {}, publicmethod = {}, tools = {};
tools._PUBMETHOD = {}, tools._PUBMETHOD.HtmlUtil = {
    htmlEncode: function (t) {
        var e = document.createElement("div");
        void 0 != e.textContent ? e.textContent = t : e.innerText = t;
        var i = e.innerHTML;
        return e = null, i
    }, htmlDecode: function (t) {
        var e = document.createElement("div");
        e.innerHTML = t;
        var i = e.innerText || e.textContent;
        return e = null, i
    }, filterKeyword: function (t) {
        return t = "string" == typeof t ? t.toLocaleLowerCase() : "", allowSchemes = ["https", "http", "javascript", "script", "href", "src", "eval", "alert"], t.length > 0 && allowSchemes.forEach(function (e) {
            var i = new RegExp(e, "g");
            t = t.replace(i, "")
        }), t
    }
}, tools.ifFirstLoad = function () {
    return !!config.firstLoad
}, tools.hideCQ = function () {
    $(".haomaqur_l").css("margin-left", "0"), $(".haomaqur_l").html("<span style='text-align:center;width:100%;color: #ff0b0b;display:inline-block;font-size:20px;height:142px;line-height:142px'>停止销售</span>")
}, tools.hideCQSSC = function () {
    var t = new Date("2019-03-29 23:52:00").getTime(), e = (new Date).getTime();
    t - e <= 0 && "cqssc" == $("#leftL_cqssc").find(".acNameColor").attr("id") && "sscStyle" == $("#bgColor").attr("class") ? ($("#detailMess").find(".cutimeBox .stopbox").show(), $("#detailMess").find(".cutimeBox .timebox").hide()) : ($("#detailMess").find(".cutimeBox .stopbox").hide(), $("#detailMess").find(".cutimeBox .timebox").show()), t - e <= 0 && ($("#cqSsc_hot,#cqSsc").find(".nextkai_time").html("<span style='text-align:right;width:100%;color: #ff0b0b;display:inline-block;font-size:20px;height:48px;line-height:48px'>停止销售</span>"), $("#cz_10002,#cz_10050").find(".kjsj").html("<span style='text-align:left;width:100%;color: #ff0b0b;display:inline-block;font-size:20px;height:48px;line-height:48px'>停止销售</span>")), "10002" != lotCode && "10050" != lotCode || t - e <= 0 && ($("body").before('<div class="dialogbox"><div class="dialog"><span id="close" onclick="javascript:$(this).parent().parent().hide()">关闭</span><h1>公告</h1><p>根据重庆市福利彩票发行中心安排，重庆时时彩于2019年3月30日零点起停止销售。</p><p>本站推荐用户查看幸运时时彩，该彩种也是国内彩民喜欢的快开彩，公平公正公开，开奖时间稳定。</p></div></div>'), $(".haomaqur_l").css("margin-left", "0"), $(".haomaqur_l").html("<span style='text-align:center;width:100%;color: #ff0b0b;display:inline-block;font-size:20px;height:142px;line-height:142px'>停止销售</span>"))
}, tools.stopLottery = function (t, e, i) {
    animateMethod[i](t.preDrawCode, e), clearInterval(animateID[e]), delete animateID[e];
    var n = "<div class='status-wrapper' style='margin-right:10px'><span class='label-warning'>停止销售</span></div>";
    $(e).find(".nextkai_time").css({"margin-top": "24px"}), $(e).find(".kjsj").html(n), $(e).find(".nextkai_time").html(n)
}, tools.loadloginR = function (t, e) {
    var i = window.location.hostname, n = window.location.host.split(".");
    if (void 0 != n[3]) {
        var o = n[0] + "." + n[1];
        -1 != i.indexOf(o) && window.location.href.split(":")[2] && (i += ":" + window.location.href.split(":")[2].split("/")[0])
    }
    var s = config.loginUrl + "login?callbackUrl=http://" + i + "?succeed",
        a = config.loginUrl + "register?callbackUrl=http://" + i;
    $("." + t).attr("href", s), $("." + e).attr("href", a)
}, tools.undefindeInitZero = function () {
    $("#shuanmiandata>td:contains('undefined')").text(0), $("#gylhcs>td:contains('undefined')").text(0)
}, tools.getParameterByName = function (t, e) {
    e || (e = window.location.href), t = t.replace(/[\[\]]/g, "\\$&");
    var i = new RegExp("[?&]" + t + "(=([^&#]*)|&|#|$)").exec(e);
    return i ? i[2] ? decodeURIComponent(i[2].replace(/\+/g, " ")) : "" : null
}, yonghufankui.listData = function (t) {
    t.source = window.location.href, $.ajax({
        url: publicUrl + "fedBack/saveFedBack.do",
        type: "GET",
        data: t,
        success: function (t) {
            $("#btn_submit").hide(), $("#btn_submiting").show(), yonghufankui.createList(t)
        },
        error: function (t) {
            console.log("data error")
        }
    })
}, yonghufankui.createList = function (t) {
    if ($("#btn_submiting").hide(), "0" == t.errorCode) {
        var e = getDate();
        localStorage.current_time = e, $("#info1").hide(), $("#info2").show()
    }
}, tools.addSund = function () {
    $("#ifSoundOpen,#soundSet").empty(), $("#ifSoundOpen").append('<div class="ifSoundOpen"><i>关闭声音</i><div class="ifSoundIcon"></div></div>'), $("#soundSet").append('<div class="soundbtn"><i>铃声设置</i><div class="soundicon soundDefY" id="soundKindsIcon">   <audio src="../../media/RING_01.wav"  controls="controls" id="audioid">       Your browser does not support the audio tag.   </audio></div><div class="soundpanel">   <div class="close"></div>   <div class="soundlist">       <ul>           <li><label><input type="radio" name="sound" value="RING_01"  checked="checked">&nbsp;默认(闹钟铃)</label></li>           <li><label><input type="radio" name="sound" value="RING_02">&nbsp;声音二(上课铃)</label></li>           <li><label><input type="radio" name="sound" value="RING_03">&nbsp;声音三(打锣声)</label></li>           <li><label><input type="radio" name="sound" value="RING_04">&nbsp;声音四(打鼓声)</label></li>           <li><label><input type="radio" name="sound" value="RING_05">&nbsp;声音五(点滴声)</label></li>           <li>               提示时间：               <select>                   <option value="5"  selected="selected">开奖前5秒</option>                   <option value="20">开奖前20秒</option>                   <option value="10">开奖前10秒</option>                   <option value="30">开奖前30秒</option>                   <option value="40">开奖前40秒</option>                   <option value="50">开奖前50秒</option>                   <option value="60">开奖前60秒</option>                   <option value="begin">开奖后</option>               </select>           </li>       </ul>   </div></div></div>')
}, publicmethod.fixBox = function () {
    var t = $(".fixedgoBack").find(".fix1200"), e = $(".fixedgoBack").find(".leftright");
    $(t).empty(), $(e).empty();
    $(t).append('<div class = "wxewmicon"></div><div class = "wechatImg"></div><div class="kfService"><button>在线客服</button><h3>扫码下载客服APP</h3><div class="imgService"></div></div><ul><li><a class="backold" target="_blank" href="" target="_blank"></a></li><li style="display: none"><a class="customerService" id="customerService"></a></li><li>\x3c!--用户反馈模态框--\x3e<span class="fankuicon fankuicon_a" data-toggle="modal" data-target="#myModal"><span class="fankuicons"></span></span></li><li style="display: none"><a class="wxkefuicon" target="_blank"></a></li><li><a class="topicon" id="gotop" href="javascript:"></a></li></ul>'), 0 != e.length && $(t).append('<ul class="ul_pre"><li class="prev_li"></li><li class="next_li"></li></ul>')
}, publicmethod.insertHeadPk10 = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    $(".nextIssue").text(i.drawIssue), $(".preDrawIssue").text(i.preDrawIssue);
    var n = i.preDrawCode.split(","), o = i.totalCount;
    $(".totalCount").text(o), $(".drawCount").text(i.drawCount), $(".sdrawCount").text(o - 1 * i.drawCount);
    for (var s = "", a = 0, d = $(".longhu").find("td").length; a < d; a++) switch (a) {
        case 0:
            s += "<td>" + ("0" == i.firstDT ? "龙" : "虎") + "</td>";
            break;
        case 1:
            s += "<td>" + ("0" == i.secondDT ? "龙" : "虎") + "</td>";
            break;
        case 2:
            s += "<td>" + ("0" == i.thirdDT ? "龙" : "虎") + "</td>";
            break;
        case 3:
            s += "<td>" + ("0" == i.fourthDT ? "龙" : "虎") + "</td>";
            break;
        case 4:
            s += "<td>" + ("0" == i.fifthDT ? "龙" : "虎") + "</td>"
    }
    return $(".longhu").html(""), $(".longhu").append(s), $(".sumFS").text(i.sumFS), $(".sumBigSamll").text("0" == i.sumBigSamll ? "大" : "小"), $(".sumSingleDouble").text("0" == i.sumSingleDouble ? "单" : "双"), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus), clearInterval(animateID[e]), animateMethod.pk10end(n, e), $("#waringbox").hide(300), delete animateID[e], setTimeout(function () {
        tools.ifCheckedOnToday() && (loadotherData(), setTimeout(function () {
            clickSelected(".imgnumber")
        }, 500))
    }, config.listTime), i.preDrawCode
};
var ifarrDxDs = [], tabarr = [];
publicmethod.insertHeadSsC = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    var n = i.totalCount;
    if ($(e).find(".DateTime").text(i.serverTime), $(e).find(".preDrawIssue").text(i.preDrawIssue), "10056" == i.lotCode) {
        var o = i.drawIssue.toString().slice(4), s = o.slice(0, 4) + "-", a = o.slice(4);
        $(e).find(".nextIssue>i").text(s), $(e).find(".nextIssue>b").text(a)
    } else $(e).find(".nextIssue").text(i.drawIssue);
    if (void 0 !== $("#drawTime").val()) {
        $("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $(e).find("#sumNum").val(i.sumNum), $(e).find("#sumSingleDouble").val(0 == i.sumSingleDouble ? "单" : "双"), $(e).find("#sumBigSmall").val(0 == i.sumBigSmall ? "大" : "小");
        var d = "";
        "0" == i.dragonTiger ? d = "龙" : "1" == i.dragonTiger ? d = "虎" : "2" == i.dragonTiger && (d = "和"), $(e).find("#dragonTiger").val(d)
    }
    $(e).find(".totalCount").text(n), $(e).find(".drawCount").text(i.drawCount), $(e).find(".sdrawCount").text(1 * n - 1 * i.drawCount), config.ifdebug && console.log("nextIssue:" + localStorage.nextIssue), $(".lenresinli").removeClass("checked"), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus), animateMethod.sscAnimateEnd(i.preDrawCode, e), $("#waringbox").hide(300), setTimeout(function () {
        tools.ifCheckedOnToday() && (loadotherData(), setTimeout(function () {
            clickSelected(".blueqiu")
        }, 500))
    }, config.listTime)
}, publicmethod.insertHeadHappyCZ = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    var n = i.totalCount;
    if ($(e).find(".preDrawIssue").text(i.preDrawIssue), "10056" == i.lotCode) {
        var o = i.drawIssue.toString().slice(4), s = o.slice(0, 4) + "-", a = o.slice(4);
        $(e).find(".nextIssue>i").text(s), $(e).find(".nextIssue>b").text(a)
    } else $(e).find(".nextIssue").text(i.drawIssue);
    if (void 0 !== $("#drawTime").val()) {
        $("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $(e).find("#sumNum").val(i.sumNum), $(e).find("#sumSingleDouble").val(0 == i.sumSingleDouble ? "单" : "双"), $(e).find("#sumBigSmall").val(0 == i.sumBigSmall ? "大" : "小");
        var d = "";
        "0" == i.dragonTiger ? d = "龙" : "1" == i.dragonTiger ? d = "虎" : "2" == i.dragonTiger && (d = "和"), $(e).find("#dragonTiger").val(d)
    }
    $(e).find(".totalCount").text(n), $(e).find(".drawCount").text(i.drawCount), $(e).find(".sdrawCount").text(1 * n - 1 * i.drawCount), config.ifdebug && console.log("nextIssue:" + localStorage.nextIssue), $(".lenresinli").removeClass("checked"), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus), animateMethod.happyCZAnimateEnd(i.preDrawCode, e), $("#waringbox").hide(300), setTimeout(function () {
        tools.ifCheckedOnToday() && loadotherData()
    }, config.listTime)
}, publicmethod.insertHeadlhc = function (n, t) {
    var e = tools.parseObj(n);
    if ("100002" == e.result.businessCode) throw new Error("error");
    if (e = e.result.data, tools.operatorTime("" == e.drawTime ? "0" : e.drawTime, e.serverTime) <= 0) throw new Error("error");
    $(t).find(".preDrawIssue").text(e.preDrawIssue), $(t).find(".nextIssue").text(e.drawIssue), $(t).find("#scoreTotal").text(e.sumTotal), $(t).find(".drawCount").text(e.drawCount), $(t).find(".sdrawCount").text(288 - e.drawCount);
    for (var o = e.fiveElements, i = e.chineseZodiac, s = "", a = 0; a < 7; a++) s += 6 == a ? "<li class='lastsh_xzlist'><span>" + proto.Zoo[i[a]] + "</span><span>" + proto.fiveLineArr[o[a]] + "</span> </li>" : "<li><span>" + proto.Zoo[i[a]] + "</span><span>" + proto.fiveLineArr[o[a]] + "</span> </li>";
    $(".new_sh_xzlist").html(s), $("#fastZongfen").text(e.sumTotal);
    var d = e.preDrawCode.split(","), l = [];
    $(d).each(function (n) {
        if (d[n] < 10) {
            var t = "0" + 1 * d[n];
            l.push(t)
        } else l.push(d[n])
    }), l = l.join(","), tools.countDown(e.drawTime, e.serverTime, t), animateMethod.sscAnimateEnd(l, t, e.color), $("#waringbox").hide(300), setTimeout(function () {
        if (tools.ifFirstLoad()) {
            var n = $(".xzsx>li>.checked").parent().attr("lang"), t = formatDate(new Date);
            -1 != window.location.href.indexOf("SixFast_index") && smSixTools.yearsFun(n, t)
        }
        config.firstLoad = !0
    }, 1e4)
}, publicmethod.insertHeadKlsf = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    var n = i.totalCount;
    $(e).find(".preDrawIssue").text(i.preDrawIssue), $(e).find(".nextIssue").text(i.drawIssue), $(e).find(".drawCount").text(i.drawCount), $(".totalCount").text(n), $(e).find(".sdrawCount").text(1 * n - 1 * i.drawCount), $(e).find(".sumNum").text(i.sumNum), $(e).find(".sumSingleDouble").text(0 == i.sumSingleDouble ? "单" : "双"), $(e).find(".sumBigSmall").text(0 == i.sumBigSmall ? "大" : "小"), $(e).find(".lastBigSmall").text(0 == i.lastBigSmall ? "尾大" : "尾小");
    "0" == i.dragonTiger || ("1" == i.dragonTiger || i.dragonTiger), $(e).find(".firstDragonTiger").text(0 == i.firstDragonTiger ? "龙" : "虎"), $(e).find(".secondDragonTiger").text(0 == i.secondDragonTiger ? "龙" : "虎"), $(e).find(".thirdDragonTiger").text(0 == i.thirdDragonTiger ? "龙" : "虎"), $(e).find(".fourthDragonTiger").text(0 == i.fourthDragonTiger ? "龙" : "虎"), void 0 !== $("#drawTime").val() && $("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus), animateMethod.sscAnimateEnd(i.preDrawCode, e);
    var o = i.preDrawCode.split(",");
    "#gxklsf" == e && tools.gxKaiBg(o, e), $("#waringbox").hide(300), setTimeout(function () {
        tools.ifCheckedOnToday() && (loadotherData(), setTimeout(function () {
            clickSelected(".blueqiu")
        }, 500))
    }, config.listTime)
}, publicmethod.insertHead11xw = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    var n = i.totalCount;
    $(e).find(".preDrawIssue").text(i.preDrawIssue), $(e).find(".nextIssue").text(i.drawIssue), $(e).find(".drawCount").text(i.drawCount), $(".totalCount").text(n), $(e).find(".sdrawCount").text(1 * n - 1 * i.drawCount), $(e).find(".sumNum").text(i.sumNum), $(e).find(".sumSingleDouble").text(0 == i.sumSingleDouble ? "单" : "双"), $(e).find(".sumBigSmall").text(0 == i.sumBigSmall ? "大" : "小"), $(e).find(".lastBigSmall").text(0 == i.lastBigSmall ? "尾大" : "尾小");
    "0" == i.dragonTiger || ("1" == i.dragonTiger || i.dragonTiger), void 0 !== $("#drawTime").val() && ($("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $(e).find("#sumNum").val(i.sumNum), $(e).find("#sumSingleDouble").val(typeOf("dsh", i.sumSingleDouble)), $(e).find("#sumBigSmall").val(typeOf("dxh", i.sumBigSmall))), $(e).find(".behindThree").text(typeOf("san", i.behindThree)), $(e).find(".betweenThree").text(typeOf("san", i.betweenThree)), $(e).find(".lastThree").text(typeOf("san", i.lastThree)), $(".lenresinli").removeClass("checked"), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus), animateMethod.sscAnimateEnd(i.preDrawCode, e), $("#waringbox").hide(300), setTimeout(function () {
        setTimeout(function () {
            tools.ifCheckedOnToday() && (loadotherData(), setTimeout(function () {
                clickSelected(".blueqiu")
            }, 500))
        }, 1e3)
    }, config.listTime)
}, publicmethod.insertHeadJsk3 = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    var n = i.totalCount;
    $(e).find(".preDrawIssue").text(i.preDrawIssue), $(e).find(".nextIssue").text(i.drawIssue), $(e).find(".sumNum").text(i.sumNum), $(e).find(".sumSingleDouble").text(0 == i.sumSingleDouble ? "单" : 2 == i.sumSingleDouble ? "通吃" : "双"), $(e).find(".sumBigSmall").text(0 == i.sumBigSmall ? "大" : "小"), $(e).find(".totalCount").text(n), $(e).find(".drawCount").text(i.drawCount), $(e).find(".sdrawCount").text(1 * n - 1 * i.drawCount);
    var o = "";
    "0" == i.dragonTiger ? o = "龙" : "1" == i.dragonTiger ? o = "虎" : "2" == i.dragonTiger && (o = "和"), $(e).find(".dragonTiger").text(o), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus), animateMethod.kuai3AnimateEnd(i.preDrawCode, e), $("#waringbox").hide(300), setTimeout(function () {
        tools.ifCheckedOnToday() && loadotherData()
    }, config.listTime)
}, publicmethod.insertHeadCqnc = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    var n = i.totalCount;
    $(e).find(".preDrawIssue").text(i.preDrawIssue), $(e).find(".nextIssue").text(i.drawIssue), $(e).find(".drawCount").text(i.drawCount), $(e).find(".totalCount").text(n), $(e).find(".sdrawCount").text(1 * n - 1 * i.drawCount), $(e).find(".sumNum").text(i.sumNum), $(e).find(".sumSingleDouble").text(0 == i.sumSingleDouble ? "单" : "双"), $(e).find(".sumBigSmall").text(0 == i.sumBigSmall ? "大" : "小"), $(e).find(".lastBigSmall").text(0 == i.lastBigSmall ? "尾大" : "尾小");
    "0" == i.dragonTiger || ("1" == i.dragonTiger || i.dragonTiger), $(e).find(".firstDragonTiger").text(0 == i.firstDragonTiger ? "龙" : "虎"), $(e).find(".secondDragonTiger").text(0 == i.secondDragonTiger ? "龙" : "虎"), $(e).find(".thirdDragonTiger").text(0 == i.thirdDragonTiger ? "龙" : "虎"), $(e).find(".fourthDragonTiger").text(0 == i.fourthDragonTiger ? "龙" : "虎"), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus), animateMethod.cqncAnimateEnd(i.preDrawCode, e), $("#waringbox").hide(300), setTimeout(function () {
        tools.ifCheckedOnToday() && loadotherData()
    }, config.listTime)
}, publicmethod.insertHeadBjkl8 = function (t, e) {
    var i = tools.parseObj(t);
    if ("100002" == i.result.businessCode) throw new Error("error");
    i = i.result.data;
    tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime);
    var n = i.totalCount;
    $(e).find(".preDrawIssue").text(i.preDrawIssue), $(e).find(".nextIssue").text(i.drawIssue), $(e).find(".drawCount").text(i.drawCount), $(e).find(".totalCount").text(n), $(e).find(".sdrawCount").text(1 * n - 1 * i.drawCount), $(e).find(".sumNum").text(i.sumNum), $(e).find(".sumBigSmall").text(typeOf("dxh", i.sumBigSmall)), $(e).find(".sumSingleDouble").text(typeOf("dsh", i.sumSingleDouble)), $(e).find(".singleDoubleCount").text(typeOf("dsd", i.singleDoubleCount)), $(e).find(".frontBehindCount").text(typeOf("qhh", i.frontBehindCount)), $(e).find(".sumBsSd").text(typeOf("zhzh", i.sumBsSd)), $(e).find(".sumWuXing").text(typeOf("wuxing", i.sumWuXing)), void 0 !== $("#drawTime").val() && ($("#drawTime").val(i.drawTime.substr(i.drawTime.length - 8, 8)), $(e).find("#preDrawIssue").val(i.preDrawIssue)), tools.countDown(i.drawTime, i.serverTime, e, i.lotteryStatus);
    var o = i.preDrawCode + "," + i.sumNum;
    "#egxy" == e || "#speedPcEgg" == e ? (animateMethod.sscAnimateEnd(o, e), tools.egxy28(e)) : (animateMethod.sscAnimateEnd(o, e), tools.bjkl8BagColor(o, e)), $("#waringbox").hide(300), tools.ifCheckedOnToday() && loadotherData()
}, tools.ifselectedOpacity = function (t) {
    $(t).hasClass("selectedOpacity") ? ($(t).removeClass(), $(t).addClass("selectedOpacity")) : $(t).removeClass()
}, tools.bigOrSmall = function (t, e) {
    $("#jrsmhmtj .blueqiu li").each(function (i) {
        var n = $(this).text(), o = n % 2 == 0, s = n >= e;
        if ($(this).find("i").hide(), "xshm" == t) {
            if (tools.ifselectedOpacity($(this)), "10060" == lotCode) {
                var a = 1 * $(this).find("i").text();
                a = a <= 9 ? "0" + a : a, $(this).addClass("cznum" + a)
            } else $(this).addClass("gxnumblue");
            console.log(lotCode), (i + 1) % 10 == 0 && $(this).addClass("li_after"), "10038" == lotCode ? 1 == n || 4 == n || 7 == n || 10 == n || 13 == n || 16 == n || 19 == n ? $(this).addClass("gxnumred") : 3 != n && 6 != n && 9 != n && 12 != n && 15 != n && 18 != n && 21 != n || $(this).addClass("gxnumgreen") : "10011" == lotCode || "10005" == lotCode || "10034" == lotCode || "10083" == lotCode ? n >= 19 && $(this).addClass("numredkong") : "10060" != lotCode && $(this).addClass("sscnumblue"), $(this).find("i").show()
        } else "xsdx" == t ? (tools.ifselectedOpacity($(this)), s ? (21 == n ? $(this).addClass("bluetotle") : $(this).addClass("bluebig"), (i + 1) % 10 == 0 && $(this).addClass("bluebig li_after")) : ($(this).addClass("bluesmall"), (i + 1) % 10 == 0 && $(this).addClass("bluesmall li_after"))) : "xsds" == t && (tools.ifselectedOpacity($(this)), o ? ($(this).addClass("blueeven"), (i + 1) % 10 == 0 && $(this).addClass("blueeven li_after")) : (21 == n && $(this).addClass("bluetotle"), $(this).addClass("bluesingular"), (i + 1) % 10 == 0 && $(this).addClass("bluesingular li_after")))
    })
}, tools.bigOrSmallTot = function (t, e) {
    $("#jrsmhmtj .blueqiu li").each(function (i) {
        var n = $(this).text(), o = n % 2 == 0, s = n >= e;
        $(this).find("i").hide(), "xshm" == t ? (tools.ifselectedOpacity($(this)), $(this).addClass("sscnumblue"), (i + 1) % 10 == 0 && $(this).addClass("li_after"), 19 != n && 20 != n || $(this).addClass("numred"), $(this).find("i").show()) : "xsdx" == t ? (tools.ifselectedOpacity($(this)), s ? (11 == n ? $(this).addClass("bluetotle") : n > 5 ? $(this).addClass("bluebig") : $(this).addClass("bluesmall"), (i + 1) % 10 == 0 && $(this).addClass("bluebig li_after")) : ($(this).addClass("bluesmall"), (i + 1) % 10 == 0 && $(this).addClass("bluesmall li_after"))) : "xsds" == t && (tools.ifselectedOpacity($(this)), o ? ($(this).addClass("blueeven"), (i + 1) % 10 == 0 && $(this).addClass("blueeven li_after")) : (11 == n ? $(this).addClass("bluetotle") : $(this).addClass("bluesingular"), (i + 1) % 10 == 0 && $(this).addClass("bluesingular li_after")))
    })
}, tools.parseObj = function (t) {
    var e = null;
    return "object" != typeof t ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e)), e
}, tools.bigOrSmallXync = function (t, e) {
    $("#jrsmhmtj .blueqiu li").each(function (i) {
        var n = $(this).text(), o = n % 2 == 0, s = n > e;
        "xshm" == t ? (tools.ifselectedOpacity($(this)), $(this).addClass("ncnum" + n), (i + 1) % 10 == 0 && $(this).addClass("li_after")) : "xsdx" == t ? (tools.ifselectedOpacity($(this)), s ? ($(this).addClass("bluebig"), (i + 1) % 10 == 0 && $(this).addClass("bluebig li_after")) : ($(this).addClass("bluesmall"), (i + 1) % 10 == 0 && $(this).addClass("bluesmall li_after"))) : "xsds" == t && (tools.ifselectedOpacity($(this)), o ? ($(this).addClass("blueeven"), (i + 1) % 10 == 0 && $(this).addClass("blueeven li_after")) : ($(this).addClass("bluesingular"), (i + 1) % 10 == 0 && $(this).addClass("bluesingular li_after")))
    })
}, tools.bigOrSmallHappyCZ = function (t, e) {
    $("#jrsmhmtj .blueqiu li").each(function (i) {
        var n = $(this).text(), o = n % 2 == 0, s = n > e;
        "xshm" == t ? (tools.ifselectedOpacity($(this)), $(this).addClass("cznum0" + n), (i + 1) % 10 == 0 && $(this).addClass("li_after")) : "xsdx" == t ? (tools.ifselectedOpacity($(this)), s ? ($(this).addClass("bluebig"), (i + 1) % 10 == 0 && $(this).addClass("bluebig li_after")) : ($(this).addClass("bluesmall"), (i + 1) % 10 == 0 && $(this).addClass("bluesmall li_after"))) : "xsds" == t && (tools.ifselectedOpacity($(this)), o ? ($(this).addClass("blueeven"), (i + 1) % 10 == 0 && $(this).addClass("blueeven li_after")) : ($(this).addClass("bluesingular"), (i + 1) % 10 == 0 && $(this).addClass("bluesingular li_after")))
    })
}, tools.playSound = function (t) {
    var e = "false" != localStorage.ifopenSoundsBtn;
    if (0 == e && void 0 != e) {
        var i = $("#audioid");
        //console.log('iiiiiiii', i)
        "begin" == t && "begin" == $("#soundSet").find("select").val() ? i[0].play() : $("#soundSet").find("select").val() == t - 1 && i[0].play()
    }
}, tools.repeatAjaxt = {
    kuai3: function (t) {
        clearInterval(animateID[t]), setTimeout(function () {
            ajaxRequst($(t).find(".nextIssue").text(), $(t).attr("id"))
        }, 1e3)
    }, qiu: function (t) {
        clearInterval(animateID[t]);
        var e = "";
        $(t).find(".kajianhao li").each(function () {
            e += $(this).text() + ","
        }), animateMethod.sscAnimateEnd(e, t), setTimeout(function () {
            ajaxRequst($(t).find(".nextIssue").text(), $(t).attr("id"))
        }, 1e3)
    }, pk10: function (t) {
        clearInterval(animateID[t]), setTimeout(function () {
            ajaxRequst($(".nextIssue").text())
        }, 1e3)
    }, cqnc: function (t) {
        clearInterval(animateID[t]), setTimeout(function () {
            ajaxRequst($(".nextIssue").text())
        }, 1e3)
    }
}, tools.repeatIndexAjax = {
    kuai3: function (t) {
        setTimeout(function () {
            ajaxRequst($(t).find(".nextIssue").text(), $(t).attr("id"))
        }, 1e3)
    }, qiu: function (t) {
        var e = "";
        $(t).find(".kajianhao li").each(function () {
            e += $(this).text() + ","
        }), animateMethod.sscAnimateEnd(e, t), setTimeout(function () {
            ajaxRequst($(t).find(".nextIssue").text(), $(t).attr("id"))
        }, 1e3)
    }, qiuam: function (t) {
        var e = "";
        $(t).find(".kajianhao li").each(function () {
            e += $(this).text() + ","
        }), animateMethod.sscAnimateEnd(e, t)
    }, pk10: function (t) {
        setTimeout(function () {
            ajaxRequst($(t).find(".nextIssue").text(), $(t).attr("id"))
        }, 1e3)
    }, cqnc: function (t) {
        clearInterval(animateID[t]), setTimeout(function () {
            ajaxRequst($(".nextIssue").text())
        }, 1e3)
    }
}, tools.bannerImg = function (t) {
    var e, i = t.list.length;
    //"index" != $("#ifindex").val() && (e = "../../img/banner/img03.jpg");
    var n = "";
    $(t.list).each(function (t) {
        n += '<div class="swiper-slide"><a href="' + this.link + '" target="_blank"><img onerror="defaultIMG(this)" src="' + this.image + '"></a></div>'
    });
    var o = '<div class="device"><div class="swiper-container"><div class="swiper-wrapper">' + n + '</div></div><div class="pagination"></div></div>';
    $("#littleimg").empty(), i <= 1 ? $("#littleimg").append(n) : $("#littleimg").append(o);
    var s = new Swiper(".swiper-container", {
        pagination: ".pagination",
        loop: !0,
        freeMode: !0,
        grabCursor: !0,
        paginationClickable: !0,
        autoplay: 4500,
        effect: "fade",
        fade: {crossFade: !0},
        autoplayDisableOnInteraction: !1,
        onSlideChangeStart: function (t) {
            $(".device").css("background-color", "#fff")
        }
    });
    $(".arrow-left").on("click", function (t) {
        t.preventDefault(), s.swipePrev()
    }), $(".arrow-right").on("click", function (t) {
        t.preventDefault(), s.swipeNext()
    })
}, tools.advertisImg = function (t) {
    if ($("#advertisebox").length > 0) {
        var e = function (t, e) {
            return '<div><a class="guanggao1" target="_blank" href="' + t + '" rel="nofollow"><img src="' + e + '" alt="" /></a></div>'
        };
        $("#advertisebox").empty(), $(t.list).each(function () {
            "" != this.image && void 0 != this.image && $("#advertisebox").append(e(this.link, this.image))
        })
    }
    try {
        "" != t.noticeContent && void 0 != t.noticeContent ? $("#noticeContent").html(t.noticeContent) : $("#hotbox").hide()
    } catch (t) {
        $("#hotbox").hide()
    }
}, tools.browserRedirect = function () {
    var t = window.location.search;
    if (!(window.screen.width >= 1024 && window.devicePixelRatio <= 2)) if (-1 != t.indexOf("m")) ; else {
        var e = navigator.userAgent.toLowerCase(), i = "ipad" == e.match(/ipad/i),
            n = "iphone os" == e.match(/iphone os/i), o = "midp" == e.match(/midp/i),
            s = "rv:1.2.3.4" == e.match(/rv:1.2.3.4/i), a = "ucweb" == e.match(/ucweb/i),
            d = "android" == e.match(/android/i);
        e.indexOf("android") > 0 && (d = !0);
        var r = "windows ce" == e.match(/windows ce/i), l = "windows mobile" == e.match(/windows mobile/i);
        if (i || n || o || s || a || d || r || l) {
            //-1 != window.location.href.indexOf("1680100.com") ? window.location.href = "//m.1680100" + tools.getCom() : window.location.href = "//m." + tools.YM() + tools.getCom()
        }
    }
}, tools.typ_NoSubmit = function () {
    $("#submit").on("click", function () {
        return "正在开奖中..." != $("#fabujingcai .pop-left span").text() || ($("#submit").css("cursor", "no-drop"), !1)
    })
}, tools.quiz_countdown = function () {
    if (0 == $("#timebox").find(".linetime .cuttime .minute").length) return !1;
    var t = 60 * $("#timebox").find(".linetime .cuttime .minute").text() + 1 * $("#timebox").find(".linetime .cuttime .second").text() - 2,
        e = $("#pk10").find(".timekeeping .linetit .nextIssue").text(), i = "";
    i = 10058 == lotCode ? "SG飞艇" : 10001 == lotCode ? "北京赛车" : 10057 == lotCode ? "幸运飞艇" : "极速赛车";
    !function () {
        t--;
        var n = Math.floor(t / 60), o = t % 60;
        if (t <= 0) s = "<p>" + i + "</p><span style='color:red'>正在开奖中...</span>", $("#submit").css("cursor", "no-drop"), "my-quiz" == $(".navigation ul .actiontetx").attr("data-text") && (console.log("22222222222222222"), getLotteryResults()); else {
            var s = "<p>" + i + '</p><span class="nextIssue">' + e + "</span>期  竞猜发布截止时间";
            s += '<span class="minute">' + (n < 10 ? "0" + n : n) + '</span> : <span class="second">' + (o < 10 ? "0" + o : o) + "</span>", $("#submit").css({
                color: "#FFFFFF",
                background: "#ff7b00",
                cursor: "pointer"
            })
        }
        tools.typ_NoSubmit(), $("#fabujingcai").find(".pop-left").html(s)
    }()
}, tools.countDown = function (t, e, i, n) {
    var o = i.replace("#", "."), s = t.replace("-", "/"), e = e.replace("-", "/"), n = void 0 !== n ? n : 0;
    s = s.replace("-", "/"), e = e.replace("-", "/");
    var a = $(i).find(".hour"), d = $(i).find(".minute"), r = $(i).find(".second"), l = $(i).find(".opentyle"),
        c = $(i).find(".cuttime"), f = $(o).find(".hour"), m = $(o).find(".minute"), u = $(o).find(".second"),
        p = $(o).find(".opentyle"), h = $(o).find(".cuttime"), x = (new Date(s) - new Date(e)) / 1e3, g = !0,
        b = new Date, v = setInterval(function () {
            var t = Math.abs(new Date - b) / 1e3;
            if (b = new Date, (t = t.toString().split("."))[0] > 1 && (x -= t[0]), g ? (g = !1, tools.playSound("begin")) : tools.playSound(x), x > 1 && 0 === n) {
                x -= 1;
                var e = Math.floor(x / 3600), s = Math.floor(x / 60 % 60), w = Math.floor(x % 60);
                0 == $(".secondOne").length ? ($(a).text(e < 10 ? "0" + e : e), $(d).text(s < 10 ? "0" + s : s), $(r).text(w < 10 ? "0" + w : w), $(f).text(e < 10 ? "0" + e : e), $(m).text(s < 10 ? "0" + s : s), $(u).text(w < 10 ? "0" + w : w)) : (w = w < 10 ? "0" + 1 * w : w.toString(), $(".secondOne").text(w.slice(0, 1)), $(".secondTwo").text(w.slice(1, 2)));
                try {
                    tools.quiz_countdown()
                } catch (t) {
                }
                e <= 0 ? ($(i).find(".hourtxt").hide(), $(a).hide(), $(o).find(".hourtxt").hide(), $(f).hide()) : ($(i).find(".hourtxt").css("display", "inline-block"), $(a).css("display", "inline-block"), $(o).find(".hourtxt").css("display", "inline-block"), $(f).css("display", "inline-block")), $(l).hide(), $(c).css({display: "inline-block"}), $(p).hide(), $(h).css({display: "inline-block"})
            } else 1 === n ? ($(l).hide(), $(c).hide(), $(p).hide(), $(h).hide(), tools.hideCQ(), clearInterval(v)) : ($(l).show(), $(c).hide(), $(p).show(), $(h).hide(), clearInterval(v), setTimeout(function () {
                var v = $(i).find(".nextId").text();
                if(v == ""){
                    v = $(i).find(".nextIssue").text();
                }
                ajaxRequst(1 * v, i)
            }, 1e3))
        }, 1e3)
}, tools.ifCheckedOnToday = function () {
    var t = null;
    if (!$("#dateframe").length < 1) {
        var e = $(".listheadrl").find(".checked"), i = $("#dateframe").find(".date").val(), n = $(e).attr("id");
        if ("" == i) return !0;
        t = ("today" == n || void 0 == n) && i == tools.getDate()
    } else t = !0;
    return !(!t || !config.firstLoad)
}, tools.getDate = function () {
    var t = new Date, e = t.getFullYear(), i = t.getMonth() + 1;
    i = i < 10 ? "0" + i : i;
    var n = t.getDate();
    n = n < 10 ? "0" + n : n;
    t.getHours(), t.getMinutes(), t.getSeconds();
    return e + "-" + i + "-" + n
}, tools.insertVideo = function () {
    var t = 3600 * $("#pk10 .cuttime").find(".hour").text() + 60 * $("#pk10 .cuttime").find(".minute").text() + 1 * $("#pk10 .cuttime").find(".second").text() - 1;
    "-1" == t && (t = 0), $("iframe")[0].contentWindow.startcountdown(t);
    var e = "", i = $("#pk10 #jnumber").find("li");
    $(i).each(function () {
        e += $(this).text() + ","
    });
    var n = null;
    n = e.length < 11 ? "5,6,3,4,8,7,9,10,2,1" : e.substring(0, e.length - 1), $("iframe")[0].contentWindow.showcurrentresult(n), $(".animate iframe").contents().find("#currentdrawid").text($("#pk10").find(".drawCount").text()), $(".animate iframe").contents().find("#nextdrawtime").text($("#pk10").find(".preDrawIssue").text()), $(".animate iframe").contents().find("#stat1_1").text($("#pk10").find(".sumFS").text()), $(".animate iframe").contents().find("#stat1_2").text($("#pk10").find(".sumBigSamll").text()), $(".animate iframe").contents().find("#stat1_3").text($("#pk10").find(".sumSingleDouble").text());
    var o = $("#pk10 .longhu").find("td");
    $(".animate iframe").contents().find("#stat2_1").text($(o).eq(0).text()), $(".animate iframe").contents().find("#stat2_2").text($(o).eq(1).text()), $(".animate iframe").contents().find("#stat2_3").text($(o).eq(2).text()), $(".animate iframe").contents().find("#stat2_4").text($(o).eq(3).text()), $(".animate iframe").contents().find("#stat2_5").text($(o).eq(4).text())
}, tools.noAPP = function () {
    tools.YM();
    $(".mphone").attr("href", toM()), $(".miniIphone").find("a").attr("href", toM())
}, tools.clearHC = function () {
    config.version, $("link").attr("href");
    $("link").each(function () {
        var t = $(this).attr("href"), e = new Date;
        t = t + "?v=" + e.getFullYear() + e.getMonth() + 1 + e.getDate(), $(this).attr("href", t)
    })
}, tools.setPK10TB = function () {
    pk10jiuchuo = setInterval(function () {
        -1 != $("#videobox").css("z-index") && ("00:00" != $(".animate iframe").contents().find(".countdownnum").text() ? (tools.insertVideo(), config.ifdebug && console.log("纠错....")) : config.ifdebug && (console.log("开始开奖了...."), console.log("停止纠错....")))
    }, 5e3)
}, tools.operatorTime = function (t, e) {
    var i = t.replace(/-/g, "/"), e = e.replace(/-/g, "/");
    return (new Date(i).getTime() - new Date(e).getTime()) / 1e3
}, tools.gxKaiBg = function (t, e) {
    for (var i = 0; i < t.length; i++) 1 == t[i] || 4 == t[i] || 7 == t[i] || 10 == t[i] || 13 == t[i] || 16 == t[i] || 19 == t[i] ? $(e).find(".gx_kajianhao").find("li").eq(i).addClass("numred") : 3 != t[i] && 6 != t[i] && 9 != t[i] && 12 != t[i] && 15 != t[i] && 18 != t[i] && 21 != t[i] || $(e).find(".gx_kajianhao").find("li").eq(i).addClass("numgreen")
}, tools.egxy28 = function (t) {
    $(t).find(".kajianhao ul").find("li:last-child").addClass("numred")
}, tools.bjkl8BagColor = function (t, e) {
    var i = t.split(",");
    i.splice(i.length - 1, 1);
    for (var n = 0; n < i.length - 1; n++) i[n] >= 41 && $(e).find(".kajianhao ul").find("li").eq(n).addClass("numWeightblue");
    "10073" == lotCode || "10054" == lotCode || "10082" == lotCode ? $(e).find(".kajianhao ul").find("li:last-child").addClass("numWeightblue") : $(e).find(".kajianhao ul").find("li:last-child").addClass("numOrange")
}, tools.setTimefun_k3 = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t, e = "", i = "", n = ($("#cqSsc").find(".kajianhao li").length, 0),
                o = $("#cqSsc").find(".preDrawIssue").text(), s = parseInt(o), a = 0 + $(".drawCount").text(),
                d = 3600 * $("#timebox").find("hour").text() + 60 * $("#timebox").find(".minute").text() + 1 * $("#timebox").find(".second").text() - 2;
            "-1" == d && (d = 0), $("#cqSsc").find(".kajianhao").find("li").each(function (o) {
                e = $(this).attr("class"), t = e.substring(e.length - 1, e.length), o <= 2 && $("iframe").contents().find("#codetop").find("li").eq(o).text(t), i += t, n += parseInt(t)
            }), i = [].slice.call(i), $("iframe").contents().find(".nowDraw").text(a);
            var r = {
                preDrawCode: i,
                sumNum: n,
                sumBigSmall: sumBigSmall,
                drawIssue: s + 1,
                drawTime: drawTime,
                seconds: d
            };
            $("iframe")[0].contentWindow.k3v.stopVideo(r)
        }
    }, 2e3)
}, tools.setTimefun_ssc = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = 3600 * $("#timebox").find(".hour").text() + 60 * $("#timebox").find(".minute").text() + 1 * $("#timebox").find(".second").text() - 1;
            "-1" == t && (t = 0);
            var e = $("#cqSsc").find(".kajianhao li").text(), i = {
                preDrawCode: [].slice.call(e),
                id: "#numBig",
                counttime: t,
                preDrawIssue: $(".preDrawIssue").text(),
                drawTime: $("#drawTime").val(),
                sumNum: $("#sumNum").val(),
                sumSingleDouble: $("#sumSingleDouble").val(),
                sumBigSmall: $("#sumBigSmall").val(),
                dragonTiger: $("#dragonTiger").val()
            };
            $("iframe")[0].contentWindow.sscAnimateEnd(i, lotCode)
        }
    }, 1e3)
}, tools.setTimefun_cqnc = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = 3600 * $("#timebox").find(".hour").text() + 60 * $("#timebox").find(".minute").text() + 1 * $("#timebox").find(".second").text() - 1;
            "-1" == t && (t = 0);
            var e = [];
            if ($("#klsf").find(".kajianhao li").each(function () {
                e.push(parseInt($(this).text()))
            }), console.log("开奖后：code数组1：" + e), e.length < 8 || NaN == e[0]) return void setTimeout(function () {
                tools.setTimefun_cqnc()
            }, 500);
            $(".preDrawIssue").text();
            var i = t;
            console.log("开奖后：code数组2：" + e), $("iframe")[0].contentWindow.stopanimate(e, i)
        }
    }, 1e3)
}, tools.setTimefun_shiyixw = function () {
    setTimeout(function () {
        void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index") && $("iframe")[0].contentWindow.k3v.stopVideo(tools.getSyxwData())
    }, 1500)
}, tools.getSyxwData = function () {
    var t = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
        e = [];
    return $("#shiyix5").find(".kajianhao li").each(function () {
        e.push(parseInt($(this).text()))
    }), {
        preDrawCode: e,
        sumNum: $("#sumNum").val(),
        sumBigSmall: $("#sumBigSmall").val(),
        sumSingleDouble: $("#sumSingleDouble").val(),
        drawIssue: $(".nextIssue").text(),
        drawTime: $("#drawTime").val(),
        preDrawTime: t
    }
}, tools.setTimefun_bjkl8 = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
                e = [];
            $("#klsf").find(".kajianhao li").each(function () {
                e.push(parseInt($(this).text()))
            }), "10073" != lotCode && "10054" != lotCode && "10082" != lotCode || e.push("101");
            var i = {
                preDrawCode: e,
                drawIssue: $("#preDrawIssue").val(),
                drawTime: $("#drawTime").val(),
                preDrawTime: t
            };
            $("iframe")[0].contentWindow.syxwV.stopVid(i)
        }
    }, 1500)
}, tools.setTimefun_pcEgg = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
                e = [];
            $("#egxy").find(".kajianhao li").each(function (t) {
                t < 3 && e.push(parseInt($(this).text()))
            });
            var i = {numArr: e, nextIssue: $(".nextIssue").text(), drawTime: $("#drawTime").val(), preDrawTime: t};
            $("iframe")[0].contentWindow.pcEgg.stopVid(i)
        }
    }, 1500)
}, tools.setTimefun_gdklsf = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = 3600 * $("#timebox").find("hour").text() + 60 * $("#timebox").find(".minute").text() + 1 * $("#timebox").find(".second").text() - 2,
                e = [];
            $("#klsf").find(".kajianhao li").each(function () {
                e.push(parseInt($(this).text()))
            });
            var i = {
                arr: e,
                thisIssue: $("#klsf").find(".preDrawIssue").text(),
                nextIssue: $("#klsf").find(".nextIssue").text(),
                nextTime: $("#klsf").find("#drawTime").val(),
                countdown: t
            };
            $("iframe")[0].contentWindow.fun.Trueresult(i.arr), $("iframe")[0].contentWindow.fun.fillHtml(i.thisIssue, i.nextIssue, i.nextTime, i.countdown)
        }
    }, 1500)
}, tools.setTimefun_gxklsf = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = $("#timebox").find("hour").text(), e = $("#timebox").find(".minute").text(),
                i = $("#timebox").find(".second").text(), n = t + ":" + e + ":" + i, o = [];
            $("#gxklsf").find(".kajianhao li").each(function () {
                o.push(parseInt($(this).text()))
            });
            var s = {
                numArr: o,
                thisIssue: $("#gxklsf").find(".preDrawIssue").text(),
                nextIssue: $("#gxklsf").find(".nextIssue").text(),
                drawTime: $("#gxklsf").find("#drawTime").val(),
                cutdonwTime: n
            };
            $("iframe")[0].contentWindow.gxklsf.stopVid(s)
        }
    }, 1500)
}, tools.setTimefun_fc3D = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
                e = [];
            $("#cqSsc").find(".kajianhao li").each(function () {
                e.push(parseInt($(this).text()))
            });
            var i = {
                preDrawCode: e,
                drawIssue: $("#preDrawIssue").val(),
                drawTime: $("#drawTime").val(),
                preDrawTime: t
            };
            $("iframe")[0].contentWindow.fc3d.stopVid(i)
        }
    }, 1500)
}, tools.setTimefun_fcssq = function () {
    setTimeout(function () {
        if (void 0 != $("#drawTime").val() && -1 != $("#videobox").css("z-index")) {
            var t = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
                e = [];
            $("#cqSsc").find(".kajianhao li").each(function () {
                e.push(parseInt($(this).text()))
            });
            var i = {
                preDrawCode: e,
                drawIssue: $("#cqSsc").find(".preDrawIssue").text(),
                drawTime: $("#cqSsc").find("#drawTime").val(),
                data: $("#cqSsc").find("#nextDate").val(),
                preDrawTime: t
            };
            $("iframe")[0].contentWindow.ssq.stopVid(i)
        }
    }, 1500)
};
var listColor = "";
tools.initListen = function () {
    $("#jrsmhmtj").find("table").css("background", "#d4d4d4"), $("#selectcolor").on("click", "span", function () {
        $(this).addClass("select").siblings().removeClass(), 1 != $(this).children().length && (listColor = $(this).css("background-color"), $("#jrsmhmtj table tr:odd").find("td").css("background", listColor))
    })
}, tools.resetListColor = function () {
    "" != listColor && $("#jrsmhmtj table tr:odd").find("td").css("background", listColor)
}, tools.Msit = function () {
    $("#advertisebox").width()
}, tools.YM = function () {
    var t = window.location.href;
    return "www" == (t = t.split("//")[1].split("/")[0].split("."))[0] ? t = t[1] : "www" != t[0] && (t = "192" == t[0] ? "1680218" : t[0]), t
}, tools.advertisement = function () {
    $.ajax({
        url: publicUrl + "focusPicture/findPictureAndNotice.do",
        type: "GET",
        dataType: "json",
        data: {type: "0", position: "1", sourceUrl: tools.YM(), platform: "168"},
        timeout: 6e4,
        beforeSend: function () {
            $("#advertisebox").html('<div class="progress" style="display: block;margin-top:30px;width:100%;text-align:center;"><img src="../../img/icon/piaog.gif"></div>')
        },
        success: function (t) {
            "object" == typeof (t = t) || (t = JSON.parse(t)), "0" == t.errorCode && ("0" == t.result.businessCode ? tools.advertisImg(t.result.data) : $("#advertisebox").empty().text("数据加载异常！"))
        },
        error: function (t) {
            setTimeout(tools.advertisement(), 1e3)
        },
        complete: function (t, e) {
            null
        }
    })
}, tools.WWWD = function () {
    $("#tryplay").hide()
}, tools.getCom = function () {
    var t = window.location.hostname.split(".");
    return "192" == t[0] ? ".co" : "." + t[t.length - 1]
}, tools.advertisement_index = function () {
    $.ajax({
        url: publicUrl + "focusPicture/findPictureAndNotice.do",
        type: "GET",
        dataType: "json",
        data: {type: "0", position: "1", sourceUrl: tools.YM(), platform: "168"},
        timeout: 6e4,
        beforeSend: function () {
            $("#advertisebox").html('<div class="progress" style="display: block;margin-top:30px;width:100%;text-align:center;"><img src="img/icon/piaog.gif"></div>')
        },
        success: function (t) {
            "object" == typeof (t = t) || (t = JSON.parse(t)), "0" == t.errorCode && ("0" == t.result.businessCode ? tools.advertisImg(t.result.data) : $("#advertisebox").empty().text("数据加载异常！"))
        },
        error: function (t) {
            setTimeout(tools.advertisement_index(), 1e3)
        },
        complete: function (t, e) {
            null
        }
    })
}, tools.showExplain = function () {
    $("#prep").click(function (t) {
        t.stopPropagation();
        $("#spreadDiv").height();
        var e = $("#spreadDiv").find("p").length;
        e *= $("#spreadDiv").find("p").eq(0).height();
        $("#spreadDiv").stop().animate({height: e, padding: "10px 0"}, 300)
    }), $("#spreadDiv").mouseleave(function (t) {
        t.stopPropagation();
        $("#spreadDiv").stop().animate({height: "28px", padding: "0"}, 300)
    })
}, tools.playVideo = function () {
    $("#startVideo").on("click", function () {
        ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "640px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575"), iframe(), isfirthload = !1, tools.insertVideo(), tools.setPK10TB()
            })
        }), ifopen = !0, document.addEventListener("touchstart", function () {
            ifopen && $("iframe")[0].contentWindow.ifsund() && $("iframe")[0].contentWindow.document.getElementById("sound").play()
        }, !1), $("iframe")[0].contentWindow.ifopen = !0)
    }), $("#videobox .closevideo").on("click", function () {
        clearInterval(pk10jiuchuo), $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            })
        }), ifopen = !1, $("iframe")[0].contentWindow.ifopen = !1, $("iframe").contents().find("#sound").attr("src", "")
    }), $("#videobox .small").on("click", function () {
        $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".animate").height("290"), iframe(), $(".content").width("347px"), toolBoxs.isIE() || ($(".animate iframe").contents().find(".footer1,.footer2,.footer3").find("div").css({
                transform: "scale(0.85)",
                "margin-top": "6px",
                "margin-left": "0px"
            }), $(".animate iframe").contents().find(".footer2_1").css({transform: "scale(0.85)", width: "auto"}))
        })
    }), $("#videobox .big").on("click", function () {
        $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "640px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), iframe()
            })
        })
    })
}, tools.playVideo_SSC = function () {
    $("#startVideo").on("click", function () {
        $("iframe")[0].contentWindow.ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "630px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575");
                var t = 3600 * $("#timebox").find(".hour").text() + 60 * $("#timebox").find(".minute").text() + 1 * $("#timebox").find(".second").text() - 1;
                "-1" == t && (t = 0);
                var e = $("#cqSsc").find(".kajianhao li").text(), i = {
                    preDrawCode: [].slice.call(e),
                    id: "#numBig",
                    counttime: t,
                    preDrawIssue: $(".preDrawIssue").text(),
                    drawTime: $("#drawTime").val(),
                    sumNum: $("#sumNum").val(),
                    sumSingleDouble: $("#sumSingleDouble").val(),
                    sumBigSmall: $("#sumBigSmall").val(),
                    dragonTiger: $("#dragonTiger").val()
                };
                $("iframe")[0].contentWindow.sscAnimateEnd(i, lotCode)
            })
        }), $("iframe")[0].contentWindow.ifopen = !0)
    }), document.addEventListener("touchstart", function () {
        $("iframe")[0].contentWindow.videoTools.sounds.soundsT.play("bgsound")
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.videoTools.sounds.soundsT.stop("bgsound"), $("iframe")[0].contentWindow.videoTools.clearInterval(), $("iframe")[0].contentWindow.ifopen = !1
    }), $("#videobox .small").on("click", function () {
        $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.playVideo_klsf = function () {
    $("#startVideo").on("click", function () {
        $("iframe")[0].contentWindow.ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "630px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575");
                var t = $("#timebox").find(".hour").text(), e = $("#timebox").find(".minute").text(),
                    i = $("#timebox").find(".second").text();
                "..." == t && (t = 0), "..." == e && (e = 0), "..." == i && (i = 0);
                var n = 3600 * t + 60 * e + 1 * i - 2;
                "-1" != n && "-2" != n || (n = 0);
                var o = [], s = [], a = $("#klsf").find(".preDrawIssue").text(),
                    d = $("#klsf").find(".nextIssue").text(), r = $("#klsf").find("#drawTime").val();
                $("#klsf").find(".kajianhao").find("li").each(function () {
                    o.push(parseInt($(this).text()))
                }), console.log("当前开奖号码数组：" + o);
                var l = {arr: o, thisIssue: a, nextIssue: d, nextTime: r, countdown: n};
                $("iframe")[0].contentWindow.fun.stateSound(), 0 == n ? ($("#jrsmhmtjTab").find("tr:nth-child(2)").find(".klsf_kaiul li").each(function () {
                    s.push(parseInt($(this).text()))
                }), $("iframe")[0].contentWindow.fun.onPcFillHtml(l.thisIssue, l.nextIssue, l.nextTime, s), $("iframe")[0].contentWindow.fun.moveBall()) : $("iframe")[0].contentWindow.fun.fillHtml(l.thisIssue, l.nextIssue, l.nextTime, l.countdown, l.arr)
            })
        }), $("iframe")[0].contentWindow.ifopen = !0)
    }), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $("iframe").contents().find(".video_box").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.fun.ballStatic(), $("iframe")[0].contentWindow.bgsound.pause(), $("iframe")[0].contentWindow.kaisound.pause(), $("iframe")[0].contentWindow.ifopen = !1
    }), $("#videobox .small").on("click", function () {
        $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $("iframe").contents().find(".video_box").css("transform", "scale(0.31)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".video_box").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.playVideo_cqnc = function () {
    $("#videobox .closevideo").on("click", function () {
        $("iframe")[0].contentWindow.stopanimate(), $(".content").animate({
            width: "0",
            "margin-right": "0"
        }, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.ifopen = !1
    }), $("#videobox .small").on("click", function () {
        $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $("iframe").contents().find(".content").css("transform", "scale(0.31)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.playVideo_GXklsf = function () {
    $("#startVideo").on("click", function () {
        $("iframe")[0].contentWindow.ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "630px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575");
                var t = $("#timebox").find(".hour").text() + ":" + $("#timebox").find(".minute").text() + ":" + $("#timebox").find(".second").text(),
                    e = [], i = $("#gxklsf").find(".preDrawIssue").text(), n = $("#gxklsf").find(".nextIssue").text(),
                    o = $("#gxklsf").find("#drawTime").val();
                $("#gxklsf").find(".kajianhao").find("li").each(function () {
                    e.push(parseInt($(this).text()))
                }), console.log("当前开奖号码数组：" + e);
                var s = {numArr: e, thisIssue: i, nextIssue: n, drawTime: o, cutdonwTime: t};
                $("iframe")[0].contentWindow.gxklsf.startVid(s)
            })
        }), $("iframe")[0].contentWindow.ifopen = !0)
    }), document.addEventListener("touchstart", function () {
        $("iframe")[0].contentWindow.gxklsf.sound.stop("audioidKai")
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.gxklsf.sound.stop("audioidBg"), $("iframe")[0].contentWindow.gxklsf.sound.stop("audioidKai"), $("iframe")[0].contentWindow.ifopen = !1, $("iframe")[0].contentWindow.gxklsf.clearTime()
    }), $("#videobox .small").on("click", function () {
        $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $("iframe").contents().find(".content").css("transform", "scale(0.31)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.playVideo_BJKL8 = function () {
    $("#startVideo").on("click", function () {
        $("iframe")[0].contentWindow.ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "630px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)");
                var t = $("#timebox").find(".hour").text(), e = $("#timebox").find(".minute").text(),
                    i = $("#timebox").find(".second").text(), n = t + ":" + e + ":" + i, o = [], s = [];
                "..." == t && (t = 0), "..." == e && (e = 0), "..." == i && (i = 0);
                var a = 3600 * t + 60 * e + 1 * i - 2;
                "-1" != a && "-2" != a || (a = 0), $("#klsf").find(".kajianhao li").each(function () {
                    o.push(parseInt($(this).text()))
                }), "10073" != lotCode && "10054" != lotCode && "10082" != lotCode || o.push("101");
                var d = {
                    preDrawCode: o,
                    drawIssue: $("#preDrawIssue").val(),
                    drawTime: $("#drawTime").val(),
                    preDrawTime: n
                };
                0 == a ? ($("#jrsmhmtjTab").find("tr:nth-child(2)").find("ul li").each(function () {
                    s.push(parseInt($(this).text()))
                }), $("iframe")[0].contentWindow.syxwV.pcFillData(d.drawIssue, d.drawTime, s, 1), $("iframe")[0].contentWindow.syxwV.intoKai(), $("iframe")[0].contentWindow.syxwV.startFun()) : $("iframe")[0].contentWindow.syxwV.startVid(d)
            })
        }), $("iframe")[0].contentWindow.ifopen = !0)
    }), $("#videobox .closevideo").on("click", function () {
        config.ifScalse = .782, $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.syxwV.sound.stop("audioidBg"), $("iframe")[0].contentWindow.syxwV.sound.stop("audioidKai"), $("iframe")[0].contentWindow.syxwV.clearTime(), $("iframe")[0].contentWindow.ifopen = !1
    }), $("#videobox .small").on("click", function () {
        config.ifScalse = .31, $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $("iframe").contents().find(".content").css("transform", "scale(0.31)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        config.ifScalse = .782, $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.playVideo_kuai3 = function () {
    $("#startVideo").on("click", function () {
        $("iframe")[0].contentWindow.ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "630px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575");
                var t, e = "", i = "", n = ($("#cqSsc").find(".kajianhao li").length, 0),
                    o = $("#cqSsc").find(".preDrawIssue").text(), s = parseInt(o), a = 0 + $(".drawCount").text(),
                    d = 3600 * $("#timebox").find("hour").text() + 60 * $("#timebox").find(".minute").text() + 1 * $("#timebox").find(".second").text() - 2;
                "-1" == d && (d = 0), $("#cqSsc").find(".kajianhao").find("li").each(function (o) {
                    e = $(this).attr("class"), t = e.substring(e.length - 1, e.length), o <= 2 && $("iframe").contents().find("#codetop").find("li").eq(o).text(t), i += t, n += parseInt(t)
                });
                var r = n;
                i = [].slice.call(i), $("iframe").contents().find(".nowDraw").text(a);
                var l = {preDrawCode: i, sumNum: n, sumBigSmall: r, drawIssue: s + 1, drawTime: drawTime, seconds: d};
                $("iframe")[0].contentWindow.k3v.stopVideo(l)
            })
        }), $("iframe")[0].contentWindow.ifopen = !0)
    }), document.addEventListener("touchstart", function () {
        $("iframe")[0].contentWindow.k3v.sound.stop("audioid")
    }, !1), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.k3v.sound.stop("audioid"), $("iframe")[0].contentWindow.ifopen = !1
    }), $("#videobox .small").on("click", function () {
        $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $("iframe").contents().find(".content").css("transform", "scale(0.31)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.playVideo_shiyix5 = function () {
    $("#startVideo").on("click", function () {
        $("iframe")[0].contentWindow.ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "630px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575"), "block" == $(".small").css("display") && $("iframe").contents().find(".content").css("transform", "scale(0.782)");
                var t = $("#timebox").find(".hour").text(), e = $("#timebox").find(".minute").text(),
                    i = $("#timebox").find(".second").text(), n = t + ":" + e + ":" + i,
                    o = 3600 * t + 60 * e + 1 * i - 2;
                "-1" != o && "-2" != o || (o = 0);
                var s = [], a = [];
                $("#shiyix5").find(".kajianhao li").each(function () {
                    s.push(parseInt($(this).text()))
                });
                var d = {
                    preDrawCode: s,
                    sumNum: $("#sumNum").val(),
                    sumBigSmall: $("#sumBigSmall").val(),
                    sumSingleDouble: $("#sumSingleDouble").val(),
                    drawIssue: $(".nextIssue").text(),
                    drawTime: $("#drawTime").val(),
                    preDrawTime: n
                };
                0 == o ? ($("#jrsmhmtjTab").find("tr:nth-child(2)").find(".blueqiu").find("ul li").each(function () {
                    a.push(parseInt($(this).text()))
                }), $("iframe")[0].contentWindow.k3v.defStartVideo(d.drawIssue, d.drawTime, d.sumNum, d.sumBigSmall, d.sumSingleDouble, a)) : $("iframe")[0].contentWindow.k3v.startVideo(d)
            })
        }), $("iframe")[0].contentWindow.ifopen = !0)
    }), $("#videobox .closevideo").on("click", function () {
        $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.k3v.sound.stop("audioidB"), $("iframe")[0].contentWindow.k3v.sound.stop("audioidR"), $("iframe")[0].contentWindow.ifopen = !1, $("iframe")[0].contentWindow.k3v.clearTime()
    }), $("#videobox .small").on("click", function () {
        $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $("iframe").contents().find(".content").css("transform", "scale(0.31)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.playVideo_pcEgg = function () {
    $("#startVideo").on("click", function () {
        $("iframe")[0].contentWindow.ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "630px",
                "margin-bottom": "-298px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)");
                var t = $("#timebox").find(".hour").text(), e = $("#timebox").find(".minute").text(),
                    i = $("#timebox").find(".second").text(), n = t + ":" + e + ":" + i, o = [], s = [];
                "..." == t && (t = 0), "..." == e && (e = 0), "..." == i && (i = 0);
                var a = 3600 * t + 60 * e + 1 * i - 2;
                "-1" != a && "-2" != a || (a = 0), $("#egxy").find(".kajianhao li").each(function (t) {
                    t < 3 && o.push(parseInt($(this).text()))
                });
                var d = {numArr: o, nextIssue: $(".nextIssue").text(), drawTime: $("#drawTime").val(), preDrawTime: n};
                0 == a ? ($("#jrsmhmtjTab").find("tr:nth-child(2)").find("ul li").each(function () {
                    s.push(parseInt($(this).find("i").text()))
                }), $("iframe")[0].contentWindow.pcEgg.pcFillData(d.nextIssue, d.drawTime, s), $("iframe")[0].contentWindow.pcEgg.startRoate()) : (clearInterval($("iframe")[0].contentWindow.pcEgg.clearFloatint()), $("iframe")[0].contentWindow.pcEgg.startVid(d))
            })
        }), $("iframe")[0].contentWindow.ifopen = !0)
    }), $("#videobox .closevideo").on("click", function () {
        config.ifScalse = .782, $(".content").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .content").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            }), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
            $(".animate iframe").contents().find(".bluefont").text();
            $(".animate iframe").contents().find(".bluefont").css({
                "font-size": "25px",
                left: "36%",
                top: "0"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "0"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
        }), $("iframe")[0].contentWindow.pcEgg.sound.stop("audioidBg"), $("iframe")[0].contentWindow.pcEgg.sound.stop("audioidKai"), $("iframe")[0].contentWindow.pcEgg.clearTime(), $("iframe")[0].contentWindow.ifopen = !1
    }), $("#videobox .small").on("click", function () {
        config.ifScalse = .31, $(".content").animate({
            right: "0",
            width: "340px",
            height: "290px",
            "margin-right": "10px",
            bottom: "0",
            "margin-bottom": "0"
        }, 200, function () {
            $("#videobox").css({position: "static"}), $(".big").show(), $(".small").hide(), $(".content").width("347px"), $("iframe").contents().find(".content").css("transform", "scale(0.31)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").hide();
            var t, e;
            $(".animate iframe").contents().find(".bluefont").text().length > 5 ? (t = "14px", e = "0") : (t = "20px", e = "3px"), $(".animate iframe").contents().find(".bluefont").css({
                "font-size": t,
                left: e,
                top: "7px"
            }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "7px"}), $(".animate iframe").contents().find(".ml").css({"font-size": "20px"})
        })
    }), $("#videobox .big").on("click", function () {
        config.ifScalse = .782, $("#videobox").animate({"z-index": "19999"}, 200, function () {
            $(".content").animate({
                bottom: "50%",
                right: "50%",
                height: "630px",
                "margin-right": "-440px",
                width: "880px",
                "margin-bottom": "-298px"
            }, 300, function () {
                $("#videobox").css({position: "fixed"}), $(".big").hide(), $(".small").show(), $(".animate").height("575"), $("iframe").contents().find(".content").css("transform", "scale(0.782)"), $(".animate iframe").contents().find("#qishu,#nexttime,#cuttime,#btnbox").show();
                $(".animate iframe").contents().find(".bluefont").text();
                $(".animate iframe").contents().find(".bluefont").css({
                    "font-size": "25px",
                    left: "36%",
                    top: "0"
                }), $(".animate iframe").contents().find(".bckj").css({"margin-top": "25%"}), $(".animate iframe").contents().find(".ml").css({"font-size": "50%"})
            })
        })
    })
}, tools.toggleNoTodayOpenTip = function (t) {
    var e = t.data, i = t.contentClass, n = t.insertClass, o = t.nextCb, s = e.length;
    if (e.list && (s = e.list.length), e.tableList && (s = e.tableList.length), e.bodyList && (s = e.bodyList.length), s) $(".no-open-today").hide(), $(i).show(), o(e); else {
        $(i).hide();
        $(".no-open-today").length ? $(".no-open-today").show() : $(n).append('<div class="no-open-today" >今日暂未开奖</div>')
    }
};
