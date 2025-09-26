<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {if $rkey==0}oncontextmenu="return false"{/if}>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>即时注单</title>
    <link href="/xypone/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="/xypone/css/default/control.css" rel="stylesheet" type="text/css" />
    <link href="/xypone/css/default/ball.css?v=1112" rel="stylesheet" type="text/css" />
    <script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
    <script language="javascript" src="/xypone/default/js/default/jsagent/libagent.js?v=11111"></script>
    <script language="javascript">
        var thref = top.location.href;
        function hideinfo() {
            if (event.srcElement.tagName == "A") {
                window.status = event.srcElement.innerText
            }
        }

        document.onmouseover = hideinfo;
        document.onmousemove = hideinfo;
        var globalpath = "/xypone/default/";
        function changeh() {
            var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
            var h = document.body.clientHeight + 500;
            obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
        }
    </script>
    <style>
        .xbody {
            margin-left: 3px;
        }

        .xbody1 {
            margin-left: 3px;
        }

        .xbody2 {
            margin-left: 3px;
        }

        .xbody3 {
            margin-left: 3px;
        }

        body {
            overflow-y: auto
        }
    </style>
    <style>
        body {
            font-size: 13px;
            overflow: auto
        }


        .now th {
            width: 50px;
        }

        .now td {
            width: 150px;
        }

        .now td, .now td {
            text-align: left
        }

        .now {
            cursor: pointer
        }

        .now td:hover {
            background: #0284c3;
            color: #eee
        }

        .now th.bred {
            background: #0284c3;
            color: #eee
        }

        .now td, .now th {
            font-size: 13px !important;
        }

        .lib th.bred {
            background: #0284c3;
            color: #eee
        }

        .lib .m {
            width: 45px;
        }

        .lib .s {
            width: 60px;
            text-align: center;
            line-height: 26px;
        }

        .lib .t {
            line-height: 26px;
        }

        .lib .fo {
            line-height: 26px;
        }

        .lib th {
            background: none
        }

        .lib img.dis {
            FILTER: gray
        }

        .lib .pl {
            font-size: 12px;
            color: blue;
            font-weight: bold
        }

        .lib td, .lib td {
            font-size: 13px;
            text-align: left;
            padding-left: 2px;
        }

        .lib .one {
            width: 25%;
            height: 50px;
            line-height: 25px;
        }

        .lib .two {
            width: 25%;
            height: 50px;
            line-height: 25px;
            background: #E2DFFD;
            display: none
        }

        .lib .three {
            width: 25%;
            height: 50px;
            line-height: 25px;
        }

        .lib .four {
            width: 25%;
            height: 50px;
            line-height: 25px;
        }

        .lib .w200 {
            width: 100%;
        }

        input.btns {
            margin: 0px;
            margin-right: 2px;
            margin-top: 2px;
            FONT-WEIGHT: normal;
            color: #222;
            border: none;
            background: #fffeee
        }

        input.small {
            width: 30px;
            font-size: 11px;
        }

        span, label, td {
            cursor: pointer
        }

        .thead input {
            margin: 0px;
        }

        .thead select, .thead span, .thead label, .thead input {
            float: left;
            margin-right: 2px;
        }


        .hide {
            display: none
        }

        .show {
            display: block
        }

        .pset td {
            x-height: 30px;
        }

        .pset .btns:hover {
        }

        .pset input.click {
            background: #C66
        }

        .w1002 {
            width: 994px;
        }

        .w1330 {
            width: 99%;
        }

        .w500 {
            width: 500px;
        }

        td.ext {
            height: 100px;
        }

        th.bo {
            background: #FC6
        }

        .butb {
            width: 150px;
            position: absolute;
            background: #fff;
            display: none;
        }

        .butbwai {
            width: 150px;
            position: absolute;
            background: #fff;
            display: none;
        }

        .xxtb {
            width: 1000px;
            position: absolute;
            background: #fff;
            display: none;
            border: 2px solid #000
        }

        .flytb {
            width: 950px;
            position: absolute;
            background: #fff;
            display: none;
            border: 2px solid #000
        }

        .xxtb td, .xxtb th {
            word-wrap: break-word;
            word-break: break-all;
        }

        .flytb td, .flytb th {
            word-wrap: break-word;
            word-break: break-all;
        }

        .xxtb tr:hover {
            background: #DEEFD8
        }

        .flytb tr:hover {
            background: #DEEFD8
        }

        .onepeilvtb {
            width: 120px;
            position: absolute;
            background: #fff;
            display: none;
            border: 2px solid #000;
            z-index: 3
        }

        a.red {
            color: #D50000
        }

        img {
            border: none
        }

        tr.z1 {
            background: #69F
        }

        tr.z3 {
            background: #EFE9ED
        }

        input.plmodeclick {
            color: #D50000
        }

        .pset td {
            x-height: 30px;
        }

        .pset .btns:hover {
            background: #FC6
        }

        .pset input.click {
            background: #C66
        }

        .libs {
            margin-top: 5px;
            display: none
        }

        .libs span {
            margin-right: 5px;
        }

        .libs .pages a {
            margin-right: 5px;
        }

        .libs .zcxx {
            color: #F00
        }

        .libs .flyxx {
            color: #090
        }

        .libs .flys {
            background: #FC3
        }

        .libs .xh {
            width: 35px;
        }

        .libs td.c {
            text-align: left;
            padding-left: 5px;
        }

        .libs label {
            margin-left: 3px;
            margin-right: 3px;
        }

        .tinfo td.warn {
            background-color: #F9FAF1
        }

        .tinfo th.warn {
            background-color: #FFF2F0
        }

        .lib .zcxx {
            color: #F00
        }

        .lib .flyxx {
            color: #090
        }

        .lib .fly {
            color: #000
        }

        .lib .flys {
            background: #FC3
        }

        .duopl {
            width: 700px;
            position: absolute;
            1
        }

        .duopl .m {
            width: 50px;
        }

        .duopl label.pl {
            color: blue;
            font-size: 14px;
        }

        .duopl label.peilv1 {
            color: blue
        }

        .duopl label.peilv2 {
            color: blue
        }

        .duopl th {
            background: # #F9FAF1 !important
        }

        input.red {
            color: #D50000
        }

        input.blue {
            color: blue
        }

        input.green {
            color: green
        }

        td.tiao {
            text-align: center;
            width: 55px !important;
        }

        .sendtb {
            display: none;
            position: absolute;
            width: 530px;
            background: #fff;
            border: 2px solid #FC3
        }

        .sendtb .txt1 {
            width: 40px;
        }

        .qiua {
            font-weight: bold;
            color: White;
            float: none;
            margin: 0px auto;
            width: 21px;
            height: 21px;
            line-height: 21px;
            font-size: 13px;
            text-align: center;
            background: #FB0200 url(/xypone/default/img/bgbm.gif) no-repeat left top;
            background-color: #0000FE;
            background-position: -42px top;
        }

        .qiub {
            font-weight: bold;
            color: White;
            float: none;
            margin: 0px auto;
            width: 21px;
            height: 21px;
            line-height: 21px;
            font-size: 13px;
            text-align: center;
            background: #FB0200 url(/xypone/default/img/bgbm.gif) no-repeat left top;
            background-color: #FB0200;
        }

        .qiuc {
            font-weight: bold;
            color: White;
            float: none;
            margin: 0px auto;
            width: 21px;
            height: 21px;
            line-height: 21px;
            font-size: 13px;
            text-align: center;
            background: #FB0200 url(/xypone/default/img/bgbm.gif) no-repeat left top;
            background-color: #007F04;
            background-position: -21px top;
        }

        label.peilv1 {
            color: #306 !important
        }

        label.mepeilv1 {
            color: red !important
        }

        label.zhpeilv1 {
            color: blue !important
        }

        label.mp1 {
            color: #000 !important
        }

        label.peilv2 {
            color: #306 !important
        }

        label.mepeilv2 {
            color: red !important
        }

        label.zhpeilv2 {
            color: blue !important
        }

        label.mp2 {
            color: #000 !important
        }

        .bts th {
            background: #F9FAF1 !important
        }
    </style>
