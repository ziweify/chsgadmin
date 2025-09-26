<script type="text/javascript">
    var SP_NAMES = true;
    $(function () {
        ResultPanel.init($('#historyResult tbody'), [['period', -2], ['ball', 0], ['ball', 1], ['ball', 2], ['total'], ['zdx', 11, -1, true]]);
    });
</script>
<table class="table_ball">
    <tr class="head">
        <th colspan="12">三军、大小</th>
    </tr>
    <tr>
        <th class="G3G_1 name ballname" id="t_3G_1" title="三军 1/鱼"><input type="hidden" id="k_3G_1"
                                                                             value="3G"/><span class="b1">1/鱼</span>
        </th>
        <td class="G3G_1 odds ballodds" id="o_3G_1" lang="3"></td>
        <td class="G3G_1 amount ha" id="a_3G_1"><input name="3G_1" class="ba"/></td>
        <th class="G3G_2 name ballname" id="t_3G_2" title="三军 2/虾"><input type="hidden" id="k_3G_2"
                                                                             value="3G"/><span class="b2">2/虾</span>
        </th>
        <td class="G3G_2 odds ballodds" id="o_3G_2" lang="3"></td>
        <td class="G3G_2 amount ha" id="a_3G_2"><input name="3G_2" class="ba"/></td>
        <th class="G3G_3 name ballname" id="t_3G_3" title="三军 3/葫芦"><input type="hidden" id="k_3G_3"
                                                                               value="3G"/><span class="b3">3/葫芦</span>
        </th>
        <td class="G3G_3 odds ballodds" id="o_3G_3" lang="3"></td>
        <td class="G3G_3 amount ha" id="a_3G_3"><input name="3G_3" class="ba"/></td>
        <th class="GDX_D name" id="t_DX_D" title=" 大"><input type="hidden" id="k_DX_D" value="DX"/>大</th>

        <td class="GDX_D odds" id="o_DX_D"></td>
        <td class="GDX_D amount ha" id="a_DX_D"><input name="DX_D" class="ba"/></td>
    </tr>
    <tr>
        <th class="G3G_4 name ballname" id="t_3G_4" title="三军 4/金钱"><input type="hidden" id="k_3G_4"
                                                                               value="3G"/><span class="b4">4/金钱</span>
        </th>
        <td class="G3G_4 odds ballodds" id="o_3G_4" lang="3"></td>
        <td class="G3G_4 amount ha" id="a_3G_4"><input name="3G_4" class="ba"/></td>
        <th class="G3G_5 name ballname" id="t_3G_5" title="三军 5/螃蟹"><input type="hidden" id="k_3G_5"
                                                                               value="3G"/><span class="b5">5/螃蟹</span>
        </th>
        <td class="G3G_5 odds ballodds" id="o_3G_5" lang="3"></td>
        <td class="G3G_5 amount ha" id="a_3G_5"><input name="3G_5" class="ba"/></td>
        <th class="G3G_6 name ballname" id="t_3G_6" title="三军 6/鸡"><input type="hidden" id="k_3G_6"
                                                                             value="3G"/><span class="b6">6/鸡</span>
        </th>
        <td class="G3G_6 odds ballodds" id="o_3G_6" lang="3"></td>
        <td class="G3G_6 amount ha" id="a_3G_6"><input name="3G_6" class="ba"/></td>
        <th class="GDX_X name" id="t_DX_X" title=" 小"><input type="hidden" id="k_DX_X" value="DX"/>小</th>

        <td class="GDX_X odds" id="o_DX_X"></td>
        <td class="GDX_X amount ha" id="a_DX_X"><input name="DX_X" class="ba"/></td>
    </tr>
</table>
<div style="display:none">
    <span id="o_3G_1_1"></span>
    <span id="o_3G_1_2"></span>
    <span id="o_3G_2_1"></span>
    <span id="o_3G_2_2"></span>
    <span id="o_3G_3_1"></span>
    <span id="o_3G_3_2"></span>
    <span id="o_3G_4_1"></span>
    <span id="o_3G_4_2"></span>
    <span id="o_3G_5_1"></span>
    <span id="o_3G_5_2"></span>
    <span id="o_3G_6_1"></span>
    <span id="o_3G_6_2"></span>
