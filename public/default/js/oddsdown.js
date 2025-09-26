$(function () {
    $("#username").change(function () {
        location.href = LIBS.url({
            username: $(this).val()
        })
    });
    $(".main .tab_panel").each(function () {
        var n = {};
        var f = $(this);
        f.find("table").each(function () {
            var i = $(this);
            var r = i.data("t");
            var q = n[r];
            if (!q) {
                q = [];
                n[r] = q
            }
            q.push(i)
        });
        for (var m in n) {
            var j = n[m];
            var b = $("<div>").addClass("panel").appendTo(f);
            var l = $("<div>").addClass("game_tab").appendTo(b);
            var c = $("<div>").addClass("tables").appendTo(b);
            var e = $("<div>").addClass("config").appendTo(b);
            for (var g = 0; g < j.length; g++) {
                var p = j[g];
                $("<a>").text(p.data("n")).data("table", p).click(function () {
                    var i = $(this);
                    var q = i.parent();
                    q.children(".on").removeClass("on");
                    i.addClass("on");
                    q.parent().find("table,.config label").hide();
                    var r = i.data("table").show().attr("id").substr(2);
                    $("#c_" + r).show()
                }).appendTo(l);
                p.appendTo(c)
            }
            l.children().eq(0).click();
            if (j.length > 1) {
                var o = true;
                var k = "";
                for (var g = 0; g < j.length; g++) {
                    var h = j[g].find("input").each(function (q) {
                        $(this).attr("no", q)
                    }).vals().join("|");
                    h += "|" + j[g].data("s");
                    if (!k) {
                        k = h;
                        continue
                    }
                    if (k != h) {
                        o = false
                    }
                }
                var d = $('<input type="checkbox">').prop("checked", o).change(function () {
                    if (!$(this).prop("checked")) {
                        return
                    }
                    var u = $(this).closest(".panel");
                    var r = u.find(".tables").children("table");
                    var q = r.filter(":visible");
                    var i = q.find("input").vals();
                    r.not(q).each(function () {
                        $(this).find("input").each(function (t) {
                            $(this).val(i[t]).change()
                        })
                    });
                    var s = u.find(".config input");
                    q = s.filter(":visible");
                    s.not(q).prop("checked", q.prop("checked"))
                });
                $("<label>").append(d).append("统一设置").appendTo(l)
            }
        }
    });
    $(".contents table.data_table tbody tr").each(function () {
        var b = $(this);
        b.find("input").each(function () {
            $(this).data("init", $(this).attr("value")).change(function () {
                var d = $(this);
                var c = Number(d.val());
                d.toggleClass("changed", !(c < 0 || isNaN(c) || c == d.data("init")));
                var e = d.closest(".panel");
                if (d.filter(":visible").length == 0 || !e.find(".game_tab input:checkbox").prop("checked")) {
                    return
                }
                e.find(".tables").find("input[no=" + d.attr("no") + "]").not(d).val(c).change()
            }).each(function () {
                var d = $(this);
                var c = Number(d.val());
                d.toggleClass("changed", !(c < 0 || isNaN(c) || c == d.data("init")))
            })
        })
        //select
        b.find("select").each(function () {
            $(this).data("init", $(this).attr("value")).change(function () {
                var d = $(this);
                var c = Number(d.val());
                d.toggleClass("changed", !(c < 0 || isNaN(c) || c == d.data("init")));
                var e = d.closest(".panel");
                if (d.filter(":visible").length == 0 || !e.find(".game_tab input:checkbox").prop("checked")) {
                    return
                }
                e.find(".tables").find("select[no=" + d.attr("no") + "]").not(d).val(c).change()
            }).each(function () {
                var d = $(this);
                var c = Number(d.val());
                //d.toggleClass("changed", !(c < 0 || isNaN(c) || c == d.data("init")))
            })
        })
    });
    var a = $(".tab_panel");
    $(".game_tab_class a").click(function () {
        a.hide();
        $(".game_tab_class a").removeClass("selected");
        $(this).addClass("selected");
        lotteryType = $(this).addClass("on").attr("id").substr(4);
        $("#p_" + lotteryType).show()
    }).eq(0).click();
    $('.control input[type="reset"]').click(function () {
        location.href = location.href
    })
});

function save() {
    var a = [];
    var b = [];
    $(".contents table.data_table tbody tr").each(function () {
        var e = $(this);
        var d = e.data("ok").split("_");
        var f = {};
        e.find("input.changed").each(function () {
            var g = $(this);
            var h = Number(g.val());
            if (isNaN(h) || h < 0) {
                return
            }
            f[g.attr("name")] = h
        });
        //select
        e.find("select.changed").each(function () {
            var g = $(this);
            var h = Number(g.val());
            if (isNaN(h) || h < 0) {
                return
            }
            f[g.attr("name")] = h
        });
        for (var c in f) {
            f.lottery = d[0];
            f.game = d[1];
            a.push(f);
            return
        }
    });
    $(".config input").each(function () {
        var d = $(this);
        var c = d.prop("checked") + "";
        if (d.val() != c) {
            b.push({
                key: d.parent().attr("id").substr(2),
                value: c
            })
        }
    });
    if (a.length > 0 || b.length > 0) {
        $.ajax({
            url: location.pathname + "/save",
            type: "POST",
            loading: true,
            data: {
                username: $("#username").val(),
                list: JSON.stringify(a),
                configs: JSON.stringify(b)
            },
            success: function (c) {
				c=eval('('+c+')');
				//console.log(c.success);
                if (c.success) {
                    alert("保存成功");
                    location.href = location.href
                } else {
                    if (c.message) {
                        alert(c.message)
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
};