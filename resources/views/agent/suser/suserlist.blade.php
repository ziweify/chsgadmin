@foreach($user as $key => $vo)
 <TR layer='{{$vo['layer']}}' uid="{{$vo['userid']}}" fid="{{$vo['fid']}}" fname="{{$vo['fname']}}" username='{{$vo['username']}}'
 	ifagent='{{$vo['ifagent']}}' wid='{{$vo['wid']}}' class="in{{$vo['userid']}}" fudong='{{$vo['fudong']}}' fids='{{$vo['userid']}},{{$vo['fids']}}'
 	types='{{$vo['ifagent']==1?"ag":"us"}}'>
 	<td><input type="checkbox" value="{{$vo['userid']}}" /></td>
 	<td class="online">@if($vo['online']==0)<span class='s0'></span>@else<span class='s1 zhuxiao' title='注销'></span>@endif</td>
	 <td class="online1">*</td>
 	<td class="parent">{{$vo['upuser']}}</td>
 	<td class="type">@if($vo['fudong']==0)信用@else现金@endif<BR />{{$vo['layername']}}</td>
 	<td class="username"><a href='javascript:void(0);' @if($vo['ifagent']==1) class='showdown' layertype=0 @endif>{{$vo['username']}} </a>[{{$vo['name']}}]</td>
    @if($config['fasttype']==1 || $vo['fudong']==0)
 	<td class="account">
        @if($vo['ifagent']==1)
 		<a href='javascript:void(0);' class="kmaxmoney">{{$vo['kmoney']}}</a>
 		@else
 		<a href='javascript:void(0);' class="kmaxmoney">{{$vo['kmoney']}}</a>
 		@endif
 	</td>
 	@endif
    @if($config['slowtype']==1)
 	<td class="account" style="display: none;">
        @if($vo['ifagent']==1)
 		<a href='javascript:void(0);' class="maxmoney">{{$vo['money']}}</a>
 		@else
 		<a href='javascript:void(0);' class="maxmoney">{{$vo['money']}}</a>
 		@endif
 	</td>
 	@endif
 	<td class="share"><a href='javascript:void(0);' class="zcmx">明细</a></td>
    @if($vo['ifagent']==0)
 	<td class="branch">{{$vo['pan']}}盘</td>
 	@else
 	<!--<td class="branch">{{$vo['downnum']}}</td>-->
 	<td class="branch"><a href='javascript:void(0);' class='showdown' layertype=0>{{$vo['downnumag']}}</a></td>
 	<td class="branch"><a href='javascript:void(0);' class='showdown' layertype=1>{{$vo['downnumu']}}</a></td>
 	<td class="new">
 		@if(($vo['layer']+1)<$vo['maxlayer'])<a href='javascript:void(0);' class='bu_ico ico_dl add' types='ag'>代理</a>@endif
 			<a href='javascript:void(0);' class='bu_ico ico_hy add' types='us'>会员</a>
 	</td>
 	@endif
 	<td class="create">{{$vo['regtime']}}</td>
 	<td class="status"><input type="button" class="s{{$vo['status']}}" v="{{$vo['status']}}" value="{{$vo['statusz']}}"></td>
 	<TD class="op">
 		<a href='javascript:void(0);' class="modify edit">修改</a>
 		<a href='javascript:void(0);' class="commission setpoints">退水</a>
 		<a href='javascript:void(0);' class="login_log info logininfo">日志</a>
 		<a href='javascript:void(0);' class="op_log record">记录</a>
 	</TD>
 </TR>
 @endforeach
 <input type="hidden" class='pageinfo' pcount='{{$pcount}}' rcount='{{$rcount}}' upage='{{$upage}}' />
