function jumpBox() {
    $(".startVideo").on("click", function () {
        ifopen || ($("#videobox").animate({"z-index": "19999"}, 200, function () {
            $("#videobox .contentb").animate({
                bottom: "50%",
                right: "50%",
                width: "880px",
                height: "200px",
                "margin-bottom": "-100px"
            }, 500, function () {
                $(".big").hide(), $(".small").show(), $(".animate").height("575")
            })
        }), "iframe1" == $(this).prev().children().find("div").attr("id") ? $(".loading").text($("fieldset #iframe1").html()) : "tziframe" == $(this).prev().children().find("div").attr("id") ? $(".loading").text($("fieldset #tziframe").html()) : "haveBgIframe" == $(this).prev().children().find("div").attr("id") ? $(".loading").text($("fieldset #haveBgIframe").html()) : "noBgIframe" == $(this).prev().children().find("div:eq(1)").attr("id") ? $(".loading").text($("fieldset #noBgIframe").html()) : "Iframe1" == $(this).parent().prev().attr("id") ? $(".loading").text($("fieldset #Iframe1").html()) : "Iframe2" == $(this).parent().prev().attr("id") && $(".loading").text($("fieldset #Iframe2").html()))
    }), $("#videobox .closevideo").on("click", function () {
        $("#videobox .contentb").animate({width: "0", "margin-right": "0"}, 200, function () {
            $("#videobox").css({"z-index": "-1", position: "fixed"}), $("#videobox .contentb").css({
                width: "880px",
                "margin-right": "-440px",
                bottom: "-50%"
            })
        }), ifopen = !1
    }), $("#hlogo,.logo,.nameLogo").on("click", function () {
        getK(window.location.href.split("?")[1])
    })
}

