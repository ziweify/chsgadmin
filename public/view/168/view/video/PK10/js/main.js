function activateflame(e, a) {
    parseInt($("#car" + a).css("left")) > e ? ($(".car" + a + " .wind").css("display", "block"), $(".car" + a + " .flame").css("display", "block")) : ($(".car" + a + " .wind").css("display", "none"), $(".car" + a + " .flame").css("display", "none"))
}
function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
function animate() {
    var e = Math.floor(40 * Math.random() + 30);
    e /= 10;
    var a = Math.floor(40 * Math.random() + 30);
    a /= 10;
    var t = Math.floor(40 * Math.random() + 30);
    t /= 10;
    var n = Math.floor(40 * Math.random() + 30);
    n /= 10;
    var o = Math.floor(40 * Math.random() + 30);
    o /= 10;
    var r = Math.floor(40 * Math.random() + 30);
    r /= 10;
    var s = Math.floor(40 * Math.random() + 30);
    s /= 10;
    var l = Math.floor(40 * Math.random() + 30);
    l /= 10;
    var i = Math.floor(40 * Math.random() + 30);
    i /= 10;
    var c = Math.floor(40 * Math.random() + 30);
    c /= 10;
    var d = Math.floor(10 * Math.random() + 1);
    d /= 10;
    var f = Math.floor(10 * Math.random() + 1);
    f /= 10;
    var m = Math.floor(10 * Math.random() + 1);
    m /= 10;
    var u = Math.floor(10 * Math.random() + 1);
    u /= 10;
    var p = Math.floor(10 * Math.random() + 1);
    p /= 10;
    var v = Math.floor(10 * Math.random() + 1);
    v /= 10;
    var h = Math.floor(10 * Math.random() + 1);
    h /= 10;
    var y = Math.floor(10 * Math.random() + 1);
    y /= 10;
    var w = Math.floor(10 * Math.random() + 1);
    w /= 10;
    var $ = Math.floor(10 * Math.random() + 1);
    $ /= 10;
    var M = Math.floor(1100 * Math.random() + 200);
    activateflame(M, "1"), M += "px";
    var g = Math.floor(1100 * Math.random() + 200);
    activateflame(g, "2"), g += "px";
    var x = Math.floor(1100 * Math.random() + 200);
    activateflame(x, "3"), x += "px";
    var I = Math.floor(1100 * Math.random() + 200);
    activateflame(I, "4"), I += "px";
    var T = Math.floor(1100 * Math.random() + 200);
    activateflame(T, "5"), T += "px";
    var B = Math.floor(1100 * Math.random() + 200);
    activateflame(B, "6"), B += "px";
    var E = Math.floor(1100 * Math.random() + 200);
    activateflame(E, "7"), E += "px";
    var k = Math.floor(1100 * Math.random() + 200);
    activateflame(k, "8"), k += "px";
    var b = Math.floor(1100 * Math.random() + 200);
    activateflame(b, "9"), b += "px";
    var A = Math.floor(1100 * Math.random() + 200);
    activateflame(A, "10"), A += "px";
    var L = document.getElementById("car1"), C = document.getElementById("car2"), N = document.getElementById("car3"),
        S = document.getElementById("car4"), q = document.getElementById("car5"), _ = document.getElementById("car6"),
        D = document.getElementById("car7"), F = document.getElementById("car8"), O = document.getElementById("car9"),
        R = document.getElementById("car10");
    TweenMax.to(L, e, {left: M, delay: d}), TweenMax.to(C, a, {left: g, delay: f}), TweenMax.to(N, t, {
        left: x,
        delay: m
    }), TweenMax.to(S, n, {left: I, delay: u}), TweenMax.to(q, o, {left: T, delay: p}), TweenMax.to(_, r, {
        left: B,
        delay: v
    }), TweenMax.to(D, s, {left: E, delay: h}), TweenMax.to(F, l, {left: k, delay: y}), TweenMax.to(O, i, {
        left: b,
        delay: w
    }), TweenMax.to(R, c, {left: A, delay: $})
}

function sortFloat(e, a) {
    return e - a
}

function checkposition() {
    carposition = new Array, carsequence = new Array, my_array = new Array;
    for (n = 0; n < 10; n++) {
        var e = n + 1, a = parseInt($("#car" + e).css("left"));
        a = (a += carpositionoffset[n]) + "." + n, carposition[n] = parseFloat(a)
    }
    carposition.sort(sortFloat);
    for (n = 0; n < 10; n++) {
        var t = carposition[n];
        t = String(t), my_array = t.split("."), void 0 == my_array[1] ? carsequence[n] = "0" : carsequence[n] = my_array[1]
    }
    for (var n = 0; n < 10; n++) {
        var o = "#pos" + (n + 1), r = -64 * carsequence[n];
        $(o).css("background-position", "0px " + r + "px")
    }
}

function wheelon() {
    for (var e = 1; e < 11; e++) $(".wheel" + e + "a").css("display", "block"), $(".wheel" + e + "b").css("display", "block")
}

function wheeloff() {
    for (var e = 1; e < 11; e++) $(".wheel" + e + "a").css("display", "none"), $(".wheel" + e + "b").css("display", "none")
}

