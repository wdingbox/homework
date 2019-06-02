
function JesusWordsInRed_BibleObj(vol){
   var BibleObj={};
   BibleObj[vol]={};
   $("#tab table tbody").find("tr").each(function(){
      var etr=$(this).find("td:eq(1)");
      var cv=etr.find("b").text().trim();

      var htm=etr.html().trim();
      
      var mat=cv.match(/^(\d+)\:(\d+)$/);
      if(!mat){
          console.log(cv, htm);
          return;
      };
      if(null===mat || mat.length<2){
         console.log("mat=",mat);
         console.log("cv=",cv,"htm=",htm);
         return;
      }
      var chp=mat[1];
      var vrs=mat[2];
      if(undefined === BibleObj[vol][chp]){
         BibleObj[vol][chp]={};
      }

      etr.find("b").remove();
      htm=etr.html().trim();
      
      BibleObj[vol][chp][vrs]=htm;

      $("#JesusSaying").val(JSON.stringify(BibleObj,null,4));

   })
}