(window.webpackJsonp = window.webpackJsonp || []).push([[154], {
    564: function (t, e, n) {
        "use strict";
        n.r(e);
        var r = n(0), o = n.n(r),
            a = (n(36), n(37), n(38), n(39), n(100), n(320), n(115), n(136), n(321), n(30), n(222), n(72), n(114), n(74), n(682), n(111), n(73), n(82), n(55), n(323), n(18), n(43), n(56), n(31), n(33), n(116), n(34), n(58), n(19)),
            i = n(1), u = n(8), c = (n(7).immutable, function (t) {
                return Object(u.c)("/rest/member/dragon/games?count=" + t, {method: "GET", cancelable: !1})
            }), l = function (t) {
                return Object(u.c)("/rest/member/multiplePeriod", {method: "POST", data: t, cancelable: !1})
            }, s = function (t) {
                return Object(u.c)("/rest/member/multipleOdds", {method: "POST", data: t, cancelable: !1})
            }, d = function (t) {
                return Object(u.c)("/rest/member/dragon/betCount", {method: "POST", data: t, cancelable: !1})
            }, f = function (t) {
                return Object(u.c)("/rest/member/dragon/bet", {method: "POST", data: t, cancelable: !1})
            }, m = n(50), p = n(4);

        function g(t) {
            return (g = "function" === typeof Symbol && "symbol" === typeof Symbol.iterator ? function (t) {
                return typeof t
            } : function (t) {
                return t && "function" === typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
            })(t)
        }

        function b(t) {
            return function (t) {
                if (Array.isArray(t)) return h(t)
            }(t) || function (t) {
                if ("undefined" !== typeof Symbol && Symbol.iterator in Object(t)) return Array.from(t)
            }(t) || function (t, e) {
                if (!t) return;
                if ("string" === typeof t) return h(t, e);
                var n = Object.prototype.toString.call(t).slice(8, -1);
                "Object" === n && t.constructor && (n = t.constructor.name);
                if ("Map" === n || "Set" === n) return Array.from(n);
                if ("Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return h(t, e)
            }(t) || function () {
                throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
            }()
        }

        function h(t, e) {
            (null == e || e > t.length) && (e = t.length);
            for (var n = 0, r = new Array(e); n < e; n++) r[n] = t[n];
            return r
        }

        function y(t, e) {
            for (var n = 0; n < e.length; n++) {
                var r = e[n];
                r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
            }
        }

        function v(t) {
            return function () {
                var e, n = x(t);
                if (function () {
                    if ("undefined" === typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" === typeof Proxy) return !0;
                    try {
                        return Date.prototype.toString.call(Reflect.construct(Date, [], function () {
                        })), !0
                    } catch (t) {
                        return !1
                    }
                }()) {
                    var r = x(this).constructor;
                    e = Reflect.construct(n, arguments, r)
                } else e = n.apply(this, arguments);
                return function (t, e) {
                    if (e && ("object" === g(e) || "function" === typeof e)) return e;
                    return w(t)
                }(this, e)
            }
        }

        function w(t) {
            if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            return t
        }

        function x(t) {
            return (x = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) {
                return t.__proto__ || Object.getPrototypeOf(t)
            })(t)
        }

        function E(t, e) {
            return (E = Object.setPrototypeOf || function (t, e) {
                return t.__proto__ = e, t
            })(t, e)
        }

        var O, k = n(7).immutable, B = function (t, e, n, r) {
                return new (n || (n = Promise))(function (o, a) {
                    function i(t) {
                        try {
                            c(r.next(t))
                        } catch (e) {
                            a(e)
                        }
                    }

                    function u(t) {
                        try {
                            c(r.throw(t))
                        } catch (e) {
                            a(e)
                        }
                    }

                    function c(t) {
                        var e;
                        t.done ? o(t.value) : (e = t.value, e instanceof n ? e : new n(function (t) {
                            t(e)
                        })).then(i, u)
                    }

                    c((r = r.apply(t, e || [])).next())
                })
            }, I = [{value: 6, label: "6"}, {value: 8, label: "8"}, {value: 10, label: "10"}, {value: 12, label: "12"}],
            S = {
                dragonCount: 6,
                dragonGameItem: void 0,
                periodItem: void 0,
                oddsItem: void 0,
                betCountItem: void 0,
                betButtonItem: void 0,
                betQueryItem: Object(i.List)([]),
                inputBetAmount: 0,
                totalBetAmount: 0,
                showDragonBetResult: !1,
                dragonBetResult: void 0,
                setDragonCount: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                fetchDragonGameItems: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                fetchPeriodItems: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                fetchOddsItems: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                fetchBetCountItems: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                fetchDragonBetResult: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                getUpdate: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                getCountUpdate: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                setBetButtonState: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                updateBetButtonState: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                onClickButton: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                onTimerFinish: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                onPlaceBet: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                onCanceBet: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                setInputBetAmount: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                setBetAmount: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                setAllBetAmount: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                setTotalBetAmount: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                },
                setDragonBetResult: function () {
                    return B(void 0, void 0, void 0, regeneratorRuntime.mark(function t() {
                        return regeneratorRuntime.wrap(function (t) {
                            for (; ;) switch (t.prev = t.next) {
                                case 0:
                                case"end":
                                    return t.stop()
                            }
                        }, t)
                    }))
                }
            }, C = o.a.createContext(S), R = function (t) {
                !function (t, e) {
                    if ("function" !== typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
                    t.prototype = Object.create(e && e.prototype, {
                        constructor: {
                            value: t,
                            writable: !0,
                            configurable: !0
                        }
                    }), e && E(t, e)
                }(u, o.a.PureComponent);
                var e, n, r, a = v(u);

                function u(t) {
                    var e;
                    return function (t, e) {
                        if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                    }(this, u), (e = a.call(this, t)).checkEmptyGame = function () {
                        var t = e.state, n = k(t, "dragonGameItem"), r = k(t, "dragonCount"), o = e.actions,
                            a = k(o, "fetchDragonGameItems"), i = k(o, "setBetButtonState");
                        n.length < 1 && a(r).then(function () {
                            return i()
                        })
                    }, e.checkGamePause = function () {
                        var t = e.actions, n = k(t, "fetchDragonGameItems"), r = k(t, "setBetButtonState"), o = e.state,
                            a = k(o, "dragonCount"), i = k(o, "periodItem");
                        void 0 != i && (i.filter(function (t) {
                            return 1 === t.status
                        }).length < 1 && n(a).then(function () {
                            return r()
                        }))
                    }, e.setodds = function (t, e) {
                        var n = e.find(function (e) {
                            return e.lottery === t
                        });
                        if (n) return Object.keys(n).reduce(function (t, e) {
                            return "lottery" === e ? t : t.concat([{key: e, odds: n[e]}])
                        }, [])
                    }, e.actions = {
                        fetchDragonGameItems: function (t) {
                            return B(w(e), void 0, void 0, regeneratorRuntime.mark(function e() {
                                var n, r, o, a = this;
                                return regeneratorRuntime.wrap(function (e) {
                                    for (; ;) switch (e.prev = e.next) {
                                        case 0:
                                            return n = k(this.actions, "getUpdate"), e.prev = 1, e.next = 4, c(String(t));
                                        case 4:
                                            r = e.sent, o = k(r, "result"), this.setState({dragonGameItem: o}, function () {
                                                return n(a.state.dragonGameItem)
                                            }), e.next = 12;
                                            break;
                                        case 9:
                                            e.prev = 9, e.t0 = e.catch(1), e.t0;
                                        case 12:
                                        case"end":
                                            return e.stop()
                                    }
                                }, e, this, [[1, 9]])
                            }))
                        }, setDragonCount: function (t) {
                            try {
                                var n = e.actions, r = k(n, "fetchDragonGameItems"), o = k(n, "getCountUpdate");
                                e.setState({dragonCount: t}, function () {
                                    return r(e.state.dragonCount).then(function () {
                                        o(e.state.dragonGameItem)
                                    })
                                })
                            } catch (a) {
                            }
                        }, fetchPeriodItems: function (t) {
                            return B(w(e), void 0, void 0, regeneratorRuntime.mark(function e() {
                                var n, r, o = this;
                                return regeneratorRuntime.wrap(function (e) {
                                    for (; ;) switch (e.prev = e.next) {
                                        case 0:
                                            return e.prev = 0, e.next = 3, l(t);
                                        case 3:
                                            n = e.sent, r = k(n, "result"), this.setState({periodItem: r}, function () {
                                                return console.log("periodItem", o.state.periodItem)
                                            }), e.next = 11;
                                            break;
                                        case 8:
                                            e.prev = 8, e.t0 = e.catch(0), e.t0;
                                        case 11:
                                        case"end":
                                            return e.stop()
                                    }
                                }, e, this, [[0, 8]])
                            }))
                        }, fetchOddsItems: function (t) {
                            return B(w(e), void 0, void 0, regeneratorRuntime.mark(function e() {
                                var n, r, o = this;
                                return regeneratorRuntime.wrap(function (e) {
                                    for (; ;) switch (e.prev = e.next) {
                                        case 0:
                                            return e.prev = 0, e.next = 3, s(t);
                                        case 3:
                                            n = e.sent, r = k(n, "result"), this.setState({oddsItem: r}, function () {
                                                return console.log("oddsItem", o.state.oddsItem)
                                            }), e.next = 11;
                                            break;
                                        case 8:
                                            e.prev = 8, e.t0 = e.catch(0), e.t0;
                                        case 11:
                                        case"end":
                                            return e.stop()
                                    }
                                }, e, this, [[0, 8]])
                            }))
                        }, fetchBetCountItems: function (t) {
                            return B(w(e), void 0, void 0, regeneratorRuntime.mark(function e() {
                                var n, r, o = this;
                                return regeneratorRuntime.wrap(function (e) {
                                    for (; ;) switch (e.prev = e.next) {
                                        case 0:
                                            return e.prev = 0, e.next = 3, d(t);
                                        case 3:
                                            n = e.sent, r = k(n, "result"), this.setState({betCountItem: r.queries}, function () {
                                                return console.log("betCountItem", o.state.betCountItem)
                                            }), e.next = 11;
                                            break;
                                        case 8:
                                            e.prev = 8, e.t0 = e.catch(0), e.t0;
                                        case 11:
                                        case"end":
                                            return e.stop()
                                    }
                                }, e, this, [[0, 8]])
                            }))
                        }, fetchDragonBetResult: function (t) {
                            return B(w(e), void 0, void 0, regeneratorRuntime.mark(function e() {
                                var n, r;
                                return regeneratorRuntime.wrap(function (e) {
                                    for (; ;) switch (e.prev = e.next) {
                                        case 0:
                                            return e.prev = 0, e.next = 3, f(t);
                                        case 3:
                                            n = e.sent, r = k(n, "result"), this.setState({dragonBetResult: r}, this.actions.setTotalBetAmount), Object(p.a)(Object(m.f)()), e.next = 12;
                                            break;
                                        case 9:
                                            e.prev = 9, e.t0 = e.catch(0), e.t0;
                                        case 12:
                                        case"end":
                                            return e.stop()
                                    }
                                }, e, this, [[0, 9]])
                            }))
                        }, onTimerFinish: function (t) {
                            var n = e.state, r = k(n, "dragonGameItem"), o = k(n, "betButtonItem"),
                                a = r.find(function (e) {
                                    return e.lottery === t
                                }), i = b(r), u = b(o), c = r.indexOf(a);
                            i.splice(c, 1), u.splice(c, 1), e.setState({dragonGameItem: i, betButtonItem: u}, function () {
                                return e.checkEmptyGame()
                            })
                        }, onClickButton: function (t) {
                            var n = k(e.state, "betButtonItem");
                            if (void 0 != n) {
                                var r = n.find(function (e) {
                                    return e.redButton.key === t.key && e.redButton.lottery === t.lottery
                                }), o = n.find(function (e) {
                                    return e.blueButton.key === t.key && e.blueButton.lottery === t.lottery
                                }), a = n.indexOf(r), i = b(n);
                                void 0 != r && (r.redButton.isSelected = !r.redButton.isSelected, i[a], e.setState({betButtonItem: i})), void 0 != o && (o.blueButton.isSelected = !o.blueButton.isSelected, i[a], e.setState({betButtonItem: i}))
                            }
                        }, getUpdate: function (t) {
                            return B(w(e), void 0, void 0, regeneratorRuntime.mark(function e() {
                                var n, r, o, a, i, u, c, l;
                                return regeneratorRuntime.wrap(function (e) {
                                    for (; ;) switch (e.prev = e.next) {
                                        case 0:
                                            n = this.actions, r = k(n, "fetchPeriodItems"), o = k(n, "fetchOddsItems"), a = k(n, "fetchBetCountItems"), i = k(n, "updateBetButtonState"), u = [], c = [], l = [], t && t.map(function (t) {
                                                u.push({lottery: t.lottery}), c.push({
                                                    lottery: t.lottery,
                                                    games: t.game
                                                }), l.push({game: t.game, lottery: t.lottery, drawNumber: t.drawNumber})
                                            }), this.state.dragonGameItem.length > 0 && (r({periodRequests: u}), o({oddsRequests: c}), a({queries: l}), i(), this.checkGamePause());
                                        case 11:
                                        case"end":
                                            return e.stop()
                                    }
                                }, e, this)
                            }))
                        }, getCountUpdate: function (t) {
                            return B(w(e), void 0, void 0, regeneratorRuntime.mark(function e() {
                                var n, r, o, a, u, c, l, s, d;
                                return regeneratorRuntime.wrap(function (e) {
                                    for (; ;) switch (e.prev = e.next) {
                                        case 0:
                                            n = this.actions, r = k(n, "fetchPeriodItems"), o = k(n, "fetchOddsItems"), a = k(n, "setTotalBetAmount"), u = k(n, "fetchBetCountItems"), c = k(n, "setBetButtonState"), l = [], s = [], d = [], t && t.map(function (t) {
                                                l.push({lottery: t.lottery}), s.push({
                                                    lottery: t.lottery,
                                                    games: t.game
                                                }), d.push({game: t.game, lottery: t.lottery, drawNumber: t.drawNumber})
                                            }), this.state.dragonGameItem.length > 0 && (r({periodRequests: l}), o({oddsRequests: s}), u({queries: d}), c()), this.setState({betQueryItem: Object(i.List)([])}, a);
                                        case 13:
                                        case"end":
                                            return e.stop()
                                    }
                                }, e, this)
                            }))
                        }, updateBetButtonState: function () {
                            var t = e.state, n = k(t, "dragonGameItem"), r = k(t, "betButtonItem"), o = [];
                            try {
                                void 0 != n && (n.map(function (t) {
                                    var e = t.dragonGameBetCount.find(function (t) {
                                            return 0 === t.order
                                        }).key,
                                        n = t.dragonGameOdds.aOddsKey == e ? t.dragonGameOdds.aOdds : t.dragonGameOdds.bOdds,
                                        a = t.dragonGameOdds.aOddsKey == e ? t.dragonGameOdds.aOddsText : t.dragonGameOdds.bOddsText,
                                        i = r.find(function (n) {
                                            return n.redButton.key === e && n.redButton.lottery === t.lottery
                                        }), u = i && i.redButton.isSelected, c = t.dragonGameBetCount.find(function (t) {
                                            return 1 === t.order
                                        }).key,
                                        l = t.dragonGameOdds.aOddsKey == c ? t.dragonGameOdds.aOdds : t.dragonGameOdds.bOdds,
                                        s = t.dragonGameOdds.aOddsKey == c ? t.dragonGameOdds.aOddsText : t.dragonGameOdds.bOddsText,
                                        d = r.find(function (e) {
                                            return e.blueButton.key === c && e.blueButton.lottery === t.lottery
                                        }), f = d && d.blueButton.isSelected;
                                    o.push({
                                        redButton: {
                                            id: t.lottery + e,
                                            lottery: t.lottery,
                                            key: e,
                                            odds: n,
                                            text: a,
                                            isSelected: u
                                        },
                                        blueButton: {
                                            id: t.lottery + c,
                                            lottery: t.lottery,
                                            key: c,
                                            odds: l,
                                            text: s,
                                            isSelected: f
                                        }
                                    })
                                }), e.setState({betButtonItem: o}, function () {
                                    return console.log("betButtonItem", e.state.betButtonItem)
                                }))
                            } catch (a) {
                            }
                        }, setBetButtonState: function () {
                            var t = k(e.state, "dragonGameItem"), n = [];
                            try {
                                void 0 != t && (t.map(function (t) {
                                    var e = t.dragonGameBetCount.find(function (t) {
                                            return 0 === t.order
                                        }).key,
                                        r = t.dragonGameOdds.aOddsKey == e ? t.dragonGameOdds.aOdds : t.dragonGameOdds.bOdds,
                                        o = t.dragonGameOdds.aOddsKey == e ? t.dragonGameOdds.aOddsText : t.dragonGameOdds.bOddsText,
                                        a = t.dragonGameBetCount.find(function (t) {
                                            return 1 === t.order
                                        }).key,
                                        i = t.dragonGameOdds.aOddsKey == a ? t.dragonGameOdds.aOdds : t.dragonGameOdds.bOdds,
                                        u = t.dragonGameOdds.aOddsKey == a ? t.dragonGameOdds.aOddsText : t.dragonGameOdds.bOddsText;
                                    n.push({
                                        redButton: {
                                            id: t.lottery + e,
                                            lottery: t.lottery,
                                            key: e,
                                            odds: r,
                                            text: o,
                                            isSelected: !1
                                        },
                                        blueButton: {
                                            id: t.lottery + a,
                                            lottery: t.lottery,
                                            key: a,
                                            odds: i,
                                            text: u,
                                            isSelected: !1
                                        }
                                    })
                                }), e.setState({betButtonItem: n}, function () {
                                    return console.log("betButtonItem", e.state.betButtonItem)
                                }))
                            } catch (r) {
                            }
                        }, onPlaceBet: function (t, n) {
                            var r = e.state.betQueryItem;
                            if (1 == n.isSelected) t.forEach(function (t) {
                                r = r.setIn([r.size], t)
                            }), e.setState({betQueryItem: r}); else {
                                var o = n.id;
                                r = r.filter(function (t) {
                                    return t.lottery + [t.game, t.contents].join("_") !== o
                                }).toList(), e.setState({betQueryItem: r})
                            }
                        }, onCanceBet: function () {
                            var t = e.actions, n = k(t, "setBetButtonState"),
                                r = (k(t, "setTotalBetAmount"), k(t, "setInputBetAmount"));
                            n(), e.setState({betQueryItem: Object(i.List)([])}, function () {
                                r(0)
                            })
                        }, setInputBetAmount: function (t) {
                            e.setState({inputBetAmount: t}, function () {
                                return console.log("inputBetAmount", e.state.inputBetAmount)
                            })
                        }, setBetAmount: function (t) {
                            var n = e.state.betQueryItem, r = n.find(function (e) {
                                return e.lottery === t.lottery && e.game === t.game && e.contents === t.contents
                            }), o = n.indexOf(r), a = Object.assign({}, r, {amount: t.amount});
                            n = n.setIn([o], a), e.setState({betQueryItem: n}, e.actions.setTotalBetAmount)
                        }, setAllBetAmount: function (t) {
                            var n = e.state.betQueryItem;
                            t.forEach(function (t) {
                                var r = n.find(function (e) {
                                    return e.lottery === t.lottery && e.game === t.game && e.contents === t.contents
                                }), o = n.indexOf(r), a = Object.assign({}, r, {amount: t.amount});
                                n = n.setIn([o], a), e.setState({betQueryItem: n}, e.actions.setTotalBetAmount)
                            })
                        }, setTotalBetAmount: function () {
                            var t = k(e.state, "betQueryItem"), n = 0;
                            t.forEach(function (t) {
                                n += Number(t.amount)
                            }), e.setState({totalBetAmount: n})
                        }, setDragonBetResult: function () {
                            e.setState({showDragonBetResult: !e.state.showDragonBetResult})
                        }
                    }, e.state = Object.assign(Object.assign({}, S), e.actions), e
                }

                return e = u, (n = [{
                    key: "componentDidMount", value: function () {
                        var t = this, e = this.actions, n = k(e, "fetchDragonGameItems"), r = k(e, "setBetButtonState"),
                            o = k(e, "getUpdate");
                        n(this.state.dragonCount).then(function () {
                            return r()
                        }), O = setInterval(function () {
                            return o(t.state.dragonGameItem)
                        }, 1e4)
                    }
                }, {
                    key: "componentWillUnmount", value: function () {
                        clearInterval(O), this.setState = function () {
                        }
                    }
                }, {
                    key: "componentDidUpdate", value: function () {
                    }
                }, {
                    key: "render", value: function () {
                        return o.a.createElement(C.Provider, Object.assign({value: this.state}, this.props))
                    }
                }]) && y(e.prototype, n), r && y(e, r), u
            }(), j = Object(a.b)(function (t) {
                return {lottery: k(t, "App").get("lottery")}
            })(R), N = C, P = n(5), A = n(683), _ = n(7).immutable,
            G = Object(P.a)(A.a).withConfig({componentId: "b0uhs3-0"})(["height:", "px;transition:all 0.3s;overflow:hidden;"], function (t) {
                return _(t, "isLoading") ? 72 : 0
            }), T = (n(81), n(112), n(799)), z = (n(7).immutable, function (t) {
                var e = t.width || 13, n = t.height || 16, r = t.className;
                return o.a.createElement("svg", Object.assign({
                    className: r,
                    width: e,
                    height: n
                }, t), o.a.createElement("g", {"data-name": "Group 34633"}, o.a.createElement("path", {
                    "data-name": "Path 83039",
                    d: "M13 6.5c0 3.59-6.5 9.5-6.5 9.5S0 10.09 0 6.5A6.5 6.5 0 016.5 0 6.5 6.5 0 0113 6.5z",
                    fill: "#5f5f5f"
                }), o.a.createElement("text", {
                    transform: "translate(2 9)",
                    fill: "#fff",
                    fontSize: 7,
                    fontFamily: "ArialMT, Arial"
                }, o.a.createElement("tspan", {x: 0, y: 0}, "PK"))))
            }), D = (n(7).immutable, function (t) {
                var e = t.width || 8.893, n = t.height || 8.5, r = t.color || "#ccc", a = t.className;
                return o.a.createElement("svg", Object.assign({
                    className: a,
                    width: e,
                    height: n
                }, t), o.a.createElement("g", {
                    "data-name": "Group 34108",
                    fill: "none",
                    stroke: r,
                    strokeMiterlimit: 10
                }, o.a.createElement("g", {
                    "data-name": "Ellipse 4638",
                    transform: "translate(.707 .977)"
                }, o.a.createElement("ellipse", {
                    cx: 3.739,
                    cy: 3.761,
                    rx: 3.739,
                    ry: 3.761,
                    stroke: "none"
                }), o.a.createElement("ellipse", {
                    cx: 3.739,
                    cy: 3.761,
                    rx: 3.239,
                    ry: 3.261
                })), o.a.createElement("path", {
                    "data-name": "Line 1276",
                    strokeLinecap: "round",
                    d: "M4.505 4.704l1.074-1.129"
                }), o.a.createElement("path", {
                    "data-name": "Line 1277",
                    strokeLinecap: "round",
                    d: "M4.446.977V.5"
                }), o.a.createElement("path", {
                    "data-name": "Line 1278",
                    strokeLinecap: "round",
                    d: "M.707 1.833L1.811.729"
                }), o.a.createElement("path", {
                    "data-name": "Line 1279",
                    strokeLinecap: "round",
                    d: "M8.186 1.833L7.082.729"
                })))
            }), L = (n(228), n(684)), M = (n(7).immutable, function (t, e) {
                var n = "--", r = "--", o = "--";
                return L.forEach(function (a) {
                    Object.values(a).forEach(function (a) {
                        for (var i = 0; i < a.games.length; i++) a.games[i].key === t && (n = a.games[i].name, a.oddsKey.forEach(function (t) {
                            "Dragon" == t.key && t.balls.forEach(function (t) {
                                t.value.forEach(function (n) {
                                    n.key === e && (o = n.name, r = t.name)
                                })
                            })
                        }))
                    })
                }), {lotteryText: n, gameModeText: r, gameBetText: o}
            }), F = n(7).immutable, Q = n(905), U = n(906), q = function (t) {
                return t.closeTime - t.currentTime
            }, K = function (t) {
                var e = t.find(function (t) {
                    return 0 === t.order
                }).bets, n = t.find(function (t) {
                    return 1 === t.order
                }).bets;
                if (e != n) {
                    var r = e + n;
                    return {ab: 100 * (e / r) + "%", bb: 100 * (n / r) + "%"}
                }
                return {ab: "50%", bb: "50%"}
            }, W = function (t) {
                return {
                    redkey: t.find(function (t) {
                        return 0 === t.order
                    }).key, bluekey: t.find(function (t) {
                        return 1 === t.order
                    }).key
                }
            }, H = function (t, e, n) {
                var r = void 0, o = void 0, a = t.find(function (t) {
                    return t.redButton.key === W(e.dragonGameBetCount).redkey && t.redButton.lottery === n.lottery
                }), i = t.find(function (t) {
                    return t.blueButton.key === W(e.dragonGameBetCount).bluekey && t.blueButton.lottery === n.lottery
                });
                return void 0 !== a && void 0 !== i ? (r = a.redButton.isSelected, o = i.blueButton.isSelected) : (r = !1, o = !1), {
                    redIS: r,
                    blueIS: o
                }
            }, J = Object(a.b)(function (t) {
                var e = F(t, "Bets");
                return {enablePresetAmount: e.get("enablePresetAmount"), presetAmount: e.get("presetAmount")}
            })(function (t) {
                var e = o.a.useContext(N), n = F(e, "dragonGameItem"), r = F(e, "onTimerFinish"), a = F(e, "betButtonItem"),
                    i = F(e, "onClickButton"), u = F(e, "inputBetAmount"), c = F(e, "oddsItem"), l = F(e, "betCountItem"),
                    s = F(e, "periodItem"), d = F(e, "onPlaceBet"), f = (F(e, "betQueryItem"), F(e, "setBetAmount")),
                    m = F(t, "title"), p = F(t, "drawNumber"), g = F(t, "game"), b = F(t, "enablePresetAmount"),
                    h = F(t, "presetAmount");
                if (void 0 === n || void 0 === a || void 0 === c || void 0 === l || void 0 === s) return o.a.createElement(Y, null, o.a.createElement($, null, o.a.createElement(G, {
                    isLoading: !0,
                    size: "small"
                })));
                var y = n.find(function (t) {
                    return t.lottery === m && t.game === g && t.drawNumber === p
                }), v = s.find(function (t) {
                    return t.lottery == y.lottery || t.drawNumber == y.drawNumber
                }), w = l.find(function (t) {
                    return t.lottery == y.lottery && t.drawNumber == y.drawNumber && t.game == y.game
                });
                if (void 0 === y || void 0 === v || void 0 === w) return null;
                if (1 != v.status) return null;
                var x = function (t, e, n) {
                    var r = void 0;
                    return t.forEach(function (t) {
                        if (null === t) return null;
                        t.lottery !== n.lottery || Object.keys(t)[0] != W(e.dragonGameBetCount).redkey && Object.keys(t)[0] != W(e.dragonGameBetCount).bluekey || (r = t)
                    }), r
                }(c, w, y);
                if (void 0 === x) return null;
                var E = W(w.dragonGameBetCount), O = Object.keys(x).find(function (t) {
                    return t === E.redkey
                }), k = M(y.lottery, O).gameBetText, B = a.find(function (t) {
                    return t.redButton.key === O && t.redButton.lottery === y.lottery
                }).redButton, I = Object.keys(x).find(function (t) {
                    return t === E.bluekey
                }), S = M(y.lottery, I).gameBetText, C = a.find(function (t) {
                    return t.blueButton.key === I && t.redButton.lottery === y.lottery
                }).blueButton;
                if (void 0 === B && void 0 === C) return null;
                var R, j = function (t, e) {
                    var n = h, r = {
                        lottery: y.lottery,
                        drawNumber: String(y.drawNumber),
                        game: y.game,
                        contents: t.key.split("_")[1],
                        odds: e,
                        amount: b ? n : u,
                        ignore: !1
                    };
                    f(r), i(t), d([r], t)
                }, P = M(y.lottery, [g, y.contents].join("_"));
                return o.a.createElement(Y, null, o.a.createElement(V, null, o.a.createElement("div", {className: "title"}, P.lotteryText), o.a.createElement("div", {className: "tag-text"}, "\u201c", P.gameBetText, "\u201d \u8fde\u5f00 ", y.rank, " \u671f")), o.a.createElement(X, null, (R = y.contents, W(w.dragonGameBetCount).redkey.split("_")[1] === R ? o.a.createElement(lt, {src: Q}) : o.a.createElement(lt, {src: U}))), o.a.createElement($, null, o.a.createElement(Z, null, o.a.createElement("div", null, o.a.createElement(et, null, "\u671f\u6570\uff1a", p, "\u671f"), o.a.createElement(et, null, "\u73a9\u6cd5\uff1a", P.gameModeText)), o.a.createElement(tt, null, o.a.createElement(D, null), o.a.createElement(nt, null, o.a.createElement(T.a, {
                    period: q(v),
                    onFinish: function () {
                        return r(y.lottery)
                    }
                })))), o.a.createElement(rt, null, o.a.createElement(ot, {percentage: K(w.dragonGameBetCount).bb}, o.a.createElement(z, {className: "0%" != String(K(w.dragonGameBetCount).bb) ? "pk-icon" : "red100"}), o.a.createElement(at, {percentage: K(w.dragonGameBetCount).ab}))), o.a.createElement(it, null, o.a.createElement(ut, null, o.a.createElement(et, {className: "red"}, k, " ", x[O] >= 1 ? x[O] : "-"), x[O] >= 1 ? o.a.createElement(ct, {
                    onClick: function () {
                        return j(B, x[O])
                    }, className: H(a, w, y).redIS ? "isSelected" : ""
                }) : o.a.createElement(ct, null)), o.a.createElement(ut, null, o.a.createElement(et, {className: "blue"}, S, " ", x[I] >= 1 ? x[I] : "-"), x[I] >= 1 ? o.a.createElement(ct, {
                    onClick: function () {
                        return j(C, x[I])
                    }, className: H(a, w, y).blueIS ? "isSelected" : ""
                }) : o.a.createElement(ct, null)))))
            }),
            Y = P.a.div.withConfig({componentId: "sc-15w8fo-0"})(["width:85%;height:135px;margin-top:8px;margin-bottom:8px;border:1px solid lightgrey;"]),
            X = P.a.div.withConfig({componentId: "sc-15w8fo-1"})(["height:27px;display:flex;align-items:center;justify-content:flex-end;background-color:#3E3E3E;"]),
            V = P.a.div.withConfig({componentId: "sc-15w8fo-2"})(["color:white;position:relative;display:flex;align-items:center;justify-content:space-between;margin-bottom:-22px;>.title{margin-left:10px;font-size:14px;font-weight:bold;}>.tag-text{font-size:10px;margin-right:10px;}"]),
            $ = P.a.div.withConfig({componentId: "sc-15w8fo-3"})(["width:100%;height:110px;background-color:white;display:flex;flex-direction:column;align-items:center;"]),
            Z = P.a.div.withConfig({componentId: "sc-15w8fo-4"})(["width:95%;padding-top:5px;display:flex;align-items:center;justify-content:space-between;"]),
            tt = P.a.div.withConfig({componentId: "sc-15w8fo-5"})(["display:flex;flex-direction:row;align-items:center;"]),
            et = P.a.div.withConfig({componentId: "sc-15w8fo-6"})(["color:grey;font-size:12px;&.red{color:#d51000}&.blue{color:#006cd8}"]),
            nt = P.a.div.withConfig({componentId: "sc-15w8fo-7"})(["color:lightgrey;font-size:9px;padding-left:3px;&.red{color:#d51000;padding-right:3px;margin-bottom:-3px;}&.blue{color:#006cd8;padding-right:3px;margin-bottom:-3px;}"]),
            rt = P.a.div.withConfig({componentId: "sc-15w8fo-8"})(["width:95%;margin-top:5px;margin-bottom:8px;display:flex;flex-direction:row;align-items:flex-end;"]),
            ot = P.a.div.withConfig({componentId: "sc-15w8fo-9"})(["width:100%;display:flex;flex-direction:column;align-items:flex-end;>.pk-icon{width:", ";}>.red100{width:", ";margin-right:-6px;}"], function (t) {
                return "calc(".concat(t.percentage, " + 6px)")
            }, function (t) {
                return "calc(".concat(t.percentage, " + 13px)")
            }),
            at = P.a.div.withConfig({componentId: "sc-15w8fo-10"})(["width:100%;height:2px;background:linear-gradient(to right,#d51000,", ",#006cd8 0%);"], function (t) {
                return "calc(".concat(t.percentage, ")")
            }),
            it = P.a.div.withConfig({componentId: "sc-15w8fo-11"})(["width:95%;margin:2px;display:flex;flex-direction:row;justify-content:space-between;"]),
            ut = P.a.div.withConfig({componentId: "sc-15w8fo-12"})(["width:47%;height:30px;display:flex;position:relative;flex-direction:column;align-items:center;justify-content:center;border:1px solid lightgrey;"]),
            ct = P.a.div.withConfig({componentId: "sc-15w8fo-13"})(["width:100%;height:inherit;display:flex;position:absolute;align-items:flex-end;justify-content:flex-end;&.isSelected{border:2px solid #35a8e0;::before{content:'';display:inline-block;width:6px;height:3px;border-top:1.5px solid #FFF;border-right:1.5px solid #FFF;transform:rotate(125deg);margin-right:-12px;margin-bottom:3px;}::after{content:'';border-bottom:12px solid #35a8e0;border-left:12px solid transparent;right:1px;bottom:1px;}}"]),
            lt = P.a.img.withConfig({componentId: "sc-15w8fo-14"})(["width:124px;height:27px;"]),
            st = (n(102), n(172), n(7).immutable), dt = function (t) {
                var e = st(t, "value"), n = st(t, "options"), r = st(t, "onChange"), a = o.a.useCallback(function (t) {
                    var e = t.target.value, o = n.find(function (t) {
                        return ["".concat(t.value), t.label].includes(e)
                    });
                    o && r(o)
                }, [r, n, e]);
                return o.a.createElement(ft, null, o.a.createElement(mt, null, o.a.createElement("select", {
                    onChange: a,
                    value: e
                }, n.map(function (t) {
                    return o.a.createElement("option", {key: "".concat(t.value), value: t.value}, t.label)
                }))))
            },
            ft = P.a.div.withConfig({componentId: "sc-2n9q9z-0"})(["display:flex;width:40px;height:25px;align-items:center;"]),
            mt = P.a.div.withConfig({componentId: "sc-2n9q9z-1"})(["display:flex;align-items:center;justify-content:space-between;width:100%;padding-right:8px;height:25px;border-radius:5px;background-color:white;&::after{width:0;height:0;content:'';display:block;border-top:5px solid #afafaf;border-bottom:none;border-left:3px solid transparent;border-right:3px solid transparent;}> select{width:100%;font-size:11px;font-weight:bold;color:grey;left:5px;border:0;outline:none;background-color:transparent;position:relative;-webkit-appearance:none;}"]),
            pt = (n(7).immutable, function (t) {
                var e = t.width || 118.535, n = t.height || 128.743, r = t.className;
                return o.a.createElement("svg", Object.assign({
                    className: r,
                    width: e,
                    height: n
                }, t), o.a.createElement("defs", null, o.a.createElement("style", null, ".prefix__a{fill:#e3e3e3}")), o.a.createElement("path", {
                    className: "prefix__a",
                    d: "M112.747 44.709l-12.69-5.91a10 10 0 00-13.29 4.83l-5.91 12.72a10 10 0 004.83 13.29l12.69 5.92a10 10 0 0013.29-4.84l5.92-12.69a10 10 0 00-4.84-13.32zm-6 15.32l-3.48 1.12a2.18 2.18 0 00-1.32 1.2l-1.26 3.66c-.18.52-.57.56-.87.1l-2-3.07a2 2 0 00-1.55-.78h-3.65c-.55 0-.72-.35-.39-.78l2.36-3.07a2.25 2.25 0 00.33-1.75l-1-3.59c-.15-.52.15-.81.67-.62l3.38 1.2a2.09 2.09 0 001.75-.26l3.06-2.27c.44-.33.78-.15.75.4l-.21 3.83a2.1 2.1 0 00.75 1.6l2.87 2.16c.44.35.33.76-.16.92zM44.647 53.489a10 10 0 00-13.66-3.66l-26 15a10 10 0 00-3.64 13.66l15 26a10 10 0 0013.66 3.66l26-15a10 10 0 003.66-13.66zm-6.38 27.14l-3.64.29a2 2 0 00-1.46 1l-1.68 3.23c-.26.49-.65.48-.88 0l-1.59-3.53a2.23 2.23 0 00-1.39-1.12l-3.64-.78c-.54-.12-.64-.52-.24-.89l2.65-2.48a2.1 2.1 0 00.6-1.66l-.56-3.78c-.08-.54.24-.75.71-.47l3.26 2a2.09 2.09 0 001.76.09l3.26-1.51c.5-.23.82 0 .72.57l-.69 3.66a2.2 2.2 0 00.49 1.72l2.63 2.83c.37.41.23.78-.31.83zM105.807 93.819a10 10 0 00-11.54-8.11l-19.7 3.48a10 10 0 00-8.11 11.59l3.48 19.7a10 10 0 0011.59 8.11l19.7-3.48a10 10 0 008.04-11.59zm-11.2 9l-2 3.18a2.26 2.26 0 00-.15 1.78l1.48 3.57c.21.51-.06.8-.58.65l-3.51-1a2 2 0 00-1.7.38l-2.73 2.42c-.42.37-.78.22-.81-.33l-.23-3.86a2.23 2.23 0 00-.9-1.54l-3.12-2c-.46-.3-.42-.71.09-.91l3.35-1.3a2.13 2.13 0 001.15-1.34l.82-3.73c.12-.54.49-.62.83-.19l2.34 3a2.11 2.11 0 001.61.72l3.58-.25c.55-.04.77.28.48.78zM78.357 37.049l5.18-19.32a10 10 0 00-7.07-12.25L57.147.349a10 10 0 00-12.25 7l-5.18 19.34a10 10 0 007.07 12.25l19.32 5.18a10 10 0 0012.25-7.07zm-12.49-11.43l-.46 3.83c-.07.55-.44.68-.83.29l-2.58-2.58a2 2 0 00-1.68-.49l-3.56.81c-.53.12-.78-.18-.54-.68l1.65-3.45a2.23 2.23 0 000-1.79l-1.8-3.32c-.26-.49 0-.83.52-.76l3.56.47a2.12 2.12 0 001.65-.6l2.52-2.88c.36-.41.73-.3.81.24l.6 3.77a2.13 2.13 0 001.07 1.41l3.26 1.46c.5.23.52.65 0 .92l-3.24 1.84a2.21 2.21 0 00-.95 1.51z"
                }))
            }), gt = n(798);

        function bt(t) {
            return (bt = "function" === typeof Symbol && "symbol" === typeof Symbol.iterator ? function (t) {
                return typeof t
            } : function (t) {
                return t && "function" === typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
            })(t)
        }

        function ht(t, e) {
            for (var n = 0; n < e.length; n++) {
                var r = e[n];
                r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
            }
        }

        function yt(t) {
            return function () {
                var e, n = vt(t);
                if (function () {
                    if ("undefined" === typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" === typeof Proxy) return !0;
                    try {
                        return Date.prototype.toString.call(Reflect.construct(Date, [], function () {
                        })), !0
                    } catch (t) {
                        return !1
                    }
                }()) {
                    var r = vt(this).constructor;
                    e = Reflect.construct(n, arguments, r)
                } else e = n.apply(this, arguments);
                return function (t, e) {
                    if (e && ("object" === bt(e) || "function" === typeof e)) return e;
                    return function (t) {
                        if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return t
                    }(t)
                }(this, e)
            }
        }

        function vt(t) {
            return (vt = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) {
                return t.__proto__ || Object.getPrototypeOf(t)
            })(t)
        }

        function wt(t, e) {
            return (wt = Object.setPrototypeOf || function (t, e) {
                return t.__proto__ = e, t
            })(t, e)
        }

        var xt = n(7).immutable, Et = function (t) {
            !function (t, e) {
                if ("function" !== typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
                t.prototype = Object.create(e && e.prototype, {
                    constructor: {
                        value: t,
                        writable: !0,
                        configurable: !0
                    }
                }), e && wt(t, e)
            }(i, o.a.Component);
            var e, n, r, a = yt(i);

            function i(t) {
                var e;
                return function (t, e) {
                    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                }(this, i), (e = a.call(this, t)).ListRef = o.a.createRef(), e.onChangeDropdown = function (t) {
                    xt(e.context, "setDragonCount")(t.value)
                }, e.onGenerateDragonBox = function () {
                    var t = e.context, n = xt(t, "dragonGameItem");
                    xt(t, "periodItem");
                    if (void 0 === n) return o.a.createElement(G, {isLoading: !0, size: "small"});
                    var r = n.map(function (t) {
                        return o.a.createElement(J, {
                            key: [t.lottery, t.game, t.contents, t.drawNumber].join("_"),
                            title: t.lottery,
                            drawNumber: t.drawNumber,
                            game: t.game
                        })
                    });
                    return n.length <= 0 ? o.a.createElement(Ct, null, o.a.createElement(pt, null), o.a.createElement(It, null, "\u5bf9\u4e0d\u8d77\uff0c\u4f60\u73b0\u6682\u65e0\u4efb\u4f55\u957f\u9f99...")) : r
                }, e
            }

            return e = i, (n = [{
                key: "componentDidMount", value: function () {
                }
            }, {
                key: "componentDidUpdate", value: function (t) {
                }
            }, {
                key: "componentWillUnmount", value: function () {
                }
            }, {
                key: "render", value: function () {
                    var t = this.context, e = xt(t, "dragonCount"), n = 0 === xt(t, "betQueryItem").size;
                    return o.a.createElement(kt, {style: n ? null : {height: "calc(100% - 68px)"}}, o.a.createElement(gt.a, null), o.a.createElement(Bt, null, o.a.createElement(It, null, "\u957f\u9f99\u8fde\u5f00\u671f\u6570"), o.a.createElement(dt, {
                        value: e,
                        options: I,
                        onChange: this.onChangeDropdown
                    })), o.a.createElement(St, null, this.onGenerateDragonBox()))
                }
            }]) && ht(e.prototype, n), r && ht(e, r), i
        }();
        Et.contextType = N;
        var Ot = Object(a.b)(function (t) {
                var e = xt(t, "Load"), n = xt(t, "UserInfo");
                return {showInfoPanel: e.get("showInfoPanel"), info: n.get("info")}
            })(Et),
            kt = P.a.div.withConfig({componentId: "qhowzd-0"})(["height:100%;display:flex;overflow:auto;flex-direction:column;background:linear-gradient(to bottom,#ebebeb,30%,white 100%);"]),
            Bt = P.a.div.withConfig({componentId: "qhowzd-1"})(["display:flex;align-items:center;justify-content:center;flex:0 0 auto;"]),
            It = P.a.div.withConfig({componentId: "qhowzd-2"})(["font-size:13px;color:grey;margin:10px;"]),
            St = P.a.div.withConfig({componentId: "qhowzd-3"})(["width:100%;display:flex;align-items:center;flex-direction:column;overflow:auto;"]),
            Ct = P.a.div.withConfig({componentId: "qhowzd-4"})(["width:100%;height:200px;display:flex;align-items:center;justify-content:center;flex:0 0 auto;flex-direction:column;margin-top:50px;"]),
            Rt = (n(229), n(328), n(325), n(49)), jt = n.n(Rt), Nt = (n(331), n(12)), Pt = (n(332), n(60)), At = n(42),
            _t = n(333), Gt = n(334);

        function Tt(t) {
            return (Tt = "function" === typeof Symbol && "symbol" === typeof Symbol.iterator ? function (t) {
                return typeof t
            } : function (t) {
                return t && "function" === typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
            })(t)
        }

        function zt(t, e) {
            for (var n = 0; n < e.length; n++) {
                var r = e[n];
                r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
            }
        }

        function Dt(t) {
            return function () {
                var e, n = Lt(t);
                if (function () {
                    if ("undefined" === typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" === typeof Proxy) return !0;
                    try {
                        return Date.prototype.toString.call(Reflect.construct(Date, [], function () {
                        })), !0
                    } catch (t) {
                        return !1
                    }
                }()) {
                    var r = Lt(this).constructor;
                    e = Reflect.construct(n, arguments, r)
                } else e = n.apply(this, arguments);
                return function (t, e) {
                    if (e && ("object" === Tt(e) || "function" === typeof e)) return e;
                    return function (t) {
                        if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return t
                    }(t)
                }(this, e)
            }
        }

        function Lt(t) {
            return (Lt = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) {
                return t.__proto__ || Object.getPrototypeOf(t)
            })(t)
        }

        function Mt(t, e) {
            return (Mt = Object.setPrototypeOf || function (t, e) {
                return t.__proto__ = e, t
            })(t, e)
        }

        var Ft = n(7).immutable, Qt = function (t) {
            !function (t, e) {
                if ("function" !== typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
                t.prototype = Object.create(e && e.prototype, {
                    constructor: {
                        value: t,
                        writable: !0,
                        configurable: !0
                    }
                }), e && Mt(t, e)
            }(i, o.a.PureComponent);
            var e, n, r, a = Dt(i);

            function i(t) {
                var e;
                return function (t, e) {
                    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                }(this, i), (e = a.call(this, t)).ListRef = o.a.createRef(), e.toggleBet = function () {
                    var t = e.props, n = Ft(t, "lottery"), r = Ft(t, "drawNumber"), o = Ft(t, "game"),
                        a = Ft(t, "contents"), i = Ft(t, "odds"), u = (Ft(t, "amount"), Ft(t, "ignore")), c = e.context,
                        l = Ft(c, "onClickButton"), s = Ft(c, "onPlaceBet"), d = Ft(c, "setBetAmount"),
                        f = {lottery: n, id: n + [o, a].join("_"), key: [o, a].join("_"), odds: i, isSelected: !1},
                        m = {lottery: n, drawNumber: r, game: o, contents: a, odds: i, amount: 0, ignore: u};
                    d(m), l(f), s([m], f)
                }, e.setLocalAmount = function (t) {
                    var n = e.props, r = Ft(n, "lottery"), o = Ft(n, "drawNumber"), a = Ft(n, "game"),
                        i = Ft(n, "contents"), u = Ft(n, "odds"), c = Ft(n, "ignore"),
                        l = Number(t.currentTarget.value);
                    Object(At.validate)({amount: l}, {amount: {numericality: {lessThan: Number.MAX_SAFE_INTEGER}}}) || e.context.setBetAmount({
                        lottery: r,
                        drawNumber: o,
                        game: a,
                        contents: i,
                        odds: u,
                        amount: t.target.value,
                        ignore: c
                    })
                }, e
            }

            return e = i, (n = [{
                key: "render", value: function () {
                    var t = this, e = this.props, n = Ft(e, "lottery"), r = (Ft(e, "drawNumber"), Ft(e, "game")),
                        a = Ft(e, "contents"), i = Ft(e, "odds"), u = Ft(e, "amount"),
                        c = (Ft(e, "ignore"), Ft(e, "editMode")), l = Ft(e, "WrapperStyle"), s = Ft(e, "canDelete") ? [{
                            text: "\u5220\u9664",
                            onPress: this.toggleBet,
                            style: {backgroundColor: "#F4333C", color: "white", width: 80}
                        }] : [], d = M(n, [r, a].join("_"));
                    return o.a.createElement(Pt.a, {
                        editMode: c,
                        style: l
                    }, o.a.createElement(Gt.default, {
                        autoClose: !0,
                        right: s
                    }, o.a.createElement("div", {className: "li_lines"}, o.a.createElement("div", {className: "betting_wrapper"}, o.a.createElement("div", {className: "left-panel"}, o.a.createElement("div", null, o.a.createElement("input", {
                        className: "round-input",
                        type: "tel",
                        min: 0,
                        onChange: function (e) {
                            return t.setLocalAmount(e)
                        },
                        value: 0 === u ? "" : u,
                        placeholder: "\u8f93\u5165\u91d1\u989d"
                    }))), o.a.createElement("div", {className: "right-panel"}, o.a.createElement("div", {className: "top-panel"}, d.lotteryText, " ", d.gameModeText), o.a.createElement("div", {className: "bottom-panel"}, o.a.createElement("div", {className: "game-name"}, o.a.createElement(_t.Textfit, {
                        mode: "multi",
                        max: 14,
                        min: 3
                    }, d.gameBetText)), o.a.createElement("div", {className: "game-odds"}, i)))))))
                }
            }]) && zt(e.prototype, n), r && zt(e, r), i
        }();
        Qt.contextType = N;
        var Ut = Object(a.b)(function (t) {
            var e = Ft(t, "Bets");
            return {enablePresetAmount: e.get("enablePresetAmount"), presetAmount: e.get("presetAmount")}
        })(Qt);
        n(139);

        function qt() {
            var t = function (t, e) {
                e || (e = t.slice(0));
                return Object.freeze(Object.defineProperties(t, {raw: {value: Object.freeze(e)}}))
            }(['\n\t.bet-amount-popup {\n\t\twidth: 70%;\n\t\tbackground-color: #fff;\n\t\ttext-align: center;\n\t\tpadding-bottom: 12px;\n\t\tborder-radius: 4px;\n\t\tborder: 1px solid rgb(204, 204, 204);\n\t\tbox-shadow: 0px 0px 30px rgba(100,100,100,0.8);\n\t\toutline: none;\n\t\tborder: 0;\n    position: absolute;\n    top: 15%;\n    left: 15%;\n\t}\n\t.bet-amount-popup .field-set:not(:last-child){\n\t\twidth: 10rem;\n\t\tmargin: 0.5rem auto;\n\t}\n\t\n\t.bet-amount-popup .field-set:not(:last-child) .field-input input{\n\t\twidth: 100%;\n\t\tmargin: 0;\n\t\tbackground-color: transparent;\n\t\tpadding: 0.5rem 0;\n\t}\n\t\n\t.bet-amount-popup .field-set:not(:last-child) .field-input input::-webkit-input-placeholder { /* Chrome/Opera/Safari */\n\t\tfont-size: 1rem;\n\t\tcolor: #C6C6C6;\n\t}\n\t.bet-amount-popup .field-set:not(:last-child) .field-input input::-moz-placeholder { /* Firefox 19+ */\n\t\tfont-size: 1rem;\n\t\tcolor: #C6C6C6;\n\t}\n\t.bet-amount-popup .field-set:not(:last-child) .field-input input:-ms-input-placeholder { /* IE 10+ */\n\t\tfont-size: 1rem;\n\t\tcolor: #C6C6C6;\n\t}\n\t.bet-amount-popup .field-set:not(:last-child) .field-input input:-moz-placeholder { /* Firefox 18- */\n\t\tfont-size: 1rem;\n\t\tcolor: #C6C6C6;\n\t}\n\t\n\t.field-input {\n\t\tdisplay: table-cell;\n\t\ttext-align: right;\n\t}\n\t\n\t.field-input input{\n\t\ttext-align: center;\n\t\twidth: 6rem;\n\t\tfont-size: 1.25rem;\n\t\toutline: none;\n\t\tborder: none;\n\t\tmargin-right: 0.5rem;\n\t\tbackground-color: rgba(0,0,0,0.05);\n\t}\n\t\n\t.field-set {\n\t\tdisplay: table;\n\t\twidth: 100%;\n\t\tline-height: 2rem;\n\t\tborder: 1px solid rgb(204, 204, 204);\n\t\tborder-radius: 0.5rem\n\t}\n\t\n\t.radio-group-set{\n\t\tdisplay: inline-flex;\n\t\tborder: 0;\n\t}\n\t\n\t.radio-group-set div{\n\t\t-webkit-box-flex: 1;\n\t\t-ms-flex-positive: 1;\n\t\tflex-grow: 1;\n\t\t-ms-flex-preferred-size: 0;\n\t\tflex-basis: 0;\n\t}\n\t\n\t.radio-group-set .radio-group-wrapper{\n\t\tposition: relative;\n\t}\n\t\n\t.radio-group-set .radio-group-wrapper input[type="radio"]{\n\t\tposition: absolute !important;\n\t\tclip: rect(0, 0, 0, 0);\n\t\theight: 1px;\n\t\twidth: 1px;\n\t\tborder: 0;\n\t\toverflow: hidden;\n\t}\n\t\n\t.radio-group-set .radio-group-wrapper input[type="radio"] + label{\n\t\tdisplay: inline-block;\n\t\twidth: 100%;\n\t\tbackground-color: #ccc;\n\t\t-webkit-transition: all 0.2s ease-in-out;\n\t\t-o-transition: all 0.2s ease-in-out;\n\t\ttransition: all 0.2s ease-in-out;\n\t}\n\t\n\t.radio-group-set .radio-group-wrapper:first-child input[type="radio"] + label{\n\t\tborder-radius: .5rem 0 0 .5rem;\n\t}\n\t\n\t.radio-group-set .radio-group-wrapper:last-child input[type="radio"] + label{\n\t\tborder-radius: 0 0.5rem 0.5rem 0;\n\t}\n\t\n\t.radio-group-set .radio-group-wrapper input[type="radio"]:checked + label{\n\t\tcolor: #fff;\n\t\tbackground-color: #2061b3;\n\t}\n\t\n\t.field-set:not(:first-child){\n\t\tmargin-top: 1rem;\n\t}\n\t\n\t.betton_betting {\n\t\tbackground-color: #2061b3;\n\t\tcolor: #ffffff;\n\t\theight: 40px;\n\t\twidth: 100%;\n\t\tborder-radius: 4px;\n\t\ttext-align: center;\n\t\tline-height: 40px;\n\t\tmargin: 0px auto;\n\t\tfont-size: 18px;\n\t\tborder: none;\n\t\toutline: medium;\n\t}\n\t\n\t.betton_betting:disabled{\n\t\tbackground-color:#999999;\n\t}\n\t.betting_set{\n\t\twidth: 100%;\n\t\tmargin: 0 auto;\n\t\tposition: fixed;\n\t}\n\t.rc-slider {\n\t\tmargin: 1rem 1rem 1rem 0.5rem;\n\t\twidth: initial !important;\n\t\tpadding: 1rem 0 2rem 0 !important;\n\t}\n\t\n\t.rc-slider .rc-slider-handle{\n\t\twidth: 2rem;\n\t\theight: 2rem;\n\t\tmargin-top: -0.5rem;\n\t\tmargin-left: -0.65rem;\n\t\tborder: solid 2px #2061b3;\n\t}\n\t\n\t.rc-slider .rc-slider-dot {\n\t\tposition: absolute;\n\t\tbottom: -2px;\n\t\tmargin-left: -4px;\n\t\twidth: 1.2rem;\n\t\theight: 1.2rem;\n\t\tborder: 2px solid #e9e9e9;\n\t\tbackground-color: #fff;\n\t\tcursor: pointer;\n\t\tborder-radius: 50%;\n\t\tvertical-align: middle;\n\t}\n\t\n\t.rc-slider .rc-slider-dot.rc-slider-dot-active{\n\t\tbackground-color: #fff;\n\t\tborder: 2px solid #2061b3;\n\t}\n\t\n\t.rc-slider .rc-slider-step{\n\t\theight: 1rem;\n\t}\n\t\n\t.rc-slider .rc-slider-mark{\n\t\tposition: absolute;\n\t\ttop: 18px;\n\t\tleft: 6px;\n\t\twidth: 100%;\n\t\tfont-size: 0.75rem;\n\t}\n\t\n\t.rc-slider .rc-slider-mark-text{\n\t\ttop: -2.5rem;\n\t\tfont-size: 1rem;\n\t\tfont-weight: bold;\n\t}\n\t\n\t.rc-slider .rc-slider-rail, .rc-slider .rc-slider-track{\n\t\theight: 1rem;\n\t}\n\t\n\t.rc-slider .rc-slider-rail {\n\t\twidth: calc(100% + 0.5rem);\n\t}\n\t\n\t.rc-slider .rc-slider-track{\n\t\tbackground-color: #2061b3;\n\t}\n']);
            return qt = function () {
                return t
            }, t
        }

        n(7).immutable, n(137);
        Object(P.b)(qt());
        var Kt = P.a.div.withConfig({componentId: "ho8s34-6"})(["z-index:999;&.bet-page{border-radius:10px 10px 0 0;transform:", ";background-color:#fff;-webkit-box-shadow:none;box-shadow:none;animation:fadeInUp 300ms cubic-bezier(0.4,0,0.2,1) forwards;&.short-list{bottom:0;width:100%;position:absolute;height:initial;top:initial;}&.long-list{}}@keyframes fadeInUp{from{transform:translateY(100%);opacity:0;}to{transform:translateY(0);opacity:1;}}"], function (t) {
            return t["data-show"] ? "translate3d(0, 0, 0)" : "translate3d(100%, 0, 0)"
        }), Wt = n(101), Ht = n(237), Jt = n(238), Yt = n(143), Xt = n(108), Vt = n(15);

        function $t(t) {
            return ($t = "function" === typeof Symbol && "symbol" === typeof Symbol.iterator ? function (t) {
                return typeof t
            } : function (t) {
                return t && "function" === typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
            })(t)
        }

        function Zt(t, e) {
            for (var n = 0; n < e.length; n++) {
                var r = e[n];
                r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
            }
        }

        function te(t) {
            return function () {
                var e, n = ee(t);
                if (function () {
                    if ("undefined" === typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" === typeof Proxy) return !0;
                    try {
                        return Date.prototype.toString.call(Reflect.construct(Date, [], function () {
                        })), !0
                    } catch (t) {
                        return !1
                    }
                }()) {
                    var r = ee(this).constructor;
                    e = Reflect.construct(n, arguments, r)
                } else e = n.apply(this, arguments);
                return function (t, e) {
                    if (e && ("object" === $t(e) || "function" === typeof e)) return e;
                    return function (t) {
                        if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return t
                    }(t)
                }(this, e)
            }
        }

        function ee(t) {
            return (ee = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) {
                return t.__proto__ || Object.getPrototypeOf(t)
            })(t)
        }

        function ne(t, e) {
            return (ne = Object.setPrototypeOf || function (t, e) {
                return t.__proto__ = e, t
            })(t, e)
        }

        var re, oe = n(7).immutable;
        !function (t) {
            t[t.ODD_CHANGE = 0] = "ODD_CHANGE"
        }(re || (re = {}));
        var ae, ie, ue,
            ce = (ae = {}, ie = re.ODD_CHANGE, ue = "\u8d54\u7387\u53d8\u5316, \u8bf7\u91cd\u65b0\u786e\u8ba4\u6295\u6ce8\u8d54\u7387", ie in ae ? Object.defineProperty(ae, ie, {
                value: ue,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : ae[ie] = ue, ae), le = function (t) {
                t
            }, se = function (t) {
                !function (t, e) {
                    if ("function" !== typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
                    t.prototype = Object.create(e && e.prototype, {
                        constructor: {
                            value: t,
                            writable: !0,
                            configurable: !0
                        }
                    }), e && ne(t, e)
                }(i, o.a.PureComponent);
                var e, n, r, a = te(i);

                function i(t) {
                    var e;
                    return function (t, e) {
                        if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                    }(this, i), (e = a.call(this, t)).ListRef = o.a.createRef(), e.rowRenderer = function () {
                        var t = oe(e.props, "page"), n = oe(e.state, "editMode"), r = oe(e.context, "betQueryItem"),
                            a = "kj" !== t;
                        return function (t) {
                            var e = oe(t, "key"), i = oe(t, "index"), u = oe(t, "style");
                            return o.a.createElement(Ut, Object.assign({
                                key: e,
                                canDelete: a,
                                editMode: n,
                                WrapperStyle: u
                            }, r.get(i)))
                        }
                    }, e.hideBetPage = function () {
                        Object(p.a)({type: Nt.a}), Object(p.a)(Vt.showBetPage(!1))
                    }, e.toggleEditMode = function (t) {
                        t.preventDefault(), e.setState({editMode: !e.state.editMode})
                    }, e.toggleBetList = function (t) {
                        e.setState({isShowList: t})
                    }, e.state = {isShowList: !1, editMode: !1}, le(e.toggleBetList), e
                }

                return e = i, r = [{
                    key: "getDerivedStateFromProps", value: function (t, e) {
                        var n = oe(t, "isOddsChange"), r = oe(e, "isShowList");
                        return n && !r ? {isShowList: !0} : null
                    }
                }], (n = [{
                    key: "componentWillUnmount", value: function () {
                        le(void 0)
                    }
                }, {
                    key: "render", value: function () {
                        var t = this, e = this.props, n = (oe(e, "page"), oe(e, "lottery"), oe(e, "isOddsChange")),
                            r = this.state.editMode, a = oe(this.context, "betQueryItem");
                        return o.a.createElement(Pt.c, null, o.a.createElement("div", {className: "bet-list-content " + (this.state.isShowList ? "show" : "")}, o.a.createElement(Yt.a, {
                            menu: !1,
                            right: !0,
                            rightButtonTitle: r ? "\u5b8c\u6210" : "\u7f16\u8f91",
                            onRightButtonClick: this.toggleEditMode,
                            title: "\u6295\u6ce8\u6e05\u5355",
                            showToggleFullscreen: !1,
                            onCloseBet: function () {
                                return t.setState({isShowList: !1})
                            }
                        }), n && o.a.createElement(fe, null, ce[re.ODD_CHANGE]), o.a.createElement(Pt.b, null, 0 !== a.size && o.a.createElement(Xt.a, null, function (e) {
                            var n = oe(e, "height"), r = oe(e, "width");
                            return o.a.createElement(Xt.c, {
                                width: r,
                                height: n,
                                rowHeight: 82,
                                rowCount: a.size,
                                rowRenderer: t.rowRenderer()
                            })
                        }))), o.a.createElement("a", {
                            className: "bets-showList-btn", onClick: function () {
                                return t.setState({isShowList: !t.state.isShowList})
                            }
                        }, "\u5df2\u9009", a.size, "\u6ce8"))
                    }
                }]) && Zt(e.prototype, n), r && Zt(e, r), i
            }();
        se.contextType = N;
        var de = Object(a.b)(function (t) {
                var e = oe(t, "App"), n = oe(t, "Bets"), r = oe(t, "Load"), o = e.get("lottery"), a = e.get("page"),
                    i = r.get("odds"), u = n.get("fixOdds"), c = r.getIn(["periods", "status"]);
                return {
                    lottery: o,
                    page: a,
                    betsArray: n.get("betsArray"),
                    isOddsChange: u.size > 0 && 1 === c && i.size > 0
                }
            })(se),
            fe = P.a.div.withConfig({componentId: "b1qoiv-0"})(["padding:8px;text-align:center;color:#ff0000;font-size:0.75rem;"]),
            me = n(685);

        function pe(t) {
            return (pe = "function" === typeof Symbol && "symbol" === typeof Symbol.iterator ? function (t) {
                return typeof t
            } : function (t) {
                return t && "function" === typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
            })(t)
        }

        function ge(t, e) {
            for (var n = 0; n < e.length; n++) {
                var r = e[n];
                r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
            }
        }

        function be(t) {
            return function () {
                var e, n = he(t);
                if (function () {
                    if ("undefined" === typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" === typeof Proxy) return !0;
                    try {
                        return Date.prototype.toString.call(Reflect.construct(Date, [], function () {
                        })), !0
                    } catch (t) {
                        return !1
                    }
                }()) {
                    var r = he(this).constructor;
                    e = Reflect.construct(n, arguments, r)
                } else e = n.apply(this, arguments);
                return function (t, e) {
                    if (e && ("object" === pe(e) || "function" === typeof e)) return e;
                    return function (t) {
                        if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return t
                    }(t)
                }(this, e)
            }
        }

        function he(t) {
            return (he = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) {
                return t.__proto__ || Object.getPrototypeOf(t)
            })(t)
        }

        function ye(t, e) {
            return (ye = Object.setPrototypeOf || function (t, e) {
                return t.__proto__ = e, t
            })(t, e)
        }

        var ve = n(7).immutable, we = function (t) {
            !function (t, e) {
                if ("function" !== typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
                t.prototype = Object.create(e && e.prototype, {
                    constructor: {
                        value: t,
                        writable: !0,
                        configurable: !0
                    }
                }), e && ye(t, e)
            }(i, o.a.PureComponent);
            var e, n, r, a = be(i);

            function i(t) {
                var e;
                return function (t, e) {
                    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                }(this, i), (e = a.call(this, t)).ListRef = o.a.createRef(), e.rowRenderer = function () {
                    var t = ve(e.context, "betQueryItem"), n = ve(e.state, "editMode");
                    return function (e) {
                        var r = ve(e, "key"), a = ve(e, "index"), i = ve(e, "style");
                        return o.a.createElement(Ut, Object.assign({key: r}, t.find(function (e) {
                            return t.indexOf(e) == a
                        }), {canDelete: !0, editMode: n, WrapperStyle: i}))
                    }
                }, e.toggleEditMode = function (t) {
                    t.preventDefault(), e.setState({editMode: !e.state.editMode})
                }, e.placeBet = function () {
                    var t = e.context, n = ve(t, "betQueryItem"), r = ve(t, "fetchDragonBetResult"),
                        o = ve(t, "setDragonBetResult");
                    e.setState({buttonLocked: !0});
                    var a = n.map(function (t) {
                        return {
                            lottery: ve(t, "lottery"),
                            drawNumber: ve(t, "drawNumber"),
                            game: ve(t, "game"),
                            contents: ve(t, "contents"),
                            odds: ve(t, "odds"),
                            amount: ve(t, "amount"),
                            ignore: ve(t, "ignore")
                        }
                    });
                    if (a.some(function (t) {
                        return Number(t.amount) < 1 || "NaN" === Number(t.amount).toString()
                    })) return Object(Wt.a)({
                        icon: "warning",
                        text: "\u8bf7\u8f93\u5165\u6295\u6ce8\u91d1\u989d"
                    }), void e.setState({buttonLocked: !1});
                    a.toJS(), r({bets: a.toJS()}), e.cancelBetsPage(), o()
                }, e.openPersist = function () {
                    return e.setState({persistOpen: !0})
                }, e.closePersist = function () {
                    return e.setState({persistOpen: !1})
                }, e.handleInput = function (t) {
                    var n = e.context, r = ve(n, "setAllBetAmount"), o = ve(n, "setInputBetAmount"), a = t;
                    if ("NaN" !== Number(a).toString() && !a.toString().match(/\./)) {
                        e.setState({input: a});
                        var i = ve(e.context, "betQueryItem"), u = [];
                        i.map(function (t) {
                            var e = ve(t, "lottery"), n = ve(t, "drawNumber"), r = ve(t, "game"), o = ve(t, "contents"),
                                i = ve(t, "odds"), c = ve(t, "ignore");
                            Object(At.validate)({value: a}, {amount: {numericality: {lessThan: Number.MAX_SAFE_INTEGER}}}) || u.push({
                                lottery: e,
                                drawNumber: n,
                                game: r,
                                contents: o,
                                odds: i,
                                amount: a,
                                ignore: c
                            })
                        }), Object(p.a)(Nt.B(a)), o(t), r(u)
                    }
                }, e.cancelBetsPage = function () {
                    var t = ve(e.props, "enablePresetAmount"), n = ve(e.context, "onCanceBet");
                    t || e.setState({input: null}), n()
                }, e.state = {
                    editMode: !1,
                    persistOpen: !1,
                    buttonLocked: !1,
                    input: t.enablePresetAmount ? t.presetAmount : 0,
                    drawNumber: void 0
                }, e
            }

            return e = i, (n = [{
                key: "componentWillUnmount", value: function () {
                    this.setState = function () {
                    }
                }
            }, {
                key: "render", value: function () {
                    var t = this, e = this.props, n = (ve(e, "odds"), ve(e, "minStake")), r = ve(e, "overlay"),
                        a = ve(e, "enablePresetAmount"), i = this.context, u = ve(i, "betQueryItem"),
                        c = ve(i, "totalBetAmount"),
                        l = n > 0 ? "\u6700\u4f4e\u8f93\u5165".concat(n, "\u5143") : "\u8f93\u5165\u91d1\u989d";
                    return u.size ? jt.a.createPortal(o.a.createElement(o.a.Fragment, null, r && o.a.createElement(me.a, {show: !0}), o.a.createElement(Kt, {
                        className: "bet-page short-list",
                        "data-show": !0
                    }, o.a.createElement(de, null), o.a.createElement(Pt.d, null, o.a.createElement("div", {className: "payment-footer"}, o.a.createElement(Jt.a, {
                        onSetBetNumber: function (e) {
                            return t.handleInput(e)
                        }
                    }), o.a.createElement("hr", {className: "sperate-line"}), o.a.createElement("div", {className: "bets"}, o.a.createElement("input", {
                        className: "bets-input-value",
                        placeholder: l,
                        min: 0,
                        type: "number",
                        pattern: "\\d*",
                        onChange: function (e) {
                            return t.handleInput(Number(e.target.value))
                        },
                        step: 1,
                        value: 0 === Number(this.state.input) ? "" : this.state.input
                    }), o.a.createElement(Ht.a, {
                        onChange: function (t) {
                            return Object(p.a)(Nt.D(t))
                        }, checked: a
                    }), o.a.createElement("a", {
                        className: "cancel-btn", onClick: function () {
                            return t.cancelBetsPage()
                        }
                    }, "\u53d6\u6d88"), o.a.createElement("button", {
                        className: "result-btn", onClick: function () {
                            return t.placeBet()
                        }
                    }, "\u786e\u8ba4 ", c)))))), document.getElementById("root")) : null
                }
            }]) && ge(e.prototype, n), r && ge(e, r), i
        }();
        we.contextType = N;
        var xe = Object(a.b)(function (t) {
                var e = ve(t, "App"), n = (ve(t, "UserInfo"), ve(t, "Persist")), r = ve(t, "Bets"), o = ve(t, "Load"),
                    a = e.get("lottery"), i = e.get("page"), u = n.get("publicConfigMessage")["user.minStake"],
                    c = r.get("enablePresetAmount"), l = r.get("presetAmount"), s = o.get("odds"),
                    d = o.getIn(["periods", "drawNumber"]);
                return {
                    lottery: a,
                    page: i,
                    minStake: "NaN" === Number(u).toString() ? 0 : Number(u),
                    odds: s,
                    enablePresetAmount: c,
                    presetAmount: l,
                    drawNumber: d
                }
            })(we), Ee = (n(324), n(171)),
            Oe = (n(7).immutable, P.a.div.withConfig({componentId: "sc-1nobhsy-0"})(["border-radius:10px;position:fixed;width:90%;height:auto !important;top:50%;left:0;right:0;margin:auto;transform:translateY(-50%);animation:fadeIn 0.4s linear forwards;z-index:99;background-color:#fff;overflow:hidden;display:block;.table-wrapper{height:calc(100% - 45px - 65px);width:90%;margin:auto;.table{width:100%;font-size:0.75rem;color:#5f5f5f;span{padding:4px 2px;text-align:center;flex-grow:1;&:first-child{text-align:left;width:50%;}&:last-child{text-align:right;width:20%;}}.head{border-bottom:1px solid #b2b2b2;display:flex;}.body{overflow:auto;position:relative;transition:all 200ms cubic-bezier(0.4,0,0.2,1);&.disabled{pointer-events:none;}.loading-overlay{background:linear-gradient(to bottom,rgba(255,255,255,0.01) 0%,#fff 100%);position:absolute;bottom:0;left:0;right:0;height:40px;width:100%;z-index:1;display:none;&.loading{display:block;}&:after{content:'';position:absolute;width:30px;height:30px;top:0;right:0;bottom:0;left:0;margin:auto;border-radius:50%;border-top:2px solid #1a5194;border-right:2px solid transparent;border-left:2px solid transparent;border-bottom:2px solid transparent;animation:loading 300ms cubic-bezier(0.4,0,0.2,1) infinite;}}@keyframes loading{to{transform:rotate(360deg);}}&.short{height:148px;}&.long{height:278px;& + .footer{&:before{content:'';position:absolute;top:-9px;left:0;right:0;height:9px;background:linear-gradient(to bottom,transparent 0%,rgba(55,55,55,0.1) 100%);}}}.table-row{display:flex;.win{color:red;}}}.footer{display:flex;border-top:1px solid #b2b2b2;border-bottom:1px solid #b2b2b2;font-weight:bold;position:relative;.win{color:red;}}}}.confirm-btn{height:45px;margin:10px auto;background:linear-gradient(to right,#7dcaff 0%,#1a5194 100%);width:200px;border-radius:50px;border:0;outline:none;color:#fff;font-size:0.875rem;display:block;}"])),
            ke = P.a.div.withConfig({componentId: "sc-1nobhsy-1"})(["position:relative;top:0;left:0;width:100%;height:45px;background:#7dcaff;background:linear-gradient(to right,#7dcaff 0%,#1a5194 100%);color:white;display:flex;justify-content:center;align-items:center;padding:0 12px;box-sizing:border-box;> div{flex:0 1 100%;text-align:center;}"]);

        function Be(t) {
            return (Be = "function" === typeof Symbol && "symbol" === typeof Symbol.iterator ? function (t) {
                return typeof t
            } : function (t) {
                return t && "function" === typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
            })(t)
        }

        function Ie(t, e) {
            for (var n = 0; n < e.length; n++) {
                var r = e[n];
                r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
            }
        }

        function Se(t) {
            return function () {
                var e, n = Ce(t);
                if (function () {
                    if ("undefined" === typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" === typeof Proxy) return !0;
                    try {
                        return Date.prototype.toString.call(Reflect.construct(Date, [], function () {
                        })), !0
                    } catch (t) {
                        return !1
                    }
                }()) {
                    var r = Ce(this).constructor;
                    e = Reflect.construct(n, arguments, r)
                } else e = n.apply(this, arguments);
                return function (t, e) {
                    if (e && ("object" === Be(e) || "function" === typeof e)) return e;
                    return function (t) {
                        if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return t
                    }(t)
                }(this, e)
            }
        }

        function Ce(t) {
            return (Ce = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) {
                return t.__proto__ || Object.getPrototypeOf(t)
            })(t)
        }

        function Re(t, e) {
            return (Re = Object.setPrototypeOf || function (t, e) {
                return t.__proto__ = e, t
            })(t, e)
        }

        var je = n(7).immutable, Ne = new Xt.b({defaultHeight: 350, fixedWidth: !0}), Pe = function (t) {
            !function (t, e) {
                if ("function" !== typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
                t.prototype = Object.create(e && e.prototype, {
                    constructor: {
                        value: t,
                        writable: !0,
                        configurable: !0
                    }
                }), e && Re(t, e)
            }(i, o.a.PureComponent);
            var e, n, r, a = Se(i);

            function i(t) {
                var e;
                return function (t, e) {
                    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                }(this, i), (e = a.call(this, t)).ListRef = o.a.createRef(), e.hideBetResult = function () {
                    e.context.setDragonBetResult()
                }, e.renderRow = function (t) {
                    var e = [];
                    return t.map(function (n) {
                        var r = je(n, "amount"), a = je(n, "contents"), i = (je(n, "drawNumber"), je(n, "exposure")),
                            u = je(n, "game"), c = (je(n, "gkey"), je(n, "lottery")), l = je(n, "message"),
                            s = je(n, "odds"), d = je(n, "success"), f = M(c, [u, a].join("_"));
                        e.push(o.a.createElement(Te, {key: t.indexOf(n)}, o.a.createElement(ze, null, o.a.createElement(Le, null, f.lotteryText), f.gameModeText, " ", f.gameBetText, " @", o.a.createElement(Me, null, s)), o.a.createElement(De, null, r), o.a.createElement(De, {className: d ? "last" : "failed"}, d ? i.toFixed(1) : "\u6295\u6ce8\u5931\u8d25 " + l)))
                    }), e
                }, e.state = {loading: !1}, e
            }

            return e = i, (n = [{
                key: "componentDidMount", value: function () {
                    Ne.clearAll()
                }
            }, {
                key: "componentWillUnmount", value: function () {
                    Ne.clearAll()
                }
            }, {
                key: "render", value: function () {
                    var t = this.context, e = je(t, "showDragonBetResult"),
                        n = (je(t, "totalBetAmount"), je(t, "dragonBetResult"));
                    if (!e) return null;
                    if (void 0 == n) return null;
                    var r = (n ? n.bets.length : 0) <= 3, a = function () {
                        var t = 0, e = 0;
                        return n.bets.forEach(function (n) {
                            n.success && (t += n.exposure, e += n.amount)
                        }), {win: t, bet: e}
                    };
                    return o.a.createElement(o.a.Fragment, null, o.a.createElement(Oe, null, o.a.createElement(ke, null, o.a.createElement(_e, null, "\u6295\u6ce8\u7ed3\u679c")), o.a.createElement("div", {className: "table-wrapper"}, o.a.createElement("div", {className: "table"}, o.a.createElement("div", {className: "head"}, o.a.createElement("span", null, "\u73a9\u6cd5"), o.a.createElement("span", null, "\u91d1\u989d"), o.a.createElement("span", null, "\u53ef\u8d62\u5956\u91d1")), o.a.createElement("div", {className: "body".concat(r ? " short" : " long ".concat(this.state.loading ? "disabled" : ""))}, o.a.createElement("div", {className: "loading-overlay".concat(this.state.loading ? " loading" : "")}), n && n.bets.length > 0 && o.a.createElement(Ge, null, this.renderRow(n.bets))), o.a.createElement("div", {className: "footer"}, o.a.createElement("span", null, "\u603b\u8ba1", n && n.bets.length || 0, "\u6ce8"), o.a.createElement("span", null, n ? a().bet : 0), o.a.createElement("span", null, n && a().win.toFixed(1))))), o.a.createElement("button", {
                        className: "confirm-btn",
                        onClick: this.hideBetResult
                    }, "\u786e\u8ba4")), o.a.createElement(Ee.a, {"data-show": "true"}))
                }
            }]) && Ie(e.prototype, n), r && Ie(e, r), i
        }();
        Pe.contextType = N;
        var Ae = Pe,
            _e = P.a.div.withConfig({componentId: "sc-1yf923g-0"})(["color:white;font-size:18px;font-weight:bold;"]),
            Ge = P.a.div.withConfig({componentId: "sc-1yf923g-1"})(["display:flex;flex-direction:column;"]),
            Te = P.a.div.withConfig({componentId: "sc-1yf923g-2"})(["margin-top:10px;display:flex;flex-direction:row;justify-content:space-between;"]),
            ze = P.a.div.withConfig({componentId: "sc-1yf923g-3"})(["width:60%;color:#2E69A9;"]),
            De = P.a.div.withConfig({componentId: "sc-1yf923g-4"})(["width:20%;&.failed{color:#E50000;}&.last{text-align:right;}"]),
            Le = P.a.div.withConfig({componentId: "sc-1yf923g-5"})(["font-weight:bold;"]),
            Me = P.a.div.withConfig({componentId: "sc-1yf923g-6"})(["color:#E50000;"]);
        n(7).immutable, e.default = function (t) {
            return o.a.createElement(j, null, o.a.createElement(Ot, null), o.a.createElement(xe, null), o.a.createElement(Ae, null))
        }
    }, 905: function (t, e, n) {
        t.exports = n.p + "assets/static/RedTagPng.ba90bbf3.png"
    }, 906: function (t, e, n) {
        t.exports = n.p + "assets/static/BlueTagPng.93fe0fbb.png"
    }
}]);
