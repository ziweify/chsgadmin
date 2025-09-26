<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css?id=3498000221"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_KLSF.css?v=1221"/>
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
                text-align: center;
            }

            table .drawTime {
                border-top: 1px solid #CCCCCC;
                padding: 5px 8px 5px 8px;
                text-align: center;
            }

            table .other1, .other2 {
                border-top: 1px solid #CCCCCC;
                padding: 5px 0px 5px 0px;
                color: black;
                width: 34px;
            }

            table .other, .TIE {
                border-top: 1px solid #CCCCCC;
                width: 34px;
                text-align: center;
            }

            .period {
                text-align: center;
            }
        </style>
        <thead>
        <tr>
            <th>期数</th>
            <th>时间</th>
            <th id="resultHead" colspan="10">
                <div id="KLSFNum" class="result_button num_button">号码</div>
                <div id="KLSFDX" class="result_button num_button">大小</div>
                <div id="KLSFDS" class="result_button num_button">单双</div>
                <div id="KLSFZHLH" class="result_button yslh_button">总和/龙虎</div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $vo)
        <tr id="KLSFResult">
            <td class="period">{{$vo['drawNumber']}}</td>
            <td class="drawTime">{{$vo['drawTime']}}</td>
            @foreach($vo['result'] as $key=>$val)
            <td class="name ballname"><span class="b{{$val}}">{{$val}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{intval($val)}}">{{$val}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{intval($val)}}">{{$val}}</span></td>
            @endforeach

            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            <td class="other GDS_{{$vo['ZDS'][1]}}">{{$vo['ZDS'][0]}}</td>
            <td class="other1 GWDX_{{$vo['ZWDX'][1]}}">{{$vo['ZWDX'][0]}}</td>
            <td class="other GLH_{{$vo['LH1'][1]}}">{{$vo['LH1'][0]}}</td>
            <td class="other GLH_{{$vo['LH2'][1]}}">{{$vo['LH2'][0]}}</td>
            <td class="other GLH_{{$vo['LH3'][1]}}">{{$vo['LH3'][0]}}</td>
            <td class="other GLH_{{$vo['LH4'][1]}}">{{$vo['LH4'][0]}}</td>
        </tr>
        @endforeach
        </tbody>

        <script>
            $(document).ready(function () {
                $('#drawTable .other1, #drawTable .other, #drawTable .other2, #drawTable .TIE').hide();
                $('#KLSFNum').attr("style", "background-color:#2161b3;color:white;");

                $('#KLSFZHLH').on('click', function () {
                    $('#KLSFZHLH').attr("style", "background-color:#2161b3;color:white;");
                    $('#KLSFDX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFDS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFNum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .big_small, #drawTable .odd_even, #drawTable .other2').hide();
                    $('#drawTable .other1, #drawTable .other, #drawTable .TIE').show();
                });
                $('#KLSFDX').on('click', function () {
                    $('#KLSFDX').attr("style", "background-color:#2161b3;color:white;");
                    $('#KLSFNum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFDS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .odd_even, #drawTable .other1, #drawTable .other, #drawTable .other2, #drawTable .TIE').hide();
                    $('#drawTable .big_small').show();
                });
                $('#KLSFDS').on('click', function () {
                    $('#KLSFDS').attr("style", "background-color:#2161b3;color:white;");
                    $('#KLSFNum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFDX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .big_small, #drawTable .ballname, #drawTable .other1, #drawTable .other, #drawTable .other2, #drawTable .TIE').hide();
                    $('#drawTable .odd_even').show();
                });
                $('#KLSFNum').on('click', function () {
                    $('#KLSFNum').attr("style", "background-color:#2161b3;color:white;");
                    $('#KLSFDS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFDX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#KLSFZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname').show();
                    $('#drawTable .big_small, #drawTable .odd_even, #drawTable .other1, #drawTable .other, #drawTable .other2, #drawTable .TIE').hide();
                });
            });
        </script>
    </table>
</div>
</body>
</html>
