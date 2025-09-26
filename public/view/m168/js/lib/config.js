function popup() {
    $("body").append("<div id='popup'><div class='pupbox'><button id='pupbtn'></button><a href='http://apparcode.com/download.html' id='downbtn'></a><img src='../../img/imginfo-app.png'/></div></div>"), setTimeout(function () {
        $("#popup").css("height", $("body").height())
    }, 500), $("#popup").on("click", function (t) {
        t.stopPropagation();
        var o = $(t.target);
        "popup" != o.attr("id") && "pupbtn" != o.attr("id") || ($("#popup").hide(), $("html,body").css({overflow: "visible"}))
    })
}

function pupout(t) {
    var o = localStorage.getItem("pupday");
    null == o && (o = "0");
    var e = (new Date).getDate(), n = window.location.origin.split("//")[1].split(":")[0].replace("m.", "");
    1 * o != 1 * e && popup(), void 0 != t && "" != t && -1 == t.indexOf(n) || ($("#downbtn").attr("href", config.appNoAdvLink), $(".app_ver").find("a").attr("href", config.appNoAdvLink))
}

function pupajax() {
    $.ajax({
        type: "get",
        url: config.publicUrl + "parameters/getNoAdvertisingDomain.do",
        async: !0,
        data: {platform: "168"},
        success: function (t) {
            "string" == typeof t && (t = JSON.parse(t)), hideList = t.result.data.domainList, operationDomain(hideList);
            var o = window.location.hostname.split(":")[0].replace("m.", ""), e = $(".app-download-button");
            void 0 == hideList || "" == hideList || -1 != hideList.indexOf(o) ? (sessionStorage.setItem("isDomainNoAdv", !0), deepLinkInteraction(e, config.deepLinkNoAdv, config.appNoAdvLink)) : (sessionStorage.setItem("isDomainNoAdv", !1), deepLinkInteraction(e, config.deepLinkWithAdv, config.appWithAdvLink))
        },
        error: function () {
        }
    })
}

function deepLinkInteraction(t, o, e) {
    t.on("click", function (t) {
        t.preventDefault(), window.location.href = o, setTimeout(function () {
            window.location.href = e
        }, 100)
    })
}

function dialogAjax() {
    $.ajax({
        type: "GET",
        url: config.publicUrl + "advertis/getWindowsAdvertis.do",
        async: !0,
        data: {
            type: 1,
            source: -1 != window.location.hostname.indexOf("192.168") ? "1682018.com" : window.location.hostname
        },
        beforeSend: function () {
        },
        success: function (t) {
            "string" == typeof t && (t = JSON.parse(t)), "1" == t.result.data.display && "index" == $("#index").val() ? alertDialog(t.result.data) : window.location.href = "html/public/home.html"
        },
        error: function () {
        },
        complete: function () {
        }
    })
}

function operationDomain(t) {
    var o = window.location.hostname.split(":")[0].replace("m.", "");
    -1 != t.indexOf(o) && ($("#business").hide(), $("#footerDiv .app_ver").find("a").attr("href", "//apparcode.com/download-noadv.html"))
}

function adddesktop() {
    $("#deskbox").show(), $("body").width() >= 569 && ($(".desk1>span").css("right", "16%"), $("body,html").css("transform", "initial"));
    window.location.pathname.split("html/")[0];
    "load_ios" == checkDevice() ? $(".desk1").css("display", "none") : $(".desk2").css("display", "none")
}

function checkDevice() {
    var t = "", o = navigator.userAgent.toLowerCase();
    return /android|linux/.test(o) ? t = "load_andriod" : /iphone|ipad|ipod/.test(o) ? t = "load_ios" : /windows phone/.test(o) && (t = "load_ios"), t
}

function checkadddesk() {
    var t = localStorage.getItem("desktop");
    null != t && t || adddesktop()
}

function installPwa() {
    $("#deskbox").hide(), localStorage.setItem("desktop", !0), deferredPrompt && (deferredPrompt.prompt(), deferredPrompt.userChoice.then(function (t) {
        t.outcome, deferredPrompt = null
    }))
}

function closePrompt() {
    $("#deskbox").hide(), localStorage.setItem("desktop", !0)
}

function queryPublicQQ() {
    $.ajax({
        url: config.publicUrl + "parameters/getQQnumbers.do", success: function (t) {
            var o = t.result;
            0 === t.errorCode && o && 0 === o.businessCode && o.data.QQList && (config.PubQQNum = o.data.QQList, setPubQQNum(o.data.QQList))
        }, error: function (t) {
        }
    })
}

function setPubQQNum(t) {
    t.forEach(function (t) {
        "GuessQQnumbers" === t.type ? $("." + t.type).val(t.numbers[0]).text(t.numbers[0]) : $("." + t.type).text(t.numbers[0])
    })
}