function startcountdown(e, a) {
    if (TweenLite.killDelayedCallsTo(winnerpage), $(".page1").css("display", "block"), $(".page2").css("display", "none"), 1 == waitfinish) return !1;
    stopanimation(), $("#car1").css("left", "1206px"), $("#car2").css("left", "1197px"), $("#car3").css("left", "1181px"), $("#car4").css("left", "1166px"), $("#car5").css("left", "1153px"), $("#car6").css("left", "1139px"), $("#car7").css("left", "1128px"), $("#car8").css("left", "1105px"), $("#car9").css("left", "1084px"), $("#car10").css("left", "1067px"), $(".roadstart").css("left", "960px"), $(".trafficlight").css("display", "block"), $(".redlight").css("display", "none"), $(".yellowlight").css("display", "none"), $(".greenlight").css("display", "none"), $(".countdownnum").html(""), $(".countdownnum2").html(""), $(".countdownnum").css("display", "block"), $(".countdownnum2").css("display", "block"), countdowninv = setInterval(function () {
        var isss = parseInt($("#drawIssue").val());
        countdowntimer(e -= 1), countdown(e), 0 == e && (clearInterval(countdowninv), clearInterval(countdowninv2), setTimeout(pubmethod.doAjax(isss, a.lotCode, a.type, !1), "2000"))
    }, 1e3);
    var t = 99;
    countdowninv2 = setInterval(function () {
        minisectimer(t), 0 == t && (t = 99), t -= 1
    }, 10), countdowntimer(e), countdown(e)
}

function minisectimer(e) {
    var a = convertTime(e);
    $(".countdownnum2").html(a)
}

function convertTime(e) {
    var a = String(e);
    return 1 == a.length ? a = "0" + a : a
}

function countdown(e) {
    var a = e / 60;
    if (0 == (a = Math.floor(a))) var t = "00"; else t = convertTime(t = String(a));
    var n = convertTime(e - 60 * a);
    e < 0 ? $(".countdownnum").html("00:00") : $(".countdownnum").html(t + ":" + n)
}

function countdowntimer(e) {
    e >= 0 ? $(".trafficlight").css("display", "block") : $(".trafficlight").css("display", "none"), e <= 2 && $(".redlight").css("display", "block"), 2 == e && videoTools.ifsund() && ($("#sound").attr("src", "sound/cuttime.mp3"), $("#sound").removeAttr("loop"), document.getElementById("sound").play()), e <= 1 && $(".yellowlight").css("display", "block"), 0 == e && (startanimation(), $(".countdownnum").html("00:00"), $(".countdownnum2").html("00"), $(".greenlight").css("display", "block"), $(".trafficlight").delay(500).fadeOut(300))
}

function startanimation() {
    setTimeout(function () {
        videoTools.ifsund() && ($("#sound").attr("src", "sound/staring.mp3"), $("#sound").attr("loop", "loop"), document.getElementById("sound").play())
    }, 1e3), wheelon();
    var e = document.getElementById("roadstart");
    TweenMax.to(e, 1, {left: "1334px", ease: Power1.easeIn});
    var a = document.getElementById("roaditm");
    TweenMax.to(a, .4, {left: "-120px", repeat: -1, ease: Linear.easeNone});
    var t = document.getElementById("scenaryitm");
    TweenMax.to(t, 20, {
        left: "0",
        repeat: -1,
        ease: Linear.easeNone
    }), $("wheel1a").css("display", "block"), animation1 = setInterval(function () {
        animate()
    }, 3e3), animation2 = setInterval(function () {
        checkposition()
    }, 300), animate(), wheelon()
}

function windflameani() {
    $(".wind").animate({opacity: .7}, 150, function () {
        $(".wind").css("opacity", "1")
    }), $(".flame").animate({opacity: .7}, 150, function () {
        $(".flame").css("opacity", "1")
    })
}

function stopanimation() {
    $("#roaditm").css("left", "-1300px"), $("#scenaryitm").css("left", "-1334px"), $(".wind").css("display", "none"), $(".flame").css("display", "none"), TweenMax.killAll(), wheeloff(), clearInterval(animation1), clearInterval(animation2), clearInterval(countdowninv), clearInterval(countdowninv2)
}

function getRandomInt(e, a) {
    return Math.floor(Math.random() * (a - e + 1)) + e
}

function midgame() {
    if (TweenLite.killDelayedCallsTo(winnerpage), $(".page1").css("display", "block"), $(".page2").css("display", "none"), 1 == waitfinish) return !1;
    stopanimation(), $("#roadstart").css("left", "1334px"), $(".trafficlight").css("display", "none");
    for (var e = 1; e < 11; e++) {
        var a = getRandomInt(200, 1e3);
        $("#car" + e).css("left", a + "px")
    }
    startanimation()
}

