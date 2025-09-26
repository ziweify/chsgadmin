var lotteryType = 0;

function getData(a) {
    var b = {};
    a.find("input:text.changed").each(function () {
        var d = $(this);
        b[d.attr("name")] = d.val()
    });
    if ($.isEmptyObject(b)) {
        return null
    }
    var c = a.find("input[name=id]").val();
    if (c) {
        c = c.split("_");
        b.lottery = c[0];
        b.game = c[1]
    }
    return b
}

function format(c, b) {
    var a = c[b];
    if (a != null) {
        a = Math.round(a * 100000) / 100000
    }
    c[b] = a
}

function saveParam() {
    if (!confirm("是否保存 " + $("#username").val() + " 的退水设置？")) {
        return
    }
    var a = [];
    $(".panel .data_table tbody tr").each(function () {
        var b = getData($(this));
        if (b != null) {
            format(b, "A");
            format(b, "C");
            format(b, "B");
            a.push(b)
        }
    });
    $.ajax({
        url: path,
        type: "POST",
        loading: true,
        dataType: "json",
        data: {
            username: $("#username").val(),
            params: JSON.stringify(a),
            downLine: $('input[name="downline"]:checked').val()
        },
        success: function (b) {
            console.log(b);
            if (b.success) {
                alert("退水设置已成功保存。");
                back()
            } else {
                if (b.status == "force") {
                    var c = confirm(b.message);
                    if (c == true) {
                        $.ajax({
                            url: "saveParam/confirm",
                            type: "POST",
                            loading: true,
                            data: {
                                username: $("#username").val(),
                                params: JSON.stringify(a),
                                downLine: $('input[name="downline"]:checked').val()
                            },
                            success: function (d) {
                                if (d.success) {
                                    alert("退水设置已成功保存。");
                                    back()
                                } else {
                                    alert(d.message)
                                }
                            },
                            error: function () {
                                alert("error")
                            }
                        })
                    }
                } else {
                    alert(b.message)
                }
            }
        },
        error: function () {
            alert("error")
        }
    })
}

function back() {
    var a = LIBS.getUrlParam("back");
    if (a) {
        if (a.indexOf("?") == -1) {
            a += "?"
        }
        location.href = LIBS.url(a, {_: (new Date()).getTime()})
    } else {
        if ($("select#username").length == 0) {
            history.back()
        } else {
            location.reload()
        }
    }
}

$("input").on("focusin", function () {
    $(this).data("val", $(this).val())
});

function validate(j) {
    var i = document.getElementById("ouType").value;
    var h = document.getElementById("uType").value;
    var c = document.getElementById("uLvl").value;
    var a = j.attr("id");
    var g;
    var b;
    if (i == 4 && h == 3) {
        var f;
        if (typeof a !== "undefined" && a.includes("_")) {
            var e = a.split("_");
            if (e[1] == "mar" || e[1] == "mpr") {
                g = Number(j.val());
                b = Number(document.getElementById(a.substring(0, a.length - 1)).value);
                f = a.substring(0, a.length - 1)
            } else {
                g = Number(document.getElementById(a + "r").value);
                b = Number(j.val());
                f = j.attr("id")
            }
            if (g == null || isNaN(g) || g < 0) {
                var d = j.data("val");
                j.val(d);
                return "不允许负数和其他符号"
            } else {
                if ((b === null || isNaN(b) || b < 0) || (g < b)) {
                    document.getElementById(f).value = g;
                    return "最大值：" + g
                }
            }
        } else {
            b = j.val();
            if ((b === null || isNaN(b) || b < 0)) {
                var d = j.data("val");
                j.val(d);
                return "不允许负数和其他符号"
            }
        }
    } else {
        g = j.closest("td").find("span").text();
        b = Number(j.val());
        if (c > 1 || typeof a !== "undefined") {
            if (g == null || g == "") {
                return ""
            }
            g = Number(g);
            if (isNaN(g)) {
                return ""
            }
            if (b === null || isNaN(b) || b > g || b < 0) {
                j.val(g);
                return "最大值：" + g
            }
        } else {
            if ((b === null || isNaN(b) || b < 0)) {
                var d = j.data("val");
                j.val(d);
                return "不允许负数和其他符号"
            }
        }
    }
    return ""
}

