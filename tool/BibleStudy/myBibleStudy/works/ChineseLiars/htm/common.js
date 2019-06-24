
$(function(){
    $(".fullscreen").click(function(){
        var x = document.URL;
        window.open(x,"_blank");
    });
    
    $(".tonx").next().toggle();    
    $(".tonx").click(function(){
        $(this).next().toggle("slow");
    })
}); 