<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {if $rkey==0}oncontextmenu="return false"{/if}>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>即时注单</title>
    <link href="/xypone/css/all.css?v=111" rel="stylesheet" type="text/css"/>
    <script language="javascript" src="/xypone/default/js/jquery-1.8.3.min.js"></script>
    <script language="javascript">
        function hideinfo() {
            if (event.srcElement.tagName == "A") {
                window.status = event.srcElement.innerText
            }
        }
        document.onmouseover = hideinfo;
        document.onmousemove = hideinfo;
        function changeh(h) {
            var obj = parent.document.getElementById("frame"); //取得父页面IFrame对象
            obj.style.height = h + "px"; //调整父页面中IFrame的高度为此页面的高度
        }
    </script>
    <style>
        body {
            overflow-y: hidden;
        }
    </style>
    <script language="javascript">
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

        function getm(val) {
            if (ngid == 101 | ngid == 111 | ngid == 113 | ngid == 115 | ngid == 108 | ngid == 109 | ngid == 110 | ngid == 112) ngid = 101;
            if (ngid == 121 | ngid == 123 | ngid == 125 | ngid == 127 | ngid == 129) ngid = 105;
            if (ngid == 133) ngid = 103;
            var sl = sma['g' + ngid].length;
            for (i = 0; i < sl; i++) {
                if (val == sma['g' + ngid][i]['name']) {
                    return sma['g' + ngid][i]['ma']
                }
            }
        }
    </script>
    <style>
        body {
            font-size: 12px;
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

        .lib img.ifok {
            marign-right: 2px;
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

        .lib .up, .lib .down {
            font-size: 12px;
        }

        .lib .one {
            width: 30%;
            height: 50px;
            line-height: 25px;
        }

        .lib .two {
            width: 40%;
            height: 50px;
            line-height: 25px;
        }

        .lib .three {
            width: 30%;
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
            font-size: 10px;
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

        input.plmodeclick {
            color: #D50000
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
            width: 100%;
        }

        .w500 {
            width: 500px;
        }

        td.ext {
            height: 100px;
        }

        td.bo {
            background: #FC6
        }

        .butb {
            width: 150px;
            position: absolute;
            background: #fff;
            display: none;
        }

        .xxtb {
            width: 950px;
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

        .onepeilvtb {
            width: 120px;
            position: absolute;
            background: #fff;
            display: none;
            border: 2px solid #000;
            z-index: 10;
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

        .ztnow th {
            width: 66px;
        }

        .ztnow td {
            width: 150px;
        }

        .ztnow td:hover {
            background: #FD8225
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

        .lib .zcxx {
            color: #F00
        }

        .lib .flyxx {
            color: #090
        }

        .lib .fly {
            background: #FC3
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

        .duopl {
            width: 700px;
            position: absolute;
            z-index: 0
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
            color: red
        }

        label.mepeilv1 {
            color: green !important
        }

        label.zhpeilv1 {
            color: blue !important
        }

        label.mp1 {
            color: #000 !important
        }

        .bts th {
            background: #F9FAF1 !important
        }

    </style>
</head>
<body>
<script language="javascript" src="/xypone/default/js/default/jshide/libmyadmin.js?v=1111111"></script>
<div class="xbody1" style="width:99%;">
    <table class="tinfo wd100">
        <tr>
            <th style="text-align:left;height:25px;line-height:25px;" class="thead">
                <select id=qishu>
                    {foreach id="i" name="qishu"}
                    <option value="{$i}">{$i}期</option>
                    {/foreach}
                </select> <select id=reloadtime>
                <option value="10">10秒</option>
                <option value="15">15秒</option>
                <option value="20">20秒</option>
                <option value="30">30秒</option>
                <option value="45">45秒</option>
                <option value="60" selected>60秒</option>
            </select>
                <label class="time"></label>
                <span>秒</span><input type="button" class="btn3 btnf" value="暂停" id='zanting'/><select id=abcd>
                <option value="0">ABCD盤</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
                <select id=ab>
                    <option value="0">AB盤</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select><input type="checkbox" value="1" id=zhenghe/><span>整合</span>

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
                </select><input type="hidden" id='setks' value="0"/>
                <select id='fly' class="hide">
                    <option value="2">外补</option>
                </select>
                <input type="button" class="btn3 btnf" id='pfly' value="批量走飛"/>

                <input type="button" class="btn1 btnf" value="刷新" id='reload'/><input type="button"
                                                                                        class="btn1 btnf hide"
                                                                                        value="打印" id='print'/><input
                    type="button" class="btn3 btnf" value="赔率設置" id='pset'/>
                <span>赔率显示:</span>
                <input type="button" class="plmode btn3 btnf plmodeclick" value="正常" v='2'/>
                <input type="button" class="plmode btn3 btnf" value="默认" v='4'/>

                <input type="button" class="btn3 btnf moren" value="寫入默認" ac='writemoren'/>
                <input type="button" class="btn3 btnf moren" value="恢复默認" ac='resetmoren'/>
                <!-- <div class='maxks'><span>亏损:</span><input type="text" size=5 /></div>
                 <div class='maxcm'><span>吃码:</span><input type="text" size=5 /></div><input value="設置" type="button" class="setks btnf btn1" />-->
                <input type="button" class="btn1 downfast btnf" value="下载当前注单"/>
            </th>
        </tr>

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
                                                                                                      style="width:45px;"
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
    <table class="wd100 tinfo now">
        <Tr>
            {foreach id="vo" name="s"}
            <th class="n{$vo.sid}">{$vo.name}</th>
            <td sid='{$vo.sid}' sname='{$vo.name}' class="n nx{$vo.sid}"></td>
            {if ($vo.i==7 || $vo.i==15)}
        </Tr>
        <tr>{/if}
            {/foreach}
            <TD colspan="4" style="text-align:left;width:400px;">占成/總投/走飛:<label class="zc">0</label>/<label
                    class="zong">0</label>/<label class="fly">0</label></TD>
        </Tr>
    </table>


</div>
<div class="xbody2" style="width:99%;">
    <table class="tinfo lib">

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
        <th>類別</th>
        <td></td>
    </tr>
    <tr>
        <th>項目</th>
        <td><label pid=''></label></td>
    </tr>
    <tr>
        <th>金額</th>
        <td><input type="text" class="buje txt1"/></td>
    </tr>
    <tr>
        <th>赔率</th>
        <td><input type="text" class="bupeilv1 txt1"/></td>
    </tr>
    <tr>
        <th>赔率2</th>
        <td><input type="text" class="bupeilv2 txt1" value="0"/></td>
    </tr>
    <tr>
        <th>退水</th>
        <td><input type="text" class="bupoints txt1"/></td>
    </tr>
    <tr>
        <th>投|註內容</th>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><input type="button" class="btns btnf sendbu" value="補"/><input style="margin-left:20px;"
                                                                                         type="button"
                                                                                         class="btns btnf c"
                                                                                         value="取消"/></td>
    </tr>
</table>

<input type="hidden" class='sort' orderby='time' sorttype='DESC' page='1' xtype='2' con=''/>
<table class="tinfo xxtb">
    <tr class="bt">
        <th>期數</th>
        <th>交易號</th>
        <th>類型</th>
        <th>類別</th>
        <th>大盤</th>
        <th>小盤</th>
        <th>內容</th>
        <th><a href="javascript:void(0);" class="je">金額<img src="/xypone/default/img/down.gif" s='up'/></a></th>
        <th>赔率</th>
        <th>退水</th>
        <th>會員</th>
        <th><a href="javascript:void(0);" class="time">時間<img src="/xypone/default/img/down.gif" s='down'/></a></th>
    </tr>
</table>

<table class="tinfo flytb">
    <tr class="bt">
        <th>期數</th>
        <th>交易號</th>
        <th>類型</th>
        <th>類別</th>
        <th>大盤</th>
        <th>小盤</th>
        <th>內容</th>
        <th>金額</th>
        <th>赔率</th>
        <th>退水</th>
        <th>會員</th>
        <th>時間</th>
        <th>手自动</th>
    </tr>
</table>
<table class="tinfo onepeilvtb">
    <tr>
        <th>項目</th>
        <TD></td>
    </tr>
    <TR>
        <th>赔率</th>
        <TD><input type='text' class="txt1" style="width:50px;"/></TD>
    </TR>
    <TR>
        <td colspan="2" align="center"><input type="button" class="btn1 btnf onesend" value='提交'/><input type="button"
                                                                                                           value='關閉'
                                                                                                           class="btn1 btnf oneclose"
                                                                                                           style="margin-left:10px;"/>
        </td>
    </TR>
</table>
<table class="tinfo sendtb">

</table>
<iframe id="downfastfrm" style="display:none;"></iframe>
<script language="javascript">
    var globalpath = '/xypone/default/';
    layername = new Array();
    {foreach id="vo" name="layername" key="i"}
    layername[{$i}] = "{$vo}";
    {/foreach}
    var layer = {$layer};
    var style = '{$class}';
    var ngid = {$gid};
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
<div id='test'></div>
</body>
</html>