$(function () {
    var a = function () {
        LIBS.ajax({
            url: "notice",
            cache: false,
            success: function (b) {
			///	b=eval('('+b+')');
                $("#notices").html(b)
            }
        })
    };
    a();
    setInterval(a, 30000)
});
