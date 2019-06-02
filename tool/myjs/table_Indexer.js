function index_col(){
	$("table").each(function(){
    	$(this).find("tbody tr").each(function(i,v){
    	    $(this).find("td:eq(0)").text(1+i);
    	});
	});
};


$(document).ready(function(){ 

    $("#indxer").click(function(){
        index_col();
    });



//////////////////////////////////////
// calc total of Column.
    $(".indexer_calc_total").click(function(){
    	console.log("indexer_calc_total");
    	var _Parent=$(this).parentUntil("table");
    	var totArr=[];
    	//init
    	$(this).find("td").each(function(iCol){
    		totArr[iCol]=0;
    	});
    	//cala
    	$(this).find("td").each(function(iCol){
	    	$(_Parent).find("tbody tr").each(function(){
	    		$(this).find("td").each(function(jcol){
	    			var txt=$(this).text().trim();
	    			var iva=parseInt(txt);
	    			totArr[jcol]+=iva;
	    		});
	    	});
    	});
    	// show
    	$(this).find("td").each(function(iCol){
    		$(this).text(totArr[iCol]);
    	});
    });
});//






