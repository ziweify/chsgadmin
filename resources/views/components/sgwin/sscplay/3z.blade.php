<ul class="tab">
    <li class="tab_title02">
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=0" @if($index == '' || $index == 0)class="on"@endif>三字前三</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=1" @if($index == 1)class="on"@endif>三字中三</a>
        <a href="load?lottery={{$lottery}}&amp;page={{$page}}&amp;index=2" @if($index == 2)class="on"@endif>三字后三</a>
    </li>
</ul>
<table class="quick_sec_table_fw" id="quick_sec_table_fw">
    <tbody>
    <tr>
        <td class="t">
            范围定位
        </td>
        <td class="c">
            开始
            <input class="fw_b text" maxlength="3">
            ~
            结束
            <input class="fw_e text" maxlength="3">
            <input type="button" value="确定" name="btnRange" class="button btn_red">
        </td>
    </tr>
    </tbody>
</table>
<div class="split_panel">


    <table>
        <tbody>
        <tr class="head">
            <th>种类</th>
            <th>赔率</th>
            <th class="ha">金额</th>
        </tr>
        <tr>
            <th class="G3ZTS{{$tsz}}_000 name" id="t_3ZTS{{$tsz}}_000" title="{{$gameName}} 000"><input type="hidden" id="k_3ZTS{{$tsz}}_000"
                                                                                     value="3Z">000
            </th>

            <td class="G3ZTS{{$tsz}}_000 odds" id="o_3ZTS{{$tsz}}_000">--</td>
            <td class="G3ZTS{{$tsz}}_000 amount ha" id="a_3ZTS{{$tsz}}_000"><input name="3ZTS{{$tsz}}_000" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_001 name" id="t_3ZTS{{$tsz}}_001" title="{{$gameName}} 001"><input type="hidden" id="k_3ZTS{{$tsz}}_001"
                                                                                     value="3Z">001
            </th>

            <td class="G3ZTS{{$tsz}}_001 odds" id="o_3ZTS{{$tsz}}_001">--</td>
            <td class="G3ZTS{{$tsz}}_001 amount ha" id="a_3ZTS{{$tsz}}_001"><input name="3ZTS{{$tsz}}_001" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_002 name" id="t_3ZTS{{$tsz}}_002" title="{{$gameName}} 002"><input type="hidden" id="k_3ZTS{{$tsz}}_002"
                                                                                     value="3Z">002
            </th>

            <td class="G3ZTS{{$tsz}}_002 odds" id="o_3ZTS{{$tsz}}_002">--</td>
            <td class="G3ZTS{{$tsz}}_002 amount ha" id="a_3ZTS{{$tsz}}_002"><input name="3ZTS{{$tsz}}_002" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_003 name" id="t_3ZTS{{$tsz}}_003" title="{{$gameName}} 003"><input type="hidden" id="k_3ZTS{{$tsz}}_003"
                                                                                     value="3Z">003
            </th>

            <td class="G3ZTS{{$tsz}}_003 odds" id="o_3ZTS{{$tsz}}_003">--</td>
            <td class="G3ZTS{{$tsz}}_003 amount ha" id="a_3ZTS{{$tsz}}_003"><input name="3ZTS{{$tsz}}_003" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_004 name" id="t_3ZTS{{$tsz}}_004" title="{{$gameName}} 004"><input type="hidden" id="k_3ZTS{{$tsz}}_004"
                                                                                     value="3Z">004
            </th>

            <td class="G3ZTS{{$tsz}}_004 odds" id="o_3ZTS{{$tsz}}_004">--</td>
            <td class="G3ZTS{{$tsz}}_004 amount ha" id="a_3ZTS{{$tsz}}_004"><input name="3ZTS{{$tsz}}_004" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_005 name" id="t_3ZTS{{$tsz}}_005" title="{{$gameName}} 005"><input type="hidden" id="k_3ZTS{{$tsz}}_005"
                                                                                     value="3Z">005
            </th>

            <td class="G3ZTS{{$tsz}}_005 odds" id="o_3ZTS{{$tsz}}_005">--</td>
            <td class="G3ZTS{{$tsz}}_005 amount ha" id="a_3ZTS{{$tsz}}_005"><input name="3ZTS{{$tsz}}_005" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_006 name" id="t_3ZTS{{$tsz}}_006" title="{{$gameName}} 006"><input type="hidden" id="k_3ZTS{{$tsz}}_006"
                                                                                     value="3Z">006
            </th>

            <td class="G3ZTS{{$tsz}}_006 odds" id="o_3ZTS{{$tsz}}_006">--</td>
            <td class="G3ZTS{{$tsz}}_006 amount ha" id="a_3ZTS{{$tsz}}_006"><input name="3ZTS{{$tsz}}_006" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_007 name" id="t_3ZTS{{$tsz}}_007" title="{{$gameName}} 007"><input type="hidden" id="k_3ZTS{{$tsz}}_007"
                                                                                     value="3Z">007
            </th>

            <td class="G3ZTS{{$tsz}}_007 odds" id="o_3ZTS{{$tsz}}_007">--</td>
            <td class="G3ZTS{{$tsz}}_007 amount ha" id="a_3ZTS{{$tsz}}_007"><input name="3ZTS{{$tsz}}_007" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_008 name" id="t_3ZTS{{$tsz}}_008" title="{{$gameName}} 008"><input type="hidden" id="k_3ZTS{{$tsz}}_008"
                                                                                     value="3Z">008
            </th>

            <td class="G3ZTS{{$tsz}}_008 odds" id="o_3ZTS{{$tsz}}_008">--</td>
            <td class="G3ZTS{{$tsz}}_008 amount ha" id="a_3ZTS{{$tsz}}_008"><input name="3ZTS{{$tsz}}_008" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_009 name" id="t_3ZTS{{$tsz}}_009" title="{{$gameName}} 009"><input type="hidden" id="k_3ZTS{{$tsz}}_009"
                                                                                     value="3Z">009
            </th>

            <td class="G3ZTS{{$tsz}}_009 odds" id="o_3ZTS{{$tsz}}_009">--</td>
            <td class="G3ZTS{{$tsz}}_009 amount ha" id="a_3ZTS{{$tsz}}_009"><input name="3ZTS{{$tsz}}_009" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_011 name" id="t_3ZTS{{$tsz}}_011" title="{{$gameName}} 011"><input type="hidden" id="k_3ZTS{{$tsz}}_011"
                                                                                     value="3Z">011
            </th>

            <td class="G3ZTS{{$tsz}}_011 odds" id="o_3ZTS{{$tsz}}_011">--</td>
            <td class="G3ZTS{{$tsz}}_011 amount ha" id="a_3ZTS{{$tsz}}_011"><input name="3ZTS{{$tsz}}_011" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_012 name" id="t_3ZTS{{$tsz}}_012" title="{{$gameName}} 012"><input type="hidden" id="k_3ZTS{{$tsz}}_012"
                                                                                     value="3Z">012
            </th>

            <td class="G3ZTS{{$tsz}}_012 odds" id="o_3ZTS{{$tsz}}_012">--</td>
            <td class="G3ZTS{{$tsz}}_012 amount ha" id="a_3ZTS{{$tsz}}_012"><input name="3ZTS{{$tsz}}_012" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_013 name" id="t_3ZTS{{$tsz}}_013" title="{{$gameName}} 013"><input type="hidden" id="k_3ZTS{{$tsz}}_013"
                                                                                     value="3Z">013
            </th>

            <td class="G3ZTS{{$tsz}}_013 odds" id="o_3ZTS{{$tsz}}_013">--</td>
            <td class="G3ZTS{{$tsz}}_013 amount ha" id="a_3ZTS{{$tsz}}_013"><input name="3ZTS{{$tsz}}_013" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_014 name" id="t_3ZTS{{$tsz}}_014" title="{{$gameName}} 014"><input type="hidden" id="k_3ZTS{{$tsz}}_014"
                                                                                     value="3Z">014
            </th>

            <td class="G3ZTS{{$tsz}}_014 odds" id="o_3ZTS{{$tsz}}_014">--</td>
            <td class="G3ZTS{{$tsz}}_014 amount ha" id="a_3ZTS{{$tsz}}_014"><input name="3ZTS{{$tsz}}_014" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_015 name" id="t_3ZTS{{$tsz}}_015" title="{{$gameName}} 015"><input type="hidden" id="k_3ZTS{{$tsz}}_015"
                                                                                     value="3Z">015
            </th>

            <td class="G3ZTS{{$tsz}}_015 odds" id="o_3ZTS{{$tsz}}_015">--</td>
            <td class="G3ZTS{{$tsz}}_015 amount ha" id="a_3ZTS{{$tsz}}_015"><input name="3ZTS{{$tsz}}_015" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_016 name" id="t_3ZTS{{$tsz}}_016" title="{{$gameName}} 016"><input type="hidden" id="k_3ZTS{{$tsz}}_016"
                                                                                     value="3Z">016
            </th>

            <td class="G3ZTS{{$tsz}}_016 odds" id="o_3ZTS{{$tsz}}_016">--</td>
            <td class="G3ZTS{{$tsz}}_016 amount ha" id="a_3ZTS{{$tsz}}_016"><input name="3ZTS{{$tsz}}_016" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_017 name" id="t_3ZTS{{$tsz}}_017" title="{{$gameName}} 017"><input type="hidden" id="k_3ZTS{{$tsz}}_017"
                                                                                     value="3Z">017
            </th>

            <td class="G3ZTS{{$tsz}}_017 odds" id="o_3ZTS{{$tsz}}_017">--</td>
            <td class="G3ZTS{{$tsz}}_017 amount ha" id="a_3ZTS{{$tsz}}_017"><input name="3ZTS{{$tsz}}_017" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_018 name" id="t_3ZTS{{$tsz}}_018" title="{{$gameName}} 018"><input type="hidden" id="k_3ZTS{{$tsz}}_018"
                                                                                     value="3Z">018
            </th>

            <td class="G3ZTS{{$tsz}}_018 odds" id="o_3ZTS{{$tsz}}_018">--</td>
            <td class="G3ZTS{{$tsz}}_018 amount ha" id="a_3ZTS{{$tsz}}_018"><input name="3ZTS{{$tsz}}_018" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_019 name" id="t_3ZTS{{$tsz}}_019" title="{{$gameName}} 019"><input type="hidden" id="k_3ZTS{{$tsz}}_019"
                                                                                     value="3Z">019
            </th>

            <td class="G3ZTS{{$tsz}}_019 odds" id="o_3ZTS{{$tsz}}_019">--</td>
            <td class="G3ZTS{{$tsz}}_019 amount ha" id="a_3ZTS{{$tsz}}_019"><input name="3ZTS{{$tsz}}_019" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_022 name" id="t_3ZTS{{$tsz}}_022" title="{{$gameName}} 022"><input type="hidden" id="k_3ZTS{{$tsz}}_022"
                                                                                     value="3Z">022
            </th>

            <td class="G3ZTS{{$tsz}}_022 odds" id="o_3ZTS{{$tsz}}_022">--</td>
            <td class="G3ZTS{{$tsz}}_022 amount ha" id="a_3ZTS{{$tsz}}_022"><input name="3ZTS{{$tsz}}_022" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_023 name" id="t_3ZTS{{$tsz}}_023" title="{{$gameName}} 023"><input type="hidden" id="k_3ZTS{{$tsz}}_023"
                                                                                     value="3Z">023
            </th>

            <td class="G3ZTS{{$tsz}}_023 odds" id="o_3ZTS{{$tsz}}_023">--</td>
            <td class="G3ZTS{{$tsz}}_023 amount ha" id="a_3ZTS{{$tsz}}_023"><input name="3ZTS{{$tsz}}_023" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_024 name" id="t_3ZTS{{$tsz}}_024" title="{{$gameName}} 024"><input type="hidden" id="k_3ZTS{{$tsz}}_024"
                                                                                     value="3Z">024
            </th>

            <td class="G3ZTS{{$tsz}}_024 odds" id="o_3ZTS{{$tsz}}_024">--</td>
            <td class="G3ZTS{{$tsz}}_024 amount ha" id="a_3ZTS{{$tsz}}_024"><input name="3ZTS{{$tsz}}_024" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_025 name" id="t_3ZTS{{$tsz}}_025" title="{{$gameName}} 025"><input type="hidden" id="k_3ZTS{{$tsz}}_025"
                                                                                     value="3Z">025
            </th>

            <td class="G3ZTS{{$tsz}}_025 odds" id="o_3ZTS{{$tsz}}_025">--</td>
            <td class="G3ZTS{{$tsz}}_025 amount ha" id="a_3ZTS{{$tsz}}_025"><input name="3ZTS{{$tsz}}_025" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_026 name" id="t_3ZTS{{$tsz}}_026" title="{{$gameName}} 026"><input type="hidden" id="k_3ZTS{{$tsz}}_026"
                                                                                     value="3Z">026
            </th>

            <td class="G3ZTS{{$tsz}}_026 odds" id="o_3ZTS{{$tsz}}_026">--</td>
            <td class="G3ZTS{{$tsz}}_026 amount ha" id="a_3ZTS{{$tsz}}_026"><input name="3ZTS{{$tsz}}_026" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_027 name" id="t_3ZTS{{$tsz}}_027" title="{{$gameName}} 027"><input type="hidden" id="k_3ZTS{{$tsz}}_027"
                                                                                     value="3Z">027
            </th>

            <td class="G3ZTS{{$tsz}}_027 odds" id="o_3ZTS{{$tsz}}_027">--</td>
            <td class="G3ZTS{{$tsz}}_027 amount ha" id="a_3ZTS{{$tsz}}_027"><input name="3ZTS{{$tsz}}_027" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_028 name" id="t_3ZTS{{$tsz}}_028" title="{{$gameName}} 028"><input type="hidden" id="k_3ZTS{{$tsz}}_028"
                                                                                     value="3Z">028
            </th>

            <td class="G3ZTS{{$tsz}}_028 odds" id="o_3ZTS{{$tsz}}_028">--</td>
            <td class="G3ZTS{{$tsz}}_028 amount ha" id="a_3ZTS{{$tsz}}_028"><input name="3ZTS{{$tsz}}_028" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_029 name" id="t_3ZTS{{$tsz}}_029" title="{{$gameName}} 029"><input type="hidden" id="k_3ZTS{{$tsz}}_029"
                                                                                     value="3Z">029
            </th>

            <td class="G3ZTS{{$tsz}}_029 odds" id="o_3ZTS{{$tsz}}_029">--</td>
            <td class="G3ZTS{{$tsz}}_029 amount ha" id="a_3ZTS{{$tsz}}_029"><input name="3ZTS{{$tsz}}_029" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_033 name" id="t_3ZTS{{$tsz}}_033" title="{{$gameName}} 033"><input type="hidden" id="k_3ZTS{{$tsz}}_033"
                                                                                     value="3Z">033
            </th>

            <td class="G3ZTS{{$tsz}}_033 odds" id="o_3ZTS{{$tsz}}_033">--</td>
            <td class="G3ZTS{{$tsz}}_033 amount ha" id="a_3ZTS{{$tsz}}_033"><input name="3ZTS{{$tsz}}_033" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_034 name" id="t_3ZTS{{$tsz}}_034" title="{{$gameName}} 034"><input type="hidden" id="k_3ZTS{{$tsz}}_034"
                                                                                     value="3Z">034
            </th>

            <td class="G3ZTS{{$tsz}}_034 odds" id="o_3ZTS{{$tsz}}_034">--</td>
            <td class="G3ZTS{{$tsz}}_034 amount ha" id="a_3ZTS{{$tsz}}_034"><input name="3ZTS{{$tsz}}_034" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_035 name" id="t_3ZTS{{$tsz}}_035" title="{{$gameName}} 035"><input type="hidden" id="k_3ZTS{{$tsz}}_035"
                                                                                     value="3Z">035
            </th>

            <td class="G3ZTS{{$tsz}}_035 odds" id="o_3ZTS{{$tsz}}_035">--</td>
            <td class="G3ZTS{{$tsz}}_035 amount ha" id="a_3ZTS{{$tsz}}_035"><input name="3ZTS{{$tsz}}_035" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_036 name" id="t_3ZTS{{$tsz}}_036" title="{{$gameName}} 036"><input type="hidden" id="k_3ZTS{{$tsz}}_036"
                                                                                     value="3Z">036
            </th>

            <td class="G3ZTS{{$tsz}}_036 odds" id="o_3ZTS{{$tsz}}_036">--</td>
            <td class="G3ZTS{{$tsz}}_036 amount ha" id="a_3ZTS{{$tsz}}_036"><input name="3ZTS{{$tsz}}_036" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_037 name" id="t_3ZTS{{$tsz}}_037" title="{{$gameName}} 037"><input type="hidden" id="k_3ZTS{{$tsz}}_037"
                                                                                     value="3Z">037
            </th>

            <td class="G3ZTS{{$tsz}}_037 odds" id="o_3ZTS{{$tsz}}_037">--</td>
            <td class="G3ZTS{{$tsz}}_037 amount ha" id="a_3ZTS{{$tsz}}_037"><input name="3ZTS{{$tsz}}_037" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_038 name" id="t_3ZTS{{$tsz}}_038" title="{{$gameName}} 038"><input type="hidden" id="k_3ZTS{{$tsz}}_038"
                                                                                     value="3Z">038
            </th>

            <td class="G3ZTS{{$tsz}}_038 odds" id="o_3ZTS{{$tsz}}_038">--</td>
            <td class="G3ZTS{{$tsz}}_038 amount ha" id="a_3ZTS{{$tsz}}_038"><input name="3ZTS{{$tsz}}_038" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_039 name" id="t_3ZTS{{$tsz}}_039" title="{{$gameName}} 039"><input type="hidden" id="k_3ZTS{{$tsz}}_039"
                                                                                     value="3Z">039
            </th>

            <td class="G3ZTS{{$tsz}}_039 odds" id="o_3ZTS{{$tsz}}_039">--</td>
            <td class="G3ZTS{{$tsz}}_039 amount ha" id="a_3ZTS{{$tsz}}_039"><input name="3ZTS{{$tsz}}_039" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_044 name" id="t_3ZTS{{$tsz}}_044" title="{{$gameName}} 044"><input type="hidden" id="k_3ZTS{{$tsz}}_044"
                                                                                     value="3Z">044
            </th>

            <td class="G3ZTS{{$tsz}}_044 odds" id="o_3ZTS{{$tsz}}_044">--</td>
            <td class="G3ZTS{{$tsz}}_044 amount ha" id="a_3ZTS{{$tsz}}_044"><input name="3ZTS{{$tsz}}_044" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_045 name" id="t_3ZTS{{$tsz}}_045" title="{{$gameName}} 045"><input type="hidden" id="k_3ZTS{{$tsz}}_045"
                                                                                     value="3Z">045
            </th>

            <td class="G3ZTS{{$tsz}}_045 odds" id="o_3ZTS{{$tsz}}_045">--</td>
            <td class="G3ZTS{{$tsz}}_045 amount ha" id="a_3ZTS{{$tsz}}_045"><input name="3ZTS{{$tsz}}_045" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_046 name" id="t_3ZTS{{$tsz}}_046" title="{{$gameName}} 046"><input type="hidden" id="k_3ZTS{{$tsz}}_046"
                                                                                     value="3Z">046
            </th>

            <td class="G3ZTS{{$tsz}}_046 odds" id="o_3ZTS{{$tsz}}_046">--</td>
            <td class="G3ZTS{{$tsz}}_046 amount ha" id="a_3ZTS{{$tsz}}_046"><input name="3ZTS{{$tsz}}_046" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_047 name" id="t_3ZTS{{$tsz}}_047" title="{{$gameName}} 047"><input type="hidden" id="k_3ZTS{{$tsz}}_047"
                                                                                     value="3Z">047
            </th>

            <td class="G3ZTS{{$tsz}}_047 odds" id="o_3ZTS{{$tsz}}_047">--</td>
            <td class="G3ZTS{{$tsz}}_047 amount ha" id="a_3ZTS{{$tsz}}_047"><input name="3ZTS{{$tsz}}_047" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_048 name" id="t_3ZTS{{$tsz}}_048" title="{{$gameName}} 048"><input type="hidden" id="k_3ZTS{{$tsz}}_048"
                                                                                     value="3Z">048
            </th>

            <td class="G3ZTS{{$tsz}}_048 odds" id="o_3ZTS{{$tsz}}_048">--</td>
            <td class="G3ZTS{{$tsz}}_048 amount ha" id="a_3ZTS{{$tsz}}_048"><input name="3ZTS{{$tsz}}_048" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_049 name" id="t_3ZTS{{$tsz}}_049" title="{{$gameName}} 049"><input type="hidden" id="k_3ZTS{{$tsz}}_049"
                                                                                     value="3Z">049
            </th>

            <td class="G3ZTS{{$tsz}}_049 odds" id="o_3ZTS{{$tsz}}_049">--</td>
            <td class="G3ZTS{{$tsz}}_049 amount ha" id="a_3ZTS{{$tsz}}_049"><input name="3ZTS{{$tsz}}_049" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_055 name" id="t_3ZTS{{$tsz}}_055" title="{{$gameName}} 055"><input type="hidden" id="k_3ZTS{{$tsz}}_055"
                                                                                     value="3Z">055
            </th>

            <td class="G3ZTS{{$tsz}}_055 odds" id="o_3ZTS{{$tsz}}_055">--</td>
            <td class="G3ZTS{{$tsz}}_055 amount ha" id="a_3ZTS{{$tsz}}_055"><input name="3ZTS{{$tsz}}_055" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_056 name" id="t_3ZTS{{$tsz}}_056" title="{{$gameName}} 056"><input type="hidden" id="k_3ZTS{{$tsz}}_056"
                                                                                     value="3Z">056
            </th>

            <td class="G3ZTS{{$tsz}}_056 odds" id="o_3ZTS{{$tsz}}_056">--</td>
            <td class="G3ZTS{{$tsz}}_056 amount ha" id="a_3ZTS{{$tsz}}_056"><input name="3ZTS{{$tsz}}_056" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_057 name" id="t_3ZTS{{$tsz}}_057" title="{{$gameName}} 057"><input type="hidden" id="k_3ZTS{{$tsz}}_057"
                                                                                     value="3Z">057
            </th>

            <td class="G3ZTS{{$tsz}}_057 odds" id="o_3ZTS{{$tsz}}_057">--</td>
            <td class="G3ZTS{{$tsz}}_057 amount ha" id="a_3ZTS{{$tsz}}_057"><input name="3ZTS{{$tsz}}_057" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_058 name" id="t_3ZTS{{$tsz}}_058" title="{{$gameName}} 058"><input type="hidden" id="k_3ZTS{{$tsz}}_058"
                                                                                     value="3Z">058
            </th>

            <td class="G3ZTS{{$tsz}}_058 odds" id="o_3ZTS{{$tsz}}_058">--</td>
            <td class="G3ZTS{{$tsz}}_058 amount ha" id="a_3ZTS{{$tsz}}_058"><input name="3ZTS{{$tsz}}_058" class="ba"></td>
        </tr>
        </tbody>
    </table>


    <table>
        <tbody>
        <tr class="head">
            <th>种类</th>
            <th>赔率</th>
            <th class="ha">金额</th>
        </tr>
        <tr>
            <th class="G3ZTS{{$tsz}}_059 name" id="t_3ZTS{{$tsz}}_059" title="{{$gameName}} 059"><input type="hidden" id="k_3ZTS{{$tsz}}_059"
                                                                                     value="3Z">059
            </th>

            <td class="G3ZTS{{$tsz}}_059 odds" id="o_3ZTS{{$tsz}}_059">--</td>
            <td class="G3ZTS{{$tsz}}_059 amount ha" id="a_3ZTS{{$tsz}}_059"><input name="3ZTS{{$tsz}}_059" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_066 name" id="t_3ZTS{{$tsz}}_066" title="{{$gameName}} 066"><input type="hidden" id="k_3ZTS{{$tsz}}_066"
                                                                                     value="3Z">066
            </th>

            <td class="G3ZTS{{$tsz}}_066 odds" id="o_3ZTS{{$tsz}}_066">--</td>
            <td class="G3ZTS{{$tsz}}_066 amount ha" id="a_3ZTS{{$tsz}}_066"><input name="3ZTS{{$tsz}}_066" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_067 name" id="t_3ZTS{{$tsz}}_067" title="{{$gameName}} 067"><input type="hidden" id="k_3ZTS{{$tsz}}_067"
                                                                                     value="3Z">067
            </th>

            <td class="G3ZTS{{$tsz}}_067 odds" id="o_3ZTS{{$tsz}}_067">--</td>
            <td class="G3ZTS{{$tsz}}_067 amount ha" id="a_3ZTS{{$tsz}}_067"><input name="3ZTS{{$tsz}}_067" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_068 name" id="t_3ZTS{{$tsz}}_068" title="{{$gameName}} 068"><input type="hidden" id="k_3ZTS{{$tsz}}_068"
                                                                                     value="3Z">068
            </th>

            <td class="G3ZTS{{$tsz}}_068 odds" id="o_3ZTS{{$tsz}}_068">--</td>
            <td class="G3ZTS{{$tsz}}_068 amount ha" id="a_3ZTS{{$tsz}}_068"><input name="3ZTS{{$tsz}}_068" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_069 name" id="t_3ZTS{{$tsz}}_069" title="{{$gameName}} 069"><input type="hidden" id="k_3ZTS{{$tsz}}_069"
                                                                                     value="3Z">069
            </th>

            <td class="G3ZTS{{$tsz}}_069 odds" id="o_3ZTS{{$tsz}}_069">--</td>
            <td class="G3ZTS{{$tsz}}_069 amount ha" id="a_3ZTS{{$tsz}}_069"><input name="3ZTS{{$tsz}}_069" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_077 name" id="t_3ZTS{{$tsz}}_077" title="{{$gameName}} 077"><input type="hidden" id="k_3ZTS{{$tsz}}_077"
                                                                                     value="3Z">077
            </th>

            <td class="G3ZTS{{$tsz}}_077 odds" id="o_3ZTS{{$tsz}}_077">--</td>
            <td class="G3ZTS{{$tsz}}_077 amount ha" id="a_3ZTS{{$tsz}}_077"><input name="3ZTS{{$tsz}}_077" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_078 name" id="t_3ZTS{{$tsz}}_078" title="{{$gameName}} 078"><input type="hidden" id="k_3ZTS{{$tsz}}_078"
                                                                                     value="3Z">078
            </th>

            <td class="G3ZTS{{$tsz}}_078 odds" id="o_3ZTS{{$tsz}}_078">--</td>
            <td class="G3ZTS{{$tsz}}_078 amount ha" id="a_3ZTS{{$tsz}}_078"><input name="3ZTS{{$tsz}}_078" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_079 name" id="t_3ZTS{{$tsz}}_079" title="{{$gameName}} 079"><input type="hidden" id="k_3ZTS{{$tsz}}_079"
                                                                                     value="3Z">079
            </th>

            <td class="G3ZTS{{$tsz}}_079 odds" id="o_3ZTS{{$tsz}}_079">--</td>
            <td class="G3ZTS{{$tsz}}_079 amount ha" id="a_3ZTS{{$tsz}}_079"><input name="3ZTS{{$tsz}}_079" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_088 name" id="t_3ZTS{{$tsz}}_088" title="{{$gameName}} 088"><input type="hidden" id="k_3ZTS{{$tsz}}_088"
                                                                                     value="3Z">088
            </th>

            <td class="G3ZTS{{$tsz}}_088 odds" id="o_3ZTS{{$tsz}}_088">--</td>
            <td class="G3ZTS{{$tsz}}_088 amount ha" id="a_3ZTS{{$tsz}}_088"><input name="3ZTS{{$tsz}}_088" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_089 name" id="t_3ZTS{{$tsz}}_089" title="{{$gameName}} 089"><input type="hidden" id="k_3ZTS{{$tsz}}_089"
                                                                                     value="3Z">089
            </th>

            <td class="G3ZTS{{$tsz}}_089 odds" id="o_3ZTS{{$tsz}}_089">--</td>
            <td class="G3ZTS{{$tsz}}_089 amount ha" id="a_3ZTS{{$tsz}}_089"><input name="3ZTS{{$tsz}}_089" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_099 name" id="t_3ZTS{{$tsz}}_099" title="{{$gameName}} 099"><input type="hidden" id="k_3ZTS{{$tsz}}_099"
                                                                                     value="3Z">099
            </th>

            <td class="G3ZTS{{$tsz}}_099 odds" id="o_3ZTS{{$tsz}}_099">--</td>
            <td class="G3ZTS{{$tsz}}_099 amount ha" id="a_3ZTS{{$tsz}}_099"><input name="3ZTS{{$tsz}}_099" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_111 name" id="t_3ZTS{{$tsz}}_111" title="{{$gameName}} 111"><input type="hidden" id="k_3ZTS{{$tsz}}_111"
                                                                                     value="3Z">111
            </th>

            <td class="G3ZTS{{$tsz}}_111 odds" id="o_3ZTS{{$tsz}}_111">--</td>
            <td class="G3ZTS{{$tsz}}_111 amount ha" id="a_3ZTS{{$tsz}}_111"><input name="3ZTS{{$tsz}}_111" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_112 name" id="t_3ZTS{{$tsz}}_112" title="{{$gameName}} 112"><input type="hidden" id="k_3ZTS{{$tsz}}_112"
                                                                                     value="3Z">112
            </th>

            <td class="G3ZTS{{$tsz}}_112 odds" id="o_3ZTS{{$tsz}}_112">--</td>
            <td class="G3ZTS{{$tsz}}_112 amount ha" id="a_3ZTS{{$tsz}}_112"><input name="3ZTS{{$tsz}}_112" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_113 name" id="t_3ZTS{{$tsz}}_113" title="{{$gameName}} 113"><input type="hidden" id="k_3ZTS{{$tsz}}_113"
                                                                                     value="3Z">113
            </th>

            <td class="G3ZTS{{$tsz}}_113 odds" id="o_3ZTS{{$tsz}}_113">--</td>
            <td class="G3ZTS{{$tsz}}_113 amount ha" id="a_3ZTS{{$tsz}}_113"><input name="3ZTS{{$tsz}}_113" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_114 name" id="t_3ZTS{{$tsz}}_114" title="{{$gameName}} 114"><input type="hidden" id="k_3ZTS{{$tsz}}_114"
                                                                                     value="3Z">114
            </th>

            <td class="G3ZTS{{$tsz}}_114 odds" id="o_3ZTS{{$tsz}}_114">--</td>
            <td class="G3ZTS{{$tsz}}_114 amount ha" id="a_3ZTS{{$tsz}}_114"><input name="3ZTS{{$tsz}}_114" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_115 name" id="t_3ZTS{{$tsz}}_115" title="{{$gameName}} 115"><input type="hidden" id="k_3ZTS{{$tsz}}_115"
                                                                                     value="3Z">115
            </th>

            <td class="G3ZTS{{$tsz}}_115 odds" id="o_3ZTS{{$tsz}}_115">--</td>
            <td class="G3ZTS{{$tsz}}_115 amount ha" id="a_3ZTS{{$tsz}}_115"><input name="3ZTS{{$tsz}}_115" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_116 name" id="t_3ZTS{{$tsz}}_116" title="{{$gameName}} 116"><input type="hidden" id="k_3ZTS{{$tsz}}_116"
                                                                                     value="3Z">116
            </th>

            <td class="G3ZTS{{$tsz}}_116 odds" id="o_3ZTS{{$tsz}}_116">--</td>
            <td class="G3ZTS{{$tsz}}_116 amount ha" id="a_3ZTS{{$tsz}}_116"><input name="3ZTS{{$tsz}}_116" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_117 name" id="t_3ZTS{{$tsz}}_117" title="{{$gameName}} 117"><input type="hidden" id="k_3ZTS{{$tsz}}_117"
                                                                                     value="3Z">117
            </th>

            <td class="G3ZTS{{$tsz}}_117 odds" id="o_3ZTS{{$tsz}}_117">--</td>
            <td class="G3ZTS{{$tsz}}_117 amount ha" id="a_3ZTS{{$tsz}}_117"><input name="3ZTS{{$tsz}}_117" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_118 name" id="t_3ZTS{{$tsz}}_118" title="{{$gameName}} 118"><input type="hidden" id="k_3ZTS{{$tsz}}_118"
                                                                                     value="3Z">118
            </th>

            <td class="G3ZTS{{$tsz}}_118 odds" id="o_3ZTS{{$tsz}}_118">--</td>
            <td class="G3ZTS{{$tsz}}_118 amount ha" id="a_3ZTS{{$tsz}}_118"><input name="3ZTS{{$tsz}}_118" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_119 name" id="t_3ZTS{{$tsz}}_119" title="{{$gameName}} 119"><input type="hidden" id="k_3ZTS{{$tsz}}_119"
                                                                                     value="3Z">119
            </th>

            <td class="G3ZTS{{$tsz}}_119 odds" id="o_3ZTS{{$tsz}}_119">--</td>
            <td class="G3ZTS{{$tsz}}_119 amount ha" id="a_3ZTS{{$tsz}}_119"><input name="3ZTS{{$tsz}}_119" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_122 name" id="t_3ZTS{{$tsz}}_122" title="{{$gameName}} 122"><input type="hidden" id="k_3ZTS{{$tsz}}_122"
                                                                                     value="3Z">122
            </th>

            <td class="G3ZTS{{$tsz}}_122 odds" id="o_3ZTS{{$tsz}}_122">--</td>
            <td class="G3ZTS{{$tsz}}_122 amount ha" id="a_3ZTS{{$tsz}}_122"><input name="3ZTS{{$tsz}}_122" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_123 name" id="t_3ZTS{{$tsz}}_123" title="{{$gameName}} 123"><input type="hidden" id="k_3ZTS{{$tsz}}_123"
                                                                                     value="3Z">123
            </th>

            <td class="G3ZTS{{$tsz}}_123 odds" id="o_3ZTS{{$tsz}}_123">--</td>
            <td class="G3ZTS{{$tsz}}_123 amount ha" id="a_3ZTS{{$tsz}}_123"><input name="3ZTS{{$tsz}}_123" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_124 name" id="t_3ZTS{{$tsz}}_124" title="{{$gameName}} 124"><input type="hidden" id="k_3ZTS{{$tsz}}_124"
                                                                                     value="3Z">124
            </th>

            <td class="G3ZTS{{$tsz}}_124 odds" id="o_3ZTS{{$tsz}}_124">--</td>
            <td class="G3ZTS{{$tsz}}_124 amount ha" id="a_3ZTS{{$tsz}}_124"><input name="3ZTS{{$tsz}}_124" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_125 name" id="t_3ZTS{{$tsz}}_125" title="{{$gameName}} 125"><input type="hidden" id="k_3ZTS{{$tsz}}_125"
                                                                                     value="3Z">125
            </th>

            <td class="G3ZTS{{$tsz}}_125 odds" id="o_3ZTS{{$tsz}}_125">--</td>
            <td class="G3ZTS{{$tsz}}_125 amount ha" id="a_3ZTS{{$tsz}}_125"><input name="3ZTS{{$tsz}}_125" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_126 name" id="t_3ZTS{{$tsz}}_126" title="{{$gameName}} 126"><input type="hidden" id="k_3ZTS{{$tsz}}_126"
                                                                                     value="3Z">126
            </th>

            <td class="G3ZTS{{$tsz}}_126 odds" id="o_3ZTS{{$tsz}}_126">--</td>
            <td class="G3ZTS{{$tsz}}_126 amount ha" id="a_3ZTS{{$tsz}}_126"><input name="3ZTS{{$tsz}}_126" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_127 name" id="t_3ZTS{{$tsz}}_127" title="{{$gameName}} 127"><input type="hidden" id="k_3ZTS{{$tsz}}_127"
                                                                                     value="3Z">127
            </th>

            <td class="G3ZTS{{$tsz}}_127 odds" id="o_3ZTS{{$tsz}}_127">--</td>
            <td class="G3ZTS{{$tsz}}_127 amount ha" id="a_3ZTS{{$tsz}}_127"><input name="3ZTS{{$tsz}}_127" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_128 name" id="t_3ZTS{{$tsz}}_128" title="{{$gameName}} 128"><input type="hidden" id="k_3ZTS{{$tsz}}_128"
                                                                                     value="3Z">128
            </th>

            <td class="G3ZTS{{$tsz}}_128 odds" id="o_3ZTS{{$tsz}}_128">--</td>
            <td class="G3ZTS{{$tsz}}_128 amount ha" id="a_3ZTS{{$tsz}}_128"><input name="3ZTS{{$tsz}}_128" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_129 name" id="t_3ZTS{{$tsz}}_129" title="{{$gameName}} 129"><input type="hidden" id="k_3ZTS{{$tsz}}_129"
                                                                                     value="3Z">129
            </th>

            <td class="G3ZTS{{$tsz}}_129 odds" id="o_3ZTS{{$tsz}}_129">--</td>
            <td class="G3ZTS{{$tsz}}_129 amount ha" id="a_3ZTS{{$tsz}}_129"><input name="3ZTS{{$tsz}}_129" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_133 name" id="t_3ZTS{{$tsz}}_133" title="{{$gameName}} 133"><input type="hidden" id="k_3ZTS{{$tsz}}_133"
                                                                                     value="3Z">133
            </th>

            <td class="G3ZTS{{$tsz}}_133 odds" id="o_3ZTS{{$tsz}}_133">--</td>
            <td class="G3ZTS{{$tsz}}_133 amount ha" id="a_3ZTS{{$tsz}}_133"><input name="3ZTS{{$tsz}}_133" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_134 name" id="t_3ZTS{{$tsz}}_134" title="{{$gameName}} 134"><input type="hidden" id="k_3ZTS{{$tsz}}_134"
                                                                                     value="3Z">134
            </th>

            <td class="G3ZTS{{$tsz}}_134 odds" id="o_3ZTS{{$tsz}}_134">--</td>
            <td class="G3ZTS{{$tsz}}_134 amount ha" id="a_3ZTS{{$tsz}}_134"><input name="3ZTS{{$tsz}}_134" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_135 name" id="t_3ZTS{{$tsz}}_135" title="{{$gameName}} 135"><input type="hidden" id="k_3ZTS{{$tsz}}_135"
                                                                                     value="3Z">135
            </th>

            <td class="G3ZTS{{$tsz}}_135 odds" id="o_3ZTS{{$tsz}}_135">--</td>
            <td class="G3ZTS{{$tsz}}_135 amount ha" id="a_3ZTS{{$tsz}}_135"><input name="3ZTS{{$tsz}}_135" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_136 name" id="t_3ZTS{{$tsz}}_136" title="{{$gameName}} 136"><input type="hidden" id="k_3ZTS{{$tsz}}_136"
                                                                                     value="3Z">136
            </th>

            <td class="G3ZTS{{$tsz}}_136 odds" id="o_3ZTS{{$tsz}}_136">--</td>
            <td class="G3ZTS{{$tsz}}_136 amount ha" id="a_3ZTS{{$tsz}}_136"><input name="3ZTS{{$tsz}}_136" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_137 name" id="t_3ZTS{{$tsz}}_137" title="{{$gameName}} 137"><input type="hidden" id="k_3ZTS{{$tsz}}_137"
                                                                                     value="3Z">137
            </th>

            <td class="G3ZTS{{$tsz}}_137 odds" id="o_3ZTS{{$tsz}}_137">--</td>
            <td class="G3ZTS{{$tsz}}_137 amount ha" id="a_3ZTS{{$tsz}}_137"><input name="3ZTS{{$tsz}}_137" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_138 name" id="t_3ZTS{{$tsz}}_138" title="{{$gameName}} 138"><input type="hidden" id="k_3ZTS{{$tsz}}_138"
                                                                                     value="3Z">138
            </th>

            <td class="G3ZTS{{$tsz}}_138 odds" id="o_3ZTS{{$tsz}}_138">--</td>
            <td class="G3ZTS{{$tsz}}_138 amount ha" id="a_3ZTS{{$tsz}}_138"><input name="3ZTS{{$tsz}}_138" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_139 name" id="t_3ZTS{{$tsz}}_139" title="{{$gameName}} 139"><input type="hidden" id="k_3ZTS{{$tsz}}_139"
                                                                                     value="3Z">139
            </th>

            <td class="G3ZTS{{$tsz}}_139 odds" id="o_3ZTS{{$tsz}}_139">--</td>
            <td class="G3ZTS{{$tsz}}_139 amount ha" id="a_3ZTS{{$tsz}}_139"><input name="3ZTS{{$tsz}}_139" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_144 name" id="t_3ZTS{{$tsz}}_144" title="{{$gameName}} 144"><input type="hidden" id="k_3ZTS{{$tsz}}_144"
                                                                                     value="3Z">144
            </th>

            <td class="G3ZTS{{$tsz}}_144 odds" id="o_3ZTS{{$tsz}}_144">--</td>
            <td class="G3ZTS{{$tsz}}_144 amount ha" id="a_3ZTS{{$tsz}}_144"><input name="3ZTS{{$tsz}}_144" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_145 name" id="t_3ZTS{{$tsz}}_145" title="{{$gameName}} 145"><input type="hidden" id="k_3ZTS{{$tsz}}_145"
                                                                                     value="3Z">145
            </th>

            <td class="G3ZTS{{$tsz}}_145 odds" id="o_3ZTS{{$tsz}}_145">--</td>
            <td class="G3ZTS{{$tsz}}_145 amount ha" id="a_3ZTS{{$tsz}}_145"><input name="3ZTS{{$tsz}}_145" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_146 name" id="t_3ZTS{{$tsz}}_146" title="{{$gameName}} 146"><input type="hidden" id="k_3ZTS{{$tsz}}_146"
                                                                                     value="3Z">146
            </th>

            <td class="G3ZTS{{$tsz}}_146 odds" id="o_3ZTS{{$tsz}}_146">--</td>
            <td class="G3ZTS{{$tsz}}_146 amount ha" id="a_3ZTS{{$tsz}}_146"><input name="3ZTS{{$tsz}}_146" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_147 name" id="t_3ZTS{{$tsz}}_147" title="{{$gameName}} 147"><input type="hidden" id="k_3ZTS{{$tsz}}_147"
                                                                                     value="3Z">147
            </th>

            <td class="G3ZTS{{$tsz}}_147 odds" id="o_3ZTS{{$tsz}}_147">--</td>
            <td class="G3ZTS{{$tsz}}_147 amount ha" id="a_3ZTS{{$tsz}}_147"><input name="3ZTS{{$tsz}}_147" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_148 name" id="t_3ZTS{{$tsz}}_148" title="{{$gameName}} 148"><input type="hidden" id="k_3ZTS{{$tsz}}_148"
                                                                                     value="3Z">148
            </th>

            <td class="G3ZTS{{$tsz}}_148 odds" id="o_3ZTS{{$tsz}}_148">--</td>
            <td class="G3ZTS{{$tsz}}_148 amount ha" id="a_3ZTS{{$tsz}}_148"><input name="3ZTS{{$tsz}}_148" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_149 name" id="t_3ZTS{{$tsz}}_149" title="{{$gameName}} 149"><input type="hidden" id="k_3ZTS{{$tsz}}_149"
                                                                                     value="3Z">149
            </th>

            <td class="G3ZTS{{$tsz}}_149 odds" id="o_3ZTS{{$tsz}}_149">--</td>
            <td class="G3ZTS{{$tsz}}_149 amount ha" id="a_3ZTS{{$tsz}}_149"><input name="3ZTS{{$tsz}}_149" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_155 name" id="t_3ZTS{{$tsz}}_155" title="{{$gameName}} 155"><input type="hidden" id="k_3ZTS{{$tsz}}_155"
                                                                                     value="3Z">155
            </th>

            <td class="G3ZTS{{$tsz}}_155 odds" id="o_3ZTS{{$tsz}}_155">--</td>
            <td class="G3ZTS{{$tsz}}_155 amount ha" id="a_3ZTS{{$tsz}}_155"><input name="3ZTS{{$tsz}}_155" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_156 name" id="t_3ZTS{{$tsz}}_156" title="{{$gameName}} 156"><input type="hidden" id="k_3ZTS{{$tsz}}_156"
                                                                                     value="3Z">156
            </th>

            <td class="G3ZTS{{$tsz}}_156 odds" id="o_3ZTS{{$tsz}}_156">--</td>
            <td class="G3ZTS{{$tsz}}_156 amount ha" id="a_3ZTS{{$tsz}}_156"><input name="3ZTS{{$tsz}}_156" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_157 name" id="t_3ZTS{{$tsz}}_157" title="{{$gameName}} 157"><input type="hidden" id="k_3ZTS{{$tsz}}_157"
                                                                                     value="3Z">157
            </th>

            <td class="G3ZTS{{$tsz}}_157 odds" id="o_3ZTS{{$tsz}}_157">--</td>
            <td class="G3ZTS{{$tsz}}_157 amount ha" id="a_3ZTS{{$tsz}}_157"><input name="3ZTS{{$tsz}}_157" class="ba"></td>
        </tr>
        </tbody>
    </table>


    <table>
        <tbody>
        <tr class="head">
            <th>种类</th>
            <th>赔率</th>
            <th class="ha">金额</th>
        </tr>
        <tr>
            <th class="G3ZTS{{$tsz}}_158 name" id="t_3ZTS{{$tsz}}_158" title="{{$gameName}} 158"><input type="hidden" id="k_3ZTS{{$tsz}}_158"
                                                                                     value="3Z">158
            </th>

            <td class="G3ZTS{{$tsz}}_158 odds" id="o_3ZTS{{$tsz}}_158">--</td>
            <td class="G3ZTS{{$tsz}}_158 amount ha" id="a_3ZTS{{$tsz}}_158"><input name="3ZTS{{$tsz}}_158" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_159 name" id="t_3ZTS{{$tsz}}_159" title="{{$gameName}} 159"><input type="hidden" id="k_3ZTS{{$tsz}}_159"
                                                                                     value="3Z">159
            </th>

            <td class="G3ZTS{{$tsz}}_159 odds" id="o_3ZTS{{$tsz}}_159">--</td>
            <td class="G3ZTS{{$tsz}}_159 amount ha" id="a_3ZTS{{$tsz}}_159"><input name="3ZTS{{$tsz}}_159" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_166 name" id="t_3ZTS{{$tsz}}_166" title="{{$gameName}} 166"><input type="hidden" id="k_3ZTS{{$tsz}}_166"
                                                                                     value="3Z">166
            </th>

            <td class="G3ZTS{{$tsz}}_166 odds" id="o_3ZTS{{$tsz}}_166">--</td>
            <td class="G3ZTS{{$tsz}}_166 amount ha" id="a_3ZTS{{$tsz}}_166"><input name="3ZTS{{$tsz}}_166" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_167 name" id="t_3ZTS{{$tsz}}_167" title="{{$gameName}} 167"><input type="hidden" id="k_3ZTS{{$tsz}}_167"
                                                                                     value="3Z">167
            </th>

            <td class="G3ZTS{{$tsz}}_167 odds" id="o_3ZTS{{$tsz}}_167">--</td>
            <td class="G3ZTS{{$tsz}}_167 amount ha" id="a_3ZTS{{$tsz}}_167"><input name="3ZTS{{$tsz}}_167" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_168 name" id="t_3ZTS{{$tsz}}_168" title="{{$gameName}} 168"><input type="hidden" id="k_3ZTS{{$tsz}}_168"
                                                                                     value="3Z">168
            </th>

            <td class="G3ZTS{{$tsz}}_168 odds" id="o_3ZTS{{$tsz}}_168">--</td>
            <td class="G3ZTS{{$tsz}}_168 amount ha" id="a_3ZTS{{$tsz}}_168"><input name="3ZTS{{$tsz}}_168" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_169 name" id="t_3ZTS{{$tsz}}_169" title="{{$gameName}} 169"><input type="hidden" id="k_3ZTS{{$tsz}}_169"
                                                                                     value="3Z">169
            </th>

            <td class="G3ZTS{{$tsz}}_169 odds" id="o_3ZTS{{$tsz}}_169">--</td>
            <td class="G3ZTS{{$tsz}}_169 amount ha" id="a_3ZTS{{$tsz}}_169"><input name="3ZTS{{$tsz}}_169" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_177 name" id="t_3ZTS{{$tsz}}_177" title="{{$gameName}} 177"><input type="hidden" id="k_3ZTS{{$tsz}}_177"
                                                                                     value="3Z">177
            </th>

            <td class="G3ZTS{{$tsz}}_177 odds" id="o_3ZTS{{$tsz}}_177">--</td>
            <td class="G3ZTS{{$tsz}}_177 amount ha" id="a_3ZTS{{$tsz}}_177"><input name="3ZTS{{$tsz}}_177" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_178 name" id="t_3ZTS{{$tsz}}_178" title="{{$gameName}} 178"><input type="hidden" id="k_3ZTS{{$tsz}}_178"
                                                                                     value="3Z">178
            </th>

            <td class="G3ZTS{{$tsz}}_178 odds" id="o_3ZTS{{$tsz}}_178">--</td>
            <td class="G3ZTS{{$tsz}}_178 amount ha" id="a_3ZTS{{$tsz}}_178"><input name="3ZTS{{$tsz}}_178" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_179 name" id="t_3ZTS{{$tsz}}_179" title="{{$gameName}} 179"><input type="hidden" id="k_3ZTS{{$tsz}}_179"
                                                                                     value="3Z">179
            </th>

            <td class="G3ZTS{{$tsz}}_179 odds" id="o_3ZTS{{$tsz}}_179">--</td>
            <td class="G3ZTS{{$tsz}}_179 amount ha" id="a_3ZTS{{$tsz}}_179"><input name="3ZTS{{$tsz}}_179" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_188 name" id="t_3ZTS{{$tsz}}_188" title="{{$gameName}} 188"><input type="hidden" id="k_3ZTS{{$tsz}}_188"
                                                                                     value="3Z">188
            </th>

            <td class="G3ZTS{{$tsz}}_188 odds" id="o_3ZTS{{$tsz}}_188">--</td>
            <td class="G3ZTS{{$tsz}}_188 amount ha" id="a_3ZTS{{$tsz}}_188"><input name="3ZTS{{$tsz}}_188" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_189 name" id="t_3ZTS{{$tsz}}_189" title="{{$gameName}} 189"><input type="hidden" id="k_3ZTS{{$tsz}}_189"
                                                                                     value="3Z">189
            </th>

            <td class="G3ZTS{{$tsz}}_189 odds" id="o_3ZTS{{$tsz}}_189">--</td>
            <td class="G3ZTS{{$tsz}}_189 amount ha" id="a_3ZTS{{$tsz}}_189"><input name="3ZTS{{$tsz}}_189" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_199 name" id="t_3ZTS{{$tsz}}_199" title="{{$gameName}} 199"><input type="hidden" id="k_3ZTS{{$tsz}}_199"
                                                                                     value="3Z">199
            </th>

            <td class="G3ZTS{{$tsz}}_199 odds" id="o_3ZTS{{$tsz}}_199">--</td>
            <td class="G3ZTS{{$tsz}}_199 amount ha" id="a_3ZTS{{$tsz}}_199"><input name="3ZTS{{$tsz}}_199" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_222 name" id="t_3ZTS{{$tsz}}_222" title="{{$gameName}} 222"><input type="hidden" id="k_3ZTS{{$tsz}}_222"
                                                                                     value="3Z">222
            </th>

            <td class="G3ZTS{{$tsz}}_222 odds" id="o_3ZTS{{$tsz}}_222">--</td>
            <td class="G3ZTS{{$tsz}}_222 amount ha" id="a_3ZTS{{$tsz}}_222"><input name="3ZTS{{$tsz}}_222" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_223 name" id="t_3ZTS{{$tsz}}_223" title="{{$gameName}} 223"><input type="hidden" id="k_3ZTS{{$tsz}}_223"
                                                                                     value="3Z">223
            </th>

            <td class="G3ZTS{{$tsz}}_223 odds" id="o_3ZTS{{$tsz}}_223">--</td>
            <td class="G3ZTS{{$tsz}}_223 amount ha" id="a_3ZTS{{$tsz}}_223"><input name="3ZTS{{$tsz}}_223" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_224 name" id="t_3ZTS{{$tsz}}_224" title="{{$gameName}} 224"><input type="hidden" id="k_3ZTS{{$tsz}}_224"
                                                                                     value="3Z">224
            </th>

            <td class="G3ZTS{{$tsz}}_224 odds" id="o_3ZTS{{$tsz}}_224">--</td>
            <td class="G3ZTS{{$tsz}}_224 amount ha" id="a_3ZTS{{$tsz}}_224"><input name="3ZTS{{$tsz}}_224" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_225 name" id="t_3ZTS{{$tsz}}_225" title="{{$gameName}} 225"><input type="hidden" id="k_3ZTS{{$tsz}}_225"
                                                                                     value="3Z">225
            </th>

            <td class="G3ZTS{{$tsz}}_225 odds" id="o_3ZTS{{$tsz}}_225">--</td>
            <td class="G3ZTS{{$tsz}}_225 amount ha" id="a_3ZTS{{$tsz}}_225"><input name="3ZTS{{$tsz}}_225" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_226 name" id="t_3ZTS{{$tsz}}_226" title="{{$gameName}} 226"><input type="hidden" id="k_3ZTS{{$tsz}}_226"
                                                                                     value="3Z">226
            </th>

            <td class="G3ZTS{{$tsz}}_226 odds" id="o_3ZTS{{$tsz}}_226">--</td>
            <td class="G3ZTS{{$tsz}}_226 amount ha" id="a_3ZTS{{$tsz}}_226"><input name="3ZTS{{$tsz}}_226" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_227 name" id="t_3ZTS{{$tsz}}_227" title="{{$gameName}} 227"><input type="hidden" id="k_3ZTS{{$tsz}}_227"
                                                                                     value="3Z">227
            </th>

            <td class="G3ZTS{{$tsz}}_227 odds" id="o_3ZTS{{$tsz}}_227">--</td>
            <td class="G3ZTS{{$tsz}}_227 amount ha" id="a_3ZTS{{$tsz}}_227"><input name="3ZTS{{$tsz}}_227" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_228 name" id="t_3ZTS{{$tsz}}_228" title="{{$gameName}} 228"><input type="hidden" id="k_3ZTS{{$tsz}}_228"
                                                                                     value="3Z">228
            </th>

            <td class="G3ZTS{{$tsz}}_228 odds" id="o_3ZTS{{$tsz}}_228">--</td>
            <td class="G3ZTS{{$tsz}}_228 amount ha" id="a_3ZTS{{$tsz}}_228"><input name="3ZTS{{$tsz}}_228" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_229 name" id="t_3ZTS{{$tsz}}_229" title="{{$gameName}} 229"><input type="hidden" id="k_3ZTS{{$tsz}}_229"
                                                                                     value="3Z">229
            </th>

            <td class="G3ZTS{{$tsz}}_229 odds" id="o_3ZTS{{$tsz}}_229">--</td>
            <td class="G3ZTS{{$tsz}}_229 amount ha" id="a_3ZTS{{$tsz}}_229"><input name="3ZTS{{$tsz}}_229" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_233 name" id="t_3ZTS{{$tsz}}_233" title="{{$gameName}} 233"><input type="hidden" id="k_3ZTS{{$tsz}}_233"
                                                                                     value="3Z">233
            </th>

            <td class="G3ZTS{{$tsz}}_233 odds" id="o_3ZTS{{$tsz}}_233">--</td>
            <td class="G3ZTS{{$tsz}}_233 amount ha" id="a_3ZTS{{$tsz}}_233"><input name="3ZTS{{$tsz}}_233" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_234 name" id="t_3ZTS{{$tsz}}_234" title="{{$gameName}} 234"><input type="hidden" id="k_3ZTS{{$tsz}}_234"
                                                                                     value="3Z">234
            </th>

            <td class="G3ZTS{{$tsz}}_234 odds" id="o_3ZTS{{$tsz}}_234">--</td>
            <td class="G3ZTS{{$tsz}}_234 amount ha" id="a_3ZTS{{$tsz}}_234"><input name="3ZTS{{$tsz}}_234" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_235 name" id="t_3ZTS{{$tsz}}_235" title="{{$gameName}} 235"><input type="hidden" id="k_3ZTS{{$tsz}}_235"
                                                                                     value="3Z">235
            </th>

            <td class="G3ZTS{{$tsz}}_235 odds" id="o_3ZTS{{$tsz}}_235">--</td>
            <td class="G3ZTS{{$tsz}}_235 amount ha" id="a_3ZTS{{$tsz}}_235"><input name="3ZTS{{$tsz}}_235" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_236 name" id="t_3ZTS{{$tsz}}_236" title="{{$gameName}} 236"><input type="hidden" id="k_3ZTS{{$tsz}}_236"
                                                                                     value="3Z">236
            </th>

            <td class="G3ZTS{{$tsz}}_236 odds" id="o_3ZTS{{$tsz}}_236">--</td>
            <td class="G3ZTS{{$tsz}}_236 amount ha" id="a_3ZTS{{$tsz}}_236"><input name="3ZTS{{$tsz}}_236" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_237 name" id="t_3ZTS{{$tsz}}_237" title="{{$gameName}} 237"><input type="hidden" id="k_3ZTS{{$tsz}}_237"
                                                                                     value="3Z">237
            </th>

            <td class="G3ZTS{{$tsz}}_237 odds" id="o_3ZTS{{$tsz}}_237">--</td>
            <td class="G3ZTS{{$tsz}}_237 amount ha" id="a_3ZTS{{$tsz}}_237"><input name="3ZTS{{$tsz}}_237" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_238 name" id="t_3ZTS{{$tsz}}_238" title="{{$gameName}} 238"><input type="hidden" id="k_3ZTS{{$tsz}}_238"
                                                                                     value="3Z">238
            </th>

            <td class="G3ZTS{{$tsz}}_238 odds" id="o_3ZTS{{$tsz}}_238">--</td>
            <td class="G3ZTS{{$tsz}}_238 amount ha" id="a_3ZTS{{$tsz}}_238"><input name="3ZTS{{$tsz}}_238" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_239 name" id="t_3ZTS{{$tsz}}_239" title="{{$gameName}} 239"><input type="hidden" id="k_3ZTS{{$tsz}}_239"
                                                                                     value="3Z">239
            </th>

            <td class="G3ZTS{{$tsz}}_239 odds" id="o_3ZTS{{$tsz}}_239">--</td>
            <td class="G3ZTS{{$tsz}}_239 amount ha" id="a_3ZTS{{$tsz}}_239"><input name="3ZTS{{$tsz}}_239" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_244 name" id="t_3ZTS{{$tsz}}_244" title="{{$gameName}} 244"><input type="hidden" id="k_3ZTS{{$tsz}}_244"
                                                                                     value="3Z">244
            </th>

            <td class="G3ZTS{{$tsz}}_244 odds" id="o_3ZTS{{$tsz}}_244">--</td>
            <td class="G3ZTS{{$tsz}}_244 amount ha" id="a_3ZTS{{$tsz}}_244"><input name="3ZTS{{$tsz}}_244" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_245 name" id="t_3ZTS{{$tsz}}_245" title="{{$gameName}} 245"><input type="hidden" id="k_3ZTS{{$tsz}}_245"
                                                                                     value="3Z">245
            </th>

            <td class="G3ZTS{{$tsz}}_245 odds" id="o_3ZTS{{$tsz}}_245">--</td>
            <td class="G3ZTS{{$tsz}}_245 amount ha" id="a_3ZTS{{$tsz}}_245"><input name="3ZTS{{$tsz}}_245" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_246 name" id="t_3ZTS{{$tsz}}_246" title="{{$gameName}} 246"><input type="hidden" id="k_3ZTS{{$tsz}}_246"
                                                                                     value="3Z">246
            </th>

            <td class="G3ZTS{{$tsz}}_246 odds" id="o_3ZTS{{$tsz}}_246">--</td>
            <td class="G3ZTS{{$tsz}}_246 amount ha" id="a_3ZTS{{$tsz}}_246"><input name="3ZTS{{$tsz}}_246" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_247 name" id="t_3ZTS{{$tsz}}_247" title="{{$gameName}} 247"><input type="hidden" id="k_3ZTS{{$tsz}}_247"
                                                                                     value="3Z">247
            </th>

            <td class="G3ZTS{{$tsz}}_247 odds" id="o_3ZTS{{$tsz}}_247">--</td>
            <td class="G3ZTS{{$tsz}}_247 amount ha" id="a_3ZTS{{$tsz}}_247"><input name="3ZTS{{$tsz}}_247" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_248 name" id="t_3ZTS{{$tsz}}_248" title="{{$gameName}} 248"><input type="hidden" id="k_3ZTS{{$tsz}}_248"
                                                                                     value="3Z">248
            </th>

            <td class="G3ZTS{{$tsz}}_248 odds" id="o_3ZTS{{$tsz}}_248">--</td>
            <td class="G3ZTS{{$tsz}}_248 amount ha" id="a_3ZTS{{$tsz}}_248"><input name="3ZTS{{$tsz}}_248" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_249 name" id="t_3ZTS{{$tsz}}_249" title="{{$gameName}} 249"><input type="hidden" id="k_3ZTS{{$tsz}}_249"
                                                                                     value="3Z">249
            </th>

            <td class="G3ZTS{{$tsz}}_249 odds" id="o_3ZTS{{$tsz}}_249">--</td>
            <td class="G3ZTS{{$tsz}}_249 amount ha" id="a_3ZTS{{$tsz}}_249"><input name="3ZTS{{$tsz}}_249" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_255 name" id="t_3ZTS{{$tsz}}_255" title="{{$gameName}} 255"><input type="hidden" id="k_3ZTS{{$tsz}}_255"
                                                                                     value="3Z">255
            </th>

            <td class="G3ZTS{{$tsz}}_255 odds" id="o_3ZTS{{$tsz}}_255">--</td>
            <td class="G3ZTS{{$tsz}}_255 amount ha" id="a_3ZTS{{$tsz}}_255"><input name="3ZTS{{$tsz}}_255" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_256 name" id="t_3ZTS{{$tsz}}_256" title="{{$gameName}} 256"><input type="hidden" id="k_3ZTS{{$tsz}}_256"
                                                                                     value="3Z">256
            </th>

            <td class="G3ZTS{{$tsz}}_256 odds" id="o_3ZTS{{$tsz}}_256">--</td>
            <td class="G3ZTS{{$tsz}}_256 amount ha" id="a_3ZTS{{$tsz}}_256"><input name="3ZTS{{$tsz}}_256" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_257 name" id="t_3ZTS{{$tsz}}_257" title="{{$gameName}} 257"><input type="hidden" id="k_3ZTS{{$tsz}}_257"
                                                                                     value="3Z">257
            </th>

            <td class="G3ZTS{{$tsz}}_257 odds" id="o_3ZTS{{$tsz}}_257">--</td>
            <td class="G3ZTS{{$tsz}}_257 amount ha" id="a_3ZTS{{$tsz}}_257"><input name="3ZTS{{$tsz}}_257" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_258 name" id="t_3ZTS{{$tsz}}_258" title="{{$gameName}} 258"><input type="hidden" id="k_3ZTS{{$tsz}}_258"
                                                                                     value="3Z">258
            </th>

            <td class="G3ZTS{{$tsz}}_258 odds" id="o_3ZTS{{$tsz}}_258">--</td>
            <td class="G3ZTS{{$tsz}}_258 amount ha" id="a_3ZTS{{$tsz}}_258"><input name="3ZTS{{$tsz}}_258" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_259 name" id="t_3ZTS{{$tsz}}_259" title="{{$gameName}} 259"><input type="hidden" id="k_3ZTS{{$tsz}}_259"
                                                                                     value="3Z">259
            </th>

            <td class="G3ZTS{{$tsz}}_259 odds" id="o_3ZTS{{$tsz}}_259">--</td>
            <td class="G3ZTS{{$tsz}}_259 amount ha" id="a_3ZTS{{$tsz}}_259"><input name="3ZTS{{$tsz}}_259" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_266 name" id="t_3ZTS{{$tsz}}_266" title="{{$gameName}} 266"><input type="hidden" id="k_3ZTS{{$tsz}}_266"
                                                                                     value="3Z">266
            </th>

            <td class="G3ZTS{{$tsz}}_266 odds" id="o_3ZTS{{$tsz}}_266">--</td>
            <td class="G3ZTS{{$tsz}}_266 amount ha" id="a_3ZTS{{$tsz}}_266"><input name="3ZTS{{$tsz}}_266" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_267 name" id="t_3ZTS{{$tsz}}_267" title="{{$gameName}} 267"><input type="hidden" id="k_3ZTS{{$tsz}}_267"
                                                                                     value="3Z">267
            </th>

            <td class="G3ZTS{{$tsz}}_267 odds" id="o_3ZTS{{$tsz}}_267">--</td>
            <td class="G3ZTS{{$tsz}}_267 amount ha" id="a_3ZTS{{$tsz}}_267"><input name="3ZTS{{$tsz}}_267" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_268 name" id="t_3ZTS{{$tsz}}_268" title="{{$gameName}} 268"><input type="hidden" id="k_3ZTS{{$tsz}}_268"
                                                                                     value="3Z">268
            </th>

            <td class="G3ZTS{{$tsz}}_268 odds" id="o_3ZTS{{$tsz}}_268">--</td>
            <td class="G3ZTS{{$tsz}}_268 amount ha" id="a_3ZTS{{$tsz}}_268"><input name="3ZTS{{$tsz}}_268" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_269 name" id="t_3ZTS{{$tsz}}_269" title="{{$gameName}} 269"><input type="hidden" id="k_3ZTS{{$tsz}}_269"
                                                                                     value="3Z">269
            </th>

            <td class="G3ZTS{{$tsz}}_269 odds" id="o_3ZTS{{$tsz}}_269">--</td>
            <td class="G3ZTS{{$tsz}}_269 amount ha" id="a_3ZTS{{$tsz}}_269"><input name="3ZTS{{$tsz}}_269" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_277 name" id="t_3ZTS{{$tsz}}_277" title="{{$gameName}} 277"><input type="hidden" id="k_3ZTS{{$tsz}}_277"
                                                                                     value="3Z">277
            </th>

            <td class="G3ZTS{{$tsz}}_277 odds" id="o_3ZTS{{$tsz}}_277">--</td>
            <td class="G3ZTS{{$tsz}}_277 amount ha" id="a_3ZTS{{$tsz}}_277"><input name="3ZTS{{$tsz}}_277" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_278 name" id="t_3ZTS{{$tsz}}_278" title="{{$gameName}} 278"><input type="hidden" id="k_3ZTS{{$tsz}}_278"
                                                                                     value="3Z">278
            </th>

            <td class="G3ZTS{{$tsz}}_278 odds" id="o_3ZTS{{$tsz}}_278">--</td>
            <td class="G3ZTS{{$tsz}}_278 amount ha" id="a_3ZTS{{$tsz}}_278"><input name="3ZTS{{$tsz}}_278" class="ba"></td>
        </tr>
        </tbody>
    </table>


    <table>
        <tbody>
        <tr class="head">
            <th>种类</th>
            <th>赔率</th>
            <th class="ha">金额</th>
        </tr>
        <tr>
            <th class="G3ZTS{{$tsz}}_279 name" id="t_3ZTS{{$tsz}}_279" title="{{$gameName}} 279"><input type="hidden" id="k_3ZTS{{$tsz}}_279"
                                                                                     value="3Z">279
            </th>

            <td class="G3ZTS{{$tsz}}_279 odds" id="o_3ZTS{{$tsz}}_279">--</td>
            <td class="G3ZTS{{$tsz}}_279 amount ha" id="a_3ZTS{{$tsz}}_279"><input name="3ZTS{{$tsz}}_279" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_288 name" id="t_3ZTS{{$tsz}}_288" title="{{$gameName}} 288"><input type="hidden" id="k_3ZTS{{$tsz}}_288"
                                                                                     value="3Z">288
            </th>

            <td class="G3ZTS{{$tsz}}_288 odds" id="o_3ZTS{{$tsz}}_288">--</td>
            <td class="G3ZTS{{$tsz}}_288 amount ha" id="a_3ZTS{{$tsz}}_288"><input name="3ZTS{{$tsz}}_288" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_289 name" id="t_3ZTS{{$tsz}}_289" title="{{$gameName}} 289"><input type="hidden" id="k_3ZTS{{$tsz}}_289"
                                                                                     value="3Z">289
            </th>

            <td class="G3ZTS{{$tsz}}_289 odds" id="o_3ZTS{{$tsz}}_289">--</td>
            <td class="G3ZTS{{$tsz}}_289 amount ha" id="a_3ZTS{{$tsz}}_289"><input name="3ZTS{{$tsz}}_289" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_299 name" id="t_3ZTS{{$tsz}}_299" title="{{$gameName}} 299"><input type="hidden" id="k_3ZTS{{$tsz}}_299"
                                                                                     value="3Z">299
            </th>

            <td class="G3ZTS{{$tsz}}_299 odds" id="o_3ZTS{{$tsz}}_299">--</td>
            <td class="G3ZTS{{$tsz}}_299 amount ha" id="a_3ZTS{{$tsz}}_299"><input name="3ZTS{{$tsz}}_299" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_333 name" id="t_3ZTS{{$tsz}}_333" title="{{$gameName}} 333"><input type="hidden" id="k_3ZTS{{$tsz}}_333"
                                                                                     value="3Z">333
            </th>

            <td class="G3ZTS{{$tsz}}_333 odds" id="o_3ZTS{{$tsz}}_333">--</td>
            <td class="G3ZTS{{$tsz}}_333 amount ha" id="a_3ZTS{{$tsz}}_333"><input name="3ZTS{{$tsz}}_333" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_334 name" id="t_3ZTS{{$tsz}}_334" title="{{$gameName}} 334"><input type="hidden" id="k_3ZTS{{$tsz}}_334"
                                                                                     value="3Z">334
            </th>

            <td class="G3ZTS{{$tsz}}_334 odds" id="o_3ZTS{{$tsz}}_334">--</td>
            <td class="G3ZTS{{$tsz}}_334 amount ha" id="a_3ZTS{{$tsz}}_334"><input name="3ZTS{{$tsz}}_334" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_335 name" id="t_3ZTS{{$tsz}}_335" title="{{$gameName}} 335"><input type="hidden" id="k_3ZTS{{$tsz}}_335"
                                                                                     value="3Z">335
            </th>

            <td class="G3ZTS{{$tsz}}_335 odds" id="o_3ZTS{{$tsz}}_335">--</td>
            <td class="G3ZTS{{$tsz}}_335 amount ha" id="a_3ZTS{{$tsz}}_335"><input name="3ZTS{{$tsz}}_335" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_336 name" id="t_3ZTS{{$tsz}}_336" title="{{$gameName}} 336"><input type="hidden" id="k_3ZTS{{$tsz}}_336"
                                                                                     value="3Z">336
            </th>

            <td class="G3ZTS{{$tsz}}_336 odds" id="o_3ZTS{{$tsz}}_336">--</td>
            <td class="G3ZTS{{$tsz}}_336 amount ha" id="a_3ZTS{{$tsz}}_336"><input name="3ZTS{{$tsz}}_336" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_337 name" id="t_3ZTS{{$tsz}}_337" title="{{$gameName}} 337"><input type="hidden" id="k_3ZTS{{$tsz}}_337"
                                                                                     value="3Z">337
            </th>

            <td class="G3ZTS{{$tsz}}_337 odds" id="o_3ZTS{{$tsz}}_337">--</td>
            <td class="G3ZTS{{$tsz}}_337 amount ha" id="a_3ZTS{{$tsz}}_337"><input name="3ZTS{{$tsz}}_337" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_338 name" id="t_3ZTS{{$tsz}}_338" title="{{$gameName}} 338"><input type="hidden" id="k_3ZTS{{$tsz}}_338"
                                                                                     value="3Z">338
            </th>

            <td class="G3ZTS{{$tsz}}_338 odds" id="o_3ZTS{{$tsz}}_338">--</td>
            <td class="G3ZTS{{$tsz}}_338 amount ha" id="a_3ZTS{{$tsz}}_338"><input name="3ZTS{{$tsz}}_338" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_339 name" id="t_3ZTS{{$tsz}}_339" title="{{$gameName}} 339"><input type="hidden" id="k_3ZTS{{$tsz}}_339"
                                                                                     value="3Z">339
            </th>

            <td class="G3ZTS{{$tsz}}_339 odds" id="o_3ZTS{{$tsz}}_339">--</td>
            <td class="G3ZTS{{$tsz}}_339 amount ha" id="a_3ZTS{{$tsz}}_339"><input name="3ZTS{{$tsz}}_339" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_344 name" id="t_3ZTS{{$tsz}}_344" title="{{$gameName}} 344"><input type="hidden" id="k_3ZTS{{$tsz}}_344"
                                                                                     value="3Z">344
            </th>

            <td class="G3ZTS{{$tsz}}_344 odds" id="o_3ZTS{{$tsz}}_344">--</td>
            <td class="G3ZTS{{$tsz}}_344 amount ha" id="a_3ZTS{{$tsz}}_344"><input name="3ZTS{{$tsz}}_344" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_345 name" id="t_3ZTS{{$tsz}}_345" title="{{$gameName}} 345"><input type="hidden" id="k_3ZTS{{$tsz}}_345"
                                                                                     value="3Z">345
            </th>

            <td class="G3ZTS{{$tsz}}_345 odds" id="o_3ZTS{{$tsz}}_345">--</td>
            <td class="G3ZTS{{$tsz}}_345 amount ha" id="a_3ZTS{{$tsz}}_345"><input name="3ZTS{{$tsz}}_345" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_346 name" id="t_3ZTS{{$tsz}}_346" title="{{$gameName}} 346"><input type="hidden" id="k_3ZTS{{$tsz}}_346"
                                                                                     value="3Z">346
            </th>

            <td class="G3ZTS{{$tsz}}_346 odds" id="o_3ZTS{{$tsz}}_346">--</td>
            <td class="G3ZTS{{$tsz}}_346 amount ha" id="a_3ZTS{{$tsz}}_346"><input name="3ZTS{{$tsz}}_346" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_347 name" id="t_3ZTS{{$tsz}}_347" title="{{$gameName}} 347"><input type="hidden" id="k_3ZTS{{$tsz}}_347"
                                                                                     value="3Z">347
            </th>

            <td class="G3ZTS{{$tsz}}_347 odds" id="o_3ZTS{{$tsz}}_347">--</td>
            <td class="G3ZTS{{$tsz}}_347 amount ha" id="a_3ZTS{{$tsz}}_347"><input name="3ZTS{{$tsz}}_347" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_348 name" id="t_3ZTS{{$tsz}}_348" title="{{$gameName}} 348"><input type="hidden" id="k_3ZTS{{$tsz}}_348"
                                                                                     value="3Z">348
            </th>

            <td class="G3ZTS{{$tsz}}_348 odds" id="o_3ZTS{{$tsz}}_348">--</td>
            <td class="G3ZTS{{$tsz}}_348 amount ha" id="a_3ZTS{{$tsz}}_348"><input name="3ZTS{{$tsz}}_348" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_349 name" id="t_3ZTS{{$tsz}}_349" title="{{$gameName}} 349"><input type="hidden" id="k_3ZTS{{$tsz}}_349"
                                                                                     value="3Z">349
            </th>

            <td class="G3ZTS{{$tsz}}_349 odds" id="o_3ZTS{{$tsz}}_349">--</td>
            <td class="G3ZTS{{$tsz}}_349 amount ha" id="a_3ZTS{{$tsz}}_349"><input name="3ZTS{{$tsz}}_349" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_355 name" id="t_3ZTS{{$tsz}}_355" title="{{$gameName}} 355"><input type="hidden" id="k_3ZTS{{$tsz}}_355"
                                                                                     value="3Z">355
            </th>

            <td class="G3ZTS{{$tsz}}_355 odds" id="o_3ZTS{{$tsz}}_355">--</td>
            <td class="G3ZTS{{$tsz}}_355 amount ha" id="a_3ZTS{{$tsz}}_355"><input name="3ZTS{{$tsz}}_355" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_356 name" id="t_3ZTS{{$tsz}}_356" title="{{$gameName}} 356"><input type="hidden" id="k_3ZTS{{$tsz}}_356"
                                                                                     value="3Z">356
            </th>

            <td class="G3ZTS{{$tsz}}_356 odds" id="o_3ZTS{{$tsz}}_356">--</td>
            <td class="G3ZTS{{$tsz}}_356 amount ha" id="a_3ZTS{{$tsz}}_356"><input name="3ZTS{{$tsz}}_356" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_357 name" id="t_3ZTS{{$tsz}}_357" title="{{$gameName}} 357"><input type="hidden" id="k_3ZTS{{$tsz}}_357"
                                                                                     value="3Z">357
            </th>

            <td class="G3ZTS{{$tsz}}_357 odds" id="o_3ZTS{{$tsz}}_357">--</td>
            <td class="G3ZTS{{$tsz}}_357 amount ha" id="a_3ZTS{{$tsz}}_357"><input name="3ZTS{{$tsz}}_357" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_358 name" id="t_3ZTS{{$tsz}}_358" title="{{$gameName}} 358"><input type="hidden" id="k_3ZTS{{$tsz}}_358"
                                                                                     value="3Z">358
            </th>

            <td class="G3ZTS{{$tsz}}_358 odds" id="o_3ZTS{{$tsz}}_358">--</td>
            <td class="G3ZTS{{$tsz}}_358 amount ha" id="a_3ZTS{{$tsz}}_358"><input name="3ZTS{{$tsz}}_358" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_359 name" id="t_3ZTS{{$tsz}}_359" title="{{$gameName}} 359"><input type="hidden" id="k_3ZTS{{$tsz}}_359"
                                                                                     value="3Z">359
            </th>

            <td class="G3ZTS{{$tsz}}_359 odds" id="o_3ZTS{{$tsz}}_359">--</td>
            <td class="G3ZTS{{$tsz}}_359 amount ha" id="a_3ZTS{{$tsz}}_359"><input name="3ZTS{{$tsz}}_359" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_366 name" id="t_3ZTS{{$tsz}}_366" title="{{$gameName}} 366"><input type="hidden" id="k_3ZTS{{$tsz}}_366"
                                                                                     value="3Z">366
            </th>

            <td class="G3ZTS{{$tsz}}_366 odds" id="o_3ZTS{{$tsz}}_366">--</td>
            <td class="G3ZTS{{$tsz}}_366 amount ha" id="a_3ZTS{{$tsz}}_366"><input name="3ZTS{{$tsz}}_366" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_367 name" id="t_3ZTS{{$tsz}}_367" title="{{$gameName}} 367"><input type="hidden" id="k_3ZTS{{$tsz}}_367"
                                                                                     value="3Z">367
            </th>

            <td class="G3ZTS{{$tsz}}_367 odds" id="o_3ZTS{{$tsz}}_367">--</td>
            <td class="G3ZTS{{$tsz}}_367 amount ha" id="a_3ZTS{{$tsz}}_367"><input name="3ZTS{{$tsz}}_367" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_368 name" id="t_3ZTS{{$tsz}}_368" title="{{$gameName}} 368"><input type="hidden" id="k_3ZTS{{$tsz}}_368"
                                                                                     value="3Z">368
            </th>

            <td class="G3ZTS{{$tsz}}_368 odds" id="o_3ZTS{{$tsz}}_368">--</td>
            <td class="G3ZTS{{$tsz}}_368 amount ha" id="a_3ZTS{{$tsz}}_368"><input name="3ZTS{{$tsz}}_368" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_369 name" id="t_3ZTS{{$tsz}}_369" title="{{$gameName}} 369"><input type="hidden" id="k_3ZTS{{$tsz}}_369"
                                                                                     value="3Z">369
            </th>

            <td class="G3ZTS{{$tsz}}_369 odds" id="o_3ZTS{{$tsz}}_369">--</td>
            <td class="G3ZTS{{$tsz}}_369 amount ha" id="a_3ZTS{{$tsz}}_369"><input name="3ZTS{{$tsz}}_369" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_377 name" id="t_3ZTS{{$tsz}}_377" title="{{$gameName}} 377"><input type="hidden" id="k_3ZTS{{$tsz}}_377"
                                                                                     value="3Z">377
            </th>

            <td class="G3ZTS{{$tsz}}_377 odds" id="o_3ZTS{{$tsz}}_377">--</td>
            <td class="G3ZTS{{$tsz}}_377 amount ha" id="a_3ZTS{{$tsz}}_377"><input name="3ZTS{{$tsz}}_377" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_378 name" id="t_3ZTS{{$tsz}}_378" title="{{$gameName}} 378"><input type="hidden" id="k_3ZTS{{$tsz}}_378"
                                                                                     value="3Z">378
            </th>

            <td class="G3ZTS{{$tsz}}_378 odds" id="o_3ZTS{{$tsz}}_378">--</td>
            <td class="G3ZTS{{$tsz}}_378 amount ha" id="a_3ZTS{{$tsz}}_378"><input name="3ZTS{{$tsz}}_378" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_379 name" id="t_3ZTS{{$tsz}}_379" title="{{$gameName}} 379"><input type="hidden" id="k_3ZTS{{$tsz}}_379"
                                                                                     value="3Z">379
            </th>

            <td class="G3ZTS{{$tsz}}_379 odds" id="o_3ZTS{{$tsz}}_379">--</td>
            <td class="G3ZTS{{$tsz}}_379 amount ha" id="a_3ZTS{{$tsz}}_379"><input name="3ZTS{{$tsz}}_379" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_388 name" id="t_3ZTS{{$tsz}}_388" title="{{$gameName}} 388"><input type="hidden" id="k_3ZTS{{$tsz}}_388"
                                                                                     value="3Z">388
            </th>

            <td class="G3ZTS{{$tsz}}_388 odds" id="o_3ZTS{{$tsz}}_388">--</td>
            <td class="G3ZTS{{$tsz}}_388 amount ha" id="a_3ZTS{{$tsz}}_388"><input name="3ZTS{{$tsz}}_388" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_389 name" id="t_3ZTS{{$tsz}}_389" title="{{$gameName}} 389"><input type="hidden" id="k_3ZTS{{$tsz}}_389"
                                                                                     value="3Z">389
            </th>

            <td class="G3ZTS{{$tsz}}_389 odds" id="o_3ZTS{{$tsz}}_389">--</td>
            <td class="G3ZTS{{$tsz}}_389 amount ha" id="a_3ZTS{{$tsz}}_389"><input name="3ZTS{{$tsz}}_389" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_399 name" id="t_3ZTS{{$tsz}}_399" title="{{$gameName}} 399"><input type="hidden" id="k_3ZTS{{$tsz}}_399"
                                                                                     value="3Z">399
            </th>

            <td class="G3ZTS{{$tsz}}_399 odds" id="o_3ZTS{{$tsz}}_399">--</td>
            <td class="G3ZTS{{$tsz}}_399 amount ha" id="a_3ZTS{{$tsz}}_399"><input name="3ZTS{{$tsz}}_399" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_444 name" id="t_3ZTS{{$tsz}}_444" title="{{$gameName}} 444"><input type="hidden" id="k_3ZTS{{$tsz}}_444"
                                                                                     value="3Z">444
            </th>

            <td class="G3ZTS{{$tsz}}_444 odds" id="o_3ZTS{{$tsz}}_444">--</td>
            <td class="G3ZTS{{$tsz}}_444 amount ha" id="a_3ZTS{{$tsz}}_444"><input name="3ZTS{{$tsz}}_444" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_445 name" id="t_3ZTS{{$tsz}}_445" title="{{$gameName}} 445"><input type="hidden" id="k_3ZTS{{$tsz}}_445"
                                                                                     value="3Z">445
            </th>

            <td class="G3ZTS{{$tsz}}_445 odds" id="o_3ZTS{{$tsz}}_445">--</td>
            <td class="G3ZTS{{$tsz}}_445 amount ha" id="a_3ZTS{{$tsz}}_445"><input name="3ZTS{{$tsz}}_445" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_446 name" id="t_3ZTS{{$tsz}}_446" title="{{$gameName}} 446"><input type="hidden" id="k_3ZTS{{$tsz}}_446"
                                                                                     value="3Z">446
            </th>

            <td class="G3ZTS{{$tsz}}_446 odds" id="o_3ZTS{{$tsz}}_446">--</td>
            <td class="G3ZTS{{$tsz}}_446 amount ha" id="a_3ZTS{{$tsz}}_446"><input name="3ZTS{{$tsz}}_446" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_447 name" id="t_3ZTS{{$tsz}}_447" title="{{$gameName}} 447"><input type="hidden" id="k_3ZTS{{$tsz}}_447"
                                                                                     value="3Z">447
            </th>

            <td class="G3ZTS{{$tsz}}_447 odds" id="o_3ZTS{{$tsz}}_447">--</td>
            <td class="G3ZTS{{$tsz}}_447 amount ha" id="a_3ZTS{{$tsz}}_447"><input name="3ZTS{{$tsz}}_447" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_448 name" id="t_3ZTS{{$tsz}}_448" title="{{$gameName}} 448"><input type="hidden" id="k_3ZTS{{$tsz}}_448"
                                                                                     value="3Z">448
            </th>

            <td class="G3ZTS{{$tsz}}_448 odds" id="o_3ZTS{{$tsz}}_448">--</td>
            <td class="G3ZTS{{$tsz}}_448 amount ha" id="a_3ZTS{{$tsz}}_448"><input name="3ZTS{{$tsz}}_448" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_449 name" id="t_3ZTS{{$tsz}}_449" title="{{$gameName}} 449"><input type="hidden" id="k_3ZTS{{$tsz}}_449"
                                                                                     value="3Z">449
            </th>

            <td class="G3ZTS{{$tsz}}_449 odds" id="o_3ZTS{{$tsz}}_449">--</td>
            <td class="G3ZTS{{$tsz}}_449 amount ha" id="a_3ZTS{{$tsz}}_449"><input name="3ZTS{{$tsz}}_449" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_455 name" id="t_3ZTS{{$tsz}}_455" title="{{$gameName}} 455"><input type="hidden" id="k_3ZTS{{$tsz}}_455"
                                                                                     value="3Z">455
            </th>

            <td class="G3ZTS{{$tsz}}_455 odds" id="o_3ZTS{{$tsz}}_455">--</td>
            <td class="G3ZTS{{$tsz}}_455 amount ha" id="a_3ZTS{{$tsz}}_455"><input name="3ZTS{{$tsz}}_455" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_456 name" id="t_3ZTS{{$tsz}}_456" title="{{$gameName}} 456"><input type="hidden" id="k_3ZTS{{$tsz}}_456"
                                                                                     value="3Z">456
            </th>

            <td class="G3ZTS{{$tsz}}_456 odds" id="o_3ZTS{{$tsz}}_456">--</td>
            <td class="G3ZTS{{$tsz}}_456 amount ha" id="a_3ZTS{{$tsz}}_456"><input name="3ZTS{{$tsz}}_456" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_457 name" id="t_3ZTS{{$tsz}}_457" title="{{$gameName}} 457"><input type="hidden" id="k_3ZTS{{$tsz}}_457"
                                                                                     value="3Z">457
            </th>

            <td class="G3ZTS{{$tsz}}_457 odds" id="o_3ZTS{{$tsz}}_457">--</td>
            <td class="G3ZTS{{$tsz}}_457 amount ha" id="a_3ZTS{{$tsz}}_457"><input name="3ZTS{{$tsz}}_457" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_458 name" id="t_3ZTS{{$tsz}}_458" title="{{$gameName}} 458"><input type="hidden" id="k_3ZTS{{$tsz}}_458"
                                                                                     value="3Z">458
            </th>

            <td class="G3ZTS{{$tsz}}_458 odds" id="o_3ZTS{{$tsz}}_458">--</td>
            <td class="G3ZTS{{$tsz}}_458 amount ha" id="a_3ZTS{{$tsz}}_458"><input name="3ZTS{{$tsz}}_458" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_459 name" id="t_3ZTS{{$tsz}}_459" title="{{$gameName}} 459"><input type="hidden" id="k_3ZTS{{$tsz}}_459"
                                                                                     value="3Z">459
            </th>

            <td class="G3ZTS{{$tsz}}_459 odds" id="o_3ZTS{{$tsz}}_459">--</td>
            <td class="G3ZTS{{$tsz}}_459 amount ha" id="a_3ZTS{{$tsz}}_459"><input name="3ZTS{{$tsz}}_459" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_466 name" id="t_3ZTS{{$tsz}}_466" title="{{$gameName}} 466"><input type="hidden" id="k_3ZTS{{$tsz}}_466"
                                                                                     value="3Z">466
            </th>

            <td class="G3ZTS{{$tsz}}_466 odds" id="o_3ZTS{{$tsz}}_466">--</td>
            <td class="G3ZTS{{$tsz}}_466 amount ha" id="a_3ZTS{{$tsz}}_466"><input name="3ZTS{{$tsz}}_466" class="ba"></td>
        </tr>
        </tbody>
    </table>


    <table>
        <tbody>
        <tr class="head">
            <th>种类</th>
            <th>赔率</th>
            <th class="ha">金额</th>
        </tr>
        <tr>
            <th class="G3ZTS{{$tsz}}_467 name" id="t_3ZTS{{$tsz}}_467" title="{{$gameName}} 467"><input type="hidden" id="k_3ZTS{{$tsz}}_467"
                                                                                     value="3Z">467
            </th>

            <td class="G3ZTS{{$tsz}}_467 odds" id="o_3ZTS{{$tsz}}_467">--</td>
            <td class="G3ZTS{{$tsz}}_467 amount ha" id="a_3ZTS{{$tsz}}_467"><input name="3ZTS{{$tsz}}_467" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_468 name" id="t_3ZTS{{$tsz}}_468" title="{{$gameName}} 468"><input type="hidden" id="k_3ZTS{{$tsz}}_468"
                                                                                     value="3Z">468
            </th>

            <td class="G3ZTS{{$tsz}}_468 odds" id="o_3ZTS{{$tsz}}_468">--</td>
            <td class="G3ZTS{{$tsz}}_468 amount ha" id="a_3ZTS{{$tsz}}_468"><input name="3ZTS{{$tsz}}_468" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_469 name" id="t_3ZTS{{$tsz}}_469" title="{{$gameName}} 469"><input type="hidden" id="k_3ZTS{{$tsz}}_469"
                                                                                     value="3Z">469
            </th>

            <td class="G3ZTS{{$tsz}}_469 odds" id="o_3ZTS{{$tsz}}_469">--</td>
            <td class="G3ZTS{{$tsz}}_469 amount ha" id="a_3ZTS{{$tsz}}_469"><input name="3ZTS{{$tsz}}_469" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_477 name" id="t_3ZTS{{$tsz}}_477" title="{{$gameName}} 477"><input type="hidden" id="k_3ZTS{{$tsz}}_477"
                                                                                     value="3Z">477
            </th>

            <td class="G3ZTS{{$tsz}}_477 odds" id="o_3ZTS{{$tsz}}_477">--</td>
            <td class="G3ZTS{{$tsz}}_477 amount ha" id="a_3ZTS{{$tsz}}_477"><input name="3ZTS{{$tsz}}_477" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_478 name" id="t_3ZTS{{$tsz}}_478" title="{{$gameName}} 478"><input type="hidden" id="k_3ZTS{{$tsz}}_478"
                                                                                     value="3Z">478
            </th>

            <td class="G3ZTS{{$tsz}}_478 odds" id="o_3ZTS{{$tsz}}_478">--</td>
            <td class="G3ZTS{{$tsz}}_478 amount ha" id="a_3ZTS{{$tsz}}_478"><input name="3ZTS{{$tsz}}_478" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_479 name" id="t_3ZTS{{$tsz}}_479" title="{{$gameName}} 479"><input type="hidden" id="k_3ZTS{{$tsz}}_479"
                                                                                     value="3Z">479
            </th>

            <td class="G3ZTS{{$tsz}}_479 odds" id="o_3ZTS{{$tsz}}_479">--</td>
            <td class="G3ZTS{{$tsz}}_479 amount ha" id="a_3ZTS{{$tsz}}_479"><input name="3ZTS{{$tsz}}_479" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_488 name" id="t_3ZTS{{$tsz}}_488" title="{{$gameName}} 488"><input type="hidden" id="k_3ZTS{{$tsz}}_488"
                                                                                     value="3Z">488
            </th>

            <td class="G3ZTS{{$tsz}}_488 odds" id="o_3ZTS{{$tsz}}_488">--</td>
            <td class="G3ZTS{{$tsz}}_488 amount ha" id="a_3ZTS{{$tsz}}_488"><input name="3ZTS{{$tsz}}_488" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_489 name" id="t_3ZTS{{$tsz}}_489" title="{{$gameName}} 489"><input type="hidden" id="k_3ZTS{{$tsz}}_489"
                                                                                     value="3Z">489
            </th>

            <td class="G3ZTS{{$tsz}}_489 odds" id="o_3ZTS{{$tsz}}_489">--</td>
            <td class="G3ZTS{{$tsz}}_489 amount ha" id="a_3ZTS{{$tsz}}_489"><input name="3ZTS{{$tsz}}_489" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_499 name" id="t_3ZTS{{$tsz}}_499" title="{{$gameName}} 499"><input type="hidden" id="k_3ZTS{{$tsz}}_499"
                                                                                     value="3Z">499
            </th>

            <td class="G3ZTS{{$tsz}}_499 odds" id="o_3ZTS{{$tsz}}_499">--</td>
            <td class="G3ZTS{{$tsz}}_499 amount ha" id="a_3ZTS{{$tsz}}_499"><input name="3ZTS{{$tsz}}_499" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_555 name" id="t_3ZTS{{$tsz}}_555" title="{{$gameName}} 555"><input type="hidden" id="k_3ZTS{{$tsz}}_555"
                                                                                     value="3Z">555
            </th>

            <td class="G3ZTS{{$tsz}}_555 odds" id="o_3ZTS{{$tsz}}_555">--</td>
            <td class="G3ZTS{{$tsz}}_555 amount ha" id="a_3ZTS{{$tsz}}_555"><input name="3ZTS{{$tsz}}_555" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_556 name" id="t_3ZTS{{$tsz}}_556" title="{{$gameName}} 556"><input type="hidden" id="k_3ZTS{{$tsz}}_556"
                                                                                     value="3Z">556
            </th>

            <td class="G3ZTS{{$tsz}}_556 odds" id="o_3ZTS{{$tsz}}_556">--</td>
            <td class="G3ZTS{{$tsz}}_556 amount ha" id="a_3ZTS{{$tsz}}_556"><input name="3ZTS{{$tsz}}_556" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_557 name" id="t_3ZTS{{$tsz}}_557" title="{{$gameName}} 557"><input type="hidden" id="k_3ZTS{{$tsz}}_557"
                                                                                     value="3Z">557
            </th>

            <td class="G3ZTS{{$tsz}}_557 odds" id="o_3ZTS{{$tsz}}_557">--</td>
            <td class="G3ZTS{{$tsz}}_557 amount ha" id="a_3ZTS{{$tsz}}_557"><input name="3ZTS{{$tsz}}_557" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_558 name" id="t_3ZTS{{$tsz}}_558" title="{{$gameName}} 558"><input type="hidden" id="k_3ZTS{{$tsz}}_558"
                                                                                     value="3Z">558
            </th>

            <td class="G3ZTS{{$tsz}}_558 odds" id="o_3ZTS{{$tsz}}_558">--</td>
            <td class="G3ZTS{{$tsz}}_558 amount ha" id="a_3ZTS{{$tsz}}_558"><input name="3ZTS{{$tsz}}_558" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_559 name" id="t_3ZTS{{$tsz}}_559" title="{{$gameName}} 559"><input type="hidden" id="k_3ZTS{{$tsz}}_559"
                                                                                     value="3Z">559
            </th>

            <td class="G3ZTS{{$tsz}}_559 odds" id="o_3ZTS{{$tsz}}_559">--</td>
            <td class="G3ZTS{{$tsz}}_559 amount ha" id="a_3ZTS{{$tsz}}_559"><input name="3ZTS{{$tsz}}_559" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_566 name" id="t_3ZTS{{$tsz}}_566" title="{{$gameName}} 566"><input type="hidden" id="k_3ZTS{{$tsz}}_566"
                                                                                     value="3Z">566
            </th>

            <td class="G3ZTS{{$tsz}}_566 odds" id="o_3ZTS{{$tsz}}_566">--</td>
            <td class="G3ZTS{{$tsz}}_566 amount ha" id="a_3ZTS{{$tsz}}_566"><input name="3ZTS{{$tsz}}_566" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_567 name" id="t_3ZTS{{$tsz}}_567" title="{{$gameName}} 567"><input type="hidden" id="k_3ZTS{{$tsz}}_567"
                                                                                     value="3Z">567
            </th>

            <td class="G3ZTS{{$tsz}}_567 odds" id="o_3ZTS{{$tsz}}_567">--</td>
            <td class="G3ZTS{{$tsz}}_567 amount ha" id="a_3ZTS{{$tsz}}_567"><input name="3ZTS{{$tsz}}_567" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_568 name" id="t_3ZTS{{$tsz}}_568" title="{{$gameName}} 568"><input type="hidden" id="k_3ZTS{{$tsz}}_568"
                                                                                     value="3Z">568
            </th>

            <td class="G3ZTS{{$tsz}}_568 odds" id="o_3ZTS{{$tsz}}_568">--</td>
            <td class="G3ZTS{{$tsz}}_568 amount ha" id="a_3ZTS{{$tsz}}_568"><input name="3ZTS{{$tsz}}_568" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_569 name" id="t_3ZTS{{$tsz}}_569" title="{{$gameName}} 569"><input type="hidden" id="k_3ZTS{{$tsz}}_569"
                                                                                     value="3Z">569
            </th>

            <td class="G3ZTS{{$tsz}}_569 odds" id="o_3ZTS{{$tsz}}_569">--</td>
            <td class="G3ZTS{{$tsz}}_569 amount ha" id="a_3ZTS{{$tsz}}_569"><input name="3ZTS{{$tsz}}_569" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_577 name" id="t_3ZTS{{$tsz}}_577" title="{{$gameName}} 577"><input type="hidden" id="k_3ZTS{{$tsz}}_577"
                                                                                     value="3Z">577
            </th>

            <td class="G3ZTS{{$tsz}}_577 odds" id="o_3ZTS{{$tsz}}_577">--</td>
            <td class="G3ZTS{{$tsz}}_577 amount ha" id="a_3ZTS{{$tsz}}_577"><input name="3ZTS{{$tsz}}_577" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_578 name" id="t_3ZTS{{$tsz}}_578" title="{{$gameName}} 578"><input type="hidden" id="k_3ZTS{{$tsz}}_578"
                                                                                     value="3Z">578
            </th>

            <td class="G3ZTS{{$tsz}}_578 odds" id="o_3ZTS{{$tsz}}_578">--</td>
            <td class="G3ZTS{{$tsz}}_578 amount ha" id="a_3ZTS{{$tsz}}_578"><input name="3ZTS{{$tsz}}_578" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_579 name" id="t_3ZTS{{$tsz}}_579" title="{{$gameName}} 579"><input type="hidden" id="k_3ZTS{{$tsz}}_579"
                                                                                     value="3Z">579
            </th>

            <td class="G3ZTS{{$tsz}}_579 odds" id="o_3ZTS{{$tsz}}_579">--</td>
            <td class="G3ZTS{{$tsz}}_579 amount ha" id="a_3ZTS{{$tsz}}_579"><input name="3ZTS{{$tsz}}_579" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_588 name" id="t_3ZTS{{$tsz}}_588" title="{{$gameName}} 588"><input type="hidden" id="k_3ZTS{{$tsz}}_588"
                                                                                     value="3Z">588
            </th>

            <td class="G3ZTS{{$tsz}}_588 odds" id="o_3ZTS{{$tsz}}_588">--</td>
            <td class="G3ZTS{{$tsz}}_588 amount ha" id="a_3ZTS{{$tsz}}_588"><input name="3ZTS{{$tsz}}_588" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_589 name" id="t_3ZTS{{$tsz}}_589" title="{{$gameName}} 589"><input type="hidden" id="k_3ZTS{{$tsz}}_589"
                                                                                     value="3Z">589
            </th>

            <td class="G3ZTS{{$tsz}}_589 odds" id="o_3ZTS{{$tsz}}_589">--</td>
            <td class="G3ZTS{{$tsz}}_589 amount ha" id="a_3ZTS{{$tsz}}_589"><input name="3ZTS{{$tsz}}_589" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_599 name" id="t_3ZTS{{$tsz}}_599" title="{{$gameName}} 599"><input type="hidden" id="k_3ZTS{{$tsz}}_599"
                                                                                     value="3Z">599
            </th>

            <td class="G3ZTS{{$tsz}}_599 odds" id="o_3ZTS{{$tsz}}_599">--</td>
            <td class="G3ZTS{{$tsz}}_599 amount ha" id="a_3ZTS{{$tsz}}_599"><input name="3ZTS{{$tsz}}_599" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_666 name" id="t_3ZTS{{$tsz}}_666" title="{{$gameName}} 666"><input type="hidden" id="k_3ZTS{{$tsz}}_666"
                                                                                     value="3Z">666
            </th>

            <td class="G3ZTS{{$tsz}}_666 odds" id="o_3ZTS{{$tsz}}_666">--</td>
            <td class="G3ZTS{{$tsz}}_666 amount ha" id="a_3ZTS{{$tsz}}_666"><input name="3ZTS{{$tsz}}_666" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_667 name" id="t_3ZTS{{$tsz}}_667" title="{{$gameName}} 667"><input type="hidden" id="k_3ZTS{{$tsz}}_667"
                                                                                     value="3Z">667
            </th>

            <td class="G3ZTS{{$tsz}}_667 odds" id="o_3ZTS{{$tsz}}_667">--</td>
            <td class="G3ZTS{{$tsz}}_667 amount ha" id="a_3ZTS{{$tsz}}_667"><input name="3ZTS{{$tsz}}_667" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_668 name" id="t_3ZTS{{$tsz}}_668" title="{{$gameName}} 668"><input type="hidden" id="k_3ZTS{{$tsz}}_668"
                                                                                     value="3Z">668
            </th>

            <td class="G3ZTS{{$tsz}}_668 odds" id="o_3ZTS{{$tsz}}_668">--</td>
            <td class="G3ZTS{{$tsz}}_668 amount ha" id="a_3ZTS{{$tsz}}_668"><input name="3ZTS{{$tsz}}_668" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_669 name" id="t_3ZTS{{$tsz}}_669" title="{{$gameName}} 669"><input type="hidden" id="k_3ZTS{{$tsz}}_669"
                                                                                     value="3Z">669
            </th>

            <td class="G3ZTS{{$tsz}}_669 odds" id="o_3ZTS{{$tsz}}_669">--</td>
            <td class="G3ZTS{{$tsz}}_669 amount ha" id="a_3ZTS{{$tsz}}_669"><input name="3ZTS{{$tsz}}_669" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_677 name" id="t_3ZTS{{$tsz}}_677" title="{{$gameName}} 677"><input type="hidden" id="k_3ZTS{{$tsz}}_677"
                                                                                     value="3Z">677
            </th>

            <td class="G3ZTS{{$tsz}}_677 odds" id="o_3ZTS{{$tsz}}_677">--</td>
            <td class="G3ZTS{{$tsz}}_677 amount ha" id="a_3ZTS{{$tsz}}_677"><input name="3ZTS{{$tsz}}_677" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_678 name" id="t_3ZTS{{$tsz}}_678" title="{{$gameName}} 678"><input type="hidden" id="k_3ZTS{{$tsz}}_678"
                                                                                     value="3Z">678
            </th>

            <td class="G3ZTS{{$tsz}}_678 odds" id="o_3ZTS{{$tsz}}_678">--</td>
            <td class="G3ZTS{{$tsz}}_678 amount ha" id="a_3ZTS{{$tsz}}_678"><input name="3ZTS{{$tsz}}_678" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_679 name" id="t_3ZTS{{$tsz}}_679" title="{{$gameName}} 679"><input type="hidden" id="k_3ZTS{{$tsz}}_679"
                                                                                     value="3Z">679
            </th>

            <td class="G3ZTS{{$tsz}}_679 odds" id="o_3ZTS{{$tsz}}_679">--</td>
            <td class="G3ZTS{{$tsz}}_679 amount ha" id="a_3ZTS{{$tsz}}_679"><input name="3ZTS{{$tsz}}_679" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_688 name" id="t_3ZTS{{$tsz}}_688" title="{{$gameName}} 688"><input type="hidden" id="k_3ZTS{{$tsz}}_688"
                                                                                     value="3Z">688
            </th>

            <td class="G3ZTS{{$tsz}}_688 odds" id="o_3ZTS{{$tsz}}_688">--</td>
            <td class="G3ZTS{{$tsz}}_688 amount ha" id="a_3ZTS{{$tsz}}_688"><input name="3ZTS{{$tsz}}_688" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_689 name" id="t_3ZTS{{$tsz}}_689" title="{{$gameName}} 689"><input type="hidden" id="k_3ZTS{{$tsz}}_689"
                                                                                     value="3Z">689
            </th>

            <td class="G3ZTS{{$tsz}}_689 odds" id="o_3ZTS{{$tsz}}_689">--</td>
            <td class="G3ZTS{{$tsz}}_689 amount ha" id="a_3ZTS{{$tsz}}_689"><input name="3ZTS{{$tsz}}_689" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_699 name" id="t_3ZTS{{$tsz}}_699" title="{{$gameName}} 699"><input type="hidden" id="k_3ZTS{{$tsz}}_699"
                                                                                     value="3Z">699
            </th>

            <td class="G3ZTS{{$tsz}}_699 odds" id="o_3ZTS{{$tsz}}_699">--</td>
            <td class="G3ZTS{{$tsz}}_699 amount ha" id="a_3ZTS{{$tsz}}_699"><input name="3ZTS{{$tsz}}_699" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_777 name" id="t_3ZTS{{$tsz}}_777" title="{{$gameName}} 777"><input type="hidden" id="k_3ZTS{{$tsz}}_777"
                                                                                     value="3Z">777
            </th>

            <td class="G3ZTS{{$tsz}}_777 odds" id="o_3ZTS{{$tsz}}_777">--</td>
            <td class="G3ZTS{{$tsz}}_777 amount ha" id="a_3ZTS{{$tsz}}_777"><input name="3ZTS{{$tsz}}_777" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_778 name" id="t_3ZTS{{$tsz}}_778" title="{{$gameName}} 778"><input type="hidden" id="k_3ZTS{{$tsz}}_778"
                                                                                     value="3Z">778
            </th>

            <td class="G3ZTS{{$tsz}}_778 odds" id="o_3ZTS{{$tsz}}_778">--</td>
            <td class="G3ZTS{{$tsz}}_778 amount ha" id="a_3ZTS{{$tsz}}_778"><input name="3ZTS{{$tsz}}_778" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_779 name" id="t_3ZTS{{$tsz}}_779" title="{{$gameName}} 779"><input type="hidden" id="k_3ZTS{{$tsz}}_779"
                                                                                     value="3Z">779
            </th>

            <td class="G3ZTS{{$tsz}}_779 odds" id="o_3ZTS{{$tsz}}_779">--</td>
            <td class="G3ZTS{{$tsz}}_779 amount ha" id="a_3ZTS{{$tsz}}_779"><input name="3ZTS{{$tsz}}_779" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_788 name" id="t_3ZTS{{$tsz}}_788" title="{{$gameName}} 788"><input type="hidden" id="k_3ZTS{{$tsz}}_788"
                                                                                     value="3Z">788
            </th>

            <td class="G3ZTS{{$tsz}}_788 odds" id="o_3ZTS{{$tsz}}_788">--</td>
            <td class="G3ZTS{{$tsz}}_788 amount ha" id="a_3ZTS{{$tsz}}_788"><input name="3ZTS{{$tsz}}_788" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_789 name" id="t_3ZTS{{$tsz}}_789" title="{{$gameName}} 789"><input type="hidden" id="k_3ZTS{{$tsz}}_789"
                                                                                     value="3Z">789
            </th>

            <td class="G3ZTS{{$tsz}}_789 odds" id="o_3ZTS{{$tsz}}_789">--</td>
            <td class="G3ZTS{{$tsz}}_789 amount ha" id="a_3ZTS{{$tsz}}_789"><input name="3ZTS{{$tsz}}_789" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_799 name" id="t_3ZTS{{$tsz}}_799" title="{{$gameName}} 799"><input type="hidden" id="k_3ZTS{{$tsz}}_799"
                                                                                     value="3Z">799
            </th>

            <td class="G3ZTS{{$tsz}}_799 odds" id="o_3ZTS{{$tsz}}_799">--</td>
            <td class="G3ZTS{{$tsz}}_799 amount ha" id="a_3ZTS{{$tsz}}_799"><input name="3ZTS{{$tsz}}_799" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_888 name" id="t_3ZTS{{$tsz}}_888" title="{{$gameName}} 888"><input type="hidden" id="k_3ZTS{{$tsz}}_888"
                                                                                     value="3Z">888
            </th>

            <td class="G3ZTS{{$tsz}}_888 odds" id="o_3ZTS{{$tsz}}_888">--</td>
            <td class="G3ZTS{{$tsz}}_888 amount ha" id="a_3ZTS{{$tsz}}_888"><input name="3ZTS{{$tsz}}_888" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_889 name" id="t_3ZTS{{$tsz}}_889" title="{{$gameName}} 889"><input type="hidden" id="k_3ZTS{{$tsz}}_889"
                                                                                     value="3Z">889
            </th>

            <td class="G3ZTS{{$tsz}}_889 odds" id="o_3ZTS{{$tsz}}_889">--</td>
            <td class="G3ZTS{{$tsz}}_889 amount ha" id="a_3ZTS{{$tsz}}_889"><input name="3ZTS{{$tsz}}_889" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_899 name" id="t_3ZTS{{$tsz}}_899" title="{{$gameName}} 899"><input type="hidden" id="k_3ZTS{{$tsz}}_899"
                                                                                     value="3Z">899
            </th>

            <td class="G3ZTS{{$tsz}}_899 odds" id="o_3ZTS{{$tsz}}_899">--</td>
            <td class="G3ZTS{{$tsz}}_899 amount ha" id="a_3ZTS{{$tsz}}_899"><input name="3ZTS{{$tsz}}_899" class="ba"></td>
        </tr>

        <tr>
            <th class="G3ZTS{{$tsz}}_999 name" id="t_3ZTS{{$tsz}}_999" title="{{$gameName}} 999"><input type="hidden" id="k_3ZTS{{$tsz}}_999"
                                                                                     value="3Z">999
            </th>

            <td class="G3ZTS{{$tsz}}_999 odds" id="o_3ZTS{{$tsz}}_999">--</td>
            <td class="G3ZTS{{$tsz}}_999 amount ha" id="a_3ZTS{{$tsz}}_999"><input name="3ZTS{{$tsz}}_999" class="ba"></td>
        </tr>
        </tbody>
    </table>

</div>
