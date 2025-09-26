<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome</title>
<link rel="stylesheet" type="text/css" href="/static/default/css/rule.css" />
<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/js/libs.js"></script>
<script type="text/javascript" src="/static/default/js/hk6Base.js"></script>
<script type="text/javascript" src="/static/default/js/hk6Base2.js"></script>
<script type="text/javascript">
    function resize(iframe) {
            iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
            iframe.scrolling="no";
    }
</script>
</head>
<body>
    <div class="rule_frame">
        <div>
            <select id="selectLotteryRuleDropdown"  style="margin: 5px">
                @foreach($lotterys as $lot)
                    <option @if($lot['lottery'] == $lottery)selected @endif value="{{$lot['lottery']}}" >
                        <span class="name">{{$lot['gname']}}</span>
                    </option>
                @endforeach
            </select>
        </div>
        <iframe id="lotteryRule" onload="resize(this)"></iframe>
    </div>
    <script>
        $(document).ready(function(){
            var lottery = "{{$lottery}}";
            var envString = location.origin.split(".")[1];
            var env = envString.substring(envString.indexOf("-") + 1, envString.length).toUpperCase();

            if(env.indexOf("SIT") !== -1 || env.indexOf("UAT") !== -1) {
                $('#lotteryRule').attr("src","/util/credit-rules/" + env + "/"+lottery+".html");
            } else {
                $('#lotteryRule').attr("src","/util/credit-rules/"+lottery+".html");
            }

            $('#selectLotteryRuleDropdown').change( function () {
                if(env.indexOf("SIT") !== -1 || env.indexOf("UAT") !== -1) {
                    $('#lotteryRule').attr("src","/util/credit-rules/" + env + "/"+$(this).val()+".html");
                } else {
                    $('#lotteryRule').attr("src","/util/credit-rules/"+$(this).val()+".html");
                }
            });

        })
    </script>
</body>
</html>
