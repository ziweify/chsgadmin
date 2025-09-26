function funshowQishu() {
    $("#showQishubox").css({height: "100%", top: "0"}), $("html,body").css({overflow: "hidden"})
}

function cancelQishu() {
    $("#showQishubox").css({height: "0", top: "-100%"}), $("html,body").css({overflow: "visible"})
}

function funshowcaikind() {
    $("#caikindBox").css({height: "100%", top: "0"}), $("html,body").css({overflow: "hidden"})
}

function backCaikind() {
    $("#caikindBox").css({height: "0", top: "-100%"}), $("html,body").css({overflow: "visible"})
}

function jumpHtml(t) {
    window.open(t)
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
!function () {
    var t = "number" == typeof window.orientation && "object" === _typeof(window.onorientationchange);
    window.addEventListener("DOMContentLoaded", function () {
        document.body.parentNode;
        var i, e = function () {
            t && (i = window.orientation)
        };
        t ? window.addEventListener("orientationchange", e, !1) : window.addEventListener("resize", e, !1), e()
    }, !1)
}();
var method = {}, ifishad = !1, datas = {isOpen: 1, count: 2};
if (null != localStorage.getItem("checkVal")) {
    czliveValue = JSON.parse(localStorage.getItem("checkVal"));
    var chedli = $("#caikindBox ul li");
    $(chedli).each(function (t) {
        -1 != czliveValue.indexOf(1 * $(this).attr("value")) && $(this).addClass("czListBg")
    })
} else var czliveValue = [];
var ifkai = !0;
$(function () {
    ifishad = !0, method.ajax(datas), method.initAjax(datas), $("#cakClass").on("touchstart", function () {
        tools.openAllCz(!0)
    }), $("#cZList .backbtn").on("touchstart", "span", function () {
        tools.openAllCz(!1), bodyHtmlvis()
    }), $(".headTitle").find("div").on("click", function () {
        $(this).addClass("checkyellowbl").siblings("div").removeClass();
        var t = $("#qishuNum").text();
        datas.count = t, $(this).find("span i").css({width: "0"}), $(this).find("span i").animate({width: "100%"}, 300), "unopen" == $(this).attr("id") ? (ifkai = !1, datas.isOpen = ifkai ? "1" : "0", $(".kaiqisho").text("连续未开期数"), method.ajax(datas), $("#ifshowkaino").removeClass("displaynone").addClass("displayblock"), $("#ifshowkaiyes").removeClass("displayblock").addClass("displaynone")) : ($(".kaiqisho").text("连开期数"), ifkai = !0, datas.isOpen = ifkai ? "1" : "0", method.ajax(datas), $("#ifshowkaino").removeClass("displayblock").addClass("displaynone"), $("#ifshowkaiyes").removeClass("displaynone").addClass("displayblock"))
    }), $("#qishuNum").on("click", function () {
        funshowQishu()
    }), $("#qsCancel").on("click", function () {
        cancelQishu()
    }), $("#qishuBox ul").find("li").on("click", function () {
        $(this).addClass("checkedli").siblings().removeClass("checkedli");
        var t = $(this).attr("value");
        $("#qishuNum").text(t), cancelQishu(), datas.count = t, datas.isOpen = ifkai ? "1" : "0", method.ajax(datas)
    }), $("#choseCaiName").on("click", function () {
        $(this).blur(), funshowcaikind()
    }), $("#backCaikind").on("click", function () {
        backCaikind();
        var t = $("#caikindBox ul .czListBg");
        czliveValue = [];
        for (var i = 0; i < t.length; i++) czliveValue.push(1 * t[i].attributes[0].value);
        localStorage.setItem("checkVal", JSON.stringify(czliveValue)), method.funshowCaiShow(czliveValue)
    }), $("#caikindBox").find("ul").find("li").on("click", function () {
        $(this).hasClass("czListBg") ? $(this).removeClass("czListBg") : $(this).addClass("czListBg")
    }), $(".rmc_checkall").on("click", function () {
        var t = $(".rmc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        })
    }), $(".rmc_cancel").on("click", function () {
        var t = $(".rmc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        })
    }), $(".sgc_checkall").on("click", function () {
        var t = $(".sgc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        })
    }), $(".sgc_cancel").on("click", function () {
        var t = $(".sgc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        })
    }), $(".jisuc_checkall").on("click", function () {
        var t = $(".jisuc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        })
    }), $(".jisuc_cancel").on("click", function () {
        var t = $(".jisuc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        })
    }), $(".trc_checkall").on("click", function () {
        var t = $(".trc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        })
    }), $(".trc_cancel").on("click", function () {
        var t = $(".trc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        })
    }), $(".gpc_checkall").on("click", function () {
        var t = $(".gpc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        })
    }), $(".gpc_cancel").on("click", function () {
        var t = $(".gpc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        })
    }), $(".jwc_checkall").on("click", function () {
        var t = $(".jwc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        })
    }), $(".jwc_cancel").on("click", function () {
        var t = $(".jwc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        })
    }), $(".qgc_checkall").on("click", function () {
        var t = $(".qgc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") || $(this).addClass("czListBg")
        })
    }), $(".qgc_cancel").on("click", function () {
        var t = $(".qgc_listBox").find(".czList_item>li");
        $(t).each(function () {
            $(this).hasClass("czListBg") && $(this).removeClass("czListBg")
        })
    })
});
var intevVal = {};
method.initAjax = function (t) {
    clearInterval(intevVal);
    var i = setInterval(function () {
        method.ajax(t)
    }, 4e3);
    intevVal.interV = i
}, method.ajax = function (t) {
    $.ajax({
        url: config.publicUrl + "dailyDragon/queryDailyDragonList.do",
        type: "GET",
        data: t,
        beforeSend: function () {
        },
        success: function (i) {
            method.createHtmlList(i, t)
        },
        error: function (t) {
            config.ifdebug
        }
    })
}, method.createHtmlList = function (t, i) {
    var e = null;
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? e = JSON.parse(t) : (e = JSON.stringify(t), e = JSON.parse(e));
    "1" == i.isOpen ? $("#kaiYes").find("tbody").empty() : $("#kaiNo").find("tbody").empty(), 0 == e.errorCode && 0 == e.result.businessCode && (e = e.result.data, $(e).each(function () {
        if (-1 != config.offLine.indexOf(this.lotCode)) return !0;
        var t = "", e = method.parseObj(this.beadSource);
        cltj = "<a  href='javascript:void(0)' onclick='method.getUrl(" + this.lotCode + "," + e.rank + "," + e.type + ")'>查看</a>", "" == czliveValue || void 0 == czliveValue ? t += '<tr class="' + this.lotCode + '"><td>' + this.lotteryName + "</td><td>" + this.location + "</td><td>" + this.currentDragon + "</td><td>" + cltj + "</td></tr>" : -1 != czliveValue.indexOf(1 * this.lotCode) ? t += '<tr class="' + this.lotCode + '"><td>' + this.lotteryName + "</td><td>" + this.location + "</td><td>" + this.currentDragon + "</td><td>" + cltj + "</td></tr>" : t += '<tr class="' + this.lotCode + '" style="display:none"><td>' + this.lotteryName + "</td><td>" + this.location + "</td><td>" + this.currentDragon + "</td><td>" + cltj + "</td></tr>", "1" == i.isOpen ? $("#kaiYes").find("tbody").append(t) : $("#kaiNo").find("tbody").append(t)
    }))
}, method.parseObj = function (t) {
    var i = null;
    return "object" != (void 0 === t ? "undefined" : _typeof(t)) ? i = JSON.parse(t) : (i = JSON.stringify(t), i = JSON.parse(i)), i
}, method.funshowCaiShow = function (t) {
    if ("" == t || void 0 == t) return !1;
    if ("unopen" == $(".checkyellowbl").attr("id")) i = $("#ifshowkaino").find("tbody").find("tr"); else if ("contopenKai" == $(".checkyellowbl").attr("id")) var i = $("#ifshowkaiyes").find("tbody").find("tr");
    $(i).each(function (i) {
        -1 != t.indexOf(1 * $(this).attr("class")) ? $(this).css("display", "table-row") : $(this).css("display", "none")
    })
}, method.getUrl = function (t, i, e) {
    switch (1 * t) {
        case 10001:
            jumpHtml("../pk10/index.html");
            break;
        case 10002:
            jumpHtml("../ssc_cq/index.html");
            break;
        case 10059:
            jumpHtml("../shishicai_xy/index.html");
            break;
        case 10003:
            jumpHtml("../ssc_tj/index.html");
            break;
        case 10064:
            jumpHtml("../tw_5fencai/index.html");
            break;
        case 10004:
            jumpHtml("../ssc_xj/index.html");
            break;
        case 10005:
            jumpHtml("../gdklsf/index.html");
            break;
        case 10006:
            jumpHtml("../11_gdsyxw/index.html");
            break;
        case 10007:
            jumpHtml("../jsks/index.html");
            break;
        case 10008:
            jumpHtml("../11_syydj/index.html");
            break;
        case 10009:
            jumpHtml("../xync/index.html");
            break;
        case 10010:
            jumpHtml("../aozxy5/index.html");
            break;
        case 10011:
            jumpHtml("../aozxy8/index.html");
            break;
        case 10012:
            jumpHtml("../aozxy10/index.html");
            break;
        case 10013:
            jumpHtml("../aozxy20/index.html");
            break;
        case 10014:
            jumpHtml("../bjkl8/index.html");
            break;
        case 10015:
            jumpHtml("../11_jxef/index.html");
            break;
        case 10016:
            jumpHtml("../11_jsef/index.html");
            break;
        case 10017:
            jumpHtml("../11_ahef/index.html");
            break;
        case 10018:
            jumpHtml("../11_shef/index.html");
            break;
        case 10019:
            jumpHtml("../11_lnef/index.html");
            break;
        case 10020:
            jumpHtml("../11_hbef/index.html");
            break;
        case 10022:
            jumpHtml("../11_gxef/index.html");
            break;
        case 10023:
            jumpHtml("../11_jlef/index.html");
            break;
        case 10024:
            jumpHtml("../11_nmgef/index.html");
            break;
        case 10025:
            jumpHtml("../11_zjef/index.html");
            break;
        case 10026:
            jumpHtml("../k3_gxft/index.html");
            break;
        case 10027:
            jumpHtml("../k3_jlft/index.html");
            break;
        case 10028:
            jumpHtml("../k3_hebft/index.html");
            break;
        case 10029:
            jumpHtml("../k3_nmgft/index.html");
            break;
        case 10030:
            jumpHtml("../k3_ahft/index.html");
            break;
        case 10031:
            jumpHtml("../k3_fjft/index.html");
            break;
        case 10032:
            jumpHtml("../k3_hubft/index.html");
            break;
        case 10033:
            jumpHtml("../k3_bjft/index.html");
            break;
        case 10061:
            jumpHtml("../k3_shks/index.html");
            break;
        case 10062:
            jumpHtml("../k3_gzks/index.html");
            break;
        case 10063:
            jumpHtml("../k3_gsks/index.html");
            break;
        case 10034:
            jumpHtml("../tianjinklsf/index.html");
            break;
        case 10035:
            jumpHtml("../xyft/index.html");
            break;
        case 10057:
            jumpHtml("../xingyft/index.html");
            break;
        case 10058:
            jumpHtml("../sgAirship/index.html");
            break;
        case 10036:
            jumpHtml("../ssc_jisu/index.html");
            break;
        case 10037:
            jumpHtml("../jisusaiche/index.html");
            break;
        case 10038:
            jumpHtml("../gxklsf/index.html");
            break;
        case 10041:
            jumpHtml("../fc3D/index.html");
            break;
        case 10043:
            jumpHtml("../tcpl3/index.html");
            break;
        case 10052:
            jumpHtml("../k3_jisu/index.html");
            break;
        case 10053:
            jumpHtml("../klsf_jisu/index.html");
            break;
        case 10054:
            jumpHtml("../jisukl8/index.html");
            break;
        case 10055:
            jumpHtml("../11_jisuef/index.html");
            break;
        case 10056:
            jumpHtml("../ffc_tencent/index.html");
            break;
        case 10060:
            jumpHtml("../happyCZ/index.html");
            break;
        case 10075:
            jumpHtml("../shishicai_sg/index.html");
            break;
        case 10076:
            jumpHtml("../k3_sg/index.html");
            break;
        case 10077:
            jumpHtml("../ukLotto5/index.html");
            break;
        case 10078:
            jumpHtml("../ukLotto8/index.html");
            break;
        case 10079:
            jumpHtml("../ukLotto10/index.html");
            break;
        case 10080:
            jumpHtml("../ukLotto20/index.html");
            break;
        case 10082:
            jumpHtml("../sgHappy8/index.html");
            break;
        case 10083:
            jumpHtml("../sgHappy10/index.html");
            break;
        case 10084:
            jumpHtml("../sg11x5/index.html")
    }
    return ""
};