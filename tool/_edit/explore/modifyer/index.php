<?php

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("../../_uti/Uti.php");

?>
<!DOCTYPE html>

<html>

<head>
<title>Modifyer</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<META name="viewport" content="width=device-witdh, initial-scale=1, maximum-scale=1, user-scale=0"> 
<script type="text/javascript" src="../../adapters/jquery.js">    </script>

<style type="text/css">
html,body {
    height: 100%;
    width: 100%;
    margin: 0px;
    padding: 0px 0px 0px 3px; //
    overflow: hidden;
}

span.op {
    position: absolute;
    top: 0px;
    right: 0%;
    margin-left: -250px;
}

a.path { //
    background-color: #dddd00;
    margin: 0px;
    padding: 0px 10px 0px 10px;
}

a.create_Dir { //
    background-color: #aaaaaa;
    margin: 0px;
    padding: 0px 10px 0px 10px;
}

a.create_File {
    margin: 0px;
    padding: 0px 10px 0px 10px;
}

#dir,#filesFilter{
    size: 100%;
    width: 100%;
}

#searchstr,#replacestr,#include_paths .wdir{
    size: 80;
    width: 520px;
}
.typefolder{
background-color:#ffff00;
}
.typefile{
background-color:#00ffff;
}

.Precaution{
background-color:#ff00ff;
}
.fcontents{
    display: none;
}

#editors, a.savebtn{
    display:none;
}

</style>




