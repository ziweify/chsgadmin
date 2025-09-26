var lottery;
var template;
var gameName;
var games = "";
var tableId = 0;
var MULTIPLE;
var lastBet;
var mgame;
var ResultPanel;
var RANGES;
var QUICKS;
var backGame;
var backRisk;
var backTotal;
var oldOdds;
var TOTALS = {
    HK6: {
        "特码": ["TM", "tm"],
        "两面": ["LM", "lm"],
        "色波": ["SB", "sb"],
        "正码": ["ZM", "zm"],
        "正码1-6": ["ZM16", "zm16"],
        "正码过关": ["ZMGG", "zmgg"],
        "正码特": ["ZMT1,ZMT2,ZMT3,ZMT4,ZMT5,ZMT6", "zmt&index=1"],
        "生肖、正肖、总肖": ["SX,ZX,2ZSX,3ZSX,4ZSX,5ZSX,6ZSX,7ZSX", "sx"],
        "特头尾数": ["TWS", "tws"],
        "七码五行": ["7M,WX", "7m5h"],
        "一肖尾数": ["YXWS", "yxws"],
        "合肖": ["HX,HXBZ", "hx"],
        "连肖": ["LX", "lx"],
        "连肖不中": ["LXBZ", "lxbz"],
        "连尾": ["LW", "lw"],
        "连尾不中": ["LWBZ", "lwbz"],
        "连码": ["MP", "mp"],
        "自选不中": ["ZXBZ", "zxbz"],
        "中一": ["5Z1,6Z1,7Z1,8Z1,9Z1,10Z1", "z1"]
    },
    PK10: {
        "冠、亚军组合": ["GYH,GDX,GDS,B1,DX1,DS1,LH1,B2,DX2,DS2,LH2", "12"],
        "三、四、五、六名": ["B3,DX3,DS3,LH3,B4,DX4,DS4,LH4,B5,DX5,DS5,LH5,B6,DX6,DS6,LH6", "3456"],
        "七、八、九、十名": ["B7,DX7,DS7,B8,DX8,DS8,B9,DX9,DS9,B10,DX10,DS10", "78910"]
    },
    SSC: {
        "两面": ["LM", "lm"],
        "单号": ["B1,B2,B3,B4,B5", "dh"],
        "前中后三": ["TS", "ts"],
        "一字": ["1Z", "1z"],
        "二字": ["2Z", "2z"],
        "三字": ["3Z", "3z"],
        "二字定": ["2DW", "dw2"],
        "三字定": ["3DW", "dw3"],
        "二字和数": ["2HS", "2zhs"],
        "三字和数": ["3HS", "3zhs"],
        "组选三": ["ZX3", "zx3"],
        "组选六": ["ZX6", "zx6"],
        "复式组合": ["FS", "fs"],
        "跨度": ["KD", "kd"],
        "斗牛": ["DN", "dn"],
    },
    KLSF: {
        "第一球": ["B1,DX1,DS1,WDX1,HDS1,FW1,ZFB1,LH1", "ball&index=1"],
        "第二球": ["B2,DX2,DS2,WDX2,HDS2,FW2,ZFB2,LH2", "ball&index=2"],
        "第三球": ["B3,DX3,DS3,WDX3,HDS3,FW3,ZFB3,LH3", "ball&index=3"],
        "第四球": ["B4,DX4,DS4,WDX4,HDS4,FW4,ZFB4,LH4", "ball&index=4"],
        "第五球": ["B5,DX5,DS5,WDX5,HDS5,FW5,ZFB5,LH5", "ball&index=5"],
        "第六球": ["B6,DX6,DS6,WDX6,HDS6,FW6,ZFB6,LH6", "ball&index=6"],
        "第七球": ["B7,DX7,DS7,WDX7,HDS7,FW7,ZFB7,LH7", "ball&index=7"],
        "第八球": ["B8,DX8,DS8,WDX8,HDS8,FW8,ZFB8,LH8", "ball&index=8"],
        "总和、正码": ["ZDX,ZDS,ZWDX,ZM", "zh"],
        "连码": ["LM2,LM22,LM3,LM32,LM4,LM5", "mp"]
    },
    KL8: {
        "总项盘口": ["DSH,DXDS,QHH,WX,ZDS,ZDX,ZHT", "all"],
        "正码": ["ZM", "ball"]
    },
    "3D": {
        "两面": ["LM", "lm"],
        "一字": ["1Z", "1z"],
        "二字": ["2Z", "2z"],
        "三字": ["3Z", "3z"],
        "一字定位": ["1DW", "dw1"],
        "二字、三字定位": ["2DW,3DW", "dw23"],
        "二字和数": ["2HS", "2zhs"],
        "三字和数、跨度": ["3HS,KD", "3zhskd"],
        "组选三": ["ZX3", "zx3"],
        "组选六": ["ZX6", "zx6"],
        "复式组合": ["FS", "fs"],
        "一字过关": ["1ZGG", "1zg"]
    },
    GXKLSF: {
        "两面": ["YLM", "lm"],
        "正码": ["B1,B2,B3,B4,B5,SB1,SB2,SB3,SB4,SB5,YFLSX1,YFLSX2,YFLSX3,YFLSX4,YFLSX5", "15ball"]
    },
    "11X5": {
        "两面": ["DX1,DS1,DX2,DS2,DX3,DS3,DX4,DS4,DX5,DS5,ZDX,ZDS,ZWDX,LH", "lm"],
        "单号": ["B1,B2,B3,B4,B5,ZM", "dh"],
        "连码、直选": ["LM2,LM3,LM30,LM32,LM4,LM5,LM6,LM7,LM8,Q2ZX,Q3ZX", "mp"]
    },
    PK10JSCNN: {
        "翻倍": ["FB", "fb"],
        "平倍": ["PB", "pb"]
    }
};
$(function () {
    if (parent && parent != window) {
        var c = LIBS.getUrlParam("page");
        var l = LIBS.getUrlParam("index");
        tableId = LIBS.getUrlParam("tableId");
        parent.$("#" + lottery + " a").removeClass("selected").each(function () {
            var v = $(this);
            var k = v.attr("href");
            var x = LIBS.getUrlParam("page", k);
            var s = LIBS.getUrlParam("index", k);
            var w = LIBS.getUrlParam("tableId", k);
            if (x == c && (!s || s == l) && (!w || w == tableId)) {
                v.addClass("selected");
                return false
            }
        })
    }
    var q = function () {
        var w = {
            "0": function (A, z) {
                return Number(A[1]) - Number(z[1])
            }, "1": function (A, z) {
                var B = Number(A[2].split(",").join("")) - Number(z[2].split(",").join(""));
                if (B == 0 || isNaN(B)) {
                    return Number(A[1]) - Number(z[1])
                }
                return B
            }, "2": function (A, z) {
                return Number(A[2]) - Number(z[2])
            }
        };
        var v = w[$("#sortMode").val()];
        $("tbody.sortable").each(function () {
            var z = $(this);
            var A = [];
            z.children().each(function () {
                var B = $(this).children();
                A.push([this, B.eq(0).text(), B.eq(3).text(), B.eq(2).text()])
            });
            A.sort(v);
            z.append($.map(A, function (B) {
                return B[0]
            }))
        });
        var s = $("tbody.sortgroup");
        if (s.length > 0) {
            var y = [];
            s.each(function () {
                var z = $(this);
                z.data("c", z.children().each(function () {
                    var A = $(this).children();
                    y.push([this, A.eq(0).text(), A.eq(3).text()])
                }).length)
            });
            y.sort(v);
            y = $.map(y, function (z) {
                return z[0]
            });
            s.each(function () {
                var z = $(this);
                z.append(y.splice(0, z.data("c")))
            })
        }
        var x = $("tbody.sortgroup-PL5-0");
        if (x.length > 0) {
            var y = [];
            x.each(function () {
                var z = $(this);
                z.data("c", z.children().each(function () {
                    var A = $(this).children();
                    y.push([this, A.eq(0).text(), A.eq(3).text()])
                }).length)
            });
            y.sort(v);
            y = $.map(y, function (z) {
                return z[0]
            });
            x.each(function () {
                var z = $(this);
                z.append(y.splice(0, z.data("c")))
            })
        }
        var k = $("tbody.sortgroup-PL5-1");
        if (k.length > 0) {
            var y = [];
            k.each(function () {
                var z = $(this);
                z.data("c", z.children().each(function () {
                    var A = $(this).children();
                    y.push([this, A.eq(0).text(), A.eq(3).text()])
                }).length)
            });
            y.sort(v);
            y = $.map(y, function (z) {
                return z[0]
            });
            k.each(function () {
                var z = $(this);
                z.append(y.splice(0, z.data("c")))
            })
        }
        var i = $("tbody.sortgroup-PL5-2");
        if (i.length > 0) {
            var y = [];
            i.each(function () {
                var z = $(this);
                z.data("c", z.children().each(function () {
                    var A = $(this).children();
                    y.push([this, A.eq(0).text(), A.eq(3).text()])
                }).length)
            });
            y.sort(v);
            y = $.map(y, function (z) {
                return z[0]
            });
            i.each(function () {
                var z = $(this);
                z.append(y.splice(0, z.data("c")))
            })
        }
    };
    var a = {
        periodShowType: 1,
        drawNumberText: "{0}期",
        changlong: $("#changlong table tbody"),
        onPeriodChange: function (k, i) {
            toggleStatus(k && k.status == 1);
            if (k) {
                $("td.amount a").each(function () {
                    var s = $(this);
                    var w = s.attr("id").split("_");
                    if (MULTIPLE) {
                        s.attr("href", "bets?lottery={0}&number={1}&game={2}&state={3}".format(lottery, k.drawNumber, w[1], w[2]))
                    } else {
                        var v = s.attr("gkey") || "game";
                        s.attr("href", ("bets?lottery={0}&number={1}&" + v + "={2}&item={3}").format(lottery, k.drawNumber, w[1], w[2]))
                    }
                })
            }
            backClose();
            if (i != null && k && i.drawNumber != k.drawNumber && MULTIPLE) {
                $("#details").dialog("close")
            }
        }, onResultChange: function () {
            if (ResultPanel) {
                ResultPanel.load()
            }
        }, loadOptions: function () {
            return {
                url: "control/risk",
                data: {
                    lottery: lottery,
                    games: games,
                    tableId: tableId,
                    all: $("#amountMode").val(),
                    username: $("#username").val(),
                    range: $("#range").val(),
                    multiple: !!MULTIPLE
                },
                success: function (i) {
					//i=eval('('+i+')');
                    showRisk(i);
                    if (MULTIPLE) {
                        loadMultiple()
                    }
                    if (q) {
                        q()
                    }
                }
            }
        }
    };
    $.each(["cdOpen", "cdClose", "cdDraw"], function (s, k) {
        a[k + "Panel"] = $("#" + k)
    });
    var d = $("#range");
    if (RANGES) {
        for (var n in RANGES) {
            var h = $("<optgroup>").attr("label", RANGES[n]).appendTo(d);
            $("A,B,C,D".split(",")).each(function (k, s) {
                h.append($("<option>").text(s + "盘").val(s + "-" + n))
            })
        }
    } else {
        $("A,B,C,D".split(",")).each(function (k, s) {
            d.append($("<option>").text(s + "盘").val(s))
        })
    } if (parent && parent != window) {
        $('.top_info select[id!=""],#oddsStep').change(function () {
            var i = $(this);
            parent["control_" + i.attr("id")] = i.val()
        }).each(function () {
            var i = $(this);
            var k = parent["control_" + i.attr("id")];
            if (k) {
                i.find('option[value="' + k + '"]').prop("selected", true)
            }
        })
    }
    $("#range,#amountMode,#username").change(function () {
        window.periodUser = $("#username").val();
        PeriodPanel.reloadData();
        PeriodPanel.reload(true)
    });
    $("#btnRefresh").click(function () {
        PeriodPanel.reload(true)
    });
    if ($("tbody.sortgroup-PL5-0").length > 0) {
        $("#sortMode").change(q)
    } else {
        if ($("tbody.sortable,tbody.sortgroup").length == 0) {
            $("#sortMode").hide();
            q = 0
        } else {
            $("#sortMode").change(q)
        }
    }
    $("td.amount a").click(function () {
        return !!PeriodPanel.period
    });
    if (varCanBack) {
        $("td.risk a").click(function () {
            showBack($(this))
        })
    }
    initBetback();
    if ($("#oddsSetting").length == 1) {
        $("#main span.odds").each(function () {
            var i = $(this);
            var k = $(this).parent();
            var s = i.attr("id").substr(2);
            $([$("<div>"), $("<div>")]).each(function (v) {
                $(this).addClass("oddsCtl oc" + v).appendTo(k).data("type", v * 2 * -1 + 1).data("id", s).click(function () {
                    var w = $(this);
                    addOdds([w.data("id")], w.data("type"))
                })
            })
        });
        $("#main .data_table tbody tr td:has(span.odds)").click(function (i) {
            if (i.target != this) {
                return
            }
            $(this).toggleClass("selected")
        });
        $("#oddsSetting .oc0").click(function () {
            quickSetOdds(1)
        });
        $("#oddsSetting .oc1").click(function () {
            quickSetOdds(-1)
        });
        $("#inputodds .edit").click(function () {
            quickSetOdds(0)
        });
        if (QUICKS) {
            var f = $("#oddsSetting");
            var m = __BALLS.getQuick();
            for (var o = 0; o < m.length; o++) {
                var j = m[o];
                var p = $("<div>").addClass("buttons").appendTo(f);
                for (var u in j) {
                    var n = j[u].split("|");
                    $("<a>").text(u).appendTo(p).click(function () {
                        var i = $(this).data("k").split("_");
                        var s = __BALLS.getBalls(i[0], i[1]);
                        if (!s) {
                            alert("参数错误")
                        }
                        $("tr.ball").filter(".ball" + s.split(",").join(",.ball")).children(":has(span.odds)").toggleClass("selected", true)
                    }).data("k", n[0]).addClass(n[1])
                }
            }
        }
    }
    TOTALS = TOTALS[template];
    if (TOTALS) {
        var t = [];
        var r = $("<table>").addClass("list data_table").appendTo($("#totals"));
        var b = $("<tr>").appendTo($("<thead>").appendTo(r));
        r = $("<tr>").appendTo($("<tbody>").appendTo(r));
        for (var n in TOTALS) {
            var e = TOTALS[n];
            $("<th>").text(n).appendTo(b);
            var g = $("<a>").text("0").appendTo($("<td>").appendTo(r));
            if (e[1]) {
                g.attr("href", "load?lottery=" + lottery + "&page=" + e[1])
            }
            t.push([e[0].split(","), g])
        }
        TOTALS = t
    } else {
        TOTALS = []
    }
    $(".total[data-keys]").each(function () {
        var i = $(this);
        if (!i.data("keys")) {
            alert(i.parent().html());
            return
        }
        TOTALS.push([i.data("keys").split(","), i])
    });
    TOTALS = $(TOTALS);
    PeriodPanel.init(a, gameName);
    $("#backPanel").find("input:text").keypress(function (i) {
        if (i.which == 13) {
            doBet()
        }
    })
});

