<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css?id=3498000221"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_11X5.css?v=1221"/>
    <link rel="stylesheet" type="text/css" href="/js/jquery/ui-lightness/jquery-ui.css"/>

</head>
<body class="L_{{$lottery}} skin_">

<div id="drawTable">
    <table class="list table_ball" style="border-bottom: 1px solid #cdd0d4; width: 100%;">
        <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.js"></script>
        <style>
            table {
                border-collapse: collapse;
                color: gray;
            }

            table th {
                border-collapse: collapse;
                padding-bottom: 5px;
            }

            table td {
                border-top: 1px solid #CCCCCC;
                padding: 5px 0 5px 0;
            }

            table .drawTime {
                border-top: 1px solid #CCCCCC;
                padding: 5px 8px 5px 8px;
                text-align: center;
                width: 50px;
            }

            table .other, .other1, .other2, .ballname, .balltie, .TIE {
                border-top: 1px solid #CCCCCC;
                padding: 5px 0px 5px 0px;
                width: 35px;
                font-size: 15px;
                text-align: center;
            }

            .period {
                width: 70px;
                text-align: center;
            }
        </style>
        <thead>
        <tr>
            <th>期数</th>
            <th>时间</th>
            <th id="resultHead" colspan="10">
                <div id="11X5Num" class="result_button num_button">号码</div>
                <div id="11X5DX" class="result_button num_button">大小</div>
                <div id="11X5DS" class="result_button num_button">单双</div>
                <div id="11X5ZHLH" class="result_button yslh_button">总和/龙虎</div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $vo)
        <tr id="11X5Result">
            <td class="period">{{$vo['drawNumber']}}</td>
            <td class="drawTime">{{$vo['drawTime']}}</td>
            @foreach($vo['result'] as $key=>$val)
            <td class="name ballname"><span class="b{{$val}}">{{$val}}</span></td>
            @if($val == 11)
            <td class="balltie" style="color:#2836f4;" hidden><span class=TIE"></span>和</td>
            @else
            <td class="big_small ballname" style="@if($vo['DX'.($key+1)]=='小')color:black; @else color:red; @endif" hidden><span class="b{{intval($val)}}">{{$vo['DX'.($key+1)]}}</span></td>
            <td class="odd_even ballname" style="@if($vo['DS'.($key+1)]=='单')color:black; @else color:red; @endif" hidden><span class="b{{intval($val)}}">{{$vo['DS'.($key+1)]}}</span></td>
            @endif
            @endforeach

            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            <td class="other GDS_{{$vo['ZDS'][1]}}">{{$vo['ZDS'][0]}}</td>
            <td class="other1 GWDX_{{$vo['ZWDX'][1]}}">{{$vo['ZWDX'][0]}}</td>
            <td class="other GLH_{{$vo['LH'][1]}}">{{$vo['LH'][0]}}</td>
        </tr>
        @endforeach
        </tbody>

        <script>
            $(document).ready(function () {
                $('#drawTable .other1, #drawTable .other, #drawTable .TIE,#drawTable .balltie').hide();
                $('#11X5Num').attr("style", "background-color:#2161b3;color:white;");

                $('#11X5ZHLH').on('click', function () {
                    $('#11X5ZHLH').attr("style", "background-color:#2161b3;color:white;");
                    $('#11X5DX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5DS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .big_small, #drawTable .odd_even, #drawTable .other2, #drawTable .balltie ').hide();
                    $('#drawTable .other1, #drawTable .other, #drawTable .TIE').show();
                });
                $('#11X5DX').on('click', function () {
                    $('#11X5DX').attr("style", "background-color:#2161b3;color:white;");
                    $('#11X5ZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5DS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .odd_even, #drawTable .other1, #drawTable .other, #drawTable .other2, #drawTable .TIE').hide();
                    $('#drawTable .big_small, #drawTable .balltie').show();
                });
                $('#11X5DS').on('click', function () {
                    $('#11X5DS').attr("style", "background-color:#2161b3;color:white;");
                    $('#11X5ZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5DX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .big_small, #drawTable .ballname, #drawTable .other1, #drawTable .other, #drawTable .other2, #drawTable .TIE').hide();
                    $('#drawTable .odd_even, #drawTable .balltie').show();
                });
                $('#11X5Num').on('click', function () {
                    $('#11X5Num').attr("style", "background-color:#2161b3;color:white;");
                    $('#11X5ZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5DX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#11X5DS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname').show();
                    $('#drawTable .big_small, #drawTable .odd_even, #drawTable .other1, #drawTable .other, #drawTable .other2, #drawTable .TIE, #drawTable .balltie').hide();
                });
            });
        </script>
    </table>
</div>
</body>
</html>
