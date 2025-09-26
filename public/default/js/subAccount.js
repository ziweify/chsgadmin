function back() {
    history.back()
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
            $.post("subAccountStatus", {
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
    $.post("delSubAccount", {
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

function saveSub() {
    if (!confirm("是否写入子帐号？")) {
        return
    }
    var a = $("#saveForm").formData();
    $.ajax({
        url: "saveSubAccount",
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
}

function querySubList(a) {
    location.href = LIBS.url({
        username: $("input[name='username']").val(),
        mainAcc: $("input[name='mainusername']").val(),
        all: a
    })
};
