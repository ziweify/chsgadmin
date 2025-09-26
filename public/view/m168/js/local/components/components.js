function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
        return n
    }
    return Array.from(e)
}

function sidenav(e, t, n) {
    $(t).load(n), login(), $(e).on("touchstart", function (e) {
        e.preventDefault(), $(win_body).addClass("sidenav-active")
    }), $(win_body).on("click", ".close-panel svg, .sidenav-overlay, .menu a", function (e) {
        sessionStorage.removeItem("backToHomePage"), $(win_body).removeClass("sidenav-active")
    }), 1 == sessionStorage.getItem("backToHomePage") && $(win_body).addClass("sidenav-active");
    var o = "", r = "", i = window.location.hostname;
    -1 != i.indexOf("192.168") && void 0 != window.location.href.split(":")[2] ? -1 != (i += ":" + window.location.href.split(":")[2].split("/")[0]).indexOf("192.168.1.105") ? (o += "/168_WEBAPP/html/Quizzes/transfer.html?Name", r += "/168_WEBAPP/html/public/home.html?sit12") : (o += "/168/168_WEBAPP/html/Quizzes/transfer.html?Name", r += "/168/168_WEBAPP/html/public/home.html?sit12") : -1 != i.indexOf("192.168.1.143") ? (o += "/webapp/html/Quizzes/transfer.html?Name", r += "/webapp/html/public/home.html?sit12") : (o += "/html/Quizzes/transfer.html?Name", r += "/html/public/home.html?sit12"), $(t).on("click", ".register li", function () {
        var e = $(this).attr("id");
        "loge" == e ? window.location.href = config.loginUrl + "login?callbackUrl=http://" + i + o : "enroll" == e && (window.location.href = config.loginUrl + "register?callbackUrl=http://" + i + r)
    });
    var a = "";
    -1 != i.indexOf("192.168") && void 0 != window.location.href.split(":")[2] ? -1 != (i += ":" + window.location.href.split(":")[2].split("/")[0]).indexOf("192.168.1.105") ? a += "/168_WEBAPP/html/public/home.html" : a += "/168/168_WEBAPP/html/public/home.html" : -1 != i.indexOf("192.168.1.143") ? a += "/webapp/html/public/home.html" : a += "/html/public/home.html", $(t).on("click", "#quit", function () {
        var e = window.location.href, t = e.indexOf("?");
        e = e.slice(0, t), window.location.href = e, sessionStorage.removeItem("tokens"), sessionStorage.removeItem("takeOut"), sessionStorage.removeItem("nameId"), window.localStorage.removeItem("tokenInfo"), window.localStorage.removeItem("userId"), window.localStorage.removeItem("userSub"), window.localStorage.removeItem("hotLotNameList"), window.location.replace("http://" + i + a)
    })
}

function uniCZList() {
    var e = [].concat(_toConsumableArray(cZ.toRMC), _toConsumableArray(cZ.toJSC), _toConsumableArray(cZ.toSGC), _toConsumableArray(cZ.toGPC), _toConsumableArray(cZ.toJWC), _toConsumableArray(cZ.toQGC));
    return [].concat(_toConsumableArray(new Set(e.map(function (e) {
        return e.id
    })))).map(function (t) {
        return {
            id: t, name: e.find(function (e) {
                return e.id === t
            }).name, enable: e.find(function (e) {
                return e.id === t
            }).enable
        }
    })
}

function renderPreferredSelection(e, t, n) {
    var o = finalPreferred = [], r = "<ul>";
    t.forEach(function (e) {
        var t = !1 === e.enable ? "<img class='stop-icon' src='../../img/icon/icon_stop_0621.png'>" : "";
        r += "<li data-id='" + e.id + "'><span>" + e.name + t + "</span></li>"
    }), r += "</ul>", $(e).html(r), $(e).off("click", "li"), $(components.preferredLotSelection.savePlusBack).off("click"), $(e).on("click", "li", function (e) {
        var t = n.indexOf($(e.currentTarget).data("id").toString());
        t >= 0 ? n.splice(t, 1) : n.push($(e.currentTarget).data("id").toString()), togglePreferenceUi(n), finalPreferred = updatePreferenceList(n, fullLotList, 0), o = updatePreferenceList(n, fullLotList, 1), renderPreferredSelection(components.preferredLotSelection.preferredEle, finalPreferred, n), renderPreferredSelection(components.preferredLotSelection.selectionEle, o, n), $(components.preferredLotSelection.savePlusBack).on("touchstart", function (e) {
            e.preventDefault(), ajaxUpdateLotPreference(n, $(this).attr("href"))
        })
    })
}

function updatePreferenceList(e, t, n) {
    var o = forSelection = [];
    return 0 == n ? (e.forEach(function (e) {
        t.forEach(function (t) {
            t.id.toString() == e && o.push({id: t.id, name: t.name, enable: t.enable})
        })
    }), o) : 1 == n ? forSelection = t.filter(function (t) {
        return !e.includes(t.id.toString())
    }) : void 0
}

