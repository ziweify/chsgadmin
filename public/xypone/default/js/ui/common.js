$(function() {
	var a = function() {
			$.ajax({
				url: "/member/notice",
				cache: false,
				success: function(d) {}
			})
		};
	a();
	setInterval(a, 60000);
	var b = LIBS.cookie("affid");
	var c = getQueryString("aff");
	if (c) {
		b = c
	}
	LIBS.cookie("affid", b)
});
var wait = 60;
var cce;

function downtime(a) {
	if (wait == 0) {
		a.removeAttr("disabled");
		a.val("点击获取");
		wait = 60
	} else {
		a.attr("disabled", "disabled");
		a.val("(" + wait + ")秒后重新获取验证码");
		wait--;
		cce = setTimeout(function() {
			downtime(a)
		}, 1000)
	}
}
function getQueryString(a) {
	var b = new RegExp("(^|&)" + a + "=([^&]*)(&|$)", "i");
	var c = window.location.search.substr(1).match(b);
	if (c != null) {
		return unescape(c[2])
	}
	return null
}
function goUrl(a) {
	var b = $("#popform");
	if (b.length == 0) {
		b = $('<form id="popform" method="post" target="_blank"></form>').appendTo("body")
	}
	b.attr("action", a).submit()
};