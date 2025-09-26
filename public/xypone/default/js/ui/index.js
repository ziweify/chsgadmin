var msg = "游客盘口只供试玩，与正式会员盘口无关!";
if (/MSIE [4-8]/.test(navigator.userAgent)) {
	location.href = "browser/index.html"
}
$(function() {
	var b = function() {
			$("#trans_list").load("/trans")
		};
	b();
	setInterval(b, 60000);
	$(".main-game-left a").click(function() {
		if (!$(".login").is(":hidden")) {
			dialog.error("消息", "您还没有登录！");
			return false
		}
	});
	$(".showVideo").click(function() {
		dialog.url("官方宣传视频", 605, 450, "")
	});
	$(".loto_menue a").click(function() {
		if (!$(".login").is(":hidden")) {
			var d = {};
			d["游客登录"] = function() {
				alert(msg);
				c("!guest!", "!guest!")
			};
			dialog.error("消息", "您还没有登录！", d);
			return false
		}
	});
	$(".trade").click(function() {
		if (!$(".login").is(":hidden")) {
			dialog.error("消息", "您还没有登录！");
			return false
		}
	});

	function c(g, e, d, f) {
		dialog.load("正在登录，请等待...");
		postUrl = "/cashlogin";
		if (typeof window.IS_MOBILE !== "undefined") {
			postUrl = "/mobile/cashlogin"
		}
		$.ajax({
			url: postUrl,
			type: "POST",
			dataType: "JSON",
			data: {
				account: g,
				password: e,
				affKey: d
			},
			success: function(h) {
				dialog.close();
				if (h.success) {
					if (f) {
						console.log("test");
						location.href = "/mobile/member/agreement?" + h.message
					} else {
						checklogin(h.message)
					}
				} else {
					dialog.error("消息", h.message)
				}
			},
			error: function(h, j, i) {
				alert(h.responseText)
			}
		})
	}
	$("#btnlogin").click(function() {
		var f = $("#username").val();
		var e = $("#password").val();
		var d = $("#aff-key-login").val();
		if (f == "") {
			dialog.error("消息", "用户名和密码都不能为空");
			return
		}
		if (e == "") {
			dialog.error("消息", "用户名和密码都不能为空");
			return
		}
		c(f, e, d)
	});
	checklogin("");
	$("#btnregister").click(function() {
		location.href = "/register"
	});
	$(".login input").keypress(function(d) {
		if (d.keyCode == 13) {
			$("#btnlogin").click();
			return false
		}
	});
	showLeftTime();
	$("#guestLogin").click(function() {
		alert(msg);
		c("!guest!", "!guest!")
	});
	$("#btnRegister").click(function() {
		a()
	});

	function a() {
		var j = $(".subcontent2 input[name=username]").val();
		if (j == "") {
			dialog.error("消息", "请输入账号名称！");
			return
		}
		var d = $(".subcontent2 input[name=name]").val();
		if (d == "") {
			dialog.error("消息", "请输入真实姓名！");
			return
		}
		var k = $(".subcontent2 input[name=email]").val();
		if (k == "") {
			dialog.error("消息", "请输入电子邮箱地址！");
			return
		}
		var e = $(".subcontent2 input[name=mobile]").val();
		var g = new RegExp("^[0-9]*$");
		if (e !== undefined && (e == "" || e.length != 11 || !g.test(e))) {
			dialog.error("消息", "请输入正确的11位数字手机号码！");
			return
		}
		var l = $(".subcontent2 input[name=wechat]").val();
		if (l == "") {
			dialog.error("消息", "请输入微信号！");
			return
		}
		var m = $(".subcontent2 input[name=password]").val();
		var n = $(".subcontent2 input[name=password1]").val();
		if (m == "") {
			dialog.error("消息", "请输入密码！");
			return
		}
		if (m != n) {
			dialog.error("消息", "输入的密码不一致，请重新输入！");
			return
		}
		var h = $(".subcontent2 input[name=affKey]").val();
		if (h == "") {
			dialog.error("消息", "请输入邀请码！");
			return
		}
		var f = $("#code").val();
		if (f == "") {
			dialog.error("消息", "请输入验证码！");
			return
		}
		var i = getQueryString("aff");
		if (i == "" || i == null) {
			i = LIBS.cookie("affid")
		}
		$("#btnRegister").attr("disabled", "disabled");
		$("#btnRegister").val("提交中，请等待...");
		$.post("reg", {
			username: j,
			password: m,
			parent: i,
			affKey: h,
			mobile: e,
			email: k,
			name: d,
			code: f,
			weChatId: l
		}, function(p) {
			if (p.success) {
				var o = {};
				o["马上登录"] = function() {
					c(j, m, h, true)
				};
				dialog.alert1("消息", "恭喜，注册成功！", o, "/index")
			} else {
				dialog.error("消息", p.message)
			}
			$("#btnRegister").removeAttr("disabled");
			$("#btnRegister").val("创建帐号")
		})
	}
});

function showLeftTime() {
	var c = new Date();
	var b = c.format("yyyy-MM-dd hh:mm:ss");
	$(".showTime").html(b);
	var a = setTimeout(showLeftTime, 1000)
}
function checklogin(a) {
	if (!a) {
		a = "/member/checklogin?client=" + Math.random()
	} else {
		a = "/member/checklogin?" + a
	}
	if (typeof window.IS_MOBILE !== "undefined") {
		a = "/mobile" + a
	}
	$.ajax({
		url: a,
		type: "POST",
		dataType: "JSON",
		success: function(b) {
			if (b.success) {
				if (typeof window.IS_MOBILE !== "undefined") {
					window.location = "/mobile/member/lobby"
				}
				$(".header-links").css("display", "block");
				$(".login").css("display", "none");
				$(".username").text(b.data.userName);
				if (b.data.tesing == 1) {
					$(".header-center").css("display", "none");
					$(".header-payment").css("display", "none")
				} else {
					$(".header-center").css("display", "block");
					$(".header-payment").css("display", "block")
				}
			} else {
				$(".login").css("display", "block");
				$(".header-links").css("display", "none");
				$(".username").text("");
				$(".header-center").css("display", "block");
				$(".header-payment").css("display", "block")
			}
		}
	})
}
function showError() {
	dialog.error("消息", "暂未开通！");
	return false
}
function showPayInfoDialog(d, e) {
	var a = ["存款人", "存款账号", "存款时间"];
	var c = '<div class="payconfirm">';
	for (var b = 0; b < a.length; b++) {
		c += "<p><label>" + a[b] + "：</label><input /></p>"
	}
	c += "</div>";
	dialog.info("支付确认信息", c, {
		"确定": function() {
			var f = $(this).find("input").vals();
			$.post("/member/payment/alertAdmin", {
				transId: d,
				payInfo: JSON.stringify(f)
			}, function(g) {
				if (g.success) {
					dialog.close();
					location.href = "/member/payment/transfer"
				} else {
					dialog.error("消息", "确认失败，请联系客服！")
				}
			})
		},
		"取消": function() {
			dialog.close()
		}
	})
}
function getLastDay(b, d) {
	var c = new Date(b, d, 1);
	var a = (new Date(c.getTime() - 1000 * 60 * 60 * 24)).getDate();
	return b + "-" + d + "-" + a
};