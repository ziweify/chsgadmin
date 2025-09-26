function strokecanvas(arr, sxArr,color, leftter) {
//  clearInterval(abb);
    var Number = [0, 10, 20, 30, 40, 50] // 开奖号码 0~~50 定
    var width = 1084; //按常规手机分辨率
    $("#c1").attr("width", width);
    var length = sxArr.length;
    if(sxArr.length <= 15) {
        var ak = 74
    } else if(sxArr.length <= 30) {
        var ak = 70
    } else if(sxArr.length >= 50) {
        var ak = 68
    }else{
        var ak= 67
    }
    var height = (width / 750) * ak * sxArr.length;
    $("#c1").attr("height", height);

    var a = width * 0.06666667,
        b = (width / 750) * 120,
        c = width * 0.97333333; //a=左边距  b=上边距   c=线的长度     
    var padding = width * 0.04
    var sxObj = {};
    var ctx = c1.getContext('2d'); // 获得画笔
    ctx.clearRect(0, 0,30000,30000);
    ctx.textBaseline = 'alphabetic';
    ctx.shadowBlur = '';

    ctx.font = 'normal normal 100 ' + width / 750 * 30 + 'px PingFang SC Light';
    ctx.fillStyle = "#333333"
    ctx.fillText("期数", a - padding, (width / 750) * 35); //字体左边距 a-30=20;
    ctx.beginPath();
    ctx.moveTo(width * 0.12, (width / 750) * 15.5); // 期数旁边的纵线
    ctx.lineTo(width * 0.12, (width / 750) * 40.5);
    ctx.strokeStyle = '#999';
    ctx.lineWidth = 1;
    ctx.stroke();
    var kk = width * 0.14666667;
    for(var n = 0; n < Number.length; n++) {
        ctx.fillStyle = "#666666"
        ctx.fillText(Number[n], kk, (width / 750) * 35); //字体左边距 a-30=20;
        kk += width * 0.15733333
    }
    ctx.beginPath();
    ctx.moveTo(0, (width / 750) * 55.5); // 横线
    ctx.lineTo(width, (width / 750) * 55.5);
    ctx.strokeStyle = '#E0E0E0';
    ctx.lineWidth = 1;
    ctx.stroke();
    if(leftter) {
        $("#c1").addClass("animated bounceInLeft");
    } else {
        $("#c1").addClass("animated bounceInRight");
    }

    function drawDashedLine(ctx, x1, y1, x2, y2, dashLength) { // 绘制虚线
        dashLength = dashLength === undefined ? 5 : dashLength;
        var deltaX = x2 - x1;
        var deltaY = y2 - y1;
        var numDashes = Math.floor(
            Math.sqrt(deltaX * deltaX + deltaY * deltaY) / dashLength);
        for(var i = 0; i < numDashes; ++i) {
            ctx[i % 2 === 0 ? 'moveTo' : 'lineTo']
                (x1 + (deltaX / numDashes) * i, y1 + (deltaY / numDashes) * i);
        }
        ctx.stroke();
    };

    ctx.translate(0.5, 0.5); //中心平移
    for(var i = 0; i < sxArr.length; i++) { // 绘制12线
        ctx.lineWidth = 0.7;
        ctx.strokeStyle = '#DADADA';
        ctx.beginPath();
        drawDashedLine(ctx, a + 35, b, c, b, 5.5) //绘制虚线
        ctx.stroke();
        sxObj[i] = b;
        ctx.fillStyle = "#989898";
        ctx.font = 'normal normal 100 ' + width / 750 * 30 + 'px 微软雅黑 Regular';
        ctx.fillText(sxArr[i], a - padding, b + 15); //字体左边距 a-padding=20;

        b += (width / 750) * 65;
    }
    //  console.log(sxObj)

    //绘制线
    ctx.beginPath();

    var arc = ((width * 0.97333333) - (width * 0.14666667)) / 50;
    //  console.log(arc);
    var p = 0;
    //  var abb = setInterval(function() { //绘制线的动画         \
    for(var p = 0; p < arr.length; p++) {

        if(p == 0) {
            ctx.moveTo(arr[p] * arc + (width * 0.135), sxObj[p]);
        }
        ctx.lineTo(arr[p] * arc + (width * 0.135), sxObj[p]);
        ctx.strokeStyle = '#999';
        ctx.lineWidth = 1;
//      if(p == length) {
//          clearInterval(abb);
//      }
        ctx.lineJoin = "bevel ";
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(arr[p] * arc + (width * 0.135), sxObj[p]);
        if(p != 0) {
            fillcircle(p - 1);
            fillcircle(p);
        }
        //      p++;
    }
    //  }, 10)

    //绘制圆
    function fillcircle(i) {
        ctx.font = 'normal normal 100 ' + width / 750 * 30 + 'px PingFang SC Light';
        ctx.beginPath();
        ctx.arc(arr[i] * arc + (width * 0.135), sxObj[i], +width / 750 * 12, 0, 2 * Math.PI);
        ctx.fillStyle =proto.colorArr[color[i]];
        ctx.fill();
        ctx.fillStyle = "#666";

        ctx.fillText(arr[i] > 9 ? arr[i] : "0" + arr[i], arr[i] * arc + (width * 0.135) - 10 * 2, sxObj[i] - 15 * 2); //字体左边距 a-30=20;

    }

}