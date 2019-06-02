
var UniqObjFreq=function(){
   this.uniqWordArr=[];
   this.uniqObjFreqArr=[];
   
   this.TotWords=0;
   this.TotCollections=0;
};
UniqObjFreq.prototype.collect_English_Words=function(sTxt){
    this.TotCollections++;
    var arr=sTxt.split(" ");
    for( var i=0; i<arr.length; i+=1) {
        var sword = arr[i];

		///////////////calc_check()//////
        var idx = this.uniqWordArr.indexOf(sword);
        if(idx<0){
            idx=this.uniqWordArr.length;//get last index for the size of array.
            this.uniqWordArr[idx]=sword;
            this.uniqObjFreqArr[idx]={Freq:0, key:sword };
        }
        this.uniqObjFreqArr[idx].Freq += 1;
        this.TotWords++;                   
    }
};
UniqObjFreq.prototype.collect_Chinese_Chars=function(sTxt){
    this.TotCollections++;
    for( var i=0; i<sTxt.length; i+=1) {
        var cc = sTxt[i];
        var chcod = cc.charCodeAt(0);
        //if(chcod<10000) continue;
        if(chcod < 19968 || chcod > 65110 ){
            continue;
        }
        var idx = this.uniqWordArr.indexOf(chcod);
        if(idx<0){
            idx=this.uniqWordArr.length;//get last index for the size of array.
            this.uniqWordArr[idx]=chcod;
            this.uniqObjFreqArr[idx]={Freq:0, key:chcod, zi:cc,};
        }
        this.uniqObjFreqArr[idx].Freq += 1;
        this.TotWords++;
                    
        //alert( cc + "=" + chcod );
    }
};
UniqObjFreq.prototype.collect_Hebrew_Chars=function(sTxt){
    this.TotCollections++;
    for( var i=0; i<sTxt.length; i+=1) {
        var sword = sTxt.charAt(i);
        var ccode = sword.charCodeAt(0);
		///////////////calc_check()//////
        var idx = this.uniqWordArr.indexOf(sword);
        if(idx<0){
            idx=this.uniqWordArr.length;//get last index for the size of array.
            this.uniqWordArr[idx]=sword;
            this.uniqObjFreqArr[idx]={Freq:0, key:sword, code:ccode };
        }
        this.uniqObjFreqArr[idx].Freq += 1;
        this.TotWords++;                   
    }
};
UniqObjFreq.prototype.collect_Hebrew_Individual_Words=function(sTxt){
    this.TotCollections++;
    //sTxt = sTxt.toLowerCase(); 
    sTxt=sTxt.replace("--", " ");
    sTxt=sTxt.replace(" -", " ");
    sTxt=sTxt.replace("- ", " ");
    var arr = sTxt.split(/[\s|\,|\.|\:|\;|\(|\)|\?|\!|\<|\>|\[|\]|\'|\"]/g);
    for( var i=0; i<arr.length; i+=1) {
        var sword2 = arr[i];
        //sword=$.trim(sword);
        //sword=sword.replace(/^\-+|\-+$/gm,'');
        //if($.isNumeric( sword )) continue;
 
        var sword='';
        for(var k=0;k<sword2.length;k++){
            var code=sword2.charCodeAt(k);
            if(code>=1488 && code<=1514){
                var ch=sword2.charAt(k);
                sword+=ch;
            }                
        }

        
        
        if(sword.length===0) continue;
		
		///////////////calc_check()//////
        var idx = this.uniqWordArr.indexOf(sword);
        if(idx<0){
            idx=this.uniqWordArr.length;//get last index for the size of array.
            this.uniqWordArr[idx]=sword;
            this.uniqObjFreqArr[idx]={key:sword, Freq:0};
        }
        this.uniqObjFreqArr[idx].Freq += 1;
        this.TotWords++;
                    
        //alert( cc + "=" + chcod );
    }
};
UniqObjFreq.prototype.getTHs=function(){
    var ths='';
    if(this.uniqObjFreqArr.length>0){
        var obj=this.uniqObjFreqArr[0];
        for(var key in obj){
            ths += "<th>"+key+"</th>";
        }
    }
    return ths;
};

var ObjArrSorter=function(objArr){
   this.objArr=objArr;
   this.sortedStrnArr=[];
   this.sout="";
};
ObjArrSorter.prototype.sort_key=function(sortKey){
    var len=this.objArr.length;
    if(undefined==len || len==0){
        return alert("obj arr empty");
    };
    var obj=this.objArr[0];
    if(undefined==obj[sortKey]){
        return alert("undefined key:"+sortKey);
    };
    for(var idx in this.objArr){
        var obj=this.objArr[idx];
        var sortk = ""+obj[sortKey];
        while(sortk.length<10){
            sortk=" "+sortk;
        }            
        for(var key in obj) {
            sortk +="_"+obj[key];
        }  
        this.sortedStrnArr.push(sortk);
    }
    this.sortedStrnArr.sort();//
    this.sortedStrnArr.reverse(); 
};



var ObjArr2Table=function(sortedStrnArr){
   this.sortedStrnArr=sortedStrnArr;
   this.sout="";
};
ObjArr2Table.prototype.show_table=function(keyTHs){
    var ths="<th>#</th><th>sorted</th>"+keyTHs;
    this.sout="<tr>"+ths+"</tr>";
    for(var idx in this.sortedStrnArr){
   
        this.sout+="<tr>";
        this.sout+=this.toTDs2(idx, this.sortedStrnArr[idx]);
        this.sout+="</tr>"; 
    }
    
    this.sout = "<table border='1' class='versTxt'>" + this.sout + "</table>";

};
ObjArr2Table.prototype.toTDs2=function(idx, sortedstrn){
    var arr = sortedstrn.split(/[_]/g);
	var sout="<td>"+idx+"</td>";
	for(var i=0;i<arr.length;i++){
		sout+="<td>"+arr[i]+"</td>";
	}
    return sout;	
};







var WordsFreq=function(){
   this.uniqObjFreq=new UniqObjFreq();
   this.objArrSorter=new ObjArrSorter(this.uniqObjFreq.uniqObjFreqArr);
   this.objArr2Table=new ObjArr2Table(this.objArrSorter.sortedStrnArr);
}
WordsFreq.prototype.getSortTable=function(key){
    this.objArrSorter.sort_key(key);
    this.objArr2Table.show_table(this.uniqObjFreq.getTHs());
    
    var nn="<hr/>TotWords="+this.uniqObjFreq.TotWords;
    nn+= "<br/>TotCollections="+this.uniqObjFreq.TotCollections;
    return this.objArr2Table.sout + nn;
};

















