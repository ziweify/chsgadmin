function ajaxRequst(e, t) {
    indexObj.ajaxSsc(e, "#cqSsc")
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
    } else if ("lhh" == e) switch (1 * t) {
        case 0:
            return "龙";
        case 1:
            return "虎";
        case 2:
            return "和"
    } else if ("qiu" == e) switch (1 * t) {
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 6:
            return "总和";
        case 12:
            return "龙虎"
    } else if ("qiuonebig" == e) switch (1 * t) {
        case 1:
            return "第一名";
        case 2:
            return "第二名";
        case 3:
            return "第三名";
        case 4:
            return "第四名";
        case 5:
            return "第五名";
        case 11:
            return "总和";
        case 12:
            return "龙虎"
    } else if ("lai" == e) switch (1 * t) {
        case 1:
            return "总来";
        case 0:
            return "没来"
    } else if ("qiuqiu" == e) switch (1 * t) {
        case 1:
            return "一";
        case 2:
            return "二";
        case 3:
            return "三";
        case 4:
            return "四";
        case 5:
            return "五";
        case 11:
            return "总和"
    } else if ("qiuqiu1" == e) switch (1 * t) {
        case 1:
            return "第一球";
        case 2:
            return "第二球";
        case 3:
            return "第三球";
        case 4:
            return "第四球";
        case 5:
            return "第五球";
        case 11:
            return "总和"
    } else if ("stated" == e) switch (1 * t) {
        case 1:
            return "单";
        case 2:
            return "双";
        case 3:
            return "大";
        case 4:
            return "小";
        case 5:
            return "龙";
        case 6:
            return "虎";
        case 7:
            return "和"
    }
}

function formatDate(e) {
    var t = e.getFullYear(), r = e.getMonth() + 1;
    r = r < 10 ? "0" + r : r;
    var a = e.getDate();
    return a = a < 10 ? "0" + a : a, t + "-" + r + "-" + a
}

function creatDataHead(e, t) {
    publicmethod.insertHeadlhc(e, t);//, tools.setTimefun_ssc()
}

$(function () {
    $("#headdivbox").load("../public/head.html", function () {
        pupajax(), config.ifdebug
    }), $("#fooderbox").load("../public/fooder.html", function () {
        config.ifdebug
    }), tools.showExplain(), ajaxRequst("", boxid)
});
var urlbublic = config.publicUrl, lotCode = 10051, boxid = "#cqSsc", indexObj = new Object;
indexObj.ajaxSsc = function (e, t) {
    var e = void 0 == e ? "" : e, r = !1;
    $.ajax({
        url: urlbublic + "speedSix/findSpeedSixInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: lotCode},
        beforeSend: function () {
            void 0 == animateID[t] && animateMethod.sscAnimate(t)
        },
        success: function (r) {
            try {
                creatDataHead(r, t), clearInterval(animateID[t]), delete animateID[t]
            } catch (r) {
                setTimeout(function () {
                    ajaxRequst(e, t)
                }, "1000"), config.ifdebug
            }
        },
        error: function (a) {
            setTimeout(function () {
                ajaxRequst(e, t)
            }, "1000"), r = !0, config.ifdebug
        },
        complete: function (a, n) {
            (r = !1) || "timeout" == n && setTimeout(function () {
                ajaxRequst(e, t)
            }, "1000")
        }
    })
};