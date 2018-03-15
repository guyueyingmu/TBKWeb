! function () {
    var t = function () {
        return cookie.get.apply(t, arguments)
    }, e = t.utils = {
            isArray: Array.isArray || function (t) {
                return "[object Array]" === Object.prototype.toString.call(t)
            },
            isPlainObject: function (t) {
                return !!t && "[object Object]" === Object.prototype.toString.call(t)
            },
            toArray: function (t) {
                return Array.prototype.slice.call(t)
            },
            escape: function (t) {
                return String(t).replace(/[,;"\\=\s%]/g, function (t) {
                    return encodeURIComponent(t)
                })
            },
            retrieve: function (t, e) {
                return null == t ? e : t
            },
            parseToDate: function (t) {
                var e = "20" + t.substr(0, 2),
                    r = t.substr(2, 2) - 1,
                    a = t.substr(4, 2),
                    n = new Date(e, r, a);
                return n.getFullYear() == e && n.getMonth() == r && n.getDate() == a ? n : "invalid date"
            },
            parseToStr: function (t) {
                var e = new Date(t),
                    r = e.getFullYear(),
                    a = e.getMonth() < 10 ? "0" + e.getMonth() : e.getMonth(),
                    n = e.getDate() < 10 ? "0" + e.getDate() : e.getDate();
                return r + a + n
            }
        };
    t.defaults = {}, t.init = function (t) {
        var r = this.transformData(t),
            a = !1,
            n = $(".calendar-main"),
            i = new Date,
            s = new Date;
        s.setDate(1);
        var o = 1 - s.getDay();
        1 == o && (o = -6), s.setDate(o);
        for (var d =
            '<div class="h" style="border-radius: 4px 0 0 0">日 </div><div class="h">一</div><div class="h">二 </div><div class="h">三</div><div class="h">四</div><div class="h">五</div><div class="h" style="border-right: 0;border-radius: 0 4px 0 0;">六</div>',
                c = 1; 42 >= c && (36 != c || 0 != a); c++) {
            var l = s.getDate();
            1 == l && (a = !a);
            var u = "";
            if (a) {
                var v = e.parseToStr(s);
                u = '<div id="' + v + '" class="h2', r[l] && (u += " signed"), u += i.getDate() == l ? ' today"' : '"',
                    0 !== c && c % 7 == 0 && (u += ' style="border-right: 0px;" '), u += '><span class="day">' + l +
                    "</span></div>"
            } else u = '<div class="h2"></div>', 0 !== c && c % 7 == 0 && (u =
                    '<div class="h2" style="border-right: 0px;"></div>');
            d += u, s.setDate(1 + s.getDate())
        }
        n.html(d)
    }, t.transformData = function (t) {
        for (var r = [], a = new Date, n = 0; n < t.length; n++) {
            var i = e.parseToDate(t[n]);
            a.getMonth() == i.getMonth() && (r[i.getDate()] = t[n])
        }
        return r
    }, t.remove = function (t) {
        t = e.isArray(t) ? t : e.toArray(arguments);
        for (var r = 0, a = t.length; a > r; r++) this.set(t[r], "", -1);
        return this
    }, "function" == typeof define && define.amd ? define(function () {
        return t
    }) : "undefined" != typeof exports ? exports.calendar = t : window.calendar = t
}(document);

