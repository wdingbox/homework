$(function () {
    $("select").change(function(){
        var val=$(this).val();
        
        console.log(val);
        var url="./hgb/"+$(this).attr("bookidx")+"_"+val+".htm";
        window.open(url,"_blank")
    });
    
});