function getK(e) {
    switch (1 * e) {
        case 10001:
            jumpHtml("view/PK10/pk10kai.html");
            break;
        case 10002:
            jumpHtml("view/shishicai_cq/ssc_index.html");
            break;
        case 10059:
            jumpHtml("view/shishicai_xy/ssc_index.html");
            break;
        case 10075:
            jumpHtml("view/shishicai_sg/ssc_index.html");
            break;
        case 10060:
            jumpHtml("view/happyCZ/ssc_index.html");
            break;
        case 10050:
            jumpHtml("view/shishicai_qxc/ssc_index.html");
            break;
        case 10003:
            jumpHtml("view/shishicai_tj/ssc_index.html");
            break;
        case 10065:
            jumpHtml("view/shishicai_xyffc/ssc_index.html");
            break;
        case 10066:
            jumpHtml("view/shishicai_hn5fc/ssc_index.html");
            break;
        case 10004:
            jumpHtml("view/shishicai_xj/ssc_index.html");
            break;
        case 10005:
            jumpHtml("view/klsf/klsf_index.html");
            break;
        case 10006:
            jumpHtml("view/shiyix5_gd/index.html");
            break;
        case 10007:
            jumpHtml("view/kuai3/kuai3_index.html");
            break;
        case 10061:
            jumpHtml("view/kuai3_shft/kuai3_index.html");
            break;
        case 10062:
            jumpHtml("view/kuai3_gzft/kuai3_index.html");
            break;
        case 10063:
            jumpHtml("view/kuai3_gsft/kuai3_index.html");
            break;
        case 10064:
            jumpHtml("view/tw_5fencai/ssc_index.html");
            break;
        case 10008:
            jumpHtml("view/shiyix5_sd/index.html");
            break;
        case 10009:
            jumpHtml("view/cqnc/index.html");
            break;
        case 10010:
            jumpHtml("view/aozxy5/ssc_index.html");
            break;
        case 10011:
            jumpHtml("view/aozxy8/klsf_index.html");
            break;
        case 10012:
            jumpHtml("view/aozxy10/pk10kai.html");
            break;
        case 10013:
            jumpHtml("view/aozxy20/aozxy20_index.html");
            break;
        case 10014:
            jumpHtml("view/beijinkl8/bjkl8_index.html");
            break;
        case 10015:
            jumpHtml("view/shiyix5_jiangxi/index.html");
            break;
        case 10016:
            jumpHtml("view/shiyix5_jiangsu/index.html");
            break;
        case 10017:
            jumpHtml("view/shiyix5_anhui/index.html");
            break;
        case 10018:
            jumpHtml("view/shiyix5_shanghai/index.html");
            break;
        case 10019:
            jumpHtml("view/shiyix5_liaoning/index.html");
            break;
        case 10020:
            jumpHtml("view/shiyix5_hubei/index.html");
            break;
        case 10021:
            jumpHtml("");
        case 10022:
            jumpHtml("view/shiyix5_guangxi/index.html");
            break;
        case 10023:
            jumpHtml("view/shiyix5_jiling/index.html");
            break;
        case 10024:
            jumpHtml("view/shiyix5_neimenggu/index.html");
            break;
        case 10025:
            jumpHtml("view/shiyix5_zhejiang/index.html");
            break;
        case 10026:
            jumpHtml("view/kuai3_guangxi/kuai3_index.html");
            break;
        case 10027:
            jumpHtml("view/kuai3_jiling/kuai3_index.html");
            break;
        case 10028:
            jumpHtml("view/kuai3_hebei/kuai3_index.html");
            break;
        case 10029:
            jumpHtml("view/kuai3_neimenggu/kuai3_index.html");
            break;
        case 10030:
            jumpHtml("view/kuai3_anhui/kuai3_index.html");
            break;
        case 10031:
            jumpHtml("view/kuai3_fujian/kuai3_index.html");
            break;
        case 10032:
            jumpHtml("view/kuai3_hubei/kuai3_index.html");
            break;
        case 10033:
            jumpHtml("view/kuai3_beijing/kuai3_index.html");
            break;
        case 10034:
            jumpHtml("view/klsf_tianjin/klsf_index.html");
            break;
        case 10035:
            jumpHtml("view/jisuft/pk10kai.html");
            break;
        case 10057:
            jumpHtml("view/xingyft/pk10kai.html");
            break;
        case 10058:
            jumpHtml("view/sgAirship/pk10kai.html");
            break;
        case 10036:
            jumpHtml("view/shishicai_jisu/ssc_index.html");
            break;
        case 10037:
            jumpHtml("view/jisusaiche/pk10kai.html");
            break;
        case 10038:
            jumpHtml("view/klsf_gaungxi/klsf_index.html");
            break;
        case 10039:
            jumpHtml("view/fcssq/index.html");
            break;
        case 10040:
            jumpHtml("view/cjdlt/index.html");
            break;
        case 10041:
            jumpHtml("view/fc3D/index.html");
            break;
        case 10042:
            jumpHtml("view/fc7lc/index.html");
            break;
        case 10043:
            jumpHtml("view/tcpl3/index.html");
            break;
        case 10044:
            jumpHtml("view/tcpl5/index.html");
            break;
        case 10045:
            jumpHtml("view/tc7xc/index.html");
            break;
        case 10047:
            jumpHtml("view/taiwanbg/twbg_index.html");
            break;
        case 10048:
            window.open("https://6hch.co/html/kaihistory.html");
            break;
        case 10051:
            window.open("https://6hch.co/html/smSixFast.html");
            break;
        case 10052:
            jumpHtml("view/kuai3_jisu/kuai3_index.html");
            break;
        case 10076:
            jumpHtml("view/kuai3_sg/kuai3_index.html");
            break;
        case 10053:
            jumpHtml("view/klsf_jisu/klsf_index.html");
            break;
        case 10054:
            jumpHtml("view/kl8_jisu/bjkl8_index.html");
            break;
        case 10055:
            jumpHtml("view/shiyix5_jisu/index.html");
            break;
        case 10056:
            jumpHtml("view/tencent_ffc/ssc_index.html");
            break;
        case 10070:
            jumpHtml("view/twBig_lottery/lottery_index.html");
            break;
        case 10071:
            jumpHtml("/view/twTaiwan_powerColor/power_index.html");
            break;
        case 10072:
            jumpHtml("/view/tw_539/Today539_index.html");
            break;
        case 10073:
            jumpHtml("view/kl8/kl8_index.html");
            break;
        case 10074:
            jumpHtml("view/PC_egxy28/PC_egxy28index.html");
            break;
        case 10077:
            jumpHtml("view/uklotto5/ssc_index.html");
            break;
        case 10078:
            jumpHtml("view/uklotto8/klsf_index.html");
            break;
        case 10079:
            jumpHtml("view/uklotto10/pk10kai.html");
            break;
        case 10080:
            jumpHtml("view/uklotto20/aozxy20_index.html");
            break;
        case 10081:
            jumpHtml("view/SpeedPcEgg/index.html");
            break;
        case 10082:
            jumpHtml("view/sgHappy8/aozxy20_index.html");
            break;
        case 10083:
            jumpHtml("view/sgHappy10/index.html");
            break;
        case 10084:
            jumpHtml("view/sg11x5/index.html")
    }
}

