<ul class="tab">
    <li class="tab_title02">
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=0" @if($index == '' || $index == 0)class="on"@endif>前三定位</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=1" @if($index == 1)class="on"@endif>中三定位</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=2" @if($index == 2)class="on"@endif>后三定位</a>
    </li>
</ul>
<table>
    <tbody><tr class="head"><th>种类</th><th>三字定位</th></tr>
    <tr><td>赔率</td>
        <td><span id="o_{{$fl[0]}}" class="odds">--</span></td>
    </tr>
    </tbody></table>
<ul class="tab">
    <li class="tab_title02">
        <a href="#" id="fastChoose1" class="on" style="width:150px;">{{$fl[1]}}位快选</a>
        <a href="#" id="fastChoose2" style="width:150px;">选项快选</a>
    </li>
</ul>
<div class="status_panel">
    <table class="table_ball">
        <tbody><tr class="head"><th colspan="12">佰位</th></tr>
        <tr class="head"><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th></tr>
        <tr>
            <th class="name" title="0"><span class="b0">0</span></th><td class="check"><input type="checkbox" name="chk0" value="0"></td>

            <th class="name" title="1"><span class="b1">1</span></th><td class="check"><input type="checkbox" name="chk0" value="1"></td>

            <th class="name" title="2"><span class="b2">2</span></th><td class="check"><input type="checkbox" name="chk0" value="2"></td>

            <th class="name" title="3"><span class="b3">3</span></th><td class="check"><input type="checkbox" name="chk0" value="3"></td>

            <th class="name" title="4"><span class="b4">4</span></th><td class="check"><input type="checkbox" name="chk0" value="4"></td>
        </tr>
        <tr>
            <th class="name" title="5"><span class="b5">5</span></th><td class="check"><input type="checkbox" name="chk0" value="5"></td>

            <th class="name" title="6"><span class="b6">6</span></th><td class="check"><input type="checkbox" name="chk0" value="6"></td>

            <th class="name" title="7"><span class="b7">7</span></th><td class="check"><input type="checkbox" name="chk0" value="7"></td>

            <th class="name" title="8"><span class="b8">8</span></th><td class="check"><input type="checkbox" name="chk0" value="8"></td>

            <th class="name" title="9"><span class="b9">9</span></th><td class="check"><input type="checkbox" name="chk0" value="9"></td>
        </tr>
        </tbody></table>
    <table class="table_ball">
        <tbody><tr class="head"><th colspan="12">拾位</th></tr>
        <tr class="head"><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th></tr>
        <tr>
            <th class="name" title="0"><span class="b0">0</span></th><td class="check"><input type="checkbox" name="chk1" value="0"></td>

            <th class="name" title="1"><span class="b1">1</span></th><td class="check"><input type="checkbox" name="chk1" value="1"></td>

            <th class="name" title="2"><span class="b2">2</span></th><td class="check"><input type="checkbox" name="chk1" value="2"></td>

            <th class="name" title="3"><span class="b3">3</span></th><td class="check"><input type="checkbox" name="chk1" value="3"></td>

            <th class="name" title="4"><span class="b4">4</span></th><td class="check"><input type="checkbox" name="chk1" value="4"></td>
        </tr>
        <tr>
            <th class="name" title="5"><span class="b5">5</span></th><td class="check"><input type="checkbox" name="chk1" value="5"></td>

            <th class="name" title="6"><span class="b6">6</span></th><td class="check"><input type="checkbox" name="chk1" value="6"></td>

            <th class="name" title="7"><span class="b7">7</span></th><td class="check"><input type="checkbox" name="chk1" value="7"></td>

            <th class="name" title="8"><span class="b8">8</span></th><td class="check"><input type="checkbox" name="chk1" value="8"></td>

            <th class="name" title="9"><span class="b9">9</span></th><td class="check"><input type="checkbox" name="chk1" value="9"></td>
        </tr>
        </tbody></table>
    <table class="table_ball">
        <tbody><tr class="head"><th colspan="12">个位</th></tr>
        <tr class="head"><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th></tr>
        <tr>
            <th class="name" title="0"><span class="b0">0</span></th><td class="check"><input type="checkbox" name="chk2" value="0"></td>

            <th class="name" title="1"><span class="b1">1</span></th><td class="check"><input type="checkbox" name="chk2" value="1"></td>

            <th class="name" title="2"><span class="b2">2</span></th><td class="check"><input type="checkbox" name="chk2" value="2"></td>

            <th class="name" title="3"><span class="b3">3</span></th><td class="check"><input type="checkbox" name="chk2" value="3"></td>

            <th class="name" title="4"><span class="b4">4</span></th><td class="check"><input type="checkbox" name="chk2" value="4"></td>
        </tr>
        <tr>
            <th class="name" title="5"><span class="b5">5</span></th><td class="check"><input type="checkbox" name="chk2" value="5"></td>

            <th class="name" title="6"><span class="b6">6</span></th><td class="check"><input type="checkbox" name="chk2" value="6"></td>

            <th class="name" title="7"><span class="b7">7</span></th><td class="check"><input type="checkbox" name="chk2" value="7"></td>

            <th class="name" title="8"><span class="b8">8</span></th><td class="check"><input type="checkbox" name="chk2" value="8"></td>

            <th class="name" title="9"><span class="b9">9</span></th><td class="check"><input type="checkbox" name="chk2" value="9"></td>
        </tr>
        </tbody></table>
