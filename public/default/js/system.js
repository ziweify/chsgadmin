$(function () {
    $("#lines .removeRowBtn").click(function () {
        $(this).closest("tr").remove()
    });
    $("#username").change(function () {
        location.href = LIBS.url({username: $(this).val()})
    })
});

function back() {
    history.back()
}

function addRow() {
    var a = $("#lines tbody tr:last");
    a = a.clone().appendTo(a.parent());
    a.find("input:text").val("");
    a.find("a").click(function () {
        $(this).closest("tr").remove()
    })
}

function jioayan(){
    $.ajax({
        url: "system/educheck",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (f) {
            alert("校验成功")
        }
    })
}

function resetftime(){
    $.ajax({
        url: "system/resetftime",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (f) {
            alert("复盘成功")
        }
    })
}

function getipsbytype(type){
    $.ajax({
        url: "system/getipsbytype",
        type: "GET",
        data: {type:type},
        dataType: "json",
        success: function (f) {
           //赋值textarea
           var oldv = $("#ips").val();
           if(f.data.ips && f.data.ips.length>0){
                $("#ips").val(oldv+","+f.data.ips);
           }
        }
    })
}

function cleariplist(){
    $("#ips").val("");
}

function clearalldara(){
    var r = confirm('请确定是否全清？');
    if(!r){
        return
    }
    var r1 = confirm('请再次确认是否清除所有数据？');
    if(!r1){
        return
    }
    $.ajax({
        url: "system/clearalldara",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (f) {
            alert("清理成功")
        }
    })
}

function saveSetting() {
    var e = true;
    if (!confirm("是否确认保存当前设置？")) {
        return
    }
    var a = [];
    $("#lines tbody tr").each(function () {
        var f = $(this).formData();
        if (f.notes.length > 255) {
            alert("您所输入的字数已超过系统限制的字数。");
            e = false;
            return
        }
        if (f.host) {
            a.push(f)
        }
    });
    var d = [];
    var c = $("#configs").formData(false, true);
    for (var b in c) {
        d.push({key: b, value: c[b]})
    }
    if (e) {
        $.ajax({
            url: "saveSystem",
            type: "POST",
            data: {username: $("#username").val(), lines: JSON.stringify(a), configs: JSON.stringify(d)},
            success: function (f) {
                if (f && f.success) {
                    alert("保存成功")
                } else {
                    if (f && f.message) {
                        alert(f.message)
                    } else {
                        alert("保存错误")
                    }
                }
            },
            error: function () {
                alert("error")
            }
        })
    }
};
