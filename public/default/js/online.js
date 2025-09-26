$(function () {
    LIBS.colorMoney("td.colorMoney a", "minus", "plus");
    $("#username").change(function () {
        location.href = LIBS.url({
            username: $(this).val()
        })
    })
});

function kick(b, a) {
    $.ajax({
        url: "kick",
        data: {
            id: b,
            platform: a
        },
        type: "POST",
        success: function () {
            location.reload()
        }, error: function (d, c) {
            if (c == "timeout") {
                alert("网络超时")
            } else {
                if (c == "error") {
                    if (d.status == 503) {
                        alert("系统繁忙")
                    } else {
                        alert("发生错误：" + d.status)
                    }
                }
            }
        }
    })
};