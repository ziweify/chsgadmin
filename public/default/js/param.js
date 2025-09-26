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
        b.gid = c[0];
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
        url: "/agent/user/param/saveParam",
        type: "POST",
        loading: true,
        data: {
            userid: $("#userid").val(),
            ruid: $("#ruid").val(),
            params: JSON.stringify(a),
            downLine: $('input[name="downline"]:checked').val()
        },
        success: function (b) {
            if (b.success) {
                alert("退水设置已成功保存。");
                back()
            } else {
                alert(b.message)
            }
        }, error: function () {
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
        location.href = LIBS.url(a, {
            _: (new Date()).getTime()
        })
    } else {
        if ($("select#username").length == 0) {
            history.back()
        } else {
            location.reload()
        }
    }
}

function validate(b) {
    var a = b.closest("td").find("span").text();
    if (!a) {
        return ""
    }
    a = Number(a);
    if (isNaN(a)) {
        return ""
    }
    var c = Number(b.val());
    if (isNaN(c) || c > a || c < 0) {
        b.val(a);
        return "最大值：" + a
    }
    return ""
}

function getTitle(b) {
    var c = b.parent().parent().parent().find("th.head").text() + " ";
    return c
}
$(function () {
    var d = location.href.split("/");
    var b = d.slice(d.length - 1, d.length).toString(String).split(".").slice(0, 1).toString(String).toLowerCase().split("?")[0];
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
        var f = $(this);
        var g = f.attr("class").substr(2);
        var e = f.find("input:text");
        f.closest("div").find(".panel table.data_table tbody tr.t_" + g + ":eq(0) td").each(function (h) {
            var k = $(this);
            var j = k.find("span").text();
            if (j == "") {
                j = k.find("input:text").val()
            }
            e.eq(h).val(j)
        })
    });
    $(".panel table.data_table input").change(function () {
        var e = $(this);
        var g = validate(e);
        if (g) {
            var f = getTitle(e);
            alert(g);
        }
        if (e.val() != e.data("init")) {
            e.addClass("changed")
        } else {
            e.removeClass("changed")
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
    $(".quick input:button").click(function () {
        var f = $(this).closest("tr");
        var e = f.attr("class").split("_")[1];
        var g = [];
        f.find("input:text").each(function () {
            g.push($(this).val())
        });
        $(".at_" + lotteryType + " .t_" + e).each(function () {
            $(this).find("input:text").val(function (j) {
                var h = $(this).val();
                if (g[j] && g[j] != h) {
                    $(this).addClass("changed");
                    return g[j]
                } else {
                    return $(this).val()
                }
            })
        })
    });
    /*$(".quick input:button").click(function () {
        var rel = $(this).attr("rel")
        var f = $(this).closest("tr");
        var e = f.attr("class").split("_")[1];
        var g = [];
        var gg = [];
        f.find("input:text").each(function (i,n) {
            var cla = $(this).attr("class")
            if(cla == "commission"){
                g.push($(this).val())
            }else{
                gg.push($(this).val())
            }
        });
        var g_len = g.length;
        $(".at_" + lotteryType + " .t_" + e).each(function () {
            $(this).find("input:text").val(function (j) {
                var cla = $(this).attr("class")
                var h = $(this).val();
                if (rel == 1 && cla == "commission" &&g[j] && g[j] != h) {
                    $(this).addClass("changed");
                    return g[j]
                } else {
                    j = j-g_len;
                    if (rel != 1 &&gg[j] && gg[j] != h) {
                        $(this).addClass("changed");
                        return gg[j]
                    }else{
                        return $(this).val()
                    }

                }
            })
        })
    });*/
    $(".tab a").each(function () {
        var e = $(this);
        var f = e.attr("href");
        if (!f || f.indexOf("javascript:") == 0 || f[0] == "#") {
            return
        }
        f = LIBS.url(f, {
            back: LIBS.getUrlParam("back") || LIBS.url({
                _: ""
            })
        });
        e.attr("href", f)
    });
    $("#username").change(function () {
        location.href = LIBS.url({
            username: $(this).val()
        })
    });
    $("#btn_commission").click(function () {
        var e = $("#commission").val();
        if (!e || isNaN(e)) {
            return
        }
        e = Math.abs(Number(e));
        $("input[name='p']").each(function () {
            var f = $(this);
            var g = Number(f.closest("td").find("span").text()) - e;
            g = LIBS.round(Math.max(0, g), 5);
            f.val(g).change()
        })
    })
    $("#btn_point").click(function () {
        var e = $("#point").val();
        if (!e || isNaN(e)) {
            return
        }
        e = Math.abs(Number(e));
        $("input[name='p']").each(function () {
            var f = $(this);
            f.val(e).change()
        })
    })
});
