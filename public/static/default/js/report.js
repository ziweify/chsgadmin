var TODAY;
var periodLoader;
$(function () {
    if (TODAY) {
        $("#date input").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });
        $('input[name="lottery"]').on("click", function () {
            loadPeriod()
        });
        $("#begin,#end").on("change", function () {
            loadPeriod()
        });
        loadPeriod()
    } else {
        function b(d) {
            return d.children(":eq(0)").attr("colspan")
        }

        function c(g, h) {
            var e = [];
            var f = 0;
            var d = [];
            h += 1;
            g.find("thead tr").each(function (k) {
                var j = 0;
                $(this).children().each(function () {
                    var i = $(this);
                    var n = i.prop("colspan");
                    if (n > 1) {
                        for (var m = 0; m < n; m++) {
                            d.push(j + m)
                        }
                    }
                    if (i.hasClass("ca")) {
                        var l = j;
                        if (k) {
                            l = d[i.index()]
                        }
                        e.push(l - h)
                    }
                    j += n
                });
                f = Math.max(j, f)
            });
            e.tbLen = f - h;
            return e
        }
        $("table.report tbody tr").click(function () {
            $(this).toggleClass("checked")
        });
        if (LIBS.getUrlParam("filter") && !LIBS.getUrlParam("username") && LIBS.getUrlParam("filter").trim() !==
            currentUserName) {
            $("table.report tr").each(function () {
                $(this).children(":not(.info)").each(function (f) {
                    var e = $(this);
                    var g = e.children();
                    if (g.length === 0) {
                        g = e
                    }
                    var d = Number(g.text());
                    if (isNaN(d)) {
                        return
                    }
                    g.text(LIBS.money(d, 1, f !== 0))
                })
            });
            return
        }
        $("table.report").each(function () {
            var m = $(this);
            var k = m.find("tbody tr");
            var h = m.find("thead .count").index() - 1;
            var e = [];
            var g = c(m, h);
            var d = g.tbLen;
            if (k.length > 0) {
                k.each(function () {
                    $(this).children(":not(.info)").each(function (p) {
                        var o = $(this);
                        var q = o.children();
                        if (q.length === 0) {
                            q = o
                        }
                        if ($(this).hasClass("string-column")) {
                            return
                        }
                        var n = Number(q.text());
                        if (isNaN(n)) {
                            return
                        }
                        o.data("sort-value", n);
                        q.text(LIBS.money(n, 1, p !== 0 && !$("thead th:nth-child(" + (
                            p + h + 2) + ")").hasClass("numeric")));
                        e[p] = (e[p] ? e[p] : 0) + n
                    })
                })
            }
            if (!$("#tfootexist").length) {
                var l = $("<tr>").appendTo($("<tfoot>").appendTo(m));
                $("<th>").attr("colspan", h + 1).text("总计：" + k.length + " 行").appendTo(l);
                for (var j = 0; j < d; j++) {
                    var f = $("<td>").text(e[j] !== undefined ? LIBS.money(e[j], 1, j !== 0 && !$(
                        "thead th:nth-child(" + (j + h + 2) + ")").hasClass("numeric")) : "").appendTo(
                        l);
                    if (g.indexOf(j) >= 0) {
                        f.addClass("result color")
                    }
                }
            }
        }).stupidtable({
            wrap: function (f, d, e) {
                if (b($(f[1]))) {
                    return 1
                } else {
                    if (b($(d[1]))) {
                        return -1
                    }
                }
                if (e) {
                    return e(f, d)
                }
                return 0
            },
            number: function (e, d) {
                return e - d
            }
        }).find(".sortable").append("<i>").filter(".sortdefault").click();
        $("table.transfer").each(function () {
            var e = $(this);
            var d = e.find("tbody tr");
            if (!$("#tfootexist").length) {
                var f = $("<tr>").appendTo($("<tfoot>").appendTo(e));
                $('<th style="text-align:right;">').attr("colspan", 2).text("总计：" + d.length + " 笔").appendTo(
                    f)
            }
        })
    }
    moduleOnChange();
    $("#product").change(function () {
        $(".product_box").hide();
        var d = $(this).find(":selected").val();
        $("#product_box_info_" + d).show()
    });

    function a() {
        var d = window.location.hash;
        if (!d) {
            return
        }
        var e = $(".game_tab_class a[href=" + d + "]").attr("id");
        if (!e) {
            return
        }
        $(".game_tab_class a").removeClass("selected");
        $(".game_tab_class a#" + e).addClass("selected");
        $(".table_box").hide();
        $(".table_box_" + e).show();
        if (e === "products") {
            $("#settled, #period").hide();
            $("#product").change()
        } else {
            $("#settled, #period").show()
        }
    }
    a();
    $(".game_tab_class a").click(function () {
        window.location.replace($(this).attr("href"));
        a();
        return false
    })
});

