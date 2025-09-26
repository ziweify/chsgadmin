$(function() {
	$('table.list tbody tr:not(.head)').hover(function() {
		$(this).addClass('hover');
	}, function() {
		$(this).removeClass('hover');
	});
	LIBS.bindFocus($('.input_panel input:text,.input_panel input:password,input.input'));

	$(window).ajaxSend(function(e, j, s) {
		if (s.loading) {
			var text = '';
			if (typeof s.loading == 'string') {
				text = s.loading;
			}
			j.loadingOverlay = $('<div>').addClass('loading_overlay').append($('<div>').append($('<span>').text(text))).appendTo('body');
		}
	});
	$(window).ajaxComplete(function(e, j, s) {
		if (s.loading && j.loadingOverlay) {
			j.loadingOverlay.remove();
		}
	});
});
(function($) {
	$.fn.delayClass = function(classname, delay) {
		var p = this;
		clearTimeout(this.data('_dc_timer_' + classname));
		this.addClass(classname);
		this.data('_dc_timer_' + classname, setTimeout(function() {
			p.removeClass(classname);
		}, delay));
	};
	$.fn.vals = function(filter) {
		var vals = [];
		if ($.isFunction(filter)) {
			this.each(function() {
				var v = $(this).val();
				v = filter(v, this);
				vals.push(v);
			});
		} else {
			this.each(function() {
				vals.push($(this).val());
			});
		}
		return vals;
	};
	$.fn.formData = function(skipEmpty, singleName) {
		var o = {};
		$('input,select,textarea', this).each(function() {
			var t = $(this);
			var tagName = t.prop('tagName').toLowerCase();
			var type = t.prop('type').toLowerCase();
			if (tagName == 'input' && (type == 'radio' || type == 'checkbox') && !t.prop('checked')) {
				return;
			}
			var name = t.prop('name');
			if (!name) {
				name = t.prop('id');
			}
			if (!name) {
				return;
			}
			var value = t.val();
			if (!value && skipEmpty) {
				return;
			}
			var obj = o;
			if (!singleName) {
				var names = name.split('.');
				while (names.length > 1) {
					name = names.shift();
					if (obj[name] == null) {
						obj[name] = {};
					}
					obj = obj[name];
				}
				name = names.shift();
			}
			if (/\[\]$/.test(name)) {
				name = name.substr(0, name.length - 2);
				var arr = obj[name];
				if (!arr) {
					arr = [];
					obj[name] = arr;
				}
				arr.push(value);
			} else {
				obj[name] = value;
			}
		});
		return o;
	};
	$.fn.onlyNumber = function() {
		$(this).keypress(function(e) {
			var key = e.which;
			if (key == 0 || key == 13 || key == 8 || (key >= 48 && key <= 57)) {
				return true;
			}
			return false;
		});
		return this;
	};
	$.fn.inputSelect = function(items){
		var menu = $('<ul class="input-select">').hide().appendTo('body');
		var lis;
		var input;
		var timer = null;
		var focus = 0;

		function clear(){
			menu.hide();
			clearTimeout(timer);
			timer=null;
			input=null;
		}
		function leave(){
			focus--;
			if(focus<=0){
				timer=setTimeout(function(){clear()},200);
			}
		}
		lis = items.map(function(text){
			return $('<li>').text(text).mouseenter(function(){
				var t=$(this);
				t.siblings('.active').removeClass('active');
				t.addClass('active');
			}).click(function(){
				if(input){
					input.val($(this).text()).change();
					clear();
				}
			});
		});
		menu.append(lis).mouseenter(function(){
			focus+=1;
		}).mouseleave(function(){
			leave();
		});
		this.focus(function(){
			clearTimeout(timer);
			focus=1;
			input = $(this);
			menu.width(input.width());
			var p = input.position();
			p.top += input.height()+2;
			menu.css(p);
			menu.children('.active').removeClass('active');
			var v = input.val();
			var idx = items.findIndex(function(item){
				if(item==v){
					return true;
				}
			});
			if(idx>=0){
				lis[idx].addClass('active');
			}
			menu.show();
		}).blur(function(){
			leave();
		});
		return this;
	};
	$.fn.clearButton = function (options) {
	  options = Object.assign({}, options, {
	    clearButtonHtml: "&times;",
	  });
	  
	  this.each(function(){
		  var self = $(this);
		  var clearElement = $("<span>")
		    .attr("tabindex", "-1")
		    .addClass("ui-input-clear")
		    .html(options.clearButtonHtml)
		    .appendTo(self.parent());
	
	
		  function _showClearButton() {
		    clearElement.css({ display: "inline-block" });
		  }
	
		  function _hideClearButton() {
		    clearElement.css({ display: "none" });
		  }
	
		  clearElement.position({
	    	my: "right center",
		    at: "right center",
		    of: self
		  }).click(function () {
		      self.val("").focus();
		      _hideClearButton();
		      self.trigger("clear");
		  });
		  self.on('input',(function () {
		      if (self.val() !== "") {
		        _showClearButton();
		      } else {
		        _hideClearButton();
		      }
		  }));
	
		  // show clearElement if input has some content on initialization
		  if (self.val() !== "") {
		    _showClearButton();
		  } else {
		    _hideClearButton();
		  }
	  });
	  return this;
	};
})($);
String.prototype.format = function() {
	var args = arguments;
	return this.replace(/{(\d+)}/g, function(m, i) {
		return args[i];
	});
};

