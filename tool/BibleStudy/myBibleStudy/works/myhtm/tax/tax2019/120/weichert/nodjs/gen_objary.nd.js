var fs = require("fs");
var path = require("path");

function date2std(dat) {
    var d = new Date(dat);
    var m = (d.getMonth() + 1);
    var m = m.toString().padStart(2, "0");
    var sda = d.getFullYear() + "-" + m + "-" + d.getDate().toString().padStart(2, "0");
    return sda;
}
var tabler = function (srcdir) {
    this.m_objary = [];
    this.m_srcDir = srcdir;
    this.m_docfile = ""
};
tabler.prototype.getPathfiles = function (srcpath) {
    return fs.readdirSync(srcpath).filter(function (file) {
        if ("." === file[0]) return false;
        return fs.statSync(srcpath + '/' + file).isFile();
    });
}
tabler.prototype.main = function () {
    this.gen();
    this.outp();
}
tabler.prototype.gen = function () {
    var srcdir = this.m_srcDir;
    var fary = this.getPathfiles(srcdir);
    this.m_str = "\n\n<div>\n";
    for (var i = 0; i < fary.length; i++) {
        var sfn = fary[i];
        var bas = path.parse(sfn);
        this.parse_fname(sfn);
    }
    this.m_str += "\n</div>\n";
}
tabler.prototype.outp = function () {
    ///////////////////////
    var srcfile = this.m_docfile;
    var str = JSON.stringify(this.m_objary, null, 4);
    fs.writeFileSync(srcfile, str, "utf8");
};
tabler.prototype.parse_fname = function (sfn) {
    var pos = sfn.indexOf("to");
    var dte = sfn.substr(0, pos);
    var obj = {
        "dat": dte,
        "std": date2std(dte),
        "des": "",
        "cat": "Weichert",
        "val": "0.0",
        "act": sfn
    };
    console.log(obj)
    this.m_objary.push(obj);
}


//var result = tidy(content, opts);

//fs.writeFileSync("o.htm",content,"utf8")
console.log("result");
var tab = new tabler();
tab.m_docfile = "weichert.json.js";
tab.m_srcDir = "../";
tab.main();