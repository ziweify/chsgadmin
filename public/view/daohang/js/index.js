$(function(){
	//countInfo();
	//点击事件
	dainjiclick();
})
function dainjiclick(){
	$(".in-common-use").on("click","li",function(){
		$(this).addClass("use-text").siblings().removeClass("use-text");
		$("#"+$(this).attr("data-text")).fadeIn().siblings().hide();
	})
	//PC端li跳转页面
//	$("#ultest").on("click",".back_XL",function(){
//		window.location.href=$(this).find("a").attr("href");
//	})
	//移动端li跳转页面
	$("#move-cem").on("click",".back_move",function(){
		window.open($(this).find("a").attr("href"));
	})
	$('#bookmarkme').click(function() {
		if(window.sidebar && window.sidebar.addPanel) { // Mozilla Firefox Bookmark
			window.sidebar.addPanel(document.title, window.location.href, '');
		} else if(window.external && ('AddFavorite' in window.external)) { // IE Favorite
			window.external.AddFavorite(location.href, document.title);
		} else if(window.opera && window.print) { // Opera Hotlist
			this.title = document.title;
			return true;
		} else { // webkit - safari/chrome
			alert('Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? '按Ctrl / Cmd ' : 'CTRL') + '+ D将此页加入书签。');
		}
	});
	$('.neirf #bookmarkme').click(function() {
		if(window.sidebar && window.sidebar.addPanel) { // Mozilla Firefox Bookmark
			window.sidebar.addPanel(document.title, window.location.href, '');
		} else if(window.external && ('AddFavorite' in window.external)) { // IE Favorite
			window.external.AddFavorite(location.href, document.title);
		} else if(window.opera && window.print) { // Opera Hotlist
			this.title = document.title;
			return true;
		} else { // webkit - safari/chrome
			alert('Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? '按Ctrl / Cmd ' : 'CTRL') + '+ D将此页加入书签。');
		}
	});
	//在线客服
	$('.online_service').on('click',function(){
		var classTools = $(this).toggleClass('onService');
		var classType = classTools.attr('class');
		if(classType.indexOf('onService') != -1){
			$('.kfService').show();
		}else{
			$('.kfService').hide();
		}
	})
	//点击弹框中在线客服连接
	$('.kfService button').on('click',function(){
		window.open('https://vue.livelyhelp.chat/chatWindow.aspx?siteId=60002182&planId=37df1c47-950e-4063-800f-1408bbf66c6a','winName','top=150,left=100,width=400,height=600');
	})
}
//--------PC端测速
$.test = function() {
	var span, d = document,
		li, a, i, lis = d.getElementById('ultest').getElementsByClassName('back_XL');
		var html1 = "";
	for(i = 0; li = lis[i++];) {
		a = li.getElementsByTagName('a')[0];
		if(!a) {
			continue;
		}
		span = d.createElement('div');
		span.ctime = new Date();
		span.innerHTML = '测速中...<img src="' + a.href + '" border="0" width="1" height="1" onerror="$.testresult(this)" />';
		li.appendChild(span);
	}
};
$.testresult = function(img) {
	var span = img.parentNode;
	var n = 'em';
	if(!$.testresult.isrun) {
		$.testresult.isrun = true;
		$(span).parent().find("div").css("background","#F1010A");
		span.innerHTML = '<font id="kkk" color="#ffffff" style=" font-weight:bolder">' + ((new Date() - span.ctime) / 1000).toFixed(2) + '秒 最快<\/font>';
	} else {
		span.innerHTML = '' + ((new Date() - span.ctime) / 1000).toFixed(2) + '秒';
	}
};
var ran = Math.random();

//--------移动端端测速
$.move_test = function() {
	var span, d = document,
		li, a, i, lis = d.getElementById('move-cem').getElementsByClassName('back_move');
		var html1 = "";
	for(i = 0; li = lis[i++];) {
		a = li.getElementsByTagName('a')[0];
		if(!a) {
			continue;
		}
		span = d.createElement('div');
		span.ctime = new Date();
		span.innerHTML = '<div class="cesu">测速中...</div>'+'<img src="' + a.href + '" border="0" width="1" height="1" onerror="$.move_result(this)" />';
		li.appendChild(span);
	}
};
$.move_result = function(img) {
	var span = img.parentNode;
	var n = 'em';
	if(!$.move_result.isrun) {
		$.move_result.isrun = true;
		$(span).parent().find("a").css("background","red")
		$(span).parent().find("span").css("color","#ffffff")
		span.innerHTML = '<font id="kkk" color="#ffffff" style=" font-weight:bolder">' + ((new Date() - span.ctime) / 1000).toFixed(2) + '秒 最快<\/font><i class="boult jiant5"></i>';
	} else {
		span.innerHTML = '' + ((new Date() - span.ctime) / 1000).toFixed(2) + '秒'+'<i class="boult jiant"></i>';
	}
};
var ran = Math.random();
// 网站统计代码
/*
var countInfo = function(){
	// CNZZ 友盟
	var cnzz_protocol = ("https:" == document.location.protocol) ? "https://" : "http://";
	(typeof $ === 'function') && $('body').append(unescape("%3Cspan class='cnzz_protocol' id='cnzz_stat_icon_1279668241'%3E%3C/span%3E%3Cscript async src='"+cnzz_protocol+"v1.cnzz.com/z_stat.php%3Fid%3D1279668241' type='text/javascript'%3E%3C/script%3E"));
	$(".cnzz_protocol").hide();

	//google统计代码
	(function(i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function() {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
			m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
	ga('create', 'UA-89926923-1', 'auto');
	ga('send', 'pageview');

	//baidu
	var _hmt = _hmt || [];
	(function() {
		var hm = document.createElement("script");
		hm.src = "https://hm.baidu.com/hm.js?38dc4a282db25a24d2889f005c0e4290";
		var s = document.getElementsByTagName("script")[0]; 
		s.parentNode.insertBefore(hm, s);
	})();
	//51la
	(function() {
		!function(p){"use strict";!function(t){var s=window,e=document,i=p,c="".concat("https:"===e.location.protocol?"https://":"http://","sdk.51.la/js-sdk-pro.min.js"),n=e.createElement("script"),r=e.getElementsByTagName("script")[0];n.type="text/javascript",n.setAttribute("charset","UTF-8"),n.async=!0,n.src=c,n.id="LA_COLLECT",i.d=n;var o=function(){s.LA.ids.push(i)};s.LA?s.LA.ids&&o():(s.LA=p,s.LA.ids=[],o()),r.parentNode.insertBefore(n,r)}()}({id:"JGnvJ9NF6Y5gf5tH",ck:"JGnvJ9NF6Y5gf5tH"});
	})();
};*/
