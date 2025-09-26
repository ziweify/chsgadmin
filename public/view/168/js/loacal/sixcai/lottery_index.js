var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
    return typeof t
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
}, twdlt = {};
$(function () {
    $("#date").val(config.formatDate), laydate.render({
        elem: "#date", trigger: "click", done: function (t, e, o) {
            twdlt.getInit(t)
        }
    }), twdlt.getInit()
}), twdlt.getInit = function (t) {
    TimeList = void 0 == t ? config.formatDate : t, $.ajax({
        url: urlbublic + "taiWanCai/getHistoryLotteryInfo.do",
        type: "GET",
        data: {lotCode: lotCode, date: TimeList},
        success: function (t) {
            twdlt.createHtml(t), animateMethod.loadingList("#jrsmhmtj", !1)
        },
        error: function (t) {
            setTimeout(function () {
                loadotherData()
            }, config.listTime), config.ifdebug
        }
    })
}, twdlt.createHtml = function (t) {
    "object" != (void 0 === t ? "undefined" : _typeof(t)) ? l = JSON.parse(t) : (l = JSON.stringify(t), l = JSON.parse(l));
    var e = [], o = "", i = "", n = "", l = l.result.data;
    void 0 == l.result && $("#jrsmhmtjTab").find("tbody").empty();
    var r = "<tr>";
    $(l).each(function (t) {
        e = this.preDrawCode.split(",");
        for (var l = 0; l < e.length; l++) 10071 == lotCode ? n = l + 1 == e.length ? "twLottery" : "tw_power" : 10072 == lotCode ? n = "tw_numblue" : 10070 == lotCode && (n = l + 1 == e.length ? "twLottery" : "tw_numblue"), o += '<li class="' + n + '" style="color:#012537"><i>' + e[l] + "</i></li>";
        i = -1 == this.sumSingleDouble ? "双" : "单", r += "\n\t\t\t<td>" + this.preDrawTime + "</td>\n\t\t\t<td>" + this.preDrawIssue + '</td>\n\t\t\t<td class="blueqiu"><ul style="width:240px">' + o + "</ul></td>\n\t\t\t<td>" + this.sumNum + "</td>\n\t\t\t<td>" + i + "</td></tr>\n\t\t\t", $("#jrsmhmtjTab").find("tbody").html(r), o = ""
    })
};