</head>
<body>
<script id=myjs language="javascript">
function json_encode_js(aaa) {
    function je(str) {
        var a = [],
            i = 0;
        var pcs = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (; i < str.length; i++) {
            if (pcs.indexOf(str[i]) == -1) a[i] = "\\u" + ("0000" + str.charCodeAt(i).toString(16)).slice(-4);
            else a[i] = str[i]
        }
        return a.join("")
    }

    var i, s, a, aa = [];
    if (typeof (aaa) != "object") {
        alert("ERROR json");
        return
    }
    for (i in aaa) {
        s = aaa[i];
        a = '"' + je(i) + '":';
        if (typeof (s) == 'object') {
            a += json_encode_js(s)
        } else {
            if (typeof (s) == 'string') a += '"' + je(s) + '"';
            else if (typeof (s) == 'number') a += s
        }
        aa[aa.length] = a
    }
    return "{" + aa.join(",") + "}"
}

function getResult(num, n) {
    return Math.round(num * Math.pow(10, n)) / Math.pow(10, n)
}

function getresult(num, n) {
    return num.toString().replace(new RegExp("^(\\-?\\d*\\.?\\d{0," + n + "})(\\d*)$"), "$1") + 0
}

function strlen(sString) {
    var sStr, iCount, i, strTemp;
    iCount = 0;
    sStr = sString.split("");
    for (i = 0; i < sStr.length; i++) {
        strTemp = escape(sStr[i]);
        if (strTemp.indexOf("%u", 0) == -1) {
            iCount = iCount + 1
        } else {
            iCount = iCount + 2
        }
    }
    return iCount
}

