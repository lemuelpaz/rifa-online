(self.webpackChunk_N_E = self.webpackChunk_N_E || []).push([
    [892], {
        769: function(e, a, t) {
            "use strict";
            t.r(a), t.d(a, {
                __N_SSP: function() {
                    return q
                },
                default: function() {
                    return Z
                }
            });
            var n = t(3789),
                s = t(266),
                i = t(809),
                r = t.n(i),
                o = t(6715),
                c = t(6858),
                l = t(7109),
                d = t(4865),
                m = t.n(d),
                u = t(7294),
                p = t(4725),
                x = t(8476),
                h = t(1664),
                f = t(4699),
                v = t(8054),
                b = t(2592),
                g = t(6403),
                j = t.n(g),
                N = t(5893);

            function y(e) {
                var a = e.caixa,
                    t = (0, u.useState)(a),
                    n = t[0],
                    s = t[1],
                    i = n.aberta,
                    r = n.premiada,
                    c = "video-" + a.token,
                    l = "caixa-premiada--item d-flex py-2 px-3 rounded-2 mb-1 text-white text-center pointer\n                        ".concat(i ? r ? "bg-gradient-green" : "bg-gradient-pink" : "bg-gradient-yellow", "\n                        font-weight-600 justify-content-between");
                return (0, u.useEffect)((function() {
                    if (!i) {
                        var e = !1;
                        document.getElementById("".concat(c, "-btn")).addEventListener("click", (function() {
                            if (e) return null;
                            e = !0;
                            var a = document.getElementById(c),
                                t = document.createElement("img"),
                                i = document.getElementById("".concat(c, "-audio-abrindo")),
                                r = document.getElementById("".concat(c, "-audio-ganhou")),
                                l = document.getElementById("".concat(c, "-audio-perdeu"));
                            t.src = "/caixa-abrindo.gif?" + Math.random(), (0, o.Z)().get("/caixas-premiadas/abrir/" + n.token).then((function(e) {
                                var n = e.data;
                                a.style.pointerEvents = "auto", a.style.opacity = 1, a.appendChild(t), i.volume = .1, i.currentTime = 0, i.play(), setTimeout((function() {
                                    t.remove(), s(n.caixa), n.caixa.premiada ? (r.currentTime = 0, r.volume = .1, r.play()) : (l.currentTime = 0, l.volume = .1, l.play()), a.style.pointerEvents = "none", a.style.opacity = 0, setTimeout((function() {
                                        return a.remove()
                                    }), 2e3)
                                }), 4e3)
                            })).catch((function() {
                                return window.location.reload()
                            }))
                        }))
                    }
                }), []), (0, N.jsxs)("div", {
                    children: [(0, N.jsx)("div", {
                        id: c,
                        className: j().video,
                        style: {
                            pointerEvents: "none",
                            opacity: 0
                        }
                    }), (0, N.jsx)("audio", {
                        id: "".concat(c, "-audio-abrindo"),
                        src: "/caixa-abrindo.mp3",
                        controls: !1,
                        preload: !0
                    }), (0, N.jsx)("audio", {
                        id: "".concat(c, "-audio-ganhou"),
                        src: "/roleta-ganhou.wav",
                        controls: !1,
                        preload: !0
                    }), (0, N.jsx)("audio", {
                        id: "".concat(c, "-audio-perdeu"),
                        src: "/roleta-perdeu.wav",
                        controls: !1,
                        preload: !0
                    }), (0, N.jsxs)("div", {
                        className: l,
                        id: "".concat(c, "-btn"),
                        children: [(0, N.jsxs)("span", {
                            children: [(0, N.jsx)("i", {
                                className: "bi bi-gift-fill"
                            }), " Caixa premiada \ud83c\udf81"]
                        }), (0, N.jsx)("span", {
                            className: "badge text-bg-light bg-opacity-75 text-uppercase",
                            children: i ? n.premiada ? "Parab\xe9ns!" : "Aberta" : "Abrir!"
                        })]
                    }), i && (0, N.jsxs)("div", {
                        className: "mb-2",
                        children: [n.premiada && (0, N.jsxs)("div", {
                            className: j().caixaPremio,
                            children: [(0, N.jsxs)("div", {
                                className: "mb-2 text-center",
                                children: [n.img && (0, N.jsx)("img", {
                                    id: "imgPremio",
                                    src: n.img,
                                    className: "img-fluid mb-2 " + j().imagem
                                }), n.descricao && (0, N.jsxs)("p", {
                                    className: "mb-1",
                                    children: ["Voc\xea ganhou ", (0, N.jsx)("b", {
                                        children: n.descricao
                                    }), " \ud83c\udf89"]
                                })]
                            }), (0, N.jsxs)("p", {
                                className: "mb-0 font-xs text-secondary text-center",
                                children: [(0, N.jsx)("b", {
                                    children: "Parab\xe9ns"
                                }), " por sua caixa premiada.", (0, N.jsx)("br", {}), "Em breve nossa equipe entrar\xe1 em contato."]
                            })]
                        }), !n.premiada && (0, N.jsx)(N.Fragment, {
                            children: (0, N.jsxs)("div", {
                                className: "row justify-content-center align-items-center py-2",
                                children: [(0, N.jsx)("div", {
                                    className: "col-auto",
                                    children: (0, N.jsx)("h1", {
                                        children: (0, N.jsx)("i", {
                                            className: "bi bi-box text-danger"
                                        })
                                    })
                                }), (0, N.jsxs)("div", {
                                    className: "col-auto",
                                    children: [(0, N.jsx)("p", {
                                        className: "mb-1",
                                        children: "N\xe3o foi dessa vez"
                                    }), (0, N.jsxs)("p", {
                                        className: "font-xs",
                                        children: ["sua ", (0, N.jsx)("b", {
                                            children: "caixa premiada"
                                        }), " veio vazia \ud83e\udd72"]
                                    })]
                                })]
                            })
                        })]
                    })]
                })
            }

            function w(e) {
                var a = e.compra.caixas.filter((function(e) {
                    return "caixa" == e.tipo
                }));
                return 0 == a.length ? null : (0, N.jsx)("div", {
                    id: "card-caixa",
                    className: ["app-card cxabre card mb-2", j().compraAbrirCaixa].join(" "),
                    children: (0, N.jsx)("div", {
                        className: "card-body",
                        children: (0, N.jsxs)("div", {
                            className: "caixa-premiada--giros",
                            children: [(0, N.jsxs)("p", {
                                className: "opacity-50 font-xs mb-1",
                                children: ["Voc\xea tem (", a.length, ") caixa", a.length > 0 && "(s)", a.length > 0 ? " dispon\xedveis" : " dispon\xedvel", ":"]
                            }), (0, N.jsx)("div", {
                                className: "lista font-xs",
                                children: a.map((function(e, a) {
                                    return (0, N.jsx)(y, {
                                        caixa: e
                                    }, e.token)
                                }))
                            })]
                        })
                    })
                })
            }

            function k() {
                return (0, N.jsx)("div", {
                    className: "text-center mb-2",
                    children: (0, N.jsxs)("div", {
                        className: "py-2",
                        children: [(0, N.jsx)("div", {
                            className: "d-flex justify-content-center mb-3",
                            children: (0, N.jsx)("div", {
                                className: "card app-card rounded-circle",
                                style: {
                                    width: 92,
                                    height: 92
                                },
                                children: (0, N.jsx)("div", {
                                    className: "card-body",
                                    children: (0, N.jsx)("div", {
                                        children: (0, N.jsx)("i", {
                                            className: "bi bi-trophy text-warning",
                                            style: {
                                                fontSize: 60
                                            }
                                        })
                                    })
                                })
                            })
                        }), (0, N.jsx)("div", {
                            className: "font-md",
                            children: "Parab\xe9ns voc\xea foi o contemplado!"
                        }), (0, N.jsx)("small", {
                            className: "m-0 font-xss",
                            children: "Em breve, nossa equipe entrar\xe1 em contato com voc\xea."
                        })]
                    })
                })
            }

            function _(e) {
                var a = e.titulosPremiados,
                    t = a.length > 1 ? "s" : "";
                return (0, N.jsxs)("div", {
                    className: "alert alert-success mb-2 text-center",
                    children: [(0, N.jsx)("h3", {
                        children: "Parab\xe9ns! \ud83c\udf89"
                    }), (0, N.jsxs)("p", {
                        className: "font-xs",
                        children: ["Sua compra possu\xed", (0, N.jsxs)("b", {
                            children: [(0, N.jsxs)("b", {
                                children: [" ", a.length, " "]
                            }), "t\xedtulo", t, " contemplado", t]
                        }), (0, N.jsx)("br", {}), "na modalidade ", (0, N.jsx)("b", {
                            children: "Premia\xe7\xe3o Instant\xe2nea:"
                        })]
                    }), (0, N.jsx)("div", {
                        className: "row",
                        children: a.map((function(e, a) {
                            return (0, N.jsx)("div", {
                                className: "col mb-3",
                                children: (0, N.jsx)("div", {
                                    style: {
                                        fontSize: 28
                                    },
                                    children: e.cota
                                })
                            }, "tituloPremiado".concat(a))
                        }))
                    }), (0, N.jsx)("p", {
                        className: "m-0",
                        children: "Em breve, nossa equipe entrar\xe1 em contato com voc\xea."
                    })]
                })
            }
            var P = t(8517),
                C = t.n(P);

            function E(e) {
                var a = e.app,
                    t = e.compra;
                return (0, N.jsx)("div", {
                    className: "detalhes app-card card mb-2",
                    children: (0, N.jsxs)("div", {
                        className: "card-body font-xs",
                        children: [(0, N.jsxs)("div", {
                            className: "font-xs opacity-75 mb-2",
                            children: [(0, N.jsx)("i", {
                                className: "bi bi-info-circle"
                            }), " Detalhes da sua compra\xa0", (null === t || void 0 === t ? void 0 : t.hash) && (0, N.jsx)("div", {
                                className: "pt-1 opacity-50",
                                children: t.hash
                            })]
                        }), (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "Comprador:"
                            }), (0, N.jsx)("div", {
                                className: "result font-xs",
                                children: t.user.nomeSocial || t.user.nome
                            })]
                        }), t.user.cpf && (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "CPF:"
                            }), (0, N.jsx)("div", {
                                className: "result font-xs",
                                children: t.user.cpf
                            })]
                        }), (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "Telefone:"
                            }), (0, N.jsx)("div", {
                                className: "result font-xs",
                                children: t.user.telefone
                            })]
                        }), (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "Data/hor\xe1rio:"
                            }), (0, N.jsx)("div", {
                                className: "result font-xs",
                                children: t.data
                            })]
                        }), (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "Situa\xe7\xe3o:"
                            }), (0, N.jsx)("div", {
                                className: "result font-xs",
                                children: t.status.title
                            })]
                        }), (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "Total:"
                            }), (0, N.jsxs)("div", {
                                className: "result font-xs",
                                children: ["R$ ", (0, l.bC)(t.total)]
                            })]
                        }), t.grupos.length > 0 && (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "Grupos:"
                            }), (0, N.jsx)("div", {
                                className: "result font-xs align-middle",
                                style: {
                                    textAlign: "middle"
                                },
                                children: t.grupos.map((function(e) {
                                    return (0, N.jsxs)("span", {
                                        className: "me-1 text-nowrap",
                                        children: [(0, N.jsx)("img", {
                                            src: "https://".concat(C().APP_DOMAIN, "/animais/").concat(e.ref, ".webp"),
                                            width: 20
                                        }), " ", e.nome]
                                    }, "grupo-".concat(e.ref))
                                }))
                            })]
                        }), (0, N.jsxs)("div", {
                            className: "item d-flex align-items-baseline",
                            children: [(0, N.jsx)("div", {
                                className: "title font-weight-500 me-1",
                                children: "promocoes" === a.tipo_site ? "T\xedtulos:" : "Cotas:"
                            }), (0, N.jsxs)("div", {
                                className: "result font-xs",
                                "data-nosnippet": !0,
                                children: [0 == t.numeros.length && "Os t\xedtulos s\xe3o liberados ap\xf3s o pagamento", t.numeros.map((function(e) {
                                    return e.cota
                                })).join(", ")]
                            })]
                        })]
                    })
                })
            }

            function T() {
                return (0, N.jsxs)("div", {
                    className: "alert alert-danger mb-2 text-center font-xss",
                    children: [(0, N.jsx)("h4", {
                        children: "N\xe3o foi dessa vez... \ud83e\udd72"
                    }), (0, N.jsxs)("p", {
                        className: "font-xs mb-0",
                        children: ["Sua compra n\xe3o possui nenhum ", (0, N.jsx)("b", {
                            children: "t\xedtulo instant\xe2neo"
                        }), ", mas voc\xea ainda est\xe1 concorrendo ao pr\xeamio principal e tamb\xe9m pode ", (0, N.jsx)("b", {
                            children: "adquirir novos n\xfameros"
                        }), " e ", (0, N.jsx)("b", {
                            children: "aumentar suas chances"
                        }), "."]
                    })]
                })
            }

            function S(e) {
                var a = e.caixa,
                    t = e.hash,
                    n = e.color,
                    s = e.btnColor,
                    i = e.premiacoes,
                    r = e.concluido,
                    c = function(e) {
                        var a = e.color,
                            t = e.btnColor,
                            n = document.createElement("div");
                        n.id = "roleta-premiada--roda", n.className = "roleta-premiada--roda";
                        var s = document.createElement("div");
                        s.id = "wheelOfFortune";
                        var i = document.createElement("canvas");
                        i.id = "wheel", i.width = 350, i.height = 350;
                        var r = document.createElement("div");
                        r.id = "spin", r.text = "Girar", r.style.backgroundColor = t, r.style.color = a;
                        var o = document.createElement("audio");
                        return o.src = "/roleta.mp3", o.preload = !0, o.controls = !1, s.appendChild(o), s.appendChild(i), s.appendChild(r), n.appendChild(s), document.getElementsByTagName("body")[0].appendChild(n), {
                            roletaRoda: n,
                            spinEl: r,
                            ctx: i.getContext("2d"),
                            audioRoleta: function(e) {
                                return o.volume = .1, o.play(), setTimeout((function() {
                                    o.src = e ? "/roleta-ganhou.wav" : "/roleta-perdeu.wav", o.currentTime = 0, o.play()
                                }), 1e3 * o.duration), 1e3 * o.duration
                            }
                        }
                    }({
                        color: n,
                        btnColor: s
                    }),
                    l = c.roletaRoda,
                    d = c.spinEl,
                    m = c.audioRoleta,
                    u = c.ctx,
                    p = i.length,
                    x = u.canvas.width / 2,
                    h = Math.PI,
                    f = 2 * h,
                    v = (i.length, !1),
                    b = function() {
                        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : null;
                        return Math.floor(p - (null == e ? 0 : e) / f * p) % p
                    };

                function g() {
                    var e = i.length,
                        a = 2 * Math.PI / e;
                    i.forEach((function(e, t) {
                        var s = a * t;
                        u.save(), u.beginPath(), u.fillStyle = e.color, u.moveTo(x, x), u.arc(x, x, x, s, s + a), u.lineTo(x, x), u.fill(), u.translate(x, x), u.rotate(s + a / 2), u.textAlign = "right", u.fillStyle = n, u.font = 'bold 15px "Poppins", sans-serif', u.fillText(e.label, x - 10, 5), e.ang = a * t + a / 2, u.restore()
                    }))
                }
                g(), l.style.opacity = 1, l.style.scale = 1,
                    function() {
                        if (u.canvas.style.transform = "rotate(".concat(0 - h / 2, "rad)"), !i[b()]) return console.log(0);
                        d.textContent = "Girar", d.style.background = s
                    }(), d.addEventListener("click", (function() {
                        if (v) return null;
                        v = !0;
                        var e = i.findIndex((function(e) {
                            return e.hash == t
                        }));
                        e >= 0 && function(e, a, t) {
                            var n = 2 * Math.PI / i.length,
                                s = 2 * Math.PI - (n * e + n / 2),
                                r = 10 * Math.PI + s,
                                o = performance.now();
                            requestAnimationFrame((function e(n) {
                                var s = n - o,
                                    i = Math.min(s / a, 1),
                                    c = 0 + (1 - Math.pow(1 - i, 3)) * (r - 0);
                                u.clearRect(0, 0, 2 * x, 2 * x), u.save(), u.translate(x, x), u.rotate(c), u.translate(-x, -x), g(), u.restore(), i < 1 ? requestAnimationFrame(e) : t && t()
                            }))
                        }(e, m(!!t), (function() {
                            l.style.scale = 2.5, (0, o.Z)().get("/caixas-premiadas/abrir/".concat(a.token)).then((function(e) {
                                var a = e.data;
                                r(a.caixa), setTimeout((function() {
                                    l.style.opacity = 0, l.style.scale = .1, l.style.pointerEvents = "none", setTimeout((function() {
                                        l.remove()
                                    }), 1500)
                                }), 200)
                            })).catch((function(e) {
                                return window.location.reload()
                            }))
                        }))
                    }))
            }

            function I(e) {
                var a = e.caixa,
                    t = (0, u.useState)(a),
                    n = t[0],
                    s = t[1],
                    i = (0, u.useState)(!1),
                    r = i[0],
                    c = i[1],
                    l = n.aberta,
                    d = "roleta-premiada--item d-flex py-2 px-3 rounded-2\n                            mb-1 text-white text-center pointer\n                            ".concat(n.aberta ? n.premiada ? "bg-gradient-green" : "bg-gradient-pink" : "bg-gradient-cyan", "\n                            font-weight-600 justify-content-between");
                return (0, N.jsxs)(N.Fragment, {
                    children: [(0, N.jsxs)("div", {
                        className: d,
                        onClick: function() {
                            if (r || l) return null;
                            c(!0), (0, o.Z)().get("/caixas-premiadas/premiacoes/".concat(a.token)).then((function(e) {
                                var t = e.data,
                                    n = t.premiacoes;
                                S({
                                    caixa: a,
                                    hash: atob(t.hash).split(":")[1],
                                    premiacoes: n,
                                    color: t.color,
                                    btnColor: t.btn_color,
                                    concluido: function(e) {
                                        s(e)
                                    }
                                })
                            }))
                        },
                        children: [(0, N.jsxs)("span", {
                            children: [(0, N.jsx)("i", {
                                className: "bi bi-play-circle-fill"
                            }), " Giro de Roleta \ud83e\ude84"]
                        }), (0, N.jsx)("span", {
                            className: "badge text-bg-light bg-opacity-75 text-uppercase",
                            children: n.aberta ? n.premiada ? "Parab\xe9ns!" : "Aberta" : "Girar!"
                        })]
                    }), l && (0, N.jsxs)("div", {
                        className: "mb-2",
                        children: [n.premiada && (0, N.jsxs)("div", {
                            className: j().caixaPremio,
                            children: [(0, N.jsxs)("div", {
                                className: "mb-2 text-center",
                                children: [n.img && (0, N.jsx)("img", {
                                    id: "imgPremio",
                                    src: n.img,
                                    className: "img-fluid mb-2 " + j().imagem
                                }), n.descricao && (0, N.jsxs)("p", {
                                    className: "mb-1",
                                    children: ["Voc\xea ganhou ", (0, N.jsx)("b", {
                                        children: n.descricao
                                    }), " \ud83c\udf89"]
                                })]
                            }), (0, N.jsxs)("p", {
                                className: "mb-0 font-xs text-secondary text-center",
                                children: [(0, N.jsx)("b", {
                                    children: "Parab\xe9ns"
                                }), " por sua roleta premiada.", (0, N.jsx)("br", {}), "Em breve nossa equipe entrar\xe1 em contato."]
                            })]
                        }), !n.premiada && (0, N.jsx)(N.Fragment, {
                            children: (0, N.jsxs)("div", {
                                className: "row justify-content-center align-items-center py-2",
                                children: [(0, N.jsx)("div", {
                                    className: "col-auto pe-0",
                                    children: (0, N.jsx)("h1", {
                                        children: (0, N.jsx)("i", {
                                            className: "bi bi-emoji-frown text-danger"
                                        })
                                    })
                                }), (0, N.jsxs)("div", {
                                    className: "col-auto",
                                    children: [(0, N.jsx)("p", {
                                        className: "mb-1",
                                        children: "N\xe3o foi dessa vez"
                                    }), (0, N.jsxs)("p", {
                                        className: "font-xs",
                                        children: ["sua ", (0, N.jsx)("b", {
                                            children: "roleta n\xe3o premiou"
                                        })]
                                    })]
                                })]
                            })
                        })]
                    })]
                })
            }

            function F(e) {
                var a = e.compra.caixas.filter((function(e) {
                    return "roleta" == e.tipo
                }));
                return 0 == a.length ? null : (0, N.jsx)("div", {
                    className: "roleta-premiada",
                    children: (0, N.jsx)("div", {
                        className: "app-card card mb-2",
                        children: (0, N.jsx)("div", {
                            className: "card-body",
                            children: (0, N.jsxs)("div", {
                                className: "roleta-premiada--giros",
                                children: [(0, N.jsxs)("p", {
                                    className: "opacity-50 font-xs mb-1",
                                    children: ["Voc\xea tem (", a.length, ") giro", a.length > 0 && "(s)", a.length > 0 ? " dispon\xedveis" : " dispon\xedvel", ":"]
                                }), (0, N.jsx)("div", {
                                    className: "lista font-xs",
                                    children: a.map((function(e) {
                                        return (0, N.jsx)(I, {
                                            caixa: e
                                        }, e.token)
                                    }))
                                })]
                            })
                        })
                    })
                })
            }

            function A(e) {
                var a = e.compra,
                    t = e.setAcabou,
                    n = (0, u.useState)((new Date).getTime()),
                    s = n[0],
                    i = n[1],
                    r = new Date(a.insert).getTime(),
                    o = new Date(a.tempoPagamento.cTime).getTime(),
                    c = o > s ? o - s : 0,
                    l = 100 - 100 * c / (o - r);
                return (0, u.useEffect)((function() {
                    var e = setInterval((function() {
                        i((new Date).getTime()), 0 == c && (t(!0), clearInterval(e))
                    }), 300);
                    return function() {
                        clearInterval(e)
                    }
                }), []), (0, N.jsx)(N.Fragment, {
                    children: (0, N.jsx)("div", {
                        className: "pagamento-rapido",
                        children: (0, N.jsx)("div", {
                            className: "app-card card rounded-top rounded-0 shadow-none border-bottom",
                            children: (0, N.jsx)("div", {
                                className: "card-body",
                                children: (0, N.jsxs)("div", {
                                    className: "pagamento-rapido--progress",
                                    children: [(0, N.jsxs)("div", {
                                        className: "d-flex justify-content-center align-items-center mb-1 font-md",
                                        children: [(0, N.jsx)("div", {
                                            children: (0, N.jsx)("small", {
                                                children: "Voc\xea tem"
                                            })
                                        }), (0, N.jsx)("div", {
                                            className: "mx-1",
                                            children: (0, N.jsx)("b", {
                                                className: "font-md",
                                                children: (0, v.mr)(c / 1e3).replace("00:", "")
                                            })
                                        }), (0, N.jsx)("div", {
                                            children: (0, N.jsx)("small", {
                                                children: "para pagar"
                                            })
                                        })]
                                    }), (0, N.jsx)("div", {
                                        className: "progress bg-dark bg-opacity-50",
                                        children: (0, N.jsx)("div", {
                                            className: "progress-bar bg-danger",
                                            role: "progressbar",
                                            style: {
                                                width: l + "%"
                                            },
                                            "aria-valuenow": "0",
                                            "aria-valuemin": "0",
                                            "aria-valuemax": "100"
                                        })
                                    })]
                                })
                            })
                        })
                    })
                })
            }
            var q = !0;

            function Z(e) {
                var a, t, i = (0, u.useState)([]),
                    d = i[0],
                    g = i[1],
                    j = (0, u.useState)(e.compra),
                    y = j[0],
                    P = j[1],
                    C = (0, u.useState)(),
                    S = C[0],
                    I = C[1],
                    q = (0, u.useState)(),
                    Z = q[0],
                    M = q[1],
                    R = (0, u.useState)(!1),
                    B = R[0],
                    z = R[1],
                    O = ((null === y || void 0 === y ? void 0 : y.numeros.filter((function(e) {
                        return e.ganhou
                    }))) || []).length > 0,
                    D = (0, u.useState)(!!(null === y || void 0 === y || null === (a = y.status) || void 0 === a || !a.podePagar)),
                    L = D[0],
                    V = D[1],
                    G = e.app,
                    Q = e.lojista,
                    X = null !== Q && void 0 !== Q && Q.urlamigavel ? "/af/".concat(Q.urlamigavel, "/") : "/",
                    H = (0, u.useState)(!1),
                    J = H[0],
                    K = H[1],
                    $ = (0, u.useState)(null),
                    U = $[0],
                    Y = $[1],
                    W = (null === y || void 0 === y ? void 0 : y.numeros.filter((function(e) {
                        return e.numeroPremiado
                    }))) || [];

                function ee() {
                    return (ee = (0, s.Z)(r().mark((function e() {
                        return r().wrap((function(e) {
                            for (;;) switch (e.prev = e.next) {
                                case 0:
                                    if (m().isStarted()) {
                                        e.next = 5;
                                        break
                                    }
                                    return m().start(), e.next = 4, (0, o.Z)().get("/compra/consulta-pagamento/".concat(y.token)).then((function(e) {
                                        var a = e.data;
                                        P(a.compra)
                                    })).catch((function(e) {
                                        var a, t;
                                        alert((null === e || void 0 === e || null === (a = e.response) || void 0 === a || null === (t = a.data) || void 0 === t ? void 0 : t.message) || "N\xe3o foi poss\xedvel consultar o pagamento")
                                    }));
                                case 4:
                                    m().done();
                                case 5:
                                case "end":
                                    return e.stop()
                            }
                        }), e)
                    })))).apply(this, arguments)
                }

                function ae() {
                    return (ae = (0, s.Z)(r().mark((function e() {
                        var a;
                        return r().wrap((function(e) {
                            for (;;) switch (e.prev = e.next) {
                                case 0:
                                    if (J || !confirm("Conclu\xedr compra utilizando cr\xe9dito?")) {
                                        e.next = 19;
                                        break
                                    }
                                    return e.prev = 1, K(!0), m().start(), e.next = 6, (0, o.Z)().post("/compra/pagar-credito", {
                                        token: y.token
                                    }).then((function(e) {
                                        return e.data
                                    })).catch((function(e) {
                                        var a, t = e.response;
                                        throw new Error((null === t || void 0 === t || null === (a = t.data) || void 0 === a ? void 0 : a.message) || "N\xe3o foi poss\xedvel pagar com cr\xe9dito, tente novamente mais tarde")
                                    }));
                                case 6:
                                    if (1 === (a = e.sent).result) {
                                        e.next = 9;
                                        break
                                    }
                                    throw new Error(a.message);
                                case 9:
                                    P(a.compra), e.next = 15;
                                    break;
                                case 12:
                                    e.prev = 12, e.t0 = e.catch(1), alert(e.t0.message);
                                case 15:
                                    return e.prev = 15, m().done(), K(!1), e.finish(15);
                                case 19:
                                case "end":
                                    return e.stop()
                            }
                        }), e, null, [
                            [1, 12, 15, 19]
                        ])
                    })))).apply(this, arguments)
                }

                function te() {
                    return (te = (0, s.Z)(r().mark((function e(a) {
                        return r().wrap((function(e) {
                            for (;;) switch (e.prev = e.next) {
                                case 0:
                                    if (confirm("Tem certeza que deseja pagar com cart\xe3o?\n\nPIX \xe9 mais r\xe1pido, f\xe1cil e a libera\xe7\xe3o \xe9 imediata")) {
                                        e.next = 2;
                                        break
                                    }
                                    return e.abrupt("return", !1);
                                case 2:
                                    window.open(a + "?redirect=1", "_blank");
                                case 3:
                                case "end":
                                    return e.stop()
                            }
                        }), e)
                    })))).apply(this, arguments)
                }

                function ne(e) {
                    var a = e.metodo,
                        t = e.url;
                    switch (a) {
                        case "transferencia":
                            return function() {
                                var e = document.getElementById("modal-contas-bancarias"),
                                    a = bootstrap.Modal.getOrCreateInstance(e);
                                a && a.show()
                            }();
                        case "link-pagamento":
                            return function(e) {
                                return te.apply(this, arguments)
                            }(t);
                        case "credito":
                            return function() {
                                return ae.apply(this, arguments)
                            }();
                        default:
                            alert("M\xe9todo n\xe3o aplicado " + a)
                    }
                }

                function se() {
                    return ie.apply(this, arguments)
                }

                function ie() {
                    return (ie = (0, s.Z)(r().mark((function e() {
                        return r().wrap((function(e) {
                            for (;;) switch (e.prev = e.next) {
                                case 0:
                                    return e.next = 2, (0, o.Z)().get("/compra/pix/".concat(y.token), {
                                        timeout: 3e4
                                    }).then(function() {
                                        var e = (0, s.Z)(r().mark((function e(a) {
                                            var t, s, i;
                                            return r().wrap((function(e) {
                                                for (;;) switch (e.prev = e.next) {
                                                    case 0:
                                                        if (1 != (t = a.data).result) {
                                                            e.next = 9;
                                                            break
                                                        }
                                                        return (i = null === (s = t.pagamento) || void 0 === s ? void 0 : s.pix) && b.toDataURL(i.payload, (function(e, a) {
                                                            if (e) return console.log("QRCodeError", e);
                                                            M(a)
                                                        })), Y(t.pagamento), I(i), g(t.outros_metodos), f.Z.saldo().then((function(e) {
                                                            e >= y.total && g([{
                                                                metodo: "credito",
                                                                icone: "bi bi-lightning-charge",
                                                                descricao: "Pagar com cr\xe9dito",
                                                                taxa: 0,
                                                                valor: y.total,
                                                                total: y.total
                                                            }].concat((0, n.Z)(t.outros_metodos)))
                                                        })), e.abrupt("return", t.pagamento);
                                                    case 9:
                                                    case "end":
                                                        return e.stop()
                                                }
                                            }), e)
                                        })));
                                        return function(a) {
                                            return e.apply(this, arguments)
                                        }
                                    }()).catch((function(e) {
                                        e.response;
                                        return setTimeout((function() {
                                            se()
                                        }), 5e3), !1
                                    }));
                                case 2:
                                    return e.abrupt("return", e.sent);
                                case 3:
                                case "end":
                                    return e.stop()
                            }
                        }), e)
                    })))).apply(this, arguments)
                }
                return (0, u.useEffect)((function() {
                    var e = [];
                    if (y) {
                        var a, t = function() {
                                var e;
                                null === (e = window.sessionStorage) || void 0 === e || e.setItem(i, "notificado"), "function" === typeof window.gtag && (window.gtag("event", "purchaseFront", {
                                    affiliation: G.title,
                                    currency: "BRL",
                                    items: [{
                                        item_id: y.rifa.id,
                                        item_name: "T\xedtulo",
                                        coupon: null,
                                        discount: 0,
                                        price: y.valor,
                                        currency: "BRL",
                                        quantity: y.quantidade
                                    }],
                                    transaction_id: y.token,
                                    shipping: 0,
                                    value: y.total,
                                    tax: 0
                                }), console.log("purchaseFront gtag")), (0, v.Ko)("purchaseFrontFb", {
                                    value: y.valor,
                                    currency: "BRL",
                                    content_ids: y.rifa.id,
                                    num_items: y.quantidade,
                                    content_name: y.rifa.title,
                                    contents: [{
                                        id: y.rifa.id,
                                        name: "T\xedtulo",
                                        coupon: null,
                                        discount: 0,
                                        price: y.valor,
                                        quantity: y.quantidade
                                    }],
                                    content_type: "product"
                                })
                            },
                            n = function a() {
                                1 === y.status.id && (0, o.Z)().get("/compra/".concat(y.token), {
                                    timeout: 5e3
                                }).then((function(n) {
                                    var s = n.data;
                                    s.compra.status.id !== y.status.id ? (P(s.compra), 2 === s.compra.status.id && t()) : e.push(setTimeout(a, 6e4))
                                })).catch((function() {}))
                            },
                            i = "COMPRAGTAG:" + y.token;
                        2 != y.status.id || null !== (a = window.sessionStorage) && void 0 !== a && a.getItem(i) || setTimeout((function() {
                            t()
                        }), 1700), "undefined" !== typeof window.fbq && window.fbq("track", "Lead"), (0, v.Ko)("ViewContent", {
                            currency: "BRL",
                            content_ids: y.rifa.id,
                            content_name: y.rifa.title,
                            content_type: "product",
                            value: y.rifa.valor
                        }), 1 === y.status.id && (0, s.Z)(r().mark((function a() {
                            return r().wrap((function(a) {
                                for (;;) switch (a.prev = a.next) {
                                    case 0:
                                        return a.next = 2, se();
                                    case 2:
                                        a.sent && (e.push(setTimeout(n, 25e3)), e.push(setTimeout((function() {
                                            z(!0)
                                        }), 6e4)));
                                    case 4:
                                    case "end":
                                        return a.stop()
                                }
                            }), a)
                        })))()
                    }
                    return function() {
                        e.forEach((function(e) {
                            return clearInterval(e)
                        }))
                    }
                }), []), y ? (0, N.jsxs)(c.Z, {
                    app: G,
                    lojista: Q,
                    versao: G.versao_site ? G.versao_site : "v1",
                    bgHeader: "v2" == G.versao_site,
                    children: [G.contas_bancarias && (0, N.jsx)(p.Z, {
                        compra: y
                    }), (0, N.jsxs)("div", {
                        className: "app-main container",
                        children: [(0, N.jsxs)("div", {
                            className: ["compra-status compra-status-"] + y.status.class,
                            children: [(0, N.jsxs)("div", {
                                className: "app-alerta-msg mb-2",
                                children: [(0, N.jsx)("i", {
                                    className: ["app-alerta-msg--icone bi bi-check-circle text-"] + y.status.class
                                }), (0, N.jsxs)("div", {
                                    className: "app-alerta-msg--txt",
                                    children: [(0, N.jsxs)("h3", {
                                        className: "app-alerta-msg--titulo",
                                        children: [1 === y.status.id && L ? "Em an\xe1lise" : y.status.title, "!"]
                                    }), (0, N.jsx)("p", {
                                        children: 1 === y.status.id && L ? "Seu pagamento ser\xe1 analisado" : {
                                            0: "Sua compra foi recusada.",
                                            1: "Finalize o pagamento",
                                            2: "Agora \xe9 s\xf3 torcer!"
                                        }[y.status.id]
                                    })]
                                })]
                            }), (0, N.jsx)("hr", {
                                className: "my-2"
                            })]
                        }), y.rifa.aviso && (0, N.jsx)(N.Fragment, {
                            children: (0, N.jsx)("div", {
                                className: "alert alert-info p-2 font-xss mb-2",
                                dangerouslySetInnerHTML: {
                                    __html: y.rifa.aviso.replace(/\n/g, "</br>")
                                }
                            })
                        }), O && (0, N.jsx)(k, {}), 1 == y.status.id && !L && (0, N.jsx)(N.Fragment, {
                            children: U ? (0, N.jsxs)("div", {
                                className: "compra-pagamento",
                                children: [(0, N.jsxs)("div", {
                                    className: "pagamentoQrCode text-center",
                                    children: [(0, N.jsx)(A, {
                                        compra: y,
                                        setAcabou: V
                                    }), S && (0, N.jsx)("div", {
                                        className: "app-card card rounded-bottom rounded-0 rounded-bottom b-1 border-dark mb-2",
                                        children: (0, N.jsxs)("div", {
                                            className: "card-body",
                                            children: [(0, N.jsxs)("div", {
                                                className: "row justify-content-center mb-2",
                                                children: [(0, N.jsxs)("div", {
                                                    className: "col-12 text-start",
                                                    children: [(0, N.jsxs)("div", {
                                                        className: "mb-1",
                                                        children: [(0, N.jsx)("span", {
                                                            className: "badge bg-success badge-xs",
                                                            children: "1"
                                                        }), (0, N.jsx)("span", {
                                                            className: "font-xs",
                                                            children: " Copie o c\xf3digo PIX abaixo."
                                                        })]
                                                    }), (0, N.jsxs)("div", {
                                                        className: "input-group mb-2",
                                                        children: [(0, N.jsx)("input", {
                                                            type: "text",
                                                            defaultValue: S.payload,
                                                            className: "form-control",
                                                            readOnly: !0,
                                                            onFocus: function(e) {
                                                                return e.target.select()
                                                            }
                                                        }), (0, N.jsx)("div", {
                                                            className: "input-group-append",
                                                            children: (0, N.jsx)("button", {
                                                                className: "app-btn btn btn-success rounded-0 rounded-end",
                                                                onClick: function() {
                                                                    if (S) {
                                                                        var e = null === S || void 0 === S ? void 0 : S.payload;
                                                                        e ? ((0, l.vQ)(e), alert("C\xf3digo copiado com sucesso"), (0, v.Ko)("pixCopiado", {
                                                                            content_ids: [y.rifa.id],
                                                                            num_items: y.quantidade,
                                                                            currency: "BRL",
                                                                            value: y.valor
                                                                        })) : alert("N\xe3o foi gerado o c\xf3digo do pagamento")
                                                                    }
                                                                },
                                                                children: "Copiar"
                                                            })
                                                        })]
                                                    }), (0, N.jsxs)("div", {
                                                        className: "mb-2",
                                                        children: [(0, N.jsx)("span", {
                                                            className: "badge bg-success",
                                                            children: "2"
                                                        }), " ", (0, N.jsx)("span", {
                                                            className: "font-xs",
                                                            children: "Abra o app do seu banco e escolha a op\xe7\xe3o PIX, como se fosse fazer uma transfer\xeancia."
                                                        })]
                                                    }), (0, N.jsxs)("p", {
                                                        children: [(0, N.jsx)("span", {
                                                            className: "badge bg-success",
                                                            children: "3"
                                                        }), " ", (0, N.jsx)("span", {
                                                            className: "font-xs",
                                                            children: "Selecione a op\xe7\xe3o PIX c\xf3pia e cola, cole a chave copiada e confirme o pagamento."
                                                        })]
                                                    })]
                                                }), (0, N.jsx)("div", {
                                                    className: "col-12 my-2",
                                                    children: (0, N.jsx)("p", {
                                                        className: "alert alert-warning p-2 font-xss",
                                                        style: {
                                                            textAlign: "justify"
                                                        },
                                                        children: "Este pagamento s\xf3 pode ser realizado dentro do tempo, ap\xf3s este per\xedodo, caso o pagamento n\xe3o for confirmado os n\xfameros voltam a ficar dispon\xedveis."
                                                    })
                                                }), (0, N.jsx)("div", {
                                                    className: "col-12",
                                                    children: (0, N.jsxs)("button", {
                                                        className: "app-btn btn btn-success btn-sm",
                                                        disabled: !B,
                                                        onClick: function() {
                                                            return function() {
                                                                return ee.apply(this, arguments)
                                                            }()
                                                        },
                                                        children: [(0, N.jsx)("i", {
                                                            className: "bi bi-check-all"
                                                        }), " J\xe1 fiz o pagamento"]
                                                    })
                                                })]
                                            }), (0, N.jsx)("hr", {}), (0, N.jsxs)("div", {
                                                className: "row justify-content-center",
                                                children: [(0, N.jsx)("div", {
                                                    className: "col-8",
                                                    children: (0, N.jsx)("div", {
                                                        className: "d-block text-center",
                                                        children: (0, N.jsx)("div", {
                                                            id: "img-qrcode",
                                                            className: "d-inline-block bg-white rounded",
                                                            children: Z && (0, N.jsx)("img", {
                                                                src: Z,
                                                                className: "img-fluid"
                                                            })
                                                        })
                                                    })
                                                }), (0, N.jsx)("div", {
                                                    className: "col-12 pb-3",
                                                    children: (0, N.jsxs)("div", {
                                                        className: "font-xss",
                                                        children: [(0, N.jsxs)("h5", {
                                                            children: [(0, N.jsx)("i", {
                                                                className: "bi bi-qr-code"
                                                            }), " QR Code"]
                                                        }), (0, N.jsx)("div", {
                                                            children: "Acesse o APP do seu banco e escolha a op\xe7\xe3o pagar com QR Code, escaneie o c\xf3digo ao lado e confirme o pagamento."
                                                        })]
                                                    })
                                                })]
                                            })]
                                        })
                                    }), (0, N.jsxs)("div", {
                                        className: "alert alert-info p-2 font-xss mb-2",
                                        children: [(0, N.jsx)("i", {
                                            className: "bi bi-info-circle"
                                        }), " Ap\xf3s o pagamento aguarde at\xe9 5 minutos para a confirma\xe7\xe3o, caso j\xe1 tenha efetuado o pagamento, clique no bot\xe3o ", (0, N.jsx)("b", {
                                            children: "J\xe1 fiz o pagamento"
                                        }), "."]
                                    }), (null === d || void 0 === d ? void 0 : d.length) > 0 && (0, N.jsxs)("div", {
                                        className: "list-group",
                                        children: [(0, N.jsx)("div", {
                                            className: "list-group-item bg-secondary text-white align-items-center",
                                            children: "Voc\xea tamb\xe9m pode pagar com"
                                        }), d.map((function(e, a) {
                                            return (0, N.jsxs)("div", {
                                                onClick: function() {
                                                    return ne(e)
                                                },
                                                className: "list-group-item d-flex justify-content-between align-items-center",
                                                children: [(0, N.jsxs)("span", {
                                                    className: "banco",
                                                    children: [(0, N.jsx)("i", {
                                                        className: e.icone
                                                    }), " ", e.descricao]
                                                }), (0, N.jsxs)("span", {
                                                    className: "badge bg-secondary rounded-pill",
                                                    children: ["R$ ", (0, l.bC)(e.total)]
                                                })]
                                            }, "outroMetodo-" + a)
                                        }))]
                                    })]
                                }), (0, N.jsx)("hr", {
                                    className: "my-2"
                                })]
                            }) : (0, N.jsx)(N.Fragment, {
                                children: (0, N.jsx)("div", {
                                    className: "app-card card mb-2",
                                    children: (0, N.jsx)("div", {
                                        className: "card-block",
                                        children: (0, N.jsxs)("div", {
                                            className: "py-4 font-weight-600 d-flex justify-content-center align-items-center",
                                            children: [(0, N.jsx)("div", {
                                                className: "text-success pe-3",
                                                children: (0, N.jsx)("span", {
                                                    className: "d-inline-block spin-animation font-lggg",
                                                    children: (0, N.jsx)("i", {
                                                        className: "bi bi-arrow-clockwise"
                                                    })
                                                })
                                            }), "Gerando QRCODE ", (0, N.jsx)("br", {}), " para pagamento..."]
                                        })
                                    })
                                })
                            })
                        }), (0, N.jsxs)("div", {
                            className: "detalhes-compra",
                            children: [y.ebook && (0, N.jsx)("div", {
                                className: ((null === (t = y.ebook) || void 0 === t ? void 0 : t.class) || "alert-primary") + " alert mb-2 pointer",
                                onClick: function() {
                                    window.open(y.ebook.url, "_blank")
                                },
                                children: (0, N.jsxs)("div", {
                                    className: "row align-items-center",
                                    children: [(0, N.jsx)("div", {
                                        className: "col-auto pe-1",
                                        children: (0, N.jsx)("i", {
                                            className: "bi bi-save font-lg"
                                        })
                                    }), (0, N.jsxs)("div", {
                                        className: "col",
                                        children: [(0, N.jsx)("div", {
                                            children: (0, N.jsx)("b", {
                                                children: y.ebook.title
                                            })
                                        }), (0, N.jsx)("small", {
                                            className: "font-xss",
                                            children: y.ebook.txt
                                        })]
                                    })]
                                })
                            }), (0, N.jsx)("div", {
                                className: "compra-sorteio mb-2",
                                children: (0, N.jsx)(x.Z, {
                                    app: G,
                                    sorteio: y.rifa
                                })
                            }), (0, N.jsx)(F, {
                                compra: y
                            }), (0, N.jsx)(w, {
                                compra: y
                            }), 0 == y.caixas.length && y.rifa.temTitulosPremiados && 2 == y.status.id && (0, N.jsx)(N.Fragment, {
                                children: W.length > 0 ? (0, N.jsx)(_, {
                                    titulosPremiados: W
                                }) : (0, N.jsx)(T, {})
                            }), (0, N.jsx)(E, {
                                app: G,
                                compra: y
                            }), (0, N.jsx)("div", {
                                className: "problems",
                                children: (0, N.jsx)(h.default, {
                                    href: "".concat(X, "contato"),
                                    children: (0, N.jsx)("a", {
                                        className: "font-xs text-muted",
                                        children: "Problemas com sua compra? clique aqui."
                                    })
                                })
                            })]
                        })]
                    })]
                }) : (0, N.jsx)(c.Z, {
                    app: G,
                    children: (0, N.jsxs)("div", {
                        className: "app-main container",
                        children: [(0, N.jsx)("div", {
                            className: "app-card card mb-3",
                            children: (0, N.jsx)("div", {
                                className: "card-body",
                                children: (0, N.jsxs)("div", {
                                    className: "alert alert-warning",
                                    children: [(0, N.jsx)("i", {
                                        className: "bi bi-exclamation-circle"
                                    }), " ", e.errMessage]
                                })
                            })
                        }), (0, N.jsx)(h.default, {
                            href: "/",
                            children: (0, N.jsx)("a", {
                                className: "btn btn-link text-decoration-none fw-normal w-100",
                                children: "Voltar a p\xe1gina inicial"
                            })
                        })]
                    })
                })
            }
        },
        7109: function(e, a, t) {
            "use strict";

            function n(e) {
                var a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 4;
                return e.toString().padStart(a, "0")
            }

            function s(e) {
                var a = document.createElement("textarea");
                a.innerText = e, document.body.appendChild(a), a.select(), document.execCommand("copy"), a.remove()
            }

            function i(e, a, t, n) {
                var s = parseFloat(e),
                    i = a;
                s = isFinite(+s) ? +s : 0;
                var r, o, c = "undefined" == typeof n ? "." : n,
                    l = "undefined" == typeof t ? "," : t,
                    d = (i = isFinite(+i) ? Math.abs(i) : 0) > 0 ? s.toFixed(i) : Math.round(s).toFixed(i),
                    m = Math.abs(s).toFixed(i);
                return m >= 1e3 ? (o = (r = m.split(/\D/))[0].length % 3 || 3, r[0] = d.slice(0, o + (s < 0)) + r[0].slice(o).replace(/(\d{3})/g, c + "$1"), d = r.join(l)) : d = d.replace(".", l), d
            }

            function r(e) {
                return i(e, 2, ",", ".")
            }
            t.d(a, {
                mO: function() {
                    return n
                },
                vQ: function() {
                    return s
                },
                AZ: function() {
                    return i
                },
                bC: function() {
                    return r
                }
            })
        },
        8218: function(e, a, t) {
            (window.__NEXT_P = window.__NEXT_P || []).push(["/compra/[token]", function() {
                return t(769)
            }])
        },
        6403: function(e) {
            e.exports = {
                compraAbrirCaixa: "caixaPremiada_compraAbrirCaixa___oOV-",
                imagem: "caixaPremiada_imagem__1HXTP",
                video: "caixaPremiada_video__3oQjY",
                caixaContent: "caixaPremiada_caixaContent__3Naie",
                caixaBtn: "caixaPremiada_caixaBtn__31sdh",
                caixaPremio: "caixaPremiada_caixaPremio__11Jtv"
            }
        }
    },
    function(e) {
        e.O(0, [5675, 2666, 6858, 9542, 9774, 2888, 179], (function() {
            return a = 8218, e(e.s = a);
            var a
        }));
        var a = e.O();
        _N_E = a
    }
]);