</div>
<br/>
<table class="table_ball table_ts table_ts_dpqs">
    <tbody><tr class="head"><th colspan="9">围骰、全骰</th></tr>
    <tr>
        <th class="GWS_111 name tsname" id="t_WS_111" title="围骰 111"><div><span class="b1">1</span><span class="b1">1</span><span class="b1">1</span></div></th>

        <td class="GWS_111 odds tsodds" id="o_WS_111">--</td>
        <td class="GWS_111 amount ha" id="a_WS_111"><input name="WS_111" class="ba" disabled=""></td>
        <th class="GWS_222 name tsname" id="t_WS_222" title="围骰 222"><div><span class="b2">2</span><span class="b2">2</span><span class="b2">2</span></div></th>

        <td class="GWS_222 odds tsodds" id="o_WS_222">--</td>
        <td class="GWS_222 amount ha" id="a_WS_222"><input name="WS_222" class="ba" disabled=""></td>
        <th class="GWS_333 name tsname" id="t_WS_333" title="围骰 333"><div><span class="b3">3</span><span class="b3">3</span><span class="b3">3</span></div></th>

        <td class="GWS_333 odds tsodds" id="o_WS_333">--</td>
        <td class="GWS_333 amount ha" id="a_WS_333"><input name="WS_333" class="ba" disabled=""></td>
    </tr>
    <tr>
        <th class="GWS_444 name tsname hover" id="t_WS_444" title="围骰 444"><div><span class="b4">4</span><span class="b4">4</span><span class="b4">4</span></div></th>

        <td class="GWS_444 odds tsodds hover" id="o_WS_444">--</td>
        <td class="GWS_444 amount ha hover" id="a_WS_444"><input name="WS_444" class="ba" disabled=""></td>
        <th class="GWS_555 name tsname" id="t_WS_555" title="围骰 555"><div><span class="b5">5</span><span class="b5">5</span><span class="b5">5</span></div></th>

        <td class="GWS_555 odds tsodds" id="o_WS_555">--</td>
        <td class="GWS_555 amount ha" id="a_WS_555"><input name="WS_555" class="ba" disabled=""></td>
        <th class="GWS_666 name tsname" id="t_WS_666" title="围骰 666"><div><span class="b6">6</span><span class="b6">6</span><span class="b6">6</span></div></th>

        <td class="GWS_666 odds tsodds" id="o_WS_666">--</td>
        <td class="GWS_666 amount ha" id="a_WS_666"><input name="WS_666" class="ba" disabled=""></td>
    </tr>
    <tr>
        <th class="GQS_0 name" id="t_QS_0" title=" 全骰"><input type="hidden" id="k_QS_0" value="QS">全骰</th>

        <td class="GQS_0 odds" id="o_QS_0">--</td>
        <td class="GQS_0 amount ha" id="a_QS_0"><input name="QS_0" class="ba" disabled=""></td>
        <th id="e_EP0" class="GEP0 name empty"></th><td class="GEP0 odds empty"></td><td class="GEP0 amount ha"></td>
        <th id="e_EP1" class="GEP1 name empty"></th><td class="GEP1 odds empty"></td><td class="GEP1 amount ha"></td>
    </tr>
    </tbody></table>
