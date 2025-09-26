<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="/static/default/css/table.css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/libs.js"></script>
    <script type="text/javascript" src="/static/default/js/skin.js"></script>
    <script type="text/javascript">$(function () {
            LIBS.colorMoney('.color', 'minus')
        })</script>
</head>
<body>
<div class="main report">
    <div class="search">
    </div>
    <table class="list table">
        <thead>
        <tr>
            <th>注单号</th>
            <th>时间</th>
            <th>类型</th>
            <th>玩法</th>
            <th>盘口</th>
            <th>下注金额</th>
            <th>退水(%)</th>
            <th>@if($settled == false)可赢金额@else结果@endif</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lib as $vo)
        <tr>
            <td>{{$vo['code']}}</td>
            <td class="time">{{$vo['time1']}}<br/> {{$vo['time2']}}</td>
            <td class="period">
                <span class="lottery">{{$vo['gid']}}</span><br/>
                <span class="draw_number">第 {{$vo['qishu']}} 期</span>
            </td>
            <td class="contents">
                <span class="text"> {{$vo['wf']}}@if($vo['content']!='') {{$vo['content']}}@endif</span> @
                <span class="odds">{{$vo['peilv1']}}@if($vo['peilv2']>1)/{{$vo['peilv2']}}@endif</span></td>
            <td class="range">{{$vo['abcd']}}</td>
            <td class="amount">{{$vo['je']}}</td>
            <td>{{$vo['points']}}%</td>
            <td class="result color">{{$vo['ky']}}</td>
        </tr>
        @endforeach
        @if(count($lib)==0)
            <tr class=""><td class="nodata" colspan="8">暂无数据!</td></tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th>总计</th>
            <td>{{$zje}}</td>
            <td></td>
            <td class="result color">{{$zky}}</td>
        </tr>
        </tfoot>
    </table>
    <script>
        $(document).ready(function () {
            $(".page-jump input").on("keydown", function (e) {
                if (e.keyCode === 13) {
                    e.stopPropagation();
                    $(this).blur();
                    if ($(this).val() <= 0 || $(this).parent().data("total-page") < $(this).val()) {
                        alert("页面不存在");
                        return;
                    } else {
                        var navigatePage = $(this).parent().data("page-url").replace("page=1", "page=" + $(this).val());
                        location.href = location.origin + location.pathname + navigatePage;
                    }
                }
            })
        })

    </script>
    @if($rcount>0)
    <div class="page_info">
        <span class="record">共 {{$rcount}} 笔记录</span>
        <span class="page_count">共 {{$pagecount}} 页</span>
        <span class="page_control">
            <a class="previous">
                @if($page == 1)
                <a class="previous">首页</a>
                @else
                <a class="previous" href="/member/bets?{{$isdate==1 ? 'date='.$date.'&':''}}page=1&settled={{$settled}}&lottery={{$lottery}}">首页</a>
                @endif
            </a> | <span class="page-jump" data-total-page="{{$pagecount}}" data-page-url="?{{$isdate==1 ? 'date='.$date.'&':''}}page=1&settled={{$settled}}&lottery={{$lottery}}">跳转至<input type="number" style="width: 50px" maxlength="3"/>页 </span>
            @if($page == 1)
            <a class="previous">前一页</a>
            @else
            <a class="previous" href="/member/bets?{{$isdate==1 ? 'date='.$date.'&':''}}page={{$page-1}}&settled={{$settled}}&lottery={{$lottery}}">前一页</a>
            @endif
            『
            @for($i=$startpcount;$i<=$endpcount;$i++)
                @if($page == $i)
                <a class="current">{{$i}}</a>
                @else
                <a href="/member/bets?{{$isdate==1 ? 'date='.$date.'&':''}}page={{$i}}&settled={{$settled}}&lottery={{$lottery}}">{{$i}}</a>
                @endif
            @endfor
            &nbsp;』
            @if($page == $pagecount)
            <a class="next">后一页</a> |
            @else
            <a class="next" href="/member/bets?{{$isdate==1 ? 'date='.$date.'&':''}}page={{$page+1}}&settled={{$settled}}&lottery={{$lottery}}">后一页</a> |
            @endif
            @if($page == $pagecount)
            <a class="next">末页</a>
            @else
             <a class="next" href="/member/bets?{{$isdate==1 ? 'date='.$date.'&':''}}page={{$pagecount}}&settled={{$settled}}&lottery={{$lottery}}">末页</a>
            @endif
        </span>
    </div>
    @endif
</div>
</body>
</html>
