var ifagent = 1;
$(function (){
    var k = {};
    var ks = {};
    var g = {};
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
        var ekk = function(n) {
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
                    if (a[c] === undefined) {
                        continue
                    }
                    o += a[c] + "、"
                }
            }
            o = o.substr(0, o.length - 1);
            $("#lotterys span").text(o)
        };
        $("#lotterys input:button").click(function() {
            chooseLotterys(lotterys, $("#lotterys input[name=lotterys]").val(), ekk)
        });
        ekk()
    }

    var e = $("#dialog_sourcelist").dialog({
        autoOpen: false,
        modal: true,
        title: "选择账号",
        width: 820,
        buttons: {
            "确定": function() {
                var m = $("input[name=source]:checked");
                var p = $("input[name=source]:not(:checked)");
                var q = ifagent;//$("#searchLvl").val();
                if (g[q] === undefined) {
                    g[q] = []
                }
                if (g[q]) {
                    m.each(function() {
                        if (!g[q].includes($(this).val())) {
                            g[q].push($(this).val())
                        }
                    });
                    p.each(function() {
                        if (g[q].includes($(this).val())) {
                            var r = g[q].indexOf($(this).val());
                            if (r !== -1) {
                                g[q].splice(r, 1)
                            }
                        }
                    })
                }
                var o = [];
                var n = [];
                for (let item in g[q]) {
                    o = o.concat(q);
                    n = n.concat(g[q][item])
                }
                $("#sourceLv").val(q);
                $("#sourceLvs").val(o.join(","));
                $("#sourceList").val(n.join(","));
                console.log(n);
                $("#sourceListStr"+ifagent).text(n.join(","));
                k = JSON.parse(JSON.stringify(g));
                e.dialog("close")
            },
            "取消": function() {
                e.dialog("close")
            }
        },
        open: function(n, o) {

            //代理部分
            var a = $("#sourceListStr1").html();
            var c = a.split(",");
            for(var i=0;i<c.length;i++){
                var j = ks[1];
                var f = c[i];
                if (j) {
                    j = j.concat(f)
                } else {
                    j = [f]
                }
                ks[1] = j;
            }

            //会员部分
            var a = $("#sourceListStr0").html();
            var c = a.split(",");
            for(var i=0;i<c.length;i++){
                var j = ks[0];
                var f = c[i];
                if (j) {
                    j = j.concat(f)
                } else {
                    j = [f]
                }
                ks[0] = j;
            }

            /*var m = $("#sourceLv").val();
            if (m) {
                $("#sourceLvl").val(m)
            }*/
            $("#sourceUsername").val("");
            g = JSON.parse(JSON.stringify(ks));
            searchDownline(function() {
                var r = ifagent;//$("#sourceLvl").val();
                var t = g[r];
                $("#searchLvl").val(r);
                if (t && t.length > 0) {
                    var s = $("#sourceCheck").find("input[type=checkbox][name='source']");
                    s.prop("checked", false);
                    for (var q = 0, p = t.length; q < p; q++) {
                        s.filter(function() {
                            return this.value === t[q]
                        }).prop("checked", true)
                    }
                }
            })
        }
    });

    $(".chooseSource").click(function() {
        ifagent = $(this).attr("ifagent");
        e.dialog("open")
    });
})

function searchDownline(e) {
    //var c = $("#sourceLvl").val() === "0" ? 1 : 2;
    //var d = $("#sourceLvl").val();
    var b = $("#sourceUsername").val();
    var a = "downlines?ifagent=" + ifagent + "&sourceUsername=" + b+"&userid="+userid;
    $.ajax({
        url: a,
        method: "POST",
        contentType: "application/json",
        loading: true,
        success: function(g) {
            g = JSON.parse(g);
            var j = $("#sourceCheck");
            j.empty();
            if (g && g.length > 0) {
                for (var f = 0; f < g.length; f++) {
                    var h = $("<label>").appendTo(j);
                    h.append($('<input name="source" type="checkbox">').val(g[f])).append(g[f])
                }
            } else {
                $("<label>").appendTo(j).append("暂无数据")
            }
            e()
        }
    })
}

function checkall(obj,type){
    var check = $(obj).prop("checked");
    $("#dolist"+type).find("input[type=checkbox]").prop("checked",check);
}

function chooseLotterys(g, c, ekk) {
console.log(ekk);
    var a = $("#lotteryChoose");
    if (a.length == 0) {
        a = $('<div id="lotteryChoose"></div>').appendTo("body");
        a.append("<ul>").append("");
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
                    console.log(j);
                    l.dialog("close");
                    var i = l.data("callback");
                    console.log(i);
                    if ($.isFunction(i)) {
                        console.log(i);
                        i(j.join(","))
                    }
                },
                "取消": function() {
                    $(this).dialog("close")
                }
            }
        })
    }
    a.data("callback", ekk);
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

