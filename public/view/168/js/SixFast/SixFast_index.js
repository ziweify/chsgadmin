function checkPpage(s, e) {
    $(".haomafenbu").hasClass("active") ? smSixTools.yearsFun(e, s) : $(".shxiaolz").hasClass("active") ? smSixTools.getshxiaoList(s) : $(".termalz").hasClass("active") ? smSixTools.gettemaList(s) : $(".zhmaZS").hasClass("active") && smSixTools.getzhmaList(s)
}

function detailCheck() {
    $("#haomafenbu>.number_box>ul>li:contains('双')").css("color", "#F8223C"), $("#haomafenbu>.number_box>ul>li:contains('大')").css("color", "#F8223C"), $("#haomafenbu>.number_box>ul>li:contains('红')").css("color", "#F8223C"), $("#haomafenbu>.number_box>ul>li:contains('蓝')").css("color", "#0093E8"), $("#haomafenbu>.number_box>ul>li:contains('绿')").css("color", "#1FC26B"), $("li.hisNum_detail>ul>li>span:contains('红')").css("color", "#F8223C"), $("li.hisNum_detail>ul>li>span:contains('蓝')").css("color", "#0093E8"), $("li.hisNum_detail>ul>li>span:contains('绿')").css("color", "#1FC26B");
    var s = $(".hisNum_detail>ul>li,.temaNum.Seven"), e = $(".opacity"), a = $(".xztj>div>ul>li.active");
    if (0 == e.length && 0 == a.length) return $(".hisNum_detail>ul>li,.temaNum.Seven").css("opacity", "1"), !1;
    0 == e.length && a.length;
    for (l = 0; l < s.length; l++) 1 == s[l].classList.contains("opacity") ? s[l].style.opacity = "1" : s[l].style.opacity = "0.1";
    var i = $(".xztj>div li.active").find("a").text(), t = $(".opacity");
    0 == i.length && 0 == t.length ? $(".hisNum_detail>ul>li,.Seven").css("opacity", "1") : 0 == i.length && 0 != t.length && $(".opacity").css("opacity", "1"), 0 == t.length && (t = $(".hisNum_detail>ul>li,.Seven"));
    for (var l = 0; l < t.length; l++) for (var o = 0; o < i.length; o++) {
        if (t[l].getAttribute("data-text") == i[o]) {
            t[l].style.opacity = "1";
            break
        }
        t[l].style.opacity = "0.1"
    }
    a = $(".xztj>div>ul>li.active")
}

function getFiveEle() {
    $.ajax({
        type: "get",
        url: config.publicUrl + "smallSix/findFiveElements.do",
        async: !0,
        dataType: "json",
        success: function (s) {
            if ("" == (s = s.result.data)) return !1;
            for (var e = "", a = 0; a < 5; a++) 0 == a ? e += "<p>金: " + s.metalNumber.split(",").join("、") + "</p>" : 1 == a ? e += "<p>木: " + s.woodNumber.split(",").join("、") + "</p>" : 2 == a ? e += "<p>水: " + s.waterNumber.split(",").join("、") + "</p>" : 3 == a ? e += "<p>火: " + s.fireNumber.split(",").join("、") + "</p>" : 4 == a && (e += "<p>土: " + s.earthNumber.split(",").join("、") + "</p>");
            $(".fiveelep").after(e)
        }
    }), $.ajax({
        type: "get",
        url: config.publicUrl + "smallSix/findChineseZodiac.do",
        async: !0,
        dataType: "json",
        success: function (s) {
            if ("" == (s = s.result.data)) return !1;
            var e = $(".zoop>span"), a = $(".zoop2>span"), i = s.animals.split(",");
            $(e).each(function (s) {
                $(this).text(i[s]), $(a[s]).text(i[s])
            })
        }
    })
}