<script type="text/javascript"> 

    $(document).ready(function(){ 

    $("#Example").click(function(){         
        $("#filesFilter").val("");          
    });////   

    $.each(".FiltersSample",function(i){
        //alert( $(this).html() );
        var colr= "#ff"+i+""+i+""+i+""+i;
        $(this).css("background-color","#ff0000");
    });     

    $(".FiltersSample").click(function(){           
        var sval = $(this).html();
        var filesFilter = $("#filesFilter").val();
        if(filesFilter.length > 0){
            var idx = filesFilter.indexOf(sval);
            if(idx<0){
                filesFilter += sval;
            }
        }
        else{
            filesFilter=sval;
        }
        $("#filesFilter").val(filesFilter);
        
    });////
    
    $("#filesFilterCtr").click(function(){     
        var dirname = $("#dirName").html();        
        var filesFilter = $("#filesFilter").val();
        var url = "./index.php?dir="+dirname+"&filesFilter="+filesFilter;
        //location.href=url;
        //window.open(url, "_blank"); 
        $("#op").val( "filesFilter" );
        $("#tblform").submit();
    });///// 

    
    
    $("#SearchStrCtr").click(function(){   
        
        var dirname = $("#dirName").html();        
        var filesFilter = $("#filesFilter").val();
        var searchstr = $("#searchstr").val();
        //alert(searchstr);
        var url = "./index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr;
        //location.href=url;
        //window.open(url, ", "_blank"); 
        $("#op").val( "SearchStr" );
        $("#tblform").submit();
        return;
    });////

    

    $("#ReplaceStrCtr").click(function(){   
        var dirname = $("#dirName").text();        
        var filesFilter = $("#filesFilter").val();
        var searchstr = $("#searchstr").val();
        var replacestr = $("#replacestr").val();
        if(searchstr.length===0){
            return alert("search strn is empty");
        }
        if(replacestr.length===0){
            return alert("replace string is empty");
        }
        if( false === confirm("Contents change: \n"+searchstr+"\n"+replacestr + "\n\nAre you sure?") ){
            return
        };
        //window.open("./index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr+"&replacestr="+replacestr, "_blank");
        $("#op").val( "ReplaceStrCtr" );
        $("#tblform").submit(); 
    });////


    $("#FileSysSearch").click(function(){   
        var dirname = $("#dir").val();        
        var filesFilter = $("#filesFilter").val();
        var searchstr = $("#searchstr").val();
        var replacestr = $("#replacestr").val();
        if(searchstr.length===0){
            return alert("search strn is empty");
        }
        $("#op").val( "FileSysSearch" );
        $("#tblform").submit(); 
        //window.open("./fileSys/index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr, "_blank"); 
    });////

    $("#FileSysModify").click(function(){   
        var dirname = $("#dir").val();        
        var filesFilter = $("#filesFilter").val();
        var searchstr = $("#searchstr").val();
        var replacestr = $("#replacestr").val();
        if(searchstr.length===0){
            return alert("search strn is empty");
        }
        if(replacestr.length===0){
            return alert("replace string is empty");
        }
        //if( false === confirm("Replace: "+searchstr+"\nwith strn: "+replacestr + "\n\nAre you sure?") ){
        //    return
       // };
        window.open("./fileSys/index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr+"&replacestr="+replacestr, "_blank"); 
    });////
    $("#FileSysModifyAutoAll").click(function(){   
        var dirname = $("#dir").val();        
        var filesFilter = $("#filesFilter").val();
        var searchstr = $("#searchstr").val();
        var replacestr = $("#replacestr").val();
        if(searchstr.length===0){
            return alert("search strn is empty");
        }
        if(replacestr.length===0){
            return alert("replace string is empty");
        }
        if( false === confirm("File name change: \n"+searchstr+"\n"+replacestr + "\n\nAre you sure?") ){
            return
       };
       var url="./fileSys/index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr+"&replacestr="+replacestr;
       url +="&AutoAll=true";
        window.open(url, "_blank"); 
    });////

    
    

    $("#Href_Src_Check").click(function(){   
        var dirname = $("#dir").val();        
        var filesFilter = $("#filesFilter").val();
        var searchstr = $("#searchstr").val();
        var replacestr = $("#replacestr").val();
        var cfgPublish = $("#cfgPublish").is(':checked') ;
        if(searchstr.length===0){
            //return alert("search strn is empty");
        }
        if(replacestr.length===0){
            //return alert("replace string is empty");
        }
        //if( false === confirm("Replace: "+searchstr+"\nwith strn: "+replacestr + "\n\nAre you sure?") ){
        //    return
       // };
       var url="./fileHrefSrc/index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr+"&replacestr="+replacestr+"&cfgPublish="+cfgPublish;
       url+="&Src_change_file=" + $("#Src_change_file").is(':checked') ;
       url+="&Href_verify_url=" + $("#Href_verify_url").is(':checked') ;
       url+="&include_paths=" + $("#include_paths").val() ;
       url+="&hrs_ext=" + $("#hrs_ext").val() ;
       //return alert(url);
       
        window.open(url, "_blank"); 
    });////
    
    
    $(".typefile").click(function(){
        var tt=$(this).text();
        var ii=1+tt.lastIndexOf("/");
        $("#searchstr").val(tt.substring(ii));
    });
    
    $("#copy2repl").click(function(){
       var ss=$("#searchstr").val(); 
       $("#replacestr").val(ss); 
    });
    
    $("#exchange").click(function(){
       var ss1=$("#searchstr").val(); 
       var ss2=$("#replacestr").val(); 
       $("#searchstr").val(ss2); 
       $("#replacestr").val(ss1); 
    });
    
    
    
    });///////////////////////////////$(document).ready(function(){    

    </script>

</head>

<body style='background-color: #ddddee'>



<?php

function showExplorePage(){
    $dir=getcwd();
    if( isset($_GET["dir"]) && strlen($_GET["dir"])>0 && file_exists($_GET["dir"])){
        $dir = $_GET["dir"];
    }
    $dir=realpath($dir);

    //$filterSamples  ="<td>";
    $filterSamples  ="<a id='Example'>Eg.</a> <a class='FiltersSample'>.htm;</a><a class='FiltersSample'>.html;</a>";
    $filterSamples .="<a class='FiltersSample'>.css;</a><a class='FiltersSample'>.php;</a>";
    $filterSamples .="<a class='FiltersSample'>.js;</a><a class='FiltersSample'>.xml;</a>";
    //$filterSamples .="</td>";    

    print_r ($_GET);
    //echo "<form id='tblform' method='GET' action='index.php'>";
    echo "<table border='1' width='99%'>";
    echo "<tr><td>work dir</td><td width='80%'><input id='dir' name='dir' value='$dir/' ></input></td><td></td></tr>";
    echo "<tr><td><a id='filesFilterCtr'>files filters</a> </td><td><input id='filesFilter' name='filesFilter' value='' ></input></td><td>($filterSamples)</td></tr>";
    echo "</table>";


    //echo "</form>\n";

    return;
}




//$ret = glob("/usr/share/apache2/htdocs/*");
//foreach($ret as $f){
//echo "$f<br/>";
//}

//echo count($ret) . "<br/>";

showExplorePage();



?>




<script type="text/javascript"> 
function svrCreateNew(){
  var dir=$("#dir").val();
  var filesFilter=$("#filesFilter").val();
  console.log(dir+","+filesFilter);
  msg("svrCreateNew");
  $.ajax({
    url: 'svrCreateNew.php',
    type: 'POST',
    data: {dir:dir,filesFilter:filesFilter},
    success: function(data) {
  	  //called when successful
      //JSON.parse(data);
      
  	  $('#out').html(data).show();
      msg("ok");
    },
    error: function(e) {
  	  //called when there is an error
  	  console.log(e.message);
    }
  });    
};
function ajx_save_single_file(url,contents){
  if(!confirm("over write?")) return;
  var dir=$("#dir").val();
  console.log(url+","+contents);
  msg("ajx_save_single_file");
  $.ajax({
    url: url,
    type: 'POST',
    data: {dir:dir,contents:contents,filesFilter :""},
    success: function(data) {
  	  //called when successful
      //JSON.parse(data);
      
  	  //$('#out').html(data);
      msg(data);
    },
    error: function(e) {
  	  //called when there is an error
  	  console.log(e.message);
    }
  });    
};

function Loadfiles(){
    var dir=$("#dir").val();
    var filesFilter = $("#filesFilter").val();
  console.log("Loadfiles");
  msg("Loadfiles");
  $.ajax({
    url: 'svrLoad2Table.php',
    type: 'POST',
    data: {dir:dir,contents:'',filesFilter:filesFilter},
    success: function(data) {
  	  //called when successful
      //JSON.parse(data);
      data=$.trim(data);

      $("#out").html(data).show();
      msg("ok");
      
    },
    error: function(e) {
  	  //called when there is an error
  	  console.log(e.message);
    }
  });    
};




function Col2textarea(_this){
    var idx=$(_this).parent().index();//(".hh").index();
    var ss="td:eq("+idx+")";
    console.log(ss);
    var tta="", OrigArr=[];
    $("td[contenteditable='true']").css("background-color","").removeAttr("contenteditable");
    $("tr.mody_tr").each(function(){   
        var ts=$(this).find(ss).attr("contenteditable","true").css("background-color","#ffffff").text().trim();
        if(ts.length>0){
            tta+=ts+"\n";
            OrigArr.push(ts);
        }
    });
    gmody=new Mody(OrigArr);    
    $("#edittext").val($.trim(tta)).parent().show();//css("display","inline");
}

function clkTH_Edit(_this){
    console.log("clkTH_Edit");
    Col2textarea(_this);
    //$(".modify").css("background-color","#ffffff");
    $(".modify").bind("click",function(){
        console.log("click contenteditable");
        $(this).css("background-color","#ffff00");
    });
    $(_this).next("a").show();
};

function clkTH_Save(_this){
    var tt="";
    $("td[contenteditable='true']").each(function(i){
        $(this).removeAttr("contenteditable").css("background-color","");
        var tss=$(this).text();
        tss=$.trim(tss);
        tt+=tss+"\n";
    });
    $("#edittext").val(tt).parent().hide();
    var url=$(_this).parent().attr("url");
    ajx_save_single_file(url,$.trim(tt));
    $(_this).hide();
};
function preview(bPreview){
    var bSaved=true;
    $(".savebtn").each(function(){
        var visible=$(this).is(":visible");
        if( visible ){            
            $(this).css("background-color","#ff0000");
            bSaved=false;
        }
    });
    if(!bSaved) return alert("Please save date before to preview/change.");
    
    var bModiContents=$("#bModiContents").is(":checked");
    var bRename=$("#bRename").is(":checked");
    console.log(bModiContents+","+bRename);
    if(!bModiContents && bRename){
        if(!confirm("Only Rename files name without changing contents may lose links forever.\n\n\n Continue?")) return;
    }
    
    
    var dir=$("#dir").val(); 
    var filesFilter = $("#filesFilter").val();
    if(filesFilter.length==0 && !confirm("no filesFilter?OK")) return;
    if(false===bPreview){
        if( !confirm("Make Changes?") ){
            return;
        }
    }
    
    $('#preview_area').html("");
    $("body").css("cursor","wait");
    $.ajax({
      url: 'svrPreviewModify.php',
      type: 'POST',
      data: {dir:dir,bPreview:bPreview,filesFilter:filesFilter, bModiContents:bModiContents,bRename:bRename},
      success: function(data) {
    	  //called when successful
          //JSON.parse(data);
          $("body").css("cursor","");
          msg("ok");
        
    	  $('#preview_area').html(data);
      },
      error: function(e) {
    	  //called when there is an error
    	  console.log(e.message);
          $("body").css("cursor","");
      }
    });    
};

function togle(_this){
    $(_this).next().slideToggle("slow");
}

    $(document).ready(function(){ 

    $("#ListFiles").click(function(){   
        if(!confirm("overwrite old one?")) return;
        svrCreateNew();
    });////   
    $("#Loadfiles").click(function(){   
        Loadfiles();
    });////  
    

  

    

    
    $("#preview").click(function(){   
        msg("preview start...");
        preview(true);
    });////
    $("#MakeChanges").click(function(){  
        msg("Make Real Changes Start...");
        preview(false);
    });////
    
    $("#finishedit").click(function(){
        var tt=$("#edittext").val();
        var arr=tt.split("\n");
        $("td[contenteditable='true']").each(function(i){
            var ta=arr[i];
            $(this).find("a").text(ta);
        });
        $(this).parent().hide();       
    });
    
    $("#toggletablebar").click(function(){
        $("#out").toggle();
    });
    
    $("#sortLines").click(function(){
        var tt=$("#edittext").val();
        var arr=tt.split("\n");
        var modiArr=[],modiSortedArr=[];
        for(var i=0;i<arr.length;i++) {
            var ln=$.trim(arr[i]);
            if(ln.length===0) continue;
            modiArr[i]=ln;
            modiSortedArr[i]=ln;
        }
        var modiSortedArr=modiSortedArr.sort();
        gmody.addOp(modiArr,modiSortedArr);
        var lines="sorted:<br>";
        var lines2="";
        for(var i=0;i<modiSortedArr.length;i++){
            var ln=$.trim(modiSortedArr[i]);
            lines+=ln+"<br>";            
            lines2+=ln+"\n";
        }
        lines+="<hr/>"+gmody.getResults();
        $("#preview_area").html(lines);
        $("#edittext").val(lines2);
    });



  
    
    });///////////////////////////////$(document).ready(function(){    
  
function msg(msg){
    $("#msg").html(msg);
}

var Mody=function(origArr){
    this.OrigArr=[];
    for(var i=0; i<origArr.length;i++){
        this.OrigArr[i]=origArr[i];
    }
    this.FinalModiArr=[];
    this.OpArr=[];
};
Mody.prototype.addOp=function(modiArr, modiSorted){
    var i=this.uniqCheck( modiArr );
    if(i>=0) return alert("Unique check failed:\n"+modiArr[i]);

    var obj={modiArr:[],sortedArr:[]};
    for(var i=0;i<modiArr.length;i++) {
        obj.modiArr[i]=modiArr[i];
        obj.sortedArr[i]=modiSorted[i];
    }
    this.OpArr.push(obj);    
    this.genFinalModi();
};
Mody.prototype.uniqCheck=function(modiArr){
    var uniqArr=[];
    for(var i=0;i<modiArr.length;i++) {
        if(uniqArr.indexOf(modiArr[i])>=0){
            return i;
        };
        uniqArr.push(modiArr[i]);
    }
    return -1;
};
Mody.prototype.genFinalModi=function(){
    for(var i=0;i<this.OrigArr.length;i++) {
        var modiIndx=i;
        var modiName="";
        for(var j=0;j<this.OpArr.length;j++) {
            var obj=this.OpArr[j];
            modiName=obj.modiArr[modiIndx];
            modiIndx=obj.sortedArr.indexOf(modiName);
        } 
        this.FinalModiArr[i]=modiName;       
    }   
};
Mody.prototype.getResults=function(){
    var ss='',sfinalmodi="",cmp="",orig="";
    for(var i=0;i<this.OrigArr.length;i++) {
        var origName=this.OrigArr[i];
        var modiName=this.FinalModiArr[i];  
        var modiName2=modiName;
        var origName2=origName;
        
        if(origName!=modiName){
            modiName2="<font color='red'>"+modiName+"</font>";
            origName2="<font color='blue'>"+origName+"</font>";
        }        
        cmp+=origName2+"<br>"+modiName2+"<br/><br/>";
        orig+=origName2+"<br>";
        sfinalmodi+=modiName2+"<br/>";
    }  
    ss="<hr/>orig:<br/>"+orig+"<hr/>sfinalmodi<br>"+sfinalmodi+"<hr>compare original with final:<br>"+cmp+"<hr/>";
    return ss;    
};
var gmody=new Mody([]);  

    </script>
<button id="ListFiles">CreateNew</button><button id="Loadfiles">Load</button>
<input type='checkbox' id='bModiContents' checked='1'>bModiContents</input><input type='checkbox' id='bRename' checked='1'>bRename</input>
<button id="preview">Preview</button><button id="MakeChanges">MakeChanges</button>


<a id="msg"></a><a id="msg"></a>
<hr id='toggletablebar' title='toggle table bar'/>
<a id="out"></a>

<div id='editors'>
<textarea id="edittext" rows="10" style="width:98%"></textarea>
<button id="finishedit">Finish edit and Close out</button>
<button id="sortLines">sort lines</button>

</div>


<div id="preview_area" style="width:100%"></div>
<p/>


</body>

</html>
