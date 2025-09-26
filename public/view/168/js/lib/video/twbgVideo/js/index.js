function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
function goRun() {
    syxwV.intoKai(), syxwV.startAnimateTry()
}

function createNum(i, n) {
    var t = n - i, a = Math.random();
    return i + Math.round(a * t)
}

function bgMusic() {
    audioType = "b", syxwV.sound.play("audioidBg"), syxwV.sound.stop("audioidKai")
}

function kaiMusic() {
    audioType = "r", syxwV.sound.play("audioidKai"), syxwV.sound.stop("audioidBg")
}

var syxwV = {}, isTry = !1, ifopen = !1, playa = "b", animateId = {}, timer = null,
    scale = parent.window.config.ifScalse, KJinit, KJing = 0;
$(function () {
    var query_code = getParameterByName("code");
    $("#box").addClass("b"+query_code);
    $("#soundBth").on("click", function () {
        "soundsOn" == $("#soundBth").attr("class") ? ($("#soundBth").removeClass("soundsOn").addClass("soundsOff"), syxwV.sound.stop("audioidKai"), syxwV.sound.stop("audioidBg")) : ($("#soundBth").removeClass("soundsOff").addClass("soundsOn"), "b" == audioType ? (syxwV.sound.play("audioidBg"), syxwV.sound.stop("audioidKai")) : (audioType, syxwV.sound.play("audioidKai"), syxwV.sound.stop("audioidBg")))
    }), $("#tryBtn").on("click", function () {
        if (isTry) return $(".jzCheck").show(), setTimeout(function () {
            $(".jzCheck").hide()
        }, 1e3), !1;
        isTry = !0, goRun()
    }), syxwV.createPaLi()
}), syxwV.sound = {
    play: function (i) {
        "soundsOn" == $("#soundBth").attr("class") && document.getElementById(i).play()
    }, stop: function (i) {
        document.getElementById(i).pause()
    }
}, syxwV.moveEle = function (i) {
    var n = i, t = n.pop();
    return n.unshift(t), n
}, syxwV.startVid = function (i) {
    $("#hourtxt").show(), $("#opening").hide(), bgMusic(), syxwV.Data(i, 1)
}, syxwV.stopVid = function (i) {
    $("#hourtxt").show(), $("#opening").hide(), clearInterval(KJinit), bgMusic(), KJing < 5 ? setTimeout(function () {
        syxwV.stopAllFun(i.preDrawCode), syxwV.Data(i, 2), KJing = 0
    }, 5e3) : (syxwV.stopAllFun(i.preDrawCode), syxwV.Data(i, 2), KJing = 0)
}, syxwV.Data = function (i, n) {
    $(".numList").find("ul").empty();
    var t = i.preDrawCode;
    1 == n && (t = syxwV.moveEle(t)), $("#issue").text(i.drawIssue), $("#kaiTime").text(i.drawTime);
    var a = i.preDrawTime.split(":");
    a[0], a[1], a[2];
    syxwV.cutTime(syxwV.getSecond(i.preDrawTime));
    for (var e = "", s = "", o = "", l = 0; l < t.length; l++) 0 == l ? s = "<li class='codetwRed" + t[l] + "'></li>" : t[l] < 10 ? (numCode = "0" + t[l], o += "<li class='code" + numCode + "'></li>") : o += "<li class='code" + t[l] + "'></li>";
    e = s + o, $(".numList").find("ul").append(e)
}, syxwV.pcFillData = function (i, n, t, a) {
    $(".numList").find("ul").empty();
    var e = t;
    1 == a && (e = syxwV.moveEle(e)), $("#issue").text(i), $("#kaiTime").text(n);
    for (var s = "", o = "", l = "", r = 0; r < e.length; r++) 0 == r ? o = "<li class='codeRed" + e[r] + "'></li>" : e[r] < 10 ? (numCode = "0" + e[r], l += "<li class='code" + numCode + "'></li>") : l += "<li class='code" + e[r] + "'></li>";
    s = o + l, $(".numList").find("ul").append(s)
}, syxwV.getSecond = function (i) {
    var n = i.split(":"), t = n[0], a = n[1], e = n[2];
    return 3600 * (t = t < 10 ? t.substring(t.length - 1, t.length) : t) + 60 * (a = a < 10 ? a.substring(a.length - 1, a.length) : a) + 1 * (e = e < 10 ? e.substring(e.length - 1, e.length) : e)
}, syxwV.cutTime = function (i) {
    null != timer && clearInterval(timer);
    var i = i;
    timer = setInterval(function () {
        if (i >= 1) {
            i -= 1;
            var n = Math.floor(i / 3600), t = Math.floor(i / 60 % 60), a = Math.floor(i % 60), e = "";
            if (e = (n < 10 ? "0" + n : n) + " : ", e = e + "" + (t < 10 ? "0" + t : t) + " : " + (a < 10 ? "0" + a : a), $("#hourtxt").text(e), i < 10) {
                var s = $(".linelist").find("li");
                $(s).eq(i).addClass("redli")
            }
        } else clearInterval(timer), $("#hourtxt").hide(), $("#opening").show(), syxwV.sound.stop("audioidBg"), syxwV.sound.stop("audioidKai"), syxwV.intoKai(), KJinit = setInterval(function () {
            KJing++
        }, 1e3), syxwV.startFun()
    }, 1e3)
}, syxwV.clearTime = function () {
    clearInterval(timer)
}, syxwV.intoKai = function () {
    $("#defaultDiv").animate({"z-index": "-1", height: "0"}, 500), $("#kaiDiv").animate({top: "180px"}, 500);
    for (var i = 0; i < 2; i++) syxwV.createKaiPaLi()
}, syxwV.recover = function () {
    $("#defaultDiv").animate({
        "z-index": "1",
        height: "540"
    }, 500), $("#kaiDiv").animate({top: "720px"}, 500), $("#kaiDiv").find(".pipkai ul li").remove()
}, syxwV.createPaLi = function () {
    for (var i = $("#defaultDiv").find(".paUl .paLi").length, n = 0; n < i; n++) {
        var t = "";
        if (0 == n) for (a = 0; a < 8; a++) t += "<li class='twRed" + (a + 1) + "'></li>"; else if (n == i - 1) for (a = 0; a < 8; a++) t += "<li class='num" + (a + 1) + "0'></li>"; else for (var a = 0; a < 8; a++) t += "<li class='num" + a + n + "'></li>";
        $("#defaultDiv").find(".paLi").eq(n).find(".sonUl").append(t)
    }
}, syxwV.createKaiPaLi = function () {
    for (var i = $("#kaiDiv").find(".paUl .pipkai").length, n = 0; n < i; n++) {
        var t = "";
        if (0 == n) for (a = 0; a < 8; a++) t += "<li class='twRed" + (a + 1) + "'></li>"; else if (n == i - 1) for (a = 0; a < 8; a++) t += "<li class='num" + (a + 1) + "0'></li>"; else for (var a = 0; a < 8; a++) t += a < 6 ? "<li  class='num" + a + n + "'></li>" : "<li class='num" + a + n + "'></li>";
        $("#kaiDiv").find(".pipkai").eq(n).find(".sonUl").append(t)
    }
}, syxwV.startDrop = function () {
    for (var i = $("#kaiDiv").find(".paUl .pipkai").length, n = 0; n < i; n++) syxwV.dropBall(n)
}, syxwV.dropBall = function (i) {
    var n = 15, t = setInterval(function () {
        y1 = $("#kaiDiv").find(".paUl .pipkai").eq(i).find(".sonUl li").eq(n).position().top + 6 * n, n <= 14 && (y1 += 46), syxwV.run(y1, i, n, scale), --n < 0 && clearInterval(t)
    }, 100)
}, syxwV.run = function (i, n, t, a) {
    var e = createNum(-80, 50), s = $("#kaiDiv").find(".paUl .pipkai").eq(n).find(".sonUl li").eq(t).position().left,
        o = s / a + e;
    0 == n && o < -35 && (o = -35), $("#kaiDiv").find(".paUl .pipkai").eq(n).find(".sonUl li").eq(t).animate({left: s + 18 * n + "px"}, 1).animate({
        top: i + 340 + "px",
        left: o + "px"
    }, 800)
}, syxwV.startAnimateTry = function () {
    syxwV.sound.stop("audioidBg"), syxwV.sound.stop("audioidKai"), syxwV.startFun(), setTimeout(function () {
        syxwV.stopAllFun()
    }, 5e3)
}, syxwV.startFun = function () {
    scale = parent.window.config.ifScalse, setTimeout(function () {
        syxwV.startDrop(), setTimeout(function () {
            kaiMusic(), syxwV.szjCir();
            var i = setInterval(function () {
                syxwV.createBall()
            }, 290);
            animateId.tryid = i
        }, 2300)
    }, 500)
}, syxwV.szjCir = function () {
    $("#crossL").addClass("rotationL"), $("#crossR").addClass("rotationR"), setTimeout(function () {
        $("#crossL").addClass("rotationL2").removeClass("rotationL"), $("#crossR").addClass("rotationR2").removeClass("rotationR")
    }, 1e3)
}, syxwV.stopAllFun = function (i) {
    if (void 0 != i) syxwV.stopFun(i); else {
        var n = syxwV.createTryArr();
        syxwV.stopFunTry(n)
    }
    setTimeout(function () {
        clearInterval(animateId.tryid), syxwV.ballDown(), setTimeout(function () {
            $("#crossL").removeClass("rotationL2"), $("#crossR").removeClass("rotationR2"), bgMusic(), syxwV.recoverFun()
        }, 1500)
    }, 1e3)
}, syxwV.recoverFun = function () {
    setTimeout(function () {
        syxwV.recover(), isTry = !1
    }, 5500)
}, syxwV.createBall = function () {
    for (var i, n = "", t = $(".paUl .pipkai:lt(6)").find(".sonUl").find("li"), a = $(".paUl .pipkai:gt(5)").find(".sonUl").find("li"), e = 0; e < t.length; e++) n = createNum(0, 450), (i = createNum(130, 466)) > 240 && i < 333 && n > 140 && n < 233 && (i = 240, n = 140), syxwV.ltfun(t[e], n, i);
    for (e = 0; e < a.length; e++) n = createNum(350, 836), (i = createNum(130, 466)) > 240 && i < 333 && n > 591 && n < 680 && (i = 240, n = 591), syxwV.ltfun(a[e], n, i)
}, syxwV.ltfun = function (i, n, t) {
    if ($(i).hasClass("checkBall")) return !1;
    var a = createNum(100, 500);
    $(i).animate({top: t + "px", left: n + "px"}, a)
}, syxwV.stopFun = function (i) {
    var n, t, a, e = 87, s = !0, o = "twRed", l = (a = i).pop();
    a.unshift(l);
    for (var r = 0; r < a.length; r++) if (0 == r) {
        var u = "<li class='twRed" + a[r] + "'></li>";
        $(".pipkai:nth-child(1)>ul").append(u), o += a[r], syxwV.checkFun_Red(o)
    } else (n = a[r]) < 10 && (n = "0" + n), t = "num" + n, r < 11 ? (syxwV.checkFun(t, e, 1), e += r >= 5 && r <= 10 ? 82 : 80) : (s && (e = 87, s = !1), syxwV.checkFun(t, e, 2), e += r >= 15 && r <= 20 ? 82 : 80)
}, syxwV.stopFunTry = function (i) {
    var n, t, a, e = 87, s = !0, o = "twRed";
    a = i;
    for (var l = 0; l < a.length; l++) if (0 == l) {
        var r = "<li class='twRed" + a[l] + "'></li>";
        $(".pipkai:nth-child(1)>ul").append(r), o += a[l], syxwV.checkFun_Red(o)
    } else (n = a[l]) < 10 && (n = "0" + n), t = "num" + n, l < 11 ? (syxwV.checkFun(t, e, 1), e += l >= 5 && l <= 10 ? 82 : 80) : (s && (e = 87, s = !1), syxwV.checkFun(t, e, 2), e += l >= 15 && l <= 20 ? 82 : 80)
}, syxwV.checkFun_Red = function (i) {
    var n = $("." + i);
    syxwV.redAnimate(n)
}, syxwV.redAnimate = function (i) {
    var n = 1 * $(i[0]).attr("class").toString().replace(/twRed/g, "");
    n = n > 8 ? 0 : 1, $(i[n]).addClass("checkBall").animate({
        top: "120px",
        left: "7px"
    }, 500).animate({top: "0px"}, 500)
}, syxwV.checkFun = function (i, n, t) {
    var a = $("." + i);
    1 == t ? syxwV.animateFun1(a, n) : syxwV.animateFun2(a, n)
}, syxwV.animateFun1 = function (i, n) {
    $(i[1]).addClass("checkBall").animate({top: "120px", left: n + "px"}, 200).animate({top: "0px"}, 200)
}, syxwV.animateFun2 = function (i, n) {
    $(i[1]).addClass("checkBall").animate({top: "120px", left: n + "px"}, 1e3).animate({top: "48px"}, 1e3)
}, syxwV.ballDown = function () {
    var i, n = 0, t = $("#kaiDiv .pipkai").find(".sonUl li");
    $(t).each(function () {
        n = 430 + createNum(-15, 35), (i = $(this).hasClass("checkBall")) || $(this).animate({top: n + "px"})
    })
}, syxwV.createArr = function () {
    for (var i = [], n = 0; n < 20; n++) {
        var t = createNum(1, 80);
        if (0 != n) for (var a = 0, e = i.length - 1; a < i.length; a++) {
            if (t == i[a]) {
                n--;
                break
            }
            if (a == e) {
                i.push(t);
                break
            }
        } else i.push(t)
    }
    return i
}, syxwV.createTryArr = function () {
    var i, n = createNum(1, 80);
    return (i = syxwV.createArr()).unshift(n), i
};