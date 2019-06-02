<?php

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include("../../../_uti/Uti.php");
?>
<!DOCTYPE html>

<html>

<head>
<title>Work</title>
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

</style>




<script type="text/javascript"> 

    $(document).ready(function(){    
  
    
    });///////////////////////////////$(document).ready(function(){    

    </script>

</head>

<body>



<?php


function showExplorePage(){

	$file0="";
	if( isset($_GET["file0"]) && strlen($_GET["file0"])>0 && file_exists($_GET["file0"])){
		$file0 = $_GET["file0"];
	}
	$file2="";
	if( isset($_GET["file2"]) && strlen($_GET["file2"])>0 ){
		$file2 = $_GET["file2"];
	}
	
	echo "$file0<br/>is renamed to:<br/>\n";
	echo "$file2<hr/>\n";


	//$cmd = "mv -v $file $file2";
	//echo $cmd . "<br/>";
	//echo system($cmd);
	$ret = rename($file0, $file2);
	$dbgstr="\n rename:" . $file0 . "\n    to:" . $file2. "\n    ret="  . $ret ;
	file_put_contents("../log.txt", $dbgstr,  FILE_APPEND);
	if(true === $ret){
		echo "<span style='background-color:#00ff00;'>OK Success.</span><br/>";
	}
	else{
		echo "<span style='background-color:#ff0000;'>...rename ERROR : $file2 </span> <br>";
	}

	echo "<hr/>";

}






showExplorePage();



?>



</body>

</html>