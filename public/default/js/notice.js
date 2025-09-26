function save() {
    "" == $("textarea[name=text]").val() ? alert("请填写公告内容！") : confirm("确定写入公告吗？") && $.ajax({
        url: "save",
        type: "POST",
        dataType: "json",
        data: {content:$("textarea[name=text]").val(),
            agent:$("select[name=visibleId]").val(),
            id:$("#newsid").val(),
            ifok:$("#ifok").prop('checked') ? 1 : 0,
            alert:$("#alert").prop('checked') ? 1 : 0,
            gundong:$("#gundong").prop('checked') ? 1 : 0,},
        success: function (e) {
            e && e.success ? (alert("公告保存成功"), location.href = LIBS.url("list", {username: $("input[name=username]").val()})) : e && alert(e.message)
        }
    })
}

function del(e, a) {
    confirm("确定删除公告吗？") && $.ajax({
        url: "delete",
        type: "POST",
        data: {id: e, username: a},
        success: function () {
            alert("公告删除成功"), location.href = "list"
        }
    })
}

function edit(id,agent,ifok,alert,gundong, content) {
    $("textarea[name=text]").val(content);
    $("#newsid").val(id);
    $("select[name=visibleId]").val(agent);
    ifok == 1 ? $("#ifok").prop('checked',ifok) : $("#ifok").prop('checked',false);
    alert == 1 ? $("#alert").prop('checked',alert) : $("#alert").prop('checked',false);
    gundong == 1 ? $("#gundong").prop('checked',gundong) : $("#gundong").prop('checked',false);
}

$(function () {
    $("#username").change(function () {
        location.href = LIBS.url({username: $(this).val()})
    }), $.fn.datetimepicker && $("#created").datetimepicker({showSecond: !0, timeFormat: "hh:mm:ss"})
});
