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

var syxwV = {}, isTry = !1, ifopen = !1, playa = "b", animateId = {}, timer = null, scale = 1, KJinit, KJing = 0;
$(function () {
    $(".loading").fadeOut(1e3, function () {
    }), $("#soundBth").on("click", function () {
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
}, syxwV.startVid = function (i, n) {
    $("#hourtxt").show(), $("#opening").hide(), bgMusic(), syxwV.Data(i, 1, n)
}, syxwV.stopVid = function (i, n) {
    $("#hourtxt").show(), $("#opening").hide(), clearInterval(KJinit), bgMusic(), KJing < 5 ? setTimeout(function () {
        syxwV.stopAllFun(i.preDrawCode), KJing = 0, syxwV.Data(i, 2, n)
    }, 5e3) : (syxwV.stopAllFun(i.preDrawCode), KJing = 0, syxwV.Data(i, 2, n))
}, syxwV.Data = function (i, n, t) {
    $(".numList").find("ul").empty();
    var a = i.preDrawCode;
    1 == n && (a = syxwV.moveEle(a),a.length>=22 && a.pop()), $("#nextissue").val(i.drawIssue), $("#issue").text(i.preDrawIssue), $("#kaiTime").text(i.drawTime.split(" ")[1]), syxwV.cutTime(i.cutime, t);
    for (var e = "", s = "", o = "", u = 0; u < a.length; u++) 0 == u ? s = "<li class='codeRed" + a[u] + "'></li>" : a[u] < 10 ? (numCode = "0" + a[u], o += "<li class='code" + numCode + "'></li>") : o += "<li class='code" + a[u] + "'></li>";
    e = s + o, $(".numList").find("ul").append(e)
}, syxwV.getSecond = function (i) {
    var n = i.split(":"), t = n[0], a = n[1], e = n[2];
    return 3600 * (t = t < 10 ? t.substring(t.length - 1, t.length) : t) + 60 * (a = a < 10 ? a.substring(a.length - 1, a.length) : a) + 1 * (e = e < 10 ? e.substring(e.length - 1, e.length) : e)
}, syxwV.cutTime = function (i, n) {
    console.log(i), null != timer && clearInterval(timer);
    var i = i;
    timer = setInterval(function () {
        if (i >= 1) {
            i -= 1;
            var t = Math.floor(i / 3600), a = Math.floor(i / 60 % 60), e = Math.floor(i % 60), s = "";
            if (s = (t < 10 ? "0" + t : t) + " : ", s = s + "" + (a < 10 ? "0" + a : a) + " : " + (e < 10 ? "0" + e : e), $("#hourtxt").text(s), i < 10) {
                var o = $(".linelist").find("li");
                $(o).eq(i).addClass("redli")
            }
        } else clearInterval(timer), $("#hourtxt").hide(), $("#opening").show(), syxwV.sound.stop("audioidBg"), syxwV.sound.stop("audioidKai"), syxwV.intoKai(), KJinit = setInterval(function () {
            KJing++
        }, 1e3), syxwV.startFun(), setTimeout(pubmethod.doAjax($("#nextissue").val(), n.lotCode, n.type, !1), "500")
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
        if (0 == n) for (var a = [1, 2, 3, 4, 5, 10], e = 0; e < a.length; e++) t += "<li class='numRed" + a[e] + "'></li>"; else if (n == i - 1) for (s = 0; s < 8; s++) t += "<li class='num" + (s + 1) + "0'></li>"; else for (var s = 0; s < 8; s++) t += "<li class='num" + s + n + "'></li>";
        $("#defaultDiv").find(".paLi").eq(n).find(".sonUl").append(t)
    }
}, syxwV.createKaiPaLi = function () {
    for (var i = $("#kaiDiv").find(".paUl .pipkai").length, n = 0; n < i; n++) {
        var t = "";
        if (0 == n) for (a = 0; a < 6; a++) t += 5 == a ? "<li class='numRed10'></li>" : "<li class='numRed" + (a + 1) + "'></li>"; else if (n == i - 1) for (a = 0; a < 8; a++) t += "<li class='num" + (a + 1) + "0'></li>"; else for (var a = 0; a < 8; a++) t += a < 6 ? "<li  class='num" + a + n + "'></li>" : "<li class='num" + a + n + "'></li>";
        $("#kaiDiv").find(".pipkai").eq(n).find(".sonUl").append(t)
    }
}, syxwV.startDrop = function () {
    for (var i = $("#kaiDiv").find(".paUl .pipkai").length, n = 0; n < i; n++) syxwV.dropBall(n)
}, syxwV.dropBall = function (i) {
    var n;
    n = 0 == i ? 11 : 15;
    var t = setInterval(function () {
        y1 = $("#kaiDiv").find(".paUl .pipkai").eq(i).find(".sonUl li").eq(n).position().top + 6 * n, n <= 14 && (y1 += 46), console.log(y1), syxwV.run(y1, i, n, scale), --n < 0 && clearInterval(t)
    }, 100)
}, syxwV.run = function (i, n, t, a) {
    var e = createNum(-80, 50), s = $("#kaiDiv").find(".paUl .pipkai").eq(n).find(".sonUl li").eq(t).position().left,
        o = s / a + e;
    0 == n && o < -35 && (o = -35), $("#kaiDiv").find(".paUl .pipkai").eq(n).find(".sonUl li").eq(t).animate({left: s + "px"}, 1).animate({
        top: i + 340 + "px",
        left: o + "px"
    }, 800)
}, syxwV.startAnimateTry = function () {
    syxwV.sound.stop("audioidBg"), syxwV.sound.stop("audioidKai"), syxwV.startFun(), setTimeout(function () {
        syxwV.stopAllFun()
    }, 5e3)
}, syxwV.startFun = function () {
    scale = scale, setTimeout(function () {
        syxwV.startDrop(), setTimeout(function () {
            kaiMusic(), syxwV.szjCir();
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
    for (var i, n = "", t = $(".paUl .pipkai:lt(6)").find(".sonUl").find("li"), a = $(".paUl .pipkai:gt(5)").find(".sonUl").find("li"), e = 0; e < t.length; e++) n = createNum(0, 450), (i = createNum(130, 466)) > 240 && i < 333 && n > 140 && n < 233 && (i = 240, n = 140), syxwV.ltfun(t[e], n, i);
    for (e = 0; e < a.length; e++) n = createNum(350, 836), (i = createNum(130, 466)) > 240 && i < 333 && n > 591 && n < 680 && (i = 240, n = 591), syxwV.ltfun(a[e], n, i)
}, syxwV.ltfun = function (i, n, t) {
    if ($(i).hasClass("checkBall")) return !1;
    var a = createNum(100, 500);
    $(i).animate({top: t + "px", left: n + "px"}, a)
}, syxwV.stopFun = function (i) {
    var n, t, a, e = 87, s = !0, o = "numRed", u = (a = i).pop();
    a.unshift(u);
    for (var l = 0; l < a.length; l++) 0 == l ? (o += a[l], $(".paUl .pipkai").eq(0).find(".sonUl").find("li"), syxwV.checkFun_Red(o)) : ((n = a[l]) < 10 && (n = "0" + n), t = "num" + n, l < 11 ? (syxwV.checkFun(t, e, 1), e += l >= 5 && l <= 10 ? 82 : 80) : (s && (e = 87, s = !1), syxwV.checkFun(t, e, 2), e += l >= 15 && l <= 20 ? 82 : 80))
}, syxwV.stopFunTry = function (i) {
    var n, t, a, e = 87, s = !0, o = "numRed";
    a = i;
    for (var u = 0; u < a.length; u++) 0 == u ? (o += a[u], $(".paUl .pipkai").eq(0).find(".sonUl").find("li"), syxwV.checkFun_Red(o)) : ((n = a[u]) < 10 && (n = "0" + n), t = "num" + n, u < 11 ? (syxwV.checkFun(t, e, 1), e += u >= 5 && u <= 10 ? 82 : 80) : (s && (e = 87, s = !1), syxwV.checkFun(t, e, 2), e += u >= 15 && u <= 20 ? 82 : 80))
}, syxwV.checkFun_Red = function (i) {
    var n = $("." + i);
    syxwV.redAnimate(n)
}, syxwV.redAnimate = function (i) {
    $(i[1]).addClass("checkBall").animate({top: "120px", left: "7px"}, 500).animate({top: "0px"}, 500)
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
    var i, n = [1, 2, 3, 4, 5, 10][createNum(0, 5)];
    return (i = syxwV.createArr()).unshift(n), i
};