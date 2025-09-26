<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css?id=3498000221"/>
    <link rel="stylesheet" type="text/css" href="/static/default/css/g_SSC.css?v=1223"/>
</head>
<body class="L_{{$lottery}} skin_">
<div id="drawTable">
    <table class="list table_ball" style="border-bottom: 1px solid #cdd0d4; width: 100%;">
        <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
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
            }

            table .other1, .other2 {
                border-top: 1px solid #CCCCCC;
                padding: 5px 0px 5px 0px;
                color: black;
                width: 34px;
            }

            table .other {
                border-top: 1px solid #CCCCCC;
                width: 30px;
            }

            .period {
                width: 90px;
                text-align: center;
            }
        </style>
        <thead>
        <tr>
            <th>期数</th>
            <th>时间</th>
            <th id="resultHead" colspan="10">
                <div id="SSCNum" class="result_button num_button">号码</div>
                <div id="SSCDX" class="result_button num_button">大小</div>
                <div id="SSCDS" class="result_button num_button">单双</div>
                <div id="SSCZHLH" class="result_button zhlh_button">总和/龙虎</div>
                <div id="SSCDN" class="result_button num_button">斗牛</div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $vo)
        <tr id="SSCResult">
            <td class="period" style="width:27%;text-align:center;">{{$vo['drawNumber']}}</td>
            <td class="drawTime" style="width:58px;text-align:center;">{{$vo['drawTime']}}</td>
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
            <td class="other1">{{$vo['ZH']}}</td>
            <td class="other">
                <div class="GDS_{{$vo['ZDS']}}">
            </td>
            <td class="other">
                <div class="GDX_{{$vo['ZDX']}}">
            </td>
            <td class="other GLHT_{{$vo['LH'][1]}}">{{$vo['LH'][0]}}</td>
            <td class="other2 GDN_{{$vo['DN'][1]}}">{{$vo['DN'][0]}}</td>
            <td class="other2 GDNDX_{{$vo['DNDX'][1]}}">@if($vo['DNDX'][1] !='LOSE'){{$vo['DNDX'][0]}}@else无牛@endif</td>
            <td class="other2 GDNDS_{{$vo['DNDS'][1]}}">@if($vo['DNDS'][1] !='LOSE'){{$vo['DNDS'][0]}}@else无牛@endif</td>
            <td class="other2 GDNSH_{{$vo['DNSH'][1]}}">{{$vo['DNSH'][0]}}</td>
            <td class="other"></td>
            <td class="other"></td>
        </tr>
        @endforeach
        <script>
            $(document).ready(function () {
                $('#drawTable .other1, #drawTable .other, #drawTable .other2, .page_info').hide();
                $('#SSCNum').attr("style", "background-color:#2161b3;color:white;");

                $('#SSCZHLH').on('click', function () {
                    $('#SSCZHLH').attr("style", "background-color:#2161b3;color:white;");
                    $('#SSCDX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCNum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDN').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .big_small, #drawTable .odd_even, #drawTable .other2').hide();
                    $('#drawTable .other1, #drawTable .other').show();
                });
                $('#SSCDX').on('click', function () {
                    $('#SSCDX').attr("style", "background-color:#2161b3;color:white;");
                    $('#SSCZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCNum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDN').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .odd_even, #drawTable .other1, #drawTable .other, #drawTable .other2').hide();
                    $('#drawTable .big_small').show();
                });
                $('#SSCDS').on('click', function () {
                    $('#SSCDS').attr("style", "background-color:#2161b3;color:white;");
                    $('#SSCZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCNum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDN').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .big_small, #drawTable .ballname, #drawTable .other1, #drawTable .other, #drawTable .other2').hide();
                    $('#drawTable .odd_even').show();
                });
                $('#SSCNum').on('click', function () {
                    $('#SSCNum').attr("style", "background-color:#2161b3;color:white;");
                    $('#SSCZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDN').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname').show();
                    $('#drawTable .big_small, #drawTable .odd_even, #drawTable .other1, #drawTable .other, #drawTable .other2').hide();
                });
                $('#SSCDN').on('click', function () {
                    $('#SSCDN').attr("style", "background-color:#2161b3;color:white;");
                    $('#SSCZHLH').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDX').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCDS').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#SSCNum').attr("style", "cursor: pointer;border-radius: 5px;border: 1px solid gray;");
                    $('#resultHead').attr('colspan', 10);
                    $('#drawTable .ballname, #drawTable .big_small, #drawTable .odd_even, #drawTable .other, #drawTable .other1').hide();
                    $('#drawTable .other2').show();
                });
            });
        </script>
        </tbody>
    </table>
</div>
</body>
</html>
