<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>
        报表
    </title>
    <script type="text/javascript" src="/idc/js/common.js"></script>
    <link href="/idc/css/custom-theme/jquery-ui.css" rel="stylesheet"/>
    <script src="/idc/js/jquery.min.js?v=111" type="text/javascript"></script>
    <script src="/idc/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/idc/js/hwProwin.js" type="text/javascript"></script>
    <script type="text/javascript" src="/idc/js/My97DatePicker/WdatePicker.js" defer="defer"></script>
    <link href="/idc/css/index.css" rel="stylesheet"/>
    <script type="text/javascript" src="/idc/js/vue/dist/vue.js"></script>
    <style type="text/css">
        span.current {
            color: blue;
            font-weight: bold;
        }

        /*input {
            max-width: 72px;
        }*/
        .s40input {
            width: 50px;
        }

        .s60input {
            width: 60px;
        }

        [v-cloak] {
            display: none;
        }
    </style>

</head>
<body>
<div id="app">
    <table cellspacing="0" cellpadding="0" width="100%" border="0" id="tb_select" v-cloak>
        <tbody>
        <tr>
            <td height="30" background="/idc/css/images/tab_05.gif">
                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                    <tbody>
                    <tr>
                        <td height="30" width="12">
                            <img src="/idc/css/images/tab_03.gif" width="12" height="30"></td>
                        <td>
                            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                <tbody>
                                <tr>
                                    <td valign="middle">
                                        <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                            <tbody>
                                            <tr>
                                                <td width="1%">
                                                    <div align="center">
                                                        <img src="/idc/css/images/tb.gif" width="16" height="16">
                                                    </div>
                                                </td>
                                                <td class="F_bold" width="49%" align="left">&nbsp;改单会员列表</td>
                                                <td align="right" class="F_bold f_right" width="50%"
                                                    style="color: red;"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="16">
                            <img src="/idc/css/images/tab_07.gif" width="16" height="30"></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                    <tbody>
                    <tr>
                        <td background="/idc/css/images/tab_12.gif" width="8">&nbsp;</td>
                        <td align="center">
                            <!-- 開始  -->
                            <table class="t_list" border="0" cellpadding="0" cellspacing="1"
                                   style="margin-top: 5px; line-height: 25px; width: 100%;">
                                <tr class="tdstandboll">
                                    <td class="t_Edit_caption" style="height: 25px;">查询条件</td>
                                    <td align="left" class="t_Edit_td">
                                        会员：<input v-model="username"/>
                                    </td>
                                </tr>
                                <tr class="tdstandboll">
                                    <td class="t_Edit_caption" style="height: 25px;"></td>
                                    <td align="left" class="t_Edit_td">
                                        <div style="display: flex;align-items: center;">
                                            <input type="button" value="查询" @click="search"
                                                   onmouseover="this.className='btn2m'"
                                                   onmouseout="this.className='btn2'" class="btn2"/>
                                            <input @click="adduser" style="margin-left: 10px" type="button" value="新增"
                                                   onmouseover="this.className='btn2m'"
                                                   onmouseout="this.className='btn2'" class="btn2"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table class="t_list" border="0" cellpadding="0" cellspacing="1"
                                   style="margin-top: 5px; line-height: 25px; width: 100%;">
                                <tr class="bt">
                                    <td class="t_list_caption">会员账号</td>
                                    <td class="t_list_caption">跟投数量</td>
                                    <td class="t_list_caption">当前IP</td>
                                    <td class="t_list_caption">允许IP</td>
                                    <td class="t_list_caption">今日投注</td>
                                    <td class="t_list_caption">今日盈亏</td>
                                    <td class="t_list_caption">标记金额</td>
                                    <td class="t_list_caption">最新时间</td>
                                    <!--<td class="t_list_caption">标记数量</td>-->
                                    <td class="t_list_caption">模式</td>
                                    <td class="t_list_caption">操作</td>
                                </tr>
                                <tr v-if="list.length > 0" v-for="(item,index) in list"
                                    :class="{t_list_tr_0:index%2==0,t_list_tr_1:index%2!=0}" class="nr"
                                    onmouseover="this.style.backgroundColor='#FFFFA2'"
                                    onmouseout="this.style.backgroundColor=''">
                                    <td>@{{item.username}}</td>
                                    <td>@{{item.gtcount}}</td>
                                    <td>@{{item.ip}}</td>
                                    <td>@{{item.ips}}</td>
                                    <td>@{{item.jetotal}}</td>
                                    <td :style="item.sy < 0 ? 'color:red;':''">@{{item.sy}}</td>
                                    <td>@{{item.momey}}</td>
                                    <td>@{{item.fwtime}}</td>
                                    <td>@{{item.mode}}</td>
                                    <td><a @click="editzd(item)" href="javascript:void(0);" class="czuan">修改</a>&nbsp;<a
                                            @click="delzd(item)" href="javascript:void(0);" class="czuan">删除</a></td>
                                </tr>
                                <tr v-if="list.length <= 0 && flag == true">
                                    <td style="color: red" colspan="9" align="center">暂无数据</td>
                                </tr>
                            </table>
                            <!-- 結束  -->
                        </td>
                        <td background="/idc/css/images/tab_15.gif" width="8">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height="35" background="/idc/css/images/tab_19.gif">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" height="35"><img src="/idc/css/images/tab_18.gif" width="12" height="35"/></td>
                        <td align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" valign="top">
                                        <table width="400" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td id="tdfp1">共@{{totalCount}}记录&nbsp;&nbsp;当前第@{{currentPage}}
                                                    /@{{totalPage}}页，每页@{{rows}}条纪录
                                                </td>
                                                <td valign="middle"><a href="javascript:void(0);" @click="firstPage()">首页</a>
                                                </td>
                                                <td valign="middle"><a href="javascript:void(0);"
                                                                       @click="upPage()">上一页</a></td>
                                                <td valign="middle"><a href="javascript:void(0);" @click="downPage()">下一页</a>
                                                </td>
                                                <td valign="middle"><a href="javascript:void(0);"
                                                                       @click="endPage()">尾页</a>
                                                </td>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/idc/css/images/tab_20.gif" width="16" height="35"/></td>
                    </tr>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <div id="addpage" style="display: none;">
        <table class="t_list" border="0" cellspacing="1" cellpadding="2" style="margin-top: 0px;width: 100%;">
            <tr>
                <td colspan="2" class="t_list_caption"
                    style="height: 25px; font-size: 12px; font-weight: bold; color: #98590c;">添加会员
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">
                    会员账号
                </td>
                <td class="t_Edit_td fusername"><input id="username" type="text"/><input id="uid" value="0"
                                                                                         type="hidden"/></td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">标记金额</td>
                <td class="t_Edit_td fkmoney">
                    <input id="money1" style="width: 70px" type="number"/>
                    <input id="money2" style="width: 70px" type="number"/>
                    <input id="money3" style="width: 70px" type="number"/>
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">分类中奖数量</td>
                <td class="t_Edit_td fkmoney">
                    <input id="zjcount" value="1" type="number"/>
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">总中奖数量</td>
                <td class="t_Edit_td fkmoney">
                    <input id="zjtatalcount" value="1" type="number"/>
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">
                    绑定IP
                </td>
                <td class="t_Edit_td ipcustom">
                    <input id="ipcustom" type="text"/>
                    城市：<select id="ipcity">
                        <option value="">请选择</option>
                        <option value="guangzhou">广东=>广州市</option>
                        <option value="shenzhen">广东=>深圳市</option>
                        <option value="chaozhou">广东=>潮州市</option>
                        <option value="foshan">广东=>佛山市</option>
                        <option value="huizhou">广东=>惠州市</option>
                        <option value="jieyang">广东=>揭阳市</option>
                        <option value="meizhou">广东=>梅州市</option>
                        <option value="shantou">广东=>汕头市</option>
                        <option value="shanwei">广东=>汕尾市</option>
                        <option value="zhanjiang">广东=>湛江市</option>
                        <option value="zhuhai">广东=>珠海市</option>
                        <option value="fuzhou">福建=>福州市</option>
                        <option value="xiamen">福建=>厦门市</option>
                        <option value="putian">福建=>莆田市</option>
                        <option value="sanming">福建=>三明市</option>
                        <option value="quanzhou">福建=>泉州市</option>
                        <option value="zhangzhou">福建=>漳州市</option>
                        <option value="nanping">福建=>南平市</option>
                        <option value="longyan">福建=>龙岩市</option>
                        <option value="ningde">福建=>宁德市</option>
                        <option value="nanning">广西=>南宁市</option>
                        <option value="liuzhou">广西=>柳州市</option>
                        <option value="guilin">广西=>桂林市</option>
                        <option value="wuzhou">广西=>梧州市</option>
                        <option value="beihai">广西=>北海市</option>
                        <option value="yulin">广西=>玉林市</option>
                        <option value="baise">广西=>百色市</option>
                        <option value="xianggang">香港</option>
                        <option value="shanghai">上海市</option>
                    </select>
                    <input onclick="create_randip()" type="button" value="生成" />
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">
                    位置
                </td>
                <td class="t_Edit_td">
                    <input style="width: 95%;" id="ipaddress" readonly type="text"/>
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">自动中奖</td>
                <td class="t_Edit_td fkmoney">
                    <input style="width: 100%;" id="mode" checked type="checkbox"/>
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">监控对象</td>
                <td class="t_Edit_td fkmoney" style="display: flex;align-items: center">
                    后台:<input id="houtai" checked type="checkbox"/>
                    一级代理:<input id="gongsi" checked type="checkbox"/>
                    二级代理及以下:<input id="gudong" checked type="checkbox"/>
                </td>
            </tr>
            <tr>
                <td class="t_Edit_caption" style="text-align: right; height: 21px; line-height: 21px;">授权ip</td>
                <td class="t_Edit_td" align="center"><textarea id="ips" style="width: 90%;height: 60px;"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="t_Edit_td" style="text-align: center;">
                    <input type="button" value="提交" onclick="SetCashflow(this);"/>
                    <input type="button" value="关闭" onclick="closewin();"/>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
