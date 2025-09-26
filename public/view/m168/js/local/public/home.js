function homeGetPageAdvConfig(e) {
    var s = e || !1;
    $.ajax({
        type: "get",
        url: config.publicUrl + "parameters/getNoAdvertisingDomain.do",
        async: !0,
        data: {platform: "168"},
        success: function (e) {
            "string" == typeof e && (e = JSON.parse(e)), hideList = e.result.data.domainList, operationDomain(hideList);
            var i = window.location.hostname.split(":")[0].replace("m.", "");
            void 0 == hideList || "" == hideList || -1 != hideList.indexOf(i) ? sessionStorage.setItem("isDomainNoAdv", !0) : sessionStorage.setItem("isDomainNoAdv", !1), s ? showHomePageBanner(s) : showHomePageBanner()
        },
        error: function () {
        }
    })
}

function showHomePageBanner(e) {
    return;
    function s(e) {
        p.find("img").attr("src", config.imgUrl + e), sessionStorage.setItem(r, 1), p.fadeIn(), m.css("display", "flex")
    }

    function i() {
        p.find("img").attr("src", "/img/promo-webapp-popup-banner-29112021.png"), localStorage.getItem(d) && !o ? (clearInterval(bannerDisplayInterval), bannerDisplayInterval = setInterval(a, 1e3)) : l()
    }

    function n(e) {
        !0 === JSON.parse(sessionStorage.getItem("isDomainNoAdv")) ? deepLinkInteraction(e, config.deepLinkNoAdv, config.appNoAdvLink) : deepLinkInteraction(e, config.deepLinkWithAdv, config.appWithAdvLink)
    }

    function a() {
        Date.now() >= localStorage.getItem(d) && (clearInterval(bannerDisplayInterval), homeGetPageAdvConfig(!0))
    }

    function l() {
        p.fadeIn(), n(p.find("img")), t(), homePageBannerInterval = setInterval(t, 1e3)
    }

    function t() {
        0 !== x ? (m.hide(), f.css("display", "flex"), f.find("span").text(x < 10 ? "0" + x + " 秒" : x + " 秒")) : (clearInterval(homePageBannerInterval), f.hide(), m.css("display", "flex")), x--
    }

    var o = e || !1, r = "homepagePopUpbanner", d = "bannerNextDisplayTime", c = sessionStorage.getItem(r), u = !1,
        p = $("#homepageBanner"), m = $("#homepageBannerCloseBtn"), f = $("#homePageBannerCountdown"), x = 10;
    $.ajax({
        type: "get",
        url: config.publicUrl + "focusPicture/findPopUpPictureByType.do",
        async: !0,
        data: {type: 3, platform: "168"},
        success: function (e) {
            var n = "";
            if ("string" == typeof e && (e = JSON.parse(e)), "" === (n = e.result.data) || 0 === n.length) i(); else {
                if (null !== c) return void p.hide();
                var a = n.startDate, l = n.endDate, t = new Date(n.startDate.replace(/-/g, "/")),
                    o = new Date(n.endDate.replace(/-/g, "/")), r = new Date;
                o = new Date(o), 0 == a.length && 0 == l.length ? (u = !0, s(n.image)) : 0 != a.length && 0 == l.length ? r >= t && (u = !0, s(n.image)) : 0 == a.length && 0 != l.length ? r <= o && (u = !0, s(n.image)) : 0 != a.length && 0 != l.length && r < o && (u = !0, s(n.image))
            }
        }
    }), $("#homepageBannerCloseBtn, .relative img").on("click", function () {
        p.fadeOut(), u || (localStorage.setItem(d, Date.now() + 216e5), clearInterval(bannerDisplayInterval), bannerDisplayInterval = setInterval(a, 1e3))
    })
}

function nofind(e) {
    e.src = "../../img/beijmr.png"
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    }, publicUrl = config.publicUrl, url6 = config.url6, smallSixInfoCountDownTimer, homePageBannerInterval,
    bannerDisplayInterval, backUrl = config.backUrl, hometools = {}, renderLottery = {};
