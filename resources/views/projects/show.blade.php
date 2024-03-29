@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="w-full">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="m-0 p-0">{{ $project->name }}</h4>
                            <button class="btn btn-success ms-auto" onclick="ShowAddBoard()">Tambah board</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <p>Deskripsi: {!! $project->description !!}</p>
                        <div id="kanban_container" style="max-width: 99%; overflow-x: auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddBoardModal" tabindex="-1" aria-labelledby="AddBoardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddBoardModalLabel">Board Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="description" class="d-block form-label">Nama Board</label>
                    <input id="NewBoardInputName" type="text" class="form-control" name="new_board_name" value=""
                        required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                    <button type="button" class="btn btn-primary" onclick="AddBoard()">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddItemModal" tabindex="-1" aria-labelledby="AddItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddItemModalLabel">Tambah Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="description" class="d-block form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" id="description" style="min-height: 10rem;" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                    <button type="button" class="btn btn-primary" onclick="AddItem()">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        ! function e(n, t, o) {
            function r(a, d) {
                if (!t[a]) {
                    if (!n[a]) {
                        var c = "function" == typeof require && require;
                        if (!d && c) return c(a, !0);
                        if (i) return i(a, !0);
                        var u = new Error("Cannot find module '" + a + "'");
                        throw u.code = "MODULE_NOT_FOUND", u
                    }
                    var l = t[a] = {
                        exports: {}
                    };
                    n[a][0].call(l.exports, function(e) {
                        var t = n[a][1][e];
                        return r(t || e)
                    }, l, l.exports, e, n, t, o)
                }
                return t[a].exports
            }
            for (var i = "function" == typeof require && require, a = 0; a < o.length; a++) r(o[a]);
            return r
        }({
            1: [function(e, n, t) {
                var o = e("dragula");
                ! function() {
                    this.jKanban = function() {
                        var e = this;
                        this.element = "", this.container = "", this.boardContainer = [], this.dragula = o,
                            this.drake = "", this.drakeBoard = "", this.addItemButton = !1, this
                            .buttonContent = "+", defaults = {
                                element: "",
                                gutter: "15px",
                                widthBoard: "250px",
                                responsive: "700",
                                boards: [],
                                addItemButton: !1,
                                buttonContent: "+",
                                dragEl: function(e, n) {},
                                dragendEl: function(e) {},
                                dropEl: function(e, n, t, o) {},
                                dragBoard: function(e, n) {},
                                dragendBoard: function(e) {},
                                dropBoard: function(e, n, t, o) {},
                                click: function(e) {},
                                buttonClick: function(e, n) {}
                            }, arguments[0] && "object" == typeof arguments[0] && (this.options = function(
                                e, n) {
                                var t;
                                for (t in n) n.hasOwnProperty(t) && (e[t] = n[t]);
                                return e
                            }(defaults, arguments[0])), this.init = function() {
                                ! function() {
                                    e.element = document.querySelector(e.options.element);
                                    var n = document.createElement("div");
                                    n.classList.add("kanban-container"), e.container = n, e.addBoards(e
                                        .options.boards), e.element.appendChild(e.container)
                                }(), window.innerWidth > e.options.responsive && (e.drakeBoard = e.dragula([
                                    e.container
                                ], {
                                    moves: function(e, n, t, o) {
                                        return t.classList.contains(
                                                "kanban-board-header") || t.classList
                                            .contains(
                                                "kanban-title-board")
                                    },
                                    accepts: function(e, n, t, o) {
                                        return n.classList.contains("kanban-container")
                                    },
                                    revertOnSpill: !0,
                                    direction: "horizontal"
                                }).on("drag", function(n, t) {
                                    n.classList.add("is-moving"), e.options.dragBoard(n, t),
                                        "function" == typeof n.dragfn && n.dragfn(n, t)
                                }).on("dragend", function(n) {
                                    n.classList.remove("is-moving"), e.options.dragendBoard(n),
                                        "function" == typeof n.dragendfn && n.dragendfn(n)
                                }).on("drop", function(n, t, o, r) {
                                    n.classList.remove("is-moving"), e.options.dropBoard(n, t,
                                        o, r), "function" == typeof n.dropfn && n.dropfn(n,
                                        t, o, r)
                                }), e.drake = e.dragula(e.boardContainer, function() {}).on("drag",
                                    function(n, t) {
                                        n.classList.add("is-moving");
                                        var o = r(t.parentNode.dataset.id);
                                        void 0 !== o.dragTo && e.options.boards.map(function(n) {
                                                -1 === o.dragTo.indexOf(n.id) && n.id !== t
                                                    .parentNode.dataset.id && e.findBoard(n.id)
                                                    .classList.add("disabled-board")
                                            }), e.options.dragEl(n, t), null !== n && "function" ==
                                            typeof n.dragfn && n.dragfn(n, t)
                                    }).on("dragend", function(n) {
                                    e.options.dragendEl(n), null !== n && "function" == typeof n
                                        .dragendfn && n.dragendfn(n)
                                }).on("drop", function(n, t, o, i) {
                                    var a = document.querySelectorAll(".kanban-board");
                                    if (a.length > 0 && void 0 !== a)
                                        for (var d = 0; d < a.length; d++) a[d].classList
                                            .remove("disabled-board");
                                    var c = r(o.parentNode.dataset.id);
                                    void 0 !== c.dragTo && -1 === c.dragTo.indexOf(t.parentNode
                                            .dataset.id) && t.parentNode.dataset.id !== o
                                        .parentNode.dataset.id && e.drake.cancel(!0), null !==
                                        n && (e.options.dropEl(n, t, o, i), n.classList.remove(
                                                "is-moving"), "function" == typeof n.dropfn && n
                                            .dropfn(n, t, o, i))
                                }))
                            }, this.addElement = function(t, o) {
                                var r = e.element.querySelector('[data-id="' + t + '"] .kanban-drag'),
                                    i = document.createElement("div");
                                return i.classList.add("kanban-item"), i.innerHTML = o.title, i.clickfn = o
                                    .click, i.dragfn = o.drag, i.dragendfn = o.dragend, i.dropfn = o.drop,
                                    n(i), r.appendChild(i), e
                            }, this.addForm = function(n, t) {
                                return e.element.querySelector('[data-id="' + n + '"] .kanban-drag')
                                    .appendChild(t), e
                            }, this.addBoards = function(o) {
                                var r = e.options.widthBoard,
                                    i = e.options.addItemButton,
                                    a = e.options.buttonContent;
                                for (var d in o) {
                                    var c = o[d];
                                    e.options.boards.push(c), "" === e.container.style.width ? e.container
                                        .style.width = parseInt(r) + 2 * parseInt(e.options.gutter) + "px" :
                                        e.container.style.width = parseInt(e.container.style.width) +
                                        parseInt(r) + 2 * parseInt(e.options.gutter) + "px";
                                    var u = document.createElement("div");
                                    u.dataset.id = c.id, u.classList.add("kanban-board"), u.style.width = r,
                                        u.style.marginLeft = e.options.gutter, u.style.marginRight = e
                                        .options.gutter;
                                    var l = document.createElement("header");
                                    if (l.classList.add("kanban-board-header", c.class), l.innerHTML =
                                        '<div class="kanban-title-board">' + c.title + "</div>", i) {
                                        var s = document.createElement("BUTTON"),
                                            f = document.createTextNode(a);
                                        s.setAttribute("class",
                                                "kanban-title-button btn btn-default btn-xs"), s
                                            .appendChild(f), l.appendChild(s), t(s, c.id)
                                    }
                                    var p = document.createElement("main");
                                    p.classList.add("kanban-drag"), e.boardContainer.push(p);
                                    for (var v in c.item) {
                                        var m = c.item[v],
                                            g = document.createElement("div");
                                        g.classList.add("kanban-item"), g.dataset.eid = m.id, g.innerHTML =
                                            m.title, g.clickfn = m.click, g.dragfn = m.drag, g.dragendfn = m
                                            .dragend, g.dropfn = m.drop, n(g), p.appendChild(g)
                                    }
                                    var h = document.createElement("footer");
                                    u.appendChild(l), u.appendChild(p), u.appendChild(h), e.container
                                        .appendChild(u)
                                }
                                return e
                            }, this.findBoard = function(n) {
                                return e.element.querySelector('[data-id="' + n + '"]')
                            }, this.findElement = function(n) {
                                return e.element.querySelector('[data-eid="' + n + '"]')
                            }, this.getBoardElements = function(n) {
                                return e.element.querySelector('[data-id="' + n + '"] .kanban-drag')
                                    .childNodes
                            }, this.removeElement = function(n) {
                                return "string" == typeof n && (n = e.element.querySelector('[data-eid="' +
                                    n + '"]')), n.remove(), e
                            }, this.removeBoard = function(n) {
                                return "string" == typeof n && (n = e.element.querySelector('[data-id="' +
                                    n + '"]')), n.remove(), e
                            }, this.onButtonClick = function(e) {};

                        function n(n, t) {
                            n.addEventListener("click", function(n) {
                                n.preventDefault, e.options.click(this), "function" == typeof this
                                    .clickfn && this.clickfn(this)
                            })
                        }

                        function t(n, t) {
                            n.addEventListener("click", function(n) {
                                n.preventDefault, e.options.buttonClick(this, t)
                            })
                        }

                        function r(n) {
                            var t = [];
                            return e.options.boards.map(function(e) {
                                if (e.id === n) return t.push(e)
                            }), t[0]
                        }
                        this.init()
                    }
                }()
            }, {
                dragula: 9
            }],
            2: [function(e, n, t) {
                n.exports = function(e, n) {
                    return Array.prototype.slice.call(e, n)
                }
            }, {}],
            3: [function(e, n, t) {
                "use strict";
                var o = e("ticky");
                n.exports = function(e, n, t) {
                    e && o(function() {
                        e.apply(t || null, n || [])
                    })
                }
            }, {
                ticky: 10
            }],
            4: [function(e, n, t) {
                "use strict";
                var o = e("atoa"),
                    r = e("./debounce");
                n.exports = function(e, n) {
                    var t = n || {},
                        i = {};
                    return void 0 === e && (e = {}), e.on = function(n, t) {
                        return i[n] ? i[n].push(t) : i[n] = [t], e
                    }, e.once = function(n, t) {
                        return t._once = !0, e.on(n, t), e
                    }, e.off = function(n, t) {
                        var o = arguments.length;
                        if (1 === o) delete i[n];
                        else if (0 === o) i = {};
                        else {
                            var r = i[n];
                            if (!r) return e;
                            r.splice(r.indexOf(t), 1)
                        }
                        return e
                    }, e.emit = function() {
                        var n = o(arguments);
                        return e.emitterSnapshot(n.shift()).apply(this, n)
                    }, e.emitterSnapshot = function(n) {
                        var a = (i[n] || []).slice(0);
                        return function() {
                            var i = o(arguments),
                                d = this || e;
                            if ("error" === n && !1 !== t.throws && !a.length) throw 1 === i
                                .length ? i[0] : i;
                            return a.forEach(function(o) {
                                t.async ? r(o, i, d) : o.apply(d, i), o._once && e.off(n, o)
                            }), e
                        }
                    }, e
                }
            }, {
                "./debounce": 3,
                atoa: 2
            }],
            5: [function(e, n, t) {
                (function(t) {
                    "use strict";
                    var o = e("custom-event"),
                        r = e("./eventmap"),
                        i = t.document,
                        a = function(e, n, t, o) {
                            return e.addEventListener(n, t, o)
                        },
                        d = function(e, n, t, o) {
                            return e.removeEventListener(n, t, o)
                        },
                        c = [];
                    t.addEventListener || (a = function(e, n, o) {
                        return e.attachEvent("on" + n, function(e, n, o) {
                            var r = u(e, n, o) || (i = e, a = o, function(e) {
                                var n = e || t.event;
                                n.target = n.target || n.srcElement, n
                                    .preventDefault = n.preventDefault ||
                                    function() {
                                        n.returnValue = !1
                                    }, n.stopPropagation = n.stopPropagation ||
                                    function() {
                                        n.cancelBubble = !0
                                    }, n.which = n.which || n.keyCode, a.call(i, n)
                            });
                            var i, a;
                            return c.push({
                                wrapper: r,
                                element: e,
                                type: n,
                                fn: o
                            }), r
                        }(e, n, o))
                    }, d = function(e, n, t) {
                        var o = u(e, n, t);
                        if (o) return e.detachEvent("on" + n, o)
                    }), n.exports = {
                        add: a,
                        remove: d,
                        fabricate: function(e, n, t) {
                            var a = -1 === r.indexOf(n) ? new o(n, {
                                detail: t
                            }) : function() {
                                var e;
                                i.createEvent ? (e = i.createEvent("Event")).initEvent(n, !0, !
                                    0) : i.createEventObject && (e = i.createEventObject());
                                return e
                            }();
                            e.dispatchEvent ? e.dispatchEvent(a) : e.fireEvent("on" + n, a)
                        }
                    };

                    function u(e, n, t) {
                        var o = function(e, n, t) {
                            var o, r;
                            for (o = 0; o < c.length; o++)
                                if ((r = c[o]).element === e && r.type === n && r.fn === t) return o
                        }(e, n, t);
                        if (o) {
                            var r = c[o].wrapper;
                            return c.splice(o, 1), r
                        }
                    }
                }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self :
                    "undefined" != typeof window ? window : {})
            }, {
                "./eventmap": 6,
                "custom-event": 7
            }],
            6: [function(e, n, t) {
                (function(e) {
                    "use strict";
                    var t = [],
                        o = "",
                        r = /^on/;
                    for (o in e) r.test(o) && t.push(o.slice(2));
                    n.exports = t
                }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self :
                    "undefined" != typeof window ? window : {})
            }, {}],
            7: [function(e, n, t) {
                (function(e) {
                    var t = e.CustomEvent;
                    n.exports = function() {
                        try {
                            var e = new t("cat", {
                                detail: {
                                    foo: "bar"
                                }
                            });
                            return "cat" === e.type && "bar" === e.detail.foo
                        } catch (e) {}
                        return !1
                    }() ? t : "function" == typeof document.createEvent ? function(e, n) {
                        var t = document.createEvent("CustomEvent");
                        return n ? t.initCustomEvent(e, n.bubbles, n.cancelable, n.detail) : t
                            .initCustomEvent(e, !1, !1, void 0), t
                    } : function(e, n) {
                        var t = document.createEventObject();
                        return t.type = e, n ? (t.bubbles = Boolean(n.bubbles), t.cancelable = Boolean(n
                            .cancelable), t.detail = n.detail) : (t.bubbles = !1, t.cancelable = !1,
                            t.detail = void 0), t
                    }
                }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self :
                    "undefined" != typeof window ? window : {})
            }, {}],
            8: [function(e, n, t) {
                "use strict";
                var o = {},
                    r = "(?:^|\\s)",
                    i = "(?:\\s|$)";

                function a(e) {
                    var n = o[e];
                    return n ? n.lastIndex = 0 : o[e] = n = new RegExp(r + e + i, "g"), n
                }
                n.exports = {
                    add: function(e, n) {
                        var t = e.className;
                        t.length ? a(n).test(t) || (e.className += " " + n) : e.className = n
                    },
                    rm: function(e, n) {
                        e.className = e.className.replace(a(n), " ").trim()
                    }
                }
            }, {}],
            9: [function(e, n, t) {
                (function(t) {
                    "use strict";
                    var o = e("contra/emitter"),
                        r = e("crossvent"),
                        i = e("./classes"),
                        a = document,
                        d = a.documentElement;

                    function c(e, n, o, i) {
                        t.navigator.pointerEnabled ? r[n](e, {
                            mouseup: "pointerup",
                            mousedown: "pointerdown",
                            mousemove: "pointermove"
                        } [o], i) : t.navigator.msPointerEnabled ? r[n](e, {
                            mouseup: "MSPointerUp",
                            mousedown: "MSPointerDown",
                            mousemove: "MSPointerMove"
                        } [o], i) : (r[n](e, {
                            mouseup: "touchend",
                            mousedown: "touchstart",
                            mousemove: "touchmove"
                        } [o], i), r[n](e, o, i))
                    }

                    function u(e) {
                        if (void 0 !== e.touches) return e.touches.length;
                        if (void 0 !== e.which && 0 !== e.which) return e.which;
                        if (void 0 !== e.buttons) return e.buttons;
                        var n = e.button;
                        return void 0 !== n ? 1 & n ? 1 : 2 & n ? 3 : 4 & n ? 2 : 0 : void 0
                    }

                    function l(e, n) {
                        return void 0 !== t[n] ? t[n] : d.clientHeight ? d[e] : a.body[e]
                    }

                    function s(e, n, t) {
                        var o, r = e || {},
                            i = r.className;
                        return r.className += " gu-hide", o = a.elementFromPoint(n, t), r.className = i, o
                    }

                    function f() {
                        return !1
                    }

                    function p() {
                        return !0
                    }

                    function v(e) {
                        return e.width || e.right - e.left
                    }

                    function m(e) {
                        return e.height || e.bottom - e.top
                    }

                    function g(e) {
                        return e.parentNode === a ? null : e.parentNode
                    }

                    function h(e) {
                        return "INPUT" === e.tagName || "TEXTAREA" === e.tagName || "SELECT" === e
                            .tagName || function e(n) {
                                if (!n) return !1;
                                if ("false" === n.contentEditable) return !1;
                                if ("true" === n.contentEditable) return !0;
                                return e(g(n))
                            }(e)
                    }

                    function b(e) {
                        return e.nextElementSibling || function() {
                            var n = e;
                            do {
                                n = n.nextSibling
                            } while (n && 1 !== n.nodeType);
                            return n
                        }()
                    }

                    function y(e, n) {
                        var t, o = (t = n, t.targetTouches && t.targetTouches.length ? t.targetTouches[0] :
                                t.changedTouches && t.changedTouches.length ? t.changedTouches[0] : t),
                            r = {
                                pageX: "clientX",
                                pageY: "clientY"
                            };
                        return e in r && !(e in o) && r[e] in o && (e = r[e]), o[e]
                    }
                    n.exports = function(e, n) {
                        1 === arguments.length && !1 === Array.isArray(e) && (n = e, e = []);
                        var t, E, w, C, S, k, x, B, L, T, N, O, I = null,
                            q = n || {};
                        void 0 === q.moves && (q.moves = p), void 0 === q.accepts && (q.accepts = p),
                            void 0 === q.invalid && (q.invalid = function() {
                                return !1
                            }), void 0 === q.containers && (q.containers = e || []), void 0 === q
                            .isContainer && (q.isContainer = f), void 0 === q.copy && (q.copy = !1),
                            void 0 === q.copySortSource && (q.copySortSource = !1), void 0 === q
                            .revertOnSpill && (q.revertOnSpill = !1), void 0 === q.removeOnSpill && (q
                                .removeOnSpill = !1), void 0 === q.direction && (q.direction =
                                "vertical"), void 0 === q.ignoreInputTextSelection && (q
                                .ignoreInputTextSelection = !0), void 0 === q.mirrorContainer && (q
                                .mirrorContainer = a.body);
                        var X = o({
                            containers: q.containers,
                            start: function(e) {
                                var n = U(e);
                                n && F(n)
                            },
                            end: H,
                            cancel: W,
                            remove: V,
                            destroy: function() {
                                P(!0), K({})
                            },
                            canMove: function(e) {
                                return !!U(e)
                            },
                            dragging: !1
                        });
                        return !0 === q.removeOnSpill && X.on("over", function(e) {
                            i.rm(e, "gu-hide")
                        }).on("out", function(e) {
                            X.dragging && i.add(e, "gu-hide")
                        }), P(), X;

                        function D(e) {
                            return -1 !== X.containers.indexOf(e) || q.isContainer(e)
                        }

                        function P(e) {
                            var n = e ? "remove" : "add";
                            c(d, n, "mousedown", R), c(d, n, "mouseup", K)
                        }

                        function Y(e) {
                            c(d, e ? "remove" : "add", "mousemove", j)
                        }

                        function M(e) {
                            var n = e ? "remove" : "add";
                            r[n](d, "selectstart", A), r[n](d, "click", A)
                        }

                        function A(e) {
                            O && e.preventDefault()
                        }

                        function R(e) {
                            if (k = e.clientX, x = e.clientY, 1 === u(e) && !e.metaKey && !e.ctrlKey) {
                                var n = e.target,
                                    t = U(n);
                                t && (O = t, Y(), "mousedown" === e.type && (h(n) ? n.focus() : e
                                    .preventDefault()))
                            }
                        }

                        function j(e) {
                            if (O)
                                if (0 !== u(e)) {
                                    if (void 0 === e.clientX || e.clientX !== k || void 0 === e
                                        .clientY || e.clientY !== x) {
                                        if (q.ignoreInputTextSelection) {
                                            var n = y("clientX", e),
                                                o = y("clientY", e);
                                            if (h(a.elementFromPoint(n, o))) return
                                        }
                                        var r = O;
                                        Y(!0), M(), H(), F(r);
                                        var s = function(e) {
                                            var n = e.getBoundingClientRect();
                                            return {
                                                left: n.left + l("scrollLeft", "pageXOffset"),
                                                top: n.top + l("scrollTop", "pageYOffset")
                                            }
                                        }(w);
                                        C = y("pageX", e) - s.left, S = y("pageY", e) - s.top, i.add(
                                                T || w, "gu-transit"),
                                            function() {
                                                if (!t) {
                                                    var e = w.getBoundingClientRect();
                                                    (t = w.cloneNode(!0)).style.width = v(e) + "px", t
                                                        .style.height = m(e) + "px", i.rm(t,
                                                            "gu-transit"), i.add(t, "gu-mirror"), q
                                                        .mirrorContainer.appendChild(t), c(d, "add",
                                                            "mousemove", Q), i.add(q.mirrorContainer,
                                                            "gu-unselectable"), X.emit("cloned", t, w,
                                                            "mirror")
                                                }
                                            }(), Q(e)
                                    }
                                } else K({})
                        }

                        function U(e) {
                            if (!(X.dragging && t || D(e))) {
                                for (var n = e; g(e) && !1 === D(g(e));) {
                                    if (q.invalid(e, n)) return;
                                    if (!(e = g(e))) return
                                }
                                var o = g(e);
                                if (o && !q.invalid(e, n) && q.moves(e, o, n, b(e))) return {
                                    item: e,
                                    source: o
                                }
                            }
                        }

                        function F(e) {
                            n = e.item, t = e.source, ("boolean" == typeof q.copy ? q.copy : q.copy(n,
                                t)) && (T = e.item.cloneNode(!0), X.emit("cloned", T, e.item,
                                "copy"));
                            var n, t;
                            E = e.source, w = e.item, B = L = b(e.item), X.dragging = !0, X.emit("drag",
                                w, E)
                        }

                        function H() {
                            if (X.dragging) {
                                var e = T || w;
                                z(e, g(e))
                            }
                        }

                        function _() {
                            O = !1, Y(!0), M(!0)
                        }

                        function K(e) {
                            if (_(), X.dragging) {
                                var n = T || w,
                                    o = y("clientX", e),
                                    r = y("clientY", e),
                                    i = J(s(t, o, r), o, r);
                                i && (T && q.copySortSource || !T || i !== E) ? z(n, i) : q
                                    .removeOnSpill ? V() : W()
                            }
                        }

                        function z(e, n) {
                            var t = g(e);
                            T && q.copySortSource && n === E && t.removeChild(w), G(n) ? X.emit(
                                "cancel", e, E, E) : X.emit("drop", e, n, E, L), $()
                        }

                        function V() {
                            if (X.dragging) {
                                var e = T || w,
                                    n = g(e);
                                n && n.removeChild(e), X.emit(T ? "cancel" : "remove", e, n, E), $()
                            }
                        }

                        function W(e) {
                            if (X.dragging) {
                                var n = arguments.length > 0 ? e : q.revertOnSpill,
                                    t = T || w,
                                    o = g(t),
                                    r = G(o);
                                !1 === r && n && (T ? o && o.removeChild(T) : E.insertBefore(t, B)),
                                    r || n ? X.emit("cancel", t, E, E) : X.emit("drop", t, o, E, L), $()
                            }
                        }

                        function $() {
                            var e = T || w;
                            _(), t && (i.rm(q.mirrorContainer, "gu-unselectable"), c(d, "remove",
                                    "mousemove", Q), g(t).removeChild(t), t = null), e && i.rm(e,
                                    "gu-transit"), N && clearTimeout(N), X.dragging = !1, I && X.emit(
                                    "out", e, I, E), X.emit("dragend", e), E = w = T = B = L = N = I =
                                null
                        }

                        function G(e, n) {
                            var o;
                            return o = void 0 !== n ? n : t ? L : b(T || w), e === E && o === B
                        }

                        function J(e, n, t) {
                            for (var o = e; o && !r();) o = g(o);
                            return o;

                            function r() {
                                if (!1 === D(o)) return !1;
                                var r = Z(o, e),
                                    i = ee(o, r, n, t);
                                return !!G(o, i) || q.accepts(w, o, E, i)
                            }
                        }

                        function Q(e) {
                            if (t) {
                                e.preventDefault();
                                var n = y("clientX", e),
                                    o = y("clientY", e),
                                    r = n - C,
                                    i = o - S;
                                t.style.left = r + "px", t.style.top = i + "px";
                                var a = T || w,
                                    d = s(t, n, o),
                                    c = J(d, n, o),
                                    u = null !== c && c !== I;
                                (u || null === c) && (I && v("out"), I = c, u && v("over"));
                                var l = g(a);
                                if (c !== E || !T || q.copySortSource) {
                                    var f, p = Z(c, d);
                                    if (null !== p) f = ee(c, p, n, o);
                                    else {
                                        if (!0 !== q.revertOnSpill || T) return void(T && l && l
                                            .removeChild(a));
                                        f = B, c = E
                                    }(null === f && u || f !== a && f !== b(a)) && (L = f, c
                                        .insertBefore(a, f), X.emit("shadow", a, c, E))
                                } else l && l.removeChild(a)
                            }

                            function v(e) {
                                X.emit(e, a, I, E)
                            }
                        }

                        function Z(e, n) {
                            for (var t = n; t !== e && g(t) !== e;) t = g(t);
                            return t === d ? null : t
                        }

                        function ee(e, n, t, o) {
                            var r = "horizontal" === q.direction;
                            return n !== e ? function() {
                                var e = n.getBoundingClientRect();
                                return i(r ? t > e.left + v(e) / 2 : o > e.top + m(e) / 2)
                            }() : function() {
                                var n, i, a, d = e.children.length;
                                for (n = 0; n < d; n++) {
                                    if (i = e.children[n], a = i.getBoundingClientRect(), r && a
                                        .left + a.width / 2 > t) return i;
                                    if (!r && a.top + a.height / 2 > o) return i
                                }
                                return null
                            }();

                            function i(e) {
                                return e ? b(n) : n
                            }
                        }
                    }
                }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self :
                    "undefined" != typeof window ? window : {})
            }, {
                "./classes": 8,
                "contra/emitter": 4,
                crossvent: 5
            }],
            10: [function(e, n, t) {
                var o;
                o = "function" == typeof setImmediate ? function(e) {
                    setImmediate(e)
                } : function(e) {
                    setTimeout(e, 0)
                }, n.exports = o
            }, {}]
        }, {}, [1]);
    </script>
    <script>
        var kanban = null
        var AddItemModalAl = null;
        var AddBoardModalAl = null;
        var currentActiveAddItem = null;

        function slugify(str) {
            return String(str)
                .normalize('NFKD') // split accented characters into their base characters and diacritical marks
                .replace(/[\u0300-\u036f]/g,
                    '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
                .trim() // trim leading or trailing whitespace
                .toLowerCase() // convert to lowercase
                .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
                .replace(/\s+/g, '-') // replace spaces with hyphens
                .replace(/-+/g, '-'); // remove consecutive hyphens
        }

        function ShowAddBoard() {
            AddBoardModalAl.toggle();
        }

        function AddBoard() {
            const title = AddBoardModalAl._element.querySelector("input").value
            const d = {
                "id": Math.floor((Math.random() * 99) + 10) + "_" + slugify(title).substring(0, 10),
                "title": title,
                "item": []
            };
            AddBoardModalAl.toggle();
            kanban.addBoards([d]);
            initUIAddOn();
            AddBoardModalAl._element.querySelector("input").value = ""
        }

        function showAddItem(id) {
            currentActiveAddItem = id;
            AddItemModalAl.toggle();
        }

        function AddItem() {
            const id = currentActiveAddItem
            const content = document.querySelector("#AddItemModal textarea").value
            const nid = Math.floor((Math.random() * 99) + 10) + "_" + slugify(content).substring(0, 10)
            const d = {
                "id": nid,
                "title": content,
            }
            kanban.addElement(id, d)
            const board_focus = kanban.getBoardElements(id)
            const new_el = board_focus[board_focus.length - 1]
            new_el.setAttribute("data-eid", nid)
            AddItemModalAl.toggle();
            document.querySelector("#AddItemModal textarea").value = ""
        }

        function initUIAddOn() {
            const boardsel = kanban.element.querySelector(".kanban-container").children;
            [...boardsel].forEach(element => {
                if (!element.querySelector(".btn-add-item")) {
                    var btn = document.createElement("BUTTON")
                    btn.classList.add("btn")
                    btn.classList.add("btn-primary")
                    btn.classList.add("mb-2")
                    btn.classList.add("ms-2")
                    btn.classList.add("btn-add-item")
                    btn.onclick = (e) => {
                        showAddItem(element.attributes["data-id"].value)
                    }
                    btn.innerHTML = "Item Baru"
                    element.querySelector("footer").appendChild(btn)
                }
            });
        }

        function getKanbanJSON() {
            const el = kanban.element.querySelector(".kanban-container")
            const boardsel = el.children;
            let jsonData = [];

            [...boardsel].forEach((element, index) => {
                var data = {
                    "order": index,
                    "id": element.attributes["data-id"].value,
                    "title": element.querySelector("header .kanban-title-board").innerHTML,
                    "items": [],
                };

                var el_items = element.querySelectorAll("main .kanban-item")
                el_items.forEach((it, idx) => {
                    var nid = "";
                    if (!it.getAttribute("data-eid").trim()) {
                        nid = Math.floor((Math.random() * 99) + 10) + "_" + slugify(content).substring(0,
                            10)
                    } else {
                        nid = it.getAttribute("data-eid")
                    }
                    const i = {
                        "order": idx,
                        "id": nid,
                        "title": it.innerHTML,
                    };

                    data["items"].push(i);
                })


                jsonData.push(data);
            });
        }

        document.onreadystatechange = function() {
            if (document.readyState == "complete") {

                kanban = new jKanban({
                    element: '#kanban_container',
                    gutter: '15px',
                    itemAddOptions: {
                        enabled: true, // add a button to board for easy item creation
                        content: '+', // text or html content of the board button
                        class: 'kanban-title-button btn btn-default btn-xs', // default class of the button
                        footer: false // position the button on footer
                    },
                    click: function(el) {},
                    dragBoards: true,
                    dragItems: true,
                    responsivePercentage: true,
                    boards: [{
                            'id': '_todo',
                            'title': 'To Do',
                            'class': 'info',
                            'item': [{
                                "id": "_mytask",
                                'title': 'My Task Test',
                            }]
                        },
                        {
                            'id': '_working',
                            'title': 'Working',
                            'class': 'warning',
                            'item': [{
                                'title': 'Run?',
                            }]
                        },
                        {
                            'id': '_done',
                            'title': 'Done',
                            'class': 'success',
                            'item': [{
                                'title': 'Ok!',
                            }]
                        }
                    ], // json of boards
                });
                initUIAddOn();

                AddItemModalAl = new window.bootstrap.Modal('#AddItemModal', {})
                AddBoardModalAl = new window.bootstrap.Modal('#AddBoardModal', {})
            }
        }
    </script>
@endsection
