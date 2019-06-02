<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Work</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="sample.css" />	
	<script type="text/javascript" src="../adapters/jquery.js">    </script>  	
	<script type="text/javascript" src="index.js">    </script>     
	<script type="text/javascript">	
	$(document).ready(function(){				
	$("#file").click(function(){		});/////$("#file").click(function(){			    
	});///////////////////////////////$(document).ready(function(){    
	</script>
</head>
<body>

<?php
//print_r ($_GET);
///www/99k.org/p/l/a/plastron777/htdocs/e/ckeditor/_dw/z/aaaaa.htm 
$THISFILE = basename(__FILE__);

$dir = getcwd();
if( isset($_GET) && strlen($_GET["dir"])>0 && file_exists($_GET["dir"])){
	$dir = $_GET["dir"];
}

$txtPath="";
$txtFile="";
chdir( $dir ); //must change to dir to scan.
echo "<a class='create' href='WorkCreateDirFtp.php?dir=$dir'>CreateDir</a><br>\n";
echo "<a class='path' href='$THISFILE?dir=". dirname($dir) . "'>[ .. ]</a>\n";
$idx=0;
foreach ( scandir( $dir, $SCANDIR_SORT_DESCENDING) as $i => $entry ) {        
    $fullpath = realpath( $entry );
	$locFile = basename($dir) . "/" . $entry;
	if ( $entry == "."  || $entry == "..") {continue;}
	if ( is_dir($entry) ){
		$txtPath .= "<br><a class='path' href='$THISFILE?dir=$fullpath'>[+] $entry</a>\n";		
	}
	else{
		$idx+=1;		
		$txtFile .= "<br><a class='view' href='$locFile'>$idx</a>. <a class='file' href='Work.htm?filename=$fullpath'>$entry</a>\n";		
	}    
}
echo $txtPath . $txtFile ;
?>

</body>
</html>
