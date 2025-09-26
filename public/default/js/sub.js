function back() {
    //location.href = "./user/subs"
	window.history.back(-1);
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
    $.post("delSub", {
        passname: a
    }, function () {
        location.reload()
    })
}

function kick(a) {
    $.ajax({
        url: "../kick",
        data: {
            id: a
        },
        cache: false,
        timeout: 15000,
        complete: function () {
            location.reload()
        }
    })
}

function saveSub(a) {
    saveSub(a, null)
}
function saveSub(b, a) {
    if (!confirm("是否写入子帐号？")) {
        return
    }
    var c = $("#saveForm").formData();
    c.mainTransferPassword = a;
    c.isNew = b;
    $.ajax({
        url: "saveSub",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(c),
        success: function(d) {
            if (d.success) {
                alert("子帐号写入成功");
                back()
            } else {
                alert(d.message)
            }
        },
        error: function() {
            alert("error")
        }
    })
}
function openInputTransferPasswordDialogSaveSub(a) {
    var b = $("#transferPasswordDialogue");
    if (b.length == 0) {
        b = $('<div id="transferPasswordDialogue">').addClass("popdiv");
        b.dialog({
            autoOpen: false,
            width: 550
        })
    }
    b.dialog("option", {
        title: "请输入操作密码"
    });
    b.empty();
    b.append('<table class="list data_table info_table"><tr><th>操作密码</th><td><input id="inputTransferPassword" type="password" class="input" /></td></tr></table><div style="position:absolute;right:20px;bottom:20px;"><input id="transferOk" type="button" value="确定" /></div>');
    b.dialog("open");
    $("#transferOk").click(function() {
        var c = $("input[id='inputTransferPassword']").val();
        if (c == null || c.trim() == "") {
            alert("请输入操作密码！");
            return
        }
        $("#transferPasswordDialogue").dialog("close");
        saveSub(a, c)
    })
}
;