function rhtml(str) {
    return str.match(/<a\b[^>]*>[\s\S]*?<\/a>/ig)
}
</script>
<div class="xbody1" style="width:99%">
    <table class="tinfo wd100">
        <tr>
            <th style="text-align:left;height:25px;line-height:25px;" class="thead">
                <select id=qishu>
                    {foreach id="i" name="qishu"}
                    <option value="{$i}">{$i}期</option>
                    {/foreach}
                </select>
                <label class="panstatus" s='{$panstatus}' id="cdClose" style="display: inline;"><label>距封盘：</label><span>00:00</span></label>
                <select id=reloadtime>
                    <option value="10">10秒</option>
                    <option value="15">15秒</option>
                    <option value="20">20秒</option>
                    <option value="30">30秒</option>
                    <option value="45">45秒</option>
                    <option value="60" selected>60秒</option>
                </select>
                <label class="time"></label>
                <span>秒</span>
                <input type="button" class="btn3 btnf" value="暂停" id='zanting'/>
                <span style="display:none">盤口</span>
                <select id=abcd>
                    <option value="0">ABCD盤</option>
                    {foreach id="i" name="pan"}
                    <option value="{$i}">{$i}盘</option>
                    {/foreach}
                </select>
                <select id=ab>
                    <option value="0">AB盤</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
                <input type="checkbox" value="1" id=zhenghe/><span>整合</span>
                <select id='xsort'>
                    <option value="name">按號碼排</option>
                    <option value="ks" selected>按盈虧排</option>
                    <option value="zje">按總投排</option>
                    <option value="zc">按占成</option>
                    <option value="zs">按註數</option>
                </select>
                <select id='userid' layer='{$layer}'>
                    <option value="">選擇下線</option>
                    {foreach id="vo" name="topuser"}
                    <option value="{$vo.userid}">{$vo.username}</option>
                    {/foreach}
                </select>
                {if $flytype==1}<select id='fly'>
                <option value="1">内补</option>
            </select>{/if}
                {if $flytype==2}<select id='fly'>
                <option value="2">外补</option>
            </select>{/if}
                {if $flytype==3}<select id='fly'>
                <option value="1">内补</option>
                <option value="2">外补</option>
            </select>{/if}
                {if ($flytype==1 | $flytype==3)} <input type="button" class="btn3 btnf" id='pfly' value="批量补货"/>{/if}
                <input type="button" class="btn1 btnf" value="刷新" id='reload'/>

                <!-- <input type="button" class="btn1 btnf hide" value="打印" id='print' />-->
                {if $layer==1 & $ifexe==1}
                <input type="button" class="btn3 btnf hide" value="赔率設置" id='pset'/>
                <span>赔率:</span>
                <input type="button" class="plmode btn3 btnf" value="上线" v='1'/>
                <input type="button" class="plmode btn3 btnf plmodeclick" value="当前赔率" v='3'/>
                {if $pself!=1}<input type="button" class="plmode btn3 btnf" value="调节值" v='2'/>
                {else}<input type="button" class="plmode btn3 btnf" value="默认赔率" v='4'/>{/if}
                {if $pself==1}
                <input type="button" class="btn3 btnf moren" value="寫入默認" ac='writemoren'/>
                <input type="button" class="btn3 btnf moren" value="恢复默認" ac='resetmoren'/>{/if}
                <input type="button" class="btn3 btnf moren{if $pself==1} hide{/if}" value="清零"
                       title="如果使用自定赔率，恢复赔率与上级同步，如果使用上级赔率，调节值清零" ac='resetzero'/>
                {/if}
                <div class="right" style="margin-right: 2px">
                    <div id="drawInfo" style="display: flex;align-items: center;">
                        <span class="draw_number" style="float: left;margin-right: 5px"><span class="upqishu"  m='{$upkj}'>{$qishu[1]}</span>期开奖</span>
                        <div class="upkj T107"></div>
                    </div>
                </div>
                <!--<input type="button" class="btn1 downfast btnf" value="下载当前注单"/>-->
            </th>
        </tr>
    </table>
    {if $layer==1 & $ifexe==1}
    <table class="tinfo onepeilvtb">
        <tr>
            <th>项目</th>
            <TD></td>
        </tr>
        <TR>
            <th>赔率</th>
            <TD><input type='text' class="txt1" style="width:50px;"/></TD>
        </TR>
        <TR>
            <td colspan="2" align="center"><input type="button" class="btn1 btnf onesend" value='提交'/><input
                    type="button" value='关闭' class="btn1 btnf oneclose" style="margin-left:10px;"/></td>
        </TR>
    </table>

    <table class='tinfo wd100 pset'>
        <TR>
            <td style="text-align:left;"><input type="button" value="單" class="btns btnf"/><input type="button"
                                                                                                   value="雙"
                                                                                                   class="btns btnf"/><input
                    type="button" value="大" class="btns btnf"/><input type="button" value="小"
                                                                       class="btns btnf"/><input type="button"
                                                                                                 value="合單"
                                                                                                 class="btns btnf"/><input
                    type="button" value="合雙" class="btns btnf"/><input type="button" value="尾大"
                                                                         class="btns btnf"/><input type="button"
                                                                                                   value="尾小"
                                                                                                   class="btns btnf"/><input
                    type="button" value="家畜" class="btns btnf"/><input type="button" value="野獸"
                                                                         class="btns btnf"/><input type="button"
                                                                                                   value="前"
                                                                                                   class="btns btnf"/><input
                    type="button" value="後" class="btns btnf"/><input type="button" value="紅"
                                                                       class="btns btnf red"/><input type="button"
                                                                                                     value="藍"
                                                                                                     class="btns btnf blue"/><input
                    type="button" value="綠" class="btns btnf green"/><input type="button" value="紅單"
                                                                             class="btns btnf red"/><input type="button"
                                                                                                           value="紅雙"
                                                                                                           class="btns btnf red"/><input
                    type="button" value="紅大" class="btns btnf red"/><input type="button" value="紅小"
                                                                             class="btns btnf red"/><input type="button"
                                                                                                           value="藍單"
                                                                                                           class="btns btnf blue"/><input
                    type="button" value="藍雙" class="btns btnf blue"/><input type="button" value="藍大"
                                                                              class="btns btnf blue"/><input
                    type="button" value="藍小" class="btns btnf blue"/><input type="button" value="綠單"
                                                                              class="btns btnf green"/><input
                    type="button" value="綠雙" class="btns btnf green"/><input type="button" value="綠大"
                                                                               class="btns btnf green"/><input
                    type="button" value="綠小" class="btns btnf green"/><input type="button" value="0尾"
                                                                               class="btns btnf"/><input type="button"
                                                                                                         value="1尾"
                                                                                                         class="btns btnf"/><input
                    type="button" value="2尾" class="btns btnf"/><input type="button" value="3尾"
                                                                        class="btns btnf"/><input type="button"
                                                                                                  value="4尾"
                                                                                                  class="btns btnf"/><input
                    type="button" value="5尾" class="btns btnf"/><input type="button" value="6尾"
                                                                        class="btns btnf"/><input type="button"
                                                                                                  value="7尾"
                                                                                                  class="btns btnf"/><input
                    type="button" value="8尾" class="btns btnf"/><input type="button" value="9尾"
                                                                        class="btns btnf"/><br/><input type="button"
                                                                                                       value="鼠"
                                                                                                       class="btns btnf"/><input
                    type="button" value="牛" class="btns btnf"/><input type="button" value="虎"
                                                                       class="btns btnf"/><input type="button"
                                                                                                 value="兔"
                                                                                                 class="btns btnf"/><input
                    type="button" value="龍" class="btns btnf"/><input type="button" value="蛇"
                                                                       class="btns btnf"/><input type="button"
                                                                                                 value="馬"
                                                                                                 class="btns btnf"/><input
                    type="button" value="羊" class="btns btnf"/><input type="button" value="猴"
                                                                       class="btns btnf"/><input type="button"
                                                                                                 value="雞"
                                                                                                 class="btns btnf"/><input
                    type="button" value="狗" class="btns btnf"/><input type="button" value="豬"
                                                                       class="btns btnf"/><input type="button"
                                                                                                 value="0头"
                                                                                                 class="btns btnf"/><input
                    type="button" value="1头" class="btns btnf"/><input type="button" value="2头"
                                                                        class="btns btnf"/><input type="button"
                                                                                                  value="3头"
                                                                                                  class="btns btnf"/><input
                    type="button" value="4头" class="btns btnf"/><input type="button" value="前3"
                                                                        class="btns btnf"/><input type="button"
                                                                                                  value="前5"
                                                                                                  class="btns btnf"/><input
                    type="button" value="前10" class="btns btnf botton"/><input type="button" value="全部"
                                                                                class="btns btnf"/><input type="button"
                                                                                                          value="反选"
                                                                                                          class="red btns btnf"/>
                <select id='psettype'>
                    <option value="0">減</option>
                    <option value="1">加</option>
                </select>
                <select id='psetattvalue'>
                    <option value="0.01">0.01</option>
                    <option value="0.02">0.02</option>
                    <option value="0.05">0.05</option>
                    <option value="0.1" selected>0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.5">0.5</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="5">5</option>
                </select>
                <input type="button" class="btn1 btnf" value="加/減" id='psetatt'/>&nbsp;&nbsp;<input type="text"
                                                                                                      style="width:35px;"
                                                                                                      value="42.5"
                                                                                                      id='psetvalue'/><input
                        type="button" class="btn1 btnf" value="送出" id='psetsend'/><input type="button"
                                                                                           class="btn1 btnf"
                                                                                           value="提交"
                                                                                           id='psetpost'/><input
                        type="button" class="btn3 btnf" value="取消修改" id='psetcancel'/><input type="checkbox"
                                                                                                 value="1"
                                                                                                 class='tmode'/><span>取同</span><input
                        type="checkbox" value="2" class='tmode'/><span>取总</span>


            </td>

        </TR>
    </table>
    {/if}
    <table class="wd100 tinfo now">
        <Tr>
            {foreach id="vo" name="s"}
            <th class="n{$vo.sid}">{$vo.name}</th>
            <td sid='{$vo.sid}' sname='{$vo.name}' class="n nx{$vo.sid}"></td>
            {if ($vo.i==7 | $vo.i==15)}
        </Tr>
        <tr>{/if}
            {/foreach}
            <TD colspan="4" style="text-align:left;width:400px;">占成/總投/走飛:<label class="zc">0</label>/<label
                    class="zong">0</label>/<label class="fly">0</label></TD>
        </Tr>
    </table>


