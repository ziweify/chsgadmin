function noticePopup(b, a) {
	getSkinColor();
	$(function() {
		var c = $("<div>").appendTo($(".Notice"));
		c.attr("id", "notice" + b);
		$("<div>").addClass("back_body").appendTo(c);
		c.append('<div class="notice_div ' + skinColor + '_back"><a href="#"><div id="notClose' + b +
			'" class="close_icon"></div></a><div class="notice_icon"><div class="nicon_icon1"></div></div><div class="notice_font">' +
			a + '</div><div id="notice_button' + b +
			'" class="notice_button"><a href="#" class="yellow animate">知道</a></div></div>');
		$("#notice_button" + b + " , #notClose" + b).click(function() {
			$("#notice" + b).hide();
			$(".details").hide()
		});
		$(".close_icon , .notice_button").click(function() {
			$(".noticeChild").hide();
			$(".details").hide()
		});
		$(".nicon_button").click(function() {
			$(".noticeChild").hide();
			$(".details").show()
		})
	})
}

function escapeHtml(a) {
	return a.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g,
		"&#039;")
}

$(document).ready(function() {
	$("#footer .more").click(function() {
		var a = "";
		//getSkinColor();
		$(".notice-menu, .notice-content").html("");
		$.ajax({
			url: "/stsm/noticelist",
			type: "GET",
			dataType: "json",
			data: "",
			success: function(c) {
				for (var b = 0; b < c.length; b++) {
					if (c[b].title == undefined) {
						a = ""
					} else {
						a = c[b].title
					}
					j = b + 1;
					$(".notice-menu").append(
						'<div class="notice-menu-item" data-category="' + j +
						'" onclick="tabChange.apply(this)">' + c[b].category + "</div>");
					var d = escapeHtml(c[b].text);
					$(".notice-content").append(
						'<div class="notice-content-item" data-category="' + j +
						'" onscroll="noticeItemScroll.apply(this)"><span>' + c[b].time + "</span><h3>" +
						a + "</h3><p>" + d + "</p></div>")
				}
				/* if (skinColor == "red") {
					$(".notice-wrapper .notice-header").attr("background",
						'url("../images/notice-header-red.svg")')
				} else {
					if (skinColor == "gold") {
						$(".notice-wrapper .notice-header").attr("background",
							'url("../images/notice-header-gold.svg")')
					} else {
						$(".notice-wrapper .notice-header").attr("background",
							'url("/xypone/css/index/images/blue/notice-header.svg")')
					}
				} */
				$(".notice-title").css("display", "block");
				$(".notice-wrapper .notice-menu-item:first-child").click();
				$(".notice-wrapper").removeClass("closing");
				$(".notice-wrapper").css("display", "block");
				$("#totalCounterSelected").html(1);
				$("#totalCounter").html(c.length)
			},
			error: function(b) {
				alert("失败：" + b.code + ",请检查状况後重试。")
			},
			complete: function() {
				$(".details").show()
			}
		})
	})
	
	$("#footer .more").click();
});

function msgPopup(c, a, b) {
	$(function() {
		$(".notice-content-item.site-message").append("<p>" + new Date(a).format("yyyy-MM-dd hh:mm:ss") +
			"<br><b>" + b + "</b><br>" + c + "</p>")
	})
}

function noticePopupWithMore() {
	$(function() {
		getSkinColor();
		if ((typeof(skinColor) == "undefined") || (skinColor == null)) {
			skinColor = "blue"
		}
	})
}

function noticeVipUpgrade() {
	$(function() {
		$("#vipNotice").appendTo($(".Notice"));
		$("#vipNotice").show();
		$("#vipNotice").siblings().hide();
		$("#closeVip").click(function() {
			if ($("#vipNotice").siblings().length > 0) {
				$("#vipNotice").siblings().last().show()
			}
			$("#vipNotice").remove()
		})
	})
}

function noticePromoPopup() {
	$(function() {
		var a = $("<div>").appendTo($(".Notice"));
		a.attr("id", "noticePromo");
		$("<div>").addClass("back_body").appendTo(a);
		$("<div>").addClass("back_body").appendTo(a);
		a.append(
			'<div class="notice_div notice_promo"><a href="#"><div id="notClosePromo" class="close_icon"></div></a><div class="notice_page_promo_title">获得优惠奖金</div><div class="notice_page_promo_msg">' +
			$("#promoIn").val() +
			'</div><div class="notice_button_promo"><a id="notice_buttonPromo" href="#" class="notice_yellow animate">知道</a></div><br><div class="notice_page_promo_bt">优惠奖金已经自动发到您的账户，请到交易记录查看。</div>'
			);
		$("#noticePromo").siblings().hide();
		$("#notClosePromo").click(function() {
			if ($("#noticePromo").siblings().length > 0) {
				$("#noticePromo").siblings().first().show()
			}
			$("#noticePromo").remove()
		});
		$("#notice_buttonPromo").click(function() {
			if ($("#noticePromo").siblings().length > 0) {
				$("#noticePromo").siblings().first().show()
			}
			$("#noticePromo").remove()
		})
	})
}

