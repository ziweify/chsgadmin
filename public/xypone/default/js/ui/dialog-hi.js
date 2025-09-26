var dialog = {
	openned: false,
	close: function() {
		if (typeof window.IS_MOBILE !== "undefined") {
			$("#dialog").dialog("close").remove()
		} else {
		    $("#dialog").dialog("close").remove()
		}
		dialog.openned = false
	},
	_getHTML: function(a) {
		if (a.join) {
			return "<div class='msg'><p>" + a.join("</p><p>") + "</p></div>"
		} else {
			return "<div class='msg'><p>" + a + "</p></div>"
		}
	},
	_show: function(g, d, f,pw,px,py) {
		var c;
		if (f.each) {
			c = {};
			f.each(function() {
				var h = $(this).attr("href");
				c[$(this).html()] = function() {
					window.location.href = h
				}
			})
		} else {
			c = f
		}
		var b = $(".g-bigdiv");
		if (b.length > 0) {
			b.hide()
		}
		var e = $(".g-tips-block2");
		if (e.length > 0) {
			e.hide()
		}
		dialog.close();
		var a = $('<div id="dialog"></div>');
		if (typeof window.IS_MOBILE !== "undefined") {
			a = $('<div id="dialog"></div>')
		}
		a.html('<div class="field-c">' + d + "</div>");
		a.dialog({
			resizable: false,
			modal: true,
			buttons: c,
			title: g,
			dialogClass: "dialog",
			minWidth: 360,
			minHeight: 200,
			position:[px,py],
			width:pw
		});
		dialog.openned = true
	},
	load: function(a) {
		if (a == null) {
			a = ""
		}
		dialog._show("", '<div class="icon"><img src="/css/default/img/ui/loading.gif"></img></div>' + dialog._getHTML(a), {})
	},
	info: function(c, a, b) {
		if (a == null) {
			a = ""
		}
		if (b == null) {
			b = {};
			b["确定"] = function() {
				dialog.close()
			}
		}
		dialog._show(c, dialog._getHTML(a), b)
	},
	open: function(g, a, b, j, f) {
		if (a == null) {
			a = ""
		}
		if (f != 1) {
			if (f == null) {
				f = {};
				f["确定"] = function() {
					dialog.close()
				}
			}
			var d;
			if (f.each) {
				d = {};
				f.each(function() {
					var k = $(this).attr("href");
					d[$(this).html()] = function() {
						window.location.href = k
					}
				})
			} else {
				d = f
			}
		}
		var h = $(".g-bigdiv");
		if (h.length > 0) {
			h.hide()
		}
		var c = $(".g-tips-block2");
		if (c.length > 0) {
			c.hide()
		}
		dialog.close();
		var i = "<iframe src=" + a + " width=" + b + " height=" + j + ' frameborder="no" border="0" >';
		var e = $('<div id="dialog"></div>');
		if (typeof window.IS_MOBILE !== "undefined") {
			e = $('<div id="dialog"></div>')
		}
		e.html('<div class="field-c">' + i + "</div>");
		e.dialog({
			resizable: false,
			modal: true,
			buttons: d,
			title: g,
			dialogClass: "dialog",
			minWidth: 360,
			minHeight: 200,
			width: b + 5,
			height: j + 5
		});
		dialog.openned = true
	},
	alert: function(c, a, b, d) {
		if (a == null) {
			a = ""
		}
		if (b == null) {
			b = {};
			b["确定"] = function() {
				dialog.close();
				if (d != "" && d != undefined) {
					window.parent.document.getElementById("frame").src = d
				}
			}
		}
		dialog._show(c, '<div class="icon"><img src="/css/default/img/ui/success.png"></img></div>' + dialog._getHTML(a), b)
	},
	alert1: function(c, a, b, d) {
		if (a == null) {
			a = ""
		}
		if (b == null) {
			b = {};
			b["确定"] = function() {
				dialog.close();
				if (d != "" && d != undefined) {
					window.location.href = d
				}
			}
		}
		dialog._show(c, '<div class="icon"><img src="/css/default/img/ui/success.png"></img></div>' + dialog._getHTML(a), b)
	},
	alertClose: function(c, a, b, d) {
		if (a == null) {
			a = ""
		}
		if (b == null) {
			b = {};
			b["确定"] = function() {
				var e = window;
				if (d != "" && d != undefined) {
					e.open(d, "frame")
				}
				e.close()
			}
		}
		dialog._show(c, '<div class="icon"><img src="/css/default/img/ui/success.png"></img></div>' + dialog._getHTML(a), b)
	},
	error: function(c, a, b) {
		if (a == null) {
			a = ""
		}
		if (b == null) {
			b = {};
			b["确定"] = function() {
				dialog.close()
			}
		}
		dialog._show(c, '<div class="icon"><img src="/css/default/img/ui/error.png" width="32px" height="32px"></img></div>' + dialog._getHTML(a), b)
	},
	confirm: function(c, a, b) {
		if (a == null) {
			a = ""
		}
		if (b == null) {
			b = {};
			b["确定"] = function() {
				dialog.close()
			}
		}
		dialog._show(c, '<div class="icon"><img src="/css/default/img/ui/prompt.png" width="32px" height="32px"></img></div>' + dialog._getHTML(a), b)
	},
	url: function(f, d, a, e) {
		var c = "<iframe src=" + e + " width=" + d + " height=" + a + ' frameborder="no" border="0" >';
		var b = $("#paneliframe");
		if (b.length == 0) {
			b = $('<div id="paneliframe">');
			b.dialog({
				autoOpen: false,
				modal: true,
				title: f,
				close: function() {
					$(this).find("iframe").attr("src", "")
				}
			})
		}
		b.html('<div class="field-c">' + c + "</div>");
		b.dialog("option", {
			width: d + 5,
			height: a + 5
		});
		b.dialog("open")
	}
};