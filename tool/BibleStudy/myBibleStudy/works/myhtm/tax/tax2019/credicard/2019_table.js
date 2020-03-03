function date2std(dat) {
    var d = new Date(dat);
    var m = (d.getMonth() + 1);
    var m = m.toString().padStart(2, "0");
    var sda = d.getFullYear() + "-" + m + "-" + d.getDate().toString().padStart(2, "0");
    return sda;
}
function init_dat_fr_raw_tab() {
    var ary = [];
    $("#tab2019 tbody tr").each(function () {
        var obj = {};
        obj.dat = $(this).find("td:eq(0)").text().trim().replace(/(\s+)/g, " ");
        obj.std = date2std(obj.dat);
        obj.des = $(this).find("td:eq(1)").text().trim().split("\n")[0].replace(/(\s+)/g, " ").trim();
        obj.cat = $(this).find("td:eq(2)").text().trim().replace(/(\s+)/g, " ");
        obj.val = $(this).find("td:eq(3)").text().trim().replace(/(\s+)/g, " ");
        obj.act = $(this).find("td:eq(4)").text().trim().replace(/(\s+)/g, " ");
        obj.Note1 = "";
        obj.Note2 = "";
        ary.push(obj);
        console.log(obj.std);
    });
    $("#out").val("var datary=\n" + JSON.stringify(ary, null, 4));
}
function gen_tab(ar) {
    function get_tr(obj) {
        var trs = "<tr><td></td>";
        var ths = "<tr><th>#</th>";
        Object.keys(obj).forEach(function (key, i) {
            var val = obj[key];
            if (0 === 1) {
                trs += `<td>${i}</td>`;
                ths += "<th>#</th>"
            }
            var san = val;
            if (san.match(/[\.][a-zA-Z]{2,}$/)) {
                san = `<a href="${val}">${val}</a>`
            }
            trs += `<td key='${key}'>${san}</td>`;
            ths += `<th>${key}</th>`;
        })
        //trs += "<td contenteditable></td><td contenteditable></td></tr>";
        //ths += "<th>Notes</th><th>Notes2</th></tr>"
        return { trs: trs, ths: ths };
    }
    var trs = "";
    for (var i = 0; i < ar.length; i++) {
        var obj = ar[i];
        trs += get_tr(obj).trs;
    }
    var stb = `<table border='1'><caption>tb</caption><thead>${get_tr(ar[0]).ths}</thead>`;
    stb += `<tbody>${trs}</tbody><tfoot>${get_tr(ar[0]).ths}</tfoot></body>`;
    $("body").append(stb).find("tfoot tr").find("th").bind("click", function () {
        var idx = $(this).index();
        var tot = 0;
        $(this).parentsUntil("table").prev().find("tr").each(function () {
            $(this).find(`td:eq(${idx})`).addClass("hili");
            var val = $(this).find(`td:eq(${idx})`).text();//.replace("$", "");
            if (!val) val = 0;
            var fva = parseFloat(val);
            tot += fva;
        });
        $(this).text(tot.toFixed(2));
    });
    table_sort();

    $("td").bind("click", function () {
        $(this).toggleClass("hili");
        if ($(this).find("a[href]").length === 0) {
            $(this).attr("contenteditable", true);
        }
        if($(this).index()===0){
            $(this).parentsUntil("tbody").clone(true).insertAfter($(this).parent());
        }
    });
    $("table caption").bind("click", function () {
        var ojary = []
        $(this).parent().find("tbody").find("tr").each(function () {
            var obj = {}
            $(this).find("td[key]").each(function (i) {
                var key = $(this).attr("key");
                var val = $(this).text();
                obj[key] = val;
            });
            ojary.push(obj);
        });
        $("#out").val("var a=\n" + JSON.stringify(ojary, null, 4));
    });
}
function tab2datary() {
    var kobj = {};
    $("table thead tr").find("th").each(function (i) {
        var tx = $(this).text();
        kobj[i] = tx;
    });

    function tr2obj(etr) {
        var obj = {};
        $(etr).find("td").each(function (i) {
            var key = kobj[i];
            obj[key] = $(this).text().trim();
        });
        return obj;
    }
    var datary = [];
    $("table tbody tr").each(function (i) {
        var obj = tr2obj(this);
        datary.push(obj);
    });

    $("#out").val("var datary=\n" + JSON.stringify(datary, null, 4));

}