function getParameterByName(o, e) {
    e || (e = window.location.href), o = o.replace(/[\[\]]/g, "\\$&");
    var n = new RegExp("[?&]" + o + "(=([^&#]*)|&|#|$)").exec(e);
    return n ? n[2] ? decodeURIComponent(n[2].replace(/\+/g, " ")) : "" : null
}
var headMethod = {}, boxId = "#headerData", lotCode = getParameterByName("code");
if(lotCode == null){window.location.href= '/html/public/home.html'}
lotCode = parseInt(lotCode);
headMethod.loadHeadData = function (t, e) {
    setTimeout(function () {
        pubmethod.ajaxHead.pk10(t, e)
    }, config.kaiCountTimes)
}, headMethod.headData = function (a, e) {
    var o = tools.parseObj(a);
    o = o.result.data;
    var t = tools.operatorTime("" == o.drawTime ? "0" : o.drawTime, o.serverTime);
    tools.publicPk10(a, e, o, t)
};