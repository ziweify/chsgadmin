function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
var lotCode = getParameterByName("code"), boxId = "#headerData", headMethod = {};
if(lotCode == null){window.location.href= '/html/public/home.html'}
lotCode = parseInt(lotCode);
headMethod.loadHeadData = function (e, o) {
    setTimeout(function () {
        pubmethod.ajaxHead.jsk3(e, o)
    }, config.kaiCountTimes)
}, headMethod.headData = function (e, o) {
    pubmethod.creatHead.jsk3(e, o);
    /*setTimeout(function () {
        !$("#videobox").length < 1 && $("iframe")[0].contentWindow.ifopen && $("iframe")[0].contentWindow.k3v.stopVideo(createData())
    }, 1e3)*/
};