<br/>
<table class="table_ds">
    <tbody><tr class="head"><th colspan="12">点数</th></tr>
    <tr>
        <th class="GDS_4 name" id="t_DS_4" title="点数 4点"><input type="hidden" id="k_DS_4" value="DS">4点</th>

        <td class="GDS_4 odds" id="o_DS_4">--</td>
        <td class="GDS_4 amount ha" id="a_DS_4"><input name="DS_4" class="ba"></td>
        <th class="GDS_5 name" id="t_DS_5" title="点数 5点"><input type="hidden" id="k_DS_5" value="DS">5点</th>

        <td class="GDS_5 odds" id="o_DS_5">--</td>
        <td class="GDS_5 amount ha" id="a_DS_5"><input name="DS_5" class="ba"></td>
        <th class="GDS_6 name" id="t_DS_6" title="点数 6点"><input type="hidden" id="k_DS_6" value="DS">6点</th>

        <td class="GDS_6 odds" id="o_DS_6">--</td>
        <td class="GDS_6 amount ha" id="a_DS_6"><input name="DS_6" class="ba"></td>
        <th class="GDS_7 name" id="t_DS_7" title="点数 7点"><input type="hidden" id="k_DS_7" value="DS">7点</th>

        <td class="GDS_7 odds" id="o_DS_7">--</td>
        <td class="GDS_7 amount ha" id="a_DS_7"><input name="DS_7" class="ba"></td>
    </tr>
    <tr>
        <th class="GDS_8 name" id="t_DS_8" title="点数 8点"><input type="hidden" id="k_DS_8" value="DS">8点</th>

        <td class="GDS_8 odds" id="o_DS_8">--</td>
        <td class="GDS_8 amount ha" id="a_DS_8"><input name="DS_8" class="ba"></td>
        <th class="GDS_9 name" id="t_DS_9" title="点数 9点"><input type="hidden" id="k_DS_9" value="DS">9点</th>

        <td class="GDS_9 odds" id="o_DS_9">--</td>
        <td class="GDS_9 amount ha" id="a_DS_9"><input name="DS_9" class="ba"></td>
        <th class="GDS_10 name" id="t_DS_10" title="点数 10点"><input type="hidden" id="k_DS_10" value="DS">10点</th>

        <td class="GDS_10 odds" id="o_DS_10">--</td>
        <td class="GDS_10 amount ha" id="a_DS_10"><input name="DS_10" class="ba"></td>
        <th class="GDS_11 name" id="t_DS_11" title="点数 11点"><input type="hidden" id="k_DS_11" value="DS">11点</th>

        <td class="GDS_11 odds" id="o_DS_11">--</td>
        <td class="GDS_11 amount ha" id="a_DS_11"><input name="DS_11" class="ba"></td>
    </tr>
    <tr>
        <th class="GDS_12 name" id="t_DS_12" title="点数 12点"><input type="hidden" id="k_DS_12" value="DS">12点</th>

        <td class="GDS_12 odds" id="o_DS_12">--</td>
        <td class="GDS_12 amount ha" id="a_DS_12"><input name="DS_12" class="ba"></td>
        <th class="GDS_13 name" id="t_DS_13" title="点数 13点"><input type="hidden" id="k_DS_13" value="DS">13点</th>

        <td class="GDS_13 odds" id="o_DS_13">--</td>
        <td class="GDS_13 amount ha" id="a_DS_13"><input name="DS_13" class="ba"></td>
        <th class="GDS_14 name" id="t_DS_14" title="点数 14点"><input type="hidden" id="k_DS_14" value="DS">14点</th>

        <td class="GDS_14 odds" id="o_DS_14">--</td>
        <td class="GDS_14 amount ha" id="a_DS_14"><input name="DS_14" class="ba"></td>
        <th class="GDS_15 name" id="t_DS_15" title="点数 15点"><input type="hidden" id="k_DS_15" value="DS">15点</th>

        <td class="GDS_15 odds" id="o_DS_15">--</td>
        <td class="GDS_15 amount ha" id="a_DS_15"><input name="DS_15" class="ba"></td>
    </tr>
    <tr>
        <th class="GDS_16 name" id="t_DS_16" title="点数 16点"><input type="hidden" id="k_DS_16" value="DS">16点</th>

        <td class="GDS_16 odds" id="o_DS_16">--</td>
        <td class="GDS_16 amount ha" id="a_DS_16"><input name="DS_16" class="ba"></td>
        <th class="GDS_17 name" id="t_DS_17" title="点数 17点"><input type="hidden" id="k_DS_17" value="DS">17点</th>

        <td class="GDS_17 odds" id="o_DS_17">--</td>
        <td class="GDS_17 amount ha" id="a_DS_17"><input name="DS_17" class="ba"></td>
        <th id="e_EP2" class="GEP2 name empty"></th><td class="GEP2 odds empty"></td><td class="GEP2 amount ha"></td>
        <th id="e_EP3" class="GEP3 name empty"></th><td class="GEP3 odds empty"></td><td class="GEP3 amount ha"></td>
    </tr>
    </tbody></table>