function togglePreferenceUi(e) {
    0 == e.length ? ($(components.preferredLotSelection.preferredTitle).text("添加您已关注的彩种"), $(components.preferredLotSelection.zeroPreferredMsg).show(), $(components.preferredLotSelection.preferredList).hide()) : ($(components.preferredLotSelection.preferredTitle).text("您已关注" + e.length + "个彩种 （点击取消）"), $(components.preferredLotSelection.zeroPreferredMsg).hide(), $(components.preferredLotSelection.preferredList).show())
}

function ajaxUpdateLotPreference(e, t) {
    $.ajax({
        headers: {token: components.login.tokenInfo},
        url: config.publicUrl + "user/updateUserPreferences.do",
        type: "POST",
        data: {userPreferences: e.toString()},
        success: function (e) {
        },
        complete: function (e, n) {
            "success" == n && (window.location.href = t)
        },
        error: function () {
        }
    })
}

function ajaxRenderPreferredLotList(e) {
    e = e || !1;
    var t = "lottery/getLotteryListByHot.do";
    if ("undefined" != components.login.tokenInfo && null != components.login.tokenInfo && "" != components.login.tokenInfo) {
        var n = [], o = finalPreferred = [];
        $.ajax({
            headers: {token: components.login.tokenInfo},
            url: config.publicUrl + "user/userPreferences.do",
            type: "GET",
            data: "json",
            success: function (t) {
                t = JSON.parse(t), n = t.result.data.userPreferences.userPreferences, n = n.length > 0 ? n.split(",") : [], finalPreferred = updatePreferenceList(n, fullLotList, 0), e || (o = updatePreferenceList(n, fullLotList, 1), togglePreferenceUi(n)), localStorage.setItem("hotLotNameList", finalPreferred.map(function (e) {
                    return e.name
                })), e || (renderPreferredSelection(components.preferredLotSelection.preferredEle, finalPreferred, n), renderPreferredSelection(components.preferredLotSelection.selectionEle, o, n))
            },
            complete: function (n, o) {
                "success" == o && e && (t += "?select=" + localStorage.getItem("hotLotNameList"), indexObj.ajaxInit(config.publicUrl + t, 4, {}))
            },
            error: function () {
            }
        })
    } else e && indexObj.ajaxInit(config.publicUrl + t, 4, {})
}

function btmQuickMenu(e, t) {
    var n = "";
    $(e).load(t), $(e).on("click", ".quizzes", function () {
        var e = localStorage.getItem("tokenInfo"), t = localStorage.getItem("localS");
        window.location.href = null == e ? "../Quizzes/index.html?" : "../Quizzes/index.html?" + t
    }), $(win_body).on("click", "#promoKjwApp", function (e) {
        e.preventDefault();
        var t = $("#promoApp");
        "true" === sessionStorage.getItem("isDomainNoAdv") ? (n = $(e.target).data("link-no-ad"), t.find(".copy").attr("data-link", n), t.find(".QRCode").attr("src", "../../img/zhuidan/" + $(e.target).data("qr-no-ad"))) : "false" === sessionStorage.getItem("isDomainNoAdv") && (n = $(e.target).data("link"), t.find(".copy").attr("data-link", n), t.find(".QRCode").attr("src", "../../img/zhuidan/" + $(e.target).data("qr"))), t.find(".header").text($(e.target).text()), t.show()
    }), $(win_body).on("click", "#promoZhuiDanApp", function (e) {
        e.preventDefault();
        var t = $("#promoApp");
        n = $(e.target).data("link"), t.find(".header").text($(e.target).text()), t.find(".copy").attr("data-link", n), t.find(".QRCode").attr("src", "../../img/zhuidan/" + $(e.target).data("qr")), t.show()
    }), $(win_body).on("click", ".padlock, #promoApp", function () {
        $("#promoApp").hide()
    }), $(win_body).on("click", ".promoInfo", function (e) {
        e.stopPropagation()
    }), $(win_body).on("click", ".goto", function (e) {
        window.open(n, "_blank")
    })
}

function toggleMemberSection(e) {
    $(e).on("touchstart", "#memberMenu li a", function () {
        void 0 !== $(this).attr("data-text") && (sessionStorage.setItem("selectedMemberMenu", $(this).attr("data-text")), window.location.href = "../Quizzes/personal-data.html")
    })
}

function toggleLoginForm() {
    "undefined" != components.login.tokenInfo && null != components.login.tokenInfo && "" != components.login.tokenInfo ? (nameDate(components.login.tokenInfo), $(".non-member").addClass("hide"), $(".member").removeClass("hide")) : ($(".non-member").removeClass("hide"), $(".member").addClass("hide"))
}

function login() {
    var e = window.location.search.split("?")[2], t = window.location.search.split("?")[1];
    void 0 != e && (localStorage.setItem("tokenInfo", e.split("=")[1]), localStorage.setItem("localS", t)), components.login.tokenInfo = localStorage.getItem("tokenInfo")
}

function nameDate(e) {
    $("#userInfo #username").text();
    customAjax(e, "user/info.do", "", !0, nameHtml, "#userInfo #username", "GET")
}

