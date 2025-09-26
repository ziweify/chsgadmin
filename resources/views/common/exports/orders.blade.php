<table>
    <thead>
    <tr>
        <th>注单号</th>
        <th>投注时间</th>
        <th>投注种类</th>
        <th>账号</th>
        <th>投注内容</th>
        <th>下注金额</th>
        <th>退水</th>
        <th>下注结果</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $vo)
        <tr>
            <td>{{ $vo['code'] }}</td>
            <td>{{$vo['time']}} 星期{{$vo['week']}}</td>
            <td>{{ $vo['game'] }}-{{$vo['qishu']}}期</td>
            <td>{{ $vo['user'] }}-{{$vo['abcd']}}盘</td>
            <td>{{$vo['wf']}} @ {{$vo['peilv1']}}</td>
            <td>{{ $vo['je'] }}</td>
            <td>{{ $vo['points'] }}%</td>
            <td>@if($vo['z'] == 9)未结算@else{{$vo['rs']}}@endif</td>
        </tr>
    @endforeach
    </tbody>
</table>
