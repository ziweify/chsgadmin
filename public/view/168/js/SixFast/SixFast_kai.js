function insscanimate() {
    0 != $("#sixfastbox").find("#klsf").length || 0 != $("#klsf").length ? ajaxRequst("", boxid) : setTimeout(function () {
        insscanimate()
    }, 10)
}

function ajaxRequst(e, t) {
    indexObj.ajaxSsc(e, t)
}

function formatDate(e) {
    var t = e.getFullYear(), n = e.getMonth() + 1;
    n = n < 10 ? "0" + n : n;
    var a = e.getDate();
    return a = a < 10 ? "0" + a : a, t + "-" + n + "-" + a
}

function getDateStr(e) {
    var t = new Date;
    return t.setDate(t.getDate() + e), t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate()
}

function creatDataHead(e, t) {
    publicmethod.insertHeadKlsf(e, t)
}

var boxid = "#klsf";
$(function () {
    insscanimate()
});
var urlbublic = config.publicUrl, lotCode = lotCode.gdklsf, indexObj = new Object;
indexObj.ajaxSsc = function (e, t) {
    e = void 0 == e ? "" : e;
    var n = !1;
    $.ajax({
        url: urlbublic + "speedSix/findSpeedSixInfo.do?", type: "GET", beforeSend: function () {
            void 0 == animateID[t] && animateMethod.sscAnimate(t)
        }, success: function (n) {
            try {
                creatDataHead(n, t), clearInterval(animateID[t]), delete animateID[t]
            } catch (n) {
                setTimeout(function () {
                    ajaxRequst(e, t)
                }, "1000"), config.ifdebug
            }
        }, error: function (a) {
            setTimeout(function () {
                ajaxRequst(e, t)
            }, "1000"), n = !0, config.ifdebug
        }, complete: function (a, i) {
            (n = !1) || "timeout" == i && setTimeout(function () {
                ajaxRequst(e, t)
            }, "1000")
        }
    })
};