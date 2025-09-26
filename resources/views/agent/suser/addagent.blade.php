<table class="data_table info_table user_panel addtb list">
	<thead>
		<tr>
			<th colspan="2">新增{{$layername}}</th>
		</tr>
	</thead>
	<tbody>
		<TR>
			<th>{{$layernamefu}}账号：</th>
			<TD><label>{{$fname}}</label><input type="hidden" value="adduser" name='xtype' id='xtype' /><input
					type="hidden" value="{{$action}}" name='action' id='action' /></td>
		</TR>
		<tr>
			<th>{{$layername}}帐号：</th>
			<TD>
				<input type="text" name='username' id='username' class="input"
					maxlength="{{$namelength}}" /><span id="usernameMsg"></span>&nbsp;&nbsp;<select name='status'
					class='hides' layer='{{$layer}}' id='status'>
					<option value="1" selectef>可用</option>
					<option value="0">禁用</option>
					<option value="2">暂停</option>
				</select>
			</td>
		</tr>
		<TR class='hides'>
			<th>帐户类型：</th>
			<TD><select name="ifagent" id=ifagent>
					<option value="1">运营商</option>
				</select>&nbsp;&nbsp;(运营商/会员)</td>
		</TR>
		<TR>
			<th>登入密码：</th>
			<TD style='display: flex;align-items: center;'>
				<input type="text" name=password id=password class="input" style="margin-right: 5px;" />
				<input type="hidden" name=userpass id=userpass class="input" />
			</td>
		</TR>
		<TR>
			<th>{{$layername}}名称：</th>
			<TD style='display: flex;align-items: center;'><input style="margin-right: 5px;" type="text" name='name' id='name' class="input" /></td>
		</tr>
		<tr style="display: none;">
			<th>额度模式</th>
			<td>
                @if($fudong==0)
				<label><input disabled="disabled" type="radio" name="fudong" value="0" class="fudong" checked="checked">信用模式</label>
				<label><input disabled="disabled" type="radio" name="fudong" class="fudong" value="1">现金模式</label>
				@else
				<label><input type="radio" name="fudong" value="0" class="fudong" disabled="disabled">信用模式</label>
				<label><input type="radio" name="fudong" class="fudong" value="1" disabled="disabled"
						checked="checked">现金模式</label>
				@endif
			</td>
		</tr>
		<TR class="modetr" style="display: none;">
			<th>信用额度[低频]：</th>
			<TD><input type="text" name="maxmoney" id='maxmoney' class="input" value="" />&nbsp;&nbsp;<span id="dx"
					class="dx"></span>
				&nbsp;&nbsp;[上级余额
				<label>{{$maxmoney}}</label>
				]
			</td>
		</tr>
		<TR class="kmodetr" @if($config['fasttype']!=1)style='display:none;' @endif>
			<th>快开彩额度：</th>
			<TD><input type="text" name="kmaxmoney" id='kmaxmoney' class="input" value="" />&nbsp;&nbsp;<span id="dxk"
					class="dx"></span>
				&nbsp;&nbsp;[上级余额
				<label>{{$kmaxmoney}}</label>
				]
			</td>
		</tr>
		<TR class="fmodetr" @if($fudong==0)style='display:none;' @endif>
			<th>快开彩额度：</th>
			<TD><input type="text" name="fmaxmoney" id='fmaxmoney' class="input" value="" />&nbsp;&nbsp;<span id="dxf"
					class="dx"></span>
				&nbsp;&nbsp;[上级余额
				<label>{{$kmaxmoney}}</label>
				]
			</td>
		</tr>
		@if($layer<$maxlayer) @if($maxrenflag==1) <TR>
			<th>最多帐户数：</th>
			<TD><input type="text" class="input" name='maxren' id=maxren />
				[限额<label>{{$maxren}}</label>]
			</td>
			</tr>
			@endif
			@endif
			<TR>
				<th>开放盘口：</th>
				<TD>
                    @foreach($pan as $vo)
					<input class="pantype" type="checkbox" value="{{$vo}}" />
					{{$vo}}盘
                    @endforeach
					<select name="defaultpan" id='defaultpan' class="hide"></select>
				</td>
			</tr>
			<TR>
				<th>赚取退水：</th>
				<TD>
					<select name="liushui" id="liushui">
						<option value="0">水全退到底</option>
						<option value="0.1">赚取 0.1% 退水</option>
						<option value="0.3">赚取 0.3% 退水</option>
						<option value="0.5">赚取 0.5% 退水</option>
						<option value="1">赚取 1.0% 退水</option>
						<option value="1.5">赚取 1.5% 退水</option>
						<option value="2">赚取 2.0% 退水</option>
						<option value="2.5">赚取 2.5% 退水</option>
						<option value="100">赚取所有退水</option>
					</select>
				</td>
			</tr>
            @if($plc == 1)
                <TR>
                    <th>赚赔差功能</th>
                    <TD> <select name='plc' id='plc'>
                            <option value="0">关</option>
                            <option value="1">开</option>
                        </select>&nbsp;&nbsp;&nbsp;设置此帐户能否赚下级赔率差，如果关闭,该帐户所有下级也不能赚赔率差。
                    </td>
                </tr>
            @endif
			<tr class='hides'>
				<th>&nbsp;</th>
				<TD><input type="button" class="btn1 btnf add" value="新增{{$layername}}"
						style="margin-right:20px;" /><input type="button" class="btn1 btnf close" value="关闭窗口" /></td>
			</tr>
			<TR class='hides'>
				<Td colspan="2">
					<label>如果锁定占成，不管走补功能开放与否，该帐户将不能走补！</label>---会员略过!<BR />
					<label>本级收补占成=收补占成-直属下级收补占成，如果是直属下级走补，本级收补占成=收补占成-0</label>---会员略过!<BR />
					<label>如果直属下级的【上级占成】设为0，本级将没有收补占成</label>---会员略过!
				</Td>
			</TR>
	</tbody>
