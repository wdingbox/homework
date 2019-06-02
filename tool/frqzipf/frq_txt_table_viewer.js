

function Calc_Comparison(chkColAry, iTabCol, sRange, iCmpSize){
  $("#vbibtxt").find("tbody td").removeClass("hilit");
  var iRange=0;
  if (!$.isNumeric(sRange)){
    //console.log("not a number");
  }
  else{
    iRange=parseInt(sRange);
  }
  console.log(iRange);


  function _____get_wordsAry(chkColAry, iTabCol, iCmpSize){
    var wordsAry=[], ichkCol=iTabCol-1;
    var seledKey=chkColAry[ichkCol];
    //console.log("seledKey="+seledKey);
    for(var i=0;i<iCmpSize;i++){
      var frqKeyAry=FRQ_WORD_DICT[seledKey][i];
      wordsAry.push(frqKeyAry[1]);
      //console.log(i,frqKeyAry);
    };  
    return wordsAry;
  };
  function _____search_word_in_dic_col_in_range(chkColAry, iChekCol, iRange, iTargetIdx,sTargetWordsAry){
    var wordsAry=[];
    var seledKey=chkColAry[iChekCol];
    //console.log("seledKey="+seledKey);
    var istart=iTargetIdx-iRange;
    if(istart<0) istart=0;
    var iend=iTargetIdx+iRange;

    for(var i=istart;i<=iend;i++){
      var frqKeyAry=FRQ_WORD_DICT[seledKey][i];
      var swrd=frqKeyAry[1];
      if(swrd===sTargetWordsAry[iTargetIdx]){
        var iTabRow=i;
        var std="tbody tr:eq("+i+") td:eq("+ iChekCol +")";
        $("#vbibtxt").find(std).addClass("hilit");
        return 1;
      }
    };  
    return 0;
  };

  function _____get_tot_found_dic_in_col(chkColAry, chkCol, iRange, sTargetWordsAry){
    var itot=0;
    for(var i=0;i<sTargetWordsAry.length;i++){
      itot+=_____search_word_in_dic_col_in_range(chkColAry, chkCol, iRange,i,sTargetWordsAry);
    };
    return itot;
  };


  var wordsSelAry=_____get_wordsAry(chkColAry, iTabCol, iCmpSize);

  for(var ichkCol=0;ichkCol<chkColAry.length;ichkCol++){
    if(iTabCol==ichkCol+1) continue;
    var itot=_____get_tot_found_dic_in_col(chkColAry, ichkCol, iRange, wordsSelAry);

    var id="#calv"+ichkCol;
    $(id).text(itot);    
  }



}