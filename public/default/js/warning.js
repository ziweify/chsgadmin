$(function () {
    $("#btnRefresh").click(function () {
        WarningPanel.reload(!0)
    }), $("#refreshWarn").change(function () {
        WarningPanel.key = $(this).val(), WarningPanel.reload(!0)
    }), WarningPanel.init()
});
var WarningPanel = {
    timeOffset: 0,
    timer: null,
    interval: 90,
    refreshRemain: -1,
    countdownText: "{0}秒",
    countdownPanel: null,
    loadOptions: null,
    loadingState: null,
    lottery: null,
    key: null,
    gameMap: null,
    showAll: !0,
    isNotice: !1,
    now: function (t) {
        return t ? (new Date).getTime() : (new Date).getTime() - this.timeOffset
    },
    settingTime: function (t) {
        t = Number(t), isNaN(t) || (this.timeOffset = this.now(!0) - t)
    },
    init: function (t) {
        LIBS.clone(this, t), this.countdownPanel || (this.countdownPanel = $("#cdRefresh"));
        var e = this, t = (LIBS.get("../../time", function (t) {
            e.settingTime(t)
        }), this.timer = setInterval(function () {
            e.doInterval()
        }, 1e3), $("#refreshInteval"));
        0 < t.length && (t.change(function () {
            e.changeInterval($(this).val())
        }), this.changeInterval(t.val())), LIBS.get("gameMap", function (t) {
            e.gameMap = t, $(".warnTotal a:eq(0)").click()
        }), this.reload(!0)
    },
    reload: function (t) {
        var e;
        this.loadingState || (t && ($.isFunction(this.showLoading) ? this.showLoading() : this.showRefreshRemain(0)), data = {
            lottery: this.lottery,
            key: this.key,
            time: $("#keepTime").val()
        }, (e = this).loadingState = $.ajax({
            url: "warning", type: "POST", data: data, success: function (t) {
                e.loadingState = null;
                try {
                    e.show(t)
                } catch (t) {
                    alert("loading warning:" + t.message)
                }
            }, complete: function () {
                $(".contents").show(), e.refreshRemain = e.interval, e.showRefreshRemain()
            }
        }))
    },
    show: function (t) {
        var e = this, n = $(".layout .data_table:eq(0)"), a = $(".layout .data_table:eq(1)"),
            i = $(".layout .data_table:eq(2)");
        if ($("#refreshWarn").data("games", t.gameMap), t.totals) for (var o in t.totals) $("#_" + o).text(t.totals[o]);
        e.buildData(t.warnFirst, n, !0), e.buildData(t.warnLast, a), e.buildData(t.warnKey, i, !1), e.showAll = !1, e.notice()
    },
    buildData: function (t, e, n) {
        if (t) {
            var a = e.data("lastUpt"), i = 0;
            e.find("tbody").empty();
            for (var o = 0, s = t.length; o < s; o++) {
                var r = t[o], l = Number(r.upt), i = Math.max(i, l), l = "<tr><td>" + (o + 1) + "</td>",
                    l = (l = (l += "<td>" + r.text + "</td>") + ("<td>" + r.amount + "</td>")) + ("<td>" + this.formatTime(r.upt) + "</td>") + "</tr>";
                e.append(l)
            }
            a ? n && a < i && (this.isNotice = !0, e.data("lastUpt", i)) : e.data("lastUpt", i)
        }
    },
    selectLottery: function (t, e) {
        var n = !0;
        if (null == this.lottery && (n = !1), this.lottery != t) {
            this.lottery = t, $("#curnLottery").text(e);
            var a = $("#refreshWarn"), e = (a.empty(), this.gameMap);
            if (e) {
                var i = e[t];
                if (i) {
                    a.append('<option value="">全部</option>');
                    for (var o = 0, s = i.length; o < s; o++) {
                        var r = $("<option>").text(i[o].name).val(i[o].key);
                        a.append(r)
                    }
                }
            }
            n && this.reload(!0)
        }
    },
    notice: function () {
        var t;
        this.isNotice && SOUND_URL && (0 == (t = $("#SOUND")).length ? (t = $('<audio id="SOUND"><source src="' + SOUND_URL + '" type="audio/mpeg"/></audio>').appendTo($("body"))[0]).load && t.load() : t = t[0], t.play && t.play(), this.isNotice = !1)
    },
    formatTime: function (t) {
        t = Number(t);
        return isNaN(t) ? "-" : new Date(t).format("hh:mm:ss")
    },
    changeInterval: function (t) {
        this.interval = t, 0 < (this.refreshRemain = t) && this.showRefreshRemain()
    },
    showRefreshRemain: function (t) {
        0 <= (t = void 0 === t ? this.refreshRemain : t) ? $.isFunction(this.countdownText) ? this.countdownText(t) : this.countdownPanel && (0 == t ? this.countdownPanel.html("<span>载入中…</span>") : (t = t, this.countdownText && (t = this.countdownText.format(t)), this.countdownPanel.text(t))) : this.countdownPanel.html("")
    },
    doInterval: function () {
        this.interval <= 0 || (--this.refreshRemain, this.showRefreshRemain(), this.refreshRemain <= 0 && this.reload(!0))
    }
};
