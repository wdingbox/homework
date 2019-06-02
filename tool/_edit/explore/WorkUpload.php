<?php
// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

date_default_timezone_set('America/New_York');
$today = date("Ymd_His");


$fname=$_REQUEST["fname"];

$bakfile = dirname(__FILE__) ;
$bakfile = str_replace("/explore", "_save_history/", $bakfile);
echo $bakfile;
mkdir($bakfile);
$bakfile = $bakfile .  basename($fname) . "." . $today . "_" . filesize($fname) . "B";


if( copy($fname,$bakfile) ) {//bakup before save
	echo "\n<br><h3 style='color: green;'>OK copy: <a href='$bakfile'>$bakfile</a></h3>\n\n";
}
else {
	die( "<br><h3 style='color: red;'>Failed backup: $bakfile</h3>\n" );
}

$txt = $_REQUEST["editor1"];//convert commentized of php scripts in ckeditor\ckeditor.js back to php scripts.
$txt = ltrim($txt);
$txt = ltrim($txt, " \x00..\x1F");

$fsize = strlen($txt);
$MAXFILESIZE = 500000;
if($fsize>$MAXFILESIZE){
	echo ("\n\n<br><br><font color='red'>************* WARN: file size ($fsize) exceed the limits of $MAXFILESIZE.</font><br><br>\n\n\n");
}
echo "<h3>($fsize B) </h3>";

if( file_put_contents($fname, $txt) ) {
	//if(fwrite($out, $txt) !== false ){
	echo "<h3 style='color: green;'>($fsize) Data is successfully saved in: <a href='$fname'>$fname </a>(refresh)</h3>";
}
else {
	die( "<h3 style='color: red;'>Failed save: $fname</h3><br>\n");
}


foreach ( $_REQUEST as $sForm => $value )
{
	if ( get_magic_quotes_gpc() ){
		$postedValue = htmlspecialchars( stripslashes( $value ) ) ;
	}
	else{
		$postedValue = htmlspecialchars( $value ) ;
	}

	echo ("<br>\n");
	//echo htmlspecialchars($sForm);
	//echo ("::\n");
	//echo $postedValue;
}//for

?>