function finishgame(e) {
    if (setTimeout(function () {
        $("#sound").attr("src", "sound/over.mp3"), document.getElementById("sound").pause(), videoTools.ifsund() && ($("#sound").removeAttr("loop"), document.getElementById("sound").play()), setTimeout(function () {
            $("#sound").removeAttr("src")
        }, 4e3)
    }, 3e3), TweenLite.killDelayedCallsTo(winnerpage), $(".page1").css("display", "block"), $(".page2").css("display", "none"), 1 == waitfinish) return !1;
    waitfinish = !0, TweenMax.killAll(), wheelon(), $("#roaditm").css("left", "-1300px");
    var a = document.getElementById("roaditm");
    TweenMax.to(a, .4, {left: "-120px", repeat: -1, ease: Linear.easeNone});
    var t = document.getElementById("scenaryitm");
    TweenMax.to(t, 20, {left: "0", repeat: -1, ease: Linear.easeNone});
    var n = document.getElementById("roadstart");
    TweenMax.to(n, 1, {left: "1334px", ease: Linear.easeNone, delay: 3});
    var o = setInterval(function () {
        checkposition()
    }, 300);
    $("#roadstart").css("left", "-250px"), $(".trafficlight").css("display", "none"), clearInterval(animation1), clearInterval(countdowninv), clearInterval(countdowninv2);
    for (var r = e.split(","), s = 0; s < 10; s++) {
        var l = Math.floor(10 * Math.random() + 1);
        l /= 10;
        var i = parseInt(r[s]) - 1, c = 100 * s - carpositionoffset[i] + 350, d = c + "px", f = "car" + r[s],
            m = document.getElementById(f);
        activateflame(c, r[s]), TweenMax.to(m, 3, {left: d, delay: l})
    }
    $(".flashlight").delay(3200).fadeIn(100, function () {
        $(".flashlight").fadeOut(500), clearInterval(o), waitfinish = !1, resultpage(e)
    })
}

function resultpage(e) {
    if ($(".page1").css("display", "block"), $(".page2").css("display", "none"), 1 == waitfinish) return !1;
    stopanimation(), $("#roadstart").css("left", "130px"), $(".trafficlight").css("display", "none");
    for (var a = e.split(","), t = 0; t < 10; t++) {
        var n = parseInt(a[t]) - 1, o = 100 * t - carpositionoffset[n] + 350 + "px", r = "car" + a[t];
        $("#" + r).css("left", o)
    }
    showcurrentresult(e), TweenLite.delayedCall(2, winnerpage, [e])
}

function showcurrentresult(e) {
    for (var a = e.split(","), t = 0; t < 10; t++) {
        var n = "#pos" + (t + 1), o = -64 * (a[t] - 1);
        $(n).css("background-position", "0px " + o + "px")
    }
}

function winnerpage(e) {
    $(".resultitm").css("opacity", 0), $(".resultcar1").css("left", "483px"), $(".resultcar1").css("top", "288px"), $(".resultcar2").css("left", "170px"), $(".resultcar2").css("top", "251px"), $(".resultcar3").css("left", "946px"), $(".resultcar3").css("top", "254px");
    var a = e.split(",");
    $(".page1").css("display", "none"), $(".page2").css("display", "block");
    for (var t = 0; t < 3; t++) {
        var n = ".resultcarimg" + (t + 1);
        $(n).attr("src", "images/winner" + a[t] + ".png")
    }
    var o = document.getElementById("resultcar1");
    TweenMax.to(o, 1, {left: "395px", top: "328px", opacity: 1, delay: .2});
    var r = document.getElementById("resultcar2");
    TweenMax.to(r, 1, {left: "81px", top: "287px", opacity: 1, delay: .7});
    var s = document.getElementById("resultcar3");
    TweenMax.to(s, 1, {left: "859px", top: "291px", opacity: 1, delay: 1.2});
    var l = document.getElementById("result1");
    TweenMax.to(l, 1, {opacity: 1, delay: .2});
    var i = document.getElementById("result2");
    TweenMax.to(i, 1, {opacity: 1, delay: .7});
    var c = document.getElementById("result3");
    TweenMax.to(c, 1, {opacity: 1, delay: 1.2})
}

function hideAddressBar() {
    setTimeout(function () {
        window.scrollTo(0, 1)
    }, 0)
}

var animation1, animation2, waitfinish, videoTools = {};
$(function () {
    var query_code = getParameterByName("code"), img_src = "";
    null != query_code && (img_src = "images/logo/logo-" + query_code + ".png", $("#video-logo").attr("src", img_src));
    $(".currentdraw").on("click", "#closeSound", function () {
        $(this).hasClass("closesoundbtn") ? ($(this).removeClass("closesoundbtn"), document.getElementById("sound").play(), ifopen = !0) : ($(this).addClass("closesoundbtn"), ifopen = !1, void 0 != $("#sound").attr("src") && document.getElementById("sound").pause())
    })
});
var carpositionoffset = [0, 9, 25, 40, 53, 67, 78, 101, 122, 139], countdowninv, countdowninv2,
    animation3 = setInterval(function () {
        windflameani()
    }, 150);
window.addEventListener("load", function () {
    hideAddressBar()
}), window.addEventListener("orientationchange", hideAddressBar), videoTools.ifsund = function () {
    var e = null;
    return e = !$("#closeSound").hasClass("closesoundbtn"), console.log("flag：" + e), e
};