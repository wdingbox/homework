<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<title>SaveFile</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<link type="text/css" rel="stylesheet" href="sample.css" />

</head>

<body>
	<h1 class="samples">
		Create Dir
	</h1> 


<?php

$dir="";
if ( isset( $_GET ) ){

	$dir = $_GET["dir"] ;			// 4.1.0 or later, use $_POST
}
echo "<h1>" . $dir . "</h1><br>" ;

if(strlen($dir)==0) {
	echo "no dir name" ;
	exit(0);
}
if(file_exists($dir)) {
	echo "dir exists" ;
	exit(0);
}

//  mkdir ( string $pathname [, int $mode = 0777 [, bool $recursive = false [, resource $context ]]] 
if( mkdir($dir, 0777, true) ) {
	// bool chmod ( string $filename , int $mode )
	echo "<font color='green'>created ok.</font>" ;
	if( chmod($dir, 0777) ){
		echo " 0777 " ;
	}
	// bool chown ( string $filename , mixed $user )
	if( chown($dir, 280087) ){
		echo "by user." ;
	}
	
}
else{
	echo "failed to create a directory" ;
}


?>





</body>

</html>