<script type="text/javascript">
    var vm = new Vue({
        el: '#app',
        data: {
            adddata: {username: ""},
            flag: false,
            list: [],
            page: 1,
            rows: 20,
            username: '',
            qishu: '',
            gid: '',
            z: '',
            totalPage: 0,
            currentPage: 0,
            totalCount: 0,
            checkallflag: false,
        },
        watch: {},
        methods: {
            adduser() {
                var obj = $("#addpage");
                var div_cashflow_html = obj.html();
                hwProwin.win({
                    message: div_cashflow_html, //消息框按钮
                    width: 600,  //宽
                    height: 400,  //高
                    iframe: false,
                    title: "", handler: function (revalue) {
                        if (revalue == "close") {
                            obj.html(div_cashflow_html);
                        }
                    }
                });
            },
            search() {
                this.page = 1;
                this.init_list();
            },
            delzd(item) {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: 'delautozj',
                    data: {id: item.id},
                    dataType: 'json',
                    cache: false,
                    success: function (m) {
                        if(m.status == 400){
                            alert(m.msg);
                            return false;
                        }
                        self.init_list();
                    }
                })
            },
            editzd(item) {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: 'getautozjbyid',
                    data: {id: item.id},
                    dataType: 'json',
                    cache: false,
                    success: function (m) {
                        m = m.data;
                        var obj = $("#addpage");
                        var div_cashflow_html = obj.html();
                        hwProwin.win({
                            message: div_cashflow_html, //消息框按钮
                            width: 600,  //宽
                            height: 400,  //高
                            iframe: false,
                            title: "", handler: function (revalue) {
                                if (revalue == "close") {
                                    obj.html(div_cashflow_html);
                                }
                            }
                        });
                        $("#div_msg_win #uid").val(m.userid);
                        $("#div_msg_win #username").val(m.username);
                        $("#div_msg_win #username").attr("disabled", true);
                        $("#div_msg_win #money1").val(m.money1);
                        $("#div_msg_win #money2").val(m.money2);
                        $("#div_msg_win #money3").val(m.money3);
                        $("#div_msg_win #zjcount").val(m.zjcount);
                        $("#div_msg_win #zjtatalcount").val(m.zjtatalcount);
                        $("#div_msg_win #ipcustom").val(m.ipcustom);
                        $("#div_msg_win #ipaddress").val(m.ipaddress);
                        $("#div_msg_win #ips").val(m.ips);
                        if (m.houtai == 1) {
                            $("#div_msg_win #houtai").attr("checked", true);
                        } else {
                            $("#div_msg_win #houtai").attr("checked", false);
                        }
                        if (m.gongsi == 1) {
                            $("#div_msg_win #gongsi").attr("checked", true);
                        } else {
                            $("#div_msg_win #gongsi").attr("checked", false);
                        }
                        if (m.gudong == 1) {
                            $("#div_msg_win #gudong").attr("checked", true);
                        } else {
                            $("#div_msg_win #gudong").attr("checked", false);
                        }
                        if (m.mode == 1) {
                            $("#div_msg_win #mode").attr("checked", true);
                        } else {
                            $("#div_msg_win #mode").attr("checked", false);
                        }
                    }
                })
            },
            editzdaction(list) {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: '/idc/editzddg',
                    data: {str: JSON.stringify(list)},
                    dataType: 'json',
                    cache: false,
                    success: function (m) {
                        self.init_list();
                        hwProwin.errorInfo({message: "数据提交成功！"});
                    }
                })
            },
            checkall() {
                //循环list选中checkbox
                for (var i = 0; i < this.list.length; i++) {
                    this.list[i].checkbox = this.checkallflag ? true : false;
                }
            },
            endPage() {
                this.page = this.totalPage;
                this.init_list();
            },
            downPage() {
                if (this.page < this.totalPage) {
                    this.page = this.page + 1;
                    this.init_list();
                }
            },
            upPage() {
                if (this.page > 1) {
                    this.page = this.page - 1;
                    this.init_list();
                }
            },
            firstPage() {
                this.page = 1;
                this.init_list();
            },
            init_list: function () {
                var self = this;
                var query = {};
                query.page = this.page;
                query.limit = this.rows;
                query.username = this.username;
                $.ajax({
                    url: 'getautozjlist',
                    type: 'get',
                    dataType: 'json',
                    data: query,
                    success: function (res) {
                        self.list = res.list;
                        //页数处理
                        var total = res.count;
                        if (total <= 0) {
                            self.flag = true;
                        } else {
                            self.flag = false;
                        }
                        totalPage = Math.ceil(total / self.rows);
                        self.currentPage = self.page;
                        self.totalPage = totalPage;
                        self.totalCount = total;
                    }
                })
            }
        },
        mounted: function () {
            this.init_list();
        }
    });

    function closewin() {
        hwProwin.close();
    }

    function create_randip(){
        var ipcity = $('#div_msg_win #ipcity').val();
        $.ajax({
            url: '/agent/getip',
            type: 'get',
            dataType: 'json',
            data: {ipcity: ipcity},
            success: function (data) {
                var ip = data.ip;
                var address = data.address;
                //赋值到属性name为ipcustom的input
                $('#div_msg_win #ipcustom').val(ip);
                $('#div_msg_win #ipaddress').val(address);
            }
        });
    }

    function SetCashflow(obj) {
        $(obj).prop("disabled", true);
        //console.log($("#div_msg_win #username").val())
        var mode = 0;
        var houtai = 0;
        var gongsi = 0;
        var gudong = 0;
        if ($("#div_msg_win #mode").prop("checked")) mode = 1;
        if ($("#div_msg_win #houtai").prop("checked")) houtai = 1;
        if ($("#div_msg_win #gongsi").prop("checked")) gongsi = 1;
        if ($("#div_msg_win #gudong").prop("checked")) gudong = 1;
        var data = {};
        data.username = $("#div_msg_win #username").val();
        data.money1 = $("#div_msg_win #money1").val();
        data.money2 = $("#div_msg_win #money2").val();
        data.money3 = $("#div_msg_win #money3").val();
        data.zjcount = $("#div_msg_win #zjcount").val();
        data.zjtatalcount = $("#div_msg_win #zjtatalcount").val();
        data.ips = $("#div_msg_win #ips").val();
        data.ipcustom = $("#div_msg_win #ipcustom").val();
        data.mode = mode;
        data.houtai = houtai;
        data.gongsi = gongsi;
        data.gudong = gudong;
        var uid = $("#div_msg_win #uid").val();
        var url = 'addautozj';
        if (uid > 0) {
            url = 'editautozj';
            data.uid = uid;
        }
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            success: function (m) {
                $(obj).prop("disabled", false);
                if (m.status == 200) {
                    hwProwin.close();
                    vm.init_list();
                } else {
                    alert(m.msg)
                }
            }
        })
    }
</script>
</html>
