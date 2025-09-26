/*/////会员抓取
$(function() {
var tr=$("tr");
console.log(tr.length);
	var user=[];
	for(var i=1;i<tr.length-2;i++){

		var  sj=tr.eq(i).children('td').eq(2).text().replace(/(^\s*)|(\s*$)/g, "");
		var name=tr.eq(i).children('td').eq(4).text().replace(/(^\s*)|(\s*$)/g, "");
	    var jb=tr.eq(i).children('td').eq(3).text().replace(/(^\s*)|(\s*$)/g, "");
		var ed=	tr.eq(i).children('td').eq(5).text().replace(/(^\s*)|(\s*$)/g, "");
		var arr=[name,sj,jb,ed];
		////console.log(sj);		console.log(name);
		 user[i]=arr;
	}
console.log(user);

});


*/

///////
var disableShare;
function changePtype(a) {
    changeUrl("", a)
}

function zdelete(ruid,userid,username) {
    //获取弹窗输入的值
    var pass = prompt("请输入密码", "");
    if(!pass){
        alert("请输入密码");
        return;
    }
    if(window.confirm('你确定要删除：'+username+'及下级所有账户？此操作不可逆，请谨慎操作！！')){
        $.post("zh_delete", {ruid: ruid,userid: userid,pass:pass},
            function (d) {
                if (d.success) {
                    location.reload()
                } else {
                    alert(d.message);
                }
        })
    }
}

function loginRetryCountReset(a) {
    $.ajax({
        url: "resetLoginRetryCount",
        type: "POST",
        loading: true,
        data: {
            username: a
        },
        success: function (b) {
            if (b.success) {
                alert("成功重置错误登录次数。");
                $("#loginRetryCount").html("0")
            } else {
                alert(b.message)
            }
        }, error: function () {
            alert("error")
        }
    })
}

