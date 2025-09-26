<ul class="tab">
    <li class="tab_title02">
        <a href="load?lottery={{$lottery}}&amp;page=zx&amp;index=2" @if($index == 2)class="on"@endif>前二直选</a
        ><a href="load?lottery={{$lottery}}&amp;page=zx&amp;index=3" @if($index == 3)class="on"@endif>前三直选</a>
    </li>

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
    @if($index == 2)
    <div class="status_panel">
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th colspan="12">第一球</th>
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
                <th>球</th>
                <th>选择</th>
            </tr>
            <tr>
                <th class="name" title="01"><span class="b01">01</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="01"></td>

                <th class="name" title="02"><span class="b02">02</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="02"></td>

                <th class="name" title="03"><span class="b03">03</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="03"></td>

                <th class="name" title="04"><span class="b04">04</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="04"></td>

                <th class="name" title="05"><span class="b05">05</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="05"></td>

                <th class="name" title="06"><span class="b06">06</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="06"></td>
            </tr>
            <tr>
                <th class="name" title="07"><span class="b07">07</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="07"></td>

                <th class="name" title="08"><span class="b08">08</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="08"></td>

                <th class="name" title="09"><span class="b09">09</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="09"></td>

                <th class="name" title="10"><span class="b10">10</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="10"></td>

                <th class="name" title="11"><span class="b11">11</span></th>
                <td class="check"><input type="checkbox" name="chk1" value="11"></td>
                <th class="name"></th>
                <td></td>
            </tr>
            </tbody>
        </table>
        <table class="table_ball">
            <tbody>
            <tr class="head">
                <th colspan="12">第二球</th>
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
                <th>球</th>
                <th>选择</th>
            </tr>
            <tr>
                <th class="name" title="01"><span class="b01">01</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="01"></td>

                <th class="name" title="02"><span class="b02">02</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="02"></td>

                <th class="name" title="03"><span class="b03">03</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="03"></td>

                <th class="name" title="04"><span class="b04">04</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="04"></td>

                <th class="name" title="05"><span class="b05">05</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="05"></td>

                <th class="name" title="06"><span class="b06">06</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="06"></td>
            </tr>
            <tr>
                <th class="name" title="07"><span class="b07">07</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="07"></td>

                <th class="name" title="08"><span class="b08">08</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="08"></td>

                <th class="name" title="09"><span class="b09">09</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="09"></td>

                <th class="name" title="10"><span class="b10">10</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="10"></td>

                <th class="name" title="11"><span class="b11">11</span></th>
                <td class="check"><input type="checkbox" name="chk2" value="11"></td>
                <th class="name"></th>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    @else
        <div class="status_panel">
            <table class="table_ball">
                <tbody><tr class="head"><th colspan="12">第一球</th></tr>
                <tr class="head"><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th></tr>
                <tr>
                    <th class="name" title="01"><span class="b01">01</span></th><td class="check"><input type="checkbox" name="chk1" value="01"></td>

                    <th class="name" title="02"><span class="b02">02</span></th><td class="check"><input type="checkbox" name="chk1" value="02"></td>

                    <th class="name" title="03"><span class="b03">03</span></th><td class="check"><input type="checkbox" name="chk1" value="03"></td>

                    <th class="name" title="04"><span class="b04">04</span></th><td class="check"><input type="checkbox" name="chk1" value="04"></td>

                    <th class="name" title="05"><span class="b05">05</span></th><td class="check"><input type="checkbox" name="chk1" value="05"></td>

                    <th class="name" title="06"><span class="b06">06</span></th><td class="check"><input type="checkbox" name="chk1" value="06"></td>
                </tr>
                <tr>
                    <th class="name" title="07"><span class="b07">07</span></th><td class="check"><input type="checkbox" name="chk1" value="07"></td>

                    <th class="name" title="08"><span class="b08">08</span></th><td class="check"><input type="checkbox" name="chk1" value="08"></td>

                    <th class="name" title="09"><span class="b09">09</span></th><td class="check"><input type="checkbox" name="chk1" value="09"></td>

                    <th class="name" title="10"><span class="b10">10</span></th><td class="check"><input type="checkbox" name="chk1" value="10"></td>

                    <th class="name" title="11"><span class="b11">11</span></th><td class="check"><input type="checkbox" name="chk1" value="11"></td>
                    <th class="name"></th><td></td></tr>
                </tbody></table>
            <table class="table_ball">
                <tbody><tr class="head"><th colspan="12">第二球</th></tr>
                <tr class="head"><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th></tr>
                <tr>
                    <th class="name" title="01"><span class="b01">01</span></th><td class="check"><input type="checkbox" name="chk2" value="01"></td>

                    <th class="name" title="02"><span class="b02">02</span></th><td class="check"><input type="checkbox" name="chk2" value="02"></td>

                    <th class="name" title="03"><span class="b03">03</span></th><td class="check"><input type="checkbox" name="chk2" value="03"></td>

                    <th class="name" title="04"><span class="b04">04</span></th><td class="check"><input type="checkbox" name="chk2" value="04"></td>

                    <th class="name" title="05"><span class="b05">05</span></th><td class="check"><input type="checkbox" name="chk2" value="05"></td>

                    <th class="name" title="06"><span class="b06">06</span></th><td class="check"><input type="checkbox" name="chk2" value="06"></td>
                </tr>
                <tr>
                    <th class="name" title="07"><span class="b07">07</span></th><td class="check"><input type="checkbox" name="chk2" value="07"></td>

                    <th class="name" title="08"><span class="b08">08</span></th><td class="check"><input type="checkbox" name="chk2" value="08"></td>

                    <th class="name" title="09"><span class="b09">09</span></th><td class="check"><input type="checkbox" name="chk2" value="09"></td>

                    <th class="name" title="10"><span class="b10">10</span></th><td class="check"><input type="checkbox" name="chk2" value="10"></td>

                    <th class="name" title="11"><span class="b11">11</span></th><td class="check"><input type="checkbox" name="chk2" value="11"></td>
                    <th class="name"></th><td></td></tr>
                </tbody></table>
            <table class="table_ball">
                <tbody><tr class="head"><th colspan="12">第三球</th></tr>
                <tr class="head"><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th><th>球</th><th>选择</th></tr>
                <tr>
                    <th class="name" title="01"><span class="b01">01</span></th><td class="check"><input type="checkbox" name="chk3" value="01"></td>

                    <th class="name" title="02"><span class="b02">02</span></th><td class="check"><input type="checkbox" name="chk3" value="02"></td>

                    <th class="name" title="03"><span class="b03">03</span></th><td class="check"><input type="checkbox" name="chk3" value="03"></td>

                    <th class="name" title="04"><span class="b04">04</span></th><td class="check"><input type="checkbox" name="chk3" value="04"></td>

                    <th class="name" title="05"><span class="b05">05</span></th><td class="check"><input type="checkbox" name="chk3" value="05"></td>

                    <th class="name" title="06"><span class="b06">06</span></th><td class="check"><input type="checkbox" name="chk3" value="06"></td>
                </tr>
                <tr>
                    <th class="name" title="07"><span class="b07">07</span></th><td class="check"><input type="checkbox" name="chk3" value="07"></td>

                    <th class="name" title="08"><span class="b08">08</span></th><td class="check"><input type="checkbox" name="chk3" value="08"></td>

                    <th class="name" title="09"><span class="b09">09</span></th><td class="check"><input type="checkbox" name="chk3" value="09"></td>

                    <th class="name" title="10"><span class="b10">10</span></th><td class="check"><input type="checkbox" name="chk3" value="10"></td>

                    <th class="name" title="11"><span class="b11">11</span></th><td class="check"><input type="checkbox" name="chk3" value="11"></td>
                    <th class="name"></th><td></td></tr>
                </tbody></table>
        </div>
    @endif
</ul>