function addOdds(b, a) {
    if (!PeriodPanel.period) {
        return
    }
    var c = $("#oddsStep").val();
    if (a != 0) {
        c *= a
    }
    $.ajax({
        url: "odds/set",
        loading: true,
        method: "POST",
        data: {
            username: $("#username").val(),
            lottery: lottery,
            type: a,
            items: JSON.stringify(b),
            value: c,
            drawNumber: $("#drawNumber").html().slice(0, -1)
        },
        success: function (d) {
			d=eval('('+d+')');
            if (!d || !d.success) {
                if (d.message) {
                    alert(d.message)
                } else {
                    alert("设置赔率错误，请重试。")
                }
            } else {
                PeriodPanel.reloadData()
            }
        }
    })
}

function addInputOdds(a) {
    if (!PeriodPanel.period) {
        return
    }
    var b = $("#oddsInput").val();
    if (b <= 0 || b == "undefined" || b == "") {
        alert("您输入的赔率错误，请重试。");
        return
    }
    $.ajax({
        url: "odds/inputset",
        loading: true,
        method: "POST",
        data: {
            username: $("#username").val(),
            lottery: lottery,
            items: JSON.stringify(a),
            value: b,
            range: $("#range").val(),
            drawNumber: $("#drawNumber").html().slice(0, -1)
        },
        success: function (c) {
			c=eval('('+c+')');
            if (!c || !c.success) {
                if (c.message) {
                    alert(c.message)
                } else {
                    alert("设置赔率错误，请重试。")
                }
            } else {
                PeriodPanel.reloadData()
            }
        }
    })
}

