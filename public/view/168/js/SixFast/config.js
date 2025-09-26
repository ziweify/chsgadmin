function errorFun(o) {
}

function sleep(o) {
    for (var n = new Date, e = n.getTime() + o; ;) if ((n = new Date).getTime() > e) return
}

function headAdbgcolor() {
    var o = window.location.pathname;
    -1 != o.indexOf("SixFast") ? ($(".Fastkai").addClass("headcheli"), $(".bodybox .Fastkai").addClass("grey_after")) : -1 != o.indexOf("/index") ? $(".adindex").addClass("headcheli") : $("#HKcai").addClass("headcheli")
}

function random(o, n) {
    var e = Math.random() * (n - o), i = Math.round(e + o);
    return i = Math.max(Math.min(i, n), o)
}

function moveBall() {
    for (var o = $(".canvas>div>ul>li"), n = 0; n < o.length; n++) {
        var e = random(-50, 400), i = random(-50, 215);
        o[n].style.cssText = "left:" + e + "px;top:" + i + "px"
    }
}

function tanwindow() {
    var o = JSON.parse(localStorage.getItem("localStorageObj"));
    null == o && (o = {});
    var n = new Date, e = n.getDate(), i = n.getHours();
    1 * o.day == 1 * e || o.dayout || (Adv_eject(), o.dayout = !0, o.timeout = !1, o.day = e, localStorage.setItem("localStorageObj", JSON.stringify(o))), i >= 20 && !o.timeout && (Adv_eject(), o.dayout = !1, o.timeout = !0, o.day = e, localStorage.setItem("localStorageObj", JSON.stringify(o)))
}

function fankuFun(o) {
    $.ajax({
        type: "get",
        url: url.config140_2 + "fedBack/saveFedBack.do",
        async: !0,
        data: o,
        dataType: "json",
        success: function (o) {
            alert(o.result.message), 0 == o.errorCode && $("#modal").hide()
        },
        error: function (o) {
        }
    })
}