</div>
<div class="xbody1" style="width:99%">
    <table class="wd100 tinfo lib ">

    </table>
    <table class="tinfo libs">
        <tr>
            <th colspan="2">每页显示：<span>50</span><span class="red">100</span><span>200</span><span>300</span></th>
            <th colspan="3"><SELECT class="pages"></SELECT></th>
        </tr>
        <tr>
            <th>序号</th>
            <th>內容</th>
            <th class='gpl hide'>赔率</th>
            <th>占成/总额/已补/注数</th>
            <th>預計亏损</th>
            <th>补</th>
        </tr>
    </table>
</div>
<table class="butb tinfo">
    <tr>
        <th>类别</th>
        <td></td>
    </tr>
    <tr>
        <th>项目</th>
        <td><label pid=''></label></td>
    </tr>
    <tr>
        <th>赔率</th>
        <td><label></label><input type="text" class="bupeilv1 txt1"/></td>
    </tr>
    <tr>
        <th>赔率2</th>
        <td><label></label><input type="text" class="bupeilv2 txt1" value="0"/></td>
    </tr>
    <tr>
        <th>退水</th>
        <td><input type="text" class="bupoints txt1"/></td>
    </tr>
    <tr>
        <th>金额</th>
        <td><input type="text" class="buje txt1"/></td>
    </tr>
    <tr>
        <th>投|注内容</th>
        <td></td>
    </tr>
    <tr>
        <th>补货类型</th>
        <td><select class="fly"></select></td>
    </tr>
    <tr>
        <td colspan="2"><input type="button" class="btn1 btnf sendbu" value="补"/><input style="margin-left:20px;"
                                                                                         type="button"
                                                                                         class="btn1 btnf cbtn"
                                                                                         value="取消"/></td>
    </tr>
