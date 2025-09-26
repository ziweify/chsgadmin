function postCall(e, t, a, n, c) {
    $.ajax({
        type: "POST", url: e, data: t, success: function (e) {
            e && !e.success ? alert("错误：" + e.message) : alert(n || "操作完成"), a && a()
        }, error: function () {
            alert(c || "操作失败")
        }
    })
}

function pick(e) {
    location.href = LIBS.url({parent: e, username: ""})
}

function resetUserTax(e,d) {
    confirm("是否要恢复【" + d + "】的今日"+tax_name+"？请再三确认！\n（包括报表与额度）") && confirm("是否要恢复【" + d + "】的今日"+tax_name+"？请再次确认！\n（包括报表与额度）") && confirm("是否要恢复【" + d + "】的今日"+tax_name+"？请最后确认一次！\n（包括报表与额度）") && postCall("resetUserTax", {userid: e}, function () {
        location.reload()
    })
}

function back() {
    var e = LIBS.getUrlParam("back");
    e && (-1 == e.indexOf("?") && (e += "?"), location.href = LIBS.url(e, {_: (new Date).getTime()}))
}

function saveParam() {
    var a = [];
    $(".data_panel input.changed").each(function () {
        var e = $(this), t = e.attr("name").split("_");
        a.push({lottery: t[0], game: t[1], tax: e.val()})
    }), 0 == a.length ? alert("没有任何变更的"+tax_name) : confirm("是否保存 " + $("#username").val() + " 的"+tax_name+"设置？") && (0 == $(".data_footer .cur_tpl").length || confirm("警告：当前用户已与模板关联，修改用户"+tax_name+"会取消与模板关联，模板设置变更后不会自动更新当前用户的"+tax_name+"！\n是否确认继续保存？")) && $.ajax({
        url: "saveParam",
        type: "POST",
        loading: !0,
        data: {userid: $("#userid").val(), params: JSON.stringify(a)},
        success: function (e) {
            e.success ? (alert(tax_name+"设置已成功保存。"), back()) : alert("设置错误：" + e.message)
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function savetax_start_bishu() {
    var fid1 = $('#fid1').val();
    var pagesize = $('#pagesize').val();
    $.ajax({
        url: "savetax_start_bishu",
        type: "POST",
        data: {tax_start_bishu:$("#tax_start_bishu").val(),fid1:fid1,pagesize:pagesize},
        success: function (e) {
            e.success ? alert("设置成功。") : alert("设置错误：" + e.message)
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function saveTemplate() {
    var a, e = $("#name").val();
    var fid1 = $('#fid1').val();
    e ? confirm("是否保存"+tax_name+"模板【" + e + "】？") && (a = [], $(".data_panel input.changed").each(function () {
        var e = $(this), t = e.attr("name").split("_");
        a.push({lottery: t[0], game: t[1], tax: e.val()})
    }), $.ajax({
        url: "saveTemplate",
        type: "POST",
        loading: !0,
        data: {tid: $("#id").val(), name: e, params: JSON.stringify(a),fid1:fid1},
        success: function (e) {
            e.success ? (alert(tax_name+"模板已成功保存。"), back()) : alert("保存错误：" + e.message)
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })) : alert("请输入模板名称")
}

function delTemplate(e, t, a,fid1) {
    t = "是否删除"+tax_name+"模板【" + t + "】？";
    a && (t += "\n警告：该模板已有 " + a + " 个用户引用，用户"+tax_name+"将转为“自定义”，保留当前模板设置！"), confirm(t) && postCall("delTemplate", {tid: e,fid1:fid1}, function () {
        location.reload()
    }, "删除成功", "删除错误")
}

$(function () {
    $("input.tax").change(function () {
        Number($(this).val()) < 0 && $(this).val(0).change()
    }).inputSelect([0, .01, .02, .04, .06, .08, .1, .2, .3, .6, .8, 1, 2, 3]).focus(function (e) {
        e.target.select()
    }), $("a.aback").each(function () {
        var e = $(this), t = e.attr("href");
        t && (t = (t += t.includes("?") ? "&" : "?") + "back=" + encodeURIComponent(LIBS.url({_: ""})), e.attr("href", t))
    });
    var e, t, n, c, a, r, i, l, o = $("#refresh");

    function u(e, t) {
        var a = l;
        e && (a = l.filter("[" + e + "=" + t + "]"));
        for (var n = 0; n < a.length; n++) if (!$(a[n]).prop("checked")) return !1;
        return !0
    }

    function s(e, t) {
        e.each(function () {
            var e = $(this);
            e.prop("checked") != t && e.prop("checked", t).change()
        })
    }

    o.length && (e = 20, o.text("刷新 (" + e + ")"), window.setInterval(function () {
        0 == --e && o.click(), 0 <= e && o.text("刷新 (" + e + ")")
    }, 1e3)), $(".tax_param").length ? ($(".data_panel input").change(function () {
        var e = $(this);
        e.val() != e.data("init") ? e.addClass("changed") : e.removeClass("changed")
    }).each(function () {
        $(this).data("init", $(this).attr("value"))
    }), (t = $(".quick_panel table")).tooltip(), l = t.find("tbody td input"), i = t.find("thead input[name=all]"), n = t.find("thead input[name=value]"), c = t.find("tbody th input"), t.find("th input[name!=all]").change(function () {
        var e = $(this), t = e.attr("name"), a = e.val(), e = e.prop("checked");
        s(l.filter("[" + t + "=" + a + "]"), e)
    }), l.change(function (e) {
        var t = $(this), a = (t.prop("checked"), t.val()),
            a = (n.filter("[value=" + a + "]").prop("checked", u("value", a)), t.attr("account"));
        c.filter("[value=" + a + "]").prop("checked", u("account", a)), i.prop("checked", u())
    }), i.change(function () {
        var e = $(this).prop("checked");
        s(l, e)
    }), $("#quickButton").click(function () {
        var a = $("#quickTax").val();
        "" != a && l.filter(":checked").each(function () {
            var e = $(this), t = e.attr("account"), e = e.val();
            $(".data_panel .at_" + t + " td.t_" + e + " input").val(a).change()
        })
    })) : $(".tax_list").length ? ($("#resetTax").click(function () {
        var fid1 = $('#fid1').val();
        confirm("是否确定停止全部下线会员的"+tax_name+"？（不恢复额度、报表及已结注单，仅停用"+tax_name+"）") && postCall("resetTax?fid1="+fid1, null, function () {
            location.reload()
        })
    }), a = $(".input_panel input").keypress(function (e) {
        13 == e.keyCode && $("#query").click()
    }).clearButton(), $("#query").click(function () {
        var t = {};
        var online = $("#online").val();
        t["online"] = online;
        a.each(function () {
            var e = $(this);
            t[e.attr("name")] = e.val()
        }), location.href = LIBS.url(t)
    }), $(".tax_list input[type=checkbox],.tax_list select").change(function () {
        var e = $(this).parent().parent(), t = e.find(".tax_status"),s = e.find(".tax_auto_close"),fid1 = $('#fid1').val();
        var is_show_jpei = e.find(".is_show_jpei").find("select").val();
        $.ajax({
            url: "saveTax",
            type: "POST",
            loading: !0,
            data: {userid: t.attr("name"), enabled: t.prop("checked") ? 1 : 0, tax_auto_close: s.prop("checked") ? 1 : 0, tid: e.find(".template").find("select").val(),fid1:fid1,is_show_jpei:is_show_jpei},
            success: function (e) {
                e.success ? location.reload() : alert("设置错误：" + e.message)
            },
            error: function () {
                alert("网络错误，请稍后重试")
            }
        })
    })) : (r = $("#resetBetButton").prop("disabled", !0), i = $("#checkAll"), l = $("td.check input[type=checkbox]").not(":disabled"), i.change(function () {
        var e = $(this).prop("checked");
        l.prop("checked", e), r.prop("disabled", !e)
    }), l.change(function () {
        var e = l.filter(":checked").length;
        i.prop("checked", e == l.length), r.prop("disabled", !e)
    }), r.click(function () {
        var e = [];
        l.filter(":checked").each(function () {
            e.push($(this).val())
        }), 0 != e.length && confirm("是否恢复选中注单的"+tax_name+"？（恢复报表、返回额度）") && $.ajax({
            url: "resetBetTax",
            type: "POST",
            loading: !0,
            data: "username=" + i.val() + "&" + e.map(function (e) {
                return "bid=" + e
            }).join("&"),
            success: function (e) {
                e.success ? (alert("注单"+tax_name+"已成功恢复。"), location.reload()) : alert("恢复错误：" + e.message)
            },
            error: function () {
                alert("网络错误，请稍后重试")
            }
        })
    }))
});
