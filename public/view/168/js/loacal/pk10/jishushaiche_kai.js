function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
var urlbublic = config.publicUrl, lotCode = getParameterByName("code"), boxid = "#pk10", isfirthload = !0, ifopen = !1;
function iframe() {
    //$(".animate").find(".loading_jisusc").fadeOut("slow"),
    isfirthload && ( $(".animate iframe").contents().find(".container").hide(), $(".animate iframe").contents().find("#preloader").hide());
    var t = $(".animate").width(), e = $(".animate").height();
    two = -1 * ((414 - e) / 8.65 / 100 - .283), t <= 360 && $(".animate iframe").contents().find("html").css("left", "-2px"), t <= 325 && $(".animate iframe").contents().find("html").css("left", "-5px");
    var i = t / 1310;
    $(".animate iframe").contents().find(".container").css("zoom", i), $(".animate iframe").contents().find(".container").css({
        "-moz-transform": "scale(" + i + ")",
        "-moz-transform-origin": "top left"
    }), toolBoxs.isIE(), setTimeout(function () {
        $(".animate iframe").contents().find(".container").fadeIn("slow"), $(".animate iframe").contents().find("body").delay(350).css({overflow: "visible"})
    }, 500), $(".content").width(t + 16), toolBoxs.isIE() && $(".content").width(t + 18)
}

function ajaxRequst(t, e) {
    var t = void 0 == t ? "" : t, i = !1;
    $.ajax({
        url: urlbublic + "pks/getLotteryPksInfo.do?issue=" + t,
        type: "get",
        timeout: 6e4,
        asasync: !1,
        data: {lotCode: lotCode},
        beforeSend: function () {
            void 0 == animateID[e] && animateMethod.pk10OpenAnimate(e)
        },
        success: function (i) {
            try {
                $(".gamename").text(i.result.data.lotName);
                $(".iconUrl").attr("src", i.result.data.iconUrl);
                //标题变更
                var title = $("title").text();
                title = title.replace('*',i.result.data.lotName);
                $("title").text(title);
                
                if ("100002" == i.result.businessCode) throw new Error("error");
                creatDataHead(i, e), clearInterval(animateID[e]), delete animateID[e]
            } catch (i) {
                setTimeout(function () {
                    ajaxRequst(t, e)
                }, "1000")
            }
        },
        error: function (n) {
            setTimeout(function () {
                ajaxRequst(t, e)
            }, "1000"), i = !0
        },
        complete: function (n, o) {
            (i = !1) || "timeout" == o && setTimeout(function () {
                ajaxRequst(t, e)
            }, "1000")
        }
    })
}

function formatDate(t) {
    var e = t.getFullYear(), i = t.getMonth() + 1;
    i = i < 10 ? "0" + i : i;
    var n = t.getDate();
    return n = n < 10 ? "0" + n : n, e + "-" + i + "-" + n
}

function creatDataHead(t, e) {
    var i = tools.parseObj(t);
    if (i = i.result.data, tools.operatorTime("" == i.drawTime ? "0" : i.drawTime, i.serverTime) <= 0) throw new Error("error");
    !$("#videobox").length < 1 && -1 != $("#videobox").css("z-index") ? ($("iframe")[0].contentWindow.finishgame(i.preDrawCode), setTimeout(function () {
        publicmethod.insertHeadPk10(t, e)
    }, 3e3), setTimeout(function () {
        tools.insertVideo()
    }, 1e4)) : publicmethod.insertHeadPk10(t, e)
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
    }), tools.showExplain(), $(".listheadrl span").live("click", function () {
        $(this).siblings().removeClass("checked"), $(this).addClass("checked");
        var t = $(this).attr("id"), e = $("#biaozxz .sinli:nth-child(4)"), i = $("#biaozxz .sinli:nth-child(5)");
        e.hasClass("checked") && e.removeClass("checked"), i.hasClass("checked") && i.removeClass("checked"), tabarr = [], $("#chakanchfb,#daxiaodsfb").find("li").removeClass("selected"), "today" == t ? (listData(getDateStr(0), ""), $(".jinri").text("今天"), $("#dateframe").find("input").val(getDateStr(0))) : "yesterday" == t ? (listData(getDateStr(-1), ""), $(".jinri").text("昨天"), $("#dateframe").find("input").val(getDateStr(-1))) : "qianday" == t ? (listData(getDateStr(-2), ""), $(".jinri").text("前天"), $("#dateframe").find("input").val(getDateStr(-2))) : "thirty" == t ? listData("", "30") : "sixty" == t ? listData("", "60") : "ninety" == t && listData("", "90")
    }), $("#startVideo").on("click", function () {
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
    }), ajaxRequst("", boxid)
});
