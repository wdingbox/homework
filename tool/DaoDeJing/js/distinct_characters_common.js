
var distinct_characters_common_virtual=
["故","必","使","既","四","五","在","二","又","之","以","其","而","者","若","所","或","何","也","乃","然","三","如","甚","且","次","各","忽","奈","被","六","比","千","里","代"];


var distinct_characters_common_core=
["天","人","下","道","知","右","大","彼","善","除","要","生","物","民","不","能","自","常","夫","名","有","可","是","得","此","身","事","言","非","用","行","足","深","我","地","死","上","成","失","信","一","相","多","治","王","明","器","取","兵","同","居","守","久","去","心","敢","乎","利","小","已","病","和","子","先","神","古","至","母","出","作","百","中","正","希","容","日","重","主","果","恐","益","教","根","士","安","家","食","法","害","修","高","光","存","姓","保","十","味","患","清","公","少","全","反","救","早","亡","入","徒","服","奇","司","音","前","解","耶","水","退","白","目","今","命","太","海","真","直","立","本","好","老","合","往","建","尊","福","舍","腹","耳","口","田","首","新","文","孩","迷","散","割","哀","力","客","方","形","起","鬼","交","加","求","奉","受","己","外","堂","色","迎","通","妄","素","阿","怕","惑","周","字","迹","黑","官","棘","年","降","露","衣","平","定","丈","基","石","偷","晚","父","藏","走","遇","施","拔","祭","蛇","分","伏","流","坐","罪","免","末","土","推","怒","配","活","手","草","枯","伯","望"]
;

//<--script language='javascript' src=''></script-->
function Load_distinct_characters_common(){

    var suffix=[
    "Negative_Bu",
    "Negative_Wu",
    "Oxymoron_pair1",
    "Same",
    "Positive_You",
    ];

    function get_scrp(srcf){
        return "<"+"script language='javascript' src='./js/"+srcf+"'><"+"/"+"script"+">\n";
    }
    var nam="distinct_characters_common_";
    for(var i=0;i<suffix.length;i++){
        var fnam=nam+suffix[i]+".js";
        var jss=get_scrp(fnam);
        console.log(jss);
        $("head").append(jss);
    }
};
//autoload_CharGrpLenJs();
////////////
/////////////////////////////

$(document).ready(function(){ 
    $("#common").click(function(){
        $.each(distinct_characters_common_core,function(i,v){
            $("."+v).toggleClass("commoncore");
        });
    });
    $("#virtue").click(function(){
        $.each(distinct_characters_common_virtual,function(i,v){
            $("."+v).toggleClass("virutalchar");
        });
        $.each(distinct_ddj_virtue,function(i,v){
            $("."+v).toggleClass("virutalchar");
        });

    });

    $("#positive").click(function(){
        $.each(Oxymoron_pair1,function(k,v){
            $("."+k).toggleClass("virutalchar");
            $("."+v).toggleClass("commoncore");
        });

        $.each(juxteposition_pair1,function(k,v){
            $("."+k).toggleClass("virutalchar");
            $("."+v).toggleClass("commoncore");
        });

    });



    $("#pair").click(function(){
        var ar=$("#aout").text().split(",");
        if(ar.length <3) return;
        var p1=ar[0][0];
        var p2=ar[1][0];
        if(!p1 || !p2) return;

        delete ar[0];
        delete ar[1];
        $("#aout").text(ar.join(",").substr(2));
        
        
        var keys=Object.keys(Oxymoron_pair1);
        if(keys.indexOf(p1)>=0){
            p1+="+";
        }
        Oxymoron_pair1[p1]=p2;
        var s1p=JSON.stringify(Oxymoron_pair1,null,4);
        $("#txot").val(s1p);
    });
});




