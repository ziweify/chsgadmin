<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/red/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/sweetalert.min.js"></script>
    <link href="/default/css/agent/system.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/default/js/agentFollowPlanSetting.js?v9"></script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">{{$layername}} {{$username}} -&gt; @if($action=='add')新增@else修改@endif</span>
        <span class="right"><a class="back" href="query">返回</a></span>
    </div>
    <div class="contents"> <!-- Main contents-->
        <input id="username" type="hidden" value="{{$username}}"/>
        <input type="hidden" class="input" id="planId" name="planId" value="{{$planId}}"/>
        <input type="hidden" class="input" id="sourceLv" name="sourceLv" value="{{$action=='edit' ? 0 : ''}}"/>
        <input type="hidden" class="input" id="sourceLvs" name="sourceLvs" value='{{$action=='edit' ? $plan['layers'] : ''}}'/>
        <table class="data_table" id="agentFollowPlan">
            <thead>
            <tr>
                <th colspan="2">跟投对象设置</th>
            </tr>
            </thead>
            <tbody>
            <input type="hidden" class="input" id="sourceList" name="sourceList" value="{{$action=='edit' ? $plan['source'] : ''}}"/>
            <input id="lotteryList" type="hidden" value="{{$action=='edit' ? $plan['lotterystr'] : ''}}"/>
            <tr class="shead">
                <th>组名</th>
                <td><input type="text" id="planName" name="planName" value="{{$action=='edit' ? $plan['planName'] : ''}}" size="16" maxlength="16"/></td>
            </tr>
            <tr class="shead">
                <th>选择账号</th>
                <td><input type="button" class="s0" value="账号列表" id="chooseSource"/>
                    <label id="sourceListStr">{{$action=='edit' ? $plan['source'] : ''}}</label></td>
            </tr>
            <tr class="shead">
                <th>跟投比例</th>
                <td><input type="text" id="percentage" size="3" name="percentage" value="{{$action=='edit' ? $plan['percentage'] : ''}}"/>%</td>
            </tr>
            <tr class="shead">
                <th>游戏选择</th>
                <td>
                    <ul class="table_box table_box_lotterys">
                        <li class="table_box_title"><span>快开彩彩种</span><a
                                onclick="selectAll(true,this)" class="ico_tick2">全选</a>&nbsp;&nbsp;&nbsp;<a
                                onclick="selectAll(false,this)">全不选</a></li>
                        <li class="table_box_info">
                            @foreach($lotterys as $lottery)
                                <label><input @if($action=='edit')@checked(in_array($lottery['lottery'],$plan['lotteryList']))@else checked="checked" @endif type="checkbox" name="lottery" value="{{$lottery['lottery']}}" />{{$lottery['gname']}}</label>
                            @endforeach
                        </li>
                    </ul>
                </td>
            </tr>
            <tr class="shead">
                <th>正跟反跟</th>
                <td>
                    <label><input @if($action=='edit')@checked($plan['indicator']==1)@else checked @endif type="radio" name="indicator" value="1"/>正跟(全部)</label>
                    <label><input @if($action=='edit')@checked($plan['indicator']==0)@endif type="radio" name="indicator" value="0"/>反跟(两面)</label>
                </td>
            </tr>
            @if($open_follow_outbet == 1)
            <tr class="shead">
                <th>导航</th>
                <td><input type="text" id="dh_138_url" name="dh_138_url" value="{{$action=='edit' ? $plan['dh_138_url'] : $dh_138_url}}"/>例如：https://013806.app</td>
            </tr>
            @endif
            </tbody>
        </table>
        <br>
        <div style="color:red;text-align: left;">
            设置投注会员请注意会员的单注，如拆单超过100笔，系统将会判断异常，停止这个投注会员的跟投功能。
        </div>
        <div style="color:red;text-align: left;">
            （例如：投注会员两面单注2，跟投对象下两面大500，要拆成250笔，系统会判断异常，将停止该会员跟投）
        </div>
        <br>
        <div style="text-align: left;">投注会员</div>
        <table class="data_table" id="planDetails" style="text-align: center">
            <thead>
            <tr>
                <th colspan="6">投注会员设置</th>
            </tr>
            </thead>
            <tbody>
            <tr class="shead">
                <th>序号</th>
                <th>网名</th>
                <th>安全码</th>
                <th>账号</th>
                <th>密码</th>
                <th>分配比例(%)</th>
            </tr>
            <tr class="detail">
                <td><input id="sequence" type="hidden" value="1"/>1</td>
                <td><input style="width: 200px" type="text" name="webName" disabled value="{{isset($plan['target'][0]) ? $plan['target'][0]['name'] : ''}}" placeholder="保存验证成功后，自动取得网名"/></td>
                <td><input type="text" name="safeCode" value="{{isset($plan['target'][0]) ? $plan['target'][0]['safeCode'] : ''}}" size="30" maxlength="100"/></td>
                <td><input type="text" name="username" value="{{isset($plan['target'][0]) ? $plan['target'][0]['username'] : ''}}" placeholder="请输入原账号" size="30" maxlength="30"/></td>
                <td><input type="password" name="password" size="30" maxlength="50" placeholder="{{isset($plan['target'][0]) ? '不修改请留空' : '请输入密码'}}" value="{{isset($plan['target'][0]) ? $plan['target'][0]['password'] : ''}}"></td>
                <td><input type="text" name="ratio" size="3" value="{{isset($plan['target'][0]) ? $plan['target'][0]['ratio'] : ''}}"/></td>
            </tr>
            <tr class="detail">
                <td><input id="sequence" type="hidden" value="2"/>2</td>
                <td><input style="width: 200px" type="text" name="webName" disabled value="{{isset($plan['target'][1]) ? $plan['target'][1]['name'] : ''}}" placeholder="保存验证成功后，自动取得网名"/></td>
                <td><input type="text" name="safeCode" value="{{isset($plan['target'][1]) ? $plan['target'][1]['safeCode'] : ''}}" size="30" maxlength="100"/></td>
                <td><input type="text" name="username" value="{{isset($plan['target'][1]) ? $plan['target'][1]['username'] : ''}}" placeholder="请输入原账号" size="30" maxlength="30"/></td>
                <td><input type="password" name="password" size="30" maxlength="50" placeholder="{{isset($plan['target'][1]) ? '不修改请留空' : '请输入密码'}}" value="{{isset($plan['target'][1]) ? $plan['target'][1]['password'] : ''}}"></td>
                <td><input type="text" name="ratio" size="3" value="{{isset($plan['target'][1]) ? $plan['target'][1]['ratio'] : ''}}"/></td>
            </tr>
            <tr class="detail">
                <td><input id="sequence" type="hidden" value="3"/>3</td>
                <td><input style="width: 200px" type="text" name="webName" disabled value="{{isset($plan['target'][2]) ? $plan['target'][2]['name'] : ''}}" placeholder="保存验证成功后，自动取得网名"/></td>
                <td><input type="text" name="safeCode" value="{{isset($plan['target'][2]) ? $plan['target'][2]['safeCode'] : ''}}" size="30" maxlength="100"/></td>
                <td><input type="text" name="username" value="{{isset($plan['target'][2]) ? $plan['target'][2]['username'] : ''}}" placeholder="请输入原账号" size="30" maxlength="30"/></td>
                <td><input type="password" name="password" size="30" maxlength="50" placeholder="{{isset($plan['target'][2]) ? '不修改请留空' : '请输入密码'}}" value="{{isset($plan['target'][2]) ? $plan['target'][2]['password'] : ''}}"></td>
                <td><input type="text" name="ratio" size="3" value="{{isset($plan['target'][2]) ? $plan['target'][2]['ratio'] : ''}}"/></td>
            </tr>
            <tr class="detail">
                <td><input id="sequence" type="hidden" value="4"/>4</td>
                <td><input style="width: 200px" type="text" name="webName" disabled value="{{isset($plan['target'][3]) ? $plan['target'][3]['name'] : ''}}" placeholder="保存验证成功后，自动取得网名"/></td>
                <td><input type="text" name="safeCode" value="{{isset($plan['target'][3]) ? $plan['target'][3]['safeCode'] : ''}}" size="30" maxlength="100"/></td>
                <td><input type="text" name="username" value="{{isset($plan['target'][3]) ? $plan['target'][3]['username'] : ''}}" placeholder="请输入原账号" size="30" maxlength="30"/></td>
                <td><input type="password" name="password" size="30" maxlength="50" placeholder="{{isset($plan['target'][3]) ? '不修改请留空' : '请输入密码'}}" value="{{isset($plan['target'][3]) ? $plan['target'][3]['password'] : ''}}"></td>
                <td><input type="text" name="ratio" size="3" value="{{isset($plan['target'][3]) ? $plan['target'][3]['ratio'] : ''}}"/></td>
            </tr>
            <tr class="detail">
                <td><input id="sequence" type="hidden" value="5"/>5</td>
                <td><input style="width: 200px" type="text" name="webName" disabled value="{{isset($plan['target'][4]) ? $plan['target'][4]['name'] : ''}}" placeholder="保存验证成功后，自动取得网名"/></td>
                <td><input type="text" name="safeCode" value="{{isset($plan['target'][4]) ? $plan['target'][4]['safeCode'] : ''}}" size="30" maxlength="100"/></td>
                <td><input type="text" name="username" value="{{isset($plan['target'][4]) ? $plan['target'][4]['username'] : ''}}" placeholder="请输入原账号" size="30" maxlength="30"/></td>
                <td><input type="password" name="password" size="30" maxlength="50" placeholder="{{isset($plan['target'][4]) ? '不修改请留空' : '请输入密码'}}" value="{{isset($plan['target'][4]) ? $plan['target'][4]['password'] : ''}}"></td>
                <td><input type="text" name="ratio" size="3" value="{{isset($plan['target'][4]) ? $plan['target'][4]['ratio'] : ''}}"/></td>
            </tr>
            <tr class="detail">
                <td><input id="sequence" type="hidden" value="6"/>6</td>
                <td><input style="width: 200px" type="text" name="webName" disabled value="{{isset($plan['target'][5]) ? $plan['target'][5]['name'] : ''}}" placeholder="保存验证成功后，自动取得网名"/></td>
                <td><input type="text" name="safeCode" value="{{isset($plan['target'][5]) ? $plan['target'][5]['safeCode'] : ''}}" size="30" maxlength="100"/></td>
                <td><input type="text" name="username" value="{{isset($plan['target'][5]) ? $plan['target'][5]['username'] : ''}}" placeholder="请输入原账号" size="30" maxlength="30"/></td>
                <td><input type="password" name="password" size="30" maxlength="50" placeholder="{{isset($plan['target'][5]) ? '不修改请留空' : '请输入密码'}}" value="{{isset($plan['target'][5]) ? $plan['target'][5]['password'] : ''}}"></td>
                <td><input type="text" name="ratio" size="3" value="{{isset($plan['target'][5]) ? $plan['target'][5]['ratio'] : ''}}"/></td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div style="color:red;text-align: center;">
        按下修改时会确认账号密码是否正确，如不正确会提示错误的会员资讯，并且无法存入
    </div>
    <div style="color:red;text-align: center;">输入错误10次，跟投功能禁用一天，隔日自动解除。</div>
    <br>
    <div class="data_footer control">
        <input id="btnSave" type="button" value="确定" class="button"/>
    </div>

</div> <!-- Main-->
<div id="dialog_sourcelist" style="display: none">
    <table class="data_table">
        <thead>
        <tr>
            <th colspan="5"></th>
        </tr>
        </thead>
        <tbody>
        <tr class="shead">
            <input id="searchLvl" type="hidden" value=""/>
            <th>层级</th>
            <td>
                <select id="sourceLvl" name="sourceLvl">
                    <option value="0" selected="selected">会员</option>
                    @foreach($layerlist as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
            </td>
            <th>账号</th>
            <td><input type="text" name="sourceUsername" id="sourceUsername"/></td>
            <td><input style="color: #eeeeee" id="btnSearch" type="button" value="查询" class="button"/></td>
        </tr>
        </tbody>
    </table>

    <table class="data_table">
        <ul class="table_box">
            <tr>
                <td>
                    <li class="table_box_info" id="sourceCheck" style="padding: 0;">
                    </li>
                </td>
            </tr>
        </ul>
    </table>

</div>
</body>
</html>
