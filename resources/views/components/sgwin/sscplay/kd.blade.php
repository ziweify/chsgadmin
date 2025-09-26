<ul class="tab">
    <li class="tab_title02">
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS1" @if($index == 'TS1')class="on"@endif>前三组跨度</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS2" @if($index == 'TS2')class="on"@endif>中三组跨度</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=TS3" @if($index == 'TS3')class="on"@endif>后三组跨度</a>
    </li>
</ul>
<table class="table_ball">
    <tbody><tr>
        <th class="GKD{{$index}}_0 name" id="t_KD{{$index}}_0" title="{{$gameName}} 0"><input type="hidden" id="k_KD{{$index}}_0" value="KD">0</th>

        <td class="GKD{{$index}}_0 odds" id="o_KD{{$index}}_0">--</td>
        <td class="GKD{{$index}}_0 amount ha" id="a_KD{{$index}}_0"><input name="KD{{$index}}_0" class="ba"></td>

        <th class="GKD{{$index}}_5 name" id="t_KD{{$index}}_5" title="{{$gameName}} 5"><input type="hidden" id="k_KD{{$index}}_5" value="KD">5</th>

        <td class="GKD{{$index}}_5 odds" id="o_KD{{$index}}_5">--</td>
        <td class="GKD{{$index}}_5 amount ha" id="a_KD{{$index}}_5"><input name="KD{{$index}}_5" class="ba"></td>
    </tr>
    <tr>
        <th class="GKD{{$index}}_1 name" id="t_KD{{$index}}_1" title="{{$gameName}} 1"><input type="hidden" id="k_KD{{$index}}_1" value="KD">1</th>

        <td class="GKD{{$index}}_1 odds" id="o_KD{{$index}}_1">--</td>
        <td class="GKD{{$index}}_1 amount ha" id="a_KD{{$index}}_1"><input name="KD{{$index}}_1" class="ba"></td>

        <th class="GKD{{$index}}_6 name" id="t_KD{{$index}}_6" title="{{$gameName}} 6"><input type="hidden" id="k_KD{{$index}}_6" value="KD">6</th>

        <td class="GKD{{$index}}_6 odds" id="o_KD{{$index}}_6">--</td>
        <td class="GKD{{$index}}_6 amount ha" id="a_KD{{$index}}_6"><input name="KD{{$index}}_6" class="ba"></td>
    </tr>
    <tr>
        <th class="GKD{{$index}}_2 name" id="t_KD{{$index}}_2" title="{{$gameName}} 2"><input type="hidden" id="k_KD{{$index}}_2" value="KD">2</th>

        <td class="GKD{{$index}}_2 odds" id="o_KD{{$index}}_2">--</td>
        <td class="GKD{{$index}}_2 amount ha" id="a_KD{{$index}}_2"><input name="KD{{$index}}_2" class="ba"></td>

        <th class="GKD{{$index}}_7 name" id="t_KD{{$index}}_7" title="{{$gameName}} 7"><input type="hidden" id="k_KD{{$index}}_7" value="KD">7</th>

        <td class="GKD{{$index}}_7 odds" id="o_KD{{$index}}_7">--</td>
        <td class="GKD{{$index}}_7 amount ha" id="a_KD{{$index}}_7"><input name="KD{{$index}}_7" class="ba"></td>
    </tr>
    <tr>
        <th class="GKD{{$index}}_3 name" id="t_KD{{$index}}_3" title="{{$gameName}} 3"><input type="hidden" id="k_KD{{$index}}_3" value="KD">3</th>

        <td class="GKD{{$index}}_3 odds" id="o_KD{{$index}}_3">--</td>
        <td class="GKD{{$index}}_3 amount ha" id="a_KD{{$index}}_3"><input name="KD{{$index}}_3" class="ba"></td>

        <th class="GKD{{$index}}_8 name" id="t_KD{{$index}}_8" title="{{$gameName}} 8"><input type="hidden" id="k_KD{{$index}}_8" value="KD">8</th>

        <td class="GKD{{$index}}_8 odds" id="o_KD{{$index}}_8">--</td>
        <td class="GKD{{$index}}_8 amount ha" id="a_KD{{$index}}_8"><input name="KD{{$index}}_8" class="ba"></td>
    </tr>
    <tr>
        <th class="GKD{{$index}}_4 name" id="t_KD{{$index}}_4" title="{{$gameName}} 4"><input type="hidden" id="k_KD{{$index}}_4" value="KD">4</th>

        <td class="GKD{{$index}}_4 odds" id="o_KD{{$index}}_4">--</td>
        <td class="GKD{{$index}}_4 amount ha" id="a_KD{{$index}}_4"><input name="KD{{$index}}_4" class="ba"></td>

        <th class="GKD{{$index}}_9 name" id="t_KD{{$index}}_9" title="{{$gameName}} 9"><input type="hidden" id="k_KD{{$index}}_9" value="KD">9</th>

        <td class="GKD{{$index}}_9 odds" id="o_KD{{$index}}_9">--</td>
        <td class="GKD{{$index}}_9 amount ha" id="a_KD{{$index}}_9"><input name="KD{{$index}}_9" class="ba"></td>
    </tr>
    </tbody></table>
