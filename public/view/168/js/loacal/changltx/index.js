function jumpHtml(i) {
    window.open(i)
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (i) {
    return typeof i
} : function (i) {
    return i && "function" == typeof Symbol && i.constructor === Symbol && i !== Symbol.prototype ? "symbol" : typeof i
};
$(function () {
    $("#headdivbox").load("../public/head.html", function () {
        pupajax(), config.ifdebug
    }), $("#fooderbox").load("../public/fooder.html", function () {
        config.ifdebug
    }), indexObj.init()
});
var indexObj = new Object;
indexObj.init = function () {
    //var i = filterRemoveLotteryList(lotteryList.SGK3, lotteryRemoveList);
    $(".czList_only").find(".czListBg").each(function () {
        $(this.parentElement.parentElement).show()
    }),  $(".czList_only>li").on("click", function () {
        $(this).hasClass("czListBg") ? $(this).removeClass("czListBg") : $(this).addClass("czListBg"), indexObj.testMenu()
    }), $(".czList_only>li").hover(function () {
        $(this).hasClass("czListBg") && $(this).addClass("hoverli")
    }, function () {
        $(this).hasClass("hoverli") && $(this).removeClass("hoverli")
    }), $(".menu-title").on("click", function () {
        $(this.nextElementSibling).slideToggle(), $(this).find("i").hasClass("topshowList") ? $(this).find("i").removeClass().addClass("bottomshowList") : $(this).find("i").removeClass().addClass("topshowList")
    }), $("#checkAll").on("click", function () {
        $(".czList_only>li").each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        }), indexObj.testMenu()
    }), $("#cancelAll").on("click", function () {
        $(".czList_only>li").each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        }), indexObj.testMenu()
    }), $("#display>li").on("hover", function () {
        $(this).hasClass("liactiveBG") || $(this).addClass("liactiveBG").siblings().removeClass("liactiveBG"), "kaiLi" == $(this).attr("id") ? ($("#kaiYes").show(), $("#kaiYes6").show(), $("#kaiNo").hide(), $("#kaiNo6").hide()) : ($("#kaiNo").show(), $("#kaiNo6").show(), $("#kaiYes").hide(), $("#kaiYes6").hide())
    }), $("#soundsCtrl").on("click", function () {
        $(this).find("i").hasClass("iChecked") ? $(this).find("i").removeClass("iChecked") : $(this).find("i").addClass("iChecked")
    }), $("#selectNum").on("change", function () {
        datasy.count = $(this).val(), datasn.count = $(this).val(), datas6.count = $(this).val(), indexObj.ajax(url, datasy), indexObj.ajax(url, datasn)
    }), indexObj.ajax(url, datasy), indexObj.ajax(url, datasn), indexObj.initAjax(url, datasy, datasn)
};
var datasy = {hot: 1, isOpen: 1, count: 2}, datasn = {hot: 1, isOpen: -1, count: 2},
    datas6 = {hot: 0, isOpen: 1, count: 1}, intevVal = {},
    url = config.publicUrl + "dailyDragon/queryDailyDragonList.do?";