function saveUser() {
    if (!confirm("是否确定写入该帐号吗？")) {
        return
    }
    var e = $("#saveForm").formData();
    var c = e.ipFilter;
    var b = [];
    for (var d in e.account) {
        var i = e.account[d];
        i.type = d;
        b.push(i)
    }
    delete e.account;
    var g = [];
    for (var d in e.shares) {
        var m = e.shares[d];
        m.lotterySubType = d;
        g.push(m)
    }
    delete e.shares;
    var j = e.commission;
    delete e.commission;
    var f = e.lotterys;
    delete e.lotterys;
    var l = e.odds;
    delete e.odds;
    var h = e.productGame;
    delete e.productGame;
    e.range = $('#saveForm input[name="range"]:checked').map(function() {
        return $(this).val()
    }).get().join("");
    e.maxoddPass = $('#saveForm input[name="maxodd"]:checked').map(function () {
        return $(this).val()
    }).get().join("");
    $.ajax({
        url: "save",
        type: "POST",
        loading: true,
        contentType: "application/json",
        data: JSON.stringify({
            update: isupdate,
            user: e,
            shares: g,
            accounts: b,
            commission: j,
            ipFilter: c,
            lotterys: f,
            odds: l,
            productGame: h
        }),
        success: function(a) {
            if(!a){
                    alert("数据错误。");
                    back()
            }
			a= eval("("+a+")");
            if (a.success) {
                if (isupdate) {
                    alert("帐户已成功修改。");
                    back()
                } else {
                    back()
                }
            } else {
                if (a.status == "force") {
                    var k = confirm(a.message);
                    if (k == true) {
                        $.ajax({
                            url: "save/confirm",
                            type: "POST",
                            loading: true,
                            contentType: "application/json",
                            data: JSON.stringify({
                                update: isupdate,
                                user: e,
                                shares: g,
                                accounts: b,
                                commission: j,
                                ipFilter: c,
                                lotterys: f,
                                odds: l,
                                productGame: h
                            }),
                            success: function (n) {
                                if (n.success) {
                                    if (isupdate) {
                                        alert("帐户已成功修改。");
                                        back()
                                    } else {
                                        if (confirm("保存成功，是否设置退水？")) {
                                            location.href = LIBS.url("param?", {
                                                username: n.data,
                                                back: LIBS.getUrlParam("back")
                                            })
                                        } else {
                                            back()
                                        }
                                    }
                                } else {
                                    alert(n.message)
                                }
                            }, error: function () {
                                alert("error")
                            }
                        })
                    }
                } else {
                    alert(a.message)
                }
            }
        }, error: function () {
            alert("error")
        }
    })
}
function changeUrl(b, c) {
    var a = location.pathname + "?type=" + $("#saveForm input[name=type]").val();
    if (b) {
        a += "&parent=" + b
    }
    if (c) {
        a += "&ptype=" + c
    }
    a += "&backUrl=" + encodeURIComponent(backUrl);
    location.href = a
}
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
}
function moneyToDX(b) {
    if (!b) {
        return ""
    }
    b = Number(b.split(",").join(""));
    if (isNaN(b) || b <= 0) {
        return ""
    }
    b = Math.floor(b);
    var a = "一二三四五六七八九";
    var g = ["十", "百", "千"];
    var l = "";
    b = b + "";
    var j = 0;
    for (var d = 0; d < b.length; d++) {
        var e = Number(b.charAt(d));
        var f = b.length - d - 1;
        var h = "";
        if (f != 0) {
            var k = f / 4;
            f = f % 4;
            if (f == 0) {
                if (k % 2 == 0) {
                    h = "亿"
                } else {
                    h = "万"
                }
            } else {
                h = g[f - 1];
                if (j == 0 && e != 0) {
                    j = e
                }
            }
        }
        if (e == 0) {
            if (f == 0 && j != 0) {
                l += h;
                j = 0
            }
            continue
        }
        if (f == 0 && j != 0) {
            j = 0
        }
        if (d > 0 && b.charAt(d - 1) == 0) {
            l += "零"
        }
        l += a.charAt(e - 1) + h
    }
    if (l.indexOf("一十") == 0) {
        l = l.substr(1)
    }
    return l
}
function showChangeStatusPanel(c, d, b) {
    if (transferPasswordEnabled == "true" && newTransferPasswordRequired == "true" && transferPasswordIPEnabled == "true") {
        var a = $("#setupTransferPasswordDialogueNew");
        if (a.length == 0) {
            a = $('<div id="setupTransferPasswordDialogueNew">').addClass("popdiv");
            a.dialog({
                autoOpen: false,
                width: 550
            })
        }
        a.dialog("option", {
            title: "设置操作密码"
        });
        a.empty();
        a.append('<table class="list data_table info_table"><tr><th>操作密码</th><td><input id="transferPassword" type="password" class="input" /></td></tr><tr><th>确认操作密码</th><td><input id="ckTransferPassword" type="password" class="input" /></td></tr></table><div style="position:absolute;right:20px;bottom:20px;"><input id="setupOk" type="button" value="确定" /></div>');
        a.dialog("open");
        $("#setupOk").click(function() {
            $("#setupTransferPasswordDialogueNew").dialog("close");
            var f = $("input[id='transferPassword']").val();
            if (f == null || f.trim() == "") {
                alert("请输入操作密码！");
                return
            }
            var f = $("#transferPassword").val();
            var e = $("#ckTransferPassword").val();
            var g = checkPassword("", f, e, false);
            if (!g) {
                return
            }
            $.post("/agent/setupTransferPassword", {
                transferPassword: f
            }, function(h) {
                if (h.success) {
                    alert("操作密码设置成功。");
                    newTransferPasswordRequired = "false";
                    showChangeStatusPanelCheck(c, d, b)
                } else {
                    showMsg(h.message);
                    $("#transferPassword").focus()
                }
            })
        })
    } else {
        if (transferPasswordEnabled == "true" && newTransferPasswordRequired == "false" && transferPasswordIPEnabled == "true") {
            var a = $("#transferPasswordDialogueListUser");
            if (a.length == 0) {
                a = $('<div id="transferPasswordDialogueListUser">').addClass("popdiv");
                a.dialog({
                    autoOpen: false,
                    width: 550
                })
            }
            a.dialog("option", {
                title: "请输入操作密码"
            });
            a.empty();
            a.append('<table class="list data_table info_table"><tr><th>操作密码</th><td><input id="inputTransferPassword" type="password" class="input" /></td></tr></table><div style="position:absolute;right:20px;bottom:20px;"><input id="transferOk" type="button" value="确定" /></div>');
            a.dialog("open");
            $("#transferOk").click(function() {
                var e = $("input[id='inputTransferPassword']").val();
                if (e == null || e.trim() == "") {
                    alert("请输入操作密码！");
                    return
                }
                $("#transferPasswordDialogueListUser").dialog("close");
                $("#btnOK").prop("disabled", true);
                $.ajax({
                    url: "/agent/user/checkTransferPassword",
                    method: "POST",
                    timeout: 15000,
                    data: {
                        transferPassword: e
                    },
                    loading: true,
                    success: function(f) {
                        if (f.success) {
                            showChangeStatusPanelCheck(c, d, b)
                        } else {
                            alert("操作失败！\n" + f.message);
                            $("#btnOK").prop("disabled", false)
                        }
                    },
                    error: function() {
                        alert("网络异常，请检查后重试。");
                        $("#btnOK").prop("disabled", false)
                    }
                })
            })
        } else {
            showChangeStatusPanelCheck(c, d, b)
        }
    }
}
function showChangeStatusPanelCheck(c, f, b) {
    var a = $("#statusPanel");
    if (a.length == 0) {
        a = $('<div id="statusPanel">').addClass("popdiv").appendTo($("body"));
        a.append($("<div>").addClass("title").text("修改帐户状态").append("<i>"));
        var e = $("<div>").addClass("statuslist").appendTo(a);
        $("<label>").append($('<input name="ustatus" type="radio">').val("0")).append("启用").appendTo(e);
        $("<label>").append($('<input name="ustatus" type="radio">').val("1")).append("冻结").appendTo(e);
        $("<label>").append($('<input name="ustatus" type="radio">').val("2")).append("停用").appendTo(e);
        a.find(".title i").click(function() {
            clearTimeout(a.data("timer"));
            a.hide()
        });
        e.find("input").click(function() {
            var h = $("#statusPanel").hide().data("status");
            var g = $(this).val();
            if (g == h) {
                return
            }
            $.get("status", {
                username: $("#statusPanel").data("username"),
                status: g
            },
            function() {
                location.reload()
            })
        })
    }
    clearTimeout(a.data("timer"));
    a.data("username", f).data("status", b);
    a.find("input[value=" + b + "]").prop("checked", true);
    var d = $(c).position();
    a.css({
        left: d.left - a.width() + 30,
        top: d.top + 24
    });
    a.show();
    a.data("timer", setTimeout(function() {
        a.hide()
    },
    5000))
}
function kick(a) {
    $.ajax({
        url: "../kick",
        data: {
            id: a,
            all: true
        },
        cache: false,
        timeout: 15000,
        complete: function() {
            location.reload()
        }
    })
}
function showValidateMsg(a, b, c) {
    if (a) {
        $(b).html('<em class="success">' + c + "</em>")
    } else {
        $(b).html('<em class="error">' + c + "</em>")
    }
}
$(function() {
    if ($.fn.datetimepicker) {
        $("#date input").datetimepicker()
    }
    if ($.fn.datetimepicker) {
        $("#logoutDate input").datetimepicker()
    }
    $("#parent").change(function() {
        var c = $("#saveForm input[name=ptype]:checked").val();
        changeUrl($(this).val(), c)
    });
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
    $("input[name=username]").change(function() {
        LIBS.get("check", {
            username: $(this).val(),
            parent: $("input[name=parent]").val()
        },
        function(c) {
            if (!c) {
                showValidateMsg(true, "#usernameMsg", "账号可用")
            } else {
                showValidateMsg(false, "#usernameMsg", c)
            }
        })
    });
    $("input.account").keyup(function() {
        var c = $(this);
        $("#dx" + c.attr("name").split(".")[1]).text(moneyToDX(c.val()))
    }).keyup();
    if (disableShare) {
        $(".user_panel .shareControl input").prop("disabled", true)
    }
    $("td.account a").click(function() {
        $("td.account .popdiv").hide();
        $(this).parent().children(".popdiv").show();
        $(".max_limit").show();
        $(".edit_amount").hide()
    });
    $(".popdiv .title i").click(function() {
        $(this).closest(".popdiv").hide()
    });
    if ($("#lotterys").length != 0) {
        var a = LIBS.toMap(lotterys);
        var h = lotterys.split(";");
        lotterys = [];
        for (var d = 0; d < h.length; d++) {
            if (!h[d]) {
                continue
            }
            var g = h[d].split("=", 2);
            lotterys.push({
                id: g[0],
                name: g[1]
            })
        }
        var e = function(n) {
            var k = n;
            if (n === undefined) {
                k = $("#lotterys input[name=lotterys]").val()
            } else {
                $("#lotterys input[name=lotterys]").val(n)
            }
            var o = "";
            if (k.length == 0) {
                o = "(与上级相同) ";
                for (var m = 0; m < lotterys.length; m++) {
                    o += lotterys[m].name + "、"
                }
            } else {
                k = k.split(",");
                for (var m = 0; m < k.length; m++) {
                    var c = k[m];
                    o += a[c] + "、"
                }
            }
            o = o.substr(0, o.length - 1);
            $("#lotterys span").text(o)
        };
        $("#lotterys input:button").click(function() {
            chooseLotterys(lotterys, $("#lotterys input[name=lotterys]").val(), e)
        });
        e()
    }
    $("td.op a,td.new a,.top_info .center a").each(function() {
        var c = $(this);
        var i = c.attr("href");
        if (!i || i.indexOf("javascript:") == 0 || i[0] == "#") {
            return
        }
        i = LIBS.url(i, {
            back: LIBS.url({
                back: "",
                _: ""
            })
        });
        c.attr("href", i)
    });
    $(".tab a").each(function() {
        var c = $(this);
        var i = c.attr("href");
        if (!i || i.indexOf("javascript:") == 0 || i[0] == "#") {
            return
        }
        i = LIBS.url(i, {
            back: LIBS.getUrlParam("back") || LIBS.url({
                _: ""
            })
        });
        c.attr("href", i)
    });
    $(".share_panel input").focus(function() {
        var c = $(this);
        if (c.val() == "0") {
            c.val("")
        }
    }).blur(function() {
        var c = $(this);
        if (c.val() == "") {
            c.val("0")
        }
    });
    $("input.date").datepicker();
    $(".share a").click(function() {
        var c = $("#shares");
        if (c.length == 0) {
            c = $('<div id="shares">').addClass("popdiv");
            c.dialog({
                autoOpen: false,
                width: 500,
                maxHeight: 400
            })
        }
        var k = $(this).attr("username");
        var i = $(this).attr("userid");
        c.dialog("option", {
            title: k + "# 占成明细"
        });
        c.empty();
        c.append('<span class="loading">载入中……</span>').load("shares", {
            userid: i
        });
        c.dialog("open")
    });
    $(".account a").click(function () {
        var c = $(this).attr("userid");
        var i = $(this).attr("type");
        var ruid = $(this).attr("ruid");
        openAccountEditDialogue(c, i,ruid)
    });
    $(".user_panel td.account").each(function() {
        var c = $(this).children("span");
        c.eq(1).text(moneyToDX(c.eq(0).text()))
    });
    $('[name="shareMode"]').click(function() {
        if (!isupdate) {
            return
        }
        /*if (confirm("更改占成模式 将会把所有下线占成设置为 0")) {
            $(".shareMode0,.shareMode1").find('input[type="number"]').val(0)
        } else {
            return false
        }*/
    });
    function b(c) {
        switch (c) {
        case "1":
            $(".shareMode0").hide();
            $(".shareMode1").show();
            break;
        default:
            $(".shareMode1").hide();
            $(".shareMode0").show();
            break
        }
    }
    $('[name="shareMode"]').change(function() {
        var i = $('input[name="shareMode"]:checked').val();
        var c;
        if (i) {
            c = i
        } else {
            c = $('input[name="shareMode"]').val()
        }
        b(c)
    });
    $('[name="shareMode"]').change()
});

