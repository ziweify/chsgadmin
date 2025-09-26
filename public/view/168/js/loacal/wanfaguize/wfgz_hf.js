$(document).scroll(function () {
    $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
}), $(document).ready(function () {
    $("#gotop").click(function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $("#headdivbox").load("../public/head.html", function () {
        pupajax(), config.ifdebug
    }), $("#fooderbox").load("../public/fooder.html", function () {
        config.ifdebug
    }), queryPublicQQ();
    var l = window.location.pathname.split("/"), t = [{title: "PK10", url: "PK10_wanfaguize.html"}, {
        title: "新疆时时彩",
        url: "XJssc_wanfaguize.html"
    }, {title: "时时彩", url: "CQssc_wanfaguize.html"}, {title: "极速蛋蛋", url: "SPEEDPCEGG.html"}, {
        title: "台湾5分彩",
        url: "tw5fc_wanfaguize.html"
    }, {title: "快乐十分", url: "GDklsf_wanfaguize.html"}, {title: "广东11选5", url: "GD11x5_wanfaguize.html"}, {
        title: "江苏快3",
        url: "JSK3_wanfaguize.html"
    }, {title: "十一运夺金", url: "SYYDJ_wanfaguize.html"}, {title: "重庆幸运农场", url: "CQXYNC_wanfaguize.html"}, {
        title: "快3",
        url: "KUAI3_wanfaguize.html"
    }, {title: "11选5", url: "SYX5_wanfaguize.html"}, {title: "快乐8", url: "KL8_wanfaguize.html"}, {
        title: "PC蛋蛋幸运28",
        url: "EGXY28.html"
    }, {title: "超级大乐透", url: "CJDLT.html"}, {title: "福彩3D", url: "FCSD.html"}, {
        title: "福彩七乐彩",
        url: "FCQLT.html"
    }, {title: "福彩双色球", url: "FCSSQ.html"}, {title: "体彩排列3", url: "PLS.html"}, {
        title: "体彩排列5",
        url: "PLW.html"
    }, {title: "体彩七星彩", url: "QXC.html"}, {title: "台湾宾果", url: "TWBG_wanfaguize.html"}, {
        title: "台湾大乐透",
        url: "TWdlt.html"
    }, {title: "台湾威力彩", url: "TWwlc.html"}, {title: "台湾今彩539", url: "TWjr539.html"}];
    !function (l) {
        $("#rule-submenu").html(""), $("#rule-submenu").append('<li class="guize_head">\n                                    <strong>玩法规则</strong>\n                                </li>');
        for (var e = 0; e < t.length; e++) {
            var i = "hover";
            t[e].url == l && (i = "active");
            var u = '<li class="' + i + '">\n                                          <a href="' + t[e].url + '"><strong>' + t[e].title + "</strong></a>\n                                     </li>";
            $("#rule-submenu").append(u)
        }
    }(l[l.length - 1])
});