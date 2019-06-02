<?php

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("../../../_uti/Uti.php");
include_once("../SearchUti.php");
//include_once("../HtmSrcHref.php");
?>
<!DOCTYPE html>

<html>

<head>
<title>href/src check</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="sample.css" />
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

#filesFilter,#searchstr,#replacestr {
	size: 80;
	width: 520px;
}
</style>




<script type="text/javascript"> 

    $(document).ready(function(){                   

    	$(".editfilename").click(function(){
        	var fullpathfilename=$(this).html();
        	//alert(fullpathfilename);
        	window.open("../../Work.htm?filename="+fullpathfilename, "_blank");        	
    	});

    	$(".relativePath2absPath").click(function(){
        	var fullpathfilename=$(this).attr("title");
        	//alert(fullpathfilename);
        	window.open("../../Work.htm?filename="+fullpathfilename, "_blank");        	
    	});

    	$(".fullpathfile2url").click(function(){
        	var fullpathfilename=$(this).attr("title");
        	//alert(fullpathfilename);
        	window.open(fullpathfilename, "_blank");        	
    	});

    	
    });///////////////////////////////$(document).ready(function(){    

    </script>

</head>

<body>



<?php


function showExplorePage(){
	print_r($_GET);
	//return;
	$cfgPublish="";
	if( isset($_GET["cfgPublish"]) && strlen($_GET["cfgPublish"])>0 ){
		$cfgPublish = $_GET["cfgPublish"];
	}

	$Src_change_file="false";
	if( isset($_GET["Src_change_file"]) && strlen($_GET["Src_change_file"])>0 ){
		$Src_change_file = $_GET["Src_change_file"];
	}


	$Href_verify_url="false";
	if( isset($_GET["Href_verify_url"]) && strlen($_GET["Href_verify_url"])>0 ){
		$Href_verify_url = $_GET["Href_verify_url"];
	}
	$Href_Checkbox_verify_url="";
	if( true===$Href_verify_url){
		$Href_Checkbox_verify_url="checked='1'";
	}

	$dir=getcwd();
	if( isset($_GET["dir"]) && strlen($_GET["dir"])>0 && file_exists($_GET["dir"])){
		$dir = $_GET["dir"];
	}
	$dir=realpath($dir);

	$filesFilter="";
	if( isset($_GET["filesFilter"]) && strlen($_GET["filesFilter"])>0 ){
		$filesFilter = $_GET["filesFilter"];
	}

	$searchstr="";
	if( isset($_GET["searchstr"]) && strlen($_GET["searchstr"])>0 ){
		$searchstr = $_GET["searchstr"];
	}
	$searchstr = trim($searchstr, "/");

	$replacestr="";
	if( isset($_GET["replacestr"]) && strlen($_GET["replacestr"])>0 ){
		$replacestr = $_GET["replacestr"];
	}
	$replacestr = trim($replacestr, "/");


	$include_paths="/publish/";
	if( isset($_GET["include_paths"]) && strlen($_GET["include_paths"])>0 ){
		$include_paths = $_GET["include_paths"];
	}
	$hrs_ext=".htm;.html";
	if( isset($_GET["hrs_ext"]) && strlen($_GET["hrs_ext"])>0 ){
		$hrs_ext = $_GET["hrs_ext"];
	}


	$filterSamples  ="<td>";
	$filterSamples .="Eg. <a class='FiltersSample'>.htm</a>;<a class='FiltersSample'>.html</a>;";
	$filterSamples .="<a class='FiltersSample'>.css</a>;<a class='FiltersSample'>.php</a>;";
	$filterSamples .="<a class='FiltersSample'>.js</a>;<a class='FiltersSample'>.xml</a>";
	$filterSamples .="</td>";

	$filesys_search = "<td><a id='FileSysSearch' >FileSysSearch</a></td>";
	$filesys_modify = "<td><a id='FileSysModify' >FileSysModify</a></td>";
	//$filesys_modify = "<a id='FileSysModify'>FileSysModify</a>";

	echo "<table border='1'>";
	echo "<tr><td>dir</td><td id='dirName'>$dir/</td><td></td></tr>";
	echo "<tr><td id='filesFilterCtr'>filesFilter</td><td><a id='filesFilter'>$filesFilter</a></td>$filterSamples</tr>";
	echo "<tr><td id='SearchStrCtr'>SearchStr</td><td><a id='searchstr' >$searchstr</a></td>$filesys_search</tr>";
	echo "<tr><td id='ReplaceStrCtr'>ReplaceStr</td><td><a id='replacestr' >$replacestr</a>$filesys_modify</td></tr>";
	echo "</table>";
	echo "\n";
	echo "<hr/>\n";

	//$op = new SearchFileSys($dir, $filesFilter, $searchstr, $replacestr);
	//$op->run();
	SearchPathFilesFilters::getFiles($files, $cfgPublish, $dir, $filesFilter);

	$t=new SearchHtm_src_href($filesFilter, $include_paths, $Src_change_file, $Href_verify_url);
	$t->hrs_ext = $hrs_ext;
	$t->run($files);

	echo "<hr/>total files checked:". $t->tot_files ;
	echo "<hr/>";
	echo "<hr/>";





	echo "<hr/>";

}






showExplorePage();



?>



</body>

</html>
