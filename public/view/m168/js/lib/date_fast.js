/* 
 * 日期插件
 * 滑动选取日期（年，月，日）
 * V1.1
 */
(function ($) {      
    $.fn.dateTools = function (options,Ycallback,Ncallback) { 
        //插件默认选项
        var that = $(this);
        var docType = $(this).is('input');
        var datetime = false;
        var nowdate = new Date();
        var indexY=1,indexM=1,indexD=1;
        var indexH=1,indexI=1,indexS=0;
        var initY=parseInt((nowdate.getFullYear()))-1900;
        var initM=parseInt(nowdate.getMonth()+"")+1;
        var initD=parseInt(nowdate.getDate()+"");
        var initH=parseInt(nowdate.getHours());
        var initI=parseInt(nowdate.getMinutes());
        var initS=parseInt(nowdate.getYear());
        var yearScroll=null,monthScroll=null,dayScroll=null;
        var HourScroll=null,MinuteScroll=null,SecondScroll=null;
        $.fn.dateTools.defaultOptions = {
            beginyear:1900,                 //日期--年--份开始
            endyear:nowdate.getFullYear()+50,                   //日期--年--份结束
            beginmonth:1,                   //日期--月--份结束
            endmonth:12,                    //日期--月--份结束
            beginday:1,                     //日期--日--份结束
            endday:31,                      //日期--日--份结束
            beginhour:1,
            endhour:12,
            beginminute:00,
            endminute:59,
            curdate:false,                   //打开日期是否定位到当前日期
            theme:"date",                    //控件样式（1：日期，2：日期+时间）
            mode:null,                       //操作模式（滑动模式）
            event:"click",                    //打开日期插件默认方式为点击后后弹出日期 
            show:true
        }
        //用户选项覆盖插件默认选项   
        var opts = $.extend( true, {}, $.fn.dateTools.defaultOptions, options );
        if(opts.theme === "datetime"){datetime = true;}
        if(!opts.show){
            that.unbind('click');
        }
        else{
            //绑定事件（默认事件为获取焦点）
            that.bind(opts.event,function () {
                createUL();      //动态生成控件显示的日期
                init_iScrll();   //初始化iscrll
                extendOptions(); //显示控件
                that.blur();
                if(datetime){
                    showdatetime();
                    refreshTime();
                }
                refreshDate();
                bindButton();
            })  
        };
        function refreshDate(){
            yearScroll.refresh();
            monthScroll.refresh();
            dayScroll.refresh();

            resetInitDete();
            yearScroll.scrollTo(0, (initY*40)==0?1:(initY*40), 100, true);
            monthScroll.scrollTo(0, (initM*40-40)==0?1:(initM*40-40), 100, true);
            dayScroll.scrollTo(0, (initD*40-40)==0?1:(initD*40-40), 100, true); 
        }
        function refreshTime(){
            HourScroll.refresh();
            MinuteScroll.refresh();
            SecondScroll.refresh();
            if(initH>12){    //判断当前时间是上午还是下午
                 SecondScroll.scrollTo(0, initD*40-40, 100, true);   //显示“下午”
                 initH=initH-12-1;
            }
            HourScroll.scrollTo(0, initH*40, 100, true);
            MinuteScroll.scrollTo(0, initI*40, 100, true);   
            initH=parseInt(nowdate.getHours());
        }
    function resetIndex(){
            indexY=1;
            indexM=1;
            indexD=1;
        }
        function resetInitDete(){
            if(opts.curdate){return false;}
            else if(that.val()===""){return false;}
            initY = parseInt(that.val().substr(0,4))-opts.beginyear;
            initM = parseInt(that.val().substr(5,2));
            initD = parseInt(that.val().substr(8,2));
        }
        function bindButton(){
            resetIndex();
            $("#dateconfirm").unbind('click').click(function () {
                var datestr = $("#yearwrapper ul li:eq("+indexY+")").html().substr(0,$("#yearwrapper ul li:eq("+indexY+")").html().length-1)+"-"+
                          $("#monthwrapper ul li:eq("+indexM+")").html().substr(0,$("#monthwrapper ul li:eq("+indexM+")").html().length-1)+"月"+
              $("#daywrapper ul li:eq("+Math.round(indexD)+")").html().substr(0,$("#daywrapper ul li:eq("+Math.round(indexD)+")").html().length-1)+"日";
               if(datetime){
                     if(Math.round(indexS)===1){//下午
                        $("#Hourwrapper ul li:eq("+indexH+")").html(parseInt($("#Hourwrapper ul li:eq("+indexH+")").html().substr(0,$("#Hourwrapper ul li:eq("+indexH+")").html().length-1))+12)
                     }else{
                        $("#Hourwrapper ul li:eq("+indexH+")").html(parseInt($("#Hourwrapper ul li:eq("+indexH+")").html().substr(0,$("#Hourwrapper ul li:eq("+indexH+")").html().length-1)))
                     }
                     datestr+=" "+$("#Hourwrapper ul li:eq("+indexH+")").html().substr(0,$("#Minutewrapper ul li:eq("+indexH+")").html().length-1)+":"+
                             $("#Minutewrapper ul li:eq("+indexI+")").html().substr(0,$("#Minutewrapper ul li:eq("+indexI+")").html().length-1);
                         indexS=0;
                }
                if(Ycallback===undefined){
                     if(docType){that.val(datestr);}else{that.html(datestr);}
                }else{
                     Ycallback(datestr);
                }
                $("#datePage").animate({"top":"-6rem"},"100"); 
                $("#datePlugin").css("height","auto");
                $("#dateshadow").animate({"opacity":"0"},"100");
                $("#dateshadow").stop().css({"display":"none"});
                $("html,body").css({overflow:"visible"});
                $("#showtime").text($("#beginTime").val().substr(5,$("#beginTime").val().length));
                //request date
                var requestdate = datestr.replace("月","-");
                requestdate = requestdate.replace("日","");
                method.loadOther(requestdate);
                $("#yearmothnday").val($("#yearwrapper ul li:eq("+indexY+")").html().substr(0,$("#yearwrapper ul li:eq("+indexY+")").html().length-1));//记录年月日
//              tools.checkDay($("#daywrapper ul li:eq("+Math.round(indexD)+")").html().substr(0,$("#daywrapper ul li:eq("+Math.round(indexD)+")").html().length-1));
            });
            $("#datecancle").click(function (){
                $("#datePage").animate({"top":"-6rem"},"100"); 
               $("#datePlugin").css("height","auto");
                $("#dateshadow").animate({"opacity":"0"},"100");
                $("#dateshadow").stop().css({"display":"none"});
                $("html,body").css({overflow:"visible"});
            });
        }       
        function extendOptions(){
            $("#datePage").css({"display":"block","top":"-2rem"});
            $("#datePlugin").css("height","auto");
            $("#dateshadow").css({"display":"block","opacity":"0"});
            $("#datePlugin").css("height","100%");
            $("#datePage").animate({"top":"20%"},"100");
            $("#dateshadow").animate({"opacity":"0.1"},"100");
//          $("html,body").css({overflow:"hidden"});
        }
        //日期滑动
        function init_iScrll() { 
            var strY = $("#yearwrapper ul li:eq("+indexY+")").html().substr(0,$("#yearwrapper ul li:eq("+indexY+")").html().length-1);
            var strM = $("#monthwrapper ul li:eq("+indexM+")").html().substr(0,$("#monthwrapper ul li:eq("+indexM+")").html().length-1)
//          var indexD = $("#daywrapper ul li:eq("+indexD+")").html().substr(0,$("#monthwrapper ul li:eq("+indexD+")").html().length-1)
              yearScroll = new iScroll("yearwrapper",{snap:"li",vScrollbar:false,
                  onScrollEnd:function () {
                       indexY = (this.y/40)*(-1)+1;
                       if((indexY+"").indexOf(".")!=-1){
                            var y = (indexY+"").split(".");
                            var y1 = (y[1]).substr(0,1);
                            if(y1*1>5){
                                indexY = y[0]*1+1;
                            }else{
                                indexY = y[0];
                            }
                       }
                       opts.endday = checkdays(strY,strM);
                         createDAY_UL();
                          createMONTH_UL($("#yearwrapper ul li:eq("+indexY+")").html().substr(0,$("#yearwrapper ul li:eq("+indexY+")").html().length-1));
                           yearScroll.refresh();
                           monthScroll.refresh();
                           dayScroll.refresh();
                  }});
              monthScroll = new iScroll("monthwrapper",{snap:"li",vScrollbar:false,
                  onScrollEnd:function (){
                      indexM = (this.y/40)*(-1)+1;
                      if((indexM+"").indexOf(".")!=-1){
                        var y0 = (indexM+"").split(".");
                        var y1 = (y0[1]).substr(0,1);
                        if(y1*1>5){
                            indexM = y0[0]*1+1;
                        }else{
                            indexM = y0[0];
                        }
                       }
                      opts.endday = checkdays(strY,strM);
                         createDAY_UL();
                         yearScroll.refresh();
                         monthScroll.refresh();
                         dayScroll.refresh();
                  }});
              dayScroll = new iScroll("daywrapper",{snap:"li",vScrollbar:false,
                  onScrollEnd:function () {
                      indexD = (this.y/40)*(-1)+1;
                      if((indexD+"").indexOf(".")!=-1){
                        var y0 = (indexD+"").split(".");
                        var y1 = (y0[1]).substr(0,1);
                        if(y1*1>5){
                            indexD = y0[0]*1+1;
                        }else{
                            indexD = y0[0];
                        }
                       }
                      opts.endday = checkdays(strY,strM);
                      yearScroll.refresh();
                      monthScroll.refresh();
                      dayScroll.refresh();
                  }});
        }
        function showdatetime(){
            init_iScroll_datetime();
            addTimeStyle();
            $("#datescroll_datetime").show(); 
            $("#Hourwrapper ul").html(createHOURS_UL());
            $("#Minutewrapper ul").html(createMINUTE_UL());
            $("#Secondwrapper ul").html(createSECOND_UL());
        }

        //日期+时间滑动
        function init_iScroll_datetime(){
            HourScroll = new iScroll("Hourwrapper",{snap:"li",vScrollbar:false,
                onScrollEnd:function () {
                    indexH = Math.round((this.y/40)*(-1))+1;
                    HourScroll.refresh();
            }})
            MinuteScroll = new iScroll("Minutewrapper",{snap:"li",vScrollbar:false,
                onScrollEnd:function () {
                    indexI = Math.round((this.y/40)*(-1))+1;
                    HourScroll.refresh();
            }})
            SecondScroll = new iScroll("Secondwrapper",{snap:"li",vScrollbar:false,
                onScrollEnd:function () {
                    indexS = Math.round((this.y/40)*(-1));
                    HourScroll.refresh();
            }})
        } 
        function checkdays (year,month){
            var new_year = year;    //取当前的年份        
            var new_month = month++;//取下一个月的第一天，方便计算（最后一天不固定）        
            if(month>12)            //如果当前大于12月，则年份转到下一年        
            {        
                new_month -=12;        //月份减        
                new_year++;            //年份增        
            }        
            var new_date = new Date(new_year,new_month,1);                //取当年当月中的第一天        
            return (new Date(new_date.getTime()-1000*60*60*24)).getDate();//获取当月最后一天日期    
        }
        function  createUL(){
            CreateDateUI();
            createYEAR_UL();
            createDAY_UL();
        }
        function CreateDateUI(){
            var str = ''+
                '<div id="dateshadow"></div>'+
                '<div id="datePage" class="page">'+
                    '<section>'+
                        '<div id="datemark"><a id="markyear"></a><a id="markmonth"></a><a id="markday"></a></div>'+
                        '<div id="timemark"><a id="markhour"></a><a id="markminut"></a><a id="marksecond"></a></div>'+
                        '<div id="datescroll">'+
                            '<div id="yearwrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                            '<div id="monthwrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                            '<div id="daywrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                        '</div>'+
                        '<div id="datescroll_datetime">'+
                            '<div id="Hourwrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                            '<div id="Minutewrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                            '<div id="Secondwrapper">'+
                                '<ul></ul>'+
                            '</div>'+
                        '</div>'+
                    '</section>'+
                    '<footer id="dateFooter">'+
                        '<div id="setcancle">'+
                            '<ul>'+
                                '<li id="dateconfirm">确定</li>'+
                                '<li id="datecancle">取消</li>'+
                            '</ul>'+
                        '</div>'+
                    '</footer>'+
                '</div>'
            $("#datePlugin").html(str);
        }
        function addTimeStyle(){
            $("#datePage").css("height","380px");
            $("#datePage").css("top","60px");
            $("#yearwrapper").css("position","absolute");
            $("#yearwrapper").css("bottom","200px");
            $("#monthwrapper").css("position","absolute");
            $("#monthwrapper").css("bottom","200px");
            $("#daywrapper").css("position","absolute");
            $("#daywrapper").css("bottom","200px");
        }
        //创建 --年-- 列表
        function createYEAR_UL(){
            var year = new Date().getFullYear();
            var str="<li>&nbsp;</li>";
            for(var i=opts.beginyear; i<=opts.endyear;i++){
                if(i>year){
                    continue;
                }
                str+='<li>'+i+'年</li>';
            }
            $("#yearwrapper ul").html(str+"<li>&nbsp;</li><li>&nbsp;</li>");
            var strY = $("#yearwrapper ul li:eq("+indexY+")").html().substr(0,$("#yearwrapper ul li:eq("+indexY+")").html().length-1);
            createMONTH_UL(strY);
        }
        //创建 --月-- 列表
        function createMONTH_UL(y){
            var years = new Date().getFullYear();
            var strY = $("#yearwrapper ul li:eq("+indexY+")").html().substr(0,$("#yearwrapper ul li:eq("+indexY+")").html().length-1);
            var moth = new Date().getMonth()+1;
            var str="<li>&nbsp;</li>";
            for(var i=opts.beginmonth;i<=opts.endmonth;i++){
                y=y=="1900"?years:y;
                if(y>=years){
                    if(i>moth){
                        continue;
                    }
                }
                if(i<10){
                    i="0"+i
                }
                str+='<li>'+i+'月</li>';
            }
            $("#monthwrapper ul").html(str+"<li>&nbsp;</li><li>&nbsp;</li>");
        }
        //创建 --日-- 列表
        function createDAY_UL(){
            var ulli = $("#monthwrapper").find("li");
            var month = new Date().getMonth()+1;
            var strM = $("#monthwrapper ul li:eq("+indexM+")").html().substr(0,$("#monthwrapper ul li:eq("+indexM+")").html().length-1);
            var years = new Date().getFullYear();
            var strYnow = $("#yearwrapper ul li:eq("+indexY+")").html().substr(0,$("#yearwrapper ul li:eq("+indexY+")").html().length-1);
            var day = new Date().getDate();
              $("#daywrapper ul").html("");
            var str="<li>&nbsp;</li>";
                for(var i=opts.beginday;i<=opts.endday;i++){
                    strY=strYnow=="1900"?years:strYnow;
                    strM=strYnow=="1900"?month:strM;
                    if(strY>=years&&strM*1>=month){
                        if(i>day){
                            continue;
                        }
                    }
                    if(i>30){
                        if(testMoth(strM)){
                        }else{
                            continue;
                        }
                    }
                    if(strM=="02"){
                        if(i>test2Moth(strY,strM)){
                            continue;
                        }
                    }
                str+='<li>'+i+'日</li>';
            }
            var ulli2 = $("#monthwrapper").find("li");
            $("#daywrapper ul").html(str+"<li>&nbsp;</li><li>&nbsp;</li>");
        }
        //创建 --时-- 列表
        function createHOURS_UL(){
            var str="<li>&nbsp;</li>";
            for(var i=opts.beginhour;i<=opts.endhour;i++){
                str+='<li>'+i+'时</li>'
            }
            return str+"<li>&nbsp;</li>";;
        }
        //创建 --分-- 列表
        function createMINUTE_UL(){
            var str="<li>&nbsp;</li>";
            for(var i=opts.beginminute;i<=opts.endminute;i++){
                if(i<10){
                    i="0"+i
                }
                str+='<li>'+i+'分</li>'
            }
            return str+"<li>&nbsp;</li>";;
        }
        //创建 --分-- 列表
        function createSECOND_UL(){
            var str="<li>&nbsp;</li>";
            str+="<li>上午</li><li>下午</li>"
            return str+"<li>&nbsp;</li>";;
        }
    }
})(jQuery);  
function testMoth(m){
    var mr31 = ["01","03","05","07","08","10",'12'];
    for(var i=0;i<mr31.length;i++){
        if(m==mr31[i]){
            return true;
        }
    }
}
function test2Moth(y,m){
    var rorp =  y%2;
     if(rorp==0&&m=="02"){
        return 29;
     }else{
        return 28;
     }
}