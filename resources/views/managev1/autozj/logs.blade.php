
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
		.s40input{
			width: 50px;
		}
		.s60input{
			width: 60px;
		}
		[v-cloak]{display: none;}
		.huang{
			background: #f2bc6c;
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
												<td class="F_bold" width="49%" align="left">&nbsp;访问记录</td>
												<td align="right" class="F_bold f_right" width="50%" style="color: red;"></td>
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
									<td class="t_Edit_caption" style="height: 25px;">定时刷新</td>
									<td align="left" class="t_Edit_td" style="display: flex;align-items: center">
										<input style="width: 60px" v-model="refreshtime" type="number" />
										<input style="margin-left: 10px" type="checkbox" v-model="isrefresh" />刷新开关
									</td>
								</tr>
								<!--<tr class="tdstandboll">
									<td class="t_Edit_caption" style="height: 25px;"></td>
									<td align="left" class="t_Edit_td">
										<div style="display: flex;align-items: center;">
											<input type="button" value="查询" @click="search" onmouseover="this.className='btn2m'" onmouseout="this.className='btn2'" class="btn2"/>
											<input @click="adduser" style="margin-left: 10px" type="button" value="新增" onmouseover="this.className='btn2m'" onmouseout="this.className='btn2'" class="btn2"/>
										</div>
									</td>
								</tr>-->
							</table>
							<table class="t_list" border="0" cellpadding="0" cellspacing="1" style="margin-top: 5px; line-height: 25px; width: 100%;">
								<tr class="bt">
									<td class="t_list_caption">访问账号</td>
									<td class="t_list_caption">访问位置</td>
									<td class="t_list_caption">访问时间</td>
									<td class="t_list_caption">访问IP</td>
									<td class="t_list_caption">时间描述</td>
								</tr>
								<tr v-if="list.length > 0" v-for="(item,index) in list" :class="{t_list_tr_0:index%2==0,t_list_tr_1:index%2!=0,huang:item.cha <= 10}" class="nr" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
									<td>@{{item.username}}(@{{item.layername}})</td>
									<td>@{{item.path_name}}</td>
									<td>@{{item.time}}</td>
									<td>@{{item.ip}}</td>
									<td>@{{item.restult}}</td>
								</tr>
								<tr v-if="list.length <= 0 && flag == true">
									<td style="color: red" colspan="4" align="center">暂无数据</td>
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
			rows:15,
			totalPage:0,
			currentPage:0,
			totalCount:0,
			refreshtime:3,
			isrefresh:true,
			timer:null,
		},
		watch:{
			isrefresh(v1,v2){
				if(v1){
					this.init_timer(1);
				}else{
					this.init_timer(0);
				}
			},
			refreshtime(){
				if(!isNaN(this.shuaxin_time)){
					this.init_timer(1);
				}
			}
		},
		methods: {
			init_timer:function (flag = 1) {
				if(this.timer){
					clearInterval(this.timer);
					this.timer = null;
				}
				if(flag == 1){
					var that = this;
					this.timer = setInterval(function () {
						that.init_list();
					},parseInt(this.refreshtime)*1000);
				}
			},
			search(){
				this.page = 1;
				this.init_list();
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
					url: 'getautozjloglist',
					type: 'get',
					dataType: 'json',
					data: query,
					success: function (res) {
						self.list = res.list;
						//页数处理
						var total = res.count;
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
			this.init_timer();
		}
	});
</script>
</html>