var env = "productionEnv", config = {
    publicUrl: "http://kjwapi.xypv1.com/api/",
    videourl:"http://kjwpc.xypv1.com/",
    url6: "",
    imgUrl: "",
    loginUrl: "",
    ifdebug: !0,
    ifFirstLoad: !0,
    ifScalse: .782,
    periods: 30,
    showrows: 60,
    klsfrows: 15,
    klsfrows_thre: 40,
    canload: !0,
    offLine: "10065,10066,10056",
    xyncHeadHeight: 0,
    hisEl: "",
    kaiCountTimes: 1000,
    PubQQNum: [{type: "DownLoadQQnumbers", numbers: [3472555555]}, {
        type: "RightQQnumbers",
        numbers: [800825370]
    }, {type: "GuessQQnumbers", numbers: [3414555555]}],
    appNoAdvLink: "",
    appWithAdvLink: "",
    deepLinkNoAdv: "",
    deepLinkWithAdv: ""
};
"stagingEnv" == env && (config.publicUrl = "http://staging-api2-168-al2.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/", config.url6 = "http://staging-x6-api-al2.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/", appNoAdvLink = "https://staging-168-upload.s3-ap-northeast-1.amazonaws.com/168NoAdv/download-noadv.html", appWithAdvLink = "https://staging-168-upload.s3-ap-northeast-1.amazonaws.com/168/download.html", deepLinkNoAdv = "com.staging168noadv://noadv", deepLinkWithAdv = "com.staging168adv://adv");
var constant = {
    pk10: {totalIssue: 179},
    cqssc: {totalIssue: 120},
    tjssc: {totalIssue: 84},
    xjssc: {totalIssue: 96},
    gdklsf: {totalIssue: 84},
    syydj: {totalIssue: 78},
    gdsyxw: {totalIssue: 84},
    jsks: {totalIssue: 82},
    xync: {totalIssue: 97}
}, lotCode = {
    pk10: 10001,
    cqssc: 10002,
    tjssc: 10003,
    xjssc: 10004,
    gdklsf: 10005,
    gdsyxw: 10006,
    jsksan: 10007,
    sdsyydj: 10008,
    cqxync: 10009,
    aozxy5: 10010,
    aozxy8: 10011,
    aozxy10: 10012,
    aozxy20: 10013,
    bjkl8: 10014,
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
    gxft: 10026,
    jlft: 10027,
    hebft: 10028,
    nmgft: 10029,
    ahft: 10030,
    fjft: 10031,
    hubft: 10032,
    bjft: 10033,
    tjklsf: 10034,
    xyft: 10035,
    jisussc: 10036,
    jisusaiche: 10037,
    gxklsf: 10038,
    fcssq: 10039,
    cjdlt: 10040,
    fcsd: 10041,
    fcqlc: 10042,
    pailie3: 10043,
    pailie5: 10044,
    qxc: 10045,
    egxy28_old: 10046,
    twbg: 10047,
    cqqxc: 10050,
    jisuksan: 10052,
    jisuklsf: 10053,
    jisukl8: 10054,
    jisuef: 10055,
    txffc: 10056,
    xingyft: 10057,
    sgAirship: 10058,
    xyssc: 10059,
    happyCZ: 10060,
    shft: 10061,
    gzft: 10062,
    gsft: 10063,
    tw_5fencai: 10064,
    tw_dlt: 10070,
    tw_wlc: 10071,
    tw_jc539: 10072,
    kl8: 10073,
    egxy28: 10074,
    sgssc: 10075,
    sgksan: 10076,
    ukLotto5: 10077,
    ukLotto8: 10078,
    ukLotto10: 10079,
    ukLotto20: 10080,
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
}, RecommTime = {
    pk10: ["10:55-15:00", "17:55-23:50"],
    aozxy10: ["10:55-15:00", "17:55-23:50"],
    ukLotto10: ["10:55-15:00", "17:55-23:50"],
    jisusaiche: ["10:55-15:00", "17:55-23:50", "01:00-03:30"],
    xyft: ["10:55-15:00", "17:55-23:50", "01:00-03:30"],
    xingyft: ["17:55-23:50", "01:00-03:30"],
    sgAirship: ["10:55-15:00", "17:55-23:50", "01:00-03:30"],
    cqssc: ["10:55-15:00", "17:55-23:50"],
    happyCZ: ["10:55-15:00", "17:55-23:50"],
    tjssc: ["10:55-15:00", "17:55-23:00"],
    xjssc: ["10:55-15:00", "17:55:00-23:50"],
    xyssc: ["10:55-15:00", "17:55-23:50"],
    sgssc: ["10:55-15:00", "17:55-23:50"],
    aozxy5: ["10:55-15:00", "17:55-23:50", "01:00-03:30"],
    ukLotto5: ["10:55-15:00", "17:55-23:50", "01:00-03:30"],
    jisussc: ["10:55-15:00", "17:55-23:50", "01:00-03:30"],
    tw_5fencai: ["10:55-15:00", "17:55-23:50"],
    gdklsf: ["10:50-15:00", "17:50-23:00"],
    aozxy8: ["10:50-15:00", "17:50-23:50"],
    ukLotto8: ["10:50-15:00", "17:50-23:50"],
    tjklsf: ["10:50-15:00", "17:50-23:00"],
    cqxync: ["10:50-15:00", "17:50-23:50"],
    egxy28: ["10:50-15:00", "17:50-23:50"],
    gdsyxw: ["10:55-15:00", "17:50-23:00"],
    jxef: ["10:50-15:00", "17:50-23:00"],
    jsef: ["10:50-15:00", "17:50-22:00"],
    ahef: ["10:50-15:00", "17:50-22:00"],
    shef: ["10:55-15:00", "17:50-22:50"],
    lnef: ["10:50-15:00", "17:50-22:30"],
    hbef: ["10:50-15:00", "17:50-22:00"],
    gxef: ["10:50-15:00", "17:50-23:50"],
    jlef: ["10:50-15:00", "17:50-21:30"],
    nmgef: ["10:50-15:00", "17:50-23:00"],
    zjef: ["10:55-15:00", "17:50-22:30"],
    sdsyydj: ["10:50-15:00", "17:50-23:00"],
    sg11x5: ["10:50-15:00", "17:50-23:00"],
    jsksan: ["10:50-15:00", "17:50-22:00"],
    shft: ["10:50-15:00", "17:50-22:00"],
    gzft: ["10:50-15:00", "17:50-22:00"],
    gsft: ["10:50-15:00", "17:50-22:00"],
    gxft: ["10:50-15:00", "17:50-22:30"],
    jlft: ["10:50-15:00", "17:50-21:30"],
    hebft: ["10:50-15:00", "17:50-22:00"],
    nmgft: ["10:50-15:00", "17:50-22:00"],
    ahft: ["10:50-15:00", "17:50-22:00"],
    fjft: ["10:50-15:00", "17:50-22:00"],
    hubft: ["10:50-15:00", "17:50-22:00"],
    bjft: ["10:50-15:00", "17:50-23:50"],
    sgksan: ["10:50-15:00", "17:50-22:00"]
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
}, lotInfoApi = {
    pk10: "pks/getLotteryPksInfo.do",
    ssc: "CQShiCai/getBaseCQShiCai.do",
    twc_new: "taiWanCai/getLotteryInfo.do",
    klsf: "klsf/getLotteryInfo.do",
    gxklsf: "gxklsf/getLotteryInfo.do",
    jisukl8: "LuckTwenty/getBaseLuckTewnty.do",
    cqnc: "klsf/getLotteryInfo.do",
    kuai3: "lotteryJSFastThree/getBaseJSFastThree.do",
    shiyi5: "ElevenFive/getElevenFiveInfo.do",
    egxy: "LuckTwenty/getPcLucky28.do",
    qgc: "QuanGuoCai/getLotteryInfo.do",
    qgc1: "QuanGuoCai/getLotteryInfo1.do",
    smallSix: "smallSix/findSmallSixInfo.do",
    speedSix: "speedSix/findSpeedSixInfo.do"
}, alertDialog = function (t) {
    var o = '<div id="popup"><div class="pupbox"><div class="pupbtn cutTime">5</div><button class="pupbtn" id="pupbtn"></button><a href="' + t.url + '" target="' + t.openWith + '" style="background:url(' + config.imgUrl + t.imgName + ') no-repeat center;background-size: cover;"></a></div></div>';
    $("body").append(o);
    var e = 5, n = setInterval(function () {
        --e <= 0 ? (clearInterval(n), $(".cutTime").hide()) : $(".cutTime").html(e)
    }, 1e3);
    $("#pupbtn").on("click", function (t) {
        t.preventDefault(), $("#popup").remove()
    })
};
$(document).scroll(function () {
    $(this).scrollTop() > 20 && ($("#navList").css({
        top: "-1.2rem",
        opacity: "0.1"
    }), $(".whiteTip").css("transform", "rotate(0deg)"))
}), "serviceWorker" in navigator && window.addEventListener("load", function () {
    navigator.serviceWorker.register("../../168sw.js").then(function (t) {
    }, function (t) {
    })
});
var deferredPrompt;
window.addEventListener("beforeinstallprompt", function (t) {
    t.preventDefault(), deferredPrompt = t
}), checkadddesk(), $(".desk1").click(function () {
    installPwa()
}), $(".desk2").click(function () {
    installPwa()
}), $("#deskbox").on("click", function (t) {
    t.stopPropagation(), closePrompt()
}), $("#desk1close").on("click", function (t) {
    t.stopPropagation(), closePrompt()
}), $("#desk2close").on("click", function (t) {
    t.stopPropagation(), closePrompt()
}), $("#deskout").click(function () {
    "load_ios" == checkDevice() ? adddesktop() : deferredPrompt && adddesktop()
}), queryPublicQQ();
