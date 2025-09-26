var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (a) {
    return typeof a
} : function (a) {
    return a && "function" == typeof Symbol && a.constructor === Symbol && a !== Symbol.prototype ? "symbol" : typeof a
};
$(function () {
    var a = window.location.href.split("?")[1];
    //caizhonmethod.loadotherData(a);
        $(".prevNext_page>p").on("click", "a:not('.pdisabled')", function () {
        var a = $(this).attr("data-text");
        $("title").text($(this).text()), caizhonmethod.loadotherData(a)
    })
});
var sessData = JSON.parse(sessionStorage.getItem("sessData")), publicurl = config.publicUrl, caizhonmethod = {},
    funObj = {}, newData = "";
caizhonmethod.loadotherData = function (a) {
    var t = {id: a, platform: "168"};
    $.ajax({
        url: publicurl + "news/findNewsParticularById.do", type: "GET", data: t, success: function (a) {
            $("body,html").animate({scrollTop: 0}, 500), caizhonmethod.createEdite(a)
        }, error: function (a) {
        }
    })
}, caizhonmethod.createEdite = function (a) {
    if ("0" == (a = JSON.parse(a)).errorCode) {
        var t = "";
        void 0 != (a = a.result.data).labels && $(a.labels.split(",")).each(function () {
            t += this + "&nbsp;"
        });
        $("#dhguanli_bianji");
        $("#title").text(a.title), $("#date").text(a.data), $("#pageView").text(a.pageView), $("#labels").html(t), $("#content").html(a.content);
        for (var e = 0; e < sessData.data.length; e++) if (-1 != sessData.data[e].title.indexOf($("#title").text())) {
            e - 1 >= 0 ? $(".prev_piece").attr("data-text", sessData.data[e - 1].newsId).text(sessData.data[e - 1].title).removeClass("pdisabled") : $(".prev_piece").attr("data-text", "").text("亲，本章已经是第一章啦").addClass("pdisabled"), e + 1 < sessData.data.length ? $(".next_piece").attr("data-text", sessData.data[e + 1].newsId).text(sessData.data[e + 1].title).removeClass("pdisabled") : sessData.funame ? setTimeout(sessData.funame, 1) : $(".next_piece").attr("data-text", "").text("亲，本章已经是最后一章啦").addClass("pdisabled");
            break
        }
    } else alert("数据错误，请稍后重新操作！")
}, checkRight = function () {
    sessData.pageNo += 1, void 0 != sessData.programaId ? funObj.loadList(sessData.programaId, sessData.pageNo, sessData.pageSize) : sessData.newAll ? funObj.loadNewsAll(sessData.pageNo, sessData.pageSize) : sessData.wanfaAll ? funObj.listData(sessData.pageNo, sessData.pageSize) : sessData.wanfaType ? funObj.listData_type(sessData.type, sessData.pageNo, sessData.pageSize) : sessData.fanfaHotLi ? funObj.fanfaHotli(sessData.pageNo, sessData.pageSize) : sessData.NewsHot && getHotArticle(sessData.pageNo, sessData.pageSize)
}, funObj.loadList = function (a, t, e) {
    var s = {programaId: a, pageNo: t = t, pageSize: e, platform: "168"};
    $.ajax({
        url: publicurl + "news/findNewsByPIdForPage.do", type: "GET", data: s, success: function (a) {
            if ("object" != (void 0 === a ? "undefined" : _typeof(a))) var a = JSON.parse(a);
            "0" == a.errorCode && "0" == a.result.businessCode && (sessData.data = sessData.data.concat(a.result.data.list), newData = a.result.data.list, funObj.pushNext())
        }, error: function (a) {
            funObj.onErrNotNext()
        }
    })
}, funObj.loadNewsAll = function (a, t) {
    var e = {pageNo: a = a, pageSize: t, platform: "168"};
    $.ajax({
        url: publicurl + "news/findNewsOrderByTime.do?", type: "GET", data: e, success: function (a) {
            if ("object" != (void 0 === a ? "undefined" : _typeof(a))) var a = JSON.parse(a);
            "0" == a.errorCode && "0" == a.result.businessCode && (sessData.data = sessData.data.concat(a.result.data.list), newData = a.result.data.list, funObj.pushNext())
        }, error: function (a) {
            funObj.onErrNotNext()
        }
    })
}, funObj.listData = function (a, t) {
    $(".wanfali").empty();
    var e = {pageNo: a, pageSize: t};
    $.ajax({
        url: publicurl + "playTricks/findPlayTricksOrderByTime.do",
        type: "get",
        data: e,
        async: !1,
        success: function (a) {
            if ("object" != (void 0 === a ? "undefined" : _typeof(a))) var a = JSON.parse(a);
            sessData.data = sessData.data.concat(a.result.data.list), newData = a.result.data.list, funObj.pushNext()
        },
        error: function (a) {
            funObj.onErrNotNext()
        }
    })
}, funObj.listData_type = function (a, t, e) {
    $(".wanfali").empty();
    var s = {type: a, pageNo: t, pageSize: e};
    $.ajax({
        url: publicurl + "playTricks/findHotPlayTricks.do", type: "get", data: s, async: !1, success: function (a) {
            if ("object" != (void 0 === a ? "undefined" : _typeof(a))) var a = JSON.parse(a);
            sessData.data = sessData.data.concat(a.result.data.list), newData = a.result.data.list, funObj.pushNext()
        }, error: function (a) {
            funObj.onErrNotNext()
        }
    })
}, funObj.fanfaHotli = function (a, t) {
    $(".nomarginTop>ul").empty();
    var e = {pageNo: a, pageSize: t};
    $.ajax({
        url: publicurl + "playTricks/findHotPlayTricks.do", type: "get", data: e, async: !1, success: function (a) {
            if ("object" != (void 0 === a ? "undefined" : _typeof(a))) var a = JSON.parse(a);
            sessData.data = sessData.data.concat(a.result.data.list), newData = a.result.data.list, funObj.pushNext()
        }, error: function (a) {
            funObj.onErrNotNext()
        }
    })
}, getHotArticle = function (a, t) {
    $.ajax({
        type: "get",
        url: publicurl + "news/findHotNews.do",
        async: !0,
        data: {pageNo: a, pageSize: t, platform: "168"},
        dataType: "json",
        success: function (a) {
            if ("object" != (void 0 === a ? "undefined" : _typeof(a))) var a = JSON.parse(a);
            sessData.data = sessData.data.concat(a.result.data.list), newData = a.result.data.list, funObj.pushNext()
        },
        error: function (a) {
            funObj.onErrNotNext()
        }
    })
}, funObj.pushNext = function () {
    try {
        $(".next_piece").attr("data-text", newData[0].newsId).text(newData[0].title).removeClass("pdisabled")
    } catch (a) {
        funObj.onErrNotNext()
    }
}, funObj.onErrNotNext = function () {
    $(".next_piece").attr("data-text", "").text("亲，本章已经是最后一章啦").addClass("pdisabled")
};