function getH(e) {
    switch (1 * e) {
        case 10001:
            jumpHtml("view/PK10/pk10kai_history.html");
            break;
        case 10002:
            jumpHtml("view/shishicai_cq/ssc_kjhistory.html");
            break;
        case 10059:
            jumpHtml("view/shishicai_xy/ssc_kjhistory.html");
            break;
        case 10075:
            jumpHtml("view/shishicai_sg/ssc_kjhistory.html");
            break;
        case 10060:
            jumpHtml("view/happyCZ/ssc_kjhistory.html");
            break;
        case 10050:
            jumpHtml("view/shishicai_qxc/ssc_kjhistory.html");
            break;
        case 10003:
            jumpHtml("view/shishicai_tj/ssc_kjhistory.html");
            break;
        case 10065:
            jumpHtml("view/shishicai_xyffc/ssc_kjhistory.html");
            break;
        case 10066:
            jumpHtml("view/shishicai_hn5fc/ssc_kjhistory.html");
            break;
        case 10004:
            jumpHtml("view/shishicai_xj/ssc_kjhistory.html");
            break;
        case 10005:
            jumpHtml("view/klsf/klsf_kjhistory.html");
            break;
        case 10006:
            jumpHtml("view/shiyix5_gd/kjhistory.html");
            break;
        case 10007:
            jumpHtml("view/kuai3/kuai3index_history.html");
            break;
        case 10061:
            jumpHtml("view/kuai3_shft/kuai3index_history.html");
            break;
        case 10062:
            jumpHtml("view/kuai3_gzft/kuai3index_history.html");
            break;
        case 10063:
            jumpHtml("view/kuai3_gsft/kuai3index_history.html");
            break;
        case 10064:
            jumpHtml("view/tw_5fencai/ssc_kjhistory.html");
            break;
        case 10008:
            jumpHtml("view/shiyix5_sd/kjhistory.html");
            break;
        case 10009:
            jumpHtml("view/cqnc/klsf_kjhistory.html");
            break;
        case 10010:
            jumpHtml("view/aozxy5/ssc_kjhistory.html");
            break;
        case 10011:
            jumpHtml("view/aozxy8/klsf_kjhistory.html");
            break;
        case 10012:
            jumpHtml("view/aozxy10/pk10kai_history.html");
            break;
        case 10013:
            jumpHtml("view/aozxy20/aozxy20_kjhistory.html");
            break;
        case 10014:
            jumpHtml("view/beijinkl8/bjkl8_kjhistory.html");
            break;
        case 10015:
            jumpHtml("view/shiyix5_jiangxi/kjhistory.html");
            break;
        case 10016:
            jumpHtml("view/shiyix5_jiangsu/kjhistory.html");
            break;
        case 10017:
            jumpHtml("view/shiyix5_anhui/kjhistory.html");
            break;
        case 10018:
            jumpHtml("view/shiyix5_shanghai/kjhistory.html");
            break;
        case 10019:
            jumpHtml("view/shiyix5_liaoning/kjhistory.html");
            break;
        case 10020:
            jumpHtml("view/shiyix5_hubei/kjhistory.html");
            break;
        case 10021:
            jumpHtml("");
        case 10022:
            jumpHtml("view/shiyix5_guangxi/kjhistory.html");
            break;
        case 10023:
            jumpHtml("view/shiyix5_jiling/kjhistory.html");
            break;
        case 10024:
            jumpHtml("view/shiyix5_neimenggu/kjhistory.html");
            break;
        case 10025:
            jumpHtml("view/shiyix5_zhejiang/kjhistory.html");
            break;
        case 10026:
            jumpHtml("view/kuai3_guangxi/kuai3index_history.html");
            break;
        case 10027:
            jumpHtml("view/kuai3_jiling/kuai3index_history.html");
            break;
        case 10028:
            jumpHtml("view/kuai3_hebei/kuai3index_history.html");
            break;
        case 10029:
            jumpHtml("view/kuai3_neimenggu/kuai3index_history.html");
            break;
        case 10030:
            jumpHtml("view/kuai3_anhui/kuai3index_history.html");
            break;
        case 10031:
            jumpHtml("view/kuai3_fujian/kuai3index_history.html");
            break;
        case 10032:
            jumpHtml("view/kuai3_hubei/kuai3index_history.html");
            break;
        case 10033:
            jumpHtml("view/kuai3_beijing/kuai3index_history.html");
            break;
        case 10034:
            jumpHtml("view/klsf_tianjin/klsf_kjhistory.html");
            break;
        case 10035:
            jumpHtml("view/jisuft/pk10kai_history.html");
            break;
        case 10057:
            jumpHtml("view/xingyft/pk10kai_history.html");
            break;
        case 10058:
            jumpHtml("view/sgAirship/pk10kai_history.html");
            break;
        case 10036:
            jumpHtml("view/shishicai_jisu/ssc_kjhistory.html");
            break;
        case 10037:
            jumpHtml("view/jisusaiche/pk10kai_history.html");
            break;
        case 10038:
            jumpHtml("view/klsf_gaungxi/klsf_kjhistory.html");
            break;
        case 10039:
            jumpHtml("view/fcssq/kjhistory.html");
            break;
        case 10040:
            jumpHtml("view/cjdlt/kjhistory.html");
            break;
        case 10041:
            jumpHtml("view/fc3D/kjhistory.html");
            break;
        case 10042:
            jumpHtml("view/fc7lc/kjhistory.html");
            break;
        case 10043:
            jumpHtml("view/tcpl3/kjhistory.html");
            break;
        case 10044:
            jumpHtml("view/tcpl5/kjhistory.html");
            break;
        case 10045:
            jumpHtml("view/tc7xc/kjhistory.html");
            break;
        case 10047:
            jumpHtml("view/taiwanbg/twbg_kjhistory.html");
            break;
        case 10048:
            window.open("https://6hch.co/html/kaihistory.html");
            break;
        case 10051:
            window.open("https://6hch.co/html/smSixFast.html");
            break;
        case 10052:
            jumpHtml("view/kuai3_jisu/kuai3index_history.html");
            break;
        case 10076:
            jumpHtml("view/kuai3_sg/kuai3index_history.html");
            break;
        case 10053:
            jumpHtml("view/klsf_jisu/klsf_kjhistory.html");
            break;
        case 10054:
            jumpHtml("view/kl8_jisu/bjkl8_kjhistory.html");
            break;
        case 10055:
            jumpHtml("view/shiyix5_jisu/kjhistory.html");
            break;
        case 10056:
            jumpHtml("view/tencent_ffc/ssc_kjhistory.html");
            break;
        case 10070:
            jumpHtml("view/twBig_lottery/lottery_index.html");
            break;
        case 10071:
            jumpHtml("/view/twTaiwan_powerColor/power_index.html");
            break;
        case 10072:
            jumpHtml("/view/tw_539/Today539_index.html");
            break;
        case 10073:
            jumpHtml("view/kl8/kl8_kjhistory.html");
            break;
        case 10074:
            jumpHtml("view/PC_egxy28/PC_egxy28_kjhistory.html");
            break;
        case 10077:
            jumpHtml("view/uklotto5/ssc_kjhistory.html");
            break;
        case 10078:
            jumpHtml("view/uklotto8/klsf_kjhistory.html");
            break;
        case 10079:
            jumpHtml("view/uklotto10/pk10kai_history.html");
            break;
        case 10080:
            jumpHtml("view/uklotto20/aozxy20_kjhistory.html");
            break;
        case 10081:
            jumpHtml("view/SpeedPcEgg/index_history.html");
            break;
        case 10082:
            jumpHtml("view/sgHappy8/aozxy20_kjhistory.html");
            break;
        case 10083:
            jumpHtml("view/sgHappy10/index_history.html");
            break;
        case 10084:
            jumpHtml("view/sg11x5/index_history.html")
    }
}

