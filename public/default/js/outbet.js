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

function saveSite() {
    var e = $("#formSite").formData();
    var a = [];
    $("#formAccs tr").each(function () {
        a.push($(this).formData())
    });
    var zhidingagent = $("#sourceListStr1").text();
    var zhidinguser = $("#sourceListStr0").text();
    e["zhidingagent"] = zhidingagent;
    e["zhidinguser"] = zhidinguser;
    var siteid = $("#siteId").val();
    var e = JSON.stringify({site: e, accs: a,siteid:siteid});
    $.ajax({
        url: "savesite",
        type: "POST",
        contentType: "application/json",
        data: e,
        loading: !0,
        success: function (e) {
            alert(e.message);
            if(e.success){
                if(siteid){
                    location.reload();
                }else{
                    location.href='config?userid='+userid;
                }
            }
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })/* : $.ajax({
        url: "site",
        type: "POST",
        contentType: "application/json",
        data: e,
        loading: !0,
        success: function (e) {
            e.success ? (alert("新增站点成功。"), location.href = "config") : alert("新增错误：" + e.message)
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })*/
}

function delSite(e, a,uid) {
    confirm("是否确定删除站点 [" + a + "]？") && $.ajax({
        url: "delsite",
        type: "POST",
        data:{id:e,userid:uid},
        loading: !0,
        success: function (e) {
            e.success ? (alert("站点删除成功。"), location.reload()) : alert("删除错误：" + e.message)
        },
        error: function () {
            alert("网络错误，请稍后重试")
        }
    })
}

function addAcc() {
    $("#formAccs").append($('<tr><td><input name="username" /></td><td>0</td><td><select name="abcd"><option value="A">A盘</option><option value="B">B盘</option><option value="C">C盘</option><option value="D">D盘</option></select></td><td><input name="password" /></td><td><form><label><input name="enabled" type="radio" value="true" checked />启用</label> <label><input name="enabled" type="radio" value="false" />停用</label></form></td><td><input style="width: 100%" name="sg_kid" value=""/></td><td><input style="width: 100%" name="sg_secretkey" value=""/></td><td class="s-0">离线</td><td><a onclick="delAcc(this)">删除</a></td></tr>'))
}

function delAcc(e) {
    $(e).parent().parent().remove()
}
