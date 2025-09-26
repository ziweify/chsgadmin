
<table class="list data_table">
    <thead><tr><th>类型</th><th>账号</th><th>占成</th><th>退水</th></tr></thead>
    <tbody>
    @foreach($bao as $vo)
    <tr><td>{{$vo['layer']}}</td><td>{{$vo['user']}}</td><td>{{$vo['zc']}}%</td><td>{{$vo['points']}}%</td></tr>
    @endforeach
    </tbody>
</table>