</table>

<input type="text" class='tests hide'/>
<input type="hidden" class='sort' orderby='time' sorttype='DESC' page='1' xtype='2' con=''/>

<table class="tinfo xxtb">
    <tr class="bt">
        <th>期数</th>
        <th>交易号</th>
        <th>类型</th>
        <th>类别</th>
        <th>大盘</th>
        <th>小盘</th>
        <th>内容</th>
        <th><a href="javascript:void(0);" class="je">金额<img src="/xypone/default/img/down.gif" s='up'/></a></th>
        <th>赔率</th>
        <th>退水</th>
        <th>会员</th>
        <th><a href="javascript:void(0);" class="time">时间<img src="/xypone/default/img/down.gif" s='down'/></a></th>
    </tr>
</table>

<table class="tinfo flytb">
    <tr class="bt">
        <th>期数</th>
        <th>交易号</th>
        <th>类型</th>
        <th>类别</th>
        <th>大盘</th>
        <th>小盘</th>
        <th>内容</th>
        <th>金额</th>
        <th>赔率</th>
        <th>退水</th>
        <th>会员</th>
        <th>时间</th>
        <th>手自动</th>
    </tr>
</table>
<table class="tinfo sendtb">

</table>
<script language="javascript">
    var globalpath = '/xypone/default/';
    layername = new Array();
    {foreach id="vo" name="layername" key="i"}
    layername[{$i}] = "{$vo}";
    {/foreach}
    var maxlayer = layername.length;
    var layer = {$layer};
    var pself = 0;
    var ifexe = 0;
    {if $layer == 1}
        ifexe = {$ifexe};
        pself = {$pself};
    {/if}
    var style = '{$class}';
    var ngid = {$gid};
    var fenlei = '{$fenlei}';
    var ma = new Array();
    {foreach id="i" name="ma"}
        {foreach key="k"  id="ii" name="i"}
            ma['{$k}'] = new Array({$ii});
        {/foreach}
    {/foreach}
    $(function () {
        myready();
    });
</script>
<iframe name=sfrm id=sfrm style="display:none;"></iframe>
<iframe id="downfastfrm" style="display:none;"></iframe>
<div id='test'></div>
</body>
</html>
