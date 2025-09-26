<head>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115" />
    <link rel="stylesheet" type="text/css" href="/static/default/css/fonts/font-awesome.css" />
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/dialog.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/rightpanel.js"></script>
    <script type="text/javascript" src="/static/default/js/complexBet.js"></script>
    <script type="text/javascript">var lotteryid='{{$lottery}}}'</script>
</head>
<head>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115" />
    <script type="text/javascript">var lotteryid='{{$lottery}}}'</script>
</head>
<body>
<div id="complex_bet">
    <div id="main">
        <div id="header">
            <div>
                <form id="saveForm">
                    <div>
                        <input type="button" class="" value="返回" onclick="history.back()" />
                    </div>
                    <select id="complexPlanSelection" class="complexPlanSelection">
                        <option onclick=""> -- 方式选择 --</option>
                        <option onclick="">指定位置投注</option>
                        <!--<option onclick="">跟上期两面</option>
                        <option onclick="">长龙投注</option>
                        <option onclick="">开某投某</option>
                        <option onclick="">追号</option>-->
                    </select>
                    <span id="plan1Description" class="plan1Description" onclick="parentPlan1Description()">设置说明</span>
                    @if($template == 'SSC')
                    <table id="complexForm" class="complexForm">
                        <thead>
                        <tr>
                            <th id="complex1HeaderGame" class="complex1HeaderGame">位置</th>
                            <th id="complex1HeaderContent" class="complex1HeaderContent" colspan="9" >玩法选择</th>
                        </tr>
                        </thead>
                        <tbody id="complex1TableData" class="complex1TableData complex1TableDataSSC">
                        <tr>
                            <td>快选</td>
                            <td>
                                <label><input type="radio" id="KX1_GDX_D" name="KX1" value="KX1_GDX_D" onchange="complexKX1(this.value, 6, 'ZDX')">大</label>
                                <label><input type="radio" id="KX1_GDX_X" name="KX1" value="KX1_GDX_X" onchange="complexKX1(this.value, 6, 'ZDX')">小</label>
                            </td>
                            <td>
                                <label><input type="radio" id="KX2_GDS_D" name="KX2" value="KX2_GDS_D" onchange="complexKX1(this.value, 6, 'ZDS')">单</label>
                                <label><input type="radio" id="KX2_GDS_S" name="KX2" value="KX2_GDS_S" onchange="complexKX1(this.value, 6, 'ZDS')">双</label>
                            </td>
                            <td>
                                <label><input type="radio" id="KX3_GLH_L" name="KX3" value="KX3_GLH_L" onchange="complexKX1(this.value, 6, '')">龙</label>
                                <label><input type="radio" id="KX3_GLH_H" name="KX3" value="KX3_GLH_H" onchange="complexKX1(this.value, 6, '')">虎</label>
                                <label><input type="radio" id="KX3_GLH_T" name="KX3" value="KX3_GLH_T" onchange="complexKX1(this.value, 6, '')">和</label>
                            </td>

                            <td>
                                <div class="betNumbers">
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_0"  id="KXB_GB_0" name=KXB_GB_0 onchange="complexKX2(this.value, 10)">
                                        <span>0</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_1"  id="KXB_GB_1" name=KXB_GB_1 onchange="complexKX2(this.value, 10)">
                                        <span>1</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_2"  id="KXB_GB_2" name=KXB_GB_2 onchange="complexKX2(this.value, 10)">
                                        <span>2</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_3"  id="KXB_GB_3" name=KXB_GB_3 onchange="complexKX2(this.value, 10)">
                                        <span>3</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_4"  id="KXB_GB_4" name=KXB_GB_4 onchange="complexKX2(this.value, 10)">
                                        <span>4</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_5"  id="KXB_GB_5" name=KXB_GB_5 onchange="complexKX2(this.value, 10)">
                                        <span>5</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_6"  id="KXB_GB_6" name=KXB_GB_6 onchange="complexKX2(this.value, 10)">
                                        <span>6</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_7"  id="KXB_GB_7" name=KXB_GB_7 onchange="complexKX2(this.value, 10)">
                                        <span>7</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_8"  id="KXB_GB_8" name=KXB_GB_8 onchange="complexKX2(this.value, 10)">
                                        <span>8</span>
                                        <input type="checkbox" class="complexCheck" value="KXB_GB_9"  id="KXB_GB_9" name=KXB_GB_9 onchange="complexKX2(this.value, 10)">
                                        <span>9</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第一球</td>
                            <td>
                                <label><input @checked(in_array('GDX1_D',$detail)) type="radio" id="GDX1_D" class="radioUnSel" name="GDX1" value="GDX1_D" >大</label>
                                <label><input @checked(in_array('GDX1_X',$detail)) type="radio" id="GDX1_X" class="radioUnSel" name="GDX1" value="GDX1_X" >小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS1_D',$detail)) type="radio" id="GDS1_D" class="radioUnSel" name="GDS1" value="GDS1_D" >单</label>
                                <label><input @checked(in_array('GDS1_S',$detail)) type="radio" id="GDS1_S" class="radioUnSel" name="GDS1" value="GDS1_S" >双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB1_0',$detail)) type="checkbox" class="complexCheck" value="GB1_0"  id="GB1_0" name=GB1_0>
                                    <span>0</span>
                                    <input @checked(in_array('GB1_1',$detail)) type="checkbox" class="complexCheck" value="GB1_1"  id="GB1_1" name=GB1_1>
                                    <span>1</span>
                                    <input @checked(in_array('GB1_2',$detail)) type="checkbox" class="complexCheck" value="GB1_2"  id="GB1_2" name=GB1_2>
                                    <span>2</span>
                                    <input @checked(in_array('GB1_3',$detail)) type="checkbox" class="complexCheck" value="GB1_3"  id="GB1_3" name=GB1_3>
                                    <span>3</span>
                                    <input @checked(in_array('GB1_4',$detail)) type="checkbox" class="complexCheck" value="GB1_4"  id="GB1_4" name=GB1_4>
                                    <span>4</span>
                                    <input @checked(in_array('GB1_5',$detail)) type="checkbox" class="complexCheck" value="GB1_5"  id="GB1_5" name=GB1_5>
                                    <span>5</span>
                                    <input @checked(in_array('GB1_6',$detail)) type="checkbox" class="complexCheck" value="GB1_6"  id="GB1_6" name=GB1_6>
                                    <span>6</span>
                                    <input @checked(in_array('GB1_7',$detail)) type="checkbox" class="complexCheck" value="GB1_7"  id="GB1_7" name=GB1_7>
                                    <span>7</span>
                                    <input @checked(in_array('GB1_8',$detail)) type="checkbox" class="complexCheck" value="GB1_8"  id="GB1_8" name=GB1_8>
                                    <span>8</span>
                                    <input @checked(in_array('GB1_9',$detail)) type="checkbox" class="complexCheck" value="GB1_9"  id="GB1_9" name=GB1_9>
                                    <span>9</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第二球</td>
                            <td>
                                <label><input @checked(in_array('GDX2_D',$detail)) type="radio" id="GDX2_D" class="radioUnSel" name="GDX2" value="GDX2_D">大</label>
                                <label><input @checked(in_array('GDX2_X',$detail)) type="radio" id="GDX2_X" class="radioUnSel" name="GDX2" value="GDX2_X" >小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS2_D',$detail)) type="radio" id="GDS2_D" class="radioUnSel" name="GDS2" value="GDS2_D" >单</label>
                                <label><input @checked(in_array('GDS2_S',$detail)) type="radio" id="GDS2_S" class="radioUnSel" name="GDS2" value="GDS2_S" >双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB2_0',$detail)) type="checkbox" class="complexCheck" value="GB2_0"  id="GB2_0" name=GB2_0>
                                    <span>0</span>
                                    <input @checked(in_array('GB2_1',$detail)) type="checkbox" class="complexCheck" value="GB2_1"  id="GB2_1" name=GB2_1>
                                    <span>1</span>
                                    <input @checked(in_array('GB2_2',$detail)) type="checkbox" class="complexCheck" value="GB2_2"  id="GB2_2" name=GB2_2>
                                    <span>2</span>
                                    <input @checked(in_array('GB2_3',$detail)) type="checkbox" class="complexCheck" value="GB2_3"  id="GB2_3" name=GB2_3>
                                    <span>3</span>
                                    <input @checked(in_array('GB2_4',$detail)) type="checkbox" class="complexCheck" value="GB2_4"  id="GB2_4" name=GB2_4>
                                    <span>4</span>
                                    <input @checked(in_array('GB2_5',$detail)) type="checkbox" class="complexCheck" value="GB2_5"  id="GB2_5" name=GB2_5>
                                    <span>5</span>
                                    <input @checked(in_array('GB2_6',$detail)) type="checkbox" class="complexCheck" value="GB2_6"  id="GB2_6" name=GB2_6>
                                    <span>6</span>
                                    <input @checked(in_array('GB2_7',$detail)) type="checkbox" class="complexCheck" value="GB2_7"  id="GB2_7" name=GB2_7>
                                    <span>7</span>
                                    <input @checked(in_array('GB2_8',$detail)) type="checkbox" class="complexCheck" value="GB2_8"  id="GB2_8" name=GB2_8>
                                    <span>8</span>
                                    <input @checked(in_array('GB2_9',$detail)) type="checkbox" class="complexCheck" value="GB2_9"  id="GB2_9" name=GB2_9>
                                    <span>9</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第三球</td>
                            <td>
                                <label><input @checked(in_array('GDX3_D',$detail)) type="radio" id="GDX3_D" class="radioUnSel" name="GDX3" value="GDX3_D">大</label>
                                <label><input @checked(in_array('GDX3_X',$detail)) type="radio" id="GDX3_X" class="radioUnSel" name="GDX3" value="GDX3_X" >小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS3_D',$detail)) type="radio" id="GDS3_D" class="radioUnSel" name="GDS3" value="GDS3_D" >单</label>
                                <label><input @checked(in_array('GDS3_S',$detail)) type="radio" id="GDS3_S" class="radioUnSel" name="GDS3" value="GDS3_S" >双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB3_0',$detail)) type="checkbox" class="complexCheck" value="GB3_0"  id="GB3_0" name=GB3_0>
                                    <span>0</span>
                                    <input @checked(in_array('GB3_1',$detail)) type="checkbox" class="complexCheck" value="GB3_1"  id="GB3_1" name=GB3_1>
                                    <span>1</span>
                                    <input @checked(in_array('GB3_2',$detail)) type="checkbox" class="complexCheck" value="GB3_2"  id="GB3_2" name=GB3_2>
                                    <span>2</span>
                                    <input @checked(in_array('GB3_3',$detail)) type="checkbox" class="complexCheck" value="GB3_3"  id="GB3_3" name=GB3_3>
                                    <span>3</span>
                                    <input @checked(in_array('GB3_4',$detail)) type="checkbox" class="complexCheck" value="GB3_4"  id="GB3_4" name=GB3_4>
                                    <span>4</span>
                                    <input @checked(in_array('GB3_5',$detail)) type="checkbox" class="complexCheck" value="GB3_5"  id="GB3_5" name=GB3_5>
                                    <span>5</span>
                                    <input @checked(in_array('GB3_6',$detail)) type="checkbox" class="complexCheck" value="GB3_6"  id="GB3_6" name=GB3_6>
                                    <span>6</span>
                                    <input @checked(in_array('GB3_7',$detail)) type="checkbox" class="complexCheck" value="GB3_7"  id="GB3_7" name=GB3_7>
                                    <span>7</span>
                                    <input @checked(in_array('GB3_8',$detail)) type="checkbox" class="complexCheck" value="GB3_8"  id="GB3_8" name=GB3_8>
                                    <span>8</span>
                                    <input @checked(in_array('GB3_9',$detail)) type="checkbox" class="complexCheck" value="GB3_9"  id="GB3_9" name=GB3_9>
                                    <span>9</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第四球</td>
                            <td>
                                <label><input @checked(in_array('GDX4_D',$detail)) type="radio" id="GDX4_D" class="radioUnSel" name="GDX4" value="GDX4_D">大</label>
                                <label><input @checked(in_array('GDX4_X',$detail)) type="radio" id="GDX4_X" class="radioUnSel" name="GDX4" value="GDX4_X" >小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS4_D',$detail)) type="radio" id="GDS4_D" class="radioUnSel" name="GDS4" value="GDS4_D" >单</label>
                                <label><input @checked(in_array('GDS4_S',$detail)) type="radio" id="GDS4_S" class="radioUnSel" name="GDS4" value="GDS4_S" >双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB4_0',$detail)) type="checkbox" class="complexCheck" value="GB4_0"  id="GB4_0" name=GB4_0>
                                    <span>0</span>
                                    <input @checked(in_array('GB4_1',$detail)) type="checkbox" class="complexCheck" value="GB4_1"  id="GB4_1" name=GB4_1>
                                    <span>1</span>
                                    <input @checked(in_array('GB4_2',$detail)) type="checkbox" class="complexCheck" value="GB4_2"  id="GB4_2" name=GB4_2>
                                    <span>2</span>
                                    <input @checked(in_array('GB4_3',$detail)) type="checkbox" class="complexCheck" value="GB4_3"  id="GB4_3" name=GB4_3>
                                    <span>3</span>
                                    <input @checked(in_array('GB4_4',$detail)) type="checkbox" class="complexCheck" value="GB4_4"  id="GB4_4" name=GB4_4>
                                    <span>4</span>
                                    <input @checked(in_array('GB4_5',$detail)) type="checkbox" class="complexCheck" value="GB4_5"  id="GB4_5" name=GB4_5>
                                    <span>5</span>
                                    <input @checked(in_array('GB4_6',$detail)) type="checkbox" class="complexCheck" value="GB4_6"  id="GB4_6" name=GB4_6>
                                    <span>6</span>
                                    <input @checked(in_array('GB4_7',$detail)) type="checkbox" class="complexCheck" value="GB4_7"  id="GB4_7" name=GB4_7>
                                    <span>7</span>
                                    <input @checked(in_array('GB4_8',$detail)) type="checkbox" class="complexCheck" value="GB4_8"  id="GB4_8" name=GB4_8>
                                    <span>8</span>
                                    <input @checked(in_array('GB4_9',$detail)) type="checkbox" class="complexCheck" value="GB4_9"  id="GB4_9" name=GB4_9>
                                    <span>9</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第五球</td>
                            <td>
                                <label><input @checked(in_array('GDX5_D',$detail)) type="radio" id="GDX5_D" class="radioUnSel" name="GDX5" value="GDX5_D" >大</label>
                                <label><input @checked(in_array('GDX5_X',$detail)) type="radio" id="GDX5_X" class="radioUnSel" name="GDX5" value="GDX5_X" >小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS5_D',$detail)) type="radio" id="GDS5_D" class="radioUnSel" name="GDS5" value="GDS5_D" >单</label>
                                <label><input @checked(in_array('GDS5_S',$detail)) type="radio" id="GDS5_S" class="radioUnSel" name="GDS5" value="GDS5_S" >双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB5_0',$detail)) type="checkbox" class="complexCheck" value="GB5_0"  id="GB5_0" name=GB5_0>
                                    <span>0</span>
                                    <input @checked(in_array('GB5_1',$detail)) type="checkbox" class="complexCheck" value="GB5_1"  id="GB5_1" name=GB5_1>
                                    <span>1</span>
                                    <input @checked(in_array('GB5_2',$detail)) type="checkbox" class="complexCheck" value="GB5_2"  id="GB5_2" name=GB5_2>
                                    <span>2</span>
                                    <input @checked(in_array('GB5_3',$detail)) type="checkbox" class="complexCheck" value="GB5_3"  id="GB5_3" name=GB5_3>
                                    <span>3</span>
                                    <input @checked(in_array('GB5_4',$detail)) type="checkbox" class="complexCheck" value="GB5_4"  id="GB5_4" name=GB5_4>
                                    <span>4</span>
                                    <input @checked(in_array('GB5_5',$detail)) type="checkbox" class="complexCheck" value="GB5_5"  id="GB5_5" name=GB5_5>
                                    <span>5</span>
                                    <input @checked(in_array('GB5_6',$detail)) type="checkbox" class="complexCheck" value="GB5_6"  id="GB5_6" name=GB5_6>
                                    <span>6</span>
                                    <input @checked(in_array('GB5_7',$detail)) type="checkbox" class="complexCheck" value="GB5_7"  id="GB5_7" name=GB5_7>
                                    <span>7</span>
                                    <input @checked(in_array('GB5_8',$detail)) type="checkbox" class="complexCheck" value="GB5_8"  id="GB5_8" name=GB5_8>
                                    <span>8</span>
                                    <input @checked(in_array('GB5_9',$detail)) type="checkbox" class="complexCheck" value="GB5_9"  id="GB5_9" name=GB5_9>
                                    <span>9</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>总和</td>
                            <td>
                                <div class="betRadio">
                                    <label><input @checked(in_array('GZDX_D',$detail)) type="radio" id="GZDX_D" class="radioUnSel" name="ZDX" value="GZDX_D">大</label>
                                    <label><input @checked(in_array('GZDX_X',$detail)) type="radio" id="GZDX_X" class="radioUnSel" name="ZDX" value="GZDX_X" >小</label>
                                </div>
                            </td>
                            <td>
                                <label><input @checked(in_array('GZDS_D',$detail)) type="radio" id="GZDS_D" class="radioUnSel" name="ZDS" value="GZDS_D" >单</label>
                                <label><input @checked(in_array('GZDS_S',$detail)) type="radio" id="GZDS_S" class="radioUnSel" name="ZDS" value="GZDS_S" >双</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GLH_L',$detail)) type="radio" id="GLH1_L" class="radioUnSel" name="GLH" value="GLH_L" >龙</label>
                                <label><input @checked(in_array('GLH_H',$detail)) type="radio" id="GLH1_H" class="radioUnSel" name="GLH" value="GLH_H" >虎</label>
                                <label><input @checked(in_array('GLH_T',$detail)) type="radio" id="GLH1_T" class="radioUnSel" name="GLH" value="GLH_T" >和</label>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    @else
                    <table id="complexForm" class="complexForm">
                        <thead>
                        <tr>
                            <th id="complex1HeaderGame" class="complex1HeaderGame">位置<!--</th--></th>
                            <th id="complex1HeaderContent" class="complex1HeaderContent" colspan="9">玩法选择</th>
                        </tr>
                        </thead>
                        <tbody id="complex1TableData" class="complex1TableData">
                        <tr>
                            <td>快选</td>
                            <td>
                                <label><input type="radio" id="KX1_GDX_D" name="KX1" value="KX1_GDX_D" onchange="complexKX1(this.value, 11, 'GDX')">大</label>
                                <label><input type="radio" id="KX1_GDX_X" name="KX1" value="KX1_GDX_X" onchange="complexKX1(this.value, 11, 'GDX')">小</label>
                            </td>
                            <td>
                                <label><input type="radio" id="KX2_GDS_D" name="KX2" value="KX2_GDS_D" onchange="complexKX1(this.value, 11, 'GDS')">单</label>
                                <label><input type="radio" id="KX2_GDS_S" name="KX2" value="KX2_GDS_S" onchange="complexKX1(this.value, 11, 'GDS')">双</label>
                            </td>
                            <td>
                                <label><input type="radio" id="KX3_GLH_L" name="KX3" value="KX3_GLH_L" onchange="complexKX1(this.value, 11, 'GLH')">龙</label>
                                <label><input type="radio" id="KX3_GLH_H" name="KX3" value="KX3_GLH_H" onchange="complexKX1(this.value, 11, 'GLH')">虎</label>
                            </td>

                            <td>
                                <div class="betNumbers">
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_1" id="KXB_GB_1" name="KXB_GB_1" onchange="complexKX2(this.value, 11)">
                                    <span>1</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_2" id="KXB_GB_2" name="KXB_GB_2" onchange="complexKX2(this.value, 11)">
                                    <span>2</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_3" id="KXB_GB_3" name="KXB_GB_3" onchange="complexKX2(this.value, 11)">
                                    <span>3</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_4" id="KXB_GB_4" name="KXB_GB_4" onchange="complexKX2(this.value, 11)">
                                    <span>4</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_5" id="KXB_GB_5" name="KXB_GB_5" onchange="complexKX2(this.value, 11)">
                                    <span>5</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_6" id="KXB_GB_6" name="KXB_GB_6" onchange="complexKX2(this.value, 11)">
                                    <span>6</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_7" id="KXB_GB_7" name="KXB_GB_7" onchange="complexKX2(this.value, 11)">
                                    <span>7</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_8" id="KXB_GB_8" name="KXB_GB_8" onchange="complexKX2(this.value, 11)">
                                    <span>8</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_9" id="KXB_GB_9" name="KXB_GB_9" onchange="complexKX2(this.value, 11)">
                                    <span>9</span>
                                    <input type="checkbox" class="complexCheck" value="KXB_GB_10" id="KXB_GB_10" name="KXB_GB_10" onchange="complexKX2(this.value, 11)">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>冠军</td>
                            <td>
                                <label><input @checked(in_array('GDX1_D',$detail)) type="radio" id="GDX1_D" class="radioUnSel" name="GDX1" value="GDX1_D">大</label>
                                <label><input @checked(in_array('GDX1_X',$detail)) type="radio" id="GDX1_X" class="radioUnSel" name="GDX1" value="GDX1_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS1_D',$detail)) type="radio" id="GDS1_D" class="radioUnSel" name="GDS1" value="GDS1_D">单</label>
                                <label><input @checked(in_array('GDS1_S',$detail)) type="radio" id="GDS1_S" class="radioUnSel" name="GDS1" value="GDS1_S">双</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GLH1_L',$detail)) type="radio" id="GLH1_L" class="radioUnSel" name="GLH1" value="GLH1_L">龙</label>
                                <label><input @checked(in_array('GLH1_H',$detail)) type="radio" id="GLH1_H" class="radioUnSel" name="GLH1" value="GLH1_H">虎</label>
                            </td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB1_1',$detail)) type="checkbox" class="complexCheck" value="GB1_1" id="GB1_1" name="GB1_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB1_2',$detail)) type="checkbox" class="complexCheck" value="GB1_2" id="GB1_2" name="GB1_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB1_3',$detail)) type="checkbox" class="complexCheck" value="GB1_3" id="GB1_3" name="GB1_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB1_4',$detail)) type="checkbox" class="complexCheck" value="GB1_4" id="GB1_4" name="GB1_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB1_5',$detail)) type="checkbox" class="complexCheck" value="GB1_5" id="GB1_5" name="GB1_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB1_6',$detail)) type="checkbox" class="complexCheck" value="GB1_6" id="GB1_6" name="GB1_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB1_7',$detail)) type="checkbox" class="complexCheck" value="GB1_7" id="GB1_7" name="GB1_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB1_8',$detail)) type="checkbox" class="complexCheck" value="GB1_8" id="GB1_8" name="GB1_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB1_9',$detail)) type="checkbox" class="complexCheck" value="GB1_9" id="GB1_9" name="GB1_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB1_10',$detail)) type="checkbox" class="complexCheck" value="GB1_10" id="GB1_10" name="GB1_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>亚军</td>
                            <td>
                                <label><input @checked(in_array('GDX2_D',$detail)) type="radio" id="GDX2_D" class="radioUnSel" name="GDX2" value="GDX2_D">大</label>
                                <label><input @checked(in_array('GDX2_X',$detail)) type="radio" id="GDX2_X" class="radioUnSel" name="GDX2" value="GDX2_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS2_D',$detail)) type="radio" id="GDS2_D" class="radioUnSel" name="GDS2" value="GDS2_D">单</label>
                                <label><input @checked(in_array('GDS2_S',$detail)) type="radio" id="GDS2_S" class="radioUnSel" name="GDS2" value="GDS2_S">双</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GLH2_L',$detail)) type="radio" id="GLH2_L" class="radioUnSel" name="GLH2" value="GLH2_L">龙</label>
                                <label><input @checked(in_array('GLH2_H',$detail)) type="radio" id="GLH2_H" class="radioUnSel" name="GLH2" value="GLH2_H">虎</label>
                            </td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB2_1',$detail)) type="checkbox" class="complexCheck" value="GB2_1" id="GB2_1" name="GB2_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB2_2',$detail)) type="checkbox" class="complexCheck" value="GB2_2" id="GB2_2" name="GB2_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB2_3',$detail)) type="checkbox" class="complexCheck" value="GB2_3" id="GB2_3" name="GB2_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB2_4',$detail)) type="checkbox" class="complexCheck" value="GB2_4" id="GB2_4" name="GB2_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB2_5',$detail)) type="checkbox" class="complexCheck" value="GB2_5" id="GB2_5" name="GB2_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB2_6',$detail)) type="checkbox" class="complexCheck" value="GB2_6" id="GB2_6" name="GB2_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB2_7',$detail)) type="checkbox" class="complexCheck" value="GB2_7" id="GB2_7" name="GB2_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB2_8',$detail)) type="checkbox" class="complexCheck" value="GB2_8" id="GB2_8" name="GB2_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB2_9',$detail)) type="checkbox" class="complexCheck" value="GB2_9" id="GB2_9" name="GB2_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB2_10',$detail)) type="checkbox" class="complexCheck" value="GB2_10" id="GB2_10" name="GB2_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第三名</td>
                            <td>
                                <label><input @checked(in_array('GDX3_D',$detail)) type="radio" id="GDX3_D" class="radioUnSel" name="GDX3" value="GDX3_D">大</label>
                                <label><input @checked(in_array('GDX3_X',$detail)) type="radio" id="GDX3_X" class="radioUnSel" name="GDX3" value="GDX3_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS3_D',$detail)) type="radio" id="GDS3_D" class="radioUnSel" name="GDS3" value="GDS3_D">单</label>
                                <label><input @checked(in_array('GDS3_S',$detail)) type="radio" id="GDS3_S" class="radioUnSel" name="GDS3" value="GDS3_S">双</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GLH3_L',$detail)) type="radio" id="GLH3_L" class="radioUnSel" name="GLH3" value="GLH3_L">龙</label>
                                <label><input @checked(in_array('GLH3_H',$detail)) type="radio" id="GLH3_H" class="radioUnSel" name="GLH3" value="GLH3_H">虎</label>
                            </td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB3_1',$detail)) type="checkbox" class="complexCheck" value="GB3_1" id="GB3_1" name="GB3_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB3_2',$detail)) type="checkbox" class="complexCheck" value="GB3_2" id="GB3_2" name="GB3_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB3_3',$detail)) type="checkbox" class="complexCheck" value="GB3_3" id="GB3_3" name="GB3_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB3_4',$detail)) type="checkbox" class="complexCheck" value="GB3_4" id="GB3_4" name="GB3_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB3_5',$detail)) type="checkbox" class="complexCheck" value="GB3_5" id="GB3_5" name="GB3_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB3_6',$detail)) type="checkbox" class="complexCheck" value="GB3_6" id="GB3_6" name="GB3_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB3_7',$detail)) type="checkbox" class="complexCheck" value="GB3_7" id="GB3_7" name="GB3_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB3_8',$detail)) type="checkbox" class="complexCheck" value="GB3_8" id="GB3_8" name="GB3_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB3_9',$detail)) type="checkbox" class="complexCheck" value="GB3_9" id="GB3_9" name="GB3_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB3_10',$detail)) type="checkbox" class="complexCheck" value="GB3_10" id="GB3_10" name="GB3_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第四名</td>
                            <td>
                                <label><input @checked(in_array('GDX4_D',$detail)) type="radio" id="GDX4_D" class="radioUnSel" name="GDX4" value="GDX4_D">大</label>
                                <label><input @checked(in_array('GDX4_X',$detail)) type="radio" id="GDX4_X" class="radioUnSel" name="GDX4" value="GDX4_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS4_D',$detail)) type="radio" id="GDS4_D" class="radioUnSel" name="GDS4" value="GDS4_D">单</label>
                                <label><input @checked(in_array('GDS4_S',$detail)) type="radio" id="GDS4_S" class="radioUnSel" name="GDS4" value="GDS4_S">双</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GLH4_L',$detail)) type="radio" id="GLH4_L" class="radioUnSel" name="GLH4" value="GLH4_L">龙</label>
                                <label><input @checked(in_array('GLH4_H',$detail)) type="radio" id="GLH4_H" class="radioUnSel" name="GLH4" value="GLH4_H">虎</label>
                            </td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB4_1',$detail)) type="checkbox" class="complexCheck" value="GB4_1" id="GB4_1" name="GB4_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB4_2',$detail)) type="checkbox" class="complexCheck" value="GB4_2" id="GB4_2" name="GB4_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB4_3',$detail)) type="checkbox" class="complexCheck" value="GB4_3" id="GB4_3" name="GB4_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB4_4',$detail)) type="checkbox" class="complexCheck" value="GB4_4" id="GB4_4" name="GB4_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB4_5',$detail)) type="checkbox" class="complexCheck" value="GB4_5" id="GB4_5" name="GB4_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB4_6',$detail)) type="checkbox" class="complexCheck" value="GB4_6" id="GB4_6" name="GB4_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB4_7',$detail)) type="checkbox" class="complexCheck" value="GB4_7" id="GB4_7" name="GB4_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB4_8',$detail)) type="checkbox" class="complexCheck" value="GB4_8" id="GB4_8" name="GB4_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB4_9',$detail)) type="checkbox" class="complexCheck" value="GB4_9" id="GB4_9" name="GB4_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB4_10',$detail)) type="checkbox" class="complexCheck" value="GB4_10" id="GB4_10" name="GB4_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第五名</td>
                            <td>
                                <label><input @checked(in_array('GDX5_D',$detail)) type="radio" id="GDX5_D" class="radioUnSel" name="GDX5" value="GDX5_D">大</label>
                                <label><input @checked(in_array('GDX5_X',$detail)) type="radio" id="GDX5_X" class="radioUnSel" name="GDX5" value="GDX5_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS5_D',$detail)) type="radio" id="GDS5_D" class="radioUnSel" name="GDS5" value="GDS5_D">单</label>
                                <label><input @checked(in_array('GDS5_S',$detail)) type="radio" id="GDS5_S" class="radioUnSel" name="GDS5" value="GDS5_S">双</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GLH5_L',$detail)) type="radio" id="GLH5_L" class="radioUnSel" name="GLH5" value="GLH5_L">龙</label>
                                <label><input @checked(in_array('GLH5_H',$detail)) type="radio" id="GLH5_H" class="radioUnSel" name="GLH5" value="GLH5_H">虎</label>
                            </td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB5_1',$detail)) type="checkbox" class="complexCheck" value="GB5_1" id="GB5_1" name="GB5_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB5_2',$detail)) type="checkbox" class="complexCheck" value="GB5_2" id="GB5_2" name="GB5_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB5_3',$detail)) type="checkbox" class="complexCheck" value="GB5_3" id="GB5_3" name="GB5_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB5_4',$detail)) type="checkbox" class="complexCheck" value="GB5_4" id="GB5_4" name="GB5_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB5_5',$detail)) type="checkbox" class="complexCheck" value="GB5_5" id="GB5_5" name="GB5_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB5_6',$detail)) type="checkbox" class="complexCheck" value="GB5_6" id="GB5_6" name="GB5_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB5_7',$detail)) type="checkbox" class="complexCheck" value="GB5_7" id="GB5_7" name="GB5_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB5_8',$detail)) type="checkbox" class="complexCheck" value="GB5_8" id="GB5_8" name="GB5_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB5_9',$detail)) type="checkbox" class="complexCheck" value="GB5_9" id="GB5_9" name="GB5_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB5_10',$detail)) type="checkbox" class="complexCheck" value="GB5_10" id="GB5_10" name="GB5_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第六名</td>
                            <td>
                                <label><input @checked(in_array('GDX6_D',$detail)) type="radio" id="GDX6_D" class="radioUnSel" name="GDX6" value="GDX6_D">大</label>
                                <label><input @checked(in_array('GDX6_X',$detail)) type="radio" id="GDX6_X" class="radioUnSel" name="GDX6" value="GDX6_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS6_D',$detail)) type="radio" id="GDS6_D" class="radioUnSel" name="GDS6" value="GDS6_D">单</label>
                                <label><input @checked(in_array('GDS6_S',$detail)) type="radio" id="GDS6_S" class="radioUnSel" name="GDS6" value="GDS6_S">双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB6_1',$detail)) type="checkbox" class="complexCheck" value="GB6_1" id="GB6_1" name="GB6_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB6_2',$detail)) type="checkbox" class="complexCheck" value="GB6_2" id="GB6_2" name="GB6_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB6_3',$detail)) type="checkbox" class="complexCheck" value="GB6_3" id="GB6_3" name="GB6_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB6_4',$detail)) type="checkbox" class="complexCheck" value="GB6_4" id="GB6_4" name="GB6_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB6_5',$detail)) type="checkbox" class="complexCheck" value="GB6_5" id="GB6_5" name="GB6_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB6_6',$detail)) type="checkbox" class="complexCheck" value="GB6_6" id="GB6_6" name="GB6_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB6_7',$detail)) type="checkbox" class="complexCheck" value="GB6_7" id="GB6_7" name="GB6_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB6_8',$detail)) type="checkbox" class="complexCheck" value="GB6_8" id="GB6_8" name="GB6_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB6_9',$detail)) type="checkbox" class="complexCheck" value="GB6_9" id="GB6_9" name="GB6_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB6_10',$detail)) type="checkbox" class="complexCheck" value="GB6_10" id="GB6_10" name="GB6_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第七名</td>
                            <td>
                                <label><input @checked(in_array('GDX7_D',$detail)) type="radio" id="GDX7_D" class="radioUnSel" name="GDX7" value="GDX7_D">大</label>
                                <label><input @checked(in_array('GDX7_X',$detail)) type="radio" id="GDX7_X" class="radioUnSel" name="GDX7" value="GDX7_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS7_D',$detail)) type="radio" id="GDS7_D" class="radioUnSel" name="GDS7" value="GDS7_D">单</label>
                                <label><input @checked(in_array('GDS7_S',$detail)) type="radio" id="GDS7_S" class="radioUnSel" name="GDS7" value="GDS7_S">双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB7_1',$detail)) type="checkbox" class="complexCheck" value="GB7_1" id="GB7_1" name="GB7_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB7_2',$detail)) type="checkbox" class="complexCheck" value="GB7_2" id="GB7_2" name="GB7_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB7_3',$detail)) type="checkbox" class="complexCheck" value="GB7_3" id="GB7_3" name="GB7_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB7_4',$detail)) type="checkbox" class="complexCheck" value="GB7_4" id="GB7_4" name="GB7_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB7_5',$detail)) type="checkbox" class="complexCheck" value="GB7_5" id="GB7_5" name="GB7_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB7_6',$detail)) type="checkbox" class="complexCheck" value="GB7_6" id="GB7_6" name="GB7_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB7_7',$detail)) type="checkbox" class="complexCheck" value="GB7_7" id="GB7_7" name="GB7_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB7_8',$detail)) type="checkbox" class="complexCheck" value="GB7_8" id="GB7_8" name="GB7_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB7_9',$detail)) type="checkbox" class="complexCheck" value="GB7_9" id="GB7_9" name="GB7_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB7_10',$detail)) type="checkbox" class="complexCheck" value="GB7_10" id="GB7_10" name="GB7_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第八名</td>
                            <td>
                                <label><input @checked(in_array('GDX8_D',$detail)) type="radio" id="GDX8_D" class="radioUnSel" name="GDX8" value="GDX8_D">大</label>
                                <label><input @checked(in_array('GDX8_X',$detail)) type="radio" id="GDX8_X" class="radioUnSel" name="GDX8" value="GDX8_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS8_D',$detail)) type="radio" id="GDS8_D" class="radioUnSel" name="GDS8" value="GDS8_D">单</label>
                                <label><input @checked(in_array('GDS8_S',$detail)) type="radio" id="GDS8_S" class="radioUnSel" name="GDS8" value="GDS8_S">双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB8_1',$detail)) type="checkbox" class="complexCheck" value="GB8_1" id="GB8_1" name="GB8_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB8_2',$detail)) type="checkbox" class="complexCheck" value="GB8_2" id="GB8_2" name="GB8_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB8_3',$detail)) type="checkbox" class="complexCheck" value="GB8_3" id="GB8_3" name="GB8_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB8_4',$detail)) type="checkbox" class="complexCheck" value="GB8_4" id="GB8_4" name="GB8_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB8_5',$detail)) type="checkbox" class="complexCheck" value="GB8_5" id="GB8_5" name="GB8_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB8_6',$detail)) type="checkbox" class="complexCheck" value="GB8_6" id="GB8_6" name="GB8_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB8_7',$detail)) type="checkbox" class="complexCheck" value="GB8_7" id="GB8_7" name="GB8_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB8_8',$detail)) type="checkbox" class="complexCheck" value="GB8_8" id="GB8_8" name="GB8_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB8_9',$detail)) type="checkbox" class="complexCheck" value="GB8_9" id="GB8_9" name="GB8_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB8_10',$detail)) type="checkbox" class="complexCheck" value="GB8_10" id="GB8_10" name="GB8_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第九名</td>
                            <td>
                                <label><input @checked(in_array('GDX9_D',$detail)) type="radio" id="GDX9_D" class="radioUnSel" name="GDX9" value="GDX9_D">大</label>
                                <label><input @checked(in_array('GDX9_X',$detail)) type="radio" id="GDX9_X" class="radioUnSel" name="GDX9" value="GDX9_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS9_D',$detail)) type="radio" id="GDS9_D" class="radioUnSel" name="GDS9" value="GDS9_D">单</label>
                                <label><input @checked(in_array('GDS9_S',$detail)) type="radio" id="GDS9_S" class="radioUnSel" name="GDS9" value="GDS9_S">双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB9_1',$detail)) type="checkbox" class="complexCheck" value="GB9_1" id="GB9_1" name="GB9_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB9_2',$detail)) type="checkbox" class="complexCheck" value="GB9_2" id="GB9_2" name="GB9_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB9_3',$detail)) type="checkbox" class="complexCheck" value="GB9_3" id="GB9_3" name="GB9_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB9_4',$detail)) type="checkbox" class="complexCheck" value="GB9_4" id="GB9_4" name="GB9_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB9_5',$detail)) type="checkbox" class="complexCheck" value="GB9_5" id="GB9_5" name="GB9_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB9_6',$detail)) type="checkbox" class="complexCheck" value="GB9_6" id="GB9_6" name="GB9_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB9_7',$detail)) type="checkbox" class="complexCheck" value="GB9_7" id="GB9_7" name="GB9_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB9_8',$detail)) type="checkbox" class="complexCheck" value="GB9_8" id="GB9_8" name="GB9_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB9_9',$detail)) type="checkbox" class="complexCheck" value="GB9_9" id="GB9_9" name="GB9_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB9_10',$detail)) type="checkbox" class="complexCheck" value="GB9_10" id="GB9_10" name="GB9_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>第十名</td>
                            <td>
                                <label><input @checked(in_array('GDX10_D',$detail)) type="radio" id="GDX10_D" class="radioUnSel" name="GDX10" value="GDX10_D">大</label>
                                <label><input @checked(in_array('GDX10_X',$detail)) type="radio" id="GDX10_X" class="radioUnSel" name="GDX10" value="GDX10_X">小</label>
                            </td>
                            <td>
                                <label><input @checked(in_array('GDS10_D',$detail)) type="radio" id="GDS10_D" class="radioUnSel" name="GDS10" value="GDS10_D">单</label>
                                <label><input @checked(in_array('GDS10_S',$detail)) type="radio" id="GDS10_S" class="radioUnSel" name="GDS10" value="GDS10_S">双</label>
                            </td>
                            <td></td>
                            <td>
                                <div class="betNumbers">
                                    <input @checked(in_array('GB10_1',$detail)) type="checkbox" class="complexCheck" value="GB10_1" id="GB10_1" name="GB10_1">
                                    <span>1</span>
                                    <input @checked(in_array('GB10_2',$detail)) type="checkbox" class="complexCheck" value="GB10_2" id="GB10_2" name="GB10_2">
                                    <span>2</span>
                                    <input @checked(in_array('GB10_3',$detail)) type="checkbox" class="complexCheck" value="GB10_3" id="GB10_3" name="GB10_3">
                                    <span>3</span>
                                    <input @checked(in_array('GB10_4',$detail)) type="checkbox" class="complexCheck" value="GB10_4" id="GB10_4" name="GB10_4">
                                    <span>4</span>
                                    <input @checked(in_array('GB10_5',$detail)) type="checkbox" class="complexCheck" value="GB10_5" id="GB10_5" name="GB10_5">
                                    <span>5</span>
                                    <input @checked(in_array('GB10_6',$detail)) type="checkbox" class="complexCheck" value="GB10_6" id="GB10_6" name="GB10_6">
                                    <span>6</span>
                                    <input @checked(in_array('GB10_7',$detail)) type="checkbox" class="complexCheck" value="GB10_7" id="GB10_7" name="GB10_7">
                                    <span>7</span>
                                    <input @checked(in_array('GB10_8',$detail)) type="checkbox" class="complexCheck" value="GB10_8" id="GB10_8" name="GB10_8">
                                    <span>8</span>
                                    <input @checked(in_array('GB10_9',$detail)) type="checkbox" class="complexCheck" value="GB10_9" id="GB10_9" name="GB10_9">
                                    <span>9</span>
                                    <input @checked(in_array('GB10_10',$detail)) type="checkbox" class="complexCheck" value="GB10_10" id="GB10_10" name="GB10_10">
                                    <span>10</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>冠亚</td>
                            <td>
                                <div class="betRadio">
                                    <label><input @checked(in_array('GGDX_D',$detail)) type="radio" id="GGDX_D" class="radioUnSel" name="GGDX" value="GGDX_D">大</label>
                                    <label><input @checked(in_array('GGDX_X',$detail)) type="radio" id="GGDX_X" class="radioUnSel" name="GGDX" value="GGDX_X">小</label>
                                </div>
                            </td>
                            <td>
                                <label><input @checked(in_array('GGDS_D',$detail)) type="radio" id="GGDS_D" class="radioUnSel" name="GGDS" value="GGDS_D">单</label>
                                <label><input @checked(in_array('GGDS_S',$detail)) type="radio" id="GGDS_S" class="radioUnSel" name="GGDS" value="GGDS_S">双</label>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    @endif
                    <br>
                    <form id="saveForm" name="complexForm1Bottom">
                        <div id="complexForm2">
                            <div class="left">
                                <div>
                                    <span id="planNamePlaceholder" class="planNamePlaceholder">自定义方式名称</span>
                                    <input class="planName" type="text" onkeydown="return (event.keyCode!=13);" id="planName" name="planName" value="{{$complex['planName']}}" placeholder="默认“方式+序号”,不超过16中英数符号">
                                </div>
                                <div>
                                    <span id="takeProfitPlaceholder" class="takeProfitPlaceholder">当日止盈金额</span>
                                    <input type="text" id="takeProfit" onkeydown="return (event.keyCode!=13);" class="takeProfit" name="takeProfit" value="{{$complex['takeprofit']}}" placeholder="可填可不填">
                                </div>
                                <div>
                                    <span id="stopLossPlaceholder" class="stopLossPlaceholder">当日止损金额</span>
                                    <input type="text" id="stopLoss" onkeydown="return (event.keyCode!=13);" class="stopLoss" name="stopLoss" value="{{$complex['stoploss']}}" placeholder="可填可不填">
                                </div>
                            </div>
                            <div class="right">
                                <div>
                                    <span id="fbAmountPlaceholder" class="fbAmountPlaceholder">金额模式</span>
                                    <label><input @checked($complex['betMode']==0) type="radio" name="amt_mode" value="0" onchange="onChangeBetMode(this.value)" />固定投注</label>
                                    <label><input @checked($complex['betMode']==1) type="radio" name="amt_mode" value="1" onchange="onChangeBetMode(this.value)" />翻倍投注</label>
                                </div>
                                <div>
                                    <span id="complexfbMode" class="complexfbMode" style="display: flex">
                                        <span id="fbModePlaceholder" class="fbModePlaceholder">翻倍方式</span>
                                        <label><input @checked($complex['fbMode']==0) type="radio" name="fb_mode" value="0" onchange="onChangeFBMode(this.value)" />中翻倍</label>
                                        <label><input @checked($complex['fbMode']==1) type="radio" name="fb_mode" value="1" onchange="onChangeFBMode(this.value)" />不中翻倍</label>
                                    </span>
                                </div>
                                <div>
                                    <span id="complexfbbzMode" class="complexfbbzMode" style="display: flex">
                                        <span @if($complex['fbMode']==0)style="display: inline-block;" @else style="display: none;" @endif id="complexfbbzModeHit" class="complexfbbzModeHit">翻倍<span class="red">不中</span>之后的投注金额</span>
                                        <span @if($complex['fbMode']==1)style="display: inline-block;" @else style="display: none;" @endif id="complexfbbzModeNoHit" class="complexfbbzModeNoHit">翻倍<span class="red">中</span>之后的投注金额</span>
                                        <label><input @checked($complex['fbbzMode']==0) type="radio" name="fbbz_mode" value="0" />退回到第一金额</label>
                                        <label><input @checked($complex['fbbzMode']==1) type="radio" name="fbbz_mode" value="1" />退回上一个金额</label>
                                    </span>
                                </div>
                                <div>
                                    <span id="fbAmountPlaceholder" class="fbAmountPlaceholder"><span class="red">*</span>投注金额</span>
                                    <div class="inputDisclaimer">
                                            <textarea id="amount" class="amount" onkeydown="return (event.keyCode!=13);" name="amount" placeholder="可输入多个金额，并于“英文逗号“隔开。最多输入20个金额，达最后一个时再翻就取最后一个">{{$complex['amount']}}</textarea>
                                        <span id="fbAmoutDisclaimer" class="fbAmoutDisclaimer">输入的金额不能小于单注最低，最大不能大于注单限额</span>
                                    </div>
                                </div>
                            </div>
                            <div class="formFooter">
                                <input type="button" id="complex1Save" class="complex1Save" value="确定" onclick="saveComplexBet(lotteryid, {{$id}})">
                                <input type="button" id="complex1Cancel" class="complex1Cancel" value="取消" onclick="back()">
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        @if($complex['betMode'] == 1)
        $('#complexfbMode').show();
        $('#complexfbbzMode').show();
        @else
        $('#complexfbMode').hide();
        $('#complexfbbzMode').hide();
        @endif
    });
</script>








