function jumpHtml(e) {
    window.open(config.jump() + "" + e)
}

function operatorTime(e, i) {
    var t = e.replace("-", "/"), i = i.replace("-", "/");
    return t = t.replace("-", "/"), i = i.replace("-", "/"), (new Date(t).getTime() - new Date(i).getTime()) / 1e3
}

var env = "productionEnv", config = {
    publicUrl: "http://kjwapi.xypv1.com/api/",
    publicUrl_six: "",
    wwwUrl: "",
    ifdebug: !1,
    listTime: 2e3,
    startTime: 1e3,
    ifScalse: $("html").width() / 1125,
    offLine: "",
    path: function () {
        var e = window.location.href, i = "https" == e.split(":")[0] ? "https" : "http";
        return config.ifdebug ? i + "://" + e.split("/")[2] + "/168/168_kaiTransfer1/view/" : -1 != e.split("/")[2].indexOf("192") ? i + "://" + e.split("/")[2] + "/168/168_kaiTransfer1/view/" : i + "://" + e.split("/")[2] + "/view/"
    },
    ym: function () {
        var e = window.location.search.split("?")[1];
        return "" == e || void 0 == e ? "?" + config.wwwUrl.split("//")[1] : "?" + e
    },
    ymL: function () {
        var e = window.location.search.split("?");
        return "" == (e = e[e.length - 1]) || void 0 == e ? "?" + config.wwwUrl.split("//")[1] : "?" + e
    },
    jump: function () {
        var e = window.location.search.split("?");
        return e = e[e.length - 1], "" != window.location.port ? "//" + config.wwwUrl + "/" : "" == e || void 0 == e ? "//" + config.wwwUrl + "/" : -1 != e.indexOf("168") ? "//" + e + "/" : "//" + config.wwwUrl + "/"
    },
    logo: function () {
        var e = window.location.search.split("?")[1];
        return void 0 == e ? config.wwwUrl : "//" + e
    }
};
"stagingEnv" == env && (config.publicUrl = "http://staging-api2-168.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/");
var oldLog = console.log;
console.log = function () {
    config.ifdebug && oldLog.apply(console, arguments)
};
var constant = {
    pk10: {totalIssue: 179},
    cqssc: {totalIssue: 120},
    tjssc: {totalIssue: 84},
    xjssc: {totalIssue: 96},
    gdklsf: {totalIssue: 84},
    syydj: {totalIssue: 78},
    gdsyxw: {totalIssue: 84},
    jsks: {totalIssue: 82},
    xync: {totalIssue: 97},
    txffc: {totalIssue: 1440}
}, lotCode = {
    pk10: 10001,
    jisusaiche: 10037,
    cqssc: 10002,
    xyssc: 10059,
    happyCZ: 10060,
    cqqxc: 10050,
    tjssc: 10003,
    xjssc: 10004,
    jisussc: 10036,
    gdklsf: 10005,
    gdsyxw: 10006,
    gxklsf: 10038,
    jsksan: 10007,
    sdsyydj: 10008,
    cqxync: 10009,
    aozxy5: 10010,
    aozxy8: 10011,
    aozxy10: 10012,
    aozxy20: 10013,
    bjkl8: 10014,
    kl8: 10073,
    twbg: 10047,
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
    fcssq: 10039,
    cjdlt: 10040,
    fcsd: 10041,
    fcqlc: 10042,
    pailie3: 10043,
    pailie5: 10044,
    qxc: 10045,
    egxy28: 10046,
    egxynew28: 10074,
    jisuft: 10035,
    xingyft: 10057,
    sgAirship: 10058,
    jisuksan: 10052,
    shft: 10061,
    gzft: 10062,
    gsft: 10063,
    tw_5fencai: 10064,
    jisuklsf: 10053,
    jisukl8: 10054,
    jisuef: 10055,
    tw_dlt: 10070,
    tw_wlc: 10071,
    tw_jc539: 10072,
    sgssc: 10075,
    sgk3: 10076,
    ukLotto5: 10077,
    ukLotto8: 10078,
    ukLotto10: 10079,
    ukLotto20: 10080,
    speedPcEgg: 10081,
    sgHappy8: 10082,
    sgHappy10: 10083,
    sg11x5: 10084
};
config.formatDate = function (e) {
    e || (e = new Date);
    var i = e.getFullYear(), t = e.getMonth() + 1;
    t = t < 10 ? "0" + t : t;
    var a = e.getDate();
    return a = a < 10 ? "0" + a : a, i + "-" + t + "-" + a
}, $(function () {
    jumpBox()
});
var ifopen = !1;
