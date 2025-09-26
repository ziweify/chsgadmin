function BarrettMu(e) {
    this.modulus = biCopy(e), this.k = biHighIndex(this.modulus) + 1;
    e = new BigInt;
    e.digits[2 * this.k] = 1, this.mu = biDivide(e, this.modulus), this.bkplus1 = new BigInt, this.bkplus1.digits[this.k + 1] = 1, this.modulo = BarrettMu_modulo, this.multiplyMod = BarrettMu_multiplyMod, this.powMod = BarrettMu_powMod
}

function BarrettMu_modulo(e) {
    for (var t = biDivideByRadixPower(e, this.k - 1), t = biDivideByRadixPower(biMultiply(t, this.mu), this.k + 1), i = biSubtract(biModuloByRadixPower(e, this.k + 1), biModuloByRadixPower(biMultiply(t, this.modulus), this.k + 1)), n = 0 <= biCompare(i = i.isNeg ? biAdd(i, this.bkplus1) : i, this.modulus); n;) n = 0 <= biCompare(i = biSubtract(i, this.modulus), this.modulus);
    return i
}

function BarrettMu_multiplyMod(e, t) {
    t = biMultiply(e, t);
    return this.modulo(t)
}

function BarrettMu_powMod(e, t) {
    var i = new BigInt;
    i.digits[0] = 1;
    for (var n = e, r = t; ;) {
        if (0 != (1 & r.digits[0]) && (i = this.multiplyMod(i, n)), 0 == (r = biShiftRight(r, 1)).digits[0] && 0 == biHighIndex(r)) break;
        n = this.multiplyMod(n, n)
    }
    return i
}

var biRadixBase = 2, biRadixBits = 16, bitsPerDigit = biRadixBits, biRadix = 65536, biHalfRadix = biRadix >>> 1,
    biRadixSquared = biRadix * biRadix, maxDigitVal = biRadix - 1, maxInteger = 9999999999999998, maxDigits, ZERO_ARRAY,
    bigZero, bigOne;

function setMaxDigits(e) {
    ZERO_ARRAY = new Array(maxDigits = e);
    for (var t = 0; t < ZERO_ARRAY.length; t++) ZERO_ARRAY[t] = 0;
    bigZero = new BigInt, (bigOne = new BigInt).digits[0] = 1
}

setMaxDigits(20);
var dpl10 = 15, lr10 = biFromNumber(1e15);

function BigInt(e) {
    this.digits = "boolean" == typeof e && 1 == e ? null : ZERO_ARRAY.slice(0), this.isNeg = !1
}

function biFromDecimal(e) {
    for (var t, i = "-" == e.charAt(0), n = i ? 1 : 0; n < e.length && "0" == e.charAt(n);) ++n;
    if (n == e.length) t = new BigInt; else {
        var r = (e.length - n) % dpl10;
        for (0 == r && (r = dpl10), t = biFromNumber(Number(e.substr(n, r))), n += r; n < e.length;) t = biAdd(biMultiply(t, lr10), biFromNumber(Number(e.substr(n, dpl10)))), n += dpl10;
        t.isNeg = i
    }
    return t
}

function biCopy(e) {
    var t = new BigInt(!0);
    return t.digits = e.digits.slice(0), t.isNeg = e.isNeg, t
}

function biFromNumber(e) {
    var t = new BigInt;
    t.isNeg = e < 0, e = Math.abs(e);
    for (var i = 0; 0 < e;) t.digits[i++] = e & maxDigitVal, e = Math.floor(e / biRadix);
    return t
}

function reverseStr(e) {
    for (var t = "", i = e.length - 1; -1 < i; --i) t += e.charAt(i);
    return t
}

var hexatrigesimalToChar = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

function biToString(e, t) {
    var i = new BigInt;
    i.digits[0] = t;
    for (var n = biDivideModulo(e, i), r = hexatrigesimalToChar[n[1].digits[0]]; 1 == biCompare(n[0], bigZero);) n = biDivideModulo(n[0], i), digit = n[1].digits[0], r += hexatrigesimalToChar[n[1].digits[0]];
    return (e.isNeg ? "-" : "") + reverseStr(r)
}

function biToDecimal(e) {
    var t = new BigInt;
    t.digits[0] = 10;
    for (var i = biDivideModulo(e, t), n = String(i[1].digits[0]); 1 == biCompare(i[0], bigZero);) i = biDivideModulo(i[0], t), n += String(i[1].digits[0]);
    return (e.isNeg ? "-" : "") + reverseStr(n)
}

var hexToChar = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");

function digitToHex(e) {
    var t = "";
    for (i = 0; i < 4; ++i) t += hexToChar[15 & e], e >>>= 4;
    return reverseStr(t)
}

function biToHex(e) {
    for (var t = "", i = (biHighIndex(e), biHighIndex(e)); -1 < i; --i) t += digitToHex(e.digits[i]);
    return t
}

function charToHex(e) {
    e = 48 <= e && e <= 57 ? e - 48 : 65 <= e && e <= 90 ? 10 + e - 65 : 97 <= e && e <= 122 ? 10 + e - 97 : 0;
    return e
}

function hexToDigit(e) {
    for (var t = 0, i = Math.min(e.length, 4), n = 0; n < i; ++n) t <<= 4, t |= charToHex(e.charCodeAt(n));
    return t
}

function biFromHex(e) {
    for (var t = new BigInt, i = e.length, n = 0; 0 < i; i -= 4, ++n) t.digits[n] = hexToDigit(e.substr(Math.max(i - 4, 0), Math.min(i, 4)));
    return t
}

function biFromString(e, t) {
    var i = "-" == e.charAt(0), n = i ? 1 : 0, r = new BigInt;
    (s = new BigInt).digits[0] = 1;
    for (var a = e.length - 1; n <= a; a--) var r = biAdd(r, biMultiplyDigit(s, charToHex(e.charCodeAt(a)))), s = biMultiplyDigit(s, t);
    return r.isNeg = i, r
}

function biDump(e) {
    return (e.isNeg ? "-" : "") + e.digits.join(" ")
}

function biAdd(e, t) {
    if (e.isNeg != t.isNeg) t.isNeg = !t.isNeg, n = biSubtract(e, t), t.isNeg = !t.isNeg; else {
        for (var i, n = new BigInt, r = 0, a = 0; a < e.digits.length; ++a) i = e.digits[a] + t.digits[a] + r, n.digits[a] = i % biRadix, r = Number(biRadix <= i);
        n.isNeg = e.isNeg
    }
    return n
}

function biSubtract(e, t) {
    if (e.isNeg != t.isNeg) t.isNeg = !t.isNeg, n = biAdd(e, t), t.isNeg = !t.isNeg; else {
        for (var i, n = new BigInt, r = a = 0; r < e.digits.length; ++r) i = e.digits[r] - t.digits[r] + a, n.digits[r] = i % biRadix, n.digits[r] < 0 && (n.digits[r] += biRadix), a = 0 - Number(i < 0);
        if (-1 == a) {
            for (var a = 0, r = 0; r < e.digits.length; ++r) i = 0 - n.digits[r] + a, n.digits[r] = i % biRadix, n.digits[r] < 0 && (n.digits[r] += biRadix), a = 0 - Number(i < 0);
            n.isNeg = !e.isNeg
        } else n.isNeg = e.isNeg
    }
    return n
}

function biHighIndex(e) {
    for (var t = e.digits.length - 1; 0 < t && 0 == e.digits[t];) --t;
    return t
}

function biNumBits(e) {
    for (var t = biHighIndex(e), i = e.digits[t], n = (t + 1) * bitsPerDigit, r = n; n - bitsPerDigit < r && 0 == (32768 & i); --r) i <<= 1;
    return r
}

function biMultiply(e, t) {
    for (var i, n, r, a = new BigInt, s = biHighIndex(e), o = biHighIndex(t), l = 0; l <= o; ++l) {
        for (r = l, j = i = 0; j <= s; ++j, ++r) n = a.digits[r] + e.digits[j] * t.digits[l] + i, a.digits[r] = n & maxDigitVal, i = n >>> biRadixBits;
        a.digits[l + s + 1] = i
    }
    return a.isNeg = e.isNeg != t.isNeg, a
}

function biMultiplyDigit(e, t) {
    var i;
    result = new BigInt;
    for (var n = biHighIndex(e), r = 0, a = 0; a <= n; ++a) i = result.digits[a] + e.digits[a] * t + r, result.digits[a] = i & maxDigitVal, r = i >>> biRadixBits;
    return result.digits[1 + n] = r, result
}

function arrayCopy(e, t, i, n, r) {
    for (var a = Math.min(t + r, e.length), s = t, o = n; s < a; ++s, ++o) i[o] = e[s]
}

var highBitMasks = new Array(0, 32768, 49152, 57344, 61440, 63488, 64512, 65024, 65280, 65408, 65472, 65504, 65520, 65528, 65532, 65534, 65535);

function biShiftLeft(e, t) {
    var i = Math.floor(t / bitsPerDigit), n = new BigInt;
    arrayCopy(e.digits, 0, n.digits, i, n.digits.length - i);
    for (var r = t % bitsPerDigit, a = bitsPerDigit - r, s = n.digits.length - 1, o = s - 1; 0 < s; --s, --o) n.digits[s] = n.digits[s] << r & maxDigitVal | (n.digits[o] & highBitMasks[r]) >>> a;
    return n.digits[0] = n.digits[s] << r & maxDigitVal, n.isNeg = e.isNeg, n
}

var lowBitMasks = new Array(0, 1, 3, 7, 15, 31, 63, 127, 255, 511, 1023, 2047, 4095, 8191, 16383, 32767, 65535),
    requirejs, require, define;

function biShiftRight(e, t) {
    var i = Math.floor(t / bitsPerDigit), n = new BigInt;
    arrayCopy(e.digits, i, n.digits, 0, e.digits.length - i);
    for (var r = t % bitsPerDigit, a = bitsPerDigit - r, s = 0, o = s + 1; s < n.digits.length - 1; ++s, ++o) n.digits[s] = n.digits[s] >>> r | (n.digits[o] & lowBitMasks[r]) << a;
    return n.digits[n.digits.length - 1] >>>= r, n.isNeg = e.isNeg, n
}

function biMultiplyByRadixPower(e, t) {
    var i = new BigInt;
    return arrayCopy(e.digits, 0, i.digits, t, i.digits.length - t), i
}

function biDivideByRadixPower(e, t) {
    var i = new BigInt;
    return arrayCopy(e.digits, t, i.digits, 0, i.digits.length - t), i
}

function biModuloByRadixPower(e, t) {
    var i = new BigInt;
    return arrayCopy(e.digits, 0, i.digits, 0, t), i
}

function biCompare(e, t) {
    if (e.isNeg != t.isNeg) return 1 - 2 * Number(e.isNeg);
    for (var i = e.digits.length - 1; 0 <= i; --i) if (e.digits[i] != t.digits[i]) return e.isNeg ? 1 - 2 * Number(e.digits[i] > t.digits[i]) : 1 - 2 * Number(e.digits[i] < t.digits[i]);
    return 0
}

function biDivideModulo(e, t) {
    var i = biNumBits(e), n = biNumBits(t), r = t.isNeg;
    if (i < n) return e.isNeg ? ((a = biCopy(bigOne)).isNeg = !t.isNeg, e.isNeg = !1, t.isNeg = !1, s = biSubtract(t, e), e.isNeg = !0, t.isNeg = r) : (a = new BigInt, s = biCopy(e)), new Array(a, s);
    for (var a = new BigInt, s = e, o = Math.ceil(n / bitsPerDigit) - 1, l = 0; t.digits[o] < biHalfRadix;) t = biShiftLeft(t, 1), ++l, ++n, o = Math.ceil(n / bitsPerDigit) - 1;
    s = biShiftLeft(s, l), i += l;
    for (var u = Math.ceil(i / bitsPerDigit) - 1, d = biMultiplyByRadixPower(t, u - o); -1 != biCompare(s, d);) ++a.digits[u - o], s = biSubtract(s, d);
    for (var c = u; o < c; --c) {
        var h = c >= s.digits.length ? 0 : s.digits[c], f = c - 1 >= s.digits.length ? 0 : s.digits[c - 1],
            p = c - 2 >= s.digits.length ? 0 : s.digits[c - 2], m = o >= t.digits.length ? 0 : t.digits[o],
            g = o - 1 >= t.digits.length ? 0 : t.digits[o - 1];
        a.digits[c - o - 1] = h == m ? maxDigitVal : Math.floor((h * biRadix + f) / m);
        for (var v = a.digits[c - o - 1] * (m * biRadix + g), y = h * biRadixSquared + (f * biRadix + p); y < v;) --a.digits[c - o - 1], v = a.digits[c - o - 1] * (m * biRadix | g), y = h * biRadix * biRadix + (f * biRadix + p);
        (s = biSubtract(s, biMultiplyDigit(d = biMultiplyByRadixPower(t, c - o - 1), a.digits[c - o - 1]))).isNeg && (s = biAdd(s, d), --a.digits[c - o - 1])
    }
    return s = biShiftRight(s, l), a.isNeg = e.isNeg != r, e.isNeg && (a = (r ? biAdd : biSubtract)(a, bigOne), s = biSubtract(t = biShiftRight(t, l), s)), 0 == s.digits[0] && 0 == biHighIndex(s) && (s.isNeg = !1), new Array(a, s)
}

function biDivide(e, t) {
    return biDivideModulo(e, t)[0]
}

function biModulo(e, t) {
    return biDivideModulo(e, t)[1]
}

function biMultiplyMod(e, t, i) {
    return biModulo(biMultiply(e, t), i)
}

function biPow(e, t) {
    for (var i = bigOne, n = e; ;) {
        if (0 != (1 & t) && (i = biMultiply(i, n)), 0 == (t >>= 1)) break;
        n = biMultiply(n, n)
    }
    return i
}

function biPowMod(e, t, i) {
    for (var n = bigOne, r = e, a = t; ;) {
        if (0 != (1 & a.digits[0]) && (n = biMultiplyMod(n, r, i)), 0 == (a = biShiftRight(a, 1)).digits[0] && 0 == biHighIndex(a)) break;
        r = biMultiplyMod(r, r, i)
    }
    return n
}

function RSAKeyPair(e, t, i) {
    this.e = biFromHex(e), this.d = biFromHex(t), this.m = biFromHex(i), this.digitSize = 2 * biHighIndex(this.m) + 2, this.chunkSize = this.digitSize - 11, this.radix = 16, this.barrett = new BarrettMu(this.m)
}

function twoDigit(e) {
    return (e < 10 ? "0" : "") + String(e)
}

function encryptedString(e, t) {
    if (e.chunkSize > e.digitSize - 11) return "Error";
    for (var i = new Array, n = t.length, r = 0; r < n;) i[r] = t.charCodeAt(r), r++;
    for (var a, s = i.length, o = "", r = 0; r < s; r += e.chunkSize) {
        for (var l = new BigInt, u = 0, d = r + e.chunkSize > s ? s % e.chunkSize : e.chunkSize, c = new Array, h = 0; h < d; h++) c[h] = i[r + d - 1 - h];
        c[d] = 0;
        var f = Math.max(8, e.digitSize - 3 - d);
        for (h = 0; h < f; h++) c[d + 1 + h] = Math.floor(254 * Math.random()) + 1;
        for (c[e.digitSize - 2] = 2, a = c[e.digitSize - 1] = 0; a < e.digitSize; ++u) l.digits[u] = c[a++], l.digits[u] += c[a++] << 8;
        var p = e.barrett.powMod(l, e.e);
        o += (16 == e.radix ? biToHex(p) : biToString(p, e.radix)) + " "
    }
    return o.substring(0, o.length - 1)
}

function decryptedString(e, t) {
    for (var i = t.split(" "), n = "", r = 0; r < i.length; ++r) for (var a = 16 == e.radix ? biFromHex(i[r]) : biFromString(i[r], e.radix), s = e.barrett.powMod(a, e.d), o = 0; o <= biHighIndex(s); ++o) n += String.fromCharCode(255 & s.digits[o], s.digits[o] >> 8);
    return n = 0 == n.charCodeAt(n.length - 1) ? n.substring(0, n.length - 1) : n
}

function callSecret(e) {
    return callSecretBase(e).vk
}

function callSecretBase(i) {
    var n, r, a = "";
    return $.ajax({
        url: SESSIONID + "/Member/GetPublicKey",
        type: "post",
        dataType: "json",
        "async": !1,
        success: function (e) {
            var t;
            1 == e.Status ? (n = e.Data.m, r = e.Data.e, a = e.Data.e + "," + e.Data.m, setMaxDigits(1290), t = new RSAKeyPair(r, "", n), vk = encryptedString(t, i)) : alert(e.Data)
        }
    }), {vk: vk, logpk: a}
}