function saveConfig() {
    var e = $("#configForm").formData(), e = JSON.stringify(e);
    $.ajax({
        url: "saveconfig", type: "POST", loading: !0, contentType: "application/json", data: e, success: function (e) {
            e.success ? (alert("设置已成功保存。"), location.reload()) : alert("保存错误：" + e.message)
        }, error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function saveauthdomain(type) {
    var a = [];
    $("#dolist"+type+" tr").each(function () {
        a.push($(this).formData());
    });
    var e = JSON.stringify({domainlist: a,type:type});
    $.ajax({
        url: "/agent/authdomain/save",
        type: "POST",
        contentType: "application/json",
        data: e,
        loading: !0,
        success: function (e) {
            alert(e.message);
            if(e.success){
                location.reload();
            }
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function suijiregister(type){
    //弹窗confirm
    var c = confirm("是否确定吗？")
    if(c){
        var sgaccount = $("#sgaccount").val();
        var sgpassword = $("#sgpassword").val();
        $.ajax({
            url: "/agent/authdomain/suijiregister",
            type: "POST",
            /*contentType: "application/json",*/
            data: {type:type,sgaccount:sgaccount,sgpassword:sgpassword},
            loading: !0,
            success: function (e) {
                alert(e.message);
                if(e.success){
                    location.reload();
                }
            },
            error: function () {
                alert("网络错误，请稍后重试")
            }
        })
    }
}

function suijipre(type) {
    $("#dolist"+type+" tr").each(function () {
        //判断是否选中
        if($(this).find("input[type=checkbox]").prop("checked")){
            //原始域名
            var domian = $(this).find("input[name=domain]").val();
            //去掉前面的第一个.xxx
            var domian1 = domian.substring(domian.indexOf(".")+1);
           //随机生成多少位数字
            var len = 8;
            if(type == 5){
                len = 10;
            }
            var s = '0123456789';
            var r = "";
            for (var i = 0; i < len; i++) {
                r += s.charAt(Math.floor(Math.random() * s.length));
            }
            var pre = $("#pre"+type).val();
            $(this).find("input[name=domain]").val(r+"-"+pre+"."+domian1);
        }
    });
}

function goto138(url){
    //打开新窗口
    window.open(url);
}

function login138(type) {
    $.ajax({
        url: "/agent/authdomain/login138",
        type: "POST",
        /*contentType: "application/json",*/
        data: {type:type},
        loading: !0,
        success: function (e) {
            alert(e.message);
            /*if(e.code == 1){
                location.reload();
            }*/
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function get138sitelist(type) {
    $.ajax({
        url: "/agent/authdomain/get138sitelist",
        type: "POST",
        /*contentType: "application/json",*/
        data: {type:type},
        loading: !0,
        success: function (e) {
            alert(e.message);
            /*if(e.code == 1){
                location.reload();
            }*/
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function suijianquanma(id) {
    var text = "";
    var possible1 = "0123456789";
    var possible2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for (var i = 0; i < 6; i++) {
        text += possible1.charAt(Math.floor(Math.random() * possible1.length));
    }
    for (var i = 0; i < 2; i++) {
        text += possible2.charAt(Math.floor(Math.random() * possible2.length));
    }
    $("#"+id).val(text);
}

function add138daohang(type) {
    //checkbox类型
    var iskjw = $("#iskjw").prop("checked");
    iskjw = iskjw?1:0;
    var anquanma = $("#anquanma").val();
    var anquanmagl = $("#anquanmagl").val();
    $.ajax({
        url: "/agent/authdomain/add138daohang",
        type: "POST",
        /*contentType: "application/json",*/
        data: {type:type,iskjw:iskjw,anquanma:anquanma,anquanmagl:anquanmagl},
        loading: !0,
        success: function (e) {
            alert(e.message);
            /*if(e.code == 1){
                location.reload();
            }*/
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function saveanquanma(type) {
    var anquanma = $("#anquanma").val();
    var anquanmagl = $("#anquanmagl").val();
    $.ajax({
        url: "/agent/authdomain/saveanquanma",
        type: "POST",
        /*contentType: "application/json",*/
        data: {type:type,anquanma:anquanma,anquanmagl:anquanmagl},
        loading: !0,
        success: function (e) {
            alert(e.message);
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function del138daohang(type) {
    $.ajax({
        url: "/agent/authdomain/del138daohang",
        type: "POST",
        /*contentType: "application/json",*/
        data: {type:type},
        loading: !0,
        success: function (e) {
            alert(e.message);
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function saveawsandbt(type) {
    var a = [];
    $("#dolist"+type+" tr").each(function () {
        //判断是否选中
        if($(this).find("input[type=checkbox]").prop("checked")){
            a.push($(this).formData());
        }
    });
    //至少选择一个
    if(a.length == 0){
        alert("请至少选择一条");
        return false;
    }
    var e = JSON.stringify({domainlist: a,type:type});
    $.ajax({
        url: "/agent/authdomain/saveawsandbt",
        type: "POST",
        contentType: "application/json",
        data: e,
        loading: !0,
        success: function (e) {
            alert(e.msg);
            /*if(e.code == 1){
                location.reload();
            }*/
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function delawsandbt(type) {
    var a = [];
    $("#dolist"+type+" tr").each(function () {
        //判断是否选中
        if($(this).find("input[type=checkbox]").prop("checked")){
            a.push($(this).formData());
        }
    });
    //至少选择一个
    if(a.length == 0){
        alert("请至少选择一条");
        return false;
    }
    var e = JSON.stringify({domainlist: a,type:type});
    $.ajax({
        url: "/agent/authdomain/delawsandbt",
        type: "POST",
        contentType: "application/json",
        data: e,
        loading: !0,
        success: function (e) {
            alert(e.msg);
            /*if(e.code == 1){
                location.reload();
            }*/
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function delauthdomain(id) {
    confirm("是否确定删除吗？") && $.ajax({
        url: "/agent/authdomain/delete",
        type: "POST",
        data:{id:id},
        loading: !0,
        success: function (e) {
            alert(e.message);
            window.location.reload();
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function addauthhtml(type) {
    $("#dolist"+type).append($('<tr class=""><td align="center"><input type="checkbox" /><input type="hidden" name="id" value="" /></td><td align="center"><input name="domain" style="width: 400px;" type="text" value=""></td><td align="center"><select name="status"><option selected value="1">正常</option><option value="0">禁用</option></select></td><td class="op"><a href="javascript:void(0)" onclick="delauthhtml(this)">删除</a></td></tr>'))
}

function delauthhtml(e) {
    $(e).parent().parent().remove()
}
