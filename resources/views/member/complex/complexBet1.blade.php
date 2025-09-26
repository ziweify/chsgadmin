<head>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/static/default/js/dialog.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript" src="/static/default/js/rightpanel.js"></script>
    <script type="text/javascript" src="/static/default/js/complexBet.js"></script>
    <script type="text/javascript">var lotteryid='{{$lottery}}'</script>
</head>
<head>
    <link rel="stylesheet" type="text/css" href="/static/default/css/bet.css?v=0115" />
    <script type="text/javascript">var lotteryid='{{$lottery}}'</script>
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
                    <table id="complexForm" class="complexForm">
                        <thead>
                        <tr>
                            <th id="complex1HeaderGame" class="complex1HeaderGame">位置</</th>
                            <th id="complex1HeaderContent" class="complex1HeaderContent" colspan="9" >玩法选择</th>
                        </tr>
                        </thead>
                        @if($template == 'SSC')
                        <x-complex.ssc></x-complex.ssc>
                        @elseif($template == 'PK10')
                        <x-complex.pk10></x-complex.pk10>
                        @endif
                    </table>
                    <br>
                    <form id="saveForm" name="complexForm1Bottom">
                        <div id="complexForm2">

                            <div class="left">
                                <div>
                                    <span id="planNamePlaceholder" class="planNamePlaceholder">自定义方式名称</span>
                                        <input class="planName" type="text" onkeydown="return (event.keyCode!=13);" id="planName" name="planName"  placeholder="默认“方式+序号”,不超过16中英数符号">
                                </div>


                                <div>
                                    <span id="takeProfitPlaceholder" class="takeProfitPlaceholder">当日止盈金额</span>


                                        <input type="text" id="takeProfit" onkeydown="return (event.keyCode!=13);" class="takeProfit" name="takeProfit" placeholder="可填可不填">

                                </div>

                                <div>
                                    <span id="stopLossPlaceholder" class="stopLossPlaceholder">当日止损金额</span>


                                        <input type="text" id="stopLoss" onkeydown="return (event.keyCode!=13);" class="stopLoss" name="stopLoss" placeholder="可填可不填">

                                </div>

                            </div>
                            <div class="right">
                                <div>
                                    <span id="fbAmountPlaceholder" class="fbAmountPlaceholder">金额模式</span>

    <label><input type="radio" name="amt_mode" value="0" checked="checked"
 onchange="onChangeBetMode(this.value)" />固定投注</label>
    <label><input type="radio" name="amt_mode" value="1"
 onchange="onChangeBetMode(this.value)" />翻倍投注</label>

                                </div>


                                <div>
                                    <span id="complexfbMode" class="complexfbMode" style="display: flex">
                                        <span id="fbModePlaceholder" class="fbModePlaceholder">翻倍方式</span>

    <label><input type="radio" name="fb_mode" value="0" checked="checked"
 onchange="onChangeFBMode(this.value)" />中翻倍</label>
    <label><input type="radio" name="fb_mode" value="1"
 onchange="onChangeFBMode(this.value)" />不中翻倍</label>

                                    </span>
                                </div>

                                <div>
                                    <span id="complexfbbzMode" class="complexfbbzMode" style="display: flex">
                                            <span id="complexfbbzModeHit" class="complexfbbzModeHit" style="display: inline-block;">翻倍<span class="red">不中</span>之后的投注金额</span>
                                            <span id="complexfbbzModeNoHit" class="complexfbbzModeNoHit" style="display: none;">翻倍<span class="red">中</span>之后的投注金额</span>

    <label><input type="radio" name="fbbz_mode" value="0" checked="checked"
  />退回到第一金额</label>
    <label><input type="radio" name="fbbz_mode" value="1"
  />退回上一个金额</label>

                                    </span>
                                </div>

                                <div>
                                    <span id="fbAmountPlaceholder" class="fbAmountPlaceholder"><span class="red">*</span>投注金额</span>
                                    <div class="inputDisclaimer">
                                            <textarea id="amount" class="amount" onkeydown="return (event.keyCode!=13);" name="amount" placeholder="可输入多个金额，并于“英文逗号“隔开。最多输入20个金额，达最后一个时再翻就取最后一个"></textarea>
                                        <span id="fbAmoutDisclaimer" class="fbAmoutDisclaimer">输入的金额不能小于单注最低，最大不能大于注单限额</span>
                                    </div>
                                </div>

                            </div>

                            <div class="formFooter">

                                    <input type="button" id="complex1Save" class="complex1Save" value="确定" onclick="saveComplexBet(lotteryid, null)">

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
            $('#complexfbMode').hide();
            $('#complexfbbzMode').hide();
    });

</script>











































