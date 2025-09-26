var lottery, games, saveUrl = "saveBackShare";

function back() {
    window.history.back()
}

function equals(t, a) {
    for (var e in t) if (t[e] != a[e]) return !1;
    return !0
}

function save() {
    var n = [];
    $("table.data_table tbody tr.changed").each(function (t) {
        var a = $(this), e = a.attr("id").split("_", 2);
        n.push({lottery: e[0], game: e[1], flag: a.find("input.flag").val(), enabled: a.find("input:checked").val()})
    }), 0 < n.length ? $.ajax({
        url: saveUrl,
        type: "POST",
        loading: !0,
        data: {lottery: lottery, username: $("#username").text(), list: JSON.stringify(n)},
        success: function (t) {
            t.success ? alert("保存成功") : alert(t.message)
        },
        error: function () {
            alert("error")
        }
    }) : alert("没有任何改动")
}

$(function () {
    $(".setting .menu");
    var t = $(".tab_panel");
    $(".game_class a").click(function () {
        t.hide(), $(".game_class a").removeClass("selected"), $(this).addClass("selected"), $("#p_" + $(this).addClass("on").attr("id").substr(4)).show()
    }).eq(0).click(), $("input[type=reset]").click(function () {
        back()
    }), $(".data_table input").change(function () {
        $(this).closest("tr").addClass("changed")
    }), $("#quickSetting input:button").click(function () {
        var n = $("#quickSetting input:text").val(), i = $("#quickSetting input:radio:checked").val();
        $(".tab_panel:visible .data_table tbody tr").each(function () {
            var t = $(this), a = !1,
                e = (n && (e = t.find("input:text")).val() != n && (e.val(n), a = !0), t.find("input:radio[value=" + i + "]"));
            e.prop("checked") || (e.prop("checked", !0), a = !0), a && t.addClass("changed")
        })
    })
});
