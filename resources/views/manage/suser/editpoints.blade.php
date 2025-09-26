<div class="top_info">
    <span class="title">{{$layername}} <span>{{$username}}（{{$name}}）</span> -&gt; 退水</span>
    <span class="right"><a class="back close" types="{{$ifagent==1 ? 'ag' : 'us'}}">返回</a></span>
</div>
<div class="warning_panel" style="display: none;">
    快开彩在【{{$editstart}}--{{$editend}}】修改以下参数才能生效，低频彩开盘期间修改以下参数不会生效！ 当天未投注用户修改参数可以立即生效！
</div>
<ul class="tab">
    <li class="tab_title02">
        <a href="javascript:void(0);" class="infoset">基本资料</a>
        <a href="javascript:void(0);" class="selected">退水设定</a>
    </li>
</ul>
<table class="data_table info_table user_panel pointstb">
    <thead style="display: none;"><th colspan="2" uid='{{$uid}}' fid='{{$fid}}' class="uid">【<label>{{$username}}</label>】退水设定</th></thead>
    <tbody style='display:none;'>
    <td colspan="2">
        统一设置赚取退水:
        <select name="liushui" id="liushui">
          @foreach($liushui as $vo)
          <option value="{{$vo}}">{{$vo}}</option>
         @endforeach
          <option value="all">全部</option>
        </select>%&nbsp;&nbsp;
    <input type="button" class="btn1 btnf setpointssend" value="提交修改" />
     <input type="button" class="btn1 btnf close" value="关闭窗口" /></td>
   </tr>
   <TR >
    <Td colspan="2" style="text-align:left;padding-left:10px;font-size:13px;color:#0063e3">注意事项:<BR />一、如果修改代理级的退水，<Br />
      1、改动后的退水大于改动前退水，该用户所有下线的退水维持不变。<BR />
      2、改动后的退水[P]小于改动前的退水，所有下线的退水和[P]作比较，大于[P]，下线的退水为[P]，小于[P]，下线退水不变<BR />
      二、如果修改占成，该用户的所有下级占成将归0。<BR />
      三、如果修改代理级的单注最大限额，<Br />
      1、改动后的值大于改动前值，该用户所有下线的（单注最大限额）维持不变。<BR />
      2、改动后的值[M]小于改动前的值，所有下线的（单注最大限额）和[M]作比较，大于[M]，下线的(单注最大限额)为[M]，小于[M]，下线(单注最大限额)不变<br />
      四、如果修改用户的（单注最低限额），该用户的所有下线的（单注最低限额）和该用户相同。 </Td>
   </TR>
   </tbody>
  </table>
<div class="game_tab_class">
@if($config['fasttype']==1)
<a id="tab_0" href="javascript:;" class="selected on">快开彩</a>
<div id="cmcontrol" style="margin-right:20px;">赚取退水：<input> <input class="fastbtn" type="button" value="确定"></div>
@endif
@if($config['slowtype']==1)
<a id="tab_0" href="javascript:;" class="selected on">低频彩</a>
<div id="cmcontrol">赚取退水：<input> <input type="button" class="slowbtn" value="确定"></div>
@endif
</div>
   <div class="contents param_panel input_panel tab_panel data_panel">

<table class="data_table quick" @if($config['fasttype']==0)style='display:none;' @endif>
<thead><tr>
<th>快开彩快速设置</th>
    @foreach($span as $vo)
    <th>{{$vo}}盘%</th>
    @endforeach
<th>注单限额</th>
<th>单期限额</th>
<th>操作</th></tr></thead>
<tbody>
<tr class="t_BALL"><th class="color">号码类（球号、车号、正码等）</th>
    @foreach($span as $vo)
    <td><input name="{{$vo}}" class="commission"></td>
    @endforeach
	<td><input class="amount"></td>
	<td><input class="amount"></td>
	<td><input type="button" value="修改"></td>
</tr>
<tr class="t_LM"><th class="color">两面类（大小、单双、龙虎、三军等）</th>
    @foreach($span as $vo)
    <td><input name="{{$vo}}" class="commission"></td>
    @endforeach
	<td><input class="amount"></td>
	<td><input class="amount"></td>
	<td><input type="button" value="修改"></td>
</tr>
<tr class="t_ITEM"><th class="color">多项类（方位、中发白、总和过关等）</th>
    @foreach($span as $vo)
    <td><input name="{{$vo}}" class="commission"></td>
    @endforeach
	<td><input class="amount"></td>
	<td><input class="amount"></td>


	<td><input type="button" value="修改"></td>
</tr>
<tr class="t_MP"><th class="color">连码类（任选二、任选三、前二组选等）</th>
    @foreach($span as $vo)
    <td><input name="{{$vo}}" class="commission"></td>
    @endforeach
	<td><input class="amount"></td>
	<td><input class="amount"></td>
	<td><input type="button" value="修改"></td>
</tr>
<tr class="t_"><th class="color">其它（冠亚和、前中后三等）</th>
    @foreach($span as $vo)
    <td><input name="{{$vo}}" class="commission"></td>
    @endforeach
	<td><input class="amount"></td>
	<td><input class="amount"></td>
	<td><input type="button" value="修改"></td>
</tr>
<tr class="tf_"  style="display: none;"><th class="color">番摊</th>
    @foreach($span as $vo)
    <td><input name="{{$vo}}" class="commission"></td>
    @endforeach
  <td><input class="amount"></td>
  <td><input class="amount"></td>
  <td><input type="button" value="修改"></td>
</tr>
</tbody>
</table>
</div>
 <div class="data_footer control">快开彩在【{{$editstart}}--{{$editend}}】修改以下参数才能生效！ 当天未投注用户修改参数可以立即生效！<input type="button" value="保存" class="button setpointssend" /> <input type="button" value="取消"  class="close button"></div>
<style type="text/css">
.param_panel .data_table td {
	text-align:center;
}
.param_panel .data_table input {
	text-align:center;
}
.param_panel .layout th.color{height:45px;}
</style>