</table>
@if($config['zcmode']==1)
<table class="data_table info_table share_panel input_panel addtb2 list">
	<thead>
		<th colspan=7>占成设置</th>
		<tr class="shead">
			<th rowspan="2">彩种</th>
			<th rowspan="2">开关</th>
			<th rowspan="2">{{$layernamefu}}实际占成</th>
			<th colspan="2">{{$layername}}占成</th>
			<th rowspan="2">补货功能</th>
			<th rowspan="2">下线补货占成</th>
		</tr>
		<tr class="shead">
			<th>最低</th>
			<th>最高</th>
		</tr>
		<tr class="shead tongyi">
			<th>统一设置</th>
			<th><select id='ifok'>
					<option value="">请选择</option>
					<option value="0">关</option>
					<option value="1">开</option>
				</select>
			</th>
			<th><input type="text" class="share" id='upzc' /></th>
			<th><input type="text" class="share" id='zcmin' /></th>
			<th><input type="text" class="share" id='zc' /></th>
			<th><select id='flytype'>
					<option value="">请选择</option>
					<option value="0">关闭</option>
					<option value="1">内补</option>
					<option value="2">外补</option>
					<option value="3">内外补</option>
				</select>
			</th>
			<th><input type="text" class="share" id='flyzc' /></th>
		</tr>
	</thead>
	<tbody>
        @foreach($gamecs as $vo)
		<tr @if($vo['ifok']==0)style="display:none" @endif>
			<th gid='{{$vo['gid']}}'>{{$vo['gname']}}</th>
			<td><select class="ifok" val='{{$vo['ifok']}}'>
                    @if($vo['ifok']==0)
					<option value="0">关</option>
					@else
					<option value="0">关</option>
					<option value="1">开</option>
					@endif
				</select></td>
			<td>
				<input type="text" class="upzc share" maxzc='{{$vo['zc']}}' value='0' />(0% 至 {{$vo['zc']}}%)
			</td>
			<td>
				<input type="text" class="zcmin share" maxzc='{{$vo['zc']}}' value='0' />%
			</td>
			<td>
				<input type="text" class="zc share" maxzc='{{$vo['zc']}}'
					value='{{$vo['zc']}}' />(最大{{$vo['zc']}}%)
			</td>
			<td>
				<select class="flytype" val='{{$vo['flytype']}}'>
                    @if($vo['flytype']==0)
					<option value="0">关闭</option>
                    @elseif($vo['flytype']==1)
					<option value="0">关闭</option>
					<option value="1">内补</option>
                    @elseif($vo['flytype']==2)
					<option value="0">关闭</option>
					<option value="2">外补</option>
					@else
					<option value="0">关闭</option>
					<option value="1">内补</option>
					<option value="2">外补</option>
					<option value="3">内外补</option>
					@endif
				</select>
			</td>
			<td>
				<input type="text" class="flyzc share" maxzc='{{$vo['flyzc']}}' value='{{$vo['flyzc']}}' />(0% 至
				{{$vo['flyzc']}}%)
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@else
<table class="data_table info_table share_panel input_panel addtb2 list">
	<thead>
		<th colspan=6>占成设置</th>
		<tr class="shead">
			<th rowspan="2">类型</th>
			<th rowspan="2">{{$layernamefu}}实际占成</th>
			<th colspan="2">{{$layername}}占成</th>
			<th rowspan="2">补货功能</th>
			<th rowspan="2">下线补货占成</th>
		</tr>
		<tr class="shead">
			<th>最低</th>
			<th>最高</th>
		</tr>
	</thead>
	<tbody>
        @foreach($gamecs as $vo)
		<tr @if($vo['typeid']==1 && $config['fasttype']==0)style='display:none' @endif @if(($vo['typeid']==0 && $config['slowtype']==0))style='display:none' @endif>
			<th typeid='{{$vo['typeid']}}'>{{$vo['typename']}}</th>
			<td>
				<input type="text" class="upzc share" maxzc='{{$vo['zc']}}' value='0' />(0% 至 {{$vo['zc']}}%)
			</td>
			<td>
				<input type="text" class="zcmin share" maxzc='{{$vo['zc']}}' value='0' />%
			</td>
			<td>
				<input type="text" class="zc share" maxzc='{{$vo['zc']-$vo['zcmin']}}'
					value='{{$vo['zc']-$vo['zcmin']}}' />(最大{{$vo['zc']}}%)
			</td>
			<td>
				<select class="flytype" val='{{$vo['flytype']}}'>
                    @if($vo['flytype']==0)
					<option value="0">关闭</option>
                    @elseif($vo['flytype']==1)
					<option value="0">关闭</option>
					<option value="1">开放</option>
					@endif
				</select>
			</td>
			<td>
				<input type="text" class="flyzc share" maxzc='{{$vo['flyzc']}}' value='{{$vo['flyzc']}}' />(0% 至
				{{$vo['flyzc']}}%)
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif
<div class="data_footer control"><input type="button" value="确定" class="button add" /> <input type="button" value="取消"
		class="close button"></div>
