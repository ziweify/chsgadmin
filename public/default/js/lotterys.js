function kongzhishowhide(){
    var cjmode = $("input[name='cjmode']:checked").val();
    if(cjmode == 0){
        $(".kongzhi").hide();
    }
    //给radio name为cjmode的添加点击事件
    $("input[name='cjmode']").click(function () {
        //获取当前选中的radio的value值
        var cjmode = $("input[name='cjmode']:checked").val();
        if (cjmode == 1 || cjmode == 2) {
            $(".kongzhi").show();
        }else{
            $(".kongzhi").hide();
        }
    });
}
function savePeriodOffset() {
    var a = $("#configs").formData();
    $.ajax({
        url: "save",
        type: "POST",
        loading: true,
        data: {
            username: $("#username").val(),
            list: JSON.stringify([a])
        },
        success: function (b) {
           // console.log(b.success);
            if (b.success) {
                alert("设置暂停成功修改。");
                back()
            } else {
                alert(b.message)
            }
        }, error: function () {
            alert("error")
        }
    })
}
function savePeriodOffsets() {
    var b = $("#configs").formData();
    var c = [];
    for (var a in b) {
        var d = b[a];
        d.lottery = a;
        c.push(d)
    }
    $.ajax({
        url: "save",
        type: "POST",
        loading: true,
        data: {
            username: $("#username").val(),
            list: JSON.stringify(c)
        },
        success: function (e) {
          //  console.log(e.success);
            if (e.success) {
                alert("设置暂停成功修改。");
                back()
            } else {
                alert(e.message)
            }
        }, error: function () {
            alert("error")
        }
    })
}
function savePause(a, b, c) {
    $.ajax({
        url: "/agent/lotterys/pause",
        type: "POST",
        loading: true,
        data: {
            username: a,
            lottery: b,
            pause: c
        },
        success: function (d) {
			d=eval('('+d+')');
         //   console.log(d.success);
            if (d.success) {
                alert("成功修改状态。");
                location.reload()
            } else {
                alert(d.message)
            }
        }, error: function () {
            alert("error")
        }
    })
}
function editLottery(a, b, c) {
    var  pause = $("input[name='pause']:checked").val();
    var  cjmode = $("input[name='cjmode']:checked").val();
    var sort = $("input[name='sort']").val();
    var fengpan = $("input[name='fengpan']").val();
    var kjswitch = $("input[name='kjswitch']:checked").val();
    var xtmode = $("input[name='xtmode']:checked").val();
    var kongje = $("input[name='kongje']").val();
    var ylup = $("input[name='ylup']").val();
    $.ajax({
        url: "/agent/lotterys/save",
        type: "POST",
        loading: true,
        data: {
            lottery: a,
			fengpan:fengpan,
			sort:sort,
            pause: pause,
            cjmode:cjmode,
			kjswitch:kjswitch,
			type:b,
            xtmode:xtmode,
            kongje:kongje,
            ylup:ylup
        },
        success: function (d) {
			d=eval('('+d+')');
          //  console.log(d.success);
            if (d.success) {
                alert("成功修改状态。");
                location.reload()
            } else {
                alert(d.message)
            }
        }, error: function () {
            alert("error")
        }
    })
}
function editLottery_tm(a, b, c) {
    var  pause_tm = $("input[name='pause_tm']:checked").val();
    var  fengpan_tm = $("input[name='fengpan_tm']").val();
    $.ajax({
        url: "../lotterys/save_tm",
        type: "POST",
        loading: true,
        data: {
            lottery: a,
			fengpan_tm:fengpan_tm,
            pause_tm: pause_tm,
			type:b
        },
        success: function (d) {
			d=eval('('+d+')');
          //  console.log(d.success);
            if (d.success) {
                alert("成功修改状态。");
                location.reload()
            } else {
                alert(d.message)
            }
        }, error: function () {
            alert("error")
        }
    })
}
function savePause2(a, b, c) {
        var c = $("#account");
        if (c.length == 0) {
            c = $('<div id="account">').addClass("popdiv");
            c.dialog({
                autoOpen: false,
                width: 410
            })
        }

        c.dialog("option", {
            title: a + "# 彩种设置"
        });
        c.empty();
        c.append('<span class="loading">载入中……</span>').load("/agent/lotterys/edit", {
            lottery: b,
        },
        function() {
            c.find("input.input").keyup(function() {
                $("#popDx").text(moneyToDX($(this).val()))
            })
        });
        c.dialog("open")
    }
function savePause_tm(a, b, c) {

        var c = $("#account2");
        if (c.length == 0) {
            c = $('<div id="account2">').addClass("popdiv");
            c.dialog({
                autoOpen: false,
                width: 410
            })
        }

        c.dialog("option", {
            title: a + "# 彩种时间设置"
        });
        c.empty();
        c.append('<span class="loading">载入中……</span>').load("edit_tm", {
            lottery: b,

        },
        function() {
            c.find("input.input").keyup(function() {
                $("#popDx").text(moneyToDX($(this).val()))
            })
        });
        c.dialog("open")
    }
$(function () {
    $("#username").change(function () {
        location.href = LIBS.url({
            username: $(this).val()
        })
    })
});

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
        history.back()
    }
};
