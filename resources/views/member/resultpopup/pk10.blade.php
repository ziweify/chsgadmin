<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css?id=3498000222"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_PK10.css?v=1222"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
</head>
<body class="L_{{$lottery}} skin_">

<div id="drawTable">
    <table class="list table_ball" style="border-bottom: 1px solid #cdd0d4; width: 100%;">
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
                text-align: center;
            }

            table .drawTime {
                border-top: 1px solid #CCCCCC;
                padding: 5px 8px 5px 8px;
            }

            table .other1, .other2 {
                border-top: 1px solid #CCCCCC;
                padding: 5px 0px 5px 0px;
                color: black;
                width: 34px;
            }

            table .other {
                border-top: 1px solid #CCCCCC;
                width: 34px;
            }

            .result_button.gylh_button {
                width: 100px;
            }
        </style>
        <thead>
        <tr>
            <th>期数</th>
            <th>时间</th>
            <th id="resultHead" colspan="10">
                <div id="PK10Num" class="result_button num_button">号码</div>
                <div id="PK10DX" class="result_button num_button">大小</div>
                <div id="PK10DS" class="result_button num_button">单双</div>
                <div id="PK10GYLH" class="result_button gylh_button">冠亚/龙虎</div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $vo)
        <tr>
            <td class="period">{{$vo['drawNumber']}}</td>
            <td class="drawTime">{{$vo['drawTime']}}</td>
            <td class="name ballname"><span class="b{{$vo['B1']}}">{{$vo['B1']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B1']}}">{{$vo['B1']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B1']}}">{{$vo['B1']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B2']}}">{{$vo['B2']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B2']}}">{{$vo['B2']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B2']}}">{{$vo['B2']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B3']}}">{{$vo['B3']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B3']}}">{{$vo['B3']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B3']}}">{{$vo['B3']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B4']}}">{{$vo['B4']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B4']}}">{{$vo['B4']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B4']}}">{{$vo['B4']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B5']}}">{{$vo['B5']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B5']}}">{{$vo['B5']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B5']}}">{{$vo['B5']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B6']}}">{{$vo['B6']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B6']}}">{{$vo['B6']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B6']}}">{{$vo['B6']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B7']}}">{{$vo['B7']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B7']}}">{{$vo['B7']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B7']}}">{{$vo['B7']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B8']}}">{{$vo['B8']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B8']}}">{{$vo['B8']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B8']}}">{{$vo['B8']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B9']}}">{{$vo['B9']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B9']}}">{{$vo['B9']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B9']}}">{{$vo['B9']}}</span></td>
            <td class="name ballname"><span class="b{{$vo['B10']}}">{{$vo['B10']}}</span></td>
            <td class="big_small ballname" hidden><span class="b{{$vo['B10']}}">{{$vo['B10']}}</span></td>
            <td class="odd_even ballname" hidden><span class="b{{$vo['B10']}}">{{$vo['B10']}}</span></td>
            <td class="other1">{{$vo['GYH']}}</td>
            <td class="other GDX_{{$vo['GDX'][1]}}">{{$vo['GDX'][0]}}</td>
            <td class="other GDS_{{$vo['GDS'][1]}}">{{$vo['GDS'][0]}}</td>
            <td class="other GLH_{{$vo['LH1'][1]}}">{{$vo['LH1'][0]}}</td>
            <td class="other GLH_{{$vo['LH2'][1]}}">{{$vo['LH2'][0]}}</td>
            <td class="other GLH_{{$vo['LH3'][1]}}">{{$vo['LH3'][0]}}</td>
            <td class="other GLH_{{$vo['LH4'][1]}}">{{$vo['LH4'][0]}}</td>
            <td class="other GLH_{{$vo['LH5'][1]}}">{{$vo['LH5'][0]}}</td>
        </tr>
        @endforeach
        </tbody>

        <script>
            $(document).ready(function () {
                $('#drawTable .other1, #drawTable .other').hide();
                $('#PK10Num').attr("style", "background-color:#2161b3;color:white;");

                $('#PK10GYLH').on('click', function () {
                    $('#PK10GYLH').attr("style", "background-color:#2161b3;color:white;");
                    $('#PK10DX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10DS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .big_small, #drawTable .odd_even').hide();
                    $('#drawTable .other1, #drawTable .other').show();
                });
                $('#PK10DX').on('click', function () {
                    $('#PK10DX').attr("style", "background-color:#2161b3;color:white;");
                    $('#PK10GYLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10DS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .odd_even, #drawTable .other1, #drawTable .other').hide();
                    $('#drawTable .big_small').show();
                });
                $('#PK10DS').on('click', function () {
                    $('#PK10DS').attr("style", "background-color:#2161b3;color:white;");
                    $('#PK10GYLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10DX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10Num').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .big_small, #drawTable .ballname, #drawTable .other1, #drawTable .other').hide();
                    $('#drawTable .odd_even').show();
                });
                $('#PK10Num').on('click', function () {
                    $('#PK10Num').attr("style", "background-color:#2161b3;color:white;");
                    $('#PK10GYLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10DX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#PK10DS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname').show();
                    $('#drawTable .big_small, #drawTable .odd_even, #drawTable .other1, #drawTable .other').hide();
                });
            });
        </script>
    </table>
</div>
</body>
</html>
