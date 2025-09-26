
<table class="list data_table">
    <thead>
    <tr>
        <th>类型/账号</th>
        @foreach($glist as $v)
            <th class="account" >{{$v}}</th>
        @endforeach
        <th class="account" style="display: none" >第三方</th>
    </tr>
    </thead>
    <tbody>
    @foreach($u as $k=>$v)
        <tr>
            <td>{{$n[$k]['layername']}}/{{$n[$k]['username']}}</td>
            @foreach($glist as $k1=>$v1)
                <td >{{$zc[$k1][$k]['zc']}}%</td>
            @endforeach
            <td style="display: none" >0%</td>
        </tr>
    @endforeach
    </tbody>
</table>



