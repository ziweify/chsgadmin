$(function() {
    $("#username").change(function() {
        location.href = LIBS.url({
            username: $(this).val()
        })
    });
    $("#btnRefresh").click(function() {
        Panel.reload(true)
    });
    Panel.init()
});
function logs(a) {
    location.href = LIBS.url("logs", {
        planId: a,
        username: $("#username").val()
    })
}
function edit(a) {
    location.href = LIBS.url("setting", {
        planId: a,
        action: "edit",
        username: $("#username").val()
    })
}
function add() {
    location.href = LIBS.url("setting", {
        action: "add",
        username: $("#username").val()
    })
}
function enabled(b, a) {
    swal({
        title: a ? "风险提示:" : "信息",
        text: a ? '跟投软件是作为用户的辅助工具，使用过程中<span style="color:red;">有一定的不可预估风险</span>，不能保证用户的注单是能够百分百成功下注，请您知悉！如出现跟投异常情况，并因此给您造成的损失<span style="color:red;">不予负责</span>。\n<br><br><p style="color:red;">启用前的注单不予再跟</p><br>\n同意此协议，启用将立即开始投注，是否确定启用？' : "已经产生的投注不撤销，是否确定停止？",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        closeOnCancel: true,
        html: true
    }, function(c) {
        if (c) {
            $.ajax({
                url: "enable",
                method: "POST",
                data: {
                    username: $("#username").val(),
                    planId: b,
                    enabled: a
                },
                success: function(d) {
                    d = JSON.parse(d);
                    if (d.success) {
                        var e = "操作成功";
                        if (d.message) {
                            e = d.message + e
                        }
                        setTimeout(function() {
                            swal({
                                title: "信息",
                                text: e,
                                confirmButtonText: "确定",
                                type: "success"
                            }, function() {
                                location.href = location.href
                            })
                        }, 200)
                    } else {
                        if (d.message) {
                            setTimeout(function() {
                                swal({
                                    title: "信息",
                                    text: d.message,
                                    confirmButtonText: "确定",
                                    type: "error"
                                }, function() {})
                            }, 200)
                        } else {
                            setTimeout(function() {
                                swal({
                                    title: "信息",
                                    text: "系统错误",
                                    confirmButtonText: "确定",
                                    type: "error"
                                }, function() {})
                            }, 200)
                        }
                    }
                },
                error: function() {
                    setTimeout(function() {
                        swal({
                            title: "信息",
                            text: "系统错误",
                            confirmButtonText: "确定",
                            type: "error"
                        }, function() {})
                    }, 200)
                }
            })
        }
    })
}
function deleted(a) {
    swal({
        title: "信息",
        text: "确定删除此投项？",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        closeOnCancel: true
    }, function(b) {
        if (b) {
            $.ajax({
                url: "delete",
                method: "POST",
                data: {
                    username: $("#username").val(),
                    planId: a
                },
                loading: true,
                success: function(c) {
                    c = JSON.parse(c);
                    if (c.success) {
                        setTimeout(function() {
                            swal({
                                title: "信息",
                                text: "操作成功",
                                confirmButtonText: "确定",
                                type: "success"
                            }, function() {
                                location.href = location.href
                            })
                        }, 200)
                    } else {
                        if (c.message) {
                            setTimeout(function() {
                                swal({
                                    title: "信息",
                                    text: c.message,
                                    confirmButtonText: "确定",
                                    type: "error"
                                }, function() {})
                            }, 200)
                        } else {
                            setTimeout(function() {
                                swal({
                                    title: "信息",
                                    text: "系统错误",
                                    confirmButtonText: "确定",
                                    type: "error"
                                }, function() {})
                            }, 200)
                        }
                    }
                },
                error: function() {
                    setTimeout(function() {
                        swal({
                            title: "信息",
                            text: "系统错误",
                            confirmButtonText: "确定",
                            type: "error"
                        }, function() {})
                    }, 200)
                }
            })
        }
    })
}
var Panel = (function() {
    return {
        timeOffset: 0,
        timer: null,
        interval: 90,
        refreshRemain: -1,
        countdownText: "刷新 {0}秒",
        countdownPanel: null,
        loadOptions: null,
        loadingState: null,
        lottery: null,
        key: null,
        gameMap: null,
        showAll: true,
        isNotice: false,
        now: function(a) {
            if (a) {
                return (new Date()).getTime()
            }
            return (new Date()).getTime() - this.timeOffset
        },
        settingTime: function(a) {
            a = Number(a);
            if (isNaN(a)) {
                return
            }
            this.timeOffset = this.now(true) - a
        },
        init: function(a) {
            LIBS.clone(this, a);
            if (!this.countdownPanel) {
                this.countdownPanel = $("#btnRefresh")
            }
            var b = this;
            LIBS.get("../../time", function(c) {
                b.settingTime(c)
            });
            this.timer = setInterval(function() {
                b.doInterval()
            }, 1000);
            this.changeInterval(30)
        },
        reload: function(a) {
            this.countdownPanel.val("载入中…");
            location.href = location.href
        },
        formatTime: function(a) {
            var b = Number(a);
            if (isNaN(b)) {
                return "-"
            }
            return new Date(b).format("hh:mm:ss")
        },
        changeInterval: function(a) {
            this.interval = a;
            this.refreshRemain = a;
            if (a > 0) {
                this.showRefreshRemain()
            }
        },
        showRefreshRemain: function(b) {
            if (b === undefined) {
                b = this.refreshRemain
            }
            if (b >= 0) {
                if ($.isFunction(this.countdownText)) {
                    this.countdownText(b);
                    return
                } else {
                    if (this.countdownPanel) {
                        if (b == 0) {
                            this.countdownPanel.val("载入中…")
                        } else {
                            var a = b;
                            if (this.countdownText) {
                                a = this.countdownText.format(a)
                            }
                            this.countdownPanel.val(a)
                        }
                    }
                }
            } else {
                this.countdownPanel.html("")
            }
        },
        doInterval: function() {
            if (this.interval <= 0) {
                return
            }
            this.refreshRemain -= 1;
            this.showRefreshRemain();
            if (this.refreshRemain <= 0) {
                this.reload(true)
            }
        }
    }
}
)();
