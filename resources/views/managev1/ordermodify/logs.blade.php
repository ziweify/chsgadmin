<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>
    报表
</title>
    <script type="text/javascript" src="/idc/js/common.js"></script>
    <link href="/idc/css/custom-theme/jquery-ui.css" rel="stylesheet"/>
	<!--[if IE]><script type="text/javascript" src="/idc/js/polyfill.js"></script><![endif]-->
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
		.s40input{
			width: 50px;
		}
		.s60input{
			width: 60px;
		}
        .bt{
            background: url(/default/css/agent/images/blue/table_head.gif) repeat-x;
        }
        .t_list_caption{
            background-image: none !important;
        }
    </style>

</head>
<body>
<div id="app">
	<table cellspacing="0" cellpadding="0" width="100%" border="0" id="tb_select">
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
												<td class="F_bold" width="49%" align="left">&nbsp;改单记录查询</td>
												<td align="right" class="F_bold f_right" width="50%">&nbsp;</td>
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

								<tr>
									<td class="t_Edit_caption" style="height: 25px;">
										改单日期
									</td>
									<td style="background-color: white;">
										<div style="overflow: hidden; float: left; padding: 0px; margin: 0px;"
											 id="div_datatype">
											&nbsp;<input type="text" value="{{$sdate[10]}}" id="txtbegindate"
														 style="width: 90px; cursor: pointer;" readonly="readonly"
														 onfocus="WdatePicker({maxDate:'2099-10-01'});"/>
											<font color="black">～</font>
											<input value="{{$sdate[10]}}" id="txtenddate"
												   style="width: 90px; cursor: pointer;"
												   readonly="readonly"
												   type="text"
												   onfocus="WdatePicker({minDate:'',maxDate:'2099-10-01'})"/>
										</div>
										<div id="td_sdays" style="float: left; padding: 0px; margin: 0px;">
											<input type="button" style="color: blue;" class="s" value="今日" d="1"/>
											<input type="button" class="s" value="昨日" d="2"/>
											<input type="button" class="s" value="本周" d="3"/>
											<input type="button" class="s" value="上周" d="4"/>
											<input type="button" class="s" value="本月" d="5"/>
											<input type="button" class="s" value="上月" d="6"/>
										</div>
									</td>
								</tr>
								<tr class="tdstandboll">
									<td class="t_Edit_caption" style="height: 25px;">其他条件</td>
									<td align="left" class="t_Edit_td">
										会员：<input v-model="username" />
                                        注单号：<input v-model="code" style="width:220px"/>
										期数：<input v-model="qishu" />
										彩种：<select v-model="gid">
										<option value="">全部</option>
                                        @foreach($gamecs as $vo)
										<option value="{{$vo['gid']}}">{{$vo['gname']}}</option>
										@endforeach
									</select>
									</td>
								</tr>
								<!--<tr class="tdstandboll">
									<td class="t_Edit_caption" style="height: 25px;">账号

									</td>
									<td align="left" class="t_Edit_td">
										<input id="txtmemberno" type="text" style="width: 66px;" maxlength="20"/>
									</td>
								</tr>-->
								<tr class="tdstandboll">
									<td class="t_Edit_caption" style="height: 25px;"></td>
									<td align="left" class="t_Edit_td">
										<div style="display: flex;align-items: center;">
											<input type="button" value="查询" @click="search" onmouseover="this.className='btn2m'" onmouseout="this.className='btn2'" class="btn2"/>
											<input @click="editzdall" style="margin-left: 10px" type="button" value="还原选中" onmouseover="this.className='btn2m'" onmouseout="this.className='btn2'" class="btn2"/>
										</div>
									</td>
								</tr>
							</table>
							<table class="t_list" border="0" cellpadding="0" cellspacing="1" style="margin-top: 5px; line-height: 25px; width: 100%;">
								<tr class="bt">
									<td class="t_list_caption"><input v-model="checkallflag" @click="checkall()" type="checkbox" class="clickall" /></td>
									<td class="t_list_caption">操作</td>
									<td class="t_list_caption">彩种</td>
									<td class="t_list_caption">期数</td>
									<td class="t_list_caption">会员</td>
									<td class="t_list_caption">注单号</td>
									<td class="t_list_caption">类型</td>
									<td class="t_list_caption">类别</td>
									<td class="t_list_caption">盘口</td>
									<td class="t_list_caption">状态</td>
									<td class="t_list_caption">金额</td>
									<td class="t_list_caption">赔率</td>
									<td class="t_list_caption">退水%</td>
                                    <td class="t_list_caption">注单时间</td>
                                    <td class="t_list_caption">改单时间</td>
									{{--<td class="t_list_caption">代理</td>
									<td class="t_list_caption">总代</td>
									<td class="t_list_caption">股东</td>
									<td class="t_list_caption">分公司</td>--}}
								</tr>
								<tr v-if="list.length > 0" v-for="(item,index) in list" :class="{t_list_tr_0:index%2==0,t_list_tr_1:index%2!=0}" class="nr" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
									<td><input v-model="item.checkbox" type="checkbox" class="clickall"></td>
									<td><a @click="editzd(item)" href="javascript:void(0);" class="czuan">还原</a></td>
									<td>@{{item.game}}</td>
									<td>@{{item.qishu}}</td>
									<td>@{{item.duser}}</td>
									<td>
                                        @{{item.code}}
                                        <template v-if="item['action'] == 2"><span style="color: #ff0812;font-weight: bold;margin-left: 5px;">删除单</span></template>
                                    </td>
									<td>@{{item.xtype}}</td>
									<td>
                                        @{{item.bid}}-@{{item.sid}}-@{{item.cid}}:@{{item.pid}}
										<template v-if="item['oldpid']">
											<br><span style="color: red;">改：</span>@{{item.oldbid}}-@{{item.oldsid}}-@{{item.oldcid}}:@{{item.oldpid}}
										</template>
									</td>
									<td>@{{item.abcd}}</td>
									<td>
										<template v-if="item['z'] == 9">
											未结算
										</template>
										<template v-if="item['z'] == 1">
											中奖
										</template>
										<template v-if="item['z'] == 0">
											未中奖
										</template>
										<template v-if="item['z'] == 2">
											和
										</template>
										<template v-if="item['z'] == 7">
											注单取消
										</template>
										<template v-if="item['oldz'] >= 0">
											<br><span style="color: red;">改：</span>
											<template v-if="item['oldz'] == 9">
												未结算
											</template>
											<template v-if="item['oldz'] == 1">
												中奖
											</template>
											<template v-if="item['oldz'] == 0">
												未中奖
											</template>
											<template v-if="item['oldz'] == 2">
												和
											</template>
											<template v-if="item['oldz'] == 7">
												注单取消
											</template>
										</template>
									</td>
									<td>@{{item.je}}
										<template v-if="item['oldje']">
											<br><span style="color: red;">改：</span>@{{item.oldje}}
										</template>
									</td>
									<td>@{{item.peilv1}}
										<template v-if="item['oldpeilv1']">
											<br><span style="color: red;">改：</span>@{{item.oldpeilv1}}
										</template>
									</td>
									<td>@{{item.points}}
										<template v-if="item['oldpoints']">
											<br><span style="color: red;">改：</span>@{{item.oldpoints}}
										</template>
									</td>
                                    <td>@{{item.time}}</td>
									<td>@{{item.errtime}}</td>
									{{--<td>
										<template v-if="item.peilv14 > 0">
											赔:@{{item.peilv14}}水:@{{item.points4}}
										</template>
									</td>
									<td>
										<template v-if="item.peilv13 > 0">
											赔:@{{item.peilv13}}水:@{{item.points3}}
										</template>
									</td>
									<td>
										<template v-if="item.peilv12 > 0">
											赔:@{{item.peilv12}}水:@{{item.points2}}
										</template>
									</td>
									<td>
										<template v-if="item.peilv11 > 0">
											赔:@{{item.peilv11}}水:@{{item.points1}}
										</template>
									</td>--}}
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
												<td id="tdfp1">共@{{totalCount}}记录&nbsp;&nbsp;当前第@{{currentPage}}/@{{totalPage}}页，每页@{{rows}}条纪录</td>
												<td valign="middle"><a href="javascript:void(0);" @click="firstPage()">首页</a>
												</td>
												<td valign="middle"><a href="javascript:void(0);" @click="upPage()">上一页</a></td>
												<td valign="middle"><a href="javascript:void(0);" @click="downPage()">下一页</a></td>
												<td valign="middle"><a href="javascript:void(0);" @click="endPage()">尾页</a>
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
</div>
</body>
<script type="text/javascript">
	var vm = new Vue({
		el: '#app',
		data: {
			flag: false,
			list: [],
			page:1,
			rows:20,
			username:'',
			qishu:'',
			code:'',
			gid:'',
			z:'',
			totalPage:0,
			currentPage:0,
			totalCount:0,
			checkallflag:false,
			flbig107:['冠军', '亚军', '第三名', '第四名', '第五名', '第六名', '第七名', '第八名', '第九名', '第十名'],
			flbig101:['第一球', '第二球', '第三球', '第四球', '第五球'],
			flsis107:[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, '大', '小', '单', '双', '龙', '虎'],
			flsis101:[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, '大', '小', '单', '双'],
			stypearr:[{value:1,title:'中奖'},{value:0,title:'不中奖'},{value:2,title:'和'},{value:7,title:'作废单'},{value:9,title:'未结算'}]
		},
		watch:{

		},
		methods: {
			search:function (){
				this.page = 1;
				this.init_list();
			},
			editzdall:function (){
				var list = [];
				for(var i=0;i<this.list.length;i++){
					if(this.list[i].checkbox){
						list.push(this.list[i]);
					}
				}
				if(list.length <= 0){
					hwProwin.errorInfo({message: "请选择要修改的数据"});
					return;
				}
				this.editzdaction(list);
			},
			editzd:function (item){
				var list = [];
				list.push(item);
				this.editzdaction(list);
			},
			editzdaction:function (list){
				var self = this;
				$.ajax({
					type: 'POST',
					url: 'huanyuanzhudan',
					data: {str:JSON.stringify(list)},
					dataType: 'json',
					cache: false,
					success: function(m) {
                        if(m.code == 1){
                            self.init_list();
                        }
						hwProwin.errorInfo({message:m.msg});
					}
				})
			},
			checkall:function (){
				//循环list选中checkbox
				for(var i=0;i<this.list.length;i++){
					this.list[i].checkbox = this.checkallflag ? true : false;
				}
			},
			endPage:function () {
				this.page = this.totalPage;
				this.init_list();
			},
			downPage:function () {
				if (this.page < this.totalPage) {
					this.page = this.page + 1;
					this.init_list();
				}
			},
			upPage:function () {
				if (this.page > 1) {
					this.page = this.page - 1;
					this.init_list();
				}
			},
			firstPage:function () {
				this.page = 1;
				this.init_list();
			},
			init_list: function () {
				var txtbegindate = $("#txtbegindate").val();
				var txtenddate = $("#txtenddate").val();
				var self = this;
				var query = {};
				query.page = this.page;
				query.limit = this.rows;
				query.start = txtbegindate;
				query.end = txtenddate;
				query.username = this.username;
				query.qishu = this.qishu;
				query.code = this.code;
				query.gid = this.gid;
				query.z = this.z;
				$.ajax({
					url: 'getgdrecordlist',
					type: 'get',
					dataType: 'json',
					data: query,
					success: function (res) {
						self.list = res.tz;
						//页数处理
						var total = res.rcount;
						if(total <= 0){
							self.flag = true;
						}else{
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
</script>
</html>
<script type="text/javascript">
    $(function () {
        $("input.s").click(function () {
            $("input.s").css("color", "#000");
            $(this).css("color", "blue");
            setdate(Number($(this).attr('d')));
            uid = 0;
            //Search();
			vm.page = 1;
			vm.init_list();
        });
        $("input[name='jiesuan']").click(function () {
            uid = 0;
            Search();
        });
        //Search();
    });

    function Search() {
        data = {};
        data.start = $("#txtbegindate").val();
        data.end = $("#txtenddate").val();
        data.username = $("#txtmemberno").val();
        data.js = $("input[name='jiesuan']:checked").val();
        data.uid = uid;
        data.page = pagecurrent;
        $("tr.nr").remove();
        $.ajax({
            type: 'GET',
            url: '/idc/getzhudanlist',
            data: data,
            dataType: 'json',
            success: function (m) {
                var rl = m['r'].length;
                str = [];
                for (var i in m['r']) {
                    let t = m['r'][i];
                    str.push("<tr class='nr t_list_tr_" + (i % 2) + "' onmouseover=\"this.style.backgroundColor='#FFFFA2'\" onmouseout=\"this.style.backgroundColor=''\">");

                    str.push('<td><a href="javascript:void(0);" tid="' + t['code'] + '" class="czuan">除赚</a></td>');
                    str.push('<td>' + t['prize'] + '</td>');
                    str.push('<td>' + t['gname'] + '</td>');
                    str.push('<td>' + t['qishu'] + '</td>');
                    str.push('<td>' + t['tid'] + '</td>');
                    str.push('<td>' + lx[t['xtype']] + '</td>');
                    str.push('<td>' + csname(t['fl'], t['b'], t['s'], t['c'], t['p']) + ' ' + psname(t['fl'], t['b'], t['s'], t['c'], t['p']) + '</td>');
                    str.push('<td>' + t['abcd'] + '</td>');
                    str.push('<td>' + zt[t['z']] + '</td>');
                    str.push('<td>' + t['je'] + '</td>');
                    str.push('<td>' + t['peilv1'] + '</td>');
                    str.push('<td>' + t['points'] + '</td>');
                    str.push('<td>' + t['time'] + '</td>');
                    str.push('<td>' + t['username'] + '</td>');
                    str.push('<td>' + ra(t['u4'], t['uid4']) + '</td>');
                    str.push('<td>' + ra(t['u3'], t['uid3']) + '</td>');
                    str.push('<td>' + ra(t['u2'], t['uid2']) + '</td>');
                    str.push('<td>' + ra(t['u1'], t['uid1']) + '</td>');

                    str.push("</tr>")
                }
                $("tr.nr").remove();
                $("tr.bt").after(str.join(''));

                var pagesize = Number(m['psize']);
                var recordcount = Number(m['rcount']);
                var pagecount = 0;
                if (recordcount > 0) {
                    if (recordcount % pagesize == 0)
                        pagecount = recordcount / pagesize;
                    else
                        pagecount = parseInt(recordcount / pagesize, 10) + 1;
                    var spage = "";
                    var first; //第一页
                    var pre;  //前一页
                    var next; //下一页
                    var end; //最后一页
                    var currentlever;

                    if (pagecurrent > 1) {
                        pvalue = pagecurrent - 1;
                        pre = "<a href=\"javascript:void(0);\" onclick=\"ShowOtherpage(" + pvalue + ")\">前一页</a>&nbsp;";
                        first = "<a href=\"javascript:void(0);\" onclick=\"ShowOtherpage(1)\"> << </a>";
                    } else {
                        pre = "<span>前一页&nbsp;</span>";
                        first = "<span> << </span>";
                    }
                    if (pagecurrent == pagecount) {
                        next = "<span> &nbsp;后一页 </span>";
                        end = "<span> >> </span>";
                    } else {
                        pvalue = pagecurrent + 1;
                        next = "<a href=\"javascript:void(0);\" onclick=\"ShowOtherpage(" + pvalue + ")\">后一页</a>&nbsp;";
                        end = "<a href=\"javascript:void(0);\" onclick=\"ShowOtherpage(" + pagecount + ")\"> >> </a>";
                    }

                    if (Math.floor(pagecurrent / 10) == 0) {
                        currentlever = Math.floor(pagecurrent / 10);
                    } else {
                        if (pagecurrent % 10 == 0) {
                            currentlever = Math.floor(pagecurrent / 10) - 1;
                        } else {
                            currentlever = Math.floor(pagecurrent / 10);
                        }
                    }
                    spage = "";
                    if (pagecurrent <= pagecount) {
                        for (p = 1; p <= 10; p++) {
                            value = p + currentlever * 10;
                            if (value > pagecount)
                                break;
                            if (pagecurrent == value) {
                                spage += "&nbsp;<span class=\"current\">" + value + "</span>"
                            } else {
                                spage += "&nbsp;<a href=\"javascript:void(0);\" onclick=\"ShowOtherpage(" + value + ")\">" + value + "</a>";
                            }
                        }
                    }
                    var pagestr = "<TABLE height=22 cellSpacing=0 cellPadding=0 width=\"100%\" border=0><TBODY>"
                        + "<TR class=\"t_list_bottom\"><TD align=left>&nbsp;共&nbsp;" + recordcount + "&nbsp;期记录</TD>"
                        + "<TD align=center>共&nbsp;" + pagecount + "&nbsp;页</TD>"
                        + "<TD align=right>" + pre + "『 " + spage + " 』" + next + "</TD></TR></TBODY></TABLE>";
                    $("#tdpage").html(pagestr);
                }

                str = null;
                t = null;
                m = null;
                $("a.u").click(function () {
                    $("#txtmemberno").val('');
                    uid = $(this).attr("uid");
                    Search();
                })
                $(".czuan").click(function () {
                    var tid = $(this).attr("tid");
                    $.ajax({
                        type: 'POST',
                        url: '/idc/czuan',
                        data: {code: tid},
                        success: function (m) {
                            if (Number(m) == 1) {
                                alert('清除成功!');
                                Search();
                            } else {
                                alert('清除失败!');
                                Search();
                            }
                        }
                    })
                });

            }
        })
    }

    lx = [];
    lx[0] = "下注";
    lx[1] = "下注";
    lx[2] = "补牌";
    zt = [];
    zt[7] = '作废单';
    zt[9] = '未结算';
    zt[0] = '不中';
    zt[1] = '中奖';
    zt[2] = '和局';

    function ra(uname, uid) {
        if (uid == 0) {
            return '';
        }
        return '<a href="javascript:void(0)" class="u" uid="' + uid + '">' + uname + '</a>';
    }

    function ShowOtherpage(v) {
        pagecurrent = v;
        Search();
    }

    function csname(fl, bn, sn, cn, pn) {
        if (fl == 101) {
            if (bn == '1~5球') {
                if (isNaN(pn)) {
                    return sn + cn;
                } else {
                    return sn;
                }
            } else if (bn == '总和龙虎') {
                return cn;
            } else if (bn == '前中后三') {
                return pn + "(" + sn + ")";
            } else if (bn == '梭哈') {
                return sn;
            } else if (cn == '牛牛大小' || cn == '牛牛单双') {
                return cn.replace('牛牛', '牛');
            } else if (sn == '牛牛') {
                return sn;
            } else {
                var head = '';
                switch (sn) {
                    case "万千ΟΟ×××":
                        head = "1,2";
                        break;
                    case "万佰Ο×Ο××":
                        head = "1,3";
                        break;
                    case "万拾Ο××Ο×":
                        head = "1,4";
                        break;
                    case "万个Ο×××Ο":
                        head = "1,5";
                        break;
                    case "千佰×ΟΟ××":
                        head = "2,3";
                        break;
                    case "千拾×Ο×Ο×":
                        head = "2,4";
                        break;
                    case "千个×Ο××Ο":
                        head = "2,5";
                        break;
                    case "佰拾××ΟΟ×":
                        head = "3,4";
                        break;
                    case "佰个××Ο×Ο":
                        head = "3,5";
                        break;
                    case "拾个×××ΟΟ":
                        head = "4,5";
                        break;
                }
                if (cn == '和尾大小') {
                    return head + '球和数尾数大小';
                } else {
                    return head + '球和数单双';
                }
            }
        } else if (fl == 107) {
            if (bn == '冠亚军组合') {
                if (!isNaN(pn)) {
                    return sn;
                } else {
                    return '冠亚' + cn;
                }

            } else if (!isNaN(pn)) {
                return sn;
            }
        } else if (fl == 161) {
            if (bn == '总和') {
                return cn;
            } else if (bn == '总和过关') {
                return sn;
            } else {
                return sn;
            }
        }
        return sn + cn;
    }

    function psname(fl, bn, sn, cn, pn) {
        if (fl == 101) {
            if (bn == '总和龙虎') {
                return pn.replace('总和', '');
            } else if (cn == '和尾大小') {
                return pn.replace('和尾', '');
            }
        } else if (fl == 107) {
            if (bn == '冠亚军组合') {
                pn.replace('冠亚', '');
            } else if (!isNaN(pn)) {
                if (Number(pn) < 10) {
                    return '0' + Number(pn);
                }
            }
        } else if (fl == 161) {
            if (cn == '总和810') {
                return "和值810";
            } else if (bn == '总和') {
                return pn.replace('总和', '');
            } else if (bn == '总和过关') {
                return pn.replace('总', '');
            }
        }
        return pn;
    }

    function setdate(val) {
        var start = $("#txtbegindate");
        var end = $("#txtenddate");
        switch (val) {
            case 1:
                start.val(sdate[10]);
                end.val(sdate[10]);
                break;
            case 2:
                start.val(sdate[0]);
                end.val(sdate[0]);
                break;
            case 3:
                start.val(sdate[5]);
                end.val(sdate[6]);
                break;
            case 4:
                start.val(sdate[7]);
                end.val(sdate[8]);
                break;
            case 5:
                start.val(sdate[1]);
                end.val(sdate[2]);
                break;
            case 6:
                start.val(sdate[3]);
                end.val(sdate[4]);
                break
        }
    }

    var uid = 0, pagecurrent = 1;

    sdate = new Array();
    sdate[0] = "{{$sdate[0]}}";
    sdate[1] = "{{$sdate[1]}}";
    sdate[2] = "{{$sdate[2]}}";
    sdate[3] = "{{$sdate[3]}}";
    sdate[4] = "{{$sdate[4]}}";
    sdate[5] = "{{$sdate[5]}}";
    sdate[6] = "{{$sdate[6]}}";
    sdate[7] = "{{$sdate[7]}}";
    sdate[8] = "{{$sdate[8]}}";
    sdate[9] = "{{$sdate[9]}}";
    sdate[10] = "{{$sdate[10]}}";
</script>