function customAjax(e, t, n, o, r, i, a) {
    $.ajax({
        headers: {token: e},
        url: urlbublic + t,
        type: a,
        dataType: "json",
        data: n,
        timeout: 6e4,
        asasync: !1,
        beforeSend: function (e) {
        },
        success: function (e) {
            r(e, i)
        },
        error: function (e) {
        },
        complete: function (e, t) {
        }
    })
}

function nameHtml(e, t) {
    var n = tools.parseObj(e);
    if (0 == e.errorCode) {
        if (100007 == n.result.businessCode && ($(".non-member").addClass("hide"), $(".member").removeClass("hide")), null == (n = n.result.data)) return void tokenExpire();
        localStorage.getItem("tokenInfo").split("=")[1], $(t).text(n.userName), $("#balance").text(n.balance), $("#fan").text(n.fan);
        var o = n.userName;
        sessionStorage.setItem("nameId", o), deleteUrl && "takeOut" != sessionStorage.getItem("takeOut") && takeOutUrlToken()
    } else alert("error!")
}

function takeOutUrlToken() {
    var e = window.location.href, t = e.indexOf("?token");
    t > -1 && (e = e.slice(0, t)), window.location.replace(e), sessionStorage.setItem("takeOut", "takeOut"), deleteUrl = !1
}

function tokenExpire() {
    window.localStorage.removeItem("tokenInfo"), localStorage.removeItem("hotLotNameList"), sessionStorage.removeItem("nameId"), $(".member").addClass("hide"), $(".non-member").removeClass("hide"), $(".pagediv").on("click", function () {
        window.location.href = config.loginUrl + "login?callbackUrl=http://" + urlList + loginIn
    })
}

function save() {
    if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
        var e = document.getElementById("testImg"), t = document.createElement("a");
        t.href = e.src, t.download = e.src.substring(e.src.lastIndexOf("/") + 1), (o = document.getElementById("downloadSnackbar")).className = "showSnack", setTimeout(function () {
            o.className = o.className.replace("showSnack", "")
        }, 3e3), t.click()
    } else {
        var e = document.getElementById("testImg"), n = document.createElement("a");
        n.href = e.src, n.download = e.src.substring(e.src.lastIndexOf("/") + 1);
        var o = document.getElementById("downloadSnackbar");
        o.className = "showSnack", setTimeout(function () {
            o.className = o.className.replace("showSnack", "")
        }, 3e3), n.click()
    }
}

var components = {
    sidenav: {trigger: "#hamburger", ele: "#sidenav", src: "/html/components/sidenav.html?v=1.0.0"},
    btmQuickMenu: {ele: "#btmQuickMenu", src: "/html/components/btm_quick_menu.html?v=1.0.0"},
    login: {tokenInfo: ""},
    moreMenu: {trigger: "#moreMenu", ele: "#moreMenuWrap", src: "../components/more_menu.html"},
    preferredLotSelection: {
        selectionEle: "#originalList",
        preferredEle: "#preferredList",
        savePlusBack: "#savePlusBack",
        preferredTitle: "#preferredTitle",
        zeroPreferredMsg: "#zeroPreferredMsg",
        preferredList: "#preferredList"
    }
}, win_body = "body", fullLotList = uniCZList();
sidenav(components.sidenav.trigger, components.sidenav.ele, components.sidenav.src), btmQuickMenu(components.btmQuickMenu.ele, components.btmQuickMenu.src);
var deleteUrl = !0, urlbublic = config.publicUrl, urlList = window.location.hostname, urlPeek = "", loginIn = "";
-1 != urlList.indexOf("192.168") && void 0 != window.location.href.split(":")[2] ? -1 != (urlList += ":" + window.location.href.split(":")[2].split("/")[0]).indexOf("192.168.1.105") ? (urlPeek += "/168_WEBAPP/html/Quizzes/personal-data.html", loginIn += "/168_WEBAPP/html/Quizzes/transfer.html?Name") : (urlPeek += "/168/168_WEBAPP/html/Quizzes/personal-data.html", loginIn += "/168/168_WEBAPP/html/Quizzes/transfer.html?Name") : -1 != urlList.indexOf("192.168.1.143") ? (urlPeek += "/webapp/html/Quizzes/personal-data.html", loginIn += "/webapp/html/Quizzes/transfer.html?Name") : (urlPeek += "/html/Quizzes/personal-data.html", loginIn += "/html/Quizzes/transfer.html?Name");
var takeOut = !0;
$(win_body).on("click", ".copy", function (e) {
    var t = this.dataset.link;
    if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) navigator.clipboard && (navigator.clipboard.writeText(t), setTimeout(function () {
        o.className = o.className.replace("showSnack", "")
    }, 3e3)); else {
        var n = $("<input>");
        $("body").append(n), n.val(t).select(), document.execCommand("copy"), n.remove();
        var o = document.getElementById("copySnackbar");
        o.className = "showSnack", setTimeout(function () {
            o.className = o.className.replace("showSnack", "")
        }, 3e3)
    }
});