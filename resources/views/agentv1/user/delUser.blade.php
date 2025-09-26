
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<table class="list data_table info_table" style="width: 100%;">
    <tbody>
    <tr>
        <from>
            <td><input id="password" name="password" placeholder="请输入删除密码" ><span id="usernameMsg"></span></td>
            <td><input id="btnOK" type="submit" value="确定" onclick="zh_delete('{{$id}}','{{$name}}','{{$type}}')" /></td>
        </from>
    </tr>
    </tbody>
</table>
<script type="text/javascript" >
    function zh_delete(ID,name,type) {
        var pass = $('input[name="password"]').val();
        if(pass==""){
            $("#usernameMsg").text("请输入密码")
        }else if(window.confirm('你确定要删除：'+name+'及下级所有账户？此操作不可逆，请谨慎操作！！')){
            window.location="zh_delete?id="+ID+'&type='+type+'&name='+name+'&pass='+pass;
            return true;
        }else{
            //alert("取消");
            return false;
        }
    }
</script>
</html>
