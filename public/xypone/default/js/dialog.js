var dialog = {
    openned: false, close: function () {
        if (typeof window.IS_MOBILE !== "undefined") {
            $("#dialog").dialog("close").remove()
        } else {
            if (typeof window.parent.isDYH !== "undefined") {
                window.parent.$("#dialog").dialog("close").remove()
            } else {
                try {
                    window.top.$("#dialog").dialog("close").remove()
                } catch (a) {
                    try {
                        window.top[0].$("#dialog").dialog("close").remove()
                    } catch (a) {
                        window.$("#dialog").dialog("close").remove()
                    }
                }
            }
        }
        dialog.openned = false
    }, _getHTML: function (a) {
        if (a.join) {
            return "<div class='msg'><p>" + a.join("</p><p>") + "</p></div>"
        } else {
            return "<div class='msg'><p>" + a + "</p></div>"
        }
    }, _show: function (i, d, g) {
        var c;
        if (g.each) {
            c = {};
            g.each(function () {
                var e = $(this).attr("href");
                c[$(this).html()] = function () {
                    window.location.href = e
                }
            })
        } else {
            c = g
        }
        var b = $(".g-bigdiv");
        if (b.length > 0) {
            b.hide()
        }
        var f = $(".g-tips-block2");
        if (f.length > 0) {
            f.hide()
        }
        dialog.close();
        var a;
        if (typeof window.IS_MOBILE !== "undefined") {
            a = $('<div id="dialog"></div>')
        } else {
            if (typeof window.parent.isDYH !== "undefined") {
                a = window.parent.$('<div id="dialog"></div>')
            } else {
                try {
                    a = window.top.$('<div id="dialog"></div>')
                } catch (h) {
                    a = window.top[0].$('<div id="dialog"></div>')
                }
            }
        }
        a.html('<div class="field-c">' + d + "</div>");
        a.dialog({
            resizable: false,
            modal: true,
            buttons: c,
            title: i,
            dialogClass: "dialog",
            minWidth: 360,
            minHeight: 200,
            closeOnEscape: false,
            open: function (e, j) {
                $(this).parent().children().children(".ui-dialog-titlebar-close").hide()
            }
        });
        dialog.openned = true
    }, load: function (a) {
        if (a == null) {
            a = ""
        }
        dialog._show("", '<div class="icon"><img src="/js/jquery-ui/styles/images/loading.gif"></img></div>' + dialog._getHTML(a), {})
    }, info: function (c, a, b) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close()
            }
        }
        dialog._show(c, dialog._getHTML(a), b)
    }, open: function (i, a, b, l, h) {
        if (a == null) {
            a = ""
        }
        if (h != 1) {
            if (h == null) {
                h = {};
                h["确定"] = function () {
                    dialog.close()
                }
            }
            var f;
            if (h.each) {
                f = {};
                h.each(function () {
                    var e = $(this).attr("href");
                    f[$(this).html()] = function () {
                        window.location.href = e
                    }
                })
            } else {
                f = h
            }
        }
        var j = $(".g-bigdiv");
        if (j.length > 0) {
            j.hide()
        }
        var c = $(".g-tips-block2");
        if (c.length > 0) {
            c.hide()
        }
        dialog.close();
        var k = "<iframe src=" + a + " width=" + b + " height=" + l + ' frameborder="no" border="0" >';
        var g;
        if (typeof window.IS_MOBILE !== "undefined") {
            g = $('<div id="dialog"></div>')
        } else {
            if (typeof window.parent.isDYH !== "undefined") {
                g = window.parent.$('<div id="dialog"></div>')
            } else {
                try {
                    g = window.top.$('<div id="dialog"></div>')
                } catch (d) {
                    g = window.top[0].$('<div id="dialog"></div>')
                }
            }
        }
        g.html('<div class="field-c">' + k + "</div>");
        g.dialog({
            resizable: false,
            modal: true,
            buttons: f,
            title: i,
            dialogClass: "dialog",
            minWidth: 360,
            minHeight: 200,
            width: b + 5,
            height: l + 5
        });
        dialog.openned = true
    }, alert: function (c, a, b, d) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close();
                if (d != "" && d != undefined) {
                    window.parent.document.getElementById("frame").src = d
                }
            }
        }
        dialog._show(c, '<div class="icon"><img src="/js/jquery-ui/styles/images/success.png"></img></div>' + dialog._getHTML(a), b)
    }, alert1: function (c, a, b, d) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close();
                if (d != "" && d != undefined) {
                    window.location.href = d
                }
            }
        }
        dialog._show(c, '<div class="icon"><img src="/js/jquery-ui/styles/images/success.png"></img></div>' + dialog._getHTML(a), b)
    }, alert2: function (c, a, b, d) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close();
                if (d != "" && d != undefined) {
                    window.location.href = d
                }
            }
        }
        dialog._show(c, '<div class="icon"></div>' + dialog._getHTML(a), b)
    }, alertWithCallback: function (c, a, b, d) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close();
                if (d) {
                    d()
                }
            }
        }
        dialog._show(c, '<div class="icon"><img src="/js/jquery-ui/styles/images/success.png"></img></div>' + dialog._getHTML(a), b)
    }, alertClose: function (c, a, b, d) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                var e = parent.window;
                if (d != "" && d != undefined) {
                    e.open(d, "frame")
                }
                e.close()
            }
        }
        dialog._show(c, '<div class="icon"><img src="/js/jquery-ui/styles/images/success.png"></img></div>' + dialog._getHTML(a), b)
    }, error: function (c, a, b) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close()
            }
        }
        dialog._show(c, '<div class="icon"><img src="/js/jquery-ui/styles/images/error.png" width="32px" height="32px"></img></div>' + dialog._getHTML(a), b)
    }, confirm: function (c, a, b) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close()
            }
        }
        dialog._show(c, '<div class="icon"><img src="/js/jquery-ui/styles/images/success.png" width="32px" height="32px"></img></div>' + dialog._getHTML(a), b)
    }, confirm2: function (c, a, b) {
        if (a == null) {
            a = ""
        }
        if (b == null) {
            b = {};
            b["确定"] = function () {
                dialog.close()
            }
        }
        dialog._show(c, '<div class="icon"><img src="/js/jquery-ui/styles/images/update.png" width="32px" height="32px"/></div>' + dialog._getHTML(a), b)
    }, url: function (f, d, a, e) {
        var c = "<iframe src=" + e + " width=" + d + " height=" + a + ' frameborder="no" border="0" >';
        var b = $("#paneliframe");
        if (b.length == 0) {
            b = $('<div id="paneliframe">');
            b.dialog({
                autoOpen: false, modal: true, title: f, close: function () {
                    $(this).find("iframe").attr("src", "")
                }
            })
        }
        b.html('<div class="field-c">' + c + "</div>");
        b.dialog("option", {width: d + 5, height: a + 5});
        b.dialog("open");
        $("span.ui-dialog-title").text(f)
    }
};