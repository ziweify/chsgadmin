<ul class="tab">
    <li class="tab_title02">
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=0" @if($index == '' || $index == 0)class="on"@endif>万千</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=1" @if($index == 1)class="on"@endif>万佰</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=2" @if($index == 2)class="on"@endif>万拾</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=3" @if($index == 3)class="on"@endif>万个</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=4" @if($index == 4)class="on"@endif>千佰</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=5" @if($index == 5)class="on"@endif>千拾</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=6" @if($index == 6)class="on"@endif>千个</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=7" @if($index == 7)class="on"@endif>佰拾</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=8" @if($index == 8)class="on"@endif>佰个</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=9" @if($index == 9)class="on"@endif>拾个</a>
    </li>
</ul>
<table>
    <tbody>
    <tr class="head">
        <th>种类</th>
        <th>{{$fl[1]}}</th>
    </tr>
    <tr>
        <td>赔率</td>
        <td><span id="o_{{$fl[0]}}" class="odds">--</span></td>
    </tr>
    </tbody>
</table>
<ul class="tab">
    <li class="tab_title02">
        <a href="#" id="fastChoose1" class="on" style="width:150px;">{{$fl[1]}}位快选</a>
        <a href="#" id="fastChoose2" style="width:150px;">选项快选</a>
    </li>
</ul>
<div class="status_panel">
    <table class="table_ball">
        <tbody>
        <tr class="head">
            <th colspan="12">{{$arr[0]}}位</th>
        </tr>
        <tr class="head">
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
        </tr>
        <tr>
            <th class="name" title="0"><span class="b0">0</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="0"></td>

            <th class="name" title="1"><span class="b1">1</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="1"></td>

            <th class="name" title="2"><span class="b2">2</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="2"></td>

            <th class="name" title="3"><span class="b3">3</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="3"></td>

            <th class="name" title="4"><span class="b4">4</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="4"></td>
        </tr>
        <tr>
            <th class="name" title="5"><span class="b5">5</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="5"></td>

            <th class="name" title="6"><span class="b6">6</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="6"></td>

            <th class="name" title="7"><span class="b7">7</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="7"></td>

            <th class="name" title="8"><span class="b8">8</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="8"></td>

            <th class="name" title="9"><span class="b9">9</span></th>
            <td class="check"><input type="checkbox" name="chk0" value="9"></td>
        </tr>
        </tbody>
    </table>
    <table class="table_ball">
        <tbody>
        <tr class="head">
            <th colspan="12">{{$arr[1]}}位</th>
        </tr>
        <tr class="head">
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
            <th>球</th>
            <th>选择</th>
        </tr>
        <tr>
            <th class="name" title="0"><span class="b0">0</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="0"></td>

            <th class="name" title="1"><span class="b1">1</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="1"></td>

            <th class="name" title="2"><span class="b2">2</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="2"></td>

            <th class="name" title="3"><span class="b3">3</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="3"></td>

            <th class="name" title="4"><span class="b4">4</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="4"></td>
        </tr>
        <tr>
            <th class="name" title="5"><span class="b5">5</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="5"></td>

            <th class="name" title="6"><span class="b6">6</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="6"></td>

            <th class="name" title="7"><span class="b7">7</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="7"></td>

            <th class="name" title="8"><span class="b8">8</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="8"></td>

            <th class="name" title="9"><span class="b9">9</span></th>
            <td class="check"><input type="checkbox" name="chk1" value="9"></td>
        </tr>
        </tbody>
    </table>
</div>
<div class="check_panel" id="instantCheck" hidden="">
    <table class="table_ball">
        <tbody>
        <tr>
            <th class="name" style="padding:0 15px;width:40px;">{{$arr[0]}}位</th>
            <td>
                <div style="float:left;"><input type="checkbox" value="快选" id="fsOddNum"><span>单数</span></div>
                <div style="float:left;"><input type="checkbox" value="快选" id="fsEvenNum"><span>双数</span></div>
                <div><span>含</span><input type="text" id="fsInclude" style="width:30px;"></div>
            </td>
            <th class="name" style="padding:0 15px;width:40px;">双重</th>
            <td>
                <div style="float:left;"><input type="checkbox" value="快选" id="doubleNum"><span>取</span></div>
                <div><input type="checkbox" value="快选" id="doubleNumX"><span>除</span></div>
            </td>

            <th class="name" style="padding:0 15px;width:40px;">数字</th>
            <td>
                <div>
                    <div style="float:left;"><span>含</span><input type="text" id="contain" style="width:30px;"></div>
                    <div><span>排除</span><input type="text" id="exclude" style="width:30px;"></div>
                </div>
            </td>
        </tr>

        <tr>
            <th class="name" style="padding:0 15px;width:40px;">{{$arr[1]}}位</th>
            <td>
                <div style="float:left;"><input type="checkbox" value="快选" id="secOddNum"><span>单数</span></div>
                <div style="float:left;"><input type="checkbox" value="快选" id="secEvenNum"><span>双数</span></div>
                <div><span>含</span><input type="text" id="secInclude" style="width:30px;"></div>
            </td>
            <th class="name" style="padding:0 15px;width:40px;">二兄弟</th>
            <td>
                <div style="float:left;"><input type="checkbox" value="快选" id="brotherNum"><span>取</span></div>
                <div><input type="checkbox" value="快选" id="brotherNumX"><span>除</span></div>
            </td>
        </tr>

        </tbody>
    </table>
