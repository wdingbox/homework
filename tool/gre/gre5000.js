
var gObjArr=[];
var WordObj=function(itemLine){
            var ln=$.trim(itemLine);
            var pos=ln.indexOf(" ");
            this.word=$.trim( ln.substr(0,pos) );
            var desc=$.trim( ln.substr(pos) );
            pos=desc.indexOf(".");
            this.wtype=desc.substr(0,pos);
            var desc2= $.trim(  desc.substr(1+pos) );
            pos=desc2.indexOf("|");
            desc=desc2;
            var tot=0,err=0;
            if(pos>0){
                desc = $.trim( desc2.substr(0,pos) );
                var statisticData = $.trim(  desc2.substr(1+pos) );
                var arrSta = statisticData.split(",");
                tot= parseInt( arrSta[0] );
                err= parseInt( arrSta[1] );
            }

            this.desc=desc2;
            this.tot= tot;
            this.err= err;
}
WordObj.prototype.getTds=function(i){
    var tr="";
    tr+="<td>" + i + "</td>";
    tr+="<td>" + this.word + "</td>";
    tr+="<td>" + this.wtype + "</td>";
    tr+="<td>" + this.desc + "</td>";
    tr+="<td>" + this.tot + "</td>";
    tr+="<td>" + this.err + "</td>";

    return tr;
}
WordObj.prototype.getTdsForScore=function(i, clr){
    var tr="";
    tr+="<td class='" + clr + "'>" + i + "</td>";
    tr+="<td>" + this.word + "</td>";
    tr+="<td>" + this.wtype + "</td>";
    tr+="<td>" + this.desc + "</td>";
    tr+="<td>" + this.tot + "</td>";
    tr+="<td>" + this.err + "</td>";
    return tr;
}

WordObj.prototype.getTxtLine=function(){
    var tr="";
    tr+=this.word + " ";
    tr+=this.wtype + " ";
    tr+=this.desc + " | ";
    tr+=this.tot + ",";
    tr+=this.err + "<br>";
    tr+="\n";
    return tr;
}



var Vocabulary=function(){
    this.WordObjArr=[];
    this.TestedIdArr=[];
};
Vocabulary.prototype.addWord=function(itemline){
    this.WordObjArr.push(new WordObj(itemline));
};
Vocabulary.prototype.getTable=function(){
    var stab="<table border='1'>";
    for(var i in this.WordObjArr){
        var wobj=this.WordObjArr[i];
        stab+="<tr>"+wobj.getTds(i)+"</tr>";
    }
    stab+="</table>";
    return stab;
};
Vocabulary.prototype.getHtml=function(){
    var stab="<html><body>\n";
    for(var i in this.WordObjArr){
        var wobj=this.WordObjArr[i];
        stab+=wobj.getTxtLine();
    }
    stab+="\n</body></html>";
    return stab;
};

Vocabulary.prototype.make_test=function(){
    var stab="";
    var iTarget = Math.floor(Math.random() * this.WordObjArr.length) + 1;
    this.targetWordIdx = iTarget;
    this.targetChoices = 0;
    this.TestedIdArr.push(iTarget);
    
    var targ = this.WordObjArr[iTarget];
    
    stab+="<h3>" + targ.word + "<h3/>";
    var arrChoices=[];
    var MAX_CHOICES=4;
    var iRand = Math.floor(Math.random() * MAX_CHOICES) ;
    var ss = targ.desc;
    arrChoices[iRand] = "<p id='"+iTarget+"' class='uChoice' onclick='uChoice("+iTarget+")'>" + ss +"</p>";
    
    for(var i=0; i<=MAX_CHOICES; i++){
        if( !!arrChoices[i] ) continue;
        var irand = Math.floor(Math.random() * this.WordObjArr.length) + 1;
        var ss=this.WordObjArr[irand].desc;
        arrChoices[i] = "<p id='"+irand+"' class='uChoice' onclick='uChoice("+irand+")'>" + ss +"</p>";
    }
    
    for(i in arrChoices){
        stab+="<p>" + arrChoices[i] + "<p/>";
    }
    return stab;
};
Vocabulary.prototype.make_1st_choice=function(iChoiceId){
    var ret="#00ff00";
    var targId = this.targetWordIdx;  

    if( targId != iChoiceId){//correct choice.
        ret="#ff0000";
    }    

    if( 0 === this.targetChoices ) {//make a record.
        this.WordObjArr[targId].last_test=1;
        if( targId != iChoiceId){//correct choice.
            this.WordObjArr[targId].err += 1;
            this.WordObjArr[targId].last_test=0;
        }
        this.WordObjArr[targId].tot += 1;
    }
    this.targetChoices ++;
    
    console.log(this.WordObjArr[targId].getTxtLine());

    return ret;
};
Vocabulary.prototype.make_scores=function(){
    var stab="<table border='1'>";
    var CorrectCount=0;
    for( i in this.TestedIdArr ) {//make a record.
        var id = this.TestedIdArr[i];
        var ow = this.WordObjArr[id];
        var clr="#ff0000";
        if(1===ow.last_test){
            clr="#00ff00";
            CorrectCount+=1;
        }
        stab +="<tr style='background-color:" + clr + ";'>";
        stab +=ow.getTds(i);
        stab +="</tr>"; 
    }
    stab+="</table>";
    
    var rate =100 * CorrectCount / this.TestedIdArr.length ;
    rate = ""+rate;
    rate = rate.substr(0,3);
    stab+="Score Rate (%) is "+rate;

    return stab;
};



var gVocabulary = new Vocabulary();


function uChoice(id){
    var ret = gVocabulary.make_1st_choice(id);
    $("#"+id).css("background-color",ret);
}



function loaddata(){
        var sp=$("#vacab").html();
        var arr=sp.split("<br>");
        //alert(arr.length);
 
        for(var i in arr){
            gVocabulary.addWord(arr[i]);
        }
}
$(function(){
//var jqxhr = $.get( "gre5k.txt", function(dat) {
//  alert( "success" );
//})
//  .done(function() {
//    alert( "second success" );
//  })
//  .fail(function() {
//    alert( "error" );
//  })
//  .always(function() {
//    alert( "finished" );
//  });

    $("#vacab").hide();
    loaddata();

    $("#hide").click(function(){
        $("#vacab").hide();
    });
    $("#none").click(function(){
        $("#vacab").css("display","none");
    });
    $("#run2table").click(function(){
        $("#out").html( gVocabulary.getTable() );
    });
    
    $("#test2out").click(function(){
        $("#out").html(" ");
        $("#out").append("<textarea id='txt'></textarea>");//
        $("#txt").val( gVocabulary.getHtml() );       
    });
    
    $("#maketest").click(function(){
        $("#out").html( gVocabulary.make_test() );
    });
    

    
    $("#makeScore").click(function(){
        $("#out").html( gVocabulary.make_scores() );
    });
    
});