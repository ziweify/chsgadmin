$(function() {
    var k = {};
    var g = {};
    function l(n, m) {
        n.data("init", n.attr("value")).change(function() {
            var s = $(this);
            var o = s.val();
            var r = s.closest("tr").find("input[name=" + m + "]");
            var q = r.data("init");
            var u = r.val();
            if (o !== s.data("init") || u !== q) {
                if (o !== "") {
                    s.closest("tr").toggleClass("changed", true);
                    var w = s.closest("tr").find("input[name=password]");
                    w.attr("placeholder", "请输入密码")
                } else {
                    s.closest("tr").toggleClass("changed", false);
                    var w = s.closest("tr").find("input[name=password]");
                    w.attr("placeholder", "")
                }
            } else {
                s.closest("tr").toggleClass("changed", false);
                var w = s.closest("tr").find("input[name=password]");
                w.attr("placeholder", "不修改请留空")
            }
        })
    }
    $(".contents table#planDetails.data_table tbody tr.detail").each(function() {
        var m = $(this);
        m.find("input[name=username]").each(function() {
            l($(this), "safeCode")
        });
        m.find("input[name=safeCode]").each(function() {
            l($(this), "username")
        })
    });
    $(".integer").keypress(function(m) {
        if ((m.which < 48 && m.which != 8) || m.which > 57) {
            return (false)
        }
    });
    $("#btnRefresh").click(function() {
        Panel.reload(true)
    });
    $("#btnSearch").click(function() {
        var m = $("input[name=source]:checked");
        var n = $("input[name=source]:not(:checked)");
        var p = $("#searchLvl").val();
        var o = g[p];
        if (o === undefined) {
            o = []
        }
        if (o) {
            m.each(function() {
                if (!o.includes($(this).val())) {
                    o.push($(this).val())
                }
            });
            n.each(function() {
                if (o.includes($(this).val())) {
                    var q = o.indexOf($(this).val());
                    if (q !== -1) {
                        o.splice(q, 1)
                    }
                }
            })
        }
        g[p] = o;
        Panel.searchDownline(function() {
            var s = $("#sourceLvl").val();
            var u = g[s];
            $("#searchLvl").val(s);
            if (u && u.length > 0) {
                var t = $("#sourceCheck").find("input[type=checkbox][name='source']");
                t.prop("checked", false);
                for (var r = 0, q = u.length; r < q; r++) {
                    t.filter(function() {
                        return this.value === u[r]
                    }).prop("checked", true)
                }
            }
        })
    });
    $("#btnSave").click(function() {
        Panel.save()
    });
    var e = $("#dialog_sourcelist").dialog({
        autoOpen: false,
        modal: true,
        title: "选择账号",
        width: 820,
        buttons: {
            "确定": function() {
                var m = $("input[name=source]:checked");
                var p = $("input[name=source]:not(:checked)");
                var q = $("#searchLvl").val();
                if (g[q] === undefined) {
                    g[q] = []
                }
                if (g[q]) {
                    m.each(function() {
                        if (!g[q].includes($(this).val())) {
                            g[q].push($(this).val())
                        }
                    });
                    p.each(function() {
                        if (g[q].includes($(this).val())) {
                            var r = g[q].indexOf($(this).val());
                            if (r !== -1) {
                                g[q].splice(r, 1)
                            }
                        }
                    })
                }
                var o = [];
                var n = [];
                for (let i = 0; i <= 10; i++) {
                    for (let item in g[i]) {
                        o = o.concat(i);
                        n = n.concat(g[i][item])
                    }
                }
                $("#sourceLv").val(q);
                $("#sourceLvs").val(o.join(","));
                $("#sourceList").val(n.join(","));
                $("#sourceListStr").text(n.join(","));
                k = JSON.parse(JSON.stringify(g));
                e.dialog("close")
            },
            "取消": function() {
                e.dialog("close")
            }
        },
        open: function(n, o) {
            var m = $("#sourceLv").val();
            if (m) {
                $("#sourceLvl").val(m)
            }
            $("#sourceUsername").val("");
            g = JSON.parse(JSON.stringify(k));
            Panel.searchDownline(function() {
                var r = $("#sourceLvl").val();
                var t = g[r];
                $("#searchLvl").val(r);
                if (t && t.length > 0) {
                    var s = $("#sourceCheck").find("input[type=checkbox][name='source']");
                    s.prop("checked", false);
                    for (var q = 0, p = t.length; q < p; q++) {
                        s.filter(function() {
                            return this.value === t[q]
                        }).prop("checked", true)
                    }
                }
            })
        }
    });
    $("#chooseSource").click(function() {
        e.dialog("open")
    });
    Panel.init();
    var b = $("#sourceLvs").val();
    var h = b.split(",");
    var a = $("#sourceList").val();
    var c = a.split(",");
    for (i = 0; i < h.length; i++) {
        var d = h[i];
        if (d && d !== "") {
            var f = c[i];
            var j = k[d];
            if (j) {
                j = j.concat(f)
            } else {
                j = [f]
            }
            k[d] = j
        }
    }
});
function selectAll(a, b) {
    $(b).parent().parent().find("input[type='checkbox']").prop("checked", a)
}
var Panel = (function() {
    return {
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
        showAll: true,
        isNotice: false,
        now: function(a) {
            if (a) {
                return (new Date()).getTime()
            }
            return (new Date()).getTime() - this.timeOffset
        },
        settingTime: function(a) {
            a = Number(a);
            if (isNaN(a)) {
                return
            }
            this.timeOffset = this.now(true) - a
        },
        init: function(b) {
            LIBS.clone(this, b);
            var d = $("#lotteryList").val();
            if (d !== "") {
                var f = d.split(",");
                if (f.length > 0) {
                    var e = $("#agentFollowPlan").find("input[type=checkbox][name='lottery']");
                    e.prop("checked", false);
                    for (var c = 0, a = f.length; c < a; c++) {
                        e.filter(function() {
                            return this.value === f[c]
                        }).prop("checked", true)
                    }
                }
            }
        },
        formatTime: function(a) {
            var b = Number(a);
            if (isNaN(b)) {
                return "-"
            }
            return new Date(b).format("hh:mm:ss")
        },
        changeInterval: function(a) {
            this.interval = a;
            this.refreshRemain = a;
            if (a > 0) {
                this.showRefreshRemain()
            }
        },
        showRefreshRemain: function(b) {
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
            } else {
                this.countdownPanel.html("")
            }
        },
        doInterval: function() {
            if (this.interval <= 0) {
                return
            }
            this.refreshRemain -= 1;
            this.showRefreshRemain();
            if (this.refreshRemain <= 0) {
                this.reload(true)
            }
        },
        searchDownline: function(e) {
            var c = $("#sourceLvl").val() === "0" ? 1 : 2;
            var d = $("#sourceLvl").val();
            var b = $("#sourceUsername").val();
            var a = "downlines?type=" + c + "&agentLv=" + d + "&username=" + $("#username").val() + "&sourceUsername=" + b;
            $.ajax({
                url: a,
                method: "POST",
                contentType: "application/json",
                loading: true,
                success: function(g) {
                    g = JSON.parse(g);
                    var j = $("#sourceCheck");
                    j.empty();
                    if (g && g.length > 0) {
                        for (var f = 0; f < g.length; f++) {
                            var h = $("<label>").appendTo(j);
                            h.append($('<input name="source" type="checkbox">').val(g[f])).append(g[f])
                        }
                    } else {
                        $("<label>").appendTo(j).append("暂无数据")
                    }
                    e()
                }
            })
        },
        save: function() {
            var f = [];
            var g = $("#sourceList").val();
            if (g !== undefined) {
                f = g.split(",")
            }
            if (g === "") {
                swal({
                    title: "信息",
                    text: "请最少选择一个账号",
                    confirmButtonText: "确定",
                    type: "error"
                }, function() {});
                return
            }
            var e = [];
            var b = $("#sourceLvs").val();
            if (b !== undefined) {
                e = b.split(",")
            }
            var d = [];
            var h = $("input[name=lottery]:checked");
            h.each(function() {
                d.push($(this).val())
            });
            if (h.length === 0) {
                swal({
                    title: "信息",
                    text: "请最少选择一个彩种",
                    confirmButtonText: "确定",
                    type: "error"
                }, function() {});
                return
            }
            var a = [];
            var c = "";
            var k = "";
            $("#planDetails tbody tr.detail").each(function() {
                var m = $(this).formData();
                var o = $(this).hasClass("changed");
                if (o && m.password === "") {
                    c = m.sequence;
                    return
                }
                if (m.ratio !== "") {
                    var n = Number(m.ratio);
                    if (isNaN(n) || !Number.isInteger(n) || n < 1 || n > 100) {
                        k = "请输入分配比例1-100"
                    }
                }
                if (m.safeCode !== "" && m.username !== "" && m.password !== "" && m.ratio !== "") {
                    a.push(m)
                } else {
                    if (m.webName !== "" && m.safeCode !== "" && m.username !== "" && m.ratio !== "") {
                        a.push(m)
                    } else {
                        if (m.safeCode !== "" || m.username !== "" || m.password !== "" || m.ratio !== "") {
                            if (c === "") {
                                c = m.sequence
                            }
                        }
                    }
                }
            });
            if (k !== "") {
                swal({
                    title: "信息",
                    text: k,
                    confirmButtonText: "确定",
                    type: "error"
                }, function() {});
                return
            }
            if (a.length === 0) {
                swal({
                    title: "信息",
                    text: "请最少输入一个投注会员",
                    confirmButtonText: "确定",
                    type: "error"
                }, function() {});
                return
            }
            if (c !== "") {
                swal({
                    title: "信息",
                    text: "序号" + c + "投注会员不完整",
                    confirmButtonText: "确定",
                    type: "error"
                }, function() {});
                return
            }
            var j = Number($("#percentage").val());
            if (isNaN(j) || !Number.isInteger(j) || j < 1 || j > 100) {
                swal({
                    title: "信息",
                    text: "请输入跟投比例1-100",
                    confirmButtonText: "确定",
                    type: "error"
                }, function() {});
                return
            }
            $.ajax({
                url: "save",
                method: "POST",
                data: {
                    username: $("#username").val(),
                    planId: $("#planId").val(),
                    planName: $("#planName").val(),
                    dh_138_url: $("#dh_138_url").val(),
                    sourceLv: e[0],
                    sourceLvs: JSON.stringify(e),
                    sourceList: JSON.stringify(f),
                    lotteryList: JSON.stringify(d),
                    percentage: $("#percentage").val(),
                    indicator: $("input[name=indicator]:checked").val(),
                    detailList: JSON.stringify(a)
                },
                loading: true,
                success: function(l) {
                    l = JSON.parse(l);
                    if (l.success) {
                        var m = "保存成功";
                        if (l.message) {
                            m = l.message + m
                        }
                        swal({
                            title: "信息",
                            text: m,
                            confirmButtonText: "确定",
                            type: "success"
                        }, function() {
                            location.href = LIBS.url("query", {})
                        })
                    } else {
                        if (l.message) {
                            swal({
                                title: "信息",
                                text: l.message,
                                confirmButtonText: "确定",
                                type: "error"
                            }, function() {})
                        } else {
                            swal({
                                title: "信息",
                                text: "系统错误",
                                confirmButtonText: "确定",
                                type: "error"
                            }, function() {})
                        }
                    }
                },
                error: function(l) {
                    swal({
                        title: "信息",
                        text: "系统错误",
                        confirmButtonText: "确定",
                        type: "error"
                    }, function() {})
                }
            })
        }
    }
}
)();
