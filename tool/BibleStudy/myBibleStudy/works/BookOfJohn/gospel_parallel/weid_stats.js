$(document).ready(function(){ 
    

    var totPairs=$(".medium-8").size();
    console.log("totPairs="+totPairs);

    var medium8only=$(".medium-8").not(".header").size();
    console.log("medium8only="+medium8only);



    var totrow=$(".harmony-table-row").size();
    console.log("totrow="+totrow);

    var Totmedium8Only=$(".harmony-table-row").not('.header-row').size();
    console.log("Totmedium8Only="+Totmedium8Only);


});//