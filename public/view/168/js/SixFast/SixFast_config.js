function currentDay(n) {
    var t = n.split("-");
    return parseInt(t[1]) + "/" + (n = parseInt(t[2]))
}

function getDate() {
    var n = new Date;
    return n.getFullYear() + "-" + (n.getMonth() + 1) + "-" + n.getDate() + " " + n.getHours() + ":" + n.getMinutes() + ":" + n.getSeconds()
}

function ifNumIsNull(n, t) {
    return "" == n ? (0 != $(t).find(".errorbox").length && $(t).find(".errorbox").remove(), $(t).find(".rowbox2").append("<span class='errorbox' style='font-size:11px;color:orangered;'>开奖号码未开出，请尝试刷新页面或稍后再试！</span>"), $(t).find(".kajianhao").hide(), !0) : ($(t).find(".errorbox").hide(), $(t).find(".kajianhao").show(), !1)
}

var config = {publicUrl: config.publicUrl, listTime: 2e3, firstLoad: !1, ifdebug: !1, ifScalse: .782},
    lotCode = {gdklsf: 10005}, ifopenSoundsBtn = !1;
$(function () {
    $("#littleimg").length >= 1 && "index" != $("#ifindex").val() && (tools.bannerImg(), $("#littleimg").find(".swiper-container").addClass("swiperother")), $("#sixfastbox").on("click", "#ifSoundOpen .ifSoundOpen", function (n) {
        ifopenSoundsBtn ? ($("#ifSoundOpen").find(".ifSoundIcon").removeClass("stopsound"), $("#ifSoundOpen").find("i").text("关闭声音"), ifopenSoundsBtn = !1, $(".soundbtn").css("background", "#ff7b00"), $("#soundSet").find(".soundbtn").removeClass("disabled"), $("#soundKindsIcon").removeClass().addClass("soundDefY")) : ($("#ifSoundOpen").find(".ifSoundIcon").addClass("stopsound"), $("#ifSoundOpen").find("i").text("打开声音"), ifopenSoundsBtn = !0, $("#soundSet").find(".soundbtn").addClass("disabled"), $(".soundbtn").css("background", "#ccc"), $("#soundSet").find(".soundpanel").hide("200"), $("#soundKindsIcon").removeClass().addClass("soundDef")), n.stopPropagation()
    }), $("#sixfastbox").on("click", "#soundSet .soundbtn:not('.disabled')", function (n) {
        $(this).find(".soundpanel").show("200"), n.stopPropagation()
    }), $(".bodybox").on("click", function (n) {
        $(this).parent().parent().find(".soundpanel").hide("200")
    }), $("#sixfastbox").on("click", "#soundSet .close", function (n) {
        $(this).parent().parent().find(".soundpanel").hide("200");
        var t = $("#soundSet").find("input:[checked='checked']").val();
        "RING_01" == t ? $("#soundKindsIcon").removeClass().addClass("soundDefY") : "RING_02" == t ? $("#soundKindsIcon").removeClass().addClass("sound2Y") : "RING_03" == t ? $("#soundKindsIcon").removeClass().addClass("sound3Y") : "RING_04" == t ? $("#soundKindsIcon").removeClass().addClass("sound4Y") : "RING_05" == t && $("#soundKindsIcon").removeClass().addClass("sound5Y"), n.stopPropagation()
    }), $("#sixfastbox").on("click", "#soundSet input", function () {
        void 0 != $(this).val() && ("RING_01" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("soundDefY") : "RING_02" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound2Y") : "RING_03" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound3Y") : "RING_04" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound4Y") : "RING_05" == $(this).val() && $("#soundKindsIcon").removeClass().addClass("sound5Y"), $("#soundSet").find("audio").attr("src", "../media/" + $(this).val() + ".wav"))
    }), setTimeout(function () {
        try {
            tools.addSund()
        } catch (n) {
        }
    }, 1e3)
});
var publicUrl = config.publicUrl, publicmethod = {}, tools = {};
tools.addSund = function () {
    $("#ifSoundOpen,#soundSet").empty(), $("#ifSoundOpen").append('<div class="ifSoundOpen"><i>关闭声音</i><div class="ifSoundIcon"></div></div>'), $("#soundSet").append('<div class="soundbtn"><i>铃声设置</i><div class="soundicon soundDefY" id="soundKindsIcon">\t<audio src="../media/RING_01.wav"  controls="controls" id="audioid">\t\tYour browser does not support the audio tag.\t</audio></div><div class="soundpanel">\t<div class="close"></div>\t<div class="soundlist">\t\t<ul>\t\t\t<li><label><input type="radio" name="sound" value="RING_01"  checked="checked">&nbsp;默认(闹钟铃)</label></li>\t\t\t<li><label><input type="radio" name="sound" value="RING_02">&nbsp;声音二(上课铃)</label></li>\t\t\t<li><label><input type="radio" name="sound" value="RING_03">&nbsp;声音三(打锣声)</label></li>\t\t\t<li><label><input type="radio" name="sound" value="RING_04">&nbsp;声音四(打鼓声)</label></li>\t\t\t<li><label><input type="radio" name="sound" value="RING_05">&nbsp;声音五(点滴声)</label></li>\t\t\t<li>\t\t\t\t提示时间：\t\t\t\t<select>\t\t\t\t\t<option value="5"  selected="selected">开奖前5秒</option>\t\t\t\t\t<option value="20">开奖前20秒</option>\t\t\t\t\t<option value="10">开奖前10秒</option>\t\t\t\t\t<option value="30">开奖前30秒</option>\t\t\t\t\t<option value="40">开奖前40秒</option>\t\t\t\t\t<option value="50">开奖前50秒</option>\t\t\t\t\t<option value="60">开奖前60秒</option>\t\t\t\t\t<option value="begin">开奖后</option>\t\t\t\t</select>\t\t\t</li>\t\t</ul>\t</div></div></div>')
}, publicmethod.insertHeadKlsf = function (n, t) {
    var e = tools.parseObj(n);
    if ("100002" == e.result.businessCode) throw new Error("error");
    if (e = e.result.data, tools.operatorTime("" == e.drawTime ? "0" : e.drawTime, e.serverTime) <= 0) throw new Error("error");
    $(t).find(".preDrawIssue").text(e.preDrawIssue), $(t).find(".nextIssue").text(e.drawIssue), $(t).find("#scoreTotal").text(e.sumTotal), $(t).find(".drawCount").text(e.drawCount), $(t).find(".sdrawCount").text(288 - e.drawCount);
    for (var o = e.fiveElements, i = e.chineseZodiac, s = "", a = 0; a < 7; a++) s += 6 == a ? "<li class='lastsh_xzlist'><span>" + proto.Zoo[i[a]] + "</span><span>" + proto.fiveLineArr[o[a]] + "</span> </li>" : "<li><span>" + proto.Zoo[i[a]] + "</span><span>" + proto.fiveLineArr[o[a]] + "</span> </li>";
    $(".new_sh_xzlist").html(s), $("#fastZongfen").text(e.sumTotal);
    var d = e.preDrawCode.split(","), l = [];
    $(d).each(function (n) {
        if (d[n] < 10) {
            var t = "0" + 1 * d[n];
            l.push(t)
        } else l.push(d[n])
    }), l = l.join(","), tools.countDown(e.drawTime, e.serverTime, t), animateMethod.sscAnimateEnd(l, t, e.color), $("#waringbox").hide(300), setTimeout(function () {
        if (tools.ifFirstLoad()) {
            var n = $(".xzsx>li>.checked").parent().attr("lang"), t = formatDate(new Date);
            -1 != window.location.href.indexOf("SixFast_index") && smSixTools.yearsFun(n, t)
        }
        config.firstLoad = !0
    }, 1e4)
}, tools.parseObj = function (n) {
    var t = null;
    return "object" != typeof n ? t = JSON.parse(n) : (t = JSON.stringify(n), t = JSON.parse(t)), t
}, tools.playSound = function (n) {
    if (0 == ifopenSoundsBtn && void 0 != ifopenSoundsBtn) {
        var t = $("#audioid");
        "begin" == n && "begin" == $("#soundSet").find("select").val() ? t[0].play() : $("#soundSet").find("select").val() == n - 1 && t[0].play()
    }
}, tools.repeatAjaxt = {
    qiu: function (n) {
        clearInterval(animateID[n]);
        var t = "";
        $(n).find(".kajianhao li").each(function () {
            t += $(this).text() + ","
        }), animateMethod.sscAnimateEnd(t, n), setTimeout(function () {
            ajaxRequst($(n).find(".nextIssue").text(), $(n).attr("id"))
        }, 1e3)
    }
}, tools.repeatIndexAjax = {
    qiu: function (n) {
        var t = "";
        $(n).find(".kajianhao li").each(function () {
            t += $(this).text() + ","
        }), animateMethod.sscAnimateEnd(t, n), setTimeout(function () {
            ajaxRequst($(n).find(".nextIssue").text(), $(n).attr("id"))
        }, 1e3)
    }, qiuam: function (n) {
        var t = "";
        $(n).find(".kajianhao li").each(function () {
            t += $(this).text() + ","
        }), animateMethod.sscAnimateEnd(t, n)
    }
}, tools.countDown = function (n, t, e) {
    var o = e.replace("#", "."), i = n.replace("-", "/"), t = t.replace("-", "/");
    i = i.replace("-", "/"), t = t.replace("-", "/");
    var s = $(e).find(".hour"), a = $(e).find(".minute"), d = $(e).find(".second"), l = $(e).find(".opentyle"),
        u = $(e).find(".cuttime"), r = $(o).find(".hour"), c = $(o).find(".minute"), f = $(o).find(".second"),
        p = $(o).find(".opentyle"), v = $(o).find(".cuttime"), h = (new Date(i) - new Date(t)) / 1e3, m = !0,
        b = new Date, x = setInterval(function () {
            var n = Math.abs(new Date - b) / 1e3;
            if (b = new Date, (n = n.toString().split("."))[0] > 1 && (h -= n[0]), m ? (m = !1, tools.playSound("begin")) : tools.playSound(h), h > 1) {
                h -= 1;
                var t = Math.floor(h / 3600), i = Math.floor(h / 60 % 60), I = Math.floor(h % 60);
                $(s).text(t < 10 ? "0" + t : t), $(a).text(i < 10 ? "0" + i : i), $(d).text(I < 10 ? "0" + I : I), $(r).text(t < 10 ? "0" + t : t), $(c).text(i < 10 ? "0" + i : i), $(f).text(I < 10 ? "0" + I : I), t <= 0 ? ($(e).find(".hourtxt").hide(), $(s).hide(), $(o).find(".hourtxt").hide(), $(r).hide()) : ($(e).find(".hourtxt").css("display", "inline-block"), $(s).css("display", "inline-block"), $(o).find(".hourtxt").css("display", "inline-block"), $(r).css("display", "inline-block")), $(l).hide(), $(u).css({display: "inline-block"}), $(p).hide(), $(v).css({display: "inline-block"})
            } else $(l).show(), $(u).hide(), $(p).show(), $(v).hide(), clearInterval(x), setTimeout(function () {
                ajaxRequst($(e).find(".nextIssue").text(), e)
            }, 1e3)
        }, 1e3)
}, tools.ifFirstLoad = function () {
    return !!config.firstLoad
}, tools.operatorTime = function (n, t) {
    var e = n.replace("-", "/"), t = t.replace("-", "/");
    return e = e.replace("-", "/"), t = t.replace("-", "/"), (new Date(e).getTime() - new Date(t).getTime()) / 1e3
};