function quickSetOdds(b) {
    var c = $("#main .data_table tbody tr td.selected");
    if (c.length > 0) {
        var a = [];
        c.each(function () {
            var d = $(this).find("span.odds");
            d.each(function () {
                var e = $(this).attr("id").substr(2);
                a.push(e)
            })
        });
        if (b == 0) {
            addInputOdds(a)
        } else {
            addOdds(a, b)
        }
    } else {
        alert("请选择您要操作种类赔率！")
    }
}

function toggleAll(a) {
    $("#main .data_table tbody tr td:has(span.odds)").each(function (b) {
        $(this).toggleClass("selected", a)
    })
}

function toggleStatus(a) {
    if (a) {
        $("#main").removeClass("period_close")
    } else {
        $("#main").addClass("period_close")
    }
}

function formatAmount(a) {
    if (isNaN(a) || a == null) {
        return "0"
    }
    return LIBS.round(a, 1)
}

function showRisk(b) {
    var C = PeriodPanel.period;
    if (!b && C && C.status == 1) {
        PeriodPanel.reloadDataDelay()
    }
    if (!$.isArray(b)) {
        return
    }
    var G = b[0];
    var n = LIBS.clone({}, b[1]);
    var K = {};
    var m = {};
    if (lottery == "PK10JSCNN") {
        var D = games.split(",");
        for (var B = 0; B < G.length; B++) {
            var v = G[B];
            for (var A = 1; A <= 4; A++) {
                var J = D[0] + "_" + v.i + "_" + A;
                if (n[J] === undefined) {
                    v.r = 0
                } else {
                    v.r = -v.a * (n[J].a - 1)
                }
                var y = [J, n[J], v.a, v.r, v.c];
                n[J] = y
            }
        }
    } else {
        for (var B = 0; B < G.length; B++) {
            var v = G[B];
            K[v.k] = (K[v.k] || 0) + (v.a || 0);
            m[v.k] = (m[v.k] || 0) + (v.cm || 0)
        }
        if (backGame) {
            backRisk = {};
            backTotal = [K[backGame], m[backGame]]
        }
        for (var B = 0; B < G.length; B++) {
            var v = G[B];
            var p = v.i.indexOf("@");
            if (p > -1) {
                v.i = v.i.substring(0, p)
            }
            var J = v.k + "_" + v.i;
            if (K[v.k]) {
                v.r = K[v.k] - (v.r || 0) - m[v.k]
            }
            var y = [J, n[J], v.a, v.r, v.c];
            n[J] = y;
            if (v.k == backGame) {
                backRisk[v.i] = y
            }
        }
    }
    for (var z in n) {
        var y = n[z];
        var J = z.split("_");
        if (!$.isArray(y)) {
            if (K[J[0]] && !MULTIPLE) {
                var f = n[J[0] + "_" + J[1]];
                var v = 0;
                if (J.length == 3 && $.isArray(f)) {
                    v = f[2] * y
                }
                y = [z, y, null, K[J[0]] - v - m[J[0]]]
            } else {
                y = [z, y]
            }
        }
        var a = y[1];
        var q;
        if ((typeof a === "object") && (a !== null)) {
            var g = 0,
                x = 0;
            for (oddKey in a) {
                if (oddKey == "showFlag") {
                    g = a[oddKey]
                } else {
                    if (oddKey == "total") {
                        x = a[oddKey]
                    } else {
                        q = a[oddKey]
                    }
                }
            }
            if (g && x && x >= g) {
                $("#o_" + z).addClass("oddsFlagged")
            } else {
                $("#o_" + z).removeClass("oddsFlagged")
            }
        } else {
            q = a
        }
        var H = $("#o_" + z).text(q);
        if (J.length == 2 || J.length == 3) {
            if (J[0].substring(2) == "GG") {
                var F = J[1].split(",");
                for (var e in F) {
                    var I = $("#a_" + getGgGameByItem(F[e]));
                    var u = parseInt(I.text()) + parseInt(y[2]);
                    I.text(formatAmount(u))
                }
            } else {
                $("#a_" + z).text(formatAmount(y[2]));
                if (MULTIPLE) {
                    $("#c_" + z).text(formatAmount(y[4]))
                }
            }
        }
        if (!MULTIPLE) {
            $("#r_" + z).data("item", y).text(formatAmount(y[3])).toggleClass("high", (y[3] || 0) < 0)
        }
    }
    oldOdds = b[1];
    K = b[2];
    var s = 0;
    TOTALS.each(function () {
        var o = this[0];
        var j = 0;
        for (var k = 0; k < o.length; k++) {
            j += K[o[k]] || 0
        }
        this[1].text(Math.round(j));
        s += j
    });
    $("#TOTAL").text(Math.round(s));
    $(".summaryData").text("-");
    if (b.length > 3) {
        var l = b[3];
        var B = 0;
        var w = "";
        for (dataIndex in l) {
            var E = l[dataIndex];
            var c = E.gkey;
            if (w.length == 0 || c != w) {
                w = c;
                B = 0
            }
            if (B > 9) {
                continue
            }
            var d = E.detail;
            var h = E.amount;
            $("#" + c + "_combination_" + B).text(d);
            $("#" + c + "_amount_" + B).text(formatAmount(h));
            B++
        }
    }
}

