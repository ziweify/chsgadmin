var lotCode = lotCode.egxy28, boxId = "#headerData", headMethod = {};
headMethod.loadHeadData = function (e, a) {
    setTimeout(function () {
        pubmethod.ajaxHead.egxy28(e, a)
    }, config.kaiCountTimes)
}, headMethod.headData = function (e, a) {
    pubmethod.creatHead.egxy28(e, a);
    //tools.setTimefun_pcEgg()
};