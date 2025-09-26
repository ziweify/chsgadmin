function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
var lotCode = getParameterByName("code"), headMethod = {};
if(lotCode == null){window.location.href= '/html/public/home.html'}
lotCode = parseInt(lotCode);
headMethod.loadHeadData = function (e, o) {
    setTimeout(function () {
        pubmethod.ajaxHead.klsf(e, o)
    }, config.kaiCountTimes)
}, headMethod.headData = function (e, o) {
    pubmethod.creatHead.klsf(e, o);
    //tools.setTimefun_gdklsf()
};