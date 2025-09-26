function mDown(t) {
    $("#tryBtn").css("transform", "scale(0.8)")
}

function mUp(t) {
    $("#tryBtn").css("transform", "scale(1)")
}

function add(t) {
    $("#kaiUl").find("li").css("margin-top", t + "px")
}

function sub(t) {
    $("#kaiUl").find("li").css("margin-top", -t + "px")
}

function headCode(t) {
    $(".numShow").empty();
    var n = t, e = "";
    $(n).each(function () {
        console.log(this), e += "<li>" + ("" == this ? 0 : this) + "</li>"
    }), $(".numShow").append(e)
}

function kaiCode(t) {
    $("#kaiUl").find("li").empty();
    var n = t, e = "";
    $("#kaiUl").find("li").each(function (t) {
        e = "<span class='num" + ("" == n[t] ? 0 : n[t]) + "'></span>", $(this).append(e)
    })
}

function defCode(t) {
    $("#kaiUl").find("li").empty();
    var n = t, e = "";
    $("#kaiUl").find("li").each(function (t) {
        e = "<span class='rotOnce num" + n[t] + "'></span>", $(this).append(e)
    })
}

function tryStopAnimate(t) {
    bgMusic(), pcEgg.bressBG(), kaiCode(t), setTimeout(function () {
        defCode(pcEgg.getKaiCode()), setTimeout(function () {
            pcEgg.floatFun(), isTry = !1
        }, 3e3)
    }, 3e3)
}

function stopAnimate(t) {
    clearInterval(animateId.chgRoateNum), bgMusic(), pcEgg.bressBG(), defCode(t), setTimeout(function () {
        pcEgg.floatFun(), isTry = !1
    }, 3e3)
}

function bgMusic() {
    audioType = "b", pcEgg.sound.play("audioidBg"), pcEgg.sound.stop("audioidKai")
}

function kaiMusic() {
    audioType = "r", pcEgg.sound.play("audioidKai"), pcEgg.sound.stop("audioidBg")
}

function createNum(t, n) {
    var e = n - t, i = Math.random();
    return t + Math.round(i * e)
}

