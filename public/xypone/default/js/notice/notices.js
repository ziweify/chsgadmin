$(function () {
    var b = null;
    var a = function () {
        $.ajax({
            url: "notice", cache: false, success: function (c) {
                $("#notices").html(c);
                if (c && c.indexOf('<span class="notice_new">') >= 0) {
                    if (b != null && b != c) {
                        $("#footer .more").click()
                    }
                    b = c
                }
            }
        })
    };
    a();
    setInterval(a, 30000);
    $(".notice-menu .notice-menu-item:first-child").click();
    $(".notice-content-item").each(function () {
        $(this).text().replace(/(?:\r\n|\r|\n)/g, "<br />")
    })
});

function tabChange() {
    if ($(this).hasClass("site-message") || $(".site-message").length > 0) {
        $(".notice-title").hide();
        if ($(this).hasClass("site-message")) {
            LIBS.ajax({url: "updateMessageRead"})
        }
    } else {
        $(".notice-title").show()
    }
    $(this).addClass("active").siblings().removeClass("active");
    var c = $(this).attr("data-category");
    var b = $('.notice-content-item[data-category="' + c + '"]');
    b.addClass("active").siblings().removeClass("active");
    var a = b.parents(".notice-content");
    if (b[0].clientHeight === b[0].scrollHeight) {
        a.removeClass(["start", "end"])
    } else {
        a.addClass("start")
    }
    if ($(this).hasClass("site-message")) {
        $("#totalCounterSelected").html($(this).index())
    } else {
        $("#totalCounterSelected").html($(this).index() + 1)
    }
}

function closeNotice() {
    $(this).parents(".notice-wrapper").addClass("closing");
    window.setTimeout(function () {
        $(this).parents(".notice-wrapper").remove()
    }, 500)
}

function noticeItemScroll() {
    var b = $(this).parents(".notice-content");
    var c = this.scrollTop === 0;
    var a = this.scrollTop === (this.scrollHeight - this.clientHeight);
    if (c) {
        b.addClass("start").removeClass("end")
    }
    if (a) {
        b.addClass("end").removeClass("start")
    }
    if (!a && !c) {
        b.addClass(["start", "end"])
    }
};