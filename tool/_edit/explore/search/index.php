<?php

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("../../_uti/Uti.php");
include("SearchUti.php");
?>
<!DOCTYPE html>

<html>

<head>
<title>Search</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="sample.css" />
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

#dir,#filesFilter,#searchstr,#replacestr,#include_paths .wdir{
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
background-color:#ff0000;
}
.fcontents{
    display: none;
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
    
    $("#dupFinder").click(function(){
        dupFinder();
    });
    
    });///////////////////////////////$(document).ready(function(){    

function dupFinder(){
    var UniqBnameArr=[];
    var UniqFullpathArr=[];
    
    var DupBnameArr=[];
    var DupStatsArr=[];
    $(".typefile").each(function(){
        var txt=$(this).text();
        var i=txt.lastIndexOf("/");
        var bname=txt.substring(i);        
        var idxUniqFind=UniqBnameArr.indexOf(bname);
        if( idxUniqFind>=0){
            var idxDupFind=DupBnameArr.indexOf(bname);
            if( idxDupFind<0){
                var fullpath=UniqFullpathArr[idxUniqFind];                
                var fullnameArr=[];
                fullnameArr.push(txt);                
                fullnameArr.push(fullpath);    
                var obj={fullnameArr:fullnameArr};
                DupStatsArr.push(obj);
                DupBnameArr.push(bname);
            }
            else{
                DupStatsArr[idxDupFind].fullnameArr.push(txt);                           
            }          
            $(this).css("background-color","#ffff00");
        }
        else{
            UniqBnameArr.push(bname);
            UniqFullpathArr.push(txt);
        }
        //console.log(bname);
    });
    
    var totalfiles=0;
    var tabs="<table border='1'>";
    for(var i=0;i<DupStatsArr.length;i++){
        var fullnameArr=DupStatsArr[i].fullnameArr;
        var dupname=DupBnameArr[i];        
        //var lnk="<a href=''
        var fnames="";
        for(var k=0;k<fullnameArr.length;k++){
            var fname=fullnameArr[k];
            var url=getUrlOfFulpathfilename(fname);            
            var lnk="<a onclick=\"window.open('"+url+"');\" style='background-color:#dddd22;'>"+dupname+"</a>";            
            var sss=fname.replace(dupname,lnk);
            fnames+=sss+"<br/>";
            totalfiles++;
        }
        tabs+="<tr><td>"+i+"</td><td>"+fnames+"</td></tr>";
    };
    tabs+="</table>";
    var msg="Total duplicated items:"+DupBnameArr.length + "\n<br>\nTotal files in duplicated:"+totalfiles;
    var MaxReduction=(totalfiles-DupBnameArr.length);
    msg+="\n<br>\nMax Reduction:"+ MaxReduction;
    tabs+=msg;
    //console.log(tabs);
    $("#out").html(tabs)[0].scrollIntoView();

    alert(msg);  
}

function getUrlOfFulpathfilename(fullpathname){
    var origin=window.location.origin;
    var pathname=window.location.pathname;
    var pathArr=pathname.split("/");
    if(pathArr.length>2){
        var sfind="/"+pathArr[1]+"/";
        var indx=fullpathname.indexOf(sfind);
        if(indx>0){
            var pn=fullpathname.substring(indx);
            var url=origin+pn;
            return url;
        }
    }
    return "no url";
}
    </script>

</head>

<body style='background-color: #ffddee'>
<a href='cmd/'>cmd</a>