<br/>
<table class="table_ball table_ts table_ts1">
    <tbody><tr class="head"><th colspan="9">长牌</th></tr>
    <tr>
        <th class="GCP_12 name tsname" id="t_CP_12" title="长牌 12"><div><span class="b1">1</span><span class="b2">2</span></div></th>

        <td class="GCP_12 odds tsodds" id="o_CP_12">--</td>
        <td class="GCP_12 amount ha" id="a_CP_12"><input name="CP_12" class="ba"></td>
        <th class="GCP_13 name tsname" id="t_CP_13" title="长牌 13"><div><span class="b1">1</span><span class="b3">3</span></div></th>

        <td class="GCP_13 odds tsodds" id="o_CP_13">--</td>
        <td class="GCP_13 amount ha" id="a_CP_13"><input name="CP_13" class="ba"></td>
        <th class="GCP_14 name tsname" id="t_CP_14" title="长牌 14"><div><span class="b1">1</span><span class="b4">4</span></div></th>

        <td class="GCP_14 odds tsodds" id="o_CP_14">--</td>
        <td class="GCP_14 amount ha" id="a_CP_14"><input name="CP_14" class="ba"></td>
    </tr>
    <tr>
        <th class="GCP_15 name tsname" id="t_CP_15" title="长牌 15"><div><span class="b1">1</span><span class="b5">5</span></div></th>

        <td class="GCP_15 odds tsodds" id="o_CP_15">--</td>
        <td class="GCP_15 amount ha" id="a_CP_15"><input name="CP_15" class="ba"></td>
        <th class="GCP_16 name tsname" id="t_CP_16" title="长牌 16"><div><span class="b1">1</span><span class="b6">6</span></div></th>

        <td class="GCP_16 odds tsodds" id="o_CP_16">--</td>
        <td class="GCP_16 amount ha" id="a_CP_16"><input name="CP_16" class="ba"></td>
        <th class="GCP_23 name tsname" id="t_CP_23" title="长牌 23"><div><span class="b2">2</span><span class="b3">3</span></div></th>

        <td class="GCP_23 odds tsodds" id="o_CP_23">--</td>
        <td class="GCP_23 amount ha" id="a_CP_23"><input name="CP_23" class="ba"></td>
    </tr>
    <tr>
        <th class="GCP_24 name tsname" id="t_CP_24" title="长牌 24"><div><span class="b2">2</span><span class="b4">4</span></div></th>

        <td class="GCP_24 odds tsodds" id="o_CP_24">--</td>
        <td class="GCP_24 amount ha" id="a_CP_24"><input name="CP_24" class="ba"></td>
        <th class="GCP_25 name tsname" id="t_CP_25" title="长牌 25"><div><span class="b2">2</span><span class="b5">5</span></div></th>

        <td class="GCP_25 odds tsodds" id="o_CP_25">--</td>
        <td class="GCP_25 amount ha" id="a_CP_25"><input name="CP_25" class="ba"></td>
        <th class="GCP_26 name tsname" id="t_CP_26" title="长牌 26"><div><span class="b2">2</span><span class="b6">6</span></div></th>

        <td class="GCP_26 odds tsodds" id="o_CP_26">--</td>
        <td class="GCP_26 amount ha" id="a_CP_26"><input name="CP_26" class="ba"></td>
    </tr>
    <tr>
        <th class="GCP_34 name tsname" id="t_CP_34" title="长牌 34"><div><span class="b3">3</span><span class="b4">4</span></div></th>

        <td class="GCP_34 odds tsodds" id="o_CP_34">--</td>
        <td class="GCP_34 amount ha" id="a_CP_34"><input name="CP_34" class="ba"></td>
        <th class="GCP_35 name tsname" id="t_CP_35" title="长牌 35"><div><span class="b3">3</span><span class="b5">5</span></div></th>

        <td class="GCP_35 odds tsodds" id="o_CP_35">--</td>
        <td class="GCP_35 amount ha" id="a_CP_35"><input name="CP_35" class="ba"></td>
        <th class="GCP_36 name tsname" id="t_CP_36" title="长牌 36"><div><span class="b3">3</span><span class="b6">6</span></div></th>

        <td class="GCP_36 odds tsodds" id="o_CP_36">--</td>
        <td class="GCP_36 amount ha" id="a_CP_36"><input name="CP_36" class="ba"></td>
    </tr>
    <tr>
        <th class="GCP_45 name tsname" id="t_CP_45" title="长牌 45"><div><span class="b4">4</span><span class="b5">5</span></div></th>

        <td class="GCP_45 odds tsodds" id="o_CP_45">--</td>
        <td class="GCP_45 amount ha" id="a_CP_45"><input name="CP_45" class="ba"></td>
        <th class="GCP_46 name tsname" id="t_CP_46" title="长牌 46"><div><span class="b4">4</span><span class="b6">6</span></div></th>

        <td class="GCP_46 odds tsodds" id="o_CP_46">--</td>
        <td class="GCP_46 amount ha" id="a_CP_46"><input name="CP_46" class="ba"></td>
        <th class="GCP_56 name tsname" id="t_CP_56" title="长牌 56"><div><span class="b5">5</span><span class="b6">6</span></div></th>

        <td class="GCP_56 odds tsodds" id="o_CP_56">--</td>
        <td class="GCP_56 amount ha" id="a_CP_56"><input name="CP_56" class="ba"></td>
    </tr>
    </tbody></table>
