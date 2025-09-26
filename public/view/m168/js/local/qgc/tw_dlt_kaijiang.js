var lotCode = lotCode.tw_dlt, boxId = "#headerData", headMethod = {};
headMethod.loadHeadData = function (e) {
    setTimeout(function () {
        pubmethod.ajaxHead.qgc(e)
    }, config.kaiCountTimes)
}, headMethod.headData = function (e, t) {
    pubmethod.creatHead.qgc(e, t), tools.resetRed(t)
};