function openAccountEditDialogue(b, c,ruid) {
    var a = $("#account");
    if (a.length == 0) {
        a = $('<div id="account">').addClass("popdiv");
        a.dialog({
            autoOpen: false,
            width: 410
        })
    }
    a.dialog("option", {
        title: b + "# 充值操作"
    });
    a.empty();
    a.append('<span class="loading">载入中……</span>').load("account", {
        userid: b,
        type: c,
        ruid: ruid
    }, function () {
        a.find("input.input").keyup(function () {
            $("#popDx").text(moneyToDX($(this).val()))
        })
    });
    a.dialog("open")
}

function validateEditAccount(b, a) {
    if (a == null || a.trim() == "") {
        alert("请选择类型！");
        return false;
    }
    if (b <= 0 || isNaN(b)) {
        alert("请输入金额！");
        return false;
    }
    return true;
}

function openInputTransferPasswordDialog(g, e, f) {
    if (f) {
        var d = Number($("input[name='balance']").val());
        var c = $("input[name='types']:checked").val();
        if (!validateEditAccount(d, c)) {
            return
        }
    }
    if (transferPasswordIPEnabled == "true") {
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
            var h = $("input[id='inputTransferPassword']").val();
            if (h == null || h.trim() == "") {
                alert("请输入操作密码！");
                return
            }
            $("#transferPasswordDialogue").dialog("close");
            if (f) {
                editAccount(g, e, d, c, h)
            } else {
                extractAccount(g, e, h, h)
            }
        })
    } else {
        var a = $("input[id='inputTransferPassword']").val();
        if (a == null || a.trim() == "") {
            a = ""
        }
        if (f) {
            editAccount(g, e, d, c, a)
        } else {
            extractAccount(g, e, a, a)
        }
    }
}
function saveUserValidateTransferPassword(f) {
    console.log(f);
    var e = $("#saveForm").formData();
    var c = false;
    for (var d in e.account) {
        var b = e.account[d];
        if (b.maxLimit > 0) {
            c = true
        }
    }
    if (isAddUser == "true") {
        if (c && f && needNewTransferPassword && transferPasswordIPEnabled == "true") {
            saveTransferPassword()
        } else {
            if (c && f && !needNewTransferPassword && transferPasswordIPEnabled == "true") {
                saveUserWithCheckTransferPassword()
            } else {
                saveUser()
            }
        }
    } else {
        if (f && needNewTransferPassword && transferPasswordIPEnabled == "true") {
            saveTransferPassword()
        } else {
            if (f && !needNewTransferPassword && transferPasswordIPEnabled == "true") {
                saveUserWithCheckTransferPassword()
            } else {
                saveUser()
            }
        }
    }
}
function setupTransferPasswordSaveNew() {
    var b = $("#transferPassword").val();
    var a = $("#ckTransferPassword").val();
    var c = checkPassword("", b, a, false);
    if (!c) {
        return
    }
    $.post("/agent/setupTransferPassword", {
        transferPassword: b
    }, function(d) {
        if (d.success) {
            alert("操作密码设置成功。");
            needNewTransferPassword = false;
            saveUser()
        } else {
            showMsg(d.message);
            $("#transferPassword").focus()
        }
    })
}
function saveTransferPassword() {
    var a = $("#setupTransferPasswordDialogueNew");
    if (a.length == 0) {
        a = $('<div id="setupTransferPasswordDialogueNew">').addClass("popdiv");
        a.dialog({
            autoOpen: false,
            width: 550
        })
    }
    a.dialog("option", {
        title: "设置操作密码"
    });
    a.empty();
    a.append('<table class="list data_table info_table"><tr><th>操作密码</th><td><input id="transferPassword" type="password" class="input" /></td></tr><tr><th>确认操作密码</th><td><input id="ckTransferPassword" type="password" class="input" /></td></tr></table><div style="position:absolute;right:20px;bottom:20px;"><input id="setupOk" type="button" value="确定" /></div>');
    a.dialog("open");
    $("#setupOk").click(function() {
        $("#setupTransferPasswordDialogueNew").dialog("close");
        var b = $("input[id='transferPassword']").val();
        if (b == null || b.trim() == "") {
            alert("请输入操作密码！");
            return
        }
        setupTransferPasswordSaveNew()
    })
}
function saveUserWithCheckTransferPassword() {
    var a = $("#transferPasswordDialogue");
    if (a.length == 0) {
        a = $('<div id="transferPasswordDialogue">').addClass("popdiv");
        a.dialog({
            autoOpen: false,
            width: 550
        })
    }
    a.dialog("option", {
        title: "请输入操作密码"
    });
    a.empty();
    a.append('<table class="list data_table info_table"><tr><th>操作密码</th><td><input id="inputTransferPassword" type="password" class="input" /></td></tr></table><div style="position:absolute;right:20px;bottom:20px;"><input id="transferOk" type="button" value="确定" /></div>');
    a.dialog("open");
    $("#transferOk").click(function() {
        var b = $("input[id='inputTransferPassword']").val();
        if (b == null || b.trim() == "") {
            alert("请输入操作密码！");
            return
        }
        $("#transferPasswordDialogue").dialog("close");
        checkTransferPassword(b)
    })
}
function checkTransferPassword(a) {
    $("#btnOK").prop("disabled", true);
    $.ajax({
        url: "/agent/user/checkTransferPassword",
        method: "POST",
        timeout: 15000,
        data: {
            transferPassword: a
        },
        loading: true,
        success: function(b) {
            if (b.success) {
                saveUser()
            } else {
                alert("操作失败！\n" + b.message);
                $("#btnOK").prop("disabled", false)
            }
        },
        error: function() {
            alert("网络异常，请检查后重试。");
            $("#btnOK").prop("disabled", false)
        }
    })
}
function adminEditAccount(d, c,ruid) {
    var b = Number($("input[name='balance']").val());
    var a = $("input[name='types']:checked").val();
    if(!validateEditAccount(b, a)){
        return;
    }
    editAccount(d, c, b, a, "",ruid)
}

