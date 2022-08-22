($.fn.dataTable.pipeline = function (a) {
    var b = $.extend({ pages: 5, url: "", data: null, method: "GET" }, a),
        c = -1,
        d = null,
        e = null,
        f = null;
    return function (a, l, j) {
        var i = !1,
            g = a.start,
            m = a.start,
            h = a.length;
        if (
            (j.clearCache
                ? ((i = !0), (j.clearCache = !1))
                : c < 0 || g < c || g + h > d
                ? (i = !0)
                : (JSON.stringify(a.order) !== JSON.stringify(e.order) ||
                      JSON.stringify(a.columns) !== JSON.stringify(e.columns) ||
                      JSON.stringify(a.search) !== JSON.stringify(e.search)) &&
                  (i = !0),
            (e = $.extend(!0, {}, a)),
            i)
        ) {
            if (
                (g < c && (g -= h * (b.pages - 1)) < 0 && (g = 0),
                (c = g),
                (d = g + h * b.pages),
                (a.start = g),
                (a.length = h * b.pages),
                "function" == typeof b.data)
            ) {
                var k = b.data(a);
                k && $.extend(a, k);
            } else $.isPlainObject(b.data) && $.extend(a, b.data);
            j.jqXHR = $.ajax({
                type: b.method,
                url: b.url,
                data: a,
                dataType: "json",
                cache: !1,
                success: function (a) {
                    (f = $.extend(!0, {}, a)),
                        c != m && a.data.splice(0, m - c),
                        h >= -1 && a.data.splice(h, a.data.length),
                        l(a);
                },
            });
        } else
            ((json = $.extend(!0, {}, f)).draw = a.draw),
                json.data.splice(0, g - c),
                json.data.splice(h, json.data.length),
                l(json);
    };
}),
    $.fn.dataTable.Api.register("clearPipeline()", function () {
        return this.iterator("table", function (a) {
            a.clearCache = !0;
        });
    });