function getGgGameByItem(c) {
    var b = c.length;
    if (b == 2) {
        if (template == "HK6") {
            return "GGSB" + c.substring(0, 1) + "_" + c.substring(1)
        } else {
            return "GGZIH" + c.substring(0, 1) + "_" + c.substring(1)
        }
    } else {
        var a = "GG";
        var d = c.substring(1, b - 1);
        a = a + (d == "W" ? "WDX" : d) + c.substring(0, 1) + "_" + c.substring(b - 1);
        return a
    }
}

function loadMultiple() {
    if (!mgame) {
        return
    }
    $.get("control/mbets", {
        lottery: lottery,
        game: mgame,
        range: $("#range").val()
    }, function (g) {
        if (!g) {
            return
        }
        var a = $("#details tbody");
        a.empty();
        var c = mgame.split("_");
        for (var b = 0; b < g.length; b++) {
            var e = g[b];
            var d = [c[0] + "_" + e.item + "_" + c[1], null, e.amount, null, null, e.text];
            var f = $("<tr>").appendTo(a);
            f.append($("<td>").text(e.text.split(",").join("、")));
            f.append($("<td>").addClass("contents").text(LIBS.round(e.amount, 1)));
            f.append($("<td>").addClass("cm").text(LIBS.round(e.cm, 1)));
            f.append($("<td>").addClass("risk").text(LIBS.round(e.risk, 1)));
            f.append($("<td>").addClass("op").append($("<input>").attr("type", "button").val("补货").click(showMultiBack).data("item", d)))
        }
    });
    sortTable($("#sort-table"), "asc")
}

