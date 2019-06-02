

var DaoDeJingUti={
keyword2eng:function(v){
    var eng="";
    if(DaoDeJing_ChineseWangBi_FrqPhrase2[v] && DaoDeJing_ChineseWangBi_FrqPhrase2[v]["eng"]){
        //eng=DaoDeJing_ChineseWangBi_FrqPhrase2[v]["eng"];
    }
    if(DaoDeJing_ChineseWangBi_FrqZi[v] && DaoDeJing_ChineseWangBi_FrqZi[v]["eng"]){
        //eng=DaoDeJing_ChineseWangBi_FrqZi[v]["eng"];
    }
    if(DaoDeJing_ChineseWangBi_FrqPhrase111[v] && DaoDeJing_ChineseWangBi_FrqPhrase111[v]["eng"]){
        //eng=DaoDeJing_ChineseWangBi_FrqPhrase111[v]["eng"];
    }
    var dict=DaoDeJing_KeywordsThemes_EngBibDictionary[v];
    if(dict){
        eng=dict["eng"];
    }
    return eng; 
},

keywords2eng:function(keyarr){
    var ar=[];
    $.each(keyarr, function(i, key){
        var eng=DaoDeJingUti.keyword2eng(key);
        ar.push(eng);

    });
    return ar;
},


}