var smSixTools = {};
$(function () {
    function s(s) {
        var e = s.getFullYear(), a = s.getMonth() + 1, i = s.getDate();
        return a = a < 10 ? "0" + a : a, i = i < 10 ? "0" + i : i, e + "-" + a + "-" + i
    }

    var e = window.location.search;
    "" != e && (e = e.split("=")[1], $("." + e).click()), $(".explain").on({
        click: function () {
            $(this).addClass("auHeight")
        }, mouseleave: function () {
            $(this).removeClass("auHeight")
        }
    }), $(".date").val(s(new Date)), $("#datebox").calendar({
        trigger: ".date",
        zIndex: 999,
        format: "yyyy-mm-dd",
        onSelected: function (e, a, i) {
            var a = s(a);
            datE = a, checkPpage(a, $(".xzsx>li>.checked").parent().attr("lang")), datE == s(new Date((new Date).getTime() - 864e5)) ? $(".Yesterday").addClass("active").siblings("button").removeClass("active") : datE == s(new Date((new Date).getTime() - 1728e5)) ? $(".thisPreDay").addClass("active").siblings("button").removeClass("active") : $(".thisDay").addClass("active").siblings("button").removeClass("active")
        },
        onClose: function (s, e, a) {
            $(".date").val(datE)
        }
    }), $(".date_text").on("click", "button", function () {
        var e = $(this), a = e.attr("class"), i = "";
        -1 != a.indexOf("thisDay") ? i = s(new Date) : -1 != a.indexOf("Yesterday") ? i = s(new Date((new Date).getTime() - 864e5)) : -1 != a.indexOf("thisPreDay") && (i = s(new Date((new Date).getTime() - 1728e5))), $(".date").val(i), e.addClass("active").siblings("button").removeClass("active"), checkPpage(i, $(".xzsx>li>.checked").parent().attr("lang"))
    })
}), $(".xzhm>li:not(title)").click(function () {
    var s = $(this).toggleClass("active").find("a").attr("href").replace("#zhma", "");
    $("." + s).toggleClass("opacity"), detailCheck()
}), $(".xzsx").on("click", "li:not(title)", function (s) {
    s.preventDefault(), $(this).find("a").addClass("checked").parent().siblings().find("a").removeClass("checked");
    var e = $(this).find("a").attr("href").replace("#", "");
    $("." + e).css("display", "block").siblings("div").css("display", "none")
}), $(".xztj>div li").click(function () {
    $(this).toggleClass("active"), detailCheck()
}), $(".xztj>div li>input").click(function () {
    $(this).parent().siblings().removeClass("active")
}), $(".years_list").on("click", "li", function () {
    $(this).addClass("active").siblings().removeClass("active");
    var s = $(this).text();
    $(".listhead>span").text(s + "年开奖记录");
    var e = "", e = "";
    e = 0 != $(".xzsx>li .checked").length ? $(".xzsx>li>.checked").parent().attr("lang") : 1, smSixTools.yearsFun(e, s)
}), $(".xzsx>li:not(title)").click(function () {
    var s = $(this).attr("lang"), e = formatDate(new Date);
    $(".xztj>div>ul .active").removeClass("active"), smSixTools.yearsFun(s, e)
}), smSixTools.yearsFun = function (s, e) {
    1 == s ? attrArr = proto.Zoo : 2 == s ? attrArr = proto.fiveLineArr : 3 == s ? attrArr = proto.jiaqzs : 4 == s ? attrArr = proto.boy_girl : 5 == s ? attrArr = proto.top_bottom : 6 == s ? attrArr = proto.four_season : 7 == s ? attrArr = proto.cqsh : 8 == s && (attrArr = proto.colorCh), $.ajax({
        type: "post",
        url: config.publicUrl + "speedSix/findSpeedSixHistory.do?",
        data: {date: e, type: s},
        dataType: "json",
        beforeSend: function () {
            $(".box-title").siblings(".number_box").remove(), $("#noMoreDate").text("正努力加载中...").show()
        },
        success: function (s) {
            var e = "", a = s.result.data;
            if ("" == a || void 0 == a) return $("#noMoreDate").text("暂无更多数据").show(), !1;
            $("#noMoreDate").hide(), $.each(a.bodyList, function (s, a) {
                for (var i = [], t = [], l = a.preDrawCode.split(","), o = 0; o < a.color.length; o++) i.push(proto.colorEng[a.color[o]]), t.push(attrArr[a.czAndFe[o]]);
                if (0 == a.seventhSingleDouble ? a.seventhSingleDouble = "单" : 1 == a.seventhSingleDouble ? a.seventhSingleDouble = "双" : a.seventhSingleDouble = "和", 0 == a.seventhBigSmall ? a.seventhBigSmall = "大" : 1 == a.seventhBigSmall ? a.seventhBigSmall = "小" : a.seventhBigSmall = "和", 0 == a.totalBigSmall ? a.totalBigSmall = "大" : 1 == a.totalBigSmall ? a.totalBigSmall = "小" : a.totalBigSmall = "和", 0 == a.totalSingleDouble ? a.totalSingleDouble = "单" : 1 == a.totalSingleDouble && (a.totalSingleDouble = "双"), $(".aone").hasClass("active")) n = "opacity"; else var n = "";
                if ($(".atwo").hasClass("active")) c = "opacity"; else var c = "";
                if ($(".athree").hasClass("active")) r = "opacity"; else var r = "";
                if ($(".afour").hasClass("active")) h = "opacity"; else var h = "";
                if ($(".afive").hasClass("active")) u = "opacity"; else var u = "";
                if ($(".asix").hasClass("active")) p = "opacity"; else var p = "";
                if ($(".aseven").hasClass("active")) m = "opacity"; else var m = "";
                l[0] < 10 && (l[0] = "0" + l[0]), l[1] < 10 && (l[1] = "0" + l[1]), l[2] < 10 && (l[2] = "0" + l[2]), l[3] < 10 && (l[3] = "0" + l[3]), l[4] < 10 && (l[4] = "0" + l[4]), l[5] < 10 && (l[5] = "0" + l[5]), l[6] < 10 && (l[6] = "0" + l[6]), 0 == a.nanairo ? a.nanairo = "红" : 1 == a.nanairo ? a.nanairo = "绿" : 2 == a.nanairo ? a.nanairo = "蓝" : 3 == a.nanairo && (a.nanairo = "和局"), 0 == a.seventhSingleDouble ? a.seventhSingleDouble = "单" : 1 == a.seventhSingleDouble ? a.seventhSingleDouble = "双" : 2 == a.seventhSingleDouble && (a.seventhSingleDouble = "和"), 0 == a.seventhCompositeDouble ? a.seventhCompositeDouble = "合单" : 1 == a.seventhCompositeDouble ? a.seventhCompositeDouble = "合双" : 2 == a.seventhCompositeDouble && (a.seventhCompositeDouble = "和"), 0 == a.seventhCompositeBig ? a.seventhCompositeBig = "合大" : 1 == a.seventhCompositeBig ? a.seventhCompositeBig = "合小" : 2 == a.seventhCompositeBig && (a.seventhCompositeBig = "和"), 0 == a.seventhMantissaBig ? a.seventhMantissaBig = "尾大" : 1 == a.seventhMantissaBig ? a.seventhMantissaBig = "尾小" : 2 == a.seventhMantissaBig && (a.seventhMantissaBig = "和"), e += "<div class='hisNUm_box number_box'><ul><li class='Time_box'><span>" + a.preDrawTime + "</span><span>" + a.issue + "期</span></li><li class='hisNum_detail'><ul><li class='One " + n + "'data-text='" + t[0] + "'><span class='" + i[0] + "'>" + l[0] + "</span> <span>" + t[0] + "</span></li><li class='Two " + c + "'data-text='" + t[1] + "'><span class='" + i[1] + "'>" + l[1] + "</span> <span>" + t[1] + "</span></li><li class='Three " + r + "'data-text='" + t[2] + "'><span class='" + i[2] + "'>" + l[2] + "</span> <span>" + t[2] + "</span></li><li class='Four " + h + "'data-text='" + t[3] + "'><span class='" + i[3] + "'>" + l[3] + "</span> <span>" + t[3] + "</span></li><li class='Five " + u + "'data-text='" + t[4] + "'><span class='" + i[4] + "'>" + l[4] + "</span> <span>" + t[4] + "</span></li><li class='Six " + p + "'data-text='" + t[5] + "'><span class='" + i[5] + "'>" + l[5] + "</span> <span>" + t[5] + "</span></li></ul></li><li class='temaNum Seven " + m + "'data-text='" + t[6] + "'><span class='" + i[6] + "'>" + l[6] + "</span> <span>" + t[6] + "</span></li><li class='Daxia_dansh dansh_ '>" + a.sumTotal + "</li><li class='Daxia_dansh'>" + a.totalSingleDouble + "</li><li class='Daxia_dansh'>" + a.totalBigSmall + "</li><li class='Daxia_dansh'>" + a.nanairo + "</li><li class='Daxia_dansh'>" + a.seventhSingleDouble + "</li><li class='Daxia_dansh'>" + a.seventhBigSmall + "</li><li class='Daxia_dansh'>" + a.seventhCompositeDouble + "</li><li class='Daxia_dansh'>" + a.seventhCompositeBig + "</li><li class='Daxia_dansh'>" + a.seventhMantissaBig + "</li></ul></div>"
            }), $(".box-title").after(e), detailCheck()
        }
    })
}, $(function () {
    var s = formatDate(new Date);
    smSixTools.yearsFun(1, s)
}), $(".checksapn").on("click", function () {
    //$(".listhead").find(".checksapn").removeClass("active");
    var s = $(this).attr("class").split(" ")[1];
    return "wanfaxume" == s ? ($(this).addClass("active").siblings(".checksapn").removeClass("active"), $(".listbox_2").show().siblings(".listbox").hide(), $(".ch-right").hide(), !1) : ($(".listbox").show(), "haomafenbu" == s ? ($(this).hasClass("active"),$("#wanfaxume").hide(350), $(".ch-right").show() ? $(".hmfb").show(350) : $(".hmfb").show(350), $(this).toggleClass("active").siblings(".checksapn").removeClass("active"), $("#" + s).show().siblings(".hmfbTable").hide(), !1) : ($(".hmfb").hide(350), (!$(this).hasClass("active") || "haomafenbu" == s) && ($(this).addClass("active").siblings(".checksapn").removeClass("active"), $("#" + s).show().siblings(".hmfbTable").hide(), checkPpage($(".date").val(), $(".xzsx li>a.checked").parents().attr("lang")), $(".listbox_2").hide(), void $(".ch-right").show())))
}), smSixTools.getzhmaList = function (s) {
    $.ajax({
        type: "post",
        url: config.publicUrl + "getOrthocodeRoadOfBeadTrend.do",
        data: {date: s},
        dataType: "json",
        beforeSend: function () {
            $(".zhmaul").siblings(".zhmaulList").remove(), $("#noMoreDate").text("正努力加载中...").show()
        },
        success: function (e) {
            "String" == typeof e && (e = JSON.parse(s));
            var a = "", i = e.result.data;
            if ("" == i || void 0 == i) return $("#noMoreDate").text("暂无更多数据").show(), !1;
            a = "";
            $.each(i, function (s) {
                a += "<ul class='zhmaulList'><li class='qishou'>" + this.issue + "期</li>";
                for (var e = this.bodyList, i = 0; i < e.length; i++) e[i].color = proto.colorEng[e[i].color], 0 == e[i].bigSmall ? e[i].bigSmall = "大" : 1 == e[i].bigSmall ? e[i].bigSmall = "小" : 2 == e[i].bigSmall && (e[i].bigSmall = "和"), 0 == e[i].singleDouble ? e[i].singleDouble = "单" : 1 == e[i].singleDouble ? e[i].singleDouble = "双" : 2 == e[i].singleDouble && (e[i].singleDouble = "和"), 0 == e[i].compositeSingleDouble ? e[i].compositeSingleDouble = "单" : 1 == e[i].compositeSingleDouble ? e[i].compositeSingleDouble = "双" : 2 == e[i].compositeSingleDouble && (e[i].compositeSingleDouble = "和"), 0 == e[i].compositeBigSmall ? e[i].compositeBigSmall = "大" : 1 == e[i].compositeBigSmall ? e[i].compositeBigSmall = "小" : 2 == e[i].compositeBigSmall && (e[i].compositeBigSmall = "和"), 0 == e[i].mantissaBigSmall ? e[i].mantissaBigSmall = "大" : 1 == e[i].mantissaBigSmall ? e[i].mantissaBigSmall = "小" : 2 == e[i].mantissaBigSmall && (e[i].mantissaBigSmall = "和"), a += "<li class='zhmaLi'><ul><li><span class='" + e[i].color + "'>" + (e[i].num <= 9 ? "0" + e[i].num : e[i].num) + "</span></li><li>" + e[i].bigSmall + "</li><li>" + e[i].singleDouble + "</li>", "和" == e[i].compositeBigSmall ? a += "<li>和</li>" : a += "<li><p>合</p><p>" + e[i].compositeBigSmall + "</p></li>", "和" == e[i].compositeSingleDouble ? a += "<li>和</li>" : a += "<li><p>合</p><p>" + e[i].compositeSingleDouble + "</p></li>", "和" == e[i].mantissaBigSmall ? a += "<li>和</li></ul></li>" : a += "<li><p>尾</p><p>" + e[i].mantissaBigSmall + "</p></li></ul></li>", 5 == i && (a += "</ul>")
            }), $(".zhmaul").after(a), $("#noMoreDate").hide()
        }
    })
}, smSixTools.getshxiaoList = function (s) {
    $.ajax({
        type: "post",
        url: config.publicUrl + "getPoultryBeastHistory.do",
        data: {date: s},
        dataType: "json",
        beforeSend: function () {
            $(".shxiaoul").siblings(".shxiaoulList").remove(), $("#noMoreDate").text("正努力加载中...").show()
        },
        success: function (e) {
            "String" == typeof e && (e = JSON.parse(s));
            var a = e.result.data;
            if ("" == a || void 0 == a) return $("#noMoreDate").text("暂无更多数据").show(), !1;
            var i = "";
            $.each(a, function (s) {
                var e = "";
                i += "<ul class='shxiaoulList'><li class='sxqishou'><span>" + this.preDrawTime.slice(0, 5) + "</span><span>" + this.issue + "</span>期</li><li class='shxiaoKai'><ul>";
                for (var a = 0; a < 7; a++) i += 6 == a ? "</ul></li><li  class='shxiaotma'><span class='" + proto.colorEng[this.color[a]] + "'>" + (this.code[a] <= 9 ? "0" + this.code[a] : this.code[a]) + "</span></li>" : "<li class='" + proto.colorEng[this.color[a]] + "'>" + (this.code[a] <= 9 ? "0" + this.code[a] : this.code[a]) + "</li>", e += "<li class='shxiaoLi'><b>" + proto.Zoo[this.czAndFe[a]] + "</b><span>" + proto.jiaqzs_text[this.poultryBeast[a]] + "</span></li>";
                e += "<li class='zoxiao_num'>" + this.totalChineseZodiac + "</li><li class='zoxiao_danx'>" + (0 == this.totalChineseZodiacSD ? "单" : "双") + "</li></ul>", i += e
            }), $(".shxiaoul").after(i), $("#noMoreDate").hide()
        }
    })
}, smSixTools.gettemaList = function (s) {
    $.ajax({
        type: "post",
        url: config.publicUrl + "getSpecialShowHistory.do",
        data: {date: s},
        dataType: "json",
        beforeSend: function () {
            $(".termaul").siblings(".temaulList").remove(), $("#noMoreDate").text("正努力加载中...").show()
        },
        success: function (e) {
            "String" == typeof e && (e = JSON.parse(s));
            var a = e.result.data;
            if ("" == a || void 0 == a) return $("#noMoreDate").text("暂无更多数据").show(), !1;
            var i = "";
            $.each(a, function (s) {
                var e = proto.colorEng[this.color], a = "", t = "", l = "";
                a = 0 == this.seventhBigSmall ? "大" : 1 == this.seventhBigSmall ? "小" : "和", t = 0 == this.seventhSingleDouble ? "单" : 1 == this.seventhSingleDouble ? "双" : "和", "red" == e ? l = "红" : "blue" == e ? l = "蓝" : "green" == e && (l = "绿"), 0 == this.seventhCompositeDouble ? this.seventhCompositeDouble = "合单" : 1 == this.seventhCompositeDouble ? this.seventhCompositeDouble = "合双" : this.seventhCompositeDouble = "和", 0 == this.seventhCompositeBig ? this.seventhCompositeBig = "合大" : 1 == this.seventhCompositeBig ? this.seventhCompositeBig = "合小" : this.seventhCompositeBig = "和", 0 == this.seventhMantissaBig ? this.seventhMantissaBig = "尾大" : 1 == this.seventhMantissaBig ? this.seventhMantissaBig = "尾小" : this.seventhMantissaBig = "和", i += "<ul class = 'temaulList'> <li class = 'termaqishou'> <span>" + this.preDrawTime.slice(0, 5) + "</span><span>" + this.issue + "期</span></li>", i += " <li class = 'terma_'> <span class='" + e + "'>" + (this.num <= 9 ? "0" + this.num : this.num) + "</span></li>", i += "<li class='termadaxi'>" + a + "</li><li class='termadaxi'>" + t + "</li>", i += "<li class='termadaxi'>" + this.seventhCompositeBig + "</li><li class='termadaxi'>" + this.seventhCompositeDouble + "</li>", i += "<li class='termadaxi'>" + this.seventhMantissaBig + "</li><li class='termabante'> " + ("和" != a ? a + t : "和 ") + " </li>", i += "<li class = 'termazoo'><span> " + proto.Zoo[this.chineseZodiac] + "</span><span>" + proto.jiaqzs_text[this.poultryBeast] + "</span></li>", i += "<li class = 'termazoo'>" + this.seventhMantissa + "尾</li><li class = 'termacolor'>" + l + "</li>", i += " <li class = 'termacolor'>" + ("和" != a ? "<span>" + l + a + "</span><span>" + l + t + "</span>" : "和") + "</li>", i += "<li class = 'termabanbanbo'> " + ("和" != a ? l + a + t : "和") + " </li></ul>"
            }), $(".termaul").after(i), $("#noMoreDate").hide(), $("#termalz .temaulList>li.termadaxi:contains('大')").css("color", "#f8223c"), $("#termalz .temaulList>li.termadaxi:contains('双')").css("color", "#f8223c"), $("#termalz .temaulList>lispan:contains('大')").css("color", "#f8223c"), $("#termalz .temaulList>lispan:contains('双')").css("color", "#f8223c")
        }
    })
}, getFiveEle();