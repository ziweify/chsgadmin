function dateAjax(l) {
    dataload(l), $(".num_history").removeClass("animated fadeInUp")
}

function dataload(l) {
    $.ajax({
        type: "post",
        url: config.publicUrl + "smallSix/findAomenSixHistory.do",
        data: {year: l,source:1,type:1},
        dataType: "json",
        success: function (l) {
            $(".num_history").addClass("animated fadeInUp"), $(".box-title").siblings().remove();
            var i = "";
            if ("" == l.result.data) return $(".num_history").html(""), !1;
            $.each(l.result.data, function (l, a) {
                for (var e = [], s = [], t = a.preDrawCode.split(","), d = 0; d < a.color.length; d++) e.push(proto.colorEng[a.color[d]]), s.push(proto.Zoo[a.czAndFe[d]]);
                0 == a.seventhSingleDouble ? a.seventhSingleDouble = "单" : a.seventhSingleDouble = "双", 0 == a.seventhBigSmall ? a.seventhBigSmall = "大" : a.seventhBigSmall = "小", 0 == a.totalBigSmall ? a.totalBigSmall = "大" : a.totalBigSmall = "小", 0 == a.totalSingleDouble ? a.totalSingleDouble = "单" : a.totalSingleDouble = "双", t[0] < 10 && (t[0] = "0" + t[0]), t[1] < 10 && (t[1] = "0" + t[1]), t[2] < 10 && (t[2] = "0" + t[2]), t[3] < 10 && (t[3] = "0" + t[3]), t[4] < 10 && (t[4] = "0" + t[4]), t[5] < 10 && (t[5] = "0" + t[5]), t[6] < 10 && (t[6] = "0" + t[6]);
                var o = new Date(a.preDrawDate), n = o.getMonth() + 1 + "月" + o.getDate() + "日";
                i += "<div class='num_row'><div class='his_date'><p>第" + a.issue + "期</p><p class='date_md'>" + n + "</p></div><div class='num_item'><ul><li><p class='" + e[0] + "'>" + t[0] + "</p><div>" + s[0] + "</div></li><li><p class='" + e[1] + "'>" + t[1] + "</p><div>" + s[1] + "</div></li><li><p class='" + e[2] + "'>" + t[2] + "</p><div>" + s[2] + "</div></li><li><p class='" + e[3] + "'>" + t[3] + "</p><div>" + s[3] + "</div></li><li><p class='" + e[4] + "'>" + t[4] + "</p><div>" + s[4] + "</div></li><li><p class='" + e[5] + "'>" + t[5] + "</p><div>" + s[5] + "</div></li><li class='add_li'><p class='add'></p> <div></div></li><li><p class='" + e[6] + "'>" + t[6] + "</p><div>" + s[6] + "</div></li></ul></div></div>"
            }), $(".num_history").html(i)
        }
    })
}

$(function () {
    var l = (new Date).getFullYear();
    $("#date").text(l + "年").dateTools(), $(".year").text(l + "年"), dataload(l)
});