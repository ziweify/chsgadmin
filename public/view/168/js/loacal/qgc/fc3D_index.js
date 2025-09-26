function excutenum() {
    return Math.floor(10 * Math.random())
}

function excutenum1_6() {
    return Math.floor(6 * Math.random())
}

function sendj(e) {
    var s = setTimeout("sendj()", 100), t = "";
    lilength == e.length - 1 && (t = "li_after", clearTimeout(s), lilength = 0), $("#jnumber").append("<li class='nub" + e[lilength] + " " + t + "'></li>"), lilength++
}

function excutek() {
    for (var e = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], s = 0, t = e.length; s < t; s++) {
        var i = Math.floor(Math.random() * e.length);
        res[s] = e[i], e.splice(i, 1)
    }
    for (var l = 0, t = jnumber.length; l < t; l++) jnumber[l].className = "nub" + res[l], l == t - 1 && (jnumber[l].style.marginRight = "0");
    time++;
    var a = setTimeout("excutek()", 200);
    if (time >= 25) {
        clearTimeout(a), $("#jnumber").html("")
    }
}

function loadotherData() {
    listData()
}

function listData() {
    $.ajax({
        url: urlbublic + "QuanGuoCai/getLotteryInfoList.do",
        type: "GET",
        data: {lotCode: lotCode},
        success: function (e) {
            createHtmlList(e), animateMethod.loadingList("#jrsmhmtj", !1)
        },
        error: function (e) {
            setTimeout(function () {
                loadotherData()
            }, config.listTime)
        }
    })
}

function parseTonum(e) {
    return 1 * e.charAt(0) <= 0 ? e.charAt(1) : e
}