<?php
function load_inlude_paths(){
    $lines=file("include_paths.txt");
    $ret="";
    foreach($lines as $line){
        $line = trim($line);
        if( isset($line[0]) && "#"===$line[0]) continue;
        $ret .=":" . $line;
    }
    return ltrim($ret, ":");
}
function showExplorePage(){

    $dir=getcwd();
    if( isset($_GET["dir"]) && strlen($_GET["dir"])>0 && file_exists($_GET["dir"])){
        $dir = $_GET["dir"];
    }
    $dir=realpath($dir);

    //$ttt=new Search_Files($dir);
    //echo count($ttt->files) . "<hr/>";
    //$ttt->show();
    //echo "<hr/>".count($ttt->files);
    //return;
    $cfgPublish="";
    if( isset($_GET["cfgPublish"]) && strlen($_GET["cfgPublish"])>0 ){
        $cfgPublish = $_GET["cfgPublish"];
    }
    $cfgPublish_checked="";
    if("on"===$cfgPublish){
        $cfgPublish_checked="checked='1'";
    }

    $Src_change_file="";
    if( isset($_GET["Src_change_file"]) && strlen($_GET["Src_change_file"])>0 ){
        $Src_change_file = $_GET["Src_change_file"];
    }
    $Src_Checkbox_change_file="";
    if("on"===$Src_change_file){
        $Src_Checkbox_change_file="checked='1'";
    }

    $Href_verify_url="";
    if( isset($_GET["Href_verify_url"]) && strlen($_GET["Href_verify_url"])>0 ){
        $Href_verify_url = $_GET["Href_verify_url"];
    }
    $Href_Checkbox_verify_url="";
    if("on"===$Href_verify_url){
        $Href_Checkbox_verify_url="checked='1'";
    }



    $filesFilter="";
    if( isset($_GET["filesFilter"]) && strlen($_GET["filesFilter"])>0 ){
        $filesFilter = $_GET["filesFilter"];
    }

    $include_paths=load_inlude_paths();//$dir;
    if( isset($_GET["include_paths"]) && strlen($_GET["include_paths"])>0 ){
        //$include_paths = $_GET["include_paths"];
    }

    $hrs_ext=".htm;.html";
    if( isset($_GET["hrs_ext"]) && strlen($_GET["hrs_ext"])>0 ){
        $hrs_ext = $_GET["hrs_ext"];
    }

    $searchstr="";
    if( isset($_GET["searchstr"]) && strlen($_GET["searchstr"])>0 ){
        $searchstr = $_GET["searchstr"];
    }

    $replacestr="";
    if( isset($_GET["replacestr"]) && strlen($_GET["replacestr"])>0 ){
        $replacestr = $_GET["replacestr"];
    }

    $op="filesFilter";
    if( isset($_GET["op"])) {
        $op=$_GET["op"];
    }

    //$filterSamples  ="<td>";
    $filterSamples  ="<a id='Example'>Eg.</a> <a class='FiltersSample'>.htm;</a><a class='FiltersSample'>.html;</a>";
    $filterSamples .="<a class='FiltersSample'>.css;</a><a class='FiltersSample'>.php;</a>";
    $filterSamples .="<a class='FiltersSample'>.js;</a><a class='FiltersSample'>.xml;</a>";
    //$filterSamples .="</td>";

    $filesys_search = "<td><button id='SearchStrCtr'>FileContents</button> <button id='FileSysSearch' >FileNames</button></td>";
    $filesys_modify = "<td><button id='ReplaceStrCtr'>FileContents</button> <button id='FileSysModify' >FileNames(Preview)</button><button id='FileSysModifyAutoAll' >(Auto)</button></td>";

    $Href_Src_Check = "<td><button id='Href_Src_Check'> check (href, src)</button></td>";

    $Href_checkbox = "<input type='checkbox' id='Href_verify_url' name='Href_verify_url' $Href_Checkbox_verify_url> verify url</a>";
    $Src_checkbox  = "<input type='checkbox' id='Src_change_file' name='Src_change_file' $Src_Checkbox_change_file>Change file</a>";

    print_r ($_GET);
    echo "<form id='tblform' method='GET' action='index.php'>";
    echo "<table border='1' width='100%'>";
    echo "<tr><td>work dir</td><td><input id='dir' name='dir' value='$dir/'></input></td><td><input type='checkbox' id='cfgPublish' name='cfgPublish' $cfgPublish_checked>cfg.publish</input><input id='op' name='op' readonly='1' value='$op'></td></tr>";
    echo "<tr><td><button id='filesFilterCtr'>list files(filted)</button> <a id='dupFinder' title='find dup base names.'>dupFinder</a> </td><td><input id='filesFilter' name='filesFilter' value='$filesFilter'></input></td><td>($filterSamples)</td></tr>";
    echo "</table>";
    echo "<table border='1'  width='100%'>";
    echo "<tr><td>SearchStrIn</td>$filesys_search<td><input id='searchstr' name='searchstr' value='$searchstr'></input><a id='copy2repl' title='copy down'>v</a></td></tr>";
    echo "<tr  style='background-color:#aaaaaa;'><td>ReplaceStrIn</td>$filesys_modify<td><input id='replacestr' name='replacestr' value='$replacestr'></input><a id='exchange' title='exchange value'>~</a></td></tr>";
    echo "</table>";
    echo "<table border='1'  width='100%'>";
    echo "<tr  style='background-color:#aaaaaa;'>$Href_Src_Check<td>$Src_checkbox</td><td>$Href_checkbox</td>";
    echo "<td>include_path:<input id='include_paths' name='include_paths' value='$include_paths'>";
    echo "ext:<input id='hrs_ext' name='hrs_ext' value='$hrs_ext'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>\n";
    echo "<hr/>\n";



    //SearchPathFilesFilters::getFiles($files, $cfgPublish, $dir, $filesFilter);
    $pf=new PathFiles($dir,$filesFilter);
    $files=$pf->files;


    switch( $op ){
        case "filesFilter"://fileslister
            $op = new FileFitler($filesFilter);
            $op->run($files);
            break;
        case "SearchStr"://search str in contents
            $op = new SearchStr($filesFilter,$searchstr);
            $op->run($files);
            break;
        case "ReplaceStrCtr"://replace str in contents
            $op = new ReplaceStr($filesFilter,$searchstr, $replacestr);
            $op->run($files);
            break;
        case "FileSysSearch"://search str in files name
            $searchstr=trim($searchstr,"/");
            $op = new SearchFileSys( $filesFilter, $searchstr, "");
            $op->run($files);
            break;
        default:
            echo "default $op";
            break;
    }

    echo "<hr/>\n";
    echo "<hr/>\n";
    return;
}




//$ret = glob("/usr/share/apache2/htdocs/*");
//foreach($ret as $f){
//echo "$f<br/>";
//}

//echo count($ret) . "<br/>";

showExplorePage();



?>


<hr/>
<div id='out'>outputdata</div>

<hr/>
end
</body>

</html>