function moduleOnChange() {
    if ($.trim($("#module").val()) != "") {
        $.ajax({
            url: "/agent/logs/getFunctions?moduleKey=" + $("#module").val(),
            method: "GET",
            success: function (a) {
                if (a && a.success) {
                    $("#function").children("option:not(:first)").remove();
                    $("#action").children("option:not(:first)").remove();
                    $.each(a.data, function (b, c) {
                        $("#function").append("<option value = " + c.functionKey + ">" + c.description +
                            "</option>")
                    })
                }
            }
        })
    }
    $("#function").children("option:not(:first)").remove();
    $("#action").children("option:not(:first)").remove();
    $("#function").children("option:first").prop("selected", "selected");
    $("#action").children("option:first").prop("selected", "selected");
    if ($("#module").val() == "instantbet") {
        $("#lotteryDDL, #periodDDL").css("display", "table-row")
    } else {
        $("#lotteryDDL, #periodDDL").css("display", "none")
    }
}

function functionOnChange() {
    var a = $("#function");
    if ($.trim(a.val()) !== "") {
        $.ajax({
            url: "/agent/logs/getActions?moduleKey=" + $("#module").val() + "&functionKey=" + $("#function").val(),
            method: "GET",
            success: function (b) {
                if (b && b.success) {
                    $("#action").children("option:not(:first)").remove();
                    $.each(b.data, function (c, d) {
                        $("#action").append("<option value = " + d.actionKey + ">" + d.description +
                            "</option>")
                    })
                }
            }
        })
    }
    $("#action").children("option:not(:first)").remove();
    $("#action").children("option:first").prop("selected", "selected")
}

function showBackupkey(a) {
    var d = $("#backupPanel");
    if (d.length === 0) {
        d = $('<div id="backupPanel">').appendTo("body");
        d.dialog({
            autoOpen: false,
            title: "备份密钥",
            width: 500
        })
    }
    if (a !== undefined) {
        d.empty();
        var b = $("<p>").appendTo(d);
        var c = "重置备份密钥";
        if (!a) {
            b.text("您尚未设置备份密钥");
            c = "请点此设置"
        } else {
            b.text("您的备份密钥为：").append($("<span>").text(a))
        }
        $('<input type="button">').val(c).appendTo(d).click(function () {
            $.ajax({
                url: "../backup/resetkey",
                method: "post",
                success: function (e) {
                    if (e != null) {
                        showBackupkey(e)
                    } else {
                        alert("重置失败")
                    }
                }
            })
        })
    } else {
        d.html("载入中……");
        $.ajax({
            url: "../backup/view",
            method: "post",
            success: function (e) {
                if (e != null) {
                    showBackupkey(e)
                } else {
                    d.html("载入失败，请重试。")
                }
            }
        });
        d.dialog("open")
    }
}

function selectAll(a, b) {
    $(b).parent().parent().find("input[type='checkbox']").prop("checked", a)
}

function pick(f, e, d, a, b) {
    var c = {
        username: f,
        lottery: d,
        game: a,
        date: b
    };
    if (e === 1) {
        window.open(LIBS.url("bets", c))
    } else {
        location.href = LIBS.url(location.href, c)
    }
}

function productPick(g, i, h, e, k, c, f, d, j) {
    if (i === 1) {
        var a = {
            username: g,
            productChannel: h,
            productGames: e,
            productGameType: k,
            begin: c,
            end: f,
            date: d,
            viewOnly: 1,
            searchUserShares: j
        };
        window.open("productQuery?" + $.param(a))
    } else {
        var b = {
            filter: null,
            username: g,
            channel: h,
            games: e,
            gameType: k,
            date: d
        };
        location.href = LIBS.url(location.href, b)
    }
}
var dt = (function () {
    var b = 86400000;

    function a(d, c) {
        var e = "yyyy-MM-dd";
        $("#begin").val(d.format(e));
        $("#end").val(c.format(e))
    }
    return {
        day: function (e) {
            var c = new Date(TODAY + e * b);
            a(c, c)
        },
        week: function (g) {
            var e = new Date(TODAY);
            var d = e.getDay() - 1;
            if (d < 0) {
                d = 6
            }
            var f = new Date(e.getTime() - b * d + b * 7 * g);
            var c = new Date(f.getTime() + b * 6);
            a(f, c)
        },
        month: function (e) {
            var d = new Date(TODAY);
            d.setDate(1);
            d.setMonth(d.getMonth() + e);
            var c = new Date(d.getTime());
            c.setMonth(d.getMonth() + 1);
            c = new Date(c.getTime() - b);
            a(d, c)
        }
    }
})();