<br/>
<table class="table_ball table_ts table_ts1">
    <tbody><tr class="head"><th colspan="9">短牌</th></tr>
    <tr>
        <th class="GDP_11 name tsname hover" id="t_DP_11" title="短牌 11"><div><span class="b1">1</span><span class="b1">1</span></div></th>

        <td class="GDP_11 odds tsodds hover" id="o_DP_11">--</td>
        <td class="GDP_11 amount ha hover" id="a_DP_11"><input name="DP_11" class="ba" disabled=""></td>
        <th class="GDP_22 name tsname" id="t_DP_22" title="短牌 22"><div><span class="b2">2</span><span class="b2">2</span></div></th>

        <td class="GDP_22 odds tsodds" id="o_DP_22">--</td>
        <td class="GDP_22 amount ha" id="a_DP_22"><input name="DP_22" class="ba" disabled=""></td>
        <th class="GDP_33 name tsname" id="t_DP_33" title="短牌 33"><div><span class="b3">3</span><span class="b3">3</span></div></th>

        <td class="GDP_33 odds tsodds" id="o_DP_33">--</td>
        <td class="GDP_33 amount ha" id="a_DP_33"><input name="DP_33" class="ba" disabled=""></td>
    </tr>
    <tr>
        <th class="GDP_44 name tsname" id="t_DP_44" title="短牌 44"><div><span class="b4">4</span><span class="b4">4</span></div></th>

        <td class="GDP_44 odds tsodds" id="o_DP_44">--</td>
        <td class="GDP_44 amount ha" id="a_DP_44"><input name="DP_44" class="ba" disabled=""></td>
        <th class="GDP_55 name tsname" id="t_DP_55" title="短牌 55"><div><span class="b5">5</span><span class="b5">5</span></div></th>

        <td class="GDP_55 odds tsodds" id="o_DP_55">--</td>
        <td class="GDP_55 amount ha" id="a_DP_55"><input name="DP_55" class="ba" disabled=""></td>
        <th class="GDP_66 name tsname" id="t_DP_66" title="短牌 66"><div><span class="b6">6</span><span class="b6">6</span></div></th>

        <td class="GDP_66 odds tsodds" id="o_DP_66">--</td>
        <td class="GDP_66 amount ha" id="a_DP_66"><input name="DP_66" class="ba" disabled=""></td>
    </tr>
    </tbody></table>