String.prototype.padleft = function(size, pad) {
	if (this.length < size) {
		if (!pad) {
			pad = ' ';
		}
		var p = '';
		for (var i = 0, len = size - this.length; i < len; i++) {
			p += pad;
		}
		return p + this;
	}
	return this;
};

Array.prototype.indexOf = function(obj) {
	for (var i = 0; i < this.length; i++) {
		if (this[i] == obj) {
			return i;
		}
	}
	return -1;
}

Date.prototype.format = function(fmt) { // author: meizz
	var o = {
		"M+" : this.getMonth() + 1, // 月份
		"d+" : this.getDate(), // 日
		"h+" : this.getHours(), // 小时
		"m+" : this.getMinutes(), // 分
		"s+" : this.getSeconds(), // 秒
		"q+" : Math.floor((this.getMonth() + 3) / 3), // 季度
		"S" : this.getMilliseconds()
	};
	if (/(y+)/.test(fmt)) {
		fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
	}
	for ( var k in o)
		if (new RegExp("(" + k + ")").test(fmt))
			fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
	return fmt;
};
var LIBS = (function() {
	function clone(target, src, props) {
		if (!target) {
			target = {};
		}
		if (src) {
			if ($.isArray(props)) {
				for (var i = 0; i < props.length; i++) {
					var key = props[i];
					var v = src[key];
					var v1 = target[key];
					if (v !== undefined && v !== v1) {
						target[key] = v;
					}
				}
			} else {
				for ( var key in src) {
					var v = src[key];
					var v1 = target[key];
					if (v !== undefined && v !== v1) {
						target[key] = v;
					}
				}
			}
		}
		return target;
	}

	return {
		NUMBERS : [ '零', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十' ],
		clone : clone,
		money : function(val, digit, pad) {
			if (digit !== undefined) {
				val = this.round(val, digit, pad);
			}
			val += '';
			var sp = val.split('.', 2);
			var r = sp[0];
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(r)) {
				r = r.replace(rgx, '$1' + ',' + '$2');
			}
			if (sp.length > 1 && sp[1].length > 0) {
				r += '.' + sp[1];
			}
			return r;
		},
		split : function(str, delimit, max) {
			var i = str.indexOf(delimit);
			if (i == -1) {
				return [ str ];
			}
			var strs = [ str.substr(0, i) ];
			i += delimit.length;
			while (i < str.length) {
				var j = str.indexOf(delimit, i);
				if (j == -1 || strs.length + 1 >= max) {
					j = str.length;
				}
				strs.push(str.substring(i, j));
				i = j + delimit.length;
			}
			return strs;
		},
		round : function(val, digit, pad) {
			if (val == null) {
				return null;
			}
			if (!digit) {
				digit = 0;
			}
			var e = Math.pow(10, digit);
			val = Math.round(val * e) / e;
			if (digit > 0 && pad) {
				val += '';
				var c = val.indexOf('.');
				if (c == -1) {
					c = val.length;
					val += '.';
				}
				for (var i = 0, len = digit - (val.length - c - 1); i < len; i++) {
					val += '0';
				}
			}
			return val;
		},

		combination : function(n, m) {
			if (n <= m) {
				return 1;
			}
			if (n == m + 1) {
				return n;
			}
			var t = n;
			for (var i = n - 1; i > n - m; i--) {
				t *= i;
			}

			for (var i = m; i > 1; i--) {
				t /= i;
			}
			return t;
		},

		replaceArray : function(a, o) {
			if (o) {
				var b = [];
				for (var i = 0; i < a.length; i++) {
					var r = o[a[i]];
					if (r == null) {
						b.push(a[i]);
					} else {
						b.push(r);
					}
				}
			}
			return b;
		},

		comboArray : function(elements, m, n) {
			if (n == null) {
				n = elements.length;
			}
			if (m < 1 || n < 1 || m > n) {
				return;
			}

			var result = [];

			var indexs = [];
			for (var i = 0; i < m; i++) {
				indexs[i] = i;
			}
			while (true) {
				var item = [];
				for (var i = 0; i < m; i++) {
					item[i] = elements[indexs[i]];
				}
				item.count = item[0].count;
				for (var k = 1, c = item.length; k < c; k++) {
					item.count *= item[k].count;
				}
				result[result.length] = item;

				for (var i = m - 1, max = i; i >= 0; i--) {
					var v = indexs[i] + 1;
					if (v >= n - max + i) {
						if (i == 0) {
							result.count = result[0].count;
							for (var k = 1, c = result.length; k < c; k++) {
								result.count += result[k].count;
							}
							return result;
						}
					} else {
						indexs[i] = v;
						for (var j = i; j < max; j++) {
							indexs[j + 1] = indexs[j] + 1;
						}
						break;
					}
				}
			}
		},
		comboOfTwoGroups : function(f) {
			if (f.length != 2) {
				return;
			}
			var c = f[0];
			var h = f[1];
			var g = h.filter(function(i) {
				return c.indexOf(i) == -1;
			});
			if (c.length < 2 && g.length < 2) {
				return;
			}
			var b = [];
			for (var e = 0; e < c.length; e++) {
				for (var d = 0; d < h.length; d++) {
					if (c[e] != h[d] && (c[e] < h[d] || h.indexOf(c[e]) == -1 || c.indexOf(h[d]) == -1)) {
						b.push([ c[e], h[d] ]);
					}
				}
			}
			return b;
		},
		comboList : function(elements) {
			var result = [];
			var indexs = [];
			var m = elements.length;
			for (var i = 0; i < m; i++) {
				indexs[i] = 0;
			}
			while (true) {
				var item = [];
				for (var i = 0; i < m; i++) {
					item[i] = elements[i][indexs[i]];
				}
				result.push(item);
				for (var i = 0; i < m; i++) {
					indexs[i] += 1;
					if (indexs[i] < elements[i].length) {
						break;
					}
					if (i == m - 1) {
						return result;
					}
					indexs[i] = 0;
				}
			}
		},

		timeToString : function(time) {
			if (time <= 0) {
				return '00:00';
			}
			var second = Math.floor(time / 1000);
			var minute = Math.floor(second / 60);
			second = second - minute * 60;
			if (minute < 10) {
				minute = '0' + minute;
			}
			if (second < 10) {
				second = '0' + second;
			}
			return '' + minute + ':' + second;
		},

		ajaxDefaultTimeout : 10000,
		ajax : function(options, retry, interval) {
			if (options && !options.timeout) {
				options.timeout = this.ajaxDefaultTimeout;
			}
			if (!retry) {
				retry = 2;
			}

			if (!interval) {
				interval = 1000;
			}

			var state = {};
			var errCount = 0;
			var errfun = options.error;
			var cmpfun = options.complete;
			var retryError = false;
			options.error = function(e, type) {
				clearTimeout(state.errTimer);
				if (type == 'timeout' || (type == 'error' && e.status == 503)) {
					errCount += 1;
					if (errCount <= retry || retry == -1) {
						delay = errCount * errCount * interval;
						state.errTimer = setTimeout(function() {
							state = clone(state, $.ajax(options));
						}, delay);
						retryError = true;
						return;
					}
				}
				if ($.isFunction(errfun)) {
					errfun.apply(this, arguments);
				}
			};
			options.complete = function() {
				if (!retryError && $.isFunction(cmpfun)) {
					cmpfun.apply(this, arguments);
				}
			};
			state = $.ajax(options);
			return state;
		},
		get : function(url, data, callback, type, retry, interval) {
			if (jQuery.isFunction(data)) {
				interval = retry;
				retry = type;
				type = callback;
				callback = data;
				data = undefined;
			}
			if (typeof type !== 'string' && !$.isArray(type)) {
				interval = retry;
				retry = type;
				type = undefined;
			}
			return this.ajax({
				url : url,
				type : 'get',
				dataType : type,
				data : data,
				success : callback
			}, retry, interval);
		},
		colorMoney : function(selector, minus, plus) {
			if (!minus && !plus) {
				return;
			}

			$(selector).each(function() {
				var t = $(this);
				var val = t.text();
				t.removeClass(minus).removeClass(plus);
				if (!val || val == '0') {
					return;
				}
				if (val[0] == '-' && minus) {
					t.addClass(minus);
				} else if (plus) {
					t.addClass(plus);
				}
			});
		},
		url : function(path, o) {
			if (!path) {
				return location.href;
			}
			if (o === undefined) {
				o = path;
				path = location.pathname;
			}
			var idx = path.indexOf('?');
			var strs = location.search;
			if (idx >= 0) {
				strs = path.substr(idx);
				path = path.substring(0, idx);
			}
			var url = path + '?';
			if (strs.length > 1) {
				strs = strs.substr(1).split('&');
				for (var i = 0; i < strs.length; i++) {
					if (strs[i].length == 0) {
						continue;
					}
					var info = strs[i].split('=', 2);
					if (!info[1]) {
						continue;
					}
					if (o[info[0]] === undefined) {
						o[info[0]] = decodeURIComponent(info[1]);
					}
				}
			}

			for ( var k in o) {
				if (!o[k]) {
					continue;
				}
				url += k + '=' + encodeURIComponent(o[k]) + '&';
			}
			url = url.substr(0, url.length - 1);
			return url;
		},
		getUrlParam : function(name, strs) {
			if (!strs) {
				strs = location.search;
			}
			if (strs.length > 1) {
				strs = strs.substr(1).split('&');
				for (var i = 0; i < strs.length; i++) {
					if (strs[i].length == 0) {
						continue;
					}
					var info = strs[i].split('=', 2);
					if (!info[1]) {
						continue;
					}
					if (info[0] == name) {
						return decodeURIComponent(info[1]);
					}
				}
			}
		},
		equals : function(a, b) {
			for ( var k in a) {
				if (a[k] != b[k]) {
					return false;
				}
			}
			return true;
		},
		bindFocus : function(e) {
			e.focusin(function() {
				$(this).addClass('input_focus');
			}).focusout(function() {
				$(this).removeClass('input_focus');
			});
			return e;
		},
		toMap : function(str, delimit, valdelimit) {
			if (str == null) {
				return {};
			}
			if (!delimit) {
				delimit = ';';
			}
			if (!valdelimit) {
				valdelimit = '=';
			}
			str = str.split(delimit);
			var o = {};
			for (var i = 0; i < str.length - 1; i++) {
				var info = str[i].split(valdelimit, 2);
				if (info.length != 2) {
					continue;
				}
				o[info[0]] = info[1];
			}
			return o;
		},
		cookie : function(name, value, options) {
			if (typeof value != 'undefined') { // name and value given, set
				// cookie
				options = options || {};
				if (value === null) {
					value = '';
					options.expires = -1;
				}
				var expires = '';
				if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
					var date;
					if (typeof options.expires == 'number') {
						date = new Date();
						date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
					} else {
						date = options.expires;
					}
					expires = '; expires=' + date.toUTCString(); // use
					// expires attribute, max-age is not supported by IE
				}
				var path = options.path ? '; path=' + options.path : '';
				if(name == '_skin_'){
					path = '; path=/'
				}
				var domain = options.domain ? '; domain=' + options.domain : '';
				var secure = options.secure ? '; secure' : '';
				document.cookie = [ name, '=', encodeURIComponent(value), expires, path, domain, secure ].join('');
			} else { // only name given, get cookie
				var cookieValue = null;
				if (document.cookie && document.cookie != '') {
					var cookies = document.cookie.split(';');
					for (var i = 0; i < cookies.length; i++) {
						var cookie = jQuery.trim(cookies[i]);
						// Does this cookie string begin with the name we want?
						if (cookie.substring(0, name.length + 1) == (name + '=')) {
							cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
							break;
						}
					}
				}
				return cookieValue;
			}
		},
		saveData: function (filename, data, type) {
			var element = document.createElement('a');
			element.setAttribute('href', 'data:' + type + ',' + data);
			element.setAttribute('download', filename);

			element.style.display = 'none';
			document.body.appendChild(element);

			element.click();

			document.body.removeChild(element);
		}
	};
})();
function getJSONData(c, e, d, b) {
	loadingStart();
	var a = c + "?token=" + $("#oid").val();
	if (d) {
		a += "&" + d;
	}
	$.getJSON(a).done(function(f) {
		if (e) {
			if ((f.result && f.result.data) || f.status == "0") {
				if (f.status == "0") {
					e(f, b);
				} else {
					if (b && b.startsWith("/agent/transfer/")) {
						openTransferMessage("error", f.message);
					} else {
						swal(f.message, "", "error");
					}
				}
			} else {
				if (b && b.startsWith("/agent/transfer/")) {
					openTransferMessage("error", f.message);
				} else {
					if (f.status == "success") {
						e(f.result);
					} else {
						swal(f.message, "", "error");
					}
				}
			}
		}
	}).fail(function(h, i, f) {
		var g = i + ", " + f;
		swal(h.responseJSON.message, "", "error");
	}).always(function() {
		loadingEnd();
	});
}
function loadingStart() {
	var c = $(".loading-wrapper");
	c.html("");
	var b = $('<div class="loading"><div>');
	for (var a = 0; a < 12; a++) {
		b.append('<div class="bar"><div class="dot"></div></div>');
	}
	c.append(b);
	c.addClass("active");
}
function loadingEnd() {
	var a = $(".loading-wrapper");
	a.removeClass("active");
	a.html("");
}