function sortTable(d, a) {
    var c = a === "asc",
        b = d.find("tbody");
    b.find("tr").sort(function (f, e) {
        if (c) {
            return $(".risk", f).text().localeCompare($(".risk", e).text())
        } else {
            return $(".risk", e).text().localeCompare($(".risk", f).text())
        }
    }).appendTo(b)
}

function showMultiple(b) {
    if (mgame || !PeriodPanel.period || PeriodPanel.period.status != 1) {
        return
    }
    var a = $("#details");
    if (a.length == 0) {
        a = $('<div id="details"><table class="list data_table" id = "sort-table"><thead><tr><th id="detailName" colspan="5"></th></tr><tr class="shead"><th>内容</th><th>金额</th><th>退水</th><th>派彩</th><th>操作</th></tr></thead><tbody></tbody></thead>');
        a.appendTo("body").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            height: 400,
            close: function () {
                mgame = null;
                backClose();
                PeriodPanel.reloadData()
            }
        })
    }
    mgame = b;
    $("#detailName").text($("#t_" + b).text());
    a.find("tbody").empty().append('<tr><th colspan="5">载入中…</th></tr>');
    loadMultiple();
    a.dialog("open")
}

function bet(a, b) {
    lastBet = $.ajax({
        url: "bet",
        type: "POST",
        loading: true,
        contentType: "application/json",
        data: JSON.stringify({
            lottery: lottery,
            drawNumber: PeriodPanel.period.drawNumber,
            ignore: true,
            bets: a
        }),
        success: function (c) {
			c=eval('('+c+')');
            if (c.status == 0) {
                alert("补货成功")
            } else {
                if (c.status == 2) {
                    alert("补货失败：已封盘")
                } else {
                    alert("补货失败：" + c.message)
                }
            }
            lastBet = null;
            PeriodPanel.reloadData();
            if ($.isFunction(b)) {
                b(c)
            }
        }
    })
}

