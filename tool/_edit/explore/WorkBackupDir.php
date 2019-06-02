<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>BackupDir</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="sample.css" />
</head>



<body>

	<h1 class="samples">
		Backup
	</h1> 





<?php



$dir="";
if ( isset( $_GET ) ){
	$dir = $_GET["dir"] ;			// 4.1.0 or later, use $_POST
}
$dir2="";
if ( isset( $_GET ) ){
	$dir2 = $_GET["dir2"] ;			// 4.1.0 or later, use $_POST
}



if(strlen($dir)==0) {
	echo "no dir name" ;
	exit(0);
}

echo "$dir<br/>" ;
if( !file_exists($dir)) {
	echo "$dir does not exists. can not backup." ;
	exit(0);
}

if(file_exists($dir2)) {
	echo "$dir2   (bakup dir)<br/>" ;
}

$cmdstr="cp -rv $dir $dir2";

echo "$cmdstr<br/><br/>";

echo system($cmdstr);


echo "<hr/><br/>";
?>











</body>



</html>



