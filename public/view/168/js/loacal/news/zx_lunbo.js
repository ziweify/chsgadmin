var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
$(function () {
    method.loadBanner();
    var t = $("#Box1"), e = t.find("ul"), a = t.find(".spanner1 span"), i = t.find("#ul li").eq(0).width(), s = 0;
    a.on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
        var t = $(this).index();
        s = t, e.animate({left: -i * s})
    }), setInterval(function () {
        ++s > a.legnth - 1 && (s = 0), a.eq(s).trigger("click")
    }, 2e3), $(".left_down_nav").find("li").live("click", function () {
        $(this).addClass("active2").siblings().removeClass();
        var t = $(this).attr("id");
        pageNo = 1, method.loadList(t, pageNo, pageSize)
    }), $("#loadmorebtn").click(function () {
        var t = $("#titlelist").find(".active2").attr("id");
        method.loadList(t, pageNo += 1, pageSize)
    })
});
var pnumber = 1, psize = 10, publicurl = config.publicUrl, publicBkurl = config.imgUrl, method = {}, pageNo = 1,
    pageSize = 7, hotnewsulData = "", listcontentData = "";
method.loadBanner = function () {
    $.ajax({
        url: publicurl + "news/findNewestCarousel.do",
        type: "GET",
        data: {platform: "168"},
        async: !1,
        success: function (t) {
            method.creatHtmlBanner(t)
        },
        error: function (t) {
        }
    })
}, method.creatHtmlBanner = function (t) {
    ($("#Box1").find("#ul").empty(), $("#Box1").find("#spanner1").empty(), "0" == t.result.businessCode ? (t = t.result.data, $(t).each(function (t) {
        var e = "<li><img src='" + this.image + "' onerror='method.defaultViewigm(this)'/></li>", a = "";
        a = 0 == t ? "<span class='active'></span>" : "<span></span>", $("#Box1").find("#ul").append(e), $("#Box1").find("#spanner1").append(a)
    })) : alert("数据错误，请稍后重新操作！"))
}, method.loadHotnews = function () {
    $.ajax({
        url: publicurl + "news/findNewestHeadline.do",
        type: "GET",
        data: {platform: "168"},
        async: !1,
        success: function (t) {
            method.creatHtmlHotnews(t)
        },
        error: function (t) {
        }
    })
}, method.creatHtmlHotnews = function (t) {
    "0" == (t = JSON.parse(t)).errorCode && ("0" == t.result.businessCode ? (t = t.result.data, hotnewsulData = t, $(t).each(function (t) {
        var e = "";
        0 == t ? ($("#hottitle").html("<a target='_blank' href='/news/detail-" + this.newsId + ".html'>" + this.title + "</a>"), $("#hotdescription").text(this.description.length > 120 ? this.description.substr(0, 120) + "..." : this.description)) : e = '<li><img src="../../img/zixun/dot.png"/><a  target=\'_blank\' href="/news/detail-' + this.newsId + '.html">' + (this.title.length > 27 ? this.title.substr(0, 27) + "..." : this.title) + "</a></li>", $("#hotnewsul").append(e)
    })) : alert("数据错误，请稍后重新操作！"))
}, method.loadHot = function () {
    return $.ajax({
        url: publicurl + "programa/findNewestHPNews.do",
        type: "GET",
        data: {platform: "168"},
        async: !1,
        success: function (t) {
            method.creatHtmlHot(t)
        },
        error: function (t) {
        }
    }), programaId
}, method.creatHtmlHot = function (t) {
    var e = "";
    return "0" == (t = JSON.parse(t)).errorCode && ($("#titlelist").empty(), "0" == t.result.businessCode ? (t = t.result.data, $(t).each(function (t) {
        var a = "";
        0 == t ? (e = this.id, a = "<li class='active2' id='" + this.id + "'><a href='javascript:void(0)' class='active1'>" + this.name + "</a></li>") : a = "<li id='" + this.id + "'><a href='javascript:void(0)' class='active1'>" + this.name + "</a></li>", $("#titlelist").append(a)
    })) : alert("数据错误，请稍后重新操作！")), e
}, method.loadTitle = function () {
    var t = "";
    return $.ajax({
        url: publicurl + "programa/findDisplay.do",
        type: "GET",
        data: {platform: "168"},
        async: !1,
        success: function (e) {
            t = method.creatHtmlTitle(e)
        },
        error: function (t) {
        }
    }), t
}, method.creatHtmlTitle = function (t) {
    var e = "";
    return "0" == (t = JSON.parse(t)).errorCode && ($("#titlelist").empty(), "0" == t.result.businessCode ? (t = t.result.data, $(t).each(function (t) {
        var a = "";
        0 == t ? (e = this.id, a = "<li class='active2' id='" + this.id + "'><a href='javascript:void(0)' class='active1'>" + this.name + "</a></li>") : a = "<li id='" + this.id + "'><a href='javascript:void(0)' class='active1'>" + this.name + "</a></li>", $("#titlelist").append(a)
    })) : alert("数据错误，请稍后重新操作！")), e
}, method.loadList = function (t, e, a) {
    var i = {programaId: t, pageNo: e = e, pageSize: a, platform: "168"};
    $.ajax({
        url: publicurl + "news/findNewsByPIdForPage.do", type: "GET", data: i, beforeSend: function () {
            $("#loadmorebtn").text("努力加载中...")
        }, success: function (e) {
            method.creatHtmlList(e, t)
        }, error: function (t) {
        }
    })
};
var lanmuId = "";
method.creatHtmlList = function (t, e) {
    lanmuId != e && $("#listcontent").empty(), lanmuId = e, "0" == (t = JSON.parse(t)).errorCode && ("0" == t.result.businessCode ? (t = t.result.data, listcontentData = t.list, "" == t ? $("#loadmorebtn").text("咦，没更多了") : $("#loadmorebtn").text("加载更多"), $(t.list).each(function (t, e) {
        var a = this.description;
        a.length > 120 && (a = a.substr(0, 120) + "...");
        var i = "<div class='div_list'><div class='div_inline'><div class='div_l'><a target='_blank' href='/news/detail-" + this.newsId + ".html'><img src='" + publicBkurl + this.image + "' onerror='method.defaultViewigm(this)'/></a></div><div class='div_r'><h3><a target='_blank' href='/news/detail-" + this.newsId + ".html'>" + this.title + "</a></h3><p>" + a + "</p><div><span class='span_l'><img src='../../img/zixun/small_pic.png' alt='' /><span class='sum'>" + this.pageView + "</span></span><span class='span_r'><span>" + this.releaseDate + "</span></span></div></div></div></div>";
        if ($("#listcontent").append(i), 2 == t) return !1
    })) : alert("数据错误，请稍后重新操作！"))
}, method.defaultViewigm = function (t) {
    $(t).attr("src", "../../img/icon/view.png")
}, method.loadLabels = function () {
    $.ajax({
        url: publicurl + "label/findLabelListTwenty.do",
        type: "GET",
        data: {platform: "168"},
        async: !1,
        beforeSend: function () {
            $("#hotLabel").text("正在加载...")
        },
        success: function (t) {
            if ("object" == (void 0 === (t = t) ? "undefined" : _typeof(t)) || (t = JSON.parse(t)), "0" == t.errorCode) if ("0" == t.result.businessCode) {
                $("#hotLabel").empty();
                var e = "";
                $(t.result.data).each(function () {
                    e += "<li><a target='_blank' href='zx_list.html?hotlabel?" + this.id + "'>" + this.name + "</a></li>"
                }), $("#hotLabel").append(e)
            } else $("#hotLabel").empty().text("数据加载异常！")
        },
        error: function (t) {
        }
    })
}, method.listData = function (t, e) {
    $(".rule_box").empty();
    var a = {pageNo: t, pageSize: e};
    $.ajax({
        url: publicurl + "playTricks/findPlayTricksOrderByTime.do",
        type: "get",
        data: a,
        async: !1,
        success: function (t) {
            if ("object" != (void 0 === t ? "undefined" : _typeof(t))) var t = JSON.parse(t);
            t = t.result.data, liDate = t.list, method.liallcreate(t)
        },
        error: function (t) {
        }
    })
}, method.liallcreate = function (t) {
    var e = "", a = "", i = "", s = ["", "PK拾", "时时彩", "快三", "快乐十分", "11选5", "其它"];
    $.each(t.list, function (t, e) {
        t <= 4 ? a += "<li><a href='wfjq_detail.html?" + e.id + "'><span class='lotype'>[" + s[e.type] + "]</span>" + e.title + "</a></li>" : t > 4 && (i += "<li><a href='wfjq_detail.html?" + e.id + "'><span class='lotype'>[" + s[e.type] + "]</span>" + e.title + "</a></li>")
    }), e = "<ul class='pk10_rule'>" + a + "</ul><ul class='sscrule'>" + i + "</ul>", $(".rule_box").html(e)
}, $(function () {
    hotnewsulData = JSON.parse($("#hotnewsulData").val()), listcontentData = JSON.parse($("#listcontentData").val()), liDate = JSON.parse($("#liDate").val()), $(".about_top1").on("click", "a", function (t) {
        var e = {data: hotnewsulData, funame: !1};
        JSON.stringify(e), sessionStorage.setItem("sessData", JSON.stringify(e))
    }), $("#listcontent").on("click", "a", function () {
        var t = {
            data: listcontentData,
            funame: "checkRight()",
            programaId: $(".active2").attr("id"),
            pageNo: 1,
            pageSize: 7
        };
        JSON.stringify(t), sessionStorage.setItem("sessData", JSON.stringify(t))
    }), $(".rule_box>ul>li").on("click", "a", function () {
        var t = {data: liDate, funame: "checkRight()", wanfaAll: !0, pageNo: 1, pageSize: 7};
        JSON.stringify(t), sessionStorage.setItem("sessData", JSON.stringify(t))
    })
});