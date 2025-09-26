function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
function ajaxRequst(t, e) {
    indexObj.ajaxSsc(t, e)
}

function typeOf(t, e) {
    if ("state" == t) switch (1 * e) {
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
    } else if ("dxh" == t) switch (1 * e) {
        case-1:
            return "小";
        case 0:
            return "和";
        case 1:
            return "大"
    } else if ("dsh" == t) switch (1 * e) {
        case-1:
            return "双";
        case 0:
            return "和";
        case 1:
            return "单"
    } else if ("qhh" == t) switch (1 * e) {
        case-1:
            return "后多";
        case 0:
            return "前后和";
        case 1:
            return "前多"
    } else if ("dsd" == t) switch (1 * e) {
        case-1:
            return "双多";
        case 0:
            return "单双和";
        case 1:
            return "单多"
    } else if ("zhzh" == t) switch (1 * e) {
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
    } else if ("wuxing" == t) switch (1 * e) {
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

function formatDate(t) {
    var e = t.getFullYear(), n = t.getMonth() + 1;
    n = n < 10 ? "0" + n : n;
    var i = t.getDate();
    return i = i < 10 ? "0" + i : i, e + "-" + n + "-" + i
}

function creatDataHead(t, e) {
    publicmethod.insertHeadBjkl8(t, e), tools.setTimefun_bjkl8()
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
        var t = $(this).attr("id"), e = $("#biaozxz .sinli:nth-child(4)"), n = $("#biaozxz .sinli:nth-child(5)");
        e.hasClass("checked") && e.removeClass("checked"), n.hasClass("checked") && n.removeClass("checked"), tabarr = [], $("#chakanchfb,#daxiaodsfb").find("li").removeClass("selected"), "today" == t ? (listData(getDateStr(0), ""), $(".jinri").text("今天"), $("#dateframe").find("input").val(getDateStr(0))) : "yesterday" == t ? (listData(getDateStr(-1), ""), $(".jinri").text(currentDay(getDateStr(-1))), $("#dateframe").find("input").val(getDateStr(-1))) : "qianday" == t ? (listData(getDateStr(-2), ""), $(".jinri").text(currentDay(getDateStr(-2))), $("#dateframe").find("input").val(getDateStr(-2))) : "thirty" == t ? listData("", "30") : "sixty" == t ? listData("", "60") : "ninety" == t && listData("", "90")
    }), ajaxRequst("", boxid), $("#startVideo").on("click", function () {
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
                    n = $("#timebox").find(".second").text(), i = t + ":" + e + ":" + n, a = [], o = [];
                "..." == t && (t = 0), "..." == e && (e = 0), "..." == n && (n = 0);
                var s = 3600 * t + 60 * e + 1 * n - 2;
                "-1" != s && "-2" != s || (s = 0), $("#klsf").find(".kajianhao li").each(function () {
                    a.push(parseInt($(this).text()))
                });
                var c = {
                    preDrawCode: a,
                    drawIssue: $("#preDrawIssue").val(),
                    drawTime: $("#drawTime").val(),
                    preDrawTime: i
                };
                0 == s ? ($("#jrsmhmtjTab").find("tr:nth-child(2)").find("ul li").each(function () {
                    o.push(parseInt($(this).text()))
                }), $("iframe")[0].contentWindow.syxwV.pcFillData(c.drawIssue, c.drawTime, o, 1), $("iframe")[0].contentWindow.syxwV.intoKai(), $("iframe")[0].contentWindow.syxwV.startFun()) : $("iframe")[0].contentWindow.syxwV.startVid(c)
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
});
var boxid = "#klsf", urlbublic = config.publicUrl, lotCode = getParameterByName("code"), indexObj = new Object;
indexObj.ajaxSsc = function (t, e) {
    var t = void 0 == t ? "" : t, n = !1;
    $.ajax({
        url: urlbublic + "LuckTwenty/getBaseLuckTewnty.do?issue=" + t,
        type: "GET",
        data: {lotCode: lotCode},
        beforeSend: function () {
            $(e).find(".kajianhao li").each(function () {
                $(this).removeClass("numWeightblue"), $(this).removeClass("numOrange")
            }), void 0 == animateID[e] && animateMethod.sscAnimate(e)
        },
        success: function (n) {
            try {
                $(".gamename").text(n.result.data.lotName);
                $(".iconUrl").attr("src", n.result.data.iconUrl);
                //标题变更
                var title = $("title").text();
                title = title.replace('*',n.result.data.lotName);
                $("title").text(title);

                creatDataHead(n, e), clearInterval(animateID[e]), delete animateID[e]
            } catch (n) {
                setTimeout(function () {
                    ajaxRequst(t, e)
                }, "1000"), config.ifdebug
            }
        },
        error: function (i) {
            setTimeout(function () {
                ajaxRequst(t, e)
            }, "1000"), n = !0, config.ifdebug
        },
        complete: function (i, a) {
            (n = !1) || "timeout" == a && setTimeout(function () {
                ajaxRequst(t, e)
            }, "1000")
        }
    })
};