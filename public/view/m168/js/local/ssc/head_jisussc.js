function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
var lotCode = getParameterByName("code"), boxId = "#headerData", headMethod = {};
if(lotCode == null){window.location.href= '/html/public/home.html'}
lotCode = parseInt(lotCode);
headMethod.loadHeadData = function (e, t) {
    setTimeout(function () {
        pubmethod.ajaxHead.ssc(e, t)
    }, config.kaiCountTimes)
}, headMethod.headData = function (e, t) {
    pubmethod.creatHead.ssc(e, t);
   /* setTimeout(function () {
        !$("#videobox").length < 1 && -1 != $("#videobox").css("z-index") && $("iframe")[0].contentWindow.sscAnimateEnd(createData())
    }, 1e3)*/
};