var url = {
    env: "productionEnv",
    fast_Kai: "//api.apiose122.com/",
    config140_2: "https://1680660.com/",
    news_adurl: "//1682018.cn/view/jisusaiche/pk10kai.html",
    news_adurl_none: "//1680100.com/view/jisusaiche/pk10kai.html"
};
"stagingEnv" == url.env && (url.fast_Kai = "//staging-api2-168-al2.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/", url.config140_2 = "//staging-x6-api-al2.puz2crbmjw.ap-northeast-1.elasticbeanstalk.com/"), url.config140 = url.config140_2 + "smallSix/", url.SixFastUrl = url.fast_Kai + "speedSix/", url.photoUrl = "//1687170.com/";
var tools = {}, config = {publicUrl: url.photoUrl, pageSizenum: 300, ifDebugger: !1}, oldLog = console.log;
console.log = function () {
    config.ifDebugger && oldLog.apply(console, arguments)
}, $("#fooderbox,.footer,#fooderbox").on("click", ".serverOnline", function () {
    $(this).hasClass("firstPage") || $("#kfu").hasClass("kfuIndex"), window.open("https://vue.livelyhelp.chat/chatWindow.aspx?siteId=60002182&planId=37df1c47-950e-4063-800f-1408bbf66c6a#", "winName", "top=150,left=100,width=400,height=600")
});
var publictools = {};
publictools.getToken = function () {
    return window.localStorage.token
}, publictools.testWWW = function () {
    -1 != window.location.href.indexOf("6hch00") ? ($(".brann_img").hide(), $("#init168").attr("href", "https://1683532.com"), $(".news_ad").attr("href", url.news_adurl_none)) : ($(".brann_img").show(), $(".news_ad").attr("href", url.news_adurl));
    var o = window.location.host, n = window.location.protocol + "//m." + (o = o.replace(/^www./, ""));
    $("#initwebapp").attr("href", n)
};
var urlhost = window.location.host;
tools.Advphoto = function () {
    $.ajax({
        type: "get",
        url: url.config140_2 + "advertisingPicture/getAdvertisingPicture.do",
        data: {sourceUrl: urlhost},
        dataType: "json",
        success: function (o) {
            var n = o.result.data, e = "", i = "", t = $(".imgDiv");
            if ("" == n) return !1;
            $.each(n, function (o, n) {
                0 == n.position && (e += "<li><a href='" + n.link + "' target='" + (1 == n.openWith ? "_blank" : "_self") + "'><img src='" + url.photoUrl + n.image + "'></a></li>", $("#sixadv").attr("href", n.link), $("#fastadv").attr("href", n.link)), 0 != t.length && 1 == n.position && (i = "<a href='" + n.link + "' id='index_ad' target='" + (1 == n.openWith ? "_blank" : "_self") + "'><img src='" + url.photoUrl + n.image + "'></a>")
            }), $(".brann_img ul").html(e), t.html(i), publictools.testWWW()
        },
        error: function () {
        }
    })
}, tools.addSund = function () {
    $("#ifSoundOpen,#soundSet").empty(), $("#ifSoundOpen").append('<div class="ifSoundOpen"><i>关闭声音</i><div class="ifSoundIcon"></div></div>'), $("#soundSet").append('<div class="soundbtn"><i>铃声设置</i><div class="soundicon soundDefY" id="soundKindsIcon">   <audio src="../media/RING_01.wav"  controls="controls" id="audioid">       Your browser does not support the audio tag.   </audio></div><div class="soundpanel">   <div class="close"></div>   <div class="soundlist">       <ul>           <li><label><input type="radio" name="sound" value="RING_01"  checked="checked">&nbsp;默认(闹钟铃)</label></li>           <li><label><input type="radio" name="sound" value="RING_02">&nbsp;声音二(上课铃)</label></li>           <li><label><input type="radio" name="sound" value="RING_03">&nbsp;声音三(打锣声)</label></li>           <li><label><input type="radio" name="sound" value="RING_04">&nbsp;声音四(打鼓声)</label></li>           <li><label><input type="radio" name="sound" value="RING_05">&nbsp;声音五(点滴声)</label></li>           <li>               提示时间：               <select>                   <option value="5"  selected="selected">开奖前5秒</option>                   <option value="20">开奖前20秒</option>                   <option value="10">开奖前10秒</option>                   <option value="30">开奖前30秒</option>                   <option value="40">开奖前40秒</option>                   <option value="50">开奖前50秒</option>                   <option value="60">开奖前60秒</option>                   <option value="begin">开奖后</option>               </select>           </li>       </ul>   </div></div></div>')
}, tools.playSound = function (o) {
    if (0 == ifopenSoundsBtn && void 0 != ifopenSoundsBtn) {
        var n = $("#audioid");
        "begin" == o && "begin" == $("#soundSet").find("select").val() ? n[0].play() : $("#soundSet").find("select").val() == o - 1 && n[0].play()
    }
};
var ifopenSoundsBtn = !1;
$(function () {
    $("#hkheader_box").on("click", "#ifSoundOpen .ifSoundOpen", function (o) {
        ifopenSoundsBtn ? ($("#ifSoundOpen").find(".ifSoundIcon").removeClass("stopsound"), $("#ifSoundOpen").find("i").text("关闭声音"), ifopenSoundsBtn = !1, $(".soundbtn").css("background", "#ff7b00"), $("#soundSet").find(".soundbtn").removeClass("disabled"), $("#soundKindsIcon").removeClass().addClass("soundDefY")) : ($("#ifSoundOpen").find(".ifSoundIcon").addClass("stopsound"), $("#ifSoundOpen").find("i").text("打开声音"), ifopenSoundsBtn = !0, $("#soundSet").find(".soundbtn").addClass("disabled"), $(".soundbtn").css("background", "#ccc"), $("#soundSet").find(".soundpanel").hide("200"), $("#soundKindsIcon").removeClass().addClass("soundDef")), o.stopPropagation()
    }), $("#hkheader_box").on("click", "#soundSet .soundbtn:not('.disabled')", function (o) {
        $(this).find(".soundpanel").show("200"), o.stopPropagation()
    }), $(".bodybox").on("click", function (o) {
        $(this).parent().parent().find(".soundpanel").hide("200")
    }), $("#hkheader_box").on("click", "#soundSet .close", function (o) {
        $(this).parent().parent().find(".soundpanel").hide("200");
        var n = $("#soundSet").find("input:[checked='checked']").val();
        "RING_01" == n ? $("#soundKindsIcon").removeClass().addClass("soundDefY") : "RING_02" == n ? $("#soundKindsIcon").removeClass().addClass("sound2Y") : "RING_03" == n ? $("#soundKindsIcon").removeClass().addClass("sound3Y") : "RING_04" == n ? $("#soundKindsIcon").removeClass().addClass("sound4Y") : "RING_05" == n && $("#soundKindsIcon").removeClass().addClass("sound5Y"), o.stopPropagation()
    }), $("#hkheader_box").on("click", "#soundSet input", function () {
        void 0 != $(this).val() && ("RING_01" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("soundDefY") : "RING_02" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound2Y") : "RING_03" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound3Y") : "RING_04" == $(this).val() ? $("#soundKindsIcon").removeClass().addClass("sound4Y") : "RING_05" == $(this).val() && $("#soundKindsIcon").removeClass().addClass("sound5Y"), $("#soundSet").find("audio").attr("src", "../media/" + $(this).val() + ".wav"))
    }), setTimeout(function () {
        try {
            tools.addSund()
        } catch (o) {
        }
    }, 1e3), $("#hkheader_box").on("click", ".time_btn", function () {
        $(".time_btn b").toggleClass("cheb"), $(".timeboxbg").toggleClass("timeboxbgche")
    })
});
var timers1, timers2, intervalFun = function () {
    timers1 = setInterval(function () {
        moveBall()
    }, 2e3)
}, Adv_eject = function () {
    $("#fixbox_").show(), intervalFun(), moveBall()
};
$(function () {
    $("#sixfastbox").load("/view/sixfast_header.html", function () {
        var o = window.location.pathname, n = o.lastIndexOf("/");
        o = (o = o.slice(n)).replace("/", "").split(".")[0], $("." + o).addClass("checked")
    }), $("#hkheader_box").load("public/Hkheader.html", function () {
        var o = window.location.pathname, n = o.lastIndexOf("/");
        o = (o = o.slice(n)).replace("/", "").split(".")[0], $("." + o).addClass("checked")
    }), tools.YM = function () {
        var t = window.location.href;
        return "www" == (t = t.split("//")[1].split("/")[0].split("."))[0] ? t = t[1] : "www" != t[0] && (t = "192" == t[0] ? "1680218" : t[0]), t
    }, tools.WWWD = function () {
        $("#tryplay").hide()
    }, tools.noAPP = function () {
        tools.YM();
        //$(".mphone").attr("href", toM()), $(".miniIphone").find("a").attr("href", toM())
    }, tools.advertisement = function () {
        $.ajax({
            url: publicUrl + "focusPicture/findPictureAndNotice.do",
            type: "GET",
            dataType: "json",
            data: {type: "0", position: "1", sourceUrl: tools.YM(), platform: "168"},
            timeout: 6e4,
            beforeSend: function () {
                $("#advertisebox").html('<div class="progress" style="display: block;margin-top:30px;width:100%;text-align:center;"><img src="../../img/icon/piaog.gif"></div>')
            },
            success: function (t) {
                "object" == typeof (t = t) || (t = JSON.parse(t)), "0" == t.errorCode && ("0" == t.result.businessCode ? tools.advertisImg(t.result.data) : $("#advertisebox").empty().text("数据加载异常！"))
            },
            error: function (t) {
                setTimeout(tools.advertisement(), 1e3)
            },
            complete: function (t, e) {
                null
            }
        })
    }, tools.Advphoto = function () {
        $.ajax({
            type: "get",
            url: url.config140_2 + "advertisingPicture/getAdvertisingPicture.do",
            data: {sourceUrl: urlhost},
            dataType: "json",
            success: function (o) {
                publictools.testWWW();
                var n = o.result.data, e = "", i = "", t = $(".imgDiv");
                if ("" == n) return !1;
                $.each(n, function (o, n) {
                    0 == n.position && (e += "<li><a href='" + n.link + "' target='" + (1 == n.openWith ? "_blank" : "_self") + "'><img src='" + url.photoUrl + n.image + "'></a></li>"), 0 != t.length && 1 == n.position && (i = "<a href='" + n.link + "' id='index_ad' target='" + (1 == n.openWith ? "_blank" : "_self") + "'><img src='" + url.photoUrl + n.image + "'></a>")
                }), $(".brann_img ul").html(e), t.html(i)
            },
            error: function () {
            }
        })
    }, $("#headdivbox").load("/view/public/head.html", function () {
        publictools.testWWW(), tools.Advphoto(), headAdbgcolor(), $("#headdivbox>div").on("click", ".closespan", function () {
            $("#fixbox_").hide(), clearInterval(timers1), clearInterval(timers2)
        })
    }), $("#fooderbox").load("public/fooder.html", function () {
    }), $("#fooderbox,.footer,#fooderbox").on("click", "#gotop", function () {
        return $("body,html").animate({scrollTop: 0}, 500), $(this).hide(), !1
    }), $("#fooderbox,.footer,#fooderbox").on("mousemove", ".fankuicon", function () {
        $(this).html("用户</br>反馈")
    }), $("#fooderbox,.footer,#fooderbox").on("mouseout", ".fankuicon", function () {
        $(this).html("")
    }), $("#fooderbox,.footer,#fooderbox").on("mousemove", ".serverOnline", function () {
        $(this).html("在线</br>客服")
    }), $("#fooderbox,.footer,#fooderbox").on("mouseout", ".serverOnline", function () {
        $(this).html("")
    }), $("#fooderbox,.footer,#fooderbox").on("click", ".bar_remove", function () {
        $("#modal").hide()
    }), $("#fooderbox,.footer,#fooderbox").on("click", ".fankuicon", function () {
        $("#modal").show()
    })
});
var proto = {
    issuc: "2017019",
    Zoo: ["", "鼠", "牛", "虎", "兔", "龙", "蛇", "马", "羊", "猴", "鸡", "狗", "猪"],
    fiveLineArr: ["", "金", "木", "水", "火", "土"],
    colorArr: ["", "#F8253E", "#1FC26B", "#0093E8"],
    colorEng: ["", "red", "green", "blue"],
    colorCh: ["", "红", "蓝", "绿"],
    jiaqzs: ["", "家", "野"],
    jiaqzs_text: ["", "家禽", "野兽"],
    boy_girl: ["", "男", "女"],
    top_bottom: ["", "天", "地"],
    four_season: ["", "春", "夏", "秋", "冬"],
    cqsh: ["", "琴", "棋", "书", "画"]
};
$(document).scroll(function () {
    $(this).scrollTop() > 10 ? $("#gotop").show() : $("#gotop").hide()
}), $("#fooderbox").on("click", "#btn_upload", function () {
    fankuFun({
        linkType: $("#fooderbox #select_op option:selected").val(),
        nickName: $("#fooderbox #first_input").val(),
        linkNumber: $("#fooderbox #fanku_text").val(),
        fedBack: $("#fooderbox #advice").val()
    })
}), $(".footer").on("click", "#btn_upload", function () {
    fankuFun({
        linkType: $(".footer #select_op option:selected").val(),
        nickName: $(".footer #first_input").val(),
        linkNumber: $(".footer #fanku_text").val(),
        fedBack: $(".footer #advice").val()
    })
}), tools.browserRedirect = function () {
    var o = navigator.userAgent.toLowerCase(), n = "ipad" == o.match(/ipad/i), e = "iphone os" == o.match(/iphone os/i),
        i = "midp" == o.match(/midp/i), t = "rv:1.2.3.4" == o.match(/rv:1.2.3.4/i), a = "ucweb" == o.match(/ucweb/i),
        s = "android" == o.match(/android/i);
    o.indexOf("android") > 0 && (s = !0);
    var d = "windows ce" == o.match(/windows ce/i), l = "windows mobile" == o.match(/windows mobile/i);
    if (n || e || i || t || a || s || d || l) {
        window.location.href;
        var r = window.location.host, u = window.location.protocol + "//m." + (r = r.replace(/^www./, ""));
        window.location.href = u
    } else window.location.href = "index.html"
};