indexObj.initAjax = function (i, e, t) {
    clearInterval(intevVal.interV);
    var a = !0, s = setInterval(function () {
        a ? (indexObj.ajax(i, e), a = !1) : (indexObj.ajax(i, t), a = !0)
    }, 4e3);
    intevVal.interV = s
}, indexObj.ajax = function (i, e, t) {
    $.ajax({
        type: "post", url: i, data: e, beforeSend: function () {
        }, success: function (i) {
            "6" == t ? indexObj.loadList6(e, i) : indexObj.loadList(e, i), indexObj.testMenu()
        }, error: function (i) {
        }
    })
}, indexObj.loadMenu = function (i) {
    indexObj.parseObj()
}, indexObj.testMenu = function () {
    $("#kaiDetial").find("tbody").find("tr").hide(), $(".czList_only").find(".czListBg").each(function (i) {
        $("." + $(this).attr("id")).show()
    })
}, indexObj.loadList = function (i, e) {
    var e = indexObj.parseObj(e), t = "", a = !1;
    "1" == i.isOpen ? $("#kaiYes").find("tbody").empty() : $("#kaiNo").find("tbody").empty(), "0" == e.errorCode && ($(e.result.data).each(function () {
        var e, s, l, m = indexObj.parseObj(this.beadSource);
        e = "<a  href='javascript:void(0)' onclick='indexObj.getUrl(true," + this.lotCode + "," + m.rank + "," + m.type + ")'>查看</a>", s = "<a  href='javascript:void(0)' onclick='indexObj.getUrl(false," + this.lotCode + "," + m.rank + "," + m.type + ")'>查看</a>", t = "<tr class='" + this.lotCode + "'><td>" + this.lotteryName + "</td><td>" + this.location + "</td><td>" + this.currentDragon + "</td><td>" + e + "</td></tr>", "1" == i.isOpen ? $("#kaiYes").find("tbody").append(t) : $("#kaiNo").find("tbody").append(t), l = this.lotCode, $(".czList_only").find(".czListBg").each(function () {
            l == $(this).attr("id") && (a = !0)
        })
    }), a && $("#soundsCtrl").find("i").hasClass("iChecked") && document.getElementById("duSound").play())
}, indexObj.loadList6 = function (i, e) {
    var e = indexObj.parseObj(e), t = "", a = !1;
    "1" == i.isOpen ? $("#kaiYes6").find("tbody").empty() : $("#kaiNo6").find("tbody").empty(), "0" == e.errorCode && ($(e.result.data).each(function () {
        var e, s, l;
        e = "<a  href='javascript:void(0)' onclick='jumpHtml(\"" + this.beadSource + "\")'>查看</a>", s = "<a  href='javascript:void(0)' onclick='jumpHtml(\"" + this.dragonSource + "\")'>查看</a>", t = "<tr class='" + this.lotCode + "'><td  width='222px'>" + this.lotteryName + "</td><td>" + this.location + "</td><td  width='120px'>" + this.currentDragon + "</td><td  width='50px'>" + e + "</td><td  width='100px'>" + s + "</td></tr>", "1" == i.isOpen ? $("#kaiYes6").find("tbody").append(t) : $("#kaiNo6").find("tbody").append(t), l = this.lotCode, $(".czList_only").find(".czListBg").each(function () {
            l == $(this).attr("id") && (a = !0)
        })
    }), a && $("#soundsCtrl").find("i").hasClass("iChecked") && document.getElementById("duSound").play())
}, indexObj.parseObj = function (i) {
    var e = null;
    return "object" != (void 0 === i ? "undefined" : _typeof(i)) ? e = JSON.parse(i) : (e = JSON.stringify(i), e = JSON.parse(e)), e
}, indexObj.getUrl = function (i, e, t, a) {
    if (i) switch (1 * e) {
        case 20032:
            jumpHtml("/view/shishicai_jisu/ssc_index.html?code=20032");
            break;
        case 20035:
            jumpHtml("/view/kuai3_jisu/kuai3_index.html?code=20035");
            break;
        case 20036:
            jumpHtml("/view/taiwanbg/twbg_index.html?code=20036");
            break;
        case 20034:
            jumpHtml("/view/klsf_jisu/klsf_index.html?code=20034");
            break;
        case 20033:
            jumpHtml("/view/shiyix5_jisu/index.html?code=20033");
            break;
        case 20031:
            jumpHtml("/view/jisusaiche/pk10kai.html?code=20031");
            break;
        case 10001:
            jumpHtml("../PK10/pk10kai_luzhufxzh.html");
            break;
        case 10002:
            jumpHtml("../shishicai_cq/ssc_luzhufenxizh.html");
            break;
        case 10059:
            jumpHtml("/view/shishicai_jisu/ssc_index.html?code=10059");
            break;
        case 10060:
            jumpHtml("../happyCZ/ssc_luzhufenxizh.html");
            break;
        case 10007:
            jumpHtml("../kuai3/kuai3_zonghelz.html");
            break;
        case 10004:
            jumpHtml("../shishicai_xj/ssc_luzhufenxizh.html");
            break;
        case 10038:
            jumpHtml("../klsf_gaungxi/klsf_zonghelzfx.html");
            break;
        case 10003:
            jumpHtml("../shishicai_tj/ssc_luzhufenxizh.html");
            break;
        case 10064:
            jumpHtml("/view/shishicai_jisu/ssc_index.html?code=10064");
            break;
        case 10075:
            jumpHtml("/view/shishicai_jisu/ssc_index.html?code=10075");
            break;
        case 10076:
            jumpHtml("/view/kuai3_jisu/kuai3_index.html?code=10076");
            break;
        case 10037:
            jumpHtml("/view/jisusaiche/pk10kai.html?code=10037");
            break;
        case 10035:
            jumpHtml("/view/jisuft/pk10kai.html?code=10035");
            break;
        case 10057:
            jumpHtml("/view/jisuft/pk10kai.html?code=10057");
            break;
        case 10058:
            jumpHtml("/view/jisuft/pk10kai.html?code=10058");
            break;
        case 10036:
            jumpHtml("/view/shishicai_jisu/ssc_index.html?code=10036");
            break;
        case 10052:
            jumpHtml("/view/kuai3_jisu/kuai3_index.html?code=10052");
            break;
        case 10053:
            jumpHtml("/view/klsf_jisu/klsf_index.html?code=10053");
            break;
        case 10055:
            jumpHtml("/view/shiyix5_jisu/index.html?code=10055");
            break;
        case 10054:
            jumpHtml("/view/kl8_jisu/bjkl8_index.html?code=10054");
            break;
        case 10082:
            jumpHtml("/view/kl8_jisu/bjkl8_index.html?code=10082");
            break;
        case 10083:
            jumpHtml("/view/klsf_jisu/klsf_index.html?code=10083");
            break;
        case 10084:
            jumpHtml("/view/shiyix5_jisu/index.html?code=10084");
            break;
        case 10010:
            jumpHtml("/view/shishicai_jisu/ssc_index.html?code=10010");
            break;
        case 10011:
            jumpHtml("/view/klsf_jisu/klsf_index.html?code=10011");
            break;
        case 10012:
            jumpHtml("/view/jisusaiche/pk10kai.html?code=10012");
            break;
        case 10013:
            jumpHtml("/view/taiwanbg/twbg_index.html?code=10013");
            break;
        case 10077:
            jumpHtml("../uklotto5/ssc_zhonghefx.html");
            break;
        case 10078:
            jumpHtml("../uklotto8/klsf_zonghelzfx.html");
            break;
        case 10079:
            jumpHtml("../uklotto10/pk10kai_luzhufxzh.html");
            break;
        case 10080:
            jumpHtml("../uklotto20/aozxy20_luzhufx.html");
            break;
        case 10041:
            jumpHtml("../fc3D/kjhistory.html");
            break;
        case 10043:
            jumpHtml("../tcpl3/kjhistory.html");
            break;
        case 10008:
            jumpHtml("../shiyix5_sd/zonghelzfx.html");
            break;
        case 10009:
            jumpHtml("../cqnc/klsf_zonghelzfx.html");
            break;
        case 10005:
            jumpHtml("../klsf/klsf_zonghelzfx.html");
            break;
        case 10034:
            jumpHtml("../klsf_tianjin/klsf_zonghelzfx.html");
            break;
        case 10006:
            jumpHtml("../shiyix5_gd/zonghelzfx.html");
            break;
        case 10014:
            jumpHtml("../beijinkl8/bjkl8_luzhufx.html");
            break;
        case 10026:
            jumpHtml("../kuai3_guangxi/kuai3_zonghelz.html");
            break;
        case 10027:
            jumpHtml("../kuai3_jiling/kuai3_zonghelz.html");
            break;
        case 10028:
            jumpHtml("../kuai3_hebei/kuai3_zonghelz.html");
            break;
        case 10029:
            jumpHtml("../kuai3_neimenggu/kuai3_zonghelz.html");
            break;
        case 10030:
            jumpHtml("../kuai3_anhui/kuai3_zonghelz.html");
            break;
        case 10031:
            jumpHtml("../kuai3_fujian/kuai3_zonghelz.html");
            break;
        case 10032:
            jumpHtml("../kuai3_hubei/kuai3_zonghelz.html");
            break;
        case 10033:
            jumpHtml("../kuai3_beijing/kuai3_zonghelz.html");
            break;
        case 10061:
            jumpHtml("../kuai3_shft/kuai3_zonghelz.html");
            break;
        case 10062:
            jumpHtml("../kuai3_gzft/kuai3_zonghelz.html");
            break;
        case 10063:
            jumpHtml("../kuai3_gsft/kuai3_zonghelz.html");
            break;
        case 10015:
            jumpHtml("../shiyix5_jiangxi/index.html");
            break;
        case 10016:
            jumpHtml("../shiyix5_jiangsu/index.html");
            break;
        case 10017:
            jumpHtml("../shiyix5_anhui/index.html");
            break;
        case 10018:
            jumpHtml("../shiyix5_shanghai/index.html");
            break;
        case 10019:
            jumpHtml("../shiyix5_liaoning/index.html");
            break;
        case 10020:
            jumpHtml("../shiyix5_hubei/index.html");
            break;
        case 10022:
            jumpHtml("../shiyix5_guangxi/index.html");
            break;
        case 10023:
            jumpHtml("../shiyix5_jiling/index.html");
            break;
        case 10024:
            jumpHtml("../shiyix5_neimenggu/index.html");
            break;
        case 10025:
            jumpHtml("../shiyix5_zhejiang/index.html");
            break;
        case 10056:
            jumpHtml("../tencent_ffc/ssc_zhonghefx.html")
    } else switch (1 * e) {
        case 10001:
            jumpHtml("../PK10/pk10kai.html");
            break;
        case 10002:
            jumpHtml("../shishicai_cq/ssc_index.html");
            break;
        case 10059:
            jumpHtml("../shishicai_xy/ssc_index.html");
            break;
        case 10060:
            jumpHtml("../happyCZ/ssc_index.html");
            break;
        case 10007:
            jumpHtml("../kuai3/kuai3_index.html");
            break;
        case 10004:
            jumpHtml("../shishicai_xj/ssc_index.html");
            break;
        case 10038:
            jumpHtml("../klsf_gaungxi/klsf_index.html");
            break;
        case 10003:
            jumpHtml("../shishicai_tj/ssc_index.html");
            break;
        case 10064:
            jumpHtml("../tw_5fencai/ssc_index.html");
            break;
        case 10037:
            jumpHtml("/view/jisusaiche/pk10kai.html?code=10037");
            break;
        case 10035:
            jumpHtml("../jisuft/pk10kai.html");
            break;
        case 10057:
            jumpHtml("../xingyft/pk10kai.html");
            break;
        case 10058:
            jumpHtml("/view/jisuft/pk10kai.html?code=10058");
            break;
        case 10036:
            jumpHtml("../shishicai_jisu/ssc_index.html");
            break;
        case 10052:
            jumpHtml("../kuai3_jisu/kuai3_zonghelz.html");
            break;
        case 10053:
            jumpHtml("../klsf_jisu/klsf_index.html");
            break;
        case 10055:
            jumpHtml("../shiyix5_jisu/index.html");
            break;
        case 10054:
            jumpHtml("../kl8_jisu/bjkl8_index.html");
            break;
        case 10075:
            jumpHtml("/view/shishicai_jisu/ssc_index.html?code=10075");
            break;
        case 10076:
            jumpHtml("/view/kuai3_jisu/kuai3_index.html?code=10076");
            break;
        case 10041:
            jumpHtml("../fc3D/index.html");
            break;
        case 10043:
            jumpHtml("../tcpl3/index.html");
            break;
        case 10010:
            jumpHtml("../aozxy5/ssc_index.html");
            break;
        case 10011:
            jumpHtml("../aozxy8/klsf_index.html");
            break;
        case 10012:
            jumpHtml("../aozxy10/pk10kai.html");
            break;
        case 10013:
            jumpHtml("../aozxy20/aozxy20_index.html");
            break;
        case 10077:
            jumpHtml("../uklotto5/ssc_index.html");
            break;
        case 10078:
            jumpHtml("../uklotto8/klsf_index.html");
            break;
        case 10079:
            jumpHtml("../uklotto10/pk10kai.html");
            break;
        case 10080:
            jumpHtml("../uklotto20/aozxy20_index.html");
            break;
        case 10008:
            jumpHtml("../shiyix5_sd/index.html");
            break;
        case 10009:
            jumpHtml("../cqnc/index.html");
            break;
        case 10005:
            jumpHtml("../klsf/klsf_index.html");
            break;
        case 10034:
            jumpHtml("../klsf_tianjin/klsf_index.html");
            break;
        case 10006:
            jumpHtml("../shiyix5_gd/index.html");
            break;
        case 10014:
            jumpHtml("../beijinkl8/bjkl8_index.html");
            break;
        case 10026:
            jumpHtml("../kuai3_guangxi/kuai3_index.html");
            break;
        case 10027:
            jumpHtml("../kuai3_jiling/kuai3_index.html");
            break;
        case 10028:
            jumpHtml("../kuai3_hebei/kuai3_index.html");
            break;
        case 10029:
            jumpHtml("../kuai3_neimenggu/kuai3_index.html");
            break;
        case 10030:
            jumpHtml("../kuai3_anhui/kuai3_index.html");
            break;
        case 10031:
            jumpHtml("../kuai3_fujian/kuai3_index.html");
            break;
        case 10061:
            jumpHtml("../kuai3_shft/kuai3_index.html");
            break;
        case 10062:
            jumpHtml("../kuai3_gzft/kuai3_index.html");
            break;
        case 10063:
            jumpHtml("../kuai3_gsft/kuai3_index.html");
            break;
        case 10032:
            jumpHtml("../kuai3_hubei/kuai3_index.html");
            break;
        case 10033:
            jumpHtml("../kuai3_beijing/kuai3_index.html");
            break;
        case 10015:
            jumpHtml("../shiyix5_jiangxi/index.html");
            break;
        case 10016:
            jumpHtml("../shiyix5_jiangsu/index.html");
            break;
        case 10017:
            jumpHtml("../shiyix5_anhui/index.html");
            break;
        case 10018:
            jumpHtml("../shiyix5_shanghai/index.html");
            break;
        case 10019:
            jumpHtml("../shiyix5_liaoning/index.html");
            break;
        case 10020:
            jumpHtml("../shiyix5_hubei/index.html");
            break;
        case 10022:
            jumpHtml("../shiyix5_guangxi/index.html");
            break;
        case 10023:
            jumpHtml("../shiyix5_jiling/index.html");
            break;
        case 10024:
            jumpHtml("../shiyix5_neimenggu/index.html");
            break;
        case 10025:
            jumpHtml("../shiyix5_zhejiang/index.html");
            break;
        case 10056:
            jumpHtml("../tencent_ffc/ssc_zhonghefx.html");
            break;
        case 10082:
            jumpHtml("/view/kl8_jisu/bjkl8_index.html?code=10082");
            break;
        case 10083:
            jumpHtml("/view/klsf_jisu/klsf_index.html?code=10083");
            break;
        case 10084:
            jumpHtml("/view/shiyix5_jisu/index.html?code=10084")
    }
    return ""
};