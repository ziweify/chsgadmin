function resetProp(c) {
	
    var d = $("input[name=passname]").val();
    var a = $("input[name=id]").val();
    var b = ["二次验证"][c];
    if (!confirm("是否重置 " + d + " 的" + b + "？")) {
        return
    }
    $.ajax({
        url: "resetsub",
        type: "POST",
        data: {
            userpassid: a,
			username:d,
            type: c
        },
        loading: true,
        success: function (e) {
			 e = eval("("+e+")"); 
            if (e && e.success) {
                alert("已重置" + d + "的" + b + "。");
                location.href = location.href
            } else {
                if (e && e.message) {
                    alert("重置失败：" + e.message)
                } else {
                    alert("重置失败，内部错误。")
                }
            }
        }
    })
}

function saveFaCode() {
    var a = $("input[name=id]").val();
    var b = $("input[name=faCode]").val();
    var c = $("input[name=secretkey]").val();
    if (b.length == 0) {
        showMsg("请输入密码！");
        $("input[name=faCode]").focus();
        return
    }
    if (!confirm("是否确定密码？")) {
        return
    }
    $.ajax({
        url: "savefacode",
        type: "POST",
        data: {
            userpassid: a,
            facode: b,
            secretkey: c
        },
        loading: true,
        success: function (d) {
			 d = eval("("+d+")"); 
			
            if (d && d.success) {
                alert("密码更新成功。");
                location.href = location.href
            } else {
                if (d && d.message) {
                    alert("重置失败：" + d.message)
                } else {
                    alert("重置失败，内部错误。")
                }
            }
        }
    })
}

function showMsg(a) {
    if (parent && parent != window && parent.showMsg) {
        dialog.error("消息提示", a)
    } else {
        alert(a)
    }
}

function showQrLink(a) {
    var b = new Image();
    b.src = a;
    $("#divLargerImage").html(b).add($("#divOverlay")).fadeIn()
}
$(function () {
    $("#divLargerImage").add($("#divOverlay")).click(function () {
        $("#divLargerImage").add($("#divOverlay")).fadeOut(function () {
            $("#divLargerImage").empty()
        })
    })
});