function query() {
    var e = $("#search_form").attr("action");
    var h = $("#begin").val();
    var l = $("#end").val();
    if (h === "" || l === "") {
        alert("请输入日期范围!");
        return
    }
    var a = "";
    if (e === "list") {
        var o = [],
            k;
        var f = $("#products").hasClass("selected");
        if (f) {
            k = document.getElementById("product").value;
            var p = $('input:checkbox[name="product-' + k + '"]:checked');
            if (!p.length) {
                sweetAlert("消息", "请选择至少一个种类", "error");
                return
            }
            p.each(function () {
                o.push(this.value)
            })
        }
        var b = $("#filter").val();
        var m = $("input:radio[name=types]:checked");
        if (m.val()) {
            a = f ? "product_list_game?" : "list_game?"
        } else {
            a = f ? "product_list?" : "list?"
        }
        a += "&begin=" + h + "&end=" + l;
        if (m.val() && b) {
            a += "&username=" + b
        } else {
            if (b) {
                a += "&filter=" + b
            }
        }
        if (f) {
            a += "&productChannel=" + k;
            a += "&games=" + o.join(",")
        } else {
            a += "&settle=" + $("input[name=settle]:checked").val()
        }
        a += "&amount=" + $("#amount").val();
        a += "÷nd=" + $("#dividend").val()
    } else {
        if (e === "logs") {
            if ((new Date(l) - new Date(h)) / 1000 / 3600 / 24 > 91) {
                sweetAlert("错误", "输入的日期范围超出了92天", "error");
                return
            }
            a = "logs?begin=" + h + "&end=" + l;
            if ($.trim($("#module").val()) !== "") {
                a += "&moduleKey=" + $("#module").val()
            }
            if ($.trim($("#function").val()) !== "") {
                a += "&functionKey=" + $("#function").val()
            }
            if ($.trim($("#action").val()) !== "") {
                a += "&actionKey=" + $("#action").val()
            }
            if ($.trim($("#operator").val()) !== "") {
                a += "&operator=" + $("#operator").val()
            }
            if ($.trim($("#targetUserId").val()) !== "") {
                a += "&targetUserId=" + $("#targetUserId").val()
            }
            if ($.trim($("#ipAdd").val()) !== "") {
                a += "&ipAdd=" + $("#ipAdd").val()
            }
            if ($("#date").attr("log-user-id") !== undefined) {
                a += "&id=" + $("#date").attr("log-user-id")
            }
        } else {
            if (e == "shareAlert") {
                var j = $("#username").val();
                a = "shareAlert?begin=" + h + "&end=" + l;
                j && (a += "&username=" + j)
            } else {
                if (e === "transfer") {
                    var d = $("#filterUsername").val();
                    var c = $("#orderId").val();
                    var g = $("input[name=status]:checked").val();
                    a = "transfer?begin=" + h + "&end=" + l;
                    d && (a += "&filterUsername=" + d);
                    c && (a += "&orderId=" + c);
                    g && (a += "&status=" + g)
                }
            }
        }
    }
    if (e === "list" || e === "logs") {
        if (!f) {
            var i = [];
            var n = $("input[name=lottery]:checked");
            if ($("input[name=lottery]").length !== n.length) {
                if (n.length === 0) {
                    sweetAlert("消息", "请最少选择一个彩种", "error");
                    return
                }
                n.each(function () {
                    i.push($(this).val())
                })
            }
            if (i.length !== 0) {
                a += "&lottery=" + i.join(",")
            }
            a += "&period=" + $("select[name=period]").val()
        }
    }
    location.href = a
}

function queryTransfer(b) {
    var a = {
        username: b,
        filterUsername: null
    };
    location.href = LIBS.url(location.href, a)
}

function queryTransferDetails(d, e, b, a) {
    var c = "../report/transferDetails?successOnly=false";
    c += "&userId=" + d;
    c += "&begin=" + e;
    c += "&end=" + b;
    c += "&status=" + a;
    location.href = c
}

function loadPeriod() {
    var d = 'select[name="period"]';
    var c = '<option value="">--------请选择期数--------</option>';
    var a = $('input[name="lottery"]:checked');
    if (a.length == 1) {
        var e = "get";
        var b = $("#begin").val();
        if (periodLoader) {
            periodLoader.abort()
        }
        periodLoader = $.ajax({
            url: "/agent/report/period",
            method: "get",
            cache: b != (new Date(TODAY)).format("yyyy-MM-dd"),
            data: {
                lottery: $(a).attr("value"),
                beginTime: b,
                endTime: $("#end").val()
            },
            success: function (g) {
                $(d).empty();
                $(d).append(c);
                for (var f = 0; f < g.length; f++) {
                    $('select[name="period"]').append("<option value='" + g[f].drawNumber + "'>" + g[f].name +
                        " - " + g[f].drawNumber + "</option>")
                }
            }
        })
    } else {
        $(d).empty();
        $(d).append('<option value="">--------请选择单一彩种--------</option>')
    }
}

function clearSearchForm() {
    $("#game_tab").remove();
    $("#search_form").remove()
};
