@php use App\ort\common\Constants; @endphp
<table class="list data_table info_table" style="width: 400px;">
    <tbody>
    <tr>
        <th>账号</th>
        <td>{{$user['username']}}</td>
    </tr>
    <tr>
        <th>快开彩额度</th>
        <td>
            @if($user['fudong']==0){{$kmaxmoney}}@else{{$kmoney}}@endif
            @if($bankatm==1)
            <input type="button" value="提取全部额度" onclick="openInputTransferPasswordDialog('{{$user['username']}}',0, false)">
            @else
            <input type="button" value="提取全部额度" onclick="extractAccount('{{$user['username']}}',0)" /></td>
            @endif
    </tr>
    @if($user['fudong']==0)<tr><th>当前余额：</th><td>{{$kmoney}}</td></tr>@endif
    <tr><th>上级可用额度</th><td>@if($user['fid']==Constants::$SUID)无限@else{{$fkmoney}}@endif</td></tr>
    <tr>
        <th>类型</th>
        <td><label><input type="radio" name="types" value="0" />存款</label> <label><input
            type="radio" name="types" value="1" />提款</label></td>
    </tr>
    <tr>
        <th>金额</th>
        <td><input name="balance" value="" onkeypress="return isNumber(event)" class="input" /> <span id="popDx" class="dx"></span></td>
    </tr>
    <tr>
        <th></th>
        @if($bankatm == 1)
        <td><input id="btnOK" type="button" value="确定" onclick="openInputTransferPasswordDialog('{{$user['username']}}', 0, true)"></td>
        @else
        <td><input id="btnOK" type="button" value="确定" onclick="adminEditAccount('{{$user['username']}}')" /></td>
        @endif
    </tr>
    </tbody>
</table>