function createHtmlList(e) {
    var s = null;
    "object" != (void 0 === e ? "undefined" : _typeof(e)) ? s = JSON.parse(e) : (s = JSON.stringify(e), s = JSON.parse(s)), s = s.result.data;
    if ($("#jrsmhmtj>table").empty(), "10041" == lotCode) var t = "<th style='display:none;'>试机号</th>";
    $("#jrsmhmtj>table").html('<tr><th width="150">时间</th><th width="130">期数</th><th id="numberbtn" width="300" style="padding-left:10px" class="numberbtn">号码</th>' + t + '<th colspan="3">佰拾和</th><th colspan="3">佰个和</th><th colspan="3">拾个和</th><th colspan="3">总和</th></tr>'), $(s).each(function (e) {
        var s = "<td>" + this.preDrawTime + "</td><td>" + this.preDrawIssue + "</td>", t = "";
        if ("" != this.preDrawCode || void 0 != this.preDrawCode) {
            var i = this.preDrawCode.split(",");
            i.length;
            $(i).each(function (e) {
                t += "<li class='numblue numredkong' style='color:#012537'><i>" + this + "</i></li>"
            })
        } else t += "";
        if (i.length <= 1) l = "<td class='blueqiu'></td>"; else var l = "<td class='blueqiu'><ul style='width:144px;max-width:144px'>" + t + "</ul></td>";
        "10041" == lotCode && (l += "<td style='display:none;'>" + this.sjh + "</td>");
        var a = "<td style='color:#a91818'>" + this.sumHundredTen + "</td><td>" + (0 == this.htSingleDouble ? "单" : "双") + "</td><td>" + (0 == this.httailBigSmall ? "尾大" : "尾小") + "</td>";
        a += "<td style='color:#a91818'>" + this.sumHundredOne + "</td><td>" + (0 == this.hoSingleDouble ? "单" : "双") + "</td><td>" + (0 == this.hotailBigSmall ? "尾大" : "尾小") + "</td>", a += "<td style='color:#a91818'>" + this.sumTenOne + "</td><td>" + (0 == this.toSingleDouble ? "单" : "双") + "</td><td>" + (0 == this.totailBigSmall ? "尾大" : "尾小") + "</td>";
        var d = "<tr>" + s + l + (a += "<td style='color:#a91818'>" + this.sumNum + "</td><td>" + (0 == this.sumSingleDouble ? "单" : "双") + "</td><td>" + (0 == this.sumBigSmall ? "大" : "小") + "</td>") + "</tr>";
        $("#jrsmhmtj>table").append(d)
    }), $("table").find("td").each(function () {
        var e = $(this).text();
        "undefined" == e && $(this).text(""), "双" != e && "大" != e && "尾大" != e || $(this).css({color: "#f12d35"})
    })
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
    return typeof e
} : function (e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
};
$(function () {
    function e(e) {
        if (a.length) {
            for (var t = !1, i = 0; i < a.length; i++) e == a[i] && (a.splice(i, 1), t = !0);
            t || a.push(e)
        } else a.push(e);
        s(!1)
    }

    function s(e) {
        $("#jrsmhmtj").find(".blueqiu li").addClass("selectedOpacity");
        for (var s = 0, t = a.length; s < t; s++) $("#jrsmhmtj .blueqiu li").each(function () {
            $(this).text() == a[s] && $(this).removeClass("selectedOpacity")
        })
    }

    function t(e) {
        if (d.length <= 0) d.push(e); else {
            for (var s = 0, t = d.length; s < t; s++) if (d[s] == e) return;
            d.push(e)
        }
    }

    function i(e, s) {
        $("#jrsmhmtj").find(".blueqiu li");
        var t = $("#dannum").hasClass("selected"), i = $("#shuangnum").hasClass("selected"),
            l = $("#danum").hasClass("selected"), d = $("#xiaonum").hasClass("selected");
        $("#jrsmhmtj .blueqiu li").each(function () {
            var a = $(this).text(), c = a % 2 == 0, o = a >= 5;
            "1" == e ? s ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && !c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? o || c ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : c ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : "2" == e ? s ? l ? o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d && o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : l ? o && c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : d ? !o && c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "3" == e ? s ? t ? c ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : t ? o && !c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : i ? o && c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : "4" == e && (s ? t ? c ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : t ? o || c ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity") : i ? !o && c ? $(this).removeClass("selectedOpacity") : $(this).addClass("selectedOpacity") : o ? $(this).addClass("selectedOpacity") : $(this).removeClass("selectedOpacity"))
        }), $("#jrsmhmtj .blueqiu li").each(function (e) {
            $(this).text() == a[e] && $(this).removeClass("selectedOpacity")
        })
    }

    function l(e) {
        $("#jrsmhmtj").find(".blueqiu li"), $("#jrsmhmtj>table>tbody").children();
        if ($("#daxiaodsfb").find("li").removeClass("selected"), e) return $("#duizinum").removeClass("selected"), void $("#jrsmhmtj .blueqiu li").removeClass("selectedOpacity");
        $("#duizinum").addClass("selected"), $("#jrsmhmtj .blueqiu li").addClass("selectedOpacity");
        var s = [], t = $("#jrsmhmtj tr"), i = t.length;
        if (!(i <= 1)) {
            for (var l = $(t[0]).find("li"), a = 0; a < 10; a++) s.push($(l[a]).text());
            for (a = 1; a < i; a++) for (var d = $(t[a]).find("li"), c = 0; c < 10; c++) {
                var o = $(d[c]).text();
                o == s[c] && ($(d[c]).removeClass("selectedOpacity"), $($(t[a - 1]).find("li")[c]).removeClass("selectedOpacity")), s[c] = o
            }
        }
    }

    animateMethod.loadingList("#jrsmhmtj", !0), $("#morelist").mouseover(function () {
        $(".sub_morelist").show(), $(".more").css("border-color", "#fa8e19").css("border-bottom-color", "#ffffff").css("color", "#fa8e19"), $(".graypre").css("display", "none"), $(".yellowpre").css("display", "inline-block")
    }).mouseout(function () {
        $(".sub_morelist").hide(), $(".more").css("border-color", "#ffffff").css("color", "#333333"), $(".graypre").css("display", "inline-block"), $(".yellowpre").css("display", "none")
    }), $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#kaijiangjl").delegate("li", "click", function () {
        var e = $(this).attr("id");
        if ($(this).hasClass("selected")) $(this).removeClass("selected"), "jrsmtj" == e ? $("." + e).hide("200") : "cltx" == e ? $("." + e).hide("200") : "hmfb" == e && ($("." + e).hide("100"), $("." + e).animate({opacity: "0"}, 200)); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).addClass("selected"), "jrsmtj" == e ? $("." + e).show("200") : "cltx" == e ? $("." + e).show("200") : "hmfb" == e && ($("." + e).show("100"), $("." + e).animate({opacity: "1"}, 200))
        }
    });
    var a = [];
    $("#chakanchfb").delegate("li", "click", function () {
        if ($("#daxiaodsfb").find("li").removeClass("selected"), $(this).hasClass("selected")) $(this).removeClass("selected"), e($(this).attr("class")), a.length + 1 == 1 && (a = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")); else {
            if ($(this).hasClass("kaijiltit")) return;
            $(this).hasClass("reset") ? (a = [], $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : (e($(this).attr("class")), $(this).addClass("selected"))
        }
    });
    var d = [];
    $("#daxiaodsfb").delegate("li", "click", function () {
        $("#chakanchfb").find("li").removeClass("selected"), a = [];
        var e = $(this).attr("id"), s = $(this).hasClass("selected");
        "dannum" == e ? s ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#shuangnum").removeClass("selected")) : "shuangnum" == e ? s ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#dannum").removeClass("selected")) : "danum" == e ? s ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#xiaonum").removeClass("selected")) : "xiaonum" == e && (s ? $(this).removeClass("selected") : ($(this).addClass("selected"), $("#danum").removeClass("selected"))), $(this).hasClass("kaijiltit") || ($(this).hasClass("reset") ? ($(this).siblings().removeClass("selected"), $("#jrsmhmtj").find(".blueqiu li").removeClass("selectedOpacity")) : "danum" == e ? ($("#duizinum").removeClass("selected"), t(2), i(3, s)) : "xiaonum" == e ? ($("#duizinum").removeClass("selected"), t(2), i(4, s)) : "dannum" == e ? ($("#duizinum").removeClass("selected"), t(1), i(1, s)) : "shuangnum" == e ? ($("#duizinum").removeClass("selected"), t(1), i(2, s)) : "duizinum" == e && l(s))
    }), $(".numberbtn span").live("click", function () {
        $(this).attr("id");
        $(this).siblings().removeClass("spanselect"), $(this).hasClass("spanselect") ? $(this).removeClass() : $(this).addClass("spanselect"), toolBoxs.qgcTools.bigOrSmall($(this).attr("id"), 5)
    }), $("#waringbox").delegate("i", "click", function () {
        $(this).parent().parent().hide("200")
    })
});
var jnumber = $("#jnumber>li"), res = [], lilength = 0, time = 0;
$(".bothover").hover(function () {
    $(this).find(".toright").css("background-color", "#FFFFFF"), $(".botline").css("border", "none"), $(this).find(".childmenu").show()
}, function () {
    $(this).find(".toright").css("background-color", ""), $(".botline").css("border", ""), $(this).find(".childmenu").hide()
});