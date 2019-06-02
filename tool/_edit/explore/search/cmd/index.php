<?php

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//include_once("../../_uti/Uti.php");
//include("SearchUti.php");
?>
<!DOCTYPE html>

<html>

<head>
<title>Search</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../sample.css" />
<script type="text/javascript" src="../../../adapters/jquery.js">    </script>

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

#dir,#filesFilter,#searchstr,#replacestr {
	size: 80;
	width: 520px;
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
    	$("#op").val( $(this).text() );
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
    	var dirname = $("#dirName").html();        
        var filesFilter = $("#filesFilter").val();
        var searchstr = $("#searchstr").val();
        var replacestr = $("#replacestr").val();
        if(searchstr.length===0){
            return alert("search strn is empty");
        }
        if(replacestr.length===0){
            return alert("replace string is empty");
        }
        if( false === confirm("Replace: "+searchstr+"\nwith strn: "+replacestr + "\n\nAre you sure?") ){
            return
        };
    	//window.open("./index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr+"&replacestr="+replacestr, "_blank");
    	$("#op").val( $(this).text() );
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
        $("#op").val( $(this).attr("id") );
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
        //if( false === confirm("Replace: "+searchstr+"\nwith strn: "+replacestr + "\n\nAre you sure?") ){
        //    return
       // };
       var url="./fileSys/index.php?dir="+dirname+"&filesFilter="+filesFilter+"&searchstr="+searchstr+"&replacestr="+replacestr;
       url +="&AutoAll=true";
    	window.open(url, "_blank"); 
    });////

    
    

    $("#helpcmd").click(function(){   
    	$("#cmd").val( $(this).val() );             
    });////

    $("#go").click(function(){   
    	var cmd=$("#cmd").val();
    	//if(!confirm(cmd))return;
    	//alert(cmd);    
    	$.ajax({
    		type: "POST",
    		url: "run_cmd.php",
    		data: { cmd: cmd, location: "Boston" }
    		})
    		.done(function( msg ) {
    			//alert( "amd return: " + msg );
    			$("#output").val(msg);
    		});   
    });////
    
    });///////////////////////////////$(document).ready(function(){    

    </script>

</head>

<body style='background-color: #ffddee'>
<input id='cmd' style="width:100%;"></input><br>
<button id='go'>go</button>
<select id='helpcmd'>
<option/>
<option>ls  /var/www/lamp/wroot  -al<option>
<option>find /var/www/lamp/wroot -name *any*.* <option>

</select><hr/>
<textarea id='output'></textarea>


<?php
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

	$hrs_file="/publish/";
	if( isset($_GET["hrs_file"]) && strlen($_GET["hrs_file"])>0 ){
		$hrs_file = $_GET["hrs_file"];
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

	$filesys_search = "<td><a id='FileSysSearch' >FileSysName</a></td>";
	$filesys_modify = "<td>FileSysRename<a id='FileSysModify' >[Manual]</a><a id='FileSysModifyAutoAll' >[Auto]</a></td>";

	$Href_Src_Check = "<td><a id='Href_Src_Check'> check (href, src)</a></td>";

	$Href_checkbox = "<input type='checkbox' id='Href_verify_url' name='Href_verify_url' $Href_Checkbox_verify_url> verify url</a>";
	$Src_checkbox  = "<input type='checkbox' id='Src_change_file' name='Src_change_file' $Src_Checkbox_change_file>Change file</a>";

	print_r ($_GET);
	echo "<form id='tblform' method='GET' action='index.php'>";
	echo "<table border='1'>";
	echo "<tr><td>dir</td><td><input id='dir' name='dir' value='$dir/'></input></td><td><input type='checkbox' id='cfgPublish' name='cfgPublish' $cfgPublish_checked>cfg.publish</input><input id='op' name='op' readonly='1' value='$op'></td></tr>";
	echo "<tr><td><a id='filesFilterCtr'>filesFilter</a> </td><td><input id='filesFilter' name='filesFilter' value='$filesFilter'></input></td><td>($filterSamples)</td></tr>";
	echo "</table>";
	echo "<table border='1'>";
	echo "<tr><td>Search<a id='SearchStrCtr'>[StrInFiles]</a></td>$filesys_search<td><input id='searchstr' name='searchstr' value='$searchstr'></input></td></tr>";
	echo "<tr  style='background-color:#aaaaaa;'><td id='ReplaceStrCtr'>ReplaceStr</td>$filesys_modify<td><input id='replacestr' name='replacestr' value='$replacestr'></input></td></tr>";
	echo "</table>";
	echo "<table border='1'>";
	echo "<tr  style='background-color:#aaaaaa;'>$Href_Src_Check<td>$Src_checkbox</td><td>$Href_checkbox</td>";
	echo "<td>file:<input id='hrs_file' name='hrs_file' value='$hrs_file'>";
	echo "ext:<input id='hrs_ext' name='hrs_ext' value='$hrs_ext'></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>\n";
	echo "<hr/>\n";



	SearchPathFilesFilters::getFiles($files, $cfgPublish, $dir, $filesFilter);


	switch( $op ){
		case "filesFilter":
			$op = new FileFitler($filesFilter);
			$op->run($files);
			break;
		case "SearchStr":
			$op = new SearchStr($filesFilter,$searchstr);
			$op->run($files);
			break;
		case "ReplaceStr":
			$op = new ReplaceStr($filesFilter,$searchstr, $replacestr);
			$op->run($files);
			break;
		case "FileSysSearch":
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

//showExplorePage();



?>



</body>

</html>
