<ul class="tab">
    <li class="tab_title02">
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS1" @if($index == 'TS1')class="on"@endif>前三组选六</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS2" @if($index == 'TS2')class="on"@endif>中三组选六</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS3" @if($index == 'TS3')class="on"@endif>后三组选六</a>
    </li>
</ul>
<table class="table_ball">
    <tbody><tr class="head"><th>种类</th><th>{{$fl[1]}}</th></tr>
    <tr><td>赔率</td>
        <td><span id="empOdds" class="odds" style="display: inline;">--</span><span id="o_ZX6TS1_4" class="odds" style="display: none;">--</span><span id="o_ZX6TS1_5" class="odds" style="display: none;">--</span><span id="o_ZX6TS1_6" class="odds" style="display: none;">--</span><span id="o_ZX6TS1_7" class="odds" style="display: none;">--</span><span id="o_ZX6TS1_8" class="odds" style="display: none;">--</span></td>
    </tr>
    </tbody></table>
<div class="status_panel">
    <table class="table_ball">
        <tbody><tr>
            <th class="name" title="0">0</th><td class="check"><input type="checkbox" value="0"></td>

            <th class="name" title="5">5</th><td class="check"><input type="checkbox" value="5"></td>
        </tr>
        <tr>
            <th class="name" title="1">1</th><td class="check"><input type="checkbox" value="1"></td>

            <th class="name" title="6">6</th><td class="check"><input type="checkbox" value="6"></td>
        </tr>
        <tr>
            <th class="name" title="2">2</th><td class="check"><input type="checkbox" value="2"></td>

            <th class="name" title="7">7</th><td class="check"><input type="checkbox" value="7"></td>
        </tr>
        <tr>
            <th class="name" title="3">3</th><td class="check"><input type="checkbox" value="3"></td>

            <th class="name" title="8">8</th><td class="check"><input type="checkbox" value="8"></td>
        </tr>
        <tr>
            <th class="name" title="4">4</th><td class="check"><input type="checkbox" value="4"></td>

            <th class="name" title="9">9</th><td class="check"><input type="checkbox" value="9"></td>
        </tr>
        </tbody></table>
</div>
