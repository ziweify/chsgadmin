<table class="list data_table info_table" style="width: 400px;">
    <tbody>
    <tr>
        <th>账号</th>
        <td>{{$username}}</td>
    </tr>
    <tr>
        <th>操作密码</th>
        <td><input id="transferPassword" type="password" class="input" /></td>
    </tr>
    <tr>
        <th>确认操作密码</th>
        <td><input id="ckTransferPassword" type="password" class="input" /></td>
    </tr>
    <tr>
        <th></th>
        <td><input id="btnOK" type="button" value="确定" onclick="setupTransferPassword('{{$username}}', '0', 'openAccountEditDialogue')" /></td>
    </tr>
    </tbody>
</table>