function makeid() {
    for (var e = "", t = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", i = 0; i < 5; i++) e += t.charAt(Math.floor(Math.random() * t.length));
    return e
}

function GK() {
    $.ajax({
        url: SESSIONID + "/Member/GK", type: "post", dataType: "json", success: function (e) {
        }
    })
}

!function (c) {
    "use strict";
    var h, u, e, i = c.layui && layui.define, d = {
        getPath: (e = document.currentScript ? document.currentScript.src : function () {
            for (var e, t = document.scripts, i = t.length - 1, n = i; 0 < n; n--) if ("interactive" === t[n].readyState) {
                e = t[n].src;
                break
            }
            return e || t[i].src
        }()).substring(0, e.lastIndexOf("/") + 1),
        config: {},
        end: {},
        minIndex: 0,
        minLeft: [],
        btn: ["&#x786E;&#x5B9A;", "&#x53D6;&#x6D88;"],
        type: ["dialog", "page", "iframe", "loading", "tips"],
        getStyle: function (e, t) {
            e = e.currentStyle || c.getComputedStyle(e, null);
            return e[e.getPropertyValue ? "getPropertyValue" : "getAttribute"](t)
        },
        link: function (e, t, i) {
            var n, r, a, s;
            f.path && (n = document.getElementsByTagName("head")[0], r = document.createElement("link"), a = "layuicss-" + ((i = "string" == typeof t ? t : i) || e).replace(/\.|\//g, ""), s = 0, r.rel = "stylesheet", r.href = e, r.id = a, document.getElementById(a) || n.appendChild(r), "function" == typeof t && function o() {
                return 80 < ++s ? c.console && console.error("layer.css: Invalid") : void (1989 === parseInt(d.getStyle(document.getElementById(a), "width")) ? t() : setTimeout(o, 100))
            }())
        }
    }, f = {
        v: "3.1.1",
        ie: (e = navigator.userAgent.toLowerCase(), !!(c.ActiveXObject || "ActiveXObject" in c) && ((e.match(/msie\s(\d+)/) || [])[1] || "11")),
        index: c.layer && c.layer.v ? 1e5 : 0,
        path: d.getPath,
        config: function (e, t) {
            return f.cache = d.config = h.extend({}, d.config, e = e || {}), f.path = d.config.path || f.path, "string" == typeof e.extend && (e.extend = [e.extend]), d.config.path && f.ready(), e.extend && (i ? layui.addcss("modules/layer/" + e.extend) : d.link("theme/" + e.extend)), this
        },
        ready: function (e) {
            var t = (i ? "modules/layer/" : "/Scripts/App/Plugins/Layer/theme/") + "default/layer.css?v=" + f.v;
            return i ? layui.addcss(t, e, "layer") : d.link(t, e, "layer"), this
        },
        alert: function (e, t, i) {
            var n = "function" == typeof t;
            return f.open(h.extend({content: e, yes: i = n ? t : i}, n ? {} : t))
        },
        confirm: function (e, t, i, n) {
            var r = "function" == typeof t;
            return r && (n = i, i = t), f.open(h.extend({content: e, btn: d.btn, yes: i, btn2: n}, r ? {} : t))
        },
        msg: function (e, t, i) {
            var n = "function" == typeof t, r = d.config.skin, a = (r ? r + " " + r + "-msg" : "") || "layui-layer-msg",
                r = p.anim.length - 1;
            return n && (i = t), f.open(h.extend({
                content: e,
                time: 3e3,
                shade: !1,
                skin: a,
                title: !1,
                closeBtn: !1,
                btn: !1,
                resize: !1,
                end: i
            }, n && !d.config.skin ? {
                skin: a + " layui-layer-hui",
                anim: r
            } : (-1 !== (t = t || {}).icon && (void 0 !== t.icon || d.config.skin) || (t.skin = a + " " + (t.skin || "layui-layer-hui")), t)))
        },
        load: function (e, t) {
            return f.open(h.extend({type: 3, icon: e || 0, resize: !1, shade: .01}, t))
        },
        tips: function (e, t, i) {
            return f.open(h.extend({
                type: 4,
                content: [e, t],
                closeBtn: !1,
                time: 3e3,
                shade: !1,
                resize: !1,
                fixed: !1,
                maxWidth: 210
            }, i))
        }
    }, t = function (e) {
        var t = this;
        t.index = ++f.index, t.config = h.extend({}, t.config, d.config, e), document.body ? t.creat() : setTimeout(function () {
            t.creat()
        }, 30)
    };
    t.pt = t.prototype;
    var p = ["layui-layer", ".layui-layer-title", ".layui-layer-main", ".layui-layer-dialog", "layui-layer-iframe", "layui-layer-content", "layui-layer-btn", "layui-layer-close"];
    p.anim = ["layer-anim-00", "layer-anim-01", "layer-anim-02", "layer-anim-03", "layer-anim-04", "layer-anim-05", "layer-anim-06"], t.pt.config = {
        type: 0,
        shade: .3,
        fixed: !0,
        move: p[1],
        title: "&#x4FE1;&#x606F;",
        offset: "auto",
        area: "auto",
        closeBtn: 1,
        time: 0,
        zIndex: 19891014,
        maxWidth: 360,
        anim: 0,
        isOutAnim: !0,
        icon: -1,
        moveType: 1,
        resize: !0,
        scrollbar: !0,
        tips: 2
    }, t.pt.vessel = function (e, t) {
        var i = this.index, n = this.config, r = n.zIndex + i, a = "object" == typeof n.title,
            s = n.maxmin && (1 === n.type || 2 === n.type),
            a = n.title ? '<div class="layui-layer-title" style="' + (a ? n.title[1] : "") + '">' + (a ? n.title[0] : n.title) + "</div>" : "";
        return n.zIndex = r, t([n.shade ? '<div class="layui-layer-shade" id="layui-layer-shade' + i + '" times="' + i + '" style="z-index:' + (r - 1) + '; "></div>' : "", '<div class="' + p[0] + " layui-layer-" + d.type[n.type] + (0 != n.type && 2 != n.type || n.shade ? "" : " layui-layer-border") + " " + (n.skin || "") + '" id="' + p[0] + i + '" type="' + d.type[n.type] + '" times="' + i + '" showtime="' + n.time + '" conType="' + (e ? "object" : "string") + '" style="z-index: ' + r + "; width:" + n.area[0] + ";height:" + n.area[1] + (n.fixed ? "" : ";position:absolute;") + '">' + (e && 2 != n.type ? "" : a) + '<div id="' + (n.id || "") + '" class="layui-layer-content' + (0 == n.type && -1 !== n.icon ? " layui-layer-padding" : "") + (3 == n.type ? " layui-layer-loading" + n.icon : "") + '">' + (0 == n.type && -1 !== n.icon ? '<i class="layui-layer-ico layui-layer-ico' + n.icon + '"></i>' : "") + ((1 != n.type || !e) && n.content || "") + '</div><span class="layui-layer-setwin">' + (s = s ? '<a class="layui-layer-min" href="javascript:;"><cite></cite></a><a class="layui-layer-ico layui-layer-max" href="javascript:;"></a>' : "", n.closeBtn && (s += '<a class="layui-layer-ico ' + p[7] + " " + p[7] + (n.title ? n.closeBtn : 4 == n.type ? "1" : "2") + '" href="javascript:;"></a>'), s) + "</span>" + (n.btn ? function () {
            var e = "";
            "string" == typeof n.btn && (n.btn = [n.btn]);
            for (var t = 0, i = n.btn.length; t < i; t++) e += '<a href="javascript:///" class="' + p[6] + t + '">' + n.btn[t] + "</a>";
            return '<div class="' + p[6] + " layui-layer-btn-" + (n.btnAlign || "") + '">' + e + "</div>"
        }() : "") + (n.resize ? '<span class="layui-layer-resize"></span>' : "") + "</div>"], a, h('<div class="layui-layer-move"></div>')), this
    }, t.pt.creat = function () {
        var e, n = this, r = n.config, a = n.index, s = "object" == typeof (l = r.content), o = h("body");
        if (!r.id || !h("#" + r.id)[0]) {
            switch ("string" == typeof r.area && (r.area = "auto" === r.area ? ["", ""] : [r.area, ""]), r.shift && (r.anim = r.shift), 6 == f.ie && (r.fixed = !1), r.type) {
                case 0:
                    r.btn = "btn" in r ? r.btn : d.btn[0], f.closeAll("dialog");
                    break;
                case 2:
                    var l = r.content = s ? r.content : [r.content || "http://layer.layui.com", "auto"];
                    r.content = '<iframe scrolling="' + (r.content[1] || "auto") + '" allowtransparency="true" id="' + p[4] + a + '" name="' + p[4] + a + '" onload="this.className=\'\';" class="layui-layer-load" frameborder="0" src="' + r.content[0] + '"></iframe>';
                    break;
                case 3:
                    delete r.title, delete r.closeBtn, -1 === r.icon && r.icon, f.closeAll("loading");
                    break;
                case 4:
                    s || (r.content = [r.content, "body"]), r.follow = r.content[1], r.content = r.content[0] + '<i class="layui-layer-TipsG"></i>', delete r.title, r.tips = "object" == typeof r.tips ? r.tips : [r.tips, !0], r.tipsMore || f.closeAll("tips")
            }
            n.vessel(s, function (e, t, i) {
                o.append(e[0]), s ? 2 == r.type || 4 == r.type ? h("body").append(e[1]) : l.parents("." + p[0])[0] || (l.data("display", l.css("display")).show().addClass("layui-layer-wrap").wrap(e[1]), h("#" + p[0] + a).find("." + p[5]).before(t)) : o.append(e[1]), h(".layui-layer-move")[0] || o.append(d.moveElem = i), n.layero = h("#" + p[0] + a), r.scrollbar || p.html.css("overflow", "hidden").attr("layer-full", a)
            }).auto(a), h("#layui-layer-shade" + n.index).css({
                "background-color": r.shade[1] || "#000",
                opacity: r.shade[0] || r.shade
            }), 2 == r.type && 6 == f.ie && n.layero.find("iframe").attr("src", l[0]), 4 == r.type ? n.tips() : n.offset(), r.fixed && u.on("resize", function () {
                n.offset(), (/^\d+%$/.test(r.area[0]) || /^\d+%$/.test(r.area[1])) && n.auto(a), 4 == r.type && n.tips()
            }), r.time <= 0 || setTimeout(function () {
                f.close(n.index)
            }, r.time), n.move().callback(), p.anim[r.anim] && (e = "layer-anim " + p.anim[r.anim], n.layero.addClass(e).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
                h(this).removeClass(e)
            })), r.isOutAnim && n.layero.data("isOutAnim", !0)
        }
    }, t.pt.auto = function (e) {
        var t = this.config, i = h("#" + p[0] + e);
        "" === t.area[0] && 0 < t.maxWidth && (f.ie && f.ie < 8 && t.btn && i.width(i.innerWidth()), i.outerWidth() > t.maxWidth && i.width(t.maxWidth));
        var n = [i.innerWidth(), i.innerHeight()], r = i.find(p[1]).outerHeight() || 0,
            a = i.find("." + p[6]).outerHeight() || 0, e = function (e) {
                (e = i.find(e)).height(n[1] - r - a - 2 * (0 | parseFloat(e.css("padding-top"))))
            };
        return 2 === t.type ? e("iframe") : "" === t.area[1] ? 0 < t.maxHeight && i.outerHeight() > t.maxHeight ? (n[1] = t.maxHeight, e("." + p[5])) : t.fixed && n[1] >= u.height() && (n[1] = u.height(), e("." + p[5])) : e("." + p[5]), this
    }, t.pt.offset = function () {
        var e = this, t = e.config, i = e.layero, n = [i.outerWidth(), i.outerHeight()],
            r = "object" == typeof t.offset;
        e.offsetTop = (u.height() - n[1]) / 2, e.offsetLeft = (u.width() - n[0]) / 2, r ? (e.offsetTop = t.offset[0], e.offsetLeft = t.offset[1] || e.offsetLeft) : "auto" !== t.offset && ("t" === t.offset ? e.offsetTop = 0 : "r" === t.offset ? e.offsetLeft = u.width() - n[0] : "b" === t.offset ? e.offsetTop = u.height() - n[1] : "l" === t.offset ? e.offsetLeft = 0 : "lt" === t.offset ? (e.offsetTop = 0, e.offsetLeft = 0) : "lb" === t.offset ? (e.offsetTop = u.height() - n[1], e.offsetLeft = 0) : "rt" === t.offset ? (e.offsetTop = 0, e.offsetLeft = u.width() - n[0]) : "rb" === t.offset ? (e.offsetTop = u.height() - n[1], e.offsetLeft = u.width() - n[0]) : e.offsetTop = t.offset), t.fixed || (e.offsetTop = /%$/.test(e.offsetTop) ? u.height() * parseFloat(e.offsetTop) / 100 : parseFloat(e.offsetTop), e.offsetLeft = /%$/.test(e.offsetLeft) ? u.width() * parseFloat(e.offsetLeft) / 100 : parseFloat(e.offsetLeft), e.offsetTop += u.scrollTop(), e.offsetLeft += u.scrollLeft()), i.attr("minLeft") && (e.offsetTop = u.height() - (i.find(p[1]).outerHeight() || 0), e.offsetLeft = i.css("left")), i.css({
            top: e.offsetTop,
            left: e.offsetLeft
        })
    }, t.pt.tips = function () {
        var e = this.config, t = this.layero, i = [t.outerWidth(), t.outerHeight()], n = h(e.follow), r = {
            width: (n = !n[0] ? h("body") : n).outerWidth(),
            height: n.outerHeight(),
            top: n.offset().top,
            left: n.offset().left
        }, a = t.find(".layui-layer-TipsG"), n = e.tips[0];
        e.tips[1] || a.remove(), r.autoLeft = function () {
            0 < r.left + i[0] - u.width() ? (r.tipLeft = r.left + r.width - i[0], a.css({
                right: 12,
                left: "auto"
            })) : r.tipLeft = r.left
        }, r.where = [function () {
            r.autoLeft(), r.tipTop = r.top - i[1] - 10, a.removeClass("layui-layer-TipsB").addClass("layui-layer-TipsT").css("border-right-color", e.tips[1])
        }, function () {
            r.tipLeft = r.left + r.width + 10, r.tipTop = r.top, a.removeClass("layui-layer-TipsL").addClass("layui-layer-TipsR").css("border-bottom-color", e.tips[1])
        }, function () {
            r.autoLeft(), r.tipTop = r.top + r.height + 10, a.removeClass("layui-layer-TipsT").addClass("layui-layer-TipsB").css("border-right-color", e.tips[1])
        }, function () {
            r.tipLeft = r.left - i[0] - 10, r.tipTop = r.top, a.removeClass("layui-layer-TipsR").addClass("layui-layer-TipsL").css("border-bottom-color", e.tips[1])
        }], r.where[n - 1](), 1 === n ? r.top - (u.scrollTop() + i[1] + 16) < 0 && r.where[2]() : 2 === n ? 0 < u.width() - (r.left + r.width + i[0] + 16) || r.where[3]() : 3 === n ? 0 < r.top - u.scrollTop() + r.height + i[1] + 16 - u.height() && r.where[0]() : 4 === n && 0 < i[0] + 16 - r.left && r.where[1](), t.find("." + p[5]).css({
            "background-color": e.tips[1],
            "padding-right": e.closeBtn ? "30px" : ""
        }), t.css({left: r.tipLeft - (e.fixed ? u.scrollLeft() : 0), top: r.tipTop - (e.fixed ? u.scrollTop() : 0)})
    }, t.pt.move = function () {
        var a = this, s = a.config, e = h(document), o = a.layero, t = o.find(s.move),
            i = o.find(".layui-layer-resize"), l = {};
        return s.move && t.css("cursor", "move"), t.on("mousedown", function (e) {
            e.preventDefault(), s.move && (l.moveStart = !0, l.offset = [e.clientX - parseFloat(o.css("left")), e.clientY - parseFloat(o.css("top"))], d.moveElem.css("cursor", "move").show())
        }), i.on("mousedown", function (e) {
            e.preventDefault(), l.resizeStart = !0, l.offset = [e.clientX, e.clientY], l.area = [o.outerWidth(), o.outerHeight()], d.moveElem.css("cursor", "se-resize").show()
        }), e.on("mousemove", function (e) {
            var t, i, n, r;
            l.moveStart && (n = e.clientX - l.offset[0], r = e.clientY - l.offset[1], i = "fixed" === o.css("position"), e.preventDefault(), l.stX = i ? 0 : u.scrollLeft(), l.stY = i ? 0 : u.scrollTop(), s.moveOut || (t = u.width() - o.outerWidth() + l.stX, i = u.height() - o.outerHeight() + l.stY, t < (n = n < l.stX ? l.stX : n) && (n = t), i < (r = r < l.stY ? l.stY : r) && (r = i)), o.css({
                left: n,
                top: r
            })), s.resize && l.resizeStart && (n = e.clientX - l.offset[0], r = e.clientY - l.offset[1], e.preventDefault(), f.style(a.index, {
                width: l.area[0] + n,
                height: l.area[1] + r
            }), l.isResize = !0, s.resizing && s.resizing(o))
        }).on("mouseup", function (e) {
            l.moveStart && (delete l.moveStart, d.moveElem.hide(), s.moveEnd && s.moveEnd(o)), l.resizeStart && (delete l.resizeStart, d.moveElem.hide())
        }), a
    }, t.pt.callback = function () {
        var t = this, i = t.layero, n = t.config;
        t.openLayer(), n.success && (2 == n.type ? i.find("iframe").on("load", function () {
            n.success(i, t.index)
        }) : n.success(i, t.index)), 6 == f.ie && t.IE6(i), i.find("." + p[6]).children("a").on("click", function () {
            var e = h(this).index();
            0 === e ? n.yes ? n.yes(t.index, i) : n.btn1 ? n.btn1(t.index, i) : f.close(t.index) : !1 === (n["btn" + (e + 1)] && n["btn" + (e + 1)](t.index, i)) || f.close(t.index)
        }), i.find("." + p[7]).on("click", function () {
            !1 === (n.cancel && n.cancel(t.index, i)) || f.close(t.index)
        }), n.shadeClose && h("#layui-layer-shade" + t.index).on("click", function () {
            f.close(t.index)
        }), i.find(".layui-layer-min").on("click", function () {
            !1 === (n.min && n.min(i)) || f.min(t.index, n)
        }), i.find(".layui-layer-max").on("click", function () {
            h(this).hasClass("layui-layer-maxmin") ? (f.restore(t.index), n.restore && n.restore(i)) : (f.full(t.index, n), setTimeout(function () {
                n.full && n.full(i)
            }, 100))
        }), n.end && (d.end[t.index] = n.end)
    }, d.reselect = function () {
        h.each(h("select"), function (e, t) {
            var i = h(this);
            i.parents("." + p[0])[0] || 1 == i.attr("layer") && h("." + p[0]).length < 1 && i.removeAttr("layer").show()
        })
    }, t.pt.IE6 = function (e) {
        h("select").each(function (e, t) {
            var i = h(this);
            i.parents("." + p[0])[0] || "none" === i.css("display") || i.attr({layer: "1"}).hide()
        })
    }, t.pt.openLayer = function () {
        f.zIndex = this.config.zIndex, f.setTop = function (e) {
            return f.zIndex = parseInt(e[0].style.zIndex), e.on("mousedown", function () {
                f.zIndex++, e.css("z-index", f.zIndex + 1)
            }), f.zIndex
        }
    }, d.record = function (e) {
        var t = [e.width(), e.height(), e.position().top, e.position().left + parseFloat(e.css("margin-left"))];
        e.find(".layui-layer-max").addClass("layui-layer-maxmin"), e.attr({area: t})
    }, d.rescollbar = function (e) {
        p.html.attr("layer-full") == e && (p.html[0].style.removeProperty ? p.html[0].style.removeProperty("overflow") : p.html[0].style.removeAttribute("overflow"), p.html.removeAttr("layer-full"))
    }, (c.layer = f).getChildFrame = function (e, t) {
        return t = t || h("." + p[4]).attr("times"), h("#" + p[0] + t).find("iframe").contents().find(e)
    }, f.getFrameIndex = function (e) {
        return h("#" + e).parents("." + p[4]).attr("times")
    }, f.iframeAuto = function (e) {
        var t, i, n;
        e && (t = f.getChildFrame("html", e).outerHeight(), n = (i = h("#" + p[0] + e)).find(p[1]).outerHeight() || 0, e = i.find("." + p[6]).outerHeight() || 0, i.css({height: t + n + e}), i.find("iframe").css({height: t}))
    }, f.iframeSrc = function (e, t) {
        h("#" + p[0] + e).find("iframe").attr("src", t)
    }, f.style = function (e, t, i) {
        var n = h("#" + p[0] + e), r = n.find(".layui-layer-content"), a = n.attr("type"),
            s = n.find(p[1]).outerHeight() || 0, e = n.find("." + p[6]).outerHeight() || 0;
        n.attr("minLeft");
        a !== d.type[3] && a !== d.type[4] && (i || (parseFloat(t.width) <= 260 && (t.width = 260), parseFloat(t.height) - s - e <= 64 && (t.height = 64 + s + e)), n.css(t), e = n.find("." + p[6]).outerHeight(), a === d.type[2] ? n.find("iframe").css({height: parseFloat(t.height) - s - e}) : r.css({height: parseFloat(t.height) - s - e - parseFloat(r.css("padding-top")) - parseFloat(r.css("padding-bottom"))}))
    }, f.min = function (e, t) {
        var i = h("#" + p[0] + e), n = i.find(p[1]).outerHeight() || 0,
            r = i.attr("minLeft") || 181 * d.minIndex + "px", a = i.css("position");
        d.record(i), d.minLeft[0] && (r = d.minLeft[0], d.minLeft.shift()), i.attr("position", a), f.style(e, {
            width: 180,
            height: n,
            left: r,
            top: u.height() - n,
            position: "fixed",
            overflow: "hidden"
        }, !0), i.find(".layui-layer-min").hide(), "page" === i.attr("type") && i.find(p[4]).hide(), d.rescollbar(e), i.attr("minLeft") || d.minIndex++, i.attr("minLeft", r)
    }, f.restore = function (e) {
        var t = h("#" + p[0] + e), i = t.attr("area").split(",");
        t.attr("type");
        f.style(e, {
            width: parseFloat(i[0]),
            height: parseFloat(i[1]),
            top: parseFloat(i[2]),
            left: parseFloat(i[3]),
            position: t.attr("position"),
            overflow: "visible"
        }, !0), t.find(".layui-layer-max").removeClass("layui-layer-maxmin"), t.find(".layui-layer-min").show(), "page" === t.attr("type") && t.find(p[4]).show(), d.rescollbar(e)
    }, f.full = function (t) {
        var i = h("#" + p[0] + t);
        d.record(i), p.html.attr("layer-full") || p.html.css("overflow", "hidden").attr("layer-full", t), clearTimeout(void 0), setTimeout(function () {
            var e = "fixed" === i.css("position");
            f.style(t, {
                top: e ? 0 : u.scrollTop(),
                left: e ? 0 : u.scrollLeft(),
                width: u.width(),
                height: u.height()
            }, !0), i.find(".layui-layer-min").hide()
        }, 100)
    }, f.title = function (e, t) {
        h("#" + p[0] + (t || f.index)).find(p[1]).html(e)
    }, f.close = function (r) {
        var a, e, s = h("#" + p[0] + r), o = s.attr("type");
        s[0] && (d.config.beforeClose && d.config.beforeClose(s), a = "layui-layer-wrap", e = function () {
            if (o === d.type[1] && "object" === s.attr("conType")) {
                s.children(":not(." + p[5] + ")").remove();
                for (var e = s.find("." + a), t = 0; t < 2; t++) e.unwrap();
                e.css("display", e.data("display")).removeClass(a)
            } else {
                if (o === d.type[2]) try {
                    var i = h("#" + p[4] + r)[0];
                    i.contentWindow.document.write(""), i.contentWindow.close(), s.find("." + p[5])[0].removeChild(i)
                } catch (n) {
                }
                s[0].innerHTML = "", s.remove()
            }
            "function" == typeof d.end[r] && d.end[r](), delete d.end[r]
        }, s.data("isOutAnim") && s.addClass("layer-anim layer-anim-close"), h("#layui-layer-moves, #layui-layer-shade" + r).remove(), 6 == f.ie && d.reselect(), d.rescollbar(r), s.attr("minLeft") && (d.minIndex--, d.minLeft.push(s.attr("minLeft"))), f.ie && f.ie < 10 || !s.data("isOutAnim") ? e() : setTimeout(function () {
            e()
        }, 200))
    }, f.closeAll = function (i) {
        h.each(h("." + p[0]), function () {
            var e = h(this), t = i ? e.attr("type") === i : 1;
            t && f.close(e.attr("times"))
        })
    };
    var n = f.cache || {}, m = function (e) {
        return n.skin ? " " + n.skin + " " + n.skin + "-" + e : ""
    };
    f.prompt = function (i, n) {
        var e, t = "";
        "function" == typeof (i = i || {}) && (n = i), i.area && (t = 'style="width: ' + (e = i.area)[0] + "; height: " + e[1] + ';"', delete i.area);
        var r,
            t = 2 == i.formType ? '<textarea class="layui-layer-input"' + t + ">" + (i.value || "") + "</textarea>" : '<input type="' + (1 == i.formType ? "password" : "text") + '" class="layui-layer-input" value="' + (i.value || "") + '">',
            a = i.success;
        return delete i.success, f.open(h.extend({
            type: 1,
            btn: ["&#x786E;&#x5B9A;", "&#x53D6;&#x6D88;"],
            content: t,
            skin: "layui-layer-prompt" + m("prompt"),
            maxWidth: u.width(),
            success: function (e) {
                (r = e.find(".layui-layer-input")).focus(), "function" == typeof a && a(e)
            },
            resize: !1,
            yes: function (e) {
                var t = r.val();
                "" === t ? r.focus() : t.length > (i.maxlength || 500) ? f.tips("&#x6700;&#x591A;&#x8F93;&#x5165;" + (i.maxlength || 500) + "&#x4E2A;&#x5B57;&#x6570;", r, {tips: 1}) : n && n(t, e, r)
            }
        }, i))
    }, f.tab = function (n) {
        var r = (n = n || {}).tab || {}, a = "layui-this", s = n.success;
        return delete n.success, f.open(h.extend({
            type: 1,
            skin: "layui-layer-tab" + m("tab"),
            resize: !1,
            title: function () {
                var e = r.length, t = 1, i = "";
                if (0 < e) for (i = '<span class="' + a + '">' + r[0].title + "</span>"; t < e; t++) i += "<span>" + r[t].title + "</span>";
                return i
            }(),
            content: '<ul class="layui-layer-tabmain">' + function () {
                var e = r.length, t = 1, i = "";
                if (0 < e) for (i = '<li class="layui-layer-tabli ' + a + '">' + (r[0].content || "no content") + "</li>"; t < e; t++) i += '<li class="layui-layer-tabli">' + (r[t].content || "no  content") + "</li>";
                return i
            }() + "</ul>",
            success: function (e) {
                var t = e.find(".layui-layer-title").children(), i = e.find(".layui-layer-tabmain").children();
                t.on("mousedown", function (e) {
                    e.stopPropagation ? e.stopPropagation() : e.cancelBubble = !0;
                    var t = h(this), e = t.index();
                    t.addClass(a).siblings().removeClass(a), i.eq(e).show().siblings().hide(), "function" == typeof n.change && n.change(e)
                }), "function" == typeof s && s(e)
            }
        }, n))
    }, f.photos = function (i, e, n) {
        var r = {};
        if ((i = i || {}).photos) {
            var t = i.photos.constructor === Object, a = t ? i.photos : {}, s = a.data || [], o = a.start || 0;
            r.imgIndex = 1 + (0 | o), i.img = i.img || "img";
            var l = i.success;
            if (delete i.success, t) {
                if (0 === s.length) return f.msg("&#x6CA1;&#x6709;&#x56FE;&#x7247;")
            } else {
                var u = h(i.photos), d = function () {
                    s = [], u.find(i.img).each(function (e) {
                        var t = h(this);
                        t.attr("layer-index", e), s.push({
                            alt: t.attr("alt"),
                            pid: t.attr("layer-pid"),
                            src: t.attr("layer-src") || t.attr("src"),
                            thumb: t.attr("src")
                        })
                    })
                };
                if (d(), 0 === s.length) return;
                if (e || u.on("click", i.img, function () {
                    var e = h(this).attr("layer-index");
                    f.photos(h.extend(i, {photos: {start: e, data: s, tab: i.tab}, full: i.full}), !0), d()
                }), !e) return
            }
            r.imgprev = function (e) {
                r.imgIndex--, r.imgIndex < 1 && (r.imgIndex = s.length), r.tabimg(e)
            }, r.imgnext = function (e, t) {
                r.imgIndex++, r.imgIndex > s.length && (r.imgIndex = 1, t) || r.tabimg(e)
            }, r.keyup = function (e) {
                var t;
                r.end || (t = e.keyCode, e.preventDefault(), 37 === t ? r.imgprev(!0) : 39 === t ? r.imgnext(!0) : 27 === t && f.close(r.index))
            }, r.tabimg = function (e) {
                if (!(s.length <= 1)) return a.start = r.imgIndex - 1, f.close(r.index), f.photos(i, !0, e)
            }, r.event = function () {
                r.bigimg.hover(function () {
                    r.imgsee.show()
                }, function () {
                    r.imgsee.hide()
                }), r.bigimg.find(".layui-layer-imgprev").on("click", function (e) {
                    e.preventDefault(), r.imgprev()
                }), r.bigimg.find(".layui-layer-imgnext").on("click", function (e) {
                    e.preventDefault(), r.imgnext()
                }), h(document).on("keyup", r.keyup)
            }, r.loadi = f.load(1, {shade: !("shade" in i) && .9, scrollbar: !1}), function (e, t, i) {
                var n = new Image;
                if (n.src = e, n.complete) return t(n);
                n.onload = function () {
                    n.onload = null, t(n)
                }, n.onerror = function (e) {
                    n.onerror = null, i(e)
                }
            }(s[o].src, function (e) {
                var t;
                f.close(r.loadi), r.index = f.open(h.extend({
                    type: 1,
                    id: "layui-layer-photos",
                    area: (t = [e.width, e.height], e = [h(c).width() - 100, h(c).height() - 100], !i.full && (t[0] > e[0] || t[1] > e[1]) && ((e = [t[0] / e[0], t[1] / e[1]])[1] < e[0] ? (t[0] = t[0] / e[0], t[1] = t[1] / e[0]) : e[0] < e[1] && (t[0] = t[0] / e[1], t[1] = t[1] / e[1])), [t[0] + "px", t[1] + "px"]),
                    title: !1,
                    shade: .9,
                    shadeClose: !0,
                    closeBtn: !1,
                    move: ".layui-layer-phimg img",
                    moveType: 1,
                    scrollbar: !1,
                    moveOut: !0,
                    isOutAnim: !1,
                    skin: "layui-layer-photos" + m("photos"),
                    content: '<div class="layui-layer-phimg"><img src="' + s[o].src + '" alt="' + (s[o].alt || "") + '" layer-pid="' + s[o].pid + '"><div class="layui-layer-imgsee">' + (1 < s.length ? '<span class="layui-layer-imguide"><a href="javascript:;" class="layui-layer-iconext layui-layer-imgprev"></a><a href="javascript:;" class="layui-layer-iconext layui-layer-imgnext"></a></span>' : "") + '<div class="layui-layer-imgbar" style="display:' + (n ? "block" : "") + '"><span class="layui-layer-imgtit"><a href="javascript:;">' + (s[o].alt || "") + "</a><em>" + r.imgIndex + "/" + s.length + "</em></span></div></div></div>",
                    success: function (e, t) {
                        r.bigimg = e.find(".layui-layer-phimg"), r.imgsee = e.find(".layui-layer-imguide,.layui-layer-imgbar"), r.event(e), i.tab && i.tab(s[o], e), "function" == typeof l && l(e)
                    },
                    end: function () {
                        r.end = !0, h(document).off("keyup", r.keyup)
                    }
                }, i))
            }, function () {
                f.close(r.loadi), f.msg("&#x5F53;&#x524D;&#x56FE;&#x7247;&#x5730;&#x5740;&#x5F02;&#x5E38;<br>&#x662F;&#x5426;&#x7EE7;&#x7EED;&#x67E5;&#x770B;&#x4E0B;&#x4E00;&#x5F20;&#xFF1F;", {
                    time: 3e4,
                    btn: ["&#x4E0B;&#x4E00;&#x5F20;", "&#x4E0D;&#x770B;&#x4E86;"],
                    yes: function () {
                        1 < s.length && r.imgnext(!0, !0)
                    }
                })
            })
        }
    }, d.run = function (e) {
        u = (h = e)(c), p.html = h("html"), f.open = function (e) {
            return new t(e).index
        }
    }, c.layui && layui.define ? (f.ready(), layui.define("jquery", function (e) {
        f.path = layui.cache.dir, d.run(layui.$), e("layer", c.layer = f)
    })) : "function" == typeof define && define.amd ? define(["jquery"], function () {
        return d.run(c.jQuery), f
    }) : (d.run(c.jQuery), f.ready())
}(window), function () {
    var f = function (e, t) {
        return "string" == typeof t ? d(t, {filename: e}) : i(e, t)
    };
    f.version = "3.0.0", f.config = function (e, t) {
        o[e] = t
    };
    var o = f.defaults = {openTag: "<%", closeTag: "%>", escape: !0, cache: !0, compress: !1, parser: null},
        l = f.cache = {};
    f.render = function (e, t) {
        return d(e, t)
    };
    var i = f.renderFile = function (e, t) {
        e = f.get(e) || u({filename: e, name: "Render Error", message: "Template not found"});
        return t ? e(t) : e
    };
    f.get = function (e) {
        var t, i;
        return l[e] ? i = l[e] : "object" != typeof document || (t = document.getElementById(e)) && (t = (t.value || t.innerHTML).replace(/^\s*|\s*$/g, ""), i = d(t, {filename: e})), i
    };
    var n = function (e, t) {
        return "string" != typeof e && ("number" == (t = typeof e) ? e += "" : e = "function" == t ? n(e.call(e)) : ""), e
    }, t = {"<": "&#60;", ">": "&#62;", '"': "&#34;", "'": "&#39;", "&": "&#38;"}, r = function (e) {
        return t[e]
    }, a = Array.isArray || function (e) {
        return "[object Array]" === {}.toString.call(e)
    }, b = f.utils = {
        $helpers: {}, $include: i, $string: n, $escape: function (e) {
            return n(e).replace(/&(?![\w#]+;)|[<>"']/g, r)
        }, $each: function (e, t) {
            var i, n;
            if (a(e)) for (i = 0, n = e.length; i < n; i++) t.call(e, e[i], i, e); else for (i in e) t.call(e, e[i], i)
        }
    };
    f.helper = function (e, t) {
        x[e] = t
    };
    var x = f.helpers = b.$helpers;
    f.onerror = function (e) {
        var t, i = "Template Error\n\n";
        for (t in e) i += "<" + t + ">\n" + e[t] + "\n\n";
        "object" == typeof console && console.error(i)
    };
    var u = function (e) {
            return f.onerror(e), function () {
                return "{Template Error}"
            }
        }, d = f.compile = function (t, i) {
            for (var e in i = i || {}, o) i[e] === undefined && (i[e] = o[e]);
            var n = i.filename;
            try {
                var r = c(t, i)
            } catch (s) {
                return s.filename = n || "anonymous", s.name = "Syntax Error", u(s)
            }

            function a(e) {
                try {
                    return new r(e, n) + ""
                } catch (s) {
                    return i.debug ? u(s)() : (i.debug = !0, d(t, i)(e))
                }
            }

            return a.prototype = r.prototype, a.toString = function () {
                return r.toString()
            }, n && i.cache && (l[n] = a), a
        }, w = b.$each,
        S = /\/\*[\w\W]*?\*\/|\/\/[^\n]*\n|\/\/[^\n]*$|"(?:[^"\\]|\\[\w\W])*"|'(?:[^'\\]|\\[\w\W])*'|\s*\.\s*[$\w\.]+/g,
        k = /[^\w$]+/g,
        C = new RegExp(["\\b" + "break,case,catch,continue,debugger,default,delete,do,else,false,finally,for,function,if,in,instanceof,new,null,return,switch,this,throw,true,try,typeof,var,void,while,with,abstract,boolean,byte,char,class,const,double,enum,export,extends,final,float,goto,implements,import,int,interface,long,native,package,private,protected,public,short,static,super,synchronized,throws,transient,volatile,arguments,let,yield,undefined".replace(/,/g, "\\b|\\b") + "\\b"].join("|"), "g"),
        M = /^\d[^,]*|,\d[^,]*/g, T = /^,+|,+$/g, E = /^$|,+/;

    function I(e) {
        return "'" + e.replace(/('|\\)/g, "\\$1").replace(/\r/g, "\\r").replace(/\n/g, "\\n") + "'"
    }

    function c(e, n) {
        var r = n.debug, t = n.openTag, a = n.closeTag, s = n.parser, i = n.compress, o = n.escape, l = 1,
            u = {$data: 1, $filename: 1, $utils: 1, $helpers: 1, $out: 1, $line: 1}, d = "".trim,
            c = d ? ["$out='';", "$out+=", ";", "$out"] : ["$out=[];", "$out.push(", ");", "$out.join('')"],
            d = d ? "$out+=text;return $out;" : "$out.push(text);",
            h = "function(){var text=''.concat.apply('',arguments);" + d + "}",
            f = "function(filename,data){data=data||$data;var text=$utils.$include(filename,data,$filename);" + d + "}",
            p = "'use strict';var $utils=this,$helpers=$utils.$helpers," + (r ? "$line=0," : ""), m = c[0],
            d = "return new String(" + c[3] + ");";
        w(e.split(t), function (e) {
            var t = (e = e.split(a))[0], i = e[1];
            1 === e.length ? m += v(t) : (m += function (e) {
                var t = l;
                s ? e = s(e, n) : r && (e = e.replace(/\n/g, function () {
                    return "$line=" + ++l + ";"
                }));
                {
                    var i;
                    0 === e.indexOf("=") && (i = o && !/^=[=#]/.test(e), e = e.replace(/^=[=#]?|[\s;]*$/g, ""), i ? (i = e.replace(/\s*\([^\)]+\)/, ""), b[i] || /^(include|print)$/.test(i) || (e = "$escape(" + e + ")")) : e = "$string(" + e + ")", e = c[1] + e + c[2])
                }
                r && (e = "$line=" + t + ";" + e);
                return w(function (e) {
                    return e.replace(S, "").replace(k, ",").replace(C, "").replace(M, "").replace(T, "").split(E)
                }(e), function (e) {
                    var t;
                    e && !u[e] && (t = "print" === e ? h : "include" === e ? f : b[e] ? "$utils." + e : x[e] ? "$helpers." + e : "$data." + e, p += e + "=" + t + ",", u[e] = !0)
                }), e + "\n"
            }(t), i && (m += v(i)))
        });
        d = p + m + d;
        r && (d = "try{" + d + "}catch(e){throw {filename:$filename,name:'Render Error',message:e.message,line:$line,source:" + I(e) + ".split(/\\n/)[$line-1].replace(/^\\s+/,'')};}");
        try {
            var g = new Function("$data", "$filename", d);
            return g.prototype = b, g
        } catch (y) {
            throw y.temp = "function anonymous($data,$filename) {" + d + "}", y
        }

        function v(e) {
            return l += e.split(/\n/).length - 1, e = (e = i ? e.replace(/\s+/g, " ").replace(/<!--[\w\W]*?-->/g, "") : e) && c[1] + I(e) + c[2] + "\n"
        }
    }

    o.openTag = "{{", o.closeTag = "}}";
    o.parser = function (e, t) {
        var i, n, r, a = (e = e.replace(/^\s/, "")).split(" "), s = a.shift(), o = a.join(" ");
        switch (s) {
            case"if":
                e = "if(" + o + "){";
                break;
            case"else":
                e = "}else" + (a = "if" === a.shift() ? " if(" + a.join(" ") + ")" : "") + "{";
                break;
            case"/if":
                e = "}";
                break;
            case"each":
                var l = a[0] || "$data";
                e = "$each(" + (l = "as" !== (a[1] || "as") ? "[]" : l) + ",function(" + ((a[2] || "$value") + "," + (a[3] || "$index")) + "){";
                break;
            case"/each":
                e = "});";
                break;
            case"echo":
                e = "print(" + o + ");";
                break;
            case"print":
            case"include":
                e = s + "(" + a.join(",") + ");";
                break;
            case"var":
                e = "var " + o + ";";
                break;
            default:
                if (/^\s*\|\s*[\w\$]/.test(o)) {
                    l = !0;
                    0 === e.indexOf("#") && (e = e.substr(1), l = !1);
                    for (var u = 0, d = e.split("|"), c = d.length, h = d[u++]; u < c; u++) i = h, n = d[u], r = void 0, n = (r = n.split(":")).shift(), r = r.join(":") || "", h = "$helpers." + n + "(" + i + (r = r && ", " + r) + ")";
                    e = (l ? "=" : "=#") + h
                } else e = f.helpers[s] ? "=#" + s + "(" + a.join(",") + ");" : "=" + e
        }
        return e
    }, "function" == typeof define ? define(function () {
        return f
    }) : "undefined" != typeof exports ? module.exports = f : this.template = f
}(), function (r, i) {
    var e, n, a, t, s, o, l, u = "hashchange", d = document, c = r.event.special, h = d.documentMode,
        f = "on" + u in i && (void 0 === h || 7 < h);

    function p(e) {
        return "#" + (e = e || location.href).replace(/^[^#]*#?(.*)$/, "$1")
    }

    function m() {
        var e = p(), t = l(s);
        e !== s ? (o(s = e, t), r(i).trigger(u)) : t !== s && (location.href = location.href.replace(/#.*/, "") + t), n = setTimeout(m, r.fn[u].delay)
    }

    r.fn[u] = function (e) {
        return e ? this.bind(u, e) : this.trigger(u)
    }, r.fn[u].delay = 50, c[u] = r.extend(c[u], {
        setup: function () {
            if (f) return !1;
            r(e.start)
        }, teardown: function () {
            if (f) return !1;
            r(e.stop)
        }
    }), h = {}, s = p(), l = o = c = function (e) {
        return e
    }, h.start = function () {
        n || m()
    }, h.stop = function () {
        n && clearTimeout(n), n = void 0
    }, function () {
        for (var e = 3, t = document.createElement("div"), i = t.getElementsByTagName("i"); t.innerHTML = "\x3c!--[if gt IE " + ++e + "]><i></i><![endif]--\x3e", i[0];) ;
        return 4 < e ? e : void 0
    }() && !f && (h.start = function () {
        a || (t = (t = r.fn[u].src) && t + p(), a = r('<iframe tabindex="-1" title="empty"/>').hide().one("load", function () {
            t || o(p()), m()
        }).attr("src", t || "javascript:0").insertAfter("body")[0].contentWindow, d.onpropertychange = function () {
            try {
                "title" === event.propertyName && (a.document.title = d.title)
            } catch (e) {
            }
        })
    }, h.stop = c, l = function () {
        return p(a.location.href)
    }, o = function (e, t) {
        var i = a.document, n = r.fn[u].domain;
        e !== t && (i.title = d.title, i.open(), n && i.write('<script>document.domain="' + n + '"<\/script>'), i.close(), a.location.hash = e)
    }), e = h
}(jQuery, this), function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (d) {
    var i;
    d.extend(d.fn, {
        validate: function (e) {
            if (this.length) {
                var n = d.data(this[0], "validator");
                return n ? n : (this.attr("novalidate", "novalidate"), n = new d.validator(e, this[0]), d.data(this[0], "validator", n), n.settings.onsubmit && (this.on("click.validate", ":submit", function (e) {
                    n.submitButton = e.currentTarget, d(this).hasClass("cancel") && (n.cancelSubmit = !0), d(this).attr("formnovalidate") !== undefined && (n.cancelSubmit = !0)
                }), this.on("submit.validate", function (i) {
                    function e() {
                        var e, t;
                        return n.submitButton && (n.settings.submitHandler || n.formSubmitted) && (e = d("<input type='hidden'/>").attr("name", n.submitButton.name).val(d(n.submitButton).val()).appendTo(n.currentForm)), !(n.settings.submitHandler && !n.settings.debug) || (t = n.settings.submitHandler.call(n, n.currentForm, i), e && e.remove(), t !== undefined && t)
                    }

                    return n.settings.debug && i.preventDefault(), n.cancelSubmit ? (n.cancelSubmit = !1, e()) : n.form() ? n.pendingRequest ? !(n.formSubmitted = !0) : e() : (n.focusInvalid(), !1)
                })), n)
            }
            e && e.debug && window.console && console.warn("Nothing selected, can't validate, returning nothing.")
        }, valid: function () {
            var e, t, i;
            return d(this[0]).is("form") ? e = this.validate().form() : (i = [], e = !0, t = d(this[0].form).validate(), this.each(function () {
                (e = t.element(this) && e) || (i = i.concat(t.errorList))
            }), t.errorList = i), e
        }, rules: function (e, t) {
            var i, n, r, a, s, o = this[0],
                l = void 0 !== this.attr("contenteditable") && "false" !== this.attr("contenteditable");
            if (null != o && (!o.form && l && (o.form = this.closest("form")[0], o.name = this.attr("name")), null != o.form)) {
                if (e) switch (n = (i = d.data(o.form, "validator").settings).rules, r = d.validator.staticRules(o), e) {
                    case"add":
                        d.extend(r, d.validator.normalizeRule(t)), delete r.messages, n[o.name] = r, t.messages && (i.messages[o.name] = d.extend(i.messages[o.name], t.messages));
                        break;
                    case"remove":
                        return t ? (s = {}, d.each(t.split(/\s/), function (e, t) {
                            s[t] = r[t], delete r[t]
                        }), s) : (delete n[o.name], r)
                }
                return (e = d.validator.normalizeRules(d.extend({}, d.validator.classRules(o), d.validator.attributeRules(o), d.validator.dataRules(o), d.validator.staticRules(o)), o)).required && (a = e.required, delete e.required, e = d.extend({required: a}, e)), e.remote && (a = e.remote, delete e.remote, e = d.extend(e, {remote: a})), e
            }
        }
    }), d.extend(d.expr.pseudos || d.expr[":"], {
        blank: function (e) {
            return !d.trim("" + d(e).val())
        }, filled: function (e) {
            e = d(e).val();
            return null !== e && !!d.trim("" + e)
        }, unchecked: function (e) {
            return !d(e).prop("checked")
        }
    }), d.validator = function (e, t) {
        this.settings = d.extend(!0, {}, d.validator.defaults, e), this.currentForm = t, this.init()
    }, d.validator.format = function (i, e) {
        return 1 === arguments.length ? function () {
            var e = d.makeArray(arguments);
            return e.unshift(i), d.validator.format.apply(this, e)
        } : (e === undefined || ((e = 2 < arguments.length && e.constructor !== Array ? d.makeArray(arguments).slice(1) : e).constructor !== Array && (e = [e]), d.each(e, function (e, t) {
            i = i.replace(new RegExp("\\{" + e + "\\}", "g"), function () {
                return t
            })
        })), i)
    }, d.extend(d.validator, {
        defaults: {
            messages: {},
            groups: {},
            rules: {},
            errorClass: "error",
            pendingClass: "pending",
            validClass: "valid",
            errorElement: "label",
            focusCleanup: !1,
            focusInvalid: !0,
            errorContainer: d([]),
            errorLabelContainer: d([]),
            onsubmit: !0,
            ignore: ":hidden",
            ignoreTitle: !1,
            onfocusin: function (e) {
                this.lastActive = e, this.settings.focusCleanup && (this.settings.unhighlight && this.settings.unhighlight.call(this, e, this.settings.errorClass, this.settings.validClass), this.hideThese(this.errorsFor(e)))
            },
            onfocusout: function (e) {
                this.checkable(e) || !(e.name in this.submitted) && this.optional(e) || this.element(e)
            },
            onkeyup: function (e, t) {
                9 === t.which && "" === this.elementValue(e) || -1 !== d.inArray(t.keyCode, [16, 17, 18, 20, 35, 36, 37, 38, 39, 40, 45, 144, 225]) || (e.name in this.submitted || e.name in this.invalid) && this.element(e)
            },
            onclick: function (e) {
                e.name in this.submitted ? this.element(e) : e.parentNode.name in this.submitted && this.element(e.parentNode)
            },
            highlight: function (e, t, i) {
                ("radio" === e.type ? this.findByName(e.name) : d(e)).addClass(t).removeClass(i)
            },
            unhighlight: function (e, t, i) {
                ("radio" === e.type ? this.findByName(e.name) : d(e)).removeClass(t).addClass(i)
            }
        },
        setDefaults: function (e) {
            d.extend(d.validator.defaults, e)
        },
        messages: {
            required: "这是必填字段",
            remote: "请修正此字段",
            email: "请输入有效的电子邮件地址",
            url: "请输入有效的网址",
            date: "请输入有效的日期",
            dateISO: "请输入有效的日期 (YYYY-MM-DD)",
            number: "请输入有效的数字",
            digits: "请输入非负整数",
            creditcard: "请输入有效的信用卡号码",
            equalTo: "你的输入不相同",
            extension: "请输入有效的后缀",
            maxlength: d.validator.format("最多可以输入 {0} 个字符"),
            minlength: d.validator.format("最少要输入 {0} 个字符"),
            rangelength: d.validator.format("请输入长度在 {0} 到 {1} 之间的字符串"),
            range: d.validator.format("请输入范围在 {0} 到 {1} 之间的数值"),
            step: d.validator.format("请输入 {0} 的整数倍值"),
            max: d.validator.format("请输入不大于 {0} 的数值"),
            min: d.validator.format("请输入不小于 {0} 的数值")
        },
        autoCreateRanges: !1,
        prototype: {
            init: function () {
                this.labelContainer = d(this.settings.errorLabelContainer), this.errorContext = this.labelContainer.length && this.labelContainer || d(this.currentForm), this.containers = d(this.settings.errorContainer).add(this.settings.errorLabelContainer), this.submitted = {}, this.valueCache = {}, this.pendingRequest = 0, this.pending = {}, this.invalid = {}, this.reset();
                var i, r = this.currentForm, n = this.groups = {};

                function e(e) {
                    var t, i,
                        n = void 0 !== d(this).attr("contenteditable") && "false" !== d(this).attr("contenteditable");
                    !this.form && n && (this.form = d(this).closest("form")[0], this.name = d(this).attr("name")), r === this.form && (t = d.data(this.form, "validator"), i = "on" + e.type.replace(/^validate/, ""), (n = t.settings)[i] && !d(this).is(n.ignore) && n[i].call(t, this, e))
                }

                d.each(this.settings.groups, function (i, e) {
                    "string" == typeof e && (e = e.split(/\s/)), d.each(e, function (e, t) {
                        n[t] = i
                    })
                }), i = this.settings.rules, d.each(i, function (e, t) {
                    i[e] = d.validator.normalizeRule(t)
                }), d(this.currentForm).on("focusin.validate focusout.validate keyup.validate", ":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'], [type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox'], [contenteditable], [type='button']", e).on("click.validate", "select, option, [type='radio'], [type='checkbox']", e), this.settings.invalidHandler && d(this.currentForm).on("invalid-form.validate", this.settings.invalidHandler)
            }, form: function () {
                return this.checkForm(), d.extend(this.submitted, this.errorMap), this.invalid = d.extend({}, this.errorMap), this.valid() || d(this.currentForm).triggerHandler("invalid-form", [this]), this.showErrors(), this.valid()
            }, checkForm: function () {
                this.prepareForm();
                for (var e = 0, t = this.currentElements = this.elements(); t[e]; e++) this.check(t[e]);
                return this.valid()
            }, element: function (e) {
                var t, i, n = this.clean(e), r = this.validationTargetFor(n), a = this, s = !0;
                return r === undefined ? delete this.invalid[n.name] : (this.prepareElement(r), this.currentElements = d(r), (i = this.groups[r.name]) && d.each(this.groups, function (e, t) {
                    t === i && e !== r.name && (n = a.validationTargetFor(a.clean(a.findByName(e)))) && n.name in a.invalid && (a.currentElements.push(n), s = a.check(n) && s)
                }), t = !1 !== this.check(r), s = s && t, this.invalid[r.name] = !t, this.numberOfInvalids() || (this.toHide = this.toHide.add(this.containers)), this.showErrors(), d(e).attr("aria-invalid", !t)), s
            }, showErrors: function (t) {
                var i;
                t && (d.extend((i = this).errorMap, t), this.errorList = d.map(this.errorMap, function (e, t) {
                    return {message: e, element: i.findByName(t)[0]}
                }), this.successList = d.grep(this.successList, function (e) {
                    return !(e.name in t)
                })), this.settings.showErrors ? this.settings.showErrors.call(this, this.errorMap, this.errorList) : this.defaultShowErrors()
            }, resetForm: function () {
                d.fn.resetForm && d(this.currentForm).resetForm(), this.invalid = {}, this.submitted = {}, this.prepareForm(), this.hideErrors();
                var e = this.elements().removeData("previousValue").removeAttr("aria-invalid");
                this.resetElements(e)
            }, resetElements: function (e) {
                var t;
                if (this.settings.unhighlight) for (t = 0; e[t]; t++) this.settings.unhighlight.call(this, e[t], this.settings.errorClass, ""), this.findByName(e[t].name).removeClass(this.settings.validClass); else e.removeClass(this.settings.errorClass).removeClass(this.settings.validClass)
            }, numberOfInvalids: function () {
                return this.objectLength(this.invalid)
            }, objectLength: function (e) {
                var t, i = 0;
                for (t in e) e[t] !== undefined && null !== e[t] && !1 !== e[t] && i++;
                return i
            }, hideErrors: function () {
                this.hideThese(this.toHide)
            }, hideThese: function (e) {
                e.not(this.containers).text(""), this.addWrapper(e).hide()
            }, valid: function () {
                return 0 === this.size()
            }, size: function () {
                return this.errorList.length
            }, focusInvalid: function () {
                if (this.settings.focusInvalid) try {
                    d(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").trigger("focus").trigger("focusin")
                } catch (e) {
                }
            }, findLastActive: function () {
                var t = this.lastActive;
                return t && 1 === d.grep(this.errorList, function (e) {
                    return e.element.name === t.name
                }).length && t
            }, elements: function () {
                var i = this, n = {};
                return d(this.currentForm).find("input, select, textarea, [contenteditable]").not(":submit, :reset, :image, :disabled").not(this.settings.ignore).filter(function () {
                    var e = this.name || d(this).attr("name"),
                        t = void 0 !== d(this).attr("contenteditable") && "false" !== d(this).attr("contenteditable");
                    return !e && i.settings.debug && window.console && console.error("%o has no name assigned", this), t && (this.form = d(this).closest("form")[0], this.name = e), this.form === i.currentForm && (!(e in n || !i.objectLength(d(this).rules())) && (n[e] = !0))
                })
            }, clean: function (e) {
                return d(e)[0]
            }, errors: function () {
                var e = this.settings.errorClass.split(" ").join(".");
                return d(this.settings.errorElement + "." + e, this.errorContext)
            }, resetInternals: function () {
                this.successList = [], this.errorList = [], this.errorMap = {}, this.toShow = d([]), this.toHide = d([])
            }, reset: function () {
                this.resetInternals(), this.currentElements = d([])
            }, prepareForm: function () {
                this.reset(), this.toHide = this.errors().add(this.containers)
            }, prepareElement: function (e) {
                this.reset(), this.toHide = this.errorsFor(e)
            }, elementValue: function (e) {
                var t = d(e), i = e.type,
                    n = void 0 !== t.attr("contenteditable") && "false" !== t.attr("contenteditable");
                return "radio" === i || "checkbox" === i ? this.findByName(e.name).filter(":checked").val() : "number" === i && "undefined" != typeof e.validity ? e.validity.badInput ? "NaN" : t.val() : (t = n ? t.text() : t.val(), "file" === i ? "C:\\fakepath\\" === t.substr(0, 12) ? t.substr(12) : 0 <= (i = t.lastIndexOf("/")) || 0 <= (i = t.lastIndexOf("\\")) ? t.substr(i + 1) : t : "string" == typeof t ? t.replace(/\r/g, "") : t)
            }, check: function (e) {
                e = this.validationTargetFor(this.clean(e));
                var t, i, n, r, a = d(e).rules(), s = d.map(a, function (e, t) {
                    return t
                }).length, o = !1, l = this.elementValue(e);
                for (i in "function" == typeof a.normalizer ? r = a.normalizer : "function" == typeof this.settings.normalizer && (r = this.settings.normalizer), r && (l = r.call(e, l), delete a.normalizer), a) {
                    n = {method: i, parameters: a[i]};
                    try {
                        if ("dependency-mismatch" === (t = d.validator.methods[i].call(this, l, e, n.parameters)) && 1 === s) {
                            o = !0;
                            continue
                        }
                        if (o = !1, "pending" === t) return void (this.toHide = this.toHide.not(this.errorsFor(e)));
                        if (!t) return this.formatAndAdd(e, n), !1
                    } catch (u) {
                        throw this.settings.debug && window.console && console.log("Exception occurred when checking element " + e.id + ", check the '" + n.method + "' method.", u), u instanceof TypeError && (u.message += ".  Exception occurred when checking element " + e.id + ", check the '" + n.method + "' method."), u
                    }
                }
                if (!o) return this.objectLength(a) && this.successList.push(e), !0
            }, customDataMessage: function (e, t) {
                return d(e).data("msg" + t.charAt(0).toUpperCase() + t.substring(1).toLowerCase()) || d(e).data("msg")
            }, customMessage: function (e, t) {
                e = this.settings.messages[e];
                return e && (e.constructor === String ? e : e[t])
            }, findDefined: function () {
                for (var e = 0; e < arguments.length; e++) if (arguments[e] !== undefined) return arguments[e];
                return undefined
            }, defaultMessage: function (e, t) {
                var i = this.findDefined(this.customMessage(e.name, (t = "string" == typeof t ? {method: t} : t).method), this.customDataMessage(e, t.method), !this.settings.ignoreTitle && e.title || undefined, d.validator.messages[t.method], "<strong>Warning: No message defined for " + e.name + "</strong>"),
                    n = /\$?\{(\d+)\}/g;
                return "function" == typeof i ? i = i.call(this, t.parameters, e) : n.test(i) && (i = d.validator.format(i.replace(n, "{$1}"), t.parameters)), i
            }, formatAndAdd: function (e, t) {
                var i = this.defaultMessage(e, t);
                this.errorList.push({
                    message: i,
                    element: e,
                    method: t.method
                }), this.errorMap[e.name] = i, this.submitted[e.name] = i
            }, addWrapper: function (e) {
                return e = this.settings.wrapper ? e.add(e.parent(this.settings.wrapper)) : e
            }, defaultShowErrors: function () {
                for (var e, t, i = 0; this.errorList[i]; i++) t = this.errorList[i], this.settings.highlight && this.settings.highlight.call(this, t.element, this.settings.errorClass, this.settings.validClass), this.showLabel(t.element, t.message);
                if (this.errorList.length && (this.toShow = this.toShow.add(this.containers)), this.settings.success) for (i = 0; this.successList[i]; i++) this.showLabel(this.successList[i]);
                if (this.settings.unhighlight) for (i = 0, e = this.validElements(); e[i]; i++) this.settings.unhighlight.call(this, e[i], this.settings.errorClass, this.settings.validClass);
                this.toHide = this.toHide.not(this.toShow), this.hideErrors(), this.addWrapper(this.toShow).show()
            }, validElements: function () {
                return this.currentElements.not(this.invalidElements())
            }, invalidElements: function () {
                return d(this.errorList).map(function () {
                    return this.element
                })
            }, showLabel: function (e, t) {
                var i, n, r, a = this.errorsFor(e), s = this.idOrName(e), o = d(e).attr("aria-describedby");
                a.length ? (a.removeClass(this.settings.validClass).addClass(this.settings.errorClass), a.html(t)) : (i = a = d("<" + this.settings.errorElement + ">").attr("id", s + "-error").addClass(this.settings.errorClass).html(t || ""), this.settings.wrapper && (i = a.hide().show().wrap("<" + this.settings.wrapper + "/>").parent()), this.labelContainer.length ? this.labelContainer.append(i) : this.settings.errorPlacement ? this.settings.errorPlacement.call(this, i, d(e)) : i.insertAfter(e), a.is("label") ? a.attr("for", s) : 0 === a.parents("label[for='" + this.escapeCssMeta(s) + "']").length && (s = a.attr("id"), o ? o.match(new RegExp("\\b" + this.escapeCssMeta(s) + "\\b")) || (o += " " + s) : o = s, d(e).attr("aria-describedby", o), (n = this.groups[e.name]) && d.each((r = this).groups, function (e, t) {
                    t === n && d("[name='" + r.escapeCssMeta(e) + "']", r.currentForm).attr("aria-describedby", a.attr("id"))
                }))), !t && this.settings.success && (a.text(""), "string" == typeof this.settings.success ? a.addClass(this.settings.success) : this.settings.success(a, e)), this.toShow = this.toShow.add(a)
            }, errorsFor: function (e) {
                var t = this.escapeCssMeta(this.idOrName(e)), e = d(e).attr("aria-describedby"),
                    t = "label[for='" + t + "'], label[for='" + t + "'] *";
                return e && (t = t + ", #" + this.escapeCssMeta(e).replace(/\s+/g, ", #")), this.errors().filter(t)
            }, escapeCssMeta: function (e) {
                return e.replace(/([\\!"#$%&'()*+,./:;<=>?@\[\]^`{|}~])/g, "\\$1")
            }, idOrName: function (e) {
                return this.groups[e.name] || !this.checkable(e) && e.id || e.name
            }, validationTargetFor: function (e) {
                return this.checkable(e) && (e = this.findByName(e.name)), d(e).not(this.settings.ignore)[0]
            }, checkable: function (e) {
                return /radio|checkbox/i.test(e.type)
            }, findByName: function (e) {
                return d(this.currentForm).find("[name='" + this.escapeCssMeta(e) + "']")
            }, getLength: function (e, t) {
                switch (t.nodeName.toLowerCase()) {
                    case"select":
                        return d("option:selected", t).length;
                    case"input":
                        if (this.checkable(t)) return this.findByName(t.name).filter(":checked").length
                }
                return e.length
            }, depend: function (e, t) {
                return !this.dependTypes[typeof e] || this.dependTypes[typeof e](e, t)
            }, dependTypes: {
                "boolean": function (e) {
                    return e
                }, string: function (e, t) {
                    return !!d(e, t.form).length
                }, "function": function (e, t) {
                    return e(t)
                }
            }, optional: function (e) {
                var t = this.elementValue(e);
                return !d.validator.methods.required.call(this, t, e) && "dependency-mismatch"
            }, startRequest: function (e) {
                this.pending[e.name] || (this.pendingRequest++, d(e).addClass(this.settings.pendingClass), this.pending[e.name] = !0)
            }, stopRequest: function (e, t) {
                this.pendingRequest--, this.pendingRequest < 0 && (this.pendingRequest = 0), delete this.pending[e.name], d(e).removeClass(this.settings.pendingClass), t && 0 === this.pendingRequest && this.formSubmitted && this.form() ? (d(this.currentForm).submit(), this.submitButton && d("input:hidden[name='" + this.submitButton.name + "']", this.currentForm).remove(), this.formSubmitted = !1) : !t && 0 === this.pendingRequest && this.formSubmitted && (d(this.currentForm).triggerHandler("invalid-form", [this]), this.formSubmitted = !1)
            }, previousValue: function (e, t) {
                return t = "string" == typeof t && t || "remote", d.data(e, "previousValue") || d.data(e, "previousValue", {
                    old: null,
                    valid: !0,
                    message: this.defaultMessage(e, {method: t})
                })
            }, destroy: function () {
                this.resetForm(), d(this.currentForm).off(".validate").removeData("validator").find(".validate-equalTo-blur").off(".validate-equalTo").removeClass("validate-equalTo-blur").find(".validate-lessThan-blur").off(".validate-lessThan").removeClass("validate-lessThan-blur").find(".validate-lessThanEqual-blur").off(".validate-lessThanEqual").removeClass("validate-lessThanEqual-blur").find(".validate-greaterThanEqual-blur").off(".validate-greaterThanEqual").removeClass("validate-greaterThanEqual-blur").find(".validate-greaterThan-blur").off(".validate-greaterThan").removeClass("validate-greaterThan-blur")
            }
        },
        classRuleSettings: {
            required: {required: !0},
            email: {email: !0},
            url: {url: !0},
            date: {date: !0},
            dateISO: {dateISO: !0},
            number: {number: !0},
            digits: {digits: !0},
            creditcard: {creditcard: !0}
        },
        addClassRules: function (e, t) {
            e.constructor === String ? this.classRuleSettings[e] = t : d.extend(this.classRuleSettings, e)
        },
        classRules: function (e) {
            var t = {}, e = d(e).attr("class");
            return e && d.each(e.split(" "), function () {
                this in d.validator.classRuleSettings && d.extend(t, d.validator.classRuleSettings[this])
            }), t
        },
        normalizeAttributeRule: function (e, t, i, n) {
            /min|max|step/.test(i) && (null === t || /number|range|text/.test(t)) && (n = Number(n), isNaN(n) && (n = undefined)), n || 0 === n ? e[i] = n : t === i && "range" !== t && (e[i] = !0)
        },
        attributeRules: function (e) {
            var t, i, n = {}, r = d(e), a = e.getAttribute("type");
            for (t in d.validator.methods) i = "required" === t ? !!(i = "" === (i = e.getAttribute(t)) ? !0 : i) : r.attr(t), this.normalizeAttributeRule(n, a, t, i);
            return n.maxlength && /-1|2147483647|524288/.test(n.maxlength) && delete n.maxlength, n
        },
        dataRules: function (e) {
            var t, i, n = {}, r = d(e), a = e.getAttribute("type");
            for (t in d.validator.methods) "" === (i = r.data("rule" + t.charAt(0).toUpperCase() + t.substring(1).toLowerCase())) && (i = !0), this.normalizeAttributeRule(n, a, t, i);
            return n
        },
        staticRules: function (e) {
            var t = {}, i = d.data(e.form, "validator");
            return t = i.settings.rules ? d.validator.normalizeRule(i.settings.rules[e.name]) || {} : t
        },
        normalizeRules: function (n, r) {
            return d.each(n, function (e, t) {
                if (!1 !== t) {
                    if (t.param || t.depends) {
                        var i = !0;
                        switch (typeof t.depends) {
                            case"string":
                                i = !!d(t.depends, r.form).length;
                                break;
                            case"function":
                                i = t.depends.call(r, r)
                        }
                        i ? n[e] = t.param === undefined || t.param : (d.data(r.form, "validator").resetElements(d(r)), delete n[e])
                    }
                } else delete n[e]
            }), d.each(n, function (e, t) {
                n[e] = d.isFunction(t) && "normalizer" !== e ? t(r) : t
            }), d.each(["minlength", "maxlength"], function () {
                n[this] && (n[this] = Number(n[this]))
            }), d.each(["rangelength", "range"], function () {
                var e;
                n[this] && (d.isArray(n[this]) ? n[this] = [Number(n[this][0]), Number(n[this][1])] : "string" == typeof n[this] && (e = n[this].replace(/[\[\]]/g, "").split(/[\s,]+/), n[this] = [Number(e[0]), Number(e[1])]))
            }), d.validator.autoCreateRanges && (null != n.min && null != n.max && (n.range = [n.min, n.max], delete n.min, delete n.max), null != n.minlength && null != n.maxlength && (n.rangelength = [n.minlength, n.maxlength], delete n.minlength, delete n.maxlength)), n
        },
        normalizeRule: function (e) {
            var t;
            return "string" == typeof e && (t = {}, d.each(e.split(/\s/), function () {
                t[this] = !0
            }), e = t), e
        },
        addMethod: function (e, t, i) {
            d.validator.methods[e] = t, d.validator.messages[e] = i !== undefined ? i : d.validator.messages[e], t.length < 3 && d.validator.addClassRules(e, d.validator.normalizeRule(e))
        },
        methods: {
            required: function (e, t, i) {
                if (!this.depend(i, t)) return "dependency-mismatch";
                if ("select" !== t.nodeName.toLowerCase()) return this.checkable(t) ? 0 < this.getLength(e, t) : e !== undefined && null !== e && 0 < e.length;
                t = d(t).val();
                return t && 0 < t.length
            }, email: function (e, t) {
                return this.optional(t) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(e)
            }, url: function (e, t) {
                return this.optional(t) || /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(e)
            }, date: (i = !1, function (e, t) {
                return i || (i = !0, this.settings.debug && window.console && console.warn("The `date` method is deprecated and will be removed in version '2.0.0'.\nPlease don't use it, since it relies on the Date constructor, which\nbehaves very differently across browsers and locales. Use `dateISO`\ninstead or one of the locale specific methods in `localizations/`\nand `additional-methods.js`.")), this.optional(t) || !/Invalid|NaN/.test(new Date(e).toString())
            }), dateISO: function (e, t) {
                return this.optional(t) || /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(e)
            }, number: function (e, t) {
                return this.optional(t) || /^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(e)
            }, digits: function (e, t) {
                return this.optional(t) || /^\d+$/.test(e)
            }, minlength: function (e, t, i) {
                e = d.isArray(e) ? e.length : this.getLength(e, t);
                return this.optional(t) || i <= e
            }, maxlength: function (e, t, i) {
                e = d.isArray(e) ? e.length : this.getLength(e, t);
                return this.optional(t) || e <= i
            }, rangelength: function (e, t, i) {
                e = d.isArray(e) ? e.length : this.getLength(e, t);
                return this.optional(t) || e >= i[0] && e <= i[1]
            }, min: function (e, t, i) {
                return this.optional(t) || i <= e
            }, max: function (e, t, i) {
                return this.optional(t) || e <= i
            }, range: function (e, t, i) {
                return this.optional(t) || e >= i[0] && e <= i[1]
            }, step: function (e, t, i) {
                var n, r = d(t).attr("type"), a = "Step attribute on input type " + r + " is not supported.",
                    s = new RegExp("\\b" + r + "\\b"), o = function (e) {
                        e = ("" + e).match(/(?:\.(\d+))?$/);
                        return e && e[1] ? e[1].length : 0
                    }, l = function (e) {
                        return Math.round(e * Math.pow(10, n))
                    }, u = !0;
                if (r && !s.test(["text", "number", "range"].join())) throw new Error(a);
                return n = o(i), (o(e) > n || l(e) % l(i) != 0) && (u = !1), this.optional(t) || u
            }, equalTo: function (e, t, i) {
                i = d(i);
                return this.settings.onfocusout && i.not(".validate-equalTo-blur").length && i.addClass("validate-equalTo-blur").on("blur.validate-equalTo", function () {
                    d(t).valid()
                }), e === i.val()
            }, remote: function (n, r, e, a) {
                if (this.optional(r)) return "dependency-mismatch";
                a = "string" == typeof a && a || "remote";
                var s, t, o = this.previousValue(r, a);
                return this.settings.messages[r.name] || (this.settings.messages[r.name] = {}), o.originalMessage = o.originalMessage || this.settings.messages[r.name][a], this.settings.messages[r.name][a] = o.message, t = d.param(d.extend({data: n}, (e = "string" == typeof e ? {url: e} : e).data)), o.old === t ? o.valid : (o.old = t, (s = this).startRequest(r), (t = {})[r.name] = n, d.ajax(d.extend(!0, {
                    mode: "abort",
                    port: "validate" + r.name,
                    dataType: "json",
                    data: t,
                    context: s.currentForm,
                    success: function (e) {
                        var t, i = !0 === e || "true" === e;
                        s.settings.messages[r.name][a] = o.originalMessage, i ? (t = s.formSubmitted, s.resetInternals(), s.toHide = s.errorsFor(r), s.formSubmitted = t, s.successList.push(r), s.invalid[r.name] = !1, s.showErrors()) : (t = {}, e = e || s.defaultMessage(r, {
                            method: a,
                            parameters: n
                        }), t[r.name] = o.message = e, s.invalid[r.name] = !0, s.showErrors(t)), o.valid = i, s.stopRequest(r, i)
                    }
                }, e)), "pending")
            }
        }
    });
    var n, r = {};
    return d.ajaxPrefilter ? d.ajaxPrefilter(function (e, t, i) {
        var n = e.port;
        "abort" === e.mode && (r[n] && r[n].abort(), r[n] = i)
    }) : (n = d.ajax, d.ajax = function (e) {
        var t = ("mode" in e ? e : d.ajaxSettings).mode, i = ("port" in e ? e : d.ajaxSettings).port;
        return "abort" === t ? (r[i] && r[i].abort(), r[i] = n.apply(this, arguments), r[i]) : n.apply(this, arguments)
    }), d
}), function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (n) {
    function i(e, t, i) {
        this.d = e, this.$d = i, this.pageIndex = t.data.pageIndex || 1, this.size = t.data.pageSize || 30, this.pageCount = t.data.pageCount, this.done = t.done || n.noop(), this.render(t.data), this.init(t)
    }

    return i.prototype.render = function (e) {
        e = '<div class="pagination">            <select class="pagesize">    <option value="10">10</option>  <option value="20">20</option>  <option value="30" selected>30</option>  <option value="60">60</option>  <option value="100">100</option>  </select>            第 <span class="pageindex">' + this.pageIndex + '</span> 页             共 <span class="pagecount">' + this.pageCount + '</span> 页             共 <span class="recordcount">' + e.recordCount + '</span> 条             <a href="javascript:void(0)" class="btn-first">首页</a>             <a href="javascript:void(0)" class="btn-prev">上一页</a>             <a href="javascript:void(0)" class="btn-next">下一页</a>             <a href="javascript:void(0)" class="btn-last">尾页</a>             <input type="text" class="input-index">             <input type="button" class="btn btn-go" value="GO">         </div>';
        this.d.innerHTML = e
    }, i.prototype.init = function (e) {
        var t = this;
        this.$index = n(".pageindex", this.d), this.$count = n(".pagecount", this.d), this.$total = n(".recordcount", this.d), this.$pagesize = n(".pagesize", this.d).val(this.size).change(function () {
            var e = this.value;
            return t.$d.each(function () {
                this.pagination.size = e, this.pagination.$pagesize.val(e)
            }), t.done(1, t.size), !1
        }), this.input_index = n(".input-index", this.d).on("blur", function () {
            var e = parseInt(this.value, 10);
            isNaN(e) || e <= 0 ? this.value = "" : e > t.pageCount && (this.value = t.pageCount)
        }).on("keydown", function (e) {
            if (13 === e.keyCode) return n(this).triggerHandler("blur"), t.go.trigger("click"), !1
        }), this.go = n(".btn-go", this.d).on("click", function () {
            /\s*\d+\s*/.test(t.input_index.val()) && (t.pageIndex = parseInt(t.input_index.val(), 10), t.$index.html(t.pageIndex), t.done(t.pageIndex, t.size))
        }), this.fnFirst = n(".btn-first", this.d).on("click", function () {
            1 != t.pageIndex && (t.pageIndex = 1, t.$index.html(t.pageIndex), t.done(1, t.size))
        }), this.fnPrev = n(".btn-prev", this.d).on("click", function () {
            1 < t.pageIndex && (--t.pageIndex, t.$index.html(t.pageIndex), t.done(t.pageIndex, t.size))
        }), this.fnNext = n(".btn-next", this.d).on("click", function () {
            t.pageIndex < t.pageCount && (t.pageIndex += 1, t.$index.html(t.pageIndex), t.done(t.pageIndex, t.size))
        }), this.fnLast = n(".btn-last", this.d).on("click", function () {
            t.pageIndex != t.pageCount && (t.pageIndex = t.pageCount, t.$index.html(t.pageIndex), t.done(t.pageIndex, t.size))
        })
    }, i.prototype.update = function (e) {
        this.pageIndex = e.data.pageIndex || 1, this.pageCount = e.data.pageCount || Math.ceil(e.data.recordCount / this.size), this.$index.html(this.pageIndex), this.$count.html(this.pageCount), this.$total.html(e.data.recordCount), this.$pagesize.val(this.size)
    }, n.fn.pagination = function (e) {
        e = e || {};
        var t = this;
        return this.each(function () {
            this.pagination ? this.pagination.update(e) : this.pagination = new i(this, e, t)
        })
    }, n
}), window.console || (window.console = {
    log: function () {
    }
}), $.support.boxSizing || document.execCommand("BackgroundImageCache", !1, !0), SESSIONID = SID ? "/" + SID : "", function (window, $) {
    var win = $(window), doc = $(document), ie9 = -1 < navigator.userAgent.indexOf("MSIE 9.0"),
        reg_include = /#include\s+([a-zA-Z0-9_\-\/]+)/g, reg_template = /#template\s+([a-zA-Z0-9_-]+)/, tpl_id,
        match_tpl, Requesting = {};

    function Loader(e, t) {
        e = e || {}, this.template = null, this.jsondata = {
            Status: 1,
            Data: {}
        }, this.bd = e.bd || null, this.timer_html = null, this.timer_bind = null, this.success = e.success || null, this.renderSuccess = e.renderSuccess || null, this.compile = e.compile || null, this.loadid = t, this.flag = 0, this.loadcount = 2, this.hash = e.hash, this.loadPage(e, t)
    }

    $.ajaxSetup({global: !1, cache: !1}), Loader.prototype.loadPage = function (e, t) {
        this.getHTML(e = e || {}), this.getJSON(e, t)
    }, Loader.prototype.render = function (e) {
        ie9 && (e = e.replace(/\/td>\s+<td/g, "/td><td"));
        var t = this;
        this.success ? this.success(e, this.jsondata) : (this.unbind(this.bd), this.bd.html(e), this.renderElement(), this.renderSuccess && this.renderSuccess(this.jsondata)), this.timer_bind = setTimeout(function () {
            t.bind(t.bd, t.jsondata), t.destroy()
        }, 0), G.iclick && this.hash && doc.triggerHandler("setHash")
    }, Loader.prototype.renderElement = function (bd) {
        var action, param, template, _bd = bd || this.bd;
        $("[async]", _bd).each(function () {
            action = this.getAttribute("action"), this.format = this.getAttribute("format") ? eval(this.getAttribute("format")) : null, this.removeAttribute("async"), param = $.unparam(this.getAttribute("param")), template = $("#" + this.getAttribute("template")).html(), loadModule({
                html: template,
                json: action,
                bd: $(this),
                param: param,
                jsonSuccess: $.proxy(function (e) {
                    return this.format ? this.format(e) : e
                }, this)
            })
        })
    }, Loader.prototype.destroy = function () {
        this.timer_bind && clearTimeout(this.timer_bind), this.template = null, this.jsondata = null, this.bd = null, this.timer_html = null, this.timer_bind = null, this.flag = null, this.loadcount = null, G[this.loadid] = null, delete G[this.loadid], this.success = null, this.renderSuccess = null, this.compile = null, this.hash = null
    }, Loader.prototype.getHTML = function (t) {
        var i, n = this;
        if (/<\w+.*?>/.test(t.html)) return this.template = t.html, this.flag += 1, void this.flashHTML(t);
        i = t.html ? /\.html$/.test(t.html) ? t.html : G.map[t.module][t.html][0] : (G.map[t.module] instanceof Array ? G.map : G.map[t.module])[t.module][0], G.cache[i] ? (this.template = G.cache[i], this.flag += 1, this.flashHTML(t)) : G.util.getHTML({
            url: i,
            success: function (e) {
                n.template = G.cache[i] = e, n.flag += 1, t.hash && t.hash != G.util.getHash() && t.hash != G.tmp_hash || n.flashHTML(t, n.jsondata)
            },
            error: function () {
            }
        })
    }, Loader.prototype.getJSON = function (t, e) {
        var i, n = this, r = [];
        if (t.json ? /^\/.+/.test(t.json) ? i = t.json : "object" != typeof t.json && (i = (r = G.map[t.module][t.json])[1]) : t.module && (i = (r = G.map[t.module] instanceof Array ? G.map[t.module] : G.map[t.module][t.html || t.module])[1]), !i) return this.jsondata = r[2] ? r[2](this.jsondata, t.param) : t.json || this.jsondata, this.flag += 1, void this.flashHTML(t);
        if (r[3]) for (var a in r[3]) t.param[a] || (t.param[a] = r[3][a]);
        G.get({
            url: i, data: t.param, success: function (e) {
                n.flag += 1, n.jsondata = e, t.jsonSuccess ? n.jsondata = t.jsonSuccess(e) || e : r[2] && (n.jsondata = r[2](e, t.param)), t.hash && t.hash != G.util.getHash() && t.hash != G.tmp_hash || n.flashHTML(t)
            }, error: function () {
                t.jsonError && t.jsonError()
            }, business: t.business
        })
    }, Loader.prototype.flashHTML = function (a) {
        if (this.jsondata && this.jsondata.isCanceled) return !1;
        var e, t, i, s, o = this;
        if (!(this.flag < this.loadcount)) {
            var n, r = "";
            if (reg_include.test(this.template)) {
                for (e = this.template.match(reg_include), this.loadcount += e.length, t = 0, i = e.length; t < i; t++) s = e[t].split(/\s+/)[1], function () {
                    var i, t = s, n = "", r = new RegExp("#include\\s+" + s);
                    G.cache[t] ? (n = G.cache[t], o.template = o.template.replace(r, n), n = null, o.flag++, o.flashHTML(a)) : i = G.util.getHTML({
                        url: "/Htmls/" + t + ".html",
                        timeout: 5e3,
                        success: function (e) {
                            G.cache[t] = n = e
                        },
                        complete: function (e, t) {
                            "timeout" == t && i.abort(), o.template = o.template.replace(r, n), n = null, o.flag++, o.flashHTML(a)
                        }
                    })
                }();
                return !1
            }
            for (; reg_template.test(this.template);) tpl_id = this.template.match(reg_template)[1], match_tpl = (match_tpl = this.template.match(new RegExp("<script.*id=['\"]" + tpl_id + "['\"][^>]*?>([\\s\\S]*?)<\\/script>"))) && match_tpl[1] ? match_tpl[1] : "", this.template = this.template.replace(reg_template, match_tpl);
            this.template = this.template.replace(new RegExp("<script[^>]*?>[\\s\\S]*?<\\/script>", "ig"), function (e) {
                return r += e, ""
            }), this.jsondata.Param = a.param || {}, $.extend(this.jsondata, window.Global), n = G.util.compile(this.template, this.jsondata), n += r, this.render(n), r = null
        }
    }, Loader.prototype.bind = function (e, t) {
        e && e.length && $("div[name=module]", e).each(function () {
            var t = this, i = this.id;
            require([$(this).attr("use")], function (e) {
                G.instance[i] = new e(t), G.instance[i].init()
            })
        })
    }, Loader.prototype.unbind = function (e) {
        e && e.length && $("div[name=module]", e).each(function () {
            var e = this.id;
            G.instance[e] && (G.instance[e].destroy && G.instance[e].destroy(), this.json = null, G.util.destroy(G.instance[e]), G.instance[e] = null, delete G.instance[e])
        })
    };
    var G = {cache: {}, instance: {}, modules: {}, iclick: !1, tmp_hash: ""}, L8, M8;
    G.util = {
        compile: function (e, t) {
            return template.compile(e)(t)
        },
        load: function (e) {
            var t = $.now();
            G[t] = new Loader(e, t)
        },
        destroy: function (e) {
            var t, i;
            for (i in e.d && (t = e.d[0].id, e.d.off(), doc.off("." + t)), e) e[i] instanceof jQuery && (e[i].off(), e[i] = null, delete e[i])
        },
        getHTML: function (i) {
            return $.ajax({
                url: i.url + "?v=" + VERSION,
                timeout: i.timeout,
                dataType: "html",
                cache: i.cache || !0,
                success: function (e) {
                    i.success && i.success(e)
                },
                error: function () {
                    i.error && i.error()
                },
                complete: function (e, t) {
                    i.complete && i.complete(e, t)
                }
            })
        },
        setCookie: function (e, t) {
            var i = new Date;
            i.setTime(i.getTime() + 2592e6), document.cookie = e + "=" + escape(t) + ";expires=" + i.toGMTString() + ";path=/"
        },
        getCookie: function (e) {
            e = new RegExp("(^| )" + e + "=([^;]*)(;|$)"), e = document.cookie.match(e);
            return e ? unescape(e[2]) : null
        },
        delCookie: function (e) {
            var t = new Date;
            t.setTime(t.getTime() - 1);
            var i = G.util.getCookie(e);
            null != i && (document.cookie = e + "=" + i + ";expires=" + t.toGMTString())
        },
        formatHash: (L8 = ["^#!([a-zA-Z0-9_]+).?", "#![a-zA-Z0-9_]+\\.([a-zA-Z0-9_]+)", "\\|([a-zA-Z0-9_]+)", "\\?(.+)"], M8 = ["module", "html", "json", "param"], function (e) {
            for (var t, i, n, r = 0, a = {}, s = {}; L8[r];) t = e.match(new RegExp(L8[r])), a[M8[r]] = t ? t[1] : undefined, r++;
            return a.param && (i = a.param.split("&"), $.each(i, function (e, t) {
                n = t.split("="), s[n[0]] = n[1]
            }), a.param = s), a
        }),
        getHash: function (e) {
            return "#" + decodeURIComponent(e || location.href).replace(/^[^#]*#?(.*)$/, "$1")
        },
        setHash: function (e) {
            G.iclick = !0, G.tmp_hash = decodeURIComponent(e), G.util.reload(G.tmp_hash), /#!.+/.test(G.tmp_hash) ? (main.removeClass("hide"), $("#ifr_main").addClass("hide")) : (main.addClass("hide"), $("#ifr_main").removeClass("hide"), location.hash = "")
        },
        reload: function (e) {
            var t = G.util.getHash(e), i = G.util.formatHash(t), e = i.module;
            i.hash = t, i.refresh = !0, G.hashFn[e] && G.hashFn[e](i)
        },
        getQueryString: function (e) {
            e = new RegExp("(^|&)" + e + "=([^&]*)(&|$)", "i"), e = window.location.search.substr(1).match(e);
            return null != e ? unescape(e[2]) : null
        },
        key_digit: function (e) {
            var t = e.keyCode;
            return (!e.shiftKey && (47 < t && t < 58 || 95 < t && t < 106 || 46 == t || 8 == t || 9 == t || 13 == t || 37 == t || 39 == t) || 229 == t || 190 == t || 110 == t) && ("" != e.target.value || 48 != t && 96 != t)
        },
        emit: function (e, t) {
            document.getElementById("ifr_main").contentWindow.doc.triggerHandler(e, [t])
        }
    }, $(["get", "post"]).each(function (e, t) {
        G[t] = function (n) {
            $.ajax({
                url: SESSIONID + n.url,
                data: n.data,
                type: t,
                dataType: "json",
                cache: n.cache,
                "async": n["async"],
                success: function (e) {
                    switch (e.Status) {
                        case 2:
                            n.bussiness ? n.bussiness(e.Data) : $.alert(e.Data.replace(/\\r\\n/g, "<br>"));
                            break;
                        case 3:
                            if (STOP_POLLING) return !1;
                            STOP_POLLING = !0;
                            var t = location.protocol,
                                i = "" !== NAVIGATION_URL ? t + "//" + NAVIGATION_URL : "/" + window.SID + "/Member/Login";
                            "" !== e.Data ? $.alert(e.Data.replace(/\\r\\n/g, "<br/>"), function () {
                                location.href = i
                            }) : location.href = i;
                            break;
                        case 5:
                            $.alert(e.Data), $("#imgCaptcha").click(), $(".captchaContent").removeClass("hide");
                            break;
                        case 500:
                            $.alert(e.Data.replace(/\\r\\n/g, "<br>"));
                            break;
                        default:
                            n.success && n.success(e)
                    }
                },
                error: function (e, t, i) {
                    n.error && n.error(e, t, i), e.responseText && -1 < e.responseText.indexOf("tn_code") && window.top.location.reload()
                },
                complete: function (e, t) {
                    n.complete && n.complete(e, t)
                }
            })
        }
    }), $.extend(window, {
        Loader: Loader,
        G: G,
        main: $("#main"),
        loadModule: G.util.load,
        doc: $(document)
    }), doc.on("click", "a", function () {
        if (!this.target && /#!/.test(this.href)) {
            var e = G.util.getHash(this.href);
            return G.iclick = !0, G.tmp_hash = e, G.util.reload(G.tmp_hash), !1
        }
    }).on("setHash", function () {
        G.util.getHash(location.hash) == G.tmp_hash && (G.iclick = !1), location.hash = "#" + encodeURIComponent(G.tmp_hash.substring(1))
    })
}(window, jQuery), $(function () {
    G.hash = G.InitHash, $.fn.hashchange.src = "/Htmls/domain.html", $.fn.hashchange.domain = document.domain, $(window).hashchange(function () {
        var e, t, i;
        G.iclick ? (G.tmp_hash = null, G.iclick = !1) : (e = G.util.getHash(), i = (t = G.util.formatHash(e)).module, t.hash = e, G.hashFn[i] && G.hashFn[i](t), $.closeAll(), /#!.+/.test(e) ? (main.removeClass("hide"), $("#ifr_main").addClass("hide")) : (main.addClass("hide"), $("#ifr_main").removeClass("hide")))
    }), /#!\w+/.test(location.hash) ? main.length && G.util.setHash(G.util.getHash(location.hash)) : main.length && G.util.setHash(G.InitHash), Loader.prototype.bind($(document.body))
}), $.extend($, {
    unparam: function (e) {
        if ("" == e || e == undefined) return {};
        for (var t, i = e.split("&"), n = i.length, r = 0, a = {}; r < n; r++) a[(t = i[r].split("="))[0]] = t[1] ? decodeURIComponent(t[1]) : "";
        return a
    }
}), $.extend(G, {
    quickMoneyStatus: G.util.getCookie("quickMoneyStatus") || 0,
    quickMoneyList: G.util.getCookie("quickMoneyList") ? JSON.parse(G.util.getCookie("quickMoneyList")) : [],
    pre_set: !1,
    pre_money: "",
    multi_set: !1,
    multi_value: 100,
    savedHistorySendData: {}
}), $.extend(G.util, {
    prop: function () {
        var e = arguments;
        if (0 == e.length) return "";
        if (1 == e.length) return G[e[0]];
        if (e[2]) {
            G.util.setCookie(e[0], e[1]);
            try {
                G[e[0]] = JSON.parse(e[1])
            } catch (t) {
                G[e[0]] = e[1]
            }
        } else G[e[0]] = e[1]
    }
}), G.InitHash = "", G.map = {password: ["/Htmls/password.html"]}, G.hashFn = {
    supper: function () {
        var i = $("#nav a");
        return function (e) {
            var t = e.module;
            G.util.load({
                bd: main.scrollTop(0),
                module: t,
                param: e.param || {},
                html: e.html,
                json: e.json,
                hash: e.hash
            }), i.filter("[name=" + t + "]").addClass("active").siblings().removeClass("active")
        }
    }()
}, $.each(G.map, function (e) {
    G.hashFn[e] = G.hashFn.supper
}), $.validator.setDefaults({
    focusInvalid: !1, onfocusout: !1, onkeyup: !1, showErrors: function (e, t) {
        t.length && (t[0].element.focus(), layer.tips(t[0].message, t[0].element))
    }
}), layer.config({
    skin: "layer-custom", anim: -1, success: function (e, n) {
        $(".layui-layer-btn a:eq(0)", e).focus(), $("div[name=module]", e).each(function () {
            var t = this, i = this.id;
            require([$(this).attr("use")], function (e) {
                G.instance[i] = new e(t), G.instance[i].INDEX = n, G.instance[i].init()
            })
        })
    }, beforeClose: function (e) {
        $("[name=module]", e).each(function () {
            G.util.destroy(G.instance[this.id])
        })
    }
}), $.each(layer, function (e, t) {
    $[e] || ($[e] = t)
}), $.dialog = function (t) {
    G.util.load({
        module: t.module,
        param: t.param,
        html: t.html,
        json: t.json,
        jsonSuccess: t.jsonSuccess,
        success: function (e) {
            layer.open({
                type: 1,
                title: t.title,
                closeBtn: 1,
                area: [t.width || "auto", t.height || "auto"],
                shadeClose: !0,
                content: e,
                btn: t.btn
            })
        }
    })
}, function (global, setTimeout) {
    var req, s, head, baseElement, dataMain, src, interactiveScript, currentlyAddingScript, mainScript, subPath,
        version = "2.3.6", commentRegExp = /\/\*[\s\S]*?\*\/|([^:"'=]|^)\/\/.*$/gm,
        cjsRequireRegExp = /[^.]\s*require\s*\(\s*["']([^'"\s]+)["']\s*\)/g, jsSuffixRegExp = /\.js$/,
        currDirRegExp = /^\.\//, op = Object.prototype, ostring = op.toString, hasOwn = op.hasOwnProperty,
        isBrowser = !("undefined" == typeof window || "undefined" == typeof navigator || !window.document),
        isWebWorker = !isBrowser && "undefined" != typeof importScripts,
        readyRegExp = isBrowser && "PLAYSTATION 3" === navigator.platform ? /^complete$/ : /^(complete|loaded)$/,
        defContextName = "_", isOpera = "undefined" != typeof opera && "[object Opera]" === opera.toString(),
        contexts = {}, cfg = {}, globalDefQueue = [], useInteractive = !1;

    function commentReplace(e, t) {
        return t || ""
    }

    function isFunction(e) {
        return "[object Function]" === ostring.call(e)
    }

    function isArray(e) {
        return "[object Array]" === ostring.call(e)
    }

    function each(e, t) {
        var i;
        if (e) for (i = 0; i < e.length && (!e[i] || !t(e[i], i, e)); i += 1) ;
    }

    function eachReverse(e, t) {
        var i;
        if (e) for (i = e.length - 1; -1 < i && (!e[i] || !t(e[i], i, e)); --i) ;
    }

    function hasProp(e, t) {
        return hasOwn.call(e, t)
    }

    function getOwn(e, t) {
        return hasProp(e, t) && e[t]
    }

    function eachProp(e, t) {
        for (var i in e) if (hasProp(e, i) && t(e[i], i)) break
    }

    function mixin(i, e, n, r) {
        return e && eachProp(e, function (e, t) {
            !n && hasProp(i, t) || (!r || "object" != typeof e || !e || isArray(e) || isFunction(e) || e instanceof RegExp ? i[t] = e : (i[t] || (i[t] = {}), mixin(i[t], e, n, r)))
        }), i
    }

    function bind(e, t) {
        return function () {
            return t.apply(e, arguments)
        }
    }

    function scripts() {
        return document.getElementsByTagName("script")
    }

    function defaultOnError(e) {
        throw e
    }

    function getGlobal(e) {
        if (!e) return e;
        var t = global;
        return each(e.split("."), function (e) {
            t = t[e]
        }), t
    }

    function makeError(e, t, i, n) {
        t = new Error(t + "\nhttps://requirejs.org/docs/errors.html#" + e);
        return t.requireType = e, t.requireModules = n, i && (t.originalError = i), t
    }

    if (void 0 === define) {
        if (void 0 !== requirejs) {
            if (isFunction(requirejs)) return;
            cfg = requirejs, requirejs = void 0
        }
        void 0 === require || isFunction(require) || (cfg = require, require = void 0), req = requirejs = function (e, t, i, n) {
            var r, a = defContextName;
            return isArray(e) || "string" == typeof e || (r = e, isArray(t) ? (e = t, t = i, i = n) : e = []), r && r.context && (a = r.context), (n = getOwn(contexts, a)) || (n = contexts[a] = req.s.newContext(a)), r && n.configure(r), n.require(e, t, i)
        }, req.config = function (e) {
            return req(e)
        }, req.nextTick = void 0 !== setTimeout ? function (e) {
            setTimeout(e, 4)
        } : function (e) {
            e()
        }, require = require || req, req.version = version, req.jsExtRegExp = /^\/|:|\?|\.js$/, req.isBrowser = isBrowser, s = req.s = {
            contexts: contexts,
            newContext: newContext
        }, req({}), each(["toUrl", "undef", "defined", "specified"], function (t) {
            req[t] = function () {
                var e = contexts[defContextName];
                return e.require[t].apply(e, arguments)
            }
        }), isBrowser && (head = s.head = document.getElementsByTagName("head")[0], baseElement = document.getElementsByTagName("base")[0], baseElement && (head = s.head = baseElement.parentNode)), req.onError = defaultOnError, req.createNode = function (e, t, i) {
            var n = e.xhtml ? document.createElementNS("http://www.w3.org/1999/xhtml", "html:script") : document.createElement("script");
            return n.type = e.scriptType || "text/javascript", n.charset = "utf-8", n["async"] = !0, n
        }, req.load = function (e, t, i) {
            var n, r = e && e.config || {};
            if (isBrowser) return (n = req.createNode(r, t, i)).setAttribute("data-requirecontext", e.contextName), n.setAttribute("data-requiremodule", t), !n.attachEvent || n.attachEvent.toString && n.attachEvent.toString().indexOf("[native code") < 0 || isOpera ? (n.addEventListener("load", e.onScriptLoad, !1), n.addEventListener("error", e.onScriptError, !1)) : (useInteractive = !0, n.attachEvent("onreadystatechange", e.onScriptLoad)), n.src = i, r.onNodeCreated && r.onNodeCreated(n, r, t, i), currentlyAddingScript = n, baseElement ? head.insertBefore(n, baseElement) : head.appendChild(n), currentlyAddingScript = null, n;
            if (isWebWorker) try {
                setTimeout(function () {
                }, 0), importScripts(i), e.completeLoad(t)
            } catch (n) {
                e.onError(makeError("importscripts", "importScripts failed for " + t + " at " + i, n, [t]))
            }
        }, isBrowser && !cfg.skipDataMain && eachReverse(scripts(), function (e) {
            if (head = head || e.parentNode, dataMain = e.getAttribute("data-main")) return mainScript = dataMain, cfg.baseUrl || -1 !== mainScript.indexOf("!") || (mainScript = (src = mainScript.split("/")).pop(), subPath = src.length ? src.join("/") + "/" : "./", cfg.baseUrl = subPath), mainScript = mainScript.replace(jsSuffixRegExp, ""), req.jsExtRegExp.test(mainScript) && (mainScript = dataMain), cfg.deps = cfg.deps ? cfg.deps.concat(mainScript) : [mainScript], !0
        }), define = function (e, i, t) {
            var n, r;
            "string" != typeof e && (t = i, i = e, e = null), isArray(i) || (t = i, i = null), !i && isFunction(t) && (i = [], t.length && (t.toString().replace(commentRegExp, commentReplace).replace(cjsRequireRegExp, function (e, t) {
                i.push(t)
            }), i = (1 === t.length ? ["require"] : ["require", "exports", "module"]).concat(i))), useInteractive && (n = currentlyAddingScript || getInteractiveScript()) && (e = e || n.getAttribute("data-requiremodule"), r = contexts[n.getAttribute("data-requirecontext")]), r ? (r.defQueue.push([e, i, t]), r.defQueueMap[e] = !0) : globalDefQueue.push([e, i, t])
        }, define.amd = {jQuery: !0}, req.exec = function (text) {
            return eval(text)
        }, req(cfg)
    }

    function newContext(l) {
        var t, e, h, u, i, m = {waitSeconds: 7, baseUrl: "./", paths: {}, bundles: {}, pkgs: {}, shim: {}, config: {}},
            d = {}, c = {}, n = {}, f = [], p = {}, r = {}, g = {}, v = 1, y = 1;

        function b(e, t, i) {
            var n, r, a, s, o, l, u, d, c, h = t && t.split("/"), f = m.map, p = f && f["*"];
            if (e && (t = (e = e.split("/")).length - 1, m.nodeIdCompat && jsSuffixRegExp.test(e[t]) && (e[t] = e[t].replace(jsSuffixRegExp, "")), function (e) {
                for (var t, i = 0; i < e.length; i++) if ("." === (t = e[i])) e.splice(i, 1), --i; else if (".." === t) {
                    if (0 === i || 1 === i && ".." === e[2] || ".." === e[i - 1]) continue;
                    0 < i && (e.splice(i - 1, 2), i -= 2)
                }
            }(e = "." === e[0].charAt(0) && h ? h.slice(0, h.length - 1).concat(e) : e), e = e.join("/")), i && f && (h || p)) {
                e:for (a = (r = e.split("/")).length; 0 < a; --a) {
                    if (o = r.slice(0, a).join("/"), h) for (s = h.length; 0 < s; --s) if ((n = getOwn(f, h.slice(0, s).join("/"))) && (n = getOwn(n, o))) {
                        l = n, u = a;
                        break e
                    }
                    !d && p && getOwn(p, o) && (d = getOwn(p, o), c = a)
                }
                !l && d && (l = d, u = c), l && (r.splice(0, u, l), e = r.join("/"))
            }
            return getOwn(m.pkgs, e) || e
        }

        function x(t) {
            isBrowser && each(scripts(), function (e) {
                if (e.getAttribute("data-requiremodule") === t && e.getAttribute("data-requirecontext") === h.contextName) return e.parentNode.removeChild(e), !0
            })
        }

        function w(e) {
            var t = getOwn(m.paths, e);
            return t && isArray(t) && 1 < t.length && (t.shift(), h.require.undef(e), h.makeRequire(null, {skipMap: !0})([e]), 1)
        }

        function S(e) {
            var t, i = e ? e.indexOf("!") : -1;
            return -1 < i && (t = e.substring(0, i), e = e.substring(i + 1, e.length)), [t, e]
        }

        function k(e, t, i, n) {
            var r, a, s, o = null, l = t ? t.name : null, u = e, d = !0, c = "";
            return e || (d = !1, e = "_@r" + (v += 1)), o = (s = S(e))[0], e = s[1], o && (o = b(o, l, n), a = getOwn(p, o)), e && (o ? c = i ? e : a && a.normalize ? a.normalize(e, function (e) {
                return b(e, l, n)
            }) : -1 === e.indexOf("!") ? b(e, l, n) : e : (o = (s = S(c = b(e, l, n)))[0], c = s[1], i = !0, r = h.nameToUrl(c))), {
                prefix: o,
                name: c,
                parentMap: t,
                unnormalized: !!(i = !o || a || i ? "" : "_unnormalized" + (y += 1)),
                url: r,
                originalName: u,
                isDefine: d,
                id: (o ? o + "!" + c : c) + i
            }
        }

        function C(e) {
            var t = e.id;
            return getOwn(d, t) || (d[t] = new h.Module(e))
        }

        function M(e, t, i) {
            var n = e.id, r = getOwn(d, n);
            !hasProp(p, n) || r && !r.defineEmitComplete ? (r = C(e)).error && "error" === t ? i(r.error) : r.on(t, i) : "defined" === t && i(p[n])
        }

        function T(t, e) {
            var i = t.requireModules, n = !1;
            e ? e(t) : (each(i, function (e) {
                e = getOwn(d, e);
                e && (e.error = t, e.events.error && (n = !0, e.emit("error", t)))
            }), n || req.onError(t))
        }

        function E() {
            globalDefQueue.length && (each(globalDefQueue, function (e) {
                var t = e[0];
                "string" == typeof t && (h.defQueueMap[t] = !0), f.push(e)
            }), globalDefQueue = [])
        }

        function I(e) {
            delete d[e], delete c[e]
        }

        function A() {
            var n, e = 1e3 * m.waitSeconds, s = e && h.startTime + e < (new Date).getTime(), r = [], a = [], o = !1,
                l = !0;
            if (!t) {
                if (t = !0, eachProp(c, function (e) {
                    var t = e.map, i = t.id;
                    if (e.enabled && (t.isDefine || a.push(e), !e.error)) if (!e.inited && s) w(i) ? o = n = !0 : (r.push(i), x(i)); else if (!e.inited && e.fetched && t.isDefine && (o = !0, !t.prefix)) return l = !1
                }), s && r.length) return (e = makeError("timeout", "Load timeout for modules: " + r, null, r)).contextName = h.contextName, T(e), 0;
                l && each(a, function (e) {
                    !function s(n, r, a) {
                        var e = n.map.id;
                        n.error ? n.emit("error", n.error) : (r[e] = !0, each(n.depMaps, function (e, t) {
                            var i = e.id, e = getOwn(d, i);
                            !e || n.depMatched[t] || a[i] || (getOwn(r, i) ? (n.defineDep(t, p[i]), n.check()) : s(e, r, a))
                        }), a[e] = !0)
                    }(e, {}, {})
                }), s && !n || !o || !isBrowser && !isWebWorker || i || (i = setTimeout(function () {
                    i = 0, A()
                }, 50)), t = !1
            }
        }

        function s(e) {
            hasProp(p, e[0]) || C(k(e[0], null, !0)).init(e[1], e[2])
        }

        function a(e, t, i, n) {
            e.detachEvent && !isOpera ? n && e.detachEvent(n, t) : e.removeEventListener(i, t, !1)
        }

        function o(e) {
            e = e.currentTarget || e.srcElement;
            return a(e, h.onScriptLoad, "load", "onreadystatechange"), a(e, h.onScriptError, "error"), {
                node: e,
                id: e && e.getAttribute("data-requiremodule")
            }
        }

        function $() {
            var e;
            for (E(); f.length;) {
                if (null === (e = f.shift())[0]) return T(makeError("mismatch", "Mismatched anonymous define() module: " + e[e.length - 1])), 0;
                s(e)
            }
            h.defQueueMap = {}
        }

        return u = {
            require: function (e) {
                return e.require || (e.require = h.makeRequire(e.map))
            }, exports: function (e) {
                if (e.usingExports = !0, e.map.isDefine) return e.exports ? p[e.map.id] = e.exports : e.exports = p[e.map.id] = {}
            }, module: function (e) {
                return e.module || (e.module = {
                    id: e.map.id, uri: e.map.url, config: function () {
                        return getOwn(m.config, e.map.id) || {}
                    }, exports: e.exports || (e.exports = {})
                })
            }
        }, (e = function (e) {
            this.events = getOwn(n, e.id) || {}, this.map = e, this.shim = getOwn(m.shim, e.id), this.depExports = [], this.depMaps = [], this.depMatched = [], this.pluginMaps = {}, this.depCount = 0
        }).prototype = {
            init: function (e, t, i, n) {
                n = n || {}, this.inited || (this.factory = t, i ? this.on("error", i) : this.events.error && (i = bind(this, function (e) {
                    this.emit("error", e)
                })), this.depMaps = e && e.slice(0), this.errback = i, this.inited = !0, this.ignore = n.ignore, n.enabled || this.enabled ? this.enable() : this.check())
            }, defineDep: function (e, t) {
                this.depMatched[e] || (this.depMatched[e] = !0, --this.depCount, this.depExports[e] = t)
            }, fetch: function () {
                if (!this.fetched) {
                    this.fetched = !0, h.startTime = (new Date).getTime();
                    var e = this.map;
                    if (!this.shim) return e.prefix ? this.callPlugin() : this.load();
                    h.makeRequire(this.map, {enableBuildCallback: !0})(this.shim.deps || [], bind(this, function () {
                        return e.prefix ? this.callPlugin() : this.load()
                    }))
                }
            }, load: function () {
                var e = this.map.url;
                r[e] || (r[e] = !0, h.load(this.map.id, e))
            }, check: function () {
                if (this.enabled && !this.enabling) {
                    var e, t, i, n = this.map.id, r = this.depExports, a = this.exports, s = this.factory;
                    if (this.inited) {
                        if (this.error) this.emit("error", this.error); else if (!this.defining) {
                            if (this.defining = !0, this.depCount < 1 && !this.defined) {
                                if (isFunction(s)) {
                                    if (this.events.error && this.map.isDefine || req.onError !== defaultOnError) try {
                                        a = h.execCb(n, s, r, a)
                                    } catch (t) {
                                        e = t
                                    } else a = h.execCb(n, s, r, a);
                                    if (this.map.isDefine && void 0 === a && ((t = this.module) ? a = t.exports : this.usingExports && (a = this.exports)), e) return e.requireMap = this.map, e.requireModules = this.map.isDefine ? [this.map.id] : null, e.requireType = this.map.isDefine ? "define" : "require", T(this.error = e)
                                } else a = s;
                                this.exports = a, this.map.isDefine && !this.ignore && (p[n] = a, req.onResourceLoad) && (i = [], each(this.depMaps, function (e) {
                                    i.push(e.normalizedMap || e)
                                }), req.onResourceLoad(h, this.map, i)), I(n), this.defined = !0
                            }
                            this.defining = !1, this.defined && !this.defineEmitted && (this.defineEmitted = !0, this.emit("defined", this.exports), this.defineEmitComplete = !0)
                        }
                    } else hasProp(h.defQueueMap, n) || this.fetch()
                }
            }, callPlugin: function () {
                var o = this.map, l = o.id, e = k(o.prefix);
                this.depMaps.push(e), M(e, "defined", bind(this, function (e) {
                    var a, t, i = getOwn(g, this.map.id), n = this.map.name,
                        r = this.map.parentMap ? this.map.parentMap.name : null,
                        s = h.makeRequire(o.parentMap, {enableBuildCallback: !0});
                    return this.map.unnormalized ? (e.normalize && (n = e.normalize(n, function (e) {
                        return b(e, r, !0)
                    }) || ""), M(t = k(o.prefix + "!" + n, this.map.parentMap, !0), "defined", bind(this, function (e) {
                        this.map.normalizedMap = t, this.init([], function () {
                            return e
                        }, null, {enabled: !0, ignore: !0})
                    })), void ((n = getOwn(d, t.id)) && (this.depMaps.push(t), this.events.error && n.on("error", bind(this, function (e) {
                        this.emit("error", e)
                    })), n.enable()))) : i ? (this.map.url = h.nameToUrl(i), void this.load()) : ((a = bind(this, function (e) {
                        this.init([], function () {
                            return e
                        }, null, {enabled: !0})
                    })).error = bind(this, function (e) {
                        this.inited = !0, (this.error = e).requireModules = [l], eachProp(d, function (e) {
                            0 === e.map.id.indexOf(l + "_unnormalized") && I(e.map.id)
                        }), T(e)
                    }), a.fromText = bind(this, function (e, t) {
                        var i = o.name, n = k(i), r = useInteractive;
                        t && (e = t), r && (useInteractive = !1), C(n), hasProp(m.config, l) && (m.config[i] = m.config[l]);
                        try {
                            req.exec(e)
                        } catch (e) {
                            return T(makeError("fromtexteval", "fromText eval for " + l + " failed: " + e, e, [l]))
                        }
                        r && (useInteractive = !0), this.depMaps.push(n), h.completeLoad(i), s([i], a)
                    }), void e.load(o.name, s, a, m))
                })), h.enable(e, this), this.pluginMaps[e.id] = e
            }, enable: function () {
                (c[this.map.id] = this).enabled = !0, this.enabling = !0, each(this.depMaps, bind(this, function (e, t) {
                    var i, n;
                    if ("string" == typeof e) {
                        if (e = k(e, this.map.isDefine ? this.map : this.map.parentMap, !1, !this.skipMap), this.depMaps[t] = e, n = getOwn(u, e.id)) return void (this.depExports[t] = n(this));
                        this.depCount += 1, M(e, "defined", bind(this, function (e) {
                            this.undefed || (this.defineDep(t, e), this.check())
                        })), this.errback ? M(e, "error", bind(this, this.errback)) : this.events.error && M(e, "error", bind(this, function (e) {
                            this.emit("error", e)
                        }))
                    }
                    i = e.id, n = d[i], hasProp(u, i) || !n || n.enabled || h.enable(e, this)
                })), eachProp(this.pluginMaps, bind(this, function (e) {
                    var t = getOwn(d, e.id);
                    t && !t.enabled && h.enable(e, this)
                })), this.enabling = !1, this.check()
            }, on: function (e, t) {
                (this.events[e] || (this.events[e] = [])).push(t)
            }, emit: function (e, t) {
                each(this.events[e], function (e) {
                    e(t)
                }), "error" === e && delete this.events[e]
            }
        }, (h = {
            config: m,
            contextName: l,
            registry: d,
            defined: p,
            urlFetched: r,
            defQueue: f,
            defQueueMap: {},
            Module: e,
            makeModuleMap: k,
            nextTick: req.nextTick,
            onError: T,
            configure: function (e) {
                var i;
                e.baseUrl && "/" !== e.baseUrl.charAt(e.baseUrl.length - 1) && (e.baseUrl += "/"), "string" == typeof e.urlArgs && (i = e.urlArgs, e.urlArgs = function (e, t) {
                    return (-1 === t.indexOf("?") ? "?" : "&") + i
                });
                var n = m.shim, r = {paths: !0, bundles: !0, config: !0, map: !0};
                eachProp(e, function (e, t) {
                    r[t] ? (m[t] || (m[t] = {}), mixin(m[t], e, !0, !0)) : m[t] = e
                }), e.bundles && eachProp(e.bundles, function (e, t) {
                    each(e, function (e) {
                        e !== t && (g[e] = t)
                    })
                }), e.shim && (eachProp(e.shim, function (e, t) {
                    !(e = isArray(e) ? {deps: e} : e).exports && !e.init || e.exportsFn || (e.exportsFn = h.makeShimExports(e)), n[t] = e
                }), m.shim = n), e.packages && each(e.packages, function (e) {
                    var t = (e = "string" == typeof e ? {name: e} : e).name;
                    e.location && (m.paths[t] = e.location), m.pkgs[t] = e.name + "/" + (e.main || "main").replace(currDirRegExp, "").replace(jsSuffixRegExp, "")
                }), eachProp(d, function (e, t) {
                    e.inited || e.map.unnormalized || (e.map = k(t, null, !0))
                }), (e.deps || e.callback) && h.require(e.deps || [], e.callback)
            },
            makeShimExports: function (t) {
                return function () {
                    var e;
                    return (e = t.init ? t.init.apply(global, arguments) : e) || t.exports && getGlobal(t.exports)
                }
            },
            makeRequire: function (a, s) {
                function o(e, t, i) {
                    var n, r;
                    return s.enableBuildCallback && t && isFunction(t) && (t.__requireJsBuild = !0), "string" == typeof e ? isFunction(t) ? T(makeError("requireargs", "Invalid require call"), i) : a && hasProp(u, e) ? u[e](d[a.id]) : req.get ? req.get(h, e, a, o) : (n = k(e, a, !1, !0).id, hasProp(p, n) ? p[n] : T(makeError("notloaded", 'Module name "' + n + '" has not been loaded yet for context: ' + l + (a ? "" : ". Use require([])")))) : ($(), h.nextTick(function () {
                        $(), (r = C(k(null, a))).skipMap = s.skipMap, r.init(e, t, i, {enabled: !0}), A()
                    }), o)
                }

                return s = s || {}, mixin(o, {
                    isBrowser: isBrowser, toUrl: function (e) {
                        var t, i = e.lastIndexOf("."), n = e.split("/")[0];
                        return -1 !== i && ("." !== n && ".." !== n || 1 < i) && (t = e.substring(i, e.length), e = e.substring(0, i)), h.nameToUrl(b(e, a && a.id, !0), t, !0)
                    }, defined: function (e) {
                        return hasProp(p, k(e, a, !1, !0).id)
                    }, specified: function (e) {
                        return e = k(e, a, !1, !0).id, hasProp(p, e) || hasProp(d, e)
                    }
                }), a || (o.undef = function (i) {
                    E();
                    var e = k(i, a, !0), t = getOwn(d, i);
                    t.undefed = !0, x(i), delete p[i], delete r[e.url], delete n[i], eachReverse(f, function (e, t) {
                        e[0] === i && f.splice(t, 1)
                    }), delete h.defQueueMap[i], t && (t.events.defined && (n[i] = t.events), I(i))
                }), o
            },
            enable: function (e) {
                getOwn(d, e.id) && C(e).enable()
            },
            completeLoad: function (e) {
                var t, i, n, r = getOwn(m.shim, e) || {}, a = r.exports;
                for (E(); f.length;) {
                    if (null === (i = f.shift())[0]) {
                        if (i[0] = e, t) break;
                        t = !0
                    } else i[0] === e && (t = !0);
                    s(i)
                }
                if (h.defQueueMap = {}, n = getOwn(d, e), !t && !hasProp(p, e) && n && !n.inited) {
                    if (!(!m.enforceDefine || a && getGlobal(a))) return w(e) ? void 0 : T(makeError("nodefine", "No define call for " + e, null, [e]));
                    s([e, r.deps || [], r.exportsFn])
                }
                A()
            },
            nameToUrl: function (e, t, i) {
                var n, r, a, s, o, l = getOwn(m.pkgs, e);
                if (l = getOwn(g, e = l ? l : e)) return h.nameToUrl(l, t, i);
                if (req.jsExtRegExp.test(e)) s = e + (t || ""); else {
                    for (n = m.paths, a = (r = e.split("/")).length; 0 < a; --a) if (o = getOwn(n, r.slice(0, a).join("/"))) {
                        isArray(o) && (o = o[0]), r.splice(0, a, o);
                        break
                    }
                    s = r.join("/"), s = ("/" === (s += t || (/^data\:|^blob\:|\?/.test(s) || i ? "" : ".js")).charAt(0) || s.match(/^[\w\+\.\-]+:/) ? "" : m.baseUrl) + s
                }
                return m.urlArgs && !/^blob\:/.test(s) ? s + m.urlArgs(e, s) : s
            },
            load: function (e, t) {
                req.load(h, e, t)
            },
            execCb: function (e, t, i, n) {
                return t.apply(n, i)
            },
            onScriptLoad: function (e) {
                "load" !== e.type && !readyRegExp.test((e.currentTarget || e.srcElement).readyState) || (interactiveScript = null, e = o(e), h.completeLoad(e.id))
            },
            onScriptError: function (e) {
                var i = o(e);
                if (!w(i.id)) {
                    var n = [];
                    return eachProp(d, function (e, t) {
                        0 !== t.indexOf("_@r") && each(e.depMaps, function (e) {
                            if (e.id === i.id) return n.push(t), !0
                        })
                    }), T(makeError("scripterror", 'Script error for "' + i.id + (n.length ? '", needed by: ' + n.join(", ") : '"'), e, [i.id]))
                }
            }
        }).require = h.makeRequire(), h
    }

    function getInteractiveScript() {
        return interactiveScript && "interactive" === interactiveScript.readyState || eachReverse(scripts(), function (e) {
            if ("interactive" === e.readyState) return interactiveScript = e
        }), interactiveScript
    }
}(this, "undefined" == typeof setTimeout ? void 0 : setTimeout), define("jquery", [], function () {
    return jQuery
}), requirejs.config({
    baseUrl: "/Scripts",
    waitSeconds: 0,
    paths: {
        rcss: "App/Libs/require.css",
        util: "App/util",
        "jquery-calendar": "App/Plugins/Calendar/jquery.calendar",
        sortable: "App/Plugins/Sortable/sortable.min"
    },
    map: {"*": {css: "rcss"}},
    shim: {"jquery-calendar": ["css!App/Plugins/Calendar/jquery.calendar.css"]}
});