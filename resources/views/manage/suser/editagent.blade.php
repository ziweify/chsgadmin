<div class="top_info">
	<span class="title">{{$layername}} <span>{{$username}}（{{$name}}）</span> -&gt; 更改</span>
	<span class="right"><a class="back close">返回</a></span>
</div>
<ul class="tab">
	<li class="tab_title02">
		<a href="javascript:void(0);" class="selected">基本资料</a>
		<a href="javascript:void(0);" class="tuiset">退水设定</a>
	</li>
</ul>
<table class="data_table info_table user_panel edittb list">
	<thead style="display: none;">
		<tr>
			<th colspan="2" class="actionname" style="text-align:center" layer='{{$layer}}'></th>
		</tr>
	</thead>
	<tbody>
		<TR>
			<th>{{$layernamefu}}账号：</th>
			<TD><label>{{$fname}}</label></td>
		</TR>
		<tr>
			<th>{{$layername}}帐号：</th>
			<TD><label id='username' uid='{{$userid}}'>{{$username}}</label>&nbsp;&nbsp;<span class="statusControl">【
					<label><input type="radio" name="status" value="1" @if($status==1) checked="checked" @endif>启用</label>
					<label><input type="radio" name="status" value="2" @if($status==2) checked="checked" @endif>冻结</label>
					<label><input type="radio" name="status" value="0" @if($status==0) checked="checked" @endif>停用</label>
					】</span>
				</select><input type="hidden" value="edituser" name='xtype' id='xtype' /><input type="hidden"
					value="{{$action}}" name='action' id='action' /></td>

		</tr>
		<TR class='hides'>
			<th>帐户类型：</th>
			<TD><select name="ifagent" id=ifagent>
                    @if($layer==$maxlayer)
					<option value="0" @if($ifagent==0) selected @endif>会员</option>
					@else
					<option value="1" @if($ifagent==1) selected @endif>运营商</option>
					@if($layer>1)<option value="0" @if($ifagent==0) selected @endif>直属会员</option>@endif
					@endif
				</select>&nbsp;&nbsp;(运营商/会员)</td>
		</TR>
		<TR>
			<th>新密码：</th>
			<TD><input type="text" name="password" id="password" class="input" /><input type="hidden" name=userpass
					id=userpass class="input" /></td>
		</TR>
		<tr>
			<th>错误登录次数</th>
			<td>
				<div>
					<span class="errortimesstatus">{{$errortimes}}</span>&nbsp;&nbsp;<a href='javascript:void(0);'
						class="czpass">重置</a>
				</div>
			</td>
		</tr>
		<TR>
			<th>{{$layername}}名称：</th>
			<TD><input type="text" name='name' id='name' class="input" value='{{$name}}' /></td>
		</tr>
		<tr>
			<th>额度模式：</th>
			<td>
				<label><input type="radio" name="fudong" value="0" class="fudong" @if($fudong==0) checked="checked" @endif disabled />信用模式</label>
				<label><input type="radio" name="fudong" class="fudong" value="1" @if($fudong==1) checked="checked" @endif disabled />现金模式</label>
			</td>
		</tr>
		<TR class="modetr" @if($config['slowtype']!=1) style='display:none;' @endif>
			<th>信用额度[低频]：</th>
			<TD><input type="text" name="maxmoney" id='maxmoney' class="input hide"
					value="{{$maxmoney}}" /><span>{{$money}}</span>&nbsp;&nbsp;<span id="dx" class="dx"></span><span
					class="hide">
					&nbsp;&nbsp;[限额
					<label>{{$fidmaxmoney}}</label>]&nbsp;&nbsp;可用余额：<label id='money'>{{$money}}</label></span>&nbsp;<a href='javascript:void(0);'>修改</a></td>
		</tr>
		<TR class="kmodetr" @if($config['fasttype']!=1) style='display:none;' @endif>
			<th>快开彩额度：</th>
			<TD><input type="text" name="kmaxmoney" id='kmaxmoney' class="input hide"
					value="{{$kmaxmoney}}" /><span>{{$kmoney}}</span>&nbsp;&nbsp;<span id="dxk" class="dx"></span><span
					class="hide">
					&nbsp;&nbsp;
					[限额<label>{{$fidkmaxmoney}}</label>]&nbsp;&nbsp;可用余额：
					<label id='kmoney'>{{$kmoney}}</label></span>&nbsp;<a href='javascript:void(0);'>修改</a></td>
		</tr>
		<TR class="fmodetr" @if($fudong==0) style='display:none;' @endif>
			<th>快开彩额度：</th>
			<TD><input type="text" name="fmaxmoney" id='fmaxmoney' class="input hide"
					value="{{$kmaxmoney}}" /><span>{{$kmoney}}</span>&nbsp;&nbsp;<span id="dxf" class="dx"></span><span
					class="hide">
					&nbsp;&nbsp;
					[限额<label>{{$fidkmaxmoney}}</label>]</span>&nbsp;&nbsp;【余额：
				<label id='kmoney'>{{$kmoney}}</label>】&nbsp;&nbsp;<a href='javascript:void(0);'>修改</a>
			</td>
		</tr>
		@if($layer<$maxlayer)
            @if($maxrenflag==1)
            <tr>
                <th>最多帐户数：</th>
                <td><input type="text" class="input" name='maxren' id='maxren' value="{{$maxren}}" />
                    [限额<label>{{$fidmaxren}}</label>]
                </td>
			</tr>
			@endif
        @endif
			<TR>
				<th>开放盘口：</th>
				<TD>
                    @foreach($fidpan as $vo)
					<input class="pantype" @if(in_array($vo,$pans)) checked @endif type="checkbox" value="{{$vo}}" @if($dis==0) disabled @endif />{{$vo}}
					@endforeach
					<select name="defaultpan" id='defaultpan' class="hide">
                        @foreach($pans as $vo)
						<option value="{{$vo}}" @if($defaultpan==$vo) selected @endif>{{$vo}}</option>
						@endforeach
					</select>
				</td>
			</tr>
            @if($layer==1)
			<TR>
				<th>赔率调节：</th>
				<TD><select name='ifexe' id='ifexe'>
						<option value="0" @if($ifexe==0) selected @endif>关</option>
						<option value="1" @if($ifexe==1) selected @endif>开</option>
					</select></td>
			</TR>
			<tr>
				<th>赔率调节方式：</th>
				<TD><select name='pself' id='pself' style="width:210px;">
                        <option value="1" @if($pself==1) selected @endif>使用自设赔率</option>
                        {{--<option value="0" @if($pself==0) selected @endif>使用上级赔率(上级基础上加减)</option>--}}
					</select></td>
			</tr>
			{{--<TR>
				<th>参数设置：</th>
				<TD><select name='cssz' id='cssz'>
						<option value="0" @if($cssz==0) selected @endif>关</option>
						<option value="1" @if($cssz==1) selected @endif>开</option>
					</select>&nbsp;&nbsp;&nbsp;设置各盘赔率差</td>
			</TR>--}}
            <tr>
                <th>剩余占城归属</th>
                <td>
                    <label><input type="radio" name="zcobj" value="1" class="zcobj" @if($zcobj==1) checked="checked" @endif>集团</label>
                    <label><input type="radio" name="zcobj" class="zcobj" value="2" @if($zcobj==2) checked="checked" @endif>一级代理</label>
                </td>
            </tr>
			@endif
            @if($fidplc==1)
			<TR>
				<th>赔率差功能</th>
				<TD>
					<select name='plc' id='plc'>
						<option value="0" @if($plc==0) selected @endif>关</option>
						<option value="1" @if($plc==1) selected @endif>开</option>
					</select>&nbsp;&nbsp;&nbsp;设置此帐户能否赚下级赔率差，如果关闭,该帐户所有下级也不能赚赔率差。
				</td>
			</tr>
			@endif
			<tr class='hides'>
				<Td></Td>
				<TD><input type="button" class="btn1 btnf" id='edit' value="修改{{$layername}}"
						style="margin-right:20px;" /><input type="button" class="btn1 btnf close" value="关闭窗口" /></td>
			</tr>
			<TR class='hides'>
				<Td colspan="2" style="font-size:13px;color:#0063e3">
					备注：快开类型在【{{$editstart}}--{{$editend}}】修改才能生效，低频类型在开盘期间修改以下参数不会生效！管理员修改参数立即生效<br />
					<label>如果锁定占成，不管补货功能开放与否，该帐户将不能补货！</label>---会员略过!<BR />
					<label>本级吃补占成=吃补占成-直属下级吃补占成，如果是直属下级补货，本级吃补占成=吃补占成-0</label>---会员略过!<BR />
					<label>如果直属下级的【上级占成】设为0，本级将没有吃补占成</label>---会员略过!
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
        @foreach($fidgamecs as $vo)
		<tr @if($vo['ifok']==0) style="display:none" @endif>
			<th gid='{{$vo['gid']}}'>{{$vo['gname']}}</th>
			<td><select class="ifok" val='{{$vo['uifok']}}'>
                    @if($vo['ifok']==0)
					<option value="0">关</option>
					@else
					<option value="0">关</option>
					<option value="1">开</option>
					@endif
				</select></td>
			<td>
				<input type="text" class="upzc share" maxzc='{{$vo['zc']}}' value='{{$vo['uupzc']}}' />(0% 至 {{$vo['zc']}}%)
			</td>
			<td>
				<input type="text" class="zcmin share" maxzc='{{$vo['zc']}}' value='{{$vo['uzcmin']}}' />%
			</td>
			<td>
				<input type="text" class="zc share" maxzc='{{$vo['zc']}}'
					value='{{$vo['uzc']}}' />(最大{{$vo['zc']}}%)
			</td>
			<td>
				<select class="flytype" val='{{$vo['uflytype']}}'>
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
				<input type="text" class="flyzc share" maxzc='{{$vo['flyzc']}}'
					value='{{$vo['uflyzc']}}' />(0% 至 {{$vo['flyzc']}}%)
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
        @foreach($fidgamecs as $vo)
		<tr @if(($vo['typeid']==1 && $config['fasttype']==0)) style='display:none' @endif @if(($vo['typeid']==0 && $config['slowtype']==0)) style='display:none' @endif>
			<th typeid='{{$vo['typeid']}}'>{{$vo['typename']}}</th>
			<td>
				<input type="text" class="upzc share" maxzc='{{$vo['zc']}}' value='{{$vo['uupzc']}}' />(0% 至 {{$vo['zc']}}%)
			</td>
			<td>
				<input type="text" class="zcmin share" maxzc='{{$vo['zc']}}' value='{{$vo['uzcmin']}}' />%
			</td>
			<td>
				<input type="text" class="zc share" maxzc='{{$vo['zc']}}'
					value='{{$vo['uzc']}}' />(最大{{$vo['zc']}}%)
			</td>
			<td>
				<select class="flytype" val='{{$vo['uflytype']}}'>
                    @if($vo['flytype']==0)
					<option value="0">关闭</option>
                    @elseif($vo['flytype']==1)
					<option value="0">关闭</option>
					<option value="1">开放</option>
					@endif
				</select>
			</td>
			<td>
				<input type="text" class="flyzc share" maxzc='{{$vo['flyzc']}}'
					value='{{$vo['uflyzc']}}' />(0% 至 {{$vo['flyzc']}}%)
			</td>
		</tr>
        @endforeach
	</tbody>
</table>
@endif
<div class="data_footer control"><input type="button" value="确定" class="button edit" /> <input type="button" value="取消"
		class="close button"></div>