$(function () {
    pupajax();
    homeGetPageAdvConfig();
    indexObj.ajaxBanner();
    setInterval(function () {
        $(".main_image ul li").find("img").width($(".main_image").width()), $(".main_image").height($(".main_image ul li").find("img").height())
    }, 500), window.onresize = function () {
        $(".main_image ul li").find("img").width($(".main_image").width()), $(".main_image").height($(".main_image ul li").find("img").height())
    };
    var e = $(".main_image").find("li");
    $(e).each(function (e) {
        $(".flicking_con").append("<a href='javascript:;' class='" + (0 == e ? "on" : "") + "'>" + (e + 1) + "</a>")
    }), $dragBln = !1, $(".main_image ul li").find("img").length > 1 ? $(".main_image").touchSlider({
        flexible: !0,
        speed: 200,
        btn_prev: $("#btn_prev"),
        btn_next: $("#btn_next"),
        paging: $(".flicking_con a"),
        counter: function (e) {
            $(".flicking_con a").removeClass("on").eq(e.current - 1).addClass("on")
        }
    }) : $(".main_image ul li").find("img").width($(".main_image").width()), $(".main_image ul li").find("img").width($(".main_image").width()), $(".main_image").bind("mousedown", function () {
        $dragBln = !1
    }), $(".main_image").bind("dragstart", function () {
        $dragBln = !0
    }), $(".main_image a").click(function () {
        if ($dragBln) return !1
    }), timer = setInterval(function () {
        $("#btn_next").click()
    }, 5e3), $(".main_visual").hover(function () {
        clearInterval(timer)
    }, function () {
        timer = setInterval(function () {
            $("#btn_next").click()
        }, 5e3)
    }), $(".main_image").bind("touchstart", function () {
        clearInterval(timer)
    }).bind("touchend", function () {
        timer = setInterval(function () {
            $("#btn_next").click()
        }, 5e3)
    }), window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", function () {
        $(".main_image ul li").find("img").width($(".main_image").width()), $(".main_image").height($(".main_image ul li").find("img").height())
    }, !1);
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#zipBtn").on("touchstart", function (e) {
        e.preventDefault(), $(this).toggleClass("upArr"), $(this).hasClass("upArr") ? ($(".muneHide").css("display", "flex"), $(".muneHide").animate({opacity: "1"}), $(".iconHome").animate({height: "1.5rem"})) : ($(".muneHide").animate({opacity: "0"}), $(".iconHome").animate({height: ".78rem"}), $(".muneHide").hide())
    }), $("#menubtn").on("touchstart", "#btnimg", function () {
        tools.openAllCz(!0)
    }), $("#cZList .backbtn").on("touchstart", "span", function () {
        tools.openAllCz(!1), bodyHtmlvis()
    }), $("#toRMC").on("click", ".lilist", function () {
        var e = $(this).attr("id").split("_")[1], s = "";
        sessionStorage.setItem("czBackToHomepage", 1);
        $(cZ.toRMC).each(function () {
            e == this.id && (s = this.href, window.location.href = s)
        }), "" == s && $(cZ.toJSC).each(function () {
            e == this.id && (s = this.href, window.location.href = s)
        }), "" == s && $(cZ.toGPC).each(function () {
            e == this.id && (s = this.href, window.location.href = s)
        }), "" == s && $(cZ.toJWC).each(function () {
            e == this.id && (s = this.href, window.location.href = s)
        }), "" == s && $(cZ.toQGC).each(function () {
            e == this.id && (s = this.href, window.location.href = s)
        }), "" == s && $(cZ.toSGC).each(function () {
            e == this.id && (s = this.href, window.location.href = s)
        })
    })
}), indexObj.ajaxRequst = function (e, s, i) {
    if (void 0 != s) {
        var e = "..." == e ? "" : e, n = s.split("_")[1];
        "cz_20049" === s && indexObj.ajaxAomenSixInfo(e,n, "#" + s, i);
        "cz_10051" === s ? indexObj.ajaxSpeedSixInfo(e,n, "#" + s, i) : "cz_10048" === s && indexObj.ajaxSmallSixInfo(e,n, "#" + s, i);
        hometools.hadCode(n, "pk10") ? indexObj.ajaxpk10(e, n, "#" + s, i) : hometools.hadCode(n, "kuai3") ? indexObj.ajaxKuai3(e, n, "#" + s, i) : hometools.hadCode(n, "cqnc") ? indexObj.ajaxCqnc(e, n, "#" + s, i) : hometools.hadCode(n, "ssc") ? indexObj.ajaxSsc(e, n, "#" + s, i) : hometools.hadCode(n, "shiyi5") ? indexObj.ajaxShiyix5(e, n, "#" + s, i) : hometools.hadCode(n, "klsf") ? indexObj.ajaxKlsf(e, n, "#" + s, i) : hometools.hadCode(n, "gxklsf") ? indexObj.ajaxGxklsf(e, n, "#" + s, i) : hometools.hadCode(n, "jisukl8") ? indexObj.ajaxJskl8(e, n, "#" + s, i) : hometools.hadCode(n, "twc_new") ? indexObj.ajaxTwc(e, n, "#" + s, i) : hometools.hadCode(n, "egxy") ? indexObj.ajaxEgxy(e, n, "#" + s, i) : hometools.hadCode(n, "qgc") ? indexObj.ajaxQgc(e, n, "#" + s, i) : hometools.hadCode(n, "qgc1") && indexObj.ajaxQgc1(e, n, "#" + s, i)
    }
}, indexObj.ajaxBanner = function () {
    var e = !1;
    indexObj.YM(), $.ajax({
        url: publicUrl + "focusPicture/findPictureAndNotice.do",
        type: "GET",
        dataType: "json",
        data: {type: "1", position: "0", sourceUrl: indexObj.YM()},
        timeout: 6e4,
        async: !1,
        success: function (e) {
            try {
                indexObj.loadBanner(e)
            } catch (e) {
                setTimeout(function () {
                    indexObj.ajaxBanner()
                }, 2e3)
            }
        },
        error: function (s) {
            setTimeout(function () {
                indexObj.ajaxBanner()
            }, 2e3), e = !0
        },
        complete: function (s, i) {
            e || "timeout" == i && setTimeout(function () {
                indexObj.ajaxBanner()
            }, 2e3)
        }
    })
}, indexObj.ajaxNotice = function () {
    var e = !1;
    $.ajax({
        url: publicUrl + "notice/getLastNotice.do?type=1",
        type: "GET",
        timeout: 6e4,
        async: !1,
        success: function (e) {
            try {
                indexObj.loadNotice(e)
            } catch (e) {
                setTimeout(function () {
                    indexObj.ajaxNotice()
                }, 2e3)
            }
        },
        error: function (s) {
            setTimeout(function () {
                indexObj.ajaxNotice()
            }, 2e3), e = !0
        },
        complete: function (s, i) {
            e || "timeout" == i && setTimeout(function () {
                indexObj.ajaxNotice()
            }, 2e3)
        }
    })
}, indexObj.loadNotice = function (e) {
    e = (e = hometools.ifObj(e)).result.data, $("#noticeT").empty(), $("#noticeT").text(e.name)
}, indexObj.loadBanner = function (e) {
    var s = hometools.ifObj(e);
    s = s.result.data;
    var i = "", n = !0;
    $(s.list).each(function (e) {
        var s = "" == this.link ? "javascript:;" : this.link;
        i += '<a target="_blank" href="' + s + '"><li><img onerror="nofind(this)" src="' + this.image + '" /></li></a>', n = !1
    }), $("#noticeT").empty(), s.noticeContent ? ($("#noticeContainer").show(), $("#noticeT").text(s.noticeContent), tools.newsTicker("noticeT")) : $("#noticeContainer").hide(), n && (i = '<a target="_blank" href=""><li><img src="../../img/beijmr.png"></li></a>'), $(".main_image ul").empty(), $(".main_image ul").append(i), $(".flicking_con").length <= 1 && $(".flicking_con").hide()
}, indexObj.ajaxInit = function (e, s, i) {
    var n = !1;
    $.ajax({
        url: e, type: "GET", data: i, timeout: 6e4, beforeSend: function () {
            hometools.progressA(s, !0), $("#toRMC").find(".li3").hide()
        }, success: function (n) {
            try {
                hometools.progressA(s, !1), indexObj.loadData(n, s), $("#toRMC").find(".li3").show("200")
            } catch (n) {
                console.log(n)
                setTimeout(function () {
                    indexObj.ajaxInit(e, s, i)
                }, 1e3)
            }
        }, error: function (a) {
            setTimeout(function () {
                indexObj.ajaxInit(e, s, i)
            }, 1e3), n = !0
        }, complete: function (a, l) {
            n || "timeout" == l && setTimeout(function () {
                indexObj.ajaxInit(e, s, i)
            }, 1e3)
        }
    })
}, indexObj.loadData = function (e, s) {
    indexObj.createRMC(e, s)
}, indexObj.createRMC = function (e, s) {
    var i = hometools.ifObj(e), n = $(".czList");
    i = i.result.data, $(i).each(function (e) {
        function i(e) {
            if (1 === e.lotteryStatus) {
                return $(a).find(".opentyle").html("<span class='label-warning'>停止销售</span>"), void $(a).find(".cuttime").hide()
            }
        }

        var a = "#cz_" + this.lotCode;
        $(a).find(".lotName").text(this.lotName);
        hometools.hadCode(this.lotCode, "aomenSix") && ($(n).append(hometools.lotTemplate.aomenSix("cz_" + this.lotCode)),i(this), indexObj.ajaxAomenSixInfo('',20049));
        hometools.hadCode(this.lotCode, "pk10") && ($(n).append(hometools.lotTemplate.pk10("cz_" + this.lotCode)), i(this), indexObj.pk10Data(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "kuai3") && ($(n).append(hometools.lotTemplate.kuai3("cz_" + this.lotCode)), i(this), indexObj.kuai3Data(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "cqnc") && ($(n).append(hometools.lotTemplate.cqnc("cz_" + this.lotCode)), indexObj.cqncData(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "ssc") && ($(n).append(hometools.lotTemplate.ssc("cz_" + this.lotCode)), i(this), indexObj.sscData(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "shiyi5") && ($(n).append(hometools.lotTemplate.shiyi5("cz_" + this.lotCode)), i(this), indexObj.shiyix5Data(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "klsf") && ($(n).append(hometools.lotTemplate.klsf("cz_" + this.lotCode)), i(this), indexObj.klsfData(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "gxklsf") && ($(n).append(hometools.lotTemplate.klsf("cz_" + this.lotCode)), i(this), indexObj.gxklsfData(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "jisukl8") && ($(n).append(hometools.lotTemplate.jisukl8("cz_" + this.lotCode)), i(this), indexObj.jskl8Data(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "twc_new") && ($(n).append(hometools.lotTemplate.twc_new("cz_" + this.lotCode)), i(this), indexObj.twcData(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "egxy") && ($(n).append(hometools.lotTemplate.egxy("cz_" + this.lotCode)), i(this), indexObj.egxyData(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "qgc") && ($(n).append(hometools.lotTemplate.qgc("cz_" + this.lotCode)), i(this), indexObj.qgcData(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "qgc1") && ($(n).append(hometools.lotTemplate.qgc1("cz_" + this.lotCode)), i(this), indexObj.qgc1Data(this, this.lotCode, a, s));
        hometools.hadCode(this.lotCode, "smallSix") && ($(n).append(hometools.lotTemplate.smallSix("cz_" + this.lotCode)), i(this), indexObj.ajaxSmallSixInfo('',10048));
        hometools.hadCode(this.lotCode, "speedSix") && ($(n).append(hometools.lotTemplate.speedSix("cz_" + this.lotCode)), i(this), indexObj.ajaxSpeedSixInfo('',10051));
        $(a).find(".preIssue").text(this.drawIssue), $(a).find(".preDrawIssue").text(this.preDrawIssue), $(a).find(".opentyle").hide();
    })
}, indexObj.ajaxpk10 = function (e, s, i, n) {
    var e = void 0 == e ? "" : e, a = !1;
    $.ajax({
        url: publicUrl + "pks/getLotteryPksInfo.do?issue=" + e,
        type: "GET",
        async: "false",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.pk10Data(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxpk10(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (l) {
            setTimeout(function () {
                indexObj.ajaxpk10(e, s, i, n)
            }, 1e3), a = !0
        },
        complete: function (l, t) {
            a || "timeout" == t && setTimeout(function () {
                indexObj.ajaxpk10(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxSsc = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "CQShiCai/getBaseCQShiCai.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.sscData(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxSsc(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxSsc(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxSsc(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxTwc = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "taiWanCai/getLotteryInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.twcData(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxTwc(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxTwc(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxTwc(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxKlsf = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "klsf/getLotteryInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            $(i).find(".numred").removeClass("numred"), hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.klsfData(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxKlsf(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxKlsf(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxKlsf(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxGxklsf = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "gxklsf/getLotteryInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            $(i).find(".numred").removeClass("numred"), hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.gxklsfData(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxGxklsf(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxGxklsf(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxGxklsf(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxJskl8 = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "LuckTwenty/getBaseLuckTewnty.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            $(i).find(".numred").removeClass("numred"), hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.jskl8Data(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxJskl8(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxJskl8(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxJskl8(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxCqnc = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "klsf/getLotteryInfo.do?issue=" + e,
        type: "GET",
        async: "false",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.cqncData(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxCqnc(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxCqnc(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxCqnc(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxKuai3 = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "lotteryJSFastThree/getBaseJSFastThree.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.kuai3Data(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxKuai3(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxKuai3(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxKuai3(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxShiyix5 = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "ElevenFive/getElevenFiveInfo.do?issue=" + e,
        type: "GET",
        async: !0,
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.shiyix5Data(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxShiyix5(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxShiyix5(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxShiyix5(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxEgxy = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "LuckTwenty/getPcLucky28.do?issue=" + e,
        type: "GET",
        async: !0,
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.egxyData(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxEgxy(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxEgxy(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxEgxy(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxQgc = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "QuanGuoCai/getLotteryInfo.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            $(i).find(".numred").removeClass("numred"), hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.qgcData(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxQgc(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxQgc(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxQgc(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxQgc1 = function (e, s, i, n) {
    var e = void 0 == e ? "" : e;
    $.ajax({
        url: publicUrl + "QuanGuoCai/getLotteryInfo1.do?issue=" + e,
        type: "GET",
        data: {lotCode: s},
        timeout: 6e4,
        beforeSend: function () {
            $(i).find(".numred").removeClass("numred"), hometools.progressA(n, !0, i)
        },
        success: function (a) {
            try {
                var l = hometools.ifObj(a);
                if (l = l.result.data, tools.operatorTime("" == l.drawTime ? "0" : l.drawTime, l.serverTime) <= 0) throw new Error("error");
                indexObj.qgc1Data(l, s, i, n), hometools.progressA(n, !1, i)
            } catch (a) {
                setTimeout(function () {
                    indexObj.ajaxQgc1(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (a) {
            setTimeout(function () {
                indexObj.ajaxQgc1(e, s, i, n)
            }, 1e3)
        },
        complete: function (a, l) {
            "timeout" == l && setTimeout(function () {
                indexObj.ajaxQgc1(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxSmallSixInfo = function (e, s, i, n) {
    var e = void 0 == e ? "" : e, a = !1;
    $.ajax({
        type: "get",
        url: publicUrl + "smallSix/findSmallSixInfo.do?issue=" + e,
        timeout: 6e4,
        async: !0,
        data: {lotCode: s},
        dataType: "json",
        beforeSend: function () {
            $("#cz_10048").find("#openingLottery").show();
        },
        success: function (es) {
            try {
                if (tools.operatorTime("" == es.result.data.drawTime ? "0" : es.result.data.drawTime, es.result.data.serverTime) <= 0) throw new Error("error");
                indexObj.verifySmallSixLotteryInfo(es, "#cz_10048", 4)
            } catch (es) {
                setTimeout(function () {
                    indexObj.ajaxSmallSixInfo(e, s, i, n)
                }, 1e3)
            }
        },
        error: function () {
            setTimeout(function () {
                indexObj.ajaxSmallSixInfo(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxAomenSixInfo = function (e, s, i, n) {
    console.log(e, s, i, n)
    var e = void 0 == e ? "" : e, a = !1;
    $.ajax({
        type: "get",
        url: publicUrl + "smallSix/findSmallSixInfo.do?issue=" + e,
        timeout: 6e4,
        async: !0,
        data: {lotCode: s},
        dataType: "json",
        beforeSend: function () {
            $("#cz_20049").find("#openingLottery").show();
        },
        success: function (es) {
            try {
                if (tools.operatorTime("" == es.result.data.drawTime ? "0" : es.result.data.drawTime, es.result.data.serverTime) <= 0) throw new Error("error");
                indexObj.verifyAomenSixLotteryInfo(es, "#cz_20049", 4)
            } catch (es) {
                //console.log(es)
                setTimeout(function () {
                    indexObj.ajaxAomenSixInfo(e, s, i, n)
                }, 1e3)
            }
        },
        error: function () {
            setTimeout(function () {
                indexObj.ajaxAomenSixInfo(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.ajaxSpeedSixInfo = function (e, s, i, n) {
    var e = void 0 == e ? "" : e, a = !1;
    var i = "#cz_10051";
    $.ajax({
        type: "get",
        url: publicUrl + "speedSix/findSpeedSixInfo.do?issue=" + e,
        timeout: 6e4,
        async: !0,
        data: {lotCode: s},
        dataType: "json",
        beforeSend: function () {
            hometools.progressA(4, !0, i)
        },
        success: function (es) {
            try {
                if (tools.operatorTime("" == es.result.data.drawTime ? "0" : es.result.data.drawTime, es.result.data.serverTime) <= 0) throw new Error("error");
                renderLottery.smallSixLottery(es, i, 4), hometools.progressA(4, !1, i)
            } catch (es) {
                setTimeout(function () {
                    indexObj.ajaxSpeedSixInfo(e, s, i, n)
                }, 1e3)
            }
        },
        error: function (es) {
            setTimeout(function () {
                indexObj.ajaxSpeedSixInfo(e, s, i, n)
            }, 1e3)
        }
    })
}, indexObj.verifySmallSixLotteryInfo = function (e, s, i) {
    var n = e.result.data.type;
    if (8 != n) {
        renderLottery.smallSixLottery(e, s, i);
        var a = setTimeout(function () {
            indexObj.ajaxSmallSixInfo(e, s, i), clearTimeout(a)
        }, 2e3)
    }
    8 == n && ($(s).find(".addpic").show(), $(s).find(".zongfen").show(), renderLottery.smallSixLottery(e, s, i))
}, indexObj.verifyAomenSixLotteryInfo = function (e, s, i) {
    var n = e.result.data.type;
    if (8 != n) {
        renderLottery.smallSixLottery(e, s, i);
        var a = setTimeout(function () {
            indexObj.ajaxAomenSixInfo(e, s, i), clearTimeout(a)
        }, 2e3)
    }
    8 == n && ($(s).find(".addpic").show(), $(s).find(".zongfen").show(), renderLottery.smallSixLottery(e, s, i))
}, indexObj.shiyix5Data = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.sscAnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".opentyle").hide(), $(i).find(".dragonTiger").text("0" == e.dragonTiger ? "龙" : "虎"), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text(tools.typeOf("zhdx", e.sumBigSmall)), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), indexObj.countDown(e.drawTime, e.serverTime, i, n)
}, indexObj.kuai3Data = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.kuai3AnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text("0" == e.sumBigSmall ? "大" : "小"), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n)
}, indexObj.pk10Data = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.pk10AnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preIssue").text(e.preDrawIssue), $(i).find(".opentyle").hide(), $(i).find(".firstDT").text("0" == e.firstDT ? "龙" : "虎"), $(i).find(".secondDT").text("0" == e.secondDT ? "龙" : "虎"), $(i).find(".thirdDT").text("0" == e.thirdDT ? "龙" : "虎"), $(i).find(".fourthDT").text("0" == e.fourthDT ? "龙" : "虎"), $(i).find(".fifthDT").text("0" == e.fifthDT ? "龙" : "虎"), $(i).find(".sumFS").text(e.sumFS), $(i).find(".sumBigSamll").text("0" == e.sumBigSamll ? "大" : "小"), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), indexObj.countDown(e.drawTime, e.serverTime, i, n)
}, indexObj.sscData = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.sscAnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue);
    var a = "";
    "0" == e.dragonTiger ? a = "龙" : "1" == e.dragonTiger ? a = "虎" : "2" == e.dragonTiger && (a = "和"), $(i).find(".dragonTiger").text(a), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text("0" == e.sumBigSmall ? "大" : "小"), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n)
}, indexObj.twcData = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.sscAnimateEnd(e.preDrawCode.split(","), i), 10070 == s ? $(i + " .sscli li:not(:last-child)").addClass("tw_orange") : 10071 == s ? $(i + " .sscli li:not(:last-child)").addClass("tw_green") : 10072 == s && $(i + " .sscli li").addClass("tw_yellow").slice(-2).remove(), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text("0" == e.sumBigSmall ? "大" : "小"), $(i).find(".sumSingleDouble").text("1" == e.sumSingleDouble ? "单" : "双"), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n)
}, indexObj.klsfData = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.sscAnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".firstDragonTiger").text("0" == e.firstDragonTiger ? "龙" : "虎"), $(i).find(".secondDragonTiger").text("0" == e.secondDragonTiger ? "龙" : "虎"), $(i).find(".thirdDragonTiger").text("0" == e.thirdDragonTiger ? "龙" : "虎"), $(i).find(".fourthDragonTiger").text("0" == e.fourthDragonTiger ? "龙" : "虎"), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text(tools.typeOf("zhdx", e.sumBigSmall)), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n), hometools.changeBackground(i)
}, indexObj.gxklsfData = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.sscAnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".firstDragonTiger").text("0" == e.firstDragonTiger ? "龙" : "虎"), $(i).find(".secondDragonTiger").text("0" == e.secondDragonTiger ? "龙" : "虎"), $(i).find(".thirdDragonTiger").text("0" == e.thirdDragonTiger ? "龙" : "虎"), $(i).find(".fourthDragonTiger").text("0" == e.fourthDragonTiger ? "龙" : "虎"), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text(tools.typeOf("zhdx", e.sumBigSmall)), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n), hometools.changeBackground(i)
}, indexObj.jskl8Data = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName);
    var a = lotCode, l = [a.sgHappy8, a.jisukl8, a.kl8],
        t = $(".czList").find("#cz_" + s + " .kajianhao ul.numberbox li"), o = t.last(), r = e.preDrawCode.split(",");
    tools.bjkl8BagColor(r, i), l.includes(1 * s) ? (r.length - 20 > 0 && r.splice(-1, r.length - 20), t.length > 20 && o.remove()) : o.css("background", "#FA8E19"), animate.sscAnimateEnd(r, i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".firstDragonTiger").text("0" == e.firstDragonTiger ? "龙" : "虎"), $(i).find(".secondDragonTiger").text("0" == e.secondDragonTiger ? "龙" : "虎"), $(i).find(".thirdDragonTiger").text("0" == e.thirdDragonTiger ? "龙" : "虎"), $(i).find(".fourthDragonTiger").text("0" == e.fourthDragonTiger ? "龙" : "虎"), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text(tools.typeOf("sumBigSmall", e.sumBigSmall)), $(i).find(".sumSingleDouble").text(tools.typeOf("sumSingleDouble", e.sumSingleDouble)), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n), hometools.changeBackground(i)
}, indexObj.cqncData = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.cqncAnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".opentyle").hide(), $(i).find(".firstDragonTiger").text("0" == e.firstDragonTiger ? "龙" : "虎"), $(i).find(".secondDragonTiger").text("0" == e.secondDragonTiger ? "龙" : "虎"), $(i).find(".thirdDragonTiger").text("0" == e.thirdDragonTiger ? "龙" : "虎"), $(i).find(".fourthDragonTiger").text("0" == e.fourthDragonTiger ? "龙" : "虎"), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text(tools.typeOf("zhdx", e.sumBigSmall)), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), $(i).find(".lastBigSmall").text("0" == e.lastBigSmall ? "尾大" : "尾小"), indexObj.countDown(e.drawTime, e.serverTime, i, n)
}, indexObj.egxyData = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName.toUpperCase()), animate.sscAnimateEnd(e.preDrawCode.split(","), i), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".firstDragonTiger").text("0" == e.firstDragonTiger ? "龙" : "虎"), $(i).find(".secondDragonTiger").text("0" == e.secondDragonTiger ? "龙" : "虎"), $(i).find(".thirdDragonTiger").text("0" == e.thirdDragonTiger ? "龙" : "虎"), $(i).find(".fourthDragonTiger").text("0" == e.fourthDragonTiger ? "龙" : "虎"), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumBigSmall").text(tools.typeOf("sumBigSmall", e.sumBigSmall)), $(i).find(".sumSingleDouble").text(tools.typeOf("sumSingleDouble", e.sumSingleDouble)), $(i).find("#pk10num").find("li:last-child").css({background: "red"}), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n), hometools.changeBackground(i)
}, indexObj.qgcData = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.sscAnimateEnd(e.preDrawCode.split(","), i), "10039" == s || "10045" == s ? $(i + " .sscli li").last().remove() : "10040" == s && $(i + " .sscli li").slice(-1).remove();
    var a = $(i).find(".sscli li").length;
    $(i).find(".sscli li").each(function (e) {
        "10039" == s || "10042" == s ? e != a - 1 ? $(this).css("background-color", "red") : $(this).css("background-color", "#0092dd") : "10040" == s ? e == a - 1 || e == a - 2 ? $(this).css("background-color", "#0092dd") : $(this).css("background-color", "red") : "10045" == s && (e <= 3 ? $(this).css("background-color", "#0092dd") : $(this).css("background-color", "#19a6da"))
    }), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n), hometools.changeBackground(i), tools.resetRed(i)
}, indexObj.qgc1Data = function (e, s, i, n) {
    $(i).find(".lotName").text(e.lotName), animate.sscAnimateEnd(e.preDrawCode.split(","), i), "10041" != s && "10043" != s || $(i + " .sscli li").slice(-2).remove(), $(i).find(".sscli li").each(function (e) {
        "10041" == s || "10043" == s ? $(this).css("background-color", "red") : "10044" == s && $(this).css("background-color", "red")
    }), $(i).find(".nextIssue").text(e.drawIssue), $(i).find(".preDrawIssue").text(e.preDrawIssue), $(i).find(".firstDragonTiger").text("0" == e.firstDragonTiger ? "龙" : "虎"), $(i).find(".secondDragonTiger").text("0" == e.secondDragonTiger ? "龙" : "虎"), $(i).find(".thirdDragonTiger").text("0" == e.thirdDragonTiger ? "龙" : "虎"), $(i).find(".fourthDragonTiger").text("0" == e.fourthDragonTiger ? "龙" : "虎"), $(i).find(".sumNum").text(e.sumNum), $(i).find(".sumSingleDouble").text("0" == e.sumSingleDouble ? "单" : "双"), $(i).find(".opentyle").hide(), indexObj.countDown(e.drawTime, e.serverTime, i, n), hometools.changeBackground(i)
}, indexObj.countDown = function (e, s, i, n) {
    var a = e.replace("-", "/"), s = s.replace("-", "/");
    a = a.replace("-", "/"), s = s.replace("-", "/");
    var l = $(i).find(".hour"), t = $(i).find(".minute"), o = $(i).find(".second"), r = $(i).find(".opentyle"),
        d = $(i).find(".cuttime"), c = (new Date(a).getTime() - new Date(s).getTime()) / 1e3, u = "";
    clearInterval(u), u = setInterval(function () {
        if (c > 1) {
            c -= 1;
            var e = 24 * Math.floor(c / 3600 / 24), s = Math.floor(c / 3600 % 24) + e, a = Math.floor(c / 60 % 60),
                p = Math.floor(c % 60);
            $(l).text(s < 10 ? "0" + s : s), $(t).text(a < 10 ? "0" + a : a), $(o).text(p < 10 ? "0" + p : p), s <= 0 ? ($(i).find(".hourtxt").hide(), $(i).find(".hour").hide()) : ($(i).find(".hourtxt").show(), $(i).find(".hour").show())
        } else $(r).show(), $(d).hide(), clearInterval(u), indexObj.ajaxRequst($(i).find(".nextIssue").text(), $(i).attr("id"), n)
    }, 1e3)
}, indexObj.smallSixInfoCountDown = function (e, s, i, n) {
    var a = e.replace("-", "/"), s = s.replace("-", "/");
    a = a.replace("-", "/"), s = s.replace("-", "/");
    var l = $(i).find(".day"), t = $(i).find(".hour"), o = $(i).find(".minute"), r = $(i).find(".second"),
        d = $(i).find(".opentyle"), c = $(i).find(".cuttime"),
        u = (new Date(a).getTime() - new Date(s).getTime()) / 1e3;
    clearInterval(smallSixInfoCountDownTimer), smallSixInfoCountDownTimer = setInterval(function () {
        if (u > 1) {
            u -= 1;
            var e = parseInt(u / 3600 / 24), s = Math.floor(u / 3600 - 24 * e), a = Math.floor(u / 60 % 60),
                p = Math.floor(u % 60);
            $(l).text(e < 10 ? "0" + e : e), $(t).text(s < 10 ? "0" + s : s), $(o).text(a < 10 ? "0" + a : a), $(r).text(p < 10 ? "0" + p : p), e <= 0 ? ($(i).find(".second").show(), $(i).find(".secondtxt").show(), $(i).find(".daytxt").hide(), $(i).find(".day").hide()) : ($(i).find(".daytxt").show(), $(i).find(".day").show(), $(i).find(".second").hide(), $(i).find(".secondtxt").hide())
        } else $(d).show(), $(c).hide(), clearInterval(smallSixInfoCountDownTimer), indexObj.ajaxRequst($(i).find(".nextIssue").text(), $(i).attr("id"), n)
    }, 1e3)
}, renderLottery.smallSixLottery = function (e, s, i) {
    var n = $(s);
    n.find(".nextIssue").text(e.result.data.drawIssue)
    n.find(".preDrawIssue").text(e.result.data.preDrawIssue), n.find(".opentyle").hide(), n.find(".cuttime").show();
    var a = n.find("#sixLotteryContent"), l = n.find(".numbox"), t = n.find("#openingLottery"),
        o = n.find(".sh_xzlist>li>span:first-child"), r = n.find(".sh_xzlist>li>span:last-child"),
        d = n.find("#jnumber>li:not(.addpic)"), c = n.find("#zongfen"), u = {};
    u.ThisCode = e.result.data.preDrawCode.split(","), c.text(""), o.text(""), r.text(""), d.text(""), d.removeClass(), u.ThisCode.length >= 6 ? (n.find(".addpic").show(), n.find(".zongfen").show()) : (n.find(".addpic").hide(), n.find(".zongfen").hide()), u.ThisCode[0] <= "" ? (t.show(), l.hide(), a.hide()) : (l.show(), a.show(), t.hide()), c.text(e.result.data.sumTotal);
    for (var p = 0; p < u.ThisCode.length; p++) {
        if (void 0 == u.ThisCode[p] || void 0 == proto.fiveLineArr[e.result.data.fiveElements[p]]) return !1;
        if (void 0 == e.result.data.fiveElements[p]) return !1;
        o[p].innerHTML = proto.Zoo[e.result.data.chineseZodiac[p]], r[p].innerHTML = proto.fiveLineArr[e.result.data.fiveElements[p]], d[p].className = proto.colorEng[e.result.data.color[p]], d[p].innerHTML = u.ThisCode[p] > 9 ? u.ThisCode[p] : "0" + u.ThisCode[p]
    }
    "#cz_10048" === s ? (clearInterval(smallSixInfoCountDownTimer), indexObj.smallSixInfoCountDown(e.result.data.drawTime, e.result.data.serverTime, s, i)) : indexObj.countDown(e.result.data.drawTime, e.result.data.serverTime, s, i)
}, hometools.progressA = function (e, s, i) {
    1 == e ? void 0 == i ? hometools.showOrHid("#toGPC", s) : hometools.showOrHid(i, s) : 2 == e ? void 0 == i ? hometools.showOrHid("#", s) : hometools.showOrHid(i, s) : 3 == e ? void 0 == i ? hometools.showOrHid("#toJWC", s) : hometools.showOrHid(i, s) : 4 == e && (void 0 == i ? hometools.showOrHid("#toRMC", s) : hometools.showOrHid(i, s))
}, hometools.showOrHid = function (e, s, i) {
    var n = "", a = "", l = "", t = "";
    n = $(e + " .kajianhao"), a = $(e + " .kajianhao").find(".numberbox"), l = $(e + " .kajianhao").find(".sh_xzlist"), t = $(e + " .boxline").find(".cuttime"), s ? ($(n).find(".progress").remove(), $(a).hide(), $(l).hide(), $(n).append('<div class="progress" style="display: block;height:0.24rem"><img src="../../img/piaog.gif"></div>'), $(t).hide(), $(".sixLotteryContent").hide()) : ($(a).show(), $(l).show(), $(n).find(".progress").remove(), $(t).show(), $(".sixLotteryContent").show())
}, hometools.ifObj = function (e) {
    var s = null;
    return "object" != (void 0 === e ? "undefined" : _typeof(e)) ? s = JSON.parse(e) : (s = JSON.stringify(e), s = JSON.parse(s)), s
}, hometools.hadCode = function (e, s) {
    var i = ["10001", "10057", "10058", "10037", "10035", "10012", "10079"],
        n = ["10002", "10050", "10003", "10004", "10036", "10010", "10059", "10075", "10060", "10064", "10077", "10056"],
        a = ["10005", "10053", "10034", "10011", "10078", "10083"], l = ["10038"],
        t = ["10054", "10014", "10073", "10013", "10047", "10082", "10080"], o = ["10009"],
        r = ["10070", "10071", "10072"],
        d = ["10007", "10052", "10076", "10026", "10027", "10028", "10029", "10030", "10031", "10032", "10033", "10061", "10062", "10063"],
        c = ["10006", "10008", "10055", "10015", "10016", "10017", "10018", "10019", "10020", "10021", "10022", "10023", "10024", "10025", "10084"],
        u = ["10046", "10074", "10081"], p = ["10048"], m = ["10051"], z = ["20049"], f = ["10039", "10042", "10040", "10045"],
        x = ["10041", "10043", "10044"], h = !1;
    return "pk10" == s ? $(i).each(function (s) {
        e == this && (h = !0)
    }) : "ssc" == s ? $(n).each(function (s) {
        e == this && (h = !0)
    }) : "klsf" == s ? $(a).each(function (s) {
        e == this && (h = !0)
    }) : "gxklsf" == s ? $(l).each(function (s) {
        e == this && (h = !0)
    }) : "cqnc" == s ? $(o).each(function (s) {
        e == this && (h = !0)
    }) : "kuai3" == s ? $(d).each(function (s) {
        e == this && (h = !0)
    }) : "shiyi5" == s ? $(c).each(function (s) {
        e == this && (h = !0)
    }) : "jisukl8" == s ? $(t).each(function () {
        e == this && (h = !0)
    }) : "twc_new" == s ? $(r).each(function () {
        e == this && (h = !0)
    }) : "egxy" == s ? $(u).each(function () {
        e == this && (h = !0)
    }) : "smallSix" == s ? $(p).each(function () {
        e == this && (h = !0)
    }) : "speedSix" == s ? $(m).each(function () {
        e == this && (h = !0)
    }) : "aomenSix" == s ? $(z).each(function () {
        e == this && (h = !0)
    }) : "qgc" == s ? $(f).each(function () {
        e == this && (h = !0)
    }) : "qgc1" == s && $(x).each(function () {
        e == this && (h = !0)
    }), h
}, hometools.changeBackground = function (e) {
    $(e).find(".numblue").each(function () {
        $(this).text() >= 19 && $(this).addClass("numred")
    })
}, hometools.lotTemplate = {
    ssc: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">幸运时时彩</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="dragonTiger"></li><li class="lastli">|</li><li class="lastli">总和：</li><li class="lastli sumNum"></li><li class="lastli sumBigSmall"></li><li class="lastli sumSingleDouble"></li></ul></div></div>'
    }, pk10: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">极速赛车</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="pk10li numberbox"><li class="nub01"></li><li class="nub02"></li><li class="nub03"></li><li class="nub04"></li><li class="nub05"></li><li class="nub06"></li><li class="nub07"></li><li class="nub08"></li><li class="nub09"></li><li class="nub10"></li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="firstDT"></li><li class="secondDT"></li><li class="thirdDT"></li><li class="fourthDT"></li><li class="fifthDT"></li><li class="lastli">|</li><li class="lastli">冠亚和：</li><li class="lastli sumFS"></li><li class="lastli sumBigSamll"></li><li class="lastli sumSingleDouble"></li></ul></div></div>'
    }, kuai3: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">江苏快3</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="k3li numberbox"><li class="num2"></li><li class="num4"></li><li class="num6"></li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="lastli">总和：</li><li class="lastli sumNum">1</li><li class="lastli sumBigSmall">大</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, shiyi5: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">广东11选5</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="dragonTiger">虎</li><li class="lastli">|</li><li class="lastli">总和：</li><li class="lastli sumNum">10</li><li class="lastli sumBigSmall">大</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, klsf: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">广东快乐十分</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li><li>7</li><li>8</li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="firstDragonTiger">虎</li><li class="secondDragonTiger">虎</li><li class="thirdDragonTiger">虎</li><li class="fourthDragonTiger">虎</li><li class="lastli">|</li><li class="lastli">总和：</li><li class="lastli sumNum">10</li><li class="lastli sumBigSmall">大</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, gxklsf: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">广东快乐十分</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li><li>7</li><li>8</li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="firstDragonTiger">虎</li><li class="secondDragonTiger">虎</li><li class="thirdDragonTiger">虎</li><li class="fourthDragonTiger">虎</li><li class="lastli">|</li><li class="lastli">总和：</li><li class="lastli sumNum">10</li><li class="lastli sumBigSmall">大</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, jisukl8: function (e) {
        return '<div class="lilist Super8" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">极速快乐8</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>01</li><li>02</li><li>03</li><li>04</li><li>05</li><li>06</li><li>07</li><li>08</li><li>09</li><li>10</li><li>11</li><li>12</li><li>13</li><li>14</li><li>15</li><li>16</li><li>17</li><li>18</li><li>19</li><li>20</li><li>21</li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="lastli">总和：</li><li class="lastli sumNum">10</li><li class="lastli sumBigSmall">大</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, cqnc: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">广东快乐十分</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li><li>7</li><li>8</li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="firstDragonTiger">虎</li><li class="secondDragonTiger">虎</li><li class="thirdDragonTiger">虎</li><li class="fourthDragonTiger">虎</li><li class="lastli">|</li><li class="lastli">总和：</li><li class="lastli sumNum">10</li><li class="lastli sumBigSmall">大</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, egxy: function (e) {
        return '<div class="egxy_div lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">PC蛋蛋幸运28</span><span><label class="preIssue preDrawIssue">588258</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul id="pk10num" class="sscli numberbox"><li>03</li><li>01</li><li>05</li><li class="sumNum">06</li></ul><span class="addF1 addicon iconspan"></span><span class="addF2 addicon iconspan"></span><span class="equalF iconspan"></span></div><div class="boxline"><ul class="pk10li li3"><li class="lastli">总和：</li><li class="lastli sumNum"></li><li class="lastli sumBigSmall"></li><li class="lastli sumSingleDouble"></li></ul></div></div>'
    }, twc_new: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">台湾大乐透</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li class="">1</li><li class="">2</li><li class="">3</li><li class="">4</li><li class="">5</li><li class="">6</li><li class="tw_red">7</li></ul></div><div class="boxline"><ul class="pk10li li3"><li class="lastli">总和：</li><li class="lastli sumNum"></li><li class="lastli sumBigSmall"></li><li class="lastli sumSingleDouble"></li></ul></div></div>'
    }, qgc: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">广东快乐十分</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li><li>7</li><li>8</li></ul></div><div class="boxline"><ul class="pk10li li3">\x3c!-- <li class="firstDragonTiger">虎</li><li class="secondDragonTiger">虎</li><li class="thirdDragonTiger">虎</li><li class="fourthDragonTiger">虎</li><li class="lastli">|</li> --\x3e<li class="lastli">总和：</li><li class="lastli sumNum">10</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, qgc1: function (e) {
        return '<div class="lilist" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">广东快乐十分</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span>距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div class="boxline kajianhao"><ul class="sscli numberbox"><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li></ul></div><div class="boxline"><ul class="pk10li li3">\x3c!-- <li class="firstDragonTiger">虎</li><li class="secondDragonTiger">虎</li><li class="thirdDragonTiger">虎</li><li class="fourthDragonTiger">虎</li><li class="lastli">|</li> --\x3e<li class="lastli">总和：</li><li class="lastli sumNum">10</li><li class="lastli sumSingleDouble">双</li></ul></div></div>'
    }, smallSix: function (e) {
        return '<div class="lilist six-lottery" id="' + e + '"><div class="boxline l1box "><div><span class="lotName">香港六合彩</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span >距下期开奖</span><span class="redfont"><span class="bgtime day">00</span><span class="daytxt colon">天</span><span class="bgtime hour">00</span><span class="hourtxt colon">时</span><span class="bgtime minute">00</span><span class="minutetxt colon">分</span><span class="bgtime second">00</span><span class="secondtxt colon">秒</span></span></span></div></div><div id="sixLotteryContent"><div class="kjspr kajianhao" ><div class="numbox"><ul id="jnumber" class="numberbox"><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=" addpic"></li><li class=" lastnub"></li></ul><ul class="sh_xzlist"><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li class="lastsh_xzlist"><span></span><span></span></li></ul>\x3c!-- <div class="six-lottery__next-draw-date">下期<span id="sixLotteryDate" ></span>开奖</div> --\x3e</div></div><div class="sixadv">\x3c!--<a id="sixadv" href="sixColor_index.html" target="_blank"></a>--\x3e<span class="zongfen">总分：<span id="zongfen"></span></span></div></div><div id="openingLottery" style="color: #de0846; margin: 10px 0 0 10px; display: none;">开奖中...</div></div>'
    }, speedSix: function (e) {
        return '<div class="lilist six-lottery" id="' + e + '"><div class="boxline l1box"><div><span class="lotName">极速六合彩</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span >距下期开奖</span><span class="redfont"><span class="hour" style="display: none;">00</span><span class="hourtxt colon" style="display: none;">:</span><span class="minute">08</span><span class="colon">:</span><span class="second">18</span></span></span></div></div><div id="sixLotteryContent"><div class="kjspr kajianhao" ><div class="numbox"><ul id="jnumber" class="numberbox"><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=" addpic"></li><li class=" lastnub"></li></ul><ul class="sh_xzlist"><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li class="lastsh_xzlist"><span></span><span></span></li></ul></div></div><div class="sixadv"><span class="zongfen">总分：<span id="zongfen"></span></span></div></div><div id="openingLottery" style="color: #de0846; margin: 10px 0 0 10px; display: none;">开奖中...</div></div>'
    }, aomenSix: function (e) {
        return '<div class="lilist six-lottery" id="' + e + '"><div class="boxline l1box "><div><span class="lotName">澳门六合彩</span><span><label class="preIssue preDrawIssue">585799</label>期</span><span class="displaynone nextIssue"></span></div><div><span class="opentyle redfont">开奖中...</span><span class="cuttime"><span >距下期开奖</span><span class="redfont"><span class="bgtime day">00</span><span class="daytxt colon">天</span><span class="bgtime hour">00</span><span class="hourtxt colon">时</span><span class="bgtime minute">00</span><span class="minutetxt colon">分</span><span class="bgtime second">00</span><span class="secondtxt colon">秒</span></span></span></div></div><div id="sixLotteryContent"><div class="kjspr kajianhao" ><div class="numbox"><ul id="jnumber" class="numberbox"><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=""></li><li class=" addpic"></li><li class=" lastnub"></li></ul><ul class="sh_xzlist"><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li><span></span><span></span></li><li class="lastsh_xzlist"><span></span><span></span></li></ul>\x3c!-- <div class="six-lottery__next-draw-date">下期<span id="sixLotteryDate" ></span>开奖</div> --\x3e</div></div><div class="sixadv">\x3c!--<a id="sixadv" href="sixColor_index.html" target="_blank"></a>--\x3e<span class="zongfen">总分：<span id="zongfen"></span></span></div></div><div id="openingLottery" style="color: #de0846; margin: 10px 0 0 10px; display: none;">开奖中...</div></div>'
    }
};