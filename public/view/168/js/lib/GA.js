//GA
var gtagProtocol = (("https:" == document.location.protocol) ? "https://" : "http://");
var head = document.getElementsByTagName("head")[0];
var gtagScript = document.createElement("script");
gtagScript.async = true;
gtagScript.src = gtagProtocol+'www.googletagmanager.com/gtag/js?id=G-8GZN0CR7N8';
//head.prepend(gtagScript);
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-8GZN0CR7N8');

//CNZZ
var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
//document.write(unescape("%3Cspan class='cnzz_protocol' id='cnzz_stat_icon_1279668241'%3E%3C/span%3E%3Cscript async src='" + cnzz_protocol + "v1.cnzz.com/z_stat.php%3Fid%3D1279668241' type='text/javascript'%3E%3C/script%3E"));
$(".cnzz_protocol").hide();

//baidu
// var _hmt = _hmt || [];
// (function() {
//   var hm = document.createElement("script");
//   hm.src = "https://hm.baidu.com/hm.js?38dc4a282db25a24d2889f005c0e4290";
//   var s = document.getElementsByTagName("script")[0]; 
//   s.parentNode.insertBefore(hm, s);
// })();

//51la
(function() {
    var sdk51 = '';//"sdk.51.la/js-sdk-pro.min.js";
    !function(p){"use strict";!function(t){var s=window,e=document,i=p,c="".concat("https:"===e.location.protocol?"https://":"http://",sdk51),n=e.createElement("script"),r=e.getElementsByTagName("script")[0];n.type="text/javascript",n.setAttribute("charset","UTF-8"),n.async=!0,n.src=c,n.id="LA_COLLECT",i.d=n;var o=function(){s.LA.ids.push(i)};s.LA?s.LA.ids&&o():(s.LA=p,s.LA.ids=[],o()),r.parentNode.insertBefore(n,r)}()}({id:"JGnvJ9NF6Y5gf5tH",ck:"JGnvJ9NF6Y5gf5tH"});
})();