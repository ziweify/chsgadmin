var lotCode = lotCode.xglhc, boxId = "#headerData", headMethod = {};
headMethod.loadHeadData = function (e) {
    setTimeout(function () {
        pubmethod.ajaxHead.lhc(e)
    }, config.kaiCountTimes)
}, headMethod.headData = function (e, t) {
    pubmethod.creatHead.lhc(e, t);
    //tools.resetRed(t)
};