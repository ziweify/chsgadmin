@php use App\ort\common\Constants; @endphp
<table class="list data_table info_table" style="width: 400px;">
    <tbody>
    <tr>
        <th>账号</th>
        <td>{{$user['username']}}</td>
    </tr>
    <tr>
        <th>百胜币余额</th>
        <td>{{$user['bsb_coin']}}</td>
    </tr>
    <tr>
        <th>类型</th>
        <td><label><input type="radio" name="types" value="0" />上分</label> <label><input
                    type="radio" name="types" value="1" />下分</label></td>
    </tr>
    <tr>
        <th>金额</th>
        <td><input name="balance" value="" onkeypress="return isNumber(event)" class="input" /> <span id="popDx" class="dx"></span></td>
    </tr>
    <tr>
        <th></th>
        <td><input id="btnOK" type="button" value="确定" onclick="adminEditAccount('{{$user['userid']}}',1,'{{$user['ruid']}}')" /></td>
    </tr>
    </tbody>
</table>