function getTitle(b) {
    var a = b.parents("table");
    var c = a.eq(1).find("th.head").text() + " ";
    c += a.eq(0).find("thead tr th").eq(b.parent().index()).text() + " ";
    return c
}

$(function () {
    var e = location.href.split("/");
    var b = e.slice(e.length - 1, e.length).toString(String).split(".").slice(0, 1).toString(String).toLowerCase().split("?")[0];
    var a = $("#param").attr("href");
    if (b == "commission") {
        $("#param").addClass("active");
        $("#param").attr("href", "commission" + a);
        $("#paramgame").attr("href", "commissiongame" + a)
    } else {
        if (b == "commissiongame") {
            $("#paramgame").addClass("active");
            $("#param").attr("href", "commission" + a);
            $("#paramgame").attr("href", "commissiongame" + a)
        } else {
            $("#" + b).addClass("active");
            $("#param").attr("href", "param" + a);
            $("#paramgame").attr("href", "paramgame" + a)
        }
    }
    $("table.quick tbody tr").each(function () {
        var g = $(this);
        var h = g.attr("class").substr(2);
        var f = g.find("input:text");
        var i = 0;
        g.closest("div").find(".panel table.data_table tbody tr.t_" + h + ":eq(0) td").each(function (j) {
            var m = $(this);
            var l = m.find("span").text();
            var k;
            if (l == "") {
                k = m.find("input:text");
                k.each(function () {
                    f.eq(i).val(this.value);
                    i++
                })
            } else {
                f.eq(j).val(l)
            }
        })
    });
    $(".panel table.data_table input").change(function () {
        var f = $(this);
        var h = validate(f);
        if (h) {
            var g = getTitle(f);
            alert(g + h)
        }
        if (f.val() != f.data("init")) {
            f.addClass("changed")
        } else {
            f.removeClass("changed")
        }
    }).each(function () {
        $(this).data("init", $(this).attr("value"))
    });
    var c = $(".tab_panel");
    $(".game_tab_class a").click(function () {
        c.hide();
        $(".game_tab_class a").removeClass("selected");
        $(this).addClass("selected");
        lotteryType = $(this).addClass("on").attr("id").substr(4);
        $("#p_" + lotteryType).show()
    }).eq(0).click();
    $(".commisionButton").click(function () {
        d(this, ".commission")
    });
    $(".amountButton").click(function () {
        d(this, ".amount")
    });

    function d(f, j) {
        var h = $(f).closest("tr");
        var g = h.attr("class").split("_")[1];
        var i = [];
        h.find(j).each(function () {
            i.push($(this).val())
        });
        $(".at_" + lotteryType + " .t_" + g).each(function () {
            $(this).find(j).val(function (l) {
                var k = $(this).val();
                if (i[l] && i[l] != k) {
                    $(this).addClass("changed");
                    return i[l]
                } else {
                    return $(this).val()
                }
            })
        });
        if (g == "") {
            $(".at_" + lotteryType + " .t_NN").each(function () {
                $(this).find(j).val(function (l) {
                    var k = $(this).val();
                    if (i[l] && i[l] != k) {
                        $(this).addClass("changed");
                        return i[l]
                    } else {
                        return $(this).val()
                    }
                })
            })
        }
    }

    $(".tab a, .backable-tab a").each(function () {
        var f = $(this);
        var g = f.attr("href");
        if (!g || g.indexOf("javascript:") == 0 || g[0] == "#") {
            return
        }
        g = LIBS.url(g, {back: LIBS.getUrlParam("back") || LIBS.url({_: ""})});
        f.attr("href", g)
    });
    $("#username").change(function () {
        location.href = LIBS.url({username: $(this).val()})
    });
    $("#cmcontrol input:button").click(function () {
        var f = $("#cmcontrol input:text").val();
        if (!f || isNaN(f)) {
            return
        }
        f = Math.abs(Number(f));
        $("#p_" + lotteryType + " .panel input.commission").each(function () {
            var g = $(this);
            var h = Number(g.closest("td").find("span").text()) - f;
            h = LIBS.round(Math.max(0, h), 5);
            g.val(h).change()
        })
    })
});
