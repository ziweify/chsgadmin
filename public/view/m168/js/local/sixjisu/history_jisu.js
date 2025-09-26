function addDataFun(t) {
    $.ajax({
        type: "get",
        url: config.publicUrl + "speedSix/findSpeedSixHistory.do",
        data: {date: t, type: 1,source:1},
        dataType: "json",
        success: function (t) {
            $(".num_history").addClass("animated fadeInUp"), $(".box-title").siblings().remove();
            var a = "";
            if ("" == t.result.data) return $(".num_history").html(""), !1;
            $.each(t.result.data.bodyList, function (t, i) {
                var e = [], d = [], l = i.preDrawCode.split(","), s = i.preDrawTime;
                s = s.substr(0, 5);
                for (var o = 0; o < i.color.length; o++) e.push(proto.colorEng[i.color[o]]), d.push(proto.Zoo[i.czAndFe[o]]);
                l[0] < 10 && (l[0] = "0" + l[0]), l[1] < 10 && (l[1] = "0" + l[1]), l[2] < 10 && (l[2] = "0" + l[2]), l[3] < 10 && (l[3] = "0" + l[3]), l[4] < 10 && (l[4] = "0" + l[4]), l[5] < 10 && (l[5] = "0" + l[5]), l[6] < 10 && (l[6] = "0" + l[6]);
                new Date(i.preDrawDate);
                a += "<div class='num_row'><div class='his_date'><p>" + i.issue + "期</p><p class='date_md'>" + s + "</p></div><div class='num_item'><ul><li><p class='" + e[0] + "'>" + l[0] + "</p><div>" + d[0] + "</div></li><li><p class='" + e[1] + "'>" + l[1] + "</p><div>" + d[1] + "</div></li><li><p class='" + e[2] + "'>" + l[2] + "</p><div>" + d[2] + "</div></li><li><p class='" + e[3] + "'>" + l[3] + "</p><div>" + d[3] + "</div></li><li><p class='" + e[4] + "'>" + l[4] + "</p><div>" + d[4] + "</div></li><li><p class='" + e[5] + "'>" + l[5] + "</p><div>" + d[5] + "</div></li><li class='add_li'><p class='add'></p> <div></div></li><li><p class='" + e[6] + "'>" + l[6] + "</p><div>" + d[6] + "</div></li></ul></div></div>"
            }), $(".num_history").html(a)
        }
    })
}
function adddaclass(e, t) {
    1 * e <= 8 ? $(".ye_timelist>ul").css({
        width: .35 * e + "rem",
        float: "right"
    }) : $(".ye_timelist>ul").css({
        width: .35 * e + "rem",
        float: "inherit"
    }), $(".ye_timelist>ul>li").each(function (e) {
        if (1 * $(this).text() == t) {
            $(this).addClass("checkdate");
            var a = 1 * $(".checkdate").offset().left;
            $(".ye_timelist").scrollLeft(Math.abs(a) - 150)
        }
    })
}

function addDomday(e) {
    var t = 1 * e.split("-")[2],
        a = (i = $("#daywrapper>ul").html().replace(/<li>&nbsp;<\/li>/gi, "")).split("日").length - 1,
        i = i.replace(/日/gi, "");
    $(".ye_timelist>ul").html(i).attr("data-text", e.split("-")[0] + "-" + e.split("-")[1] + "-"), adddaclass(a, t)
}
function getDateStr(t) {
    var a = new Date;
    return a.setDate(a.getDate() + t), a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate()
}

$(window).scroll(function () {
    $(this).scrollTop() >= 108 ? $(".num_view").show() : $(".num_view").hide()
}), $(function () {
    var e = (new Date).getFullYear(), t = (new Date).getMonth() + 1, a = (new Date).getDate(),
        i = (t = 1 * t > 9 ? t : "0" + t) + "月" + a + "日";
    $(".ye_timelist>ul").attr("data-text", e + "-" + t + "-"), $("#showtime").text(i);
    for (var r = "", o = 0; o < 1 * a; o++) r += "<li>" + (1 * o + 1) + "</li>";
    $(".ye_timelist>ul").html(r), adddaclass(a, a);

    var t = (new Date).getFullYear();
    $("#date").text(t + "年").dateTools(), addDataFun(getDateStr(0))
});
var method = {};
$("#beginTime").dateTools(), method.loadOther = function (t) {
    addDomday(t), addDataFun(t)
}, $(".ye_timelist").on("click", "ul>li", function () {
    $(this).addClass("checkdate").siblings().removeClass("checkdate"), addDataFun($(this).parent().attr("data-text") + $(this).text())
});
var old = 0, olddata = "";