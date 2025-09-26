var ADMIN;
var selectLottery;
$(function () {
    var d = location.href.split("/");
    var b = d.slice(d.length - 1, d.length).toString(String).split(".").slice(0, 1).toString(String).toLowerCase().split("?")[0];
    $("#" + b).addClass("active");
    $("#username").change(function () {
        location.href = LIBS.url({
            username: $(this).val()
        })
    });
    $(".main .tab_panel").each(function () {
        var o = {};
        var g = $(this);
        g.find("table").each(function () {
            var r = $(this);
            var u = r.data("t");
            var s = o[u];
            if (!s) {
                s = [];
                o[u] = s
            }
            s.push(r)
        });
        for (var n in o) {
            var k = o[n];
            var e = $("<div>").addClass("panel").appendTo(g);
            var m = $("<div>").addClass("game_tab").appendTo(e);
            for (var h = 0; h < k.length; h++) {
                var q = k[h];
                $("<a>").text(q.data("n")).data("table", q).click(function () {
                    var r = $(this);
                    var s = r.parent();
                    s.children(".on").removeClass("on");
                    r.addClass("on");
                    s.parent().children("table:visible").hide();
                    r.data("table").show()
                }).appendTo(m);
                q.appendTo(e)
            }
            m.children().eq(0).click();
            if (k.length > 1) {
                var p = true;
                var l = "";
                for (var h = 0; h < k.length; h++) {
                    var j = k[h].find("input").each(function (r) {
                        $(this).attr("no", r)
                    }).change(function () {
                        var r = $(this);
                        var s = r.closest(".panel");
                        if (r.filter(":visible").length == 0 || !s.find(".game_tab input:checkbox").prop("checked")) {
                            return
                        }
                        s.find("input[no=" + r.attr("no") + "]").not(r).val(r.val()).change()
                    }).vals().join("|");
                    if (!l) {
                        l = j;
                        continue
                    }
                    if (l != j) {
                        p = false
                    }
                }
                var f = $('<input type="checkbox">').prop("checked", p).change(function () {
                    if (!$(this).prop("checked")) {
                        return
                    }
                    var s = $(this).closest(".panel").children("table");
                    var r = s.filter(":visible").find("input").vals();
                    s.filter(":not(:visible)").each(function () {
                        $(this).find("input").each(function (t) {
                            $(this).val(r[t]).change()
                        })
                    })
                });
                $("<label>").append(f).append("统一设置").appendTo(m)
            }
        }
    });
    $(".contents table.data_table tbody tr").each(function () {
        var e = $(this);
        e.find("input").each(function () {
            $(this).change(function () {
                var f = Number($(this).val());
                $(this).toggleClass("changed", !(f < 0 || isNaN(f) || f == $(this).data("init")))
            }).change()
        });
        e.find("input[name=odds]:eq(0)").focus(function () {
            var g = $(this);
            var f = Number(g.val());
            if (f >= 0 && !isNaN(f)) {
                g.data("v", f)
            }
        }).blur(function () {
            var g = $(this);
            var f = Number(g.val());
            var h = Number(g.data("v"));
            if (f >= 0 && !isNaN(f) && h >= 0 && !isNaN(h)) {
                f -= h;
                f = LIBS.round(f, 6);
                g.closest("tr").find("input[name=odds]:gt(0)").each(function () {
                    var k = $(this);
                    var j = Number(k.val());
                    if (j >= 0 && !isNaN(j)) {
                        j += f;
                        j = LIBS.round(j, 6);
                        if (j < 0) {
                            j = 0
                        }
                        k.val(j).change()
                    }
                })
            }
        })
    });
    var c = $(".tab_panel");
    $(".game_tab_class a").click(function () {
        c.hide();
        $(".game_tab_class a").removeClass("selected");
        $(this).addClass("selected");
        lotteryType = $(this).addClass("on").attr("id").substr(4);
        $("#p_" + lotteryType).show()
    }).eq(0).click();
    $('.control input[type="reset"]').click(function () {
        location.href = location.href
    });
    var a = $(["a", "b", "c", "d"]);
    $("#btnCopy").click(function () {
        var e = $("#copyPanel");
        if (e.length == 0) {
            e = $('<div id="copyPanel">');
            e.dialog({
                autoOpen: false,
                modal: true,
                title: "复制赔率",
                buttons: {
                    "确定": function () {
                        var m = $(this).find("select").not("#selectLottery");
                        var o = m.eq(0).val();
                        var l = m.eq(1).val();
                        var k = $(this).find("#selectLottery");
                        var h = k.val();
                        var g = "";
                        if (h.length > 0) {
                            g = k.find("option:selected").text() + "的 "
                        }
                        if (o == l) {
                            alert("请选择不同用户进行复制");
                            return
                        }
                        var n = $(this).find("input[name=range]:checked").vals();
                        if (n.length == 0) {
                            alert("请选择需要复制的盘口");
                            return
                        }
                        var j = $(this).find("input[name=type]:checked").vals();
                        if (j.length == 0 && h.length == 0) {
                            alert("请选择需要复制的盘口");
                            return
                        }
                        if (!confirm("快速设置时，系统将检查各级代理所选彩票退水，把超过上一级代理的退水重设。是否确定将 【" + o + "】的 " + g + n.join("、") + "盘 赔率和退水复制到【" + l + "】？")) {
                            return
                        }
                        $.ajax({
                            url: "odds/copy",
                            data: {
                                from: o,
                                to: l,
                                range: n.join(""),
                                types: j.join(","),
                                lottery: h
                            },
                            loading: true,
                            success: function (p) {
								p=eval('('+p+')');
                                if (p && p.success) {
                                    alert("复制成功");
                                    location.href = location.href
                                } else {
                                    if (p.message) {
                                        alert(p.message)
                                    } else {
                                        alert("复制失败")
                                    }
                                }
                            }
                        });
                        $(this).dialog("close")
                    }, "取消": function () {
                        $(this).dialog("close")
                    }
                }
            });
            $("<p>").append("从：").append('<select id="usernameFromSelection">').appendTo(e);
            var f = $('<p id="lotteryTypeSelection">').append("复制：").appendTo(e);
            $(["快开彩", "全国彩", "香港彩"]).each(function (g) {
                $("<label>").append('<input name="type" type="checkbox" value="' + g + '" />').append(this).appendTo(f)
            });
            $("<p>").append("彩票：").append(selectLottery).appendTo(e);
            f = $("<p>").append("盘口：").appendTo(e);
            $(["A", "B", "C", "D"]).each(function () {
                $("<label>").append('<input name="range" type="checkbox" value="' + this + '" />').append(this + "盘").appendTo(f)
            });
            $("<p>").append("到：").append('<select id="usernameToSelection">').appendTo(e);
            $("#selectLottery").change(function () {
                var g = e.find("#lotteryTypeSelection");
                if ($(this).val().length == 0) {
                    g.show()
                } else {
                    g.hide()
                }
            })
        }
        e.find("#usernameFromSelection").each(function () {
            $("#username").children().clone().appendTo($(this).empty())
        });
        e.find("#usernameToSelection").each(function () {
            $("#usernameAgent").children().clone().appendTo($(this).empty())
        });
        e.find("input:checkbox").prop("checked", true);
        e.dialog("open")
    })

    $("#btnTball").click(function () {
        $.ajax({
            url: "/agent/quick/tball",
            type: "POST",
            loading: true,
            data: {},
            success: function (g) {
                g=eval('('+g+')');
                if (g.success) {
                    alert(g.message)
                } else {
                    if (g.message) {
                        alert(g.message)
                    } else {
                        alert("系统错误")
                    }
                }
            }, error: function () {
                alert("error")
            }
        })
    })
});