function editAccount(e, d, c, b, a,ruid) {
    if (!confirm("是否确定修改额度吗？")) {
        return
    }
    $("#btnOK").prop("disabled", true);
    $.ajax({
        url: "/agent/user/editAccount",
        method: "POST",
        timeout: 15000,
        data: {
            value: c,
            updatetype: b,
            userid: e,
            type: d,
            transferPassword: a,
            ruid: ruid
        },
        loading: true,
        success: function (f) {
			f= eval("("+f+")");
            if (f.success) {
                alert("操作成功！");
                location.href = location.href
            } else {
                alert("操作失败！\n" + f.message);
                $("#btnOK").prop("disabled", false)
            }
        },
        error: function() {
            alert("网络异常，请检查后重试。");
            $("#btnOK").prop("disabled", false)
        }
    })
}
function extractAccount(c, b, a) {
    if (!confirm("是否确定抽取额度吗？")) {
        return
    }
    $("#btnOK").prop("disabled", true);
    $.ajax({
        url: "/agent/user/extractAccount",
        method: "POST",
        data: {
            username: c,
            type: b,
            transferPassword: a
        },
        timeout: 15000,
        loading: true,
        success: function (d) {
			d= eval("("+d+")");
            if (d.success) {
                alert("抽取成功！");
                location.href = location.href
            } else {
                alert("抽取失败！\n" + d.message);
                $("#btnOK").prop("disabled", false)
            }
        }, error: function () {
            alert("网络异常，请检查后重试。");
            $("#btnOK").prop("disabled", false)
        }
    })
}
function chooseLotterys(g, c, k) {
    var a = $("#lotteryChoose");
    if (a.length == 0) {
        a = $('<div id="lotteryChoose"></div>').appendTo("body");
        a.append("<ul>").append("<p>注：可拖动彩种位置来改变彩种排序。</p>");
        a.dialog({
            modal: true,
            title: "选择显示彩种",
            autoOpen: false,
            buttons: {
                "确定": function() {
                    var l = $(this);
                    var j = [];
                    l.find("ul input:checked").each(function() {
                        j.push($(this).val())
                    });
                    l.dialog("close");
                    var i = l.data("callback");
                    if ($.isFunction(i)) {
                        i(j.join(","))
                    }
                },
                "取消": function() {
                    $(this).dialog("close")
                }
            }
        })
    }
    a.data("callback", k);
    var h = a.find("ul").empty();
    var f = [];
    if (c) {
        g = g.slice(0);
        c = c.split(",");
        for (var e = 0; e < c.length; e++) {
            for (var d = 0; d < g.length; d++) {
                var b = g[d];
                if (b != null && b.id == c[e]) {
                    f.push(b);
                    g[d] = null;
                    break
                }
            }
        }
    } else {
        for (var e = 0; e < g.length; e++) {
            f.push(g[e])
        }
        g = []
    }
	//console.log(f);console.log(g);
    for (var e = 0; e < f.length; e++) {
        var b = f[e];
        $('<li><input type="checkbox" checked="checked" value="' + b.id + '">' + b.name + "</li>").appendTo(h)
    }
    for (var e = 0; e < g.length; e++) {
        var b = g[e];
        if (b != null) {
            $('<li><input type="checkbox" value="' + b.id + '">' + b.name + "</li>").appendTo(h)
        }
    }
    h.sortable().disableSelection();
    a.dialog("open")
}
function updateAccount(d, e, c, b) {
    var a = $("#updateAccountPanel");
    if (a.length == 0) {
        a = $('<div id="updateAccountPanel"><div class="title">赢额提取</div><div class="panel">金额：<input /></div><div class="bottom"><input type="button" value="确定" /><input type="button" value="取消" /></div></div>').appendTo("body");
        a.find(".bottom input").click(function() {
            if ($(this).index() == 0) {
                var g = Number($(".panel input").val());
                if (isNaN(g) || g <= 0) {
                    alert("输入不正确。");
                    return
                }
                var f = a.data("d");
                $.post("updateAccount", {
                    username: f.u,
                    type: f.t,
                    value: 0 - g
                },
                function(h) {
                    if (h && h.success) {
                        alert("提取成功");
                        if (f.b) {
                            location.href = f.b
                        } else {
                            location.href = location.href
                        }
                    } else {
                        if (h.message) {
                            alert(h.message)
                        } else {
                            alert("提取错误")
                        }
                    }
                })
            }
            $("#updateAccountPanel").hide()
        })
    }
    a.data("d", {
        u: e,
        t: c,
        b: b
    }).show().position({
        of: d,
        at: "bottom",
        my: "top"
    });
    a.find(".panel input").val("").focus()
}
function updateMaxlimit(c, a, d) {
    var b = $(c).parent().find("input[type='text']").val();
    if (!confirm("是否确定进行该操作？")) {
        return
    }
    $.ajax({
        url: "updateAccount",
        type: "POST",
        loading: true,
        data: {
            type: a,
            username: d,
            value: b
        },
        success: function(f) {
            if (f.success) {
                var e = "快开彩";
                if (a == 1) {
                    e = "全国彩"
                } else {
                    if (a == 2) {
                        e = "香港彩"
                    }
                }
                alert(e + "额度成功修改。")
            } else {
                alert(f.message)
            }
        },
        error: function() {
            alert("error")
        }
    })
}
function closeMaxlimit(a, b) {
    $(".btn_input" + a + "").hide();
    $(".limit_" + b + "_" + a + "").show()
}
function hideAccount(a, b) {
    $(".btn_input" + a + "").show();
    $(".limit_" + b + "_" + a + "").hide()
}
function isNumber(b) {
    b = (b) ? b: window.event;
    var a = (b.which) ? b.which: b.keyCode;
    if (a > 31 && (a < 46 || a > 57)) {
        return false
    }
    return true
}
function exportXlsUserList(a) {
    var b = a.split("?");
    window.open("/agent/user/list/export/?" + b[1])
}
function resetProp(b) {
    var c = $("input[name=username]").val();
    var a = ["手机", "邮箱", "提款密码", "微信号", "安全提示问题答案", "二次验证"][b];
    if (!confirm("是否重置 " + c + " 的" + a + "？")) {
        return
    }
    $.ajax({
        url: "reset",
        method: "POST",
        data: {
            username: c,
            type: b
        },
        loading: true,
        success: function(d) {
			d=eval('('+d+')');
            if (d && d.success) {
                alert("已重置" + c + "的" + a + "。");
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
var param = "";
var username = "";
function showAPIDialog(a) {
    $("#apiBalance").text("0");
    $("#transferButton").html("");
    param = "username=" + a;
    username = a;
    var b = $("#apiDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 410,
        title: a + " - 棋牌余额",
        open: function() {
            loadAPIBalance()
        }
    });
    b.dialog("open")
}
function loadAPIBalance() {
    getJSONData("/web/rest/gameCard/getUserInfo", getUserBalance, param)
}
function getUserBalance(a) {
    var b = a.result.data;
    if (b && b.freeMoney > 0) {
        $("#apiBalance").html(parseFloat(b.freeMoney));
        generateTransferButton()
    }
}
function generateTransferButton() {
    $("#transferButton").html("<input type='button' onclick='transferAllToMainAccount()' value='一键收回'/>")
}
function transferAllToMainAccount() {
    swal({
        title: "是否确定收回棋牌余额?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(a) {
        if (a) {
            getJSONData("/web/rest/gameCard/amountTransferAllToMain", amountTransferAllToMain, param)
        }
    })
}
function amountTransferAllToMain() {
    var a = parseFloat($("#lbl_" + username).text()) + parseFloat($("#apiBalance").text());
    $("#lbl_" + username).text(a);
    $("#apiBalance").text("0");
    $("#transferButton").html("");
    swal("余额已全部收回")
}
function queryLoginLogs() {
    location.href = LIBS.url({
        userid: $("#userid").val(),
        begin: $("#begin").val(),
        end: $("#end").val(),
        logoutBegin: $("#logoutBegin").val(),
        logoutEnd: $("#logoutEnd").val(),
        ip: $("input[name='ip']").val(),
        ipAdd: $("input[name='ipAdd']").val(),
        logoutType: $("input[name='logoutType']").val()
    })
}
function enableDownline(a) {
    loadingStart();
    $.get("enableDownline", {
        username: a
    }, function(b) {
        loadingEnd();
        if (b.success) {
            alert("正在为您启用下线用户,详细进度请查看一键启用报表。");
            location.reload()
        } else {
            alert(b.message)
        }
    })
}
;
