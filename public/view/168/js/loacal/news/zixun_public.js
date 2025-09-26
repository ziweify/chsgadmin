function SetHome(e) {
    document.all ? (document.body.style.behavior = "url(#default#homepage)", document.body.setHomePage(e)) : alert("您好,您的浏览器不支持自动设置页面为首页功能,请您手动在浏览器里设置该页面为首页!")
}

function addFavorite2() {
    var e = window.location, t = document.title, o = navigator.userAgent.toLowerCase();
    if (o.indexOf("360se") > -1) alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！"); else if (o.indexOf("msie 8") > -1) window.external.AddToFavoritesBar(e, t); else if (document.all) try {
        window.external.addFavorite(e, t)
    } catch (e) {
        alert("您的浏览器不支持,请按 Ctrl+D 手动收藏!")
    } else window.sidebar ? window.sidebar.addPanel(t, e, "") : alert("您的浏览器不支持,请按 Ctrl+D 手动收藏!")
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
    return typeof e
} : function (e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
}, bgSelect = setInterval(function () {
    $(".zixun_nav").addClass("li_checked").siblings().removeClass("li_checked"), 0 != $(".zixun_nav").length && clearInterval(bgSelect)
}, 200), hotNewData = "";
$(function () {
    $(".movedowm").on({
        hover: function () {
            $(".tjlottey").addClass("hover")
        }
    }), $(".tjlottey").mouseleave(function () {
        $(this).removeClass("hover")
    });
    var e = config.publicUrl;
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $(document).scroll(function () {
        $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
    }), $("#headdivbox").load("/view/public/head.html", function () {
        pupajax()
    }), $("#fooderbox").load("/view/public/fooder.html", function () {
    }), getHotArticle_createhtml = function (t, o) {
        $("#hotNews>ul").empty(), $.ajax({
            type: "get",
            url: e + "news/findHotNews.do",
            async: !0,
            data: {pageNo: t, pageSize: o, platform: "168"},
            dataType: "json",
            success: function (e) {
                if ("object" != (void 0 === e ? "undefined" : _typeof(e))) var e = JSON.parse(e);
                hotNewData = e.result.data.list, getHotArticle_create(e.result.data)
            },
            error: function (e) {
            }
        })
    }, getHotArticle_create = function (e) {
        var t = "";
        $.each(e.list, function (e, o) {
            t += "<li><a href='zx_detail.html?" + o.newsId + "'> <span>[" + o.programaName + "]</span>" + o.title + "</a></li>"
        }), $("#hotNews>ul").html(t)
    };
    0 != $("#hotNewData").length && (hotNewData = JSON.parse($("#hotNewData").val())), $("#hotNews>ul").on("click", "a", function (e) {
        var t = {data: hotNewData, funame: "checkRight()", NewsHot: !0, pageNo: 1, pageSize: 8};
        JSON.stringify(t), sessionStorage.setItem("sessData", JSON.stringify(t))
    })
});