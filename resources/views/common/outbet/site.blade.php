<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link href="/js/jquery/new/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/master.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/loading.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.datepicker-zh-CN.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/js/sweetalert.min.js"></script>
    <link href="/default/css/form_validate.css" rel="stylesheet" type="text/css"/>
    <link href="/default/css/agent/outbet.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/default/js/outbet.js?v=223"></script>
    <script>
        var lotterys = '{{$lotterysstr}}';
        var userid = '{{$userid}}';
    </script>
</head>
<body>
<div class="main">
    <div class="top_info">
        <span class="title">新增站点</span>
        <div class="right">
            <a class="back" onclick="history.back()">返回</a>
        </div>
    </div>
    <div class="contents">
        <input type="hidden" id="siteId" value="{{$id}}"/>
        <form id="formSite">
            <table class="data_table info_table user_panel">
                <thead>
                <tr>
                    <th colspan="2">站点配置</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($ht))
                <tr>
                    <th>所属代理</th>
                    <td><input name="userid" type="hidden" value="{{$userid}}"/><span>{{$layername}}({{$username}})</span></td>
                </tr>
                @endif
                <tr>
                    <th>名称</th>
                    <td><input name="name" type="text" value="{{$id ? $site['name'] : ''}}"/><span>用于区分不同的站点设置，可任意填写</span></td>
                </tr>
                <tr>
                    <th>类型</th>
                    <td>
                        @if($action=='add')
                        <label><input checked="checked"  type="radio" name="type" value="SGWIN" />SGWIN</label>
                            <label><input type="radio" name="type" value="SGWIN2" />SGWIN(现金盘)</label>
                        @else
                        <label><input @if($site['type']=='SGWIN')checked="checked" @endif type="radio" name="type" value="SGWIN" />SGWIN</label>
                            <label><input @if($site['type']=='SGWIN2')checked="checked" @endif type="radio" name="type" value="SGWIN2" />SGWIN(现金盘)</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{$outbet_name}}彩种</th>
                    <td id="lotterys">
                        <input name="lotterys" type="hidden" value="{{$lotterykeys}}">
                        <input type="button" value="设置"/> <span></span></td>
                </tr>
                <tr>
                    <th>{{$outbet_name}}模式</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="mode" value="2" checked="checked" />按金额飞</label>
                            <label><input type="radio" name="mode" value="1" />按占成飞</label>
                        @else
                            <label><input @if($site['mode']==2)checked="checked" @endif type="radio" name="mode" value="2" />按金额飞</label>
                            <label><input @if($site['mode']==1)checked="checked" @endif type="radio" name="mode" value="1" />按占城飞</label>
                        @endif
                    </td>
                </tr>
                @if($ifhide == 1)
                <tr>
                    <th>正反跟</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="indicator" value="1" checked="checked" />正跟</label>
                            <label><input type="radio" name="indicator" value="0" />反跟</label>
                        @else
                            <label><input @if($site['indicator']==1)checked="checked" @endif type="radio" name="indicator" value="1" />正跟</label>
                            <label><input @if($site['indicator']==0)checked="checked" @endif type="radio" name="indicator" value="0" />反跟</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>正反跟不符合是否过滤</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="indicator_hl" value="1" checked="checked" />是</label>
                            <label><input type="radio" name="indicator_hl" value="0" />否</label>
                        @else
                            <label><input @if($site['indicator_hl']==1)checked="checked" @endif type="radio" name="indicator_hl" value="1" />是</label>
                            <label><input @if($site['indicator_hl']==0)checked="checked" @endif type="radio" name="indicator_hl" value="0" />否</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>隐藏</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="ifhide" value="1" />是</label>
                            <label><input type="radio" name="ifhide" value="0" checked="checked" />否</label>
                        @else
                            <label><input @if($site['ifhide']==1)checked="checked" @endif type="radio" name="ifhide" value="1" />是</label>
                            <label><input @if($site['ifhide']==0)checked="checked" @endif type="radio" name="ifhide" value="0" />否</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>是否反跟最大的五码</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="ft_max_ma" value="1" />是</label>
                            <label><input type="radio" name="ft_max_ma" value="0" checked="checked" />否</label>
                        @else
                            <label><input @if($site['ft_max_ma']==1)checked="checked" @endif type="radio" name="ft_max_ma" value="1" />是</label>
                            <label><input @if($site['ft_max_ma']==0)checked="checked" @endif type="radio" name="ft_max_ma" value="0" />否</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>是否合并订单</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="is_hebing" value="1" />是</label>
                            <label><input type="radio" name="is_hebing" value="0" checked="checked" />否</label>
                        @else
                            <label><input @if($site['is_hebing']==1)checked="checked" @endif type="radio" name="is_hebing" value="1" />是</label>
                            <label><input @if($site['is_hebing']==0)checked="checked" @endif type="radio" name="is_hebing" value="0" />否</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>合并订单是否去重</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="is_quchong" value="1" />是</label>
                            <label><input type="radio" name="is_quchong" value="0" checked="checked" />否</label>
                        @else
                            <label><input @if($site['is_quchong']==1)checked="checked" @endif type="radio" name="is_quchong" value="1" />是</label>
                            <label><input @if($site['is_quchong']==0)checked="checked" @endif type="radio" name="is_quchong" value="0" />否</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>盈亏控制</th>
                    <td><input name="ykstr" value="{{$id ? $site['ykstr'] : ''}}"/>
                        <span>5000|1 表示盈利大于5000则停止，5000|2表示盈利低于5000停止，-5000|1表示亏损大于5000则停止</span>
                    </td>
                </tr>
                @if($adminid == 22222)
                <tr>
                    <th>正反跟是否自动切换</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="auto_qh_zfg" value="1"/>是</label>
                            <label><input type="radio" name="auto_qh_zfg" value="0" checked="checked" />否</label>
                        @else
                            <label><input @if($site['auto_qh_zfg']==1)checked="checked" @endif type="radio" name="auto_qh_zfg" value="1" />是</label>
                            <label><input @if($site['auto_qh_zfg']==0)checked="checked" @endif type="radio" name="auto_qh_zfg" value="0" />否</label>
                        @endif
                    </td>
                </tr>
                <tr style="color: #ff0812 !important;font-weight: bold;">
                    <th style="color: #ff0812 !important;font-weight: bold;">公式投信息</th>
                    <td style="color: #ff0812 !important;font-weight: bold;">