</div>
<div class="split_panel" id="exprType" hidden="">
    <div>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk00" value="00"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk01" value="01"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk02" value="02"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk03" value="03"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk04" value="04"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk05" value="05"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk06" value="06"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk07" value="07"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk08" value="08"></td>
            </tr>


            <tr>
                <th class="name" title="0"><span class="b0">0</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk09" value="09"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk10" value="10"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk11" value="11"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk12" value="12"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk13" value="13"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk14" value="14"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk15" value="15"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk16" value="16"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk17" value="17"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk18" value="18"></td>
            </tr>


            <tr>
                <th class="name" title="1"><span class="b1">1</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk19" value="19"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk20" value="20"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk21" value="21"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk22" value="22"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk23" value="23"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk24" value="24"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk25" value="25"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk26" value="26"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk27" value="27"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk28" value="28"></td>
            </tr>


            <tr>
                <th class="name" title="2"><span class="b2">2</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk29" value="29"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk30" value="30"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk31" value="31"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk32" value="32"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk33" value="33"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk34" value="34"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk35" value="35"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk36" value="36"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk37" value="37"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk38" value="38"></td>
            </tr>


            <tr>
                <th class="name" title="3"><span class="b3">3</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk39" value="39"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk40" value="40"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk41" value="41"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk42" value="42"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk43" value="43"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk44" value="44"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk45" value="45"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk46" value="46"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk47" value="47"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk48" value="48"></td>
            </tr>


            <tr>
                <th class="name" title="4"><span class="b4">4</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk49" value="49"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk50" value="50"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk51" value="51"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk52" value="52"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk53" value="53"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk54" value="54"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk55" value="55"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk56" value="56"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk57" value="57"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk58" value="58"></td>
            </tr>


            <tr>
                <th class="name" title="5"><span class="b5">5</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk59" value="59"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk60" value="60"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk61" value="61"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk62" value="62"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk63" value="63"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk64" value="64"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk65" value="65"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk66" value="66"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk67" value="67"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk68" value="68"></td>
            </tr>


            <tr>
                <th class="name" title="6"><span class="b6">6</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk69" value="69"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk70" value="70"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk71" value="71"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk72" value="72"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk73" value="73"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk74" value="74"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk75" value="75"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk76" value="76"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk77" value="77"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk78" value="78"></td>
            </tr>


            <tr>
                <th class="name" title="7"><span class="b7">7</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk79" value="79"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk80" value="80"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk81" value="81"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk82" value="82"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk83" value="83"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk84" value="84"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk85" value="85"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk86" value="86"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk87" value="87"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk88" value="88"></td>
            </tr>


            <tr>
                <th class="name" title="8"><span class="b8">8</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk89" value="89"></td>
            </tr>

            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th>{{$arr[0]}}位</th>
                <th>{{$arr[1]}}位</th>
                <th>选择</th>
            </tr>

            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="0"><span class="b0">0</span></th>
                <td class="check"><input type="checkbox" name="chk90" value="90"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="1"><span class="b1">1</span></th>
                <td class="check"><input type="checkbox" name="chk91" value="91"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="2"><span class="b2">2</span></th>
                <td class="check"><input type="checkbox" name="chk92" value="92"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="3"><span class="b3">3</span></th>
                <td class="check"><input type="checkbox" name="chk93" value="93"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="4"><span class="b4">4</span></th>
                <td class="check"><input type="checkbox" name="chk94" value="94"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="5"><span class="b5">5</span></th>
                <td class="check"><input type="checkbox" name="chk95" value="95"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="6"><span class="b6">6</span></th>
                <td class="check"><input type="checkbox" name="chk96" value="96"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="7"><span class="b7">7</span></th>
                <td class="check"><input type="checkbox" name="chk97" value="97"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="8"><span class="b8">8</span></th>
                <td class="check"><input type="checkbox" name="chk98" value="98"></td>
            </tr>


            <tr>
                <th class="name" title="9"><span class="b9">9</span></th>
                <th class="name" title="9"><span class="b9">9</span></th>
                <td class="check"><input type="checkbox" name="chk99" value="99"></td>
            </tr>

            </tbody>
        </table>
    </div>
</div>
