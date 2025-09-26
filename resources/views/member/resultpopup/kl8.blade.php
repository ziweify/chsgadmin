<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css?id=3498000221"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_KL8.css?v=1221"/>
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
            }

            table .drawTime {
                border-top: 1px solid #CCCCCC;
                padding: 5px 8px 5px 8px;
                text-align: center;
            }

            table .other2 {
                border-top: 1px solid #CCCCCC;
                padding: 5px 0px 5px 0px;
                color: black;
                font-size: 13px;
            }

            table .other, .other1, .TIE {
                border-top: 1px solid #CCCCCC;
                font-size: 13px;
            }

            .period {
                width: 90px;
                text-align: center;
            }

            .other1 {
                color: red;
            }

            .other2 {
                text-align: center;
            }
        </style>
        <thead>
        <tr>
            <th>期数</th>
            <th>时间</th>
            <th id="resultHead" colspan="10">
                <div id="KL8Num" class="result_button num_button">号码</div>
                <div id="KL8Sum" class="result_button num_button">总和</div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $vo)
        <tr>
            <td class="period" rowspan="2">{{$vo['drawNumber']}}</td>
            <td class="drawTime" rowspan="2">{{$vo['drawTime']}}</td>
            <td class="name"><span class="b{{$vo['B1']}}">{{$vo['B1']}}</span></td>
            <td class="name"><span class="b{{$vo['B2']}}">{{$vo['B2']}}</span></td>
            <td class="name"><span class="b{{$vo['B3']}}">{{$vo['B3']}}</span></td>
            <td class="name"><span class="b{{$vo['B4']}}">{{$vo['B4']}}</span></td>
            <td class="name"><span class="b{{$vo['B5']}}">{{$vo['B5']}}</span></td>
            <td class="name"><span class="b{{$vo['B6']}}">{{$vo['B6']}}</span></td>
            <td class="name"><span class="b{{$vo['B7']}}">{{$vo['B8']}}</span></td>
            <td class="name"><span class="b{{$vo['B8']}}">{{$vo['B8']}}</span></td>
            <td class="name"><span class="b{{$vo['B9']}}">{{$vo['B9']}}</span></td>
            <td class="name"><span class="b{{$vo['B10']}}">{{$vo['B10']}}</span></td>
        </tr>
        <tr>
            <th class="name"><span class="b{{$vo['B11']}}">{{$vo['B11']}}</span></th>
            <th class="name"><span class="b{{$vo['B12']}}">{{$vo['B12']}}</span></th>
            <th class="name"><span class="b{{$vo['B13']}}">{{$vo['B13']}}</span></th>
            <th class="name"><span class="b{{$vo['B14']}}">{{$vo['B14']}}</span></th>
            <th class="name"><span class="b{{$vo['B15']}}">{{$vo['B15']}}</span></th>
            <th class="name"><span class="b{{$vo['B16']}}">{{$vo['B16']}}</span></th>
            <th class="name"><span class="b{{$vo['B17']}}">{{$vo['B17']}}</span></th>
            <th class="name"><span class="b{{$vo['B18']}}">{{$vo['B18']}}</span></th>
            <th class="name"><span class="b{{$vo['B19']}}">{{$vo['B19']}}</span></th>
            <th class="name"><span class="b{{$vo['B20']}}">{{$vo['B20']}}</span></th>
            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            <td class="other GDS_{{$vo['ZDS'][1]}}">{{$vo['ZDS'][0]}}</td>
            <td class="other GWX_{{$vo['WX'][1]}}">{{$vo['WX'][0]}}</td>
            <td class="other2 GQHH_{{$vo['QHH'][1]}}">{{$vo['QHH'][0]}}</td>
            <td class="other2 GDSH_{{$vo['DSH'][1]}}">{{$vo['DSH'][0]}}</td>
        </tr>
        @endforeach
        <script>
            $(document).ready(function () {
                $('#drawTable .other1, #drawTable .other2, #drawTable .other, #drawTable .TIE, .page_info').hide();
                $('#KL8Num').attr("style", "background-color:#2161b3;color:white;");

                $('#KL8Num').on('click', function () {
                    $('#KL8Num').attr("style", "background-color:#2161b3;color:white;");
                    $('#KL8Sum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .other1, #drawTable .other2, #drawTable .other, #drawTable .TIE').hide();
                    $('#drawTable .name').show();
                });

                $('#KL8Sum').on('click', function () {
                    $('#KL8Sum').attr("style", "background-color:#2161b3;color:white;");
                    $('#KL8Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .name').hide();
                    $('#drawTable .other1, #drawTable .other2, #drawTable .TIE, #drawTable .other').show();
                });
            });
        </script>
        </tbody>
    </table>
</div>
</body>
</html>
