function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
function goRun() {
    syxwV.intoKai(), syxwV.startAnimateTry()
}

function createNum(i, n) {
    var e = n - i, a = Math.random();
    return i + Math.round(a * e)
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
    var i = function (i, n) {
        n || (n = window.location.href), i = i.replace(/[\[\]]/g, "\\$&");
        var e = new RegExp("[?&]" + i + "(=([^&#]*)|&|#|$)").exec(n);
        return e ? e[2] ? decodeURIComponent(e[2].replace(/\+/g, " ")) : "" : null
    }("code"), n = "img/bjkl8Logo.png";
    null != i && (n = "img/" + i + ".png"), $("#video-logo").attr("src", n), $("#soundBth").on("click", function () {
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
    var n = i, e = n.pop();
    return n.unshift(e), n
}, syxwV.startVid = function (i) {
    $("#hourtxt").show(), $("#opening").hide(), bgMusic(), syxwV.Data(i, 1)
}, syxwV.stopVid = function (i) {
    $("#hourtxt").show(), $("#opening").hide(), clearInterval(KJinit), bgMusic(), KJing < 5 ? setTimeout(function () {
        syxwV.stopAllFun(i.preDrawCode), KJing = 0, syxwV.Data(i, 2)
    }, 5e3) : (syxwV.stopAllFun(i.preDrawCode), KJing = 0, syxwV.Data(i, 2))
}, syxwV.Data = function (i, n) {
    $(".numList").find("ul").empty();
    var e = i.preDrawCode;
    1 == n && (e = syxwV.moveEle(e)), $("#issue").text(i.drawIssue), $("#kaiTime").text(i.drawTime);
    var a = i.preDrawTime.split(":");
    a[0], a[1], a[2];
    syxwV.cutTime(syxwV.getSecond(i.preDrawTime));
    for (var t = "", s = "", o = "", l = 0; l < e.length; l++) 0 == l ? s = "<li class='codeRed" + e[l] + "'></li>" : e[l] < 10 ? (numCode = "0" + e[l], o += "<li class='code" + numCode + "'></li>") : o += "<li class='code" + e[l] + "'></li>";
    t = s + o, $(".numList").find("ul").append(t)
}, syxwV.pcFillData = function (i, n, e, a) {
    $("#hourtxt").hide(), $("#opening").show(), $(".numList").find("ul").empty();
    var t = e;
    1 == a && (t = syxwV.moveEle(t)), $("#issue").text(i), $("#kaiTime").text(n);
    for (var s = "", o = "", l = "", r = 0; r < t.length; r++) 0 == r ? o = "<li class='codeRed" + t[r] + "'></li>" : t[r] < 10 ? (numCode = "0" + t[r], l += "<li class='code" + numCode + "'></li>") : l += "<li class='code" + t[r] + "'></li>";
    s = o + l, $(".numList").find("ul").append(s)
}, syxwV.getSecond = function (i) {
    var n = i.split(":"), e = n[0], a = n[1], t = n[2];
    return 3600 * (e = e < 10 ? e.substring(e.length - 1, e.length) : e) + 60 * (a = a < 10 ? a.substring(a.length - 1, a.length) : a) + 1 * (t = t < 10 ? t.substring(t.length - 1, t.length) : t)
}, syxwV.cutTime = function (i) {
    null != timer && clearInterval(timer);
    var i = i;
    timer = setInterval(function () {
        if (i >= 1) {
            i -= 1;
            var n = Math.floor(i / 3600), e = Math.floor(i / 60 % 60), a = Math.floor(i % 60), t = "";
            if (t = (n < 10 ? "0" + n : n) + " : ", t = t + "" + (e < 10 ? "0" + e : e) + " : " + (a < 10 ? "0" + a : a), $("#hourtxt").text(t), i < 10) {
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
        var e = "";
        if (0 == n) for (var a = [1, 2, 3, 4, 5, 10], t = 0; t < a.length; t++) e += "<li class='numRed" + a[t] + "'></li>"; else if (n == i - 1) for (s = 0; s < 8; s++) e += "<li class='num" + (s + 1) + "0'></li>"; else for (var s = 0; s < 8; s++) e += "<li class='num" + s + n + "'></li>";
        $("#defaultDiv").find(".paLi").eq(n).find(".sonUl").append(e)
    }
}, syxwV.createKaiPaLi = function () {
    for (var i = $("#kaiDiv").find(".paUl .pipkai").length, n = 0; n < i; n++) {
        var e = "";
        if (0 == n) for (a = 0; a < 6; a++) e += 5 == a ? "<li class='numRed10'></li>" : "<li class='numRed" + (a + 1) + "'></li>"; else if (n == i - 1) for (a = 0; a < 8; a++) e += "<li class='num" + (a + 1) + "0'></li>"; else for (var a = 0; a < 8; a++) e += a < 6 ? "<li  class='num" + a + n + "'></li>" : "<li class='num" + a + n + "'></li>";
        $("#kaiDiv").find(".pipkai").eq(n).find(".sonUl").append(e)
    }
}, syxwV.startDrop = function () {
    var i = $("#kaiDiv").find(".paUl .pipkai").length;
    $("#kaiDiv").find(".paUl .pipkai").eq(n).find(".sonUl").addClass(".positionR");
    for (var n = 0; n < i; n++) syxwV.dropBall(n)
}, syxwV.dropBall = function (i) {
    var n;
    n = 0 == i ? 11 : 15;
    var e = setInterval(function () {
        y1 = $("#kaiDiv").find(".paUl .pipkai").eq(i).find(".sonUl li").eq(n).position().top + 6 * n, n <= 14 && (y1 += 46), syxwV.run(y1, i, n, scale), --n < 0 && clearInterval(e)
    }, 100)
}, syxwV.run = function (i, n, e, a) {
    var t = createNum(-80, 50), s = $("#kaiDiv").find(".paUl .pipkai").eq(n).find(".sonUl li").eq(e).position().left,
        o = s / a + t;
    0 == n && o < -35 && (o = -35), $("#kaiDiv").find(".paUl .pipkai").eq(n).find(".sonUl li").eq(e).animate({left: s + 18 * n + "px"}, 1).animate({
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
            $("#kaiDiv").find(".paUl .pipkai").find(".sonUl").removeClass(".positionR"), kaiMusic(), syxwV.szjCir();
            var i = setInterval(function () {
                syxwV.createBall()
            }, 285);
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
    }, 5e3)
}, syxwV.createBall = function () {
    for (var i, n = "", e = $(".paUl .pipkai:lt(6)").find(".sonUl").find("li"), a = $(".paUl .pipkai:gt(5)").find(".sonUl").find("li"), t = 0; t < e.length; t++) n = createNum(0, 450), (i = createNum(130, 466)) > 240 && i < 333 && n > 140 && n < 233 && (i = 240, n = 140), syxwV.ltfun(e[t], n, i);
    for (t = 0; t < a.length; t++) n = createNum(350, 836), (i = createNum(130, 466)) > 240 && i < 333 && n > 591 && n < 680 && (i = 240, n = 591), syxwV.ltfun(a[t], n, i)
}, syxwV.ltfun = function (i, n, e) {
    if ($(i).hasClass("checkBall")) return !1;
    var a = createNum(100, 500);
    $(i).animate({top: e + "px", left: n + "px"}, a)
}, syxwV.stopFun = function (i) {
    var n, e, a, t = 87, s = !0, o = "numRed", l = (a = i).pop();
    a.unshift(l);
    for (var r = 0; r < a.length; r++) 0 == r ? (o += a[r], $(".paUl .pipkai").eq(0).find(".sonUl").find("li"), syxwV.checkFun_Red(o)) : ((n = a[r]) < 10 && (n = "0" + n), e = "num" + n, r < 11 ? (syxwV.checkFun(e, t, 1), t += r >= 5 && r <= 10 ? 82 : 80) : (s && (t = 87, s = !1), syxwV.checkFun(e, t, 2), t += r >= 15 && r <= 20 ? 82 : 80))
}, syxwV.stopFunTry = function (i) {
    var n, e, a, t = 87, s = !0, o = "numRed";
    a = i;
    for (var l = 0; l < a.length; l++) 0 == l ? (o += a[l], $(".paUl .pipkai").eq(0).find(".sonUl").find("li"), syxwV.checkFun_Red(o)) : ((n = a[l]) < 10 && (n = "0" + n), e = "num" + n, l < 11 ? (syxwV.checkFun(e, t, 1), t += l >= 5 && l <= 10 ? 82 : 80) : (s && (t = 87, s = !1), syxwV.checkFun(e, t, 2), t += l >= 15 && l <= 20 ? 82 : 80))
}, syxwV.checkFun_Red = function (i) {
    var n = $("." + i);
    syxwV.redAnimate(n)
}, syxwV.redAnimate = function (i) {
    $(i[1]).addClass("checkBall").animate({top: "120px", left: "7px"}, 500).animate({top: "0px"}, 500)
}, syxwV.checkFun = function (i, n, e) {
    var a = $("." + i);
    1 == e ? syxwV.animateFun1(a, n) : syxwV.animateFun2(a, n)
}, syxwV.animateFun1 = function (i, n) {
    $(i[1]).addClass("checkBall").animate({top: "120px", left: n + "px"}, 200).animate({top: "0px"}, 200)
}, syxwV.animateFun2 = function (i, n) {
    $(i[1]).addClass("checkBall").animate({top: "120px", left: n + "px"}, 1e3).animate({top: "48px"}, 1e3)
}, syxwV.ballDown = function () {
    var i, n = 0, e = $("#kaiDiv .pipkai").find(".sonUl li");
    $(e).each(function () {
        n = 430 + createNum(-15, 35), (i = $(this).hasClass("checkBall")) || $(this).animate({top: n + "px"})
    })
}, syxwV.createArr = function () {
    for (var i = [], n = 0; n < 20; n++) {
        var e = createNum(1, 80);
        if (0 != n) for (var a = 0, t = i.length - 1; a < i.length; a++) {
            if (e == i[a]) {
                n--;
                break
            }
            if (a == t) {
                i.push(e);
                break
            }
        } else i.push(e)
    }
    return i
}, syxwV.createTryArr = function () {
    var i, n = [1, 2, 3, 4, 5, 10][createNum(0, 5)];
    return (i = syxwV.createArr()).unshift(n), i
};