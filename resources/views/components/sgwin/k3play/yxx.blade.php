<script type="text/javascript">var games='3G';
    $(function(){
        ResultPanel.init($('#historyResult tbody'),[['period', -2],['ball', 0],['ball', 1],['ball', 2]]);
        $('#main .control').hide();
        $('.panel_yxx .name').each(function(){var t=$(this);t.text(t.text()+'@开2骰@开3骰')});
    });
    function toggleBet(isOpening) {
        $('.panel_yxx a').toggle(isOpening);
    }
</script>
<div class="control n_anniu yxxpopupresult">
    <input type="button" class="button2 show-result-list-btn" value="查看近期开奖" onclick="showResultList();" style="float:right;">
    <div class="buttons">
        <label class="checkdefault"><input type="checkbox" class="checkbox"><span class="color_lv bold">预设</span></label>&nbsp;&nbsp;<label id="quickAmount" class="quickAmount"><span class="color_lv bold">金额</span> <input></label>
        <input type="button" onclick="bet()" value="确定" class="button">
        <input type="button" onclick="resetBets()" value="重置" class="button">
        <input type="button" class="button" value="重覆上次下单" onclick="repeatbet()" style="width: 100px">
    </div>
</div>
<div class="panel_yxx odds">
    <a href="javascript:void(0)" id="o_3G_1" lang="3" style="display: none;">--</a><div style="display:none"><span id="t_3G_1" title="三军 1/鱼" class="name">1/鱼@开2骰@开3骰</span><input type="hidden" id="k_3G_1" value="3G"><span id="o_3G_1_1">2.974</span><span id="o_3G_1_2">4.461</span></div><a href="javascript:void(0)" id="o_3G_2" lang="3" style="display: none;">--</a><div style="display:none"><span id="t_3G_2" title="三军 2/虾" class="name">2/虾@开2骰@开3骰</span><input type="hidden" id="k_3G_2" value="3G"><span id="o_3G_2_1">2.974</span><span id="o_3G_2_2">4.461</span></div><a href="javascript:void(0)" id="o_3G_3" lang="3" style="display: none;">--</a><div style="display:none"><span id="t_3G_3" title="三军 3/葫芦" class="name">3/葫芦@开2骰@开3骰</span><input type="hidden" id="k_3G_3" value="3G"><span id="o_3G_3_1">2.974</span><span id="o_3G_3_2">4.461</span></div><a href="javascript:void(0)" id="o_3G_4" lang="3" style="display: none;">--</a><div style="display:none"><span id="t_3G_4" title="三军 4/金钱" class="name">4/金钱@开2骰@开3骰</span><input type="hidden" id="k_3G_4" value="3G"><span id="o_3G_4_1">2.974</span><span id="o_3G_4_2">4.461</span></div><a href="javascript:void(0)" id="o_3G_5" lang="3" style="display: none;">--</a><div style="display:none"><span id="t_3G_5" title="三军 5/螃蟹" class="name">5/螃蟹@开2骰@开3骰</span><input type="hidden" id="k_3G_5" value="3G"><span id="o_3G_5_1">2.974</span><span id="o_3G_5_2">4.461</span></div><a href="javascript:void(0)" id="o_3G_6" lang="3" style="display: none;">--</a><div style="display:none"><span id="t_3G_6" title="三军 6/鸡" class="name">6/鸡@开2骰@开3骰</span><input type="hidden" id="k_3G_6" value="3G"><span id="o_3G_6_1">2.974</span><span id="o_3G_6_2">4.461</span></div>
</div>
<script>
    $(document).ready( function(){
        $('.yxxpopupresult').removeAttr('style');
    });
</script>
