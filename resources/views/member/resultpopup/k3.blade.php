<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css?id=3498000221"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_K3.css?v=1221"/>
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
            }

            table .other1 {
                border-top: 1px solid #CCCCCC;
                padding: 5px 0px 5px 0px;
                color: black;
                width: 55px;
                height: 32px;
                font-size: 18px;
                text-align: center;
            }

            table .other {
                border-top: 1px solid #CCCCCC;
            }

            .period {
                width: 90px;
                text-align: center;
            }
        </style>
        <thead>
        <tr>
            <th class="period">期数</th>
            <th>时间</th>
            <th id="resultHead" colspan="10">
                <div id="K3Num" class="result_button long_button">开出骰子</div>
                <div id="K3YXX" class="result_button long_button">鱼虾蟹</div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $vo)
        <tr>
            <td class="period">{{$vo['drawNumber']}}</td>
            <td class="drawTime">{{$vo['drawTime']}}</td>
            <td class="name ballname"><span class="b{{$vo['B1']}}">{{$vo['B1']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B2']}}">{{$vo['B2']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B3']}}">{{$vo['B3']}}</span></td>
            <td class="other1 Gyxx{{$vo['yxxone'][1]}}">{{$vo['yxxone'][0]}}</td>
            <td class="other1 Gyxx{{$vo['yxxtwo'][1]}}">{{$vo['yxxtwo'][0]}}</td>
            <td class="other1 Gyxx{{$vo['yxxthree'][1]}}">{{$vo['yxxthree'][0]}}</td>
            <td class="other">{{$vo['ZH']}}</td>

            <td class="other GDX_{{$vo['ZDX'][1]}}">{{$vo['ZDX'][0]}}</td>
            <td style="width:20px;"></td>
            <td style="width:20px;"></td>
            <td style="width:20px;"></td>
            <td style="width:20px;"></td>
        </tr>
        @endforeach
        </tbody>

        <script>
            $(document).ready(function () {
                $('#drawTable .other1').hide();
                $('#K3Num').attr("style", "background-color:#2161b3;color:white;");

                $('#K3Num').on('click', function () {
                    $('#K3Num').attr("style", "background-color:#2161b3;color:white;");
                    $('#K3YXX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .other1').hide();
                    $('#drawTable .ballname, #drawTable .other').show();
                });

                $('#K3YXX').on('click', function () {
                    $('#K3YXX').attr("style", "background-color:#2161b3;color:white;");
                    $('#K3Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .other').hide();
                    $('#drawTable .other1').show();
                });
            });
        </script>
    </table>
</div>
</body>
</html>