function showMultiBack() {
    showBackPanel($(this), function (a) {
        var b = a[0].split("_");
        a[1] = $("#o_" + b[0] + "_" + b[2]).text();
        return a[5].split(",").join("、")
    })
}

function showBack(b) {
    showBackPanel(b, function (a) {
        return $("#n_" + a[0]).text()
    })
}

function showBackPanel(d, f) {
    var h = PeriodPanel.period;
    var e = d.data("item");
    if (e == null || !h || h.status != 1) {
        return
    }
    var c = Math.floor(e[2]);
    if (isNaN(c) || c <= 0) {
        return
    }
    var b = $("#backPanel");
    var g = d.offset();
    b.css({
        "z-index": 9999,
        top: g.top + 20,
        left: g.left - b.width() / 2
    });
    b.find(".text").text(f(e));
    b.find(".odds").text(e[1].a);
    b.find(".limit").text(c);
    b.data("item", e).show();
    b.find(".input").val("").focus();
    b.find("input:button").prop("disabled", false)
}

function doBet() {
    var g = PeriodPanel.period;
    var e = $("#backPanel").data("item");
    if (!g || g.status != 1 || !e || lastBet) {
        return
    }
    var d = Number($("#backPanel .input").val());
    if (isNaN(d) || d <= 0) {
        alert("金额不正确");
        return
    }
    if (d < 5) {
        alert("最低5元");
        return
    }
    $("#backPanel").find("input:button").prop("disabled", true);
    var f = e[0].split("_");
    var c = $("#range").val();
    if (games) {
        var a = games.indexOf("*");
        if (a >= 0 && f[0] == games.substr(0, a)) {
            if (c) {
                c = c.split("-");
                f[0] = c[1];
                c = c[0]
            } else {
                f[0] = games.substring(a + 1, games.indexOf(",", a))
            }
        }
    }
    var b = [{
        game: f[0],
        state: f[2],
        contents: f[1],
        amount: d,
        odds: e[1].a,
        range: c
    }];
    bet(b, backClose)
}

