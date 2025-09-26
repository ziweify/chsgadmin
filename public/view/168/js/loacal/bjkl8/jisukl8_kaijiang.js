function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
function ajaxRequst(e, t) {
    indexObj.ajaxSsc(e, t)
}

function typeOf(e, t) {
    if ("state" == e) switch (1 * t) {
        case 0:
            return "总和大小";
        case 1:
            return "总和单双";
        case 2:
            return "总和大小单双";
        case 3:
            return "前后和";
        case 4:
            return "单双和";
        case 5:
            return "五行"
    } else if ("dxh" == e) switch (1 * t) {
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
    } else if ("qhh" == e) switch (1 * t) {
        case-1:
            return "后多";
        case 0:
            return "前后和";
        case 1:
            return "前多"
    } else if ("dsd" == e) switch (1 * t) {
        case-1:
            return "双多";
        case 0:
            return "单双和";
        case 1:
            return "单多"
    } else if ("zhzh" == e) switch (1 * t) {
        case 1:
            return "总大单";
        case 2:
            return "总大双";
        case 3:
            return "总小单";
        case 4:
            return "总小双";
        case 5:
            return "总和"
    } else if ("wuxing" == e) switch (1 * t) {
        case 1:
            return "金";
        case 2:
            return "木";
        case 3:
            return "水";
        case 4:
            return "火";
        case 5:
            return "土"
    }
}

function formatDate(e) {
    var t = e.getFullYear(), a = e.getMonth() + 1;
    a = a < 10 ? "0" + a : a;
    var i = e.getDate();
    return i = i < 10 ? "0" + i : i, t + "-" + a + "-" + i
}

function creatDataHead(e, t) {
    publicmethod.insertHeadBjkl8(e, t), tools.setTimefun_bjkl8()
}
function initMenu(){
    $(".dhmenu").each(function(t){
        var hr = $(this).attr("href");
        $(this).attr("href",hr+"?code="+lotCode);
    });
    //视频
    var sr = $(".videocz").attr("src");
    $(".videocz").attr("src",sr+"?code="+lotCode);
}
$(function () {
    if(lotCode == null){window.location.href= '/'}
    lotCode = parseInt(lotCode);
    initMenu();
    $("#headdivbox").load("../public/head.html", function () {
        pupajax(), config.ifdebug
    }), $("#fooderbox").load("../public/fooder.html", function () {
        config.ifdebug
    }), $(".listheadrl span").live("click", function () {
        $(this).siblings().removeClass("checked"), $(this).addClass("checked");
        var e = $(this).attr("id"), t = $("#biaozxz .sinli:nth-child(4)"), a = $("#biaozxz .sinli:nth-child(5)");
        t.hasClass("checked") && t.removeClass("checked"), a.hasClass("checked") && a.removeClass("checked"), tabarr = [], $("#chakanchfb,#daxiaodsfb").find("li").removeClass("selected"), "today" == e ? (listData(getDateStr(0), ""), $(".jinri").text("今天"), $("#dateframe").find("input").val(getDateStr(0))) : "yesterday" == e ? (listData(getDateStr(-1), ""), $(".jinri").text(currentDay(getDateStr(-1))), $("#dateframe").find("input").val(getDateStr(-1))) : "qianday" == e ? (listData(getDateStr(-2), ""), $(".jinri").text(currentDay(getDateStr(-2))), $("#dateframe").find("input").val(getDateStr(-2))) : "thirty" == e ? listData("", "30") : "sixty" == e ? listData("", "60") : "ninety" == e && listData("", "90")
    }), tools.playVideo_BJKL8(), ajaxRequst("", boxid)
});
var boxid = "#klsf", urlbublic = config.publicUrl, lotCode = getParameterByName("code"), indexObj = new Object;
indexObj.ajaxSsc = function (e, t) {
    var e = void 0 == e ? "" : e, a = !1;
    $.ajax({
        url: urlbublic + "LuckTwenty/getBaseLuckTewnty.do?issue=" + e,
        type: "GET",
        data: {lotCode: lotCode},
        beforeSend: function () {
            $(t).find(".kajianhao li").each(function () {
                $(this).removeClass("numWeightblue"), $(this).removeClass("numOrange")
            }), void 0 == animateID[t] && animateMethod.sscAnimate(t)
        },
        success: function (a) {
            try {
                $(".gamename").text(a.result.data.lotName);
                $(".iconUrl").attr("src", a.result.data.iconUrl);
                //标题变更
                var title = $("title").text();
                title = title.replace('*',a.result.data.lotName);
                $("title").text(title);

                creatDataHead(a, t), clearInterval(animateID[t]), delete animateID[t]
            } catch (a) {
                setTimeout(function () {
                    ajaxRequst(e, t)
                }, "1000"), config.ifdebug
            }
        },
        error: function (i) {
            setTimeout(function () {
                ajaxRequst(e, t)
            }, "1000"), a = !0, config.ifdebug
        },
        complete: function (i, n) {
            (a = !1) || "timeout" == n && setTimeout(function () {
                ajaxRequst(e, t)
            }, "1000")
        }
    })
};