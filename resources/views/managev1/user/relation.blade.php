<table class="data_table list">
    <thead>
    <tr>
        <th class="online">在线</th>
        <th class="parent">账号</th>
        <th class="type">用户类型</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $vo)
    <tr class="">
        @if($vo['online'] == 1)
            <td class="online"><span class="s1">在线</span></td>
        @else
            <td class="online"><span class="s0">离线</span></td>
        @endif
        <td class="parent"><a href="list?name={{$vo['username']}}">{{$vo['username']}}</a></td>
        <td class="type">{{$vo['layername']}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