----------------------------------start----------------------------------
                    </td>
                </tr>
                <tr>
                    <th>模式</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="is_gentoumode" value="1" checked="checked"/>跟投模式</label>
                            <label><input type="radio" name="is_gentoumode" value="2" />公式投注</label>
                        @else
                            <label><input @if($site['is_gentoumode']==1)checked="checked" @endif type="radio" name="is_gentoumode" value="1" />跟投模式</label>
                            <label><input @if($site['is_gentoumode']==2)checked="checked" @endif type="radio" name="is_gentoumode" value="2" />公式投注</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>投注金额</th>
                    <td><input name="complex_money" value="{{$id ? $site['complex_money'] : ''}}"/>
                        <span></span>
                    </td>
                </tr>
                <tr>
                    <th>分界线期数</th>
                    <td><input name="fj_qishu" value="{{$id ? $site['fj_qishu'] : ''}}"/>
                        <span></span>
                    </td>
                </tr>
                <tr>
                    <th>其他配置</th>
                    <td><input name="other_pz" value="{{$id ? $site['other_pz'] : '1|0'}}"/>
                        <span></span>
                    </td>
                </tr>
                <tr style="color: #ff0812 !important;font-weight: bold;">
                    <th style="color: #ff0812 !important;font-weight: bold;">公式投信息</th>
                    <td style="color: #ff0812 !important;font-weight: bold;">
                        ----------------------------------end----------------------------------
                    </td>
                </tr>
                @endif
                @endif
                <tr>
                    <th>{{$outbet_name}}倍数</th>
                    <td><input name="flyjiabei" value="{{$id ? $site['flyjiabei'] : 100}}"/>
                        <span>100%不加倍,50%飞一半,200%,加一倍</span>
                    </td>
                </tr>
                <tr>
                    <th>大额分投</th>
                    <td><input name="chai_money" value="{{$id ? $site['chai_money'] : 0}}"/>
                        <span>填写大于0的金额将进拆分，例如填写5000，则会员下注两面大6000，将拆分成5000和1000下注。</span>
                    </td>
                </tr>
                <tr>
                    <th>起飞金额</th>
                    <td><input name="start_money" value="{{$id ? $site['start_money'] : 0}}"/>
                        <span>填0则不限制，例如：填5000，则4999不飞，5000、6000则飞</span>
                    </td>
                </tr>
                <tr>
                    <th>指定代理</th>
                    <td><input type="button" ifagent="1" class="s0 chooseSource" value="账号列表"/>
                        <label id="sourceListStr1">{{$action=='edit' ? $site['zhidingagent'] : ''}}</label><span style="color: red;margin-left: 5px">指定代理或指定会员为空则下线会员全部飞</span></td>
                </tr>
                <tr>
                    <th>指定会员</th>
                    <td><input type="button" ifagent="0" class="s0 chooseSource" value="账号列表"/>
                        <label id="sourceListStr0">{{$action=='edit' ? $site['zhidinguser'] : ''}}</label><span style="color: red;margin-left: 5px">指定代理或指定会员为空则下线会员全部飞</span></td>
                </tr>
                <tr>
                    <th>网址</th>
                    <td>
                        <textarea name="urls" rows="6" cols="60" style="resize: none">{{$id ? $site['urls'] : ''}}</textarea>
                        <div>*每行一个网址，需要包含http://或https://，例：</div>
                        <div>http://123567.xxx.com</div>
                        <div>https://584677.yyy.net</div>
                    </td>
                </tr>
                <tr>
                    <th>模式</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="bet_mode" value="1" checked="checked" />服务器投注</label>
                            <label><input type="radio" name="bet_mode" value="2" />API投注</label>
                        @else
                            <label><input @if($site['bet_mode']==1)checked="checked" @endif type="radio" name="bet_mode" value="1" />服务器投注</label>
                            <label><input @if($site['bet_mode']==2)checked="checked" @endif type="radio" name="bet_mode" value="2" />API投注</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>主副站类型</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="main_fu_type" value="1" checked="checked" />主站</label>
                            <label><input type="radio" name="main_fu_type" value="2" />副站</label>
                        @else
                            <label><input @if($site['main_fu_type']==1)checked="checked" @endif type="radio" name="main_fu_type" value="1" />主站</label>
                            <label><input @if($site['main_fu_type']==2)checked="checked" @endif type="radio" name="main_fu_type" value="2" />副站</label>
                        @endif
                        <span style="color: red;margin-left: 5px">主站：优先使用主站进行飞单。副站：如果选择副站，需要选择一个主站，当主站异常的时候会用副站进行飞单，主站正常的时候不会使用副站进行飞单</span>
                    </td>
                </tr>
                <tr style="@if($action=='add')display: none; @else {{$site['main_fu_type']==1 ? 'display: none;' : ''}} @endif" id="main_site_id">
                    <th>选择主站</th>
                    <td>
                        <select name="main_site_id">
                            <option value="0">请选择</option>
                            @foreach($main_site_list as $main_site)
                                @if($action=='add')
                                <option value="{{$main_site['id']}}">{{$main_site['name']}}</option>
                                @else
                                <option @if($site['main_site_id']==$main_site['id'])selected="selected" @endif value="{{$main_site['id']}}">{{$main_site['name']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>开关</th>
                    <td>
                        @if($action=='add')
                            <label><input type="radio" name="enabled" value="1" checked="checked" />启用</label>
                            <label><input type="radio" name="enabled" value="0" />停用</label>
                        @else
                            <label><input @if($site['enabled']==1)checked="checked" @endif type="radio" name="enabled" value="1" />启用</label>
                            <label><input @if($site['enabled']==0)checked="checked" @endif type="radio" name="enabled" value="0" />停用</label>
                        @endif
                    </td>
                </tr>
                {{--<tr>
                    <th>优先级</th>
                    <td><input name="priority" value="{{$id ? $site['priority'] : 0}}"/>
                        <span>从小到大排列，当优先级高的站点全部账号正在投注或账号异常时，使用低优先级站点补货</span>
                    </td>
                </tr>--}}
                </tbody>
            </table>
        </form>
        <table class="data_table info_table input_panel site_table">
            <thead>
            <tr>
                <th colspan="10">账号设置</th>
            </tr>
            <tr>
                <td>登录账号</td>
                <td>账户余额</td>
                <td>盘口</td>
                <td>登录密码</td>
                <td>开关</td>
                <td>API_KID</td>
                <td>API_SCR</td>
                {{--<td>优先级</td>--}}
                <td>状态</td>
                <td>操作</td>
            </tr>
            </thead>
            <tbody id="formAccs">
            @if($action=='edit')
                @foreach($site['accs'] as $acc)
            <tr>
                <td><input type="hidden" name="id" value="{{$acc['id']}}"/><input name="username" value="{{$acc['username']}}"/></td>
                <td>{{$acc['balance']}}</td>
                <td>
                    <select name="abcd">
                        <option @selected($acc['abcd']=='A') value="A">A盘</option>
                        <option @selected($acc['abcd']=='B') value="B">B盘</option>
                        <option @selected($acc['abcd']=='C') value="C">C盘</option>
                        <option @selected($acc['abcd']=='D') value="D">D盘</option>
                    </select>
                </td>
                <td><input name="password" value="{{$acc['password']}}"/></td>
                <td>
                    <form>
                        <label><input @if($acc['enabled']==1)checked="checked" @endif type="radio" name="enabled" value="1" />启用</label>
                        <label><input @if($acc['enabled']==0)checked="checked" @endif type="radio" name="enabled" value="0" />停用</label>
                    </form>
                </td>
                <td><input style="width: 100%" name="sg_kid" value="{{$acc['sg_kid']}}"/></td>
                <td><input style="width: 100%" name="sg_secretkey" value="{{$acc['sg_secretkey']}}"/></td>
                {{--<td><input name="priority" value="{{$acc['priority']}}"/></td>--}}
                <td class="s-{{$acc['online']}}">@if($acc['online']==0)离线@elseif($acc['online']==2)错误@else在线@endif</td>
                <td><a onclick="delAcc(this)">删除</a></td>
            </tr>
                @endforeach
            @else
            <tr>
                <td><input type="hidden" name="id" value=""/><input name="username" value=""/></td>
                <td>0</td>
                <td>
                    <select name="abcd">
                        <option selected value="A">A盘</option>
                        <option value="B">B盘</option>
                        <option value="C">C盘</option>
                        <option value="D">D盘</option>
                    </select>
                </td>
                <td><input name="password" value=""/></td>
                <td>
                    <form>
                        <label><input type="radio" name="enabled" value="1" checked="checked" />启用</label>
                        <label><input type="radio" name="enabled" value="0" />停用</label>
                    </form>
                </td>
                <td><input style="width: 100%" name="sg_kid" value=""/></td>
                <td><input style="width: 100%" name="sg_secretkey" value=""/></td>
                <td><input name="priority" value="0"/></td>
                <td class="s-0"></td>
                <td><a onclick="delAcc(this)">删除</a></td>
            </tr>
            @endif
            </tbody>
            <tfoot>
            <tr>
                <th colspan="10"><input type="button" value="添加账号" onclick="addAcc()"/></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="data_footer control"><input type="button" value="确定" onclick="saveSite()" class="button"/> <input
        type="button" value="取消" onclick="location.href='config?userid={{$userid}}'" class="button"/></div>
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
                {{--<th>层级</th>
                <td>
                    <select id="sourceLvl" name="sourceLvl">
                        <option value="0" selected="selected">会员</option>
                    </select>
                </td>--}}
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
</div>
</body>
<script>
    //当选择主副站类型的时候，显示或隐藏选择主站的下拉框
    $("input[name='main_fu_type']").click(function(){
        var main_fu_type = $(this).val();
        if(main_fu_type==1){
            $("#main_site_id").hide();
        }else{
            $("#main_site_id").show();
        }
    });
</script>
</html>
