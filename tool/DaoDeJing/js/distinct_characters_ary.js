var distinct_characters=[];

//<--script language='javascript' src=''></script-->
function Load_distinct_characters(){
    function get_scrp(srcf){
        return "<"+"script language='javascript' src='./js/"+srcf+"'><"+"/"+"script"+">\n";
    }
    var nam="distinct_characters";
    var suffixar={"0":"DDJ","1":"Mat","2":"Mak","3":"Luk","4":"Jhn"};
    for(var i=0;i<=4;i++){
        var si=""+i;
        var fnam=nam+"_"+si+"_"+suffixar[si]+".js";
        var jss=get_scrp(fnam);
        console.log(jss);
        $("head").append(jss);
    }
};
//autoload_CharGrpLenJs();



var common_set=[];
function find_common_sets(i){
    var ar1=Object.keys(distinct_characters[i]);
    if( common_set && common_set==0){
        common_set=JSON.parse(JSON.stringify(ar1));
        return [];
    }
    var common_set2=JSON.parse(JSON.stringify(common_set));
    common_set=[];
    $.each(common_set2,function(i,v){
        if(ar1.indexOf(v)>=0){
            common_set.push(v);
        };
    });

    gen_tab(common_set);
};


function gen_tab(arr){
    var idx=0;
    var s="<div border='1'>";
    $.each(arr,function(i,v){
        var cls="";
        if(virtual_chars.indexOf(v)<0){
            s+="<a>"+(idx++)+"</a><a class='kwd'>"+v+"</a> ";
        }
    });
    s+="</div><hr><div><a class='hilit' >";
    s+=virtual_chars.join("</a><a class='hilit'>")+"</a></div>";
    s+=virtual_chars.length;
    $("#hout").html(s).find("a").bind("click",function(){
        $(this).toggleClass('hilit');
    });
};






var virtual_chars=
["故","必","使","既","右","四","五","彼","在","二","又","除","要","之","不","以","其","而","者","有","是","若","可","得","所","或","此","何","也","乃","然","三","非","如","甚","且","深","次","各","忽","奈","被","六","比","千","里","代"];