function backClose() {
    $("#backPanel").hide()
}

function initBetback() {
    if (backGame) {
        $("#backControl input:button").click(function () {
            var e = Math.abs(Number($("#backControl input:text").val()));
            if (isNaN(e)) {
                alert("请输入计算值");
                return
            }
            var h = $("#backControl input:radio:checked").val();
            var a = $("#quickBetbackPopPanel");
            if (a.length == 0) {
                a = $('<div id="quickBetbackPopPanel">').appendTo("body");
                var l = $("<table>").addClass("data_table").appendTo(a);
                $("<tr><th>号码</th><th>金额</th><th>赔率</th><th>风险</th><th>补货金额</th></tr>").appendTo($("<thead>").appendTo(l));
                $("<tbody>").appendTo(l);
                a.dialog({
                    autoOpen: false,
                    width: 600,
                    maxHeight: 400,
                    buttons: {
                        "确认": function () {
                            var i = [];
                            $(this).find("input.input").each(function () {
                                var p = $(this);
                                var n = Number(p.val());
                                if (isNaN(n) || n <= 0) {
                                    return
                                }
                                var q = p.closest("tr").children();
                                var r = [backGame, q.eq(0).text()];
                                var o = $("#range").val();
                                if (games) {
                                    var j = games.indexOf("*");
                                    if (j >= 0 && r[0] == games.substr(0, j)) {
                                        if (o) {
                                            o = o.split("-");
                                            r[0] = o[1];
                                            o = o[0]
                                        } else {
                                            r[0] = games.substring(j + 1, games.indexOf(",", j))
                                        }
                                    }
                                }
                                i.push({
                                    game: r[0],
                                    contents: r[1],
                                    amount: n,
                                    odds: q.eq(2).text(),
                                    range: o
                                })
                            });
                            if (i.length == 0) {
                                $(this).dialog("close");
                                return
                            }
                            bet(i, function () {
                                a.dialog("close")
                            })
                        }, "取消": function () {
                            $(this).dialog("close")
                        }
                    }
                })
            }
            var d = a.find("tbody").empty();
            var f = calcBetback(e, h);
            for (var c = 0; c < f.length; c++) {
                var m = f[c];
                var g = $("<tr>").appendTo(d);
                var k = $("<input>").addClass("input").val(m.shift());
                for (var b = 0; b < m.length; b++) {
                    $("<td>").text(b > 0 ? formatAmount(m[b]) : m[b]).appendTo(g)
                }
                $("<td>").append(k).appendTo(g)
            }
            a.dialog("open")
        })
    } else {
        $("#backControl").hide()
    }
}

