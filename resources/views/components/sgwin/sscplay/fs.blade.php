<ul class="tab">
    <li class="tab_title02">
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS1" @if($index == 'TS1')class="on"@endif>前三复式</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS2" @if($index == 'TS2')class="on"@endif>中三复式</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS3" @if($index == 'TS3')class="on"@endif>后三复式</a>
    </li>
</ul>
<table class="table_ball">
    <tbody><tr class="head">
        <th>种类</th>
        <th>复式组合</th>
    </tr>
    <tr>
        <td>赔率</td>
        <td><span id="fs_odds" class="odds">--</span></td>
    </tr>
    </tbody></table>
<div class="status_panel">
    <table class="table_ball">
        <tbody><tr class="head">
            <th>万位</th>
            <th>勾选</th>
            <th>千位</th>
            <th>勾选</th>
            <th>佰位</th>
            <th>勾选</th>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="0">0</th>
            <td class="check"><input name="wan" type="checkbox" value="0"></td>
            <th class="name" style="width: 97px;" title="0">0</th>
            <td class="check"><input name="qian" type="checkbox" value="0"></td>
            <th class="name" style="width: 97px;" title="0">0</th>
            <td class="check"><input name="bai" type="checkbox" value="0"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="1">1</th>
            <td class="check"><input name="wan" type="checkbox" value="1"></td>
            <th class="name" style="width: 97px;" title="1">1</th>
            <td class="check"><input name="qian" type="checkbox" value="1"></td>
            <th class="name" style="width: 97px;" title="1">1</th>
            <td class="check"><input name="bai" type="checkbox" value="1"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="2">2</th>
            <td class="check"><input name="wan" type="checkbox" value="2"></td>
            <th class="name" style="width: 97px;" title="2">2</th>
            <td class="check"><input name="qian" type="checkbox" value="2"></td>
            <th class="name" style="width: 97px;" title="2">2</th>
            <td class="check"><input name="bai" type="checkbox" value="2"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="3">3</th>
            <td class="check"><input name="wan" type="checkbox" value="3"></td>
            <th class="name" style="width: 97px;" title="3">3</th>
            <td class="check"><input name="qian" type="checkbox" value="3"></td>
            <th class="name" style="width: 97px;" title="3">3</th>
            <td class="check"><input name="bai" type="checkbox" value="3"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="4">4</th>
            <td class="check"><input name="wan" type="checkbox" value="4"></td>
            <th class="name" style="width: 97px;" title="4">4</th>
            <td class="check"><input name="qian" type="checkbox" value="4"></td>
            <th class="name" style="width: 97px;" title="4">4</th>
            <td class="check"><input name="bai" type="checkbox" value="4"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="5">5</th>
            <td class="check"><input name="wan" type="checkbox" value="5"></td>
            <th class="name" style="width: 97px;" title="5">5</th>
            <td class="check"><input name="qian" type="checkbox" value="5"></td>
            <th class="name" style="width: 97px;" title="5">5</th>
            <td class="check"><input name="bai" type="checkbox" value="5"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="6">6</th>
            <td class="check"><input name="wan" type="checkbox" value="6"></td>
            <th class="name" style="width: 97px;" title="6">6</th>
            <td class="check"><input name="qian" type="checkbox" value="6"></td>
            <th class="name" style="width: 97px;" title="6">6</th>
            <td class="check"><input name="bai" type="checkbox" value="6"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="7">7</th>
            <td class="check"><input name="wan" type="checkbox" value="7"></td>
            <th class="name" style="width: 97px;" title="7">7</th>
            <td class="check"><input name="qian" type="checkbox" value="7"></td>
            <th class="name" style="width: 97px;" title="7">7</th>
            <td class="check"><input name="bai" type="checkbox" value="7"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="8">8</th>
            <td class="check"><input name="wan" type="checkbox" value="8"></td>
            <th class="name" style="width: 97px;" title="8">8</th>
            <td class="check"><input name="qian" type="checkbox" value="8"></td>
            <th class="name" style="width: 97px;" title="8">8</th>
            <td class="check"><input name="bai" type="checkbox" value="8"></td>
        </tr>
        <tr>
            <th class="name" style="width: 97px;" title="9">9</th>
            <td class="check"><input name="wan" type="checkbox" value="9"></td>
            <th class="name" style="width: 97px;" title="9">9</th>
            <td class="check"><input name="qian" type="checkbox" value="9"></td>
            <th class="name" style="width: 97px;" title="9">9</th>
            <td class="check"><input name="bai" type="checkbox" value="9"></td>
        </tr>


        </tbody></table>
</div>
