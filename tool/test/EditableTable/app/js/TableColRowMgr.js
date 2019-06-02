
$(document).ready(function(){

    

    $("table tr:eq(0) td:eq(0)").click(function(){
        InsertColAfter($("table")[0],0);
    });
    
});

function InsertColAfter(otbl, col){
    $(otbl).find("tr").each(function(i){
        $(this).find("td:eq("+col+")").after($("<td>-</td>"));
    });
}

var TableColRowMgr={

InsertColAfter:function(otbl, col){
    $(otbl).find("tr").each(function(i){
        $(this).find("td:eq("+col+")").after($("<td>-</td>"));
    });
},
SetTD:function(tab, objArr){
    for(var i=0;i<objArr.length;i++){
        var obj=objArr[i];
        var selectedTd=tab+" tr:eq("+obj.irow+") td:eq("+obj.icol+")";
        $(selectedTd).html(obj.txt).css("background-color",obj.bgc);     
    }
},
    
};