</div>
<div class="check_panel" id="instantCheck" hidden="">
    <table class="table_ball">
        <tbody><tr>
            <th class="name" style="padding:0 15px;width:50px;">佰位</th>
            <td><div style="float:left;"><input type="checkbox" value="快选" id="fsOddNum"><span>单数</span></div>
                <div style="float:left;"><input type="checkbox" value="快选" id="fsEvenNum"><span>双数</span></div>
                <div><span>含</span><input type="text" id="fsInclude" style="width:30px;"></div>
            </td>

            <th class="name" style="padding:0 15px;width:50px;">双重</th>
            <td><div style="float:left;"><input type="checkbox" value="快选" id="doubleNum"><span>取</span></div>
                <div><input type="checkbox" value="快选" id="doubleNumX"><span>除</span></div></td>

            <th class="name" style="padding:0 15px;width:50px;">二兄弟</th>
            <td><div style="float:left;"><input type="checkbox" value="快选" id="twoBroNum"><span>取</span></div>
                <div><input type="checkbox" value="快选" id="twoBroNumX"><span>除</span></div></td>

        </tr>

        <tr>
            <th class="name" style="padding:0 15px;width:50px;">拾位</th>
            <td><div style="float:left;"><input type="checkbox" value="快选" id="secOddNum"><span>单数</span></div>
                <div style="float:left;"><input type="checkbox" value="快选" id="secEvenNum"><span>双数</span></div>
                <div><span>含</span><input type="text" id="secInclude" style="width:30px;"></div>
            </td>

            <th class="name" style="padding:0 15px;width:50px;">三重</th>
            <td><div style="float:left;"><input type="checkbox" value="快选" id="tripleNum"><span>取</span></div>
                <div><input type="checkbox" value="快选" id="tripleNumX"><span>除</span></div></td>

            <th class="name" style="padding:0 15px;width:50px;">三兄弟</th>
            <td><div style="float:left;"><input type="checkbox" value="快选" id="threeBroNum"><span>取</span></div>
                <div><input type="checkbox" value="快选" id="threeBroNumX"><span>除</span></div></td>
        </tr>

        <tr>
            <th class="name" style="padding:0 15px;width:50px;">个位</th>
            <td><div style="float:left;"><input type="checkbox" value="快选" id="trdOddNum"><span>单数</span></div>
                <div style="float:left;"><input type="checkbox" value="快选" id="trdEvenNum"><span>双数</span></div>
                <div><span>含</span><input type="text" id="trdInclude" style="width:30px;"></div>
            </td>

            <th class="name" style="padding:0 15px;width:40px;">数字</th>
            <td colspan="3"><div><div style="float:left;"><span>含</span><input type="text" id="contain" style="width:30px;"></div>
                    <div><span>排除</span><input type="text" id="exclude" style="width:30px;"></div></div></td>
        </tr>
        </tbody></table>
</div>
<div class="split_panel" id="exprType" hidden="">
    <div class="bet_table"></div>
</div>
