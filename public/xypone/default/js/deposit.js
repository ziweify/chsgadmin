var recharge = "/member/payment/recharge";
var transfer = "/member/payment/transfer";
var transtips = "/member/payment/transtips";
var atmtips = "/member/payment/atmtips";
var safetips = "/member/payment/safetips";
if (typeof window.IS_MOBILE !== "undefined") {
	recharge = "/mobile/member/payment/recharge";
	transfer = "#/payment/transfer";
	transtips = "#/payment/deposit/transtips/";
	atmtips = "#/payment/deposit/atmtips/";
	safetips = "#/payment/deposit/safetips/"
}
$(function() {
	$(".banklist,.banklist2").click(function() {
		$(this).find("input:radio").prop("checked", true)
	});
	$(".tab").click(function() {
		var a = $(this).attr("id");
		$(".subcontent").css("display", "none");
		$(".tab").removeClass("tabactive");
		$("#subpage" + a).css("display", "block");
		$(this).addClass("tabactive")
	});
	$("#copy_chkcode").val(Math.floor((Math.random() * 1000000) % 800000) + 100000)
});

function doDeposit(b, a) {
	b = $(b);
	if (a == -1) {
		return apiDeposit(b)
	} else {
		if (a == 0) {
			return zfbDeposit(b)
		} else {
			if (a == 1) {
				return atmDeposit(b)
			}
		}
	}
	
}
function apiDeposit(c) {
	var a = c.closest(".subcontent");
	var b = Number(a.find("input[name=amount]").val());
	console.log(a);
	console.log(b);
	if (isNaN(b) || b <= 0 || b < MIN_AMOUNT) {
		if (typeof window.IS_MOBILE !== "undefined") {
			alert("充值金额最少为" + Math.max(MIN_AMOUNT, 1) + "元")
		} else {
			dialog.error("错误", "充值金额最少为" + Math.max(MIN_AMOUNT, 1) + "元")
		}
		return false
	}
	var d;
	if (typeof window.IS_MOBILE !== "undefined") {
		d = a.find("select").val()
	} else {
		d = a.find("input:radio:checked").val()
	}
	if (d == undefined) {
		dialog.error("错误", "请选择银行种类！");
		return false
	}
	if (typeof window.IS_MOBILE !== "undefined") {
		window.location.href = transtips + b
	} else {
		dialog.url("订单信息", 334, 270, transtips + "?amount=" + b)
	}
}
function atmDeposit(a) {
	var b;
	if (typeof window.IS_MOBILE !== "undefined") {
		b = a.closest(".subcontent").find("select").val()
	} else {
		b = a.closest(".subcontent").find("input:radio:checked").val()
	}
	alert(b);
	if (b == undefined) {
		dialog.error("消息", "请选择银行种类！");
		return
	}
	
	if (typeof window.IS_MOBILE !== "undefined") {
		window.location.href = atmtips + b
	} else {
		dialog.url("订单提交", 564, 457, atmtips + "?cardid=" + b)
	}
}
function zfbDeposit(a) {
	var b;
	if (typeof window.IS_MOBILE !== "undefined") {
		b = a.closest(".subcontent").find("select").val()
	} else {
		b = a.closest(".subcontent").find("input:radio:checked").val()
	}
	if (b == undefined) {
		dialog.error("消息", "请选择银行种类！");
		return
	}
	if (typeof window.IS_MOBILE !== "undefined") {
		window.location.href = safetips + b
	} else {
		dialog.url("订单提交", 564, 437, safetips + "?cardid=" + b)
	}
}
function isNumber(b) {
	b = (b) ? b : window.event;
	var a = (b.which) ? b.which : b.keyCode;
	if (a > 31 && (a < 46 || a > 57)) {
		return false
	}
	return true
}
function validation(a) {
	var b = $("#subpage" + a + " #amount" + a).val();
	if (b == "") {
		$("#subpage" + a + " .validation").fadeIn(200);
		$("#btnSubmit" + a).css("display", "block");
		$("#btnDeposit" + a).css("display", "none")
	} else {
		if (b >= MIN_AMOUNT) {
			$("#subpage" + a + " .validation").fadeOut(200);
			$("#btnSubmit" + a).css("display", "none");
			$("#btnDeposit" + a).css("display", "block")
		} else {
			$("#subpage" + a + " .validation").fadeIn(200);
			$("#btnSubmit" + a).css("display", "block");
			$("#btnDeposit" + a).css("display", "none")
		}
	}
}
var intDiff = parseInt(1200);

