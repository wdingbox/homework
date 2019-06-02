<?php

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("../../../_uti/Uti.php");
include_once("../SearchUti.php");
?>
<!DOCTYPE html>

<html>

<head>
<title>FileSys</title>
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

    });///////////////////////////////$(document).ready(function(){    

    </script>

</head>

<body>



<?php


function showExplorePage(){
	$cfgPublish="";
	if( isset($_GET["cfgPublish"]) && strlen($_GET["cfgPublish"])>0 ){
		$cfgPublish = $_GET["cfgPublish"];
	}
	$cfgPublish_checked="";
	if("on"===$cfgPublish){
		$cfgPublish_checked="checked='1'";
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

	$AutoAll="";
	if( isset($_GET["AutoAll"]) && strlen($_GET["AutoAll"])>0 ){
		$AutoAll = $_GET["AutoAll"];
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

	SearchPathFilesFilters::getFiles($files, $cfgPublish, $dir, $filesFilter);
	$op = new SearchFileSys( $filesFilter, $searchstr, $replacestr);
	$op->AutoRenameAll= $AutoAll;
	$op->run($files);

	echo "<hr/>";
	return;
}






showExplorePage();



?>



</body>

</html>