function redirectAdminTopup(a) {
	$.ajax({
		url: "/member/payment/deleteAdminTopupInfo",
		type: "DELETE",
		success: function() {
			$("#adminTopupSidebar").hide();
			if (!$("#redPackIcon").is(":visible") && !$("#adminTopupSidebar").is(":visible") && !$(
					"#loyaltyWeeklyTopupSidebar").is(":visible") && !$("#loyaltyMonthlyTopupSidebar").is(
					":visible") && !$("#loyaltyRedPackIcon").is(":visible")) {
				$(".sidebar-extras-container").hide()
			}
			goToTransfer(a)
		},
		error: function() {
			console.log("提示清除失败");
			goToTransfer(a)
		}
	})
}

function redirectLoyaltyWeeklyTopup(a) {
	$.ajax({
		url: "/member/payment/deleteLoyaltyWeeklyTopupInfo",
		type: "DELETE",
		success: function() {
			$("#loyaltyWeeklyTopupSidebar").hide();
			if (!$("#redPackIcon").is(":visible") && !$("#adminTopupSidebar").is(":visible") && !$(
					"#loyaltyWeeklyTopupSidebar").is(":visible") && !$("#loyaltyMonthlyTopupSidebar").is(
					":visible") && !$("#loyaltyRedPackIcon").is(":visible")) {
				$(".sidebar-extras-container").hide()
			}
			goToTransfer(a)
		},
		error: function() {
			console.log("周俸提示清除失败");
			goToTransfer(a)
		}
	})
}

function redirectLoyaltyMonthlyTopup(a) {
	$.ajax({
		url: "/member/payment/deleteLoyaltyMonthlyTopupInfo",
		type: "DELETE",
		success: function() {
			$("#loyaltyMonthlyTopupSidebar").hide();
			if (!$("#redPackIcon").is(":visible") && !$("#adminTopupSidebar").is(":visible") && !$(
					"#loyaltyWeeklyTopupSidebar").is(":visible") && !$("#loyaltyMonthlyTopupSidebar").is(
					":visible") && !$("#loyaltyRedPackIcon").is(":visible")) {
				$(".sidebar-extras-container").hide()
			}
			goToTransfer(a)
		},
		error: function() {
			console.log("月俸提示清除失败");
			goToTransfer(a)
		}
	})
}

function redPackPopup() {
	$(function() {
		$.getJSON("payment/getbonusinfo", function(a) {
			if (a.data.length > 0) {
				$.ajax({
					url: "payment/drawbonus",
					type: "GET",
					contentType: "application/json",
					data: {
						transId: a.data[0].id
					},
					success: function(b) {
						if (a.success == true) {
							$("#redPack .redpack_amount").text(a.data[0].amount);
							$("#redPack .redpack_remark").text(a.data[0].remark);
							if (!window.IS_MOBILE) {
								loadBonus()
							}
							$("#redPack").show();
							if (!window.IS_MOBILE) {
								loadAccount()
							}
						} else {
							alert(a.message)
						}
					},
					error: function(b) {
						alert("失败：" + b.code + ",请检查状况後重试。")
					},
					complete: function() {
						$("#redPackIcon").hide();
						if (!$("#redPackIcon").is(":visible") && !$("#adminTopupSidebar")
							.is(":visible") && !$("#loyaltyWeeklyTopupSidebar").is(
								":visible") && !$("#loyaltyMonthlyTopupSidebar").is(
								":visible") && !$("#loyaltyRedPackIcon").is(":visible")) {
							$(".sidebar-extras-container").hide()
						}
					}
				})
			}
		})
	})
}

function loyaltyRedPackPopup() {
	$.ajax({
		url: "payment/collectLoyaltyRedPacket",
		type: "GET",
		contentType: "application/json",
		success: function(a) {
			if (a.success == true) {
				$("#loyaltyRedPack .loyalty_redpack_amount").text(a.data.amount);
				if (!window.IS_MOBILE) {
					loadBonus()
				}
				$("#loyaltyRedPack").show();
				if (!window.IS_MOBILE) {
					loadAccount()
				}
			} else {
				alert(a.message)
			}
		},
		error: function(a) {
			alert("失败：" + a.code + ",请检查状况後重试。")
		},
		complete: function() {
			$("#loyaltyRedPackIcon").hide();
			if (!$("#redPackIcon").is(":visible") && !$("#adminTopupSidebar").is(":visible") && !$(
					"#loyaltyWeeklyTopupSidebar").is(":visible") && !$("#loyaltyMonthlyTopupSidebar").is(
					":visible") && !$("#loyaltyRedPackIcon").is(":visible")) {
				$(".sidebar-extras-container").hide()
			}
		}
	})
};
