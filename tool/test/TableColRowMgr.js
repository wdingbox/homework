
$(document).ready(function(){

    

    $("table tr:eq(0) td:eq(0)").click(function(){
        InsertColAfter($("table")[0],0);
    });
    
});

function InsertColAfter(otbl, idx){
    $(otbl).find("tr").each(function(i){
        $(this).find("td:eq("+idx+")").after($("<td>-</td>"));
    });
}