var pcEgg = {}, isTry = !1, ifopen = !1, audioType = "b", animateId = {}, timer = null;
$(function () {
    $(".loading").fadeOut(1e3, function () {
    }), $("#soundBth").on("click", function () {
        "soundsOn" == $("#soundBth").attr("class") ? ($("#soundBth").removeClass("soundsOn").addClass("soundsOff"), pcEgg.sound.stop("audioidKai"), pcEgg.sound.stop("audioidBg")) : ($("#soundBth").removeClass("soundsOff").addClass("soundsOn"), "b" == audioType ? (pcEgg.sound.play("audioidBg"), pcEgg.sound.stop("audioidKai")) : (pcEgg.sound.play("audioidKai"), pcEgg.sound.stop("audioidBg")))
    }), $("#tryBtn").on("click", function () {
        if (isTry) return $(".jzCheck").show(), setTimeout(function () {
            $(".jzCheck").hide()
        }, 1e3), !1;
        isTry = !0, pcEgg.tryKaiFun()
    })
}), pcEgg.startVid = function (t, n) {
    $("#pc28ImgLogo").attr("src", "img/" + lotCode + ".png"), pcEgg.bressBG(), $("#hourtxt").show(), $("#opening").hide(), bgMusic(), pcEgg.Data(t, n), pcEgg.floatFun()
}, pcEgg.stopVid = function (t, n) {
    $("#hourtxt").show(), $("#opening").hide(), pcEgg.Data(t, n), stopAnimate(t.numArr), isTry = !1
}, pcEgg.Data = function (t, n) {
    $("#nextIssue").text(t.nextIssue), $("#drawTime").text(t.drawTime.split(" ")[1]), headCode(t.numArr), kaiCode(t.numArr), pcEgg.cutTime(pcEgg.getSecond(t.drawTime) - pcEgg.getSecond(t.serverTime), n)
}, pcEgg.floatFun = function () {
    var t = 0;
    animateId.floatInt = setInterval(function () {
        sub(), (t += 1) >= 0 && t <= 20 ? (add(t), 20 == t && (t = -20)) : sub(t)
    }, 50)
}, pcEgg.clearFloatint = function () {
    clearInterval(animateId.floatInt)
}, pcEgg.startRoate = function () {
    kaiMusic(), pcEgg.bressBG(20);
    var t = null;
    animateId.chgRoateNum = setInterval(function () {
        kaiCode(t = pcEgg.createArr()), $("#kaiUl").find("li").find("span").addClass("Rotation")
    }, 300)
}, pcEgg.stopRoate = function () {
    clearInterval(animateId.chgRoateNum), $("#kaiUl").find("li").find("span").removeClass("Rotation")
}, pcEgg.tryKaiFun = function () {
    void 0 != animateId.floatInt && clearInterval(animateId.floatInt), setTimeout(function () {
        pcEgg.startRoate(), setTimeout(function () {
            var t = pcEgg.createArr();
            pcEgg.stopRoate(), tryStopAnimate(t)
        }, 4e3)
    }, 1e3)
}, pcEgg.getKaiCode = function () {
    var t = [];
    return $("#kaiNum").find("li").each(function () {
        t.push($(this).text())
    }), t
}, pcEgg.getSecond = function (t) {
    var n = t.split(" ")[1].split(":"), e = n[0], i = n[1], a = n[2],
        o = 3600 * (e = e < 10 ? e.substring(e.length - 1, e.length) : e) + 60 * (i = i < 10 ? i.substring(i.length - 1, i.length) : i) + 1 * (a = a < 10 ? a.substring(a.length - 1, a.length) : a);
    return console.log(o), o
}, pcEgg.cutTime = function (t, n) {
    null != timer && clearInterval(timer);
    var t = t;
    console.log(t), timer = setInterval(function () {
        var issue = $("#nextIssue").text();
        if (t >= 1) {
            t -= 1;
            var e = Math.floor(t / 3600), i = Math.floor(t / 60 % 60), a = Math.floor(t % 60), o = "";
            if (o = (e < 10 ? "0" + e : e) + " : ", o = o + "" + (i < 10 ? "0" + i : i) + " : " + (a < 10 ? "0" + a : a), $("#hourtxt").text(o), t < 10) {
                var s = $(".linelist").find("li");
                $(s).eq(t).addClass("redli")
            }
        } else clearInterval(timer), $("#hourtxt").hide(), $("#opening").css("display", "block"), clearInterval(animateId.floatInt), pcEgg.startRoate(), setTimeout(pubmethod.doAjax(issue, n.lotCode, n.type, !1), "500")
    }, 1e3)
}, pcEgg.clearTime = function () {
    clearInterval(timer)
}, pcEgg.sound = {
    play: function (t) {
        "soundsOn" == $("#soundBth").attr("class") && document.getElementById(t).play()
    }, stop: function (t) {
        document.getElementById(t).pause()
    }
}, pcEgg.createArr = function () {
    for (var t = [], n = 0; n < 3; n++) {
        var e = createNum(0, 9);
        if (0 != n) for (var i = 0, a = t.length - 1; i < t.length; i++) {
            if (e == t[i]) {
                n--;
                break
            }
            if (i == a) {
                t.push(e);
                break
            }
        } else t.push(e)
    }
    return t
}, pcEgg.bressBG = function (t) {
    var n = 1, e = !1;
    void 0 != animateId.bressBG && clearInterval(animateId.bressBG), void 0 == t && (t = 80);
    var i = setInterval(function () {
        $("#light").find("li").stop().animate({opacity: "0." + n}, t), e ? (n -= 1) < 1 && (e = !1) : (n += 1) > 8 && (e = !0)
    }, t);
    animateId.bressBG = i
}, pcEgg.pcFillData = function (t, n, e) {
    $("#nextIssue").text(t), $("#drawTime").text(n), headCode(e)
};