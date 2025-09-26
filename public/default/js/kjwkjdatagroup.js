function back() {
    location.href = "./list"
	//window.history.back(-1);
    //history.back();
}
$(function () {
    $("input[name=passname]").change(function () {
        LIBS.get("check", {
            username: $(this).val(),
            parent: $("input[name=parent]").val()
        }, function (a) {
            if (!a) {
                $("#usernameMsg").text("账号可用")
            } else {
                $("#usernameMsg").text(a)
            }
        })
    })
    if($("input[name=passname]").val() == ""){
        //选中所有名称为popedoms
        console.log("isupdate");
        $(".popedom input").each(function(){
            //遍历所有的checkbox
            $(this).prop("checked",true);
        });
    }
    var f = $(".top_info .query_panel");
    if (f.length > 0) {
        f.find("select").change(function() {
            var c = $(this);
            var i = {};
            i[c.attr("name")] = c.val();
            location.href = LIBS.url(i)
        });
        f.find("input:button").click(function() {
            location.href = LIBS.url({
                name: $(this).parent().find("input:text").val()
            })
        });
        f.find("input:text").keypress(function(c) {
            if (c.which == 13) {
                location.href = LIBS.url({
                    name: $(this).val()
                })
            }
        });
        var j = 0;
        $(".left_panel li.t2 span").each(function() {
            j += Number($(this).text())
        });
        $("#t2All").text(j)
    }
});

function showChangeStatusPanel(c, e, b) {
    var a = $("#statusPanel");
    if (a.length == 0) {
        a = $('<div id="statusPanel">').addClass("popdiv").appendTo($("body"));
        a.append($("<div>").addClass("title").text("修改帐户状态"));
        var f = $("<div>").addClass("statuslist").appendTo(a);
        $("<label>").append($('<input name="ustatus" type="radio">').val("0")).append("启用").appendTo(f);
        $("<label>").append($('<input name="ustatus" type="radio">').val("2")).append("停用").appendTo(f);
        f.find("input").click(function () {
            var h = $("#statusPanel").hide().data("status");
            var g = $(this).val();
            if (g == h) {
                return
            }
            $.post("subStatus", {
                passname: $("#statusPanel").data("username"),
                status: g
            }, function () {
                location.reload()
            })
        })
    }
    clearTimeout(a.data("timer"));
    a.data("username", e).data("status", b);
    a.find("input[value=" + b + "]").prop("checked", true);
    var d = $(c).position();
    a.css({
        left: d.left - a.width() + 30,
        top: d.top + 24
    });
    a.show();
    a.data("timer", setTimeout(function () {
        a.hide()
    }, 5000))
}

function delSub(a) {
    if (!confirm("是否删除子帐号 " + a + "？")) {
        return
    }
    $.post("delete", {
        adminid: a
    }, function () {
        location.reload()
    })
}

function createdata(date,gid) {
    $.ajax({
        url: "createdata",
        data: {date: date,gid:gid},
        cache: false,
        timeout: 15000,
        success: function () {
            location.reload();
        }
    })
}

function cleardata(date,gid) {
    $.ajax({
        url: "clear",
        data: {date: date,gid:gid},
        cache: false,
        timeout: 15000,
        success: function () {
            location.reload();
        }
    })
}

function clearall(fast) {
    var r = confirm('请确定是否清除所有开奖数据？');
    if(!r){
        return
    }
    var r1 = confirm('请再次确认是否清除所有开奖数据？');
    if(!r1){
        return
    }
    $.ajax({
        url: "clearall",
        data: {fast: fast},
        cache: false,
        timeout: 15000,
        success: function (f) {
            if(f.success){
                alert("清理成功");
                location.reload();
            }else{
                alert(f.message);
            }
        }
    })
}

function yijianjiesuan() {
    var r = confirm('请确定是否一键结算？');
    if(!r){
        return
    }
    var r1 = confirm('请再次确认是否请确定是否一键结算？');
    if(!r1){
        return
    }
    $.ajax({
        url: "yijianjiesuan",
        data: {},
        cache: false,
        timeout: 15000,
        success: function (f) {
            if(f.success){
                alert("操作成功");
            }else{
                alert(f.message);
            }
        }
    })
}

function tongbugf(date,gid) {
    $.ajax({
        url: "tongbugf",
        data: {date: date,gid:gid},
        cache: false,
        timeout: 15000,
        success: function (f) {
            if(f.success){
                alert("同步成功");
                location.reload();
            }else{
                alert(f.message);
            }
        }
    })
}

function createbydays(gid) {
    //根据输入的天数创建数据
    var days = $("#days").val();
    $.ajax({
        url: "createbydays",
        data: {days: days,gid:gid},
        cache: false,
        timeout: 15000,
        success: function (f) {
            if(f.success){
                alert("已提交任务等待中");
            }else{
                alert(f.message);
            }
        }
    })
}

function yijiantongbugf(gid) {
    //根据输入的天数创建数据
    var days = $("#days").val();
    $.ajax({
        url: "yijiantongbugf",
        data: {days: days,gid:gid},
        cache: false,
        timeout: 15000,
        success: function (f) {
            if(f.success){
                alert("已提交任务等待中");
            }else{
                alert(f.message);
            }
        }
    })
}

function loadqgc() {
    $.ajax({
        url: "loadqgc",
        data: {},
        cache: false,
        timeout: 15000,
        success: function (f) {
            if(f.success){
                alert("加载成功");
            }else{
                alert(f.message);
            }
        }
    })
}

function loadlhc() {
    $.ajax({
        url: "loadlhc",
        data: {},
        cache: false,
        timeout: 15000,
        success: function (f) {
            if(f.success){
                alert("加载成功");
                location.reload();
            }else{
                alert(f.message);
            }
        }
    })
}

function saveSub() {
    if (!confirm("是否写入子帐号？")) {
        return
    }
    var a = $("#saveForm").formData();
    $.ajax({
        url: "edit",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(a),
        success: function (b) {
				b= eval("("+b+")");
            if (b.success) {
                alert("子帐号写入成功");
                back()
            } else {
                alert(b.message)
            }
        }, error: function () {
            alert("error")
        }
    })
};
function saveSub2() {
    if (!confirm("是否写入子帐号？")) {
        return
    }
    var a = $("#saveForm").formData();
    $.ajax({
        url: "saveSub2",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(a),
        success: function (b) {
				b= eval("("+b+")");
            if (b.success) {
                alert("子帐号写入成功");
                back()
            } else {
                alert(b.message)
            }
        }, error: function () {
            alert("error")
        }
    })
};

function querygamelist() {
    console.log('2222222222',$("input[name='fenlei']").val())
    location.href = LIBS.url({
        gname: $("input[name='gname']").val(),
        fenlei: $("input[name='fenlei']").val(),
        fast: $("input[name='fast']").val(),
    })
};
