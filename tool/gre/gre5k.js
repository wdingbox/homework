

var FreqCalc=function(){
   this.IndexCodeArr=[];
   this.UFchcodDatArr=[];
   this.sortedStrnArr=[];
   this.sout="";
   this.TotWords=0;
   this.NumOfCalc=0;
  
   this.htmlcodeStart="&#";
   this.htmlcodeEnd=";";
   
   this.ZhiWithoutTbi=[];
}
FreqCalc.prototype.SetLanguage=function(sLang){
    if("zh"===sLang){
        this.htmlcodeStart="&#";
        this.htmlcodeEnd=";";
    }
    else{
        this.htmlcodeStart="";
        this.htmlcodeEnd="";
    }
}
FreqCalc.prototype.calc_zh=function(sTxt){
    this.NumOfCalc++;
    for( var i=0; i<sTxt.length; i+=1) {
        var cc = sTxt[i];
        var chcod = cc.charCodeAt(0);
        //if(chcod<10000) continue;
        if(chcod < 19968 || chcod > 65110 ){
            continue;
        }
        var idx = this.IndexCodeArr.indexOf(chcod);
        if(idx<0){
            idx=this.IndexCodeArr.length;//get last index for the size of array.
            this.IndexCodeArr[idx]=chcod;
            this.UFchcodDatArr[idx]={key:chcod, RFrq:0};
        }
        this.UFchcodDatArr[idx].RFrq += 1;
        this.TotWords++;
                    
        //alert( cc + "=" + chcod );
    }
};
FreqCalc.prototype.calc_English=function(sTxt){
    this.NumOfCalc++;
    sTxt = sTxt.toLowerCase(); 
    var arr = sTxt.split(/\s|\,|\.|\:|\;|\(|\)|\?|\!|\<|\>|\[|\]|\'/g);
    for( var i=0; i<arr.length; i+=1) {
        var sword = arr[i];
        if(sword.length===0) continue;
        var idx = this.IndexCodeArr.indexOf(sword);
        if(idx<0){
            idx=this.IndexCodeArr.length;//get last index for the size of array.
            this.IndexCodeArr[idx]=sword;
            this.UFchcodDatArr[idx]={key:sword, RFrq:0};
        }
        this.UFchcodDatArr[idx].RFrq += 1;
        this.TotWords++;
                    
        //alert( cc + "=" + chcod );
    }
};
FreqCalc.prototype.sort_freq=function(){
    for(var idx in this.UFchcodDatArr){
        var freq = ""+this.UFchcodDatArr[idx].RFrq;               
        var ccod = this.UFchcodDatArr[idx].key;
        
        while(freq.length<10){
            freq="0"+freq;
        }        
        var str=freq+"_"+ccod;
        this.sortedStrnArr.push(str);
    }
    this.sortedStrnArr.sort();//
    this.sortedStrnArr.reverse(); 
}
FreqCalc.prototype.toTable=function(){
    this.sout="<tr><td>#</td><td>code</td><td>tbi</td><td>word</td><td>freq</td></tr>";
    for(var idx in this.sortedStrnArr){
   
        this.sout+="<tr>";
        this.sout+=this.toTDs(idx, this.sortedStrnArr[idx]);
        this.sout+="</tr>"; 
    }
    
    this.sout = "<table border='1' class='versTxt'>" + this.sout + "</table>";
    this.sout+="<br>TotWords="+this.TotWords;
    this.sout+="<br>NumOfCalc="+this.NumOfCalc;
}

FreqCalc.prototype.toTableJoin=function(sorted2){
    this.sout="<tr><td>#</td><td>code</td><td>tbi</td><td>word</td><td>freq</td></tr>";
    for(var idx=0; idx< (this.sortedStrnArr.length || idx<sorted2.length); idx++){
        var sortedStrn1="";
        if(idx< (this.sortedStrnArr.length)){
            sortedStrn1 = this.sortedStrnArr[idx];
        }
        var sortedStrn2="";
        if(idx< (sorted2.length)){
            sortedStrn2 = sorted2[idx];
        }
        
        this.sout+="<tr>";
        this.sout+=this.toTDs(idx, sortedStrn1);
        this.sout+=this.toTDs(idx, sortedStrn2);
        this.sout+="</tr>"; 
    }
    
    this.sout = "<table border='1' class='versTxt'>" + this.sout + "</table>";
    this.sout+="<br>TotWords="+this.TotWords;
    this.sout+="<br>NumOfCalc="+this.NumOfCalc;
}
FreqCalc.prototype.toTDs=function(idx, sortedstrn){
    var arr = sortedstrn.split(/[_]/g);
    var freq = arr[0];              
    var ccod = arr[1];

    var cch = String.fromCharCode( ccod );// this.htmlcodeStart+ccod+this.htmlcodeEnd;
    var tbi = "";//z2g_translate2jiaguwen( cch );
    
    //if(tbi.length<3){//no tbi found.
        //this.ZhiWithoutTbi.push("_"+ccod+"=',',//"+cch);
        //console.log("tbi:"+tbi+tbi.length+","+this.ZhiWithoutTbi.length);
    //}
    
    
    var sout="";
    sout+="<td>"+idx+"</td>";
    sout+="<td>"+ccod+"</td>";
    sout+="<td>"+tbi+"</td>";
    sout+="<td>"+cch+"</td>";
    sout+="<td>"+parseInt(freq,10)+"</td>";
    return sout;
}
FreqCalc.prototype.ZhiWithoutTbi_show=function(){
    console.log("ZhiWithoutTbi:"+this.ZhiWithoutTbi.length);
    var sss="<hr/>ZhiWithoutTbi<br/>";
    for(var i=0;i<this.ZhiWithoutTbi.length;i++){
        sss+="Z."+this.ZhiWithoutTbi[i]+"<br/>";
    }
    sss+="<hr/>";
    return sss;
}




var WordObj=function(itemLine){
            var ln=$.trim(itemLine);
            if(ln.length===0) return;
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


//////////////////////////////////////

var Vocabulary=function(){
    this.WordObjArr=[];
    this.QuizIdArr=[];
    this.TimeStart=new Date();
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
Vocabulary.prototype.getPrintingTxt=function(){
    var stab="\n";
    for(var i in this.WordObjArr){
        var wobj=this.WordObjArr[i];
        stab+=wobj.getTxtLine();
    }
    stab+="\n";
    return stab;
};

Vocabulary.prototype.make_a_quiz=function(){
    var stab="";
    var iTarget = Math.floor(Math.random() * this.WordObjArr.length) + 1;
    this.targetWordIdx = iTarget;
    this.targetChoices = 0;
    this.QuizIdArr.push(iTarget);
    
    var targ = this.WordObjArr[iTarget];
    
    stab+="<h3>" + targ.word + "<h3/>";
    var arrChoices=[];
    var MAX_CHOICES=2;
    var iRand = Math.floor(Math.random() * (1+MAX_CHOICES)) ;
    console.log("iRand="+iRand);
    var ss = targ.desc;
    var wd = targ.word;
    arrChoices[iRand] = "<p id='"+iTarget+"' word='"+wd+"' onclick='uChoice("+iTarget+")'>" + ss +"</p>";
    
    for(var i=0; i<=MAX_CHOICES; i++){
        if( !!arrChoices[i] ) continue;
        var irand = Math.floor(Math.random() * this.WordObjArr.length) + 1;
        var ss=this.WordObjArr[irand].desc;
        var wd=this.WordObjArr[irand].word;
        arrChoices[i] = "<p id='"+irand+"' word='"+wd+"' onclick='uChoice("+irand+")'>" + ss +"</p>";
    }
    stab+="<ol>";
    for(i in arrChoices){
        stab+="<li><p>" + arrChoices[i] + "<p/></li>";
    }
    stab+="</ol>"
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
    var timeEnd = new Date(); //pastDate.toString('days-hours-minutes-seconds');
    var timespan= Math.floor((timeEnd - this.TimeStart)/1000);
    var speed = Math.floor( timespan / this.QuizIdArr.length );
    var Cap = " Avg Time Per Question(s):"+speed;
    
    var stab="<table border='1'>";
    var CorrectCount=0;
    for( i in this.QuizIdArr ) {//make a record.
        var id = this.QuizIdArr[i];
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
    
    var rate =100 * CorrectCount / this.QuizIdArr.length ;
    rate = ""+rate;
    rate = rate.substr(0,3);
    
    Cap ="Score Rate (%) is "+rate + "," + Cap;
    

    return Cap+stab;
};
Vocabulary.prototype.all_descr=function(){
    var stab="";
    for( id in this.WordObjArr ) {//make a record.
        var ow = this.WordObjArr[id];
        stab += " " + ow.desc;        
    }
    return stab;
};


var gVocabulary = new Vocabulary();


function uChoice(id){
    var ret = gVocabulary.make_1st_choice(id);
    $("#"+id).css("background-color",ret);
    var wd = $("#"+id).attr("word");
    $("#"+id).attr("title", wd);
}



function loaddata(){
        var sp=$("#vacab").html();
        var arr=sp.split("<br>");
        //alert(arr.length);
 
        for(var i in arr){
            var str = $.trim(arr[i]);
            if(str.length>0){
               gVocabulary.addWord(str);
            }
        }
}
function makeaquiz(){
        $("#out").html( gVocabulary.make_a_quiz() );
        $("#quizInfo").text("question:#"+gVocabulary.QuizIdArr.length);
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
    
    setInterval(function(){
       var dt = new Date();
       var tms = Math.floor((dt - gVocabulary.TimeStart)/1000);
       
       $("#tm").text("time(s):"+tms.toString()); 
    }, 1000);
    
    $("#vacab").hide();
    loaddata();
    makeaquiz();

    $("#hide").click(function(){
        $("#vacab").hide();
    });
    $("#none").click(function(){
        $("#vacab").css("display","none");
    });
    
    $("#run2table").click(function(){
        $("#out2").html( gVocabulary.getTable() );
    });
    
    $("#test2out").click(function(){
        $("#out2").html(" ");
        $("#out2").append("<textarea id='txt'></textarea>");//
        $("#txt").val( gVocabulary.getPrintingTxt() );       
    });
    
    $("#makequiz").click(function(){
        makeaquiz();
    });
    

    
    $("#makeScore").click(function(){
        $("#out2").html( gVocabulary.make_scores() );
    });
    
    $("#descWFrq").click(function(){
        var oFreqCalc = new FreqCalc();
        oFreqCalc.SetLanguage("Eng");
        oFreqCalc.calc_English(gVocabulary.all_descr());
        oFreqCalc.sort_freq();
        oFreqCalc.toTable();
        
        $("#out2").html(  oFreqCalc.sout );
    });
    
});