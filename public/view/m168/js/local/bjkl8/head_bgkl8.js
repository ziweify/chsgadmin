function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
var lotCode = getParameterByName("code"), boxId = "#headerData", headMethod = {},vurl = "view/video/bjkl8Video/index.html";
if(lotCode == null){window.location.href= '/html/public/home.html'}
lotCode = parseInt(lotCode);
headMethod.loadHeadData = function (e, a) {
    setTimeout(function () {
        pubmethod.ajaxHead.bjkl8(e, a)
    }, config.kaiCountTimes)
}, headMethod.headData = function (e, a) {
    pubmethod.creatHead.bjkl8(e, a);
    //tools.setTimefun_bjkl8()
};