function calcBetback(e, f) {
    var c = [
        function (a) {
            return [0 - a[3] - Math.abs(e)] / a[1]
        },
        function (a) {
            return a[2] - e
        }
    ][f];
    var h = [];
    for (var d in backRisk) {
        var g = backRisk[d];
        var b = Math.floor(c(g));
        if (isNaN(b) || b <= 0) {
            continue
        }
        h.push([b, d, g[2], g[1], g[3]])
    }
    h.sort(function (j, i) {
        return i[0] - j[0]
    });
    return h
}

function startTime() {
    var f = new Date();
    var i = f.getTime() + (f.getTimezoneOffset() * 60000);
    var k = new Date(i + (3600000 * 8));
    var g = k.getFullYear();
    var c = k.getMonth() + 1;
    var e = k.getDate();
    var b = k.getHours();
    var a = k.getMinutes();
    var l = k.getSeconds();
    c = checkTime(c);
    e = checkTime(e);
    b = checkTime(b);
    a = checkTime(a);
    l = checkTime(l);
    if (document.getElementById("dateTime")) {
        document.getElementById("dateTime").innerHTML = g + "-" + c + "-" + e + " " + b + ":" + a + ":" + l
    }
    var j = setTimeout(startTime, 500)
}

function checkTime(a) {
    if (a < 10) {
        a = "0" + a
    }
    return a
};