function timer(a) {
	if (window.timerVar) {
		clearTimeout(timerVar)
	}
	timerVar = window.setInterval(function() {
		var c = 0,
			b = 0,
			e = 0,
			d = 0;
		if (a > 0) {
			c = Math.floor(a / (60 * 60 * 24));
			b = Math.floor(a / (60 * 60)) - (c * 24);
			e = Math.floor(a / 60) - (c * 24 * 60) - (b * 60);
			d = Math.floor(a) - (c * 24 * 60 * 60) - (b * 60 * 60) - (e * 60)
		}
		if (e <= 9) {
			e = "0" + e
		}
		if (d <= 9) {
			d = "0" + d
		}
		$("#time_show").html("<s></s>" + e + ":<s></s>" + d);
		a--
	}, 1000)
}
$(function() {
	timer(intDiff)
});

function getQueryString(a) {
	var b = new RegExp("(^|&)" + a + "=([^&]*)(&|$)", "i");
	var c = window.location.search.substr(1).match(b);
	if (c != null) {
		return unescape(c[2])
	}
	return null
}
function goFrameUrl(a) {
	window.parent.document.getElementById("frame").src = a
}
function alertAdmin(f) {
	var a = $("#amount").val();
	var e = $("#userName").val();
	var d = $("#cardId").val();
	var c = $("#depostitTime").val();
	var g = $(".post-info").find("input").vals();
	if (a == "") {
		if (typeof window.IS_MOBILE !== "undefined") {
			alert("存款金额不能为空！")
		} else {
			dialog.error("消息", "存款金额不能为空！")
		}
		return
	}
	if (e == "") {
		if (typeof window.IS_MOBILE !== "undefined") {
			alert("用户姓名不能为空！")
		} else {
			dialog.error("消息", "用户姓名不能为空！")
		}
		return
	}
	if (d == "") {
		if (typeof window.IS_MOBILE !== "undefined") {
			alert("用户卡号不能为空！")
		} else {
			dialog.error("消息", "用户卡号不能为空！")
		}
		return
	}
	if (c == "") {
		if (typeof window.IS_MOBILE !== "undefined") {
			alert("存款时间不能为空！")
		} else {
			dialog.error("消息", "存款时间不能为空！")
		}
		return
	}
	if (g == "") {
		if (typeof window.IS_MOBILE !== "undefined") {
			alert("存款金额不能为空！")
		} else {
			dialog.error("消息", "存款信息不能为空！")
		}
		return
	}
	var b = $("#copy_cardid").val();
	if (b == "") {
		if (typeof window.IS_MOBILE !== "undefined") {
			alert("存款金额不能为空！")
		} else {
			dialog.error("消息", "转入帐号不能为空！")
		}
		return
	}
	$(f).attr("disabled", "disabled");
	$(f).val("提交中，请等待...");
	$.post(recharge, {
		amount: a,
		cardid: b,
		check: $("#copy_chkcode").val(),
		payInfo: JSON.stringify(g)
	}, function(h) {
		if (h.success) {
			alert("存款信息提交成功，等待客服审核！");
			window.parent.location.href = transfer;
			return
		} else {
			if (typeof window.IS_MOBILE !== "undefined") {
				alert(h.message)
			} else {
				dialog.error("消息", h.message)
			}
		}
		$(f).removeAttr("disabled");
		$(f).val("提交订单")
	})
}
function cancelTrans(a, b) {
	$(a).attr("disabled", "disabled");
	$(a).val("提交中，请等待...");
	$.post("/member/payment/cancelTrans", {
		transId: b
	}, function(c) {
		if (c.success) {
			if (!confirm("取消成功啦！，是否前往订单列表？")) {
				$(a).removeAttr("disabled");
				$(a).val("取消订单");
				return
			}
			window.parent.location.href = "/member/payment/transfer"
		} else {
			dialog.error("消息", "提交失败，请联系客服！")
		}
		$(a).removeAttr("disabled");
		$(a).val("取消订单")
	})
};