function save(c) {
    var b = [];
    var a = [];
    $(".contents table.data_table").each(function () {
        var d = $(this).attr("id").substr(2);
        $(this).find("tbody tr").each(function () {
            var h = $(this);
            var f = h.find("input");
            var j = ["colA"];
            var t = ["colminBetAmount", "colmaxBetAmount", "colmaxUserPeriodAmount", "colmaxPeriodAmount"];
            if (c == true) {
                j.push("oddsmax")
            }
            var k = f.filter("[name^=odds]");
            if (k.filter(".changed").length != 0) {
                var e = [];
                for (i = 0; i < 1; i++) {
                    e.push(k.parent("." + j[i]).find("[name^=odds]").val())
                }
                b.push({
                    lottery: d,
                    key: h.data("ok"),
                    values: e
                })
            }
            var l = f.filter("[name=cm]");
            if (l.filter(".changed").length != 0) {
                var g = [];
                for (i = 0; i < 4; i++) {
                    cmCol = l.parent("." + t[i]).find("[name=cm]");
                    g.push(cmCol.val())
                }
                a.push({
                    lottery: d,
                    key: h.data("ck"),
                    values: g
                })
            }
        })
    });
    if (b || a) {
        $.ajax({
            url: location.pathname + "/save",
            type: "POST",
            loading: true,
            data: {
                username: $("#username").val(),
                odds: JSON.stringify(b),
                cm: JSON.stringify(a)
            },
            success: function (d) {
					d=eval('('+d+')');
                if (d.success) {
                    alert("保存成功");
                    location.href = location.href
                } else {
                    if (d.message) {
                        alert(d.message)
                    } else {
                        alert("系统错误")
                    }
                }
            }, error: function () {
                alert("error")
            }
        })
    } else {
        alert("没有任何改动")
    }
}

function showDialog(e, c, d) {
    var a = $("#username").val();
    var b = "quickdetail?mid=" + c + "&lottery=" + d + (a ? "&username=" + a : "");
    $("#dialog").dialog({
        title: e,
        modal: true,
        width: 680,
        height: 518,
        open: function (f, g) {
            $("#dialog_content").load(b)
        }, close: function (f, g) {
            $("#dialog_content").html("")
        }, buttons: [{
            text: "保存",
            click: function () {
                console.log("保存");
                var f = [];
                $("table.data_table tbody tr").each(function () {
                    var h = $(this);
                    var g = h.find("input");
                    var j = g.filter("[name^=odds]");
                    if (j.filter(".changed").length != 0) {
                        f.push({
                            lottery: d,
                            key: h.data("detailid"),
                            a: j.filter("[data-range=a]").val(),
                            b: j.filter("[data-range=b]").val(),
                            c: j.filter("[data-range=c]").val(),
                            d: j.filter("[data-range=d]").val()
                        })
                    }
                });
                if (f.length > 0) {
                    $.ajax({
                        url: "/agent/quick/saveDetail",
                        type: "POST",
                        loading: true,
                        data: {
                            username: a,
                            odds: JSON.stringify(f)
                        },
                        success: function (g) {
							g=eval('('+g+')');
                            if (g.success) {
                                alert("保存成功")
                            } else {
                                if (g.message) {
                                    alert(g.message)
                                } else {
                                    alert("系统错误")
                                }
                            }
                        }, error: function () {
                            alert("error")
                        }
                    })
                } else {
                    alert("没有任何改动")
                }
            }
        }, {
            text: "关闭",
            click: function () {
                $(this).dialog("close")
            }
        }]
    })
};
