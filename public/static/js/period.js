var PeriodPanel;
var lottery;
var pageMap;
var tableId;
var mapping = {X1: "闲一", X2: "闲二", X3: "闲三", X4: "闲四", X5: "闲五"};
if (!PeriodPanel) {
    $.ajaxSetup({cache: false});

    function showTime(a, b) {
        if (a && a.length > 0) {
            a.text(LIBS.timeToString(b))
        }
    }

    function fillCDPanel(b, a) {
        var c = a + "Panel";
        if (b[a] == null && b[c] != null) {
            b[a] = b[c].children("span")
        } else {
            if (b[c] == null && b[a] != null) {
                b[c] = b[a].parent()
            }
        }
    }

    function checkEmpty(d, c) {
        for (var b = 0; b < c.length; b++) {
            var a = c[b];
            if (d[a] && d[a].length === 0) {
                d[a] = null
            }
        }
    }

    function bindComplete(c, b) {
        var a = b.complete;
        b.complete = function () {
            if (c.refreshRemain <= 0) {
                c.refreshRemain = c.interval;
                c.showRefreshRemain()
            }
            if (a) {
                a.apply(this, arguments)
            }
        };
        return b
    }

    var NUM_CONV = "一二三四五六七八九十".split("");

    function clearChanglongTitle(b) {
        if (b.indexOf("冠亚") == 0 && b.indexOf("-") == -1) {
            b = b.replace("冠亚", "冠亚军和 - ")
        } else {
            b = b.replace("-", " - ");
            for (var a = 0; a < NUM_CONV.length; a++) {
                b = b.replace(NUM_CONV[a], a + 1)
            }
        }
        return b
    }

    var isGameClosePopupOpen = false;
    PeriodPanel = (function () {
        return {
            timeOffset: 0,
            timer: null,
            interval: 90,
            refreshRemain: -1,
            titleConverter: clearChanglongTitle,
            loadOptions: null,
            loadingState: null,
            changlong: null,
            drawPanel: null,
            lastResult: null,
            resultTimer: null,
            resultInterval: 6000,
            accountTimer: null,
            accountInterval: 30000,
            countdownText: "{0}秒",
            countdownPanel: null,
            drawNumberText: null,
            drawNumberPanel: null,
            showLoading: null,
            cdOpenPanel: null,
            cdClosePanel: null,
            cdDrawPanel: null,
            cdOpen: null,
            cdClose: null,
            cdDraw: null,
            periodShowType: 0,
            refreshFlag: -1000,
            onResultChange: null,
            onPeriodChange: null,
            onLoadData: null,
            onAccountUpdated: null,
            onChangLongClick: null,
            now: function (a) {
                if (a) {
                    return (new Date()).getTime()
                }
                return (new Date()).getTime() - this.timeOffset
            },
            settingTime: function (a) {
                a = Number(a);
                if (isNaN(a)) {
                    return
                }
                this.timeOffset = this.now(true) - a
            },
            init: function (b, d) {
                tableId = LIBS.getUrlParam("tableId");
                LIBS.clone(this, b);
                fillCDPanel(this, "cdOpen");
                fillCDPanel(this, "cdClose");
                fillCDPanel(this, "cdDraw");
                if (!this.drawPanel) {
                    this.drawPanel = $("#drawInfo")
                }
                if (!this.countdownPanel) {
                    this.countdownPanel = $("#cdRefresh")
                }
                if (!this.drawNumberPanel) {
                    this.drawNumberPanel = $("#drawNumber")
                }
                if (d) {
                    $("#gameName").text(d)
                }
                checkEmpty(this, ["cdOpen", "cdOpenPanel", "cdClose", "cdClosePanel", "cdDraw", "cdRefresh", "cdDrawPanel", "drawPanel", "countdownPanel", "drawNumberPanel", "changlong"]);
                var c = this;
                LIBS.get("../time", function (e) {
                    c.settingTime(e)
                });
                this.timer = setInterval(function () {
                    if (c.period) {
                        c.showPeriod()
                    }
                    c.doInterval()
                }, 1000);
                var a = $("#refreshInteval");
                if (a.length > 0) {
                    a.change(function () {
                        c.changeInterval($(this).val())
                    });
                    this.changeInterval(a.val())
                }
                if (this.loadOptions && !$.isFunction(this.loadOptions)) {
                    bindComplete(this, this.loadOptions)
                }
                this.reload()
            },
            reload: function (a) {
                if (this.loadingState) {
                    return
                }
                if (this.reloadDelayTimer) {
                    clearTimeout(this.reloadDelayTimer);
                    this.reloadDelayTimer = null
                }
                if (a) {
                    if ($.isFunction(this.showLoading)) {
                        this.showLoading()
                    } else {
                        this.showRefreshRemain(0)
                    }
                }
                data = {lottery: lottery, tableId: tableId, games: games};
                if (typeof periodUser !== "undefined") {
                    data.username = periodUser
                }
                var b = this;
                this.loadingState = $.ajax({
                    url: "period", data: data, success: function (i) {
                        var d = i && i.nextOpenTime;
                        b.loadingState = null;
                        if (d && !isGameClosePopupOpen) {
                            isGameClosePopupOpen = true;
                            var f = {
                                "关闭": function () {
                                    dialog.close()
                                }
                            };
                            var c = $("#lotteryName").text();
                            var j = moment(new Date(d)).locale("zh_cn");
                            var g = '<div class="game-close-popup" style="text-align: center;"><svg style="margin: 0 auto 10px;" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><g id="Group_17" data-name="Group 17" transform="translate(-920 -412)"><circle id="Ellipse_2" cx="40" cy="40" r="40" transform="translate(920 412)" fill="#cc0a0a"/><circle id="Ellipse_3" cx="30" cy="30" r="30" transform="translate(930 422)" fill="#f9f9f9"/><rect id="Rectangle_5" width="10" height="26" rx="5" transform="translate(955.284 446.284)" fill="#cc0a0a"/><rect id="Rectangle_6" width="10" height="10" rx="5" transform="translate(955.284 432.284)" fill="#cc0a0a"/></g></svg><div class="game-close-popup-title" style="font-weight: bold; font-size: 18px;"><span>' + c + '</span>现已关盘</div><div class="message">下期开盘时间为</div><div class="date" style="color: green;">' + j.format("MM月DD号 | A hh:mm:ss") + "</div></div>";
                            if (dialog) {
                                window.dialog._show("温馨提示", g, f)
                            }
                        }
                        try {
                            b.changePeriod(i)
                        } catch (h) {
                            alert("loading period:" + h.message)
                        }
                    }, complete: function () {
                        if (b.refreshRemain <= 0) {
                            b.refreshRemain = b.interval;
                            b.showRefreshRemain()
                        }
                    }
                })
            },
            changePeriod: function (d) {
                if (d) {
                    var c = this.now();
                    var b = d.status;
                    d.rstatus = b;
                    if (d.openTime <= c && b < 1) {
                        d.status = 1
                    }
                    if (d.closeTime <= c && b < 2) {
                        d.status = 2
                    }
                }
                var a = this.period;
                this.period = d;
                if (a === undefined || (!!a) != (!!d) || (d && (d.drawNumber != a.drawNumber || d.status != a.status))) {
                    if ($.isFunction(this.onPeriodChange)) {
                        if (this.onPeriodChange(d, a) === false) {
                            return
                        }
                    }
                    this.loadResult();
                    if (template == "HK6") {
                        setZodiacBalls()
                    }
                }
                if (d) {
                    this.reloadData()
                }
                this.showPeriod()
            },
            reloadData: function () {
                if (this.loadingState) {
                    return
                }
                if (this.loadOptions) {
                    var a = this.loadOptions;
                    if ($.isFunction(a)) {
                        a = a()
                    }
                    if (a) {
                        LIBS.ajax(a)
                    }
                }
                if ($.isFunction(this.onLoadData)) {
                    this.onLoadData(this)
                }
            },
            reloadDataDelay: function (a) {
                if (!a) {
                    a = 3000
                }
                if (this.reloadDelayTimer) {
                    return
                }
                var b = this;
                this.reloadDelayTimer = setTimeout(function () {
                    b.reloadDelayTimer = null;
                    b.reload()
                }, a)
            },
            changeInterval: function (a) {
                this.interval = a;
                this.refreshRemain = a;
                if (a > 0) {
                    this.showRefreshRemain()
                }
            },
            showRefreshRemain: function (b) {
                if (b === undefined) {
                    b = this.refreshRemain
                }
                if (b >= 0) {
                    if ($.isFunction(this.countdownText)) {
                        this.countdownText(b);
                        return
                    } else {
                        if (this.countdownPanel) {
                            if (b == 0) {
                                this.countdownPanel.html("<span>载入中…</span>")
                            } else {
                                var a = b;
                                if (this.countdownText) {
                                    a = this.countdownText.format(a)
                                }
                                this.countdownPanel.text(a)
                            }
                        }
                    }
                }
            },
            doInterval: function () {
                if (this.refreshRemain <= 0) {
                    return
                }
                this.refreshRemain -= 1;
                this.showRefreshRemain();
                if (this.refreshRemain <= 0) {
                    this.reload(true)
                }
            },
            showPeriod: function () {
                var g = this.period;
                if (!g) {
                    if (this.drawNumberPanel) {
                        this.drawNumberPanel.text("")
                    }
                    showTime(this.cdOpen, 0);
                    showTime(this.cdClose, 0);
                    showTime(this.cdDraw, 0)
                } else {
                    if (this.drawNumberPanel) {
                        var d = g.drawNumber;
                        if (this.drawNumberText) {
                            d = this.drawNumberText.format(d)
                        }
                        this.drawNumberPanel.text(d)
                    }
                    var e = this.now();
                    var c = g.openTime - e;
                    var f = g.closeTime - e;
                    var a = g.drawTime - e;
                    if (isNaN(c) && isNaN(f) && isNaN(a)) {
                        showTime(this.cdOpen, 0);
                        showTime(this.cdClose, 0);
                        showTime(this.cdDraw, 0)
                    } else {
                        showTime(this.cdOpen, c);
                        showTime(this.cdClose, f);
                        showTime(this.cdDraw, a)
                    }
                    if (f < 1000 && f >= -2000) {
                        if (typeof toggleBet === "function") {
                            toggleBet(false)
                        } else {
                            if (typeof toggleStatus === "function") {
                                toggleStatus(false)
                            }
                        }
                    }
                    if (this.periodShowType == 0 && this.cdOpenPanel) {
                        if (c > 0) {
                            this.cdOpenPanel.show();
                            this.cdClosePanel.hide();
                            this.cdOpenPanel.parent(".cdContainer").show();
                            this.cdClosePanel.parent(".cdContainer").hide()
                        } else {
                            this.cdOpenPanel.hide();
                            this.cdClosePanel.show();
                            this.cdOpenPanel.parent(".cdContainer").hide();
                            this.cdClosePanel.parent(".cdContainer").show()
                        }
                    } else {
                        if (this.periodShowType == 1) {
                            if (c > 0) {
                                this.cdOpenPanel.show();
                                this.cdClosePanel.hide();
                                this.cdOpenPanel.parent(".cdContainer").show();
                                this.cdClosePanel.parent(".cdContainer").hide();
                                this.cdDrawPanel.hide()
                            } else {
                                if (f > 0) {
                                    this.cdOpenPanel.hide();
                                    this.cdClosePanel.show();
                                    this.cdOpenPanel.parent(".cdContainer").hide();
                                    this.cdClosePanel.parent(".cdContainer").show();
                                    this.cdDrawPanel.hide()
                                } else {
                                    this.cdOpenPanel.hide();
                                    this.cdClosePanel.hide();
                                    this.cdDrawPanel.show();
                                    this.cdOpenPanel.parent(".cdContainer").hide();
                                    this.cdClosePanel.parent(".cdContainer").hide()
                                }
                            }
                        }
                    }
                    var b = g.status;
                    if ((c <= this.refreshFlag && b < 1) || (f <= this.refreshFlag && b < 2)) {
                        this.reloadDataDelay()
                    } else {
                        if (a <= 0) {
                            this.reloadDataDelay(10000)
                        }
                    }
                }
            },
            loadResult: function () {
                var a = this;
                LIBS.ajax({
                    url: "lastResult", data: {lottery: lottery, table: tableId}, success: function (c) {
                        if (c) {
                            a.showResult(c);
                            var d = a.period;
                            var b = c.drawNumber;
                            if (d && b != d.drawNumber && b != d.pnumber) {
                                clearTimeout(a.resultTimer);
                                a.resultTimer = setTimeout(function () {
                                    a.loadResult()
                                }, a.resultInterval)
                            }
                        }
                    }
                })
            },
            showResult: function (a) {
                var o = this.lastResult;
                if (o == null || o.drawNumber != a.drawNumber || o.result != a.result) {
                    this.loadAccounts();
                    if ($.isFunction(this.onResultChange)) {
                        this.onResultChange(a)
                    }
                }
                this.lastResult = a;
                if (this.drawPanel) {
                    this.drawPanel.find(".draw_number").html(a.drawNumber + "<span>期开奖</span>");
                    var b = this.drawPanel.find(".balls");
                    b.empty();
                    var g = a.result.split(",");
                    var f;
                    if (template == "HK6") {
                        f = get_animal_by_ball
                    } else {
                        if (template == "3D") {
                            f = function (p, r) {
                                return ["佰", "拾", "个"][r]
                            }
                        }
                    }
                    for (var h = 0; h < g.length; h++) {
                        var e = g[h];
                        if (template == "FT") {
                            e = "0" + e
                        }
                        var d = $("<li>").appendTo(b);
                        d.append($("<b>").addClass("b" + e).text(e));
                        if (f) {
                            d.append($("<i>").text(f(e, h)))
                        }
                        if (template == "HK6") {
                            if (h == 5) {
                                $("<li>").addClass("plus").text("+").appendTo(b)
                            }
                        }
                    }
                } else {
                    if (parent && parent.showResult) {
                        parent.showResult(a)
                    }
                }
                var n = this.changlong;
                if (!this.changlong) {
                    return
                }
                n.empty();
                if (lottery == "PK10JSCNN") {
                    this.generateChangLongJSNN(a, n)
                } else {
                    if (a.detail && n.length) {
                        var u = a.detail.split(";");
                        var j = [];
                        for (var h = 0; h < u.length; h++) {
                            var s = u[h];
                            if (!s) {
                                continue
                            }
                            var k = s.split(",");
                            if (k[0].startsWith("YX") || k[0].startsWith("WS") || k[0].startsWith("ZX") || k[0].startsWith("DNSH") || k[0] == "DNDX=LOSE" || k[0] == "DNDS=LOSE") {
                                continue
                            }
                            if (/\d$/.test(k[0])) {
                                continue
                            }
                            j.push([k[1], this.titleConverter ? this.titleConverter(k[2]) : k[2], k[0].replace("=", "_")])
                        }
                        j.sort(function (p, i) {
                            var r = i[0] - p[0];
                            if (r != 0) {
                                return r
                            }
                            return p[1].localeCompare(i[1])
                        });

                        function m(r) {
                            if (pageMap) {
                                var p = pageMap[template];
                                if (!p) {
                                    return
                                }
                                for (var i in p) {
                                    if (i == "") {
                                        continue
                                    }
                                    if (r.indexOf(i) === 0) {
                                        return p[i]
                                    }
                                }
                                return p[""]
                            }
                        }

                        var q = this;
                        for (var h = 0; h < j.length; h++) {
                            var k = j[h];
                            var l = m(k[1]);
                            var c = $("<th>");
                            if (l) {
                                $("<a>").text(k[1]).attr("href", "load?lottery=" + lottery + "&page=" + l + "#" + k[2]).click(function () {
                                    if (q.onChangLongClick) {
                                        var p = $(this).attr("href");
                                        var i = p.lastIndexOf("#");
                                        return q.onChangLongClick(p.substr(i + 1), p.substr(0, i))
                                    }
                                }).appendTo(c)
                            } else {
                                c.text(k[1])
                            }
                            $("<tr>").append(c).append($("<td>").text(k[0] + " 期")).appendTo(n)
                        }
                    }
                }
            },
            generateChangLongJSNN: function (f, b) {
                if (f.freqResult && b.length) {
                    for (var d = 0; d < f.freqResult.length; d++) {
                        var a = f.freqResult[d];
                        for (var c in a) {
                            if (a.hasOwnProperty(c)) {
                                var e = $("<th>");
                                e.text(mapping[c]);
                                $("<tr>").append(e).append($("<td>").text(a[c] + " 期")).appendTo(b)
                            }
                        }
                    }
                }
            },
            loadAccounts: function () {
                var a = this;
                clearTimeout(this.accountTimer);
                LIBS.ajax({
                    url: "accounts", success: function (b) {
                        if ($.isArray(b) && b.length > 0) {
                            a.showAccount(b)
                        }
                    }
                });
                this.accountTimer = setTimeout(function () {
                    a.loadAccounts()
                }, this.accountInterval)
            },
            showAccount: function (c) {
                var a = 0;
                for (var b = 0; b < c.length; b++) {
                    a += Number(c[b].result || 0)
                }
                $("#bresult").text(LIBS.round(a, 1));
                if ($.isFunction(this.onAccountUpdated)) {
                    this.onAccountUpdated(c)
                }
            }
        }
    })();
    if (typeof window.IS_MOBILE != "undefined") {
        PeriodPanel.showPeriod = (function () {
            var g = this.period;
            this.cdOpenPanel = $(".openPanel");
            this.cdClosePanel = $(".closePanel");
            if (!g) {
                if (this.drawNumberPanel) {
                    this.drawNumberPanel.text("")
                }
                showTime(this.cdOpen, 0);
                showTime(this.cdClose, 0);
                showTime(this.cdDraw, 0)
            } else {
                if (this.drawNumberPanel) {
                    var d = g.drawNumber;
                    if (this.drawNumberText) {
                        d = this.drawNumberText.format(d)
                    }
                    this.drawNumberPanel.text(d)
                }
                var e = this.now();
                var c = g.openTime - e;
                var f = g.closeTime - e;
                var a = g.drawTime - e;
                showTime(this.cdOpen, c);
                showTime(this.cdClose, f);
                showTime(this.cdDraw, a);
                if (LIBS.timeToString(f) == "00:00") {
                    this.cdOpenPanel.hide();
                    this.cdClosePanel.show()
                } else {
                    this.cdOpenPanel.show();
                    this.cdClosePanel.hide()
                }
                var b = g.status;
                if ((c <= this.refreshFlag && b < 1) || (f <= this.refreshFlag && b < 2) || (a <= this.refreshFlag)) {
                    this.reload()
                }
            }
        });
        PeriodPanel.showRefreshRemain = (function (b) {
            if (b === undefined) {
                b = this.refreshRemain
            }
            if (b >= 0) {
                if ($.isFunction(this.countdownText)) {
                    this.countdownText(b);
                    return
                } else {
                    if (this.countdownPanel) {
                        if (b == 0) {
                            this.countdownPanel.html("<span>载入</span>")
                        } else {
                            var a = b;
                            if (this.countdownText) {
                                a = this.countdownText.format(a)
                            }
                            this.countdownPanel.text(a)
                        }
                    }
                }
            }
        })
    }
}
;
