<table class="list data_table info_table" style="width: 400px;">
    <tbody>
    <tr>
        <th>彩种</th>
        <td>{{$game['gname']}}</td>
    </tr>
    <tr>
        <th>封盘时间</th>
        <td><input id="fengpan" name="fengpan" value="{{$game['userclosetime']}}" class="input"/></td>
    </tr>
    <tr>
        <th>彩种排序</th>
        <td><input id="sort" name="sort" value="{{$game['xsort']}}" class="input"/></td>
    </tr>
    <tr>
        <th>状态</th>
        <td>
            <label><input @if($game['pause'] == 0)checked @endif id="pause" type="radio" name="pause" value="0"/>正常</label>
            <label><input @if($game['pause'] == 1)checked @endif id="pause" type="radio" name="pause" value="1"/>暂停</label>
        </td>
    </tr>
    <tr>
        <th>采集模式</th>
        <td>
            <label><input @if($cs['cjmode'] == 0)checked @endif id="cjmode" type="radio" name="cjmode" value="0"/>168开奖</label>
            @if($isauth == 1)
            <label><input @if($cs['cjmode'] == 1)checked @endif id="cjmode" type="radio" name="cjmode" value="1"/>随机开奖</label>
            {{--<label><input @if($cs['cjmode'] == 2)checked @endif id="cjmode" type="radio" name="cjmode" value="2"/>系投开奖</label>--}}
            @endif
        </td>
    </tr>
    <tr class="kongzhi">
        <th>开奖模式</th>
        <td>
            <label><input @if($cs['xtmode'] == 0)checked @endif id="xtmode" type="radio" name="xtmode" value="0"/>随机开</label>
            <label><input @if($cs['xtmode'] == 3)checked @endif id="xtmode" type="radio" name="xtmode" value="3"/>随机赢</label>
            <label><input @if($cs['xtmode'] == 2)checked @endif id="xtmode" type="radio" name="xtmode" value="2"/>赢最多</label>
            <label><input @if($cs['xtmode'] == 1)checked @endif id="xtmode" type="radio" name="xtmode" value="1"/>赢最少</label>
            <label><input @if($cs['xtmode'] == -1)checked @endif id="xtmode" type="radio" name="xtmode" value="-1"/>输最少</label>
            <label><input @if($cs['xtmode'] == -2)checked @endif id="xtmode" type="radio" name="xtmode" value="-2"/>输最多</label>
            <label><input @if($cs['xtmode'] == -3)checked @endif id="xtmode" type="radio" name="xtmode" value="-3"/>随机输</label>
        </td>
    </tr>
    <tr class="kongzhi">
        <th>起控金额</th>
        <td><input id="kongje" name="kongje" value="{{$cs['kongje']}}" class="input"/></td>
    </tr>
    <tr class="kongzhi">
        <th>盈利上限</th>
        <td><input id="ylup" name="ylup" value="{{$cs['ylup']}}" class="input"/></td>
    </tr>
    <tr>
        <th></th>
        <td><input id="btnOK" type="button" value="确定" onclick="editLottery('{{$game['lottery']}}',6)"/></td>
    </tr>
    </tbody>
</table>
<script>
    kongzhishowhide();
</script>
